<?php
@set_time_limit(0);
/**
 * ϵͳ���л������
 *
 * @version        $Id: testenv.php 13:57 2011/11/10 tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckPurview('sys_Edit');
$action = isset($action)? $action : '';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['cfg_soft_lang']; ?>">
<title>ϵͳ����Ŀ¼Ȩ�޼��</title>
<link rel="stylesheet" type="text/css" href="css/base.css" />
<link rel="stylesheet" type="text/css" href="css/indexbody.css" />
<script type="text/javascript" src="../include/js/jquery/jquery.js" ></script>
</head>
<body leftmargin="8" topmargin='8' bgcolor="#FFFFFF" style="min-width:840px">
<?php
if(!function_exists('TestWriteable'))
{
	// ����Ƿ��д
	function TestWriteable($d, $c=TRUE)
	{
		$tfile = '_write_able.txt';
		$d = preg_replace("/\/$/", '', $d);
		$fp = @fopen($d.'/'.$tfile,'w');
		if(!$fp)
		{
			if( $c==false )
			{
				@chmod($d, 0777);
				return false;
			}
			else return TestWriteable($d, true);
		}
		else
		{
			fclose($fp);
			return @unlink($d.'/'.$tfile) ? true : false;
		}
	}
}

if(!function_exists('TestExecuteable'))
{
	// ����Ƿ��Ŀ¼��ִ��
	function TestExecuteable($d='.', $siteuRL='', $rootDir='') {
		$testStr = '<'.chr(0x3F).'p'.chr(hexdec(68)).chr(112)."\n\r";
		$filename = md5($d).'.php';
		$testStr .= 'function test(){ echo md5(\''.$d.'\');}'."\n\rtest();\n\r";
		$testStr .= chr(0x3F).'>';
		$reval = false;
		if(empty($rootDir)) $rootDir = DEDEROOT;
		if (TestWriteable($d)) 
		{
			@file_put_contents($d.'/'.$filename, $testStr);
			$remoteUrl = $siteuRL.'/'.str_replace($rootDir, '', str_replace("\\", '/',realpath($d))).'/'.$filename;
			$tempStr = @PostHost($remoteUrl);

			$reval = (md5($d) == trim($tempStr))? true : false;
			unlink($d.'/'.$filename);
			return $reval;
		} else
		{
			return -1;
		}
	}
}


if(!function_exists('PostHost'))
{
	function PostHost($host,$data='',$method='GET',$showagent=null,$port=null,$timeout=30){
		$parse = @parse_url($host);
		if (empty($parse)) return false;
		if ((int)$port>0) {
			$parse['port'] = $port;
		} elseif (!@$parse['port']) {
			$parse['port'] = '80';
		}
		$parse['host'] = str_replace(array('http://','https://'),array('','ssl://'),"$parse[scheme]://").$parse['host'];
		if (!$fp=@fsockopen($parse['host'],$parse['port'],$errnum,$errstr,$timeout)) {
			return false;
		}
		$method = strtoupper($method);
		$wlength = $wdata = $responseText = '';
		$parse['path'] = str_replace(array('\\','//'),'/',@$parse['path'])."?".@$parse['query'];
		if ($method=='GET') {
			$separator = @$parse['query'] ? '&' : '';
			substr($data,0,1)=='&' && $data = substr($data,1);
			$parse['path'] .= $separator.$data;
		} elseif ($method=='POST') {
			$wlength = "Content-length: ".strlen($data)."\r\n";
			$wdata = $data;
		}
		$write = "$method $parse[path] HTTP/1.0\r\nHost: $parse[host]\r\nContent-type: application/x-www-form-urlencoded\r\n{$wlength}Connection: close\r\n\r\n$wdata";
		@fwrite($fp,$write);
		while ($data = @fread($fp, 4096)) {
			$responseText .= $data;
		}
		@fclose($fp);
		empty($showagent) && $responseText = trim(stristr($responseText,"\r\n\r\n"),"\r\n");
		return $responseText;
	}
}

	$allPath = array();
	$needDir = "$cfg_medias_dir|
	$cfg_image_dir|
	$ddcfg_image_dir|
	$cfg_user_dir|
	$cfg_soft_dir|
	$cfg_other_medias|
	$cfg_medias_dir/flink|
	$cfg_cmspath/data|
	$cfg_cmspath/data/$cfg_backup_dir|
	$cfg_cmspath/data/textdata|
	$cfg_cmspath/data/sessions|
	$cfg_cmspath/data/tplcache|
	$cfg_cmspath/data/admin|
	$cfg_cmspath/data/enums|
	$cfg_cmspath/data/mark|
	$cfg_cmspath/data/module|
	$cfg_cmspath/data/rss|
	$cfg_special|
	$cfg_cmspath$cfg_arcdir";
	$needDir = explode('|', $needDir);
	foreach($needDir as $key => $val)
	{
		$allPath[trim($val)] = array(
			'read'=>true,    // ��ȡ
			'write'=>true,   // д��
			'execute'=>false // ִ��
		);
	}
	
	
	// ������ĿĿ¼
	$sql = "SELECT typedir FROM #@__arctype ORDER BY id DESC";
	$dsql->SetQuery($sql);
	$dsql->Execute('al', $sql);
	while($row = $dsql->GetArray('al'))
	{
		$typedir = str_replace($cfg_basehost, '', $row['typedir']);
		if(preg_match("/^http:|^ftp:/i", $row['typedir'])) continue;
		$typedir = str_replace("{cmspath}", $cfg_cmspath, $row['typedir']);
		$allPath[trim($typedir)] = array(
			'read'=>true,    // ��ȡ
			'write'=>true,   // д��
			'execute'=>false // ִ��
		);
	}
	
	// ֻ�����ȡ,������д���Ŀ¼
	$needDir = array(
		'include',
		'member',
		'plus',
	);
	// ��ȡ��Ŀ¼
	function GetSondir($d, &$dirname=array())
	{
		$dh = dir($d);
		while($filename = $dh->read() )
		{
			if(substr($filename, 0, 1)=='.' || is_file($d.'/'.$filename) ||
				  preg_match("#^(svn|bak-)#i", $filename) )
			{
				CONTINUE;
			}
			if(is_dir($d.'/'.$filename)) 
			{
				$dirname[] = $d.'/'.$filename;
				GetSondir($d.'/'.$filename,$dirname);
			}
		}
		$dh->close();
		return $dirname;
	}
	
	//��ȡ�����ļ��б�
	function preg_ls($path=".", $rec=FALSE, $pat="/.*/", $ignoredir='')
	{
		while (substr ($path,-1,1) =="/")
		{
			$path=substr ($path,0,-1);
		}
		if (!is_dir ($path) )
		{
			$path=dirname ($path);
		}
		if ($rec!==TRUE)
		{
			$rec=FALSE;
		}
		$d=dir ($path);
		$ret=Array ();
		while (FALSE!== ($e=$d->read () ) )
		{
			if ( ($e==".") || ($e=="..") )
			{
				continue;
			}
			if ($rec && is_dir ($path."/".$e) && ($ignoredir == '' || strpos($ignoredir,$e ) === FALSE))
			{
				$ret = array_merge ($ret, preg_ls($path."/".$e, $rec, $pat, $ignoredir));
				continue;
			}
			if (!preg_match ($pat, $e) )
			{
				continue;
			}
			$ret[] = $path."/".$e;
		}
		return (empty ($ret) && preg_match ($pat,basename($path))) ? Array ($path."/") : $ret;
	}
	
	foreach($needDir as $key => $val)
	{
		$allPath[trim('/'.$val)] = array(
			'read'=>true,    // ��ȡ
			'write'=>false,   // д��
			'execute'=>true // ִ��
		);
		$sonDir = GetSondir(DEDEROOT.'/'.$val);
		foreach($sonDir as $kk => $vv)
		{
			$vv = trim(str_replace(DEDEROOT, '', $vv));
			$allPath[$vv] = array(
				'read'=>true,    // ��ȡ
				'write'=>false,   // д��
				'execute'=>true // ִ��
			);
		}
		
	}
	
	// ����Ҫִ�е�
	$needDir = array(
		'/images',
		'/templets'
	);
	foreach($needDir as $key => $val)
	{
		$allPath[trim('/'.$val)] = array(
			'read'=>true,    // ��ȡ
			'write'=>false,   // д��
			'execute'=>false // ִ��
		);
		$sonDir = GetSondir(DEDEROOT.'/'.$val);
		foreach($sonDir as $kk => $vv)
		{
			$vv = trim(str_replace(DEDEROOT.'/', '', $vv));
			$allPath[$vv] = array(
				'read'=>true,    // ��ȡ
				'write'=>false,   // д��
				'execute'=>false // ִ��
			);
		}
		
	}
	
	// ����js����ֻ��
	$jsDir = array(
		'/images',
		'/templets',
		'