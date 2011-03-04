<?php
class Janrain_Engage_Helper_Identifiers extends Mage_Core_Helper_Abstract {

	/**
	 * Assigns a new identifier to a customer
	 *
	 * @param int $customer_id
	 * @param string $identifier
	 */
	public function save_identifier($customer_id, $identifier) {

		/**
		 * Make sure we have a valid customer_id
		 *
		 */
		$customer = Mage::getModel('customer/customer')
			->getCollection()
			->addFieldToFilter('entity_id', $customer_id)
			->getFirstItem();
		if(!$customer->getId())
			Mage::throwException('Invalid Customer ID');

		/**
		 * Make the save
		 *
		 */

		try {
			Mage::getModel('engage/identifiers')
					->setIdentifier($identifier)
					->setCustomerId($customer_id)
					->save();
		}
		catch (Exception $e) {
			echo "Could not save: " . $e->getMessage() . "\n";
		}

	}

	/**
	 * Gets a customer by identifier
	 *
	 * @param string $identifier
	 * @return Mage_Customer_Model_Customer
	 */
	public function get_customer($identifier) {
		$customer_id = Mage::getModel('engage/identifiers')
						->getCollection()
						->addFieldToFilter('identifier', $identifier)
						->getFirstItem();

		$customer_id = $customer_id->getCustomerId();
		if((int) $customer_id > 0) {
			$customer = Mage::getModel('customer/customer')
						->getCollection()
						->addFieldToFilter('entity_id', $customer_id)
						->getFirstItem();
			return $customer;
		}

		return false;
	}

	

}