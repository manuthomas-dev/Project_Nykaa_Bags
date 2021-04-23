<?php
/**
 * Template used to display post content.
 *
 * @package storedesign
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php			
		get_template_part( 'content-part/content', 'media' );
		the_title( sprintf( '<h2 class="alpha entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		
		?>
		</header><!-- .entry-header -->
		<div class="entry-content">
		<?php		
		$ismore = ! empty( $post->post_content ) ? strpos( $post->post_content, '<!--more-->' ) : '';
        if ( ! empty( $ismore ) ) {
                /* translators: %s: Name of current post */
                the_content( sprintf(
                                esc_html__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'storedesign' ),
                                get_the_title()
                        ) );
        } else {
                the_excerpt();				
        }	

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storedesign' ),
			'after'  => '</div>',
		) );
		?>
		</div><!-- .entry-content -->
</article><!-- #post-## -->
