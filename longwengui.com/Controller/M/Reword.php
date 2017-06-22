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
        $Title ='线索悬赏-文贵网';
        $Keywords="催收平台,催收系统，债务清算,债务追讨,欠款催收,债务案源,老赖曝光,线索悬赏";
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
        $Title ='发布悬赏-文贵网';
        MService::IsNoLogin();
       include template('RewardPublish');
    }
}