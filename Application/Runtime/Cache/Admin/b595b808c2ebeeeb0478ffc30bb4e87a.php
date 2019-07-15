<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="/fly/public/admin/css/layui.css">
    <style>
        .layui-side .layui-side-scroll .layui-nav .layui-nav-item span {
            /* font-weight: 100; */
        }

        .layui-side .layui-side-scroll .layui-nav .layui-nav-item a .layui-icon {
            font-size: 1.1rem;
            margin-right: 0.5rem;
        }
    </style>
</head>

<body class="layui-layout-body" scroling="no">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <div class="layui-logo">Wakanda 后台管理系统</div>
            <!-- 头部区域（可配合layui已有的水平导航） -->
            <!-- <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item"><a href="">控制台</a></li>
                <li class="layui-nav-item"><a href="">商品管理</a></li>
                <li class="layui-nav-item"><a href="">用户</a></li>
                <li class="layui-nav-item">
                    <a href="javascript:;">其它系统</a>
                    <dl class="layui-nav-child">
                        <dd><a href="">邮件管理</a></dd>
                        <dd><a href="">消息管理</a></dd>
                        <dd><a href="">授权管理</a></dd>
                    </dl>
                </li>
            </ul> -->
            <ul class="layui-nav layui-layout-right">
                <li class="layui-nav-item"><a href="">前台页面</a></li>
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                        贤心
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="">基本资料</a></dd>
                        <dd><a href="">安全设置</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">退出</a></li>
            </ul>
        </div>

        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
                <ul class="layui-nav layui-nav-tree" lay-filter="test">
                    <li class="layui-nav-item">
                        <a class="" href="javascript:;">
                            <i class="layui-icon layui-icon-home"></i>
                            <span>主页</span>
                        </a>
                        <!-- <dl class="layui-nav-child">
                            <dd><a href="http://www.baidu.com" target="my_ifr">列表一</a></dd>
                            <dd><a href=<?php echo U(Tickets/tickets);?> target="my_ifr">列表二</a></dd>
                            <dd><a href="javascript:;">列表三</a></dd>
                            <dd><a href="">超链接</a></dd>
                        </dl> -->
                    </li>
                    <li class="layui-nav-item">

                        <a href="javascript:;">
                            <i class="layui-icon layui-icon-form"></i>
                            <span>订票管理</span>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="">
                            <i class="layui-icon layui-icon-release"></i>
                            <span>航班计划</span>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="">
                            <i class="layui-icon layui-icon-website"></i>
                            <span>航班公司</span>
                        </a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="<?php echo U('Users/users');?>" target="my_ifr">
                            <i class="layui-icon layui-icon-user"></i>
                            <span>会员信息</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="layui-body">
            <!-- 内容主体区域 -->
            <!-- <div style="padding: 15px;">内容主体区域</div> -->
            <iframe src="" frameborder="0" id="my_ifr" name="my_ifr" width="100%" height="99%" scroling="no" style="padding: 10px" ></iframe>
        </div>

        <div class="layui-footer">
            <!-- 底部固定区域 -->
            © layui.com - 底部固定区域
        </div>
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