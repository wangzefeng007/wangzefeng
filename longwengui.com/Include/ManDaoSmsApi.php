<?php
/* *
 * 类名：ManDaoSmsApi
 * 功能：漫道接口请求类
 */
class ManDaoSmsApi {
        public function sendSMS($mobile,$content) {
            //您把序列号和密码还有手机号，填上，直接运行就可以了
            //如果您的系统是utf-8,请转成GB2312 后，再提交、
            //请参考 'content'=>iconv( "UTF-8", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//短信内容
            header ( "Content-Type: textml; charset=UTF-8" );

            $flag = 0;
            $params = '';
            //要post的数据 
            $argv = array ('sn' => 'SDK-WSS-010-09388', ////替换成您自己的序列号
            'pwd' => strtoupper ( md5 ( 'SDK-WSS-010-09388'.'^c8-^a57' ) ), //此处密码需要加密 加密方式为 md5(sn+password) 32位大写
            'mobile' => $mobile, //手机号 多个用英文的逗号隔开 post理论没有长度限制.推荐群发一次小于等于10000个手机号
            'content' => $content, //iconv( "GB2312", "gb2312//IGNORE" ,'您好测试短信[XXX公司]'),//'您好测试,短信测试[签名]',//短信内容
            'ext' => '', 'stime' => '', //定时时间 格式为2011-6-29 11:09:21
            'msgfmt' => '', 'rrid' => '' );
                        //构造要post的字符串 
                        //echo $argv['content'];
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
                        $fp = fsockopen ( "sdk.entinfo.cn", 8061, $errno, $errstr, 10 ) or exit ( $errstr . "--->" . $errno );
                        //构造post请求的头 
                        $header = "POST /webservice.asmx/mdsmssend HTTP/1.1\r\n";
                        $header .= "Host:sdk.entinfo.cn\r\n";
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
                        $result = explode ( "-", $line );           
                        // echo $line."-------------";
                        if (count ( $result ) > 1){
                               return '发送失败返回值为:' . $line . '。请查看webservice返回值对照表';exit;
                        }else{
                               return "success";
                        }
                }      
}
?>