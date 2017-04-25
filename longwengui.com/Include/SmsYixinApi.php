<?php
/* *
 * 类名：SmsYixinApi
 * 功能：易信中科短信接口请求类
 */
class SmsYixinApi {
    public function yixinSMS($mobile,$content) {
        //您把发送账户和密码还有手机号，填上，直接运行就可以了
        //如果您的系统是utf-8,请转成GB2312 后，再提交、
        //请参考 'content'=>iconv( "UTF-8", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//短信内容
        header ( "Content-Type: textml; charset=UTF-8" );

        $flag = 0;
        $params = '';
        //要post的数据
        $argv = array ('zh' => '51349996', ////发送账户
            'mm' => '123123', //密码
            'hm' => '18039847468', //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'nr' => '您好测试短信[隆文贵网]', //iconv( "GB2312", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//'您好测试,短信测试[签名]',//短信内容
            'sms_type' => '52'//用户的通道ID
        );
        //构造要post的字符串

        foreach ( $argv as $key => $value ) {
            if ($flag != 0) {
                $params .= "&";
                $flag = 1;
            }
            $params .= $key . "=";
            $params .= urlencode ( $value ); // urlencode($value);
            $flag = 1;
        }
        $length = strlen ( $params );
        //创建socket连接
        $fp = fsockopen ( "60.205.93.144", 80, $errno, $errstr, 10 ) or exit ( $errstr . "--->" . $errno );
        //构造post请求的头
        $header = "POST /jk.aspx HTTP/1.1\r\n";
        $header .= "Host:60.205.93.144\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . $length . "\r\n";
        $header .= "Connection: Close\r\n\r\n";
        //添加post的字符串
        $header .= $params . "\r\n";
        //发送post的数据
        //echo $header;
        //exit;
        fputs ( $fp, $header );
        $inheader = 1;
        while ( ! feof ( $fp ) ) {
            $line = fgets ( $fp, 1024 ); //去除请求包的头只显示页面的返回数据
            if ($inheader && ($line == "\n" || $line == "\r\n")) {
                $inheader = 0;
            }
            if ($inheader == 0) {
                // echo $line;
            }
        }
        //<string xmlns="http://tempuri.org/">-5</string>
        $line = str_replace ( "<string xmlns=\"http://entinfo.cn/\">", "", $line );
        $line = str_replace ( "</string>", "", $line );
        $result = explode ( ":", $line );
        // echo $line."-------------";
        if ($result[0]=='0'){
            return "success";exit;
        }else{
            return '发送失败返回值为:' . $result[1] ;exit;
        }
    }
}
?>