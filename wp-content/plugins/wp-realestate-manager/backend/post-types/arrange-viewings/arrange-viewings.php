<?php

/**
 * File Type: Reservations Post Type
 */
if (!class_exists('post_type_property_viewings')) {

    class post_type_property_viewings {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('init', array(&$this, 'wp_rem_property_viewings_register'), 12);
            add_filter('manage_property_viewings_posts_columns', array(&$this, 'property_viewings_columns_add'), 10, 1);
            add_action('manage_property_viewings_posts_custom_column', array(&$this, 'property_viewings_columns'), 10, 2);
            add_filter('post_row_actions', array(&$this, 'property_viewings_remove_row_actions'), 11, 2);
            add_action('admin_menu', array($this, 'wp_rem_remove_post_boxes'));
            add_action('do_meta_boxes', array($this, 'wp_rem_remove_post_boxes'));
			// Custom Sort Columns
			add_filter('manage_edit-property_viewings_sortable_columns', array( $this, 'wp_rem_viewings_sortable' ));
			add_filter('request', array( $this, 'wp_rem_viewings_column_orderby' ));
			// Custom Filter
			add_action('restrict_manage_posts', array( $this, 'wp_rem_admin_viewings_filters' ), 11);
			add_filter('parse_query', array( &$this, 'wp_rem_viewings_filter' ), 11, 1);
			// Status change action
			add_filter('wp_ajax_wp_rem_viewing_status_change_bk', array( &$this, 'viewing_status_change_bk' ));
			// Bulk action hook
			add_filter('bulk_actions-edit-property_viewings', array( &$this, 'custom_bulk_actions' ));
			// Remove Default search box
			add_filter('admin_head', array( &$this, 'hide_default_search_box' ));
			// Alter filter posts list
			add_filter('views_edit-property_viewings', array( &$this, 'alter_filter_posts_list' ));
        }

        public function property_viewings_remove_row_actions($actions, $post) {
            if ($post->post_type == 'property_viewings') {
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

        public function property_viewings_columns_add($columns) {
            unset($columns['title']);
            unset($columns['date']);
			unset($columns['validated_is_valid']);
			unset($columns['validated_check']);
            $columns['p_title'] = wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_column_id' );
            $columns['p_date'] = wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_column_date' );
            $columns['property_member'] = wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_column_property_member' );
			$columns['property'] = wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_column_property' );
            $columns['viewing_member'] = wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_column_viewing_member' );
            $columns['status'] = wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_column_status' );
            return $columns;
        }

        public function property_viewings_columns($name) {
            global $post, $orders_inquiries, $wp_rem_plugin_options, $wp_rem_form_fields;
			
			$property_member = get_post_meta($post->ID, 'wp_rem_property_member', true);
			$property_id = get_post_meta($post->ID, 'wp_rem_property_id', true);
			$viewing_member = get_post_meta($post->ID, 'wp_rem_viewing_member', true);

            switch ($name) {
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
                case 'viewing_member':
                    echo '<a href="' . admin_url('post.php?post=' . $viewing_member . '&action=edit') . '">' . get_the_title($viewing_member) . '</a>';
                    break;
                case 'status':
                    $status = get_post_meta($post->ID, 'wp_rem_viewing_status', true);
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
							'extra_atr' => 'onchange="wp_rem_viewing_status_change_bk(this.value, \'' . $post->ID . '\')"',
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
		
		public function wp_rem_viewings_sortable($columns) {
			$columns['p_title'] = 'ID';
			$columns['p_date'] = 'date';
			return $columns;
		}

		public function wp_rem_viewings_column_orderby($vars) {
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

		public function wp_rem_admin_viewings_filters() {
			global $wp_rem_form_fields, $wp_rem_plugin_options, $post_type;

			//only add filter to post type you want
			if ( $post_type == 'property_viewings' ) {

				$orders_statuses = isset($wp_rem_plugin_options['orders_status']) ? $wp_rem_plugin_options['orders_status'] : '';

				if ( ! empty($orders_statuses) ) {
					$enquiry_status_options = array( '' => wp_rem_plugin_text_srt('wp_rem_enquiry_post_status_txt') );
					foreach ( $orders_statuses as $orders_status ) {
						$enquiry_status_options[$orders_status] = $orders_status;
					}
					$enquiry_status = isset($_GET['viewing_status']) ? $_GET['viewing_status'] : '';
					$wp_rem_opt_array = array(
						'std' => $enquiry_status,
						'id' => 'viewing_status',
						'cust_id' => 'viewing_status',
						'cust_name' => 'viewing_status',
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

		function wp_rem_viewings_filter($query) {
			global $pagenow;
			$custom_filter_arr = array();
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_viewings' && isset($_GET['member_name']) && $_GET['member_name'] != '' ) {
				remove_filter('parse_query', array( &$this, 'wp_rem_viewings_filter' ), 11, 1);
				$members_args = array(
					'post_type' => 'members',
					'posts_per_page' => -1,
					's' => $_GET['member_name'],
					'fields' => 'ids',
				);
				$members_ids = get_posts($members_args);
				wp_reset_postdata();
				add_filter('parse_query', array( &$this, 'wp_rem_viewings_filter' ), 11, 1);
				if ( empty($members_ids) ) {
					$members_ids = array( 0 );
				}
				$custom_filter_arr[] = array(
					'key' => 'wp_rem_property_member',
					'value' => $members_ids,
					'compare' => 'IN',
				);
			}
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_viewings' && isset($_GET['property_name']) && $_GET['property_name'] != '' ) {
				remove_filter('parse_query', array( &$this, 'wp_rem_viewings_filter' ), 11, 1);
				$properties_args = array(
					'post_type' => 'properties',
					'posts_per_page' => -1,
					's' => $_GET['property_name'],
					'fields' => 'ids',
				);
				$properties_ids = get_posts($properties_args);
				wp_reset_postdata();
				add_filter('parse_query', array( &$this, 'wp_rem_viewings_filter' ), 11, 1);
				if ( empty($properties_ids) ) {
					$properties_ids = array( 0 );
				}
				$custom_filter_arr[] = array(
					'key' => 'wp_rem_property_id',
					'value' => $properties_ids,
					'compare' => 'IN',
				);
			}
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_viewings' && isset($_GET['viewing_status']) && $_GET['viewing_status'] != '' ) {

				$custom_filter_arr[] = array(
					'key' => 'wp_rem_viewing_status',
					'value' => $_GET['viewing_status'],
					'compare' => '=',
				);
			}
			if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'property_viewings' && ! empty($custom_filter_arr) ) {
				$query->set('meta_query', $custom_filter_arr);
			}
		}
		
		/**
		 * Viewing Status change callback
		 */
		public function viewing_status_change_bk() {
			$viewing_id = isset($_POST['viewing_id']) ? $_POST['viewing_id'] : '';
			$status_val = isset($_POST['status_val']) ? $_POST['status_val'] : '';
			if ( $viewing_id != '' && $status_val != '' ) {
				update_post_meta($viewing_id, 'wp_rem_viewing_status', $status_val);
				$msg = wp_rem_plugin_text_srt('wp_rem_enquiry_post_status_change');
			} else {
				$msg = wp_rem_plugin_text_srt('wp_rem_enquiry_post_there_is_error');
			}
			echo json_encode(array( 'msg' => $msg ));
			die;
		}
		
		function hide_default_search_box() {

			if ( get_post_type() === 'property_viewings' ) {
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
        public function wp_rem_orders_inquiries_init() {
            // Initialize Post Type
            $this->wp_rem_property_viewings_register();
        }

        /**
         * Start Function How to Register post type
         */
        public function wp_rem_property_viewings_register() {
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_name'),
                'singular_name' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_singular_name'),
                'menu_name' => wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings' ),
                'name_admin_bar' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_name_admin_bar'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_add_new'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_add_new_item'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_new_item'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_edit_item'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_view_item'),
                'all_items' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_all_items'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_search_items'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_not_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings_not_found_in_trash'),
            );

            $args = array(
                'labels' => $labels,
                'description' => wp_rem_plugin_text_srt('wp_rem_arrange_viewings'),
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'menu_position' => 25,
                'menu_icon' => wp_rem::plugin_url() . 'assets/backend/images/icon-view.png',
                'query_var' => false,
                'rewrite' => array('slug' => 'property_viewings'),
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'exclude_from_search' => true,
                'supports' => array('title'),
				'capabilities' => array(
					'create_posts' => false,
				),
				'map_meta_cap' => true,
            );

            register_post_type('property_viewings', $args);
        }

        public function wp_rem_remove_post_boxes() {
            remove_meta_box('mymetabox_revslider_0', 'property_viewings', 'normal');
        }
        // End of class	
    }

    // Initialize Object
    $property_viewings = new post_type_property_viewings();
}




// add analytic for order inquiries

add_filter('views_edit-property_viewings', function( $views ) {
    
    $total_viewings = 0;
    $complete_viewings = 0;
    $processing_viewings = 0;
	$closed_viewings = 0;

	$args = array(
		'post_type' => 'property_viewings',
		'posts_per_page' => "1",
		'post_status' => 'publish',
	);
	$total_viewings_query = new WP_Query($args);
	$total_viewings = $total_viewings_query->found_posts;
	
	
	$args = array(
		'post_type' => 'property_viewings',
		'posts_per_page' => "1",
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'wp_rem_viewing_status',
				'value' => 'Completed',
				'compare' => '=',
			),
		),
	);
	$complete_viewings_query = new WP_Query($args);
	$complete_viewings = $complete_viewings_query->found_posts;
	
	$args = array(
		'post_type' => 'property_viewings',
		'posts_per_page' => "1",
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'wp_rem_viewing_status',
				'value' => 'Processing',
				'compare' => '=',
			),
		),
	);
	$processing_viewings_query = new WP_Query($args);
	$processing_viewings = $processing_viewings_query->found_posts;
	
	$args = array(
		'post_type' => 'property_viewings',
		'posts_per_page' => "1",
		'post_status' => 'publish',
		'meta_query' => array(
			array(
				'key' => 'wp_rem_viewing_status',
				'value' => 'Closed',
				'compare' => '=',
			),
		),
	);
	$closed_viewings_query = new WP_Query($args);
	$closed_viewings = $closed_viewings_query->found_posts;
	
	wp_reset_postdata();
    echo '
    <ul class="total-wp-rem-property row">
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_total' ) . '</strong><em>' . $total_viewings . '</em><i class="icon-eye2"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_completed' ) . '</strong><em>' . $complete_viewings . '</em><i class="icon-check_circle"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_processing' ) . '</strong><em>' . $processing_viewings . '</em><i class="icon-refresh3"></i></div></li>
	<li class="col-lg-3 col-md-3 col-sm-6 col-xs-12"><div class="wp-rem-text-holder"><strong>' . wp_rem_plugin_text_srt( 'wp_rem_arrange_viewings_closed' ) . '</strong><em>' . $closed_viewings . '</em><i class="icon-eye-blocked"></i></div></li>    
    </ul>
    ';
    return $views;
});

// End  analytic for order inquiries