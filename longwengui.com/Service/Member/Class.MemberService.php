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
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }
    }

}