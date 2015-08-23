// JavaScript Document// JavaScript Document

function findUser(){	
		//验证用户身份（是否是注册用户）
		$.ajax({
			type:"POST",
			url:"../../background/web_app/M_activityApplyB.php",
			data:{
				ousertel:$('[name="aTel"]').val(),
				actId:$('[name="actId"]').val(),
			},
			//dataType:,
			success:function(data){
				checkUser(data);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
}

function checkUser(data){
			if(data == 200){
				$("#userName_1").text($('[name="aName"]').val())
				$("#userTel_1").text($('[name="aTel"]').val())
				$('[name="state"]').val('200');
				$("#index_1").hide();
				$("#index_2").show();
			}else if(data == 201){
				$("#userName_2").text($('[name="aName"]').val())
				$("#userTel_2").text($('[name="aTel"]').val())
				$('[name="state"]').val('201');
				//请求发送验证码
				request_code();
				$("#index_1").hide();
				$("#index_3").show();
			}else if(data == 202){
				$("#userName_2").text($('[name="aName"]').val())
				$("#userTel_2").text($('[name="aTel"]').val())
				$('[name="state"]').val('202');
				//请求发送验证码
				request_code();
				$("#index_1").hide();
				$("#index_3").show();
			}else if(data == 203){
				alert("您已经报过名了！");
			}else{
				alert("操作失败，未知错误，请联系客服！");
			}
}
			
//var test_code;	
	
function request_code(){
	//验证用户身份（是否是注册用户）
	$.ajax({
		type:"POST",
		url:"../../background/background_person/form_register.php?action=testcode",
		data:{
			usertel:$('[name="aTel"]').val(),
		},
		//dataType:,
		success:function(data){
			test_code = data;
		},
		error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}


//检查验证码是否正确，提交表单
function form_submit(){
	var input_code = $('[name="testCode"]').val();
	if(test_code == input_code){
		$("#pre_applyForm").submit();
	}else{
		alert("验证码输入错误，请重新输入");
	}
}
