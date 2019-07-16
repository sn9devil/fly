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
        
            <select>
                <?php if(is_array($contact)): $i = 0; $__LIST__ = $contact;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$contact): $mod = ($i % 2 );++$i;?><option value=<?php echo ($contact["cid"]); ?> ><?php echo ($contact["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

    </body>
</html>