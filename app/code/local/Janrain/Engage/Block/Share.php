<?php

class Janrain_Engage_Block_Share extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface {

	public function rpx_social_icons() {
		$providers = Mage::helper('engage')->getRpxProviders();
		if(is_array($providers)){
			$social_pub = Mage::getStoreConfig('engage/vars/socialpub');
			$social_providers = array_filter(explode(',', $social_pub));
			$rpx_social_icons = '';
			foreach ($social_providers as $val) {
				$rpx_social_icons .= '<div class="rpx_icon_small rpx_' . $val . '_small"></div>';
			}
			$buttons = '<div class="rpx_social_icons">' . $rpx_social_icons . '</div>';
			return $buttons;
		}
	}

	/**
	 * Adds a link to open the Engage authentication dialog
	 *
	 * @return string
	 */
	protected function _toHtml() {
		$link = '<div class="rpxsocial rpx_tooltip" onclick="RPXNOW.loadAndRun([\'Social\'], function () { var activity = new RPXNOW.Social.Activity(\'Share:\', \'' . Mage::getSingleton('cms/page')->getTitle() . '\', \'' . Mage::helper('core/url')->getCurrentUrl() . '\'); activity.setUserGeneratedContent(\'' . $this->getShareText() . '\'); activity.setDescription(\'' . Mage::getSingleton('cms/page')->getTitle() . '\'); RPXNOW.Social.publishActivity(activity); });">';
		$link .= '<span class="rpxsharebutton">share</span><div class="rpx_share_tip">Share this on:<br />' . $this->rpx_social_icons() . '</div></div>';

		return $link;
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