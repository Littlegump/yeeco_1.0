﻿<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
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

//在社团纳新表中提取信息
$freshResult=mysql_fetch_assoc(mysql_query("select * from society_fresh where sId='$sId'"));
$sinfoResult=mysql_fetch_assoc(mysql_query("select sNum,Board,isFresh from society where sId='$sId'"));
$fImg=substr($freshResult['fImg'],3);
$fNum=$freshResult['fNum'];
$fAnn=$freshResult['fAnn'];
$fDetail=$freshResult['fDetail'];
$fBoard=$sinfoResult['Board'];
//在申请成员表apply_information_unselected中查询信息
$members=mysql_query("SELECT aId,uId,aName,aSex,aClass,aTel,sDep,aRemark FROM apply_information_unselected WHERE sId='$sId' order by aSendTime desc");
if($members && mysql_num_rows($members)){
	    while($row = mysql_fetch_assoc($members)){
			$member_info[]=$row;
		}			
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>纳新详情</title>
<link href="css/main.css" type="text/css" rel="stylesheet">
<link href="css/fresh_detail.css" type="text/css" rel="stylesheet">
</head>

<body>
<!--顶部--> 
<div class="top_back">
  <div class="top">
      <ul>

        <li class="a"><?php  echo $freshResult['sName']?>&nbsp;·&nbsp;纳新</li>

        <li class="b">返回&nbsp&nbsp;<a href="society_home.php?sId=<?php echo $sId?>">我的社团>></a></li>
      </ul>
  </div>
</div>
<div style="clear:both;"></div>

<!--封面--> 
<div class="head">
	<div class="cover"><img src="<?php echo $fImg ?>"/></div>
    <div class="summary">
    	<ul>
           <li>
          <span>当前状态</span>
			<?php 
                if($sinfoResult['isFresh']==1){		
            ?>
                    <em>正在纳新</em>           
            <?php
                }else{
            ?>
                    <em>纳新关闭</em>
            <?php 		
                }
            ?>
          </li>
          <li>
            <span>申请人数</span>
            <em><?php echo $fNum ?></em>
          </li>
          <li class="course_hour">
            <span>现有成员</span>
            <em><?php echo $sinfoResult['sNum']?></em>
          </li>
   
        </ul>
    </div>
    <div class="head_handle">

        <div class="read_form" id="read_form">
        	<a href="javascript:read_form();" class="handle_1">
            	<i></i>
            	<em class="read_form-icon">查看（打印）报名表</em>
            </a>
        </div>

        <div class="join">
             <a href="javascript:stopFresh()" class="handle_2">停止纳新</a>
        </div>
    </div>
</div>
<div style="clear:both;"></div>

<!--主体-->
<div class="body">
    <div class="main">
    	<!--纳新公告--纳新详情-->
    	<div class="page page_1">
        	<strong>纳新公告：</strong>
                <p><?php echo $fAnn ?></p>
        	<strong>纳新详情：</strong><a class="more" href="javascript:detail()"></a>
            	<p><pre id="detail" style="display:none;"><?php echo $fDetail ?></pre></p>
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
		$qu=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$value[uId]'"));
		$uImg=$qu['userFace'];
		if(empty($value['aRemark'])){
			$value['aRemark'] = '添加备注';}
?>                
                <li id="<?php echo $value['aId']?>"><span><input type="checkbox" value="<?php echo $value['aId']?>" class="key" name='member[]'/></span><span><a href="javascript:void(0)" id="table_a"><img src="../<?php echo $uImg?>"/><?php echo $value['aName']?><i><?php echo $value['aSex']?></i></a></span><span><?php echo $value['aClass']?></span><span><?php echo $value['aTel']?></span><span><?php echo $value['sDep']=='0'?'任意部门': $value['sDep'];?></span><span><a href="javascript:void(0)" class="add_remark"><?php echo $value['aRemark']?></a></span><div class="edit_box" style="display:none"><input type="text" id="remark"/></div></li>
               
<?php
	}
?>                             
                <li><span><input type="checkbox" id="all" value="888"/></span><span style="border-right:0;"><label for="all">全选</label></span><a href="" id="load_more">加载更多<i></i></a></li>
              </ul>
            </div>
            <div class="handle">
            	<p>操作：</p><a href="javascript:del_app()" id="h1">删除</a><div class="edit_box" style="width:0px;"><input type="text" id="remark_selected"/></div><a href="javascript:add_edit()" id="h2">添加备注</a><a href="" id="h3">发送通知</a><a href="javascript:employ()" id="h4">录用</a>
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
            <strong>公告栏</strong><a href="javascript:edit()" id="a1">编辑</a><a href="javascript:save()" style="display:none" id="a2">保存</a>
				<br/><input type="hidden" id="sId" value="<?php echo $sId?>"/><textarea name="board" id="board_text" placeholder="不超过140个字符" readonly="readonly"><?php echo $fBoard ?></textarea>
            
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

<!--查看、打印报名表--> 
<div class="app_form" id="form_box" style="display:none;">
	<strong><?php  echo $freshResult['sName']?>报名表<a href="javascript:return_main()">&times;</a></strong>
	      <label><span>*</span>填写报名表：</label>
<form action="background/society-apply-form.php" method="post" name="apply_table">
       <input type="hidden" name="sId" value="">
       <input type="hidden" name="userId" value="">
<table cellspacing="0">
  <tr>
    <td width=80>姓名</td>
    <td width=120><input type="text" name="aName" required="required"/></td>
    <td width=80>性别</td>
    <td width=120><input type="text" name="aSex" required="required"/></td>
    <td width=100 rowspan="4" class="photo">
  </tr>
  <tr>
    <td>出生年月</td>
    <td><input type="text" name="aBirthday" required="required"/></td>
    <td>籍贯</td>
    <td><input type="text" name="aNative" required="required"/></td>
  </tr>
  <tr>
    <td>专业班级</td>
    <td><input type="text" name="aClass" required="required"/></td>
    <td>联系电话</td>
    <td><input type="text" name="aTel" required="required"/></td>
  </tr>
  <tr>
    <td>个人邮箱</td>
    <td><input type="text" name="aEmail" required="required"/></td>
    <td>QQ</td>
    <td><input type="text" name="aQQ" required="required"/></td>
  </tr>
  <tr>
    <td>兴趣爱好</td>
    <td colspan="4"><input type="text" name="aFavor" style="width:100%;"/></td>
  </tr>
  <tr>
    <td>特长优势</td>
    <td colspan="4"><input type="text" name="aStrong" style="width:100%;"/></td>
  </tr>
  <tr>
    <td colspan="5">
    <p>1、<?php echo $freshResult['fQue_1']?></p>
    <textarea name="aAnser_1"></textarea>
    </td>
  </tr>
  <tr>
    <td colspan="5">
    <p>2、<?php echo $freshResult['fQue_2']?></p>
    <textarea name="aAnser_2"></textarea>
    </td>
  </tr>   
  <tr>
    <td colspan="5">
    <p>3、<?php echo $freshResult['fQue_3']?></p>
    <textarea name="aAnser_3"></textarea>
    </td>
  </tr>
</table>
<label><span>*</span>选择部门：</label>
<select name="department">
                <option value="0">任意部门</option>
            </select>
<input type="button" value="打印" class="button">
         <div style="clear:both;"></div> 
</form>
    <div style="clear:both;"></div>
</div>
<div style="clear:both;"></div>

<!--公式提醒框--> 
<div class="notice_box" id="notice_box" style="display:none;">
	<strong>本次纳新结束，是否将本次纳新结果进行公示？</strong>
    <p>注：公示为期一周，一周后将自动关闭公示；<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;公示结果仅本校内同学可见！</p>
    <div class="choose"><a class="button" href="../background/background_society/society_stopFresh.php?sId=<?php echo $sId?>&sName=<?php echo $freshResult['sName']?>&action=pub">公示</a><a class="button" href="../background/background_society/society_stopFresh.php?sId=<?php echo $sId?>&sName=<?php echo $freshResult['sName']?>&action=pri">不公示</a></div>
</div>

<!--删除提醒框--> 
<div class="notice_box" id="del_notice" style="display:none;">
	<strong>您确定要删除以上勾选的成员吗？</strong>
    <p>一旦删除该报名者将从当前报名列表中删除！</p>
    <div class="choose"><a href="javascript:cancel_del()" class="button">取消</a><a class="button" href="javascript:del_app_act()">删除</a></div>
</div>

<!--录用提醒框--> 
<div class="notice_box" id="employ_notice" style="display:none;">
	<strong>您确定要录用以上勾选的成员吗？</strong>
    <p>经录后用该报名者将从当前报名列表中删除！<br/>您可以在社团成员通讯录中查看！</p>
    <div class="choose"><a href="javascript:cancel_employ()" class="button">取消</a><a class="button" href="javascript:employ_act()">录用</a></div>
</div>



<!--侧边快捷操作面板--> 
<div class="icon_box">
	<a href=""><div id="icon_1"></div></a>
    <a href="personal_center.php"><div id="icon_2"></div></a>
    <a href="../background/background_person/login.php?action=logout"><div id="icon_3"></div></a>
</div>

<script src="js/jquery-1.11.1.js"></script>
<script src="js/main.js"></script>
<script src="js/fresh_detail.js" type="text/javascript"></script>

</body>
</html>