<?php

require_once("Mage/Customer/Model/Customer.php");

class Janrain_Engage_Model_Customer extends Mage_Customer_Model_Customer {

	private $_session;

	/**
     * Construct Parent
     *
     */
	function _construct() {
		
		parent::_construct();
		
		// Probably need to change this to allow for non-default store authentication
		Mage::app()->setCurrentStore('default');
		$this->_session = Mage::getSingleton('customer/session');

	}

	/**
     * Authenticate customer
     *
     * @param  string $login
     * @return true
     * @throws Exception
     */
    public function authenticate($login)
    {
		$customer = Mage::getModel('customer/customer');
		$customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());

        $customer->loadByEmail($login);
        if ($customer->getConfirmation() && $customer->isConfirmationRequired()) {
            throw Mage::exception('Mage_Core', Mage::helper('customer')->__('This account is not confirmed.'),
                self::EXCEPTION_EMAIL_NOT_CONFIRMED
            );
        }
        Mage::dispatchEvent('customer_customer_authenticated', array(
           'model'    => $customer
        ));
		var_dump($this->_session->setCustomerAsLoggedIn($customer));
        return true;
    }

	/**
     * Define target URL and redirect customer after logging in
     */
    protected function _loginPostRedirect()
    {
		/*
        $session = $this->_getSession();

        if (!$session->getBeforeAuthUrl() || $session->getBeforeAuthUrl() == Mage::getBaseUrl()) {

            // Set default URL to redirect customer to
            $session->setBeforeAuthUrl(Mage::helper('customer')->getAccountUrl());
            // Redirect customer to the last page visited after logging in
            if ($session->isLoggedIn()) {
                if (!Mage::getStoreConfigFlag('customer/startup/redirect_dashboard')) {
                    $referer = $this->getRequest()->getParam(Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME);
                    if ($referer) {
                        $referer = Mage::helper('core')->urlDecode($referer);
                        if ($this->_isUrlInternal($referer)) {
                            $session->setBeforeAuthUrl($referer);
                        }
                    }
                } else if ($session->getAfterAuthUrl()) {
                    $session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
                }
            } else {
                $session->setBeforeAuthUrl(Mage::helper('customer')->getLoginUrl());
            }
        } else if ($session->getBeforeAuthUrl() == Mage::helper('customer')->getLogoutUrl()) {
            $session->setBeforeAuthUrl(Mage::helper('customer')->getDashboardUrl());
        } else {
            if (!$session->getAfterAuthUrl()) {
                $session->setAfterAuthUrl($session->getBeforeAuthUrl());
            }
            if ($session->isLoggedIn()) {
                $session->setBeforeAuthUrl($session->getAfterAuthUrl(true));
            }
        }
        //$this->_redirectUrl($session->getBeforeAuthUrl(true));
		//$this->_redirectUrl('http://magento.bhamrick.kodingen.com/customer/account/index/');
		 * 
		 */
		header('HTTP/1.1 303 See Other');
		header('Content-Type: text/html');
		header('Location: '.'http://magento.bhamrick.kodingen.com/customer/account/index/');
    }

	private function randomString($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';
		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}

	/**
     * Check url to be used as internal
     *
     * @param   string $url
     * @return  bool
     */
    protected function _isUrlInternal($url)
    {
        if (strpos($url, 'http') !== false) {
            /**
             * Url must start from base secure or base unsecure url
             */
            if ((strpos($url, Mage::app()->getStore()->getBaseUrl()) === 0)
                || (strpos($url, Mage::app()->getStore()->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, true)) === 0)) {
                return true;
            }
        }
        return false;
    }

}