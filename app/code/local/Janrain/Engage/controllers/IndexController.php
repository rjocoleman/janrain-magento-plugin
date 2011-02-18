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

        $identifier = "http://twitter.com/account/profile?user_id=180107268";
//        $identifier = "http://www.facebook.com/profile.php?id=100001311517499";
        $activity_message = "test Magento 002";
        $url = "http://www.janrain.com";

        try {
            $result = Mage::helper('engage')->rpxActivityCall($identifier, $activity_message, $url);
            echo $result;

        }
        catch (Exception $e) {
            echo $e;
        }

    }

    /**
     * Login Customer
     *
     * @param string $email
     * @param string $password
     * @return boolean
     */
    public function loginAction() {
        var_dump($this->_session->login('bryce+testuser@janrain.com', 'password1'));
    }

}