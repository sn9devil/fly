<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
        
        // $Model = M();
        // $sql = 'select * from ticket a left join company b on a.cid=b.id';
        // $list = $Model->query($sql);
       
        
        // 把数据传入模板
        // $this->assign('list', $list);
        // 模板渲染
        $this->display();		
    }


}