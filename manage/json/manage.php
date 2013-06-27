<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
$Db = new Db();
switch ($_POST['op']) {
	case "admin_select":
		$result=$Db->query_fetch("select * from user");
		echo json_encode($result);
		break;
}