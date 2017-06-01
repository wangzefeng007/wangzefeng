var weather=function(){
	var tmp=0;
	var SWther={w:[{}],add:{}};
	var SWther={};
	if(charset !== "gb2312") {
	this.getWeather=function(city,type){
		jq.getScript("http://php.weather.sina.com.cn/iframe/index/w_cl.php?code=js&day=2&city="+city+"&dfc=3",function(){if(type=='js'){echo(city);}})
	;}
        }
	if(charset == "utf-8") {
	this.getWeather=function(city,type){
		jq.getScript("http://php.weather.sina.com.cn/iframe/index/w_cl.php?code=js&day=2&city="+city+"&dfc=3&charset=utf-8",function(){if(type=='js'){echo(city);}})
	;}
        }
			
function dis_img(weather){
    var style_img="sunshine";
	if(weather.indexOf("晴")!==-1){style_img="sunshine";}
	else if(weather.indexOf("阴")!==-1){style_img="overcast";}
	else if(weather.indexOf("小雪")!==-1){style_img="lightsnow";}
	else if(weather.indexOf("中雪")!==-1){style_img="heavysnow";}
	else if(weather.indexOf("大雪")!==-1){style_img="heavysnow";}
	else if(weather.indexOf("暴雪")!==-1){style_img="heavysnow";}
	else if(weather.indexOf("雷阵雨")!==-1){style_img="thundershower";}
	else if(weather.indexOf("阵雨")!==-1){style_img="moderaterain";}
	else if(weather.indexOf("小雨")!==-1){style_img="sprinkle";}
	else if(weather.indexOf("中雨")!==-1){style_img="moderaterain";}
	else if(weather.indexOf("大雨")!==-1){style_img="moderaterain";}
	else if(weather.indexOf("暴雨")!==-1){style_img="moderaterain";}
	else if(weather.indexOf("雨")!==-1){style_img="moderaterain";}
	else if(weather.indexOf("雾")!==-1){style_img="mist";}
	else if(weather.indexOf("多云")!==-1){style_img="cloudy";}
	else if(weather.indexOf("冰雹")!==-1){style_img="hailstone";}
	else if(weather.indexOf("扬沙")!==-1){style_img="sandstorm";}
	else if(weather.indexOf("沙尘")!==-1){style_img="sandstorm";}
	else{style_img="overcast";}
    return style_img;};
	
function echo(city){
	jq('#city').html(city);
	jq('#weather').html(window.SWther.w[city][0].s1);
	jq('#temperature').html(window.SWther.w[city][0].t1+'&deg;');
	jq('#wind').html(window.SWther.w[city][0].p1);
	jq('#direction').html(window.SWther.w[city][0].d1);
	jq('#T_weather').html(window.SWther.w[city][0].s1);
	
	var T_weather_img=dis_img(window.SWther.w[city][0].s1);
	jq('#T_weather_img').html("<div id='"+T_weather_img+"' class='Horizontalscroll sky'><div class='dw'><div class='child-0'></div></div></div>");
	jq('#T_temperature').html(window.SWther.w[city][0].t1+'~'+window.SWther.w[city][0].t2+'&deg;');
	jq('#T_wind').html(window.SWther.w[city][0].p1);
	jq('#T_direction').html(window.SWther.w[city][0].d1);
	jq('#M_weather').html(window.SWther.w[city][1].s1);
	
	var M_weather_img=dis_img(window.SWther.w[city][1].s1);
	jq('#M_weather_img').html("<div id='"+M_weather_img+"' class='Horizontalscroll sky'><div class='dw'><div class='child-0'></div></div></div>");
	jq('#M_temperature').html(window.SWther.w[city][1].t1+'~'+window.SWther.w[city][1].t2+'&deg;');
	jq('#M_wind').html(window.SWther.w[city][1].p1);
	jq('#M_direction').html(window.SWther.w[city][1].d1);
	jq('#L_weather').html(window.SWther.w[city][2].s1);
	
	var L_weather_img=dis_img(window.SWther.w[city][2].s1);
	jq('#L_weather_img').html("<div id='"+L_weather_img+"' class='Horizontalscroll sky'><div class='dw'><div class='child-0'></div></div></div>");
	jq('#L_temperature').html(window.SWther.w[city][2].t1+'~'+window.SWther.w[city][2].t2+'&deg;');
	jq('#L_wind').html(window.SWther.w[city][2].p1);jq('#L_direction').html(window.SWther.w[city][2].d1);
	}
	}
	function jintian(){
		weather_.getWeather(city,'js');
		};