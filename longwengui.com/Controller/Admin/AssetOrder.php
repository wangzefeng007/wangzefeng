<?php

/**
 *@desc  资产订单管理
 */
class AssetOrder
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  资产订单列表
     */
    public function Lists()
    {
        include template('AssetOrderLists');
    }
    /**
     * @desc  资产订单详情
     */
    public function Detail(){
        include template('AssetOrderDetail');
    }
}