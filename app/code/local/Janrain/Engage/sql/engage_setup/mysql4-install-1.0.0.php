<?php

$installer = $this;

$installer->startSetup();
$installer->run("
CREATE TABLE `{$installer->getTable('engage_identifiers')}` (
  `engage_identifier_id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) NOT NULL,
  `customer_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`engage_identifier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
");
$installer->endSetup();
