<?php

class Janrain_Engage_Block_Auth extends Mage_Core_Block_Template implements Mage_Widget_Block_Interface {

    function rpx_small_buttons() {
        $size = $this->getSize();
        if ($size == 'inline') {
            return '<div id="janrainEngageEmbed"></div>'; 
        }
        else {
            $providers = Mage::helper('engage')->getRpxProviders();
            if (is_array($providers)) {
                $size = ($size == 'small') ? "16" : "30";
                $wrap_open = '<a class="janrainEngage rpxnow rpx_link_wrap" onclick="return false;" href="'
                    . Mage::helper('engage')->getRpxAuthUrl()
                    . '">';
                $wrap_close = '</a>';

                $labelText = $this->getLabelText();
                if (empty($labelText))
                    $labelText = 'Or log in with';

                $label = '<span class="rpx_label">' . $labelText . '</span>';
                $rpx_buttons = '';
                foreach ($providers as $val) {
                    $rpx_buttons .= '<span class="jn-icon jn-size' . $size . ' jn-' . $val . '" title="' . htmlentities($val) . '"></span>';
                }
                $buttons = '<span class="rpx_button">' . $rpx_buttons . '</span><span class="rpx_clear"></span>';

                return $wrap_open . $label . $buttons . $wrap_close;

            }

        }
    }

    protected function _toHtml() {
        $content = '';
        if (Mage::getSingleton('customer/session')->isLoggedIn() == false)
            $content = $this->rpx_small_buttons();
        return $content;
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

        if ($this->getLayout()->getBlock('janrain_engage_scripts') == false) {
            $block = $this->getLayout()
                ->createBlock('core/template', 'janrain_engage_scripts')
                ->setTemplate('janrain/engage/scripts.phtml');
            $this->getLayout()->getBlock('before_body_end')->insert($block);
        }

        parent::_prepareLayout();
    }

}
