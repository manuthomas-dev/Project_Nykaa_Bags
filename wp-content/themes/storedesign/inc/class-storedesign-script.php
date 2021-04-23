<?php
/**
 * Script Class
 *
 * Handles the script and style functionality of plugin
 *
 * @package Storedesign
 * @since   0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class Storedesign_Script {
	
	function __construct() {

		add_action( 'wp_enqueue_scripts',         array( $this, 'scripts' ),       10 );
		add_action( 'wp_enqueue_scripts',         array( $this, 'child_scripts' ), 30 ); // After WooCommerce.    
                
	}      
 
		/**
		 * Enqueue scripts and styles.
		 *
		 * @since   0.1
		 */
		function scripts() {		

			/*** Styles	 **/
			wp_enqueue_style( 'storedesign-style', STOREDESIGN_URL . '/style.css', '', STOREDESIGN_VERSION );
			wp_style_add_data( 'storedesign-style', 'rtl', 'replace' );

			wp_enqueue_style( 'storedesign-icons', STOREDESIGN_URL . '/assets/css/base/icons.css', '', STOREDESIGN_VERSION );
			wp_style_add_data( 'storedesign-icons', 'rtl', 'replace' );
			
			/*** Font Awesome CSS ***/			
			wp_register_style( 'font-awesome', STOREDESIGN_URL.'/assets/css/font-awesome.min.css', array(), STOREDESIGN_VERSION );
			wp_enqueue_style( 'font-awesome' );

			/*** Fonts **/	
			wp_enqueue_style( 'storedesign-fonts', storedesign_fonts_url(), array(), null );

			/*** Scripts **/
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			if ( is_page_template( 'template-parts/template-homepage.php' )) {
				wp_enqueue_script( 'storedesign-homepage', STOREDESIGN_URL . '/assets/js/homepage.js', array('jquery'), STOREDESIGN_VERSION, true );
			}
			// Registring and enqueing slick slider css
			if( wp_style_is( 'wpos-slick-style', 'registered' ) ) {
				wp_enqueue_style( 'wpos-slick-style' );
			} 
			else if(!wp_style_is( 'slick-style', 'registered' ) )
			{				
				wp_register_style( 'slick-style', STOREDESIGN_URL.'/assets/css/slick.css', array(), STOREDESIGN_VERSION );
				wp_enqueue_style( 'slick-style' );
			}

			// Registring slick slider script			
			 if (wp_script_is( 'wpos-slick-jquery', 'registered' ))
				{
					wp_enqueue_script( 'wpos-slick-jquery' );
				} else if( !wp_script_is( 'jquery-slick', 'registered' ) ) {
					wp_register_script( 'jquery-slick', STOREDESIGN_URL . '/assets/js/slick.min.js', array('jquery'), STOREDESIGN_VERSION, true );
					wp_enqueue_script( 'jquery-slick' );
				}

			// Navigation JS
			wp_register_script('storedesign-navigation-script',STOREDESIGN_URL . '/assets/js/navigation.js', array('jquery'), STOREDESIGN_VERSION, true);
			wp_enqueue_script('storedesign-navigation-script');

			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		/**
		 * Enqueue child theme stylesheet.
		 * A separate function is required as the child theme css needs to be enqueued _after_ the parent theme
		 * primary css and the separate WooCommerce css.
		 *
		 * @since   0.1
		 */
		function child_scripts() {
			if ( is_child_theme() ) {
				$child_theme = wp_get_theme( get_stylesheet() );
				wp_enqueue_style( 'storedesign-child-style', get_stylesheet_uri(), array(), $child_theme->get( 'Version' ) );
			}
		}
}

$storedesign_script = new Storedesign_Script();