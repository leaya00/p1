<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>导入基础数据</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>
<link href="../js/bootstrap/css/bootstrap.css"	rel="stylesheet" type="text/css" />
	<script src="../js/jquery-1.7.1.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap/js/bootstrap.js" type="text/javascript"></script>

</head>
<body>
	<?php
	require_once "../global.php";
	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('PRC');

	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

	
	/** Include PHPExcel_IOFactory */
	require_once './lib/PHPExcel_1.7.9_doc/PHPExcel/IOFactory.php';		
	
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	$objPHPExcel = PHPExcel_IOFactory::load("./wptj/template.xls");
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow(); // 取得总行数
	$highestColumn = $sheet->getHighestColumn(); // 取得总列数
	echo $highestRow."--".$highestColumn;
	$x=$sheet->getCell("A1")->getValue();
	
	echo $x;
	
	?>
	<div class="container" style='width:500px;margin-top:50px;'>
		
		<form name="form1" method="post" enctype="multipart/form-data" class="form-horizontal">
			<div class="controls">
			<h4><a>模板下载</a></h4>
			<hr/>
			</div>
			<input type="hidden" name="importdata" value="true">
			<div class="control-group">
				<label class="control-label">选择要导入的文件:</label>
			<div class="controls">
				
				<input type="file" name="inputExcel" style='width:300px;'>	
					<br/>
				<input class='btn btn-primary' type="submit" value="导入数据">
			</div>
				
			</div>			

		</form>
		
	</div>
</body>
</html>