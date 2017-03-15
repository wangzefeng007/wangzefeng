<?php

/**
 * @desc 申请代理用户表
 * Class MemberProxyApplyModule
 */
class MemberProxyApplyModule extends CommonModule {

    public $KeyID = 'ApplyID';
    public $TableName = 'member_proxy_apply';
    
     /**
     * @desc 后台代理审核状态
     * @var array
     */
    public $NStatus = [
        '1' => '未提交审核',
        '2' => '审核中',
        '3' => '审核通过',
    ];
}