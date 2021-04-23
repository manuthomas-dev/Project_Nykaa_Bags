<?php

	$logoslider_setting_h = get_theme_mod( 'logoslider_cont_h' );	
	$logoslider_cont_scode = get_theme_mod( 'logoslider_cont_scode');
	$logoslider_enable = get_theme_mod( 'enable_logoslider_cont' );
			
			if ($logoslider_enable ) {

				echo '<section class="storedesign-product-section storedesign-logoslider" aria-label="' . esc_attr__( 'Logoslider', 'storedesign' ) . '">';

				echo '<h2 class="section-title">' . esc_html($logoslider_setting_h) . '</h2>';	

					echo do_shortcode( wp_kses_post($logoslider_cont_scode) );

				echo '</section>';
			}	
?>