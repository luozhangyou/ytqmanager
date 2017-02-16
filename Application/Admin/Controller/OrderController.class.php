<?php
namespace Admin\Controller;
use Admin\Common\Controller\CommonController;
use Org\Util\Date;
class OrderController extends CommonController {
	public $phpbean="Order";
    
    public function pageList(){
    	$beanName=$this->phpbean;
		
    	$pageBean['rows']=$_GET['rows'];
    	$pageBean['page']=$_GET['page'];
    	$example['pageBean']=$pageBean;
    	
    	$order['sort']=$_GET['sort'];
    	$order['order']=$_GET['order'];
    	$example['order']=$order;
    	
    	$example['relation']=true;
    	
//     	$condition['level']=1;
        
    	$user_id=self::getSessionUserId();
    	$roleUser=getRoleIdByUserId($user_id);
    	$role_id=$roleUser['role_id'];
    	if($role_id==2){
    	    $condition['o.create_user']=$user_id;
    	}
    	
    	if (isset($_GET['account_status'])&&$_GET['account_status']!=""){
    	    $account_status=$_GET['account_status'];
    	    $condition['account_status']=$account_status;
    	}
    	
    	if (isset($_GET['start_time_01'])&&$_GET['start_time_01']!=""&&isset($_GET['start_time_02'])&&$_GET['start_time_02']!=""){
    	    
    	    $condition['start_time']=array(array('EGT',$_GET['start_time_01']),array('ELT',$_GET['start_time_02'])) ;;
    	}
    	
    	if (isset($_GET['order_num'])&&$_GET['order_num']!=""){
    	    $condition['order_num']=$_GET['order_num'];
    	}
    	
    	if (isset($_GET['order_status'])&&$_GET['order_status']!=""){
    	    $condition['order_status']=$_GET['order_status'];
    	}
    	
    	if (isset($_GET['route_search_order'])&&$_GET['route_search_order']!=""){
    	    $condition['route_id']=$_GET['route_search_order'];
    	}
    	
    	if (isset($_GET['provider_search_order'])&&$_GET['provider_search_order']!=""){
    	    $condition['provider_id']=$_GET['provider_search_order'];
    	}
    	
    	$condition['is_delete']=array('neq',1);
    	
    	$example['condition']=$condition;
    	
    	$rtr = D($beanName)->pageListOrder($example,$beanName);
    	$total= D($beanName)->countTotalOrder($example,$beanName);
    	
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
    		$data=$_POST['data'];
    		$rtr['flag']=true;
    		
    		if ($data['purchase_price']!=""&&$data['sale_price']!=""&&$data['platform_id']!=""){
    		    $route_type=getRouteType($data['route_id']);//获取线路类型;
    		    $tax=getTaxById($data['platform_id'],$route_type);//获取对应类型线路税点
    		    
    		    $come_price=$data['sale_price']+$data['outline_sale_price']+$data['pay_price'];
    		    $out_price=$data['sale_price']*($tax/100)+$data['shuadan_price']+
    		              $data['hotal_price']+$data['air_price']+$data['other_price']+$data['purchase_price'];

    		    $data['profit_price']=$come_price-$out_price;
    		}
    		
    		if ($data['id']>0){
    			$data['update_time']=time();
    			$data['update_user']=$user_id;
    			$rtr['object'] = D($beanName)->updateRow($data,$beanName);
    			$rtr['msg']="更新成功";
    			$this->ajaxReturn($rtr);
    		}else{

    		    $data['account_status']=1;
    			$data['create_time']=time();
    			$data['create_user']=$user_id;
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
    		$data=$_POST['data'];
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
    
    public function uplateIsDetele(){
        try {
            $beanName=$this->phpbean;
            $data=$_POST['data'];
            $dataRow['id']=$data['ids'];
            $dataRow['is_delete']=1;
            $rtr['flag']=true;
            $rtr['object']= D($beanName)->uplateIsDetele($dataRow,$beanName);
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
    	 
    	$example['condition']=$condition;
    	$rtr=D($beanName)->getAllList($example,$beanName);
    	$this->ajaxReturn($rtr);
    }
    
    public function update_account_status(){
        try {
    		$beanName=$this->phpbean;
    		$data['id']=$_POST['id'];
    		$data['account_status']=2;
    		$rtr['flag']=true;
    		$rtr['object']= D($beanName)->updateAccountStatus($data,$beanName);
    		$rtr['msg']="操作成功";
    		$this->ajaxReturn($rtr);
    	} catch (\Exception $e) {
    		$rtr['flag']=false;
    		$rtr['msg']="操作失败";
    		$this->ajaxReturn($rtr);
    	}
    }
    
    public function update_refund_info(){
        try {
            $beanName=$this->phpbean;
            $data=$_POST['data'];
            $data['order_status']=3;
            $rtr['flag']=true;
            
            $condition['id']=$data['id'];
            $example['condition']=$condition;
            
            $order=D($beanName)->findRow($example,$beanName);
            $route_type=getRouteType($order['route_id']);//获取线路类型;
            $tax=getTaxById($order['platform_id'],$route_type);//获取对应类型线路税点
            
            
            if($data['refund_status']==1){//线上退款
                $come_price=$order['sale_price']+$order['outline_sale_price'];
                $out_price=$data['refund_customer_price']+$data['refund_provider_price']+(($order['sale_price']-$data['refund_customer_price'])*($tax/100));
                $refund_total=$come_price-$out_price;
            }elseif ($data['refund_status']==2){//线下退款
                $come_price=$order['sale_price']+$order['outline_sale_price'];
                $out_price=$data['refund_customer_price']+$data['refund_provider_price']+($come_price*($tax/100));;
                $refund_total=$come_price-$out_price;
            }
            $data['refund_total_price']=$refund_total;
            
            $object_id= D($beanName)->update_refund_info($data,$beanName);
            
            $rtr['demo']=$tax;
            $rtr['msg']="操作成功";
            $this->ajaxReturn($rtr);
        } catch (\Exception $e) {
            $rtr['flag']=false;
            $rtr['msg']="操作失败";
            $this->ajaxReturn($rtr);
        }
        
    }
    //根据ids批量结算
    public function update_account_statuss(){
        $ids=$_POST['ids'];
        
        try {
            $beanName=$this->phpbean;
            $data['account_status']=2;
            $rtr['flag']=true;
            
            for($i=0;$i<count($ids);$i++){
                $data['id']=$ids[$i];
                D($beanName)->updateAccountStatus($data,$beanName);
            }
            
            $rtr['msg']="操作成功";
            $this->ajaxReturn($rtr);
        } catch (\Exception $e) {
            $rtr['flag']=false;
            $rtr['msg']="操作失败";
            $this->ajaxReturn($rtr);
        }
    }
}