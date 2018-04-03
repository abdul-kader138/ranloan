-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2017 at 01:27 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `syztest_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `add_transfer`
--

CREATE TABLE IF NOT EXISTS `add_transfer` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE IF NOT EXISTS `appointments` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bakery_sales`
--

CREATE TABLE IF NOT EXISTS `bakery_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `sale_datetime` datetime NOT NULL,
  `sales_person_id` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `session` enum('morning','evening') COLLATE utf8_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_items` int(11) NOT NULL,
  `cash` float NOT NULL,
  `credit` float NOT NULL,
  `settled_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_amount` float NOT NULL COMMENT '1: Sales, 2: Return',
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` enum('partial','complete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'partial',
  `sid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bakery_sale_items`
--

CREATE TABLE IF NOT EXISTS `bakery_sale_items` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE IF NOT EXISTS `bank_accounts` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bank_accounts`
--

INSERT INTO `bank_accounts` (`id`, `account_number`, `bank`, `branch`, `current_balance`, `is_visible`, `created_by`, `user_id`, `created`) VALUES
(1, '67859742', 'Sampath Bank', 'Malabe', 2939.3, 1, 36, 36, '2017-07-02 15:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `bank_transfers`
--

CREATE TABLE IF NOT EXISTS `bank_transfers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` int(11) NOT NULL,
  `transfer_date` date NOT NULL,
  `bank_from` varchar(100) NOT NULL,
  `bank_to` varchar(100) NOT NULL,
  `amount` float NOT NULL,
  `payment_method` int(11) NOT NULL COMMENT '0: default, 1:bank',
  `reference` text NOT NULL,
  `document` text NOT NULL,
  `is_visible` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` varchar(255) NOT NULL DEFAULT '',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bank_transfers`
--

INSERT INTO `bank_transfers` (`id`, `outlet_id`, `transfer_date`, `bank_from`, `bank_to`, `amount`, `payment_method`, `reference`, `document`, `is_visible`, `created_by`, `created`) VALUES
(1, 1, '2017-09-08', '1', '1', 200, 0, 'not', '', 1, '1', '2017-09-08 09:46:42'),
(2, 1, '2017-09-08', '1', '1', 20, 1, 'not', '', 1, '1', '2017-09-08 09:48:10'),
(3, 1, '2017-09-08', '1', '1', 130, 1, 'not', '', 1, '2', '2017-09-08 09:51:36'),
(4, 1, '2017-09-08', '1', '1', 560.7, 0, 'not', '', 1, '2', '2017-09-08 09:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `batch_expire_multi`
--

CREATE TABLE IF NOT EXISTS `batch_expire_multi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_id` varchar(255) NOT NULL DEFAULT '',
  `batch_no` varchar(255) NOT NULL DEFAULT '',
  `expirydate` date NOT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `notification` varchar(255) NOT NULL DEFAULT '0',
  `status` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `batch_expire_multi`
--

INSERT INTO `batch_expire_multi` (`id`, `inventory_id`, `batch_no`, `expirydate`, `created_date`, `notification`, `status`) VALUES
(1, '3', '10', '0000-00-00', '2017-08-08 18:20:53', '0', '0'),
(2, '3', '10', '0000-00-00', '2017-08-08 18:20:53', '0', '0'),
(3, '2', '100', '2017-08-20', '2017-08-08 18:28:15', '0', '0'),
(4, '2', '100', '2017-08-20', '2017-08-08 18:28:15', '0', '0'),
(5, '3', '20', '2017-08-20', '2017-08-08 18:28:15', '0', '0'),
(6, '3', '20', '2017-08-20', '2017-08-08 18:28:15', '0', '0'),
(7, '4', '123456', '2017-08-20', '2017-08-08 18:28:15', '0', '0'),
(8, '1', '123', '1970-01-29', '2017-08-08 18:37:18', '0', '0'),
(9, '3', '123456', '1970-01-20', '2017-08-08 18:37:18', '0', '0'),
(10, '1', '', '1970-01-01', '2017-08-10 15:23:16', '0', '0'),
(11, '6', '123456', '2017-08-26', '2017-08-10 16:22:36', '0', '0'),
(12, '6', '1221345', '2017-08-31', '2017-08-10 16:22:36', '0', '0'),
(13, '6', '123456', '2017-08-31', '2017-08-10 16:22:36', '0', '0'),
(14, '7', '123456', '2017-08-31', '2017-08-10 16:22:36', '0', '0'),
(15, '7', '123456', '2017-08-31', '2017-08-10 16:22:36', '0', '0'),
(16, '10', '12456', '2017-08-29', '2017-08-10 16:25:54', '0', '0'),
(17, '10', '123123456', '2017-08-29', '2017-08-10 16:25:54', '0', '0'),
(18, '11', '123456120', '2017-08-30', '2017-08-10 16:25:54', '0', '0'),
(19, '11', '1237812', '2017-08-30', '2017-08-10 16:25:54', '0', '0'),
(20, '1', '', '1970-01-01', '2017-08-14 10:21:33', '0', '0'),
(21, '1', '', '1970-01-01', '2017-08-17 13:41:47', '0', '0'),
(22, '5', '20', '2017-08-31', '2017-08-23 17:38:53', '0', '0'),
(23, '6', '30', '2017-08-31', '2017-08-23 17:38:53', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `bill_numbering`
--

CREATE TABLE IF NOT EXISTS `bill_numbering` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bill_numbering`
--

INSERT INTO `bill_numbering` (`id`, `user_id`, `created_date`, `auto_number_change`, `change_daily`, `change_weekly`, `change_monthly`, `change_yearly`, `sales_invoice`, `pos_bill`, `current_year`, `current_month`, `current_day`, `enter_starting_number`, `status`) VALUES
(1, '36', '2017-08-11 12:29:29', '1', '0', '0', '1', '0', '1', '1', '1', '1', '1', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand` varchar(100) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_modefied_by` int(11) DEFAULT NULL,
  `last_modefied_at` datetime DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=active , 1= inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `brand`, `created_by`, `created_at`, `last_modefied_by`, `last_modefied_at`, `status`) VALUES
(1, 'supplier1', 36, '2017-08-24 10:41:36', NULL, NULL, 0),
(2, 'supplier2', 36, '2017-08-24 10:41:36', NULL, NULL, 0),
(3, '1', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(4, '2', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(5, '4', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(6, '5', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(7, '6', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(8, '7', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(9, '8', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(10, '9', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(11, '10', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(12, '11', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(13, '12', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(14, '13', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(15, '14', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(16, '15', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(17, '17', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(18, '18', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(19, '19', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(20, '20', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(21, '21', 36, '2017-08-28 05:18:29', NULL, NULL, 0),
(22, '22', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(23, '23', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(24, '24', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(25, '25', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(26, '26', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(27, '27', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(28, '28', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(29, '30', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(30, '31', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(31, '32', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(32, '33', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(33, '34', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(34, '35', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(35, '36', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(36, '38', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(37, '39', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(38, '40', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(39, '42', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(40, '43', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(41, '44', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(42, '48', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(43, '49', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(44, '50', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(45, '51', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(46, '53', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(47, '58', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(48, '59', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(49, '60', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(50, '61', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(51, '62', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(52, '63', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(53, '64', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(54, '65', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(55, '66', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(56, '67', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(57, '68', 36, '2017-08-28 05:18:30', NULL, NULL, 0),
(58, '69', 36, '2017-08-28 05:18:30', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `brand_suppliers`
--

CREATE TABLE IF NOT EXISTS `brand_suppliers` (
  `brand_id_fk` int(11) NOT NULL,
  `supplier_id_fk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=23 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(9, 'Services', 1, '2016-12-01 00:00:00', 1, '2016-12-01 00:00:00', 1),
(12, 'Non-Inventory Items', 6, '2017-01-05 15:03:35', 0, '0000-00-00 00:00:00', 1),
(20, 'Fuel', 36, '2017-05-28 11:48:47', 36, '2017-06-04 16:14:02', 1),
(21, 'Other items', 36, '2017-05-30 01:22:16', 36, '2017-06-04 14:37:37', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('8575f9fb33d23f993390e39d193b9937fd7afea2', '127.0.0.1', 1504869940, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530343836393934303b),
('23c431ce0ce93df5fe187c56e415abcdb3fd9b60', '127.0.0.1', 1504856639, 0x5f5f63695f6c6173745f726567656e65726174657c693a313530343835303037313b73657373696f6e69647c733a333a22706f73223b757365725f69647c733a313a2232223b757365725f656d61696c7c733a31333a2231323340676d61696c2e636f6d223b757365725f726f6c657c733a313a2231223b757365725f6f75746c65747c733a313a2230223b757365725f726f6c655f6e616d657c733a31333a2241646d696e6973747261746f72223b);

-- --------------------------------------------------------

--
-- Table structure for table `create_order_estimate`
--

CREATE TABLE IF NOT EXISTS `create_order_estimate` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE IF NOT EXISTS `currency` (
  `iso` char(3) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`iso`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`iso`, `name`) VALUES
('KRW', '(South) Korean Won'),
('AFA', 'Afghanistan Afghani'),
('ALL', 'Albanian Lek'),
('DZD', 'Algerian Dinar'),
('ADP', 'Andorran Peseta'),
('AOK', 'Angolan Kwanza'),
('ARS', 'Argentine Peso'),
('AMD', 'Armenian Dram'),
('AWG', 'Aruban Florin'),
('AUD', 'Australian Dollar'),
('BSD', 'Bahamian Dollar'),
('BHD', 'Bahraini Dinar'),
('BDT', 'Bangladeshi Taka'),
('BBD', 'Barbados Dollar'),
('BZD', 'Belize Dollar'),
('BMD', 'Bermudian Dollar'),
('BTN', 'Bhutan Ngultrum'),
('BOB', 'Bolivian Boliviano'),
('BWP', 'Botswanian Pula'),
('BRL', 'Brazilian Real'),
('GBP', 'British Pound'),
('BND', 'Brunei Dollar'),
('BGN', 'Bulgarian Lev'),
('BUK', 'Burma Kyat'),
('BIF', 'Burundi Franc'),
('CAD', 'Canadian Dollar'),
('CVE', 'Cape Verde Escudo'),
('KYD', 'Cayman Islands Dollar'),
('CLP', 'Chilean Peso'),
('CLF', 'Chilean Unidades de Fomento'),
('COP', 'Colombian Peso'),
('XOF', 'CommunautÃ© FinanciÃ¨re Africaine BCEAO - Francs'),
('XAF', 'CommunautÃ© FinanciÃ¨re Africaine BEAC, Francs'),
('KMF', 'Comoros Franc'),
('XPF', 'Comptoirs FranÃ§ais du Pacifique Francs'),
('CRC', 'Costa Rican Colon'),
('CUP', 'Cuban Peso'),
('CYP', 'Cyprus Pound'),
('CZK', 'Czech Republic Koruna'),
('DKK', 'Danish Krone'),
('YDD', 'Democratic Yemeni Dinar'),
('DOP', 'Dominican Peso'),
('XCD', 'East Caribbean Dollar'),
('TPE', 'East Timor Escudo'),
('ECS', 'Ecuador Sucre'),
('EGP', 'Egyptian Pound'),
('SVC', 'El Salvador Colon'),
('EEK', 'Estonian Kroon (EEK)'),
('ETB', 'Ethiopian Birr'),
('EUR', 'Euro'),
('FKP', 'Falkland Islands Pound'),
('FJD', 'Fiji Dollar'),
('GMD', 'Gambian Dalasi'),
('GHC', 'Ghanaian Cedi'),
('GIP', 'Gibraltar Pound'),
('XAU', 'Gold, Ounces'),
('GTQ', 'Guatemalan Quetzal'),
('GNF', 'Guinea Franc'),
('GWP', 'Guinea-Bissau Peso'),
('GYD', 'Guyanan Dollar'),
('HTG', 'Haitian Gourde'),
('HNL', 'Honduran Lempira'),
('HKD', 'Hong Kong Dollar'),
('HUF', 'Hungarian Forint'),
('INR', 'Indian Rupee'),
('IDR', 'Indonesian Rupiah'),
('XDR', 'International Monetary Fund (IMF) Special Drawing Rights'),
('IRR', 'Iranian Rial'),
('IQD', 'Iraqi Dinar'),
('IEP', 'Irish Punt'),
('ILS', 'Israeli Shekel'),
('JMD', 'Jamaican Dollar'),
('JPY', 'Japanese Yen'),
('JOD', 'Jordanian Dinar'),
('KHR', 'Kampuchean (Cambodian) Riel'),
('KES', 'Kenyan Schilling'),
('KWD', 'Kuwaiti Dinar'),
('LAK', 'Lao Kip'),
('LBP', 'Lebanese Pound'),
('LSL', 'Lesotho Loti'),
('LRD', 'Liberian Dollar'),
('LYD', 'Libyan Dinar'),
('MOP', 'Macau Pataca'),
('MGF', 'Malagasy Franc'),
('MWK', 'Malawi Kwacha'),
('MYR', 'Malaysian Ringgit'),
('MVR', 'Maldive Rufiyaa'),
('MTL', 'Maltese Lira'),
('MRO', 'Mauritanian Ouguiya'),
('MUR', 'Mauritius Rupee'),
('MXP', 'Mexican Peso'),
('MNT', 'Mongolian Tugrik'),
('MAD', 'Moroccan Dirham'),
('MZM', 'Mozambique Metical'),
('NAD', 'Namibian Dollar'),
('NPR', 'Nepalese Rupee'),
('ANG', 'Netherlands Antillian Guilder'),
('YUD', 'New Yugoslavia Dinar'),
('NZD', 'New Zealand Dollar'),
('NIO', 'Nicaraguan Cordoba'),
('NGN', 'Nigerian Naira'),
('KPW', 'North Korean Won'),
('NOK', 'Norwegian Kroner'),
('OMR', 'Omani Rial'),
('PKR', 'Pakistan Rupee'),
('XPD', 'Palladium Ounces'),
('PAB', 'Panamanian Balboa'),
('PGK', 'Papua New Guinea Kina'),
('PYG', 'Paraguay Guarani'),
('PEN', 'Peruvian Nuevo Sol'),
('PHP', 'Philippine Peso'),
('XPT', 'Platinum, Ounces'),
('PLN', 'Polish Zloty'),
('QAR', 'Qatari Rial'),
('RON', 'Romanian Leu'),
('RUB', 'Russian Ruble'),
('RWF', 'Rwanda Franc'),
('WST', 'Samoan Tala'),
('STD', 'Sao Tome and Principe Dobra'),
('SAR', 'Saudi Arabian Riyal'),
('SCR', 'Seychelles Rupee'),
('SLL', 'Sierra Leone Leone'),
('XAG', 'Silver, Ounces'),
('SGD', 'Singapore Dollar'),
('SKK', 'Slovak Koruna'),
('SBD', 'Solomon Islands Dollar'),
('SOS', 'Somali Schilling'),
('ZAR', 'South African Rand'),
('LKR', 'Sri Lanka Rupee'),
('SHP', 'St. Helena Pound'),
('SDP', 'Sudanese Pound'),
('SRG', 'Suriname Guilder'),
('SZL', 'Swaziland Lilangeni'),
('SEK', 'Swedish Krona'),
('CHF', 'Swiss Franc'),
('SYP', 'Syrian Potmd'),
('TWD', 'Taiwan Dollar'),
('TZS', 'Tanzanian Schilling'),
('THB', 'Thai Baht'),
('TOP', 'Tongan Paanga'),
('TTD', 'Trinidad and Tobago Dollar'),
('TND', 'Tunisian Dinar'),
('TRY', 'Turkish Lira'),
('UGX', 'Uganda Shilling'),
('AED', 'United Arab Emirates Dirham'),
('UYU', 'Uruguayan Peso'),
('USD', 'US Dollar'),
('VUV', 'Vanuatu Vatu'),
('VEF', 'Venezualan Bolivar'),
('VND', 'Vietnamese Dong'),
('YER', 'Yemeni Rial'),
('CNY', 'Yuan (Chinese) Renminbi'),
('ZRZ', 'Zaire Zaire'),
('ZMK', 'Zambian Kwacha'),
('ZWD', 'Zimbabwe Dollar');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
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
  `outlet_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `tid` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=242 ;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullname`, `email`, `password`, `mobile`, `address`, `customer_group`, `outstanding`, `loan_amount`, `created_user_id`, `created_datetime`, `deposit`, `balance`, `nic`, `outlet_id`, `tid`) VALUES
(1, 'Customer1', 'Customer1@gmail.com', '', '9979133538', 'surat', 1, '5000', '0', 36, '2017-08-22 13:55:55', 0, NULL, 'Customer1@gmail.com', '1', NULL),
(2, 'Customer2', 'Customer2@gmail.com', '', '9979133538', 'surat ', 1, '5000', '0', 36, '2017-08-22 13:56:25', 0, NULL, 'Customer2@gmail.com', '1', NULL),
(3, 'Customer3', 'Customer3@gmail.com', '', '9979133538', 'surat', 1, '2000', '0', 36, '2017-08-22 14:43:48', 0, NULL, 'Customer3@gmail.com', '1', NULL),
(4, 'Customer4', 'Customer4@gmail.com', '', '9979133538', 'surat', 1, '2000', '0', 36, '2017-08-22 17:54:10', -350, NULL, 'Customer4@gmail.com', '2', NULL),
(178, 'Weerasiri Bus Laxman', 'Weerasiri@W.com', '11', '11', '11', 1, '87157.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(177, 'Police Station - Uhana', 'Police Station@P.com', '11', '11', '11', 1, '427480.76', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(176, 'Ranpasindu Bus', 'Ranpasindu@R.com', '11', '11', '11', 1, '24132.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(175, 'Sandamali Stores - Himidurawa', 'Sandamali Stores@S.com', '11', '11', '11', 1, '112125.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(174, 'D.T. Himaya Mhipali', 'D@D.com', '11', '11', '11', 1, '4348.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(173, 'Akanayaka (Muditha)', 'Akanayaka@A.com', '11', '11', '11', 1, '307534.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(171, 'Kethsiri - Tractor', 'Kethsiri@K.com', '11', '11', '11', 1, '4540.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(172, 'Sumith Bandara - Manager', 'Sumith Bandara@S.com', '11', '11', '11', 1, '3361.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(169, 'SK Wave (Sandun)', 'SK@S.com', '11', '11', '11', 1, '2800.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(170, 'Nanayakkara Stores - RajagalaThanna', 'Nanayakkara Stores@N.com', '11', '11', '11', 1, '128320.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(168, 'Asanka Weeragoda', 'Asanka@A.com', '11', '11', '11', 1, '36785.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(166, 'Liyanage - Kumaragama', 'Liyanage@L.com', '11', '11', '11', 1, '19270.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(167, 'Kapila - Tractor', 'Kapila@K.com', '11', '11', '11', 1, '950', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(165, 'Pradeshiyasaba - Uhana', 'Pradeshiyasaba@P.com', '11', '11', '11', 1, '447440.56', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(164, 'Anura Gamage Dialog', 'Anura@A.com', '11', '11', '11', 1, '13597.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(163, 'Isuru Layanal', 'Isuru@I.com', '11', '11', '11', 1, '66930.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(162, 'Weerasiri Bus Laxman', 'Weerasiri@W.com', '11', '11', '11', 1, '87157.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(161, 'Police Station - Uhana', 'Police Station@P.com', '11', '11', '11', 1, '427480.76', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(160, 'Ranpasindu Bus', 'Ranpasindu@R.com', '11', '11', '11', 1, '24132.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(159, 'Sandamali Stores - Himidurawa', 'Sandamali Stores@S.com', '11', '11', '11', 1, '112125.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(158, 'D.T. Himaya Mhipali', 'D@D.com', '11', '11', '11', 1, '4348.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(157, 'Akanayaka (Muditha)', 'Akanayaka@A.com', '11', '11', '11', 1, '307534.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(155, 'Kethsiri - Tractor', 'Kethsiri@K.com', '11', '11', '11', 1, '4540.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(156, 'Sumith Bandara - Manager', 'Sumith Bandara@S.com', '11', '11', '11', 1, '3361.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(154, 'Nanayakkara Stores - RajagalaThanna', 'Nanayakkara Stores@N.com', '11', '11', '11', 1, '128320.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(153, 'SK Wave (Sandun)', 'SK@S.com', '11', '11', '11', 1, '2800.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(151, 'Kapila - Tractor', 'Kapila@K.com', '11', '11', '11', 1, '950', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(152, 'Asanka Weeragoda', 'Asanka@A.com', '11', '11', '11', 1, '36785.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(150, 'Liyanage - Kumaragama', 'Liyanage@L.com', '11', '11', '11', 1, '19270.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(149, '4 - Pradeshiyasaba - Uhana', '4@4.com', '11', '11', '11', 1, '447440.56', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(147, '6 - Isuru Layanal', '6@6.com', '11', '11', '11', 1, '66930.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(148, '5 - Anura Gamage Dialog', '5@5.com', '11', '11', '11', 1, '13597.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(146, '7 - Weerasiri Bus Laxman', '7@7.com', '11', '11', '11', 1, '87157.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(144, '12 - Ranpasindu Bus', '12@1.com', '11', '11', '11', 1, '24132.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(145, '8 - Police Station - Uhana', '8@8.com', '11', '11', '11', 1, '70903.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(143, '20 - President Order', '20@2.com', '11', '11', '11', 1, '7125.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(141, '26 - D.T. Himaya Mhipali', '26@2.com', '11', '11', '11', 1, '4348.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(142, '24 - Sandamali Stores - Himidurawa', '24@2.com', '11', '11', '11', 1, '112125.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(140, '31 - Akanayaka (Muditha)', '31@3.com', '11', '11', '11', 1, '307534.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(139, '39 - Sumith Bandara - Manager', '39@3.com', '11', '11', '11', 1, '3361.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(138, '43 - Kethsiri - Tractor', '43@4.com', '11', '11', '11', 1, '4540.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(137, '59 - Nanayakkara Stores - RajagalaThanna', '59@5.com', '11', '11', '11', 1, '128320.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(135, '65 - Asanka Weeragoda', '65@6.com', '11', '11', '11', 1, '36785.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(136, '63 - SK Wave (Sandun)', '63@6.com', '11', '11', '11', 1, '2800.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(134, '66 - Kapila - Tractor', '66@6.com', '11', '11', '11', 1, '950', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(133, '67 - Liyanage - Kumaragama', '67@6.com', '11', '11', '11', 1, '19270.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(132, '8 - Police Station - Uhana', '8@8.com', '11', '11', '11', 1, '185116.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(131, '113- APH (Vetnary Office)', '113@1.com', '11', '11', '11', 1, '75732.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(130, '216 - Pumper - S.A.Prasad', '216@2.com', '11', '11', '11', 1, '16100.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(129, '213 - Pumper - P.T.Sajith Prasanna', '213@2.com', '11', '11', '11', 1, '19695.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(128, '187 - Pumper - Danushka Udayanga H.L.D', '187@1.com', '11', '11', '11', 1, '61679.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(127, '224 - Pumper - L.P.G.Anura Kumara Aruyarathna', '224@2.com', '11', '11', '11', 1, '4821.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(126, '341 - Pumper - J.M.Tissa Wijekumara', '341@3.com', '11', '11', '11', 1, '50730.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(125, '343 - Pumper - M.G.Lasitha Madushanka', '343@3.com', '11', '11', '11', 1, '25536.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(124, '343 - K.Dilanka Sandaruwan', '343@3.com', '11', '11', '11', 1, '20239.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(123, '105 - Pumper - H.M.Chanrasena Gunawardena', '105@1.com', '11', '11', '11', 1, '22234.00', '0', 36, '2017-08-26 17:26:44', 0, NULL, '11', '1', NULL),
(179, 'Isuru Layanal', 'Isuru@I.com', '11', '11', '11', 1, '66930.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(180, 'Anura Gamage Dialog', 'Anura@A.com', '11', '11', '11', 1, '13597.00', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(181, 'Pradeshiyasaba - Uhana', 'Pradeshiyasaba@P.com', '11', '11', '11', 1, '447440.56', '0', 36, '2017-08-26 17:26:45', 0, NULL, '11', '1', NULL),
(182, '105 - Pumper - H.M.Chanrasena Gunawardena', '105@1.com', '11', '11', '11', 1, '22234.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(183, '343 - K.Dilanka Sandaruwan', '343@3.com', '11', '11', '11', 1, '20239.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(184, '343 - Pumper - M.G.Lasitha Madushanka', '343@3.com', '11', '11', '11', 1, '25536.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(185, '341 - Pumper - J.M.Tissa Wijekumara', '341@3.com', '11', '11', '11', 1, '50730.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(186, '224 - Pumper - L.P.G.Anura Kumara Aruyarathna', '224@2.com', '11', '11', '11', 1, '4821.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(187, '187 - Pumper - Danushka Udayanga H.L.D', '187@1.com', '11', '11', '11', 1, '61679.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(188, '213 - Pumper - P.T.Sajith Prasanna', '213@2.com', '11', '11', '11', 1, '19695.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(189, '216 - Pumper - S.A.Prasad', '216@2.com', '11', '11', '11', 1, '16100.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(190, '113- APH (Vetnary Office)', '113@1.com', '11', '11', '11', 1, '75732.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(191, '8 - Police Station - Uhana', '8@8.com', '11', '11', '11', 1, '185116.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(192, '67 - Liyanage - Kumaragama', '67@6.com', '11', '11', '11', 1, '19270.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(193, '66 - Kapila - Tractor', '66@6.com', '11', '11', '11', 1, '950', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(194, '65 - Asanka Weeragoda', '65@6.com', '11', '11', '11', 1, '36785.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(195, '63 - SK Wave (Sandun)', '63@6.com', '11', '11', '11', 1, '2800.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(196, '59 - Nanayakkara Stores - RajagalaThanna', '59@5.com', '11', '11', '11', 1, '128320.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(197, '43 - Kethsiri - Tractor', '43@4.com', '11', '11', '11', 1, '4540.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(198, '39 - Sumith Bandara - Manager', '39@3.com', '11', '11', '11', 1, '3361.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(199, '31 - Akanayaka (Muditha)', '31@3.com', '11', '11', '11', 1, '307534.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(200, '26 - D.T. Himaya Mhipali', '26@2.com', '11', '11', '11', 1, '4348.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(201, '24 - Sandamali Stores - Himidurawa', '24@2.com', '11', '11', '11', 1, '112125.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(202, '20 - President Order', '20@2.com', '11', '11', '11', 1, '7125.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(203, '12 - Ranpasindu Bus', '12@1.com', '11', '11', '11', 1, '24132.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(204, '8 - Police Station - Uhana', '8@8.com', '11', '11', '11', 1, '70903.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(205, '7 - Weerasiri Bus Laxman', '7@7.com', '11', '11', '11', 1, '87157.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(206, '6 - Isuru Layanal', '6@6.com', '11', '11', '11', 1, '66930.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(207, '5 - Anura Gamage Dialog', '5@5.com', '11', '11', '11', 1, '13597.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(208, '4 - Pradeshiyasaba - Uhana', '4@4.com', '11', '11', '11', 1, '447440.56', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(209, 'Liyanage - Kumaragama', 'Liyanage@L.com', '11', '11', '11', 1, '19270.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(210, 'Kapila - Tractor', 'Kapila@K.com', '11', '11', '11', 1, '950', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(211, 'Asanka Weeragoda', 'Asanka@A.com', '11', '11', '11', 1, '36785.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(212, 'SK Wave (Sandun)', 'SK@S.com', '11', '11', '11', 1, '2800.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(213, 'Nanayakkara Stores - RajagalaThanna', 'Nanayakkara Stores@N.com', '11', '11', '11', 1, '128320.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(214, 'Kethsiri - Tractor', 'Kethsiri@K.com', '11', '11', '11', 1, '4540.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(215, 'Sumith Bandara - Manager', 'Sumith Bandara@S.com', '11', '11', '11', 1, '3361.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(216, 'Akanayaka (Muditha)', 'Akanayaka@A.com', '11', '11', '11', 1, '307534.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(217, 'D.T. Himaya Mhipali', 'D@D.com', '11', '11', '11', 1, '4348.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(218, 'Sandamali Stores - Himidurawa', 'Sandamali Stores@S.com', '11', '11', '11', 1, '112125.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(219, 'Ranpasindu Bus', 'Ranpasindu@R.com', '11', '11', '11', 1, '24132.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(220, 'Police Station - Uhana', 'Police Station@P.com', '11', '11', '11', 1, '427480.76', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(221, 'Weerasiri Bus Laxman', 'Weerasiri@W.com', '11', '11', '11', 1, '87157.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(222, 'Isuru Layanal', 'Isuru@I.com', '11', '11', '11', 1, '66930.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(223, 'Anura Gamage Dialog', 'Anura@A.com', '11', '11', '11', 1, '13597.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(224, 'Pradeshiyasaba - Uhana', 'Pradeshiyasaba@P.com', '11', '11', '11', 1, '447440.56', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(225, 'Liyanage - Kumaragama', 'Liyanage@L.com', '11', '11', '11', 1, '19270.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(226, 'Kapila - Tractor', 'Kapila@K.com', '11', '11', '11', 1, '950', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(227, 'Asanka Weeragoda', 'Asanka@A.com', '11', '11', '11', 1, '36785.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(228, 'SK Wave (Sandun)', 'SK@S.com', '11', '11', '11', 1, '2800.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(229, 'Nanayakkara Stores - RajagalaThanna', 'Nanayakkara Stores@N.com', '11', '11', '11', 1, '128320.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(230, 'Kethsiri - Tractor', 'Kethsiri@K.com', '11', '11', '11', 1, '4540.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(231, 'Sumith Bandara - Manager', 'Sumith Bandara@S.com', '11', '11', '11', 1, '3361.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(232, 'Akanayaka (Muditha)', 'Akanayaka@A.com', '11', '11', '11', 1, '307534.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(233, 'D.T. Himaya Mhipali', 'D@D.com', '11', '11', '11', 1, '4348.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(234, 'Sandamali Stores - Himidurawa', 'Sandamali Stores@S.com', '11', '11', '11', 1, '112125.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(235, 'Ranpasindu Bus', 'Ranpasindu@R.com', '11', '11', '11', 1, '24132.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(236, 'Police Station - Uhana', 'Police Station@P.com', '11', '11', '11', 1, '427480.76', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(237, 'Weerasiri Bus Laxman', 'Weerasiri@W.com', '11', '11', '11', 1, '87157.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(238, 'Isuru Layanal', 'Isuru@I.com', '11', '11', '11', 1, '66930.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(239, 'Anura Gamage Dialog', 'Anura@A.com', '11', '11', '11', 1, '13597.00', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(240, 'Pradeshiyasaba - Uhana', 'Pradeshiyasaba@P.com', '11', '11', '11', 1, '447440.56', '0', 36, '2017-08-28 13:39:44', 0, NULL, '11', '1', NULL),
(241, 'Customer50', 'Customer50@gmail.com', '', '9979133538', 'surat gujarat india', 1, '2500', '0', 36, '2017-09-06 13:31:31', 0, NULL, 'Customer50@gmail.com', '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_group`
--

CREATE TABLE IF NOT EXISTS `customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `customer_group`
--

INSERT INTO `customer_group` (`id`, `name`, `is_active`) VALUES
(1, 'General Customer', 1),
(2, 'sads', 1);

-- --------------------------------------------------------

--
-- Table structure for table `daily_collection`
--

CREATE TABLE IF NOT EXISTS `daily_collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `collection_form_no` varchar(255) NOT NULL DEFAULT '',
  `pumper_id` varchar(255) NOT NULL DEFAULT '',
  `settlement_id` varchar(255) NOT NULL DEFAULT '',
  `settlement_date` datetime NOT NULL,
  `balance_collection` varchar(255) NOT NULL DEFAULT '0',
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `created_by` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `delete_inventory_settlement`
--

CREATE TABLE IF NOT EXISTS `delete_inventory_settlement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qty` varchar(255) NOT NULL DEFAULT '',
  `product_code` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `fuel_warehouse_id` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '0: Warehouse, 1: Fuel ',
  `inventory_id` varchar(255) NOT NULL DEFAULT '',
  `orders_item_id` varchar(255) NOT NULL DEFAULT '',
  `created_at` varchar(255) NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: active, 1: inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `delete_inventory_settlement`
--

INSERT INTO `delete_inventory_settlement` (`id`, `qty`, `product_code`, `outlet_id`, `fuel_warehouse_id`, `type`, `inventory_id`, `orders_item_id`, `created_at`, `created_date`, `status`) VALUES
(1, '20', 'Product3', '1', '1', '0', '1', '17', '36', '2017-08-24 10:57:48', '0'),
(2, '5', 'Product1', '1', '2', '1', '3', '38', '36', '2017-08-25 10:07:08', '0'),
(3, '5', 'Product1', '1', '2', '1', '3', '39', '36', '2017-08-25 10:07:08', '0'),
(4, '10', 'Product1', '1', '1', '1', '2', '40', '36', '2017-08-25 10:07:08', '0');

-- --------------------------------------------------------

--
-- Table structure for table `dip_report`
--

CREATE TABLE IF NOT EXISTS `dip_report` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE IF NOT EXISTS `division` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `name`, `is_active`) VALUES
(1, 'div1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `esctax`
--

CREATE TABLE IF NOT EXISTS `esctax` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(85) NOT NULL,
  `tax_percentage` varchar(3) NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '1=ON, 0=OFF',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `last_modefied_at` datetime NOT NULL,
  `last_modefied_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expenses_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expense_category` int(11) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(4999) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expenses_number`, `expense_category`, `outlet_id`, `outlet_name`, `date`, `amount`, `reason`, `file_name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `payment_type`, `transaction_id_fk`) VALUES
(1, '1', 2, 1, 'Outlet1', '2017-08-04', '100.00', 'month July', '', 36, '2017-08-04 00:00:00', 0, '0000-00-00 00:00:00', 1, 1, 432),
(2, '2', 1, 1, 'Outlet1', '2017-08-25', '10.00', 'no', '', 36, '2017-08-25 00:00:00', 0, '0000-00-00 00:00:00', 1, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

CREATE TABLE IF NOT EXISTS `expense_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL COMMENT '0: Inactive, 1: Active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `expense_categories`
--

INSERT INTO `expense_categories` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(1, 'test', 36, '2017-07-25 22:11:15', 0, '0000-00-00 00:00:00', 1),
(2, 'Electricity ', 36, '2017-07-25 22:11:24', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fuel_tanks`
--

CREATE TABLE IF NOT EXISTS `fuel_tanks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `fuel_tank_number` varchar(50) NOT NULL,
  `fuel_type` varchar(30) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `starting_volume` varchar(255) NOT NULL,
  `current_balance` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fuel_tanks`
--

INSERT INTO `fuel_tanks` (`id`, `product_id`, `fuel_tank_number`, `fuel_type`, `outlet_id`, `starting_volume`, `current_balance`, `user_id`, `created`) VALUES
(1, 1, 'Tank1', '', 1, '0', '113208.00', 36, '2017-08-29 10:06:59'),
(2, 2, 'Tanks2', '', 1, '200', '442.00', 36, '2017-08-29 10:07:16'),
(3, 3, 'Tanks3', '', 1, '200', '20.00', 36, '2017-08-29 10:07:27'),
(4, 2, 'FT95-2', '', 1, '200', '665.00', 36, '2017-09-08 04:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_tanks_reading`
--

CREATE TABLE IF NOT EXISTS `fuel_tanks_reading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_id` varchar(255) NOT NULL DEFAULT '',
  `purchase_order_no` varchar(255) NOT NULL DEFAULT '',
  `tank_id` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `tank_qty` varchar(255) NOT NULL DEFAULT '0',
  `total_tank_balance` varchar(255) NOT NULL DEFAULT '0',
  `available_tank_qty` varchar(255) NOT NULL DEFAULT '0',
  `purchase_qty` varchar(255) NOT NULL DEFAULT '0',
  `sold_qty` varchar(255) NOT NULL DEFAULT '0',
  `created_by` varchar(255) NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Active , 1: Inactive, 2: Tempory',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `fuel_tanks_reading`
--

INSERT INTO `fuel_tanks_reading` (`id`, `settlement_id`, `purchase_order_no`, `tank_id`, `outlet_id`, `tank_qty`, `total_tank_balance`, `available_tank_qty`, `purchase_qty`, `sold_qty`, `created_by`, `created_date`, `status`) VALUES
(1, '', '16', '1', '1', '20', '112929', '112929', '20', '0', '36', '2017-09-04 18:10:35', '0'),
(2, '', '17', '1', '1', '20', '112949', '112949', '20', '0', '36', '2017-09-04 18:11:23', '0'),
(3, '', '20', '1', '1', '20', '112989', '112989', '20', '0', '36', '2017-09-04 18:17:21', '0'),
(4, '11', '', '3', '1', '3', '23', '17', '0', '3', '36', '2017-09-04 18:30:20', '0'),
(5, '', '22', '1', '1', '20', '113009', '113009', '20', '0', '36', '2017-09-05 12:53:42', '0'),
(6, '', '22', '2', '1', '30', '388', '388', '30', '0', '36', '2017-09-05 12:53:42', '0'),
(7, '', '23', '1', '1', '20', '113029', '113029', '20', '0', '36', '2017-09-05 12:59:20', '0'),
(8, '', '23', '2', '1', '10', '398', '398', '10', '0', '36', '2017-09-05 12:59:20', '0'),
(9, '', '24', '1', '1', '20', '113049', '113049', '20', '0', '36', '2017-09-06 09:45:56', '0'),
(10, '', '24', '2', '1', '30', '428', '428', '30', '0', '36', '2017-09-06 09:45:56', '0'),
(11, '', '25', '1', '1', '20', '113069', '113069', '20', '0', '36', '2017-09-06 09:49:58', '0'),
(12, '', '26', '1', '1', '20', '113089', '113089', '20', '0', '36', '2017-09-06 09:50:50', '0'),
(13, '', '1', '1', '1', '20', '113109', '113109', '20', '0', '36', '2017-09-06 09:53:59', '0'),
(14, '', '1', '1', '1', '20', '113129', '113129', '20', '0', '36', '2017-09-06 09:53:59', '0'),
(15, '', '3', '2', '1', '20', '448', '448', '20', '0', '36', '2017-09-06 09:59:19', '0'),
(16, '12', '', '1', '1', '1', '113130', '113128', '0', '1', '36', '2017-09-06 13:03:24', '0'),
(17, '12', '', '2', '1', '5', '453', '443', '0', '5', '36', '2017-09-06 13:03:24', '0'),
(18, '12', '', '3', '1', '5', '22', '12', '0', '5', '36', '2017-09-06 13:03:24', '0'),
(19, '13', '', '3', '1', '10', '22', '2', '0', '10', '36', '2017-09-06 13:04:16', '0'),
(20, '14', '', '2', '1', '1', '444', '442', '0', '1', '36', '2017-09-06 13:38:30', '0'),
(21, '15', '', '3', '1', '1', '3', '1', '0', '1', '36', '2017-09-06 13:56:19', '0'),
(22, '16', '', '3', '1', '1', '2', '0', '0', '1', '36', '2017-09-06 13:57:07', '0'),
(23, '', '4', '3', '1', '20', '20', '20', '20', '0', '36', '2017-09-06 15:00:37', '0'),
(24, '', '5', '1', '1', '20', '113158', '113158', '20', '0', '36', '2017-09-06 15:55:21', '0'),
(25, '', '5', '1', '1', '50', '113208', '113208', '50', '0', '36', '2017-09-06 15:55:21', '0'),
(26, '', '', '4', '1', '200', '200', '200', '0', '0', '36', '2017-09-08 10:08:05', '0'),
(27, '', '6', '4', '1', '25', '225', '225', '25', '0', '36', '2017-09-08 10:10:22', '0'),
(28, '', '', '4', '1', '20', '245', '205', '0', '20', '36', '2017-09-08 10:11:57', '0'),
(29, '', '7', '4', '1', '500', '705', '705', '500', '0', '36', '2017-09-08 10:13:23', '0'),
(30, '', '', '4', '1', '40', '745', '665', '0', '40', '36', '2017-09-08 10:15:05', '0');

-- --------------------------------------------------------

--
-- Table structure for table `fuel_types`
--

CREATE TABLE IF NOT EXISTS `fuel_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fuel_type` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`fuel_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gift_card`
--

CREATE TABLE IF NOT EXISTS `gift_card` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `card_number` varchar(90) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiry_date` date NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL COMMENT '0: haven''t use, 1: used',
  `outlet_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gold_grade`
--

CREATE TABLE IF NOT EXISTS `gold_grade` (
  `grade_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `grade_name` varchar(100) NOT NULL,
  `grade_price` float(6,2) NOT NULL,
  `gold_purity` float(6,2) NOT NULL,
  `date_created` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `trash` varchar(10) NOT NULL,
  PRIMARY KEY (`grade_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gold_grade`
--

INSERT INTO `gold_grade` (`grade_id`, `grade_name`, `grade_price`, `gold_purity`, `date_created`, `status`, `trash`) VALUES
(1, '24', 9999.99, 2500.00, '2017-08-05', 'active', '1'),
(2, 'smith', 2500.00, 24.00, '2017-08-18', 'active', '1');

-- --------------------------------------------------------

--
-- Table structure for table `gold_inventory`
--

CREATE TABLE IF NOT EXISTS `gold_inventory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `gold_code` varchar(100) NOT NULL,
  `i_gold_grade` varchar(100) NOT NULL,
  `i_gold_qty` float(20,3) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `idate_created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gold_orders`
--

CREATE TABLE IF NOT EXISTS `gold_orders` (
  `gold_id` int(11) NOT NULL AUTO_INCREMENT,
  `gold_customer_id` int(11) NOT NULL,
  `gold_customer_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_customer_email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_customer_mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_customer_note` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_ordered_datetime` datetime NOT NULL,
  `gold_outlet_id` int(11) NOT NULL,
  `gold_warehouse_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `gold_outlet_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_outlet_address` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gold_gold_outlet_contact` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `gold_outlet_receipt_footer` longtext COLLATE utf8_unicode_ci NOT NULL,
  `gold_gold_gift_card` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gold_subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_discount_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_discount_percentage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_gold_total_items` int(11) NOT NULL,
  `gold_payment_method` int(11) NOT NULL,
  `gold_payment_method_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_cheque_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gold_paid_amt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gold_return_change` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
  `gold_point` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gold_balance` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`gold_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gold_prices`
--

CREATE TABLE IF NOT EXISTS `gold_prices` (
  `gp_id` int(11) NOT NULL AUTO_INCREMENT,
  `gp_grade` int(11) NOT NULL,
  `gp_purity` float(6,3) NOT NULL,
  `gp_price` float(6,2) NOT NULL,
  `gp_date` date NOT NULL,
  `gp_date_created` datetime NOT NULL,
  PRIMARY KEY (`gp_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gold_products`
--

CREATE TABLE IF NOT EXISTS `gold_products` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gold_smith`
--

CREATE TABLE IF NOT EXISTS `gold_smith` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gold_smith`
--

INSERT INTO `gold_smith` (`gs_id`, `fullname`, `gender`, `email`, `password`, `status`, `address`, `phone`, `land_phone_number`, `dob`, `nic`, `weight__qty_pergram`, `gold_smith_num`, `date_created`) VALUES
(1, 'hardik', 'Male', 'hardik@gmail.com', '', 'active', 'surat', '9979133538', '9979133538', '2017-08-30', '', 10000000.000, '10', '2017-08-18'),
(2, 'GoldSmith1', 'Male', 'GoldSmith1@gmail.com', '', 'active', 'surat', '9979133538', '9979133538', '2017-09-16', '', 10000000.000, '9979133538', '2017-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `qty` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ow_id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '0: Warehouse, 1: Fuel ',
  `date` datetime NOT NULL,
  `updated_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `batch_no` varchar(35) COLLATE utf8_unicode_ci NOT NULL,
  `expire_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=12 ;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_code`, `outlet_id`, `qty`, `ow_id`, `type`, `date`, `updated_date`, `batch_no`, `expire_date`) VALUES
(1, 'Product1', 1, '113198.00', 1, '1', '2017-08-29 15:36:59', '2017-09-06 15:55:21', '', '0000-00-00'),
(2, 'Product2', 1, '442.00', 2, '1', '2017-08-29 15:37:16', '2017-09-06 13:38:30', '', '0000-00-00'),
(3, 'Product3', 1, '20.00', 3, '1', '2017-08-29 15:37:27', '2017-09-06 15:00:37', '', '0000-00-00'),
(4, 'Product8', 1, '249877864.00', 1, '0', '2017-08-31 09:51:26', '2017-09-08 16:33:25', '', '0000-00-00'),
(5, 'Product8', 1, '288.00', 2, '0', '2017-08-31 09:51:26', '2017-09-06 16:27:17', '', '0000-00-00'),
(6, 'Product8', 1, '1995.00', 3, '0', '2017-08-31 09:51:26', '2017-09-06 09:57:04', '', '0000-00-00'),
(7, 'product10', 1, '-7.00', 1, '0', '2017-09-06 13:11:03', '2017-09-06 16:27:17', '', '0000-00-00'),
(8, 'product10', 1, '0.00', 2, '0', '2017-09-06 13:11:03', '2017-09-06 13:11:03', '', '0000-00-00'),
(9, 'product10', 1, '0.00', 3, '0', '2017-09-06 13:11:03', '2017-09-06 13:11:03', '', '0000-00-00'),
(10, 'Product11', 1, '10.00', 1, '1', '2017-09-06 13:15:49', '2017-09-06 13:15:49', '', '0000-00-00'),
(11, 'Product2', 1, '665.00', 4, '1', '2017-09-08 10:08:05', '2017-09-08 10:15:05', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `loan`
--

CREATE TABLE IF NOT EXISTS `loan` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `meter_reset`
--

CREATE TABLE IF NOT EXISTS `meter_reset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `pump_id` varchar(255) NOT NULL DEFAULT '',
  `product_id` varchar(255) NOT NULL DEFAULT '',
  `tank_id` varchar(255) NOT NULL DEFAULT '',
  `last_meter` varchar(255) NOT NULL DEFAULT '',
  `reset_new_meter` varchar(255) NOT NULL DEFAULT '',
  `reason` text NOT NULL,
  `created_at` varchar(255) NOT NULL DEFAULT '',
  `created_date` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1' COMMENT '1: Active , 0: Inactive',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=123 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(1, 0, 'appointments', ' Appointments', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00', '1'),
(2, 1, 'add_appointment', 'Add Appointment', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00', '1'),
(3, 1, 'list_appointment', 'Manage Appointments', 36, '2017-08-23 15:03:50', 0, '0000-00-00 00:00:00', '1'),
(4, 0, 'purchase_order', 'Purchase Module', 36, '2017-08-23 15:04:17', 0, '0000-00-00 00:00:00', '1'),
(5, 4, 'po_view', 'Purchases', 36, '2017-08-23 15:04:45', 0, '0000-00-00 00:00:00', '1'),
(6, 4, 'suppliers', 'Suppliers', 36, '2017-08-23 15:05:09', 0, '0000-00-00 00:00:00', '1'),
(7, 4, 'pay_suppliers', 'Pay Suppliers', 36, '2017-08-23 15:05:28', 0, '0000-00-00 00:00:00', '1'),
(8, 4, 'purchase_return', 'Purchase Return', 36, '2017-08-23 15:05:46', 0, '0000-00-00 00:00:00', '1'),
(9, 4, 'purchase_bills', 'Purchase Bills', 36, '2017-08-23 15:06:08', 0, '0000-00-00 00:00:00', '1'),
(10, 4, 'purchase_bonus', 'Purchase Bonus', 36, '2017-08-23 15:06:27', 0, '0000-00-00 00:00:00', '1'),
(11, 0, 'sales', ' Sales Module', 36, '2017-08-23 15:07:37', 0, '0000-00-00 00:00:00', '1'),
(12, 11, 'view', 'sales', 36, '2017-08-23 15:09:47', 0, '0000-00-00 00:00:00', '1'),
(13, 0, 'customers', 'Customers Module', 36, '2017-08-23 15:27:16', 0, '0000-00-00 00:00:00', '1'),
(14, 13, 'view', 'Customers', 36, '2017-08-23 15:29:06', 0, '0000-00-00 00:00:00', '1'),
(15, 0, 'debit', 'Debit Module', 36, '2017-08-23 15:32:45', 0, '0000-00-00 00:00:00', '1'),
(16, 15, 'view', 'Credit Sales', 36, '2017-08-23 15:33:03', 0, '0000-00-00 00:00:00', '1'),
(17, 11, 'list_sales', 'Today Sales', 36, '2017-08-23 15:33:39', 0, '0000-00-00 00:00:00', '1'),
(18, 11, 'opened_bill', 'Opened Bill', 36, '2017-08-23 15:34:02', 0, '0000-00-00 00:00:00', '1'),
(19, 11, 'pos', 'POS', 36, '2017-08-23 15:34:34', 0, '0000-00-00 00:00:00', '1'),
(20, 11, 'settlement', 'Settelment', 36, '2017-08-23 15:34:54', 0, '0000-00-00 00:00:00', '1'),
(21, 0, 'returnorder', 'Sales Return Module', 36, '2017-08-23 15:43:28', 0, '0000-00-00 00:00:00', '1'),
(22, 21, 'create_return', 'Create Sales Return', 36, '2017-08-23 15:43:55', 0, '0000-00-00 00:00:00', '1'),
(23, 21, 'return_report', 'Sales Return Receipt', 36, '2017-08-23 15:44:16', 0, '0000-00-00 00:00:00', '1'),
(24, 0, 'store', 'Warehouse Module', 36, '2017-08-23 15:46:16', 0, '0000-00-00 00:00:00', '1'),
(25, 0, 'gold', 'Gold Module', 36, '2017-08-23 15:57:39', 0, '0000-00-00 00:00:00', '1'),
(26, 24, 'warehouse_list', 'List Warehouses', 36, '2017-08-23 15:58:24', 0, '0000-00-00 00:00:00', '1'),
(27, 24, 'assign_store', 'Assign Warehouse', 36, '2017-08-23 16:34:05', 0, '0000-00-00 00:00:00', '1'),
(28, 24, 'warehouse_stocks', 'Warehouse Stocks', 36, '2017-08-23 16:34:25', 0, '0000-00-00 00:00:00', '1'),
(29, 24, 'transfer_stocks', 'Transfer Stocks', 36, '2017-08-23 16:34:45', 0, '0000-00-00 00:00:00', '1'),
(30, 25, 'addgrade', 'Add Gold-Grade', 36, '2017-08-23 16:35:36', 0, '0000-00-00 00:00:00', '1'),
(31, 25, 'Gold_gold_prices', 'Gold Grade & Prices', 36, '2017-08-23 16:35:56', 0, '0000-00-00 00:00:00', '1'),
(32, 25, 'order_estimate', ' Order Estimate', 36, '2017-08-23 16:36:31', 0, '0000-00-00 00:00:00', '1'),
(33, 25, 'Goldsmith', 'Goldsmith', 36, '2017-08-23 16:38:45', 0, '0000-00-00 00:00:00', '1'),
(34, 25, 'view_transfer', 'Transfer', 36, '2017-08-23 16:39:06', 0, '0000-00-00 00:00:00', '1'),
(35, 25, 'list_store_transfer', 'View Store Record', 36, '2017-08-23 16:39:22', 0, '0000-00-00 00:00:00', '1'),
(36, 25, 'list_order_estimate', 'List Order Estimate', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00', '1'),
(37, 25, 'Gold_gradeview', 'Gold Grade List', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00', '1'),
(38, 0, 'refine_gold', 'Refined Gold Module', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00', '1'),
(39, 38, 'refine_order_list', 'Refine Order List', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00', '1'),
(40, 38, 'add_refine_order', 'Add Refine Order', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00', '1'),
(41, 38, 'add_refined_receive_note', 'Add Refined Receieved Note', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00', '1'),
(42, 38, 'refined_gold', 'Refined Gold List', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00', '1'),
(43, 0, 'productions', 'Production Module', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00', '1'),
(44, 43, 'all_production', 'Production', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00', '1'),
(45, 43, 'list_goldsmith_wastage', 'Goldsmith Wastage', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00', '1'),
(46, 0, 'bakery_sales', 'Bakery Module', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00', '1'),
(47, 46, 'bakerySales', 'Bakery Sales', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00', '1'),
(48, 46, 'issue_sale_report', 'Issue Sales Report', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00', '1'),
(49, 0, 'pumps', 'Pumps Module', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00', '1'),
(50, 49, 'index', 'List Pumps', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00', '1'),
(51, 49, 'list_operators', 'List Pump Operators', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00', '1'),
(52, 49, 'list_ft', 'List Fuel Tanks', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00', '1'),
(53, 49, 'pumpSales', 'Pump Comm & Shortage', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00', '1'),
(54, 49, 'settlement_pump', 'Settlement', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00', '1'),
(55, 49, 'settlement_list', 'Settlement List', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00', '1'),
(56, 49, 'escTax', 'Esc Tax', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00', '1'),
(57, 49, 'pumperreport', 'Pump Operator Reports', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00', '1'),
(58, 49, 'fuelsalereport', 'Fuel Sale Reports', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00', '1'),
(59, 49, 'dipreport', 'Dip Reports', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00', '1'),
(60, 49, 'daily_collection', 'Daily Collection', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00', '1'),
(61, 49, 'pump_reading', 'Pump Reading', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00', '1'),
(62, 49, 'testing_detail', 'Testing Detail', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00', '1'),
(63, 49, 'meter_resetting', 'Meter Resetting', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00', '1'),
(64, 0, 'loan', 'Loan Module', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00', '1'),
(65, 64, 'loan_list', 'Loan List', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00', '1'),
(66, 64, 'settle_loan', 'Settle Loan', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00', '1'),
(67, 0, 'inventory', 'Inventory Module', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00', '1'),
(68, 67, 'view', 'Inventory', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00', '1'),
(69, 0, 'products', 'Products Module', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00', '1'),
(70, 69, 'list_products', 'List Products', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00', '1'),
(71, 69, 'product_category', 'Product Category', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00', '1'),
(72, 69, 'print_label', 'Print Product Label', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00', '1'),
(73, 69, 'reorder_detail', 'Re Order Details', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00', '1'),
(74, 0, 'brand', 'Brand Module', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00', '1'),
(75, 74, 'view', 'Brand', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00', '1'),
(76, 0, 'sub_category', 'Sub Category Module', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00', '1'),
(77, 76, 'view', 'Sub Category', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00', '1'),
(78, 0, 'bank_accounts', 'Banking Module ', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00', '1'),
(79, 78, 'index', 'Bank Accounts', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00', '1'),
(80, 0, 'bank_dt', 'Bank Deposit/Transfer Module', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00', '1'),
(81, 80, 'index', 'Bank Deposit/Transfer', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00', '1'),
(82, 78, 'balance', 'Account Balances', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00', '1'),
(83, 0, 'receivedcheque', 'Received Cheque Module', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00', '1'),
(84, 83, 'voucherdetail', 'Voucher Details', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00', '1'),
(85, 0, 'cheque_manager', 'Cheque Manager Module', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00', '1'),
(86, 0, 'gift_card', ' Gift Card Module', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00', '1'),
(87, 86, 'add_gift_card', 'Add Gift Card', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00', '1'),
(88, 86, 'list_gift_card', '  List Gift Card', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00', '1'),
(89, 0, 'expenses', ' Expenses Module ', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00', '1'),
(90, 89, 'view', 'Expenses', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00', '1'),
(91, 89, 'expense_category', ' Expense Category', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00', '1'),
(92, 0, 'reports', 'Reports Module', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00', '1'),
(93, 92, 'sales_report', ' Product Sales Report', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00', '1'),
(94, 92, 'product_report', ' Product Report', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00', '1'),
(95, 92, 'product_category_report', 'Product Category Report', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00', '1'),
(96, 92, 'sales_report_payement', 'Sales Report', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00', '1'),
(97, 92, 'daily_summary_report', 'Daily Summary Report', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00', '1'),
(98, 92, 'credit_sales_payment', ' Credit Sales Payments', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00', '1'),
(99, 92, 'taxes', 'Taxes', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00', '1'),
(100, 92, 'product_batch_expiry', ' Product Batch Expiry', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00', '1'),
(101, 0, 'pnl', 'Profit & Loss Module', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00', '1'),
(102, 101, 'view', 'P & L Graphs', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00', '1'),
(103, 101, 'view_pnl_report', 'P & L Report', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00', '1'),
(104, 0, 'setting', 'Setting Module', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00', '1'),
(105, 104, 'outlets', 'Outlets', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00', '1'),
(106, 104, 'users', 'Users', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00', '1'),
(107, 104, 'staff', 'Staff', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00', '1'),
(108, 104, 'permission', 'Permission', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00', '1'),
(109, 104, 'payment_methods', ' Payment Methods', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00', '1'),
(110, 104, 'bill_numbering', 'Bill Numbering', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00', '1'),
(111, 104, 'product_code_numbering', ' Product Code Numbering', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00', '1'),
(112, 104, 'add_new_page', ' Add New Page', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00', '1'),
(113, 104, 'download_database', 'Download Database', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00', '1'),
(114, 104, 'system_setting', 'System Setting', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00', '1'),
(115, 0, 'dashboard', 'Dashboard', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00', '1'),
(116, 49, 'deleted_settlement', 'Deleted Settlement', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00', '1'),
(117, 49, 'fuel_reading', ':Fuel Meter Readings', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00', '1'),
(118, 43, 'all_work_job_order', 'Work / Job Order', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00', '1'),
(119, 43, 'producation_receive', 'Receive Production Module', 36, '2017-09-01 16:26:00', 0, '0000-00-00 00:00:00', '1'),
(120, 4, 'purchase_direct', 'Purchase Direct', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00', '1'),
(121, 11, 'credit_limits', 'Credit Limits', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00', '1'),
(122, 43, 'receive_work_job_order', 'Receive Work / Job Order', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
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
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Active , 1: Inactive,2: temporary',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_gold`
--

CREATE TABLE IF NOT EXISTS `orders_gold` (
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
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_percentage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
  `paid_amt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `return_change` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders_payment`
--

CREATE TABLE IF NOT EXISTS `orders_payment` (
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
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_percentage` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extra_credit_debit_balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `total_items` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cheque_number` varchar(499) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paid_amt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `unpaid_amt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `return_change` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `vt_status` int(11) NOT NULL COMMENT '0: Debit Payment, 1: Completed',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '1: active, 2: inactive',
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
  `bring_forword` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_category` int(11) NOT NULL,
  `cost` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vt_status` int(11) DEFAULT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `return_change` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `discount_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `card_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cheque_number` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gift_card` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pump_operators_id` int(11) NOT NULL,
  `pump_id` int(11) DEFAULT NULL,
  `short_amount` float DEFAULT NULL,
  `payment_deails` text COLLATE utf8_unicode_ci,
  `ow_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '0= warehouse, 1 =tank',
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0' COMMENT '0: Active , 1: Inactive,2:tempory',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `order_items_gold`
--

CREATE TABLE IF NOT EXISTS `order_items_gold` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_category` int(11) NOT NULL,
  `cost` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` float(10,3) NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `balance_stock` int(100) NOT NULL,
  `warehouse_id` int(100) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vt_status` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment_method_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `return_change` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `paid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `other_cost_and_name`
--

CREATE TABLE IF NOT EXISTS `other_cost_and_name` (
  `other_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_reference_id` varchar(100) NOT NULL,
  `other_name` varchar(100) NOT NULL,
  `other_cost` float(10,3) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`other_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `other_cost_and_name_estimate_order`
--

CREATE TABLE IF NOT EXISTS `other_cost_and_name_estimate_order` (
  `est_other_id` int(11) NOT NULL,
  `invoice` varchar(100) NOT NULL,
  `other_name` varchar(100) NOT NULL,
  `other_cost` float(10,3) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `code_` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--

CREATE TABLE IF NOT EXISTS `outlets` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `outlets`
--

INSERT INTO `outlets` (`id`, `name`, `store_id`, `address`, `contact_number`, `receipt_header`, `receipt_footer`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(1, 'Outlet1', 0, 'Outlet1', '9979133538', '', '<p>Outlet1 Footer</p>', 36, '2017-08-22 12:33:42', 0, '0000-00-00 00:00:00', 1),
(2, 'Outlet2', 0, 'Outlet2', '9979133538', '', '<p>Outlet2 Footer</p>', 36, '2017-08-22 12:46:55', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `outlet_warehouse`
--

CREATE TABLE IF NOT EXISTS `outlet_warehouse` (
  `ow_id` int(11) NOT NULL AUTO_INCREMENT,
  `out_id` int(11) NOT NULL,
  `w_id` int(11) NOT NULL,
  `centerwarehouse_id` int(11) NOT NULL,
  `ow_date` date NOT NULL,
  PRIMARY KEY (`ow_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `outlet_warehouse`
--

INSERT INTO `outlet_warehouse` (`ow_id`, `out_id`, `w_id`, `centerwarehouse_id`, `ow_date`) VALUES
(1, 1, 1, 0, '2017-08-29'),
(2, 1, 2, 0, '2017-08-29'),
(3, 1, 3, 0, '2017-08-29'),
(4, 2, 2, 0, '2017-08-29'),
(5, 2, 3, 0, '2017-08-29');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `balance` text COLLATE utf8_unicode_ci NOT NULL,
  `outlet_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=35 ;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `name`, `balance`, `outlet_id`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(1, 'Cash', '2108101.4', '1', 36, '2016-09-25 01:43:41', 2, '2017-09-08 16:33:25', 1),
(3, 'Credit cards', '153379.8', '1', 36, '2016-09-25 01:43:50', 36, '2017-09-06 13:04:16', 1),
(5, 'Cheque', '34765', '1', 36, '2016-09-25 01:44:02', 36, '2017-09-02 18:02:17', 1),
(6, 'Debit / Credit Sales', '15684140.44', '1', 36, '2016-09-25 01:44:05', 36, '2017-09-06 18:03:37', 1),
(7, 'Gift Card', '0', '1', 36, '2016-10-16 01:23:05', 0, '0000-00-00 00:00:00', 1),
(8, 'Deposit', '350', '1', 36, '2016-11-27 23:09:14', 36, '2017-09-01 14:22:28', 1),
(9, 'Shortage Account', '0', '1', 36, '2017-01-05 15:06:10', 36, '2017-08-04 10:36:40', 1),
(10, 'Free', '4000', '1', 36, '2017-01-30 20:36:44', 36, '2017-08-29 18:51:11', 1),
(11, 'Points', '640', '1', 36, '2017-02-09 21:01:19', 36, '2017-09-01 14:24:43', 1),
(13, 'Dialog Cards', '0', '1', 36, '2017-06-04 17:20:51', 36, '2017-07-18 14:13:59', 1),
(14, 'Visa / Master', '0', '1', 36, '2017-06-04 17:21:23', 36, '2017-07-02 19:37:41', 1),
(15, 'Amex', '66500', '1', 36, '2017-06-04 17:21:39', 36, '2017-08-31 10:42:26', 1),
(16, 'P B Visa', '0', '1', 36, '2017-06-04 17:22:13', 36, '2017-07-02 11:06:12', 1),
(17, 'Vouchers', '99972.94', '1', 36, '0000-00-00 00:00:00', 36, '2017-08-31 10:54:35', 1),
(19, 'Excess', '-500.68', '1', 36, '2017-07-03 18:12:00', 36, '2017-08-30 11:01:51', 1),
(20, 'Cash', '310', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-23 17:42:10', 1),
(21, 'Credit cards', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(22, 'Cheque', '200', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-23 14:11:22', 1),
(23, 'Debit / Credit Sales', '2000', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 17:54:10', 1),
(24, 'Gift Card', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(25, 'Deposit', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(26, 'Shortage Account', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(27, 'Free', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(28, 'Points', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(29, 'Dialog Cards', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(30, 'Visa / Master', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(31, 'Amex', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(32, 'P B Visa', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(33, 'Vouchers', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1),
(34, 'Excess', '0', '2', 36, '2017-08-22 12:46:55', 36, '2017-08-22 12:46:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `main_menu` int(10) NOT NULL,
  `view_menu_right` int(10) NOT NULL,
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=245 ;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `user_id`, `resource_id`, `main_menu`, `view_menu_right`, `add_right`, `edit_right`, `view_right`, `delete_right`, `print_right`, `email_right`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES
(1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(2, 2, 2, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(3, 2, 3, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 2, 4, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(5, 2, 5, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(6, 2, 6, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(7, 2, 7, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(8, 2, 8, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(9, 2, 9, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(10, 2, 10, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(11, 2, 120, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(12, 2, 11, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(13, 2, 12, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(14, 2, 17, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(15, 2, 18, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(16, 2, 19, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(17, 2, 20, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(18, 2, 121, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(19, 2, 13, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(20, 2, 14, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(21, 2, 15, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(22, 2, 16, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(23, 2, 21, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(24, 2, 22, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(25, 2, 23, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(26, 2, 24, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(27, 2, 26, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(28, 2, 27, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(29, 2, 28, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(30, 2, 29, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(31, 2, 25, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(32, 2, 30, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(33, 2, 31, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(34, 2, 32, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(35, 2, 33, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(36, 2, 34, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(37, 2, 35, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(38, 2, 36, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(39, 2, 37, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(40, 2, 38, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(41, 2, 39, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(42, 2, 40, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(43, 2, 41, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(44, 2, 42, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(45, 2, 43, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(46, 2, 44, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(47, 2, 45, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(48, 2, 118, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(49, 2, 119, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(50, 2, 122, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(51, 2, 46, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(52, 2, 47, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(53, 2, 48, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(54, 2, 49, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(55, 2, 50, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(56, 2, 51, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(57, 2, 52, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(58, 2, 53, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(59, 2, 54, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(60, 2, 55, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(61, 2, 56, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(62, 2, 57, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(63, 2, 58, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(64, 2, 59, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(65, 2, 60, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(66, 2, 61, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(67, 2, 62, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(68, 2, 63, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(69, 2, 116, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(70, 2, 117, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(71, 2, 64, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(72, 2, 65, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(73, 2, 66, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(74, 2, 67, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(75, 2, 68, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(76, 2, 69, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(77, 2, 70, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(78, 2, 71, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(79, 2, 72, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(80, 2, 73, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(81, 2, 74, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(82, 2, 75, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(83, 2, 76, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(84, 2, 77, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(85, 2, 78, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(86, 2, 79, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(87, 2, 82, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(88, 2, 80, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(89, 2, 81, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(90, 2, 83, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(91, 2, 84, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(92, 2, 85, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(93, 2, 86, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(94, 2, 87, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(95, 2, 88, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(96, 2, 89, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(97, 2, 90, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(98, 2, 91, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(99, 2, 92, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(100, 2, 93, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(101, 2, 94, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(102, 2, 95, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(103, 2, 96, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(104, 2, 97, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(105, 2, 98, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(106, 2, 99, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(107, 2, 100, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(108, 2, 101, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(109, 2, 102, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(110, 2, 103, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(111, 2, 104, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(112, 2, 105, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(113, 2, 106, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(114, 2, 107, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(115, 2, 108, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(116, 2, 109, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(117, 2, 110, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(118, 2, 111, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(119, 2, 112, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(120, 2, 113, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(121, 2, 114, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(122, 2, 115, 1, 1, 1, 1, 1, 1, 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(123, 3, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(124, 3, 2, 0, 0, 1, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(125, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(126, 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(127, 3, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(128, 3, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(129, 3, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(130, 3, 8, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(131, 3, 9, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(132, 3, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(133, 3, 120, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(134, 3, 11, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(135, 3, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(136, 3, 17, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(137, 3, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(138, 3, 19, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(139, 3, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(140, 3, 121, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(141, 3, 13, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(142, 3, 14, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(143, 3, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(144, 3, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(145, 3, 21, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(146, 3, 22, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(147, 3, 23, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(148, 3, 24, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(149, 3, 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(150, 3, 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(151, 3, 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(152, 3, 29, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(153, 3, 25, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(154, 3, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(155, 3, 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(156, 3, 32, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(157, 3, 33, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(158, 3, 34, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(159, 3, 35, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(160, 3, 36, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(161, 3, 37, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(162, 3, 38, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(163, 3, 39, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(164, 3, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(165, 3, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(166, 3, 42, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(167, 3, 43, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(168, 3, 44, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(169, 3, 45, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(170, 3, 118, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(171, 3, 119, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(172, 3, 122, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(173, 3, 46, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(174, 3, 47, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(175, 3, 48, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(176, 3, 49, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(177, 3, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(178, 3, 51, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(179, 3, 52, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(180, 3, 53, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(181, 3, 54, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(182, 3, 55, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(183, 3, 56, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(184, 3, 57, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(185, 3, 58, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(186, 3, 59, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(187, 3, 60, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(188, 3, 61, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(189, 3, 62, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(190, 3, 63, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(191, 3, 116, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(192, 3, 117, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(193, 3, 64, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(194, 3, 65, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(195, 3, 66, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(196, 3, 67, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(197, 3, 68, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(198, 3, 69, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(199, 3, 70, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(200, 3, 71, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(201, 3, 72, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(202, 3, 73, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(203, 3, 74, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(204, 3, 75, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(205, 3, 76, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(206, 3, 77, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(207, 3, 78, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(208, 3, 79, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(209, 3, 82, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(210, 3, 80, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(211, 3, 81, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(212, 3, 83, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(213, 3, 84, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(214, 3, 85, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(215, 3, 86, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(216, 3, 87, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(217, 3, 88, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(218, 3, 89, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(219, 3, 90, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(220, 3, 91, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(221, 3, 92, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(222, 3, 93, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(223, 3, 94, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(224, 3, 95, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(225, 3, 96, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(226, 3, 97, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(227, 3, 98, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(228, 3, 99, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(229, 3, 100, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(230, 3, 101, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(231, 3, 102, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(232, 3, 103, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(233, 3, 104, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(234, 3, 105, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(235, 3, 106, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(236, 3, 107, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(237, 3, 108, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(238, 3, 109, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(239, 3, 110, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(240, 3, 111, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(241, 3, 112, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(242, 3, 113, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(243, 3, 114, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(244, 3, 115, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `prepay`
--

CREATE TABLE IF NOT EXISTS `prepay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `payment_method` int(11) NOT NULL,
  `payment` double NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `prepay`
--

INSERT INTO `prepay` (`id`, `customer_id`, `payment_method`, `payment`, `outlet_id`, `created_by`, `created`) VALUES
(2, 15, 1, 0, 0, 36, '2017-07-02 10:52:41');

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE IF NOT EXISTS `production` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `generic_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `category` int(11) NOT NULL,
  `sub_category_id_fk` int(11) NOT NULL,
  `purchase_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `retail_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
  `notification` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `generic_name`, `category`, `sub_category_id_fk`, `purchase_price`, `retail_price`, `thumbnail`, `rack`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `brand_id_fk`, `alt_qty`, `outlet_id_fk`, `weight`, `start_qty`, `supplier_id_fk`, `expire`, `notification`) VALUES
(1, 'Product1', 'Product1', 'Product1', 20, 2, '10.00000', '20.00', 'no_image.jpg', '10', 36, '2017-08-29 15:35:36', 0, '0000-00-00 00:00:00', 1, 2, 10, 1, '10', '0', 0, 0, '0'),
(2, 'Product2', 'Product2', 'Product2', 20, 2, '10.00000', '30.00', 'no_image.jpg', '20', 36, '2017-08-29 15:35:55', 0, '0000-00-00 00:00:00', 1, 2, 10, 1, '10', '0', 0, 0, '0'),
(3, 'Product3', 'Product3', 'Product3', 20, 1, '10.00000', '20.00', 'no_image.jpg', '20', 36, '2017-08-29 15:36:31', 0, '0000-00-00 00:00:00', 1, 1, 10, 1, '20', '0', 0, 0, '0'),
(4, 'Product8', 'Product8', 'Product8', 21, 9, '10.00000', '20.00', 'no_image.jpg', '20', 36, '2017-08-31 09:51:26', 0, '0000-00-00 00:00:00', 1, 2, 10, 1, '10', '5000', 0, 0, '0'),
(5, 'product10', 'product10', 'product10', 9, 0, '10.00000', '10.00', 'no_image.jpg', '10', 36, '2017-09-06 13:11:03', 0, '0000-00-00 00:00:00', 1, 1, 10, 1, '10', '10', 0, 0, '0'),
(6, 'Product11', 'Product11', 'Product11', 20, 2, '10.00000', '20.00', 'no_image.jpg', '10', 36, '2017-09-06 13:15:49', 0, '0000-00-00 00:00:00', 1, 2, 10, 1, '10', '10', 0, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `product_code_numbering`
--

CREATE TABLE IF NOT EXISTS `product_code_numbering` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product_code_numbering`
--

INSERT INTO `product_code_numbering` (`id`, `user_id`, `created_date`, `auto_generate_code`, `change_daily`, `change_weekly`, `change_monthly`, `change_yearly`, `current_year`, `current_month`, `current_day`, `enter_starting_number`, `status`) VALUES
(2, '36', '2017-07-03 13:19:28', '1', '0', '1', '0', '0', '0', '0', '1', '1', '0'),
(3, '36', '2017-08-11 12:29:00', '1', '0', '1', '0', '0', '1', '1', '1', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pro_subcategory_gold`
--

CREATE TABLE IF NOT EXISTS `pro_subcategory_gold` (
  `pro_cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_` varchar(10) NOT NULL,
  `cate_date` date NOT NULL,
  `pro_cate_date_creation` date NOT NULL,
  PRIMARY KEY (`pro_cate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pumper_report`
--

CREATE TABLE IF NOT EXISTS `pumper_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_receipt_no` varchar(255) NOT NULL DEFAULT '',
  `pump_id_fk` int(11) NOT NULL,
  `pumper_id_fk` int(11) NOT NULL,
  `pumper_name` varchar(100) NOT NULL,
  `commission_amount` float NOT NULL,
  `pump_fuel` decimal(13,4) NOT NULL,
  `fuel_type` int(11) NOT NULL COMMENT 'product id',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `orderDatetime` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `commission_type` varchar(25) NOT NULL,
  `commission_rate` varchar(255) NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `outlet_name` varchar(100) NOT NULL,
  `sale_amount` varchar(255) NOT NULL,
  `product_name` varchar(499) NOT NULL,
  `customer_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pumper_report`
--

INSERT INTO `pumper_report` (`id`, `settlement_receipt_no`, `pump_id_fk`, `pumper_id_fk`, `pumper_name`, `commission_amount`, `pump_fuel`, `fuel_type`, `status`, `orderDatetime`, `created_by`, `commission_type`, `commission_rate`, `outlet_id`, `outlet_name`, `sale_amount`, `product_name`, `customer_id`) VALUES
(1, '5', 1, 1, 'Operators1', 0, '10.0000', 3, 0, '2017-09-04 16:17:56', 36, 'fixed', '0', 1, 'Outlet1', '200', 'Product3', 1),
(2, '5', 2, 1, 'Operators1', 0, '5.0000', 2, 0, '2017-09-04 16:17:56', 36, 'fixed', '0', 1, 'Outlet1', '150', 'Product2', 1),
(3, '8', 1, 1, 'Operators1', 0, '10.0000', 3, 0, '2017-09-04 16:36:59', 36, 'fixed', '0', 1, 'Outlet1', '200', 'Product3', 0),
(4, '9', 1, 1, 'Operators1', 0, '1.0000', 3, 0, '2017-09-04 16:40:08', 36, 'fixed', '0', 1, 'Outlet1', '20', 'Product3', 0),
(5, '11', 1, 1, 'Operators1', 0, '3.0000', 3, 0, '2017-09-04 18:30:20', 36, 'fixed', '0', 1, 'Outlet1', '60', 'Product3', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pumps`
--

CREATE TABLE IF NOT EXISTS `pumps` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pumps`
--

INSERT INTO `pumps` (`id`, `pump_name`, `outlet_id`, `fuel_type`, `installation_date`, `pump_no`, `image_link`, `storage_tank`, `starting_meter`, `last_meter_reading`, `temp_meter_reading`, `pid`, `fuel_tank_ids`, `qty`, `checkk`, `testing`) VALUES
(1, 'Pump1', 1, '', '2017-09-12', 'Pump1', '', NULL, '0.0000', '472.0000', '472.0000', 3, '3', '', 1, '1'),
(2, 'Pump2', 1, '', '2017-09-19', 'Pump2', '', NULL, '0.0000', '186.0000', '186.0000', 2, '2', '', 1, '1'),
(3, 'Pump3', 1, '', '2017-08-29', 'Pump3', '', NULL, '0.0000', '65112.0000', '65112.0000', 1, '1', '', 1, '1');

-- --------------------------------------------------------

--
-- Table structure for table `pump_operators`
--

CREATE TABLE IF NOT EXISTS `pump_operators` (
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
  `commission_ap` varchar(255) NOT NULL,
  `short_amount` int(11) NOT NULL,
  `excess_amount` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pump_operators`
--

INSERT INTO `pump_operators` (`id`, `outlet_id`, `pump_id`, `operator_name`, `operator_cnic`, `operator_address`, `operator_dob`, `operator_telephone_number`, `operator_mobile_number`, `assigned_pump_id`, `status`, `commission_type`, `commission_ap`, `short_amount`, `excess_amount`) VALUES
(1, '1', '', 'Operators1', 'indain', 'Operators1', '2017-09-18', '9979133538', '9979133538', 0, 1, 'fixed', '0', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `pump_reading`
--

CREATE TABLE IF NOT EXISTS `pump_reading` (
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
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Active , 1: Inactive,2: Tempory',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `pump_reading`
--

INSERT INTO `pump_reading` (`id`, `settlement_id`, `outlet_id`, `pump_id`, `product_id`, `start_meter`, `end_meter`, `sold_qty`, `testing_qty`, `amount`, `created_at`, `status`) VALUES
(1, '1', '1', '2', '2', '150.0000', '160', '10', '0', '300', '2017-09-04 15:52:31', '0'),
(2, '1', '1', '1', '3', '390.0000', '400', '10', '0', '200', '2017-09-04 15:52:31', '0'),
(3, '2', '1', '3', '1', '65090.0000', '65100', '10', '0', '200', '2017-09-04 16:01:09', '0'),
(4, '2', '1', '1', '3', '400', '405', '5', '0', '100', '2017-09-04 16:01:09', '0'),
(5, '3', '1', '1', '3', '405', '410', '5', '0', '100', '2017-09-04 16:03:15', '0'),
(6, '4', '1', '3', '1', '65100', '65110', '10', '0', '200', '2017-09-04 16:16:29', '0'),
(7, '4', '1', '2', '2', '160', '165', '5', '0', '150', '2017-09-04 16:16:29', '0'),
(8, '4', '1', '1', '3', '405', '410', '5', '0', '100', '2017-09-04 16:16:29', '0'),
(9, '5', '1', '1', '3', '410', '420', '10', '0', '200', '2017-09-04 16:17:56', '0'),
(10, '5', '1', '2', '2', '165', '170', '5', '0', '150.00', '2017-09-04 16:17:56', '0'),
(11, '6', '1', '1', '3', '420', '430', '10', '0', '200', '2017-09-04 16:27:00', '0'),
(12, '6', '1', '2', '2', '170', '180', '10', '0', '300', '2017-09-04 16:27:00', '0'),
(13, '6', '1', '3', '1', '65110', '65111', '1', '0', '20', '2017-09-04 16:27:00', '0'),
(14, '7', '1', '1', '3', '430', '440', '10', '0', '200', '2017-09-04 16:29:42', '0'),
(15, '8', '1', '1', '3', '440', '450', '10', '0', '200', '2017-09-04 16:36:59', '0'),
(16, '9', '1', '1', '3', '450', '451', '1', '0', '20', '2017-09-04 16:40:08', '0'),
(17, '10', '1', '1', '3', '451', '452', '1', '0', '20.00', '2017-09-04 16:40:43', '0'),
(18, '11', '1', '1', '3', '452', '455', '3', '0', '60.00', '2017-09-04 18:30:19', '0'),
(19, '12', '1', '3', '1', '65111', '65112', '1', '0', '20.00', '2017-09-06 13:03:23', '0'),
(20, '12', '1', '2', '2', '180', '185', '5', '0', '150', '2017-09-06 13:03:23', '0'),
(21, '12', '1', '1', '3', '455', '460', '5', '0', '100', '2017-09-06 13:03:23', '0'),
(22, '13', '1', '1', '3', '460', '470', '10', '0', '200.00', '2017-09-06 13:04:16', '0'),
(23, '14', '1', '2', '2', '185', '186', '1', '0', '30.00', '2017-09-06 13:38:30', '0'),
(24, '15', '1', '1', '3', '470', '471', '1', '0', '20', '2017-09-06 13:56:19', '0'),
(25, '16', '1', '1', '3', '471', '472', '1', '0', '20.00', '2017-09-06 13:57:07', '0');

-- --------------------------------------------------------

--
-- Table structure for table `pump_testing`
--

CREATE TABLE IF NOT EXISTS `pump_testing` (
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
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Active , 1: Inactive,2: temporary',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_bills`
--

CREATE TABLE IF NOT EXISTS `purchase_bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `grandtotal` varchar(255) NOT NULL,
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
  `paid_amt` varchar(255) NOT NULL,
  `paid_date` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order`
--

CREATE TABLE IF NOT EXISTS `purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_number` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `purchase_bill_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `total_items` int(11) NOT NULL,
  `discount_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_percentage` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `subTotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grandTotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
  `paid_amt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `return_change` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_items`
--

CREATE TABLE IF NOT EXISTS `purchase_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` int(11) NOT NULL,
  `inventory_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `ordered_qty` int(11) NOT NULL,
  `bonusqty` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `bill_no` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `received_qty` int(11) NOT NULL,
  `cost` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_percentage` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `subTotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `partail_qty` int(11) NOT NULL DEFAULT '0',
  `warehouse_tank_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `warehouse_tank_status_partial` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_status`
--

CREATE TABLE IF NOT EXISTS `purchase_order_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `purchase_order_status`
--

INSERT INTO `purchase_order_status` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(1, 'Created', 1, '2016-09-10 00:00:00', 0, '0000-00-00 00:00:00', 1),
(2, 'Sent To Supplier', 1, '2016-09-10 00:00:00', 0, '0000-00-00 00:00:00', 1),
(3, 'Received From Supplier', 1, '2016-09-10 00:00:00', 0, '0000-00-00 00:00:00', 1),
(4, 'Pending', 1, '2017-04-29 00:00:00', 0, '0000-00-00 00:00:00', 1),
(5, 'Raised', 1, '2017-04-29 00:00:00', 0, '0000-00-00 00:00:00', 1),
(6, 'Received', 1, '2017-04-29 00:00:00', 0, '0000-00-00 00:00:00', 1),
(7, 'Archived', 1, '2017-04-29 00:00:00', 0, '0000-00-00 00:00:00', 1),
(8, 'Partial', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_received`
--

CREATE TABLE IF NOT EXISTS `purchase_received` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_id` varchar(255) NOT NULL DEFAULT '',
  `purchase_item_id` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `tank_qty` varchar(255) NOT NULL DEFAULT '0',
  `tank_id` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Warehouse, 1: Fuel',
  `inventory_id` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `purchase_received`
--

INSERT INTO `purchase_received` (`id`, `purchase_id`, `purchase_item_id`, `outlet_id`, `tank_qty`, `tank_id`, `type`, `inventory_id`, `created_at`) VALUES
(1, '1', '1', '1', '20', '1', '1', '1', '2017-09-06 09:53:59'),
(2, '1', '2', '1', '20', '1', '1', '1', '2017-09-06 09:53:59'),
(3, '2', '3', '1', '10', '1', '0', '4', '2017-09-06 09:57:04'),
(4, '2', '3', '1', '5', '2', '0', '5', '2017-09-06 09:57:04'),
(5, '2', '3', '1', '5', '3', '0', '6', '2017-09-06 09:57:04'),
(6, '3', '4', '1', '20', '2', '1', '2', '2017-09-06 09:59:19'),
(7, '3', '5', '1', '30', '1', '0', '4', '2017-09-06 09:59:19'),
(8, '4', '6', '1', '30', '1', '0', '7', '2017-09-06 15:00:37'),
(9, '4', '7', '1', '20', '3', '1', '3', '2017-09-06 15:00:37'),
(10, '5', '8', '1', '20', '1', '1', '1', '2017-09-06 15:55:21'),
(11, '5', '9', '1', '50', '1', '1', '1', '2017-09-06 15:55:21'),
(12, '6', '10', '1', '25', '4', '1', '11', '2017-09-08 10:10:22'),
(13, '7', '11', '1', '500', '4', '1', '11', '2017-09-08 10:13:23');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return`
--

CREATE TABLE IF NOT EXISTS `purchase_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `warehouse_tank` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '0: warehouse , 1:tank',
  `batch_expiry_id` varchar(255) NOT NULL DEFAULT '',
  `returned_qty` varchar(255) NOT NULL DEFAULT '0',
  `ref_bill_no` varchar(255) NOT NULL DEFAULT '',
  `supplier_id` varchar(255) NOT NULL DEFAULT '',
  `product_code` varchar(255) NOT NULL DEFAULT '',
  `refund_amount` varchar(255) NOT NULL DEFAULT '0',
  `payment_type` varchar(255) NOT NULL DEFAULT '',
  `refund_tax` varchar(255) NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  `cheque_number` varchar(255) NOT NULL DEFAULT '',
  `cheque_date` date NOT NULL,
  `bank` varchar(255) NOT NULL DEFAULT '',
  `card_number` varchar(255) NOT NULL DEFAULT '',
  `Gift_Card` varchar(255) NOT NULL DEFAULT '',
  `voucher_number` varchar(255) NOT NULL DEFAULT '',
  `created_by` varchar(255) NOT NULL DEFAULT '',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_taxes`
--

CREATE TABLE IF NOT EXISTS `purchase_taxes` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `redeem`
--

CREATE TABLE IF NOT EXISTS `redeem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `staff_redeem` int(11) DEFAULT '0',
  `customer_redeem` int(11) DEFAULT '0',
  `datee` varchar(20) NOT NULL,
  `Created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `refined_job_order`
--

CREATE TABLE IF NOT EXISTS `refined_job_order` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `refined_job_received_note`
--

CREATE TABLE IF NOT EXISTS `refined_job_received_note` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE IF NOT EXISTS `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=123 ;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `pid`, `name`, `title`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES
(1, 0, 'appointments', ' Appointments', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00'),
(2, 1, 'add_appointment', 'Add Appointment', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(3, 1, 'list_appointment', 'Manage Appointments', 36, '2017-08-23 15:03:50', 0, '0000-00-00 00:00:00'),
(4, 0, 'purchase_order', 'Purchase Module', 36, '2017-08-23 15:04:17', 0, '0000-00-00 00:00:00'),
(5, 4, 'po_view', 'Purchases', 36, '2017-08-23 15:04:45', 0, '0000-00-00 00:00:00'),
(6, 4, 'suppliers', 'Suppliers', 36, '2017-08-23 15:05:09', 0, '0000-00-00 00:00:00'),
(7, 4, 'pay_suppliers', 'Pay Suppliers', 36, '2017-08-23 15:05:28', 0, '0000-00-00 00:00:00'),
(8, 4, 'purchase_return', 'Purchase Return', 36, '2017-08-23 15:05:46', 0, '0000-00-00 00:00:00'),
(9, 4, 'purchase_bills', 'Purchase Bills', 36, '2017-08-23 15:06:08', 0, '0000-00-00 00:00:00'),
(10, 4, 'purchase_bonus', 'Purchase Bonus', 36, '2017-08-23 15:06:27', 0, '0000-00-00 00:00:00'),
(11, 0, 'sales', ' Sales Module', 36, '2017-08-23 15:07:37', 0, '0000-00-00 00:00:00'),
(12, 11, 'view', 'sales', 36, '2017-08-23 15:09:47', 0, '0000-00-00 00:00:00'),
(13, 0, 'customers', 'Customers Module', 36, '2017-08-23 15:27:16', 0, '0000-00-00 00:00:00'),
(14, 13, 'view', 'Customers', 36, '2017-08-23 15:29:06', 0, '0000-00-00 00:00:00'),
(15, 0, 'debit', 'Debit Module', 36, '2017-08-23 15:32:45', 0, '0000-00-00 00:00:00'),
(16, 15, 'view', 'Credit Sales', 36, '2017-08-23 15:33:03', 0, '0000-00-00 00:00:00'),
(17, 11, 'list_sales', 'Today Sales', 36, '2017-08-23 15:33:39', 0, '0000-00-00 00:00:00'),
(18, 11, 'opened_bill', 'Opened Bill', 36, '2017-08-23 15:34:02', 0, '0000-00-00 00:00:00'),
(19, 11, 'pos', 'POS', 36, '2017-08-23 15:34:34', 0, '0000-00-00 00:00:00'),
(20, 11, 'settlement', 'Settelment', 36, '2017-08-23 15:34:54', 0, '0000-00-00 00:00:00'),
(21, 0, 'returnorder', 'Sales Return Module', 36, '2017-08-23 15:43:28', 0, '0000-00-00 00:00:00'),
(22, 21, 'create_return', 'Create Sales Return', 36, '2017-08-23 15:43:55', 0, '0000-00-00 00:00:00'),
(23, 21, 'return_report', 'Sales Return Receipt', 36, '2017-08-23 15:44:16', 0, '0000-00-00 00:00:00'),
(24, 0, 'store', 'Warehouse Module', 36, '2017-08-23 15:46:16', 0, '0000-00-00 00:00:00'),
(25, 0, 'gold', 'Gold Module', 36, '2017-08-23 15:57:39', 0, '0000-00-00 00:00:00'),
(26, 24, 'warehouse_list', 'List Warehouses', 36, '2017-08-23 15:58:24', 0, '0000-00-00 00:00:00'),
(27, 24, 'assign_store', 'Assign Warehouse', 36, '2017-08-23 16:34:05', 0, '0000-00-00 00:00:00'),
(28, 24, 'warehouse_stocks', 'Warehouse Stocks', 36, '2017-08-23 16:34:25', 0, '0000-00-00 00:00:00'),
(29, 24, 'transfer_stocks', 'Transfer Stocks', 36, '2017-08-23 16:34:45', 0, '0000-00-00 00:00:00'),
(30, 25, 'addgrade', 'Add Gold-Grade', 36, '2017-08-23 16:35:36', 0, '0000-00-00 00:00:00'),
(31, 25, 'Gold_gold_prices', 'Gold Grade & Prices', 36, '2017-08-23 16:35:56', 0, '0000-00-00 00:00:00'),
(32, 25, 'order_estimate', ' Order Estimate', 36, '2017-08-23 16:36:31', 0, '0000-00-00 00:00:00'),
(33, 25, 'Goldsmith', 'Goldsmith', 36, '2017-08-23 16:38:45', 0, '0000-00-00 00:00:00'),
(34, 25, 'view_transfer', 'Transfer', 36, '2017-08-23 16:39:06', 0, '0000-00-00 00:00:00'),
(35, 25, 'list_store_transfer', 'View Store Record', 36, '2017-08-23 16:39:22', 0, '0000-00-00 00:00:00'),
(36, 25, 'list_order_estimate', 'List Order Estimate', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(37, 25, 'Gold_gradeview', 'Gold Grade List', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(38, 0, 'refine_gold', 'Refined Gold Module', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(39, 38, 'refine_order_list', 'Refine Order List', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(40, 38, 'add_refine_order', 'Add Refine Order', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(41, 38, 'add_refined_receive_note', 'Add Refined Receieved Note', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(42, 38, 'refined_gold', 'Refined Gold List', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(43, 0, 'productions', 'Production Module', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(44, 43, 'all_production', 'Production', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(45, 43, 'list_goldsmith_wastage', 'Goldsmith Wastage', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(46, 0, 'bakery_sales', 'Bakery Module', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(47, 46, 'bakerySales', 'Bakery Sales', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(48, 46, 'issue_sale_report', 'Issue Sales Report', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(49, 0, 'pumps', 'Pumps Module', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(50, 49, 'index', 'List Pumps', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(51, 49, 'list_operators', 'List Pump Operators', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(52, 49, 'list_ft', 'List Fuel Tanks', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(53, 49, 'pumpSales', 'Pump Comm & Shortage', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(54, 49, 'settlement_pump', 'Settlement', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(55, 49, 'settlement_list', 'Settlement List', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(56, 49, 'escTax', 'Esc Tax', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(57, 49, 'pumperreport', 'Pump Operator Reports', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(58, 49, 'fuelsalereport', 'Fuel Sale Reports', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(59, 49, 'dipreport', 'Dip Reports', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(60, 49, 'daily_collection', 'Daily Collection', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(61, 49, 'pump_reading', 'Pump Reading', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(62, 49, 'testing_detail', 'Testing Detail', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(63, 49, 'meter_resetting', 'Meter Resetting', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(64, 0, 'loan', 'Loan Module', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(65, 64, 'loan_list', 'Loan List', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(66, 64, 'settle_loan', 'Settle Loan', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(67, 0, 'inventory', 'Inventory Module', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(68, 67, 'view', 'Inventory', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(69, 0, 'products', 'Products Module', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(70, 69, 'list_products', 'List Products', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(71, 69, 'product_category', 'Product Category', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(72, 69, 'print_label', 'Print Product Label', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(73, 69, 'reorder_detail', 'Re Order Details', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(74, 0, 'brand', 'Brand Module', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(75, 74, 'view', 'Brand', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(76, 0, 'sub_category', 'Sub Category Module', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(77, 76, 'view', 'Sub Category', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(78, 0, 'bank_accounts', 'Banking Module ', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(79, 78, 'index', 'Bank Accounts', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(80, 0, 'bank_dt', 'Bank Deposit/Transfer Module', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(81, 80, 'index', 'Bank Deposit/Transfer', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(82, 78, 'balance', 'Account Balances', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(83, 0, 'receivedcheque', 'Received Cheque Module', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(84, 83, 'voucherdetail', 'Voucher Details', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(85, 0, 'cheque_manager', 'Cheque Manager Module', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(86, 0, 'gift_card', ' Gift Card Module', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(87, 86, 'add_gift_card', 'Add Gift Card', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(88, 86, 'list_gift_card', '  List Gift Card', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(89, 0, 'expenses', ' Expenses Module ', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(90, 89, 'view', 'Expenses', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(91, 89, 'expense_category', ' Expense Category', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(92, 0, 'reports', 'Reports Module', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(93, 92, 'sales_report', ' Product Sales Report', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(94, 92, 'product_report', ' Product Report', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(95, 92, 'product_category_report', 'Product Category Report', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(96, 92, 'sales_report_payement', 'Sales Report', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(97, 92, 'daily_summary_report', 'Daily Summary Report', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(98, 92, 'credit_sales_payment', ' Credit Sales Payments', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(99, 92, 'taxes', 'Taxes', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(100, 92, 'product_batch_expiry', ' Product Batch Expiry', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(101, 0, 'pnl', 'Profit & Loss Module', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(102, 101, 'view', 'P & L Graphs', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(103, 101, 'view_pnl_report', 'P & L Report', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(104, 0, 'setting', 'Setting Module', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(105, 104, 'outlets', 'Outlets', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(106, 104, 'users', 'Users', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(107, 104, 'staff', 'Staff', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(108, 104, 'permission', 'Permission', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(109, 104, 'payment_methods', ' Payment Methods', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(110, 104, 'bill_numbering', 'Bill Numbering', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(111, 104, 'product_code_numbering', ' Product Code Numbering', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(112, 104, 'add_new_page', ' Add New Page', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(113, 104, 'download_database', 'Download Database', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(114, 104, 'system_setting', 'System Setting', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00'),
(115, 0, 'dashboard', 'Dashboard', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(116, 49, 'deleted_settlement', 'Deleted Settlement', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(117, 49, 'fuel_reading', ':Fuel Meter Readings', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(118, 43, 'all_work_job_order', 'Work / Job Order', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(119, 43, 'producation_receive', 'Receive Production Module', 36, '2017-09-01 16:26:00', 0, '0000-00-00 00:00:00'),
(120, 4, 'purchase_direct', 'Purchase Direct', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(121, 11, 'credit_limits', 'Credit Limits', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(122, 43, 'receive_work_job_order', 'Receive Work / Job Order', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `return_items`
--

CREATE TABLE IF NOT EXISTS `return_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_category` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ow_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'warehouse/Tank',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '0: Warehouse, 1: Fuel',
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `discount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `item_condition` int(11) NOT NULL COMMENT '1: Good, 2: Not Good',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `rules`
--

CREATE TABLE IF NOT EXISTS `rules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `resource_id` int(11) NOT NULL,
  `allowed_type` enum('allow','deny') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'allow',
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=889 ;

--
-- Dumping data for table `rules`
--

INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES
(1, 1, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00'),
(2, 3, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00'),
(3, 6, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00'),
(4, 1, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(5, 3, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(6, 6, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(7, 1, 3, 'allow', 36, '2017-08-23 15:03:50', 0, '0000-00-00 00:00:00'),
(8, 3, 3, 'allow', 36, '2017-08-23 15:03:50', 0, '0000-00-00 00:00:00'),
(9, 4, 3, 'allow', 36, '2017-08-23 15:03:50', 0, '0000-00-00 00:00:00'),
(10, 1, 4, 'allow', 36, '2017-08-23 15:04:17', 0, '0000-00-00 00:00:00'),
(11, 3, 4, 'allow', 36, '2017-08-23 15:04:17', 0, '0000-00-00 00:00:00'),
(12, 6, 4, 'allow', 36, '2017-08-23 15:04:17', 0, '0000-00-00 00:00:00'),
(13, 7, 4, 'allow', 36, '2017-08-23 15:04:17', 0, '0000-00-00 00:00:00'),
(14, 1, 5, 'allow', 36, '2017-08-23 15:04:45', 0, '0000-00-00 00:00:00'),
(15, 2, 5, 'allow', 36, '2017-08-23 15:04:45', 0, '0000-00-00 00:00:00'),
(16, 3, 5, 'allow', 36, '2017-08-23 15:04:45', 0, '0000-00-00 00:00:00'),
(17, 4, 5, 'allow', 36, '2017-08-23 15:04:45', 0, '0000-00-00 00:00:00'),
(18, 1, 6, 'allow', 36, '2017-08-23 15:05:09', 0, '0000-00-00 00:00:00'),
(19, 3, 6, 'allow', 36, '2017-08-23 15:05:09', 0, '0000-00-00 00:00:00'),
(20, 4, 6, 'allow', 36, '2017-08-23 15:05:09', 0, '0000-00-00 00:00:00'),
(21, 1, 7, 'allow', 36, '2017-08-23 15:05:28', 0, '0000-00-00 00:00:00'),
(22, 3, 7, 'allow', 36, '2017-08-23 15:05:28', 0, '0000-00-00 00:00:00'),
(23, 4, 7, 'allow', 36, '2017-08-23 15:05:28', 0, '0000-00-00 00:00:00'),
(24, 1, 8, 'allow', 36, '2017-08-23 15:05:46', 0, '0000-00-00 00:00:00'),
(25, 2, 8, 'allow', 36, '2017-08-23 15:05:46', 0, '0000-00-00 00:00:00'),
(26, 4, 8, 'allow', 36, '2017-08-23 15:05:46', 0, '0000-00-00 00:00:00'),
(27, 1, 9, 'allow', 36, '2017-08-23 15:06:08', 0, '0000-00-00 00:00:00'),
(28, 3, 9, 'allow', 36, '2017-08-23 15:06:08', 0, '0000-00-00 00:00:00'),
(29, 6, 9, 'allow', 36, '2017-08-23 15:06:08', 0, '0000-00-00 00:00:00'),
(30, 1, 10, 'allow', 36, '2017-08-23 15:06:27', 0, '0000-00-00 00:00:00'),
(31, 2, 10, 'allow', 36, '2017-08-23 15:06:27', 0, '0000-00-00 00:00:00'),
(32, 4, 10, 'allow', 36, '2017-08-23 15:06:27', 0, '0000-00-00 00:00:00'),
(33, 6, 10, 'allow', 36, '2017-08-23 15:06:27', 0, '0000-00-00 00:00:00'),
(34, 1, 11, 'allow', 36, '2017-08-23 15:07:37', 0, '0000-00-00 00:00:00'),
(35, 3, 11, 'allow', 36, '2017-08-23 15:07:37', 0, '0000-00-00 00:00:00'),
(36, 4, 11, 'allow', 36, '2017-08-23 15:07:37', 0, '0000-00-00 00:00:00'),
(37, 6, 11, 'allow', 36, '2017-08-23 15:07:37', 0, '0000-00-00 00:00:00'),
(38, 1, 12, 'allow', 36, '2017-08-23 15:09:47', 0, '0000-00-00 00:00:00'),
(39, 4, 12, 'allow', 36, '2017-08-23 15:09:47', 0, '0000-00-00 00:00:00'),
(40, 6, 12, 'allow', 36, '2017-08-23 15:09:47', 0, '0000-00-00 00:00:00'),
(41, 1, 13, 'allow', 36, '2017-08-23 15:27:16', 0, '0000-00-00 00:00:00'),
(42, 4, 13, 'allow', 36, '2017-08-23 15:27:16', 0, '0000-00-00 00:00:00'),
(43, 7, 13, 'allow', 36, '2017-08-23 15:27:16', 0, '0000-00-00 00:00:00'),
(44, 1, 14, 'allow', 36, '2017-08-23 15:29:06', 0, '0000-00-00 00:00:00'),
(45, 3, 14, 'allow', 36, '2017-08-23 15:29:06', 0, '0000-00-00 00:00:00'),
(46, 6, 14, 'allow', 36, '2017-08-23 15:29:06', 0, '0000-00-00 00:00:00'),
(47, 7, 14, 'allow', 36, '2017-08-23 15:29:06', 0, '0000-00-00 00:00:00'),
(48, 1, 15, 'allow', 36, '2017-08-23 15:32:45', 0, '0000-00-00 00:00:00'),
(49, 3, 15, 'allow', 36, '2017-08-23 15:32:45', 0, '0000-00-00 00:00:00'),
(50, 6, 15, 'allow', 36, '2017-08-23 15:32:45', 0, '0000-00-00 00:00:00'),
(51, 1, 16, 'allow', 36, '2017-08-23 15:33:03', 0, '0000-00-00 00:00:00'),
(52, 3, 16, 'allow', 36, '2017-08-23 15:33:03', 0, '0000-00-00 00:00:00'),
(53, 4, 16, 'allow', 36, '2017-08-23 15:33:03', 0, '0000-00-00 00:00:00'),
(54, 6, 16, 'allow', 36, '2017-08-23 15:33:03', 0, '0000-00-00 00:00:00'),
(55, 1, 17, 'allow', 36, '2017-08-23 15:33:39', 0, '0000-00-00 00:00:00'),
(56, 3, 17, 'allow', 36, '2017-08-23 15:33:39', 0, '0000-00-00 00:00:00'),
(57, 4, 17, 'allow', 36, '2017-08-23 15:33:39', 0, '0000-00-00 00:00:00'),
(58, 6, 17, 'allow', 36, '2017-08-23 15:33:39', 0, '0000-00-00 00:00:00'),
(59, 7, 17, 'allow', 36, '2017-08-23 15:33:39', 0, '0000-00-00 00:00:00'),
(60, 1, 18, 'allow', 36, '2017-08-23 15:34:02', 0, '0000-00-00 00:00:00'),
(61, 3, 18, 'allow', 36, '2017-08-23 15:34:02', 0, '0000-00-00 00:00:00'),
(62, 4, 18, 'allow', 36, '2017-08-23 15:34:02', 0, '0000-00-00 00:00:00'),
(63, 1, 19, 'allow', 36, '2017-08-23 15:34:34', 0, '0000-00-00 00:00:00'),
(64, 2, 19, 'allow', 36, '2017-08-23 15:34:34', 0, '0000-00-00 00:00:00'),
(65, 4, 19, 'allow', 36, '2017-08-23 15:34:34', 0, '0000-00-00 00:00:00'),
(66, 6, 19, 'allow', 36, '2017-08-23 15:34:34', 0, '0000-00-00 00:00:00'),
(67, 1, 20, 'allow', 36, '2017-08-23 15:34:54', 0, '0000-00-00 00:00:00'),
(68, 3, 20, 'allow', 36, '2017-08-23 15:34:54', 0, '0000-00-00 00:00:00'),
(69, 4, 20, 'allow', 36, '2017-08-23 15:34:54', 0, '0000-00-00 00:00:00'),
(70, 6, 20, 'allow', 36, '2017-08-23 15:34:54', 0, '0000-00-00 00:00:00'),
(71, 7, 20, 'allow', 36, '2017-08-23 15:34:54', 0, '0000-00-00 00:00:00'),
(72, 1, 21, 'allow', 36, '2017-08-23 15:43:28', 0, '0000-00-00 00:00:00'),
(73, 4, 21, 'allow', 36, '2017-08-23 15:43:28', 0, '0000-00-00 00:00:00'),
(74, 6, 21, 'allow', 36, '2017-08-23 15:43:28', 0, '0000-00-00 00:00:00'),
(75, 7, 21, 'allow', 36, '2017-08-23 15:43:28', 0, '0000-00-00 00:00:00'),
(76, 1, 22, 'allow', 36, '2017-08-23 15:43:55', 0, '0000-00-00 00:00:00'),
(77, 3, 22, 'allow', 36, '2017-08-23 15:43:55', 0, '0000-00-00 00:00:00'),
(78, 4, 22, 'allow', 36, '2017-08-23 15:43:55', 0, '0000-00-00 00:00:00'),
(79, 6, 22, 'allow', 36, '2017-08-23 15:43:55', 0, '0000-00-00 00:00:00'),
(80, 1, 23, 'allow', 36, '2017-08-23 15:44:16', 0, '0000-00-00 00:00:00'),
(81, 3, 23, 'allow', 36, '2017-08-23 15:44:16', 0, '0000-00-00 00:00:00'),
(82, 4, 23, 'allow', 36, '2017-08-23 15:44:16', 0, '0000-00-00 00:00:00'),
(83, 6, 23, 'allow', 36, '2017-08-23 15:44:16', 0, '0000-00-00 00:00:00'),
(84, 1, 24, 'allow', 36, '2017-08-23 15:46:16', 0, '0000-00-00 00:00:00'),
(85, 3, 24, 'allow', 36, '2017-08-23 15:46:16', 0, '0000-00-00 00:00:00'),
(86, 6, 24, 'allow', 36, '2017-08-23 15:46:16', 0, '0000-00-00 00:00:00'),
(87, 7, 24, 'allow', 36, '2017-08-23 15:46:16', 0, '0000-00-00 00:00:00'),
(88, 1, 25, 'allow', 36, '2017-08-23 15:57:39', 0, '0000-00-00 00:00:00'),
(89, 3, 25, 'allow', 36, '2017-08-23 15:57:39', 0, '0000-00-00 00:00:00'),
(90, 6, 25, 'allow', 36, '2017-08-23 15:57:39', 0, '0000-00-00 00:00:00'),
(91, 1, 26, 'allow', 36, '2017-08-23 15:58:24', 0, '0000-00-00 00:00:00'),
(92, 3, 26, 'allow', 36, '2017-08-23 15:58:24', 0, '0000-00-00 00:00:00'),
(93, 6, 26, 'allow', 36, '2017-08-23 15:58:24', 0, '0000-00-00 00:00:00'),
(94, 1, 27, 'allow', 36, '2017-08-23 16:34:05', 0, '0000-00-00 00:00:00'),
(95, 2, 27, 'allow', 36, '2017-08-23 16:34:05', 0, '0000-00-00 00:00:00'),
(96, 3, 27, 'allow', 36, '2017-08-23 16:34:05', 0, '0000-00-00 00:00:00'),
(97, 4, 27, 'allow', 36, '2017-08-23 16:34:05', 0, '0000-00-00 00:00:00'),
(98, 1, 28, 'allow', 36, '2017-08-23 16:34:25', 0, '0000-00-00 00:00:00'),
(99, 2, 28, 'allow', 36, '2017-08-23 16:34:25', 0, '0000-00-00 00:00:00'),
(100, 6, 28, 'allow', 36, '2017-08-23 16:34:25', 0, '0000-00-00 00:00:00'),
(101, 1, 29, 'allow', 36, '2017-08-23 16:34:45', 0, '0000-00-00 00:00:00'),
(102, 2, 29, 'allow', 36, '2017-08-23 16:34:45', 0, '0000-00-00 00:00:00'),
(103, 4, 29, 'allow', 36, '2017-08-23 16:34:45', 0, '0000-00-00 00:00:00'),
(104, 7, 29, 'allow', 36, '2017-08-23 16:34:45', 0, '0000-00-00 00:00:00'),
(105, 1, 30, 'allow', 36, '2017-08-23 16:35:36', 0, '0000-00-00 00:00:00'),
(106, 3, 30, 'allow', 36, '2017-08-23 16:35:36', 0, '0000-00-00 00:00:00'),
(107, 4, 30, 'allow', 36, '2017-08-23 16:35:36', 0, '0000-00-00 00:00:00'),
(108, 1, 31, 'allow', 36, '2017-08-23 16:35:56', 0, '0000-00-00 00:00:00'),
(109, 4, 31, 'allow', 36, '2017-08-23 16:35:56', 0, '0000-00-00 00:00:00'),
(110, 6, 31, 'allow', 36, '2017-08-23 16:35:56', 0, '0000-00-00 00:00:00'),
(111, 1, 32, 'allow', 36, '2017-08-23 16:36:31', 0, '0000-00-00 00:00:00'),
(112, 4, 32, 'allow', 36, '2017-08-23 16:36:31', 0, '0000-00-00 00:00:00'),
(113, 7, 32, 'allow', 36, '2017-08-23 16:36:31', 0, '0000-00-00 00:00:00'),
(114, 1, 33, 'allow', 36, '2017-08-23 16:38:45', 0, '0000-00-00 00:00:00'),
(115, 3, 33, 'allow', 36, '2017-08-23 16:38:45', 0, '0000-00-00 00:00:00'),
(116, 6, 33, 'allow', 36, '2017-08-23 16:38:45', 0, '0000-00-00 00:00:00'),
(117, 1, 34, 'allow', 36, '2017-08-23 16:39:06', 0, '0000-00-00 00:00:00'),
(118, 3, 34, 'allow', 36, '2017-08-23 16:39:06', 0, '0000-00-00 00:00:00'),
(119, 4, 34, 'allow', 36, '2017-08-23 16:39:06', 0, '0000-00-00 00:00:00'),
(120, 1, 35, 'allow', 36, '2017-08-23 16:39:22', 0, '0000-00-00 00:00:00'),
(121, 3, 35, 'allow', 36, '2017-08-23 16:39:22', 0, '0000-00-00 00:00:00'),
(122, 6, 35, 'allow', 36, '2017-08-23 16:39:22', 0, '0000-00-00 00:00:00'),
(123, 1, 36, 'allow', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(124, 2, 36, 'allow', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(125, 3, 36, 'allow', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(126, 4, 36, 'allow', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(127, 6, 36, 'allow', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(128, 7, 36, 'allow', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(129, 8, 36, 'allow', 36, '2017-08-23 16:41:03', 0, '0000-00-00 00:00:00'),
(130, 1, 37, 'allow', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(131, 2, 37, 'allow', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(132, 3, 37, 'allow', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(133, 4, 37, 'allow', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(134, 6, 37, 'allow', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(135, 7, 37, 'allow', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(136, 8, 37, 'allow', 36, '2017-08-23 16:42:03', 0, '0000-00-00 00:00:00'),
(137, 1, 38, 'allow', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(138, 2, 38, 'allow', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(139, 3, 38, 'allow', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(140, 4, 38, 'allow', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(141, 6, 38, 'allow', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(142, 7, 38, 'allow', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(143, 8, 38, 'allow', 36, '2017-08-23 16:42:29', 0, '0000-00-00 00:00:00'),
(144, 1, 39, 'allow', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(145, 2, 39, 'allow', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(146, 3, 39, 'allow', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(147, 4, 39, 'allow', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(148, 6, 39, 'allow', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(149, 7, 39, 'allow', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(150, 8, 39, 'allow', 36, '2017-08-23 16:42:57', 0, '0000-00-00 00:00:00'),
(151, 1, 40, 'allow', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(152, 2, 40, 'allow', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(153, 3, 40, 'allow', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(154, 4, 40, 'allow', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(155, 6, 40, 'allow', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(156, 7, 40, 'allow', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(157, 8, 40, 'allow', 36, '2017-08-23 16:43:32', 0, '0000-00-00 00:00:00'),
(158, 1, 41, 'allow', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(159, 2, 41, 'allow', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(160, 3, 41, 'allow', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(161, 4, 41, 'allow', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(162, 6, 41, 'allow', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(163, 7, 41, 'allow', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(164, 8, 41, 'allow', 36, '2017-08-23 16:43:53', 0, '0000-00-00 00:00:00'),
(165, 1, 42, 'allow', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(166, 2, 42, 'allow', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(167, 3, 42, 'allow', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(168, 4, 42, 'allow', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(169, 6, 42, 'allow', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(170, 7, 42, 'allow', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(171, 8, 42, 'allow', 36, '2017-08-23 16:44:09', 0, '0000-00-00 00:00:00'),
(172, 1, 43, 'allow', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(173, 2, 43, 'allow', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(174, 3, 43, 'allow', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(175, 4, 43, 'allow', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(176, 6, 43, 'allow', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(177, 7, 43, 'allow', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(178, 8, 43, 'allow', 36, '2017-08-23 16:44:46', 0, '0000-00-00 00:00:00'),
(179, 1, 44, 'allow', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(180, 2, 44, 'allow', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(181, 3, 44, 'allow', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(182, 4, 44, 'allow', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(183, 6, 44, 'allow', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(184, 7, 44, 'allow', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(185, 8, 44, 'allow', 36, '2017-08-23 16:46:08', 0, '0000-00-00 00:00:00'),
(186, 1, 45, 'allow', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(187, 2, 45, 'allow', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(188, 3, 45, 'allow', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(189, 4, 45, 'allow', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(190, 6, 45, 'allow', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(191, 7, 45, 'allow', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(192, 8, 45, 'allow', 36, '2017-08-23 16:46:51', 0, '0000-00-00 00:00:00'),
(193, 1, 46, 'allow', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(194, 2, 46, 'allow', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(195, 3, 46, 'allow', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(196, 4, 46, 'allow', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(197, 6, 46, 'allow', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(198, 7, 46, 'allow', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(199, 8, 46, 'allow', 36, '2017-08-23 16:47:18', 0, '0000-00-00 00:00:00'),
(200, 1, 47, 'allow', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(201, 2, 47, 'allow', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(202, 3, 47, 'allow', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(203, 4, 47, 'allow', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(204, 6, 47, 'allow', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(205, 7, 47, 'allow', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(206, 8, 47, 'allow', 36, '2017-08-23 16:47:44', 0, '0000-00-00 00:00:00'),
(207, 1, 48, 'allow', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(208, 2, 48, 'allow', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(209, 3, 48, 'allow', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(210, 4, 48, 'allow', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(211, 6, 48, 'allow', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(212, 7, 48, 'allow', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(213, 8, 48, 'allow', 36, '2017-08-23 16:48:05', 0, '0000-00-00 00:00:00'),
(214, 1, 49, 'allow', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(215, 2, 49, 'allow', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(216, 3, 49, 'allow', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(217, 4, 49, 'allow', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(218, 6, 49, 'allow', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(219, 7, 49, 'allow', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(220, 8, 49, 'allow', 36, '2017-08-23 16:48:33', 0, '0000-00-00 00:00:00'),
(221, 1, 50, 'allow', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(222, 2, 50, 'allow', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(223, 3, 50, 'allow', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(224, 4, 50, 'allow', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(225, 6, 50, 'allow', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(226, 7, 50, 'allow', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(227, 8, 50, 'allow', 36, '2017-08-23 16:53:07', 0, '0000-00-00 00:00:00'),
(228, 1, 51, 'allow', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(229, 2, 51, 'allow', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(230, 3, 51, 'allow', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(231, 4, 51, 'allow', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(232, 6, 51, 'allow', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(233, 7, 51, 'allow', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(234, 8, 51, 'allow', 36, '2017-08-23 16:53:32', 0, '0000-00-00 00:00:00'),
(235, 1, 52, 'allow', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(236, 2, 52, 'allow', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(237, 3, 52, 'allow', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(238, 4, 52, 'allow', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(239, 6, 52, 'allow', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(240, 7, 52, 'allow', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(241, 8, 52, 'allow', 36, '2017-08-23 16:53:57', 0, '0000-00-00 00:00:00'),
(242, 1, 53, 'allow', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(243, 2, 53, 'allow', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(244, 3, 53, 'allow', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(245, 4, 53, 'allow', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(246, 6, 53, 'allow', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(247, 7, 53, 'allow', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(248, 8, 53, 'allow', 36, '2017-08-23 16:54:14', 0, '0000-00-00 00:00:00'),
(249, 1, 54, 'allow', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(250, 2, 54, 'allow', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(251, 3, 54, 'allow', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(252, 4, 54, 'allow', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(253, 6, 54, 'allow', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(254, 7, 54, 'allow', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(255, 8, 54, 'allow', 36, '2017-08-23 16:54:34', 0, '0000-00-00 00:00:00'),
(256, 1, 55, 'allow', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(257, 2, 55, 'allow', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(258, 3, 55, 'allow', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(259, 4, 55, 'allow', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(260, 6, 55, 'allow', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(261, 7, 55, 'allow', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(262, 8, 55, 'allow', 36, '2017-08-23 17:10:04', 0, '0000-00-00 00:00:00'),
(263, 1, 56, 'allow', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(264, 2, 56, 'allow', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(265, 3, 56, 'allow', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(266, 4, 56, 'allow', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(267, 6, 56, 'allow', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(268, 7, 56, 'allow', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(269, 8, 56, 'allow', 36, '2017-08-23 17:10:23', 0, '0000-00-00 00:00:00'),
(270, 1, 57, 'allow', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(271, 2, 57, 'allow', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(272, 3, 57, 'allow', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(273, 4, 57, 'allow', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(274, 6, 57, 'allow', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(275, 7, 57, 'allow', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(276, 8, 57, 'allow', 36, '2017-08-23 17:10:42', 0, '0000-00-00 00:00:00'),
(277, 1, 58, 'allow', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(278, 2, 58, 'allow', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(279, 3, 58, 'allow', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(280, 4, 58, 'allow', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(281, 6, 58, 'allow', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(282, 7, 58, 'allow', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(283, 8, 58, 'allow', 36, '2017-08-23 17:10:59', 0, '0000-00-00 00:00:00'),
(284, 1, 59, 'allow', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(285, 2, 59, 'allow', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(286, 3, 59, 'allow', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(287, 4, 59, 'allow', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(288, 6, 59, 'allow', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(289, 7, 59, 'allow', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(290, 8, 59, 'allow', 36, '2017-08-23 17:11:43', 0, '0000-00-00 00:00:00'),
(291, 1, 60, 'allow', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(292, 2, 60, 'allow', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(293, 3, 60, 'allow', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(294, 4, 60, 'allow', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(295, 6, 60, 'allow', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(296, 7, 60, 'allow', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(297, 8, 60, 'allow', 36, '2017-08-23 17:12:00', 0, '0000-00-00 00:00:00'),
(298, 1, 61, 'allow', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(299, 2, 61, 'allow', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(300, 3, 61, 'allow', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(301, 4, 61, 'allow', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(302, 6, 61, 'allow', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(303, 7, 61, 'allow', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(304, 8, 61, 'allow', 36, '2017-08-23 17:12:20', 0, '0000-00-00 00:00:00'),
(305, 1, 62, 'allow', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(306, 2, 62, 'allow', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(307, 3, 62, 'allow', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(308, 4, 62, 'allow', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(309, 6, 62, 'allow', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(310, 7, 62, 'allow', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(311, 8, 62, 'allow', 36, '2017-08-23 17:12:38', 0, '0000-00-00 00:00:00'),
(312, 1, 63, 'allow', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(313, 2, 63, 'allow', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(314, 3, 63, 'allow', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(315, 4, 63, 'allow', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(316, 6, 63, 'allow', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(317, 7, 63, 'allow', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(318, 8, 63, 'allow', 36, '2017-08-23 17:12:55', 0, '0000-00-00 00:00:00'),
(319, 1, 64, 'allow', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(320, 2, 64, 'allow', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(321, 3, 64, 'allow', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(322, 4, 64, 'allow', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(323, 6, 64, 'allow', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(324, 7, 64, 'allow', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(325, 8, 64, 'allow', 36, '2017-08-23 17:13:17', 0, '0000-00-00 00:00:00'),
(326, 1, 65, 'allow', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(327, 2, 65, 'allow', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(328, 3, 65, 'allow', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(329, 4, 65, 'allow', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(330, 6, 65, 'allow', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(331, 7, 65, 'allow', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(332, 8, 65, 'allow', 36, '2017-08-23 17:13:38', 0, '0000-00-00 00:00:00'),
(333, 1, 66, 'allow', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(334, 2, 66, 'allow', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(335, 3, 66, 'allow', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(336, 4, 66, 'allow', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(337, 6, 66, 'allow', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(338, 7, 66, 'allow', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(339, 8, 66, 'allow', 36, '2017-08-23 17:13:57', 0, '0000-00-00 00:00:00'),
(340, 1, 67, 'allow', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(341, 2, 67, 'allow', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(342, 3, 67, 'allow', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(343, 4, 67, 'allow', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(344, 6, 67, 'allow', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(345, 7, 67, 'allow', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(346, 8, 67, 'allow', 36, '2017-08-23 17:14:19', 0, '0000-00-00 00:00:00'),
(347, 1, 68, 'allow', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(348, 2, 68, 'allow', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(349, 3, 68, 'allow', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(350, 4, 68, 'allow', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(351, 6, 68, 'allow', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(352, 7, 68, 'allow', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(353, 8, 68, 'allow', 36, '2017-08-23 17:14:39', 0, '0000-00-00 00:00:00'),
(354, 1, 69, 'allow', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(355, 2, 69, 'allow', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(356, 3, 69, 'allow', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(357, 4, 69, 'allow', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(358, 6, 69, 'allow', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(359, 7, 69, 'allow', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(360, 8, 69, 'allow', 36, '2017-08-23 17:21:58', 0, '0000-00-00 00:00:00'),
(361, 1, 70, 'allow', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(362, 2, 70, 'allow', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(363, 3, 70, 'allow', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(364, 4, 70, 'allow', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(365, 6, 70, 'allow', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(366, 7, 70, 'allow', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(367, 8, 70, 'allow', 36, '2017-08-23 17:22:32', 0, '0000-00-00 00:00:00'),
(368, 1, 71, 'allow', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(369, 2, 71, 'allow', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(370, 3, 71, 'allow', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(371, 4, 71, 'allow', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(372, 6, 71, 'allow', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(373, 7, 71, 'allow', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(374, 8, 71, 'allow', 36, '2017-08-23 17:23:08', 0, '0000-00-00 00:00:00'),
(375, 1, 72, 'allow', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(376, 2, 72, 'allow', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(377, 3, 72, 'allow', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(378, 4, 72, 'allow', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(379, 6, 72, 'allow', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(380, 7, 72, 'allow', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(381, 8, 72, 'allow', 36, '2017-08-23 17:23:27', 0, '0000-00-00 00:00:00'),
(382, 1, 73, 'allow', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(383, 2, 73, 'allow', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(384, 3, 73, 'allow', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(385, 4, 73, 'allow', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(386, 6, 73, 'allow', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(387, 7, 73, 'allow', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(388, 8, 73, 'allow', 36, '2017-08-23 17:23:43', 0, '0000-00-00 00:00:00'),
(389, 1, 74, 'allow', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(390, 2, 74, 'allow', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(391, 3, 74, 'allow', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(392, 4, 74, 'allow', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(393, 6, 74, 'allow', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(394, 7, 74, 'allow', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(395, 8, 74, 'allow', 36, '2017-08-23 17:29:26', 0, '0000-00-00 00:00:00'),
(396, 1, 75, 'allow', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(397, 2, 75, 'allow', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(398, 3, 75, 'allow', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(399, 4, 75, 'allow', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(400, 6, 75, 'allow', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(401, 7, 75, 'allow', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(402, 8, 75, 'allow', 36, '2017-08-23 17:29:54', 0, '0000-00-00 00:00:00'),
(403, 1, 76, 'allow', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(404, 2, 76, 'allow', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(405, 3, 76, 'allow', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(406, 4, 76, 'allow', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(407, 6, 76, 'allow', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(408, 7, 76, 'allow', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(409, 8, 76, 'allow', 36, '2017-08-23 17:30:46', 0, '0000-00-00 00:00:00'),
(410, 1, 77, 'allow', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(411, 2, 77, 'allow', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(412, 3, 77, 'allow', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(413, 4, 77, 'allow', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(414, 6, 77, 'allow', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(415, 7, 77, 'allow', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(416, 8, 77, 'allow', 36, '2017-08-23 17:31:01', 0, '0000-00-00 00:00:00'),
(417, 1, 78, 'allow', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(418, 2, 78, 'allow', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(419, 3, 78, 'allow', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(420, 4, 78, 'allow', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(421, 6, 78, 'allow', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(422, 7, 78, 'allow', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(423, 8, 78, 'allow', 36, '2017-08-23 17:31:29', 0, '0000-00-00 00:00:00'),
(424, 1, 79, 'allow', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(425, 2, 79, 'allow', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(426, 3, 79, 'allow', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(427, 4, 79, 'allow', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(428, 6, 79, 'allow', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(429, 7, 79, 'allow', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(430, 8, 79, 'allow', 36, '2017-08-23 17:35:10', 0, '0000-00-00 00:00:00'),
(431, 1, 80, 'allow', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(432, 2, 80, 'allow', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(433, 3, 80, 'allow', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(434, 4, 80, 'allow', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(435, 6, 80, 'allow', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(436, 7, 80, 'allow', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(437, 8, 80, 'allow', 36, '2017-08-23 17:37:47', 0, '0000-00-00 00:00:00'),
(438, 1, 81, 'allow', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(439, 2, 81, 'allow', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(440, 3, 81, 'allow', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(441, 4, 81, 'allow', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(442, 6, 81, 'allow', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(443, 7, 81, 'allow', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(444, 8, 81, 'allow', 36, '2017-08-23 17:38:05', 0, '0000-00-00 00:00:00'),
(445, 1, 82, 'allow', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(446, 2, 82, 'allow', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(447, 3, 82, 'allow', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(448, 4, 82, 'allow', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(449, 6, 82, 'allow', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(450, 7, 82, 'allow', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(451, 8, 82, 'allow', 36, '2017-08-23 17:39:07', 0, '0000-00-00 00:00:00'),
(452, 1, 83, 'allow', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(453, 2, 83, 'allow', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(454, 3, 83, 'allow', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(455, 4, 83, 'allow', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(456, 6, 83, 'allow', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(457, 7, 83, 'allow', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(458, 8, 83, 'allow', 36, '2017-08-23 17:40:37', 0, '0000-00-00 00:00:00'),
(459, 1, 84, 'allow', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(460, 2, 84, 'allow', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(461, 3, 84, 'allow', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(462, 4, 84, 'allow', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(463, 6, 84, 'allow', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(464, 7, 84, 'allow', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(465, 8, 84, 'allow', 36, '2017-08-23 17:41:21', 0, '0000-00-00 00:00:00'),
(466, 1, 85, 'allow', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(467, 2, 85, 'allow', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(468, 3, 85, 'allow', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(469, 4, 85, 'allow', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(470, 6, 85, 'allow', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(471, 7, 85, 'allow', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(472, 8, 85, 'allow', 36, '2017-08-23 17:42:00', 0, '0000-00-00 00:00:00'),
(473, 1, 86, 'allow', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(474, 2, 86, 'allow', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(475, 3, 86, 'allow', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(476, 4, 86, 'allow', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(477, 6, 86, 'allow', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(478, 7, 86, 'allow', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(479, 8, 86, 'allow', 36, '2017-08-23 17:42:29', 0, '0000-00-00 00:00:00'),
(480, 1, 87, 'allow', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(481, 2, 87, 'allow', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(482, 3, 87, 'allow', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(483, 4, 87, 'allow', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(484, 6, 87, 'allow', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(485, 7, 87, 'allow', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(486, 8, 87, 'allow', 36, '2017-08-23 17:42:55', 0, '0000-00-00 00:00:00'),
(487, 1, 88, 'allow', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(488, 2, 88, 'allow', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(489, 3, 88, 'allow', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(490, 4, 88, 'allow', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(491, 6, 88, 'allow', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(492, 7, 88, 'allow', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(493, 8, 88, 'allow', 36, '2017-08-23 17:43:52', 0, '0000-00-00 00:00:00'),
(494, 1, 89, 'allow', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(495, 2, 89, 'allow', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(496, 3, 89, 'allow', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(497, 4, 89, 'allow', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(498, 6, 89, 'allow', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(499, 7, 89, 'allow', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(500, 8, 89, 'allow', 36, '2017-08-23 17:44:16', 0, '0000-00-00 00:00:00'),
(501, 1, 90, 'allow', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(502, 2, 90, 'allow', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(503, 3, 90, 'allow', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(504, 4, 90, 'allow', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(505, 6, 90, 'allow', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(506, 7, 90, 'allow', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(507, 8, 90, 'allow', 36, '2017-08-23 17:44:37', 0, '0000-00-00 00:00:00'),
(508, 1, 91, 'allow', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(509, 2, 91, 'allow', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(510, 3, 91, 'allow', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(511, 4, 91, 'allow', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(512, 6, 91, 'allow', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(513, 7, 91, 'allow', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(514, 8, 91, 'allow', 36, '2017-08-23 17:45:01', 0, '0000-00-00 00:00:00'),
(515, 1, 92, 'allow', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(516, 2, 92, 'allow', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(517, 3, 92, 'allow', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(518, 4, 92, 'allow', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(519, 6, 92, 'allow', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(520, 7, 92, 'allow', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(521, 8, 92, 'allow', 36, '2017-08-23 17:45:33', 0, '0000-00-00 00:00:00'),
(522, 1, 93, 'allow', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(523, 2, 93, 'allow', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(524, 3, 93, 'allow', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(525, 4, 93, 'allow', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(526, 6, 93, 'allow', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(527, 7, 93, 'allow', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(528, 8, 93, 'allow', 36, '2017-08-23 17:46:11', 0, '0000-00-00 00:00:00'),
(529, 1, 94, 'allow', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(530, 2, 94, 'allow', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(531, 3, 94, 'allow', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(532, 4, 94, 'allow', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(533, 6, 94, 'allow', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(534, 7, 94, 'allow', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(535, 8, 94, 'allow', 36, '2017-08-23 17:46:57', 0, '0000-00-00 00:00:00'),
(536, 1, 95, 'allow', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(537, 2, 95, 'allow', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(538, 3, 95, 'allow', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(539, 4, 95, 'allow', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(540, 6, 95, 'allow', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(541, 7, 95, 'allow', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(542, 8, 95, 'allow', 36, '2017-08-23 17:49:55', 0, '0000-00-00 00:00:00'),
(543, 1, 96, 'allow', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(544, 2, 96, 'allow', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(545, 3, 96, 'allow', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(546, 4, 96, 'allow', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(547, 6, 96, 'allow', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(548, 7, 96, 'allow', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(549, 8, 96, 'allow', 36, '2017-08-23 17:50:11', 0, '0000-00-00 00:00:00'),
(550, 1, 97, 'allow', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(551, 2, 97, 'allow', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(552, 3, 97, 'allow', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(553, 4, 97, 'allow', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(554, 6, 97, 'allow', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(555, 7, 97, 'allow', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(556, 8, 97, 'allow', 36, '2017-08-23 17:50:26', 0, '0000-00-00 00:00:00'),
(557, 1, 98, 'allow', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(558, 2, 98, 'allow', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(559, 3, 98, 'allow', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(560, 4, 98, 'allow', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(561, 6, 98, 'allow', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(562, 7, 98, 'allow', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(563, 8, 98, 'allow', 36, '2017-08-23 17:50:46', 0, '0000-00-00 00:00:00'),
(564, 1, 99, 'allow', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(565, 2, 99, 'allow', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(566, 3, 99, 'allow', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(567, 4, 99, 'allow', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(568, 6, 99, 'allow', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(569, 7, 99, 'allow', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(570, 8, 99, 'allow', 36, '2017-08-23 17:51:03', 0, '0000-00-00 00:00:00'),
(571, 1, 100, 'allow', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(572, 2, 100, 'allow', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(573, 3, 100, 'allow', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(574, 4, 100, 'allow', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(575, 6, 100, 'allow', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(576, 7, 100, 'allow', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(577, 8, 100, 'allow', 36, '2017-08-23 17:51:20', 0, '0000-00-00 00:00:00'),
(578, 1, 101, 'allow', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(579, 2, 101, 'allow', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(580, 3, 101, 'allow', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(581, 4, 101, 'allow', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(582, 6, 101, 'allow', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(583, 7, 101, 'allow', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(584, 8, 101, 'allow', 36, '2017-08-23 17:52:04', 0, '0000-00-00 00:00:00'),
(585, 1, 102, 'allow', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(586, 2, 102, 'allow', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(587, 3, 102, 'allow', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(588, 4, 102, 'allow', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(589, 6, 102, 'allow', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(590, 7, 102, 'allow', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(591, 8, 102, 'allow', 36, '2017-08-23 17:52:44', 0, '0000-00-00 00:00:00'),
(592, 1, 103, 'allow', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(593, 2, 103, 'allow', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(594, 3, 103, 'allow', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(595, 4, 103, 'allow', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(596, 6, 103, 'allow', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(597, 7, 103, 'allow', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(598, 8, 103, 'allow', 36, '2017-08-23 17:53:07', 0, '0000-00-00 00:00:00'),
(599, 1, 104, 'allow', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(600, 2, 104, 'allow', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(601, 3, 104, 'allow', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(602, 4, 104, 'allow', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(603, 6, 104, 'allow', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(604, 7, 104, 'allow', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(605, 8, 104, 'allow', 36, '2017-08-23 17:53:29', 0, '0000-00-00 00:00:00'),
(606, 1, 105, 'allow', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(607, 2, 105, 'allow', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(608, 3, 105, 'allow', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(609, 4, 105, 'allow', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(610, 6, 105, 'allow', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(611, 7, 105, 'allow', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(612, 8, 105, 'allow', 36, '2017-08-23 17:54:03', 0, '0000-00-00 00:00:00'),
(613, 1, 106, 'allow', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(614, 2, 106, 'allow', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(615, 3, 106, 'allow', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(616, 4, 106, 'allow', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(617, 6, 106, 'allow', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(618, 7, 106, 'allow', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(619, 8, 106, 'allow', 36, '2017-08-23 17:54:45', 0, '0000-00-00 00:00:00'),
(620, 1, 107, 'allow', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(621, 2, 107, 'allow', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(622, 3, 107, 'allow', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(623, 4, 107, 'allow', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(624, 6, 107, 'allow', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(625, 7, 107, 'allow', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(626, 8, 107, 'allow', 36, '2017-08-23 17:55:29', 0, '0000-00-00 00:00:00'),
(627, 1, 108, 'allow', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(628, 2, 108, 'allow', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(629, 3, 108, 'allow', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(630, 4, 108, 'allow', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(631, 6, 108, 'allow', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(632, 7, 108, 'allow', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(633, 8, 108, 'allow', 36, '2017-08-23 17:56:46', 0, '0000-00-00 00:00:00'),
(634, 1, 109, 'allow', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(635, 2, 109, 'allow', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(636, 3, 109, 'allow', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(637, 4, 109, 'allow', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(638, 6, 109, 'allow', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(639, 7, 109, 'allow', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(640, 8, 109, 'allow', 36, '2017-08-23 17:57:20', 0, '0000-00-00 00:00:00'),
(641, 1, 110, 'allow', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(642, 2, 110, 'allow', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(643, 3, 110, 'allow', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(644, 4, 110, 'allow', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(645, 6, 110, 'allow', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(646, 7, 110, 'allow', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(647, 8, 110, 'allow', 36, '2017-08-23 17:57:34', 0, '0000-00-00 00:00:00'),
(648, 1, 111, 'allow', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(649, 2, 111, 'allow', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(650, 3, 111, 'allow', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(651, 4, 111, 'allow', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(652, 6, 111, 'allow', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(653, 7, 111, 'allow', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(654, 8, 111, 'allow', 36, '2017-08-23 17:57:58', 0, '0000-00-00 00:00:00'),
(655, 1, 112, 'allow', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(656, 2, 112, 'allow', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(657, 3, 112, 'allow', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(658, 4, 112, 'allow', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(659, 6, 112, 'allow', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(660, 7, 112, 'allow', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(661, 8, 112, 'allow', 36, '2017-08-23 17:58:14', 0, '0000-00-00 00:00:00'),
(662, 1, 113, 'allow', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(663, 2, 113, 'allow', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(664, 3, 113, 'allow', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(665, 4, 113, 'allow', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(666, 6, 113, 'allow', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(667, 7, 113, 'allow', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(668, 8, 113, 'allow', 36, '2017-08-23 17:58:30', 0, '0000-00-00 00:00:00'),
(669, 1, 114, 'allow', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00'),
(670, 2, 114, 'allow', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00'),
(671, 3, 114, 'allow', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00'),
(672, 4, 114, 'allow', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00'),
(673, 6, 114, 'allow', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00'),
(674, 7, 114, 'allow', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00');
INSERT INTO `rules` (`id`, `role_id`, `resource_id`, `allowed_type`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES
(675, 8, 114, 'allow', 36, '2017-08-23 17:58:46', 0, '0000-00-00 00:00:00'),
(676, 1, 115, 'allow', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(677, 2, 115, 'allow', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(678, 3, 115, 'allow', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(679, 4, 115, 'allow', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(680, 6, 115, 'allow', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(681, 7, 115, 'allow', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(682, 8, 115, 'allow', 36, '2017-08-23 18:15:47', 0, '0000-00-00 00:00:00'),
(683, 2, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '2017-08-23 15:02:26'),
(684, 4, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '2017-08-23 15:02:26'),
(685, 0, 0, 'allow', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(686, 5, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00'),
(687, 7, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00'),
(688, 8, 1, 'allow', 36, '2017-08-23 15:02:26', 0, '0000-00-00 00:00:00'),
(689, 2, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(690, 4, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(691, 5, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(692, 7, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(693, 8, 2, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(694, 2, 3, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(695, 5, 3, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(696, 6, 3, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(697, 7, 3, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(698, 8, 3, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(699, 2, 4, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(700, 5, 4, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(701, 8, 4, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(702, 5, 5, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(703, 6, 5, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(704, 7, 5, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(705, 8, 5, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(706, 2, 6, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(707, 5, 6, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(708, 6, 6, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(709, 7, 6, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(710, 8, 6, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(711, 2, 7, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(712, 5, 7, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(713, 6, 7, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(714, 7, 7, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(715, 8, 7, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(716, 3, 8, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(717, 5, 8, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(718, 6, 8, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(719, 7, 8, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(720, 8, 8, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(721, 2, 9, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(722, 4, 9, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(723, 5, 9, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(724, 7, 9, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(725, 8, 9, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(726, 3, 10, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(727, 5, 10, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(728, 7, 10, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(729, 8, 10, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(730, 2, 11, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(731, 5, 11, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(732, 7, 11, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(733, 8, 11, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(734, 2, 12, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(735, 3, 12, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(736, 5, 12, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(737, 7, 12, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(738, 8, 12, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(739, 2, 13, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(740, 3, 13, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(741, 5, 13, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(742, 6, 13, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(743, 8, 13, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(744, 2, 14, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(745, 4, 14, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(746, 5, 14, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(747, 8, 14, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(748, 2, 15, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(749, 4, 15, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(750, 5, 15, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(751, 7, 15, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(752, 8, 15, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(753, 2, 16, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(754, 5, 16, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(755, 7, 16, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(756, 8, 16, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(757, 2, 17, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(758, 5, 17, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(759, 8, 17, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(760, 5, 18, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(761, 2, 18, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(762, 6, 18, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(763, 7, 18, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(764, 8, 18, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(765, 5, 19, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(766, 3, 19, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(767, 7, 19, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(768, 8, 19, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(769, 5, 20, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(770, 2, 20, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(771, 8, 20, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(772, 5, 21, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(773, 2, 21, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(774, 3, 21, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(775, 8, 21, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(776, 5, 22, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(777, 2, 22, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(778, 7, 22, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(779, 8, 22, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(780, 5, 23, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(781, 2, 23, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(782, 7, 23, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(783, 8, 23, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(784, 5, 24, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(785, 2, 24, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(786, 4, 24, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(787, 8, 24, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(788, 2, 25, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(789, 4, 25, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(790, 5, 25, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(791, 7, 25, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(792, 8, 25, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(793, 2, 26, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(794, 4, 26, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(795, 5, 26, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(796, 7, 26, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(797, 8, 26, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(798, 5, 27, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(799, 6, 27, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(800, 7, 27, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(801, 8, 27, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(802, 3, 28, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(803, 4, 28, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(804, 5, 28, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(805, 7, 28, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(806, 8, 28, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(807, 3, 29, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(808, 5, 29, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(809, 8, 29, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(810, 2, 30, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(811, 5, 30, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(812, 6, 30, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(813, 7, 30, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(814, 8, 30, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(815, 3, 31, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(816, 2, 31, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(817, 5, 31, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(818, 7, 31, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(819, 8, 31, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(820, 3, 32, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(821, 2, 32, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(822, 5, 32, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(823, 6, 32, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(824, 8, 32, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(825, 2, 33, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(826, 4, 33, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(827, 5, 33, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(828, 7, 33, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(829, 8, 33, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(830, 2, 34, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(831, 5, 34, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(832, 6, 34, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(833, 7, 34, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(834, 8, 34, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(835, 2, 35, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(836, 4, 35, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(837, 5, 35, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(838, 7, 35, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(839, 8, 35, 'allow', 36, '2017-08-23 15:03:03', 0, '0000-00-00 00:00:00'),
(840, 1, 116, 'allow', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(841, 2, 116, 'allow', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(842, 3, 116, 'allow', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(843, 4, 116, 'allow', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(844, 6, 116, 'allow', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(845, 7, 116, 'allow', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(846, 8, 116, 'allow', 36, '2017-08-25 09:46:58', 0, '0000-00-00 00:00:00'),
(847, 1, 117, 'allow', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(848, 2, 117, 'allow', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(849, 3, 117, 'allow', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(850, 4, 117, 'allow', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(851, 6, 117, 'allow', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(852, 7, 117, 'allow', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(853, 8, 117, 'allow', 36, '2017-08-26 16:23:04', 0, '0000-00-00 00:00:00'),
(854, 1, 118, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(855, 2, 118, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(856, 3, 118, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(857, 4, 118, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(858, 6, 118, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(859, 7, 118, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(860, 8, 118, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(861, 1, 119, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(862, 2, 119, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(863, 3, 119, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(864, 4, 119, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(865, 6, 119, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(866, 7, 119, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(867, 8, 119, 'allow', 36, '2017-09-01 10:25:14', 0, '0000-00-00 00:00:00'),
(868, 1, 120, 'allow', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(869, 2, 120, 'allow', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(870, 3, 120, 'allow', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(871, 4, 120, 'allow', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(872, 6, 120, 'allow', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(873, 7, 120, 'allow', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(874, 8, 120, 'allow', 36, '2017-09-01 17:32:20', 0, '0000-00-00 00:00:00'),
(875, 1, 121, 'allow', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(876, 2, 121, 'allow', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(877, 3, 121, 'allow', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(878, 4, 121, 'allow', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(879, 6, 121, 'allow', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(880, 7, 121, 'allow', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(881, 8, 121, 'allow', 36, '2017-09-06 10:06:40', 0, '0000-00-00 00:00:00'),
(882, 1, 122, 'allow', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00'),
(883, 2, 122, 'allow', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00'),
(884, 3, 122, 'allow', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00'),
(885, 4, 122, 'allow', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00'),
(886, 6, 122, 'allow', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00'),
(887, 7, 122, 'allow', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00'),
(888, 8, 122, 'allow', 36, '2017-09-06 12:10:09', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sales_return`
--

CREATE TABLE IF NOT EXISTS `sales_return` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `returned_qty` varchar(255) NOT NULL DEFAULT '0',
  `ref_bill_no` varchar(255) NOT NULL DEFAULT '',
  `refund_tax` varchar(255) NOT NULL DEFAULT '',
  `total_discount_amount` varchar(255) NOT NULL DEFAULT '0',
  `total_discount_percent` varchar(255) NOT NULL DEFAULT '0',
  `subtotal` varchar(255) NOT NULL DEFAULT '0',
  `grandtotal` varchar(255) NOT NULL DEFAULT '0',
  `refund_amount` varchar(255) NOT NULL DEFAULT '0',
  `payment_method` varchar(255) NOT NULL DEFAULT '',
  `refund_method` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Full_Refund, 1:Partial_Refund',
  `condition` varchar(255) NOT NULL DEFAULT '0' COMMENT '0:good, 1: not_good',
  `status` varchar(255) NOT NULL DEFAULT '0',
  `remark` text NOT NULL,
  `created_by` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `settlement`
--

CREATE TABLE IF NOT EXISTS `settlement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_no` varchar(255) NOT NULL DEFAULT '',
  `outlet_id` varchar(255) NOT NULL DEFAULT '',
  `pumper_id` varchar(255) NOT NULL,
  `note` text NOT NULL,
  `total_amount` varchar(25) NOT NULL DEFAULT '0',
  `shift_start_time` varchar(255) NOT NULL DEFAULT '',
  `shift_end_time` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Active , 1: Inactive,2: temporary',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `settlement`
--

INSERT INTO `settlement` (`id`, `settlement_no`, `outlet_id`, `pumper_id`, `note`, `total_amount`, `shift_start_time`, `shift_end_time`, `created_at`, `status`) VALUES
(1, '1', '1', '', '', '940.00', '', '', '2017-09-04 15:52:31', '0'),
(2, '2', '1', '', 'undefined', '300.00', 'undefined', 'undefined', '2017-09-04 16:01:09', '0'),
(3, '3', '1', '', 'undefined', '100.00', 'undefined', 'undefined', '2017-09-04 16:03:15', '0'),
(4, '4', '1', '', '', '450.00', '4 : 02 PM', '4 : 02 PM', '2017-09-04 16:16:29', '0'),
(5, '5', '1', '1', '', '1230.00', '4 : 16 PM', '4 : 16 PM', '2017-09-04 16:17:56', '0'),
(6, '6', '1', '', '', '1180.00', '4 : 19 PM', '4 : 19 PM', '2017-09-04 16:27:00', '0'),
(7, '7', '1', '', '', '200.00', '4 : 28 PM', '4 : 28 PM', '2017-09-04 16:29:42', '0'),
(8, '8', '1', '1', '', '640.00', '4 : 35 PM', '4 : 35 PM', '2017-09-04 16:36:59', '0'),
(9, '9', '1', '1', '', '20.00', '4 : 37 PM', '4 : 37 PM', '2017-09-04 16:40:08', '0'),
(10, '10', '1', '', '', '460.00', '4 : 40 PM', '4 : 40 PM', '2017-09-04 16:40:43', '0'),
(11, '11', '1', '1', '', '60.00', '6 : 28 PM', '6 : 28 PM', '2017-09-04 18:30:19', '0'),
(12, '12', '1', '', '', '270.00', '1 : 00 PM', '1 : 00 PM', '2017-09-06 13:03:23', '0'),
(13, '13', '1', '', '', '200.00', '1 : 03 PM', '1 : 03 PM', '2017-09-06 13:04:16', '0'),
(14, '14', '1', '', '', '30.00', '1 : 35 PM', '1 : 35 PM', '2017-09-06 13:38:30', '0'),
(15, '15', '1', '', '', '31.00', '1 : 38 PM', '1 : 38 PM', '2017-09-06 13:56:19', '0'),
(16, '16', '1', '', '', '64.00', '1 : 56 PM', '1 : 56 PM', '2017-09-06 13:57:07', '0'),
(17, '17', '1', '', '', '7628.06', '4 : 04 PM', '4 : 04 PM', '2017-09-06 16:27:17', '0'),
(18, '18', '1', '', '', '1694.00', '4 : 28 PM', '4 : 28 PM', '2017-09-06 16:46:03', '0'),
(19, '19', '1', '', '', '4950.00', '4 : 46 PM', '4 : 46 PM', '2017-09-06 18:03:37', '0');

-- --------------------------------------------------------

--
-- Table structure for table `site_setting`
--

CREATE TABLE IF NOT EXISTS `site_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `site_logo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `pagination` int(11) NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `datetime_format` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `display_product` int(11) NOT NULL,
  `display_keyboard` int(11) NOT NULL,
  `default_customer_id` int(11) NOT NULL,
  `default_store_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `new_settings` text COLLATE utf8_unicode_ci NOT NULL,
  `pre_print_invoice` int(1) NOT NULL,
  `email_method` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `defult_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_account` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_incoming_mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_outgoing_mail` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_username` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `smtp_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `site_setting`
--

INSERT INTO `site_setting` (`id`, `site_name`, `site_logo`, `timezone`, `pagination`, `tax`, `currency`, `datetime_format`, `display_product`, `display_keyboard`, `default_customer_id`, `default_store_id`, `updated_user_id`, `updated_datetime`, `new_settings`, `pre_print_invoice`, `email_method`, `defult_email`, `smtp_name`, `smtp_email`, `smtp_account`, `smtp_incoming_mail`, `smtp_outgoing_mail`, `smtp_username`, `smtp_password`) VALUES
(1, 'Onic-Ezymo', 'logo.jpg', 'Asia/Colombo', 10, '10.00', 'LKR', 'd-m-Y', 3, 0, 1, '1', 36, '2017-08-28 17:06:06', '{"pre_so":"","post_so":"","pre_po":"","post_po":"","pumps":"","invoice_footer":"asd","is_point":"yes","point_percentage":"2","max_outlets":"4","max_pumps18":"10","max_pumps17":"10","max_pumps1":"12"}', 0, '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `staff_code`, `staff_name`, `staff_mobile`, `email`, `division_id`, `assign_outlet`, `address`, `staff_cni`, `thumbnail`, `points`, `created_user_id`, `date_cre`, `point_title`, `point_percentage`, `isview_sale`) VALUES
(49, '', 'User1', '', 'user@gmail.com', 0, 1, '', '', NULL, 0, 36, '2017-08-28', 0, '0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `s_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(100) NOT NULL,
  `s_address` text NOT NULL,
  `s_contact` varchar(100) NOT NULL,
  `s_stock` float(65,3) NOT NULL,
  `s_stock_upated` float(65,3) NOT NULL,
  `s_status` varchar(10) NOT NULL,
  `date_created` datetime NOT NULL,
  PRIMARY KEY (`s_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`s_id`, `s_name`, `s_address`, `s_contact`, `s_stock`, `s_stock_upated`, `s_status`, `date_created`) VALUES
(1, 'Store1', 'Store1', '9979133538', 249877888.000, 249877888.000, '1', '2017-08-26 11:32:04'),
(2, 'Store2', 'Store2', '9979133538', 288.000, 288.000, '1', '2017-08-26 11:32:04'),
(3, 'Store3', 'Store3', '9979133538', 1995.000, 1995.000, '1', '2017-08-26 11:32:04');

-- --------------------------------------------------------

--
-- Table structure for table `store_transfer_record`
--

CREATE TABLE IF NOT EXISTS `store_transfer_record` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `store_transform`
--

CREATE TABLE IF NOT EXISTS `store_transform` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `sub_category`
--

CREATE TABLE IF NOT EXISTS `sub_category` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `sub_category`
--

INSERT INTO `sub_category` (`id`, `sub_category`, `category_id_fk`, `prefix`, `created_by`, `created_at`, `last_modefied_id`, `last_modefied_at`, `status`) VALUES
(1, 'Diesel', 20, '', 36, '2017-07-14 09:39:28', 36, '2017-07-14 15:09:28', 0),
(2, 'Petrol', 20, '', 36, '2017-07-14 09:39:15', 36, '2017-07-14 15:09:15', 0),
(3, 'Petrol 92', 20, '', 36, '2017-07-25 15:00:42', NULL, NULL, 0),
(4, 'dis', 20, '', 36, '2017-07-26 11:34:15', NULL, NULL, 0),
(5, 'asd', 20, '', 36, '2017-07-26 11:36:08', NULL, NULL, 0),
(6, 'LAD-1', 20, '', 36, '2017-07-31 05:26:21', NULL, NULL, 0),
(7, 'LAD-2', 20, '', 36, '2017-07-31 05:26:29', NULL, NULL, 0),
(8, 'SP95', 20, '', 36, '2017-07-31 05:38:17', NULL, NULL, 0),
(9, 'Lubricants', 21, '', 36, '2017-08-01 05:12:14', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE IF NOT EXISTS `suppliers` (
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
  `balance` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `address`, `tel`, `fax`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`, `balance`) VALUES
(1, 'Supplier Co., Ltd', 'supplier@gmail.com', 'asdf', '2345678', '8765432', 1, '2016-09-11 19:29:24', 1, '2016-12-18 14:59:58', 1, '0'),
(3, 'IOC', 'ioc@gmail.com', '1', '1', '', 36, '2017-06-04 15:14:49', 36, '2017-06-04 15:15:21', 1, '0'),
(5, 'Test Supplier', 'ts@gmail.com', '11', '11', '11', 36, '2017-07-25 20:33:50', 0, '0000-00-00 00:00:00', 1, '0'),
(6, 'hardik', 'hardikdayani1@gmail.com', 'surat', '9979133538', '', 36, '2017-08-19 11:22:59', 0, '0000-00-00 00:00:00', 1, '0'),
(7, 'supplier1', 'supplier1@gmail.com', 'Supplier Address1', '', '', 36, '2017-08-24 16:11:36', 0, '0000-00-00 00:00:00', 0, '0'),
(8, 'supplier2', 'supplier2@gmail.com', 'Supplier Address2', '', '', 36, '2017-08-24 16:11:36', 0, '0000-00-00 00:00:00', 0, '0'),
(9, 'S & S AGENCIES', 'ss@1.com', 'ads', '', '', 36, '2017-08-28 10:48:29', 0, '0000-00-00 00:00:00', 0, '0'),
(10, 'MICROSOL TECHNOLOGIES', 'm@1.com', 'ads', '', '', 36, '2017-08-28 10:48:29', 0, '0000-00-00 00:00:00', 0, '0'),
(11, 'MICROSOL TECHNOLOGIES', 'm1@.com', 'ads', '', '', 36, '2017-08-28 10:48:30', 0, '0000-00-00 00:00:00', 0, '0'),
(12, 'DASH', 'd@1.com', 'ads', '', '', 36, '2017-08-28 10:48:30', 0, '0000-00-00 00:00:00', 0, '0'),
(13, 'RASHMINA ENTERPRISES 1 @. COM', 'r1@1.com', 'ads', '', '', 36, '2017-08-28 10:48:30', 0, '0000-00-00 00:00:00', 0, '0'),
(14, 'SOL 4 MARKETING PVT LTD', 'sol@1.com', 'ads', '', '', 36, '2017-08-28 10:48:30', 0, '0000-00-00 00:00:00', 0, '0'),
(15, 'ERANDI RICE MILLS', 'e@1.com', 'ads', '', '', 36, '2017-08-28 10:48:30', 0, '0000-00-00 00:00:00', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `suspend`
--

CREATE TABLE IF NOT EXISTS `suspend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `fullname` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ref_number` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `outlet_id` int(11) NOT NULL,
  `subtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount_total` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grandtotal` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total_items` int(11) NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `suspend_items`
--

CREATE TABLE IF NOT EXISTS `suspend_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suspend_id` int(11) NOT NULL,
  `product_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_code` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `product_category` int(11) NOT NULL,
  `product_cost` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qty` int(11) NOT NULL,
  `balance_stock` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `product_price` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ow_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_order_items`
--

CREATE TABLE IF NOT EXISTS `temporary_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_id` varchar(255) NOT NULL DEFAULT '',
  `product_code` varchar(255) NOT NULL DEFAULT '',
  `qty` varchar(255) NOT NULL DEFAULT '',
  `cost` varchar(255) NOT NULL DEFAULT '0',
  `price` varchar(255) NOT NULL DEFAULT '0',
  `paid` varchar(255) NOT NULL DEFAULT '0',
  `grandtotal` varchar(255) NOT NULL DEFAULT '0',
  `tax` varchar(255) NOT NULL DEFAULT '0',
  `tax_amount` varchar(255) NOT NULL DEFAULT '0',
  `discount` varchar(255) NOT NULL DEFAULT '0',
  `discount_amount` varchar(255) NOT NULL DEFAULT '0',
  `testing_qty` varchar(255) NOT NULL DEFAULT '0',
  `start_meter` varchar(255) NOT NULL DEFAULT '0',
  `end_meter` varchar(255) NOT NULL DEFAULT '0',
  `pump_operators_id` varchar(255) NOT NULL DEFAULT '',
  `pump_id` varchar(255) NOT NULL DEFAULT '',
  `ow_id` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL DEFAULT '' COMMENT '0:warehouse, 1:tank',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_payment_method`
--

CREATE TABLE IF NOT EXISTS `temporary_payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `settlement_no` varchar(255) NOT NULL DEFAULT '',
  `payment_type` varchar(255) NOT NULL DEFAULT '',
  `amount` varchar(255) NOT NULL DEFAULT '0',
  `cheque_number` varchar(255) NOT NULL DEFAULT '',
  `cheque_date` date NOT NULL,
  `bank` varchar(255) NOT NULL DEFAULT '',
  `voucher_number` varchar(255) NOT NULL DEFAULT '',
  `addi_card_numb` varchar(255) NOT NULL DEFAULT '',
  `card_numb` varchar(255) NOT NULL DEFAULT '',
  `customer_id` varchar(255) NOT NULL DEFAULT '',
  `pumper_id` varchar(255) NOT NULL DEFAULT '',
  `note` varchar(355) NOT NULL DEFAULT '',
  `created_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `temporary_purchase_order_items`
--

CREATE TABLE IF NOT EXISTS `temporary_purchase_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_id` varchar(255) NOT NULL DEFAULT '',
  `product_code` varchar(255) NOT NULL DEFAULT '',
  `cost` varchar(255) NOT NULL DEFAULT '',
  `ordered_qty` varchar(255) NOT NULL DEFAULT '0',
  `bonusqty` varchar(255) NOT NULL DEFAULT '0',
  `discount_percentage` varchar(255) NOT NULL DEFAULT '0',
  `discount_amount` varchar(255) NOT NULL DEFAULT '0',
  `tax` varchar(255) NOT NULL DEFAULT '0',
  `subTotal` varchar(255) NOT NULL DEFAULT '0',
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE IF NOT EXISTS `timezones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(499) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=422 ;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `code`, `timezone`) VALUES
(1, 'AD', 'Europe/Andorra'),
(2, 'AE', 'Asia/Dubai'),
(3, 'AF', 'Asia/Kabul'),
(4, 'AG', 'America/Antigua'),
(5, 'AI', 'America/Anguilla'),
(6, 'AL', 'Europe/Tirane'),
(7, 'AM', 'Asia/Yerevan'),
(8, 'AO', 'Africa/Luanda'),
(9, 'AQ', 'Antarctica/McMurdo'),
(10, 'AQ', 'Antarctica/Casey'),
(11, 'AQ', 'Antarctica/Davis'),
(12, 'AQ', 'Antarctica/DumontDUrville'),
(13, 'AQ', 'Antarctica/Mawson'),
(14, 'AQ', 'Antarctica/Palmer'),
(15, 'AQ', 'Antarctica/Rothera'),
(16, 'AQ', 'Antarctica/Syowa'),
(17, 'AQ', 'Antarctica/Troll'),
(18, 'AQ', 'Antarctica/Vostok'),
(19, 'AR', 'America/Argentina/Buenos_Aires'),
(20, 'AR', 'America/Argentina/Cordoba'),
(21, 'AR', 'America/Argentina/Salta'),
(22, 'AR', 'America/Argentina/Jujuy'),
(23, 'AR', 'America/Argentina/Tucuman'),
(24, 'AR', 'America/Argentina/Catamarca'),
(25, 'AR', 'America/Argentina/La_Rioja'),
(26, 'AR', 'America/Argentina/San_Juan'),
(27, 'AR', 'America/Argentina/Mendoza'),
(28, 'AR', 'America/Argentina/San_Luis'),
(29, 'AR', 'America/Argentina/Rio_Gallegos'),
(30, 'AR', 'America/Argentina/Ushuaia'),
(31, 'AS', 'Pacific/Pago_Pago'),
(32, 'AT', 'Europe/Vienna'),
(33, 'AU', 'Australia/Lord_Howe'),
(34, 'AU', 'Antarctica/Macquarie'),
(35, 'AU', 'Australia/Hobart'),
(36, 'AU', 'Australia/Currie'),
(37, 'AU', 'Australia/Melbourne'),
(38, 'AU', 'Australia/Sydney'),
(39, 'AU', 'Australia/Broken_Hill'),
(40, 'AU', 'Australia/Brisbane'),
(41, 'AU', 'Australia/Lindeman'),
(42, 'AU', 'Australia/Adelaide'),
(43, 'AU', 'Australia/Darwin'),
(44, 'AU', 'Australia/Perth'),
(45, 'AU', 'Australia/Eucla'),
(46, 'AW', 'America/Aruba'),
(47, 'AX', 'Europe/Mariehamn'),
(48, 'AZ', 'Asia/Baku'),
(49, 'BA', 'Europe/Sarajevo'),
(50, 'BB', 'America/Barbados'),
(51, 'BD', 'Asia/Dhaka'),
(52, 'BE', 'Europe/Brussels'),
(53, 'BF', 'Africa/Ouagadougou'),
(54, 'BG', 'Europe/Sofia'),
(55, 'BH', 'Asia/Bahrain'),
(56, 'BI', 'Africa/Bujumbura'),
(57, 'BJ', 'Africa/Porto-Novo'),
(58, 'BL', 'America/St_Barthelemy'),
(59, 'BM', 'Atlantic/Bermuda'),
(60, 'BN', 'Asia/Brunei'),
(61, 'BO', 'America/La_Paz'),
(62, 'BQ', 'America/Kralendijk'),
(63, 'BR', 'America/Noronha'),
(64, 'BR', 'America/Belem'),
(65, 'BR', 'America/Fortaleza'),
(66, 'BR', 'America/Recife'),
(67, 'BR', 'America/Araguaina'),
(68, 'BR', 'America/Maceio'),
(69, 'BR', 'America/Bahia'),
(70, 'BR', 'America/Sao_Paulo'),
(71, 'BR', 'America/Campo_Grande'),
(72, 'BR', 'America/Cuiaba'),
(73, 'BR', 'America/Santarem'),
(74, 'BR', 'America/Porto_Velho'),
(75, 'BR', 'America/Boa_Vista'),
(76, 'BR', 'America/Manaus'),
(77, 'BR', 'America/Eirunepe'),
(78, 'BR', 'America/Rio_Branco'),
(79, 'BS', 'America/Nassau'),
(80, 'BT', 'Asia/Thimphu'),
(81, 'BW', 'Africa/Gaborone'),
(82, 'BY', 'Europe/Minsk'),
(83, 'BZ', 'America/Belize'),
(84, 'CA', 'America/St_Johns'),
(85, 'CA', 'America/Halifax'),
(86, 'CA', 'America/Glace_Bay'),
(87, 'CA', 'America/Moncton'),
(88, 'CA', 'America/Goose_Bay'),
(89, 'CA', 'America/Blanc-Sablon'),
(90, 'CA', 'America/Toronto'),
(91, 'CA', 'America/Nipigon'),
(92, 'CA', 'America/Thunder_Bay'),
(93, 'CA', 'America/Iqaluit'),
(94, 'CA', 'America/Pangnirtung'),
(95, 'CA', 'America/Atikokan'),
(96, 'CA', 'America/Winnipeg'),
(97, 'CA', 'America/Rainy_River'),
(98, 'CA', 'America/Resolute'),
(99, 'CA', 'America/Rankin_Inlet'),
(100, 'CA', 'America/Regina'),
(101, 'CA', 'America/Swift_Current'),
(102, 'CA', 'America/Edmonton'),
(103, 'CA', 'America/Cambridge_Bay'),
(104, 'CA', 'America/Yellowknife'),
(105, 'CA', 'America/Inuvik'),
(106, 'CA', 'America/Creston'),
(107, 'CA', 'America/Dawson_Creek'),
(108, 'CA', 'America/Fort_Nelson'),
(109, 'CA', 'America/Vancouver'),
(110, 'CA', 'America/Whitehorse'),
(111, 'CA', 'America/Dawson'),
(112, 'CC', 'Indian/Cocos'),
(113, 'CD', 'Africa/Kinshasa'),
(114, 'CD', 'Africa/Lubumbashi'),
(115, 'CF', 'Africa/Bangui'),
(116, 'CG', 'Africa/Brazzaville'),
(117, 'CH', 'Europe/Zurich'),
(118, 'CI', 'Africa/Abidjan'),
(119, 'CK', 'Pacific/Rarotonga'),
(120, 'CL', 'America/Santiago'),
(121, 'CL', 'Pacific/Easter'),
(122, 'CM', 'Africa/Douala'),
(123, 'CN', 'Asia/Shanghai'),
(124, 'CN', 'Asia/Urumqi'),
(125, 'CO', 'America/Bogota'),
(126, 'CR', 'America/Costa_Rica'),
(127, 'CU', 'America/Havana'),
(128, 'CV', 'Atlantic/Cape_Verde'),
(129, 'CW', 'America/Curacao'),
(130, 'CX', 'Indian/Christmas'),
(131, 'CY', 'Asia/Nicosia'),
(132, 'CZ', 'Europe/Prague'),
(133, 'DE', 'Europe/Berlin'),
(134, 'DE', 'Europe/Busingen'),
(135, 'DJ', 'Africa/Djibouti'),
(136, 'DK', 'Europe/Copenhagen'),
(137, 'DM', 'America/Dominica'),
(138, 'DO', 'America/Santo_Domingo'),
(139, 'DZ', 'Africa/Algiers'),
(140, 'EC', 'America/Guayaquil'),
(141, 'EC', 'Pacific/Galapagos'),
(142, 'EE', 'Europe/Tallinn'),
(143, 'EG', 'Africa/Cairo'),
(144, 'EH', 'Africa/El_Aaiun'),
(145, 'ER', 'Africa/Asmara'),
(146, 'ES', 'Europe/Madrid'),
(147, 'ES', 'Africa/Ceuta'),
(148, 'ES', 'Atlantic/Canary'),
(149, 'ET', 'Africa/Addis_Ababa'),
(150, 'FI', 'Europe/Helsinki'),
(151, 'FJ', 'Pacific/Fiji'),
(152, 'FK', 'Atlantic/Stanley'),
(153, 'FM', 'Pacific/Chuuk'),
(154, 'FM', 'Pacific/Pohnpei'),
(155, 'FM', 'Pacific/Kosrae'),
(156, 'FO', 'Atlantic/Faroe'),
(157, 'FR', 'Europe/Paris'),
(158, 'GA', 'Africa/Libreville'),
(159, 'GB', 'Europe/London'),
(160, 'GD', 'America/Grenada'),
(161, 'GE', 'Asia/Tbilisi'),
(162, 'GF', 'America/Cayenne'),
(163, 'GG', 'Europe/Guernsey'),
(164, 'GH', 'Africa/Accra'),
(165, 'GI', 'Europe/Gibraltar'),
(166, 'GL', 'America/Godthab'),
(167, 'GL', 'America/Danmarkshavn'),
(168, 'GL', 'America/Scoresbysund'),
(169, 'GL', 'America/Thule'),
(170, 'GM', 'Africa/Banjul'),
(171, 'GN', 'Africa/Conakry'),
(172, 'GP', 'America/Guadeloupe'),
(173, 'GQ', 'Africa/Malabo'),
(174, 'GR', 'Europe/Athens'),
(175, 'GS', 'Atlantic/South_Georgia'),
(176, 'GT', 'America/Guatemala'),
(177, 'GU', 'Pacific/Guam'),
(178, 'GW', 'Africa/Bissau'),
(179, 'GY', 'America/Guyana'),
(180, 'HK', 'Asia/Hong_Kong'),
(181, 'HN', 'America/Tegucigalpa'),
(182, 'HR', 'Europe/Zagreb'),
(183, 'HT', 'America/Port-au-Prince'),
(184, 'HU', 'Europe/Budapest'),
(185, 'ID', 'Asia/Jakarta'),
(186, 'ID', 'Asia/Pontianak'),
(187, 'ID', 'Asia/Makassar'),
(188, 'ID', 'Asia/Jayapura'),
(189, 'IE', 'Europe/Dublin'),
(190, 'IL', 'Asia/Jerusalem'),
(191, 'IM', 'Europe/Isle_of_Man'),
(192, 'IN', 'Asia/Kolkata'),
(193, 'IO', 'Indian/Chagos'),
(194, 'IQ', 'Asia/Baghdad'),
(195, 'IR', 'Asia/Tehran'),
(196, 'IS', 'Atlantic/Reykjavik'),
(197, 'IT', 'Europe/Rome'),
(198, 'JE', 'Europe/Jersey'),
(199, 'JM', 'America/Jamaica'),
(200, 'JO', 'Asia/Amman'),
(201, 'JP', 'Asia/Tokyo'),
(202, 'KE', 'Africa/Nairobi'),
(203, 'KG', 'Asia/Bishkek'),
(204, 'KH', 'Asia/Phnom_Penh'),
(205, 'KI', 'Pacific/Tarawa'),
(206, 'KI', 'Pacific/Enderbury'),
(207, 'KI', 'Pacific/Kiritimati'),
(208, 'KM', 'Indian/Comoro'),
(209, 'KN', 'America/St_Kitts'),
(210, 'KP', 'Asia/Pyongyang'),
(211, 'KR', 'Asia/Seoul'),
(212, 'KW', 'Asia/Kuwait'),
(213, 'KY', 'America/Cayman'),
(214, 'KZ', 'Asia/Almaty'),
(215, 'KZ', 'Asia/Qyzylorda'),
(216, 'KZ', 'Asia/Aqtobe'),
(217, 'KZ', 'Asia/Aqtau'),
(218, 'KZ', 'Asia/Oral'),
(219, 'LA', 'Asia/Vientiane'),
(220, 'LB', 'Asia/Beirut'),
(221, 'LC', 'America/St_Lucia'),
(222, 'LI', 'Europe/Vaduz'),
(223, 'LK', 'Asia/Colombo'),
(224, 'LR', 'Africa/Monrovia'),
(225, 'LS', 'Africa/Maseru'),
(226, 'LT', 'Europe/Vilnius'),
(227, 'LU', 'Europe/Luxembourg'),
(228, 'LV', 'Europe/Riga'),
(229, 'LY', 'Africa/Tripoli'),
(230, 'MA', 'Africa/Casablanca'),
(231, 'MC', 'Europe/Monaco'),
(232, 'MD', 'Europe/Chisinau'),
(233, 'ME', 'Europe/Podgorica'),
(234, 'MF', 'America/Marigot'),
(235, 'MG', 'Indian/Antananarivo'),
(236, 'MH', 'Pacific/Majuro'),
(237, 'MH', 'Pacific/Kwajalein'),
(238, 'MK', 'Europe/Skopje'),
(239, 'ML', 'Africa/Bamako'),
(240, 'MM', 'Asia/Rangoon'),
(241, 'MN', 'Asia/Ulaanbaatar'),
(242, 'MN', 'Asia/Hovd'),
(243, 'MN', 'Asia/Choibalsan'),
(244, 'MO', 'Asia/Macau'),
(245, 'MP', 'Pacific/Saipan'),
(246, 'MQ', 'America/Martinique'),
(247, 'MR', 'Africa/Nouakchott'),
(248, 'MS', 'America/Montserrat'),
(249, 'MT', 'Europe/Malta'),
(250, 'MU', 'Indian/Mauritius'),
(251, 'MV', 'Indian/Maldives'),
(252, 'MW', 'Africa/Blantyre'),
(253, 'MX', 'America/Mexico_City'),
(254, 'MX', 'America/Cancun'),
(255, 'MX', 'America/Merida'),
(256, 'MX', 'America/Monterrey'),
(257, 'MX', 'America/Matamoros'),
(258, 'MX', 'America/Mazatlan'),
(259, 'MX', 'America/Chihuahua'),
(260, 'MX', 'America/Ojinaga'),
(261, 'MX', 'America/Hermosillo'),
(262, 'MX', 'America/Tijuana'),
(263, 'MX', 'America/Bahia_Banderas'),
(264, 'MY', 'Asia/Kuala_Lumpur'),
(265, 'MY', 'Asia/Kuching'),
(266, 'MZ', 'Africa/Maputo'),
(267, 'NA', 'Africa/Windhoek'),
(268, 'NC', 'Pacific/Noumea'),
(269, 'NE', 'Africa/Niamey'),
(270, 'NF', 'Pacific/Norfolk'),
(271, 'NG', 'Africa/Lagos'),
(272, 'NI', 'America/Managua'),
(273, 'NL', 'Europe/Amsterdam'),
(274, 'NO', 'Europe/Oslo'),
(275, 'NP', 'Asia/Kathmandu'),
(276, 'NR', 'Pacific/Nauru'),
(277, 'NU', 'Pacific/Niue'),
(278, 'NZ', 'Pacific/Auckland'),
(279, 'NZ', 'Pacific/Chatham'),
(280, 'OM', 'Asia/Muscat'),
(281, 'PA', 'America/Panama'),
(282, 'PE', 'America/Lima'),
(283, 'PF', 'Pacific/Tahiti'),
(284, 'PF', 'Pacific/Marquesas'),
(285, 'PF', 'Pacific/Gambier'),
(286, 'PG', 'Pacific/Port_Moresby'),
(287, 'PG', 'Pacific/Bougainville'),
(288, 'PH', 'Asia/Manila'),
(289, 'PK', 'Asia/Karachi'),
(290, 'PL', 'Europe/Warsaw'),
(291, 'PM', 'America/Miquelon'),
(292, 'PN', 'Pacific/Pitcairn'),
(293, 'PR', 'America/Puerto_Rico'),
(294, 'PS', 'Asia/Gaza'),
(295, 'PS', 'Asia/Hebron'),
(296, 'PT', 'Europe/Lisbon'),
(297, 'PT', 'Atlantic/Madeira'),
(298, 'PT', 'Atlantic/Azores'),
(299, 'PW', 'Pacific/Palau'),
(300, 'PY', 'America/Asuncion'),
(301, 'QA', 'Asia/Qatar'),
(302, 'RE', 'Indian/Reunion'),
(303, 'RO', 'Europe/Bucharest'),
(304, 'RS', 'Europe/Belgrade'),
(305, 'RU', 'Europe/Kaliningrad'),
(306, 'RU', 'Europe/Moscow'),
(307, 'RU', 'Europe/Simferopol'),
(308, 'RU', 'Europe/Volgograd'),
(309, 'RU', 'Europe/Kirov'),
(310, 'RU', 'Europe/Astrakhan'),
(311, 'RU', 'Europe/Samara'),
(312, 'RU', 'Europe/Ulyanovsk'),
(313, 'RU', 'Asia/Yekaterinburg'),
(314, 'RU', 'Asia/Omsk'),
(315, 'RU', 'Asia/Novosibirsk'),
(316, 'RU', 'Asia/Barnaul'),
(317, 'RU', 'Asia/Tomsk'),
(318, 'RU', 'Asia/Novokuznetsk'),
(319, 'RU', 'Asia/Krasnoyarsk'),
(320, 'RU', 'Asia/Irkutsk'),
(321, 'RU', 'Asia/Chita'),
(322, 'RU', 'Asia/Yakutsk'),
(323, 'RU', 'Asia/Khandyga'),
(324, 'RU', 'Asia/Vladivostok'),
(325, 'RU', 'Asia/Ust-Nera'),
(326, 'RU', 'Asia/Magadan'),
(327, 'RU', 'Asia/Sakhalin'),
(328, 'RU', 'Asia/Srednekolymsk'),
(329, 'RU', 'Asia/Kamchatka'),
(330, 'RU', 'Asia/Anadyr'),
(331, 'RW', 'Africa/Kigali'),
(332, 'SA', 'Asia/Riyadh'),
(333, 'SB', 'Pacific/Guadalcanal'),
(334, 'SC', 'Indian/Mahe'),
(335, 'SD', 'Africa/Khartoum'),
(336, 'SE', 'Europe/Stockholm'),
(337, 'SG', 'Asia/Singapore'),
(338, 'SH', 'Atlantic/St_Helena'),
(339, 'SI', 'Europe/Ljubljana'),
(340, 'SJ', 'Arctic/Longyearbyen'),
(341, 'SK', 'Europe/Bratislava'),
(342, 'SL', 'Africa/Freetown'),
(343, 'SM', 'Europe/San_Marino'),
(344, 'SN', 'Africa/Dakar'),
(345, 'SO', 'Africa/Mogadishu'),
(346, 'SR', 'America/Paramaribo'),
(347, 'SS', 'Africa/Juba'),
(348, 'ST', 'Africa/Sao_Tome'),
(349, 'SV', 'America/El_Salvador'),
(350, 'SX', 'America/Lower_Princes'),
(351, 'SY', 'Asia/Damascus'),
(352, 'SZ', 'Africa/Mbabane'),
(353, 'TC', 'America/Grand_Turk'),
(354, 'TD', 'Africa/Ndjamena'),
(355, 'TF', 'Indian/Kerguelen'),
(356, 'TG', 'Africa/Lome'),
(357, 'TH', 'Asia/Bangkok'),
(358, 'TJ', 'Asia/Dushanbe'),
(359, 'TK', 'Pacific/Fakaofo'),
(360, 'TL', 'Asia/Dili'),
(361, 'TM', 'Asia/Ashgabat'),
(362, 'TN', 'Africa/Tunis'),
(363, 'TO', 'Pacific/Tongatapu'),
(364, 'TR', 'Europe/Istanbul'),
(365, 'TT', 'America/Port_of_Spain'),
(366, 'TV', 'Pacific/Funafuti'),
(367, 'TW', 'Asia/Taipei'),
(368, 'TZ', 'Africa/Dar_es_Salaam'),
(369, 'UA', 'Europe/Kiev'),
(370, 'UA', 'Europe/Uzhgorod'),
(371, 'UA', 'Europe/Zaporozhye'),
(372, 'UG', 'Africa/Kampala'),
(373, 'UM', 'Pacific/Johnston'),
(374, 'UM', 'Pacific/Midway'),
(375, 'UM', 'Pacific/Wake'),
(376, 'US', 'America/New_York'),
(377, 'US', 'America/Detroit'),
(378, 'US', 'America/Kentucky/Louisville'),
(379, 'US', 'America/Kentucky/Monticello'),
(380, 'US', 'America/Indiana/Indianapolis'),
(381, 'US', 'America/Indiana/Vincennes'),
(382, 'US', 'America/Indiana/Winamac'),
(383, 'US', 'America/Indiana/Marengo'),
(384, 'US', 'America/Indiana/Petersburg'),
(385, 'US', 'America/Indiana/Vevay'),
(386, 'US', 'America/Chicago'),
(387, 'US', 'America/Indiana/Tell_City'),
(388, 'US', 'America/Indiana/Knox'),
(389, 'US', 'America/Menominee'),
(390, 'US', 'America/North_Dakota/Center'),
(391, 'US', 'America/North_Dakota/New_Salem'),
(392, 'US', 'America/North_Dakota/Beulah'),
(393, 'US', 'America/Denver'),
(394, 'US', 'America/Boise'),
(395, 'US', 'America/Phoenix'),
(396, 'US', 'America/Los_Angeles'),
(397, 'US', 'America/Anchorage'),
(398, 'US', 'America/Juneau'),
(399, 'US', 'America/Sitka'),
(400, 'US', 'America/Metlakatla'),
(401, 'US', 'America/Yakutat'),
(402, 'US', 'America/Nome'),
(403, 'US', 'America/Adak'),
(404, 'US', 'Pacific/Honolulu'),
(405, 'UY', 'America/Montevideo'),
(406, 'UZ', 'Asia/Samarkand'),
(407, 'UZ', 'Asia/Tashkent'),
(408, 'VA', 'Europe/Vatican'),
(409, 'VC', 'America/St_Vincent'),
(410, 'VE', 'America/Caracas'),
(411, 'VG', 'America/Tortola'),
(412, 'VI', 'America/St_Thomas'),
(413, 'VN', 'Asia/Ho_Chi_Minh'),
(414, 'VU', 'Pacific/Efate'),
(415, 'WF', 'Pacific/Wallis'),
(416, 'WS', 'Pacific/Apia'),
(417, 'YE', 'Asia/Aden'),
(418, 'YT', 'Indian/Mayotte'),
(419, 'ZA', 'Africa/Johannesburg'),
(420, 'ZM', 'Africa/Lusaka'),
(421, 'ZW', 'Africa/Harare');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` varchar(255) NOT NULL DEFAULT '',
  `account_number` varchar(30) DEFAULT NULL,
  `outlet_id` int(11) NOT NULL,
  `trans_type` enum('wd','dep','loan','return','payment','outstanding') DEFAULT NULL,
  `amount` varchar(255) DEFAULT '0',
  `transaction` text,
  `created_by` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pumper_id` int(11) DEFAULT NULL,
  `receipt` varchar(55) DEFAULT NULL,
  `expense` int(11) DEFAULT NULL,
  `balance` int(11) DEFAULT NULL,
  `settlement_id` int(11) NOT NULL DEFAULT '0',
  `bring_forword` varchar(255) NOT NULL,
  `cheque_number` varchar(255) NOT NULL DEFAULT '',
  `cheque_date` date NOT NULL,
  `bank` varchar(255) NOT NULL DEFAULT '',
  `voucher_number` varchar(255) NOT NULL DEFAULT '',
  `card_number` varchar(255) NOT NULL DEFAULT '',
  `status` varchar(255) NOT NULL DEFAULT '0' COMMENT '0: Active , 1: Inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=158 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `order_id`, `account_number`, `outlet_id`, `trans_type`, `amount`, `transaction`, `created_by`, `user_id`, `created`, `pumper_id`, `receipt`, `expense`, `balance`, `settlement_id`, `bring_forword`, `cheque_number`, `cheque_date`, `bank`, `voucher_number`, `card_number`, `status`) VALUES
(1, '1', '1', 1, 'dep', '20', NULL, 36, 1, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '77428.74', '', '0000-00-00', '', '', '', '0'),
(2, '1', '3', 1, 'dep', '20', NULL, 36, 1, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '600.00', '', '0000-00-00', '', '', '', '0'),
(3, '1', '3', 1, 'dep', '30', NULL, 36, 1, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '620.00', '', '0000-00-00', '', '', '', '0'),
(4, '1', '6', 1, 'dep', '410', NULL, 36, 3, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '15602984.60', '', '0000-00-00', '', '', '', '0'),
(5, '1', '3', 1, 'dep', '29.3', NULL, 36, 1, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '650.00', '', '0000-00-00', '', '', '32312', '0'),
(6, '1', '10', 1, 'dep', '4000', NULL, 36, 3, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '0.00', '', '0000-00-00', '', '', '', '0'),
(7, '1', '6', 1, 'dep', '12', NULL, 36, 123, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '15603394.60', '', '0000-00-00', '', '', '', '0'),
(8, '1', '1', 1, 'dep', '476.7', NULL, 36, 1, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '77448.74', '', '0000-00-00', '', '', '', '0'),
(9, '1', '1', 1, 'dep', '2', NULL, 36, 1, '2017-08-29 13:21:11', 0, NULL, NULL, NULL, 70, '77925.44', '', '0000-00-00', '', '', '', '0'),
(10, '2', '1', 1, 'dep', '970280', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '77927.44', '', '0000-00-00', '', '', '', '0'),
(11, '2', '3', 1, 'dep', '76372.25', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '679.30', '', '0000-00-00', '', '', '', '0'),
(12, '2', '6', 1, 'dep', '9599.28', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '15603406.60', '', '0000-00-00', '', '', '', '0'),
(13, '2', '6', 1, 'dep', '9969.11', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '15613005.88', '', '0000-00-00', '', '', '', '0'),
(14, '2', '6', 1, 'dep', '8949.48', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '15622974.99', '', '0000-00-00', '', '', '', '0'),
(15, '2', '6', 1, 'dep', '9499.05', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '15631924.47', '', '0000-00-00', '', '', '', '0'),
(16, '2', '5', 1, 'dep', '17390', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '50.00', '', '0000-00-00', '', '', '', '0'),
(17, '2', '17', 1, 'dep', '5382.04', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '400.00', '', '0000-00-00', '', '', '', '0'),
(18, '2', '17', 1, 'dep', '1846.33', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '5782.04', '', '0000-00-00', '', '', '', '0'),
(19, '2', '17', 1, 'dep', '4833.89', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '7628.37', '', '0000-00-00', '', '', '', '0'),
(20, '2', '17', 1, 'dep', '2100.45', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '12462.26', '', '0000-00-00', '', '', '', '0'),
(21, '2', '17', 1, 'dep', '4000.26', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '14562.71', '', '0000-00-00', '', '', '', '0'),
(22, '2', '19', 1, 'dep', '-250.34', NULL, 36, 1, '2017-08-30 05:20:29', 1, NULL, NULL, NULL, 71, '0.00', '', '0000-00-00', '', '', '', '0'),
(23, '3', '1', 1, 'dep', '970280', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '1048207.44', '', '0000-00-00', '', '', '', '0'),
(24, '3', '3', 1, 'dep', '76372.25', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '77051.55', '', '0000-00-00', '', '', '', '0'),
(25, '3', '6', 1, 'dep', '9599.28', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '15641423.52', '', '0000-00-00', '', '', '', '0'),
(26, '3', '6', 1, 'dep', '9969.11', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '15651022.80', '', '0000-00-00', '', '', '', '0'),
(27, '3', '6', 1, 'dep', '8949.48', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '15660991.91', '', '0000-00-00', '', '', '', '0'),
(28, '3', '6', 1, 'dep', '9499.05', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '15669941.39', '', '0000-00-00', '', '', '', '0'),
(29, '3', '5', 1, 'dep', '17390', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '17440.00', '', '0000-00-00', '', '', '', '0'),
(30, '3', '17', 1, 'dep', '5382.04', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '18562.97', '', '0000-00-00', '', '', '', '0'),
(31, '3', '17', 1, 'dep', '1846.33', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '23945.01', '', '0000-00-00', '', '', '', '0'),
(32, '3', '17', 1, 'dep', '4833.89', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '25791.34', '', '0000-00-00', '', '', '', '0'),
(33, '3', '17', 1, 'dep', '2100.45', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '30625.23', '', '0000-00-00', '', '', '', '0'),
(34, '3', '17', 1, 'dep', '4000.26', NULL, 36, 1, '2017-08-30 05:31:51', 0, NULL, NULL, NULL, 72, '32725.68', '', '0000-00-00', '', '', '', '0'),
(35, '4', '1', 1, 'dep', '2090', NULL, 36, 1, '2017-08-31 04:24:56', 0, NULL, NULL, NULL, 73, '2018487.44', '', '0000-00-00', '', '', '', '0'),
(36, '5', '1', 1, 'dep', '2000', NULL, 36, 1, '2017-08-31 05:12:26', 0, NULL, NULL, NULL, 74, '2020577.44', '', '0000-00-00', '', '', '', '0'),
(37, '5', '6', 1, 'dep', '2000', NULL, 36, 1, '2017-08-31 05:12:26', 0, NULL, NULL, NULL, 74, '15679440.44', '', '0000-00-00', '', '', '', '0'),
(38, '5', '17', 1, 'dep', '25000', NULL, 36, 1, '2017-08-31 05:12:26', 0, NULL, NULL, NULL, 74, '36725.94', '', '0000-00-00', '', '12345645', '', '0'),
(39, '5', '17', 1, 'dep', '2500', NULL, 36, 1, '2017-08-31 05:12:26', 0, NULL, NULL, NULL, 74, '61725.94', '', '0000-00-00', '', '', '', '0'),
(40, '5', '17', 1, 'dep', '35000', NULL, 36, 1, '2017-08-31 05:12:26', 0, NULL, NULL, NULL, 74, '64225.94', '', '0000-00-00', '', '', '', '0'),
(41, '5', '15', 1, 'dep', '66500', NULL, 36, 1, '2017-08-31 05:12:26', 0, NULL, NULL, NULL, 74, '0.00', '', '0000-00-00', '', '', '', '0'),
(42, '5', '1', 1, 'dep', '47028.2', NULL, 36, 1, '2017-08-31 05:12:26', 0, NULL, NULL, NULL, 74, '2022577.44', '', '0000-00-00', '', '', '', '0'),
(43, '6', '1', 1, 'dep', '11000', NULL, 36, 1, '2017-08-31 05:13:32', NULL, NULL, NULL, NULL, 0, '2069605.64', '', '1970-01-01', '', '', '', '0'),
(44, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080605.64', '', '0000-00-00', '', '', '', '0'),
(45, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080606.64', '', '0000-00-00', '', '', '', '0'),
(46, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080607.64', '', '0000-00-00', '', '', '', '0'),
(47, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080608.64', '', '0000-00-00', '', '', '', '0'),
(48, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080609.64', '', '0000-00-00', '', '', '', '0'),
(49, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080610.64', '', '0000-00-00', '', '', '', '0'),
(50, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080611.64', '', '0000-00-00', '', '', '', '0'),
(51, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080612.64', '', '0000-00-00', '', '', '', '0'),
(52, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080613.64', '', '0000-00-00', '', '', '', '0'),
(53, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080614.64', '', '0000-00-00', '', '', '', '0'),
(54, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080615.64', '', '0000-00-00', '', '', '', '0'),
(55, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080616.64', '', '0000-00-00', '', '', '', '0'),
(56, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080617.64', '', '0000-00-00', '', '', '', '0'),
(57, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080618.64', '', '0000-00-00', '', '', '', '0'),
(58, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080619.64', '', '0000-00-00', '', '', '', '0'),
(59, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080620.64', '', '0000-00-00', '', '', '', '0'),
(60, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080621.64', '', '0000-00-00', '', '', '', '0'),
(61, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080622.64', '', '0000-00-00', '', '', '', '0'),
(62, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080623.64', '', '0000-00-00', '', '', '', '0'),
(63, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080624.64', '', '0000-00-00', '', '', '', '0'),
(64, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080625.64', '', '0000-00-00', '', '', '', '0'),
(65, '7', '3', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '153423.80', '', '0000-00-00', '', '', '', '0'),
(66, '7', '1', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '2080626.64', '', '0000-00-00', '', '', '', '0'),
(67, '7', '17', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '99225.94', '', '0000-00-00', '', '', '', '0'),
(68, '7', '17', 1, 'dep', '1', NULL, 36, 1, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '99226.94', '', '0000-00-00', '', '', '', '0'),
(69, '7', '17', 1, 'dep', '745', NULL, 36, 2, '2017-08-31 05:24:35', 0, NULL, NULL, NULL, 75, '99227.94', '', '0000-00-00', '', '123456', '', '0'),
(70, '12', '1', 1, 'dep', '40', NULL, 36, 1, '2017-08-31 13:23:53', 1, NULL, NULL, NULL, 80, '2080627.64', '', '0000-00-00', '', '', '', '0'),
(71, '12', '1', 1, 'dep', '40', NULL, 36, 1, '2017-08-31 13:24:23', 1, NULL, NULL, NULL, 80, '2080667.64', '', '0000-00-00', '', '', '', '0'),
(72, '12', '1', 1, 'dep', '40', NULL, 36, 1, '2017-08-31 13:26:04', 1, NULL, NULL, NULL, 80, '2080707.64', '', '0000-00-00', '', '', '', '0'),
(73, '12', '1', 1, 'dep', '40', NULL, 36, 1, '2017-08-31 13:26:31', 1, NULL, NULL, NULL, 80, '2080747.64', '', '0000-00-00', '', '', '', '0'),
(74, '1', '1', 1, 'dep', '200', NULL, 36, 1, '2017-09-01 04:39:10', 1, NULL, NULL, NULL, 1, '2080787.64', '', '0000-00-00', '', '', '', '0'),
(75, '2', '1', 1, 'dep', '2130', NULL, 36, 1, '2017-09-01 04:46:00', 1, NULL, NULL, NULL, 2, '2080987.64', '', '0000-00-00', '', '', '', '0'),
(76, '3', '1', 1, 'dep', '200', NULL, 36, 1, '2017-09-01 05:00:03', 1, NULL, NULL, NULL, 3, '2083117.64', '', '0000-00-00', '', '', '', '0'),
(77, '4', '1', 1, 'dep', '700', NULL, 36, 1, '2017-09-01 05:05:11', 0, NULL, NULL, NULL, 4, '2083317.64', '', '0000-00-00', '', '', '', '0'),
(78, '5', '1', 1, 'dep', '720', NULL, 36, 1, '2017-09-01 05:06:11', 1, NULL, NULL, NULL, 5, '2084017.64', '', '0000-00-00', '', '', '', '0'),
(79, '6', '1', 1, 'dep', '660', NULL, 36, 1, '2017-09-01 05:07:24', 1, NULL, NULL, NULL, 6, '2084737.64', '', '0000-00-00', '', '', '', '0'),
(80, '7', '1', 1, 'dep', '700', NULL, 36, 1, '2017-09-01 05:26:28', 0, NULL, NULL, NULL, 7, '2085397.64', '', '0000-00-00', '', '', '', '0'),
(81, '8', '1', 1, 'dep', '760', NULL, 36, 1, '2017-09-01 05:28:53', 0, NULL, NULL, NULL, 8, '2086097.64', '', '0000-00-00', '', '', '', '0'),
(82, '9', '1', 1, 'dep', '310', NULL, 36, 1, '2017-09-01 05:32:06', 1, NULL, NULL, NULL, 9, '2086857.64', '', '0000-00-00', '', '', '', '0'),
(83, '10', '1', 1, 'dep', '100', NULL, 36, 1, '2017-09-01 05:34:24', 1, NULL, NULL, NULL, 10, '2087167.64', '', '0000-00-00', '', '', '', '0'),
(84, '11', '1', 1, 'dep', '60', NULL, 36, 1, '2017-09-01 06:16:30', 1, NULL, NULL, NULL, 11, '2087267.64', '', '0000-00-00', '', '', '', '0'),
(85, '14', '1', 1, 'dep', '20', NULL, 36, 0, '2017-09-01 08:48:59', 0, NULL, NULL, NULL, 14, '2087327.64', '', '1970-01-01', '', '', '', '0'),
(86, '14', '3', 1, 'dep', '30', NULL, 36, 0, '2017-09-01 08:48:59', 0, NULL, NULL, NULL, 14, '153424.80', '', '1970-01-01', '', '', '123456', '0'),
(87, '14', '1', 1, 'dep', '150', NULL, 36, 1, '2017-09-01 08:48:59', 0, NULL, NULL, NULL, 14, '2087347.64', '', '0000-00-00', '', '', '', '0'),
(88, '13', '1', 1, 'dep', '20', NULL, 36, 1, '2017-09-01 08:52:28', 0, NULL, NULL, NULL, 13, '2087497.64', '', '0000-00-00', '', '', '', '0'),
(89, '13', '3', 1, 'dep', '20', NULL, 36, 1, '2017-09-01 08:52:28', 0, NULL, NULL, NULL, 13, '153454.80', '', '0000-00-00', '', '', '12345612332', '0'),
(90, '13', '3', 1, 'dep', '50', NULL, 36, 1, '2017-09-01 08:52:28', 0, NULL, NULL, NULL, 13, '153474.80', '', '0000-00-00', '', '', '124561223123', '0'),
(91, '13', '8', 1, 'dep', '350', NULL, 36, 4, '2017-09-01 08:52:28', 0, NULL, NULL, NULL, 13, '0.00', '', '0000-00-00', '', '', '', '0'),
(92, '16', '1', 1, 'dep', '25', NULL, 36, 1, '2017-09-01 08:54:43', 1, NULL, NULL, NULL, 16, '2087517.64', '', '0000-00-00', '', '', '', '0'),
(93, '16', '3', 1, 'dep', '75', NULL, 36, 1, '2017-09-01 08:54:43', 1, NULL, NULL, NULL, 16, '153524.80', '', '0000-00-00', '', '', '', '0'),
(94, '16', '11', 1, 'dep', '640', NULL, 36, 1, '2017-09-01 08:54:43', 1, NULL, NULL, NULL, 16, '0.00', '', '0000-00-00', '', '', '', '0'),
(95, '', '1', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:25:10', NULL, NULL, NULL, NULL, 0, '2087542.64', '', '1970-01-01', '', '', '', '0'),
(96, '', '1', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:27:38', NULL, NULL, NULL, NULL, 0, '2087532.64', '', '1970-01-01', '', '', '', '0'),
(97, '', '1', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:27:38', NULL, NULL, NULL, NULL, 0, '2087522.64', '', '1970-01-01', '', '', '', '0'),
(98, '', '1', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:29:11', NULL, NULL, NULL, NULL, 0, '2087512.64', '', '1970-01-01', '', '', '', '0'),
(99, '', '1', 1, 'return', '30', NULL, 36, 0, '2017-09-02 12:29:11', NULL, NULL, NULL, NULL, 0, '2087502.64', '', '1970-01-01', '', '', '', '0'),
(100, '', '5', 1, 'return', '40', NULL, 36, 0, '2017-09-02 12:29:11', NULL, NULL, NULL, NULL, 0, '34830.00', '123456', '2017-09-16', 'sbin', '', '', '0'),
(101, '', '1', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:32:17', NULL, NULL, NULL, NULL, 0, '2087472.64', '', '1970-01-01', '', '', '', '0'),
(102, '', '5', 1, 'return', '25', NULL, 36, 0, '2017-09-02 12:32:17', NULL, NULL, NULL, NULL, 0, '34790.00', '123456869', '2017-09-23', 'sbin', '', '', '0'),
(103, '', '1', 1, 'return', '25', NULL, 36, 0, '2017-09-02 12:33:53', NULL, NULL, NULL, NULL, 0, '2087462.64', '', '1970-01-01', '', '', '', '0'),
(104, '', '1', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:33:53', NULL, NULL, NULL, NULL, 0, '2087437.64', '', '1970-01-01', '', '', '', '0'),
(105, '', '1', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:39:37', NULL, NULL, NULL, NULL, 0, '2087427.64', '', '1970-01-01', '', '', '', '0'),
(106, '', '3', 1, 'return', '10', NULL, 36, 0, '2017-09-02 12:39:37', NULL, NULL, NULL, NULL, 0, '153599.80', '', '1970-01-01', '', '', '100', '0'),
(107, '19', '1', 1, 'dep', '10', NULL, 36, 1, '2017-09-04 09:40:42', 0, NULL, NULL, NULL, 33, '2087417.64', '', '1970-01-01', '', '', '', '0'),
(108, '19', '1', 1, 'dep', '920', NULL, 36, 1, '2017-09-04 09:40:42', 0, NULL, NULL, NULL, 33, '2087427.64', '', '1970-01-01', '', '', '', '0'),
(109, '1', '1', 1, 'dep', '940', NULL, 36, 1, '2017-09-04 10:22:31', 0, NULL, NULL, NULL, 1, '2088347.64', '', '1970-01-01', '', '', '', '0'),
(110, '2', '1', 1, 'dep', '300', NULL, 36, 1, '2017-09-04 10:31:09', 0, NULL, NULL, NULL, 2, '2089287.64', '', '0000-00-00', '', '', '', '0'),
(111, '3', '1', 1, 'dep', '100', NULL, 36, 1, '2017-09-04 10:33:15', 0, NULL, NULL, NULL, 3, '2089587.64', '', '0000-00-00', '', '', '', '0'),
(112, '4', '1', 1, 'dep', '50', NULL, 36, 1, '2017-09-04 10:46:29', 0, NULL, NULL, NULL, 4, '2089687.64', '', '1970-01-01', '', '', '', '0'),
(113, '4', '1', 1, 'dep', '400', NULL, 36, 1, '2017-09-04 10:46:29', 0, NULL, NULL, NULL, 4, '2089737.64', '', '0000-00-00', '', '', '', '0'),
(114, '5', '1', 1, 'dep', '1230', NULL, 36, 1, '2017-09-04 10:47:56', 1, NULL, NULL, NULL, 5, '2090137.64', '', '0000-00-00', '', '', '', '0'),
(115, '6', '1', 1, 'dep', '1180', NULL, 36, 1, '2017-09-04 10:57:00', 0, NULL, NULL, NULL, 6, '2091367.64', '', '0000-00-00', '', '', '', '0'),
(116, '7', '1', 1, 'dep', '200', NULL, 36, 1, '2017-09-04 10:59:42', 0, NULL, NULL, NULL, 7, '2092547.64', '', '0000-00-00', '', '', '', '0'),
(117, '8', '1', 1, 'dep', '640', NULL, 36, 1, '2017-09-04 11:06:59', 1, NULL, NULL, NULL, 8, '2092747.64', '', '1970-01-01', '', '', '', '0'),
(118, '9', '1', 1, 'dep', '20', NULL, 36, 1, '2017-09-04 11:10:08', 1, NULL, NULL, NULL, 9, '2093387.64', '', '1970-01-01', '', '', '', '0'),
(119, '10', '1', 1, 'dep', '460', NULL, 36, 1, '2017-09-04 11:10:43', 0, NULL, NULL, NULL, 10, '2093407.64', '', '0000-00-00', '', '', '', '0'),
(120, '11', '1', 1, 'dep', '60', NULL, 36, 1, '2017-09-04 13:00:19', 1, NULL, NULL, NULL, 11, '2093867.64', '', '0000-00-00', '', '', '', '0'),
(121, '12', '1', 1, 'dep', '270', NULL, 36, 1, '2017-09-06 07:33:23', 0, NULL, NULL, NULL, 12, '2093927.64', '', '0000-00-00', '', '', '', '0'),
(122, '13', '1', 1, 'dep', '140', NULL, 36, 1, '2017-09-06 07:34:16', 0, NULL, NULL, NULL, 13, '2094197.64', '', '0000-00-00', '', '', '', '0'),
(123, '13', '3', 1, 'dep', '40', NULL, 36, 1, '2017-09-06 07:34:16', 0, NULL, NULL, NULL, 13, '153589.80', '', '0000-00-00', '', '', '13546', '0'),
(124, '13', '1', 1, 'dep', '20', NULL, 36, 1, '2017-09-06 07:34:16', 0, NULL, NULL, NULL, 13, '2094337.64', '', '0000-00-00', '', '', '', '0'),
(125, '', '6', 1, 'dep', '2500', NULL, 36, 0, '2017-09-06 08:01:31', NULL, NULL, NULL, NULL, 0, '15681440.44', '', '0000-00-00', '', '', '', '0'),
(126, '14', '1', 1, 'dep', '30', NULL, 36, 1, '2017-09-06 08:08:30', 0, NULL, NULL, NULL, 14, '2094357.64', '', '0000-00-00', '', '', '', '0'),
(127, '15', '1', 1, 'dep', '31', NULL, 36, 1, '2017-09-06 08:26:19', 0, NULL, NULL, NULL, 15, '2094387.64', '', '0000-00-00', '', '', '', '0'),
(128, '16', '1', 1, 'dep', '64', NULL, 36, 1, '2017-09-06 08:27:07', 0, NULL, NULL, NULL, 16, '2094418.64', '', '0000-00-00', '', '', '', '0'),
(129, '17', '1', 1, 'dep', '298', NULL, 36, 1, '2017-09-06 09:51:48', NULL, NULL, NULL, NULL, 0, '2094482.64', '', '1970-01-01', '', '', '', '0'),
(130, '18', '1', 1, 'dep', '7628.06', NULL, 36, 1, '2017-09-06 10:57:17', 0, NULL, NULL, NULL, 17, '2094780.64', '', '0000-00-00', '', '', '', '0'),
(131, '19', '1', 1, 'dep', '1694', NULL, 36, 1, '2017-09-06 11:16:03', 0, NULL, NULL, NULL, 18, '2102408.70', '', '0000-00-00', '', '', '', '0'),
(132, '20', '1', 1, '', '110', NULL, 36, 241, '2017-09-06 12:32:19', NULL, NULL, NULL, NULL, 0, '2104102.70', '', '1970-01-01', '', '', '', '0'),
(133, '21', '1', 1, 'dep', '4750', NULL, 36, 1, '2017-09-06 12:33:37', 0, NULL, NULL, NULL, 19, '2104212.70', '', '0000-00-00', '', '', '', '0'),
(134, '21', '6', 1, 'dep', '200', NULL, 36, 241, '2017-09-06 12:33:37', 0, NULL, NULL, NULL, 19, '15683940.44', '', '0000-00-00', '', '', '', '0'),
(135, '22', '1', 1, '', '660', NULL, 36, 1, '2017-09-08 04:41:57', NULL, NULL, NULL, NULL, 0, '2108962.70', '', '1970-01-01', '', '', '', '0'),
(136, '23', '1', 1, '', '1188', NULL, 36, 1, '2017-09-08 04:45:05', NULL, NULL, NULL, NULL, 0, '2109622.70', '', '1970-01-01', '', '', '', '0'),
(137, '', '1', 1, 'wd', '2000', NULL, 0, 0, '2017-09-08 07:43:08', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(138, '', '1', 1, 'dep', '2000', NULL, 0, 0, '2017-09-08 07:43:08', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(139, '', '1', 1, 'wd', '2300', NULL, 0, 0, '2017-09-08 09:01:06', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(140, '', '1', 1, 'dep', '2300', NULL, 0, 0, '2017-09-08 09:01:06', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(141, '', '3', 1, 'wd', '250', NULL, 0, 0, '2017-09-08 09:02:12', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(142, '', '1', 1, 'dep', '250', NULL, 0, 0, '2017-09-08 09:02:12', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(143, '', '1', 1, 'wd', '200', NULL, 0, 0, '2017-09-08 09:11:28', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(144, '', '1', 1, 'dep', '200', NULL, 0, 0, '2017-09-08 09:11:28', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(145, '', '1', 1, 'wd', '250', NULL, 0, 0, '2017-09-08 09:29:47', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(146, '', '1', 1, 'dep', '250', NULL, 0, 0, '2017-09-08 09:29:47', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(147, '', '1', 1, 'wd', '250', NULL, 0, 0, '2017-09-08 09:31:30', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(148, '', '1', 1, 'dep', '250', NULL, 0, 0, '2017-09-08 09:31:30', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(149, '', '1', 1, 'wd', '200', NULL, 0, 0, '2017-09-08 09:46:42', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(150, '', '1', 1, 'dep', '200', NULL, 0, 0, '2017-09-08 09:46:42', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(151, '', '1', 1, 'wd', '20', NULL, 0, 0, '2017-09-08 09:48:10', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(152, '', '1', 1, 'dep', '20', NULL, 0, 0, '2017-09-08 09:48:10', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(153, '', '1', 1, 'wd', '130', NULL, 0, 0, '2017-09-08 09:51:36', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(154, '', '1', 1, 'dep', '130', NULL, 0, 0, '2017-09-08 09:51:36', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(155, '', '1', 1, 'wd', '560.7', NULL, 0, 0, '2017-09-08 09:52:00', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(156, '', '1', 1, 'dep', '560.7', NULL, 0, 0, '2017-09-08 09:52:00', NULL, NULL, NULL, NULL, 0, '0.00', '', '0000-00-00', '', '', '', '0'),
(157, '', '1', 1, 'return', '20', NULL, 2, 0, '2017-09-08 11:03:25', NULL, NULL, NULL, NULL, 0, '2108121.40', '', '1970-01-01', '', '', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role_id`, `outlet_id`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`, `status`) VALUES
(1, 'sys@gmail.com', 'abc@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 7, 1, 1, '2017-02-01 03:57:20', 0, '0000-00-00 00:00:00', 1),
(2, 'owner', 'abcd@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 1, 0, 1, '0000-00-00 00:00:00', 36, '2017-08-29 12:43:39', 1),
(3, 'business', 'business@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 3, 1, 36, '2017-08-14 10:49:47', 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE IF NOT EXISTS `user_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_datetime` datetime NOT NULL,
  `updated_user_id` int(11) NOT NULL,
  `updated_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `name`, `created_user_id`, `created_datetime`, `updated_user_id`, `updated_datetime`) VALUES
(1, 'Administrator', 1, '2016-08-16 00:00:00', 0, '0000-00-00 00:00:00'),
(2, 'Manager', 1, '2016-08-16 00:00:00', 0, '0000-00-00 00:00:00'),
(3, 'Sales Person', 1, '2016-08-16 00:00:00', 0, '0000-00-00 00:00:00'),
(4, 'Super Manager', 1, '2017-01-12 05:12:30', 0, '0000-00-00 00:00:00'),
(6, 'Customer', 1, '2017-01-30 00:00:00', 1, '2017-01-30 00:00:00'),
(7, 'System Admin', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(8, 'Staff', 1, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `wastage_product_gold`
--

CREATE TABLE IF NOT EXISTS `wastage_product_gold` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `wastage_product_gold_backup`
--

CREATE TABLE IF NOT EXISTS `wastage_product_gold_backup` (
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

-- --------------------------------------------------------

--
-- Table structure for table `work_job_order`
--

CREATE TABLE IF NOT EXISTS `work_job_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` date NOT NULL,
  `job_order_no` int(50) NOT NULL,
  `outlet_id` int(50) NOT NULL,
  `gold_smith_id` int(50) NOT NULL,
  `customer_order_no` varchar(200) NOT NULL,
  `product_code_id` varchar(100) NOT NULL,
  `product_qty` int(50) NOT NULL,
  `weight_bluk_store_product` int(50) NOT NULL,
  `weight_each_product` int(50) NOT NULL,
  `qty` int(20) NOT NULL,
  `item_details` varchar(200) NOT NULL,
  `gold_qty_goldsmith` int(50) NOT NULL,
  `alloy_qty_goldsmith` int(50) NOT NULL,
  `order_delivery_date` date NOT NULL,
  `created_user_id` int(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
