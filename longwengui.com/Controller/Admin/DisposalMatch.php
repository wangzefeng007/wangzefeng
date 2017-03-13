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
        $MemberFindDisposalDebtModule = new MemberFindDisposalDebtModule();
        $StatusInfo = $MemberFindDisposalDebtModule->NStatus;
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
        $Rscount = $MemberFindDisposalDebtModule->GetListsNum($SqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            if ($Page > $Data['PageCount'])
                $page = $Data['PageCount'];
            $Data['Data'] = $MemberFindDisposalDebtModule->GetLists($SqlWhere, $Offset, $Data['PageSize']);
            foreach ($Data['Data']as $key => $value) {
                $value['DebtInfo'] = json_decode($value['DebtInfo'],ture);
                $Data['Data'][$key]['name'] = $value['DebtInfo'][0]['name'];
                $Data['Data'][$key]['province'] = $value['DebtInfo'][0]['province'];
                $Data['Data'][$key]['city'] = $value['DebtInfo'][0]['city'];
                $Data['Data'][$key]['area'] = $value['DebtInfo'][0]['area'];
                $Data['Data'][$key]['money'] = $value['DebtInfo'][0]['money'];
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
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberFindDisposalDebtModule = new MemberFindDisposalDebtModule();
        //编辑当前状态
        if ($_POST['DebtID']) {
            $Data['Status'] = intval($_POST['Status']);
            $DebtID = intval($_POST['DebtID']);
            $result = $MemberFindDisposalDebtModule->UpdateInfoByWhere($Data, ' DebtID= '.$DebtID);
            if ($result) {
                alertandgotopage('操作成功!', '/index.php?Module=DisposalMatch&Action=DisposalMatchEdit&DebtID=' . $DebtID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        $DebtID = intval($_GET ['DebtID']);
        $DebtInfo = $MemberFindDisposalDebtModule->GetInfoByKeyID($DebtID);
        $DebtInfo['DebtInfo'] = json_decode($DebtInfo['DebtInfo'], true);
        $DebtInfo['CreditorsInfo'] = json_decode($DebtInfo['CreditorsInfo'], true);
        $DebtInfo['WarrantorInfo'] = json_decode($DebtInfo['WarrantorInfo'], true);
        $DebtInfo['GuaranteeInfo'] = json_decode($DebtInfo['GuaranteeInfo'], true);
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $DebtInfo['UserID']);
        include template('DisposalMatchEdit');
    }
}