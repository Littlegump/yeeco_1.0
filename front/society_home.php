<?php 
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
$sId=$_GET['sId'];
$uId=$_SESSION['userId'];
//获取用户身份
$isManage=mysql_fetch_assoc(mysql_query("select isManage from user_society_relation where societyId='$sId' and userId='$uId'"));
if($isManage['isManage']==0){
	$user_limit='成员';
}else if($isManage['isManage']==1){
	$user_limit='管理员';
}else if($isManage['isManage']==2){
	$user_limit='创建人';
}
$societyRes=mysql_fetch_array(mysql_query("select *  from society where sId='$sId'"));
//获取动态
$res=mysql_query("select * from dynamic_state where sId='$sId'");
if($res && mysql_num_rows($res)){	
	while($row = mysql_fetch_assoc($res)){
			$news[] = $row;	
	}			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我的社团-社团动态</title>
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/society_home.css" type="text/css" rel="stylesheet">
</head>
<body>
<div class="top_back transparency"></div>
  <div class="top">
      <ul>
        <li class="a">logo</li>
        <li class="b"><?php echo $societyRes['sName']?></li>
        <li class="c">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
      <div style="clear:both;"></div>
  </div>
  
<!--社团封面部分-->
<div class="head">
    <div class="head_in">
    	<div class="cover_pic"><img src="<?php echo substr($societyRes['sImg'],3)?>"/></div>
        <div class="name"><strong><?php echo $societyRes['sName']?></strong></div>
        <div class="description"><p><?php echo $societyRes['sDesc']?></p></div>
        <div class="identity">我是：<a href="" ><?php echo $user_limit?></a></div>
    </div>
</div>

<div class="body">
    <!--左侧导航按钮-->
    <div class="left">
<?php
if($user_limit!='成员'){
	if($societyRes['isFresh']!=1){
		
?>
    	<a href="fresh_open.php?sId=<?php echo $sId?>&sName=<?php echo $societyRes['sName']?>"><div class="fresh_button">开启纳新</div></a>
<?php
	}else{
?>
        <a href="fresh_detail.php?sId=<?php echo $sId?>"><div class="fresh_button">查看纳新</div></a>
<?php
	}
}else{
?>
	<a href="society_visitor.php?sId=<?php echo $sId?>"><div class="fresh_button">查看纳新</div></a>
<?php
}
?>
        <div class="buttons" id="fixedSide">
        <a href="society_home.php?sId=<?php echo $sId?>"><div class="nav_on"><li><img src=""/>社团动态</li></div></a>
        <a href="address_book.php?sId=<?php echo $sId?>"><div><li><img src=""/>通讯录</li></div></a>
        <a href="activity.php?sId=<?php echo $sId?>"><div><li><img src=""/>活动</li></div></a>
        <a href="society_info.php?sId=<?php echo $sId?>"><div><li><img src=""/>社团资料</li></div></a>
        <a href="change_term.php?sId=<?php echo $sId?>"><div><li><img src=""/>换届</li></div></a>
        <a href="find_sponsor.php?sId=<?php echo $sId?>"><div><li><img src=""/>找赞助</li></div></a>
      </div>
    </div>
    <!--中间主体内容-->
    <div class="main">
        <div class="send_ms">
        </div>
        <div id="list">
           <!-- <div class="box clearfix">
                <a class="close" href="javascript:;">×</a>
                <img class="user_face" src="../image/user_image/test/1.jpg" alt=""/>
                <div class="content">
                    <div class="host">
                        <p class="txt">
                            <span class="user">Andy：</span>轻轻的我走了，正如我轻轻的来；我轻轻的招手，作别西天的云彩。
                        </p>
                        <img class="pic" src="../image/user_image/test/img1.jpg" alt=""/>
                    </div>
                    <div class="info clearfix">
                        <span class="time">02-14 23:01</span>
                        <a class="praise" href="javascript:;">赞</a>
                    </div>
                    <div class="praises-total" total="4" style="display: block;">4个人觉得很赞</div>
                    <div class="comment-list">
                        <div class="comment-box clearfix" user="self">
                            <img class="myhead" src="../image/user_image/test/my.jpg" alt=""/>
                            <div class="comment-content">
                                <p class="comment-text"><span class="user">我：</span>写的太好了。</p>
                                <p class="comment-time">
                                    2014-02-19 14:36
                                    <a href="javascript:;" class="comment-praise" total="1" my="0" style="display: inline-block">1 赞</a>
                                    <a href="javascript:;" class="comment-operate">删除</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-box">
                        <textarea class="comment" autocomplete="off">评论…</textarea>
                        <button class="btn ">回 复</button>
                        <span class="word"><span class="length">0</span>/140</span>
                    </div>
                </div>
            </div>
    
            <div class="box clearfix">
                <a class="close" href="javascript:;">×</a>
                <img class="user_face" src="../image/user_image/test/2.jpg" alt=""/>
                <div class="content">
                    <div class="host">
                        <p class="txt">
                            <span class="user">人在旅途：</span>三亚的海滩很漂亮。
                        </p>
                        <img class="pic" src="../image/user_image/test/img5.jpg" alt=""/>
                    </div>
                    <div class="info clearfix">
                        <span class="time">02-14 23:01</span>
                        <a class="praise" href="javascript:;">赞</a>
                    </div>
                    <div class="praises-total" total="0" style="display: none;"></div>
                    <div class="comment-list">
                        <div class="comment-box clearfix" user="other">
                            <img class="myhead" src="../image/user_image/test/4.jpg" alt=""/>
                            <div class="comment-content">
                                <p class="comment-text"><span class="user">老鹰：</span>我也想去三亚。</p>
                                <p class="comment-time">
                                    2014-02-19 14:36
                                    <a href="javascript:;" class="comment-praise" total="0" my="0">赞</a>
                                    <a href="javascript:;" class="comment-operate">回复</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="text-box">
                        <textarea class="comment" autocomplete="off">评论…</textarea>
                        <button class="btn ">回 复</button>
                        <span class="word"><span class="length">0</span>/140</span>
                    </div>
                </div>
            </div>-->
<?php
if($news){
	foreach($news as $value){
?>
            <div class="box clearfix">
                <a class="close" href="javascript:;">×</a>
                <img class="user_face" src="<?php echo substr($value['nImg'],3)?>" alt=""/>
                <div class="content">
                    <div class="host">
                        <p class="txt">
                            <span class="user"><?php echo $value['oName']?>：</span><?php echo $value['nBody']?>
                        </p>
                    </div>
                    <div class="info clearfix">
                        <span class="time"><?php echo $value['nTime']?></span>
                        <a class="praise" href="javascript:;">赞</a>
                    </div>
                    <div class="praises-total" total="0" style="display: none;"></div>
                    <div class="comment-list">
    
                    </div>
                    <div class="text-box">
                        <textarea class="comment" autocomplete="off">评论…</textarea>
                        <button class="btn ">回 复</button>
                        <span class="word"><span class="length">0</span>/140</span>
                    </div>
                </div>
            </div>
<?php
	}
}
?>
        </div>
    </div>
    <!--右侧 广告 或者其他-->
    <div class="right">
    	<div class="board">
            <strong>公告栏</strong>
<?php 
if($user_limit!='成员'){
?>
            <a href="javascript:edit()" id="a1">编辑</a>
            <a href="javascript:save()" style="display:none" id="a2">保存</a>
<?php
}
?>
				<br/><input type="hidden" id="sId" value="<?php echo $societyRes['sId']?>"/><textarea name="board" id="board_text" placeholder="不超过140个字符" readonly="readonly"><?php echo $societyRes['Board']?></textarea>
            
        </div>
        <div class="advertisement">
          <div class="ad_title">
            <li class="ad_title_li">推广链接</li>
          </div>
          <div class="ad_img"><img src="../image/web_image/测试图片/9.png"></div>
          <div class="ad_img"><img src="../image/web_image/测试图片/20.png"></div>
          <div class="ad_img"><img src="../image/web_image/测试图片/8.png"></div>
          <div class="ad_img"><img src="../image/web_image/测试图片/9.png"></div>
          <div style="clear:both;"></div>
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
<script src="js/society_home.js" type="text/javascript"></script>
<script src="js/comment.js"></script>
</body>