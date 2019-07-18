<?php
namespace Admin\Controller;
use Think\Controller;
class OrdersController extends Controller {

    public function orders(){
        
       
        $this->display("orders");		
    }

    public function getOrders(){
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