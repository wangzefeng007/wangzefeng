<?php

/**
 * Created by PhpStorm.
 * User: 123456
 * Date: 2017/3/8
 * Time: 18:46
 */
class Debt
{
    public function __construct() {

    }
    public function Index(){
        $Nav='index';
        include template('Index');
    }

    public function DebtLists(){
        $Nav='debtlists';
        include template('DebtLists');
    }
}