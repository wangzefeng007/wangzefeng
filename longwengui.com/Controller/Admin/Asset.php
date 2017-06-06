<?php
/**
 *@desc  资产转让管理
 */
class Asset
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  添加或更新资产转让
     */
    public function Add()
    {
        alertandback('待开发');exit;
        include template('AssetAdd');
    }
    /**
     * @desc  资产信息列表
     */
    public function Lists()
    {
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $NStatus = $MemberAssetInfoModule->NStatus;
        $MysqlWhere = '';
        $PageSize = 10;
        $PageUrl = '';
        $Title = trim($_GET['Title']);
        if ($Title) {
            //"标题/资产ID/资产单号
            $MysqlWhere .= ' and (AssetMember=\'' . $Title . '\' or AssetID like \'%' . $Title . '%\' or concat(Title) like \'%' . $Title . '%\')';
            $PageUrl .= " and `Title` = $Title";
        }
        $Status  = $_GET['Status'];
        if ($Status) {
            $MysqlWhere .= " and `Status` = $Status";
            $PageUrl .= "&Status=$Status";
        }
        // 跳转到该页面
        if ($_POST['Page']) {
            $page = $_POST['Page'];
            tourl('/index.php?Module=Asset&Action=Lists&Page=' . $page . $PageUrl);
        }
        $Page = intval($_GET['Page']) ? intval($_GET['Page']) : 1;
        $ListsNum = $MemberAssetInfoModule->GetListsNum($MysqlWhere);
        $Rscount = $ListsNum ['Num'];
        if ($Rscount) {
            $Data ['RecordCount'] = $Rscount;
            $Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
            $Data ['PageCount'] = ceil($Data ['RecordCount'] / $PageSize);
            if ($Page > $Data ['PageCount'])
                $Page = $Data ['PageCount'];
            $Data ['Page'] = min($Page, $Data ['PageCount']);
            $Offset = ($Page - 1) * $Data ['PageSize'];
            $Data['Data'] = $MemberAssetInfoModule->GetLists($MysqlWhere, $Offset, $Data ['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $Data['Data'][$key]['AddTime'] = date("Y-m-d H:i:s",$value['AddTime']);
                $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID = '.$value['UserID']);
                $Data['Data'][$key]['RealName'] = $UserInfo['RealName'];
            }
            MultiPage($Data, 10);
        }
        include template('AssetLists');
    }
    /**
     * @desc  资产订单详情
     */
    public function Detail(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $StatusInfo = $MemberAssetInfoModule->NStatus;
        $ProductStatus = $MemberAssetInfoModule->ProductStatus;
        if ($_POST['AssetID']) {
            $Data['ProductStatus'] = intval($_POST['ProductStatus']);
            $Data['Status'] = intval($_POST['Status']);
            $AssetID = intval($_POST['AssetID']);
            $result = $MemberAssetInfoModule->UpdateInfoByWhere($Data, ' AssetID= ' . $AssetID);
            if ($result) {
                alertandgotopage('操作成功!', '/index.php?Module=Asset&Action=Detail&AssetID='.$AssetID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        $AssetID = intval($_GET['AssetID']);
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($AssetID);
        $AssetImage = $MemberAssetImageModule->UpdateInfoByWhere(' and AssetID = '.$AssetID,true);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        include template('AssetDetail');
    }
    /**
     * @desc  删除资产转让
     */
    public function Delete()
    {
        $TourAreaModule = new TourAreaModule();
        $AreaID = $_GET['AreaID'];
        $TourAreaModules = $TourAreaModule->DeleteByKeyID($AreaID);
        if (!$TourAreaModules) {
            alertandgotopage("删除失败", '/index.php?Module=TourArea&Action=TourAreaList');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=TourArea&Action=TourAreaList');
        }
    }
}