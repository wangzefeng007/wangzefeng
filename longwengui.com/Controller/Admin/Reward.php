<?php

/**
 * @param 悬赏信息管理
 */
class Reward
{
    public function __construct()
    {
        IsLogin();
    }

    /**
     * @desc  添加或更新悬赏信息
     */
    public function Add()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        include template('RewardAdd');
    }

    /**
     * @desc  悬赏信息列表
     */
    public function RewardLists()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $SqlWhere = '';
        // 搜索条件
        $PageUrl = '';
        $keyword = trim($_GET['keyword']);
        if ($keyword != '') {
            $SqlWhere .= ' and (RewardNum=\'' . $keyword . '\' or concat(DebtName) like \'%' . $keyword . '%\')';
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
            tourl('/index.php?Module=Reward&Action=RewardLists&Page=' . $page . $PageUrl);
        }
        // 分页开始
        $Page = intval($_GET['Page']);
        $Page = $Page ? $Page : 1;
        $PageSize = 10;
        $Rscount = $MemberRewardInfoModule->GetListsNum($SqlWhere);
        if ($Rscount['Num']) {
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];

            if ($Page > $Data['PageCount'])
                $page = $Data['PageCount'];

            $Data['Data'] = $MemberRewardInfoModule->GetLists($SqlWhere, $Offset, $Data['PageSize']);
            MultiPage($Data, $Data['PageCount']);
        }
        include template('RewardLists');
    }
     /**
     * @desc  悬赏信息详情
     */
    public function RewardDetail()
    {
          $MemberRewardInfoModule = new MemberRewardInfoModule();
        include template('RewardLists');
    }

    /**
     * @desc  悬赏信息删除
     */
    public function Delete()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardInfo = $MemberRewardInfoModule->DeleteByKeyID($AreaID);
        if (!$MemberRewardInfo) {
            alertandgotopage("删除失败", '/index.php?Module=Reward&Action=RewardList');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=Reward&Action=RewardList');
        }
    }
}