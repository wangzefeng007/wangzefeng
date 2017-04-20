<?php
/**
 * @desc  搜索老赖
 */
class DeadBeat
{
    public function index(){
        $Nav='deadbeat';
        $Title="债务案源|催收系统|债务追讨-隆文贵债务处置";
        $Keywords="催收平台,催收系统，债务清算,债务追讨,欠款催收,债务案源";
        $Description="债权人在隆文贵债务处置平台发布单笔或多笔债权信息后，债务信息展现在隆文贵债务处置债务催收栏目版块，执业律师或催收公司在此页面可根据地域分布和佣金比例等因素选择接单，进行催收，从而赚取佣金。";
        include template('SearchDeadBeat');
    }
}