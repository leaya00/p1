--
-- MySQL database dump
-- Created by DBManage class, Power By yanue. 
-- http://www.yanue.net 
--
-- 主机: localhost
-- 生成日期: 2013 年  06 月 23 日 22:28
-- MySQL版本: 5.5.27
-- PHP 版本: 5.4.7

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
  `password` varchar(10) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 user
--

--
-- 表的结构wptj_data
--

DROP TABLE IF EXISTS `wptj_data`;
CREATE TABLE `wptj_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `shop` varchar(20) CHARACTER SET latin1 NOT NULL,
  `object` varchar(20) CHARACTER SET latin1 NOT NULL,
  `createname` varchar(100) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 wptj_data
--

INSERT INTO `wptj_data` VALUES('1','2013-01-01','2013-12-31','10000','001','02','test');
INSERT INTO `wptj_data` VALUES('3','2012-06-25','2013-06-24','10000','002','01','test');
--
-- 表的结构wptj_dict
--

DROP TABLE IF EXISTS `wptj_dict`;
CREATE TABLE `wptj_dict` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET latin1 NOT NULL,
  `code` varchar(20) CHARACTER SET latin1 NOT NULL,
  `caption` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 wptj_dict
--

INSERT INTO `wptj_dict` VALUES('1','','','');
INSERT INTO `wptj_dict` VALUES('2','shop','002','shop2');
INSERT INTO `wptj_dict` VALUES('3','shop','003','shop3');
INSERT INTO `wptj_dict` VALUES('4','object','01','空调1');
INSERT INTO `wptj_dict` VALUES('5','object','02','空调2');
INSERT INTO `wptj_dict` VALUES('6','','','');
INSERT INTO `wptj_dict` VALUES('7','','','');
INSERT INTO `wptj_dict` VALUES('8','','','');
INSERT INTO `wptj_dict` VALUES('9','shop','001','shop1');
INSERT INTO `wptj_dict` VALUES('10','shop','004','shop4');
INSERT INTO `wptj_dict` VALUES('11','shop','005','shop5');
INSERT INTO `wptj_dict` VALUES('12','shop','006','shop6');
INSERT INTO `wptj_dict` VALUES('13','object','03','装饰1');
INSERT INTO `wptj_dict` VALUES('14','object','04','物品1');
