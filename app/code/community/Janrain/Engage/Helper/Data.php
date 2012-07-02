<?php

class Janrain_Engage_Helper_Data extends Mage_Core_Helper_Abstract {

    private $providers = array(
        'Facebook' => 'facebook',
        'Google' => 'google',
        'LinkedIn' => 'linkedin',
        'MySpace' => 'myspace',
        'Twitter' => 'twitter',
        'Windows Live' => 'live_id',
        'Yahoo!' => 'yahoo',
        'AOL' => 'aol',
        'Blogger' => 'blogger',
        'Flickr' => 'flickr',
        'Hyves' => 'hyves',
        'Livejournal' => 'livejournal',
        'MyOpenID' => 'myopenid',
        'Netlog' => 'netlog',
        'OpenID' => 'openid',
        'Verisign' => 'verisign',
        'Wordpress' => 'wordpress',
        'PayPal' => 'paypal'
    );

    /**
     * Returns whether the Enabled config variable is set to true
     *
     * @return bool
     */
    public function isEngageEnabled() {
        if (Mage::getStoreConfig('engage/options/enable') == '1' && strlen(Mage::getStoreConfig('engage/options/apikey')) > 1)
            return true;

        return false;
    }

    /**
     * Returns random alphanumber string
     *
     * @param int $length
     * @param string $chars
     * @return string
     */
    public function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
        $chars_length = (strlen($chars) - 1);

        $string = $chars{rand(0, $chars_length)};

        for ($i = 1; $i < $length; $i = strlen($string)) {
            $r = $chars{rand(0, $chars_length)};

            if ($r != $string{$i - 1})
                $string .= $r;
        }

        return $string;
    }

    /**
     * Returns the url of skin directory containing scripts and styles
     *
     * @return string
     */
    public function _baseSkin() {
        return Mage::getBaseUrl('skin') . "frontend/janrain";
    }
	
    public function rpxRealmName() {
        $realm = Mage::getStoreConfig('engage/vars/realm');
        $realm = str_replace(".rpxnow.com", "", $realm);
        return $realm;
	}

}
