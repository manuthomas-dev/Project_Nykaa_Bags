<?php
/**
 * storedesign_Recommendation Class
 * 
 * Handles the recommended plugin functionality.
 * 
 * @package Storedesign
 * @since   0.1
 */

// Plugin recomendation class
require_once( STOREDESIGN_DIR . '/inc/plugins/class-tgm-plugin-activation.php' );

class storedesign_Recommendation {

	function __construct() {
		
		// Action to add recomended plugins
		add_action( 'tgmpa_register', array($this, 'storedesign_recommend_plugin') );
	}

	/**
	 * Recommend Plugins
	 * 
	 * @package Storedesign
	 * @since   0.1
	 */
	function storedesign_recommend_plugin() {
	    $plugins = array(
			array(
	            'name'               => __('WP Logo Showcase Responsive Slider', 'storedesign'),
	            'slug'               => 'wp-logo-showcase-responsive-slider-slider',
	            'required'           => false,
	        ), array(
	            'name'               => __('WP Responsive Recent Post Slider', 'storedesign'),
	            'slug'               => 'wp-responsive-recent-post-slider',
	            'required'           => false,
	        ), array(
	            'name'               => __('Slider and Carousel Plus Widget for Instagram', 'storedesign'),
	            'slug'               => 'slider-and-carousel-plus-widget-for-instagram',
	            'required'           => false,
	        ), array(
	            'name'               => __('InboundWP – A Complete Inbound Marketing Pack', 'storedesign'),
	            'slug'               => 'inboundwp-lite',
	            'required'           => false,
	        )
	    );
	    tgmpa( $plugins);
	}
}

$storedesign_recommendation = new storedesign_Recommendation();