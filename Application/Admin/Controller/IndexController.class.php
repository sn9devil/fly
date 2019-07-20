<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){

        $this->display();		
    }

    public function home(){
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
}