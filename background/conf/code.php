<?php
error_reporting(E_ALL & ~E_NOTICE);
//����Ψһ�ַ������ļ���
function QRCode($page,$Id,$QRfolder){
	$f1=substr($QRfolder,3);
	include $f1.'phpqrcode/qrlib.php';
	include $f1.'phpqrcode/qrconfig.php';
	if($page=='mobileFront/M_societyVisitor.php'){
		$value = 'http://192.168.1.105/yeeco_1.0/front/'.$page.'?sId='.$Id; //��ά������ 
	}
	if($page=='activity_detail.php'){
		$value = 'http://192.168.1.105/yeeco_1.0/front/'.$page.'?actId='.$Id;
	}
	$errorCorrectionLevel = 'L';//�ݴ����� 
	$matrixPointSize = 6;//����ͼƬ��С 
	//���ɶ�ά��ͼƬ 
	$imgname=getUniName();
	$qrpath= $QRfolder.'image/user_image/society/qrcode/'.$imgname.'.png';
	QRcode::png($value,$qrpath, $errorCorrectionLevel, $matrixPointSize, 2); 
	return $qrpath;
	//$QR = 'qrcode.png';//�Ѿ����ɵ�ԭʼ��ά��ͼ 
}
?>