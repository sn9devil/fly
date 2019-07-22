/*
	JavaScript 代码
	找回密码
*/

function forget_submit(){
	
	var phone = document.getElementById("phone");
	var phone_tip = document.getElementById("phone_tip");
	
	//手机号
	if(phone.value == ""){	
	}
	var myreg=/^[1][3,4,5,7,8][0-9]{9}$/; //设置手机号正则表达式
	if(!myreg.test(phone.value)){ //验证手机号格式是否正确
           var phoneFocus = document.getElementById("phone");  
			phoneFocus.focus();      
			phoneFocus.select();  
			phone_tip.style.display="";
	}else{
		phone_tip.style.display="none";
	}
}

