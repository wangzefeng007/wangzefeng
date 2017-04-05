<?php
/**
 * @desc  会员登录注册
 */
class Member
{
    public function __construct() {
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
        $Title = '会员登录';
        //如果已登陆，直接跳转到会员中心
        MemberService::IsLogin();
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
        //如果已登陆，直接跳转到会员中心
        MemberService::IsLogin();
        $Title = '注册会员';
        include template('MemberRegister');
    }
    /**
     * @desc  会员注册完善资料(加入催收行业)
     */
    public function RegisterTwo()
    {
        $type = intval($_GET['T']);
        $Title = '会员注册完善资料';
        include template('MemberRegisterTwo');
    }
    /**
     * @desc  会员注册完善资料(加入发布债务)
     */
    public function RegisterThree()
    {
        $Title = '会员注册完善资料';
        include template('MemberRegisterThree');
    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }
    }
    /**
     * @desc  找回密码
     */
    public function FindPasswd()
    {
        $Title = '会员登录_找回密码';
        include template('MemberFindPasswd');
    }
    /**
     * @desc 更改/绑定手机
     */
    public function ChangeMobile()
    {
        $this->IsLogin();
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $Nav = 'changemobile';
        $Title = '会员_更改绑定手机';
        include template('MemberChangeMobile');
    }
    /**
     * @desc 修改密码
     */
    public function EditPassWord(){
        $Title = '会员-修改密码';
        $this->IsLogin();
        $Nav = 'editpassword';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberEditPassWord');
    }
    /**
     * @desc 系统消息
     */
    public function SystemMessage(){
        $Title = '会员-系统消息';
        $this->IsLogin();
        $Nav = 'systemmessage';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberSystemMessage');
    }
    /**
     * @desc 投诉建议
     */
    public function Advice(){
        $Title = '会员-投诉建议';
        $this->IsLogin();
        $Nav = 'advice';
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        if ($_POST['advice']){
            var_dump($_POST);exit;
            $Data['Content'] = trim($_POST['advice']);
            $Data['UserID'] = $_SESSION['UserID'];
            $Data['AddTime'] = time();
            $Insert = $MemberComplaintAdviceModule->InsertInfo($Data);
            if ($Insert){
                alertandback("提交成功");
            }else{
                alertandback("提交失败");
            }
        }
        include template('MemberAdvice');
    }
    /**
     * @desc 注册会员用户中心选择
     */
    public function Center(){
        $Title = '会员-用户中心';
        $this->IsLogin();
        $Nav = 'center';
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=0)
                alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberCenter');
    }

}