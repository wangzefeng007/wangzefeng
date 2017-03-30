<?php
/**
 * @desc  个人会员中心
 */
class MemberPerson
{
    public function __construct() {

    }
    /**
     * @desc 个人会员中心(个人信息)
     */
    public function Index()
    {

        MemberService::IsLogin();
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $Title = '会员中心首页';
        include template('MemberPersonIndex');
    }
    /**
     * @desc 催收公司会员中心(完善个人资料)
     */
    public function PerfectInfo()
    {
        include template('MemberPersonPerfectInfo');
    }
}