<?php
namespace Home\Controller;
use Home\Controller\PublicController;
class ContactController extends PublicController {

    public function idcard_verify_number($idcard_base){
        if (strlen($idcard_base) != 17){ return false; }
        // 加权因子
        $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

        // 校验码对应值
        $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

        $checksum = 0;
        for ($i = 0; $i < strlen($idcard_base); $i++){
            $checksum += substr($idcard_base, $i, 1) * $factor[$i];
        }

        $mod = strtoupper($checksum % 11);
        $verify_number = $verify_number_list[$mod];

        return $verify_number;
    }

    // 将15位身份证升级到18位
    public function idcard_15to18($idcard){
        if (strlen($idcard) != 15){
            return false;
        }else{
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){
                $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9);
            }else{
                $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9);
            }
        }

        $idcard = $idcard . idcard_verify_number($idcard);

        return $idcard;
    }

    //18位身份证校验码有效性检查
    public function idcard_checksum18($idcard){
        if (strlen($idcard ==15)){ $this->idcard_15to18($idcard); }
        if (strlen($idcard) != 18){ return false; }
        $aCity = array(11 => "北京",12=>"天津",13=>"河北",14=>"山西",15=>"内蒙古",
        21=>"辽宁",22=>"吉林",23=>"黑龙江",
        31=>"上海",32=>"江苏",33=>"浙江",34=>"安徽",35=>"福建",36=>"江西",37=>"山东",
        41=>"河南",42=>"湖北",43=>"湖南",44=>"广东",45=>"广西",46=>"海南",
        50=>"重庆",51=>"四川",52=>"贵州",53=>"云南",54=>"西藏",
        61=>"陕西",62=>"甘肃",63=>"青海",64=>"宁夏",65=>"新疆",
        71=>"台湾",81=>"香港",82=>"澳门",
        91=>"国外");
        //非法地区
        if (!array_key_exists(substr($idcard,0,2),$aCity)) {
            return false;
        }
        //验证生日
        if (!checkdate(substr($idcard,10,2),substr($idcard,12,2),substr($idcard,6,4))) {
            return false;
        }
        $idcard_base = substr($idcard, 0, 17);
        if ($this->idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){
            return false;
        }else{
            return true;
        }
    }

    public static function full_year_day($tyear,$tmonth,$type=18){
        $sum=365*$type;
        for($i=$tyear+1;$i<$tyear+$type;$i++)//考虑中间年份
        {
            if(self::is_leap_year($i))
                $sum++;
        }
        if(self::is_leap_year($tyear)&&$tmonth<=2)//考虑初末两年
            $sum++;
        if(self::is_leap_year($tyear+$type)&&$tmonth>=3){
            $sum++;
        }
        return $sum;
    }

    public static function is_leap_year($year){
        if(($year%4==0&&$year%100!=0)||$year%400==0)
            return 1;
        else
            return 0;
    }

    //是否成年 返回0成年，1未成年
    public function is_adult($IDCard){
        $flag = 0;
        if(strlen($IDCard)==18){
            $tyear=intval(substr($IDCard,6,4));
            $tmonth=intval(substr($IDCard,10,2));
            $tday=intval(substr($IDCard,12,2));
            if($tyear>date("Y")||$tyear<(date("Y")-100)){
                $flag=0;
            }elseif($tmonth<0||$tmonth>12){
                $flag=0;
            }elseif($tday<0||$tday>31){
                $flag=0;
            }else{
                $day_sum = self::full_year_day($tyear,$tmonth,18);
                if((time()-mktime(0,0,0,$tmonth,$tday,$tyear))>$day_sum*24*60*60){
                    $flag=0;
                }else{
                    $flag=1;
                }
            }
        }elseif(strlen($IDCard)==15){
            $tyear=intval("19".substr($IDCard,6,2));
            $tmonth=intval(substr($IDCard,8,2));
            $tday=intval(substr($IDCard,10,2));
            if($tyear>date("Y")||$tyear<(date("Y")-100)){
                $flag=0;
            }elseif($tmonth<0||$tmonth>12){
                $flag=0;
            }elseif($tday<0||$tday>31){
                $flag=0;
            }else{
                $day_sum = self::full_year_day($tyear,$tmonth,18);
                if((time()-mktime(0,0,0,$tmonth,$tday,$tyear))>$day_sum*24*60*60){
                    $flag=0;
                }else{
                    $flag=1;
                }
            }
        }
        return $flag;
    }

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
        $Model = M();
        $Contact = M('contact');
        $check_idcard = $_GET['identity'];
        if(strlen($check_idcard)<15 || strlen($check_idcard)>18){
            $this->error('证件号码位数出错');
            exit;
        }else{
            if($this->idcard_checksum18($check_idcard)){
                // 查找有没有重复的联系人信息
                $sql = 'select * from contact where name='."'".$_GET[cid]."'"."and identity="."'".$check_idcard."'";
                $list = $Model->query($sql);
                if(!empty($list)){
                    $this->error('已存在相同的联系人信息');
                    exit;
                }
                $type = $this->is_adult($check_idcard); 
                $data['name'] = $_GET[name];
                $data['type'] = $type;
                $data['identity'] = $_GET[identity];
                $data['uid'] = session('user.uid');
                $Contact->data($data)->add();
                $this->success('嘤嘤嘤',U('Contact/index'),1);exit;    
            }else{
                $this->error('证件号码填写有问题，请重新输入');
                exit;
            }
        }
        
           
    }

    public function update(){
        $Model = M();
        $Contact = M('contact');
        $check_idcard = $_GET['identity'];
        if(strlen($check_idcard)<15 || strlen($check_idcard)>18){
            $this->error('证件号码位数出错');
            exit;
        }else{
            if($this->idcard_checksum18($check_idcard)){
                // 查找有没有重复的联系人信息
                $sql = 'select * from contact where name='."'".$_GET[cid]."'"."and identity="."'".$check_idcard."'";
                $list = $Model->query($sql);
                if(!empty($list)){
                    $this->error('已存在相同的联系人信息');
                    exit;
                }
                $type = $this->is_adult($check_idcard); 
                $data['name'] = $_GET[name];
                $data['type'] = $type;
                $data['identity'] = $_GET[identity];
                $data['uid'] = session('user.uid');
                $Contact->where('cid='.$_GET[cid])->save($data); // 根据条件更新记录
                $this->success('嘤嘤嘤',U('Contact/index'),1);exit;    
            }else{
                $this->error('证件号码填写有问题，请重新输入');
                exit;
            }
        }
    }
    
    public function edit(){
        $Model = M();
        $sql = 'select * from contact where cid='.$_GET[cid];
        $list = $Model->query($sql);    
        $this->assign('list', $list);
        $this->display();       
    }

    public function delete(){
    	$Contact = M("contact"); // 实例化User对象
        $Contact->where('cid='.$_GET[cid])->delete(); // 删除id为5的用户数据	
        $this->success('嘤嘤嘤',U('Contact/index'),1);exit;  
    }

}