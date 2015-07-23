<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$actId=$_GET['actId'];
$sId=$_GET['sId'];
mysql_query("delete from society_act_closed where actId='$actId'");
mysql_query("delete from act_user_relation where actId='$actId'");
echo "<script>window.location.href='../../../front/activity.php?sId=$sId'</script>";
?>