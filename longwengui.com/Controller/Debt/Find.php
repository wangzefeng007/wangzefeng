<?php
/**
 * @desc  寻找处置方
 */
class Find
{
    public function __construct() {

    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=1)
                alertandgotopage("访问被拒绝,目前只有普通会员可以寻找处置方！", WEB_MAIN_URL.'/choicefind/');
        }
    }
    /**
     * @desc  寻找处置方
     */
    public function ChoiceFind(){
        $Title="寻找处置方-隆文贵不良资产处置";
        $Nav ='find';
        include template('DebtChoiceFind');
    }
    public function Team(){
        $this->IsLogin();
        if ($_SESSION['IdentityState']!=3 )
            alertandgotopage("请等待审核通过方可寻找处置方！", WEB_MAIN_URL.'/choicefind/');
        $Nav ='find';
        $Type = intval($_GET['T']);
        if ($Type===1){
            $Title="寻找律师团队-隆文贵不良资产处置";
        }elseif($Type===2){
            $Title="寻找催收公司-隆文贵不良资产处置";
        }else{
            alertandback('无此处置方！');
        }
        include template('DebtFindTeam');
    }
    /**
     * @desc  寻找处置方
     */
    public function Details(){
        $Title="寻找处置方债务详情页-隆文贵不良资产处置";
        $Nav ='find';
        $ID = intval($_GET['ID']);
        $MemberFindDebtOrderModule = new MemberFindDebtOrderModule();
        $MemberFindDebtModule = new MemberFindDebtModule();
        $MemberFindDebtorsModule = new MemberFindDebtorsModule();
        $MemberFindCreditorsModule = new MemberFindCreditorsModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $FindDebt = $MemberFindDebtModule->GetInfoByKeyID($ID);
        if (!$FindDebt){
            alertandback('不存在该债务！');
        }
        $FindDebt['WarrantorInfo'] = json_decode($FindDebt['WarrantorInfo'],JSON_UNESCAPED_UNICODE);
        $FindDebt['GuaranteeInfo'] = json_decode($FindDebt['GuaranteeInfo'],JSON_UNESCAPED_UNICODE);
        $DebtorsInfo = $MemberFindDebtorsModule->GetInfoByWhere(' and DebtID = '.$ID,true);//债务人信息
        if ($DebtorsInfo){
            foreach ($DebtorsInfo as $key=>$value){
                if ($value['Province'])
                    $DebtorsInfo[$key]['Province']= $MemberAreaModule->GetCnNameByKeyID($value['Province']);
                if ($value['City'])
                    $DebtorsInfo[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
                if ($value['Area'])
                    $DebtorsInfo[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
            }
        }
        $CreditorsInfo = $MemberFindCreditorsModule->GetInfoByWhere(' and DebtID = '.$ID,true);//债权人信息
        if ($CreditorsInfo){
            foreach ($CreditorsInfo as $key=>$value){
                if ($value['Province'])
                    $CreditorsInfo[$key]['Province']= $MemberAreaModule->GetCnNameByKeyID($value['Province']);
                if ($value['City'])
                    $CreditorsInfo[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
                if ($value['Area'])
                    $CreditorsInfo[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
            }
        }
        //发布人信息
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $FindDebt['UserID']);
        include template('FindDebtDetails');
    }


}