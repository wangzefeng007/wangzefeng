<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from Login.htm on 2017-03-13 09:19:30
*/
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1"/>
	<meta name="description" content="">
	<meta name="author" content="ThemeBucket">
	<title>隆文贵后台管理系统</title>
	<link href="<?php echo CssURL; ?>/admin/common/style.css" rel="stylesheet">
	<link href="<?php echo CssURL; ?>/admin/common/style-responsive.css" rel="stylesheet">
	<link href="/Templates/Admin/Images/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet">
	<!-- HTML5 shim and Respond.js IE8支持HTML5元素和媒体查询 -->
	<!--[if lt IE 9]>
	<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body class="login-body">
<div class="container">
	<form class="form-signin" action="/index.php?Module=Admin&Action=Login" method="post" id="login_form" autocomplete="off">
		<div class="form-signin-heading text-center">
			<h1 class="sign-title">登录</h1>
<!--			<img src="/Templates/Admin//Images/Admin/login-logo.png" alt=""/>-->
		</div>
		<div class="login-wrap">
			<input type="text" class="form-control" placeholder="用户名" autofocus name="user">
			<input type="password" class="form-control" placeholder="密码" name="pass">
			<input type="text" name="code" placeholder="验证码" class="form-control" style="width: 50%;float: left">
			<img src="/code/pic.jpg" onclick="this.src='/code/pic.jpg?'+Math.random();" style="width: 45%;margin-left: 5%;border-radius: 2px">
			<button class="btn btn-lg btn-login btn-block" type="submit">
				<i class="fa fa-check"></i>
			</button>
			<div class="registration" style="display: none">
				还不是会员?
				<a class="" href="javascript:void(0)">
					注册
				</a>
			</div>
			<label class="checkbox" style="display: none">
				<input type="checkbox" value="remember-me"> 记得账号密码
			<span class="pull-right" style="display: none">
			<a data-toggle="modal" href="javascript:void(0)" id="reset"> 忘记密码?</a>
				<!--<a data-toggle="modal" href="#myModal"> 忘记密码?</a>-->
			</span>
			</label>
		</div>
		<!-- 模态 -->
		<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">忘记密码 ?</h4>
					</div>
					<div class="modal-body">
						<p>
							下面输入您的电子邮件地址重新设置您的密码.
						</p>
						<input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">
					</div>
					<div class="modal-footer">
						<button data-dismiss="modal" class="btn btn-default" type="button">取消</button>
						<button class="btn btn-primary" type="button">提交</button>
					</div>
				</div>
			</div>
		</div>
		<!-- 模态结束 -->
	</form>
</div>
<!--<script src="<?php echo JsURL; ?>/admin/common/jquery-1.10.2.min.js"></script>-->
<!--<script src="<?php echo JsURL; ?>/admin/common/bootstrap.min.js"></script>-->
<!--<script src="<?php echo JsURL; ?>/admin/common/modernizr.min.js"></script>-->
<!--<script src="<?php echo JsURL; ?>/admin/login.js"></script>-->
<!--<script src="<?php echo JsURL; ?>/admin/common/layer/2.4/layer.js"></script>-->
</body>
</html>