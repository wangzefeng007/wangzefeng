<?php

/**
 *@desc 投诉建议管理
 */
class ComplaintAdvice
{
    public function __construct()
    {
        IsLogin();
    }

    /**
     * @desc 投诉建议详情
     */
    public function  ComplaintAdviceDetail()
    {
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        include template('ComplaintAdviceDetail');
    }

    /**
     * @desc  投诉建议列表
     */
    public function ComplaintAdviceLists() {
        
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        
        $StatusInfo = $MemberComplaintAdviceModule->Status;
        $SqlWhere = '';
        // 搜索条件
        $PageUrl = '';
        $keyword = trim($_GET['keyword']);
        if ($keyword != '') {
            $SqlWhere .= ' and (RewardNum=\'' . $keyword . '\' or concat(DebtName) like \'%' . $keyword . '%\')';
            $PageUrl .= '&keyword=' . $keyword;
        }
        // 跳转到该页面
        if ($_POST['page']) {
            $page = $_POST['page'];
            tourl('/index.php?Module=ComplaintAdvice&Action=ComplaintAdviceLists&Page=' . $page . $PageUrl);
        }
        // 分页开始
        $Page = intval($_GET['Page']);
        $Page = $Page ? $Page : 1;
        $PageSize = 10;
        $Rscount = $MemberComplaintAdviceModule->GetListsNum($SqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];

            if ($Page > $Data['PageCount']) {
                $page = $Data['PageCount'];
            }
            $Data['Data'] = $MemberComplaintAdviceModule->GetLists($SqlWhere, $Offset, $Data['PageSize']);
           
            foreach ($Data['Data']as $key => $value) {
                $UserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
                $Data['Data'][$key]['AddTime'] = !empty($value['AddTime']) ? date('Y-m-d H:i:s', $value['AddTime']) : '';
                $Data['Data'][$key]['RealName'] = $UserInfo['RealName'];
            }
            MultiPage($Data, $Data['PageCount']);
        }
        include template('ComplaintAdviceLists');
    }

    /**
     * @desc  删除投诉建议
     */
    public function Delete()
    {
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        $ID = $_GET['ID'];
        $MemberComplaintAdvice = $MemberComplaintAdviceModule->DeleteByKeyID($ID);
        if (!$MemberComplaintAdvice) {
            alertandgotopage("删除失败", '/index.php?Module=ComplaintAdvice&Action=ComplaintAdviceLists');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=ComplaintAdvice&Action=ComplaintAdviceLists');
        }
    }
}