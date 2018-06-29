<?php

/*
 *
 * @Shortcode Name : Start function for Eitor shortcode/element front end view
 * @retrun
 *
 */

if ( ! function_exists( 'wp_rem_cs_var_editor_shortocde' ) ) {

    function wp_rem_cs_var_editor_shortocde( $atts, $content = "" ) {
        $html = '';
        $page_element_size  = isset( $atts['editor_element_size'] )? $atts['editor_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html   .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_editor_title' => '',
            'wp_rem_cs_var_editor_subtitle' => '',
            'wp_rem_var_editor_align' => '',
        );
        extract( shortcode_atts( $defaults, $atts ) );
        
        if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
            }
        }
        if ( (isset( $wp_rem_cs_var_editor_title ) && $wp_rem_cs_var_editor_title <> "") || (isset( $content ) && $content <> "") ) {
            if ( isset( $column_class ) && $column_class <> '' ) {
                $html .= '<div class="' . esc_html( $column_class ) . '">';
            }
            ///// Editor Element Title

            $html .= wp_rem_title_sub_align($wp_rem_cs_var_editor_title, $wp_rem_cs_var_editor_subtitle, $wp_rem_var_editor_align);

            ///// Editor Content
            
            if ( isset( $content ) && $content <> "" ) {
                $content = nl2br( $content );
                $content = wp_rem_cs_var_custom_shortcode_decode( $content );
                $html .= '<div class="wp_rem_cs_editor">' . do_shortcode( $content ) . '</div>';
            }

            if ( isset( $column_class ) && $column_class <> '' ) {
                $html .= ' </div>';
            }
        }
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
           $html    .=  '</div>';
        }
        return $html;
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) ) {
        wp_rem_cs_var_short_code( 'wp_rem_cs_editor', 'wp_rem_cs_var_editor_shortocde' );
    }
}