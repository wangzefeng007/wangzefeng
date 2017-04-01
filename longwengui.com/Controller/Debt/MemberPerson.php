<?php
/**
 * @desc  个人会员中心
 */
class MemberPerson
{
    public function __construct() {
    }
    /**
     * @desc  判断是否登录并返回登录页面
     */

    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }
    }
    /**
     * @desc 个人会员中心(个人信息)
     */
    public function Index()
    {
        $this->IsLogin();
        $Nav='memberperson';
        if ($_SESSION['Identity']!=0 && $_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['Area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        $Title = '会员中心首页';
        include template('MemberPersonIndex');
    }
    /**
     * @desc 催收公司会员中心(完善个人资料)
     */
    public function EditInfo()
    {
        $this->IsLogin();
        $Nav='memberperson';
        if ($_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
            alertandback("访问被拒绝");
        }
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        if ($UserInfo['Province'])
        $UserInfo['province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
        $UserInfo['city'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
        $UserInfo['area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberPersonEditInfo');
    }
}