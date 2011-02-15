<?php

class Janrain_Engage_IndexController extends Mage_Core_Controller_Front_Action {

	public function indexAction() {

		$rpxApiKey = '1ea372282118fd1574f6fdd1e3961cec868b21f4';
		$rpxToken = $this->getRequest()->getPost('token');

		if (strlen($rpxToken) == 40) {
			$http = new Varien_Http_Client('https://rpxnow.com/api/v2/auth_info');
			$http->setParameterPost(array(
				'token' => $rpxToken,
				'apiKey' => $rpxApiKey,
				'format' => 'json',
				'extended' => 'true'
			));
			$result = $http->request(Varien_Http_Client::POST);
			
			$auth_info = json_decode($result->getBody());
			
			if ($auth_info['stat'] == 'ok') {
				
			}
		}
	}

}