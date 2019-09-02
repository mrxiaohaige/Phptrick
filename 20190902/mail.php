<?php
require_once("../include/common.inc.php");

if($dopost == "saveedit")
{
//接收参数值	
$name = htmlspecialchars($name);

//定义标题
$mailtitle = "Wap用户提交表单";

//定义内容
$mailbody .= "<p>姓名：{$name}\r\n</br>年龄：{$age}\r\n</br>手机号码：{$number}\r\n</br>校区：{$school}\r\n</br>预约时间：{$time}</p>";

//定义接收信箱
$email .= "naver2333@163.com,604607812@qq.com";//多个信箱使用英文逗号分隔开

$headers = "From: ".$cfg_adminemail."\r\nReply-To: ".$cfg_adminemail;
if($cfg_sendmail_bysmtp == 'Y' && !empty($cfg_smtp_server))
{
$mailtype = 'HTML';
require_once('orders.mail.php');
$smtp = new smtp($cfg_smtp_server,$cfg_smtp_port,true,$cfg_smtp_usermail,$cfg_smtp_password);
$smtp->debug = false;
$smtp->sendmail($email, $cfg_smtp_usermail, $mailtitle, $mailbody, "HTML");
}
else
{
@mail($email, $mailtitle, $mailbody, $headers);
}
echo "<script language='javascript'>";
echo "alert('发送成功!');history.go(-1)";
echo "</script>";
exit();
}
else
{
echo "<script language='javascript'>";
echo "alert('参数错误!');history.go(-1)";
echo "</script>";
}
?>