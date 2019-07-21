<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

    public function login(){
        
        $this->display();		
    }


    public function postLogin(){
        $post = json_decode($_POST['post'], 1);
        $Admin = M('manager');
        $admin = $Admin
                 ->field('aid, username')
                 ->where('username = "'.$post['username'].'" and password ="'.md5($post['password']).'"')
                 ->find();

        if($admin){
            session('admin',$admin);
            $data = [];
            $data['msg'] = '登录成功';
            $data['status']=1;
            $data['url']=U('admin/Index/index');
            echo json_encode($data);
        }else{
            echo json_encode(['msg'=>'用户名或密码错误','status'=>0]);
        }         
        
    }

}