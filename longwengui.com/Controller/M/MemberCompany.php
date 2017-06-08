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
        $Nav ='member';
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
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $UserInfo['PublicAgent'] = json_decode($UserInfo['PublicAgent'],true);
        if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['Area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberCompanyInformation');
    }
    /**
     * @desc 编辑信息
     */
    public function EditInfo(){
        include template('MemberCompanyEditInfo');
    }
    /**
     * @desc 债权管理
     */
    public function DebtManagement(){
        MService::IsNoLogin();
        include template('MemberCompanyDebtManagement');
    }
    /**
     * @desc 我的关注
     */
    public function Focus(){
        include template('MemberCompanyFocus');
    }
}