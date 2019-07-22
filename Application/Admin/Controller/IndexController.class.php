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
        $sum_amount = "select sum(amount) as am from orders where datediff(ctime,'$today')=0";
        $amount = $Order->query($sum_amount);
        var_dump($amount);
        $this->assign('amount',$amount);

        //今日出行人数
        
        $sum_num = "select sum(num) as nu from orders where datediff(ctime,'$today')=0";
        $num = $Order->query($sum_num);
        
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