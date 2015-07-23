// JavaScript Document
$(document).ready(function(){
	//在未启用编辑模式下，表单样式不可用
	$(".board textarea").focus(function(){
			$(this).css("border","1px solid #fff");
	}) 
    $(".board textarea").blur(function(){
			$(this).css("border","1px solid #fff");
	})

})


	
var t=1;
//纳新详情
function detail(){
	if(t==0){
		$("#detail").slideDown("fast");
		$(".more").css("background-position","0 0");
		t=1;
	}else{
		$("#detail").slideUp("fast");
		$(".more").css("background-position","0 -25px");
		t=0;
	}
}
//报名参加活动
function apply_activity(){
	$.ajax({
		type:"GET",
		url:"../background/background_society/activity/apply_activity.php?actId="+$("#actId").val()+"&uId="+$("#uId").val(),
		success:function(){
			$(".close_act").html("已经报名");	
			$("#apply_act").attr("href","");
		},
		error:function(){alert("操作失败");}
	})
}
