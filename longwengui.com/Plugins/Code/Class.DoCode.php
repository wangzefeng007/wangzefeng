<?php
session_start ();
//同步SESSIONID
setcookie ("session_id",session_id(),time()+3600,"/","longwengui.com" );
include './Class.Code.php'; //先把类包含进来，实际路径根据实际情况进行修改。
$_vc = new ValidateCode (); //实例化一个对象
$_vc->doimg ();
$_SESSION ['authnum_session'] = $_vc->getCode ();

//验证码保存到SESSION中
