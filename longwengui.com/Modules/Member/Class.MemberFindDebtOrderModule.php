<?php
/**
 * @desc 寻找处置方债务接单表
 * Class MemberFindDebtOrderModule
 */
class MemberFindDebtOrderModule extends CommonModule {
    public $KeyID = 'OrderID';
    public $TableName = 'member_find_debt_order';
    /**
     * @desc 后台订单状态
     * @var array
     */
    public $NStatus = [
        '1' => '申请中',
        '2' => '催收中',
        '3' => '未完成',
        '4' => '已完成',
        '5' => '已完成',
        '6' => '未曝光',
        '7' => '已曝光',
        '9' => '取消发布',
    ];
}