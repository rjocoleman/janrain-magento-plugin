<?php

$installer = $this;

$installer->addAttribute('customer', 'engage_identifier', array(
	'type' => 'varchar',
	'input' => 'text',
	'label' => 'Engage Identifier',
	'visible' => true,
	'required' => false,
	'position' => 69,
));