<?php
/*
 *
 * @Shortcode Name : Gallery
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_gallery_shortcode') ) {

    function wp_rem_cs_gallery_shortcode($atts, $content = "") {
        global $acc_counter, $wp_rem_cs_var_gallery_view,$acc_counter;
        $acc_counter = rand(40, 9999999);
        $html = '';
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_gallery_main_title' => '',
            'wp_rem_cs_var_gallery_main_subtitle' => '',
            'wp_rem_var_gallery_align' => '',
            'wp_rem_cs_var_gallery_magin_right' => '',
            'wp_rem_cs_var_gallery_magin_left' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $column_class = '';
        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_gallery_main_title = isset($wp_rem_cs_var_gallery_main_title) ? $wp_rem_cs_var_gallery_main_title : '';
        $wp_rem_cs_var_gallery_main_subtitle = isset($wp_rem_cs_var_gallery_main_subtitle) ? $wp_rem_cs_var_gallery_main_subtitle : '';
        $wp_rem_var_gallery_align = isset($wp_rem_var_gallery_align) ? $wp_rem_var_gallery_align : '';
        $wp_rem_cs_var_gallery_magin_right = isset($wp_rem_cs_var_gallery_magin_right) ? $wp_rem_cs_var_gallery_magin_right : '';
        $wp_rem_cs_var_gallery_magin_left = isset($wp_rem_cs_var_gallery_magin_left) ? $wp_rem_cs_var_gallery_magin_left : '';
        $margin_str = '';
        $margin_strr = '';
        if (isset($wp_rem_cs_var_gallery_magin_left) && !empty($wp_rem_cs_var_gallery_magin_left) ) {
            $margin_str .= 'margin-left:' . $wp_rem_cs_var_gallery_magin_left . 'px;';
        }
        if (isset($wp_rem_cs_var_gallery_magin_right) && !empty($wp_rem_cs_var_gallery_magin_right) ) {
            $margin_str .= 'margin-right:' . $wp_rem_cs_var_gallery_magin_right . 'px;';
        }
        if ($margin_str != '') {
            $margin_strr = 'style="' . $margin_str . '"';
        }
        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }
        $html .= wp_rem_title_sub_align($wp_rem_cs_var_gallery_main_title, $wp_rem_cs_var_gallery_main_subtitle, $wp_rem_var_gallery_align);
        wp_enqueue_style('wp-rem-prettyPhoto');
        wp_enqueue_script('wp-rem-lightbox');
        wp_enqueue_script('wp-rem-prettyPhoto');
	wp_rem_gallery_masonry();
        $html .= '<div ' . $margin_strr . ' class="rem-gallery">';
        $html .= '<ul class="gallery">';
        $html .= do_shortcode($content);
        $html .= '</ul>';
        $html .= '</div>';
        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '</div>';
        }
        $page_element_size = isset($atts['gallery_element_size']) ? $atts['gallery_element_size'] : 100;
        return '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">' . do_shortcode($html) . '</div>';
    }
    if ( function_exists('wp_rem_cs_short_code') ) {
        wp_rem_cs_short_code('wp_rem_cs_gallery', 'wp_rem_cs_gallery_shortcode');
    }
}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('wp_rem_cs_gallery', 'wp_rem_cs_gallery_shortcode');
/*
 *
 * @Shortcode item : Gallery
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_gallery_item_shortcode') ) {

    function wp_rem_cs_gallery_item_shortcode($atts, $content = "") {
        global $acc_counter, $wp_rem_cs_var_gallery_view;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $defaults = array(
            'wp_rem_cs_var_galler_img_size' => '',
            'wp_rem_cs_var_gallery_image' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $randomid = rand(0, 999);
        $wp_rem_cs_var_acc_icon = '';
        $wp_rem_cs_var_galler_img_size = isset($wp_rem_cs_var_galler_img_size) ? $wp_rem_cs_var_galler_img_size : '';
        $wp_rem_cs_var_gallery_image = isset($wp_rem_cs_var_gallery_image) ? $wp_rem_cs_var_gallery_image : '';
        $html = '';
        if ( isset($wp_rem_cs_var_icon_box) && $wp_rem_cs_var_icon_box != '' ) {
            $wp_rem_cs_var_acc_icon .= '<i class="' . esc_html($wp_rem_cs_var_icon_box) . '"></i>';
        }
        $html .= '<li class="' . esc_html($wp_rem_cs_var_galler_img_size) . '">'
                . '<a href="' . esc_url($wp_rem_cs_var_gallery_image) . '" rel="prettyPhoto['.$acc_counter.']">'
                . '<figure><img src="' . esc_url($wp_rem_cs_var_gallery_image) . '" alt=""/><figcaption><i class="icon-plus3"></i> </figcaption></figure>'
                . '</a>'
                . '</li>';
       
        return $html;
    }
    if ( function_exists('wp_rem_cs_short_code') ) {
        wp_rem_cs_short_code('gallery_item', 'wp_rem_cs_gallery_item_shortcode');
    }
}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('gallery_item', 'wp_rem_cs_gallery_item_shortcode');
