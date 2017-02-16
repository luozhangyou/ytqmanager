<?php
namespace Home\Controller;
use Think\Verify;
use Org\Util\Rbac;
use Home\Common\Controller\CommonController;
class LoginController extends CommonController {
	//获取验证码图片
	public function getVerify(){
		$verify=new Verify();
		$verify->entry(1);
	}
	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
	function login($userName="",$password="",$code="",$id=1){
		$verify = new Verify();
		$flagCheck=$verify->check($code, $id);
		if($flagCheck){
			$user=M('user');
			//根据用户名查询
			$cond['account']=$userName;
			$cond['active']=array('gt',0);
			//通过authenticate读取用户信息
			$result=RBAC::authenticate($cond);
			$rtr=null;
			if($result){
				if($result['password']==md5($password)){
					$_SESSION[C('USER_AUTH_KEY')]=$result['id'];
					$_SESSION["nickname"]=$result['nickname'];
					$_SESSION["user_type"]=$result['type'];
					RBAC::saveAccessList();
					echo "<SCRIPT language=JavaScript>location.href='".__ROOT__."/Admin/Index/index';</SCRIPT>";
	
				}else{
					echo "<SCRIPT language=JavaScript>alert('用户密码错误');</SCRIPT>";
					$this->display('Index/login_manage');
				}
			}else{
				echo "<SCRIPT language=JavaScript>alert('帐号不存在');</SCRIPT>";
				$this->display('Index/login_manage');
			}
		}else {
			echo "<SCRIPT language=JavaScript>alert('验证码不存在');</SCRIPT>";
			$this->display('Index/login_manage');
		}
	}
	public function logout_manange(){
		session_destroy();
		echo "<SCRIPT language=JavaScript>location.href='".__ROOT__."/Home/Index/login_manage';</SCRIPT>";
	}
	
	
	
}