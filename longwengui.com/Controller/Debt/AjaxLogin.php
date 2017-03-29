<?php
/**
 * @desc 会员中心登陆、注册、忘记密码
 * Class AjaxLogin
 */
class AjaxLogin
{
    public function Index()
    {
        $Intention = trim($_POST['Intention'])?trim($_POST['Intention']):trim($_GET['Intention']);
        if ($Intention == '') {
            $json_result = array(
                'ResultCode' => 500,
                'Message' => '系統錯誤',
                'Url' => ''
            );
            if($_GET['Intention']){
                echo 'jsonpCallback('.json_encode($json_result).')';
            }
            elseif($_POST['Intention']){
                echo json_encode($json_result);
            }
            exit;
        }
        $this->$Intention ();
    }
    /**
     * @desc  PC端登陆
     */
    private function Login()
    {
        $ImageCode = strtolower($_POST['ImageCode']);
        if ($_COOKIE['PasswordErrTimes'] < 3) {
            $_SESSION['authnum_session'] = $ImageCode;
        }
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        if ($ImageCode == $_SESSION['authnum_session']) {
            $Account = trim($AjaxData['phoneNumber']);
            $User = new MemberUserModule();
            //判断账号是否注册
            $UserInfo = $User->AccountExists($Account);
            if (empty($UserInfo)) {
                $json_result = array('ResultCode' => 106,'Message' => '未注册的账号！', 'Url' => '');
                echo json_encode($json_result);
                exit;
            }
            $PassWord = md5($AjaxData['password']);
            $UserID = $User->CheckUser($Account, $PassWord);
            //发送系统消息
            if ($UserID) {
                $XpirationDate = time() + 3600 * 24;
                if ($_POST['AutoLogin'] == 1) {
                    setcookie("UserID", $UserID, $XpirationDate, "/", WEB_HOST_URL);
                    setcookie("Account", $Account, $XpirationDate, "/", WEB_HOST_URL);
                }
                //同步SESSIONID
                setcookie("session_id", session_id(), $XpirationDate, "/", WEB_HOST_URL);
                $_SESSION['UserID'] = $UserID;
                $_SESSION['Account'] = $Account;
                setcookie("UserID", $_SESSION['UserID'], time() + 3600 * 24, "/", WEB_HOST_URL);
                $UserInfoModule = new MemberUserInfoModule();
                $Data['LastLogin'] = date('Y-m-d H:i:s', time());
                $UserInfoModule->UpdateInfoByWhere($Data,' UserID = '.$UserID);
                $UserInfo=$UserInfoModule->GetInfoByUserID($UserID);
                if($UserInfo){
                    if($UserInfo['Identity']==1){
                        $Url = WEB_MAIN_URL.'/memberperson/';
                    } elseif($UserInfo['Identity']==2){
                        $Url=WEB_MAIN_URL.'/memberperson/';
                    } elseif($UserInfo['Identity']==3){
                        $Url=WEB_MAIN_URL.'/memberfirm/';
                    }elseif($UserInfo['Identity']==4){
                        $Url=WEB_MAIN_URL.'/memberlawyer/';
                    }
                }else{
                    $Url = WEB_MAIN_URL.'/memberperson/';
                }
                $json_result = array('ResultCode' => 200, 'Message' => '登录成功', 'Url' => $Url);
            }
            else {
                // 设置密码超过三次
                $PasswordErrTimes = intval($_COOKIE['PasswordErrTimes']) + 1;
                setcookie("PasswordErrTimes", $PasswordErrTimes, time() + 3600, "/", WEB_HOST_URL);
                if ($PasswordErrTimes > 2) {
                    $json_result = array('ResultCode' => 105, 'Message' => '您输入的密码错误，请重新输入!');
                } else {
                    $json_result = array('ResultCode' => 100, 'Message' => '您输入的密码错误，请重新输入!');
                }
            }
        } else {
            $json_result = array('ResultCode' => 101, 'Message' => '验证码错误');
        }
        echo json_encode($json_result);
        exit;
    }
    /**
     * @desc  发送 注册/找回密码 验证码
     */
    private function RegisterSendCode(){
        $ImageCode = $_POST['ImageCode'];
        $Account = $_POST['phoneNumber'];
        $UserModule = new MemberUserModule();
        if ($UserModule->AccountExists($Account)) {
            $json_result = array('ResultCode' => 106, 'Message' => '该帐号已被注册过了,请更换帐号注册');
        }else{
            $json_result = MemberService::SendMobileVerificationCode($Account);
        }
        echo json_encode($json_result);exit;
    }
    /**
     * @desc  注册
     */
    private function Register()
    {
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        $Account = trim($AjaxData['phoneNumber']);
        $UserModule = new MemberUserModule();
        if ($UserModule->AccountExists($Account)) {
            $json_result = array('ResultCode' => 101, 'Message' => '该帐号已被注册过了,请更换号码注册', 'Url' => '');
        } else {
            $VerifyCode = $AjaxData['code'];
            $Authentication = new MemberAuthenticationModule ();
            $TempUserInfo = $Authentication->GetAccountInfo($Account, $VerifyCode, 0);
            if ($TempUserInfo) {
                $CurrentTime = time();
                if ($CurrentTime > $TempUserInfo['XpirationDate']) {
                    $json_result = array('ResultCode' => 103, 'Message' => '短信验证码过期');
                }else{
                    $Data['Mobile'] = $Account;
                    $Data['AddTime'] = Time();
                    $Data['AddIP'] = GetIP();
                    $Data['State'] = 1;
                    $Data['PassWord'] = md5(trim($AjaxData['password']));
                    //开始事务
                    global $DB;
                    $DB->query("BEGIN");
                    $insert_result = $UserModule->InsertInfo($Data);
                    if ($insert_result) {
                        $AccountInfo = $UserModule->AccountExists($Account);
                        $UserInfo = new MemberUserInfoModule();
                        $InfoData['UserID'] = $AccountInfo['UserID'];
                        $InfoData['NickName'] = 'LWG_'.date('i').mt_rand(100,999);
                        $InfoData['LastLogin'] =  $Data['AddTime'];
                        $InfoData['Identity'] =0;
                        $InfoData['IdentityState'] =3;
                        $InfoData['Avatar']='/Uploads/Debt/imgs/head_img.png';
                        $UserInfo->InsertInfo($InfoData);
                        // 同步SESSIONID
                        setcookie("session_id", session_id(), time() + 3600 * 24, "/", WEB_HOST_URL);
                        $_SESSION['UserID'] = $InfoData['UserID'];
                        $_SESSION['NickName'] = $InfoData['NickName'];
                        $_SESSION['Account'] = $Account;
                        $_SESSION['Identity'] = $InfoData['Identity'];
                        setcookie("UserID", $_SESSION['UserID'], time() + 3600 * 24, "/", WEB_HOST_URL);
                        $DB->query("COMMIT");//执行事务
                        $json_result = array('ResultCode' => 200, 'Message' => '注册成功',);
                    }else{
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $json_result = array('ResultCode' => 102, 'Message' => '注册失败',);
                    }
                }
            }else{
                $json_result = array('ResultCode' => 104, 'Message' => '短信验证码输入错误',);
            }
        }
        echo json_encode($json_result);exit;
    }
}