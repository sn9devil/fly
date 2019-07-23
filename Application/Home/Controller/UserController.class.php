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

        if($user or $phone){
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
    
            $sql = 'select * from users where username='."'".$post['username']."'";
            $usernameList = $Model->query($sql);
           
            $sql = 'select * from users where phone_number='."'".$post['phone_number']."'";
            $phoneList = $Model->query($sql);
            
            if(!empty($usernameList)){
                echo json_encode(['msg'=>'已存在相同的用户名','status'=>0]);
                return ;   
            }
            else if(!empty($phoneList)){
                echo json_encode(['msg'=>'已存在同样的电话','status'=>0]); 
                return ;  
            }else{
                // 把用户数据插入到数据库
                // 1.1 把数据进行整理
                unset($post['password2']);
                $post['password'] = md5($post['password']);

                // // 1.2 把数据插入数据库
                $User = M('users');
                $result = $User->data($post)->add();

                $sql = 'select uid from users where username='."'".$post['username']."'";
                $uid = $Model->query($sql);
                

                $Contact = M('contact');
                $check_idcard = $post['identity'];
                
                if(strlen($check_idcard)<15 || strlen($check_idcard)>18){
                    $sql = 'delete from users where uid='.$uid[0]['uid'];
                    $Model->execute($sql);
                    echo json_encode(['msg'=>'证件号码不合法','status'=>0]); 
                    return ;
                }else{
                    if($C->idcard_checksum18($check_idcard)){
                        $type = $C->is_adult($check_idcard); 
                        $data['name'] = $post[name];
                        $data['type'] = $type;
                        $data['identity'] = $post[identity];
                        $data['uid'] = $uid[0]['uid'];
                        $Contact->data($data)->add();
                        $data = [];
                        $data['msg'] = '注册成功';
                        $data['status']=1;
                        $data['url']=U('Home/User/login');
                        echo json_encode($data);
                        return ; 
                    }else{
                        $sql = 'delete from users where uid='.$uid[0]['uid'];
                        $Model->execute($sql);
                        echo json_encode(['msg'=>'证件号码不合法','status'=>0]); 
                        return ;    
                    }
                }
            }    
        }else{
            echo json_encode(['msg'=>'注册失败','status'=>0]);
        }
        
    }


	// 用户登出
    public function logOut(){
		session('user', null);
		$this->redirect('Index/index');  
    }

    //个人信息
    public function information(){
        $Model = M();
        $sql = 'select * from contact a left join users b on a.uid=b.uid group by a.uid';
        $result = $Model->query($sql);
        foreach ($result as $key => $value) {
            if($result[$key]['member'] == 0){
                $result[$key]['member'] = "否";
            }else{
                $result[$key]['member'] = "是";
            }
        }
        $this->assign('result',$result);
        $this->display();		// 模板渲染
    }

    public function getContact(){
        $Contact = M('contact');

        $Model = M();
        $sql = 'select * from contact a left join users b on a.uid=b.uid';
        $contact = $Model->query($sql);
        
        foreach ($contact as $key => $value) {
            if($contact[$key]['type'] == 0){
                $contact[$key]['type'] = "成人";
            }else{
                $contact[$key]['type'] = "未成年";
            }
        }

        $arr = array();
        $arr['code'] = 0;
        $arr['count'] = $Contact->where('uid='.session('user.uid'))->count();
        $arr['msg'] ="";
        $arr['data'] = $contact;

        if($contact){
            echo json_encode($arr);
        }
        

    }
  
}