<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends Controller {

    public function getusersinfo(){
        $Users = M('users');
        $users = $Users
                 ->where()
                 ->select();
        $arr = array();
        $arr['code'] = 0;
        $arr['count'] = $Users->where()->count();
        $arr['msg'] = "";
        $arr['data'] = $users;

        if($users){
            echo json_encode($arr);
        }
        		
    }

    // public function searchUser($uid){
    //     $Users = M('users');
    //     $users = $Users
    //              ->where('uid='.$uid);
    //              ->select();
    //     $arr = array();
    //     $arr['code'] = 0;
    //     $arr['count'] = 1;
    //     $arr['msg'] = "";
    //     $arr['data'] = $users;

    //     if($users){
    //         echo json_encode($arr);
    //     }
    // }

    public function users(){
        $this->display();
    }
}