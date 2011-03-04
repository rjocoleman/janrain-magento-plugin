<?php

class Janrain_Engage_Helper_Session extends Mage_Core_Helper_Abstract {

	const ENGAGE_IDENTIFIER = 'identifier';
	const SESSION_NAMESPACE = 'Janrain_Engage';

	function __construct() {
		if (!isset($_SESSION[self::SESSION_NAMESPACE]))
			$_SESSION[self::SESSION_NAMESPACE] = array();
	}

	public function getIdentifier() {
		return $_SESSION[self::SESSION_NAMESPACE][self::ENGAGE_IDENTIFIER];
	}

	public function setIdentifier($string) {
		$_SESSION[self::SESSION_NAMESPACE][self::ENGAGE_IDENTIFIER] = $string;
	}

	public function getStore($key) {
		return $_SESSION[self::SESSION_NAMESPACE][$key];
	}

	public function setStore($key, $string) {
		$_SESSION[self::SESSION_NAMESPACE][$key] = $string;
	}

}