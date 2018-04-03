#
# TABLE STRUCTURE FOR: add_transfer
#

DROP TABLE IF EXISTS `add_transfer`;

CREATE TABLE `add_transfer` (
  `trans_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_rjo` int(11) NOT NULL,
  `trans_grade` varchar(10) NOT NULL,
  `trans_profit` float(10,3) NOT NULL,
  `trans_weight` float(10,3) NOT NULL,
  `trans_stone` float(10,3) NOT NULL,
  `trans_total_weight` float(20,3) NOT NULL,
  `trans_stonecost` float(20,3) NOT NULL,
  `trans_totalother` float(20,3) NOT NULL,
  `trans_day_price` float(20,3) NOT NULL,
  `trans_grade_` float(20,3) NOT NULL,
  `trans_grade_minimum` float(20,3) NOT NULL,
  `item_name` varchar(40) NOT NULL,
  `item_id` int(11) NOT NULL,
  `trans_note` varchar(200) NOT NULL,
  `t_date_creation` date NOT NULL,
  PRIMARY KEY (`trans_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: appointments
#

DROP TABLE IF EXISTS `appointments`;

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` int(11) NOT NULL,
  `from` datetime NOT NULL,
  `to` datetime NOT NULL,
  `customer_id` int(11) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `service_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `payment_method` int(11) NOT NULL,
  `paid` float NOT NULL,
  `balance` float NOT NULL,
  `notes` text NOT NULL,
  `created_by` int(11) NOT NULL,
  `status` enum('pending','active','reject') NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: bakery_sale_items
#

DROP TABLE IF EXISTS `bakery_sale_items`;

CREATE TABLE `bakery_sale_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bakery_sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` float NOT NULL,
  `issued_qty` int(11) NOT NULL,
  `return_qty` int(11) NOT NULL,
  `sold_qty` int(11) NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: bakery_sales
#

DROP TABLE IF EXISTS `bakery_sales`;

CREATE TABLE `bakery_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `sale_datetime` datetime NOT NULL,
  `sales_person_id` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `session` enum('morning','evening') COLLATE utf8_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` double(11,2) NOT NULL,
  `total_items` int(11) NOT NULL,
  `cash` float NOT NULL,
  `credit` float NOT NULL,
  `settled_amount` double(11,2) NOT NULL,
  `short_amount` float NOT NULL COMMENT '1: Sales, 2: Return',
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` enum('partial','complete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'partial',
  `sid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: bank_accounts
#

DROP TABLE IF EXISTS `bank_accounts`;

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_number` varchar(30) NOT NULL,
  `bank` varchar(30) NOT NULL,
  `branch` varchar(30) NOT NULL,
  `current_balance` float NOT NULL,
  `is_visible` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `bank_accounts` (`id`, `account_number`, `bank`, `branch`, `current_balance`, `is_visible`, `created_by`, `user_id`, `created`) VALUES ('1', '67859742', 'Sampath Bank', 'Malabe', '0', '1', '36', '36', '2017-07-02 21:21:32');


#
# TABLE STRUCTURE FOR: bank_transfers
#

DROP TABLE IF EXISTS `bank_transfers`;

CREATE TABLE `bank_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `bank_from` varchar(100) NOT NULL,
  `bank_to` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `payment_method` int(11) NOT NULL,
  `reference` text NOT NULL,
  `document` text NOT NULL,
  `is_visible` tinyint(4) NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: bill_numbering
#

DROP TABLE IF EXISTS `bill_numbering`;

CREATE TABLE `bill_numbering` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `auto_number_change` varchar(255) NOT NULL DEFAULT '0',
  `change_daily` varchar(255) NOT NULL DEFAULT '0',
  `change_weekly` varchar(255) NOT NULL DEFAULT '0',
  `change_monthly` varchar(255) NOT NULL DEFAULT '0',
  `change_yearly` varchar(255) NOT NULL DEFAULT '0',
  `sales_invoice` varchar(255) NOT NULL DEFAULT '0',
  `pos_bill` varchar(255) NOT NULL DEFAULT '0',
  `current_year` varchar(255) NOT NULL DEFAULT '0',
  `current_month` varchar(255) NOT NULL DEFAULT '0',
  `current_day` varchar(255) NOT NULL DEFAULT '0',
  `enter_starting_number` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0=active, 1=inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: brand
#

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modefied_by` int(11) DEFAULT NULL,
  `last_modefied_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=active , 1= inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: brand_suppliers
#

DROP TABLE IF EXISTS `brand_suppliers`;

CREATE TABLE `brand_suppliers` (
  `brand_id_fk` int(11) NOT NULL,
  `supplier_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: category
#

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `category` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('9', 'Services', '1', '2016-12-01 00:00:00', '1', '2016-12-01 00:00:00', '1');
INSERT INTO `category` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('12', 'Non-Inventory Items', '6', '2017-01-05 15:03:35', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `category` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('20', 'Fuel', '36', '2017-05-28 11:48:47', '36', '2017-06-04 16:14:02', '1');
INSERT INTO `category` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('21', 'Other items', '36', '2017-05-30 01:22:16', '36', '2017-06-04 14:37:37', '1');


#
# TABLE STRUCTURE FOR: ci_sessions
#

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('75c0e7c87ef9264700a12136169b6a85d1cc605a', '103.232.125.179', '1500645677', '__ci_last_regenerate|i:1500645665;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('cc5f33cc3dbd80183be2d3ec3b5f7b26d7be0c32', '103.232.125.179', '1500647702', '__ci_last_regenerate|i:1500647702;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a6a3d1942134aff01458a421527d1f7d45c8d11e', '13.76.241.210', '1500647717', '__ci_last_regenerate|i:1500647717;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0c67128689c6c28e305b81765f199d85e0647fc0', '23.99.101.118', '1500647718', '__ci_last_regenerate|i:1500647718;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3975137f4fbb92197e2b9e74fa9f4afc769e0605', '112.135.7.15', '1500647822', '__ci_last_regenerate|i:1500647750;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2d01fa196131e12349e5cb233a6d75f147187ac9', '112.135.7.15', '1500649007', '__ci_last_regenerate|i:1500648906;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b9f7d983e26ddf85c0d164835c710a2b14f775e8', '112.135.7.15', '1500649374', '__ci_last_regenerate|i:1500649374;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('98fd68acee86427c411e76edadb216a68da30e25', '113.59.202.119', '1500683075', '__ci_last_regenerate|i:1500683051;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('690a90f81646cff83a7dd4a7db6556c834fb980c', '112.135.0.20', '1500684075', '__ci_last_regenerate|i:1500683794;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f08683b9261adc3e31c9c0301ee7f4526c0f1adb', '112.135.0.20', '1500684302', '__ci_last_regenerate|i:1500684104;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('89c8cbdbfb8bc0d5e154cbca9f5d88db387e541d', '112.135.0.20', '1500684625', '__ci_last_regenerate|i:1500684482;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c5d94487f3e62dc1f0757636afb1e709f028284b', '112.135.0.20', '1500690162', '__ci_last_regenerate|i:1500690150;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('51b7c09c24bf9a38fb1e63584fc03e2639b3aaed', '103.232.125.36', '1500697041', '__ci_last_regenerate|i:1500696907;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7270eeefc045c086c1947d9ae4309b426c09b14b', '103.232.125.36', '1500698777', '__ci_last_regenerate|i:1500698569;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ba015d761dd0e3570042889ec51ddd713c38c854', '13.76.241.210', '1500701074', '__ci_last_regenerate|i:1500701074;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('92ab7301904afe3bf506833d8bd03d4622af0e79', '23.99.101.118', '1500701075', '__ci_last_regenerate|i:1500701075;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('eac8a2a039bf00e1f41fc3b291ec17b1cdc46658', '103.232.125.36', '1500702039', '__ci_last_regenerate|i:1500701737;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3440bf63573bc6eda0d95541d02857dba146e3b0', '113.59.200.19', '1500704401', '__ci_last_regenerate|i:1500704392;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('df54fff511e40eaa3b5336d761d95a824cc17737', '103.232.125.36', '1500704674', '__ci_last_regenerate|i:1500704626;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e85ccbff1ef3d3725eb090517e7685891e61752b', '103.232.125.36', '1500705136', '__ci_last_regenerate|i:1500705052;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8d04baea02aa2502f8b0aa30906fcf61e840a7d3', '113.59.200.19', '1500717555', '__ci_last_regenerate|i:1500717521;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('99d6342cbbdd861e3424a215c99a1e513079ecdd', '113.59.203.140', '1500776452', '__ci_last_regenerate|i:1500776418;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('86deb2463861ad788b1b2d56cb077b2ac37f365e', '113.59.203.140', '1500779426', '__ci_last_regenerate|i:1500779383;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f95e5cd316a6b03b309e38402f9754fe643cf487', '123.231.110.96', '1500802267', '__ci_last_regenerate|i:1500802191;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1b0943019c1110de4d9f74943772d094c4b22b8e', '123.231.110.96', '1500831056', '__ci_last_regenerate|i:1500831056;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('20b93f0d1db28507d73dff7f493c5d49430beed8', '103.232.125.27', '1500870723', '__ci_last_regenerate|i:1500870564;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3408a4d21b3e65b5b2758d78fb2997d7a04dc082', '103.232.125.27', '1500871334', '__ci_last_regenerate|i:1500871334;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ab99aa078a3eadf6db38f4172e2787d88ec64a15', '103.232.125.27', '1500871334', '__ci_last_regenerate|i:1500871334;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c4ab94c98f16a8f5bece11bd4afbbc39b51b437c', '175.157.57.15', '1500874794', '__ci_last_regenerate|i:1500874533;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6ff9a420dca217a165a76a0030420d7f42e36598', '103.232.125.27', '1500874704', '__ci_last_regenerate|i:1500874679;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('906f95145623d394887f3d219cc23f61c234ed68', '112.134.16.242', '1500874839', '__ci_last_regenerate|i:1500874839;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fcd189645f2196b0423d6f525702514b7ce3a09e', '103.232.125.27', '1500875778', '__ci_last_regenerate|i:1500875756;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5c165943261c868662acb596172a873d279c9ac0', '103.232.125.27', '1500876419', '__ci_last_regenerate|i:1500876172;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7e5a3a431476117d2bd0ca2674beb9bc22d63d9e', '23.99.101.118', '1500876762', '__ci_last_regenerate|i:1500876762;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('327e47063e7fa537534241b204cf1ba6e13eaa89', '103.232.125.27', '1500881621', '__ci_last_regenerate|i:1500881621;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('238793d819174a1a67af0ef74833da6cdfa432e8', '113.59.201.39', '1500886411', '__ci_last_regenerate|i:1500886411;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('72018fec9af575d0c1c9100745da567ea3934b9c', '13.76.241.210', '1500886565', '__ci_last_regenerate|i:1500886565;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3ccac95ff92f03cc85a718afa079cd8834314ff8', '113.59.201.39', '1500887066', '__ci_last_regenerate|i:1500887061;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('470bc4069df79cf7db8bf215bc2b3da0a1a197f1', '103.232.125.27', '1500890299', '__ci_last_regenerate|i:1500890254;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4bba221152fe813b4bbfbfdd1237c992b18d7b26', '123.231.127.73', '1500890734', '__ci_last_regenerate|i:1500890733;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('95b446551ae5d4383c5a5fac3d6c8a41f97d864d', '113.59.201.39', '1500893059', '__ci_last_regenerate|i:1500892775;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5d3aac976a4a960330b31ba9dbce4b89e7dbb56b', '113.59.201.39', '1500893292', '__ci_last_regenerate|i:1500893187;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bfcba64030be4871e304ee6c2104684be63f2516', '103.232.125.27', '1500897858', '__ci_last_regenerate|i:1500897772;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('99f3f539fbffbde30ec3882bd0f1cc90d0c16af6', '123.231.122.127', '1500903991', '__ci_last_regenerate|i:1500903991;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('af0f4f1e03cb9a22c88972933a32f7808336be59', '103.232.125.27', '1500905018', '__ci_last_regenerate|i:1500905017;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('01bced7c940b826a96d2da66ee074ca624c2941f', '103.232.125.27', '1500906488', '__ci_last_regenerate|i:1500906488;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d975358d4997bb2c853650224a6eb4e070154ed9', '113.59.202.252', '1500911965', '__ci_last_regenerate|i:1500911917;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('be9681b930a694c443ac4a835c8e58e7de9ee014', '113.59.202.252', '1500913499', '__ci_last_regenerate|i:1500913488;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('726d5b13c3fee3f50f5b025e677256f698d154cd', '103.232.125.254', '1500971035', '__ci_last_regenerate|i:1500971029;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e57519ccce4bbe161453d5475e2464bed67d0524', '113.59.203.137', '1500972295', '__ci_last_regenerate|i:1500972295;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5c16e2292e74d7011ce6bf654285db2e5d137b1d', '103.232.125.254', '1500973333', '__ci_last_regenerate|i:1500973333;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2641ab5e17ce3f2a6941cc81a22d439233ed590a', '113.59.203.137', '1500982499', '__ci_last_regenerate|i:1500982317;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c92730dc9f650e573bc7a96d053e55cadda59360', '103.232.125.254', '1500984199', '__ci_last_regenerate|i:1500984099;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('30178d6dc40a40fc06ea1dab203f52b3abfd940c', '113.59.203.137', '1500984593', '__ci_last_regenerate|i:1500984590;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bb570e0b5f9868ca5bbc525e8b4098a96faf3ae3', '103.232.125.254', '1500984857', '__ci_last_regenerate|i:1500984740;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('15635826879b69331909d2d4af6cf0e89ea2c245', '113.59.203.137', '1500985161', '__ci_last_regenerate|i:1500985161;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6b4331eafec0a291fbed23a70c2d71445cda8243', '113.59.203.137', '1500986493', '__ci_last_regenerate|i:1500986493;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f2c28f168fa17cc149dc158152e0ea9e743a6f52', '113.59.203.137', '1500986898', '__ci_last_regenerate|i:1500986893;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('cf0575262ec1a95799af1da46cf6787e1921ceac', '113.59.203.137', '1500987419', '__ci_last_regenerate|i:1500987376;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2906d20620a43fc8819d30b61756ea30b77e6c88', '113.59.203.137', '1500988074', '__ci_last_regenerate|i:1500987780;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('571d6e64e151f5c653ab35636a8782ceed3d05cc', '103.232.125.254', '1500988125', '__ci_last_regenerate|i:1500987903;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d2de0b97e1d532a529c9be9fddd6bcc8a05eb7d0', '113.59.203.137', '1500988284', '__ci_last_regenerate|i:1500988105;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('01e9be137483f295ef4ab99d9d9f72f36eac12c8', '103.232.125.254', '1500988458', '__ci_last_regenerate|i:1500988458;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('cd3be7679bbfa2f18dba671e22ef5de5f33d3424', '103.232.125.254', '1500988472', '__ci_last_regenerate|i:1500988472;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('aa9a1ceb7d8f39354f0e3c42b74daa4a47565d50', '113.59.203.137', '1500988858', '__ci_last_regenerate|i:1500988563;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('300dcf8eb256c5cc08ab1c1e5dae234753342ca1', '103.232.125.254', '1500989575', '__ci_last_regenerate|i:1500989534;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('54a5264ba7c01652886bd30e1db351efb32fb7b1', '23.99.101.118', '1500989569', '__ci_last_regenerate|i:1500989569;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2b1421e0ce97151401d8c23a0b0e153f5b8e5c4f', '23.99.101.118', '1500989586', '__ci_last_regenerate|i:1500989586;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f8712fc65d717f720d6aa15521a100a0d89c0647', '113.59.204.29', '1500990167', '__ci_last_regenerate|i:1500989905;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0f2d9746606a52af8605fb113f4a931fa91e02fb', '103.232.125.254', '1500990637', '__ci_last_regenerate|i:1500990360;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d0dca141ce56eb8049237855f9cdc0a7b0ac3eb9', '103.232.125.254', '1500990906', '__ci_last_regenerate|i:1500990685;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0a268de6c983a31ac894fbaf01202a567b2caf21', '103.232.125.254', '1500991552', '__ci_last_regenerate|i:1500991315;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2778d69c0ff856c4eecf49da03863b9f16adddb9', '103.232.125.254', '1500991434', '__ci_last_regenerate|i:1500991329;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7e1667dc0e401b269b03c79eba595e827bb195e8', '113.59.204.29', '1500991913', '__ci_last_regenerate|i:1500991649;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('25659b258d789ca985eb5cd53e02848ad87f3328', '103.232.125.254', '1500991777', '__ci_last_regenerate|i:1500991772;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0678083115f01294377c86461dca2f948f65e9bc', '103.232.125.254', '1500991884', '__ci_last_regenerate|i:1500991884;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2e25d775510d8c851315a7e42b5c4482b970a4c0', '113.59.204.29', '1500992050', '__ci_last_regenerate|i:1500992050;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('96842d68ecb51517e9441700ac7bfaafdd4df0b7', '113.59.204.29', '1500992745', '__ci_last_regenerate|i:1500992416;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2f931f49bc7e5d110b4285c2ecb5cb6a081d6452', '103.232.125.254', '1500992749', '__ci_last_regenerate|i:1500992662;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('873939406e67adcc4f4762aa99333d6e4666c3a3', '103.232.125.254', '1500993855', '__ci_last_regenerate|i:1500993663;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d07a9d36722b4cdac7dc6cf112fc34567ef85d30', '113.59.204.29', '1500994310', '__ci_last_regenerate|i:1500994211;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('18e64e677af45039f70538bfbd31652de9bc2116', '113.59.204.29', '1500994956', '__ci_last_regenerate|i:1500994680;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0da4b6ee2bc95c056701519e8811d013f8e5a2c1', '113.59.204.29', '1500994997', '__ci_last_regenerate|i:1500994787;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('768239bf4c624d094b0498644b25e452480b64d6', '103.232.125.254', '1500994824', '__ci_last_regenerate|i:1500994807;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('71335a6be2946a1926a750738b05ccf1e66012b7', '113.59.204.29', '1500995129', '__ci_last_regenerate|i:1500995010;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2aa5a8daaf27c1e4244e6b4e2fe956ba9c931beb', '13.76.241.210', '1500995018', '__ci_last_regenerate|i:1500995018;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8b7c513343d7dbb419cdb669a23e8a6d253a2be4', '23.99.101.118', '1500999298', '__ci_last_regenerate|i:1500999298;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1344dc88f1100e21ae9d6b9ff4a3ce5c3697708c', '103.232.127.5', '1500999442', '__ci_last_regenerate|i:1500999318;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5fc3657218cc4f77baf151901ff70804657ee4bb', '103.232.127.5', '1500999662', '__ci_last_regenerate|i:1500999662;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('45b04467431bab3a0ed84d449c51e108a5a95164', '113.59.203.21', '1501000317', '__ci_last_regenerate|i:1501000113;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6f7d15eaf73c6d789be2a90d37a2b4d287b2537a', '123.231.108.45', '1501000839', '__ci_last_regenerate|i:1501000512;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('22e4191c28339b6a32fcd7e54acd2d1ecf111e93', '103.232.127.5', '1501000744', '__ci_last_regenerate|i:1501000524;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4496acbc60d11d32ba59e8348e88ccccf61fb530', '23.99.101.118', '1501000690', '__ci_last_regenerate|i:1501000690;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('aae6b5d671cd2e29886cc8aaee7a16f764f5f11a', '123.231.108.45', '1501001117', '__ci_last_regenerate|i:1501000851;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3588a124f9a04d28163936a06429398a3d282caf', '103.232.127.5', '1501001184', '__ci_last_regenerate|i:1501000875;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bce18360ea3974c1e7ffa3dce7119db192fe90e2', '123.231.108.45', '1501001440', '__ci_last_regenerate|i:1501001165;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('08e2fc682765c2f6c97402075e8c7938171e5108', '103.232.127.5', '1501001354', '__ci_last_regenerate|i:1501001196;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7b27656b9aef64929b8d98668365c97db5f1c37f', '103.232.127.5', '1501002118', '__ci_last_regenerate|i:1501002113;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3f064a7031862d4bbba9aaf3312e757ddb0efabd', '23.99.101.118', '1501002135', '__ci_last_regenerate|i:1501002135;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7169f9ac65b6d0bad84cf3944be28fbdac0c20db', '123.231.108.45', '1501002161', '__ci_last_regenerate|i:1501002161;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('235d88cb509a1c0ed9d01a37ec8ecb23b6fff8e5', '123.231.108.45', '1501003423', '__ci_last_regenerate|i:1501003126;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('269b9486f2c15eb98aebf0f9d6046d628b42966f', '103.232.125.152', '1501042441', '__ci_last_regenerate|i:1501042427;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('afef7a77ad39599a6e353e4da9a2f736dd4d5240', '123.231.121.47', '1501042605', '__ci_last_regenerate|i:1501042569;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c8720a52d4ff207a6117d7f4939e6b012f3b79e3', '103.232.125.152', '1501042748', '__ci_last_regenerate|i:1501042746;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('780b69efbe20e8b49c5466794e8d8ab7cd73c6a9', '123.231.121.47', '1501043203', '__ci_last_regenerate|i:1501043203;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3892e76e4b6df76b5aaafc5f267a87e35baf28b1', '123.231.121.47', '1501043389', '__ci_last_regenerate|i:1501043226;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e61360eeb8aec1c063a53176d339ec4911a95fc1', '123.231.121.47', '1501044653', '__ci_last_regenerate|i:1501044625;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('89b6388f2c1b798f0f47281a78c0764bb77f2f59', '123.231.108.225', '1501048506', '__ci_last_regenerate|i:1501048473;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7e54108bde0fcc8ac335061aae9f7425a379fc21', '103.232.125.152', '1501052304', '__ci_last_regenerate|i:1501052235;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d46d89ce780719a64341bece67e8697a95c448ee', '123.231.108.225', '1501053002', '__ci_last_regenerate|i:1501052655;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9604eb1849795ad4d8e22f2a88950b70676ca40f', '123.231.108.225', '1501052748', '__ci_last_regenerate|i:1501052694;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('85078f0a7c63bf3951329b70565cdb0dcca09ac3', '123.231.108.225', '1501053026', '__ci_last_regenerate|i:1501053002;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6f02de43d0711c4277f03dd483f66cf368455513', '103.232.125.152', '1501054829', '__ci_last_regenerate|i:1501054829;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7e994e93818ef860c17c99834d8b2a2185e55da1', '113.59.203.164', '1501066851', '__ci_last_regenerate|i:1501066842;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3ed8249de05ccfcecd4f129cf9406c8d1e00d2d3', '103.232.125.152', '1501068968', '__ci_last_regenerate|i:1501068832;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";alert_msg|a:3:{i:0;s:7:\"success\";i:1;s:16:\"Add Sub Category\";i:2;s:37:\"Successfully Added Sub Category : asd\";}__ci_vars|a:1:{s:9:\"alert_msg\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3b554069f33f8468d394c32cc62dbdf99f9a2ed9', '103.232.125.152', '1501071437', '__ci_last_regenerate|i:1501071183;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('881217376f5c4b69b47cb261aa6fcd724bc98d6b', '104.45.18.178', '1501071519', '__ci_last_regenerate|i:1501071519;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ee4666c720c64a32428b77a3472efbd20043de1c', '104.45.18.178', '1501071519', '__ci_last_regenerate|i:1501071519;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('241d1124ac6cdba022d87ef20cdce20328cda5a3', '103.232.125.152', '1501071849', '__ci_last_regenerate|i:1501071687;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f44ac351eb51b9249d03884a61d19ae5af14c9a7', '175.157.37.117', '1501081174', '__ci_last_regenerate|i:1501081168;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d33e0ace028a94fad351a21757ef6639be3b15bf', '103.232.126.101', '1501128996', '__ci_last_regenerate|i:1501128891;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0a4a10c788fc765af36b8c884950c7e8ec887df5', '103.232.126.101', '1501131648', '__ci_last_regenerate|i:1501131386;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f81ac60f569189d7b28861bb625743c698366625', '103.232.126.101', '1501131944', '__ci_last_regenerate|i:1501131783;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5e4a61899cac101b0d969c47eec57810983b65c5', '104.45.18.178', '1501131959', '__ci_last_regenerate|i:1501131959;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5e6431433937b55858bab75eeba38c719adc086f', '23.99.101.118', '1501131991', '__ci_last_regenerate|i:1501131991;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bbbe049d01f238ee934bf513fa6dbe2dec6d0a51', '103.232.126.101', '1501132291', '__ci_last_regenerate|i:1501132287;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b002a3257bb280405620757097e9cdf19f1b3022', '113.59.199.94', '1501134532', '__ci_last_regenerate|i:1501134532;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('16417696f54a5de264b075f2dc37729df8f925a7', '113.59.199.94', '1501134534', '__ci_last_regenerate|i:1501134534;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ae5b045174b2d045b2eb10e92fa1bda1e081825c', '113.59.199.94', '1501135180', '__ci_last_regenerate|i:1501135167;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0d2b75a5d21f83296f12e406825dd1e0e67de703', '113.59.199.94', '1501136053', '__ci_last_regenerate|i:1501136053;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d276eb2ac40e16de7cf051bc6b09186db5474e59', '113.59.199.94', '1501137459', '__ci_last_regenerate|i:1501137459;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1ad080a6085bdf59adb3dc87be2a43409a929acc', '103.232.126.101', '1501139461', '__ci_last_regenerate|i:1501139458;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('118c5e2436ab93870ae8b791a3e164d375b7ffb4', '113.59.199.94', '1501141629', '__ci_last_regenerate|i:1501141380;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3491257bc0ec30ba3652956d4d532d2370a43926', '103.232.126.101', '1501144754', '__ci_last_regenerate|i:1501143155;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b7070b9432ef1ab204bcc99c575f345339b8c653', '103.232.126.101', '1501144781', '__ci_last_regenerate|i:1501144757;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b61932b3ca1557c433900e7d1df05c5b8c2b4ad6', '113.59.199.94', '1501146120', '__ci_last_regenerate|i:1501146100;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('afe6b297a84ccf75b4053e118ef2721c1d96d78b', '113.59.199.94', '1501146198', '__ci_last_regenerate|i:1501146122;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9313ce7a91f136c667721fe32591a439aaa30bca', '113.59.199.94', '1501155826', '__ci_last_regenerate|i:1501153815;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5ea37faa16dd20190b5f86c888a17d5fdd0397c0', '113.59.199.94', '1501155829', '__ci_last_regenerate|i:1501155829;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('113b45664435a6eae1c81a13557dce5940c680db', '112.135.5.36', '1501163885', '__ci_last_regenerate|i:1501163885;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bbdf73b1484d08841b572311e4f776f85910a829', '113.59.201.253', '1501163902', '__ci_last_regenerate|i:1501163902;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('187a156cced9cd2fd5422a456d644297438c78e0', '113.59.201.253', '1501164274', '__ci_last_regenerate|i:1501164243;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c48c0e425da545c5df936e7066b8fea90a4a71d7', '113.59.201.253', '1501170304', '__ci_last_regenerate|i:1501170244;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ed27c30f99ea4ea6877b0c5d72d8e714006f9fa1', '113.59.203.16', '1501202197', '__ci_last_regenerate|i:1501202195;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bf4c9ed60fd08b37c430217f67a68418f1cdcb73', '113.59.203.16', '1501205880', '__ci_last_regenerate|i:1501205863;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d8627438c07fd7e9298f1ae8ed706ef0ee068243', '113.59.203.16', '1501206591', '__ci_last_regenerate|i:1501206589;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e4624eddcd7aec0139a05d79ce193ce4a4ca8b53', '103.232.125.188', '1501219414', '__ci_last_regenerate|i:1501219414;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b87b3e5086572e0e395db295bc6539c5da2e1fdb', '113.59.202.124', '1501221873', '__ci_last_regenerate|i:1501221864;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2e5aa5e5eb04818bca05d82a6aa5d621f0ec631d', '103.232.125.188', '1501224427', '__ci_last_regenerate|i:1501224321;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f06b7415289c5ef5698576f8bad80cd4ab99bd03', '103.232.125.188', '1501235757', '__ci_last_regenerate|i:1501235461;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f359ec587335f9d6730817b241f47349984bfd90', '23.101.61.176', '1501235477', '__ci_last_regenerate|i:1501235477;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e5e1a59a28a726ecd7aa87855e1eaa914ad2a40a', '103.232.125.188', '1501235785', '__ci_last_regenerate|i:1501235489;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('67d77d648211311e80c36a920b082a61f80c27ff', '103.232.125.188', '1501235899', '__ci_last_regenerate|i:1501235780;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('819927930df70976bac8d9c4bd625bd24ef2e0c0', '103.232.125.188', '1501235793', '__ci_last_regenerate|i:1501235793;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6073c0794fbdd3d2919480c63f9a7cd732b06287', '103.232.125.188', '1501235793', '__ci_last_regenerate|i:1501235793;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6841e46ecc7d3f08f1b2dbbd2d9a039eb7e6f5b7', '103.232.125.188', '1501235892', '__ci_last_regenerate|i:1501235795;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a82881d91d7ca4dd86f81c9702b34ecd8703137c', '103.232.125.188', '1501236134', '__ci_last_regenerate|i:1501236134;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4d95c13385f78941da25bbfa0290730c5b206f90', '103.232.125.188', '1501237932', '__ci_last_regenerate|i:1501237747;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9449a444522d6686a0f624e86cfce23f423d21f6', '123.231.125.253', '1501260654', '__ci_last_regenerate|i:1501260388;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('06f55e887c9947926bcd59784e00249bd071e1f0', '123.231.125.253', '1501258625', '__ci_last_regenerate|i:1501258605;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('56eac7e8c56fbd53dc32d317661ebf4ce41f9f99', '113.59.205.66', '1501287827', '__ci_last_regenerate|i:1501287590;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('337cbc81999610f1394e35a06530011166e4e862', '113.59.205.66', '1501288387', '__ci_last_regenerate|i:1501288089;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('80816e42448bc76c8cf564ad87500fa8df9ba327', '113.59.205.66', '1501288667', '__ci_last_regenerate|i:1501288451;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8ce495172c7fa96bbb1b0808f17c98ac76fae33c', '113.59.205.66', '1501289023', '__ci_last_regenerate|i:1501288803;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9ab780f3e39f2565bed02dfb01223805bb495132', '113.59.205.66', '1501289595', '__ci_last_regenerate|i:1501289373;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6eb2f167b096b81b6f184d27e1f7f1a938edb2c4', '113.59.205.66', '1501290854', '__ci_last_regenerate|i:1501290854;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('09f7a9ee03a505a1c006ee2afae098cb0e6cac5b', '113.59.205.66', '1501297040', '__ci_last_regenerate|i:1501297040;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c57dc54a2cee8898de3d24d2c33133c1be7c335f', '103.232.125.10', '1501303725', '__ci_last_regenerate|i:1501303630;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('056cfafaef23e0d809b646ccdae5c8d4bb749bab', '23.101.61.176', '1501303736', '__ci_last_regenerate|i:1501303736;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3aa1108c0eaa9dee757d36ff2b09f8ecda77ee56', '123.231.104.223', '1501311651', '__ci_last_regenerate|i:1501311634;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1a77f7eea660b736c3fea9efc955991bed4765fa', '123.231.104.223', '1501313567', '__ci_last_regenerate|i:1501313567;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3b5441c0cf6ec62de9fd40dcb77bdeb31eca4c34', '123.231.104.223', '1501313913', '__ci_last_regenerate|i:1501313913;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7d01cc99829f1050dafbc9512f58a30902c3dc16', '13.76.241.210', '1501315629', '__ci_last_regenerate|i:1501315629;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('82b37cc91df5e6742f28d0fa0a52a2a917169b7d', '123.231.104.223', '1501315963', '__ci_last_regenerate|i:1501315934;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6eac2e726cbea73e4d48eced56f434f3a49b69f4', '103.232.125.10', '1501321831', '__ci_last_regenerate|i:1501321798;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('33016c0f96f942b4431759653f6c3b0bc08ea05f', '103.232.125.10', '1501328159', '__ci_last_regenerate|i:1501328159;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fbb4035a393138f2cdc9c7065852a5bf1df3b635', '104.45.18.178', '1501331676', '__ci_last_regenerate|i:1501331676;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('57d9c70882feb9851b02ca3222dfdbdaa23eac1a', '104.45.18.178', '1501331676', '__ci_last_regenerate|i:1501331676;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f29086e6a7fec86925492de4fab2be135118e8e4', '104.45.18.178', '1501331676', '__ci_last_regenerate|i:1501331676;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3875dd2bdcd218e67e3a0e185875c2c9d414154d', '103.232.125.10', '1501333645', '__ci_last_regenerate|i:1501333645;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('65e5cf9c335f19fc42cdbd12507b0496a88dcc5e', '123.231.123.83', '1501344014', '__ci_last_regenerate|i:1501344013;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('391f8537c3e311092bb11759227a3a2f86d5822d', '113.59.199.191', '1501371470', '__ci_last_regenerate|i:1501371368;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6801e02d44240ee52a4402f2dc610293fa939aac', '113.59.199.191', '1501404655', '__ci_last_regenerate|i:1501404651;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('148db49a0a9eaf35acadb524d403d0ee164f25ce', '113.59.199.191', '1501431868', '__ci_last_regenerate|i:1501431868;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('afa7c27e28ddf3add63d82409404290cd8194d6e', '113.59.199.191', '1501469787', '__ci_last_regenerate|i:1501469787;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d69909565798c28c9a6c99e0a99422f12e801f79', '113.59.199.191', '1501475163', '__ci_last_regenerate|i:1501475148;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f8d8fce3b4ec76b5dd12586b1f4cb29a470f115c', '113.59.199.191', '1501476203', '__ci_last_regenerate|i:1501475864;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f8761da4ec339642f1ae49f478a77407d52ab974', '113.59.199.191', '1501476427', '__ci_last_regenerate|i:1501476232;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3918b9df81e2b6327b5cce956bff9f8b366ed1e7', '113.59.199.191', '1501476740', '__ci_last_regenerate|i:1501476630;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d11f3ff79fceaa8ba5daff26f0cf1d9899b60a2d', '113.59.199.191', '1501476995', '__ci_last_regenerate|i:1501476991;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('60043cfdb8025dee5e41d946a854a891d25345bc', '113.59.199.191', '1501477585', '__ci_last_regenerate|i:1501477576;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4ba50854c6bac9192cd9635142e1831a98a0c699', '113.59.199.191', '1501478400', '__ci_last_regenerate|i:1501478102;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9629b329164d23e84723d8fa44adf2931eeb615c', '113.59.199.191', '1501478924', '__ci_last_regenerate|i:1501478616;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c0613cf5ec97bdb9ca8f89fb02e83aa4e00e4de3', '113.59.199.191', '1501478942', '__ci_last_regenerate|i:1501478662;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1140733b47aceabcfba25c0a6da7311509c1d120', '113.59.199.191', '1501479130', '__ci_last_regenerate|i:1501478934;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('17ad1e8ba6601c96230b43836070cc80754015ce', '113.59.199.191', '1501478974', '__ci_last_regenerate|i:1501478974;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3ca0322da10374dfc9ca8fb6c1d86fb047b6fc2b', '103.232.125.39', '1501479512', '__ci_last_regenerate|i:1501479230;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0b0b99b725543fc0696cf6f87eedd639e723b3ac', '113.59.199.191', '1501479657', '__ci_last_regenerate|i:1501479366;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e12174a0e38364f2525c49afc1a945fd1157e86b', '113.59.199.191', '1501479717', '__ci_last_regenerate|i:1501479439;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('dce52efec4df6c52b02bddd28ba6ac2b3ccc0cf3', '113.59.199.191', '1501479857', '__ci_last_regenerate|i:1501479784;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('141916b48c869cf256ccb35cbf2bc1c12593cf1b', '113.59.199.191', '1501479753', '__ci_last_regenerate|i:1501479672;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('02303ffe16584c771f7180549662efb50fdeda9d', '113.59.199.191', '1501480251', '__ci_last_regenerate|i:1501480225;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6051c151c354e009369b1b5f99fd2a3f50efc1a9', '113.59.199.191', '1501480304', '__ci_last_regenerate|i:1501480229;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0ccef12f3c700ae3891eba9a620264fd38469c5a', '103.232.125.39', '1501484653', '__ci_last_regenerate|i:1501484653;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('aa75b0884bd57acaf17ee3eafec770271547467a', '113.59.199.191', '1501486784', '__ci_last_regenerate|i:1501486762;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('052ab5ef6668566146699d64a1005940cd4977a5', '113.59.199.191', '1501488374', '__ci_last_regenerate|i:1501488348;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('cdd4aa8a7b8156eb57ff80b8e6e9a238b39f92be', '113.59.199.191', '1501489399', '__ci_last_regenerate|i:1501489394;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a40084535c06e3a5de20d1f832adae6d1faa3f11', '103.232.125.39', '1501491144', '__ci_last_regenerate|i:1501491140;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a5d3f5be9012938e35279a53288b3afd9237bd5a', '113.59.199.191', '1501492433', '__ci_last_regenerate|i:1501492362;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ed5c1065f5af26b3742b10ac074d16931abd91d7', '113.59.199.191', '1501492804', '__ci_last_regenerate|i:1501492755;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8ee5c0a067f8b34b0ba10ac082fcfb0f372cc7d3', '103.232.125.39', '1501499285', '__ci_last_regenerate|i:1501499116;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ed8d168ad6f3aec81ad6f373251ae3a94b40b939', '113.59.199.191', '1501499750', '__ci_last_regenerate|i:1501499720;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a3a51e214f89f3342fc31b76e76eeb495a2e2036', '103.232.125.39', '1501499807', '__ci_last_regenerate|i:1501499806;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:29:\"Customer Added Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('642c39a555148578d1b0b6375cfe32f0eee57a5e', '103.232.125.39', '1501500206', '__ci_last_regenerate|i:1501500206;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a431e7ecb2bc9cc711bbb541eccaa01fc95d8a8c', '113.59.199.191', '1501500446', '__ci_last_regenerate|i:1501500421;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ca60f8d45b8fe97f774f67f18d412a730df5c331', '113.59.199.191', '1501501188', '__ci_last_regenerate|i:1501500918;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8f707b635400adead0cbc1d49e8ee5861b91258e', '23.99.101.118', '1501501059', '__ci_last_regenerate|i:1501501059;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('edca5366bbfb59a86530dd4df9366810fd8b8263', '23.101.61.176', '1501501060', '__ci_last_regenerate|i:1501501060;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5dfd4457c6b7cc91a080857fa103618d1df023fc', '113.59.199.191', '1501501876', '__ci_last_regenerate|i:1501501858;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a4d344651cbaad1f1b6cfc18d13308247bb92a2b', '113.59.199.191', '1501502171', '__ci_last_regenerate|i:1501502155;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c634bc954871dc17afcc656c2b6a613eabeb59be', '103.232.125.39', '1501502174', '__ci_last_regenerate|i:1501502161;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('150a27c2d6f61ea3856c3c4339620422514be33a', '113.59.199.191', '1501502959', '__ci_last_regenerate|i:1501502864;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1f43380e20b0f4843170f94180a9eaf3823d3b3a', '113.59.199.191', '1501506065', '__ci_last_regenerate|i:1501506064;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c129e2f264539ba02e2853f1457a331ec1a4c248', '113.59.199.191', '1501506372', '__ci_last_regenerate|i:1501506372;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3dafc668f0aa0e7c3e4e6b378095082849be0dab', '103.232.125.39', '1501509127', '__ci_last_regenerate|i:1501509099;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0c8f172d6ab0ee00866add1369b445aa21386275', '113.59.199.191', '1501510078', '__ci_last_regenerate|i:1501509824;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3a06e204f92e1c264a53e13fdf0e0feefaae528f', '113.59.199.191', '1501510412', '__ci_last_regenerate|i:1501510146;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6ce72e1f6506566381bdb968a0261fc2457a8631', '123.231.110.139', '1501511635', '__ci_last_regenerate|i:1501511578;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('15da43bc57f229da8358ad2c671927ad7e275e2d', '103.232.125.39', '1501512212', '__ci_last_regenerate|i:1501512212;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8a501dad2536d9c9ff7d08070c915338628ac3f4', '113.59.199.191', '1501513460', '__ci_last_regenerate|i:1501513359;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('478b16024aadfee5c624bf129f002bcacce8ad8f', '123.231.123.29', '1501551719', '__ci_last_regenerate|i:1501551453;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('13d38f548e570f9aca997fbe80b87b4455f0ab4b', '123.231.123.29', '1501552173', '__ci_last_regenerate|i:1501552173;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1d518837fb1557975de9db3667e05c251dbcdd21', '103.232.126.14', '1501561969', '__ci_last_regenerate|i:1501561807;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1013e5c0d07121cc831590367c4118037aefadba', '123.231.122.89', '1501561992', '__ci_last_regenerate|i:1501561978;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('92bca7379a7eef13433c3e8f4b1fec5810bf8308', '13.76.241.210', '1501562012', '__ci_last_regenerate|i:1501562012;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('197f8d5c11f62fd1ea9f611afcf4aa6b9e4283df', '23.101.61.176', '1501562014', '__ci_last_regenerate|i:1501562014;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('10fe0b393d10e3d42f34a3837435c89d59e7a18f', '103.232.126.14', '1501562266', '__ci_last_regenerate|i:1501562172;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7718ee84f24b3a31cbb494aa5556f208623d8be4', '123.231.122.89', '1501562529', '__ci_last_regenerate|i:1501562529;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('91c145edb112d49878f728b134fcc462ae650f27', '112.135.33.162', '1501564387', '__ci_last_regenerate|i:1501564228;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9379ce8ae40daf54838a552f864fd126f3d933c4', '103.232.126.14', '1501564421', '__ci_last_regenerate|i:1501564417;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ebce2ea052da4e0013faa630d26e184617385512', '123.231.122.89', '1501565887', '__ci_last_regenerate|i:1501565879;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('149f79c41bd69d6eb960f587198def277fcfff76', '103.232.126.14', '1501566045', '__ci_last_regenerate|i:1501566045;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('703a47beb99fe84e93bafefea1d2a92b45018a18', '103.232.126.14', '1501566485', '__ci_last_regenerate|i:1501566287;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b72d6c3cdbc9513548f9d7236332206317ac59ba', '123.231.122.89', '1501566378', '__ci_last_regenerate|i:1501566321;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fcc98120142998e17dde8ef48025bd7a12d5a279', '103.232.126.14', '1501566371', '__ci_last_regenerate|i:1501566348;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5d1c2da3ec50ea7a394113f2ee6fc62970cafb4e', '13.76.241.210', '1501566369', '__ci_last_regenerate|i:1501566369;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b89c7ba5fcce5086b949152768425ce65dea62b9', '104.45.18.178', '1501566376', '__ci_last_regenerate|i:1501566376;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3698cea48c141c4b129e2a19ddd9d531e51b03cf', '23.101.61.176', '1501566397', '__ci_last_regenerate|i:1501566397;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c263691a90327e0738bdc6702dd8056a9e1b34df', '103.232.126.14', '1501566632', '__ci_last_regenerate|i:1501566623;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6c813b9752814c9a4492318358eacb0e0a225752', '123.231.122.89', '1501567188', '__ci_last_regenerate|i:1501567028;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('67945f0a504890125a455ad6dda8cfe6f86e9f40', '103.232.126.14', '1501567171', '__ci_last_regenerate|i:1501567147;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4a92b7d9abd76b3baf589b26bff04ad60d6a4a1f', '104.45.18.178', '1501567240', '__ci_last_regenerate|i:1501567240;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('91242465e98f6b09ad7288b2f9775f738e735e47', '104.45.18.178', '1501567240', '__ci_last_regenerate|i:1501567240;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6255d95eae147ac680662957c86452257275d35c', '112.135.38.156', '1501567393', '__ci_last_regenerate|i:1501567263;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ea98953e454a299ae37fac073d7b2047baeebb31', '103.232.126.14', '1501567504', '__ci_last_regenerate|i:1501567276;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2a0f571a961fb858ded1750ddb3f5cd14376625b', '123.231.122.89', '1501567682', '__ci_last_regenerate|i:1501567423;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('41e9d31fd390e707cfa63042418d9ed37c1afa7e', '13.76.241.210', '1501567389', '__ci_last_regenerate|i:1501567389;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('cc3ffcb328d144d50a28d0eaa783bf81c827807e', '103.232.126.14', '1501567857', '__ci_last_regenerate|i:1501567679;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('aed6fdefbf047b43e1df0b6b86ea893373d83404', '123.231.122.89', '1501567727', '__ci_last_regenerate|i:1501567726;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('5f0087d44ba75fa8cf6a22d9957f6c579ffd1879', '123.231.122.89', '1501568053', '__ci_last_regenerate|i:1501568053;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('73e9b864ff1519f5f4f5cc6e7406d9a64f78d168', '103.232.126.14', '1501568369', '__ci_last_regenerate|i:1501568369;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f2850e127b526a8670bb668b1596c477d909e182', '123.231.122.89', '1501568917', '__ci_last_regenerate|i:1501568911;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bb9caa8d2eedc03aa15e8a08fed327312d6f0703', '103.232.126.14', '1501569306', '__ci_last_regenerate|i:1501569102;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('9fd4ccc35e44ab93b4965419ca7bf6e213a202b5', '103.232.126.14', '1501569419', '__ci_last_regenerate|i:1501569419;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7e5ac36380c255d21358e0fa4329a5985b41984c', '123.231.122.89', '1501570811', '__ci_last_regenerate|i:1501570534;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4bb7fa7f74fd1f86351ce12eccc370ab66f2f439', '23.101.61.176', '1501570698', '__ci_last_regenerate|i:1501570698;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6f65fe91bb3f79d1f5255c50369b67c6a98fa815', '123.231.122.89', '1501571437', '__ci_last_regenerate|i:1501571437;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6746224cfc00a51684e037630d34de210562cdc8', '103.232.126.14', '1501572403', '__ci_last_regenerate|i:1501572389;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:25:\"Page Added Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fa8557562785998a3a4b3bae67ddc88ed675e86a', '123.231.122.89', '1501573056', '__ci_last_regenerate|i:1501572827;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c6e3579b7fc1be06a1de4ee3c6b4c7ed6e7dce79', '123.231.122.89', '1501574618', '__ci_last_regenerate|i:1501574618;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d08f22e4232c883781e683ef544a5c151fb0e932', '103.232.126.14', '1501576489', '__ci_last_regenerate|i:1501576407;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:29:\"Customer Added Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e6e8e18d08de71f261d62e596da54a08ecafcb5c', '123.231.122.89', '1501576749', '__ci_last_regenerate|i:1501576581;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:29:\"Customer Added Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7c32b5693a4f155cb97353f094e433307f982192', '103.232.126.14', '1501580404', '__ci_last_regenerate|i:1501580319;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('ebd6d45fc2c3fd6b90df8f1c21e5e7516720b461', '123.231.126.34', '1501585909', '__ci_last_regenerate|i:1501585908;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('be46c9cef444b8bfe6170177693d2cdae842d564', '123.231.126.34', '1501585909', '__ci_last_regenerate|i:1501585908;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f7fd2f1e33a6aba31524335f5dd7353602d87b32', '103.232.126.14', '1501587691', '__ci_last_regenerate|i:1501587657;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('47942d4e9ad2a7c5558b5d529d802d73ff1b3a00', '103.232.126.14', '1501588000', '__ci_last_regenerate|i:1501587984;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3b7ac021e649904511000a749b6c405d925003e0', '103.232.126.14', '1501591319', '__ci_last_regenerate|i:1501591128;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3cd9e70c5409134fc26dcdee8f85de6a0f1e0fbe', '103.232.126.14', '1501592089', '__ci_last_regenerate|i:1501591806;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('473335da1323e50b5f431da2d162f6eb4bdfb4b4', '103.232.126.14', '1501592123', '__ci_last_regenerate|i:1501592119;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('42f7f13c4db21210d12173caaf115bef925df31f', '103.232.126.14', '1501592724', '__ci_last_regenerate|i:1501592724;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a00ffe884711f44738ed43df0529bc96f5fd6f14', '103.232.126.14', '1501594606', '__ci_last_regenerate|i:1501594441;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('38f850ae22b80aba81b86677d885e4a9ced0296d', '123.231.122.124', '1501607981', '__ci_last_regenerate|i:1501607808;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2a541bfc1c697eca2754d8fd996e4cf0c7eb9600', '123.231.122.124', '1501608381', '__ci_last_regenerate|i:1501608381;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e6e037b1af33d6e59dafa3b7b227221a29eb6aa1', '103.232.125.107', '1501647870', '__ci_last_regenerate|i:1501647642;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('965535c2aac54ec0f75c4ac7308b405cff297fb6', '103.232.125.107', '1501648081', '__ci_last_regenerate|i:1501647925;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('99c9eb4ce8f71b82c500957858549f68688e2c6b', '103.232.125.107', '1501648253', '__ci_last_regenerate|i:1501647985;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2ad86ca0d6597ea7dc807d6494b123c6cfb722a7', '103.232.125.107', '1501648295', '__ci_last_regenerate|i:1501648286;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3479cc489b3cc426b5895f04f70b2951ee8c2f40', '103.232.125.107', '1501648716', '__ci_last_regenerate|i:1501648592;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f46f1a3127180615f04ea88e2dbbc75f4fbd51b5', '103.232.125.107', '1501648766', '__ci_last_regenerate|i:1501648723;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('17a0df4cdce22d77856f2128c7a379e3390ef01b', '103.232.125.107', '1501649335', '__ci_last_regenerate|i:1501649333;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bc32cacc3e2f519328ebef16c20d8ce73cd7766f', '103.232.125.107', '1501651054', '__ci_last_regenerate|i:1501650940;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d5a63ea5493193dbd4d80e3d3279768019665c11', '23.101.61.176', '1501652008', '__ci_last_regenerate|i:1501652008;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('60070bb4739dc5882ffffa8e52bda9bb45790938', '23.99.101.118', '1501658093', '__ci_last_regenerate|i:1501658093;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e7d3fe06024862b0589e41d9ee26457c2a3b9aaf', '103.232.125.107', '1501659135', '__ci_last_regenerate|i:1501658838;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a8cf8d3739c113b343ae361d733a436f69ec2861', '103.232.125.107', '1501659358', '__ci_last_regenerate|i:1501659142;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('351058a4735e587ea1947bcf4eae1e9c222d0b72', '103.232.125.107', '1501662063', '__ci_last_regenerate|i:1501662063;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('cc6d5299cd93e484d37f011f427247f99e09d4b1', '123.231.127.21', '1501679936', '__ci_last_regenerate|i:1501679729;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fcde1937599aa858f2c7363ac6e7225811a563b0', '103.232.125.107', '1501681273', '__ci_last_regenerate|i:1501681161;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";alert_msg|a:3:{i:0;s:7:\"failure\";i:1;s:10:\"View pumps\";i:2;s:49:\"You can not view pumps. Please ask administrator!\";}__ci_vars|a:1:{s:9:\"alert_msg\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('91af3ecb054ccf8204013b609adbdac20cfab4bb', '123.231.127.21', '1501683672', '__ci_last_regenerate|i:1501683666;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2ed2a1243d121cc5231cf1c47a9d51f0d2879f0a', '123.231.127.21', '1501687868', '__ci_last_regenerate|i:1501687868;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('46005816947dbb0e493c80e98658131a769ba179', '123.231.127.21', '1501724339', '__ci_last_regenerate|i:1501724338;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b0d49ecfe45b6ea848d58b09e0c994648df260e8', '103.232.126.32', '1501737240', '__ci_last_regenerate|i:1501737240;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d97b1c493546608de040c9b179f35e3dfcff056f', '123.231.127.21', '1501739841', '__ci_last_regenerate|i:1501739697;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fd8305064bea2cda1109bef404d6a03d2cb4e457', '103.232.126.32', '1501739841', '__ci_last_regenerate|i:1501739834;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('72bb8b691881aad41060bc6a5be255062947d42c', '123.231.127.21', '1501740301', '__ci_last_regenerate|i:1501740069;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:37:\"Daily Collection Saved Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7afc5b5a45a81cfb93097b8decb1a87a78a6d657', '123.231.127.21', '1501740893', '__ci_last_regenerate|i:1501740754;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f629353c731d18cc45db19662801dd972b9aadb4', '103.232.126.32', '1501752573', '__ci_last_regenerate|i:1501752317;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1e186bde4872a8e4ad3bc392de102fd4c5ac3351', '103.232.126.32', '1501752804', '__ci_last_regenerate|i:1501752648;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b3fbfc0b3bc5f399a502c0af43df0dcee1c4f69a', '103.232.126.32', '1501753288', '__ci_last_regenerate|i:1501752991;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8a1aeec7d69ee088175af63d46ae16b7eeec2474', '103.232.126.32', '1501753546', '__ci_last_regenerate|i:1501753305;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2ef4c1644a477c8a6cb85bab78df61153f1387b1', '123.231.121.4', '1501753471', '__ci_last_regenerate|i:1501753471;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('23e5970077b2b2d0d2c0ca64658e427044359a86', '103.232.126.32', '1501753740', '__ci_last_regenerate|i:1501753485;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7a29f4fa63cd47a4024cf21f3641d0a0f7193028', '103.232.126.32', '1501753965', '__ci_last_regenerate|i:1501753671;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('346ed9c365f9d88046e77ff03b285482096ce54d', '104.45.18.178', '1501753749', '__ci_last_regenerate|i:1501753749;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6ce98417a286cecac57d428c28e96a74494a4ff7', '103.232.126.32', '1501754270', '__ci_last_regenerate|i:1501753976;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('a0786eb72d4833761fc9cb1fd5e1284ec093f572', '103.232.126.32', '1501754597', '__ci_last_regenerate|i:1501754282;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f528a958ea16a981f9644a37a6dee35093b8457a', '103.232.126.32', '1501754831', '__ci_last_regenerate|i:1501754598;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('3f362775a78b755f4fd0169ee166466aff58ee40', '103.232.126.32', '1501755057', '__ci_last_regenerate|i:1501754917;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:25:\"Page Added Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b47ba39e0a10570a709336e0777952afe0d8ec82', '103.232.126.32', '1501755013', '__ci_last_regenerate|i:1501755013;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('be3765b182b4b2071553696d0b7cd148c5e96046', '103.232.126.32', '1501755714', '__ci_last_regenerate|i:1501755714;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d6ddc562e99f65982d98067cf69ecdde30322f3f', '103.232.126.32', '1501764061', '__ci_last_regenerate|i:1501764060;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('bf123acdfdadddfb1b84d6e689836cb5e7f59107', '13.76.241.210', '1501801251', '__ci_last_regenerate|i:1501801251;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('2732bf522e56a29c3bc4a43698965c1909ca74c6', '123.231.123.95', '1501816038', '__ci_last_regenerate|i:1501813527;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('37c5b1afc2a883f846019f609ebc87ade4286f6d', '123.231.123.95', '1501814485', '__ci_last_regenerate|i:1501814426;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:25:\"Loan Added Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d1da0fe5e3356772d51879d8828c482feda6ea33', '23.99.101.118', '1501814498', '__ci_last_regenerate|i:1501814498;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('50319ef908d3d7991067454d8982f3096a48debd', '123.231.123.95', '1501814858', '__ci_last_regenerate|i:1501814730;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('98ef95564eb893c1fdd690b3eaa9c7e1924bc956', '123.231.123.95', '1501818237', '__ci_last_regenerate|i:1501816038;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0ab7b6aa9023eb59f411f0bd047f535b400ad557', '123.231.123.95', '1501818252', '__ci_last_regenerate|i:1501818240;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('54420c1c9301bab1f062b65b68be39b3854de3c8', '123.231.123.95', '1501820598', '__ci_last_regenerate|i:1501820320;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('4af65449431a12c9238afb72449ad2bc804f5cfe', '123.231.123.95', '1501820748', '__ci_last_regenerate|i:1501820645;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('f4e8e3550ca206ad054869710ea0b358c3f5c3d7', '123.231.123.95', '1501821687', '__ci_last_regenerate|i:1501821199;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('03a63a91421fa38caa68147b86ee58da7272f6a2', '123.231.123.95', '1501821806', '__ci_last_regenerate|i:1501821687;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";SUCCESSMSG|s:33:\"Settlement Deleted Successfully!!\";__ci_vars|a:1:{s:10:\"SUCCESSMSG\";s:3:\"old\";}');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('181800f31a0c0f33a466dab328771be4f0f99d3e', '123.231.123.95', '1501822369', '__ci_last_regenerate|i:1501822048;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1edce0921da19670e88b8f06f1361773d834043a', '123.231.123.95', '1501822545', '__ci_last_regenerate|i:1501822369;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('6590a1e1c12ddd436f5e2b4c055a307d536b9f16', '123.231.123.95', '1501823201', '__ci_last_regenerate|i:1501822720;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('609a8bf1ef372250f1090780523830bb76740e04', '123.231.123.95', '1501823687', '__ci_last_regenerate|i:1501823203;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('410acd4a7c2f8183f3ca8b705d91b81758066850', '123.231.123.95', '1501823850', '__ci_last_regenerate|i:1501823688;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('365681be2aa0ee2cbab08b63ac270d7f0545da9b', '123.231.123.95', '1501825302', '__ci_last_regenerate|i:1501825071;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('b34f480da60d1e9afd2ee18447516de4a2f7c937', '123.231.123.95', '1501825669', '__ci_last_regenerate|i:1501825393;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('61f52bf5e235382ca2d90e3fb5ac523a1711ad8e', '123.231.123.95', '1501825721', '__ci_last_regenerate|i:1501825721;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d62596bd1e4007a37b0d7b92c19a27e39bf8d597', '123.231.123.95', '1501826509', '__ci_last_regenerate|i:1501826507;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('84abc66e24950a0761cdbd571a037a222a6f8b70', '123.231.123.95', '1501826965', '__ci_last_regenerate|i:1501826672;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('fd15083562ae15d9c9376440e16374641d36dd55', '123.231.123.95', '1501827629', '__ci_last_regenerate|i:1501827256;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('de783eb130d003a4279efd77a49d97081e0c0889', '123.231.123.95', '1501827670', '__ci_last_regenerate|i:1501827629;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8c4476b886c9f06a03192a6e3b74f08b8d94953c', '103.232.125.172', '1501828122', '__ci_last_regenerate|i:1501828122;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('967eaf8ec727f11cb33049f4ca8328b7b86808bb', '123.231.123.95', '1501831431', '__ci_last_regenerate|i:1501831118;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('c4edf01db365d425e7cc70024d46e84aef44f01d', '123.231.123.95', '1501831697', '__ci_last_regenerate|i:1501831433;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('906b6270177799d6f223d1feb97a6c8804f6c1e8', '103.232.125.172', '1501831756', '__ci_last_regenerate|i:1501831518;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('8873696f1f993a34f33ee127116c442d3bb51b2c', '13.76.241.210', '1501831679', '__ci_last_regenerate|i:1501831679;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('1ad6bcdf3ebf71bb8e32aa2850d240412a2e7029', '104.45.18.178', '1501831697', '__ci_last_regenerate|i:1501831697;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('0f41e36cf3e0d910274b4a984866e71cda15a6d7', '103.232.125.172', '1501831725', '__ci_last_regenerate|i:1501831725;');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('912d00eca2051a253ff6a73308afa937aa0cd84a', '123.231.123.95', '1501831802', '__ci_last_regenerate|i:1501831735;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('eda7b828ddfc4f1279baf89d23ba55826ade5ef3', '123.231.123.95', '1501832349', '__ci_last_regenerate|i:1501832285;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('d25723ac4e293274d79ca4f61760cbaa16f7ce02', '123.231.123.95', '1501833544', '__ci_last_regenerate|i:1501833269;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('df0f0f6a4684439bd2617c85c6689d282b0cf2fa', '123.231.123.95', '1501834403', '__ci_last_regenerate|i:1501834339;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');
INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('7d1187f2a4f40210a9d82137ba5f810df5efa078', '::1', '1501834763', '__ci_last_regenerate|i:1501834755;sessionid|s:3:\"pos\";user_id|s:2:\"36\";user_email|s:14:\"abcd@gmail.com\";user_role|s:1:\"1\";user_outlet|s:1:\"0\";user_role_name|s:13:\"Administrator\";');


#
# TABLE STRUCTURE FOR: create_order_estimate
#

DROP TABLE IF EXISTS `create_order_estimate`;

CREATE TABLE `create_order_estimate` (
  `estimate_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `delivery_date` date NOT NULL,
  `price` float(16,2) NOT NULL,
  `weight` float(10,3) NOT NULL,
  `subtotal` float(10,2) NOT NULL,
  `reserve` tinyint(2) NOT NULL,
  `other_cost` float(10,2) NOT NULL,
  `sale_ofice_id` int(11) NOT NULL,
  PRIMARY KEY (`estimate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: currency
#

DROP TABLE IF EXISTS `currency`;

CREATE TABLE `currency` (
  `iso` char(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`iso`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `currency` (`iso`, `name`) VALUES ('KRW', '(South) Korean Won');
INSERT INTO `currency` (`iso`, `name`) VALUES ('AFA', 'Afghanistan Afghani');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ALL', 'Albanian Lek');
INSERT INTO `currency` (`iso`, `name`) VALUES ('DZD', 'Algerian Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ADP', 'Andorran Peseta');
INSERT INTO `currency` (`iso`, `name`) VALUES ('AOK', 'Angolan Kwanza');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ARS', 'Argentine Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('AMD', 'Armenian Dram');
INSERT INTO `currency` (`iso`, `name`) VALUES ('AWG', 'Aruban Florin');
INSERT INTO `currency` (`iso`, `name`) VALUES ('AUD', 'Australian Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BSD', 'Bahamian Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BHD', 'Bahraini Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BDT', 'Bangladeshi Taka');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BBD', 'Barbados Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BZD', 'Belize Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BMD', 'Bermudian Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BTN', 'Bhutan Ngultrum');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BOB', 'Bolivian Boliviano');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BWP', 'Botswanian Pula');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BRL', 'Brazilian Real');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GBP', 'British Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BND', 'Brunei Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BGN', 'Bulgarian Lev');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BUK', 'Burma Kyat');
INSERT INTO `currency` (`iso`, `name`) VALUES ('BIF', 'Burundi Franc');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CAD', 'Canadian Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CVE', 'Cape Verde Escudo');
INSERT INTO `currency` (`iso`, `name`) VALUES ('KYD', 'Cayman Islands Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CLP', 'Chilean Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CLF', 'Chilean Unidades de Fomento');
INSERT INTO `currency` (`iso`, `name`) VALUES ('COP', 'Colombian Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XOF', 'CommunautÃ© FinanciÃ¨re Africaine BCEAO - Francs');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XAF', 'CommunautÃ© FinanciÃ¨re Africaine BEAC, Francs');
INSERT INTO `currency` (`iso`, `name`) VALUES ('KMF', 'Comoros Franc');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XPF', 'Comptoirs FranÃ§ais du Pacifique Francs');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CRC', 'Costa Rican Colon');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CUP', 'Cuban Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CYP', 'Cyprus Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CZK', 'Czech Republic Koruna');
INSERT INTO `currency` (`iso`, `name`) VALUES ('DKK', 'Danish Krone');
INSERT INTO `currency` (`iso`, `name`) VALUES ('YDD', 'Democratic Yemeni Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('DOP', 'Dominican Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XCD', 'East Caribbean Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('TPE', 'East Timor Escudo');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ECS', 'Ecuador Sucre');
INSERT INTO `currency` (`iso`, `name`) VALUES ('EGP', 'Egyptian Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SVC', 'El Salvador Colon');
INSERT INTO `currency` (`iso`, `name`) VALUES ('EEK', 'Estonian Kroon (EEK)');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ETB', 'Ethiopian Birr');
INSERT INTO `currency` (`iso`, `name`) VALUES ('EUR', 'Euro');
INSERT INTO `currency` (`iso`, `name`) VALUES ('FKP', 'Falkland Islands Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('FJD', 'Fiji Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GMD', 'Gambian Dalasi');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GHC', 'Ghanaian Cedi');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GIP', 'Gibraltar Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XAU', 'Gold, Ounces');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GTQ', 'Guatemalan Quetzal');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GNF', 'Guinea Franc');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GWP', 'Guinea-Bissau Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('GYD', 'Guyanan Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('HTG', 'Haitian Gourde');
INSERT INTO `currency` (`iso`, `name`) VALUES ('HNL', 'Honduran Lempira');
INSERT INTO `currency` (`iso`, `name`) VALUES ('HKD', 'Hong Kong Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('HUF', 'Hungarian Forint');
INSERT INTO `currency` (`iso`, `name`) VALUES ('INR', 'Indian Rupee');
INSERT INTO `currency` (`iso`, `name`) VALUES ('IDR', 'Indonesian Rupiah');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XDR', 'International Monetary Fund (IMF) Special Drawing Rights');
INSERT INTO `currency` (`iso`, `name`) VALUES ('IRR', 'Iranian Rial');
INSERT INTO `currency` (`iso`, `name`) VALUES ('IQD', 'Iraqi Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('IEP', 'Irish Punt');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ILS', 'Israeli Shekel');
INSERT INTO `currency` (`iso`, `name`) VALUES ('JMD', 'Jamaican Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('JPY', 'Japanese Yen');
INSERT INTO `currency` (`iso`, `name`) VALUES ('JOD', 'Jordanian Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('KHR', 'Kampuchean (Cambodian) Riel');
INSERT INTO `currency` (`iso`, `name`) VALUES ('KES', 'Kenyan Schilling');
INSERT INTO `currency` (`iso`, `name`) VALUES ('KWD', 'Kuwaiti Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('LAK', 'Lao Kip');
INSERT INTO `currency` (`iso`, `name`) VALUES ('LBP', 'Lebanese Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('LSL', 'Lesotho Loti');
INSERT INTO `currency` (`iso`, `name`) VALUES ('LRD', 'Liberian Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('LYD', 'Libyan Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MOP', 'Macau Pataca');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MGF', 'Malagasy Franc');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MWK', 'Malawi Kwacha');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MYR', 'Malaysian Ringgit');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MVR', 'Maldive Rufiyaa');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MTL', 'Maltese Lira');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MRO', 'Mauritanian Ouguiya');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MUR', 'Mauritius Rupee');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MXP', 'Mexican Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MNT', 'Mongolian Tugrik');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MAD', 'Moroccan Dirham');
INSERT INTO `currency` (`iso`, `name`) VALUES ('MZM', 'Mozambique Metical');
INSERT INTO `currency` (`iso`, `name`) VALUES ('NAD', 'Namibian Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('NPR', 'Nepalese Rupee');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ANG', 'Netherlands Antillian Guilder');
INSERT INTO `currency` (`iso`, `name`) VALUES ('YUD', 'New Yugoslavia Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('NZD', 'New Zealand Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('NIO', 'Nicaraguan Cordoba');
INSERT INTO `currency` (`iso`, `name`) VALUES ('NGN', 'Nigerian Naira');
INSERT INTO `currency` (`iso`, `name`) VALUES ('KPW', 'North Korean Won');
INSERT INTO `currency` (`iso`, `name`) VALUES ('NOK', 'Norwegian Kroner');
INSERT INTO `currency` (`iso`, `name`) VALUES ('OMR', 'Omani Rial');
INSERT INTO `currency` (`iso`, `name`) VALUES ('PKR', 'Pakistan Rupee');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XPD', 'Palladium Ounces');
INSERT INTO `currency` (`iso`, `name`) VALUES ('PAB', 'Panamanian Balboa');
INSERT INTO `currency` (`iso`, `name`) VALUES ('PGK', 'Papua New Guinea Kina');
INSERT INTO `currency` (`iso`, `name`) VALUES ('PYG', 'Paraguay Guarani');
INSERT INTO `currency` (`iso`, `name`) VALUES ('PEN', 'Peruvian Nuevo Sol');
INSERT INTO `currency` (`iso`, `name`) VALUES ('PHP', 'Philippine Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XPT', 'Platinum, Ounces');
INSERT INTO `currency` (`iso`, `name`) VALUES ('PLN', 'Polish Zloty');
INSERT INTO `currency` (`iso`, `name`) VALUES ('QAR', 'Qatari Rial');
INSERT INTO `currency` (`iso`, `name`) VALUES ('RON', 'Romanian Leu');
INSERT INTO `currency` (`iso`, `name`) VALUES ('RUB', 'Russian Ruble');
INSERT INTO `currency` (`iso`, `name`) VALUES ('RWF', 'Rwanda Franc');
INSERT INTO `currency` (`iso`, `name`) VALUES ('WST', 'Samoan Tala');
INSERT INTO `currency` (`iso`, `name`) VALUES ('STD', 'Sao Tome and Principe Dobra');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SAR', 'Saudi Arabian Riyal');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SCR', 'Seychelles Rupee');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SLL', 'Sierra Leone Leone');
INSERT INTO `currency` (`iso`, `name`) VALUES ('XAG', 'Silver, Ounces');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SGD', 'Singapore Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SKK', 'Slovak Koruna');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SBD', 'Solomon Islands Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SOS', 'Somali Schilling');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ZAR', 'South African Rand');
INSERT INTO `currency` (`iso`, `name`) VALUES ('LKR', 'Sri Lanka Rupee');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SHP', 'St. Helena Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SDP', 'Sudanese Pound');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SRG', 'Suriname Guilder');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SZL', 'Swaziland Lilangeni');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SEK', 'Swedish Krona');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CHF', 'Swiss Franc');
INSERT INTO `currency` (`iso`, `name`) VALUES ('SYP', 'Syrian Potmd');
INSERT INTO `currency` (`iso`, `name`) VALUES ('TWD', 'Taiwan Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('TZS', 'Tanzanian Schilling');
INSERT INTO `currency` (`iso`, `name`) VALUES ('THB', 'Thai Baht');
INSERT INTO `currency` (`iso`, `name`) VALUES ('TOP', 'Tongan Paanga');
INSERT INTO `currency` (`iso`, `name`) VALUES ('TTD', 'Trinidad and Tobago Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('TND', 'Tunisian Dinar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('TRY', 'Turkish Lira');
INSERT INTO `currency` (`iso`, `name`) VALUES ('UGX', 'Uganda Shilling');
INSERT INTO `currency` (`iso`, `name`) VALUES ('AED', 'United Arab Emirates Dirham');
INSERT INTO `currency` (`iso`, `name`) VALUES ('UYU', 'Uruguayan Peso');
INSERT INTO `currency` (`iso`, `name`) VALUES ('USD', 'US Dollar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('VUV', 'Vanuatu Vatu');
INSERT INTO `currency` (`iso`, `name`) VALUES ('VEF', 'Venezualan Bolivar');
INSERT INTO `currency` (`iso`, `name`) VALUES ('VND', 'Vietnamese Dong');
INSERT INTO `currency` (`iso`, `name`) VALUES ('YER', 'Yemeni Rial');
INSERT INTO `currency` (`iso`, `name`) VALUES ('CNY', 'Yuan (Chinese) Renminbi');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ZRZ', 'Zaire Zaire');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ZMK', 'Zambian Kwacha');
INSERT INTO `currency` (`iso`, `name`) VALUES ('ZWD', 'Zimbabwe Dollar');


#
# TABLE STRUCTURE FOR: customer_group
#

DROP TABLE IF EXISTS `customer_group`;

CREATE TABLE `customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `customer_group` (`id`, `name`, `is_active`) VALUES ('1', 'General Customer', '1');
INSERT INTO `customer_group` (`id`, `name`, `is_active`) VALUES ('2', 'sads', '1');


#
# TABLE STRUCTURE FOR: customers
#

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `customer_group` int(11) NOT NULL,
  `outstanding` varchar(13) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `loan_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `deposit` float NOT NULL DEFAULT '0',
  `balance` text COLLATE utf8_unicode_ci,
  `nic` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tid` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('1', 'Walk In Customer', 'tc1@gmail.com', '', '1111', '', '0', '0', '10000', '36', '2017-07-17 12:33:36', '0', NULL, '', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('2', 'Test Customer', 'tc@gmail.com', '', '11', '', '0', '0', '0', '36', '2017-07-21 15:01:20', '0', NULL, '', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('3', 'dsadsd', 'dasdas@aa.com', '', 'dsadsd', 'sda', '1', '10', '0', '36', '2017-07-25 17:44:14', '0', NULL, 'abcd@gmail.com', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('4', 'XYZ', 'c3@1.com', '', '1', 'a', '1', '12000', '0', '36', '2017-07-25 19:52:36', '0', NULL, '1', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('5', 'hardik', 'hardik@gmail.com', '', '8141918666', 'dfdfsdf', '1', '100', '0', '36', '2017-07-25 19:55:14', '0', NULL, 'sdasd', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('6', 'Nilaaaaa', 'abcd@gmail.com', '', '1234567890', 'abcd@gmail.com', '2', '100', '0', '36', '2017-07-25 20:11:20', '0', NULL, 'abcd@gmail.com', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('7', 'AX', 'C4@1.COM', '', '1', 'A', '1', '4000', '0', '36', '2017-07-25 20:20:45', '0', NULL, '3', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('13', 'customer3', 'data2@gmail.com', '123456', '1234567890', 'katargam, surat', '1', '500', '0', '36', '2017-08-01 14:04:49', '0', NULL, 'tushar', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('12', 'customer2', 'data1@gmail.com', '123456', '1234567890', 'kartargam, surat', '1', '400', '0', '36', '2017-08-01 14:04:49', '0', NULL, 'ds', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('11', 'customer1', 'data@gmail.com', '123456', '1234567890', 'surat, katargam', '1', '200', '0', '36', '2017-08-01 14:04:49', '0', NULL, 'hardik', NULL);
INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `tid`) VALUES ('14', 'chandana', '1@a.com', '12', '23', 'werd', '1', '5000', '0', '36', '2017-08-01 14:09:09', '0', NULL, 'nbv', NULL);


#
# TABLE STRUCTURE FOR: daily_collection
#

DROP TABLE IF EXISTS `daily_collection`;

CREATE TABLE `daily_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection_form_no` varchar(255) NOT NULL DEFAULT '',
  `pumper_id` varchar(255) NOT NULL DEFAULT '',
  `balance_collection` varchar(255) NOT NULL DEFAULT '0',
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `created_by` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `daily_collection` (`id`, `collection_form_no`, `pumper_id`, `balance_collection`, `amount`, `outlet_id`, `created_by`, `created_at`) VALUES ('1', '1', '1', '0', '10000', '1', '36', '2017-08-04 11:51:10');
INSERT INTO `daily_collection` (`id`, `collection_form_no`, `pumper_id`, `balance_collection`, `amount`, `outlet_id`, `created_by`, `created_at`) VALUES ('2', '2', '2', '0', '10500', '1', '36', '2017-08-04 12:58:56');
INSERT INTO `daily_collection` (`id`, `collection_form_no`, `pumper_id`, `balance_collection`, `amount`, `outlet_id`, `created_by`, `created_at`) VALUES ('3', '3', '2', '0', '5000', '1', '36', '2017-08-04 12:59:12');


#
# TABLE STRUCTURE FOR: dip_report
#

DROP TABLE IF EXISTS `dip_report`;

CREATE TABLE `dip_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id_fk` int(11) NOT NULL,
  `tank_id_fk` int(11) NOT NULL,
  `tank_number` varchar(100) NOT NULL,
  `dip_reading` decimal(10,4) NOT NULL,
  `tank_fuel_dip` decimal(10,4) NOT NULL,
  `tank_fuel_system` float NOT NULL,
  `ref_numb` float NOT NULL,
  `note` varchar(200) NOT NULL,
  `dip_datetime` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `reading_diff` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: division
#

DROP TABLE IF EXISTS `division`;

CREATE TABLE `division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `division` (`id`, `name`, `is_active`) VALUES ('1', 'div1', '1');


#
# TABLE STRUCTURE FOR: esctax
#

DROP TABLE IF EXISTS `esctax`;

CREATE TABLE `esctax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(85) NOT NULL,
  `tax_percentage` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1=ON, 0=OFF',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_modefied_at` datetime NOT NULL,
  `last_modefied_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: expense_categories
#

DROP TABLE IF EXISTS `expense_categories`;

CREATE TABLE `expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL COMMENT '0: Inactive, 1: Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `expense_categories` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('1', 'test', '36', '2017-07-25 22:11:15', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `expense_categories` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('2', 'Electricity ', '36', '2017-07-25 22:11:24', '0', '0000-00-00 00:00:00', '1');


#
# TABLE STRUCTURE FOR: expenses
#

DROP TABLE IF EXISTS `expenses`;

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expenses_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expense_category` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(4999) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `amount` double(11,2) NOT NULL,
  `reason` longtext COLLATE utf8_unicode_ci NOT NULL,
  `file_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `payment_type` int(11) NOT NULL,
  `transaction_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `expenses` (`id`, `expenses_number`, `expense_category`, `outlet_id`, `outlet_name`, `date`, `amount`, `reason`, `file_name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `payment_type`, `transaction_id_fk`) VALUES ('1', '1', '2', '1', 'Outlet1', '2017-08-04', '100.00', 'month July', '', '36', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '1', '1', '432');


#
# TABLE STRUCTURE FOR: fuel_tanks
#

DROP TABLE IF EXISTS `fuel_tanks`;

CREATE TABLE `fuel_tanks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `fuel_tank_number` varchar(50) NOT NULL,
  `fuel_type` varchar(30) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `starting_volume` float NOT NULL,
  `current_balance` double(11,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `fuel_tanks` (`id`, `product_id`, `fuel_tank_number`, `fuel_type`, `outlet_id`, `starting_volume`, `current_balance`, `user_id`, `created`) VALUES ('1', '3', 'Tank1', '', '1', '0', '15080.00', '36', '2017-08-03 15:30:33');
INSERT INTO `fuel_tanks` (`id`, `product_id`, `fuel_tank_number`, `fuel_type`, `outlet_id`, `starting_volume`, `current_balance`, `user_id`, `created`) VALUES ('2', '4', 'Tank3', '', '1', '0', '4755.00', '36', '2017-08-03 15:30:48');
INSERT INTO `fuel_tanks` (`id`, `product_id`, `fuel_tank_number`, `fuel_type`, `outlet_id`, `starting_volume`, `current_balance`, `user_id`, `created`) VALUES ('3', '4', 'Tank2', '', '1', '0', '5000.00', '36', '2017-08-03 15:32:25');


#
# TABLE STRUCTURE FOR: fuel_types
#

DROP TABLE IF EXISTS `fuel_types`;

CREATE TABLE `fuel_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fuel_type` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`fuel_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: gift_card
#

DROP TABLE IF EXISTS `gift_card`;

CREATE TABLE `gift_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `value` double(11,2) NOT NULL,
  `expiry_date` date NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL COMMENT '0: haven''t use, 1: used',
  `outlet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: gold_grade
#

DROP TABLE IF EXISTS `gold_grade`;

CREATE TABLE `gold_grade` (
  `grade_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(100) NOT NULL,
  `grade_price` float(6,2) NOT NULL,
  `gold_purity` float(6,2) NOT NULL,
  `date_created` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `trash` varchar(10) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: gold_inventory
#

DROP TABLE IF EXISTS `gold_inventory`;

CREATE TABLE `gold_inventory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gold_code` varchar(100) NOT NULL,
  `i_gold_grade` varchar(100) NOT NULL,
  `i_gold_qty` float(20,3) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `idate_created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: gold_orders
#

DROP TABLE IF EXISTS `gold_orders`;

CREATE TABLE `gold_orders` (
  `gold_id` int(11) NOT NULL AUTO_INCREMENT,
  `gold_customer_id` int(11) NOT NULL,
  `gold_customer_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_customer_email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_customer_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_ordered_datetime` datetime NOT NULL,
  `gold_outlet_id` int(11) NOT NULL,
  `gold_outlet_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_outlet_address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gold_gold_outlet_contact` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_outlet_receipt_footer` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gold_gold_gift_card` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gold_subtotal` double(11,2) NOT NULL,
  `gold_discount_total` double(11,2) NOT NULL,
  `gold_discount_percentage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_tax` double(11,2) NOT NULL,
  `gold_grandtotal` double(11,2) NOT NULL,
  `gold_gold_total_items` int(11) NOT NULL,
  `gold_payment_method` int(11) NOT NULL,
  `gold_payment_method_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_cheque_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gold_paid_amt` double(11,2) NOT NULL,
  `gold_return_change` double(11,2) NOT NULL,
  `gold_created_user_id` int(11) NOT NULL,
  `gold_created_datetime` datetime NOT NULL,
  `gold_updated_user_id` int(11) NOT NULL,
  `gold_updated_datetime` datetime NOT NULL,
  `gold_vt_status` int(11) NOT NULL COMMENT '0: Debit Payment, 1: Completed',
  `gold_status` int(11) NOT NULL COMMENT '1: Sales, 2: Return',
  `gold_refund_status` int(11) NOT NULL COMMENT '1: Full Refund, 2: Partial Refund',
  `gold_remark` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gold_card_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gold_sid` int(11) NOT NULL,
  `gold_pump_operators_id` int(11) NOT NULL,
  `gold_pump_id` int(11) NOT NULL,
  `gold_appointment_id` int(11) NOT NULL,
  `gold_short_amount` float DEFAULT NULL,
  `gold_payment_deails` text COLLATE utf8_unicode_ci,
  `gold_payment_details` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`gold_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: gold_prices
#

DROP TABLE IF EXISTS `gold_prices`;

CREATE TABLE `gold_prices` (
  `gp_id` int(11) NOT NULL AUTO_INCREMENT,
  `gp_grade` int(11) NOT NULL,
  `gp_purity` float(6,3) NOT NULL,
  `gp_price` float(6,2) NOT NULL,
  `gp_date` date NOT NULL,
  `gp_date_created` datetime NOT NULL,
  PRIMARY KEY (`gp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: gold_products
#

DROP TABLE IF EXISTS `gold_products`;

CREATE TABLE `gold_products` (
  `gpro_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gpro_name` varchar(10) NOT NULL,
  `gpro_code` varchar(50) NOT NULL,
  `gpro_store_id` bigint(20) NOT NULL,
  `gpro_outlet_id` bigint(20) NOT NULL,
  `gpro_weight` float(10,3) NOT NULL,
  `purchase` float(30,2) NOT NULL,
  `thumbnail` text NOT NULL,
  `gpro_status` varchar(10) NOT NULL,
  `gpro_updated_weight` float(10,3) NOT NULL,
  `gpro_date_added` date NOT NULL,
  `gpro_date_creation` date NOT NULL,
  `grade_id` int(11) NOT NULL,
  `gpro_cate_id` int(11) NOT NULL,
  `who_created_product` int(11) NOT NULL,
  PRIMARY KEY (`gpro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: gold_smith
#

DROP TABLE IF EXISTS `gold_smith`;

CREATE TABLE `gold_smith` (
  `gs_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `land_phone_number` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `nic` varchar(20) NOT NULL,
  `weight__qty_pergram` float(10,3) NOT NULL,
  `gold_smith_num` varchar(20) NOT NULL,
  `date_created` date NOT NULL,
  PRIMARY KEY (`gs_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: inventory
#

DROP TABLE IF EXISTS `inventory`;

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `qty` double(11,2) NOT NULL,
  `ow_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '0: Warehouse, 1: Fuel ',
  `date` datetime NOT NULL,
  `batch_no` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('1', 'Product1', '1', '2000.00', '1', '0', '2017-08-03 15:23:40', '0', '0000-00-00');
INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('2', 'Product1', '1', '500.00', '2', '0', '2017-08-03 15:23:40', '0', '0000-00-00');
INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('3', 'Product2', '1', '300.00', '3', '0', '2017-08-03 15:24:15', '0', '1970-01-01');
INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('4', 'Product3', '1', '15080.00', '1', '1', '2017-08-03 15:30:33', '', '0000-00-00');
INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('5', 'Product4', '1', '4755.00', '2', '1', '2017-08-03 15:30:48', '', '0000-00-00');
INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('6', 'Product4', '1', '5000.00', '3', '1', '2017-08-03 15:32:25', '', '0000-00-00');
INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('7', 'Product1', '1', '250.00', '3', '0', '2017-08-04 09:13:57', '0', '1970-01-01');
INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `batch_no`, `expire_date`) VALUES ('8', 'Product2', '1', '50.00', '2', '0', '2017-08-04 11:38:25', '0', '1970-01-01');


#
# TABLE STRUCTURE FOR: loan
#

DROP TABLE IF EXISTS `loan`;

CREATE TABLE `loan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_form_no` varchar(255) NOT NULL DEFAULT '',
  `customer_id` varchar(255) NOT NULL DEFAULT '',
  `loan_amount` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `payment_id` varchar(255) NOT NULL DEFAULT '',
  `note` text NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `loan` (`id`, `loan_form_no`, `customer_id`, `loan_amount`, `outlet_id`, `payment_id`, `note`, `created_by`, `created_at`) VALUES ('1', '1', '1', '10000', '1', '1', 'sonali test', '36', '2017-08-04 08:11:25');


#
# TABLE STRUCTURE FOR: modules
#

DROP TABLE IF EXISTS `modules`;

CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('1', '0', 'dashboard', 'Dashboard', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('2', '0', 'appointment_module', 'Appointments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('3', '2', 'appointments', 'Appointments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('4', '2', 'add_appointment', 'Add Appointment', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('5', '2', 'list_appointment', 'Manage Appointments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('6', '0', 'purchase_module', 'Purchase Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('7', '6', 'purchases', 'Purchases', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('8', '6', 'suppliers', 'Suppliers', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('9', '6', 'pay_suppliers', 'Pay Suppliers', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('10', '6', 'purchase_bills', 'Purchase Bills', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('11', '0', 'sales_module', 'Sales Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('12', '11', 'customers', 'Customers', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('13', '11', 'credit_sales', 'Credit Sales', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('14', '11', 'today_sales', 'Today Sales', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('15', '11', 'opened_bill', 'Opened Bill', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('16', '11', 'pos', 'POS', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('17', '11', 'sales_settlement', 'Settelment', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('18', '11', 'sales_return', 'Sales Return', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('19', '18', 'create_return', 'Create Sales Return', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('20', '18', 'return_report', 'Sales Return Receipt', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('21', '0', 'warehouse_module', 'Warehouse Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('22', '21', 'warehouse_list', 'List Warehouses', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('23', '21', 'assign_store', 'Assign Warehouse', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('24', '21', 'warehouse_stocks', 'Warehouse Stocks', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('25', '0', 'gold_module', 'Gold Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('26', '25', 'addgrade', 'Add Gold-Grade', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('27', '25', 'gold_gold_prices', 'Gold Grade & Prices', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('28', '25', 'order_estimate', 'Order Estimate', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('29', '25', 'goldsmith', 'Goldsmith', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('30', '25', 'view_transfer', 'Transfer', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('31', '25', 'list_store_transfer', 'View Store Record', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('32', '25', 'list_order_estimate', 'List Order Estimate', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('33', '25', 'gold_gradeview', 'Gold Grade List', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('34', '0', 'goldsmith_module', 'Refined Gold Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('35', '34', 'refine_order_list', 'Refine Order List', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('36', '34', 'add_refine_order', 'Add Refine Order', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('37', '34', 'add_refined_receive_note', 'Add Refined Receieved Note', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('38', '34', 'refined_gold', 'Refined Gold List', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('39', '0', 'production', 'Production', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('40', '39', 'all_production', 'Production', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('41', '39', 'list_goldsmith_wastage', 'Goldsmith Wastage', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('42', '0', 'bakerysales_module', 'Bakery Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('43', '42', 'bakerySales', 'Bakery Sales', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('44', '42', 'issue_sale_report', 'Issue Sales Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('45', '0', 'pumps_module', 'Pumps Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('46', '45', 'pumps', 'List Pumps', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('47', '45', 'list_operators', 'List Pump Operators', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('48', '45', 'list_ft', 'List Fuel Tanks', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('49', '45', 'pumpSales', 'Pump Comm & Shortage', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('50', '45', 'pumps_settlement', 'Settlement', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('51', '45', 'escTax', 'Esc Tax', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('52', '45', 'pumperreport', 'Pump Operator Reports', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('53', '45', 'fuelsalereport', 'Fuel Sale Reports', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('54', '45', 'dipreport', 'Dip Reports', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('55', '0', 'inventory_module', 'Inventory Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('56', '55', 'inventory', 'Inventory', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('57', '55', 'products', 'Products', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('58', '57', 'list_products', 'List Products', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('59', '57', 'product_category', 'Product Category', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('60', '57', 'print_label', 'Print Product Label', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('61', '55', 'brand', 'Brand', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('62', '55', 'sub_category', 'Sub Category', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('63', '0', 'banking', 'Banking Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('64', '63', 'bank_accounts', 'Bank Accounts', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('65', '63', 'bank_dt', 'Bank Deposit/Transfer', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('66', '63', 'balance', 'Account Balances', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('67', '63', 'receivedcheque', 'Received Cheque Detail', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('68', '63', 'voucherdetail', 'Voucher Details', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('69', '0', 'gift_module', 'Gift Card', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('70', '69', 'add_gift_card', 'Add Gift Card', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('71', '69', 'list_gift_card', 'List Gift Card', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('72', '0', 'expenses_module', 'Expenses Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('73', '72', 'expenses', 'Expenses', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('74', '72', 'expense_category', 'Expense Category', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('75', '0', 'reports_module', 'Reports', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('76', '75', 'sales_report', 'Sales Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('77', '75', 'product_report', 'Product Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('78', '75', 'product_category_report', 'Product Category Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('79', '75', 'sales_report_payement', 'Sales Report â€“ Payments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('80', '0', 'pl_repor', 'Profit & Loss', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('81', '80', 'pnl', 'P & L Graphs', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('82', '80', 'view_pnl_report', 'P & L Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('83', '0', 'setting', 'Setting', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('84', '83', 'outlets', 'Outlets', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('85', '83', 'users', 'Users', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('86', '83', 'staff', 'Staff', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('87', '83', 'permission', 'Permission', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('88', '83', 'payment_methods', 'Payment Methods', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('89', '83', 'system_setting', 'System Setting', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('90', '83', 'division', 'Division', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('91', '45', 'pump_reading', 'Pump Reading', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('95', '83', 'bill_numbering', 'Bill Numbering', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('96', '83', 'product_code_numbering', 'Product Code Numbering', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('97', '57', 'reorder_detail', 'Reorder Detail', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('98', '75', 'daily_summary_report', 'Daily Summary Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('99', '0', 'loan', 'Loan', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('100', '99', 'loan_list', 'Loan List', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('101', '99', 'settle_loan', 'Settle Loan', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('102', '45', 'pump_reading', 'Pump Reading', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('103', '45', 'testing_detail', 'Testing Detail', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('104', '75', 'credit_sales_payment', 'Credit Sales Payment', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('105', '75', 'taxes', 'Taxes', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('106', '83', 'add_new_page', 'Add New Page', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('107', '45', 'daily_collection', 'Daily Collection', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('108', '63', 'cheque_manager', 'Cheque Manager', '36', '2017-07-31 19:22:01', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('109', '45', 'settlement_list', 'Settlement List', '36', '2017-08-01 12:56:42', '0', '0000-00-00 00:00:00');
INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('110', '83', 'download_database', 'Download Database', '36', '2017-08-03 15:40:56', '0', '0000-00-00 00:00:00');


#
# TABLE STRUCTURE FOR: order_items
#

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_category` int(11) NOT NULL,
  `cost` double(11,2) NOT NULL,
  `price` double(11,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vt_status` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `return_change` double NOT NULL,
  `paid` double NOT NULL,
  `subtotal` double NOT NULL,
  `grandtotal` double NOT NULL,
  `tax` double NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `card_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cheque_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gift_card` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pump_operators_id` int(11) NOT NULL,
  `pump_id` int(11) DEFAULT NULL,
  `short_amount` float DEFAULT NULL,
  `payment_deails` text COLLATE utf8_unicode_ci,
  `ow_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '0= warehouse, 1 =tank',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_code`, `product_name`, `product_category`, `cost`, `price`, `qty`, `customer_id`, `vt_status`, `payment_method`, `payment_method_name`, `return_change`, `paid`, `subtotal`, `grandtotal`, `tax`, `discount`, `card_number`, `cheque_number`, `gift_card`, `pump_operators_id`, `pump_id`, `short_amount`, `payment_deails`, `ow_id`, `type`) VALUES ('5', '3', '4', 'Product4', 'Product4', '20', '10.00', '10.00', '245', NULL, '0', '0', '', '0', '2450', '2450', '2450', '0', '0', '', '', '', '0', '2', NULL, NULL, '2', '1');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_code`, `product_name`, `product_category`, `cost`, `price`, `qty`, `customer_id`, `vt_status`, `payment_method`, `payment_method_name`, `return_change`, `paid`, `subtotal`, `grandtotal`, `tax`, `discount`, `card_number`, `cheque_number`, `gift_card`, `pump_operators_id`, `pump_id`, `short_amount`, `payment_deails`, `ow_id`, `type`) VALUES ('4', '3', '3', 'Product3', 'Product3', '20', '10.00', '10.00', '495', NULL, '0', '0', '', '0', '4950', '4950', '4950', '0', '0', '', '', '', '0', '1', NULL, NULL, '1', '1');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_code`, `product_name`, `product_category`, `cost`, `price`, `qty`, `customer_id`, `vt_status`, `payment_method`, `payment_method_name`, `return_change`, `paid`, `subtotal`, `grandtotal`, `tax`, `discount`, `card_number`, `cheque_number`, `gift_card`, `pump_operators_id`, `pump_id`, `short_amount`, `payment_deails`, `ow_id`, `type`) VALUES ('9', '6', '3', 'Product3', 'Product3', '20', '10.00', '10.00', '85', NULL, '0', '0', '', '0', '850', '850', '850', '0', '0', '', '', '', '1', '1', NULL, NULL, '1', '1');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_code`, `product_name`, `product_category`, `cost`, `price`, `qty`, `customer_id`, `vt_status`, `payment_method`, `payment_method_name`, `return_change`, `paid`, `subtotal`, `grandtotal`, `tax`, `discount`, `card_number`, `cheque_number`, `gift_card`, `pump_operators_id`, `pump_id`, `short_amount`, `payment_deails`, `ow_id`, `type`) VALUES ('8', '5', '3', 'Product3', 'Product3', '20', '10.00', '10.00', '95', NULL, '0', '0', '', '0', '950', '950', '950', '0', '0', '', '', '', '2', '1', NULL, NULL, '1', '1');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_code`, `product_name`, `product_category`, `cost`, `price`, `qty`, `customer_id`, `vt_status`, `payment_method`, `payment_method_name`, `return_change`, `paid`, `subtotal`, `grandtotal`, `tax`, `discount`, `card_number`, `cheque_number`, `gift_card`, `pump_operators_id`, `pump_id`, `short_amount`, `payment_deails`, `ow_id`, `type`) VALUES ('10', '7', '3', 'Product3', 'Product3', '20', '10.00', '10.00', '95', NULL, '0', '0', '', '0', '950', '950', '950', '0', '0', '', '', '', '2', '1', NULL, NULL, '1', '1');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_code`, `product_name`, `product_category`, `cost`, `price`, `qty`, `customer_id`, `vt_status`, `payment_method`, `payment_method_name`, `return_change`, `paid`, `subtotal`, `grandtotal`, `tax`, `discount`, `card_number`, `cheque_number`, `gift_card`, `pump_operators_id`, `pump_id`, `short_amount`, `payment_deails`, `ow_id`, `type`) VALUES ('11', '8', '3', 'Product3', 'Product3', '20', '10.00', '10.00', '85', NULL, '0', '0', '', '0', '850', '850', '850', '0', '0', '', '', '', '1', '1', NULL, NULL, '1', '1');
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_code`, `product_name`, `product_category`, `cost`, `price`, `qty`, `customer_id`, `vt_status`, `payment_method`, `payment_method_name`, `return_change`, `paid`, `subtotal`, `grandtotal`, `tax`, `discount`, `card_number`, `cheque_number`, `gift_card`, `pump_operators_id`, `pump_id`, `short_amount`, `payment_deails`, `ow_id`, `type`) VALUES ('12', '9', '3', 'Product3', 'Product3', '20', '10.00', '10.00', '65', NULL, '0', '0', '', '0', '650', '650', '650', '0', '0', '', '', '', '2', '1', NULL, NULL, '1', '1');


#
# TABLE STRUCTURE FOR: order_items_gold
#

DROP TABLE IF EXISTS `order_items_gold`;

CREATE TABLE `order_items_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_category` int(11) NOT NULL,
  `cost` double(11,2) NOT NULL,
  `weight` float(10,3) NOT NULL,
  `price` double(11,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vt_status` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `return_change` double NOT NULL,
  `paid` double NOT NULL,
  `subtotal` double NOT NULL,
  `grandtotal` double NOT NULL,
  `tax` double NOT NULL,
  `card_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cheque_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subs` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `subv` tinyint(2) NOT NULL,
  `gift_card` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pump_operators_id` int(11) NOT NULL,
  `pump_id` int(11) DEFAULT NULL,
  `short_amount` float DEFAULT NULL,
  `payment_deails` text COLLATE utf8_unicode_ci,
  `work_status_item` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: orders
#

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `outlet_name` varchar(255) NOT NULL DEFAULT '',
  `outlet_address` varchar(255) NOT NULL DEFAULT '',
  `outlet_contact` varchar(255) NOT NULL,
  `outlet_receipt_footer` text NOT NULL,
  `customer_id` varchar(255) NOT NULL DEFAULT '',
  `created_by` varchar(255) NOT NULL,
  `pump_operators_id` varchar(255) NOT NULL DEFAULT '',
  `settlement_no` varchar(255) NOT NULL DEFAULT '',
  `total_items` varchar(255) NOT NULL DEFAULT '',
  `sid` varchar(255) NOT NULL,
  `discount_total` varchar(255) NOT NULL DEFAULT '0',
  `tpaid` varchar(255) NOT NULL DEFAULT '0',
  `totalamount` varchar(255) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `orders` (`id`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `customer_id`, `created_by`, `pump_operators_id`, `settlement_no`, `total_items`, `sid`, `discount_total`, `tpaid`, `totalamount`, `created_at`, `status`) VALUES ('3', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '1', '36', '', '1', '740', '1', '0', '7400.00', '7400.00', '2017-08-04 08:37:17', '1');
INSERT INTO `orders` (`id`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `customer_id`, `created_by`, `pump_operators_id`, `settlement_no`, `total_items`, `sid`, `discount_total`, `tpaid`, `totalamount`, `created_at`, `status`) VALUES ('5', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '1', '36', '2', '4', '95', '2', '0', '950.00', '950.00', '2017-08-04 10:22:49', '1');
INSERT INTO `orders` (`id`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `customer_id`, `created_by`, `pump_operators_id`, `settlement_no`, `total_items`, `sid`, `discount_total`, `tpaid`, `totalamount`, `created_at`, `status`) VALUES ('6', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '1', '36', '1', '6', '85', '3', '0', '850.00', '850.00', '2017-08-04 10:25:45', '1');
INSERT INTO `orders` (`id`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `customer_id`, `created_by`, `pump_operators_id`, `settlement_no`, `total_items`, `sid`, `discount_total`, `tpaid`, `totalamount`, `created_at`, `status`) VALUES ('7', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '1', '36', '2', '7', '95', '4', '0', '950.00', '950.00', '2017-08-04 10:36:41', '1');
INSERT INTO `orders` (`id`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `customer_id`, `created_by`, `pump_operators_id`, `settlement_no`, `total_items`, `sid`, `discount_total`, `tpaid`, `totalamount`, `created_at`, `status`) VALUES ('8', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '4', '36', '1', '8', '85', '5', '0', '850.00', '850.00', '2017-08-04 10:44:47', '1');
INSERT INTO `orders` (`id`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `customer_id`, `created_by`, `pump_operators_id`, `settlement_no`, `total_items`, `sid`, `discount_total`, `tpaid`, `totalamount`, `created_at`, `status`) VALUES ('9', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '1', '36', '2', '9', '65', '6', '0', '650.00', '650.00', '2017-08-04 13:43:22', '1');


#
# TABLE STRUCTURE FOR: orders_gold
#

DROP TABLE IF EXISTS `orders_gold`;

CREATE TABLE `orders_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `customer_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordered_datetime` datetime NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `outlet_contact` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_receipt_footer` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gift_card` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtotal` double(11,2) NOT NULL,
  `discount_total` double(11,2) NOT NULL,
  `discount_percentage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` double(11,2) NOT NULL,
  `grandtotal` double(11,2) NOT NULL,
  `total_items` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_estimate` tinyint(4) NOT NULL,
  `new_item` tinyint(4) NOT NULL,
  `exchange` tinyint(4) NOT NULL,
  `discount_` tinyint(4) NOT NULL,
  `old_gold` tinyint(4) NOT NULL,
  `sale_officer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoice_` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `minimum_total` float(10,2) NOT NULL,
  `total_weight` float(6,3) NOT NULL,
  `cheque_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid_amt` double(11,2) NOT NULL,
  `return_change` double(11,2) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `vt_status` int(11) NOT NULL COMMENT '0: Debit Payment, 1: Completed',
  `status` int(11) NOT NULL COMMENT '1: Sales, 2: Return',
  `refund_status` int(11) NOT NULL COMMENT '1: Full Refund, 2: Partial Refund',
  `remark` longtext COLLATE utf8_unicode_ci NOT NULL,
  `card_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sid` int(11) NOT NULL,
  `pump_operators_id` int(11) NOT NULL,
  `pump_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `short_amount` float DEFAULT NULL,
  `payment_deails` text COLLATE utf8_unicode_ci,
  `payment_details` text COLLATE utf8_unicode_ci,
  `work_status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: orders_payment
#

DROP TABLE IF EXISTS `orders_payment`;

CREATE TABLE `orders_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `customer_email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `customer_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordered_datetime` datetime NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `outlet_contact` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_receipt_footer` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gift_card` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subtotal` double(11,2) NOT NULL,
  `discount_total` double(11,2) NOT NULL,
  `discount_percentage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` double(11,2) NOT NULL,
  `grandtotal` double(11,2) NOT NULL,
  `extra_credit_debit_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `total_items` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cheque_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid_amt` double(11,2) NOT NULL,
  `unpaid_amt` double(11,2) NOT NULL,
  `return_change` double(11,2) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `vt_status` int(11) NOT NULL COMMENT '0: Debit Payment, 1: Completed',
  `status` int(11) NOT NULL COMMENT '1: Sales, 2: Return',
  `refund_status` int(11) NOT NULL COMMENT '1: Full Refund, 2: Partial Refund',
  `remark` longtext COLLATE utf8_unicode_ci NOT NULL,
  `card_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sid` int(11) NOT NULL,
  `pump_operators_id` int(11) NOT NULL,
  `pump_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `short_amount` float DEFAULT NULL,
  `payment_deails` text COLLATE utf8_unicode_ci,
  `payment_details` text COLLATE utf8_unicode_ci,
  `staffPoint` int(11) NOT NULL,
  `customer_Point` int(11) NOT NULL DEFAULT '0',
  `voucher_number` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `customer_note` varchar(5000) COLLATE utf8_unicode_ci NOT NULL,
  `bank` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `cheque_date` date NOT NULL,
  `bring_forword` double(11,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('3', '3', '1', 'Test Customer 1', 'tc1@gmail.com', '1111', '2017-08-04 08:37:17', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '7400.00', '0.00', '', '0.00', '7400.00', '0', '0', '1', 'Cash', '', '7400.00', '0.00', '0.00', '36', '2017-08-04 08:37:17', '36', '2017-08-04 08:37:17', '1', '1', '0', '', '', '1', '0', '0', '0', NULL, NULL, NULL, '0', '148', '', '', '', '0000-00-00', '36185.75');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('7', '6', '1', 'Walk In Customer', 'tc1@gmail.com', '1111', '2017-08-04 10:25:44', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '800.00', '0.00', '', '0.00', '800.00', '0', '0', '1', 'Cash', '', '800.00', '0.00', '0.00', '36', '2017-08-04 10:25:44', '36', '2017-08-04 10:25:44', '1', '1', '0', '', '', '3', '1', '0', '0', NULL, NULL, NULL, '0', '16', '', '', '', '0000-00-00', '44535.75');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('6', '5', '1', 'Walk In Customer', 'tc1@gmail.com', '1111', '2017-08-04 10:22:49', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '950.00', '0.00', '', '0.00', '950.00', '0', '0', '1', 'Cash', '', '950.00', '0.00', '0.00', '36', '2017-08-04 10:22:49', '36', '2017-08-04 10:22:49', '1', '1', '0', '', '', '2', '2', '0', '0', NULL, NULL, NULL, '0', '19', '', '', '', '0000-00-00', '43585.75');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('8', '6', '1', 'Walk In Customer', 'tc1@gmail.com', '1111', '2017-08-04 10:25:44', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '50.00', '0.00', '', '0.00', '50.00', '0', '0', '9', 'Shortage Account', '', '50.00', '0.00', '0.00', '36', '2017-08-04 10:25:44', '36', '2017-08-04 10:25:44', '1', '1', '0', '', '', '3', '1', '0', '0', NULL, NULL, NULL, '0', '1', '', '', '', '0000-00-00', '300.00');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('9', '7', '4', 'XYZ', 'c3@1.com', '1', '2017-08-04 10:36:40', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '300.00', '0.00', '', '0.00', '300.00', '0', '0', '17', 'vouchers', '', '0.00', '300.00', '0.00', '36', '2017-08-04 10:36:40', '36', '2017-08-04 10:36:40', '0', '1', '0', '', '', '4', '2', '0', '0', NULL, NULL, NULL, '0', '6', '123', 'note - 1', '', '0000-00-00', '250.00');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('10', '7', '2', 'Test Customer', 'tc@gmail.com', '11', '2017-08-04 10:36:40', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '50.00', '0.00', '', '0.00', '50.00', '0', '0', '9', 'Shortage Account', '', '50.00', '0.00', '0.00', '36', '2017-08-04 10:36:40', '36', '2017-08-04 10:36:40', '1', '1', '0', '', '', '4', '2', '0', '0', NULL, NULL, NULL, '0', '1', '123', 'note - 1', '', '0000-00-00', '350.00');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('11', '7', '1', 'Walk In Customer', 'tc1@gmail.com', '1111', '2017-08-04 10:36:40', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '600.00', '0.00', '', '0.00', '600.00', '0', '0', '1', 'Cash', '', '600.00', '0.00', '0.00', '36', '2017-08-04 10:36:40', '36', '2017-08-04 10:36:40', '1', '1', '0', '', '', '4', '2', '0', '0', NULL, NULL, NULL, '0', '12', '123', 'note - 1', '', '0000-00-00', '45335.75');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('12', '8', '4', 'XYZ', 'c3@1.com', '1', '2017-08-04 10:44:46', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '850.00', '0.00', '', '0.00', '850.00', '0', '0', '5', 'Cheque', 'ch-123', '850.00', '0.00', '0.00', '36', '2017-08-04 10:44:46', '36', '2017-08-04 10:44:46', '1', '1', '0', '', '', '5', '1', '0', '0', NULL, NULL, NULL, '0', '17', '', '', 'anz', '2017-08-31', '100.00');
INSERT INTO `orders_payment` (`id`, `order_id`, `customer_id`, `customer_name`, `customer_email`, `customer_mobile`, `ordered_datetime`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `outlet_receipt_footer`, `gift_card`, `subtotal`, `discount_total`, `discount_percentage`, `tax`, `grandtotal`, `extra_credit_debit_balance`, `total_items`, `payment_method`, `payment_method_name`, `cheque_number`, `paid_amt`, `unpaid_amt`, `return_change`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `vt_status`, `status`, `refund_status`, `remark`, `card_number`, `sid`, `pump_operators_id`, `pump_id`, `appointment_id`, `short_amount`, `payment_deails`, `payment_details`, `staffPoint`, `customer_Point`, `voucher_number`, `customer_note`, `bank`, `cheque_date`, `bring_forword`) VALUES ('13', '9', '1', 'Walk In Customer', 'tc1@gmail.com', '1111', '2017-08-04 13:43:22', '1', 'Outlet1', 'Outlet ', '1234567890', '<p>Outlet</p>', '', '650.00', '0.00', '', '0.00', '650.00', '0', '0', '1', 'Cash', '', '650.00', '0.00', '0.00', '36', '2017-08-04 13:43:22', '36', '2017-08-04 13:43:22', '1', '1', '0', '', '', '6', '2', '0', '0', NULL, NULL, NULL, '0', '13', '', '', '', '0000-00-00', '45935.75');


#
# TABLE STRUCTURE FOR: other_cost_and_name
#

DROP TABLE IF EXISTS `other_cost_and_name`;

CREATE TABLE `other_cost_and_name` (
  `other_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_reference_id` varchar(100) NOT NULL,
  `other_name` varchar(100) NOT NULL,
  `other_cost` float(10,3) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`other_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: other_cost_and_name_estimate_order
#

DROP TABLE IF EXISTS `other_cost_and_name_estimate_order`;

CREATE TABLE `other_cost_and_name_estimate_order` (
  `est_other_id` int(11) NOT NULL,
  `invoice` varchar(100) NOT NULL,
  `other_name` varchar(100) NOT NULL,
  `other_cost` float(10,3) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `code_` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: outlet_warehouse
#

DROP TABLE IF EXISTS `outlet_warehouse`;

CREATE TABLE `outlet_warehouse` (
  `ow_id` int(11) NOT NULL AUTO_INCREMENT,
  `out_id` int(11) NOT NULL,
  `w_id` int(11) NOT NULL,
  `centerwarehouse_id` int(11) NOT NULL,
  `ow_date` date NOT NULL,
  PRIMARY KEY (`ow_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `outlet_warehouse` (`ow_id`, `out_id`, `w_id`, `centerwarehouse_id`, `ow_date`) VALUES ('1', '1', '1', '0', '2017-08-03');
INSERT INTO `outlet_warehouse` (`ow_id`, `out_id`, `w_id`, `centerwarehouse_id`, `ow_date`) VALUES ('2', '1', '2', '0', '2017-08-03');
INSERT INTO `outlet_warehouse` (`ow_id`, `out_id`, `w_id`, `centerwarehouse_id`, `ow_date`) VALUES ('3', '1', '3', '0', '2017-08-03');


#
# TABLE STRUCTURE FOR: outlets
#

DROP TABLE IF EXISTS `outlets`;

CREATE TABLE `outlets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `contact_number` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `receipt_header` longtext COLLATE utf8_unicode_ci NOT NULL,
  `receipt_footer` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL COMMENT '1: Active, 0: Inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `outlets` (`id`, `name`, `store_id`, `address`, `contact_number`, `receipt_header`, `receipt_footer`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('1', 'Outlet1', '1', 'Outlet ', '1234567890', '', '<p>Outlet</p>', '36', '2017-07-14 14:41:03', '0', '0000-00-00 00:00:00', '1');


#
# TABLE STRUCTURE FOR: payment_method
#

DROP TABLE IF EXISTS `payment_method`;

CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `balance` text COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('1', 'Cash', '46585.75', '1', '2016-09-25 01:43:41', '36', '2017-08-04 13:43:22', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('3', 'Credit cards', '1095', '1', '2016-09-25 01:43:50', '36', '2017-08-01 12:05:03', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('5', 'Cheque', '950', '1', '2016-09-25 01:44:02', '36', '2017-08-04 10:44:46', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('6', 'Debit / Credit Sales ', '22400', '1', '2016-09-25 01:44:05', '36', '2017-08-01 14:09:09', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('7', 'Gift Card', '', '1', '2016-10-16 01:23:05', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('8', 'Deposit', '0', '1', '2016-11-27 23:09:14', '36', '2017-07-02 11:06:12', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('9', 'Shortage Account', '400', '6', '2017-01-05 15:06:10', '36', '2017-08-04 10:36:40', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('10', 'Free', '0', '1', '2017-01-30 20:36:44', '36', '2017-06-23 21:36:43', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('11', 'Points', '', '1', '2017-02-09 21:01:19', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('13', 'Dialog Cards ', '0', '36', '2017-06-04 17:20:51', '36', '2017-07-18 14:13:59', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('14', 'Visa / Master', '0', '36', '2017-06-04 17:21:23', '36', '2017-07-02 19:37:41', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('15', 'Amex', '0', '36', '2017-06-04 17:21:39', '36', '2017-07-18 14:13:59', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('16', 'P B Visa', '0', '36', '2017-06-04 17:22:13', '36', '2017-07-02 11:06:12', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('17', 'vouchers', '550', '0', '0000-00-00 00:00:00', '36', '2017-08-04 10:36:40', '1');
INSERT INTO `payment_method` (`id`, `name`, `balance`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('19', 'excess', '0', '36', '2017-07-03 18:12:00', '36', '2017-08-04 10:11:26', '1');


#
# TABLE STRUCTURE FOR: permissions
#

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `add_right` tinyint(1) NOT NULL,
  `edit_right` tinyint(1) NOT NULL,
  `view_right` tinyint(1) NOT NULL,
  `delete_right` tinyint(1) NOT NULL,
  `print_right` tinyint(1) NOT NULL,
  `email_right` tinyint(1) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=200 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('1', '36', '1', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('2', '36', '2', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('3', '36', '3', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('4', '36', '4', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('5', '36', '5', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('6', '36', '6', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('7', '36', '7', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('8', '36', '8', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('9', '36', '9', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('10', '36', '10', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('11', '36', '11', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('12', '36', '12', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('13', '36', '13', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('14', '36', '14', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('15', '36', '15', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('16', '36', '16', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('17', '36', '17', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('18', '36', '18', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('19', '36', '19', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('20', '36', '20', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('21', '36', '21', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('22', '36', '22', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('23', '36', '23', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('24', '36', '24', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('25', '36', '25', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('26', '36', '26', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('27', '36', '27', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('28', '36', '28', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('29', '36', '29', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('30', '36', '30', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('31', '36', '31', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('32', '36', '32', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('33', '36', '33', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('34', '36', '34', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('35', '36', '35', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('36', '36', '36', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('37', '36', '37', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('38', '36', '38', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('39', '36', '39', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('40', '36', '40', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('41', '36', '41', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('42', '36', '42', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('43', '36', '43', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('44', '36', '44', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('45', '36', '45', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('46', '36', '46', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('47', '36', '47', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('48', '36', '48', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('49', '36', '49', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('50', '36', '50', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('51', '36', '51', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('52', '36', '52', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('53', '36', '53', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('54', '36', '54', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('55', '36', '55', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('56', '36', '56', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('57', '36', '57', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('58', '36', '58', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('59', '36', '59', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('60', '36', '60', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('61', '36', '61', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('62', '36', '62', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('63', '36', '63', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('64', '36', '64', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('65', '36', '65', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('66', '36', '66', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('67', '36', '67', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('68', '36', '68', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('69', '36', '69', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('70', '36', '70', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('71', '36', '71', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('72', '36', '72', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('73', '36', '73', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('74', '36', '74', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('75', '36', '75', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('76', '36', '76', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('77', '36', '77', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('78', '36', '78', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('79', '36', '79', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('80', '36', '80', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('81', '36', '81', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('82', '36', '82', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('83', '36', '84', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('84', '36', '85', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('85', '36', '86', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('86', '36', '87', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('87', '36', '88', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('88', '36', '89', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('89', '36', '83', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('90', '20', '1', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('91', '20', '2', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('92', '20', '3', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('93', '20', '4', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('94', '20', '5', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('95', '20', '6', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('96', '20', '7', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('97', '20', '8', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('98', '20', '9', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('99', '20', '10', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('100', '20', '11', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('101', '20', '12', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('102', '20', '13', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('103', '20', '14', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('104', '20', '15', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('105', '20', '16', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('106', '20', '17', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('107', '20', '18', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('108', '20', '19', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('109', '20', '20', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('110', '20', '21', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('111', '20', '22', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('112', '20', '23', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('113', '20', '24', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('114', '20', '25', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('115', '20', '26', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('116', '20', '27', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('117', '20', '28', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('118', '20', '29', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('119', '20', '30', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('120', '20', '31', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('121', '20', '32', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('122', '20', '33', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('123', '20', '34', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('124', '20', '35', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('125', '20', '36', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('126', '20', '37', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('127', '20', '38', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('128', '20', '39', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('129', '20', '40', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('130', '20', '41', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('131', '20', '42', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('132', '20', '43', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('133', '20', '44', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('134', '20', '45', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('135', '20', '46', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('136', '20', '47', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('137', '20', '48', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('138', '20', '49', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('139', '20', '50', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('140', '20', '51', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('141', '20', '52', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('142', '20', '53', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('143', '20', '54', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('144', '20', '55', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('145', '20', '56', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('146', '20', '57', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('147', '20', '58', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('148', '20', '59', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('149', '20', '60', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('150', '20', '61', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('151', '20', '62', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('152', '20', '63', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('153', '20', '64', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('154', '20', '65', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('155', '20', '66', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('156', '20', '67', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('157', '20', '68', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('158', '20', '69', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('159', '20', '70', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('160', '20', '71', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('161', '20', '72', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('162', '20', '73', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('163', '20', '74', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('164', '20', '75', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('165', '20', '76', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('166', '20', '77', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('167', '20', '78', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('168', '20', '79', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('169', '20', '80', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('170', '20', '81', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('171', '20', '82', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('172', '20', '83', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('173', '20', '84', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('174', '20', '85', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('175', '20', '86', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('176', '20', '87', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('177', '20', '88', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('178', '20', '89', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('179', '20', '90', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('180', '36', '90', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('181', '36', '114', '0', '0', '0', '0', '0', '0', '36', '2017-07-31 19:22:01', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('182', '36', '115', '0', '0', '0', '0', '0', '0', '36', '2017-08-01 12:56:42', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('183', '36', '91', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('184', '36', '102', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('185', '36', '103', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('186', '36', '107', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('187', '36', '109', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('188', '36', '97', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('189', '36', '108', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('190', '36', '98', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('191', '36', '104', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('192', '36', '105', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('193', '36', '95', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('194', '36', '96', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('195', '36', '106', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('196', '36', '99', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('197', '36', '100', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('198', '36', '101', '1', '1', '1', '1', '1', '1', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('199', '36', '116', '0', '0', '0', '0', '0', '0', '36', '2017-08-03 15:40:56', '0', '0000-00-00 00:00:00');


#
# TABLE STRUCTURE FOR: prepay
#

DROP TABLE IF EXISTS `prepay`;

CREATE TABLE `prepay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment` double NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `prepay` (`id`, `customer_id`, `payment_method`, `payment`, `outlet_id`, `created_by`, `created`) VALUES ('2', '15', '1', '0', '0', '36', '2017-07-02 10:52:41');


#
# TABLE STRUCTURE FOR: pro_subcategory_gold
#

DROP TABLE IF EXISTS `pro_subcategory_gold`;

CREATE TABLE `pro_subcategory_gold` (
  `pro_cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_` varchar(10) NOT NULL,
  `cate_date` date NOT NULL,
  `pro_cate_date_creation` date NOT NULL,
  PRIMARY KEY (`pro_cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: product_code_numbering
#

DROP TABLE IF EXISTS `product_code_numbering`;

CREATE TABLE `product_code_numbering` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL,
  `auto_generate_code` varchar(255) NOT NULL DEFAULT '0',
  `change_daily` varchar(255) NOT NULL DEFAULT '0',
  `change_weekly` varchar(255) NOT NULL DEFAULT '0',
  `change_monthly` varchar(255) NOT NULL DEFAULT '0',
  `change_yearly` varchar(255) NOT NULL DEFAULT '0',
  `current_year` varchar(255) NOT NULL DEFAULT '0',
  `current_month` varchar(255) NOT NULL DEFAULT '0',
  `current_day` varchar(255) NOT NULL DEFAULT '0',
  `enter_starting_number` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0=active, 1=inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `product_code_numbering` (`id`, `user_id`, `created_date`, `auto_generate_code`, `change_daily`, `change_weekly`, `change_monthly`, `change_yearly`, `current_year`, `current_month`, `current_day`, `enter_starting_number`, `status`) VALUES ('2', '36', '2017-07-03 13:19:28', '1', '0', '1', '0', '0', '0', '0', '1', '1', '0');


#
# TABLE STRUCTURE FOR: production
#

DROP TABLE IF EXISTS `production`;

CREATE TABLE `production` (
  `pro_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pro_reference` varchar(100) NOT NULL,
  `pro_out_id` int(11) NOT NULL,
  `goldsmith` int(11) NOT NULL,
  `pro_date_created` datetime NOT NULL,
  `pro_type` varchar(100) NOT NULL,
  `pro_qty` float(20,3) NOT NULL,
  `pro_ware` int(11) NOT NULL,
  `pro_grade` int(11) NOT NULL,
  `pro_wastage` float(10,3) NOT NULL,
  `pro_total_product` float(10,3) NOT NULL,
  `pro_otherweight` float(10,3) NOT NULL,
  `pro_wastage_cal` float(10,3) NOT NULL,
  `pro_total_gold_wastage` float(10,3) NOT NULL,
  `pro_goldsmith_was` float(10,3) NOT NULL,
  `design_cost` float(10,2) NOT NULL,
  `stone_cost` float(10,2) NOT NULL,
  `labour_cost` float(10,2) NOT NULL,
  `day_price` float(10,2) NOT NULL,
  `labour_unit_cost` float(10,2) NOT NULL,
  `pro_date` date NOT NULL,
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: products
#

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `generic_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `sub_category_id_fk` int(11) NOT NULL,
  `purchase_price` double(11,5) NOT NULL,
  `retail_price` double(11,2) NOT NULL,
  `thumbnail` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `rack` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `brand_id_fk` int(11) NOT NULL,
  `alt_qty` int(11) NOT NULL DEFAULT '0',
  `outlet_id_fk` int(11) NOT NULL,
  `weight` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `start_qty` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_id_fk` int(11) DEFAULT NULL,
  `expire` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `products` (`id`, `code`, `name`, `generic_name`, `category`, `sub_category_id_fk`, `purchase_price`, `retail_price`, `thumbnail`, `rack`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `brand_id_fk`, `alt_qty`, `outlet_id_fk`, `weight`, `start_qty`, `supplier_id_fk`, `expire`) VALUES ('1', 'Product1', 'Product1', 'Product1', '21', '9', '10.00000', '10.00', 'no_image.jpg', '10', '36', '2017-08-03 15:23:40', '0', '0000-00-00 00:00:00', '1', '0', '10', '1', '10', '2500', '1', '10');
INSERT INTO `products` (`id`, `code`, `name`, `generic_name`, `category`, `sub_category_id_fk`, `purchase_price`, `retail_price`, `thumbnail`, `rack`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `brand_id_fk`, `alt_qty`, `outlet_id_fk`, `weight`, `start_qty`, `supplier_id_fk`, `expire`) VALUES ('2', 'Product2', 'Product2', 'Product2', '21', '9', '12.00000', '10.00', 'no_image.jpg', '10', '36', '2017-08-03 15:24:15', '36', '2017-08-04 11:13:57', '1', '0', '275', '1', '10', '250', '1', '10');
INSERT INTO `products` (`id`, `code`, `name`, `generic_name`, `category`, `sub_category_id_fk`, `purchase_price`, `retail_price`, `thumbnail`, `rack`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `brand_id_fk`, `alt_qty`, `outlet_id_fk`, `weight`, `start_qty`, `supplier_id_fk`, `expire`) VALUES ('3', 'Product3', 'Product3', 'Product3', '20', '1', '10.00000', '10.00', 'no_image.jpg', '10', '36', '2017-08-03 15:27:33', '36', '2017-08-04 11:14:35', '1', '0', '150', '1', '10', '0', '1', '10');
INSERT INTO `products` (`id`, `code`, `name`, `generic_name`, `category`, `sub_category_id_fk`, `purchase_price`, `retail_price`, `thumbnail`, `rack`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `brand_id_fk`, `alt_qty`, `outlet_id_fk`, `weight`, `start_qty`, `supplier_id_fk`, `expire`) VALUES ('4', 'Product4', 'Product4', 'Product4', '20', '0', '10.00000', '10.00', 'no_image.jpg', '10', '36', '2017-08-03 15:28:02', '0', '0000-00-00 00:00:00', '1', '0', '10', '1', '10', '0', '1', '10');


#
# TABLE STRUCTURE FOR: pump_operators
#

DROP TABLE IF EXISTS `pump_operators`;

CREATE TABLE `pump_operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `pump_id` varchar(255) NOT NULL DEFAULT '',
  `operator_name` varchar(100) NOT NULL,
  `operator_cnic` varchar(100) NOT NULL,
  `operator_address` varchar(255) NOT NULL,
  `operator_dob` date NOT NULL,
  `operator_telephone_number` varchar(20) NOT NULL,
  `operator_mobile_number` varchar(20) NOT NULL,
  `assigned_pump_id` int(11) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `commission_type` enum('fixed','percentage') NOT NULL,
  `commission_ap` double NOT NULL,
  `short_amount` int(11) NOT NULL,
  `excess_amount` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `pump_operators` (`id`, `outlet_id`, `pump_id`, `operator_name`, `operator_cnic`, `operator_address`, `operator_dob`, `operator_telephone_number`, `operator_mobile_number`, `assigned_pump_id`, `status`, `commission_type`, `commission_ap`, `short_amount`, `excess_amount`) VALUES ('2', '1', '', 'all in one', '45', 'qaw', '2017-07-20', '654', '13', '0', '1', '', '0', '350', '0');
INSERT INTO `pump_operators` (`id`, `outlet_id`, `pump_id`, `operator_name`, `operator_cnic`, `operator_address`, `operator_dob`, `operator_telephone_number`, `operator_mobile_number`, `assigned_pump_id`, `status`, `commission_type`, `commission_ap`, `short_amount`, `excess_amount`) VALUES ('3', '1', '', 'Test Pumper ', '11', 'ads', '2017-07-13', '11', '11', '0', '1', 'fixed', '0.2', '0', '0');


#
# TABLE STRUCTURE FOR: pump_reading
#

DROP TABLE IF EXISTS `pump_reading`;

CREATE TABLE `pump_reading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_id` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `pump_id` varchar(255) NOT NULL DEFAULT '',
  `product_id` varchar(255) NOT NULL DEFAULT '',
  `start_meter` varchar(255) NOT NULL DEFAULT '',
  `end_meter` varchar(255) NOT NULL DEFAULT '',
  `sold_qty` varchar(255) NOT NULL DEFAULT '',
  `testing_qty` varchar(255) NOT NULL DEFAULT '',
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`) VALUES ('3', '1', '1', '1', '3', '0.0000', '500', '495', '5', '4950.00', '2017-08-04 08:37:17');
INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`) VALUES ('4', '1', '1', '2', '4', '0.0000', '250', '245', '5', '2450.00', '2017-08-04 08:37:17');
INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`) VALUES ('6', '4', '1', '1', '3', '500.0000', '600', '95', '5', '950.00', '2017-08-04 10:22:49');
INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`) VALUES ('7', '6', '1', '1', '3', '600.0000', '690', '85', '5', '850.00', '2017-08-04 10:25:44');
INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`) VALUES ('8', '7', '1', '1', '3', '690.0000', '790', '95', '5', '950.00', '2017-08-04 10:36:40');
INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`) VALUES ('9', '8', '1', '1', '3', '790.0000', '880', '85', '5', '850.00', '2017-08-04 10:44:46');
INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`) VALUES ('10', '9', '1', '1', '3', '880.0000', '950', '65', '5', '650.00', '2017-08-04 13:43:22');


#
# TABLE STRUCTURE FOR: pump_testing
#

DROP TABLE IF EXISTS `pump_testing`;

CREATE TABLE `pump_testing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_id` varchar(255) NOT NULL DEFAULT '',
  `pump_id` varchar(255) NOT NULL DEFAULT '',
  `order_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `pump_operators_id` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL DEFAULT '0',
  `testing_qty` varchar(255) NOT NULL DEFAULT '0',
  `grand_total` varchar(255) NOT NULL DEFAULT '0',
  `created_by` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO `pump_testing` (`id`, `settlement_id`, `pump_id`, `order_id`, `product_id`, `outlet_id`, `product_code`, `pump_operators_id`, `price`, `testing_qty`, `grand_total`, `created_by`, `created_at`) VALUES ('1', '1', '1', '3', '3', '1', 'Product3', '', '10.00', '5', '50', '36', '2017-08-04 08:37:17');
INSERT INTO `pump_testing` (`id`, `settlement_id`, `pump_id`, `order_id`, `product_id`, `outlet_id`, `product_code`, `pump_operators_id`, `price`, `testing_qty`, `grand_total`, `created_by`, `created_at`) VALUES ('2', '1', '2', '3', '4', '1', 'Product4', '', '10.00', '5', '50', '36', '2017-08-04 08:37:17');
INSERT INTO `pump_testing` (`id`, `settlement_id`, `pump_id`, `order_id`, `product_id`, `outlet_id`, `product_code`, `pump_operators_id`, `price`, `testing_qty`, `grand_total`, `created_by`, `created_at`) VALUES ('4', '4', '1', '5', '3', '1', 'Product3', '2', '10.00', '5', '50', '36', '2017-08-04 10:22:49');
INSERT INTO `pump_testing` (`id`, `settlement_id`, `pump_id`, `order_id`, `product_id`, `outlet_id`, `product_code`, `pump_operators_id`, `price`, `testing_qty`, `grand_total`, `created_by`, `created_at`) VALUES ('5', '6', '1', '6', '3', '1', 'Product3', '1', '10.00', '5', '50', '36', '2017-08-04 10:25:44');
INSERT INTO `pump_testing` (`id`, `settlement_id`, `pump_id`, `order_id`, `product_id`, `outlet_id`, `product_code`, `pump_operators_id`, `price`, `testing_qty`, `grand_total`, `created_by`, `created_at`) VALUES ('6', '7', '1', '7', '3', '1', 'Product3', '2', '10.00', '5', '50', '36', '2017-08-04 10:36:40');
INSERT INTO `pump_testing` (`id`, `settlement_id`, `pump_id`, `order_id`, `product_id`, `outlet_id`, `product_code`, `pump_operators_id`, `price`, `testing_qty`, `grand_total`, `created_by`, `created_at`) VALUES ('7', '8', '1', '8', '3', '1', 'Product3', '1', '10.00', '5', '50', '36', '2017-08-04 10:44:46');
INSERT INTO `pump_testing` (`id`, `settlement_id`, `pump_id`, `order_id`, `product_id`, `outlet_id`, `product_code`, `pump_operators_id`, `price`, `testing_qty`, `grand_total`, `created_by`, `created_at`) VALUES ('8', '9', '1', '9', '3', '1', 'Product3', '2', '10.00', '5', '50', '36', '2017-08-04 13:43:22');


#
# TABLE STRUCTURE FOR: pumper_report
#

DROP TABLE IF EXISTS `pumper_report`;

CREATE TABLE `pumper_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_receipt_no` varchar(255) NOT NULL DEFAULT '',
  `pump_id_fk` int(11) NOT NULL,
  `pumper_id_fk` int(11) NOT NULL,
  `pumper_name` varchar(100) NOT NULL,
  `commission_amount` float NOT NULL,
  `pump_fuel` decimal(13,4) NOT NULL,
  `fuel_type` int(11) NOT NULL COMMENT 'product id',
  `status` tinyint(1) NOT NULL,
  `orderDatetime` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `commission_type` varchar(25) NOT NULL,
  `commission_rate` double NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(100) NOT NULL,
  `sale_amount` double NOT NULL,
  `product_name` varchar(499) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('1', '', '9', '2', 'all in one', '0', '50.0000', '3', '1', '2017-07-25 22:17:57', '36', '', '0', '1', 'Outlet1', '1250', 'S1 - Petrol', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('2', '', '9', '2', 'all in one', '0', '50.0000', '3', '1', '2017-07-25 22:49:59', '36', '', '0', '1', 'Outlet1', '1250', 'S1 - Petrol', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('3', '', '9', '1', 'Test Pumper ', '0', '100.0000', '3', '1', '2017-07-26 12:35:43', '36', '', '0', '1', 'Outlet1', '2500', 'S1 - Petrol', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('4', '', '10', '1', 'Test Pumper ', '0', '5.0000', '3', '1', '2017-07-26 12:40:01', '36', '', '0', '1', 'Outlet1', '125', 'S1 - Petrol', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('5', '6', '8', '2', 'all in one', '0', '95.0000', '3', '1', '2017-07-29 06:12:36', '36', '', '0', '1', 'Outlet1', '2375', 'S1 - Petrol', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('6', '16', '15', '1', 'Test Pumper ', '0', '10.0000', '21', '1', '2017-08-02 13:05:02', '36', '', '0', '1', 'Outlet1', '100', 'Producthardik2', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('7', '17', '9', '1', 'Test Pumper ', '0', '295.0000', '3', '1', '2017-08-02 18:47:27', '36', '', '0', '1', 'Outlet1', '7375', 'S1 - Petrol', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('8', '18', '9', '1', 'Test Pumper ', '0', '195.0000', '3', '1', '2017-08-02 18:48:30', '36', '', '0', '1', 'Outlet1', '4875', 'S1 - Petrol', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('9', '1', '1', '1', 'Test Pumper ', '0', '10.0000', '3', '1', '2017-08-03 15:33:17', '36', '', '0', '1', 'Outlet1', '100', 'Product3', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('10', '1', '2', '1', 'Test Pumper ', '0', '250.0000', '4', '1', '2017-08-03 15:33:17', '36', '', '0', '1', 'Outlet1', '2500', 'Product4', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('11', '4', '1', '1', 'Test Pumper ', '0', '95.0000', '3', '1', '2017-08-04 10:11:27', '36', '', '0', '1', 'Outlet1', '950', 'Product3', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('12', '5', '1', '2', 'all in one', '0', '95.0000', '3', '1', '2017-08-04 10:22:49', '36', '', '0', '1', 'Outlet1', '950', 'Product3', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('13', '6', '1', '1', 'Test Pumper ', '0', '85.0000', '3', '1', '2017-08-04 10:25:45', '36', '', '0', '1', 'Outlet1', '850', 'Product3', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('14', '7', '1', '2', 'all in one', '0', '95.0000', '3', '1', '2017-08-04 10:36:41', '36', '', '0', '1', 'Outlet1', '950', 'Product3', '1');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('15', '8', '1', '1', 'Test Pumper ', '0', '85.0000', '3', '1', '2017-08-04 10:44:47', '36', '', '0', '1', 'Outlet1', '850', 'Product3', '4');
INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES ('16', '9', '1', '2', 'all in one', '0', '65.0000', '3', '1', '2017-08-04 13:43:22', '36', '', '0', '1', 'Outlet1', '650', 'Product3', '1');


#
# TABLE STRUCTURE FOR: pumps
#

DROP TABLE IF EXISTS `pumps`;

CREATE TABLE `pumps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pump_name` varchar(50) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `fuel_type` varchar(255) NOT NULL,
  `installation_date` date NOT NULL,
  `pump_no` varchar(25) NOT NULL,
  `image_link` varchar(300) NOT NULL,
  `storage_tank` varchar(11) DEFAULT NULL,
  `starting_meter` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `last_meter_reading` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `temp_meter_reading` decimal(13,4) NOT NULL DEFAULT '0.0000',
  `pid` int(11) NOT NULL,
  `fuel_tank_ids` text NOT NULL,
  `qty` text NOT NULL,
  `checkk` int(1) NOT NULL DEFAULT '1',
  `testing` varchar(255) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO `pumps` (`id`, `pump_name`, `outlet_id`, `fuel_type`, `installation_date`, `pump_no`, `image_link`, `storage_tank`, `starting_meter`, `last_meter_reading`, `temp_meter_reading`, `pid`, `fuel_tank_ids`, `qty`, `checkk`, `testing`) VALUES ('1', 'Pump1', '1', '', '2017-08-17', 'Pump1', '', NULL, '0.0000', '950.0000', '950.0000', '3', '1', '', '1', '1');
INSERT INTO `pumps` (`id`, `pump_name`, `outlet_id`, `fuel_type`, `installation_date`, `pump_no`, `image_link`, `storage_tank`, `starting_meter`, `last_meter_reading`, `temp_meter_reading`, `pid`, `fuel_tank_ids`, `qty`, `checkk`, `testing`) VALUES ('2', 'Pump2', '1', '', '2017-08-10', 'Pump2', '', NULL, '0.0000', '250.0000', '250.0000', '4', '2', '', '1', '1');


#
# TABLE STRUCTURE FOR: purchase_bills
#

DROP TABLE IF EXISTS `purchase_bills`;

CREATE TABLE `purchase_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `grandtotal` double(11,2) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(499) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(499) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_name` varchar(255) NOT NULL,
  `cheque_number` varchar(90) DEFAULT NULL,
  `cheque_date` date NOT NULL,
  `cheque_bank` varchar(255) NOT NULL DEFAULT '',
  `card_number` varchar(90) DEFAULT NULL,
  `gift_card` varchar(90) DEFAULT NULL,
  `paid_amt` double(11,2) NOT NULL,
  `paid_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: purchase_order
#

DROP TABLE IF EXISTS `purchase_order`;

CREATE TABLE `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_number` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `total_items` int(11) NOT NULL,
  `discount_amount` double(11,2) NOT NULL,
  `discount_percentage` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subTotal` double(11,2) NOT NULL,
  `tax` double(11,2) NOT NULL,
  `grandTotal` double(11,2) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `supplier_tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `outlet_contact` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cheque_number` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gift_card` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `card_number` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `paid_amt` double(11,2) NOT NULL,
  `return_change` double(11,2) NOT NULL,
  `po_date` date NOT NULL,
  `attachment_file` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `note` longtext COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `received_user_id` int(11) NOT NULL,
  `received_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `vt_status` int(1) NOT NULL COMMENT '0: Debit Payment, 1: Completed ',
  `refund_status` int(1) NOT NULL COMMENT '1: Full Refund, 2: Partial Refund ',
  `pid` int(11) NOT NULL,
  `fuel_tank_id` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `purchase_order` (`id`, `po_number`, `total_items`, `discount_amount`, `discount_percentage`, `subTotal`, `tax`, `grandTotal`, `supplier_id`, `supplier_name`, `supplier_email`, `supplier_address`, `supplier_tel`, `supplier_fax`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `payment_method`, `payment_method_name`, `cheque_number`, `gift_card`, `card_number`, `paid_amt`, `return_change`, `po_date`, `attachment_file`, `note`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `received_user_id`, `received_datetime`, `status`, `vt_status`, `refund_status`, `pid`, `fuel_tank_id`) VALUES ('1', '1', '250', '0.00', '0.00', '0.00', '0.00', '2500.00', '1', 'Supplier Co., Ltd', 'supplier@gmail.com', 'asdf', '2345678', '8765432', '1', 'Outlet1', 'Outlet ', '1234567890', '0', '', '', '', '', '0.00', '0.00', '2017-08-04', '', '', '36', '2017-08-04 08:38:46', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '6', '0', '0', '0', '');
INSERT INTO `purchase_order` (`id`, `po_number`, `total_items`, `discount_amount`, `discount_percentage`, `subTotal`, `tax`, `grandTotal`, `supplier_id`, `supplier_name`, `supplier_email`, `supplier_address`, `supplier_tel`, `supplier_fax`, `outlet_id`, `outlet_name`, `outlet_address`, `outlet_contact`, `payment_method`, `payment_method_name`, `cheque_number`, `gift_card`, `card_number`, `paid_amt`, `return_change`, `po_date`, `attachment_file`, `note`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `received_user_id`, `received_datetime`, `status`, `vt_status`, `refund_status`, `pid`, `fuel_tank_id`) VALUES ('2', '2', '100', '0.00', '0.00', '0.00', '0.00', '1200.00', '1', 'Supplier Co., Ltd', 'supplier@gmail.com', 'asdf', '2345678', '8765432', '1', 'Outlet1', 'Outlet ', '1234567890', '0', '', '', '', '', '0.00', '0.00', '2017-08-04', '', '', '36', '2017-08-04 11:35:43', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '6', '0', '0', '0', '');


#
# TABLE STRUCTURE FOR: purchase_order_items
#

DROP TABLE IF EXISTS `purchase_order_items`;

CREATE TABLE `purchase_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `inventory_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `ordered_qty` int(11) NOT NULL,
  `bonusqty` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `bill_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `received_qty` int(11) NOT NULL,
  `cost` double(11,2) NOT NULL,
  `discount_amount` double(11,2) NOT NULL,
  `discount_percentage` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tax` double(11,2) NOT NULL,
  `subTotal` double(11,2) NOT NULL,
  `partail_qty` int(11) NOT NULL DEFAULT '0',
  `warehouse_tank_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `warehouse_tank_status_partial` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `purchase_order_items` (`id`, `po_id`, `inventory_id`, `product_code`, `ordered_qty`, `bonusqty`, `bill_no`, `received_qty`, `cost`, `discount_amount`, `discount_percentage`, `tax`, `subTotal`, `partail_qty`, `warehouse_tank_status`, `warehouse_tank_status_partial`) VALUES ('1', '1', '1', 'Product1', '250', '0', '123', '0', '10.00', '0.00', '0', '0.00', '2500.00', '0', '1', '0');
INSERT INTO `purchase_order_items` (`id`, `po_id`, `inventory_id`, `product_code`, `ordered_qty`, `bonusqty`, `bill_no`, `received_qty`, `cost`, `discount_amount`, `discount_percentage`, `tax`, `subTotal`, `partail_qty`, `warehouse_tank_status`, `warehouse_tank_status_partial`) VALUES ('2', '2', '3', 'Product2', '100', '0', '', '0', '12.00', '0.00', '0', '0.00', '1200.00', '0', '1', '0');


#
# TABLE STRUCTURE FOR: purchase_order_status
#

DROP TABLE IF EXISTS `purchase_order_status`;

CREATE TABLE `purchase_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('1', 'Created', '1', '2016-09-10 00:00:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('2', 'Sent To Supplier', '1', '2016-09-10 00:00:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('3', 'Received From Supplier', '1', '2016-09-10 00:00:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('4', 'Pending', '1', '2017-04-29 00:00:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('5', 'Raised', '1', '2017-04-29 00:00:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('6', 'Received', '1', '2017-04-29 00:00:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('7', 'Archived', '1', '2017-04-29 00:00:00', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('8', 'Partial', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '1');


#
# TABLE STRUCTURE FOR: purchase_received
#

DROP TABLE IF EXISTS `purchase_received`;

CREATE TABLE `purchase_received` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_item_id` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `tank_qty` varchar(255) NOT NULL DEFAULT '0',
  `tank_id` varchar(255) NOT NULL DEFAULT '',
  `inventory_id` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: purchase_taxes
#

DROP TABLE IF EXISTS `purchase_taxes`;

CREATE TABLE `purchase_taxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(100) NOT NULL,
  `tax_rate` int(11) NOT NULL,
  `total_amount` int(11) NOT NULL,
  `tax_amount` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `purchase_id_fk` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: redeem
#

DROP TABLE IF EXISTS `redeem`;

CREATE TABLE `redeem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `staff_redeem` int(11) DEFAULT '0',
  `customer_redeem` int(11) DEFAULT '0',
  `datee` varchar(20) NOT NULL,
  `Created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: refined_job_order
#

DROP TABLE IF EXISTS `refined_job_order`;

CREATE TABLE `refined_job_order` (
  `rjo_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `rjo` varchar(100) NOT NULL,
  `rjo_store_id` int(11) NOT NULL,
  `gold_smith_id` int(11) NOT NULL,
  `gold_grade` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `gold_weigth` float NOT NULL,
  `estimated_weigth` float NOT NULL,
  `status` varchar(30) NOT NULL,
  `date` date NOT NULL,
  `date_created` date NOT NULL,
  PRIMARY KEY (`rjo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: refined_job_received_note
#

DROP TABLE IF EXISTS `refined_job_received_note`;

CREATE TABLE `refined_job_received_note` (
  `rjrn_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date_` date NOT NULL,
  `rjrnn_no` varchar(255) NOT NULL,
  `gs_id` int(11) NOT NULL,
  `job_no` varchar(100) NOT NULL,
  `outlet` varchar(100) NOT NULL,
  `rjrn_store_id` int(11) NOT NULL,
  `gold_grade` int(11) NOT NULL,
  `actual_gold_rec` float NOT NULL,
  `netgold_amount` float NOT NULL,
  `date_created` date NOT NULL,
  PRIMARY KEY (`rjrn_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: resources
#

DROP TABLE IF EXISTS `resources`;

CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('11', '0', 'customers', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('10', '0', 'bank_dt', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('9', '0', 'bank_accounts', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('8', '0', 'auth', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('7', '0', 'appointments', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('12', '0', 'dashboard', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('13', '0', 'debit', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('14', '0', 'debit_to_delete', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('15', '0', 'expenses', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('16', '0', 'gift_card', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('17', '0', 'inventory', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('18', '0', 'pnl', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('19', '0', 'pnl_report', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('20', '0', 'pos', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('21', '0', 'products', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('22', '0', 'pumps', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('23', '0', 'purchase_order', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('24', '0', 'reports', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('25', '0', 'returnorder', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('26', '0', 'sales', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('27', '0', 'setting', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('28', '0', 'unit_test', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('29', '0', 'error', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('30', '0', 'sys_admin', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('31', '0', '123', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('32', '0', 'purchase_order_1', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('33', '0', 'add_appointment', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('34', '0', 'debit / 123', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('35', '0', 'reports Module', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('36', '7', 'index', 'Appointments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('37', '7', 'add_appointment', 'Add Appointments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('38', '7', 'list_appointment', 'Manage Appointments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('39', '0', 'bakery_sales', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('40', '9', 'index', 'Bank Accounts', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('41', '9', 'balance', 'Account balance', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('42', '10', 'index', 'Bank Deposit / Transfer', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('43', '13', 'view', 'Credit Sales', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('44', '15', 'view', 'Expenses', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('45', '15', 'expense_category', 'Expense Category', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('46', '16', 'add_gift_card', 'Add Gift Card', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('47', '16', 'list_gift_card', 'List Gift Card', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('48', '17', 'view', 'Inventory', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('49', '18', 'view', 'P & L Graphs', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('50', '18', 'view_pnl_report', 'P & L Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('51', '20', 'index', 'POS', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('52', '21', 'list_products', 'Products', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('53', '21', 'product_category', 'Product Category', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('54', '21', 'print_label', 'Print Product Label', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('55', '22', 'index', 'List Pumps', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('56', '22', 'list_operators', 'List Pump Operators', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('57', '22', 'list_ft', 'List Fuel Tanks', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('58', '22', 'pumpSales', 'Pump Comm & Shortage', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('59', '23', 'po_view', 'Purchases', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('60', '24', 'sales_report', 'Sales Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('61', '24', 'product_category_report', 'Product Category Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('62', '24', 'issue_sale_report', 'Issue Sales Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('63', '25', 'create_return', 'Sales Return', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('64', '25', 'return_report', 'Sales Return Receipt', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('65', '26', 'view', 'Customers', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('66', '26', 'list_sales', 'Today Sales', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('67', '26', 'opened_bill', 'Opened Bill', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('68', '27', 'outlets', 'Outlets', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('69', '27', 'users', 'Users', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('70', '27', 'payment_methods', 'Payment Metods', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('71', '27', 'system_setting', 'System Setting', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('72', '39', 'bakerySales', 'Bakery Sales', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('73', '11', 'view', 'Customers', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('74', '27', 'suppliers', 'Suppliers', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('75', '0', 'gold', '', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('76', '75', 'rjo', 'RJO', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('77', '75', 'rgrn', 'RGRN', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('78', '0', 'store', 'Stores', '1', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('79', '0', 'gold_product', 'Gold Products', '1', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('80', '0', 'gold_inventory', 'Gold inventory', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('81', '0', 'goldsmith', 'GoldSmith', '1', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('82', '0', 'refine_gold', 'Refined Gold Module', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('83', '0', 'productions', 'Production', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('84', '0', 'staff', 'Staff', '1', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('85', '0', 'brand', 'brand', '1', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('86', '0', 'sub_category', 'Sub Category', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('88', '0', 'settelment', 'Sattelment Collection', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('89', '0', 'esctax', 'Esc Tax', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('90', '0', 'pumperreport', 'Pump Operator Reports', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('91', '0', 'fuelsalereport', 'Fuel Sale Reports', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('92', '0', 'dipreport', 'Dip Reports', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('93', '0', 'purchase_bills', 'Purchase Bills', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('94', '0', 'sales_report_payement', 'Sales Report â€“ Payments', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('95', '0', 'settlement', 'settlement', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('96', '0', 'list_order_estimate', 'List of Order Estimate', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('97', '0', 'voucherdetail', 'Voucher Details', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('98', '0', 'receivedcheque', 'Received Cheque Details', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('99', '27', 'permissions', 'Permissions', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('100', '27', 'permissions', 'Permissions', '0', '2017-06-28 00:00:00', '0', '2017-06-28 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('101', '0', 'bill_numbering', 'Bill Numbering', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('102', '0', 'product_code_numbering', 'Product Code Numbering', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('103', '0', 'reorder_detail', 'Re-order Details', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('104', '0', 'daily_collection', 'Daily Collection', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('105', '0', 'daily_summary_report', 'Daily Summary Report', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('106', '0', 'loan', 'loan', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('107', '0', 'loan_list', 'Loan List', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('108', '0', 'settle_loan', 'Settle Loan', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('109', '0', 'pump_reading', 'Pump Reading', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('110', '0', 'credit_sales_payment', 'Credit Sales Payment', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('111', '0', 'taxes', 'Taxes', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('112', '0', 'testing_detail', 'Testing Detail', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('113', '0', 'add_new_page', 'Add New Page', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('114', '0', 'cheque_manager', 'Cheque Manager', '36', '2017-07-31 19:22:01', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('115', '0', 'settlement_list', 'Settlement List', '36', '2017-08-01 12:56:42', '0', '0000-00-00 00:00:00');
INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('116', '0', 'download_database', 'Download Database', '36', '2017-08-03 15:40:56', '0', '0000-00-00 00:00:00');


#
# TABLE STRUCTURE FOR: return_items
#

DROP TABLE IF EXISTS `return_items`;

CREATE TABLE `return_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(11,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `item_condition` int(11) NOT NULL COMMENT '1: Good, 2: Not Good',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: rules
#

DROP TABLE IF EXISTS `rules`;

CREATE TABLE `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `allowed_type` enum('allow','deny') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'allow',
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=402 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('1', '1', '7', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('2', '1', '8', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('3', '1', '9', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('4', '1', '10', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('5', '1', '11', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('6', '1', '12', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('7', '1', '13', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('8', '1', '14', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('9', '1', '15', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('10', '1', '16', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('11', '1', '17', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('12', '1', '18', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('13', '1', '19', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('14', '1', '20', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('15', '1', '21', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('16', '1', '22', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('17', '1', '23', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('18', '1', '24', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('19', '1', '25', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('20', '1', '26', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('21', '1', '27', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('22', '1', '28', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('23', '2', '7', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('24', '2', '8', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('25', '2', '9', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('26', '2', '10', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('27', '2', '11', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('28', '2', '12', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('29', '2', '13', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('30', '2', '14', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('31', '2', '15', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('32', '2', '16', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('33', '2', '17', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('34', '2', '18', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('35', '2', '19', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('36', '2', '20', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('37', '2', '21', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('38', '2', '22', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('39', '2', '23', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('40', '2', '24', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('41', '2', '25', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('42', '2', '26', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('43', '2', '27', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('44', '2', '28', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('45', '3', '7', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('46', '3', '8', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('47', '3', '9', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('48', '3', '10', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('49', '3', '11', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('50', '3', '12', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('51', '3', '13', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('52', '3', '14', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('53', '3', '15', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('54', '3', '16', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('55', '3', '17', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('56', '3', '18', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('57', '3', '19', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('58', '3', '20', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('59', '3', '21', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('60', '3', '22', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('61', '3', '23', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('62', '3', '24', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('63', '3', '25', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('64', '3', '26', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('65', '3', '27', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('66', '3', '28', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('67', '4', '7', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('68', '4', '8', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('69', '4', '9', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('70', '4', '10', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('71', '4', '11', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('72', '4', '12', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('73', '4', '13', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('74', '4', '14', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('75', '4', '15', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('76', '4', '16', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('77', '4', '17', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('78', '4', '18', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('79', '4', '19', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('80', '4', '20', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('81', '4', '21', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('82', '4', '22', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('83', '4', '23', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('84', '4', '24', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('85', '4', '25', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('86', '4', '26', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('87', '4', '27', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('88', '4', '28', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('89', '6', '7', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('90', '6', '8', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('91', '6', '9', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('92', '6', '10', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('93', '6', '11', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('94', '6', '12', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('95', '6', '13', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('96', '6', '14', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('97', '6', '15', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('98', '6', '16', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('99', '6', '17', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('100', '6', '18', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('101', '6', '19', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('102', '6', '20', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('103', '6', '21', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('104', '6', '22', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('105', '6', '23', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('106', '6', '24', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('107', '6', '25', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('108', '6', '26', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('109', '6', '27', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('110', '6', '28', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('111', '0', '7', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('112', '0', '8', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('113', '0', '9', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('114', '0', '10', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('115', '0', '11', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('116', '0', '12', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('117', '0', '13', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('118', '0', '14', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('119', '0', '15', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('120', '0', '16', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('121', '0', '17', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('122', '0', '18', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('123', '0', '19', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('124', '0', '20', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('125', '0', '21', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('126', '0', '22', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('127', '0', '23', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('128', '0', '24', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('129', '0', '25', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('130', '0', '26', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('131', '0', '27', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('132', '0', '28', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('133', '0', '29', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('134', '2', '29', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('135', '3', '29', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('136', '4', '29', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('137', '6', '29', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('138', '7', '7', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('139', '7', '8', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('140', '7', '9', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('141', '7', '10', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('142', '7', '11', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('143', '7', '12', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('144', '7', '13', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('145', '7', '14', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('146', '7', '15', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('147', '7', '16', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('148', '7', '17', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('149', '7', '18', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('150', '7', '19', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('151', '7', '20', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('152', '7', '21', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('153', '7', '22', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('154', '7', '23', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('155', '7', '24', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('156', '7', '25', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('157', '7', '26', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('158', '7', '27', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('159', '7', '28', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('160', '7', '29', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('161', '7', '30', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('162', '0', '30', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('163', '0', '31', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('164', '0', '32', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('165', '0', '33', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('166', '0', '34', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('167', '1', '29', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('168', '1', '30', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('169', '1', '31', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('170', '1', '32', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('171', '1', '33', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('172', '1', '34', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('173', '2', '30', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('174', '2', '31', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('175', '2', '32', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('176', '2', '33', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('177', '2', '34', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('178', '3', '30', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('179', '3', '31', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('180', '3', '32', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('181', '3', '33', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('182', '3', '34', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('183', '4', '30', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('184', '4', '31', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('185', '4', '32', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('186', '4', '33', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('187', '4', '34', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('188', '6', '30', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('189', '6', '31', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('190', '6', '32', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('191', '6', '33', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('192', '6', '34', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('193', '0', '55', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('194', '0', '37', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('195', '0', '38', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('196', '0', '41', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('197', '0', '65', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('198', '0', '45', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('199', '0', '46', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('200', '0', '47', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('201', '0', '50', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('202', '0', '52', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('203', '0', '53', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('204', '0', '54', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('205', '0', '56', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('206', '0', '57', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('207', '0', '58', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('208', '0', '59', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('209', '0', '60', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('210', '0', '61', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('211', '0', '62', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('212', '0', '63', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('213', '0', '64', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('214', '0', '66', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('215', '0', '67', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('216', '0', '68', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('217', '0', '69', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('218', '0', '70', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('219', '0', '71', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('220', '0', '35', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('221', '0', '39', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('222', '1', '55', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('223', '1', '37', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('224', '1', '38', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('225', '1', '41', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('226', '1', '65', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('227', '1', '45', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('228', '1', '46', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('229', '1', '47', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('230', '1', '50', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('231', '1', '52', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('232', '1', '53', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('233', '1', '54', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('234', '1', '56', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('235', '1', '57', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('236', '1', '58', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('237', '1', '59', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('238', '1', '60', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('239', '1', '61', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('240', '1', '62', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('241', '1', '63', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('242', '1', '64', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('243', '1', '66', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('244', '1', '67', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('245', '1', '68', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('246', '1', '69', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('247', '1', '70', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('248', '1', '71', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('249', '1', '35', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('250', '1', '39', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('251', '1', '72', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('252', '7', '55', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('253', '7', '37', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('254', '7', '38', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('255', '7', '41', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('256', '7', '65', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('257', '7', '45', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('258', '7', '46', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('259', '7', '47', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('260', '7', '50', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('261', '7', '52', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('262', '7', '53', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('263', '7', '54', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('264', '7', '56', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('265', '7', '57', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('266', '7', '58', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('267', '7', '59', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('268', '7', '60', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('269', '7', '61', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('270', '7', '62', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('271', '7', '63', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('272', '7', '64', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('273', '7', '66', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('274', '7', '67', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('275', '7', '68', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('276', '7', '69', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('277', '7', '70', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('278', '7', '71', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('279', '7', '31', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('280', '7', '32', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('281', '7', '33', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('282', '7', '34', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('283', '7', '35', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('284', '7', '39', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('285', '7', '72', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('286', '0', '72', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('287', '6', '55', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('288', '6', '37', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('289', '6', '38', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('290', '6', '41', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('291', '6', '65', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('292', '6', '45', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('293', '6', '46', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('294', '6', '47', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('295', '6', '50', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('296', '6', '52', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('297', '6', '53', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('298', '6', '54', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('299', '6', '56', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('300', '6', '57', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('301', '6', '58', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('302', '6', '59', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('303', '6', '60', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('304', '6', '61', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('305', '6', '62', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('306', '6', '63', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('307', '6', '64', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('308', '6', '66', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('309', '6', '67', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('310', '6', '68', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('311', '6', '69', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('312', '6', '70', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('313', '6', '71', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('314', '6', '35', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('315', '6', '39', 'deny', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('316', '6', '72', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('317', '0', '73', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('318', '0', '74', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('319', '1', '73', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('320', '1', '74', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('321', '1', '75', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('322', '1', '78', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('323', '1', '79', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('324', '1', '80', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('325', '1', '81', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('326', '1', '82', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('327', '1', '83', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('328', '0', '75', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('329', '0', '78', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('330', '0', '79', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('331', '0', '80', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('332', '0', '81', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('333', '0', '82', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('334', '0', '83', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('335', '1', '84', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('336', '1', '85', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('337', '1', '86', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('338', '1', '88', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('339', '1', '89', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('340', '1', '90', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('341', '1', '91', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('342', '1', '92', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('343', '1', '93', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('344', '1', '94', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('345', '1', '95', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('346', '1', '96', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('347', '1', '97', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('348', '1', '98', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('349', '0', '84', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('350', '0', '85', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('351', '0', '86', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('352', '0', '88', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('353', '0', '89', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('354', '0', '90', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('355', '0', '91', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('356', '0', '92', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('357', '0', '93', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('358', '0', '94', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('359', '0', '95', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('360', '0', '96', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('361', '0', '97', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('362', '0', '98', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('363', '7', '73', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('364', '7', '74', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('365', '7', '75', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('366', '7', '78', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('367', '7', '79', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('368', '7', '80', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('369', '7', '81', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('370', '7', '82', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('371', '7', '83', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('372', '7', '84', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('373', '7', '85', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('374', '7', '86', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('375', '7', '88', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('376', '7', '89', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('377', '7', '90', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('378', '7', '91', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('379', '7', '92', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('380', '7', '93', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('381', '7', '94', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('382', '7', '95', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('383', '7', '96', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('384', '7', '97', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('385', '7', '98', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('386', '1', '101', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('387', '1', '102', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('388', '1', '103', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('389', '1', '104', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('390', '1', '105', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('391', '1', '106', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('392', '1', '107', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('393', '1', '108', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('394', '1', '109', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('395', '1', '110', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('396', '1', '111', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('397', '1', '112', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('398', '1', '113', 'allow', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('399', '1', '114', 'allow', '36', '2017-07-31 19:22:01', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('400', '1', '115', 'allow', '36', '2017-08-01 12:56:42', '0', '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('401', '1', '116', 'allow', '36', '2017-08-03 15:40:56', '0', '0000-00-00 00:00:00');


#
# TABLE STRUCTURE FOR: settlement
#

DROP TABLE IF EXISTS `settlement`;

CREATE TABLE `settlement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_no` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `pumper_id` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `total_amount` varchar(25) NOT NULL DEFAULT '0',
  `shift_start_time` varchar(255) NOT NULL DEFAULT '',
  `shift_end_time` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `settlement` (`id`, `settlement_no`, `outlet_id`, `pumper_id`, `note`, `total_amount`, `shift_start_time`, `shift_end_time`, `created_at`) VALUES ('3', '1', '1', '', '', '7400.00', '7 : 59 AM', '7 : 59 AM', '2017-08-04 08:37:17');
INSERT INTO `settlement` (`id`, `settlement_no`, `outlet_id`, `pumper_id`, `note`, `total_amount`, `shift_start_time`, `shift_end_time`, `created_at`) VALUES ('5', '4', '1', '2', '', '950.00', '10 : 19 AM', '10 : 19 AM', '2017-08-04 10:22:49');
INSERT INTO `settlement` (`id`, `settlement_no`, `outlet_id`, `pumper_id`, `note`, `total_amount`, `shift_start_time`, `shift_end_time`, `created_at`) VALUES ('6', '6', '1', '1', '', '850.00', '6 : 22 AM', '7 : 22 PM', '2017-08-04 10:25:44');
INSERT INTO `settlement` (`id`, `settlement_no`, `outlet_id`, `pumper_id`, `note`, `total_amount`, `shift_start_time`, `shift_end_time`, `created_at`) VALUES ('7', '7', '1', '2', '', '950.00', '10 : 32 AM', '10 : 32 AM', '2017-08-04 10:36:40');
INSERT INTO `settlement` (`id`, `settlement_no`, `outlet_id`, `pumper_id`, `note`, `total_amount`, `shift_start_time`, `shift_end_time`, `created_at`) VALUES ('8', '8', '1', '1', '', '850.00', '6 : 41 AM', '12 : 41 AM', '2017-08-04 10:44:46');
INSERT INTO `settlement` (`id`, `settlement_no`, `outlet_id`, `pumper_id`, `note`, `total_amount`, `shift_start_time`, `shift_end_time`, `created_at`) VALUES ('9', '9', '1', '2', '', '650.00', '1 : 42 PM', '1 : 42 PM', '2017-08-04 13:43:22');


#
# TABLE STRUCTURE FOR: site_setting
#

DROP TABLE IF EXISTS `site_setting`;

CREATE TABLE `site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `site_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `pagination` int(11) NOT NULL,
  `tax` double(11,2) NOT NULL,
  `currency` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `display_product` int(11) NOT NULL,
  `display_keyboard` int(11) NOT NULL,
  `default_customer_id` int(11) NOT NULL,
  `default_store_id` int(11) NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `new_settings` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `site_setting` (`id`, `site_name`, `site_logo`, `timezone`, `pagination`, `tax`, `currency`, `datetime_format`, `display_product`, `display_keyboard`, `default_customer_id`, `default_store_id`, `updated_user_id`, `updated_datetime`, `new_settings`) VALUES ('1', 'Onic-Ezymo', 'logo.jpg', 'Asia/Colombo', '10', '0.00', 'LKR', 'd-m-Y', '3', '0', '1', '0', '36', '2017-05-18 18:35:04', '{\"pre_so\":\"\",\"post_so\":\"\",\"pre_po\":\"\",\"post_po\":\"\",\"pumps\":\"\",\"invoice_footer\":\"asd\",\"is_point\":\"yes\",\"point_percentage\":\"2\",\"max_outlets\":\"4\",\"max_pumps18\":\"10\",\"max_pumps17\":\"10\",\"max_pumps1\":\"12\"}');


#
# TABLE STRUCTURE FOR: staff
#

DROP TABLE IF EXISTS `staff`;

CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_code` varchar(100) NOT NULL,
  `staff_name` varchar(100) NOT NULL,
  `staff_mobile` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `division_id` int(11) NOT NULL,
  `assign_outlet` int(11) NOT NULL,
  `address` varchar(40) NOT NULL,
  `staff_cni` varchar(20) NOT NULL,
  `thumbnail` text,
  `points` int(11) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `date_cre` date NOT NULL,
  `point_title` tinyint(1) NOT NULL,
  `point_percentage` varchar(11) DEFAULT '0',
  `isview_sale` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: store_transfer_record
#

DROP TABLE IF EXISTS `store_transfer_record`;

CREATE TABLE `store_transfer_record` (
  `str_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `trans_num` varchar(100) NOT NULL,
  `trans_from_w` int(11) NOT NULL,
  `trans_to_w` int(11) NOT NULL,
  `trans_goldsmith_id` int(11) NOT NULL,
  `trans_items` float(10,3) NOT NULL,
  `total_weight_trans_gold` float(10,3) NOT NULL,
  `total_item_trans` float(10,3) NOT NULL,
  `total_items_cost` float(65,2) NOT NULL,
  `str_user_id` int(11) NOT NULL,
  `str_date_created` datetime NOT NULL,
  `str_date` date NOT NULL,
  PRIMARY KEY (`str_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: store_transform
#

DROP TABLE IF EXISTS `store_transform`;

CREATE TABLE `store_transform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sr_transform_no` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `from_store` varchar(255) NOT NULL DEFAULT '',
  `to_store` varchar(255) NOT NULL DEFAULT '',
  `product_code` varchar(255) NOT NULL DEFAULT '',
  `qty` varchar(255) NOT NULL DEFAULT '',
  `subtotal` varchar(255) NOT NULL DEFAULT '',
  `toStore_warehouse` varchar(255) NOT NULL DEFAULT '',
  `FromStore_warehouse` varchar(255) NOT NULL DEFAULT '',
  `createdby` varchar(255) NOT NULL DEFAULT '',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: stores
#

DROP TABLE IF EXISTS `stores`;

CREATE TABLE `stores` (
  `s_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(100) NOT NULL,
  `s_address` text NOT NULL,
  `s_contact` varchar(100) NOT NULL,
  `s_stock` float(65,3) NOT NULL,
  `s_stock_upated` float(65,3) NOT NULL,
  `s_status` varchar(10) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO `stores` (`s_id`, `s_name`, `s_address`, `s_contact`, `s_stock`, `s_stock_upated`, `s_status`, `date_created`) VALUES ('1', 'store1', 'surat', '9979133538', '2000.000', '2000.000', '1', '2017-08-03 15:20:35');
INSERT INTO `stores` (`s_id`, `s_name`, `s_address`, `s_contact`, `s_stock`, `s_stock_upated`, `s_status`, `date_created`) VALUES ('2', 'store2', 'surat', '9979133538', '550.000', '550.000', '1', '2017-08-03 15:20:35');
INSERT INTO `stores` (`s_id`, `s_name`, `s_address`, `s_contact`, `s_stock`, `s_stock_upated`, `s_status`, `date_created`) VALUES ('3', 'store3', 'surat', '9979133538', '550.000', '550.000', '1', '2017-08-03 15:20:35');


#
# TABLE STRUCTURE FOR: sub_category
#

DROP TABLE IF EXISTS `sub_category`;

CREATE TABLE `sub_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub_category` varchar(55) NOT NULL,
  `category_id_fk` int(11) NOT NULL,
  `prefix` varchar(55) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modefied_id` int(11) DEFAULT NULL,
  `last_modefied_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0= active , 1= inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('1', 'Diesel', '20', '', '36', '2017-07-14 15:09:28', '36', '2017-07-14 15:09:28', '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('2', 'Petrol', '20', '', '36', '2017-07-14 15:09:15', '36', '2017-07-14 15:09:15', '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('3', 'Petrol 92', '20', '', '36', '2017-07-25 20:30:42', NULL, NULL, '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('4', 'dis', '20', '', '36', '2017-07-26 17:04:15', NULL, NULL, '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('5', 'asd', '20', '', '36', '2017-07-26 17:06:08', NULL, NULL, '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('6', 'LAD-1', '20', '', '36', '2017-07-31 10:56:21', NULL, NULL, '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('7', 'LAD-2', '20', '', '36', '2017-07-31 10:56:29', NULL, NULL, '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('8', 'SP95', '20', '', '36', '2017-07-31 11:08:17', NULL, NULL, '0');
INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES ('9', 'Lubricants', '21', '', '36', '2017-08-01 10:42:14', NULL, NULL, '0');


#
# TABLE STRUCTURE FOR: suppliers
#

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(4999) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `balance` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `suppliers` (`id`, `name`, `email`, `address`, `tel`, `fax`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `balance`) VALUES ('1', 'Supplier Co., Ltd', 'supplier@gmail.com', 'asdf', '2345678', '8765432', '1', '2016-09-11 19:29:24', '1', '2016-12-18 14:59:58', '1', '0');
INSERT INTO `suppliers` (`id`, `name`, `email`, `address`, `tel`, `fax`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `balance`) VALUES ('3', 'IOC', 'ioc@gmail.com', '1', '1', '', '36', '2017-06-04 15:14:49', '36', '2017-06-04 15:15:21', '1', '0');
INSERT INTO `suppliers` (`id`, `name`, `email`, `address`, `tel`, `fax`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `balance`) VALUES ('5', 'Test Supplier', 'ts@gmail.com', '11', '11', '11', '36', '2017-07-25 20:33:50', '0', '0000-00-00 00:00:00', '1', '0');


#
# TABLE STRUCTURE FOR: suspend
#

DROP TABLE IF EXISTS `suspend`;

CREATE TABLE `suspend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `fullname` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_number` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `subtotal` double(11,2) NOT NULL,
  `discount_total` double(11,2) NOT NULL,
  `tax` double(11,2) NOT NULL,
  `grandtotal` double(11,2) NOT NULL,
  `total_items` int(11) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: suspend_items
#

DROP TABLE IF EXISTS `suspend_items`;

CREATE TABLE `suspend_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suspend_id` int(11) NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_cost` double(11,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `product_price` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ow_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

#
# TABLE STRUCTURE FOR: timezones
#

DROP TABLE IF EXISTS `timezones`;

CREATE TABLE `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=422 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('1', 'AD', 'Europe/Andorra');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('2', 'AE', 'Asia/Dubai');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('3', 'AF', 'Asia/Kabul');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('4', 'AG', 'America/Antigua');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('5', 'AI', 'America/Anguilla');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('6', 'AL', 'Europe/Tirane');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('7', 'AM', 'Asia/Yerevan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('8', 'AO', 'Africa/Luanda');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('9', 'AQ', 'Antarctica/McMurdo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('10', 'AQ', 'Antarctica/Casey');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('11', 'AQ', 'Antarctica/Davis');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('12', 'AQ', 'Antarctica/DumontDUrville');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('13', 'AQ', 'Antarctica/Mawson');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('14', 'AQ', 'Antarctica/Palmer');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('15', 'AQ', 'Antarctica/Rothera');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('16', 'AQ', 'Antarctica/Syowa');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('17', 'AQ', 'Antarctica/Troll');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('18', 'AQ', 'Antarctica/Vostok');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('19', 'AR', 'America/Argentina/Buenos_Aires');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('20', 'AR', 'America/Argentina/Cordoba');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('21', 'AR', 'America/Argentina/Salta');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('22', 'AR', 'America/Argentina/Jujuy');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('23', 'AR', 'America/Argentina/Tucuman');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('24', 'AR', 'America/Argentina/Catamarca');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('25', 'AR', 'America/Argentina/La_Rioja');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('26', 'AR', 'America/Argentina/San_Juan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('27', 'AR', 'America/Argentina/Mendoza');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('28', 'AR', 'America/Argentina/San_Luis');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('29', 'AR', 'America/Argentina/Rio_Gallegos');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('30', 'AR', 'America/Argentina/Ushuaia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('31', 'AS', 'Pacific/Pago_Pago');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('32', 'AT', 'Europe/Vienna');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('33', 'AU', 'Australia/Lord_Howe');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('34', 'AU', 'Antarctica/Macquarie');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('35', 'AU', 'Australia/Hobart');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('36', 'AU', 'Australia/Currie');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('37', 'AU', 'Australia/Melbourne');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('38', 'AU', 'Australia/Sydney');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('39', 'AU', 'Australia/Broken_Hill');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('40', 'AU', 'Australia/Brisbane');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('41', 'AU', 'Australia/Lindeman');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('42', 'AU', 'Australia/Adelaide');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('43', 'AU', 'Australia/Darwin');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('44', 'AU', 'Australia/Perth');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('45', 'AU', 'Australia/Eucla');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('46', 'AW', 'America/Aruba');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('47', 'AX', 'Europe/Mariehamn');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('48', 'AZ', 'Asia/Baku');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('49', 'BA', 'Europe/Sarajevo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('50', 'BB', 'America/Barbados');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('51', 'BD', 'Asia/Dhaka');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('52', 'BE', 'Europe/Brussels');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('53', 'BF', 'Africa/Ouagadougou');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('54', 'BG', 'Europe/Sofia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('55', 'BH', 'Asia/Bahrain');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('56', 'BI', 'Africa/Bujumbura');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('57', 'BJ', 'Africa/Porto-Novo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('58', 'BL', 'America/St_Barthelemy');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('59', 'BM', 'Atlantic/Bermuda');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('60', 'BN', 'Asia/Brunei');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('61', 'BO', 'America/La_Paz');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('62', 'BQ', 'America/Kralendijk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('63', 'BR', 'America/Noronha');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('64', 'BR', 'America/Belem');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('65', 'BR', 'America/Fortaleza');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('66', 'BR', 'America/Recife');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('67', 'BR', 'America/Araguaina');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('68', 'BR', 'America/Maceio');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('69', 'BR', 'America/Bahia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('70', 'BR', 'America/Sao_Paulo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('71', 'BR', 'America/Campo_Grande');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('72', 'BR', 'America/Cuiaba');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('73', 'BR', 'America/Santarem');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('74', 'BR', 'America/Porto_Velho');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('75', 'BR', 'America/Boa_Vista');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('76', 'BR', 'America/Manaus');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('77', 'BR', 'America/Eirunepe');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('78', 'BR', 'America/Rio_Branco');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('79', 'BS', 'America/Nassau');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('80', 'BT', 'Asia/Thimphu');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('81', 'BW', 'Africa/Gaborone');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('82', 'BY', 'Europe/Minsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('83', 'BZ', 'America/Belize');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('84', 'CA', 'America/St_Johns');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('85', 'CA', 'America/Halifax');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('86', 'CA', 'America/Glace_Bay');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('87', 'CA', 'America/Moncton');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('88', 'CA', 'America/Goose_Bay');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('89', 'CA', 'America/Blanc-Sablon');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('90', 'CA', 'America/Toronto');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('91', 'CA', 'America/Nipigon');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('92', 'CA', 'America/Thunder_Bay');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('93', 'CA', 'America/Iqaluit');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('94', 'CA', 'America/Pangnirtung');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('95', 'CA', 'America/Atikokan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('96', 'CA', 'America/Winnipeg');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('97', 'CA', 'America/Rainy_River');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('98', 'CA', 'America/Resolute');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('99', 'CA', 'America/Rankin_Inlet');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('100', 'CA', 'America/Regina');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('101', 'CA', 'America/Swift_Current');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('102', 'CA', 'America/Edmonton');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('103', 'CA', 'America/Cambridge_Bay');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('104', 'CA', 'America/Yellowknife');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('105', 'CA', 'America/Inuvik');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('106', 'CA', 'America/Creston');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('107', 'CA', 'America/Dawson_Creek');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('108', 'CA', 'America/Fort_Nelson');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('109', 'CA', 'America/Vancouver');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('110', 'CA', 'America/Whitehorse');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('111', 'CA', 'America/Dawson');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('112', 'CC', 'Indian/Cocos');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('113', 'CD', 'Africa/Kinshasa');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('114', 'CD', 'Africa/Lubumbashi');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('115', 'CF', 'Africa/Bangui');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('116', 'CG', 'Africa/Brazzaville');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('117', 'CH', 'Europe/Zurich');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('118', 'CI', 'Africa/Abidjan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('119', 'CK', 'Pacific/Rarotonga');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('120', 'CL', 'America/Santiago');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('121', 'CL', 'Pacific/Easter');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('122', 'CM', 'Africa/Douala');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('123', 'CN', 'Asia/Shanghai');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('124', 'CN', 'Asia/Urumqi');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('125', 'CO', 'America/Bogota');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('126', 'CR', 'America/Costa_Rica');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('127', 'CU', 'America/Havana');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('128', 'CV', 'Atlantic/Cape_Verde');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('129', 'CW', 'America/Curacao');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('130', 'CX', 'Indian/Christmas');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('131', 'CY', 'Asia/Nicosia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('132', 'CZ', 'Europe/Prague');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('133', 'DE', 'Europe/Berlin');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('134', 'DE', 'Europe/Busingen');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('135', 'DJ', 'Africa/Djibouti');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('136', 'DK', 'Europe/Copenhagen');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('137', 'DM', 'America/Dominica');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('138', 'DO', 'America/Santo_Domingo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('139', 'DZ', 'Africa/Algiers');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('140', 'EC', 'America/Guayaquil');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('141', 'EC', 'Pacific/Galapagos');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('142', 'EE', 'Europe/Tallinn');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('143', 'EG', 'Africa/Cairo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('144', 'EH', 'Africa/El_Aaiun');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('145', 'ER', 'Africa/Asmara');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('146', 'ES', 'Europe/Madrid');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('147', 'ES', 'Africa/Ceuta');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('148', 'ES', 'Atlantic/Canary');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('149', 'ET', 'Africa/Addis_Ababa');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('150', 'FI', 'Europe/Helsinki');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('151', 'FJ', 'Pacific/Fiji');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('152', 'FK', 'Atlantic/Stanley');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('153', 'FM', 'Pacific/Chuuk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('154', 'FM', 'Pacific/Pohnpei');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('155', 'FM', 'Pacific/Kosrae');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('156', 'FO', 'Atlantic/Faroe');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('157', 'FR', 'Europe/Paris');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('158', 'GA', 'Africa/Libreville');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('159', 'GB', 'Europe/London');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('160', 'GD', 'America/Grenada');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('161', 'GE', 'Asia/Tbilisi');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('162', 'GF', 'America/Cayenne');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('163', 'GG', 'Europe/Guernsey');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('164', 'GH', 'Africa/Accra');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('165', 'GI', 'Europe/Gibraltar');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('166', 'GL', 'America/Godthab');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('167', 'GL', 'America/Danmarkshavn');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('168', 'GL', 'America/Scoresbysund');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('169', 'GL', 'America/Thule');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('170', 'GM', 'Africa/Banjul');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('171', 'GN', 'Africa/Conakry');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('172', 'GP', 'America/Guadeloupe');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('173', 'GQ', 'Africa/Malabo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('174', 'GR', 'Europe/Athens');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('175', 'GS', 'Atlantic/South_Georgia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('176', 'GT', 'America/Guatemala');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('177', 'GU', 'Pacific/Guam');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('178', 'GW', 'Africa/Bissau');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('179', 'GY', 'America/Guyana');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('180', 'HK', 'Asia/Hong_Kong');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('181', 'HN', 'America/Tegucigalpa');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('182', 'HR', 'Europe/Zagreb');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('183', 'HT', 'America/Port-au-Prince');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('184', 'HU', 'Europe/Budapest');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('185', 'ID', 'Asia/Jakarta');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('186', 'ID', 'Asia/Pontianak');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('187', 'ID', 'Asia/Makassar');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('188', 'ID', 'Asia/Jayapura');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('189', 'IE', 'Europe/Dublin');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('190', 'IL', 'Asia/Jerusalem');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('191', 'IM', 'Europe/Isle_of_Man');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('192', 'IN', 'Asia/Kolkata');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('193', 'IO', 'Indian/Chagos');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('194', 'IQ', 'Asia/Baghdad');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('195', 'IR', 'Asia/Tehran');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('196', 'IS', 'Atlantic/Reykjavik');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('197', 'IT', 'Europe/Rome');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('198', 'JE', 'Europe/Jersey');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('199', 'JM', 'America/Jamaica');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('200', 'JO', 'Asia/Amman');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('201', 'JP', 'Asia/Tokyo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('202', 'KE', 'Africa/Nairobi');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('203', 'KG', 'Asia/Bishkek');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('204', 'KH', 'Asia/Phnom_Penh');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('205', 'KI', 'Pacific/Tarawa');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('206', 'KI', 'Pacific/Enderbury');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('207', 'KI', 'Pacific/Kiritimati');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('208', 'KM', 'Indian/Comoro');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('209', 'KN', 'America/St_Kitts');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('210', 'KP', 'Asia/Pyongyang');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('211', 'KR', 'Asia/Seoul');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('212', 'KW', 'Asia/Kuwait');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('213', 'KY', 'America/Cayman');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('214', 'KZ', 'Asia/Almaty');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('215', 'KZ', 'Asia/Qyzylorda');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('216', 'KZ', 'Asia/Aqtobe');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('217', 'KZ', 'Asia/Aqtau');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('218', 'KZ', 'Asia/Oral');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('219', 'LA', 'Asia/Vientiane');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('220', 'LB', 'Asia/Beirut');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('221', 'LC', 'America/St_Lucia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('222', 'LI', 'Europe/Vaduz');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('223', 'LK', 'Asia/Colombo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('224', 'LR', 'Africa/Monrovia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('225', 'LS', 'Africa/Maseru');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('226', 'LT', 'Europe/Vilnius');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('227', 'LU', 'Europe/Luxembourg');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('228', 'LV', 'Europe/Riga');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('229', 'LY', 'Africa/Tripoli');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('230', 'MA', 'Africa/Casablanca');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('231', 'MC', 'Europe/Monaco');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('232', 'MD', 'Europe/Chisinau');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('233', 'ME', 'Europe/Podgorica');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('234', 'MF', 'America/Marigot');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('235', 'MG', 'Indian/Antananarivo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('236', 'MH', 'Pacific/Majuro');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('237', 'MH', 'Pacific/Kwajalein');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('238', 'MK', 'Europe/Skopje');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('239', 'ML', 'Africa/Bamako');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('240', 'MM', 'Asia/Rangoon');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('241', 'MN', 'Asia/Ulaanbaatar');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('242', 'MN', 'Asia/Hovd');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('243', 'MN', 'Asia/Choibalsan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('244', 'MO', 'Asia/Macau');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('245', 'MP', 'Pacific/Saipan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('246', 'MQ', 'America/Martinique');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('247', 'MR', 'Africa/Nouakchott');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('248', 'MS', 'America/Montserrat');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('249', 'MT', 'Europe/Malta');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('250', 'MU', 'Indian/Mauritius');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('251', 'MV', 'Indian/Maldives');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('252', 'MW', 'Africa/Blantyre');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('253', 'MX', 'America/Mexico_City');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('254', 'MX', 'America/Cancun');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('255', 'MX', 'America/Merida');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('256', 'MX', 'America/Monterrey');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('257', 'MX', 'America/Matamoros');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('258', 'MX', 'America/Mazatlan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('259', 'MX', 'America/Chihuahua');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('260', 'MX', 'America/Ojinaga');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('261', 'MX', 'America/Hermosillo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('262', 'MX', 'America/Tijuana');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('263', 'MX', 'America/Bahia_Banderas');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('264', 'MY', 'Asia/Kuala_Lumpur');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('265', 'MY', 'Asia/Kuching');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('266', 'MZ', 'Africa/Maputo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('267', 'NA', 'Africa/Windhoek');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('268', 'NC', 'Pacific/Noumea');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('269', 'NE', 'Africa/Niamey');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('270', 'NF', 'Pacific/Norfolk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('271', 'NG', 'Africa/Lagos');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('272', 'NI', 'America/Managua');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('273', 'NL', 'Europe/Amsterdam');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('274', 'NO', 'Europe/Oslo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('275', 'NP', 'Asia/Kathmandu');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('276', 'NR', 'Pacific/Nauru');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('277', 'NU', 'Pacific/Niue');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('278', 'NZ', 'Pacific/Auckland');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('279', 'NZ', 'Pacific/Chatham');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('280', 'OM', 'Asia/Muscat');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('281', 'PA', 'America/Panama');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('282', 'PE', 'America/Lima');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('283', 'PF', 'Pacific/Tahiti');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('284', 'PF', 'Pacific/Marquesas');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('285', 'PF', 'Pacific/Gambier');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('286', 'PG', 'Pacific/Port_Moresby');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('287', 'PG', 'Pacific/Bougainville');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('288', 'PH', 'Asia/Manila');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('289', 'PK', 'Asia/Karachi');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('290', 'PL', 'Europe/Warsaw');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('291', 'PM', 'America/Miquelon');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('292', 'PN', 'Pacific/Pitcairn');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('293', 'PR', 'America/Puerto_Rico');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('294', 'PS', 'Asia/Gaza');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('295', 'PS', 'Asia/Hebron');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('296', 'PT', 'Europe/Lisbon');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('297', 'PT', 'Atlantic/Madeira');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('298', 'PT', 'Atlantic/Azores');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('299', 'PW', 'Pacific/Palau');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('300', 'PY', 'America/Asuncion');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('301', 'QA', 'Asia/Qatar');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('302', 'RE', 'Indian/Reunion');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('303', 'RO', 'Europe/Bucharest');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('304', 'RS', 'Europe/Belgrade');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('305', 'RU', 'Europe/Kaliningrad');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('306', 'RU', 'Europe/Moscow');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('307', 'RU', 'Europe/Simferopol');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('308', 'RU', 'Europe/Volgograd');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('309', 'RU', 'Europe/Kirov');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('310', 'RU', 'Europe/Astrakhan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('311', 'RU', 'Europe/Samara');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('312', 'RU', 'Europe/Ulyanovsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('313', 'RU', 'Asia/Yekaterinburg');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('314', 'RU', 'Asia/Omsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('315', 'RU', 'Asia/Novosibirsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('316', 'RU', 'Asia/Barnaul');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('317', 'RU', 'Asia/Tomsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('318', 'RU', 'Asia/Novokuznetsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('319', 'RU', 'Asia/Krasnoyarsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('320', 'RU', 'Asia/Irkutsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('321', 'RU', 'Asia/Chita');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('322', 'RU', 'Asia/Yakutsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('323', 'RU', 'Asia/Khandyga');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('324', 'RU', 'Asia/Vladivostok');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('325', 'RU', 'Asia/Ust-Nera');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('326', 'RU', 'Asia/Magadan');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('327', 'RU', 'Asia/Sakhalin');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('328', 'RU', 'Asia/Srednekolymsk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('329', 'RU', 'Asia/Kamchatka');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('330', 'RU', 'Asia/Anadyr');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('331', 'RW', 'Africa/Kigali');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('332', 'SA', 'Asia/Riyadh');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('333', 'SB', 'Pacific/Guadalcanal');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('334', 'SC', 'Indian/Mahe');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('335', 'SD', 'Africa/Khartoum');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('336', 'SE', 'Europe/Stockholm');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('337', 'SG', 'Asia/Singapore');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('338', 'SH', 'Atlantic/St_Helena');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('339', 'SI', 'Europe/Ljubljana');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('340', 'SJ', 'Arctic/Longyearbyen');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('341', 'SK', 'Europe/Bratislava');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('342', 'SL', 'Africa/Freetown');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('343', 'SM', 'Europe/San_Marino');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('344', 'SN', 'Africa/Dakar');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('345', 'SO', 'Africa/Mogadishu');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('346', 'SR', 'America/Paramaribo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('347', 'SS', 'Africa/Juba');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('348', 'ST', 'Africa/Sao_Tome');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('349', 'SV', 'America/El_Salvador');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('350', 'SX', 'America/Lower_Princes');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('351', 'SY', 'Asia/Damascus');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('352', 'SZ', 'Africa/Mbabane');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('353', 'TC', 'America/Grand_Turk');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('354', 'TD', 'Africa/Ndjamena');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('355', 'TF', 'Indian/Kerguelen');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('356', 'TG', 'Africa/Lome');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('357', 'TH', 'Asia/Bangkok');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('358', 'TJ', 'Asia/Dushanbe');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('359', 'TK', 'Pacific/Fakaofo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('360', 'TL', 'Asia/Dili');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('361', 'TM', 'Asia/Ashgabat');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('362', 'TN', 'Africa/Tunis');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('363', 'TO', 'Pacific/Tongatapu');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('364', 'TR', 'Europe/Istanbul');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('365', 'TT', 'America/Port_of_Spain');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('366', 'TV', 'Pacific/Funafuti');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('367', 'TW', 'Asia/Taipei');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('368', 'TZ', 'Africa/Dar_es_Salaam');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('369', 'UA', 'Europe/Kiev');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('370', 'UA', 'Europe/Uzhgorod');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('371', 'UA', 'Europe/Zaporozhye');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('372', 'UG', 'Africa/Kampala');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('373', 'UM', 'Pacific/Johnston');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('374', 'UM', 'Pacific/Midway');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('375', 'UM', 'Pacific/Wake');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('376', 'US', 'America/New_York');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('377', 'US', 'America/Detroit');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('378', 'US', 'America/Kentucky/Louisville');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('379', 'US', 'America/Kentucky/Monticello');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('380', 'US', 'America/Indiana/Indianapolis');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('381', 'US', 'America/Indiana/Vincennes');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('382', 'US', 'America/Indiana/Winamac');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('383', 'US', 'America/Indiana/Marengo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('384', 'US', 'America/Indiana/Petersburg');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('385', 'US', 'America/Indiana/Vevay');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('386', 'US', 'America/Chicago');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('387', 'US', 'America/Indiana/Tell_City');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('388', 'US', 'America/Indiana/Knox');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('389', 'US', 'America/Menominee');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('390', 'US', 'America/North_Dakota/Center');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('391', 'US', 'America/North_Dakota/New_Salem');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('392', 'US', 'America/North_Dakota/Beulah');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('393', 'US', 'America/Denver');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('394', 'US', 'America/Boise');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('395', 'US', 'America/Phoenix');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('396', 'US', 'America/Los_Angeles');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('397', 'US', 'America/Anchorage');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('398', 'US', 'America/Juneau');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('399', 'US', 'America/Sitka');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('400', 'US', 'America/Metlakatla');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('401', 'US', 'America/Yakutat');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('402', 'US', 'America/Nome');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('403', 'US', 'America/Adak');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('404', 'US', 'Pacific/Honolulu');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('405', 'UY', 'America/Montevideo');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('406', 'UZ', 'Asia/Samarkand');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('407', 'UZ', 'Asia/Tashkent');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('408', 'VA', 'Europe/Vatican');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('409', 'VC', 'America/St_Vincent');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('410', 'VE', 'America/Caracas');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('411', 'VG', 'America/Tortola');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('412', 'VI', 'America/St_Thomas');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('413', 'VN', 'Asia/Ho_Chi_Minh');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('414', 'VU', 'Pacific/Efate');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('415', 'WF', 'Pacific/Wallis');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('416', 'WS', 'Pacific/Apia');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('417', 'YE', 'Asia/Aden');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('418', 'YT', 'Indian/Mayotte');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('419', 'ZA', 'Africa/Johannesburg');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('420', 'ZM', 'Africa/Lusaka');
INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES ('421', 'ZW', 'Africa/Harare');


#
# TABLE STRUCTURE FOR: transactions
#

DROP TABLE IF EXISTS `transactions`;

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL DEFAULT '',
  `account_number` varchar(30) DEFAULT NULL,
  `outlet_id` int(11) NOT NULL,
  `trans_type` enum('wd','dep','loan') DEFAULT NULL,
  `amount` double DEFAULT '0',
  `transaction` text,
  `created_by` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pumper_id` int(11) DEFAULT NULL,
  `receipt` varchar(55) DEFAULT NULL,
  `expense` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `settlement_id` int(11) NOT NULL DEFAULT '0',
  `bring_forword` double(11,2) NOT NULL,
  `cheque_number` varchar(255) NOT NULL DEFAULT '',
  `cheque_date` date NOT NULL,
  `bank` varchar(255) NOT NULL DEFAULT '',
  `voucher_number` varchar(255) NOT NULL DEFAULT '',
  `card_number` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('3', '', '1', '1', 'loan', '10000', NULL, '36', '0', '2017-08-04 08:11:25', NULL, NULL, NULL, NULL, '0', '46185.75', '', '0000-00-00', '', '', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('4', '3', '1', '1', 'dep', '7400', NULL, '36', '0', '2017-08-04 08:37:17', '0', NULL, NULL, NULL, '1', '36185.75', '', '0000-00-00', '', '', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('7', '5', '1', '1', 'dep', '950', NULL, '36', '0', '2017-08-04 10:22:49', '2', NULL, NULL, NULL, '4', '43585.75', '', '0000-00-00', '', '', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('8', '6', '1', '1', 'dep', '800', NULL, '36', '0', '2017-08-04 10:25:44', '1', NULL, NULL, NULL, '6', '44535.75', '', '0000-00-00', '', '', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('9', '6', '9', '1', 'dep', '50', NULL, '36', '0', '2017-08-04 10:25:44', '1', NULL, NULL, NULL, '6', '300.00', '', '0000-00-00', '', '', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('10', '7', '17', '1', 'dep', '300', NULL, '36', '0', '2017-08-04 10:36:40', '2', NULL, NULL, NULL, '7', '250.00', '', '0000-00-00', '', '123', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('11', '7', '9', '1', 'dep', '50', NULL, '36', '0', '2017-08-04 10:36:40', '2', NULL, NULL, NULL, '7', '350.00', '', '0000-00-00', '', '123', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('12', '7', '1', '1', 'dep', '600', NULL, '36', '0', '2017-08-04 10:36:40', '2', NULL, NULL, NULL, '7', '45335.75', '', '0000-00-00', '', '123', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('13', '8', '5', '1', 'dep', '850', NULL, '36', '0', '2017-08-04 10:44:46', '1', NULL, NULL, NULL, '8', '100.00', 'ch-123', '2017-08-31', 'anz', '', '');
INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`) VALUES ('14', '9', '1', '1', 'dep', '650', NULL, '36', '0', '2017-08-04 13:43:22', '2', NULL, NULL, NULL, '9', '45935.75', '', '0000-00-00', '', '', '');


#
# TABLE STRUCTURE FOR: user_roles
#

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('1', 'Administrator', '1', '2016-08-16 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('2', 'Manager', '1', '2016-08-16 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('3', 'Sales Person', '1', '2016-08-16 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('4', 'Super Manager', '1', '2017-01-12 05:12:30', '0', '0000-00-00 00:00:00');
INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('6', 'Customer', '1', '2017-01-30 00:00:00', '1', '2017-01-30 00:00:00');
INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('7', 'System Admin', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES ('8', 'Staff', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');


#
# TABLE STRUCTURE FOR: users
#

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role_id`, `outlet_id`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('20', 'sys@gmail.com', 'abc@gmail.com', '20628e8a531b0fc3df5cf14ca4d9ce07', '7', '1', '1', '2017-02-01 03:57:20', '0', '0000-00-00 00:00:00', '1');
INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role_id`, `outlet_id`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES ('36', 'owner', 'abcd@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1', '0', '1', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00', '1');


#
# TABLE STRUCTURE FOR: wastage_product_gold
#

DROP TABLE IF EXISTS `wastage_product_gold`;

CREATE TABLE `wastage_product_gold` (
  `w_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `goldsmith_id` int(11) NOT NULL,
  `wastage_amount` float(10,3) NOT NULL,
  `how_created` int(11) NOT NULL,
  `date` date NOT NULL,
  `was_datetime` datetime NOT NULL,
  PRIMARY KEY (`w_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: wastage_product_gold_backup
#

DROP TABLE IF EXISTS `wastage_product_gold_backup`;

CREATE TABLE `wastage_product_gold_backup` (
  `w_id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `sub_id` int(11) NOT NULL,
  `goldsmith_id` int(11) NOT NULL,
  `wastage_amount` float(10,3) NOT NULL,
  `how_created` int(11) NOT NULL,
  `date` date NOT NULL,
  `was_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

