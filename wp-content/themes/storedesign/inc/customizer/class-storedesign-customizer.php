<?php
/**
 * Storedesign Customizer Class
 *
 * @author   WP Online Support
 * @package  storedesign
 * @since   0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Storedesign_Customizer' ) ) :

	/**
	 * The Storedesign Customizer class
	 */
	class Storedesign_Customizer {

		var $defaults_values;
	
		/**
		 * Setup class.
		 *
		 * @since   0.1
		 */
		public function __construct() {
			add_action( 'customize_register',              array( $this, 'customize_register' ), 10 );
			add_filter( 'body_class',                      array( $this, 'layout_class' ) );
			add_action( 'wp_enqueue_scripts',              array( $this, 'add_customizer_css' ), 130 );
			add_action( 'after_setup_theme',               array( $this, 'custom_header_setup' ) );
			add_action( 'customize_controls_print_styles', array( $this, 'customizer_custom_control_css' ) );
			add_action( 'customize_register',              array( $this, 'edit_default_customizer_settings' ), 99 );
			add_action( 'init',                            array( $this, 'default_theme_mod_values' ), 10 );

			add_action( 'after_switch_theme',              array( $this, 'set_storedesign_style_theme_mods' ) );
			add_action( 'customize_save_after',            array( $this, 'set_storedesign_style_theme_mods' ) );
			
			//$this->default_values = $this->get_storedesign_default_setting_values();
		}

		/**
		 * Returns an array of the desired default Storedesign Options
		 *
		 * @return array
		 */
		public static function get_storedesign_default_setting_values() {
			return apply_filters( 'storedesign_setting_default_values', $args = array(
				'storedesign_heading_color'               => '#333333',
				'storedesign_text_color'                  => '#6d6d6d',
				'storedesign_accent_color'                => '#000000',
				'storedesign_header_background_color'     => '#ffffff',
				'storedesign_header_text_color'           => '#404040',
				'storedesign_header_link_color'           => '#333333',
				'storedesign_footer_background_color'     => '#ffffff',
				'storedesign_footer_heading_color'        => '#333333',
				'storedesign_footer_text_color'           => '#6d6d6d',
				'storedesign_footer_link_color'           => '#333333',
                'copyright'                         	  => __('&copy {year} Theme', 'storedesign'),
				'storedesign_button_background_color'     => '#fd6e4f',
				'storedesign_button_text_color'           => '#ffffff',
				'storedesign_button_alt_background_color' => '#333333',
				'storedesign_button_alt_text_color'       => '#ffffff',
				'storedesign_layout'                      => 'right',
				'background_color'                        => 'ffffff',
				
				'storedesign_shopbycat_setting'           => 0,
				'storedesign_shopbycat_setting_h'         => esc_html__( 'Shop by Category', 'storedesign' ),
				'storedesign_shopbycat_setting_limit'     => '3',
				'storedesign_shopbycat_setting_col'       => '3',
				'storedesign_shopbycat_setting_cat'       => '',	

				'storedesign_latestprd_setting'	          => 0,
				'storedesign_latestprd_setting_h'         => esc_html__( 'Latest Products', 'storedesign' ),
				'storedesign_latestprd_setting_limit'     => '3',
				'storedesign_latestprd_setting_col'       => '3',		
				
				'storedesign_recommend_setting'	          => 0,
				'storedesign_recommend_setting_h'         => esc_html__( 'We Recommend', 'storedesign' ),
				'storedesign_recommend_setting_limit'     => '3',
				'storedesign_recommend_setting_col'       => '3',
				
				'storedesign_popularprd_setting'          => 0,
				'storedesign_popularprd_setting_h'        => esc_html__( 'Popular Products', 'storedesign' ),
				'storedesign_popularprd_setting_limit'     => '3',
				'storedesign_popularprd_setting_col'       => '3',
				
				'storedesign_sale_setting'         		  => 0,
				'storedesign_sale_setting_h'        	  => esc_html__( 'On Sale', 'storedesign' ),
				'storedesign_sale_setting_limit'     	  => '3', 
				
				'storedesign_bestdallers_setting'         => 0,
				'storedesign_bestdallers_setting_h'       => esc_html__( 'Best Sellers', 'storedesign' ),
				'storedesign_bestdallers_setting_limit'   => '3',
				'storedesign_bestdallers_setting_col'     => '3', 
				
                'enable_testimonials_cont'                => 0,
                'testimonials_cont_h'                     => esc_html__( 'Testimonials Content', 'storedesign' ),             
                'testimonials_cont_scode'                 => '',
                'enable_logoslider_cont'                  => 0,
                'logoslider_cont_h'                       => esc_html__( 'Logo Slider Content', 'storedesign' ),              
                'logoslider_cont_scode'                   => '',                                               
                'enable_ourblog_cont'                     => 0,
                'ourblog_cont_h'                          => esc_html__( 'Latest From Blog ', 'storedesign' ),               
                'ourblog_cont_scode'                      => '',                
				'header_social'                     	  => 0,
                'footer_social'                           => 0,
                'facebook'                                => '',
                'twitter'                                 => '',
                'linkedin'                          	  => '',
                'behance'                           	  => '',
                'dribbble'                          	  => '',
                'instagram'                         	  => '',
                'youtube'                           	  => '',
                'pinterest'                        		  => '',
			) );
		}

		/**
		 * Adds a value to each Storedesign setting if one isn't already present.
		 *
		 * @uses get_storedesign_default_setting_values()
		 */
		public function default_theme_mod_values() {
			foreach ( self::get_storedesign_default_setting_values() as $mod => $val ) {
				add_filter( 'theme_mod_' . $mod, array( $this, 'get_theme_mod_value' ), 10 );
			}
		}

		/**
		 * Get theme mod value.
		 *
		 * @param string $value
		 * @return string
		 */
		public function get_theme_mod_value( $value ) {
			$key = substr( current_filter(), 10 );

			$set_theme_mods = get_theme_mods();

			if ( isset( $set_theme_mods[ $key ] ) ) {
				return $value;
			}

			$values = $this->get_storedesign_default_setting_values();

			return isset( $values[ $key ] ) ? $values[ $key ] : $value;
		}

		/**
		 * Set Customizer setting defaults.
		 * These defaults need to be applied separately as child themes can filter storedesign_setting_default_values
		 *
		 * @param  array $wp_customize the Customizer object.
		 * @uses   get_storedesign_default_setting_values()
		 */
		public function edit_default_customizer_settings( $wp_customize ) {
			foreach ( self::get_storedesign_default_setting_values() as $mod => $val ) {
				$wp_customize->get_setting( $mod )->default = $val;
			}
		}

		/**
		 * Setup the WordPress core custom header feature.
		 *
		 * @uses storedesign_header_style()
		 * @uses storedesign_admin_header_style()
		 * @uses storedesign_admin_header_image()
		 */
		public function custom_header_setup() {
			add_theme_support( 'custom-header', apply_filters( 'storedesign_custom_header_args', array(
				'default-image' => '',
				'header-text'   => false,
				'width'         => 1950,
				'height'        => 500,
				'flex-width'    => true,
				'flex-height'   => true,
			) ) );
		}

		/**
		 * Add postMessage support for site title and description for the Theme Customizer along with several other settings.
		 *
		 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
		 * @since   0.1
		 */
		public function customize_register( $wp_customize ) {

			// Move background color setting alongside background image.
			$wp_customize->get_control( 'background_color' )->section   = 'background_image';
			$wp_customize->get_control( 'background_color' )->priority  = 20;

			// Change background image section title & priority.
			$wp_customize->get_section( 'background_image' )->title     = __( 'Background', 'storedesign' );
			$wp_customize->get_section( 'background_image' )->priority  = 30;

			// Change header image section title & priority.
			$wp_customize->get_section( 'header_image' )->title         = __( 'Header', 'storedesign' );
			$wp_customize->get_section( 'header_image' )->priority      = 25;

			// Selective refresh.
			if ( function_exists( 'add_partial' ) ) {
				$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
				$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

				$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
					'selector'        => '.site-branding',
					'render_callback' => array( $this, 'get_site_logo' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogname', array(
					'selector'        => '.site-title.beta a',
					'render_callback' => array( $this, 'get_site_name' ),
				) );

				$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
					'selector'        => '.site-description',
					'render_callback' => array( $this, 'get_site_description' ),
				) );
			}

			/**
			 * Custom controls
			 */
			require_once dirname( __FILE__ ) . '/class-storedesign-customizer-control-radio-image.php';
			require_once dirname( __FILE__ ) . '/class-storedesign-customizer-control-arbitrary.php';			

			/**
			 * Add the typography section
			 */
			$wp_customize->add_section( 'storedesign_typography' , array(
				'title'      			=> __( 'Typography Colors', 'storedesign' ),
				'priority'   			=> 45,
			) );

			/**
			 * Heading color
			 */
			$wp_customize->add_setting( 'storedesign_heading_color', array(
				'default'           	=> apply_filters( 'storedesign_default_heading_color', '#484c51' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_heading_color', array(
				'label'	   				=> __( 'Heading color', 'storedesign' ),
				'section'  				=> 'storedesign_typography',
				'settings' 				=> 'storedesign_heading_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Text Color
			 */
			$wp_customize->add_setting( 'storedesign_text_color', array(
				'default'           	=> apply_filters( 'storedesign_default_text_color', '#43454b' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_text_color', array(
				'label'					=> __( 'Text color', 'storedesign' ),
				'section'				=> 'storedesign_typography',
				'settings'				=> 'storedesign_text_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Accent Color
			 */
			$wp_customize->add_setting( 'storedesign_accent_color', array(
				'default'           	=> apply_filters( 'storedesign_default_accent_color', '#96588a' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_accent_color', array(
				'label'	   				=> __( 'Link / accent color', 'storedesign' ),
				'section'  				=> 'storedesign_typography',
				'settings' 				=> 'storedesign_accent_color',
				'priority' 				=> 40,
			) ) );

			$wp_customize->add_control( new Arbitrary_Storedesign_Control( $wp_customize, 'storedesign_header_image_heading', array(
				'section'  				=> 'header_image',
				'type' 					=> 'heading',
				'label'					=> __( 'Header background image', 'storedesign' ),
				'priority' 				=> 6,
			) ) );

			/**
			 * Header Background
			 */
			$wp_customize->add_setting( 'storedesign_header_background_color', array(
				'default'           	=> apply_filters( 'storedesign_default_header_background_color', '#2c2d33' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_header_background_color', array(
				'label'	   				=> __( 'Background color', 'storedesign' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'storedesign_header_background_color',
				'priority' 				=> 15,
			) ) );

			/**
			 * Header text color
			 */
			$wp_customize->add_setting( 'storedesign_header_text_color', array(
				'default'           	=> apply_filters( 'storedesign_default_header_text_color', '#9aa0a7' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_header_text_color', array(
				'label'	   				=> __( 'Text color', 'storedesign' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'storedesign_header_text_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Header link color
			 */
			$wp_customize->add_setting( 'storedesign_header_link_color', array(
				'default'           	=> apply_filters( 'storedesign_default_header_link_color', '#d5d9db' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_header_link_color', array(
				'label'	   				=> __( 'Link color', 'storedesign' ),
				'section'  				=> 'header_image',
				'settings' 				=> 'storedesign_header_link_color',
				'priority' 				=> 30,
			) ) );

			/***** Footer Settings *****/
			$wp_customize->add_section( 'wpostheme_general_footer_section', array(
				'title' => __( 'Footer Copyright and Colors', 'storedesign' ),			
			));

			// Footer Copyright
			$wp_customize->add_setting( 'copyright', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'default'           => apply_filters( 'default_copyright', '&copy {year} StoreDesign WordPress WooCommerce Theme' ),
				'transport'         => 'refresh',	
			));

			$wp_customize->add_control( 'copyright', array(
				'label'    => __( 'Footer Copyright', 'storedesign' ),
				'section'  => 'wpostheme_general_footer_section',
			));
			

			/**
			 * Footer Background
			 */
			$wp_customize->add_setting( 'storedesign_footer_background_color', array(
				'default'           	=> apply_filters( 'storedesign_default_footer_background_color', '#f0f0f0' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_footer_background_color', array(
				'label'	   				=> __( 'Background color', 'storedesign' ),
				'section'  				=> 'wpostheme_general_footer_section',
				'settings' 				=> 'storedesign_footer_background_color',
				'priority'				=> 10,
			) ) );

			/**
			 * Footer heading color
			 */
			$wp_customize->add_setting( 'storedesign_footer_heading_color', array(
				'default'           	=> apply_filters( 'storedesign_default_footer_heading_color', '#494c50' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_footer_heading_color', array(
				'label'	   				=> __( 'Heading color', 'storedesign' ),
				'section'  				=> 'wpostheme_general_footer_section',
				'settings' 				=> 'storedesign_footer_heading_color',
				'priority'				=> 20,
			) ) );

			/**
			 * Footer text color
			 */
			$wp_customize->add_setting( 'storedesign_footer_text_color', array(
				'default'           	=> apply_filters( 'storedesign_default_footer_text_color', '#61656b' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_footer_text_color', array(
				'label'	   				=> __( 'Text color', 'storedesign' ),
				'section'  				=> 'wpostheme_general_footer_section',
				'settings' 				=> 'storedesign_footer_text_color',
				'priority'				=> 30,
			) ) );

			/**
			 * Footer link color
			 */
			$wp_customize->add_setting( 'storedesign_footer_link_color', array(
				'default'           	=> apply_filters( 'storedesign_default_footer_link_color', '#2c2d33' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_footer_link_color', array(
				'label'	   				=> __( 'Link color', 'storedesign' ),
				'section'  				=> 'wpostheme_general_footer_section',
				'settings' 				=> 'storedesign_footer_link_color',
				'priority'				=> 40,
			) ) );


			/**
			 * Buttons section
			 */
			$wp_customize->add_section( 'storedesign_buttons' , array(
				'title'      			=> __( 'Buttons', 'storedesign' ),
				'priority'   			=> 45,
				'description' 			=> __( 'Customize the look & feel of your website buttons.', 'storedesign' ),
			) );

			/**
			 * Button background color
			 */
			$wp_customize->add_setting( 'storedesign_button_background_color', array(
				'default'           	=> apply_filters( 'storedesign_default_button_background_color', '#96588a' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_button_background_color', array(
				'label'	   				=> __( 'Background color', 'storedesign' ),
				'section'  				=> 'storedesign_buttons',
				'settings' 				=> 'storedesign_button_background_color',
				'priority' 				=> 10,
			) ) );

			/**
			 * Button text color
			 */
			$wp_customize->add_setting( 'storedesign_button_text_color', array(
				'default'           	=> apply_filters( 'storedesign_default_button_text_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_button_text_color', array(
				'label'	   				=> __( 'Text color', 'storedesign' ),
				'section'  				=> 'storedesign_buttons',
				'settings' 				=> 'storedesign_button_text_color',
				'priority' 				=> 20,
			) ) );

			/**
			 * Button alt background color
			 */
			$wp_customize->add_setting( 'storedesign_button_alt_background_color', array(
				'default'           	=> apply_filters( 'storedesign_default_button_alt_background_color', '#2c2d33' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_button_alt_background_color', array(
				'label'	   				=> __( 'Alternate button background color', 'storedesign' ),
				'section'  				=> 'storedesign_buttons',
				'settings' 				=> 'storedesign_button_alt_background_color',
				'priority' 				=> 30,
			) ) );

			/**
			 * Button alt text color
			 */
			$wp_customize->add_setting( 'storedesign_button_alt_text_color', array(
				'default'           	=> apply_filters( 'storedesign_default_button_alt_text_color', '#ffffff' ),
				'sanitize_callback' 	=> 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'storedesign_button_alt_text_color', array(
				'label'	   				=> __( 'Alternate button text color', 'storedesign' ),
				'section'  				=> 'storedesign_buttons',
				'settings' 				=> 'storedesign_button_alt_text_color',
				'priority' 				=> 40,
			) ) );

			/**
			* Header Social Icon
			**/
			$wp_customize->add_section( 'wpostheme_general_socials_section', array(
				'title' => __( 'Social Profile', 'storedesign' ),
			));

			// Socials Icons on Header
			$wp_customize->add_setting( 'header_social', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',
				'default'           => apply_filters( 'default_header_social', '0' ),
			));

			$wp_customize->add_control( 'header_social', array(
				'label'    		  => __( 'Enable Socials Icons on Header', 'storedesign' ),
				'section' 		  => 'wpostheme_general_socials_section',
				'type'                    => 'checkbox',
			));

			// Socials Icons on Footer
			$wp_customize->add_setting( 'footer_social', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_header_social', '0' ),
			));

			$wp_customize->add_control( 'footer_social', array(
				'label'    		  => __( 'Enable Socials Icons on Footer', 'storedesign' ),
				'section' 		  => 'wpostheme_general_socials_section',
				'type'                    => 'checkbox',
			));

			// Facebook
			$wp_customize->add_setting( 'facebook', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_facebook', '' ),
			));

			$wp_customize->add_control( 'facebook', array(
				'label'    => __( 'Facebook', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',
			));

			// Twitter
			$wp_customize->add_setting( 'twitter', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_twitter', '' ),
			));

			$wp_customize->add_control( 'twitter', array(
				'label'    => __( 'Twitter', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',			
			));

			// Linkedin
			$wp_customize->add_setting( 'linkedin', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_linkedin', '' ),
			));

			$wp_customize->add_control( 'linkedin', array(
				'label'    => __( 'Linkedin', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',
			));

			// Instagram
			$wp_customize->add_setting( 'instagram', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_instagram', '' ),
			));

			$wp_customize->add_control( 'instagram', array(
				'label'    => __( 'Instagram', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',
			));

			// YouTube
			$wp_customize->add_setting( 'youtube', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_youtube', '' ),
			));

			$wp_customize->add_control( 'youtube', array(
				'label'    => __( 'YouTube', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',
			));

			// Behance
			$wp_customize->add_setting( 'behance', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_behance', '' ),
			));

			$wp_customize->add_control( 'behance', array(
				'label'    => __( 'Behance', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',
			));

			// Dribbble
			$wp_customize->add_setting( 'dribbble', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_dribbble', '' ),
			));

			$wp_customize->add_control( 'dribbble', array(
				'label'    => __( 'Dribbble', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',
			));

			// Pinterest
			$wp_customize->add_setting( 'pinterest', array(
				'sanitize_callback' => 'storedesign_sanitize_url',
				'transport'         => 'refresh',
				'default' 			=> apply_filters( 'default_pinterest', '' ),
			));

			$wp_customize->add_control( 'pinterest', array(
				'label'    => __( 'Pinterest', 'storedesign' ),
				'section'  => 'wpostheme_general_socials_section',
			));

			/**
			 * Layout
			 */
			$wp_customize->add_section( 'storedesign_layout' , array(
				'title'      			=> __( 'Layout', 'storedesign' ),
				'priority'   			=> 50,
			) );

			$wp_customize->add_setting( 'storedesign_layout', array(
				'default'    			=> apply_filters( 'storedesign_default_layout', $layout = is_rtl() ? 'left' : 'right' ),
				'sanitize_callback' 	=> 'storedesign_sanitize_choices',
			) );

			$wp_customize->add_control( new Storedesign_Custom_Radio_Image_Control( $wp_customize, 'storedesign_layout', array(
				'settings'				=> 'storedesign_layout',
				'section'				=> 'storedesign_layout',
				'label'					=> __( 'General Layout', 'storedesign' ),
				'priority'				=> 1,
				'choices'				=> array(
											'right' => STOREDESIGN_URL . '/assets/images/customizer/controls/2cr.png',
											'left'  => STOREDESIGN_URL . '/assets/images/customizer/controls/2cl.png',
				),
			) ) );

	/**************************************
	Front Page Design
	***************************************/	

		$wp_customize->add_panel(
			'panel_frontpage', array(			
				'capability' => 'edit_theme_options',
				'title'      => __( 'Front Page Design', 'storedesign' ),
				
			'active_callback' => 'storedesign_is_woocommerce_activated',
			)
		);
	/**
	Shop by Category setting 
	**/
	$wp_customize->add_section(
		'storedesign_shopbycat_section', array(
			'title'    => __( 'Shop by Category', 'storedesign' ),
			'priority' => 1,
			'panel'    => 'panel_frontpage',
		)
	);
	
		$wp_customize->add_setting(
			'storedesign_shopbycat_setting', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',	
				'default'			=> apply_filters( 'storedesign_shopbycat_setting', 0 ),			
			)
		);

		$wp_customize->add_control(
			'storedesign_shopbycat_setting', array(
				'label'    	=> __( 'Enable Shop by Category Section', 'storedesign' ),
				'description'   => __( 'If Enable, it will show the Shop by Category section ', 'storedesign' ),
				'section' 	=> 'storedesign_shopbycat_section',
				'priority' 	=> 1,
				'type'       	=> 'checkbox',
			)
		);
		
	$wp_customize->add_setting(
			'storedesign_shopbycat_setting_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '1',
			)
		);

		$wp_customize->add_control(
			'storedesign_shopbycat_setting_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_shopbycat_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);		
		
		$wp_customize->add_setting(
			'storedesign_shopbycat_setting_cat', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_shopbycat_setting_cat', array(
				'label'    		  => __( 'Enter category ids ', 'storedesign' ),				
				'section' 		  => 'storedesign_shopbycat_section',
				'priority' 		  => 2,
				'type'       	  => 'text',	
				'description'   => __( 'Enter category ids that you want to display ie 10,20,30 etc', 'storedesign' ),	
			)
		);
		$wp_customize->add_setting(
			'storedesign_shopbycat_setting_limit', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_shopbycat_setting_limit', array(
				'label'    		  => __( 'Enter Products Limit', 'storedesign' ),				
				'section' 		  => 'storedesign_shopbycat_section',
				'priority' 		  => 3,
				'type'            => 'number',	
				'description'   => __( 'Enter the number of products you want to display ', 'storedesign' ),	
			)
		);	
		
		$wp_customize->add_setting(
			'storedesign_shopbycat_setting_col', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_shopbycat_setting_col', array(
				'label'    		  => __( 'Enter Products Columns', 'storedesign' ),				
				'section' 		  => 'storedesign_shopbycat_section',
				'priority' 		  => 3,
				'description'   => __( 'Enter the number of products columns ', 'storedesign' ),
				'type'            => 'number',				
			)
		);	
	
	/**
	Latest Products Added 
	**/
	$wp_customize->add_section(
		'storedesign_latestprd_section', array(
			'title'    => __( 'Latest Products - Display in Tab', 'storedesign' ),
			'priority' => 1,
			'panel'    => 'panel_frontpage',
		)
	);
	
		$wp_customize->add_setting(
			'storedesign_latestprd_setting', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',
				'default'			=> apply_filters( 'storedesign_latestprd_setting', 0 ),				
			)
		);

		$wp_customize->add_control(
			'storedesign_latestprd_setting', array(
				'label'    	=> __( 'Enable Latest Products Added Section', 'storedesign' ),
				'description'   => __( 'If Checked, it will show the Latest Products Added section ', 'storedesign' ),
				'section' 	=> 'storedesign_latestprd_section',
				'priority' 	=> 1,
				'type'       	=> 'checkbox',
			)
		);
		
		$wp_customize->add_setting(
			'storedesign_latestprd_setting_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_latestprd_setting_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_latestprd_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);
		$wp_customize->add_setting(
			'storedesign_latestprd_setting_limit', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_latestprd_setting_limit', array(
				'label'    		  => __( 'Enter Products Limit', 'storedesign' ),				
				'section' 		  => 'storedesign_latestprd_section',
				'priority' 		  => 3,
				'type'            => 'number',	
				'description'   => __( 'Enter the number of products you want to display ', 'storedesign' ),	
			)
		);	
		
		$wp_customize->add_setting(
			'storedesign_latestprd_setting_col', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_latestprd_setting_col', array(
				'label'    		  => __( 'Enter Products Columns', 'storedesign' ),				
				'section' 		  => 'storedesign_latestprd_section',
				'priority' 		  => 3,
				'description'   => __( 'Enter the number of products columns ', 'storedesign' ),
				'type'            => 'number',				
			)
		);	
		
		
	/**
	We Recommend 
	**/
	$wp_customize->add_section(
		'storedesign_recommend_section', array(
			'title'    => __( 'We Recommend  - Display in Tab', 'storedesign' ),
			'priority' => 1,
			'panel'    => 'panel_frontpage',
		)
	);
	
		$wp_customize->add_setting(
			'storedesign_recommend_setting', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',	
				'default'			=> apply_filters( 'storedesign_recommend_setting', 0 ),				
			)
		);

		$wp_customize->add_control(
			'storedesign_recommend_setting', array(
				'label'    	=> __( 'Enable Latest We Recommend Section', 'storedesign' ),
				'description'   => __( 'If Checked, it will show the We Recommend section ', 'storedesign' ),
				'section' 	=> 'storedesign_recommend_section',
				'priority' 	=> 1,
				'type'       	=> 'checkbox',
			)
		);	
		
		$wp_customize->add_setting(
			'storedesign_recommend_setting_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_recommend_setting_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_recommend_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);		
		
		$wp_customize->add_setting(
			'storedesign_recommend_setting_limit', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_recommend_setting_limit', array(
				'label'    		  => __( 'Enter Products Limit', 'storedesign' ),				
				'section' 		  => 'storedesign_recommend_section',
				'priority' 		  => 3,
				'type'            => 'number',	
				'description'   => __( 'Enter the number of products you want to display ', 'storedesign' ),	
			)
		);	
		
		$wp_customize->add_setting(
			'storedesign_recommend_setting_col', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_recommend_setting_col', array(
				'label'    		  => __( 'Enter Products Columns', 'storedesign' ),				
				'section' 		  => 'storedesign_recommend_section',
				'priority' 		  => 3,
				'description'   => __( 'Enter the number of products columns ', 'storedesign' ),
				'type'            => 'number',				
			)
		);	
		
		
	/**
	Popular Products 
	**/
	$wp_customize->add_section(
		'storedesign_popularprd_section', array(
			'title'    => __( 'Popular Products  - Display in Tab', 'storedesign' ),
			'priority' => 1,
			'panel'    => 'panel_frontpage',
		)
	);
	
		$wp_customize->add_setting(
			'storedesign_popularprd_setting', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',
				'default'			=> apply_filters( 'storedesign_popularprd_setting', 0 ),					
			)
		);

		$wp_customize->add_control(
			'storedesign_popularprd_setting', array(
				'label'    	=> __( 'Enable Latest Popular Products Section', 'storedesign' ),
				'description'   => __( 'If Checked, it will show the Popular Products section ', 'storedesign' ),
				'section' 	=> 'storedesign_popularprd_section',
				'priority' 	=> 1,
				'type'       	=> 'checkbox',
			)
		);	
		
		$wp_customize->add_setting(
			'storedesign_popularprd_setting_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_popularprd_setting_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_popularprd_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);
		$wp_customize->add_setting(
			'storedesign_popularprd_setting_limit', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_popularprd_setting_limit', array(
				'label'    		  => __( 'Enter Products Limit', 'storedesign' ),				
				'section' 		  => 'storedesign_popularprd_section',
				'priority' 		  => 3,
				'type'            => 'number',	
				'description'   => __( 'Enter the number of products you want to display ', 'storedesign' ),	
			)
		);	
		
		$wp_customize->add_setting(
			'storedesign_popularprd_setting_col', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_popularprd_setting_col', array(
				'label'    		  => __( 'Enter Products Columns', 'storedesign' ),				
				'section' 		  => 'storedesign_popularprd_section',
				'priority' 		  => 3,
				'description'   => __( 'Enter the number of products columns ', 'storedesign' ),
				'type'            => 'number',				
			)
		);		

		
		
	/**
	Best Sellers
	**/
	$wp_customize->add_section(
		'storedesign_bestdallers_section', array(
			'title'    => __( 'Best Sellers  - Display in Tab', 'storedesign' ),
			'priority' => 1,
			'panel'    => 'panel_frontpage',
		)
	);
	
		$wp_customize->add_setting(
			'storedesign_bestdallers_setting', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',		
				'default'			=> apply_filters( 'storedesign_bestdallers_setting', 0 ),				
			)
		);

		$wp_customize->add_control(
			'storedesign_bestdallers_setting', array(
				'label'    	=> __( 'Enable Best Sellers Section', 'storedesign' ),
				'description'   => __( 'If Checked, it will show the Best Sellers section ', 'storedesign' ),
				'section' 	=> 'storedesign_bestdallers_section',
				'priority' 	=> 1,
				'type'       	=> 'checkbox',
			)
		);	

		$wp_customize->add_setting(
			'storedesign_bestdallers_setting_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_bestdallers_setting_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_bestdallers_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);
		$wp_customize->add_setting(
			'storedesign_bestdallers_setting_limit', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_bestdallers_setting_limit', array(
				'label'    		  => __( 'Enter Products Limit', 'storedesign' ),				
				'section' 		  => 'storedesign_bestdallers_section',
				'priority' 		  => 3,
				'type'            => 'number',	
				'description'   => __( 'Enter the number of products you want to display ', 'storedesign' ),	
			)
		);	
		
		$wp_customize->add_setting(
			'storedesign_bestdallers_setting_col', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_bestdallers_setting_col', array(
				'label'    		  => __( 'Enter Products Columns', 'storedesign' ),				
				'section' 		  => 'storedesign_bestdallers_section',
				'priority' 		  => 3,
				'description'   => __( 'Enter the number of products columns ', 'storedesign' ),
				'type'            => 'number',				
			)
		);
		
	/**
	On Sale
	**/
	$wp_customize->add_section(
		'storedesign_sale_section', array(
			'title'    => __( 'On Sale - Display In Slider', 'storedesign' ),
			'priority' => 1,
			'panel'    => 'panel_frontpage',
		)
	);
	
		$wp_customize->add_setting(
			'storedesign_sale_setting', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',
				'default'			=> apply_filters( 'storedesign_sale_setting', 0 ),				
			)
		);

		$wp_customize->add_control(
			'storedesign_sale_setting', array(
				'label'    	=> __( 'Enable Latest On Sale Section', 'storedesign' ),
				'description'   => __( 'If Checked, it will show the On Sale section ', 'storedesign' ),
				'section' 	=> 'storedesign_sale_section',
				'priority' 	=> 1,
				'type'       	=> 'checkbox',
			)
		);	
			
		$wp_customize->add_setting(
			'storedesign_sale_setting_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_sale_setting_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_sale_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);
		$wp_customize->add_setting(
			'storedesign_sale_setting_limit', array(
				'sanitize_callback' => 'absint',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'storedesign_sale_setting_limit', array(
				'label'    		  => __( 'Enter Products Limit', 'storedesign' ),				
				'section' 		  => 'storedesign_sale_section',
				'priority' 		  => 3,
				'type'            => 'number',	
				'description'   => __( 'Enter the number of products you want to display ', 'storedesign' ),	
			)
		);	
		
		
	/**
	Testimonials Content
	**/	
	$wp_customize->add_section(
		'storedesign_testimonials_section', array(
			'title'    => __( 'Testimonials', 'storedesign' ),
			'priority' => 4,
			'panel'    => 'panel_frontpage',
		)
	);
	
	/**Testimonials Content Inside **/
		$wp_customize->add_setting(
			'enable_testimonials_cont', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',				
			)
		);

		$wp_customize->add_control(
			'enable_testimonials_cont', array(
				'label'    	  => __( 'Enable Testimonials', 'storedesign' ),
				'description'     => __( 'If Checked - This will show Testimonials section from home page', 'storedesign' ),	
				'section' 	  => 'storedesign_testimonials_section',
				'priority' 	  => 1,
				'type'       	  => 'checkbox',
				
			)
		);	
		
		$wp_customize->add_setting(
			'testimonials_cont_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',	
			)
		);

		$wp_customize->add_control(
			'testimonials_cont_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_testimonials_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);
		
		$wp_customize->add_setting(
			'testimonials_cont_scode', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				 'default'          => '',
			)
		);

		$wp_customize->add_control(
			'testimonials_cont_scode', array(
				'label'          => __( 'Shortcode', 'storedesign' ),
				'description'    => __( 'To check shortcode please go to Testimonials -> How It Work<br> Ex: [sp_testimonials_slider slides_column="2"] ', 'storedesign' ),	
				'section' 	 => 'storedesign_testimonials_section',
				'priority' 	 => 4,
				'type'       	 => 'text',				
			)
		);

	/**
	Logo Showcase
	**/	
	$wp_customize->add_section(
		'storedesign_logoslider_section', array(
			'title'    => __( 'Logo Showcase', 'storedesign' ),
			'priority' => 5,
			'panel'    => 'panel_frontpage',
		)
	);
	
	/**Logo Showcase Content Inside **/
		$wp_customize->add_setting(
			'enable_logoslider_cont', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',				
			)
		);

		$wp_customize->add_control(
			'enable_logoslider_cont', array(
				'label'    		  => __( 'Enable Logo Slider', 'storedesign' ),
				'description'     => __( 'If Checked - This will show Logo Slider section from home page', 'storedesign' ),	
				'section' 		  => 'storedesign_logoslider_section',
				'priority' 		  => 1,
				'type'       	  => 'checkbox',
				
			)
		);	
		
		$wp_customize->add_setting(
			'logoslider_cont_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default'           => '',
			)
		);

		$wp_customize->add_control(
			'logoslider_cont_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_logoslider_section',
				'priority' 		  => 2,
				'type'       	  => 'text',				
			)
		);
		
		$wp_customize->add_setting(
			'logoslider_cont_scode', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				 'default'          =>  '',
			)
		);

		$wp_customize->add_control(
			'logoslider_cont_scode', array(
				'label'             => __( 'Shortcode', 'storedesign' ),
				'description'       => __( 'To check shortcode please go to Logo Showcase -> How It Work <br> Ex: [logoshowcase hide_border="true" slides_column="3"]', 'storedesign' ),	
				'section'           => 'storedesign_logoslider_section',
				'priority'          => 4,
				'type'              => 'text',				
			)
		);

	
	
	

	/**
	Latest From Blog
	**/	
	$wp_customize->add_section(
		'storedesign_ourblog_section', array(
			'title'    => __( 'Blog Post Section', 'storedesign' ),
			'priority' => 6,
			'panel'    => 'panel_frontpage',
		)
	);
	
	/**Our Blog Inside **/
		$wp_customize->add_setting(
			'enable_ourblog_cont', array(
				'sanitize_callback' => 'storedesign_sanitize_checkbox',
				'transport'         => 'refresh',				
			)
		);

		$wp_customize->add_control(
			'enable_ourblog_cont', array(
				'label'    		  => __( 'Enable Blog Section', 'storedesign' ),
				'description'     => __( 'If Checked - This will show Blog post section from home page', 'storedesign' ),	
				'section' 		  => 'storedesign_ourblog_section',
				'priority' 		  => 1,
				'type'       	  => 'checkbox',
				
			)
		);	
		
		$wp_customize->add_setting(
			'ourblog_cont_h', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				'default' 			=> '',
			)
		);

		$wp_customize->add_control(
			'ourblog_cont_h', array(
				'label'    		  => __( 'Title', 'storedesign' ),				
				'section' 		  => 'storedesign_ourblog_section',
				'priority' 		  => 2,
				'type'            => 'text',				
			)
		);
		
		$wp_customize->add_setting(
			'ourblog_cont_scode', array(
				'sanitize_callback' => 'storedesign_sanitize_clean',
				'transport'         => 'refresh',
				 'default'          =>  '',
			)
		);

		$wp_customize->add_control(
			'ourblog_cont_scode', array(
				'label'    		 => __( 'Shortcode', 'storedesign' ),
				'description'    => __( 'To check shortcode please go to Portfolio -> How It Work <br> Ex: [recent_post_slider speed="400" design="design-4" limit="10"]', 'storedesign' ),	
				'section' 	 	 => 'storedesign_ourblog_section',
				'priority' 		 => 4,
				'type'       	 => 'text',				
			)
		);
	
		}

		
		
		/**
		 * Get all of the Storedesign theme mods.
		 *
		 * @return array $storedesign_theme_mods The Storedesign Theme Mods.
		 */
		public function get_storedesign_theme_mods() {
			$storedesign_theme_mods = array(
				'background_color'            => storedesign_get_content_background_color(),
				'accent_color'                => get_theme_mod( 'storedesign_accent_color' ),
				'header_background_color'     => get_theme_mod( 'storedesign_header_background_color' ),
				'header_link_color'           => get_theme_mod( 'storedesign_header_link_color' ),
				'header_text_color'           => get_theme_mod( 'storedesign_header_text_color' ),
				'footer_background_color'     => get_theme_mod( 'storedesign_footer_background_color' ),
				'footer_link_color'           => get_theme_mod( 'storedesign_footer_link_color' ),
				'footer_heading_color'        => get_theme_mod( 'storedesign_footer_heading_color' ),
				'footer_text_color'           => get_theme_mod( 'storedesign_footer_text_color' ),
				'text_color'                  => get_theme_mod( 'storedesign_text_color' ),
				'heading_color'               => get_theme_mod( 'storedesign_heading_color' ),
				'button_background_color'     => get_theme_mod( 'storedesign_button_background_color' ),
				'button_text_color'           => get_theme_mod( 'storedesign_button_text_color' ),
				'button_alt_background_color' => get_theme_mod( 'storedesign_button_alt_background_color' ),
				'button_alt_text_color'       => get_theme_mod( 'storedesign_button_alt_text_color' ),
			);

			return apply_filters( 'storedesign_theme_mods', $storedesign_theme_mods );
		}

		/**
		 * Get Customizer css.
		 *
		 * @see get_storedesign_theme_mods()
		 * @return array $styles the css
		 */
		public function get_css() {
			$storedesign_theme_mods = $this->get_storedesign_theme_mods();
			$brighten_factor       = apply_filters( 'storedesign_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'storedesign_darken_factor', -25 );

			$styles                = '
			.main-navigation ul li a,
			.site-title a,
			ul.menu li a,
			.site-branding h1 a,			
			button.menu-toggle,
			button.menu-toggle:hover {
				color: ' . $storedesign_theme_mods['header_link_color'] . ';
			}

			button.menu-toggle,
			button.menu-toggle:hover {
				border-color: ' . $storedesign_theme_mods['header_link_color'] . ';
			}

			.main-navigation ul li a:hover,
			.main-navigation ul li:hover > a,
			.site-title a:hover,
			a.cart-contents:hover,
			.site-header-cart .widget_shopping_cart a:hover,
			.site-header-cart:hover > li > a,
			.site-header ul.menu li.current-menu-item > a {
				color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['header_link_color'], 65 ) . ';
			}

			

			.site-header,
			.secondary-navigation ul ul,
			.main-navigation ul.menu > li.menu-item-has-children:after,
			.secondary-navigation ul.menu ul,			
			button.menu-toggle,
			button.menu-toggle:hover {
				background-color: ' . $storedesign_theme_mods['header_background_color'] . ';
			}

			p.site-description,
			.site-header {
				color: ' . $storedesign_theme_mods['header_text_color'] . ';
			}

			
			button.menu-toggle:after,
			button.menu-toggle:before,
			button.menu-toggle span:before {
				background-color: ' . $storedesign_theme_mods['header_link_color'] . ';
			}

			.storedesign-handheld-footer-bar ul li.cart .count {
				color: ' . $storedesign_theme_mods['header_background_color'] . ';
			}

			.storedesign-handheld-footer-bar ul li.cart .count {
				border-color: ' . $storedesign_theme_mods['header_background_color'] . ';
			}

			h1, h2, h3, h4, h5, h6 {
				color: ' . $storedesign_theme_mods['heading_color'] . ';
			}

			.widget h1 {
				border-bottom-color: ' . $storedesign_theme_mods['heading_color'] . ';
			}

			body,
			.secondary-navigation a,
			.onsale,
			.pagination .page-numbers li .page-numbers:not(.current), .woocommerce-pagination .page-numbers li .page-numbers:not(.current) {
				color: ' . $storedesign_theme_mods['text_color'] . ';
			}

			.widget-area .widget a,			
			.hentry .entry-header .byline a {
				color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['text_color'], 5 ) . ';
			}

			a  {
				color: ' . $storedesign_theme_mods['accent_color'] . ';
			}

			a:focus,
			.button:focus,
			.button.alt:focus,
			.button.added_to_cart:focus,
			.button.wc-forward:focus,
			button:focus,
			input[type="button"]:focus,
			input[type="reset"]:focus,
			input[type="submit"]:focus {
				outline-color: ' . $storedesign_theme_mods['accent_color'] . ';
			}

			button, input[type="button"], input[type="reset"], input[type="submit"], .button, .added_to_cart, .widget a.button, .site-header-cart .widget_shopping_cart a.button {
				background-color: ' . $storedesign_theme_mods['button_background_color'] . ';
				border-color: ' . $storedesign_theme_mods['button_background_color'] . ';
				color: ' . $storedesign_theme_mods['button_text_color'] . ';
			}

			button:hover, input[type="button"]:hover, input[type="reset"]:hover, input[type="submit"]:hover, .button:hover, .added_to_cart:hover, .widget a.button:hover, .site-header-cart .widget_shopping_cart a.button:hover {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $storedesign_theme_mods['button_text_color'] . ';
			}

			button.alt, input[type="button"].alt, input[type="reset"].alt, input[type="submit"].alt, .button.alt, .added_to_cart.alt, .widget-area .widget a.button.alt, .added_to_cart, .widget a.button.checkout {
				background-color: ' . $storedesign_theme_mods['button_alt_background_color'] . ';
				border-color: ' . $storedesign_theme_mods['button_alt_background_color'] . ';
				color: ' . $storedesign_theme_mods['button_alt_text_color'] . ';
			}

			button.alt:hover, input[type="button"].alt:hover, input[type="reset"].alt:hover, input[type="submit"].alt:hover, .button.alt:hover, .added_to_cart.alt:hover, .widget-area .widget a.button.alt:hover, .added_to_cart:hover, .widget a.button.checkout:hover {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				border-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['button_alt_background_color'], $darken_factor ) . ';
				color: ' . $storedesign_theme_mods['button_alt_text_color'] . ';
			}

			.pagination .page-numbers li .page-numbers.current, .woocommerce-pagination .page-numbers li .page-numbers.current {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], $darken_factor ) . ';
				color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['text_color'], -10 ) . ';
			}

			#comments .comment-list .comment-content .comment-text {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -7 ) . ';
			}

			.site-footer {
				background-color: ' . $storedesign_theme_mods['footer_background_color'] . ';
				color: ' . $storedesign_theme_mods['footer_text_color'] . ';
			}

			.site-footer a:not(.button) {
				color: ' . $storedesign_theme_mods['footer_link_color'] . ';
			}

			.site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6 {
				color: ' . $storedesign_theme_mods['footer_heading_color'] . ';
			}

			

			#payment .payment_methods > li .payment_box,
			#payment .place-order {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -5 ) . ';
			}

			#payment .payment_methods > li:not(.woocommerce-notice) {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -10 ) . ';
			}

			#payment .payment_methods > li:not(.woocommerce-notice):hover {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -15 ) . ';
			}

			@media screen and ( min-width: 768px ) {
				.secondary-navigation ul.menu a:hover {
					color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['header_text_color'], $brighten_factor ) . ';
				}

				.secondary-navigation ul.menu a {
					color: ' . $storedesign_theme_mods['header_text_color'] . ';
				}

				.site-header-cart .widget_shopping_cart,
				.main-navigation ul.menu ul.sub-menu,
				.main-navigation ul.nav-menu ul.children {
					background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['header_background_color'], -15 ) . ';
				}

				.site-header-cart .widget_shopping_cart .buttons,
				.site-header-cart .widget_shopping_cart .total {
					background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['header_background_color'], -10 ) . ';
				}

				
			}';

			return apply_filters( 'storedesign_customizer_css', $styles );
		}

		/**
		 * Get Customizer css associated with WooCommerce.
		 *
		 * @see get_storedesign_theme_mods()
		 * @return array $woocommerce_styles the WooCommerce css
		 */
		public function get_woocommerce_css() {
			$storedesign_theme_mods = $this->get_storedesign_theme_mods();
			$brighten_factor       = apply_filters( 'storedesign_brighten_factor', 25 );
			$darken_factor         = apply_filters( 'storedesign_darken_factor', -25 );

			$woocommerce_styles    = '
			a.cart-contents,
			.site-header-cart .widget_shopping_cart a {
				color: ' . $storedesign_theme_mods['header_link_color'] . ';
			}			

			.woocommerce-tabs ul.tabs li.active a,
			ul.products li.product .price,			
			.widget_search form:before,
			.widget_product_search form:before {
				color: ' . $storedesign_theme_mods['text_color'] . ';
			}

			.woocommerce-breadcrumb a,
			a.woocommerce-review-link,
			.product_meta a {
				color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['text_color'], 5 ) . ';
			}

			.onsale {
				border-color: ' . $storedesign_theme_mods['text_color'] . ';
			}

			.star-rating span:before,
			.quantity .plus, .quantity .minus,
			p.stars a:hover:after,
			p.stars a:after,
			.star-rating span:before,
			#payment .payment_methods li input[type=radio]:first-child:checked+label:before {
				color: ' . $storedesign_theme_mods['accent_color'] . ';
			}

			.widget_price_filter .ui-slider .ui-slider-range,
			.widget_price_filter .ui-slider .ui-slider-handle {
				background-color: ' . $storedesign_theme_mods['accent_color'] . ';
			}

			.order_details {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -7 ) . ';
			}

			.order_details > li {
				border-bottom: 1px dotted ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -28 ) . ';
			}

			.order_details:before,
			.order_details:after {
				background: -webkit-linear-gradient(transparent 0,transparent 0),-webkit-linear-gradient(135deg,' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%),-webkit-linear-gradient(45deg,' . storedesign_adjust_color_brightness( $storedesign_theme_mods['background_color'], -7 ) . ' 33.33%,transparent 33.33%)
			}

			p.stars a:before,
			p.stars a:hover~a:before,
			p.stars.selected a.active~a:before {
				color: ' . $storedesign_theme_mods['text_color'] . ';
			}

			p.stars.selected a.active:before,
			p.stars:hover a:before,
			p.stars.selected a:not(.active):before,
			p.stars.selected a.active:before {
				color: ' . $storedesign_theme_mods['accent_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger {
				background-color: ' . $storedesign_theme_mods['button_background_color'] . ';
				color: ' . $storedesign_theme_mods['button_text_color'] . ';
			}

			.single-product div.product .woocommerce-product-gallery .woocommerce-product-gallery__trigger:hover {
				background-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['button_background_color'], $darken_factor ) . ';
				border-color: ' . storedesign_adjust_color_brightness( $storedesign_theme_mods['button_background_color'], $darken_factor ) . ';
				color: ' . $storedesign_theme_mods['button_text_color'] . ';
			}

			.button.loading {
				color: ' . $storedesign_theme_mods['button_background_color'] . ';
			}

			.button.loading:hover {
				background-color: ' . $storedesign_theme_mods['button_background_color'] . ';
			}

			.button.loading:after {
				color: ' . $storedesign_theme_mods['button_text_color'] . ';
			}

			@media screen and ( min-width: 768px ) {
				.site-header-cart .widget_shopping_cart,
				.site-header .product_list_widget li .quantity {
					color: ' . $storedesign_theme_mods['header_text_color'] . ';
				}
			}';

			return apply_filters( 'storedesign_customizer_woocommerce_css', $woocommerce_styles );
		}

		/**
		 * Assign Storedesign styles to individual theme mods.
		 *
		 * @return void
		 */
		public function set_storedesign_style_theme_mods() {
			set_theme_mod( 'storedesign_styles', $this->get_css() );
			set_theme_mod( 'storedesign_woocommerce_styles', $this->get_woocommerce_css() );
		}

		/**
		 * Add CSS in <head> for styles handled by the theme customizer
		 * If the Customizer is active pull in the raw css. Otherwise pull in the prepared theme_mods if they exist.
		 *
		 * @since   0.1.0
		 * @return void
		 */
		public function add_customizer_css() {
			$storedesign_styles             = get_theme_mod( 'storedesign_styles' );
			$storedesign_woocommerce_styles = get_theme_mod( 'storedesign_woocommerce_styles' );

			if ( is_customize_preview() || ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) || ( false === $storedesign_styles && false === $storedesign_woocommerce_styles ) ) {
				wp_add_inline_style( 'storedesign-style', $this->get_css() );
				wp_add_inline_style( 'storedesign-woocommerce-style', $this->get_woocommerce_css() );
			} else {
				wp_add_inline_style( 'storedesign-style', get_theme_mod( 'storedesign_styles' ) );
				wp_add_inline_style( 'storedesign-woocommerce-style', get_theme_mod( 'storedesign_woocommerce_styles' ) );
			}
		}

		/**
		 * Layout classes
		 * Adds 'right-sidebar' and 'left-sidebar' classes to the body tag
		 *
		 * @param  array $classes current body classes.
		 * @return string[]          modified body classes
		 * @since   0.1
		 */
		public function layout_class( $classes ) {
			$left_or_right = get_theme_mod( 'storedesign_layout' );

			$classes[] = $left_or_right . '-sidebar';

			return $classes;
		}

		/**
		 * Add CSS for custom controls
		 *
		 * This function incorporates CSS from the Kirki Customizer Framework
		 *
		 * The Kirki Customizer Framework, Copyright Aristeides Stathopoulos (@aristath),
		 * is licensed under the terms of the GNU GPL, Version 2 (or later)
		 *
		 * @link https://github.com/reduxframework/kirki/
		 * @since  1.5.0
		 */
		public function customizer_custom_control_css() {
			?>
			<style>
			.customize-control-radio-image input[type=radio] {
				display: none;
			}

			.customize-control-radio-image label {
				display: block;
				width: 48%;
				float: left;
				margin-right: 4%;
			}

			.customize-control-radio-image label:nth-of-type(2n) {
				margin-right: 0;
			}

			.customize-control-radio-image img {
				opacity: .5;
			}

			.customize-control-radio-image input[type=radio]:checked + label img,
			.customize-control-radio-image img:hover {
				opacity: 1;
			}

			</style>
			<?php
		}

		/**
		 * Get site logo.
		 *
		 * @since   0.1
		 * @return string
		 */
		public function get_site_logo() {
			return storedesign_site_title_or_logo( false );
		}

		/**
		 * Get site name.
		 *
		 * @since   0.1
		 * @return string
		 */
		public function get_site_name() {
			return get_bloginfo( 'name', 'display' );
		}

		/**
		 * Get site description.
		 *
		 * @since   0.1
		 * @return string
		 */
		public function get_site_description() {
			return get_bloginfo( 'description', 'display' );
		}
	}

endif;

return new Storedesign_Customizer();