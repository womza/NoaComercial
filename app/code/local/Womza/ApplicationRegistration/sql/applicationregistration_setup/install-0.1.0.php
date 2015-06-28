<?php
$installer = $this;
$installer->startSetup();
$installer->run("
-- DROP TABLE IF EXISTS {$this->getTable('applicationregistration')};
CREATE TABLE {$this->getTable('applicationregistration')} (
  `applicationregistration_id` int(11) unsigned NOT NULL auto_increment,
  `name` varchar(500) NOT NULL,
  `location` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `comment` text NOT NULL,
  `checked` tinyint(1) DEFAULT 0 NOT NULL,
  `created_time` datetime,
  PRIMARY KEY (`applicationregistration_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
$installer->endSetup();