<?php
/**
 * Theme Welcome page function
 *
 * @package StoreDesign
 * @since   0.1
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Action to add menu
add_action('admin_menu', 'storedesign_register_design_page');

/**
 * Register Theme Welcome page in admin menu
 * 
 * @package StoreDesign
 * @since   0.1
 */

  $theme = wp_get_theme();
  $theme_name  = $theme->name;
  $theme_slug  = $theme->template;
  $theme_version  = $theme->version;
  $theme_description  = $theme->description;
 
  
 add_action( 'admin_enqueue_scripts', 'storedesign_enqueue_scripts'); 
 
 function storedesign_enqueue_scripts( $hook ) {
        global $theme_name,$theme_slug;
        if ( "appearance_page_{$theme_slug}" !== $hook ) {
                return;
        }
        wp_enqueue_style( "{$theme_slug}-dashboard-style", STOREDESIGN_URL . '/inc/dashboard/css/dashboard-style.css' );
}
 

  

function storedesign_register_design_page() {
    
    global $theme_name,$theme_slug;
    
    add_theme_page(
			 $theme_name,
			 __('StoreDesign', 'storedesign'),
			 'edit_theme_options',
			 'storedesign',
			 'storedesign_designs_page' 
    );
}

/**
 * Function to display Welcome page
 * 
 * @package StoreDesign
 * @since   0.1
 */
function storedesign_designs_page() {
    
        global $theme_name,$theme_slug,$theme_version,$theme_description;
	$wpos_feed_tabs = storedesign_help_tabs();
	$active_tab 	= isset($_GET['tab']) ? $_GET['tab'] : 'getting-started';
?>
		
	<div class="wrap storedesign-postformate-wrap-custom about-wrap">
        <?php include get_template_directory() . '/inc/dashboard/sections/welcome.php'; ?>
		<h2 class="nav-tab-wrapper">
                    <?php
                    foreach ($wpos_feed_tabs as $tab_key => $tab_val) {
                            $tab_name	= $tab_val['name'];
                            $active_cls = ($tab_key == $active_tab) ? 'nav-tab-active' : '';
                            $tab_link 	= add_query_arg( array( 'page' => 'storedesign', 'tab' => $tab_key), admin_url('themes.php') );
                    ?>

                    <a class="nav-tab <?php echo esc_attr($active_cls); ?>" href="<?php echo esc_url($tab_link); ?>"><?php echo esc_html($tab_name); ?></a>

			<?php } ?>
		</h2>
		
		<div class="storedesign-postformate-tab-cnt-wrp">
		<?php
			if( isset($active_tab) && $active_tab == 'getting-started' ) {
				storedesign_getting_started_page();
			}
			else if( isset($active_tab) && $active_tab == 'support' ) {
				storedesign_support_page();
			} 
		?>
		</div><!-- end .storedesign-postformate-tab-cnt-wrp -->

	</div><!-- end .storedesign-postformate-wrap -->

<?php } 

/**
 * Function to get plugin feed tabs
 *
 * @package StoreDesign
 * @since   0.1
 */
function storedesign_help_tabs() {
	$wpos_feed_tabs = array(
                                'getting-started' 	=> array(
                                                            'name'              => __('Getting Started', 'storedesign'),
                                                        ),
                                'support' 	=> array(
                                                            'name'              => __('Support', 'storedesign'),
                                                        )                                
                                );
	return $wpos_feed_tabs;
}

/**
 * Function to Display getting started tab
 *
 * @package StoreDesign
 * @since   0.1
 */
function storedesign_getting_started_page() { ?>
	<div class="post-box-container">
		<div id="poststuff">
			<?php include get_template_directory() . '/inc/dashboard/sections/getting-started.php'; ?>				
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
<?php }

/**
 * Function to Display support tab
 *
 * @package StoreDesign
 * @since   0.1
 */
function storedesign_support_page() { ?>
	<div class="post-box-container">
		<div id="poststuff">
			<?php include get_template_directory() . '/inc/dashboard/sections/support.php'; ?>				
		</div><!-- #poststuff -->
	</div><!-- #post-box-container -->
<?php }