
<?php
function do_post_request($url,$data){
	 $flag = 0;
	 $post = '';
	 $errno = '';
	 $errstr = '';
	 //瑕乸ost鐨勬暟鎹�
	$argv = $data;
	//鏋勯€犺post鐨勫瓧绗︿覆
	foreach ($argv as $key=>$value) {
		if ($flag!=0) {
			$post .= "&";
			$flag = 1;
		}
		$post.= $key."="; $post.= urlencode($value);
		$flag = 1;
		}
		$length = strlen($post);
		 //鍒涘缓socket杩炴帴
	   $fp = fsockopen("localhost",80,$errno,$errstr,10) or exit($errstr."--->".$errno);
		//鏋勯€爌ost璇锋眰鐨勫ご
		$header  = "POST ".$url." HTTP/1.1\r\n";
		$header .= "Host:127.0.0.1\r\n";
		$header .= "Referer: /test/test.php\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: ".$length."\r\n";
		$header .= "Connection: Close\r\n\r\n";
		//娣诲姞post鐨勫瓧绗︿覆
		$header .= $post."\r\n";
		
	
		//鍙戦€乸ost鐨勬暟鎹�
	   fputs($fp,$header);
		$inheader = 1;
		while (!feof($fp)) {
			$line = fgets($fp,1024); //鍘婚櫎璇锋眰鍖呯殑澶村彧鏄剧ず椤甸潰鐨勮繑鍥炴暟鎹�
			if ($inheader && ($line == "\n" || $line == "\r\n")) {
				 $inheader = 0;
			}
			if ($inheader == 0) {
				$temp =$line;
			}
		}
	
	fclose($fp);
	if($temp){
		return $temp;
	}	
}
?>


