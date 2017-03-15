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
        '1' => '未提交审核',
        '2' => '审核中',
        '3' => '悬赏中',
        '4' => '已完成',
    ];
}