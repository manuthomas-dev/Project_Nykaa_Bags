<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package storedesign
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<div class="error-404 not-found">

				<div class="page-content">
					<div class="error-image">
						<img alt="<?php esc_attr_e( '404', 'storedesign' ); ?>" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/404.png' ); ?>" />
					</div>
					<header class="page-header">
						<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'storedesign' ); ?></h1>
					</header><!-- .page-header -->

					<p class="page-desc"><?php esc_html_e( 'Nothing was found at this location. Try searching, or check out the links below.', 'storedesign' ); ?></p>

					<?php
					echo '<section aria-label="' . esc_html__( 'Search', 'storedesign' ) . '">';

					if ( storedesign_is_woocommerce_activated() ) {
						the_widget( 'WC_Widget_Product_Search' );
					} else {
						get_search_form();
					}

					echo '</section>';

					if ( storedesign_is_woocommerce_activated() ) {

						echo '<div class="fourohfour-columns-2">';

							echo '<section class="col-full-404" aria-label="' . esc_html__( 'Promoted Products', 'storedesign' ) . '">';

								storedesign_promoted_products();

							echo '</section>';							
						echo '</div>';

						echo '<section aria-label="' . esc_html__( 'Popular Products', 'storedesign' ) . '">';

							echo '<h2 class="section-title">' . esc_html__( 'Popular Products', 'storedesign' ) . '</h2>';

							echo storedesign_do_shortcode( 'best_selling_products', array(
								'per_page' => 4,
								'columns'  => 4,
							) );

						echo '</section>';
					}
					?>

				</div><!-- .page-content -->
			</div><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer();
