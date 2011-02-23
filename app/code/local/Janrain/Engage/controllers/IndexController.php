<?php

class Janrain_Engage_IndexController extends Mage_Core_Controller_Front_Action {

    public function _construct() {
        // Change to the default store so we
        // can grab the frontend user session
        //Mage::app()->setCurrentStore('default');

        // Get the customer session
        //$this->_session = Mage::getSingleton('customer/session');
    }

    public function indexAction() {
		var_dump(Mage::getStoreConfig('engage/vars/session_namespace'));
		exit;

//		$customer = Mage::getModel('customer/customer')
//						->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
//						->loadByEmail('bryce+testuser9@janrain.com');
//
//		//$customer = Mage::getModel("customer/customer")->loadByEmail('bryce+testuser9@janrain.com');
//		$item = Mage::getModel('customer/customer')->getCollection()
//				->addFieldToFilter('lastname','User6')
//				->addAttributeToSelect('*')
//				->getFirstItem();
//
//		var_dump($item->getData());
		//$customer = $this->_session->getCustomer();
		var_dump(Mage::getSingleton('customer/session')->getCustomer()->getData());
		//$customer->setEngageIdentifier('this is a test');
		//$customer->save();
		//var_dump(($customer->getData()));
    }

}