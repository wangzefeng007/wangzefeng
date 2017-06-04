<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/6/2
 * Time: 9:53
 */
class Debt
{
    /**
     * @desc  债务催收列表
     */
    public function Index(){
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $AreaList = $MemberAreaModule->GetInfoByWhere(' and R1 =1 order by S1 asc',true);
        $NStatus = $MemberDebtInfoModule->NStatus;
        //分页查询开始-------------------------------------------------
        $MysqlWhere = ' and `Status` <= 7 order by Status asc , AddTime desc';
        //关键字
        $Rscount = $MemberDebtInfoModule->GetListsNum($MysqlWhere);
        $Page=intval($_GET['p'])?intval($_GET['p']):0;
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=7;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $Data['Data'] = $MemberDebtInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(" and DebtID = ".$value['DebtID']);
                $Data['Data'][$key]['Phone'] = $DebtorsInfo['Phone'];
                $Data['Data'][$key]['Name'] = $DebtorsInfo['Name'];
                if ($DebtorsInfo['Province'])
                    $Data['Data'][$key]['Province'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Province']);
                if ($DebtorsInfo['City'])
                    $Data['Data'][$key]['City'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['City']);
                if ($DebtorsInfo['Area'])
                    $Data['Data'][$key]['Area'] = $MemberAreaModule->GetCnNameByKeyID($DebtorsInfo['Area']);
                $Data['Data'][$key]['AddTime'] = !empty($value['AddTime'])? date('Y-m-d',$value['AddTime']): '';
                $Data['Data'][$key]['Url'] = '/debt/'.$value['DebtID'].'.html';
            }
        }
        include template('DebtIndex');
    }
    /**
     * @desc  债务详情
     */
    public function Details(){

        include template('DebtDetails');
    }
    /**
     * @desc  发布债务
     */
    public function Publish(){
        include template('DebtPublish');
    }
}