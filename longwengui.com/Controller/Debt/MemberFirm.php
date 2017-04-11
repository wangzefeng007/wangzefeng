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
        $this->IsLogin();
        $Nav ='applydebtorder';
        $Title = '会员中心-申请的债权';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $NStatus = $MemberClaimsDisposalModule->NStatus;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);

        //分页Start
        $MysqlWhere =' and UserID = '.$_SESSION['UserID'];
        $Status = $_GET['S']? intval($_GET['S']) : 0;
        if ($Status==1){
            $MysqlWhere .=' and `Status` = 1';//正在接单的债务
        }elseif($Status==2){
            $MysqlWhere .=' and `Status` = 2';//催款中的债务
        }elseif($Status==3){
            $MysqlWhere .=' and `Status` IN (4,5)';//完成的债务
        }elseif($Status==4){
            $MysqlWhere .=' and `Status` = 3';//未完成的债务
        }
        $Rscount = $MemberClaimsDisposalModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=10;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberClaimsDisposalModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($value['DebtID']);
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(' and DebtID = '.$value['DebtID']);
                $Data['Data'][$key]['DebtNum']= $DebtInfo['DebtNum'];
                $Data['Data'][$key]['DebtAmount']= $DebtInfo['DebtAmount'];
                $Data['Data'][$key]['Overduetime']= $DebtInfo['Overduetime'];
                $Data['Data'][$key]['AddTime']= $DebtInfo['AddTime'];
                $Data['Data'][$key]['Name']= $DebtorsInfo['Name'];
                if ($DebtorsInfo['Province'])
                    $Data['Data'][$key]['Province']= $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
                if ($DebtorsInfo['City'])
                    $Data['Data'][$key]['City']= $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
                if ($DebtorsInfo['Area'])
                    $Data['Data'][$key]['Area']= $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberFirmApplyDebtOrder');
    }
    /**
     * @desc 催收公司债权接单
     */
    public function CreditOrder(){
        $this->IsLogin();
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
        $this->IsLogin();
        $Nav='creditorder';
        $Title = '会员中心-要求方案';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberSetCompanyModule = new MemberSetCompanyModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere =' and UserID = '.$_SESSION['UserID'];
        $Rscount = $MemberSetCompanyModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=10;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberSetCompanyModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberFirmDemandList');
    }

    /**
     * @desc 催收公司要求方案(方案详情)
     */
    public function DemandDetails(){
        $this->IsLogin();
        $MemberAreaModule = new MemberAreaModule();
        $MemberSetCompanyModule = new MemberSetCompanyModule();
        $ID = intval($_GET['ID']);
        $CompanyDemand = $MemberSetCompanyModule->GetInfoByWhere(' and SetID ='.$ID.' and UserID = '.$_SESSION['UserID']);
        if (!$CompanyDemand){
            alertandback("该方案不存在！");
        }
        if ($CompanyDemand['Province'])
        $CompanyDemand['province'] = $MemberAreaModule->GetCnNameByKeyID($CompanyDemand['Province']);
        if ($CompanyDemand['City'])
        $CompanyDemand['city'] = $MemberAreaModule->GetCnNameByKeyID($CompanyDemand['City']);
        if ($CompanyDemand['Area'])
        $CompanyDemand['area'] = $MemberAreaModule->GetCnNameByKeyID($CompanyDemand['Area']);
        include template('MemberFirmDemandDetails');
    }
    /**
     * @desc 催收公司要求方案(新增方案)
     */
    public function SetDemand(){
        $this->IsLogin();
        $MemberAreaModule = new MemberAreaModule();
        $MemberSetCompanyModule = new MemberSetCompanyModule();
        $ID = intval($_GET['ID']);
        if ($ID) {
            $CompanyDemand = $MemberSetCompanyModule->GetInfoByKeyID($ID);
            if ($CompanyDemand['Province'])
            $CompanyDemand['province'] = $MemberAreaModule->GetCnNameByKeyID($CompanyDemand['Province']);
            if ($CompanyDemand['City'])
            $CompanyDemand['city'] = $MemberAreaModule->GetCnNameByKeyID($CompanyDemand['City']);
            if ($CompanyDemand['Area'])
            $CompanyDemand['area'] = $MemberAreaModule->GetCnNameByKeyID($CompanyDemand['Area']);
        }
        include template('MemberFirmSetDemand');
    }
}