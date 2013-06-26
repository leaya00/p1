<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
$Db = new Db();
switch ($_GET['op']) {
	case "select":
		$sql=sprintf("SELECT * FROM `wptj_dict` where type='%s'",$_GET['type']);
		$result=$Db->query_fetch($sql);
		echo json_encode($result);
		$Db->close();
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
		$tj="%".$_POST['tj']."%";
		$sql=sprintf("SELECT * FROM `wptj_dict` where type='%s'
		 and (code like '%s' or caption like '%s')"
		,$_POST['type'],$tj,$tj);
		$result=$Db->query_fetch($sql);
		echo json_encode($result);
		$Db->close();	
		break;
}
