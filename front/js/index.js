//获取焦点改变文本框（当前对象的父标签）边框颜色：操作的文本框
function register_text_in(x){
    x.parentNode.style.border="1px solid #00ACFF";
}

//失去焦点改变文本框（当前对象的父标签）边框颜色：操作的文本框
function register_text_out(x){
     x.parentNode.style.border="1px solid #ccc";
}

// JavaScript Document
//弹出窗口：要弹出窗口的id
function newbox(wid){
	$('#'+wid).fadeIn("fast");	
}

//窗口消失：要消失窗口的id
function movebox(wid){
	$('#'+wid).fadeOut("fast");
}





