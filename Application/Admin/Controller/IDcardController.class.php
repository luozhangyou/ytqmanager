<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
class IDcardController extends CommonController {
	public $phpbean="IDcard";
    
    public function pageList(){
    	$beanName=$this->phpbean;
		
    	$pageBean['rows']=$_GET['rows'];
    	$pageBean['page']=$_GET['page'];
    	$example['pageBean']=$pageBean;
    	
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	
    	$example['relation']=true;
    	
    	$condition['level']=1;
    	$example['condition']=$condition;
    	
    	$rtr = D($beanName)->pageList($example,$beanName);
    	$total= D($beanName)->countTotal($example,$beanName);
    	
    	$data=array(
    			'rows' => $rtr,
    			'total' => $total
    	);
    	$this->ajaxReturn($data);
    	
    }
    
    public function addOrUpdate(){
    	$user_id=self::getSessionUserId();
    	try {
    		$beanName=$this->phpbean;
    		$data['name']=$_POST['name'];
    		$data['card']=$_POST['card'];
    		$data['order_id']=$_POST['order_id'];
    		$data['id']=$_POST['id'];
    		
    		$rtr['flag']=true;
    		if ($data['id']>0){
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{
    			$rtr['object']= D($beanName)->addRow($data,$beanName);
    			$rtr['msg']="添加成功";
    			$this->ajaxReturn($rtr);
    		}
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function delRows(){
    	try {
    		$beanName=$this->phpbean;
    		$data['ids']=$_POST['id'];
    		$rtr['flag']=true;
    		$rtr['object']= D($beanName)->delRows($data,$beanName);
    		$rtr['msg']="操作成功";
    		$this->ajaxReturn($rtr);
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function getAll(){
    	$beanName=$this->phpbean;
    	$example['relation']=false;
    	 
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function getAllByOrderId(){
        $beanName=$this->phpbean;
        $example['relation']=false;
        
        $condition['order_id']=$_POST['order_id'];
        $example['condition']=$condition;
        
        $rtr=D($beanName)->getAllList($example,$beanName);
        $this->ajaxReturn($rtr);
    }
    
}