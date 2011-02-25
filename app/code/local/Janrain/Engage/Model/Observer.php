<?php

class Janrain_Engage_Model_Observer {

	public function addIdentifier($observer) {
		$engage_session = Mage::helper('engage/session');

		if($identifier = $engage_session->getIdentifier()) {
			$observer->getCustomer()->setEngageIdentifier($identifier);
		}
	}

	public function onConfigSave($observer) {
		if($lookup_rp = Mage::helper('engage/rpxcall')->rpxLookupRpCall()){
			if($lookup_rp->realm)
				$uiConfig = Mage::helper('engage/rpxcall')->rpxUiConfigCall($lookup_rp->realm, $lookup_rp->realmScheme);

			Mage::getModel('core/config')
				->saveConfig('engage/vars/realm', $lookup_rp->realm)
				->saveConfig('engage/vars/realmscheme', $lookup_rp->realmScheme)
				->saveConfig('engage/vars/appid', $lookup_rp->appId)
				->saveConfig('engage/vars/adminurl', $lookup_rp->adminUrl)
				->saveConfig('engage/vars/socialpub', $lookup_rp->socialPub)
				->saveConfig('engage/vars/enabled_providers', $uiConfig ? serialize($uiConfig->enabled_providers) : '');
			Mage::getConfig()->reinit();
		}
	}

}