<?php
/**
 * @desc 催客用户
 */
class MemberPushGuest
{
    /**
     * @desc 催客用户中心
     */
    public function Index()
    {
        MService::IsNoLogin();
        $Nav ='member';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberPushGuestIndex');
    }
    /**
     * @desc 我的信息
     */
    public function Information()
    {
        MService::IsNoLogin();
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
        include template('MemberPushGuestInformation');
    }
    /**
     * @desc 编辑信息
     */
    public function EditInfo(){
        MService::IsNoLogin();
        include template('MemberPushGuestEditInfo');
    }
    /**
     * @desc 债权管理
     */
    public function DebtManagement(){
        MService::IsNoLogin();
        include template('MemberPushGuestDebtManagement');
    }

}