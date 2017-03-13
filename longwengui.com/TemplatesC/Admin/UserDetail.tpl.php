<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from UserDetail.htm on 2017-03-10 17:09:21
*/
?><?php include template('Head'); ?><div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb panel">
                <li>
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="/index.php?Module=User&Action=UserLists" class="position">会员管理</a>
                </li>
                <li class="active">会员详情</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <td colspan="3" class="t-h">会员详情：</td>
                        </tr>
                        <tr>
                            <td>会员ID：<?php echo $UserInfo[UserID];?></td>
                            <td>昵称：<?php echo $UserInfo[NickName];?></td>
                            <td>手机号：<?php echo $User[Mobile];?></td>
                        </tr>
                        <tr>
                            <td>邮箱：<?php echo $User['E-Mail'];?></td>
                            <td>真实姓名：<?php echo $UserInfo[RealName];?></td>
                            <td>性别：<?php if($UserInfo[Sex]==0) { ?>保密<?php } elseif($UserInfo[Sex]==1) { ?>女<?php } elseif($UserInfo[Sex]==2) { ?>男<?php } ?></td>
                        </tr>
                        <tr>
                            <td>详细地址：<?php echo $UserInfo[Address];?></td>
                            <td>证件号码：<?php echo $UserInfo[CardNum];?></td>
                            <td>审核状态：<?php if($UserInfo[IdentityState]==1) { ?>未提交审核<?php } elseif($UserInfo[IdentityState]==2) { ?>审核中<?php } elseif($UserInfo[IdentityState]==3) { ?>审核通过<?php } elseif($UserInfo[IdentityState]==4) { ?>审核不通过<?php } ?></td>
                        </tr>
                        <tr>
                            <td>登录IP：<?php echo $UserInfo[IP];?></td>
                            <td>身份：<?php if($UserInfo[Identity]==1) { ?>个人用户<?php } elseif($UserInfo[Identity]==2) { ?>催客<?php } elseif($UserInfo[Identity]==3) { ?>公司会员<?php } elseif($UserInfo[Identity]==4) { ?>律师企业会员<?php } ?></td>
                            <td>QQ：<?php echo $UserInfo[QQ];?></td>
                        </tr>
                        <tr>
                            <td>地区：<?php echo $UserInfo[Province];?>-<?php echo $UserInfo[City];?>-<?php echo $UserInfo[Area];?></td>
                            <td>详细地址：<?php echo $UserInfo[Address];?></td>
                            <td>最后登录时间：<?php echo $UserInfo[LastLogin];?></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="t-h"><h5>&nbsp;&nbsp;身份证图片：</h5> </td>

                        </tr>
                        <tr>
                            <td>身份证正面:<a href="<?php echo $UserInfo[CardPositive];?>" target="_blank"><img src="<?php echo $UserInfo[CardPositive];?>" height="150px" width="150px" title="点击显示大图"></a></td>
                            <td>身份证反面:<a href="<?php echo $UserInfo[CardNegative];?>" target="_blank"><img src="<?php echo $UserInfo[CardNegative];?>" width="150px" height="150px" title="点击显示大图"></a></td>
                            <td>手持身份证:<a href="<?php echo $UserInfo[CardHold];?>" target="_blank"><img src="<?php echo $UserInfo[CardHold];?>" width="150px" height="150px"  title="点击显示大图"></a></td>
                        </tr>
                    </table>
                    <table class="table table-bordered table-striped table-hover">
                        <form action='/index.php?Module=User&Action=UserDetail'  method='post'  enctype="multipart/form-data">
                            <tbody>
                            <tr>
                                <td class="t-r" width="150">审核状态：</td>
                                <td>
                                    <select name="Status" id="Status" class="form-control" style="width:200px;float:left;margin-right: 10px" onchange="GetNewTourAreaID(this.value)" >
                                        <option value="1" <?php if($UserInfo[IdentityState] == 1) { ?>selected="selected"<?php } ?>>未提交审核</option>
                                        <option value="2" <?php if($UserInfo[IdentityState] == 2) { ?>selected="selected"<?php } ?>>审核中</option>
                                        <option value="3" <?php if($UserInfo[IdentityState] == 3) { ?>selected="selected"<?php } ?>>审核通过</option>
                                        <option value="4" <?php if($UserInfo[IdentityState] == 4) { ?>selected="selected"<?php } ?>>审核不通过</option>
                                    </select>
                                    <input type="hidden" name="UserID" value="<?php echo $UserID;?>" />
                                    <input class="btn btn-danger" type="submit" name="submit" value="修改">
                                </td>
                            </tr>
                            </tbody>
                        </form>
                    </table>
                    <tr>
                        <td><a class="right" href="/index.php?Module=User&Action=UserLists">返回列表</a></td>
                    </tr>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 底部 --><?php include template('Foot'); ?>