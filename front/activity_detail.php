<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
require_once('../background/conf/connect.php');
$sId=$_GET['sId'];
$actId=$_GET['actId'];
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
//判断活动是否关闭
$flag=false;
$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_open where actId='$actId'"));
if(!$aInfo){
	$aInfo=mysql_fetch_assoc(mysql_query("select * from society_act_closed where actId='$actId'"));
	$flag=true;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>活动详情</title>
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/activity_detail.css" type="text/css" rel="stylesheet">
</head>

<body>
<!--顶部--> 
<div class="top_back">
  <div class="top">
      <ul>

        <li class="a"><?php echo $aInfo['actName']?></li>
        <li class="b">返回&nbsp&nbsp;<a href="society_home.php?sId=<?php echo $sId?>">我的社团>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

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
if($flag==false){
?>
            <a href="javascript:close_act()"><div class="close_act">关闭活动</div></a>
<?php 
}else{
?>
			<a href="javascript:close_act()"><div class="close_act">删除活动</div></a>	
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
        <!--当前报名-->
    	<div class="page page_2">
        	<strong>当前报名：</strong>
<?php if($member_info){?>
            <div class="table">
              <ul>
                <li><span>选择</span><span>姓名</span><span>专业班级</span><span>手机号码</span><span>部门</span><span>备注</span></li>
<?php
	foreach($member_info as $value){
		if(empty($value['aRemark'])){
			$value['aRemark'] = '添加备注';}
?>                
                <li><span><input type="checkbox" value="<?php echo $value['aId']?>" id="key" name='member[]'/></span><span><a href="javascript:void(0)" id="table_a"><img src=""/>屈煜晖<?php echo $value['aName']?><i><?php echo $value['aSex']?></i></a></span><span>通信工程1214<?php echo $value['aClass']?></span><span>13201865125<?php echo $value['aTel']?></span><span>吃屎部<?php echo $value['sDep']?></span><span><a href="javascript:void(0)" class="add_remark">？？<?php echo $value['aRemark']?></a></span><div class="edit_box" style="display:none"><input type="text" id="remark"/></div></li>
               
<?php
	}
?>                             
                <li><span><input type="checkbox" id="all" value=""/></span><span style="border-right:0;"><label for="all">全选</label></span><a href="" id="load_more">加载更多<i></i></a></li>
              </ul>
            </div>
            <div class="handle">
            	<p>操作：</p><a href="" id="h1">删除</a><div class="edit_box" style="width:0px;"><input type="text" id="remark_selected"/></div><a href="javascript:add_edit()" id="h2">添加备注</a><a href="" id="h3">发送通知</a><a href="" id="h4">录用</a>
            </div>
            <div style="clear:both;"></div>            
<?php
	}else{
?>
    <div class="no_body">当前还没有报名成员！</div>
<?php
	}
?>        
        </div>
        <!--评论-->
    	<div class="page">
        	<strong>评论：</strong>
        </div>
    </div>
    
    <div class="right">
    	<div class="board">
            <strong>活动公告</strong><a href="javascript:edit()" id="a1">编辑</a><a href="javascript:save()" style="display:none" id="a2">保存</a>
				<br/><input type="hidden" id="actId" value="<?php echo $actId?>"/><textarea name="board" id="board_text" placeholder="不超过140个字符" readonly="readonly"><?php echo $aInfo['actBoard']?></textarea>
            
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
<!--关闭提醒框--> 
<div class="notice_box" id="notice_box" style="display:none;">
<?php
if($flag==false){
?>
	<strong>您确定要关闭此次活动？</strong>
    <div class="choose"><a class="button" href="../background/background_society/activity/activity_closed.php?actId=<?php echo $actId?>&sId=<?php echo $sId?>">确定</a><a class="button" href="javascript:cancel_close()">取消</a></div>
<?php
}else{
?>
	<strong>您确定要删除此次活动？</strong>
    <div class="choose"><a class="button" href="../background/background_society/activity/activity_del.php?actId=<?php echo $actId?>&sId=<?php echo $sId?>">确定</a><a class="button" href="javascript:cancel_close()">取消</a></div>
<?php
}
?>
</div>




<!--侧边快捷操作面板--> 
<div class="icon_box">
	<a href=""><div id="icon_1"></div></a>
    <a href="personal_center.php"><div id="icon_2"></div></a>
    <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script src="js/activity_detail.js" type="text/javascript"></script>

</body>
</html>