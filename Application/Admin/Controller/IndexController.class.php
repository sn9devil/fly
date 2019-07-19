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
}