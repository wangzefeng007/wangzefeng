<?php

/**
 * Created by PhpStorm.
 * User: 123456
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
     * @desc  债务催收列表
     */
    public function DebtLists(){
        $Nav='debtlists';
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $NStatus = $MemberDebtInfoModule->NStatus;
        $MemberAreaModule = new MemberAreaModule();
        //分页查询开始-------------------------------------------------
        $MysqlWhere ='';
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
            foreach (  $Data['Data'] as $key=>$value){
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere("  and Type =1 and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                $Data['Data'][$key]['Province'] = $DebtorsInfo['Province'];
                $Data['Data'][$key]['City'] = $DebtorsInfo['City'];
                $Data['Data'][$key]['Area'] = $DebtorsInfo['Area'];
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
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberDebtImageModule = new MemberDebtImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $ID = intval($_GET['ID']);
        //债务信息
        $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($ID);
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
        $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere("  and Type =1 and DebtID = ".$ID,true);
        foreach ($DebtorsInfo as $key=>$value){
            $DebtorsInfo[$key]['Card'] = strlen($value['Card']) ? substr_replace($value['Card'], '****', 10, 4) : '';
        }
        //债务人图片
        $DebtImage = $MemberDebtImageModule->GetInfoByWhere(" and DebtID = ".$ID,true);
        include template('DebtDetails');
    }
}