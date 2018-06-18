<?php

/*
 *
 * @Shortcode Name : Image Frame
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_image_frame') ) {

    function wp_rem_cs_var_image_frame($atts, $content = "") {

        global $header_map, $post;
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_image_section_title' => '',
            'wp_rem_cs_var_image_section_subtitle' => '',
            'wp_rem_cs_var_frame_image_url_array' => '',
            'wp_rem_cs_var_image_title' => '',
            'wp_rem_var_image_title_align' => '',
            'wp_rem_cs_var_img_align' => '',
            'wp_rem_cs_var_img_style' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $main_post_class = '';
        $col_respons_class = '';
        if ( $wp_rem_cs_var_img_style == 'default' ) {
            $image_frm_class = ' img-frame';
            $main_post_class = ' default';
            $col_respons_class = ' default-img-holder';
        }
        $wp_rem_cs_var_image_frame = '';
        $page_element_size = isset($atts['image_frame_element_size']) ? $atts['image_frame_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_image_frame .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) .$col_respons_class. ' ">';
        }
        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        //img-frame classic has-border has-shadow
        $image_frm_class = 'media-holder ' . esc_html($wp_rem_cs_var_img_align) . ' ' . esc_html($wp_rem_cs_var_img_style) . '-image-frame';
        if ( $wp_rem_cs_var_img_style == 'modern' ) {
            $image_frm_class = 'img-frame classic has-border has-shadow';
        }
        $wp_rem_cs_var_image_section_title = isset($wp_rem_cs_var_image_section_title) ? $wp_rem_cs_var_image_section_title : '';
        $wp_rem_cs_var_frame_image_url = isset($wp_rem_cs_var_frame_image_url_array) ? $wp_rem_cs_var_frame_image_url_array : '';
        $wp_rem_cs_var_image_title = isset($wp_rem_cs_var_image_title) ? $wp_rem_cs_var_image_title : '';
        $wp_rem_cs_var_img_align = isset($wp_rem_cs_var_img_align) ? $wp_rem_cs_var_img_align : '';
        $wp_rem_cs_var_img_style = (isset($wp_rem_cs_var_img_style) && $wp_rem_cs_var_img_style != '') ? $wp_rem_cs_var_img_style : 'simple';
        if ( isset($column_class) && $column_class <> '' ) {
            $wp_rem_cs_var_image_frame .= '<div class="' . esc_html($column_class) . '">';
        }
        $wp_rem_cs_var_image_frame .= wp_rem_title_sub_align($wp_rem_cs_var_image_section_title, $wp_rem_cs_var_image_section_subtitle, $wp_rem_var_image_title_align);
        if ( $wp_rem_cs_var_img_style != 'modern' ) {
            $wp_rem_cs_var_image_frame .= '<div class="main-post' . $main_post_class . '">';
        }
        if ( $wp_rem_cs_var_frame_image_url <> '' ) {
            $wp_rem_cs_var_image_frame .= '<div class="' . $image_frm_class . '">'
                    . '<figure><img alt = "' . esc_html($wp_rem_cs_var_image_title) . '" src = "' . esc_url($wp_rem_cs_var_frame_image_url) . '">'
                    . '</figure></div>';
        }
        if ( $content != '' || $wp_rem_cs_var_image_title != '' ) {
            $wp_rem_cs_var_image_frame .= '<div class="cs-text" >';
            if ( $wp_rem_cs_var_image_title && trim($wp_rem_cs_var_image_title) != '' ) {
                $wp_rem_cs_var_image_frame .= '<h4>' . esc_html($wp_rem_cs_var_image_title) . '</h4>';
            }
            if ( $content <> '' ) {
                $wp_rem_cs_var_image_frame .= do_shortcode($content);
            }
            $wp_rem_cs_var_image_frame .= '</div>';
        }
        if ( $wp_rem_cs_var_img_style != 'modern' ) {
            $wp_rem_cs_var_image_frame .= '</div>';
        }
        if ( isset($column_class) && $column_class <> '' ) {
            $wp_rem_cs_var_image_frame .= '</div>';
        }
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_image_frame .= '</div>';
        }
        return $wp_rem_cs_var_image_frame;
    }

    if ( function_exists('wp_rem_cs_var_short_code') )
        wp_rem_cs_var_short_code('wp_rem_cs_image_frame', 'wp_rem_cs_var_image_frame');
}