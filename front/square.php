<?php
session_start();
error_reporting(E_ALL & ~E_NOTICE);
$uId=$_SESSION['userId'];
$sSchool=$_SESSION['sSchool'];
require_once('../background/conf/connect.php');
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
$query=mysql_query("SELECT sId,sImg FROM society WHERE sSchool='$sSchool'");
if($query && mysql_num_rows($query)){
	    while($row = mysql_fetch_assoc($query)){
			$allSociety[]=$row;
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
        <a href="society_establish.php"><li class="unselected">创建社团</li></a>
        <a onclick="mysociety()"><li class="unselected">我的社团</li></a>
      </ul>
      <div style="clear:both;"></div>
      <div id="mysociety">
        <ul>
        <?php 
			if($sName){
				for($i=0;$i<=sizeof($sName)-1;$i++){
		?>
          	<a href="society_home.php?sId=<?php echo $societyId[$i]?>"><?php echo $sName[$i]?></a>
         <?php 
		 	}}
		 ?>
          <div style="clear:both;"></div>
        </ul>   
      </div>
      
    </div>
</div>


    
<div class="activity">
<table cellspacing="0">
  <tr>
    <td width="380" height="45"><strong>活动推荐：</strong></td>
    <td width="120"></td>
    <td rowspan="6" width="250" class="img"></td>
  </tr>
  <tr>
    <td height="40"><a href="#">MT音乐俱乐部正式开始纳新！</a></td>
    <td>2012-05-01</td>
    </tr>
  <tr>
    <td height="40"><a href="#">MT音乐俱乐部正式开始纳新！</a></td>
    <td>2012-05-01</td>
    </tr>
  <tr>
    <td height="40"><a href="#">MT音乐俱乐部正式开始纳新！</a></td>
    <td>2012-05-01</td>
    </tr>
  <tr>
    <td height="40"><a href="#">MT音乐俱乐部正式开始纳新！</a></td>
    <td>2012-05-01</td>
    </tr>
  <tr>
    <td height="40"><a href="#">MT音乐俱乐部正式开始纳新！</a></td>
    <td>2012-05-01</td>
    </tr>
</table>
</div>



<div style="clear:both;"></div>

<?php
//查询社团封面 
$sId=1;
$sInfo=mysql_fetch_array(mysql_query("select sImg from society where sId='$sId'"));
$sImg=substr($sInfo['sImg'],3);
?>
<!--社团封面墙-->
<div class="society_card" id="cards">
  <div class="card_in">
    <div id="card_1" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_visitor.php?sId=<?php echo $sId ?>"><img src="<?php echo $sImg?>"/></a>
        <div id="card_1_cover" class="card_a_cover"></div>
        <div id="card_1_det" class="card_a_det" style="display:none;">
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_7" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href="activity_cards.php"><img src="../image/society_logo/u=801810842,3045602267&fm=21&gp=0.jpg"/></a>
            <div id="card_7_cover" class="card_c_cover"></div>
            <div id="card_7_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_8" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=484766370,2203549706&fm=21&gp=0.jpg"/></a>
            <div id="card_8_cover" class="card_c_cover"></div>
            <div id="card_8_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_9" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=3962778191,940168985&fm=21&gp=0.jpg"/></a>
            <div id="card_9_cover" class="card_c_cover"></div>
            <div id="card_9_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_10" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=392091846,1659149597&fm=21&gp=0.jpg"/></a>
            <div id="card_10_cover" class="card_c_cover"></div>
            <div id="card_10_det" class="card_c_det" style="display:none;">
            </div>
        </div>
    </div>
    <div id="card_2" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href=""><img src="../image/society_logo/u=358487922,984970018&fm=21&gp=0.jpg"/></a>
        <div id="card_2_cover" class="card_a_cover"></div>
        <div id="card_2_det" class="card_a_det" style="display:none;">
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_11" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=3504401578,1101857660&fm=21&gp=0.jpg"/></a>
            <div id="card_11_cover" class="card_c_cover"></div>
            <div id="card_11_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_12" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=3258953337,2869384803&fm=21&gp=0.jpg"/></a>
            <div id="card_12_cover" class="card_c_cover"></div>
            <div id="card_12_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_13" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=1957469265,2649025778&fm=21&gp=0.jpg"/></a>
            <div id="card_13_cover" class="card_c_cover"></div>
            <div id="card_13_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_14" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=1893159384,4132529176&fm=21&gp=0.jpg"/></a>
            <div id="card_14_cover" class="card_c_cover"></div>
            <div id="card_14_det" class="card_c_det" style="display:none;">
            </div>
        </div>
    </div>
    
    <div id="card_3" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href=""><img src="../image/society_logo/u=1172880492,3133369770&fm=21&gp=0.jpg"/></a>
        <div id="card_3_cover" class="card_a_cover"></div>
        <div id="card_3_det" class="card_e_det" style="display:none;">
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_15" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/cdbf6c81800a19d850e70c5630fa828ba71e46f9.jpg"/></a>
            <div id="card_15_cover" class="card_c_cover"></div>
            <div id="card_15_det" class="card_d_det" style="display:none;">
            </div>
        </div>
        <div id="card_16" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/53e58PICsSq_1024.jpg"/></a>
            <div id="card_16_cover" class="card_c_cover"></div>
            <div id="card_16_det" class="card_d_det" style="display:none;">
            </div>
        </div>
        <div id="card_17" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/4923011_091716903000_2.jpg"/></a>
            <div id="card_17_cover" class="card_c_cover"></div>
            <div id="card_17_det" class="card_d_det" style="display:none;">
            </div>
        </div>
        <div id="card_18" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/47J58PICQgd_1024.jpg"/></a>
            <div id="card_18_cover" class="card_c_cover"></div>
            <div id="card_18_det" class="card_d_det" style="display:none;">
            </div>
        </div>
    </div>
    <div class="card_b">
        <div id="card_19" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/3920444_110025089229_2.jpg"/></a>
            <div id="card_19_cover" class="card_c_cover"></div>
            <div id="card_19_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_20" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/31558PICcyh_1024.jpg"/></a>
            <div id="card_20_cover" class="card_c_cover"></div>
            <div id="card_20_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_21" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/20120503_a0b6cc962e34afeb7907RBeeIYywWQG7.jpg"/></a>
            <div id="card_21_cover" class="card_c_cover"></div>
            <div id="card_21_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_22" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/3920444_110025089229_2.jpg"/></a>
            <div id="card_22_cover" class="card_c_cover"></div>
            <div id="card_22_det" class="card_c_det" style="display:none;">
            </div>
        </div>
    </div>
    
    <div id="card_4" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href=""><img  src="../image/society_logo/31558PICcyh_1024.jpg"/></a>
        <div id="card_4_cover" class="card_a_cover"></div>
        <div id="card_4_det" class="card_a_det" style="display:none;">
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_23" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/4923011_091716903000_2.jpg"/></a>
            <div id="card_23_cover" class="card_c_cover"></div>
            <div id="card_23_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_24" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/4923011_091716903000_2.jpg"/></a>
            <div id="card_24_cover" class="card_c_cover"></div>
            <div id="card_24_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_25" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/4923011_091716903000_2.jpg"/></a>
            <div id="card_25_cover" class="card_c_cover"></div>
            <div id="card_25_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_26" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/4923011_091716903000_2.jpg"/></a>
            <div id="card_26_cover" class="card_c_cover"></div>
            <div id="card_26_det" class="card_c_det" style="display:none;">
            </div>
        </div>
    </div>
    
    <div id="card_5" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href=""><img src="../image/society_logo/u=3962778191,940168985&fm=21&gp=0.jpg"/></a>
        <div id="card_5_cover" class="card_a_cover"></div>
        <div id="card_5_det" class="card_a_det" style="display:none;">
        </div>
    </div>
    
    <div class="card_b">
        <div id="card_27" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=3962778191,940168985&fm=21&gp=0.jpg"/></a>
            <div id="card_27_cover" class="card_c_cover"></div>
            <div id="card_27_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_28" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=3962778191,940168985&fm=21&gp=0.jpg"/></a>
            <div id="card_28_cover" class="card_c_cover"></div>
            <div id="card_28_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_29" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=3962778191,940168985&fm=21&gp=0.jpg"/></a>
            <div id="card_29_cover" class="card_c_cover"></div>
            <div id="card_29_det" class="card_c_det" style="display:none;">
            </div>
        </div>
        <div id="card_30" class="card_c" onmouseover="movecover(this)" onmouseout="recover(this)">
            <a href=""><img src="../image/society_logo/u=3962778191,940168985&fm=21&gp=0.jpg"/></a>
            <div id="card_30_cover" class="card_c_cover"></div>
            <div id="card_30_det" class="card_c_det" style="display:none;">
            </div>
        </div>
    </div>
    <div id="card_6" class="card_a" onmouseover="movecover(this)" onmouseout="recover(this)">
        <a href="society_cards.php"><img src="../image/society_logo/图片1.png"/></a>
        <div id="card_6_cover" class="card_a_cover"></div>
        <div id="card_6_det" class="card_e_det" style="display:none;">
        </div>
    </div>
  </div> 
  <div class="cover" id="cards_cover">社团名片墙</div> 
</div>
<div style="clear:both;"></div>
<div style="height:100px;"></div>
<script src="js/jquery-1.11.1.js"></script>
<script src="js/square.js"></script>
</body>
</html>
