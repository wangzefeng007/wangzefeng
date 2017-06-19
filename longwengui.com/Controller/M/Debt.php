<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/2
 * Time: 9:53
 */
class Debt
{
    /**
     * @desc  债务催收列表
     */
    public function Index(){
        include template('DebtIndex');
    }
    /**
     * @desc  债务详情
     */
    public function Details(){
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberDebtImageModule = new MemberDebtImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberCreditorsInfoModule = new MemberCreditorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberFocusDebtModule = new MemberFocusDebtModule();
        $NStatus = $MemberDebtInfoModule->NStatus;
        $ID = intval($_GET['ID']);
        //债务信息
        $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($ID);
        $DebtInfo['Overduetime'] = intval((time()-$DebtInfo['Overduetime'])/ 86400);
        //债权人信息
        $CreditorsInfo = $MemberCreditorsInfoModule->GetInfoByWhere(" and DebtID = ".$ID,true);
        foreach ($CreditorsInfo as $key=>$value){
            $CreditorsInfo[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            $CreditorsInfo[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            $CreditorsInfo[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
            $CreditorsInfo[$key]['Card'] = strlen($value['Card']) ? substr_replace($value['Card'], '****', 10, 4) : '';
            $CreditorsInfo[$key]['Phone'] = strlen($value['Phone']) ? substr_replace($value['Phone'], '****', 4, 4) : '';
        }
        //亲友信息
        if ($DebtInfo['DebtFamily']){
            $DebtFamilyInfo = json_decode($DebtInfo['DebtFamilyInfo'],true);
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
            $DebtorsInfo[$key]['Phone'] = strlen($value['Phone']) ? substr_replace($value['Phone'], '****', 4, 4) : '';
        }
        //债务人图片
        $DebtImage = $MemberDebtImageModule->GetInfoByWhere(" and DebtID = ".$ID,true);
        //债务关注
        if (!empty ($_SESSION ['UserID'])){
            $FocusDebt = $MemberFocusDebtModule->GetInfoByWhere(' and DebtID = '.$ID.' and UserID= '.$_SESSION['UserID']);
        }
        include template('DebtDetails');
    }
    /**
     * @desc  发布债务
     */
    public function Publish(){
        include template('DebtPublish');
    }
}