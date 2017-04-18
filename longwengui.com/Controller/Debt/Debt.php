<?php

/**
 * Created by PhpStorm.
 * Member: 123456
 * Date: 2017/3/8
 * Time: 18:46
 */
class Debt
{
    public function __construct() {

    }
    public function Index(){
        $Title ='隆文贵不良资产处置';
        $Nav='index';
        include template('Index');
    }
    /**
     * @desc 前端测试静态页
     */
    public function Test(){
      include template('Test');
    }
    /**
     * @desc  债务催收列表
     */
    public function DebtLists(){
        $Nav='debt';
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $AreaList = $MemberAreaModule->GetInfoByWhere(' and R1 =1 order by S1 asc',true);
        $NStatus = $MemberDebtInfoModule->NStatus;
        //分页查询开始-------------------------------------------------
        $MysqlWhere = ' and `Status` <= 7 and `CollectionType`<= 2 order by Status asc , AddTime desc';
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
        $Title="债务案源|催收系统|债务追讨-隆文贵不良资产处置";
        $Keywords="催收平台,催收系统，债务清算,债务追讨,欠款催收,债务案源";
        $Description="债权人在隆文贵不良资产处置平台发布单笔或多笔债权信息后，债务信息展现在隆文贵不良资产处置债务催收栏目版块，执业律师或催收公司在此页面可根据地域分布和佣金比例等因素选择接单，进行催收，从而赚取佣金。";
        include template('DebtLists');
    }
    public function DebtDetails(){
        $Nav='debt';
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberDebtImageModule = new MemberDebtImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberFocusDebtModule = new MemberFocusDebtModule();
        $NStatus = $MemberDebtInfoModule->NStatus;
        $ID = intval($_GET['ID']);
        //债务信息
        $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($ID);
        if ($DebtInfo['Status'] ==8  && $DebtInfo['UserID']!=$_SESSION['UserID']){
            alertandgotopage("访问被拒绝", WEB_MAIN_URL.'/debtlists/');
        }
        //债务关注
        $FocusDebt = $MemberFocusDebtModule->GetInfoByWhere(' and DebtID = '.$ID.' and UserID= '.$_SESSION['UserID']);
        //保证人信息
        if ($DebtInfo['Warrantor']){
            $WarrantorInfo = json_decode($DebtInfo['WarrantorInfo'],true);
            foreach ($WarrantorInfo as $key=>$value){
                $WarrantorInfo[$key]['card'] = strlen($value['card']) ? substr_replace($value['card'], '****', 10, 4) : '';
                $WarrantorInfo[$key]['phone'] = strlen($value['phone']) ? substr_replace($value['phone'], '****', 7, 4) : '';
            }
        }
        //抵押物信息
        if ($DebtInfo['Guarantee']){
            $GuaranteeInfo = json_decode($DebtInfo['GuaranteeInfo'],true);
        }
        //发布人信息
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $DebtInfo['UserID']);
        //债务人信息
        $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID = ".$ID,true);
        foreach ($DebtorsInfo as $key=>$value){
            $DebtorsInfo[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            $DebtorsInfo[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            $DebtorsInfo[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
            $DebtorsInfo[$key]['Card'] = strlen($value['Card']) ? substr_replace($value['Card'], '****', 10, 4) : '';
        }
        //债务人图片
        $DebtImage = $MemberDebtImageModule->GetInfoByWhere(" and DebtID = ".$ID,true);
        if (isset ($_SESSION ['UserID']) || !empty ($_SESSION ['UserID'])){
            //浏览人信息
            $browseUserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $_SESSION['UserID']);
        }
        //关联的债务信息
        if ($DebtorsInfo[0]['Card'] !==''){
            $AssociatedDebtors = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID != ".$ID.' and Card = \''.$DebtorsInfo[0]['Card'].'\'',true);
            foreach ($AssociatedDebtors as $key =>$value){
                $AssociatedDebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($value['DebtID']);
                $AssociatedDebtors[$key]['DebtNum'] = $AssociatedDebtInfo['DebtNum'];
                $AssociatedDebtors[$key]['Overduetime'] = $AssociatedDebtInfo['Overduetime'];
                $AssociatedDebtors[$key]['AddTime'] = $AssociatedDebtInfo['AddTime'];
                $AssociatedDebtors[$key]['DebtAmount'] = $AssociatedDebtInfo['DebtAmount'];
                $AssociatedDebtors[$key]['Status'] = $AssociatedDebtInfo['Status'];
                $AssociatedDebtors[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
                $AssociatedDebtors[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
                $AssociatedDebtors[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
            }
        }
        $Title="债务详情-隆文贵不良资产处置";
        //处置方接单申请
        if ($DebtInfo['UserID']==$_SESSION['UserID']){
            $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
            $Data['Data'] = $MemberClaimsDisposalModule->GetInfoByWhere(' and DebtID ='.$DebtInfo['DebtID'],true);
            foreach ( $Data['Data'] as $key=>$value){
               $ClaimsUserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
               if ($ClaimsUserInfo['Identity']==3 ||$ClaimsUserInfo['Identity']==4){
                   $Data['Data'][$key]['CompanyName'] = $ClaimsUserInfo['CompanyName'];
               }elseif ($ClaimsUserInfo['Identity']==2){
                   $Data['Data'][$key]['CompanyName'] = $ClaimsUserInfo['RealName'];
               }
            }
        }
        include template('DebtDetails');
    }
    /**
     * @desc  发布债务
     */
    public function DebtPublish()
    {
        $Nav='debt';
        $Type = intval($_GET['T']);
        $Title="发布债务-隆文贵不良资产处置";
        if ($Type===1){
            include template('DebtPublishLawer');
        }elseif ($Type===2){
            include template('DebtPublishCollectors');
        }elseif ($Type===3){
            include template('DebtPublishDiy');
        }

    }
    /**
     * @desc  债权转让/股权转让暂定
     */
    public function Transfer(){
        $Nav ='transfer';
        include template('DebtTransfer');
    }
}
