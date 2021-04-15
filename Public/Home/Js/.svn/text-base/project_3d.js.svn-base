var tdFun = function(_bgBili){
	(function () {
		var scr, ctx, pointer, walls, pics, over, nw, nh,_zeye,camera;
		if(_bgBili>=1){
			_zeye = 190;
		}else{
			_zeye = 220;
		}
		// ---- def camera ----
		camera = {
			x: 0,
			y: 10000,
			z: 500*_bgBili,
			zeye: -_zeye,
			hm: 200,
			visible: true,
			project: function (z) {
				//计算伸缩比例
				z += this.z;
				var scale = this.zeye - z;
				if (scale > 0) scale = -.0001;
				scale = this.zeye / scale;
				if (scale > 100) scale = 100;
				this.visible = (z > this.zeye * .99);
				return scale;
			},
			move: function (x, y, z) {
				//计算移动比例
				this.x += (x - this.x) * 0.1*_bgBili;
				this.y += (y - this.y) * 0.1*_bgBili;
				this.z += (z - this.z) * 0.1;
			}
		};
		// ---- screen resize ----
		var resize = function () {
			nw = scr.width  * 0.5;
			nh = scr.height * 0.5;
		}
		//---- init script ----
		var init = function (data) {
			scr = new ge1doot.Screen({
				container: "screen",
				resize: function () {
					resize();
				}
			});
			ctx = scr.ctx;
			scr.resize();
			// ---- pointer events ----
			pointer = new ge1doot.Pointer({
				tap: function () {
					if (over) {
						
						if (over.focus) {
							if (over.href) {
								// ---- hyperlink ----
								if(over.title == "媒体森林" || over.title=="Media Forest"){

									window.location.href="vankepavilion-thirddmedia.html";
								}
								else{

									$.fancybox.open({
										href : over.href,
										type : 'iframe',
										width: "90%",
										changeSpeed: 100,
										height: 640,
										padding : 0
									});
								}
							} else {
								camera.hm = -100 - over.z * 100;
								over.focus = false;
							}
						} else {
							if(over.bamboo== 0){
							}else{

								if(over.title == "媒体森林" || over.title=="Media Forest"){

									window.location.href="vankepavilion-thirddmedia.html";
								}
								else{

									$.fancybox.open({
										href : over.href,
										type : 'iframe',
										width: "90%",
										changeSpeed: 100,
										height: 640,
										padding : 0
									});
								}

								
							}

															// ---- move camera ----
								camera.hm = -80 - over.z * 100;
								// *_bgBili;
								pointer.bXi = pointer.Xi = (-over.x * 100) - (over.w * 50);
								pointer.bYi = pointer.Yi = ( over.y * 100) + (over.h * 50);
								over.focus = true;
						}
					}
				},
				scale: function () {
					camera.hm -= pointer.scale * 20;
				},
				wheel: function () {
					camera.hm -= -pointer.wheelDelta;
				}
			});
			// ---- create images ----
			walls = data.walls;
			pics = data.pics;
			var i = 0, p;
			while ( p = pics[i++] ) {
				p.img = new Image();
				p.img.src = p.src;
			}
			// ---- start animation ----
			run();
		}
		// ======== main loop ========
		var run = function () {
			ctx.clearRect(0, 0, scr.width, scr.height);
			// ---- cap position -----
			camera.hm = Math.min(Math.max(camera.hm, -250), 200);
			pointer.Xi = Math.min(Math.max(pointer.Xi, -250), 250);
			pointer.Yi = Math.min(Math.max(pointer.Yi, -110), 110);
			// ---- easing camera ----
			camera.move(pointer.Xi, -pointer.Yi, camera.hm);
			// ---- draw walls ----
			ctx.fillStyle = "#000";
			var i = 0, w;
			while ( w = walls[i++] ) {
				ctx.beginPath();
				for (var j = 0; j < 4; j++) {
					var z0 = camera.project(w.z[j] * 100);
					ctx.lineTo(
						nw + (camera.x + w.x[j] * 100) * z0,
						nh + (camera.y + w.y[j] * 100) * z0
					);
				}
				// ctx.closePath();
				// ctx.fill();//底色
			}
			// ---- draw images ----
			over = true;
			ctx.font = 'normal 10px Microsoft Yahei';
			ctx.textAlign = 'center';
			ctx.textBaseline = 'bottom';
			ctx.fillStyle = "#89733c";
			var i = 0, p;
			while ( p = pics[i++] ) {
				// ---- 3D to 2D projection ----
				var scale = camera.project(p.z * 100*_bgBili),
				scale2 = camera.project(p.z * 100);
				if (camera.visible) {
					var x = (camera.x + (p.x * 100)) * scale,
						y = (camera.y + (p.y * 100)) * scale,
						w = p.w * scale * 100,
						h = p.h * scale * 100;
					// ---- draw transparent frame ----
					ctx.beginPath();
					ctx.moveTo(nw + x, nh + y);
					ctx.lineTo(nw + x + w, nh + y);
					ctx.lineTo(nw + x + w, nh + y + h);
					ctx.lineTo(nw + x, nh + y + h);
					ctx.closePath();
					// ctx.fill();
					// ---- pointer over ----
					if (ctx.isPointInPath(pointer.X, pointer.Y)) over = p;
					// ---- draw image ----
					ctx.drawImage(p.img, nw + x + (15 * scale), nh + y + (15 * scale), w - (30 * scale), h - (30 * scale));
					// ---- draw text ----
					ctx.save();
					// ctx.fillStyle = '#f00';
					ctx.translate(nw + (p.w * scale * 50) + x, nh + (scale * 12) + y);
					ctx.scale(scale, scale);
					ctx.fillText(p.title, 0, 0);
					ctx.restore();
				}
			}
			// ---- cursor ----
			scr.setCursor(over ? "pointer" : "default");
			// ---- animation loop ----
			requestAnimFrame(run);
		}
		return {
			// ---- onload event ----
			load : function (data) {
				window.addEventListener('load', function () {
					init(data);
				}, false);
			}
		}
	})().load({
		walls: [
	{x:[-420.52,-420.52,-420.52,-420.52], y:[-420,-420,420,420], z:[-220,220,220,-220]},
{x:[-420.5,420.5,420.5,-420.5], y:[-420,-420,420,420], z:[220,220,220,220]},
{x:[420.52,420.52,420.52,420.52], y:[-420,-420,420,420], z:[220,-220.1,-220.5,220]}
		],
		pics: [
			//竹子背景  展馆设计
			
			{x:-150,  y:-100,  z:11.1,  w:250,   h:154,  src:"img/bamboo/2560/bamboo08.png", title:"", bamboo:"0" },
			{x:-90,  y:-50,  z:10.1,  w:175,   h:105,  src:"img/bamboo/1280/05-4.png", title:"", bamboo:"0" },
			//第三层
			{x:-21.5,  y:-15,  z:0.7,   w:40,   h:30,    src:"img/bamboo/1280/02-2.png", title:"", bamboo:"0" },
			
			//第二层
			{x:-20,  y:-12,  z:-0.7,   w:40,   h:25,    src:"img/bamboo/1280/05-2.png", title:"", bamboo:"0" },
			
			//第一层
			{x:-12.5,  y:-6,  z:-2.5,  w:25,   h:13,    src:"img/bamboo/1280/05-1.png", title:"", bamboo:"0" },

			//{x:3.8,    y:2,  z:-2.5,  w:1, h:1,  src:"img/bamboo/3ddesign/11.jpg",        title:title7 ,href:"vankepavilion-devent-id-33.html"},


			{x:-2,  y:-3.5,   z:-2.5,  w:1.8, h:1.8, src:"img/bamboo/3ddesign/2.jpg", title:title2 ,href:"vankepavilion-design-id-14.html"},
			{x:-6,   y:0.5,   z:-2.5, w:1.8, h:1.8, src:"img/bamboo/3ddesign/6.jpg",  title:title5 ,href:"vankepavilion-design-id-25.html"},


			//{x:4.5,    y:0,  z:-2.5,  w:1.5, h:1.5,  src:"img/bamboo/3ddesign/10.jpg",        title:title7 ,href:"vankepavilion-devent-id-32.html"},
			{x:-3.5,   y: 1.2,  z:-2.5, w:1.5, h:1.5,     src:"img/bamboo/3ddesign/7.jpg",        title:title12 ,href:"vankepavilion-design-id-35.html"},
			{x:4.2,    y:-1,  z:-2.5,  w:2, h:2, src:"img/bamboo/3ddesign/9.jpg", title:title7 ,href:"vankepavilion-devent-id-31.html"},
			{x:-2.5,    y:-0.5,  z:-2.5,   w:1.2, h:1.2,   src:"img/bamboo/3ddesign/5.jpg",        title:title6 ,href:"vankepavilion-design-id-24.html"},
			{x:-1,    y:1.9,  z:-2.5, w:1.5, h:1.5, src:"img/bamboo/3ddesign/4.jpg", title:title3 ,href:"vankepavilion-design-id-23.html"},

			
			{x:-5,  y:-2.5,   z:-2.5, w:2.1, h:2.1,   src:"img/bamboo/3ddesign/1.jpg",        title:title1 ,href:"vankepavilion-design-id-13.html"},
			{x:1, y: 0, z: -2.5,    w:1.8, h:1.8,   src:"img/bamboo/3ddesign/3.jpg",        title:title4 ,href:"vankepavilion-design-id-15.html"},
			//{x:3.8,   y:-2.8,  z:-2.5, w:1.3, h:1.3,  src:"img/bamboo/3ddesign/8.jpg", title:title7 ,href:"vankepavilion-devent-id-30.html"},
			{x:0.3,   y:-2.5,  z:-2.5, w:1.5, h:1.5,  src:"img/bamboo/3ddesign/12.jpg", title:title11,href:""},

		]
	});
},
_ww = $(window).width(),
_hh = $(window).height(),
_bgWidth = 1920,
_bgHeight = 1000,
tdResize = function(_ww,_hh){
	var _bgBili = _ww/_bgWidth,
	$screen = $("#screen"),
	au=navigator.userAgent,
	firefox = false,
	_bili,_leftPx,
	_bgBili2 = _hh/_bgHeight;
	if(_bgBili>_bgBili2){
		if(_bgBili<= 0.85) {
			_bili = _bgBili + 0.15;
		}else{
			_bili = _bgBili;
		}
	}else{
		if(_bgBili2<= 0.85) {
			_bili = _bgBili2 + 0.15;
		}else{
			_bili = _bgBili2;
		}
	}
	_leftPx = (_ww - _bgWidth)/5;
	if(_ww < 1366 && _hh < 720){
		_leftPx = 0;
	}
	// _bili = _bgBili;
	tdFun(_bili);
	if(au.indexOf("Firefox")>0) var firefox=true;
	if(firefox){
		// $screen.attr("style",'transform: scale('+_bili+');-moz-transform-origin:0% 0%; cursor:pointer; left:'+  _leftPx +'');
	}else{
		// $screen.css({"zoom":_bili,"left":_leftPx,"cursor":"pointer"});
	}
	$screen.attr("width",_ww);
	$screen.attr("height",_hh);
};
tdResize(_ww,_hh);
$(window).resize(function(event) {
	var _ww = $(window).width(),
	_hh = $(window).height();
	tdResize(_ww,_hh);
});