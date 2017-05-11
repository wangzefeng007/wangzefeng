<?php

class Pay
{
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
                        $VerifyData['Sign'] = $this->VerifyData($VerifyData);
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
}