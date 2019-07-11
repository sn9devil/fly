<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends Controller {
    public $username = null;

    public function __construct(){
        // 先执行一次父级的构造函数，防止构造函数的覆盖。
        parent::__construct();
        // echo ACTION_NAME;exit;
        // 判断当前的URL地址。如果是用户登录的控制器方法，就不需要用户验证
        if(CONTROLLER_NAME != 'User'){
            if(ACTION_NAME != 'login' || ACTION_NAME != 'postLogin' || ACTION_NAME != 'reg'){
                $this->checkLogin();
            }
        }
    } 

    // 验证用户登录
   	public function checkLogin(){
   		$this->username = session('user.username');
   		// 判断session中有没有用户资料
   		if(empty($this->username)){
   			$this->error('对不起，你没有登录。重请登录后再进行操作。',U('Home/User/login'),3);
   			exit;
           }
           
        $this->assign('username',$this->username);
   	}

}