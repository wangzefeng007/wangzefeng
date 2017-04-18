<?php
/**
 * @desc 律师佣金设置表
 * Class MemberSetLawyerFeeModule
 */
class MemberSetLawyerFeeModule extends CommonModule{
    public $KeyID = 'SetID';
    public $TableName = 'member_set_lawyerfee';

    /**
     * @desc  寻找处置方获取律师数据
     * $MysqlWhere 省份
     * $Money 债务金额
     */
    public function GetTeamInfoByWhere($MysqlWhere = '',$Money){
        global $DB;
        $sql = "select  me.*,b.mobile,c.* from (SELECT SetID,min(Money) from member_set_lawyerfee GROUP BY UserID) a
left JOIN member_set_lawyerfee me ON me.SetID = a.SetID 
left JOIN member_user b ON me.UserID = b.UserID 
left JOIN member_user_info c ON me.UserID = c.UserID where me.Province IN ($MysqlWhere) and c.IdentityState=3 and c.Identity=4 and me.FromMoney <= $Money and me.ToMoney >= $Money order by me.Money asc";
        return $DB->select($sql);
    }
}