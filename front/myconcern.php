<?php
	session_start();
	error_reporting(E_ALL & ~E_NOTICE);
	require_once('../background/conf/connect.php');
	require_once('../background/conf/session.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>个人中心</title>
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/myconcern.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">个人中心</li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">

<!--左侧导航按钮--> 
  <div class="left">
      <div class="picture"></div>
      <div class="buttons" id="fixedSide">
      	  <a href="myconcern.php"><div><li>我关注的</li></div></a>
      	  <a href="personal_center.php?action=info"><div><li>个人资料</li></div></a>
          <a href="personal_center.php?action=account"><div><li>账号信息</li></div></a>
      </div>
  </div>


<!--我的动态页面-->   
<div class="main" id="main_1">
    <div class="page_title">
        <li class="title_left">我关注的&nbsp;·&nbsp;社团</li>
    </div>
    <div class="contact">

    </div>  
</div>

<div class="main" id="main_2">
    <div class="page_title">
        <li class="title_left">我关注的&nbsp;·&nbsp;活动</li>
    </div>
    <div class="contact">
			<a href="#" style="color:#333;">
                <div class="act">
                    <div class="act_ad">
                        <img src="#"/>
                    </div>
                    <ul class="act_tips">
                      <li><strong>活动名称</strong><span class="number"><strong>34</strong>人报名&nbsp;<strong>43</strong>人关注</span></li>
                      <li><label>类型：</label><span>比赛/面向全校/无需报名</span></li>		
                      <li><label>时间：</label><span>2015-07-25 16:01 ~ 2015-07-25 16:01</span></li>
                      <li><label>地点：</label><span>这里是活动地点</span></li>
                      <li><label>简介：</label><span>这里是活动简介</span></li>
                    </ul>       
                    <div style="clear:both;"></div>
                </div>
             </a>	
    </div>  
</div>

</div>

<!--侧边快捷操作面板-->
<div class="icon_box">
     <a href=""><div id="icon_1"></div></a>
     <a href="personal_center.php"><div id="icon_2"></div></a>
     <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script src="js/myconcern.js" type="text/javascript"></script>

</body>
</html>

