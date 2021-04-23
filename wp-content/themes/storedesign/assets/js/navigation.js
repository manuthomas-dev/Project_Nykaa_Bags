/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 * Also adds a focus class to parent li's for accessibility.
 * Finally adds a class required to reveal the search in the handheld footer bar.
 */
( function() {
	// Wait for DOM to be ready.
	document.addEventListener( 'DOMContentLoaded', function() {
		var container = document.getElementById( 'site-navigation' );
		if ( !container ) {
			return;
		}

		var button = container.querySelector( 'button' );
		if ( !button ) {
			return;
		}

		var menu = container.querySelector( 'ul' );
		// Hide menu toggle button if menu is empty and return early.
		if ( !menu ) {
			button.style.display = 'none';
			return;
		}

		button.setAttribute( 'aria-expanded', 'false' );
		menu.setAttribute( 'aria-expanded', 'false' );
		menu.classList.add( 'nav-menu' );

		button.addEventListener( 'click', function() {
			container.classList.toggle( 'toggled' );
			var expanded = container.classList.contains( 'toggled' ) ? 'true' : 'false';
			button.setAttribute( 'aria-expanded', expanded );
			menu.setAttribute( 'aria-expanded', expanded );
		} );
		
	} );

} )();
jQuery(function($) {
    
	var $window = $(window),
		$body = $('body'),
		$navBar = $('.navbar'),
		clickEvent = 'ontouchstart' in window ? 'touchstart' : 'click';

	function toggleMobileMenu() {
		var $body = $('body'),
			mobileClass = 'mobile-menu-open',
			clickEvent = 'ontouchstart' in window ? 'touchstart' : 'click',
			transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';

		// Click to show mobile menu.
		$('.menu-toggle').on(clickEvent, function(event) {

			event.preventDefault();
			event.stopPropagation(); // Do not trigger click event on '.wrapper' below.
			if ($body.hasClass(mobileClass)) {
				return;
			}
			$body.addClass(mobileClass);
		});

		// When mobile menu is open, click on page content will close it.
		$('.site,.mobile_close_icons')
			.on(clickEvent, function(event) {
				if (!$body.hasClass(mobileClass)) {
					return;
				}
				event.preventDefault();
				$body.removeClass(mobileClass).addClass('animating');
			})
			.on(transitionEnd, function() {
				$body.removeClass('animating');
			});
	}

	/**
	 * Add toggle dropdown icon for mobile menu.
	 * @param $container
	 */
	function initMobileNavigation($container) {

		// Add dropdown toggle that displays child menu items.
		var $dropdownToggle = $('<span class="dropdown-toggle fa fa-angle-down"></span>');

		$container.find('.menu-item-has-children > a').after($dropdownToggle);

		// Toggle buttons and sub menu items with active children menu items.
		$container.find('.current-menu-ancestor > .sub-menu').show();
		$container.find('.current-menu-ancestor > .dropdown-toggle').addClass('toggled-on');
		$container.on(clickEvent, '.dropdown-toggle', function(e) {
			e.preventDefault();
			$(this).toggleClass('toggled-on');
			$(this).next('ul').toggle();
		});
	}

	function hideMobileMenuOnDesktops() {
		$window.on( 'resize', function () {
			if ( $window.width() > 992 ) {
				$body.removeClass('mobile-menu-open');
			}
		} )
	}

	toggleMobileMenu();
	initMobileNavigation($('.mobile-menu'));
	hideMobileMenuOnDesktops();    

	// Header Cart Slide Box JS
	
	$("#site-header-cart").on("click", function () {		
		$("#Sidenav-cart").css("right", "0");	
	});
	$("#mobile-header-cart").on("click", function () {		
		$("#Sidenav-cart").css("right", "0");	
	});
	$(".closebtn").on("click", function () {		
		 $("#Sidenav-cart").css("right", "-300px");		
	});
	 
});



