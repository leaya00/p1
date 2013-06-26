<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>	
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <link href="../js/ext-4.2.1/resources/css/ext-all-neptune.css" rel="stylesheet" type="text/css" />
    <script src="../js/ext-4.2.1/ext-all-debug.js" type="text/javascript"></script>
    <script src="../js/ext-4.2.1/locale/ext-lang-zh_CN.js" type="text/javascript"></script>
	<script src="./js/editDict.js" type="text/javascript"></script>
</head>
<body>
	
	<?php
		$hid_type='<input id="hid_type" type="hidden" value="%s" />';	
	
		if(empty($_GET["type"])){ 
			$type="";
		}else{
			$type=$_GET["type"];
		}
		echo sprintf($hid_type,$type);
	?>
	
	<script>
		if( $("#hid_type").val()=='shop'){
			$(document)[0].title='店铺录入';
		}
		if( $("#hid_type").val()=='object'){
			$(document)[0].title='物品录入';
		}
	</script>
    <input id="hid_id" type="hidden" />
</body>
</html>