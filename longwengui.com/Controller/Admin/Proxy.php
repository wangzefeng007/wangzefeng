<?php

/**
 *desc代理信息管理
 */
class Proxy
{
    public function __construct()
    {
        IsLogin();
    }
    /**
     * @desc  添加或更新代理信息
     */
    public function Add()
    {
        $MemberProxyApplyModule = new MemberProxyApplyModule();
        include template('ProxyAdd');
    }

    /**
     * @desc 代理信息列表
     */
    public function ProxyLists()
    {
        $MemberProxyApplyModule = new MemberProxyApplyModule();
        include template('ProxyLists');
    }

    /**
     * @desc  删除代理信息
     */
    public function Delete()
    {
        $MemberProxyApplyModule = new MemberProxyApplyModule();
        $MemberProxyApply = $MemberProxyApplyModule->DeleteByKeyID($AreaID);
        if (!$MemberProxyApply) {
            alertandgotopage("删除失败", '/index.php?Module=Proxy&Action=ProxyList');
        } else {
            alertandgotopage("删除成功", '/index.php?Module=Proxy&Action=ProxyList');
        }
    }
}