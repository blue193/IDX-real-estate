<?php

add_action( 'wp_rem_import_users', 'wp_rem_import_users_handle' );
if ( ! function_exists( 'wp_rem_import_users_handle' ) ) {
	function wp_rem_import_users_handle( $obj ) {
		if (class_exists('wp_rem_user_import')) {
			ob_start();
			$wp_rem_user_import = new wp_rem_user_import();
            $wp_rem_user_import->wp_rem_import_user_demodata( false, false, false, $obj->users_data_path );
			ob_end_clean();
			$obj->action_return = true;
		} else {
			$obj->action_return = false;
		}
	}
}

add_action( 'wp_rem_import_plugin_options', 'wp_rem_import_plugin_options_handle' );
if ( ! function_exists( 'wp_rem_import_plugin_options_handle' ) ) {
	function wp_rem_import_plugin_options_handle( $obj ) {
		if ( function_exists( 'wp_rem_demo_plugin_data' ) ) {
			wp_rem_demo_plugin_data( $obj->plugins_data_path );
			$obj->action_return = true;
		} else {
			$obj->action_return = false;
		}
	}
}