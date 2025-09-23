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

CREATE TABLE `sa_news_collect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `news_id` int(11) NOT NULL COMMENT '文章id',
  PRIMARY KEY (`id`),
  KEY `fk_sa_user_collect_news_user_idx1` (`user_id`) USING BTREE,
  KEY `fk_sa_user_collect_news_news_idx2` (`news_id`) USING BTREE,
  CONSTRAINT `sa_user_collect_news_news_idfk2` FOREIGN KEY (`news_id`) REFERENCES `sa_news` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `sa_user_collect_news_user_idfk1` FOREIGN KEY (`user_id`) REFERENCES `sa_user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户收藏-文章';