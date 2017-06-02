new function (){
    var _self = this;
    var eles,ele;
    eles = document.documentElement;
    ele = document.createElement("style");
    eles.firstElementChild.appendChild(ele);
    _self.width = 750;//设置默认最大宽度
    _self.fontSize = 100;//默认字体大小
    _self.widthProportion = function(){var p = (document.body&&document.body.clientWidth||document.getElementsByTagName("html")[0].offsetWidth)/_self.width;return p>1?1:p<0.426?0.426:p;};
    _self.changePage = function(){
        //document.getElementsByTagName("html")[0].setAttribute("style","font-size:"+_self.widthProportion()*_self.fontSize+"px !important");
        ele.innerHTML="html{font-size:" + _self.widthProportion()*_self.fontSize + "px!important;}";
    }
    _self.changePage();
    window.addEventListener('resize',function(){_self.changePage();},false);
}