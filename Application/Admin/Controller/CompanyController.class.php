<?php
namespace Admin\Controller;
use Think\Controller;
class CompanyController extends Controller {

    public function company(){
        
        $this->display();		
    }

    public function getcompanyinfo(){
        $Company = M('company');
        $post = $_POST['id'];
        // var_dump $get;
        if($post){
            $company = $Company
            ->where('id = '.$post)
            ->select();
            // var_dump($users);
        }else{
            $company = $Company
            ->where()
            ->select();
        }
        // echo $users;
        $arr = array();
        $arr['code'] = 0;
        $arr['count'] = $Company->where()->count();
        $arr['msg'] = "";
        $arr['data'] = $company;

        if($company){
            // var_dump(json_encode($arr));
            echo json_encode($arr);
        }
    }

    //添加航空公司
    public function addcompanyinfo(){
        $Company = M('company');
        //注意json_decode()的第二个参数
        $get = json_decode($_GET['get'],1);
        $Company->add(['company'=>$get['company'],'address'=>$get['address'],'phone'=>$get['phone'],'describe'=>$get['describe']]);
        echo  666;
    }


    //删除公司
    public function delcompany(){
        $Company = M('company');
        $id = $_POST['id'];
        var_dump($id);
        $Company->delete($id);
        echo 1;
    }

    //删除多个公司
    public function mutdeluser(){
        $Company = M('company');
        $post = json_decode($_POST['array']);
        $count = count($post);
         for($i=0;$i<$count;$i++){
             $id = $id.$post[$i].",";
         }
        $id = substr($id,0,-1);
        $Users->delete($id);
        echo 1;
    }
}