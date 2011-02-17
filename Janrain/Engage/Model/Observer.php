<?php

class Janrain_Engage_Model_Observer extends Mage_Core_Controller_Varien_Action {
	const RPX_TOKEN_ACTION = 'rpx_token';
	const RPX_AUTH_ACTION = 'rpx_auth';
	const SESSION_NAMESPACE = 'Janrain_Engage';


	private $request;

	public function checkForAuthInfo($observer) {
		$this->request = $observer->getEvent()->getData('front')->getRequest();
		$rpxApiKey = '1ea372282118fd1574f6fdd1e3961cec868b21f4';

		if ($this->request->action == self::RPX_TOKEN_ACTION && $this->request->token) {

			if (strlen($this->request->token) == 40) {
				$http = new Varien_Http_Client('https://rpxnow.com/api/v2/auth_info');
				$http->setParameterPost(array(
					'token' => $this->request->token,
					'apiKey' => $rpxApiKey,
					'format' => 'json',
					'extended' => 'true'
				));
				$result = $http->request(Varien_Http_Client::POST);

				$auth_info = json_decode($result->getBody());

				if ($auth_info->stat == 'ok') {
					Mage::app()->setCurrentStore('default');
					$this->_session = Mage::getSingleton('customer/session');
					var_dump($this->_session->login('brycehamrick@gmail.com','password1'));
					//Mage::getModel('engage/customer')->authenticate('brycehamrick@gmail.com');

					/*
					if($this->login($auth_info->email)) {
						$session = $this->_getSession();
						var_dump($session->isLoggedIn());
						exit;
					}
					*/

					/*
					$ses = new Zend_Session_Namespace(self::SESSION_NAMESPACE);
					$key = $this->randomString(6);
					$ses->$key = $auth_info;
					$redirect = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB)
						."?action=".self::RPX_AUTH_ACTION
						."&session=".$key;
					header('HTTP/1.1 303 See Other');
					header('Content-Type: text/html');
					header('Location: '.$redirect);
					 *
					 */
				}
			}
		}
		elseif ($this->request->action == self::RPX_AUTH_ACTION && $this->request->session) {
			$ses = new Zend_Session_Namespace(self::SESSION_NAMESPACE);
		}
	}

}