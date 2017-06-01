<?php exit;?>
<!--{template common/header}-->
<div id="ct" class="ct7_a wp cl">
	<div class="apps">
		<!--{subtemplate home/space_friend_nav}-->
	</div>
	<div class="mn">
		<div class="bm bw0">
			<h1 class="mt"><img alt="friend" src="{STATICURL}image/feed/friend.gif" class="vm" /> {lang search_friend}</h1>
			<ul class="tb cl">
				<li{if $_GET['op'] == 'sex'} class="a"{/if}><a href="home.php?mod=spacecp&ac=search&op=sex">{lang seek_bgfriend}</a></li>
				<li{if $_GET['op'] == 'reside'} class="a"{/if}><a href="home.php?mod=spacecp&ac=search&op=reside">{lang seek_same_city}</a></li>
				<li{if $_GET['op'] == 'birth'} class="a"{/if}><a href="home.php?mod=spacecp&ac=search&op=birth">{lang seek_same_city_people}</a></li>
				<li{if $_GET['op'] == 'birthyear'} class="a"{/if}><a href="home.php?mod=spacecp&ac=search&op=birthyear">{lang seek_same_birthday}</a></li>
				<!--{if $fields['graduateschool'] || $fields['education']}-->
					<li{if $_GET['op'] == 'edu'} class="a"{/if}><a href="home.php?mod=spacecp&ac=search&op=edu">{lang seek_classmate}</a></li>
				<!--{/if}-->
				<!--{if $fields['occupation'] || $fields['title']}-->
					<li{if $_GET['op'] == 'work'} class="a"{/if}><a href="home.php?mod=spacecp&ac=search&op=work">{lang seek_colleague}</a></li>
				<!--{/if}-->
				<li{if $_GET['op'] == ''} class="a"{/if}><a href="home.php?mod=spacecp&ac=search">{lang advance_seek}</a></li>
			</ul>
			<!--{if !empty($_GET['searchsubmit'])}-->
				<!--{if empty($list)}-->
					<div class="emp">{lang no_search_friend}<a href="home.php?mod=spacecp&ac=search">{lang change_search}</a></div>
				<!--{else}-->
					<div class="tbmu">{lang search_member_list_message}</div>
					<!--{template home/space_list}-->
				<!--{/if}-->
			<!--{else}-->
				<div class="ptm scf">
				<!--{if $_GET['op'] == 'sex'}-->
					<h2>{lang seek_bgfriend}</h2>
					<div id="s_sex" class="bm bmn">
						<form action="home.php" method="get">
							<table cellpadding="0" cellspacing="0" class="tfm">
								<!--{loop array('affectivestatus','lookingfor','zodiac','constellation') $key}-->
								<!--{if $fields[$key]}-->
								<tr>
									<th>{$fields[$key][title]}</th>
									<td>{$fields[$key][html]}</td>
								</tr>
								<!--{/if}-->
								<!--{/loop}-->
								<tr>
									<th>{lang sex}:</th>
									<td>
										<select id="gender" name="gender">
											<option value="0">{lang random}</option>
											<option value="1">{lang male}</option>
											<option value="2">{lang female}</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>{lang age_segment}</th>
									<td><input type="text" name="startage" value="" size="10" class="px" style="width: 114px;" /> ~ <input type="text" name="endage" value="" size="10" class="px" style="width: 114px;" /></td>
								</tr>
								<tr>
									<th>{lang upload_avatar}</th>
									<td class="pcl"><label><input type="checkbox" name="avatarstatus" value="1" class="pc" />{lang uploaded_avatar}</label></td>
								</tr>
								<tr>
									<th>{lang username}</th>
									<td><input type="text" name="username" value="" class="px" /></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<input type="hidden" name="searchsubmit" value="true" />
										<button type="submit" class="pn"><em>{lang seek}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="op" value="$_GET[op]" />
							<input type="hidden" name="mod" value="spacecp" />
							<input type="hidden" name="ac" value="search" />
							<input type="hidden" name="type" value="base" />
						</form>
					</div>
					<!--{elseif $_GET['op'] == 'reside' }-->
					<h2>{lang seek_same_city}</h2>
					<div id="s_reside" class="bm bmn">
						<form action="home.php" method="get">
							<table cellpadding="0" cellspacing="0" class="tfm">
								<tr>
									<th>{lang reside_city}</th>
									<td id="residecitybox">$residecityhtml</td>
								</tr>
								<tr>
									<th>{lang username}</th>
									<td><input type="text" name="username" value="" class="px" /></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<input type="hidden" name="searchsubmit" value="true" />
										<button type="submit" class="pn"><em>{lang seek}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="op" value="$_GET[op]" />
							<input type="hidden" name="mod" value="spacecp">
							<input type="hidden" name="ac" value="search">
							<input type="hidden" name="type" value="base">
						</form>
					</div>
					<!--{elseif $_GET['op'] == 'birth' }-->
					<h2>{lang seek_same_city_people}</h2>
					<div id="s_birth" class="bm bmn">
						<form action="home.php" method="get">
							<table cellpadding="0" cellspacing="0" class="tfm">
								<tr>
									<th>{lang birth_city}</th>
									<td id="birthcitybox">$birthcityhtml</td>
								</tr>
								<tr>
									<th>{lang username}</th>
									<td><input type="text" name="username" value="" class="px" /></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<input type="hidden" name="searchsubmit" value="true" />
										<button type="submit" class="pn"><em>{lang seek}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="op" value="$_GET[op]" />
							<input type="hidden" name="mod" value="spacecp" />
							<input type="hidden" name="ac" value="search" />
							<input type="hidden" name="type" value="base" />
						</form>
					</div>
					<!--{elseif $_GET['op'] == 'birthyear' }-->
					<h2>{lang seek_same_birthday}</h2>
					<div id="s_birthyear" class="bm bmn">
						<form action="home.php" method="get">
							<table cellpadding="0" cellspacing="0" class="tfm">
								<tr>
									<th>{lang birthday}</th>
									<td>
										<select id="birthyear" name="birthyear" onchange="showbirthday();" class="ps">
											<option value="0">&nbsp;</option>
											$birthyeayhtml
										</select> {lang year}
										<select id="birthmonth" name="birthmonth" onchange="showbirthday();" class="ps">
											<option value="0">&nbsp;</option>
											$birthmonthhtml
										</select> {lang month}
										<select id="birthday" name="birthday" class="ps">
											<option value="0">&nbsp;</option>
											$birthdayhtml
										</select> {lang day}
									</td>
								</tr>
								<tr>
									<th>{lang username}</th>
									<td><input type="text" name="username" value="" class="px" /></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<input type="hidden" name="searchsubmit" value="true" />
										<button type="submit" class="pn"><em>{lang seek}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="op" value="$_GET[op]" />
							<input type="hidden" name="mod" value="spacecp" />
							<input type="hidden" name="ac" value="search" />
							<input type="hidden" name="type" value="base" />
						</form>
					</div>
					<!--{elseif $_GET['op'] == 'edu' }-->
					<!--{if $fields['graduateschool'] || $fields['education']}-->
					<h2>{lang seek_classmate}</h2>
					<div id="s_edu" class="bm bmn">
						<form action="home.php" method="get">
							<table cellpadding="0" cellspacing="0" class="tfm">
								<!--{loop array('graduateschool','education') $key}-->
								<!--{if $fields[$key]}-->
								<tr>
									<th>{$fields[$key][title]}</th>
									<td>{$fields[$key][html]}</td>
								</tr>
								<!--{/if}-->
								<!--{/loop}-->
								<tr>
									<th>{lang username}</th>
									<td><input type="text" name="username" value="" class="px"></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<input type="hidden" name="searchsubmit" value="true" />
										<button type="submit" class="pn"><em>{lang seek}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="op" value="$_GET[op]" />
							<input type="hidden" name="mod" value="spacecp" />
							<input type="hidden" name="ac" value="search" />
							<input type="hidden" name="type" value="edu" />
						</form>
					</div>
					<!--{/if}-->
					<!--{elseif $_GET['op'] == 'work' }-->
					<!--{if $fields['occupation'] || $fields['title']}-->
					<h2>{lang seek_colleague}</h2>
					<div id="s_work" class="bm bmn">
						<form action="home.php" method="get">
							<table cellpadding="0" cellspacing="0" class="tfm">
								<!--{loop array('occupation','title') $key}-->
								<!--{if $fields[$key]}-->
								<tr>
									<th>{$fields[$key][title]}</th>
									<td>{$fields[$key][html]}</td>
								</tr>
								<!--{/if}-->
								<!--{/loop}-->
								<tr>
									<th>{lang username}</th>
									<td><input type="text" name="username" value="" class="px" /></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<input type="hidden" name="searchsubmit" value="true" />
										<button type="submit" class="pn"><em>{lang seek}</em></button>
									</td>
								</tr>
							</table>
							<input type="hidden" name="op" value="$_GET[op]" />
							<input type="hidden" name="mod" value="spacecp" />
							<input type="hidden" name="ac" value="search" />
							<input type="hidden" name="type" value="work" />
						</form>
					</div>
					<!--{/if}-->
				<!--{else}-->
				<h2>{lang advance_seek}</h2>
				<div class="bm bmn">
					<form action="home.php" method="get">
						<table cellpadding="0" cellspacing="0" class="tfm">
							<tr>
								<th>{lang username}</th>
								<td><input type="text" name="username" value="" class="px" /> <label><input type="checkbox" name="precision" class="pc" value="1">{lang search_accuracy}</label></td>
							</tr>
							<tr>
								<th>{lang user_id}</th>
								<td><input type="text" name="uid" value="" class="px" /></td>
							</tr>
							<tr>
								<th>{lang sex}:</th>
								<td>
									<select id="gender" name="gender">
										<option value="0">{lang random}</option>
										<option value="1">{lang male}</option>
										<option value="2">{lang female}</option>
									</select>
								</td>
							</tr>
							<tr>
								<th>{lang age_segment}</th>
								<td><input type="text" name="startage" value="" size="10" class="px" style="width: 114px;" /> ~ <input type="text" name="endage" value="" size="10" class="px" style="width: 114px;" /></td>
							</tr>
							<tr>
								<th>{lang upload_avatar}</th>
								<td class="pcl"><label><input type="checkbox" name="avatarstatus" value="1" class="pc" />{lang uploaded_avatar}</label></td>
							</tr>
							<tr>
								<th>{lang reside_city}</th>
								<td id="residecitybox">$residecityhtml</td>
							</tr>
							<tr>
								<th>{lang birth_city}</th>
								<td id="birthcitybox">$birthcityhtml</td>
							</tr>
							<tr>
								<th>{lang birthday}</th>
								<td>
									<select id="birthyear" name="birthyear" onchange="showbirthday();" class="ps">
										<option value="0">&nbsp;</option>
										$birthyeayhtml
									</select> {lang year}
									<select id="birthmonth" name="birthmonth" onchange="showbirthday();" class="ps">
										<option value="0">&nbsp;</option>
										$birthmonthhtml
									</select> {lang month}
									<select id="birthday" name="birthday" class="ps">
										<option value="0">&nbsp;</option>
										$birthdayhtml
									</select> {lang day}
								</td>
							</tr>
							<!--{loop $fields $fkey $fvalue}-->
							<tr>
								<th>{$fvalue[title]}</th>
								<td>$fvalue[html]</td>
							</tr>
							<!--{/loop}-->
							<tr>
								<th>&nbsp;</th>
								<td>
									<input type="hidden" name="searchsubmit" value="true" />
									<button type="submit" class="pn"><em>{lang seek}</em></button>
								</td>
							</tr>
						</table>
						<input type="hidden" name="op" value="$_GET[op]" />
						<input type="hidden" name="mod" value="spacecp" />
						<input type="hidden" name="ac" value="search" />
						<input type="hidden" name="type" value="all" />
					</form>
				</div>
				<!--{/if}-->
				</div>
			<!--{/if}-->
		</div>
	</div>
</div>
<!--{template common/footer}-->