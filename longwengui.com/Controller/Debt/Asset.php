<?php
/**
 * @desc  资产转让
 */
class Asset
{
    public function __construct() {

    }
    public function IsLogin()
    {
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }
    }
    /**
     * @desc  资产转让列表
     */
    public function Lists(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $Title ='隆文贵债务处置-资产转让';
        $Nav='asset';
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
        $this->IsLogin();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($_SESSION['UserID']);
        if ($UserInfo['IdentityState']!=3){
            alertandback("审核通过后的会员方可发布资产转让！");
        }
        $Nav='asset';
        $EndTime = time()+ 2592000;
        include template('AssetPublish');
    }
    /**
     * @desc  资产转让详情页
     */
    public function Details(){
        $Nav='asset';
        $ID = $_GET['ID'];
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($ID);
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$AssetInfo['AssetID'],true);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and ProductID = '.$AssetInfo['AssetID'],true);
        $TotalAmount =0;
        foreach ($OrderInfo as $value){
            $TotalAmount =$TotalAmount+ $value['TotalAmount'];
        }
        include template('AssetDetails');
    }
    /**
     * @desc  资产转让订单填写提交页
     */
    public function Order(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberShippingAddressModule = new MemberShippingAddressModule();
        $Nav='asset';
        $ID = $_GET['id'];
        $Num = $_GET['num'];
        $Money = $_GET['money'];
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($ID);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $ExpirationDate = ceil(($AssetInfo['ExpirationDate'] -time())/(3600*24));
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
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($OrderInfo['ProductID']);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $OrderInfo['Title'] = $AssetInfo['Title'];
        $OrderInfo['RealName'] = $UserInfo['RealName'];
        $GoToUrl = WEB_MAIN_URL . '/member/buyorderlist/';
        $Time = time();
        if ($OrderInfo && $OrderInfo['Status'] == 1) {
            if ($OrderInfo['ExpirationTime'] > $Time) {
                include template('AssetOrderPay');
            } else {
                $UpData['Status'] = 10;
                $UpData['Remarks'] = '订单超时未支付';
                $Result = $MemberProductOrderModule->UpdateInfoByKeyID($UpData, $OrderInfo['OrderID']);
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
                    $UserInfo = $MemberUserModule->GetUserIDbyMobile($OrderInfo['Tel']);
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
        $Type = trim($_GET['type']);
        $OrderID = trim($_GET['id']);
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $Order = $MemberProductOrderModule->GetInfoByKeyID($OrderID);
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($Order['ProductID']);
        $Data = array();
        if ($_POST){
            var_dump($_POST);exit;
        }
        if ($Order && $Order['Status'] == 1) {
            if ($Type == 'alipay') {
                $Data['OrderNo'] = $Order['OrderNumber'];
                $Data['Subject'] = html_entity_decode($AssetInfo['Title'], ENT_QUOTES);
                $Data['Money'] = $Order['TotalAmount'];
                $Data['Body'] = html_entity_decode($AssetInfo['Title'], ENT_QUOTES);
                $Data['ReturnUrl'] = WEB_MAIN_URL . '/pay/result/';
                $Data['NotifyUrl'] = WEB_MAIN_URL . '/pay/result/';
                $Data['ProductUrl'] = WEB_MAIN_URL . "/assetdetails/{$Order['ProductID']}.html";
                $Data['RunTime'] = time();
                $Data['Sign'] = ToolService::VerifyData($Data);
                echo ToolService::PostForm(WEB_MAIN_URL . '/pay/alipay/', $Data);
            } elseif ($Type == 'wxpay') {
                $Data['OrderNo'] = $Order['OrderNumber'];
                $Data['Subject'] = html_entity_decode($AssetInfo['Title'], ENT_QUOTES);
                $Data['Money'] = $Order['TotalAmount'];
                $Data['Body'] = html_entity_decode($AssetInfo['Title'], ENT_QUOTES);
                $Data['ReturnUrl'] = WEB_MAIN_URL . '/pay/result/';
                $Data['RunTime'] = time();
                $Data['Sign'] = ToolService::VerifyData($Data);
                $Sign = $Data['Sign'];
                unset($Data['Sign']);
                if ($Sign == ToolService::VerifyData($Data)) {
                    include SYSTEM_ROOTPATH . '/Include/WXPayTwo/WxPay.NativePay.php';
                    $notify = new NativePay();
                    $input = new WxPayUnifiedOrder();
                    $input->SetBody(stripslashes($Data['Subject'])); //必填
                    $input->SetDetail(stripslashes($Data['Body']));
                    $input->SetOut_trade_no($Data['OrderNo']); //必填
                    $input->SetTotal_fee($Data['Money']*100); //必填
                    $input->SetNotify_url(WEB_MAIN_URL . '/pay/wxpaynotify/'); //必填
                    $input->SetTrade_type("NATIVE");
                    $input->SetSpbill_create_ip(GetIP());
                    $input->SetProduct_id($Data['OrderNo']);
                    $result = $notify->GetPayUrl($input);
                    if ($result['code_img_url'] && $result['status']=='0') {
                        $ImageUrl = $result["code_img_url"];
                        $result_json = array('ResultCode'=>200,'Message'=>'返回成功','ImageUrl'=>$ImageUrl);
                        echo json_encode($result_json,JSON_UNESCAPED_UNICODE);exit;
                    }elseif ($result['err_msg']=='订单已支付'&& $result['result_code']=='1'){
                        //更新库存量
                        $MemberAssetInfoModule = new MemberAssetInfoModule();
                        $MemberAssetInfoModule->SetInventory($Order['AssetID'],$Order['Num']);
                        //添加订单日志
                        $OrderLogModule = new MemberOrderLogModule();
                        $LogMessage ='买家已付款，付款方式微信支付';
                        $LogData = array(
                            'OrderNumber' =>$Data['OrderNo'],
                            'UserID' => $_SESSION['UserID'],
                            'OldStatus' => 1,
                            'NewStatus' => 2,
                            'OperateTime' => date("Y-m-d H:i:s", time()),
                            'IP' => GetIP(),
                            'Remarks' => $LogMessage,
                            'Type' => 1
                        );
                        $LogResult = $OrderLogModule->InsertInfo($LogData);
                        //添加订单状态
                        $Date['PaymentMethod'] = '2';
                        $Date['Status'] = '2';
                        $MemberProductOrderModule->UpdateInfoByWhere($Date,' OrderNumber = \''.$Data['OrderNo'].'\'');//更新订单状态
                        $VerifyData['OrderNo'] = $Data['OrderNo'];
                        $VerifyData['Money'] = ($Data['Money']);
                        $VerifyData['PayType'] = "微信支付";
                        $VerifyData['ResultCode'] = 'SUCCESS';
                        $VerifyData['RunTime'] = time();
                        $VerifyData['RedirectUrl'] = WEB_MAIN_URL . '/orderdetail/'.$VerifyData['OrderNo'].'.html';
                        $VerifyData['Sign'] = ToolService::VerifyData($VerifyData);
                        $result_json = array('ResultCode'=>200,'Message'=>'支付成功','Url'=>WEB_MAIN_URL.'/pay/wxresult/?OrderNo='.$Data['OrderNo']);
                        EchoResult($result_json);
                    } else {
                        $result_json = array('ResultCode'=>102,'Message'=>'订单异常','Url'=>WEB_MAIN_URL);
                        EchoResult($result_json);
                    }
                    //判断支付成功返回支付成功结果页end
                } else {
                    $result_json = array('ResultCode'=>103,'Message'=>'异常的请求','Url'=>WEB_MAIN_URL);
                }
                EchoResult($result_json);exit;
            }
        } else {
            alertandback('不能操作的订单');
        }
    }
}