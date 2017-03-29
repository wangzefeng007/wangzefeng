<?php
/**
 * @desc  个人会员中心
 */
class MemberPerson
{
    public function __construct() {
        //$_SESSION ['UserID']=1;
    }
    /**
     * @desc 个人会员中心(个人信息)
     */
    public function Index()
    {
        $Title = '会员中心首页';
        include template('MemberPersonIndex');
    }
    /**
     * @desc 催收公司会员中心(完善个人资料)
     */
    public function PerfectInfo()
    {
        include template('MemberPersonPerfectInfo');
    }
}