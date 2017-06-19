<?php
/**
 * @desc 个人用户
 */
class MemberPerson
{
    /**
     * @desc 个人用户中心
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
        include template('MemberPersonIndex');
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
        include template('MemberPersonInformation');
    }
    /**
     * @desc 编辑信息
     */
    public function EditInfo(){
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
            $UserInfo['province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['city'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberPersonEditInfo');
    }

    /**
     * @desc 债权管理
     */
    public function DebtManagement(){
        MService::IsNoLogin();
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $NStatus = $MemberDebtInfoModule->NStatus;
        $Data['Data'] = $MemberDebtInfoModule->GetInfoByWhere(' and UserID = '.$_SESSION['UserID'],true);
        foreach ($Data['Data'] as $key=>$value){
            $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(' and DebtID = '.$value['DebtID']);
            $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
            $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
            if ($DebtorsInfo['Province'])
                $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
            if ($DebtorsInfo['City'])
                $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
            if ($DebtorsInfo['Area'])
                $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
        }
        include template('MemberPersonDebtManagement');
    }
    /**
     * @desc 我的资产
     */
    public function Asset(){
        MService::IsNoLogin();
        include template('MemberPersonAsset');
    }
    public function OrderDetails(){
        MService::IsNoLogin();
        include template('MemberPersonOrderDetails');
    }
    /**
     * @desc 关注/收藏
     */
    public function Focus(){
        MService::IsNoLogin();
        include template('MemberPersonFocus');
    }
}