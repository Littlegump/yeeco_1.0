// JavaScript Document
//页面加载时进行的函数
window.onload = function (){

	

	

//msg_list事件******************************************
		var msgList_height=parseInt($(".msg_list").height());
		//计算当前msg_list中li的数目、
		var li_num = $(".msg_list ul li").length;
		//计算前msg_list ul的总体高度
		var msgUl_height =  71 * li_num;
		if(msgUl_height>msgList_height){
			$(".ui-scrollbar-bar").show();	
		}
		var k = (msgUl_height-msgList_height)/(msgList_height-66);	
		
    $(".delete_msg").click(function(){
		$(this).parent().parent().remove();
		//获取当前msg_list的高度
		msgList_height=parseInt($(".msg_list").height());
		//计算当前msg_list中li的数目、
		li_num = $(".msg_list ul li").length;
		//计算前msg_list ul的总体高度
		msgUl_height =  71 * li_num;
		if(msgList_height>msgUl_height){
			$(".ui-scrollbar-bar").hide();	
		}
		k = (msgUl_height-msgList_height)/(msgList_height-66);	
	})

    //拖拽事件，滚动条滚动
	var mark=0;	
	var mark_2=0;
	
	
    $('.ui-scrollbar-bar').mousedown(function(){
        var patch=event.clientY;
        $(document).mousemove(function (event){
			$("*").addClass("temp_c"); 
            var oy=event.clientY;
			var d=oy-patch;
			//拖拽时产生的事件响应
			var t=d+mark;//t表示进度条距离顶部的高度
			$(".ui-scrollbar-bar").addClass("temp_b");
			if(t<=msgList_height-66 && t>=0){
				$('.ui-scrollbar-bar').css({'top':t});
				$('.msg_list ul').css({'top':-k*t});
			}
            return false;  
        });
    });
    $(document).mouseup(function (){
		$("*").removeClass("temp_c");
	    $(".ui-scrollbar-bar").removeClass("temp_b");
		$(".ui-scrollbar-bar_2").removeClass("temp_b");
        $(this).unbind("mousemove");
	    mark=parseInt($(".ui-scrollbar-bar").css("top"));
		mark_2=parseInt($(".ui-scrollbar-bar_2").css("top"));
    }); 
	
	//重写鼠标轮滚动事件	
	$(".msg_list").on("mousewheel DOMMouseScroll", MouseWheelHandler);
	function MouseWheelHandler(e) {	
	    var scroolly=parseInt($(".ui-scrollbar-bar").css("top"));
		    mark=scroolly;
		e.preventDefault();
		var value = e.originalEvent.wheelDelta || -e.originalEvent.detail;
		var delta = Math.max(-1, Math.min(1, value));
			if (delta < 0) {
				if(msgUl_height>msgList_height){
					scroolly=scroolly+40;
					if(scroolly<=msgList_height-66 && scroolly>=0){
						$('.ui-scrollbar-bar').css({'top':scroolly});
						$('.msg_list ul').css({'top':-k*scroolly});					
					}else{
						$('.ui-scrollbar-bar').css({'top':msgList_height-66});
						$('.msg_list ul').css({'top':-k*(msgList_height-66)});	
					}
				}
			}else {
				scroolly=scroolly-40;
				if(scroolly<=msgList_height-66 && scroolly>=0){
					$('.ui-scrollbar-bar').css({'top':scroolly});
					$('.msg_list ul').css({'top':-k*scroolly});				
			    }else{
					$('.ui-scrollbar-bar').css({'top':0});
					$('.msg_list ul').css({'top':0});
				}
			}
		return false;
	}
	
	
	
}



//**********************************消息系统*************************************

//打开并接收消息

function openSingleChat(msgToId,x){
	var msgFromId = $("[name='userId']").val();
	if(typeof(EventSource)!=="undefined"){
	//如果浏览器支持此技术， 则执行：
		$("[name='toId']").val(msgToId);
		var toUserName =$(x).find("strong").text();
		var toUserFace = $(x).find(".userFace img").attr("src");
		$("[name='toUserName']").val(toUserName);
		$("[name='toUserFace']").val(toUserFace);
		var source=new EventSource("../background/message/request_msg.php?msgToId="+msgToId+"&msgFromId="+msgFromId);
  		source.onmessage=function(event){
    		document.getElementById("result").innerHTML+=event.data + "<br />";
			//判断返回值不是 json 格式
			if (!event.data.match("^\{(.+:.+,*){1,}\}$")){
				 alert("请求重传")
			}else{
				 //通过这种方法可将字符串转换为对象
				var obj = jQuery.parseJSON(event.data);
				var state = obj.state;
				if(state == "501"){
					RxmsgBody = obj.message.msgBody;
					RxmsgTime = formateDate(new Date(obj.message.msgTime *1000));
					var new_html = "<li class='Rx_msg'><div class='msg_face'><img src='"+toUserFace+"' /></div><div class='conbine'><em>"+toUserName+"</em><div class='msg_content'><p>"+RxmsgBody+"</p></div></div><span class='send_time'>"+RxmsgTime+"</span><div style='clear:both;'></div></li>";
					$(new_html).appendTo(".massages ul");
				}
			}
			
		};
	}else{//如果浏览器不支持此技术， 则执行
 		alert("对不起，您的浏览器暂不支持即时消息推送~");
	}
}

	



//发送消息
function send_massage(){
	var userName = $("[name='userName']").val();
	var userFace = $("[name='userFace']").val();
	var massage = $("[name='message']").val();
	var date = formateDate(new Date());
	$("#massage_form").ajaxForm(function(data){
		var new_html = "<li class='Tx_msg'><div class='msg_face'><img src='"+userFace+"' /></div><div class='conbine'><em>"+userName+"</em><div class='msg_content'><p>"+massage+"</p></div></div><span class='send_time'>"+date+"</span><div style='clear:both;'></div></li>";
		$(new_html).appendTo(".massages ul");
		$("[name='message']").val("");
	});
}

//格式化日期
    function formateDate(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        var h = date.getHours();
        var mi = date.getMinutes();
        m = m > 9 ? m : '0' + m;
        return y + '-' + m + '-' + d + ' ' + h + ':' + mi;
    }
