<?php
/**
 * @desc 处理逻辑函数
 */
class MService
{
    /**
     * @desc  判断登录返回相应会员中心
     */
    public static function IsLogin(){

        if (isset($_SESSION['UserID']) && !empty($_SESSION['UserID'])) {
            if ($_SESSION['Identity'] <=1){
                header('Location:' . WEB_M_URL.'/memberperson/');
            }elseif($_SESSION['Identity'] ==2){
                header('Location:' . WEB_M_URL.'/memberpushguest/');
            }elseif($_SESSION['Identity'] ==3){
                header('Location:' . WEB_M_URL.'/memberfirm/');
            }elseif($_SESSION['Identity'] ==4){
                header('Location:' . WEB_M_URL.'/memberlawyer/');
            }elseif($_SESSION['Identity'] ==5){
                header('Location:' . WEB_M_URL.'/membercompany/');
            }elseif($_SESSION['Identity'] ==6){
                header('Location:' . WEB_M_URL.'/memberlawfirm/');
            }
        }
    }
    /**
     * @desc  判断是否登录返回登录页
     */
    public static function IsNoLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_M_URL . '/member/login/');
        }
    }

}