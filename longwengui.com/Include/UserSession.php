<?php
if($_COOKIE['session_id']!=''){
    session_id($_COOKIE['session_id']);
}
session_start();
//post函数
function curl_postsend_usersession($url, $data = array()) {
	$ch = curl_init ();
	//设置选项，包括URL
	curl_setopt ( $ch, CURLOPT_URL, "$url" );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 5 ); //定义超时3秒钟  
	// POST数据
	curl_setopt ( $ch, CURLOPT_POST, 1 );
	// POST参数
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, http_build_query ( $data ) );
	//执行并获取url地址的内容
	$output = curl_exec ( $ch );
	$errorCode = curl_errno ( $ch );
	//释放curl句柄
	curl_close ( $ch );
	if (0 !== $errorCode) {
		return false;
	}
	return $output;
}


//获取登录信息
if($_SESSION['UserID'] && $_SESSION['Account']){
    if(!isset($_SESSION['Level'])){
        $json_data=curl_postsend_usersession(WEB_MEMBER_URL.'/userajax.html',array('Intention'=>'GetSession','ID'=>$_SESSION['UserID'],'Account'=>$_SESSION['Account']));
        $_SESSION=json_decode($json_data,true);
    }
    
}
