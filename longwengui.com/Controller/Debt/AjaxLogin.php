<?php
/**
 * @desc
 * Class AjaxLogin
 */
class AjaxLogin
{
    public function Index()
    {
        $Intention = trim($_POST['Intention'])?trim($_POST['Intention']):trim($_GET['Intention']);
        if ($Intention == '') {
            $json_result = array(
                'ResultCode' => 500,
                'Message' => '系統錯誤',
                'Url' => ''
            );
            if($_GET['Intention']){
                echo 'jsonpCallback('.json_encode($json_result).')';
            }
            elseif($_POST['Intention']){
                echo json_encode($json_result);
            }
            exit;
        }
        $this->$Intention ();
    }
    /**
     * @desc  PC端登陆
     */
    private function Login()
    {
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        $ImageCode = strtolower($AjaxData['ImageCode']);
        if ($_COOKIE['PasswordErrTimes'] < 3) {
            $_SESSION['authnum_session'] = $ImageCode;
        }
        if ($ImageCode == $_SESSION['authnum_session']) {
            $Account = trim($AjaxData['phoneNumber']);
            $User = new MemberUserModule();
            //判断账号是否注册
            $UserInfo = $User->AccountExists($Account);
            if (empty($UserInfo)) {
                $json_result = array('ResultCode' => 106,'Message' => '未注册的账号！', 'Url' => '');
                echo json_encode($json_result);
                exit;
            }
            $PassWord = md5($AjaxData['password']);
            $UserID = $User->CheckUser($Account, $PassWord);
            //发送系统消息
            if ($UserID) {
                $XpirationDate = time() + 3600 * 24;
                if ($_POST['AutoLogin'] == 1) {
                    setcookie("UserID", $UserID, $XpirationDate, "/", WEB_HOST_URL);
                    setcookie("Account", $Account, $XpirationDate, "/", WEB_HOST_URL);
                }
                //同步SESSIONID
                setcookie("session_id", session_id(), $XpirationDate, "/", WEB_HOST_URL);
                $_SESSION['UserID'] = $UserID;
                $_SESSION['Account'] = $Account;
                setcookie("UserID", $_SESSION['UserID'], time() + 3600 * 24, "/", WEB_HOST_URL);
                $UserInfoModule = new MemberUserInfoModule();
                $Data['LastLogin'] = time();
                $Data['IP'] = GetIP();
                $UserInfoModule->UpdateInfoByWhere($Data,' UserID = '.$UserID);
                $UserInfo=$UserInfoModule->GetInfoByUserID($UserID);
                if($UserInfo){
                    if($UserInfo['Identity']==1){
                        $Url = WEB_MAIN_URL.'/memberperson/';
                    } elseif($UserInfo['Identity']==2){
                        $Url=WEB_MAIN_URL.'/memberperson/';
                    } elseif($UserInfo['Identity']==3){
                        $Url=WEB_MAIN_URL.'/memberfirm/';
                    }elseif($UserInfo['Identity']==4){
                        $Url=WEB_MAIN_URL.'/memberlawyer/';
                    }
                }else{
                    $Url = WEB_MAIN_URL.'/memberperson/';
                }
                $json_result = array('ResultCode' => 200, 'Message' => '登录成功');
            }
            else {
                // 设置密码超过三次
                $PasswordErrTimes = intval($_COOKIE['PasswordErrTimes']) + 1;
                setcookie("PasswordErrTimes", $PasswordErrTimes, time() + 3600, "/", WEB_HOST_URL);
                if ($PasswordErrTimes > 2) {
                    $json_result = array('ResultCode' => 105, 'Message' => '您输入的密码错误，请重新输入!');
                } else {
                    $json_result = array('ResultCode' => 100, 'Message' => '您输入的密码错误，请重新输入!');
                }
            }
        } else {
            $json_result = array('ResultCode' => 101, 'Message' => '验证码错误');
        }
        echo json_encode($json_result);
        exit;
    }
    /**
     * @desc  发送注册验证码
     */
    private function RegisterSendCode(){
        $ImageCode = $_POST['ImageCode'];
        $Account = $_POST['phoneNumber'];
        $UserModule = new MemberUserModule();
        if ($UserModule->AccountExists($Account)) {
            $json_result = array('ResultCode' => 106, 'Message' => '该帐号已被注册过了,请更换帐号注册');
        }else{
            $json_result = MemberService::SendMobileVerificationCode($Account);
        }
        echo json_encode($json_result);exit;
    }
    /**
     * @desc 修改密码/找回密码 手机绑定验证码
     */
    private function RegisterVerifyCode(){
        $Account = $_POST['phoneNumber'];
        $UserModule = new MemberUserModule();
        if (!$UserModule->AccountExists($Account)) {
            $json_result = array('ResultCode' => 106, 'Message' => '该帐号未注册,请先注册帐号');
        }else{
            $json_result = MemberService::SendMobileVerificationCode($Account);
            if($json_result['ResultCode'] == 200 ){
                $_SESSION['temp_account'] = $_POST['User'];
            }
        }
        echo json_encode($json_result);exit;
    }
    /**
     * @desc  注册页忘记密码
     */
    private function RetrievePassword(){
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        $Account = $AjaxData['phoneNumber'];
        $PassWord = md5($AjaxData ['password']);
        $VerifyCode = $AjaxData['Code'];
        $Authentication = new MemberAuthenticationModule ();
        $TempUserInfo = $Authentication->GetAccountInfo($Account, $VerifyCode, 0);
        if ($TempUserInfo) {
            $CurrentTime = time();
            if ($CurrentTime > $TempUserInfo['XpirationDate']) {
                $json_result = array('ResultCode' => 103, 'Message' => '短信验证码过期');
            }else{
                $MemberUserModule = new MemberUserModule ();
                $UserInfo = $MemberUserModule->GetInfoByWhere(' and Mobile ='.$Account);
                $Result = $MemberUserModule->UpdateInfoByWhere(array('PassWord'=>$PassWord), ' UserID ='.$UserInfo['UserID']);
                if($Result || $Result === 0){
                    $json_result = array('ResultCode' => 200, 'Message' => '重置成功', 'Url' =>WEB_MAIN_URL);
                }else{
                    $json_result = array('ResultCode' => 103, 'Message' => '重置失败');
                }
            }
        }else{
            $json_result = array('ResultCode' => 104, 'Message' => '短信验证码输入错误',);
        }
        echo json_encode($json_result);
    }
    /**
     * @desc  会员中心修改密码
     */
    private function ChangePassword(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_MAIN_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
        $NewPassword = md5(trim($_POST['newPass']));
        $OldPassword = md5(trim($_POST['oldPass']));
        $MemberUserModule = new MemberUserModule();
        $MemberUser = $MemberUserModule->GetInfoByWhere(' and UserID ='.$_SESSION['UserID'].' and PassWord = \''.$OldPassword.'\'');
        if (!$MemberUser){
            $json_result = array('ResultCode' => 101, 'Message' => '旧密码输入错误',);
            echo json_encode($json_result);exit;
        }
        if ($NewPassword ==$OldPassword){
            $json_result = array('ResultCode' => 102, 'Message' => '新密码不能和旧密码相同',);
        }else{
            $MemberUserInfoModule = new MemberUserInfoModule();
            $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID ='.$_SESSION['UserID']);
            if($UserInfo['Identity']==3){
                $Url =WEB_MAIN_URL.'/memberfirm/';
            }elseif($UserInfo['Identity']==4){
                $Url =WEB_MAIN_URL.'/memberlawyer/';
            }else{
                $Url =WEB_MAIN_URL.'/memberperson/';
            }
            $UpdatePassWord = $MemberUserModule->UpdateInfoByWhere(array('PassWord'=>$NewPassword),' UserID ='.$_SESSION['UserID']);
            if ($UpdatePassWord){
                $json_result = array('ResultCode' => 200, 'Message' => '修改成功','Url'=>$Url);
            }else{
                $json_result = array('ResultCode' => 103, 'Message' => '修改失败');
            }
        }
        echo json_encode($json_result);exit;
    }
    /**
     * @desc 修改绑定手机 发送手机验证码
     */
    private function ChangeMobileCode(){
        $Account = $_POST['phoneNumber'];
        $json_result = MemberService::SendMobileVerificationCode($Account);
        if($json_result['ResultCode'] == 200 ){
            $_SESSION['temp_account'] = $_POST['User'];
        }
        echo json_encode($json_result);exit;
    }
    /**
     * @desc  修改绑定手机(验证旧手机)
     */
    private function ChangeMobileFirst(){
        $Account = trim($_POST['phoneNumber']);
        $VerifyCode = trim($_POST['code']);
        $Authentication = new MemberAuthenticationModule ();
        $TempUserInfo = $Authentication->GetAccountInfo($Account, $VerifyCode);
        if ($TempUserInfo){
            $json_result = array('ResultCode' => 200, 'Message' => '验证成功','Random'=>$VerifyCode);
        }else{
            $json_result = array('ResultCode' => 103, 'Message' => '验证失败');
        }
        echo json_encode($json_result);exit;
    }

    /**
     * @desc  修改绑定手机(验证新手机)
     */
    private function ChangeMobileSecond(){
        $Account = trim($_POST['phoneNumber']);
        $VerifyCode = trim($_POST['code']);
        $Authentication = new MemberAuthenticationModule ();
        $MemberUserModule = new MemberUserModule();
        $TempUserInfo = $Authentication->GetAccountInfo($Account, $VerifyCode);
        if ($TempUserInfo){
            if ($MemberUserModule->GetInfoByWhere(' and Mobile ='.$Account.' and UserID ='.$_SESSION['UserID'])){
                $json_result = array('ResultCode' => 101, 'Message' => '新手机不能和旧手机相同');
            }else{
                if ($MemberUserModule->GetInfoByWhere(' and Mobile ='.$Account.' and UserID !='.$_SESSION['UserID'])){
                    $json_result = array('ResultCode' => 103, 'Message' => '该手机已绑定到其他账户');
                }else{
                    $UpdateMobile = $MemberUserModule->UpdateInfoByWhere(array('Mobile'=>$Account),' UserID ='.$_SESSION['UserID']);
                    if ($UpdateMobile){
                        $_SESSION['Account'] =$Account;
                        $json_result = array('ResultCode' => 200, 'Message' => '绑定成功','Mobile'=>$Account);
                    }else{
                        $json_result = array('ResultCode' => 103, 'Message' => '绑定失败');
                    }
                }
            }
        }else{
            $json_result = array('ResultCode' => 103, 'Message' => '验证失败');
        }
        echo json_encode($json_result);exit;
    }
    /**
     * @desc  注册
     */
    private function Register()
    {
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        $Account = trim($AjaxData['phoneNumber']);
        $UserModule = new MemberUserModule();
        if ($UserModule->AccountExists($Account)) {
            $json_result = array('ResultCode' => 101, 'Message' => '该帐号已被注册过了,请更换号码注册', 'Url' => '');
        } else {
            $VerifyCode = $AjaxData['code'];
            $Authentication = new MemberAuthenticationModule();
            $TempUserInfo = $Authentication->GetAccountInfo($Account, $VerifyCode, 0);
            if ($TempUserInfo) {
                $CurrentTime = time();
                if ($CurrentTime > $TempUserInfo['XpirationDate']) {
                    $json_result = array('ResultCode' => 103, 'Message' => '短信验证码过期');
                }else{
                    $Data['Mobile'] = $Account;
                    $Data['AddTime'] = Time();
                    $Data['AddIP'] = GetIP();
                    $Data['State'] = 1;
                    $Data['PassWord'] = md5(trim($AjaxData['password']));
                    //开始事务
                    global $DB;
                    $DB->query("BEGIN");
                    $insert_result = $UserModule->InsertInfo($Data);
                    if ($insert_result) {
                        $AccountInfo = $UserModule->AccountExists($Account);
                        $UserInfo = new MemberUserInfoModule();
                        $InfoData['UserID'] = $AccountInfo['UserID'];
                        $InfoData['NickName'] = 'LWG_'.date('i').mt_rand(100,999);
                        $InfoData['LastLogin'] =  $Data['AddTime'];
                        $InfoData['Identity'] =0;
                        $InfoData['IdentityState'] =1;
                        $Data['IP'] = $Data['AddIP'];
                        $InfoData['Avatar']='/Uploads/Debt/imgs/head_img.png';
                        $UserInfo->InsertInfo($InfoData);
                        // 同步SESSIONID
                        setcookie("session_id", session_id(), time() + 3600 * 24, "/", WEB_HOST_URL);
                        $_SESSION['UserID'] = $InfoData['UserID'];
                        $_SESSION['NickName'] = $InfoData['NickName'];
                        $_SESSION['Account'] = $Account;
                        $_SESSION['Identity'] = $InfoData['Identity'];
                        setcookie("UserID", $_SESSION['UserID'], time() + 3600 * 24, "/", WEB_HOST_URL);
                        $DB->query("COMMIT");//执行事务
                        $json_result = array('ResultCode' => 200, 'Message' => '注册成功',);
                    }else{
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $json_result = array('ResultCode' => 102, 'Message' => '注册失败',);
                    }
                }
            }else{
                $json_result = array('ResultCode' => 104, 'Message' => '短信验证码输入错误',);
            }
        }
        echo json_encode($json_result);exit;
    }

    /**
     * @desc 添加证件图片
     */
    public function AddCardImage(){
        //上传图片
        $ImgBaseData = $_POST['ImgBaseData'];
        $ImageUrl = SendToImgServ($ImgBaseData);
        $Data['ImageUrl'] = $ImageUrl ? $ImageUrl : '';
        if ($Data['ImageUrl'] !==''){
            $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['ImageUrl']);
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 添加头像图片
     */
    public function AddHeadImage(){
        //上传图片
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID ='.$_SESSION['UserID']);
        $ImgBaseData = $_POST['ImgBaseData'];
        $ImageUrl = SendToImgServ($ImgBaseData);
        $Data['Avatar'] = $ImageUrl ? $ImageUrl : '';
        if ($Data['Avatar'] !==''){
            $UpdateAvatar = $MemberUserInfoModule->UpdateInfoByWhere($Data,' UserID =' .$_SESSION['UserID']);
            if ($UpdateAvatar){
                $_SESSION['Avatar'] = $Data['Avatar'];
                $result_json = array('ResultCode'=>200,'Message'=>'上传成功！','url'=>$Data['Avatar']);
            }else{
                $result_json = array('ResultCode'=>101,'Message'=>'上传失败！');
            }
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'上传失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 完善个人资料（个人、催客、公司、律师事务所）
     */
    public function AddInformation(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_MAIN_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        if ($AjaxData['type']==1){
            if (count($AjaxData['images'])==3){//升级催客
                $AjaxData['type'] =2;
                $Data['CardHold'] = $AjaxData['images'][2];//手持身份证
            }
            $Data['NickName'] = trim($AjaxData['nickName']);//昵称
            $Data['RealName'] = trim($AjaxData['name']);//姓名
            $Data['CardNum'] = trim($AjaxData['idNum']);//身份证号
            $Data['Province'] = trim($AjaxData['province']);//省
            $Data['City'] = trim($AjaxData['city']);//市
            $Data['Area'] = trim($AjaxData['area']); //县
            $Data['Address'] = trim($AjaxData['areaDetail']);//详细地址
            $Data['CardPositive'] = $AjaxData['images'][0];//身份证正面
            $Data['CardNegative'] = $AjaxData['images'][1];//身份证背面
            $Data['QQ'] = trim($AjaxData['qq']);//qq
            $Data['E-Mail'] = trim($AjaxData['email']);//邮箱
            $Data['Identity'] = intval($AjaxData['type']);//类型
            $Url =WEB_MAIN_URL.'/memberperson/';
        }elseif ($AjaxData['type']==2){
            $Data['NickName'] = trim($AjaxData['nickName']); //昵称
            $Data['RealName'] = trim($AjaxData['name']); //姓名
            $Data['CardNum'] = trim($AjaxData['idNum']); //身份证号
            $Data['Province'] = trim($AjaxData['province']);//省
            $Data['City'] = trim($AjaxData['city']);//市
            $Data['Area'] = trim($AjaxData['area']); //县
            $Data['Address'] = trim($AjaxData['areaDetail']);//详细地址
            $Data['CardPositive'] = $AjaxData['images'][0];//身份证正面
            $Data['CardNegative'] = $AjaxData['images'][1];//身份证背面
            $Data['CardHold'] = $AjaxData['images'][2];//手持身份证
            $Data['QQ'] = trim($AjaxData['qq']);//qq
            $Data['E-Mail'] = trim($AjaxData['email']); //邮箱
            $Data['Identity'] = intval($AjaxData['type']); //类型
            $Url =WEB_MAIN_URL.'/memberperson/';
        }elseif ($AjaxData['type']==3){
            $Data['CompanyName'] = trim($AjaxData['companyName']);//催收公司名称
            $Data['RealName'] = trim($AjaxData['registrantName']);//公司注册人姓名
            $Data['CardNum'] = trim($AjaxData['idNum']);//注册人身份证号
            $Data['CreditCode'] = trim($AjaxData['creditNum']);//信用代码
            $Data['Province'] = trim($AjaxData['province']);//省
            $Data['City'] = trim($AjaxData['city']);//市
            $Data['Area'] = trim($AjaxData['area']);//县
            $Data['Address'] = trim($AjaxData['areaDetail']); //详细地址
            $Data['CardPositive'] = $AjaxData['registrantImages'][0];//注册人身份证照正面
            $Data['CardNegative'] = $AjaxData['registrantImages'][1];//注册人身份证照背面
            $Data['BusinessImage'] = $AjaxData['license'];//营业执照照片
            $Data['QQ'] = trim($AjaxData['qq']);//qq
            $Data['E-Mail'] = trim($AjaxData['email']); //邮箱
            $Data['Identity'] = intval($AjaxData['type']);//类型
            $Url =WEB_MAIN_URL.'/memberfirm/';
        }elseif ($AjaxData['type']==4){
            $Data['RealName'] = trim($AjaxData['name']);//姓名
            $Data['CardNum'] = trim($AjaxData['idNum']);//身份证号
            $Data['ProfessionalNum'] = trim($AjaxData['jobNo']);//执业证号
            $Data['CompanyName'] = trim($AjaxData['office']);//所属律师事务所
            $Data['AnnualDueDate'] = $AjaxData['inspectionDate'];//年检时间
            $Data['Province'] = trim($AjaxData['province']);//省
            $Data['City'] = trim($AjaxData['city']);//市
            $Data['Area'] = trim($AjaxData['area']);//县
            $Data['Address'] = trim($AjaxData['areaDetail']); //详细地址
            $Data['LawyerCertificatePhoto'] = $AjaxData['images'][0];//律师资格证照片页
            $Data['LawyerCertificateYear'] = $AjaxData['images'][1];//律师资格证年检页
            $Data['QQ'] = trim($AjaxData['qq']);//qq
            $Data['E-Mail'] = trim($AjaxData['email']); //邮箱
            $Data['Identity'] = intval($AjaxData['type']);//类型
            $Url =WEB_MAIN_URL.'/memberlawyer/';
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'数据出错！');
            EchoResult($result_json);
            exit;
        }
        if ($AjaxData['headImg'])
            $Data['Avatar'] = $AjaxData['headImg']; //头像
        $Data['IdentityState'] =2;
        $_SESSION['Identity'] = $AjaxData['type'];
        $MemberUserInfoModule = new MemberUserInfoModule();
        $UpdateInfo = $MemberUserInfoModule->UpdateInfoByWhere($Data,' UserID='.$_SESSION['UserID']);
        if ($UpdateInfo){
            $result_json = array('ResultCode'=>200,'Message'=>'保存成功！', 'Url' => $Url);
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'信息未修改！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 催收公司设置佣金方案
     */
    public function SetFirmDemand(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_MAIN_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        if (count($AjaxData['fee_rate'])==2){
            if ($AjaxData['fee_rate'][1]['from'] >$AjaxData['fee_rate'][0]['from'] && $AjaxData['fee_rate'][1]['from'] < $AjaxData['fee_rate'][0]['to']){
                $result_json = array('ResultCode' => 102, 'Message' => '佣金范围不能重叠！');
                EchoResult($result_json);
            }
            if ($AjaxData['fee_rate'][1]['to'] >$AjaxData['fee_rate'][0]['from'] && $AjaxData['fee_rate'][1]['to'] < $AjaxData['fee_rate'][0]['to']){
                $result_json = array('ResultCode' => 102, 'Message' => '佣金范围不能重叠！');
                EchoResult($result_json);
            }
        }
        $Data['UserID'] = $_SESSION['UserID'];
        $Data['CaseName']= $AjaxData['case_name'];
        $Data['EarlyCost'] = $AjaxData['fee'];//有无前期费用
        $Data['FindDebtor'] = $AjaxData['searchedAnytime'];//债务人是否随时找得到
        $Data['RepaymentDebtor'] = $AjaxData['abilityDebt'];//债务人有无还款能力
        $Data['Commission'] =json_encode($AjaxData['fee_rate']);//佣金范围和金额
        $Data['Area'] = json_encode($AjaxData['area']) ;//服务地区
        $MemberSetCollectionModule = new MemberSetCollectionModule();
        if (!empty($_POST['ID'])){
            $ID = intval($_POST['ID']);
            $Data['UpdateTime'] = time();
            $Result = $MemberSetCollectionModule->UpdateInfoByKeyID($Data,$ID);
            if ($Result){
                $result_json = array('ResultCode'=>200,'Message'=>'更新成功！','Url'=>'/memberfirm/demandlist/');
            }else{
                $result_json = array('ResultCode'=>103,'Message'=>'信息未修改！');
            }
        }else{
            $Data['AddTime'] = time();
            $Data['UpdateTime'] = $Data['AddTime'];
            $Insert = $MemberSetCollectionModule->InsertInfo($Data);
            if ($Insert){
                $result_json = array('ResultCode'=>200,'Message'=>'保存成功！','Url'=>'/memberfirm/demandlist/');
            }else{
                $result_json = array('ResultCode'=>104,'Message'=>'信息未修改！');
            }
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 律师团队设置佣金方案
     */
    public function SetLawyerDemand(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_MAIN_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
        $AjaxData= json_decode(stripslashes($_POST['AjaxJSON']),true);
        if (count($AjaxData['fee_rate'])==2){
            if ($AjaxData['fee_rate'][1]['from'] >$AjaxData['fee_rate'][0]['from'] && $AjaxData['fee_rate'][1]['from'] < $AjaxData['fee_rate'][0]['to']){
                $result_json = array('ResultCode' => 102, 'Message' => '佣金范围不能重叠！');
                EchoResult($result_json);
            }
            if ($AjaxData['fee_rate'][1]['to'] >$AjaxData['fee_rate'][0]['from'] && $AjaxData['fee_rate'][1]['to'] < $AjaxData['fee_rate'][0]['to']){
                $result_json = array('ResultCode' => 102, 'Message' => '佣金范围不能重叠！');
                EchoResult($result_json);
            }
        }
        $Data['UserID'] = $_SESSION['UserID'];
        $Data['CaseName']= $AjaxData['case_name'];
        $Data['Commission'] =json_encode($AjaxData['fee_rate']);//佣金范围和金额
        $Data['Area'] = json_encode($AjaxData['area']) ;//服务地区

        $MemberSetLawyerfeeModule = new MemberSetLawyerfeeModule();
        if (!empty($_POST['ID'])){
            $ID = intval($_POST['ID']);
            $Data['UpdateTime'] = time();
            $Result = $MemberSetLawyerfeeModule->UpdateInfoByKeyID($Data,$ID);
            if ($Result){
                $result_json = array('ResultCode'=>200,'Message'=>'更新成功！','Url'=>'/memberlawyer/demandlist/');
            }else{
                $result_json = array('ResultCode'=>103,'Message'=>'信息未修改！');
            }
        }else{
            $Data['AddTime'] = time();
            $Data['UpdateTime'] = $Data['AddTime'];
            $Insert = $MemberSetLawyerfeeModule->InsertInfo($Data);
            if ($Insert){
                $result_json = array('ResultCode'=>200,'Message'=>'保存成功！','Url'=>'/memberlawyer/demandlist/');
            }else{
                $result_json = array('ResultCode'=>104,'Message'=>'信息未修改！');
            }
        }
        EchoResult($result_json);
        exit;
    }
}