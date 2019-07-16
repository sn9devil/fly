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
    	<form action="<?php echo U('pay');?>" method="GET" >
				<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><input type="text" name='ooid' value="<?php echo ($data["ooid"]); ?>">
					<h5>订单号：<?php echo ($data["ooid"]); ?></h5>
					<h5>订单时间：<?php echo ($data["ctime"]); ?></h5>
					<h5>张数：<?php echo ($data["num"]); ?></h5>
					<h5>总额：<?php echo ($data["amount"]); ?></h5>
					<h5>订单号：<?php echo ($data["ooid"]); ?></h5><?php endforeach; endif; else: echo "" ;endif; ?>
				<?php if(is_array($ticket)): $i = 0; $__LIST__ = $ticket;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ticket): $mod = ($i % 2 );++$i;?><h5>起始地<?php echo ($ticket["go"]); ?></h5>
					<h5>重点：<?php echo ($ticket["back"]); ?></h5>
					<h5>出发时间：<?php echo ($ticket["go_time"]); ?></h5>
					<h5>到达时间：<?php echo ($ticket["arrive_time"]); ?></h5><?php endforeach; endif; else: echo "" ;endif; ?>

				<button>支付</button>
		<form>
				<button formaction="<?php echo U('Order/search');?>">取消</button>

				<?php reset($data); ?> 
			<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><input type="text" name='ooid' value="<?php echo ($data["ooid"]); ?>">
				<h5>订单号：<?php echo ($data["ooid"]); ?></h5>
				<h5>订单时间：<?php echo ($data["ctime"]); ?></h5>
				<h5>张数：<?php echo ($data["num"]); ?></h5>
				<h5>总额：<?php echo ($data["amount"]); ?></h5>
				<h5>订单号：<?php echo ($data["ooid"]); ?></h5><?php endforeach; endif; else: echo "" ;endif; ?>
			<?php if(is_array($ticket)): $i = 0; $__LIST__ = $ticket;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$ticket): $mod = ($i % 2 );++$i;?><h5>起始地<?php echo ($ticket["go"]); ?></h5>
				<h5>重点：<?php echo ($ticket["back"]); ?></h5>
				<h5>出发时间：<?php echo ($ticket["go_time"]); ?></h5>
				<h5>到达时间：<?php echo ($ticket["arrive_time"]); ?></h5><?php endforeach; endif; else: echo "" ;endif; ?>
</body>	
</html>