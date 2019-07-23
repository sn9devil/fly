<?php
namespace Admin\Controller;
use Think\Controller;
class CompanyController extends BasicController {

    public function company(){
        
        $this->display();		
    }

    /*
    *注意只可以只有一个echo
    */
    public function getcompanyinfo(){
        $Company = M('company');
        $post = $_GET['company'];
        // echo $post;
        if($post){
            $company = $Company
            ->where('company like '.'"%'.$post.'%"')
            ->select();
            // var_dump($users);
        }else{
            $company = $Company
            ->where()
            ->select();
        }
        // echo $users;
        $arr = array();
        $arr['code'] = 0;
        $arr['count'] = $Company->where()->count();
        $arr['msg'] = "";
        $arr['data'] = $company;
        // echo $arr;
        // echo json_encode($arr);
        if($company){
            // var_dump(json_encode($arr));
            echo json_encode($arr);
        }
    }

    //添加航空公司
    public function addcompanyinfo(){
        $Company = M('company');
        //注意json_decode()的第二个参数
        $get = json_decode($_GET['get'],1);
        $Company->add(['company'=>$get['company'],'address'=>$get['address'],'phone'=>$get['phone'],'describe'=>$get['describe']]);
        echo  666;
    }


    //删除公司
    public function delcompany(){
        $Company = M('company');
        $id = $_POST['id'];
        var_dump($id);
        $Company->delete($id);
        echo 1;
    }

    //删除多个公司
    public function mutdeluser(){
        $Company = M('company');
        $post = json_decode($_POST['array']);
        $count = count($post);
         for($i=0;$i<$count;$i++){
             $id = $id.$post[$i].",";
         }
        $id = substr($id,0,-1);
        echo $id;
        $Company->delete($id);
        echo 1;
    }


    //更新公司信息的先查询方法
    public function updatacompany(){
        $Company = M('company');
        $id = $_GET['id'];
        $company = $Company->where('id='.$id)->select();
        $this->assign('list',$company);
        $this->display();
    }

    //真正更新公司信息方法
    public function updatacompanyinfo(){
        $Company = M('company');
        $get = json_decode($_GET['get'],1);
        $Company->where('id ='.$get['id'])->save($get);

    }

    //传递对应公司的id
    public function getcompanyticket(){
        $id = $_GET['cid'];
        $this->assign('list',$id);
        $this->display();
    }

    //获取机票信息
    public function getCompanyTicketInfo(){
        $Ticket = M('ticket');
        $i = $_GET['cid'];
        // var_dump($i);
        $ticket = $Ticket->where('cid='.$i)->select();
        // var_dump($ticket);
        $arr = array();
        $arr['code'] = 0;
        $arr['count'] = $Ticket->where('cid='.$i)->count();
        $arr['msg'] = "";
        $arr['data'] = $ticket;
        echo json_encode($arr);
    }
}