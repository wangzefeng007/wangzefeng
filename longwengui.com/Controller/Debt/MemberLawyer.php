<?php
/**
 * @desc  律师会员中心
 */
class MemberLawyer
{
    public function __construct() {
        //$_SESSION ['UserID']=1;
    }
    /**
     * @desc 律师会员中心(个人信息)
     */
    public function Index()
    {
        $Title = '会员中心首页';
        include template('MemberLawyerIndex');
    }
    /**
     * @desc 律师会员中心(完善个人资料)
     */
    public function PerfectInfo()
    {
        include template('MemberLawyerPerfectInfo');
    }
}