DELIMITER $$
CREATE  PROCEDURE mytest()
BEGIN
   declare _End int default 0;
   while (_End < 100) do
      INSERT INTO `wptj_data`(`sdate`, `edate`, `price`, `shop`, `object`, `postdate`, `remark`, `createname` ) VALUES ('2011-01-01','2013-12-31',50000,001,01,'2012-12-30','test','lxy');
       set _End = _End +1;
   end while;
END $$
DELIMITER ; 