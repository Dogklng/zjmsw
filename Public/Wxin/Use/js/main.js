// JavaScript Document
// 判断是否为移动端
if (!navigator.userAgent.match(/mobile/i)) {
  
  console.log($(document).scrollTop)
  if($(document).scrollTop()<30){
      console.log()
       $('.footer').css({"position":"fixed","bottom":"0px"})
    }


}


window.onload = function(){
	// console.log(document.body.clientWidth)

	
	if(document.body.clientWidth<768){
		//$('#index').append('<div class="p_headzc" style=""><div class=""><a class="p_topdl" href="p_login.html">注册</a><a class="p_topdl" href="p_login2.html" style="border-left:1px solid #333;">登录</a></div></div>');
	}
	
}

function clickjump(datainfo){

  console.log($(window).height())
  var win_height = $(window).height()-50-$('.footer').height();
  $('.p_pages').height(win_height)

  console.log(datainfo)
  $('#p_personinfo').children().hide();
  
  switch(datainfo){

    case 'touxiang':$('.p_pages.touxiang').show();break;
    case 'yonghuming':$('.p_pages.yonghuming').show();break;
    case 'name':$('.p_pages.name').show();break;
    case 'nicheng':$('.p_pages.nicheng').show();break;
    case 'gender':$('.p_pages.gender').show();break;
    case 'phonenum':$('.p_pages.phonenum').show();break;
    case 'birthday':$('.p_pages.birthday').show();break;
    case 'emails':$('.p_pages.emails').show();break;
    case 'linkways':$('.p_pages.linkways').show();break;
  }
}
function backuser(){
  $('.p_pages').hide();
  $('#p_personinfo').children().show();
}

// toways2 绑定手机跳转第二步
function toways2(){
  $('.phonenum .ways1').hide();
   $('.phonenum .ways2').show()
}


$(window).ready(function(){
	 // user 头部
	 // js代码
	$('.index-logo').click(function(){
	    console.log('1')
	    location.href="../index.html";
	  })
	 	
	// if(){
	// 	var isMobile = viewport().width < 740 || isMobile();
	// }







	 // --------------------------------------------
	 //order
	 /*****个人中心*****/
	 $(document).ready(function(){
	     
	   $(window).resize(function(){

	 	  })
	   
	   
	   $('.user_r5>h5>a').click(function(){
	 	  // $('.dizhi').stop(true).fadeIn(1000);
	 	  $('.dizhi').animate({"opacity":"1"},300)
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
	   	  // console.log('dizhi')
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
	 
	 
	 
	 $(".sousuo").click(function(){
		$(".sousuok").slideToggle(300);
	})
	
	 /*****个人中心*****/



	var height1 = $(window).height()-100;
$(".dw_top").delay(100).animate({"width":"100%"},1000,function(){
	$(".dw_right").animate({"height":height1},1000,function(){
		$(".dw_bottom").animate({"width":"100%"},1000,function(){
			$(".dw_left").animate({"height":height1},1000)
			})
		})
	})
	
	
	$(".dldd").click(function(){
		$(".form_fixed1").animate({"left":"0"},500);
	})
	
	$(".close1").click(function(){
		$(".form_fixed1").animate({"left":"-100%"},500);
	})
	
	$(".dldd2").click(function(){
		$(".form_fixed2").animate({"left":"-100%"},500,(function(){
		$(".form_fixed1").animate({"left":"0"},500);
		}))
		
	})
	
	$(".zcdd2").click(function(){
		$(".form_fixed1").animate({"left":"-100%"},500,function(){
		$(".form_fixed2").delay(100).animate({"left":"0"},500);
		})
	})
	
	$(".zcdd").click(function(){
		$(".form_fixed2").animate({"left":"0"},500);
	})
	$(".close2").click(function(){
		$(".form_fixed2").animate({"left":"-100%"},500);
	})
	
	
	
	$(".close3").click(function(){
		$(".form_fixed3").animate({"left":"-100%"},500);
	})

	$(".wjmm").click(function(){
		$(".form_fixed1").animate({"left":"-100%"},500,function(){
		$(".form_fixed3").delay(100).animate({"left":"0"},500);
		})
	})
	
	
	

})

















