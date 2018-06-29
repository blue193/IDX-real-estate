<?php

/**
 * File Type: Packages Post Type
 */
if (!class_exists('post_type_packages')) {

    class post_type_packages {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('init', array(&$this, 'wp_rem_packages_register'), 12);
            add_filter('manage_packages_posts_columns', array($this, 'packages_cpt_columns'));
            add_action('manage_packages_posts_custom_column', array($this, 'custom_packages_column'), 10, 2);
            add_shortcode('wp_rem_package', array($this, 'wp_rem_package_shortcode_function'));
            add_action('admin_head', array($this, 'title_moving_callback'));
            add_action('admin_menu', array($this, 'remove_post_boxes'));
            add_action('do_meta_boxes', array($this, 'remove_post_boxes'));
			add_filter( 'manage_edit-packages_sortable_columns', array($this, 'wp_rem_packages_sortable'));
			add_filter( 'request', array($this, 'wp_rem_packages_column_orderby'));
        }
		
		/**
         * Start Wp's Initilize action hook Function
         */
        public function wp_rem_packages_init() {
            // Initialize Post Type
            $this->wp_rem_packages_register();
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
			<style type="text/css">
				.post-type-packages .column-title.column-primary { width:300px !important; overflow:hidden }
				.post-type-packages .column-package_type { width:120px !important; overflow:hidden }
				.post-type-packages .column-package_price { width:120px !important; overflow:hidden }
				.post-type-packages .column-package_duration { width:200px !important; overflow:hidden }
				.post-type-packages .column-num_of_properties { width:200px !important; overflow:hidden }
				.post-type-packages .column-property_duration { width:200px !important; overflow:hidden }
			</style>
            <?php
		}

        /**
         * Start Function How to Register post type
         */
        public function wp_rem_packages_register() {
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_post_type_package_name'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_post_type_package_singular_name'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_post_type_package_menu_name'),
                'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_post_type_package_name_admin_bar'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_post_type_package_add_new'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_post_type_package_add_new_item'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_post_type_package_new_item'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_post_type_package_edit_item'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_post_type_package_view_item'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_post_type_package_all_items'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_post_type_package_search_items'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_post_type_package_not_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_post_type_package_not_found_in_trash'),
            );

            $args = array(
                'labels' => $labels,
                'description' => wp_rem_plugin_text_srt('wp_rem_packages'),
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'menu_position' => 33,
                'menu_icon' => wp_rem::plugin_url() . 'assets/backend/images/tool.png',
                'query_var' => false,
                'rewrite' => array('slug' => 'packages'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'exclude_from_search' => true
            );

            register_post_type('packages', $args);
        }

        /*
         * add custom column to to row
         */

        public function packages_cpt_columns($columns) {

            $new_columns = array(
			'package_type' => wp_rem_plugin_text_srt( 'wp_rem_packages_type' ),
			'package_price' => wp_rem_plugin_text_srt( 'wp_rem_package_price' ),
			'package_duration' => wp_rem_plugin_text_srt( 'wp_rem_property_packages_duration' ),
			'num_of_properties' => wp_rem_plugin_text_srt( 'wp_rem_property_packages_num_property_allowed' ),
			'property_duration' => wp_rem_plugin_text_srt( 'wp_rem_property_packages_property_duration' ),
            'shortcode' => wp_rem_plugin_text_srt( 'wp_rem_packages_purchase_button' ),
            );
            return array_merge($columns, $new_columns);
        }

        /*
         * add column values for each row
         */

        public function custom_packages_column($column) {
			global $post;
			$package_data = get_post_meta($post->ID, 'wp_rem_package_data', true);
            switch ($column) {
				case 'package_type' :
					echo ucfirst(get_post_meta( $post->ID, 'wp_rem_package_type', true ));
                break;
				case 'package_price' :
                    echo get_post_meta( $post->ID, 'wp_rem_package_price', true );
                break;
				case 'package_duration' :
                    echo (isset($package_data['duration']['value']) && $package_data['duration']['value'] != '') ? $package_data['duration']['value'] : '-';
                break;
				case 'num_of_properties' :
                    echo (isset($package_data['number_of_property_allowed']['value']) && $package_data['number_of_property_allowed']['value'] != '') ? $package_data['number_of_property_allowed']['value'] : '-';
                break;
				case 'property_duration' :
                    echo (isset($package_data['property_duration']['value']) && $package_data['property_duration']['value'] != '' ) ? $package_data['property_duration']['value'] : '-';
                break;
				case 'shortcode' :
                    $post_id = get_the_id();
                    $column_shortcode = '[wp_rem_package package_id="' . $post_id . '"]';
                    echo force_balance_tags($column_shortcode);
				break;
            }
        }
		
		public function wp_rem_packages_column_orderby(  $vars ){
			if ( isset( $vars['orderby'] ) && 'package_type' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'wp_rem_package_type',
					'orderby' => 'meta_value',
				) );
				
			}
			if ( isset( $vars['orderby'] ) && 'package_price' == $vars['orderby'] ) {
				$vars = array_merge( $vars, array(
					'meta_key' => 'wp_rem_package_price',
					'orderby' => 'meta_value_num',
				) );
				
			}
			if ( isset( $vars['orderby'] ) && ('package_duration' == $vars['orderby'] || 'num_of_properties' == $vars['orderby'] || 'property_duration' == $vars['orderby']) ) {
				if( 'package_duration' == $vars['orderby'] ){
					$key_name = 'duration';
				}else if('num_of_properties' == $vars['orderby']){
					$key_name = 'number_of_property_allowed';
				}else{
					$key_name = 'property_duration';
				}
				
				$args = array(
					'post_type' => 'packages',
					'post_status' => 'publish',
					'posts_per_page' => -1,
					'fields' => 'ids',
				);
				$packages = get_posts( $args );
				
				$packages_ids = array();
				if( !empty($packages) ){
					$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
					foreach( $packages as $package ){
						$package_data = get_post_meta($package, 'wp_rem_package_data', true);
						$pkg_sort_field_val = isset($package_data[$key_name]['value']) ? $package_data[$key_name]['value'] : 0;
						$found_val_packages_ids[$package] = $pkg_sort_field_val;
						
					}
					if( $order == 'asc' ){
						asort($found_val_packages_ids);
					}elseif($order == 'desc'){
						arsort($found_val_packages_ids);
					}
					if( !empty($found_val_packages_ids)){
						foreach( $found_val_packages_ids as $key => $found_val_packages_id ){
							$packages_ids[] = $key;
						}
					}
				}
				if( !empty($packages_ids)){
					$vars = array_merge( $vars, array(
						'post__in' => $packages_ids,
						'orderby' => 'post__in',
					) );
				}
				
			}
			return $vars;
		}
		public function wp_rem_packages_sortable( $columns ){
			$columns['package_type'] = 'package_type';
			$columns['package_price'] = 'package_price';
			$columns['package_duration'] = 'package_duration';
			$columns['num_of_properties'] = 'num_of_properties';
			$columns['property_duration'] = 'property_duration';
			return $columns;
		}

        public function wp_rem_package_shortcode_function($atts) {
            global $wp_rem_html_fields_frontend, $wp_rem_plugin_options, $current_user;
            $single_package_dashboard = isset($wp_rem_plugin_options['wp_rem_package_page']) ? $wp_rem_plugin_options['wp_rem_package_page'] : '';
            $page_link = get_the_permalink($single_package_dashboard);
            $atts = shortcode_atts(
                    array(
                'package_id' => ' ',
                    ), $atts, 'wp_rem_package');
            $package_id = $atts['package_id'];
            $output = '';
            $rand_numb = rand(1000000, 99999999);
            if (isset($_POST['wp_rem_package_buy']) && $_POST['wp_rem_package_buy'] == '1') {
                $package_id = isset($_POST['package_id']) ? $_POST['package_id'] : 0;


                if (is_user_logged_in() && current_user_can('wp_rem_member')) {



                    $form_rand_numb = isset($_POST['wp_rem_package_random']) ? $_POST['wp_rem_package_random'] : '';
                    $form_rand_transient = get_transient('wp_rem_package_random');

                    if ($form_rand_transient != $form_rand_numb) {

                        $wp_rem_property_obj = new wp_rem_member_property_actions();
                        $company_id = wp_rem_company_id_form_user_id($current_user->ID);

                        set_transient('wp_rem_package_random', $form_rand_numb, 60 * 60 * 24 * 30);

                        $wp_rem_property_obj->wp_rem_property_add_transaction('buy_package', 0, $package_id, $company_id);
                    }
                }
            }
            if (is_user_logged_in() && current_user_can('wp_rem_member')) {
                if (true === Wp_rem_Member_Permissions::check_permissions('packages')) {
                    $output .= '
                    <form method="post">
                        <input type="hidden" name="wp_rem_package_buy" value="1" />
                        <input type="hidden" name="wp_rem_package_random" value="' . absint($rand_numb) . '" />
                        <input type="hidden" name="package_id" value="' . absint($package_id) . '" />
                        <div class="wp-rem-subscribe-pkg-btn">
							<div class="buy-btn-' . absint($rand_numb) . ' input-button-loader" data-id="' . absint($rand_numb) . '">
								<input class="buy-btn" type="submit"  value="' . wp_rem_plugin_text_srt( 'wp_rem_packages_buy_now' ) . '">
							</div>
							<i class="icon-controller-play"></i>
                        </div>
                    </form>';
                }
            } else if (is_user_logged_in() && !current_user_can('wp_rem_member')) {
                $output .= '<a data-id="' . absint($rand_numb) . '" href="javascript:void(0);" class="wp-rem-subscribe-pkg text-color">' . wp_rem_plugin_text_srt( 'wp_rem_packages_buy_now' ) . '<i class="icon-controller-play"></i></a>';
            } else if (!is_user_logged_in()) {
                $output .= '<a href="#" data-target="#sign-in" data-msg="' . wp_rem_plugin_text_srt( 'wp_rem_packages_login_first' ) . '" data-toggle="modal" class="wp-rem-open-signin-tab wp-rem-subscribe-pkg text-color">' . wp_rem_plugin_text_srt( 'wp_rem_packages_buy_now' ) . '<i class="icon-controller-play"></i></a>';
            }
            $output .= '<div id="response-' . $rand_numb . '" class="response-holder" style="display: none;">
					<div class="alert alert-warning fade in">' . wp_rem_plugin_text_srt( 'wp_rem_packages_become_member' ) . '</div>
				</div>';
            return $output;
        }

        public function assing_page_temp_by_id() {
            global $wp_rem_plugin_options;
            $package_detail_page = isset($wp_rem_plugin_options['wp_rem_package_page']) ? $wp_rem_plugin_options['wp_rem_package_page'] : '';
            if (-1 != $package_detail_page) {

                update_post_meta($package_detail_page, '_wp_page_template', 'packages-template.php');
            }
        }

        function remove_post_boxes() {
            remove_meta_box('mymetabox_revslider_0', 'packages', 'normal');
        }

        // End of class	
    }

    // Initialize Object
    $packages_object = new post_type_packages();
    $packages_object->assing_page_temp_by_id();
}


if (!function_exists('wp_rem_packages_remove_help_tabs')) {

    add_action('admin_head', 'wp_rem_packages_remove_help_tabs');

    function wp_rem_packages_remove_help_tabs() {
        $screen = get_current_screen();
        if (isset($screen->post_type) && $screen->post_type == 'packages') {
            add_filter('screen_options_show_screen', '__return_false');
            add_filter('bulk_actions-edit-packages', '__return_empty_array');
            echo '<style type="text/css">
			.post-type-packages .tablenav.bottom,
			.post-type-packages .tablenav.top,
			.post-type-packages .subsubsub,
			.post-type-packages .search-box,
			.post-type-packages .hide-if-no-js,
			.post-type-packages #postdivrich{
			display: none;
			}
		</style>';
        }
    }

}

if (!function_exists('wp_rem_package_columns')) {

    function wp_rem_package_columns($columns) {
        unset(
        $columns['date'], $columns['cb']
        );

        return $columns;
    }

    add_filter('manage_packages_posts_columns', 'wp_rem_package_columns');
}

if (!function_exists('wp_rem_hide_publishing_actions')) {

    function wp_rem_hide_publishing_actions() {
        $my_post_type = 'packages';
        global $post;
        if ($post->post_type == 'packages') {
            echo '
                <style type="text/css">
		    #misc-publishing-actions,
                    #minor-publishing-actions{
                        display:none;
                    }
		    
                </style>
            ';
        }
    }

    add_action('admin_head-post.php', 'wp_rem_hide_publishing_actions');
    add_action('admin_head-post-new.php', 'wp_rem_hide_publishing_actions');
}