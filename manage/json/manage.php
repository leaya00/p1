<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
$Db = new Dbi();
switch ($_POST['op']) {
	//修改密码
	case "modifyPwd":
		$stmt =mysqli_prepare($Db->link,"update user set password=? where id=?");
		mysqli_stmt_bind_param($stmt,'si',$_POST['value'],$_POST['id']);
		$result=mysqli_stmt_execute($stmt);     	
		echo json_encode(array('result'=>$result));
		break;
		//删除用户
	case "delUser":
		$stmt =mysqli_prepare($Db->link,"delete from user  where id=?");
		mysqli_stmt_bind_param($stmt,'i',$_POST['id']);
		$result=mysqli_stmt_execute($stmt);     	
		echo json_encode(array('result'=>$result));
	case "checkpwd":
		break;
}