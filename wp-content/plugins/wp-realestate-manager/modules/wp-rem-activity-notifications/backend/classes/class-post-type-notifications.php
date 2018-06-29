<?php

/**
 * File Type: Notifications Post Type
 */
if ( ! class_exists('Wp_rem_Post_Type_Notifications') ) {

    class Wp_rem_Post_Type_Notifications {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('init', array( &$this, 'wp_rem_activity_notifications_register' ));
            add_action('post_row_actions', array( $this, 'post_row_actions_callback' ), 10, 2);
            add_filter('bulk_actions-edit-notifications', array( $this, 'bulk_actions_callback' )); // Custom columns
            add_filter('manage_notifications_posts_columns', array( $this, 'custom_columns_callback' ), 10, 1);
            add_action('manage_notifications_posts_custom_column', array( $this, 'manage_posts_custom_column_callback' ), 10, 1);
        }

        /**
         * Add new columns to notifications backend property.
         *
         * @param	array	$columns
         * @return	array
         */
        public function custom_columns_callback($columns) {
			$new_columns = array();
			foreach($columns as $key => $value) {
				$new_columns[$key] = $value;
				if( $key == 'title' ){
					$new_columns['notification_message'] = wp_rem_plugin_text_srt('wp_rem_activity_notification_message');
				}
			}
			return $new_columns;
        }

        /**
         * Output data for custom columns.
         *
         * @param	string	$column_name
         */
        public function manage_posts_custom_column_callback($column_name) {
            global $post;
            switch ( $column_name ) {
                case 'notification_message':
                    echo get_the_content($post->ID);
                    break;
            }
        }

        /**
         * Remove Trash option from bulk dropdown
         */
        public function bulk_actions_callback($actions) {
            unset($actions['trash']);
            unset($actions['edit']);
            return $actions;
        }

        /**
         * Delete Notifications Permanently
         */
        public function post_row_actions_callback($actions, $post) {

            if ( $post->post_type == "notifications" ) {
                unset($actions['trash']);
                unset($actions['view']);
                unset($actions['edit']);
                $post_type_object = get_post_type_object($post->post_type);
                $actions['trash'] = "<a class='submitdelete' title='" . wp_rem_plugin_text_srt('wp_rem_notifications_delete_permanently') . "' href='" . get_delete_post_link($post->ID, '', true) . "'>" . wp_rem_plugin_text_srt('wp_rem_notifications_row_delete') . "</a>";
            }
            return $actions;
        }

        /**
         * Start Function How to Register post type
         */
        public function wp_rem_activity_notifications_register() {

            $labels = array(
                'name' =>  wp_rem_plugin_text_srt('wp_rem_post_type_notification_name'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_post_type_notification_singular_name'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_post_type_notification_not_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_post_type_notification_not_found_in_trash'),
            );

            $args = array(
                'labels' => $labels,
                'description' => wp_rem_plugin_text_srt('wp_rem_activity_notifications'),
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true, // Hidden post type it is not being displayed in admin.
                'query_var' => false,
                'menu_icon' => wp_rem::plugin_url() . 'assets/backend/images/icon-notifications-active.png',
                'rewrite' => array( 'slug' => 'notifications' ),
                'capability_type' => 'post',
                'has_archive' => false,
				'capabilities' => array(
					'create_posts' => false,
				),
                'hierarchical' => false,
				'menu_position' => 29,
                'exclude_from_search' => true,
            );

            register_post_type('notifications', $args);
		}

        // End of class	
    }

    // Initialize Object
    $wp_rem_activity_notifications_object = new Wp_rem_Post_Type_Notifications();
}