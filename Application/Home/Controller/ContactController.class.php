<?php
namespace Home\Controller;
use Home\Controller\PublicController;
class ContactController extends PublicController {
    public function index(){
        $Model = M();
        $sql = 'select * from contact where uid='.session('user.uid');
        $contactList = $Model->query($sql);    
        $this->assign('contactList', $contactList);
        $this->display();		// 模板渲染
    }

    public function select(){
        $Model = M();
        $sql = 'select * from contact where uid='.session('user.uid');
        $contactList = $Model->query($sql);    
        return $contactList;
    }

    //添加常用联系人
    public function add(){
        $Contact = M("contact"); // 实例化User对象
        $data['name'] = $_GET[name];
        $data['identity'] = $_GET[identity];
        $data['uid'] = session('user.uid');
        $Contact->data($data)->add();
        $this->success('嘤嘤嘤',U('Contact/index'),1);exit;       
    }



    public function eidt(){
        $this->display();       
    }



    public function delete(){
    	$Contact = M("contact"); // 实例化User对象
        $Contact->where('cid='.$_GET[cid])->delete(); // 删除id为5的用户数据	
        $this->success('嘤嘤嘤',U('Contact/index'),1);exit;  
    }

}