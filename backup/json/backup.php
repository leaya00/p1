<?php	
	require_once("../../lib/checkUser_json.php");
	if($_SESSION['username']!='admin'){
			exit();
		}
	set_time_limit(0);
?>
<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
require ('../../lib/ioUtils.php');
require '../../lib/DbManage.php';
$backup_file = "../../backup_file/";
$backup=new DbManage(Dbi::$root,Dbi::$user,Dbi::$pass,Dbi::$db,Dbi::$charset);
switch ($_POST['op']) {
	case "backup":
		$r=$backup->backup('','../../backup_file/',null);

		echo json_encode(array('result' => $r));
		break;
	case "restore":
		$r=$backup->restore($backup_file.$_POST['filename']);
		echo  json_encode(array('result' => $r));
		break;
	case "getfilelist":
		$result=getDirFileToArray($backup_file);
		$xx=array();
		foreach ($result as $tmp){
			$xx[]['filename']=$tmp;

		}
		echo json_encode($xx);
		break;
}

