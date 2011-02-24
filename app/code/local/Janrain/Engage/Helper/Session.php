<?php

class Janrain_Engage_Helper_Session extends Mage_Core_Helper_Abstract {

	private $_namespace;
	const ENGAGE_IDENTIFIER = 'identifier';

	function __construct() {
		$this->_namespace = Mage::getStoreConfig('engage/vars/session_namespace');
		if (!isset($_SESSION[$this->_namespace]))
			$_SESSION[$this->_namespace] = array();
	}

	public function getIdentifier() {
		return $_SESSION[$this->_namespace][self::ENGAGE_IDENTIFIER];
	}

	public function setIdentifier($string) {
		$_SESSION[$this->_namespace][self::ENGAGE_IDENTIFIER] = $string;
	}

	public function getStore($key) {
		return $_SESSION[$this->_namespace][self::ENGAGE_IDENTIFIER][$key];
	}

	public function setStore($key, $string) {
		$_SESSION[$this->_namespace][self::ENGAGE_IDENTIFIER][$key] = $string;
	}

}

?>
