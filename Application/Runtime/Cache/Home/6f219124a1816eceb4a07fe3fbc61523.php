<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>后台管理登录</title>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" /> 
<title>js+css</title>

<link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Home/widget/bootstrap-3.3.5-dist/css/bootstrap.min.css" />

<script type="text/javascript" src="/taoyongjin/Public/Home/theme/default/js/jquery.min.js"></script>
<script type="text/javascript" src="/taoyongjin/Public/Home/theme/default/js/jquery.ajax.js"></script>
</head>
<body>
	
</body>
</html>
<link rel="stylesheet" type="text/css" href="/taoyongjin/Public/Home/theme/default/css/login.css" />
<style type="text/css">
.shadow-box{
	background: #FFF none repeat scroll 0% 0%;
	border-radius: 5px;
	box-shadow: 0px 1px 3px 0px rgba(0, 0, 0, 0.25);
}
body{
	/* background: url("/taoyongjin/Public/admin/default/images/loginBg.png") no-repeat; */
	-moz-background-size:100% 100%; 
	background-size:100% 100%;	
}
.loginBg{
	padding-top: 40px;
	padding-bottom: 40px;
}
</style>
</head>
<body>
	<div class="loginBg">
	    <form id="loginForm" class="container " action="/taoyongjin/Home/Login/login" method="POST" >
	      <div class="form-signin shadow-box">
	        <h2 class="form-signin-heading">后台登录</h2>
	        <div class="form-group">
		        <label for="inputEmail" class="sr-only">邮箱</label>
		        <input name="userName" id="inputEmail" class="form-control" placeholder="帐户" required="true" autofocus="">
		    </div>
	        <div class="form-group">    
	        	<label for="inputPassword" class="sr-only">密码</label>
	        	<input name="password" id="exampleInputPassword1" class="form-control" placeholder="密码" required="" type="password">
	        </div>	
	        <label for="inputPassword" class="sr-only">验证码</label>
	        <input name="code" id="inputCheck" style="width:150px;float:left;border-radius:0px;" class="form-control" placeholder="验证码" required="" type="text">
	        <div style="float:left;width:150px;height:45px;">
	        	<img id="checkeImg" alt="看不清" title="看不清请点击" src="" style="width:150px;height:45px;cursor:pointer;">
	        </div> 
	        <div style="clear:both;"></div>
	        <div class="checkbox">
	          <label>
	            <!-- <input value="remember-me" type="checkbox"> 记住帐号 -->
	          </label>
	        </div>
	        <button id="loginSubmit" class="btn btn-lg btn-primary btn-block">登录</button>
	        <div style="clear:both;height:20px;"></div>
	     </div> <!-- /container -->
	     </form>
     </div>
    <script type="text/javascript">
    	$(document).ready(function(){
    		//获取验证码图片
    		$("#checkeImg").attr("src","/taoyongjin/Home/Login/getVerify"+'/'+Math.random());
    		$("#checkeImg").click(function(){
    			$("#checkeImg").attr("src","/taoyongjin/Home/Login/getVerify"+'/'+Math.random());//
    		});
    	});
    </script>
</body>
</html>