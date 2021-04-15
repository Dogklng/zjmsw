// JavaScript Document
/*****个人中心*****/
$(document).ready(function(){
	
	$('.order1_yh_con1>ul li').click(function(){

  var or=$(this).index();
  $('.order1_yh_con1 ul li').removeClass('order1_yhon');
  $(this).addClass('order1_yhon');
  
  $('.order1_yh_list').stop(true,true).fadeOut(0);	
  $('.order1_yh_list').eq(or).stop(true,true).fadeIn(300);	
	
})



$('.order1_yh_list1>ul>li>input').click(function(){
	$('.order1_yh_list1>ul>li>input').removeClass('j_checkbox_on');
  	$(this).addClass('j_checkbox_on');
    $('.order1_yh_list1 .user8_con2').slideUp();
	})

$('.j_checkbox_xz').click(function(){
  $('.order1_yh_list1 .user8_con2').slideDown();
  })  



$('.j_checkbox').click(function(){
     $(this).toggleClass('j_checkbox_on')
     })




	
    
  $(window).resize(function(){

	  })
  
  
  $('.user_r5>h5>a').click(function(){
	  $('.dizhi').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_con').addClass('dizhi_con_on');
		  },300)
	  })
  
  $('.user_r2_btn>a').click(function(){
	  $('.dizhi').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_con').addClass('dizhi_con_on');
		  },300)
	  })
  
  $('.order_shon2>span').click(function(){
	  $('.dizhi').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_con').addClass('dizhi_con_on');
		  },300)
	  })
   
  $('.order_shone1>a').eq(0).click(function(){
	  $('.order_shond').stop(true).slideDown(300);
	  $('.order_shone1>a').eq(0).stop(true).fadeOut(0);
	  $('.order_shone1>a').eq(1).stop(true).fadeIn(0);
	  }) 
  
  $('.order_shonc li').click(function(){
	  $('.order_shonc li').removeClass('order_shoncon');
	  $(this).addClass('order_shoncon');
	  })	  
  
  $('.order_shonc li a').click(function(){
	  $('.dizhi').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_con').addClass('dizhi_con_on');
		  },300)
	  })
  	  
  $('.order_shone1>a').eq(1).click(function(){
	  $('.dizhi').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_con').addClass('dizhi_con_on');
		  },300)
	  })	  
  	  
  
  $('.dizhi_bj').click(function(){
	  $('.dizhi').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_con').addClass('dizhi_con_on');
		  },300)
	  })
  	  
  $('.dizhi_btn1>a').click(function(){
	  $('.dizhi').stop(true).fadeOut(1000);
	  $('.dizhi_con').removeClass('dizhi_con_on');
	  })
  
  $('.dizhi_con>img').click(function(){
	  $('.dizhi').stop(true).fadeOut(1000);
	  $('.dizhi_con').removeClass('dizhi_con_on');
	  })
  
  
  $('.order_shon2>a').click(function(){
	  $('.dizhi_change').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_change_con').addClass('dizhi_change_con_on');
		  },300)
	  })
  
  $('.dizhi_change_btn1>a').click(function(){
	  $('.dizhi_change').stop(true).fadeOut(1000);
	  $('.dizhi_change_con').removeClass('dizhi_change_con_on');
	  })
  
  $('.dizhi_change_con>img').click(function(){
	  $('.dizhi_change').stop(true).fadeOut(1000);
	  $('.dizhi_change_con').removeClass('dizhi_change_con_on');
	  })
  	  	
  
  $('.dizhi_change_lista>a').click(function(){
	  $('.dizhi_change').stop(true).fadeOut(1000);
	  $('.dizhi_change_con').removeClass('dizhi_change_con_on');
	  
	  setTimeout(function(){
		  
		  $('.dizhi').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.dizhi_con').addClass('dizhi_con_on');
		  },300)
		  
		  },600)
	  
	  })
  
  
  $('.frist_log').click(function(){
	  $('.bd_show').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.bd_cona').addClass('bd_con_on');
		  },300)
	  })
  
  $('.login_other p').click(function(){
	  $('.bd_show').stop(true).fadeIn(1000);
	  setTimeout(function(){
		  $('.bd_conb').addClass('bd_con_on');
		  },300)
	  })
  
  $('.bd_conb_close').click(function(){
	  $('.bd_show').stop(true).fadeOut(1000);
		  $('.bd_conb').removeClass('bd_con_on');
	  })
  
  
  $('.xgmm>input').click(function(){
	  if($('.xgmm_con').css("display")=="none"){
		  $('.xgmm_con').stop(true).slideDown(300);
		  }else{
			  $('.xgmm_con').stop(true).slideUp(300);
			  }
	  })	       	  
  
  $('.dizhi_change_list').click(function(){
	  $('.dizhi_change_list').removeClass('dizhi_change_list_on');
	  $(this).addClass('dizhi_change_list_on');
	  })
  
  
  $('.soucang').click(function(){
	  $(this).toggleClass('soucang_on');
	  })	
  
   $('.j_checkbox').click(function(){
	   $(this).toggleClass('j_checkbox_on')
	   })	 
   
   $('.user_r4_btn a').click(function(){
	   $('.user_r4_cons').stop(true).slideDown(600);
	   })	    
   
   $('.user_r4 .user8_con2>a').click(function(){
	   $('.user_r4_cons').stop(true).slideUp(600);
	   }) 	   
	    
   $('.order_shona').click(function(){
	   $('.order_shona').removeClass('pro_xz');
	   $(this).addClass('pro_xz');
	   })
   		

})


 $(document).ready(function(){
  
   var show = false
	 $(".ddgd").click(function(){
		 //$(".more_gs").slideToggle();
		 if(show==false){
			 $(".more_text").slideDown();
		 	$(".ddgd").text("点击收回")
			
			 show=true;
			 }else{
				  $(".more_text").slideUp();
				  $(".ddgd").text("查看更多+")
				  show=false;
				
				 }
        })
	$(".ddgd").click(
		 function(event){event.stopPropagation();}
		)
	

})

/*****个人中心*****/




