<?php
/**
 * The template for displaying full width pages.
 *
 * Template Name: Full width
 *
 * @package storedesign
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post();	

				get_template_part( 'content-part/content', 'page' );

				storedesign_display_comments();

			endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
