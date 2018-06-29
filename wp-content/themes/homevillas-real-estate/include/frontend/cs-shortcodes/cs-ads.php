<?php

/**
 * Ads html view for page builder
 *
 * @package Wp Rem */
if ( ! function_exists( 'wp_rem_cs_var_wp_rem_cs_ads' ) ) {

    /**
     * Display ads shortcode html.
     *
     * @param array  $atts ads shortcode attributes.
     * @param string $content ads shortcode content.
     */
    function wp_rem_cs_var_wp_rem_cs_ads( $atts = '', $content = '' ) {

        global $wp_rem_cs_var_options;
        $defaults = array( 'id' => '0' );
        extract( shortcode_atts( $defaults, $atts ) );
        $html = '';
        $page_element_size  = isset( $atts['ads_element_size'] )? $atts['ads_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html   .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        if ( isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'] ) && is_array( $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'] ) ) {
            $i = 0;
            foreach ( $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'] as $banner ) :
                if ( $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'][$i] === $id ) {
                    break;
                }
                $i ++;
            endforeach;

            $wp_rem_cs_var_banner_title = isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_title'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_title'][$i] : '';
            $wp_rem_cs_var_banner_style = isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_style'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_style'][$i] : '';
            $wp_rem_cs_var_banner_type = isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_type'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_type'][$i] : '';
            $wp_rem_cs_var_banner_image = isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_image_array'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_image_array'][$i] : '';
            $wp_rem_cs_var_banner_url = isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_url'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_url'][$i] : '';
            $wp_rem_cs_var_banner_url_target = isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_target'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_target'][$i] : '';
            $wp_rem_cs_var_banner_adsense_code = isset( $wp_rem_cs_var_options['wp_rem_cs_var_adsense_code'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_adsense_code'][$i] : '';
            $wp_rem_cs_var_banner_code_no = isset( $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'][$i] ) ? $wp_rem_cs_var_options['wp_rem_cs_var_banner_field_code_no'][$i] : '';

            if ( 'image' === $wp_rem_cs_var_banner_type ) {
                $banner_cookie = wp_rem_cs_get_cookie( 'banner_clicks_' . wp_rem_cs_allow_special_char($wp_rem_cs_var_banner_code_no), false );

                if ( ! isset( $banner_cookie ) || $banner_cookie == '' ) {

                    $html .= '<div class="cs-media ad-banner ' . esc_html( $wp_rem_cs_var_banner_style ) . '"><figure><a onclick="wp_rem_cs_var_banner_click_count_plus(\'' . admin_url( 'admin-ajax.php' ) . '\', \'' . esc_html($wp_rem_cs_var_banner_code_no) . '\')" id="banner_clicks' . esc_html($wp_rem_cs_var_banner_code_no) . '" href="' . esc_url( $wp_rem_cs_var_banner_url ) . '" target="_blank"><img src="' . esc_url( $wp_rem_cs_var_banner_image ) . '" alt="' . esc_attr($wp_rem_cs_var_banner_title) . '" /></a></figure></div>';
                } else {
                    $html .= '<div class="cs-media ad-banner ' . esc_html( $wp_rem_cs_var_banner_style ) . '"><figure><a href="' . esc_url( $wp_rem_cs_var_banner_url ) . '" target="' . esc_attr($wp_rem_cs_var_banner_url_target) . '"><img src="' . esc_url( $wp_rem_cs_var_banner_image ) . '" alt="' . esc_attr($wp_rem_cs_var_banner_title) . '" /></a></figure></div>';
                }
            } else {
                $html .= htmlspecialchars_decode( stripslashes( $wp_rem_cs_var_banner_adsense_code ) );
            }
        }

        $wp_rem_cs_inline_script = '
		function wp_rem_cs_var_banner_click_count_plus(ajax_url, id) {
			"use strict";
			var dataString = "code_id=" + id + "&action=wp_rem_cs_var_banner_click_count_plus";
			jQuery.ajax({
				type: "POST",
				url: ajax_url,
				data: dataString,
				success: function (response) {
				if (response != "error") {
						jQuery("#banner_clicks" + id).removeAttr("onclick");
					}
				}
			});
			return false;
		}';
        wp_rem_cs_inline_enqueue_script( $wp_rem_cs_inline_script, 'wp_rem_cs-functions' );
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
           $html    .=  '</div>';
        }
       return $html;

        return do_shortcode( $html );
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) ) {
        wp_rem_cs_var_short_code( 'wp_rem_cs_ads', 'wp_rem_cs_var_wp_rem_cs_ads' );
    }
}
