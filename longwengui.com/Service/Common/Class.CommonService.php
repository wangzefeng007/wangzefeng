<?php

Class CommonService{

    /**
     * @desc  发送手机验证码，验证手机
     */
    public static function SendMobileVerificationCode($Mobile)
    {
        $Data['Account'] = trim($Mobile);
        $Data['VerifyCode'] = mt_rand(100000, 999999);
        $Data['XpirationDate'] = Time() + 60 * 30;
        $Data ['Type'] = 0;
        $Authentication = new MemberAuthenticationModule ();
        $ID = $Authentication->GetInfoByWhere(' and Account=\''.$Data ['Account'].'\'');
        if ($ID) {
            $result = $Authentication->UpdateInfoByKeyID($Data, $ID);
        } else {
            $result = $Authentication->InsertInfo($Data);
        }
        if ($result) {
            $result1 = ToolService::SendSMSNotice($Data['Account'],'亲爱的57美国网用户,您认证的验证码为:' . $Data['VerifyCode'] . '。如非本人操作，请忽略。');
            if ($result1) {
                $json_result = array('ResultCode' => 200, 'Message' => '发送成功');
            } else {
                $json_result = array('ResultCode' => 100, 'Message' => '验证码发送失败,请重试');
            }
        } else {
            $json_result = array('ResultCode' => 100, 'Message' => '发送失败,系统异常');
        }
        echo json_encode($json_result);
    }

}

