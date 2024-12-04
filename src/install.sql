INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('文章管理', '1', 'icon-wenzhang2', '', 'newsManage', NULL, ',newsManage,', '', NULL, '1000', '1', NULL, '1', '2023-03-31 16:36:45', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('文章分类', '2', 'icon-zuzhijigou1', '/news/class', 'newsClass', 'newsManage', ',newsManage,newsClass,', '/news/class', NULL, '0', '1', NULL, '1', '2023-04-03 13:59:48', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('只浏览数据', '6', '', '', 'newsClassGetList', 'newsClass', ',newsManage,newsClass,newsClassGetList,', '', NULL, '0', '1', NULL, '1', '2023-10-10 13:40:23', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('添加分类', '6', '', '/news_class/create', 'newsClassCreate', 'newsClass', ',newsManage,newsClass,newsClassCreate,', '/news_class/create', NULL, '1', '1', NULL, '1', '2023-04-03 14:11:05', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('修改分类', '6', '', '', 'newsClassUpdate', 'newsClass', ',newsManage,newsClass,newsClassUpdate,', '', NULL, '2', '1', NULL, '1', '2023-04-04 13:36:14', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('删除分类', '6', '', '', 'newsClassDelete', 'newsClass', ',newsManage,newsClass,newsClassDelete,', '', NULL, '2', '1', NULL, '1', '2023-04-04 13:36:25', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('修改排序', '6', '', '', 'newsClassUpdateSort', 'newsClass', ',newsManage,newsClass,newsClassUpdateSort,', '', NULL, '3', '1', NULL, '1', '2023-04-04 15:00:16', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('状态修改', '6', '', '', 'newsClassUpdateStatus', 'newsClass', ',newsManage,newsClass,newsClassUpdateStatus,', '', NULL, '7', '1', NULL, '1', '2024-04-09 18:47:04', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('文章列表', '2', 'icon-wenzhang2', '/news/list', 'news', 'newsManage', ',newsManage,news,', '/news/list', NULL, '1', '1', NULL, '1', '2023-04-03 14:00:28', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('只浏览数据', '6', '', '', 'newsGetList', 'news', ',newsManage,news,newsGetList,', '', NULL, '0', '1', NULL, '1', '2023-10-10 13:40:48', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('添加文章', '5', '', '/news/list/create', 'newsCreate', 'news', ',newsManage,news,newsCreate,', '/news/list/create', NULL, '1', '1', NULL, '1', '2023-04-04 13:36:34', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('修改文章', '5', '', '/news/list/update', 'newsUpdate', 'news', ',newsManage,news,newsUpdate,', '/news/list/update', NULL, '2', '1', NULL, '2', '2023-04-04 13:36:46', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('删除文章', '6', '', '', 'newsDelete', 'news', ',newsManage,news,newsDelete,', '', NULL, '2', '1', NULL, '1', '2023-04-04 13:36:59', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('复制文章', '6', '', '', 'newsCopy', 'news', ',newsManage,news,newsCopy,', '', NULL, '3', '1', NULL, '1', '2023-04-04 13:37:53', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('批量切换分类', '6', '', '', 'newsUpdateClassId', 'news', ',newsManage,news,newsUpdateClassId,', '', NULL, '4', '1', NULL, '1', '2023-04-04 13:38:04', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('修改排序', '6', '', '', 'newsUpdateSort', 'news', ',newsManage,news,newsUpdateSort,', '', NULL, '5', '1', NULL, '1', '2023-04-05 09:57:27', '2024-11-28 10:59:49');
INSERT INTO `sa_admin_menu` (`title`, `type`, `icon`, `path`, `name`, `pid_name`, `pid_name_path`, `component_path`, `url`, `sort`, `hidden`, `desc`, `is_params`, `create_time`, `update_time`) VALUES ('状态修改', '6', '', '', 'newsUpdateStatus', 'news', ',newsManage,news,newsUpdateStatus,', '', NULL, '7', '1', '上架下架', '1', '2024-04-09 18:47:20', '2024-11-28 10:59:49');

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

