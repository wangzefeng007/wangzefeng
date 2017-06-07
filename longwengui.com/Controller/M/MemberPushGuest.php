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
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberPushGuestInformation');
    }

}