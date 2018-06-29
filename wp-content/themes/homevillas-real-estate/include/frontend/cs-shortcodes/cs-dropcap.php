<?php

/**
 * dropcap html form for page builder
 */
if ( ! function_exists( 'wp_rem_cs_var_dropcap_shortcode' ) ) {

    function wp_rem_cs_var_dropcap_shortcode( $atts, $content = "" ) {
         $html = '';
        $page_element_size  = isset( $atts['dropcap_element_size'] )? $atts['dropcap_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html   .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $wp_rem_cs_var_defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_dropcap_section_title' => '',
            'wp_rem_cs_dropcap_section_subtitle' => '',
            'wp_rem_var_dropcap_align' => '',
        );
        $author_name = '';
        extract( shortcode_atts( $wp_rem_cs_var_defaults, $atts ) );

        $wp_rem_cs_dropcap_section_title = isset( $wp_rem_cs_dropcap_section_title ) ? $wp_rem_cs_dropcap_section_title : '';
        $dropcap_cite_url = isset( $dropcap_cite_url ) ? $dropcap_cite_url : '';
        $dropcap_cite = isset( $dropcap_cite ) ? $dropcap_cite : '';
        if ( isset( $dropcap_cite_url ) && $dropcap_cite_url <> '' ) {

            if ( isset( $dropcap_cite_url ) && $dropcap_cite_url <> '' ) {
                $author_name .= '<a href="' . esc_url( $dropcap_cite_url ) . '">';
            }
            $author_name .= '-- ' . $dropcap_cite;
            if ( isset( $dropcap_cite_url ) && $dropcap_cite_url <> '' ) {
                $author_name .= '</a>';
            }
        }
        $column_class = '';
        if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
            }
        }
        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '<div  class="' . esc_html( $column_class ) . '" >';
        }
        $html .= wp_rem_title_sub_align($wp_rem_cs_dropcap_section_title, $wp_rem_cs_dropcap_section_subtitle, $wp_rem_var_dropcap_align);
        $html .= '<div class="cs-dropcap">
		<p>' . do_shortcode( $content ) . '</p>
		</div>';
        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '</div>';
        }
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
           $html    .=  '</div>';
        }
        return $html;
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) )
        wp_rem_cs_var_short_code( 'wp_rem_cs_dropcap', 'wp_rem_cs_var_dropcap_shortcode' );
}