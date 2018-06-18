<?php

/*
 *
 * @Shortcode Name : Map
 * @retrun
 *
 */
if ( ! function_exists( 'wp_rem_cs_var_column' ) ) {

    function wp_rem_cs_var_column( $atts, $content = "" ) {
        global $header_map;
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_column_section_title' => '',
             'wp_rem_cs_var_column_section_subtitle' => '',
            'wp_rem_var_column_align' => '',
            'wp_rem_cs_var_column_text' => '',
            'wp_rem_cs_column_margin_left' => '',
            'wp_rem_cs_column_margin_right' => '',
            'wp_rem_cs_var_column_top_padding' => '',
            'wp_rem_cs_var_column_bottom_padding' => '',
            'wp_rem_cs_var_column_left_padding' => '',
            'wp_rem_cs_var_column_right_padding' => '',
            'wp_rem_cs_var_column_image_url_array' => '',
            'wp_rem_cs_var_column_bg_color' => '',
            'wp_rem_cs_var_column_title_color' => '',
        );
        extract( shortcode_atts( $defaults, $atts ) );

        $wp_rem_cs_var_column_section_title = isset( $wp_rem_cs_var_column_section_title ) ? $wp_rem_cs_var_column_section_title : '';
        $wp_rem_cs_var_column_title_color = isset( $wp_rem_cs_var_column_title_color ) ? $wp_rem_cs_var_column_title_color : '';
        $wp_rem_cs_column_margin_left = isset( $wp_rem_cs_column_margin_left ) ? $wp_rem_cs_column_margin_left : '';
        $wp_rem_cs_column_margin_right = isset( $wp_rem_cs_column_margin_right ) ? $wp_rem_cs_column_margin_right : '';
        $wp_rem_cs_var_column_top_padding = isset( $wp_rem_cs_var_column_top_padding ) ? $wp_rem_cs_var_column_top_padding : '';
        $wp_rem_cs_var_column_bottom_padding = isset( $wp_rem_cs_var_column_bottom_padding ) ? $wp_rem_cs_var_column_bottom_padding : '';
        $wp_rem_cs_var_column_left_padding = isset( $wp_rem_cs_var_column_left_padding ) ? $wp_rem_cs_var_column_left_padding : '';
        $wp_rem_cs_var_column_right_padding = isset( $wp_rem_cs_var_column_right_padding ) ? $wp_rem_cs_var_column_right_padding : '';
        $wp_rem_cs_var_column_image_url = isset( $atts['wp_rem_cs_var_column_image_url_array'] ) ? $atts['wp_rem_cs_var_column_image_url_array'] : '';
       $wp_rem_cs_var_column_bg_color = isset( $wp_rem_cs_var_column_bg_color ) ? $wp_rem_cs_var_column_bg_color : '';
       

        $column_class = '';
        if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
            }
        }

        $style_string = '';
        if ( $wp_rem_cs_var_column_bg_color != '' || $wp_rem_cs_var_column_top_padding != '' || $wp_rem_cs_var_column_bottom_padding != '' || $wp_rem_cs_var_column_left_padding != '' || $wp_rem_cs_var_column_right_padding != '' || $wp_rem_cs_column_margin_left != '' || $wp_rem_cs_column_margin_right != '' ) {
            $style_string .= 'style=" ';
            if ( $wp_rem_cs_var_column_top_padding != '' ) {
                $style_string .= ' padding-top:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_column_top_padding) . 'px; ';
            }
            if ( $wp_rem_cs_var_column_bottom_padding != '' ) {
                $style_string .= ' padding-bottom:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_column_bottom_padding) . 'px; ';
            }
            if ( $wp_rem_cs_var_column_left_padding != '' ) {
                $style_string .= ' padding-left:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_column_left_padding) . 'px; ';
            }
            if ( $wp_rem_cs_var_column_right_padding != '' ) {
                $style_string .= ' padding-right:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_column_right_padding) . 'px; ';
            }
            if ( $wp_rem_cs_column_margin_left != '' ) {
                $style_string .= ' margin-left:' . wp_rem_cs_allow_special_char($wp_rem_cs_column_margin_left) . 'px; ';
            }
            if ( $wp_rem_cs_column_margin_right != '' ) {
                $style_string .= ' margin-right:' . wp_rem_cs_allow_special_char($wp_rem_cs_column_margin_right) . 'px; ';
            }
            if ( $wp_rem_cs_var_column_image_url != '' ) {
                $style_string .= ' background-image: url(' . esc_url( $wp_rem_cs_var_column_image_url ) . ');';
            }
            if ( $wp_rem_cs_var_column_bg_color != '' ) {
                $style_string .= ' background-color:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_column_bg_color) . '; ';
            }
            $style_string .= '" ';
        }
        $html_column = '';
        $page_element_size = isset( $atts['flex_column_element_size'] ) ? $atts['flex_column_element_size'] : 100;
        if ( function_exists( 'wp_rem_cs_var_page_builder_element_sizes' ) ) {
            $html_column .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes( $page_element_size ) . ' ">';
        }
        if ( isset( $column_class ) && $column_class <> '' ) {
            $html_column .= '<div class="' . force_balance_tags( $column_class ) . '">';
        }
        $wp_rem_cs_column_bg_class = '';
        if ( isset( $wp_rem_cs_var_column_bg_color ) && $wp_rem_cs_var_column_bg_color != '' ) {
            $wp_rem_cs_column_bg_class = ' has-bg';
        }
        if ( isset( $wp_rem_cs_var_column_section_title ) && $wp_rem_cs_var_column_section_title != '' ) {
            $title_style = '';
            if ( $wp_rem_cs_var_column_title_color ) {
                $title_style = 'style="color:' . ( $wp_rem_cs_var_column_title_color ) . ' !important;"';
            }
            $html_column .= wp_rem_title_sub_align($wp_rem_cs_var_column_section_title, $wp_rem_cs_var_column_section_subtitle, $wp_rem_var_column_align,$wp_rem_cs_var_column_title_color);
        }
        $html_column .= '<div  class="column-content ' . esc_html( $wp_rem_cs_column_bg_class ) . '" ' . force_balance_tags( $style_string ) . '>';
        $html_column .= do_shortcode( $content );
        $html_column .= '</div>';
        if ( isset( $column_class ) && $column_class <> '' ) {
            $html_column .= '</div>';
        }
        if ( function_exists( 'wp_rem_cs_var_page_builder_element_sizes' ) ) {
            $html_column .= '</div>';
        }
        return $html_column;
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) )
        wp_rem_cs_var_short_code( 'wp_rem_cs_column', 'wp_rem_cs_var_column' );
}