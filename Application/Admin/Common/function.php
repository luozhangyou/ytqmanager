<?php

/**
 * 获取个人中心菜单
 */
function getTaxById($id,$route_type){
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
            if($route_type==1){
                return $row['short_tax'];
            }else if($route_type==2){
                return $row['long_tax'];
            }else if($route_type==3){
                return $row['long_tax'];
            }
        }
    }
}

/**
 * 获取线路类型
 */
function getRouteType($id){
    if (empty($id)){
        return null;
    }else{
        $object="Route";
        $condition['id']=$id;
        $example['condition']=$condition;
        $row=D($object)->findRow($example,$object);
        if (empty($row)){
            return null;
        }else {
            return $row['type'];
        }
    }
}

/**
 * 获取用户角色（唯一角色）
 */
function getRoleIdByUserId($id){
    $beanName="RoleUser";
	$condition['user_id']=$id;
	$example['condition']=$condition;
	$example['relation']=false;
	$rtr=D($beanName)->getAllList($example,$beanName);
	return $rtr[0];
}