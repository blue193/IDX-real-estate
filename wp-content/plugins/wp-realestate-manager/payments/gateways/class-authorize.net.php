<?php

/**
 *  File Type: Authorize.net Gateway

 */
if (!class_exists('WP_REM_AUTHORIZEDOTNET_GATEWAY')) {

    class WP_REM_AUTHORIZEDOTNET_GATEWAY extends WP_REM_PAYMENTS {

        // Call a construct for objects 
        public function __construct() {
            // Do Something
            global $wp_rem_gateway_options;
            $wp_rem_gateway_options = get_option('wp_rem_plugin_options');
            $wp_rem_lister_url = '';
            if (isset($wp_rem_gateway_options['dir_authorizenet_ipn_url'])) {
                $wp_rem_lister_url = $wp_rem_gateway_options['dir_authorizenet_ipn_url'];
            }
            if (isset($wp_rem_gateway_options['wp_rem_authorizenet_sandbox']) && $wp_rem_gateway_options['wp_rem_authorizenet_sandbox'] == 'on') {
                $this->gateway_url = "https://test.authorize.net/gateway/transact.dll";
            } else {
                $this->gateway_url = "https://secure.authorize.net/gateway/transact.dll";
            }
            $this->listner_url = $wp_rem_lister_url;
        }

        // Start function for Authorize.net payment gateway
        
        public function settings($wp_rem_gateways_id = '') {
            global $post;

            $wp_rem_rand_id = rand(10000000, 99999999);

            $on_off_option = array("show" => wp_rem_plugin_text_srt('wp_rem_aythorize_option_on'), "hide" => wp_rem_plugin_text_srt('wp_rem_aythorize_option_off'));




            $wp_rem_settings[] = array(
                "name" => wp_rem_plugin_text_srt('wp_rem_aythorize_settings'),
                "id" => "tab-heading-options",
                "std" => wp_rem_plugin_text_srt('wp_rem_aythorize_settings'),
                "type" => "section",
                "options" => "",
                "parrent_id" => "$wp_rem_gateways_id",
                "active" => true,
            );




            $wp_rem_settings[] = array("name" => wp_rem_plugin_text_srt('wp_rem_aythorize_custom_logo'),
                "desc" => "",
                "hint_text" => "",
                "id" => "authorizedotnet_gateway_logo",
                "std" => wp_rem::plugin_url() . 'payments/images/athorizedotnet_.png',
                "display" => "none",
                "type" => "upload logo"
            );

            $wp_rem_settings[] = array("name" => wp_rem_plugin_text_srt('wp_rem_aythorize_default_status'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_aythorize_default_status_hint'),
                "id" => "authorizedotnet_gateway_status",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $wp_rem_settings[] = array("name" => wp_rem_plugin_text_srt('wp_rem_aythorize_sandbox'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_aythorize_sandbox_hint'),
                "id" => "authorizenet_sandbox",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );

            $wp_rem_settings[] = array("name" => wp_rem_plugin_text_srt('wp_rem_aythorize_login_id'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_aythorize_login_id_hint'),
                "id" => "authorizenet_login",
                "std" => "",
                "type" => "text"
            );

            $wp_rem_settings[] = array("name" => wp_rem_plugin_text_srt('wp_rem_aythorize_trans_key'),
                "desc" => "",
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_aythorize_trans_key_hint'),
                "id" => "authorizenet_transaction_key",
                "std" => "",
                "type" => "text"
            );

            $ipn_url = wp_rem::plugin_url() . 'payments/listner.php';
            $wp_rem_settings[] = array("name" => wp_rem_plugin_text_srt('wp_rem_aythorize_ipn_url'),
                "desc" => $ipn_url,
                "hint_text" => '',
				"label_desc" => wp_rem_plugin_text_srt('wp_rem_aythorize_ipn_url_hint'),
                "id" => "dir_authorizenet_ipn_url",
                "std" => $ipn_url,
                "type" => "text"
            );



            return $wp_rem_settings;
        }
            // Start function for process request Authorize.net payment gateway
        public function wp_rem_proress_request($params = '') {
            global $post, $wp_rem_gateway_options, $wp_rem_form_fields;
          
            extract($params);
            $wp_rem_current_date = date('Y/m/d H:i:s');
            $output = '';
            $rand_id = $this->wp_rem_get_string(5);
            $wp_rem_login = '';
            if (isset($wp_rem_gateway_options['wp_rem_authorizenet_login'])) {
                $wp_rem_login = $wp_rem_gateway_options['wp_rem_authorizenet_login'];
            }
            $transaction_key = '';
            if (isset($wp_rem_gateway_options['wp_rem_authorizenet_transaction_key'])) {
                $transaction_key = $wp_rem_gateway_options['wp_rem_authorizenet_transaction_key'];
            }
            if (isset($package)) {
                $package = $wp_rem_gateway_options['wp_rem_packages_options'][$wp_rem_trans_pkg];
            }

            $timeStamp = time();
            $sequence = rand(1, 1000);

            if (phpversion() >= '5.1.2') {
                $fingerprint = hash_hmac("md5", $wp_rem_login . "^" . $sequence . "^" . $timeStamp . "^" . $transaction_amount . "^", $transaction_key);
            } else {
                $fingerprint = bin2hex(mhash(MHASH_MD5, $wp_rem_login . "^" . $sequence . "^" . $timeStamp . "^" . $transaction_amount . "^", $transaction_key));
            }
			
			$wp_rem_package_title = get_the_title($transaction_package);

            $currency = isset($wp_rem_gateway_options['wp_rem_currency_type']) && $wp_rem_gateway_options['wp_rem_currency_type'] != '' ? $wp_rem_gateway_options['wp_rem_currency_type'] : 'USD';
            $user_ID = get_current_user_id();

            $wp_rem_opt_hidden1_array = array(
                'id' => '',
                'std' => $wp_rem_login,
                'cust_id' => "",
                'cust_name' => "x_login",
                'return' => true,
            );
            $wp_rem_opt_hidden2_array = array(
                'id' => '',
                'std' => 'AUTH_CAPTURE',
                'cust_id' => "",
                'cust_name' => "x_type",
                'return' => true,
            );
            $wp_rem_opt_hidden3_array = array(
                'id' => '',
                'std' => $transaction_amount,
                'cust_id' => "",
                'cust_name' => "x_amount",
                'return' => true,
            );
           
            $wp_rem_opt_hidden4_array = array(
                'id' => '',
                'std' => $sequence,
                'cust_id' => "",
                'cust_name' => "x_fp_sequence",
                'return' => true,
            );
            $wp_rem_opt_hidden5_array = array(
                'id' => '',
                'std' => $timeStamp,
                'cust_id' => "",
                'cust_name' => "x_fp_timestamp",
                'return' => true,
            );
            $wp_rem_opt_hidden6_array = array(
                'id' => '',
                'std' => $fingerprint,
                'cust_id' => "",
                'cust_name' => "x_fp_hash",
                'return' => true,
            );
            $wp_rem_opt_hidden7_array = array(
                'id' => '',
                'std' => 'PAYMENT_FORM',
                'cust_id' => "",
                'cust_name' => "x_show_form",
                'return' => true,
            );
            $wp_rem_opt_hidden8_array = array(
                'id' => '',
                'std' => 'ORDER-' . sanitize_text_field($transaction_id),
                'cust_id' => "",
                'cust_name' => "x_invoice_num",
                'return' => true,
            );
            $wp_rem_opt_hidden9_array = array(
                'id' => '',
                'std' => sanitize_text_field($transaction_id),
                'cust_id' => "",
                'cust_name' => "x_po_num",
                'return' => true,
            );
            $wp_rem_opt_hidden10_array = array(
                'id' => '',
                'std' => sanitize_text_field($trans_item_id),
                'cust_id' => "",
                'cust_name' => "x_cust_id",
                'return' => true,
            );
            $wp_rem_opt_hidden11_array = array(
                'id' => '',
                'std' => sanitize_text_field($wp_rem_package_title),
                'cust_id' => "",
                'cust_name' => "x_description",
                'return' => true,
            );
			$return_url = isset( $transaction_return_url ) ? $transaction_return_url : esc_url( home_url( '/' ) );
			$wp_rem_opt_hidden18_array = array(
                'id' => '',
                'std' => $return_url,
                'cust_id' => "",
                'cust_name' => "x_receipt_link_url",
                'return' => true,
            );
            $wp_rem_opt_hidden12_array = array(
                'id' => '',
                'std' => esc_url(get_permalink()),
                'cust_id' => "",
                'cust_name' => "x_cancel_url",
                'return' => true,
            );
            $wp_rem_opt_hidden13_array = array(
                'id' => '',
                'std' => wp_rem_plugin_text_srt('wp_rem_aythorize_cancel_order'),
                'cust_id' => "",
                'cust_name' => "x_cancel_url_text",
                'return' => true,
            );
            $wp_rem_opt_hidden14_array = array(
                'id' => '',
                'std' => 'TRUE',
                'cust_id' => "",
                'cust_name' => "x_relay_response",
                'return' => true,
            );
            $wp_rem_opt_hidden15_array = array(
                'id' => '',
                'std' => sanitize_text_field($this->listner_url),
                'cust_id' => "",
                'cust_name' => "x_relay_url",
                'return' => true,
            );
            $wp_rem_opt_hidden16_array = array(
                'id' => '',
                'std' => 'false',
                'cust_id' => "",
                'cust_name' => "x_test_request",
                'return' => true,
            );
             $wp_rem_opt_hidden17_array = array(
				'id' => '',
				'std' => $currency,
				'cust_id' => "",
				'cust_name' => "currency_code",
				'return' => true,
			);
            $output .= '<form name="AuthorizeForm" id="direcotry-authorize-form" action="' . $this->gateway_url . '" method="post">  
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
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden15_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden16_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden17_array) . '
                        ' . $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_hidden18_array) . '
						</form>'
						. '<h3>' . wp_rem_plugin_text_srt('wp_rem_aythorize_redirect_payment') . '</h3>';
            echo force_balance_tags($output);
            echo '<script>
				    	jQuery("#direcotry-authorize-form").submit();
				      </script>';
            die;
        }

    }

}