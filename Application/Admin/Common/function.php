<?php

/**
 * 获取个人中心菜单
 */
function getTaxById($id){
    if (empty($id)){
        return null;
    }else{
        $object="Platform";
        $condition['id']=$id;
        $example['condition']=$condition;
        $row=D($object)->findRow($example,$object);
        if (empty($row)){
            return null;
        }else {
            return $row['tax'];
        }
    }
}