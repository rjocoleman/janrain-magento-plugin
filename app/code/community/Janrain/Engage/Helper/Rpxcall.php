<?php

class Janrain_Engage_Helper_Rpxcall extends Mage_Core_Helper_Abstract {

    public function getEngageApiKey() {
        return Mage::getStoreConfig('engage/options/apikey');
    }

    public function rpxLookupSave() {
        try {
            $lookup_rp = $this->rpxLookupRpCall();

            Mage::getModel('core/config')
                ->saveConfig('engage/vars/realm', $lookup_rp->realm)
                ->saveConfig('engage/vars/realmscheme', $lookup_rp->realmScheme)
                ->saveConfig('engage/vars/appid', $lookup_rp->appId)
                ->saveConfig('engage/vars/adminurl', $lookup_rp->adminUrl)
                ->saveConfig('engage/vars/socialpub', $lookup_rp->socialPub)
                ->saveConfig('engage/vars/enabled_providers', $lookup_rp->signinProviders)
                ->saveConfig('engage/vars/apikey', Mage::getStoreConfig('engage/options/apikey'));
            Mage::getConfig()->reinit();

            return true;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addWarning('Could not retrieve account info. Please try again');
        }

        return false;
    }

    public function rpxLookupRpCall() {
        $version = Mage::getConfig()->getModuleConfig("Janrain_Engage")->version;

        $postParams = array();
        $postParams["apiKey"] = $this->getEngageApiKey();
        $postParams["pluginName"] = "magento";
        $postParams["pluginVersion"] = $version;

        $result = "rpxLookupRpCall: no result";
        try {
            $result = $this->rpxPost("lookup_rp", $postParams);
        } catch (Exception $e) {
            throw Mage::exception('Mage_Core', $e);
        }

        return $result;
    }
}
