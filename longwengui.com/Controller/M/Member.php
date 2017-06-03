<?php
/**
 * @desc  会员中心
 */
class Member
{
    public function __construct() {
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
        header("location:" . WEB_M_URL);
    }
    /**
     * @desc 登入页或登录操作
     */
    public function  Login(){
        include template('MemberLogin');
    }
    /**
     * @desc  注册
     */
    public function Register()
    {
        include template('MemberRegisterOne');
    }
    /**
     * @desc 用户选择会员类型
     */
    public function ChooseType(){
        $Title = '会员-选择类型';
        include template('MemberChooseType');
    }

    /**
     * @desc  会员注册完善资料(企业或者个人)
     */
    public function RegisterTwo(){
        include template('MemberRegisterTwo');
    }
    /**
     * @desc  会员注册完善资料(催收公司和催客)
     */
    public function RegisterThree(){
        include template('MemberRegisterThree');
    }
    /**
     * @desc  会员注册完善资料(律师事务所和律师)
     */
    public function RegisterFour(){
        include template('MemberRegisterFour');
    }
}