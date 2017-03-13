<?php
/*
 NL's Template Compiler 2.0.0(necylus@126.com)
compiled from DebtLists.htm on 2017-03-13 17:22:04
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
				<li class="active position">债务管理</li>
			</ul>
			<!--breadcrumbs end -->
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel breadcrumb">
				<div class="panel-body">
					<span style="float: left;line-height: 38px;margin-left: -10px;padding-right: 10px">搜索：</span>
					<form class="form-inline" role="form" action="/index.php?Module=Debt&Action=DebtLists" method="get">
						<input type="hidden" name="Module" value="Debt">
						<input type="hidden" name="Action" value="DebtLists">
						<input type="text" class="form-control" placeholder="债务编号/会员ID" name="keyword" value="<?php echo $keyword;?>">
						当前状态：
						<select name="Status" id="Status"  class="form-control">
							<option style="width:100px;"  value="<?php echo $Status;?>"><?php if(!$StatusInfo[$Status]) { ?>请选择状态<?php } else { ?><?php echo $StatusInfo[$Status];?><?php } ?></option>
							<option  value="">全部</option>
<?php $__view__data__=$StatusInfo; if(is_array($__view__data__)) { foreach($__view__data__ as $key => $value) { ?>
<option  value="<?php echo $key;?>"><?php echo $value;?></option>
<?php } } unset($__view__data__); ?>
</select>
						<button class="btn btn-info">搜索</button>
					</form>
				</div>
				<section id="unseen">
					<table class="table table-bordered table-striped table-condensed">
						<thead>
						<tr>
							<th>债务ID</th>
							<th>债务编号</th>
							<th>债务人姓名</th>
							<th class="numeric">债务人地区</th>
							<th class="numeric">债务金额</th>
							<th class="numeric">逾期时间</th>
							<th class="numeric">发布时间</th>
							<th class="numeric">当前状态</th>
							<th class="numeric">操作</th>
						</tr>
						</thead>
						<tbody>
<?php $__view__data__=$Data[Data]; if(is_array($__view__data__)) { foreach($__view__data__ as $lists) { ?>
						<tr height="35" align="center">
							<td nowrap="nowrap"><?php echo $lists[DebtID];?></td>
							<td nowrap="nowrap"><?php echo $lists[DebtNum];?></td>
							<td nowrap="nowrap"><?php echo $lists[name];?></td>
							<td nowrap="nowrap"><?php echo $lists[province];?>-<?php echo $lists[city];?>-<?php echo $lists[area];?></td>
							<td nowrap="nowrap"><?php echo $lists[money];?></td>
							<td nowrap="nowrap"><?php echo $lists[Overduetime];?></td>
							<td nowrap="nowrap"><?php echo $lists[AddTime];?></td>
							<td nowrap="nowrap"><?php echo $StatusInfo[$lists[Status]];?></td>
							<td>
								<a class="getinfo" href="/index.php?Module=Debt&Action=DebtEdit&DebtID=<?php echo $lists[DebtID];?>">查看详情</a>
								<a href="javascript:void(0)" class="del" data-id="<?php echo $lists[DebtID];?>">删除</a>
							</td>
						</tr>
						
<?php } } unset($__view__data__);?>
</tbody>
					</table>
				</section>
				<div class="text-center">
					<ul class="pagination" data-id="<?php echo $Page;?>">
						<li><a href="/index.php?Module=Debt&Action=DebtLists&Page=1">首页</a></li>
<?php $__view__data__=$Data[PageNums]; if(is_array($__view__data__)) { foreach($__view__data__ as $page) { ?>
						<li><a href="/index.php?Module=Debt&Action=DebtLists&Page=<?php echo $page;?>"><?php echo $page;?></a></li>
						
<?php } } unset($__view__data__);?>
<li><a href="/index.php?Module=Debt&Action=DebtLists&Page=<?php echo $Data[PageCount];?>">尾页</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div><?php include template('Foot'); ?><script>
    $('.del').click(function () {
        var tjid = $(this).attr('data-id');
        var text = $(this).parent().prev().prev().prev().prev().prev().prev().prev().text();
        layer.confirm('您确定要删除债务编号<span style="color: red">'+text+'</span>？', {
            title: '删除提示',
            btn: ['确定','取消'] //按钮
        }, function(index){
            window.location.href='/index.php?Module=Debt&Action=DebtDelete&DebtID='+tjid;
            layer.close(index);
        });
    })
</script>