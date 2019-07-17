<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    //首页
    public function index(){       
        $Model = M();
        $sql = "select * from ticket a left join company b on a.cid=b.id where date_format(go_time,'%Y-%m-%d-%H-%i-%S') > date_format(now(),'%Y-%m-%d-%H-%i-%S')";
        $list = $Model->query($sql);
        // 把数据传入模板
        $this->assign('list', $list);
        // 模板渲染
        $this->display();		
    }

    public function index2(){       

        $this->display();       
    }

    //查询页面
    public function search(){
        $go = $_GET['go'];
        $arrive = $_GET['arrive'];
        $date = $_GET['date'];
        $back_date = $_GET['back_date'];
        $people = $_GET['people'];
        //去除参数中的中文
        $people = preg_replace('/([\x80-\xff]*)/i','',$people);
        $adult = $people[0];
        $children = $people[1];
        var_dump($adult);
        var_dump($children);

        $list = $this->findTicket($go,$arrive,$date);
        foreach ($list as $key => $value) {
            $time = $this->countTime($value['go_time'],$value['arrive_time']);
            $list[$key]['time'] = $time;
        }

        if(!empty($back_date)){
            $back_list = $this->findTicket($arrive,$go,$back_date);
            foreach ($back_list as $key => $value) {
                $time = $this->countTime($value['go_time'],$value['arrive_time']);
                $back_list[$key]['time'] = $time;
            }
            $this->assign('back_list', $back_list);
        }
        $this->assign('list', $list);
        $this->display();		

    }

    public function findTicket($go,$arrive,$date){
        $Model = M();
        $sql = 'select * from ticket a left join company b on a.cid=b.id where a.go='."'".$go."'".'and a.arrive='."'".$arrive."'".'and a.date='."'".$date."'";
        $list = $Model->query($sql);
        return $list;

    }

    //计算飞行时间
    public function countTime($date1,$date2){
        $date1 = strtotime($date1);
        $date2 = strtotime($date2);
        $diff = abs($date1 - $date2);
        $hour = (int)($diff / 3600);
        $min =  $diff / 60 % 60;
        $time = $hour.'h'.$min.'m';
        return $time;
    }

}