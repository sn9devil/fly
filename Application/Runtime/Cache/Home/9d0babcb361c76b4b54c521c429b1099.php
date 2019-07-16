<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html class="x-admin-sm">
    
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="/fly/public/home/css/font.css">
        <link rel="stylesheet" href="/fly/public/home/css/xadmin.css">
        <script src="/fly/public/home/lib/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="/fly/public/home/js/xadmin.js"></script>
    </head>
    
    <body>
        <div class="x-nav">
            <span class="layui-breadcrumb">
                <a href="">首页</a>
                <a href="">演示</a>
                <a>
                    <cite>导航元素</cite></a>
            </span>
            <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
                <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i>
            </a>
        </div>
        <div class="layui-fluid">
            <div class="layui-row layui-col-space15">
                <div class="layui-col-md12">
                    <div class="layui-card">
                        
                        <div class="layui-card-body ">
                            <form action="<?php echo U('Contact/add');?>" class="layui-form layui-col-space5">
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="name" placeholder="请输入姓名" autocomplete="off" class="layui-input" value=""></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <input type="text" name="identity" placeholder="请输入身份证号码" autocomplete="off" class="layui-input"value=""></div>
                                <div class="layui-input-inline layui-show-xs-block">
                                    <button class="layui-btn" lay-submit="" lay-filter="sreach">
                                        <i class="layui-icon">&#xe615;</i></button>
                                </div>
                            </form>
                        </div>
                        <div class="layui-card-body ">
                            <table class="layui-table layui-form">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" name="" lay-skin="primary">
                                        </th>
                                        <th>姓名</th>
                                        <th>身份证号码</th>
										
										<th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(is_array($contactList)): $i = 0; $__LIST__ = $contactList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$contact): $mod = ($i % 2 );++$i;?><tr>
                                        <td>
                                            <input type="checkbox" name="" lay-skin="primary">
                                        </td>
                                        <td><?php echo ($contact["name"]); ?></td>
                                        <td><?php echo ($contact["identity"]); ?></td>

                                        <td class="td-manage">
                                            <a title="编辑" href="<?php echo U('edit', ['cid'=>$contact['cid']]);?>">
                                                <i class="layui-icon">&#xe63c;</i></a>
                                            <a title="删除" href="<?php echo U('delete', ['cid'=>$contact['cid']]);?>">
                                                <i class="layui-icon">&#xe640;</i></a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="layui-card-body ">
                            <div class="page">
                                <div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>layui.use(['laydate', 'form'],
        function() {
            var laydate = layui.laydate;

            //执行一个laydate实例
            laydate.render({
                elem: '#start' //指定元素
            });

            //执行一个laydate实例
            laydate.render({
                elem: '#end' //指定元素
            });
        });

        /*用户-停用*/
        function member_stop(obj, id) {
            layer.confirm('确认要停用吗？',
            function(index) {

                if ($(obj).attr('title') == '启用') {

                    //发异步把用户状态进行更改
                    $(obj).attr('title', '停用');
                    $(obj).find('i').html('&#xe62f;');

                    $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                    layer.msg('已停用!', {
                        icon: 5,
                        time: 1000
                    });

                } else {
                    $(obj).attr('title', '启用');
                    $(obj).find('i').html('&#xe601;');

                    $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                    layer.msg('已启用!', {
                        icon: 5,
                        time: 1000
                    });
                }

            });
        }

        /*用户-删除*/
        function member_del(obj, id) {
            layer.confirm('确认要删除吗？',
            function(index) {
                //发异步删除数据
                $(obj).parents("tr").remove();
                layer.msg('已删除!', {
                    icon: 1,
                    time: 1000
                });
            });
        }

        function delAll(argument) {

            var data = tableCheck.getData();

            layer.confirm('确认要删除吗？' + data,
            function(index) {
                //捉到所有被选中的，发异步进行删除
                layer.msg('删除成功', {
                    icon: 1
                });
                $(".layui-form-checked").not('.header').parents('tr').remove();
            });
        }</script>

</html>