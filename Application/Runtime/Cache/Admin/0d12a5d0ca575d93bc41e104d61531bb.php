<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/fly/public/admin/css/layui.css" media="all">
    <script src="/fly/public/admin/layui.js" charset="utf-8"></script>
    <style>
        body {
            padding-top: 35px;
            background-color: rgb(255, 255, 255);
            width:320px;
            height: 300px;
        }
    </style>

</head>

<body>
    <form class="layui-form" action="">
        <div class="layui-form-item">
            <label class="layui-form-label">用户名：</label>
            <div class="layui-input-block">
                <input type="text" name="name" lay-verify="name" autocomplete="off" placeholder="请输入名字" id="name"
                    class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码：</label>
            <div class="layui-input-block">
                <input type="text" name="password" lay-verify="pass" placeholder="请输入密码" id="password"
                    autocomplete="off" class="layui-input">
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">手机号码：</label>
                <div class="layui-input-inline">
                    <input type="tel" name="phone" lay-verify="required|phone" autocomplete="off" class="layui-input" id="phone">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">会员：</label>
            <div class="layui-input-block">
                <input type="radio" name="member" value="1" title="是" id="member">
                <input type="radio" name="member" value="0" title="否"  checked="" id="member">
            </div>
        </div>
    </form>

    <script>
        layui.use(['form', 'layedit', 'laydate'], function () {
        });
    </script>

</body>

</html>