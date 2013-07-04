<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
	session_start();
	if(empty($_SESSION['username'])){		
		echo "<script>location.href='login.php';</script>"; 
		}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>内部系统</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
	<link href="./js/bootstrap/css/bootstrap.css"	rel="stylesheet" type="text/css" />
	<script src="./js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="./js/bootstrap/js/bootstrap.js" type="text/javascript"></script>

</head>
<body>
	<h4><a href="./login.php">注销用户</a></h4>
	<h3>用户名:<?php echo $_SESSION['username'];?></h3>
	
	<ul>	
		<li><a href="./wptj/" target="_blank">物品摊销子系统</a></li>
	</ul>
	<ul>
		<?php 
			if($_SESSION['username']=='admin'){
				echo '<li> <a href="./backup" target="_blank">备份恢复数据</a></li>';
			}
		?>	
		
	</ul>
	<ul>
		<?php 
			if($_SESSION['username']=='admin'){
				echo '<li> <a href="./manage/admin.php" target="_blank">管理用户</a></li>';
			}
		?>		
		<li> <a href="./manage/user.php" target="_blank">修改密码</a></li>
	</ul>
</body>
</html>