<?php

/**
 *desc代理信息管理
 */
class Proxy
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  添加或更新代理信息
     */
    public function Add()
    {
        $MemberProxyApplyModule = new MemberProxyApplyModule();
        include template('ProxyAdd');
    }

    /**
     * @desc 代理信息列表
     */
    public function ProxyLists()
 {
        $MemberProxyApplyModule = new MemberProxyApplyModule();
        $StatusInfo = $MemberProxyApplyModule->NStatus;
        $SqlWhere = '';
        // 搜索条件
        $PageUrl = '';
        $keyword = trim($_GET['keyword']);
        if ($keyword != '') {
            $SqlWhere .= ' and concat(Name) like \'%' . $keyword . '%\'';
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
            tourl('/index.php?Module=Proxy&Action=ProxyLists&Page=' . $page . $PageUrl);
        }
        // 分页开始
        $Page = intval($_GET['Page']);
        $Page = $Page ? $Page : 1;
        $PageSize = 10;
        $Rscount = $MemberProxyApplyModule->GetListsNum($SqlWhere);
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
            $Data['Data'] = $MemberProxyApplyModule->GetLists($SqlWhere, $Offset, $Data['PageSize']);
            foreach ($Data['Data']as $key => $value) {
                $Data['Data'][$key]['AddTime'] = !empty($value['AddTime']) ? date('Y-m-d H:i:s', $value['AddTime']) : '';
            }
            MultiPage($Data, $Data['PageCount']);
        }
        include template('ProxyLists');
    }
      /**
     * @desc 代理信息详情与审核
     */
    
     public function ProxyDetail() {
         
        $MemberProxyApplyModule = new MemberProxyApplyModule();
        if ($_POST['ApplyID']) {
            $Data['Status'] = intval($_POST['Status']);
            $ApplyID = intval($_POST['ApplyID']);
            $result = $MemberProxyApplyModule->UpdateInfoByWhere($Data, ' ApplyID= ' . $ApplyID);
            if ($result) {
                alertandgotopage('操作成功!', '/index.php?Module=Proxy&Action=ProxyDetail&ApplyID=' . $ApplyID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        if ($_GET['ApplyID']) {
            $ApplyID = $_GET['ApplyID'];
            $UserInfo = $MemberProxyApplyModule->GetInfoByKeyID($ApplyID);
            $UserInfo['AddTime'] = !empty($UserInfo['AddTime']) ? date('Y-m-d H:i:s', $UserInfo['AddTime']) : '';
        }
        include template('ProxyDetail');
    }

    /**
     * @desc  删除代理信息
     */
    public function Delete()
    {
        $MemberProxyApplyModule = new MemberProxyApplyModule();
        $ApplyID = $_GET['ApplyID'];
        $result = $MemberProxyApplyModule->DeleteByKeyID($ApplyID);
        if (!$result) {
            alertandgotopage("删除失败", '/index.php?Module=Proxy&Action=ProxyLists');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=Proxy&Action=ProxyLists');
        }
    }

}
