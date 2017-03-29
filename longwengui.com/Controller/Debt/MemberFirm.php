<?php
/**
 * @desc  催收公司会员中心
 */
class MemberFirm
{
    public function __construct() {
        //$_SESSION ['UserID']=1;
    }
    /**
     * @desc 催收公司会员中心(个人信息)
     */
    public function Index()
    {
        $Title = '会员中心首页';
        include template('MemberFirmIndex');
    }
    /**
     * @desc 催收公司会员中心(完善个人资料)
     */
    public function PerfectInfo()
    {
        include template('MemberFirmPerfectInfo');
    }
}