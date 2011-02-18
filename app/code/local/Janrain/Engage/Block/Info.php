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
        return $content;
    }

}
