<?php
/**
 * Storedesign Class
 *
 * @author   WP Online Support
 * @since   0.1
 * @package  storedesign
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Storedesign' ) ) :

	/**
	 * The main Storedesign class
	 */
	class Storedesign {

		/**
		 * Setup class.
		 *
		 * @since   0.1
		 */
		public function __construct() {
			add_action( 'after_setup_theme',          array( $this, 'storedesign_setup' ) );
			add_action( 'widgets_init',               array( $this, 'storedesign_widgets_init' ) );			
			add_filter( 'body_class',                 array( $this, 'storedesign_body_classes' ) );
			add_filter( 'wp_page_menu_args',          array( $this, 'storedesign_page_menu_args' ) );
			add_filter( 'navigation_markup_template', array( $this, 'storedesign_navigation_markup_template' ) );
			add_action( 'enqueue_embed_scripts',      array( $this, 'storedesign_print_embed_styles' ) );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 */
		public function storedesign_setup() {
			
			// Loads wp-content/languages/themes/storedesign-it_IT.mo.
			load_theme_textdomain( 'storedesign', trailingslashit( WP_LANG_DIR ) . 'themes/' );

			// Loads wp-content/themes/child-theme-name/languages/it_IT.mo.
			load_theme_textdomain( 'storedesign', get_stylesheet_directory() . '/languages' );

			// Loads wp-content/themes/storedesign/languages/it_IT.mo.
			load_theme_textdomain( 'storedesign', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );
			
			// This theme supports a variety of post formats.
			add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );
			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#Post_Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );				
			add_image_size( 'storedesign-soft-featured', 700, 400, true );
			
			// This theme styles the visual editor with editor-style.css to match the theme style.
			add_editor_style();

			/**
			 * Enable support for site logo
			 */
			add_theme_support( 'custom-logo', apply_filters( 'storedesign_custom_logo_args', array(
				'height'      => 110,
				'width'       => 470,
				'flex-width'  => true,
			) ) );

			// This theme uses wp_nav_menu() in two locations.
			register_nav_menus( apply_filters( 'storedesign_register_nav_menus', array(
				'primary'   => __( 'Primary Menu', 'storedesign' ),
				'top'  		=> __( 'Top Menu', 'storedesign' ),
				'footer' 	=> __( 'Footer Menu', 'storedesign' ),				
			) ) );

			/*
			 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5', apply_filters( 'storedesign_html5_args', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'widgets',
			) ) );

			// Setup the WordPress core custom background feature.
			add_theme_support( 'custom-background', apply_filters( 'storedesign_custom_background_args', array(
				'default-color' => apply_filters( 'storedesign_default_background_color', 'ffffff' ),
				'default-image' => '',
			) ) );

			/**
			 *  Add support for the Site Logo plugin and the site logo functionality in JetPack
			 *  https://github.com/automattic/site-logo
			 *  http://jetpack.me/
			 */
			add_theme_support( 'site-logo', apply_filters( 'storedesign_site_logo_args', array(
				'size' => 'full'
			) ) );

			// Declare WooCommerce support.
			add_theme_support( 'woocommerce', apply_filters( 'storedesign_woocommerce_args', array(
				'single_image_width'    => 416,
				'thumbnail_image_width' => 324,
				'product_grid'          => array(
					'default_columns' => 3,
					'default_rows'    => 4,
					'min_columns'     => 1,
					'max_columns'     => 6,
					'min_rows'        => 1
				)
			) ) );

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );

			// Declare support for title theme feature.
			add_theme_support( 'title-tag' );

			// Declare support for selective refreshing of widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );
		}

		/**
		 * Register widget area.
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
		 */
		public function storedesign_widgets_init() {
			$sidebar_args['sidebar'] = array(
				'name'          => __( 'Sidebar', 'storedesign' ),
				'id'            => 'sidebar-1',
				'description'   => ''
			);
			
			$sidebar_args['shoppage'] = array(
				'name'        => __( 'Shop Page Sidebar', 'storedesign' ),
				'id'          => 'shoppage',
				'description' => __( 'Widgets added to this region will appear shop page.', 'storedesign' ),
			);
			$sidebar_args['storedesign-intsgram-feed'] = array(
				'name'        => __( 'Footer Instgarm Widget Area', 'storedesign' ),
				'id'          => 'storedesign-intsgram-feed',
				'description' => __( 'Widgets added to this region will appear footer section.', 'storedesign' ),
			);		
			

			$rows    = intval( apply_filters( 'storedesign_footer_widget_rows', 1 ) );
			$regions = intval( apply_filters( 'storedesign_footer_widget_columns', 4 ) );

			for ( $row = 1; $row <= $rows; $row++ ) {
				for ( $region = 1; $region <= $regions; $region++ ) {
					$footer_n = $region + $regions * ( $row - 1 ); // Defines footer sidebar ID.
					$footer   = sprintf( 'footer_%d', $footer_n );

					if ( 1 == $rows ) {
						$footer_region_name = sprintf( __( 'Footer Column %1$d', 'storedesign' ), $region );
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of the footer.', 'storedesign' ), $region );
					} else {
						$footer_region_name = sprintf( __( 'Footer Row %1$d - Column %2$d', 'storedesign' ), $row, $region );
						$footer_region_description = sprintf( __( 'Widgets added here will appear in column %1$d of footer row %2$d.', 'storedesign' ), $region, $row );
					}

					$sidebar_args[ $footer ] = array(
						'name'        => $footer_region_name,
						'id'          => sprintf( 'footer-%d', $footer_n ),
						'description' => $footer_region_description,
					);
				}
			}

			$sidebar_args = apply_filters( 'storedesign_sidebar_args', $sidebar_args );

			foreach ( $sidebar_args as $sidebar => $args ) {
				$widget_tags = array(
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="gamma widget-title">',
					'after_title'   => '</h3>',
				);

				$filter_hook = sprintf( 'storedesign_%s_widget_tags', $sidebar );
				$widget_tags = apply_filters( $filter_hook, $widget_tags );

				if ( is_array( $widget_tags ) ) {
					register_sidebar( $args + $widget_tags );
				}
			}
		}
		

		/**
		 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
		 *
		 * @param array $args Configuration arguments.
		 * @return array
		 */
		public function storedesign_page_menu_args( $args ) {
			$args['show_home'] = true;
			return $args;
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 * @return array
		 */
		public function storedesign_body_classes( $classes ) {
			// Adds a class of group-blog to blogs with more than 1 published author.
			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			if ( ! function_exists( 'woocommerce_breadcrumb' ) ) {
				$classes[]	= 'no-wc-breadcrumb';
			}
			
			$cute = apply_filters( 'storedesign_make_me_cute', false );

			if ( true === $cute ) {
				$classes[] = 'storedesign-cute';
			}

			// If our main sidebar doesn't contain widgets, adjust the layout to be full-width.
			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$classes[] = 'storedesign-full-width-content';
			}

			// Add class when using homepage template + featured image
			if ( is_page_template( 'template-parts/template-homepage.php' ) && has_post_thumbnail() ) {
				$classes[] = 'has-post-thumbnail';
			}

			return $classes;
		}

		/**
		 * Custom navigation markup template hooked into `navigation_markup_template` filter hook.
		 */
		public function storedesign_navigation_markup_template() {
			$template  = '<nav id="post-navigation" class="navigation %1$s" role="navigation" aria-label="' . esc_html__( 'Post Navigation', 'storedesign' ) . '">';
			$template .= '<span class="screen-reader-text">%2$s</span>';
			$template .= '<div class="nav-links">%3$s</div>';
			$template .= '</nav>';

			return apply_filters( 'storedesign_navigation_markup_template', $template );
		}

		/**
		 * Add styles for embeds
		 */
		public function storedesign_print_embed_styles() {			
			$accent_color     = get_theme_mod( 'storedesign_accent_color' );
			$background_color = storedesign_get_content_background_color();
			?>
			<style type="text/css">
				.wp-embed {
					padding: 2.618em !important;
					border: 0 !important;
					border-radius: 3px !important;
					font-family: "Roboto", "Open Sans", sans-serif !important;
					background-color: <?php echo esc_html( storedesign_adjust_color_brightness( $background_color, -7 ) ); ?> !important;
				}

				.wp-embed .wp-embed-featured-image {
					margin-bottom: 2.618em;
				}

				.wp-embed .wp-embed-featured-image img,
				.wp-embed .wp-embed-featured-image.square {
					min-width: 100%;
					margin-bottom: .618em;
				}

				a.wc-embed-button {
					padding: .857em 1.387em !important;
					font-weight: 500;
					background-color: <?php echo esc_attr( $accent_color ); ?>;
					color: #fff !important;
					border: 0 !important;
					line-height: 1;
					border-radius: 0 !important;
					box-shadow:
						inset 0 -1px 0 rgba(#000,.3);
				}

				a.wc-embed-button + a.wc-embed-button {
					background-color: #60646c;
				}
			</style>
			<?php
		}
	}
endif;

return new Storedesign();
