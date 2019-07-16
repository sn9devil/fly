<?php
namespace Admin\Controller;
use Think\Controller;
class TicketsController extends Controller {

    public function tickets(){
        
        // $Model = M();
        // $sql = 'select * from ticket a left join company b on a.cid=b.id';
        // $list = $Model->query($sql);
       
        
        // 把数据传入模板
        // $this->assign('list', $list);
        // 模板渲染
        $this->display("tickets");		
    }

    public function getTickets(){
        $Ticket = M('ticket');
        $Company = M('company');

        $arr = array();
        $arr['code'] = 0;
        $arr['msg']="";

        $post = $_POST['key'];
        $tid=$post['tid'];
        if($tid){
            $mo=M('ticket as t')->join('company as c')->where('t.tid = '.$tid.' and t.cid = c.id')->select();
            // $ticket = $Ticket->where('tid = '.$tid)->select();
            $arr['count'] = $Ticket->where('tid = '.$tid)->count();
            $arr['data']=$mo;
        }else{
            $mo=M('ticket as t')->join('company as c')->where("t.cid = c.id")->select();
            // $ticket = $Ticket->where()->select();
            $arr['count'] = $Ticket->where()->count();
            $arr['data']=$mo;
        }
    	
        echo json_encode($arr);
    }


}