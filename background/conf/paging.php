<?php
function paging($page,$total){
//显示页数
$showPage=5;
$pageSize=10;
////总条数
//$total_sql="select count(*) from page";
//$total_result=mysql_fetch_array(mysql_query($total_sql));
//$total=$total_result[0];
//总页数
$total_pages=ceil($total/$pageSize);
//分页条
$page_banner="<div class='page'>";
//计算偏移量
$pageoffset=($showPage-1)/2;
if($page>1){
	$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=1'>首页</a>";
	$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".($page-1)."'><上一页</a>";	
}else{
	$page_banner.="<span class='disable'>首页</span>";
	$page_banner.="<span class='disable'><上一页</span>";
}
$start=1;
$end=$total_pages;
if($total_pages>$showPage){
	if($page>$pageoffset+1){
		$page_banner.="...";
	}
	if($page>$pageoffset){
		$start=$page-$pageoffset;
		$end=$total_pages>$page+$pageoffset?$page+$pageoffset:$total_pages;
	}else{
		$start=1;
		$end=$total_pages>$showPage?$showPage:$total_pages;
	}
	if($page+$pageoffset>$total_pages){
		$start=$start-($page+$pageoffset-$end);
	}
}
for($i=$start;$i<=$end;$i++){
	if($page==$i){
		$page_banner.="<span class='current'>{$i}</span>";
	}else{
		$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".$i."'>{$i}</a>";
	}
}
//尾部省略
if($total_pages>$showPage&&$total_pages>$page+$pageoffset){
	$page_banner.="...";
}
if($page<$total_pages){
	$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".($page+1)."'>下一页></a>";
	$page_banner.="<a href='".$_SERVER['PHP_SELF']."?p=".($total_pages)."'>尾页</a>";
}else{
	$page_banner.="<span class='disable'>下一页></span>";
	$page_banner.="<span class='disable'>尾页</span>";
}
$page_banner.="共{$total_pages}页,";
$page_banner.="<form action='activity_cards.php' method='GET'>";
$page_banner.="到第<input type='text' size='2' name='p'/>";
$page_banner.="<input type='submit' value='确定'/>";
$page_banner.="</form></div>";
echo  $page_banner;	
	
}


?>