// JavaScript Document
//页面加载时进行的函数
window.onload = function (){
	//点击下拉菜单事件
	var i=0;


	$(".ui-select-dock").click(function (event) {
		if(i==0){
			$(".ui-select-options").fadeIn();
			$(".ui-icon-triangleb").css({'background-position':'14px 16px'});
			i=1;
			$(document).one("click", function () {//对document绑定一个影藏Div方法
			    $(".ui-select-options").hide();
				$(".ui-icon-triangleb").css({'background-position':'14px -21px'});
				i=0;
			});
			event.stopPropagation();//点击阻止事件冒泡到document
		}
	});
	$(".ui-select-options").click(function (event) {
		event.stopPropagation();//在Div区域内的点击事件阻止冒泡到document
	});


   
	var mark=0;	
    //拖拽事件，进度条滚动
    $('.ui-scrollbar-bar').mousedown(function (){
        var patch=event.clientY;
        $(document).mousemove(function (event){
			$("*").addClass("temp_c");
            var oy=event.clientY;
			var d=oy-patch;
			//拖拽时产生的事件响应
			var t=d+mark;//t表示进度条距离顶部的高度
			$(".ui-scrollbar-bar").addClass("temp_b");
			if(t<=198 && t>=0){
				$('.ui-scrollbar-bar').css({'top':t});
				$('.ui-menu').css({'top':-4.34*t});
			}
            return false;  
        });
    });
    $(document).mouseup(function (){
		$("*").removeClass("temp_c");
	    $(".ui-scrollbar-bar").removeClass("temp_b");
        $(this).unbind("mousemove");
	    mark=parseInt($(".ui-scrollbar-bar").css("top"));
    }); 
  
    //重写鼠标滑动事件
	var scroolly=mark;
	$(".ui-select-options").on("mousewheel DOMMouseScroll", MouseWheelHandler);
	function MouseWheelHandler(e) {
		e.preventDefault();
		var value = e.originalEvent.wheelDelta || -e.originalEvent.detail;
		var delta = Math.max(-1, Math.min(1, value));
			if (delta < 0) {
				if(scroolly<=198 && scroolly>=-1.7){
					scroolly=scroolly+9.9;
					$('.ui-scrollbar-bar').css({'top':scroolly});
					$('.ui-menu').css({'top':-4.34*scroolly});
			    }
			}else {
				if(scroolly<=199 && scroolly>=0){
					scroolly=scroolly-9.9;
					$('.ui-scrollbar-bar').css({'top':scroolly});
					$('.ui-menu').css({'top':-4.34*scroolly});
			    }
			}
		return false;
	}
	
	//点击li选择省份
    $(".ui-select-options ul li").click(function (event) {
		var o=$(this).text();
		$(".ui-select-selected").text(o);
		$(".ui-select-options").hide();
		$(".ui-icon-triangleb").css({'background-position':'14px -21px'});
		i=0;
	});	
	
}
