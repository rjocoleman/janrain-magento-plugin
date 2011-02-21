<?php

require_once("Mage/Customer/controllers/AccountController.php");

class Janrain_Engage_RpxController extends Mage_Customer_AccountController {
	const SESSION_NAMESPACE = 'Janrain_Engage';

	public function preDispatch() {
	}

	/**
	 * Default customer account page
	 */
	public function indexAction() {
	}

	/**
	 * RPX Callback
	 */
	public function token_urlAction() {
		parent::preDispatch();
		$session = $this->_getSession();

		if ($this->getRequest()->isPost()) {
			$token = $this->getRequest()->getPost('token');
			if(!isset($_SESSION[self::SESSION_NAMESPACE]))
				$_SESSION[self::SESSION_NAMESPACE] = array();
			$key = $this->rand_str(12);
			$_SESSION[self::SESSION_NAMESPACE][$key] = $token;
			$this->_redirect("janrain-engage/rpx/login/ses/$key");
		}
	}

	/**
	 * Login post action
	 */
	public function loginAction() {
		parent::preDispatch();
		$session = $this->_getSession();
		if ($session->isLoggedIn()) {
			$this->_redirect('*/*/');
			return;
		}

		if(!isset($_SESSION[self::SESSION_NAMESPACE]))
			$_SESSION[self::SESSION_NAMESPACE] = array();

		$key = $this->getRequest()->getParam('ses');
		$token = $_SESSION[self::SESSION_NAMESPACE][$key];
		$auth_info = Mage::helper('engage')->rpxAuthInfoCall($token);

		$username = 'bryce+testuser@janrain.com';

		$customer = Mage::getModel('customer/customer')
						->setWebsiteId(Mage::app()->getStore()->getWebsiteId());

		if ($this->authenticate($customer, $username)) {
			$session->setCustomerAsLoggedIn($customer);
			$this->_loginPostRedirect();
		}
	}

	/**
	 * Create customer account action
	 */
	public function createAction() {
		$session = $this->_getSession();
		if ($session->isLoggedIn()) {
			$this->_redirect('*/*/');
			return;
		}
		$session->setEscapeMessages(true); // prevent XSS injection in user input
		$errors = array();

		if (!$customer = Mage::registry('current_customer')) {
			$customer = Mage::getModel('customer/customer')->setId(null);
		}

		/* @var $customerForm Mage_Customer_Model_Form */
		$customerForm = Mage::getModel('customer/form');
		$customerForm->setFormCode('customer_account_create')
				->setEntity($customer);

		// Populate Test Data
		$customerData = array(
			"firstname" => "TESTU",
			"lastname" => "SER",
			"email" => "bryce+testu_ser@janrain.com",
			"password" => $this->rand_str(8)
		);

		/**
		 * Come back to this - make an option to auto-subscribe new users
		 *
		  if ($this->getRequest()->getParam('is_subscribed', false)) {
		  $customer->setIsSubscribed(1);
		  } */
		/**
		 * Initialize customer group id
		 */
		$customer->getGroupId();

		try {
			$customerErrors = $customerForm->validateData($customerData);
			if ($customerErrors !== true) {
				$errors = array_merge($customerErrors, $errors);
			} else {
				$customerForm->compactData($customerData);
				$customer->setPassword($customerData['password']);
				$customer->setConfirmation($customerData['password']);
				$customerErrors = $customer->validate();
				if (is_array($customerErrors)) {
					$errors = array_merge($customerErrors, $errors);
				}
			}

			$validationResult = count($errors) == 0;

			if (true === $validationResult) {
				$customer->save();

				if ($customer->isConfirmationRequired()) {
					$customer->sendNewAccountEmail('confirmation', $session->getBeforeAuthUrl());
					$session->addSuccess($this->__('Account confirmation is required. Please, check your email for the confirmation link. To resend the confirmation email please <a href="%s">click here</a>.', Mage::helper('customer')->getEmailConfirmationUrl($customer->getEmail())));
					$this->_redirectSuccess(Mage::getUrl('*/*/index', array('_secure' => true)));
					return;
				} else {
					$session->setCustomerAsLoggedIn($customer);
					$url = $this->_welcomeCustomer($customer);
					$this->_redirectSuccess($url);
					return;
				}
			} else {
				if (is_array($errors)) {
					foreach ($errors as $errorMessage) {
						$session->addError($errorMessage);
					}
				} else {
					$session->addError($this->__('Invalid customer data'));
				}
			}
		} catch (Mage_Core_Exception $e) {
			$session->setCustomerFormData($this->getRequest()->getPost());
			if ($e->getCode() === Mage_Customer_Model_Customer::EXCEPTION_EMAIL_EXISTS) {
				$url = Mage::getUrl('customer/account/forgotpassword');
				$message = $this->__('There is already an account with this email address. If you are sure that it is your email address, <a href="%s">click here</a> to get your password and access your account.', $url);
				$session->setEscapeMessages(false);
			} else {
				$message = $e->getMessage();
			}
			$session->addError($message);
		} catch (Exception $e) {
			$session->setCustomerFormData($this->getRequest()->getPost())
					->addException($e, $this->__('Cannot save the customer.'));
		}

		$this->_redirectError(Mage::getUrl('*/*/create', array('_secure' => true)));
	}

	/**
	 * Define target URL and redirect customer after logging in
	 */
	protected function _loginPostRedirect() {
		$session = $this->_getSession();

		if (!$session->getBeforeAuthUrl() || $session->getBeforeAuthUrl() == Mage::getBaseUrl()) {

			// Set default URL to redirect customer to
			$session->setBeforeAuthUrl(Mage::helper('customer')->getAccountUrl());
			// Redirect customer to the last page visited after logging in
			if ($session->isLoggedIn()) {
				if (!Mage::getStoreConfigFlag('customer/startup/redirect_dashboard')) {
					$referer = $this->getRequest()->getParam(Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME);
					if ($referer) {
						$referer = Mage::helper('core')->urlDecode($referer);
						if ($this->_isUrlInternal($referer)) {
							$session->setBeforeAuthUrl($referer);
						}
					}
				} else if ($session->getAfterAuthUrl()) {
					$session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
				}
			} else {
				$session->setBeforeAuthUrl(Mage::helper('customer')->getLoginUrl());
			}
		} else if ($session->getBeforeAuthUrl() == Mage::helper('customer')->getLogoutUrl()) {
			$session->setBeforeAuthUrl(Mage::helper('customer')->getDashboardUrl());
		} else {
			if (!$session->getAfterAuthUrl()) {
				$session->setAfterAuthUrl($session->getBeforeAuthUrl());
			}
			if ($session->isLoggedIn()) {
				$session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
			}
		}
		//$this->_redirectUrl($session->getBeforeAuthUrl(true));
		$this->_redirectUrl('http://lamp-magento.com/customer/account/index/');
	}

	/**
	 * Authenticate customer
	 *
	 * @param  instance $customer
	 * @param  string $login
	 * @return true
	 * @throws Exception
	 */
	public function authenticate(&$customer, $login) {
		$customer->loadByEmail($login);
		if ($customer->getConfirmation() && $customer->isConfirmationRequired()) {
			throw Mage::exception('Mage_Core', Mage::helper('customer')->__('This account is not confirmed.'),
					self::EXCEPTION_EMAIL_NOT_CONFIRMED
			);
		}
		Mage::dispatchEvent('customer_customer_authenticated', array(
					'model' => $customer,
					'password' => 'nopass',
				));
		return true;
	}

	private function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
		$chars_length = (strlen($chars) - 1);

		$string = $chars{rand(0, $chars_length)};

		for ($i = 1; $i < $length; $i = strlen($string)) {
			$r = $chars{rand(0, $chars_length)};

			if ($r != $string{$i - 1})
				$string .= $r;
		}

		return $string;
	}

}