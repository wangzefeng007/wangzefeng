<?php
/**
 * @desc  资产转让
 */
class AssetDeal
{
    public function __construct() {

    }
    /**
     * @desc  资产转让列表
     */
    public function Index(){
        $Title ='隆文贵债务处置-资产转让';
        $Nav='index';
        include template('AssetDealIndex');
    }
    /**
     * @desc  发布资产转让
     */
    public function Publish(){
        include template('AssetDealPublish');
    }
}