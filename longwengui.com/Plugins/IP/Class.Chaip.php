<?php

//*
//文件头 [第一条索引的偏移量 (4byte)] + [最后一条索引的偏移地址 (4byte)]     8字节
//记录区 [结束ip (4byte)] + [地区1] + [地区2]                                4字节+不定长
//索引区 [开始ip (4byte)] + [指向记录区的偏移地址 (3byte)]                   7字节
//注意:使用之前请去网上下载纯真IP数据库,并改名为 "CoralWry.dat" 放到当前目录下即可.
//by 查询吧 www.query8.com
//*
class ipLocation
{
	var $fp;
	var $firstip; //第一条ip索引的偏移地址
	var $lastip; //最后一条ip索引的偏移地址
	var $totalip; //总ip数

	//*
	//构造函数,初始化一些变量
	//$datfile 的值为纯真IP数据库的名子,可自行修改.
	//*
	function ipLocation()
	{
		$datfile = SYSTEM_ROOTPATH . '/Include/IP/qqwry.dat';
		$this->fp = fopen($datfile, 'rb'); //二制方式打开
		$this->firstip = $this->get4b(); //第一条ip索引的绝对偏移地址
		$this->lastip = $this->get4b(); //最后一条ip索引的绝对偏移地址
		$this->totalip = ($this->lastip - $this->firstip) / 7; //ip总数 索引区是定长的7个字节,在此要除以7,
		register_shutdown_function(array($this , "closefp")); //为了兼容php5以下版本,本类没有用析构函数,自动关闭ip库.
	}

	//*
	//关闭ip库
	//*
	function closefp()
	{
		fclose($this->fp);
	}

	//*
	//读取4个字节并将解压成long的长模式
	//*
	function get4b()
	{
		$str = unpack("V", fread($this->fp, 4));
		return $str[1];
	}

	//*
	//读取重定向了的偏移地址
	//*
	function getoffset()
	{
		$str = unpack("V", fread($this->fp, 3) . chr(0));
		return $str[1];
	}

	//*
	//读取ip的详细地址信息
	//*
	function getstr()
	{
		$split = fread($this->fp, 1);
		while (ord($split) != 0)
		{
			$str .= $split;
			$split = fread($this->fp, 1);
		}
		return $str;
	}

	//*
	//将ip通过ip2long转成ipv4的互联网地址,再将他压缩成big-endian字节序
	//用来和索引区内的ip地址做比较
	//*
	function iptoint($ip)
	{
		return pack("N", intval(ip2long($ip)));
	}

	//*
	//获取客户端ip地址
	//注意:如果你想要把ip记录到服务器上,请在写库时先检查一下ip的数据是否安全.
	//*
	function get_IP()
	{
		
		if (getenv('HTTP_CLIENT_IP'))
		{
			$ip = getenv('HTTP_CLIENT_IP');
		}
		elseif (getenv('HTTP_X_FORWARDED_FOR'))
		{ //获取客户端用代理服务器访问时的真实ip 地址
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_X_FORWARDED'))
		{
			$ip = getenv('HTTP_X_FORWARDED');
		}
		elseif (getenv('HTTP_FORWARDED_FOR'))
		{
			$ip = getenv('HTTP_FORWARDED_FOR');
		}
		elseif (getenv('HTTP_FORWARDED'))
		{
			$ip = getenv('HTTP_FORWARDED');
		}
		else
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	//*
	//获取地址信息
	//*
	function readaddress()
	{
		$now_offset = ftell($this->fp); //得到当前的指针位址
		$flag = $this->getflag();
		switch (ord($flag))
		{
			case 0:
				$address = "";
				break;
			case 1:
			case 2:
				fseek($this->fp, $this->getoffset());
				$address = $this->getstr();
				break;
			default:
				fseek($this->fp, $now_offset);
				$address = $this->getstr();
				break;
		}
		return $address;
	}

	//*
	//获取标志1或2
	//用来确定地址是否重定向了.
	//*
	function getflag()
	{
		return fread($this->fp, 1);
	}

	//*
	//用二分查找法在索引区内搜索ip
	//*
	function searchip($ip)
	{
		$ip = gethostbyname($ip); //将域名转成ip
		$ip_offset["ip"] = $ip;
		$ip = $this->iptoint($ip); //将ip转换成长整型
		$firstip = 0; //搜索的上边界
		$lastip = $this->totalip; //搜索的下边界
		$ipoffset = $this->lastip; //初始化为最后一条ip地址的偏移地址
		while ($firstip <= $lastip)
		{
			$i = floor(($firstip + $lastip) / 2); //计算近似中间记录 floor函数记算给定浮点数小的最大整数,说白了就是四舍五也舍
			fseek($this->fp, $this->firstip + $i * 7); //定位指针到中间记录
			$startip = strrev(fread($this->fp, 4)); //读取当前索引区内的开始ip地址,并将其little-endian的字节序转换成big-endian的字节序
			if ($ip < $startip)
			{
				$lastip = $i - 1;
			}
			else
			{
				fseek($this->fp, $this->getoffset());
				$endip = strrev(fread($this->fp, 4));
				if ($ip > $endip)
				{
					$firstip = $i + 1;
				}
				else
				{
					$ip_offset["offset"] = $this->firstip + $i * 7;
					break;
				}
			}
		}
		return $ip_offset;
	}

	//*
	//获取ip地址详细信息
	//*
	function getaddress($ip)
	{
		$ip_offset = $this->searchip($ip); //获取ip 在索引区内的绝对编移地址
		$ipoffset = $ip_offset["offset"];
		$address["ip"] = $ip_offset["ip"];
		fseek($this->fp, $ipoffset); //定位到索引区
		$address["startip"] = long2ip($this->get4b()); //索引区内的开始ip 地址
		$address_offset = $this->getoffset(); //获取索引区内ip在ip记录区内的偏移地址
		fseek($this->fp, $address_offset); //定位到记录区内
		$address["endip"] = long2ip($this->get4b()); //记录区内的结束ip 地址
		$flag = $this->getflag(); //读取标志字节
		switch (ord($flag))
		{
			case 1: //地区1地区2都重定向
				$address_offset = $this->getoffset(); //读取重定向地址
				fseek($this->fp, $address_offset); //定位指针到重定向的地址
				$flag = $this->getflag(); //读取标志字节
				switch (ord($flag))
				{
					case 2: //地区1又一次重定向,
						fseek($this->fp, $this->getoffset());
						$address["area1"] = $this->getstr();
						fseek($this->fp, $address_offset + 4); //跳4个字节
						$address["area2"] = $this->readaddress(); //地区2有可能重定向,有可能没有
						break;
					default: //地区1,地区2都没有重定向
						fseek($this->fp, $address_offset); //定位指针到重定向的地址
						$address["area1"] = $this->getstr();
						$address["area2"] = $this->readaddress();
						break;
				}
				break;
			case 2: //地区1重定向 地区2没有重定向
				$address1_offset = $this->getoffset(); //读取重定向地址
				fseek($this->fp, $address1_offset);
				$address["area1"] = $this->getstr();
				fseek($this->fp, $address_offset + 8);
				$address["area2"] = $this->readaddress();
				break;
			default: //地区1地区2都没有重定向
				fseek($this->fp, $address_offset + 4);
				$address["area1"] = $this->getstr();
				$address["area2"] = $this->readaddress();
				break;
		}
		//*过滤一些无用数据
		if (strpos($address["area1"], "CZ88.NET") != false)
		{
			$address["area1"] = "未知";
		}
		if (strpos($address["area2"], "CZ88.NET") != false)
		{
			$address["area2"] = " ";
		}
		return $address;
	}

}
//*ipLocation class end


$wordCity = Array(

0 => Array("pinyin" => "qinhuangdao" , "id" => "130300" , "name" => "秦皇岛") , 

1 => Array("pinyin" => "handan" , "id" => "130400" , "name" => "邯郸") , 

2 => Array("pinyin" => "baoding" , "id" => "130600" , "name" => "保定") , 

3 => Array("pinyin" => "chengde" , "id" => "130800" , "name" => "承德") , 

4 => Array("pinyin" => "cangzhou" , "id" => "130900" , "name" => "沧州") , 

5 => Array("pinyin" => "langfang" , "id" => "131000" , "name" => "廊坊") , 

6 => Array("pinyin" => "hengshui" , "id" => "131100" , "name" => "衡水") , 

7 => Array("pinyin" => "datong" , "id" => "140200" , "name" => "大同") , 

8 => Array("pinyin" => "yangquan" , "id" => "140300" , "name" => "阳泉") , 

9 => Array("pinyin" => "changzhi" , "id" => "140400" , "name" => "长治") , 

10 => Array("pinyin" => "shuozhou" , "id" => "140600" , "name" => "朔州") , 

11 => Array("pinyin" => "jinzhong" , "id" => "140700" , "name" => "晋中") , 

12 => Array("pinyin" => "xinzhou" , "id" => "140900" , "name" => "忻州") , 

13 => Array("pinyin" => "linfen" , "id" => "141000" , "name" => "临汾") , 

14 => Array("pinyin" => "luliang" , "id" => "141100" , "name" => "吕梁") , 

15 => Array("pinyin" => "wuhai" , "id" => "150300" , "name" => "乌海") , 

16 => Array("pinyin" => "chifeng" , "id" => "150400" , "name" => "赤峰") , 

17 => Array("pinyin" => "tongliao" , "id" => "150500" , "name" => "通辽") , 

18 => Array("pinyin" => "eerduosi" , "id" => "150600" , "name" => "鄂尔多斯") , 

19 => Array("pinyin" => "hulunbeier" , "id" => "150700" , "name" => "呼伦贝尔") , 

20 => Array("pinyin" => "bayanneer" , "id" => "150800" , "name" => "巴彦淖尔") , 

21 => Array("pinyin" => "wulanchabu" , "id" => "150900" , "name" => "乌兰察布") , 

22 => Array("pinyin" => "xingan" , "id" => "152200" , "name" => "兴安盟") , 

23 => Array("pinyin" => "xilinguole" , "id" => "152500" , "name" => "锡林郭勒盟") , 

24 => Array("pinyin" => "wulanchabumeng" , "id" => "152600" , "name" => "乌兰察布盟") , 

25 => Array("pinyin" => "alashan" , "id" => "152900" , "name" => "阿拉善盟") , 

26 => Array("pinyin" => "fushun" , "id" => "210400" , "name" => "抚顺") , 

27 => Array("pinyin" => "benxi" , "id" => "210500" , "name" => "本溪") , 

28 => Array("pinyin" => "dandong" , "id" => "210600" , "name" => "丹东") , 

29 => Array("pinyin" => "yingkou" , "id" => "210800" , "name" => "营口") , 

30 => Array("pinyin" => "fuxin" , "id" => "210900" , "name" => "阜新") , 

31 => Array("pinyin" => "liaoyang" , "id" => "211000" , "name" => "辽阳") , 

32 => Array("pinyin" => "panjin" , "id" => "211100" , "name" => "盘锦") , 

33 => Array("pinyin" => "tieling" , "id" => "211200" , "name" => "铁岭") , 

34 => Array("pinyin" => "chaoyang" , "id" => "211300" , "name" => "朝阳") , 

35 => Array("pinyin" => "huludao" , "id" => "211400" , "name" => "葫芦岛") , 

36 => Array("pinyin" => "siping" , "id" => "220300" , "name" => "四平") , 

37 => Array("pinyin" => "liaoyuan" , "id" => "220400" , "name" => "辽源") , 

38 => Array("pinyin" => "tonghua" , "id" => "220500" , "name" => "通化") , 

39 => Array("pinyin" => "baishan" , "id" => "220600" , "name" => "白山") , 

40 => Array("pinyin" => "songyuan" , "id" => "220700" , "name" => "松原") , 

41 => Array("pinyin" => "yanbian" , "id" => "222400" , "name" => "延边") , 

42 => Array("pinyin" => "jixi" , "id" => "230300" , "name" => "鸡西") , 

43 => Array("pinyin" => "hegang" , "id" => "230400" , "name" => "鹤岗") , 

44 => Array("pinyin" => "shuangyashan" , "id" => "230500" , "name" => "双鸭山") , 

45 => Array("pinyin" => "daqing" , "id" => "230600" , "name" => "大庆") , 

46 => Array("pinyin" => "yichun" , "id" => "230700" , "name" => "伊春") , 

47 => Array("pinyin" => "jiamusi" , "id" => "230800" , "name" => "佳木斯") , 

48 => Array("pinyin" => "qitaihe" , "id" => "230900" , "name" => "七台河") , 

49 => Array("pinyin" => "mudanjiang" , "id" => "231000" , "name" => "牡丹江") , 

50 => Array("pinyin" => "heihe" , "id" => "231100" , "name" => "黑河") , 

51 => Array("pinyin" => "suihua" , "id" => "231200" , "name" => "绥化") , 

52 => Array("pinyin" => "daxinganling" , "id" => "232700" , "name" => "大兴安岭") , 

53 => Array("pinyin" => "xuzhou" , "id" => "320300" , "name" => "徐州") , 

54 => Array("pinyin" => "changzhou" , "id" => "320400" , "name" => "常州") , 

55 => Array("pinyin" => "nantong" , "id" => "320600" , "name" => "南通") , 

56 => Array("pinyin" => "lianyungang" , "id" => "320700" , "name" => "连云港") , 

57 => Array("pinyin" => "huaian" , "id" => "320800" , "name" => "淮安") , 

58 => Array("pinyin" => "zhenjiang" , "id" => "321100" , "name" => "镇江") , 

59 => Array("pinyin" => "taizhou" , "id" => "321200" , "name" => "泰州") , 

60 => Array("pinyin" => "suqian" , "id" => "321300" , "name" => "宿迁") , 

61 => Array("pinyin" => "huzhou" , "id" => "330500" , "name" => "湖州") , 

62 => Array("pinyin" => "shaoxing" , "id" => "330600" , "name" => "绍兴") , 

63 => Array("pinyin" => "jinhua" , "id" => "330700" , "name" => "金华") , 

64 => Array("pinyin" => "quzhou" , "id" => "330800" , "name" => "衢州") , 

65 => Array("pinyin" => "zhoushan" , "id" => "330900" , "name" => "舟山") , 

66 => Array("pinyin" => "taizhoushi" , "id" => "331000" , "name" => "台州") , 

67 => Array("pinyin" => "lishui" , "id" => "331100" , "name" => "丽水") , 

68 => Array("pinyin" => "wuhu" , "id" => "340200" , "name" => "芜湖") , 

69 => Array("pinyin" => "bengbu" , "id" => "340300" , "name" => "蚌埠") , 

70 => Array("pinyin" => "huainan" , "id" => "340400" , "name" => "淮南") , 

71 => Array("pinyin" => "maanshan" , "id" => "340500" , "name" => "马鞍山") , 

72 => Array("pinyin" => "huaibei" , "id" => "340600" , "name" => "淮北") , 

73 => Array("pinyin" => "tongling" , "id" => "340700" , "name" => "铜陵") , 

74 => Array("pinyin" => "anqing" , "id" => "340800" , "name" => "安庆") , 

75 => Array("pinyin" => "huangshan" , "id" => "341000" , "name" => "黄山") , 

76 => Array("pinyin" => "chuzhou" , "id" => "341100" , "name" => "滁州") , 

77 => Array("pinyin" => "fuyang" , "id" => "341200" , "name" => "阜阳") , 

78 => Array("pinyin" => "suzhoushi" , "id" => "341300" , "name" => "宿州") , 

79 => Array("pinyin" => "chaohu" , "id" => "341400" , "name" => "巢湖") , 

80 => Array("pinyin" => "liuan" , "id" => "341500" , "name" => "六安") , 

81 => Array("pinyin" => "bozhou" , "id" => "341600" , "name" => "亳州") , 

82 => Array("pinyin" => "chizhou" , "id" => "341700" , "name" => "池州") , 

83 => Array("pinyin" => "putian" , "id" => "350300" , "name" => "莆田") , 

84 => Array("pinyin" => "sanming" , "id" => "350400" , "name" => "三明") , 

85 => Array("pinyin" => "huian" , "id" => "350521" , "name" => "惠安县") , 

86 => Array("pinyin" => "shishi" , "id" => "350581" , "name" => "石狮") , 

87 => Array("pinyin" => "jinjiang" , "id" => "350582" , "name" => "晋江") , 

88 => Array("pinyin" => "nanan" , "id" => "350583" , "name" => "南安") , 

89 => Array("pinyin" => "zhangzhou" , "id" => "350600" , "name" => "漳州") , 

90 => Array("pinyin" => "nanping" , "id" => "350700" , "name" => "南平") , 

91 => Array("pinyin" => "longyan" , "id" => "350800" , "name" => "龙岩") , 

92 => Array("pinyin" => "ningde" , "id" => "350900" , "name" => "宁德") , 

93 => Array("pinyin" => "pingxiang" , "id" => "360300" , "name" => "萍乡") , 

94 => Array("pinyin" => "xinyu" , "id" => "360500" , "name" => "新余") , 

95 => Array("pinyin" => "yingtan" , "id" => "360600" , "name" => "鹰潭") , 

96 => Array("pinyin" => "jian" , "id" => "360800" , "name" => "吉安") , 

97 => Array("pinyin" => "yichunshi" , "id" => "360900" , "name" => "宜春") , 

98 => Array("pinyin" => "shangrao" , "id" => "361100" , "name" => "上饶") , 

99 => Array("pinyin" => "zibo" , "id" => "370300" , "name" => "淄博") , 

100 => Array("pinyin" => "zaozhuang" , "id" => "370400" , "name" => "枣庄") , 

101 => Array("pinyin" => "dongying" , "id" => "370500" , "name" => "东营") , 

102 => Array("pinyin" => "weifang" , "id" => "370700" , "name" => "潍坊") , 

103 => Array("pinyin" => "taian" , "id" => "370900" , "name" => "泰安") , 

104 => Array("pinyin" => "weihai" , "id" => "371000" , "name" => "威海") , 

105 => Array("pinyin" => "rizhao" , "id" => "371100" , "name" => "日照") , 

106 => Array("pinyin" => "laiwu" , "id" => "371200" , "name" => "莱芜") , 

107 => Array("pinyin" => "dezhou" , "id" => "371400" , "name" => "德州") , 

108 => Array("pinyin" => "heze" , "id" => "371700" , "name" => "荷泽") , 

109 => Array("pinyin" => "pingdingshan" , "id" => "410400" , "name" => "平顶山") , 

110 => Array("pinyin" => "anyang" , "id" => "410500" , "name" => "安阳") , 

111 => Array("pinyin" => "hebi" , "id" => "410600" , "name" => "鹤壁") , 

112 => Array("pinyin" => "xinxiang" , "id" => "410700" , "name" => "新乡") , 

113 => Array("pinyin" => "jiaozuo" , "id" => "410800" , "name" => "焦作") , 

114 => Array("pinyin" => "jiyuan" , "id" => "410881" , "name" => "济源") , 

115 => Array("pinyin" => "puyang" , "id" => "410900" , "name" => "濮阳") , 

116 => Array("pinyin" => "xuchang" , "id" => "411000" , "name" => "许昌") , 

117 => Array("pinyin" => "luohe" , "id" => "411100" , "name" => "漯河") , 

118 => Array("pinyin" => "sanmenxia" , "id" => "411200" , "name" => "三门峡") , 

119 => Array("pinyin" => "nanyang" , "id" => "411300" , "name" => "南阳") , 

120 => Array("pinyin" => "shangqiu" , "id" => "411400" , "name" => "商丘") , 

121 => Array("pinyin" => "xinyang" , "id" => "411500" , "name" => "信阳") , 

122 => Array("pinyin" => "zhoukou" , "id" => "411600" , "name" => "周口") , 

123 => Array("pinyin" => "zhumadian" , "id" => "411700" , "name" => "驻马店") , 

124 => Array("pinyin" => "huangshi" , "id" => "420200" , "name" => "黄石") , 

125 => Array("pinyin" => "shiyan" , "id" => "420300" , "name" => "十堰") , 

126 => Array("pinyin" => "yichang" , "id" => "420500" , "name" => "宜昌") , 

127 => Array("pinyin" => "xiangfan" , "id" => "420600" , "name" => "襄樊") , 

128 => Array("pinyin" => "ezhou" , "id" => "420700" , "name" => "鄂州") , 

129 => Array("pinyin" => "jingmen" , "id" => "420800" , "name" => "荆门") , 

130 => Array("pinyin" => "xiaogan" , "id" => "420900" , "name" => "孝感") , 

131 => Array("pinyin" => "jingzhou" , "id" => "421000" , "name" => "荆州") , 

132 => Array("pinyin" => "huanggang" , "id" => "421100" , "name" => "黄冈") , 

133 => Array("pinyin" => "xianning" , "id" => "421200" , "name" => "咸宁") , 

134 => Array("pinyin" => "suizhou" , "id" => "421300" , "name" => "随州") , 

135 => Array("pinyin" => "enshi" , "id" => "422800" , "name" => "恩施") , 

136 => Array("pinyin" => "xiangtan" , "id" => "430300" , "name" => "湘潭") , 

137 => Array("pinyin" => "yueyang" , "id" => "430600" , "name" => "岳阳") , 

138 => Array("pinyin" => "changde" , "id" => "430700" , "name" => "常德") , 

139 => Array("pinyin" => "zhangjiajie" , "id" => "430800" , "name" => "张家界") , 

140 => Array("pinyin" => "yiyang" , "id" => "430900" , "name" => "益阳") , 

141 => Array("pinyin" => "loudi" , "id" => "431300" , "name" => "娄底") , 

142 => Array("pinyin" => "xiangxi" , "id" => "433100" , "name" => "湘西") , 

143 => Array("pinyin" => "foshan" , "id" => "440600" , "name" => "佛山") , 

144 => Array("pinyin" => "jiangmen" , "id" => "440700" , "name" => "江门") , 

145 => Array("pinyin" => "maoming" , "id" => "440900" , "name" => "茂名") , 

146 => Array("pinyin" => "zhaoqing" , "id" => "441200" , "name" => "肇庆") , 

147 => Array("pinyin" => "huizhou" , "id" => "441300" , "name" => "惠州") , 

148 => Array("pinyin" => "meizhou" , "id" => "441400" , "name" => "梅州") , 

149 => Array("pinyin" => "shanwei" , "id" => "441500" , "name" => "汕尾") , 

150 => Array("pinyin" => "heyuan" , "id" => "441600" , "name" => "河源") , 

151 => Array("pinyin" => "yangjiang" , "id" => "441700" , "name" => "阳江") , 

152 => Array("pinyin" => "qingyuan" , "id" => "441800" , "name" => "清远") , 

153 => Array("pinyin" => "dongguan" , "id" => "441900" , "name" => "东莞") , 

154 => Array("pinyin" => "zhongshan" , "id" => "442000" , "name" => "中山") , 

155 => Array("pinyin" => "chaozhou" , "id" => "445100" , "name" => "潮州") , 

156 => Array("pinyin" => "jieyang" , "id" => "445200" , "name" => "揭阳") , 

157 => Array("pinyin" => "yunfu" , "id" => "445300" , "name" => "云浮") , 

158 => Array("pinyin" => "guilin" , "id" => "450300" , "name" => "桂林") , 

159 => Array("pinyin" => "wuzhou" , "id" => "450400" , "name" => "梧州") , 

160 => Array("pinyin" => "beihai" , "id" => "450500" , "name" => "北海") , 

161 => Array("pinyin" => "fangchenggang" , "id" => "450600" , "name" => "防城港") , 

162 => Array("pinyin" => "qinzhou" , "id" => "450700" , "name" => "钦州") , 

163 => Array("pinyin" => "guigang" , "id" => "450800" , "name" => "贵港") , 

164 => Array("pinyin" => "yulin" , "id" => "450900" , "name" => "玉林") , 

165 => Array("pinyin" => "baise" , "id" => "451000" , "name" => "百色") , 

166 => Array("pinyin" => "hezhou" , "id" => "451100" , "name" => "贺州") , 

167 => Array("pinyin" => "hechi" , "id" => "451200" , "name" => "河池") , 

168 => Array("pinyin" => "laibin" , "id" => "451300" , "name" => "来宾") , 

169 => Array("pinyin" => "chongzuo" , "id" => "451400" , "name" => "崇左") , 

170 => Array("pinyin" => "sanya" , "id" => "460200" , "name" => "三亚") , 

171 => Array("pinyin" => "zigong" , "id" => "510300" , "name" => "自贡") , 

172 => Array("pinyin" => "panzhihua" , "id" => "510400" , "name" => "攀枝花") , 

173 => Array("pinyin" => "luzhou" , "id" => "510500" , "name" => "泸州") , 

174 => Array("pinyin" => "deyang" , "id" => "510600" , "name" => "德阳") , 

175 => Array("pinyin" => "mianyang" , "id" => "510700" , "name" => "绵阳") , 

176 => Array("pinyin" => "guangyuan" , "id" => "510800" , "name" => "广元") , 

177 => Array("pinyin" => "suining" , "id" => "510900" , "name" => "遂宁") , 

178 => Array("pinyin" => "neijiang" , "id" => "511000" , "name" => "内江") , 

179 => Array("pinyin" => "nanchong" , "id" => "511300" , "name" => "南充") , 

180 => Array("pinyin" => "meishan" , "id" => "511400" , "name" => "眉山") , 

181 => Array("pinyin" => "yibin" , "id" => "511500" , "name" => "宜宾") , 

182 => Array("pinyin" => "guangan" , "id" => "511600" , "name" => "广安") , 

183 => Array("pinyin" => "dazhou" , "id" => "511700" , "name" => "达州") , 

184 => Array("pinyin" => "yaan" , "id" => "511800" , "name" => "雅安") , 

185 => Array("pinyin" => "bazhong" , "id" => "511900" , "name" => "巴中") , 

186 => Array("pinyin" => "ziyang" , "id" => "512000" , "name" => "资阳") , 

187 => Array("pinyin" => "aba" , "id" => "513200" , "name" => "阿坝州") , 

188 => Array("pinyin" => "liangshan" , "id" => "513400" , "name" => "凉山") , 

189 => Array("pinyin" => "liupanshui" , "id" => "520200" , "name" => "六盘水") , 

190 => Array("pinyin" => "zunyi" , "id" => "520300" , "name" => "遵义") , 

191 => Array("pinyin" => "anshun" , "id" => "520400" , "name" => "安顺") , 

192 => Array("pinyin" => "tongren" , "id" => "522200" , "name" => "铜仁") , 

193 => Array("pinyin" => "qianxinan" , "id" => "522300" , "name" => "黔西南州") , 

194 => Array("pinyin" => "bijie" , "id" => "522400" , "name" => "毕节") , 

195 => Array("pinyin" => "qiandongnan" , "id" => "522600" , "name" => "黔东南") , 

196 => Array("pinyin" => "qiannan" , "id" => "522700" , "name" => "黔南") , 

197 => Array("pinyin" => "qujing" , "id" => "530300" , "name" => "曲靖") , 

198 => Array("pinyin" => "yuxi" , "id" => "530400" , "name" => "玉溪") , 

199 => Array("pinyin" => "baoshan" , "id" => "530500" , "name" => "保山") , 

200 => Array("pinyin" => "zhaotong" , "id" => "530600" , "name" => "昭通") , 

201 => Array("pinyin" => "lijiang" , "id" => "530700" , "name" => "丽江") , 

202 => Array("pinyin" => "puer" , "id" => "530800" , "name" => "思茅") , 

203 => Array("pinyin" => "lincang" , "id" => "530900" , "name" => "临沧") , 

204 => Array("pinyin" => "chuxiong" , "id" => "532300" , "name" => "楚雄") , 

205 => Array("pinyin" => "honghe" , "id" => "532500" , "name" => "红河") , 

206 => Array("pinyin" => "wenshan" , "id" => "532600" , "name" => "文山") , 

207 => Array("pinyin" => "xishuangbanna" , "id" => "532800" , "name" => "西双版纳") , 

208 => Array("pinyin" => "dali" , "id" => "532900" , "name" => "大理") , 

209 => Array("pinyin" => "dehong" , "id" => "533100" , "name" => "德宏") , 

210 => Array("pinyin" => "nujiang" , "id" => "533300" , "name" => "怒江") , 

211 => Array("pinyin" => "diqing" , "id" => "533400" , "name" => "迪庆") , 

212 => Array("pinyin" => "changdu" , "id" => "542100" , "name" => "昌都") , 

213 => Array("pinyin" => "shannan" , "id" => "542200" , "name" => "山南") , 

214 => Array("pinyin" => "rikaze" , "id" => "542300" , "name" => "日喀则") , 

215 => Array("pinyin" => "naqu" , "id" => "542400" , "name" => "那曲") , 

216 => Array("pinyin" => "ali" , "id" => "542500" , "name" => "阿里") , 

217 => Array("pinyin" => "linzhi" , "id" => "542600" , "name" => "林芝") , 

218 => Array("pinyin" => "tongchuan" , "id" => "610200" , "name" => "铜川") , 

219 => Array("pinyin" => "baoji" , "id" => "610300" , "name" => "宝鸡") , 

220 => Array("pinyin" => "xianyang" , "id" => "610400" , "name" => "咸阳") , 

221 => Array("pinyin" => "weinan" , "id" => "610500" , "name" => "渭南") , 

222 => Array("pinyin" => "yanan" , "id" => "610600" , "name" => "延安") , 

223 => Array("pinyin" => "hanzhong" , "id" => "610700" , "name" => "汉中") , 

224 => Array("pinyin" => "ankang" , "id" => "610900" , "name" => "安康") , 

225 => Array("pinyin" => "shangluo" , "id" => "611000" , "name" => "商洛") , 

226 => Array("pinyin" => "jiayuguan" , "id" => "620200" , "name" => "嘉峪关") , 

227 => Array("pinyin" => "jinchang" , "id" => "620300" , "name" => "金昌") , 

228 => Array("pinyin" => "baiyin" , "id" => "620400" , "name" => "白银") , 

229 => Array("pinyin" => "tianshui" , "id" => "620500" , "name" => "天水") , 

230 => Array("pinyin" => "wuwei" , "id" => "620600" , "name" => "武威") , 

231 => Array("pinyin" => "zhangye" , "id" => "620700" , "name" => "张掖") , 

232 => Array("pinyin" => "pingliang" , "id" => "620800" , "name" => "平凉") , 

233 => Array("pinyin" => "jiuquan" , "id" => "620900" , "name" => "酒泉") , 

234 => Array("pinyin" => "qingyang" , "id" => "621000" , "name" => "庆阳") , 

235 => Array("pinyin" => "dingxi" , "id" => "621100" , "name" => "定西") , 

236 => Array("pinyin" => "longnan" , "id" => "621200" , "name" => "陇南") , 

237 => Array("pinyin" => "linxia" , "id" => "622900" , "name" => "临夏") , 

238 => Array("pinyin" => "gannan" , "id" => "623000" , "name" => "甘南") , 

239 => Array("pinyin" => "haidong" , "id" => "632100" , "name" => "海东") , 

240 => Array("pinyin" => "haibei" , "id" => "632200" , "name" => "海北") , 

241 => Array("pinyin" => "hainan" , "id" => "632500" , "name" => "海南") , 

242 => Array("pinyin" => "guoluo" , "id" => "632600" , "name" => "果洛") , 

243 => Array("pinyin" => "yushu" , "id" => "632700" , "name" => "玉树") , 

244 => Array("pinyin" => "haixi" , "id" => "632800" , "name" => "海西") , 

245 => Array("pinyin" => "shizuishan" , "id" => "640200" , "name" => "石嘴山") , 

246 => Array("pinyin" => "wuzhong" , "id" => "640300" , "name" => "吴忠") , 

247 => Array("pinyin" => "guyuan" , "id" => "640400" , "name" => "固原") , 

248 => Array("pinyin" => "zhongwei" , "id" => "640500" , "name" => "中卫") , 

249 => Array("pinyin" => "karamay" , "id" => "650200" , "name" => "克拉玛依") , 

250 => Array("pinyin" => "tulufan" , "id" => "652100" , "name" => "吐鲁番") , 

251 => Array("pinyin" => "hami" , "id" => "652200" , "name" => "哈密") , 

252 => Array("pinyin" => "changji" , "id" => "652300" , "name" => "昌吉") , 

253 => Array("pinyin" => "akesu" , "id" => "652900" , "name" => "阿克苏") , 

254 => Array("pinyin" => "hetian" , "id" => "653200" , "name" => "和田") , 

255 => Array("pinyin" => "yili" , "id" => "654000" , "name" => "伊犁") , 

256 => Array("pinyin" => "tacheng" , "id" => "654200" , "name" => "塔城") , 

257 => Array("pinyin" => "altay" , "id" => "654300" , "name" => "阿勒泰") , 

258 => Array("pinyin" => "qionghai" , "id" => "469002" , "name" => "琼海") , 

259 => Array("pinyin" => "danzhou" , "id" => "469003" , "name" => "儋州") , 

260 => Array("pinyin" => "wenchang" , "id" => "469005" , "name" => "文昌") , 

261 => Array("pinyin" => "dongfang" , "id" => "469007" , "name" => "东方") , 

262 => Array("pinyin" => "xiantao" , "id" => "429004" , "name" => "仙桃") , 

263 => Array("pinyin" => "qianjiang" , "id" => "429005" , "name" => "潜江") , 

264 => Array("pinyin" => "tianmen" , "id" => "429006" , "name" => "天门") , 

265 => Array("pinyin" => "jincheng" , "id" => "140500" , "name" => "晋城") , 

266 => Array("pinyin" => "yuncheng" , "id" => "140800" , "name" => "运城") , 

267 => Array("pinyin" => "xuancheng" , "id" => "341800" , "name" => "宣城") , 

268 => Array("pinyin" => "liaocheng" , "id" => "371500" , "name" => "聊城") , 

269 => Array("pinyin" => "dongqu" , "id" => "810002" , "name" => "东区") , 

270 => Array("pinyin" => "nanqu" , "id" => "810005" , "name" => "南区") , 

271 => Array("pinyin" => "beiqu" , "id" => "810011" , "name" => "北区") , 

272 => Array("pinyin" => "lianjiangxian" , "id" => "912700" , "name" => "连江县") , 

273 => Array("pinyin" => "shijiazhuang" , "id" => "130100" , "name" => "石家庄") , 

274 => Array("pinyin" => "tangshan" , "id" => "130200" , "name" => "唐山") , 

275 => Array("pinyin" => "xingtai" , "id" => "130500" , "name" => "邢台") , 

276 => Array("pinyin" => "zhangjiakou" , "id" => "130700" , "name" => "张家口") , 

277 => Array("pinyin" => "taiyuan" , "id" => "140100" , "name" => "太原") , 

278 => Array("pinyin" => "huhehaote" , "id" => "150100" , "name" => "呼和浩特") , 

279 => Array("pinyin" => "baotou" , "id" => "150200" , "name" => "包头") , 

280 => Array("pinyin" => "shenyang" , "id" => "210100" , "name" => "沈阳") , 

281 => Array("pinyin" => "dalian" , "id" => "210200" , "name" => "大连") , 

282 => Array("pinyin" => "anshan" , "id" => "210300" , "name" => "鞍山") , 

283 => Array("pinyin" => "jinzhou" , "id" => "210700" , "name" => "锦州") , 

284 => Array("pinyin" => "changchun" , "id" => "220100" , "name" => "长春") , 

285 => Array("pinyin" => "jilinshi" , "id" => "220200" , "name" => "吉林") , 

286 => Array("pinyin" => "haerbin" , "id" => "230100" , "name" => "哈尔滨") , 

287 => Array("pinyin" => "qiqihaer" , "id" => "230200" , "name" => "齐齐哈尔") , 

288 => Array("pinyin" => "nanjing" , "id" => "320100" , "name" => "南京") , 

289 => Array("pinyin" => "wuxi" , "id" => "320200" , "name" => "无锡") , 

290 => Array("pinyin" => "suzhou" , "id" => "320500" , "name" => "苏州") , 

291 => Array("pinyin" => "yangzhou" , "id" => "321000" , "name" => "扬州") , 

292 => Array("pinyin" => "hangzhou" , "id" => "330100" , "name" => "杭州") , 

293 => Array("pinyin" => "ningbo" , "id" => "330200" , "name" => "宁波") , 

294 => Array("pinyin" => "wenzhou" , "id" => "330300" , "name" => "温州") , 

295 => Array("pinyin" => "jiaxing" , "id" => "330400" , "name" => "嘉兴") , 

296 => Array("pinyin" => "hefei" , "id" => "340100" , "name" => "合肥") , 

297 => Array("pinyin" => "fuzhou" , "id" => "350100" , "name" => "福州") , 

298 => Array("pinyin" => "xiamen" , "id" => "350200" , "name" => "厦门") , 

299 => Array("pinyin" => "quanzhou" , "id" => "350500" , "name" => "泉州") , 

300 => Array("pinyin" => "nanchang" , "id" => "360100" , "name" => "南昌") , 

301 => Array("pinyin" => "jingdezhen" , "id" => "360200" , "name" => "景德镇") , 

302 => Array("pinyin" => "jiujiang" , "id" => "360400" , "name" => "九江") , 

303 => Array("pinyin" => "ganzhou" , "id" => "360700" , "name" => "赣州") , 

304 => Array("pinyin" => "fuzhoushi" , "id" => "361000" , "name" => "抚州") , 

305 => Array("pinyin" => "jinan" , "id" => "370100" , "name" => "济南") , 

306 => Array("pinyin" => "qingdao" , "id" => "370200" , "name" => "青岛") , 

307 => Array("pinyin" => "yantai" , "id" => "370600" , "name" => "烟台") , 

308 => Array("pinyin" => "jining" , "id" => "370800" , "name" => "济宁") , 

309 => Array("pinyin" => "linyi" , "id" => "371300" , "name" => "临沂") , 

310 => Array("pinyin" => "binzhou" , "id" => "371600" , "name" => "滨州") , 

311 => Array("pinyin" => "zhengzhou" , "id" => "410100" , "name" => "郑州") , 

312 => Array("pinyin" => "kaifeng" , "id" => "410200" , "name" => "开封") , 

313 => Array("pinyin" => "luoyang" , "id" => "410300" , "name" => "洛阳") , 

314 => Array("pinyin" => "wuhan" , "id" => "420100" , "name" => "武汉") , 

315 => Array("pinyin" => "changsha" , "id" => "430100" , "name" => "长沙") , 

316 => Array("pinyin" => "zhuzhou" , "id" => "430200" , "name" => "株洲") , 

317 => Array("pinyin" => "hengyang" , "id" => "430400" , "name" => "衡阳") , 

318 => Array("pinyin" => "shaoyang" , "id" => "430500" , "name" => "邵阳") , 

319 => Array("pinyin" => "chenzhou" , "id" => "431000" , "name" => "郴州") , 

320 => Array("pinyin" => "yongzhou" , "id" => "431100" , "name" => "永州") , 

321 => Array("pinyin" => "huaihua" , "id" => "431200" , "name" => "怀化") , 

322 => Array("pinyin" => "guangzhou" , "id" => "440100" , "name" => "广州") , 

323 => Array("pinyin" => "shaoguan" , "id" => "440200" , "name" => "韶关") , 

324 => Array("pinyin" => "shenzhen" , "id" => "440300" , "name" => "深圳") , 

325 => Array("pinyin" => "zhuhai" , "id" => "440400" , "name" => "珠海") , 

326 => Array("pinyin" => "shantou" , "id" => "440500" , "name" => "汕头") , 

327 => Array("pinyin" => "zhanjiang" , "id" => "440800" , "name" => "湛江") , 

328 => Array("pinyin" => "nanning" , "id" => "450100" , "name" => "南宁") , 

329 => Array("pinyin" => "liuzhou" , "id" => "450200" , "name" => "柳州") , 

330 => Array("pinyin" => "haikou" , "id" => "460100" , "name" => "海口") , 

331 => Array("pinyin" => "chengdu" , "id" => "510100" , "name" => "成都") , 

332 => Array("pinyin" => "leshan" , "id" => "511100" , "name" => "乐山") , 

333 => Array("pinyin" => "ganzi" , "id" => "513300" , "name" => "甘孜") , 

334 => Array("pinyin" => "guiyang" , "id" => "520100" , "name" => "贵阳") , 

335 => Array("pinyin" => "kunming" , "id" => "530100" , "name" => "昆明") , 

336 => Array("pinyin" => "lasa" , "id" => "540100" , "name" => "拉萨") , 

337 => Array("pinyin" => "xian" , "id" => "610100" , "name" => "西安") , 

338 => Array("pinyin" => "lanzhou" , "id" => "620100" , "name" => "兰州") , 

339 => Array("pinyin" => "xining" , "id" => "630100" , "name" => "西宁") , 

340 => Array("pinyin" => "yinchuan" , "id" => "640100" , "name" => "银川") , 

341 => Array("pinyin" => "urumqi" , "id" => "650100" , "name" => "乌鲁木齐") , 

342 => Array("pinyin" => "yancheng" , "id" => "320900" , "name" => "盐城") , 

343 => Array("pinyin" => "beijing" , "id" => "110000" , "name" => "北京") , 

344 => Array("pinyin" => "tianjin" , "id" => "120000" , "name" => "天津") , 

345 => Array("pinyin" => "chongqing" , "id" => "500000" , "name" => "重庆") , 

346 => Array("pinyin" => "shanghai" , "id" => "310000" , "name" => "上海"))

?>