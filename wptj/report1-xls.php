<?php	
	require_once("lib/checkUser_json.php");
?>
<?php
require_once "../global.php";
require_once './wptj/lib/report.php';
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('PRC');
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once './lib/PHPExcel_1.7.9_doc/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("")
							 ->setLastModifiedBy("")
							 ->setTitle("")
							 ->setSubject("")
							 ->setDescription("")
							 ->setKeywords("")
							 ->setCategory("");
//set sheet
$sheet=$objPHPExcel->setActiveSheetIndex(0);

//输出列头
$rowIndex=1;
$sheet->setCellValueByColumnAndRow(1,$rowIndex, '摊销起始日期');
$sheet->getStyleByColumnAndRow(1,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(2,$rowIndex, '摊销截止日期');
$sheet->getStyleByColumnAndRow(2,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(3,$rowIndex, '总金额');
$sheet->getStyleByColumnAndRow(3,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(4,$rowIndex,'店铺代码');
$sheet->getStyleByColumnAndRow(4,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(5,$rowIndex, '店铺名称');
$sheet->getStyleByColumnAndRow(5,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(6,$rowIndex,'物品代码');
$sheet->getStyleByColumnAndRow(6,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(7,$rowIndex, '物品名称');
$sheet->getStyleByColumnAndRow(7,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(8,$rowIndex, '总摊销天数');
$sheet->getStyleByColumnAndRow(8,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(9,$rowIndex, '已摊销天数');
$sheet->getStyleByColumnAndRow(9,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(10,$rowIndex, '已摊销金额');
$sheet->getStyleByColumnAndRow(10,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(11,$rowIndex, '剩余摊销天数');
$sheet->getStyleByColumnAndRow(11,$rowIndex)->getFont()->setBold(true);
$sheet->setCellValueByColumnAndRow(12,$rowIndex, '剩余摊销金额');
$sheet->getStyleByColumnAndRow(12,$rowIndex)->getFont()->setBold(true);
//输出数据
$result=report1();
$root=$result['root'];
$rowIndex=2;
foreach($root as $rowkey=>$row){ 
	$sheet->setCellValueByColumnAndRow(1,$rowIndex, $row['sdate']);
	$sheet->setCellValueByColumnAndRow(2,$rowIndex, $row['edate']);
	$sheet->setCellValueByColumnAndRow(3,$rowIndex, $row['price']);
	$sheet->setCellValueExplicitByColumnAndRow(4,$rowIndex,$row['shop'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueByColumnAndRow(5,$rowIndex, $row['shop_s']);
	$sheet->setCellValueExplicitByColumnAndRow(6,$rowIndex,$row['object'], PHPExcel_Cell_DataType::TYPE_STRING);
	$sheet->setCellValueByColumnAndRow(7,$rowIndex, $row['object_s']);
	$sheet->setCellValueByColumnAndRow(8,$rowIndex, $row['sumday']);
	$sheet->setCellValueByColumnAndRow(9,$rowIndex, $row['nowday']);
	$sheet->setCellValueByColumnAndRow(10,$rowIndex, $row['nowprice']);
	$sheet->setCellValueByColumnAndRow(11,$rowIndex, $row['lostday']);
	$sheet->setCellValueByColumnAndRow(12,$rowIndex, $row['lostprice']);
	
	$rowIndex++;
} 
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('export');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment;filename="report1.xls"');


header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
