<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>用户注册</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="/fly/public/home/css/font.css">
    <link rel="stylesheet" href="/fly/public/home/css/login.css">
	 <link rel="stylesheet" href="/fly/public/home/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/fly/public/home/lib/layui/layui.js" charset="utf-8"></script>

</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">用户注册</div>
        <div id="darkbannerwrap"></div>
        
        <form id="form" action="<?php echo U('User/reg');?>" method="post" class="layui-form" >
            <input id="phone_number" name="phone_number" placeholder="手机号码"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input id="username" name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            
            <input id="password" name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input id="r_password" name="r_password" lay-verify="required" placeholder="重新输入密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input value="注册" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>

    <script>
        $('#form').submit(function (){
            let username = $('#username').val();
            let phone_number = $('#phone_number').val();
            let password = $('#password').val();
            
            let r_password = $('#r_password').val();
            if(username == ''){
                alert('用户名不能为空');
                return false;
            }
            if(password !== r_password){
                alert('两次输入的密码不一样，请重新输入。');
                return false;
            }
        });
    </script>

    <script>

    </script>
</body>
</html>