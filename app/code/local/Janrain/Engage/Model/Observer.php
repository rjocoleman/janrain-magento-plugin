<?php

class Janrain_Engage_Model_Observer {

	public function addIdentifier($observer) {
		$engage_session = Mage::helper('engage/session');

		if($identifier = $engage_session->getIdentifier()) {
			$observer->getCustomer()->setEngageIdentifier($identifier);
		}
	}

	public function onConfigSave($observer) {

        // TODO don't do this every time the user saves the config

        // user stores API key in Admin
        // on that save, we turn around and call lookup_rp
        // save additional data (at least, account name)
        // call more additional data, using realm name and api key
        // save the list of providers

        // Set new value
//		Mage::getModel('core/config')->saveConfig('engage/vars/enabled_providers', $value );

		// Re-initialize config
//		Mage::getConfig()->reinit();

		// Refresh store for output display
//		Mage::app()->reinitStores();
//        return;




//		var_dump($observer->getGroups());
//        echo("hello");
//		echo($observer);
//		exit;
//        return false;
	}

}