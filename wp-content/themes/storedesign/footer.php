<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storedesign
 */

?>
	
		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storedesign_before_footer' ); ?>
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if (is_active_sidebar( 'storedesign-intsgram-feed' ) ) { ?>
			<div class="storedesign-intsgram-area">
				<?php dynamic_sidebar( 'storedesign-intsgram-feed' ); ?>
			</div>
		<?php } 
			$footer_social = get_theme_mod( 'footer_social' );
			if(!empty($footer_social)){
		?>
		<div class="footer-social-icon">
			<div class="col-full">
				<div class="storedesign-social-networks storedesign-social-networks-footer">
					<?php storedesign_get_footer_social_icon(); ?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="footer-widget-sections">
			<div class="col-full">
				<?php			
					// Display the Footer Section
					storedesign_footer_widgets();
				?>
			</div>
		</div>
		<div class="footer-info">
			<div class="col-full">
			<?php if( has_nav_menu( 'footer' ) ){ ?>
				<div class="footer-menu-main">
					<?php  						
							wp_nav_menu( array(
								'theme_location' => 'footer',
								'menu_id' => 'footer-menu',
								'depth'  => 1,
							) ); 
					?>
				</div>	
				<?php } ?>
				<div class="site-info">
				<?php echo  storedesign_footer_copyright(); ?>
				</div><!-- .site-info -->

			</div><!-- .col-full -->
		</div><!-- Footer info -->
	</footer><!-- #colophon -->

	<?php do_action( 'storedesign_after_footer' ); ?>

</div><!-- #page -->
<nav class="mobile-navigation mobile-menu" role="navigation">
	
	<div class="mobile_close_icons"><i class="fa fa-close"></i></div>
	<?php
	if ( storedesign_is_woocommerce_activated() ) { ?>
					<div class="mobile-site-search">
						<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
					</div>
				<?php
				} ?>
   <?php

	if( has_nav_menu( 'primary' ) ){
		wp_nav_menu( array(
			'container_class' => 'mobile-menu-container',
			'menu_class'      => 'mobile-menu clearfix',
			'theme_location'  => 'primary',
			'items_wrap'      => '<ul>%3$s</ul>',
		) );
	}
		$header_social = get_theme_mod( 'header_social' );
	?>
	<div class="mobile-menu-social-icon"><?php if( !empty($header_social) ) { storedesign_get_social_icon(); } ?></div>


</nav>
<?php wp_footer(); ?>

</body>
</html>
