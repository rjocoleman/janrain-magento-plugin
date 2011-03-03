<?php

require_once("Mage/Customer/controllers/AccountController.php");

class Janrain_Engage_RpxController extends Mage_Customer_AccountController {

	// Override parent preDispatch so we can manually invoke it when needed.
	// If preDispatch runs prior to the action being called the user
	// tends to be redirected to the login page
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

			// Init engage_session
			$engage_session = Mage::helper('engage/session');

			// Store token in session under random key
			$key = Mage::helper('engage')->rand_str(12);
			$engage_session->setStore($key, $token);

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

		// Init engage_session
		$engage_session = Mage::helper('engage/session');

		$key = $this->getRequest()->getParam('ses');
		$token = $engage_session->getStore($key);
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

			$email = $auth_info->profile->verifiedEmail
				? $auth_info->profile->verifiedEmail
				: ($auth_info->profile->email
						? $auth_info->profile->email : ''
				);

			$firstName = Mage::helper('engage/rpxcall')->getFirstName($auth_info);
			$lastName = Mage::helper('engage/rpxcall')->getLastName($auth_info);

			$form_data->setEmail($email);
			$form_data->setFirstname($firstName);
			$form_data->setLastname($lastName);
			$engage_session->setIdentifier($auth_info->profile->identifier);

			$this->renderLayout();
			return;
		} else {
			// TODO Make a more secure method of bypassing password
			$engage_session->setStore('bypass_password', true);
			$session->login($customer->getEmail(), 'REQUIRED_SECOND_PARAM');
			$this->_loginPostRedirect();
		}
	}

}