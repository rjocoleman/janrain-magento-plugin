<?php

require_once("Mage/Customer/controllers/AccountController.php");

class Janrain_Engage_RpxController extends Mage_Customer_AccountController {

	// Override parent preDispatch so we can manually invoke it when needed
	public function preDispatch() {
	}

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

			// Init session if it doesn't exists
			if(!isset($_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')]))
				$_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')] = array();

			// Store token in session under random key
			$key = $this->rand_str(12);
			$_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')][$key] = $token;

			// Redirect user to $this->authAction method passing $key as ses
			// $_GET variable (Magento style)
			$this->_redirect("janrain-engage/rpx/create/ses/$key");
		}
	}

	public function createAction() {
		parent::preDispatch();
		$session = $this->_getSession();
		if ($session->isLoggedIn()) {
			$this->_redirect('*/*/');
			return;
		}

		if(!isset($_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')]))
			$_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')] = array();

		$key = $this->getRequest()->getParam('ses');
		$token = $_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')][$key];
		$auth_info = Mage::helper('engage/rpxcall')->rpxAuthInfoCall($token);

		$customer = Mage::getModel('customer/customer')
			->getCollection()
			->addFieldToFilter('engage_identifier',$auth_info->profile->identifier)
			->getFirstItem();
		
		// TODO Manually setting redirect url to the customer/account page. Fix.
		$session->setBeforeAuthUrl(Mage::helper('customer')->getDashboardUrl());

		if(!$customer->getId()){
			$this->loadLayout();
			$block = Mage::getSingleton('core/layout')->getBlock('customer_form_register');
			$form_data = $block->getFormData();
			$form_data->setEmail('this is a test');
			$form_data->setEngageIdentifier($auth_info->profile->identifier);

			$this->renderLayout();
			return;
		} else {
			$_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')]['bypass_password'] = true;
			$session->login($customer->getEmail(), 'REQUIRED_SECOND_PARAM');
			$this->_loginPostRedirect();
		}
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