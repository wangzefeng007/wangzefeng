<?php

/**
 *@desc 投诉建议管理
 */
class ComplaintAdvice
{
    public function __construct()
    {
        IsLogin();
    }

    /**
     * @desc 投诉建议详情
     */
    public function Add()
    {
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        include template('ComplaintAdviceAdd');
    }

    /**
     * @desc  投诉建议列表
     */
    public function ComplaintAdviceLists()
    {
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        include template('ComplaintAdviceLists');
    }

    /**
     * @desc  删除投诉建议
     */
    public function Delete()
    {
        $MemberComplaintAdviceModule = new MemberComplaintAdviceModule();
        $AreaID = $_GET['AreaID'];
        $MemberComplaintAdvice = $MemberComplaintAdviceModule->DeleteByKeyID($AreaID);
        if (!$MemberComplaintAdvice) {
            alertandgotopage("删除失败", '/index.php?Module=TourArea&Action=TourAreaList');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=TourArea&Action=TourAreaList');
        }
    }
}