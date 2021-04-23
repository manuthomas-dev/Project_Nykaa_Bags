<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package storedesign
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
			<?php
			storedesign_post_thumbnail( 'full' );
			the_title( '<h1 class="entry-title">', '</h1>' );
			?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'storedesign' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->	
</div><!-- #post-## -->
