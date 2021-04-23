<?php
/**
 * Function to excerpt more
 * 
 * @package storedesign
 * @since   0.1
 */
function storedesign_excerpt_more( $more ) {
	if ( ! is_admin() ) {
		return '...';
	}
}
add_filter('excerpt_more', 'storedesign_excerpt_more');

/**
 * Auto add more links.
 *
 * @package storedesign
 * @since   0.1
 */
function storedesign_content_more() {	
	/* translators: link read more. */
	$text = wp_kses_post( sprintf( esc_html__( 'Continue reading &#10142; %s', 'storedesign' ), '<span class="screen-reader-text">' . get_the_title() . '</span>' ) );
	$more = sprintf( '<div class="link-more"><a href="%s#more-%d" class="more-link">%s</a></div>', esc_url( get_permalink() ), get_the_ID(), $text );
	if ( ! is_admin() ) {
		return $more;
	}
}
add_filter( 'the_content_more_link', 'storedesign_content_more' );

/**
 * Auto add more links.
 * 
 * @package storedesign
 * @since   0.1
 */
function storedesign_excerpt_more_link( $excerpt ) {
    if ( ! is_admin() ) {
		$excerpt 	.= storedesign_content_more();
		return $excerpt;
	}
}
add_filter( 'the_excerpt', 'storedesign_excerpt_more_link', 21 );

/**
 * Storedesign template functions.
 *
 * @package storedesign
 */

if ( ! function_exists( 'storedesign_display_comments' ) ) {
	/**
	 * Storedesign display comments
	 *
	 * @since   0.1
	 */
	function storedesign_display_comments() {
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || '0' != get_comments_number() ) :
			comments_template();
		endif;
	}
}

if ( ! function_exists( 'storedesign_comment' ) ) {
	/**
	 * Storedesign comment template
	 *
	 * @param array $comment the comment array.
	 * @param array $args the comment args.
	 * @param int   $depth the comment depth.
	 * @since   0.1.0
	 */
	function storedesign_comment( $comment, $args, $depth ) {
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
		?>
		<<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-body">
		<div class="comment-meta commentmetadata">
			<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 128 ); ?>
			<?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'storedesign' ), get_comment_author_link() ); ?>
			</div>
			<?php if ( '0' == $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'storedesign' ); ?></em>
				<br />
			<?php endif; ?>

			<a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
				<?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
			</a>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>" class="comment-content">
		<?php endif; ?>
		<div class="comment-text">
		<?php comment_text(); ?>
		</div>
		<div class="reply">
		<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		<?php edit_comment_link( __( 'Edit', 'storedesign' ), '  ', '' ); ?>
		</div>
		</div>
		<?php if ( 'div' != $args['style'] ) : ?>
		</div>
		<?php endif; ?>
	<?php
	}
}

if ( ! function_exists( 'storedesign_footer_widgets' ) ) {
	/**
	 * Display the footer widget regions.
	 *
	 * @since   0.1
	 * @return void
	 */
	function storedesign_footer_widgets() {
		$rows    = intval( apply_filters( 'storedesign_footer_widget_rows', 1 ) );
		$regions = intval( apply_filters( 'storedesign_footer_widget_columns', 4 ) );

		for ( $row = 1; $row <= $rows; $row++ ) :

			// Defines the number of active columns in this footer row.
			for ( $region = $regions; 0 < $region; $region-- ) {
				if ( is_active_sidebar( 'footer-' . strval( $region + $regions * ( $row - 1 ) ) ) ) {
					$columns = $region;
					break;
				}
			}

			if ( isset( $columns ) ) : ?>
				<div class=<?php echo '"footer-widgets row-' . strval( $row ) . ' col-' . strval( $columns ) . ' fix"'; ?>><?php

					for ( $column = 1; $column <= $columns; $column++ ) :
						$footer_n = $column + $regions * ( $row - 1 );

						if ( is_active_sidebar( 'footer-' . strval( $footer_n ) ) ) : ?>

							<div class="block footer-widget-<?php echo strval( $column ); ?>">
								<?php dynamic_sidebar( 'footer-' . strval( $footer_n ) ); ?>
							</div><?php

						endif;
					endfor; ?>

				</div><!-- .footer-widgets.row-<?php echo strval( $row ); ?> --><?php

				unset( $columns );
			endif;
		endfor;
	}
}

if ( ! function_exists( 'storedesign_post_meta' ) ) {
	/**
	 * Display the post meta
	 *
	 * @since   0.1.0
	 */
	function storedesign_post_meta() {
		?>
		<aside class="entry-meta">
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search.

			?>
			<span class="vcard author">
				<?php
					echo get_avatar( get_the_author_meta( 'ID' ), 80 );					
					echo sprintf( '<a href="%1$s" class="url fn" rel="author">%2$s</a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() );
				?>
			</span>
			<?php
			storedesign_posted_on();
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'storedesign' ) );

			if ( $categories_list ) : ?>
				<span class="cat-links">
				<i class="fa fa-folder-open"></i>
					<?php					
					echo wp_kses_post( $categories_list );
					?>
				</span>
			<?php endif; // End if categories. ?>

			<?php
			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', __( ', ', 'storedesign' ) );

			if ( $tags_list ) : ?>
				<span class="tags-links">
					<i class="fa fa-tags"></i>
					<?php					
					echo wp_kses_post( $tags_list );
					?>
				</span>
			<?php endif; // End if $tags_list. ?>

		<?php endif; // End if 'post' == get_post_type(). ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
				<span class="comments-link">
					<i class="fa fa-comments-o"></i>
					<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'storedesign' ), __( '1 Comment', 'storedesign' ), __( '% Comments', 'storedesign' ) ); ?></span>
				</span>
			<?php endif; ?>
		</aside>
		<?php
	}
}

if ( ! function_exists( 'storedesign_paging_nav' ) ) {
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function storedesign_paging_nav() {
		global $wp_query;

		$args = array(
			'type' 	    => 'list',
			'next_text' => _x( 'Next', 'Next post', 'storedesign' ),
			'prev_text' => _x( 'Previous', 'Previous post', 'storedesign' ),
			);

		the_posts_pagination( $args );
	}
}

if ( ! function_exists( 'storedesign_post_nav' ) ) {
	/**
	 * Display navigation to next/previous post when applicable.
	 */
	function storedesign_post_nav() {
		$args = array(
			'next_text' => '%title',
			'prev_text' => '%title',
			);
		the_post_navigation( $args );
	}
}

if ( ! function_exists( 'storedesign_posted_on' ) ) {
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function storedesign_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);		
		
		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		echo wp_kses( apply_filters( 'storedesign_single_post_posted_on_html', '<span class="posted-on"><i class="fa fa-clock-o"></i>' . $posted_on . '</span>', $posted_on ), array(
			'span' => array(
				'class'  => array(),
			),
			'i' => array(
				'class'  => array(),
			),
			'a'    => array(
				'href'  => array(),
				'title' => array(),
				'rel'   => array(),
			),
			'time' => array(
				'datetime' => array(),
				'class'    => array(),
			),
		) );
	}
}

if ( ! function_exists( 'storedesign_homepage_content' ) ) {
	/**
	 * Display homepage content
	 * Hooked into the `homepage` action in the homepage template
	 *
	 * @since   0.1
	 * @return  void
	 */
	function storedesign_homepage_content() {
		while ( have_posts() ) {
			the_post();

			get_template_part( 'content-part/content', 'homepage' );

		} // end of the loop.
	}
}


if ( ! function_exists( 'storedesign_get_sidebar' ) ) {
	/**
	 * Display storedesign sidebar
	 *
	 * @uses get_sidebar()
	 * @since   0.1.0
	 */
	function storedesign_get_sidebar() {
			if (class_exists( 'WooCommerce' )) {
				if ((is_shop() || is_product_category()) && !is_cart() && !is_checkout()) {
					get_sidebar('wc');
				} else if(!is_cart() && !is_checkout() && !is_account_page()) {
				get_sidebar();
				}
			} else {
				get_sidebar();
			}
	}
}

if ( ! function_exists( 'storedesign_post_thumbnail' ) ) {
	/**
	 * Display post thumbnail
	 *
	 * @var $size thumbnail size. thumbnail|medium|large|full|$custom
	 * @uses has_post_thumbnail()
	 * @uses the_post_thumbnail
	 * @param string $size the post thumbnail size.
	 * @since   0.1
	 */
	function storedesign_post_thumbnail( $size = 'large' ) {
		if ( has_post_thumbnail() ) { ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">	
			<?php the_post_thumbnail( $size ); ?>
		</a>
		<?php	
		}
	}
}

