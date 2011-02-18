<?php

class Janrain_Engage_Helper_RpxCall extends Mage_Core_Helper_Abstract {

    public function isEngageEnabled() {
        return Mage::getStoreConfig('engage/options/enable');
    }

    public function getEngageApiKey() {
        return Mage::getStoreConfig('engage/options/apikey');
    }

    public function rpxAuthInfoCall($token) {

        $postParams = array();

        $postParams["token"] = $token;
        $postParams["apiKey"] = $this->getEngageApiKey();

        // TODO: check level of Engage account
        $postParams["extended"] = 'true';

        $result = "rpxAuthInfoCall: no result";
        try {
            $result = $this->rpxCall("auth_info", $postParams);
        }
        catch (Exception $e) {
            throw Mage::exception('Mage_Core', $e);
        }

        return $result;

    }


    public function rpxActivityCall($identifier, $activity_message, $url) {

        $postParams = array();

        $activity_json = "{\"action\":\"$activity_message\",\"url\":\"$url\"}";

        $postParams["activity"] = $activity_json;
        $postParams["identifier"] = $identifier;
        $postParams["apiKey"] = $this->getEngageApiKey();

        $result = "rpxActivityCall: no result";
        try {
            $result = $this->rpxCall("activity", $postParams);
        }
        catch (Exception $e) {
            throw Mage::exception('Mage_Core', $e);
        }

        return $result;

    }


    private function rpxCall($method, $postParams) {

        $rpxbase = "https://rpxnow.com";

        if ($method == "auth_info") {
            $method_fragment = "api/v2/auth_info";
        }
        elseif ($method == "activity") {
            $method_fragment = "api/v2/activity";
        }
        else {
            throw Mage::exception('Mage_Core', "method [$method] not understood");
        }

        $postParams["format"] = 'json';

        $result = "rpxCall: no result yet";

        try {
            $http = new Varien_Http_Client("$rpxbase/$method_fragment");
            $http->setParameterPost($postParams);

            $result = $http->request(Varien_Http_Client::POST);

//            var_dump($result);
//            var_dump($result->getBody());
//            exit;

            $body = $result->getBody();

            try {
                $result = json_decode($body);
            }
            catch (Exception $e) {
                throw Mage::exception('Mage_Core', $e);
            }

//            var_dump($x);
//            exit;

            $stat = $result->stat;
            $err = $result->err;

//            var_dump($stat);
//            var_dump($err);
//            exit;

            if ($err) {
                return $err->msg;
            }
            else if ($stat) {
                return $stat;
            }
            else {
                throw Mage::exception('Mage_Core', "something went wrong");
            }

        }
        catch (Exception $e) {
            throw Mage::exception('Mage_Core', $e);
        }

    }

}