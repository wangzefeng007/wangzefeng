<?php

/**
 *@desc  资产订单管理
 */
class AssetOrder
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  资产订单列表
     */
    public function Lists()
    {
        $MemberProductOrderModule = new MemberProductOrderModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $StatusInfo = $MemberProductOrderModule->Status;
        $PaymentMethod = $MemberProductOrderModule->PaymentMethod;
        $MysqlWhere = '';
        $PageSize = 10;
        $PageUrl = '';
        $Title = $_GET['Title'];
        if ($Title) {
            //标题/订单ID/订单编号
            $MysqlWhere .= ' and (OrderID=\'' . $Title . '\' or OrderNumber like \'%' . $Title . '%\')';
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
            tourl('/index.php?Module=AssetOrder&Action=Lists&Page=' . $page . $PageUrl);
        }
        $Page = intval($_GET['Page']) ? intval($_GET['Page']) : 1;
        $ListsNum = $MemberProductOrderModule->GetListsNum($MysqlWhere);
        $Rscount = $ListsNum ['Num'];
        if ($Rscount) {
            $Data ['RecordCount'] = $Rscount;
            $Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
            $Data ['PageCount'] = ceil($Data ['RecordCount'] / $PageSize);
            if ($Page > $Data ['PageCount'])
                $Page = $Data ['PageCount'];
            $Data ['Page'] = min($Page, $Data ['PageCount']);
            $Offset = ($Page - 1) * $Data ['PageSize'];
            $Data['Data'] = $MemberProductOrderModule->GetLists($MysqlWhere, $Offset, $Data ['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $Data['Data'][$key]['AddTime'] = date("Y-m-d H:i:s",$value['AddTime']);
                $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID = '.$value['UserID']);
                $Data['Data'][$key]['RealName'] = $UserInfo['RealName'];
            }
            MultiPage($Data, 10);
        }
        include template('AssetOrderLists');
    }
    /**
     * @desc  资产订单详情
     */
    public function Detail(){
        $MemberProductOrderModule = new MemberProductOrderModule();
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        if ($_POST['Status']){
            $Status = intval($_POST['Status']);
            $OrderID = $_POST['OrderID'];
            $Result =  $MemberProductOrderModule->UpdateInfoByKeyID(array('Status'=>$Status),$OrderID);
            if ($Result){
                alertandback('操作成功!');
            }else{
                alertandback('操作失败!');
            }
        }
        $StatusInfo = $MemberProductOrderModule->Status;
        $PaymentMethod = $MemberProductOrderModule->PaymentMethod;
        $OrderID = intval($_GET['OrderID']);
        $OrderInfo = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);
        include template('AssetOrderDetail');
    }
}