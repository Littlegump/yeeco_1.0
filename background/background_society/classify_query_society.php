<?php 
/**
*社团搜索--模糊查询
*/
error_reporting(E_ALL & ~E_NOTICE);
require_once('../conf/connect.php');
$action=$_GET['action'];
//搜索按钮查找社团
if($action=='search'){
	$school=$_GET['school'];
	$words=$_POST['words'];
	$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sName like '%$words%' and sSchool='$school'");
	if($query && mysql_num_rows($query)){
    	while($row = mysql_fetch_assoc($query)){
			$sInfo[]=$row;
		}			
	}
	if($sInfo){
		foreach($sInfo as $value){
			echo "<li class='course-one'>
                                <a href='society_visitor.php?sId=".$value['sId']."'>
                                    <div class='course-list-img'>
                                        <img src='".substr($value['sImg'],3)."'/>
                                    </div>
                                    <h5>
                                        <span>".$value['sName']."</span>
                                    </h5>
                                    <div class='tips'>
                                        <p class='des'>".$value['sDesc']."</p>
                                        <span class='type'>".$value['sCate']."</span>
  	                           <span class='member_num'>现有成员<strong>".$value['sNum']."</strong>人</span>
                                    </div>
                                </a>
                          </li>";	
		}	
	}
	echo '@'.count($sInfo);
	exit;
}
//分类查找
if($action=='precise_search'){
	$cert=$_POST['cert'];
	$cate=$_POST['cate'];
	$status=$_POST['status'];
	$school=$_POST['school'];
	if($cert=='全部' && $cate=='全部'){
		if($status=='最热'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sSchool='$school' order by sNum DESC");
		}
		if($status=='最新'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sSchool='$school' order by regTime DESC");
		}
	}else if($cert=='全部' && $cate!='全部'){
		if($status=='最热'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sCate like '%$cate%' and sSchool='$school' order by sNum DESC");
		}
		if($status=='最新'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sCate like '%$cate%' and sSchool='$school' order by regTime DESC");
		}
	}else if($cert!='全部' && $cate=='全部'){
		$cert=substr($cert,0,3);
		if($status=='最热'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where isCert like '%$cert%' and sSchool='$school' order by sNum DESC");
		}
		if($status=='最新'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where isCert like '%$cert%' and sSchool='$school' order by regTime DESC");
		}
	}else{
		$cert=substr($cert,0,3);
		if($status=='最热'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sCate like '%$cate%' and isCert like '%$cert%' and sSchool='$school' order by sNum DESC");
		}
		if($status=='最新'){
			$query=mysql_query("select sId,sName,sCate,sDesc,sNum,sImg from society where sCate like '%$cate%' and isCert like '%$cert%' and sSchool='$school' order by regTime DESC");
		}
	}
	if($query && mysql_num_rows($query)){
		while($row = mysql_fetch_assoc($query)){
			$sInfo[]=$row;
		}			
	}
	if($sInfo){
		foreach($sInfo as $value){
			echo "<li class='course-one'>
                                <a href='society_visitor.php?sId=".$value['sId']."'>
                                    <div class='course-list-img'>
                                        <img src='".substr($value['sImg'],3)."'/>
                                    </div>
                                    <h5>
                                        <span>".$value['sName']."</span>
                                    </h5>
                                    <div class='tips'>
                                        <p class='des'>".$value['sDesc']."</p>
                                        <span class='type'>".$value['sCate']."</span>
  	                           <span class='member_num'>现有成员<strong>".$value['sNum']."</strong>人</span>
                                    </div>
                                </a>
                          </li>";	
		}	
	}
	echo '@'.count($sInfo);
	exit;
}
?>