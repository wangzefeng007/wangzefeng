<?php

/**
 * @param 悬赏信息管理
 */
class Reward
{
    public function __construct()
    {
        IsLogin();
    }

    /**
     * @desc  添加或更新悬赏信息
     */
    public function Add()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        include template('RewardAdd');
    }

    /**
     * @desc  悬赏信息列表
     */
    public function RewardLists()
    {
          $MemberRewardInfoModule = new MemberRewardInfoModule();
        include template('RewardLists');
    }
     /**
     * @desc  悬赏信息详情
     */
    public function RewardDetail()
    {
          $MemberRewardInfoModule = new MemberRewardInfoModule();
        include template('RewardLists');
    }

    /**
     * @desc  悬赏信息删除
     */
    public function Delete()
    {
        $MemberRewardInfoModule = new MemberRewardInfoModule();
        $MemberRewardInfo = $MemberRewardInfoModule->DeleteByKeyID($AreaID);
        if (!$MemberRewardInfo) {
            alertandgotopage("删除失败", '/index.php?Module=Reward&Action=RewardList');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=Reward&Action=RewardList');
        }
    }
}