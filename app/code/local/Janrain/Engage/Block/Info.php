<?php

class Janrain_Engage_Block_Info extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

    public function render(Varien_Data_Form_Element_Abstract $element) {

        $html = $this->_getHeaderHtml($element);

        $html.= $this->_getFieldHtml($element);

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    protected function _getFieldHtml($fieldset) {
        $content = '<p>This extension is developed by <a href="http://janrain.com/" target="_blank">Janrain</a></p>';
        $content.= '<p>Copyright &copy ' . date("Y") . ' <a href="http://janrain.com/" target="_blank">Janrain, Inc.</a></p>';
		$content.= '<p>Realm: '.Mage::getStoreConfig('engage/vars/realm').'<br />Realm Scheme: '.Mage::getStoreConfig('engage/vars/realmscheme')
			.'<br />App Id: '.Mage::getStoreConfig('engage/vars/appid').'<br />Admin Url: '.Mage::getStoreConfig('engage/vars/adminurl')
			.'<br />Social Pub: '.Mage::getStoreConfig('engage/vars/socialpub')
			.'<br />Enabled Providers: '.Mage::getStoreConfig('engage/vars/enabled_providers').'</p>';
        return $content;
    }

}
