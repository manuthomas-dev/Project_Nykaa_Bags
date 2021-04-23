<?php
/**
 * Display Welcome page Getting started section.
 *
 * @package storedesign
 * @since   0.1
 * 
 */

?>
<div id="getting-started" class="gt-tab-pane gt-is-active">
    <div class="feature-section two-col">
        <div class="col">
                <h3><?php esc_html_e( 'Customize The Theme', 'storedesign' ); ?></h3>
                <p><?php esc_html_e( 'Using the WordPress Customizer you can easily customize every aspect of the theme.', 'storedesign' ); ?></p>
                <p>
                        <a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Start Customize', 'storedesign' ); ?></a>
                </p>

					
        </div>

        <div class="col">
                <img src="<?php echo esc_url( STOREDESIGN_URL ); ?>/screenshot.png" alt="<?php esc_attr_e( 'screenshot', 'storedesign' ); ?>">
        </div>
    </div>
</div>