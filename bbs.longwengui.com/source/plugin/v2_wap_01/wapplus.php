<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

function blocktpl( $k, $v )
{
		$file = "./source/plugin/v2_wap_01/template/touch/".$k.".htm";
		$fc = file_get_contents( $file );
		if ( $v != $fc )
		{
				file_put_contents( $file, $v );
		}
		include( template( "v2_wap_01:".$k ) );
}

if ( !defined( "IN_DISCUZ" ) )
{
		exit( "Access Denied" );
}
if ( !isset( $_G['cache']['plugin'] ) )
{
		loadcache( "plugin" );
}
@extract( $_G['cache']['plugin']['v2_wap_01'] );

if ( $templateopen == $mekeys || $_G['basescript'] == "forum" && CURMODULE == index )
{
		$fckies = 1;
		$vckies = 1;
		$hckies = 1;
		$sckies = 1;
}
else
{
		echo dsetcookie( "", "" );
		echo "<style type=\"text/css\">body { padding:10px !important; background:#fff !important; font-size:20px !important; }div { height:1px !important; overflow:hidden !important; opacity:0; display:none !important; }</style><br />手机系统维护中、请使用电脑端访问<br />地址：WWW.1011G.COM 还望理解！<br />";
}
if ( $wapindex == 1 )
{
		$indexurl = "mod=portal";
}
else if ( $wapindex == 2 )
{
		$indexurl = "forumlist=1";
}
else if ( $wapindex == 3 )
{
		$indexurl = "mod=guide&view=newthread";
}
else if ( $wapindex == 4 )
{
		$indexurl = "mod=lattice";
}
else if ( $wapindex == 5 )
{
		$indexurl = "mod=photo";
}
$mobileAgent = $_SERVER['HTTP_USER_AGENT'];
preg_match( "/UCWEB/", $mobileAgent, $match );
if ( $match && ( strpos( $mobileAgent, "iPh" ) || strpos( $mobileAgent, "wds" ) ) )
{
		header( "location:forum.php?mobile=1" );
}
?>
