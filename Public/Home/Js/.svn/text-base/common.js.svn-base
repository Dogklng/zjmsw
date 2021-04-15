var langUrl = LAE.LANGURL;
var nationUrl = LAE.NATIONURL;
/*

 var handler = function(e) {
 e.preventDefault();
 };

 function fnGnbScrollhandler(){
 var $body = $('body');
 if(LAE.IS_VIEWTYPE != 'web'){
 if($body.hasClass('mobgnbopen') || $body.hasClass('schopen')) {
 $body.bind('touchmove', handler);
 $body.bind('ontouchstart', handler);
 } else {
 $body.unbind('touchmove', handler);
 $body.unbind('ontouchstart', handler);
 }
 }
 }
 */

(function( $ )
{
	"use strict";
	$( function()
	{

		var $body = $( 'body' );
		var $wrapper = $( '.wrapper' );
		var $gnb = $( '.gnb' );
		var $searhcbtnwrap = $( '.header-totsch' );
		var $searhcbtn = $searhcbtnwrap.find( 'button' );
		var $searhcbtnimg = $searhcbtn.find( 'img' );
		var $searhbox = $( '.gnb-search' );
		var $inputbox = $( '.gnbsearch-btn' );
		var $inputsubmitbtn = $inputbox.find( 'button[type=submit]' );
		var extendsch, extendGnb, extenddimmd;

		$( document ).ready( init );

		function init()
		{

			//if($wrapper.hasClass('subpage')){
			LAE.IS_SIZE.MAXTABLET = 999;
			SetViewSize();
			CheckMobile();
			DeivceChkFn();
			//}
			fnGnbSearch();
			fnLabelFocus();
			fnClearSchtext();
			LAE.FUNCLOAD.fnGnbserachOpen = fnGnbserachOpen;
		}

		function fnGnbSearch()
		{

			extendsch = new fnGnbserachOpen;
			$searhcbtn.on( 'click', fnGnbserachevt );
			$inputsubmitbtn.on( 'focusout', focusevt );
		}

		function focusevt()
		{
			extendsch.schclose();
			extendsch.schtoggle();
			extenddimmd.dimmClose();
		}

		function fnGnbserachevt( e )
		{
			extenddimmd = new LAE.FUNCLOAD.fndimmd;
			if( $searhcbtn.hasClass( 'active' ) )
			{
				extendsch.schclose();
				extendsch.schtoggle();
				extenddimmd.dimmClose();
			}
			else
			{
				if( $body.hasClass( 'mobgnbopen' ) || $gnb.data( 'targetName' ) == 'Product' || $gnb.data( 'targetName' ) == "LaneigeStory" )
				{
					extendGnb = new LAE.FUNCLOAD.fnMobOpen;
				}
				else
				{
				}
				extendsch.schopen();
				extendsch.schtoggle();
				extenddimmd.dimmOpen();
			}
		}

		function fnGnbserachOpen()
		{

			this.schclose = function()
			{
				$searhcbtn.removeClass( 'active' );
				$searhcbtnimg.attr( 'src', $searhcbtnimg.data( 'schNormal' ) );
			};

			this.schopen = function()
			{
				$searhcbtn.addClass( 'active' );
				$searhcbtnimg.attr( 'src', $searhcbtnimg.data( 'schActive' ) );
			};

			this.schtoggle = function()
			{

				$body.toggleClass( 'schopen' );
				$searhbox.stop().animate( {
					height: "toggle"
				}, 300, function()
				{
				} );
			};

		}

		function fnClearSchtext()
		{
			var $this = $inputbox.find( 'button[type=button]' );
			$this.on( 'click', fnInputClearText )
		}

		function fnInputClearText()
		{
			$searhbox.find( 'input[type=text]' ).val( "" );
			$searhbox.find( 'label' ).removeClass( 'hide' );
		}

		function fnLabelFocus()
		{
			$searhbox.find( 'input[type=text]' ).on( {
				'focusin': function()
				{
					$( this ).siblings( 'label' ).addClass( 'hide' );
				},
				'focusout': function()
				{
					if( !$( this ).val() )
					{
						$( this ).siblings( 'label' ).removeClass( 'hide' );
					}
				}
			} )
		}

	} );
})( jQuery );

/*
 *
 * 작성자 : 문승연
 * gnb
 *
 * */

(function( $ )
{
	"use strict";
	$( function()
	{
		var self = this;
		var $html = $( 'html' );
		var $body = $( 'body' );
		var $wrapper = $( '.wrapper' );
		var $header = $( '.header' );
		var $mobbtn = $( '.mobopen-gnbbtn' );
		var $gnb = $( '.gnb' );
		var $dep1 = $( '.dep1' );
		var $dep1lnk = $dep1.children( 'a' );
		var $dep2wrap = $( '.dep2wrap' );
		var $dep2list = $( '.dep2list' );
		var $dep2 = $( '.dep2' );
		var $dep3 = $( '.dep3' );
		var $dep2lnk = $dep2.children( 'a' );
		var $dimmd = $( '.dimmd' );
		var speed = 700;
		var exSearch, lastFocus;
		var $firstFocus;
		var effect = "easeOutQuad";
		var layoldview = LAE.IS_VIEWTYPE;
		var $old1dep;

		var newchk3dep, oldchk3dep;

		$( document ).ready( init );

		function init()
		{
			if( $dep1.length > 0 && $dep3.length > 0 )
			{
				LAE.FUNCLOAD.fndimmd();
				exSearch = new LAE.FUNCLOAD.fnGnbserachOpen;
				fnDivcesubchk();
				fnGnbDeiveEvt();
				fnProductdep3();
				//var lastfocusable = new LAE.FUNCLOAD.focusable($gnb);
				//var lastfocusable = $('.dep1:last-child').find('.dep2wrap:last-child .dep2:last-child a');

				//console.log(lastfocusable)
				//alert($firstFocus)
				//console.log($firstFocus)
				lastFocus = $( '.dep1:last-child' ).find( '.dep2wrap:last-child .dep2:last-child a' );
			}

		}

		function fnProductdep3()
		{
			if( LAE.IS_VIEWTYPE == 'web' )
			{
				$dep1.eq( 1 ).find( $dep2list ).css( "margin-left", $dep1.offset().left + $dep1.eq( 0 ).width() );
				$dep3.css( "margin-left", $dep1.offset().left + $dep1.eq( 0 ).width() )
			}
		}

		LAE.FUNCLOAD.fndimmd = function()
		{
			this.dimmOpen = function()
			{
				$dimmd.css( {
					'display': 'block',
					'height': $wrapper.height()
				} );
			};

			this.dimmClose = function()
			{
				$dimmd.css( {
					'display': 'none'
				} );
			};

			if( $body.hasClass( 'mobgnbopen' ) )
			{
				this.dimmOpen();
			}
			else
			{
				this.dimmClose();
			}
		};

		LAE.FUNCLOAD.fnMobOpen = function()
		{
			$gnb.data( 'gnbEvent', '' );
			$gnb.data( 'targetName', '' );
			fnGnbDeiveEvt();
			$body.toggleClass( 'mobgnbopen' );
			fnGnbOverflow();
			var lastfocusable = new LAE.FUNCLOAD.focusable( $gnb );
			$firstFocus = $dep1.eq( 0 ).children( 'a' );
			lastFocus = $( '.dep1:last-child' ).find( '.dep2wrap:last-child .dep2:last-child a' );
			var gnb = document.getElementById( "gnb" );

			this.fnTggleGnb = function()
			{
				if( $body.hasClass( 'mobgnbopen' ) )
				{
					$dep2list.attr( 'style', '' );
					$dep2wrap.attr( 'style', '' ).css( 'height', 'auto' );
					$dep1.removeClass( "active" );
					$dep1lnk.removeClass( "active" );
				}
				$dep1lnk.find( 'span' ).find( 'img' ).attr( 'src', $gnb.data( 'dep1Normal' ) )
				$gnb.stop().animate( {
					height: "toggle"
				}, speed, function()
				{
				} );
			};
			this.fnDephide = function()
			{
				$gnb.data( 'targetName', '' );
				fnWebclose();
				fnWebClosedep3();
			};

			if( LAE.IS_VIEWTYPE != 'web' )
			{
				this.fnTggleGnb();
			}
			else
			{
				this.fnDephide();
			}

			LAE.FUNCLOAD.fndimmd();
			fnschClose();
		};

		function fnWebOpen( e )
		{
			if( e.type == "keydown" )
			{
				if( e.keyCode != 13 )
				{
					return;
				}
			}

			var $this = $( this );
			if( e.type == "focus" )
			{
				speed = 0;
			}
			else
			{
				speed = 700;
			}

			if( $dimmd.hasClass( 'mobgnbopen' ) || $body.hasClass( 'schopen' ) )
			{
				LAE.FUNCLOAD.dimmClose();
			}

			if( $gnb.data( 'targetName' ) == $this.text() )
			{
				if( LAE.IS_VIEWTYPE == 'web' )
				{
					e.preventDefault();
					exSearch.schclose();
					LAE.FUNCLOAD.dimmClose();
					$gnb.data( 'targetName', '' );
					return;
				}
				else
				{
					$dep1lnk.find( 'span' ).find( 'img' ).attr( 'src', $gnb.data( 'dep1Normal' ) )
				}
			}

			fnWebclose();

			if( $this.next().html() != undefined )
			{

				if( $gnb.data( 'targetName' ) != $this.text() )
				{
					$this.addClass( "active" );
					$this.parent().addClass( "active" );
					$dep1lnk.find( 'span' ).find( 'img' ).attr( 'src', $gnb.data( 'dep1Normal' ) )
					$this.find( 'span' ).find( 'img' ).attr( 'src', $gnb.data( 'dep1Active' ) )
				}
				else
				{
					$this.find( 'span' ).find( 'img' ).attr( 'src', $gnb.data( 'dep1Normal' ) )
				}
			}
			else
			{
				if( LAE.IS_VIEWTYPE != 'web' )
				{
					//document.location.href= $this.href();
					document.location.href = $this.attr( 'href' );
				}
				$dep1lnk.find( 'span' ).find( 'img' ).attr( 'src', $gnb.data( 'dep1Normal' ) )

			}

			if( $gnb.data( 'targetName' ) != $this.text() )
			{
				$gnb.data( 'targetName', $this.text() );
			}
			else
			{
				$gnb.data( 'targetName', '' );
			}

			fnProductdep3();
			if( $body.hasClass( 'schopen' ) )
			{
				fnschClose();
			}

			if( $this.hasClass( 'active' ) )
			{
				/*$this.next().stop().animate({
				 height: "toggle"
				 }, speed, function () {
				 });*/
				$dep2wrap.css( {
					'height': 'auto'
				} );
				var thisnextHeight = $this.next().height();
				$this.next().css( {
					'height': '0',
					'display': 'block',
					'overflow': 'hidden'

				} );
				TweenMax.killTweensOf( $this.next() );
				TweenMax.to( $this.next(), 0.7, {
					height: thisnextHeight,
					onComplete: comShow,
					onCompleteParams: [ $this.next() ]
				} )
			}

			if( LAE.IS_VIEWTYPE == 'web' )
			{
				if( $gnb.data( 'targetName' ) == $this.text() )
				{
					$gnb.data( 'targetName', '' );
				}
			}

			return false;
		}

		function comShow( $target )
		{
			$target.css( {
				'overflow': 'visible'
			} );
		}

		function fnGnbOverflow()
		{
			if( $body.hasClass( 'mobgnbopen' ) && LAE.IS_VIEWTYPE != "web" )
			{
				var headerH = $header.css( 'height' );
				var targetboxH;
				targetboxH = LAE.VIEWPORT_HEIGHT - parseInt( headerH );
				$gnb.css( {
					"height": targetboxH
				} )
			}
		}

		/* 16.12.12 bdsnack 윤지혜 gnb depth3 관련 수정 s */
		function fnWebOpendep3( e )
		{
			var $this = $( this );
			var thisidx = $this.parent().index();
			var isDepth3 = $dep3.eq( thisidx ).find( 'dd' ).length > 0;

			if( e.type == "focus" )
			{
				speed = 0;
			}
			else
			{
				speed = 700;
			}

			$dep2.removeClass( 'active' );
			$dep2lnk.removeClass( 'active' );

			//depth3 check
			if( isDepth3 )
			{
				if( $this.next().html() != undefined )
				{
					$this.parent().addClass( "active" );
					$this.addClass( "active" );
				}

				if( $this.hasClass( 'active' ) )
				{
					e.preventDefault();
					$this.next().css( {
						'height': 'auto'
					} );
					var thisnextHeight = $this.next().height();
					$this.next().css( {
						'height': '0',
						'display': 'block',
						'overflow': 'hidden'

					} );

					TweenMax.killTweensOf( $this.next() );
					TweenMax.to( $this.next(), 0.7, {
						height: thisnextHeight,
						onComplete: comShow,
						onCompleteParams: [ $this.next() ]
					} );

				}
			}

			//console.log('-thisidx:', thisidx);
			$dep3.each( function( idx )
			{
				if( thisidx != idx )
				{
					$dep3.eq( idx ).css( {
						'overflow': 'hidden'
					} );
					TweenMax.killTweensOf( $dep3.eq( idx ) );
					TweenMax.to( $dep3.eq( idx ), 0.7, {
						height: 0,
						onComplete: comHide,
						onCompleteParams: [ $dep3.eq( idx ) ]
					} )
				}
			} );

		}

		/* 16.12.12 bdsnack 윤지혜 gnb depth3 관련 수정 e */

		function fnWebClosedep3()
		{
			var dep2len = $dep2.length;
			//			for (var i = 0; i <= dep2len - 1; i++) {
			//if (!$dep2.eq(i).children('a').hasClass('active')) {

			$dep2.each( function( idx )
			{
				//if(!$(this).hasClass('active')) {

				var $dep3elem = $( this ).find( $dep3 );
				$dep3elem.removeClass( 'active' );
				$dep3elem.children( 'a' ).removeClass( 'active' );
				$dep3elem.css( {
					'overflow': 'hidden'
				} );
				TweenMax.killTweensOf( $dep3elem );
				TweenMax.to( $dep3elem, 0.2, { height: 0, onComplete: comHide, onCompleteParams: [ $dep3elem ] } );
				//}

			} );

			/*$dep2.eq(i).find($dep3).stop().animate({
			 height: "toggle"
			 }, speed, function () {
			 });*/

			//	}
			//$dep2.children('a').removeClass('active');

			//}
		}

		function fnschClose()
		{
			//if($body.hasClass('schopen') || $gnb.data('targetName') == 'Product' || $gnb.data('targetName') == "LaneigeStory"){
			if( $body.hasClass( 'schopen' ) )
			{
				//alert("cc")
				exSearch.schclose();
				exSearch.schtoggle();
				fnWebClosedep3();
			}
		}

		function fnWebclose()
		{
			var dep1Len = $dep1.length;
			fnWebClosedep3();
			for( var i = 0; i <= dep1Len - 1; i++ )
			{
				var $dep1Target = $dep1.eq( i ).children( 'a' );
				if( $dep1Target.hasClass( 'active' ) )
				{
					$dep1Target.next().css( {
						'overflow': 'hidden'
					} );
					TweenMax.killTweensOf( $dep1Target.next() )
					TweenMax.to( $dep1Target.next(), 0.7, {
						height: 0,
						onComplete: comHide,
						onCompleteParams: [ $dep1Target.next() ]
					} )
				}
			}
			$dep1.removeClass( "active" );
			$dep1lnk.removeClass( "active" );

		}

		function comHide( $target )
		{
			$target.css( {
				"display": "none",
				"overflow": "auto",
				"height": "auto"
			} );

			//console.log($target.closest('.dep1').hasClass('active'))
			//console.log($target.closest('.dep1').children('a').text() == $gnb.data("targetName"))
			//$gnb.data("targetName",'')
		}

		function mobLastfocus( e )
		{
			var keyCode = e.keyCode || e.which;
			if( keyCode == 9 )
			{
				LAE.FUNCLOAD.fnMobOpen();
			}
		}

		function mobclosefocus( e )
		{
			if( e.keyCode == 9 && e.shiftKey )
			{
			}
			else
				if( e.keyCode == 9 )
				{
					fnWebclose();
				}
		}

		function mobFirstfocus( e )
		{
			if( e.keyCode == 9 && e.shiftKey )
			{
				fnWebclose();
			}
		}

		function fnOffEvt()
		{
			$mobbtn.off( 'click', LAE.FUNCLOAD.fnMobOpen );
			$dep1lnk.off( 'click', fnWebOpen );
			$dep1lnk.off( 'keydown', fnWebOpen );
			$dep1lnk.off( 'mouseenter', fnWebOpen );
			$dep1lnk.off( 'focus', fnWebOpen );
			$dep2lnk.off( 'mouseenter', fnWebOpendep3 );
			//$dep2lnk.off('mouseleave', fnWebClosedep3);
			$dep2lnk.off( 'focus', fnWebOpendep3 );
			//console.log(firstFocus)
			$firstFocus = $dep1.eq( 0 ).children( 'a' );
			$firstFocus.off( 'keydown', mobFirstfocus );
			//console.log(lastFocus)
			lastFocus = $( '.dep1:last-child' ).find( '.dep2wrap:last-child .dep2:last-child a' );
			lastFocus.off( 'keydown', mobLastfocus );
			$dep3.off( 'mouseenter', fnWebOpendep3 );
			$gnb.off( 'mouseleave', fnWebclose );
		}

		/* device event */

		function fnGnbDeiveEvt()
		{
			if( LAE.IS_VIEWTYPE != 'web' )
			{
				$gnb.data( 'gnbEvent', '' );
				fnOffEvt();
				$dep1lnk.on( 'click', fnWebOpen );

				lastFocus.on( 'keydown', mobLastfocus );
			}
			else
			{
				lastFocus = $( '.dep1:last-child' ).find( '.dep2wrap:last-child .dep2:last-child a' );

				lastFocus.on( 'keydown', mobclosefocus );

				$gnb.data( 'gnbEvent', 'clickEvt' );
				fnOffEvt();
				$firstFocus = $dep1.eq( 0 ).children( 'a' );
				$firstFocus.on( 'keydown', mobFirstfocus );
				$dep1lnk.on( 'mouseenter', fnWebOpen );
				$dep1lnk.on( 'focus', fnWebOpen );
				$dep2lnk.on( 'mouseenter', fnWebOpendep3 );
				//$dep2lnk.on('mouseleave', fnWebClosedep3);

				$dep2lnk.on( 'focus', fnWebOpendep3 );
				$dep3.on( 'mouseenter', fnWebOpendep3 );
				$gnb.on( 'mouseleave', fnWebclose );
			}
			$mobbtn.on( 'click', LAE.FUNCLOAD.fnMobOpen );

		}

		/* resize */

		$( window ).on( 'resize', fnheaderResize );

		function fnheaderResize( e )
		{

			$gnb.data( 'gnbEvent', '' );
			$gnb.data( 'targetName', '' );
			//alert(LAE.IS_VIEWTYPE)
			if( LAE.IS_VIEWTYPE == 'web' )
			{
				$gnb.attr( 'style', '' );
				$dep2wrap.attr( 'style', '' );
				fnschClose();
				fnWebclose();
				$body.removeClass( 'mobgnbopen' );
				$body.removeClass( 'schopen' );
				$dep2lnk.removeClass( "active" );
				$dep1lnk.removeClass( "active" );
				$dep1.removeClass( "active" );
				fnschClose();
				LAE.FUNCLOAD.dimmClose();
				$dep2wrap.attr( 'style', '' );
				$gnb.css( 'display', 'block' );
				$gnb.attr( 'style', '' );
				$dep3.attr( 'style', '' );
				$dep2wrap.attr( 'style', '' );
				$dep2list.attr( 'style', '' );
				fnProductdep3();

				fnschClose();

				//$gnb.niceScroll().resize();
			}
			else
				if( LAE.IS_VIEWTYPE != 'web' )
				{
					fnGnbOverflow();
					//LAE.FUNCLOAD.fndimmd();
					$dep2wrap.attr( 'style', '' );
					$dep3.attr( 'style', '' );
					//fnschClose();
					$gnb.data( 'targetName', '' )
				}
			//fnschClose();
			//LAE.DELAY_FUNC(function () {
			fnGnbDeiveEvt();
			SetViewSize();
			//}, 200);

		}
	} );
})( jQuery );

$( document ).ready( customUIinit );

function customUIinit()
{

	/* kwcag mark */
	function markHide()
	{
		if( LAE.IS_MOBILE )
		{
			$( '.kwacc-mark' ).hide();
		}
	}

	markHide();
	//$(window).on('resize', markHide );

	// 체크박스 라디오버튼 디자인 바인딩
	var $checkbox = $( 'input.iCheck-default' );
	if( $checkbox.length )
	{
		$checkbox.iCheck( {
			checkboxClass: 'icheckbox_minimal',
			radioClass: 'iradio_minimal',
			increaseArea: '20%',
			aria: true
		} );
	}

	// 체크박스 라디오버튼 디자인 바인딩
	var $radiobox = $( 'input.iCheck-bluetype' );
	if( $radiobox.length )
	{
		$radiobox.iCheck( {
			checkboxClass: 'icheckbox_minimal bluetype',
			radioClass: 'iradio_minimal bluetype',
			increaseArea: '20%',
			aria: true
		} );
	}

	//셀렉트 디자인 바인딩
	var $designSelect = $( 'select' );
	$designSelect.jqListBox( 'init' );

	// 셀렉트 커스텀
	var $jqListbox = $( '.jqListBox' );
	$jqListbox.on( 'click', checkThis );

	function checkThis()
	{
		var $this = $( this );
		var thisidx = $jqListbox.index( $this );
		var $closeTarget;

		$jqListbox.each( function( idx )
		{
			if( idx != thisidx )
			{
				$closeTarget = $jqListbox.eq( idx ).siblings( 'select' );
				$closeTarget.jqListBox( "close" );
			}
		} );
	}

	var $inputtype = $( "input[type=text], input[type=password]" );

	function closeJqlist()
	{
		var $jqListElem = $( '.jqListbox-adapt' );
		if( $jqListElem.length )
		{
			$designSelect.jqListBox( 'close' );
		}
	}

	$inputtype.on( 'focus', closeJqlist );

	$( 'input' ).on( 'ifChecked', function()
	{
		closeJqlist();
	} );

	//커스텀 셀렉트에 연결된 label 포커스
	$( 'label' ).on( 'click', function( e )
	{
		var $customeSelect = $( '[data-origin="' + $( this ).attr( 'for' ) + '"]' );

		if( $customeSelect.length )
		{
			e.preventDefault();
			$customeSelect.find( '.jqListBox-combo' ).focus();
		}
	} );

}

(function( $ )
{
	"use strict";
	$( function()
	{

		$( document ).ready( tabtypebox );

		function tabtypebox()
		{
			var $tabdropbox = $( '.tabtype-dropbox' );
			var $tabdroplistbox = $tabdropbox.find( 'ul' );
			var $tabdroplist = $tabdroplistbox.find( 'li' );
			var $tabdroplistlnk = $tabdroplist.find( 'a' );
			var $tabcatebox = $( '.tabtype-category' );
			var $tabbox = $tabcatebox.find( '.tabtype-category-wrap' );
			var tabselected = new listfaq( $tabcatebox, $tabdropbox, $tabbox );
			$tabdroplistlnk.on( 'keydown', tablistevt );
			var oldviewType;

			function tablistevt( e )
			{
				if( LAE.IS_VIEWTYPE != 'mobile' ) return;
				var $this = $( this );
				if( $this.closest( 'li' ).index() == $tabdroplist.length - 1 )
				{
					tabselected.statchk();
				}
			}

			$( window ).resize( tabresize );

			function tabresize()
			{
				if( oldviewType == LAE.IS_VIEWTYPE ) return;
				$tabdropbox.removeClass( 'active' );
				if( !$tabbox.hasClass( 'UIslider-content' ) )
				{
					$tabbox.stop().attr( 'style', '' );
				}
				tabselected.oldidx = null;

				oldviewType = LAE.IS_VIEWTYPE;
			}
		}
	} );
})( jQuery );

function efftoogleopen()
{

	this.listOpen = function( $target )
	{
		$target.stop().slideDown( function()
		{
			$target.attr( 'style', '' ).css( 'display', 'block' )
		} );
	};

	this.listClose = function( $target )
	{
		$target.stop().slideUp( function()
		{
			$target.attr( 'style', '' ).css( 'display', 'none' )
		} );
	};
}

function listfaq( $container, $list, $dropbox )
{

	var self = this;
	var $reviewContainer = $container;
	var $reviewList = $reviewContainer.find( $list );
	var $reviewslide = $reviewList.find( $dropbox );
	var $reviewEvttarget = $reviewList.find( '.listfaqevt' );

	var toogleopen = new efftoogleopen();

	function add_event()
	{
		$reviewEvttarget.on( 'click', self.statchk );
	}

	this.statchk = function()
	{
		var $this = jQuery( this );
		var $thislist = $this.closest( $reviewList );
		self.idx = $thislist.index();
		if( self.idx != self.oldidx )
		{
			$reviewList.removeClass( 'active' );
			$thislist.addClass( 'active' );
			toogleopen.listClose( $reviewList.eq( self.oldidx ).find( $reviewslide ) );
			toogleopen.listOpen( $thislist.find( $reviewslide ) );
		}
		else
		{
			$reviewList.removeClass( 'active' );
			toogleopen.listClose( $thislist.find( $reviewslide ) );
			self.idx = null;
		}
		self.oldidx = self.idx;

	};
	add_event();
}

// subpage search inputbox remove text

function inputremovetxt()
{
	var $searhbox = $( '.searchform-content' );
	var $inputbox = $( '.searchform-btn' );

	fnClearSchtext();

	function fnClearSchtext()
	{
		var $this = $inputbox.find( 'button[type=button]' );
		$this.on( 'click', fnInputClearText )
	}

	function fnInputClearText()
	{
		$searhbox.find( 'input[type=text]' ).val( "" );
		$searhbox.find( 'label' ).removeClass( 'hide' );
	}
}

(function( $ )
{
	"use strict";
	$( function()
	{

		$( document ).on( 'ready', initpos );
		$( window ).on( 'resize', initpos );
		//$(window).on('scroll', chksctop);

		function initpos()
		{
			var $topbtn = $( '.footer-topbtn' );
			var $footerwrap = $( '.footer-wrap' );
			if( !$footerwrap.length || !$topbtn.length ) return;
			$topbtn.css( {
				"right": $footerwrap.offset().left
			} );
			$topbtn.on( 'click', windowscTop )
		}

		function windowscTop()
		{
			$( 'html, body' ).stop().animate( {
				scrollTop: '0'
			}, 300 )
		}

		/*function chksctop(){
		 //$('html, body').stop()
		 }*/

	} );
})( jQuery );

(function( $ )
{
	"use strict";
	$( function()
	{

		// 디바이스별 이미지 변경
		$( document ).ready( retinareplace );

		function retinareplace()
		{
			var $reitnaItem = $( '.retinaimg' );
			if( $reitnaItem.length > 0 )
			{
				$reitnaItem.RetinaImg();
			}
		}

	} );
})( jQuery );

(function( $ )
{
	"use strict";
	$( function()
	{

		// mobile scorll overflow bug 대응
		$( document ).ready( mobileScroll );

		function mobileScroll()
		{
			var $overflowitem = $( '.jsoverflow' );

			if( !LAE.IS_MOBILE )
			{
				$overflowitem.addClass( 'jsoverscroll' );
			}

			if( $overflowitem.length > 0 && LAE.IS_MOBILE )
			{
				$overflowitem.niceScroll();
			}

		}

	} );
})( jQuery );

/* open window (url, tit, width, height, scroll[true||false]) */
function openWindowPopup( url, title, width, height, scroll )
{
	if( !LAE.IS_MOBILE )
	{
		var top = ($( window ).height() / 2) - (height / 2);
		var left = ($( window ).width() / 2) - (width / 2 );
		var scrollbars = scroll ? "yes" : "no";
		window.open( url, 'width=' + width + ', height=' + height + ', top=' + top + ', left=' + left + ', scrollbars=' + scrollbars );
	}
	else
	{
		document.location.replace( url );
	}
}

(function( $ )
{
	"use strict";
	$( function()
	{
		// 윈도우 팝업 닫기
		$( document ).ready( closepopup );

		function closepopup()
		{
			var $closebtn = $( ".popup-tit .closebtn" );
			var $closeinbtn = $( ".closebtn" );
			$closeinbtn.on( 'click', windowClose );
			/*if(LAE.IS_MOBILE) {
			 $closeinbtn.css('display','none');
			 }*/
		}

	} );
})( jQuery );

function windowClose()
{
	if( !LAE.IS_MOBILE )
	{
		window.close();
	}
	else
	{
		document.location.replace( document.referrer );
		history.go( -1 );
		history.replaceState( "", {}, '' );
		//window.location.reload();
	}
}

(function( $ )
{
	"use strict";
	$( function()
	{
		var $datepicker = $( '.js-datepicker' );
		if( !$datepicker.length ) return;
		$datepicker.datepicker( {
			inline: true,
			//nextText: '&rarr;',
			//prevText: '&larr;',
			showOtherMonths: true,
			dateFormat: 'yy-mm-dd',
			dayNamesMin: [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
			showOn: "button",
			buttonImage: "/content/dam/laneige/laneige2015/" + nationUrl + '/' + langUrl + "/components/membership/calender-ico.gif",
			buttonImageOnly: true,
			buttonText: "calendar"
		} );
	} );
})( jQuery );

function IEloadchk( arr, callback )
{
	if( !LAE.IS_IE8 ) return;
	for( var call = 0; call < arr.length; call++ )
	{
		callback = arr[ call ];
		callback()
	}
}

(function( $ )
{

	var $inreselem = $( "input, select, a, button, .jqListBox-combo, .iradio_minimal, .icheckbox_minimal" );

	var headerHeight = $( ".header" ).height();
	var scrollTop = $( window ).scrollTop();
	$inreselem.on( 'focus', focusintop );
	$( window ).on( 'resize', resizeelem );

	function focusintop()
	{
		var $this = $( this );
		var targetTop = $this.offset().top;
		if( (headerHeight + scrollTop) > targetTop )
		{
			$( window ).scrollTop( headerHeight );
		}
	}

	function resizeelem()
	{
		headerHeight = $( ".header" ).height();
	}

})( jQuery );

(function( $ )
{
	$.fn.elemani = function( duration, term, isAnimateOnVisible, visibleOffset )
	{

		var wowstat = false;
		var self = this;

		$( this ).on( 'reset', function()
		{
			if( !LAE.IS_IE8 )
			{
				var $this = $( this );
				$this.css( 'visibility', 'hidden' );
			}
		} ).trigger( 'reset' );

		this.wowinit = function()
		{
			if( !LAE.IS_IE8 || $( window ).scrollTop() == 0 )
			{
				if( !LAE.IS_IE8 )
				{
					if( wowstat ) return;
					var wow = new WOW( {
						boxClass: 'wow',      	// animated element css class (default is wow)
						animateClass: 'animated',	// animation css class (default is animated)
						offset: 0,
						mobile: false,			// distance to the element when triggering the animation (default is 0)
						live: true,
						callback: function( box )
						{
							// the callback is fired every time an animation is started
							// the argument that is passed in is the DOM node being animated
						}
					} );
					if( !LAE.IS_IE8 )
					{
						wow.init();
					}
					wowstat = true;
				}
			}
			else
			{
			}
		};

		if( !isAnimateOnVisible )
		{
			this.wowinit();
			return;
		}

		$( this ).one( 'inview', { offset: visibleOffset }, self.wowinit );

	};

})( jQuery );

$( document ).ready( function()
{
	var $wow = $( '.wow' );
	if( !LAE.IS_IE8 && $wow.length )
	{
		$wow.css( 'visibility', 'hidden' );
	}
	else
	{
		$wow.css( 'visibility', 'visible' );
	}
	//if(LAE.IS_MOBILE || LAE.IS_VIEWTYPE != "web") {
	if( LAE.IS_MOBILE )
	{
		wowRmClass( $wow );
		$wow.css( 'visibility', 'visible' );
	}
	$( document ).on( 'keydown', wowkeyfn );
	var visiblenum = 0;

	function wowkeyfn( e )
	{
		if( e.keyCode == 9 && $wow.length != visiblenum )
		{
			$wow.each( function( idx )
			{
				$wow.eq( idx ).css( 'visibility', 'visible' );
				wowRmClass( $wow.eq( idx ), 'fadeInUp' );
				visiblenum++;
			} );
		}
	}

} );

function wowRmClass( $wow, targetClass )
{
	$wow.removeClass( targetClass );
	$wow.removeClass( 'animated' );
	$wow.removeClass( 'wow' );
	$wow.css( 'visibility', 'visible' );
}

$( window ).load( function()
{
	var $wow = $( '.wow' );
	//if(LAE.IS_VIEWTYPE == "web") {
	if( !LAE.IS_MOBILE )
	{
		$wow.elemani( 1000, 200, false, 0.7 );
	}
	//} else {
	//	wowRmClass($wow);
	//	$wow.css('visibility', 'visible');
	//}
} );

//$(window).on('resize', wowreset );

function wowreset()
{
	var $wow = $( '.wow' );
	//if( LAE.IS_VIEWTYPE != "web") {
	//	console.log(LAE.IS_VIEWTYPE)
	wowRmClass( $wow );
	//	$wow.css('visibility', 'visible');
	//}
}

$( document ).on( 'click', '[data-modal]', function( e )
{
	e.preventDefault();

	if( $( this ).data( 'requireLogin' ) && isLogin() == 'N' )
	{
		if( confirm( '로그인이 필요한 서비스 입니다' ) )
		{
			//location.href='/content/beautypoint/ko-kr/header/login.html';
		}
		else
		{
			return false;
		}
	}
	else
	{
		$( this ).jqModal( $( this ).attr( 'href' ) );
	}
} );

function loadingCheck()
{
	var loadingDimmd = '';
	loadingDimmd += '<div class="loading-dimmd" aria-hidden="true" tabindex="-1"></div>'

	$( 'body' ).append( loadingDimmd );
	var $loadingDim = $( '.loading-dimmd' );

	$loadingDim.css( {
		'z-index': '10001'
	} );

	$( '.loadingbox' ).css( {
		'display': 'block',
		'z-index': '10002'
	} );
}

function loadingComplete()
{
	var $loadingDim = $( '.loading-dimmd' );
	$loadingDim.remove();
	$( '.loadingbox' ).css( {
		'display': 'none',
		'z-index': 'auto'
	} );
}

//20160108 - 브라우저 자동완성 placeholder hide - ghchoi
$( window ).load( function()
{
	setTimeout( function()
	{
		$( 'input[type=text]' ).each( function()
		{
			if( $( this ).val().length > 0 )
			{
				$( this ).siblings( 'label' ).addClass( 'hide' );
			}
		} );
	}, 100 );
	setTimeout( function()
	{
		$( 'input[type=password]' ).each( function()
		{
			if( $( this ).val().length > 0 )
			{
				$( this ).siblings( 'label' ).addClass( 'hide' );
			}
		} );
	}, 100 );
} );

/* My Two Tone Lip Bar, SOKB-OfflineClass */
$( function()
{
	$( ".tabtype-category.num4 .tab-frame li a" ).click( function()
	{

		//fromTop =
		//alert($("body").Height(););

		//alert("test");
		$( ".tabtype-category.num4 .tab-frame li" ).removeClass( "active" );
		$( this ).parent().parent( "li" ).addClass( "active" );

	} );
} );

if( window.google && google.maps )
{
	//google map - 명동 로드샵
	$( document ).ready( function()
	{
		var $mapCanvas = $( '#map_canvas' );

		if( !$mapCanvas.length ) return;

		var latlng = new google.maps.LatLng( 37.561609, 126.9851125 ),
			mapOptions = {
				center: latlng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			},
			map = new google.maps.Map( $mapCanvas.get( 0 ), mapOptions ),
			marker = new google.maps.Marker( {
				map: map,
				position: latlng,
				icon: 'http://www.laneige.com/kr/ko/my-laneige/my-two-tone-lip-bar/location-point.png'
			} );
	} );

	//google map - 명동 플래그십 스토어 16.10.20 bdsnack 윤지혜 추가
	$( document ).ready( function()
	{
		var $mapCanvas = $( '#map_canvas2' );

		if( !$mapCanvas.length ) return;

		var latlng = new google.maps.LatLng( 37.563365, 126.984414 ),
			mapOptions = {
				center: latlng,
				zoom: 15,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			},
			map = new google.maps.Map( $mapCanvas.get( 0 ), mapOptions ),
			marker = new google.maps.Marker( {
				map: map,
				position: latlng,
				icon: 'http://www.laneige.com/kr/ko/my-laneige/my-two-tone-lip-bar/location-point.png'
			} );
	} );

}

/****************
 * jqListBox
 * jQuery Custom SelectBox
 * 뷰티포인트 용 _ select사이즈 할당안함.
 *  iam@syung.kr
 *****************/
;(function( $ )
{
	"use strict";

	var isMobile = (function()
	{
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) )
		{
			return true;
		}
		else
		{
			return false
		}
	})();

	$.fn.jqListBox = function( options )
	{

		return this.each( function( index )
		{

			var $this = $( this ),
				Len = $this.find( 'option' ).length,
				origin_Txt = [],
				origin_Tit = [],
				origin_Val = [],
				IndexZ = 20 - index,
				selectedIdx = $this.find( 'option:selected' ).index();

			var _className = ($this.data( 'class' )) ? ' ' + $this.data( 'class' ) : '',
				_idName = ($this.attr( 'id' )) ? 'data-origin="' + $this.attr( 'id' ) + '"' : '',
			//_selectTitle = ($this.attr('title')) ? 'title="'+$this.attr('title')+'"' : '',
				_originWidth = ($this.data( 'width' )) ? $this.data( 'width' ) : $this.width(),
				_maxHeight = ($this.data( 'maxheight' )) ? 'max-height:' + $this.data( "maxheight" ) + 'px;' : '';

			$.each( $this.find( 'option' ), function()
			{
				var list = $( this );
				origin_Txt.push( list.text() );
				origin_Val.push( list.val() );
				//origin_Tit.push( ( list.attr('title') ) ? list.attr('title') : list.text() );
			} );

			var make = {
				el: function()
				{
					var $listbox = $this.next( '.jqListBox' ),
						$combo = $listbox.find( '.jqListBox-combo' ),
						$comboTxt = $combo.find( '.jqListBox-combo-txt' ),
						$comboArrow = $combo.find( '.jqListBox-combo-arrow' ),
						$list = $listbox.find( '.jqListBox-list' ),
						$option = $list.find( '.jqListBox-option' ),
						$btnData = $this.parent().data( "selectdataTargetclass" );

					return {
						listbox: $listbox,
						combo: $combo,
						comboTxt: $comboTxt,
						comboArr: $comboArrow,
						list: $list,
						option: $option,
						btndata: $btnData
					}
				},

				init: function()
				{
					var _this = this;
					_this.make();
					_this.bind();
					_this.change( selectedIdx );
					if( isMobile )
					{
						_this.mobileType();
					}
				},

				make: function()
				{
					var html = '';
					var selected = '';

					html += '<div class="jqListBox' + _className + '"' + _idName + 'style="z-index:' + IndexZ + '">';
					html += '<div class="jqListBox-combo" id="jqListBox-combo-' + index + '" ' + _selectTitle + ' tabindex="0" role="combobox" aria-autocomplete="list" aria-owns="jqListBox-list-' + index + '"><span class="jqListBox-combo-txt" data-id="0">' + origin_Txt[ 0 ] + '</span><span class="jqListBox-combo-arrow"></span></div>';
					html += '<ul class="jqListBox-list" id="jqListBox-list-' + index + '"role="listbox" aria-hidden="false" role="listbox" aria-labelledby="jqListBox-combo-' + index + '" aria-expanded="false" style="display:none;' + _maxHeight + '">';

					for( var i = 0; i < Len; i++ )
					{
						if( i != 0 )
						{
							html += '<li class="jqListBox-option" id="jqListBox-option-' + index + '-' + i + '" data-id="' + i + '" data-val="' + origin_Val[ i ] + '"role="option" tabindex="0">' + origin_Txt[ i ] + '</li>';
						}
						else
						{
							html += '<li class="jqListBox-option selected" id="jqListBox-option-' + index + '-' + i + '" data-id="' + i + '" data-val="' + origin_Val[ i ] + '" role="option" tabindex="0">' + origin_Txt[ i ] + '</li>';
						}
					}
					html += '</ul>';
					html += '</div>';

					$this.hide().after( html );
					//this.setWidth();
				},
				/*

				 setWidth : function(){
				 var el = this.el();
				 var calWidth = parseInt( _originWidth - el.comboArr.outerWidth() ,10);
				 el.comboTxt.width(calWidth);
				 el.combo.width(_originWidth);
				 el.list.width(el.combo.width());
				 },
				 */

				change: function( idx )
				{
					var el = this.el();

					if( $this.prop( 'disabled' ) )
					{
						return false;
					}

					el.option.removeClass( 'selected' ).eq( idx ).addClass( 'selected' );
					el.combo.find( '.jqListBox-combo-txt' ).attr( 'data-id', idx ).text( origin_Txt[ idx ] );
					el.combo.attr( 'aria-activedescendant', el.option.eq( idx ).attr( 'id' ) );
					$this.find( 'option:eq(' + idx + ')' ).prop( "selected", true ).end().change();

					if( el.btndata != undefined )
					{
						$( "." + el.btndata ).text( origin_Txt[ idx ] )
					}

				},

				open: function()
				{
					var el = this.el();

					if( $this.prop( 'disabled' ) )
					{
						return false;
					}

					el.combo.find( '.jqListBox-combo-arrow' ).addClass( 'on' );
					el.list.slideDown( 100, function()
					{
						el.list.find( '.selected' ).focus();
						if( el.list.closest( '.jqListbox-adapt' ).hasClass( 'jqdate' ) )
						{
							el.list.css( 'overflow-y', 'scroll' );
						}
					} ).attr( 'aria-expanded', 'true' );
					el.list.width( Math.floor( el.combo.width() ) );
				},

				close: function( check )
				{
					var el = this.el();
					if( !check )
					{
						el.combo.focus().find( '.jqListBox-combo-arrow' ).removeClass( 'on' );
					}
					else
					{
						el.combo.find( '.jqListBox-combo-arrow' ).removeClass( 'on' );
					}
					el.list.slideUp( 100 ).attr( 'aria-expanded', 'false' );
				},

				mobileType: function()
				{
					var el = this.el();
					$this.css( {
						'position': 'absolute',
						'display': 'block',
						'opacity': 0
					} ).next( '.jqListBox' ).css( 'z-index', '-1' );
					//alert(_originWidth)
					$this.change( function()
					{
						var idx = $( this ).find( 'option:selected' ).index();
						el.option.removeClass( 'selected' ).eq( idx ).addClass( 'selected' );
						el.combo.find( '.jqListBox-combo-txt' ).attr( 'data-id', idx ).text( origin_Txt[ idx ] );
					} );
				},
				unbind: function()
				{
					var el = this.el();
					el.combo.off();
					el.option.off();
					el.option.last().off();
					el.listbox.off();
				},

				bind: function()
				{
					var _this = this;
					var el = this.el();
					var listLen = el.option.length;

					el.combo.on( {
						'click': function( e )
						{
							if( el.list.is( ':visible' ) )
							{
								_this.close();
							}
							else
							{
								_this.open();
							}
							e.preventDefault();
						},
						'keydown': function( e )
						{
							var idx = el.option.filter( '.selected' ).index();
							if( e.shiftKey )
							{
								if( e.keyCode == 9 )
								{
									_this.close();
								}
							}
							else
								if( !e.altKey )
								{
									switch( e.keyCode )
									{

										case 13 :
											//e.preventDefault();
											_this.open();
											break;

										case 27 :	//esc
											_this.close();
											break;

										case 32 :	//space
											_this.open();
											break;

										case 33 :	//pageUp
											if( idx >= 3 )
											{
												el.option.eq( idx - 3 ).click();
											}
											else
											{
												el.option.eq( 0 ).click();
											}
											e.preventDefault();
											break;

										case 34 :	//pageDown
											if( Len > idx + 3 )
											{
												el.option.eq( idx + 3 ).click();
											}
											else
											{
												el.option.eq( Len - 1 ).click();
											}
											e.preventDefault();
											break;

										case 35 :	//end
											el.option.eq( -1 ).click();
											e.preventDefault();
											break;

										case 36 :	//home
											el.option.eq( 0 ).click();
											e.preventDefault();
											break;

										case 37 :	//left
										case 38 :	//up
											if( idx > 0 )
											{
												el.option.eq( idx - 1 ).click();
											}
											e.preventDefault();
											break;

										case 39 :	//right
										case 40 :	//down
											if( idx < listLen )
											{
												el.option.eq( idx + 1 ).click();
											}
											e.preventDefault();
											break;
									}
								} //no altKey
								else
									if( e.altKey )
									{

										switch( e.keyCode )
										{
											case 38 :	//up
											case 40 :	//down
												_this.open();
												break;
										}
									}
						}
					} );

					el.option.on( {
						'click': function( e )
						{
							var idx = $( this ).data( 'id' );
							_this.change( idx );
							_this.close();
							el.combo.focus();
							e.preventDefault();
						},
						'keydown': function( e )
						{
							var idx = $( this ).data( 'id' );
							if( !e.altKey )
							{
								switch( e.keyCode )
								{

									case 13 :	//space
									case 32 :	//enter
										$( this ).click();
										e.preventDefault();
										break;

									case 27 : //esc
										_this.close();
										el.combo.focus();
										break;

									case 33 :	//pageUp
										if( idx >= 3 )
										{
											el.option.eq( idx - 3 ).focus();
										}
										else
										{
											el.option.eq( 0 ).focus();
										}
										e.preventDefault();
										break;

									case 34 :	//pageDown
										if( Len >= idx + 3 )
										{
											el.option.eq( idx + 3 ).focus();
										}
										else
										{
											el.option.eq( Len - 1 ).focus();
										}
										e.preventDefault();
										break;

									case 35 : //end
										el.option.eq( -1 ).focus();
										e.preventDefault();
										break;

									case 36 : //home
										el.option.eq( 0 ).focus();
										e.preventDefault();
										break;

									case 37 :	//up
									case 38 :	//left
										if( idx != 0 )
										{
											idx--;
										}
										el.option.eq( idx ).focus();
										e.preventDefault();
										break;

									case 39 :	//right
									case 40 :	//down
										idx++;
										el.option.eq( idx ).focus();
										e.preventDefault();
										break;

								}
							} //no altKey
							else
								if( e.altKey )
								{

									switch( e.keyCode )
									{
										case 38 :	//up
										case 40 :	//down
											_this.close();
											break;
									}
								} //alt
						}
					} );

					el.option.last().on( {
						'keydown': function( e )
						{
							if( e.keyCode == 9 )
							{
								if( !e.shiftKey )
								{
									e.preventDefault();
									_this.close();
								}
							}
						}
					} );

					el.list.on( 'mouseleave', function()
					{
						_this.close();
					} );

				}
			};

			if( options === 'init' )
			{
				make.init();
			}
			if( options === 'close' )
			{
				make.close( true );
			}
			if( options === 'update' )
			{
				make.change( $this.find( 'option:selected' ).index() );
			}
			if( options === 'destory' )
			{
				make.unbind();
				$this.show().next( '.jqListBox' ).remove();
			}
		} );
	};

})( jQuery );
/*! jQuery UI - v1.11.4 - 2015-10-20
 * http://jqueryui.com
 * Includes: core.js, datepicker.js
 * Copyright 2015 jQuery Foundation and other contributors; Licensed MIT */

(function( e )
{
	"function" == typeof define && define.amd ? define( [ "jquery" ], e ) : e( jQuery )
})( function( e )
{
	function t( t, s )
	{
		var n, a, o, r = t.nodeName.toLowerCase();
		return "area" === r ? (n = t.parentNode, a = n.name, t.href && a && "map" === n.nodeName.toLowerCase() ? (o = e( "img[usemap='#" + a + "']" )[ 0 ], !!o && i( o )) : !1) : (/^(input|select|textarea|button|object)$/.test( r ) ? !t.disabled : "a" === r ? t.href || s : s) && i( t )
	}

	function i( t )
	{
		return e.expr.filters.visible( t ) && !e( t ).parents().addBack().filter( function()
			{
				return "hidden" === e.css( this, "visibility" )
			} ).length
	}

	function s( e )
	{
		for( var t, i; e.length && e[ 0 ] !== document; )
		{
			if( t = e.css( "position" ), ("absolute" === t || "relative" === t || "fixed" === t) && (i = parseInt( e.css( "zIndex" ), 10 ), !isNaN( i ) && 0 !== i) )return i;
			e = e.parent()
		}
		return 0
	}

	function n()
	{
		this._curInst = null, this._keyEvent = !1, this._disabledInputs = [], this._datepickerShowing = !1, this._inDialog = !1, this._mainDivId = "ui-datepicker-div", this._inlineClass = "ui-datepicker-inline", this._appendClass = "ui-datepicker-append", this._triggerClass = "ui-datepicker-trigger", this._dialogClass = "ui-datepicker-dialog", this._disableClass = "ui-datepicker-disabled", this._unselectableClass = "ui-datepicker-unselectable", this._currentClass = "ui-datepicker-current-day", this._dayOverClass = "ui-datepicker-days-cell-over", this.regional = [], this.regional[ "" ] = {
			closeText: "Done",
			prevText: "Prev",
			nextText: "Next",
			currentText: "Today",
			monthNames: [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ],
			monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
			dayNames: [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ],
			dayNamesShort: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
			dayNamesMin: [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
			weekHeader: "Wk",
			dateFormat: "mm/dd/yy",
			firstDay: 0,
			isRTL: !1,
			showMonthAfterYear: !1,
			yearSuffix: ""
		}, this._defaults = {
			showOn: "focus",
			showAnim: "fadeIn",
			showOptions: {},
			defaultDate: null,
			appendText: "",
			buttonText: "...",
			buttonImage: "",
			buttonImageOnly: !1,
			hideIfNoPrevNext: !1,
			navigationAsDateFormat: !1,
			gotoCurrent: !1,
			changeMonth: !1,
			changeYear: !1,
			yearRange: "c-10:c+10",
			showOtherMonths: !1,
			selectOtherMonths: !1,
			showWeek: !1,
			calculateWeek: this.iso8601Week,
			shortYearCutoff: "+10",
			minDate: null,
			maxDate: null,
			duration: "fast",
			beforeShowDay: null,
			beforeShow: null,
			onSelect: null,
			onChangeMonthYear: null,
			onClose: null,
			numberOfMonths: 1,
			showCurrentAtPos: 0,
			stepMonths: 1,
			stepBigMonths: 12,
			altField: "",
			altFormat: "",
			constrainInput: !0,
			showButtonPanel: !1,
			autoSize: !1,
			disabled: !1
		}, e.extend( this._defaults, this.regional[ "" ] ), this.regional.en = e.extend( !0, {}, this.regional[ "" ] ), this.regional[ "en-US" ] = e.extend( !0, {}, this.regional.en ), this.dpDiv = a( e( "<div id='" + this._mainDivId + "' class='ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all'></div>" ) )
	}

	function a( t )
	{
		var i = "button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a";
		return t.delegate( i, "mouseout", function()
		{
			e( this ).removeClass( "ui-state-hover" ), -1 !== this.className.indexOf( "ui-datepicker-prev" ) && e( this ).removeClass( "ui-datepicker-prev-hover" ), -1 !== this.className.indexOf( "ui-datepicker-next" ) && e( this ).removeClass( "ui-datepicker-next-hover" )
		} ).delegate( i, "mouseover", o )
	}

	function o()
	{
		e.datepicker._isDisabledDatepicker( h.inline ? h.dpDiv.parent()[ 0 ] : h.input[ 0 ] ) || (e( this ).parents( ".ui-datepicker-calendar" ).find( "a" ).removeClass( "ui-state-hover" ), e( this ).addClass( "ui-state-hover" ), -1 !== this.className.indexOf( "ui-datepicker-prev" ) && e( this ).addClass( "ui-datepicker-prev-hover" ), -1 !== this.className.indexOf( "ui-datepicker-next" ) && e( this ).addClass( "ui-datepicker-next-hover" ))
	}

	function r( t, i )
	{
		e.extend( t, i );
		for( var s in i )null == i[ s ] && (t[ s ] = i[ s ]);
		return t
	}

	e.ui = e.ui || {}, e.extend( e.ui, {
		version: "1.11.4",
		keyCode: {
			BACKSPACE: 8,
			COMMA: 188,
			DELETE: 46,
			DOWN: 40,
			END: 35,
			ENTER: 13,
			ESCAPE: 27,
			HOME: 36,
			LEFT: 37,
			PAGE_DOWN: 34,
			PAGE_UP: 33,
			PERIOD: 190,
			RIGHT: 39,
			SPACE: 32,
			TAB: 9,
			UP: 38
		}
	} ), e.fn.extend( {
		scrollParent: function( t )
		{
			var i = this.css( "position" ), s = "absolute" === i, n = t ? /(auto|scroll|hidden)/ : /(auto|scroll)/, a = this.parents().filter( function()
			{
				var t = e( this );
				return s && "static" === t.css( "position" ) ? !1 : n.test( t.css( "overflow" ) + t.css( "overflow-y" ) + t.css( "overflow-x" ) )
			} ).eq( 0 );
			return "fixed" !== i && a.length ? a : e( this[ 0 ].ownerDocument || document )
		}, uniqueId: function()
		{
			var e = 0;
			return function()
			{
				return this.each( function()
				{
					this.id || (this.id = "ui-id-" + ++e)
				} )
			}
		}(), removeUniqueId: function()
		{
			return this.each( function()
			{
				/^ui-id-\d+$/.test( this.id ) && e( this ).removeAttr( "id" )
			} )
		}
	} ), e.extend( e.expr[ ":" ], {
		data: e.expr.createPseudo ? e.expr.createPseudo( function( t )
		{
			return function( i )
			{
				return !!e.data( i, t )
			}
		} ) : function( t, i, s )
		{
			return !!e.data( t, s[ 3 ] )
		}, focusable: function( i )
		{
			return t( i, !isNaN( e.attr( i, "tabindex" ) ) )
		}, tabbable: function( i )
		{
			var s = e.attr( i, "tabindex" ), n = isNaN( s );
			return (n || s >= 0) && t( i, !n )
		}
	} ), e( "<a>" ).outerWidth( 1 ).jquery || e.each( [ "Width", "Height" ], function( t, i )
	{
		function s( t, i, s, a )
		{
			return e.each( n, function()
			{
				i -= parseFloat( e.css( t, "padding" + this ) ) || 0, s && (i -= parseFloat( e.css( t, "border" + this + "Width" ) ) || 0), a && (i -= parseFloat( e.css( t, "margin" + this ) ) || 0)
			} ), i
		}

		var n = "Width" === i ? [ "Left", "Right" ] : [ "Top", "Bottom" ], a = i.toLowerCase(), o = {
			innerWidth: e.fn.innerWidth,
			innerHeight: e.fn.innerHeight,
			outerWidth: e.fn.outerWidth,
			outerHeight: e.fn.outerHeight
		};
		e.fn[ "inner" + i ] = function( t )
		{
			return void 0 === t ? o[ "inner" + i ].call( this ) : this.each( function()
			{
				e( this ).css( a, s( this, t ) + "px" )
			} )
		}, e.fn[ "outer" + i ] = function( t, n )
		{
			return "number" != typeof t ? o[ "outer" + i ].call( this, t ) : this.each( function()
			{
				e( this ).css( a, s( this, t, !0, n ) + "px" )
			} )
		}
	} ), e.fn.addBack || (e.fn.addBack = function( e )
	{
		return this.add( null == e ? this.prevObject : this.prevObject.filter( e ) )
	}), e( "<a>" ).data( "a-b", "a" ).removeData( "a-b" ).data( "a-b" ) && (e.fn.removeData = function( t )
	{
		return function( i )
		{
			return arguments.length ? t.call( this, e.camelCase( i ) ) : t.call( this )
		}
	}( e.fn.removeData )), e.ui.ie = !!/msie [\w.]+/.exec( navigator.userAgent.toLowerCase() ), e.fn.extend( {
		focus: function( t )
		{
			return function( i, s )
			{
				return "number" == typeof i ? this.each( function()
				{
					var t = this;
					setTimeout( function()
					{
						e( t ).focus(), s && s.call( t )
					}, i )
				} ) : t.apply( this, arguments )
			}
		}( e.fn.focus ), disableSelection: function()
		{
			var e = "onselectstart" in document.createElement( "div" ) ? "selectstart" : "mousedown";
			return function()
			{
				return this.bind( e + ".ui-disableSelection", function( e )
				{
					e.preventDefault()
				} )
			}
		}(), enableSelection: function()
		{
			return this.unbind( ".ui-disableSelection" )
		}, zIndex: function( t )
		{
			if( void 0 !== t )return this.css( "zIndex", t );
			if( this.length )for( var i, s, n = e( this[ 0 ] ); n.length && n[ 0 ] !== document; )
			{
				if( i = n.css( "position" ), ("absolute" === i || "relative" === i || "fixed" === i) && (s = parseInt( n.css( "zIndex" ), 10 ), !isNaN( s ) && 0 !== s) )return s;
				n = n.parent()
			}
			return 0
		}
	} ), e.ui.plugin = {
		add: function( t, i, s )
		{
			var n, a = e.ui[ t ].prototype;
			for( n in s )a.plugins[ n ] = a.plugins[ n ] || [], a.plugins[ n ].push( [ i, s[ n ] ] )
		}, call: function( e, t, i, s )
		{
			var n, a = e.plugins[ t ];
			if( a && (s || e.element[ 0 ].parentNode && 11 !== e.element[ 0 ].parentNode.nodeType) )for( n = 0; a.length > n; n++ )e.options[ a[ n ][ 0 ] ] && a[ n ][ 1 ].apply( e.element, i )
		}
	}, e.extend( e.ui, { datepicker: { version: "1.11.4" } } );
	var h;
	e.extend( n.prototype, {
		markerClassName: "hasDatepicker",
		maxRows: 4,
		_widgetDatepicker: function()
		{
			return this.dpDiv
		},
		setDefaults: function( e )
		{
			return r( this._defaults, e || {} ), this
		},
		_attachDatepicker: function( t, i )
		{
			var s, n, a;
			s = t.nodeName.toLowerCase(), n = "div" === s || "span" === s, t.id || (this.uuid += 1, t.id = "dp" + this.uuid), a = this._newInst( e( t ), n ), a.settings = e.extend( {}, i || {} ), "input" === s ? this._connectDatepicker( t, a ) : n && this._inlineDatepicker( t, a )
		},
		_newInst: function( t, i )
		{
			var s = t[ 0 ].id.replace( /([^A-Za-z0-9_\-])/g, "\\\\$1" );
			return {
				id: s,
				input: t,
				selectedDay: 0,
				selectedMonth: 0,
				selectedYear: 0,
				drawMonth: 0,
				drawYear: 0,
				inline: i,
				dpDiv: i ? a( e( "<div class='" + this._inlineClass + " ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all'></div>" ) ) : this.dpDiv
			}
		},
		_connectDatepicker: function( t, i )
		{
			var s = e( t );
			i.append = e( [] ), i.trigger = e( [] ), s.hasClass( this.markerClassName ) || (this._attachments( s, i ), s.addClass( this.markerClassName ).keydown( this._doKeyDown ).keypress( this._doKeyPress ).keyup( this._doKeyUp ), this._autoSize( i ), e.data( t, "datepicker", i ), i.settings.disabled && this._disableDatepicker( t ))
		},
		_attachments: function( t, i )
		{
			var s, n, a, o = this._get( i, "appendText" ), r = this._get( i, "isRTL" );
			i.append && i.append.remove(), o && (i.append = e( "<span class='" + this._appendClass + "'>" + o + "</span>" ), t[ r ? "before" : "after" ]( i.append )), t.unbind( "focus", this._showDatepicker ), i.trigger && i.trigger.remove(), s = this._get( i, "showOn" ), ("focus" === s || "both" === s) && t.focus( this._showDatepicker ), ("button" === s || "both" === s) && (n = this._get( i, "buttonText" ), a = this._get( i, "buttonImage" ), i.trigger = e( this._get( i, "buttonImageOnly" ) ? e( "<img/>" ).addClass( this._triggerClass ).attr( {
				src: a
			} ) : e( "<button type='button'></button>" ).addClass( this._triggerClass ).html( a ? e( "<img/>" ).attr( {
				src: a
			} ) : n ) ), t[ r ? "before" : "after" ]( i.trigger ), i.trigger.click( function()
			{
				return e.datepicker._datepickerShowing && e.datepicker._lastInput === t[ 0 ] ? e.datepicker._hideDatepicker() : e.datepicker._datepickerShowing && e.datepicker._lastInput !== t[ 0 ] ? (e.datepicker._hideDatepicker(), e.datepicker._showDatepicker( t[ 0 ] )) : e.datepicker._showDatepicker( t[ 0 ] ), !1
			} ))
		},
		_autoSize: function( e )
		{
			if( this._get( e, "autoSize" ) && !e.inline )
			{
				var t, i, s, n, a = new Date( 2009, 11, 20 ), o = this._get( e, "dateFormat" );
				o.match( /[DM]/ ) && (t = function( e )
				{
					for( i = 0, s = 0, n = 0; e.length > n; n++ )e[ n ].length > i && (i = e[ n ].length, s = n);
					return s
				}, a.setMonth( t( this._get( e, o.match( /MM/ ) ? "monthNames" : "monthNamesShort" ) ) ), a.setDate( t( this._get( e, o.match( /DD/ ) ? "dayNames" : "dayNamesShort" ) ) + 20 - a.getDay() )), e.input.attr( "size", this._formatDate( e, a ).length )
			}
		},
		_inlineDatepicker: function( t, i )
		{
			var s = e( t );
			s.hasClass( this.markerClassName ) || (s.addClass( this.markerClassName ).append( i.dpDiv ), e.data( t, "datepicker", i ), this._setDate( i, this._getDefaultDate( i ), !0 ), this._updateDatepicker( i ), this._updateAlternate( i ), i.settings.disabled && this._disableDatepicker( t ), i.dpDiv.css( "display", "block" ))
		},
		_dialogDatepicker: function( t, i, s, n, a )
		{
			var o, h, l, u, d, c = this._dialogInst;
			return c || (this.uuid += 1, o = "dp" + this.uuid, this._dialogInput = e( "<input type='text' id='" + o + "' style='position: absolute; top: -100px; width: 0px;'/>" ), this._dialogInput.keydown( this._doKeyDown ), e( "body" ).append( this._dialogInput ), c = this._dialogInst = this._newInst( this._dialogInput, !1 ), c.settings = {}, e.data( this._dialogInput[ 0 ], "datepicker", c )), r( c.settings, n || {} ), i = i && i.constructor === Date ? this._formatDate( c, i ) : i, this._dialogInput.val( i ), this._pos = a ? a.length ? a : [ a.pageX, a.pageY ] : null, this._pos || (h = document.documentElement.clientWidth, l = document.documentElement.clientHeight, u = document.documentElement.scrollLeft || document.body.scrollLeft, d = document.documentElement.scrollTop || document.body.scrollTop, this._pos = [ h / 2 - 100 + u, l / 2 - 150 + d ]), this._dialogInput.css( "left", this._pos[ 0 ] + 20 + "px" ).css( "top", this._pos[ 1 ] + "px" ), c.settings.onSelect = s, this._inDialog = !0, this.dpDiv.addClass( this._dialogClass ), this._showDatepicker( this._dialogInput[ 0 ] ), e.blockUI && e.blockUI( this.dpDiv ), e.data( this._dialogInput[ 0 ], "datepicker", c ), this
		},
		_destroyDatepicker: function( t )
		{
			var i, s = e( t ), n = e.data( t, "datepicker" );
			s.hasClass( this.markerClassName ) && (i = t.nodeName.toLowerCase(), e.removeData( t, "datepicker" ), "input" === i ? (n.append.remove(), n.trigger.remove(), s.removeClass( this.markerClassName ).unbind( "focus", this._showDatepicker ).unbind( "keydown", this._doKeyDown ).unbind( "keypress", this._doKeyPress ).unbind( "keyup", this._doKeyUp )) : ("div" === i || "span" === i) && s.removeClass( this.markerClassName ).empty(), h === n && (h = null))
		},
		_enableDatepicker: function( t )
		{
			var i, s, n = e( t ), a = e.data( t, "datepicker" );
			n.hasClass( this.markerClassName ) && (i = t.nodeName.toLowerCase(), "input" === i ? (t.disabled = !1, a.trigger.filter( "button" ).each( function()
			{
				this.disabled = !1
			} ).end().filter( "img" ).css( {
				opacity: "1.0",
				cursor: ""
			} )) : ("div" === i || "span" === i) && (s = n.children( "." + this._inlineClass ), s.children().removeClass( "ui-state-disabled" ), s.find( "select.ui-datepicker-month, select.ui-datepicker-year" ).prop( "disabled", !1 )), this._disabledInputs = e.map( this._disabledInputs, function( e )
			{
				return e === t ? null : e
			} ))
		},
		_disableDatepicker: function( t )
		{
			var i, s, n = e( t ), a = e.data( t, "datepicker" );
			n.hasClass( this.markerClassName ) && (i = t.nodeName.toLowerCase(), "input" === i ? (t.disabled = !0, a.trigger.filter( "button" ).each( function()
			{
				this.disabled = !0
			} ).end().filter( "img" ).css( {
				opacity: "0.5",
				cursor: "default"
			} )) : ("div" === i || "span" === i) && (s = n.children( "." + this._inlineClass ), s.children().addClass( "ui-state-disabled" ), s.find( "select.ui-datepicker-month, select.ui-datepicker-year" ).prop( "disabled", !0 )), this._disabledInputs = e.map( this._disabledInputs, function( e )
			{
				return e === t ? null : e
			} ), this._disabledInputs[ this._disabledInputs.length ] = t)
		},
		_isDisabledDatepicker: function( e )
		{
			if( !e )return !1;
			for( var t = 0; this._disabledInputs.length > t; t++ )if( this._disabledInputs[ t ] === e )return !0;
			return !1
		},
		_getInst: function( t )
		{
			try
			{
				return e.data( t, "datepicker" )
			}
			catch( i )
			{
				throw"Missing instance data for this datepicker"
			}
		},
		_optionDatepicker: function( t, i, s )
		{
			var n, a, o, h, l = this._getInst( t );
			return 2 === arguments.length && "string" == typeof i ? "defaults" === i ? e.extend( {}, e.datepicker._defaults ) : l ? "all" === i ? e.extend( {}, l.settings ) : this._get( l, i ) : null : (n = i || {}, "string" == typeof i && (n = {}, n[ i ] = s), l && (this._curInst === l && this._hideDatepicker(), a = this._getDateDatepicker( t, !0 ), o = this._getMinMaxDate( l, "min" ), h = this._getMinMaxDate( l, "max" ), r( l.settings, n ), null !== o && void 0 !== n.dateFormat && void 0 === n.minDate && (l.settings.minDate = this._formatDate( l, o )), null !== h && void 0 !== n.dateFormat && void 0 === n.maxDate && (l.settings.maxDate = this._formatDate( l, h )), "disabled" in n && (n.disabled ? this._disableDatepicker( t ) : this._enableDatepicker( t )), this._attachments( e( t ), l ), this._autoSize( l ), this._setDate( l, a ), this._updateAlternate( l ), this._updateDatepicker( l )), void 0)
		},
		_changeDatepicker: function( e, t, i )
		{
			this._optionDatepicker( e, t, i )
		},
		_refreshDatepicker: function( e )
		{
			var t = this._getInst( e );
			t && this._updateDatepicker( t )
		},
		_setDateDatepicker: function( e, t )
		{
			var i = this._getInst( e );
			i && (this._setDate( i, t ), this._updateDatepicker( i ), this._updateAlternate( i ))
		},
		_getDateDatepicker: function( e, t )
		{
			var i = this._getInst( e );
			return i && !i.inline && this._setDateFromField( i, t ), i ? this._getDate( i ) : null
		},
		_doKeyDown: function( t )
		{
			var i, s, n, a = e.datepicker._getInst( t.target ), o = !0, r = a.dpDiv.is( ".ui-datepicker-rtl" );
			if( a._keyEvent = !0, e.datepicker._datepickerShowing )switch( t.keyCode )
			{
				case 9:
					e.datepicker._hideDatepicker(), o = !1;
					break;
				case 13:
					return n = e( "td." + e.datepicker._dayOverClass + ":not(." + e.datepicker._currentClass + ")", a.dpDiv ), n[ 0 ] && e.datepicker._selectDay( t.target, a.selectedMonth, a.selectedYear, n[ 0 ] ), i = e.datepicker._get( a, "onSelect" ), i ? (s = e.datepicker._formatDate( a ), i.apply( a.input ? a.input[ 0 ] : null, [ s, a ] )) : e.datepicker._hideDatepicker(), !1;
				case 27:
					e.datepicker._hideDatepicker();
					break;
				case 33:
					e.datepicker._adjustDate( t.target, t.ctrlKey ? -e.datepicker._get( a, "stepBigMonths" ) : -e.datepicker._get( a, "stepMonths" ), "M" );
					break;
				case 34:
					e.datepicker._adjustDate( t.target, t.ctrlKey ? +e.datepicker._get( a, "stepBigMonths" ) : +e.datepicker._get( a, "stepMonths" ), "M" );
					break;
				case 35:
					(t.ctrlKey || t.metaKey) && e.datepicker._clearDate( t.target ), o = t.ctrlKey || t.metaKey;
					break;
				case 36:
					(t.ctrlKey || t.metaKey) && e.datepicker._gotoToday( t.target ), o = t.ctrlKey || t.metaKey;
					break;
				case 37:
					(t.ctrlKey || t.metaKey) && e.datepicker._adjustDate( t.target, r ? 1 : -1, "D" ), o = t.ctrlKey || t.metaKey, t.originalEvent.altKey && e.datepicker._adjustDate( t.target, t.ctrlKey ? -e.datepicker._get( a, "stepBigMonths" ) : -e.datepicker._get( a, "stepMonths" ), "M" );
					break;
				case 38:
					(t.ctrlKey || t.metaKey) && e.datepicker._adjustDate( t.target, -7, "D" ), o = t.ctrlKey || t.metaKey;
					break;
				case 39:
					(t.ctrlKey || t.metaKey) && e.datepicker._adjustDate( t.target, r ? -1 : 1, "D" ), o = t.ctrlKey || t.metaKey, t.originalEvent.altKey && e.datepicker._adjustDate( t.target, t.ctrlKey ? +e.datepicker._get( a, "stepBigMonths" ) : +e.datepicker._get( a, "stepMonths" ), "M" );
					break;
				case 40:
					(t.ctrlKey || t.metaKey) && e.datepicker._adjustDate( t.target, 7, "D" ), o = t.ctrlKey || t.metaKey;
					break;
				default:
					o = !1
			}
			else 36 === t.keyCode && t.ctrlKey ? e.datepicker._showDatepicker( this ) : o = !1;
			o && (t.preventDefault(), t.stopPropagation())
		},
		_doKeyPress: function( t )
		{
			var i, s, n = e.datepicker._getInst( t.target );
			return e.datepicker._get( n, "constrainInput" ) ? (i = e.datepicker._possibleChars( e.datepicker._get( n, "dateFormat" ) ), s = String.fromCharCode( null == t.charCode ? t.keyCode : t.charCode ), t.ctrlKey || t.metaKey || " " > s || !i || i.indexOf( s ) > -1) : void 0
		},
		_doKeyUp: function( t )
		{
			var i, s = e.datepicker._getInst( t.target );
			if( s.input.val() !== s.lastVal )try
			{
				i = e.datepicker.parseDate( e.datepicker._get( s, "dateFormat" ), s.input ? s.input.val() : null, e.datepicker._getFormatConfig( s ) ), i && (e.datepicker._setDateFromField( s ), e.datepicker._updateAlternate( s ), e.datepicker._updateDatepicker( s ))
			}
			catch( n )
			{
			}
			return !0
		},
		_showDatepicker: function( t )
		{
			if( t = t.target || t, "input" !== t.nodeName.toLowerCase() && (t = e( "input", t.parentNode )[ 0 ]), !e.datepicker._isDisabledDatepicker( t ) && e.datepicker._lastInput !== t )
			{
				var i, n, a, o, h, l, u;
				i = e.datepicker._getInst( t ), e.datepicker._curInst && e.datepicker._curInst !== i && (e.datepicker._curInst.dpDiv.stop( !0, !0 ), i && e.datepicker._datepickerShowing && e.datepicker._hideDatepicker( e.datepicker._curInst.input[ 0 ] )), n = e.datepicker._get( i, "beforeShow" ), a = n ? n.apply( t, [ t, i ] ) : {}, a !== !1 && (r( i.settings, a ), i.lastVal = null, e.datepicker._lastInput = t, e.datepicker._setDateFromField( i ), e.datepicker._inDialog && (t.value = ""), e.datepicker._pos || (e.datepicker._pos = e.datepicker._findPos( t ), e.datepicker._pos[ 1 ] += t.offsetHeight), o = !1, e( t ).parents().each( function()
				{
					return o |= "fixed" === e( this ).css( "position" ), !o
				} ), h = {
					left: e.datepicker._pos[ 0 ],
					top: e.datepicker._pos[ 1 ]
				}, e.datepicker._pos = null, i.dpDiv.empty(), i.dpDiv.css( {
					position: "absolute",
					display: "block",
					top: "-1000px"
				} ), e.datepicker._updateDatepicker( i ), h = e.datepicker._checkOffset( i, h, o ), i.dpDiv.css( {
					position: e.datepicker._inDialog && e.blockUI ? "static" : o ? "fixed" : "absolute",
					display: "none",
					left: h.left + "px",
					top: h.top + "px"
				} ), i.inline || (l = e.datepicker._get( i, "showAnim" ), u = e.datepicker._get( i, "duration" ), i.dpDiv.css( "z-index", s( e( t ) ) + 999 ), e.datepicker._datepickerShowing = !0, e.effects && e.effects.effect[ l ] ? i.dpDiv.show( l, e.datepicker._get( i, "showOptions" ), u ) : i.dpDiv[ l || "show" ]( l ? u : null ), e.datepicker._shouldFocusInput( i ) && i.input.focus(), e.datepicker._curInst = i))
			}
		},
		_updateDatepicker: function( t )
		{
			this.maxRows = 4, h = t, t.dpDiv.empty().append( this._generateHTML( t ) ), this._attachHandlers( t );
			var i, s = this._getNumberOfMonths( t ), n = s[ 1 ], a = 17, r = t.dpDiv.find( "." + this._dayOverClass + " a" );
			r.length > 0 && o.apply( r.get( 0 ) ), t.dpDiv.removeClass( "ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4" ).width( "" ), n > 1 && t.dpDiv.addClass( "ui-datepicker-multi-" + n ).css( "width", a * n + "em" ), t.dpDiv[ (1 !== s[ 0 ] || 1 !== s[ 1 ] ? "add" : "remove") + "Class" ]( "ui-datepicker-multi" ), t.dpDiv[ (this._get( t, "isRTL" ) ? "add" : "remove") + "Class" ]( "ui-datepicker-rtl" ), t === e.datepicker._curInst && e.datepicker._datepickerShowing && e.datepicker._shouldFocusInput( t ) && t.input.focus(), t.yearshtml && (i = t.yearshtml, setTimeout( function()
			{
				i === t.yearshtml && t.yearshtml && t.dpDiv.find( "select.ui-datepicker-year:first" ).replaceWith( t.yearshtml ), i = t.yearshtml = null
			}, 0 ))
		},
		_shouldFocusInput: function( e )
		{
			return e.input && e.input.is( ":visible" ) && !e.input.is( ":disabled" ) && !e.input.is( ":focus" )
		},
		_checkOffset: function( t, i, s )
		{
			var n = t.dpDiv.outerWidth(), a = t.dpDiv.outerHeight(), o = t.input ? t.input.outerWidth() : 0, r = t.input ? t.input.outerHeight() : 0, h = document.documentElement.clientWidth + (s ? 0 : e( document ).scrollLeft()), l = document.documentElement.clientHeight + (s ? 0 : e( document ).scrollTop());
			return i.left -= this._get( t, "isRTL" ) ? n - o : 0, i.left -= s && i.left === t.input.offset().left ? e( document ).scrollLeft() : 0, i.top -= s && i.top === t.input.offset().top + r ? e( document ).scrollTop() : 0, i.left -= Math.min( i.left, i.left + n > h && h > n ? Math.abs( i.left + n - h ) : 0 ), i.top -= Math.min( i.top, i.top + a > l && l > a ? Math.abs( a + r ) : 0 ), i
		},
		_findPos: function( t )
		{
			for( var i, s = this._getInst( t ), n = this._get( s, "isRTL" ); t && ("hidden" === t.type || 1 !== t.nodeType || e.expr.filters.hidden( t )); )t = t[ n ? "previousSibling" : "nextSibling" ];
			return i = e( t ).offset(), [ i.left, i.top ]
		},
		_hideDatepicker: function( t )
		{
			var i, s, n, a, o = this._curInst;
			!o || t && o !== e.data( t, "datepicker" ) || this._datepickerShowing && (i = this._get( o, "showAnim" ), s = this._get( o, "duration" ), n = function()
			{
				e.datepicker._tidyDialog( o )
			}, e.effects && (e.effects.effect[ i ] || e.effects[ i ]) ? o.dpDiv.hide( i, e.datepicker._get( o, "showOptions" ), s, n ) : o.dpDiv[ "slideDown" === i ? "slideUp" : "fadeIn" === i ? "fadeOut" : "hide" ]( i ? s : null, n ), i || n(), this._datepickerShowing = !1, a = this._get( o, "onClose" ), a && a.apply( o.input ? o.input[ 0 ] : null, [ o.input ? o.input.val() : "", o ] ), this._lastInput = null, this._inDialog && (this._dialogInput.css( {
				position: "absolute",
				left: "0",
				top: "-100px"
			} ), e.blockUI && (e.unblockUI(), e( "body" ).append( this.dpDiv ))), this._inDialog = !1)
		},
		_tidyDialog: function( e )
		{
			e.dpDiv.removeClass( this._dialogClass ).unbind( ".ui-datepicker-calendar" )
		},
		_checkExternalClick: function( t )
		{
			if( e.datepicker._curInst )
			{
				var i = e( t.target ), s = e.datepicker._getInst( i[ 0 ] );
				(i[ 0 ].id !== e.datepicker._mainDivId && 0 === i.parents( "#" + e.datepicker._mainDivId ).length && !i.hasClass( e.datepicker.markerClassName ) && !i.closest( "." + e.datepicker._triggerClass ).length && e.datepicker._datepickerShowing && (!e.datepicker._inDialog || !e.blockUI) || i.hasClass( e.datepicker.markerClassName ) && e.datepicker._curInst !== s) && e.datepicker._hideDatepicker()
			}
		},
		_adjustDate: function( t, i, s )
		{
			var n = e( t ), a = this._getInst( n[ 0 ] );
			this._isDisabledDatepicker( n[ 0 ] ) || (this._adjustInstDate( a, i + ("M" === s ? this._get( a, "showCurrentAtPos" ) : 0), s ), this._updateDatepicker( a ))
		},
		_gotoToday: function( t )
		{
			var i, s = e( t ), n = this._getInst( s[ 0 ] );
			this._get( n, "gotoCurrent" ) && n.currentDay ? (n.selectedDay = n.currentDay, n.drawMonth = n.selectedMonth = n.currentMonth, n.drawYear = n.selectedYear = n.currentYear) : (i = new Date, n.selectedDay = i.getDate(), n.drawMonth = n.selectedMonth = i.getMonth(), n.drawYear = n.selectedYear = i.getFullYear()), this._notifyChange( n ), this._adjustDate( s )
		},
		_selectMonthYear: function( t, i, s )
		{
			var n = e( t ), a = this._getInst( n[ 0 ] );
			a[ "selected" + ("M" === s ? "Month" : "Year") ] = a[ "draw" + ("M" === s ? "Month" : "Year") ] = parseInt( i.options[ i.selectedIndex ].value, 10 ), this._notifyChange( a ), this._adjustDate( n )
		},
		_selectDay: function( t, i, s, n )
		{
			var a, o = e( t );
			e( n ).hasClass( this._unselectableClass ) || this._isDisabledDatepicker( o[ 0 ] ) || (a = this._getInst( o[ 0 ] ), a.selectedDay = a.currentDay = e( "a", n ).html(), a.selectedMonth = a.currentMonth = i, a.selectedYear = a.currentYear = s, this._selectDate( t, this._formatDate( a, a.currentDay, a.currentMonth, a.currentYear ) ))
		},
		_clearDate: function( t )
		{
			var i = e( t );
			this._selectDate( i, "" )
		},
		_selectDate: function( t, i )
		{
			var s, n = e( t ), a = this._getInst( n[ 0 ] );
			i = null != i ? i : this._formatDate( a ), a.input && a.input.val( i ), this._updateAlternate( a ), s = this._get( a, "onSelect" ), s ? s.apply( a.input ? a.input[ 0 ] : null, [ i, a ] ) : a.input && a.input.trigger( "change" ), a.inline ? this._updateDatepicker( a ) : (this._hideDatepicker(), this._lastInput = a.input[ 0 ], "object" != typeof a.input[ 0 ] && a.input.focus(), this._lastInput = null)
		},
		_updateAlternate: function( t )
		{
			var i, s, n, a = this._get( t, "altField" );
			a && (i = this._get( t, "altFormat" ) || this._get( t, "dateFormat" ), s = this._getDate( t ), n = this.formatDate( i, s, this._getFormatConfig( t ) ), e( a ).each( function()
			{
				e( this ).val( n )
			} ))
		},
		noWeekends: function( e )
		{
			var t = e.getDay();
			return [ t > 0 && 6 > t, "" ]
		},
		iso8601Week: function( e )
		{
			var t, i = new Date( e.getTime() );
			return i.setDate( i.getDate() + 4 - (i.getDay() || 7) ), t = i.getTime(), i.setMonth( 0 ), i.setDate( 1 ), Math.floor( Math.round( (t - i) / 864e5 ) / 7 ) + 1
		},
		parseDate: function( t, i, s )
		{
			if( null == t || null == i )throw"Invalid arguments";
			if( i = "object" == typeof i ? "" + i : i + "", "" === i )return null;
			var n, a, o, r, h = 0, l = (s ? s.shortYearCutoff : null) || this._defaults.shortYearCutoff, u = "string" != typeof l ? l : (new Date).getFullYear() % 100 + parseInt( l, 10 ), d = (s ? s.dayNamesShort : null) || this._defaults.dayNamesShort, c = (s ? s.dayNames : null) || this._defaults.dayNames, p = (s ? s.monthNamesShort : null) || this._defaults.monthNamesShort, f = (s ? s.monthNames : null) || this._defaults.monthNames, m = -1, g = -1, v = -1, y = -1, b = !1, _ = function( e )
			{
				var i = t.length > n + 1 && t.charAt( n + 1 ) === e;
				return i && n++, i
			}, x = function( e )
			{
				var t = _( e ), s = "@" === e ? 14 : "!" === e ? 20 : "y" === e && t ? 4 : "o" === e ? 3 : 2, n = "y" === e ? s : 1, a = RegExp( "^\\d{" + n + "," + s + "}" ), o = i.substring( h ).match( a );
				if( !o )throw"Missing number at position " + h;
				return h += o[ 0 ].length, parseInt( o[ 0 ], 10 )
			}, w = function( t, s, n )
			{
				var a = -1, o = e.map( _( t ) ? n : s, function( e, t )
				{
					return [ [ t, e ] ]
				} ).sort( function( e, t )
				{
					return -(e[ 1 ].length - t[ 1 ].length)
				} );
				if( e.each( o, function( e, t )
					{
						var s = t[ 1 ];
						return i.substr( h, s.length ).toLowerCase() === s.toLowerCase() ? (a = t[ 0 ], h += s.length, !1) : void 0
					} ), -1 !== a )return a + 1;
				throw"Unknown name at position " + h
			}, k = function()
			{
				if( i.charAt( h ) !== t.charAt( n ) )throw"Unexpected literal at position " + h;
				h++
			};
			for( n = 0; t.length > n; n++ )if( b )"'" !== t.charAt( n ) || _( "'" ) ? k() : b = !1;
			else switch( t.charAt( n ) )
				{
					case"d":
						v = x( "d" );
						break;
					case"D":
						w( "D", d, c );
						break;
					case"o":
						y = x( "o" );
						break;
					case"m":
						g = x( "m" );
						break;
					case"M":
						g = w( "M", p, f );
						break;
					case"y":
						m = x( "y" );
						break;
					case"@":
						r = new Date( x( "@" ) ), m = r.getFullYear(), g = r.getMonth() + 1, v = r.getDate();
						break;
					case"!":
						r = new Date( (x( "!" ) - this._ticksTo1970) / 1e4 ), m = r.getFullYear(), g = r.getMonth() + 1, v = r.getDate();
						break;
					case"'":
						_( "'" ) ? k() : b = !0;
						break;
					default:
						k()
				}
			if( i.length > h && (o = i.substr( h ), !/^\s+/.test( o )) )throw"Extra/unparsed characters found in date: " + o;
			if( -1 === m ? m = (new Date).getFullYear() : 100 > m && (m += (new Date).getFullYear() - (new Date).getFullYear() % 100 + (u >= m ? 0 : -100)), y > -1 )for( g = 1, v = y; ; )
			{
				if( a = this._getDaysInMonth( m, g - 1 ), a >= v )break;
				g++, v -= a
			}
			if( r = this._daylightSavingAdjust( new Date( m, g - 1, v ) ), r.getFullYear() !== m || r.getMonth() + 1 !== g || r.getDate() !== v )throw"Invalid date";
			return r
		},
		ATOM: "yy-mm-dd",
		COOKIE: "D, dd M yy",
		ISO_8601: "yy-mm-dd",
		RFC_822: "D, d M y",
		RFC_850: "DD, dd-M-y",
		RFC_1036: "D, d M y",
		RFC_1123: "D, d M yy",
		RFC_2822: "D, d M yy",
		RSS: "D, d M y",
		TICKS: "!",
		TIMESTAMP: "@",
		W3C: "yy-mm-dd",
		_ticksTo1970: 1e7 * 60 * 60 * 24 * (718685 + Math.floor( 492.5 ) - Math.floor( 19.7 ) + Math.floor( 4.925 )),
		formatDate: function( e, t, i )
		{
			if( !t )return "";
			var s, n = (i ? i.dayNamesShort : null) || this._defaults.dayNamesShort, a = (i ? i.dayNames : null) || this._defaults.dayNames, o = (i ? i.monthNamesShort : null) || this._defaults.monthNamesShort, r = (i ? i.monthNames : null) || this._defaults.monthNames, h = function( t )
			{
				var i = e.length > s + 1 && e.charAt( s + 1 ) === t;
				return i && s++, i
			}, l = function( e, t, i )
			{
				var s = "" + t;
				if( h( e ) )for( ; i > s.length; )s = "0" + s;
				return s
			}, u = function( e, t, i, s )
			{
				return h( e ) ? s[ t ] : i[ t ]
			}, d = "", c = !1;
			if( t )for( s = 0; e.length > s; s++ )if( c )"'" !== e.charAt( s ) || h( "'" ) ? d += e.charAt( s ) : c = !1;
			else switch( e.charAt( s ) )
				{
					case"d":
						d += l( "d", t.getDate(), 2 );
						break;
					case"D":
						d += u( "D", t.getDay(), n, a );
						break;
					case"o":
						d += l( "o", Math.round( (new Date( t.getFullYear(), t.getMonth(), t.getDate() ).getTime() - new Date( t.getFullYear(), 0, 0 ).getTime()) / 864e5 ), 3 );
						break;
					case"m":
						d += l( "m", t.getMonth() + 1, 2 );
						break;
					case"M":
						d += u( "M", t.getMonth(), o, r );
						break;
					case"y":
						d += h( "y" ) ? t.getFullYear() : (10 > t.getYear() % 100 ? "0" : "") + t.getYear() % 100;
						break;
					case"@":
						d += t.getTime();
						break;
					case"!":
						d += 1e4 * t.getTime() + this._ticksTo1970;
						break;
					case"'":
						h( "'" ) ? d += "'" : c = !0;
						break;
					default:
						d += e.charAt( s )
				}
			return d
		},
		_possibleChars: function( e )
		{
			var t, i = "", s = !1, n = function( i )
			{
				var s = e.length > t + 1 && e.charAt( t + 1 ) === i;
				return s && t++, s
			};
			for( t = 0; e.length > t; t++ )if( s )"'" !== e.charAt( t ) || n( "'" ) ? i += e.charAt( t ) : s = !1;
			else switch( e.charAt( t ) )
				{
					case"d":
					case"m":
					case"y":
					case"@":
						i += "0123456789";
						break;
					case"D":
					case"M":
						return null;
					case"'":
						n( "'" ) ? i += "'" : s = !0;
						break;
					default:
						i += e.charAt( t )
				}
			return i
		},
		_get: function( e, t )
		{
			return void 0 !== e.settings[ t ] ? e.settings[ t ] : this._defaults[ t ]
		},
		_setDateFromField: function( e, t )
		{
			if( e.input.val() !== e.lastVal )
			{
				var i = this._get( e, "dateFormat" ), s = e.lastVal = e.input ? e.input.val() : null, n = this._getDefaultDate( e ), a = n, o = this._getFormatConfig( e );
				try
				{
					a = this.parseDate( i, s, o ) || n
				}
				catch( r )
				{
					s = t ? "" : s
				}
				e.selectedDay = a.getDate(), e.drawMonth = e.selectedMonth = a.getMonth(), e.drawYear = e.selectedYear = a.getFullYear(), e.currentDay = s ? a.getDate() : 0, e.currentMonth = s ? a.getMonth() : 0, e.currentYear = s ? a.getFullYear() : 0, this._adjustInstDate( e )
			}
		},
		_getDefaultDate: function( e )
		{
			return this._restrictMinMax( e, this._determineDate( e, this._get( e, "defaultDate" ), new Date ) )
		},
		_determineDate: function( t, i, s )
		{
			var n = function( e )
			{
				var t = new Date;
				return t.setDate( t.getDate() + e ), t
			}, a = function( i )
			{
				try
				{
					return e.datepicker.parseDate( e.datepicker._get( t, "dateFormat" ), i, e.datepicker._getFormatConfig( t ) )
				}
				catch( s )
				{
				}
				for( var n = (i.toLowerCase().match( /^c/ ) ? e.datepicker._getDate( t ) : null) || new Date, a = n.getFullYear(), o = n.getMonth(), r = n.getDate(), h = /([+\-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g, l = h.exec( i ); l; )
				{
					switch( l[ 2 ] || "d" )
					{
						case"d":
						case"D":
							r += parseInt( l[ 1 ], 10 );
							break;
						case"w":
						case"W":
							r += 7 * parseInt( l[ 1 ], 10 );
							break;
						case"m":
						case"M":
							o += parseInt( l[ 1 ], 10 ), r = Math.min( r, e.datepicker._getDaysInMonth( a, o ) );
							break;
						case"y":
						case"Y":
							a += parseInt( l[ 1 ], 10 ), r = Math.min( r, e.datepicker._getDaysInMonth( a, o ) )
					}
					l = h.exec( i )
				}
				return new Date( a, o, r )
			}, o = null == i || "" === i ? s : "string" == typeof i ? a( i ) : "number" == typeof i ? isNaN( i ) ? s : n( i ) : new Date( i.getTime() );
			return o = o && "Invalid Date" == "" + o ? s : o, o && (o.setHours( 0 ), o.setMinutes( 0 ), o.setSeconds( 0 ), o.setMilliseconds( 0 )), this._daylightSavingAdjust( o )
		},
		_daylightSavingAdjust: function( e )
		{
			return e ? (e.setHours( e.getHours() > 12 ? e.getHours() + 2 : 0 ), e) : null
		},
		_setDate: function( e, t, i )
		{
			var s = !t, n = e.selectedMonth, a = e.selectedYear, o = this._restrictMinMax( e, this._determineDate( e, t, new Date ) );
			e.selectedDay = e.currentDay = o.getDate(), e.drawMonth = e.selectedMonth = e.currentMonth = o.getMonth(), e.drawYear = e.selectedYear = e.currentYear = o.getFullYear(), n === e.selectedMonth && a === e.selectedYear || i || this._notifyChange( e ), this._adjustInstDate( e ), e.input && e.input.val( s ? "" : this._formatDate( e ) )
		},
		_getDate: function( e )
		{
			var t = !e.currentYear || e.input && "" === e.input.val() ? null : this._daylightSavingAdjust( new Date( e.currentYear, e.currentMonth, e.currentDay ) );
			return t
		},
		_attachHandlers: function( t )
		{
			var i = this._get( t, "stepMonths" ), s = "#" + t.id.replace( /\\\\/g, "\\" );
			t.dpDiv.find( "[data-handler]" ).map( function()
			{
				var t = {
					prev: function()
					{
						e.datepicker._adjustDate( s, -i, "M" )
					}, next: function()
					{
						e.datepicker._adjustDate( s, +i, "M" )
					}, hide: function()
					{
						e.datepicker._hideDatepicker()
					}, today: function()
					{
						e.datepicker._gotoToday( s )
					}, selectDay: function()
					{
						return e.datepicker._selectDay( s, +this.getAttribute( "data-month" ), +this.getAttribute( "data-year" ), this ), !1
					}, selectMonth: function()
					{
						return e.datepicker._selectMonthYear( s, this, "M" ), !1
					}, selectYear: function()
					{
						return e.datepicker._selectMonthYear( s, this, "Y" ), !1
					}
				};
				e( this ).bind( this.getAttribute( "data-event" ), t[ this.getAttribute( "data-handler" ) ] )
			} )
		},
		_generateHTML: function( e )
		{
			var t, i, s, n, a, o, r, h, l, u, d, c, p, f, m, g, v, y, b, _, x, w, k, T, D, S, N, M, C, P, A, I, H, z, F, E, W, O, L, j = new Date, R = this._daylightSavingAdjust( new Date( j.getFullYear(), j.getMonth(), j.getDate() ) ), Y = this._get( e, "isRTL" ), J = this._get( e, "showButtonPanel" ), B = this._get( e, "hideIfNoPrevNext" ), K = this._get( e, "navigationAsDateFormat" ), U = this._getNumberOfMonths( e ), V = this._get( e, "showCurrentAtPos" ), q = this._get( e, "stepMonths" ), G = 1 !== U[ 0 ] || 1 !== U[ 1 ], X = this._daylightSavingAdjust( e.currentDay ? new Date( e.currentYear, e.currentMonth, e.currentDay ) : new Date( 9999, 9, 9 ) ), Q = this._getMinMaxDate( e, "min" ), $ = this._getMinMaxDate( e, "max" ), Z = e.drawMonth - V, et = e.drawYear;
			if( 0 > Z && (Z += 12, et--), $ )for( t = this._daylightSavingAdjust( new Date( $.getFullYear(), $.getMonth() - U[ 0 ] * U[ 1 ] + 1, $.getDate() ) ), t = Q && Q > t ? Q : t; this._daylightSavingAdjust( new Date( et, Z, 1 ) ) > t; )Z--, 0 > Z && (Z = 11, et--);
			for( e.drawMonth = Z, e.drawYear = et, i = this._get( e, "prevText" ), i = K ? this.formatDate( i, this._daylightSavingAdjust( new Date( et, Z - q, 1 ) ), this._getFormatConfig( e ) ) : i, s = this._canAdjustMonth( e, -1, et, Z ) ? "<a class='ui-datepicker-prev ui-corner-all' data-handler='prev' data-event='click' title='" + i + "'><span class='ui-icon ui-icon-circle-triangle-" + (Y ? "e" : "w") + "'>" + i + "</span></a>" : B ? "" : "<a class='ui-datepicker-prev ui-corner-all ui-state-disabled' title='" + i + "'><span class='ui-icon ui-icon-circle-triangle-" + (Y ? "e" : "w") + "'>" + i + "</span></a>", n = this._get( e, "nextText" ), n = K ? this.formatDate( n, this._daylightSavingAdjust( new Date( et, Z + q, 1 ) ), this._getFormatConfig( e ) ) : n, a = this._canAdjustMonth( e, 1, et, Z ) ? "<a class='ui-datepicker-next ui-corner-all' data-handler='next' data-event='click' title='" + n + "'><span class='ui-icon ui-icon-circle-triangle-" + (Y ? "w" : "e") + "'>" + n + "</span></a>" : B ? "" : "<a class='ui-datepicker-next ui-corner-all ui-state-disabled' title='" + n + "'><span class='ui-icon ui-icon-circle-triangle-" + (Y ? "w" : "e") + "'>" + n + "</span></a>", o = this._get( e, "currentText" ), r = this._get( e, "gotoCurrent" ) && e.currentDay ? X : R, o = K ? this.formatDate( o, r, this._getFormatConfig( e ) ) : o, h = e.inline ? "" : "<button type='button' class='ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all' data-handler='hide' data-event='click'>" + this._get( e, "closeText" ) + "</button>", l = J ? "<div class='ui-datepicker-buttonpane ui-widget-content'>" + (Y ? h : "") + (this._isInRange( e, r ) ? "<button type='button' class='ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all' data-handler='today' data-event='click'>" + o + "</button>" : "") + (Y ? "" : h) + "</div>" : "", u = parseInt( this._get( e, "firstDay" ), 10 ), u = isNaN( u ) ? 0 : u, d = this._get( e, "showWeek" ), c = this._get( e, "dayNames" ), p = this._get( e, "dayNamesMin" ), f = this._get( e, "monthNames" ), m = this._get( e, "monthNamesShort" ), g = this._get( e, "beforeShowDay" ), v = this._get( e, "showOtherMonths" ), y = this._get( e, "selectOtherMonths" ), b = this._getDefaultDate( e ), _ = "", w = 0; U[ 0 ] > w; w++ )
			{
				for( k = "", this.maxRows = 4, T = 0; U[ 1 ] > T; T++ )
				{
					if( D = this._daylightSavingAdjust( new Date( et, Z, e.selectedDay ) ), S = " ui-corner-all", N = "", G )
					{
						if( N += "<div class='ui-datepicker-group", U[ 1 ] > 1 )switch( T )
						{
							case 0:
								N += " ui-datepicker-group-first", S = " ui-corner-" + (Y ? "right" : "left");
								break;
							case U[ 1 ] - 1:
								N += " ui-datepicker-group-last", S = " ui-corner-" + (Y ? "left" : "right");
								break;
							default:
								N += " ui-datepicker-group-middle", S = ""
						}
						N += "'>"
					}
					for( N += "<div class='ui-datepicker-header ui-widget-header ui-helper-clearfix" + S + "'>" + (/all|left/.test( S ) && 0 === w ? Y ? a : s : "") + (/all|right/.test( S ) && 0 === w ? Y ? s : a : "") + this._generateMonthYearHeader( e, Z, et, Q, $, w > 0 || T > 0, f, m ) + "</div><table class='ui-datepicker-calendar'><thead>" + "<tr>", M = d ? "<th class='ui-datepicker-week-col'>" + this._get( e, "weekHeader" ) + "</th>" : "", x = 0; 7 > x; x++ )C = (x + u) % 7, M += "<th scope='col'" + ((x + u + 6) % 7 >= 5 ? " class='ui-datepicker-week-end'" : "") + ">" + "<span title='" + c[ C ] + "'>" + p[ C ] + "</span></th>";
					for( N += M + "</tr></thead><tbody>", P = this._getDaysInMonth( et, Z ), et === e.selectedYear && Z === e.selectedMonth && (e.selectedDay = Math.min( e.selectedDay, P )), A = (this._getFirstDayOfMonth( et, Z ) - u + 7) % 7, I = Math.ceil( (A + P) / 7 ), H = G ? this.maxRows > I ? this.maxRows : I : I, this.maxRows = H, z = this._daylightSavingAdjust( new Date( et, Z, 1 - A ) ), F = 0; H > F; F++ )
					{
						for( N += "<tr>", E = d ? "<td class='ui-datepicker-week-col'>" + this._get( e, "calculateWeek" )( z ) + "</td>" : "", x = 0; 7 > x; x++ )W = g ? g.apply( e.input ? e.input[ 0 ] : null, [ z ] ) : [ !0, "" ], O = z.getMonth() !== Z, L = O && !y || !W[ 0 ] || Q && Q > z || $ && z > $, E += "<td class='" + ((x + u + 6) % 7 >= 5 ? " ui-datepicker-week-end" : "") + (O ? " ui-datepicker-other-month" : "") + (z.getTime() === D.getTime() && Z === e.selectedMonth && e._keyEvent || b.getTime() === z.getTime() && b.getTime() === D.getTime() ? " " + this._dayOverClass : "") + (L ? " " + this._unselectableClass + " ui-state-disabled" : "") + (O && !v ? "" : " " + W[ 1 ] + (z.getTime() === X.getTime() ? " " + this._currentClass : "") + (z.getTime() === R.getTime() ? " ui-datepicker-today" : "")) + "'" + (O && !v || !W[ 2 ] ? "" : " title='" + W[ 2 ].replace( /'/g, "&#39;" ) + "'") + (L ? "" : " data-handler='selectDay' data-event='click' data-month='" + z.getMonth() + "' data-year='" + z.getFullYear() + "'") + ">" + (O && !v ? "&#xa0;" : L ? "<span class='ui-state-default'>" + z.getDate() + "</span>" : "<a class='ui-state-default" + (z.getTime() === R.getTime() ? " ui-state-highlight" : "") + (z.getTime() === X.getTime() ? " ui-state-active" : "") + (O ? " ui-priority-secondary" : "") + "' href='#'>" + z.getDate() + "</a>") + "</td>", z.setDate( z.getDate() + 1 ), z = this._daylightSavingAdjust( z );
						N += E + "</tr>"
					}
					Z++, Z > 11 && (Z = 0, et++), N += "</tbody></table>" + (G ? "</div>" + (U[ 0 ] > 0 && T === U[ 1 ] - 1 ? "<div class='ui-datepicker-row-break'></div>" : "") : ""), k += N
				}
				_ += k
			}
			return _ += l, e._keyEvent = !1, _
		},
		_generateMonthYearHeader: function( e, t, i, s, n, a, o, r )
		{
			var h, l, u, d, c, p, f, m, g = this._get( e, "changeMonth" ), v = this._get( e, "changeYear" ), y = this._get( e, "showMonthAfterYear" ), b = "<div class='ui-datepicker-title'>", _ = "";
			if( a || !g )_ += "<span class='ui-datepicker-month'>" + o[ t ] + "</span>";
			else
			{
				for( h = s && s.getFullYear() === i, l = n && n.getFullYear() === i, _ += "<select class='ui-datepicker-month' data-handler='selectMonth' data-event='change'>", u = 0; 12 > u; u++ )(!h || u >= s.getMonth()) && (!l || n.getMonth() >= u) && (_ += "<option value='" + u + "'" + (u === t ? " selected='selected'" : "") + ">" + r[ u ] + "</option>");
				_ += "</select>"
			}
			if( y || (b += _ + (!a && g && v ? "" : "&#xa0;")), !e.yearshtml )if( e.yearshtml = "", a || !v )b += "<span class='ui-datepicker-year'>" + i + "</span>";
			else
			{
				for( d = this._get( e, "yearRange" ).split( ":" ), c = (new Date).getFullYear(), p = function( e )
				{
					var t = e.match( /c[+\-].*/ ) ? i + parseInt( e.substring( 1 ), 10 ) : e.match( /[+\-].*/ ) ? c + parseInt( e, 10 ) : parseInt( e, 10 );
					return isNaN( t ) ? c : t
				}, f = p( d[ 0 ] ), m = Math.max( f, p( d[ 1 ] || "" ) ), f = s ? Math.max( f, s.getFullYear() ) : f, m = n ? Math.min( m, n.getFullYear() ) : m, e.yearshtml += "<select class='ui-datepicker-year' data-handler='selectYear' data-event='change'>"; m >= f; f++ )e.yearshtml += "<option value='" + f + "'" + (f === i ? " selected='selected'" : "") + ">" + f + "</option>";
				e.yearshtml += "</select>", b += e.yearshtml, e.yearshtml = null
			}
			return b += this._get( e, "yearSuffix" ), y && (b += (!a && g && v ? "" : "&#xa0;") + _), b += "</div>"
		},
		_adjustInstDate: function( e, t, i )
		{
			var s = e.drawYear + ("Y" === i ? t : 0), n = e.drawMonth + ("M" === i ? t : 0), a = Math.min( e.selectedDay, this._getDaysInMonth( s, n ) ) + ("D" === i ? t : 0), o = this._restrictMinMax( e, this._daylightSavingAdjust( new Date( s, n, a ) ) );
			e.selectedDay = o.getDate(), e.drawMonth = e.selectedMonth = o.getMonth(), e.drawYear = e.selectedYear = o.getFullYear(), ("M" === i || "Y" === i) && this._notifyChange( e )
		},
		_restrictMinMax: function( e, t )
		{
			var i = this._getMinMaxDate( e, "min" ), s = this._getMinMaxDate( e, "max" ), n = i && i > t ? i : t;
			return s && n > s ? s : n
		},
		_notifyChange: function( e )
		{
			var t = this._get( e, "onChangeMonthYear" );
			t && t.apply( e.input ? e.input[ 0 ] : null, [ e.selectedYear, e.selectedMonth + 1, e ] )
		},
		_getNumberOfMonths: function( e )
		{
			var t = this._get( e, "numberOfMonths" );
			return null == t ? [ 1, 1 ] : "number" == typeof t ? [ 1, t ] : t
		},
		_getMinMaxDate: function( e, t )
		{
			return this._determineDate( e, this._get( e, t + "Date" ), null )
		},
		_getDaysInMonth: function( e, t )
		{
			return 32 - this._daylightSavingAdjust( new Date( e, t, 32 ) ).getDate()
		},
		_getFirstDayOfMonth: function( e, t )
		{
			return new Date( e, t, 1 ).getDay()
		},
		_canAdjustMonth: function( e, t, i, s )
		{
			var n = this._getNumberOfMonths( e ), a = this._daylightSavingAdjust( new Date( i, s + (0 > t ? t : n[ 0 ] * n[ 1 ]), 1 ) );
			return 0 > t && a.setDate( this._getDaysInMonth( a.getFullYear(), a.getMonth() ) ), this._isInRange( e, a )
		},
		_isInRange: function( e, t )
		{
			var i, s, n = this._getMinMaxDate( e, "min" ), a = this._getMinMaxDate( e, "max" ), o = null, r = null, h = this._get( e, "yearRange" );
			return h && (i = h.split( ":" ), s = (new Date).getFullYear(), o = parseInt( i[ 0 ], 10 ), r = parseInt( i[ 1 ], 10 ), i[ 0 ].match( /[+\-].*/ ) && (o += s), i[ 1 ].match( /[+\-].*/ ) && (r += s)), (!n || t.getTime() >= n.getTime()) && (!a || t.getTime() <= a.getTime()) && (!o || t.getFullYear() >= o) && (!r || r >= t.getFullYear())
		},
		_getFormatConfig: function( e )
		{
			var t = this._get( e, "shortYearCutoff" );
			return t = "string" != typeof t ? t : (new Date).getFullYear() % 100 + parseInt( t, 10 ), {
				shortYearCutoff: t,
				dayNamesShort: this._get( e, "dayNamesShort" ),
				dayNames: this._get( e, "dayNames" ),
				monthNamesShort: this._get( e, "monthNamesShort" ),
				monthNames: this._get( e, "monthNames" )
			}
		},
		_formatDate: function( e, t, i, s )
		{
			t || (e.currentDay = e.selectedDay, e.currentMonth = e.selectedMonth, e.currentYear = e.selectedYear);
			var n = t ? "object" == typeof t ? t : this._daylightSavingAdjust( new Date( s, i, t ) ) : this._daylightSavingAdjust( new Date( e.currentYear, e.currentMonth, e.currentDay ) );
			return this.formatDate( this._get( e, "dateFormat" ), n, this._getFormatConfig( e ) )
		}
	} ), e.fn.datepicker = function( t )
	{
		if( !this.length )return this;
		e.datepicker.initialized || (e( document ).mousedown( e.datepicker._checkExternalClick ), e.datepicker.initialized = !0), 0 === e( "#" + e.datepicker._mainDivId ).length && e( "body" ).append( e.datepicker.dpDiv );
		var i = Array.prototype.slice.call( arguments, 1 );
		return "string" != typeof t || "isDisabled" !== t && "getDate" !== t && "widget" !== t ? "option" === t && 2 === arguments.length && "string" == typeof arguments[ 1 ] ? e.datepicker[ "_" + t + "Datepicker" ].apply( e.datepicker, [ this[ 0 ] ].concat( i ) ) : this.each( function()
		{
			"string" == typeof t ? e.datepicker[ "_" + t + "Datepicker" ].apply( e.datepicker, [ this ].concat( i ) ) : e.datepicker._attachDatepicker( this, t )
		} ) : e.datepicker[ "_" + t + "Datepicker" ].apply( e.datepicker, [ this[ 0 ] ].concat( i ) )
	}, e.datepicker = new n, e.datepicker.initialized = !1, e.datepicker.uuid = (new Date).getTime(), e.datepicker.version = "1.11.4", e.datepicker
} );
/**
 *
 * jQuery RetinaImg replace
 * xlrj0716@gmail.com
 * $(element).RetinaImg();
 * element는 체크할 이미지;
 * 반응형시 mobile(maxMobile), Tablet(maxTablet) breakpoint 조절
 * 2015.04.23 V 0.1
 *
 */

;(function( $, window, document, undefined )
{
	"use strict";

	(function( pluginName )
	{

		var defaults = {
			'item': '.retinaimg',
			'maxMobile': LAE.IS_SIZE.MAXMOBILE || 768,
			'maxTablet': LAE.IS_SIZE.MAXTABLET || 999
		};

		$.fn[ pluginName ] = function( options, settings )
		{
			settings = $.extend( true, {}, defaults, settings );

			var imgSrc = [];

			var _var = {
				itemLen: 0,
				viewType: 'mobile',
				oldViewType: '',
				initFlag: true
			};

			SetViewSize();
			CheckMobile();

			return this.each( function()
			{
				var elem = this;
				var $item = $( settings.item )

				_var.itemLen = $item.length;

				/**
				 * 단말기 구분은 기본적으로
				 * document.documentElement.clientWidth와 userAgent값을 가져와서 구분
				 */

				this.init = function()
				{
					DeivceChkFn();
					this.RetinaReplace();
					this.ChangeBandImgSrc();
				};

				/*this.DeivceChk = function() {
				 var deviceWidth = LAE.VIEWPORT_WIDTH;
				 if(deviceWidth < $maxMobile && LAE.IS_MOBILE){
				 _var.viewType = 'mobile';

				 } else if(deviceWidth <= $maxTablet && LAE.IS_MOBILE){
				 _var.viewType = 'tablet';
				 } else {
				 if(deviceWidth < $maxMobile ) {
				 _var.viewType = 'mobile';
				 } else if (deviceWidth <= $maxTablet ) {
				 _var.viewType = 'tablet';
				 } else {
				 _var.viewType = 'pc';
				 }
				 }
				 };*/

				/**
				 * 레티나 3x 이미지까지 고려
				 * 필요없는 경우 조정해서 이미지 개수 최소화
				 * 기본으로(아이폰6plus까지) pc 이미지 1개와 모바일 태블릿 이미지 3씩 준비 총 7장의 이미지가 필요함
				 * 맥북 레티나까지 고려와 @4x 까지 전체적으로 고려시 총 12장의 이미지가 필요
				 */

				this.RetinaReplace = function()
				{
					$item.each( function( index )
					{
						var $this = $( this );
						if( LAE.IS_VIEWTYPE != 'pc' && window.devicePixelRatio != undefined )
						{ // 일반적인 pc사용시

							//				if(window.devicePixelRatio != undefined) { // 맥북 레티나 고려시
							if( $this.data( LAE.IS_VIEWTYPE ).indexOf( '@' ) != -1 )
							{
								//if (window.devicePixelRatio >= 4) {
								//	imgSrc[index] = $this.data(viewType).replace(/\@1x/g, '@4x');
								//} else /* 4x 이미지 필요시 활성화 */
								if( window.devicePixelRatio >= 3 )
								{
									imgSrc[ index ] = $this.data( LAE.IS_VIEWTYPE ).replace( /\@1x/g, '@3x' );
								}
								else
									if( window.devicePixelRatio >= 2 )
									{
										imgSrc[ index ] = $this.data( LAE.IS_VIEWTYPE ).replace( /\@1x/g, '@2x' );
									}
									else
										if( window.devicePixelRatio >= 1 )
										{
											imgSrc[ index ] = $this.data( LAE.IS_VIEWTYPE );
										}
							}
							else
							{
								imgSrc[ index ] = $this.data( LAE.IS_VIEWTYPE );
							}
						}
						else
						{
							imgSrc[ index ] = $this.data( LAE.IS_VIEWTYPE );
						}
					} );
				};

				this.ChangeBandImgSrc = function()
				{
					if( _var.initFlag || _var.oldViewType != LAE.IS_VIEWTYPE )
					{
						var $img = [];
						$item.each( function( index )
						{
							$img[ index ] = $item.eq( index );
							$img[ index ].attr( 'src', imgSrc[ index ] );
						} );
						_var.initFlag = false;
						_var.oldViewType = LAE.IS_VIEWTYPE;
					}
				};

				$( window ).resize( function()
				{
					if( _var.itemLen > 0 )
					{
						SetViewSize();
						CheckMobile();
						DeivceChkFn();
						elem.RetinaReplace();
						elem.ChangeBandImgSrc();
					}
				} );
				this.init();
			} );
		};
		$.fn[ pluginName ].defaults = defaults;
	})( 'RetinaImg' );
})( jQuery, window, document, undefined );

/*!
 * VERSION: 1.17.0
 * DATE: 2015-05-27
 * UPDATES AND DOCS AT: http://greensock.com
 *
 * Includes all of the following: TweenLite, TweenMax, TimelineLite, TimelineMax, EasePack, CSSPlugin, RoundPropsPlugin, BezierPlugin, AttrPlugin, DirectionalRotationPlugin
 *
 * @license Copyright (c) 2008-2015, GreenSock. All rights reserved.
 * This work is subject to the terms at http://greensock.com/standard-license or for
 * Club GreenSock members, the software agreement that was issued with your membership.
 *
 * @author: Jack Doyle, jack@greensock.com
 **/
var _gsScope = "undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window;
(_gsScope._gsQueue || (_gsScope._gsQueue = [])).push( function()
{
	"use strict";
	_gsScope._gsDefine( "TweenMax", [ "core.Animation", "core.SimpleTimeline", "TweenLite" ], function( t, e, i )
	{
		var s = function( t )
		{
			var e, i = [], s = t.length;
			for( e = 0; e !== s; i.push( t[ e++ ] ) );
			return i
		}, r = function( t, e, s )
		{
			i.call( this, t, e, s ), this._cycle = 0, this._yoyo = this.vars.yoyo === !0, this._repeat = this.vars.repeat || 0, this._repeatDelay = this.vars.repeatDelay || 0, this._dirty = !0, this.render = r.prototype.render
		}, n = 1e-10, a = i._internals, o = a.isSelector, h = a.isArray, l = r.prototype = i.to( {}, .1, {} ), _ = [];
		r.version = "1.17.0", l.constructor = r, l.kill()._gc = !1, r.killTweensOf = r.killDelayedCallsTo = i.killTweensOf, r.getTweensOf = i.getTweensOf, r.lagSmoothing = i.lagSmoothing, r.ticker = i.ticker, r.render = i.render, l.invalidate = function()
		{
			return this._yoyo = this.vars.yoyo === !0, this._repeat = this.vars.repeat || 0, this._repeatDelay = this.vars.repeatDelay || 0, this._uncache( !0 ), i.prototype.invalidate.call( this )
		}, l.updateTo = function( t, e )
		{
			var s, r = this.ratio, n = this.vars.immediateRender || t.immediateRender;
			e && this._startTime < this._timeline._time && (this._startTime = this._timeline._time, this._uncache( !1 ), this._gc ? this._enabled( !0, !1 ) : this._timeline.insert( this, this._startTime - this._delay ));
			for( s in t )this.vars[ s ] = t[ s ];
			if( this._initted || n )if( e )this._initted = !1, n && this.render( 0, !0, !0 );
			else
				if( this._gc && this._enabled( !0, !1 ), this._notifyPluginsOfEnabled && this._firstPT && i._onPluginEvent( "_onDisable", this ), this._time / this._duration > .998 )
				{
					var a = this._time;
					this.render( 0, !0, !1 ), this._initted = !1, this.render( a, !0, !1 )
				}
				else
					if( this._time > 0 || n )
					{
						this._initted = !1, this._init();
						for( var o, h = 1 / (1 - r), l = this._firstPT; l; )o = l.s + l.c, l.c *= h, l.s = o - l.c, l = l._next
					}
			return this
		}, l.render = function( t, e, i )
		{
			this._initted || 0 === this._duration && this.vars.repeat && this.invalidate();
			var s, r, o, h, l, _, u, c, f = this._dirty ? this.totalDuration() : this._totalDuration, p = this._time, m = this._totalTime, d = this._cycle, g = this._duration, v = this._rawPrevTime;
			if( t >= f ? (this._totalTime = f, this._cycle = this._repeat, this._yoyo && 0 !== (1 & this._cycle) ? (this._time = 0, this.ratio = this._ease._calcEnd ? this._ease.getRatio( 0 ) : 0) : (this._time = g, this.ratio = this._ease._calcEnd ? this._ease.getRatio( 1 ) : 1), this._reversed || (s = !0, r = "onComplete", i = i || this._timeline.autoRemoveChildren), 0 === g && (this._initted || !this.vars.lazy || i) && (this._startTime === this._timeline._duration && (t = 0), (0 === t || 0 > v || v === n) && v !== t && (i = !0, v > n && (r = "onReverseComplete")), this._rawPrevTime = c = !e || t || v === t ? t : n)) : 1e-7 > t ? (this._totalTime = this._time = this._cycle = 0, this.ratio = this._ease._calcEnd ? this._ease.getRatio( 0 ) : 0, (0 !== m || 0 === g && v > 0) && (r = "onReverseComplete", s = this._reversed), 0 > t && (this._active = !1, 0 === g && (this._initted || !this.vars.lazy || i) && (v >= 0 && (i = !0), this._rawPrevTime = c = !e || t || v === t ? t : n)), this._initted || (i = !0)) : (this._totalTime = this._time = t, 0 !== this._repeat && (h = g + this._repeatDelay, this._cycle = this._totalTime / h >> 0, 0 !== this._cycle && this._cycle === this._totalTime / h && this._cycle--, this._time = this._totalTime - this._cycle * h, this._yoyo && 0 !== (1 & this._cycle) && (this._time = g - this._time), this._time > g ? this._time = g : 0 > this._time && (this._time = 0)), this._easeType ? (l = this._time / g, _ = this._easeType, u = this._easePower, (1 === _ || 3 === _ && l >= .5) && (l = 1 - l), 3 === _ && (l *= 2), 1 === u ? l *= l : 2 === u ? l *= l * l : 3 === u ? l *= l * l * l : 4 === u && (l *= l * l * l * l), this.ratio = 1 === _ ? 1 - l : 2 === _ ? l : .5 > this._time / g ? l / 2 : 1 - l / 2) : this.ratio = this._ease.getRatio( this._time / g )), p === this._time && !i && d === this._cycle )return m !== this._totalTime && this._onUpdate && (e || this._callback( "onUpdate" )), void 0;
			if( !this._initted )
			{
				if( this._init(), !this._initted || this._gc )return;
				if( !i && this._firstPT && (this.vars.lazy !== !1 && this._duration || this.vars.lazy && !this._duration) )return this._time = p, this._totalTime = m, this._rawPrevTime = v, this._cycle = d, a.lazyTweens.push( this ), this._lazy = [ t, e ], void 0;
				this._time && !s ? this.ratio = this._ease.getRatio( this._time / g ) : s && this._ease._calcEnd && (this.ratio = this._ease.getRatio( 0 === this._time ? 0 : 1 ))
			}
			for( this._lazy !== !1 && (this._lazy = !1), this._active || !this._paused && this._time !== p && t >= 0 && (this._active = !0), 0 === m && (2 === this._initted && t > 0 && this._init(), this._startAt && (t >= 0 ? this._startAt.render( t, e, i ) : r || (r = "_dummyGS")), this.vars.onStart && (0 !== this._totalTime || 0 === g) && (e || this._callback( "onStart" ))), o = this._firstPT; o; )o.f ? o.t[ o.p ]( o.c * this.ratio + o.s ) : o.t[ o.p ] = o.c * this.ratio + o.s, o = o._next;
			this._onUpdate && (0 > t && this._startAt && this._startTime && this._startAt.render( t, e, i ), e || (this._totalTime !== m || s) && this._callback( "onUpdate" )), this._cycle !== d && (e || this._gc || this.vars.onRepeat && this._callback( "onRepeat" )), r && (!this._gc || i) && (0 > t && this._startAt && !this._onUpdate && this._startTime && this._startAt.render( t, e, i ), s && (this._timeline.autoRemoveChildren && this._enabled( !1, !1 ), this._active = !1), !e && this.vars[ r ] && this._callback( r ), 0 === g && this._rawPrevTime === n && c !== n && (this._rawPrevTime = 0))
		}, r.to = function( t, e, i )
		{
			return new r( t, e, i )
		}, r.from = function( t, e, i )
		{
			return i.runBackwards = !0, i.immediateRender = 0 != i.immediateRender, new r( t, e, i )
		}, r.fromTo = function( t, e, i, s )
		{
			return s.startAt = i, s.immediateRender = 0 != s.immediateRender && 0 != i.immediateRender, new r( t, e, s )
		}, r.staggerTo = r.allTo = function( t, e, n, a, l, u, c )
		{
			a = a || 0;
			var f, p, m, d, g = n.delay || 0, v = [], y = function()
			{
				n.onComplete && n.onComplete.apply( n.onCompleteScope || this, arguments ), l.apply( c || n.callbackScope || this, u || _ )
			};
			for( h( t ) || ("string" == typeof t && (t = i.selector( t ) || t), o( t ) && (t = s( t ))), t = t || [], 0 > a && (t = s( t ), t.reverse(), a *= -1), f = t.length - 1, m = 0; f >= m; m++ )
			{
				p = {};
				for( d in n )p[ d ] = n[ d ];
				p.delay = g, m === f && l && (p.onComplete = y), v[ m ] = new r( t[ m ], e, p ), g += a
			}
			return v
		}, r.staggerFrom = r.allFrom = function( t, e, i, s, n, a, o )
		{
			return i.runBackwards = !0, i.immediateRender = 0 != i.immediateRender, r.staggerTo( t, e, i, s, n, a, o )
		}, r.staggerFromTo = r.allFromTo = function( t, e, i, s, n, a, o, h )
		{
			return s.startAt = i, s.immediateRender = 0 != s.immediateRender && 0 != i.immediateRender, r.staggerTo( t, e, s, n, a, o, h )
		}, r.delayedCall = function( t, e, i, s, n )
		{
			return new r( e, 0, {
				delay: t,
				onComplete: e,
				onCompleteParams: i,
				callbackScope: s,
				onReverseComplete: e,
				onReverseCompleteParams: i,
				immediateRender: !1,
				useFrames: n,
				overwrite: 0
			} )
		}, r.set = function( t, e )
		{
			return new r( t, 0, e )
		}, r.isTweening = function( t )
		{
			return i.getTweensOf( t, !0 ).length > 0
		};
		var u = function( t, e )
		{
			for( var s = [], r = 0, n = t._first; n; )n instanceof i ? s[ r++ ] = n : (e && (s[ r++ ] = n), s = s.concat( u( n, e ) ), r = s.length), n = n._next;
			return s
		}, c = r.getAllTweens = function( e )
		{
			return u( t._rootTimeline, e ).concat( u( t._rootFramesTimeline, e ) )
		};
		r.killAll = function( t, i, s, r )
		{
			null == i && (i = !0), null == s && (s = !0);
			var n, a, o, h = c( 0 != r ), l = h.length, _ = i && s && r;
			for( o = 0; l > o; o++ )a = h[ o ], (_ || a instanceof e || (n = a.target === a.vars.onComplete) && s || i && !n) && (t ? a.totalTime( a._reversed ? 0 : a.totalDuration() ) : a._enabled( !1, !1 ))
		}, r.killChildTweensOf = function( t, e )
		{
			if( null != t )
			{
				var n, l, _, u, c, f = a.tweenLookup;
				if( "string" == typeof t && (t = i.selector( t ) || t), o( t ) && (t = s( t )), h( t ) )for( u = t.length; --u > -1; )r.killChildTweensOf( t[ u ], e );
				else
				{
					n = [];
					for( _ in f )for( l = f[ _ ].target.parentNode; l; )l === t && (n = n.concat( f[ _ ].tweens )), l = l.parentNode;
					for( c = n.length, u = 0; c > u; u++ )e && n[ u ].totalTime( n[ u ].totalDuration() ), n[ u ]._enabled( !1, !1 )
				}
			}
		};
		var f = function( t, i, s, r )
		{
			i = i !== !1, s = s !== !1, r = r !== !1;
			for( var n, a, o = c( r ), h = i && s && r, l = o.length; --l > -1; )a = o[ l ], (h || a instanceof e || (n = a.target === a.vars.onComplete) && s || i && !n) && a.paused( t )
		};
		return r.pauseAll = function( t, e, i )
		{
			f( !0, t, e, i )
		}, r.resumeAll = function( t, e, i )
		{
			f( !1, t, e, i )
		}, r.globalTimeScale = function( e )
		{
			var s = t._rootTimeline, r = i.ticker.time;
			return arguments.length ? (e = e || n, s._startTime = r - (r - s._startTime) * s._timeScale / e, s = t._rootFramesTimeline, r = i.ticker.frame, s._startTime = r - (r - s._startTime) * s._timeScale / e, s._timeScale = t._rootTimeline._timeScale = e, e) : s._timeScale
		}, l.progress = function( t )
		{
			return arguments.length ? this.totalTime( this.duration() * (this._yoyo && 0 !== (1 & this._cycle) ? 1 - t : t) + this._cycle * (this._duration + this._repeatDelay), !1 ) : this._time / this.duration()
		}, l.totalProgress = function( t )
		{
			return arguments.length ? this.totalTime( this.totalDuration() * t, !1 ) : this._totalTime / this.totalDuration()
		}, l.time = function( t, e )
		{
			return arguments.length ? (this._dirty && this.totalDuration(), t > this._duration && (t = this._duration), this._yoyo && 0 !== (1 & this._cycle) ? t = this._duration - t + this._cycle * (this._duration + this._repeatDelay) : 0 !== this._repeat && (t += this._cycle * (this._duration + this._repeatDelay)), this.totalTime( t, e )) : this._time
		}, l.duration = function( e )
		{
			return arguments.length ? t.prototype.duration.call( this, e ) : this._duration
		}, l.totalDuration = function( t )
		{
			return arguments.length ? -1 === this._repeat ? this : this.duration( (t - this._repeat * this._repeatDelay) / (this._repeat + 1) ) : (this._dirty && (this._totalDuration = -1 === this._repeat ? 999999999999 : this._duration * (this._repeat + 1) + this._repeatDelay * this._repeat, this._dirty = !1), this._totalDuration)
		}, l.repeat = function( t )
		{
			return arguments.length ? (this._repeat = t, this._uncache( !0 )) : this._repeat
		}, l.repeatDelay = function( t )
		{
			return arguments.length ? (this._repeatDelay = t, this._uncache( !0 )) : this._repeatDelay
		}, l.yoyo = function( t )
		{
			return arguments.length ? (this._yoyo = t, this) : this._yoyo
		}, r
	}, !0 ), _gsScope._gsDefine( "TimelineLite", [ "core.Animation", "core.SimpleTimeline", "TweenLite" ], function( t, e, i )
	{
		var s = function( t )
		{
			e.call( this, t ), this._labels = {}, this.autoRemoveChildren = this.vars.autoRemoveChildren === !0, this.smoothChildTiming = this.vars.smoothChildTiming === !0, this._sortChildren = !0, this._onUpdate = this.vars.onUpdate;
			var i, s, r = this.vars;
			for( s in r )i = r[ s ], h( i ) && -1 !== i.join( "" ).indexOf( "{self}" ) && (r[ s ] = this._swapSelfInParams( i ));
			h( r.tweens ) && this.add( r.tweens, 0, r.align, r.stagger )
		}, r = 1e-10, n = i._internals, a = s._internals = {}, o = n.isSelector, h = n.isArray, l = n.lazyTweens, _ = n.lazyRender, u = [], c = _gsScope._gsDefine.globals, f = function( t )
		{
			var e, i = {};
			for( e in t )i[ e ] = t[ e ];
			return i
		}, p = a.pauseCallback = function( t, e, i, s )
		{
			var n, a = t._timeline, o = a._totalTime, h = t._startTime, l = 0 > t._rawPrevTime || 0 === t._rawPrevTime && a._reversed, _ = l ? 0 : r, c = l ? r : 0;
			if( e || !this._forcingPlayhead )
			{
				for( a.pause( h ), n = t._prev; n && n._startTime === h; )n._rawPrevTime = c, n = n._prev;
				for( n = t._next; n && n._startTime === h; )n._rawPrevTime = _, n = n._next;
				e && e.apply( s || a.vars.callbackScope || a, i || u ), (this._forcingPlayhead || !a._paused) && a.seek( o )
			}
		}, m = function( t )
		{
			var e, i = [], s = t.length;
			for( e = 0; e !== s; i.push( t[ e++ ] ) );
			return i
		}, d = s.prototype = new e;
		return s.version = "1.17.0", d.constructor = s, d.kill()._gc = d._forcingPlayhead = !1, d.to = function( t, e, s, r )
		{
			var n = s.repeat && c.TweenMax || i;
			return e ? this.add( new n( t, e, s ), r ) : this.set( t, s, r )
		}, d.from = function( t, e, s, r )
		{
			return this.add( (s.repeat && c.TweenMax || i).from( t, e, s ), r )
		}, d.fromTo = function( t, e, s, r, n )
		{
			var a = r.repeat && c.TweenMax || i;
			return e ? this.add( a.fromTo( t, e, s, r ), n ) : this.set( t, r, n )
		}, d.staggerTo = function( t, e, r, n, a, h, l, _ )
		{
			var u, c = new s( {
				onComplete: h,
				onCompleteParams: l,
				callbackScope: _,
				smoothChildTiming: this.smoothChildTiming
			} );
			for( "string" == typeof t && (t = i.selector( t ) || t), t = t || [], o( t ) && (t = m( t )), n = n || 0, 0 > n && (t = m( t ), t.reverse(), n *= -1), u = 0; t.length > u; u++ )r.startAt && (r.startAt = f( r.startAt )), c.to( t[ u ], e, f( r ), u * n );
			return this.add( c, a )
		}, d.staggerFrom = function( t, e, i, s, r, n, a, o )
		{
			return i.immediateRender = 0 != i.immediateRender, i.runBackwards = !0, this.staggerTo( t, e, i, s, r, n, a, o )
		}, d.staggerFromTo = function( t, e, i, s, r, n, a, o, h )
		{
			return s.startAt = i, s.immediateRender = 0 != s.immediateRender && 0 != i.immediateRender, this.staggerTo( t, e, s, r, n, a, o, h )
		}, d.call = function( t, e, s, r )
		{
			return this.add( i.delayedCall( 0, t, e, s ), r )
		}, d.set = function( t, e, s )
		{
			return s = this._parseTimeOrLabel( s, 0, !0 ), null == e.immediateRender && (e.immediateRender = s === this._time && !this._paused), this.add( new i( t, 0, e ), s )
		}, s.exportRoot = function( t, e )
		{
			t = t || {}, null == t.smoothChildTiming && (t.smoothChildTiming = !0);
			var r, n, a = new s( t ), o = a._timeline;
			for( null == e && (e = !0), o._remove( a, !0 ), a._startTime = 0, a._rawPrevTime = a._time = a._totalTime = o._time, r = o._first; r; )n = r._next, e && r instanceof i && r.target === r.vars.onComplete || a.add( r, r._startTime - r._delay ), r = n;
			return o.add( a, 0 ), a
		}, d.add = function( r, n, a, o )
		{
			var l, _, u, c, f, p;
			if( "number" != typeof n && (n = this._parseTimeOrLabel( n, 0, !0, r )), !(r instanceof t) )
			{
				if( r instanceof Array || r && r.push && h( r ) )
				{
					for( a = a || "normal", o = o || 0, l = n, _ = r.length, u = 0; _ > u; u++ )h( c = r[ u ] ) && (c = new s( { tweens: c } )), this.add( c, l ), "string" != typeof c && "function" != typeof c && ("sequence" === a ? l = c._startTime + c.totalDuration() / c._timeScale : "start" === a && (c._startTime -= c.delay())), l += o;
					return this._uncache( !0 )
				}
				if( "string" == typeof r )return this.addLabel( r, n );
				if( "function" != typeof r )throw"Cannot add " + r + " into the timeline; it is not a tween, timeline, function, or string.";
				r = i.delayedCall( 0, r )
			}
			if( e.prototype.add.call( this, r, n ), (this._gc || this._time === this._duration) && !this._paused && this._duration < this.duration() )for( f = this, p = f.rawTime() > r._startTime; f._timeline; )p && f._timeline.smoothChildTiming ? f.totalTime( f._totalTime, !0 ) : f._gc && f._enabled( !0, !1 ), f = f._timeline;
			return this
		}, d.remove = function( e )
		{
			if( e instanceof t )return this._remove( e, !1 );
			if( e instanceof Array || e && e.push && h( e ) )
			{
				for( var i = e.length; --i > -1; )this.remove( e[ i ] );
				return this
			}
			return "string" == typeof e ? this.removeLabel( e ) : this.kill( null, e )
		}, d._remove = function( t, i )
		{
			e.prototype._remove.call( this, t, i );
			var s = this._last;
			return s ? this._time > s._startTime + s._totalDuration / s._timeScale && (this._time = this.duration(), this._totalTime = this._totalDuration) : this._time = this._totalTime = this._duration = this._totalDuration = 0, this
		}, d.append = function( t, e )
		{
			return this.add( t, this._parseTimeOrLabel( null, e, !0, t ) )
		}, d.insert = d.insertMultiple = function( t, e, i, s )
		{
			return this.add( t, e || 0, i, s )
		}, d.appendMultiple = function( t, e, i, s )
		{
			return this.add( t, this._parseTimeOrLabel( null, e, !0, t ), i, s )
		}, d.addLabel = function( t, e )
		{
			return this._labels[ t ] = this._parseTimeOrLabel( e ), this
		}, d.addPause = function( t, e, s, r )
		{
			var n = i.delayedCall( 0, p, [ "{self}", e, s, r ], this );
			return n.data = "isPause", this.add( n, t )
		}, d.removeLabel = function( t )
		{
			return delete this._labels[ t ], this
		}, d.getLabelTime = function( t )
		{
			return null != this._labels[ t ] ? this._labels[ t ] : -1
		}, d._parseTimeOrLabel = function( e, i, s, r )
		{
			var n;
			if( r instanceof t && r.timeline === this )this.remove( r );
			else
				if( r && (r instanceof Array || r.push && h( r )) )for( n = r.length; --n > -1; )r[ n ] instanceof t && r[ n ].timeline === this && this.remove( r[ n ] );
			if( "string" == typeof i )return this._parseTimeOrLabel( i, s && "number" == typeof e && null == this._labels[ i ] ? e - this.duration() : 0, s );
			if( i = i || 0, "string" != typeof e || !isNaN( e ) && null == this._labels[ e ] )null == e && (e = this.duration());
			else
			{
				if( n = e.indexOf( "=" ), -1 === n )return null == this._labels[ e ] ? s ? this._labels[ e ] = this.duration() + i : i : this._labels[ e ] + i;
				i = parseInt( e.charAt( n - 1 ) + "1", 10 ) * Number( e.substr( n + 1 ) ), e = n > 1 ? this._parseTimeOrLabel( e.substr( 0, n - 1 ), 0, s ) : this.duration()
			}
			return Number( e ) + i
		}, d.seek = function( t, e )
		{
			return this.totalTime( "number" == typeof t ? t : this._parseTimeOrLabel( t ), e !== !1 )
		}, d.stop = function()
		{
			return this.paused( !0 )
		}, d.gotoAndPlay = function( t, e )
		{
			return this.play( t, e )
		}, d.gotoAndStop = function( t, e )
		{
			return this.pause( t, e )
		}, d.render = function( t, e, i )
		{
			this._gc && this._enabled( !0, !1 );
			var s, n, a, o, h, u = this._dirty ? this.totalDuration() : this._totalDuration, c = this._time, f = this._startTime, p = this._timeScale, m = this._paused;
			if( t >= u )this._totalTime = this._time = u, this._reversed || this._hasPausedChild() || (n = !0, o = "onComplete", h = !!this._timeline.autoRemoveChildren, 0 === this._duration && (0 === t || 0 > this._rawPrevTime || this._rawPrevTime === r) && this._rawPrevTime !== t && this._first && (h = !0, this._rawPrevTime > r && (o = "onReverseComplete"))), this._rawPrevTime = this._duration || !e || t || this._rawPrevTime === t ? t : r, t = u + 1e-4;
			else
				if( 1e-7 > t )if( this._totalTime = this._time = 0, (0 !== c || 0 === this._duration && this._rawPrevTime !== r && (this._rawPrevTime > 0 || 0 > t && this._rawPrevTime >= 0)) && (o = "onReverseComplete", n = this._reversed), 0 > t )this._active = !1, this._timeline.autoRemoveChildren && this._reversed ? (h = n = !0, o = "onReverseComplete") : this._rawPrevTime >= 0 && this._first && (h = !0), this._rawPrevTime = t;
				else
				{
					if( this._rawPrevTime = this._duration || !e || t || this._rawPrevTime === t ? t : r, 0 === t && n )for( s = this._first; s && 0 === s._startTime; )s._duration || (n = !1), s = s._next;
					t = 0, this._initted || (h = !0)
				}
				else this._totalTime = this._time = this._rawPrevTime = t;
			if( this._time !== c && this._first || i || h )
			{
				if( this._initted || (this._initted = !0), this._active || !this._paused && this._time !== c && t > 0 && (this._active = !0), 0 === c && this.vars.onStart && 0 !== this._time && (e || this._callback( "onStart" )), this._time >= c )for( s = this._first; s && (a = s._next, !this._paused || m); )(s._active || s._startTime <= this._time && !s._paused && !s._gc) && (s._reversed ? s.render( (s._dirty ? s.totalDuration() : s._totalDuration) - (t - s._startTime) * s._timeScale, e, i ) : s.render( (t - s._startTime) * s._timeScale, e, i )), s = a;
				else for( s = this._last; s && (a = s._prev, !this._paused || m); )(s._active || c >= s._startTime && !s._paused && !s._gc) && (s._reversed ? s.render( (s._dirty ? s.totalDuration() : s._totalDuration) - (t - s._startTime) * s._timeScale, e, i ) : s.render( (t - s._startTime) * s._timeScale, e, i )), s = a;
				this._onUpdate && (e || (l.length && _(), this._callback( "onUpdate" ))), o && (this._gc || (f === this._startTime || p !== this._timeScale) && (0 === this._time || u >= this.totalDuration()) && (n && (l.length && _(), this._timeline.autoRemoveChildren && this._enabled( !1, !1 ), this._active = !1), !e && this.vars[ o ] && this._callback( o )))
			}
		}, d._hasPausedChild = function()
		{
			for( var t = this._first; t; )
			{
				if( t._paused || t instanceof s && t._hasPausedChild() )return !0;
				t = t._next
			}
			return !1
		}, d.getChildren = function( t, e, s, r )
		{
			r = r || -9999999999;
			for( var n = [], a = this._first, o = 0; a; )r > a._startTime || (a instanceof i ? e !== !1 && (n[ o++ ] = a) : (s !== !1 && (n[ o++ ] = a), t !== !1 && (n = n.concat( a.getChildren( !0, e, s ) ), o = n.length))), a = a._next;
			return n
		}, d.getTweensOf = function( t, e )
		{
			var s, r, n = this._gc, a = [], o = 0;
			for( n && this._enabled( !0, !0 ), s = i.getTweensOf( t ), r = s.length; --r > -1; )(s[ r ].timeline === this || e && this._contains( s[ r ] )) && (a[ o++ ] = s[ r ]);
			return n && this._enabled( !1, !0 ), a
		}, d.recent = function()
		{
			return this._recent
		}, d._contains = function( t )
		{
			for( var e = t.timeline; e; )
			{
				if( e === this )return !0;
				e = e.timeline
			}
			return !1
		}, d.shiftChildren = function( t, e, i )
		{
			i = i || 0;
			for( var s, r = this._first, n = this._labels; r; )r._startTime >= i && (r._startTime += t), r = r._next;
			if( e )for( s in n )n[ s ] >= i && (n[ s ] += t);
			return this._uncache( !0 )
		}, d._kill = function( t, e )
		{
			if( !t && !e )return this._enabled( !1, !1 );
			for( var i = e ? this.getTweensOf( e ) : this.getChildren( !0, !0, !1 ), s = i.length, r = !1; --s > -1; )i[ s ]._kill( t, e ) && (r = !0);
			return r
		}, d.clear = function( t )
		{
			var e = this.getChildren( !1, !0, !0 ), i = e.length;
			for( this._time = this._totalTime = 0; --i > -1; )e[ i ]._enabled( !1, !1 );
			return t !== !1 && (this._labels = {}), this._uncache( !0 )
		}, d.invalidate = function()
		{
			for( var e = this._first; e; )e.invalidate(), e = e._next;
			return t.prototype.invalidate.call( this )
		}, d._enabled = function( t, i )
		{
			if( t === this._gc )for( var s = this._first; s; )s._enabled( t, !0 ), s = s._next;
			return e.prototype._enabled.call( this, t, i )
		}, d.totalTime = function()
		{
			this._forcingPlayhead = !0;
			var e = t.prototype.totalTime.apply( this, arguments );
			return this._forcingPlayhead = !1, e
		}, d.duration = function( t )
		{
			return arguments.length ? (0 !== this.duration() && 0 !== t && this.timeScale( this._duration / t ), this) : (this._dirty && this.totalDuration(), this._duration)
		}, d.totalDuration = function( t )
		{
			if( !arguments.length )
			{
				if( this._dirty )
				{
					for( var e, i, s = 0, r = this._last, n = 999999999999; r; )e = r._prev, r._dirty && r.totalDuration(), r._startTime > n && this._sortChildren && !r._paused ? this.add( r, r._startTime - r._delay ) : n = r._startTime, 0 > r._startTime && !r._paused && (s -= r._startTime, this._timeline.smoothChildTiming && (this._startTime += r._startTime / this._timeScale), this.shiftChildren( -r._startTime, !1, -9999999999 ), n = 0), i = r._startTime + r._totalDuration / r._timeScale, i > s && (s = i), r = e;
					this._duration = this._totalDuration = s, this._dirty = !1
				}
				return this._totalDuration
			}
			return 0 !== this.totalDuration() && 0 !== t && this.timeScale( this._totalDuration / t ), this
		}, d.paused = function( e )
		{
			if( !e )for( var i = this._first, s = this._time; i; )i._startTime === s && "isPause" === i.data && (i._rawPrevTime = 0), i = i._next;
			return t.prototype.paused.apply( this, arguments )
		}, d.usesFrames = function()
		{
			for( var e = this._timeline; e._timeline; )e = e._timeline;
			return e === t._rootFramesTimeline
		}, d.rawTime = function()
		{
			return this._paused ? this._totalTime : (this._timeline.rawTime() - this._startTime) * this._timeScale
		}, s
	}, !0 ), _gsScope._gsDefine( "TimelineMax", [ "TimelineLite", "TweenLite", "easing.Ease" ], function( t, e, i )
	{
		var s = function( e )
		{
			t.call( this, e ), this._repeat = this.vars.repeat || 0, this._repeatDelay = this.vars.repeatDelay || 0, this._cycle = 0, this._yoyo = this.vars.yoyo === !0, this._dirty = !0
		}, r = 1e-10, n = e._internals, a = n.lazyTweens, o = n.lazyRender, h = new i( null, null, 1, 0 ), l = s.prototype = new t;
		return l.constructor = s, l.kill()._gc = !1, s.version = "1.17.0", l.invalidate = function()
		{
			return this._yoyo = this.vars.yoyo === !0, this._repeat = this.vars.repeat || 0, this._repeatDelay = this.vars.repeatDelay || 0, this._uncache( !0 ), t.prototype.invalidate.call( this )
		}, l.addCallback = function( t, i, s, r )
		{
			return this.add( e.delayedCall( 0, t, s, r ), i )
		}, l.removeCallback = function( t, e )
		{
			if( t )if( null == e )this._kill( null, t );
			else for( var i = this.getTweensOf( t, !1 ), s = i.length, r = this._parseTimeOrLabel( e ); --s > -1; )i[ s ]._startTime === r && i[ s ]._enabled( !1, !1 );
			return this
		}, l.removePause = function( e )
		{
			return this.removeCallback( t._internals.pauseCallback, e )
		}, l.tweenTo = function( t, i )
		{
			i = i || {};
			var s, r, n, a = { ease: h, useFrames: this.usesFrames(), immediateRender: !1 };
			for( r in i )a[ r ] = i[ r ];
			return a.time = this._parseTimeOrLabel( t ), s = Math.abs( Number( a.time ) - this._time ) / this._timeScale || .001, n = new e( this, s, a ), a.onStart = function()
			{
				n.target.paused( !0 ), n.vars.time !== n.target.time() && s === n.duration() && n.duration( Math.abs( n.vars.time - n.target.time() ) / n.target._timeScale ), i.onStart && n._callback( "onStart" )
			}, n
		}, l.tweenFromTo = function( t, e, i )
		{
			i = i || {}, t = this._parseTimeOrLabel( t ), i.startAt = {
				onComplete: this.seek,
				onCompleteParams: [ t ],
				callbackScope: this
			}, i.immediateRender = i.immediateRender !== !1;
			var s = this.tweenTo( e, i );
			return s.duration( Math.abs( s.vars.time - t ) / this._timeScale || .001 )
		}, l.render = function( t, e, i )
		{
			this._gc && this._enabled( !0, !1 );
			var s, n, h, l, _, u, c = this._dirty ? this.totalDuration() : this._totalDuration, f = this._duration, p = this._time, m = this._totalTime, d = this._startTime, g = this._timeScale, v = this._rawPrevTime, y = this._paused, T = this._cycle;
			if( t >= c )this._locked || (this._totalTime = c, this._cycle = this._repeat), this._reversed || this._hasPausedChild() || (n = !0, l = "onComplete", _ = !!this._timeline.autoRemoveChildren, 0 === this._duration && (0 === t || 0 > v || v === r) && v !== t && this._first && (_ = !0, v > r && (l = "onReverseComplete"))), this._rawPrevTime = this._duration || !e || t || this._rawPrevTime === t ? t : r, this._yoyo && 0 !== (1 & this._cycle) ? this._time = t = 0 : (this._time = f, t = f + 1e-4);
			else
				if( 1e-7 > t )if( this._locked || (this._totalTime = this._cycle = 0), this._time = 0, (0 !== p || 0 === f && v !== r && (v > 0 || 0 > t && v >= 0) && !this._locked) && (l = "onReverseComplete", n = this._reversed), 0 > t )this._active = !1, this._timeline.autoRemoveChildren && this._reversed ? (_ = n = !0, l = "onReverseComplete") : v >= 0 && this._first && (_ = !0), this._rawPrevTime = t;
				else
				{
					if( this._rawPrevTime = f || !e || t || this._rawPrevTime === t ? t : r, 0 === t && n )for( s = this._first; s && 0 === s._startTime; )s._duration || (n = !1), s = s._next;
					t = 0, this._initted || (_ = !0)
				}
				else 0 === f && 0 > v && (_ = !0), this._time = this._rawPrevTime = t, this._locked || (this._totalTime = t, 0 !== this._repeat && (u = f + this._repeatDelay, this._cycle = this._totalTime / u >> 0, 0 !== this._cycle && this._cycle === this._totalTime / u && this._cycle--, this._time = this._totalTime - this._cycle * u, this._yoyo && 0 !== (1 & this._cycle) && (this._time = f - this._time), this._time > f ? (this._time = f, t = f + 1e-4) : 0 > this._time ? this._time = t = 0 : t = this._time));
			if( this._cycle !== T && !this._locked )
			{
				var x = this._yoyo && 0 !== (1 & T), w = x === (this._yoyo && 0 !== (1 & this._cycle)), b = this._totalTime, P = this._cycle, k = this._rawPrevTime, S = this._time;
				if( this._totalTime = T * f, T > this._cycle ? x = !x : this._totalTime += f, this._time = p, this._rawPrevTime = 0 === f ? v - 1e-4 : v, this._cycle = T, this._locked = !0, p = x ? 0 : f, this.render( p, e, 0 === f ), e || this._gc || this.vars.onRepeat && this._callback( "onRepeat" ), w && (p = x ? f + 1e-4 : -1e-4, this.render( p, !0, !1 )), this._locked = !1, this._paused && !y )return;
				this._time = S, this._totalTime = b, this._cycle = P, this._rawPrevTime = k
			}
			if( !(this._time !== p && this._first || i || _) )return m !== this._totalTime && this._onUpdate && (e || this._callback( "onUpdate" )), void 0;
			if( this._initted || (this._initted = !0), this._active || !this._paused && this._totalTime !== m && t > 0 && (this._active = !0), 0 === m && this.vars.onStart && 0 !== this._totalTime && (e || this._callback( "onStart" )), this._time >= p )for( s = this._first; s && (h = s._next, !this._paused || y); )(s._active || s._startTime <= this._time && !s._paused && !s._gc) && (s._reversed ? s.render( (s._dirty ? s.totalDuration() : s._totalDuration) - (t - s._startTime) * s._timeScale, e, i ) : s.render( (t - s._startTime) * s._timeScale, e, i )), s = h;
			else for( s = this._last; s && (h = s._prev, !this._paused || y); )(s._active || p >= s._startTime && !s._paused && !s._gc) && (s._reversed ? s.render( (s._dirty ? s.totalDuration() : s._totalDuration) - (t - s._startTime) * s._timeScale, e, i ) : s.render( (t - s._startTime) * s._timeScale, e, i )), s = h;
			this._onUpdate && (e || (a.length && o(), this._callback( "onUpdate" ))), l && (this._locked || this._gc || (d === this._startTime || g !== this._timeScale) && (0 === this._time || c >= this.totalDuration()) && (n && (a.length && o(), this._timeline.autoRemoveChildren && this._enabled( !1, !1 ), this._active = !1), !e && this.vars[ l ] && this._callback( l )))
		}, l.getActive = function( t, e, i )
		{
			null == t && (t = !0), null == e && (e = !0), null == i && (i = !1);
			var s, r, n = [], a = this.getChildren( t, e, i ), o = 0, h = a.length;
			for( s = 0; h > s; s++ )r = a[ s ], r.isActive() && (n[ o++ ] = r);
			return n
		}, l.getLabelAfter = function( t )
		{
			t || 0 !== t && (t = this._time);
			var e, i = this.getLabelsArray(), s = i.length;
			for( e = 0; s > e; e++ )if( i[ e ].time > t )return i[ e ].name;
			return null
		}, l.getLabelBefore = function( t )
		{
			null == t && (t = this._time);
			for( var e = this.getLabelsArray(), i = e.length; --i > -1; )if( t > e[ i ].time )return e[ i ].name;
			return null
		}, l.getLabelsArray = function()
		{
			var t, e = [], i = 0;
			for( t in this._labels )e[ i++ ] = { time: this._labels[ t ], name: t };
			return e.sort( function( t, e )
			{
				return t.time - e.time
			} ), e
		}, l.progress = function( t, e )
		{
			return arguments.length ? this.totalTime( this.duration() * (this._yoyo && 0 !== (1 & this._cycle) ? 1 - t : t) + this._cycle * (this._duration + this._repeatDelay), e ) : this._time / this.duration()
		}, l.totalProgress = function( t, e )
		{
			return arguments.length ? this.totalTime( this.totalDuration() * t, e ) : this._totalTime / this.totalDuration()
		}, l.totalDuration = function( e )
		{
			return arguments.length ? -1 === this._repeat ? this : this.duration( (e - this._repeat * this._repeatDelay) / (this._repeat + 1) ) : (this._dirty && (t.prototype.totalDuration.call( this ), this._totalDuration = -1 === this._repeat ? 999999999999 : this._duration * (this._repeat + 1) + this._repeatDelay * this._repeat), this._totalDuration)
		}, l.time = function( t, e )
		{
			return arguments.length ? (this._dirty && this.totalDuration(), t > this._duration && (t = this._duration), this._yoyo && 0 !== (1 & this._cycle) ? t = this._duration - t + this._cycle * (this._duration + this._repeatDelay) : 0 !== this._repeat && (t += this._cycle * (this._duration + this._repeatDelay)), this.totalTime( t, e )) : this._time
		}, l.repeat = function( t )
		{
			return arguments.length ? (this._repeat = t, this._uncache( !0 )) : this._repeat
		}, l.repeatDelay = function( t )
		{
			return arguments.length ? (this._repeatDelay = t, this._uncache( !0 )) : this._repeatDelay
		}, l.yoyo = function( t )
		{
			return arguments.length ? (this._yoyo = t, this) : this._yoyo
		}, l.currentLabel = function( t )
		{
			return arguments.length ? this.seek( t, !0 ) : this.getLabelBefore( this._time + 1e-8 )
		}, s
	}, !0 ), function()
	{
		var t = 180 / Math.PI, e = [], i = [], s = [], r = {}, n = _gsScope._gsDefine.globals, a = function( t, e, i, s )
		{
			this.a = t, this.b = e, this.c = i, this.d = s, this.da = s - t, this.ca = i - t, this.ba = e - t
		}, o = ",x,y,z,left,top,right,bottom,marginTop,marginLeft,marginRight,marginBottom,paddingLeft,paddingTop,paddingRight,paddingBottom,backgroundPosition,backgroundPosition_y,", h = function( t, e, i, s )
		{
			var r = { a: t }, n = {}, a = {}, o = { c: s }, h = (t + e) / 2, l = (e + i) / 2, _ = (i + s) / 2, u = (h + l) / 2, c = (l + _) / 2, f = (c - u) / 8;
			return r.b = h + (t - h) / 4, n.b = u + f, r.c = n.a = (r.b + n.b) / 2, n.c = a.a = (u + c) / 2, a.b = c - f, o.b = _ + (s - _) / 4, a.c = o.a = (a.b + o.b) / 2, [ r, n, a, o ]
		}, l = function( t, r, n, a, o )
		{
			var l, _, u, c, f, p, m, d, g, v, y, T, x, w = t.length - 1, b = 0, P = t[ 0 ].a;
			for( l = 0; w > l; l++ )f = t[ b ], _ = f.a, u = f.d, c = t[ b + 1 ].d, o ? (y = e[ l ], T = i[ l ], x = .25 * (T + y) * r / (a ? .5 : s[ l ] || .5), p = u - (u - _) * (a ? .5 * r : 0 !== y ? x / y : 0), m = u + (c - u) * (a ? .5 * r : 0 !== T ? x / T : 0), d = u - (p + ((m - p) * (3 * y / (y + T) + .5) / 4 || 0))) : (p = u - .5 * (u - _) * r, m = u + .5 * (c - u) * r, d = u - (p + m) / 2), p += d, m += d, f.c = g = p, f.b = 0 !== l ? P : P = f.a + .6 * (f.c - f.a), f.da = u - _, f.ca = g - _, f.ba = P - _, n ? (v = h( _, P, g, u ), t.splice( b, 1, v[ 0 ], v[ 1 ], v[ 2 ], v[ 3 ] ), b += 4) : b++, P = m;
			f = t[ b ], f.b = P, f.c = P + .4 * (f.d - P), f.da = f.d - f.a, f.ca = f.c - f.a, f.ba = P - f.a, n && (v = h( f.a, P, f.c, f.d ), t.splice( b, 1, v[ 0 ], v[ 1 ], v[ 2 ], v[ 3 ] ))
		}, _ = function( t, s, r, n )
		{
			var o, h, l, _, u, c, f = [];
			if( n )for( t = [ n ].concat( t ), h = t.length; --h > -1; )"string" == typeof(c = t[ h ][ s ]) && "=" === c.charAt( 1 ) && (t[ h ][ s ] = n[ s ] + Number( c.charAt( 0 ) + c.substr( 2 ) ));
			if( o = t.length - 2, 0 > o )return f[ 0 ] = new a( t[ 0 ][ s ], 0, 0, t[ -1 > o ? 0 : 1 ][ s ] ), f;
			for( h = 0; o > h; h++ )l = t[ h ][ s ], _ = t[ h + 1 ][ s ], f[ h ] = new a( l, 0, 0, _ ), r && (u = t[ h + 2 ][ s ], e[ h ] = (e[ h ] || 0) + (_ - l) * (_ - l), i[ h ] = (i[ h ] || 0) + (u - _) * (u - _));
			return f[ h ] = new a( t[ h ][ s ], 0, 0, t[ h + 1 ][ s ] ), f
		}, u = function( t, n, a, h, u, c )
		{
			var f, p, m, d, g, v, y, T, x = {}, w = [], b = c || t[ 0 ];
			u = "string" == typeof u ? "," + u + "," : o, null == n && (n = 1);
			for( p in t[ 0 ] )w.push( p );
			if( t.length > 1 )
			{
				for( T = t[ t.length - 1 ], y = !0, f = w.length; --f > -1; )if( p = w[ f ], Math.abs( b[ p ] - T[ p ] ) > .05 )
				{
					y = !1;
					break
				}
				y && (t = t.concat(), c && t.unshift( c ), t.push( t[ 1 ] ), c = t[ t.length - 3 ])
			}
			for( e.length = i.length = s.length = 0, f = w.length; --f > -1; )p = w[ f ], r[ p ] = -1 !== u.indexOf( "," + p + "," ), x[ p ] = _( t, p, r[ p ], c );
			for( f = e.length; --f > -1; )e[ f ] = Math.sqrt( e[ f ] ), i[ f ] = Math.sqrt( i[ f ] );
			if( !h )
			{
				for( f = w.length; --f > -1; )if( r[ p ] )for( m = x[ w[ f ] ], v = m.length - 1, d = 0; v > d; d++ )g = m[ d + 1 ].da / i[ d ] + m[ d ].da / e[ d ], s[ d ] = (s[ d ] || 0) + g * g;
				for( f = s.length; --f > -1; )s[ f ] = Math.sqrt( s[ f ] )
			}
			for( f = w.length, d = a ? 4 : 1; --f > -1; )p = w[ f ], m = x[ p ], l( m, n, a, h, r[ p ] ), y && (m.splice( 0, d ), m.splice( m.length - d, d ));
			return x
		}, c = function( t, e, i )
		{
			e = e || "soft";
			var s, r, n, o, h, l, _, u, c, f, p, m = {}, d = "cubic" === e ? 3 : 2, g = "soft" === e, v = [];
			if( g && i && (t = [ i ].concat( t )), null == t || d + 1 > t.length )throw"invalid Bezier data";
			for( c in t[ 0 ] )v.push( c );
			for( l = v.length; --l > -1; )
			{
				for( c = v[ l ], m[ c ] = h = [], f = 0, u = t.length, _ = 0; u > _; _++ )s = null == i ? t[ _ ][ c ] : "string" == typeof(p = t[ _ ][ c ]) && "=" === p.charAt( 1 ) ? i[ c ] + Number( p.charAt( 0 ) + p.substr( 2 ) ) : Number( p ), g && _ > 1 && u - 1 > _ && (h[ f++ ] = (s + h[ f - 2 ]) / 2), h[ f++ ] = s;
				for( u = f - d + 1, f = 0, _ = 0; u > _; _ += d )s = h[ _ ], r = h[ _ + 1 ], n = h[ _ + 2 ], o = 2 === d ? 0 : h[ _ + 3 ], h[ f++ ] = p = 3 === d ? new a( s, r, n, o ) : new a( s, (2 * r + s) / 3, (2 * r + n) / 3, n );
				h.length = f
			}
			return m
		}, f = function( t, e, i )
		{
			for( var s, r, n, a, o, h, l, _, u, c, f, p = 1 / i, m = t.length; --m > -1; )for( c = t[ m ], n = c.a, a = c.d - n, o = c.c - n, h = c.b - n, s = r = 0, _ = 1; i >= _; _++ )l = p * _, u = 1 - l, s = r - (r = (l * l * a + 3 * u * (l * o + u * h)) * l), f = m * i + _ - 1, e[ f ] = (e[ f ] || 0) + s * s
		}, p = function( t, e )
		{
			e = e >> 0 || 6;
			var i, s, r, n, a = [], o = [], h = 0, l = 0, _ = e - 1, u = [], c = [];
			for( i in t )f( t[ i ], a, e );
			for( r = a.length, s = 0; r > s; s++ )h += Math.sqrt( a[ s ] ), n = s % e, c[ n ] = h, n === _ && (l += h, n = s / e >> 0, u[ n ] = c, o[ n ] = l, h = 0, c = []);
			return { length: l, lengths: o, segments: u }
		}, m = _gsScope._gsDefine.plugin( {
			propName: "bezier", priority: -1, version: "1.3.4", API: 2, global: !0, init: function( t, e, i )
			{
				this._target = t, e instanceof Array && (e = { values: e }), this._func = {}, this._round = {}, this._props = [], this._timeRes = null == e.timeResolution ? 6 : parseInt( e.timeResolution, 10 );
				var s, r, n, a, o, h = e.values || [], l = {}, _ = h[ 0 ], f = e.autoRotate || i.vars.orientToBezier;
				this._autoRotate = f ? f instanceof Array ? f : [ [ "x", "y", "rotation", f === !0 ? 0 : Number( f ) || 0 ] ] : null;
				for( s in _ )this._props.push( s );
				for( n = this._props.length; --n > -1; )s = this._props[ n ], this._overwriteProps.push( s ), r = this._func[ s ] = "function" == typeof t[ s ], l[ s ] = r ? t[ s.indexOf( "set" ) || "function" != typeof t[ "get" + s.substr( 3 ) ] ? s : "get" + s.substr( 3 ) ]() : parseFloat( t[ s ] ), o || l[ s ] !== h[ 0 ][ s ] && (o = l);
				if( this._beziers = "cubic" !== e.type && "quadratic" !== e.type && "soft" !== e.type ? u( h, isNaN( e.curviness ) ? 1 : e.curviness, !1, "thruBasic" === e.type, e.correlate, o ) : c( h, e.type, l ), this._segCount = this._beziers[ s ].length, this._timeRes )
				{
					var m = p( this._beziers, this._timeRes );
					this._length = m.length, this._lengths = m.lengths, this._segments = m.segments, this._l1 = this._li = this._s1 = this._si = 0, this._l2 = this._lengths[ 0 ], this._curSeg = this._segments[ 0 ], this._s2 = this._curSeg[ 0 ], this._prec = 1 / this._curSeg.length
				}
				if( f = this._autoRotate )for( this._initialRotations = [], f[ 0 ] instanceof Array || (this._autoRotate = f = [ f ]), n = f.length; --n > -1; )
				{
					for( a = 0; 3 > a; a++ )s = f[ n ][ a ], this._func[ s ] = "function" == typeof t[ s ] ? t[ s.indexOf( "set" ) || "function" != typeof t[ "get" + s.substr( 3 ) ] ? s : "get" + s.substr( 3 ) ] : !1;
					s = f[ n ][ 2 ], this._initialRotations[ n ] = this._func[ s ] ? this._func[ s ].call( this._target ) : this._target[ s ]
				}
				return this._startRatio = i.vars.runBackwards ? 1 : 0, !0
			}, set: function( e )
			{
				var i, s, r, n, a, o, h, l, _, u, c = this._segCount, f = this._func, p = this._target, m = e !== this._startRatio;
				if( this._timeRes )
				{
					if( _ = this._lengths, u = this._curSeg, e *= this._length, r = this._li, e > this._l2 && c - 1 > r )
					{
						for( l = c - 1; l > r && e >= (this._l2 = _[ ++r ]); );
						this._l1 = _[ r - 1 ], this._li = r, this._curSeg = u = this._segments[ r ], this._s2 = u[ this._s1 = this._si = 0 ]
					}
					else
						if( this._l1 > e && r > 0 )
						{
							for( ; r > 0 && (this._l1 = _[ --r ]) >= e; );
							0 === r && this._l1 > e ? this._l1 = 0 : r++, this._l2 = _[ r ], this._li = r, this._curSeg = u = this._segments[ r ], this._s1 = u[ (this._si = u.length - 1) - 1 ] || 0, this._s2 = u[ this._si ]
						}
					if( i = r, e -= this._l1, r = this._si, e > this._s2 && u.length - 1 > r )
					{
						for( l = u.length - 1; l > r && e >= (this._s2 = u[ ++r ]); );
						this._s1 = u[ r - 1 ], this._si = r
					}
					else
						if( this._s1 > e && r > 0 )
						{
							for( ; r > 0 && (this._s1 = u[ --r ]) >= e; );
							0 === r && this._s1 > e ? this._s1 = 0 : r++, this._s2 = u[ r ], this._si = r
						}
					o = (r + (e - this._s1) / (this._s2 - this._s1)) * this._prec
				}
				else i = 0 > e ? 0 : e >= 1 ? c - 1 : c * e >> 0, o = (e - i * (1 / c)) * c;
				for( s = 1 - o, r = this._props.length; --r > -1; )n = this._props[ r ], a = this._beziers[ n ][ i ], h = (o * o * a.da + 3 * s * (o * a.ca + s * a.ba)) * o + a.a, this._round[ n ] && (h = Math.round( h )), f[ n ] ? p[ n ]( h ) : p[ n ] = h;
				if( this._autoRotate )
				{
					var d, g, v, y, T, x, w, b = this._autoRotate;
					for( r = b.length; --r > -1; )n = b[ r ][ 2 ], x = b[ r ][ 3 ] || 0, w = b[ r ][ 4 ] === !0 ? 1 : t, a = this._beziers[ b[ r ][ 0 ] ], d = this._beziers[ b[ r ][ 1 ] ], a && d && (a = a[ i ], d = d[ i ], g = a.a + (a.b - a.a) * o, y = a.b + (a.c - a.b) * o, g += (y - g) * o, y += (a.c + (a.d - a.c) * o - y) * o, v = d.a + (d.b - d.a) * o, T = d.b + (d.c - d.b) * o, v += (T - v) * o, T += (d.c + (d.d - d.c) * o - T) * o, h = m ? Math.atan2( T - v, y - g ) * w + x : this._initialRotations[ r ], f[ n ] ? p[ n ]( h ) : p[ n ] = h)
				}
			}
		} ), d = m.prototype;
		m.bezierThrough = u, m.cubicToQuadratic = h, m._autoCSS = !0, m.quadraticToCubic = function( t, e, i )
		{
			return new a( t, (2 * e + t) / 3, (2 * e + i) / 3, i )
		}, m._cssRegister = function()
		{
			var t = n.CSSPlugin;
			if( t )
			{
				var e = t._internals, i = e._parseToProxy, s = e._setPluginRatio, r = e.CSSPropTween;
				e._registerComplexSpecialProp( "bezier", {
					parser: function( t, e, n, a, o, h )
					{
						e instanceof Array && (e = { values: e }), h = new m;
						var l, _, u, c = e.values, f = c.length - 1, p = [], d = {};
						if( 0 > f )return o;
						for( l = 0; f >= l; l++ )u = i( t, c[ l ], a, o, h, f !== l ), p[ l ] = u.end;
						for( _ in e )d[ _ ] = e[ _ ];
						return d.values = p, o = new r( t, "bezier", 0, 0, u.pt, 2 ), o.data = u, o.plugin = h, o.setRatio = s, 0 === d.autoRotate && (d.autoRotate = !0), !d.autoRotate || d.autoRotate instanceof Array || (l = d.autoRotate === !0 ? 0 : Number( d.autoRotate ), d.autoRotate = null != u.end.left ? [ [ "left", "top", "rotation", l, !1 ] ] : null != u.end.x ? [ [ "x", "y", "rotation", l, !1 ] ] : !1), d.autoRotate && (a._transform || a._enableTransforms( !1 ), u.autoRotate = a._target._gsTransform), h._onInitTween( u.proxy, d, a._tween ), o
					}
				} )
			}
		}, d._roundProps = function( t, e )
		{
			for( var i = this._overwriteProps, s = i.length; --s > -1; )(t[ i[ s ] ] || t.bezier || t.bezierThrough) && (this._round[ i[ s ] ] = e)
		}, d._kill = function( t )
		{
			var e, i, s = this._props;
			for( e in this._beziers )if( e in t )for( delete this._beziers[ e ], delete this._func[ e ], i = s.length; --i > -1; )s[ i ] === e && s.splice( i, 1 );
			return this._super._kill.call( this, t )
		}
	}(), _gsScope._gsDefine( "plugins.CSSPlugin", [ "plugins.TweenPlugin", "TweenLite" ], function( t, e )
	{
		var i, s, r, n, a = function()
		{
			t.call( this, "css" ), this._overwriteProps.length = 0, this.setRatio = a.prototype.setRatio
		}, o = _gsScope._gsDefine.globals, h = {}, l = a.prototype = new t( "css" );
		l.constructor = a, a.version = "1.17.0", a.API = 2, a.defaultTransformPerspective = 0, a.defaultSkewType = "compensated", a.defaultSmoothOrigin = !0, l = "px", a.suffixMap = {
			top: l,
			right: l,
			bottom: l,
			left: l,
			width: l,
			height: l,
			fontSize: l,
			padding: l,
			margin: l,
			perspective: l,
			lineHeight: ""
		};
		var _, u, c, f, p, m, d = /(?:\d|\-\d|\.\d|\-\.\d)+/g, g = /(?:\d|\-\d|\.\d|\-\.\d|\+=\d|\-=\d|\+=.\d|\-=\.\d)+/g, v = /(?:\+=|\-=|\-|\b)[\d\-\.]+[a-zA-Z0-9]*(?:%|\b)/gi, y = /(?![+-]?\d*\.?\d+|[+-]|e[+-]\d+)[^0-9]/g, T = /(?:\d|\-|\+|=|#|\.)*/g, x = /opacity *= *([^)]*)/i, w = /opacity:([^;]*)/i, b = /alpha\(opacity *=.+?\)/i, P = /^(rgb|hsl)/, k = /([A-Z])/g, S = /-([a-z])/gi, R = /(^(?:url\(\"|url\())|(?:(\"\))$|\)$)/gi, O = function( t, e )
		{
			return e.toUpperCase()
		}, A = /(?:Left|Right|Width)/i, C = /(M11|M12|M21|M22)=[\d\-\.e]+/gi, D = /progid\:DXImageTransform\.Microsoft\.Matrix\(.+?\)/i, M = /,(?=[^\)]*(?:\(|$))/gi, z = Math.PI / 180, I = 180 / Math.PI, F = {}, N = document, E = function( t )
		{
			return N.createElementNS ? N.createElementNS( "http://www.w3.org/1999/xhtml", t ) : N.createElement( t )
		}, L = E( "div" ), X = E( "img" ), B = a._internals = { _specialProps: h }, Y = navigator.userAgent, j = function()
		{
			var t = Y.indexOf( "Android" ), e = E( "a" );
			return c = -1 !== Y.indexOf( "Safari" ) && -1 === Y.indexOf( "Chrome" ) && (-1 === t || Number( Y.substr( t + 8, 1 ) ) > 3), p = c && 6 > Number( Y.substr( Y.indexOf( "Version/" ) + 8, 1 ) ), f = -1 !== Y.indexOf( "Firefox" ), (/MSIE ([0-9]{1,}[\.0-9]{0,})/.exec( Y ) || /Trident\/.*rv:([0-9]{1,}[\.0-9]{0,})/.exec( Y )) && (m = parseFloat( RegExp.$1 )), e ? (e.style.cssText = "top:1px;opacity:.55;", /^0.55/.test( e.style.opacity )) : !1
		}(), U = function( t )
		{
			return x.test( "string" == typeof t ? t : (t.currentStyle ? t.currentStyle.filter : t.style.filter) || "" ) ? parseFloat( RegExp.$1 ) / 100 : 1
		}, q = function( t )
		{
			window.console && console.log( t )
		}, V = "", G = "", W = function( t, e )
		{
			e = e || L;
			var i, s, r = e.style;
			if( void 0 !== r[ t ] )return t;
			for( t = t.charAt( 0 ).toUpperCase() + t.substr( 1 ), i = [ "O", "Moz", "ms", "Ms", "Webkit" ], s = 5; --s > -1 && void 0 === r[ i[ s ] + t ]; );
			return s >= 0 ? (G = 3 === s ? "ms" : i[ s ], V = "-" + G.toLowerCase() + "-", G + t) : null
		}, Z = N.defaultView ? N.defaultView.getComputedStyle : function()
		{
		}, Q = a.getStyle = function( t, e, i, s, r )
		{
			var n;
			return j || "opacity" !== e ? (!s && t.style[ e ] ? n = t.style[ e ] : (i = i || Z( t )) ? n = i[ e ] || i.getPropertyValue( e ) || i.getPropertyValue( e.replace( k, "-$1" ).toLowerCase() ) : t.currentStyle && (n = t.currentStyle[ e ]), null == r || n && "none" !== n && "auto" !== n && "auto auto" !== n ? n : r) : U( t )
		}, $ = B.convertToPixels = function( t, i, s, r, n )
		{
			if( "px" === r || !r )return s;
			if( "auto" === r || !s )return 0;
			var o, h, l, _ = A.test( i ), u = t, c = L.style, f = 0 > s;
			if( f && (s = -s), "%" === r && -1 !== i.indexOf( "border" ) )o = s / 100 * (_ ? t.clientWidth : t.clientHeight);
			else
			{
				if( c.cssText = "border:0 solid red;position:" + Q( t, "position" ) + ";line-height:0;", "%" !== r && u.appendChild )c[ _ ? "borderLeftWidth" : "borderTopWidth" ] = s + r;
				else
				{
					if( u = t.parentNode || N.body, h = u._gsCache, l = e.ticker.frame, h && _ && h.time === l )return h.width * s / 100;
					c[ _ ? "width" : "height" ] = s + r
				}
				u.appendChild( L ), o = parseFloat( L[ _ ? "offsetWidth" : "offsetHeight" ] ), u.removeChild( L ), _ && "%" === r && a.cacheWidths !== !1 && (h = u._gsCache = u._gsCache || {}, h.time = l, h.width = 100 * (o / s)), 0 !== o || n || (o = $( t, i, s, r, !0 ))
			}
			return f ? -o : o
		}, H = B.calculateOffset = function( t, e, i )
		{
			if( "absolute" !== Q( t, "position", i ) )return 0;
			var s = "left" === e ? "Left" : "Top", r = Q( t, "margin" + s, i );
			return t[ "offset" + s ] - ($( t, e, parseFloat( r ), r.replace( T, "" ) ) || 0)
		}, K = function( t, e )
		{
			var i, s, r, n = {};
			if( e = e || Z( t, null ) )if( i = e.length )for( ; --i > -1; )r = e[ i ], (-1 === r.indexOf( "-transform" ) || Pe === r) && (n[ r.replace( S, O ) ] = e.getPropertyValue( r ));
			else for( i in e )(-1 === i.indexOf( "Transform" ) || be === i) && (n[ i ] = e[ i ]);
			else
				if( e = t.currentStyle || t.style )for( i in e )"string" == typeof i && void 0 === n[ i ] && (n[ i.replace( S, O ) ] = e[ i ]);
			return j || (n.opacity = U( t )), s = Ne( t, e, !1 ), n.rotation = s.rotation, n.skewX = s.skewX, n.scaleX = s.scaleX, n.scaleY = s.scaleY, n.x = s.x, n.y = s.y, Se && (n.z = s.z, n.rotationX = s.rotationX, n.rotationY = s.rotationY, n.scaleZ = s.scaleZ), n.filters && delete n.filters, n
		}, J = function( t, e, i, s, r )
		{
			var n, a, o, h = {}, l = t.style;
			for( a in i )"cssText" !== a && "length" !== a && isNaN( a ) && (e[ a ] !== (n = i[ a ]) || r && r[ a ]) && -1 === a.indexOf( "Origin" ) && ("number" == typeof n || "string" == typeof n) && (h[ a ] = "auto" !== n || "left" !== a && "top" !== a ? "" !== n && "auto" !== n && "none" !== n || "string" != typeof e[ a ] || "" === e[ a ].replace( y, "" ) ? n : 0 : H( t, a ), void 0 !== l[ a ] && (o = new fe( l, a, l[ a ], o )));
			if( s )for( a in s )"className" !== a && (h[ a ] = s[ a ]);
			return { difs: h, firstMPT: o }
		}, te = {
			width: [ "Left", "Right" ],
			height: [ "Top", "Bottom" ]
		}, ee = [ "marginLeft", "marginRight", "marginTop", "marginBottom" ], ie = function( t, e, i )
		{
			var s = parseFloat( "width" === e ? t.offsetWidth : t.offsetHeight ), r = te[ e ], n = r.length;
			for( i = i || Z( t, null ); --n > -1; )s -= parseFloat( Q( t, "padding" + r[ n ], i, !0 ) ) || 0, s -= parseFloat( Q( t, "border" + r[ n ] + "Width", i, !0 ) ) || 0;
			return s
		}, se = function( t, e )
		{
			(null == t || "" === t || "auto" === t || "auto auto" === t) && (t = "0 0");
			var i = t.split( " " ), s = -1 !== t.indexOf( "left" ) ? "0%" : -1 !== t.indexOf( "right" ) ? "100%" : i[ 0 ], r = -1 !== t.indexOf( "top" ) ? "0%" : -1 !== t.indexOf( "bottom" ) ? "100%" : i[ 1 ];
			return null == r ? r = "center" === s ? "50%" : "0" : "center" === r && (r = "50%"), ("center" === s || isNaN( parseFloat( s ) ) && -1 === (s + "").indexOf( "=" )) && (s = "50%"), t = s + " " + r + (i.length > 2 ? " " + i[ 2 ] : ""), e && (e.oxp = -1 !== s.indexOf( "%" ), e.oyp = -1 !== r.indexOf( "%" ), e.oxr = "=" === s.charAt( 1 ), e.oyr = "=" === r.charAt( 1 ), e.ox = parseFloat( s.replace( y, "" ) ), e.oy = parseFloat( r.replace( y, "" ) ), e.v = t), e || t
		}, re = function( t, e )
		{
			return "string" == typeof t && "=" === t.charAt( 1 ) ? parseInt( t.charAt( 0 ) + "1", 10 ) * parseFloat( t.substr( 2 ) ) : parseFloat( t ) - parseFloat( e )
		}, ne = function( t, e )
		{
			return null == t ? e : "string" == typeof t && "=" === t.charAt( 1 ) ? parseInt( t.charAt( 0 ) + "1", 10 ) * parseFloat( t.substr( 2 ) ) + e : parseFloat( t )
		}, ae = function( t, e, i, s )
		{
			var r, n, a, o, h, l = 1e-6;
			return null == t ? o = e : "number" == typeof t ? o = t : (r = 360, n = t.split( "_" ), h = "=" === t.charAt( 1 ), a = (h ? parseInt( t.charAt( 0 ) + "1", 10 ) * parseFloat( n[ 0 ].substr( 2 ) ) : parseFloat( n[ 0 ] )) * (-1 === t.indexOf( "rad" ) ? 1 : I) - (h ? 0 : e), n.length && (s && (s[ i ] = e + a), -1 !== t.indexOf( "short" ) && (a %= r, a !== a % (r / 2) && (a = 0 > a ? a + r : a - r)), -1 !== t.indexOf( "_cw" ) && 0 > a ? a = (a + 9999999999 * r) % r - (0 | a / r) * r : -1 !== t.indexOf( "ccw" ) && a > 0 && (a = (a - 9999999999 * r) % r - (0 | a / r) * r)), o = e + a), l > o && o > -l && (o = 0), o
		}, oe = {
			aqua: [ 0, 255, 255 ],
			lime: [ 0, 255, 0 ],
			silver: [ 192, 192, 192 ],
			black: [ 0, 0, 0 ],
			maroon: [ 128, 0, 0 ],
			teal: [ 0, 128, 128 ],
			blue: [ 0, 0, 255 ],
			navy: [ 0, 0, 128 ],
			white: [ 255, 255, 255 ],
			fuchsia: [ 255, 0, 255 ],
			olive: [ 128, 128, 0 ],
			yellow: [ 255, 255, 0 ],
			orange: [ 255, 165, 0 ],
			gray: [ 128, 128, 128 ],
			purple: [ 128, 0, 128 ],
			green: [ 0, 128, 0 ],
			red: [ 255, 0, 0 ],
			pink: [ 255, 192, 203 ],
			cyan: [ 0, 255, 255 ],
			transparent: [ 255, 255, 255, 0 ]
		}, he = function( t, e, i )
		{
			return t = 0 > t ? t + 1 : t > 1 ? t - 1 : t, 0 | 255 * (1 > 6 * t ? e + 6 * (i - e) * t : .5 > t ? i : 2 > 3 * t ? e + 6 * (i - e) * (2 / 3 - t) : e) + .5
		}, le = a.parseColor = function( t )
		{
			var e, i, s, r, n, a;
			return t && "" !== t ? "number" == typeof t ? [ t >> 16, 255 & t >> 8, 255 & t ] : ("," === t.charAt( t.length - 1 ) && (t = t.substr( 0, t.length - 1 )), oe[ t ] ? oe[ t ] : "#" === t.charAt( 0 ) ? (4 === t.length && (e = t.charAt( 1 ), i = t.charAt( 2 ), s = t.charAt( 3 ), t = "#" + e + e + i + i + s + s), t = parseInt( t.substr( 1 ), 16 ), [ t >> 16, 255 & t >> 8, 255 & t ]) : "hsl" === t.substr( 0, 3 ) ? (t = t.match( d ), r = Number( t[ 0 ] ) % 360 / 360, n = Number( t[ 1 ] ) / 100, a = Number( t[ 2 ] ) / 100, i = .5 >= a ? a * (n + 1) : a + n - a * n, e = 2 * a - i, t.length > 3 && (t[ 3 ] = Number( t[ 3 ] )), t[ 0 ] = he( r + 1 / 3, e, i ), t[ 1 ] = he( r, e, i ), t[ 2 ] = he( r - 1 / 3, e, i ), t) : (t = t.match( d ) || oe.transparent, t[ 0 ] = Number( t[ 0 ] ), t[ 1 ] = Number( t[ 1 ] ), t[ 2 ] = Number( t[ 2 ] ), t.length > 3 && (t[ 3 ] = Number( t[ 3 ] )), t)) : oe.black
		}, _e = "(?:\\b(?:(?:rgb|rgba|hsl|hsla)\\(.+?\\))|\\B#.+?\\b";
		for( l in oe )_e += "|" + l + "\\b";
		_e = RegExp( _e + ")", "gi" );
		var ue = function( t, e, i, s )
		{
			if( null == t )return function( t )
			{
				return t
			};
			var r, n = e ? (t.match( _e ) || [ "" ])[ 0 ] : "", a = t.split( n ).join( "" ).match( v ) || [], o = t.substr( 0, t.indexOf( a[ 0 ] ) ), h = ")" === t.charAt( t.length - 1 ) ? ")" : "", l = -1 !== t.indexOf( " " ) ? " " : ",", _ = a.length, u = _ > 0 ? a[ 0 ].replace( d, "" ) : "";
			return _ ? r = e ? function( t )
			{
				var e, c, f, p;
				if( "number" == typeof t )t += u;
				else
					if( s && M.test( t ) )
					{
						for( p = t.replace( M, "|" ).split( "|" ), f = 0; p.length > f; f++ )p[ f ] = r( p[ f ] );
						return p.join( "," )
					}
				if( e = (t.match( _e ) || [ n ])[ 0 ], c = t.split( e ).join( "" ).match( v ) || [], f = c.length, _ > f-- )for( ; _ > ++f; )c[ f ] = i ? c[ 0 | (f - 1) / 2 ] : a[ f ];
				return o + c.join( l ) + l + e + h + (-1 !== t.indexOf( "inset" ) ? " inset" : "")
			} : function( t )
			{
				var e, n, c;
				if( "number" == typeof t )t += u;
				else
					if( s && M.test( t ) )
					{
						for( n = t.replace( M, "|" ).split( "|" ), c = 0; n.length > c; c++ )n[ c ] = r( n[ c ] );
						return n.join( "," )
					}
				if( e = t.match( v ) || [], c = e.length, _ > c-- )for( ; _ > ++c; )e[ c ] = i ? e[ 0 | (c - 1) / 2 ] : a[ c ];
				return o + e.join( l ) + h
			} : function( t )
			{
				return t
			}
		}, ce = function( t )
		{
			return t = t.split( "," ), function( e, i, s, r, n, a, o )
			{
				var h, l = (i + "").split( " " );
				for( o = {}, h = 0; 4 > h; h++ )o[ t[ h ] ] = l[ h ] = l[ h ] || l[ (h - 1) / 2 >> 0 ];
				return r.parse( e, o, n, a )
			}
		}, fe = (B._setPluginRatio = function( t )
		{
			this.plugin.setRatio( t );
			for( var e, i, s, r, n = this.data, a = n.proxy, o = n.firstMPT, h = 1e-6; o; )e = a[ o.v ], o.r ? e = Math.round( e ) : h > e && e > -h && (e = 0), o.t[ o.p ] = e, o = o._next;
			if( n.autoRotate && (n.autoRotate.rotation = a.rotation), 1 === t )for( o = n.firstMPT; o; )
			{
				if( i = o.t, i.type )
				{
					if( 1 === i.type )
					{
						for( r = i.xs0 + i.s + i.xs1, s = 1; i.l > s; s++ )r += i[ "xn" + s ] + i[ "xs" + (s + 1) ];
						i.e = r
					}
				}
				else i.e = i.s + i.xs0;
				o = o._next
			}
		}, function( t, e, i, s, r )
		{
			this.t = t, this.p = e, this.v = i, this.r = r, s && (s._prev = this, this._next = s)
		}), pe = (B._parseToProxy = function( t, e, i, s, r, n )
		{
			var a, o, h, l, _, u = s, c = {}, f = {}, p = i._transform, m = F;
			for( i._transform = null, F = e, s = _ = i.parse( t, e, s, r ), F = m, n && (i._transform = p, u && (u._prev = null, u._prev && (u._prev._next = null))); s && s !== u; )
			{
				if( 1 >= s.type && (o = s.p, f[ o ] = s.s + s.c, c[ o ] = s.s, n || (l = new fe( s, "s", o, l, s.r ), s.c = 0), 1 === s.type) )for( a = s.l; --a > 0; )h = "xn" + a, o = s.p + "_" + h, f[ o ] = s.data[ h ], c[ o ] = s[ h ], n || (l = new fe( s, h, o, l, s.rxp[ h ] ));
				s = s._next
			}
			return { proxy: c, end: f, firstMPT: l, pt: _ }
		}, B.CSSPropTween = function( t, e, s, r, a, o, h, l, _, u, c )
		{
			this.t = t, this.p = e, this.s = s, this.c = r, this.n = h || e, t instanceof pe || n.push( this.n ), this.r = l, this.type = o || 0, _ && (this.pr = _, i = !0), this.b = void 0 === u ? s : u, this.e = void 0 === c ? s + r : c, a && (this._next = a, a._prev = this)
		}), me = function( t, e, i, s, r, n )
		{
			var a = new pe( t, e, i, s - i, r, -1, n );
			return a.b = i, a.e = a.xs0 = s, a
		}, de = a.parseComplex = function( t, e, i, s, r, n, a, o, h, l )
		{
			i = i || n || "", a = new pe( t, e, 0, 0, a, l ? 2 : 1, null, !1, o, i, s ), s += "";
			var u, c, f, p, m, v, y, T, x, w, b, k, S = i.split( ", " ).join( "," ).split( " " ), R = s.split( ", " ).join( "," ).split( " " ), O = S.length, A = _ !== !1;
			for( (-1 !== s.indexOf( "," ) || -1 !== i.indexOf( "," )) && (S = S.join( " " ).replace( M, ", " ).split( " " ), R = R.join( " " ).replace( M, ", " ).split( " " ), O = S.length), O !== R.length && (S = (n || "").split( " " ), O = S.length), a.plugin = h, a.setRatio = l, u = 0; O > u; u++ )if( p = S[ u ], m = R[ u ], T = parseFloat( p ), T || 0 === T )a.appendXtra( "", T, re( m, T ), m.replace( g, "" ), A && -1 !== m.indexOf( "px" ), !0 );
			else
				if( r && ("#" === p.charAt( 0 ) || oe[ p ] || P.test( p )) )k = "," === m.charAt( m.length - 1 ) ? ")," : ")", p = le( p ), m = le( m ), x = p.length + m.length > 6, x && !j && 0 === m[ 3 ] ? (a[ "xs" + a.l ] += a.l ? " transparent" : "transparent", a.e = a.e.split( R[ u ] ).join( "transparent" )) : (j || (x = !1), a.appendXtra( x ? "rgba(" : "rgb(", p[ 0 ], m[ 0 ] - p[ 0 ], ",", !0, !0 ).appendXtra( "", p[ 1 ], m[ 1 ] - p[ 1 ], ",", !0 ).appendXtra( "", p[ 2 ], m[ 2 ] - p[ 2 ], x ? "," : k, !0 ), x && (p = 4 > p.length ? 1 : p[ 3 ], a.appendXtra( "", p, (4 > m.length ? 1 : m[ 3 ]) - p, k, !1 )));
				else
					if( v = p.match( d ) )
					{
						if( y = m.match( g ), !y || y.length !== v.length )return a;
						for( f = 0, c = 0; v.length > c; c++ )b = v[ c ], w = p.indexOf( b, f ), a.appendXtra( p.substr( f, w - f ), Number( b ), re( y[ c ], b ), "", A && "px" === p.substr( w + b.length, 2 ), 0 === c ), f = w + b.length;
						a[ "xs" + a.l ] += p.substr( f )
					}
					else a[ "xs" + a.l ] += a.l ? " " + p : p;
			if( -1 !== s.indexOf( "=" ) && a.data )
			{
				for( k = a.xs0 + a.data.s, u = 1; a.l > u; u++ )k += a[ "xs" + u ] + a.data[ "xn" + u ];
				a.e = k + a[ "xs" + u ]
			}
			return a.l || (a.type = -1, a.xs0 = a.e), a.xfirst || a
		}, ge = 9;
		for( l = pe.prototype, l.l = l.pr = 0; --ge > 0; )l[ "xn" + ge ] = 0, l[ "xs" + ge ] = "";
		l.xs0 = "", l._next = l._prev = l.xfirst = l.data = l.plugin = l.setRatio = l.rxp = null, l.appendXtra = function( t, e, i, s, r, n )
		{
			var a = this, o = a.l;
			return a[ "xs" + o ] += n && o ? " " + t : t || "", i || 0 === o || a.plugin ? (a.l++, a.type = a.setRatio ? 2 : 1, a[ "xs" + a.l ] = s || "", o > 0 ? (a.data[ "xn" + o ] = e + i, a.rxp[ "xn" + o ] = r, a[ "xn" + o ] = e, a.plugin || (a.xfirst = new pe( a, "xn" + o, e, i, a.xfirst || a, 0, a.n, r, a.pr ), a.xfirst.xs0 = 0), a) : (a.data = { s: e + i }, a.rxp = {}, a.s = e, a.c = i, a.r = r, a)) : (a[ "xs" + o ] += e + (s || ""), a)
		};
		var ve = function( t, e )
		{
			e = e || {}, this.p = e.prefix ? W( t ) || t : t, h[ t ] = h[ this.p ] = this, this.format = e.formatter || ue( e.defaultValue, e.color, e.collapsible, e.multi ), e.parser && (this.parse = e.parser), this.clrs = e.color, this.multi = e.multi, this.keyword = e.keyword, this.dflt = e.defaultValue, this.pr = e.priority || 0
		}, ye = B._registerComplexSpecialProp = function( t, e, i )
		{
			"object" != typeof e && (e = { parser: i });
			var s, r, n = t.split( "," ), a = e.defaultValue;
			for( i = i || [ a ], s = 0; n.length > s; s++ )e.prefix = 0 === s && e.prefix, e.defaultValue = i[ s ] || a, r = new ve( n[ s ], e )
		}, Te = function( t )
		{
			if( !h[ t ] )
			{
				var e = t.charAt( 0 ).toUpperCase() + t.substr( 1 ) + "Plugin";
				ye( t, {
					parser: function( t, i, s, r, n, a, l )
					{
						var _ = o.com.greensock.plugins[ e ];
						return _ ? (_._cssRegister(), h[ s ].parse( t, i, s, r, n, a, l )) : (q( "Error: " + e + " js file not loaded." ), n)
					}
				} )
			}
		};
		l = ve.prototype, l.parseComplex = function( t, e, i, s, r, n )
		{
			var a, o, h, l, _, u, c = this.keyword;
			if( this.multi && (M.test( i ) || M.test( e ) ? (o = e.replace( M, "|" ).split( "|" ), h = i.replace( M, "|" ).split( "|" )) : c && (o = [ e ], h = [ i ])), h )
			{
				for( l = h.length > o.length ? h.length : o.length, a = 0; l > a; a++ )e = o[ a ] = o[ a ] || this.dflt, i = h[ a ] = h[ a ] || this.dflt, c && (_ = e.indexOf( c ), u = i.indexOf( c ), _ !== u && (-1 === u ? o[ a ] = o[ a ].split( c ).join( "" ) : -1 === _ && (o[ a ] += " " + c)));
				e = o.join( ", " ), i = h.join( ", " )
			}
			return de( t, this.p, e, i, this.clrs, this.dflt, s, this.pr, r, n )
		}, l.parse = function( t, e, i, s, n, a )
		{
			return this.parseComplex( t.style, this.format( Q( t, this.p, r, !1, this.dflt ) ), this.format( e ), n, a )
		}, a.registerSpecialProp = function( t, e, i )
		{
			ye( t, {
				parser: function( t, s, r, n, a, o )
				{
					var h = new pe( t, r, 0, 0, a, 2, r, !1, i );
					return h.plugin = o, h.setRatio = e( t, s, n._tween, r ), h
				}, priority: i
			} )
		}, a.useSVGTransformAttr = c || f;
		var xe, we = "scaleX,scaleY,scaleZ,x,y,z,skewX,skewY,rotation,rotationX,rotationY,perspective,xPercent,yPercent".split( "," ), be = W( "transform" ), Pe = V + "transform", ke = W( "transformOrigin" ), Se = null !== W( "perspective" ), Re = B.Transform = function()
		{
			this.perspective = parseFloat( a.defaultTransformPerspective ) || 0, this.force3D = a.defaultForce3D !== !1 && Se ? a.defaultForce3D || "auto" : !1
		}, Oe = window.SVGElement, Ae = function( t, e, i )
		{
			var s, r = N.createElementNS( "http://www.w3.org/2000/svg", t ), n = /([a-z])([A-Z])/g;
			for( s in i )r.setAttributeNS( null, s.replace( n, "$1-$2" ).toLowerCase(), i[ s ] );
			return e.appendChild( r ), r
		}, Ce = N.documentElement, De = function()
		{
			var t, e, i, s = m || /Android/i.test( Y ) && !window.chrome;
			return N.createElementNS && !s && (t = Ae( "svg", Ce ), e = Ae( "rect", t, {
				width: 100,
				height: 50,
				x: 100
			} ), i = e.getBoundingClientRect().width, e.style[ ke ] = "50% 50%", e.style[ be ] = "scaleX(0.5)", s = i === e.getBoundingClientRect().width && !(f && Se), Ce.removeChild( t )), s
		}(), Me = function( t, e, i, s, r )
		{
			var n, o, h, l, _, u, c, f, p, m, d, g, v, y, T = t._gsTransform, x = Fe( t, !0 );
			T && (v = T.xOrigin, y = T.yOrigin), (!s || 2 > (n = s.split( " " )).length) && (c = t.getBBox(), e = se( e ).split( " " ), n = [ (-1 !== e[ 0 ].indexOf( "%" ) ? parseFloat( e[ 0 ] ) / 100 * c.width : parseFloat( e[ 0 ] )) + c.x, (-1 !== e[ 1 ].indexOf( "%" ) ? parseFloat( e[ 1 ] ) / 100 * c.height : parseFloat( e[ 1 ] )) + c.y ]), i.xOrigin = l = parseFloat( n[ 0 ] ), i.yOrigin = _ = parseFloat( n[ 1 ] ), s && x !== Ie && (u = x[ 0 ], c = x[ 1 ], f = x[ 2 ], p = x[ 3 ], m = x[ 4 ], d = x[ 5 ], g = u * p - c * f, o = l * (p / g) + _ * (-f / g) + (f * d - p * m) / g, h = l * (-c / g) + _ * (u / g) - (u * d - c * m) / g, l = i.xOrigin = n[ 0 ] = o, _ = i.yOrigin = n[ 1 ] = h), T && (r || r !== !1 && a.defaultSmoothOrigin !== !1 ? (o = l - v, h = _ - y, T.xOffset += o * x[ 0 ] + h * x[ 2 ] - o, T.yOffset += o * x[ 1 ] + h * x[ 3 ] - h) : T.xOffset = T.yOffset = 0), t.setAttribute( "data-svg-origin", n.join( " " ) )
		}, ze = function( t )
		{
			return !!(Oe && "function" == typeof t.getBBox && t.getCTM && (!t.parentNode || t.parentNode.getBBox && t.parentNode.getCTM))
		}, Ie = [ 1, 0, 0, 1, 0, 0 ], Fe = function( t, e )
		{
			var i, s, r, n, a, o = t._gsTransform || new Re, h = 1e5;
			if( be ? s = Q( t, Pe, null, !0 ) : t.currentStyle && (s = t.currentStyle.filter.match( C ), s = s && 4 === s.length ? [ s[ 0 ].substr( 4 ), Number( s[ 2 ].substr( 4 ) ), Number( s[ 1 ].substr( 4 ) ), s[ 3 ].substr( 4 ), o.x || 0, o.y || 0 ].join( "," ) : ""), i = !s || "none" === s || "matrix(1, 0, 0, 1, 0, 0)" === s, (o.svg || t.getBBox && ze( t )) && (i && -1 !== (t.style[ be ] + "").indexOf( "matrix" ) && (s = t.style[ be ], i = 0), r = t.getAttribute( "transform" ), i && r && (-1 !== r.indexOf( "matrix" ) ? (s = r, i = 0) : -1 !== r.indexOf( "translate" ) && (s = "matrix(1,0,0,1," + r.match( /(?:\-|\b)[\d\-\.e]+\b/gi ).join( "," ) + ")", i = 0))), i )return Ie;
			for( r = (s || "").match( /(?:\-|\b)[\d\-\.e]+\b/gi ) || [], ge = r.length; --ge > -1; )n = Number( r[ ge ] ), r[ ge ] = (a = n - (n |= 0)) ? (0 | a * h + (0 > a ? -.5 : .5)) / h + n : n;
			return e && r.length > 6 ? [ r[ 0 ], r[ 1 ], r[ 4 ], r[ 5 ], r[ 12 ], r[ 13 ] ] : r
		}, Ne = B.getTransform = function( t, i, s, n )
		{
			if( t._gsTransform && s && !n )return t._gsTransform;
			var o, h, l, _, u, c, f = s ? t._gsTransform || new Re : new Re, p = 0 > f.scaleX, m = 2e-5, d = 1e5, g = Se ? parseFloat( Q( t, ke, i, !1, "0 0 0" ).split( " " )[ 2 ] ) || f.zOrigin || 0 : 0, v = parseFloat( a.defaultTransformPerspective ) || 0;
			if( f.svg = !(!t.getBBox || !ze( t )), f.svg && (Me( t, Q( t, ke, r, !1, "50% 50%" ) + "", f, t.getAttribute( "data-svg-origin" ) ), xe = a.useSVGTransformAttr || De), o = Fe( t ), o !== Ie )
			{
				if( 16 === o.length )
				{
					var y, T, x, w, b, P = o[ 0 ], k = o[ 1 ], S = o[ 2 ], R = o[ 3 ], O = o[ 4 ], A = o[ 5 ], C = o[ 6 ], D = o[ 7 ], M = o[ 8 ], z = o[ 9 ], F = o[ 10 ], N = o[ 12 ], E = o[ 13 ], L = o[ 14 ], X = o[ 11 ], B = Math.atan2( C, F );
					f.zOrigin && (L = -f.zOrigin, N = M * L - o[ 12 ], E = z * L - o[ 13 ], L = F * L + f.zOrigin - o[ 14 ]), f.rotationX = B * I, B && (w = Math.cos( -B ), b = Math.sin( -B ), y = O * w + M * b, T = A * w + z * b, x = C * w + F * b, M = O * -b + M * w, z = A * -b + z * w, F = C * -b + F * w, X = D * -b + X * w, O = y, A = T, C = x), B = Math.atan2( M, F ), f.rotationY = B * I, B && (w = Math.cos( -B ), b = Math.sin( -B ), y = P * w - M * b, T = k * w - z * b, x = S * w - F * b, z = k * b + z * w, F = S * b + F * w, X = R * b + X * w, P = y, k = T, S = x), B = Math.atan2( k, P ), f.rotation = B * I, B && (w = Math.cos( -B ), b = Math.sin( -B ), P = P * w + O * b, T = k * w + A * b, A = k * -b + A * w, C = S * -b + C * w, k = T), f.rotationX && Math.abs( f.rotationX ) + Math.abs( f.rotation ) > 359.9 && (f.rotationX = f.rotation = 0, f.rotationY += 180), f.scaleX = (0 | Math.sqrt( P * P + k * k ) * d + .5) / d, f.scaleY = (0 | Math.sqrt( A * A + z * z ) * d + .5) / d, f.scaleZ = (0 | Math.sqrt( C * C + F * F ) * d + .5) / d, f.skewX = 0, f.perspective = X ? 1 / (0 > X ? -X : X) : 0, f.x = N, f.y = E, f.z = L, f.svg && (f.x -= f.xOrigin - (f.xOrigin * P - f.yOrigin * O), f.y -= f.yOrigin - (f.yOrigin * k - f.xOrigin * A))
				}
				else
					if( !(Se && !n && o.length && f.x === o[ 4 ] && f.y === o[ 5 ] && (f.rotationX || f.rotationY) || void 0 !== f.x && "none" === Q( t, "display", i )) )
					{
						var Y = o.length >= 6, j = Y ? o[ 0 ] : 1, U = o[ 1 ] || 0, q = o[ 2 ] || 0, V = Y ? o[ 3 ] : 1;
						f.x = o[ 4 ] || 0, f.y = o[ 5 ] || 0, l = Math.sqrt( j * j + U * U ), _ = Math.sqrt( V * V + q * q ), u = j || U ? Math.atan2( U, j ) * I : f.rotation || 0, c = q || V ? Math.atan2( q, V ) * I + u : f.skewX || 0, Math.abs( c ) > 90 && 270 > Math.abs( c ) && (p ? (l *= -1, c += 0 >= u ? 180 : -180, u += 0 >= u ? 180 : -180) : (_ *= -1, c += 0 >= c ? 180 : -180)), f.scaleX = l, f.scaleY = _, f.rotation = u, f.skewX = c, Se && (f.rotationX = f.rotationY = f.z = 0, f.perspective = v, f.scaleZ = 1), f.svg && (f.x -= f.xOrigin - (f.xOrigin * j + f.yOrigin * q), f.y -= f.yOrigin - (f.xOrigin * U + f.yOrigin * V))
					}
				f.zOrigin = g;
				for( h in f )m > f[ h ] && f[ h ] > -m && (f[ h ] = 0)
			}
			return s && (t._gsTransform = f, f.svg && (xe && t.style[ be ] ? e.delayedCall( .001, function()
			{
				Be( t.style, be )
			} ) : !xe && t.getAttribute( "transform" ) && e.delayedCall( .001, function()
			{
				t.removeAttribute( "transform" )
			} ))), f
		}, Ee = function( t )
		{
			var e, i, s = this.data, r = -s.rotation * z, n = r + s.skewX * z, a = 1e5, o = (0 | Math.cos( r ) * s.scaleX * a) / a, h = (0 | Math.sin( r ) * s.scaleX * a) / a, l = (0 | Math.sin( n ) * -s.scaleY * a) / a, _ = (0 | Math.cos( n ) * s.scaleY * a) / a, u = this.t.style, c = this.t.currentStyle;
			if( c )
			{
				i = h, h = -l, l = -i, e = c.filter, u.filter = "";
				var f, p, d = this.t.offsetWidth, g = this.t.offsetHeight, v = "absolute" !== c.position, y = "progid:DXImageTransform.Microsoft.Matrix(M11=" + o + ", M12=" + h + ", M21=" + l + ", M22=" + _, w = s.x + d * s.xPercent / 100, b = s.y + g * s.yPercent / 100;
				if( null != s.ox && (f = (s.oxp ? .01 * d * s.ox : s.ox) - d / 2, p = (s.oyp ? .01 * g * s.oy : s.oy) - g / 2, w += f - (f * o + p * h), b += p - (f * l + p * _)), v ? (f = d / 2, p = g / 2, y += ", Dx=" + (f - (f * o + p * h) + w) + ", Dy=" + (p - (f * l + p * _) + b) + ")") : y += ", sizingMethod='auto expand')", u.filter = -1 !== e.indexOf( "DXImageTransform.Microsoft.Matrix(" ) ? e.replace( D, y ) : y + " " + e, (0 === t || 1 === t) && 1 === o && 0 === h && 0 === l && 1 === _ && (v && -1 === y.indexOf( "Dx=0, Dy=0" ) || x.test( e ) && 100 !== parseFloat( RegExp.$1 ) || -1 === e.indexOf( "gradient(" && e.indexOf( "Alpha" ) ) && u.removeAttribute( "filter" )), !v )
				{
					var P, k, S, R = 8 > m ? 1 : -1;
					for( f = s.ieOffsetX || 0, p = s.ieOffsetY || 0, s.ieOffsetX = Math.round( (d - ((0 > o ? -o : o) * d + (0 > h ? -h : h) * g)) / 2 + w ), s.ieOffsetY = Math.round( (g - ((0 > _ ? -_ : _) * g + (0 > l ? -l : l) * d)) / 2 + b ), ge = 0; 4 > ge; ge++ )k = ee[ ge ], P = c[ k ], i = -1 !== P.indexOf( "px" ) ? parseFloat( P ) : $( this.t, k, parseFloat( P ), P.replace( T, "" ) ) || 0, S = i !== s[ k ] ? 2 > ge ? -s.ieOffsetX : -s.ieOffsetY : 2 > ge ? f - s.ieOffsetX : p - s.ieOffsetY, u[ k ] = (s[ k ] = Math.round( i - S * (0 === ge || 2 === ge ? 1 : R) )) + "px"
				}
			}
		}, Le = B.set3DTransformRatio = B.setTransformRatio = function( t )
		{
			var e, i, s, r, n, a, o, h, l, _, u, c, p, m, d, g, v, y, T, x, w, b, P, k = this.data, S = this.t.style, R = k.rotation, O = k.rotationX, A = k.rotationY, C = k.scaleX, D = k.scaleY, M = k.scaleZ, I = k.x, F = k.y, N = k.z, E = k.svg, L = k.perspective, X = k.force3D;
			if( !(((1 !== t && 0 !== t || "auto" !== X || this.tween._totalTime !== this.tween._totalDuration && this.tween._totalTime) && X || N || L || A || O) && (!xe || !E) && Se) )return R || k.skewX || E ? (R *= z, b = k.skewX * z, P = 1e5, e = Math.cos( R ) * C, r = Math.sin( R ) * C, i = Math.sin( R - b ) * -D, n = Math.cos( R - b ) * D, b && "simple" === k.skewType && (v = Math.tan( b ), v = Math.sqrt( 1 + v * v ), i *= v, n *= v, k.skewY && (e *= v, r *= v)), E && (I += k.xOrigin - (k.xOrigin * e + k.yOrigin * i) + k.xOffset, F += k.yOrigin - (k.xOrigin * r + k.yOrigin * n) + k.yOffset, xe && (k.xPercent || k.yPercent) && (m = this.t.getBBox(), I += .01 * k.xPercent * m.width, F += .01 * k.yPercent * m.height), m = 1e-6, m > I && I > -m && (I = 0), m > F && F > -m && (F = 0)), T = (0 | e * P) / P + "," + (0 | r * P) / P + "," + (0 | i * P) / P + "," + (0 | n * P) / P + "," + I + "," + F + ")", E && xe ? this.t.setAttribute( "transform", "matrix(" + T ) : S[ be ] = (k.xPercent || k.yPercent ? "translate(" + k.xPercent + "%," + k.yPercent + "%) matrix(" : "matrix(") + T) : S[ be ] = (k.xPercent || k.yPercent ? "translate(" + k.xPercent + "%," + k.yPercent + "%) matrix(" : "matrix(") + C + ",0,0," + D + "," + I + "," + F + ")", void 0;
			if( f && (m = 1e-4, m > C && C > -m && (C = M = 2e-5), m > D && D > -m && (D = M = 2e-5), !L || k.z || k.rotationX || k.rotationY || (L = 0)), R || k.skewX )R *= z, d = e = Math.cos( R ), g = r = Math.sin( R ), k.skewX && (R -= k.skewX * z, d = Math.cos( R ), g = Math.sin( R ), "simple" === k.skewType && (v = Math.tan( k.skewX * z ), v = Math.sqrt( 1 + v * v ), d *= v, g *= v, k.skewY && (e *= v, r *= v))), i = -g, n = d;
			else
			{
				if( !(A || O || 1 !== M || L || E) )return S[ be ] = (k.xPercent || k.yPercent ? "translate(" + k.xPercent + "%," + k.yPercent + "%) translate3d(" : "translate3d(") + I + "px," + F + "px," + N + "px)" + (1 !== C || 1 !== D ? " scale(" + C + "," + D + ")" : ""), void 0;
				e = n = 1, i = r = 0
			}
			l = 1, s = a = o = h = _ = u = 0, c = L ? -1 / L : 0, p = k.zOrigin, m = 1e-6, x = ",", w = "0", R = A * z, R && (d = Math.cos( R ), g = Math.sin( R ), o = -g, _ = c * -g, s = e * g, a = r * g, l = d, c *= d, e *= d, r *= d), R = O * z, R && (d = Math.cos( R ), g = Math.sin( R ), v = i * d + s * g, y = n * d + a * g, h = l * g, u = c * g, s = i * -g + s * d, a = n * -g + a * d, l *= d, c *= d, i = v, n = y), 1 !== M && (s *= M, a *= M, l *= M, c *= M), 1 !== D && (i *= D, n *= D, h *= D, u *= D), 1 !== C && (e *= C, r *= C, o *= C, _ *= C), (p || E) && (p && (I += s * -p, F += a * -p, N += l * -p + p), E && (I += k.xOrigin - (k.xOrigin * e + k.yOrigin * i) + k.xOffset, F += k.yOrigin - (k.xOrigin * r + k.yOrigin * n) + k.yOffset), m > I && I > -m && (I = w), m > F && F > -m && (F = w), m > N && N > -m && (N = 0)), T = k.xPercent || k.yPercent ? "translate(" + k.xPercent + "%," + k.yPercent + "%) matrix3d(" : "matrix3d(", T += (m > e && e > -m ? w : e) + x + (m > r && r > -m ? w : r) + x + (m > o && o > -m ? w : o), T += x + (m > _ && _ > -m ? w : _) + x + (m > i && i > -m ? w : i) + x + (m > n && n > -m ? w : n), O || A ? (T += x + (m > h && h > -m ? w : h) + x + (m > u && u > -m ? w : u) + x + (m > s && s > -m ? w : s), T += x + (m > a && a > -m ? w : a) + x + (m > l && l > -m ? w : l) + x + (m > c && c > -m ? w : c) + x) : T += ",0,0,0,0,1,0,", T += I + x + F + x + N + x + (L ? 1 + -N / L : 1) + ")", S[ be ] = T
		};
		l = Re.prototype, l.x = l.y = l.z = l.skewX = l.skewY = l.rotation = l.rotationX = l.rotationY = l.zOrigin = l.xPercent = l.yPercent = l.xOffset = l.yOffset = 0, l.scaleX = l.scaleY = l.scaleZ = 1, ye( "transform,scale,scaleX,scaleY,scaleZ,x,y,z,rotation,rotationX,rotationY,rotationZ,skewX,skewY,shortRotation,shortRotationX,shortRotationY,shortRotationZ,transformOrigin,svgOrigin,transformPerspective,directionalRotation,parseTransform,force3D,skewType,xPercent,yPercent,smoothOrigin", {
			parser: function( t, e, i, s, n, o, h )
			{
				if( s._lastParsedTransform === h )return n;
				s._lastParsedTransform = h;
				var l, _, u, c, f, p, m, d, g, v = t._gsTransform, y = s._transform = Ne( t, r, !0, h.parseTransform ), T = t.style, x = 1e-6, w = we.length, b = h, P = {}, k = "transformOrigin";
				if( "string" == typeof b.transform && be )u = L.style, u[ be ] = b.transform, u.display = "block", u.position = "absolute", N.body.appendChild( L ), l = Ne( L, null, !1 ), N.body.removeChild( L ), null != b.xPercent && (l.xPercent = ne( b.xPercent, y.xPercent )), null != b.yPercent && (l.yPercent = ne( b.yPercent, y.yPercent ));
				else
					if( "object" == typeof b )
					{
						if( l = {
								scaleX: ne( null != b.scaleX ? b.scaleX : b.scale, y.scaleX ),
								scaleY: ne( null != b.scaleY ? b.scaleY : b.scale, y.scaleY ),
								scaleZ: ne( b.scaleZ, y.scaleZ ),
								x: ne( b.x, y.x ),
								y: ne( b.y, y.y ),
								z: ne( b.z, y.z ),
								xPercent: ne( b.xPercent, y.xPercent ),
								yPercent: ne( b.yPercent, y.yPercent ),
								perspective: ne( b.transformPerspective, y.perspective )
							}, m = b.directionalRotation, null != m )if( "object" == typeof m )for( u in m )b[ u ] = m[ u ];
						else b.rotation = m;
						"string" == typeof b.x && -1 !== b.x.indexOf( "%" ) && (l.x = 0, l.xPercent = ne( b.x, y.xPercent )), "string" == typeof b.y && -1 !== b.y.indexOf( "%" ) && (l.y = 0, l.yPercent = ne( b.y, y.yPercent )), l.rotation = ae( "rotation" in b ? b.rotation : "shortRotation" in b ? b.shortRotation + "_short" : "rotationZ" in b ? b.rotationZ : y.rotation, y.rotation, "rotation", P ), Se && (l.rotationX = ae( "rotationX" in b ? b.rotationX : "shortRotationX" in b ? b.shortRotationX + "_short" : y.rotationX || 0, y.rotationX, "rotationX", P ), l.rotationY = ae( "rotationY" in b ? b.rotationY : "shortRotationY" in b ? b.shortRotationY + "_short" : y.rotationY || 0, y.rotationY, "rotationY", P )), l.skewX = null == b.skewX ? y.skewX : ae( b.skewX, y.skewX ), l.skewY = null == b.skewY ? y.skewY : ae( b.skewY, y.skewY ), (_ = l.skewY - y.skewY) && (l.skewX += _, l.rotation += _)
					}
				for( Se && null != b.force3D && (y.force3D = b.force3D, p = !0), y.skewType = b.skewType || y.skewType || a.defaultSkewType, f = y.force3D || y.z || y.rotationX || y.rotationY || l.z || l.rotationX || l.rotationY || l.perspective, f || null == b.scale || (l.scaleZ = 1); --w > -1; )i = we[ w ], c = l[ i ] - y[ i ], (c > x || -x > c || null != b[ i ] || null != F[ i ]) && (p = !0, n = new pe( y, i, y[ i ], c, n ), i in P && (n.e = P[ i ]), n.xs0 = 0, n.plugin = o, s._overwriteProps.push( n.n ));
				return c = b.transformOrigin, y.svg && (c || b.svgOrigin) && (d = y.xOffset, g = y.yOffset, Me( t, se( c ), l, b.svgOrigin, b.smoothOrigin ), n = me( y, "xOrigin", (v ? y : l).xOrigin, l.xOrigin, n, k ), n = me( y, "yOrigin", (v ? y : l).yOrigin, l.yOrigin, n, k ), (d !== y.xOffset || g !== y.yOffset) && (n = me( y, "xOffset", v ? d : y.xOffset, y.xOffset, n, k ), n = me( y, "yOffset", v ? g : y.yOffset, y.yOffset, n, k )), c = xe ? null : "0px 0px"), (c || Se && f && y.zOrigin) && (be ? (p = !0, i = ke, c = (c || Q( t, i, r, !1, "50% 50%" )) + "", n = new pe( T, i, 0, 0, n, -1, k ), n.b = T[ i ], n.plugin = o, Se ? (u = y.zOrigin, c = c.split( " " ), y.zOrigin = (c.length > 2 && (0 === u || "0px" !== c[ 2 ]) ? parseFloat( c[ 2 ] ) : u) || 0, n.xs0 = n.e = c[ 0 ] + " " + (c[ 1 ] || "50%") + " 0px", n = new pe( y, "zOrigin", 0, 0, n, -1, n.n ), n.b = u, n.xs0 = n.e = y.zOrigin) : n.xs0 = n.e = c) : se( c + "", y )), p && (s._transformType = y.svg && xe || !f && 3 !== this._transformType ? 2 : 3), n
			}, prefix: !0
		} ), ye( "boxShadow", {
			defaultValue: "0px 0px 0px 0px #999",
			prefix: !0,
			color: !0,
			multi: !0,
			keyword: "inset"
		} ), ye( "borderRadius", {
			defaultValue: "0px", parser: function( t, e, i, n, a )
			{
				e = this.format( e );
				var o, h, l, _, u, c, f, p, m, d, g, v, y, T, x, w, b = [ "borderTopLeftRadius", "borderTopRightRadius", "borderBottomRightRadius", "borderBottomLeftRadius" ], P = t.style;
				for( m = parseFloat( t.offsetWidth ), d = parseFloat( t.offsetHeight ), o = e.split( " " ), h = 0; b.length > h; h++ )this.p.indexOf( "border" ) && (b[ h ] = W( b[ h ] )), u = _ = Q( t, b[ h ], r, !1, "0px" ), -1 !== u.indexOf( " " ) && (_ = u.split( " " ), u = _[ 0 ], _ = _[ 1 ]), c = l = o[ h ], f = parseFloat( u ), v = u.substr( (f + "").length ), y = "=" === c.charAt( 1 ), y ? (p = parseInt( c.charAt( 0 ) + "1", 10 ), c = c.substr( 2 ), p *= parseFloat( c ), g = c.substr( (p + "").length - (0 > p ? 1 : 0) ) || "") : (p = parseFloat( c ), g = c.substr( (p + "").length )), "" === g && (g = s[ i ] || v), g !== v && (T = $( t, "borderLeft", f, v ), x = $( t, "borderTop", f, v ), "%" === g ? (u = 100 * (T / m) + "%", _ = 100 * (x / d) + "%") : "em" === g ? (w = $( t, "borderLeft", 1, "em" ), u = T / w + "em", _ = x / w + "em") : (u = T + "px", _ = x + "px"), y && (c = parseFloat( u ) + p + g, l = parseFloat( _ ) + p + g)), a = de( P, b[ h ], u + " " + _, c + " " + l, !1, "0px", a );
				return a
			}, prefix: !0, formatter: ue( "0px 0px 0px 0px", !1, !0 )
		} ), ye( "backgroundPosition", {
			defaultValue: "0 0", parser: function( t, e, i, s, n, a )
			{
				var o, h, l, _, u, c, f = "background-position", p = r || Z( t, null ), d = this.format( (p ? m ? p.getPropertyValue( f + "-x" ) + " " + p.getPropertyValue( f + "-y" ) : p.getPropertyValue( f ) : t.currentStyle.backgroundPositionX + " " + t.currentStyle.backgroundPositionY) || "0 0" ), g = this.format( e );
				if( -1 !== d.indexOf( "%" ) != (-1 !== g.indexOf( "%" )) && (c = Q( t, "backgroundImage" ).replace( R, "" ), c && "none" !== c) )
				{
					for( o = d.split( " " ), h = g.split( " " ), X.setAttribute( "src", c ), l = 2; --l > -1; )d = o[ l ], _ = -1 !== d.indexOf( "%" ), _ !== (-1 !== h[ l ].indexOf( "%" )) && (u = 0 === l ? t.offsetWidth - X.width : t.offsetHeight - X.height, o[ l ] = _ ? parseFloat( d ) / 100 * u + "px" : 100 * (parseFloat( d ) / u) + "%");
					d = o.join( " " )
				}
				return this.parseComplex( t.style, d, g, n, a )
			}, formatter: se
		} ), ye( "backgroundSize", { defaultValue: "0 0", formatter: se } ), ye( "perspective", {
			defaultValue: "0px",
			prefix: !0
		} ), ye( "perspectiveOrigin", {
			defaultValue: "50% 50%",
			prefix: !0
		} ), ye( "transformStyle", { prefix: !0 } ), ye( "backfaceVisibility", { prefix: !0 } ), ye( "userSelect", { prefix: !0 } ), ye( "margin", { parser: ce( "marginTop,marginRight,marginBottom,marginLeft" ) } ), ye( "padding", { parser: ce( "paddingTop,paddingRight,paddingBottom,paddingLeft" ) } ), ye( "clip", {
			defaultValue: "rect(0px,0px,0px,0px)",
			parser: function( t, e, i, s, n, a )
			{
				var o, h, l;
				return 9 > m ? (h = t.currentStyle, l = 8 > m ? " " : ",", o = "rect(" + h.clipTop + l + h.clipRight + l + h.clipBottom + l + h.clipLeft + ")", e = this.format( e ).split( "," ).join( l )) : (o = this.format( Q( t, this.p, r, !1, this.dflt ) ), e = this.format( e )), this.parseComplex( t.style, o, e, n, a )
			}
		} ), ye( "textShadow", {
			defaultValue: "0px 0px 0px #999",
			color: !0,
			multi: !0
		} ), ye( "autoRound,strictUnits", {
			parser: function( t, e, i, s, r )
			{
				return r
			}
		} ), ye( "border", {
			defaultValue: "0px solid #000", parser: function( t, e, i, s, n, a )
			{
				return this.parseComplex( t.style, this.format( Q( t, "borderTopWidth", r, !1, "0px" ) + " " + Q( t, "borderTopStyle", r, !1, "solid" ) + " " + Q( t, "borderTopColor", r, !1, "#000" ) ), this.format( e ), n, a )
			}, color: !0, formatter: function( t )
			{
				var e = t.split( " " );
				return e[ 0 ] + " " + (e[ 1 ] || "solid") + " " + (t.match( _e ) || [ "#000" ])[ 0 ]
			}
		} ), ye( "borderWidth", { parser: ce( "borderTopWidth,borderRightWidth,borderBottomWidth,borderLeftWidth" ) } ), ye( "float,cssFloat,styleFloat", {
			parser: function( t, e, i, s, r )
			{
				var n = t.style, a = "cssFloat" in n ? "cssFloat" : "styleFloat";
				return new pe( n, a, 0, 0, r, -1, i, !1, 0, n[ a ], e )
			}
		} );
		var Xe = function( t )
		{
			var e, i = this.t, s = i.filter || Q( this.data, "filter" ) || "", r = 0 | this.s + this.c * t;
			100 === r && (-1 === s.indexOf( "atrix(" ) && -1 === s.indexOf( "radient(" ) && -1 === s.indexOf( "oader(" ) ? (i.removeAttribute( "filter" ), e = !Q( this.data, "filter" )) : (i.filter = s.replace( b, "" ), e = !0)), e || (this.xn1 && (i.filter = s = s || "alpha(opacity=" + r + ")"), -1 === s.indexOf( "pacity" ) ? 0 === r && this.xn1 || (i.filter = s + " alpha(opacity=" + r + ")") : i.filter = s.replace( x, "opacity=" + r ))
		};
		ye( "opacity,alpha,autoAlpha", {
			defaultValue: "1", parser: function( t, e, i, s, n, a )
			{
				var o = parseFloat( Q( t, "opacity", r, !1, "1" ) ), h = t.style, l = "autoAlpha" === i;
				return "string" == typeof e && "=" === e.charAt( 1 ) && (e = ("-" === e.charAt( 0 ) ? -1 : 1) * parseFloat( e.substr( 2 ) ) + o), l && 1 === o && "hidden" === Q( t, "visibility", r ) && 0 !== e && (o = 0), j ? n = new pe( h, "opacity", o, e - o, n ) : (n = new pe( h, "opacity", 100 * o, 100 * (e - o), n ), n.xn1 = l ? 1 : 0, h.zoom = 1, n.type = 2, n.b = "alpha(opacity=" + n.s + ")", n.e = "alpha(opacity=" + (n.s + n.c) + ")", n.data = t, n.plugin = a, n.setRatio = Xe), l && (n = new pe( h, "visibility", 0, 0, n, -1, null, !1, 0, 0 !== o ? "inherit" : "hidden", 0 === e ? "hidden" : "inherit" ), n.xs0 = "inherit", s._overwriteProps.push( n.n ), s._overwriteProps.push( i )), n
			}
		} );
		var Be = function( t, e )
		{
			e && (t.removeProperty ? (("ms" === e.substr( 0, 2 ) || "webkit" === e.substr( 0, 6 )) && (e = "-" + e), t.removeProperty( e.replace( k, "-$1" ).toLowerCase() )) : t.removeAttribute( e ))
		}, Ye = function( t )
		{
			if( this.t._gsClassPT = this, 1 === t || 0 === t )
			{
				this.t.setAttribute( "class", 0 === t ? this.b : this.e );
				for( var e = this.data, i = this.t.style; e; )e.v ? i[ e.p ] = e.v : Be( i, e.p ), e = e._next;
				1 === t && this.t._gsClassPT === this && (this.t._gsClassPT = null)
			}
			else this.t.getAttribute( "class" ) !== this.e && this.t.setAttribute( "class", this.e )
		};
		ye( "className", {
			parser: function( t, e, s, n, a, o, h )
			{
				var l, _, u, c, f, p = t.getAttribute( "class" ) || "", m = t.style.cssText;
				if( a = n._classNamePT = new pe( t, s, 0, 0, a, 2 ), a.setRatio = Ye, a.pr = -11, i = !0, a.b = p, _ = K( t, r ), u = t._gsClassPT )
				{
					for( c = {}, f = u.data; f; )c[ f.p ] = 1, f = f._next;
					u.setRatio( 1 )
				}
				return t._gsClassPT = a, a.e = "=" !== e.charAt( 1 ) ? e : p.replace( RegExp( "\\s*\\b" + e.substr( 2 ) + "\\b" ), "" ) + ("+" === e.charAt( 0 ) ? " " + e.substr( 2 ) : ""), t.setAttribute( "class", a.e ), l = J( t, _, K( t ), h, c ), t.setAttribute( "class", p ), a.data = l.firstMPT, t.style.cssText = m, a = a.xfirst = n.parse( t, l.difs, a, o )
			}
		} );
		var je = function( t )
		{
			if( (1 === t || 0 === t) && this.data._totalTime === this.data._totalDuration && "isFromStart" !== this.data.data )
			{
				var e, i, s, r, n, a = this.t.style, o = h.transform.parse;
				if( "all" === this.e )a.cssText = "", r = !0;
				else for( e = this.e.split( " " ).join( "" ).split( "," ), s = e.length; --s > -1; )i = e[ s ], h[ i ] && (h[ i ].parse === o ? r = !0 : i = "transformOrigin" === i ? ke : h[ i ].p), Be( a, i );
				r && (Be( a, be ), n = this.t._gsTransform, n && (n.svg && this.t.removeAttribute( "data-svg-origin" ), delete this.t._gsTransform))
			}
		};
		for( ye( "clearProps", {
			parser: function( t, e, s, r, n )
			{
				return n = new pe( t, s, 0, 0, n, 2 ), n.setRatio = je, n.e = e, n.pr = -10, n.data = r._tween, i = !0, n
			}
		} ), l = "bezier,throwProps,physicsProps,physics2D".split( "," ), ge = l.length; ge--; )Te( l[ ge ] );
		l = a.prototype, l._firstPT = l._lastParsedTransform = l._transform = null, l._onInitTween = function( t, e, o )
		{
			if( !t.nodeType )return !1;
			this._target = t, this._tween = o, this._vars = e, _ = e.autoRound, i = !1, s = e.suffixMap || a.suffixMap, r = Z( t, "" ), n = this._overwriteProps;
			var l, f, m, d, g, v, y, T, x, b = t.style;
			if( u && "" === b.zIndex && (l = Q( t, "zIndex", r ), ("auto" === l || "" === l) && this._addLazySet( b, "zIndex", 0 )), "string" == typeof e && (d = b.cssText, l = K( t, r ), b.cssText = d + ";" + e, l = J( t, l, K( t ) ).difs, !j && w.test( e ) && (l.opacity = parseFloat( RegExp.$1 )), e = l, b.cssText = d), this._firstPT = f = e.className ? h.className.parse( t, e.className, "className", this, null, null, e ) : this.parse( t, e, null ), this._transformType )
			{
				for( x = 3 === this._transformType, be ? c && (u = !0, "" === b.zIndex && (y = Q( t, "zIndex", r ), ("auto" === y || "" === y) && this._addLazySet( b, "zIndex", 0 )), p && this._addLazySet( b, "WebkitBackfaceVisibility", this._vars.WebkitBackfaceVisibility || (x ? "visible" : "hidden") )) : b.zoom = 1, m = f; m && m._next; )m = m._next;
				T = new pe( t, "transform", 0, 0, null, 2 ), this._linkCSSP( T, null, m ), T.setRatio = be ? Le : Ee, T.data = this._transform || Ne( t, r, !0 ), T.tween = o, T.pr = -1, n.pop()
			}
			if( i )
			{
				for( ; f; )
				{
					for( v = f._next, m = d; m && m.pr > f.pr; )m = m._next;
					(f._prev = m ? m._prev : g) ? f._prev._next = f : d = f, (f._next = m) ? m._prev = f : g = f, f = v
				}
				this._firstPT = d
			}
			return !0
		}, l.parse = function( t, e, i, n )
		{
			var a, o, l, u, c, f, p, m, d, g, v = t.style;
			for( a in e )f = e[ a ], o = h[ a ], o ? i = o.parse( t, f, a, this, i, n, e ) : (c = Q( t, a, r ) + "", d = "string" == typeof f, "color" === a || "fill" === a || "stroke" === a || -1 !== a.indexOf( "Color" ) || d && P.test( f ) ? (d || (f = le( f ), f = (f.length > 3 ? "rgba(" : "rgb(") + f.join( "," ) + ")"), i = de( v, a, c, f, !0, "transparent", i, 0, n )) : !d || -1 === f.indexOf( " " ) && -1 === f.indexOf( "," ) ? (l = parseFloat( c ), p = l || 0 === l ? c.substr( (l + "").length ) : "", ("" === c || "auto" === c) && ("width" === a || "height" === a ? (l = ie( t, a, r ), p = "px") : "left" === a || "top" === a ? (l = H( t, a, r ), p = "px") : (l = "opacity" !== a ? 0 : 1, p = "")), g = d && "=" === f.charAt( 1 ), g ? (u = parseInt( f.charAt( 0 ) + "1", 10 ), f = f.substr( 2 ), u *= parseFloat( f ), m = f.replace( T, "" )) : (u = parseFloat( f ), m = d ? f.replace( T, "" ) : ""), "" === m && (m = a in s ? s[ a ] : p), f = u || 0 === u ? (g ? u + l : u) + m : e[ a ], p !== m && "" !== m && (u || 0 === u) && l && (l = $( t, a, l, p ), "%" === m ? (l /= $( t, a, 100, "%" ) / 100, e.strictUnits !== !0 && (c = l + "%")) : "em" === m ? l /= $( t, a, 1, "em" ) : "px" !== m && (u = $( t, a, u, m ), m = "px"), g && (u || 0 === u) && (f = u + l + m)), g && (u += l), !l && 0 !== l || !u && 0 !== u ? void 0 !== v[ a ] && (f || "NaN" != f + "" && null != f) ? (i = new pe( v, a, u || l || 0, 0, i, -1, a, !1, 0, c, f ), i.xs0 = "none" !== f || "display" !== a && -1 === a.indexOf( "Style" ) ? f : c) : q( "invalid " + a + " tween value: " + e[ a ] ) : (i = new pe( v, a, l, u - l, i, 0, a, _ !== !1 && ("px" === m || "zIndex" === a), 0, c, f ), i.xs0 = m)) : i = de( v, a, c, f, !0, null, i, 0, n )), n && i && !i.plugin && (i.plugin = n);
			return i
		}, l.setRatio = function( t )
		{
			var e, i, s, r = this._firstPT, n = 1e-6;
			if( 1 !== t || this._tween._time !== this._tween._duration && 0 !== this._tween._time )if( t || this._tween._time !== this._tween._duration && 0 !== this._tween._time || this._tween._rawPrevTime === -1e-6 )for( ; r; )
			{
				if( e = r.c * t + r.s, r.r ? e = Math.round( e ) : n > e && e > -n && (e = 0), r.type )if( 1 === r.type )if( s = r.l, 2 === s )r.t[ r.p ] = r.xs0 + e + r.xs1 + r.xn1 + r.xs2;
				else
					if( 3 === s )r.t[ r.p ] = r.xs0 + e + r.xs1 + r.xn1 + r.xs2 + r.xn2 + r.xs3;
					else
						if( 4 === s )r.t[ r.p ] = r.xs0 + e + r.xs1 + r.xn1 + r.xs2 + r.xn2 + r.xs3 + r.xn3 + r.xs4;
						else
							if( 5 === s )r.t[ r.p ] = r.xs0 + e + r.xs1 + r.xn1 + r.xs2 + r.xn2 + r.xs3 + r.xn3 + r.xs4 + r.xn4 + r.xs5;
							else
							{
								for( i = r.xs0 + e + r.xs1, s = 1; r.l > s; s++ )i += r[ "xn" + s ] + r[ "xs" + (s + 1) ];
								r.t[ r.p ] = i
							}
				else-1 === r.type ? r.t[ r.p ] = r.xs0 : r.setRatio && r.setRatio( t );
				else r.t[ r.p ] = e + r.xs0;
				r = r._next
			}
			else for( ; r; )2 !== r.type ? r.t[ r.p ] = r.b : r.setRatio( t ), r = r._next;
			else for( ; r; )
			{
				if( 2 !== r.type )if( r.r && -1 !== r.type )if( e = Math.round( r.s + r.c ), r.type )
				{
					if( 1 === r.type )
					{
						for( s = r.l, i = r.xs0 + e + r.xs1, s = 1; r.l > s; s++ )i += r[ "xn" + s ] + r[ "xs" + (s + 1) ];
						r.t[ r.p ] = i
					}
				}
				else r.t[ r.p ] = e + r.xs0;
				else r.t[ r.p ] = r.e;
				else r.setRatio( t );
				r = r._next
			}
		}, l._enableTransforms = function( t )
		{
			this._transform = this._transform || Ne( this._target, r, !0 ), this._transformType = this._transform.svg && xe || !t && 3 !== this._transformType ? 2 : 3
		};
		var Ue = function()
		{
			this.t[ this.p ] = this.e, this.data._linkCSSP( this, this._next, null, !0 )
		};
		l._addLazySet = function( t, e, i )
		{
			var s = this._firstPT = new pe( t, e, 0, 0, this._firstPT, 2 );
			s.e = i, s.setRatio = Ue, s.data = this
		}, l._linkCSSP = function( t, e, i, s )
		{
			return t && (e && (e._prev = t), t._next && (t._next._prev = t._prev), t._prev ? t._prev._next = t._next : this._firstPT === t && (this._firstPT = t._next, s = !0), i ? i._next = t : s || null !== this._firstPT || (this._firstPT = t), t._next = e, t._prev = i), t
		}, l._kill = function( e )
		{
			var i, s, r, n = e;
			if( e.autoAlpha || e.alpha )
			{
				n = {};
				for( s in e )n[ s ] = e[ s ];
				n.opacity = 1, n.autoAlpha && (n.visibility = 1)
			}
			return e.className && (i = this._classNamePT) && (r = i.xfirst, r && r._prev ? this._linkCSSP( r._prev, i._next, r._prev._prev ) : r === this._firstPT && (this._firstPT = i._next), i._next && this._linkCSSP( i._next, i._next._next, r._prev ), this._classNamePT = null), t.prototype._kill.call( this, n )
		};
		var qe = function( t, e, i )
		{
			var s, r, n, a;
			if( t.slice )for( r = t.length; --r > -1; )qe( t[ r ], e, i );
			else for( s = t.childNodes, r = s.length; --r > -1; )n = s[ r ], a = n.type, n.style && (e.push( K( n ) ), i && i.push( n )), 1 !== a && 9 !== a && 11 !== a || !n.childNodes.length || qe( n, e, i )
		};
		return a.cascadeTo = function( t, i, s )
		{
			var r, n, a, o, h = e.to( t, i, s ), l = [ h ], _ = [], u = [], c = [], f = e._internals.reservedProps;
			for( t = h._targets || h.target, qe( t, _, c ), h.render( i, !0, !0 ), qe( t, u ), h.render( 0, !0, !0 ), h._enabled( !0 ), r = c.length; --r > -1; )if( n = J( c[ r ], _[ r ], u[ r ] ), n.firstMPT )
			{
				n = n.difs;
				for( a in s )f[ a ] && (n[ a ] = s[ a ]);
				o = {};
				for( a in n )o[ a ] = _[ r ][ a ];
				l.push( e.fromTo( c[ r ], i, o, n ) )
			}
			return l
		}, t.activate( [ a ] ), a
	}, !0 ), function()
	{
		var t = _gsScope._gsDefine.plugin( {
			propName: "roundProps", priority: -1, API: 2, init: function( t, e, i )
			{
				return this._tween = i, !0
			}
		} ), e = t.prototype;
		e._onInitAllProps = function()
		{
			for( var t, e, i, s = this._tween, r = s.vars.roundProps instanceof Array ? s.vars.roundProps : s.vars.roundProps.split( "," ), n = r.length, a = {}, o = s._propLookup.roundProps; --n > -1; )a[ r[ n ] ] = 1;
			for( n = r.length; --n > -1; )for( t = r[ n ], e = s._firstPT; e; )i = e._next, e.pg ? e.t._roundProps( a, !0 ) : e.n === t && (this._add( e.t, t, e.s, e.c ), i && (i._prev = e._prev), e._prev ? e._prev._next = i : s._firstPT === e && (s._firstPT = i), e._next = e._prev = null, s._propLookup[ t ] = o), e = i;
			return !1
		}, e._add = function( t, e, i, s )
		{
			this._addTween( t, e, i, i + s, e, !0 ), this._overwriteProps.push( e )
		}
	}(), function()
	{
		var t = /(?:\d|\-|\+|=|#|\.)*/g, e = /[A-Za-z%]/g;
		_gsScope._gsDefine.plugin( {
			propName: "attr", API: 2, version: "0.4.0", init: function( i, s )
			{
				var r, n, a, o, h;
				if( "function" != typeof i.setAttribute )return !1;
				this._target = i, this._proxy = {}, this._start = {}, this._end = {}, this._suffix = {};
				for( r in s )this._start[ r ] = this._proxy[ r ] = n = i.getAttribute( r ) + "", this._end[ r ] = a = s[ r ] + "", this._suffix[ r ] = o = e.test( a ) ? a.replace( t, "" ) : e.test( n ) ? n.replace( t, "" ) : "", o && (h = a.indexOf( o ), -1 !== h && (a = a.substr( 0, h ))), this._addTween( this._proxy, r, parseFloat( n ), a, r ) || (this._suffix[ r ] = ""), "=" === a.charAt( 1 ) && (this._end[ r ] = this._firstPT.s + this._firstPT.c + o), this._overwriteProps.push( r );
				return !0
			}, set: function( t )
			{
				this._super.setRatio.call( this, t );
				for( var e, i = this._overwriteProps, s = i.length, r = 1 === t ? this._end : t ? this._proxy : this._start, n = r === this._proxy; --s > -1; )e = i[ s ], this._target.setAttribute( e, r[ e ] + (n ? this._suffix[ e ] : "") )
			}
		} )
	}(), _gsScope._gsDefine.plugin( {
		propName: "directionalRotation", version: "0.2.1", API: 2, init: function( t, e )
		{
			"object" != typeof e && (e = { rotation: e }), this.finals = {};
			var i, s, r, n, a, o, h = e.useRadians === !0 ? 2 * Math.PI : 360, l = 1e-6;
			for( i in e )"useRadians" !== i && (o = (e[ i ] + "").split( "_" ), s = o[ 0 ], r = parseFloat( "function" != typeof t[ i ] ? t[ i ] : t[ i.indexOf( "set" ) || "function" != typeof t[ "get" + i.substr( 3 ) ] ? i : "get" + i.substr( 3 ) ]() ), n = this.finals[ i ] = "string" == typeof s && "=" === s.charAt( 1 ) ? r + parseInt( s.charAt( 0 ) + "1", 10 ) * Number( s.substr( 2 ) ) : Number( s ) || 0, a = n - r, o.length && (s = o.join( "_" ), -1 !== s.indexOf( "short" ) && (a %= h, a !== a % (h / 2) && (a = 0 > a ? a + h : a - h)), -1 !== s.indexOf( "_cw" ) && 0 > a ? a = (a + 9999999999 * h) % h - (0 | a / h) * h : -1 !== s.indexOf( "ccw" ) && a > 0 && (a = (a - 9999999999 * h) % h - (0 | a / h) * h)), (a > l || -l > a) && (this._addTween( t, i, r, r + a, i ), this._overwriteProps.push( i )));
			return !0
		}, set: function( t )
		{
			var e;
			if( 1 !== t )this._super.setRatio.call( this, t );
			else for( e = this._firstPT; e; )e.f ? e.t[ e.p ]( this.finals[ e.p ] ) : e.t[ e.p ] = this.finals[ e.p ], e = e._next
		}
	} )._autoCSS = !0, _gsScope._gsDefine( "easing.Back", [ "easing.Ease" ], function( t )
	{
		var e, i, s, r = _gsScope.GreenSockGlobals || _gsScope, n = r.com.greensock, a = 2 * Math.PI, o = Math.PI / 2, h = n._class, l = function( e, i )
		{
			var s = h( "easing." + e, function()
			{
			}, !0 ), r = s.prototype = new t;
			return r.constructor = s, r.getRatio = i, s
		}, _ = t.register || function()
			{
			}, u = function( t, e, i, s )
		{
			var r = h( "easing." + t, { easeOut: new e, easeIn: new i, easeInOut: new s }, !0 );
			return _( r, t ), r
		}, c = function( t, e, i )
		{
			this.t = t, this.v = e, i && (this.next = i, i.prev = this, this.c = i.v - e, this.gap = i.t - t)
		}, f = function( e, i )
		{
			var s = h( "easing." + e, function( t )
			{
				this._p1 = t || 0 === t ? t : 1.70158, this._p2 = 1.525 * this._p1
			}, !0 ), r = s.prototype = new t;
			return r.constructor = s, r.getRatio = i, r.config = function( t )
			{
				return new s( t )
			}, s
		}, p = u( "Back", f( "BackOut", function( t )
		{
			return (t -= 1) * t * ((this._p1 + 1) * t + this._p1) + 1
		} ), f( "BackIn", function( t )
		{
			return t * t * ((this._p1 + 1) * t - this._p1)
		} ), f( "BackInOut", function( t )
		{
			return 1 > (t *= 2) ? .5 * t * t * ((this._p2 + 1) * t - this._p2) : .5 * ((t -= 2) * t * ((this._p2 + 1) * t + this._p2) + 2)
		} ) ), m = h( "easing.SlowMo", function( t, e, i )
		{
			e = e || 0 === e ? e : .7, null == t ? t = .7 : t > 1 && (t = 1), this._p = 1 !== t ? e : 0, this._p1 = (1 - t) / 2, this._p2 = t, this._p3 = this._p1 + this._p2, this._calcEnd = i === !0
		}, !0 ), d = m.prototype = new t;
		return d.constructor = m, d.getRatio = function( t )
		{
			var e = t + (.5 - t) * this._p;
			return this._p1 > t ? this._calcEnd ? 1 - (t = 1 - t / this._p1) * t : e - (t = 1 - t / this._p1) * t * t * t * e : t > this._p3 ? this._calcEnd ? 1 - (t = (t - this._p3) / this._p1) * t : e + (t - e) * (t = (t - this._p3) / this._p1) * t * t * t : this._calcEnd ? 1 : e
		}, m.ease = new m( .7, .7 ), d.config = m.config = function( t, e, i )
		{
			return new m( t, e, i )
		}, e = h( "easing.SteppedEase", function( t )
		{
			t = t || 1, this._p1 = 1 / t, this._p2 = t + 1
		}, !0 ), d = e.prototype = new t, d.constructor = e, d.getRatio = function( t )
		{
			return 0 > t ? t = 0 : t >= 1 && (t = .999999999), (this._p2 * t >> 0) * this._p1
		}, d.config = e.config = function( t )
		{
			return new e( t )
		}, i = h( "easing.RoughEase", function( e )
		{
			e = e || {};
			for( var i, s, r, n, a, o, h = e.taper || "none", l = [], _ = 0, u = 0 | (e.points || 20), f = u, p = e.randomize !== !1, m = e.clamp === !0, d = e.template instanceof t ? e.template : null, g = "number" == typeof e.strength ? .4 * e.strength : .4; --f > -1; )i = p ? Math.random() : 1 / u * f, s = d ? d.getRatio( i ) : i, "none" === h ? r = g : "out" === h ? (n = 1 - i, r = n * n * g) : "in" === h ? r = i * i * g : .5 > i ? (n = 2 * i, r = .5 * n * n * g) : (n = 2 * (1 - i), r = .5 * n * n * g), p ? s += Math.random() * r - .5 * r : f % 2 ? s += .5 * r : s -= .5 * r, m && (s > 1 ? s = 1 : 0 > s && (s = 0)), l[ _++ ] = {
				x: i,
				y: s
			};
			for( l.sort( function( t, e )
			{
				return t.x - e.x
			} ), o = new c( 1, 1, null ), f = u; --f > -1; )a = l[ f ], o = new c( a.x, a.y, o );
			this._prev = new c( 0, 0, 0 !== o.t ? o : o.next )
		}, !0 ), d = i.prototype = new t, d.constructor = i, d.getRatio = function( t )
		{
			var e = this._prev;
			if( t > e.t )
			{
				for( ; e.next && t >= e.t; )e = e.next;
				e = e.prev
			}
			else for( ; e.prev && e.t >= t; )e = e.prev;
			return this._prev = e, e.v + (t - e.t) / e.gap * e.c
		}, d.config = function( t )
		{
			return new i( t )
		}, i.ease = new i, u( "Bounce", l( "BounceOut", function( t )
		{
			return 1 / 2.75 > t ? 7.5625 * t * t : 2 / 2.75 > t ? 7.5625 * (t -= 1.5 / 2.75) * t + .75 : 2.5 / 2.75 > t ? 7.5625 * (t -= 2.25 / 2.75) * t + .9375 : 7.5625 * (t -= 2.625 / 2.75) * t + .984375
		} ), l( "BounceIn", function( t )
		{
			return 1 / 2.75 > (t = 1 - t) ? 1 - 7.5625 * t * t : 2 / 2.75 > t ? 1 - (7.5625 * (t -= 1.5 / 2.75) * t + .75) : 2.5 / 2.75 > t ? 1 - (7.5625 * (t -= 2.25 / 2.75) * t + .9375) : 1 - (7.5625 * (t -= 2.625 / 2.75) * t + .984375)
		} ), l( "BounceInOut", function( t )
		{
			var e = .5 > t;
			return t = e ? 1 - 2 * t : 2 * t - 1, t = 1 / 2.75 > t ? 7.5625 * t * t : 2 / 2.75 > t ? 7.5625 * (t -= 1.5 / 2.75) * t + .75 : 2.5 / 2.75 > t ? 7.5625 * (t -= 2.25 / 2.75) * t + .9375 : 7.5625 * (t -= 2.625 / 2.75) * t + .984375, e ? .5 * (1 - t) : .5 * t + .5
		} ) ), u( "Circ", l( "CircOut", function( t )
		{
			return Math.sqrt( 1 - (t -= 1) * t )
		} ), l( "CircIn", function( t )
		{
			return -(Math.sqrt( 1 - t * t ) - 1)
		} ), l( "CircInOut", function( t )
		{
			return 1 > (t *= 2) ? -.5 * (Math.sqrt( 1 - t * t ) - 1) : .5 * (Math.sqrt( 1 - (t -= 2) * t ) + 1)
		} ) ), s = function( e, i, s )
		{
			var r = h( "easing." + e, function( t, e )
			{
				this._p1 = t >= 1 ? t : 1, this._p2 = (e || s) / (1 > t ? t : 1), this._p3 = this._p2 / a * (Math.asin( 1 / this._p1 ) || 0), this._p2 = a / this._p2
			}, !0 ), n = r.prototype = new t;
			return n.constructor = r, n.getRatio = i, n.config = function( t, e )
			{
				return new r( t, e )
			}, r
		}, u( "Elastic", s( "ElasticOut", function( t )
		{
			return this._p1 * Math.pow( 2, -10 * t ) * Math.sin( (t - this._p3) * this._p2 ) + 1
		}, .3 ), s( "ElasticIn", function( t )
		{
			return -(this._p1 * Math.pow( 2, 10 * (t -= 1) ) * Math.sin( (t - this._p3) * this._p2 ))
		}, .3 ), s( "ElasticInOut", function( t )
		{
			return 1 > (t *= 2) ? -.5 * this._p1 * Math.pow( 2, 10 * (t -= 1) ) * Math.sin( (t - this._p3) * this._p2 ) : .5 * this._p1 * Math.pow( 2, -10 * (t -= 1) ) * Math.sin( (t - this._p3) * this._p2 ) + 1
		}, .45 ) ), u( "Expo", l( "ExpoOut", function( t )
		{
			return 1 - Math.pow( 2, -10 * t )
		} ), l( "ExpoIn", function( t )
		{
			return Math.pow( 2, 10 * (t - 1) ) - .001
		} ), l( "ExpoInOut", function( t )
		{
			return 1 > (t *= 2) ? .5 * Math.pow( 2, 10 * (t - 1) ) : .5 * (2 - Math.pow( 2, -10 * (t - 1) ))
		} ) ), u( "Sine", l( "SineOut", function( t )
		{
			return Math.sin( t * o )
		} ), l( "SineIn", function( t )
		{
			return -Math.cos( t * o ) + 1
		} ), l( "SineInOut", function( t )
		{
			return -.5 * (Math.cos( Math.PI * t ) - 1)
		} ) ), h( "easing.EaseLookup", {
			find: function( e )
			{
				return t.map[ e ]
			}
		}, !0 ), _( r.SlowMo, "SlowMo", "ease," ), _( i, "RoughEase", "ease," ), _( e, "SteppedEase", "ease," ), p
	}, !0 )
} ), _gsScope._gsDefine && _gsScope._gsQueue.pop()(), function( t, e )
{
	"use strict";
	var i = t.GreenSockGlobals = t.GreenSockGlobals || t;
	if( !i.TweenLite )
	{
		var s, r, n, a, o, h = function( t )
		{
			var e, s = t.split( "." ), r = i;
			for( e = 0; s.length > e; e++ )r[ s[ e ] ] = r = r[ s[ e ] ] || {};
			return r
		}, l = h( "com.greensock" ), _ = 1e-10, u = function( t )
		{
			var e, i = [], s = t.length;
			for( e = 0; e !== s; i.push( t[ e++ ] ) );
			return i
		}, c = function()
		{
		}, f = function()
		{
			var t = Object.prototype.toString, e = t.call( [] );
			return function( i )
			{
				return null != i && (i instanceof Array || "object" == typeof i && !!i.push && t.call( i ) === e)
			}
		}(), p = {}, m = function( s, r, n, a )
		{
			this.sc = p[ s ] ? p[ s ].sc : [], p[ s ] = this, this.gsClass = null, this.func = n;
			var o = [];
			this.check = function( l )
			{
				for( var _, u, c, f, d = r.length, g = d; --d > -1; )(_ = p[ r[ d ] ] || new m( r[ d ], [] )).gsClass ? (o[ d ] = _.gsClass, g--) : l && _.sc.push( this );
				if( 0 === g && n )for( u = ("com.greensock." + s).split( "." ), c = u.pop(), f = h( u.join( "." ) )[ c ] = this.gsClass = n.apply( n, o ), a && (i[ c ] = f, "function" == typeof define && define.amd ? define( (t.GreenSockAMDPath ? t.GreenSockAMDPath + "/" : "") + s.split( "." ).pop(), [], function()
				{
					return f
				} ) : s === e && "undefined" != typeof module && module.exports && (module.exports = f)), d = 0; this.sc.length > d; d++ )this.sc[ d ].check()
			}, this.check( !0 )
		}, d = t._gsDefine = function( t, e, i, s )
		{
			return new m( t, e, i, s )
		}, g = l._class = function( t, e, i )
		{
			return e = e || function()
				{
				}, d( t, [], function()
			{
				return e
			}, i ), e
		};
		d.globals = i;
		var v = [ 0, 0, 1, 1 ], y = [], T = g( "easing.Ease", function( t, e, i, s )
		{
			this._func = t, this._type = i || 0, this._power = s || 0, this._params = e ? v.concat( e ) : v
		}, !0 ), x = T.map = {}, w = T.register = function( t, e, i, s )
		{
			for( var r, n, a, o, h = e.split( "," ), _ = h.length, u = (i || "easeIn,easeOut,easeInOut").split( "," ); --_ > -1; )for( n = h[ _ ], r = s ? g( "easing." + n, null, !0 ) : l.easing[ n ] || {}, a = u.length; --a > -1; )o = u[ a ], x[ n + "." + o ] = x[ o + n ] = r[ o ] = t.getRatio ? t : t[ o ] || new t
		};
		for( n = T.prototype, n._calcEnd = !1, n.getRatio = function( t )
		{
			if( this._func )return this._params[ 0 ] = t, this._func.apply( null, this._params );
			var e = this._type, i = this._power, s = 1 === e ? 1 - t : 2 === e ? t : .5 > t ? 2 * t : 2 * (1 - t);
			return 1 === i ? s *= s : 2 === i ? s *= s * s : 3 === i ? s *= s * s * s : 4 === i && (s *= s * s * s * s), 1 === e ? 1 - s : 2 === e ? s : .5 > t ? s / 2 : 1 - s / 2
		}, s = [ "Linear", "Quad", "Cubic", "Quart", "Quint,Strong" ], r = s.length; --r > -1; )n = s[ r ] + ",Power" + r, w( new T( null, null, 1, r ), n, "easeOut", !0 ), w( new T( null, null, 2, r ), n, "easeIn" + (0 === r ? ",easeNone" : "") ), w( new T( null, null, 3, r ), n, "easeInOut" );
		x.linear = l.easing.Linear.easeIn, x.swing = l.easing.Quad.easeInOut;
		var b = g( "events.EventDispatcher", function( t )
		{
			this._listeners = {}, this._eventTarget = t || this
		} );
		n = b.prototype, n.addEventListener = function( t, e, i, s, r )
		{
			r = r || 0;
			var n, h, l = this._listeners[ t ], _ = 0;
			for( null == l && (this._listeners[ t ] = l = []), h = l.length; --h > -1; )n = l[ h ], n.c === e && n.s === i ? l.splice( h, 1 ) : 0 === _ && r > n.pr && (_ = h + 1);
			l.splice( _, 0, { c: e, s: i, up: s, pr: r } ), this !== a || o || a.wake()
		}, n.removeEventListener = function( t, e )
		{
			var i, s = this._listeners[ t ];
			if( s )for( i = s.length; --i > -1; )if( s[ i ].c === e )return s.splice( i, 1 ), void 0
		}, n.dispatchEvent = function( t )
		{
			var e, i, s, r = this._listeners[ t ];
			if( r )for( e = r.length, i = this._eventTarget; --e > -1; )s = r[ e ], s && (s.up ? s.c.call( s.s || i, {
				type: t,
				target: i
			} ) : s.c.call( s.s || i ))
		};
		var P = t.requestAnimationFrame, k = t.cancelAnimationFrame, S = Date.now || function()
			{
				return (new Date).getTime()
			}, R = S();
		for( s = [ "ms", "moz", "webkit", "o" ], r = s.length; --r > -1 && !P; )P = t[ s[ r ] + "RequestAnimationFrame" ], k = t[ s[ r ] + "CancelAnimationFrame" ] || t[ s[ r ] + "CancelRequestAnimationFrame" ];
		g( "Ticker", function( t, e )
		{
			var i, s, r, n, h, l = this, u = S(), f = e !== !1 && P, p = 500, m = 33, d = "tick", g = function( t )
			{
				var e, a, o = S() - R;
				o > p && (u += o - m), R += o, l.time = (R - u) / 1e3, e = l.time - h, (!i || e > 0 || t === !0) && (l.frame++, h += e + (e >= n ? .004 : n - e), a = !0), t !== !0 && (r = s( g )), a && l.dispatchEvent( d )
			};
			b.call( l ), l.time = l.frame = 0, l.tick = function()
			{
				g( !0 )
			}, l.lagSmoothing = function( t, e )
			{
				p = t || 1 / _, m = Math.min( e, p, 0 )
			}, l.sleep = function()
			{
				null != r && (f && k ? k( r ) : clearTimeout( r ), s = c, r = null, l === a && (o = !1))
			}, l.wake = function()
			{
				null !== r ? l.sleep() : l.frame > 10 && (R = S() - p + 5), s = 0 === i ? c : f && P ? P : function( t )
				{
					return setTimeout( t, 0 | 1e3 * (h - l.time) + 1 )
				}, l === a && (o = !0), g( 2 )
			}, l.fps = function( t )
			{
				return arguments.length ? (i = t, n = 1 / (i || 60), h = this.time + n, l.wake(), void 0) : i
			}, l.useRAF = function( t )
			{
				return arguments.length ? (l.sleep(), f = t, l.fps( i ), void 0) : f
			}, l.fps( t ), setTimeout( function()
			{
				f && 5 > l.frame && l.useRAF( !1 )
			}, 1500 )
		} ), n = l.Ticker.prototype = new l.events.EventDispatcher, n.constructor = l.Ticker;
		var O = g( "core.Animation", function( t, e )
		{
			if( this.vars = e = e || {}, this._duration = this._totalDuration = t || 0, this._delay = Number( e.delay ) || 0, this._timeScale = 1, this._active = e.immediateRender === !0, this.data = e.data, this._reversed = e.reversed === !0, U )
			{
				o || a.wake();
				var i = this.vars.useFrames ? j : U;
				i.add( this, i._time ), this.vars.paused && this.paused( !0 )
			}
		} );
		a = O.ticker = new l.Ticker, n = O.prototype, n._dirty = n._gc = n._initted = n._paused = !1, n._totalTime = n._time = 0, n._rawPrevTime = -1, n._next = n._last = n._onUpdate = n._timeline = n.timeline = null, n._paused = !1;
		var A = function()
		{
			o && S() - R > 2e3 && a.wake(), setTimeout( A, 2e3 )
		};
		A(), n.play = function( t, e )
		{
			return null != t && this.seek( t, e ), this.reversed( !1 ).paused( !1 )
		}, n.pause = function( t, e )
		{
			return null != t && this.seek( t, e ), this.paused( !0 )
		}, n.resume = function( t, e )
		{
			return null != t && this.seek( t, e ), this.paused( !1 )
		}, n.seek = function( t, e )
		{
			return this.totalTime( Number( t ), e !== !1 )
		}, n.restart = function( t, e )
		{
			return this.reversed( !1 ).paused( !1 ).totalTime( t ? -this._delay : 0, e !== !1, !0 )
		}, n.reverse = function( t, e )
		{
			return null != t && this.seek( t || this.totalDuration(), e ), this.reversed( !0 ).paused( !1 )
		}, n.render = function()
		{
		}, n.invalidate = function()
		{
			return this._time = this._totalTime = 0, this._initted = this._gc = !1, this._rawPrevTime = -1, (this._gc || !this.timeline) && this._enabled( !0 ), this
		}, n.isActive = function()
		{
			var t, e = this._timeline, i = this._startTime;
			return !e || !this._gc && !this._paused && e.isActive() && (t = e.rawTime()) >= i && i + this.totalDuration() / this._timeScale > t
		}, n._enabled = function( t, e )
		{
			return o || a.wake(), this._gc = !t, this._active = this.isActive(), e !== !0 && (t && !this.timeline ? this._timeline.add( this, this._startTime - this._delay ) : !t && this.timeline && this._timeline._remove( this, !0 )), !1
		}, n._kill = function()
		{
			return this._enabled( !1, !1 )
		}, n.kill = function( t, e )
		{
			return this._kill( t, e ), this
		}, n._uncache = function( t )
		{
			for( var e = t ? this : this.timeline; e; )e._dirty = !0, e = e.timeline;
			return this
		}, n._swapSelfInParams = function( t )
		{
			for( var e = t.length, i = t.concat(); --e > -1; )"{self}" === t[ e ] && (i[ e ] = this);
			return i
		}, n._callback = function( t )
		{
			var e = this.vars;
			e[ t ].apply( e[ t + "Scope" ] || e.callbackScope || this, e[ t + "Params" ] || y )
		}, n.eventCallback = function( t, e, i, s )
		{
			if( "on" === (t || "").substr( 0, 2 ) )
			{
				var r = this.vars;
				if( 1 === arguments.length )return r[ t ];
				null == e ? delete r[ t ] : (r[ t ] = e, r[ t + "Params" ] = f( i ) && -1 !== i.join( "" ).indexOf( "{self}" ) ? this._swapSelfInParams( i ) : i, r[ t + "Scope" ] = s), "onUpdate" === t && (this._onUpdate = e)
			}
			return this
		}, n.delay = function( t )
		{
			return arguments.length ? (this._timeline.smoothChildTiming && this.startTime( this._startTime + t - this._delay ), this._delay = t, this) : this._delay
		}, n.duration = function( t )
		{
			return arguments.length ? (this._duration = this._totalDuration = t, this._uncache( !0 ), this._timeline.smoothChildTiming && this._time > 0 && this._time < this._duration && 0 !== t && this.totalTime( this._totalTime * (t / this._duration), !0 ), this) : (this._dirty = !1, this._duration)
		}, n.totalDuration = function( t )
		{
			return this._dirty = !1, arguments.length ? this.duration( t ) : this._totalDuration
		}, n.time = function( t, e )
		{
			return arguments.length ? (this._dirty && this.totalDuration(), this.totalTime( t > this._duration ? this._duration : t, e )) : this._time
		}, n.totalTime = function( t, e, i )
		{
			if( o || a.wake(), !arguments.length )return this._totalTime;
			if( this._timeline )
			{
				if( 0 > t && !i && (t += this.totalDuration()), this._timeline.smoothChildTiming )
				{
					this._dirty && this.totalDuration();
					var s = this._totalDuration, r = this._timeline;
					if( t > s && !i && (t = s), this._startTime = (this._paused ? this._pauseTime : r._time) - (this._reversed ? s - t : t) / this._timeScale, r._dirty || this._uncache( !1 ), r._timeline )for( ; r._timeline; )r._timeline._time !== (r._startTime + r._totalTime) / r._timeScale && r.totalTime( r._totalTime, !0 ), r = r._timeline
				}
				this._gc && this._enabled( !0, !1 ), (this._totalTime !== t || 0 === this._duration) && (this.render( t, e, !1 ), I.length && V())
			}
			return this
		}, n.progress = n.totalProgress = function( t, e )
		{
			return arguments.length ? this.totalTime( this.duration() * t, e ) : this._time / this.duration()
		}, n.startTime = function( t )
		{
			return arguments.length ? (t !== this._startTime && (this._startTime = t, this.timeline && this.timeline._sortChildren && this.timeline.add( this, t - this._delay )), this) : this._startTime
		}, n.endTime = function( t )
		{
			return this._startTime + (0 != t ? this.totalDuration() : this.duration()) / this._timeScale
		}, n.timeScale = function( t )
		{
			if( !arguments.length )return this._timeScale;
			if( t = t || _, this._timeline && this._timeline.smoothChildTiming )
			{
				var e = this._pauseTime, i = e || 0 === e ? e : this._timeline.totalTime();
				this._startTime = i - (i - this._startTime) * this._timeScale / t
			}
			return this._timeScale = t, this._uncache( !1 )
		}, n.reversed = function( t )
		{
			return arguments.length ? (t != this._reversed && (this._reversed = t, this.totalTime( this._timeline && !this._timeline.smoothChildTiming ? this.totalDuration() - this._totalTime : this._totalTime, !0 )), this) : this._reversed
		}, n.paused = function( t )
		{
			if( !arguments.length )return this._paused;
			var e, i, s = this._timeline;
			return t != this._paused && s && (o || t || a.wake(), e = s.rawTime(), i = e - this._pauseTime, !t && s.smoothChildTiming && (this._startTime += i, this._uncache( !1 )), this._pauseTime = t ? e : null, this._paused = t, this._active = this.isActive(), !t && 0 !== i && this._initted && this.duration() && this.render( s.smoothChildTiming ? this._totalTime : (e - this._startTime) / this._timeScale, !0, !0 )), this._gc && !t && this._enabled( !0, !1 ), this
		};
		var C = g( "core.SimpleTimeline", function( t )
		{
			O.call( this, 0, t ), this.autoRemoveChildren = this.smoothChildTiming = !0
		} );
		n = C.prototype = new O, n.constructor = C, n.kill()._gc = !1, n._first = n._last = n._recent = null, n._sortChildren = !1, n.add = n.insert = function( t, e )
		{
			var i, s;
			if( t._startTime = Number( e || 0 ) + t._delay, t._paused && this !== t._timeline && (t._pauseTime = t._startTime + (this.rawTime() - t._startTime) / t._timeScale), t.timeline && t.timeline._remove( t, !0 ), t.timeline = t._timeline = this, t._gc && t._enabled( !0, !0 ), i = this._last, this._sortChildren )for( s = t._startTime; i && i._startTime > s; )i = i._prev;
			return i ? (t._next = i._next, i._next = t) : (t._next = this._first, this._first = t), t._next ? t._next._prev = t : this._last = t, t._prev = i, this._recent = t, this._timeline && this._uncache( !0 ), this
		}, n._remove = function( t, e )
		{
			return t.timeline === this && (e || t._enabled( !1, !0 ), t._prev ? t._prev._next = t._next : this._first === t && (this._first = t._next), t._next ? t._next._prev = t._prev : this._last === t && (this._last = t._prev), t._next = t._prev = t.timeline = null, t === this._recent && (this._recent = this._last), this._timeline && this._uncache( !0 )), this
		}, n.render = function( t, e, i )
		{
			var s, r = this._first;
			for( this._totalTime = this._time = this._rawPrevTime = t; r; )s = r._next, (r._active || t >= r._startTime && !r._paused) && (r._reversed ? r.render( (r._dirty ? r.totalDuration() : r._totalDuration) - (t - r._startTime) * r._timeScale, e, i ) : r.render( (t - r._startTime) * r._timeScale, e, i )), r = s
		}, n.rawTime = function()
		{
			return o || a.wake(), this._totalTime
		};
		var D = g( "TweenLite", function( e, i, s )
		{
			if( O.call( this, i, s ), this.render = D.prototype.render, null == e )throw"Cannot tween a null target.";
			this.target = e = "string" != typeof e ? e : D.selector( e ) || e;
			var r, n, a, o = e.jquery || e.length && e !== t && e[ 0 ] && (e[ 0 ] === t || e[ 0 ].nodeType && e[ 0 ].style && !e.nodeType), h = this.vars.overwrite;
			if( this._overwrite = h = null == h ? Y[ D.defaultOverwrite ] : "number" == typeof h ? h >> 0 : Y[ h ], (o || e instanceof Array || e.push && f( e )) && "number" != typeof e[ 0 ] )for( this._targets = a = u( e ), this._propLookup = [], this._siblings = [], r = 0; a.length > r; r++ )n = a[ r ], n ? "string" != typeof n ? n.length && n !== t && n[ 0 ] && (n[ 0 ] === t || n[ 0 ].nodeType && n[ 0 ].style && !n.nodeType) ? (a.splice( r--, 1 ), this._targets = a = a.concat( u( n ) )) : (this._siblings[ r ] = G( n, this, !1 ), 1 === h && this._siblings[ r ].length > 1 && Z( n, this, null, 1, this._siblings[ r ] )) : (n = a[ r-- ] = D.selector( n ), "string" == typeof n && a.splice( r + 1, 1 )) : a.splice( r--, 1 );
			else this._propLookup = {}, this._siblings = G( e, this, !1 ), 1 === h && this._siblings.length > 1 && Z( e, this, null, 1, this._siblings );
			(this.vars.immediateRender || 0 === i && 0 === this._delay && this.vars.immediateRender !== !1) && (this._time = -_, this.render( -this._delay ))
		}, !0 ), M = function( e )
		{
			return e && e.length && e !== t && e[ 0 ] && (e[ 0 ] === t || e[ 0 ].nodeType && e[ 0 ].style && !e.nodeType)
		}, z = function( t, e )
		{
			var i, s = {};
			for( i in t )B[ i ] || i in e && "transform" !== i && "x" !== i && "y" !== i && "width" !== i && "height" !== i && "className" !== i && "border" !== i || !(!E[ i ] || E[ i ] && E[ i ]._autoCSS) || (s[ i ] = t[ i ], delete t[ i ]);
			t.css = s
		};
		n = D.prototype = new O, n.constructor = D, n.kill()._gc = !1, n.ratio = 0, n._firstPT = n._targets = n._overwrittenProps = n._startAt = null, n._notifyPluginsOfEnabled = n._lazy = !1, D.version = "1.17.0", D.defaultEase = n._ease = new T( null, null, 1, 1 ), D.defaultOverwrite = "auto", D.ticker = a, D.autoSleep = 120, D.lagSmoothing = function( t, e )
		{
			a.lagSmoothing( t, e )
		}, D.selector = t.$ || t.jQuery || function( e )
			{
				var i = t.$ || t.jQuery;
				return i ? (D.selector = i, i( e )) : "undefined" == typeof document ? e : document.querySelectorAll ? document.querySelectorAll( e ) : document.getElementById( "#" === e.charAt( 0 ) ? e.substr( 1 ) : e )
			};
		var I = [], F = {}, N = D._internals = {
			isArray: f,
			isSelector: M,
			lazyTweens: I
		}, E = D._plugins = {}, L = N.tweenLookup = {}, X = 0, B = N.reservedProps = {
			ease: 1,
			delay: 1,
			overwrite: 1,
			onComplete: 1,
			onCompleteParams: 1,
			onCompleteScope: 1,
			useFrames: 1,
			runBackwards: 1,
			startAt: 1,
			onUpdate: 1,
			onUpdateParams: 1,
			onUpdateScope: 1,
			onStart: 1,
			onStartParams: 1,
			onStartScope: 1,
			onReverseComplete: 1,
			onReverseCompleteParams: 1,
			onReverseCompleteScope: 1,
			onRepeat: 1,
			onRepeatParams: 1,
			onRepeatScope: 1,
			easeParams: 1,
			yoyo: 1,
			immediateRender: 1,
			repeat: 1,
			repeatDelay: 1,
			data: 1,
			paused: 1,
			reversed: 1,
			autoCSS: 1,
			lazy: 1,
			onOverwrite: 1,
			callbackScope: 1
		}, Y = {
			none: 0,
			all: 1,
			auto: 2,
			concurrent: 3,
			allOnStart: 4,
			preexisting: 5,
			"true": 1,
			"false": 0
		}, j = O._rootFramesTimeline = new C, U = O._rootTimeline = new C, q = 30, V = N.lazyRender = function()
		{
			var t, e = I.length;
			for( F = {}; --e > -1; )t = I[ e ], t && t._lazy !== !1 && (t.render( t._lazy[ 0 ], t._lazy[ 1 ], !0 ), t._lazy = !1);
			I.length = 0
		};
		U._startTime = a.time, j._startTime = a.frame, U._active = j._active = !0, setTimeout( V, 1 ), O._updateRoot = D.render = function()
		{
			var t, e, i;
			if( I.length && V(), U.render( (a.time - U._startTime) * U._timeScale, !1, !1 ), j.render( (a.frame - j._startTime) * j._timeScale, !1, !1 ), I.length && V(), a.frame >= q )
			{
				q = a.frame + (parseInt( D.autoSleep, 10 ) || 120);
				for( i in L )
				{
					for( e = L[ i ].tweens, t = e.length; --t > -1; )e[ t ]._gc && e.splice( t, 1 );
					0 === e.length && delete L[ i ]
				}
				if( i = U._first, (!i || i._paused) && D.autoSleep && !j._first && 1 === a._listeners.tick.length )
				{
					for( ; i && i._paused; )i = i._next;
					i || a.sleep()
				}
			}
		}, a.addEventListener( "tick", O._updateRoot );
		var G = function( t, e, i )
		{
			var s, r, n = t._gsTweenID;
			if( L[ n || (t._gsTweenID = n = "t" + X++) ] || (L[ n ] = {
					target: t,
					tweens: []
				}), e && (s = L[ n ].tweens, s[ r = s.length ] = e, i) )for( ; --r > -1; )s[ r ] === e && s.splice( r, 1 );
			return L[ n ].tweens
		}, W = function( t, e, i, s )
		{
			var r, n, a = t.vars.onOverwrite;
			return a && (r = a( t, e, i, s )), a = D.onOverwrite, a && (n = a( t, e, i, s )), r !== !1 && n !== !1
		}, Z = function( t, e, i, s, r )
		{
			var n, a, o, h;
			if( 1 === s || s >= 4 )
			{
				for( h = r.length, n = 0; h > n; n++ )if( (o = r[ n ]) !== e )o._gc || o._kill( null, t, e ) && (a = !0);
				else
					if( 5 === s )break;
				return a
			}
			var l, u = e._startTime + _, c = [], f = 0, p = 0 === e._duration;
			for( n = r.length; --n > -1; )(o = r[ n ]) === e || o._gc || o._paused || (o._timeline !== e._timeline ? (l = l || Q( e, 0, p ), 0 === Q( o, l, p ) && (c[ f++ ] = o)) : u >= o._startTime && o._startTime + o.totalDuration() / o._timeScale > u && ((p || !o._initted) && 2e-10 >= u - o._startTime || (c[ f++ ] = o)));
			for( n = f; --n > -1; )if( o = c[ n ], 2 === s && o._kill( i, t, e ) && (a = !0), 2 !== s || !o._firstPT && o._initted )
			{
				if( 2 !== s && !W( o, e ) )continue;
				o._enabled( !1, !1 ) && (a = !0)
			}
			return a
		}, Q = function( t, e, i )
		{
			for( var s = t._timeline, r = s._timeScale, n = t._startTime; s._timeline; )
			{
				if( n += s._startTime, r *= s._timeScale, s._paused )return -100;
				s = s._timeline
			}
			return n /= r, n > e ? n - e : i && n === e || !t._initted && 2 * _ > n - e ? _ : (n += t.totalDuration() / t._timeScale / r) > e + _ ? 0 : n - e - _
		};
		n._init = function()
		{
			var t, e, i, s, r, n = this.vars, a = this._overwrittenProps, o = this._duration, h = !!n.immediateRender, l = n.ease;
			if( n.startAt )
			{
				this._startAt && (this._startAt.render( -1, !0 ), this._startAt.kill()), r = {};
				for( s in n.startAt )r[ s ] = n.startAt[ s ];
				if( r.overwrite = !1, r.immediateRender = !0, r.lazy = h && n.lazy !== !1, r.startAt = r.delay = null, this._startAt = D.to( this.target, 0, r ), h )if( this._time > 0 )this._startAt = null;
				else
					if( 0 !== o )return
			}
			else
				if( n.runBackwards && 0 !== o )if( this._startAt )this._startAt.render( -1, !0 ), this._startAt.kill(), this._startAt = null;
				else
				{
					0 !== this._time && (h = !1), i = {};
					for( s in n )B[ s ] && "autoCSS" !== s || (i[ s ] = n[ s ]);
					if( i.overwrite = 0, i.data = "isFromStart", i.lazy = h && n.lazy !== !1, i.immediateRender = h, this._startAt = D.to( this.target, 0, i ), h )
					{
						if( 0 === this._time )return
					}
					else this._startAt._init(), this._startAt._enabled( !1 ), this.vars.immediateRender && (this._startAt = null)
				}
			if( this._ease = l = l ? l instanceof T ? l : "function" == typeof l ? new T( l, n.easeParams ) : x[ l ] || D.defaultEase : D.defaultEase, n.easeParams instanceof Array && l.config && (this._ease = l.config.apply( l, n.easeParams )), this._easeType = this._ease._type, this._easePower = this._ease._power, this._firstPT = null, this._targets )for( t = this._targets.length; --t > -1; )this._initProps( this._targets[ t ], this._propLookup[ t ] = {}, this._siblings[ t ], a ? a[ t ] : null ) && (e = !0);
			else e = this._initProps( this.target, this._propLookup, this._siblings, a );
			if( e && D._onPluginEvent( "_onInitAllProps", this ), a && (this._firstPT || "function" != typeof this.target && this._enabled( !1, !1 )), n.runBackwards )for( i = this._firstPT; i; )i.s += i.c, i.c = -i.c, i = i._next;
			this._onUpdate = n.onUpdate, this._initted = !0
		}, n._initProps = function( e, i, s, r )
		{
			var n, a, o, h, l, _;
			if( null == e )return !1;
			F[ e._gsTweenID ] && V(), this.vars.css || e.style && e !== t && e.nodeType && E.css && this.vars.autoCSS !== !1 && z( this.vars, e );
			for( n in this.vars )
			{
				if( _ = this.vars[ n ], B[ n ] )_ && (_ instanceof Array || _.push && f( _ )) && -1 !== _.join( "" ).indexOf( "{self}" ) && (this.vars[ n ] = _ = this._swapSelfInParams( _, this ));
				else
					if( E[ n ] && (h = new E[ n ])._onInitTween( e, this.vars[ n ], this ) )
					{
						for( this._firstPT = l = {
							_next: this._firstPT,
							t: h,
							p: "setRatio",
							s: 0,
							c: 1,
							f: !0,
							n: n,
							pg: !0,
							pr: h._priority
						}, a = h._overwriteProps.length; --a > -1; )i[ h._overwriteProps[ a ] ] = this._firstPT;
						(h._priority || h._onInitAllProps) && (o = !0), (h._onDisable || h._onEnable) && (this._notifyPluginsOfEnabled = !0)
					}
					else this._firstPT = i[ n ] = l = {
						_next: this._firstPT,
						t: e,
						p: n,
						f: "function" == typeof e[ n ],
						n: n,
						pg: !1,
						pr: 0
					}, l.s = l.f ? e[ n.indexOf( "set" ) || "function" != typeof e[ "get" + n.substr( 3 ) ] ? n : "get" + n.substr( 3 ) ]() : parseFloat( e[ n ] ), l.c = "string" == typeof _ && "=" === _.charAt( 1 ) ? parseInt( _.charAt( 0 ) + "1", 10 ) * Number( _.substr( 2 ) ) : Number( _ ) - l.s || 0;
				l && l._next && (l._next._prev = l)
			}
			return r && this._kill( r, e ) ? this._initProps( e, i, s, r ) : this._overwrite > 1 && this._firstPT && s.length > 1 && Z( e, this, i, this._overwrite, s ) ? (this._kill( i, e ), this._initProps( e, i, s, r )) : (this._firstPT && (this.vars.lazy !== !1 && this._duration || this.vars.lazy && !this._duration) && (F[ e._gsTweenID ] = !0), o)
		}, n.render = function( t, e, i )
		{
			var s, r, n, a, o = this._time, h = this._duration, l = this._rawPrevTime;
			if( t >= h )this._totalTime = this._time = h, this.ratio = this._ease._calcEnd ? this._ease.getRatio( 1 ) : 1, this._reversed || (s = !0, r = "onComplete", i = i || this._timeline.autoRemoveChildren), 0 === h && (this._initted || !this.vars.lazy || i) && (this._startTime === this._timeline._duration && (t = 0), (0 === t || 0 > l || l === _ && "isPause" !== this.data) && l !== t && (i = !0, l > _ && (r = "onReverseComplete")), this._rawPrevTime = a = !e || t || l === t ? t : _);
			else
				if( 1e-7 > t )this._totalTime = this._time = 0, this.ratio = this._ease._calcEnd ? this._ease.getRatio( 0 ) : 0, (0 !== o || 0 === h && l > 0) && (r = "onReverseComplete", s = this._reversed), 0 > t && (this._active = !1, 0 === h && (this._initted || !this.vars.lazy || i) && (l >= 0 && (l !== _ || "isPause" !== this.data) && (i = !0), this._rawPrevTime = a = !e || t || l === t ? t : _)), this._initted || (i = !0);
				else
					if( this._totalTime = this._time = t, this._easeType )
					{
						var u = t / h, c = this._easeType, f = this._easePower;
						(1 === c || 3 === c && u >= .5) && (u = 1 - u), 3 === c && (u *= 2), 1 === f ? u *= u : 2 === f ? u *= u * u : 3 === f ? u *= u * u * u : 4 === f && (u *= u * u * u * u), this.ratio = 1 === c ? 1 - u : 2 === c ? u : .5 > t / h ? u / 2 : 1 - u / 2
					}
					else this.ratio = this._ease.getRatio( t / h );
			if( this._time !== o || i )
			{
				if( !this._initted )
				{
					if( this._init(), !this._initted || this._gc )return;
					if( !i && this._firstPT && (this.vars.lazy !== !1 && this._duration || this.vars.lazy && !this._duration) )return this._time = this._totalTime = o, this._rawPrevTime = l, I.push( this ), this._lazy = [ t, e ], void 0;
					this._time && !s ? this.ratio = this._ease.getRatio( this._time / h ) : s && this._ease._calcEnd && (this.ratio = this._ease.getRatio( 0 === this._time ? 0 : 1 ))
				}
				for( this._lazy !== !1 && (this._lazy = !1), this._active || !this._paused && this._time !== o && t >= 0 && (this._active = !0), 0 === o && (this._startAt && (t >= 0 ? this._startAt.render( t, e, i ) : r || (r = "_dummyGS")), this.vars.onStart && (0 !== this._time || 0 === h) && (e || this._callback( "onStart" ))), n = this._firstPT; n; )n.f ? n.t[ n.p ]( n.c * this.ratio + n.s ) : n.t[ n.p ] = n.c * this.ratio + n.s, n = n._next;
				this._onUpdate && (0 > t && this._startAt && t !== -1e-4 && this._startAt.render( t, e, i ), e || (this._time !== o || s) && this._callback( "onUpdate" )), r && (!this._gc || i) && (0 > t && this._startAt && !this._onUpdate && t !== -1e-4 && this._startAt.render( t, e, i ), s && (this._timeline.autoRemoveChildren && this._enabled( !1, !1 ), this._active = !1), !e && this.vars[ r ] && this._callback( r ), 0 === h && this._rawPrevTime === _ && a !== _ && (this._rawPrevTime = 0))
			}
		}, n._kill = function( t, e, i )
		{
			if( "all" === t && (t = null), null == t && (null == e || e === this.target) )return this._lazy = !1, this._enabled( !1, !1 );
			e = "string" != typeof e ? e || this._targets || this.target : D.selector( e ) || e;
			var s, r, n, a, o, h, l, _, u, c = i && this._time && i._startTime === this._startTime && this._timeline === i._timeline;
			if( (f( e ) || M( e )) && "number" != typeof e[ 0 ] )for( s = e.length; --s > -1; )this._kill( t, e[ s ], i ) && (h = !0);
			else
			{
				if( this._targets )
				{
					for( s = this._targets.length; --s > -1; )if( e === this._targets[ s ] )
					{
						o = this._propLookup[ s ] || {}, this._overwrittenProps = this._overwrittenProps || [], r = this._overwrittenProps[ s ] = t ? this._overwrittenProps[ s ] || {} : "all";
						break
					}
				}
				else
				{
					if( e !== this.target )return !1;
					o = this._propLookup, r = this._overwrittenProps = t ? this._overwrittenProps || {} : "all"
				}
				if( o )
				{
					if( l = t || o, _ = t !== r && "all" !== r && t !== o && ("object" != typeof t || !t._tempKill), i && (D.onOverwrite || this.vars.onOverwrite) )
					{
						for( n in l )o[ n ] && (u || (u = []), u.push( n ));
						if( (u || !t) && !W( this, i, e, u ) )return !1
					}
					for( n in l )(a = o[ n ]) && (c && (a.f ? a.t[ a.p ]( a.s ) : a.t[ a.p ] = a.s, h = !0), a.pg && a.t._kill( l ) && (h = !0), a.pg && 0 !== a.t._overwriteProps.length || (a._prev ? a._prev._next = a._next : a === this._firstPT && (this._firstPT = a._next), a._next && (a._next._prev = a._prev), a._next = a._prev = null), delete o[ n ]), _ && (r[ n ] = 1);
					!this._firstPT && this._initted && this._enabled( !1, !1 )
				}
			}
			return h
		}, n.invalidate = function()
		{
			return this._notifyPluginsOfEnabled && D._onPluginEvent( "_onDisable", this ), this._firstPT = this._overwrittenProps = this._startAt = this._onUpdate = null, this._notifyPluginsOfEnabled = this._active = this._lazy = !1, this._propLookup = this._targets ? {} : [], O.prototype.invalidate.call( this ), this.vars.immediateRender && (this._time = -_, this.render( -this._delay )), this
		}, n._enabled = function( t, e )
		{
			if( o || a.wake(), t && this._gc )
			{
				var i, s = this._targets;
				if( s )for( i = s.length; --i > -1; )this._siblings[ i ] = G( s[ i ], this, !0 );
				else this._siblings = G( this.target, this, !0 )
			}
			return O.prototype._enabled.call( this, t, e ), this._notifyPluginsOfEnabled && this._firstPT ? D._onPluginEvent( t ? "_onEnable" : "_onDisable", this ) : !1
		}, D.to = function( t, e, i )
		{
			return new D( t, e, i )
		}, D.from = function( t, e, i )
		{
			return i.runBackwards = !0, i.immediateRender = 0 != i.immediateRender, new D( t, e, i )
		}, D.fromTo = function( t, e, i, s )
		{
			return s.startAt = i, s.immediateRender = 0 != s.immediateRender && 0 != i.immediateRender, new D( t, e, s )
		}, D.delayedCall = function( t, e, i, s, r )
		{
			return new D( e, 0, {
				delay: t,
				onComplete: e,
				onCompleteParams: i,
				callbackScope: s,
				onReverseComplete: e,
				onReverseCompleteParams: i,
				immediateRender: !1,
				lazy: !1,
				useFrames: r,
				overwrite: 0
			} )
		}, D.set = function( t, e )
		{
			return new D( t, 0, e )
		}, D.getTweensOf = function( t, e )
		{
			if( null == t )return [];
			t = "string" != typeof t ? t : D.selector( t ) || t;
			var i, s, r, n;
			if( (f( t ) || M( t )) && "number" != typeof t[ 0 ] )
			{
				for( i = t.length, s = []; --i > -1; )s = s.concat( D.getTweensOf( t[ i ], e ) );
				for( i = s.length; --i > -1; )for( n = s[ i ], r = i; --r > -1; )n === s[ r ] && s.splice( i, 1 )
			}
			else for( s = G( t ).concat(), i = s.length; --i > -1; )(s[ i ]._gc || e && !s[ i ].isActive()) && s.splice( i, 1 );
			return s
		}, D.killTweensOf = D.killDelayedCallsTo = function( t, e, i )
		{
			"object" == typeof e && (i = e, e = !1);
			for( var s = D.getTweensOf( t, e ), r = s.length; --r > -1; )s[ r ]._kill( i, t )
		};
		var $ = g( "plugins.TweenPlugin", function( t, e )
		{
			this._overwriteProps = (t || "").split( "," ), this._propName = this._overwriteProps[ 0 ], this._priority = e || 0, this._super = $.prototype
		}, !0 );
		if( n = $.prototype, $.version = "1.10.1", $.API = 2, n._firstPT = null, n._addTween = function( t, e, i, s, r, n )
			{
				var a, o;
				return null != s && (a = "number" == typeof s || "=" !== s.charAt( 1 ) ? Number( s ) - Number( i ) : parseInt( s.charAt( 0 ) + "1", 10 ) * Number( s.substr( 2 ) )) ? (this._firstPT = o = {
					_next: this._firstPT,
					t: t,
					p: e,
					s: i,
					c: a,
					f: "function" == typeof t[ e ],
					n: r || e,
					r: n
				}, o._next && (o._next._prev = o), o) : void 0
			}, n.setRatio = function( t )
			{
				for( var e, i = this._firstPT, s = 1e-6; i; )e = i.c * t + i.s, i.r ? e = Math.round( e ) : s > e && e > -s && (e = 0), i.f ? i.t[ i.p ]( e ) : i.t[ i.p ] = e, i = i._next
			}, n._kill = function( t )
			{
				var e, i = this._overwriteProps, s = this._firstPT;
				if( null != t[ this._propName ] )this._overwriteProps = [];
				else for( e = i.length; --e > -1; )null != t[ i[ e ] ] && i.splice( e, 1 );
				for( ; s; )null != t[ s.n ] && (s._next && (s._next._prev = s._prev), s._prev ? (s._prev._next = s._next, s._prev = null) : this._firstPT === s && (this._firstPT = s._next)), s = s._next;
				return !1
			}, n._roundProps = function( t, e )
			{
				for( var i = this._firstPT; i; )(t[ this._propName ] || null != i.n && t[ i.n.split( this._propName + "_" ).join( "" ) ]) && (i.r = e), i = i._next
			}, D._onPluginEvent = function( t, e )
			{
				var i, s, r, n, a, o = e._firstPT;
				if( "_onInitAllProps" === t )
				{
					for( ; o; )
					{
						for( a = o._next, s = r; s && s.pr > o.pr; )s = s._next;
						(o._prev = s ? s._prev : n) ? o._prev._next = o : r = o, (o._next = s) ? s._prev = o : n = o, o = a
					}
					o = e._firstPT = r
				}
				for( ; o; )o.pg && "function" == typeof o.t[ t ] && o.t[ t ]() && (i = !0), o = o._next;
				return i
			}, $.activate = function( t )
			{
				for( var e = t.length; --e > -1; )t[ e ].API === $.API && (E[ (new t[ e ])._propName ] = t[ e ]);
				return !0
			}, d.plugin = function( t )
			{
				if( !(t && t.propName && t.init && t.API) )throw"illegal plugin definition.";
				var e, i = t.propName, s = t.priority || 0, r = t.overwriteProps, n = {
					init: "_onInitTween",
					set: "setRatio",
					kill: "_kill",
					round: "_roundProps",
					initAll: "_onInitAllProps"
				}, a = g( "plugins." + i.charAt( 0 ).toUpperCase() + i.substr( 1 ) + "Plugin", function()
				{
					$.call( this, i, s ), this._overwriteProps = r || []
				}, t.global === !0 ), o = a.prototype = new $( i );
				o.constructor = a, a.API = t.API;
				for( e in n )"function" == typeof t[ e ] && (o[ n[ e ] ] = t[ e ]);
				return a.version = t.version, $.activate( [ a ] ), a
			}, s = t._gsQueue )
		{
			for( r = 0; s.length > r; r++ )s[ r ]();
			for( n in p )p[ n ].func || t.console.log( "GSAP encountered missing dependency: com.greensock." + n )
		}
		o = !1
	}
}( "undefined" != typeof module && module.exports && "undefined" != typeof global ? global : this || window, "TweenMax" );

(function( $ )
{
	"use strict";
	$( function()
	{

		var $subsharewrap = $( '.com-subshare' );
		var $subsharebtn = $( '.com-subshare-btn button' );
		var $subsharelist = $( '.com-subshare-list' );
		var $subsharelistlnk = $subsharelist.find( 'a' );
		var oldview;

		$subsharebtn.on( 'click', function( e )
		{
			e.preventDefault();
			$( this ).toggleClass( 'show' );
			$( this ).siblings( 'button' ).toggleClass( 'show' ).focus();
			$subsharelist.toggleClass( 'show' ).css( 'width', $( 'body' ).width() );
		} );

		$subsharelistlnk.on( 'keydown', sharefocus );

		$( window ).on( 'resize', widthset );

		function widthset()
		{
			if( oldview == LAE.IS_VIEWTYPE ) return;
			$subsharelist.css( 'width', $( 'body' ).width() );
			$subsharewrap.find( '.share' ).addClass( 'show' );
			$subsharewrap.find( '.close' ).removeClass( 'show' );
			$subsharelist.removeClass( 'show' ).css( 'width', 'auto' );
			oldview = LAE.IS_VIEWTYPE;
		}

		function sharefocus( e )
		{
			if( LAE.IS_VIEWTYPE != 'mobile' ) return;
			var $this = $( this );
			var thisidx = $this.closest( 'li' ).index();
			var shareLen = $subsharelist.length;

			if( e.shiftKey && e.keyCode == 9 )
			{
			}
			else
				if( e.keyCode == 9 )
				{
					if( thisidx == shareLen )
					{
						e.preventDefault();
						$subsharewrap.find( '.share' ).addClass( 'show' ).focus();
						$subsharewrap.find( '.close' ).removeClass( 'show' );
						$subsharelist.removeClass( 'show' ).css( 'width', 'auto' );

					}
				}

		}

	} );
})( jQuery );
