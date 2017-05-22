<?php
/**
 * @desc  寻找处置方
 */
class Find
{
    public function __construct() {

    }
    public function IsLogin(){
        if (!isset ($_SESSION ['UserID']) || empty ($_SESSION ['UserID'])) {
            header('Location:' . WEB_MAIN_URL . '/member/login/');
        }else{
            if ($_SESSION['Identity']!=1 && $_SESSION['Identity']!=2 && $_SESSION['Identity']!=5)
                alertandgotopage("访问被拒绝！您没有此项权限", WEB_MAIN_URL.'/choicefind/');
        }
    }
    /**
     * @desc  寻找处置方
     */
    public function ChoiceFind(){
        $Title="寻找处置方-隆文贵债务处置";
        $Nav ='find';
        include template('DebtChoiceFind');
    }

}