<?php
require_once("../../lib/checkUser_json.php");
?>
<?php
header("Content-Type: application/json; charset=utf-8");     //编码及内容类型头信息加在这里
require '../../lib/dbUtils.php';
$Db = new Dbi();
switch ($_POST['op']) {
	//修改密码
	case "modifyPwd":
		if($_SESSION['username']!='admin'){
			exit();
		}
		$stmt =mysqli_prepare($Db->link,"update user set password=? where id=?");
		mysqli_stmt_bind_param($stmt,'si',$_POST['value'],$_POST['id']);
		$result=mysqli_stmt_execute($stmt);
		 
		echo json_encode(array('result'=>$result));
		break;
		//删除用户
	case "delUser":
		if($_SESSION['username']!='admin'){
			exit();
		}
		$stmt =mysqli_prepare($Db->link,"delete from user  where id=?");
		mysqli_stmt_bind_param($stmt,'i',$_POST['id']);
		$result=mysqli_stmt_execute($stmt);
		echo json_encode(array('result'=>$result));
	case "userModifyPwd":
		$old=md5($_POST['oldvalue']);
		$new=md5($_POST['newvalue']);
		$result=$Db->query_fetch_all("select count(1) from user where id=".$_SESSION['userid']." and  password='".$old."'");
		if($result[0][0]==1){
			$stmt =mysqli_prepare($Db->link,"update user set password=? where id=? and username=? and password=?");
			mysqli_stmt_bind_param($stmt,'siss',$new,$_SESSION['userid'],$_SESSION['username'],$old);
			$result=mysqli_stmt_execute($stmt);
			echo json_encode(array('result'=>$result));
		}else{
			echo json_encode(array('result'=>false));
		}
		break;
}