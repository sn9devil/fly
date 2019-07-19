<?php
namespace Home\Controller;
use Home\Controller\PublicController;


class OrderController extends PublicController {

    public function index(){
        /*
            orders 订单编号 订单日期 票数总额 订单状态
            ticket 出发地 目的地 出发日期

        */
        $Model = M();
        $sql = 'select * from (orders_item a left join ticket b on a.t_id=b.tid) left join orders c on a.o_id=c.oid';
        $orderlist = $Model->query($sql);
       
        foreach($orderlist as $key => $value){
            if($value['status'] == '1'){
                $orderlist[$key]['status'] = "已支付";
            }
        }

        // echo '<pre>';
        // print_r($orderlist);
        // 把数据传入模板
        $this->assign('orderlist', $orderlist);
        // 模板渲染
        $this->display();		
    }

    public function search(){

        $uid = session('user.uid');         
        $Orders = M('orders');
        $demo = M();
        $all = [];
        $order_id = [];

        // 通不get方法获取参数
        $d = empty($_GET['d'])? 0: $_GET['d'];          // 当前目录ID
        $p = empty($_GET['p'])? 1: $_GET['p'];          // 当前分页码
        $count = count($Orders->distinct(true)->field('ooid')->select());// 查询满足要求的总记录数

        $order_list = $Orders->where(['uid'=>$uid])->page($p.',2') ->order('ctime desc')->select();
        $Page  = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show();// 分页显示输出

        foreach($order_list as $key => $value){
            $order_id[] = array('oid'=>$value['oid'],'status'=>$value['status'],'num'=>$value['num']);
        }

        foreach($order_id as $key => $value){
            $ticket['travel'] = '';
            $ticket['date'] = '';
            $result = $demo->table('orders_item a,ticket b')
                ->where('a.t_id = b.tid and a.o_id ="'.$value['oid'].'"')
                ->field('go,arrive,date')
                ->group('b.tid')
                ->select();
            foreach($result as $k => $v){
                $ticket['travel'] .= '<p>'.$v['go'].'--'.$v['arrive'].'</p>';
                $ticket['date'] .= '<p>'.$v['date'].'</p>';
 
            }
            $all []=array($value['oid'],$ticket['travel'],$ticket['date'],$value['status'],$value['num']);
        }

        $this->assign('list', $all);
        $this->assign('page',$show);// 赋值分页输出
        $this->display();           

    }

    //下单页面
    public function  orderContent(){
        import('@.Controller.Contact');
        import('@.Controller.Ticket');
        $C = new ContactController();
        $T = new TicketController();

        //需要传入的参数
        $uid = session('user.uid');
        $tid = $_GET["tid"];
        $back_tid = $_GET["back_tid"];
        $ticket_type = $_GET["ticket_type"];
        $back_ticket_type = $_GET["back_ticket_type"];
        $adult = 2;
        $children = 1;
        $num = $adult + $children;

        $contact = $C->select();
        $ticket = $T->find($tid);
        if(!empty($back_tid)){
            $back_ticket = $T->find($back_tid);
            $this->assign('back_ticket',$back_ticket);

        }

        // echo '<pre>';
        // var_dump($ticket);
        $this->assign('ticket',$ticket);
        $this->assign('contact',$contact);
        $this->display();


    }

    //各自的价钱和票数 问题 为解决
    //支付页面
    public function orderPay(){
        //生成订单
        $Orders = M('orders');
        $ticket = M('ticket');

        //需要传入的参数
        $cid[0] = 1;  //$_GET['cid'];
        $cid[1] = 2;
        $cid[2] = 3;    
        $uid = session('user.uid');
        $tid = 10;
        $back_tid = 13;
        $num = 2;
        
        //支付状态
        $status = 0;
        //机票类型
        $priceType = 1;
        $back_priceType = 1;
        if($priceType){
            $priceType = "cheap_price";
        }else{
            $priceType = "expensive_price";
        }
        if(!empty($back_tid)){
            if($back_priceType){
                $back_priceType = "cheap_price";
            }else{
                $back_priceType = "expensive_price";
            }
        }
        //计算总价
        $adult = 2;
        $children = 1;
        //出发价格
        $go_price = $this->ticketPrice($tid, $adult, $child, $priceType);
        $amount = $go_price; 
        //返程价格
        if(!empty($back_tid)){
            $back_price =  $this->ticketPrice($back_tid, $adult, $child, $back_priceType);
            $amount += $back_price;
        }

        //判断是否会员
        if(session('user.member') == 1){
            $amount = $amount * 0.9;
        }

        //生成订单号
        $ooid = $this->get_sn();
        $ctime = Date("Y/m/d G:i:s");
        $data = [];
        $data['uid'] = $uid;
        $data['ooid'] = $ooid;
        $data['amount'] = $amount;
        $data['stauts'] = $status;
        $data['ctime'] = $ctime;
        $data['num'] = empty($back_tid) ?  $num : $num * 2;
        //添加订单
        $Orders->add($data);

        $orderOid = $Orders->where(['ooid'=>$ooid])->find();
        $oid = (int)$orderOid['oid'];

        //添加发出的机票详细
        $this->productOrderItem($tid,$oid,$cid,$num);

        //添加返程的机票详细
        if(!empty($back_tid)){
            $this->productOrderItem($back_tid,$oid,$cid,$num);
        }

        //展示支付页面
        $ticket_list = $ticket->where(['tid'=>$tid])->select();
        $ticket_list[0]['num'] = $num;
        if(!empty($back_tid)){
            $back_ticket_list = $ticket->where(['tid'=>$back_tid])->select();
            $back_ticket_list[0]['num'] = $num;
            $this->assign("back_ticket",$back_ticket_list);     
        }

        $this->assign("data",array($data));
        $this->assign("ticket",$ticket_list);

        // var_dump($ticket_list);
        $this->display();

    }


    //计算机票价钱
    //传入tid 成年人数 未成年数  机票类型
    public function ticketPrice($tid, $adult, $children, $priceType){
        $ticket = M('ticket');
        $price = $ticket->where(['tid'=>$tid])->find()[$priceType];
        $childrenPrice =  $children * $price * 0.5;
        $adultPrice =  $adult * $price;
        $amount = $adultPrice + $childrenPrice;
        return $amount;
    }


    //生成订单详情
    public function productOrderItem($tid, $oid, $cid, $num){
        $ticket = M('ticket');
        $orders_item = M('orders_item');
        for($i = 0; $i < $num; $i++){
            $orders_item->add(['t_id'=>$tid,'o_id'=>$oid,'c_id'=>$cid[$i]]);
            $ticket->where(['tid'=>$tid])->save(['sprplus'=>array('exp','sprplus -1')]);
        }
    }

    public function cancel(){
        $Model = M();
        $sql = 'update Orders set status = 2 where ooid='.$_GET['ooid'];
        $orderUpdate = $Model->execute($sql);
        $this->success('取消订单',U('Order/search'),1);exit;
    }

    public function pay(){
        $Model = M();
        $sql = 'update Orders set status = 1 where ooid='.$_GET['ooid'];
        $orderUpdate = $Model->execute($sql);
        $this->success('支付成功',U('Order/search'),1);exit;
    }

    //生成订单编号
    function get_sn() {
        return date('YmdHis').rand(100000, 999999);
    }

}