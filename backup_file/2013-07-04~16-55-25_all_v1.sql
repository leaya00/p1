--
-- MySQL database dump
-- Created by DBManage class, Power By yanue. 
-- http://www.yanue.net 
--
-- 主机: 127.0.0.1
-- 生成日期: 2013 年  07 月 04 日 16:55
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
  `password` varchar(100) CHARACTER SET latin1 NOT NULL,
  `createtimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 user
--

INSERT INTO `user` VALUES('11','admin','21232f297a57a5a743894a0e4a801fc3','0000-00-00 00:00:00');
INSERT INTO `user` VALUES('15','用户1','202cb962ac59075b964b07152d234b70','2013-07-04 16:50:21');
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
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 wptj_data
--

INSERT INTO `wptj_data` VALUES('5','2013-04-04','2016-04-03','22644.00','002','01','','test','0000-00-00 00:00:00');
INSERT INTO `wptj_data` VALUES('6','2013-06-01','2014-05-31','12000.00','002','01','','test','0000-00-00 00:00:00');
INSERT INTO `wptj_data` VALUES('7','2012-07-02','2013-07-26','11111.00','001','02','xxxxx','test','0000-00-00 00:00:00');
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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 wptj_dict
--

INSERT INTO `wptj_dict` VALUES('1','','','','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('2','shop','002','shop2','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('3','shop','003','shop3','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('4','object','01','空调春兰','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('5','object','02','空调2','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('6','','','','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('7','','','','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('8','','','','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('10','shop','004','shop4','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('11','shop','005','shop5','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('12','shop','006','shop6','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('13','object','03','装饰1','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('14','object','04','物品1','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('15','object','05','冰箱','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('16','object','06','a','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('17','object','07','b','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('18','object','08','d','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('19','object','09','e','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('20','object','10','f','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('21','object','11','g','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('22','object','12','h','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('23','object','13','aaaa','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('24','object','14','aaaaa','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('25','object','15','fgggg','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('26','object','16','hhhhhh','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('27','object','17','kjljljk','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('28','object','18','4444','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('29','object','19','ghjkghjgh','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('30','object','21','jkljkljkl','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('31','shop','007','中华人民共和国','0000-00-00 00:00:00');
INSERT INTO `wptj_dict` VALUES('32','shop','001','某某','0000-00-00 00:00:00');
