<?php

require_once("Mage/Customer/controllers/AccountController.php");

class Janrain_Engage_RpxController extends Mage_Customer_AccountController {

	const SESSION_NAMESPACE = 'Janrain_Engage';

	public function preDispatch(){
		//parent::preDispatch();
	}

	/**
     * Default customer account page
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');

        $this->getLayout()->getBlock('content')->append(
            $this->getLayout()->createBlock('customer/account_dashboard')
        );
        $this->getLayout()->getBlock('head')->setTitle($this->__('My Account'));
        $this->renderLayout();
    }

	/**
	 * Login post action
	 */
	public function loginAction() {
		if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');
            return;
        }
		$session = $this->_getSession();

		$login = array('username'=>'bryce+test@janrain.com','password'=>'password1');

		try {
			$session->login($login['username'], $login['password']);
			if ($session->getCustomer()->getIsJustConfirmed()) {
				$this->_welcomeCustomer($session->getCustomer(), true);
			}
		} catch (Mage_Core_Exception $e) {
			switch ($e->getCode()) {
				case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED:
					$message = Mage::helper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', Mage::helper('customer')->getEmailConfirmationUrl($login['username']));
					break;
				case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD:
					$message = $e->getMessage();
					break;
				default:
					$message = $e->getMessage();
			}
			$session->addError($message);
			$session->setUsername($login['username']);
		} catch (Exception $e) {
			// Mage::logException($e); // PA DSS violation: this exception log can disclose customer password
		}

		$this->_loginPostRedirect();
	}

	public function token_urlAction(){
		Mage::getModel('engage/customer')->authenticate('brycehamrick@gmail.com');
		exit;
	}

	/**
     * Create customer account action
     */
    public function createAction()
    {
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
			"password" => "password1"
		);

		/**
		 * Come back to this - make an option to auto-subscribe new users
		 *
		if ($this->getRequest()->getParam('is_subscribed', false)) {
			$customer->setIsSubscribed(1);
		}*/

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
					$this->_redirectSuccess(Mage::getUrl('*/*/index', array('_secure'=>true)));
					return;
				} else {
					$session->setCustomerAsLoggedIn($customer);
					$url = $this->_welcomeCustomer($customer);
					$this->_redirectSuccess($url);
					return;
				}
			} else {
				$session->setCustomerFormData($this->getRequest()->getPost());
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
    protected function _loginPostRedirect()
    {
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
		$this->_redirectUrl('http://magento.bhamrick.kodingen.com/customer/account/index/');
    }

}