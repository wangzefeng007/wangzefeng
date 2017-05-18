<?php

class Pay
{

    //支付宝
    public function AliPay()
    {
        $Sign = $_POST['Sign'];
        unset($_POST['Sign']);
        if ($Sign == ToolService::VerifyData($_POST)) {
            $notify_url = WEB_MAIN_URL . '/pay/alipaynotify/';
            $return_url = WEB_MAIN_URL . '/pay/alipaynotify/'; //必填
            $out_trade_no = $_POST['OrderNo']; //必填
            $subject = stripslashes($_POST['Subject']); //必填
            $total_fee = $_POST['Money']; //必填
            $body = stripslashes($_POST['Body']);
            $show_url = $_POST['ProductUrl'];
            $MemberProductOrderModule = new MemberProductOrderModule;
            $Result = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$out_trade_no.'\'');
            if ($Result) {
                if ($Result['Status']==1){
                    include SYSTEM_ROOTPATH.'/Include/AliPay/AliPay.php';
                    $AliPay = new AliPay();
                    $AliPay->SubmitOrder(1, $notify_url, $return_url, $out_trade_no, $subject, $total_fee, $body, $show_url);
                }else{
                    alertandgotopage('该订单已支付完成!', WEB_MAIN_URL);
                }
            }else {
                alertandgotopage('订单支付出现异常,请重新尝试', WEB_MAIN_URL);
            }
        }else {
            alertandgotopage('异常的请求', WEB_MAIN_URL);
        }
    }

    //支付宝回调
    public function AliPayNotify()
    {
        $MemberProductOrderModule = new MemberProductOrderModule;
        include SYSTEM_ROOTPATH.'/Include/Alipay/AliPay.php';
        $AliPay = new AliPay();
        $ResultUrl = WEB_MAIN_URL . '/pay/result/';
        if (count($_POST)) {
            if ($AliPay->GetPayStatus($_POST) === 'true') {
                $OrderNumber = trim($_POST['out_trade_no']);
                $OrderInfo = $MemberProductOrderModule ->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
                if ($OrderInfo) {
                    //更新库存
                    $MemberAssetInfoModule = new MemberAssetInfoModule();
                    $MemberAssetInfoModule->SetInventory($OrderInfo['ProductID'],$OrderInfo['Num']);
                    //添加订单日志
                    $OrderLogModule = new MemberOrderLogModule();
                    $LogMessage ='买家已付款，付款方式支付宝';
                    $LogData = array(
                        'OrderNumber' =>$OrderInfo['OrderNumber'],
                        'UserID' => $_SESSION['UserID'],
                        'OldStatus' => 1,
                        'NewStatus' => 2,
                        'OperateTime' => date("Y-m-d H:i:s", time()),
                        'IP' => GetIP(),
                        'Remarks' => $LogMessage,
                        'Type' => 1
                    );
                    $LogResult = $OrderLogModule->InsertInfo($LogData);
                    //更新订单状态
                    $Data['PaymentMethod'] = '1';
                    $Data['Status'] = '2';
                    $MemberProductOrderModule->UpdateInfoByWhere($Data,' OrderNumber = \''.$OrderNumber.'\'');
                    $VerifyData['OrderNo'] = trim($_POST['out_trade_no']);
                    $VerifyData['Money'] = $OrderInfo['Money'];
                    $VerifyData['ResultCode'] = 'SUCCESS';
                    $VerifyData['RunTime'] = time();
                    $VerifyData['RedirectUrl'] = WEB_MAIN_URL . '/orderdetail/'.$VerifyData['OrderNo'].'.html';
                    $VerifyData['Sign'] = ToolService::VerifyData($VerifyData);
                    echo ToolService::PostForm($ResultUrl, $VerifyData);
                } else {
                    header("Location:/pay/result/");
                }
            } else {
                header("Location:/pay/result/");
            }
        } else {
            if ($AliPay->GetPayStatus($_GET) === 'true') {

                $OrderNumber = trim($_GET['out_trade_no']);
                $OrderInfo = $MemberProductOrderModule ->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
                if ($OrderInfo) {
                    $Data['PaymentMethod'] = '1';
                    $Data['Status'] = '2';
                    $MemberProductOrderModule->UpdateInfoByWhere($Data,' OrderNumber = \''.$OrderNumber.'\'');//更新订单状态
                    $VerifyData['OrderNo'] = trim($_GET['out_trade_no']);
                    $VerifyData['Money'] = $OrderInfo['Money'];
                    $VerifyData['PayResult'] = 'SUCCESS';
                    $VerifyData['RunTime'] = time();
                    $VerifyData['RedirectUrl'] = WEB_MAIN_URL . '/orderdetail/'.$VerifyData['OrderNo'].'.html';
                    $VerifyData['Sign'] = ToolService::VerifyData($VerifyData);
                    echo ToolService::PostForm($ResultUrl, $VerifyData);
                } else {
                    header("Location:/pay/result/");
                }
            } else {
                header("Location:/pay/result/");
            }
        }
    }
    /**
     * @desc 微信支付
     */
    public function WXPay()
    {
        $Sign = $_POST['Sign'];
        unset($_POST['Sign']);
        if ($Sign == ToolService::VerifyData($_POST)) {
            include SYSTEM_ROOTPATH . '/Include/WXPayTwo/WxPay.NativePay.php';
            $notify = new NativePay();
            $input = new WxPayUnifiedOrder();
            $input->SetBody(stripslashes($_POST['Subject'])); //必填
            $input->SetDetail(stripslashes($_POST['Body']));
            $input->SetOut_trade_no($_POST['OrderNo']); //必填
            $input->SetTotal_fee($_POST['Money']*100); //必填
            $input->SetNotify_url(WEB_MAIN_URL . '/pay/wxpaynotify/'); //必填
            $input->SetTrade_type("NATIVE");
            $input->SetSpbill_create_ip(GetIP());
            $input->SetProduct_id($_POST['OrderNo']);
            $result = $notify->GetPayUrl($input);
            if ($result['code_img_url']) {
//                    $WXPayUrl= $result['code_url'];
//                    $WXPayUrl = "http://paysdk.weixin.qq.com/example/qrcode.php?data=" . urlencode($WXPayUrl);
                $ImageUrl = $result["code_img_url"];
                $result_json = array('ResultCode'=>200,'Message'=>'返回成功','ImageUrl'=>$ImageUrl);
            } else {
                $result_json = array('ResultCode'=>102,'Message'=>'订单异常','Url'=>WEB_MAIN_URL);
                alertandgotopage('订单异常', WEB_MAIN_URL);
            }
        } else {
            $result_json = array('ResultCode'=>103,'Message'=>'异常的请求','Url'=>WEB_MAIN_URL);
        }
        EchoResult($result_json);exit;
    }
    //支付成功提示
    public function Result()
    {
        $sign = $_POST['Sign'];
        unset($_POST['Sign']);
        $VerifySign = ToolService::VerifyData($_POST);
        if ($VerifySign == $sign) {
            $PayResult = $_POST['PayResult'];
            if ($PayResult == 'SUCCESS') {
                $OrderNumber = $_POST['OrderNo'];
                $Money = $_POST['Money'];
                $RedirectUrl = $_POST['RedirectUrl'];
                include template('PayResultSUCCESS');
            } else {
                include template('PayResultFAIL');
            }
        } else {
            include template('PayResultFAIL');
        }
    }
    //支付成功提示
    public function WxResult()
    {
        $OrderNumber = $_GET['OrderNo'];
        $MemberProductOrderModule = new MemberProductOrderModule();
        $OrderInfo = $MemberProductOrderModule->GetInfoByWhere(' and OrderNumber = \''.$OrderNumber.'\'');
        if ($OrderInfo && $OrderInfo['Status']==2) {
            $Money = $OrderInfo['TotalAmount'];
            $RedirectUrl = WEB_MAIN_URL . '/orderdetail/'.$OrderNumber.'.html';
            include template('PayResultSUCCESS');
        } else {
            include template('PayResultFAIL');
        }
    }
}