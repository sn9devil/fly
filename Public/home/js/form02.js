/*
	JavaScript 代码
	表单验证
*/

function on_submit(){
	var name = document.getElementById("name");
	var phone = document.getElementById("phone");
	var username = document.getElementById("username");
	var password = document.getElementById("password");
	var password2 = document.getElementById("password2");
	var idcard = document.getElementById("idcard");
	
	var name_tip = document.getElementById("name_tip");
	var phone_tip = document.getElementById("phone_tip");
	var username_tip = document.getElementById("username_tip");
	var password_tip = document.getElementById("password_tip");
	var password2_tip = document.getElementById("password2_tip");
	var idcard_tip = document.getElementById("idcard_tip");
	
	
	//姓名
	if(name.value == ""){
		
	}
	var han = /^[\u4e00-\u9fa5]{2,9}$/; //设置汉字的正则表达式：2-9个汉字
	if(!han.test(name.value)){ //验证输入的内容是否是2-9个汉字
            var pFocus = document.getElementById("name");  
			pFocus.focus();      
			pFocus.select();  
			name_tip.style.display="";
	}else{
		name_tip.style.display="none";
	}
	
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
	
	//用户名
	if(phone.value == ""){
		
	}
	var myusername=/^[A-Za-z0-9]{1,13}$/; //设置用户名正则表达式
	if(!myusername.test(username.value)){ 
           var userFocus = document.getElementById("username");  
			userFocus.focus();      
			userFocus.select();  
			username_tip.style.display="";
	}else{
		username_tip.style.display="none";
	}
	
	//密码
	if(phone.value == ""){
		
	}
	var mypass=/^[0-9][0-9][0-9][0-9][0-9][0-9]$/; //设置密码正则表达式
	if(!mypass.test(password.value)){ 
           var passwordFocus = document.getElementById("password");  
			passwordFocus.focus();      
			passwordFocus.select();  
			password_tip.style.display="";
	}else{
		password_tip.style.display="none";
	}
	
	
	//确认密码
	var mypass2 = /^[0-9][0-9][0-9][0-9][0-9][0-9]$/;
	if(password2.value != password.value){
		var pass2Focus = document.getElementById("password2");  
			pass2Focus.focus();      
			pass2Focus.select();  
			password2_tip.style.display="";
	}else{
		password2_tip.style.display="none";
	}
	
	//证件号码
	if(phone.value == ""){
		
	}
	var mycard=/^[0-9]{18}$/; //设置密码正则表达式
	if(!mycard.test(idcard.value)){ 
           var cardFocus = document.getElementById("idcard");  
			cardFocus.focus();      
			cardFocus.select();  
			idcard_tip.style.display="";
	}else{
		idcard_tip.style.display="none";
	}
	
}

