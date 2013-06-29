<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
require '../../lib/strUtils.php';
$Db = new Db();

switch ($_POST['report']) {
	case "report1":
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
		$sql_nowprice="(price / $sql_sumday * $sql_nowday)";
		//		剩余摊销天数
		$sql_lostday="(TIMESTAMPDIFF(DAY,'#now',edate))";
		//		剩余摊销金额
		$sql_lostprice="(price / $sql_sumday * $sql_lostday)";
		$base_sql="SELECT id,sdate, edate, price,shop,object,shop.caption as shop_s,object.caption as object_s
			, $sql_sumday as sumday,
			$sql_nowday as nowday,
			$sql_nowprice as nowprice,
			$sql_lostday as lostday,
			$sql_lostprice as lostprice
			FROM wptj_data as a
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='shop') AS shop ON a.shop = shop.code 
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='object') AS object ON a.object= object.code
			 $where ";			
			$base_sql=str_replace("#now",$_POST['date'],$base_sql);
			$data=$Db->query_fetch("select count(1) from ($base_sql) as a");
			$count=$data[0][0];	
			$data=$Db->query_fetch($base_sql.$limit_sql);
			// echo $base_sql.$limit_sql;
			// break;
			$result=array('root'=>$data,'count'=>$count,'sum1'=>'hahahahah');
			echo json_encode($result);
			$Db->close();	
			break;
	case "report2":
		$limit_sql=" limit ".$_POST['start'].",".$_POST['limit'];
		$where=" where (a.id not in(select id from wptj_data where  '#in_sdate'>edate or '#in_edate'<sdate)) ";
		if(!empty($_POST['shop'])){
			$where="$where and (a.shop in (".parseParm($_POST['shop']).")) ";
		}
		if(!empty($_POST['object'])){
			$where="$where and (a.object in (".parseParm($_POST['object']).")) ";
		}		
		$sql_stdate="if(sdate>'#in_sdate',sdate,'#in_sdate')";
		$sql_etdate="if(edate<'#in_edate',edate,'#in_edate')";
		$sql_sumday="(TIMESTAMPDIFF(DAY,sdate,edate)+1)";
		$sql_nowday="(TIMESTAMPDIFF(DAY,$sql_stdate,$sql_etdate)+1)";
		$sql_nowprice="(price / ".$sql_sumday." * ".$sql_nowday.")";

		$base_sql="SELECT id,sdate, edate, price,shop,object,shop.caption as shop_s,object.caption as object_s
			, ".$sql_sumday." as sumday,
			  ".$sql_nowday." as nowday,
			  ".$sql_nowprice." as nowprice			  
			FROM wptj_data as a
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='shop') AS shop ON a.shop = shop.code 
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='object') AS object ON a.object= object.code $where";
		$base_sql=str_replace("#in_sdate",$_POST['sdate'],$base_sql);
		$base_sql=str_replace("#in_edate",$_POST['edate'],$base_sql);
		$data=$Db->query_fetch("select count(1) from ($base_sql) as a");
		$count=$data[0][0];	
		$data=$Db->query_fetch($base_sql.$limit_sql);
		$result=array('root'=>$data,'count'=>$count);
		echo json_encode($result);
		$Db->close();
		break;
}

