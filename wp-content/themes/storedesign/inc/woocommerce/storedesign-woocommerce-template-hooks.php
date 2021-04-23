<?php
/**
 * Layout
 *
 * @see  storedesign_before_content()
 * @see  storedesign_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  storedesign_shop_messages()
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb',                   20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );
remove_action( 'woocommerce_after_shop_loop',     'woocommerce_pagination',                   10 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_result_count',                 20 );
remove_action( 'woocommerce_before_shop_loop',    'woocommerce_catalog_ordering',             30 );

add_action( 'woocommerce_before_main_content',    'storedesign_before_content',                10 );
add_action( 'woocommerce_after_main_content',     'storedesign_after_content',                 10 );
add_action( 'storedesign_content_top',             'storedesign_shop_messages',                 15 );
add_action( 'storedesign_content_top',             'woocommerce_breadcrumb',                   10 );

add_action( 'woocommerce_after_shop_loop',        'storedesign_sorting_wrapper',               9 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_catalog_ordering',             10 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_result_count',                 20 );
add_action( 'woocommerce_after_shop_loop',        'woocommerce_pagination',                   30 );
add_action( 'woocommerce_after_shop_loop',        'storedesign_sorting_wrapper_close',         31 );
add_action( 'woocommerce_after_shop_loop',        'storedesign_product_columns_wrapper_close', 40 );

add_action( 'woocommerce_before_shop_loop',       'storedesign_sorting_wrapper',               9 );
add_action( 'woocommerce_before_shop_loop',       'woocommerce_catalog_ordering',             10 );
add_action( 'woocommerce_before_shop_loop',       'woocommerce_result_count',                 20 );
add_action( 'woocommerce_before_shop_loop',       'storedesign_woocommerce_pagination',        30 );
add_action( 'woocommerce_before_shop_loop',       'storedesign_sorting_wrapper_close',         31 );
add_action( 'woocommerce_before_shop_loop',       'storedesign_product_columns_wrapper',       40 );



// Legacy WooCommerce columns filter.
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
	add_filter( 'loop_shop_columns', 'storedesign_loop_columns' );
}

/**
 * Products
 *
 * @see  storedesign_upsell_display()
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display',               15 );
add_action( 'woocommerce_after_single_product_summary',    'storedesign_upsell_display',                15 );
remove_action( 'woocommerce_before_shop_loop_item_title',  'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_after_shop_loop_item_title',      'woocommerce_show_product_loop_sale_flash', 6 );

/**
 * Cart fragment
 *
 * @see storedesign_cart_link_fragment()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'storedesign_cart_link_fragment' );
} else {
	add_filter( 'add_to_cart_fragments', 'storedesign_cart_link_fragment' );
}
