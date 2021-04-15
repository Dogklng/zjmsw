// 洽购功能
function toQiaGou(gid)
{
	var qiagou_price = jQuery('#qiagou_price').val().replace(/[^0-9.]/g, '');

	if (! /^[0-9.]+$/.test(qiagou_price))
	{
		alert('请输入合法的洽购金额。');
	}
	else
	{
		$.post(
			'ywapply.php',
			'act=qiagou&gid=' + gid + '&qiagou_price=' + qiagou_price,
			function(response)
			{
				result = $.evalJSON(response);
				if (result.error == 2)
				{
					alert(result.message);
					window.location.href = '/login';
				}
				else
				{
					alert(result.message);
				}
				
			},
			'JSON'
		);
	}
}

/**
* 检查订单完成状态
* 
* @param	log_id		int		支付ID
*/
function start_check_order(log_id)
{
	log_id = log_id || 0;

	if (log_id == 0)
	{
		return false;
	}

	setTimeout(check_pay_order, 3000);

	function check_pay_order()
	{
		$.post(
			'ywapply.php',
			'act=check_pay_order&log_id=' + log_id,
			function(response)
			{
				result = $.evalJSON(response);
				if (result.error == 0)
				{
					 $.fn.colorbox({
							scrolling:false,
							html:'<br><h3>' + result.message + '</h3><br>',
							onComplete:function()
							{
							},
							onCleanup:function()
							{
								location.href = './';
							}
					});
				}
				else
				{
					setTimeout(check_pay_order, 3000);
				}
			},
			'JSON'
		);
	}
}

//jQuery(function(){
//	start_check_order(9021);
//});


(function( $ )
	{          
    var target = null;
    var template = null;
    var lock = false;
    var variables = {
        'last'      :    0
	}

    var settings = {
        'amount'      :   '10',          
        'address'     :   'top.php',
        'format'      :   'json',
        'template'    :   '.single_item',
        'trigger'     :   '.wrap-more',
        'scroll'      :   'false',
        'offset'      :   '100',
        'spinner_code':   ''
    }

    var methods = {
        init  :   function(options)
		{
            return this.each(function(){
              
                if(options){
                    $.extend(settings, options);
                }
                template = $(this).children(settings.template).wrap('<div/>').parent();
                template.css('display','none')
                $(this).append('<div class="more_loader_spinner">'+settings.spinner_code+'</div>')
                $(this).children(settings.template).remove()   
                target = $(this);
                if(settings.scroll == 'false'){                    
                    $(this).find(settings.trigger).bind('click.more',methods.get_data);
                    $(this).more('get_data');
                }                
                else{
                    if($(this).height() <= $(this).attr('scrollHeight')){
                        target.more('get_data',settings.amount*2);
                    }
                    $(this).bind('scroll.more',methods.check_scroll);
                }
            })
        },
        check_scroll : function(){
            if((target.scrollTop()+target.height()+parseInt(settings.offset)) >= target.attr('scrollHeight') && lock == false){
                target.more('get_data');
            }
        },
        debug :   function(){
            var debug_string = '';
            $.each(variables, function(k,v){
                debug_string += k+' : '+v+'\n';
            })
            alert(debug_string);
        },     
        remove        : function(){            
            target.children(settings.trigger).unbind('.more');
            target.unbind('.more')
            target.children(settings.trigger).remove();
        },
        add_elements  : function(data){
            //alert('adding elements')
            
            var root = target       
         //   alert(root.attr('id'))
            var counter = 0;
            if(data){
                $(data).each(function(){
                    counter++
                    var t = template                    
                    $.each(this, function(key, value){                          
                        if(t.find('.'+key)) t.find('.'+key).html(value);
                    })         
                    //t.attr('id', 'more_element_'+ (variables.last++))
                    if(settings.scroll == 'true'){
                    //    root.append(t.html())
                    root.children('.more_loader_spinner').before(t.html())  
                    }else{
                    //    alert('...')
                          
                          root.children(settings.trigger).before(t.html())  

                    }

                    root.children(settings.template+':last').attr('id', 'more_element_'+ ((variables.last++)+1))
                })
            }
            else  methods.remove()
            target.children('.more_loader_spinner').css('display','none');
            if(counter < settings.amount) methods.remove()            

        },
        get_data      : function(){   
           // alert('getting data')
            var ile;
            lock = true;
            target.children(".more_loader_spinner").css('display','block');
            $(settings.trigger).css('display','none');
            if(typeof(arguments[0]) == 'number') ile=arguments[0];
            else {
                ile = settings.amount;              
            }
            
            $.post(settings.address, {
                last : variables.last, 
                amount : ile                
            }, function(data){            
                $(settings.trigger).css('display','block')
                methods.add_elements(data)
                lock = false;
            }, settings.format)
            
        }
    };
    $.fn.more = function(method){
        if(methods[method]) 
            return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
        else if(typeof method == 'object' || !method) 
            return methods.init.apply(this, arguments);
        else $.error('Method ' + method +' does not exist!');

    }    
})(jQuery)