<?php

/*
 * Homevillas Add Property
 * Shortcode
 * @retrun markup
 */

if (!function_exists('wp_rem_add_property_shortcode')) {

    function wp_rem_add_property_shortcode($atts, $content = "") {
        $defaults = array('property_title' => '', 'title_align' => '',);

        extract(shortcode_atts($defaults, $atts));
        $html = '';

        ob_start();
        $page_element_size = isset($atts['wp_rem_add_property_element_size']) ? $atts['wp_rem_add_property_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ' . $title_align . '">';
        }
        $property_add_settings = array(
            'return_html' => false,
        );
        if (is_user_logged_in() && current_user_can('wp_rem_member')) {
            do_action('wp_rem_property_add', $property_add_settings);
        } else if (!is_user_logged_in()) {
            do_action('wp_rem_property_add', $property_add_settings);
        } else {
            echo wp_rem_plugin_text_srt('wp_rem_add_property_not_authorized');
        }
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            echo '</div>';
        }
        $html .= ob_get_clean();

        return $html;
    }

    add_shortcode('wp_rem_add_property', 'wp_rem_add_property_shortcode');
}