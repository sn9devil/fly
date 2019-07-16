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

    //
    public function search(){
        $go = $_GET['go'];
        $arrive = $_GET['arrive'];
        $date = $_GET['date'];
        $back_date = $_GET['back_date'];
        $num = $_GET['num'];

        
        $list = $this->findTicket($go,$arrive,$date);
        $this->assign('list', $list);

        if(!empty($back_date)){
            $back_list = $this->findTicket($arrive,$go,$back_date);
            $this->assign('back_list', $back_list);
        }

        $this->display();		

    }

    public function findTicket($go,$arrive,$date){
        $Model = M();
        $sql = 'select * from ticket a left join company b on a.cid=b.id where a.go='."'".$go."'".'and a.arrive='."'".$arrive."'".'and a.date='."'".$date."'";
        $list = $Model->query($sql);
        return $list;

    }

}