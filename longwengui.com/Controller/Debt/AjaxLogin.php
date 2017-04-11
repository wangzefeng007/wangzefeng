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
                        $Data['IP'] = GetIP();
                        $InfoData['Avatar']='/Uploads/Debt/imgs/head_img.png';
                        $InsertInfo =$UserInfo->InsertInfo($InfoData);
                        if (!$InsertInfo){
                            $DB->query("ROLLBACK");//判断当执行失败时回滚
                            $json_result = array('ResultCode' => 105, 'Message' => '注册失败',);
                            echo json_encode($json_result);exit;
                        }
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

        $Data['UserID'] = $_SESSION['UserID'];
        $Data['CaseName']= $AjaxData['case_name'];
        $Data['FindDebtor']= $AjaxData['searchedAnytime'];
        $Data['EarlyCost']= $AjaxData['fee'];
        $Data['RepaymentDebtor']= $AjaxData['abilityDebt'];
        $Data['FromMoney'] =($AjaxData['fee_rate'][0]['from']);
        $Data['ToMoney'] =($AjaxData['fee_rate'][0]['to']);
        $Data['MoneyScale'] =($AjaxData['fee_rate'][0]['rate']);
        $Data['Province'] = ($AjaxData['area'][0]['province']);
        $Data['City'] = ($AjaxData['area'][0]['city']);
        $Data['Area'] = ($AjaxData['area'][0]['area']);
        $MemberSetCompanyModule = new MemberSetCompanyModule();
        if (!empty($_POST['ID'])){
            $ID = intval($_POST['ID']);
            $Data['UpdateTime'] = time();
            $Result = $MemberSetCompanyModule->UpdateInfoByKeyID($Data,$ID);
            if ($Result){
                $result_json = array('ResultCode'=>200,'Message'=>'更新成功！','Url'=>'/memberfirm/demandlist/');
            }else{
                $result_json = array('ResultCode'=>103,'Message'=>'信息未修改！');
            }
        }else{
            $Data['AddTime'] = time();
            $Data['UpdateTime'] = $Data['AddTime'];
            $Insert = $MemberSetCompanyModule->InsertInfo($Data);
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

        $Data['UserID'] = $_SESSION['UserID'];
        $Data['CaseName']= $AjaxData['caseName'];
        $Data['FromMoney'] =($AjaxData['feeRate'][0]['from']);
        $Data['ToMoney'] =($AjaxData['feeRate'][0]['to']);
        $Data['Money'] =($AjaxData['feeRate'][0]['fee']);
        $Data['Province'] = ($AjaxData['area'][0]['province']);
        $Data['City'] = ($AjaxData['area'][0]['city']);
        $Data['Area'] = ($AjaxData['area'][0]['area']);
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
    /**
     * @desc 删除律师团队佣金方案
     */
    public function DeleteLawyerDemand(){
        $MemberSetLawyerfeeModule = new MemberSetLawyerfeeModule();
    }
    /**
     * @desc 删除催收公司佣金方案
     */
    public function DeleteFirmDemand(){
        $MemberSetCompanyModule = new MemberSetCompanyModule();
    }
    /**
     * @desc 用户确认完成发布悬赏
     */
    public function ConfirmReword(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录', 'Url' => WEB_MAIN_URL.'/member/login/');
            EchoResult($result_json);
            exit;
        }
        if($_POST['id']){
            $ID  = intval($_POST['id']);
            $MemberRewardInfoModule = new MemberRewardInfoModule();
            $RewardInfo = $MemberRewardInfoModule->GetInfoByWhere(' and ID ='.$ID.' and UserID = '.$_SESSION['UserID']);
            if ($RewardInfo['Status']==3){
                $Data['Status']=4;
                $UpdateReward = $MemberRewardInfoModule->UpdateInfoByKeyID($Data,$ID);
                if ($UpdateReward){
                    $result_json = array('ResultCode'=>200,'Message'=>'更新成功！');
                }else{
                    $result_json = array('ResultCode'=>101,'Message'=>'更新失败！');
                }
            }else{
                $result_json = array('ResultCode'=>102,'Message'=>'当前状态是待审核，待发布之后方可确认');
            }
        }else{
            $result_json = array('ResultCode'=>103,'Message'=>'更新失败，未提交相应数据');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 委托方申请接单，发布者同意接单申请
     */
    public function AgreeApply(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录');
            EchoResult($result_json);
            exit;
        }
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberUserModule = new MemberUserModule();
        $User = $MemberUserModule->GetInfoByKeyID($_SESSION['UserID']);//发布者用户信息
        if ($_POST){
            //开始事务
            global $DB;
            $DB->query("BEGIN");
            $DebtID = $_POST['debtId'];
            $ID = $_POST['id'];
            $ClaimsDisposal = $MemberClaimsDisposalModule->GetInfoByKeyID($ID);
            //更新债务信息表，更改状态和委托用户ID
            $UpdateDebtInfo =$MemberDebtInfoModule->UpdateInfoByKeyID(array('Status'=>2,'MandatorID'=>$ClaimsDisposal['UserID']),$DebtID);
            if ($UpdateDebtInfo){
                $MemberClaimsDisposalModule->UpdateInfoByWhere(array('Agreed'=>2,'Status'=>10),' DebtID = '.$DebtID.' and ID != '.$ID);//拒绝的同时，该申请债务状态为已拒绝。
                $UpdateInfo = $MemberClaimsDisposalModule->UpdateInfoByKeyID(array('Agreed'=>1,'Status'=>2),$ID);
                if ($UpdateInfo){
                    $MandatorUser = $MemberUserModule->GetInfoByKeyID($ClaimsDisposal['UserID']);//委托方用户信息
                    ToolService::SendSMSNotice($MandatorUser['Mobile'], '亲爱的隆文贵网用户');//发送短信给委托方
                    ToolService::SendSMSNotice($User['Mobile'], '亲爱的隆文贵网用户');//发送短信给发布者
                    ToolService::SendSMSNotice(18039847468, '站内客服，有债务已确认，请及时跟进，债务编号：');//发送短信给内部客服人员
                    $DB->query("COMMIT");//执行事务
                    $result_json = array('ResultCode'=>200,'Message'=>'操作成功！');
                }else{
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode'=>101,'Message'=>'操作失败！','Remarks'=>'更新申请表状态失败');
                }
            }else{
                $DB->query("ROLLBACK");//判断当执行失败时回滚
                $result_json = array('ResultCode'=>102,'Message'=>'操作失败！','Remarks'=>'更新债务状态失败');
            }
        }else{
            $result_json = array('ResultCode'=>103,'Message'=>'操作失败！');
        }
        EchoResult($result_json);
        exit;
    }

    /**
     * @desc 委托方申请接单，发布者拒绝接单申请
     */
    public function RejectApply(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录');
            EchoResult($result_json);
            exit;
        }
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        if ($_POST){
            $DebtID = $_POST['debtId'];
            $ID = $_POST['id'];
            $UpdateInfo = $MemberClaimsDisposalModule->UpdateInfoByKeyID(array('Agreed'=>2,'Status'=>10),$ID);//拒绝的同时，该申请债务状态为已拒绝。
            if ($UpdateInfo){
                $result_json = array('ResultCode'=>200,'Message'=>'操作成功！');
            }else{
                $result_json = array('ResultCode'=>101,'Message'=>'操作失败！');
            }
        }else{
            $result_json = array('ResultCode'=>102,'Message'=>'操作失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 待接单发布者取消发布
     */
    public function CancelDebt(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录');
            EchoResult($result_json);
            exit;
        }
        if($_POST){
            $MemberDebtInfoModule = new MemberDebtInfoModule();
            $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
            $DebtID = $_POST['id'];
            $Data['Remarks'] = $_POST['reason'];
            $Data['Status'] = 9;//取消发布
            $Data['UpdateTime'] = time();
            $UpdateDebtInfo = $MemberDebtInfoModule->UpdateInfoByKeyID($Data,$DebtID);
            if ($MemberClaimsDisposalModule->GetInfoByWhere(' and DebtID = '.$DebtID)){
                $MemberClaimsDisposalModule->UpdateInfoByWhere(array('Agreed'=>2,'Status'=>9),' DebtID = '.$DebtID);//更改申请表状态，状态为拒绝。债务状态为取消发布
            }
            if ($UpdateDebtInfo){
                $result_json = array('ResultCode'=>200,'Message'=>'操作成功！');
            }else{
                $result_json = array('ResultCode'=>101,'Message'=>'操作失败！');
            }
            EchoResult($result_json);
            exit;
        }
    }
    /**
     * @desc 委托方选择完成情况（确认完成情况）
     */
    public function ConfirmCompletion(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录');
            EchoResult($result_json);
            exit;
        }
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $Data['Status'] =intval($_POST['Status']);//完成情况
        $DebtID = intval($_POST['id']);
        //开始事务
        global $DB;
        $DB->query("BEGIN");
        $UpdateDebtInfo = $MemberDebtInfoModule->UpdateInfoByKeyID($Data,$DebtID);
        $UpdateClaimsDisposal = $MemberClaimsDisposalModule->UpdateInfoByWhere($Data, ' DebtID = '.$DebtID.' and UserID= '.$_SESSION['UserID']);
        if ($UpdateDebtInfo && $UpdateClaimsDisposal){
            $DB->query("COMMIT");//执行事务
            $result_json = array('ResultCode'=>200,'Message'=>'操作成功！');
        }else{
            $DB->query("ROLLBACK");//判断当执行失败时回滚
            $result_json = array('ResultCode'=>101,'Message'=>'操作失败！');
        }
        EchoResult($result_json);
        exit;
    }
    /**
     * @desc 发布者债务未完成选择继续发布债务
     */
    public function PublishAgain(){
        if (!isset($_SESSION['UserID']) || empty($_SESSION['UserID'])) {
            $result_json = array('ResultCode' => 101, 'Message' => '请先登录');
            EchoResult($result_json);
            exit;
        }
        $MemberDebtInfoModule = new MemberDebtInfoModule();
        $MemberCreditorsInfoModule = new MemberCreditorsInfoModule();
        $MemberDebtorsInfoModule = new MemberDebtorsInfoModule();
        $MemberClaimsDisposalModule = new MemberClaimsDisposalModule();
        $DebtID = intval($_POST['id']);
        $MemberDebtInfoModule->UpdateInfoByKeyID(array('Status'=>6),$DebtID);//更改债务表债务状态为未曝光
        $MemberClaimsDisposalModule->UpdateInfoByWhere(array('Status'=>6),' DebtID = '.$DebtID);//更改申请表债务状态为未曝光
        $DebtInfo = $MemberDebtInfoModule->GetInfoByKeyID($DebtID);
        if ($DebtInfo){
            $DebtInfo['AddTime'] = time();
            $DebtInfo['Status'] = 1;
            $DebtInfo['EntrustNum'] = 1;//委托数量
            $DebtInfo['UpdateTime'] = $DebtInfo['AddTime'];
            $DebtInfo['DebtNum'] ='DB'.date("YmdHis").rand(100, 999);
            unset($DebtInfo['DebtID'],$DebtInfo['Remarks'],$DebtInfo['BrowseNum'],$DebtInfo['MandatorID']);
            //开始事务
            global $DB;
            $DB->query("BEGIN");
            $NewDebtID = $MemberDebtInfoModule->InsertInfo($DebtInfo);
            if ($NewDebtID){
                $CreditorsInfo = $MemberCreditorsInfoModule->GetInfoByWhere(' and DebtID ='.$DebtID,true);
                //债权人信息
                $Datb['AddTime'] = $DebtInfo['AddTime'];
                $Datb['DebtID'] = $NewDebtID;
                foreach ($CreditorsInfo as $key => $value) {
                    $Datb['Name'] = trim($value['Name']);
                    $Datb['Card'] = trim($value['Card']);
                    $Datb['Money'] = trim($value['Money']);
                    $Datb['Phone'] = trim($value['Phone']);
                    $Datb['Province'] = trim($value['Province']);
                    $Datb['City'] = trim($value['City']);
                    $Datb['Area'] = trim($value['Area']);
                    $Datb['Address'] = trim($value['Address']);
                    $InsertCreditorsInfo = $MemberCreditorsInfoModule->InsertInfo($Datb);
                    if (!$InsertCreditorsInfo) {
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $result_json = array('ResultCode' => 201, 'Message' => '录入债权人信息失败');
                        EchoResult($result_json);
                        exit;
                    }
                }
                if ($InsertCreditorsInfo){
                    $DB->query("COMMIT");//执行事务
                    //债务人信息
                    $DebtorsInfo = $MemberDebtorsInfoModule->GetInfoByWhere(' and DebtID ='.$DebtID,true);
                    $Datc['AddTime'] = $DebtInfo['AddTime'];
                    $Datc['DebtID'] = $NewDebtID;
                    foreach ($DebtorsInfo as $key => $value) {
                        $Datc['Name'] = trim($value['Name']);
                        $Datc['Card'] = trim($value['Card']);
                        $Datc['Money'] = trim($value['Money']);
                        $Datc['Phone'] = trim($value['Phone']);
                        $Datc['Province'] = trim($value['Province']);
                        $Datc['City'] = trim($value['City']);
                        $Datc['Area'] = trim($value['Area']);
                        $Datc['Address'] = trim($value['Address']);
                        $InsertDebtorsInfo = $MemberDebtorsInfoModule->InsertInfo($Datc);
                        if (!$InsertDebtorsInfo) {
                            $DB->query("ROLLBACK");//判断当执行失败时回滚
                            $result_json = array('ResultCode' => 101, 'Message' => '录入债务人信息失败');
                            EchoResult($result_json);
                            exit;
                        }
                    }
                    if ($InsertDebtorsInfo){
                        $DB->query("COMMIT");//执行事务
                        $result_json = array('ResultCode' => 200, 'Message' => '操作成功');
                    }else{
                        $DB->query("ROLLBACK");//判断当执行失败时回滚
                        $result_json = array('ResultCode'=>103,'Message'=>'操作失败！');
                    }
                }else{
                    $DB->query("ROLLBACK");//判断当执行失败时回滚
                    $result_json = array('ResultCode'=>104,'Message'=>'操作失败！');
                }
            }else{
                $DB->query("ROLLBACK");//判断当执行失败时回滚
                $result_json = array('ResultCode'=>105,'Message'=>'操作失败！');
            }
        }
        EchoResult($result_json);
        exit;
    }

}