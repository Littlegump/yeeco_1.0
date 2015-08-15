<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
$sId=$_GET['sId'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的社团-换届</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/change_term.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back transparency"></div>
  <div class="top">
      <ul>
        <li class="a">logo</li>
        <li class="b">MT音乐俱乐部</li>
        <li class="c">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
      <div style="clear:both;"></div>
  </div>
  
<!--社团封面部分-->
<div class="head">
    <div class="head_in">
    	<div class="cover_pic"><img src=""/></div>
        <div class="name"><strong>MT音乐俱乐部</strong></div>
        <div class="description"><p>这是一个，值得你去追求梦想，不断前行，不断成长的地方。在这里，你会啦啦啦啦啦啦啦啦啦！</p></div>
    </div>
</div>

<div class="body">
    <!--左侧导航按钮-->
    <div class="left">
    	<a href="fresh_open.php"><div class="fresh_button">开启纳新</div></a>
        <div class="buttons" id="fixedSide">
        <a href="society_home.php?sId=<?php echo $sId?>"><div><li><img src=""/>社团动态</li></div></a>
        <a href="address_book.php?sId=<?php echo $sId?>"><div><li><img src=""/>通讯录</li></div></a>
        <a href="activity.php?sId=<?php echo $sId?>"><div><li><img src=""/>活动</li></div></a>
        <a href="society_info.php?sId=<?php echo $sId?>"><div><li><img src=""/>社团资料</li></div></a>
        <a href="change_term.php?sId=<?php echo $sId?>"><div class="nav_on"><li><img src=""/>换届</li></div></a>
        <a href="temp_page.html"><div><li><img src=""/>找赞助</li></div></a>
      </div>
    </div>
    <!--中间主体内容-->
    <div class="main">
        <div class="temp">不好意思啊！！这里还在装修，过些时候再来吧!<br/><a href="javascript:history.go(-1);">点此返回</a></div>
    </div>
    
</div>

<!--侧边快捷操作面板-->
<div class="icon_box">
     <a href="massageBox.php"><div id="icon_1"></div>
<?php
	if(mysql_num_rows(mysql_query("select  msgId  from message where msgToId='$uId'"))){
?>     
     <span></span>
<?php
	}
?> 
     </a>
     <a href="personal_center.php"><div id="icon_2"></div></a>
     <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>
<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script src="js/change_term.js" type="text/javascript"></script>
</body>