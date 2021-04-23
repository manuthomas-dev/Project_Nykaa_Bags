<?php
/**
 * The sidebar containing WC the main widget area.
 *
 * @package storedesign
 */

if ( ! is_active_sidebar( 'shoppage' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'shoppage' ); ?>
</div><!-- #secondary -->
