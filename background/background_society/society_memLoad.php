<?php
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$sId=$_GET['sId'];
$depName=$_GET['depName'];
$i=$_POST['i'];
//获取用户社团关系信息
$user_society_r=mysql_query("select userId,isManage,depBelong,position from user_society_relation where societyId='$sId' and depBelong='$depName' limit ".$i.",2");
if($user_society_r && mysql_num_rows($user_society_r)){
	    while($row = mysql_fetch_assoc($user_society_r)){			
			$user_r[]=$row;
			$uInfo[]=mysql_fetch_assoc(mysql_query("select userFace from user where uId='$row[userId]'"));
			$ueInfo[]=mysql_fetch_assoc(mysql_query("select userName,userTel,userSex,userClass from userextrainfo where uId='$row[userId]'"));
		}
}
$k=0;
if($user_r){
	foreach($user_r as $value_2){
		if($depName=='0'){
			$depName='未分配';
		}
		echo "<li>
                <span><input type='checkbox' id='".$value_2['userId']."' value='".$value_2['userId']."' name='member_".$depName."[]'/></span><span><img src='../".$uInfo[$k]['userFace']."'/>".$ueInfo[$k]['userName']."".$ueInfo[$k]['userSex']."</span><span>".$ueInfo[$k]['userClass']."</span><span>".$ueInfo[$k]['userTel']."</span><span>".$depName."</span><span class='limit'>".$value_2['position']."</span><span class='cap'><a href='javascript:void(0)' class='table_b'>删除</a><a href='javascript:void(0)' class='table_c'>调换部门</a><a href='javascript:void(0)' class='table_d'>发送通知</a></span>                            
                </li>
		";
		$k++;
		$i++;
	}
	echo '@'.$i;
}
?>