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
		// TODO Make a more secure method of bypassing password
		if(Mage::helper('engage/session')->getStore('bypass_password')===true)
			return true;
        return parent::validatePassword($password);
    }

}