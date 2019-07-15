<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="stylesheet" href="/fly/public/admin/css/layui.css" media="all">
</head>

<body>

    <table class="layui-hide" id="test" lay-filter="test"></table>

    <script type="text/html" id="toolbarDemo">
        <div class="layui-btn-container">

            <button class="layui-btn layui-btn-sm" lay-event="getCheckData">获取选中行数据</button>
            <button class="layui-btn layui-btn-sm" lay-event="getCheckLength">获取选中数目</button>
        </div>
        <!-- <div class="demoTable">
        搜索用户名：
        <div class="layui-inline">
            <input class="layui-input" name="id" id="demoReload" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload" lay-event="searchUserInfo">搜索</button>
    </div> -->
    </script>
    <div class="demoTable">
        搜索用户名：
        <div class="layui-inline">
            <input class="layui-input" name="id" id="demoReload" autocomplete="off">
        </div>
        <div class="layui-btn" data-type="reload" lay-event="searchUserInfo">搜索</div>
    </div>


    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        <a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="save">保存</a>
    </script>


    <script src="/fly/public/admin/layui.js" charset="utf-8"></script>
    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->

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
                    }, {
                        field: 'username',
                        title: '用户名',
                        edit: 'text'
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
                    }, {
                        fixed: 'right',
                        title: '操作',
                        toolbar: '#barDemo',
                    }]
                ]
                ,page: true
            });

            //头工具栏事件
            table.on('toolbar(test)', function (obj) {
                var checkStatus = table.checkStatus(obj.config.id);
                switch (obj.event) {
                    case 'searchUserInfo':
                        // var data = checkStatus.data;
                        layer.alert("选择");
                        break;
                    case 'getCheckLength':
                        var data = checkStatus.data;
                        layer.msg('选中了：' + data.length + ' 个');
                        break;
                    case 'isAll':
                        layer.msg(checkStatus.isAll ? '全选' : '未全选');
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
            var $ = layui.$, active = {
                    reload: function () {
                        var demoReload = $('#demoReload');

                        //执行重载
                        table.reload('allUserInfoTable', {
                            page: {
                                curr: 1 //重新从第 1 页开始
                            },
                            where: {
                                key: {
                                    uid: demoReload.val()
                                }
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