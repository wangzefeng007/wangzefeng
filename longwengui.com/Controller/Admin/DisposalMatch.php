<?php

/**
 * @desc 寻找处置方管理
 */
class DisposalMatch
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  处置方信息列表
     */
    public function DisposalMatchLists()
    {
        $MemberFindDebtModule = new MemberFindDebtModule();
        $MemberFindDebtorsModule = new MemberFindDebtorsModule();
        $MemberAreaModule = new MemberAreaModule();
        $StatusInfo = $MemberFindDebtModule->NStatus;
        $SqlWhere = '';
        // 搜索条件
        $PageUrl = '';
        $keyword = trim($_GET['keyword']);
        if ($keyword != '') {
            $SqlWhere .= ' and (DebtNum=\'' . $keyword . '\' or concat(UserID) like \'%' . $keyword . '%\')';
            $PageUrl .= '&keyword=' . $keyword;
        }
        if ($_GET ['Status']) {
            $Status = trim($_GET ['Status']);
            $SqlWhere .=' and `Status` = \'' . $Status . '\'';
            $PageUrl .='&Status=' . $Status;
        }
        // 跳转到该页面
        if ($_POST['page']) {
            $page = $_POST['page'];
            tourl('/index.php?Module=Debt&Action=DebtLists&Page=' . $page . $PageUrl);
        }
        // 分页开始
        $Page = intval($_GET['Page']);
        $Page = $Page ? $Page : 1;
        $PageSize = 10;
        $Rscount = $MemberFindDebtModule->GetListsNum($SqlWhere);
        if ($Rscount['Num']) {
            $SqlWhere = ' order by AddTime desc';
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            if ($Page > $Data['PageCount'])
                $page = $Data['PageCount'];
            $Data['Data'] = $MemberFindDebtModule->GetLists($SqlWhere, $Offset, $Data['PageSize']);
            foreach ($Data['Data']as $key => $value) {
                $DebtorsInfo = $MemberFindDebtorsModule->GetInfoByWhere(" and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Money'] = $DebtorsInfo['Money'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                $Province = $MemberAreaModule->GetInfoByKeyID($DebtorsInfo['Province']);
                $Data['Data'][$key]['Province'] = $Province['CnName'];
                $City = $MemberAreaModule->GetInfoByKeyID($DebtorsInfo['City']);
                $Data['Data'][$key]['City'] = $City['CnName'];
                $Area = $MemberAreaModule->GetInfoByKeyID($DebtorsInfo['Area']);
                $Data['Data'][$key]['Area'] = $Area['CnName'];
                $Data['Data'][$key]['AddTime']= !empty($value['AddTime'])? date('Y-m-d H:i:s',$value['AddTime']): '';
            }
            MultiPage($Data, $Data['PageCount']);
        }
        include template('DisposalMatchLists');
    }
    /**
     * @desc  更新处置方信息
     */
    public function DisposalMatchEdit()
    {
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberFindDebtModule = new MemberFindDebtModule();
        $MemberFindDebtorsModule = new MemberFindDebtorsModule();
        $MemberFindCreditorsModule = new MemberFindCreditorsModule();
        $MemberFindDebtOrderModule = new MemberFindDebtOrderModule();
        $MemberAreaModule = new MemberAreaModule();
        //编辑当前状态
        if ($_POST['DebtID']) {
            $Data['Status'] = intval($_POST['Status']);
            $DebtID = intval($_POST['DebtID']);
            $result = $MemberFindDebtModule->UpdateInfoByWhere($Data, ' DebtID= '.$DebtID);
            if ($result) {
                alertandgotopage('操作成功!', '/index.php?Module=DisposalMatch&Action=DisposalMatchEdit&DebtID=' . $DebtID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        $DebtID = intval($_GET ['DebtID']);
        $DebtInfo = $MemberFindDebtModule->GetInfoByKeyID($DebtID);
        //债务人信息
        $DebtorsInfo = $MemberFindDebtorsModule->GetInfoByWhere(" and DebtID = " . $DebtID,true);
        foreach ($DebtorsInfo as $key =>$value){
            $DebtorsInfo[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            $DebtorsInfo[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            $DebtorsInfo[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
        }
        //债权人信息
        $CreditorsInfo = $MemberFindCreditorsModule->GetInfoByWhere(" and DebtID = " . $DebtID,true);
        foreach ($CreditorsInfo as $key =>$value){
            $CreditorsInfo[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
            $CreditorsInfo[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
            $CreditorsInfo[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
        }
        $DebtInfo['DebtInfo'] = json_decode($DebtInfo['DebtInfo'], true);
        $DebtInfo['CreditorsInfo'] = json_decode($DebtInfo['CreditorsInfo'], true);
        $DebtInfo['WarrantorInfo'] = json_decode($DebtInfo['WarrantorInfo'], true);
        $DebtInfo['GuaranteeInfo'] = json_decode($DebtInfo['GuaranteeInfo'], true);
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $DebtInfo['UserID']);
        //处置方会员信息
        $FindDebtOrder = $MemberFindDebtOrderModule->GetInfoByWhere(' and DebtID = '.$DebtID,true);
        foreach ($FindDebtOrder as $key=>$value){
            $FindDebtOrder[$key]['UserID'] = $value['UserID'];
            $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $value['UserID']);
            $FindDebtOrder[$key]['CompanyName'] = $UserInfo['CompanyName'];
        }
        include template('DisposalMatchEdit');
    }
}