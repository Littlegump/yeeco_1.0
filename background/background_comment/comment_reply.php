<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$action=$_GET['action'];
if($action=='insert'){
	$uId=$_POST['userId'];
	$uName=$_POST['userName'];
	$uFace=$_POST['userFace'];
	$cBody=$_POST['comment'];
	$cTime=$_POST['date'];
	$nId=$_POST['nId'];
	$ccId=$_POST['ccId'];
	$ccName=$_POST['ccName'];
	mysql_query("insert into comment_form(uId,uName,uFace,cBody,cTime,nId,ccId,ccName) values('$uId','$uName','$uFace','$cBody','$cTime','$nId','$ccId','$ccName')");
	exit;
}
if($action=='delete'){
	$cId=$_POST['cId'];
	mysql_query("delete from comment_form where cId='$cId'");
}

?>