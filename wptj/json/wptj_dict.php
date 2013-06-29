<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
$Db = new Db();
switch ($_GET['op']) {
	case "select":
		$tj="";
		if(!empty($_GET['tj'])){
			$tmptj="%".$_GET['tj']."%";
			$tj=" and (code like '$tmptj' or caption like '$tmptj') ";	
		}		
		$limit_sql=" limit ".$_GET['start'].",".$_GET['limit'];
		$base_sql="SELECT * FROM `wptj_dict` where type='".$_GET['type']."' $tj";	
		$data=$Db->query_fetch("select count(1) from ($base_sql) as a");
		$count=$data[0][0];	
		$data=$Db->query_fetch($base_sql.$limit_sql);
		$result=array('root'=>$data,'count'=>$count);
		echo json_encode($result);		
		break;
	case "save":
		$id=$_POST['id'];
		if($id==""){
			$v_sql=sprintf("select count(id) as re from `wptj_dict` where type='%s' and code ='%s'",$_POST['type'],$_POST['code']);
			$sql= sprintf("INSERT INTO `wptj_dict` (type,code,caption) values ('%s','%s','%s')"
			,$_POST['type'],$_POST['code'],$_POST['caption']);
		}else{
			$v_sql=sprintf("select count(id) as re from `wptj_dict` where type='%s' and code ='%s' and id<>%s",$_POST['type'],$_POST['code'],$id);
			$sql= sprintf("UPDATE  `wptj_dict` set type='%s',code='%s',caption='%s' where id=%s"
			,$_POST['type'],$_POST['code'],$_POST['caption'],$id);
		}
		//防止代码重复	
				$query= $Db->query($v_sql);
				$row=$Db->fetch($query);
//		$row=$Db->query_fetch($v_sql);
		if($row['re']>0){
			echo json_encode(array('result' => '代码重复了！'));	
		}else{
			$r= $Db->query($sql);
			echo json_encode(array('result' => (Bool)$r));
		}

		break;
	case "delete":
		$sql=sprintf("DELETE FROM `wptj_dict` where id=%s",$_POST['id']);
		$r= ($Db->query($sql));
		echo json_encode(array('result' => (Bool)$r));
		break;
	case "filter":
		$limit_sql=" limit ".$_POST['start'].",".$_POST['limit'];
		$tj="%".$_POST['tj']."%";
		$base_sql="SELECT * FROM `wptj_dict` where type='".$_POST['type']."' and (code like '$tj' or caption like '$tj')";
		$data=$Db->query_fetch("select count(1) from ($base_sql) as a");
		$count=$data[0][0];	
		$data=$Db->query_fetch($base_sql.$limit_sql);
		$result=array('root'=>$data,'count'=>$count);
		echo json_encode($result);		
		break;
}
