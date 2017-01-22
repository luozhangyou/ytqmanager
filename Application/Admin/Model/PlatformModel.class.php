<?php
namespace Admin\Model;
use Admin\Common\Model\CommonRelationModel;
class PlatformModel extends CommonRelationModel{
    
    protected $trueTableName =  'bbb_platform';
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
    		),
    );
    
}

?>