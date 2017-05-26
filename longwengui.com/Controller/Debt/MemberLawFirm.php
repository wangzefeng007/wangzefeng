<?php
/**
 * @desc  律师事务所中心
 */
class MemberLawFirm
{
    public function __construct() {
    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=6)
                alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
    }
    /**
     * @desc 律师事务所中心(个人信息)
     */
    public function Index()
    {
        $this->IsLogin();
        $Nav='memberlawfirm';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $UserInfo['Agent'] = json_decode($UserInfo['Agent'],true);
        if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['Area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        $Title = '会员中心首页';
        include template('MemberLawFirmIndex');
    }
    /**
     * @desc 催收公司会员中心(完善个人资料)
     */
    public function EditInfo()
    {
        $this->IsLogin();
        $Title = '会员中心-完善个人资料';
        $Nav='memberlawfirm';
        //会员基本信息
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $UserInfo['Agent'] = json_decode($UserInfo['Agent'],true);
        if ($UserInfo['Province'])
            $UserInfo['province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['city'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberLawFirmEditInfo');
    }
    /**
     * @desc 律师事务所申请的债权列表
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
        include template('MemberLawFirmApplyDebtOrder');
    }
    /**
     * @desc 关注的债务
     */
    public function FocusDebtList(){
        $this->IsLogin();
        $Nav='focusdebtlist';
        $MemberFocusDebtModule = new MemberFocusDebtModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $NStatus = $MemberDebtInfoModule->NStatus;
        //分页查询开始-------------------------------------------------
        $MysqlWhere = ' and Type = 1 and UserID='.$_SESSION ['UserID'];
        //关键字
        $Rscount = $MemberFocusDebtModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=7;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberFocusDebtModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($value['DebtID']);
                $Data['Data'][$key]['DebtNum'] = $DebtInfo['DebtNum'];
                $Data['Data'][$key]['DebtAmount'] = $DebtInfo['DebtAmount'];
                $Data['Data'][$key]['Overduetime'] = $DebtInfo['Overduetime'];
                $Data['Data'][$key]['Status'] = $DebtInfo['Status'];
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                if ($DebtorsInfo['Province'])
                    $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
                if ($DebtorsInfo['City'])
                    $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
                if ($DebtorsInfo['Area'])
                    $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
                $Data['Data'][$key]['AddTime']= !empty($value['AddTime'])? date('Y-m-d',$value['AddTime']): '';
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberLawFirmFocusDebtList');
    }
    /**
     * @desc 援助方案
     */
    public function AidList()
    {
        $Nav='aidlist';
        $Title = '会员中心-要求方案';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere =' and UserID = '.$_SESSION['UserID'];
        $Rscount = $MemberLawfirmAidModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberLawfirmAidModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberLawFirmAidList');
    }
    /**
     * @desc 援助方案设置
     */
    public function SetAid(){
        $this->IsLogin();
        $MemberAreaModule = new MemberAreaModule();
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        $ID = intval($_GET['ID']);
        if ($ID) {
            $LawfirmAidInfo = $MemberLawfirmAidModule->GetInfoByWhere(' and ID ='.$ID.' and UserID = '.$_SESSION['UserID']);
            $LawfirmAidInfo['Area'] = json_decode($LawfirmAidInfo['Area'],true);
            foreach ( $LawfirmAidInfo['Area'] as $key=>$value){
                if ($value['province'])
                    $LawfirmAidInfo['Area'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['province']);
                if ($value['city'])
                    $LawfirmAidInfo['Area'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['city']);
                if ($value['area'])
                    $LawfirmAidInfo['Area'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['area']);
            }
        }
        include template('MemberLawFirmSetAid');
    }
    /**
     * @desc 援助方案详情
     */
    public function AidDetails(){
        $this->IsLogin();
        $MemberAreaModule = new MemberAreaModule();
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        $ID = intval($_GET['ID']);
        $LawfirmAidInfo = $MemberLawfirmAidModule->GetInfoByWhere(' and ID ='.$ID.' and UserID = '.$_SESSION['UserID']);
        if (!$LawfirmAidInfo){
            alertandback("该方案不存在！");
        }
        $LawfirmAidInfo['Area'] = json_decode($LawfirmAidInfo['Area'],true);
        foreach ($LawfirmAidInfo['Area'] as $key =>$value){
            if ($value['province'])
                $LawfirmAidInfo['Area'][$key]['province'] = $MemberAreaModule->GetCnNameByKeyID($value['province']);
            if ($value['city'])
                $LawfirmAidInfo['Area'][$key]['city'] = $MemberAreaModule->GetCnNameByKeyID($value['city']);
            if ($value['area'])
                $LawfirmAidInfo['Area'][$key]['area'] = $MemberAreaModule->GetCnNameByKeyID($value['area']);
        }
        include template('MemberLawFirmAidDetails');
    }
}