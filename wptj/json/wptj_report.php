<?php	
	require_once("../lib/checkUser_json.php");
?>
<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require_once "../../global.php";
require_once './wptj/lib/report.php';


switch ($_POST['report']) {
	case "report1":
		$result=report1();
		echo json_encode($result);		
		break;
	case "report2":
		$result=report2();
		echo json_encode($result);			
		break;
}

