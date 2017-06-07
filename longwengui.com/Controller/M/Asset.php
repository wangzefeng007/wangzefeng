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
    public function Index(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        include template('AssetIndex');
        echo 'asset';exit;
    }
    /**
     * @desc  发布资产转让
     */
    public function Publish(){
        include template('AssetPublish');
    }
    /**
     * @desc  发布资产转让成功待审核页面
     */
    public function Audit(){
        include template('AssetAudit');
    }
    /**
     * @desc  资产转让详情页
     */
    public function Details(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberUserModule = new MemberUserModule();
        $MemberProductOrderModule = new MemberProductOrderModule();
        include template('AssetDetails');
    }
    /**
     * 选择支付页
     */
    public function ChoicePay()
    {

    }
    /**
     * 准备支付
     */
    public function Pay()
    {
    }
}