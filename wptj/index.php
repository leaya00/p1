
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
	require_once("lib/checkUser.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>
	<link href="../js/bootstrap/css/bootstrap.css"	rel="stylesheet" type="text/css" />
	<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap/js/bootstrap.js" type="text/javascript"></script>
</head>
<body>
	<h4><a href="../">返回首页</a></h4>
	<h3>用户名:<?php echo $_SESSION['username'];?></h3>
	
	<ul>	
		<li><a href="editdict.php?type=shop" target="_blank">店铺录入</a></li>
		<li><a href="editdict.php?type=object" target="_blank">物品录入</a></li>
	</ul>
	<ul>
		<li> <a href="editData.php" target="_blank">基本数据录入</a></li>
		<li> <a href="importData.php" target="_blank">基本数据导入</a></li>
	</ul>
	<ul>
		<li><a href="report1.php" target="_blank">剩余摊销汇总表</a></li>
		<li><a href="report2.php" target="_blank">阶段摊销额汇总表</a></li>
	</ul>
	<ul>
		
		<li> <a href="../backup" target="_blank">备份恢复数据</a></li>
	</ul>
</body>
</html>