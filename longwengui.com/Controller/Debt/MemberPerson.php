<?php
/**
 * @desc  个人会员中心
 */
class MemberPerson
{
    public function __construct() {
    }
    /**
     * @desc  判断是否登录并返回登录页面
     */

    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }
    }
    /**
     * @desc 个人会员中心(个人信息)
     */
    public function Index()
    {
        $this->IsLogin();
        $Nav='memberperson';
        if ($_SESSION['Identity']!=0 && $_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
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
        include template('MemberPersonIndex');
    }
    /**
     * @desc 个人会员中心(完善个人资料)
     */
    public function EditInfo()
    {
        $this->IsLogin();
        $Nav='memberperson';
        if ($_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
            alertandback("访问被拒绝");
        }
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
     * @desc 个人会员我的债权
     */
    public function BondList()
    {
        $this->IsLogin();
        if ($_SESSION['Identity']!=0 && $_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
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
        include template('MemberPersonBondList');
    }
    /**
     * @desc 个人会员我的负债
     */
    public function DebtList()
    {
        $this->IsLogin();
        if ($_SESSION['Identity']!=0 && $_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $Nav ='debtlist';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        if ($UserInfo['CardNum']){
            $Data['Data'] =array();
            $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(' and Card = \''.$UserInfo['CardNum'].'\'',true);
            if ($DebtorsInfo){
                foreach ($DebtorsInfo  as $key=>$value){
                    $data[]=$value['DebtID'];
                }
                $data=implode(',',array_unique($data));
                $MysqlWhere = " and DebtID IN ($data)";
                $Data['Data'] = $MemberDebtInfoModule->GetLists($MysqlWhere, 0,30);
                foreach ($Data['Data'] as $key =>$value){
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
                    //发布人姓名
                    $MemberUserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
                    $Data['Data'][$key]['RealName'] =$MemberUserInfo['RealName'];
                }
            }
        }
        include template('MemberPersonDebtList');
    }
    /**
     * @desc (悬赏的债务)
     */
    public function RewordList(){
        $this->IsLogin();
        if ($_SESSION['Identity']!=0 && $_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
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
        include template('MemberPersonRewordList');

    }
    /**
     * @desc 个人会员主动申请的债权(向处置方申请的债务)
     */
    public function FindTeam()
    {
        $this->IsLogin();
        if ($_SESSION['Identity']!=0 && $_SESSION['Identity']!=1 && $_SESSION['Identity']!=2){
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
                $Data['Data'][$key]['Name']= $DebtorsInfo['Name'];
                $Data['Data'][$key]['DebtNum']= $FindDebt['DebtNum'];
                $Data['Data'][$key]['DebtAmount']= $FindDebt['DebtAmount'];
                $Data['Data'][$key]['AddTime']= $FindDebt['AddTime'];
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
        include template('MemberPersonFindTeam');
    }
    /**
     * @desc 个人会员申请的债权(向发布者申请的债务)
     */
    public function ApplyDebtOrder(){
        $this->IsLogin();
        if ($_SESSION['Identity']!=2 && $_SESSION['IdentityState']!=3){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL);
        }
        $Nav='applydebtorder';
        $Title = '会员中心-申请的债权';
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        //会员基本信息
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        $NStatus = $MemberClaimsDisposalModule->NStatus;
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
        include template('MemberPersonApplyDebtOrder');
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
        $MysqlWhere = ' and UserID='.$_SESSION ['UserID'];
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
        include template('MemberPersonFocusDebtList');
    }
}