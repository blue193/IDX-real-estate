<?php

/**
 * @Divider html form for page builder
 */
if ( ! function_exists( 'wp_rem_cs_var_wp_rem_cs_divider_shortcode' ) ) {

    function wp_rem_cs_var_wp_rem_cs_divider_shortcode( $atts, $content = "" ) {
        $html = '';
        $page_element_size  = isset( $atts['divider_element_size'] )? $atts['divider_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html   .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $wp_rem_cs_var_defaults = array(
            'wp_rem_cs_var_divider_padding_left' => '0',
            'wp_rem_cs_var_divider_padding_right' => '0',
            'wp_rem_cs_var_divider_margin_top' => '0',
            'wp_rem_cs_var_divider_margin_buttom' => '0',
            'wp_rem_cs_var_divider_align' => '',
        );
        extract( shortcode_atts( $wp_rem_cs_var_defaults, $atts ) );


        $wp_rem_cs_var_divider_padding_left = isset( $wp_rem_cs_var_divider_padding_left ) ? $wp_rem_cs_var_divider_padding_left : '';
        $wp_rem_cs_var_divider_padding_right = isset( $wp_rem_cs_var_divider_padding_right ) ? $wp_rem_cs_var_divider_padding_right : '';
        $wp_rem_cs_var_divider_margin_top = isset( $wp_rem_cs_var_divider_margin_top ) ? $wp_rem_cs_var_divider_margin_top : '';
        $wp_rem_cs_var_divider_margin_buttom = isset( $wp_rem_cs_var_divider_margin_buttom ) ? $wp_rem_cs_var_divider_margin_buttom : '';
        $wp_rem_cs_var_divider_align = isset( $wp_rem_cs_var_divider_align ) ? $wp_rem_cs_var_divider_align : '';
        $style_string = '';
        if ( $wp_rem_cs_var_divider_padding_left != '' || $wp_rem_cs_var_divider_padding_right != '' || $wp_rem_cs_var_divider_margin_top != '' || $wp_rem_cs_var_divider_margin_buttom != '' ) {
            $style_string .= ' ';
            if ( $wp_rem_cs_var_divider_padding_left != '' ) {
                $style_string .= ' padding-left:' . esc_html( $wp_rem_cs_var_divider_padding_left ) . 'px; ';
            }
            if ( $wp_rem_cs_var_divider_padding_right != '' ) {
                $style_string .= ' padding-right:' . esc_html( $wp_rem_cs_var_divider_padding_right ) . 'px; ';
            }
            if ( $wp_rem_cs_var_divider_margin_top != '' ) {
                $style_string .= ' margin-top:' . esc_html( $wp_rem_cs_var_divider_margin_top ) . 'px; ';
            }
            if ( $wp_rem_cs_var_divider_margin_buttom != '' ) {
                $style_string .= ' margin-bottom:' . esc_html( $wp_rem_cs_var_divider_margin_buttom ) . 'px; ';
            }

            $style_string .= ' ';
        }
        $html .= '<div class="' . esc_html( $wp_rem_cs_var_divider_align ) . '">';
        $html .= '<div  style=" ' . esc_html( $style_string ) . '" class="cs-spreator">';
        $html .= '<div class="cs-seprater" style="text-align:center;"> <span> <i class="icon-transport177"> </i> </span> </div>';
        $html .= '</div>';
        $html .= '</div>';
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
           $html    .=  '</div>';
        }
        return do_shortcode( $html );
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) )
        wp_rem_cs_var_short_code( 'wp_rem_cs_divider', 'wp_rem_cs_var_wp_rem_cs_divider_shortcode' );
}