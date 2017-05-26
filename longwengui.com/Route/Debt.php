<?php
$RouteArr=array(
    //'控制器小写@方法小写'=>'真实控制器名@真实方法名'
    //法律援助
    'legalaid@index'=>'LegalAid@Index',
    //债务催收
    'debt@test'=>'Debt@Test',
    'debt@index'=>'Debt@Index',
    'debt@debtlists'=>'Debt@DebtLists',
    'debt@debtdetails'=>'Debt@DebtDetails',
    'debt@publish'=>'Debt@DebtPublish',
    //线索悬赏
    'reword@index'=>'Reword@Index',
    'reword@publish'=>'Reword@RewordPublish',
    //资产转让
    'asset@publish'=>'Asset@Publish',
    'asset@lists'=>'Asset@Lists',
    'asset@details'=>'Asset@Details',
    'asset@order'=>'Asset@Order',
    'asset@choicepay'=>'Asset@ChoicePay',
    'asset@pay'=>'Asset@Pay',
    //寻找处置方
    'find@choicefind'=>'Find@ChoiceFind',
    //搜索老赖
    'deadbeat@index'=>'DeadBeat@Index',
    //会员中心
    'member@login'=>'Member@Login',
    'member@signout'=>'Member@SignOut',
    'member@register'=>'Member@Register',
    'member@registertwo'=>'Member@RegisterTwo',
    'member@registerthree'=>'Member@RegisterThree',
    'member@registerfour'=>'Member@RegisterFour',
    'member@findpasswd'=>'Member@FindPasswd',
    'member@changemobile'=>'Member@ChangeMobile',
    'member@editpassword'=>'Member@EditPassWord',
    'member@reword'=>'Member@Reword',
    'member@wallet'=>'Member@Wallet',
    'member@systemmessage'=>'Member@SystemMessage',
    'member@advice'=>'Member@Advice',
    'member@center'=>'Member@Center',
    'member@assetlist'=>'Member@AssetList',
    'member@sellorderlist'=>'Member@SellOrderList',
    'member@sellorderdetail'=>'Member@SellOrderDetail',
    'member@sellorderrefund'=>'Member@SellOrderRefund',
    'member@buyorderlist'=>'Member@BuyOrderList',
    'member@buyorderdetail1'=>'Member@BuyOrderDetail1',
    'member@buyorderrefund'=>'Member@BuyOrderRefund',

    //普通会员中心
    'memberperson@index'=>'MemberPerson@Index',
    'memberperson@editinfo'=>'MemberPerson@EditInfo',
    'memberperson@applydebtorder'=>'MemberPerson@ApplyDebtOrder',
    'memberperson@bondlist'=>'MemberPerson@BondList',
    'memberperson@debtlist'=>'MemberPerson@DebtList',
    'memberperson@demandlist'=>'MemberPerson@DemandList',
    'memberperson@demanddetails'=>'MemberPerson@DemandDetails',
    'memberperson@setdemand'=>'MemberPerson@SetDemand',
    'memberperson@focusdebtlist'=>'MemberPerson@FocusDebtList',
    'memberperson@download'=>'MemberPerson@Download',
    //律师会员中心
    'memberlawyer@index'=>'MemberLawyer@Index',
    'memberlawyer@editinfo'=>'MemberLawyer@EditInfo',
    'memberlawyer@applydebtorder'=>'MemberLawyer@ApplyDebtOrder',
    //催收公司会员中心
    'memberfirm@index'=>'MemberFirm@Index',
    'memberfirm@editinfo'=>'MemberFirm@EditInfo',
    'memberfirm@applydebtorder'=>'MemberFirm@ApplyDebtOrder',
    'memberfirm@creditorder'=>'MemberFirm@CreditOrder',
    'memberfirm@demandlist'=>'MemberFirm@DemandList',
    'memberfirm@demanddetails'=>'MemberFirm@DemandDetails',
    'memberfirm@setdemand'=>'MemberFirm@SetDemand',
    //律师事务所
    'memberlawfirm@index'=>'MemberLawFirm@Index',
    'memberlawfirm@editinfo'=>'MemberLawFirm@EditInfo',
    'memberlawfirm@applydebtorder'=>'MemberLawFirm@ApplyDebtOrder',
    'memberlawfirm@focusdebtlist'=>'MemberLawFirm@FocusDebtList',
    'memberlawfirm@aidlist'=>'MemberLawFirm@AidList',
    'memberlawfirm@setaid'=>'MemberLawFirm@SetAid',
    'memberlawfirm@aiddetails'=>'MemberLawFirm@AidDetails',
    //订单支付
    'pay@alipay'=>'Pay@AliPay',
    'pay@alipaynotify'=>'Pay@AliPayNotify',
    'pay@result'=>'Pay@Result',
    'pay@wxresult'=>'Pay@WxResult',

    //Ajax
    'ajaximage@index'=>'AjaxImage@Index',
    'ajaxasset@index'=>'AjaxAsset@Index',
    'ajaxorder@index'=>'AjaxOrder@Index',
);
