<?php

class Janrain_Engage_Model_Resource_Eav_Mysql4_Setup extends Mage_Eav_Model_Entity_Setup {

	
	public function getDefaultEntities() {
		return array(
			'customer' => array(
				'entity_model' => 'customer/customer',
				'table' => 'customer/entity',
				'increment_model' => 'eav/entity_increment_numeric',
				'increment_per_store' => false,
				'attributes' => array(
					'engage_identifier' => array(
						'type' => 'varchar',
						'input' => 'text',
						'label' => 'Engage Identifier',
						'visible' => true,
						'required' => false,
						'position' => 69,
					),
				),
			),
		);
	} 

}