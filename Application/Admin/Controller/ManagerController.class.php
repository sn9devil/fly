<?php
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends BasicController {

    //获取用户信息
    public function getmanagerinfo(){
        $Manager = M('manager');
        $get = $_GET['username'];
        // var_dump $get;
        $arr = array();
        $arr['code'] = 0;
        if($get){
            $manager = $Manager
            ->where('username like '.'"%'.$get.'%"')
            ->select();
            $arr['count'] = $Manager->where('username like '.'"%'.$get.'%"')->count();
            // var_dump($users);
        }else{
            $manager = $Manager
            ->where()
            ->select();
            $arr['count'] = $Manager->where()->count();
        }
        // echo $users;
        $arr['msg'] = "";
        $arr['data'] = $manager;

        if($manager){

            echo json_encode($arr);
        }
        // $this->display();
        	
    }

    //添加管理员
    public function addManagerInfo(){
        $Manager = M('manager');
        //注意json_decode()的第二个参数
        $get = json_decode($_GET['get'],1);
        // $phone = intval($get['phone']);
        $data = [];
        $manager = $Manager->where('username = '."'".$get['name']."'")->find();
        if($manager){
            $data['status'] = '0';
            $data['msg'] = '管理员名已存在';
            echo json_encode($data);
        }else {
            $data['status'] = '1';
            $password = md5($get['password']);
            $Manager->add(['username'=>$get['name'],'password'=>$password,'sex'=>$get['sex'],'phone'=>$get['phone'],'email'=>$get['email'],'jointime'=>$get['jointime']]);
            $data['msg'] = '添加成功';
            echo json_encode($data);
        }       
    }

    //删除管理员
    public function delmanager(){
        $Manager = M('manager');
        $aid = $_POST['aid'];
        // var_dump($aid);
        $Manager->delete($aid);
        echo 1;
    }

    //删除多个管理员
    public function mutdelmanager(){
        $Manager = M('manager');
        $aid = $_POST['array'];
        $s = json_decode($aid);
        $count = count($s);
         for($i=0;$i<$count;$i++){
             $id = $id.$s[$i].",";
         }
        $id = substr($id,0,-1);
        $Manager->delete($id);
        echo "删除多个管理员成功";
    }


     //更新管理员信息的先查询方法
     public function updatamanager(){
        $Manager = M('manager');
        $id = $_GET['aid'];
        $manager = $Manager->where('aid='.$id)->select();
        // var_dump($manager);
        $this->assign('list',$manager);
        $this->display();
    }

    public function updataManagerInfo(){
        $Manager = M('manager');
        $get = json_decode($_GET['get'],1);
        $get['password'] = md5($get['password']);
        $Manager->where('aid ='.$get['aid'])->save($get);
    }

    


    public function manager(){
        $this->display();
    }
}