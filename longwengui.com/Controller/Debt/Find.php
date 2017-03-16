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
        $Type = $_GET['T'];
        include template('DebtFindTeam');
    }
}