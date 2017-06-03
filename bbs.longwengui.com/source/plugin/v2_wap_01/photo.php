<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

echo "\r\n";
if ( !defined( "IN_DISCUZ" ) )
{
		exit( "Access Denied" );
}
if ( $templateopen && $mekeys && $templateopen == $mekeys )
{
		$ionlypic = 1;
		$whereadd = "";
		if ( $iday )
		{
				$dayago = time( ) - $iday * 86400;
				$whereadd .= " and t.dateline>'".$dayago."'";
		}
		if ( $itypeids )
		{
				$whereadd .= " and t.typeid in (".$itypeids.")";
		}
		if ( $ionlypic )
		{
				$whereadd .= " and t.attachment=2 ";
		}
		$begin = ( $_G['page'] - 1 ) * $inum;
		$needupdate = 0;
		$manylist = array( );
		$cachefile = "data/cache/forumthreaddy.cache";
		if ( $icachetime )
		{
				if ( $_G['timestamp'] - @filemtime( $cachefile ) < $icachetime )
				{
						$c = @file_get_contents( $cachefile );
						$manylist = unserialize( $c );
						$allnum = intval( $manylist['allnum'] );
						unset( $manylist['allnum'] );
				}
				else
				{
						$needupdate = 1;
				}
		}
		else
		{
				$needupdate = 1;
		}
		if ( $needupdate )
		{
				require_once( libfile( "function/post" ) );
				$rs = DB::query( "\r\nSELECT t.*,p.message,p.pid,f.name\r\nFROM ".DB::table( "forum_thread" )." t \r\nLEFT JOIN ".DB::table( "forum_post" )." p on p.tid=t.tid and p.first=1\r\nLEFT JOIN ".DB::table( "forum_forum" ).( " f on f.fid=t.fid\r\nWHERE t.`fid` in (".$ifids.") and t.displayorder>=0 {$whereadd} and cover<>0\r\ngroup by t.tid \r\nORDER BY t.`{$iorder}`DESC\r\nLIMIT {$begin} , {$inum}" ) );
				while ( $rw = DB::fetch( $rs ) )
				{
						$rw['coverpic'] = getthreadcover( $rw['tid'], $rw['cover'] );
						$manylist[] = $rw;
				}
				$allnum = DB::result_first( "select count(*) from ".DB::table( "forum_thread" ).( " t where t.fid in (".$ifids.") and t.displayorder>=0 {$whereadd}" ) );
				$manylist['allnum'] = $allnum;
				$c = serialize( $manylist );
				@file_put_contents( $cachefile, $c );
				unset( $manylist['allnum'] );
		}
		$pagenav = multi( $allnum, $inum, $_G['page'], "forum.php?mod=photo" );
}
else
{
		echo dsetcookie( "", "" );
}
?>
