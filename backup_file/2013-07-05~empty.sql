--
-- MySQL database dump
-- Created by DBManage class, Power By yanue. 
-- http://www.yanue.net 
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年  07 月 05 日 14:23
-- MySQL版本: 5.5.32
-- PHP 版本: 5.4.16

--
-- 数据库: `lilang`
--

-- -------------------------------------------------------

--
-- 表的结构user
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 NOT NULL,
  `createtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 user
--

INSERT INTO `user` VALUES('11','admin','21232f297a57a5a743894a0e4a801fc3','0000-00-00 00:00:00');
INSERT INTO `user` VALUES('16','test','098f6bcd4621d373cade4e832627b4f6','2013-07-04 17:25:15');
--
-- 表的结构wptj_data
--

DROP TABLE IF EXISTS `wptj_data`;
CREATE TABLE `wptj_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `shop` varchar(20) CHARACTER SET latin1 NOT NULL,
  `object` varchar(20) CHARACTER SET latin1 NOT NULL,
  `remark` varchar(200) NOT NULL,
  `createname` varchar(100) CHARACTER SET latin1 NOT NULL,
  `createtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 wptj_data
--

--
-- 表的结构wptj_dict
--

DROP TABLE IF EXISTS `wptj_dict`;
CREATE TABLE `wptj_dict` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET latin1 NOT NULL,
  `code` varchar(20) CHARACTER SET latin1 NOT NULL,
  `caption` varchar(80) NOT NULL,
  `createtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 wptj_dict
--

