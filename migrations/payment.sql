/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : payment

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-05-14 11:41:09
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
  `pre_login_at` int(10) unsigned NOT NULL,
  `pre_login_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_admin
-- ----------------------------
INSERT INTO `p_admin` VALUES ('1', 'admin', 'eb2ceSlO_HduMj9dQWzk9rPJt2P0L-bJ', '$2y$13$X1i.6iOS61RMBKjAItz.8uAyVeaH7EiEJOqgs8ozvj7UM5rSkIe1W', '_N78d_egne3rxC-OPuCblPSXO8yZPJgK_1586831793', '1589427074', '127.0.0.1', 'test@test.com', '10', '1586831793', '1589427074');

-- ----------------------------
-- Table structure for `p_admin_log`
-- ----------------------------
DROP TABLE IF EXISTS `p_admin_log`;
CREATE TABLE `p_admin_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `route` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `created_at` int(10) NOT NULL,
  `admin_id` int(10) NOT NULL DEFAULT '0',
  `admin_ip` char(15) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `admin_agent` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `admin_name` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

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
INSERT INTO `p_auth_assignment` VALUES ('超级管理员', '1', '1587026853');

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
INSERT INTO `p_auth_item` VALUES ('/*', '2', null, null, null, '1487816675', '1487816675');
INSERT INTO `p_auth_item` VALUES ('/admin-log/index', '2', null, null, null, '1589424850', '1589424850');
INSERT INTO `p_auth_item` VALUES ('/admin/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/assignment/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/assignment/assign', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/assignment/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/assignment/revoke', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/assignment/view', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/default/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/default/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/menu/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/menu/create', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/menu/delete', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/menu/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/menu/update', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/menu/view', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/assign', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/create', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/delete', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/remove', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/update', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/permission/view', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/assign', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/create', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/delete', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/remove', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/update', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/role/view', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/route/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/route/assign', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/route/create', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/route/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/route/refresh', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/route/remove', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/rule/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/rule/create', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/rule/delete', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/rule/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/rule/update', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/rule/view', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/activate', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/change-password', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/delete', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/login', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/logout', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/request-password-reset', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/reset-password', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/signup', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/admin/user/view', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/batch/*', '2', null, null, null, '1487839853', '1487839853');
INSERT INTO `p_auth_item` VALUES ('/batch/cruds', '2', null, null, null, '1487839853', '1487839853');
INSERT INTO `p_auth_item` VALUES ('/batch/index', '2', null, null, null, '1487839853', '1487839853');
INSERT INTO `p_auth_item` VALUES ('/batch/models', '2', null, null, null, '1487839853', '1487839853');
INSERT INTO `p_auth_item` VALUES ('/change-user-money-log/index', '2', null, null, null, '1588151587', '1588151587');
INSERT INTO `p_auth_item` VALUES ('/data-report/*', '2', null, null, null, '1588919018', '1588919018');
INSERT INTO `p_auth_item` VALUES ('/data-report/product-analyze', '2', null, null, null, '1588919034', '1588919034');
INSERT INTO `p_auth_item` VALUES ('/draw-money-order/*', '2', null, null, null, '1589349948', '1589349948');
INSERT INTO `p_auth_item` VALUES ('/draw-money-order/index', '2', null, null, null, '1589349930', '1589349930');
INSERT INTO `p_auth_item` VALUES ('/draw-money-order/update', '2', null, null, null, '1589349942', '1589349942');
INSERT INTO `p_auth_item` VALUES ('/draw-money-order/view', '2', null, null, null, '1589349936', '1589349936');
INSERT INTO `p_auth_item` VALUES ('/gii/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/gii/default/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/gii/default/action', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/gii/default/diff', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/gii/default/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/gii/default/preview', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/gii/default/view', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/pay-channel/*', '2', null, null, null, '1587118471', '1587118471');
INSERT INTO `p_auth_item` VALUES ('/pay-channel/create', '2', null, null, null, '1587118493', '1587118493');
INSERT INTO `p_auth_item` VALUES ('/pay-channel/delete', '2', null, null, null, '1587118512', '1587118512');
INSERT INTO `p_auth_item` VALUES ('/pay-channel/index', '2', null, null, null, '1587118481', '1587118481');
INSERT INTO `p_auth_item` VALUES ('/pay-channel/recycle-bin', '2', null, null, null, '1587376380', '1587376380');
INSERT INTO `p_auth_item` VALUES ('/pay-channel/update', '2', null, null, null, '1587118507', '1587118507');
INSERT INTO `p_auth_item` VALUES ('/pay-order/correction', '2', null, null, null, '1588150989', '1588150989');
INSERT INTO `p_auth_item` VALUES ('/pay-order/index', '2', null, null, null, '1588150926', '1588150926');
INSERT INTO `p_auth_item` VALUES ('/pay-order/turn-down', '2', null, null, null, '1588151002', '1588151002');
INSERT INTO `p_auth_item` VALUES ('/pay-order/view', '2', null, null, null, '1588150937', '1588150937');
INSERT INTO `p_auth_item` VALUES ('/product/*', '2', null, null, null, '1587026426', '1587026426');
INSERT INTO `p_auth_item` VALUES ('/product/create', '2', null, null, null, '1587026722', '1587026722');
INSERT INTO `p_auth_item` VALUES ('/product/index', '2', null, null, null, '1587026712', '1587026712');
INSERT INTO `p_auth_item` VALUES ('/product/recycle-bin', '2', null, null, null, '1587376391', '1587376391');
INSERT INTO `p_auth_item` VALUES ('/product/update', '2', null, null, null, '1587026732', '1587026732');
INSERT INTO `p_auth_item` VALUES ('/site/*', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/site/error', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/site/index', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/site/login', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/site/logout', '2', null, null, null, '1487816732', '1487816732');
INSERT INTO `p_auth_item` VALUES ('/user/index', '2', null, null, null, '1587972927', '1587972927');
INSERT INTO `p_auth_item` VALUES ('超级管理员', '1', null, null, null, '1487817275', '1487817275');

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
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/assignment/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/assignment/assign');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/assignment/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/assignment/revoke');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/assignment/view');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/default/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/default/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/menu/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/menu/create');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/menu/delete');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/menu/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/menu/update');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/menu/view');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/assign');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/create');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/delete');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/remove');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/update');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/permission/view');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/assign');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/create');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/delete');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/remove');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/update');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/role/view');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/route/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/route/assign');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/route/create');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/route/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/route/refresh');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/route/remove');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/rule/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/rule/create');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/rule/delete');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/rule/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/rule/update');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/rule/view');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/activate');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/change-password');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/delete');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/login');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/logout');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/request-password-reset');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/reset-password');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/signup');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/admin/user/view');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/batch/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/batch/cruds');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/batch/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/batch/models');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/gii/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/gii/default/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/gii/default/action');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/gii/default/diff');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/gii/default/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/gii/default/preview');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/gii/default/view');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/site/*');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/site/error');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/site/index');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/site/login');
INSERT INTO `p_auth_item_child` VALUES ('超级管理员', '/site/logout');

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
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `change_money` decimal(12,3) NOT NULL DEFAULT '0.000',
  `before_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `after_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `extra` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_change_user_money_log
-- ----------------------------
INSERT INTO `p_change_user_money_log` VALUES ('1', '1', '9900.000', '0.000', '9900.000', '3', '1589279385', '1589279385', '12020051218294537692');
INSERT INTO `p_change_user_money_log` VALUES ('2', '1', '9900.000', '9900.000', '19800.000', '3', '1589279525', '1589279525', '12020051218320541533');
INSERT INTO `p_change_user_money_log` VALUES ('3', '1', '9900.000', '19800.000', '29700.000', '3', '1589279621', '1589279621', '12020051218334121522');
INSERT INTO `p_change_user_money_log` VALUES ('4', '1', '9900.000', '29700.000', '39600.000', '3', '1589280112', '1589280112', '12020051218415215585');
INSERT INTO `p_change_user_money_log` VALUES ('5', '1', '9900.000', '39600.000', '49500.000', '3', '1589280287', '1589280287', '12020051218444796988');
INSERT INTO `p_change_user_money_log` VALUES ('6', '1', '9900.000', '49500.000', '59400.000', '3', '1589280685', '1589280685', '12020051218512515842');
INSERT INTO `p_change_user_money_log` VALUES ('7', '1', '9900.000', '59400.000', '69300.000', '3', '1589280696', '1589280696', '12020051218513532975');
INSERT INTO `p_change_user_money_log` VALUES ('8', '1', '9900.000', '69300.000', '79200.000', '3', '1589280761', '1589280761', '12020051218524163662');
INSERT INTO `p_change_user_money_log` VALUES ('9', '1', '9900.000', '79200.000', '89100.000', '3', '1589280783', '1589280783', '12020051218530321078');
INSERT INTO `p_change_user_money_log` VALUES ('10', '1', '9900.000', '89100.000', '99000.000', '3', '1589281065', '1589281065', '12020051218574428474');
INSERT INTO `p_change_user_money_log` VALUES ('11', '1', '9900.000', '99000.000', '108900.000', '3', '1589281068', '1589281068', '12020051218574866857');
INSERT INTO `p_change_user_money_log` VALUES ('12', '1', '9900.000', '108900.000', '118800.000', '3', '1589281121', '1589281121', '12020051218584102302');
INSERT INTO `p_change_user_money_log` VALUES ('13', '1', '9900.000', '118800.000', '128700.000', '3', '1589281125', '1589281125', '12020051218584553832');
INSERT INTO `p_change_user_money_log` VALUES ('14', '1', '9900.000', '128700.000', '138600.000', '3', '1589281127', '1589281127', '12020051218584788529');
INSERT INTO `p_change_user_money_log` VALUES ('15', '1', '9900.000', '138600.000', '148500.000', '3', '1589281129', '1589281129', '12020051218584932329');
INSERT INTO `p_change_user_money_log` VALUES ('16', '1', '9900.000', '148500.000', '158400.000', '3', '1589281132', '1589281132', '12020051218585222268');
INSERT INTO `p_change_user_money_log` VALUES ('17', '1', '9900.000', '158400.000', '168300.000', '3', '1589281198', '1589281198', '12020051218595808887');
INSERT INTO `p_change_user_money_log` VALUES ('18', '1', '9900.000', '168300.000', '178200.000', '3', '1589281228', '1589281228', '12020051219002823048');
INSERT INTO `p_change_user_money_log` VALUES ('19', '1', '9900.000', '178200.000', '188100.000', '3', '1589281312', '1589281312', '12020051219015296542');
INSERT INTO `p_change_user_money_log` VALUES ('20', '1', '9900.000', '188100.000', '198000.000', '3', '1589281408', '1589281408', '12020051219032804845');
INSERT INTO `p_change_user_money_log` VALUES ('21', '1', '9900.000', '198000.000', '207900.000', '3', '1589281436', '1589281436', '12020051219035604725');
INSERT INTO `p_change_user_money_log` VALUES ('22', '1', '9900.000', '207900.000', '217800.000', '3', '1589281815', '1589281815', '12020051219101565319');
INSERT INTO `p_change_user_money_log` VALUES ('23', '1', '9900.000', '217800.000', '227700.000', '3', '1589334907', '1589334907', '12020051309550759219');
INSERT INTO `p_change_user_money_log` VALUES ('24', '1', '9900.000', '227700.000', '237600.000', '3', '1589334923', '1589334923', '12020051309552352811');
INSERT INTO `p_change_user_money_log` VALUES ('25', '1', '9900.000', '237600.000', '247500.000', '3', '1589336372', '1589336372', '12020051310193267237');
INSERT INTO `p_change_user_money_log` VALUES ('26', '1', '9900.000', '247500.000', '257400.000', '3', '1589336449', '1589336449', '12020051310204933584');
INSERT INTO `p_change_user_money_log` VALUES ('27', '1', '9900.000', '257400.000', '267300.000', '3', '1589336500', '1589336500', '12020051310213955272');
INSERT INTO `p_change_user_money_log` VALUES ('28', '1', '9900.000', '267300.000', '277200.000', '3', '1589336522', '1589336522', '12020051310220276969');
INSERT INTO `p_change_user_money_log` VALUES ('29', '1', '9900.000', '277200.000', '287100.000', '3', '1589336581', '1589336581', '12020051310230156888');
INSERT INTO `p_change_user_money_log` VALUES ('30', '1', '9900.000', '287100.000', '297000.000', '3', '1589336636', '1589336636', '12020051310235672038');
INSERT INTO `p_change_user_money_log` VALUES ('31', '1', '9900.000', '297000.000', '306900.000', '3', '1589336749', '1589336749', '12020051310254972667');
INSERT INTO `p_change_user_money_log` VALUES ('32', '1', '9900.000', '306900.000', '316800.000', '3', '1589336790', '1589336790', '12020051310262973229');
INSERT INTO `p_change_user_money_log` VALUES ('33', '1', '9900.000', '316800.000', '326700.000', '3', '1589336870', '1589336870', '12020051310275067390');
INSERT INTO `p_change_user_money_log` VALUES ('34', '1', '9900.000', '326700.000', '336600.000', '3', '1589336926', '1589336926', '12020051310284642300');
INSERT INTO `p_change_user_money_log` VALUES ('35', '1', '9900.000', '336600.000', '346500.000', '3', '1589336935', '1589336935', '12020051310285413471');
INSERT INTO `p_change_user_money_log` VALUES ('36', '1', '9900.000', '346500.000', '356400.000', '3', '1589336979', '1589336979', '12020051310293804159');
INSERT INTO `p_change_user_money_log` VALUES ('37', '1', '9900.000', '356400.000', '366300.000', '1', '1589349353', '1589349353', '12020051218084046695');
INSERT INTO `p_change_user_money_log` VALUES ('38', '1', '-100.000', '366300.000', '366200.000', '4', '1589350066', '1589350066', '12020051314074607545');
INSERT INTO `p_change_user_money_log` VALUES ('39', '1', '9900.000', '366200.000', '376100.000', '3', '1589427112', '1589427112', '12020051411315195840');

-- ----------------------------
-- Table structure for `p_draw_money_order`
-- ----------------------------
DROP TABLE IF EXISTS `p_draw_money_order`;
CREATE TABLE `p_draw_money_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `sys_order_id` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `account_number` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `receipt_number` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `money` int(11) NOT NULL,
  `remark` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `success_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_draw_money_order
-- ----------------------------
INSERT INTO `p_draw_money_order` VALUES ('1', '1', '12020051314074607545', '123456', '123456', '', '100', '', '0', '1589350066', '1589350066', '0');

-- ----------------------------
-- Table structure for `p_email_code`
-- ----------------------------
DROP TABLE IF EXISTS `p_email_code`;
CREATE TABLE `p_email_code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of p_menu
-- ----------------------------
INSERT INTO `p_menu` VALUES ('1', '管理设置', null, null, '100', 0x636F67);
INSERT INTO `p_menu` VALUES ('2', '菜单列表', '1', '/admin/menu/index', '1', 0x62617273);
INSERT INTO `p_menu` VALUES ('3', '角色列表', '1', '/admin/role/index', '2', 0x7573657273);
INSERT INTO `p_menu` VALUES ('4', '管理员列表', '1', '/admin/user/index', '3', 0x75736572);
INSERT INTO `p_menu` VALUES ('5', '权限列表', '1', '/admin/permission/index', '6', 0x6C6F636B);
INSERT INTO `p_menu` VALUES ('6', '路由列表', '1', '/admin/route/index', '4', 0x696E7465726E65742D6578706C6F726572);
INSERT INTO `p_menu` VALUES ('7', '规则列表', '1', '/admin/rule/index', '5', 0x6C697374);
INSERT INTO `p_menu` VALUES ('8', '分配权限', '1', '/admin/assignment/index', '7', 0x756E6C6F636B);
INSERT INTO `p_menu` VALUES ('9', '产品管理', null, null, '3', 0x70726F647563742D68756E74);
INSERT INTO `p_menu` VALUES ('10', '产品列表', '9', '/product/index', null, 0x706965642D70697065722D7070);
INSERT INTO `p_menu` VALUES ('11', '支付通道列表', '9', '/pay-channel/index', null, 0x62616E6B20);
INSERT INTO `p_menu` VALUES ('12', '产品回收站', '9', '/product/recycle-bin', null, 0x72656379636C65);
INSERT INTO `p_menu` VALUES ('13', '支付通道回收站', '9', '/pay-channel/recycle-bin', null, 0x72656379636C65);
INSERT INTO `p_menu` VALUES ('14', '用户管理', null, null, '2', 0x7573657273);
INSERT INTO `p_menu` VALUES ('15', '用户列表', '14', '/user/index', null, 0x75736572);
INSERT INTO `p_menu` VALUES ('16', '订单管理', null, null, '4', 0x627269656663617365);
INSERT INTO `p_menu` VALUES ('17', '支付订单列表', '16', '/pay-order/index', null, 0x72656F7264657220);
INSERT INTO `p_menu` VALUES ('18', '用户资金日志', '16', '/change-user-money-log/index', null, 0x726D62);
INSERT INTO `p_menu` VALUES ('19', '数据分析', null, null, '99', 0x6C696E652D6368617274);
INSERT INTO `p_menu` VALUES ('20', '网站管理', null, null, '1', 0x6465736B746F70);
INSERT INTO `p_menu` VALUES ('21', '服务器信息', '20', '/site/index', null, 0x736572766572);
INSERT INTO `p_menu` VALUES ('22', '产品分析', '19', '/data-report/product-analyze', '99', 0x617265612D6368617274);
INSERT INTO `p_menu` VALUES ('23', '提款订单列表', '16', '/draw-money-order/index', null, 0x62616E6B);
INSERT INTO `p_menu` VALUES ('24', '管理员日志', '20', '/admin-log/index', null, 0x757365722D636972636C652D6F);

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
INSERT INTO `p_migration` VALUES ('m000000_000000_base', '1587958209');

-- ----------------------------
-- Table structure for `p_pay_channel`
-- ----------------------------
DROP TABLE IF EXISTS `p_pay_channel`;
CREATE TABLE `p_pay_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_bin NOT NULL,
  `profit_rate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收取费率，单位:万分之一',
  `cost_rate` int(11) NOT NULL DEFAULT '0' COMMENT '成本费率，单位:万分之一',
  `weight` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '权重',
  `request_url` varchar(255) COLLATE utf8mb4_bin NOT NULL COMMENT '请求url',
  `status` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '状态:1-开启,0-关闭',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_pay_channel
-- ----------------------------
INSERT INTO `p_pay_channel` VALUES ('1', '1', 'demo通道', 'Demo', '10', '10', '100', 'http://www.a.com', '1', '1589266730', '1589266730', '0');

-- ----------------------------
-- Table structure for `p_pay_channel_account`
-- ----------------------------
DROP TABLE IF EXISTS `p_pay_channel_account`;
CREATE TABLE `p_pay_channel_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pay_channel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `account` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `appid` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `md5_key` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `private_key` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `public_key` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `extra` varchar(255) COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `weight` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL,
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pay_channel_id` (`pay_channel_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_pay_channel_account
-- ----------------------------
INSERT INTO `p_pay_channel_account` VALUES ('1', '1', '123456', '123456', '123456', '123456', '123456', '', '123', '1', '1589267202', '1589267202', '0');

-- ----------------------------
-- Table structure for `p_pay_order`
-- ----------------------------
DROP TABLE IF EXISTS `p_pay_order`;
CREATE TABLE `p_pay_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_channel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_channel_code` varchar(255) NOT NULL,
  `pay_channel_account` varchar(255) NOT NULL,
  `pay_channel_account_extra` varchar(255) NOT NULL,
  `md5_key` varchar(255) NOT NULL,
  `public_key` varchar(255) NOT NULL,
  `private_key` varchar(255) NOT NULL,
  `user_id` int(10) NOT NULL,
  `user_account` varchar(255) NOT NULL,
  `sys_order_id` varchar(100) NOT NULL,
  `user_order_id` varchar(100) NOT NULL,
  `supplier_order_id` varchar(100) NOT NULL DEFAULT '',
  `profit_rate` int(11) unsigned NOT NULL DEFAULT '0',
  `cost_rate` int(11) NOT NULL,
  `pay_money` int(11) unsigned NOT NULL DEFAULT '0',
  `user_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `cost_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `profit_money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000',
  `inform_num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_notify_url` varchar(255) NOT NULL,
  `user_callback_url` varchar(255) NOT NULL,
  `user_extra_field` varchar(255) NOT NULL DEFAULT '',
  `user_sign_type` varchar(255) NOT NULL DEFAULT 'md5',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `notify_at` int(10) unsigned NOT NULL DEFAULT '0',
  `success_at` int(10) unsigned NOT NULL DEFAULT '0',
  `query_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of p_pay_order
-- ----------------------------
INSERT INTO `p_pay_order` VALUES ('1', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218084046695', '1589278120', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '5', '1589278120', '1589349353', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('2', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218100162489', '1589278201', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589278201', '1589278201', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('3', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218144507459', '1589278485', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589278485', '1589278485', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('4', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218175925061', '1589278679', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589278679', '1589278679', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('5', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218294537692', '1589279385', '1234567890', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589279385', '1589279385', '1589279385', '0', '0');
INSERT INTO `p_pay_order` VALUES ('6', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218315363431', '1589279513', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589279513', '1589279513', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('7', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218320541533', '1589279525', 'test1589279525', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589279525', '1589279525', '1589279525', '0', '0');
INSERT INTO `p_pay_order` VALUES ('8', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218334121522', '1589279621', 'test1589279621', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589279621', '1589279621', '1589279621', '0', '0');
INSERT INTO `p_pay_order` VALUES ('9', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218415215585', '1589280112', 'test1589280112', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589280112', '1589280112', '1589280112', '0', '0');
INSERT INTO `p_pay_order` VALUES ('10', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218444796988', '1589280287', 'test1589280287', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589280287', '1589280287', '1589280287', '0', '0');
INSERT INTO `p_pay_order` VALUES ('11', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218512515842', '1589280685', 'test1589280685', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589280685', '1589280685', '1589280685', '0', '0');
INSERT INTO `p_pay_order` VALUES ('12', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218513532975', '1589280695', 'test1589280696', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589280695', '1589280696', '1589280696', '0', '0');
INSERT INTO `p_pay_order` VALUES ('13', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218524163662', '1589280761', 'test1589280761', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589280761', '1589280761', '1589280761', '0', '0');
INSERT INTO `p_pay_order` VALUES ('14', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218530321078', '1589280783', 'test1589280783', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589280783', '1589280783', '1589280783', '0', '0');
INSERT INTO `p_pay_order` VALUES ('15', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218573884409', '1589281058', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589281058', '1589281058', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('16', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218574428474', '1589281064', 'test1589281064', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281064', '1589281065', '1589281065', '0', '0');
INSERT INTO `p_pay_order` VALUES ('17', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218574866857', '1589281068', 'test1589281068', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281068', '1589281068', '1589281068', '0', '0');
INSERT INTO `p_pay_order` VALUES ('18', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218575129851', '1589281070', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589281071', '1589281071', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('19', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218584102302', '1589281121', 'test1589281121', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281121', '1589281121', '1589281121', '0', '0');
INSERT INTO `p_pay_order` VALUES ('20', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218584553832', '1589281125', 'test1589281125', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281125', '1589281125', '1589281125', '0', '0');
INSERT INTO `p_pay_order` VALUES ('21', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218584788529', '1589281127', 'test1589281127', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281127', '1589281127', '1589281127', '0', '0');
INSERT INTO `p_pay_order` VALUES ('22', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218584932329', '1589281129', 'test1589281129', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281129', '1589281129', '1589281129', '0', '0');
INSERT INTO `p_pay_order` VALUES ('23', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218585222268', '1589281132', 'test1589281132', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281132', '1589281132', '1589281132', '0', '0');
INSERT INTO `p_pay_order` VALUES ('24', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218591103199', '1589281151', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589281151', '1589281151', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('25', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218595642794', '1589281195', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589281196', '1589281196', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('26', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051218595808887', '1589281198', 'test1589281198', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281198', '1589281198', '1589281198', '0', '0');
INSERT INTO `p_pay_order` VALUES ('27', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051219002823048', '1589281228', 'test1589281228', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281228', '1589281228', '1589281228', '0', '0');
INSERT INTO `p_pay_order` VALUES ('28', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051219003381338', '1589281232', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589281233', '1589281233', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('29', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051219015296542', '1589281312', 'test1589281312', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281312', '1589281312', '1589281312', '0', '0');
INSERT INTO `p_pay_order` VALUES ('30', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051219032804845', '1589281408', 'test1589281408', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281408', '1589281408', '1589281408', '0', '0');
INSERT INTO `p_pay_order` VALUES ('31', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051219035604725', '1589281436', 'test1589281436', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281436', '1589281436', '1589281436', '0', '0');
INSERT INTO `p_pay_order` VALUES ('32', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051219093373551', '1589281773', '', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '0', '1589281773', '1589281773', '0', '0', '0');
INSERT INTO `p_pay_order` VALUES ('33', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051219101565319', '1589281815', 'test1589281815', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589281815', '1589281815', '1589281815', '0', '0');
INSERT INTO `p_pay_order` VALUES ('34', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051309550759219', '1589334907', 'test1589334907', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589334907', '1589334907', '1589334907', '0', '0');
INSERT INTO `p_pay_order` VALUES ('35', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051309552352811', '1589334923', 'test1589334923', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589334923', '1589334923', '1589334923', '0', '0');
INSERT INTO `p_pay_order` VALUES ('36', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310193267237', '1589336372', 'test1589336372', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336372', '1589336372', '1589336372', '0', '0');
INSERT INTO `p_pay_order` VALUES ('37', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310204933584', '1589336448', 'test1589336449', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336449', '1589336449', '1589336449', '0', '0');
INSERT INTO `p_pay_order` VALUES ('38', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310213955272', '1589336499', 'test1589336500', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336499', '1589336500', '1589336500', '0', '0');
INSERT INTO `p_pay_order` VALUES ('39', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310220276969', '1589336522', 'test1589336522', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336522', '1589336522', '1589336522', '0', '0');
INSERT INTO `p_pay_order` VALUES ('40', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310230156888', '1589336581', 'test1589336581', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336581', '1589336581', '1589336581', '0', '0');
INSERT INTO `p_pay_order` VALUES ('41', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310235672038', '1589336635', 'test1589336636', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336636', '1589336636', '1589336636', '0', '0');
INSERT INTO `p_pay_order` VALUES ('42', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310254972667', '1589336749', 'test1589336749', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336749', '1589336749', '1589336749', '0', '0');
INSERT INTO `p_pay_order` VALUES ('43', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310262973229', '1589336789', 'test1589336790', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336789', '1589336790', '1589336790', '0', '0');
INSERT INTO `p_pay_order` VALUES ('44', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310275067390', '1589336869', 'test1589336870', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336870', '1589336870', '1589336870', '0', '0');
INSERT INTO `p_pay_order` VALUES ('45', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310284642300', '1589336926', 'test1589336926', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336926', '1589336926', '1589336926', '0', '0');
INSERT INTO `p_pay_order` VALUES ('46', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310285413471', '1589336934', 'test1589336935', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336934', '1589336935', '1589336935', '0', '0');
INSERT INTO `p_pay_order` VALUES ('47', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051310293804159', '1589336978', 'test1589336978', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589336978', '1589336979', '1589336979', '0', '0');
INSERT INTO `p_pay_order` VALUES ('48', '1', '1', 'Demo', '123456', '', '123456', '123456', '123456', '1', '3LqeO20200512145618', '12020051411315195840', '1589427111', 'test1589427112', '10', '10', '10000', '9900.000', '100.000', '100.000', '0', 'http://www.bbb.com', 'http://www.bbb.com', '', 'md5', '1', '1589427111', '1589427112', '1589427112', '0', '0');

-- ----------------------------
-- Table structure for `p_product`
-- ----------------------------
DROP TABLE IF EXISTS `p_product`;
CREATE TABLE `p_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT '支付产品名',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  `is_del` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of p_product
-- ----------------------------
INSERT INTO `p_product` VALUES ('1', '测试支付1', '1', '1589266681', '1589266681', '0');
INSERT INTO `p_product` VALUES ('2', '测试支付2', '1', '1589422478', '1589422478', '0');

-- ----------------------------
-- Table structure for `p_user`
-- ----------------------------
DROP TABLE IF EXISTS `p_user`;
CREATE TABLE `p_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `password_reset_token` varchar(256) DEFAULT NULL,
  `pay_password_hash` varchar(256) NOT NULL,
  `pay_password_reset_token` varchar(256) DEFAULT NULL,
  `email` varchar(256) NOT NULL,
  `account` varchar(255) NOT NULL COMMENT '账号',
  `pay_md5_key` varchar(255) NOT NULL,
  `money` decimal(12,3) unsigned NOT NULL DEFAULT '0.000' COMMENT '现金,单位:分',
  `status` int(11) NOT NULL DEFAULT '10',
  `pre_login_ip` varchar(255) NOT NULL DEFAULT '',
  `pre_login_at` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of p_user
-- ----------------------------
INSERT INTO `p_user` VALUES ('1', 'demo', 'Hz26a-IM-SB0vonQen9pN43DwQUbhp-Y', '$2y$13$PuMu8nWAVU/gDYFBjSk5aesVtdEd2lt8ZrP0wNwx4DT5DEwSo/F26', 'q2hzuPbyL9IsSiZWEbUa21bm26BlYgSW_1589266577', '$2y$13$/OjUyUZ9Qbi9Rf3QKmb4KOgbj0/qVu0fLEWLgbaKtRnjw7Zsmzos.', '3d6IwRQoO4f_XjTvIIlKbmUCXnOGu4hB_1589266577', 'demo@a.com', '3LqeO20200512145618', 'd02521f72e0b9367ec9067976e803dab', '376100.000', '10', '', '1589267819', '1589266577', '1589267819');
INSERT INTO `p_user` VALUES ('2', 'lgbya', 'PhGmfTfrWuPR7fZUIUrYGM7BHN1j_E1M', '$2y$13$zzOyIYDmBpXtaLV1zFWoHeS7nY0.x2nv0VzZs75QPPnQ5XvmPdM7W', '0v3erd6V38ty3oRMRwguESM-dLbB3nMv_1589362203', '$2y$13$101b2F8KkQiFhAgEnjqDMeGX4YmHHyCv..HBoI7qMfgWbjwxLvzyK', '24hNQM8g8i5zCP2DCbnf3YcEEwVqPvQ0_1589362204', '1105882406@qq.com', 'eO0BK20200513173006', '8ca8dd96041c24fc716d1b04f792339b', '0.000', '10', '', '1589365006', '1589362204', '1589365006');

-- ----------------------------
-- Table structure for `p_user_to_pay_channel`
-- ----------------------------
DROP TABLE IF EXISTS `p_user_to_pay_channel`;
CREATE TABLE `p_user_to_pay_channel` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pay_channel_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `pay_channel_id` (`pay_channel_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_user_to_pay_channel
-- ----------------------------
INSERT INTO `p_user_to_pay_channel` VALUES ('1', '1', '1', '1589267800', '1589267800');
