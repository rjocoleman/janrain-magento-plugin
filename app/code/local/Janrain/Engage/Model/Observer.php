<?php

class Janrain_Engage_Model_Observer {

	public function addIdentifier($observer) {
		if($_POST['engage_identifier']) {
			$observer->getCustomer()->setEngageIdentifier($_POST['engage_identifier']);
			//var_dump($observer->getCustomer());
			//exit;
		}
	}

}