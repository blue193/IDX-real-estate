<?php

/**
 * File Type: Branches Post Type
 */
if (!class_exists('post_type_branches')) {

    class post_type_branches {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('init', array($this, 'wp_rem_branches_register'), 12);
            add_action('admin_head', array($this, 'title_moving_callback'));
            add_action('admin_menu', array($this, 'remove_post_boxes'));
            add_action('do_meta_boxes', array($this, 'remove_post_boxes'));
        }

        /**
         * Start Moving package title in metabox
         */
        function title_moving_callback() {
            ?>
            <script type="text/javascript">
                (function ($) {
                    $(document).ready(function () {
                        $('#wp_rem_title_move').append($('#titlediv'));
                    });

                })(jQuery);
            </script>
            <?php

        }

        /**
         * Start Function How to Register post type
         */
        public function wp_rem_branches_register() {
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_name'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_singular_name'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_menu_name'),
                'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_name_admin_bar'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_add_new'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_add_new_item'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_new_item'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_edit_item'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_view_item'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_all_items'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_search_items'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_not_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_post_type_branch_not_found_in_trash'),
            );

            $args = array(
                'labels' => $labels,
                'description' => wp_rem_plugin_text_srt('wp_rem_branches'),
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => false,
                'menu_position' => 29,
                'menu_icon' => wp_rem::plugin_url() . 'assets/backend/images/tool.png',
                'query_var' => false,
                'rewrite' => array('slug' => 'branches'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'exclude_from_search' => true
            );

            register_post_type('branches', $args);
        }

        function remove_post_boxes() {
            remove_meta_box('mymetabox_revslider_0', 'branches', 'normal');
        }
	}

    // Initialize Object
    $branches_object = new post_type_branches();
    
}


if (!function_exists('wp_rem_branches_remove_help_tabs')) {
	add_action('admin_head', 'wp_rem_branches_remove_help_tabs');
	function wp_rem_branches_remove_help_tabs() {
        $screen = get_current_screen();
        if (isset($screen->post_type) && $screen->post_type == 'branches') {
            add_filter('screen_options_show_screen', '__return_false');
            add_filter('bulk_actions-edit-branches', '__return_empty_array');
            echo '<style type="text/css">
			.post-type-branches #titlediv,
			.post-type-branches .tablenav.bottom,
			.post-type-branches .tablenav.top,
			.post-type-branches .subsubsub,
			.post-type-branches .search-box,
			.post-type-branches .hide-if-no-js,
			.post-type-branches #postdivrich{
			 display: none;
			}
		</style>';
        }
    }
}