<?php

/**
 * @desc 寻找处置方管理
 */
class DisposalMatch
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  更新处置方信息
     */
    public function Add()
    {
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $MemberFindDisposalDebtModule = new MemberFindDisposalDebtModule();
        include template('DisposalMatchAdd');
    }

    /**
     * @desc  处置方信息列表
     */
    public function DisposalMatchLists()
    {
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $MemberFindDisposalDebtModule = new MemberFindDisposalDebtModule();

        include template('DisposalMatchLists');
    }
}