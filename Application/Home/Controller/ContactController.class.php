<?php
namespace Home\Controller;
use Home\Controller\PublicController;
//由于继承了PublicController，所以路由得加上父类PublicController
class ContactController extends PublicController {
    public function index(){     
        $this->display();		// 模板渲染
    }



    public function select(){
        $this->display();       
    }



    public function add(){
        $this->display();       
    }



    public function eidt(){
        $this->display();       
    }



    public function delete(){
    	$this->display();		
    }



	// 用户登出
    public function logOut(){
		session('user', null);
		$this->success('你已经成功退出', U('user/login'), 2);exit;    
    }
}