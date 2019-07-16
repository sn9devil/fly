<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/fly/public/admin/css/layui.css" media="all">
    <script src="/fly/public/admin/jquery/jquery-3.4.1.min.js"></script>
</head>

<body>
    <div class="demoTable">
        搜索用户名：
        <div class="layui-inline">
            <input class="layui-input" name="id" id="demoReload" autocomplete="off">
        </div>
        <div class="layui-btn" data-type="reload" lay-event="searchUserInfo">搜索</div>
    </div>
    <table class="layui-hide" id="test" lay-filter="test"></table>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">
            <button class="layui-btn layui-btn-sm " lay-event="addUser">添加</button>
            <button class="layui-btn layui-btn-sm layui-btn-danger" lay-event="mutDelUser">批量删除</button>
        </div>
    </script>



    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="save">保存</a>
    </script>


    <script src="/fly/public/admin/layui.js" charset="utf-8"></script>

    <script>
        layui.use('table', function () {
            var table = layui.table;

            table.render({
                elem: '#test',
                url: "<?php echo U('Users/getusersinfo');?>",
                toolbar: '#toolbarDemo',
                cellMinWidth: 80,
                title: '用户数据表',
                id: 'allUserInfoTable',
                cols: [
                    [{
                        type: 'checkbox',
                        fixed: 'left'
                    }, {
                        field: 'uid',
                        title: 'ID',
                        fixed: 'left',
                        unresize: true,
                        sort: true,
                    }, {
                        field: 'username',
                        title: '用户名',
                        edit: 'text',
                        sort: true,
                    }, {
                        field: 'password',
                        title: '密码',
                        edit: 'text',
                    }, {
                        field: 'phone_number',
                        title: '手机号码',
                        edit: 'text',
                    }, {
                        field: 'member',
                        title: '会员',
                        sort: true,
                    }, {
                        fixed: 'right',
                        title: '操作',
                        toolbar: '#barDemo',
                    }]
                ],
                page: true
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'addUser':
                        layer.open({
                            type: 2,
                            resize: true,
                            title: '添加用户信息',
                            area: ['350px', '450px'],
                            shade: 0,
                            btn: ['确认提交', '重置', '取消'],
                            content: "<?php echo U('Users/adduser');?>",
                            yes: function (index, layero) {
                                var body = layer.getChildFrame('body', index);
                                var iframeWin = window[layero.find('iframe')[0]['name']];
                                console.log(body.find('#name').val());
                                console.log(body.find('#password').val());
                                console.log(body.find('#phone').val());
                                console.log(body.find('#member').val());
                                $.ajax({
                                    url: "<?php echo U('Users/adduserinfo');?>",
                                    type: 'get',
                                    data: {
                                        'username': body.find('#name').val(),
                                        'password': body.find('#password').val(),
                                        'phone_number': body.find('#phone').val(),
                                        'member': body.find('#member').val(),
                                    },
                                    dataType: 'json',
                                    success: function (json) {
                                        // layer.msg(json.msg, function () {
                                            
                                        //     });
                                        alert('添加成功');
                                        // var $ = layui.$,
                                        //     active = {
                                        //         reload: function () {
                                        //             var demoReload =
                                        //                 $(
                                        //                     '#demoReload');
                                        //             //执行重载
                                        //             table
                                        //                 .reload(
                                        //                     'allUserInfoTable', {
                                        //                         method: 'get',
                                        //                         page: {
                                        //                             curr: 1 //重新从第 1 页开始
                                        //                         },
                                        //                         where: {}
                                        //                     }
                                        //                 );
                                        //         }
                                        //     };
                                        // console.log(json);
                                        // if (json == 1) {
                                        //     console.log('成功');
                                        // } else {
                                        //     console.log(111);
                                        // }
                                    }
                                });
                            },
                            btn2: function () {
                                layer.alert('11111');
                            },
                            btn3: function () {
                                layer.alert('2222');
                            },
                            zIndex: layer.zIndex,
                            success: function (layero) {
                                layer.setTop(layero);
                            }
                        });
                        break;
                    case 'mutDelUser':
                        var data = checkStatus.data;
                        layer.msg('选中了：' + data.length + ' 个');
                        break;
                };
            });

            //监听行工具事件
            table.on('tool(test)', function (obj) {
                var data = obj.data;
                //console.log(obj)
                if (obj.event === 'del') {
                    layer.confirm('真的删除行么', function (index) {
                        obj.del();
                        layer.close(index);

                    });
                } else if (obj.event === 'edit') {
                    layer.prompt({
                        formType: 2,
                        value: data.email
                    }, function (value, index) {
                        obj.update({
                            email: value
                        });
                        layer.close(index);
                    });
                }
            });
            var $ = layui.$,
                active = {
                    reload: function () {
                        var demoReload = $('#demoReload');
                        //执行重载
                        table.reload('allUserInfoTable', {
                            method: 'get',
                            page: {
                                curr: 1 //重新从第 1 页开始
                            },
                            where: {
                                uid: demoReload.val()
                            }
                        });
                    }
                };
            //监听查询
            $('.demoTable .layui-btn').on('click', function () {
                var type = $(this).data('type');
                active[type] ? active[type].call(this) : '';
            });

        });
    </script>

</body>

</html>