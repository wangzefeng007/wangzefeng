<?php exit;?>
<!--{eval $keywordenc = $keyword ? rawurlencode($keyword) : '';}-->
<!--{if $searchid || ($_GET['adv'] && CURMODULE == 'forum')}-->
	<table id="scform" class="mbm" cellspacing="0" cellpadding="0">
		<tr>
			<td><h1><a href="search.php" title="$_G['setting']['bbname']"><img src="{IMGDIR}/logo_sc_s.png" alt="$_G['setting']['bbname']" /></a></h1></td>
			<td>
				<div id="scform_tb" class="cl">
					<!--{if CURMODULE == 'forum'}-->
						<span class="y">
							<a href="javascript:;" id="quick_sch" class="showmenu" onmouseover="delayShow(this);">{lang quick}</a>
							<!--{if CURMODULE == 'forum'}-->
								<a href="search.php?mod=forum&adv=yes{if $keyword}&srchtxt=$keywordenc{/if}">{lang search_adv}</a>
							<!--{/if}-->
						</span>
					<!--{/if}-->
					<!--{if $_G['setting']['portalstatus'] && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)}--><!--{block slist[portal]}--><a href="search.php?mod=portal{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'portal'} class="a"{/if}>{lang portal}</a><!--{/block}--><!--{/if}-->
					<!--{if $_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)}--><!--{block slist[forum]}--><a href="search.php?mod=forum{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'forum'} class="a"{/if}>{lang thread}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1)}--><!--{block slist[blog]}--><a href="search.php?mod=blog{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'blog'} class="a"{/if}>{lang blog}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1)}--><!--{block slist[album]}--><a href="search.php?mod=album{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'album'} class="a"{/if}>{lang album}</a><!--{/block}--><!--{/if}-->
					<!--{if $_G['setting']['groupstatus'] && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)}--><!--{block slist[group]}--><a href="search.php?mod=group{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'group'} class="a"{/if}>$_G['setting']['navs'][3]['navname']</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('collection') && $_G['setting']['search']['collection']['status'] && ($_G['group']['allowsearch'] & 64 || $_G['adminid'] == 1)}--><!--{block slist[collection]}--><a href="search.php?mod=collection{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'collection'} class="a"{/if}>{lang collection}</a><!--{/block}--><!--{/if}-->
					<!--{block slist[user]}--><a href="search.php?mod=user{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'user'} class="a"{/if}>{lang users}</a><!--{/block}-->
					<!--{echo implode("", $slist);}-->
				</div>
				<table id="scform_form" cellspacing="0" cellpadding="0">
					<tr>
						<td class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" size="45" maxlength="40" value="$keyword" tabindex="1" x-webkit-speech speech /><script type="text/javascript">initSearchmenu('scform_srchtxt');$('scform_srchtxt').focus();</script></td>
						<td class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" class="schbtn"><strong>{lang search}</strong></button></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<!--{else}-->
	<!--{if !empty($srchtype)}--><input type="hidden" name="srchtype" value="$srchtype" /><!--{/if}-->
	<!--{if $srchtype != 'threadsort'}-->
		<div class="hm mtw ptw pbw"><h1 class="mtw ptw"><a href="./" title="$_G['setting']['bbname']"><img src="{IMGDIR}/logo_sc.png" alt="$_G['setting']['bbname']" /></a></a></h1></div>
		<table id="scform" cellspacing="0" cellpadding="0" style="margin: 0 auto;">
			<tr>
				<td id="scform_tb" class="xs2">
					<!--{if CURMODULE == 'forum'}-->
					<span class="y xs1">
						<a href="javascript:;" id="quick_sch" class="showmenu" onmouseover="delayShow(this);">{lang quick}</a>
						<!--{if CURMODULE == 'forum'}-->
							<a href="search.php?mod=forum&adv=yes">{lang search_adv}</a>
						<!--{/if}-->
					</span>
					<!--{/if}-->
					<!--{if helper_access::check_module('portal') && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)}--><!--{block slist[portal]}--><a href="search.php?mod=portal{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'portal'} class="a"{/if}>{lang portal}</a><!--{/block}--><!--{/if}-->
					<!--{if $_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)}--><!--{block slist[forum]}--><a href="search.php?mod=forum{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'forum'} class="a"{/if}>{lang thread}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1) && helper_access::check_module('blog')}--><!--{block slist[blog]}--><a href="search.php?mod=blog{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'blog'} class="a"{/if}>{lang blog}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1) && helper_access::check_module('album')}--><!--{block slist[album]}--><a href="search.php?mod=album{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'album'} class="a"{/if}>{lang album}</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('group') && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)}--><!--{block slist[group]}--><a href="search.php?mod=group{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'group'} class="a"{/if}>$_G['setting']['navs'][3]['navname']</a><!--{/block}--><!--{/if}-->
					<!--{if helper_access::check_module('collection') && $_G['setting']['search']['collection']['status'] && ($_G['group']['allowsearch'] & 64 || $_G['adminid'] == 1)}--><!--{block slist[collection]}--><a href="search.php?mod=collection{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'collection'} class="a"{/if}>{lang collection}</a><!--{/block}--><!--{/if}-->
					<!--{echo implode("", $slist);}-->
					<a href="search.php?mod=user{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'user'} class="a"{/if}>{lang user}</a>
				</td>
			</tr>
			<tr>
				<td>
					<table cellspacing="0" cellpadding="0" id="scform_form">
						<tr>
							<td class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" size="65" maxlength="40" value="$keyword" tabindex="1" /><script type="text/javascript">initSearchmenu('scform_srchtxt');$('scform_srchtxt').focus();</script></td>
							<td class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" value="true"><strong>{lang search}</strong></button></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	<!--{/if}-->
<!--{/if}-->
<!--{if CURMODULE == 'forum'}-->
	<ul id="quick_sch_menu" class="p_pop" style="display: none;">
		<li><a href="search.php?mod=forum&srchfrom=3600&searchsubmit=yes">{lang search_quick_hour_1}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=14400&searchsubmit=yes">{lang search_quick_hour_4}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=28800&searchsubmit=yes">{lang search_quick_hour_8}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=86400&searchsubmit=yes">{lang search_quick_hour_24}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=604800&searchsubmit=yes">{lang search_quick_day_7}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=2592000&searchsubmit=yes">{lang search_quick_day_30}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=15552000&searchsubmit=yes">{lang search_quick_day_180}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=31536000&searchsubmit=yes">{lang search_quick_day_365}</a></li>
	</ul>
<!--{/if}-->