<?php

class Janrain_Engage_Block_Auth extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface {

	protected $rpx_size;
	protected $rpx_auth_url;
	protected $rpx_providers;

	/**
	 * Returns the size the user has selected for the given widget
	 *
	 * @return string
	 */
	public function getRpxSize() {
		if (!$this->rpx_size) {
			$this->rpx_size = $this->getData("size");
		}

		return $this->rpx_size;
	}

	/**
	 * Returns the full Auth URL for the Engage Sign In Widget
	 *
	 * @return string
	 */
	public function getRpxAuthUrl() {
		if (!$this->rpx_auth_url) {
			$rpx_callback = urlencode(Mage::getUrl() . "/janrain-engage/rpx/token_url");
			$link = (Mage::getStoreConfig('engage/vars/realmscheme') == 'https') ? 'https' : 'http';
			$link.= '://' . Mage::getStoreConfig('engage/vars/realm');
			$link.= '/openid/v2/signin?token_url=' . $rpx_callback;
			$this->rpx_auth_url = $link;
		}

		return $this->rpx_auth_url;
	}

	/**
	 * Returns an unserialized array of available providers
	 * or Null if empty (Invalid or missing API Key)
	 *
	 * @return string
	 */
	public function getRpxProviders() {
		if (!$this->rpx_providers) {
			$providers = Mage::getStoreConfig('engage/vars/enabled_providers');
			if ($providers)
				$this->rpx_providers = unserialize($providers);
		}

		return $this->rpx_providers;
	}

	function rpx_small_buttons() {
		$rpx_callback = Mage::getUrl() . "/janrain-engage/rpx/token_url";
		$rpx_callback = urlencode($rpx_callback);

		$providers = $this->getRpxProviders();
		$size = $this->getData("size") ? $this->getData("size") : "large";
		$wrap_open = '<a class="rpxnow rpx_link_wrap" onclick="return false;" href="';
		$wrap_open .= (Mage::getStoreConfig('engage/vars/realmscheme') == 'https') ? 'https' : 'http';
		$wrap_open .= '://' . Mage::getStoreConfig('engage/vars/realm') . '/openid/v2/signin?token_url=' . $rpx_callback . '">';
		$wrap_close = '</a>';
		$label = '<div class="rpx_label">Or log in with</div>';
		$rpx_buttons = '';
		foreach ($providers as $val) {
			$rpx_buttons .= '<div class="rpx_icon_' . $size . ' rpx_' . $val . '_' . $size . '" title="' . htmlentities($val) . '"></div>';
		}
		$buttons = '<div class="rpx_button"><div class="rpx_' . $size . '_icons">' . $rpx_buttons . '</div></div><div class="rpx_clear"></div>';
		
		return $wrap_open . $label . $buttons . $wrap_close;
	}

	protected function _toHtml() {
		return $this->rpx_small_buttons();
	}

}