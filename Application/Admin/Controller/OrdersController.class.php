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

        $t_id = $Orders_item->field('t_id')->where('o_id = '.$oid)->buildSql();
        // echo json_encode($t_id);

        $Ticket = M('ticket');
        // $ticket = $Ticket->where('tid in '.$t_id)->select();
        // echo json_encode($ticket);

        $ticket = M('ticket as t')->join('company as c')->where('t.tid in '.$t_id.'and t.cid = c.id')->select();
        $arr = array();
        $arr['code'] = 0;
        $arr['msg']="";
        $arr['count'] =  M('ticket as t')->join('company as c')->where('t.tid in '.$t_id.'and t.cid = c.id')->count();
        $arr['data']=$ticket;
        echo json_encode($arr);
    }

    //订单-常用联系人弹窗
    public function contactShow(){
        $oid = $_GET['oid'];
        $this->assign('oid',$oid);
        $this->display("contactShow");	
    }

    //获取订单-常用联系人
    public function getContact(){
        $oid = $_GET['oid'];
        $Orders_item = M('orders_item');

        $c_id = $Orders_item->field('c_id')->where('o_id = '.$oid)->select();
        echo json_encode($c_id);

        // $Contact = M('contact');
        // $contact = $Contact->where('cid in '.$c_id)->select();
        // echo json_encode($contact);

        // $ticket = M('ticket as t')->join('company as c')->where('t.tid in '.$t_id.'and t.cid = c.id')->select();
    //     $arr = array();
    //     $arr['code'] = 0;
    //     $arr['msg']="";
    //     $arr['count'] =  $Contact->where('cid in '.$c_id)->count();
    //     $arr['data']=$contact;
    //     echo json_encode($arr);
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