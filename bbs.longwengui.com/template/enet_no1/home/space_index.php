<?php exit;?>
<!--{template home/space_header}-->
<div id="ct" class="wp w cl">
	<div id="diypage" class="area">
		<div id="frame1" class="frame cl" noedit="1">
			<div id="frame1_left" style="width:{$widths[0]}px" class="z column">
				<!--{if empty($leftlist)}-->
				<div id="left_temp" class="move-span temp"></div>
				<!--{/if}-->
				<!--{loop $leftlist $key $value}-->
				<!--{if !empty($key)}-->
					<div id="$key" class="block move-span">
						$value
					</div>
				<!--{/if}-->
				<!--{/loop}-->
			</div>

			<div id="frame1_center" style="width:{$widths[1]}px" class="z column">
				<!--{if empty($centerlist)}-->
				<div id="center_temp" class="move-span temp"></div>
				<!--{/if}-->
				<!--{loop $centerlist $key $value}-->
					<!--{if !empty($key)}-->
						<div id="$key" class="block move-span">
							$value
						</div>
					<!--{/if}-->
				<!--{/loop}-->
			</div>

			<!--{if (strlen($userdiy['currentlayout']) > 3) }-->
			<div id="frame1_right" style="width:{$widths[2]}px" class="z column">
				<!--{if empty($rightlist)}-->
				<div id="right_temp" class="move-span temp"></div>
				<!--{/if}-->
				<!--{loop $rightlist $key $value}-->
				<!--{if !empty($key)}-->
					<div id="$key" class="block move-span">
						$value
					</div>
				<!--{/if}-->
				<!--{/loop}-->
			</div>
			<!--{/if}-->
		</div>
	</div>
</div>
<script type="text/javascript">
function succeedhandle_followmod(url, msg, values) {
	var fObj = $('followmod');
	if(values['type'] == 'add') {
		fObj.innerHTML = 'ȡ������';
		fObj.className = 'flw_btn_unfo';
		fObj.href = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+values['fuid'];
	} else if(values['type'] == 'del') {
		fObj.innerHTML = '����TA';
		fObj.className = 'flw_btn_fo';
		fObj.href = 'home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid='+values['fuid'];
	}
}
</script>
<!--{template common/footer}-->
