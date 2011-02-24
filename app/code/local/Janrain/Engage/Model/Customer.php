<?php

class Janrain_Engage_Model_Customer extends Mage_Customer_Model_Customer {

	/**
     * Validate password with salted hash
     *
     * @param string $password
     * @return boolean
     */
    public function validatePassword($password)
    {
		if($_SESSION[Mage::getStoreConfig('engage/vars/session_namespace')]['bypass_password']===true)
			return true;
        return parent::validatePassword($password);
    }

}