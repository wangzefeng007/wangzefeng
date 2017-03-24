<?php

/**
 * Class Admin
 * @desc  后台登陆
 */
class Admin
{
    public function __construct()
    {
    }

    /**
     * @desc  登陆页面
     */
    public function Index()
    {
        if ($_SESSION['AdminID'] && $_SESSION['AdminName']) {
            header("Location:" . WEB_ADMIN_URL . "/index.php?Module=Debt&Action=DebtLists");
        } else {
            include template('Login');
        }
    }

    /**
     * @desc  登录操作
     */
    public function Login()
    {
        $ImageCode = strtolower(trim($_POST['code']));
        //$_SESSION['authnum_session'] = $ImageCode;
        if ($ImageCode == $_SESSION['authnum_session']) {
            $AdminName = trim($_POST['user']);
            $PassWord = md5(trim($_POST['pass']));
            $ServerAdmin = new MemberAdminModule();
            $AdminInfo = $ServerAdmin->CheckUser($AdminName, $PassWord);
            if ($AdminInfo) {
                $LoginInfo['LastLogin'] = date('Y-m-d H:i:s', time());
                $LoginInfo['LoginIP'] = GetIP();
                $ServerAdmin->UpdateInfoByKeyID($LoginInfo, $AdminInfo['AdminID']);
                $_SESSION['AdminID'] = $AdminInfo['AdminID'];
                $_SESSION['AdminName'] = $AdminName;
                $_SESSION['AdminGroup'] = $AdminInfo['GroupID'];
                $this->Index();
            } else {
                alertandback("账号或密码错误,登录失败");
            }
        } else {
            alertandback("验证码错误,登录失败");
        }
    }

    /**
     * @desc  退出
     */
    public function Layout()
    {
        unset($_SESSION);
        session_destroy();
        header("Location:/index.php?Module=Admin&Action=Index");
    }
}
