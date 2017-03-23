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
        $Nav ='find';
        include template('DebtChoiceFind');
    }
    public function Team(){
        $Nav ='find';
        $Type = intval($_GET['T']);
        if ($Type!==1 && $Type!==2){
            alertandback('无此处置方！');
        }
        include template('DebtFindTeam');
    }
}