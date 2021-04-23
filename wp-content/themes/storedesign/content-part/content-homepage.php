<?php
/**
 * The template used for displaying page content in template-homepage.php
 *
 * @package storedesign
 */

?>
<?php
$featured_image = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="<?php storedesign_homepage_content_styles(); ?>" data-featured-image="<?php echo esc_url($featured_image); ?>">
	<div class="banner-image-overlay">
		<div class="col-full">			
			<?php			
			edit_post_link( __( 'Edit this section', 'storedesign' ), '', '', '', 'button storedesign-hero__button-edit' );
			?>
		<header class="entry-header">
			<?php
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
		</div>
	</div>
</div><!-- #post-## -->
