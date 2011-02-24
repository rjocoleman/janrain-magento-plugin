<?php

class Janrain_Engage_Model_Observer {

	public function addIdentifier($observer) {
		$engage_session = Mage::helper('engage/session');

		if($identifier = $engage_session->getIdentifier()) {
			$observer->getCustomer()->setEngageIdentifier($identifier);
		}
	}

	public function onConfigSave($observer) {

        

//		var_dump($observer->getGroups());
//        echo("hello");
//		echo($observer);
//		exit;
//        return false;
	}

}