<?php
/*
 * Plugin Name: Sharing buttons shortcode for Jetpack
 * Plugin URI: http://wordpress.org/plugins/jetpack-sharing-butttons-shortcode/
 * Description: Extends the Jetpack plugin and allows you to add sharing buttons anywhere inside your posts thanks to the [jpshare] shortcode
 * Author: Jeremy Herve
 * Version: 1.2.1
 * Author URI: http://jeremy.hu
 * License: GPL2+
 * Text Domain: jetpack
 */

function tweakjp_sd_shortcode() {
	if ( function_exists( 'sharing_display' ) ) {
		return sharing_display();
	}
}

function tweakjp_sd_rm_shortcode( $content ) {
	return str_replace( '[jpshare]', '', $content );
}

function tweakjp_sd_enable() {
	if (
		class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'get_active_modules' ) && in_array( 'sharedaddy', Jetpack::get_active_modules() )
		) {
		add_shortcode( 'jpshare', 'tweakjp_sd_shortcode' );
	} else {
		add_filter( 'the_content', 'tweakjp_sd_rm_shortcode' );
	}
}
add_action( 'plugins_loaded', 'tweakjp_sd_enable' );
