/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.168
Source Server Version : 50726
Source Host           : 192.168.1.168:3306
Source Database       : superadminx

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2024-12-04 18:15:08
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for sa_news
-- ----------------------------
DROP TABLE IF EXISTS `sa_news`;
CREATE TABLE `sa_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_class_id` int(11) DEFAULT NULL COMMENT '分类id',
  `title` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '文章简介',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1》显示，2》隐藏',
  `pv` int(11) DEFAULT '0' COMMENT '点击量',
  `content` longtext COLLATE utf8mb4_unicode_ci COMMENT '内容',
  `img` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '图片\\n',
  `sort` int(11) DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='新闻表';

-- ----------------------------
-- Table structure for sa_news_class
-- ----------------------------
DROP TABLE IF EXISTS `sa_news_class`;
CREATE TABLE `sa_news_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '分类名称',
  `pid` int(11) DEFAULT NULL COMMENT '上级id',
  `pid_path` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'pid路劲',
  `pid_path_title` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '路劲标题',
  `img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '分类图片',
  `description` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '描述',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态，1》显示，2》隐藏',
  `create_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='新闻分类';
