--
-- table struct `user_connect`
-- Date: 2014-12-10
-- Database: ``
--

CREATE TABLE `user_connect` (
    `id` varchar NOT NULL AUTO_INCREMENT COMMENT "", 
    `user_id` varchar(0) NOT NULL COMMENT "用户ID",
    `third_party` varchar(2) NOT NULL COMMENT "第三方类型",
    `connect_id` varchar(64) NOT NULL COMMENT "第三方帐号ID",
    `access_token` varchar(512) NOT NULL COMMENT "存储登录token信息",
    `create_time` datetime NOT NULL COMMENT "",
    PRIMARY KEY (`id`)
) AUTO_INCREMENT=0 ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='';
ALTER TABLE `user_connect`
 ADD PRIMARY KEY (`id`), ADD KEY `user_id` (`user_id`), ADD KEY `third_party` (`third_party`,`connect_id`);
