<?php
//һ��model����һ�ű�ͨ����ͬ�ķ��������Ա������ɾ�Ĳ�
class emp extends Model{
    function listart(){
        $query = "select aid,title,xqaddress,xqtelphone,xqpoint,nativeplace from dede_addonxiaoqu";
        $this->dsql->Execute('me', $query);//�ο�dedecms�����ݿ���
        $rows = array();
        while($row = $this->dsql->getarray()){
            $rows[] = $row;
        } 
        return $rows;
    }
}
?>