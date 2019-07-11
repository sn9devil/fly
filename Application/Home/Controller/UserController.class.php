<?php
namespace Home\Controller;
use Home\Controller\PublicController;
//由于继承了PublicController，所以路由得加上父类PublicController
class UserController extends PublicController {
    public function index(){     
        $this->display();		// 模板渲染
    }

    // 用户登录页面
    public function login(){
    	$this->display();		// 模板渲染
    }

    // 用户登录的方法
    public function postLogin(){
    	$post = json_decode($_POST['post'], 1);
    	
    	// 创建数据表操作对象
    	$User = M('users');

    	// 查询用户
    	$user = $User->where('username = "'.$post['username'].'" and password = "'.md5($post['password']).'"')->find();
		
		session('user', $user);

    	if($user){
    		// $this->show('欢迎光临') ;
    		// 当用户成功登录，返回JSON数据
    		$data = [];
    		$data['msg'] = '欢迎光临';
    		$data['status'] = 1;
    		$data['url'] = U('/home/index/index');
    		echo json_encode($data);
    	}else{
    		// $this->show('用户名或密码错误');
    		echo json_encode(['msg'=>'用户名或密码错误', 'status'=>0 ]);
    	}
	}
	
	// 用户注册
    public function reg(){
        if(!empty($_POST)){
            // var_dump($_POST);exit;
            // 实例化数据表操作对象
            $User = M('users');
            // 查找有没有重复的手机号
            $res = $User->where(['phone_number'=>$_POST['phone_number']])->find();
            if(!empty($res)){
                $this->error('对不起，你输入的手机号已经被使用了。请使用别的手机号码进行注册');
                exit;
            }

            // 查找有没有重复的用户名
			$res = $User->where(['username'=>$_POST['username']])->find();
            if(!empty($res)){
                $this->error('对不起，你输入的手机号已经被使用了。请使用别的手机号码进行注册');
                exit;
            }
            // 查找有没有重复的邮箱地址
			
            // 把用户数据插入到数据库
            // 1.1 把数据进行整理
            unset($_POST['r_password']);
            $_POST['password'] = md5($_POST['password']);

            // 1.2 把数据插入数据库
            $result = $User->data($_POST)->add();

            // var_dump($result);exit;
            if(!empty($result)){
                $this->success('恭喜您，注册成功。现在为了跳转到登录页面。请登录后再进行操作。', U('User/login'), 5);exit;
            }else{
                $this->error('注册失败');
            }
        }
        $this->display();
    }


	// 用户登出
    public function logOut(){
		session('user', null);
		$this->success('你已经成功退出', U('user/login'), 2);exit;    
    }
}