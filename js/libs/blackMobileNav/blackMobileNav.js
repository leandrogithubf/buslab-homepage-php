//####################################################################
//               BLACK MOBILE NAV
// -----------------------------------------------------------------
//     Created by: BlackHeart-frt
//     date:       12-april-2021
//     email:      blackheart.frt@gmail.com
// -----------------------------------------------------------------
//
//              SETTINGS
// -----------------------------------------------------------------
//		breakpoint: 		{string}{css value + css unit}
//			'1023px'		
//		menuWidth: 			{string}{css value + css unit}
//			'100%'
//		buttonOpenMenu: 	{string}{css selector}
//			'[data-mobile-menu="open"]'
//		buttonCloseMenu: 	{string}{css selector}
//			'[data-mobile-menu="close"]'
//		mainNav: 			{string}{css selector}
//			'[data-mobile-menu="main-nav]'
//		mainNavAppendTo: 	{string}{css selector || html element}
//			'body'
//		iconOpen: 			{boolean}
//			true
//		iconOpenAppendTo: 	{string}{css selector}
//			$(this)			
//		iconOpenWidth: 		{string}{css value + css unit}
//			'40px'
//		iconOpenHeight: 	{string}{css value + css unit}
//			'auto'	
//
//              HTML BASE
// -----------------------------------------------------------------
//
//		all menu elements must be contained in the same parent element
//####################################################################

(function($){
	$.fn.blackMobileNav	=	function(options){
		let 	settings 		=	$.extend({
					breakpoint: 		'1023px',
					menuWidth: 			'100%',
					buttonOpenMenu:		'[data-mobile-menu="open"]',			
					buttonCloseMenu:	'[data-mobile-menu="close"]',			
					mainNav: 			'[data-mobile-menu="main-nav"]',
					mainNavAppendTo: 	'body',
					iconOpen: 			 true,
					iconOpenAppendTo: 	 $(this),			
					iconOpenWidth: 		'40px',
					iconOpenHeight: 	'auto'
		}, options);

		let 	deviceWidth 	= 	window.matchMedia('(max-device-width:' + settings.breakpoint + ')');

		const 	initBlackPlugin = 	function(){
			//hide menu mobile
			if($(settings.mainNav).css('display') != 'none'){
				$(settings.mainNav)
					.hide()
					.attr('data-mobile-menu-active', 'off');
			};
			//create overlay in DOM
			if($('.menu-mobile-overlay').length === 0){
				$('body').append('<div class="menu-mobile-overlay"></div>');
				$('.menu-mobile-overlay')
					.css({
						position: 			'absolute',
						top: 				'0',
						left: 				'0',
						width: 				'100vw',
						height: 			'100vh',				
						backgroundColor: 	'rgba(0,0,0,.75)',
						zIndex: 			'9998',
						display: 			'none'
					});

				};
			//append icon open
			if(settings.iconOpen === true && $(settings.buttonOpenMenu).length === 0){				
				$(settings.iconOpenAppendTo)
					.append('<svg data-mobile-menu="open" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 39 22"><defs/><g fill="#141c5c"><path d="M0 0h39v4H0zM0 9h39v4H0zM0 18h39v4H0z"/></g></svg>')
				$(settings.buttonOpenMenu).css({
					margin: 	'1rem',
					width: 		settings.iconOpenWidth,
					height: 	settings.iconOpenHeight
				});
			};
			//clone menu mobile
			if($(settings.mainNav).length === 1){
				$(settings.mainNav)
					.clone(true, true)
					.appendTo('.menu-mobile-overlay')
					.css({
						right: 		'-100vw',
						width: 		settings.menuWidth,
						padding: 	'1rem',
						boxSizing: 	'border-box'
					});

			};
			//create menu mobile close button
			if($(settings.buttonCloseMenu).length === 0){			
				$(settings.buttonOpenMenu)
					.clone(true, true)
					.prependTo(settings.mainNav)[1];

				$(settings.mainNav)
					.eq(1)
					.children(settings.buttonOpenMenu)
					.attr('data-mobile-menu', 'close')
					.css({
						alignSelf: 	'flex-end'
					});
			}
			//functions menu trigger open/close
			const 	openMenuMobile 	= 	function(){
				if($(settings.mainNav).eq(1).attr('data-mobile-menu-active') === 'off'){
					$('.menu-mobile-overlay').show();
					$(settings.mainNav)
						.eq(1)
						.css('display', 'flex')
						.animate({
							right: 		'0'
						})
						.attr('data-mobile-menu-active', 'on');
				};
			};
			const 	closeMenuMobile = 	function(){
				if($(settings.mainNav).eq(1).attr('data-mobile-menu-active') === 'on'){
					$(settings.mainNav)
						.eq(1)
						.animate({
							right: 		'-100vw'
						}, function(){
							$('.menu-mobile-overlay').hide();
						})
						.attr('data-mobile-menu-active', 'off');				
				};
			};
			//menu mobile trigger open
			$(settings.buttonOpenMenu).on('click', function(event){
				event.preventDefault();
				openMenuMobile();
			});
			//menu mobile trigger close
			$(settings.buttonCloseMenu).on('click', function(event){
				event.preventDefault();
				closeMenuMobile();
			});
			//menu mobile trigger close by link element
			$(settings.mainNav).on('click', 'a', function(){
				if($(this).attr('href') != "" || $(this).attr('href') != undefined){
					closeMenuMobile();
				};
			});

			//plugin message
			console.clear();
			console.info('Thank you for using the Black Mobile Nav plugin!');
			console.info('support: blackheart.frt@gmail.com');

			return this;
		};

		//call plugin if media querie true
		const 	testDeviceWidth 	= 	function(){
			if(deviceWidth.matches){					
				initBlackPlugin();
			}else{				
				$('.menu-mobile-overlay').remove();
				$(settings.buttonOpenMenu).remove();
				$(settings.mainNav)
					.eq(0)
					.css('display', 'flex');				
			};	
		}
		//attach event listener function on state changes
		deviceWidth.addListener(testDeviceWidth);
		//call after load page
		$(document).ready(function(){
			testDeviceWidth();
		})
	};
}(jQuery));