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
    public function Lawyer(){
        $Nav ='find';
        echo 1;exit;
    }
}