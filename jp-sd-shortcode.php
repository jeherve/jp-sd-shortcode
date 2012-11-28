<?php
/*
 * Plugin Name: Jetpack Sharing butttons shortcode
 * Plugin URI: http://wordpress.org/extend/plugins/jetpack/
 * Description: Extends the Jetpack plugin and allows you to add sharing buttons anywhere inside your posts thanks to the [jpshare] shortcode
 * Author: Jeremy Herve
 * Version: 1.0
 * Author URI: http://jeremyherve.com
 * License: GPL2+
 * Text Domain: jetpack
 */

function tweakjp_sd_shortcode() {
   return sharing_display();
}
add_shortcode( 'jpshare', 'tweakjp_sd_shortcode' );

?>