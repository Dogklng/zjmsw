// JavaScript Document


$(document).ready(function(){
	/*var h = $(window).height();
	 $(".swiper-container01").css("height",h*0.6);
	 $(".swiper-wrapper01").css("height",h*0.6);
	 $(".swiper-slide01").css("height",h*0.6);*/





	$(window).resize(function (){
		var sheight = $(window).height();
		$('.DB_bgSet li').css("height",sheight-91)
		$(".DB_tab25").css("height",sheight-91);
	})

})




$(".map-item ").hover(
	function(){
		$(this).siblings().find(".sub").stop().fadeOut(200);
		$(this).find(".sub").fadeIn(200);
	},function(){
		$(this).find(".sub").stop().fadeOut(200);
	})












/*****产品详情*****/
$(document).ready(function(){

	$('.pro_phfl').width($('.pro_hd1').width());


	$('.pro_xximg').width($('.pro_xx').width()-123)
	$('.pro_inner_con_kj').height(($('.pro_inner_con_kj').width()-123)*680/750);
	$('.pro_xximg').height($('.pro_xximg').width()*680/750);

	$(window).resize(function(){
		$('.pro_xximg').width($('.pro_xx').width()-123)
		$('.pro_inner_con_kj').height(($('.pro_inner_con_kj').width()-123)*680/750);
		$('.pro_xximg').height($('.pro_xximg').width()*680/750)
	})


	var n=0;


	$('.pro_xximg>li').removeClass('pro_xximg_z');
	$('.pro_xximg>li').eq(0).addClass('pro_xximg_z');
	$('.pro_xximg>li').eq(0).addClass('pro_xximg_show');
	$('.pro_xx_s>li').removeClass('pro_xx_son')
	$('.pro_xx_s>li').eq(0).addClass('pro_xx_son')

	setTimeout(function(){
		$('.pro_xximg>li').removeClass('pro_xximg_show');
		$('.pro_xximg>li').eq(0).addClass('pro_xximg_show');
	},300)


	$('.pro_xx_s>li').click(function(){
		var pro_num=$(this).index();
		$('.pro_xximg>li').removeClass('pro_xximg_z');
		$('.pro_xximg>li').eq(pro_num).addClass('pro_xximg_z');
		$('.pro_xximg>li').eq(pro_num).addClass('pro_xximg_show');
		$('.pro_xx_s>li').removeClass('pro_xx_son')
		$(this).addClass('pro_xx_son')

		setTimeout(function(){
			$('.pro_xximg>li').removeClass('pro_xximg_show');
			$('.pro_xximg>li').eq(pro_num).addClass('pro_xximg_show');
		},300)

	})



	$('.pro_xx_s>li').hover(function(){
		$(this).find('.line_t').stop(true).animate({width:"100%"},300)
		$(this).find('.line_r').stop(true).animate({height:"100%"},300)
		$(this).find('.line_b').stop(true).animate({width:"100%"},300)
		$(this).find('.line_l').stop(true).animate({height:"100%"},300)
	},function(){
		$(this).find('.line_t').stop(true).animate({width:"0"},300)
		$(this).find('.line_r').stop(true).animate({height:"0"},300)
		$(this).find('.line_b').stop(true).animate({width:"0"},300)
		$(this).find('.line_l').stop(true).animate({height:"0"},300)
	})

	$('.pro_xx_s>li').outerWidth($('.pro_xx_s_box').width());
	var xx=$('.pro_xx_s>li').width();
	var ss=$('.pro_xx_s>li').size();
	var xxx=xx+13;

	/* $('.pro_xx_s_box').height(xx*4+57); */
	$('.pro_xx_s_box').height($('.pro_xx_s>li').height()*4+57);
	$('.pro_xx_s').height(xx*ss+10)

	$('.pro_xx_next').click(function(){
		if(n>(ss-5)){
			$('.pro_xx_s').stop(true).animate({top:0},300)
			n=0;
		}else{
			$('.pro_xx_s').stop(true).animate({top:-xxx*(n+1)},300)
			n++;
		}
	})

	$('.pro_xx_prev').click(function(){
		if(n<1){
			$('.pro_xx_s').stop(true).animate({top:-(ss-4)*xxx},300)
			n=ss-4;
		}else{
			$('.pro_xx_s').stop(true).animate({top:-xxx*(n-1)},300)
			n--;
		}
	})


	var lh=$('.pro_lh').height();


	$('.pro_boton_t ul li').hover(function(){

		var pin=$(this).index();

		if($('.pro_boton_list').eq(pin).css("display")=="none"){
			$('.pro_boton_t ul li').removeClass('pro_lion');
			$('.pro_boton_t ul li').eq(pin).addClass('pro_lion');
			$('.pro_boton_list').stop(true,true).fadeOut(0);
			$('.pro_boton_list').eq(pin).stop(true,true).fadeIn(300);
			$('.pro_rh').css("min-height",lh);
		}else{

		}

	},function(){

	})

	$('.pro_rot ul li').click(function(){
		$('.pro_boton_t ul li').removeClass('pro_lion');
		$('.pro_boton_t ul li').eq(0).addClass('pro_lion');
		$('.pro_boton_list').stop(true,true).fadeOut(0);
		$('.pro_boton_list').eq(0).stop(true,true).fadeIn(300);
	})



})

/*****产品详情*****/




/*****个人中心*****/
$(document).ready(function(){

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
	});

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
/*****个人中心*****/




$(window).load(function(){

	$('.JS_floor_banner').height($('.JS_floor_banner').width()*449/621);

	$('.floor-left').height($('.floor-right').height());
	$('.floor-left2').height($('.floor-right2').height());

	$('.kong').height($('.user_left').height());

	$(window).resize(function(){

		$('.JS_floor_banner').height($('.JS_floor_banner').width()*449/621);

		$('.floor-left').height($('.floor-right').height());
		$('.floor-left2').height($('.floor-right2').height());

		$('.kong').height($('.user_left').height());

	})


})



$(window).load(function(){

	$('.caigou1_2_list input').width($('.caigou1_2_list').width()-90);
	$('.caigou1_2_list1 textarea').width($('.caigou1_2_list1').width()-90);

	$('.main_rm_l1').height($('.main_rm_l2').height());
	$('.main_rm_r').height($('.main_rm_l').height()-1);

	$('.main_rm_r>ul li').height($('.main_rm_r').height()/5);

	$(window).resize(function(){
		$('.main_rm_l1').height($('.main_rm_l2').height());
		$('.main_rm_r').height($('.main_rm_l').height()-1);
		$('.main_rm_r>ul li').height($('.main_rm_r').height()/5);

		$('.caigou1_2_list input').width($('.caigou1_2_list').width()-90);
		$('.caigou1_2_list1 textarea').width($('.caigou1_2_list1').width()-90);

	})

})


$(document).ready(function(){

	$('.wap_weixin1').find('.wap_weixin_show1').stop(true).fadeIn(0);
	$('.wap_weixin1').find('p').stop(true,true).fadeIn(0);



	$('.back_top').click(function(){
		$("html,body").animate({scrollTop:0}, 1000);
	})

	$('.wap_weixin>span').click(function(){
		$(this).parent().find('.wap_weixin_show').stop(true,true).fadeIn(300);
		$(this).parent().find('p').stop(true,true).fadeIn(300);
	})

	$('.pro_inner_zi4 span').hover(function(){
		$(this).find('.pro_inner_zi4_img').stop(true,true).fadeIn(300);
	},function(){
		$(this).find('.pro_inner_zi4_img').stop(true,true).fadeOut(300);
	})

	$('.wap_weixin_show>a').click(function(){
		$('.wap_weixin').find('.wap_weixin_show').stop(true,true).fadeOut(300);
		$('.wap_weixin').find('p').stop(true,true).fadeOut(300);
	})

	$('.sec3_list').hover(function(){
		$(this).find('.youhuo').stop(true,true).fadeIn(300);
	},function(){
		$(this).find('.youhuo').stop(true,true).fadeOut(300);
	})

	$('.pro_phone').hover(function(){
		$('.pro_phone_show').stop(true,true).fadeIn(300)
	},function(){
		$('.pro_phone_show').stop(true,true).fadeOut(300)
	})

	$('.order1_yh_con1>ul li').click(function(){

		var or=$(this).index();
		$('.order1_yh_con1 ul li').removeClass('order1_yhon');
		$(this).addClass('order1_yhon');



		$(this).parents("ul").siblings(".order1_yh_l").find('.order1_yh_list').fadeOut(0);
		$(this).parents("ul").siblings(".order1_yh_l").find('.order1_yh_list').eq(or).fadeIn(300);

	})


	$('.order1_yh_list1>ul>li>input').click(function(){
		$('.order1_yh_list1>ul>li>input').removeClass('j_checkbox_on');
		$(this).addClass('j_checkbox_on');
		$('.order1_yh_list1 .user8_con2').stop(true).slideUp(300);
	})

	$('.j_checkbox_xz').click(function(){
		$('.order1_yh_list1 .user8_con2').stop(true).slideDown(300);
	})


	$('.order1_yh_con2>ul>li .j_checkbox').click(function(){

		/*$('.order1_yh_con2>ul>li .j_checkbox').removeClass('j_checkbox_on');
		$(this).addClass('j_checkbox_on');*/
        $(this).parents("ul").find(".j_checkbox").removeClass('j_checkbox_on');
        $(this).addClass('j_checkbox_on');

	})

	$('.pro_pht span').hover(function(){
		var pt=$(this).index();

		if($('.pro_ph_con1').eq(pt).css("display")=="none"){
			$('.pro_pht span').removeClass('pro_phton');
			$('.pro_pht span').eq(pt).addClass('pro_phton');

			$('.pro_ph_con1').stop(true,true).fadeOut(0);
			$('.pro_ph_con1').eq(pt).stop(true,true).fadeIn(300);

		}

	},function(){})


	$('.pro_inner_zi2 p span').click(function(){
		$(this).parent().find('span').removeClass('pro_xz');
		$(this).addClass('pro_xz');
	});


	$('.pro_sc h5').click(function(){
		$(this).toggleClass('pro_scon')
	});

	$('.pro_ph_list h5').click(function(){
		$(this).find('i').toggleClass('fa-angle-down');
		$(this).parent().find('ul').stop(true,true).slideToggle(300);
	});



	$('.ktlb').click(function(){
		$(this).toggleClass('ktlb_on');
		$(this).find('ul').stop(true).slideToggle(300);
	});

	$('.btn01').click(function(){
		$('.caigou_two_bz_box').stop(true,true).slideToggle(300);
	});






	$('.fee_pay').click(function(){
        var order_no =  $(this).attr("data-order_no");
        $(".zhifu").attr("data-order_no",order_no);
		$('.wap_tancs1' ).css('display','block');
	});

	$(".ququ" ).click(function(){
		$(".wap_tancs1" ).fadeOut(500);
	});

	$(".zhifu" ).click(function(){
        var order_no =  $(this).attr("data-order_no");
        if($(".order_shona").eq(0).hasClass("pro_xz")){

        } else if($(".order_shona").eq(1).hasClass("pro_xz")){

        } else if($(".order_shona").eq(2).hasClass("pro_xz")){

        } else if($(".order_shona").eq(3).hasClass("pro_xz")){
            $(".bao_qx1").attr("data-order_no",order_no);
			$(".address_bg_dz1" ).fadeIn(500);
			$(".wap_tancs1" ).fadeOut(500);
		}
	});
	$(".fa_qx1,.xubox_setwin" ).click(function(){
		$(".address_bg" ).fadeOut(500);
	});


})









/*******产品评价*******/
$(document).ready(function(){
	var pjDiv;
	var pjPrev;
	var pjNext;
	var pjClose;
	var pjUl;
	var pjLi;
	var pjW;
	var pjS;
	var pjImg1;
	var t=0;
	var i=0;
	var pi=0;

	$('.pingj_t p').click(function(){
		$('.pingj_t p').removeClass('pingj_on');
		$(this).addClass('pingj_on');
		var pj=$(this).index();
		$('.pingj_con>ul').stop(true,true).fadeOut(0);
		$('.pingj_con>ul').eq(pj).stop(true,true).fadeIn(300);
	})

	$('.ping_img img').click(function(){

		pjDiv=$(this).parents('.pingj_con_zi').find('.ping_img_cons');
		pjLi=$(this).parents('.pingj_con_zi').find('.ping_img_cons li');
		pjUl=$(this).parents('.pingj_con_zi').find('.ping_img_cons ul');
		pjPrev=$(this).parents('.pingj_con_zi').find('.ping_img_con_prev');
		pjNext=$(this).parents('.pingj_con_zi').find('.ping_img_con_next');
		pjClose=$(this).parents('.pingj_con_zi').find('.ping_img_con_close');
		pjImg1=$(this).parent().find('img');
		i=$(this).parent().attr('id');
		if(pi==i){
		}else{
			t=0;
		}
		pi=i;


		if($(this).hasClass('ping_on')){
			$('.ping_img_con').removeClass('ping_img_con_on');
			$('.ping_img img').removeClass('ping_on');
		}else{
			var n=$(this).index();
			$('.ping_img_con').removeClass('ping_img_con_on');
			$(this).parents('.pingj_con_zi').find('.ping_img_con').addClass('ping_img_con_on');

			pjS=pjLi.size();
			pjUl.height(pjLi.eq(n).height());

			$('.ping_img img').removeClass('ping_on');
			$(this).addClass('ping_on');
			pjLi.stop(true,true).fadeOut(0);
			pjLi.eq(n).stop(true,true).fadeIn(0);

			pjClose.click(function(){
				$('.ping_img_con').removeClass('ping_img_con_on');
				$('.ping_img img').removeClass('ping_on');
			})

			if(t==0){
				pingjia();
				t=1;
				return;
			}

		}


		function pingjia(){

			pjNext.click(function(){
				pingjia1();
			})

			pjPrev.click(function(){
				pingjia2();
			})
		}

		function pingjia1(){
			if(n>(pjS-2)){
				n=0;
				pjUl.height(pjLi.eq(n).height());
				pjLi.stop(true,true).fadeOut(0);
				pjLi.eq(n).stop(true,true).fadeIn(0);
				$('.ping_img img').removeClass('ping_on');
				pjImg1.eq(n).addClass('ping_on');

			}else{
				n++;
				pjUl.height(pjLi.eq(n).height());
				pjLi.stop(true,true).fadeOut(0);
				pjLi.eq(n).stop(true,true).fadeIn(0);
				$('.ping_img img').removeClass('ping_on');
				pjImg1.eq(n).addClass('ping_on');
			}
		}


		function pingjia2(){
			if(n<1){
				n=pjS-1;
				pjUl.height(pjLi.eq(n).height());
				pjLi.stop(true,true).fadeOut(0);
				pjLi.eq(n).stop(true,true).fadeIn(0);
				$('.ping_img img').removeClass('ping_on');
				pjImg1.eq(n).addClass('ping_on');
			}else{
				n--;
				pjUl.height(pjLi.eq(n).height());
				pjLi.stop(true,true).fadeOut(0);
				pjLi.eq(n).stop(true,true).fadeIn(0);
				$('.ping_img img').removeClass('ping_on');
				pjImg1.eq(n).addClass('ping_on');
			}
		}


	})


})
/*******产品评价*******/





$(window).load(function(){

	var s1,s2,s3,s4,timer1;
	s1=getid("gp1");
	s2=getid("gp2");
	s3=getid("gp3");
	s4=getid("gp_con1");
	s4.style.width=(s2.offsetWidth*2+100)+"px";
	s3.innerHTML=s2.innerHTML;


	function mar1(){

		if(s2.offsetWidth<=s1.scrollLeft){
			s1.scrollLeft-=s2.offsetWidth;

		}else{s1.scrollLeft++;}

	}
	function getid(id){
		return document.getElementById(id);
	}

	function init1(){
		timer1=setInterval(function(){
			mar1()
		},45)
	}
	init1();

	$('#gp1').hover(function(){
		clearInterval(timer1);
	},function(){
		init1();
	})

})


/*******积分商城*******/
$(document).ready(function(){

	var y1=$('.jfdh_con>ul>li').size();
	var x1=$('.jfdh_con>ul>li').height();
	var play=0;
	var x=0;
	var d=0;
	$('.jfdh_con').height(x1*5);

	function gd(){


		function gundong(){
			if(y1>5){
				play=setInterval(function(){
					if(x>x1){
						x=0;
						$('.jfdh_con>ul').find('li:first-child').appendTo($('.jfdh_con>ul'));
						$('.jfdh_con>ul').css({marginTop:0});
						$('.jfdh_con>ul').stop(true,true).animate({marginTop:-x},0,'linear');
					}else{
						$('.jfdh_con>ul').stop(true,true).animate({marginTop:-x},1,'linear');
						x++;
					}
				},40);
			}
		}

		gundong();



		$('.jfdh_con').hover(function(){
			d=0;
			clearInterval(play)
		},function(){
			if(d==0){
				gundong();
				d=1;
				return;
			}
		})



	}


	gd();


})


/*******积分商城*******/











