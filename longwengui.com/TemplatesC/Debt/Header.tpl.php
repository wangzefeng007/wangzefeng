<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from Header.htm on 2017-03-13 17:21:12
*/
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="描述">
    <meta name="keywords" content="催收平台,催收系统，债务清算,债务追讨,欠款催收,债务案源">
    <title>隆文贵</title>
    <link rel="stylesheet" href="<?php echo CssURL; ?>/debt/common.css">

</head>
<body>
<div class="top">
    <div class="wrap">
        <span>您好 , 欢迎访问 隆文贵 ！</span>
        <span>服务热线 : 13960658585</span>
        <span onclick="go('./login.html')">登录</span>
        <span onclick="go('./reg.html')">注册</span>
    </div>
</div>
<div class="header">
    <div class="wrap">
        <a href="./index.html"><img src="/Uploads/Debt/imgs/logo.png" alt=""></a>
        <div class="nav-wrap">
            <a href="<?php echo WEB_MAIN_URL; ?>"><li  <?php if($Nav=='index') { ?>class="nav-active"<?php } ?>>首页</li></a>
            <a href="<?php echo WEB_MAIN_URL; ?>/debtlists/"><li <?php if($Nav=='debtlists') { ?>class="nav-active"<?php } ?>>债务催收</li></a>
            <a href="javascript:void (0)"><li>债权转让</li></a>
            <a href="/debt/reword.html"><li>线索悬赏</li></a>
            <a href="/debt/solver.html"><li>寻找处置方</li></a>
            <a href="/debt/debtorSearch.html"><li>查询老赖</li></a>
        </div>
    </div>
</div>