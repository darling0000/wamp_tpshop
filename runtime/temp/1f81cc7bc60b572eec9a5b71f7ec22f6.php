<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"D:\WWW\tpshop\public/../application/home\view\login\register.html";i:1529128731;}*/ ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE">
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title>个人注册</title>

    <link rel="stylesheet" type="text/css" href="/static/home/css/all.css" />
    <link rel="stylesheet" type="text/css" href="/static/home/css/pages-register.css" />
    
	<script type="text/javascript" src="/static/home/js/all.js"></script>
	<script type="text/javascript" src="/static/home/js/pages/register.js"></script>
</head>

<body>
	<div class="register py-container ">
		<!--head-->
		<div class="logoArea">
			<a href="" class="logo"></a>
		</div>
		<!--register-->
		<div class="registerArea">
			<h3>注册新用户<span class="go">我有账号，去<a href="<?php echo url('login'); ?>" target="_blank">登陆</a></span></h3>
			<div class="info">
				<form action="<?php echo url('phone'); ?>" method="post" id="reg_form" class="sui-form form-horizontal">
					<div class="control-group">
						<label class="control-label">手机号：</label>
						<div class="controls">
							<input type="text" id="phone" name="phone" placeholder="请输入你的手机号" class="input-xfat input-xlarge">
							<span class="error"></span>
							<span class="error" style="color: #009900"></span>
						</div>
					</div>
					<div class="control-group">
						<label for="inputPassword" class="control-label">验证码：</label>
						<div class="controls">
							<input type="text" id="code" name="code" placeholder="验证码" class="input-xfat input-xlarge" style="width:120px">
							<button type="button" class="btn-xlarge" id="dyMobileButton">发送验证码</button>
							<span class="error"></span>
						</div>
					</div>
					<div class="control-group">
						<label for="inputPassword" class="control-label">登录密码：</label>
						<div class="controls">
							<input type="password" id="password" name="password" placeholder="设置登录密码" class="input-xfat input-xlarge">
							<span class="error"></span>
						</div>
					</div>
					<div class="control-group">
						<label for="inputPassword" class="control-label">确认密码：</label>
						<div class="controls">
							<input type="password" id="repassword" name="repassword" placeholder="再次确认密码" class="input-xfat input-xlarge">
							<span class="error"></span>
						</div>
					</div>
					<div class="control-group">
						<label for="inputPassword" class="control-label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<div class="controls">
							<input name="m1" type="checkbox" value="2" ><span>同意协议并注册《品优购用户协议》</span>
							<span class="error"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label"></label>
						<div class="controls btn-reg">
							<a id="reg_btn" class="sui-btn btn-block btn-xlarge btn-danger reg-btn" href="javascript:;">完成注册</a>
						</div>
					</div>
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
		<!--foot-->
		<div class="py-container copyright">
			<ul>
				<li>关于我们</li>
				<li>联系我们</li>
				<li>联系客服</li>
				<li>商家入驻</li>
				<li>营销中心</li>
				<li>手机品优购</li>
				<li>销售联盟</li>
				<li>品优购社区</li>
			</ul>
			<div class="address">地址：北京市昌平区建材城西路金燕龙办公楼一层 邮编：100096 电话：400-618-4000 传真：010-82935100</div>
			<div class="beian">京ICP备08001421号京公网安备110108007702
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
//	window.onload = function(){
//		var reg_btn = document.getElementById('reg_btn');
//		reg_btn.onclick = function () {
//			var flag = 0;
//			var phone = document.getElementById('phone').value;
//			var phone_pattern = /^1[3-9]\d{9}$/;
//			if (phone == ''){
//				document.getElementById('phone').nextElementSibling.innerHTML = '手机号不能为空';
//				flag++;
//			}else if(!phone_pattern.test(phone)){
//				document.getElementById('phone').nextElementSibling.innerHTML = '手机号格式不正确';
//				flag++;
//			}else{
//				document.getElementById('phone').nextElementSibling.innerHTML = '';
//			}
//			var code = document.getElementById('code').value;
//			if (code == ''){
//				document.getElementById('code').nextElementSibling.nextElementSibling.innerHTML = '验证码不能为空';
//				flag++;
//			}else{
//				document.getElementById('code').nextElementSibling.nextElementSibling.innerHTML = '';
//			}
//			var password = document.getElementById('password').value;
//			if (password == ''){
//				document.getElementById('password').nextElementSibling.innerHTML = '密码不能为空';
//				flag++;
//			}else{
//				document.getElementById('password').nextElementSibling.innerHTML = '';
//			}
//			var repassword = document.getElementById('repassword').value;
//			if (repassword == ''){
//				document.getElementById('repassword').nextElementSibling.innerHTML = '确认密码不能为空';
//				flag++;
//			}else{
//				document.getElementById('repassword').nextElementSibling.innerHTML = '';
//			}
//			var xieyi = document.getElementsByName('m1');
//			if(xieyi[0].checked == false){
//				xieyi[0].nextElementSibling.nextElementSibling.innerHTML = '请阅读并同意协议';
//				flag++;
//			}else {
//				xieyi[0].nextElementSibling.nextElementSibling.innerHTML = '';
//			}
//			if (flag > 0){
//				return;
//			}
//			var reg_form = document.getElementById('reg_form');
//			reg_form.submit();
//
//		}
//		//同意协议绑定onchange事件
//		var xieyi = document.getElementsByName('m1');
//		xieyi[0].onchange = function () {
////			console.log(123);
//			if (xieyi[0].checked == false) {
//				xieyi[0].nextElementSibling.nextElementSibling.innerHTML = '请阅读并同意协议';
//			} else {
//				xieyi[0].nextElementSibling.nextElementSibling.innerHTML = '';
//			}
//		}
//		//给“发送验证码”标签绑定点击事件
//		var dyMobileButton = document.getElementById('dyMobileButton');
//		dyMobileButton.onclick = function () {
//			//设置定时器 1次/60S
//			var time = 6;
//			var interval = setInterval(function () {
//				if(time>0){
//					time--;
//					dyMobileButton.innerHTML = "重新发送：" + time + 's';
//					dyMobileButton.disabled = true;
//				}else if(time == 0){
//					dyMobileButton.innerHTML = "发送验证码";
//					dyMobileButton.disabled = false;
//					clearInterval(interval);
//				}
//			},1000);
//		}
//
//		var phone = document.getElementById('phone');
//		phone.onfocus = function () {
//			phone.nextElementSibling.innerHTML = '请填写11位手机号';
//		}
//		phone.onblur = function () {
//			phone.nextElementSibling.innerHTML = '';
//		}
//		var code = document.getElementById('code');
//		code.onfocus = function () {
//			code.nextElementSibling.nextElementSibling.innerHTML = '请填写验证码';
//		}
//		code.onblur = function () {
//			code.nextElementSibling.nextElementSibling.innerHTML = '';
//		}
//		var password = document.getElementById('password');
//		password.onfocus = function () {
//			password.nextElementSibling.innerHTML = '请设置6-12位密码，包含（0-9，a-z，_,!,?,）';
//		}
//		password.onblur = function () {
//			password.nextElementSibling.innerHTML = '';
//		}
//		var repassword = document.getElementById('repassword');
//		repassword.onfocus = function () {
//			repassword.nextElementSibling.innerHTML = '请确认密码';
//		}
//		repassword.onblur = function () {
//			repassword.nextElementSibling.innerHTML = '';
//		}
//	}
</script>
<script>
	//定义载入事件
	$(function () {
		$('#dyMobileButton').click(function () {
			//
			var phone = $('#phone').val();
			if(phone == ''){
				return;
			}
			if(!/^1[3-9]\d{9}$/.test(phone)){
				return;
			}
			var data = {"phone":phone};
			//
			$.ajax({
				"url":"<?php echo url('sendcode'); ?>",
				"type":"post",
				"data":data,
				"dataType":"json",
				"success":function (res) {
					alert(res.msg);
				},
			})
			var time = 6;
			var interval = setInterval(function () {
				if(time > 0){
					time--;
					$('#dyMobileButton').html('重新发送，' + time + 's');
					$('#dyMobileButton').attr('disabled',true);
				}else{
					$('#dyMobileButton').html('发送验证码');
					$('#dyMobileButton').attr('disabled',false);
					clearInterval(interval);
				}
			},1000);
		})
		//获取 完成注册 的a标签 绑定点击事件
		$('#reg_btn').click(function () {
			//检测input value值不能为空
			var flag = 0;
			var phone = $('#phone').val();
			if(phone == ''){
				$('#phone').parent().find('.error').html('手机号不能为空');
				flag++;
			}else{
				$('#phone').parent().find('.error').html('');
			}
			var code = $('#code').val();
			if(code == ''){
				$('#code').parent().find('.error').html('验证码不能为空');
				flag++;
			}else{
				$('#code').parent().find('.error').html('');
			}
			var password = $('#password').val();
			if(password == ''){
				$('#password').parent().find('.error').html('密码不能为空');
				flag++;
			}else{
				$('#password').parent().find('.error').html('');
			}
			var repassword = $('#repassword').val();
			if(repassword == ''){
				$('#repassword').parent().find('.error').html('确认密码不能为空');
				flag++;
			}else{
				$('#repassword').parent().find('.error').html('');
			}
			var m1 = $('input[name=m1]').prop('checked');
			if(m1 == ''){
				$('input[name=m1]').parent().find('.error').html('请阅读并同意协议');
				flag++;
			}else{
				$('input[name=m1]').parent().find('.error').html('');
			}
			if(flag == 0){
				$('#reg_form').submit();
			}
		})

		//获取电话input框 绑定失去焦点事件（JQ/Ajax）
		$('#phone').blur(function () {
			//清空提示信息
			//console.log(this);
			//$('#phone').next().html('');
			$(this).next().html("<img src='/static/home/img/load.gif'>");
			$('#phone').next().next().html("");
			if ($('#phone').val() == ''){
				$('#phone').next().html('手机号不能为空');
				return;
			}else if(! (/^1[3-9]\d{9}$/.test($('#phone').val())) ){
				$('#phone').next().html('手机号格式不正确');
				return;
			}else{
//				var data = "phone=" + $('#phone').val();
//				var xhr = new XMLHttpRequest();
//				xhr.onreadystatechange = function () {
//					if(xhr.readyState == 4 && xhr.status == 200){
////						console.log(xhr.responseText);
//						var res = xhr.responseText;
//						var json = JSON.parse(res);
//						if(json.code != 10000){
//							$('#phone').next().html(json.msg);
//						}else{
//							if (json.status == 1){
//								$('#phone').next().html('手机号已被注册');
//							}else{
//								$('#phone').next().next().html('手机号可用');
//							}
//						}
//					}
//					if(xhr.readyState != 4){
//						$('#phone').next().next().html("<img src='/static/home/img/load.gif'>");
//					}
//				}
//				xhr.open('post',"<?php echo url('home/login/checkphone'); ?>");
//				xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
//				xhr.send(data);
				var phone = $(this).val();
				var data = {"phone":phone};
				var _this = this;
				$.ajax({
					"url":"<?php echo url('home/login/checkphone'); ?>",
					"type":"post",
					"data":data,
					"dataType":"json",
					"success":function (res) {
						if(res.code != 10000){
							alert(res.msg);
							return;
						}else{
							if(res.status == 1){
								$(_this).next().html('手机号已被注册');
							}else{
								$(_this).next().html('');
								$(_this).next().next().html('手机号可用');
							}
						}
					}
				});
			}
		});
	});
</script>
</html>