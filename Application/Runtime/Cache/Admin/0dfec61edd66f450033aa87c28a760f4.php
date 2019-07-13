<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>登录页面</title>
    <link rel="stylesheet" href="/fly/public/admin/css/layui.css">
    <style>
        body {
            background: url("");
        }

        .login {
            padding: 70px;
            background-color: aquamarine;
            width: 360px;
            height: 360px;
            margin: 0 auto;
            /* margin-top:calc((100vh - 500px)/2); */
            margin-top: 220px;
            border-radius: 15px;
            box-shadow: 5px 5px 30px #838B8B;
        }
        .layui-input{
            border-radius: 8px;
        }
    </style>
</head>

<body class="layui-layout-body ">
    <div class="login">
        <input type="text" name="title" required lay-verify="required" placeholder="用户名" autocomplete="off"
            class="layui-input">
        <input type="text" name="title" required lay-verify="required" placeholder="用户名" autocomplete="off"
            class="layui-input">
    </div>
    <script src="/fly/public/admin/layui.js"></script>
    <script>
        //JavaScript代码区域
        layui.use('element', function () {
            var element = layui.element;

        });
    </script>
</body>

</html>