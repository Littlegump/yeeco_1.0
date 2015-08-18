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
	
	
	//逐一添加按钮
	$(".invite_1").hover(function(){
		    $(".invite_1 img").fadeIn("fast");
		},function(){
			$(".invite_1 img").fadeOut("fast");
	});
	//批量导入按钮
	$(".invite_2").hover(function(){
		    $(".invite_2 img").fadeIn("fast");
		},function(){
			$(".invite_2 img").fadeOut("fast");
	});
	
	$("#form_2").ajaxForm(function(data) { 
       alert("邀请成功！");
	   quit();
    });
	
	
	
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


function export_members(){
	newbox("export_members");
	coverall();
}

function quit(){
	movebox('export_members');
	movebox('add_newMember');
	movebox('exit_society');
	nocover();
}


function add_newMember(){
	var authority=$("#authority").val();
	if(authority!='成员'){
		newbox("add_newMember");
		coverall();
	}else{
		alert("只有社团创建人和管理员才能邀请成员！");
	}
	
}

//打开“逐个添加”添加方式
function add_1(){
    $(".invite_1").animate({marginTop:30,backgroundSize:'120%'});
	$(".invite_2").animate({marginTop:30,backgroundSize:'100%'});
	$(".way_2").fadeOut("fast");
	$(".way_1").fadeIn("fast");
}
//打开“批量导入”添加方式
function add_2(){
	$(".invite_2").animate({marginTop:30,backgroundSize:'120%'});
    $(".invite_1").animate({marginTop:30,backgroundSize:'100%'});
	$(".way_1").fadeOut("fast");
	$(".way_2").fadeIn("fast");
}
//邀请成员-逐个添加-继续添加
var idmem = 1;
function insert_mem(){
	var oForm = document.getElementById("member_all");
    var newHtml = document.createElement("li");
	idmem = idmem +1;
	newHtml.id= "mem_"+idmem;
	var bb = "'mem_"+idmem+"'";
	newHtml.innerHTML = '<input type="text" name="name[]" onfocus="outline_new(this)" onblur="outline_old(this)" placeholder="姓名"/><input type="text" name="telnumber[]" onfocus="outline_new(this)" onblur="outline_old(this)" placeholder="联系方式"/><a href="javascript:deleteMem('+bb+');">-</a><div style="clear:both;"></div>';
	oForm.appendChild(newHtml);
}
//删除所添加成员
function deleteMem(id){
    var parentnode = document.getElementById("member_all");
	var childnode = document.getElementById(id);
	 parentnode.removeChild(childnode);
}

function exit_society(){
	newbox("exit_society");
	coverall();
}
//导出成员
function export_depMenbers(){
	var depName=new Array();
	var i=0;
	var sId=$("#sId").val();
	$("input[name='dep[]']:checkbox").each(function () { 
		if (this.checked){ 
			depName[i]=$(this).attr("value");
			i++;	
		}
	})	
	if(depName[0]==null){
		alert("请选择部门！");
	}else{
		$('#export_form').submit();
		quit();
			
	}
}



