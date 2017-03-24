<?php

/**
 *@desc  股权转让管理
 */
class EquityTransfer
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  添加或更新股权转让
     */
    public function Add()
    {
         alertandback('待开发');exit;
        include template('EquityTransferAdd');
    }

    /**
     * @desc  股权转让列表
     */
    public function EquityTransferLists()
    {
        alertandback('待开发');exit;
        include template('EquityTransferLists');
    }

    /**
     * @desc  删除股权转让
     */
    public function Delete()
    {
        $TourAreaModule = new TourAreaModule();
        $TourAreaModules = $TourAreaModule->DeleteByKeyID($AreaID);
        if (!$TourAreaModules) {
            alertandgotopage("删除失败", '/index.php?Module=TourArea&Action=TourAreaList');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=TourArea&Action=TourAreaList');
        }
    }
}