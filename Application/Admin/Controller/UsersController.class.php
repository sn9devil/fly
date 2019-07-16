<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends Controller {

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


    public function users(){
        $this->display();
    }
}