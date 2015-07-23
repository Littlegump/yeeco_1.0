// JavaScript Document
//异步提交表单功能
$(document).ready(function () {
     //提交表单
    $("#search_form").ajaxForm(function(data) {  
     	var data1=data.substr(0,data.length-1);
		var data2=data.substr(data.length-1,1);
		$('#body').html(data1);
		$('#anum').text(data2);
    });
});
//加载页面自动出发事件
$('#all').bind("myClick", function(){  
 	precise_search();
});
$('#all').trigger("myClick");
//搜索选中活动
$(".course-nav-item").click(function(){
	$(this).parent().find(".on").removeClass("on");
	$(this).addClass("on");
	precise_search();
})
//最新，最热
$('.sort-item').click(function(){
	$(this).parent().find(".active").removeClass("active");
	$(this).addClass("active");
	precise_search();
})
//搜索操作
function precise_search(){
	var going=$(".s1").find(".on").children("a").text();
	var type=$(".s2").find(".on").children("a").text();
	var status=$('.tool-left').find(".active").text();
	$.ajax({
			type:"POST",
			url:"../background/background_society/activity/classify_query_activity.php?action=precise_search",
			data:{
				"going":going,
				"type":type,
				"status":status,
				"school":$("#school").val(),
			},
			success:function(data){
				var data1=data.substr(0,data.length-1);
				var data2=data.substr(data.length-1,1);
				$('#body').html(data1);
				$('#anum').text(data2);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}