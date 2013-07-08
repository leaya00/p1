<?php
require_once("../lib/checkUser_json.php");
?>
<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
$Db = new Dbi();
switch ($_GET['op']) {
	case "select":
		$tj="";
		if(!empty($_GET['tj'])){
			$tmptj="%".$_GET['tj']."%";
			$tj="where (shop.code like '$tmptj' or shop.caption like '$tmptj' or object.code like '$tmptj' or object.caption like '$tmptj' )";
		}
		$limit_sql=" limit ".$_GET['start'].",".$_GET['limit'];

		$base_sql="SELECT a.id,a.shop,a.object,a.price,a.sdate,a.edate,a.postdate,a.createname,shop.caption as shop_s,object.caption object_s,a.remark,a.createtimestamp
			FROM`wptj_data`AS a
			LEFT JOIN (SELECT * FROM wptj_dict WHERE TYPE='shop') AS shop ON a.shop = shop.code
			LEFT JOIN (SELECT * FROM wptj_dict WHERE TYPE='object') AS object ON a.object= object.code $tj order by id desc";

		$data=$Db->query_fetch_all("select count(1) from ($base_sql) as temp");
		$count=$data[0][0];
		$data=$Db->query_fetch_all($base_sql.$limit_sql);
		// file_put_contents('c:/xxx.txt',$base_sql.$limit_sql);
		$result=array('root'=>$data,'count'=>$count);
		echo json_encode($result);
		// $Db->close();
		break;
	case "save":
		// 'id', 'sdate', 'edate','postdate','price','shop','object','createname','remark'
		$id=$_POST['id'];
		//admin 录入人填写空
		$writeUser=$_SESSION['username'];
		if($writeUser=='admin'){
			$writeUser='';
		}
		if($id==""){
			$sql= sprintf("INSERT INTO `wptj_data` (sdate,edate,postdate,price,shop,object,createname,remark) values ('%s','%s','%s','%s','%s','%s','%s','%s')"
			,$_POST['sdate'],$_POST['edate'],$_POST['postdate'],$_POST['price']
			,$_POST['shop'],$_POST['object'],$writeUser,$_POST['remark']);
		}else{
			$sql= sprintf("UPDATE  `wptj_data` set sdate='%s',edate='%s',postdate='%s',price='%s',shop='%s',object='%s'
			 ,createname='%s',remark='%s' where id=%s"
			 ,$_POST['sdate'],$_POST['edate'],$_POST['postdate'],$_POST['price']
			 ,$_POST['shop'],$_POST['object'],$writeUser,$_POST['remark']
			 ,$id);
		}
		$r= ($Db->query($sql));
		echo json_encode(array('result' => (Bool)$r));
		break;
	case "delete":
		$sql=sprintf("DELETE FROM `wptj_data` where id=%s",$_POST['id']);
		$r= ($Db->query($sql));
		echo json_encode(array('result' => (Bool)$r));
		break;
}
