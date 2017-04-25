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
     * @desc (悬赏的债务)
     */
    public function RewordList(){
        $this->IsLogin();
        if ($_SESSION['Identity']!=5){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $Nav='rewordlist';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardImageModule = new MemberRewardImageModule();
        $MemberAreaModule = new MemberAreaModule();
        //分页查询开始-------------------------------------------------

        $MysqlWhere ='';
        $Status = $_GET['S']?intval($_GET['S']):0;
        if ($Status==1){
            $MysqlWhere .= ' and Status =3 ';
        }elseif($Status==2){
            $MysqlWhere .= ' and Status =4 ';
        }
        $MysqlWhere .= ' and UserID ='.$_SESSION['UserID'].' order by AddTime desc';
        //关键字
        $Rscount = $MemberRewardInfoModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberRewardInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                if ($value['Province'])
                    $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
                if ($value['City'])
                    $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
                if ($value['Area'])
                    $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
                $RewardImage = $MemberRewardImageModule->GetInfoByWhere(' and RewardID = '.$value['ID'],true);
                foreach ($RewardImage as $K=>$V){
                    if ($V['IsDefault']==1){
                        $Data['Data'][$key]['DefaultImage'] = $V['ImageUrl'];
                    }else{
                        $Data['Data'][$key]['Image'][] = $V['ImageUrl'];
                    }
                }
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        include template('MemberCompanyRewordList');

    }
    /**
     * @desc 个人会员主动申请的债权(向处置方申请的债务)
     */
    public function FindTeam()
    {
        $this->IsLogin();
        if ($_SESSION['Identity']!=5){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $Title = '会员中心-向处置方申请的债务';
        $Nav='findteam';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberFindDebtOrderModule = new MemberFindDebtOrderModule();
        $MemberFindDebtModule = new MemberFindDebtModule();
        $MemberFindDebtorsModule = new MemberFindDebtorsModule();
        $MemberAreaModule = new MemberAreaModule();
        $NStatus = $MemberFindDebtOrderModule->NStatus;
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        //分页Start
        $MysqlWhere ='';
        $Status = $_GET['S']? intval($_GET['S']) : 0;
        if ($Status==1){
            $MysqlWhere .=' and `Status` = 1';//正在申请的债务
        }elseif($Status==2){
            $MysqlWhere .=' and `Status` = 2';//催款中的债务
        }elseif($Status==3){
            $MysqlWhere .=' and `Status` = 3';//未完成的债务
        }elseif($Status==4){
            $MysqlWhere .=' and `Status` IN (4,5)';//完成的债务
        }
        $FindDebtInfo = $MemberFindDebtModule->GetFindDebtInfoByUserID($_SESSION['UserID'],$MysqlWhere);
        $RscountNum = count($FindDebtInfo);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($RscountNum) {
            $PageSize=10;
            $Data = array();
            $Data['RecordCount'] = $RscountNum;
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            foreach ($FindDebtInfo as $value){
                $DebtID[] = $value['DebtID'];
            }
            $DebtID=implode(',',array_unique($DebtID));
            $sqlWhere = " and DebtID IN ($DebtID) order by AddTime desc";
            $Data['Data'] = $MemberFindDebtModule->GetLists($sqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $FindDebt = $MemberFindDebtModule->GetInfoByKeyID($value['DebtID']);
                $DebtorsInfo = $MemberFindDebtorsModule->GetInfoByWhere(' and DebtID = '.$value['DebtID']);
                $FindDebtOrder = $MemberFindDebtOrderModule->GetInfoByWhere(' and DebtID = '.$value['DebtID']);
                $Data['Data'][$key]['OrderID']= $FindDebtOrder['OrderID'];
                $Data['Data'][$key]['Money']= $FindDebtOrder['Money'];
                $Data['Data'][$key]['DelegateTime']= $FindDebtOrder['DelegateTime'];
                $Data['Data'][$key]['Name']= $DebtorsInfo['Name'];
                $Data['Data'][$key]['DebtNum']= $FindDebt['DebtNum'];
                $Data['Data'][$key]['DebtAmount']= $FindDebt['DebtAmount'];
                if ($DebtorsInfo['Province'])
                    $Data['Data'][$key]['Province']= $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
                if ($DebtorsInfo['City'])
                    $Data['Data'][$key]['City']= $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
                if ($DebtorsInfo['Area'])
                    $Data['Data'][$key]['Area']= $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
            }
            $ClassPage = new Page($RscountNum, $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('MemberCompanyFindTeam');
    }
}