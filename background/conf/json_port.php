<?php
class Response{
	/**
	*按json方式输出通信数据
	*@param integer $code状态码
	*@param string $message提示信息
	*@param array $data 数据
	*return
	**/
	public static function json($code,$message = '',$data = array()){
		if(!is_numeric($code)){
			return '';
		}
		
		$result = array(
			'code' => $code,
			'message' => $message,
			'data' => $data
		);
		
		echo decodeUnicode(json_encode($result));
		exit;
	}
}

function decodeUnicode($str)
{
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        create_function(
            '$matches',
            'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
        ),
        $str);
}

?>