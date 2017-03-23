<?php
/**
 * @desc  寻找处置方
 */
class Find
{
    public function __construct() {

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