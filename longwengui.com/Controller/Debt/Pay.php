<?php

class Pay
{

    //支付宝
    public function AliPay()
    {
        $Sign = $_POST['Sign'];
        unset($_POST['Sign']);
        if ($Sign == ToolService::VerifyData($_POST)) {
            $notify_url = WEB_MEMBER_URL . '/pay/alipaynotify/';
            $return_url = WEB_MEMBER_URL . '/pay/alipaynotify/'; //必填
            $out_trade_no = $_POST['OrderNo']; //必填
            $subject = stripslashes($_POST['Subject']); //必填
            $total_fee = $_POST['Money']; //必填
            $body = stripslashes($_POST['Body']);
            $show_url = $_POST['ProductUrl'];
            $MemberOrderTempModule = new MemberOrderTempModule();
            $Data['OrderID'] = $out_trade_no;
            $Data['NotifyUrl'] = $_POST['ReturnUrl'];
            $Data['PayType'] = 0;
            $Data['CreateTime'] = time();
            $Data['ResultCode'] = 0;
            $OrderExists = $MemberOrderTempModule->GetOrderByID($Data['OrderID']);
            if (!$OrderExists) {
                $InsertResult = $MemberOrderTempModule->InsertInfo($Data);
            } else {
                if ($OrderExists['ResultCode'] == 1) {
                    alertandgotopage("该订单已支付完成!", WEB_MEMBER_URL);
                } else {
                    $InsertResult = $MemberOrderTempModule->UpdateData($Data, $Data['OrderID']);
                }
            }
            if ($InsertResult) {
                if($this->IsOrNotMobile()){
                    include SYSTEM_ROOTPATH.'/Include/Alipay/wap/AopSdk.php';
                    include SYSTEM_ROOTPATH.'/Include/Alipay/wap/AopSdk.php';
                    $aop = new AopClient();
                    $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
                    $aop->appId = '2016092601971945';
                    $aop->rsaPrivateKeyFilePath = SYSTEM_ROOTPATH.'/Include/Alipay/wap/rsa_private_key.pem';
                    $aop->alipayPublicKey=SYSTEM_ROOTPATH.'/Include/Alipay/wap/rsa_public_key.pem';
                    $aop->apiVersion = '1.0';
                    $aop->postCharset='utf-8';
                    $aop->format='json';
                    $request = new AlipayTradeWapPayRequest ();
                    $JsonData['body']=$body;
                    $JsonData['subject']=$subject;
                    $JsonData['out_trade_no']=$out_trade_no;
                    $JsonData['total_amount']=$total_fee;
                    $JsonData['product_code']="QUICK_WAP_PAY";
                    $request->setReturnUrl(WEB_MEMBER_URL . '/pay/wapalipayreturn/');
                    $request->setNotifyUrl(WEB_MEMBER_URL . '/pay/wapalipaynotify/');
                    $request->setBizContent(json_encode($JsonData));
                    $result = $aop->pageExecute ( $request);
                    echo $result;
                }else{
                    include SYSTEM_ROOTPATH.'/Include/AliPay/AliPay.php';
                    $AliPay = new AliPay();
                    $AliPay->SubmitOrder(1, $notify_url, $return_url, $out_trade_no, $subject, $total_fee, $body, $show_url);
                }
            } else {
                alertandgotopage('订单支付出现异常,请重新尝试', WEB_MEMBER_URL);
            }
        } else {
            alertandgotopage('异常的请求', WEB_MEMBER_URL);
        }
    }

    //支付宝手机支付异步
    public function WapAliPayNotify(){
        include './alipay/AopSdk.php';
        $aop = new AopClient();
        $aop->alipayPublicKey=SYSTEM_ROOTPATH.'/Include/Alipay/wap/rsa_public_key.pem';
        //公钥
        //$aop->alipayrsaPublicKey="MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB";
        if($aop->rsaCheckV1($_POST,SYSTEM_ROOTPATH.'/Include/Alipay/wap/rsa_public_key.pem')==1){
            //验证通过
            if($_POST['trade_status']=='TRADE_SUCCESS'){
                $MemberOrderTempModule = new MemberOrderTempModule();
                $Data['ResultCode'] = 1;
                $Data['Money'] = trim($_POST['total_amount']);
                $Result=$MemberOrderTempModule->UpdateData($Data, trim($_POST['out_trade_no']));
                if($Result){
                    $OrderInfo = $MemberOrderTempModule->GetOrderByID(trim($_POST['out_trade_no']));
                    if ($OrderInfo) {
                        $VerifyData['OrderNo'] = trim($_POST['out_trade_no']);
                        $VerifyData['Money'] = $OrderInfo['Money'];
                        $VerifyData['PayType'] = "支付宝";
                        $VerifyData['ResultCode'] = 'SUCCESS';
                        $VerifyData['RunTime'] = time();
                        $VerifyData['Sign'] = ToolService::VerifyData($VerifyData);
                        $NotifyUrl = rtrim($OrderInfo['NotifyUrl'], '/') . '/?' . http_build_query($VerifyData);
                        @file_get_contents($NotifyUrl);
                    }
                }
            }
        }
    }
    //支付宝回调
    public function AliPayNotify()
    {var_dump($_GET);exit;
        include SYSTEM_ROOTPATH.'/Include/Alipay/AliPay.php';
        $AliPay = new AliPay();
        if (count($_POST)) {var_dump($_POST);exit;
            if ($AliPay->GetPayStatus($_POST) === 'true') {
                $MemberOrderTempModule = new MemberOrderTempModule();
                $Data['ResultCode'] = 1;
                $Data['Money'] = trim($_POST['total_fee']);
                $MemberOrderTempModule->UpdateData($Data, trim($_POST['out_trade_no']));
                $OrderInfo = $MemberOrderTempModule->GetOrderByID(trim($_POST['out_trade_no']));
                if ($OrderInfo) {
                    $VerifyData['OrderNo'] = trim($_POST['out_trade_no']);
                    $VerifyData['Money'] = $OrderInfo['Money'];
                    $VerifyData['PayType'] = "支付宝";
                    $VerifyData['ResultCode'] = 'SUCCESS';
                    $VerifyData['RunTime'] = time();
                    $VerifyData['Sign'] = ToolService::VerifyData($VerifyData);
                    $NotifyUrl = rtrim($OrderInfo['NotifyUrl'], '/') . '/?' . http_build_query($VerifyData);
                    @file_get_contents($NotifyUrl);
                } else {
                    header("Location:/pay/result/");
                }
            } else {
                header("Location:/pay/result/");
            }
        } else {var_dump($_GET);
            if ($AliPay->GetPayStatus($_GET) === 'true') {
                $MemberOrderTempModule = new MemberOrderTempModule();
                $Data['ResultCode'] = 1;
                $Data['Money'] = trim($_GET['total_fee']);
                $MemberOrderTempModule->UpdateData($Data, trim($_GET['out_trade_no']));
                $OrderInfo = $MemberOrderTempModule->GetOrderByID(trim($_GET['out_trade_no']));
                if ($OrderInfo) {
                    $VerifyData['OrderNo'] = trim($_GET['out_trade_no']);
                    $VerifyData['Money'] = $OrderInfo['Money'];
                    $VerifyData['PayType'] = "支付宝";
                    $VerifyData['ResultCode'] = 'SUCCESS';
                    $VerifyData['RunTime'] = time();
                    $VerifyData['Sign'] = ToolService::VerifyData($VerifyData);
                    header("Location:" . rtrim($OrderInfo['NotifyUrl'], '/') . '/?' . http_build_query($VerifyData));
                } else {
                    header("Location:/pay/result/");
                }
            } else {
                header("Location:/pay/result/");
            }
        }
    }
    //支付成功提示
    public function Result()
    {
        $sign = $_POST['Sign'];
        if (isset($_POST['Message'])) {
            $Message = stripcslashes($_POST['Message']);
            unset($_POST['Message']);
        }
        unset($_POST['Sign']);
        $VerifySign = ToolService::VerifyData($_POST);
        if ($VerifySign == $sign) {
            $PayResult = $_POST['PayResult'];
            if ($PayResult == 'SUCCESS') {
                $OrderNo = $_POST['OrderNo'];
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

/*
 * 识别是不是手机端
 */
    function IsOrNotMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }
}