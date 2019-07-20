<?php
namespace Admin\Controller;
use Think\Controller;
class OrdersController extends Controller {

    public function orders(){
        
       
        $this->display("orders");		
    }

    //获取订单
    public function getOrders(){
        $Order = M('orders');

        $arr = array();
        $arr['code'] = 0;
        $arr['msg']="";

        $post = $_POST['key'];//订单号
        $ooid=$post['ooid'];
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        if($ooid){
            $mo=M('orders as o')->join('users as u')->where('o.ooid = '.$ooid.' and o.uid = u.uid')->limit(($page-1)*$limit,$limit)->select();
            // $ticket = $Ticket->where('tid = '.$tid)->select();
            $arr['count'] = M('orders as o')->join('users as u')->where('o.ooid = '.$ooid.' and o.uid = u.uid')->count();
            $arr['data']=$mo;
        }else{
            $mo=M('orders as o')->join('users as u')->where("o.uid = u.uid")->limit(($page-1)*$limit,$limit)->select();
            // $ticket = $Ticket->where()->select();
            $arr['count'] = M('orders as o')->join('users as u')->where("o.uid = u.uid")->count();
            $arr['data']=$mo;
        }
    	
        echo json_encode($arr);
    }
    
    //订单-机票弹窗
    public function ticketsShow(){
        $oid = $_GET['oid'];
        $this->assign('oid',$oid);
        $this->display("ticketsShow");	
    }

    //获取订单-机票
    public function getTickets(){
        $oid = $_GET['oid'];
        $Orders_item = M('orders_item');

        // $t_id = $Orders_item->field('t_id')->where('o_id = '.$oid)->buildSql();
        // // echo json_encode($t_id);
        // // $c_id = $Orders_item->field('c_id')->where('tid in '.$t_id)->buildSql();
        // $Ticket = M('ticket');
        // // $ticket = $Ticket->where('tid in '.$t_id)->select();
        // // echo json_encode($ticket);
        $demo = M();
        $result = $demo->table('orders_item as o,contact as con,company as c, ticket as t')->field('t.tid,t.flight_number,t.go,t.arrive,t.date,t.go_time,t.arrive_time,con.cid,con.name,c.company')
            ->where("o.o_id='".$oid."' and o.c_id= con.cid and o.t_id=t.tid and t.cid=c.id")
            ->select();
        // var_dump($result);
        // $ticket = M('ticket as t')->join('company as c')->where('t.tid in '.$t_id.'and t.cid = c.id')->select();

        $arr = array();
        $arr['code'] = 0;
        $arr['msg']="";
        $arr['count'] =  $demo->table('orders_item as o,contact as con,company as c, ticket as t')
        ->where("o.o_id='".$oid."' and o.c_id= con.cid and o.t_id=t.tid and t.cid=c.id")
        ->count();
        $arr['data']=$result;
        echo json_encode($arr);
    }

    //乘客信息弹窗
    public function contactShow(){
        $cid = $_GET['cid'];
        $this->assign('cid',$cid);
        $this->display("contactShow");	
    }

    //获取乘客信息
    public function getContact(){
        $cid = $_GET['cid'];
        $Contact = M('contact');
        $contact = $Contact->where("cid = ".$cid)->select();
        $arr = array();
        $arr['code'] = 0;
        $arr['msg']="";
        $arr['count'] = $Contact->where("cid = ".$cid)->count();
        $arr['data']=$contact;
        echo json_encode($arr);
     }


        //删除一行
    public function deleteOrders(){
        $Order = M('orders');
        $data = [];
        $data['msg'] = '删除成功';
        $oid = $_POST['oid'];
        $order = $Order->delete($oid);
        echo json_encode($data);
    }

}