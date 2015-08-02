// JavaScript Document

$(document).ready(function(){
	
	//报名表下，表达那样式不可用
	$(".app_form textarea").focus(function(){
		$(this).css("border","0 solid #fff");
	})
	$(".app_form :text").focus(function(){
		$(this).css("border","0 solid #fff");
	})
	$(".app_form textarea").blur(function(){
		$(this).css("border","0 solid #fff");
	})
	$(".app_form :text").blur(function(){
		$(this).css("border","0 solid #fff");
	})
	
	$(".top_back").hover(function(){
				$(".top_back").removeClass("transparency");
			},function(){
				$(".top_back").addClass("transparency");
		});
	$(".top").hover(function(){
				$(".top_back").removeClass("transparency");
			},function(){
				$(".top_back").addClass("transparency");
		});
	
	var jWindow = $(window);
	jWindow.scroll(function(){
		var scrollHeight =jWindow.scrollTop();
		if(scrollHeight>310){
		    $('#fixedSide').addClass("scroll");
		}else{
			$('#fixedSide').removeClass("scroll");
		}
	})
		
	//展开成员列表
	$(".unfold").click(function(){
		var state = $(this);	
		var depName = $(this).parent().find(".dep_name").text();
		if(depName=='未分配'){
			depName='0';
		}
		var target = $(this).parent().parent().find("#content_"+depName);
		if(state.text() == '展开'){
			$("#content_"+depName).load("res_package/memberList.php",{"sId":$("#sId").val(),"depName":depName},function(){
				target.slideDown('fast');
			 	state.html('收起<i></i>');
			});
		}else{
			target.slideUp('fast');
			state.html('展开<i></i>');
		}
	})
	//页面加载自动展开
	$("#open_target").trigger("click");	
})

//关闭报名表
function return_main(){
	movebox('form_box');
	nocover();
}
//切换社团
function change_society(){
	$(".change_society").fadeIn("fast");
	$(document).one("click", function (){//对document绑定一个影藏Div方法
		$(".change_society").hide();
	});
	event.stopPropagation();
}
$(".change_society").click(function (event){
	event.stopPropagation();//阻止事件向上冒泡
});