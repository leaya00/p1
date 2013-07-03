<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>代码测试</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8"/>


</head>
<body>


<?php
	require_once "./global.php";
	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

	date_default_timezone_set('PRC');

	/** Include PHPExcel_IOFactory */
	require_once './lib/PHPExcel_1.7.9_doc/PHPExcel/IOFactory.php';
	// require_once './lib/PHPExcel_1.7.9_doc/PHPExcel.php';
	
	
	
	$objReader = PHPExcel_IOFactory::createReader('Excel5');
	$objPHPExcel = PHPExcel_IOFactory::load("./wptj/template.xls");
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow(); // 取得总行数
	$highestColumn = $sheet->getHighestColumn(); // 取得总列数
	echo $highestRow."--".$highestColumn;
	$x=$sheet->getCell("A1")->getValue();
	
	echo $x;
?>
</body>
</html>
