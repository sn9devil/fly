<?php
namespace Home\Controller;
use Home\Controller\PublicController;
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
        $User = M('users');
        $user = $User
                 ->field('uid, username')
                 ->where('username = "'.$post['username'].'" and password ="'.md5($post['password']).'"')
                 ->find();

        if($user){
            session('user',$user);
            $data = [];
            $data['msg'] = '登录成功';
            $data['status']=1;
            $data['url']=U('Home/Index/index');
            echo json_encode($data);
        }else{
            echo json_encode(['msg'=>'用户名或密码错误','status'=>0]);
        }         
    }
    
    public function register(){
        $this->display();		// 模板渲染
    }
	
	// 用户注册
    public function reg(){
        $post = json_decode($_POST['post'], 1);
        import('@.Controller.Contact');
        $C = new ContactController();
       
        if(!empty($post)){
            $Model = M();
            // $sql = 'select * from users where phone_number='."'".$_POST['phone_number']."'";
            // $phoneList = $Model->query($sql);
            // if(!empty($phoneList)){
            //     $this->error('对不起，你输入的手机号已经被使用了。请使用别的手机号码进行注册');
            //     exit;
            // }
            $sql = 'select * from users where username='."'".$_POST['username']."'";
            $usernameList = $Model->query($sql);
            var_dump($usernameList);
            // 查找有没有重复的用户名
            if(!empty($usernameList)){
                $list['status'] = 0;
                $list['mgs'] = "已存在相同的用户名";
                echo json_encode($list);
                return ;
            }
			
            // 把用户数据插入到数据库
            // 1.1 把数据进行整理
            // unset($_POST['r_password']);
            // $_POST['password'] = md5($_POST['password']);

            // // 1.2 把数据插入数据库
            // $User = M('users');
            // $result = $User->data($_POST)->add();
            

            // $sql = 'select uid from users where username='."'".$_POST['username']."'";
            // $uidList = $Model->query($sql);

            // if(!empty($_POST['name'])  && !empty($_POST['identity'])){
               
            //     $Contact = M('contact');
            //     $check_idcard = $_POST['identity'];
            //     if(strlen($check_idcard)<15 || strlen($check_idcard)>18){
            //         $list['status'] = 0;
            //         $list['mgs'] = "证件号码位数出错";
            //         echo json_encode($list);
            //         return ;
            //     }else{
            //         if($C->idcard_checksum18($check_idcard)){
            //             // 查找有没有重复的联系人信息
            //             $sql = 'select * from contact where name='."'".$_POST['name']."'"."and identity="."'".$check_idcard."'";
            //             $list = $Model->query($sql);
            //             if(!empty($list)){
            //                 $list['status'] = 0;
            //                 $list['mgs'] = "已存在相同的联系人信息";
            //                 echo json_encode($list);
            //                 return ;        
            //             }
            //             $type = $C->is_adult($check_idcard); 
            //             $data['name'] = $_POST[name];
            //             $data['type'] = $type;
            //             $data['identity'] = $_POST[identity];
            //             $data['uid'] = $uidList['uid'];
            //             $Contact->data($data)->add();

            //             $list['status'] = 1;
            //             $list['mgs'] = "成功添加";
            //             echo json_encode($list);
            //             return ;
            //         }else{
            //             $list['status'] = 0;
            //             $list['mgs'] = "证件号码填写有问题，请重新输入";
            //             echo json_encode($list);
            //             return ;    
            //         }
            //     }
            // }

            // if(!empty($result)){
            //     $this->redirect('User/login');
            // }else{
            //     $this->error('注册失败');
            // }
        }
    
    }


	// 用户登出
    public function logOut(){
		session('user', null);
		$this->redirect('Index/index');  
    }
}