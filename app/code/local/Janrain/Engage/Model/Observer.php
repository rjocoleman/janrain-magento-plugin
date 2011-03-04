<?php

class Janrain_Engage_Model_Observer {

	public function addIdentifier($observer) {
		$engage_session = Mage::helper('engage/session');
		if($identifier = $engage_session->getIdentifier()) {
			Mage::helper('engage/identifiers')
				->save_identifier($observer->getCustomer()->getId(), $identifier);
			$engage_session->setIdentifier('');
		}
	}

	public function onConfigSave($observer) {
		if(strlen(Mage::getStoreConfig('engage/vars/appid'))<1){
			Mage::helper('engage/rpxcall')->rpxLookupSave();
		}
	}

}