<?php
/**
 * @desc  处置接单表
 * Class MemberClaimsDisposalModule
 */
Class MemberClaimsDisposalModule extends CommonModule {
    public $KeyID = 'ID';
    public $TableName = 'member_claims_disposal';

    /**
     * @desc 前台订单状态
     * @var array
     */
    public $NStatus = array(
        '1' => '申请中',
        '2' => '催收中',
        '3' => '未完成',
        '4' => '部分完成',
        '5' => '全部完成',
        '6' => '未曝光',
        '7' => '已曝光',
        '8' => '待审核',
        '9' => '取消发布',
    );
}