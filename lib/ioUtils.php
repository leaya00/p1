<?php


function getDirFileToArray($dir){
	$result=array();
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($file = readdir($dh)) !== false) {
				if(filetype($dir . $file)=='file')
				$result[]= iconv('GB2312','UTF-8',$file);
			} closedir($dh);
		}
	}
	return  $result;
}