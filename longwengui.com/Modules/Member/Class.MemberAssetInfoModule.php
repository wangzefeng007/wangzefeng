<?php
/**
 * @desc  资产转让基础信息表
 * Class  MemberAssetInfoModule
 */
class MemberAssetInfoModule extends CommonModule
{
    public $KeyID = 'AssetID';
    public $TableName = 'member_asset_info';
    /**
     * @desc 前台订单状态
     * @var array
     */
    public $NStatus = [
        '1' => '待审核',
        '2' => '审核通过',
        '3' => '审核未通过	',
        '4' => '过期自动关闭',
    ];
}