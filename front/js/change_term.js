// JavaScript Document
$(document).ready(function(){
	
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
})