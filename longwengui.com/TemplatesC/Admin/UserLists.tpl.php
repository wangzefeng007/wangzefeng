<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from UserLists.htm on 2017-03-10 17:09:19
*/
?><?php include template('Head'); ?><script type="text/javascript" charset="utf-8" src="/Plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Plugins/ueditor/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/Plugins/ueditor/lang/zh-cn/zh-cn.js"></script>
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb panel">
                <li>
                    <a href="#"><i class="fa fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="/index.php?Module=User&Action=UserLists">会员管理</a>
                </li>
                <span class="position hidden">会员管理</span>
            </ul>
            <!--breadcrumbs end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel breadcrumb">
                <div class="panel-body">
                    <span style="float: left;line-height: 36px;margin-left: -10px;padding-right: 10px">用户ID：</span>
                    <form class="form-inline" role="form" action="/index.php?Module=User&Action=UserLists" method="GET">
                        <input type="text" class="form-control" name="Title" placeholder="用户ID" value="<?php echo $Title;?>" style="width:300px;">
                        <input type="hidden" name="Module" value="User">
                        <input type="hidden" name="Action" value="UserLists">
                        <button class="btn btn-info">搜索</button>
                    </form>
                </div>
                <section id="unseen">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead>
                        <tr  align="center">
                            <th>用户ID</th>
                            <th>昵称</th>
                            <th>真实姓名</th>
                            <th>手机</th>
                            <th>身份</th>
                            <th>审核状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        
<?php $__view__data__=$Data[Data]; if(is_array($__view__data__)) { foreach($__view__data__ as $lists) { ?>
                        <tr height="35" align="center">
                            <td><?php echo $lists[UserID];?></td>
                            <td><?php echo $lists[NickName];?></td>
                            <td><?php echo $lists[RealName];?></td>
                            <td><?php echo $lists[Mobile];?></td>
                            <td><?php echo $Identity[$lists[Identity]];?></td>
                            <td><?php echo $IdentityStatus[$lists[IdentityState]];?></td>
                            <td>&nbsp;<a href="/index.php?Module=User&Action=UserDetail&UserID=<?php echo $lists[UserID];?>">详情</a>
                        </tr>
                        
<?php } } unset($__view__data__);?>
                        </tbody>
                    </table>
                    <form action="/index.php?Module=User&Action=UserLists<?php echo $PageUrl;?>" method="POST">
                        <div class="text-center">
                            <ul class="pagination" data-id="<?php echo $Page;?>">
                                <li><a href="/index.php?Module=User&Action=UserLists&Page=1<?php echo $PageUrl;?>">首页</a></li>
                                <?php if($Previous) { ?>                                <li><a href="/index.php?Module=User&Action=UserLists&Page=<?php echo $Previous;?><?php echo $PageUrl;?>">上一页</a></li>
                                <?php } ?>                                
<?php $__view__data__=$Data[PageNums]; if(is_array($__view__data__)) { foreach($__view__data__ as $page) { ?>
                                <li><a href="/index.php?ModuleUser&Action=UserLists&Page=<?php echo $page;?><?php echo $PageUrl;?>" <?php if($Page==$page) { ?>class="on"<?php } ?>><?php echo $page;?></a></li>
                                
<?php } } unset($__view__data__);?>
                                <?php if($Next) { ?>                                <li><a href="/index.php?Module=User&Action=UserLists&Page=<?php echo $Next;?><?php echo $PageUrl;?>">下一页</a></li>
                                <?php } ?>                                <li><a href="/index.php?Module=User&Action=UserLists&Page=<?php echo $Data[PageCount];?><?php echo $PageUrl;?>">尾页</a></li>
                                <span style="line-height: 27px;margin-right: 10px">第<?php echo $Page;?>页&nbsp;&nbsp;共<?php echo $Data[PageCount];?>页&nbsp;&nbsp;到<input type="text" name ='Page' value ='' style="width:30px;height: 27px;line-height: 27px;margin: 0px 8px 0px 8px">页</span>
                                <button class="btn btn-info" style="background-color: #65CEA7;border-color: #65CEA7;color: #fff;">确定</button>
                            </ul>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</div><?php include template('Foot'); ?><script type="text/javascript" src="/Plugins/rili/calendar.js"></script>