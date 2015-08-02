<?php
/**
*活动搜索--模糊查询
*/
error_reporting(E_ALL & ~E_NOTICE);
require_once('../../conf/connect.php');
$action=$_GET['action'];
//$action='precise_search';
if($action=='search'){
	$school=$_GET['school'];
	$words=$_POST['words'];
	$query=mysql_query("select * from society_act_open where actName like '%$words%' and actSchool='$school'");
	if($query && mysql_num_rows($query)){
    	while($row = mysql_fetch_assoc($query)){
			$actInfo[]=$row;
		}			
	}
	if($actInfo){
		foreach($actInfo as $value){
			//查找该活动所属的社团
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$value[sId]'"));
			echo "<ul>
                    <li class='course-one'>
                      <a href='activity_visitor.php?actId=".$value['actId']."'>
                        <div class='course-list-img'>
                        	<img src='".substr($value['actImg'],3)."'/>
                        </div>
                        <h5>
                            <span>".$value['actName']."</span>
                        </h5>
                        <div class='tips'>
                        	<p><label style='color:#999;'>社团：</label><span style='color:#333;'>".$sName['sName']."</span></p>
                        	<p><label>类型：</label><span>".$value['actType']."/".$value['isApply']."/".$value['actRange']."</span></p>
                      		<p><label>时间：</label><span style='color:#333;'>".$value['actBeginDate']."&nbsp;".$value['actBeginTime']."&nbsp;&nbsp;~&nbsp;&nbsp;".$value['actEndDate']."&nbsp;".$value['actEndTime']."</span></p>
                      		<p><label>地点：</label><span style='color:#333;'>".$value['actPlace']."</span></p>
                      		<p><label>简介：</label><span class='des'>".$value['actDesc']."</span></p>
                            <p class='number'><strong>.".$value['actNum']."</strong>人报名&nbsp;<strong>".$value['actFocusNum']."</strong>人关注</p>
                       	</div>
                      </a>
                    </li>
				  </ul>";
		}
	}
	echo '@'.count($actInfo);
	exit;
}
//分类查找
if($action=='precise_search'){
	$going=$_POST['going'];
	$type=$_POST['type'];
	$status=$_POST['status'];
	$school=$_POST['school'];
	//echo $going."+".$type."+".$status;

	//$going='全部';$type='全部';$status='最新';
	//$school='西安邮电大学';
	if($going=='全部' && $type=='全部'){
		if($status=='最新'){
			$query=mysql_query("select * from society_act_open union
select * from society_act_closed where actSchool='$school' order by setTime desc");
		}
		if($status=='最热'){
			$query=mysql_query("select * from society_act_closed union
select * from society_act_open where actSchool='$school' order by actNum desc");
		}
	}else if($going=='全部' && $type!='全部'){
		if($status=='最新'){
			$query=mysql_query("select * from society_act_closed union
select * from society_act_open where actSchool='$school' and actType like '%$type%' order by setTime desc");
		}
		if($status=='最热'){
			$query=mysql_query("select * from society_act_closed union
select * from society_act_open where actSchool='$school' and actType like '%$type%' order by actNum desc");
		}
	}else if($going=='正在进行' && $type=='全部'){
		if($status=='最新'){
			$query=mysql_query("select * from society_act_open where actSchool='$school' order by setTime desc");
		}
		if($status=='最热'){
			$query=mysql_query("select * from society_act_open where actSchool='$school' order by actNum desc");
		}
	}else if($going=='正在进行' && $type!='全部'){
		if($status=='最新'){
			$query=mysql_query("select * from society_act_open where actSchool='$school' and actType like '%$type%' order by setTime desc");
		}
		if($status=='最热'){
			$query=mysql_query("select * from society_act_open where actSchool='$school' and actType like '%$type%' order by actNum desc");
		}
	}else if($going=='已经结束' && $type=='全部'){
		if($status=='最新'){
			$query=mysql_query("select * from society_act_closed where actSchool='$school' order by setTime desc");
		}
		if($status=='最热'){
			$query=mysql_query("select * from society_act_closed where actSchool='$school' order by actNum desc");
		}
	}else if($going=='已经结束' && $type!='全部'){
		if($status=='最新'){
			$query=mysql_query("select * from society_act_closed where actSchool='$school' and actType like '%$type%' order by setTime desc");
		}
		if($status=='最热'){
			$query=mysql_query("select * from society_act_closed where actSchool='$school' and actType like '%$type%' order by actNum desc");
		}
	}
	if($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query)){
			$actInfo[]=$row;
		}			
	}
	if($actInfo){
		foreach($actInfo as $value){
			//查找该活动所属的社团
			$sName=mysql_fetch_assoc(mysql_query("select sName from society where sId='$value[sId]'"));
			echo "<ul>
                    <li class='course-one'>
                      <a href='activity_visitor.php?actId=".$value['actId']."'>
                        <div class='course-list-img'>
                        	<img src='".substr($value['actImg'],3)."'/>
                        </div>
                        <h5>
                            <span>".$value['actName']."</span>
                        </h5>
                        <div class='tips'>
                        	<p><label style='color:#999;'>社团：</label><span style='color:#333;'>".$sName['sName']."</span></p>
                        	<p><label>类型：</label><span>".$value['actType']."/".$value['isApply']."/".$value['actRange']."</span></p>
                      		<p><label>时间：</label><span style='color:#333;'>".$value['actBeginDate']."&nbsp;".$value['actBeginTime']."&nbsp;&nbsp;~&nbsp;&nbsp;".$value['actEndDate']."&nbsp;".$value['actEndTime']."</span></p>
                      		<p><label>地点：</label><span style='color:#333;'>".$value['actPlace']."</span></p>
                      		<p><label>简介：</label><span class='des'>".$value['actDesc']."</span></p>
                            <p class='number'><strong>".$value['actNum']."</strong>人报名&nbsp;<strong>".$value['actFocusNum']."</strong>人关注</p>
                       	</div>
                      </a>
                    </li>
				  </ul>";	
		}	
	}
	echo '@'.count($actInfo);
	exit;
}
?>