<?php

/*
 *
 * @Shortcode Name :  tabs front end view
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_tabs_shortcode')) {


    function wp_rem_cs_var_tabs_shortcode($atts, $content = "") {

        global $post, $wp_rem_cs_var_tabs_column;
        global $tabs_content;
        $tabs_content = '';
        $defaults = array(
            'wp_rem_cs_var_element_title' => '',
            'wp_rem_cs_var_element_subtitle' => '',
            'wp_rem_var_tabs_align' => '',
            'wp_rem_cs_var_tabs_view' => '',
        );

        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_element_title = isset($wp_rem_cs_var_element_title) ? $wp_rem_cs_var_element_title : '';
        $wp_rem_cs_var_tabs_view = isset($wp_rem_cs_var_tabs_view) ? $wp_rem_cs_var_tabs_view : '';
        $html = '';
        $wp_rem_cs_section_title = '';
        $wp_rem_cs_section_sub_title = '';
        $page_element_size = isset($atts['tabs_element_size']) ? $atts['tabs_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $wp_rem_cs_section_title = wp_rem_title_sub_align($wp_rem_cs_var_element_title, $wp_rem_cs_var_element_subtitle, $wp_rem_var_tabs_align);
        $html .= $wp_rem_cs_section_title;
        if ($wp_rem_cs_var_tabs_view == "horizontal") {
            $html .= "<div class='cs-tabs full-width horizontal-tabs'>";
        } else {
            $html .= "<div class='cs-faq-tabs vertical-tabs'>";
        }
        $html .= '  <ul class="nav nav-tabs" role="tablist">';
        $html .= do_shortcode($content);
        $html .= '</ul>';
        $html .= '<div class="tab-content">';
        $html .= wp_rem_cs_allow_special_char($tabs_content);
        $html .= '</div>';
        $html .= '</div>';
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html .= '</div>';
        }


        return do_shortcode($html);
    }

    if (function_exists('wp_rem_cs_var_short_code')) {
        wp_rem_cs_var_short_code('tabs', 'wp_rem_cs_var_tabs_shortcode');
    }
}


/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_tabs_item_shortcode')) {

    function wp_rem_cs_var_tabs_item_shortcode($atts, $content = "") {
        global $post, $wp_rem_cs_var_tabs_column, $tabs_content;
        $output = '';
        global $tabs_content;
        $defaults = array(
            'wp_rem_cs_var_tabs_title' => '',
            'wp_rem_cs_var_tabs_icon' => '',
            'wp_rem_cs_var_tabs_icon_group' => 'default',
            'wp_rem_cs_var_tab_active' => ''
        );
        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_tabs_column_str = '';
        if ($wp_rem_cs_var_tabs_column != 12) {
            $wp_rem_cs_var_tabs_column_str = 'class = "col-md-' . esc_html($wp_rem_cs_var_tabs_column) . '"';
        }
        $wp_rem_cs_var_tabs_title = isset($wp_rem_cs_var_tabs_title) ? $wp_rem_cs_var_tabs_title : '';
        $wp_rem_cs_var_tabs_color = isset($wp_rem_cs_var_tabs_color) ? $wp_rem_cs_var_tabs_color : '';
        $wp_rem_cs_var_tabs_icon = isset($wp_rem_cs_var_tabs_icon) ? $wp_rem_cs_var_tabs_icon : '';
        $wp_rem_cs_var_tab_active = isset($wp_rem_cs_var_tab_active) ? $wp_rem_cs_var_tab_active : '';

        $activeClass = "";
        if ($wp_rem_cs_var_tab_active == 'yes') {
            $activeClass = 'active in';
        }

        $fa_icon = '';
        if ($wp_rem_cs_var_tabs_icon) {
            wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_tabs_icon_group );
            $fa_icon = '<i class="' . sanitize_html_class($wp_rem_cs_var_tabs_icon) . '"></i>  ';
        }
        $randid = rand(877, 9999);
        $output .= '<li  class="' . ($activeClass) . '"><a data-toggle="tab" href="#cs-tab-' . sanitize_title($wp_rem_cs_var_tabs_title) . $randid . '"  aria-expanded="true">' . wp_rem_cs_allow_special_char($fa_icon) . wp_rem_cs_allow_special_char($wp_rem_cs_var_tabs_title) . '</a></li>';
        $tabs_content .= '<div id="cs-tab-' . sanitize_title($wp_rem_cs_var_tabs_title) . $randid . '" class="tab-pane fade ' . wp_rem_cs_allow_special_char($activeClass) . '">';
        $tabs_content .= do_shortcode($content);
        $tabs_content .= '</div>';

        return do_shortcode($output);
    }

    if (function_exists('wp_rem_cs_var_short_code')) {
        wp_rem_cs_var_short_code('tabs_item', 'wp_rem_cs_var_tabs_item_shortcode');
    }
}