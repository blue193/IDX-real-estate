<?php

/*
 *
 * @File : Call to action
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_call_to_action_shortcode') ) {

    function wp_rem_cs_var_call_to_action_shortcode($atts, $content = "") {
        $html = '';
        $page_element_size = isset($atts['call_to_action_element_size']) ? $atts['call_to_action_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_call_to_action_title' => '',
            'wp_rem_cs_var_call_to_action_subtitle' => '',
            'wp_rem_var_call_to_action_align' => '',
            'wp_rem_cs_var_call_action_subtitle' => '',
            'wp_rem_cs_var_heading_color' => '#000',
            'wp_rem_cs_var_call_to_action_icon_background_color' => '',
            'wp_rem_cs_var_call_to_action_button_text' => '',
            'wp_rem_cs_var_call_to_action_button_link' => '#',
            'wp_rem_cs_var_contents_bg_color' => '',
            'wp_rem_cs_var_call_to_action_img_array' => '',
            'wp_rem_cs_var_call_action_text_align' => '',
            'wp_rem_cs_var_call_action_img_align' => '',
            'wp_rem_cs_var_button_bg_color' => '',
            'wp_rem_cs_var_button_border_color' => '',
            'wp_rem_var_call_to_action_style' => '',
        );

        extract(shortcode_atts($defaults, $atts));

        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_call_to_action_img_array = isset($wp_rem_cs_var_call_to_action_img_array) ? $wp_rem_cs_var_call_to_action_img_array : '';
        $wp_rem_cs_var_call_action_img_align = isset($wp_rem_cs_var_call_action_img_align) ? $wp_rem_cs_var_call_action_img_align : '';
        $wp_rem_cs_var_call_to_action_title = isset($wp_rem_cs_var_call_to_action_title) ? $wp_rem_cs_var_call_to_action_title : '';
        $wp_rem_var_call_to_action_style = isset($wp_rem_var_call_to_action_style) ? $wp_rem_var_call_to_action_style : '';
        $wp_rem_cs_var_call_action_text_align = isset($wp_rem_cs_var_call_action_text_align) ? $wp_rem_cs_var_call_action_text_align : '';
        $wp_rem_cs_var_call_action_subtitle = isset($wp_rem_cs_var_call_action_subtitle) ? $wp_rem_cs_var_call_action_subtitle : '';
        $wp_rem_cs_var_heading_color = isset($wp_rem_cs_var_heading_color) ? $wp_rem_cs_var_heading_color : '';
        $wp_rem_cs_var_call_action_contents = $content;
        $wp_rem_cs_var_call_to_action_button_text = isset($wp_rem_cs_var_call_to_action_button_text) ? $wp_rem_cs_var_call_to_action_button_text : '';
        $wp_rem_cs_var_call_to_action_button_link = isset($wp_rem_cs_var_call_to_action_button_link) ? $wp_rem_cs_var_call_to_action_button_link : '';
        $wp_rem_cs_var_button_bg_color = isset($wp_rem_cs_var_button_bg_color) ? $wp_rem_cs_var_button_bg_color : '';
        $wp_rem_cs_var_button_border_color = isset($wp_rem_cs_var_button_border_color) ? $wp_rem_cs_var_button_border_color : '';
        $wp_rem_cs_var_contents_bg_color = isset($wp_rem_cs_var_contents_bg_color) ? $wp_rem_cs_var_contents_bg_color : '';
        $wp_rem_cs_var_call_to_action_icon_background_color = isset($wp_rem_cs_var_call_to_action_icon_background_color) ? $wp_rem_cs_var_call_to_action_icon_background_color : '';
        $column_class = '';

        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        $call_to_action_class = ' default';
        if ( $wp_rem_var_call_to_action_style == 'classic' ) {
            $call_to_action_class = ' classic';
        }

        $style_string = $wp_rem_cs_var_CustomId = '';
        if ( $wp_rem_cs_var_call_to_action_img_array ) {
            $style_string .= ' background:url(' . esc_url($wp_rem_cs_var_call_to_action_img_array) . ') ' . esc_html($wp_rem_cs_var_call_action_img_align) . ' !important; background-color:#fff;';
        } else {
            $style_string .= ' background-color:' . esc_html($wp_rem_cs_var_contents_bg_color) . ' !important;';
        }
        $style_string = ' style="' . $style_string . '"';

        $html .= wp_rem_title_sub_align($wp_rem_cs_var_call_to_action_title, $wp_rem_cs_var_call_to_action_subtitle, $wp_rem_var_call_to_action_align);

        $html .= '<div class="calltoaction-bg" ' . wp_rem_cs_allow_special_char($style_string) . '>';

        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '<div  class="' . esc_html($column_class) . '" >';
        }
        $html .= '<div class="cs-calltoaction' . $call_to_action_class . '">';
        $html .= '<div class="cs-text">';
        if ( isset($wp_rem_cs_var_call_action_subtitle) && $wp_rem_cs_var_call_action_subtitle <> '' ) {
            $color_string = '';
            if ( $wp_rem_cs_var_heading_color != '' ) {
                $color_string = ' style="color:' . esc_html($wp_rem_cs_var_heading_color) . ' !important;"';
            }
            $html .= '<h2 ' . wp_rem_cs_allow_special_char($color_string) . '>' . esc_html($wp_rem_cs_var_call_action_subtitle) . '</h2>';
        }
        if ( $wp_rem_cs_var_call_action_contents != '' ) {
            $color_string = '';

            $html .= do_shortcode($wp_rem_cs_var_call_action_contents);
        }
        if ( isset($wp_rem_cs_var_call_to_action_button_text) and $wp_rem_cs_var_call_to_action_button_text <> '' ) {
            $color_string = '';
            $button_text_color = '';
            if ( $wp_rem_cs_var_call_to_action_icon_background_color != '' ) {
                $button_text_color = ' color:' . esc_attr($wp_rem_cs_var_call_to_action_icon_background_color) . ' !important;';
            }
            $button_border_color = '';
            if ( $wp_rem_cs_var_button_border_color != '' ) {
                $button_border_color = ' border: 2px solid ' . esc_html($wp_rem_cs_var_button_border_color) . ' !important;';
            }
            if ( $wp_rem_cs_var_button_bg_color != '' || $wp_rem_cs_var_call_to_action_icon_background_color != '' ) {
                $color_string = ' style="background-color:' . esc_html($wp_rem_cs_var_button_bg_color) . ' !important; ' . $button_text_color . '' . $button_border_color . '"';
            }

            $html .= '</div>';
            $html .= '<a href="' . esc_url($wp_rem_cs_var_call_to_action_button_link) . '" class="csborder-color cs-color" ' . wp_rem_cs_allow_special_char($color_string) . '>' . esc_html($wp_rem_cs_var_call_to_action_button_text) . '</a>';
        }
        $html .= '</div>';

        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '</div>';
        }
        $html .= '</div>';
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }
        return wp_rem_cs_allow_special_char($html);
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('call_to_action', 'wp_rem_cs_var_call_to_action_shortcode');
    }
}