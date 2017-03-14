<?php

/**
 * @desc 悬赏信息表
 * Class MemberRewardInfoModule
 */
class MemberRewardInfoModule extends CommonModule {

    public $KeyID = 'ID';
    public $TableName = 'member_reward_info';

    /**
     * @desc 后台悬赏状态
     * @var array
     */
    public $NStatus = [
        '1' => '审核中',
        '2' => '悬赏中',
        '3' => '已完成',
    ];
}