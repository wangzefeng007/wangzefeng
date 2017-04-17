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
            if ($_SESSION['Identity']!=1)
                alertandgotopage("访问被拒绝,目前只有普通会员可以寻找处置方！", WEB_MAIN_URL.'/choicefind/');
        }
    }
    /**
     * @desc  寻找处置方
     */
    public function ChoiceFind(){
        $Title="寻找处置方-隆文贵不良资产处置";
        $Nav ='find';
        include template('DebtChoiceFind');
    }
    public function Team(){
        $this->IsLogin();
        $Nav ='find';
        $Type = intval($_GET['T']);
        if ($Type===1){
            $Title="寻找律师团队-隆文贵不良资产处置";
        }elseif($Type===2){
            $Title="寻找催收公司-隆文贵不良资产处置";
        }else{
            alertandback('无此处置方！');
        }
        include template('DebtFindTeam');
    }
}