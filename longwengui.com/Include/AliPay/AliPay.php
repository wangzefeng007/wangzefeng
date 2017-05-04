<?php
class AliPay {
    private $alipay_config=array();
    public function __construct() {
            //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm  2088912584072026
            $this->alipay_config['partner'] = '2088121216639966';
            
            //收款支付宝账号，一般情况下收款账号就是签约账号
            //$this->alipay_config['seller_email'] = 'info@57us.com';
            
            //收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
            $this->alipay_config['seller_id']= $this->alipay_config['partner'];

            // MD5密钥，安全检验码，由数字和字母组成的32位字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm  c2dstn2mjso8u78te87ofdnca6zlg2wp
            $this->alipay_config['key'] = 'zjce0doeelmdkssnej6jfvld4p5ewb1e';

            //签名方式
            $this->alipay_config['sign_type'] = strtoupper('MD5');

            //字符编码格式 目前支持 gbk 或 utf-8
            $this->alipay_config['input_charset']= strtolower('utf-8');

            //ca证书路径地址，用于curl中ssl校验
            //请保证cacert.pem文件在当前文件夹目录中
            $this->alipay_config['cacert'] = SYSTEM_ROOTPATH.'/Include/AliPay/cacert.pem';

            //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
            $this->alipay_config['transport']    = 'http';
       
    }
    
    public function SubmitOrder($payment_type,$notify_url='',$return_url='',$out_trade_no,$subject,$total_fee,$body,$show_url){
        require_once(SYSTEM_ROOTPATH."/Include/AliPay/alipay_submit.class.php");
        /**************************请求参数**************************/
            //支付类型
            //$payment_type = "1"; 必填，不能修改
            //服务器异步通知页面路径 $notify_url 需http://格式的完整路径，不能加?id=123这类自定义参数
            //页面跳转同步通知页面路径 $return_url
            //商户订单号 $out_trade_no 商户网站订单系统中唯一订单号，必填
            //订单名称 $subject 必填
            //付款金额 $total_fee 必填
            //订单描述 $body 
            //商品展示地址 $show_url  需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
            //防钓鱼时间戳  $anti_phishing_key  若要使用请调用类文件submit中的query_timestamp函数     
            //客户端的IP地址 $exter_invoke_ip 非局域网的外网IP地址，如：221.0.0.1
        /************************************************************/
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $parameter = array(
                "service"=> 'create_direct_pay_by_user',
                "partner"=>trim($this->alipay_config['partner']),
                "seller_id"=>trim($this->alipay_config['seller_id']),
                "payment_type"=>$payment_type,
                "notify_url"=>$notify_url,
                "return_url"=>$return_url,
                "out_trade_no"=>$out_trade_no,
                "subject"=>$subject,
                "total_fee"=>$total_fee,
                "body"=>$body,
                "show_url"=>$show_url,
                "anti_phishing_key"=>$alipaySubmit->query_timestamp(),
                "exter_invoke_ip"=>GetIP(),
                "_input_charset"=>trim(strtolower($this->alipay_config['input_charset']))
        );            
//        $logData['service']='create_direct_pay_by_user';
//        $logData['out_trade_no']=$out_trade_no;
//        $logData["subject"]=$subject;
//        $logData["total_fee"]=$total_fee;
//        $logData["body"]=$body;
//        $logData["time"]=date('Y-m-d');
//        $logData['ip']=$parameter['exter_invoke_ip'];
//        $logData['payType']="支付宝";
//        $logData['status']="创建订单";
//        $logJson=json_encode($logData);
//        @$handle=fopen(SYSTEM_ROOTPATH.'/Logs/AliPay/log.txt','a');   
//        @fwrite($handle,$logJson."\r\n");
//        @fclose($handle);
        echo $alipaySubmit->buildRequestForm($parameter,"post","确认");
        //var_dump($alipaySubmit->buildRequestHttp($parameter));
    }
    
    public function GetPayStatus($Result){
        require_once(SYSTEM_ROOTPATH."/Include/AliPay/alipay_notify.class.php");
         //计算得出通知验证结果
         $alipayNotify = new AlipayNotify($this->alipay_config);
         $verify_result = $alipayNotify->verifyReturn($Result);
         if($verify_result) {
             //验证成功
             /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
             //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
             //商户订单号
             $out_trade_no = $Result['out_trade_no'];
             //支付宝交易号
             $trade_no = $Result['trade_no'];
             //交易状态
             $trade_status = $Result['trade_status'];
             if($Result['trade_status'] == 'TRADE_FINISHED' || $Result['trade_status'] == 'TRADE_SUCCESS') {
                return 'true';
                //$logData['status']="支付成功";
             }else{
                return 'false';
                //$logData['status']=$Result['trade_status'];
             }
//            $logData['out_trade_no']=$out_trade_no;
//            $logData['trade_no'] = $trade_no;
//            $logData['ip']=GetIP();
//            $logData["time"]=date('Y-m-d');
//            $logData['payType']="支付宝";
//            $logJson=json_encode($logData);
//            @$handle=fopen(SYSTEM_ROOTPATH.'/Logs/AliPay/log.txt','a');   
//            @fwrite($handle,$logJson."\r\n");
//            @fclose($handle);
         }
         else {
             return 'false';
         }
    }
}
