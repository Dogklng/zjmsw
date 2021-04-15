
/* 放大镜 */
    //设置鼠标进入事件
            $('#showmagnifier').mouseover(function(){
                $('#smallmagnifier').css('display','block');
                $('#hiddenmagnifier').css('visibility','visible');
            });
            
            $('#showmagnifier').mouseout(function(){
                $('#smallmagnifier').css('display','none');
                $('#hiddenmagnifier').css('visibility','hidden');
            });
        
            
        
        
            //设置small的移动事件
            $('#showmagnifier').mousemove(function(e){
                //当前鼠标的位置
                var x = e.pageX;
                var y = e.pageY;
                
                //left的偏移量newLeft = x -$('#showmagnifier').offset().Left - $('#smallmagnifier').width()/2;
                var newLeft = x -$('#showmagnifier').offset().left - $('#smallmagnifier').width()/2;
                //console.log(newLeft);
                //left的临界点
                if(newLeft<=0){
                    newLeft = 0;
                }
                if(newLeft>=($('#showmagnifier').width()-$('#smallmagnifier').width())){
                    newLeft = $('#showmagnifier').width()-$('#smallmagnifier').width();
                }
                
                //top侧的偏移var newTop = y - $('#showmagnifier').offset().top - $('#smallmagnifier').height()/2;
                var newTop = y - $('#showmagnifier').offset().top - $('#smallmagnifier').height()/2;
                //top的临界点
                if(newTop<=0){
                    newTop = 0;
                }
                if(newTop>=($('#showmagnifier').height()-$('#smallmagnifier').height())){
                    newTop = $('#showmagnifier').height()-$('#smallmagnifier').height();
                }
                
                
                //赋值
                $('#smallmagnifier').css({left:newLeft,top:newTop});
                
                //bigmagnifier的偏移量
                //$('#smallmagbifier').offset().left/$('showmagnifier').width()=$('bigmagnifier').offset().Left/$('hiddenmagnifier').width();
                var bigLeft = newLeft*$('#bigmagnifier').width()/$('#showmagnifier').width();
                var bigTop = newTop*$('#bigmagnifier').height()/$('#showmagnifier').height();
                //console.log($('#showmagnifier').height())
                //console.log(newLeft);
                
                $('#bigmagnifier').css({left:-bigLeft,top:-bigTop});
            })
            
            //设置元素的单击事件
            $('#magnifierlist>ul>li>img').mouseover(function(){
                //console.log(111); 
                console.log($('#showmagnifier>img'));
                //console.log($('#showmagnifier>img'));
                $('#showmagnifier>img').attr('src',$(this).attr('src'));
                $('#bigmagnifier').attr('src',$(this).attr('src'));
                
            });

            $('#magnifierlist>ul>li>img').mouseover(function(){
                //console.log(111); 
                console.log($('#showmagnifier>img'));
                //console.log($('#showmagnifier>img'));
                $('#showmagnifier>img').attr('src',$(this).attr('src'));
                $('#bigmagnifier').attr('src',$(this).attr('src'));
                
            });

            var i = 0;
            
            $('#magnifierRight').click(function(){ 
                i++;
                if(i>$('#magnifierMiddle li').length-1){
                    i = 0;
                }
                $('#showmagnifier>img').attr('src',$('#magnifierMiddle li').eq(i).children().attr('src'));
                $('#bigmagnifier').attr('src',$('#magnifierMiddle li').eq(i).children().attr('src')); 
              
            });


             $('#magnifierLeft').click(function(){    
                if(i<0){
                    i = $('#magnifierMiddle li').length-1;
                    
                }
                console.log(i);
                i--;

                $('#showmagnifier>img').attr('src',$('#magnifierMiddle li').eq(i).children().attr('src'));
                $('#bigmagnifier').attr('src',$('#magnifierMiddle li').eq(i).children().attr('src')); 
              
            });


