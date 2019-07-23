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
        // $phone = intval($post['phone']);
        $data = [];
        $user = $Users->where('username = '."'".$post['name']."'")->find();
        if($user){
            $data['status'] = '0';
            $data['msg'] = '用户名已存在';
            echo json_encode($data);
        }else {
            $data['status'] = '1';
            $mdpassword = md5($post['password']);
            $Users->add(['username'=>$post['name'],'password'=>$mdpassword,'phone_number'=>$post['phone'],'member'=>$post['member'],'con_id'=>0]);
            $data['msg'] = '添加成功';
            echo json_encode($data);
        }       
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
        $data['username'] = $get['name'];
        $data['password'] = md5($get['password']);
        $data['phone_number'] = $get['phone'];
        $data['member'] = $get['member'];
        $Users->where('uid ='.$get['uid'])->save($data);
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

    public function updataContactInfo(){
        $Contact = M('contact');
        $get = json_decode($_GET['get'],1);
        $cid = $get['cid'];
        $newdata['name'] = $get['name'.$cid];
        $newdata['type'] = $get['type'.$cid];
        $newdata['identity'] = $get['identity'.$cid];
        $Contact->where('cid ='.$cid)->save($newdata);
        echo "更新常用联系人成功";  
    }

    public function users(){
        $this->display();
    }
}