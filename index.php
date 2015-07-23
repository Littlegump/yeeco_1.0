<?php	
    if(@$_COOKIE["passwordno"]){
	
?>
	<form id="LoginForm" action="background/background_person/login.php?action=auto" method="post"><!--指向后台的登录模块.php-->
        <input type="hidden" name="usertel" value="<?php echo $_COOKIE["usertelno"]?>"/>
        <input type="hidden"name="password" value="<?php echo $_COOKIE["passwordno"]?>"/>
    </form>
	<script type="text/javascript">
    	document.getElementById('LoginForm').submit();
	</script>
<?php	      
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>yeeco-home</title>
<link href="front/css/login.css" type="text/css" rel="stylesheet">
<link href="front/css/main.css" type="text/css" rel="stylesheet">
</head> 
<body> 
<div class="top_back">
  <div class="top">
      <div class="top_logo"><a href="../index.php"><img src="image/web_image/logo.png" width=100% height=100% /></a></div>
      <ul class="top_right">
        <a onMouseOver="newbox('code_2')" onMouseOut="movebox('code_2')"><li>Android下载</li></a>
        <a onMouseOver="newbox('code_1')" onMouseOut="movebox('code_1')"><li>iPhone下载</li></a>
        <a href="front/register.php"><li>注册易可账号</li></a>
      </ul>
      <div id="code_1">
           <img src="image/web_image/二维码.png"/>
      </div>
      <div id="code_2">
           <img src="image/web_image/二维码.png"/>
      </div>
  </div>
</div>

<div style="clear:both;"></div>

<div class="first_page">
      
    <div class="b"><img src="image/web_image/主题图片.png"></div>
    <div class="a"><img src="image/web_image/背景图片1.png"></div>  
    <div class="c"><img src="image/web_image/气泡1.png"></div>
    <div class="d"><img src="image/web_image/气泡2.png"></div>
    <div class="e"><img src="image/web_image/气泡3.png"></div>
    
    <div class="login_box">
        <div class="logon_header">
          登&nbsp;录
        </div>
    <form name="LoginForm" action="background/background_person/login.php" method="post"><!--指向后台的登录模块.php-->
        <div class="lnusername">
            <div class="icon"></div>
            <input type="text" id="username" name="usertel" class="text-input" onFocus="register_text_in(this)" onBlur="register_text_out(this)" placeholder="请输入手机号码" required/>
        </div>
        <div class="lnpassword">
            <div class="icon"></div>
            <input type="password" id="password" name="password" class="text-input" onFocus="register_text_in(this)" onBlur="register_text_out(this)" placeholder="请输人密码" required oncopy="return false" onpaste="return false"/>
        </div>
        <label class="checkbox"><input type="checkbox" name="remember" checked="checked">自动登录</label>
        <label class="forget"><a href="front/change_password.php">忘记密码</a></label>
        <input type="submit" name="submit" class="logon" value="登录">
    </form>
    </div>

    
</div>
<div style="height:1000px;"></div>
<div style="clear:both;"></div>
<div class="foot_back">
  <div class="foot">
      <div class="foot_logo"><img src="image_main/logo.png" width=100% height=100% /></div>
      <div class="foot_middle">
        <p>好点子，心生活！&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;易可传技，传递价值！<br/>
	    地址：西安邮电大学东区大学生创新创业孵化基地B3       |京ICP备 13046642号-2  </p>
      </div>
      <div class="foot_right">
	    <ul>
		  <li><a href="">网站主页</a></li>
		  <li><a href="">新手上路</a></li>
		  <li><a href="">网站地图</a></li><br>
	      <li><a href="">诚聘英才</a></li>
		  <li><a href="">关于我们</a></li>
		  <li><a href="">联系方式</a></li>
	    </ul>
	  </div>
  </div>
</div>
<script src="front/js/jquery-1.11.1.js"></script>
<script src="front/js/index.js"></script>
</body>
</html>
