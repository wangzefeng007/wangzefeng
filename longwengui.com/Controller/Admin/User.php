<?php

/**
 *@desc 会员中心管理
 */
class User
{
    public function __construct()
    {
        IsLogin();
    }


    /**
     * @desc 会员中心列表
     */
    public function UserLists()
    {
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        $MysqlWhere = '';
        $PageSize = 10;
        $PageUrl = '';
        $Title = $_GET['Title'];
        if ($Title) {
            $MysqlWhere .= " and UserID like '%$Title%'";
            $PageUrl .= "&Title=$Title";
        }
        // 跳转到该页面
        if ($_POST['Page']) {
            $page = $_POST['Page'];
            tourl('/index.php?Module=User&Action=UserLists&Page=' . $page . $PageUrl);
        }
        $Page = intval($_GET['Page']) ? intval($_GET['Page']) : 1;
        $ListsNum = $MemberUserModule->GetListsNum($MysqlWhere);
        $Rscount = $ListsNum ['Num'];
        if ($Rscount) {
            $Data ['RecordCount'] = $Rscount;
            $Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
            $Data ['PageCount'] = ceil($Data ['RecordCount'] / $PageSize);
            if ($Page > $Data ['PageCount'])
                $Page = $Data ['PageCount'];
            $Data ['Page'] = min($Page, $Data ['PageCount']);
            $Offset = ($Page - 1) * $Data ['PageSize'];
            $Data['Data'] = $MemberUserModule->GetLists($MysqlWhere, $Offset, $Data ['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID = '.$value['UserID']);
                $Data['Data'][$key]['InfoID'] = $UserInfo['InfoID'];
                $Data['Data'][$key]['NickName'] = $UserInfo['NickName'];
                $Data['Data'][$key]['RealName'] = $UserInfo['RealName'];
                $Data['Data'][$key]['Identity'] = $UserInfo['Identity'];
                $Data['Data'][$key]['IdentityState'] = $UserInfo['IdentityState'];
            }
            MultiPage($Data, 10);
        }
        include template("UserLists");
    }
    /**
     * @desc 会员中心详情与审核
     */
    public function UserDetail()
    {
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        if ($_POST['UserID']) {
            $Data['IdentityState'] = intval($_POST['Status']);
            $UserID = intval($_POST['UserID']);
            $result = $MemberUserInfoModule->UpdateInfoByWhere($Data, ' UserID= ' . $UserID);
            $User = $MemberUserModule->GetInfoByKeyID($UserID);
            if ($result) {
                if ($Data['IdentityState']==3){
                    ToolService::SendSMSNotice($User['Mobile'], '尊敬的用户，您的账户已审核通过，感谢您的使用，详情请登录http://www.longwengui.net/');//发送短信给内部客服人员
                }
                alertandgotopage('操作成功!', '/index.php?Module=User&Action=UserDetail&UserID=' . $UserID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        if ($_GET['UserID']) {
            $UserID = $_GET['UserID'];
            $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID= '.$UserID);
            if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
            if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
            if ($UserInfo['Area'])
            $UserInfo['Area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
            $UserInfo['LastLogin'] = !empty($UserInfo['LastLogin'])? date('Y-m-d H:i:s',$UserInfo['LastLogin']): '';
            $UserInfo['AnnualDueDate'] = !empty($UserInfo['AnnualDueDate'])? date('Y-m-d H:i:s',$UserInfo['AnnualDueDate']): '';
            $User = $MemberUserModule->GetInfoByKeyID($UserID);
        }
        include template("UserDetail");
    }

}