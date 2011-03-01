<?php

class Janrain_Engage_Block_Accountdata extends Mage_Adminhtml_Block_System_Config_Form_Fieldset {

    public function render(Varien_Data_Form_Element_Abstract $element) {

        $html = $this->_getHeaderHtml($element);

        $html.= $this->_getFieldHtml($element);

        $html .= $this->_getFooterHtml($element);

        return $html;
    }

    protected function _getFieldHtml($fieldset) {
		$vars = array(
			'realm' => 'Realm',
			'realmscheme' => 'Realm Scheme',
			'appid' => 'App Id',
			'adminurl' => 'Admin URL',
			'socialpub' => 'Social Pub',
			'enabled_providers' =>'Enabled Providers'
		);

		if(Mage::helper('engage')->isEngageEnabled() === false)
			return '<p>Module not enabled. Please set "Enabled" to "Yes" and enter your API key above.</p>';

		$content = '<p>The following is the current account info being used. <a href="#">Click Here to refresh</a></p>';

		$content .= '<table><tbody>';
		foreach($vars as $key => $val){
			$value = Mage::getStoreConfig('engage/vars/' . $key);
			if($key=='enabled_providers' && $providers = unserialize($value))
				$value = implode(', ', $providers);

			$content .= '<tr><td><em>' . $val . ':</em></td><td>' . $value . '</td></tr>';
		}
        $content .= '</tbody></table>';
		
        return $content;
    }

}
