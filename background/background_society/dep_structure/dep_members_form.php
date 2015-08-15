<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../excel/UpLoad_Excel.php');
require_once('../../message/create_sysMsg.php');
session_start();
$sId=$_POST['sId'];
$sSchool=$_POST['sSchool'];
//上传excel文件到服务器模块
$file = $_FILES['members']['name'];
if($file){
	$msg = uploadFile($sId,$file,$sSchool);
}
//手动添加模块
//获取表单值
$username=$_POST['name'];
$telnumber=$_POST['telnumber'];
if($username[0]){
for($i=0;$i<count($username);$i++){
	$res=mysql_fetch_array(mysql_query("select uId from user where userTel='$telnumber[$i]'"));
	if(!$res){
		mysql_query("insert into pre_user(userName,userTel,userSchool) values('$username[$i]','$telnumber[$i]','$sSchool')");
		$pid = mysql_insert_id();
		mysql_query("insert into preuser_society_relation(pid,sid,isDepManager,position) values('$pid','$sId','0','成员')");
	}else{
		$uId=$res['uId'];
		$data=array();
		$data['sId']=$sId;
		$data['depName']='（未分配部门）';
		$data['position']='成员';
		send_sysMsg($uId,$data,'joinSociety');
		mysql_query("insert into user_society_relation(userId,societyId,isManage,position) values('$uId','$sId','0','成员')");
	}
}
}
if(!($file || $username[0])){
		echo "<script>alert('请添加社团成员！');</script>";
	}
?>
