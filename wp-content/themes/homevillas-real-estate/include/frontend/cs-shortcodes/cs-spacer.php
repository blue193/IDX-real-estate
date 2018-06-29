<?php

/**
 * @Spacer html form for page builder
 */
if ( ! function_exists( 'wp_rem_cs_var_spacer_shortcode' ) ) {

    function wp_rem_cs_var_spacer_shortcode( $atts, $content = "" ) {
        global $wp_rem_cs_border;

        $wp_rem_cs_var_defaults = array( 'wp_rem_cs_var_spacer_height' => '25' );
        extract( shortcode_atts( $wp_rem_cs_var_defaults, $atts ) );

        return '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:' . do_shortcode( $wp_rem_cs_var_spacer_height ) . 'px">
		</div>';
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) )
        wp_rem_cs_var_short_code( 'spacer', 'wp_rem_cs_var_spacer_shortcode' );
}