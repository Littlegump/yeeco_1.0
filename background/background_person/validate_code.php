<?php
function creatTestCode($userTel){
	$arr=array();
	while(count($arr)<6)
	{
	  $arr[]=rand(0,9);
	  $arr=array_unique($arr);
	}
	$testCode = implode("",$arr);
	//在这里将验证码发给运营商
	
	return $testCode;
}

?>