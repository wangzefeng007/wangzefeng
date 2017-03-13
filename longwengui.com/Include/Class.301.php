<?php
/**
 * @desc  301跳转
 */

/**
 * @desc  讀取301.txt數據整合成數組
 */
/*$handler = fopen('301.txt','r'); //打开文件
while(!feof($handler)){
	$m[] = fgets($handler,4096); //fgets逐行读取，4096最大长度，默认为1024
}
fclose($handler); //关闭文件
$info = array();
foreach($m as $val){
	$a = explode("|",$val);
	$k = str_replace('http://','',$a[0]);
	$v = str_replace('http://','',$a[1]);
	$info[$k] = $v;
}
$open=fopen("301.php","w+" );
fwrite($open,var_export($info,true));
fclose($open);
exit;*/

include SYSTEM_ROOTPATH.'/Include/Data/Data301.php';

$the_host = $_SERVER['HTTP_HOST'];//取得当前域名
$the_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面部分

$OldUrl = $the_host.$the_url;
if($Array_301[$OldUrl]){
	header('HTTP/1.1 301 Moved Permanently');//发出301头部
	header('Location:http://'.$Array_301[$OldUrl]);//跳转到带www的网址
	exit;
}


?>