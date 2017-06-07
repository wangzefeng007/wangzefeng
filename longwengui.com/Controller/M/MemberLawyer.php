<?php

/**
 * @desc  律师个人
 */
class MemberLawyer
{

    /**
     * @desc 律师个人中心
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
        include template('MemberLawyerIndex');
    }
    /**
     * @desc 我的信息
     */
    public function Information()
    {
        MService::IsNoLogin();
        include template('MemberLawyerInformation');
    }
}