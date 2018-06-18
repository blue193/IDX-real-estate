<?php

/**
 * File Type: Property Enquiries Post Type
 */
if ( ! class_exists('post_type_property_enquiries') ) {

	class post_type_property_enquiries {

		/**
		 * Start Contructer Function
		 */
		public function __construct() {
			add_action('init', array( &$this, 'wp_rem_property_enquiries_register' ), 12);
			add_filter('manage_property_enquiries_posts_columns', array( &$this, 'property_enquiries_columns_add' ), 10, 1);
			add_action('manage_property_enquiries_posts_custom_column', array( &$this, 'property_enquiries_columns' ), 10, 2);
			add_filter('post_row_actions', array( &$this, 'property_enquiries_remove_row_actions' ), 11, 2);
			add_action('admin_menu', array( $this, 'wp_rem_remove_post_boxes' ));
			add_action('do_meta_boxes', array( $this, 'wp_rem_remove_post_boxes' ));
			// Custom Sort Columns
			add_filter('manage_edit-property_enquiries_sortable_columns', array( $this, 'wp_rem_enquiries_sortable' ));
			add_filter('request', array( $this, 'wp_rem_enquiries_column_orderby' ));
			// Custom Filter
			add_action('restrict_manage_posts', array( $this, 'wp_rem_admin_enquiries_filters' ), 11);
			add_filter('parse_query', array( &$this, 'wp_rem_enquiries_filter' ), 11, 1);
			// Status change action
			add_filter('wp_ajax_wp_rem_enquiry_status_change_bk', array( &$this, 'enquiry_status_change_bk' ));
			// Bulk action hook
			add_filter('bulk_actions-edit-property_enquiries', array( &$this, 'custom_bulk_actions' ));
			// Remove Default search box
			add_filter('admin_head', array( &$this, 'hide_default_search_box' ));
			// Alter filter posts list
			add_filter('views_edit-property_enquiries', array( &$this, 'alter_filter_posts_list' ));
		}

		public function property_enquiries_remove_row_actions($actions, $post) {
			if ( $post->post_type == 'property_enquiries' ) {
				unset($actions['view']);
				unset($actions['edit']);
			}
			return $actions;
		}

		public function alter_filter_posts_list($views) {
			unset($views['publish']);
			return $views;
		}

		public function custom_bulk_actions($actions) {
			unset($actions['edit']);
			return $actions;
		}

		public function property_enquiries_columns_add($columns) {
			unset($columns['title']);
			unset($columns['date']);
			unset($columns['validated_is_valid']);
			unset($columns['validated_check']);
			$columns['p_title'] = wp_rem_plugin_text_srt('wp_rem_enquiry_id');
			$columns['p_date'] = wp_rem_plugin_text_srt('wp_rem_enquiry_date');
			$columns['property_member'] = wp_rem_plugin_text_srt('wp_rem_enquiry_property_member');
			$columns['property'] = wp_rem_plugin_text_srt('wp_rem_enquiry_property_name');
			$columns['enquiry_member'] = wp_rem_plugin_text_srt('wp_rem_enquiry_enquiry_member');
			$columns['status'] = wp_rem_plugin_text_srt('wp_rem_enquiry_status');
			return $columns;
		}

		public function property_enquiries_columns($name) {
			global $post, $orders_inquiries, $wp_rem_plugin_options, $wp_rem_form_fields;

			$property_member = get_post_meta($post->ID, 'wp_rem_property_member', true);
			$enquiry_member = get_post_meta($post->ID, 'wp_rem_enquiry_member', true);
			$property_id = get_post_meta($post->ID, 'wp_rem_property_id', true);

			switch ( $name ) {
				case 'p_title':
					echo '#' . $post->ID;
					break;
				case 'p_date':
					echo get_the_date();
					break;
				case 'property_member':
					echo '<a href="' . admin_url('post.php?post=' . $property_member . '&action=edit') . '">' . get_the_title($property_member) . '</a>';
					break;
				case 'property':
					echo '<a href="' . admin_url('post.php?post=' . $property_id . '&action=edit') . '">' . get_the_title($property_id) . '</a>';
					break;
				case 'enquiry_member':
					echo '<a href="' . admin_url('post.php?post=' . $enquiry_member . '&action=edit') . '">' . get_the_title($enquiry_member) . '</a>';
					break;
				case 'status':
					$status = get_post_meta($post->ID, 'wp_rem_enquiry_status', true);
					$orders_statuses = isset($wp_rem_plugin_options['orders_status']) ? $wp_rem_plugin_options['orders_status'] : '';

					if ( ! empty($orders_statuses) ) {
						$enquiry_status_options = array();
						foreach ( $orders_statuses as $orders_status ) {
							$enquiry_status_options[$orders_status] = $orders_status;
						}
						$enquiry_status_options['Closed'] = wp_rem_plugin_text_srt('wp_rem_closed');
						
						$wp_rem_opt_array = array(
							'std' => $status,
							'id' => 'enquiry_status',
							'extra_atr' => 'onchange="wp_rem_enquiry_status_change_bk(this.value, \'' . $post->ID . '\')"',
							'classes' => '',
							'options' => $enquiry_status_options,
							'return' => false,
						);
						$wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
						echo '<div id="status-loader-' . $post->ID . '" class="enquiry-status-loader"></div>';
					} else {
						echo '-';
					}
					break;
			}
		}

		public function wp_rem_enquiries_sortable($columns) {
			$columns['p_title'] = 'ID';
			$columns['p_date'] = 'date';
			return $columns;
		}

		public function wp_rem_enquiries_column_orderby($vars) {
			if ( isset($vars['orderby']) && 'p_title' == $vars['orderby'] ) {
				$vars = array_merge($vars, array(
					'orderby' => 'ID',
				));
			}
			if ( isset($vars['orderby']) && 'p_date' == $vars['orderby'] ) {
				$vars = array_merge($vars, array(
					'orderby' => 'date',
				));
			}
			return $vars;
		}

		public function wp_rem_admin_enquiries_filters() {
			global $wp_rem_form_fields, $wp_rem_plugin_options, $post_type;

			//only add filter to post type you want
			if ( $post_type == 'property_enquiries' ) {

				$orders_statuses = isset($wp_rem_plugin_options['orders_status']) ? $wp_rem_plugin_options['orders_status'] : '';

				if ( ! empty($orders_statuses) ) {
					$enquiry_status_options = array( '' => wp_rem_plugin_text_srt('wp_rem_enquiry_post_status_txt') );
					foreach ( $orders_statuses as $orders_status ) {
						$enquiry_status_options[$orders_status] = $orders_status;
					}
					$enquiry_status = isset($_GET['enquiry_status']) ? $_GET['enquiry_status'] : '';
					$wp_rem_opt_array = array(
						'std' => $enquiry_status,
						'id' => 'enquiry_status',
						'cust_id' => 'enquiry_status',
						'cust_name' => 'enquiry_status',
						'extra_atr' => '',
						'classes' => '',
						'options' => $enquiry_status_options,
						'return' => false,
					);
					$wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
				}

				$member_name = isset($_GET['member_name']) ? $_GET['member_name'] : '';
				$wp_rem_opt_array = array(
					'id' => 'member_name',
					'cust_name' => 'member_name',
					'std' => $member_name,
					'classes' => 'filter-member-name',
					'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_enquiry_post_filter_for_member') . '"',
					'return' => false,
					'force_std' => true,
				);
				$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);

				$property_name = isset($_GET['property_name']) ? $_GET['property_name'] : '';
				$wp_rem_opt_array = array(
					'id' => 'property_name',
					'cust_name' => 'property_name',
					'std' => $property_name,
					'classes' => 'filter-property-name',
					'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_enquiry_post_filter_for_Property') . '"',
					'return' => false,
					'force_std' => true,
				);
				$wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
			}
		}

		function wp_rem_enquiries_filter($query) {
			global $pagenow;
			$custom_filter_arr = array();
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_enquiries' && isset($_GET['member_name']) && $_GET['member_name'] != '' ) {
				remove_filter('parse_query', array( &$this, 'wp_rem_enquiries_filter' ), 11, 1);
				$members_args = array(
					'post_type' => 'members',
					'posts_per_page' => -1,
					's' => $_GET['member_name'],
					'fields' => 'ids',
				);
				$members_ids = get_posts($members_args);
				wp_reset_postdata();
				add_filter('parse_query', array( &$this, 'wp_rem_enquiries_filter' ), 11, 1);
				if ( empty($members_ids) ) {
					$members_ids = array( 0 );
				}
				$custom_filter_arr[] = array(
					'key' => 'wp_rem_property_member',
					'value' => $members_ids,
					'compare' => 'IN',
				);
			}
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_enquiries' && isset($_GET['property_name']) && $_GET['property_name'] != '' ) {
				remove_filter('parse_query', array( &$this, 'wp_rem_enquiries_filter' ), 11, 1);
				$properties_args = array(
					'post_type' => 'properties',
					'posts_per_page' => -1,
					's' => $_GET['property_name'],
					'fields' => 'ids',
				);
				$properties_ids = get_posts($properties_args);
				wp_reset_postdata();
				add_filter('parse_query', array( &$this, 'wp_rem_enquiries_filter' ), 11, 1);
				if ( empty($properties_ids) ) {
					$properties_ids = array( 0 );
				}
				$custom_filter_arr[] = array(
					'key' => 'wp_rem_property_id',
					'value' => $properties_ids,
					'compare' => 'IN',
				);
			}
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_enquiries' && isset($_GET['enquiry_status']) && $_GET['enquiry_status'] != '' ) {

				$custom_filter_arr[] = array(
					'key' => 'wp_rem_enquiry_status',
					'value' => $_GET['enquiry_status'],
					'compare' => '=',
				);
			}
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_enquiries' && ! empty($custom_filter_arr) ) {
				$query->set('meta_query', $custom_filter_arr);
			}
		}

		/**
		 * Enquiry Status change callback
		 */
		public function enquiry_status_change_bk() {
			$enquiry_id = isset($_POST['enquiry_id']) ? $_POST['enquiry_id'] : '';
			$status_val = isset($_POST['status_val']) ? $_POST['status_val'] : '';
			if ( $enquiry_id != '' && $status_val != '' ) {
				update_post_meta($enquiry_id, 'wp_rem_enquiry_status', $status_val);
				$msg = wp_rem_plugin_text_srt('wp_rem_enquiry_post_status_change');
			} else {
				$msg = wp_rem_plugin_text_srt('wp_rem_enquiry_post_there_is_error');
			}
			echo json_encode(array( 'msg' => $msg ));
			die;
		}

		function hide_default_search_box() {

			if ( get_post_type() === 'property_enquiries' ) {
				echo '<style type="text/css">
				#posts-filter > p.search-box {
					display: none;
				}
				</style>';
			}
		}

		/**
		 * Start Wp's Initilize action hook Function
		 */
		public function wp_rem_property_enquiries_init() {
			// Initialize Post Type
			$this->wp_rem_property_enquiries_register();
		}

		/**
		 * Start Function How to Register post type
		 */
		public function wp_rem_property_enquiries_register() {
			$labels = array(
				'name' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_name'),
				'singular_name' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_singular_name'),
				'menu_name' => wp_rem_plugin_text_srt('wp_rem_property_enquiries'),
				'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_name_admin_bar'),
				'add_new' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_add_new'),
				'add_new_item' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_add_new_item'),
				'new_item' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_new_item'),
				'edit_item' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_edit_item'),
				'view_item' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_view_item'),
				'all_items' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_all_items'),
				'search_items' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_search_items'),
				'not_found' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_not_found'),
				'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_property_enquiries_not_found_in_trash'),
			);

			$args = array(
				'labels' => $labels,
				'description' => wp_rem_plugin_text_srt('wp_rem_property_enquiries'),
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'menu_position' => 29,
				'menu_icon' => wp_rem::plugin_url() . 'assets/backend/images/icon-enquiries.png',
				'query_var' => false,
				'rewrite' => array( 'slug' => 'property_enquiries' ),
				'capability_type' => 'post',
				'has_archive' => false,
				'hierarchical' => false,
				'exclude_from_search' => true,
				'supports' => array( 'title' ),
				'capabilities' => array(
					'create_posts' => false,
				),
				'map_meta_cap' => true,
			);

			register_post_type('property_enquiries', $args);
		}

		public function wp_rem_remove_post_boxes() {
			remove_meta_box('mymetabox_revslider_0', 'property_enquiries', 'normal');
		}

		// End of class	
	}

	// Initialize Object
	$property_enquiries_object = new post_type_property_enquiries();
}




// add analytic for Properties Enquiries

add_filter('views_edit-property_enquiries', function( $views ) {
	
	$total_enquiries = 0;
	$complete_enquiries = 0;
	$closed_enquiries = 0;
	$processing_enquiries = 0;
	
	$args = array(
		'post_type' => 'property_enquiries',
		'posts_per_page' => "1",
		'post_status' => 'publish',
	);
	$total_enquiries_query = new WP_Query($args);
	$total_enquiries = $total_enquiries_query->found_posts;
	
	
	$args = array(
		'post_type' => 'property_enquiries',
		'posts_per_page' => "1",
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'wp_rem_enquiry_status',
				'value' => 'Completed',
				'compare' => '=',
			),
		),
	);
	$complete_enquiries_query = new WP_Query($args);
	$complete_enquiries = $complete_enquiries_query->found_posts;
	
	$args = array(
		'post_type' => 'property_enquiries',
		'posts_per_page' => "1",
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'wp_rem_enquiry_status',
				'value' => 'Processing',
				'compare' => '=',
			),
		),
	);
	$processing_enquiries_query = new WP_Query($args);
	$processing_enquiries = $processing_enquiries_query->found_posts;
	
	$args = array(
		'post_type' => 'property_enquiries',
		'posts_per_page' => "1",
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'wp_rem_enquiry_status',
				'value' => 'Closed',
				'compare' => '=',
			),
		),
	);
	$closed_enquiries_query = new WP_Query($args);
	$closed_enquiries = $closed_enquiries_query->found_posts;
	
	wp_reset_postdata();
	
	echo '
    <ul class="total-wp-rem-property row">
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_total_enquiries') . '</strong><em>' . $total_enquiries . '</em><i class="icon-question2"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_completed_enquiries') . '</strong><em>' . $complete_enquiries . '</em><i class="icon-check_circle"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_processing_enquiries') . '</strong><em>' . $processing_enquiries . '</em><i class="icon-refresh3"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt('wp_rem_closed_enquiries') . '</strong><em>' . $closed_enquiries . '</em><i class="icon-close"></i></div></li>    
    </ul>
    ';
	return $views;
});

// End  analytic for order inquiries