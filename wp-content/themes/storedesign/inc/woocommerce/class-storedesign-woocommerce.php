<?php
/**
 * Storedesign WooCommerce Class
 *
 * @package  storedesign
 * @author   WP Online Support
 * @since   0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Storedesign_WooCommerce' ) ) :

	/**
	 * The Storedesign WooCommerce Integration class
	 */
	class Storedesign_WooCommerce {

		/**
		 * Setup class.
		 *
		 * @since   0.1
		 */
		public function __construct() {
			add_filter( 'body_class',                               array( $this, 'woocommerce_body_class' ) );
			add_action( 'wp_enqueue_scripts',                       array( $this, 'woocommerce_scripts' ),	20 );
			add_filter( 'woocommerce_enqueue_styles',               '__return_empty_array' );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_product_thumbnails_columns',   array( $this, 'thumbnail_columns' ) );
			add_filter( 'woocommerce_breadcrumb_defaults',          array( $this,'change_breadcrumb_delimiter' ) );

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.5', '<' ) ) {
				add_action( 'wp_footer',                            array( $this, 'star_rating_script' ) );
			}

			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
				add_filter( 'loop_shop_per_page',                   array( $this, 'products_per_page' ) );
			}			
		}


		/**
		 * Add 'woocommerce-active' class to the body tag
		 *
		 * @param  array $classes css classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class
		 */
		public function woocommerce_body_class( $classes ) {
			if ( storedesign_is_woocommerce_activated() ) {
				$classes[] = 'woocommerce-active';
			}

			return $classes;
		}

		/**
		 * WooCommerce specific scripts & stylesheets
		 *
		 * @since   0.1.0
		 */
		public function woocommerce_scripts() {	

			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'storedesign-woocommerce-style', STOREDESIGN_URL . '/assets/css/woocommerce/woocommerce.css', array(), STOREDESIGN_VERSION );
			wp_style_add_data( 'storedesign-woocommerce-style', 'rtl', 'replace' );
		}

		/**
		 * Star rating backwards compatibility script (WooCommerce <2.5).
		 *
		 * @since 1.6.0
		 */
		public function star_rating_script() {
			if ( is_product() ) {
		?>
			<script type="text/javascript">
				var starsEl = document.querySelector( '#respond p.stars' );
				if ( starsEl ) {
					starsEl.addEventListener( 'click', function( event ) {
						if ( event.target.tagName === 'A' ) {
							starsEl.classList.add( 'selected' );
						}
					} );
				}
			</script>
		<?php
			}
		}

		/**
		 * Related Products Args
		 *
		 * @param  array $args related products args.
		 * @since   0.1.0
		 * @return  array $args related products args
		 */
		public function related_products_args( $args ) {
			$args = apply_filters( 'storedesign_related_products_args', array(
				'posts_per_page' => 3,
				'columns'        => 3,
			) );

			return $args;
		}

		/**
		 * Product gallery thumbnail columns
		 *
		 * @return integer number of columns
		 * @since   0.1
		 */
		public function thumbnail_columns() {
			$columns = 4;

			if ( ! is_active_sidebar( 'sidebar-1' ) ) {
				$columns = 5;
			}

			return intval( apply_filters( 'storedesign_product_thumbnail_columns', $columns ) );
		}

		/**
		 * Products per page
		 *
		 * @return integer number of products
		 * @since   0.1
		 */
		public function products_per_page() {
			return intval( apply_filters( 'storedesign_products_per_page', 12 ) );
		}
		

		/**
		 * Remove the breadcrumb delimiter
		 * @param  array $defaults The breadcrumb defaults
		 * @return array           The breadcrumb defaults
		 * @since   0.1
		 */
		public function change_breadcrumb_delimiter( $defaults ) {
			$defaults['delimiter'] = '<span class="breadcrumb-separator"> / </span>';
			return $defaults;
		}	

	}

endif;

return new Storedesign_WooCommerce();
