




$(document).ready(function(e) {
	
	
	 $(".sousuo").click(function(){
		$(".sousuok").slideToggle(300);
	})
	
	$('.order1_yh_con1>ul li').click(function(){

  var or=$(this).index();
  $('.order1_yh_con1 ul li').removeClass('order1_yhon');
  $(this).addClass('order1_yhon');
  
  $('.order1_yh_list').stop(true,true).fadeOut(0);	
  $('.order1_yh_list').eq(or).stop(true,true).fadeIn(300);	
	});
	
	
	
	 $('.j_checkbox').click(function(){
	   $(this).toggleClass('j_checkbox_on')
	   })
	
	
	/*******banner**********/

 // 
//  $('.banner').height($(window).width()*300/600);
//  $('.products_inner_ban').height($(window).width()*500/750);
//  
//  $(window).resize(function(){
//      $('.banner').height($(window).width()*300/600);
//	  $('.products_inner_ban').height($(window).width()*500/750);
//	  })
//   
// 
//
//
//var mySwiper = new Swiper('.swiper-container',{
//    pagination: '.pagination',
//    loop:true,
//	autoplay:4000,
//	speed: 500,
//	autoplayDisableOnInteraction : false,
//    grabCursor: true,
//    paginationClickable: true
//  })

/*******banner**********/
	

	$(".backTop").click(function(e) {
        $('body,html').animate({ scrollTop: 0 }, 300);
    });
	
	
	 $('.products_inner_jf1').click(function(){
	   $('.pro_show_bg').stop(true,true).fadeIn(300);
	   $('.show_jf').stop(true,true).animate({bottom:"0"},500);
	   $('body').addClass('body_on');
	   })	
   
   $('.products_inner_jf2').click(function(){
	   $('.pro_show_bg').stop(true,true).fadeIn(300);
	   $('.show_jifen').stop(true,true).animate({bottom:"0"},500);
	   $('body').addClass('body_on');
	   })
   
   $('.products_inner_fw>p').click(function(){
	   $('.pro_show_bg').stop(true,true).fadeIn(300);
	   $('.show_fw').stop(true,true).animate({bottom:"0"},500);
	   $('body').addClass('body_on');
	   })
    
	$('.pro_innera2').click(function(){
		$('.pro_show_bg').stop(true,true).fadeIn(300);
	   $('.show_xz').stop(true,true).animate({bottom:"0"},500);
	   $('body').addClass('body_on');
		})
	
	$('.products_inner_zi2').click(function(){
	   $('.pro_show_bg').stop(true,true).fadeIn(300);
	   $('.show_xz').stop(true,true).animate({bottom:"0"},500);
	   $('body').addClass('body_on');
	   })	   
   
    $('.pro_inner_cs1 h5').click(function(){
	   $('.pro_show_bg').stop(true,true).fadeIn(300);
	   $('.show_cs1').stop(true,true).animate({bottom:"0"},500);
	   $('body').addClass('body_on');
	   }) 	   
   	   
   	     
   $('.pro_show_bg').click(function(){
	   $('.pro_show_bg').stop(true,true).fadeOut(300);
	   $('.show_div').stop(true,true).animate({bottom:"-425px"},500);
	   $('body').removeClass('body_on');
	   })	
	$('.show_div>a').click(function(){
	   $('.pro_show_bg').stop(true,true).fadeOut(300);
	   $('.show_div').stop(true,true).animate({bottom:"-425px"},500);
	   $('body').removeClass('body_on');
	   })  
    
	
	$('.show_xzb p span').click(function(){
		$(this).parent().find('span').removeClass('show_xzb_on');
		$(this).addClass('show_xzb_on');
		})
	

	
	
	
	

function GetRTime(){    
	var EndTime= new Date('2017/11/26 23:00:00');    
	var NowTime = new Date();    
	var t =EndTime.getTime() - NowTime.getTime();    
	var d=0;    
	var h=0;    
	var m=0;    
	var s=0;   
	if(t>=0){      
		//d=Math.floor(t/1000/60/60/24);      
		//h=Math.floor(t/1000/60/60%24); 
		h=Math.floor(t/1000/60/60);      
		m=Math.floor(t/1000/60%60);      
		s=Math.floor(t/1000%60);    
	}      
	//document.getElementById("t_d").innerHTML = d + "天";    
	//document.getElementById("t_h").innerHTML = h<10? "0"+h : h;    
	$("span.count1").text(  m<10? "0"+m : m  )    
	$("span.count2").text( s<10? "0"+s : s  ) 
}  
setInterval(GetRTime,100);




});






function alertMsg(){
	$(".share_box").fadeIn(200);
}