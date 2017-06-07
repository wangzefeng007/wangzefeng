<?php
/**
 * @desc  催收公司用户
 */
class MemberFirm
{

    /**
     * @desc 催收公司用户中心
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
        include template('MemberFirmIndex');
    }
    /**
     * @desc 我的信息
     */
    public function Information()
    {
        MService::IsNoLogin();
        include template('MemberFirmInformation');
    }
}