<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/4/25
 * Time: 10:51
 */
class MemberCompany
{
    public function __construct() {
    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=5)
                alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
    }
    /**
     * @desc 企业会员中心(个人信息)
     */
    public function Index()
    {
        $Nav='membercompany';
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
        $UserInfo['PublicAgent'] = json_decode($UserInfo['PublicAgent'],true);
        if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['Area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberCompanyIndex');
    }
    /**
     * @desc 企业会员中心(完善个人资料)
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
        $UserInfo['PublicAgent'] = json_decode($UserInfo['PublicAgent'],true);
        if ($UserInfo['Province'])
            $UserInfo['province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
        if ($UserInfo['City'])
            $UserInfo['city'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
        if ($UserInfo['Area'])
            $UserInfo['area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
        include template('MemberCompanyEditInfo');
    }
    /**
     * @desc 个人会员我的债权
     */
    public function BondList()
    {
        $this->IsLogin();
        if ( $_SESSION['Identity']!=5){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $Nav ='bondlist';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $NStatus = $MemberDebtInfoModule->NStatus;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        //分页查询开始-------------------------------------------------
        $MysqlWhere ='';
        $Status = $_GET['S']?intval($_GET['S']):0;
        if ($Status==1){
            $MysqlWhere .= ' and ( Status =1 or Status =8 ) ';
        }elseif($Status==2){
            $MysqlWhere .= ' and Status =2 ';
        }elseif($Status==3){
            $MysqlWhere .= ' and Status =3 ';
        }elseif($Status==4){
            $MysqlWhere .= ' and ( Status =4 or Status =5 ) ';
        }elseif($Status==5){
            $MysqlWhere .= ' and Status =7 ';
        }
        $MysqlWhere .= ' and UserID ='.$_SESSION['UserID'].' order by AddTime desc';
        //关键字
        $Rscount = $MemberDebtInfoModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberDebtInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
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
        include template('MemberCompanyBondList');
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
        include template('MemberCompanyFocusDebtList');
    }
}