<?php
	/* Latest Prducts */
	$latestprd_setting_h = get_theme_mod( 'storedesign_latestprd_setting_h');
	$recommend_setting_h = get_theme_mod( 'storedesign_recommend_setting_h');
	$popularprd_setting_h = get_theme_mod( 'storedesign_popularprd_setting_h');
	$bestdallers_setting_h = get_theme_mod( 'storedesign_bestdallers_setting_h');

	$latestprd_enable = get_theme_mod( 'storedesign_latestprd_setting' );
	$recommend_enable = get_theme_mod( 'storedesign_recommend_setting' );
	$popularprd_enable = get_theme_mod( 'storedesign_popularprd_setting' );
	$bestdallers_enable = get_theme_mod( 'storedesign_bestdallers_setting' );

	if($latestprd_enable || $recommend_enable || $popularprd_enable || $bestdallers_enable) {
		if(storedesign_is_woocommerce_activated()){
?>
<section class="storedesign-product-section storedesign-product-slider">
<h2 class="section-title"><?php echo esc_html( 'Products', 'storedesign' ); ?></h2>
<div class="tab">
<?php if($latestprd_enable){ ?>
  <button class="tablinks active" onclick="openCity(event, 'Latest_Products')"><?php echo esc_html($latestprd_setting_h); ?></button>
<?php } if($recommend_enable) { ?>
  <button class="tablinks" onclick="openCity(event, 'Recommend_Products')"><?php echo esc_html($recommend_setting_h); ?></button>
<?php } if($popularprd_enable) { ?>
  <button class="tablinks" onclick="openCity(event, 'Popular_Products')"><?php echo esc_html($popularprd_setting_h); ?></button>
<?php } if($bestdallers_enable) { ?>
   <button class="tablinks" onclick="openCity(event, 'Best_Products')"><?php echo esc_html($bestdallers_setting_h); ?></button>
<?php } ?>
    
</div>
<?php if ( storedesign_is_woocommerce_activated() && $latestprd_enable ) { ?>
<div id="Latest_Products" class="tabcontent" style="display: block;">
<?php
/* Latest Prducts */
		$latestprd_setting_limit = get_theme_mod( 'storedesign_latestprd_setting_limit');
		$latestprd_setting_col = get_theme_mod( 'storedesign_latestprd_setting_col');		

			$args = apply_filters( 'storedesign_recent_products_args', array(
				'limit' 			=> $latestprd_setting_limit,
				'columns' 			=> $latestprd_setting_col,				
			) );

			$shortcode_content = storedesign_do_shortcode( 'recent_products', apply_filters( 'storedesign_recent_products_shortcode_args', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {

				echo '<section class="storedesign-recent-products" aria-label="'  . esc_attr__( 'Recent Products', 'storedesign' ) . '">';

				echo $shortcode_content;

				echo '</section>';

			}
?>
</div>
<?php }
	if ( storedesign_is_woocommerce_activated() && $recommend_enable ) {
?>
<div id="Recommend_Products" class="tabcontent">
<?php		
/* Recommend Prducts */
		$recommend_setting_limit = get_theme_mod( 'storedesign_recommend_setting_limit');
		$recommend_setting_col = get_theme_mod( 'storedesign_recommend_setting_col');					

			$args = apply_filters( 'storedesign_featured_products_args', array(
				'limit'   => $recommend_setting_limit,
				'columns' => $recommend_setting_col,
				'orderby' => 'date',
				'order'   => 'desc',				
			) );

			$shortcode_content = storedesign_do_shortcode( 'featured_products', apply_filters( 'storedesign_featured_products_shortcode_args', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
				'orderby'  => esc_attr( $args['orderby'] ),
				'order'    => esc_attr( $args['order'] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {

				echo '<section class="storedesign-featured-products" aria-label="' . esc_attr__( 'Featured Products', 'storedesign' ) . '">';

				echo $shortcode_content;

				echo '</section>';

			}
?>
</div>
<?php } 
	if ( storedesign_is_woocommerce_activated() && $popularprd_enable ) {
?>
<div id="Popular_Products" class="tabcontent">
<?php
/* popular Prducts */
		$popularprd_setting_limit = get_theme_mod( 'storedesign_popularprd_setting_limit');
		$popularprd_setting_col = get_theme_mod( 'storedesign_popularprd_setting_col');	


			$args = apply_filters( 'storedesign_popular_products_args', array(
				'limit'   => $popularprd_setting_limit,
				'columns' => $popularprd_setting_col,				
			) );

			$shortcode_content = storedesign_do_shortcode( 'top_rated_products', apply_filters( 'storedesign_popular_products_shortcode_args', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {

				echo '<section class="storedesign-popular-products" aria-label="' . esc_attr__( 'Popular Products', 'storedesign' ) . '">';

				echo $shortcode_content;

				echo '</section>';

			}	
?>
</div>
<?php }
	if ( storedesign_is_woocommerce_activated() && $bestdallers_enable ) {
?>
<div id="Best_Products" class="tabcontent">		
<?php		
/* Best Saleing Prducts */
		$bestdallers_setting_limit = get_theme_mod( 'storedesign_bestdallers_setting_limit');
		$bestdallers_setting_col = get_theme_mod( 'storedesign_bestdallers_setting_col');		

			$args = apply_filters( 'storedesign_best_selling_products_args', array(
				'limit'   => $bestdallers_setting_limit,
				'columns' => $bestdallers_setting_col,								
			) );

			$shortcode_content = storedesign_do_shortcode( 'best_selling_products', apply_filters( 'storedesign_best_selling_products_shortcode_args', array(
				'per_page' => intval( $args['limit'] ),
				'columns'  => intval( $args['columns'] ),
			) ) );

			/**
			 * Only display the section if the shortcode returns products
			 */
			if ( false !== strpos( $shortcode_content, 'product' ) ) {

				echo '<section class="storedesign-best-selling-products" aria-label="' . esc_attr__( 'Best Selling Products', 'storedesign' ) . '">';

				echo $shortcode_content;

				echo '</section>';

			}	
?>
</div>	
<?php } ?>
</section>	
<?php } } 