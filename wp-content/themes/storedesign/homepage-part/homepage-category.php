<?php

$shopbycat_setting_h = get_theme_mod( 'storedesign_shopbycat_setting_h' );
		$shopbycat_setting_limit = get_theme_mod( 'storedesign_shopbycat_setting_limit' );
		$shopbycat_setting_col = get_theme_mod( 'storedesign_shopbycat_setting_col' );
		$shopbycat_setting_ids = get_theme_mod( 'storedesign_shopbycat_setting_cat' );
		$shopbycat_enable = get_theme_mod( 'storedesign_shopbycat_setting' );
	
		if ( storedesign_is_woocommerce_activated() && $shopbycat_enable ) {

			$args = apply_filters( 'storedesign_product_categories_args', array(
				'limit' 			=> $shopbycat_setting_limit,
				'columns' 			=> $shopbycat_setting_col,
				'child_categories' 	=> 0,
				'orderby' 			=> 'name',
				'ids'               => $shopbycat_setting_ids,
				'title'				=> $shopbycat_setting_h,
			) );

			$shortcode_content = storedesign_do_shortcode( 'product_categories', apply_filters( 'storedesign_product_categories_shortcode_args', array(
				'number'  => intval( $args['limit'] ),
				'columns' => intval( $args['columns'] ),
				'orderby' => esc_attr( $args['orderby'] ),
				'ids'     =>  intval( $args['ids'] ), 
				'parent'  => esc_attr( $args['child_categories'] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns product categories
			 */
			if ( false !== strpos( $shortcode_content, 'product-category' ) ) {

				echo '<section class="storedesign-product-section storedesign-product-categories" aria-label="' . esc_attr__( 'Product Categories', 'storedesign' ) . '">';

				echo '<h2 class="section-title">' . wp_kses_post( $args['title'] ) . '</h2>';

				echo $shortcode_content;

				echo '</section>';

			}
		}
?>