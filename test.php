
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>代码测试</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />


</head>
<body>


<?php

header("Content-Type: text/html; charset=utf-8");     //编码及内容类型头信息加在这里
//require './lib/dbUtils.php';
//require './lib/DbManage.php';
//$backup=new DbManage(Db::$root,Db::$user,Db::$pass,Db::$db);
//$backup->backup('','./backup_file/',null);

//date_default_timezone_set('PRC');
//echo date ( 'Y-m-d-H-i-s' );


//iconv('GB2312','UTF-8',$file)
$dir = "./backup_file/";
// Open a known directory, and proceed to read its contents
$result=array();
if (is_dir($dir)) {
	if ($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if(filetype($dir . $file)=='file')
				$result[]= iconv('GB2312','UTF-8',$file)."<br/>";
		} closedir($dh);
	}
}
//['filename']
$xx=array();
foreach ($result as $tmp){
	$xx[]['filename']=$tmp;
	
}
echo json_encode($xx);
?>
</body>
</html>
