<?php
namespace Admin\Controller;
use Think\Controller;
class UsersController extends BasicController {

    //获取用户信息
    public function getusersinfo(){
        $Users = M('users');
        $get = $_GET['username'];
        // var_dump $get;
        if($get){
            $users = $Users
            ->where('username like '.'"%'.$get.'%"')
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

            echo json_encode($arr);
        }
        // $this->display();
        	
    }

    //添加用户
    public function adduserinfo(){
        $Users = M('users');
        //注意json_decode()的第二个参数
        $post = json_decode($_GET['get'],1);
        $phone = intval($post['phone']);
        $Users->add(['username'=>$post['name'],'password'=>$post['password'],'phone_number'=>$phone,'member'=>$post['member'],'con_id'=>0]);
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
        $user = $Users->where('uid='.$id)->select();
        $this->assign('list',$user);
        $this->display();
    }

    public function updatauserinfo(){
        $Users = M('users');
        $get = json_decode($_GET['get'],1);
        $Users->where('uid ='.$get['uid'])->save($get);

    }

    //获取对应用户常用联系人的查询方法
    public function getcontact(){
        $Contact = M('contact');
        $id = $_GET['uid'];
        $contact = $Contact->where('uid='.$id)->select();
    //    var_dump($contact);
        $this->assign('list',$contact);
        $this->display();
    }

    public function users(){
        $this->display();
    }
}