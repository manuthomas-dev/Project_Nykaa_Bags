<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storedesign
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php 
	$header_social = get_theme_mod( 'header_social' );
?>
<?php if ( storedesign_is_woocommerce_activated() ) {	?>
	<div id="Sidenav-cart" class="sidenav-cart">
	  <a href="javascript:void(0)" class="closebtn"><i class="fa fa-close"></i></a> 		
			<?php	the_widget( 'WC_Widget_Cart', '' ); ?>
	</div>
<?php } ?>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner" style="<?php storedesign_header_styles(); ?>">		
		<?php if(!empty($header_social) ||  has_nav_menu( 'top' ))  { ?>
		<div class="header-top">
			<div class="col-full">
				<?php if(!empty($header_social) ) { ?>
				<div class="header-social-icon">
					<?php storedesign_get_social_icon(); ?>
				</div>
				<?php } ?>
				<div class="top-header-menu hide-for-small-only">
					<nav id="site-navigation-top" class="main-navigation" role="navigation">
					<?php  
						if( has_nav_menu( 'top' ) ){
							wp_nav_menu( array(
								'theme_location' => 'top',
								'menu_id' => 'top-menu',
							) ); 
					} ?>
					</nav>      
				</div>  
			</div>
		</div>
		<?php } ?>
		<div class="main-header">
			<div class="col-full">
				<a class="skip-link screen-reader-text" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'storedesign' ); ?></a>
				<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'storedesign' ); ?></a>
				<div class="header-cart-icon" id="mobile-header-cart">
					<i class="fa fa-shopping-cart"></i>
				</div>
				<div class="site-branding">
					 <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) { ?>
	                                <?php the_custom_logo(); ?>
	                    <?php } else { ?>
	                                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	                                <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
	                    <?php } ?>
				</div>
				<?php 
				if ( storedesign_is_woocommerce_activated() ) { ?>
					<div class="site-search">
						<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
					</div>
				<?php
				}
				?>
				<div class="storedesign-primary-navigation">
					<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'storedesign' ); ?>">
						<button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span></span></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location'	=> 'primary',
								'container_class'	=> 'primary-navigation',
								)
						);					
						?>
					</nav><!-- #site-navigation -->
					<?php if ( storedesign_is_woocommerce_activated() ) {
							if ( is_cart() ) {
								$class = 'current-menu-item';
							} else {
								$class = '';
							}
						?>						
						<ul id="site-header-cart" class="site-header-cart menu">
							<li>
								<?php storedesign_cart_link(); ?>
							</li>
						</ul>
						<?php
						}
						?>
				</div>
			</div>
		</div>
	</header><!-- #masthead -->

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

		<?php
		/**
		 * Functions hooked in to storedesign_content_top
		 *
		 * @hooked woocommerce_breadcrumb - 10
		 */
		do_action( 'storedesign_content_top' );
