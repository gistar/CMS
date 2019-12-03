/*
SQLyog Ultimate v12.08 (32 bit)
MySQL - 10.4.10-MariaDB : Database - data_zhongze
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`data_zhongze` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `data_zhongze`;

/*Table structure for table `admin_department` */

DROP TABLE IF EXISTS `admin_department`;

CREATE TABLE `admin_department` (
  `department_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `department_name` varchar(255) NOT NULL DEFAULT '' COMMENT '部门名称',
  `department_dec` varchar(522) DEFAULT '' COMMENT '部门描述',
  `leader_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '部门领头人id',
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT current_timestamp() COMMENT '更新时间',
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='公司部门(用于数据资源分配时)';

/*Table structure for table `admin_department_users` */

DROP TABLE IF EXISTS `admin_department_users`;

CREATE TABLE `admin_department_users` (
  `department_id` int(10) NOT NULL COMMENT '部门id',
  `user_id` int(10) DEFAULT NULL COMMENT '用户id',
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT current_timestamp() COMMENT '更新时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部门管理人员(一个部门可以拥有多个用户)';

/*Table structure for table `admin_menu` */

DROP TABLE IF EXISTS `admin_menu`;

CREATE TABLE `admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permission` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_operation_log` */

DROP TABLE IF EXISTS `admin_operation_log`;

CREATE TABLE `admin_operation_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_operation_log_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4046 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_permissions` */

DROP TABLE IF EXISTS `admin_permissions`;

CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`),
  UNIQUE KEY `admin_permissions_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_project` */

DROP TABLE IF EXISTS `admin_project`;

CREATE TABLE `admin_project` (
  `project_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `department_id` int(10) unsigned NOT NULL DEFAULT 0,
  `note` varchar(522) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `create_user_id` int(10) NOT NULL DEFAULT 0 COMMENT '创建人',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`project_id`),
  KEY `admin_project_department_id_index` (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_project_enterprise` */

DROP TABLE IF EXISTS `admin_project_enterprise`;

CREATE TABLE `admin_project_enterprise` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '公司名',
  `representative` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '法人代表',
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '公司地址',
  `region` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '所属地区(省)',
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '城市',
  `district` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '区/县',
  `lat_long` varchar(80) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '经纬度，json -> {"lat": "30.18484477830133", "long": "120.06383340659741"}',
  `biz_status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '经营状态',
  `credit_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '统一社会信用代码',
  `register_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '注册号',
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '电话',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '邮箱',
  `setup_time` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-' COMMENT '成立时间',
  `industry` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '所属行业',
  `biz_scope` varchar(1200) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '经营范围',
  `company_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '公司类型',
  `registered_capital` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '注册资本',
  `actual_capital` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '实缴资本',
  `taxpayer_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '纳税人识别号',
  `organization_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '组织机构代码',
  `english_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '公司英文名',
  `authorization` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '登记机关',
  `homepage` varchar(522) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '公司官网',
  `used_name` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '公司曾用名',
  `score` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '评分',
  `other` varchar(522) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '其他',
  `word` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT '-' COMMENT '词源',
  `create_user_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '创建人',
  `order_user_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '成单人',
  `lastediter_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '最后编辑',
  `project_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '项目id',
  `source_id` bigint(20) unsigned NOT NULL DEFAULT 0 COMMENT '企业源头id',
  `contract_fund` decimal(10,2) DEFAULT 0.00 COMMENT '合同金额',
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT '\'-\'' COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT 0 COMMENT '状态0:未跟踪,1:跟踪进行时,2意向客户,3非意向客户,4已成交用户',
  `deleted_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `admin_project_enterprise_project_id_index` (`project_id`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_project_members` */

DROP TABLE IF EXISTS `admin_project_members`;

CREATE TABLE `admin_project_members` (
  `project_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_role_menu` */

DROP TABLE IF EXISTS `admin_role_menu`;

CREATE TABLE `admin_role_menu` (
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_menu_role_id_menu_id_index` (`role_id`,`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_role_permissions` */

DROP TABLE IF EXISTS `admin_role_permissions`;

CREATE TABLE `admin_role_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_permissions_role_id_permission_id_index` (`role_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_role_users` */

DROP TABLE IF EXISTS `admin_role_users`;

CREATE TABLE `admin_role_users` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_role_users_role_id_user_id_index` (`role_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`),
  UNIQUE KEY `admin_roles_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_user_permissions` */

DROP TABLE IF EXISTS `admin_user_permissions`;

CREATE TABLE `admin_user_permissions` (
  `user_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `admin_user_permissions_user_id_permission_id_index` (`user_id`,`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `city` */

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `city_id` varchar(12) DEFAULT NULL,
  `province_id` varchar(12) DEFAULT NULL,
  `spell` char(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `country` */

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `country_id` varchar(12) DEFAULT NULL,
  `city_id` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `customer_pool` */

DROP TABLE IF EXISTS `customer_pool`;

CREATE TABLE `customer_pool` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company` varchar(255) DEFAULT '',
  `legaler` varchar(255) DEFAULT '',
  `email` char(255) DEFAULT '',
  `tel` char(60) DEFAULT '',
  `website` varchar(522) DEFAULT '',
  `province` varchar(12) DEFAULT '',
  `city` varchar(12) DEFAULT '',
  `country` varchar(12) DEFAULT '',
  `reg_real` varchar(225) DEFAULT '',
  `create` datetime DEFAULT NULL,
  `type` varchar(120) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `business` varchar(522) DEFAULT '',
  `source` varchar(255) DEFAULT '',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `emaillog` */

DROP TABLE IF EXISTS `emaillog`;

CREATE TABLE `emaillog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `templateid` int(10) unsigned NOT NULL,
  `status` enum('presend','sending','sended','sendwar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `service` mediumint(8) unsigned NOT NULL,
  `sender` int(10) unsigned NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `openstatus` enum('unknow','received','unopened','opened') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `emailtemplate` */

DROP TABLE IF EXISTS `emailtemplate`;

CREATE TABLE `emailtemplate` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `variable` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `enterprise` */

DROP TABLE IF EXISTS `enterprise`;

CREATE TABLE `enterprise` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司名',
  `representative` varchar(40) DEFAULT '-' COMMENT '法人代表',
  `address` text DEFAULT '\'-\'' COMMENT '公司地址',
  `region` varchar(15) DEFAULT '-' COMMENT '所属地区(省)',
  `city` varchar(15) DEFAULT '-' COMMENT '城市',
  `district` varchar(15) DEFAULT '-' COMMENT '区/县',
  `lat_long` varchar(80) DEFAULT '-' COMMENT '经纬度，json -> {"lat": "30.18484477830133", "long": "120.06383340659741"}',
  `biz_status` varchar(20) DEFAULT '-' COMMENT '经营状态',
  `credit_code` varchar(32) DEFAULT '-' COMMENT '统一社会信用代码',
  `register_code` varchar(32) DEFAULT '-' COMMENT '注册号',
  `phone` varchar(255) NOT NULL DEFAULT '-' COMMENT '电话',
  `email` varchar(255) NOT NULL DEFAULT '-' COMMENT '邮箱',
  `setup_time` varchar(20) DEFAULT '-' COMMENT '成立时间',
  `industry` varchar(50) DEFAULT '-' COMMENT '所属行业',
  `biz_scope` varchar(1200) DEFAULT '-' COMMENT '经营范围',
  `company_type` varchar(32) DEFAULT '-' COMMENT '公司类型',
  `registered_capital` varchar(32) DEFAULT '-' COMMENT '注册资本',
  `actual_capital` varchar(32) DEFAULT '-' COMMENT '实缴资本',
  `taxpayer_code` varchar(32) DEFAULT '-' COMMENT '纳税人识别号',
  `organization_code` varchar(32) DEFAULT '-' COMMENT '组织机构代码',
  `english_name` varchar(128) DEFAULT '-' COMMENT '公司英文名',
  `authorization` varchar(50) DEFAULT '-' COMMENT '登记机关',
  `homepage` varchar(255) DEFAULT '-' COMMENT '公司官网',
  `used_name` varchar(128) DEFAULT '-' COMMENT '公司曾用名',
  `score` varchar(32) DEFAULT '-' COMMENT '评分',
  `other` varchar(522) DEFAULT '-' COMMENT '其他',
  `word` varchar(200) DEFAULT '-' COMMENT '搜索词',
  `gmt_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '插入时间',
  `gmt_modify` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最后操作时间',
  `phone2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5434463 DEFAULT CHARSET=utf8mb4 COMMENT='企业信息表';

/*Table structure for table `enterprise2` */

DROP TABLE IF EXISTS `enterprise2`;

CREATE TABLE `enterprise2` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司名',
  `representative` varchar(40) NOT NULL DEFAULT '-' COMMENT '法人代表',
  `address` varchar(200) NOT NULL DEFAULT '-' COMMENT '公司地址',
  `region` varchar(15) NOT NULL DEFAULT '-' COMMENT '所属地区(省)',
  `city` varchar(15) NOT NULL DEFAULT '-' COMMENT '城市',
  `district` varchar(15) NOT NULL DEFAULT '-' COMMENT '区/县',
  `lat_long` varchar(80) NOT NULL DEFAULT '-' COMMENT '经纬度，json -> {"lat": "30.18484477830133", "long": "120.06383340659741"}',
  `biz_status` varchar(20) NOT NULL DEFAULT '-' COMMENT '经营状态',
  `credit_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '统一社会信用代码',
  `register_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '注册号',
  `phone` varchar(255) NOT NULL DEFAULT '-' COMMENT '电话',
  `email` varchar(255) NOT NULL DEFAULT '-' COMMENT '邮箱',
  `setup_time` varchar(20) NOT NULL DEFAULT '-' COMMENT '成立时间',
  `industry` varchar(50) NOT NULL DEFAULT '-' COMMENT '所属行业',
  `biz_scope` varchar(1200) NOT NULL DEFAULT '-' COMMENT '经营范围',
  `company_type` varchar(32) NOT NULL DEFAULT '-' COMMENT '公司类型',
  `registered_capital` varchar(32) NOT NULL DEFAULT '-' COMMENT '注册资本',
  `actual_capital` varchar(32) NOT NULL DEFAULT '-' COMMENT '实缴资本',
  `taxpayer_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '纳税人识别号',
  `organization_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '组织机构代码',
  `english_name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司英文名',
  `authorization` varchar(50) NOT NULL DEFAULT '-' COMMENT '登记机关',
  `homepage` varchar(255) NOT NULL DEFAULT '-' COMMENT '公司官网',
  `used_name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司曾用名',
  `score` varchar(32) NOT NULL DEFAULT '-' COMMENT '评分',
  `other` varchar(522) NOT NULL DEFAULT '-' COMMENT '其他',
  `word` varchar(200) NOT NULL DEFAULT '-' COMMENT '搜索词',
  `gmt_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '插入时间',
  `gmt_modify` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最后操作时间',
  `phone2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2342001 DEFAULT CHARSET=utf8mb4 COMMENT='企业信息表';

/*Table structure for table `enterprise2筛选完成` */

DROP TABLE IF EXISTS `enterprise2筛选完成`;

CREATE TABLE `enterprise2筛选完成` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司名',
  `representative` varchar(40) NOT NULL DEFAULT '-' COMMENT '法人代表',
  `address` varchar(200) NOT NULL DEFAULT '-' COMMENT '公司地址',
  `region` varchar(15) NOT NULL DEFAULT '-' COMMENT '所属地区(省)',
  `city` varchar(15) NOT NULL DEFAULT '-' COMMENT '城市',
  `district` varchar(15) NOT NULL DEFAULT '-' COMMENT '区/县',
  `lat_long` varchar(80) NOT NULL DEFAULT '-' COMMENT '经纬度，json -> {"lat": "30.18484477830133", "long": "120.06383340659741"}',
  `biz_status` varchar(20) NOT NULL DEFAULT '-' COMMENT '经营状态',
  `credit_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '统一社会信用代码',
  `register_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '注册号',
  `phone` varchar(255) NOT NULL DEFAULT '-' COMMENT '电话',
  `email` varchar(255) NOT NULL DEFAULT '-' COMMENT '邮箱',
  `setup_time` varchar(20) NOT NULL DEFAULT '-' COMMENT '成立时间',
  `industry` varchar(50) NOT NULL DEFAULT '-' COMMENT '所属行业',
  `biz_scope` varchar(1200) NOT NULL DEFAULT '-' COMMENT '经营范围',
  `company_type` varchar(32) NOT NULL DEFAULT '-' COMMENT '公司类型',
  `registered_capital` varchar(32) NOT NULL DEFAULT '-' COMMENT '注册资本',
  `actual_capital` varchar(32) NOT NULL DEFAULT '-' COMMENT '实缴资本',
  `taxpayer_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '纳税人识别号',
  `organization_code` varchar(32) NOT NULL DEFAULT '-' COMMENT '组织机构代码',
  `english_name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司英文名',
  `authorization` varchar(50) NOT NULL DEFAULT '-' COMMENT '登记机关',
  `homepage` varchar(255) NOT NULL DEFAULT '-' COMMENT '公司官网',
  `used_name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司曾用名',
  `score` varchar(32) NOT NULL DEFAULT '-' COMMENT '评分',
  `other` varchar(522) NOT NULL DEFAULT '-' COMMENT '其他',
  `word` varchar(200) NOT NULL DEFAULT '-' COMMENT '搜索词',
  `gmt_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '插入时间',
  `gmt_modify` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最后操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2005294 DEFAULT CHARSET=utf8mb4 COMMENT='企业信息表';

/*Table structure for table `enterprise_models` */

DROP TABLE IF EXISTS `enterprise_models`;

CREATE TABLE `enterprise_models` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `enterprise_resource` */

DROP TABLE IF EXISTS `enterprise_resource`;

CREATE TABLE `enterprise_resource` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'PK',
  `name` varchar(128) NOT NULL DEFAULT '-' COMMENT '公司名',
  `representative` varchar(40) NOT NULL DEFAULT '-' COMMENT '法人代表',
  `address` varchar(200) NOT NULL DEFAULT '-' COMMENT '公司地址',
  `region` varchar(15) NOT NULL DEFAULT '-' COMMENT '所属地区(省)',
  `city` varchar(15) NOT NULL DEFAULT '-' COMMENT '城市',
  `district` varchar(15) NOT NULL DEFAULT '-' COMMENT '区/县',
  `lat_long` varchar(80) DEFAULT '-' COMMENT '经纬度，json -> {"lat": "30.18484477830133", "long": "120.06383340659741"}',
  `biz_status` varchar(20) NOT NULL DEFAULT '-' COMMENT '经营状态',
  `credit_code` varchar(32) DEFAULT '-' COMMENT '统一社会信用代码',
  `register_code` varchar(32) DEFAULT '-' COMMENT '注册号',
  `phone` varchar(255) NOT NULL DEFAULT '-' COMMENT '电话',
  `email` varchar(255) NOT NULL DEFAULT '-' COMMENT '邮箱',
  `setup_time` varchar(20) NOT NULL DEFAULT '-' COMMENT '成立时间',
  `industry` varchar(50) DEFAULT '-' COMMENT '所属行业',
  `biz_scope` varchar(1200) DEFAULT '-' COMMENT '经营范围',
  `company_type` varchar(32) DEFAULT '-' COMMENT '公司类型',
  `registered_capital` varchar(32) DEFAULT '-' COMMENT '注册资本',
  `actual_capital` varchar(32) DEFAULT '-' COMMENT '实缴资本',
  `taxpayer_code` varchar(32) DEFAULT '-' COMMENT '纳税人识别号',
  `organization_code` varchar(32) DEFAULT '-' COMMENT '组织机构代码',
  `english_name` varchar(128) DEFAULT '-' COMMENT '公司英文名',
  `authorization` varchar(50) DEFAULT '-' COMMENT '登记机关',
  `homepage` varchar(255) DEFAULT '-' COMMENT '公司官网',
  `used_name` varchar(128) DEFAULT '-' COMMENT '公司曾用名',
  `score` varchar(32) DEFAULT '-' COMMENT '评分',
  `other` varchar(522) DEFAULT '-' COMMENT '其他',
  `word` varchar(200) NOT NULL DEFAULT '-' COMMENT '搜索词',
  `gmt_create` timestamp NOT NULL DEFAULT current_timestamp() COMMENT '插入时间',
  `gmt_modify` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '最后操作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1251583 DEFAULT CHARSET=utf8mb4 COMMENT='企业信息表';

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `plan` */

DROP TABLE IF EXISTS `plan`;

CREATE TABLE `plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(27) DEFAULT '',
  `provice` varchar(50) DEFAULT '',
  `pvc_code` char(50) DEFAULT '',
  `city` char(50) DEFAULT '',
  `city_code` char(50) DEFAULT '',
  `area` char(50) DEFAULT '',
  `area_code` char(50) DEFAULT '',
  `getnum` int(10) DEFAULT 0 COMMENT '正在采集的页码',
  `total` int(10) DEFAULT 0 COMMENT '总共页数',
  `status` tinyint(5) DEFAULT 0 COMMENT '状态0:未开始，1：正在采集2：采集完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `province` */

DROP TABLE IF EXISTS `province`;

CREATE TABLE `province` (
  `_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `province_id` varchar(12) DEFAULT NULL,
  `spell` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  UNIQUE KEY `sessions_id_unique` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `smslogs` */

DROP TABLE IF EXISTS `smslogs`;

CREATE TABLE `smslogs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `templateId` int(10) unsigned NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('presend','sending','sended','sendwar','senderr') COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `smssign` */

DROP TABLE IF EXISTS `smssign`;

CREATE TABLE `smssign` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SignSource` enum('0','1','2','3','4','5') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0:企事业单位的全称或简称1:工信部备案网站的全称或简称2:APP应用的全称或简称3:公众号或小程序的全称或简称4:电商平台店铺名的全称或简称5:商标名的全称或简称',
  `Remark` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '短信签名申请说明',
  `status` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0:未通过1:通过',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `smstemplate` */

DROP TABLE IF EXISTS `smstemplate`;

CREATE TABLE `smstemplate` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `projectId` int(10) unsigned NOT NULL DEFAULT 0,
  `title` varchar(522) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(522) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '模版CODE',
  `signid` int(10) NOT NULL DEFAULT 0 COMMENT '签名id',
  `status` enum('unauth','authed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unauth',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `sys_role_resource` */

DROP TABLE IF EXISTS `sys_role_resource`;

CREATE TABLE `sys_role_resource` (
  `sys_rtr_id` int(10) NOT NULL,
  `sys_rol_id` int(10) unsigned DEFAULT NULL COMMENT '角色id',
  `sys_res_id` int(10) unsigned DEFAULT NULL COMMENT '权限id',
  `create_time` timestamp NULL DEFAULT current_timestamp() COMMENT '创建时间',
  `update_time` timestamp NULL DEFAULT current_timestamp() COMMENT '更新时间',
  PRIMARY KEY (`sys_rtr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='角色权限表(一个角色可以对应多个权限)';

/*Table structure for table `sys_user` */

DROP TABLE IF EXISTS `sys_user`;

CREATE TABLE `sys_user` (
  `sys_uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sys_uname` char(255) NOT NULL DEFAULT '' COMMENT '用户名',
  `pwd` char(255) NOT NULL DEFAULT '' COMMENT '密码',
  `email` char(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  `tel` char(20) NOT NULL DEFAULT '' COMMENT '手机',
  `sys_cmy` varchar(255) NOT NULL DEFAULT '' COMMENT '公司名称',
  `sys_dpt` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '公司部门',
  `sys_gid` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '组',
  `true_name` varchar(255) NOT NULL DEFAULT '' COMMENT '真实名称',
  `login_time` timestamp NULL DEFAULT NULL COMMENT '登录时间',
  `login_count` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '登录次数',
  `last_login_time` timestamp NULL DEFAULT NULL COMMENT '最后一次登录时间',
  `salt` char(255) NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT current_timestamp() COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT current_timestamp() COMMENT '更新时间',
  PRIMARY KEY (`sys_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `sys_users` */

DROP TABLE IF EXISTS `sys_users`;

CREATE TABLE `sys_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `town` */

DROP TABLE IF EXISTS `town`;

CREATE TABLE `town` (
  `_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `town_id` varchar(12) DEFAULT NULL,
  `country_id` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''''' COMMENT 'api_token',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Table structure for table `village` */

DROP TABLE IF EXISTS `village`;

CREATE TABLE `village` (
  `_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `village_id` varchar(12) DEFAULT NULL,
  `town_id` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
