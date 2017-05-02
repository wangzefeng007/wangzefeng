<?php
class ToolService {
    /**
     * @desc  发送短信通知
     * @param $Mobile
     * @param $Message
     * @return bool
     */
    public static function SendSMSNotice($Mobile,$Message){
        $Url = $_SERVER['HTTP_HOST'];
        if ( !strstr($Url, '.com')){
            return 0;
        }
        require_once SYSTEM_ROOTPATH . '/Include/SmsbaoApi.php';
        $smsapi = new SmsbaoApi ();
        $result = $smsapi->sendSMS ( $Mobile, '【隆文贵网】'.$Message);
        if ($result == "success") {
            return true;
        } else {
            return false;
        }

    }

    /**
     * @desac  发送邮箱通知
     * @param $EMail
     * @param $Title
     * @param $Message
     * @return bool
     */
    public static function SendEMailNotice($EMail,$Title,$Message){
        $Url = $_SERVER['HTTP_HOST'];
        if ( !strstr($Url, '.com')){
            return 0;
        }
        include SYSTEM_ROOTPATH . '/Include/smtp.class.php';
        $smtpserver = "smtp.mxhichina.com"; //SMTP服务器
        $smtpserverport = '25'; //SMTP服务器端口
        $smtpusermail = "57us.com@57us.com"; //SMTP服务器的用户邮箱
        $smtpemailto = "$EMail"; //发送给谁
        $smtpuser = "57us.com@57us.com"; //SMTP服务器的用户帐号
        $smtppass = "Admin12388857us.."; //SMTP服务器的用户密码
        $mailsubject = "$Title"; //邮件主题
        $mailbody = "<span>$Message</span>"; //邮件内容
        $mailtype = "HTML"; //邮件格式（HTML/TXT）,TXT为文本邮件
        $smtp = new smtp ( $smtpserver, $smtpserverport, true, $smtpuser, $smtppass ); //这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false; //是否显示发送的调试信息
        $rs = $smtp->sendmail ( $smtpemailto, $smtpusermail, $mailsubject, $mailbody, $mailtype );
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @desc  处理上传文件
     * @param $Module  模块名称study等
     * @param $Document 文档
     * @return string
     */
    public static function HandleUploadFile($Module,$Document){
        if(strpos($Document,'data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,')!==false ){
            $FileFullUrl='/file/'.$Module.'/'.date('Y').'/'.date('md').'/'.date('YmdHis').mt_rand(1000,9999).'.docx';
            SendToFileServ($FileFullUrl,str_replace('data:application/vnd.openxmlformats-officedocument.wordprocessingml.document;base64,','',$Document));
            $DocumentFile = $FileFullUrl;
        }
        elseif(strpos($Document,'data:text/plain;base64,')!==false ){
            $FileFullUrl='/file/'.$Module.'/'.date('Y').'/'.date('md').'/'.date('YmdHis').mt_rand(1000,9999).'.txt';
            SendToFileServ($FileFullUrl,str_replace('data:text/plain;base64,','',$Document));
            $DocumentFile = $FileFullUrl;
        }
        elseif(strpos($Document,'data:application/msword;base64,')!==false ){
            $FileFullUrl='/file/'.$Module.'/'.date('Y').'/'.date('md').'/'.date('YmdHis').mt_rand(1000,9999).'.doc';
            SendToFileServ($FileFullUrl,str_replace('data:application/msword;base64,','',$Document));
            $DocumentFile = $FileFullUrl;
        }
        elseif(strpos($Document,'data:application/x-zip-compressed;base64,')!==false ){
            $FileFullUrl='/file/'.$Module.'/'.date('Y').'/'.date('md').'/'.date('YmdHis').mt_rand(1000,9999).'.zip';
            SendToFileServ($FileFullUrl,str_replace('data:application/x-zip-compressed;base64,','',$Document));
            $DocumentFile = $FileFullUrl;
        }
        elseif(strpos($Document,'http://')!==false){
            $DocumentFile = $Document;
        }
        return $DocumentFile;
    }

    /**
     * @desc  产生随机码
     * @param int $length   长度
     * @param int $numeric  1-数字，2-字符串
     * @return string
     */
    public static function Random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ0123456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    /**
     * @desc  XML转换成数组
     * @param $xml
     * @return mixed
     */
    public static function XmlToArray($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return @$arr;
    }

    /**
     * @desc 请求地址
     * @param $url
     * @return mixed|string
     */
    public static function HttpsRequest($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
        curl_close($curl);
        return $data;
    }


    /**
     * @desc  计算几秒几分几天几月几年前
     * @param $Time
     * @return string
     *
     */
    public static function FormatDate($Time)
    {
        $T = time() - $Time;
        $F = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        foreach ($F as $key => $val) {
            if (0 != $C = floor($T / (int)$key)) {
                return $C . $val . '前';
            }
        }
    }

    /**
     * @desc  以表单方式发送
     * @param $Url
     * @param $Data
     */
    public static function PostForm($Url, $Data){
        $sHtml = "<form id='postform' name='postform' action='$Url' method='post'>";
        foreach ($Data as $key => $val) {
            $sHtml .= "<input type='hidden' name='$key' value='$val' />";
        }
        $sHtml = $sHtml . "</form>";
        $sHtml = $sHtml . "<script>document.forms['postform'].submit();</script>";
        return $sHtml;
    }

    /**
     * @desc  数据验证
     * @param $para
     * @return bool|string
     */
    public static function VerifyData($para)
    {
        if (!is_array($para)) {
            return false;
        } else {
            $arg = "";
            while (list ($key, $val) = each($para)) {
                $arg .= $key . "=" . $val . "&";
            }
            //去掉最后一个&字符
            $arg = substr($arg, 0, count($arg) - 2);
            //如果存在转义字符，那么去掉转义
            $arg = stripslashes($arg);
            $SignKey = '57us3cjq29vcu38cn2q0dj01d9c57is7';
            $sign = md5($arg . $SignKey);
            return $sign;
        }
    }

}