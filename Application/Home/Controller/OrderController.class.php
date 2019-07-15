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

    public function cancel(){
        
    }
}