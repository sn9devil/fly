<?php
namespace Admin\Controller;
use Think\Controller;
class TicketsController extends BasicController {

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

        $page = $_GET['page'];
        $limit = $_GET['limit'];

        $get = $_GET['arr'];
        // $tid=$post['tid'];
        // $flight_number=$post['flight_number'];

        // echo $post['flight_number'];
        // $post = json_decode($post,1);
        
        //删除空值的数组的键
        foreach ($get as $key=>$value)
        {
            if(empty($value)){  
                unset($get[$key]);
            }
        }
        // echo json_encode($get);

        if($get){
            // echo "due";
            //$mo=M('ticket as t')->join('company as c')->where('t.tid = '.$tid.' and t.cid = c.id')->order('t.tid asc')->limit(($page-1)*$limit,$limit)->select();
            //$m1o=M('ticket as t')->join('company as c')->where($map)->where('t.cid = c.id')->order('t.tid asc')->limit(($page-1)*$limit,$limit)->select();
            $mo=M('ticket as t')->join('company as c')->where($get)->where('t.cid = c.id')->order('t.tid asc')->limit(($page-1)*$limit,$limit)->select();
            $arr['count'] = M('ticket as t')->join('company as c')->where($get)->where('t.cid = c.id')->order('t.tid asc')->count();
            $arr['data']=$mo;
        }else{
            $mo=M('ticket as t')->join('company as c')->where("t.cid = c.id")->order('t.tid asc')->limit(($page-1)*$limit,$limit)->select();
            $arr['count'] = M('ticket as t')->join('company as c')->where("t.cid = c.id")->count();
            $arr['data']=$mo;
        }
        echo json_encode($arr);
    }

    //添加机票页面
    public function addTickets(){
        $Company = M('company');
        $company = $Company->where()->select();
        $this->assign('company',$company);
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

        $Company = M('company');
        $company = $Company->where()->select();
        $this->assign('company',$company);
        
        $this->display("editTickets");
    }

    public function edit(){
        $Ticket = M('ticket');
        $post = json_decode($_POST['post'], 1);
        $tid = $post['tid'];
    //    var_dump($post);
        $ticket = $Ticket->where('tid='.$tid)->save($post);
        $data = [];
        $data['msg'] = '修改成功';
        echo json_encode($data);
    }


}