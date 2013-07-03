<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>登录系统</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
<script src="./js/jquery-1.7.1.min.js" type="text/javascript"></script>
<link href="./js/ext-4.2.1/resources/css/ext-all-neptune.css"
	rel="stylesheet" type="text/css" />
<script src="./js/ext-4.2.1/ext-all-debug.js" type="text/javascript"></script>
<script src="./js/ext-4.2.1/locale/ext-lang-zh_CN.js"
	type="text/javascript"></script>

</head>
<body>
<?php
session_start();
unset($_SESSION['username']);
if(isset($_POST['username']) && isset($_POST['password'])){
	require './lib/dbUtils.php';
	//		登录成功跳转

	$db=new Dbi();
	function setParam($stmt){
		$pwd=md5($_POST['password']);
		mysqli_stmt_bind_param($stmt,'ss',$_POST['username'],$pwd);
	}
	$result=$db->query_prepare_fetch_all('select username  from user where username=? and password=?',setParam);
	if(count($result)>0){
		$_SESSION['username'] = $result[0][0];
		echo "<script>location.href='./wptj/';</script>";
	}



}
?>
<script>
	
	Ext.require([
			'Ext.form.*',
			'Ext.layout.container.Absolute',
			'Ext.window.Window'
		]);

	Ext.onReady(function () {
		var form = Ext.create('Ext.form.Panel', {
				layout : 'absolute',
				url : 'login.php',
				defaultType : 'textfield',
				method : 'POST',
				standardSubmit : true,
				fieldDefaults : {
					labelWidth : 80,
					labelAlign : 'right'
				},
				border : false,
				region : 'center',
				items : [{
						fieldLabel : '用户名',
						fieldWidth : 70,
						msgTarget : 'side',
						allowBlank : false,
						x : 0,
						y : 20,
						// value:'xxx',
						name : 'username',
						id:'username',
						listeners : {
							specialkey : function (field, e) {
								if (e.getKey() == Ext.EventObject.ENTER) {
									form.submit();

								}
							}
						}
					}, {
						fieldLabel : '密码',
						fieldWidth : 70,
						x : 0,
						y : 55,
						inputType : 'password',
						name : 'password',
						listeners : {
							specialkey : function (field, e) {
								if (e.getKey() == Ext.EventObject.ENTER) {
									form.submit();

								}
							}
						}
					}
				]
			});

		var win = Ext.create('Ext.window.Window', {
				autoShow : true,
				title : '登录',
				width : 400,
				height : 200,
				closable : false,
				draggable : false,
				resizable : false,
				layout : 'border',
				plain : true,
				items : [{

						width : 100,
						border : false,
						region : 'west',
						html : "<div style='margin-top:10px;margin-left:10px;'><image src='./image/login/login.png'></image></div>"
					}, form],

				buttons : [{
						text : '登录',
						handler : function () {
							form.submit();
						}
					}, {
						text : '重置',
						handler : function () {
							form.reset();
						}
					}
				]
			});
			 Ext.getCmp('username').focus(true,100);
	});
	 
	</script>

</body>
</html>
