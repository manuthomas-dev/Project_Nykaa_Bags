<?php
/**
 * WooCommerce Template Functions.
 *
 * @package storedesign
 */

if ( ! function_exists( 'storedesign_before_content' ) ) {
	/**
	 * Before Content
	 * Wraps all WooCommerce content in wrappers which match the theme markup
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function storedesign_before_content() {
		?>
		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">
		<?php
	}
}

if ( ! function_exists( 'storedesign_after_content' ) ) {
	/**
	 * After Content
	 * Closes the wrapping divs
	 *
	 * @since   1.0.0
	 * @return  void
	 */
	function storedesign_after_content() {
		?>
			</main><!-- #main -->
		</div><!-- #primary -->

		<?php if(!is_product()) { storedesign_get_sidebar(); }
	}
}

if ( ! function_exists( 'storedesign_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments
	 * Ensure cart contents update when products are added to the cart via AJAX
	 *
	 * @param  array $fragments Fragments to refresh via AJAX.
	 * @return array            Fragments to refresh via AJAX
	 */
	function storedesign_cart_link_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		storedesign_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();
		return $fragments;
	}
}

if ( ! function_exists( 'storedesign_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 *
	 * @return void
	 * @since   0.1
	 */
	function storedesign_cart_link() {		
		?>
			<a class="cart-contents" href="javascript:void(0)" title="<?php esc_attr_e( 'View your shopping cart', 'storedesign' ); ?>">
				<i class="fa fa-shopping-cart"></i><span class="count"><?php echo wp_kses_data(WC()->cart->get_cart_contents_count());?></span>
			</a>
			
		<?php
		
	}
}



if ( ! function_exists( 'storedesign_upsell_display' ) ) {
	/**
	 * Upsells
	 * Replace the default upsell function with our own which displays the correct number product columns
	 *
	 * @since   1.0.0
	 * @return  void
	 * @uses    woocommerce_upsell_display()
	 */
	function storedesign_upsell_display() {
		$columns = apply_filters( 'storedesign_upsells_columns', 3 );
		woocommerce_upsell_display( -1, $columns );
	}
}

if ( ! function_exists( 'storedesign_sorting_wrapper' ) ) {
	/**
	 * Sorting wrapper
	 *
	 * @since   1.4.3
	 * @return  void
	 */
	function storedesign_sorting_wrapper() {
		echo '<div class="storedesign-sorting">';
	}
}

if ( ! function_exists( 'storedesign_sorting_wrapper_close' ) ) {
	/**
	 * Sorting wrapper close
	 *
	 * @since   1.4.3
	 * @return  void
	 */
	function storedesign_sorting_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'storedesign_product_columns_wrapper' ) ) {
	/**
	 * Product columns wrapper
	 *
	 * @since   2.2.0
	 * @return  void
	 */
	function storedesign_product_columns_wrapper() {
		$columns = storedesign_loop_columns();
		echo '<div class="columns-' . absint( $columns ) . '">';
	}
}

if ( ! function_exists( 'storedesign_loop_columns' ) ) {
	/**
	 * Default loop columns on product archives
	 *
	 * @return integer products per row
	 * @since   0.1
	 */
	function storedesign_loop_columns() {
		$columns = 3; // 3 products per row

		if ( function_exists( 'wc_get_default_products_per_row' ) ) {
			$columns = wc_get_default_products_per_row();
		}

		return apply_filters( 'storedesign_loop_columns', $columns );
	}
}

if ( ! function_exists( 'storedesign_product_columns_wrapper_close' ) ) {
	/**
	 * Product columns wrapper close
	 *
	 * @since   2.2.0
	 * @return  void
	 */
	function storedesign_product_columns_wrapper_close() {
		echo '</div>';
	}
}

if ( ! function_exists( 'storedesign_shop_messages' ) ) {
	/**
	 * Storedesign shop messages
	 *
	 * @since   1.4.4
	 * @uses    storedesign_do_shortcode
	 */
	function storedesign_shop_messages() {
		if ( ! is_checkout() ) {
			echo wp_kses_post( storedesign_do_shortcode( 'woocommerce_messages' ) );
		}
	}
}

if ( ! function_exists( 'storedesign_woocommerce_pagination' ) ) {
	/**
	 * Storedesign WooCommerce Pagination
	 * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
	 * but since Storedesign adds pagination before that function is excuted we need a separate function to
	 * determine whether or not to display the pagination.
	 *
	 * @since 1.4.4
	 */
	function storedesign_woocommerce_pagination() {
		if ( woocommerce_products_will_display() ) {
			woocommerce_pagination();
		}
	}
}

if ( ! function_exists( 'storedesign_promoted_products' ) ) {
	
	function storedesign_promoted_products( $per_page = '4', $columns = '4', $recent_fallback = true ) {
		if ( storedesign_is_woocommerce_activated() ) {

			if ( wc_get_featured_product_ids() ) {

				echo '<h2 class="section-title">' . esc_html__( 'Featured Products', 'storedesign' ) . '</h2>';

				echo storedesign_do_shortcode( 'featured_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( wc_get_product_ids_on_sale() ) {

				echo '<h2 class="section-title">' . esc_html__( 'On Sale Now', 'storedesign' ) . '</h2>';

				echo storedesign_do_shortcode( 'sale_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			} elseif ( $recent_fallback ) {

				echo '<h2 class="section-title">' . esc_html__( 'New In Store', 'storedesign' ) . '</h2>';

				echo storedesign_do_shortcode( 'recent_products', array(
											'per_page' => $per_page,
											'columns'  => $columns,
				) );
			}
		}
	}
}
if ( ! function_exists( 'storedesign_short_description' ) ) {
	/**
	 * Short description of product 
	 */
	function storedesign_short_description() {
		if ( storedesign_is_woocommerce_activated() ) {
			global $product;
			if ( ! $product->get_short_description() ) return;
			 echo apply_filters( 'woocommerce_short_description', $product->get_short_description() ) ;
		}
	}
}
