//$('#body1').append(' <script id="aaa" src="js/vendor/vendor.js"> <\/script>').append(' <script id="bbb" src="js/main.js"> <\/script>');
	
//		 $(' <script id="aaa" src="js/vendor/vendor.js"> <\/script>').remove();
//		 console.log($(' <script id="aaa" src="js/vendor/vendor.js"> <\/script>'));
//	$('#body1').children().eq(12).remove()
//	$('#body1').children().eq(12).remove()	
//		$('#capture').remove();
		

		
		var flag = true;
		$(window).scroll(function(){
			
	var top = $(this).scrollTop()
	
	if(top < 818){
		if(top>360){
		$('.two_column p').eq(0).stop(true).delay(300).animate({ "margin-left": "0", 'opacity': 1 }, 1200);
		$('.two_column p').eq(1).stop(true).delay(600).animate({ "margin-left": "0", 'opacity': 1 }, 1200);
		$('.column1 p').eq(0).stop(true).delay(300).animate({ "margin-left": "5%", 'opacity': 1 }, 1200);
		$('.column1 p').eq(1).stop(true).delay(600).animate({ "margin-left": "5%", 'opacity': 1 }, 1200);
		
	};
		if($('#capture')==true){
			return false
		}
	if(flag){
		$('#body1').append(' <script id="aaa" src="js/vendor/vendor.js"> <\/script>').append(' <script id="bbb" src="js/main.js"> <\/script>');
	$('#canvasbox').append('<canvas id="capture" style="display:none;"></canvas>')
	flag=false;
	
	}else{
		return false
	}
	
		
	}else{
	
		$('#body1').children().eq(12).remove()
	$('#body1').children().eq(12).remove()	
		$('#capture').remove();
	flag = true
	
	 if(top>1100){
  	$('.newsList1').delay(300).animate({ 'opacity': 1 }, 1200);

  };
  if(top>3180){

	$('.p1').addClass('bounceInRight');
	$('.p2').addClass('bounceInRight');
	$('.p3').addClass('bounceInRight');

}
   if(top>4675){
	
	$('.newsList2').delay(300).animate({ 'opacity': 1 }, 1200);

}
	
	

		
	};

});
