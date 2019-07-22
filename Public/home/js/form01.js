/*
	JavaScript 代码
	表单验证
*/
function isNull(v){
	if(v==null || v==""){
		return true;
	}else{
		return false;
	}
}

function isSelect(){
	
}

function on_submit(){
	var name = document.getElementById("name");
	var phone = document.getElementById("phone");
	var password = document.getElementById("password");
	if(isNull(name.value)){
		name.style.border="1px solid red";
		name.focus();
		alert("请输入用户名");
		return false;
	}else{
		name.style.border="1px solid #ccc";
	}
	if(isNull(phone.value)){
		phone.style.border="1px solid red";
		phone.focus();
		alert("请输入手机号");
		return false;
	}else{
		phone.style.border="1px solid #ccc";
	}
	if(isNull(password.value)){
		password.style.border="1px solid red";
		password.focus();
		alert("请输入密码");
		return false;
	}else{
		password.style.border="1px solid #ccc";
	}
	return true;
}

