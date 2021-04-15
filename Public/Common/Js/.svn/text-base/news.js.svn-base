
$(function() {

	/******************* news one image upload ***************************/
	
	//--异步单张图片上传
	var progress = $('.xuanze_percent');
	
	$("#xuanze").wrap("<form id='form1' action='/Admin/Index/addImage' method='post' enctype='multipart/form-data'></form>");	
	$("#xuanze").change(function() {   //选择文件
		$("#form1").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {   //开始上传
				progress.show();       //显示进度条
				var percentVal = '0%';
				progress.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%'; //获得进度
				progress.html(percentVal); 				//显示上传进度百分比
			},
			success: function(res) {
				var img = '<img src="'+res[0]["savepath"].substr(1)+res[0]["savename"]+'" height="80" ><input type="hidden" name="imgs" value="'+res[0]["savepath"].substr(1)+res[0]["savename"]+'"></input>';
				$('.xuanze_showimge').html(img);
				progress.hide();
			},
			error:function(xhr){
				//console.log(xhr.status)
			}
		});
	});
	
	//品牌--广告--小图点击上传
	$("#xuanze_btn").wrap("<form id='form_btn' action='/Admin/Index/addImage' method='post' enctype='multipart/form-data'></form>");	
	$("#xuanze_btn").change(function() {   //选择文件
		$("#form_btn").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {   //开始上传
				progress.show();       //显示进度条
				var percentVal = '0%';
				progress.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%'; //获得进度
				progress.html(percentVal); 				//显示上传进度百分比
			},
			success: function(res) {
				var img = '<img src="'+res[0]["savepath"].substr(1)+res[0]["savename"]+'" height="80" ><input type="hidden" name="btn_img" value="'+res[0]["savepath"].substr(1)+res[0]["savename"]+'"></input>';
				$('.xuanze_showimge_btn_img').html(img);
				progress.hide();
			},
			error:function(xhr){
				//console.log(xhr.status)
			}
		});
	});
	
	//视频路径上传
	$("#videos").wrap("<form id='Myvideos' action='/Admin/Index/addImage' method='post' enctype='multipart/form-data'></form>");	
	$("#videos").change(function() {   //选择文件
		$("#Myvideos").ajaxSubmit({
			dataType:  'json',
			beforeSend: function() {   //开始上传
				progress.show();       //显示进度条
				var percentVal = '0%';
				progress.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%'; //获得进度
				progress.html(percentVal); 				//显示上传进度百分比
			},
			success: function(res) {
				var video_url = '<input type="text" style="border:none;" name="video_url" value="'+res[0]["savepath"].substr(1)+res[0]["savename"]+'"></input>';
				$('.show_videos').html(video_url);
				progress.hide();
			},
			error:function(xhr){
				//console.log(xhr.status)
			}
		});
	});
	
	
	/********************* brands multiple imge upload ************************/
	
	//品牌简介层--异步多张图片上传
	var percent  = $('.multiple_percent');
	var progress = $('.multiple_percent');
	
	$("#multiple").wrap("<form id='myupload' action='/Admin/Index/addImage' method='post' enctype='multipart/form-data'></form>");
	$("#multiple").change(function() {   //选择文件
		$("#myupload").ajaxSubmit({
			dataType:  'json', 			 //数据格式为json
			beforeSend: function() { 	 //开始上传
				progress.show();		 //显示进度条
				var percentVal = '0%';
				percent.html(percentVal);
			},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%'; //获得进度
				percent.html(percentVal); 				//显示上传进度百分比
			},
			success: function(data) { 				    //成功
				var img = '<img src="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'" height="80"  class="mgr10 mgt10 " onclick="delImg(this)"><input type="hidden" name="imgs"  value="'+data[0]["savepath"].substr(1)+data[0]["savename"]+'"></input>';
				$('.multiple_showimge').append(img);
				progress.hide();
			},
			error:function(xhr){
				console.log(xhr.status);
			}
		});
	});
	
	//删除多张图片中的其中某张图片
	function delImg(obj) {
	    if(!confirm("删除这张图片？")){
	      return false;
	    }
	    var id = $(obj).attr("data-id")
	    if(id){
	      alert(1);
	      return false;
	    }
	    $(obj).next("input").remove();
	    $(obj).remove();
	  }
	
	
	//模糊查询
	$("#buutons").click(function() {
		var input = $(".input").val();
		$.get(urls['index_url'], {title : input}, function(res){
			//console.log(res);
		}, 'json');
	});
	
});

