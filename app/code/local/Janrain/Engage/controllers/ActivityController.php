<?php

class Janrain_Engage_ActivityController extends Mage_Core_Controller_Front_Action {

    public function activityAction() {

        $identifier = "http://twitter.com/account/profile?user_id=180107268";
//        $identifier = "http://www.facebook.com/profile.php?id=100001311517499";
        $activity_message = "test Magento 004";
        $url = "http://www.janrain.com";

        try {
            $result = Mage::helper('engage/rpxCall')->rpxActivityCall($identifier, $activity_message, $url);
            // echo $result;

            // TODO flash some kind of message
            // TODO redirect


        }
        catch (Exception $e) {
            // echo $e;
            Mage::Log("problem doing social publishing: $e");

            // TODO flash some kind of message
            // TODO redirect

        }

    }

	public function getidentifierAction() {
		Mage::getModel('engage/identifiers')->setIdentifier('test')->save();
		$col = Mage::getModel('engage/identifiers')->getCollection()
				->addFieldToFilter('indentifiers',$identifier)->getFirstItem();
		var_dump($col);
//		$customer = Mage::getSingleton('customer/session')->getCustomer();
//		var_dump($customer->getData());
//
//		foreach(Mage::getModel('customer/customer')->getCollection()
//				->addAttributeToSelect('*') as $customer)
//		{
//			var_dump($customer->getData());
//			echo "<hr/>";
//		}
	}

	public function testAction() {
		Mage::getSingleton('engage/session')->setLoginRequest('test');
		var_dump(Mage::getSingleton('engage/session')->getLoginRequest());
	}

}