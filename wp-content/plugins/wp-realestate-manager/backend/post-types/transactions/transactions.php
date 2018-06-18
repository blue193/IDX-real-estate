<?php

// Transactions start
// Adding columns start

/**
 * Start Function  how to Create colume in transactions 
 */
if ( ! function_exists('transactions_columns_add') ) {
    add_filter('manage_wp-rem-trans_posts_columns', 'transactions_columns_add');
	
    function transactions_columns_add($columns) {
        $new_columns = array();
		foreach($columns as $key => $value) {
			$new_columns[$key] = $value;
			if( $key == 'title' ){
				$new_columns[$key] = wp_rem_plugin_text_srt('wp_rem_transaction_column_transaction_id');
			}
			if( $key == 'date' ){
				$new_columns[$key] = wp_rem_plugin_text_srt('wp_rem_transaction_column_date');
				$new_columns['property_owner'] = wp_rem_plugin_text_srt('wp_rem_transaction_column_property_owner');
				$new_columns['order_type'] = wp_rem_plugin_text_srt('wp_rem_transaction_column_order_type');
				$new_columns['gateway'] = wp_rem_plugin_text_srt('wp_rem_transaction_column_gateway');
				$new_columns['amount'] = wp_rem_plugin_text_srt('wp_rem_transaction_column_amount');
			}
		}
		return $new_columns;
    }

}

/**
 * Start Function  how to Show data in columns
 */
if ( ! function_exists('transactions_columns') ) {
    add_action('manage_wp-rem-trans_posts_custom_column', 'transactions_columns', 10, 2);

    function transactions_columns($name) {
        global $post, $gateways, $wp_rem_plugin_options;
        $general_settings = new WP_REM_PAYMENTS();
        $currency_sign = wp_rem_get_currency_sign();
        $transaction_user = get_post_meta($post->ID, 'wp_rem_transaction_user', true);
        $transaction_amount = get_post_meta($post->ID, 'wp_rem_transaction_amount', true);
        $transaction_fee = get_post_meta($post->ID, 'transaction_fee', true);
        $transaction_status = get_post_meta($post->ID, 'wp_rem_transaction_status', true);
        $order_type = get_post_meta($post->ID, 'wp_rem_transaction_order_type', true);

        $transaction_order_id = get_post_meta($post->ID, 'wp_rem_transaction_order_id', true);

        // return payment gateway name
        switch ( $name ) {
            case 'p_title':
                echo get_the_title($post->ID);
                break;
            case 'p_date':
                echo get_the_date();
                break;
            case 'property_owner':
                echo force_balance_tags($transaction_user != '' ? '<a href="'. esc_url(get_edit_post_link($transaction_user)) .'">'. get_the_title($transaction_user) .'</a>' : '');
                break;
            case 'order_type':
                if ( $order_type == 'package-order' ) {
                    echo esc_html__('Package Order', 'wp-rem');
                } else {
                    echo esc_html__('Order', 'wp-rem');
                }
                break;
            case 'gateway':
                $wp_rem_trans_gate = get_post_meta(get_the_id(), "wp_rem_transaction_pay_method", true);
                if ( $wp_rem_trans_gate != '' ) {
                    $wp_rem_trans_gate = isset($gateways[strtoupper($wp_rem_trans_gate)]) ? $gateways[strtoupper($wp_rem_trans_gate)] : $wp_rem_trans_gate;

                    $wp_rem_trans_gate = ( isset($wp_rem_trans_gate) && $wp_rem_trans_gate == 'WP_REM_WOOCOMMERCE_GATEWAY' ) ? 'payment cancelled' : $wp_rem_trans_gate;
                    $wp_rem_trans_gate = isset($wp_rem_trans_gate) ? $wp_rem_trans_gate : wp_rem_plugin_text_srt('wp_rem_transaction_gateway_nill');
                    echo esc_html($wp_rem_trans_gate);
                } else {
                    echo '-';
                }
                $order_with = get_post_meta($post->ID, 'wp_rem_order_with', true);
                if ( isset($order_with) && $order_with == 'woocommerce' ) {
                    $order_id = get_post_meta($post->ID, 'woocommerce_order_id', true);
                    if ( isset($order_id) && $order_id != '' ) {
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . get_edit_post_link($order_id) . '">' . wp_rem_plugin_text_srt('wp_rem_transaction_gateway_deatil_order') . '</a>';
                    }
                }
                break;
            case 'amount':
                $order_with = get_post_meta($post->ID, 'wp_rem_order_with', true);
                $currency_sign = get_post_meta($post->ID, 'wp_rem_currency', true);
                $currency_position = get_post_meta($post->ID, 'wp_rem_currency_position', true);
                if ( isset($order_with) && $order_with == 'woocommerce' ) {
                    $currency_symbol = get_post_meta($post->ID, 'wp_rem_currency', true);
                    if ( isset($currency_symbol) && $currency_symbol != '' ) {
                        $currency_sign = $currency_symbol;
                    }
                }
                $currency_sign = ( $currency_sign != '' ) ? $currency_sign : '$';
                $wp_rem_trans_amount = get_post_meta($post->ID, "wp_rem_transaction_amount", true);
                if ( $wp_rem_trans_amount != '' ) {
                    echo wp_rem_get_order_currency($wp_rem_trans_amount, $currency_sign, $currency_position);
                } else {
                    echo '-';
                }
                break;
        }
    }

}

if ( ! function_exists('wp_rem_transactions_sortable') ) {
	add_filter( 'manage_edit-wp-rem-trans_sortable_columns', 'wp_rem_transactions_sortable');
	function wp_rem_transactions_sortable( $columns ){
		$columns['property_owner'] = 'transaction_property_owner';
		$columns['order_type'] = 'transaction_order_type';
		$columns['gateway'] = 'transaction_gateway';
		$columns['amount'] = 'transaction_amount';
		return $columns;
	}
}
if ( ! function_exists('wp_rem_admin_transactions_column_orderby') ) {
	add_filter( 'request', 'wp_rem_admin_transactions_column_orderby');
	function wp_rem_admin_transactions_column_orderby(  $vars ){
		if ( isset( $vars['orderby'] ) && 'transaction_property_owner' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_transaction_user',
				'orderby' => 'meta_value',
			) );
		}
		if ( isset( $vars['orderby'] ) && 'transaction_order_type' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_transaction_order_type',
				'orderby' => 'meta_value',
			) );
		}
		if ( isset( $vars['orderby'] ) && 'transaction_gateway' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_transaction_pay_method',
				'orderby' => 'meta_value',
			) );
		}
		if ( isset( $vars['orderby'] ) && 'transaction_amount' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'wp_rem_transaction_amount',
				'orderby' => 'meta_value_num',
			) );
		}
		return $vars;
	}
}

/**
 * Start Function  how to Row in columns
 */
if ( ! function_exists('remove_row_actions') ) {
    add_filter('post_row_actions', 'remove_row_actions', 10, 1);

    function remove_row_actions($actions) {
        if ( get_post_type() == 'wp-rem-trans' ) {
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
if ( ! class_exists('post_type_transactions') ) {

    class post_type_transactions {

        // The Constructor
        public function __construct() {
            add_action('init', array( &$this, 'transactions_init' ));
            add_action('admin_init', array( &$this, 'transactions_admin_init' ));
            add_action('admin_menu', array( $this, 'wp_rem_remove_post_boxes' ));
            add_action('do_meta_boxes', array( $this, 'wp_rem_remove_post_boxes' ));
        }

        public function transactions_init() {
            // Initialize Post Type
            $this->transactions_register();
        }

        public function transactions_register() {
            $labels = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_name'),
                'menu_name' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_menu_name'),
                'add_new_item' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_add_new_item'),
                'edit_item' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_edit_item'),
                'new_item' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_new_item'),
                'add_new' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_add_new'),
                'view_item' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_view_item'),
                'search_items' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_search_item'),
                'not_found' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_not_found'),
                'not_found_in_trash' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_not_found_trash'),
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
                'supports' => array( '' )
            );
            register_post_type('wp-rem-trans', $args);
        }

        /**
         * Start Function  how create add meta boxes of transactions
         */
        public function transactions_admin_init() {
            // Add metaboxes
            add_action('add_meta_boxes', array( &$this, 'wp_rem_meta_transactions_add' ));
        }

        public function wp_rem_meta_transactions_add() {
            add_meta_box('wp_rem_meta_transactions', wp_rem_plugin_text_srt('wp_rem_transaction_post_type_trans_options'), array( &$this, 'wp_rem_meta_transactions' ), 'wp-rem-trans', 'normal', 'high');
        }

        public function wp_rem_meta_transactions($post) {
            global $gateways, $wp_rem_html_fields, $wp_rem_form_fields, $wp_rem_plugin_options;
            $wp_rem_users_list = array( '' => wp_rem_plugin_text_srt('wp_rem_transaction_post_type_slct_pblisher') );
            $args = array( 'posts_per_page' => '-1', 'post_type' => 'members', 'orderby' => 'title', 'post_status' => 'publish', 'order' => 'ASC' );
            $cust_query = get_posts($args);
            if ( is_array($cust_query) && sizeof($cust_query) > 0 ) {
                foreach ( $cust_query as $package_post ) {
                    if ( isset($package_post->ID) ) {
                        $package_id = $package_post->ID;
                        $package_title = $package_post->post_title;
                        $wp_rem_users_list[$package_id] = $package_title;
                    }
                }
            }

            $object = new WP_REM_PAYMENTS();
            $payment_geteways = array();
            $payment_geteways[''] = wp_rem_plugin_text_srt('wp_rem_transaction_post_type_slct_pay_gateway');
            $wp_rem_gateway_options = get_option('wp_rem_plugin_options');

            foreach ( $gateways as $key => $value ) {
                $status = $wp_rem_gateway_options[strtolower($key) . '_status'];
                if ( isset($status) && $status == 'on' ) {
                    $payment_geteways[$key] = $value;
                }
            }

            if ( isset($wp_rem_gateway_options['wp_rem_use_woocommerce_gateway']) && $wp_rem_gateway_options['wp_rem_use_woocommerce_gateway'] == 'on' ) {
                if ( class_exists('WooCommerce') ) {
                    unset($payment_geteways);
                    $payment_geteways[''] = wp_rem_plugin_text_srt('wp_rem_transaction_slct_paymnt_gateway');
                    $gateways = WC()->payment_gateways->get_available_payment_gateways();
                    foreach ( $gateways as $key => $gateway_data ) {
                        $payment_geteways[$key] = $gateway_data->method_title;
                    }
                }
            }

            $transaction_meta = array();
            $transaction_meta['transaction_id'] = array(
                'name' => 'transaction_id',
                'type' => 'hidden_label',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_slct_paymnt_gateway'),
                'description' => '',
            );
            $transaction_meta['transaction_order_id'] = array(
                'name' => 'transaction_order_id',
                'type' => 'hidden_label',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_order_id'),
                'description' => '',
            );
            $transaction_meta['transaction_summary'] = array(
                'name' => 'transaction_summary',
                'type' => 'summary',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_summary'),
                'description' => '',
            );
            $transaction_meta['transaction_order_type'] = array(
                'name' => 'transaction_order_type',
                'type' => 'select',
                'classes' => 'chosen-select',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_order_type'),
                'options' => array(
                    '' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_slct_order_type'),
                    'package-order' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_packages_order'),
                ),
                'description' => '',
            );
            $transaction_meta['transaction_user'] = array(
                'name' => 'transaction_user',
                'type' => 'select',
                'classes' => 'chosen-select',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_user'),
                'options' => $wp_rem_users_list,
                'description' => '',
            );
            $transaction_meta['transaction_amount'] = array(
                'name' => 'transaction_amount',
                'type' => 'text',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_amount'),
                'description' => '',
            );
            $transaction_meta['transaction_pay_method'] = array(
                'name' => 'transaction_pay_method',
                'type' => 'select',
                'classes' => 'chosen-select-no-single',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_payment_gateway'),
                'options' => $payment_geteways,
                'description' => '',
            );
            $transaction_meta['transaction_status'] = array(
                'name' => 'transaction_status',
                'type' => 'select',
                'classes' => 'chosen-select-no-single',
                'title' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_status'),
                'options' => array(
                    'pending' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_status_pending'),
                    'in-process' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_status_in_process'),
                    'approved' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_status_approved'),
                    'cancelled' => wp_rem_plugin_text_srt('wp_rem_transaction_meta_status_cancelled')
                ),
                'description' => '',
            );

            $html = '
			<div class="page-wrap">
			<div class="option-sec" style="margin-bottom:0;">
			<div class="opt-conts">
			<div class="wp-rem-review-wrap">';

            foreach ( $transaction_meta as $key => $params ) {
                $html .= wp_rem_create_transactions_fields($key, $params);
            }

            $html .= '
			</div>
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
            remove_meta_box('mymetabox_revslider_0', 'wp-rem-trans', 'normal');
        }

    }

    /**
     * End Function  how create add meta boxes of transactions
     */
    return new post_type_transactions();
}