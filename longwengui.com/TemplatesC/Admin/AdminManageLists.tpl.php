<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from AdminManageLists.htm on 2017-03-10 10:13:37
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
          <a href="#">管理员管理</a>
        </li>
        <li class="active position">管理员列表</li>
      </ul>
      <!--breadcrumbs end -->
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel breadcrumb">
        <div class="panel-body">
          <span style="float: left;line-height: 38px;margin-left: -10px;padding-right: 10px">标题：</span>
          <form class="form-inline" role="form" action="/index.php" method="get">
            <input type="hidden" name="Module" value="AdminManage">
            <input type="hidden" name="Action" value="Lists">
            <input type="text" class="form-control" placeholder="账号" name="Keywords" value="<?php echo $Keywords;?>">
            <button class="btn btn-info">搜索</button>
            <input type="button" onClick="location.href='/index.php?Module=AdminManage&Action=AddAdmin'" value="添加" class="btn btn-danger">
          </form>
        </div>
        <section id="unseen">
          <table class="table table-bordered table-striped table-condensed">
            <thead>
            <tr align="center">
              <th width="50px"><strong>ID</strong></th>
              <th>管理员</th>
              <th>管理员级别</th>
              <th>最后登录</th>
              <th>登录IP</th>
              <th>操作</th>
            </tr>
            </thead>
            <tbody>
            
<?php $__view__data__=$Data[Data]; if(is_array($__view__data__)) { foreach($__view__data__ as $lists) { ?>
            <tr height="35" align="center">
              <td nowrap="nowrap" width="20px"><?php echo $lists[AdminID];?></td>
              <td nowrap="nowrap" width="50px"><?php echo $lists[AdminName];?></td>
              <td nowrap="nowrap" width="100px"><?php if($lists[GroupID]==2) { ?>普通管理员<?php } else { ?>无<?php } ?></td>
              <td nowrap="nowrap" width="100px"><?php echo $lists[LastLogin];?></td>
              <td nowrap="nowrap" width="100px"><?php echo $lists[LoginIP];?></td>
              <td nowrap="nowrap" width="50px"><a href="/index.php?Module=AdminManage&Action=AddAdmin&ID=<?php echo $lists[AdminID];?>">修改</a>&nbsp;&nbsp;&nbsp; <a href="/index.php?Module=AdminManage&Action=DelAdmin&ID=<?php echo $lists[AdminID];?>" onclick="return confirm('确定要删除该管理员？');">删除</a>&nbsp;&nbsp;&nbsp;
            </tr>
            
<?php } } unset($__view__data__);?>
            </tbody>
          </table>
          <form action="#" method="POST">
            <div class="text-center">
              <ul class="pagination" data-id="<?php echo $Page;?>">
                <li><a href="/index.php?Module=AdminManage&Action=Lists&Page=1">首页</a></li>
                <?php if($Previous) { ?><li><a href="/index.php?Module=TourLine&Action=TourlineList&Page=<?php echo $Previous;?><?php echo $PageUrl;?>">上一页</a></li><?php } ?>                
<?php $__view__data__=$Data[PageNums]; if(is_array($__view__data__)) { foreach($__view__data__ as $page) { ?>
                <li><a href="/index.php?Module=AdminManage&Action=Lists&Page=<?php echo $page;?>" <?php if($Page == $page) { ?> class="on" <?php } ?>><?php echo $page;?></a></li>
                
<?php } } unset($__view__data__);?>
                <?php if($Next) { ?><li><a href="/index.php?Module=TourLine&Action=TourlineList&Page=<?php echo $Next;?><?php echo $PageUrl;?>">下一页</a></li><?php } ?>                <li><a href="/index.php?Module=AdminManage&Action=Lists&Page=<?php echo $Data[PageCount];?>">尾页</a></li>
                <span style="line-height: 27px;margin-right: 10px">第<?php echo $Page;?>页&nbsp;&nbsp;共<?php echo $PageMax;?>页&nbsp;&nbsp;到<input type="text" name ='page' value ='' style="width:30px;height: 27px;line-height: 27px;margin: 0px 8px 0px 8px">页</span>
                <button class="btn btn-info" style="background-color: #65CEA7;border-color: #65CEA7;color: #fff;">确定</button>
              </ul>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</div><?php include template('Foot'); ?>