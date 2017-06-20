<?php
/**
 * @desc 资产转让相关
 * Class AjaxAsset
 */
class AjaxAsset
{
    public function __construct()
    {
    }
    public function Index()
    {
        $Intention = trim($_POST ['Intention']);
        if ($Intention == '') {
            $json_result = array(
                'ResultCode' => 500,
                'Message' => '系統錯誤',
                'Url' => ''
            );
            EchoResult($json_result);
            exit;
        }
        $this->$Intention ();
    }
    /**
     * @desc  判断是否登录
     */
    private function IsLogin()
    {
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_M_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
    }
    /**
     * @desc 资产列表获取
     */
    public function GetAssetList(){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MysqlWhere = '';
        //关键字
        $S = intval($_POST['Type']);
        $Keywords = trim($_GET['Keyword']);
        if ($S ==1){
            $MysqlWhere = ' and `Status` = 2 and `S1` =1 ';
        }elseif($S ==2){
            $MysqlWhere = ' and `Status` = 2 and `S2` =1 ';
        }else{
            $MysqlWhere = ' and `Status` = 2 ';
        }
        if ($Keywords!=''){
            $MysqlWhere .= ' and Title like \'%' . $Keywords . '%\'';
        }
        $Rscount = $MemberAssetInfoModule->GetListsNum($MysqlWhere);
        $Page = intval($_POST['Page']) < 1 ? 1 : intval($_POST['Page']); // 页码 可能是空
        if ($Page < 1) {
            $Page = 1;
        }
        if ($Rscount['Num']) {
            $PageSize=6;
            $Data = array();
            $Data['RecordCount'] = $Rscount['Num'];
            $Data['PageSize'] = ($PageSize ? $PageSize : $Data['RecordCount']);
            $Data['PageCount'] = ceil($Data['RecordCount'] / $PageSize);
            if ($Page > $Data['PageCount'])
                $Page = $Data['PageCount'];
            $Data['Page'] = min($Page, $Data['PageCount']);
            $Offset = ($Page - 1) * $Data['PageSize'];
            $List= $MemberAssetInfoModule->GetLists($MysqlWhere, $Offset,$Data['PageSize']);
            foreach ($List as $key=>$value){
                $AssetImage = $MemberAssetImageModule->GetInfoByWhere(" and AssetID = ".$value['AssetID'].' and IsDefault = 1');
                $Data['Data'][$key]['ImageUrl'] = $AssetImage['ImageUrl'];
                $Data['Data'][$key]['Url'] = '/assetdetails/'.$value['AssetID'].'.html';
                $Data['Data'][$key]['MarketPrice'] = $value['MarketPrice'];
                $Data['Data'][$key]['Price'] = $value['Price'];
                $Data['Data'][$key]['Title'] = $value['Title'];
            }
            MultiPage($Data, 5);
            $Data['Message'] = '返回成功';
            $Data['ResultCode'] = 200;
        }else{
            $Data['ResultCode'] = 101;
            $Data['Message'] = '很抱歉，暂时无法找到相应数据';
            EchoResult($Data);exit;
        }
        EchoResult($Data);exit;

    }
    /**
     * @desc 发布资产
     */
    public function Publish(){
        $this->IsLogin();
        if ($_POST){
        $MemberAssetInfoModule = new MemberAssetInfoModule();
        $MemberAssetImageModule = new MemberAssetImageModule();
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        $Data['AssetMember'] = 'L'.date("Ymd").rand(100, 999);//资产单号
        $Data['Content'] = stripslashes($AjaxData['transDetail']);//内容
        $Data['Title'] = addslashes($AjaxData['_transTitle']);//标题
        $Data['Price'] = trim($AjaxData['_trans_money']);//单价
        $Data['MarketPrice'] = trim($AjaxData['_public_money']);//市场单价
        $Data['Inventory'] = trim($AjaxData['_trans_count']);//库存量
        $Data['Amount'] = $Data['Inventory'];//总数量
        $Data['AssetsAmount'] = $Data['Price']*$Data['Inventory'];//资产总金额
        $Data['Freight'] = trim($AjaxData['_emsMoney']);//运费
        $Data['AfterPhone'] = trim($AjaxData['_sell_phone']);//售后电话
        $Data['Category'] = trim($AjaxData['_trans_type']);//产品类型
        $Data['ExpirationDate'] = strtotime($AjaxData['_end_time']);//截止时间
        $Data['UserID'] =  $_SESSION['UserID'];
        $Data['AddTime'] = time();
        $Data['Status'] =2;
        $ID = intval($_POST['ID']);
            $ImageArr=array();
            if (strstr($AjaxData['transDetail'], 'data:image')){
                preg_match_all('/<img src="data:image(.*)"/isU',$AjaxData['transDetail'],$ImageArr);
                if(count($ImageArr[1])){
                    $NewImgArr=array();
                    foreach($ImageArr[1] as $key=>$ImgUrl){
                        $savePath = '/Uploads/Asset/'.date('Ymd').'/';
                            $NewImgArr[$key] = SendToImgServ($savePath,$ImgUrl);
                            $NewImgTagArr[$key]="<img src=\"{$NewImgArr[$key]}\">";
                    }
                }
                $Data['Content']=str_replace(array_reverse($ImageArr[0]),array_reverse($NewImgTagArr),$AjaxData['transDetail']);
            }
            if (!empty($ID)){
                $Result = $MemberAssetInfoModule->UpdateInfoByKeyID($Data,$ID);
                if ($Result){
                    $MemberAssetImageModule->DeleteByWhere(' and AssetID ='.$ID);
                    foreach ($AjaxData['imageList'] as $key =>$value){
                        if ($key==0){
                            $IsDefault =1;
                        }else{
                            $IsDefault =0;
                        }
                        $InsertImage = $MemberAssetImageModule->InsertInfo(array('AssetID'=>$ID,'ImageUrl'=>$value,'IsDefault'=>$IsDefault));
                    }
                    if (!$InsertImage){
                        $result_json = array('ResultCode'=>105,'Message'=>'修改失败！','Url'=>'/member/asset/');
                    }else{
                        $result_json = array('ResultCode'=>200,'Message'=>'修改成功！','Url'=>'/member/asset/');
                    }
                }else{
                    $result_json = array('ResultCode'=>104,'Message'=>'修改失败！','Url'=>'/member/asset/');
                }
            }else{
                $AssetID = $MemberAssetInfoModule->InsertInfo($Data);
                if ($AssetID){
                    foreach ($AjaxData['imageList'] as $key =>$value){
                        if ($key==0){
                            $IsDefault =1;
                        }else{
                            $IsDefault =0;
                        }
                        $InsertImage = $MemberAssetImageModule->InsertInfo(array('AssetID'=>$AssetID,'ImageUrl'=>$value,'IsDefault'=>$IsDefault));
                    }
                    if (!$InsertImage){
                        $result_json = array('ResultCode'=>102,'Message'=>'图片上传失败！');
                    }else{
                        $result_json = array('ResultCode'=>200,'Message'=>'发布成功,请等待审核！','Url'=>'/member/asset/');
                    }
                }else{
                    $result_json = array('ResultCode'=>103,'Message'=>'发布失败！');
                }
            }
            EchoResult($result_json);
            exit;
        }
    }
    /**
     * @desc 商城产品上架下架
     */
    public function ProductShelves(){
        $this->IsLogin();
        if ($_POST['AssetID']) {
            $AssetID = intval($_POST['AssetID']);
            $MemberAssetInfoModule = new MemberAssetInfoModule();
            $AssetInfo = $MemberAssetInfoModule->GetInfoByKeyID($AssetID);
            if ($AssetInfo['ProductStatus']==1){
                $Data['ProductStatus']=0;
            }else{
                $Data['ProductStatus']=1;
            }
            $Result = $MemberAssetInfoModule->UpdateInfoByKeyID($Data,$AssetID);
            if ($Result){
                $result_json = array('ResultCode'=>200,'Message'=>'操作成功！');
            }else{
                $result_json = array('ResultCode'=>102,'Message'=>'操作失败！');
            }
            EchoResult($result_json);
        }
    }

    /**
     * @desc 订单确认
     */
    public function ConfirmOrder(){
        $this->IsLogin();
        if ($_POST) {
            $MemberAssetInfoModule = new MemberAssetInfoModule();
            $MemberProductOrderModule = new MemberProductOrderModule();
            $MemberShippingAddressModule = new MemberShippingAddressModule();
            $MemberAreaModule = new MemberAreaModule();
            $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
            $AssetInfo =$MemberAssetInfoModule->GetInfoByKeyID($AjaxData['ProductID']);
            if (!$AssetInfo){
                $result_json = array('ResultCode'=>102,'Message'=>'不存在该产品！');
            }else{
                if ($AjaxData['AddressId']){
                    $Data['TotalAmount'] = trim($AjaxData['Money']);//订单总金额
                    $Money = $AssetInfo['Price'] * intval($AjaxData['Number']) +$AssetInfo['Freight'];
                    if ($Money!=$Data['TotalAmount']){
                        $result_json = array('ResultCode'=>105,'Message'=>'订单金额出错！');
                        EchoResult($result_json);
                    }
                    $ShippingAddressID = intval($AjaxData['AddressId']);
                    $AddressInfo = $MemberShippingAddressModule->GetInfoByKeyID($ShippingAddressID);
                    $AddressInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($AddressInfo['Province']);
                    $AddressInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($AddressInfo['City']);
                    $AddressInfo['Area']= $MemberAreaModule->GetCnNameByKeyID($AddressInfo['Area']);
                    $Data['OrderNumber'] = 'D'.date("Ymd").rand(1000, 9999);;//订单编号
                    $Data['Num'] = intval($AjaxData['Number']);//数量
                    $Data['ProductID'] = intval($AjaxData['ProductID']);//产品ID
                    $Data['UserID'] = $_SESSION['UserID'];
                    $Data['AddTime'] = time();//订单创建时间
                    $Data['UpdateTime'] = $Data['AddTime'];//订单修改时间
                    $Data['ExpirationTime'] = $Data['AddTime']+3600;//超时时间
                    $Data['Status'] = 1;
                    $Data['FromIP'] = GetIP();
                    $Data['Address'] = $AddressInfo['Province'].$AddressInfo['City'].$AddressInfo['Area'].$AddressInfo['Address'];//收货地址
                    $Data['Tel'] = $AddressInfo['Mobile'];//手机号码
                    $Data['Contacts'] = $AddressInfo['Name'];//联系人姓名
                    $Data['UnitPrice'] = $AssetInfo['Price'];//单价
                    $InsertInfo = $MemberProductOrderModule->InsertInfo($Data);
                    if ($InsertInfo){
                        $result_json = array('ResultCode'=>200,'Message'=>'订单提交成功！', 'Url' => WEB_M_URL . '/asset/pay/?id='.$InsertInfo.'&type=alipay');
                    }else{
                        $result_json = array('ResultCode'=>103,'Message'=>'订单提交失败！');
                    }
                }else{
                    $result_json = array('ResultCode'=>104,'Message'=>'收货地址不能为空！');
                }
            }
            EchoResult($result_json);
            exit;
        }
    }
}