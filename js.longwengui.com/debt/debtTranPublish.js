$(function(){
  $('#end_time').dcalendarpicker({format: 'yyyy-mm-dd', width: '424px'}); //初始化日期选择器
  $('#send_time').dcalendarpicker({format: 'yyyy-mm-dd', width: '424px'}); //初始化日期选择器
});

//截止时间改变时计算距离时间
function endTimeChange(){
  var end_time = $('#end_time').val();
  var day = calcTime(end_time);
  if(day){
    $('#left_time').html('还有<span class="c-b">' + day + '</span>天')
  }
}

//计算时间距离
function calcTime(end_time){
  var a = new Date();
  var now = new Date(a.getFullYear() + '-' + ((a.getMonth() + 1) > 9 ? (a.getMonth() + 1) : ('0' + (a.getMonth() + 1))) + '-' + (a.getDate() > 9 ? a.getDate() : ('0' + a.getDate())));
  var end_date = new Date(end_time);
  //如果截止日期不大于今天，不执行
  if(end_date > now){
    var dis = end_date.getTime() - now.getTime();
    return dis/(1000*3600*24);
  }else{
    return;
  }
}

//编辑器初始化
KindEditor.ready(function(K) {
	K.each({
		'plug-align' : {
			name : '对齐方式',
			method : {
				'justifyleft' : '左对齐',
				'justifycenter' : '居中对齐',
				'justifyright' : '右对齐'
			}
		},
		'plug-order' : {
			name : '编号',
			method : {
				'insertorderedlist' : '数字编号',
				'insertunorderedlist' : '项目编号'
			}
		},
    'insertorderedlist' : '数字编号',
    'insertunorderedlist' : '项目编号',
		'plug-indent' : {
			name : '缩进',
			method : {
				'indent' : '向右缩进',
				'outdent' : '向左缩进'
			}
		}
	},function( pluginName, pluginData ){
		var lang = {};
		lang[pluginName] = pluginData.name;
		KindEditor.lang( lang );
		KindEditor.plugin( pluginName, function(K) {
			var self = this;
			self.clickToolbar( pluginName, function() {
				var menu = self.createMenu({
						name : pluginName,
						width : pluginData.width || 100
					});
				K.each( pluginData.method, function( i, v ){
					menu.addItem({
						title : v,
						checked : false,
						iconClass : pluginName+'-'+i,
						click : function() {
							self.exec(i).hideMenu();
						}
					});
				})
			});
		});
	});
	K.create('#contentqq', {
		themeType : 'qq',
		items : [
			'bold', 'italic', 'underline','fontsize','forecolor','plug-align','plug-order','plug-indent','link','image'
		]
	});
});
