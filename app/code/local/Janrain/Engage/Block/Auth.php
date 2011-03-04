<?php

class Janrain_Engage_Block_Auth extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface {

	/**
	 * Returns the size the user has selected for the given widget
	 *
	 * @return string
	 */
	public function getRpxSize() {
		return $this->getData("size");
	}

	function rpx_small_buttons() {
		$providers = Mage::helper('engage')->getRpxProviders();
		if (is_array($providers)) {
			$size = $this->getData("size") ? $this->getData("size") : "large";
			$wrap_open = '<a class="rpxnow rpx_link_wrap" onclick="return false;" href="'
					. Mage::helper('engage')->getRpxAuthUrl()
					. '">';
			$wrap_close = '</a>';
			$label = '<div class="rpx_label">Or log in with</div>';
			$rpx_buttons = '';
			foreach ($providers as $val) {
				$rpx_buttons .= '<div class="rpx_icon_' . $size . ' rpx_' . $val . '_' . $size . '" title="' . htmlentities($val) . '"></div>';
			}
			$buttons = '<div class="rpx_button"><div class="rpx_' . $size . '_icons">' . $rpx_buttons . '</div></div><div class="rpx_clear"></div>';

			return $wrap_open . $label . $buttons . $wrap_close;
		}
	}

	protected function _toHtml() {
		return $this->rpx_small_buttons();
	}

	protected function _prepareLayout() {

		/*
		 * Doesn't work on inline widgets because layout isn't loaded until
		 * after the head has been written to the page. Fix.
		 *
		if($this->getLayout()->getBlock('janrain_engage_styles')==false) {
			$block = $this->getLayout()
				->createBlock('core/template', 'janrain_engage_styles')
				->setTemplate('janrain/engage/styles.phtml');
			$this->getLayout()->getBlock('head')->insert($block);
		}
		*/

		if($this->getLayout()->getBlock('janrain_engage_scripts')==false) {
			$block = $this->getLayout()
				->createBlock('core/template', 'janrain_engage_scripts')
				->setTemplate('janrain/engage/scripts.phtml');
			$this->getLayout()->getBlock('before_body_end')->insert($block);
		}

		parent::_prepareLayout();
	}

}