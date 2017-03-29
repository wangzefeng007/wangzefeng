<?php
/**
 * @desc  会员登录注册
 */
class Member
{
    public function __construct() {
       // echo 1;exit;
       //$_SESSION ['UserID']=1;
    }
    /**
     * @desc 会员中心首页(我的主页)
     */
    public function Index()
    {
    }
    /**
     * @desc 登入页或登录操作
     */
    public function  Login(){
        //如果已登陆，直接跳转到会员中心
        if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
            if ($_SESSION['Identity'] <=2){
                header('Location:' . WEB_MAIN_URL.'/memberperson/');
            }elseif($_SESSION['Identity'] ==3){
                header('Location:' . WEB_MAIN_URL.'/memberfirm/');
            }elseif($_SESSION['Identity'] ==4){
                header('Location:' . WEB_MAIN_URL.'/memberlawyer/');
            }
        }
        include template('MemberLogin');
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
        $this->Login();
        $Title = '会员登录_注册';
        include template('MemberRegister');
    }
    /**
     * @desc  会员注册完善资料
     */
    public function RegisterTwo()
    {
        MemberService::IsLogin();
        $Title = '会员注册完善资料';
        include template('MemberRegisterTwo');
    }
    /**
     * @desc  找回密码
     */
    public function FindPasswd()
    {
        MemberService::IsLogin();
        $Title = '会员登录_找回密码';
        include template('MemberFindPasswd');
    }
    /**
     * @desc 更改/绑定手机
     */
    public function ChangeMobile()
    {
        MemberService::IsLogin();
        $Title = '会员_绑定手机';
        include template('MemberChangeMobile');
    }
}