<?php

class Janrain_Engage_Model_Observer {

	public function addIdentifier($observer) {
		if($identifier = Mage::getSingleton('engage/session')->getIdentifier()) {
			Mage::helper('engage/identifiers')
				->save_identifier($observer->getCustomer()->getId(), $identifier);
			Mage::getSingleton('engage/session')->setIdentifier(false);
		}
	}

	public function onConfigSave($observer) {
		if(strlen(Mage::getStoreConfig('engage/vars/appid'))<1){
			Mage::helper('engage/rpxcall')->rpxLookupSave();
		}
	}

}