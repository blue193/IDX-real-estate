<?php

// Package Orders start
// Adding columns start

/**
 * Start Function  how to Create colume in transactions 
 */
if (!function_exists('package_orders_columns_add')) {
    add_filter('manage_package-orders_posts_columns', 'package_orders_columns_add');

    function package_orders_columns_add($columns) {
		$new_columns = array();
		foreach($columns as $key => $value) {
			$new_columns[$key] = $value;
			if( $key == 'title' ){
				$new_columns[$key] = wp_rem_plugin_text_srt( 'wp_rem_package_id' );
			}
			if( $key == 'date' ){
				$new_columns[$key] = wp_rem_plugin_text_srt( 'wp_rem_package_date' );
				$new_columns['users'] = wp_rem_plugin_text_srt( 'wp_rem_package_member' );
				$new_columns['package'] = wp_rem_plugin_text_srt( 'wp_rem_package_name' );
				$new_columns['amount'] = wp_rem_plugin_text_srt( 'wp_rem_package_amount' );
			}
		}
		return $new_columns;
        
    }

}

/**
 * Start Function  how to Show data in columns
 */
if (!function_exists('package_orders_columns')) {
    add_action('manage_package-orders_posts_custom_column', 'package_orders_columns', 10, 2);

    function package_orders_columns($name) {
        global $post, $gateways, $wp_rem_plugin_options;
        $general_settings = new WP_REM_PAYMENTS();
        $currency_sign = wp_rem_get_currency_sign();
        $transaction_user = get_post_meta($post->ID, 'wp_rem_transaction_user', true);
        $transaction_amount = get_post_meta($post->ID, 'wp_rem_transaction_amount', true);
        $transaction_fee = get_post_meta($post->ID, 'transaction_fee', true);
        $transaction_status = get_post_meta($post->ID, 'wp_rem_transaction_status', true);

        // return payment gateway name
        switch ($name) {
            case 'users':
                echo $transaction_user != '' ? '<a href="'. esc_url(get_edit_post_link($transaction_user)) .'">'. get_the_title($transaction_user) .'</a>' : '';
                break;
            case 'package':
                $wp_rem_trans_type = get_post_meta(get_the_id(), "wp_rem_transaction_type", true);

                $wp_rem_trans_pkg = get_post_meta(get_the_id(), "wp_rem_transaction_package", true);
                $wp_rem_trans_pkg_title = get_the_title($wp_rem_trans_pkg);

                if ($wp_rem_trans_pkg_title != '') {
                    echo '<a href="'. esc_url(get_edit_post_link($wp_rem_trans_pkg)) .'">'. WP_REM_FUNCTIONS()->special_chars($wp_rem_trans_pkg_title) .'</a>';
                } else {
                    echo '-';
                }
                break;
            case 'amount':
                $wp_rem_trans_amount = get_post_meta(get_the_id(), "wp_rem_transaction_amount", true);
                $currency_sign = get_post_meta(get_the_id(), "wp_rem_currency", true);
                $currency_sign = ( $currency_sign != '' ) ? $currency_sign : '$';
                $currency_position = get_post_meta(get_the_id(), "wp_rem_currency_position", true);
                if ($wp_rem_trans_amount != '') {
                    echo wp_rem_get_order_currency( $wp_rem_trans_amount, $currency_sign, $currency_position );
                } else {
                    echo '-';
                }
                break;
        }
    }

}

if ( ! function_exists('wp_rem_package_orders_sortable') ) {
	add_filter( 'manage_edit-package-orders_sortable_columns', 'wp_rem_package_orders_sortable');
	function wp_rem_package_orders_sortable( $columns ){
		$columns['users'] = 'package_order_user';
		$columns['amount'] = 'package_order';
		return $columns;
	}
}
if ( ! function_exists('wp_rem_admin_package_orders_column_orderby') ) {
	add_filter( 'request', 'wp_rem_admin_package_orders_column_orderby');
	function wp_rem_admin_package_orders_column_orderby(  $vars ){
		if ( isset( $vars['orderby'] ) && 'package_order_user' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_transaction_user',
				'orderby' => 'meta_value',
			) );
		}
		if ( isset( $vars['orderby'] ) && 'package_order' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_transaction_amount',
				'orderby' => 'meta_value_num',
			) );
		}
		return $vars;
	}
}

if ( ! function_exists('wp_rem_admin_package_orders_filter') ) {
	add_action( 'restrict_manage_posts', 'wp_rem_admin_package_orders_filter', 11 );
	function wp_rem_admin_package_orders_filter(){
		global $wp_rem_form_fields, $post_type, $wpdb;
		//only add filter to post type you want
		if ($post_type == 'package-orders'){
			$querystr = "SELECT id FROM $wpdb->posts WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_type = 'package-orders'";
			$package_orders = $wpdb->get_results($querystr);
			$package_names = array();
			if( !empty($package_orders)){
				$package_names[''] = wp_rem_plugin_text_srt('wp_rem_package_tile');
				foreach( $package_orders as $package_order ){
					if( isset($package_order->id)){
						$wp_rem_trans_pkg = get_post_meta($package_order->id, "wp_rem_transaction_package", true);
						$package_names[$wp_rem_trans_pkg] = get_the_title($wp_rem_trans_pkg); 
					}
				}
			}
			if( !empty($package_names)){
				$order_package = isset($_GET['order_package']) ? $_GET['order_package'] : '';
				$wp_rem_opt_array = array(
					'std' => $order_package,
					'id' => 'order_package',
					'cust_name' => 'order_package',
					'extra_atr' => '',
					'classes' => '',
					'options' => $package_names,
					'return' => false,
				);
				$wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
			}
		}
	}
}

if ( ! function_exists('wp_rem_admin_package_orders_filter_query') ) {
	add_filter('parse_query', 'wp_rem_admin_package_orders_filter_query', 11, 1);
	function wp_rem_admin_package_orders_filter_query( $query ){
		global $pagenow;
		$custom_filter_arr = array();
		if ( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'package-orders' && isset($_GET['order_package']) && $_GET['order_package'] != '' ) {
			$custom_filter_arr[] = array(
				'key' => 'wp_rem_transaction_package',
				'value' => $_GET['order_package'],
				'compare' => '=',
			);
		}
		if( is_admin() && $pagenow == 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'package-orders' && !empty($custom_filter_arr)){
			$query->set( 'meta_query', $custom_filter_arr );
		}
	}
}

/**
 * Start Function  how to Row in columns
 */
if (!function_exists('remove_row_actions')) {
    add_filter('post_row_actions', 'remove_row_actions', 10, 1);

    function remove_row_actions($actions) {
        if (get_post_type() == 'package-orders') {
            unset($actions['view']);
            unset($actions['trash']);
            unset($actions['inline hide-if-no-js']);
        }
        return $actions;
    }

}


/**
 * Start Function  how create post type of transactions
 */
if (!class_exists('post_type_package_orders')) {

    class post_type_package_orders {

        // The Constructor
        public function __construct() {
            add_action('init', array(&$this, 'transactions_init'));
            add_action('admin_init', array(&$this, 'transactions_admin_init'));
            add_action('admin_menu', array($this, 'wp_rem_remove_post_boxes'));
            add_action('do_meta_boxes', array($this, 'wp_rem_remove_post_boxes'));
        }

        public function transactions_init() {
            // Initialize Post Type
            $this->transactions_register();
        }

        public function transactions_register() {
            $labels = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_package_orders' ),
                'menu_name' => wp_rem_plugin_text_srt( 'wp_rem_package_orders' ),
                'add_new_item' => wp_rem_plugin_text_srt( 'wp_rem_package_add_new' ),
                'edit_item' => wp_rem_plugin_text_srt( 'wp_rem_package_edit' ),
                'new_item' => wp_rem_plugin_text_srt( 'wp_rem_new_package_order' ),
                'add_new' => wp_rem_plugin_text_srt( 'wp_rem_add_new_package_order' ),
                'view_item' => wp_rem_plugin_text_srt( 'wp_rem_view_package_order' ),
                'search_items' => wp_rem_plugin_text_srt( 'wp_rem_package_search' ),
                'not_found' => wp_rem_plugin_text_srt( 'wp_rem_package_nothing_found' ),
                'not_found_in_trash' => wp_rem_plugin_text_srt( 'wp_rem_package_nothing_found_trash' ),
                'parent_item_colon' => ''
            );
            $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'query_var' => false,
                'menu_icon' => 'dashicons-admin-post',
                'show_in_menu' => 'edit.php?post_type=packages',
                'rewrite' => true,
                'capability_type' => 'post',
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('')
            );
            register_post_type('package-orders', $args);
        } 
        /**
         * Start Function  how create add meta boxes of transactions
         */
        public function transactions_admin_init() {
            // Add metaboxes
            add_action('add_meta_boxes', array(&$this, 'wp_rem_meta_transactions_add'));
        }

        public function wp_rem_meta_transactions_add() {
            add_meta_box('wp_rem_meta_transactions', wp_rem_plugin_text_srt( 'wp_rem_package_order_options' ), array(&$this, 'wp_rem_meta_transactions'), 'package-orders', 'normal', 'high');
        }

        public function wp_rem_meta_transactions($post) {
            global $wp_rem_html_fields, $wp_rem_form_fields, $wp_rem_plugin_options;

            $wp_rem_users_list = array('' => wp_rem_plugin_text_srt( 'wp_rem_package_select_member' ));
            $args = array('posts_per_page' => '-1', 'post_type' => 'members', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC');
            $cust_query = get_posts($args);
            if (is_array($cust_query) && sizeof($cust_query) > 0) {
                foreach ($cust_query as $package_post) {
                    if (isset($package_post->ID)) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        $wp_rem_users_list[$package_id] = $package_title;
                    }
                }
            }

            $wp_rem_packages_list = array('' => wp_rem_plugin_text_srt( 'wp_rem_select_package' ));
            $args = array('posts_per_page' => '-1', 'post_type' => 'packages', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC');
            $cust_query = get_posts($args);
            if (is_array($cust_query) && sizeof($cust_query) > 0) {
                foreach ($cust_query as $package_post) {
                    if (isset($package_post->ID)) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        $wp_rem_packages_list[$package_id] = $package_title;
                    }
                }
            }

            $wp_rem_trans_type = get_post_meta(get_the_id(), "wp_rem_transaction_type", true);

            $transaction_meta = array();
            $transaction_meta['transaction_id'] = array(
                'name' => 'transaction_id',
                'type' => 'hidden_label',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_order_id' ),
                'description' => '',
            );
            $transaction_meta['transaction_user'] = array(
                'name' => 'transaction_user',
                'type' => 'select',
                'classes' => 'chosen-select',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_user' ),
                'options' => $wp_rem_users_list,
                'description' => '',
            );

            $transaction_meta['transaction_package'] = array(
                'name' => 'transaction_package',
                'type' => 'select',
                'classes' => 'chosen-select-no-single',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package' ),
                'options' => $wp_rem_packages_list,
                'description' => '',
            );
            $transaction_meta['transaction_amount'] = array(
                'name' => 'transaction_amount',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_amount' ),
                'description' => '',
            );
            $transaction_meta['transaction_expiry_date'] = array(
                'name' => 'transaction_expiry_date',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_expiry' ),
                'description' => '',
            );
            $transaction_meta['transaction_properties'] = array(
                'name' => 'transaction_properties',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_no_of_properties' ),
                'description' => '',
            );

            $transaction_meta['transaction_property_expiry'] = array(
                'name' => 'transaction_property_expiry',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_property_expiry' ),
                'description' => '',
            ); 
            $transaction_meta['transaction_property_pic_num'] = array(
                'name' => 'transaction_property_pic_num',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_no_of_pictures' ),
                'description' => '',
            );
            $transaction_meta['transaction_property_doc_num'] = array(
                'name' => 'transaction_property_doc_num',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_no_of_documents' ),
                'description' => '',
            );
            $transaction_meta['transaction_property_tags_num'] = array(
                'name' => 'transaction_property_tags_num',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_no_of_tags' ),
                'description' => '',
            );

            $transaction_meta['transaction_property_feature_list'] = array(
                'name' => 'transaction_property_feature_list',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_no_of_featured' ),
                'description' => '',
            );

            $transaction_meta['transaction_property_top_cat_list'] = array(
                'name' => 'transaction_property_top_cat_list',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_no_of_top_categories' ),
                'description' => '',
            );

            $transaction_meta['transaction_property_phone'] = array(
                'name' => 'transaction_property_phone',
                'type' => 'checkbox',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_phone_number' ),
                'description' => '',
            );

            $transaction_meta['transaction_property_website'] = array(
                'name' => 'transaction_property_website',
                'type' => 'checkbox',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_website_link' ),
                'description' => '',
            );

            $transaction_meta['transaction_property_social'] = array(
                'name' => 'transaction_property_social',
                'type' => 'checkbox',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_social_impressions' ),
                'description' => '',
            );
            $transaction_meta['transaction_status'] = array(
                'name' => 'transaction_status',
                'type' => 'select',
                'classes' => 'chosen-select-no-single',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_status' ),
                'options' => array('pending' => wp_rem_plugin_text_srt( 'wp_rem_package_pending' ), 'approved' => wp_rem_plugin_text_srt( 'wp_rem_package_approved' )),
                'description' => '',
            );

            $transaction_meta['transaction_property_dynamic'] = array(
                'name' => 'transaction_property_dynamic',
                'type' => 'trans_dynamic',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_dynamic_fields' ),
                'description' => '',
            );

            $transaction_meta['transaction_ex_features'] = array(
                'type' => 'extra_features',
                'title' => wp_rem_plugin_text_srt( 'wp_rem_package_properties' ),
            );

            $html = '<div class="page-wrap">
						<div class="option-sec" style="margin-bottom:0;">
							<div class="opt-conts">
								<div class="wp-rem-review-wrap">
									<script type="text/javascript">
										jQuery(function(){
											jQuery("#wp_rem_transaction_expiry_date").datetimepicker({
												format:"d-m-Y",
                                                minDate: new Date(),
												timepicker:false
											});
										});
									</script>';
            foreach ($transaction_meta as $key => $params) {
                $html .= wp_rem_create_package_orders_fields($key, $params);
            }

            $html .= '</div>
						</div>
					</div>';
            $wp_rem_opt_array = array(
                'std' => '1',
                'id' => 'transactions_form',
                'cust_name' => 'transactions_form',
                'cust_type' => 'hidden',
                'return' => true,
            );
            $html .= $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
            $html .= '
				<div class="clear"></div>
			</div>';
            echo force_balance_tags($html);
        }
        
         public function wp_rem_remove_post_boxes() {
            remove_meta_box('mymetabox_revslider_0', 'package-orders', 'normal');
        }

    }

    /**
     * End Function  how create add meta boxes of transactions
     */
    return new post_type_package_orders();
}