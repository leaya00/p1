<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php	
	require_once("lib/checkUser.php");
	set_time_limit(0);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>导入基础数据</title>
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
if(!empty($_GET['succ_msg'])){

	echo "导入成功第".$_GET['succ_msg']."行<br/>";
}

?></p>
</h3>
<h3>
<p class="text-error"><?php
if(!empty($_GET['error_msg'])){

	echo "导入失败第".$_GET['error_msg']."行<br/>";
}

?></p>
</h3>
<h3>
<p class="text-error"><?php
if(!empty($_GET['file_msg'])){

	echo "上传文件失败:".$_GET['file_msg']."<br/>";
}

?></p>
</h3>
<?php

if(!empty($_POST['importdata'])){
	$uploadDir="upload/";
	//文件上传
	if ($_FILES["inputExcel"]["error"] > 0)
	{
		$msg=$_FILES["inputExcel"]["error"];
		if($msg==4)
		$msg="没有选择文件!";
		if($msg==1)
		$msg="文件大小超过限制!";	
		echo "<script>location.href='importData.php?file_msg=".urlencode($msg)."'</script>";
	}
	else{
		if(!is_dir($uploadDir)){
			mkdir($uploadDir);
		}
		$filename=uniqid().".xls";
		move_uploaded_file($_FILES["inputExcel"]["tmp_name"],
		$uploadDir.$filename);

		//导入excel数据

		require_once '../lib/dbUtils.php';
		/** Error reporting */
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('PRC');

		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');


		/** Include PHPExcel_IOFactory */
		require_once '../lib/PHPExcel_1.7.9_doc/PHPExcel/IOFactory.php';

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objPHPExcel = PHPExcel_IOFactory::load($uploadDir.$filename);
		$sheet = $objPHPExcel->getSheet(0);
		$highestRow = $sheet->getHighestRow(); // 取得总行数
		$highestColumn = $sheet->getHighestColumn(); // 取得总列数
		//	echo $highestRow."--".$highestColumn;
		$db=new Dbi();
		$succ_msg=array();
		$error_msg=array();
		//admin 录入人填写空
		$writeUser=$_SESSION['username'];
		if($writeUser=='admin'){
			$writeUser='';
		}
		//shop,object,price,sdate,edate,postdate,remark
		for ($row=2;$row<=$highestRow;$row++){
			$sql= "INSERT INTO `wptj_data` (shop,object,price,sdate,edate,postdate,remark,createname) values (?,?,?,?,?,?,?,?)";
			$shop=$sheet->getCell("A$row")->getValue();
			$object=$sheet->getCell("B$row")->getValue();
			$price=$sheet->getCell("C$row")->getValue();
			$sdate=$sheet->getCell("D$row")->getValue();
			$sdate=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($sdate));
			$edate=$sheet->getCell("E$row")->getValue();
			$edate=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($edate));
			$postdate=$sheet->getCell("F$row")->getValue();
			$postdate=date('Y-m-d',PHPExcel_Shared_Date::ExcelToPHP($postdate));
			$remark=$sheet->getCell("G$row")->getValue();
			$createname=$writeUser;
			$stmt =mysqli_prepare($db->link,$sql);
			mysqli_stmt_bind_param($stmt,'ssdsssss',
			$shop,$object,$price,$sdate,$edate,$postdate,$remark,$createname);

			$r=mysqli_stmt_execute($stmt);

			if($r){
				$succ_msg[]=$row;
			}else{

				$error_msg[]=$row;
			}
			//
		}		
		//删除文件
		unlink($uploadDir.$filename);
		echo "<script>location.href='importData.php?succ_msg=".implode($succ_msg, ",")."&error_msg=".implode($error_msg, ",")."'</script>";

	}


}
?>
<div class="container" style='width: 500px; margin-top: 50px;'>

<form name="form1" id="form1" method="post"
	enctype="multipart/form-data" class="form-horizontal">
<div class="controls">
<h4><a href="./template_data.xls">模板下载</a></h4>
<hr />
</div>
<input type="hidden" name="importdata" value="true">


<div class="control-group"><label class="control-label">选择要导入的文件:</label>
<div class="controls"><input type="file" name="inputExcel" id="inputExcel"
	style='width: 300px;'><br />
<input class='btn btn-primary' type="button" onclick="exec();"
	value="导入数据"></div>

</div>

</form>

</div>
<script>
	function GetFileName(filepath) {
           if (filepath != "") {
               var names = filepath.split("\\");
               return names[names.length - 1];
           }
     }
	function exec(){
		var filepath=$("#inputExcel").val();
		if(filepath===''){
			alert('请选择文件');
			return;
		}
		var r=confirm("是否要导入'"+GetFileName(filepath)+"'？");
		if(r){
			$("#form1").submit();
			}
		}
</script>
</body>
</html>
