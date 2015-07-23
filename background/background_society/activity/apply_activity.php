<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$actId=$_GET['actId'];
$uId=$_GET['uId'];
//插入活动-用户关联关系表
mysql_query("insert into act_user_relation(uId,actId) values('$uId','$actId')");

?>