<?php

/**
 *  File Type: Paypal Gateway
 *
 */
if ( ! class_exists('WP_REM_PAYPAL_GATEWAY') ) {

	class WP_REM_PAYPAL_GATEWAY extends WP_REM_PAYMENTS {

		public function __construct() {
			global $wp_rem_gateway_options;

			$wp_rem_gateway_options = get_option('wp_rem_plugin_options');

			$wp_rem_lister_url = '';
			if ( isset($wp_rem_gateway_options['wp_rem_dir_paypal_ipn_url']) ) {
				$wp_rem_lister_url = $wp_rem_gateway_options['wp_rem_dir_paypal_ipn_url'];
			}

			if ( isset($wp_rem_gateway_options['wp_rem_paypal_sandbox']) && $wp_rem_gateway_options['wp_rem_paypal_sandbox'] == 'on' ) {
				$this->gateway_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
			} else {
				$this->gateway_url = "https://www.paypal.com/cgi-bin/webscr";
			}
			$this->listner_url = $wp_rem_lister_url;
		}

		// Start function for paypal setting 

		public function settings($wp_rem_gateways_id = '') {
			global $post;

			$wp_rem_rand_id = rand(10000000, 99999999);

			$on_off_option = array( "show" => wp_rem_plugin_text_srt('wp_rem_paypal_options_on'), "hide" => wp_rem_plugin_text_srt('wp_rem_paypal_options_off') );



			$wp_rem_settings[] = array(
				"name" => wp_rem_plugin_text_srt('wp_rem_paypal_settings'),
				"id" => "tab-heading-options",
				"std" => wp_rem_plugin_text_srt('wp_rem_paypal_settings'),
				"type" => "section",
				"options" => "",
				"parrent_id" => "$wp_rem_gateways_id",
				"active" => true,
			);



			$wp_rem_settings[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_paypal_custom_logo'),
				"desc" => "",
				"hint_text" => "",
				"id" => "paypal_gateway_logo",
				"std" => wp_rem::plugin_url() . 'payments/images/paypal.png',
				"display" => "none",
				"type" => "upload logo"
			);

			$wp_rem_settings[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_paypal_default_status'),
				"desc" => "",
				"hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_paypal_default_status_hint'),
				"id" => "paypal_gateway_status",
				"std" => "on",
				"type" => "checkbox",
				"options" => $on_off_option
			);

			$wp_rem_settings[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_paypal_sandbox'),
				"desc" => "",
				"hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_paypal_sandbox_hint'),
				"id" => "paypal_sandbox",
				"std" => "on",
				"type" => "checkbox",
				"options" => $on_off_option
			);

			$wp_rem_settings[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_paypal_business_email'),
				"desc" => "",
				"hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_paypal_business_email_hint'),
				"id" => "paypal_email",
				"std" => "",
				"type" => "text"
			);

			$ipn_url = wp_rem::plugin_url() . 'payments/listner.php';
			$wp_rem_settings[] = array( "name" => wp_rem_plugin_text_srt('wp_rem_paypal_ipn_url'),
				"desc" => $ipn_url,
				"hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_skrill_ipn_url_hint'),
				"id" => "dir_paypal_ipn_url",
				"std" => $ipn_url,
				"type" => "text"
			);



			return $wp_rem_settings;
		}

		// Start function for paypal process request  

		public function wp_rem_proress_request($params = '') {
			global $post, $wp_rem_gateway_options, $wp_rem_form_fields;
			extract($params);

			$wp_rem_current_date = date('Y/m/d H:i:s');
			$output = '';
			$rand_id = $this->wp_rem_get_string(5);
			$business_email = $wp_rem_gateway_options['wp_rem_paypal_email'];

			$wp_rem_package_title = get_the_title($transaction_package);
			$currency = isset($wp_rem_gateway_options['wp_rem_currency_type']) && $wp_rem_gateway_options['wp_rem_currency_type'] != '' ? $wp_rem_gateway_options['wp_rem_currency_type'] : 'USD';
			$return_url = isset( $transaction_return_url ) ? $transaction_return_url : esc_url( home_url( '/' ) );
			
			$wp_rem_opt_hidden1_array = array(
				'id' => '',
				'std' => '_xclick',
				'cust_id' => "",
				'cust_name' => "cmd",
				'return' => true,
			);
			$wp_rem_opt_hidden2_array = array(
				'id' => '',
				'std' => sanitize_email($business_email),
				'cust_id' => "",
				'cust_name' => "business",
				'return' => true,
			);
			$wp_rem_opt_hidden3_array = array(
				'id' => '',
				'std' => $transaction_amount,
				'cust_id' => "",
				'cust_name' => "amount",
				'return' => true,
			);
			$wp_rem_opt_hidden4_array = array(
				'id' => '',
				'std' => $currency,
				'cust_id' => "",
				'cust_name' => "currency_code",
				'return' => true,
			);
			$wp_rem_opt_hidden5_array = array(
				'id' => '',
				'std' => $wp_rem_package_title,
				'cust_id' => "",
				'cust_name' => "item_name",
				'return' => true,
			);
			$wp_rem_opt_hidden6_array = array(
				'id' => '',
				'std' => $trans_item_id,
				'cust_id' => "",
				'cust_name' => "item_number",
				'return' => true,
			);
			$wp_rem_opt_hidden7_array = array(
				'id' => '',
				'std' => '',
				'cust_id' => "",
				'cust_name' => "cancel_return",
				'return' => true,
			);
			$wp_rem_opt_hidden8_array = array(
				'id' => '',
				'std' => '1',
				'cust_id' => "",
				'cust_name' => "no_note",
				'return' => true,
			);
			$wp_rem_opt_hidden9_array = array(
				'id' => '',
				'std' => sanitize_text_field($transaction_id),
				'cust_id' => "",
				'cust_name' => "invoice",
				'return' => true,
			);
			$wp_rem_opt_hidden10_array = array(
				'id' => '',
				'std' => esc_url($this->listner_url),
				'cust_id' => "",
				'cust_name' => "notify_url",
				'return' => true,
			);
			$wp_rem_opt_hidden11_array = array(
				'id' => '',
				'std' => '',
				'cust_id' => "",
				'cust_name' => "lc",
				'return' => true,
			);
			$wp_rem_opt_hidden12_array = array(
				'id' => '',
				'std' => '2',
				'cust_id' => "",
				'cust_name' => "rm",
				'return' => true,
			);
			$wp_rem_opt_hidden13_array = array(
				'id' => '',
				'std' => sanitize_text_field($transaction_id),
				'cust_id' => "",
				'cust_name' => "custom",
				'return' => true,
			);
			$wp_rem_opt_hidden14_array = array(
				'id' => '',
				'std' => $return_url,
				'cust_id' => "",
				'cust_name' => "return",
				'return' => true,
			);

			$output .= '<form name="PayPalForm" id="direcotry-paypal-form" action="' . $this->gateway_url . '" method="post">  
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden1_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden2_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden3_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden4_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden5_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden6_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden7_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden8_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden9_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden10_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden11_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden12_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden13_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden14_array) . '
                        </form>'
						. '<h3>' .  wp_rem_plugin_text_srt('wp_rem_skrill_redirect_to_pg'). '</h3>';


			$data = force_balance_tags($output);
			$data .= '<script>
					  	  jQuery("#direcotry-paypal-form").submit();
					  </script>';
			echo force_balance_tags($data);
		}

		public function wp_rem_gateway_listner() {
			
		}

	}

}