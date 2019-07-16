<?php
namespace Home\Controller;
use Home\Controller\PublicController;
class TicketController extends PublicController {
    public function index(){
        $Company = M('company');
         
        $list = $Company->select();

        //var_dump($list);
        // 把数据传入模板
        $this->assign('list', $list);

        // 渲染模板
        $this->display();
        //s$this->success('。', U('User/login'), 5);exit;
    }

    public function add(){

        $Company = M('company');
        // 查找有没有重复的手机号
        $company = $Company->where(['company'=>$_POST['company']])->find();
        if(!empty($company)){
            $this->error('对不起，你输入的公司名称已经存在。请使用别的公司名称');
            exit;
        }
        

        // 1.2 把数据插入数据库
        $result = $Company->data($_POST)->add();
         
        $this->display();
    }

    public function search(){

        $Company = M('company');
        // 查找有没有重复的手机号
        $company = $Company->where(['company'=>$_POST['company']])->find();
        if(!empty($company)){
            $this->error('对不起，你输入的公司名称已经存在。请使用别的公司名称');
            exit;
        }
        

        // 1.2 把数据插入数据库
        $result = $Company->data($_POST)->add();
         
        $this->display();
    }

    //查询机票信息
    public function find($tid){
        $m = M('ticket');
        $result = $m->where(['tid'=>$tid])->select();
        return $result;

    }

}