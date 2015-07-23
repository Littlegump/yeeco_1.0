// JavaScript Document
$(document).ready(function(){
	//在未启用编辑模式下，表单样式不可用
	$(".board textarea").focus(function(){
		var isEdit = $("#a2").attr("style").indexOf("display"); 
		if(isEdit==0){
			$(this).css("border","1px solid #fff");
		}
	}) 
    $(".board textarea").blur(function(){
		var isSaved = $("#a2").attr("style").indexOf("display"); 
		if(isSaved==0){
			$(this).css("border","1px solid #fff");
		}
	})
		//全选
	$("#all").click(function(){
			if(this.checked){
				$(":checkbox[name='member[]']").prop('checked',true)
				$(".key").parent().parent().css("background","#ffffd7");
			}else{
				$(":checkbox[name='member[]']").prop('checked',false)
				$(".key").parent().parent().css("background","#fff");
			}
	})
		//单选
	$(":checkbox").change(function(){
		if($(this).attr("class")== "key"){
			if(this.checked){
				$(this).parent().parent().css("background","#ffffd7");
			}else{
				$(this).parent().parent().css("background","#fff");
			}
		}	
	})

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

	$("#read_form").hover(function(){
		$("#read_form i").css("background-position","0 -75px");
	},function(){
		$("#read_form i").css("background-position","0 0");
	})
	
	//添加备注信息
	$(".add_remark").click(function(){
		$(this).text('保存').attr('class','save_remark');
		$(this).parent().parent().find(".edit_box").show();
		jQuery.getScript('js/fresh_detail.js');
	})
	//保存备注信息
	$(".save_remark").click(function(){
		var content = $(this).parent().parent().find("#remark").val();	
		if(content==''){
			content='添加备注';
		}
		var aId = $(this).parent().parent().find(":checkbox").val();
		$(this).text(content).attr('class','add_remark');
		$(this).parent().parent().find(".edit_box").hide();
		////**************************************在这里执行异步提交以后的内容
		$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"saveRemark",
				aId:aId,
				remark:content,
			},
			success:function(data){
				//alert(data);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
	})



})

//选中的添加备注
function add_edit(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		$(".edit_box").animate({width:'200px'});
		$(".handle p").animate({margin:'0 20px 0 10px'});
		$("#h2").text('保存').attr('href','javascript:save_selected()');	
		$("#remark_selected").trigger("focus");
	}
}

//保存已选备注信息
function save_selected(){
	var content = $("#remark_selected").val();
	if(content==''){
			content='添加备注';
		}
	var aId=new Array();
	var i=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			aId[i] = $(this).val();
			i++;
			$(this).parent().parent().find(".add_remark").text(content);
		}
	}) 
	$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"saveRemark_selected",
				aId:aId,
				remark:content,
			},
			success:function(data){
				//alert(data);
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
	$(".edit_box").animate({width:'0px'});
	$(".handle p").animate({margin:'0 110px 0 10px'},function(){});
	$("#h2").text('添加备注').attr('href','javascript:add_edit()');
}
//批量删除
function del_app(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		coverall();
		newbox('del_notice');
	}
}
//取消删除
function cancel_del(){
	nocover();
	movebox('del_notice');
}
function del_app_act(){
		var aId=new Array();
		var i=0;
		$("input[name='member[]']:checkbox").each(function () { 
			if (this.checked){ 
				aId[i] = $(this).val();
				i++;
			}
		}) 
		$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"del_app",
				aId:aId,
			},
			success:function(data){
				for(var j=0;j<i;j++){
					$('#'+aId[j]).remove();
				}
				nocover();
				movebox('del_notice');
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
}


//批量录用
function employ(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		coverall();
		newbox('employ_notice');
	}
}
//取消录用
function cancel_employ(){
	nocover();
	movebox('employ_notice');
}
//录用
function employ_act(){
	var c=0;
	$("input[name='member[]']:checkbox").each(function () { 
		if (this.checked){ 
			c++;
		}
	})
	if(c==0){
		alert("您没有勾选任意一个成员！")
	}else{
		var aId=new Array();
		var i=0;
		$("input[name='member[]']:checkbox").each(function () { 
			if (this.checked){ 
				aId[i] = $(this).val();
				i++;
			}
		}) 
		$.ajax({
			type:"POST",
			url:"../background/background_society/society_apply_form.php",
			//dataType:"json",
			data:{
				action:"employ",
				aId:aId,
			},
			success:function(data){
				for(var j=0;j<i;j++){
					$('#'+aId[j]).remove();
				}
				nocover();
				movebox('employ_notice');
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
		})
	}
}

//查看打印报名表
function read_form(){
	coverall();
	newbox('form_box');
}
//关闭报名表
function return_main(){
	movebox('form_box');
	nocover();
}
	
var t=0;
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

//编辑公告
function edit(){
	$("#board_text").removeAttr("readonly");
	$("#board_text").focus();
	$("#a1").hide();
	$("#a2").show();	
    $(".board textarea").css("border","1px solid #00acff");
}
//保存公告
function save(){
	$("#board_text").attr("readonly","readonly");
	$("#a1").show();
	$("#a2").hide();
	$(".board textarea").css("border","1px solid #fff");
	////**************************************在这里执行异步提交以后的内容
	$.ajax({
			type:"POST",
			url:"../background/background_society/saveBoard.php",
			data:{
				board:$("#board_text").val(),
				sId:$("#sId").val(),
				
			},
			//dataType:,
			success:function(data){
			},
			error:function(jqXHR){alert("操作失败"+jqXHR.status);}
	})
}
//停止纳新
function stopFresh(){
	coverall();
	newbox('notice_box');
}


