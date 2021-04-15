/*
 * jQuery JSON Plugin
 * MIT License: http://www.opensource.org/licenses/mit-license.php
 * copyrighted 2005 by Bob Ippolito.
 */
(function(e){e.toJSON=function(a){if(typeof JSON=="object"&&JSON.stringify)return JSON.stringify(a);var b=typeof a;if(a===null)return"null";if(b!="undefined"){if(b=="number"||b=="boolean")return a+"";if(b=="string")return e.quoteString(a);if(b=="object"){if(typeof a.toJSON=="function")return e.toJSON(a.toJSON());if(a.constructor===Date){var c=a.getUTCMonth()+1;if(c<10)c="0"+c;var d=a.getUTCDate();if(d<10)d="0"+d;b=a.getUTCFullYear();var f=a.getUTCHours();if(f<10)f="0"+f;var g=a.getUTCMinutes();if(g<
10)g="0"+g;var h=a.getUTCSeconds();if(h<10)h="0"+h;a=a.getUTCMilliseconds();if(a<100)a="0"+a;if(a<10)a="0"+a;return'"'+b+"-"+c+"-"+d+"T"+f+":"+g+":"+h+"."+a+'Z"'}if(a.constructor===Array){c=[];for(d=0;d<a.length;d++)c.push(e.toJSON(a[d])||"null");return"["+c.join(",")+"]"}c=[];for(d in a){b=typeof d;if(b=="number")b='"'+d+'"';else if(b=="string")b=e.quoteString(d);else continue;if(typeof a[d]!="function"){f=e.toJSON(a[d]);c.push(b+":"+f)}}return"{"+c.join(", ")+"}"}}};e.evalJSON=function(a){if(typeof JSON==
"object"&&JSON.parse)return JSON.parse(a);return eval("("+a+")")};e.secureEvalJSON=function(a){if(typeof JSON=="object"&&JSON.parse)return JSON.parse(a);var b=a;b=b.replace(/\\["\\\/bfnrtu]/g,"@");b=b.replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]");b=b.replace(/(?:^|:|,)(?:\s*\[)+/g,"");if(/^[\],:{}\s]*$/.test(b))return eval("("+a+")");else throw new SyntaxError("Error parsing JSON, source is not valid.");};e.quoteString=function(a){if(a.match(i))return'"'+a.replace(i,
function(b){var c=j[b];if(typeof c==="string")return c;c=b.charCodeAt();return"\\u00"+Math.floor(c/16).toString(16)+(c%16).toString(16)})+'"';return'"'+a+'"'};var i=/["\\\x00-\x1f\x7f-\x9f]/g,j={"\u0008":"\\b","\t":"\\t","\n":"\\n","\u000c":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"}})(jQuery);
/* Metadata - Dual licensed under the MIT and GPL licenses */
(function(e){e.extend({metadata:{defaults:{type:"class",name:"metadata",cre:/({.*})/,single:"metadata"},setType:function(b,a){this.defaults.type=b;this.defaults.name=a},get:function(b,a){a=e.extend({},this.defaults,a);if(!a.single.length)a.single="metadata";var c=e.data(b,a.single);if(c)return c;c="{}";var h=function(d){if(typeof d!="string")return d;return d=eval("("+d+")")};if(a.type=="html5"){var g={};e(b.attributes).each(function(){var d=this.nodeName;if(d.match(/^data-/))d=d.replace(/^data-/,
"");else return true;g[d]=h(this.nodeValue)})}else{if(a.type=="class"){var f=a.cre.exec(b.className);if(f)c=f[1]}else if(a.type=="elem"){if(!b.getElementsByTagName)return;f=b.getElementsByTagName(a.name);if(f.length)c=e.trim(f[0].innerHTML)}else if(b.getAttribute!=undefined)if(f=b.getAttribute(a.name))c=f;g=h(c.indexOf("{")<0?"{"+c+"}":c)}e.data(b,a.single,g);return g}}});e.fn.metadata=function(b){return e.metadata.get(this[0],b)}})(jQuery);
// ColorBox v1.3.19 - jQuery lightbox plugin
// (c) 2011 Jack Moore - jacklmoore.com
// License: http://www.opensource.org/licenses/mit-license.php
(function(a,b,c){function Z(c,d,e){var g=b.createElement(c);return d&&(g.id=f+d),e&&(g.style.cssText=e),a(g)}function $(a){var b=y.length,c=(Q+a)%b;return c<0?b+c:c}function _(a,b){return Math.round((/%/.test(a)?(b==="x"?z.width():z.height())/100:1)*parseInt(a,10))}function ba(a){return K.photo||/\.(gif|png|jpe?g|bmp|ico)((#|\?).*)?$/i.test(a)}function bb(){var b;K=a.extend({},a.data(P,e));for(b in K)a.isFunction(K[b])&&b.slice(0,2)!=="on"&&(K[b]=K[b].call(P));K.rel=K.rel||P.rel||"nofollow",K.href=K.href||a(P).attr("href"),K.title=K.title||P.title,typeof K.href=="string"&&(K.href=a.trim(K.href))}function bc(b,c){a.event.trigger(b),c&&c.call(P)}function bd(){var a,b=f+"Slideshow_",c="click."+f,d,e,g;K.slideshow&&y[1]?(d=function(){F.text(K.slideshowStop).unbind(c).bind(j,function(){if(K.loop||y[Q+1])a=setTimeout(W.next,K.slideshowSpeed)}).bind(i,function(){clearTimeout(a)}).one(c+" "+k,e),r.removeClass(b+"off").addClass(b+"on"),a=setTimeout(W.next,K.slideshowSpeed)},e=function(){clearTimeout(a),F.text(K.slideshowStart).unbind([j,i,k,c].join(" ")).one(c,function(){W.next(),d()}),r.removeClass(b+"on").addClass(b+"off")},K.slideshowAuto?d():e()):r.removeClass(b+"off "+b+"on")}function be(b){U||(P=b,bb(),y=a(P),Q=0,K.rel!=="nofollow"&&(y=a("."+g).filter(function(){var b=a.data(this,e).rel||this.rel;return b===K.rel}),Q=y.index(P),Q===-1&&(y=y.add(P),Q=y.length-1)),S||(S=T=!0,r.show(),K.returnFocus&&a(P).blur().one(l,function(){a(this).focus()}),q.css({opacity:+K.opacity,cursor:K.overlayClose?"pointer":"auto"}).show(),K.w=_(K.initialWidth,"x"),K.h=_(K.initialHeight,"y"),W.position(),o&&z.bind("resize."+p+" scroll."+p,function(){q.css({width:z.width(),height:z.height(),top:z.scrollTop(),left:z.scrollLeft()})}).trigger("resize."+p),bc(h,K.onOpen),J.add(D).hide(),I.html(K.close).show()),W.load(!0))}function bf(){!r&&b.body&&(Y=!1,z=a(c),r=Z(X).attr({id:e,"class":n?f+(o?"IE6":"IE"):""}).hide(),q=Z(X,"Overlay",o?"position:absolute":"").hide(),s=Z(X,"Wrapper"),t=Z(X,"Content").append(A=Z(X,"LoadedContent","width:0; height:0; overflow:hidden"),C=Z(X,"LoadingOverlay").add(Z(X,"LoadingGraphic")),D=Z(X,"Title"),E=Z(X,"Current"),G=Z(X,"Next"),H=Z(X,"Previous"),F=Z(X,"Slideshow").bind(h,bd),I=Z(X,"Close")),s.append(Z(X).append(Z(X,"TopLeft"),u=Z(X,"TopCenter"),Z(X,"TopRight")),Z(X,!1,"clear:left").append(v=Z(X,"MiddleLeft"),t,w=Z(X,"MiddleRight")),Z(X,!1,"clear:left").append(Z(X,"BottomLeft"),x=Z(X,"BottomCenter"),Z(X,"BottomRight"))).find("div div").css({"float":"left"}),B=Z(X,!1,"position:absolute; width:9999px; visibility:hidden; display:none"),J=G.add(H).add(E).add(F),a(b.body).append(q,r.append(s,B)))}function bg(){return r?(Y||(Y=!0,L=u.height()+x.height()+t.outerHeight(!0)-t.height(),M=v.width()+w.width()+t.outerWidth(!0)-t.width(),N=A.outerHeight(!0),O=A.outerWidth(!0),r.css({"padding-bottom":L,"padding-right":M}),G.click(function(){W.next()}),H.click(function(){W.prev()}),I.click(function(){W.close()}),q.click(function(){K.overlayClose&&W.close()}),a(b).bind("keydown."+f,function(a){var b=a.keyCode;S&&K.escKey&&b===27&&(a.preventDefault(),W.close()),S&&K.arrowKey&&y[1]&&(b===37?(a.preventDefault(),H.click()):b===39&&(a.preventDefault(),G.click()))}),a("."+g,b).live("click",function(a){a.which>1||a.shiftKey||a.altKey||a.metaKey||(a.preventDefault(),be(this))})),!0):!1}var d={transition:"elastic",speed:300,width:!1,initialWidth:"600",innerWidth:!1,maxWidth:!1,height:!1,initialHeight:"450",innerHeight:!1,maxHeight:!1,scalePhotos:!0,scrolling:!0,inline:!1,html:!1,iframe:!1,fastIframe:!0,photo:!1,href:!1,title:!1,rel:!1,opacity:.9,preloading:!0,current:"image {current} of {total}",previous:"previous",next:"next",close:"close",open:!1,returnFocus:!0,reposition:!0,loop:!0,slideshow:!1,slideshowAuto:!0,slideshowSpeed:2500,slideshowStart:"start slideshow",slideshowStop:"stop slideshow",onOpen:!1,onLoad:!1,onComplete:!1,onCleanup:!1,onClosed:!1,overlayClose:!0,escKey:!0,arrowKey:!0,top:!1,bottom:!1,left:!1,right:!1,fixed:!1,data:undefined},e="colorbox",f="cbox",g=f+"Element",h=f+"_open",i=f+"_load",j=f+"_complete",k=f+"_cleanup",l=f+"_closed",m=f+"_purge",n=!a.support.opacity&&!a.support.style,o=n&&!c.XMLHttpRequest,p=f+"_IE6",q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X="div",Y;if(a.colorbox)return;a(bf),W=a.fn[e]=a[e]=function(b,c){var f=this;b=b||{},bf();if(bg()){if(!f[0]){if(f.selector)return f;f=a("<a/>"),b.open=!0}c&&(b.onComplete=c),f.each(function(){a.data(this,e,a.extend({},a.data(this,e)||d,b))}).addClass(g),(a.isFunction(b.open)&&b.open.call(f)||b.open)&&be(f[0])}return f},W.position=function(a,b){function i(a){u[0].style.width=x[0].style.width=t[0].style.width=a.style.width,t[0].style.height=v[0].style.height=w[0].style.height=a.style.height}var c=0,d=0,e=r.offset(),g=z.scrollTop(),h=z.scrollLeft();z.unbind("resize."+f),r.css({top:-9e4,left:-9e4}),K.fixed&&!o?(e.top-=g,e.left-=h,r.css({position:"fixed"})):(c=g,d=h,r.css({position:"absolute"})),K.right!==!1?d+=Math.max(z.width()-K.w-O-M-_(K.right,"x"),0):K.left!==!1?d+=_(K.left,"x"):d+=Math.round(Math.max(z.width()-K.w-O-M,0)/2),K.bottom!==!1?c+=Math.max(z.height()-K.h-N-L-_(K.bottom,"y"),0):K.top!==!1?c+=_(K.top,"y"):c+=Math.round(Math.max(z.height()-K.h-N-L,0)/2),r.css({top:e.top,left:e.left}),a=r.width()===K.w+O&&r.height()===K.h+N?0:a||0,s[0].style.width=s[0].style.height="9999px",r.dequeue().animate({width:K.w+O,height:K.h+N,top:c,left:d},{duration:a,complete:function(){i(this),T=!1,s[0].style.width=K.w+O+M+"px",s[0].style.height=K.h+N+L+"px",K.reposition&&setTimeout(function(){z.bind("resize."+f,W.position)},1),b&&b()},step:function(){i(this)}})},W.resize=function(a){S&&(a=a||{},a.width&&(K.w=_(a.width,"x")-O-M),a.innerWidth&&(K.w=_(a.innerWidth,"x")),A.css({width:K.w}),a.height&&(K.h=_(a.height,"y")-N-L),a.innerHeight&&(K.h=_(a.innerHeight,"y")),!a.innerHeight&&!a.height&&(A.css({height:"auto"}),K.h=A.height()),A.css({height:K.h}),W.position(K.transition==="none"?0:K.speed))},W.prep=function(b){function g(){return K.w=K.w||A.width(),K.w=K.mw&&K.mw<K.w?K.mw:K.w,K.w}function h(){return K.h=K.h||A.height(),K.h=K.mh&&K.mh<K.h?K.mh:K.h,K.h}if(!S)return;var c,d=K.transition==="none"?0:K.speed;A.remove(),A=Z(X,"LoadedContent").append(b),A.hide().appendTo(B.show()).css({width:g(),overflow:K.scrolling?"auto":"hidden"}).css({height:h()}).prependTo(t),B.hide(),a(R).css({"float":"none"}),o&&a("select").not(r.find("select")).filter(function(){return this.style.visibility!=="hidden"}).css({visibility:"hidden"}).one(k,function(){this.style.visibility="inherit"}),c=function(){function q(){n&&r[0].style.removeAttribute("filter")}var b,c,g=y.length,h,i="frameBorder",k="allowTransparency",l,o,p;if(!S)return;l=function(){clearTimeout(V),C.hide(),bc(j,K.onComplete)},n&&R&&A.fadeIn(100),D.html(K.title).add(A).show();if(g>1){typeof K.current=="string"&&E.html(K.current.replace("{current}",Q+1).replace("{total}",g)).show(),G[K.loop||Q<g-1?"show":"hide"]().html(K.next),H[K.loop||Q?"show":"hide"]().html(K.previous),K.slideshow&&F.show();if(K.preloading){b=[$(-1),$(1)];while(c=y[b.pop()])o=a.data(c,e).href||c.href,a.isFunction(o)&&(o=o.call(c)),ba(o)&&(p=new Image,p.src=o)}}else J.hide();K.iframe?(h=Z("iframe")[0],i in h&&(h[i]=0),k in h&&(h[k]="true"),h.name=f+ +(new Date),K.fastIframe?l():a(h).one("load",l),h.src=K.href,K.scrolling||(h.scrolling="no"),a(h).addClass(f+"Iframe").appendTo(A).one(m,function(){h.src="//about:blank"})):l(),K.transition==="fade"?r.fadeTo(d,1,q):q()},K.transition==="fade"?r.fadeTo(d,0,function(){W.position(0,c)}):W.position(d,c)},W.load=function(b){var c,d,e=W.prep;T=!0,R=!1,P=y[Q],b||bb(),bc(m),bc(i,K.onLoad),K.h=K.height?_(K.height,"y")-N-L:K.innerHeight&&_(K.innerHeight,"y"),K.w=K.width?_(K.width,"x")-O-M:K.innerWidth&&_(K.innerWidth,"x"),K.mw=K.w,K.mh=K.h,K.maxWidth&&(K.mw=_(K.maxWidth,"x")-O-M,K.mw=K.w&&K.w<K.mw?K.w:K.mw),K.maxHeight&&(K.mh=_(K.maxHeight,"y")-N-L,K.mh=K.h&&K.h<K.mh?K.h:K.mh),c=K.href,V=setTimeout(function(){C.show()},100),K.inline?(Z(X).hide().insertBefore(a(c)[0]).one(m,function(){a(this).replaceWith(A.children())}),e(a(c))):K.iframe?e(" "):K.html?e(K.html):ba(c)?(a(R=new Image).addClass(f+"Photo").error(function(){K.title=!1,e(Z(X,"Error").text("This image could not be loaded"))}).load(function(){var a;R.onload=null,K.scalePhotos&&(d=function(){R.height-=R.height*a,R.width-=R.width*a},K.mw&&R.width>K.mw&&(a=(R.width-K.mw)/R.width,d()),K.mh&&R.height>K.mh&&(a=(R.height-K.mh)/R.height,d())),K.h&&(R.style.marginTop=Math.max(K.h-R.height,0)/2+"px"),y[1]&&(K.loop||y[Q+1])&&(R.style.cursor="pointer",R.onclick=function(){W.next()}),n&&(R.style.msInterpolationMode="bicubic"),setTimeout(function(){e(R)},1)}),setTimeout(function(){R.src=c},1)):c&&B.load(c,K.data,function(b,c,d){e(c==="error"?Z(X,"Error").text("Request unsuccessful: "+d.statusText):a(this).contents())})},W.next=function(){!T&&y[1]&&(K.loop||y[Q+1])&&(Q=$(1),W.load())},W.prev=function(){!T&&y[1]&&(K.loop||Q)&&(Q=$(-1),W.load())},W.close=function(){S&&!U&&(U=!0,S=!1,bc(k,K.onCleanup),z.unbind("."+f+" ."+p),q.fadeTo(200,0),r.stop().fadeTo(300,0,function(){r.add(q).css({opacity:1,cursor:"auto"}).hide(),bc(m),A.remove(),setTimeout(function(){U=!1,bc(l,K.onClosed)},1)}))},W.remove=function(){a([]).add(r).add(q).remove(),r=null,a("."+g).removeData(e).removeClass(g).die()},W.element=function(){return a(P)},W.settings=d})(jQuery,document,this);

/* Valid8 */
(function($){$.fn.extend({valid8:function(b){return this.each(function(){$(this).data('valid',false);var a={regularExpressions:[],ajaxRequests:[],jsFunctions:[],validationEvents:['keyup','blur'],validationFrequency:1000,values:null,defaultErrorMessage:'Required'};if(typeof b=='string')a.defaultErrorMessage=b;if(this.type=='checkbox'){a.regularExpressions=[{expression:/^true$/,errormessage:a.defaultErrorMessage}];a.validationEvents=['click']}else a.regularExpressions=[{expression:/^.+$/,errormessage:a.defaultErrorMessage}];$(this).data('settings',$.extend(a,b));initialize(this)})},isValid:function(){var a=true;this.each(function(){validate(this);if($(this).data('valid')==false)a=false});return a}});function initializeDataObject(a){$(a).data('loadings',new Array());$(a).data('errors',new Array());$(a).data('valids',new Array());$(a).data('keypressTimer',null)}function initialize(a){initializeDataObject(a);activate(a)};function activate(b){var c=$(b).data('settings').validationEvents;if(typeof c=='string')$(b)[c](function(e){handleEvent(e,b)});else{$.each(c,function(i,a){$(b)[a](function(e){handleEvent(e,b)})})}};function validate(a){initializeDataObject(a);var b;if(a.type=='checkbox')b=a.checked.toString();else b=a.value;regexpValidation(b.replace(/^[ \t]+|[ \t]+$/,''),a)};function regexpValidation(b,c){$.each($(c).data('settings').regularExpressions,function(i,a){if(!a.expression.test(b))$(c).data('errors')[$(c).data('errors').length]=a.errormessage;else if(a.validmessage)$(c).data('valids')[$(c).data('valids').length]=a.validmessage});if($(c).data('errors').length>0)onEvent(c,'error',false);else if($(c).data('settings').jsFunctions.length>0){functionValidation(b,c)}else if($(c).data('settings').ajaxRequests.length>0){fileValidation(b,c)}else{onEvent(c,'valid',true)}};function functionValidation(c,d){$.each($(d).data('settings').jsFunctions,function(i,a){var v;if(a.values){if(typeof a.values=='function')v=a.values()}var b=v||c;handleLoading(d,a);if(a['function'](b).valid)$(d).data('valids')[$(d).data('valids').length]=a['function'](b).message;else $(d).data('errors')[$(d).data('errors').length]=a['function'](b).message});if($(d).data('errors').length>0)onEvent(d,'error',false);else if($(d).data('settings').ajaxRequests.length>0){fileValidation(c,d)}else{onEvent(d,'valid',true)}};function fileValidation(e,f){$.each($(f).data('settings').ajaxRequests,function(i,c){var v;if(c.values){if(typeof c.values=='function')v=c.values()}var d=v||{value:e};handleLoading(f,c);$.post(c.url,d,function(a,b){if(a.valid){$(f).data('valids')[$(f).data('valids').length]=a.message||c.validmessage||""}else{$(f).data('errors')[$(f).data('errors').length]=a.message||c.errormessage||""}if($(f).data('errors').length>0)onEvent(f,'error',false);else{onEvent(f,'valid',true)}},"json")})};function handleEvent(e,a){if(e.keyCode&&$(a).attr('value').length>0){clearTimeout($(a).data('keypressTimer'));$(a).data('keypressTimer',setTimeout(function(){validate(a)},$(a).data('settings').validationFrequency))}else if(e.keyCode&&$(a).attr('value').length<=0)return false;else{validate(a)}};function handleLoading(a,b){if(b.loadingmessage){$(a).data('loadings')[$(a).data('loadings').length]=b.loadingmessage;onEvent(a,'loading',false)}};function onEvent(a,b,c){var d=b.substring(0,1).toUpperCase()+b.substring(1,b.length),messages=$(a).data(b+'s');$(a).data(b,c);setStatus(a,b);setParentClass(a,b);setMessage(messages,a);$(a).trigger(b,[messages,a,b])}function setParentClass(a,b){var c=$(a).parent();c[0].className=(c[0].className.replace(/(^\s|(\s*(loading|error|valid)))/g,'')+' '+b).replace(/^\s/,'')}function setMessage(a,b){var c=$(b).parent();var d=b.id+"ValidationMessage";var e='validationMessage';if(!$('#'+d).length>0){c.append('<span id="'+d+'" class="'+e+'"></span>')}$('#'+d).html("");$('#'+d).text(a[0])};function setStatus(a,b){if(b=='valid'){$(a).data('valid',true)}else if(b=='error'){$(a).data('valid',false)}}})(jQuery);
/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 *
*/
jQuery.easing.jswing=jQuery.easing.swing;
jQuery.extend(jQuery.easing,{def:"easeOutQuad",swing:function(e,a,c,b,d){return jQuery.easing[jQuery.easing.def](e,a,c,b,d)},easeInQuad:function(e,a,c,b,d){return b*(a/=d)*a+c},easeOutQuad:function(e,a,c,b,d){return-b*(a/=d)*(a-2)+c},easeInOutQuad:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a+c;return-b/2*(--a*(a-2)-1)+c},easeInCubic:function(e,a,c,b,d){return b*(a/=d)*a*a+c},easeOutCubic:function(e,a,c,b,d){return b*((a=a/d-1)*a*a+1)+c},easeInOutCubic:function(e,a,c,b,d){if((a/=d/2)<1)return b/
2*a*a*a+c;return b/2*((a-=2)*a*a+2)+c},easeInQuart:function(e,a,c,b,d){return b*(a/=d)*a*a*a+c},easeOutQuart:function(e,a,c,b,d){return-b*((a=a/d-1)*a*a*a-1)+c},easeInOutQuart:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a*a*a+c;return-b/2*((a-=2)*a*a*a-2)+c},easeInQuint:function(e,a,c,b,d){return b*(a/=d)*a*a*a*a+c},easeOutQuint:function(e,a,c,b,d){return b*((a=a/d-1)*a*a*a*a+1)+c},easeInOutQuint:function(e,a,c,b,d){if((a/=d/2)<1)return b/2*a*a*a*a*a+c;return b/2*((a-=2)*a*a*a*a+2)+c},easeInSine:function(e,
a,c,b,d){return-b*Math.cos(a/d*(Math.PI/2))+b+c},easeOutSine:function(e,a,c,b,d){return b*Math.sin(a/d*(Math.PI/2))+c},easeInOutSine:function(e,a,c,b,d){return-b/2*(Math.cos(Math.PI*a/d)-1)+c},easeInExpo:function(e,a,c,b,d){return a==0?c:b*Math.pow(2,10*(a/d-1))+c},easeOutExpo:function(e,a,c,b,d){return a==d?c+b:b*(-Math.pow(2,-10*a/d)+1)+c},easeInOutExpo:function(e,a,c,b,d){if(a==0)return c;if(a==d)return c+b;if((a/=d/2)<1)return b/2*Math.pow(2,10*(a-1))+c;return b/2*(-Math.pow(2,-10*--a)+2)+c},
easeInCirc:function(e,a,c,b,d){return-b*(Math.sqrt(1-(a/=d)*a)-1)+c},easeOutCirc:function(e,a,c,b,d){return b*Math.sqrt(1-(a=a/d-1)*a)+c},easeInOutCirc:function(e,a,c,b,d){if((a/=d/2)<1)return-b/2*(Math.sqrt(1-a*a)-1)+c;return b/2*(Math.sqrt(1-(a-=2)*a)+1)+c},easeInElastic:function(e,a,c,b,d){e=1.70158;var f=0,g=b;if(a==0)return c;if((a/=d)==1)return c+b;f||(f=d*0.3);if(g<Math.abs(b)){g=b;e=f/4}else e=f/(2*Math.PI)*Math.asin(b/g);return-(g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f))+c},easeOutElastic:function(e,
a,c,b,d){e=1.70158;var f=0,g=b;if(a==0)return c;if((a/=d)==1)return c+b;f||(f=d*0.3);if(g<Math.abs(b)){g=b;e=f/4}else e=f/(2*Math.PI)*Math.asin(b/g);return g*Math.pow(2,-10*a)*Math.sin((a*d-e)*2*Math.PI/f)+b+c},easeInOutElastic:function(e,a,c,b,d){e=1.70158;var f=0,g=b;if(a==0)return c;if((a/=d/2)==2)return c+b;f||(f=d*0.3*1.5);if(g<Math.abs(b)){g=b;e=f/4}else e=f/(2*Math.PI)*Math.asin(b/g);if(a<1)return-0.5*g*Math.pow(2,10*(a-=1))*Math.sin((a*d-e)*2*Math.PI/f)+c;return g*Math.pow(2,-10*(a-=1))*Math.sin((a*
d-e)*2*Math.PI/f)*0.5+b+c},easeInBack:function(e,a,c,b,d,f){if(f==undefined)f=1.70158;return b*(a/=d)*a*((f+1)*a-f)+c},easeOutBack:function(e,a,c,b,d,f){if(f==undefined)f=1.70158;return b*((a=a/d-1)*a*((f+1)*a+f)+1)+c},easeInOutBack:function(e,a,c,b,d,f){if(f==undefined)f=1.70158;if((a/=d/2)<1)return b/2*a*a*(((f*=1.525)+1)*a-f)+c;return b/2*((a-=2)*a*(((f*=1.525)+1)*a+f)+2)+c},easeInBounce:function(e,a,c,b,d){return b-jQuery.easing.easeOutBounce(e,d-a,0,b,d)+c},easeOutBounce:function(e,a,c,b,d){return(a/=
d)<1/2.75?b*7.5625*a*a+c:a<2/2.75?b*(7.5625*(a-=1.5/2.75)*a+0.75)+c:a<2.5/2.75?b*(7.5625*(a-=2.25/2.75)*a+0.9375)+c:b*(7.5625*(a-=2.625/2.75)*a+0.984375)+c},easeInOutBounce:function(e,a,c,b,d){if(a<d/2)return jQuery.easing.easeInBounce(e,a*2,0,b,d)*0.5+c;return jQuery.easing.easeOutBounce(e,a*2-d,0,b,d)*0.5+b*0.5+c}});
/*
 * jQuery Color Animations
 * Copyright 2007 John Resig
 * Released under the MIT and GPL licenses.
 */
(function(d){function e(c){var a;if(c&&c.constructor==Array&&c.length==3)return c;if(a=/rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(c))return[parseInt(a[1]),parseInt(a[2]),parseInt(a[3])];if(a=/rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(c))return[parseFloat(a[1])*2.55,parseFloat(a[2])*2.55,parseFloat(a[3])*2.55];if(a=/#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(c))return[parseInt(a[1],16),parseInt(a[2],
16),parseInt(a[3],16)];if(a=/#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(c))return[parseInt(a[1]+a[1],16),parseInt(a[2]+a[2],16),parseInt(a[3]+a[3],16)];return f[d.trim(c).toLowerCase()]}function g(c,a){var b;do{b=d.curCSS(c,a);if(b!=""&&b!="transparent"||d.nodeName(c,"body"))break;a="backgroundColor"}while(c=c.parentNode);return e(b)}d.each(["backgroundColor","borderBottomColor","borderLeftColor","borderRightColor","borderTopColor","color","outlineColor"],function(c,a){d.fx.step[a]=function(b){if(b.state==
0){b.start=g(b.elem,a);b.end=e(b.end)}b.elem.style[a]="rgb("+[Math.max(Math.min(parseInt(b.pos*(b.end[0]-b.start[0])+b.start[0]),255),0),Math.max(Math.min(parseInt(b.pos*(b.end[1]-b.start[1])+b.start[1]),255),0),Math.max(Math.min(parseInt(b.pos*(b.end[2]-b.start[2])+b.start[2]),255),0)].join(",")+")"}});var f={aqua:[0,255,255],azure:[240,255,255],beige:[245,245,220],black:[0,0,0],blue:[0,0,255],brown:[165,42,42],cyan:[0,255,255],darkblue:[0,0,139],darkcyan:[0,139,139],darkgrey:[169,169,169],darkgreen:[0,
100,0],darkkhaki:[189,183,107],darkmagenta:[139,0,139],darkolivegreen:[85,107,47],darkorange:[255,140,0],darkorchid:[153,50,204],darkred:[139,0,0],darksalmon:[233,150,122],darkviolet:[148,0,211],fuchsia:[255,0,255],gold:[255,215,0],green:[0,128,0],indigo:[75,0,130],khaki:[240,230,140],lightblue:[173,216,230],lightcyan:[224,255,255],lightgreen:[144,238,144],lightgrey:[211,211,211],lightpink:[255,182,193],lightyellow:[255,255,224],lime:[0,255,0],magenta:[255,0,255],maroon:[128,0,0],navy:[0,0,128],olive:[128,
128,0],orange:[255,165,0],pink:[255,192,203],purple:[128,0,128],violet:[128,0,128],red:[255,0,0],silver:[192,192,192],white:[255,255,255],yellow:[255,255,0]}})(jQuery);
/* tipsy */
(function(b){function j(a){if(a.attr("title")||typeof a.attr("original-title")!="string")a.attr("original-title",a.attr("title")||"").removeAttr("title")}function k(a,c){this.$element=b(a);this.options=c;this.enabled=true;j(this.$element)}k.prototype={show:function(){var a=this.getTitle();if(a&&this.enabled){var c=this.tip();c.find(".tipsy-inner")[this.options.html?"html":"text"](a);c[0].className="tipsy";c.remove().css({top:0,left:0,visibility:"hidden",display:"block"}).appendTo(document.body);a=
b.extend({},this.$element.offset(),{width:this.$element[0].offsetWidth,height:this.$element[0].offsetHeight});var d=c[0].offsetWidth,h=c[0].offsetHeight,g=typeof this.options.gravity=="function"?this.options.gravity.call(this.$element[0]):this.options.gravity,f;switch(g.charAt(0)){case "n":f={top:a.top+a.height+this.options.offset,left:a.left+a.width/2-d/2};break;case "s":f={top:a.top-h-this.options.offset,left:a.left+a.width/2-d/2};break;case "e":f={top:a.top+a.height/2-h/2,left:a.left-d-this.options.offset};
break;case "w":f={top:a.top+a.height/2-h/2,left:a.left+a.width+this.options.offset};break}if(g.length==2)f.left=g.charAt(1)=="w"?a.left+a.width/2-15:a.left+a.width/2-d+15;c.css(f).addClass("tipsy-"+g);this.options.fade?c.stop().css({opacity:0,display:"block",visibility:"visible"}).animate({opacity:this.options.opacity}):c.css({visibility:"visible",opacity:this.options.opacity})}},hide:function(){this.options.fade?this.tip().stop().fadeOut(function(){b(this).remove()}):this.tip().remove()},getTitle:function(){var a,
c=this.$element,d=this.options;j(c);d=this.options;if(typeof d.title=="string")a=c.attr(d.title=="title"?"original-title":d.title);else if(typeof d.title=="function")a=d.title.call(c[0]);return(a=(""+a).replace(/(^\s*|\s*$)/,""))||d.fallback},tip:function(){if(!this.$tip)this.$tip=b('<div class="tipsy"></div>').html('<div class="tipsy-arrow"></div><div class="tipsy-inner"/></div>');return this.$tip},validate:function(){this.$element[0].parentNode||this.hide()},enable:function(){this.enabled=true},
disable:function(){this.enabled=false},toggleEnabled:function(){this.enabled=!this.enabled}};b.fn.tipsy=function(a){function c(e){var i=b.data(e,"tipsy");if(!i){i=new k(e,b.fn.tipsy.elementOptions(e,a));b.data(e,"tipsy",i)}return i}function d(){var e=c(this);e.hoverState="in";a.delayIn==0?e.show():setTimeout(function(){e.hoverState=="in"&&e.show()},a.delayIn)}function h(){var e=c(this);e.hoverState="out";a.delayOut==0?e.hide():setTimeout(function(){e.hoverState=="out"&&e.hide()},a.delayOut)}if(a===
true)return this.data("tipsy");else if(typeof a=="string")return this.data("tipsy")[a]();a=b.extend({},b.fn.tipsy.defaults,a);a.live||this.each(function(){c(this)});if(a.trigger!="manual"){var g=a.live?"live":"bind",f=a.trigger=="hover"?"mouseleave":"blur";this[g](a.trigger=="hover"?"mouseenter":"focus",d)[g](f,h)}return this};b.fn.tipsy.defaults={delayIn:0,delayOut:0,fade:false,fallback:"",gravity:"n",html:false,live:false,offset:0,opacity:0.8,title:"title",trigger:"hover"};b.fn.tipsy.elementOptions=
function(a,c){return b.metadata?b.extend({},c,b(a).metadata()):c};b.fn.tipsy.autoNS=function(){return b(this).offset().top>b(document).scrollTop()+b(window).height()/2?"s":"n"};b.fn.tipsy.autoWE=function(){return b(this).offset().left>b(document).scrollLeft()+b(window).width()/2?"e":"w"};b.fn.tipsy.autoSNiy=function(){return (b(this).offset().top-b(document).scrollTop())>50?"s":"n"}})(jQuery);


//////////////////////////////////////////////////////////////////////////////////
// Cloud Zoom V1.0.2
// (c) 2010 by R Cecco. <http://www.professorcloud.com>
// MIT License
//
// Please retain this copyright header in all versions of the software
//////////////////////////////////////////////////////////////////////////////////
(function(b){function n(g){for(var e=1;e<arguments.length;e++)g=g.replace("%"+(e-1),arguments[e]);return g}function H(g,e){var d=b("img:last",g),k,f=null,i=null,h=null,m=null,l=null,u=null,o,C=0,s,t,D=0,E=0,y=0,z=0,F=0,A,B,v=this,G;setTimeout(function(){if(i===null){var c=g.width();g.parent().append(n('<div style="width:%0px;position:absolute;top:75%;left:%1px;text-align:center" class="cloud_zoom_loading" >'+e.loading+"</div>",c/3,c/2-c/6)).find(":last").css("opacity",0.5)}},1);var I=function(){if(u!==
null){u.remove();u=null}b(".cloud_zoom_wrap iframe").remove()};this.removeBits=function(){if(h){h.remove();h=null}if(m){m.remove();m=null}if(l){l.remove();l=null}I();b(".cloud_zoom_loading",g.parent()).remove()};this.destroy=function(){g.data("zoom",null);if(i){i.unbind();i.remove();i=null}if(f){f.remove();f=null}this.removeBits()};this.fadedOut=function(){if(f){f.remove();f=null}this.removeBits()};this.controlLoop=function(){if(h){var c=A-d.offset().left-s*0.5>>0,j=B-d.offset().top-t*0.5>>0;if(c<
0)c=0;else if(c>d.outerWidth()-s)c=d.outerWidth()-s;if(j<0)j=0;else if(j>d.outerHeight()-t)j=d.outerHeight()-t;h.css({left:c,top:j});h.css("background-position",-c+"px "+-j+"px");D=c/d.outerWidth()*o.width>>0;E=j/d.outerHeight()*o.height>>0;z+=(D-z)/e.smoothMove;y+=(E-y)/e.smoothMove;f.css("background-position",-(z>>0)+"px "+(-(y>>0)+"px"))}C=setTimeout(function(){v.controlLoop()},30)};this.init2=function(c,j){F++;if(j===1)o=c;F===2&&this.init()};this.init=function(){b(".cloud_zoom_loading",g.parent()).remove();
i=g.parent().append(n("<div class='mousetrap' style='background-image:url(\".\");z-index:9;position:absolute;width:%0px;height:%1px;left:%2px;top:%3px;'></div>",d.outerWidth(),d.outerHeight(),0,0)).find(":last");i.bind("mousemove",this,function(c){A=c.pageX;B=c.pageY});i.bind("mouseleave",this,function(){clearTimeout(C);h&&h.fadeOut(299);m&&m.fadeOut(299);l&&l.fadeOut(299);f.fadeOut(300,function(){v.fadedOut()});return false});i.bind("mouseenter",this,function(c){A=c.pageX;B=c.pageY;G=c.data;if(f){f.stop(true,
false);f.remove()}c=e.adjustX;var j=e.adjustY,w=d.outerWidth(),x=d.outerHeight(),p=e.zoomWidth,q=e.zoomHeight;if(e.zoomWidth=="auto")p=w;if(e.zoomHeight=="auto")q=x;var r=g.parent();switch(e.position){case "top":j-=q;break;case "right":c+=w;break;case "bottom":j+=x;break;case "left":c-=p;break;case "inside":p=w;q=x;break;default:r=b("#"+e.position);if(r.length){p=r.innerWidth();q=r.innerHeight()}else{r=g;c+=w;j+=x}}f=r.append(n('<div id="cloud_zoom_big" class="cloud_zoom_big" style="display:none;position:absolute;left:%0px;top:%1px;width:%2px;height:%3px;background-image:url(\'%4\');z-index:8;"></div>',
c,j,p,q,o.src)).find(":last");d.attr("title")&&e.showTitle&&f.append(n('<div class="cloud_zoom_title">%0</div>',d.attr("title"))).find(":last").css("opacity",e.titleOpacity);if(b.browser.msie&&b.browser.version<7)u=b('<iframe frameborder="0" src="#"></iframe>').css({position:"absolute",left:c,top:j,zIndex:8,width:p,height:q}).insertBefore(f);f.fadeIn(500);if(h){h.remove();h=null}s=d.outerWidth()/o.width*f.width();t=d.outerHeight()/o.height*f.height();h=g.append(n("<div class = 'cloud_zoom_lens' style='display:none;z-index:7;position:absolute;width:%0px;height:%1px;'></div>",
s,t)).find(":last");i.css("cursor",h.css("cursor"));c=false;if(e.tint){h.css("background",'url("'+d.attr("src")+'")');m=g.append(n('<div style="display:none;position:absolute; left:0px; top:0px; width:%0px; height:%1px; background-color:%2;" />',d.outerWidth(),d.outerHeight(),e.tint)).find(":last");m.css("opacity",e.tintOpacity);c=true;m.fadeIn(500)}if(e.softFocus){h.css("background",'url("'+d.attr("src")+'")');l=g.append(n('<div style="position:absolute;display:none;top:2px; left:2px; width:%0px; height:%1px;" />',
d.outerWidth()-2,d.outerHeight()-2,e.tint)).find(":last");l.css("background",'url("'+d.attr("src")+'")');l.css("opacity",0.5);c=true;l.fadeIn(500)}c||h.css("opacity",e.lensOpacity);e.position!=="inside"&&h.fadeIn(500);G.controlLoop()})};k=new Image;b(k).load(function(){v.init2(this,0)});k.src=d.attr("src");k=new Image;b(k).load(function(){v.init2(this,1)});k.src=g.attr("href")}b(document).ready(function(){b(".cloud_zoom, .cloud_zoom_gallery").CloudZoom()});b.fn.CloudZoom=function(g){try{document.execCommand("BackgroundImageCache",
false,true)}catch(e){}this.each(function(){var d,k;eval("var\ta = {"+b(this).attr("rel")+"}");d=a;if(b(this).is(".cloud_zoom")){b(this).css({position:"relative"});b("img:last",b(this)).css({display:"block"});b(this).parent().attr("class")!="cloud_zoom_wrap"&&b(this).wrap('<div class="cloud_zoom_wrap" style="top:0px;z-index:11;position:relative;"></div>');k=b.extend({},b.fn.CloudZoom.defaults,g);k=b.extend({},k,d);b(this).data("zoom",new H(b(this),k))}else if(b(this).is(".cloud_zoom_gallery")){k=b.extend({},
d,g);b(this).data("relOpts",k);b(this).bind("click mouseenter",b(this),function(f){var i=f.data.data("relOpts");b("#"+i.useZoom).data("zoom").destroy();b("#"+i.useZoom).attr("href",f.data.attr("href"));b("#"+i.useZoom+" img:first").attr("src",f.data.data("relOpts").smallImage);b("#"+i.useZoom+" img:first").attr("title",f.data.data("relOpts").title);b("#"+f.data.data("relOpts").useZoom).CloudZoom();return false})}});return this};b.fn.CloudZoom.defaults={zoomWidth:"360",zoomHeight:"360",position:"right",
tint:false,tintOpacity:0.5,lensOpacity:0.5,softFocus:false,smoothMove:3,showTitle:true,title:"",loading:"Loading",titleOpacity:0.5,adjustX:17,adjustY:0}})(jQuery);

if ($.browser.msie && ($.browser.version <= "9.0")) {

/* http://keith-wood.name/countdown.html
   Countdown for jQuery v1.5.11.
   Written by Keith Wood (kbwood{at}iinet.com.au) January 2008.
   Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and 
   MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses. 
   Please attribute the author if you use it. */
(function($){function Countdown(){this.regional=[];this.regional['']={labels:['Years','Months','Weeks','Days','Hours','Minutes','Seconds'],labels1:['Year','Month','Week','Day','Hour','Minute','Second'],compactLabels:['y','m','w','d'],whichLabels:null,timeSeparator:':',isRTL:false};this._defaults={until:null,since:null,timezone:null,serverSync:null,format:'dHMS',layout:'',compact:false,significant:0,description:'',expiryUrl:'',expiryText:'',alwaysExpire:false,onExpiry:null,onTick:null,tickInterval:1};$.extend(this._defaults,this.regional['']);this._serverSyncs=[];function timerCallBack(a){var b=(a||new Date().getTime());if(b-d>=1000){$.countdown._updateTargets();d=b}c(timerCallBack)}var c=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||null;var d=0;if(!c){setInterval(function(){$.countdown._updateTargets()},980)}else{d=window.mozAnimationStartTime||new Date().getTime();c(timerCallBack)}}var w='countdown';var Y=0;var O=1;var W=2;var D=3;var H=4;var M=5;var S=6;$.extend(Countdown.prototype,{markerClassName:'hasCountdown',_timerTargets:[],setDefaults:function(a){this._resetExtraLabels(this._defaults,a);extendRemove(this._defaults,a||{})},UTCDate:function(a,b,c,e,f,g,h,i){if(typeof b=='object'&&b.constructor==Date){i=b.getMilliseconds();h=b.getSeconds();g=b.getMinutes();f=b.getHours();e=b.getDate();c=b.getMonth();b=b.getFullYear()}var d=new Date();d.setUTCFullYear(b);d.setUTCDate(1);d.setUTCMonth(c||0);d.setUTCDate(e||1);d.setUTCHours(f||0);d.setUTCMinutes((g||0)-(Math.abs(a)<30?a*60:a));d.setUTCSeconds(h||0);d.setUTCMilliseconds(i||0);return d},periodsToSeconds:function(a){return a[0]*31557600+a[1]*2629800+a[2]*604800+a[3]*86400+a[4]*3600+a[5]*60+a[6]},_settingsCountdown:function(a,b){if(!b){return $.countdown._defaults}var c=$.data(a,w);return(b=='all'?c.options:c.options[b])},_attachCountdown:function(a,b){var c=$(a);if(c.hasClass(this.markerClassName)){return}c.addClass(this.markerClassName);var d={options:$.extend({},b),_periods:[0,0,0,0,0,0,0]};$.data(a,w,d);this._changeCountdown(a)},_addTarget:function(a){if(!this._hasTarget(a)){this._timerTargets.push(a)}},_hasTarget:function(a){return($.inArray(a,this._timerTargets)>-1)},_removeTarget:function(b){this._timerTargets=$.map(this._timerTargets,function(a){return(a==b?null:a)})},_updateTargets:function(){for(var i=this._timerTargets.length-1;i>=0;i--){this._updateCountdown(this._timerTargets[i])}},_updateCountdown:function(a,b){var c=$(a);b=b||$.data(a,w);if(!b){return}c.html(this._generateHTML(b));c[(this._get(b,'isRTL')?'add':'remove')+'Class']('countdown_rtl');var d=this._get(b,'onTick');if(d){var e=b._hold!='lap'?b._periods:this._calculatePeriods(b,b._show,this._get(b,'significant'),new Date());var f=this._get(b,'tickInterval');if(f==1||this.periodsToSeconds(e)%f==0){d.apply(a,[e])}}var g=b._hold!='pause'&&(b._since?b._now.getTime()<b._since.getTime():b._now.getTime()>=b._until.getTime());if(g&&!b._expiring){b._expiring=true;if(this._hasTarget(a)||this._get(b,'alwaysExpire')){this._removeTarget(a);var h=this._get(b,'onExpiry');if(h){h.apply(a,[])}var i=this._get(b,'expiryText');if(i){var j=this._get(b,'layout');b.options.layout=i;this._updateCountdown(a,b);b.options.layout=j}var k=this._get(b,'expiryUrl');if(k){window.location=k}}b._expiring=false}else if(b._hold=='pause'){this._removeTarget(a)}$.data(a,w,b)},_changeCountdown:function(a,b,c){b=b||{};if(typeof b=='string'){var d=b;b={};b[d]=c}var e=$.data(a,w);if(e){this._resetExtraLabels(e.options,b);extendRemove(e.options,b);this._adjustSettings(a,e);$.data(a,w,e);var f=new Date();if((e._since&&e._since<f)||(e._until&&e._until>f)){this._addTarget(a)}this._updateCountdown(a,e)}},_resetExtraLabels:function(a,b){var c=false;for(var n in b){if(n!='whichLabels'&&n.match(/[Ll]abels/)){c=true;break}}if(c){for(var n in a){if(n.match(/[Ll]abels[0-9]/)){a[n]=null}}}},_adjustSettings:function(a,b){var c;var d=this._get(b,'serverSync');var e=0;var f=null;for(var i=0;i<this._serverSyncs.length;i++){if(this._serverSyncs[i][0]==d){f=this._serverSyncs[i][1];break}}if(f!=null){e=(d?f:0);c=new Date()}else{var g=(d?d.apply(a,[]):null);c=new Date();e=(g?c.getTime()-g.getTime():0);this._serverSyncs.push([d,e])}var h=this._get(b,'timezone');h=(h==null?-c.getTimezoneOffset():h);b._since=this._get(b,'since');if(b._since!=null){b._since=this.UTCDate(h,this._determineTime(b._since,null));if(b._since&&e){b._since.setMilliseconds(b._since.getMilliseconds()+e)}}b._until=this.UTCDate(h,this._determineTime(this._get(b,'until'),c));if(e){b._until.setMilliseconds(b._until.getMilliseconds()+e)}b._show=this._determineShow(b)},_destroyCountdown:function(a){var b=$(a);if(!b.hasClass(this.markerClassName)){return}this._removeTarget(a);b.removeClass(this.markerClassName).empty();$.removeData(a,w)},_pauseCountdown:function(a){this._hold(a,'pause')},_lapCountdown:function(a){this._hold(a,'lap')},_resumeCountdown:function(a){this._hold(a,null)},_hold:function(a,b){var c=$.data(a,w);if(c){if(c._hold=='pause'&&!b){c._periods=c._savePeriods;var d=(c._since?'-':'+');c[c._since?'_since':'_until']=this._determineTime(d+c._periods[0]+'y'+d+c._periods[1]+'o'+d+c._periods[2]+'w'+d+c._periods[3]+'d'+d+c._periods[4]+'h'+d+c._periods[5]+'m'+d+c._periods[6]+'s');this._addTarget(a)}c._hold=b;c._savePeriods=(b=='pause'?c._periods:null);$.data(a,w,c);this._updateCountdown(a,c)}},_getTimesCountdown:function(a){var b=$.data(a,w);return(!b?null:(!b._hold?b._periods:this._calculatePeriods(b,b._show,this._get(b,'significant'),new Date())))},_get:function(a,b){return(a.options[b]!=null?a.options[b]:$.countdown._defaults[b])},_determineTime:function(k,l){var m=function(a){var b=new Date();b.setTime(b.getTime()+a*1000);return b};var n=function(a){a=a.toLowerCase();var b=new Date();var c=b.getFullYear();var d=b.getMonth();var e=b.getDate();var f=b.getHours();var g=b.getMinutes();var h=b.getSeconds();var i=/([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g;var j=i.exec(a);while(j){switch(j[2]||'s'){case's':h+=parseInt(j[1],10);break;case'm':g+=parseInt(j[1],10);break;case'h':f+=parseInt(j[1],10);break;case'd':e+=parseInt(j[1],10);break;case'w':e+=parseInt(j[1],10)*7;break;case'o':d+=parseInt(j[1],10);e=Math.min(e,$.countdown._getDaysInMonth(c,d));break;case'y':c+=parseInt(j[1],10);e=Math.min(e,$.countdown._getDaysInMonth(c,d));break}j=i.exec(a)}return new Date(c,d,e,f,g,h,0)};var o=(k==null?l:(typeof k=='string'?n(k):(typeof k=='number'?m(k):k)));if(o)o.setMilliseconds(0);return o},_getDaysInMonth:function(a,b){return 32-new Date(a,b,32).getDate()},_normalLabels:function(a){return a},_generateHTML:function(c){var d=this._get(c,'significant');c._periods=(c._hold?c._periods:this._calculatePeriods(c,c._show,d,new Date()));var e=false;var f=0;var g=d;var h=$.extend({},c._show);for(var i=Y;i<=S;i++){e|=(c._show[i]=='?'&&c._periods[i]>0);h[i]=(c._show[i]=='?'&&!e?null:c._show[i]);f+=(h[i]?1:0);g-=(c._periods[i]>0?1:0)}var j=[false,false,false,false,false,false,false];for(var i=S;i>=Y;i--){if(c._show[i]){if(c._periods[i]){j[i]=true}else{j[i]=g>0;g--}}}var k=this._get(c,'compact');var l=this._get(c,'layout');var m=(k?this._get(c,'compactLabels'):this._get(c,'labels'));var n=this._get(c,'whichLabels')||this._normalLabels;var o=this._get(c,'timeSeparator');var p=this._get(c,'description')||'';var q=function(a){var b=$.countdown._get(c,'compactLabels'+n(c._periods[a]));return(h[a]?c._periods[a]+(b?b[a]:m[a])+' ':'')};var r=function(a){var b=$.countdown._get(c,'labels'+n(c._periods[a]));return((!d&&h[a])||(d&&j[a])?'<span class="countdown-section"><span class="countdown-amount">'+c._periods[a]+'</span>'+(b?b[a]:m[a])+'</span>':'')};return(l?this._buildLayout(c,h,l,k,d,j):((k?'<span class="countdown-row countdown-amount'+(c._hold?' countdown_holding':'')+'">'+q(Y)+q(O)+q(W)+q(D)+(h[H]?this._minDigits(c._periods[H],2):'')+(h[M]?(h[H]?o:'')+this._minDigits(c._periods[M],2):'')+(h[S]?(h[H]||h[M]?o:'')+this._minDigits(c._periods[S],2):''):'<span class="countdown-row countdown-show'+(d||f)+(c._hold?' countdown-holding':'')+'">'+r(Y)+r(O)+r(W)+r(D)+r(H)+r(M)+r(S))+'</span>'+(p?'<span class="countdown_row countdown-descr">'+p+'</span>':'')))},_buildLayout:function(c,d,e,f,g,h){var j=this._get(c,(f?'compactLabels':'labels'));var k=this._get(c,'whichLabels')||this._normalLabels;var l=function(a){return($.countdown._get(c,(f?'compactLabels':'labels')+k(c._periods[a]))||j)[a]};var m=function(a,b){return Math.floor(a/b)%10};var o={desc:this._get(c,'description'),sep:this._get(c,'timeSeparator'),yl:l(Y),yn:c._periods[Y],ynn:this._minDigits(c._periods[Y],2),ynnn:this._minDigits(c._periods[Y],3),y1:m(c._periods[Y],1),y10:m(c._periods[Y],10),y100:m(c._periods[Y],100),y1000:m(c._periods[Y],1000),ol:l(O),on:c._periods[O],onn:this._minDigits(c._periods[O],2),onnn:this._minDigits(c._periods[O],3),o1:m(c._periods[O],1),o10:m(c._periods[O],10),o100:m(c._periods[O],100),o1000:m(c._periods[O],1000),wl:l(W),wn:c._periods[W],wnn:this._minDigits(c._periods[W],2),wnnn:this._minDigits(c._periods[W],3),w1:m(c._periods[W],1),w10:m(c._periods[W],10),w100:m(c._periods[W],100),w1000:m(c._periods[W],1000),dl:l(D),dn:c._periods[D],dnn:this._minDigits(c._periods[D],2),dnnn:this._minDigits(c._periods[D],3),d1:m(c._periods[D],1),d10:m(c._periods[D],10),d100:m(c._periods[D],100),d1000:m(c._periods[D],1000),hl:l(H),hn:c._periods[H],hnn:this._minDigits(c._periods[H],2),hnnn:this._minDigits(c._periods[H],3),h1:m(c._periods[H],1),h10:m(c._periods[H],10),h100:m(c._periods[H],100),h1000:m(c._periods[H],1000),ml:l(M),mn:c._periods[M],mnn:this._minDigits(c._periods[M],2),mnnn:this._minDigits(c._periods[M],3),m1:m(c._periods[M],1),m10:m(c._periods[M],10),m100:m(c._periods[M],100),m1000:m(c._periods[M],1000),sl:l(S),sn:c._periods[S],snn:this._minDigits(c._periods[S],2),snnn:this._minDigits(c._periods[S],3),s1:m(c._periods[S],1),s10:m(c._periods[S],10),s100:m(c._periods[S],100),s1000:m(c._periods[S],1000)};var p=e;for(var i=Y;i<=S;i++){var q='yowdhms'.charAt(i);var r=new RegExp('\\{'+q+'<\\}(.*)\\{'+q+'>\\}','g');p=p.replace(r,((!g&&d[i])||(g&&h[i])?'$1':''))}$.each(o,function(n,v){var a=new RegExp('\\{'+n+'\\}','g');p=p.replace(a,v)});return p},_minDigits:function(a,b){a=''+a;if(a.length>=b){return a}a='0000000000'+a;return a.substr(a.length-b)},_determineShow:function(a){var b=this._get(a,'format');var c=[];c[Y]=(b.match('y')?'?':(b.match('Y')?'!':null));c[O]=(b.match('o')?'?':(b.match('O')?'!':null));c[W]=(b.match('w')?'?':(b.match('W')?'!':null));c[D]=(b.match('d')?'?':(b.match('D')?'!':null));c[H]=(b.match('h')?'?':(b.match('H')?'!':null));c[M]=(b.match('m')?'?':(b.match('M')?'!':null));c[S]=(b.match('s')?'?':(b.match('S')?'!':null));return c},_calculatePeriods:function(c,d,e,f){c._now=f;c._now.setMilliseconds(0);var g=new Date(c._now.getTime());if(c._since){if(f.getTime()<c._since.getTime()){c._now=f=g}else{f=c._since}}else{g.setTime(c._until.getTime());if(f.getTime()>c._until.getTime()){c._now=f=g}}var h=[0,0,0,0,0,0,0];if(d[Y]||d[O]){var i=$.countdown._getDaysInMonth(f.getFullYear(),f.getMonth());var j=$.countdown._getDaysInMonth(g.getFullYear(),g.getMonth());var k=(g.getDate()==f.getDate()||(g.getDate()>=Math.min(i,j)&&f.getDate()>=Math.min(i,j)));var l=function(a){return(a.getHours()*60+a.getMinutes())*60+a.getSeconds()};var m=Math.max(0,(g.getFullYear()-f.getFullYear())*12+g.getMonth()-f.getMonth()+((g.getDate()<f.getDate()&&!k)||(k&&l(g)<l(f))?-1:0));h[Y]=(d[Y]?Math.floor(m/12):0);h[O]=(d[O]?m-h[Y]*12:0);f=new Date(f.getTime());var n=(f.getDate()==i);var o=$.countdown._getDaysInMonth(f.getFullYear()+h[Y],f.getMonth()+h[O]);if(f.getDate()>o){f.setDate(o)}f.setFullYear(f.getFullYear()+h[Y]);f.setMonth(f.getMonth()+h[O]);if(n){f.setDate(o)}}var p=Math.floor((g.getTime()-f.getTime())/1000);var q=function(a,b){h[a]=(d[a]?Math.floor(p/b):0);p-=h[a]*b};q(W,604800);q(D,86400);q(H,3600);q(M,60);q(S,1);if(p>0&&!c._since){var r=[1,12,4.3482,7,24,60,60];var s=S;var t=1;for(var u=S;u>=Y;u--){if(d[u]){if(h[s]>=t){h[s]=0;p=1}if(p>0){h[u]++;p=0;s=u;t=1}}t*=r[u]}}if(e){for(var u=Y;u<=S;u++){if(e&&h[u]){e--}else if(!e){h[u]=0}}}return h}});function extendRemove(a,b){$.extend(a,b);for(var c in b){if(b[c]==null){a[c]=null}}return a}$.fn.countdown=function(a){var b=Array.prototype.slice.call(arguments,1);if(a=='getTimes'||a=='settings'){return $.countdown['_'+a+'Countdown'].apply($.countdown,[this[0]].concat(b))}return this.each(function(){if(typeof a=='string'){$.countdown['_'+a+'Countdown'].apply($.countdown,[this].concat(b))}else{$.countdown._attachCountdown(this,a)}})};$.countdown=new Countdown()})(jQuery);

} else {

/** Abstract base class for collection plugins.
	Written by Keith Wood (kbwood{at}iinet.com.au) December 2013.
	Licensed under the MIT (https://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt) license. */
(function(){var j=false;window.JQClass=function(){};JQClass.classes={};JQClass.extend=function extender(f){var g=this.prototype;j=true;var h=new this();j=false;for(var i in f){h[i]=typeof f[i]=='function'&&typeof g[i]=='function'?(function(d,e){return function(){var b=this._super;this._super=function(a){return g[d].apply(this,a)};var c=e.apply(this,arguments);this._super=b;return c}})(i,f[i]):f[i]}function JQClass(){if(!j&&this._init){this._init.apply(this,arguments)}}JQClass.prototype=h;JQClass.prototype.constructor=JQClass;JQClass.extend=extender;return JQClass}})();(function($){JQClass.classes.JQPlugin=JQClass.extend({name:'plugin',defaultOptions:{},regionalOptions:{},_getters:[],_getMarker:function(){return'is-'+this.name},_init:function(){$.extend(this.defaultOptions,(this.regionalOptions&&this.regionalOptions[''])||{});var c=camelCase(this.name);$[c]=this;$.fn[c]=function(a){var b=Array.prototype.slice.call(arguments,1);if($[c]._isNotChained(a,b)){return $[c][a].apply($[c],[this[0]].concat(b))}return this.each(function(){if(typeof a==='string'){if(a[0]==='_'||!$[c][a]){throw'Unknown method: '+a;}$[c][a].apply($[c],[this].concat(b))}else{$[c]._attach(this,a)}})}},setDefaults:function(a){$.extend(this.defaultOptions,a||{})},_isNotChained:function(a,b){if(a==='option'&&(b.length===0||(b.length===1&&typeof b[0]==='string'))){return true}return $.inArray(a,this._getters)>-1},_attach:function(a,b){a=$(a);if(a.hasClass(this._getMarker())){return}a.addClass(this._getMarker());b=$.extend({},this.defaultOptions,this._getMetadata(a),b||{});var c=$.extend({name:this.name,elem:a,options:b},this._instSettings(a,b));a.data(this.name,c);this._postAttach(a,c);this.option(a,b)},_instSettings:function(a,b){return{}},_postAttach:function(a,b){},_getMetadata:function(d){try{var f=d.data(this.name.toLowerCase())||'';f=f.replace(/'/g,'"');f=f.replace(/([a-zA-Z0-9]+):/g,function(a,b,i){var c=f.substring(0,i).match(/"/g);return(!c||c.length%2===0?'"'+b+'":':b+':')});f=$.parseJSON('{'+f+'}');for(var g in f){var h=f[g];if(typeof h==='string'&&h.match(/^new Date\((.*)\)$/)){f[g]=eval(h)}}return f}catch(e){return{}}},_getInst:function(a){return $(a).data(this.name)||{}},option:function(a,b,c){a=$(a);var d=a.data(this.name);if(!b||(typeof b==='string'&&c==null)){var e=(d||{}).options;return(e&&b?e[b]:e)}if(!a.hasClass(this._getMarker())){return}var e=b||{};if(typeof b==='string'){e={};e[b]=c}this._optionsChanged(a,d,e);$.extend(d.options,e)},_optionsChanged:function(a,b,c){},destroy:function(a){a=$(a);if(!a.hasClass(this._getMarker())){return}this._preDestroy(a,this._getInst(a));a.removeData(this.name).removeClass(this._getMarker())},_preDestroy:function(a,b){}});function camelCase(c){return c.replace(/-([a-z])/g,function(a,b){return b.toUpperCase()})}$.JQPlugin={createPlugin:function(a,b){if(typeof a==='object'){b=a;a='JQPlugin'}a=camelCase(a);var c=camelCase(b.name);JQClass.classes[c]=JQClass.classes[a].extend(b);new JQClass.classes[c]()}}})(jQuery);
/* http://keith-wood.name/countdown.html
   Countdown for jQuery v2.0.0.
   Written by Keith Wood (kbwood{at}iinet.com.au) January 2008.
   Available under the MIT (https://github.com/jquery/jquery/blob/master/MIT-LICENSE.txt) license. 
   Please attribute the author if you use it. */
(function($){var w='countdown';var Y=0;var O=1;var W=2;var D=3;var H=4;var M=5;var S=6;$.JQPlugin.createPlugin({name:w,defaultOptions:{until:null,since:null,timezone:null,serverSync:null,format:'dHMS',layout:'',compact:false,padZeroes:false,significant:0,description:'',expiryUrl:'',expiryText:'',alwaysExpire:false,onExpiry:null,onTick:null,tickInterval:1},regionalOptions:{'':{labels:['Years','Months','Weeks','Days','Hours','Minutes','Seconds'],labels1:['Year','Month','Week','Day','Hour','Minute','Second'],compactLabels:['y','m','w','d'],whichLabels:null,digits:['0','1','2','3','4','5','6','7','8','9'],timeSeparator:':',isRTL:false}},_getters:['getTimes'],_rtlClass:w+'-rtl',_sectionClass:w+'-section',_amountClass:w+'-amount',_periodClass:w+'-period',_rowClass:w+'-row',_holdingClass:w+'-holding',_showClass:w+'-show',_descrClass:w+'-descr',_timerElems:[],_init:function(){var c=this;this._super();this._serverSyncs=[];var d=(typeof Date.now=='function'?Date.now:function(){return new Date().getTime()});var e=(window.performance&&typeof window.performance.now=='function');function timerCallBack(a){var b=(a<1e12?(e?(performance.now()+performance.timing.navigationStart):d()):a||d());if(b-g>=1000){c._updateElems();g=b}f(timerCallBack)}var f=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||null;var g=0;if(!f||$.noRequestAnimationFrame){$.noRequestAnimationFrame=null;setInterval(function(){c._updateElems()},980)}else{g=window.animationStartTime||window.webkitAnimationStartTime||window.mozAnimationStartTime||window.oAnimationStartTime||window.msAnimationStartTime||d();f(timerCallBack)}},UTCDate:function(a,b,c,e,f,g,h,i){if(typeof b=='object'&&b.constructor==Date){i=b.getMilliseconds();h=b.getSeconds();g=b.getMinutes();f=b.getHours();e=b.getDate();c=b.getMonth();b=b.getFullYear()}var d=new Date();d.setUTCFullYear(b);d.setUTCDate(1);d.setUTCMonth(c||0);d.setUTCDate(e||1);d.setUTCHours(f||0);d.setUTCMinutes((g||0)-(Math.abs(a)<30?a*60:a));d.setUTCSeconds(h||0);d.setUTCMilliseconds(i||0);return d},periodsToSeconds:function(a){return a[0]*31557600+a[1]*2629800+a[2]*604800+a[3]*86400+a[4]*3600+a[5]*60+a[6]},_instSettings:function(a,b){return{_periods:[0,0,0,0,0,0,0]}},_addElem:function(a){if(!this._hasElem(a)){this._timerElems.push(a)}},_hasElem:function(a){return($.inArray(a,this._timerElems)>-1)},_removeElem:function(b){this._timerElems=$.map(this._timerElems,function(a){return(a==b?null:a)})},_updateElems:function(){for(var i=this._timerElems.length-1;i>=0;i--){this._updateCountdown(this._timerElems[i])}},_optionsChanged:function(a,b,c){if(c.layout){c.layout=c.layout.replace(/&lt;/g,'<').replace(/&gt;/g,'>')}this._resetExtraLabels(b.options,c);var d=(b.options.timezone!=c.timezone);$.extend(b.options,c);this._adjustSettings(a,b,c.until!=null||c.since!=null||d);var e=new Date();if((b._since&&b._since<e)||(b._until&&b._until>e)){this._addElem(a[0])}this._updateCountdown(a,b)},_updateCountdown:function(a,b){a=a.jquery?a:$(a);b=b||a.data(this.name);if(!b){return}a.html(this._generateHTML(b)).toggleClass(this._rtlClass,b.options.isRTL);if($.isFunction(b.options.onTick)){var c=b._hold!='lap'?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date());if(b.options.tickInterval==1||this.periodsToSeconds(c)%b.options.tickInterval==0){b.options.onTick.apply(a[0],[c])}}var d=b._hold!='pause'&&(b._since?b._now.getTime()<b._since.getTime():b._now.getTime()>=b._until.getTime());if(d&&!b._expiring){b._expiring=true;if(this._hasElem(a[0])||b.options.alwaysExpire){this._removeElem(a[0]);if($.isFunction(b.options.onExpiry)){b.options.onExpiry.apply(a[0],[])}if(b.options.expiryText){var e=b.options.layout;b.options.layout=b.options.expiryText;this._updateCountdown(a[0],b);b.options.layout=e}if(b.options.expiryUrl){window.location=b.options.expiryUrl}}b._expiring=false}else if(b._hold=='pause'){this._removeElem(a[0])}},_resetExtraLabels:function(a,b){var c=false;for(var n in b){if(n!='whichLabels'&&n.match(/[Ll]abels/)){c=true;break}}if(c){for(var n in a){if(n.match(/[Ll]abels[02-9]|compactLabels1/)){a[n]=null}}}},_adjustSettings:function(a,b,c){var d;var e=0;var f=null;for(var i=0;i<this._serverSyncs.length;i++){if(this._serverSyncs[i][0]==b.options.serverSync){f=this._serverSyncs[i][1];break}}if(f!=null){e=(b.options.serverSync?f:0);d=new Date()}else{var g=($.isFunction(b.options.serverSync)?b.options.serverSync.apply(a[0],[]):null);d=new Date();e=(g?d.getTime()-g.getTime():0);this._serverSyncs.push([b.options.serverSync,e])}var h=b.options.timezone;h=(h==null?-d.getTimezoneOffset():h);if(c||(!c&&b._until==null&&b._since==null)){b._since=b.options.since;if(b._since!=null){b._since=this.UTCDate(h,this._determineTime(b._since,null));if(b._since&&e){b._since.setMilliseconds(b._since.getMilliseconds()+e)}}b._until=this.UTCDate(h,this._determineTime(b.options.until,d));if(e){b._until.setMilliseconds(b._until.getMilliseconds()+e)}}b._show=this._determineShow(b)},_preDestroy:function(a,b){this._removeElem(a[0]);a.empty()},pause:function(a){this._hold(a,'pause')},lap:function(a){this._hold(a,'lap')},resume:function(a){this._hold(a,null)},toggle:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'pause':'resume'](a)},toggleLap:function(a){var b=$.data(a,this.name)||{};this[!b._hold?'lap':'resume'](a)},_hold:function(a,b){var c=$.data(a,this.name);if(c){if(c._hold=='pause'&&!b){c._periods=c._savePeriods;var d=(c._since?'-':'+');c[c._since?'_since':'_until']=this._determineTime(d+c._periods[0]+'y'+d+c._periods[1]+'o'+d+c._periods[2]+'w'+d+c._periods[3]+'d'+d+c._periods[4]+'h'+d+c._periods[5]+'m'+d+c._periods[6]+'s');this._addElem(a)}c._hold=b;c._savePeriods=(b=='pause'?c._periods:null);$.data(a,this.name,c);this._updateCountdown(a,c)}},getTimes:function(a){var b=$.data(a,this.name);return(!b?null:(b._hold=='pause'?b._savePeriods:(!b._hold?b._periods:this._calculatePeriods(b,b._show,b.options.significant,new Date()))))},_determineTime:function(k,l){var m=this;var n=function(a){var b=new Date();b.setTime(b.getTime()+a*1000);return b};var o=function(a){a=a.toLowerCase();var b=new Date();var c=b.getFullYear();var d=b.getMonth();var e=b.getDate();var f=b.getHours();var g=b.getMinutes();var h=b.getSeconds();var i=/([+-]?[0-9]+)\s*(s|m|h|d|w|o|y)?/g;var j=i.exec(a);while(j){switch(j[2]||'s'){case's':h+=parseInt(j[1],10);break;case'm':g+=parseInt(j[1],10);break;case'h':f+=parseInt(j[1],10);break;case'd':e+=parseInt(j[1],10);break;case'w':e+=parseInt(j[1],10)*7;break;case'o':d+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break;case'y':c+=parseInt(j[1],10);e=Math.min(e,m._getDaysInMonth(c,d));break}j=i.exec(a)}return new Date(c,d,e,f,g,h,0)};var p=(k==null?l:(typeof k=='string'?o(k):(typeof k=='number'?n(k):k)));if(p)p.setMilliseconds(0);return p},_getDaysInMonth:function(a,b){return 32-new Date(a,b,32).getDate()},_normalLabels:function(a){return a},_generateHTML:function(c){var d=this;c._periods=(c._hold?c._periods:this._calculatePeriods(c,c._show,c.options.significant,new Date()));var e=false;var f=0;var g=c.options.significant;var h=$.extend({},c._show);for(var i=Y;i<=S;i++){e|=(c._show[i]=='?'&&c._periods[i]>0);h[i]=(c._show[i]=='?'&&!e?null:c._show[i]);f+=(h[i]?1:0);g-=(c._periods[i]>0?1:0)}var j=[false,false,false,false,false,false,false];for(var i=S;i>=Y;i--){if(c._show[i]){if(c._periods[i]){j[i]=true}else{j[i]=g>0;g--}}}var k=(c.options.compact?c.options.compactLabels:c.options.labels);var l=c.options.whichLabels||this._normalLabels;var m=function(a){var b=c.options['compactLabels'+l(c._periods[a])];return(h[a]?d._translateDigits(c,c._periods[a])+(b?b[a]:k[a])+' ':'')};var n=(c.options.padZeroes?2:1);var o=function(a){var b=c.options['labels'+l(c._periods[a])];return((!c.options.significant&&h[a])||(c.options.significant&&j[a])?'<span class="'+d._sectionClass+'">'+'<span class="'+d._amountClass+'">'+d._minDigits(c,c._periods[a],n)+'</span>'+'<span class="'+d._periodClass+'">'+(b?b[a]:k[a])+'</span></span>':'')};return(c.options.layout?this._buildLayout(c,h,c.options.layout,c.options.compact,c.options.significant,j):((c.options.compact?'<span class="'+this._rowClass+' '+this._amountClass+(c._hold?' '+this._holdingClass:'')+'">'+m(Y)+m(O)+m(W)+m(D)+(h[H]?this._minDigits(c,c._periods[H],2):'')+(h[M]?(h[H]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[M],2):'')+(h[S]?(h[H]||h[M]?c.options.timeSeparator:'')+this._minDigits(c,c._periods[S],2):''):'<span class="'+this._rowClass+' '+this._showClass+(c.options.significant||f)+(c._hold?' '+this._holdingClass:'')+'">'+o(Y)+o(O)+o(W)+o(D)+o(H)+o(M)+o(S))+'</span>'+(c.options.description?'<span class="'+this._rowClass+' '+this._descrClass+'">'+c.options.description+'</span>':'')))},_buildLayout:function(c,d,e,f,g,h){var j=c.options[f?'compactLabels':'labels'];var k=c.options.whichLabels||this._normalLabels;var l=function(a){return(c.options[(f?'compactLabels':'labels')+k(c._periods[a])]||j)[a]};var m=function(a,b){return c.options.digits[Math.floor(a/b)%10]};var o={desc:c.options.description,sep:c.options.timeSeparator,yl:l(Y),yn:this._minDigits(c,c._periods[Y],1),ynn:this._minDigits(c,c._periods[Y],2),ynnn:this._minDigits(c,c._periods[Y],3),y1:m(c._periods[Y],1),y10:m(c._periods[Y],10),y100:m(c._periods[Y],100),y1000:m(c._periods[Y],1000),ol:l(O),on:this._minDigits(c,c._periods[O],1),onn:this._minDigits(c,c._periods[O],2),onnn:this._minDigits(c,c._periods[O],3),o1:m(c._periods[O],1),o10:m(c._periods[O],10),o100:m(c._periods[O],100),o1000:m(c._periods[O],1000),wl:l(W),wn:this._minDigits(c,c._periods[W],1),wnn:this._minDigits(c,c._periods[W],2),wnnn:this._minDigits(c,c._periods[W],3),w1:m(c._periods[W],1),w10:m(c._periods[W],10),w100:m(c._periods[W],100),w1000:m(c._periods[W],1000),dl:l(D),dn:this._minDigits(c,c._periods[D],1),dnn:this._minDigits(c,c._periods[D],2),dnnn:this._minDigits(c,c._periods[D],3),d1:m(c._periods[D],1),d10:m(c._periods[D],10),d100:m(c._periods[D],100),d1000:m(c._periods[D],1000),hl:l(H),hn:this._minDigits(c,c._periods[H],1),hnn:this._minDigits(c,c._periods[H],2),hnnn:this._minDigits(c,c._periods[H],3),h1:m(c._periods[H],1),h10:m(c._periods[H],10),h100:m(c._periods[H],100),h1000:m(c._periods[H],1000),ml:l(M),mn:this._minDigits(c,c._periods[M],1),mnn:this._minDigits(c,c._periods[M],2),mnnn:this._minDigits(c,c._periods[M],3),m1:m(c._periods[M],1),m10:m(c._periods[M],10),m100:m(c._periods[M],100),m1000:m(c._periods[M],1000),sl:l(S),sn:this._minDigits(c,c._periods[S],1),snn:this._minDigits(c,c._periods[S],2),snnn:this._minDigits(c,c._periods[S],3),s1:m(c._periods[S],1),s10:m(c._periods[S],10),s100:m(c._periods[S],100),s1000:m(c._periods[S],1000)};var p=e;for(var i=Y;i<=S;i++){var q='yowdhms'.charAt(i);var r=new RegExp('\\{'+q+'<\\}([\\s\\S]*)\\{'+q+'>\\}','g');p=p.replace(r,((!g&&d[i])||(g&&h[i])?'$1':''))}$.each(o,function(n,v){var a=new RegExp('\\{'+n+'\\}','g');p=p.replace(a,v)});return p},_minDigits:function(a,b,c){b=''+b;if(b.length>=c){return this._translateDigits(a,b)}b='0000000000'+b;return this._translateDigits(a,b.substr(b.length-c))},_translateDigits:function(b,c){return(''+c).replace(/[0-9]/g,function(a){return b.options.digits[a]})},_determineShow:function(a){var b=a.options.format;var c=[];c[Y]=(b.match('y')?'?':(b.match('Y')?'!':null));c[O]=(b.match('o')?'?':(b.match('O')?'!':null));c[W]=(b.match('w')?'?':(b.match('W')?'!':null));c[D]=(b.match('d')?'?':(b.match('D')?'!':null));c[H]=(b.match('h')?'?':(b.match('H')?'!':null));c[M]=(b.match('m')?'?':(b.match('M')?'!':null));c[S]=(b.match('s')?'?':(b.match('S')?'!':null));return c},_calculatePeriods:function(c,d,e,f){c._now=f;c._now.setMilliseconds(0);var g=new Date(c._now.getTime());if(c._since){if(f.getTime()<c._since.getTime()){c._now=f=g}else{f=c._since}}else{g.setTime(c._until.getTime());if(f.getTime()>c._until.getTime()){c._now=f=g}}var h=[0,0,0,0,0,0,0];if(d[Y]||d[O]){var i=this._getDaysInMonth(f.getFullYear(),f.getMonth());var j=this._getDaysInMonth(g.getFullYear(),g.getMonth());var k=(g.getDate()==f.getDate()||(g.getDate()>=Math.min(i,j)&&f.getDate()>=Math.min(i,j)));var l=function(a){return(a.getHours()*60+a.getMinutes())*60+a.getSeconds()};var m=Math.max(0,(g.getFullYear()-f.getFullYear())*12+g.getMonth()-f.getMonth()+((g.getDate()<f.getDate()&&!k)||(k&&l(g)<l(f))?-1:0));h[Y]=(d[Y]?Math.floor(m/12):0);h[O]=(d[O]?m-h[Y]*12:0);f=new Date(f.getTime());var n=(f.getDate()==i);var o=this._getDaysInMonth(f.getFullYear()+h[Y],f.getMonth()+h[O]);if(f.getDate()>o){f.setDate(o)}f.setFullYear(f.getFullYear()+h[Y]);f.setMonth(f.getMonth()+h[O]);if(n){f.setDate(o)}}var p=Math.floor((g.getTime()-f.getTime())/1000);var q=function(a,b){h[a]=(d[a]?Math.floor(p/b):0);p-=h[a]*b};q(W,604800);q(D,86400);q(H,3600);q(M,60);q(S,1);if(p>0&&!c._since){var r=[1,12,4.3482,7,24,60,60];var s=S;var t=1;for(var u=S;u>=Y;u--){if(d[u]){if(h[s]>=t){h[s]=0;p=1}if(p>0){h[u]++;p=0;s=u;t=1}}t*=r[u]}}if(e){for(var u=Y;u<=S;u++){if(e&&h[u]){e--}else if(!e){h[u]=0}}}return h}})})(jQuery);

}
/*
 * Tabiy Slidiy mSlidiy Formiy
 * (c) 2011 by David. <http://www.shopiy.com/>
 */

/*
 * Tabiy
 * Shopiy.com
 */
(function($) 
{
var tabsCount = 1;
$.fn.Tabiy = function()
{
	var container = $(this);
	var box = container.find('.box[id!=""]');
	var otherBox = container.find('.box[id=""]');

	if (box.length > 0)
	{
		var tabs = '<div class="tab_wrapper"><p class="tabs" id="tabs-' + tabsCount + '"></p><div class="extra"></div></div>';
		container.prepend(tabs);
		var tabsWrap = $('#tabs-' + tabsCount + '');
		var tabsHeight = tabsWrap.outerHeight() + 7;
		box.hide().css({paddingTop: (tabsHeight), marginTop: -tabsHeight});
		box.find('.hd').hide();

		box.each(function(n) 
		{
			var supText = $(this).find('.hd .extra em').text();
			supText = (supText.length < 1) ? '' : '<sup><em>' + supText + '</em></sup>';
			tabsWrap.append('<a href="#' + $(this).attr('id') + '" id="tab-' + $(this).attr('id') + '"><span>' + $(this).find('.hd h3').text() + supText + '</span></a>');
		});

		otherBox.detach();
		container.append(otherBox);
		var linkBox = container.find(location.hash);

		if (linkBox.length == 1) 
		{
			$('#tab-' + location.hash.slice(1) + '').addClass('current');
			linkBox.show();
		}
		else
		{
			$('#tabs-' + tabsCount + ' a:eq(0)').addClass('current');
			box.eq(0).show();
		};

		$('#tabs-' + tabsCount + ' a').click(function()
		{
			$(this).addClass('current').siblings().removeClass('current');
			container.find('.box[id!=""]').hide();

			$('#' + $(this).attr('id').slice(4) + '').fadeIn('fast');
			return false;
		});
	};
	tabsCount++;
};
})(jQuery);
/*
 * Slidiy
 * Shopiy.com
 */
(function($) {
var sliderCount = 1;
$.fn.Slidiy = function()
{
	var slider			= $(this);
	var item			= slider.find('li');
	var currentSlide	= -1;
	var prevSlide		= null;
	var interval		= null;
	var sliderIndex		= sliderCount;
	var html			= '<p class="triggers">';

	item.css({position:'absolute'}).slice(1).hide();
	for (var i = 0 ;i <= item.length - 1; i++)
	{
		var url = slider.find('a').eq(i).attr('href');
		html += '<a href="'+ url +'" id="slide' + sliderIndex + i +'">'+ (i+1) +'</a>' ;
	}

	html += '</p>';
	slider.find('ul').after(html);
	var triggers = slider.find('.triggers');
	for (var i = 0 ;i <= item.length - 1; i++)
	{
		$('#slide' + sliderCount + i).bind('mouseover',{index:i},function(event)
		{
			currentSlide = event.data.index;
			gotoSlide(event.data.index, sliderIndex);
		});
	};

	if (item.length <= 1)
	{
		triggers.hide();
	}

	nextSlide();
	function nextSlide ()
	{
		if (currentSlide >= item.length -1)
		{
			currentSlide = 0;
		}
		else
		{
			currentSlide++
		}

		gotoSlide(currentSlide, sliderIndex);
	}

	function gotoSlide(slideNum, sliderIndex)
	{
		if (slideNum != prevSlide)
		{
			if (prevSlide != null)
			{
				item.eq(prevSlide).css({opacity:'1',zIndex:'0'}).stop().animate({opacity: 0}, 300);
				//$('#slide' + sliderCount + prevSlide).removeClass('current');
			}

			var currenTrigger = $('#slide' + sliderIndex + slideNum);
			currenTrigger.addClass('current').siblings().removeClass('current');
			item.eq(slideNum).show().css({opacity:'0',zIndex:'1'}).stop().animate({opacity: 1}, 300);

			prevSlide = currentSlide;
			if (interval != null)
			{
				clearInterval(interval);
			}

			interval = setInterval(nextSlide, 6000);
		}
	}
	sliderCount++;
};
})(jQuery);

/* mSlidiy */
(function($) {
	$.fn.mSlidiy = function(options){
		var defaults = {
			num:			4,
			controls:		true,
			vertical:		false,
			speed:			200,
			step:			4,
			auto:			false,
			pause:			2000,
			continuous:		true,
			controlsFade:	false,
			html:			'<p class="controls"><a href="javascript:void(0);" class="prev">Previous</a><a href="javascript:void(0);" class="next">Next</a></p>'
		};
		var options = $.extend(defaults, options);
		this.each(function() {
			var obj = $(this);
			$('.clearer', obj).remove();
			$('.first_child', obj).removeClass('first_child');
			var s = $('li', obj).length;
			var w = $('li', obj).outerWidth();
			var h = $('li', obj).outerHeight();
			var maxh = 0;
			$('li', obj).each(function() {
				var thisHeight = $(this).outerHeight();
				if(thisHeight > maxh) {
					maxh = thisHeight;
				}
			});
			var maxih = 0;
			$('li', obj).each(function() {
				var thisInnerHeight = $(this).height();
				if(thisInnerHeight > maxih) {
					maxih = thisInnerHeight;
				}
			});
			obj.css('overflow-x','hidden');
			if(!options.vertical) {
				obj.width(w*options.num);
				//obj.height(maxh);
				$('ul', obj).css('width',s*w);
			} else {
				obj.width(w);
				if (s < options.num) {
					obj.height(maxh*s);
				} else {
					obj.height(maxh*options.num);
				}
				$('ul', obj).css('height',s*maxh);
				//$('li', obj).css({height: maxih, overflow:'hidden'});
			};
			var ts = s-1;
			var t = 0;
			if(options.controls && (s>options.num)){obj.after(options.html);};
			var nextBtn = $('.next', obj.parent());
			var prevBtn = $('.prev', obj.parent());
			nextBtn.click(function(){animate('next',true);});
			prevBtn.click(function(){animate('prev',true);});
			
			function animate(dir,clicked){
				var ot = t;
				switch(dir){
					case 'next':
						t = (ot+options.num>ts) ? (options.continuous ? 0 : ot) : t+options.step;
						break;
					case 'prev':
						t = (t<=0) ? (options.continuous ? ts-options.num+1 : 0) : t-options.step;
						break;
					default:
						break;
				};	
				
				var diff = Math.abs(ot-t);
				var speed = diff*options.speed;
				if(!options.vertical) {
					p = (t*w*-1);
					$('ul',obj).animate(
						{ marginLeft: p },
						speed
					);
				} else {
					p = (t*h*-1);
					$('ul',obj).animate(
						{ marginTop: p },
						speed
					);
				};
				
				if(!options.continuous && options.controlsFade){
					if(t==ts-ts%options.num){
						nextBtn.hide();
					} else {
						nextBtn.show();
					};
					if(t==0){
						prevBtn.hide();
					} else {
						prevBtn.show();
					};
				};
				
				if(clicked) clearTimeout(timeout);
				if(options.auto && dir=='next' && !clicked){;
					timeout = setTimeout(function(){
						animate('next',false);
					},diff*options.speed+options.pause);
				};
				
			};
			var timeout;
			if(options.auto){
				timeout = setTimeout(function(){
					animate('next',false);
				},options.pause);
			};		
		
			if(!options.continuous && options.controlsFade){
				prevBtn.hide();
			};
			
		});
	  
	};

})(jQuery);

(function($) {
$.fn.Formiy = function(){
	var area = $(this);
	var label = area.find('label');
	var input = area.find('input');
	input.hide();
	label.has(':checked').addClass('checked');
	label.hover(function(){
		$(this).toggleClass('hover');
	});
	label.click(function(){
		if ($(this).children('input').is(':radio')) {
			$(this).addClass('checked').siblings().removeClass('checked');
			$(this).children('input').attr('checked','checked');
			$(this).siblings().children('input').removeAttr('checked');
		} else if ($(this).children('input').is(':checkbox')) {
			$(this).toggleClass('checked');
			if ($(this).children('input').attr('checked')) {
				$(this).children('input').removeAttr('checked');
			} else {
				$(this).children('input').attr('checked','checked');
			}
		}
		if (typeof(goodsId) != 'undefined') {
			$('#purchase_form').ChangePriceSiy();
		}
		return false;
	});
};
})(jQuery);

/**
 * HoverScroll jQuery Plugin
 *
 * Make an unordered list scrollable by hovering the mouse over it
 *
 * @author RasCarlito <carl.ogren@gmail.com>
 * @version 0.2.3
 * @revision 19
 */
(function(c){c.fn.hoverscroll=function(a){a||(a={});a=c.extend({},c.fn.hoverscroll.params,a);this.each(function(){function p(e,f){e-=b.offset().left;f-=b.offset().top;e=a.vertical?f:e;for(i in l)if(e>=l[i].from&&e<l[i].to)l[i].action=="move"?q(l[i].direction,l[i].speed):n()}function r(){if(!(!a.arrows||a.fixedArrows)){var e,f;if(a.vertical){e=g[0].scrollHeight-g.height();f=g[0].scrollTop}else{e=g[0].scrollWidth-g.width();f=g[0].scrollLeft}f=f/e;var m=a.arrowsOpacity;if(isNaN(f))f=0;var o=false;if(f<=
0){c("div.arrow.left, div.arrow.top",b).hide();o=true}if(f>=m||e<=0){c("div.arrow.right, div.arrow.bottom",b).hide();o=true}if(!o){c("div.arrow.left, div.arrow.top",b).show().css("opacity",f>m?m:f);c("div.arrow.right, div.arrow.bottom",b).show().css("opacity",1-f>m?m:1-f)}}}function q(e,f){if(b[0].direction!=e){a.debug&&c.log("[HoverScroll] Starting to move. direction: "+e+", speed: "+f);n();b[0].direction=e;b[0].isChanging=true;s()}if(b[0].speed!=f){a.debug&&c.log("[HoverScroll] Changed speed: "+
f);b[0].speed=f}}function n(){if(b[0].isChanging){a.debug&&c.log("[HoverScroll] Stoped moving");b[0].isChanging=false;b[0].direction=0;b[0].speed=1;clearTimeout(b[0].timer)}}function s(){if(b[0].isChanging!=false){r();g[0][a.vertical?"scrollTop":"scrollLeft"]+=b[0].direction*b[0].speed;b[0].timer=setTimeout(function(){s()},50)}}var k=c(this);a.debug&&c.log("[HoverScroll] Trying to create hoverscroll on element "+this.tagName+"#"+this.id);a.fixedArrows?k.wrap('<div class="fixed-listcontainer"></div>'):
k.wrap('<div class="listcontainer"></div>');k.addClass("list");var g=k.parent();g.wrap('<div class="ui-widget-content hoverscroll"></div>');var b=g.parent(),h,j;if(a.arrows)if(a.vertical)if(a.fixedArrows){h='<div class="fixed-arrow top"></div>';j='<div class="fixed-arrow bottom"></div>';g.before(h).after(j)}else{h='<div class="arrow top"></div>';j='<div class="arrow bottom"></div>';g.append(h).append(j)}else if(a.fixedArrows){h='<div class="fixed-arrow left"></div>';j='<div class="fixed-arrow right"></div>';
g.before(h).after(j)}else{h='<div class="arrow left"></div>';j='<div class="arrow right"></div>';g.append(h).append(j)}b.width(a.width).height(a.height);if(a.arrows&&a.fixedArrows)if(a.vertical){h=g.prev();j=g.next();g.width(a.width).height(a.height-(h.height()+j.height()))}else{h=g.prev();j=g.next();g.height(a.height).width(a.width-(h.width()+j.width()))}else g.width(a.width).height(a.height);var d=0;if(a.vertical){b.addClass("vertical");k.children().each(function(){c(this).addClass("item");d+=c(this).outerHeight?
c(this).outerHeight(true):c(this).height()+parseInt(c(this).css("padding-top"))+parseInt(c(this).css("padding-bottom"))+parseInt(c(this).css("margin-bottom"))+parseInt(c(this).css("margin-bottom"))});k.height(d);a.debug&&c.log("[HoverScroll] Computed content height : "+d+"px");d=b.outerHeight?b.outerHeight():b.height()+parseInt(b.css("padding-top"))+parseInt(b.css("padding-bottom"))+parseInt(b.css("margin-top"))+parseInt(b.css("margin-bottom"));a.debug&&c.log("[HoverScroll] Computed container height : "+
d+"px")}else{b.addClass("horizontal");k.children().each(function(){c(this).addClass("item");var e=c(this).clone();e.addClass("hoverscroll_item");e.hasClass("current")&&e.addClass("hoverscroll_item_current");e.css("visibility","hidden");c("body").append(e);var f=e.outerWidth(true);d+=f;e.remove()});k.width(d);a.debug&&c.log("[HoverScroll] Computed content width : "+d+"px");d=b.outerWidth?b.outerWidth():b.width()+parseInt(b.css("padding-left"))+parseInt(b.css("padding-right"))+parseInt(b.css("margin-left"))+
parseInt(b.css("margin-right"));a.debug&&c.log("[HoverScroll] Computed container width : "+d+"px")}var l={1:{action:"move",from:0,to:0.06*d,direction:-1,speed:16},2:{action:"move",from:0.06*d,to:0.15*d,direction:-1,speed:8},3:{action:"move",from:0.15*d,to:0.25*d,direction:-1,speed:4},4:{action:"move",from:0.25*d,to:0.4*d,direction:-1,speed:2},5:{action:"stop",from:0.4*d,to:0.6*d},6:{action:"move",from:0.6*d,to:0.75*d,direction:1,speed:2},7:{action:"move",from:0.75*d,to:0.85*d,direction:1,speed:4},
8:{action:"move",from:0.85*d,to:0.94*d,direction:1,speed:8},9:{action:"move",from:0.94*d,to:d,direction:1,speed:16}};b[0].isChanging=false;b[0].direction=0;b[0].speed=1;b.mousemove(function(e){p(e.pageX,e.pageY)}).bind("mouseleave",function(){n()});this.startMoving=q;this.stopMoving=n;a.arrows&&!a.fixedArrows?r():c(".arrowleft, .arrowright, .arrowtop, .arrowbottom",b).hide()});return this};if(!c.fn.offset)c.fn.offset=function(){this.left=this.top=0;if(this[0]&&this[0].offsetParent){var a=this[0];
do{this.left+=a.offsetLeft;this.top+=a.offsetTop}while(a=a.offsetParent)}return this};c.fn.hoverscroll.params={vertical:false,width:400,height:50,arrows:true,arrowsOpacity:0.7,fixedArrows:false,debug:false};c.log=function(){try{console.log.apply(console,arguments)}catch(a){try{opera.postError.apply(opera,arguments)}catch(p){}}}})(jQuery);


jQuery.fn.liveSearch = function (conf) {
	var config = jQuery.extend({
		url:			'live_search.php?q=',//david
		id:				'live_search',//david
		duration:		400, 
		typeDelay:		200,
		loadingClass:	'loading',
		loader:			'<div class="loader">&nbsp;</div>',//david
		onSlideUp:		function () {}, 
		uptadePosition:	false
	}, conf);

	var liveSearch	= jQuery('#' + config.id);
	if (!liveSearch.length) {
		liveSearch = jQuery('<div id="' + config.id + '"></div>')
						.appendTo(document.body)
						.hide()
						.slideUp(0);
		jQuery(document.body).click(function(event) {
			var clicked = jQuery(event.target);
			if (!(clicked.is('#' + config.id) || clicked.parents('#' + config.id).length || clicked.is('input'))) {
				liveSearch.slideUp(config.duration, function () {
					config.onSlideUp();
				});
			}
		});
	}

	return this.each(function () {
		var input							= jQuery(this).attr('autocomplete', 'off');
		var liveSearchPaddingBorderHoriz	= parseInt(liveSearch.css('paddingLeft'), 10) + parseInt(liveSearch.css('paddingRight'), 10) + parseInt(liveSearch.css('borderLeftWidth'), 10) + parseInt(liveSearch.css('borderRightWidth'), 10);
		input.after(config.loader);//david
		var repositionLiveSearch = function () {
			var tmpOffset	= input.offset();
			var inputDim	= {
				left:		tmpOffset.left, 
				top:		tmpOffset.top, 
				width:		input.outerWidth(), 
				height:		input.outerHeight()
			};

			inputDim.topPos		= inputDim.top + inputDim.height;
			inputDim.totalWidth	= inputDim.width - liveSearchPaddingBorderHoriz;

			liveSearch.css({
				position:	'absolute', 
				left:		inputDim.left - 1 + 'px',//david
				top:		inputDim.topPos + 'px',
				width:		inputDim.totalWidth + 32 + 'px'//david
			});
		};
		var showLiveSearch = function () {
			repositionLiveSearch();
			$(window).unbind('resize', repositionLiveSearch);
			$(window).bind('resize', repositionLiveSearch);
			liveSearch.slideDown(config.duration);
		};
		var hideLiveSearch = function () {
			liveSearch.slideUp(config.duration, function () {
				config.onSlideUp();
			});
		};

		input.focus(function () {
				if (this.value !== '') {
					if (liveSearch.html() == '') {
						this.lastValue = '';
						input.keyup();
					}
					else {
						setTimeout(showLiveSearch, 1);
					}
				}
			})
			// Auto update live-search onkeyup
			.keyup(function () {
				// Don't update live-search if it's got the same value as last time
				if (this.value != this.lastValue) {
					input.addClass(config.loadingClass);
					input.next('.loader').css({visibility:'visible'}).fadeTo(0, 1000);//david

					var q = encodeURI(this.value);//david

					// Stop previous ajax-request
					if (this.timer) {
						clearTimeout(this.timer);
					}

					// Start a new ajax-request in X ms
					this.timer = setTimeout(function () {
						jQuery.get(config.url + q, function (data) {
							input.removeClass(config.loadingClass);
							input.next('.loader').fadeTo(1000, 0);//david

							// Show live-search if results and search-term aren't empty
							if (data.length && q.length) {
								liveSearch.html(data);
								showLiveSearch();
							}
							else {
								hideLiveSearch();
							}
						});
					}, config.typeDelay);

					this.lastValue = this.value;
				}
			});
	});
};

/**
 * jQuery Cookie plugin
 *
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
jQuery.cookie = function (key, value, options) {
    
    // key and at least value given, set cookie...
    if (arguments.length > 1 && String(value) !== "[object Object]") {
        options = jQuery.extend({}, options);

        if (value === null || value === undefined) {
            options.expires = -1;
        }

        if (typeof options.expires === 'number') {
            var days = options.expires, t = options.expires = new Date();
            t.setDate(t.getDate() + days);
        }
        
        value = String(value);
        
        return (document.cookie = [
            encodeURIComponent(key), '=',
            options.raw ? value : encodeURIComponent(value),
            options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
            options.path ? '; path=' + options.path : '',
            options.domain ? '; domain=' + options.domain : '',
            options.secure ? '; secure' : ''
        ].join(''));
    }

    // key and possibly options given, get cookie...
    options = value || {};
    var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent;
    return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
};
/*
 * Lazy Load - jQuery plugin for lazy loading images
 * Copyright (c) 2007-2013 Mika Tuupola
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 * Version:  1.8.4
 */
(function(a,b,c,d){var e=a(b);a.fn.lazyload=function(c){function i(){var b=0;f.each(function(){var c=a(this);if(h.skip_invisible&&!c.is(":visible"))return;if(!a.abovethetop(this,h)&&!a.leftofbegin(this,h))if(!a.belowthefold(this,h)&&!a.rightoffold(this,h))c.trigger("appear"),b=0;else if(++b>h.failure_limit)return!1})}var f=this,g,h={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:b,data_attribute:"original",skip_invisible:!0,appear:null,load:null};return c&&(d!==c.failurelimit&&(c.failure_limit=c.failurelimit,delete c.failurelimit),d!==c.effectspeed&&(c.effect_speed=c.effectspeed,delete c.effectspeed),a.extend(h,c)),g=h.container===d||h.container===b?e:a(h.container),0===h.event.indexOf("scroll")&&g.bind(h.event,function(a){return i()}),this.each(function(){var b=this,c=a(b);b.loaded=!1,c.one("appear",function(){if(!this.loaded){if(h.appear){var d=f.length;h.appear.call(b,d,h)}a("<img />").bind("load",function(){c.hide().attr("src",c.data(h.data_attribute))[h.effect](h.effect_speed),b.loaded=!0;var d=a.grep(f,function(a){return!a.loaded});f=a(d);if(h.load){var e=f.length;h.load.call(b,e,h)}}).attr("src",c.data(h.data_attribute))}}),0!==h.event.indexOf("scroll")&&c.bind(h.event,function(a){b.loaded||c.trigger("appear")})}),e.bind("resize",function(a){i()}),/iphone|ipod|ipad.*os 5/gi.test(navigator.appVersion)&&e.bind("pageshow",function(b){b.originalEvent.persisted&&f.each(function(){a(this).trigger("appear")})}),a(b).load(function(){i()}),this},a.belowthefold=function(c,f){var g;return f.container===d||f.container===b?g=e.height()+e.scrollTop():g=a(f.container).offset().top+a(f.container).height(),g<=a(c).offset().top-f.threshold},a.rightoffold=function(c,f){var g;return f.container===d||f.container===b?g=e.width()+e.scrollLeft():g=a(f.container).offset().left+a(f.container).width(),g<=a(c).offset().left-f.threshold},a.abovethetop=function(c,f){var g;return f.container===d||f.container===b?g=e.scrollTop():g=a(f.container).offset().top,g>=a(c).offset().top+f.threshold+a(c).height()},a.leftofbegin=function(c,f){var g;return f.container===d||f.container===b?g=e.scrollLeft():g=a(f.container).offset().left,g>=a(c).offset().left+f.threshold+a(c).width()},a.inviewport=function(b,c){return!a.rightoffold(b,c)&&!a.leftofbegin(b,c)&&!a.belowthefold(b,c)&&!a.abovethetop(b,c)},a.extend(a.expr[":"],{"below-the-fold":function(b){return a.belowthefold(b,{threshold:0})},"above-the-top":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-screen":function(b){return a.rightoffold(b,{threshold:0})},"left-of-screen":function(b){return!a.rightoffold(b,{threshold:0})},"in-viewport":function(b){return a.inviewport(b,{threshold:0})},"above-the-fold":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-fold":function(b){return a.rightoffold(b,{threshold:0})},"left-of-fold":function(b){return!a.rightoffold(b,{threshold:0})}})})(jQuery,window,document);
/*
* Timeliner.js
* @copyright	Tarek Anandan (http://www.technotarek.com)
*/
;(function($) {
        $.timeliner = function(options) {
            if ($.timeliners == null) {
                $.timeliners = { options: [] };
                $.timeliners.options.push(options);
            }
            else {
                $.timeliners.options.push(options);
            }
            $(document).ready(function() {
                for (var i=0; i<$.timeliners.options.length; i++) {
                    startTimeliner($.timeliners.options[i]);
                }
            });
        }
        function startTimeliner(options){
            var settings = {
                timelineContainer: options['timelineContainer'] || '#timelineContainer',
                startState: options['startState'] || 'closed',
                startOpen: options['startOpen'] || [],
                baseSpeed: options['baseSpeed'] || 200,
                speed: options['speed'] || 4,
                fontOpen: options['fontOpen'] || '1.2em',
                fontClosed: options['fontClosed'] || '1em'
            };

            function openEvent(eventHeading,eventBody) {
                $(eventHeading)
                    .removeClass('closed')
                    .addClass('open')
                    .animate({ fontSize: settings.fontOpen }, settings.baseSpeed);
                $(eventBody).show(settings.speed*settings.baseSpeed);
            }

            function closeEvent(eventHeading,eventBody) {
                $(eventHeading)
                    .animate({ fontSize: settings.fontClosed }, 0)
                    .removeClass('open')
                    .addClass('closed');
                $(eventBody).hide(settings.speed*settings.baseSpeed);
            }


            if ($(settings.timelineContainer).data('started')) {
                return;
            } else {
                $(settings.timelineContainer).data('started', true);
			if(settings.startState==='closed')
			{
                $(settings.timelineContainer+" "+".timelineEvent").hide();
				$.each($(settings.startOpen), function(index, value) {
                    openEvent($(value).parent(settings.timelineContainer+" "+".timelineMinor").find("dt a"),$(value));
				});
			}else{
                openEvent($(settings.timelineContainer+" "+".timelineMinor dt a"),$(settings.timelineContainer+" "+".timelineEvent"));
			}

			$('dt',settings.timelineContainer).bind("click",function(){
				var currentId = $(this).attr('id');
				if($(this).find('span').is('.open')) {
					closeEvent($("span",this),$("#"+currentId+"EX"))
				} else{
					openEvent($("span", this),$("#"+currentId+"EX"));
				}
				return;
			});

			$(".timelineMajorMarker",settings.timelineContainer).bind("click",function()
			{
				var numEvents = $(this).parents(".timelineMajor").find(".timelineMinor").length;
				var numOpen = $(this).parents(".timelineMajor").find('.open').length;
				if(numEvents > numOpen )
				{
					openEvent($(this).parents(".timelineMajor").find(".timelineTitle span"),$(this).parents(".timelineMajor").find(".timelineEvent"));
				} else{
					closeEvent($(this).parents(".timelineMajor").find(".timelineTitle span"),$(this).parents(".timelineMajor").find(".timelineEvent"));
				}
			});

            $(settings.timelineContainer+" "+".expandAll").click(function()
			{
				if($(this).hasClass('expanded'))
				{
					closeEvent($(this).parents(settings.timelineContainer).find(".timelineTitle span"),$(this).parents(settings.timelineContainer).find(".timelineEvent"));
					$(this).removeClass('expanded');
				} else{
					openEvent($(this).parents(settings.timelineContainer).find(".timelineTitle span"),$(this).parents(settings.timelineContainer).find(".timelineEvent"));
					$(this).addClass('expanded');

				}
			});
                }
	};
})(jQuery);

/* HTML5 Placeholder jQuery Plugin - v2.1.2
 * Copyright (c)2015 Mathias Bynens
 * 2015-06-09
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof module&&module.exports?require("jquery"):jQuery)}(function(a){function b(b){var c={},d=/^jQuery\d+$/;return a.each(b.attributes,function(a,b){b.specified&&!d.test(b.name)&&(c[b.name]=b.value)}),c}function c(b,c){var d=this,f=a(d);if(d.value==f.attr("placeholder")&&f.hasClass(m.customClass))if(f.data("placeholder-password")){if(f=f.hide().nextAll('input[type="password"]:first').show().attr("id",f.removeAttr("id").data("placeholder-id")),b===!0)return f[0].value=c;f.focus()}else d.value="",f.removeClass(m.customClass),d==e()&&d.select()}function d(){var d,e=this,f=a(e),g=this.id;if(""===e.value){if("password"===e.type){if(!f.data("placeholder-textinput")){try{d=f.clone().prop({type:"text"})}catch(h){d=a("<input>").attr(a.extend(b(this),{type:"text"}))}d.removeAttr("name").data({"placeholder-password":f,"placeholder-id":g}).bind("focus.placeholder",c),f.data({"placeholder-textinput":d,"placeholder-id":g}).before(d)}f=f.removeAttr("id").hide().prevAll('input[type="text"]:first').attr("id",g).show()}f.addClass(m.customClass),f[0].value=f.attr("placeholder")}else f.removeClass(m.customClass)}function e(){try{return document.activeElement}catch(a){}}var f,g,h="[object OperaMini]"==Object.prototype.toString.call(window.operamini),i="placeholder"in document.createElement("input")&&!h,j="placeholder"in document.createElement("textarea")&&!h,k=a.valHooks,l=a.propHooks;if(i&&j)g=a.fn.placeholder=function(){return this},g.input=g.textarea=!0;else{var m={};g=a.fn.placeholder=function(b){var e={customClass:"placeholder"};m=a.extend({},e,b);var f=this;return f.filter((i?"textarea":":input")+"[placeholder]").not("."+m.customClass).bind({"focus.placeholder":c,"blur.placeholder":d}).data("placeholder-enabled",!0).trigger("blur.placeholder"),f},g.input=i,g.textarea=j,f={get:function(b){var c=a(b),d=c.data("placeholder-password");return d?d[0].value:c.data("placeholder-enabled")&&c.hasClass(m.customClass)?"":b.value},set:function(b,f){var g=a(b),h=g.data("placeholder-password");return h?h[0].value=f:g.data("placeholder-enabled")?(""===f?(b.value=f,b!=e()&&d.call(b)):g.hasClass(m.customClass)?c.call(b,!0,f)||(b.value=f):b.value=f,g):b.value=f}},i||(k.input=f,l.value=f),j||(k.textarea=f,l.value=f),a(function(){a(document).delegate("form","submit.placeholder",function(){var b=a("."+m.customClass,this).each(c);setTimeout(function(){b.each(d)},10)})}),a(window).bind("beforeunload.placeholder",function(){a("."+m.customClass).each(function(){this.value=""})})}});
