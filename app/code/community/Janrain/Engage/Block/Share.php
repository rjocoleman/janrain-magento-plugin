<?php

class Janrain_Engage_Block_Share extends Mage_Core_Block_Abstract implements Mage_Widget_Block_Interface {

    public function rpx_social_icons() {
        $social_pub = Mage::getStoreConfig('engage/vars/socialpub');
        $social_providers = array_filter(explode(',', $social_pub));
        if (is_array($social_providers)) {
            $rpx_social_icons = '';
            foreach ($social_providers as $val) {
                $rpx_social_icons .= '<div class="jn-icon jn-size16 jn-' . $val . '"></div>';
            }
            $buttons = '<div class="rpx_social_icons">' . $rpx_social_icons . '</div>';
            return $buttons;
        }
        return false;
    }

    /**
     * Adds a link to open the Engage authentication dialog
     *
     * @return string
     */
    protected function _toHtml() {
        $link = '';

        if ($icons = $this->rpx_social_icons()) {
            $link .= '<div class="rpxsocial rpx_tooltip" id="janrainEngageShare">';
            $link .= '<span class="rpxsharebutton">share</span><div class="rpx_share_tip">Share this on:<br />' . $icons . '</div></div>';
        }

        return $link;
    }

    protected function _prepareLayout() {
        if ($this->getLayout()->getBlock('janrain_engage_share') == false) {
            $block = $this->getLayout()
                ->createBlock('core/template', 'janrain_engage_share')
                ->setData('message', $this->getShareText())
                ->setTemplate('janrain/engage/share.phtml');
            $this->getLayout()->getBlock('before_body_end')->insert($block);
        }

        parent::_prepareLayout();
    }

}
