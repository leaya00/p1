<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<link href="../js/bootstrap/css/bootstrap.css" rel="stylesheet"
	type="text/css" />
<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
<script src="../js/bootstrap/js/bootstrap.js" type="text/javascript"></script>

</head>
<body>
<h3>
<p class="text-success"><?php
if(!empty($_GET['msg'])){

	echo $_GET['msg'];
}

?></p>
</h3>
<?php
require_once "../lib/dbUtils.php";
$db=new Dbi();
if(!empty($_POST['username'])){
	// 增加用户	
	$result=$db->query_fetch_all("select count(1) from user where username='".$_POST['username']."'");
	if($result[0][0]>0){
		$msg="用户名[".$_POST['username']."]已存在";
	}else{
		$result=$db->query("insert into user (username,password) values ('".$_POST['username']."','".md5($_POST['password'])."')");
		$msg="增加用户：".$_POST['username'];
	}

	$msg=urlencode($msg);
	echo "<script>location.href='admin.php?msg=$msg'</script>";
}
?>
<div class="container" style='width: 500px; margin-top: 50px;'>
<p class="text-info">增加用户</p>
<hr />
<form class="form-horizontal" id="add_form" method="post"
	autocomplete="off">
<div class="control-group"><label class="control-label"
	for="txt_username">用户名</label>
<div class="controls"><input type="text" id="txt_username"
	name="username"></div>
</div>
<div class="control-group"><label class="control-label"
	for="txt_password">密码</label>
<div class="controls"><input type="password" id="txt_password"
	name="password"></div>
</div>
<div class="control-group">
<div class="controls"><input type="button" class="btn btn-primary"
	onclick="adduser();" value='增加'></div>
</div>

</form>
<p class="text-info">管理用户</p>
<hr />
<table class="table table-bordered table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>用户名</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$result=$db->query_fetch_all("select * from user");
	$rownum=0;
	foreach ($result as $row){
		echo "<tr>";
			
		echo "<td>$rownum</td>";
		echo "<td>".$row['username']."</td>";
		echo "<td style='width: 140px;'>
			<button type='submit' class='btn btn-danger' onclick='modifyPwd(".$row['id'].",\"".$row['username']."\");'>重置密码</button>
			<button type='submit' class='btn btn-danger' onclick='delUser(".$row['id'].",\"".$row['username']."\");'>删除</button>
			</td>";
		echo "</tr>";
		$rownum++;			
	}
	?>

	</tbody>
</table>
</div>
<div class="modal hide fade" id="myalert">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal"
	aria-hidden="true">&times;</button>
<h3>对话框标题</h3>
</div>
<div class="modal-body">
<p>One fine body…</p>
</div>
<div class="modal-footer"><a href="#" class="btn btn-primary"
	onclick="okMyAlert();">确定</a> <a href="#" class="btn btn-primary"
	onclick="hideMyAlert();">取消</a></div>
</div>
<script>
		adduser=function (){
			$("#add_form").submit();
		};
		okExec=null;
		showMyAlert=function(title,body){
			$('#myalert h3').html(title);
			$('#myalert p').html(body);
			$('#myalert').modal();
		};
		hideMyAlert=function(){
			$('#myalert').modal('hide');
			}		
		okMyAlert=function(){
			if(okExec){
				okExec();
			}
			hideMyAlert();
			};
		modifyPwd=function(id,text){
			showMyAlert("提示","用户:["+text+"],密码将重置为111111");
			okExec=function(){
				var v={
						id:id,
						op:'modifyPwd',
						value:'<?php echo md5("111111");?>'
						};
				$.ajax({
					   type: "POST",
					   url: "./json/manage.php",
					   data: v,
					   dataType:'json',
					   success: function(msg){
					   		if(msg.result){
					     		alert('重置密码成功!');
					   		}else{
					   			alert('重置密码失败!');
						   	}
					   },
					   error:function (XMLHttpRequest, textStatus, errorThrown) {
						  
						    alert('重置密码失败!\r\n'+XMLHttpRequest.responseText);
						}
					});
				};
			};
		delUser=function(id,text){
				showMyAlert("提示","用户["+text+"]将被删除!");
				okExec=function(){
					var v={
							id:id,
							op:'delUser'							
							};
					$.ajax({
						   type: "POST",
						   url: "./json/manage.php",
						   data: v,
						   dataType:'json',
						   success: function(msg){
						   		if(msg.result){
						     		alert('删除用户成功!');
						     		location.href='admin.php';
						   		}else{
						   			alert('删除用户失败!');
							   	}
						   },
						   error:function (XMLHttpRequest, textStatus, errorThrown) {
							  
							    alert('删除用户失败!\r\n'+XMLHttpRequest.responseText);
							}
						});
					};
				};
	</script>

</body>
</html>
