<?php
//一个model操作一张表。通过不同的方法，来对表进行增删改查
class emp extends Model{
    function listart(){
        $query = "select aid,title,xqaddress,xqtelphone,xqpoint,nativeplace from dede_addonxiaoqu";
        $this->dsql->Execute('me', $query);//参考dedecms的数据库类
        $rows = array();
        while($row = $this->dsql->getarray()){
            $rows[] = $row;
        } 
        return $rows;
    }
}
?>