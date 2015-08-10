<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$type=$_GET['type'];
$fromId=$_POST['userId'];
$toId=$_POST['toId'];
$message=$_POST['message'];
$msgTime = time();
mysql_query("insert into message(msgToId,msgFromId,msgBody,msgTime) values('$toId','$fromId','$message','$msgTime')");
echo "insert into message(msgToId,msgFromId,msgBody,msgTime) values('$toId','$fromId','$message','$msgTime')";
?>