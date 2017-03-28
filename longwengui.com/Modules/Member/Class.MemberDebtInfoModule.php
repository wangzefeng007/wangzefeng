<?php
/**
 * @desc  债务信息管理 
 * Class MemberDebtInfoModule
 */
Class MemberDebtInfoModule extends CommonModule {
    public $KeyID = 'DebtID';
    public $TableName = 'member_debt_info';
    /**
     * @desc 前台订单状态
     * @var array
     */
    public $NStatus = array(
        '1' => '未接单',
        '2' => '催收中',
        '3' => '未完成',
        '4' => '已完成',
        '5' => '已完成',
        '6' => '未曝光',
        '7' => '已曝光',
        '8' => '待审核',
    );
    /**
     * @desc 后台订单状态
     * @var array
     */
    public $Status = array(
        '1' => '未接单',
        '2' => '催收中',
        '3' => '未完成',
        '4' => '部分收回',
        '5' => '全部收回',
        '6' => '未曝光',
        '7' => '已曝光',
        '8' => '待审核',
    );
    /**
     * @desc 催收方式
     * @var array
     */
    public $CollectionType = array(
        '1' => '律师催收',
        '2' => '催收公司催收',
        '3' => '自助催收',
    );
}
