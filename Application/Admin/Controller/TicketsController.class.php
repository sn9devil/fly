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

    public function addTickets(){
        
        $this->display("addTickets");
    }

    public function add(){
        $post = json_decode($_POST['post'], 1);
        // $Admin = M('manager');
        // $admin = $Admin
        //          ->field('aid, username')
        //          ->where('username = "'.$post['username'].'" and password ="'.md5($post['password']).'"')
        //          ->find();

        // if($admin){
        //     session('admin',$admin);
        //     $data = [];
        //     $data['msg'] = '欢迎光临';
        //     $data['status']=1;
        //     $data['url']=U('admin/Index/index');
        //     echo json_encode($data);
        // }else{
        //     echo json_encode(['msg'=>'用户名或密码错误','status'=>0]);
        // }         
    
        $Ticket = M('ticket');
        // echo $post['flight_number'];
        $data = [];
        $data['msg'] = '添加成功';
        $ticket = $Ticket->add(['flight_number'=>$post['flight_number'],'go'=>$post['go'],'arrive'=>$post['arrive'],'date'=>$post['date'],'cheap_price'=>$post['cheap_price'],'expensive_price'=>$post['expensive_price'],'sprplus'=>$post['sprplus'],'cid'=>$post['company'],'go_time'=>$post['go_time'],'arrive_time'=>$post['arrive_time']]);
        echo json_encode($data);
    }
}