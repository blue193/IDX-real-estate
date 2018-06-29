<?php

/**
 * File Type: Price Tables Post Type
 */
if (!class_exists('post_type_price_tables')) {

    class post_type_price_tables {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('init', array(&$this, 'wp_rem_price_tables_register'), 12);
            add_filter('manage_price_tables_posts_columns', array($this, 'price_tables_cpt_columns'));
            add_action('manage_price_tables_posts_custom_column', array($this, 'custom_price_tables_column'), 10, 2);
            add_shortcode('wp_rem_price_table', array($this, 'wp_rem_price_table_shortcode_function'));
            add_action('admin_menu', array($this, 'wp_rem_remove_post_boxes'));
            add_action('do_meta_boxes', array($this, 'wp_rem_remove_post_boxes'));
        }

        /**
         * Start Wp's Initilize action hook Function
         */
        public function wp_rem_price_tables_init() {
            // Initialize Post Type
            $this->wp_rem_price_tables_register();
        }

        /**
         * Start Function How to Register post type
         */
        public function wp_rem_price_tables_register() {
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_name'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_singular_name'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_menu_name'),
                'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_name_admin_bar'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_add_new'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_add_new_item'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_new_item'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_edit_item'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_view_item'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_all_items'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_search_items'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_not_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_post_type_price_table_not_found_in_trash'),
            );

            $args = array(
                'labels' => $labels,
                'description' => wp_rem_plugin_text_srt('wp_rem_price_tables'),
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => 'edit.php?post_type=packages',
                'query_var' => false,
                'rewrite' => array('slug' => 'wp-rem-pt'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'exclude_from_search' => true,
                'supports' => array('title')
            );

            register_post_type('wp-rem-pt', $args);
        }

        /*
         * add custom column to to row
         */

        public function price_tables_cpt_columns($columns) {

            $new_columns = array();
            return array_merge($columns, $new_columns);
        }

        /*
         * add column values for each row
         */

        public function custom_price_tables_column($column) {
            switch ($column) {
                
            }
        }

        public function wp_rem_remove_post_boxes() {
            remove_meta_box('mymetabox_revslider_0', 'wp-rem-pt', 'normal');
        }
        // End of class	
    }

    // Initialize Object
    $price_tables_object = new post_type_price_tables();
}
