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
    public function Index(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        include template('AssetIndex');
    }
    /**
     * @desc  发布资产转让
     */
    public function Publish(){
        include template('AssetPublish');
    }
    /**
     * @desc  发布资产转让成功待审核页面
     */
    public function Audit(){
        include template('AssetAudit');
    }
    /**
     * @desc  资产转让详情页
     */
    public function Details(){
        $ID = $_GET['ID'];
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($ID);
        if ($AssetInfo['Status']!=2){
            alertandback("该资产未审核通过！");
        }
        $AssetImage = $MemberAssetImageModule->GetInfoByWhere(' and AssetID = '.$AssetInfo['AssetID'],true);
        $UserInfo = $MemberUserInfoModule->GetInfoByUserID($AssetInfo['UserID']);
        $MemberUser = $MemberUserModule->GetInfoByKeyID($AssetInfo['UserID']);
        $UserInfo['Mobile'] =$MemberUser['Mobile'];
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and `Status` > 1 and ProductID = '.$AssetInfo['AssetID'],true);
        $TotalAmount =0;
        foreach ($OrderInfo as $value){
            $TotalAmount =$TotalAmount+ $value['TotalAmount'];
        }
        include template('AssetDetails');
    }
    /**
     * @desc  订单填写页
     */
    public function  Order(){
        MService::IsNoLogin();
//        if ($_SESSION ['Identity']!=1 && $_SESSION['Identity']!=2){
//            alertandback("个人会员和催客方可购买商品！");
//        }
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
        $GoToUrl = WEB_M_URL . '/member/buyorderlist/';
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
                $Data['ReturnUrl'] = WEB_M_URL . '/pay/result/';
                $Data['NotifyUrl'] = WEB_M_URL . '/pay/result/';
                $Data['ProductUrl'] = WEB_M_URL . "/assetdetails/{$Order['ProductID']}.html";
                $Data['RunTime'] = time();
                $Data['Sign'] = ToolService::VerifyData($Data);
                echo ToolService::PostForm(WEB_M_URL . '/pay/alipay/', $Data);
            } elseif ($Type == 'wxpay') {
                $Data['OrderNo'] = $Order['OrderNumber'];
                $Data['Subject'] = html_entity_decode($AssetInfo['Title'], ENT_QUOTES);
                $Data['Money'] = $Order['TotalAmount'];
                $Data['Body'] = html_entity_decode($AssetInfo['Title'], ENT_QUOTES);
                $Data['ReturnUrl'] = WEB_M_URL . '/pay/result/';
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
                    $input->SetNotify_url(WEB_M_URL . '/pay/wxpaynotify/'); //必填
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
                        $MemberAssetInfoModule->SetInventory($Order['ProductID'],$Order['Num']);
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
                        $VerifyData['RedirectUrl'] = WEB_M_URL . '/orderdetail/'.$VerifyData['OrderNo'].'.html';
                        $VerifyData['Sign'] = ToolService::VerifyData($VerifyData);
                        $result_json = array('ResultCode'=>200,'Message'=>'支付成功','Url'=>WEB_M_URL.'/pay/wxresult/?OrderNo='.$Data['OrderNo']);
                        EchoResult($result_json);
                    } else {
                        $result_json = array('ResultCode'=>102,'Message'=>'订单异常','Url'=>WEB_M_URL);
                        EchoResult($result_json);
                    }
                    //判断支付成功返回支付成功结果页end
                } else {
                    $result_json = array('ResultCode'=>103,'Message'=>'异常的请求','Url'=>WEB_M_URL);
                }
                EchoResult($result_json);exit;
            }
        } else {
            alertandback('不能操作的订单');
        }
    }
}