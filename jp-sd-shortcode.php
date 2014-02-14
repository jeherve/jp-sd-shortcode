<?php
/*
 * Plugin Name: [MyDesignStudio] Jetpack Sharing buttons shortcode
 * Plugin URI: https://github.com/alexbarmin/mds-jp-sd-shortcode
 * Description: Extends the Jetpack plugin and allows you to add sharing buttons anywhere inside your posts thanks to the [jpshare] shortcode
 * Author: Jeremy Herve
 * Version: 1.3
 * Author URI: http://jeremyherve.com
 * License: GPL2+
 * Text Domain: jetpack
 * GitHub Plugin URI: https://github.com/alexbarmin/mds-jp-sd-shortcode
 * GitHub Branch:     master
 */

function tweakjp_sd_shortcode() {
    /**
     * Unfortunatently, if no pages selected, shortcode doesn't work. Copy code from sharing_display here
     */
    $sharer = new Sharing_Service();
    $global = $sharer->get_global_options();

    $sharing_content = '';

    $enabled = apply_filters( 'sharing_enabled', $sharer->get_blog_services() );

    if ( count( $enabled['all'] ) > 0 ) {
        global $post;

        $dir = get_option( 'text_direction' );

        // Wrapper
        $sharing_content .= '<div class="sharedaddy sd-sharing-enabled"><div class="robots-nocontent sd-block sd-social sd-social-' . $global['button_style'] . ' sd-sharing">';
        if ( $global['sharing_label'] != '' )
            $sharing_content .= '<h3 class="sd-title">' . $global['sharing_label'] . '</h3>';
        $sharing_content .= '<div class="sd-content" style="float: left; "><ul>';

        // Visible items
        $visible = '';
        foreach ( $enabled['visible'] as $id => $service ) {
            // Individual HTML for sharing service
            $visible .= '<li class="share-' . $service->get_class() . '">' . $service->get_display( $post ) . '</li>';
        }

        $parts = array();
        $parts[] = $visible;
        if ( count( $enabled['hidden'] ) > 0 ) {
            if ( count( $enabled['visible'] ) > 0 )
                $expand = __( 'More', 'jetpack' );
            else
                $expand = __( 'Share', 'jetpack' );
            $parts[] = '<li><a href="#" class="sharing-anchor sd-button share-more"><span>'.$expand.'</span></a></li>';
        }

        if ( $dir == 'rtl' )
            $parts = array_reverse( $parts );

        $sharing_content .= implode( '', $parts );
        $sharing_content .= '<li class="share-end"></li></ul>';

        if ( count( $enabled['hidden'] ) > 0 ) {
            $sharing_content .= '<div class="sharing-hidden"><div class="inner" style="display: none;';

            if ( count( $enabled['hidden'] ) == 1 )
                $sharing_content .= 'width:150px;';

            $sharing_content .= '">';

            if ( count( $enabled['hidden'] ) == 1 )
                $sharing_content .= '<ul style="background-image:none;">';
            else
                $sharing_content .= '<ul>';

            $count = 1;
            foreach ( $enabled['hidden'] as $id => $service ) {
                // Individual HTML for sharing service
                $sharing_content .= '<li class="share-'.$service->get_class().'">';
                $sharing_content .= $service->get_display( $post );
                $sharing_content .= '</li>';

                if ( ( $count % 2 ) == 0 )
                    $sharing_content .= '<li class="share-end"></li>';

                $count ++;
            }

            // End of wrapper
            $sharing_content .= '<li class="share-end"></li></ul></div></div>';
        }

        $sharing_content .= '</div></div></div>';

        // Register our JS if not registered
        if (!wp_script_is("sharing-js", "registered ")) {
            wp_register_script( 'sharing-js', plugins_url().'/jetpack/modules/sharedaddy/sharing.js', array( 'jquery' ), '20121205' );
            add_action( 'wp_footer', 'sharing_add_footer' );
        }
    }

    return $sharing_content;
}

function tweakjp_sd_rm_shortcode( $content ) {
	return str_replace( '[jpshare]', '', $content );
}

function tweakjp_sd_enable() {
	if (class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'get_active_modules' ) && in_array( 'sharedaddy', Jetpack::get_active_modules() )) {
		add_shortcode( 'jpshare', 'tweakjp_sd_shortcode' );
	} else {
		add_filter( 'the_content', 'tweakjp_sd_rm_shortcode' );
	}
}
add_action( 'plugins_loaded', 'tweakjp_sd_enable' );
