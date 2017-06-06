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
        '1' => '待付款',
        '2' => '已付款',
        '3' => '待签收',
        '4' => '已签收',
        '5' => '申请退款',
        '6' => '退款中',
        '7' => '申请失败',
        '8' => '退款完成',
        '9' => '交易关闭',
        '10' => '交易关闭',
        '11' => '退货中',
    );
    /**
     * @desc 后台订单状态
     * @var array
     */
    public $Status = array(
        '1' => '待付款',
        '2' => '已付款确认中',
        '3' => '已付款待确认收货',
        '4' => '已付款已确认收货',
        '5' => '申请退款',
        '6' => '退款（处理中）',
        '7' => '退款审核不通过',
        '8' => '退款完成',
        '9' => '交易关闭(超时)',
        '10' => '交易关闭(用户关闭)',
        '11' => '退款（退货中）',
    );
    /**
     * @desc 后台支付方式
     * @var array
     */
    public $PaymentMethod = array(
        '1' => '支付宝',
        '2' => '微信',
        '3' => '网银',
    );
}