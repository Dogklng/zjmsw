// JavaScript Document
/*手机导航*/


$(document).ready(function(){
	$( '.head_nav ul li' ).hover( function()
{

	$( this ).find( '.erjinav1' ).stop( true ).animate( { "height": "220px", "opacity": "1" }, 500 );
	$( this ).find( '.sanjiao' ).stop( true ).animate( { "opacity": "1" }, 500 );
}, function()
{
	$( this ).find( '.erjinav1' ).stop( true ).animate( { "height": "0px", "opacity": "0" }, 200 );
	$( this ).find( '.sanjiao' ).stop( true ).animate( { "opacity": "0" }, 500 );
} )

})


/***手机导航 ***/
$(document).ready(function(){	
	//menu菜单
	$(".menuTitle i").click(function(){
		$(".menuBody ul").css({"display":"none"});
		$(".menuBody .ul1").css({"display":"block"});
		if($(".menuTitle span").text()=="0519-85068877"){
			$("html").stop(true).animate({"left":"0"});
			$(".menuBox").animate({"left":"-265px"})
			$("html").css({"overflow":"auto","position":"relative"});
			show=0;
		}else{
			$(".menuTitle span").text("0519-68889126");
		}
	})
	
	var show=0;
	$(".top-left").click(function(){
		$('.menuBox_close').stop(true).fadeIn();
		if(show==0){
			$("html").stop(true).animate({"left":"0"});
			$(".menuBox").animate({"left":"0"})
			$("html").css({"overflow":"hidden","position":"fixed"});
			show=1;
			return;
		}else if(show==1){
			$("html").stop(true).animate({"left":"0"});
			$(".menuBox").animate({"left":"-265px"})
			$("html").css({"overflow":"auto","position":"relative"});
			show=0;
			return;
		}
	})
	
	$('.menuBox_close').click(function(){
		$('.menuBox_close').stop(true).fadeOut();
		$("html").stop(true).animate({"left":"0"});
			$(".menuBox").animate({"left":"-265px"})
			$("html").css({"overflow":"auto","position":"relative"});
			show=0;
		})
	
	var length1=$(".menuBody .ul1 li").length;
	var menuTitleText;
	for(i=0;i<length1;i++){
		(function(){
			var ind=i;
			$(".menuBody .ul1 li").eq(i).click(function(){
				
				if($(this).find("ul").hasClass("marked")){
					$(this).find("ul").removeClass("marked").slideUp();
					return;
				}
				$(".menuBody").find(".marked").removeClass("marked").slideUp();
				$(this).find("ul").addClass("marked").slideDown();
				
				//menuTitleText=$(this).text();
//				$(this).parent().css({"display":"none"});
//				$(".menuBody .ul2_"+ind).css({"display":"block"})
				//$(".menuTitle span").text(menuTitleText);
			})
		})()
	}
	
})



