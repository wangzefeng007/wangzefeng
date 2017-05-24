<?php

/**
 *@desc 会员中心管理
 */
class User
{
    public function __construct()
    {
        IsLogin();
    }


    /**
     * @desc 会员中心列表
     */
    public function UserLists()
    {
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        $MysqlWhere = '';
        $PageSize = 10;
        $PageUrl = '';
        $Title = $_GET['Title'];
        if ($Title) {
            $MysqlWhere .= " and UserID = $Title ";
            $PageUrl .= "&Title=$Title";
        }
        // 跳转到该页面
        if ($_POST['Page']) {
            $page = $_POST['Page'];
            tourl('/index.php?Module=User&Action=UserLists&Page=' . $page . $PageUrl);
        }
        $Page = intval($_GET['Page']) ? intval($_GET['Page']) : 1;
        $ListsNum = $MemberUserModule->GetListsNum($MysqlWhere);
        $Rscount = $ListsNum ['Num'];
        if ($Rscount) {
            $Data ['RecordCount'] = $Rscount;
            $Data ['PageSize'] = ($PageSize ? $PageSize : $Data ['RecordCount']);
            $Data ['PageCount'] = ceil($Data ['RecordCount'] / $PageSize);
            if ($Page > $Data ['PageCount'])
                $Page = $Data ['PageCount'];
            $Data ['Page'] = min($Page, $Data ['PageCount']);
            $Offset = ($Page - 1) * $Data ['PageSize'];
            $Data['Data'] = $MemberUserModule->GetLists($MysqlWhere, $Offset, $Data ['PageSize']);
            foreach ($Data['Data'] as $key=>$value){
                $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID = '.$value['UserID']);
                $Data['Data'][$key]['InfoID'] = $UserInfo['InfoID'];
                $Data['Data'][$key]['NickName'] = $UserInfo['NickName'];
                $Data['Data'][$key]['RealName'] = $UserInfo['RealName'];
                $Data['Data'][$key]['Identity'] = $UserInfo['Identity'];
                $Data['Data'][$key]['IdentityState'] = $UserInfo['IdentityState'];
            }
            MultiPage($Data, 10);
        }
        include template("UserLists");
    }
    /**
     * @desc 会员中心详情与审核
     */
    public function UserDetail()
    {
        $MemberUserModule = new MemberUserModule();
        $MemberUserInfoModule = new MemberUserInfoModule();
        $MemberAreaModule = new MemberAreaModule();
        $IdentityStatus = $MemberUserInfoModule->IdentityStatus;
        $Identity = $MemberUserInfoModule->Identity;
        if ($_POST['UserID']) {
            $Data['IdentityState'] = intval($_POST['Status']);
            $UserID = intval($_POST['UserID']);
            $result = $MemberUserInfoModule->UpdateInfoByWhere($Data, ' UserID= ' . $UserID);
            $User = $MemberUserModule->GetInfoByKeyID($UserID);
            if ($result) {
                if ($Data['IdentityState']==3){
                    ToolService::SendSMSNotice($User['Mobile'], '尊敬的用户，您的账户已审核通过，感谢您的使用，详情请登录http://www.longwengui.net/');//发送短信给内部客服人员
                }
                alertandgotopage('操作成功!', '/index.php?Module=User&Action=UserDetail&UserID=' . $UserID);
            } elseif ($result === 0) {
                alertandback('状态未发生改变!');
            } else {
                alertandback('操作失败!');
            }
        }
        if ($_GET['UserID']) {
            $UserID = $_GET['UserID'];
            $UserInfo = $MemberUserInfoModule->GetInfoByWhere(' and UserID= '.$UserID);
            if ($UserInfo['Province'])
            $UserInfo['Province'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Province']);
            if ($UserInfo['City'])
            $UserInfo['City'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['City']);
            if ($UserInfo['Area'])
            $UserInfo['Area'] = $MemberAreaModule->GetCnNameByKeyID($UserInfo['Area']);
            $UserInfo['LastLogin'] = !empty($UserInfo['LastLogin'])? date('Y-m-d H:i:s',$UserInfo['LastLogin']): '';
            $UserInfo['AnnualDueDate'] = !empty($UserInfo['AnnualDueDate'])? date('Y-m-d H:i:s',$UserInfo['AnnualDueDate']): '';
            $User = $MemberUserModule->GetInfoByKeyID($UserID);
        }
        include template("UserDetail");
    }
     public function Testputong(){
         require_once SYSTEM_ROOTPATH . '/Include/SmsYixinApi.php';
         $SmsYixinApi = new SmsYixinApi ();
         $mobile='15695928612,13696963502,18506061256,18741872641,18850348205,13799456112,13063082394,15960273768,13959223090,18759217098,13834681536,13666069689,13616055993,18030042857,13959218810,13666091748,18959455533,18650015155,18659228355,13616003961,13606918244,17750818939,13295922549,15354408762,18259229280,13375978602,18859209301,13015955656,18150902655,13043103104,15306980292,18650142958,13850096812,18859273062,13860478336,18250857369,13696907596,15359356061,18282768305,15519199493,18859326977,15005090589,18065211524,13159231568,15711560562,15565559981,15805927552,18859230197,15959279927,13950754186,18750227621,13559693925,13599917021,18805176303,13616021703,15080327886,13950126430,18924918289,13860226056,18205906702,13860499256,15985937313,15759257828,18059280498,15136303910,18250889973,15806019253,13799792940,15396202487,18030296785,18668790481,13365922516,13600974562,13505020475,18350565670,18060306195,13799295703,15960377111,15359332522,13559267497,13400664456,13599915282,15396232206,15859218819,13673230229,13666044472,13850093061,13459253065,13910375081,13799780187,18965811150,18259282806,18212013965,18054824966,18559796016,17750617089,15860892883,13981978616,15759261528,15160020927,15304663345,18144002180,15160044598,15060791808,13666029583,15260595355,15980892265,18610009979,13805080688,15159256343,17708540823,18950076540,15980935872,13805095602,13023959743,13616019183,18259587070,15860752212,18719443332,13194085953,13549919151,18900220201,13950188526,15959352411,18030268681,18659626681,18031650908,13123388125,13997183056,13063063739,13023919225,13606019052,18850195277,15959201757,13950152894,18149624506,18950092829,15051611594,18663302207,18695670756,18750501831,13700494455,18050129833,18905061238,18859972321,13790003329,15659989333,13959226058,18960068468,15306986229,15986374506,13685081861,15259670220,18030130342,18950136162,15603390158,13950192054,13589927880,18423560779,15160035655,15860757298,13606064302,18065927126,13358386889,18359813831,13850084202,18605026113,13600918931,13950110716,13696928507,15860608761,15775106119,15759084220,15159253387,13459146406,13666099964,15920138994,13696969201,13210980676,13600931687,13063082383,13606923905,15106352527,15960841401,18965198333,18620905293,13015958686,13696988021,18750255374,15960252809,13906098326,18159248752,13055676188,15860787775,18120755250,18538079976,15006939878,13906007107,13400666141,13370551823,18950065229,15980995539,15860789850,13003994756,13959220677,13696924599,18559255069,15857021753,18520372443,18876527200,18605038586,18206066955,18558769992,18559315329,13328319668,15980808817,13959796375,13015910581,18950051310,15306003760,13159200005,15959386641,17750033903,18659938288,15006036656,15959265775,13459200510,15555307816,15880218821,18950035281,18250883362,18650900990,13606903121,15280357058,18250093112,13799834379,13600932883,13860427100,18046235966,15960254677,13043009800,15659817836,13600910483,13779984168,15880212347,18876320682,15960256226,15054816068,18739929181,18950035720,18760671776,13328772220,13606084283,18250882782,15305022251,13860465320,18205919472,15860799320,18859273953,13489993178,13328327745,15260237242,18907568671,13904613248,13696929704,15710688536,18950006260,15960261395,15066310095,15859266827,18030153119,13720898325,18650198347,13906007794,13645074148,18759708407,15980110383,13003887992,15005064122,18650737318,17706901551,15985705995,15259105987,13305009698,18959105273,13645067385,13313756531,18060581929,13055299723,13609503752,18350090071,18950485752,13645068672,15205026974,13705004062,13960768805,13559925084,15659174627,13075883072,15980276115,18159088589,18959127313,13799319423,13509352520,18860111238,15960191775,15259195036,15305909862,18650358346,13003816881,13850187403,13805000483,18558768738,13705052942,13799327030,15659162612,13338263861,13706995788,13705910498,13285914532,13599410433,13763898959,15705961273,13215971120,15005067072,13860614302,13950305376,13559435559,18950370971,13459498501,18396510457,13043508023,15392490482,15205046096,18650387707,15806079924,15859055111,13015760169,18959193888,18650707105,17759102557,13705954893,13067259289,13023886772,13763860259,13295972518,13675050024,13599099598,18805001636,17759101378,15880029228,15959193440,17359109960,13960961596,15960986168,15980616981,15959142079,15060013575,13720833289,18606070555,13055273086,13559173445,18359137190,13675054536,13705959376,13706965798,13215007289,18860171376,13850140197,18259912226,18558719369,13665019481,13509378047,18596782085,13405994416,18859193370,18850106582,13320031513,13950427044,18859172133,18790108987,13003875205,13559125090,15715941880,15659998687,13705043346,18950284546,15880030062,13067289475,13405917050,15960068554,13615000123,13559137873,13124017815,13860670756,13400557698,18060609598,18450076264,15900681863,13067119518,13950345177,13675006136,13860677351,13023806973,15259113533,13635297706,18060585395,13110540885,18705018530,13665029224,15359105326,13075979956,15880075401,18060393901,15280444258,17705021611,18305996503,15980293509,13159412500,15060064382,18350041911,18120820152,13358200178,13358202512,13599050361,15980920622,13600725115,13600902617,15160053022,18205999101,13696935809,15980938242,15711538488,15359293090,18030158118,15859229972,18120785623,15750781035,15960827076,18059269257,13225030778,15659282224,15980895336,13696957542,13205920302,13950155092,13074808279,13950059315,15880280485,13799785511,13779964984,18020730025,18965182232,15259231080,13906034531,18250856651,13860450184,18859262501,15387825958,18950037150,18750235323,18850566534,18659268862,13696923850,13515973933,18650028581,15711557585,13959293518,18850502889,18259476725,13666062571,18206070778,18950111862,18850180180,15959218008,18720577227,18030200867,15960836673,13779922070,15396236393,18030003363,13600957262,15880229654,13950011608,13328323912,18059292199,15859254653,18120725179,13960711639,13074800469,15959393356,15659815770,15160005453,13295923827,18050020753,18060915415,15759283823,15959277695,18850173661,15160003136,13527425823,18506958588,15759231918,13606911769,13313856949,13606054609,18030197155,13459011552,13779923836,13646004969,15960233732,15980817055,13859992143,13860125238,15960826805,18950125153,18059276658,13696972725,18859204320,15959742570,15306030101,13074887592,18860005015,18559761609,15985885498,15080321053,13950062865,18850312553,18284943773,15394488874,18900225596,13074861069,13666015586,18906044999,13860402397,15259208828,18650015569,13313842777,13950076660,13275002901,15980920072,15860768296,13950026651,18965188699,18030062568,13606015380,18005025102,15980868580,18760089819,18959292256,15880266097,15959355521,15960836153,13394040767,18250893525,18750236668,18805065016,18859229156,18150375923,18050123787,13959298513,15805916706,13696910899,15959213125,13774691158,13696983262,13666020829,18039847468,18059289652';
         $content ='您好，我们是隆文贵债务处置网（www.longwengui.com）。我们有专业的律师和上门催收的催收团队，如果你有被债务所困扰，可以咨询电话0592—5253262。或者直接关注微信公众号：互联网不良资产。';
         $result = $SmsYixinApi->yixinSMS($mobile,$content);
         var_dump($result);exit;
     }
    public function Testlvshi(){
        require_once SYSTEM_ROOTPATH . '/Include/SmsYixinApi.php';
        $SmsYixinApi = new SmsYixinApi ();
        $mobile='13666008118,15980996153,15544445544,15060772045,15659988116,15280288334,13295926064,13860444450,15259684389,15960822607,18120733017,14646111011,13268521908,13159237896,17759219575,15159267608,15980814468,17099275886,13811228961,15750728679,18923760681,13074837572,13062447692,18206055425,13400660214,13799776777,13860463316,15980853473,13950057602,18850165056,15394478520,13606095603,15960265750,15080326674,13146365512,18950122739,13799840605,18650801261,13666009124,15710689811,18850149715,18610721315,15009718227,17750585660,18649727036,18649608595,15280262802,15802505542,18951866153,13906058268,18559797600,13858962456,13159209823,13696956759,15980936569,18963660279,13616028180,13600956932,18060914065,13774666345,13256125999,13666085205,13850060245,13696965885,13666081302,15160056258,13606917110,15007454541,18801016246,13400710951,13606068449,18106935450,15980825128,13063051773,13600992888,17090404124,13003914325,18039847468,18059245823,15711513573,13809518466,18705003929,13950200085,15544445544,13600898018,18950442325,15280076315,13850160129,15059156727';
        $content ='您好，这里是隆文贵信息对接平台，（www.longwengui.com）平台借助互联网和大数据向债权人发布的债务进行匹配，现在诚邀律师免费加入，共享资源。平台只会在债务催收成功后，收取律师所得佣金的10%作为平台的推广及维护。';
        $result = $SmsYixinApi->yixinSMS($mobile,$content);
        var_dump($result);exit;
    }
}