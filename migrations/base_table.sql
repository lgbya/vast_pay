/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : payment

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-05-14 16:59:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `p_admin`
-- ----------------------------
DROP TABLE IF EXISTS `p_admin`;
CREATE TABLE `p_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) unsigned NOT NULL DEFAULT '10',
  `pre_login_at` int(11) unsigned NOT NULL DEFAULT '0',
  `pre_login_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_admin
-- ----------------------------

-- ----------------------------
-- Table structure for `p_admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `p_admin_log`;
CREATE TABLE `p_admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0',
  `admin_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `admin_agent` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_admin_log
-- ----------------------------

-- ----------------------------
-- Table structure for `p_auth_assignment`
-- ----------------------------
DROP TABLE IF EXISTS `p_auth_assignment`;
CREATE TABLE `p_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  KEY `p_idx-auth_assignment-user_id` (`user_id`),
  CONSTRAINT `p_auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `p_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_auth_assignment
-- ----------------------------

-- ----------------------------
-- Table structure for `p_auth_item`
-- ----------------------------
DROP TABLE IF EXISTS `p_auth_item`;
CREATE TABLE `p_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `p_idx-auth_item-type` (`type`),
  CONSTRAINT `p_auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `p_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_auth_item
-- ----------------------------

-- ----------------------------
-- Table structure for `p_auth_item_child`
-- ----------------------------
DROP TABLE IF EXISTS `p_auth_item_child`;
CREATE TABLE `p_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `p_auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `p_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `p_auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `p_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_auth_item_child
-- ----------------------------

-- ----------------------------
-- Table structure for `p_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `p_auth_rule`;
CREATE TABLE `p_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_auth_rule
-- ----------------------------

-- ----------------------------
-- Table structure for `p_change_user_money_log`
-- ----------------------------
DROP TABLE IF EXISTS `p_change_user_money_log`;
CREATE TABLE `p_change_user_money_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `change_money` decimal(12,3) NOT NULL,
  `before_money` decimal(12,3) unsigned NOT NULL,
  `after_money` decimal(12,3) unsigned NOT NULL,
  `type` tinyint(3) unsigned NOT NULL,
  `extra` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_change_user_money_log
-- ----------------------------

-- ----------------------------
-- Table structure for `p_draw_money_order`
-- ----------------------------
DROP TABLE IF EXISTS `p_draw_money_order`;
CREATE TABLE `p_draw_money_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `sys_order_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receipt_number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` int(11) unsigned DEFAULT '0',
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned DEFAULT '0',
  `success_at` int(11) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `sys_order_id` (`sys_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_draw_money_order
-- ----------------------------

-- ----------------------------
-- Table structure for `p_email_code`
-- ----------------------------
DROP TABLE IF EXISTS `p_email_code`;
CREATE TABLE `p_email_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_email_code
-- ----------------------------

-- ----------------------------
-- Table structure for `p_menu`
-- ----------------------------
DROP TABLE IF EXISTS `p_menu`;
CREATE TABLE `p_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` blob,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `p_menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `p_menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of p_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `p_migration`
-- ----------------------------
DROP TABLE IF EXISTS `p_migration`;
CREATE TABLE `p_migration` (
  `version` varchar(180) COLLATE utf8mb4_bin NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_migration
-- ----------------------------
INSERT INTO `p_migration` VALUES ('m000000_000000_base', '1589446710');
INSERT INTO `p_migration` VALUES ('m140506_102106_rbac_init', '1589446712');
INSERT INTO `p_migration` VALUES ('m170907_052038_rbac_add_index_on_auth_assignment_user_id', '1589446712');
INSERT INTO `p_migration` VALUES ('m180523_151638_rbac_updates_indexes_without_prefix', '1589446713');
INSERT INTO `p_migration` VALUES ('m200409_110543_rbac_update_mssql_trigger', '1589446713');
INSERT INTO `p_migration` VALUES ('m200514_035402_create_admin_log', '1589446713');
INSERT INTO `p_migration` VALUES ('m200514_054507_create_admin', '1589446713');
INSERT INTO `p_migration` VALUES ('m200514_054653_create_change_user_money_log', '1589446714');
INSERT INTO `p_migration` VALUES ('m200514_054714_create_draw_money_order', '1589446714');
INSERT INTO `p_migration` VALUES ('m200514_054741_create_email_code', '1589446715');
INSERT INTO `p_migration` VALUES ('m200514_054757_create_menu', '1589446715');
INSERT INTO `p_migration` VALUES ('m200514_054815_create_pay_channel', '1589446715');
INSERT INTO `p_migration` VALUES ('m200514_054830_create_pay_channel_account', '1589446716');
INSERT INTO `p_migration` VALUES ('m200514_054846_create_pay_order', '1589446717');
INSERT INTO `p_migration` VALUES ('m200514_054901_create_product', '1589446717');
INSERT INTO `p_migration` VALUES ('m200514_054917_create_user', '1589446717');
INSERT INTO `p_migration` VALUES ('m200514_054934_create_user_to_pay_channel', '1589446717');

-- ----------------------------
-- Table structure for `p_pay_channel`
-- ----------------------------
DROP TABLE IF EXISTS `p_pay_channel`;
CREATE TABLE `p_pay_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `profit_rate` int(11) unsigned NOT NULL DEFAULT '0',
  `cost_rate` int(11) unsigned NOT NULL DEFAULT '0',
  `weight` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `request_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `code` (`code`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_pay_channel
-- ----------------------------

-- ----------------------------
-- Table structure for `p_pay_channel_account`
-- ----------------------------
DROP TABLE IF EXISTS `p_pay_channel_account`;
CREATE TABLE `p_pay_channel_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pay_channel_id` int(11) unsigned NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `appid` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `md5_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `private_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `public_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `extra` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `weight` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pay_channel_id` (`pay_channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_pay_channel_account
-- ----------------------------

-- ----------------------------
-- Table structure for `p_pay_order`
-- ----------------------------
DROP TABLE IF EXISTS `p_pay_order`;
CREATE TABLE `p_pay_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) unsigned NOT NULL,
  `pay_channel_id` int(11) unsigned NOT NULL,
  `pay_channel_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_channel_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_channel_account_extra` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `md5_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `public_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `private_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `user_account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sys_order_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_order_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `supplier_order_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `profit_rate` int(11) unsigned NOT NULL DEFAULT '0',
  `cost_rate` int(11) unsigned NOT NULL DEFAULT '0',
  `pay_money` int(11) unsigned NOT NULL,
  `user_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `cost_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `profit_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `inform_num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_notify_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_callback_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_extra_field` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_sign_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'md5',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  `notify_at` int(11) unsigned NOT NULL DEFAULT '0',
  `success_at` int(11) unsigned NOT NULL DEFAULT '0',
  `query_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sys_order_id` (`sys_order_id`),
  KEY `user_id` (`user_id`),
  KEY `user_order_id` (`user_order_id`,`user_id`),
  KEY `supplier_order_id` (`supplier_order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_pay_order
-- ----------------------------

-- ----------------------------
-- Table structure for `p_product`
-- ----------------------------
DROP TABLE IF EXISTS `p_product`;
CREATE TABLE `p_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_product
-- ----------------------------

-- ----------------------------
-- Table structure for `p_user`
-- ----------------------------
DROP TABLE IF EXISTS `p_user`;
CREATE TABLE `p_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pay_password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pay_md5_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `money` decimal(12,3) NOT NULL DEFAULT '0.000',
  `status` smallint(6) unsigned NOT NULL DEFAULT '10',
  `pre_login_at` int(11) unsigned NOT NULL DEFAULT '0',
  `pre_login_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_user
-- ----------------------------

-- ----------------------------
-- Table structure for `p_user_to_pay_channel`
-- ----------------------------
DROP TABLE IF EXISTS `p_user_to_pay_channel`;
CREATE TABLE `p_user_to_pay_channel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `pay_channel_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`pay_channel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_user_to_pay_channel
-- ----------------------------
