<?php
/**
 * @desc  资产转让
 */
class Asset
{
    public function __construct() {

    }
    /**
     * @desc  资产转让列表
     */
    public function Lists(){
        $Title ='隆文贵债务处置-资产转让';
        $Nav='index';
        include template('AssetLists');
    }
    /**
     * @desc  发布资产转让
     */
    public function Publish(){
        include template('AssetPublish');
    }
}