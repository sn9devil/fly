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

    //获取表格
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

    //添加机票页面
    public function addTickets(){
        
        $this->display("addTickets");
    }

    //添加机票操作
    public function add(){
        $post = json_decode($_POST['post'], 1);
        $Ticket = M('ticket');
        // echo $post['flight_number'];
        $data = [];
        $data['msg'] = '添加成功';
        $ticket = $Ticket->add(['flight_number'=>$post['flight_number'],'go'=>$post['go'],'arrive'=>$post['arrive'],'date'=>$post['date'],'cheap_price'=>$post['cheap_price'],'expensive_price'=>$post['expensive_price'],'sprplus'=>$post['sprplus'],'cid'=>$post['company'],'go_time'=>$post['go_time'],'arrive_time'=>$post['arrive_time']]);
        echo json_encode($data);
    }

    //删除一行
    public function deleteTickets(){
        $Ticket = M('ticket');
        $data = [];
        $data['msg'] = '删除成功';
        $tid = $_POST['tid'];
        $ticket = $Ticket->delete($tid);
        echo json_encode($data);
    }

    //删除多行
    public function multiDelete(){
        $Ticket = M('ticket');
        $post = $_POST['array'];
        $post = json_decode($post);
        // $s = json_decode($tid);
        // $count = count($s);

        for($i=0;$i<count($post);$i++){
           $tid =$tid.$post[$i].",";
        }
        $tid = substr($tid,0,-1);
        $ticket = $Ticket->delete($tid);
        
    
        // for($i=0;$i<count($post);$i++){
        //     if($i==(count($post)-1)){
        //         $tid =$tid.$post[$i];
        //     }else{
        //     $tid =$tid.$post[$i].",";
        //     }
        // }
        // echo $tid;
        $ticket = $Ticket->delete($tid);
        $data = [];
        $data['msg'] = '删除成功';
        echo json_encode($data);
    }

    //编辑机票信息
    public function editTickets(){
        $Ticket = M('ticket');
        $tid = $_GET['tid'];
        $ticket = $Ticket->where('tid='.$tid)->select();
        $this->assign('ticket',$ticket);
        $this->display("editTickets");
    }
}