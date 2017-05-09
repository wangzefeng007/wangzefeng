<?php
/**
 * @desc  资产转让
 */
class Asset
{
    public function __construct() {

    }
    /**
     * @desc  资产转让列表
     */
    public function Lists(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $Title ='隆文贵债务处置-资产转让';
        $Nav='transfer';
        $S = intval($_GET['S']);
        $Keywords = trim($_GET['K']);
        if ($S ==1){
            $MysqlWhere = ' and `Status` = 2 and `S1` =1 ';
        }elseif($S ==2){
            $MysqlWhere = ' and `Status` = 2 and `S1` =2 ';
        }else{
            $MysqlWhere = ' and `Status` = 2 ';
        }
        if ($Keywords!=''){
            $MysqlWhere .= ' and Title like \'%' . $Keywords . '%\'';
        }
        //分页查询开始-------------------------------------------------
        $MysqlWhere .= ' order by AddTime desc';
        //关键字
        $Rscount = $MemberAssetInfoModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=9;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberAssetInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $AssetImage = $MemberAssetImageModule->GetInfoByWhere(" and AssetID = ".$value['AssetID'].' and IsDefault = 1');
                $UserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
                $Data['Data'][$key]['ImageUrl'] = $AssetImage['ImageUrl'];
                $Data['Data'][$key]['RealName'] = $UserInfo['RealName'];
                $Data['Data'][$key]['Avatar'] = $UserInfo['Avatar'];
                $Data['Data'][$key]['AddTime'] = date('m'.'月'.'d'.'日',$value['AddTime']);
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('AssetLists');
    }
    /**
     * @desc  发布资产转让
     */
    public function Publish(){
        MemberService::IsLogin();
        $Nav='transfer';
        $EndTime = time()+ 2592000;
        include template('AssetPublish');
    }
    /**
     * @desc  资产转让详情页
     */
    public function Details(){
        $Nav='transfer';
        $ID = $_GET['ID'];
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($ID);
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$AssetInfo['AssetID'],true);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        include template('AssetDetails');
    }
    /**
     * @desc  资产转让订单填写提交页
     */
    public function Order(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberShippingAddressModule = new MemberShippingAddressModule();
        $Nav='transfer';
        $ID = $_GET['id'];
        $Num = $_GET['num'];
        $Money = $_GET['money'];
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($ID);
        $AmountMoney =number_format($AssetInfo['AssetsAmount']-$Money, 2);//剩余资产金额
        $TotalAmount =number_format($Money+$AssetInfo['Freight'], 2);//合计金额
        $AddressList = $MemberShippingAddressModule->GetInfoByWhere(' and UserID ='.$_SESSION['UserID'],true);
        if (!empty($AddressList)){
            $MemberAreaModule = new MemberAreaModule();
            foreach ($AddressList as $key=>$value){
                $AddressList[$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($value['Province']);
                $AddressList[$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($value['City']);
                $AddressList[$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($value['Area']);
        }
        }
        include template('AssetOrder');
    }
    /**
     * 选择支付页
     */
    public function ChoicePay()
    {
        $Title = '订单支付';
        $OrderNumber = $_GET['OrderNumber'];
        $MemberProductOrderModule = new MemberProductOrderModule();
        $Order = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        $GoToUrl = WEB_MAIN_URL . '/assetdetails/' . $Order['ProductID'] . '.html';
        if ($Order && $Order['Status'] == 1) {
            if ($Order['ExpirationTime'] > time()) {
                include template('AssetOrderPay');
            } else {
                $UpData['Status'] = 10;
                $UpData['Remarks'] = '订单超时未支付';
                $Result = $MemberProductOrderModule->UpdateInfoByKeyID($UpData, $Order['OrderID']);
                if ($Result) {
                    $LogMessage = '操作失败(超时状态更新失败)';
                } else {
                    $LogMessage = '超时未支付,订单取消';
                }
                // 添加订单状态更改日志
                $OrderLogModule = new MemberOrderLogModule();
                if ($_SESSION['UserID'] && ! empty($_SESSION['UserID'])) {
                    $UserID = $_SESSION['UserID'];
                } else {
                    $MemberUserModule = new MemberUserModule();
                    $UserInfo = $MemberUserModule->GetUserIDbyMobile($Order['Tel']);
                    $UserID = $UserInfo['UserID'];
                }
                $LogData = array(
                    'OrderNumber' => $OrderNumber,
                    'UserID' => $UserID,
                    'OldStatus' => 1,
                    'NewStatus' => 10,
                    'OperateTime' => date("Y-m-d H:i:s", time()),
                    'IP' => GetIP(),
                    'Remarks' => $LogMessage,
                    'Type' => 1
                );
                $LogResult = $OrderLogModule->InsertInfo($LogData);
                alertandgotopage('订单超时未支付', $GoToUrl);
            }
        } else {
            alertandgotopage('不能操作的订单', $GoToUrl);
        }
    }
    /**
     * 准备支付
     */
    public function Pay()
    {
        $Type = trim($_GET['Type']);
        $OrderID = trim($_GET['ID']);
        $MemberProductOrderModule = new MemberProductOrderModule();
        $Order = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
        $Data = array();
        if ($Order && $Order['Status'] == 1) {
            if ($Type == 'alipay') {

                $Data['Sign'] = ToolService::VerifyData($Data);
                echo ToolService::PostForm(WEB_MAIN_URL . '/pay/alipay/', $Data);
            } elseif ($Type == 'wxpay') {

                $Data['Sign'] = ToolService::VerifyData($Data);
                echo ToolService::PostForm(WEB_MAIN_URL . '/pay/wxpay/', $Data);
            }
        } else {
            alertandback('不能操作的订单');
        }
    }
}