<?php
/**
 * @desc  债务信息管理
 */
class Debt {
    public function __construct() {
        IsLogin();
    }
    /**
     * @desc  债务管理列表
     */
    public function DebtLists() {
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $StatusInfo = $MemberDebtInfoModule->Status;
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
        $Rscount = $MemberDebtInfoModule->GetListsNum($SqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            if ($Page > $Data['PageCount'])
                $page = $Data['PageCount'];
            $Data['Data'] = $MemberDebtInfoModule->GetLists($SqlWhere, $Offset, $Data['PageSize']);
            foreach ($Data['Data']as $key => $value) {
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere("  and Type =1 and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                $Data['Data'][$key]['Province'] = $DebtorsInfo['Province'];
                $Data['Data'][$key]['City'] = $DebtorsInfo['City'];
                $Data['Data'][$key]['Area'] = $DebtorsInfo['Area'];
                $Data['Data'][$key]['AddTime']= !empty($value['AddTime'])? date('Y-m-d H:i:s',$value['AddTime']): '';
            }

            MultiPage($Data, $Data['PageCount']);
        }
        include template('DebtLists');
    }

    /**
     * @desc  删除债务
     */
    public function DebtDelete() {
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $DebtID = $_GET['DebtID'];
        $result = $MemberDebtInfoModule->DeleteByKeyID($DebtID);
        if (!$result) {
            alertandgotopage("删除失败", '/index.php?Module=Debt&Action=DebtLists');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=Debt&Action=DebtLists');
        }
    }
    /**
     * @desc 债务管理详情编辑
     */
    public function DebtEdit() {
        //查询数据
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        //编辑当前状态

        if ($_POST['DebtID']) {
            $Data['Status'] = intval($_POST['Status']);
            $DebtID = intval($_POST['DebtID']);
            $result = $MemberDebtInfoModule->UpdateInfoByWhere($Data, ' DebtID= '.$DebtID);
            if ($result) {
                alertandgotopage('操作成功!', '/index.php?Module=Debt&Action=DebtEdit&DebtID=' . $DebtID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        $DebtID = intval($_GET ['DebtID']);
        $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($DebtID);
        $DebtInfo['DebtInfo'] = json_decode($DebtInfo['DebtInfo'], true);
        $DebtInfo['CreditorsInfo'] = json_decode($DebtInfo['CreditorsInfo'], true);
        $DebtInfo['WarrantorInfo'] = json_decode($DebtInfo['WarrantorInfo'], true);
        $DebtInfo['GuaranteeInfo'] = json_decode($DebtInfo['GuaranteeInfo'], true);
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID=' . $DebtInfo['UserID']);
        include template("DebtEdit");
    }
}

?>