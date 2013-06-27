<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
$Db = new Db();

switch ($_POST['report']) {
	case "report1":
		if(isset($_POST['shop'])){
			$where_shop="(a.shop='".$_POST['shop']."')";
		}
		if(isset($_POST['object'])){
			$where_object="(a.object='".$_POST['object']."')";
		}
		//todo:增加where条件
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
		$sql="SELECT id,sdate, edate, price,shop,object,shop.caption as shop_s,object.caption as object_s
			, $sql_sumday as sumday,
			$sql_nowday as nowday,
			$sql_nowprice as nowprice,
			$sql_lostday as lostday,
			$sql_lostprice as lostprice
			FROM wptj_data as a
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='shop') AS shop ON a.shop = shop.code 
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='object') AS object ON a.object= object.code";
			$sql=str_replace("#now",$_POST['date'],$sql);
			//		查询
			$result=$Db->query_fetch($sql);
			echo json_encode($result);
			$Db->close();
			break;
	case "report2":
		$sql_stdate="if(sdate>'#in_sdate',sdate,'#in_sdate')";
		$sql_etdate="if(edate<'#in_edate',edate,'#in_edate')";
		$sql_sumday="(TIMESTAMPDIFF(DAY,sdate,edate)+1)";
		$sql_nowday="(TIMESTAMPDIFF(DAY,$sql_stdate,$sql_etdate)+1)";
		$sql_nowprice="(price / ".$sql_sumday." * ".$sql_nowday.")";

		$sql="SELECT id,sdate, edate, price,shop,object,shop.caption as shop_s,object.caption as object_s
			, ".$sql_sumday." as sumday,
			  ".$sql_nowday." as nowday,
			  ".$sql_nowprice." as nowprice			  
			FROM wptj_data as a
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='shop') AS shop ON a.shop = shop.code 
			LEFT JOIN (SELECT code,caption FROM wptj_dict WHERE TYPE='object') AS object ON a.object= object.code";
		$sql=str_replace("#in_sdate",$_POST['sdate'],$sql);
		$sql=str_replace("#in_edate",$_POST['edate'],$sql);
		//		查询
		$result=$Db->query_fetch($sql);
		echo json_encode($result);
		$Db->close();
		break;
}


