<?php
/**
 * Homevillas Email Templates Module
 */

// Direct access not allowed.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants
define( 'WP_REM_EMAIL_TEMPLATES_CORE_DIR', WP_PLUGIN_DIR . '/wp-realestate-manager/modules/wp-rem-email-templates' );
define( 'WP_REM_EMAIL_TEMPLATES_INCLUDES_DIR', WP_REM_EMAIL_TEMPLATES_CORE_DIR . '/includes' );
define( 'WP_REM_EMAIL_TEMPLATES_PLUGIN_URL', WP_PLUGIN_URL . '/wp-realestate-manager/modules/wp-rem-email-templates' );

require_once( WP_REM_EMAIL_TEMPLATES_INCLUDES_DIR . '/class-email-templates.php');

if ( ! function_exists( 'wp_rem_check_if_template_exists' ) ) {

	function wp_rem_check_if_template_exists( $slug, $type ) {
		global $wpdb;
		$post = $wpdb->get_row( "SELECT ID FROM " . $wpdb->prefix . "posts WHERE post_name = '" . $slug . "' && post_type = '" . $type . "'", 'ARRAY_A' );

		if ( isset( $post ) && isset( $post['ID'] ) ) {
			return $post['ID'];
		} else {
			return false;
		}
	}

}
