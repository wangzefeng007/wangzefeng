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
    /**
     * @desc 资产订单详情（已买到的）
     */
    public function OrderDetails(){
        MService::IsNoLogin();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $OrderNumber = trim($_GET['OrderNumber']);
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        if (!$OrderInfo){
            alertandback("不存在该订单！");
        }
        $NStatus = $MemberProductOrderModule->NStatus;
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberAreaModule = new MemberAreaModule();
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);//通过产品ID获取
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$OrderInfo['ProductID'].' and IsDefault=1');
        //发布人信息
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $User = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
        $UserInfo['Mobile'] = $User['Mobile'];
        if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['Area']= $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberPersonOrderDetails');
    }

}