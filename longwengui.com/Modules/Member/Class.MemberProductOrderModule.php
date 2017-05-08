<?php
/**
 * @desc 资产订单表
 * Class MemberProductOrderModule
 */
class MemberProductOrderModule extends CommonModule {

    public $KeyID = 'OrderID';
    public $TableName = 'member_product_order';

    /**
     * @desc 前台订单状态
     * @var array
     */
    public $NStatus = array(
        '1' => '待接单',
        '2' => '催收中',
        '3' => '未完成',
        '4' => '已完成',
        '5' => '已完成',
        '6' => '未曝光',
        '7' => '已曝光',
        '8' => '待审核',
        '9' => '取消发布',
        '10' => '审核失败',
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
        '9' => '取消发布',
        '10' => '审核失败',
    );
}