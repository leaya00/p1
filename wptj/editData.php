<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
	require_once("lib/checkUser.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
    <title>基本数据录入</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>	
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>
	<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <link href="../js/ext-4.2.1/resources/css/ext-all-neptune.css" rel="stylesheet" type="text/css" />
    <script src="../js/ext-4.2.1/ext-all-debug.js" type="text/javascript"></script>
    <script src="../js/ext-4.2.1/locale/ext-lang-zh_CN.js" type="text/javascript"></script>
	<script src="../js/utils.js" type="text/javascript"></script>
	<script src="./js/editData.js" type="text/javascript"></script>
	<script src="./js/popWinDictSelect.js" type="text/javascript"></script>
</head>
<body>
	 <input id="username" value="<?php echo $_SESSION['username'];?>" type="hidden" />
    <input id="hid_id" type="hidden" />
</body>
</html>