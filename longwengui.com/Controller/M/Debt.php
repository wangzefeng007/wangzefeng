<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/2
 * Time: 9:53
 */
class Debt
{
    /**
     * @desc  债务催收列表
     */
    public function Index(){
        include template('DebtIndex');
    }
    /**
     * @desc  债务详情
     */
    public function Detail(){
        include template('DebtDetail');
    }
    /**
     * @desc  发布债务
     */
    public function Publish()
    {
        include template('DebtPublish');
    }
}