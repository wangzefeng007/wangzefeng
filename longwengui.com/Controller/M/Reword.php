<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/3/14
 * Time: 14:31
 */
class Reword
{
    public function __construct() {

    }
    /**
     * @desc  线索悬赏列表
     */
    public function Index(){
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardImageModule = new MemberRewardImageModule();
        $MemberAreaModule = new MemberAreaModule();
         include template('RewardIndex');
    }
    /**
     * @desc  发布悬赏
     */

    public function Publish()
    {
       include template('RewardPublish');
    }
}