<?php
$urls = array(
    'http://www.xinsiwen.com/jiaoyuredian/2016/0624/35.html',
    'http://www.xinsiwen.com/jiaoyuredian/2016/0624/34.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/33.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/32.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/31.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/30.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/29.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/6.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/5.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/4.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/3.html',
	'http://www.xinsiwen.com/jiaoyuredian/2016/0624/2.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/16.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/15.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/14.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/13.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/12.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/11.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/10.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/9.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/8.html',
	'http://www.xinsiwen.com/pinpaidongtai/2016/0624/7.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/28.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/27.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/26.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/25.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/24.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/23.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/22.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/21.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/20.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/19.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/18.html',
	'http://www.xinsiwen.com/hangyezixun/2016/0624/17.html',
	
	
	
);
$api = 'http://data.zz.baidu.com/urls?site=www.xinsiwen.com&token=60MZIBKpvwqtVw7p';
$ch = curl_init();
$options =  array(
    CURLOPT_URL => $api,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => implode("\n", $urls),
    CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
);
curl_setopt_array($ch, $options);
$result = curl_exec($ch);
echo $result;
?>