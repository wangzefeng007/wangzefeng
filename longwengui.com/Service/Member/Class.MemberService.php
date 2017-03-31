<?php
/**
 * @desc 处理逻辑函数
 */
class MemberService
{
    /**
     * @desc  判断是否登录并返回登录页面
     */
    public static function IsLogin(){

        if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
            if ($_SESSION['Identity'] <=2){
                header('Location:' . WEB_MAIN_URL.'/memberperson/');
            }elseif($_SESSION['Identity'] ==3){
                header('Location:' . WEB_MAIN_URL.'/memberfirm/');
            }elseif($_SESSION['Identity'] ==4){
                header('Location:' . WEB_MAIN_URL.'/memberlawyer/');
            }
        }
    }

    /**
     * @desc  发送手机验证码，验证手机
     * @param $Mobile 手机号码
     */
    public static function SendMobileVerificationCode($Mobile)
    {
        $Data['Account'] = trim($Mobile);
        $Data['VerifyCode'] = mt_rand(1000, 9999);
        $Data['XpirationDate'] = Time() + 60 * 30;
        $Data ['Type'] = 0;
        $Authentication = new MemberAuthenticationModule ();
        $ID = $Authentication->searchAccount($Data ['Account']);
        if ($ID) {
            $result = $Authentication->UpdateUser($Data, $ID);
        } else {
            $result = $Authentication->InsertUser($Data);
        }
        if ($result) {
            $result1 = ToolService::SendSMSNotice($Data['Account'], '亲爱的隆文贵网用户,您的验证码为:' . $Data['VerifyCode'] . '。如非本人操作，请忽略。');
            if ($result1) {
                $json_result = array('ResultCode' => 200, 'Message' => '发送成功');
            } else {
                $json_result = array('ResultCode' => 103, 'Message' => '验证码发送失败,请重试');
            }
        } else {
            $json_result = array('ResultCode' => 104, 'Message' => '发送失败,系统异常');
        }
        return $json_result;
    }

}