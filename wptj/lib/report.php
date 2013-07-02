<?php
if(!defined('global_lib')){
	require_once "../../global.php";
}
require_once './lib/dbUtils.php';
require_once './lib/strUtils.php';

$Db = new Db();
// 已摊销完的那个 已摊销天数 和已摊销额 就可以直接等于总的摊销天数 和总金额了
// 剩余部分为0
function report1(){		
		global $Db;
		// print_r($_POST);
		$limit_sql=" limit ".$_POST['start'].",".$_POST['limit'];
		//摊销开始时间大于查询时间的 不在报表1出现
		$where="where '#now'>=sdate ";
		// 其他限定条件
		if(!empty($_POST['shop'])){
			$where="$where and (a.shop in (".parseParm($_POST['shop'])."))";
		}
		if(!empty($_POST['object'])){
			$where="$where and (a.object in (".parseParm($_POST['object'])."))";
		}	
		//总摊销天数
		$sql_sumday="(TIMESTAMPDIFF(DAY,sdate,edate)+1)";
		//		已摊销天数
		$sql_nowday="(TIMESTAMPDIFF(DAY,sdate,'#now')+1)";
		//		已摊销金额
		$sql_nowprice="ROUND((price / $sql_sumday * $sql_nowday),2)";
		//		剩余摊销天数
		$sql_lostday="(TIMESTAMPDIFF(DAY,'#now',edate))";
		//		剩余摊销金额
		$sql_lostprice="ROUND((price / $sql_sumday * $sql_lostday),2)";
		// 普通字段
		$sql_field=" id,sdate, edate, price,shop,object,shop.caption as shop_s,object.caption as object_s
			, $sql_sumday as sumday,
			$sql_nowday as nowday,
			$sql_nowprice as nowprice,
			$sql_lostday as lostday,
			$sql_lostprice as lostprice ";
		// 合计字段
		$sql_sum_field="sum(price) as price_sum,sum($sql_nowprice) as nowprice_sum,sum($sql_lostprice) as lostprice_sum";
		
		// 查询语句
		$base_sql="SELECT %s
			FROM wptj_data as a
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='shop') AS shop ON a.shop = shop.code 
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='object') AS object ON a.object= object.code
			 $where ";
		// 获取合计
		$sum_sql=sprintf($base_sql,$sql_sum_field);
		$sum_sql=str_replace("#now",$_POST['date'],$sum_sql);
		$data=$Db->query_fetch($sum_sql);
		// echo $sum_sql;
		$price_sum=$data[0]['price_sum'];
		$nowprice_sum=$data[0]['nowprice_sum'];
		$lostprice_sum=$data[0]['lostprice_sum'];
		///获取总记录数
		$count_sql=sprintf($base_sql,'1');
		$count_sql=str_replace("#now",$_POST['date'],$count_sql);
		$data=$Db->query_fetch("select count(1) from ($count_sql) as a");
		$count=$data[0][0];	
		//获取本页数据
		$select_sql=sprintf($base_sql,$sql_field);
		$select_sql=str_replace("#now",$_POST['date'],$select_sql);
		$data=$Db->query_fetch($select_sql.$limit_sql);	
		//返回值
		$result=array('root'=>$data
					  ,'count'=>$count
					  ,'price_sum'=>$price_sum
					  ,'nowprice_sum'=>$nowprice_sum
					  ,'lostprice_sum'=>$lostprice_sum);
		return $result;
}
function report2(){
		global $Db;
		$limit_sql=" limit ".$_POST['start'].",".$_POST['limit'];
		//时间限定条件
		$where=" where (a.id not in(select id from wptj_data where  '#in_sdate'>edate or '#in_edate'<sdate)) ";
		//普通限定条件
		if(!empty($_POST['shop'])){
			$where="$where and (a.shop in (".parseParm($_POST['shop']).")) ";
		}
		if(!empty($_POST['object'])){
			$where="$where and (a.object in (".parseParm($_POST['object']).")) ";
		}	
		//开始时间
		$sql_stdate="if(sdate>'#in_sdate',sdate,'#in_sdate')";
		//结束时间
		$sql_etdate="if(edate<'#in_edate',edate,'#in_edate')";
		//总摊销天数
		$sql_sumday="(TIMESTAMPDIFF(DAY,sdate,edate)+1)";
		//已摊销天数
		$sql_nowday="(TIMESTAMPDIFF(DAY,$sql_stdate,$sql_etdate)+1)";
		//已摊销金额
		$sql_nowprice="ROUND((price / ".$sql_sumday." * ".$sql_nowday."),2)";
		//普通字段
		$sql_field="id,sdate, edate, price,shop,object,shop.caption as shop_s,object.caption as object_s
			, $sql_sumday as sumday,
			  $sql_nowday as nowday,
			  $sql_nowprice as nowprice	";
		// 合计字段
		$sql_sum_field="sum(price) as price_sum,sum($sql_nowprice) as nowprice_sum";
		$base_sql="SELECT %s		  
			FROM wptj_data as a
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='shop') AS shop ON a.shop = shop.code 
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='object') AS object ON a.object= object.code $where";
		// 获取合计
		$sum_sql=sprintf($base_sql,$sql_sum_field);
		$sum_sql=str_replace("#in_sdate",$_POST['sdate'],$sum_sql);
		$sum_sql=str_replace("#in_edate",$_POST['edate'],$sum_sql);
		$data=$Db->query_fetch($sum_sql);
		$price_sum=$data[0]['price_sum'];
		$nowprice_sum=$data[0]['nowprice_sum'];
		///获取总记录数
		$count_sql=sprintf($base_sql,'1');
		$count_sql=str_replace("#in_sdate",$_POST['sdate'],$count_sql);
		$count_sql=str_replace("#in_edate",$_POST['edate'],$count_sql);
		$data=$Db->query_fetch("select count(1) from ($count_sql) as a");
		$count=$data[0][0];	
		//获取本页数据
		$select_sql=sprintf($base_sql,$sql_field);
		$select_sql=str_replace("#in_sdate",$_POST['sdate'],$select_sql);
		$select_sql=str_replace("#in_edate",$_POST['edate'],$select_sql);
		$data=$Db->query_fetch($select_sql.$limit_sql);	
		//返回值
		$result=array('root'=>$data
					  ,'count'=>$count
					  ,'price_sum'=>$price_sum
					  ,'nowprice_sum'=>$nowprice_sum
					  );
		return $result;
}