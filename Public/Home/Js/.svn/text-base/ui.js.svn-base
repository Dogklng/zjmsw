/**
 * Created by MoonSeongyeon on 2015-08-07.
 */

var SLIDER = SLIDER || {};
SLIDER.JS = [];
SLIDER.OBJ = SLIDER.OBJ || {};

$(document).ready(SLIDERinit);

function SLIDERinit() {
	var self = this;
	var extendLen;
	//var slider;
	var head = document.getElementsByTagName("head")[0];
	var scripts = document.getElementsByTagName("script");
	var scripturl = [];
	var selfScript;
	for(var i = 0; i<scripts.length; i++){
		if( scripts[i].src.indexOf("UIsliderload.js") > -1){
			selfScript = scripts[i];
			self.root = scripts[i].src.replace("UIsliderload.js", "");
			break;
		}
	}

	var $slider = $('.UIslider');
	 $slider.each(function(index){
		 sliderExtendArray($slider.eq(index), index);
		 SLIDER.OBJ[index] = SLIDER.OBJ[index] || {};
	 });


	extendLen = SLIDER.JS.length;
	for (var i = 0; i < extendLen; i++) {
		scripturl.push(parser(SLIDER.JS[i]))
	}

	function parser( $value ){
		return self.root+String($value).replace(/\./g, "/")+".js";
	}

	function scriptElement( $src ){
		var script = document.createElement("script");
		script.src = $src;
		script.type = "text/javascript";
		script.charset = "utf-8";
		return script;
	}

	var loadscript = {
		loaded: [],
		load: function( callback ) {
			var sc = $('script[src *= "UIsliderload.js"]');
			var idx = arguments.length;
			while (idx-- > 0) {
				if ($.inArray(arguments[idx], this.loaded) == -1) { // 중복처리
					this.loaded.push(arguments[idx]);
					sc.after(arguments[idx]);
				}
			}

		}

	};

	for (var i=0; i < extendLen; i++) {
		loadscript.load( scriptElement( parser(SLIDER.JS[i])))
		if (loadscript.loaded.length == SLIDER.JS.length) {
			var script = scriptElement ( parser( "UIslider" ) );
			//head.insertBefore( script , selfScript.nextSibling);
		}
	}


	function sliderExtendArray($target, idx){
		var self = this;
		var $elem = $target;
		var jsnum=0;
		this.extendobj = $elem.data();
		this.root = "";
		for (key in self.extendobj) {
			if (self.extendobj.hasOwnProperty(key)) jsnum++;
			if($.inArray(self.extendobj[key], SLIDER.JS) == -1) {
				SLIDER.JS.push(self.extendobj[key]);
			}
		}
	}
}


//$(window).load( UIsliderCall );





//if(!LAE.IS_IE8) {
	$(document).ready( UIsliderCall );
//} else {
	//LAE.IS_IE8FN.push(UIsliderCall);
//}

$(window).load( sizeInit );

function sizeInit(){
    	var $slider = $('.UIslider');
		$slider.each(function( idx ){
            if(!$('.wrapper').hasClass('subpage')){
            	SLIDER.OBJ[idx].fnUIsliderbtn.fnanimate.resizeSet();
            }
            //console.log(idx)
        });
}

function UIsliderCall(){
	var $slider = $('.UIslider');
	var sliderLen = $slider.length;
	if($('.wrapper').hasClass('subpage')){
		LAE.IS_SIZE.MAXTABLET = 999;
	}

	$slider.each(function( idx ){
		SLIDER.OBJ[idx] = new UIslider( jQuery(this) );
        //SLIDER.OBJ[idx].fnUIsliderbtn.fnanimate.setContainer();
	});


	//console.log(SLIDER)

    /*
    *
    * init goto 처리시 활용 (ex > product color chip)
    *
    * SLIDER.OBJ[0]는 UIslider index로 처리
    *
    * var $gototarget = SLIDER.OBJ[0].elemobj.targetItem;
    * SLIDER.OBJ[0].fnUIsliderbtn.gotoinit($gototarget, 2, "next");
    *
    *
    * 잔여처리 항목 : mode별 init & destory, tabfocus처리
    *
    *
    * */

 }

/*
$(window).on('resize', UIslidermodeinit );

function UIslidermodeinit(){
	//console.log(SLIDER.OBJ[0].elemobj.target)
	switch (LAE.IS_VIEWTYPE) {
		case "web":
			//$(window).off('resize', SLIDER.OBJ[0].fnUIsliderbtn.fnanimate.resizeset );

			SLIDER.OBJ[0].destory( SLIDER.OBJ[0].elemobj.target, SLIDER.OBJ[0].elemobj );
			break;
		case "tablet":
			//$(window).on('resize', SLIDER.OBJ[0].fnUIsliderbtn.fnanimate.resizeset );

			SLIDER.OBJ[0].init();
			break;
		case "mobile":
			SLIDER.OBJ[0].init();
			break;
	}
}*/




/*
* product colorchip 활용
*
*
 */

$(document).ready( productindi );

function productindi(){
    var $thumbbox = $('.thumb-indi'),
        $thumbbtn = $thumbbox.find('button');

    $thumbbtn.on('click', gotoslider);

}

function gotoslider(e){
    var $this = $(this);
	var $thumbbox = $('.thumb-indi');
	var evt = e;
    var thisidx = $this.index();
    var parentidx = $this.closest('.UIslider').index( '.UIslider' );
    var $gototarget = SLIDER.OBJ[parentidx].elemobj.targetItem;

	if( !SLIDER.OBJ[parentidx].elemobj.isFlag ) {
		$thumbbox.find('button').removeClass('active');
		$this.addClass('active');
		var direct = SLIDER.OBJ[parentidx].fnUIsliderbtn.fnUIindicator.movedirect(thisidx);
		SLIDER.OBJ[parentidx].fnUIsliderbtn.gotoinit($gototarget, thisidx, direct, evt);
	}
}



function fnelemobj ( $target, thisidx ) {
	var self = this;
	this.initslider = true;
	this.target = $target;
	this.targetidx = thisidx;
	this.targetdataobj = $target.data();
	this.indibox = $target.find('.UIindicator');
	this.targetWrap = $target.find('.UIslider-container');
	this.targetcontainer = $target.find('ul');
	this.targetcontainer_w = self.targetcontainer.width();
	this.targetcontainer_h = self.targetcontainer.height();
	this.targetItem = self.targetcontainer.find('li');
	this.targetItem_w = self.targetItem.width();
	this.targetItem_h = self.targetItem.height();
	this.targetItemLen= self.targetItem.length;
	this.targetcontainerdata = this.targetWrap.data();
	this.targetIteminnerbox = $target.find('.UIslider-box');
	this.UInextbtn = $target.find('.UIslider-next');
	this.UIprevbtn = $target.find('.UIslider-prev');
	this.UIautorunplay = $target.find('.UIautorun-play');
	this.UIautorunstop = $target.find('.UIautorun-stop');
	this.moveX = $target.find('li').width();
	this.speed = 1.2;
	this.isFlag = false;
	this.chkidx = '';
	this.extendArry = [];
	var thisextend = $target.data();
	for(key in thisextend) {
		this.extendArry.push(thisextend[key])
	}
}


function fnelemobjreset( $target, elemobj ){

	elemobj.targetWrap = $target.find('.UIslider-container');
	elemobj.targetcontainer = $target.find('ul');
	elemobj.targetcontainer_h = elemobj.targetcontainer.height();
	elemobj.targetcontainer_w =elemobj.targetcontainer.width();
	elemobj.targetItem = elemobj.targetcontainer.find('.UIslider-item');
	elemobj.targetItem_h = elemobj.targetWrap[0].clientHeight;
	elemobj.targetItem_w = elemobj.targetWrap[0].clientWidth;
	elemobj.targetItemLen = elemobj.targetItem.length;
	elemobj.targetIteminnerbox = elemobj.targetItem.find('.UIslider-box');
	elemobj.moveX = elemobj.targetItem_w;
	elemobj.speed = 1.2

}

var getLength = function(obj) {
	var size = 0, key = null;
	for (key in obj) {
		if (obj.hasOwnProperty(key)) size++;
	}
	return size;
};

function UIslider( $target ){
	CheckMobile();

	var self = this;
	var thisidx = $target.index('.UIslider');
	this.elemobj = new fnelemobj( $target, thisidx );
	self.elemobj.chkidx = thisidx;
	this.fnUIsliderbtn = new UIsliderbutton( $target, self.elemobj);
	self.elemobj.initslider = true;
	self.elemobj.oldviewtype = LAE.IS_VIEWTYPE;
	self.modearr = [];

	self.elemobj.targetItem.find('a').attr("tabindex",'-1');
	self.elemobj.targetcontainer.find('li').eq(0).addClass('active');
	self.elemobj.targetcontainer.find('li.active').find('a').attr("tabindex",'0');

	this.init = function( $target, elemobj){
		var $this = $target;
		var thisidxchk = $this.index('.UIslider');

		fnResizeDom($target, elemobj, elemobj.targetWrap.data(LAE.IS_VIEWTYPE), elemobj.htmlArray);
		elemobj.targetWrap.swipe("enable");

		/*if($this.data("uiIndicator") == "UIindicator") {
		 //console.log(thisidx)
		 SLIDER.OBJ[thisidx].fnUIsliderbtn.fnUIindicator.fnResetindi (SLIDER.OBJ[thisidx].elemobj);
		 console.log(SLIDER.OBJ[thisidx].elemobj.indibox.data())
		 SLIDER.OBJ[thisidx].fnUIsliderbtn.resize_addevent(elemobj)
		 elemobj.targetcontainer.find('li').eq(0).addClass('active');
		 }*/

	};

	this.destory = function( $target, elemobj ){
		fnResizeDom($target, self.elemobj, 1, elemobj.htmlArray);
		$target.find(elemobj.targetcontainer).attr('style','');
		$target.find(elemobj.targetItem).css('width','auto');
		$target.find(elemobj.targetWrap).css('style','');
		//$target.find(elemobj.indibox).css('display','none');
	};


	this.modeinit = function(){

		if (self.modearr.indexOf(LAE.IS_VIEWTYPE) == -1) {
			self.destory($target, self.elemobj);
			self.elemobj.initslider = false;
		} else {
			if(self.elemobj.oldviewtype != LAE.IS_VIEWTYPE) {
				var slideNum = getLength(SLIDER.OBJ);
				self.elemobj.initslider = true;
				for (var i = 0; i < slideNum; i++) {
					SLIDER.OBJ[i].init($target, self.elemobj);

				}
			}

			self.elemobj.oldviewtype = LAE.IS_VIEWTYPE;

			self.fnUIsliderbtn.fnanimate.resizeSet();
			self.fnUIsliderbtn.resizesetevt();

		}
		self.elemobj.oldviewtype = LAE.IS_VIEWTYPE;
	};

	if(self.elemobj.targetWrap.data('onslider') != undefined) {
		self.modearr = self.elemobj.targetcontainerdata.onslider.split("-");
		self.elemobj.modearr = self.modearr;
		$(window).on('resize', self.modeinit);

		self.modeinit();
	}
}


/* 움직임 컨트롤  */

function UIanimation ($target, elemobj){
	this.elemobj = elemobj;
	var self = this;
	var oldprevelem;
	this.viewLen = this.elemobj.targetWrap.data(LAE.IS_VIEWTYPE+"len");
	var sortchk = extendchk("UIslidersort", elemobj);
	var resizechk = extendchk("UIresize", elemobj);

	this.htmlArry = fnHtmlArray($target, self.elemobj);
	this.speed = 0.7;
	var moveitem, $oldmoveitem;
	var oldviewtype = LAE.IS_VIEWTYPE;


	this.resizeSet = function() {
		if(oldviewtype != LAE.IS_VIEWTYPE) {

			if (sortchk) {
				TweenMax.killAll(true, true, false, false);
			}
			if (!elemobj.initslider) return;
			moveitem = null;

			if (sortchk) {
				TweenMax.killTweensOf(moveitem);
				self.elemobj.targetcontainer.find('li').remove();
				self.viewLen = UIslidersort($target, elemobj, self.htmlArry);
			}

			var itemLen = self.elemobj.targetItem.length;
			for (var i = 1; i <= itemLen; i++) {
				if (!self.elemobj.targetcontainer.find('li[data-id=' + i + ']')) {
					self.elemobj.targetcontainer.append(self.elemobj.targetcontainer.find('li[data-id=' + i + ']'));
				}
			}
		}
		self.elemobj.targetItem = $target.find('ul li');
		self.elemobj.targetItem.css({
			'width': self.elemobj.targetWrap.width()
		});
		self.elemobj.targetItem_w = self.elemobj.targetItem.width();
		self.elemobj.targetcontainer.css({
			'width': self.elemobj.targetItem_w * self.elemobj.targetItem.length
		});

		self.elemobj.moveX = self.elemobj.targetcontainer.find('li').width();
		oldviewtype = LAE.IS_VIEWTYPE;
	};


	if (sortchk) {
		self.viewLen = UIslidersort($target, elemobj, self.htmlArry);
		fnelemobjreset ($target, elemobj);
	}


	if( resizechk ) {
		$(window).on('resize', self.resizeSet);
	}

	this.setContainer = function (e) {
		self.elemobj.targetItem_w = self.elemobj.targetItem.outerWidth();

		self.elemobj.targetItem.css({
			'width': self.elemobj.targetItem_w
		});

		self.elemobj.targetcontainer.css({
			'width': self.elemobj.targetItem_w * self.elemobj.targetItem.length
		});
	};
	self.setContainer();

	this.next = function ( $moveitem, direct, idx, sort ) {
		elemobj.isFlag = true;
		moveitem = $moveitem;
		self.elemobj.moveX = $moveitem.width();
		TweenMax.killTweensOf($oldmoveitem);
		if($oldmoveitem != undefined) {
			$oldmoveitem.css('margin-left', '0');
		}
		TweenMax.to($moveitem, self.elemobj.speed, { marginLeft: -self.elemobj.moveX, ease: Expo.easeOut, onComplete: domMove, onCompleteParams: [ $moveitem, direct, idx, sort ] });
		$oldmoveitem = $moveitem;
	};

	this.prev = function ( $moveitem ,direct, idx, sort ) {
		elemobj.isFlag = true;
		moveitem = $moveitem;
		TweenMax.killTweensOf($oldmoveitem);
		if($oldmoveitem != undefined) {
			$oldmoveitem.css('margin-left', '0');
		}
		self.elemobj.moveX = $moveitem.width();
		$moveitem.css('margin-left', -self.elemobj.moveX);
		/*self.elemobj.targetcontainer.prepend($moveitem);*/
		TweenMax.to($moveitem, self.elemobj.speed, { marginLeft: 0, ease: Expo.easeOut, onComplete: domMove, onCompleteParams: [ $moveitem, direct, idx, sort ] });
		$oldmoveitem = $moveitem;
	};


	function domMove( $moveitem, direct, idx, sort ){
		elemobj.isFlag = false;
		elemobj.isNexet = false;
		moveitem = $moveitem;
		$moveitem.css('margin-left', '0');
		if(direct == 'next'){
			self.elemobj.targetcontainer.append($moveitem);
		}
		if(sort != "sort") return;
		var inddicatorchk = extendchk ("UIindicator", elemobj);
		if (!inddicatorchk) return;
		var arrhtml = [];
		for (var i=0; i < elemobj.targetItemLen; i++) {
			arrhtml[i] = i
		}

		self.elemobj.targetItem = self.elemobj.targetcontainer.find('li');


		var sortarr = fnreduce( idx, arrhtml );
		for (var j=1; j < sortarr.length; j++) {
			// main bestseller indi click bug
			// if(self.elemobj.targetWrap.data(LAE.IS_VIEWTYPE) == 1) return;
			elemobj.targetcontainer.append( elemobj.targetcontainer.find( 'li[data-id='+ sortarr[j] +']' ) );
		}
	}

	this.init = function(){
		if (sortchk) {
			self.viewLen = UIslidersort($target, elemobj, self.htmlArry);
			fnelemobjreset ($target, elemobj);
		}
		var resizechk = extendchk("UIresize", elemobj);
		if( resizechk ) {
			$(window).on('resize', self.resizeSet);
		}
		self.setContainer();

	}

}

function extendchk ( extend, elemobj ){
	var inchk = false;
	var extendLen = elemobj.extendArry.length;
	for(var i = 0; i < extendLen; i++) {
		if (elemobj.extendArry[i] == extend) {
			inchk = true;
		}
	}
	return inchk;
}

function fnHtmlArray($target, elemobj ){
	var $targetItem = $target.find(elemobj.targetItem);
	var $innerbox = $targetItem.children();
	var $inneritem = $innerbox.children();
	var htmlArray = [];

	for (var i = 0; i <= $inneritem.length-1 ; i++ ){
		htmlArray[i] = ($inneritem[i].outerHTML)
	}
	elemobj.htmlArray = htmlArray;
	return htmlArray;
}


function UIindicator ( elemobj ){

	var self = this;
	var direct;
	self.oldidx = 0;
	var modearr = [];

	this.fnResetindi = function(elemobj){

		if(elemobj.targetcontainerdata.onslider) {
			modearr = elemobj.targetWrap.data("onslider").split("-");
		}

		if (elemobj.targetItem.length > 0) {
			var indiHtml = '';
			var Len = Math.ceil(elemobj.htmlArray.length / elemobj.targetWrap.data(LAE.IS_VIEWTYPE));

			if (elemobj.indibox.data('activeSrc') && elemobj.indibox.data('normalSrc')) {
				if (modearr.indexOf(LAE.IS_VIEWTYPE) != -1) {

					for (var i = 0; i < Len; i++) {
						indiHtml += '<button type="button" class="pager" title="'+ i +'번 슬라이드"><img src="' + elemobj.indibox.data('nomalSrc') + '" alt="'+ i +'번 슬라이드"></button>';
					}
				} else {
					for (var i = 1; i < elemobj.targetItemLen + 1; i++) {
						indiHtml += '<button type="button" class="pager" title="'+ i +'번 슬라이드"><img src="' + elemobj.indibox.data('nomalSrc') + '" alt="'+ i +'번 슬라이드"></button>';
					}
				}


			} else if (elemobj.indibox.data('indiSrc')) {
				var inidsrcArry = [];
				var $indibtn = elemobj.indibox.find('button');
				var indibtnLen = $indibtn.length;
				for (var btni = 0; btni < indibtnLen; btni++) {
					elemobj.indibox.html()
					inidsrcArry.push($indibtn.eq(btni).html())
				}

				for (var i = 0; i < elemobj.targetItemLen; i++) {
					indiHtml += '<button type="button" class="pager" title="'+ i +'번 슬라이드">' + inidsrcArry[i] + '</button>';
				}
			} else {
				for (var i = 1; i < elemobj.targetItemLen + 1; i++) {
					indiHtml += '<button type="button" class="pager"><span>' + i + '</span></button>';
				}
			}
			elemobj.indibox.find('button').remove();
			elemobj.indibox.append(indiHtml);
		} else {
			elemobj.indibox.find('button').remove();
		}

	};

	this.movedirect = function (current) {
		if (current > self.oldidx) {
			direct = "next";
		} else if(current < self.oldidx) {
			direct = "prev"
		}
		self.oldidx = current;
		return direct;
	};


	this.indiactive = function(elemobj){
		var activesrc = elemobj.indibox.data('activeSrc');
		var normalsrc = elemobj.indibox.data('normalSrc');
		elemobj.indibox.find('button img').attr('src', normalsrc);
		elemobj.indibox.find('.active img').attr('src', activesrc);
	}
}

function fnreduce(idx, arr){
	var q = idx;
	function cc(p, c, s, o){
		var n = c+(q+1);
		var len = o.length;
		p.push( ( n > len ) ? n - len : n );
		return p;
	}
	var b = arr.reduce(cc, []);
	return b;
}


function UIresize(elemobj){

	SetViewSize();
	CheckMobile();
	DeivceChkFn();
	var viewLen;
	switch (LAE.IS_VIEWTYPE) {
		case "web":
			viewLen = elemobj.targetcontainerdata.web;
			break;
		case "tablet":
			viewLen = elemobj.targetcontainerdata.tablet;
			break;
		case "mobile":
			viewLen = elemobj.targetcontainerdata.mobile;
			break;
	}

	return viewLen
}
function UIsliderauto( $target, elemobj ){

	var self = this;
	this.target = $target;
	var targetItem = self.target.find('li');
	var autoTimer;

	this.setInterval = function () {
		//console.log("tt")
		clearInterval(autoTimer);
		autoTimer = setInterval(function () {
			targetItem = self.target.find('li');
			UIslider.prototype.animate($target, targetItem.eq(0), "next");
		}, 3000);
	};

	this.clearInterval = function () {
		clearInterval(autoTimer);
	};

	this.setInterval();

}

function UIsliderbutton ( $target, elemobj ){
    
	var self = this;

	this.fnanimate = new UIanimation($target, elemobj);
	var $moveitem;
	this.inddicatorchk = extendchk ("UIindicator", elemobj);
	var sortchk = extendchk ("UIslidersort", elemobj);
	var auturunchk = (elemobj.targetWrap.data("autorun")) ? true : false;
	var viewLen = elemobj.targetItem.length;
	var gotoidx, direct;
	var autoTimer, autoevt;
	var oldviewtype;
	var moveidx = 0;
	var chkoldidx;
	this.gotoinit = function ($gototarget, index, dir, evt){
		gotoidx = index;
		direct = dir;

		if (direct == "next") {
			self.fnUIindi(evt);
		} else if (direct == "prev") {
			self.fnUIindi(evt);
		}
	};

	this.fnUIindi = function(e){
		var $this = $(this);

		elemobj.speed = 1.2;
		if(e.type == 'focus') {
			elemobj.speed = 0;
		}
		var idx = ($this.index() > -1) ? $this.index() : gotoidx;

		if(auturunchk) {
			//self.setInterval(e);
		}

		if(self.oldindex == idx) return;
		direct = (self.inddicatorchk) ? self.fnUIindicator.movedirect(idx) : direct;
		if(direct == undefined) {
			direct = "prev";
		}

		if(auturunchk) {
			self.clearInterval();

			//self.setInterval(e);
		}


		/*if(self.inddicatorchk) {

		 var arr = domRealign( idx );
		 for(var i = 2, len = arr.length-1; i <= len; i++) {
		 console.log("append data >>>> " + arr[i]);
		 elemobj.targetcontainer.append( elemobj.targetcontainer.find('li[data-id='+ arr[i] +']') );
		 }

		 }*/

		//console.log(idx)

		self.activeslider(elemobj.indibox.find('button'), idx);
		elemobj.targetItem.removeClass('active');
		if(direct == "next"){
			//console.log(idx);
			elemobj.targetItem = elemobj.targetcontainer.find('li');
			elemobj.targetcontainer.find('li[data-id='+ parseInt(idx+1) +']').addClass('active');
			if(elemobj.isFlag && idx > chkoldidx) {
				chkoldidx = idx;
				TweenMax.killTweensOf(elemobj.targetItem.eq(0));
				elemobj.targetcontainer.append( elemobj.targetItem.eq(0) );
				elemobj.targetItem = elemobj.targetcontainer.find('li');
				//elemobj.targetItem.eq(0).after(elemobj.targetcontainer.find('li[data-id=' + parseInt(idx + 1) + ']'));
				elemobj.targetItem = elemobj.targetcontainer.find('li');
			} else {
               // console.log(idx);
				chkoldidx = idx;
				elemobj.targetItem.eq(0).after( elemobj.targetcontainer.find('li[data-id=' + parseInt(idx + 1) + ']') );
			}
			$moveitem = elemobj.targetcontainer.find('li').eq(0);
			self.fnanimate.next( $moveitem, direct, idx, "sort" );
			elemobj.isNexet = true;
			elemobj.isFlag = false;

		} else if(direct == "prev") {
			TweenMax.killTweensOf(elemobj.targetItem.eq(0));
			//console.log("prev  "+idx);
			elemobj.targetcontainer.find('li[data-id='+ parseInt(idx+1) +']').addClass('active');
			$moveitem = elemobj.targetcontainer.find('li[data-id='+ parseInt(idx+1) +']');
			if(parseInt(elemobj.targetItem.length-1) == idx+1) {
				elemobj.targetcontainer.prepend(elemobj.targetcontainer.find('li[data-id='+ parseInt(elemobj.targetItem.length) +']') );
			}
			elemobj.targetcontainer.prepend($moveitem );
			self.fnanimate.prev( $moveitem, direct, idx, "sort" );
			elemobj.isNexet = false;
		}
		self.oldindex = idx;

		elemobj.targetItem.find('a').attr("tabindex",'-1');
		elemobj.targetcontainer.find('li.active').find('a').attr("tabindex",'0');
		if(self.inddicatorchk) {
			self.fnUIindicator.indiactive( elemobj );
		}

	};

	function domRealign( idx ){
		var arr = [];
		var len =  elemobj.targetcontainer.find('li').length;
		for (var i = 0; i < len; i++) {
			arr[i] = i;
		}
		var newarr = fnreduce( idx, arr );
		return newarr;
	}

	function resetCallback(){
		//console.log("callback")
	}

	function resetDom( idx, callback){
		//var chkidx = parseInt( elemobj.targetcontainer.find('li').eq(0).data('id')-1 );
		var arr = domRealign( idx )

		//console.log(arr)
		//console.log(idx)
		//console.log(arr)

		for(var i=0; i< arr.length; i++ ) {

			elemobj.targetcontainer.append( elemobj.targetcontainer.find('li[data-id='+ arr[i] +']') );
		}
		elemobj.targetItem = elemobj.targetcontainer.find('li');
		elemobj.targetItem.removeClass('active');
		elemobj.targetItem.eq(0).next().addClass('active');

		//callback();
		//console.log(chkidx)
		//var arr = domRealign( idx )
	}


	this.fnUInextbtn = function(e){

		if(e.keyCode == 9 || e.shiftKey) return;
		elemobj.isFlag = true;
		//console.log(elemobj.isFlag)
		//if(elemobj.isFlag != false) return;
		elemobj.speed = 0;
		if(e.type == 'click' || e.type == "touchend" || e.type =="focusout") {
			elemobj.speed = 1.2;
		}

		/* autorun bug fix :: start :: */
		if(auturunchk) {
			self.clearInterval();
			self.setInterval(e);
			elemobj.UIautorunplay.css('display','none');
			elemobj.UIautorunstop.css('display','block');
		}
		/* autorun bug fix :: end :: */

		//console.log(e)
		var $item = elemobj.targetcontainer.find('li');
		$item.removeClass('active');
		//elemobj.targetcontainer.append($item.eq(0));

		//$moveitem = $item.eq(0);
		if(elemobj.isFlag) {
			/*for(var i = 0; i < $item.length; i++) {
			 console.log(i)
			 }*/

			if(elemobj.isNexet) {
				elemobj.targetcontainer.append($item.eq(0));
				$item = elemobj.targetcontainer.find('li');
				//elemobj.targetcontainer.prepend($item.last());
			}
		}
		$moveitem = $item.eq(0);
		$moveitem.next().addClass('active');

		var direct = 'next';
		elemobj.isNexet = true;

		/*if(self.inddicatorchk) {
		 var idx = parseInt(elemobj.targetcontainer.find('li').eq(1).data('id'));
		 var arr = domRealign( idx );
		 console.log(arr)
		 for(var i = 2, len = arr.length-1; i <= len; i++) {
		 elemobj.targetcontainer.append( elemobj.targetcontainer.find('li[data-id='+ arr[i] +']') );
		 }
		 }*/

		$item = elemobj.targetcontainer.find('li');
		var chkidx = parseInt( elemobj.targetcontainer.find('li.active').data('id') - 1 );
		var resetidx = parseInt( elemobj.targetcontainer.find('li').eq(0).data('id')-1 );
		if(elemobj.isFlag) {
			resetDom( resetidx, resetCallback );
		}

		self.fnanimate.next( $moveitem, direct );

		if(e.type == 'keydown') {
			if($moveitem.data('id') == $item.length) return;
			$item.eq(1).find('a:first-child').focus();
		}

		if(self.inddicatorchk) {
			var activeidx = elemobj.targetcontainer.find('li.active').data('id')-1;
			if(e.type == "focusout") {
				//activeidx = activeidx+1
			}
			if(e.type == "click" || e.type == "focusout" || e.type == "touchend") {

				self.activeslider(elemobj.indibox.find('button'), activeidx);
			}

			self.oldindex = activeidx;
			self.fnUIindicator.indiactive( elemobj );

		}





		elemobj.targetItem.find('a').attr("tabindex",'-1');
		elemobj.targetcontainer.find('li.active').find('a').attr("tabindex",'0');





	};

	this.fnUIprevbtn = function(e){

		if(e.keyCode == 9 || e.shiftKey) return;
		//if(elemobj.isFlag != false) return;
		elemobj.speed = 0;
		if(e.type == 'click' || e.type == "touchend"  || e.type =="focusout") {
			elemobj.speed = 1.2;
		}

		/* autorun bug fix :: start :: */
		if(auturunchk) {
			self.clearInterval();
			self.setInterval(e);
			elemobj.UIautorunplay.css('display','none');
			elemobj.UIautorunstop.css('display','block');
		}
		/* autorun bug fix :: end :: */

		var $item = elemobj.targetcontainer.find('li');
		$item.removeClass('active');

		var resetidx = parseInt( elemobj.targetcontainer.find('li').eq(0).data('id')-1 );

		if(elemobj.isFlag) {
			resetDom( resetidx, resetCallback );
		}
		$item =  elemobj.targetcontainer.find('li');

		if(e.type != 'keydown') {
			if(elemobj.isFlag ) {
				if(elemobj.isNexet) {
					$item = elemobj.targetcontainer.find('li');
					$moveitem = $item.eq(0);
				} else {
					elemobj.targetcontainer.prepend($item.last());
					$item = elemobj.targetcontainer.find('li');
					$moveitem = $item.eq(0);
				}
			} else {
				elemobj.targetcontainer.prepend($item.last());
				$item = elemobj.targetcontainer.find('li');
				$moveitem = $item.eq(0);
			}
		}

		elemobj.isNexet = false;
		elemobj.targetItem = elemobj.targetcontainer.find('li');

		$moveitem.addClass('active');
		var chkidx = parseInt( elemobj.targetcontainer.find('li.active').data('id') - 1 );

		//$moveitem.find('a:last-child').focus();



		var direct = 'prev';
		self.fnanimate.prev( $moveitem, direct, chkidx, "sort" );

		if(self.inddicatorchk) {
			var activeidx = elemobj.targetcontainer.find('li.active').data('id')-1;
			self.activeslider(elemobj.indibox.find('button'), activeidx);
			self.fnUIindicator.indiactive( elemobj );
		}

		elemobj.targetItem.find('a').attr("tabindex",'-1');
		elemobj.targetcontainer.find('li.active').find('a').attr("tabindex",'0');
	};




	this.resize_addevent = function( elemobj ){
		elemobj.indibox.find('button').off('focus', evtbtnfocus);
		elemobj.indibox.find('button').off('keydown', evtbtnkey);
		elemobj.indibox.find('button').off('mousedown keypress', self.fnUIindi);
		if (self.inddicatorchk) {
			elemobj.indibox.find('button').on('focus', evtbtnfocus);
			elemobj.indibox.find('button').on('keydown', evtbtnkey);
			elemobj.indibox.find('button').on('mousedown keypress', self.fnUIindi);
		}
	};

	this.resizesetevt = function(e) {

		if(oldviewtype != LAE.IS_VIEWTYPE) {
			if (self.inddicatorchk) {
				viewLen = elemobj.targetItemLen;
				self.fnUIindicator.fnResetindi(elemobj);
				self.resize_addevent(elemobj);
				self.oldindex = 0;
				direct = "next";
				self.fnUIindicator.oldidx = 0;
				var activeid;
				if (sortchk) {
					activeid = 0;
				} else {
					if (elemobj.targetcontainer.find('li.active') == "undefined") {
						activeid = 0;
/////////////////////  
                        console.log("called");
						elemobj.targetcontainer.find('li').eq(0).addClass('active');
					} else {
						activeid = parseInt(elemobj.targetcontainer.find('.active').data('id') - 1);
					}
				}
				self.activeslider(elemobj.indibox.find('button'), activeid);
				self.fnUIindicator.indiactive(elemobj);

				if (elemobj.targetcontainerdata[LAE.IS_VIEWTYPE] > 1) {
					elemobj.targetcontainer.find('li a.UIslider-con').off('focus', evtfocus);
					elemobj.targetcontainer.find('li a.UIslider-con').off('keydown', evtkey);

					elemobj.targetcontainer.find('li a.UIslider-con').on('focus', evtfocus);
					if(auturunchk) {
						//elemobj.targetcontainer.find('li a.UIslider-con').off('focusout', fnautoRun);
						//elemobj.targetcontainer.find('li a.UIslider-con').on('focusout', fnautoRun);
					}
					elemobj.targetcontainer.find('li a.UIslider-con').on('keydown', evtkey);
				}

			}


			if(elemobj.modearr != undefined) {
				if (self.inddicatorchk && $target.find('.UIslider-con').length > 1 && elemobj.modearr.indexOf(LAE.IS_VIEWTYPE) != -1) {
					//console.log($target.find('.UIslider-item').length)
					if ($target.find('.UIslider-item').length  > 1) {
						//console.log($target.find('.UIslider-con').length)
						if (elemobj.modearr.indexOf(LAE.IS_VIEWTYPE) != -1) {
							$target.find(elemobj.indibox).css('display', "inline-block");
						} else {
							$target.find(elemobj.indibox).css('display', "none");
						}
					} else {

					}
				} else {
					$target.find(elemobj.indibox).css('display', "none");
                    console.log("display none");
				}
			} else {
				if(self.inddicatorchk && $target.find('.UIslider-item').length > 1) {
					$target.find(elemobj.indibox).css('display', "inline-block");
				} 
                else if( $target.find('.bestslider-item').length > 1) { //태그명 달라서 추가로 처리함
					$target.find(elemobj.indibox).css('display', "inline-block");
                }else {
					$target.find(elemobj.indibox).css('display', "none");
                     console.log("display none2");
				}
			}

			/*if (elemobj.UInextbtn.length && elemobj.UIprevbtn && $target.find('.UIslider-con').length > 1) {
			 if($target.find('.UIslider-con').length-1 >= elemobj.targetWrap.data(LAE.IS_VIEWTYPE)) {
			 elemobj.UInextbtn.css('display',"block");
			 elemobj.UIprevbtn.css('display',"block");
			 console.log("block")
			 } else {
			 console.log("none")
			 elemobj.UInextbtn.css('display',"none");
			 elemobj.UIprevbtn.css('display',"none");
			 }
			 }*/

			if (elemobj.targetItem.length <= 1) {
				elemobj.UInextbtn.css('display','none');
				elemobj.UIprevbtn.css('display','none');
                 console.log("display none3");
			}

			oldviewtype = LAE.IS_VIEWTYPE;
		}
	};

	if (self.inddicatorchk) {
		this.fnUIindicator = new UIindicator(elemobj);
	}

	this.indichkinit = function() {
		if (self.inddicatorchk) {
			self.fnUIindicator.fnResetindi(elemobj);
			self.resize_addevent(elemobj);
			elemobj.targetcontainer.find('li').eq(0).addClass('active');
		}
	};

	this.indichkinit();

	if(elemobj.targetItem.length <= 1) {
		elemobj.UInextbtn.css('display',"none");
		elemobj.UIprevbtn.css('display',"none");
		if (self.inddicatorchk) {
			elemobj.indibox.css('display', "none");
		}
		if(auturunchk) {
			elemobj.UIautorunplay.css('display','none');
			elemobj.UIautorunstop.css('display','none');

		}

	}

	this.setInterval = function (e) {
		autoevt = e;
		clearInterval(autoTimer);
		autoTimer = setInterval(function () {
			self.fnUInextbtn(autoevt)
		}, 4000);
	};

	this.clearInterval = function () {
		clearInterval(autoTimer);
	};

	if(auturunchk) {

		elemobj.UIautorunstop.on('click', fnautostop);
		elemobj.UIautorunplay.on('click', fnautoRun);

		var loadevt = {};
		loadevt.type = "click";
		self.setInterval(loadevt);
		elemobj.UIautorunplay.css('display','none');
	}

	function fnautoRun (e){
		self.clearInterval();
		self.setInterval(e);
		elemobj.UIautorunplay.css('display','none');
		elemobj.UIautorunstop.css('display','block');

		if(e.type == "click") {
			e.preventDefault();
			elemobj.UIautorunstop.focus();
		}

		if(e.type == "focusout") {
			elemobj.speed = 1.2;
		}
	}

	function fnautostop(e){
		self.clearInterval();
		elemobj.UIautorunplay.css('display','block');
		elemobj.UIautorunstop.css('display','none');
		if(e.type == "click") {
			e.preventDefault();
			elemobj.UIautorunplay.focus();
		}
	}

	self.stopfn = function(e){
		fnautostop(e)
	};

	var resizechk = extendchk ("UIresize", elemobj);
	if(resizechk) {
		$(window).on('resize', self.resizesetevt)
	}

	var swipeOptions = {
		triggerOnTouchEnd : true,
		tap : tabEvent,
		//swipe : swipeEvent,
		//swipeStatus : LAE.IS_MOBILE && swipeStatus,
		swipeStatus : LAE.IS_MOBILE && swipeStatus,
		allowPageScroll:"vertical",
		threshold:80,
		excludedElements : []
	};

	function add_event(elemobj){

		elemobj.targetcontainer.swipe(swipeOptions);
		//$target.swipe(swipeOptions);
		elemobj.UInextbtn.on('click', self.fnUInextbtn );
		elemobj.UIprevbtn.on('click', self.fnUIprevbtn );


		elemobj.targetcontainer.find('li a.UIslider-con').on('focus', evtfocus);
		elemobj.targetcontainer.find('li a.UIslider-con').on('keydown', evtkey);

		if(auturunchk) {
			elemobj.targetcontainer.find('li a.UIslider-con').on('focusout', fnautoRun);
		}


	}

	add_event( elemobj );

	function tabEvent(event,target){
		if(event.type == 'touchend'){
			if($(target).closest('a').attr('href')){
				location.href= $(target).closest('a').attr('href');
			}
		}
	}

	function swipeStatus(event, phase, direction, distance, duration){

		if (phase == "move" && (direction == "left" || direction == "right")) {

		} else if ( phase == "cancel" || phase =="end"){

			if(distance>75){

				if (direction == "right"){
					if (elemobj.targetItem.length <= 1) return;
					self.fnUIprevbtn(event);
					self.oldindex = elemobj.targetcontainer.find('li.active').data('id')-1;
					self.activeslider(elemobj.indibox.find('button'), self.oldindex);
					if(auturunchk) {
						self.clearInterval();
						self.setInterval(event)
					}
				} else if (direction == "left"){
					if (elemobj.targetItem.length <= 1) return;
					self.fnUInextbtn(event);
					self.oldindex = elemobj.targetcontainer.find('li.active').data('id')-1;
					self.activeslider(elemobj.indibox.find('button'), self.oldindex);
					if(auturunchk) {
						self.clearInterval();
						self.setInterval(event)
					}
				}
			}
		}
	}

	this.activeslider = function(activeelem, idx){
		//console.log("acitve")
		activeelem.removeClass('active');
		activeelem.eq(idx).addClass('active');
		self.oldindex = idx;
	};

	self.activeslider(elemobj.indibox.find('button'), 0);

	if(self.inddicatorchk) {
		elemobj.targetcontainer.find('li a.UIslider-con').on('keydown', evtkey);
		self.fnUIindicator.indiactive(elemobj);
	}



	/* focuse 처리 */

	/* indicator button keydown */
	function evtbtnkey(e){
		var focusnext;
		if(e.shiftKey && e.keyCode == 9) {
			focusnext = false;
			if(auturunchk) {
				//console.log("chkeck")
				self.clearInterval();
			}
		} else if(e.keyCode == 9) {
			focusnext = true;
			if(auturunchk) {
				self.clearInterval();
			}
		}


		var $indibtn = elemobj.indibox.find('button');
		var UIbtnLen = $indibtn.length-1;
		var $this = $(this);
		var thisbtnidx = $indibtn.index( $this );
		var $gototarget;
		var exNum;
		gotoidx = 0;
		direct = "prev";
		$gototarget = "";
		if(focusnext) {


			if(UIbtnLen != thisbtnidx) {
				//console.log(thisbtnidx+1)
				//console.log(elemobj.targetcontainer.find('li').eq(0).data('id'))
				if(thisbtnidx+1 != elemobj.targetcontainer.find('li').eq(0).data('id')) {
					exNum = 1;
				} else {
					exNum = 0;
				}
				//console.log("exNum >>>" + exNum) 
				if(!elemobj.targetItem.eq( $indibtn.index($(this)) ).find('a.UIslider-con').length) return;
				//console.log(exNum)
				//console.log("tabName>>>> " + elemobj.targetcontainer.find('li').eq(exNum).find('.UIslider-con')[0].tagName)
				//console.log($indibtn.index($(this)))

				//console.log(elemobj.targetItem.eq( $indibtn.index($(this)) ).find('.UIslider-con')[0].tagName == "DIV")
				//console.log(elemobj.targetcontainer.find('li').eq(exNum).find('.UIslider-con')[0].tagName == "DIV")
				if(elemobj.targetcontainer.find('li').eq(exNum).find('.UIslider-con')[0].tagName == "DIV"){


					//console.log("err")
					//console.log(UIbtnLen)
					//console.log(thisbtnidx)
					//console.log(!elemobj.targetWrap.data("customindi"))


					if( elemobj.targetWrap.data(LAE.IS_VIEWTYPE) != 1 ){
						e.preventDefault();
						self.gotoinit($gototarget, thisbtnidx, direct, e);
						console.log()
						elemobj.targetcontainer.find('li[data-id=' + parseInt(thisbtnidx + 1) + ']').find('a.UIslider-con:first-child').focus();
					} else {
						e.preventDefault();
						elemobj.targetcontainer.find('li[data-id=' + parseInt(thisbtnidx + 1) + ']').find('a.UIslider-con:first-child').focus();
					}
				} else {


					//console.log("ok")
					//console.log(UIbtnLen)
					//console.log(thisbtnidx)
					//console.log(!elemobj.targetWrap.data("customindi"))


					if(elemobj.targetWrap.data("customindi") && elemobj.targetWrap.data(LAE.IS_VIEWTYPE) == 1) {
						e.preventDefault();
						self.gotoinit($gototarget, thisbtnidx, direct, e);
						elemobj.targetcontainer.find('li[data-id=' + parseInt(thisbtnidx + 1) + ']').find('a.UIslider-con').first().focus();

					}

					if(!elemobj.targetWrap.data("customindi") && elemobj.targetWrap.data(LAE.IS_VIEWTYPE) == 1) {
						/* visual 처리 */

						e.preventDefault();
						self.gotoinit($gototarget, thisbtnidx, direct, e);

						if(elemobj.targetcontainer.find('li[data-id=' + parseInt(thisbtnidx + 1) + ']').find('a').length) {
							elemobj.targetcontainer.find('li[data-id=' + parseInt(thisbtnidx + 1) + ']').find('a.UIslider-con').first().focus();
						} else {
							//console.log("chkdfjs bve")
							//elemobj.indibox.find('button').eq(parseInt(thisbtnidx)).focus()
							elemobj.indibox.find('button').eq(parseInt(thisbtnidx+1)).focus()
						}
					}

					if(elemobj.targetWrap.data(LAE.IS_VIEWTYPE) != 1) {
						e.preventDefault();
						self.gotoinit($gototarget, thisbtnidx, direct, e);
						elemobj.targetcontainer.find('li[data-id=' + parseInt(thisbtnidx + 1) + ']').find('a.UIslider-con').first().focus();
					}

				}
			} else {
				if(elemobj.targetItem.eq( $indibtn.index($(this)) ).find('.UIslider-con')[0].tagName != "DIV") {
					e.preventDefault();
					elemobj.targetcontainer.find('li[data-id=' + parseInt(thisbtnidx + 1) + ']').find('a.UIslider-con').first().focus();
				}
			}
		} else {

		}



	}

	/* indicator button focus */
	function evtbtnfocus(e){
		var thisidx = elemobj.indibox.find('button').index( $(this) );
		gotoidx= 0;
		direct = "next";
		var $gototarget ="";
		if(auturunchk) {
			fnautostop(e);
		}
		if(elemobj.indibox.find('button.active').index() == thisidx ) return;
		self.gotoinit($gototarget, thisidx, direct, e);

	}


	/* list item keydown */

	function evtkey(e){
		var $this = $(this);
		var $elem = elemobj.targetcontainer.find('li');
		var idx;
		viewLen = $elem.length;
		if(elemobj.targetItem.length <= 1) return;

		if(e.shiftKey && e.keyCode == 9) {
			if ($this.index() == 0) {
				if (self.inddicatorchk && elemobj.indibox.find('button').length > 1) {
					e.preventDefault();
					idx = $this.closest('li').data('id');
					elemobj.indibox.find('button').eq(idx-1).focus();
				} else {
					//$moveitem = elemobj.targetcontainer.find('li[data-id=' + parseInt(idx - 1) + ']');
					//$moveitem.find('a:last-child').focus();
				}
			}

			if(elemobj.indibox.data("indiSrc") == true) {
				e.preventDefault();
				elemobj.indibox.find('button').eq( $this.closest('li').data('id')-1 ).focus();
			}

		} else if(e.keyCode == 9) {
			if($this.closest('li').data('id') == elemobj.targetItem.length) {
				if($this.index() != elemobj.targetcontainer.find('li[data-id='+ elemobj.targetItem.length +'] a:last-child').index()) return;
			}

			if($this.index() == parseInt(elemobj.targetcontainerdata[LAE.IS_VIEWTYPE]-1)) {
				if(self.inddicatorchk && elemobj.indibox.find('button').length > 1) {

					if($this.closest('li').data('id') == elemobj.targetItem.length) {
						if ($this.index() != elemobj.targetcontainer.find('li[data-id=' + elemobj.targetItem.length + '] a:last-child').index()) {
							e.preventDefault();
							self.fnUInextbtn(e);
							elemobj.targetcontainer.find('li a.UIslider-con').attr('tabindex', '0');
						}
					} else {
						e.preventDefault();
						elemobj.speed = 0;
						self.fnUInextbtn(e);
						elemobj.indibox.find('button').eq( $this.closest('li').data("id") ).focus();
					}
				} else {
					self.fnUInextbtn(e);
				}
			}

			if($this.closest('li').data('id') == elemobj.targetItem.length) {
				if($this.index() != elemobj.targetcontainer.find('li[data-id='+ elemobj.targetItem.length +'] a:last-child').index()) return;
			}


			if($target.find(elemobj.indibox).data("indiSrc") == true) {
				if($this.closest('li').data('id') == elemobj.targetItem.length) return;
				e.preventDefault();
				elemobj.speed = 0;
				self.fnUInextbtn(e);
				elemobj.indibox.find('button').eq( $this.closest('li').data('id') ).focus();
			}

		}

	}


	/* list item focus */

	function evtfocus(e) {
		var $this = $(this);
		if(auturunchk) {
			fnautostop(e);
		}
		//console.log("chk")
		var $elem = elemobj.targetcontainer.find('li');
		viewLen = $elem.length;
		elemobj.speed = 0;
		if(elemobj.targetItem.length <= 1) return;
		if($this.closest('li').data('id') == 1) {
			if($this.index() == elemobj.targetcontainer.find('li[data-id='+ elemobj.targetItem.length +'] a:first-child').index()) {
				e.preventDefault();

				gotoidx= 0;
				direct = "next";
				var $gototarget ="";
				self.gotoinit($gototarget, 0, direct, e);
				//$this.focus();
			}
		}

		if($this.closest('li').data('id') == viewLen) {
			if($this.index() == elemobj.targetcontainer.find('li[data-id='+ elemobj.targetItem.length +'] a:last-child').index()) {
				e.preventDefault();
				//console.log("chkde")
				elemobj.speed = 0;
				direct = "prev";
				gotoidx = elemobj.targetcontainer.find('li').length - 1;
				$moveitem = elemobj.targetcontainer.find('li[data-id=' + gotoidx + ']');
			}
		}

	}


}

function UIslidersort( $target, elemobj, htmlArry ){
	var viewLen = UIresize( elemobj );
    fnResizeDom( $target, elemobj, viewLen, htmlArry);
	fnelemobjreset( $target, elemobj );
	return viewLen;
	/* 정렬  */
}

function fnResizeDom ( $target, elemobj, viewLen, htmlArray ){

	var Len = Math.ceil( htmlArray.length / viewLen ) ;
	var itemboxHtml = '';
	var statNum = 1;
	if(elemobj.targetWrap.data("onslider")) {
		var modearr = [];
		modearr = elemobj.targetWrap.data("onslider").split("-");
	}

	for (var i = 1; i <= Len;i++){
		if(i == 1) {
			//itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '">';
			if(elemobj.targetWrap.data("onslider")) {
				if (modearr.indexOf(LAE.IS_VIEWTYPE) == -1 && i > elemobj.targetWrap.data(LAE.IS_VIEWTYPE)) {
					itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '" style="display:none">';
				} else {
					itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '">';
				}
			} else {
				itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '">';
			}
		} else {
			if(elemobj.targetWrap.data("onslider")) {
				if (modearr.indexOf(LAE.IS_VIEWTYPE) == -1 && i > elemobj.targetWrap.data(LAE.IS_VIEWTYPE)) {
					itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '">';
				} else {
					itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '">';
				}
			} else {
				itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '">';
			}
			//itemboxHtml += '<li class="UIslider-item" data-id="' + parseInt(i) + '">';
		}
		itemboxHtml += '<div class="UIslider-box">';

		for (var j = statNum; j <= htmlArray.length ; j++) {

			if ((j % viewLen) === 0){

				itemboxHtml += htmlArray[j-1];
				statNum = j + 1;
				break;
			}

			itemboxHtml += htmlArray[j-1];
		}

		itemboxHtml += '</div>';
		itemboxHtml += '</li>'
	}


	elemobj.targetcontainer.find('li').remove();
	elemobj.targetcontainer.append( itemboxHtml );
	var $reitnaItem = $('.retinaimg');
	if($reitnaItem.length > 0) {
		$reitnaItem.RetinaImg();
	}
}

