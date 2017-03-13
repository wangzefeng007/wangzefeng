<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from DebtEdit.htm on 2017-03-10 18:57:52
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
                    <a href="#">债务信息管理</a>
                </li>
                <li>
                    <a href="/index.php?Module=Debt&Action=DebtLists" class="position">债务管理</a>
                </li>
                <li class="active position">债务列表</li>
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
                                <td colspan="3" class="t-h">债务人信息：</td>
                            </tr>
                            <tr>
                                <td>发布人：<?php echo $UserInfo[RealName];?></td>
                                <td>债务人名字：<?php echo $DebtInfo[DebtInfo][0][name];?></td>
                                <td>债务人身份证：<?php echo $DebtInfo[DebtInfo][0]['card'];?></td>
                            </tr>
                            <tr>
                                <td>债务编号：<?php echo $DebtInfo[DebtNum];?></td>
                                <td>催收类型：<?php if($DebtInfo[CollectionType]==1) { ?>自助催收<?php } elseif($DebtInfo[CollectionType]==2) { ?>委托催收<?php } ?></td>
                                <td>债务曝光：<?php if($DebtInfo[DebtExposure]==0) { ?>隐藏<?php } elseif($DebtInfo[DebtExposure]==1) { ?>曝光<?php } ?></td>
                            </tr>
                            <tr>
                                <td>地区：<?php echo $DebtInfo[DebtInfo][0]['province'];?>-<?php echo $DebtInfo[DebtInfo][0]['city'];?>-<?php echo $DebtInfo[DebtInfo][0]['area'];?></td>
                                <td>金额：<?php echo $DebtInfo[DebtInfo][0]['money'];?></td>
                                <td>逾期时间：<?php echo $DebtInfo[Overduetime];?></td>
                            </tr>
                                <tr>
                                <td>借款原因：<?php echo $DebtInfo[ReasonsBorrowing];?></td>
                                <td>债务近况：<?php echo $DebtInfo[DebtRecent];?></td>
                                <td>联系电话：<?php echo $DebtInfo[DebtInfo][0]['phone'];?></td>
                            </tr>
                            <tr>
                                <td>债务人有无还款能力：<?php if($DebtInfo[RepaymentDebtor]==0) { ?>否<?php } elseif($DebtInfo[RepaymentDebtor]==1) { ?>是<?php } ?></td>
                                <td>债务人是否随时找得到：<?php if($DebtInfo[FindDebtor]==0) { ?>否<?php } elseif($DebtInfo[FindDebtor]==1) { ?>是<?php } ?></td>
                                <td>有无抵押物：<?php if($DebtInfo[Guarantee]==0) { ?>无<?php } elseif($DebtInfo[Guarantee]==1) { ?>有<?php } ?></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="t-h">债权人信息：</td>
                            </tr>
                            <tr>
                                <td>债权人姓名：<?php echo $DebtInfo[CreditorsInfo][0]['name'];?></td>
                                <td>债权人身份证：<?php echo $DebtInfo[CreditorsInfo][0]['card'];?></td>
                                <td>联系电话：<?php echo $DebtInfo[CreditorsInfo][0]['phone'];?></td>
                            </tr>
                            <tr>
                                <td>地区：<?php echo $DebtInfo[CreditorsInfo][0]['province'];?>-<?php echo $DebtInfo[CreditorsInfo][0]['city'];?>-<?php echo $DebtInfo[CreditorsInfo][0]['area'];?></td>
                                <td>详细地址：<?php echo $DebtInfo[CreditorsInfo][0]['address'];?></td>
                                <td>债权金额：<?php echo $DebtInfo[CreditorsInfo][0]['money'];?></td>
                            </tr>
                            <tr>
                                <td>委托数量：<?php echo $DebtInfo[EntrustNum];?></td>
                                <td>债权人数量：<?php echo $DebtInfo[BondsNum];?></td>
                                <td>有无保证人：<?php if($DebtInfo[Warrantor]==0) { ?>无<?php } elseif($DebtInfo[Warrantor]==1) { ?>有<?php } ?></td>
                            </tr>
                             <tr>
                                <td colspan="3" class="t-h">保证人信息：</td>
                            </tr>
                            <tr>
                                <td>保证人姓名：<?php echo $DebtInfo[WarrantorInfo][0]['name'];?></td>
                                <td>身份证身份证：<?php echo $DebtInfo[WarrantorInfo][0]['card'];?></td>
                                <td>联系电话：<?php echo $DebtInfo[WarrantorInfo][0]['phone'];?></td>
                            </tr>
                             <tr>
                                <td colspan="3" class="t-h">抵押物信息：</td>
                            </tr>
                            <tr>
                                <td>抵押物名称：<?php echo $DebtInfo[GuaranteeInfo][0]['name'];?></td>
                                <td colspan="2">抵押物介绍：<?php echo $DebtInfo[GuaranteeInfo][0]['content'];?></td>
                            </tr>
                        </table>
                    <table class="table table-bordered table-striped table-hover">
                        <form action='/index.php?Module=Debt&Action=DebtEdit'  method='post'  enctype="multipart/form-data">
                            <tbody>
                                <tr>
                                    <td class="t-r" width="150">当前状态：</td>
                                    <td>
                                        <select name="Status" id="Status" class="form-control" style="width:200px;float:left;margin-right: 10px" onchange="GetNewTourAreaID(this.value)" >
                                            <option value="1" <?php if($DebtInfo[Status] == 1) { ?>selected="selected"<?php } ?>>未接单</option>
                                            <option value="2" <?php if($DebtInfo[Status] == 2) { ?>selected="selected"<?php } ?>>催收中</option>
                                            <option value="3" <?php if($DebtInfo[Status] == 3) { ?>selected="selected"<?php } ?>>未完成</option>
                                            <option value="4" <?php if($DebtInfo[Status] == 4) { ?>selected="selected"<?php } ?>>部分收回(已完成)</option>
                                            <option value="5" <?php if($DebtInfo[Status] == 5) { ?>selected="selected"<?php } ?>>全部收回(已完成)</option>
                                            <option value="6" <?php if($DebtInfo[Status] == 6) { ?>selected="selected"<?php } ?>>未曝光</option>
                                            <option value="7" <?php if($DebtInfo[Status] == 7) { ?>selected="selected"<?php } ?>>已曝光</option>
                                            <option value="8" <?php if($DebtInfo[Status] == 8) { ?>selected="selected"<?php } ?>>待审核</option>
                                        </select>
                                        <input type="hidden" name="DebtID" value="<?php echo $DebtID;?>" />
                                        <input class="btn btn-danger" type="submit" name="submit" value="修改">
                                    </td>
                                </tr>
                            </tbody>
                        </form>
                    </table>
                        <tr>
                            <td height="35" width="500px"> <a class="right"  href="/index.php?Module=Debt&Action=DebtLists">返回列表</a></td>
                        </tr>
                    </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><?php include template('Foot'); ?>