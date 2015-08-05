// JavaScript Document


//*************************************************************
//检查一个对象是否包含在另外一个对象中的方法
function contains(parentNode, childNode) {
    if (parentNode.contains) {
        return parentNode != childNode && parentNode.contains(childNode);
    } else {
        return !!(parentNode.compareDocumentPosition(childNode) & 16);
    }
}

//检查鼠标是否真正从外部移入或者移出对象的函数
function checkHover(e,target){
    if (getEvent(e).type=="mouseover")  {
        return !contains(target,getEvent(e).relatedTarget||getEvent(e).fromElement) && !((getEvent(e).relatedTarget||getEvent(e).fromElement)===target);
    } else {
        return !contains(target,getEvent(e).relatedTarget||getEvent(e).toElement) && !((getEvent(e).relatedTarget||getEvent(e).toElement)===target);
    }
}
function getEvent(e){
    return e||window.event;
}


//******************************************************************
//页面加载时产生的事件响应
window.onload = function () {
    
	//焦点轮播图效果
            var container = document.getElementById('container');
            var list = document.getElementById('list');
            var buttons = document.getElementById('buttons').getElementsByTagName('div');
           
            var index = 1;
            var len = 4;         //总共有4张图片
            var animated = false;
            var interval = 3000;   //每隔3秒图片进行一次切换
            var timer;


            function animate (offset) {
                if (offset == 0) {
                    return;
                }
                animated = true;
                var time = 300;     //每次切换所用时常为300ms
                var inteval = 10;
                var speed = offset/(time/inteval);
                var left = parseInt(list.style.marginLeft) + offset;

                var go = function (){
                    if ( (speed > 0 && parseInt(list.style.marginLeft) < left) || (speed < 0 && parseInt(list.style.marginLeft) > left)) {
                        list.style.marginLeft = parseInt(list.style.marginLeft) + speed + 'px';
                        setTimeout(go, inteval);
                    }
                    else {
                        list.style.marginLeft = left + 'px';
                        if(left>-200){
                            list.style.marginLeft = -537 * len + 'px'; //图片宽度为630
                        }
                        if(left<(-537 * len)) { 
                            list.style.marginLeft = '-537px';
                        }
                        animated = false;
                    }
                }
                go();
            }

            function showButton() {
                for (var i = 0; i < buttons.length ; i++) {
                    if( buttons[i].className == 'on'){
                        buttons[i].className = '';
                        break;
                    }
                }
                buttons[index - 1].className = 'on';
            }

            function play() {
                timer = setTimeout(function () {
                    next();
                    play();
                }, interval);
            }
            function stop() {
                clearTimeout(timer);
            }

            function next() {
                if (animated) {
                    return;
                }
                if (index == 4) {
                    index = 1;
                }
                else {
                    index += 1;
                }
                animate(-537); 
                showButton();
            }
           
            for (var i = 0; i < buttons.length; i++) {
                buttons[i].onclick = function () {
                    if (animated) {
                        return;
                    }
                    if(this.className == 'on') {
                        return;
                    }
                    var myIndex = parseInt(this.getAttribute('index'));
                    var offset = -537 * (myIndex - index);  

                    animate(offset);
                    index = myIndex;
                    showButton();
                }
            }

            container.onmouseover = stop;
            container.onmouseout = play;

            play();



	
	//鼠标划过cards，遮罩层消失；
    document.getElementById('cards').onmouseover=function(){
        if(checkHover(window.event,this)){
            $("#cards_cover").fadeOut();
        }
    }
    //鼠标离开cards，遮罩层出现；
     document.getElementById('cards').onmouseout=function(){
        if(checkHover(window.event,this)){
	        $("#cards_cover").fadeIn();
        }
    }




}
var timer = null;
//出现相应card名片详情
function cardIn(x){
	//获取相应名片详情的id
	var det = '#'+x.id+'_det';
	if(timer){
		clearTimeout(timer);
		timer = null;
	}
	timer = setTimeout(function(){
		var cover = x.id+'_cover';
        var state = document.getElementById(cover).style.display;  
			if(state == "none"){
			    $(det).fadeIn("fast");
			}   
	},700)	
}

function cardOut(x){
    //获取相应名片详情的id
	var det = '#'+x.id+'_det';
	 $(det).fadeOut("fast");
}

//鼠标划过card对象，移除相应的遮罩层
function movecover(x){
	//获取相应遮罩层的id
	var cover = '#'+x.id+'_cover';
    if(checkHover(window.event,x)){
        $(cover).fadeOut("fast");
    }
	//跳出响应的名片详情
	cardIn(x);
}
//鼠标离开card对象，出现相应的遮罩层
function recover(x){
	//获取相应遮罩层的id
	var cover = '#'+x.id+'_cover';
    if(checkHover(window.event,x)){
        $(cover).fadeIn("fast");
    }
	//隐藏响应的card详情
	cardOut(x);
}
//打开或关闭我的社团
function mysociety(){
	$(".mysociety").fadeIn("fast");
	$(document).one("click", function (){//对document绑定一个影藏Div方法
		$(".mysociety").fadeOut("fast");
	});
	event.stopPropagation();
}
$(".mysociety").click(function (event){
	event.stopPropagation();//阻止事件向上冒泡
});
//寻找社团
function find_society(){
	scrollTo(0,1300);
}

//**活动推荐部分动画效果****************************************************************
	$(".act_body li").hover(function(){
		$(this).find(".act_img img").animate({height:"110%",width:"110%",margin:"-9px -14px"},300);
		$(this).find(".decs").fadeIn("fast");
		$(this).find(".act_tips").fadeOut("fast");
	},function(){
		$(this).find(".act_img img").animate({height:"100%",width:"100%",margin:"0"},300);
		$(this).find(".decs").fadeOut("fast");
		$(this).find(".act_tips").fadeIn("fast");
	});