<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');
//点对点通信,主动给某人发,生成一则消息div
$chooseToId = $_GET['chooseToId'];
if($chooseToId){
$toUserInfo = mysql_fetch_assoc(mysql_query("select userFace,userName from user where uId='$chooseToId' limit 1"));
}
//查询有没有我的消息
$query=mysql_query("select msgFromId,msgIsRead from message where msgToId='$uId'");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$toMyMsg[]=$row;
		}			
}
//如果有我的消息，查询是谁给我发的
if($toMyMsg){
	foreach($toMyMsg as $fromUid){
		$toUserReply[]=mysql_fetch_assoc(mysql_query("select userFace,userName,uId,'$fromUid[msgIsRead]' as isRead from user where uId='$fromUid[msgFromId]' limit 1"));
	}
}

//print_r($toUserReply);exit;
//查询我给别人发的消息
$query=mysql_query("select msgToId,msgIsRead from message where msgFromId='$uId'");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$fromMyMsg[]=$row;
		}			
}
if($fromMyMsg){
	foreach($fromMyMsg as $fromUid){
		$toUserInfos[]=mysql_fetch_assoc(mysql_query("select userFace,userName,uId,'$fromUid[msgIsRead]' as isRead from user where uId='$fromUid[msgToId]' limit 1"));
	}
}
//print_r($toUserReply);exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" style="height: 100%;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>消息盒子</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="renderer" content="webkit">
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/massageBox.css" type="text/css" rel="stylesheet">
</head>

<body style="height: 100%;">

<div class="top_back">
  <div class="top">
      <ul>
        <li class="a">消息盒子</li>
        <li class="b">返回&nbsp&nbsp;<a href="square.php">易可广场>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<div class="body">
<div class="nav">
   	  <a href="#" id="msgBtn"></a>
      <a href="#" id="linkBtn"></a>
    </div>
    
    <div class="msg_list">
      <ul>
 <?php
 	//
 	if($toUserInfo){
 ?>
      	<a href="javascript:void(0);" onclick="openSingleChat(<?php echo $chooseToId?>,this)"><li>
        <div class="userFace"><img id='ddd' src="../<?php echo $toUserInfo['userFace']?>" /></div>
        <strong><?php echo $toUserInfo['userName']?></strong>
        <p>发给<?php echo $toUserInfo['userName']?>的消息</p><i class="delete_msg">删除</i>
        </li></a>
<?php
	}
	//查询给我发的消息
	if($toMyMsg){
		$toUserReply=array_unique($toUserReply);
		foreach($toUserReply as $reply){
			
?>

       <a href="javascript:void(0);" onclick="openSingleChat(<?php echo $reply['uId']?>,this)"><li>
        <div class="userFace"><img src="../<?php echo $reply['userFace']?>" /></div>
        <strong><?php echo $reply['userName']?></strong>
        <p><?php echo $reply['isRead']?'已读':'未读'?></p><i class="delete_msg">删除</i>
        </li></a>
<?php
		}
	}
	//查询我给别人发的消息
	if($fromMyMsg){
		$toUserInfos=array_unique($toUserInfos);
		foreach($toUserInfos as $reply){
?>
        <a href="javascript:void(0);" onclick="openSingleChat(<?php echo $reply['uId']?>,this)"><li>
        <div class="userFace"><img src="../<?php echo $reply['userFace']?>" /></div>
        <strong><?php echo $reply['userName']?></strong>
        <p><?php echo $reply['userName']?><?php echo $reply['isRead']?'已读':'未读'?></p><i class="delete_msg">删除</i>
        </li></a>
<?php
		}
	}
?>
       
       
       
       <!-- 
        <a href="javascript:openSingleChat(6)"><li>
        <div class="userFace"><img src="../image/user_image/user_face/default_face/default_face_5.jpg" /></div>
        <strong>傻逼屈煜晖</strong>
        <p>Hi小伙伴们，期待已久的林永坚大神的动画案例新作已经新鲜出炉了</p><i class="delete_msg">删除</i>
        </li></a>
        <a href="javascript:openSingleChat(7)"><li>
        <div class="userFace"><img src="../image/user_image/user_face/default_face/default_face_5.jpg" /></div>
        <strong>傻逼屈煜晖</strong>
        <p>Hi小伙伴们，期待已久的林永坚大神的动画案例新作已经新鲜出炉了</p><i class="delete_msg">删除</i>
        </li></a>
        <a href="javascript:openSingleChat(1)"><li>
        <div class="userFace"><img src="../image/user_image/user_face/default_face/default_face_5.jpg" /></div>
        <strong>傻逼屈煜晖</strong>
        <p>Hi小伙伴们，期待已久的林永坚大神的动画案例新作已经新鲜出炉了</p><i class="delete_msg">删除</i>
        </li></a>-->

      </ul>
      <div class="ui-scrollbar-bar" style="top:0;display:none;"></div>
    </div>
    
    <div class="linkman_list" style="display:none">

  </div>
    
    <div class="chat_window state_1" style="display:none">
    
    </div>
    
    <div class="chat_window state_2">
    	<div class="massages">
           <ul>
           <!--
           <li class="Tx_msg">
            	<div class="msg_face"><img src="../image/user_image/user_face/default_face/default_face_8.jpg" /></div>
                <div class="conbine"><em>林圣良</em>
                <div class="msg_content"><p>1这上来看来面是一旦上面上来看上来看来面是一旦上面上面上来看上来看来面是一旦上面上来看上来看来面是一旦上面上来看来</p></div></div>
                <span class="send_time">2015-07-17 15:28</span>
                <div style="clear:both;"></div>
            </li>
            <li class="Rx_msg">
            	<div class="msg_face"><img src="../image/user_image/user_face/default_face/default_face_8.jpg" /></div>
                <div class="conbine"><em>刘钰泽</em>
                <div class="msg_content"><p>2这上来看来面是一来面来看上来看来面是一旦上面上来看上来看来面是一旦上面上来看来</p></div></div>
                <span class="send_time">2015-07-17 15:28</span>
                <div style="clear:both;"></div>
            </li>
            -->
          </ul>       
        </div>
        <div class="sendBox">
          <form action="../background/message/create_msg.php?type=person" method="post" id="massage_form" name="massage_form">
            <input type="hidden" name="userName" value="<?php echo $userName?>" />
            <input type="hidden" name="userFace" value="<?php echo '../'.$userFace?>" />
            <input type="hidden" name="userId" value="<?php echo $uId?>" />
            <input type="hidden" name="toId" value="" />
            <input type="hidden" name="toUserFace" value="" />
            <input type="hidden" name="toUserName" value="" />
        	<textarea name="message"></textarea>
            <input type="submit" value="发送" onclick="send_massage()"/>
          </form>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<div id="result" style="height:500px;">**</div>

<!--侧边快捷操作面板-->
<div class="icon_box">
     <a href=""><div id="icon_1"></div></a>
     <a href="personal_center.php"><div id="icon_2"></div></a>
     <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
<script src="js/massageBox.js" type="text/javascript"></script>



</body>
</html>


