<?php
/**
 * @desc  律师会员中心
 */
class MemberLawyer
{
    public function __construct() {
    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=4)
                alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
    }
    /**
     * @desc 律师会员中心(个人信息)
     */
    public function Index()
    {
        $this->IsLogin();
        $Nav='memberlawyer';
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
        $Title = '会员中心首页';
        include template('MemberLawyerIndex');
    }
    /**
     * @desc 律师会员中心(完善个人资料)
     */
    public function EditInfo()
    {
        $this->IsLogin();
        $Nav='memberlawyer';
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
        include template('MemberLawyerEditInfo');
    }
    /**
     * @desc 律师主动申请的债权列表
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
                $Data['Data'][$key]['Status']= $DebtInfo['Status'];
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
        include template('MemberLawyerApplyDebtOrder');
    }
    /**
     * @desc 律师债权接单
     */
    public function CreditOrder(){
        $this->IsLogin();
        $Nav='creditorder';
        $Title = '会员中心-债权接单';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberFindDebtOrderModule = new MemberFindDebtOrderModule();
        $MemberFindDebtModule = new MemberFindDebtModule();
        $MemberFindDebtorsModule = new MemberFindDebtorsModule();
        $MemberFindCreditorsModule = new MemberFindCreditorsModule();
        $MemberAreaModule = new MemberAreaModule();
        $NStatus = $MemberFindDebtOrderModule->NStatus;
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
        $Rscount = $MemberFindDebtOrderModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberFindDebtOrderModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);//处置方申请信息
            foreach ($Data['Data'] as $key=>$value){
                $DebtInfo = $MemberFindDebtModule->GetInfoByKeyID($value['DebtID']);//债务基本信息
                $DebtorsInfo = $MemberFindDebtorsModule->GetInfoByWhere(' and DebtID = '.$value['DebtID']);//债务人信息
                $Data['Data'][$key]['DebtNum']= $DebtInfo['DebtNum'];
                $Data['Data'][$key]['DebtAmount']= $DebtInfo['DebtAmount'];
                $Data['Data'][$key]['Overduetime']= $DebtInfo['Overduetime'];
                $Data['Data'][$key]['AddTime']= $DebtInfo['AddTime'];
                $Data['Data'][$key]['Name']= $DebtorsInfo['Name'];
                if ($DebtorsInfo['Province'])
                    $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
                if ($DebtorsInfo['City'])
                    $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
                if ($DebtorsInfo['Area'])
                    $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }

        include template('MemberLawyerCreditOrder');
    }
    /**
     * @desc 律师(悬赏的债务)
     */
    public function RewordList(){
        $this->IsLogin();
        if ($_SESSION['Identity']!=4){
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
        include template('MemberLawyerRewordList');

    }
    /**
     * @desc 律师债权接单的要求方案列表
     */
    public function DemandList(){
        $this->IsLogin();
        $Nav='demandlist';
        $Title = '会员中心-要求方案';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberSetLawyerFeeModule = new MemberSetLawyerFeeModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $MysqlWhere =' and UserID = '.$_SESSION['UserID'];
        $Rscount = $MemberSetLawyerFeeModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberSetLawyerFeeModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }

        include template('MemberLawyerDemandList');
    }
    /**
     * @desc 律师要求方案(方案详情)
     */
    public function DemandDetails(){
        $this->IsLogin();
        $MemberAreaModule = new MemberAreaModule();
        $MemberSetLawyerFeeModule = new MemberSetLawyerFeeModule();
        $ID = intval($_GET['ID']);
        $LawyerFeeDemand = $MemberSetLawyerFeeModule->GetInfoByWhere(' and SetID ='.$ID.' and UserID = '.$_SESSION['UserID']);
        if (!$LawyerFeeDemand){
            alertandback("该方案不存在！");
        }
        if ($LawyerFeeDemand['Province'])
        $LawyerFeeDemand['province'] = $MemberAreaModule->GetCnNameByKeyID($LawyerFeeDemand['Province']);
        if ($LawyerFeeDemand['City'])
        $LawyerFeeDemand['city'] = $MemberAreaModule->GetCnNameByKeyID($LawyerFeeDemand['City']);
        if ($LawyerFeeDemand['Area'])
        $LawyerFeeDemand['area'] = $MemberAreaModule->GetCnNameByKeyID($LawyerFeeDemand['Area']);
        include template('MemberLawyerDemandDetails');
    }
    /**
     * @desc 律师要求方案(新增方案)
     */
    public function SetDemand(){
        $this->IsLogin();
        $MemberAreaModule = new MemberAreaModule();
        $MemberSetLawyerFeeModule = new MemberSetLawyerFeeModule();
        $ID = intval($_GET['ID']);
        if ($ID){
            $LawyerFeeDemand= $MemberSetLawyerFeeModule->GetInfoByKeyID($ID);
            if ($LawyerFeeDemand['Province'])
            $LawyerFeeDemand['province'] = $MemberAreaModule->GetCnNameByKeyID($LawyerFeeDemand['Province']);
            if ($LawyerFeeDemand['City'])
            $LawyerFeeDemand['city'] = $MemberAreaModule->GetCnNameByKeyID($LawyerFeeDemand['City']);
            if ($LawyerFeeDemand['Area'])
            $LawyerFeeDemand['area'] = $MemberAreaModule->GetCnNameByKeyID($LawyerFeeDemand['Area']);
        }
        include template('MemberLawyerSetDemand');
    }
}