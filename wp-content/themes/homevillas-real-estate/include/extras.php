<?php

/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wp_rem_cs
 */
/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if ( ! function_exists('wp_rem_cs_body_classes') ) {

    function wp_rem_cs_body_classes($classes) {
        global $wp_rem_cs_var_options;
        // Adds a class of group-blog to blogs with more than 1 published author.
        if ( is_multi_author() ) {
            $classes[] = 'group-blog';
        }
        if ( is_page() ) {
            $page_id = get_the_ID();
            $page_footrer_hidden = get_post_meta($page_id, 'wp_rem_cs_var_page_footer_hidden', true);
            $page_footrer_hidden = isset($page_footrer_hidden) ? $page_footrer_hidden : '';
            if ( isset($page_footrer_hidden) && $page_footrer_hidden == 'on' ) {
               $classes[] = 'wp-rem-footer-hidden';
            }
            
            $page_header_hidden = get_post_meta($page_id, 'wp_rem_cs_var_page_header_hidden', true);
            $page_header_hidden = isset($page_header_hidden) ? $page_header_hidden : '';
            if ( isset($page_header_hidden) && $page_header_hidden == 'on' ) {
               $classes[] = 'wp-rem-header-hidden';
            }
        }
        // Adds a class of hfeed to non-singular pages.
        if ( ! is_singular() ) {
            $classes[] = 'hfeed';
        }
        if ( ! get_option('wp_rem_cs_var_options') ) {
            $classes[] = 'cs-blog-unit';
        }
        return $classes;
    }

    add_filter('body_class', 'wp_rem_cs_body_classes');
}