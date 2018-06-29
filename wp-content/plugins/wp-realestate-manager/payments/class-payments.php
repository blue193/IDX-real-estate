<?php

global $gateways;
/**
 *  File Type: Payemnts Base Class
 *
 */
if ( ! class_exists('WP_REM_PAYMENTS') ) {

	class WP_REM_PAYMENTS {

		public $gateways;

		public function __construct() {
			global $gateways;
			$gateways['WP_REM_PAYPAL_GATEWAY'] = 'Paypal';
			$gateways['WP_REM_AUTHORIZEDOTNET_GATEWAY'] = 'Authorize.net';
			$gateways['WP_REM_PRE_BANK_TRANSFER'] = 'Pre Bank Transfer';
			$gateways['WP_REM_SKRILL_GATEWAY'] = 'Skrill-MoneyBooker';
		}

		 // Start function get string length

		public function wp_rem_get_string($length = 3) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ( $i = 0; $i < $length; $i ++ ) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}

		// Start function for add transaction 

		public function wp_rem_add_transaction($fields = array()) {
			global $wp_rem_plugin_options;
			define("DEBUG", 1);
			define("USE_SANDBOX", 1);
			define("LOG_FILE", "./ipn.log");
			include_once('../../../../wp-load.php');
			if ( is_array($fields) ) {
				foreach ( $fields as $key => $value ) {
					update_post_meta((int) $fields['wp_rem_transaction_id'], "$key", $value);
				}
			}
			return true;
		}

	}

}
