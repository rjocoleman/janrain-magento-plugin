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

		$customer = Mage::getModel("customer/customer")->load(1);
		
		var_dump(($customer->getData()));

    }

}