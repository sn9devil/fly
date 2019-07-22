<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    //首页
    // public function index(){       
    //     $Model = M();
    //     $sql = "select * from ticket a left join company b on a.cid=b.id where date_format(go_time,'%Y-%m-%d-%H-%i-%S') > date_format(now(),'%Y-%m-%d-%H-%i-%S')";
    //     $list = $Model->query($sql);
    //     // 把数据传入模板
    //     $this->assign('list', $list);
    //     // 模板渲染
    //     $this->display();		
    // }

    public function index(){       
        $oneList = $this->findTicket2("北京");
        $twoList = $this->findTicket2("海口");
        $threeList = $this->findTicket2("三亚");
        $fourList = $this->findTicket2("广州");
        // echo '<pre>';
        // print_r($twoList);
        $this->assign('oneList', $oneList);
        $this->assign('twoList', $twoList);
        $this->assign('threeList', $threeList);
        $this->assign('fourList', $fourList);
        $this->display();       
    }

    //查询页面
    public function search(){
        $go = $_GET['go'];
        $arrive = $_GET['arrive'];
        $date = $_GET['date'];
        $back_date = $_GET['back_date'];
        $people = $_GET['people'];
        $this->assign('people', $people);
        //去除参数中的中文
        $people = preg_replace('/([\x80-\xff]*)/i','',$people);
        $adult = $people[0];
        $children = $people[1];
        // var_dump($adult);
        // var_dump($children);

        $list = $this->findTicket($go,$arrive,$date);
        //去程的机票数
        $go_sum = count($list);
        //处理时间
        // foreach ($list as $key => $value) {
        //     $time = $this->countTime($value['go_time'],$value['arrive_time']);
        //     $data = $this->getTime($value['go_time']);
        //     $list[$key]['go_month']  = $data['month'];
        //     $list[$key]['go_day']  = $data['day'];
        //     $list[$key]['go_hour']  = $data['hour'];
        //     $data = $this->getTime($value['arrive_time']);
        //     $list[$key]['back_month']  = $data['month'];
        //     $list[$key]['back_day']  = $data['day'];
        //     $list[$key]['back_hour']  = $data['hour'];
        //     $list[$key]['cheap_price']  = (int)$list[$key]['cheap_price'];
        //     $list[$key]['time'] = $time;
        // }

        if(!empty($back_date)){
            $back_list = $this->findTicket($arrive,$go,$back_date);
            $back_sum = count($back_list);
            // foreach ($back_list as $key => $value) {
            //     $time = $this->countTime($value['go_time'],$value['arrive_time']);
            //     $data = $this->getTime($value['go_time']);
            //     $back_list[$key]['go_month']  = $data['month'];
            //     $back_list[$key]['go_day']  = $data['day'];
            //     $back_list[$key]['go_hour']  = $data['hour'];
            //     $data = $this->getTime($value['arrive_time']);
            //     $back_list[$key]['back_month']  = $data['month'];
            //     $back_list[$key]['back_day']  = $data['day'];
            //     $back_list[$key]['back_hour']  = $data['hour'];
            //     $back_list[$key]['cheap_price']  = (int)$back_list[$key]['cheap_price'];
            //     $back_list[$key]['time'] = $time;
            // }
            $this->assign('back_list', $back_list);
            $this->assign('back_sum', $back_sum);
        }
        //var_dump($back_list);
        $this->assign('go_sum', $go_sum);
        $this->assign('list', $list);
        $this->display();		

    }

    public function findTicket($go,$arrive,$date){
        $Model = M();
        $sql = 'select * from ticket a left join company b on a.cid=b.id where a.go='."'".$go."'".'and a.arrive='."'".$arrive."'".'and a.date='."'".$date."'";
        $list = $Model->query($sql);
        return $list;

    }

    public function findTicket2($go){
        $Model = M();
        $sql = 'select go,arrive,cast(cheap_price as decimal(9,0))cheap_price,date from ticket where go='."'".$go."' order by date asc";
        $list = $Model->query($sql);
        return $list;

    }

    //计算飞行时间
    // public function countTime($date1,$date2){
    //     $date1 = strtotime($date1);
    //     $date2 = strtotime($date2);
    //     $diff = abs($date1 - $date2);
    //     $hour = (int)($diff / 3600);
    //     $min =  $diff / 60 % 60;
    //     $time = $hour.'h'.$min.'m';
    //     return $time;
    // }

    // public function getMonth($date){
    //     $month = substr($date,5,2);
    //     if($month[0] == '0'){
    //         $month = $month[1];
    //     }
    //     return $month;
    // }

    // public function getDay($date){
    //     $day = substr($date,8,2);
    //     if($day[0] == '0'){
    //         $day = $day[1];
    //     }
    //     return $day;
    // }

    // public function getHourMin($date){
    //     $hour = substr($date,11,5);
    //     return $hour;
    // }

    // //分割月日时分
    // public function getTime($date){
    //     $data['month'] = $this->getMonth($date);
    //     $data['day'] = $this->getDay($date);
    //     $data['hour'] = $this->getHourMin($date);
    //     return $data;
    // }

}