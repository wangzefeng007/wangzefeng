<?php
/**
 * @desc  企业用户
 */
class MemberCompany
{
    /**
     * @desc 企业会员中心
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
        include template('MemberCompanyIndex');
    }
    /**
     * @desc 我的信息
     */
    public function Information()
    {
        MService::IsNoLogin();
        include template('MemberCompanyInformation');
    }
}