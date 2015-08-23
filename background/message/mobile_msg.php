<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
require_once('sendOnce.php');
//获取发送对象用户ID
$toId=$_POST['toId'];
$message=$_POST['m_message'];
//处理toId,字符串转换成数组
$massMsgTo = explode(",",$toId);
foreach($massMsgTo as $value){
	$res=mysql_fetch_assoc(mysql_query("select userTel from user where uId='$value' limit 1"));
	$userTel=$res['userTel'].',';
}
$userTel=substr($userTel,0,strlen($userTel)-1);
//发送短信函数
$c=$message;
$m=$userTel;
sendSMS($url,$ac,$authkey,$cgid,$m,$c,$csid,$t);
?>