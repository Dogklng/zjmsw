
//		 $(' <script id="aaa" src="js/vendor/vendor.js"> <\/script>').remove();
//		 console.log($(' <script id="aaa" src="js/vendor/vendor.js"> <\/script>'));
//	$('#body1').children().eq(12).remove()
//	$('#body1').children().eq(12).remove()	
//		$('#capture').remove();

var flag = true;
$(window).scroll(function () {
	var fsttop = $('.js-footer').offset().top;
	var sectop = $('.title').offset().top;	
	var tritop = $('.top3').offset().top;
	var fortop = $('.Grid-description').offset().top;
	var fiftop = $('.footbefore_wrap_content').offset().top;
console.log(sectop-fsttop/2)
	var top = $(this).scrollTop()

	if (top < fsttop) {
		if (top > sectop-fsttop/2) {
			$('.two_column p').eq(0).stop(true).delay(300).animate({
				"margin-left": "0",
				'opacity': 1
			}, 1200);
			$('.two_column p').eq(1).stop(true).delay(600).animate({
				"margin-left": "0",
				'opacity': 1
			}, 1200);
			$('.column1 p').eq(0).stop(true).delay(300).animate({
				"margin-left": "5%",
				'opacity': 1
			}, 1200);
			$('.column1 p').eq(1).stop(true).delay(600).animate({
				"margin-left": "5%",
				'opacity': 1
			}, 1200);

		};
		if (flag == true) {
			return false
		}
		if (!flag) {
			console.log(222)
			$("canvas").css('display','block')
			flag = true;

		} else {
			return false
		}


	} else {
		if (flag) {
			$("canvas").css('display','none')
//			$('#body1').children().eq(12).remove()
//			$('#body1').children().eq(12).remove()
			$('#capture').remove();
			flag = false
		}
		if (top > tritop) {
			$('.newsList1').delay(300).animate({
				'opacity': 1
			}, 1200);

		};
		
		if (top > fortop) {

			$('.p1').addClass('bounceInRight');
			$('.p2').addClass('bounceInRight');
			$('.p3').addClass('bounceInRight');

		}
		if (top > fiftop) {

			$('.newsList2').delay(300).animate({
				'opacity': 1
			}, 1200);

		}




	};

});
