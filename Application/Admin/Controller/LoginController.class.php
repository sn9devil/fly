<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {

    public function login(){
        
        // $Model = M();
        // $sql = 'select * from ticket a left join company b on a.cid=b.id';
        // $list = $Model->query($sql);
       
        
        // 把数据传入模板
        // $this->assign('list', $list);
        // 模板渲染
        $this->display();		
    }


    public function postLogin(){
        $post = json_decode($_POST['post'], 1);
        $data = [];
        $data['msg'] = '欢迎光临';
   
        echo json_encode($data);
    }

}