<?php

class Janrain_Engage_Helper_Data extends Mage_Core_Helper_Abstract {

	public function isEngageEnabled() {
		return Mage::getStoreConfig('engage/options/enable');
	}

}