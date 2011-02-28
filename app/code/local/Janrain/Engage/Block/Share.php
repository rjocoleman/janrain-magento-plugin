<?php

class Janrain_Engage_Block_Share extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface {

	protected function  _construct() {
		parent::_construct();
	}

	/**
	 * Adds a link to open the Engage authentication dialog
	 *
	 * @return string
	 */
	protected function _toHtml() {
		$rpx_callback = Mage::getUrl() . "/janrain-engage/rpx/token_url";
		$rpx_callback = urlencode($rpx_callback);

		$link = '<h2>Social Sharing is Fun!</h2>';
		return $link;
	}

}