<?php

class Janrain_Engage_IndexController extends Mage_Core_Controller_Front_Action {

	private $_session;

	public function _construct() {
		// Change to the default store so we
		// can grab the frontend user session
		Mage::app()->setCurrentStore('default');

		// Get the customer session
		$this->_session = Mage::getSingleton('customer/session');
	}

	public function indexAction() {
		echo Mage::getStoreConfig('engage/options/apikey');
	}

	/**
	 * Login Customer
	 *
	 * @param string $email
	 * @param string $password
	 * @return boolean
	 */
	public function loginAction() {
		var_dump($this->_session->login('bryce+testuser@janrain.com', 'password1'));
	}

}