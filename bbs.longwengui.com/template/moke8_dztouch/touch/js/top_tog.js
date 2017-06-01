 var toplist = document.getElementById("toplist");
 var toplistwrap = document.getElementById("toplistwrap");
 var more = document.getElementById('more');
more.onclick=function(){
	if(toplist.style.display!='none')
	{
		toplist.slideUp(10,115);
		toplistwrap.slideUp(10,140); 
	}
	else
	{
		toplist.slideDown(10,115);
		toplistwrap.slideDown(10,140); 
		more.className += ' moreclick';
	}
}
document.getElementById('slideup').onclick = function() 
{
	toplist.slideUp(10,115);
	toplistwrap.slideUp(10,140); 
}

window.HTMLElement.prototype.slideDown=function(speed,height)
{
	var o = this;
	clearInterval(o.slideFun);
	var h = height;
	var i = 0;
	o.style.height = '0px';	
	o.style.display = 'block';
	o.style.overflow = 'hidden';
	o.slideFun = setInterval(function(){
		
		i = i + 30;
		if(i>h) i=h;
		o.style.height = i+'px';
		if(i>=h)
		{
			o.style.removeProperty('overflow');
			clearInterval(o.slideFun);
		}	
	},speed);
}

window.HTMLElement.prototype.slideUp=function(speed,height)
{
	var o = this;
	clearInterval(o.slideFun);
	var h = height;
	var i = h;
	o.style.overflow = 'hidden';
	o.slideFun = setInterval(function(){
		i -= 30;
		if(i<0) i=0;
		o.style.height = i+'px';
		if(i<=0)
		{
			o.style.display = 'none';
			o.style.removeProperty('overflow');
			more.className = more.className.replace(' moreclick','');
			clearInterval(o.slideFun);
		}	
	
	},speed);
}

function hideGoTop(){
	var top = document.body.scrollTop;
	if (top > 250) {
		$('#gotop').show();
	} else {
		$('#gotop').hide();
	}
}

window.onscroll=hideGoTop;

$('#gotop').click(function(){
	document.body.scrollTop=0;
});