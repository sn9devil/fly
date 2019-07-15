<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>登录页面</title>
    <link rel="stylesheet" href="/fly/public/admin/css/layui.css">
    <script type="text/javascript" src="/fly/public/admin/jquery/jquery-3.4.1.min.js">

    </script>
    <!-- <script type="text/java"></script> -->
    <style>
        body {
            /* background-size: 100%;
            height: 100%;
            width: 100%; */
            background: url("/fly/public/admin/images/sky.jpg") no-repeat;
        }

        .login {
            /* padding: 70px; */
            background-color: rgb(255, 255, 255);
            width: 450px;
            height: 450px;
            margin: 0 auto;
            margin-top: calc((100vh - 500px)/2);
            /* margin-top: 220px; */
            border-radius: 15px;
            box-shadow: 5px 5px 30px #838B8B;
        }

        .layui-input {
            margin: 0 auto;
            border-radius: 5px;
            margin-top: 10px;
            width: 80%;
        }

        .login_top {
            text-align: center;
            border-radius: 15px 15px 0px 0px;
            width: 100%;
            height: 45%;
            background-color: #2b2b36;
        }

        .login_center {
            width: 100%;
            height: 35%;
            padding: 30px;
            box-sizing: border-box;
            background-color: #2b2b36;
        }

        .login_buttom {
            border-radius: 0px 0px 15px 15px;
            width: 100%;
            height: 20%;
            background-color: #3EA751;
        }

        .login_btn {
            width: 100%;
            text-align: center;
            border-radius: 0px 0px 15px 15px;
            height: 100%;
            outline: none;
            border: none;
            color: white;
            font-size: 30px;
            background-color: #3EA751;
            transition: all 0.5s;
        }

        .login_btn:hover {
            background-color: crimson;
        }

        span {
            color: lightslategrey;
            font-size: 15px;
        }

        .img {
            display: block;
            margin: 0 auto;
        }
    </style>
</head>

<body class="layui-layout-body ">
    <form class="layui-form" action="<?php echo U('postLogin');?>" method="post">
        <div class="login layui-form-item">
            <div class="login_top">
                <img src="/fly/public/admin/images/fly.png" alt="" height="55%" class="img">
                <span>欢迎回来</span>
            </div>
            <div class="login_center">
                <input type="text" name="username" required lay-verify="required" placeholder="用户名" autocomplete="off"
                    class="layui-input">
                <input type="password" name="password" required lay-verify="required" placeholder="密码" autocomplete="off"
                    class="layui-input">
            </div>
            <div class="login_buttom layui-form-item">
                <button lay-submit="" lay-filter="login_user" class="login_btn">Login</button>
            </div>
        </div>
    </form>

    <script src="/fly/public/admin/layui.js"></script>
    <script>
        layui.use('form', function () {
            var form = layui.form;

            //监听提交
            form.on('submit(login_user)', function (data) {
                // layer.alert(data.field);
                // layer.msg(JSON.stringify(data.form));
                let url = "<?php echo U('postLogin');?>";
                let post = JSON.stringify(data.field);
                console.log(url,post);
                $.ajax({
                    type:'post',
                    url: url,
                    data: 'post=' +post,
                    dataType: 'json',
                    success: function(json){
                        console.log(json);
                        if(json.status == 1){
                            layer.msg(json.msg,function(){
                                location.href = json.url;
                            });
                        }else{
                            console.log(111);
                            layer.msg(json.msg,function(){
                                return false;
                            });
                        }
                    }
                });
                return false;
            });
        });
    </script>
</body>

</html>