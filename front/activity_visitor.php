<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../background/conf/connect.php');
$actId=$_GET['actId'];
$uId=$_SESSION['userId'];
//查询活动内容
$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_open where actId='$actId'"));
if(!$aInfo){
	$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_closed where actId='$actId'"));
}
//查询是否已经参加活动
$isJoin=mysql_num_rows(mysql_query("select id from act_user_relation where uId='$uId' and actId='$actId'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活动详情</title>
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/activity_visitor.css" type="text/css" rel="stylesheet">
</head>
<body>
<!--顶部--> 
<div class="top_back">
  <div class="top">
      <ul>

        <li class="a"><?php echo $aInfo['actName']?></li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>
<!--个人信息-->
<input type="hidden" id="actId" value="<?php echo $actId?>"/>
<input type="hidden" id="uId" value="<?php echo $uId?>"/>
<!--封面--> 
<div class="head">
	<div class="cover">
    	<img src="<?php echo substr($aInfo['actImg'],3)?>"/>    
    </div>
    <div class="summary">
    	<ul>
          <li>
          <span>活动时间</span>
           <em><?php echo $aInfo['actBeginDate']?>&nbsp;<?php echo $aInfo['actBeginTime']?>&nbsp;~&nbsp;<?php echo $aInfo['actEndDate']?>&nbsp;<?php echo $aInfo['actEndTime']?></em>       
          </li>
          <li>
            <span>活动地点</span>
            <em><?php echo $aInfo['actPlace']?></em>
          </li>     
        </ul>
        <div class="head_handle">
        	<div class="number">
              <ul>
              	<li><span>报名人数</span><em><?php echo $aInfo['actNum']?></em></li>
                <li><span style="margin-right:70px;"></span><span>关注人数</span><em><?php echo $aInfo['actFocusNum']?></em></li>
              </ul>         
            </div>
<?php
if($isJoin){
?>
        <a><div class="close_act">已经报名</div></a>
<?php
}else{
?> 
		<a href="javascript:apply_activity();" id="apply_act"><div class="close_act">报名参加</div></a>  
<?php 
}
?>   
            <div style="clear:both;"></div>
        </div>
    </div>
   
</div>
<div style="clear:both;"></div>

<!--主体-->
<div class="body">
    <div class="main">
    	<!--纳新公告--纳新详情-->
    	<div class="page page_1">
        	<strong>活动类型：</strong>
                <p><?php echo $aInfo['actType']?></p>
        	<strong>活动简介：</strong>
                <p><?php echo $aInfo['actDesc']?></p>
        	<strong>活动详情：</strong><a class="more" href="javascript:detail()"></a>
            	<p id="detail" style="display:none;"><?php echo $aInfo['actDetail']?></p>
        </div>
 
        <!--评论-->
    	<div class="page">
        	<strong>评论：</strong>
        </div>
    </div>
    
    <div class="right">
    	<div class="board">
            <strong>活动公告</strong>
				<br/><input type="hidden" id="sId" value="<?php echo $sId?>"/><textarea name="board" id="board_text" placeholder="暂时没有公告！" readonly="readonly"><?php echo $aInfo['actBoard'] ?></textarea>
        </div>
        <!--社团二维码-->
    	<div class="activity_code">
            <strong>活动二维码</strong>
			<div><img src="<?php echo substr($aInfo['actCode'],3)?>" /></div>
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


<div style="clear:both;"></div>





<!--侧边快捷操作面板--> 
<div class="icon_box">
	<a href=""><div id="icon_1"></div></a>
    <a href="personal_center.php"><div id="icon_2"></div></a>
    <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script src="js/activity_visitor.js" type="text/javascript"></script>

</body>
</html>