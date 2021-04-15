

//var h=$(window).height();
//var mh=$('.wrap .bg').height()-h;
//
//$('.wrap .bg').animate({top:-mh},{duration:10000,easing:'easeOutCubic'});
//setTimeout(function(){
//    $('.shine-wrap .shine1 img').animate({left:250,top:-100},{duration:1000,easing:'easeInOutCubic'});
//    $('.shine-wrap .shine2 img').delay(300).animate({left:0,top:-274},{duration:1000,easing:'easeInOutCubic'});
//    $('.shine-wrap .shine3 img').delay(500).animate({left:-400,top:-200},{duration:1000,easing:'easeInOutCubic'});
//},6000)
//$('.line1').delay(3500).animate({left:173,top:-68},{duration:3000,easing:'easeOutCubic'});

//只涉及背景


var h=$(window).height();
var w=$(window).width();
//var mh=$('.wrap .bg').height()-h;

$('.bg').animate({"background-position-x":"-0px", "background-position-y":"-1000px"},{duration:0,easing:'swing',complete:function(){
    $('body').mousemove(function(e){
        var x=e.pageX;
        var y=e.pageY;
        x=2*(x-w/2)/w;
        y=2*(y-h/2)/h;
        $('.bg-1').css({"background-position-x":x*10+'px', "background-position-y":-10000+y*10+'px'});
        $('.bg-2').css({"background-position-x":x*10+'px', "background-position-y":-10000+y*10+'px'});
        $('.bg-3').css({"background-position-x":x*10+'px', "background-position-y":-10000+y*10+'px'});
        $('.shine-wrap .hdimg').css({'marginLeft':x*2,'marginTop':y*2});
		$('.shine-wrap .hdimglist').css({'marginLeft':x*80,'marginTop':y*80});
		$('.shine-wrap .hdimgcon').css({'marginLeft':x*-40,'marginTop':y*-40,});
    })
    
}});
setTimeout(function(){
    $('.shine-wrap .shine1 .hdimg').animate({left:-2,right:-2,bottom:-30,top:-30},{duration:0,easing:'easeInOutCubic'});
	$('.shine-wrap .shine1 .hdimglist').animate({left:-80,right:-80,bottom:-80,top:-80},{duration:0,easing:'easeInOutCubic'});
	$('.shine-wrap .shine1 .hdimgcon').animate({left:-40,right:-40,bottom:-40,top:-40},{duration:0,easing:'easeInOutCubic'});
	$('.dian object').animate({left:"50%",top:"50%"},{duration:0,easing:'easeInOutCubic'});
},0)
