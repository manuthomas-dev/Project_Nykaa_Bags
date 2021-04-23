<?php 
	$sale_setting_h = get_theme_mod( 'storedesign_sale_setting_h');
	$sale_setting_limit = get_theme_mod( 'storedesign_sale_setting_limit');
	$sale_enable = get_theme_mod( 'storedesign_sale_setting' );
	if(storedesign_is_woocommerce_activated() && $sale_enable){ ?>
<section class="storedesign-product-section storedesign-on-sale-products on-sale-slide-wrap clear">
<?php					
				global $woocommerce;
				$args = array(
					'post_type'      => 'product',
					'posts_per_page' => $sale_setting_limit,
					'meta_query'     => array(
							'relation' => 'OR',
							array( // Simple products type
								'key'           => '_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							),
							array( // Variable products type
								'key'           => '_min_variation_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							)
						)
				); 
				
					echo '<h2 class="section-title">' . esc_html( $sale_setting_h ) . '</h2>';
					
					 $loop = new WP_Query( $args );
						if ( $loop->have_posts() ) { ?>
							<div class="product-for theme-col-9 theme-columns">
							<?php 
							while ( $loop->have_posts() ) : $loop->the_post(); 
								$currency = get_woocommerce_currency_symbol();
								$price = get_post_meta( get_the_ID(), '_regular_price', true);
								$sale = get_post_meta( get_the_ID(), '_sale_price', true);
							?>	
								<div class="on-sale-slide">
									<div class="woocommerce-product-gallery theme-col-6 theme-columns">
										<a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail('medium_large'); ?></a>
									</div>
									<div class="summary entry-summary theme-col-6 theme-columns">
										<h2 class="woocommerce-loop-product__title"><?php the_title(); ?></h2>
										<p class="price">
											<?php if($sale) { ?>
											<del>
												<span class="woocommerce-Price-amount amount">
													<span class="woocommerce-Price-currencySymbol"><?php echo esc_html($currency); ?></span> <?php echo esc_html($price); ?>
												</span>
											</del> 													
											<ins>
												<span class="woocommerce-Price-amount amount">
													<span class="woocommerce-Price-currencySymbol"><?php echo esc_html($currency); ?></span> <?php  echo esc_html($sale); ?>   
												</span>
											</ins> 							
											<?php } ?>
										</p>
										<div class="woocommerce-product-details__short-description">
											<?php storedesign_short_description(); ?>
										</div>	
										<div class="cart cart-botton-home">
											<a href="<?php the_permalink(); ?>" class="button"><?php esc_html_e( 'Buy Now', 'storedesign' ); ?></a>
										</div>
									</div>	
								</div>	
							<?php endwhile; ?>
							</div>	
							<div class="product-nav theme-col-3 theme-columns">
							<?php 
							while ( $loop->have_posts() ) : $loop->the_post();								
							?>	
								<div class="on-sale-slide-thumb">
									<div class="on-sale-slide-thumb-gallery">
										<?php the_post_thumbnail('thumbnail'); ?>
									</div>									
								</div>	
							<?php endwhile; ?>
							</div>	
						<?php } 
						wp_reset_postdata();							
?>
</section>
<?php }