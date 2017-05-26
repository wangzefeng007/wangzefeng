<?php
/**
 * @desc  法律援助
 */
class LegalAid
{
    public function Index(){
        $Nav='legalaid';
        $MemberLawfirmAidModule = new MemberLawfirmAidModule();
        $MemberAreaModule = new MemberAreaModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        //分页查询开始-------------------------------------------------
        $MysqlWhere = ' ';
        //关键字
        $Province = trim($_GET['dd_province']);
        if ($Province!=''){
            $MysqlWhere .= ' and  Area like \'%'.$Province.'%\'';
        }
        $City = trim($_GET['dd_city']);
        if ($City!=''){
            $MysqlWhere .= ' and  Area like \'%'.$City.'%\'';
        }
        $Rscount = $MemberLawfirmAidModule->GetListsNum($MysqlWhere);
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
            $Data['Data'] = $MemberLawfirmAidModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $AreaInfo = json_decode($value['Area'],true);
                foreach($AreaInfo as $K=>$V){
                    $AreaInfo[$K]['province'] = $MemberAreaModule->GetCnNameByKeyID($V['province']);
                    $AreaInfo[$K]['city'] = $MemberAreaModule->GetCnNameByKeyID($V['city']);
                    $AreaInfo[$K]['area'] = $MemberAreaModule->GetCnNameByKeyID($V['area']);
                }
                $Data['Data'][$key]['Area'] = $AreaInfo;
                $UserInfo = $MemberUserInfoModule->GetInfoByUserID($value['UserID']);
                $Data['Data'][$key]['Avatar'] = $UserInfo['Avatar'];
                $Data['Data'][$key]['Name'] = $UserInfo['CompanyName'];
            }
            $ClassPage = new Page($Rscount['Num'], $PageSize,3);
            $ShowPage = $ClassPage->showpage();
        }
        include template('LegalAidIndex');
    }
}