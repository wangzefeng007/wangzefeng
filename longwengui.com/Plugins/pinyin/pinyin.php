<?php
function ChineseToPinyinTwo($string){
		global $__pinyins__;
		$restring = '';
		$str = trim($string);
		$slen = strlen($string);
		if ($slen < 2)
		return $str;
		if (! $__pinyins__) {
			$fp = file(SYSTEM_ROOTPATH . '/Plugins/pinyin/pinyin.dat');
			foreach ($fp as $line) {
				$tmp = explode('`', $line);
				$__pinyins__[$tmp[0]] = str_replace(array(
				"\r", 
				"\n"
				), array(
				'', 
				''
				), $tmp[1]);
			}
			unset($fp);
		}
		$n = 0;
		while ($n < $slen) {
			$start = $n;
			$t = ord($string[$n]);
			if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1;
			} elseif (194 <= $t && $t <= 223) {
				$tn = 2;
			} elseif (224 <= $t && $t < 239) {
				$tn = 3;
			} elseif (240 <= $t && $t <= 247) {
				$tn = 4;
			} elseif (248 <= $t && $t <= 251) {
				$tn = 5;
			} elseif ($t == 252 || $t == 253) {
				$tn = 6;
			} else {
				$tn = 1;
			}

			if ($tn > 1) {
				$substring = substr($string, $start, $tn);
				$zhongwenarray[]=$substring;
				if ($__pinyins__[$substring])
				$restring .= $__pinyins__[$substring];
				else
				$restring .= '';
				$yingwenarray[]=$__pinyins__[$substring];
			} else
			$restring .= '';
			$n += $tn;
		}
		foreach ($zhongwenarray as $k=>$v)
		{
			$string= str_replace ( $v, $yingwenarray[$k], $string );
			$string = ucwords($string);
		}
		return $string;
	}