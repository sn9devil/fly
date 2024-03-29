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
        if(session('user')!=null){
            echo json_encode(['msg'=>'请先退出当前用户','status'=>0]);
            return ;
        }
        $post = json_decode($_POST['post'], 1);
        $User = M('users');
        $user = $User
                 ->field('uid, username,member')
                 ->where('username = "'.$post['username'].'" and password ="'.md5($post['password']).'"')
                 ->find();
        
        if($user or $phone){
            session('user',$user);
            $data = [];
            $data['msg'] = '登录成功';
            $data['status']=1;
            $data['url']=U('Home/Index/index');
            echo json_encode($data);
            return ;
        }else{
            echo json_encode(['msg'=>'用户名或密码错误','status'=>0]);
            return ;
        }         
    
    }
    
    public function register(){
        $this->display();		// 模板渲染
    }
	
	// 用户注册
    public function reg(){
        
        import('@.Controller.Contact');
        $C = new ContactController();
        // var_dump($_POST);
        if(!empty($_POST)){
            $Model = M();
    
            $sql = 'select * from users where username='."'".$_POST['username']."'";
            $usernameList = $Model->query($sql);
           
            $sql = 'select * from users where phone_number='."'".$_POST['phone_number']."'";
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
                unset($_POST['password2']);
                $_POST['password'] = md5($_POST['password']);

                // // 1.2 把数据插入数据库
                $User = M('users');
                $result = $User->data($_POST)->add();

                $sql = 'select uid from users where username='."'".$_POST['username']."'";
                $uid = $Model->query($sql);
                

                $Contact = M('contact');
                $check_idcard = $_POST['identity'];
                
                if(strlen($check_idcard)<15 || strlen($check_idcard)>18){
                    $sql = 'delete from users where uid='.$uid[0]['uid'];
                    $Model->execute($sql);
                    echo json_encode(['msg'=>'证件号码不合法','status'=>0]); 
                    return ;
                }else{
                    if($C->idcard_checksum18($check_idcard)){
                        $type = $C->is_adult($check_idcard); 
                        $data['name'] = $_POST[name];
                        $data['type'] = $type;
                        $data['identity'] = $_POST[identity];
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
        $sql = 'select * from users where uid='."'".session('user.uid')."'";
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
        $sql = 'select * from (contact a left join users b on a.uid=b.uid) where a.uid='.session('user.uid');
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
    
    public function beMember(){
        $Model = M();
        $sql = 'update users set member = 1 where username ='."'".session('user.username')."'";
        $contact = $Model->execute($sql);
        
        session('user.member',1);  //设置session
        

        $this->redirect('User/information'); 
    }
}