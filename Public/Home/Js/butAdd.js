$(function(){
	
	//ZQJ检测 是否登录，是否选择大赛期数，是否上传头像，
	$('.zggA').click(function(){
		var nid = $('#nid').val();
		$.ajax({
			url:'/Home/News/buttonRelease',
			type:'post',
			data:{},
			dataType:'json',
			success:function(g){
				if(g.status == 1){
					//dialog.showTips(g.info, "warn", function(){ window.location.href = g.url;});
					 window.location.href = g.url;
					return false;
				}else{
					if(g.url != undefined){
						
						dialog.showTips(g.info, "warn", function () { window.location.href = g.url;});
						return false;

					}else{
						alert(g.info);
						return false;
					}
				}
				
			}
			
		})
	})
})