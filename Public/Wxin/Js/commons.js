var isHandheld =  /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
var mobilePlatform = isMobile();
var isMobile = viewport().width < 740 || isMobile();
var sliding = false;
var supportsOrientationChange = "onorientationchange" in window, orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
var gallery_open = false;
var formDatepicker = false;
var arrivalDatepicker; 
var departureDatepicker;
var hideDatepickerArrival;
var hideDatepickerDeparture;
var arrivalDate = new Date();
var departureDate = new Date();
departureDate.setTime(departureDate.getTime() + 2 * 86400000 );

$(document).ready(function(){
	if(!isMobile){
		$('head').append('<meta name="viewport" content="width=1280">')
	}
	
	
	head_start();
	window[current+'_ready']();
	
	
	$('#menu_controller').bind('click',manage_menu);
	$('#menu_buttons > ul li').bind('mouseenter',menu_hover).bind('mouseleave',menu_out);
	
	if($('#main_slider .slides_wrap .slide').length > 0){
		$('#frame .forward').bind('click', function(){home_slider_next('#main_slider')})
		$('#frame .backward').bind('click', function(){home_slider_prev('#main_slider')})

	}
	
	
	$(window).scroll(function(){
		_pageY = window.pageYOffset;
		global_scroll();
		window[current+'_scroll']();
	
	});
	
	if($('.specials').length != 0 && !isMobile){
		$('.specials .slider_controls .forward').bind(_click,special_forward);
		$('.specials .slider_controls .backward').bind(_click,special_backward);
		$('.specials .special_viewport').bind(_mousedown,start_specials_drag);
	}
	
	resize_elements();
	
	full_slider_setup();
	
	
	
});

$(window).load(function(){
	/*$('.main_section').each(function(i){
		$sections_offset.push($('.main_section:eq('+i+')').offset().top);
		if( $('.main_section:eq('+i+')').hasClass('matt')){
			$sections_matt.push(true);
		} else {
			$sections_matt.push(false);
		}
		
	})*/;
	
	
	
	window[current+'_load']();
})


var _window_height;
var _window_width;
var $sections_offset = [];
var $sections_matt = [];
var arrow_forward_to;
var arrow_backward_to;
var arrows_visible = false;
var header_title_visible = false;
var header_text_visible = false;
var frame_filled = false;
var _header;
var _pageY = 0;
var $frameLastHeight;

/******** ELEMENTS *********/

var $frame = $('#frame');
var $slides_wrap = document.getElementById('general_slide');
var to_frame_no_transition;
var to_frame_no_op;

function resize_elements (){
	
	if(!isHandheld){
		full_slider_setup()
	} else {

		}
		
	_window_height = $(window).height();
	_window_width = $(window).width();
	
	if(current != "contacts" && current != "specials"){
		_header = _window_height;
	} else {
		_header = $('#header').height();
	}
	
	if(isMobile){
		_header = 0;
	}
	
	window[current+'_resize']();
	
	if(gallery_open){
		resize_gallery();
	};
	
	if(isMobile && $('#footer_left').index() == 0){
		$('#footer_center').prependTo($('#footer_content'));
	} else if(!isMobile && $('#footer_center').index() == 0 ) {
		$('#footer_left').prependTo($('#footer_content'));
	}
	
	
}


	function global_scroll(){
		
		
		
		
		
		
		/*$('.main_section').each(function(i){
	    	if(window.pageYOffset >  $sections_offset[i] && window.pageYOffset < $sections_offset[i] + $('.main_section:eq('+i+')').outerHeight()+parseInt($('.main_section:eq('+i+')').css('margin-bottom')) ){
	    		if( $sections_matt[i]){
	    			if(!$frame.hasClass('filled')){
	    				$frame.addClass('filled');
	    				$('#menu_controller hr:not(.dark)').each(function(i){
	    					setTimeout(function(){$('#menu_controller hr:not(.dark):eq('+i+')').css('transform','translate3d(30px,0,0)')},(50*i));
	    				})
	    				$('#menu_controller hr.dark').each(function(i){
	    					setTimeout(function(){$('#menu_controller hr.dark:eq('+i+')').css('transform','translate3d(0px,0,0)')},(50*i));
	    				})
	    			}
	    		} else {
	    			if($frame.hasClass('filled')){
	    				$frame.removeClass('filled');
	    				$('#menu_controller hr:not(.dark)').each(function(i){
	    					setTimeout(function(){$('#menu_controller hr:not(.dark):eq('+i+')').css('transform','translate3d(0,0,0)')},(50*i));
	    				})
	    				$('#menu_controller hr.dark').each(function(i){
	    					setTimeout(function(){$('#menu_controller hr.dark:eq('+i+')').css('transform','translate3d(-30px,0,0)')},(50*i));
	    				})
	    				
	    			}
	    		}
	    	}
	    })*/
	    
	    if(current != "index" && current != "specials" && current != "contacts"){
	    	if(_pageY>60 && !header_title_visible){
	    		header_title_visible = true;
	    		$('#header + .main_section .block_title').removeClass('top_double');
	    		
	    	}
	    	
	    	if(_pageY>120 && !header_text_visible){
	    		header_text_visible = true;
	    		$('#header + .main_section .block_title h2').removeClass('top_double');
	    		setTimeout(function(){$('#header + .main_section .block_title p').removeClass('top_double');},100);
	    	}

	    	if(_pageY<60 && header_title_visible){
	    		header_title_visible = false;
	    		header_text_visible = false;
	    		$('#header + .main_section .block_title p').addClass('top_double');
	    		$('#header + .main_section .block_title').addClass('top_double');
	    	}
	    }
	    
	    if(window.pageYOffset <= _header) {
	    	if(frame_filled){
	    		frame_filled = false;
	    		if(isMobile){
					$('#frame').removeClass('mobile_layout');
				}
				$frame.removeClass('filled');
				$('#menu_controller hr:not(.dark)').each(function(i){
					setTimeout(function(){$('#menu_controller hr:not(.dark):eq('+i+')').css('transform','translate3d(0px,0,0)')},(50*i));
				})
				$('#menu_controller hr.dark').each(function(i){
					setTimeout(function(){$('#menu_controller hr.dark:eq('+i+')').css('transform','translate3d(-30px,0,0)')},(50*i));
				})
			}
	    	
	    	if(current != "specials" && current != "contacts"){
	    		$slides_wrap.style[Modernizr.prefixed('transform')] = 'translate3d(0,'+window.pageYOffset/4+'px, 0)';
	    	}
	    }
	    
	    if(window.pageYOffset > _header && !frame_filled ) {
	    	$frame.addClass('filled');
	    	frame_filled = true;
	    	if(isMobile){
				$('#frame').addClass('mobile_layout');
			}
			$('#menu_controller hr:not(.dark)').each(function(i){
				setTimeout(function(){$('#menu_controller hr:not(.dark):eq('+i+')').css('transform','translate3d(30px,0,0)')},(50*i));
			})
			$('#menu_controller hr.dark').each(function(i){
				setTimeout(function(){$('#menu_controller hr.dark:eq('+i+')').css('transform','translate3d(0px,0,0)')},(50*i));
			})
	    }
	}

$(window).resize(function(){
	resize_elements();
})



function head_start(){
	$('#main_slider .slide._1 img').imagesLoaded(function(){
		
		if(window.location.href.indexOf('section') != -1){
			section = window.location.href.slice(window.location.href.indexOf('=')+1);
			$(window).scrollTop($('#'+section).offset().top);
		}
		
		start_slider('#main_slider');
		
		$('#main_slider .veil').removeClass('no_opacity');
		
		setTimeout(function(){
			$('.logo img').removeClass('top_single');
		},1000);
		setTimeout(function(){
			$('.logo h1').removeClass('top_single');
		},1100);
		setTimeout(function(){
			$('.logo h2').removeClass('top_single');
		},1200);
		
		setTimeout(function(){
			$('#frame .top').removeClass('no_width');
			$('#frame .right').removeClass('no_height');
			$('#frame .bottom').removeClass('no_width');
			$('#frame .left').removeClass('no_height');
		},600);
		
		setTimeout(function(){
			$('#book_now').removeClass('top_single');
			if(isMobile){
				$('#frame .borders .top').addClass('has_transition_300');
			}
		},1450);
		setTimeout(function(){
			$('#menu_controller .menu_text').removeClass('top_single');
		},1600)
		
			
			setTimeout(function(){if($('#main_slider .slides_wrap .slide').length > 1 && window.pageYOffset == 0){$('#frame .backward').removeClass('hidden_by_scaling')}},2000);
			setTimeout(function(){if($('#main_slider .slides_wrap .slide').length > 1 && window.pageYOffset == 0){$('#frame .forward').removeClass('hidden_by_scaling')}},2100);
		
		
		setTimeout(function(){$('.scroll_down').removeClass('top_single')},2300);
		
		
		$('#menu_controller hr:not(.dark)').each(function(i){
			setTimeout(function(){$('#menu_controller hr:not(.dark):eq('+i+')').css('transform','translate3d(0px,0,0)')},1550+(50*i));
		});
		
		
		// DATEPICKER //
		
		arrivalDatepicker = $('.dates.arrival').glDatePicker(
				{
					cssName: 'flatwhite',
					zIndex: 1000,
				    borderSize: 0,
				    monthNames : getMonthNames(),
				    dowNames : getDowNames(),
				    dowOffset: getDowOffset(),
				    selectableDateRange: [{ from: new Date(), to:new Date(3000,1,1)}],
				    selectedDate: arrivalDate,
				    onShow: function(calendar){
				    	arrivalDatepicker.render();
				    	clearTimeout(hideDatepickerArrival);
				    	calendar.find('div').addClass('top_double').addClass('has_transition_600');
				    	calendar.show();
				    	calendar.find('div').each(function(c){
				    		setTimeout(function(){
				    			calendar.find('div:eq('+c+')').removeClass('top_double')
				    		},5*c);
				    	})
				    	
				    },
				    onHide:function(calendar){
				    	hideDatepickerArrival = setTimeout(function(){
				    	calendar.addClass('has_transition_300').addClass('no_opacity')
				    	setTimeout(function(){calendar.hide();},300)
				    	},1);
				    },
				    onClick: function(el, cell, date, data) {
				    	var dd = date.getDate();
				    	var mm = date.getMonth()+1;
				    	var yyyy = date.getFullYear();
				    	
				    	if(dd<10) {
				    	    dd='0'+dd
				    	}
				    	
				    	if(mm<10) {
				    	    mm='0'+mm
				    	} 
				    	
				    	arrivalDate = date;
				    	selected = dd+'/'+mm+'/'+yyyy;
				    	el.children('input').val(selected);
				    },
				    calendarOffset: { x: 0, y: 10 },
				}
			).glDatePicker(true);
			departureDatepicker = $('.dates.departure').glDatePicker(
				{
					cssName: 'flatwhite',
					zIndex: 1000,
				    borderSize: 0,
				    monthNames : getMonthNames(),
				    dowNames : getDowNames(),
				    dowOffset: getDowOffset(),

				    selectableDateRange: [{ from: new Date(), to:new Date(3000,1,1)}],
				    selectedDate:departureDate,

				    onShow: function(calendar){
				    	clearTimeout(hideDatepickerDeparture);
				    	departureDatepicker.render();
				    	calendar.find('div').addClass('top_double').addClass('has_transition_600')
				    	calendar.show();
				    	calendar.find('div').each(function(c){
				    		setTimeout(function(){
				    			calendar.find('div:eq('+c+')').removeClass('top_double')
				    		},5*c);
				    	})
				    	
				    },
				    onHide:function(calendar){
				    	hideDatepickerDeparture = setTimeout(function(){
					    	calendar.addClass('has_transition_300').addClass('no_opacity')
					    	setTimeout(function(){calendar.hide();},300)
					    },1);
				    	
				    },
				    onClick: function(el, cell, date, data) {
				    	var dd = date.getDate();
				    	var mm = date.getMonth()+1;
				    	var yyyy = date.getFullYear();
				    	
				    	if(dd<10) {
				    	    dd='0'+dd
				    	}
				    	
				    	if(mm<10) {
				    	    mm='0'+mm
				    	} 
				    	
				    	departureDate = date;
				    	selected = dd+'/'+mm+'/'+yyyy;
				    	el.children('input').val(selected);
				    },
				    calendarOffset: { x: 0, y: 10 },
				}
			).glDatePicker(true);
		
		function print_adults(n){
			var adults = 'A,'; 
			
			for(a=0;a<n-1;a++){
				adults+='A,'	
			}
			
			adults = adults.substring(0, adults.length - 1);
			
			console.log(adults)
			
			return adults;
		}
			
		$('#book_now a').bind('click',function(e){
			e.preventDefault();
			window.open('https://www.simplebooking.it/ibe/hotelbooking/search?hid=3115&lang='+lang+'#/q&in='+arrivalDate.getFullYear()+'-'+(arrivalDate.getMonth()+1)+'-'+arrivalDate.getDate()+'&out='+departureDate.getFullYear()+'-'+(departureDate.getMonth()+1)+'-'+departureDate.getDate()+'&guests='+print_adults($('#form_guests').val()))
			console.log('https://www.simplebooking.it/ibe/hotelbooking/search?hid=3115&lang='+lang+'#/q&in='+arrivalDate.getFullYear()+'-'+(arrivalDate.getMonth()+1)+'-'+arrivalDate.getDate()+'&out='+departureDate.getFullYear()+'-'+(departureDate.getMonth()+1)+'-'+departureDate.getDate()+'&guests='+print_adults($('#form_guests').val()))

		});
	})
}

function full_slider_setup() {
	    viewport_height = $(window).height();
	    viewport_width = $(window).width();
	    screen_ratio = viewport_width / viewport_height;
	    pic_ratio = 1920 / 1200;

	    $('.slider').height(viewport_height);

	    if (pic_ratio > screen_ratio) {
	        $('.slider .slide > img').css({
	            height: viewport_height,
	            width: Math.round(viewport_height * pic_ratio),
	            marginLeft: Math.round(-(viewport_height * pic_ratio - viewport_width) / 2),
	            marginTop: 0
	        })
	    } else {
	        $(".slider .slide > img").css({
	            width: viewport_width,
	            height: Math.round(viewport_width / pic_ratio),
	            marginTop: Math.round(-(viewport_width / pic_ratio - viewport_height) / 2),
	            marginLeft: 0
	        })
	    }
	};
	
var clearPay;
var clearSlide;

function start_slider(slider){
	changing = true;
	
	
		if( $(slider+' .slide').length == 1){
			$(slider+' .slide._1').addClass('active').addClass('easing');
			first_run = false;
			setTimeout(show_pay,1500)
		} else if(first_run){
			$(slider+' .slide._1').addClass('active').addClass('first');
			first_run = false;
			if(slider == "#main_slider"){
			setTimeout(show_pay,1500);
			}
		} else {
			
			$(slider+' .slide.active').addClass('in');
			if(slider == "#main_slider"){
			setTimeout(show_pay,1200);
			}
		}
		
		setTimeout(function(){
			$(slider+' .slide.active').siblings().removeClass('in').removeClass('first')
			changing = false;
		},1500)
		
		
		$(slider+' .slide.active').on('animationend webkitAnimationEnd oAnimationEnd', function() {
	        $(this).removeClass('in');
	        $(this).removeClass('first');
	        $(this).removeClass('easing');
	    });

		if($(slider+' .slide').length != 1){
			if(slider == "#main_slider"){
				clearPay = setTimeout(function(){remove_pay()},6200);
			}
			
			clearSlide = setTimeout(function(){
				if($(slider+' .slide.active').index() == $(slider+' .slide').length){
					$(slider+' .slide.active').removeClass('active');
					$(slider+' .slide._1').addClass('active');
					if(slider == "#main_slider"){
						$('#pays .pay.active').removeClass('active');
						$('#pays .pay._1').addClass('active');
					}
				} else { 
					$(slider+' .slide.active').removeClass('active').next().addClass('active');
					if(slider == "#main_slider"){
						$('#pays .pay.active').removeClass('active').next().addClass('active');
					}
				}
				start_slider(slider);
			},7000);
		} 
	
		
}



function show_pay(index){
	
	setTimeout(function(){
		$('.pay.active p.top_pay').removeClass('top_single');
	},100);
	setTimeout(function(){
		$('.pay.active .pay_separator').removeClass('top_single');
	},200);
	setTimeout(function(){
		$('.pay.active p.subpay').removeClass('top_single');
	},300);
}
function remove_pay(index){
	setTimeout(function(){
		$('.pay p.top_pay').addClass('top_single');
	},300);
	setTimeout(function(){
		$('.pay .pay_separator').addClass('top_single');
	},200);
	setTimeout(function(){
		$('.pay p.subpay').addClass('top_single');
	},100);
}

var changing = false;

function home_slider_next(slider){
	if(!changing){
		changing = true;
		clearTimeout(clearPay);
		clearTimeout(clearSlide);
		remove_pay();
		
		if($(slider+' .slide.active').index('.slide') == $(slider+' .slide').length-1){
			$(slider+' .slide.active').removeClass('active');
			$(slider+' .slide._1').addClass('active');
			if(slider == "#main_slider"){
				$('#pays .pay.active').removeClass('active');
				$('#pays .pay._1').addClass('active');
			}
		} else { 
			$(slider+' .slide.active').removeClass('active').next().addClass('active');
			if(slider == "#main_slider"){
				$('#pays .pay.active').removeClass('active').next().addClass('active');
			}
		}
		start_slider(slider);
		
	}
}

function home_slider_prev(slider){
	if(!changing){
		changing = true;
		clearTimeout(clearPay);
		clearTimeout(clearSlide);
		remove_pay();
		
		if($(slider+' .slide.active').index('.slide') == 0){
			$(slider+' .slide.active').removeClass('active');
			$(slider+' .slide:last-child').addClass('active');
			if(slider == "#main_slider"){
				$('#pays .pay.active').removeClass('active');
				$('#pays .pay:last-child').addClass('active');
			}
		} else { 
			$(slider+' .slide.active').removeClass('active').prev('.slide').addClass('active');
			if(slider == "#main_slider"){
				$('#pays .pay.active').removeClass('active').prev().addClass('active');
			}
		}
		start_slider(slider);
		
	}
}


function manage_menu(){
	if(!$('#main_menu').hasClass('opened')){
		
		open_menu();
	} else {
		close_menu();
	}
}

function open_menu(){
	if(isMobile){
		_header = -1;
		$(window).trigger('scroll');
	}
	$('#main_menu').removeClass('no_events');
	setTimeout(function(){
		$('#main_menu').addClass('opened').removeClass('hidden');
		$('#menu_controller').addClass('opened');
	},1);
	$('#menu_buttons ul li').each(function(i){
		setTimeout(function(){$('#menu_buttons ul li:eq('+i+') a').removeClass('hidden');},250+(50*i));
	});
	
	setTimeout(function(){$('.menu_pic:first-child').removeClass('no_width');},600);
}

function close_menu(){
	if(isMobile){
		_header = 0;
		$(window).trigger('scroll');
		
	}
	$('#menu_buttons ul li').each(function(i){
		setTimeout(function(){$('#menu_buttons ul li:eq('+i+') a').addClass('hidden');},(10*i));
	});
	$('#main_menu').removeClass('opened').addClass('hidden').addClass('no_events');
	$('#menu_controller').removeClass('opened');


	
}


var depth_index = 2;
var reset_depth;
var reaction_timeout;

function menu_hover() {
	clearTimeout(reset_depth);
	clearTimeout(reaction_timeout);
	$(this).addClass('hover');
	$this = $(this);
	reaction_timeout = setTimeout(function(){
	$('.menu_pic').removeClass('menu_pic_in');
	$('.menu_pic:eq('+$this.index()+')').css('z-index',depth_index++).addClass('menu_pic_in');
	},200);
	reset_depth = setTimeout(function(){
		$('.menu_pic').css('z-index',0);
		$('.menu_pic.menu_pic_in').css('z-index',1);
		depth_index = 2;
	},800);
	
}

function menu_out() {
	
	$(this).removeClass('hover');
	
	
	
}

var $space_threshold = 200;

function show_specials (){
	$('.special_box .special').removeClass('no_transition');
	$('.special_box .special > img').removeClass('no_transition');
	$('.special_box .special h2').removeClass('no_transition');
	$('.special_box .special .side_separator').removeClass('no_transition');
	$('.special_box .special .pointer').removeClass('no_transition');
	$('.special_box .special p').removeClass('no_transition');
	$('.special_box .special table').removeClass('no_transition');
	$('.special_box .special_container.active .special').each(function(i){
		setTimeout(function(){$('.special_box .special_container.active .special:eq('+i+')').removeClass('hidden');},100*i);
		setTimeout(function(){$('.special_box .special_container.active .special:eq('+i+') > img').removeClass('hidden');},750+(100*i));
		setTimeout(function(){$('.special_box .special_container.active .special:eq('+i+') h2').removeClass('top_single');},950+(100*i))
		setTimeout(function(){
			$('.special_box .special_container.active .special:eq('+i+') .side_separator').removeClass('no_width');
		},1150);
		setTimeout(function(){
		$('.special_box .special_container.active .special:eq('+i+') .pointer').removeClass('no_opacity')
		},1750);
		setTimeout(function(){$('.special_box .special_container.active .special:eq('+i+') p').removeClass('top_double')},1150+(100*i))
		setTimeout(function(){$('.special_box .special_container.active .special:eq('+i+') table').removeClass('no_opacity')},1350+(100*i))

	})
	
	setTimeout(function(){
		$(window).trigger('resize')
	},1200);
}

function hide_specials (){
	$('.special_box .special').addClass('no_transition').addClass('hidden');
	$('.special_box .special > img').addClass('no_transition').addClass('hidden');
	$('.special_box .special h2').addClass('no_transition').addClass('top_single');
	$('.special_box .special .side_separator').addClass('no_transition').addClass('no_width');
	$('.special_box .special .pointer').addClass('no_transition').addClass('no_opacity');
	$('.special_box .special p').addClass('no_transition').addClass('top_double');
	$('.special_box .special table').addClass('no_transition').addClass('no_opacity');
}

var special_sliding = false;

function special_forward(){
	if($('.special_container.active').index('.special_container') < $('.special_container').length-1 && !special_sliding){
		special_sliding = true;
		$('.special_container.active').css('transform','translate3d('+(-$('.special_container').width())+'px, 0,0)');
		$('.special_container.active').next().addClass('no_transition').css('transform','translate3d(120px,0,0)')
		setTimeout(function(){
			$('.special_container.active').removeClass('active').hide().next().addClass('active').show();
			$('.special_container').removeClass('no_transition');
			setTimeout(function(){
				$('.special_container.active').css('transform','translate3d(0,0,0)')
				show_specials();
				if($('.special_container.active').index('.special_container') == $('.special_container').length-1){
					$('.specials .forward').addClass('hidden_by_scaling');
				}
				$('.specials .backward').removeClass('hidden_by_scaling');

			},15);
		},510);
		setTimeout(function(){
			special_sliding = false;
		},1600)
	}
}

function special_backward(){
	if($('.special_container.active').index('.special_container') > 0 && !special_sliding){
		special_sliding = true;
		$('.special_container.active').css('transform','translate3d('+$('.special_container').width()+'px, 0,0)');
		$('.special_container.active').prev().addClass('no_transition').css('transform','translate3d(-120px,0,0)')
		setTimeout(function(){
			hide_specials();
			$('.special_container.active').removeClass('active').hide().prev().addClass('active').show();
			$('.special_container').removeClass('no_transition');
			setTimeout(function(){
				$('.special_container.active').css('transform','translate3d(0,0,0)')
				show_specials();
				if($('.special_container.active').index('.special_container') == 0){
					$('.specials .backward').addClass('hidden_by_scaling');
				}
				$('.specials .forward').removeClass('hidden_by_scaling');


			},15);
		},510);
		setTimeout(function(){
			special_sliding = false;
		},1600);
	}
	
}

function start_specials_drag(e) {
	
	if(!special_sliding){
	    $('.special_container.active').addClass('no_transition');
	    $(window).bind(_mouseup, stop_specials_drag);
	    mouse_deltaX = 0;
	    $(".specials").bind(_mousemove, move_specials);
	    mouse_initialX = __pageX(e);
	    
	    sections_initial_position = 0;
	}
}

function stop_specials_drag(e) {
    $(window).unbind(_mouseup);
    $('.special_container.active').removeClass('no_transition');
    $(".specials").unbind(_mousemove);
    $(".specials").stop();
    if (mouse_deltaX > treshold_specials && directionX == "left") {
        if ($('.special_container.active').next('.special_container').length != 0) {
            $(".specials .forward").trigger(_click);
        } else {
        	 $('.special_container.active').css("transform","translate3d(0, 0, 0)");


        }
    }
    if (mouse_deltaX > treshold_specials && directionX == "right") {
        if ($('.special_container.active').prev('.special_container').length != 0) {
        	  $(".specials .backward").trigger(_click);
        } else {
        	 $('.special_container.active').css("transform","translate3d(0, 0, 0)");
        }
    } else if (mouse_deltaX < treshold_specials) {
    	 $('.special_container.active').css("transform","translate3d(0, 0, 0)");



    }

}

function move_specials(e) {
    if (__pageX(e) > mouse_initialX) {
        mouse_deltaX = __pageX(e) - mouse_initialX;
        directionX = "right";
    } else if (__pageX(e) < mouse_initialX) {
        directionX = "left";
        mouse_deltaX = mouse_initialX - __pageX(e)

    }
    if (directionX == "right") {
        sections_current_position = sections_initial_position + mouse_deltaX
    } else {
        sections_current_position = sections_initial_position - mouse_deltaX
    }
    
    $('.special_container.active')[0].style[Modernizr.prefixed('transform')] = "translate3d("+sections_current_position/2 + "px, 0, 0)";


    
}



//SLIDING VARS //


var mouse_initialX;
var mouse_deltaX;
var directionX;
var sections_initial_position;
var page_bind = false;
var treshold_gallery = 200;
var treshold_specials = 200;
var $url;


var _mousemove;
var _click;
var _mouseenter;
var _mouseleve;
var _mousedown;
var _mouseup;

if (Modernizr.touchevents) {
	
    _mousemove = "touchmove";
    _click = "touchend";
    _mousedown = "touchstart";
    _mouseup = "touchend";
    _mouseenter = "mouseenter";
    _mouseleave = "mouseleave"
} else {
    _mousemove = "mousemove";
    _click = "click";
    _mousedown = "mousedown";
    _mouseup = "mouseup";
    _mouseenter = "mouseenter";
    _mouseleave = "mouseleave"
}

function __pageX(e) {
    if (Modernizr.touchevents) {
        return e.originalEvent.touches[0].pageX
    } else {
        return e.pageX
    }
}

function __pageY(e) {
    if (Modernizr.touchevents) {
        return e.originalEvent.touches[0].pageY
    } else {
        return e.pageY
    }
}


// dates //



var mesi = new Array();
   mesi[0] = "Gennaio";
   mesi[1] = "Febbraio";
   mesi[2] = "Marzo";
   mesi[3] = "Aprile";
   mesi[4] = "Maggio";
   mesi[5] = "Giugno";
   mesi[6] = "Luglio";
   mesi[7] = "Agosto";
   mesi[8] = "Settembre";
   mesi[9] = "Ottobre";
   mesi[10] = "Novembre";
   mesi[11] = "Dicembre";
   
   
   
var month = new Array();
   month[0] = "January";
   month[1] = "February";
   month[2] = "March";
   month[3] = "April";
   month[4] = "May";
   month[5] = "June";
   month[6] = "July";
   month[7] = "August";
   month[8] = "September";
   month[9] = "October";
   month[10] = "November";
   month[11] = "December";
   
   var mois = new Array();
   mois[0] = "Janvier";
   mois[1] = "Février";
   mois[2] = "Mars";
   mois[3] = "Avril";
   mois[4] = "Mai";
   mois[5] = "Juin";
   mois[6] = "Juillet";
   mois[7] = "Août";
   mois[8] = "Septembre";
   mois[9] = "Octobre";
   mois[10] = "Novembre";
   mois[11] = "Décembre";
   
   var monate = new Array();
   monate[0] = "Januar";
   monate[1] = "Februar";
   monate[2] = "März";
   monate[3] = "April";
   monate[4] = "Mai";
   monate[5] = "Juni";
   monate[6] = "Juli";
   monate[7] = "August";
   monate[8] = "September";
   monate[9] = "Oktober";
   monate[10] = "November";
   monate[11] = "Dezember";
   
var giorni = new Array();
  giorni[1] = "Lun";
  giorni[2] = "Mar";
  giorni[3] = "Mer";
  giorni[4] = "Gio";
  giorni[5] = "Ven";
  giorni[6] = "Sab";
  giorni[0] = "Dom";
  
  
  var jours = new Array();
  jours[0] = "Lun";
  jours[1] = "Mar";
  jours[2] = "Mer";
  jours[3] = "Jeu";
  jours[4] = "Ven";
  jours[5] = "Sam";
  jours[6] = "Dim";
  
  var tage = new Array();
  tage[0] = "Mo";
  tage[1] = "Di";
  tage[2] = "Mi";
  tage[3] = "Do";
  tage[4] = "Fr";
  tage[5] = "Sa";
  tage[6] = "So";


   function getMonthNames(){
   	if(lang=="it"){
   		return mesi;
   	} else 	if(lang=="fr"){
   		return mois;
   	}	if(lang=="de"){
   		return monate;
   	} else {
   		return month
   	}
   }
   
   

   function getDowNames(){
   	if(lang=="it"){
   		return giorni;
   	} else 	if(lang=="fr"){
   		return jours;
   	} else 	if(lang=="de"){
   		return tage;
   	} else {
   		return null
   	}
   }
   
   function getDowOffset(){
	 	if(lang=="it"){
	   		return 1;
	   	} else 	if(lang=="fr"){
	   		return 1;
	   	} else 	if(lang=="de"){
	   		return 1;
	   	} else {
	   		return 0
	   	}
   }

   function matrixToArray(str) {
	   return str.match(/(-?[0-9\.]+)/g);
	 }

