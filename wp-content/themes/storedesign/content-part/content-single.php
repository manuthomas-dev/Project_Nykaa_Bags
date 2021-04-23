<?php
/**
 * Template used to display post content on single pages.
 *
 * @package storedesign
 */

?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		get_template_part( 'content-part/content', 'media' );	
		the_title( '<h1 class="entry-title">', '</h1>' );		
		?>
		</header><!-- .entry-header -->
		<div class="entry-content">
		<?php		
		the_content();
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storedesign' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
	<?php	
	storedesign_post_nav();
	storedesign_display_comments();
	?>

</div><!-- #post-## -->
