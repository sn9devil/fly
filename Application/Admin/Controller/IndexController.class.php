<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BasicController {

    public function index(){
        $name =  session('admin');
        $this->assign('name',$name['username']);
        $this->display();		
    }

    public function home(){
        $name =  session('admin');
        $this->assign('name',$name['username']);
        //总收入
        $today=date('Y-m-d H:i:s');
        $Order  = M();
        $sum_amount = "select COALESCE(SUM(amount),0) as am from orders where datediff(ctime,'$today')=0";
        $amount = $Order->query($sum_amount);
        $this->assign('amount',$amount);

        //今日出行人数
        //$sum_num = "select COALESCE(SUM(num),0) as nu from orders where datediff(ctime,'$today')=0";
        $sum_num = "select count('tid') as nu from ticket join orders_item where orders_item.t_id = ticket.tid and datediff(ticket.go_time,'$today')=0";
        $num = $Order->query($sum_num);
        // var_dump($num);
        $this->assign('num',$num);

        //用户人数
        $count_user = "select count('uid') as nu from users"; 
        $user_num = $Order->query($count_user);
        $this->assign('user',$user_num);
        
        $this->display();
    }

    //获取未来7天的机票销售统计
    public function getDayticket(){
        $Tickets = M();
        $sql = "select count('date') as 'count',substr(date,9,10) date from (orders_item a left join ticket b on a.t_id=b.tid) group by date order by date asc";
        $list = $Tickets->query($sql);
        echo json_encode($list) ;
    }

    //统计各目的地的数量
    public function getEndCity(){
        $Tickets = M();
        $sql = "select arrive ,count('arrive') as 'count' from (orders_item a left join ticket b on a.t_id=b.tid) group by arrive order by count asc";
        $list = $Tickets->query($sql);
        echo json_encode($list);
    }
     //统计各出发地的数量
     public function getStartCity(){
        $Tickets = M();
        $sql = "select go ,count('go') as 'count' from (orders_item a left join ticket b on a.t_id=b.tid) group by go order by count asc";
        $list = $Tickets->query($sql);
        // var_dump("拿到的".$list);
        echo json_encode($list);
    }

    //退出登录
    public function loginOut(){
        session('[destroy]');
        $name = session('?admin');
        if(isset($name)){
            $this->redirect('Login/login');
        }
    }
}