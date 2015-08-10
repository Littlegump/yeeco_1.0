<?php 
error_reporting(E_ALL & ~E_NOTICE);
header('Cache-Control: no-cache');
require_once('../conf/connect.php');
header('Content-Type: text/event-stream');
////查询消息
$msgToId=$_GET['msgFromId'];
$msgFromId=$_GET['msgToId'];
$msg=mysql_fetch_assoc(mysql_query("select msgId,msgBody,msgTime from message where msgToId='$msgToId' and msgFromId='$msgFromId' and msgIsRead='0' limit 1"));
if($msg){
	$data['state'] = "501";	
	$data['message'] = array(
//		'msgToId' => $msgToId,
//		'msgFromId' => $msgFromId,
		'msgTime' => $msg['msgTime'],
		'msgBody' => $msg['msgBody']
	);
	$data=json_encode($data);
	echo "data: {$data}\n\n";
	flush();
	mysql_query("update message set msgIsRead=1 where msgId='$msg[msgId]'");	
}
//sleep(2);
?>