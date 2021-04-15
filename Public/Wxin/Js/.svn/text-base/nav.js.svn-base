
$( document ).ready( function()
{

	$( window ).load( function()
	{

		$(".has_transition_800_inout" ).removeClass("no_width")
		$(".has_transition_800_inout" ).removeClass("no_height")

		setInterval(function(){
			$(".menu_text" ).removeClass("top_single")
			$("#menu_controller ._1c" ).css("transform", "translate3d(0px, 0px, 0px)")
			$("#menu_controller ._2c" ).css("transform", "translate3d(0px, 0px, 0px)")
			$("#menu_controller ._3c" ).css("transform", "translate3d(0px, 0px, 0px)")

		},1000)


		$("#menu_controller" ).click(function(){
			if($(this ).hasClass("opened")){
				$(this ).removeClass("opened")
				$("#main_menu" ).addClass("hidden")
				$("#main_menu" ).addClass("no_events")
				$("#main_menu" ).removeClass("opened")

				$("#menu_buttons > ul li a").addClass("hidden")
			}
			else{
				$(this ).addClass("opened")
				$("#main_menu" ).removeClass("hidden")
				$("#main_menu" ).removeClass("no_events")
				$("#main_menu" ).addClass("opened")

				$("#menu_buttons > ul li a").removeClass("hidden")
			}
		})

		$("#menu_buttons > ul li" ).hover(function(){
			$(this ).addClass("hover" ).siblings("li" ).removeClass("hover")
		},function(){
			$("#menu_buttons > ul li" ).removeClass("hover")
		})



		$( window ).scroll( function()
		{
			
			
			if( $( window ).scrollTop() > ($( ".banner" ).height()-80) )
			{
				
				
				$("#frame").addClass("filled")
				$(".search-con" ).css("border", "1px solid #333")
				$(".search-l").css("color", "#333")
				$(".search-btn").css("color", "#333")
				$(".search-btn").css("background","url('images/button-search1.png') 50% 50% no-repeat")
				$(".dianhua").css("color", "#333")
				$(".dh-img2").css("opacity", "1")
				$(".zhuce a").css("color", "#333")

				$("._1c").css("transform", "translate3d(30px, 0px, 0px)")
				$("._2c").css("transform", "translate3d(30px, 0px, 0px)")
				$("._3c").css("transform", "translate3d(30px, 0px, 0px)")

				$(".dark.has_transition_600").css("transform", "translate3d(0px, 0px, 0px)")
				$(".top").css("opacity","1")
				$(".menu_text").css("color","#333")


			}
			else
			{
				$("#frame").removeClass("filled")
				$(".search-con" ).css("border", "1px solid #fff")
				$(".search-l").css("color", "#fff")
				$(".search-btn").css("color", "#fff")
				$(".search-btn").css("background","url('images/button-search.png') 50% 50% no-repeat")
				$(".dianhua").css("color", "#fff")
				$(".dh-img2").css("opacity", "0")
				$(".zhuce a").css("color", "#fff")

				$("._1c").css("transform", "translate3d(0px, 0px, 0px)")
				$("._2c").css("transform", "translate3d(0px, 0px, 0px)")
				$("._3c").css("transform", "translate3d(0px, 0px, 0px)")

				$(".dark.has_transition_600").css("transform", "translate3d(-30px, 0px, 0px)")
				$(".top").css("opacity","0")
				$(".menu_text").css("color","#fff")
			}

		} );



	} )

} )