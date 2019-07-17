<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends Controller {

    //获取用户信息
    public function getusersinfo(){
        $Users = M('users');
        $get = $_GET['uid'];
        // var_dump $get;
        if($get){
            $users = $Users
            ->where('uid = '.$get)
            ->select();
            // var_dump($users);
        }else{
            $users = $Users
            ->where()
            ->select();
        }
        // echo $users;
        $arr = array();
        $arr['code'] = 0;
        $arr['count'] = $Users->where()->count();
        $arr['msg'] = "";
        $arr['data'] = $users;

        if($users){
            // var_dump(json_encode($arr));
            echo json_encode($arr);
        }
        // $this->display();
        	
    }

    //添加用户
    public function adduserinfo(){
        $Users = M('users');
        $username = $_GET['username'];
        var_dump($username);
        $password = $_GET['password'];
        $phone_number = $_GET['phone_number'];
        $member = $_GET['member'];
        $users = $Users->add(['username'=>$username,'password'=>$password,'phone_number'=>$phone_number,'member'=>$member,'con_id'=>0]);

        echo  1;
    }

    //删除用户
    public function deluser(){
        $Users = M('users');
        $uid = $_POST['uid'];
        var_dump($uid);
        $Users = $Users->delete($uid);
        echo 1;
    }

    //删除多个用户
    public function mutdeluser(){
        $Users = M('users');
        $uid = $_POST['array'];
        $s = json_decode($uid);
        $count = count($s);
         for($i=0;$i<$count;$i++){
             $tid = $tid.$s[$i].",";
         }
        $tid = substr($tid,0,-1);
        $Users->delete($tid);
        echo 1;
    }


     //更新用户信息的先查询方法
     public function updatauser(){
        $Users = M('users');
        $id = $_GET['uid'];
        // $Users->password = $_GET['password'];
        // $Users->phone_number = $_GET['phone_number'];
        // $Users->member = $_GET['member'];
        // $users = $Users->find()->add(['username'=>$username,'password'=>$password,'phone_number'=>$phone_number,'member'=>$member,'con_id'=>0]);
        $user = $Users->where('uid='.$id)->select();
        
        $this->assign('list',$user);
        // $this->assign('ok',1111);
        $this->display();
    }

    public function users(){
        $this->display();
    }
}