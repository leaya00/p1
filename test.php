
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>代码测试</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />


</head>
<body>


<?php
    $m="01,02";
    $r = explode(",",$m);

    foreach ($r as $key => $value) {
            $r[$key]="'$value'";
    }
    print_r(implode($r, ","));
?>
</body>
</html>
