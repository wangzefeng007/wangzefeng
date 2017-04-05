<?php
/**
 * @desc  催收公司会员中心
 */
class MemberFirm
{
    public function __construct() {
    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=3)
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
    }
    /**
     * @desc 催收公司会员中心(个人信息)
     */
    public function Index()
    {
        $Nav='memberfirm';
        $this->IsLogin();
        $Title = '会员中心首页';
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
        include template('MemberFirmIndex');
    }
    /**
     * @desc 催收公司会员中心(完善个人资料)
     */
    public function EditInfo()
    {
        $Title = '会员中心-完善个人资料';
        $Nav='memberfirm';
        $this->IsLogin();
        //会员基本信息
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
        include template('MemberFirmEditInfo');
    }

    /**
     * @desc 催收公司主动申请的债权列表
     */
    public function  ApplyDebtOrder(){
        $Nav ='applydebtorder';
        $Title = '会员中心-申请的债权';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberFirmApplyDebtOrder');
    }
    /**
     * @desc 催收公司债权接单
     */
    public function CreditOrder(){
        $Nav='creditorder';
        $Title = '会员中心-债权接单';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberFirmCreditOrder');
    }
    /**
     * @desc 催收公司债权接单的要求方案列表
     */
    public function DemandList(){
        $Nav='creditorder';
        $Title = '会员中心-要求方案';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberSetCollectionModule = new MemberSetCollectionModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere ='';
        $Rscount = $MemberSetCollectionModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=15;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberSetCollectionModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberFirmDemandList');
    }
    public function DemandDetails(){
        $MemberAreaModule = new MemberAreaModule();
        $MemberSetCollectionModule = new MemberSetCollectionModule();
        $ID = intval($_GET['ID']);
        $CollectionInfo = $MemberSetCollectionModule->GetInfoByKeyID($ID);
        var_dump($CollectionInfo);
        $Commission = json_decode($CollectionInfo['Commission'],true);
        include template('MemberFirmDemandDetails');
    }
    /**
     * @desc 催收公司要求方案(新增方案)
     */
    public function SetDemand(){
        $MemberAreaModule = new MemberAreaModule();
        $MemberSetCollectionModule = new MemberSetCollectionModule();
        $ID = intval($_GET['ID']);
        $Data= $MemberSetCollectionModule->GetInfoByKeyID($ID);
        include template('MemberFirmSetDemand');
    }
}