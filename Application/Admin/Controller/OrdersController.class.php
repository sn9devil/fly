<?php
namespace Admin\Controller;
use Think\Controller;
class OrdersController extends Controller {

    public function orders(){
        
        // $Model = M();
        // $sql = 'select * from ticket a left join company b on a.cid=b.id';
        // $list = $Model->query($sql);
       
        
        // 把数据传入模板
        // $this->assign('list', $list);
        // 模板渲染
        $this->display("orders");		
    }

    public function getOrders(){
        // $Ticket = M('ticket');
        // $Company = M('company');

        // $arr = array();
        // $arr['code'] = 0;
        // $arr['msg']="";

        // $post = $_POST['key'];
        // $tid=$post['tid'];
        // if($tid){
        //     $mo=M('ticket as t')->join('company as c')->where('t.tid = '.$tid.' and t.cid = c.id')->select();
        //     // $ticket = $Ticket->where('tid = '.$tid)->select();
        //     $arr['count'] = $Ticket->where('tid = '.$tid)->count();
        //     $arr['data']=$mo;
        // }else{
        //     $mo=M('ticket as t')->join('company as c')->where("t.cid = c.id")->select();
        //     // $ticket = $Ticket->where()->select();
        //     $arr['count'] = $Ticket->where()->count();
        //     $arr['data']=$mo;
        // }
    	$Order = M('orders');

        $arr = array();
        $arr['code'] = 0;
        $arr['msg']="";

        $post = $_POST['key'];
        $oid=$post['oid'];
        if($tid){
            $order = $Order->where('oid = '.$oid)->select();
            $arr['count'] = $Ticket->where('oid = '.$oid)->count();
            $arr['data']=$order;
        }else{
            $order = $Order->where()->select();
            $arr['count'] = $Order->where()->count();
            $arr['data']=$order;
        }
        echo json_encode($arr);
    }


}