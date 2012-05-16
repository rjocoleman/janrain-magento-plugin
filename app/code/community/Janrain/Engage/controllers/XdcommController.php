<?php

class Janrain_Engage_XdcommController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $block = $this->getLayout()->createBlock('engage/xdcomm');
        $this->getResponse()->setBody($block->toHtml());
    }

}
