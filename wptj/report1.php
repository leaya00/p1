<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>剩余摊销汇总表</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>	
	<meta http-equiv="X-UA-Compatible" content="IE=7" />
	<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <link href="../js/ext-4.2.1/resources/css/ext-all-neptune.css" rel="stylesheet" type="text/css" />
    <script src="../js/ext-4.2.1/ext-all-debug.js" type="text/javascript"></script>
    <script src="../js/ext-4.2.1/locale/ext-lang-zh_CN.js" type="text/javascript"></script>
    <script src="../js/utils.js" type="text/javascript"></script>
	<script src="./js/report1.js" type="text/javascript"></script>
	<script src="./js/popWinDictSelect.js" type="text/javascript"></script>
</head>
<body>
	<form id='exportform' name='exportform' action="./report1-xls.php" method="post" >
		<input type="hidden" id="hid_report" name="report"/>
		<input type="hidden" id="hid_start" name="start"/>
		<input type="hidden" id="hid_limit" name="limit"/>
		<input type="hidden" id="hid_shop" name="shop"/>
		<input type="hidden" id="hid_object" name="object"/>
		<input type="hidden" id="hid_date" name="date"/>
		<input type="hidden" id="hid_txzt" name="txzt"/>
	</form>
	
</body>
</html>