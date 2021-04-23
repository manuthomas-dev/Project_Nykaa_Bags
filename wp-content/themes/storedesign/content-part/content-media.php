<?php
/**
 * Display an optional post thumbnail, video in according to post formats
 *
 * @package Oviyan
 * @since   0.1 
 */

if ( has_post_thumbnail() ) { ?>           
         <div class='entry-media'>
		 <?php storedesign_post_thumbnail();
				storedesign_post_meta(); ?>
		</div>
<?php }  ?>