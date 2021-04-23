<?php
/**
 * Storedesign engine room
 *
 * @package storedesign
 */

// Defining Some Variable
if( !defined( 'STOREDESIGN_VERSION' ) ) {
	define('STOREDESIGN_VERSION', '1.0.3'); // Theme Version
}
if( !defined( 'STOREDESIGN_DIR' ) ) {
	define( 'STOREDESIGN_DIR', get_template_directory() ); // Theme dir
}
if( !defined( 'STOREDESIGN_URL' ) ) {
	define( 'STOREDESIGN_URL', get_template_directory_uri() ); // Theme url
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

require_once( STOREDESIGN_DIR . '/inc/class-storedesign.php');
require_once( STOREDESIGN_DIR . '/inc/class-storedesign-script.php' );
require_once( STOREDESIGN_DIR . '/inc/customizer/class-storedesign-customizer.php');
require_once( STOREDESIGN_DIR . '/inc/storedesign-functions.php');
require_once( STOREDESIGN_DIR . '/inc/storedesign-template-functions.php');

if ( storedesign_is_woocommerce_activated() ) {
	require_once( STOREDESIGN_DIR . '/inc/woocommerce/class-storedesign-woocommerce.php' );	
	require_once( STOREDESIGN_DIR . '/inc/woocommerce/storedesign-woocommerce-template-hooks.php');
	require_once( STOREDESIGN_DIR . '/inc/woocommerce/storedesign-woocommerce-template-functions.php');	
}

// Plugin recomendation class
require_once( STOREDESIGN_DIR . '/inc/plugins/class-storedesign-recommendation.php');


/**
 * Load tab dashboard
 */
if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    require get_template_directory() . '/inc/dashboard/storedesign-how-it-work.php';
    
}