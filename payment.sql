/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : payment

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-04-30 18:13:04
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
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of p_admin
-- ----------------------------
INSERT INTO `p_admin` VALUES ('1', 'admin', 'eb2ceSlO_HduMj9dQWzk9rPJt2P0L-bJ', '$2y$13$X1i.6iOS61RMBKjAItz.8uAyVeaH7EiEJOqgs8ozvj7UM5rSkIe1W', '_N78d_egne3rxC-OPuCblPSXO8yZPJgK_1586831793', 'test@test.com', '10', '1586831793', '1586831793');

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
  `change_money` int(11) NOT NULL DEFAULT '0',
  `before_money` int(10) unsigned NOT NULL DEFAULT '0',
  `after_money` int(10) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `extra` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_change_user_money_log
-- ----------------------------
INSERT INTO `p_change_user_money_log` VALUES ('17', '2', '11111', '0', '11111', '1', '1588147210', '1588147210', '12345678901234567890');
INSERT INTO `p_change_user_money_log` VALUES ('18', '2', '-11111', '11111', '0', '2', '1588147519', '1588147519', '12345678901234567890');
INSERT INTO `p_change_user_money_log` VALUES ('19', '2', '11111', '0', '11111', '1', '1588148573', '1588148573', '12345678901234567890');
INSERT INTO `p_change_user_money_log` VALUES ('20', '2', '-11111', '11111', '0', '2', '1588148579', '1588148579', '12345678901234567890');
INSERT INTO `p_change_user_money_log` VALUES ('21', '1', '11111', '0', '11111', '1', '1588148645', '1588148645', '12345678901234567890');
INSERT INTO `p_change_user_money_log` VALUES ('22', '1', '-11111', '11111', '0', '2', '1588148706', '1588148706', '12345678901234567890');
INSERT INTO `p_change_user_money_log` VALUES ('23', '1', '11111', '0', '11111', '1', '1588148711', '1588148711', '12345678901234567890');

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

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
INSERT INTO `p_menu` VALUES ('9', '产品管理', null, null, '100', 0x70726F647563742D68756E74);
INSERT INTO `p_menu` VALUES ('10', '产品列表', '9', '/product/index', null, 0x706965642D70697065722D7070);
INSERT INTO `p_menu` VALUES ('11', '支付通道列表', '9', '/pay-channel/index', null, 0x62616E6B20);
INSERT INTO `p_menu` VALUES ('12', '产品回收站', '9', '/product/recycle-bin', null, 0x72656379636C65);
INSERT INTO `p_menu` VALUES ('13', '支付通道回收站', '9', '/pay-channel/recycle-bin', null, 0x72656379636C65);
INSERT INTO `p_menu` VALUES ('14', '用户管理', null, null, '100', 0x7573657273);
INSERT INTO `p_menu` VALUES ('15', '用户列表', '14', '/user/index', null, 0x75736572);
INSERT INTO `p_menu` VALUES ('16', '订单管理', null, null, null, 0x627269656663617365);
INSERT INTO `p_menu` VALUES ('17', '支付订单列表', '16', '/pay-order/index', null, 0x72656F7264657220);
INSERT INTO `p_menu` VALUES ('18', '用户资金日志', '16', '/change-user-money-log/index', null, 0x726D62);
INSERT INTO `p_menu` VALUES ('19', '数据分析', null, null, null, 0x6C696E652D6368617274);

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_pay_channel
-- ----------------------------
INSERT INTO `p_pay_channel` VALUES ('1', '3', 'a2222', '12321', '1', '1', '1', 'http://www.a.com', '1', '1587117867', '1588236028', '0');
INSERT INTO `p_pay_channel` VALUES ('2', '5', 'd44', '12', '12321', '312', '31', 'http://www.a.com', '1', '1588039184', '1588236044', '1');
INSERT INTO `p_pay_channel` VALUES ('3', '3', 'a222', '312333', '12321', '312', '31', 'http://www.a.com', '1', '1588039216', '1588235980', '0');
INSERT INTO `p_pay_channel` VALUES ('4', '3', 'a22', 'a2', '1', '1', '1', 'http://www.a.com', '1', '1588044444', '1588235959', '0');
INSERT INTO `p_pay_channel` VALUES ('5', '3', 'a2', '3131', '31', '321', '131', 'http://www.a.com', '1', '1588044493', '1588235937', '0');
INSERT INTO `p_pay_channel` VALUES ('6', '5', 'd4', '31', '31', '321', '31', 'http://www.a.com', '1', '1588044530', '1588236041', '1');
INSERT INTO `p_pay_channel` VALUES ('7', '4', 'd3', '12332333', '31', '31', '32', 'http://www.a.com', '1', '1588044604', '1588236035', '1');

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
INSERT INTO `p_pay_channel_account` VALUES ('1', '1', '3333', '3212', '321', '312', '312', '312', '1', '1587366595', '1587367774', '1');

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
  `user_account` int(10) unsigned NOT NULL,
  `sys_order_id` varchar(100) NOT NULL,
  `user_order_id` varchar(100) NOT NULL,
  `supplier_order_id` varchar(100) NOT NULL,
  `profit_rate` int(11) unsigned NOT NULL DEFAULT '0',
  `cost_rate` int(11) NOT NULL,
  `pay_money` int(11) unsigned NOT NULL DEFAULT '0',
  `user_money` int(11) unsigned NOT NULL DEFAULT '0',
  `cost_money` int(11) unsigned NOT NULL DEFAULT '0',
  `profit_money` int(11) unsigned NOT NULL DEFAULT '0',
  `inform_num` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_notify_url` varchar(255) NOT NULL,
  `user_callback_url` varchar(255) NOT NULL,
  `user_extra_field` varchar(255) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0',
  `notify_time` int(10) unsigned NOT NULL DEFAULT '0',
  `success_time` int(10) unsigned NOT NULL DEFAULT '0',
  `query_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of p_pay_order
-- ----------------------------
INSERT INTO `p_pay_order` VALUES ('1', '4', '2', '213', '13123213214214', '1421421', '42141', '41421', '42141241', '1', '241421421', '12345678901234567890', '12345678901234567890', '12345678901234567890', '111', '111', '111111', '11111', '1111', '11111', '3', '1313131', '3131231', '31231', '5', '0', '0', '0', '0', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of p_product
-- ----------------------------
INSERT INTO `p_product` VALUES ('3', '测试产品2', '0', '1587088514', '1587104640', '0');
INSERT INTO `p_product` VALUES ('4', '测试产品3', '1', '1587106040', '1587106040', '0');
INSERT INTO `p_product` VALUES ('5', '测试产品4', '1', '1587106054', '1587376020', '0');
INSERT INTO `p_product` VALUES ('6', '测试产品5', '1', '1587373410', '1587376027', '1');

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
  `email` varchar(256) NOT NULL,
  `account` varchar(255) NOT NULL COMMENT '账号',
  `pay_md5_key` varchar(255) NOT NULL,
  `money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '现金,单位:分',
  `status` int(11) NOT NULL DEFAULT '10',
  `pre_login_at` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of p_user
-- ----------------------------
INSERT INTO `p_user` VALUES ('1', 'demo', 'eb2ceSlO_HduMj9dQWzk9rPJt2P0L-bJ', '$2y$13$jD0WBG.bp.YGREdhbG3bFuZvy.BbF6yHnoP0r1klY0KyfFXdRA7aq', 'OPuCblPSXO8yZPJgK_1586831793', 'test@test.com', 'abcdefghijklmnopqrstuvwxyz', '10ebebdad7f7f3aa424372942633db8d', '11111', '10', '1588241391', '0', '1588241391');
INSERT INTO `p_user` VALUES ('7', 'demo2', '1I8x_Bg8a2f3AelwzXj-j1aaNK_c2Zdt', '$2y$13$YRgTMvOVrVELCkUoZ.Qb3eOUzoUNwR0UzkleoKIS6ezyf.KJf2ohu', 'yDxRUVVfLzDJkDTGZ4HyGLsRYxkzPpXU_1588212892', 'aaa@a.com', 'qzk2h20200430101454', '10ebebdad7f7f3aa424372942633db8f', '0', '10', '0', '1588212892', '1588212892');
INSERT INTO `p_user` VALUES ('8', 'demo3', 'e9IS3Z6yNUBos1d4bhbI-r8mEaTEPWyZ', '$2y$13$j.lsYcvKPkkRADQr71HO5u90udCiOU6DYtauJwGPpy4tYIWQMFpia', 'VmoV-AeDvv1do9AW5EfPd9wXDmgjEycp_1588213911', 'aaa2@a.com', 'cAaZh20200430103154', '8fafdd316542a68d3794c663bf3a80a8', '0', '1', '0', '1588213911', '1588213911');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- ----------------------------
-- Records of p_user_to_pay_channel
-- ----------------------------
INSERT INTO `p_user_to_pay_channel` VALUES ('4', '1', '1', '1588237754', '1588237754');
INSERT INTO `p_user_to_pay_channel` VALUES ('5', '1', '3', '1588237754', '1588237754');
