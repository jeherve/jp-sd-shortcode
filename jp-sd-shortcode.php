<?php
/*
 * Plugin Name: Jetpack Sharing butttons shortcode
 * Plugin URI: http://wordpress.org/extend/plugins/jetpack/
 * Description: Extends the Jetpack plugin and allows you to add sharing buttons anywhere inside your posts thanks to the [jpshare] shortcode
 * Author: Jeremy Herve
 * Version: 1.1
 * Author URI: http://jeremyherve.com
 * License: GPL2+
 * Text Domain: jetpack
 */
 
if (
	class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'get_active_modules' ) && in_array( 'sharedaddy', Jetpack::get_active_modules() )
) :

function tweakjp_sd_shortcode() {
   return sharing_display();
}
add_shortcode( 'jpshare', 'tweakjp_sd_shortcode' );

else :

function tweakjp_sd_rm_shortcode( $content ) {
	return str_replace( '[jpshare]', '', $content );
}
add_filter( 'the_content', 'tweakjp_sd_rm_shortcode' );

endif;

?>