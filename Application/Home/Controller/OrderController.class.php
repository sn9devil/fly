<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends Controller {

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

       
        $go = $_GET['go'];
        $arrive = $_GET['arrive'];
        $date = $_GET['date'];
        
        $Model = M();
        $sql = 'select * from ticket a left join company b on a.cid=b.id where a.go='."'".$go."'".'and a.arrive='."'".$arrive."'".'and a.date='."'".$date."'";
        $list = $Model->query($sql);

        // 把数据传入模板
        $this->assign('list', $list);
        // 模板渲染
        $this->display();		

    }
}