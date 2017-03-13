<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from DebtDetail.htm on 2017-03-09 11:03:33
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
                    <a href="/index.php?Module=Debt&Action=DebtList" class="position">债务管理</a>
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
                    <form action='/index.php?Module=Debt&Action=DebtList'  method='post'  enctype="multipart/form-data">
                        <table class="table table-bordered table-striped table-hover">
                            <tr>
                                <td colspan="3" class="t-h">债务详情：</td>
                            </tr>
                            <tr>
                                <td>发布人：<?php echo $UserInfo[RealName];?></td>
                                <td>债务人名字：<?php echo $Data[DebtName];?></td>
                                <td>债务人身份证：<?php echo $Data[CardNum];?></td>
                            </tr>
                            <tr>
                                <td>地区：<?php echo $Data[Province];?>-<?php echo $Data[City];?>-<?php echo $Data[Area];?></td>
                                <td>金额：<?php echo $Data[Money];?></td>
                                <td>逾期时间：<?php echo $Data[Overduetime];?></td>
                            </tr>
                            <tr>
                                <td>借款原因：<?php echo $Data[BorrowReason];?></td>
                                <td>债务近况：<?php echo $Data[DebtRecent];?></td>
                                <td>联系电话：<?php echo $Data[Phone];?></td>
                            </tr>
                            <tr>
                                <td>欠款人有无还款能力：<?php if($Data[RepaymentDebtor]==0) { ?>否<?php } elseif($Data[RepaymentDebtor]==1) { ?>是<?php } ?></td>
                                <td>欠款人是否随时找得到：<?php if($Data[FindDebtor]==0) { ?>否<?php } elseif($Data[FindDebtor]==1) { ?>是<?php } ?></td>
                                <td>有无抵押物：<?php if($Data[Guarantee]==0) { ?>无<?php } elseif($Data[Guarantee]==1) { ?>有<?php } ?></td>
                            </tr>
                        </table>
                        <tr>
                            <td height="35" width="500px"> <a class="right"  href="/index.php?Module=Debt&Action=DebtList">返回列表</a></td>
                        </tr>
                    </form>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div><?php include template('Foot'); ?>