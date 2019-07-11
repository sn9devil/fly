<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

   
        
   
    public function index(){
        // 通过用户ID获取用户的文件列表信息
        $Ticket = M('ticket');
        $list = $Ticket->select();
        $Company = M('company');
        $company = $Company
        ->field('id, company')
        ->where(['id' => $list[0]['cid']])
        ->find();
    
        $list[0]['company'] = $company['company'];
    
        
        //var_dump($list);
        // 把数据传入模板
        $this->assign('list', $list);

        $this->display();		// 模板渲染
    }

    public function search(){

        $Ticket = M('ticket');
        //$map = [];
        $map['go'] = $_GET['go'];
        $map['arrive'] = $_GET['arrive'];
        $map['date'] = $_GET['date'];
        //var_dump($map);
        // 查找有没有重复的手机号
        
        $list =$Ticket->where($map)->select();
        $Company = M('company');
        $company = $Company
        ->field('id, company')
        ->where(['id' => $list[0]['cid']])
        ->find();
    
        $list[0]['company'] = $company['company'];

         // 把数据传入模板
         $this->assign('list', $list);
        $this->display();		// 模板渲染

    }
}