<?php

ob_start();

if ( ! class_exists('Payment_Processing') ) {

	class Payment_Processing {

		public function __construct() {
			global $rcv_parameters;
			$rcv_parameters = array();
			$Payment_Processing = '';
			add_action('woocommerce_order_status_cancelled', array( $this, 'custom_order_status_cancelled' ));
			add_action('woocommerce_thankyou', array( $this, 'custom_thankyou_page' ));
			add_action('woocommerce_checkout_order_processed', array( $this, 'action_woocommerce_new_order' ), 1000);
			add_filter('woocommerce_checkout_fields', array( $this, 'custom_override_checkout_fields' ));
			add_filter('woocommerce_order_status_pending_to_processing', array( $this, 'custom_payment_complete' ));
			add_action('woocommerce_payment_complete', array( $this, 'custom_payment_complete' ));
			add_action('woocommerce_order_status_processing', array( $this, 'custom_payment_complete' ));
			add_filter('woocommerce_payment_complete_order_status', array( $this, 'custom_payment_complete_order_status' ), 10, 2);
			add_filter('woocommerce_billing_fields', array( $this, 'woocommerce_billing_fields_callback' ), 10, 1);
			add_filter('woocommerce_shipping_fields', array( $this, 'woocommerce_shipping_fields_callback' ), 10, 1);
			add_filter('woocommerce_cart_calculate_fees', array( $this, 'woocommerce_cart_calculate_fees_callback' ), 10, 1);
		}

		public function processing_payment($payment_args) {
			global $wpdb, $rcv_parameters, $woocommerce;
			$rcv_parameters = $payment_args;
			extract($payment_args);


			$wpdb->query("DELETE " . $wpdb->prefix . "posts
			FROM " . $wpdb->prefix . "posts
			INNER JOIN " . $wpdb->prefix . "postmeta ON " . $wpdb->prefix . "postmeta.post_id = " . $wpdb->prefix . "posts.ID
			WHERE (" . $wpdb->prefix . "postmeta.meta_key = 'referance_ID' AND " . $wpdb->prefix . "postmeta.meta_value = '" . $package_id . "')");

			$post = array(
				'post_author' => 1,
				'post_content' => '',
				'post_status' => "publish",
				'post_title' => $package_name,
				'post_parent' => '',
				'post_type' => "product",
			);

			//Create post
			$post_id = wp_insert_post($post);

			update_post_meta($post_id, '_visibility', 'visible');
			update_post_meta($post_id, '_stock_status', 'instock');
			update_post_meta($post_id, '_regular_price', $price);
			update_post_meta($post_id, 'referance_ID', $package_id);
			update_post_meta($post_id, '_price', $price);
			update_post_meta($post_id, 'rcv_parameters', $payment_args);
			update_post_meta($post_id, '_virtual', 'yes');
			update_post_meta($post_id, '_visibility', 'hidden');

			$woocommerce->cart->empty_cart();
			$woocommerce->cart->add_to_cart($post_id, 1);

			$checkout_url = $woocommerce->cart->get_checkout_url();

			echo "<script>window.top.location.href='$checkout_url';</script>";
			if ( isset($is_json) && $is_json == 'true' ) {
				// do nothing
			} else {
				exit;
			}
		}

		public function custom_order_status_cancelled($order_id) {
			global $wp_rem_plugin_options;
			$rcv_parameters = get_post_meta($order_id, '_rcv_parameters', true);
			if ( isset($rcv_parameters) && ! empty($rcv_parameters) ) {
				$_REQUEST['order_id'] = $order_id;
				$_REQUEST['payment_status'] = 'Cancelled';
				$_REQUEST['payment_source'] = 'wooC';
				$redirect_url = add_query_arg($_REQUEST, $wp_rem_plugin_options['wp_rem_dir_paypal_ipn_url']);

				$order = new WC_Order($order_id);
				foreach ( $order->get_items() as $item ) {
					wp_delete_post($item['product_id']);
				}
				wp_delete_post($order_id);
				$return_url = get_option('wooCommerce_current_page');
				if ( ! isset($return_url) || $return_url == '' ) {
					$return_url = site_url();
				}
				wp_redirect($return_url);
			}
		}

		public function custom_thankyou_page($order_id) {
			global $wp_rem_plugin_options;
			$rcv_parameters = get_post_meta($order_id, '_rcv_parameters', true);
			if ( isset($rcv_parameters) && ! empty($rcv_parameters) ) {
				$return_url = $rcv_parameters['redirect_url'];
				$order = new WC_Order($order_id);
				$payment_method = get_post_meta($order_id, '_payment_method', true);
				$order_status_array = array(
					'payment_method' => $payment_method,
					'order_id' => $order_id,
					'status_code' => 200,
					'status_message' => wp_rem_plugin_text_srt('wp_rem_wooc_hooks_order_received'),
				);
				$return_url = get_option('wooCommerce_current_page');
				if ( ! isset($return_url) || $return_url == '' ) {
					$return_url = site_url();
				}
				update_option('custom_order_status_array', $order_status_array);
				wp_redirect($return_url);
			}
		}

		public function action_woocommerce_new_order($order_id) {
			global $woocommerce;
			$order = new WC_Order($order_id);
			foreach ( $order->get_items() as $item ) {
				$product_id = $item['product_id'];
			}
			$rcv_parameters = get_post_meta($item['product_id'], 'rcv_parameters', true);
			$transaction_id = $rcv_parameters['custom_var']['wp_rem_transaction_id'];
			if ( isset($rcv_parameters) && ! empty($rcv_parameters) ) {
				update_post_meta($order_id, '_rcv_parameters', $rcv_parameters);
			}
			$current_user = wp_get_current_user();
			update_post_meta($transaction_id, 'woocommerce_order_id', $order_id);
			update_post_meta($transaction_id, 'wp_rem_transaction_pay_method', get_post_meta($order_id, '_payment_method', true));
			update_post_meta($transaction_id, 'wp_rem_currency', get_woocommerce_currency_symbol());
			update_post_meta($transaction_id, 'wp_rem_currency_position', wp_rem_get_currency_position());
			$user_id = get_current_user_id();
		}

		public function custom_override_checkout_fields($fields) {
			global $woocommerce;
			$items = $woocommerce->cart->get_cart();

			foreach ( $items as $item ) {
				$product = $item['data']->post;
				$product_id = $product->ID;
			}
			$rcv_parameters = get_post_meta($product_id, 'rcv_parameters');

			if ( isset($rcv_parameters) && ! empty($rcv_parameters) ) {
				$fields = array();
			}
			return $fields;
		}

		public function custom_payment_complete($order_id) {
			$wp_rem_plugin_options = get_option('wp_rem_plugin_options');
			$_REQUEST['order_id'] = $order_id;
			$_REQUEST['payment_status'] = 'approved';
			$_REQUEST['payment_source'] = 'WP_REM_WOOCOMMERCE_GATEWAY';
			$redirect_url = $wp_rem_plugin_options['wp_rem_dir_paypal_ipn_url'];
			$redirect_url = add_query_arg($_REQUEST, $redirect_url);
			wp_remote_get($redirect_url);
		}

		public function custom_payment_complete_order_status($order_status, $order_id) {
			if ( $order_status == 'processing' ) {
				$wp_rem_plugin_options = get_option('wp_rem_plugin_options');
				$_REQUEST['order_id'] = $order_id;
				$_REQUEST['payment_status'] = 'approved';
				$_REQUEST['payment_source'] = 'WP_REM_WOOCOMMERCE_GATEWAY';
				$redirect_url = $wp_rem_plugin_options['wp_rem_dir_paypal_ipn_url'];
				$redirect_url = add_query_arg($_REQUEST, $redirect_url);
				wp_remote_get($redirect_url);
			}
			return 'completed';
		}

		public function custom_hide_coupon_field($enabled) {
			if ( is_checkout() ) {
				$enabled = false;
			}
			return $enabled;
		}

		public function custom_order_status_display() {
			global $woocommerce;
			$return_data = get_option('custom_order_status_array');
			delete_option('custom_order_status_array');
			return $return_data;
		}

		public function remove_raw_data($order_id) {
			if ( isset($order_id) && $order_id != '' ) {
				$order = new WC_Order($order_id);
				foreach ( $order->get_items() as $item ) {
					wp_delete_post($item['product_id']);
				}
			}
		}

		public function woocommerce_billing_fields_callback($address_fields) {
			$address_fields['billing_phone']['required'] = false;
			$address_fields['billing_country']['required'] = false;
			$address_fields['billing_first_name']['required'] = false;
			$address_fields['billing_last_name']['required'] = false;
			$address_fields['billing_email']['required'] = false;
			$address_fields['billing_address_1']['required'] = false;
			$address_fields['billing_city']['required'] = false;
			$address_fields['billing_postcode']['required'] = false;
			return $address_fields;
		}

		public function woocommerce_shipping_fields_callback($address_fields) {
			$address_fields['order_comments']['required'] = false;
			return $address_fields;
		}

		public function woocommerce_order_items_meta_display_callback($output, $orderObj) {
			return $output;
		}

		public function woocommerce_cart_calculate_fees_callback($wooccm_custom_user_charge_man) {
			global $woocommerce, $wp_rem_plugin_options;

			$vat_tax = 0;
			if ( isset($wp_rem_plugin_options['wp_rem_vat_switch']) && $wp_rem_plugin_options['wp_rem_vat_switch'] == 'on' ) {
				$vat_tax = ( isset($wp_rem_plugin_options['wp_rem_payment_vat']) && $wp_rem_plugin_options['wp_rem_payment_vat'] != '' ) ? $wp_rem_plugin_options['wp_rem_payment_vat'] : 0;
			}
			if ( $vat_tax != 0 ) {
				$items = $woocommerce->cart->get_cart();

				foreach ( $items as $item ) {
					$product = $item['data']->post;
					$product_id = $product->ID;
				}
				$rcv_parameters = get_post_meta($product_id, 'rcv_parameters', true);
				$wp_rem_transaction_amount = isset($rcv_parameters['price']) ? $rcv_parameters['price'] : 0;

				$wp_rem_vat_amount = $wp_rem_transaction_amount * ( $vat_tax / 100 );
				$vat_amount = WP_REM_FUNCTIONS()->num_format($wp_rem_vat_amount);

				$woocommerce->cart->add_fee(wp_rem_plugin_text_srt('wp_rem_wooc_hooks_vat') . ' (' . $vat_tax . '%)', $vat_amount);
			}
			return $wooccm_custom_user_charge_man;
		}

	}

	global $Payment_Processing;
	$Payment_Processing = new Payment_Processing();
}