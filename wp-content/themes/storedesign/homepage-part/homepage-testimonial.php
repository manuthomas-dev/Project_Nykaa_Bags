<?php

$testimonials_setting_h = get_theme_mod( 'testimonials_cont_h');		
		$testimonials_cont_scode = get_theme_mod( 'testimonials_cont_scode' );
		$testimonials_enable = get_theme_mod( 'enable_testimonials_cont' );
			
			if ($testimonials_enable ) {

				echo '<section class="storedesign-product-section storedesign-testimonials" aria-label="' . esc_attr__( 'Testimonial', 'storedesign' ) . '">';

				echo '<h2 class="section-title">' . esc_html($testimonials_setting_h) . '</h2>';	

					echo do_shortcode( wp_kses_post($testimonials_cont_scode) );

				echo '</section>';
			}
?>