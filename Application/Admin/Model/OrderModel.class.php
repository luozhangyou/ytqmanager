<?php
namespace Admin\Model;
use Admin\Common\Model\CommonRelationModel;
class OrderModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_order';
    protected $_link = array(
    		'createUser'=>array(
    				'mapping_type'  => self::BELONGS_TO,
    				'class_name'  => 'User',
    				'foreign_key' => 'create_user',
    				'mapping_name' => 'createUser'
    		),
    		'updateUser'=>array(
    				'mapping_type'  => self::BELONGS_TO,
    				'class_name'  => 'User',
    				'foreign_key' => 'update_user',
    				'mapping_name' => 'updateUser'
    		)
    );
    
    
    public static function pageListOrder($example,$beanName){
        $object = D($beanName);
        $order=$example['order'];
        $condition=$example['condition'];
        $pageBean=$example['pageBean'];
        $relation=$example['relation'];
        $result=$object->
            distinct(true)->
            field('o.id,o.start_time,o.end_time,o.record_time,o.number,o.name,o.mobile,o.route_id,o.provider_id,
                   o.sale_price,o.purchase_price,o.pay_price,o.platform_id,o.create_user,o.create_time,o.update_user,o.update_time,
                   p.name as platform_name,p.store_name as store_name,p.tax as tax,pvd.name as provider_name,r.name as route_name')->
            alias('o')->
            join('LEFT JOIN __PLATFORM__ p ON p.id = o.platform_id')->
            join('LEFT JOIN __PROVIDER__ pvd  ON pvd.id = o.provider_id')->
            join('LEFT JOIN __ROUTE__ r ON r.id = o.route_id')->
            where($condition)->
            order($order['sort'].' '.$order['order'])->
            page($pageBean['page'],$pageBean['rows'])->relation($relation)->select();
        return $result;
    }
    
    public static function countTotalOrder($example,$beanName){
        $condition=$example['condition'];
        return $count = D($beanName)->where($condition)->count();
    }
    
}

?>