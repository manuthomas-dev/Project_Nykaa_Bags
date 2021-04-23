<?php
/**
 * Storedesign  functions.
 *
 * @package storedesign
 */

if ( ! function_exists( 'storedesign_is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function storedesign_is_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

/**
 * Checks if the current page is a product archive
 * @return boolean
 */
function storedesign_is_product_archive() {
	if ( storedesign_is_woocommerce_activated() ) {
		if ( is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag() ) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

/**
 * Call a shortcode function by tag name.
 *
 * @since   0.1
 *
 * @param string $tag     The shortcode whose function to call.
 * @param array  $atts    The attributes to pass to the shortcode function. Optional.
 * @param array  $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 */
function storedesign_do_shortcode( $tag, array $atts = array(), $content = null ) {
	global $shortcode_tags;

	if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	}

	return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
}

/**
 * Get the content background color
 * Accounts for the Storedesign Designer and Storedesign Powerpack content background option.
 *
 * @since  1.6.0
 * @return string the background color
 */
function storedesign_get_content_background_color() {
	if ( class_exists( 'Storedesign_Designer' ) ) {
		$content_bg_color = get_theme_mod( 'sd_content_background_color' );
		$content_frame    = get_theme_mod( 'sd_fixed_width' );
	}

	if ( class_exists( 'Storedesign_Powerpack' ) ) {
		$content_bg_color = get_theme_mod( 'sp_content_frame_background' );
		$content_frame    = get_theme_mod( 'sp_content_frame' );
	}

	$bg_color = str_replace( '#', '', get_theme_mod( 'background_color' ) );

	if ( class_exists( 'Storedesign_Powerpack' ) || class_exists( 'Storedesign_Designer' ) ) {
		if ( $content_bg_color && ( 'true' == $content_frame || 'frame' == $content_frame ) ) {
			$bg_color = str_replace( '#', '', $content_bg_color );
		}
	}

	return '#' . $bg_color;
}


/**
 * Apply inline style to the Storedesign header.
 *
 * @uses  get_header_image()
 * @since   0.1
 */
function storedesign_header_styles() {
	$is_header_image = get_header_image();
	$header_bg_image = '';

	if ( $is_header_image ) {
		$header_bg_image = 'url(' . esc_url( $is_header_image ) . ')';
	}

	$styles = array();

	if ( '' !== $header_bg_image ) {
		$styles['background-image'] = $header_bg_image;
	}

	$styles = apply_filters( 'storedesign_header_styles', $styles );

	foreach ( $styles as $style => $value ) {
		echo esc_attr( $style . ': ' . $value . '; ' );
	}
}


/**
 * Apply inline style to the Storedesign homepage content.
 *
 * @uses  get_the_post_thumbnail_url()
 * @since  2.2.0
 */
function storedesign_homepage_content_styles() {
	$featured_image   = get_the_post_thumbnail_url( get_the_ID() );
	$background_image = '';

	if ( $featured_image ) {
		$background_image = 'url(' . esc_url( $featured_image ) . ')';
	}

	$styles = array();

	if ( '' !== $background_image ) {
		$styles['background-image'] = $background_image;
	}	

	$styles = apply_filters( 'storedesign_homepage_content_styles', $styles );

	foreach ( $styles as $style => $value ) {
		echo esc_attr( $style . ': ' . $value . '; ' );
	}
}


/**
 * Adjust a hex color brightness
 * Allows us to create hover styles for custom link colors
 *
 * @param  strong  $hex   hex color e.g. #111111.
 * @param  integer $steps factor by which to brighten/darken ranging from -255 (darken) to 255 (brighten).
 * @return string        brightened/darkened hex color
 * @since   0.1
 */
function storedesign_adjust_color_brightness( $hex, $steps ) {
	// Steps should be between -255 and 255. Negative = darker, positive = lighter.
	$steps  = max( -255, min( 255, $steps ) );

	// Format the hex color string.
	$hex    = str_replace( '#', '', $hex );

	if ( 3 == strlen( $hex ) ) {
		$hex    = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Get decimal values.
	$r  = hexdec( substr( $hex, 0, 2 ) );
	$g  = hexdec( substr( $hex, 2, 2 ) );
	$b  = hexdec( substr( $hex, 4, 2 ) );

	// Adjust number of steps and keep it inside 0 to 255.
	$r  = max( 0, min( 255, $r + $steps ) );
	$g  = max( 0, min( 255, $g + $steps ) );
	$b  = max( 0, min( 255, $b + $steps ) );

	$r_hex  = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex  = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex  = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 * @since  1.3.0
 */
function storedesign_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}


/**
 * Clean variables using sanitize_text_field. Arrays are cleaned recursively.
 * Non-scalar values are ignored.
 * 
 * @package WP iClean Responsive
 * @since   0.1
 */
function storedesign_sanitize_clean( $var ) {
	if ( is_array( $var ) ) {
		return array_map( 'storedesign_sanitize_clean', $var );
	} else {
		$data = is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
		return wp_unslash($data);
	}
}

function storedesign_sanitize_textarea_field( $str ) {
    $filtered = _sanitize_text_fields( $str, true );
 
    /**
     * Filters a sanitized textarea field string.
     *
     * @since 4.7.0
     *
     * @param string $filtered The sanitized string.
     * @param string $str      The string prior to being sanitized.
     */
    return apply_filters( 'storedesign_sanitize_textarea_field', $filtered, $str );
}

/**
 * Strip Html Tags
 * It will sanitize text input (strip html tags, and escape characters)
 * 
 * @package WP iClean Responsive
 * @since   0.1
 */
function storedesign_sanitize_nohtml_kses($data = array()) {

	if ( is_array($data) ) {

	$data = array_map('storedesign_sanitize_nohtml_kses', $data);

	} elseif ( is_string( $data ) ) {
		$data = trim( $data );
		$data = wp_filter_nohtml_kses($data);
	}

	return $data;
}

/**
 * Checkbox sanitization callback.
 *
 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
 * as a boolean value, either TRUE or FALSE.
 *
 * @param bool $checked Whether the checkbox is checked.
 * @return bool Whether the checkbox is checked.
 * @since  1.5.0
 */
function storedesign_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitize URL
 * 
 * @package Storedesign
 * @since   0.1
 */
function storedesign_sanitize_url( $url ) {
	return esc_url_raw( trim($url) );
}

/**
 * Social icon header
 *
 * @package storedesign
 * @since   0.1
 */

function storedesign_get_social_icon() {

		$facebook 		= get_theme_mod( 'facebook' ); 
		$twitter 		= get_theme_mod( 'twitter' );
		$linkedin 		= get_theme_mod( 'linkedin' );
		$behance 		= get_theme_mod( 'behance' );   
		$dribbble 		= get_theme_mod( 'dribbble' );
		$instagram 		= get_theme_mod( 'instagram' );
		$youtube 		= get_theme_mod( 'youtube' );
		$pinterest  	= get_theme_mod( 'pinterest' );

     	if(!empty($facebook) ) { ?>   
	            <a href="<?php echo esc_url($facebook); ?>" title="<?php esc_attr_e('Facebook','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-facebook-icon"><i class="fa fa-facebook"></i></a>
	    <?php } 
	    if(!empty($twitter) ) { ?>  
	            <a href="<?php echo esc_url($twitter); ?>" title="<?php esc_attr_e('Twitter','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-twitter-icon"><i class="fa fa-twitter"></i></a>
	    <?php } 
	    if(!empty($linkedin) ) { ?> 
	            <a href="<?php echo esc_url($linkedin); ?>" title="<?php esc_attr_e('LinkedIn','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-linkedin-icon"><i class="fa fa-linkedin"></i></a>
	    <?php } 
	    if(!empty($youtube)) { ?>       
	            <a href="<?php echo esc_url($youtube); ?>" title="<?php esc_attr_e('YouTube','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-youtube-icon"><i class="fa fa-youtube"></i></a>             
	    <?php } 
	    if(!empty($instagram) ) { ?>        
	            <a href="<?php echo esc_url($instagram); ?>" title="<?php esc_attr_e('Instagram','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-instagram-icon"><i class="fa fa-instagram"></i></a>             
	    <?php } 
	    if(!empty($behance) ) { ?>      
	            <a href="<?php echo esc_url($behance); ?>" title="<?php esc_attr_e('Behance','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-behance-icon"><i class="fa fa-behance"></i></a>             
	    <?php } 
	    if(!empty($dribbble) ) { ?>     
	            <a href="<?php echo esc_url($dribbble); ?>" title="<?php esc_attr_e('Dribbble','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-dribbble-icon"><i class="fa fa-dribbble"></i></a>             
	    <?php }
	    if(!empty($pinterest) ) { ?>      
                <a href="<?php echo esc_url($pinterest); ?>" title="<?php esc_attr_e('Pinterest','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-pinterest-icon"><i class="fa fa-pinterest"></i></a>             
	    <?php } 

}

/**
 * Social icon Footer
 *
 * @package storedesign
 * @since   0.1
 */

function storedesign_get_footer_social_icon() {

		$facebook 		= get_theme_mod( 'facebook' ); 
		$twitter 		= get_theme_mod( 'twitter' );
		$linkedin 		= get_theme_mod( 'linkedin' );
		$behance 		= get_theme_mod( 'behance' );   
		$dribbble 		= get_theme_mod( 'dribbble' );
		$instagram 		= get_theme_mod( 'instagram' );
		$youtube 		= get_theme_mod( 'youtube' );
		$pinterest      = get_theme_mod( 'pinterest' );

     	if(!empty($facebook) ) { ?>	
       		<a href="<?php echo esc_url($facebook); ?>" title="<?php esc_attr_e('Facebook','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-facebook-icon"><i class="fa fa-facebook"></i> <span class="storedesign-social-text"><?php esc_html_e( 'Facebook', 'storedesign' ); ?></span></a>
		<?php } 
		if(!empty($twitter) ) { ?>	
			<a href="<?php echo esc_url($twitter); ?>" title="<?php esc_attr_e('Twitter','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-twitter-icon"><i class="fa fa-twitter"></i> <span class="storedesign-social-text"><?php esc_html_e( 'Twitter', 'storedesign' ); ?></span></a>
		<?php } 
		if(!empty($linkedin) ) { ?>	
			<a href="<?php echo esc_url($linkedin); ?>" title="<?php esc_attr_e('LinkedIn','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-linkedin-icon"><i class="fa fa-linkedin"></i> <span class="storedesign-social-text"><?php esc_html_e( 'LinkedIn', 'storedesign' ); ?></span></a>
		<?php } 
		if(!empty($youtube)) { ?>		
			<a href="<?php echo esc_url($youtube); ?>" title="<?php esc_attr_e('YouTube','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-youtube-icon"><i class="fa fa-youtube"></i> <span class="storedesign-social-text"><?php esc_html_e( 'YouTube', 'storedesign' ); ?></span></a>				
		<?php } 
		if(!empty($instagram) ) { ?>		
			<a href="<?php echo esc_url($instagram); ?>" title="<?php esc_attr_e('Instagram','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-instagram-icon"><i class="fa fa-instagram"></i> <span class="storedesign-social-text"><?php esc_html_e( 'Instagram', 'storedesign' ); ?></span></a>				
		<?php } 
		if(!empty($behance) ) { ?>		
			<a href="<?php echo esc_url($behance); ?>" title="<?php esc_attr_e('Behance','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-behance-icon"><i class="fa fa-behance"></i> <span class="storedesign-social-text"><?php esc_html_e( 'Behance', 'storedesign' ); ?></span></a>				
		<?php } 

		if(!empty($dribbble) ) { ?>		
			<a href="<?php echo esc_url($dribbble); ?>" title="<?php esc_attr_e('Dribbble','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-dribbble-icon"><i class="fa fa-dribbble"></i> <span class="storedesign-social-text"><?php esc_html_e( 'Dribbble', 'storedesign' ); ?></span></a>				
		<?php } 

		if(!empty($pinterest) ) { ?>		
			<a href="<?php echo esc_url($pinterest); ?>" title="<?php esc_attr_e('Pinterest','storedesign'); ?>" target="_blank" class="storedesign-social-network-icon storedesign-pinterest-icon"><i class="fa fa-pinterest"></i> <span class="storedesign-social-text"><?php esc_html_e( 'Pinterest', 'storedesign' ); ?></span></a>				
		<?php }

}

/**
 * Handles the footer copy right text
 *
 * @package Storedesign
 * @since   0.1
 */
function storedesign_footer_copyright() {
	
	$current_year 	= date( 'Y', current_time('timestamp') );
	$copyright_text = get_theme_mod( 'copyright' );
	$copyright_text = str_replace('{year}', $current_year, $copyright_text);

	return apply_filters( 'storedesign_footer_copyright', $copyright_text);

}

if ( ! function_exists( 'is_woocommerce_activated' ) ) {
	/**
	 * Query WooCommerce activation
	 */
	function is_woocommerce_activated() {
		_deprecated_function( 'is_woocommerce_activated', '2.1.6', 'storedesign_is_woocommerce_activated' );

		return class_exists( 'woocommerce' ) ? true : false;
	}
}

/**
 * Schema type
 *
 * @return void
 */
function storedesign_html_tag_schema() {
	_deprecated_function( 'storedesign_html_tag_schema', '2.0.2' );

	$schema = 'http://schema.org/';
	$type   = 'WebPage';

	if ( is_singular( 'post' ) ) {
		$type = 'Article';
	} elseif ( is_author() ) {
		$type = 'ProfilePage';
	} elseif ( is_search() ) {
		$type 	= 'SearchResultsPage';
	}

	echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( $type ) . '"';
}

/**
 * Sanitizes the layout setting
 *
 * Ensures only array keys matching the original settings specified in add_control() are valid
 *
 * @param array $input the layout options.
 * @since   0.1.3
 */
function storedesign_sanitize_layout( $input ) {
	_deprecated_function( 'storedesign_sanitize_layout', '2.0', 'storedesign_sanitize_choices' );

	$valid = array(
		'right' => 'Right',
		'left'  => 'Left',
	);

	if ( array_key_exists( $input, $valid ) ) {
		return $input;
	} else {
		return '';
	}
}

/**
 * Storedesign Sanitize Hex Color
 *
 * @param string $color The color as a hex.
 * @todo remove in 2.1.
 */
function storedesign_sanitize_hex_color( $color ) {
	_deprecated_function( 'storedesign_sanitize_hex_color', '2.0', 'sanitize_hex_color' );

	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}
	
if ( ! function_exists( 'storedesign_fonts_url' ) ) {
/**
 * Register Google fonts for Storedesign.
 * Create your own lite_fonts_url() function to override in a child theme.
 * @return string Google fonts URL for the theme.
 */
function storedesign_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Poppins, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Poppins font: on or off', 'storedesign' ) ) {
		$fonts[] = 'Poppins:400,500';
	}
	/* translators: If there are characters in your language that are not supported by Roboto, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'storedesign' ) ) {
		$fonts[] = 'Roboto:400,500';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
}	