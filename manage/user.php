<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
	require_once("../lib/checkUser_json.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>	
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>	
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>
	<link href="../js/bootstrap/css/bootstrap.css" rel="stylesheet"
	type="text/css" />
<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../js/bootstrap/js/bootstrap.js" type="text/javascript"></script>
    
</head>
<body>
	<div class="container" style='width: 500px; margin-top: 50px;'>
	<p class="text-info">修改密码</p>
		<hr />
		<form class="form-horizontal" id="form1" method="post"
			autocomplete="off">
		
		<div class="control-group"><label class="control-label"
			for="txt_password">旧密码</label>
		<div class="controls"><input type="password" id="txt_password1"
			name="password"></div>
		</div>
		<div class="control-group"><label class="control-label"
			for="txt_password">新密码</label>
		<div class="controls"><input type="password" id="txt_password2"
			name="password"></div>
		</div>
		<div class="control-group"><label class="control-label"
			for="txt_password">重复新密码</label>
		<div class="controls"><input type="password" id="txt_password3"
			name="password"></div>
		</div>
		<div class="control-group">
		<div class="controls"><input type="button" class="btn btn-primary"
			onclick="adduser();" value='修改密码'></div>
		</div>
		
		</form>
   </div>
   <script>
   		checkValue=function(){
			var p1=$('#txt_password1').val();
			var p2=$('#txt_password2').val();
			var p3=$('#txt_password3').val();
			if(p2!=p3){
				alert('新密码输入不一致！');
				return false;
			}
			//todo:需要知道当前用户名
   	   	}
   </script>
</body>
</html>