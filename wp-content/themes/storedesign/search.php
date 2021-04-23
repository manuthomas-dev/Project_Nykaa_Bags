<?php
/**
 * The template for displaying search results pages.
 *
 * @package storedesign
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( esc_attr__( 'Search Results for: %s', 'storedesign' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header><!-- .page-header -->

			<?php get_template_part( 'loop' );

		else :

			get_template_part( 'content-part/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
storedesign_get_sidebar();
get_footer();
