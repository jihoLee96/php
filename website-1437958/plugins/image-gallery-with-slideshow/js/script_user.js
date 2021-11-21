var $j=jQuery.noConflict();
var theInt = null;
var $crosslink, $navthumb;
var curclicked = 0;		
theInterval = function(cur){
	clearInterval(theInt);			
	if( typeof cur != 'undefined' )
		curclicked = cur;			
	$crosslink.removeClass("active-thumb");
	$navthumb.eq(curclicked).parent().addClass("active-thumb");
		$j(".stripNav ul li a").eq(curclicked).trigger('click');			
	theInt = setInterval(function(){
		$crosslink.removeClass("active-thumb");
		$navthumb.eq(curclicked).parent().addClass("active-thumb");
		$j(".stripNav ul li a").eq(curclicked).trigger('click');
		curclicked++;
		if( 6 == curclicked )
			curclicked = 0;				
	}, 3000);
};
		
$j(function(){
	$j("#main-photo-slider").codaSlider();
	$navthumb = $j(".nav-thumb");
	$crosslink = $j(".cross-link");
	$navthumb
	.click(function() {
		var $this = $j(this);
		theInterval($this.parent().attr('href').slice(1) - 1);
		return false;
	});
	theInterval();
});