<?php
/**
 * @desc 寻找处置方债权表
 * Class MemberFindDebtModule
 */
Class MemberFindDebtModule extends CommonModule {
    public $KeyID = 'DebtID';
    public $TableName = 'member_find_debt';
    /**
     * @desc 前台订单状态
     * @var array
     */
    public $NStatus = [
        '1' => '待接单',
        '2' => '催收中',
        '3' => '未完成',
        '4' => '已完成',
        '5' => '已完成',
        '6' => '未曝光',
        '7' => '已曝光',
    ];
    /**
     * @desc 后台订单状态
     * @var array
     */
    public $Status = [
        '1' => '未接单',
        '2' => '催收中',
        '3' => '未完成',
        '4' => '部分收回',
        '5' => '全部收回',
        '6' => '未曝光',
        '7' => '已曝光',
    ];
}
