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
				$("#index_1").hide();
				$("#index_3").show();
			}else if(data == 202){
				$("#userName_2").text($('[name="aName"]').val())
				$("#userTel_2").text($('[name="aTel"]').val())
				$('[name="state"]').val('202');
				$("#index_1").hide();
				$("#index_3").show();
			}else if(data == 203){
				alert("您已经报过名了！");
			}else{
				alert("操作失败，未知错误，请联系客服！");
			}
}
			