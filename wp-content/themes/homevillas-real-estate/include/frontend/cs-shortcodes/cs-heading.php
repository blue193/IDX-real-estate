<?php

// start Heading shortcode front end view function
if ( ! function_exists( 'wp_rem_cs_var_heading' ) ) {

    function wp_rem_cs_var_heading( $atts, $content = "" ) {
        $divider_div = '';
        $html = '';
        $page_element_size  = isset( $atts['heading_element_size'] )? $atts['heading_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html   .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $defaults = array(
            'column_size' => '1/1',
            'wp_rem_cs_heading_title' => '',
            'wp_rem_cs_heading_subtitle' => '',
            'wp_rem_var_heading_align' => 'center',
            'wp_rem_cs_heading_color' => '#000',
            'class' => 'cs-heading-shortcode',
            'wp_rem_cs_heading_style' => '1',
            'wp_rem_cs_heading_size' => '',
            'wp_rem_cs_letter_space' => '0',
            'wp_rem_cs_line_height' => '',
            'wp_rem_cs_font_weight'=>'',
            'wp_rem_cs_heading_font_style' => '',
            'wp_rem_cs_heading_view' => '',
            'wp_rem_cs_heading_align' => 'align-center',
            'wp_rem_cs_heading_divider' => '',
        );

        extract( shortcode_atts( $defaults, $atts ) );
        $column_class = wp_rem_cs_var_custom_column_class( $column_size );
        $css = '';
        $he_font_style = '';

        $wp_rem_cs_heading_title = isset( $wp_rem_cs_heading_title ) ? $wp_rem_cs_heading_title : '';
        $wp_rem_cs_heading_subtitle = isset( $wp_rem_cs_heading_subtitle ) ? $wp_rem_cs_heading_subtitle : '';
        $wp_rem_cs_heading_color = isset( $wp_rem_cs_heading_color ) ? $wp_rem_cs_heading_color : '';
        $wp_rem_cs_heading_style = isset( $wp_rem_cs_heading_style ) ? $wp_rem_cs_heading_style : '';
        $wp_rem_cs_heading_size = isset( $wp_rem_cs_heading_size ) ? $wp_rem_cs_heading_size : '';
        $wp_rem_cs_letter_space = isset( $wp_rem_cs_letter_space ) ? $wp_rem_cs_letter_space : '';
        $wp_rem_cs_line_height = isset( $wp_rem_cs_line_height ) ? $wp_rem_cs_line_height : '';
        $wp_rem_cs_font_weight = isset( $wp_rem_cs_font_weight ) ? $wp_rem_cs_font_weight : '';
        $wp_rem_cs_heading_font_style = isset( $wp_rem_cs_heading_font_style ) ? $wp_rem_cs_heading_font_style : '';
        $wp_rem_cs_heading_view = isset( $wp_rem_cs_heading_view ) ? $wp_rem_cs_heading_view : '';
        $wp_rem_cs_heading_align = isset( $wp_rem_cs_heading_align ) ? $wp_rem_cs_heading_align : '';
        $wp_rem_cs_heading_divider = isset( $wp_rem_cs_heading_divider ) ? $wp_rem_cs_heading_divider : '';
        if ( $wp_rem_cs_heading_font_style <> '' ) {
            $he_font_style = ' font-style:' . $wp_rem_cs_heading_font_style;
        }
        echo balanceTags( $css, false );

      
        $wp_rem_cs_stylish_heading_class = '';
        if ( $wp_rem_cs_heading_style == 'stylish' ) {
            $wp_rem_cs_stylish_heading_class = ' cs-stylish-heading';
        }
        if ( $wp_rem_cs_heading_view == 'view-1' ) {
            $html .= '<div class="fancy-heading '.esc_html($wp_rem_cs_heading_align).'' . esc_html( $wp_rem_cs_stylish_heading_class ) . '">';
        } else {
            $html .= '<div class="element-title '.esc_html($wp_rem_cs_heading_align).'' . esc_html( $wp_rem_cs_stylish_heading_class ) . '">';
        }
        if ( $wp_rem_cs_heading_style == 'section_title' ) {
            $html .= '<div class="element-title '.esc_html($wp_rem_var_heading_align).'"><h2 style="color:' . esc_html( $wp_rem_cs_heading_color ) . ' !important; font-size: ' . esc_html( $wp_rem_cs_heading_size ) . 'px !important; letter-spacing: ' . esc_html( $wp_rem_cs_letter_space ) . 'px !important; line-height: ' . esc_html( $wp_rem_cs_line_height ) . 'px !important; font-weight: ' . esc_html( $wp_rem_cs_font_weight ) . ' !important; text-align:' . esc_html( $wp_rem_cs_heading_align ) . ';' . esc_html( $he_font_style ) . ';">' . esc_html( $wp_rem_cs_heading_title ) . '</h2></div>';
        } elseif ( $wp_rem_cs_heading_style == 'fancy' ) {
            $html .= '<h3 class="cs-fancy" style="color:' . esc_html( $wp_rem_cs_heading_color ) . ' !important; font-size: ' . esc_html( $wp_rem_cs_heading_size ) . 'px !important; letter-spacing: ' . esc_html( $wp_rem_cs_letter_space ) . 'px !important; line-height: ' . esc_html( $wp_rem_cs_line_height ) . 'px !important; font-weight: ' . esc_html( $wp_rem_cs_font_weight ) . ' !important; text-align:' . esc_html( $wp_rem_cs_heading_align ) . ';' . esc_html( $he_font_style ) . ';">' . esc_html( $wp_rem_cs_heading_title ) . '</h3>';
        } elseif ( $wp_rem_cs_heading_style == 'stylish' ) {
            $html .= '<h2 style="color:' . esc_html( $wp_rem_cs_heading_color ) . ' !important; font-size: ' . esc_html( $wp_rem_cs_heading_size ) . 'px !important; letter-spacing: ' . esc_html( $wp_rem_cs_letter_space ) . 'px !important; line-height: ' . esc_html( $wp_rem_cs_line_height ) . 'px !important; font-weight: ' . esc_html( $wp_rem_cs_font_weight ) . ' !important; text-align:' . esc_html( $wp_rem_cs_heading_align ) . ';' . esc_html( $he_font_style ) . ';">' . esc_html( $wp_rem_cs_heading_title ) . '</h2>';
        } elseif ( $wp_rem_cs_heading_style == 'modern' ) {
            if ( $wp_rem_cs_heading_title != '' ) {
                $heading_title_words = explode( " ", $wp_rem_cs_heading_title );
                $heading_title_words[0] = isset( $heading_title_words[0] ) ? '<span class="cs-color">' . esc_html($heading_title_words[0]) . '</span>' : '';
                $wp_rem_cs_heading_title = implode( ' ', $heading_title_words );
                $html .= '<h3 style="color:' . esc_html( $wp_rem_cs_heading_color ) . ' !important; font-size: ' . esc_html( $wp_rem_cs_heading_size ) . 'px !important; letter-spacing: ' . esc_html( $wp_rem_cs_letter_space ) . 'px !important; line-height: ' . esc_html( $wp_rem_cs_line_height ) . 'px !important; font-weight: ' . esc_html( $wp_rem_cs_font_weight ) . ' !important; text-align:' . esc_html( $wp_rem_cs_heading_align ) . ';' . esc_html( $he_font_style ) . ';">' . esc_html( $wp_rem_cs_heading_title ) . '</h3>';
            }
        } else {
            if($wp_rem_cs_heading_title <> ''){
            $html .= '<h' . esc_html($wp_rem_cs_heading_style) . ' style="color:' . esc_html( $wp_rem_cs_heading_color ) . ' !important; font-size: ' . esc_html( $wp_rem_cs_heading_size ) . 'px !important; letter-spacing: ' . esc_html( $wp_rem_cs_letter_space ) . 'px !important; line-height: ' . esc_html( $wp_rem_cs_line_height ) . 'px !important; font-weight: ' . esc_html( $wp_rem_cs_font_weight ) . ' !important; text-align:' . esc_html( $wp_rem_var_heading_align ) . ';' . esc_html( $he_font_style ) . ';">' . esc_html( $wp_rem_cs_heading_title ) . '</h' . esc_html($wp_rem_cs_heading_style) . '>';
            }
            if($wp_rem_cs_heading_subtitle <> ''){
                 $style_subtitle = '';
                 if(isset($wp_rem_cs_heading_color) && $wp_rem_cs_heading_color <> ''){
                    $style_subtitle = ' style="color: ' . esc_html( $wp_rem_cs_heading_color ) . ' !important;"'; 
                 }
                $html .= '<p' . $style_subtitle . '>'.esc_html($wp_rem_cs_heading_subtitle).'</p>';
            }
            
        }
        if ( $content != '' ) {
            $html .= nl2br( $content );
        }
        if ( isset( $wp_rem_cs_heading_divider ) and $wp_rem_cs_heading_divider == 'on' ) {
            $html .= '<div class="center">';
            $html .= '<div class="cs-spreator">';
            $html .= '<div class="cs-seprater" style="text-align:center;"> <span> <i class="icon-transport177"> </i> </span> </div>';
            $html .= '</div>';
            $html .= '</div>';
        }
        $html .= '</div>';
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
           $html    .=  '</div>';
        }
        return do_shortcode( $html );
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) ) {
        wp_rem_cs_var_short_code( 'wp_rem_cs_heading', 'wp_rem_cs_var_heading' );
    }
}