<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
require_once('../background/conf/connect.php');
require_once('../background/conf/session.php');

//查找用户
$find_user = mysql_query("select * from user where uId='$uId' limit 1");
$result_user = mysql_fetch_array($find_user);
//查找用户相关社团ID
$user_society_Id=mysql_query("SELECT societyId FROM user_society_relation WHERE userId='$uId' and isManage<>4");
if($user_society_Id && mysql_num_rows($user_society_Id)){
	    while($row = mysql_fetch_assoc($user_society_Id)){
			$societyId[]=$row['societyId'];
		}			
}

//获取社团名称
if($societyId){
	foreach($societyId as $value){
		$res=mysql_fetch_array(mysql_query("select sName from society where sId='$value' "));
		$sName[]=$res['sName'];
	}
}
//查找所有社团
$query=mysql_query("SELECT sId,sImg FROM society WHERE sSchool='$sSchool' order by sNum desc limit 30");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$society[]=$row;
		}			
}
//$i=1;print_r($i);
//print_r($society);print_r($i);;print_r(++$i);exit;
//查找活动
$query=mysql_query("select * from society_act_open where actSchool='$sSchool' order by actFocusNum desc limit 8");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$acts[]=$row;
		}			
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>易可社团-广场</title>
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/square.css" type="text/css" rel="stylesheet">
<script src="js/jquery-1.11.1.js"></script>
</head>


<body>
<div class="top_back">
  <div class="top">
      <div class="top_logo"><a href="../index.jsp"><img src="../image/web_image/logo.png"/></a></div>
      <div class="top_right">
          <ul>
            <li>
                <span><img src="../<?php echo $result_user['userFace']?>"/></span>
                <span><?php echo $_SESSION['userName']?></span>
            </li> 
            <div style="clear:both;"></div>
            <a href="personal_center.php"><li>个人中心</li></a>
            <a href=""><li>易可助手</li></a>
            <a href="../background/background_person/login.php?action=logout"><li>退出登录</li></a>
          </ul>
      </div>
  </div>
</div>
<div style="clear:both;"></div>
    
<div class="page_main" id="page_main">
<script>
//计算并设置主页面的高度
    $("#page_main").height($(window).height()-100); 
</script>

<div id="all_cover" style="display:none;"></div>
    <div class="pic_back">
      <div class="pic_main" id="container"> 
          <div id="list" style="margin-left: -537px;"><!--图片宽度为537-->
            <a href=""><img src="../image/web_image/测试图片/4.jpg" alt="1"/></a>
            <a href=""><img src="../image/web_image/测试图片/1.jpg" alt="1"/></a>
            <a href=""><img src="../image/web_image/测试图片/2.jpg" alt="2"/></a>
            <a href=""><img src="../image/web_image/测试图片/3.jpg" alt="3"/></a>
            <a href=""><img src="../image/web_image/测试图片/4.jpg" alt="4"/></a>
            <a href=""><img src="../image/web_image/测试图片/1.jpg" alt="4"/></a>
          </div>
      </div>
      <div class="pic_right" id="buttons">
        <div index="1" class="on"></div>
        <div index="2" ></div>
        <div index="3" ></div>
        <div index="4" ></div>
      </div>
    </div>
    <div class="slogan"></div>
    
    <div class="buttons">
      <ul>
        <a onclick="find_society()"><li class="unselected">寻找社团</li></a>
        <a onclick="mysociety()"><li class="unselected">我的社团</li></a>
      </ul>
      <div style="clear:both;"></div>
    </div>
    <div class="mysociety" style="display:none">
        <ul>
        <?php 
			if($sName){
				for($i=0;$i<=sizeof($sName)-1;$i++){
		?>
          	<li><a href="society_home.php?sId=<?php echo $societyId[$i]?>"><?php echo $sName[$i]?></a></li>
         <?php 
		 	}}
		 ?>
          <div style="clear:both;"></div>
        </ul>   
      </div>
</div>

<!--活动推荐-->
<div class="act_recommend">
	<div class="title">活动推荐</div>
	<div class="act_body">
      <ul>
<?php
if($acts){
	foreach($acts as $act){
?>
 		<li>
          <a href="activity_visitor.php?actId=<?php echo $act['actId']?>">
             <div class="act_img">
                 <img src="<?php echo substr($act['actImg'],3)?>" alt="">
          	 </div>
             <div class="decs" style="display:none">
             	 <p><?php echo $act['actDesc']?></p>
             </div>
          	 <div class="act_tips">
             	 <h2><?php echo $act['actName']?></h2>
             	 <span class="act_l"><?php echo $act['actFocusNum']?>关注</span>
             	 <span class="act_r"><?php echo $act['actBeginDate'].' '.$act['actBeginTime']?></span>
             </div>
          </a>
        </li>
<?php
	}
}
?>
      </ul>
      <div style="clear:both;"></div>
    </div>
    <div class="more_act">
    	<a href="activity_cards.php" class="button">更多活动</a>
    </div>
</div>
<!--社团封面墙-->
<div class="society_card" id="cards">
  <div class="card_in">
<?php
//查询社团封面 
if($society){
	$k=1;$i=0;
	for(;$i<=sizeof($society);$i++){
?>
    <div id="card_<?php echo $k?>" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_visitor.php?sId=<?php echo $society[$i]['sId']?>"><img src="<?php echo substr($society[$i]['sImg'],3)?>"/></a>
        <div id="card_<?php echo $k?>_cover" class="card_a_cover"></div>
        <div id="card_<?php echo $k++?>_det" class="card_a_det" style="display:none;">
        ??????
        </div>
    </div>    
    <div class="card_b">
        <div id="card_<?php echo $k?>" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[++$i]['sId']?>"><img src="<?php echo substr($society[$i]['sImg'],3)?>"/></a>
            <div id="card_<?php echo $k?>_cover" class="card_c_cover"></div>
            <div id="card_<?php echo $k++?>_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_<?php echo $k?>" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[++$i]['sId']?>"><img src="<?php echo substr($society[$i]['sImg'],3)?>"/></a>
            <div id="card_<?php echo $k?>_cover" class="card_c_cover"></div>
            <div id="card_<?php echo $k++?>_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_<?php echo $k?>" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[++$i]['sId']?>"><img src="<?php echo substr($society[$i]['sImg'],3)?>"/></a>
            <div id="card_<?php echo $k?>_cover" class="card_c_cover"></div>
            <div id="card_<?php echo $k++?>_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_<?php echo $k?>" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="society_visitor.php?sId=<?php echo $society[++$i]['sId']?>"><img src="<?php echo substr($society[$i]['sImg'],3)?>"/></a>
            <div id="card_<?php echo $k?>_cover" class="card_c_cover"></div>
            <div id="card_<?php echo $k++?>_det" class="card_c_det" style="display:none;">
            </div>
        </div>
    </div>
<?php 
	}
}
?>
  </div> 
  <div class="cover" id="cards_cover">社团名片墙</div> 
  
</div>
<div style="clear:both;"></div>

<div class="more_society">
    <a href="society_cards.php" class="button">更多社团</a>
</div>


<div class="mobile_client">
</div>

<div class="about_us">
</div>
<div class="footer">
	<p><a href="temp_page.html">招才纳士</a><a href="temp_page.html">联系我们</a><a href="temp_page.html">意见反馈</a><a href="temp_page.html">网站地图</a><a href="temp_page.html">新手学堂</a></p>
    <hr color="#ccc" size="1"/>
    <p>中国·陕西·西安市·长安区·西安邮电大学 710100 | *</p>
    <p>好点子，新生活</p>
</div>
<script src="js/square.js"></script>
</body>
</html>
