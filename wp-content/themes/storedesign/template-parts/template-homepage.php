<?php
/**
 * The template for displaying the homepage.
 *
 * Template name: Homepage
 *
 * @package storedesign
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				// Home Banner Section
				storedesign_homepage_content(10);
				// Display Product Category
				get_template_part( 'homepage-part/homepage', 'category' );
				// Display Recent Products
				get_template_part( 'homepage-part/homepage', 'product-slider' );
				
				get_template_part( 'homepage-part/homepage', 'onsale-product' );
			
				// Display Testimonial
				get_template_part( 'homepage-part/homepage', 'testimonial' );
				// Dispaly Logo Slider
				get_template_part( 'homepage-part/homepage', 'logo-slider' );
				// Display Latest Blog 
				get_template_part( 'homepage-part/homepage', 'latest-blog' );
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
