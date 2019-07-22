<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {

    public function __construct(){
        // 先执行一次父级的构造函数，防止构造函数的覆盖。
        parent::__construct();
        // echo ACTION_NAME;exit;
        // 判断当前的URL地址。如果是用户登录的控制器方法，就不需要用户验证
        if(CONTROLLER_NAME != 'Index' && CONTROLLER_NAME != 'User'){
            $this->checkLogin();
        }else if(ACTION_NAME != 'index' && ACTION_NAME != 'search' && ACTION_NAME != 'findTicket' && ACTION_NAME != 'login' && ACTION_NAME != 'postLogin' && ACTION_NAME != 'reg' && ACTION_NAME != 'register' && ACTION_NAME!= 'reg'){
            $this->checkLogin();
        }
    } 

    // 验证用户登录
   	public function checkLogin(){
        $username = session('user.username');
   		// 判断session中有没有用户资料
   		if(empty($username)){
   			$this->error('对不起，你没有登录。重请登录后再进行操作。',U('Home/User/login'),1);
   			exit;
           }
   	}

}