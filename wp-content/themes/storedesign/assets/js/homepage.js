/**
 * homepage.js
 *
 * Handles behaviour of the homepage featured image
 */
( function() {
	/**
	 * Set hero content dimensions / layout
	 * Run adaptive backgrounds and set colors
	 */
	document.addEventListener( 'DOMContentLoaded', function() {
		var homepageContent = document.querySelector( '.page-template-template-homepage .type-page.has-post-thumbnail' );
		if ( !homepageContent ) {
			// Only apply layout to the homepage content component if it exists on the page
			return;
		}
		var siteMain = document.querySelector( '.site-main' );
		var htmlDirValue = document.documentElement.getAttribute( 'dir' );
		var updateDimensions = function() {
			if ( updateDimensions._tick ) {
				cancelAnimationFrame( updateDimensions._tick );
			}
			updateDimensions._tick = requestAnimationFrame( function() {
				updateDimensions._tick = null;
				// Make the homepage content full width and centrally aligned.
				homepageContent.style.width = window.innerWidth + 'px';
				if ( htmlDirValue !== 'rtl' ) {
					homepageContent.style.marginLeft = -siteMain.getBoundingClientRect().left + 'px';
				} else {
					homepageContent.style.marginRight = -siteMain.getBoundingClientRect().left + 'px';
				}
			} );
		};
		// On window resize, set hero content dimensions / layout.
		window.addEventListener( 'resize', updateDimensions );
		updateDimensions();		
	} );

} )();

function openCity(evt, producttabName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
	
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(producttabName).style.display = "block";
    evt.currentTarget.className += " active";
}
jQuery(function($) {
	$('.product-for').slick({
	  slidesToShow: 1,
	  slidesToScroll: 1,
	  arrows: true,
	  fade: false,
	  asNavFor: '.product-nav',
	  infinite:false,
	});
	$('.product-nav').slick({
	  slidesToShow: 2,
	  slidesToScroll: 1,
	  asNavFor: '.product-for',
	  dots: false,	  
	  focusOnSelect: true,
	  vertical: true,
	  verticalSwiping:true,
	  infinite:false,
	   arrows: false,
	});
});
