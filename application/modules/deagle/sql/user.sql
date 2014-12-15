--
-- table struct `user`
-- Date: 2014-12-10
-- Database: ``
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(10) NOT NULL,
  `nick` varchar(128) NOT NULL COMMENT '用户昵称',
  `email` varchar(128) NOT NULL COMMENT '邮箱',
  `is_email_verified` tinyint(4) NOT NULL,
  `intro` varchar(1024) NOT NULL COMMENT '用户介绍',
  `avatar` varchar(1024) NOT NULL COMMENT '头像',
  `user_level` tinyint(4) NOT NULL,
  `tags` varchar(1024) NOT NULL,
  `accept_subscribe_email` tinyint(4) NOT NULL,
  `last_login_time` datetime NOT NULL,
  `id_card_no` varchar(32) NOT NULL COMMENT '身份证号',
  `last_login_ip` varchar(32) NOT NULL,
  `create_time` datetime NOT NULL,
  `last_modified_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `user`
 ADD PRIMARY KEY (`id`), ADD KEY `nick` (`nick`);
