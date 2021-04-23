<?php

$ourblog_setting_h = get_theme_mod( 'ourblog_cont_h' );		
		$ourblog_cont_scode = get_theme_mod( 'ourblog_cont_scode' );
		$ourblog_enable = get_theme_mod( 'enable_ourblog_cont' );
			
			if ($ourblog_enable ) {

				echo '<section class="storedesign-product-section storedesign-latestblog" aria-label="' . esc_attr__( 'Blog & News', 'storedesign' ) . '">';

				echo '<h2 class="section-title">' . esc_html($ourblog_setting_h) . '</h2>';	

					echo do_shortcode(wp_kses_post($ourblog_cont_scode));

				echo '</section>';
			}	

?>