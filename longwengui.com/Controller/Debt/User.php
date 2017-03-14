<?php
/**
 * @desc  普通用户会员中心
 */
class User
{
    public function __construct() {
        echo 1;exit;
        $_SESSION ['UserID']=1;
    }
    /**
     * @desc 会员中心首页(我的主页)
     */
    public function Index()
    {
        $Title = '会员中心首页';
    }
    /**
     * @desc 登入页或登录操作
     */
    public function  Login(){

    }
    /**
     * @desc  退出登录
     */
    public function SignOut()
    {
        unset($_SESSION);
        setcookie("UserID", '', time() - 1, "/", WEB_HOST_URL);
        setcookie("Account", '', time() - 1, "/", WEB_HOST_URL);
        setcookie("session_id", session_id(), time() - 1, "/", WEB_HOST_URL);
        session_destroy();
        header("location:" . WEB_MAIN_URL);
    }
    /**
     * @desc  注册
     */
    public function Register()
    {
        $Title = '会员登录_注册';
    }
    /**
     * @desc  找回密码
     */
    public function RetrievePassword()
    {
        UserService::IsLogin();
        $Title = '会员登录_找回密码';
    }
    /**
     * @desc 更改/绑定手机
     */
    public function ChangeMobile()
    {
        $Title = '会员登录_绑定手机';
    }
    /**
     * @desc  发布债务
     */
    public function  DebtRelease(){
        UserService::IsLogin();
        include template('DebtRelease');
    }
}