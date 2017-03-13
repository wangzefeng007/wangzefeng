<?php
//模版编译类
define ( 'PHP_CLOSE_TAG', '?' . '>' );
define ( 'PHP_NEXTLINE', (PHP_OS == 'WINNT') ? "\r\n" : "\n" );
/*
//配置
$templates_cfg = array(
'templates_dir' => '/Templates',
'templates_compiled_dir' => '/TemplatesC',
'realrootpath' => SYSTEM_ROOTPATH,
'template_file_ext' => '.htm',
'template_compiled_file_ext'=>'.tpl.php',
'templates_default_dir' => null,
);
使用:
include template('yourtemplate');
*/

/*配置*/

$templates_cfg = array ('templates_dir' => '/Templates/' . $Group, 'templates_compiled_dir' => '/TemplatesC/' . $Group, 'realrootpath' => SYSTEM_ROOTPATH, 'template_file_ext' => '.htm', 'template_compiled_file_ext' => '.tpl.php', 'templates_default_dir' => null );
function ResetConfig(){
    global $templates_cfg,$Group;
    $templates_cfg = array ('templates_dir' => '/Templates/' . $Group, 'templates_compiled_dir' => '/TemplatesC/' . $Group, 'realrootpath' => SYSTEM_ROOTPATH, 'template_file_ext' => '.htm', 'template_compiled_file_ext' => '.tpl.php', 'templates_default_dir' => null );    
}
function template_gethtml($tpl, $force_compile = false) {
	extract ( $GLOBALS );
	ob_start ();
	include template ( $tpl, $force_compile );
	$html = ob_get_contents ();
	ob_clean ();
	return $html;
}
function template($tpl='',$ResetTemplatedir=false,$force_compile = false) {
	/*global $templates_cfg;
	if(!$templates_cfg||!$templates_cfg['templates_dir']||!$templates_cfg['realrootpath'])
	die('The Template parameter setting error.');
	$template_file = $templates_cfg['realrootpath'].$templates_cfg['templates_dir'].'/'.$tpl.$templates_cfg['template_file_ext'];
	$template_compiled_file = $templates_cfg['realrootpath'].$templates_cfg['templates_compiled_dir'].'/'.$tpl.$templates_cfg['template_compiled_file_ext'];
	if(!file_exists($templates_cfg['realrootpath'].$templates_cfg['templates_compiled_dir'].$templates_cfg['templates_dir'])){
		mkdirs($templates_cfg['templates_compiled_dir'].$templates_cfg['templates_dir'],$templates_cfg['realrootpath']);
	}
	if($templates_cfg['templates_default_dir']){
		$default_template_file = $templates_cfg['realrootpath'].$templates_cfg['templates_default_dir'].'/'.$tpl.$templates_cfg['template_file_ext'];
		$default_template_compiled_file = $templates_cfg['realrootpath'].$templates_cfg['templates_compiled_dir'].$templates_cfg['templates_default_dir'].'/'.$tpl.$templates_cfg['template_compiled_file_ext'];
		if(!file_exists($templates_cfg['realrootpath'].$templates_cfg['templates_compiled_dir'].$templates_cfg['templates_default_dir'])){
			mkdirs($templates_cfg['templates_compiled_dir'].$templates_cfg['templates_default_dir'],$templates_cfg['realrootpath']);
		}
	}*/
	global $templates_cfg;
	if($ResetTemplatedir){
	   $templates_cfg['templates_dir']='/Templates';
	   $templates_cfg['templates_compiled_dir']='/TemplatesC';
	}

	//if (! $templates_cfg || ! $templates_cfg ['templates_dir'] || ! $templates_cfg ['realrootpath'])
	//	die ( 'The Template parameter setting error.' );
	$template_file = $templates_cfg ['realrootpath'] . $templates_cfg ['templates_dir'] . '/' . $tpl . $templates_cfg ['template_file_ext'];
	$template_compiled_file = $templates_cfg ['realrootpath'] . $templates_cfg ['templates_compiled_dir'] . '/' . $tpl . $templates_cfg ['template_compiled_file_ext'];
	if (! file_exists ( $templates_cfg ['realrootpath'] . $templates_cfg ['templates_compiled_dir'] )) {
		mkdirs ( $templates_cfg ['templates_compiled_dir'], $templates_cfg ['realrootpath'] );
	}
	if ($templates_cfg ['templates_default_dir']) {
		$default_template_file = $templates_cfg ['realrootpath'] . $templates_cfg ['templates_default_dir'] . '/' . $tpl . $templates_cfg ['template_file_ext'];
		$default_template_compiled_file = $templates_cfg ['realrootpath'] . $templates_cfg ['templates_compiled_dir'] . $templates_cfg ['templates_default_dir'] . '/' . $tpl . $templates_cfg ['template_compiled_file_ext'];
		if (! file_exists ( $templates_cfg ['realrootpath'] . $templates_cfg ['templates_compiled_dir'] . $templates_cfg ['templates_default_dir'] )) {
			mkdirs ( $templates_cfg ['templates_compiled_dir'] . $templates_cfg ['templates_default_dir'], $templates_cfg ['realrootpath'] );
		}
	}
	
	if (file_exists ( $template_file )) {
		if (! file_exists ( $template_compiled_file ) || @filemtime ( $template_file ) > @filemtime ( $template_compiled_file ) || $force_compile) {
		    echo $force_compile;
			//compile template file
			template_compiler ( $tpl, $template_file, $template_compiled_file );
                        ResetConfig();
			return $template_compiled_file;
		} else {
                        ResetConfig();
			return $template_compiled_file;
		}
	} elseif ($templates_cfg ['templates_default_dir'] && file_exists ( $default_template_file )) {
		if (! file_exists ( $default_template_compiled_file ) || @filemtime ( $default_template_file ) > @filemtime ( $default_template_compiled_file ) || $force_compile) {
			//compile template file
			template_compiler ( $tpl, $default_template_file, $default_template_compiled_file );
                        ResetConfig();
			return $default_template_compiled_file;
		} else {
                        ResetConfig();
			return $default_template_compiled_file;
		}
	} else {
                ResetConfig();
		die ( "The template file '" . $tpl . $templates_cfg ['template_file_ext'] . "' not found or have no access!(1)" );
	}
}

function template_load($tpl, $tplfile) {
	global $templates_cfg;
	if (! @$fp = fopen ( $tplfile, 'r' )) {
		die ( "The template file '" . $tpl . $templates_cfg ['template_file_ext'] . "' not found or have no access!(2)" );
	}
	$template_sources = fread ( $fp, filesize ( $tplfile ) );
	fclose ( $fp );
	unset ( $fp );
	return $template_sources;
}

function template_compiler($tpl, $template_file, $template_compiled_file) {
	global $templates_cfg;
	$template_sources = template_load ( $tpl, $template_file );
	if (! $template_sources) {
		die ( "The template file '" . $tpl . $templates_cfg ['template_file_ext'] . "' not found or have no access!" );
	}
	
	$template_sources = preg_replace ( "/\<\!\-\-\{(.+?)\}\-\-\>/s", "{\\1}", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}[\n\r\t]*/es", "'<?php echo '.template_varsCompiler('\\1').';?>'", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{(\\\$[a-zA-Z0-9_\,\[\]\'\"\-\>\(\)\$\.\x7f-\xff]+)\}[\n\r\t]*/es", "'<?php echo '.template_varsCompiler('\\1').';?>'", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{template\s+([a-z0-9_-]+)\}[\n\r\t]*/is", "<?php include template('\\1'); ?>", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{template\s+(.+?)\}[\n\r\t]*/is", "<?php include template(\\1); ?>", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{eval\s+(.+?)\}[\n\r\t]*/ies", "template_stripvtags('<?php \\1 ?>','')", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{php\s+(.+?)\}[\n\r\t]*/ies", "template_stripvtags('<?php \\1 ?>','')", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{echo\s+(.+?)\}[\n\r\t]*/ies", "template_stripvtags('<?php echo \\1; ?>','')", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{unix_timestamp\s+(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}[\n\r\t]*/is", '<?php echo template_unix_timestamp(\\1);?>', $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{unix_timestamp\s+(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\s+(.+?)\}[\n\r\t]*/is", '<?php echo template_unix_timestamp(\\1,\\2); ?>', $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{cycle\s+(.+?)\}[\n\r\t]*/is", "<?php echo template_cycle(\\1, \$_this); ?>", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{htmlencode\s+(.+?)\}[\n\r\t]*/is", "<?php echo template_htmlspecialchars(\\1); ?>", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{urlencode\s+(.+?)\}[\n\r\t]*/is", "<?php echo urlencode(\\1); ?>", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{lang\s+(\\\$[a-zA-Z0-9_\[\]\'\"\$\.\x7f-\xff]+)\}[\n\r\t]*/is", "<?php echo template_lang(\\1); ?>", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{lang\s+(.+?)\}[\n\r\t]*/is", "<?php echo template_lang('\\1'); ?>", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{elseif\s+(.+?)\}[\n\r\t]*/ies", "template_stripvtags('<?php } elseif(\\1) { ?>','')", $template_sources );
	$template_sources = preg_replace ( "/[\n\r\t]*\{else\}[\n\r\t]*/is", "<?php } else { ?>", $template_sources );
	// loop
	for($i = 0; $i < 20; $i ++) {
		$template_sources = preg_replace ( "/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\}[\n\r]*(.+?)[\n\r]*\{\/loop\}[\n\r\t]*/ies", "template_stripvtags('\n<?php \$__view__data__=\\1; if(is_array(\$__view__data__)) { foreach(\$__view__data__ as \\2) { ?>','\n\\3\n<?php } } unset(\$__view__data__);?>\n')", $template_sources );
		$template_sources = preg_replace ( "/[\n\r\t]*\{loop\s+(\S+)\s+(\S+)\s+(\S+)\}[\n\r\t]*(.+?)[\n\r\t]*\{\/loop\}[\n\r\t]*/ies", "template_stripvtags('\n<?php \$__view__data__=\\1; if(is_array(\$__view__data__)) { foreach(\$__view__data__ as \\2 => \\3) { ?>','\n\\4\n<?php } } unset(\$__view__data__); ?>\n')", $template_sources );
	}
	$template_sources = preg_replace ( "/[\n\r\t]*\{if\s+(.+?)\}[\n\r]*/ies", "template_stripvtags('<?php if(\\1) { ?>')", $template_sources );
	$template_sources = preg_replace ( "/[\n\r]*\{\/if\}[\n\r\t]*/ies", "template_stripvtags('<?php } ?>')", $template_sources );
	$template_sources = preg_replace ( "/\s*\{nodisplay\}\s*(.+?)\s*\{\/nodisplay\}\s*/ies", " ", $template_sources );
	$template_sources = preg_replace ( "/ \?\>[\n\r]*\<\? /s", " ", $template_sources );
	if (! compiled_save ( $tpl, $template_compiled_file, $template_sources ))
		return 0;
	else {
		die ( 'The template file "' . $tpl . $templates_cfg ['template_file_ext'] . " compiled failed!" );
		return - 1;
	}
}
function compiled_save($tpl, $path, $template_sources) {
	global $templates_cfg;
	$copyright = "<?php\r\n/*\r\n NL's Template Compiler 2.0.0(necylus@126.com)\r\n" . "compiled from " . $tpl . $templates_cfg ['template_file_ext'] . " on " . date ( "Y-m-d H:i:s" ) . "\r\n*/\r\n" . '?>';
	$template_sources = $copyright . $template_sources;
	
	$objfile = $path;
	if (! @$fp = fopen ( $objfile, 'w' )) {
		die ( "Directory '" . $templates_cfg ['templates_compiled_dir'] . "' not found or have no access!" );
	}
	flock ( $fp, 2 );
	fwrite ( $fp, $template_sources );
	fclose ( $fp );
	return 0;
}
function template_lang($langid) {
	if (! function_exists ( 'lang' ))
		return $langid;
	else
		lang ( $langid );
}
function template_unix_timestamp($timestamp, $format = '') {
	if (! $format)
		$format = 'Y-m-d H:i:s';
	return date ( $format, $timestamp );
}
function template_htmlspecialchars($string) {
	if (is_string ( $string )) {
		$string = strip_tags ( $string );
		$string = preg_replace ( '/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1', str_replace ( array ('&', '"', '<', '>' ), array ('&amp;', '&quot;', '&lt;', '&gt;' ), $string ) );
	}
	return $string;
}
function template_cycle($values, &$t) {
	list ( $var1, $var2 ) = explode ( ",", $values );
	$var1 = trim ( $var1 );
	$var2 = trim ( $var2 );
	if (! $t) {
		$t = $var1;
	} elseif ($t == $var1) {
		$t = $var2;
	} else {
		$t = $var1;
	}
	return $t;
}
function template_varscompiler($expr) {
	if (strstr ( $expr, "." )) {
		$vars = explode ( ".", $expr );
		$return = '';
		foreach ( $vars as $id => $key ) {
			if ($id == 0)
				$return .= $key;
			else
				$return .= '[' . $key . ']';
		}
		return $return;
	} else {
		return str_replace ( '\\', '', $expr );
	}
}
function template_stripvtags($expr, $statement) {
	$expr = str_replace ( "\\\"", "\"", preg_replace ( "/\<\?\=(\\\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\[\]\"\'\$\x7f-\xff]*)\?\>/s", "\\1", $expr ) );
	$statement = str_replace ( "\\\"", "\"", $statement );
	return $expr . $statement;
}
if (! function_exists ( '_mkdir' )) {
	function _mkdir($dir) {
		$u = umask ( 0 );
		if (file_exists ( $dir ))
			return true;
		$r = @mkdir ( $dir, 0777 );
		umask ( $u );
		return $r;
	}
}
if (! function_exists ( 'mkdirs' )) {
	function mkdirs($dir, $rootpath = '.') {
		if (! $rootpath)
			return false;
		if ($rootpath == '.')
			$rootpath = realpath ( $rootpath );
		$forlder = explode ( '/', $dir );
		$path = '';
		for($i = 0; $i < count ( $forlder ); $i ++) {
			if ($current_dir = trim ( $forlder [$i] )) {
				if ($current_dir == '.')
					continue;
				$path .= '/' . $current_dir;
				if ($current_dir == '..') {
					continue;
				}
				if (file_exists ( $rootpath . $path )) {
					@chmod ( $rootpath . $path, 0777 );
				} else {
					if (! _mkdir ( $rootpath . $path )) {
						return false;
					}
				}
			}
		}
		return true;
	}
}
