<?php

/*
 *
 * @Shortcode Name :  infobox front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_infobox_shortcode') ) {

    function wp_rem_cs_var_infobox_shortcode($atts, $content = "") {
        global $post, $wp_rem_cs_var_infobox_column, $wp_rem_cs_var_infobox_title_color, $wp_rem_cs_var_info_icon_color, $wp_rem_var_infobox_styles;
        $html = '';
        $page_element_size = isset($atts['infobox_element_size']) ? $atts['infobox_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }

        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_infobox_icon' => '',
            'wp_rem_cs_var_infobox_main_title' => '',
            'wp_rem_cs_var_infobox_main_subtitle' => '',
            'wp_rem_var_infobox_align' => '',
            'wp_rem_cs_var_info_icon_color' => '',
            'wp_rem_cs_var_info_heading_color'=>'',
            'wp_rem_var_infobox_styles' => '',
            'wp_rem_cs_var_info_content_color' => '',
            'infobox_get_in_touch_url' => '',
            'infobox_get_in_touch_text' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_infobox_main_title = isset($wp_rem_cs_var_infobox_main_title) ? $wp_rem_cs_var_infobox_main_title : '';
        $wp_rem_cs_var_info_icon_color = isset($wp_rem_cs_var_info_icon_color) ? $wp_rem_cs_var_info_icon_color : '';
        $wp_rem_cs_var_info_title_color = isset($wp_rem_cs_var_info_title_color) ? $wp_rem_cs_var_info_title_color : '';
        $wp_rem_var_infobox_styles = isset($wp_rem_var_infobox_styles) ? $wp_rem_var_infobox_styles : '';
        $infobox_get_in_touch_url = isset($infobox_get_in_touch_url) ? $infobox_get_in_touch_url : '';
        $infobox_get_in_touch_text = isset($infobox_get_in_touch_text) ? $infobox_get_in_touch_text : '';
        $wp_rem_cs_section_title = '';
        $wp_rem_cs_section_sub_title = '';
        $column_class = '';
        $column_class = '';
        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }
        if ( $wp_rem_var_infobox_styles == 'modern' ) {
            $html .='<div class="contact-property modern">';
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_infobox_main_title, $wp_rem_cs_var_infobox_main_subtitle, $wp_rem_var_infobox_align,$wp_rem_cs_var_info_heading_color);
            $html .='<div class="row">';
            $html .= do_shortcode($content);
            $html .= '</div>';
            $html .= '</div>';
        } elseif ( $wp_rem_var_infobox_styles == 'classic' ) {
            $html .='<div class="contact-property default">';
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_infobox_main_title, $wp_rem_cs_var_infobox_main_subtitle, $wp_rem_var_infobox_align,$wp_rem_cs_var_info_heading_color);
            $html .='<ul class="contact-info">';
            $html .= do_shortcode($content);
            $html .='</ul>';
            if ( isset($infobox_get_in_touch_text) && $infobox_get_in_touch_text != '' ) {
                $html .='<a href="' . esc_url($infobox_get_in_touch_url) . '">' . esc_html($infobox_get_in_touch_text) . ' </a>';
            }
            $html .= '</div>';
        } else {
            $html .='<div class="contact-property">';
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_infobox_main_title, $wp_rem_cs_var_infobox_main_subtitle, $wp_rem_var_infobox_align,$wp_rem_cs_var_info_heading_color);
            $html .='<ul class="contact-info">';
            $html .= do_shortcode($content);
            $html .='</ul>';
            $html .= '</div>';
        }

        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '</div>';
        }
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }
        return do_shortcode($html);
    }

}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('wp_rem_cs_infobox', 'wp_rem_cs_var_infobox_shortcode');
/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_infobox_item_shortcode') ) {

    function wp_rem_cs_var_infobox_item_shortcode($atts, $content = "") {
        global $post, $wp_rem_cs_var_infobox_column, $wp_rem_cs_var_infobox_title_color, $wp_rem_cs_var_info_icon_color, $wp_rem_var_infobox_styles;
        $output = '';
        $defaults = array(
            'wp_rem_cs_var_infobox_element_title' => '',
            'wp_rem_cs_var_infobox_icon' => '',
            'wp_rem_cs_var_icon_box' => '',
            'wp_rem_cs_var_icon_box_group' => 'default',
            'wp_rem_cs_var_infobox_title' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_infobox_column_str = '';
        $wp_rem_cs_var_infobox_element_title = isset($wp_rem_cs_var_infobox_element_title) ? $wp_rem_cs_var_infobox_element_title : '';
        $wp_rem_cs_var_infobox_title = isset($wp_rem_cs_var_infobox_title) ? $wp_rem_cs_var_infobox_title : '';
        $wp_rem_cs_var_icon_box = isset($wp_rem_cs_var_icon_box) ? $wp_rem_cs_var_icon_box : '';
        $title_color = '';
        $icon_color = '';
        wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_icon_box_group );
        if ( isset($wp_rem_cs_var_infobox_title_color) && $wp_rem_cs_var_infobox_title_color != '' ) {
            $title_color = 'style="color:' . esc_html($wp_rem_cs_var_infobox_title_color) . '"';
        }
        if ( isset($wp_rem_cs_var_info_icon_color) && $wp_rem_cs_var_info_icon_color != '' ) {
            $icon_color = 'style="color:' . esc_html($wp_rem_cs_var_info_icon_color) . ' !important"';
        }
        if ( $wp_rem_var_infobox_styles == 'modern' ) {
            $output .='<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">';
            $output .='<ul class="contact-info">';
            $output .= '
                    <li>
                            <i ' . $icon_color . ' class="' . esc_html($wp_rem_cs_var_icon_box) . '"></i>
                            <div class="address-text"><span class="label-title">' . $wp_rem_cs_var_infobox_title . '</span><span class="info-desc">' . do_shortcode($content) . '</span></div>
                    </li>';
            $output .='</ul>';
            $output .= '</div>';
        } elseif ( $wp_rem_var_infobox_styles == 'classic' ) {
            $output .= '
                    <li>
                            <div class="address-text"><span class="label-title">' . $wp_rem_cs_var_infobox_title . '</span><span class="info-desc">' . do_shortcode($content) . '</span></div>
                    </li>';
        } else {
            $output .= '
                    <li>
                            <i ' . $icon_color . ' class="' . esc_html($wp_rem_cs_var_icon_box) . '"></i>
                            <div class="address-text"><span class="label-title">' . $wp_rem_cs_var_infobox_title . '</span><span class="info-desc">' . do_shortcode($content) . '</span></div>
                    </li>';
        }
        $randid = rand(877, 9999);
        return force_balance_tags($output);
    }

}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('infobox_item', 'wp_rem_cs_var_infobox_item_shortcode');