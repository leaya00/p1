<?php
/*
输入：1,2,3
输出:'1','2','3'
*/
function parseParm($m){
    $r = explode(",",$m);
    foreach ($r as $key => $value) {
        $r[$key]="'$value'";
    }
    return implode($r, ",");
}