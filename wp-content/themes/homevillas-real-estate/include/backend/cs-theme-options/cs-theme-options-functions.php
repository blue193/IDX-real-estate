<?php

/**
 * Saving Theme Options
 *
 */
if ( ! function_exists('theme_option_save') ) {
	/*
	 * function to save theme options
	 */

	function theme_option_save() {
		global $wp_rem_cs_var_static_text;
		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_theme_option_strings();
		// theme option save request.
		if ( isset($_REQUEST['wp_rem_cs_var_theme_option_save_flag']) ) {
			$theme_id = THEME_ENVATO_ID;
			$theme_name = THEME_NAME;
			$envato_purchase_code_verification = get_option('item_purchase_code_verification');
			$verify_code = false;
			if ( $envato_purchase_code_verification ) {
				if (
						isset($envato_purchase_code_verification['item_id']) && $theme_id == $envato_purchase_code_verification['item_id'] &&
						isset($envato_purchase_code_verification['last_verification_time']) && $envato_purchase_code_verification['last_verification_time'] + 30 * 24 * 60 * 60 > time()
				) {
					$verify_code = false;
				}
			}

			if ( $verify_code ) {
				$html = '
				<div id="wp-rem-purchase-code-sec" class="purchase-code-sec">
					<div class="control-heading"><h2>' . wp_rem_cs_var_theme_text_srt('wp_rem_pur_code_verfiy_txt') . '</h2></div>
					<div class="control-group-fields">
						<label for="item-purchase-code">' . wp_rem_cs_var_theme_text_srt('wp_rem_pur_code_item_pur_code') . '</label>
						<input type="text" name="item-purchase-code" id="item-purchase-code" class="form-contorl">
					</div>
					<div class="btns-group">
						<a id="purchase-code-verify-btn" class="purchase-code-verify-btn" href="javascript:void(0)">' . wp_rem_cs_var_theme_text_srt('wp_rem_pur_code_verfiy_btn') . '</a>
						<a id="purchase-code-cancel-btn" class="purchase-code-cancel-btn" href="javascript:void(0)">' . wp_rem_cs_var_theme_text_srt('wp_rem_pur_code_cancel_btn') . '</a>
					</div>
					<div id="verify-purchase-code-loader" class="verify-purchase-code-loader"></div>
				</div>';
				echo json_encode(array( 'purchase_code' => 'true', 'msg' => $html ));
			} else {
				$_POST = wp_rem_cs_var_stripslashes_htmlspecialchars($_POST);
				update_option("wp_rem_cs_var_options", $_POST);
				// create css file when them option call
				wp_rem_cs_write_stylesheet_content();

				echo json_encode(array( 'purchase_code' => 'false', 'msg' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save_msg') ));
			}
		}
		die();
	}

	add_action('wp_ajax_theme_option_save', 'theme_option_save');
}

/**
 * @Generate Options Backup
 * @return
 *
 */
if ( ! function_exists('wp_rem_cs_var_settings_backup_generate') ) {

	function wp_rem_cs_var_settings_backup_generate() {

		global $wp_filesystem, $wp_rem_cs_var_options, $wp_rem_cs_var_static_text;
		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_theme_option_field_strings();

		$wp_rem_cs_var_export_options = $wp_rem_cs_var_options;

		$wp_rem_cs_var_option_fields = json_encode($wp_rem_cs_var_export_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

		$backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');
		if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

			return true;
		}

		if ( ! WP_Filesystem($creds) ) {
			request_filesystem_credentials($backup_url, '', true, false, array());
			return true;
		}

		$wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';
		$wp_rem_cs_var_filename = trailingslashit($wp_rem_cs_var_upload_dir) . (current_time('d-M-Y_H.i.s')) . '.json';


		if ( ! $wp_filesystem->put_contents($wp_rem_cs_var_filename, $wp_rem_cs_var_option_fields, FS_CHMOD_FILE) ) {
			echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_saving_file'));
		} else {
			echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_backup_generated'));
		}

		die();
	}

	add_action('wp_ajax_wp_rem_cs_var_settings_backup_generate', 'wp_rem_cs_var_settings_backup_generate');
}

/**
 * @Delete Backup File
 * @return
 *
 */
if ( ! function_exists('wp_rem_cs_var_backup_file_delete') ) {

	function wp_rem_cs_var_backup_file_delete() {

		global $wp_filesystem, $wp_rem_cs_var_static_text;

		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_theme_option_field_strings();
		$backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');
		if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

			return true;
		}

		if ( ! WP_Filesystem($creds) ) {
			request_filesystem_credentials($backup_url, '', true, false, array());
			return true;
		}

		$wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';

		$file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';

		$wp_rem_cs_var_filename = trailingslashit($wp_rem_cs_var_upload_dir) . $file_name;

		if ( is_file($wp_rem_cs_var_filename) ) {
			unlink($wp_rem_cs_var_filename);
			printf(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_file_deleted_successfully'), $file_name);
		} else {
			echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_deleting_file'));
		}

		die();
	}

	add_action('wp_ajax_wp_rem_cs_var_backup_file_delete', 'wp_rem_cs_var_backup_file_delete');
}

/**
 * @Restore Backup File
 * @return
 *
 */
if ( ! function_exists('wp_rem_cs_var_backup_file_restore') ) {

	function wp_rem_cs_var_backup_file_restore() {

		global $wp_filesystem, $wp_rem_cs_var_static_text;
		$strings = new wp_rem_cs_theme_all_strings;
		$strings->wp_rem_cs_theme_option_field_strings();

		$backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');
		if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

			return true;
		}

		if ( ! WP_Filesystem($creds) ) {
			request_filesystem_credentials($backup_url, '', true, false, array());
			return true;
		}

		$wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/backups/';

		$file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';

		$file_path = isset($_POST['file_path']) ? $_POST['file_path'] : '';

		if ( $file_path == 'yes' ) {

			$wp_rem_cs_var_file_body = '';

			$wp_rem_cs_var_file_response = wp_remote_get($file_name, array( 'decompress' => false ));

			if ( is_array($wp_rem_cs_var_file_response) ) {
				$wp_rem_cs_var_file_body = isset($wp_rem_cs_var_file_response['body']) ? $wp_rem_cs_var_file_response['body'] : '';
			}

			if ( $wp_rem_cs_var_file_body != '' ) {

				$get_options_file = json_decode($wp_rem_cs_var_file_body, true);

				update_option("wp_rem_cs_var_options", $get_options_file);


				echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_file_import_successfully'));
			} else {
				echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_restoring_file'));
			}

			die;
		}

		$wp_rem_cs_var_filename = trailingslashit($wp_rem_cs_var_upload_dir) . $file_name;

		if ( is_file($wp_rem_cs_var_filename) ) {

			$get_options_file = $wp_filesystem->get_contents($wp_rem_cs_var_filename);

			$get_options_file = json_decode($get_options_file, true);

			update_option("wp_rem_cs_var_options", $get_options_file);


			$wp_rem_cs_var_file_restore_successfully = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_file_restore_successfully');
			printf($wp_rem_cs_var_file_restore_successfully, $file_name);
		} else {
			echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_restoring_file'));
		}

		die();
	}

	add_action('wp_ajax_wp_rem_cs_var_backup_file_restore', 'wp_rem_cs_var_backup_file_restore');
}

/**
 * @saving all the theme options end
 * @return
 *
 */
if ( ! function_exists('theme_option_rest_all') ) {

	function theme_option_rest_all() {

		global $wp_filesystem;

		$backup_url = esc_url(home_url('/'));
		if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

			return true;
		}

		if ( ! WP_Filesystem($creds) ) {
			request_filesystem_credentials($backup_url, '', true, false, array());
			return true;
		}

		$wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/default-settings/';

		$wp_rem_cs_var_filename = trailingslashit($wp_rem_cs_var_upload_dir) . 'default-settings.json';

		if ( is_file($wp_rem_cs_var_filename) ) {

			$get_options_file = $wp_filesystem->get_contents($wp_rem_cs_var_filename);

			$get_options_file = json_decode($get_options_file, true);

			update_option("wp_rem_cs_var_options", $get_options_file);
		} else {
			wp_rem_cs_var_reset_data();
		}
		die;
	}

	add_action('wp_ajax_theme_option_rest_all', 'theme_option_rest_all');
}


/**
 * @Default Options for Theme
 *
 */
if ( ! function_exists('theme_default_options') ) {

	function theme_default_options() {

		global $wp_filesystem;

		$backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');
		if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

			return true;
		}

		if ( ! WP_Filesystem($creds) ) {
			request_filesystem_credentials($backup_url, '', true, false, array());
			return true;
		}

		$wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/default-settings/';

		$wp_rem_cs_var_filename = trailingslashit($wp_rem_cs_var_upload_dir) . 'default-settings.json';

		if ( is_file($wp_rem_cs_var_filename) ) {

			$get_options_file = $wp_filesystem->get_contents($wp_rem_cs_var_filename);

			$wp_rem_cs_var_default_data = $get_options_file = json_decode($get_options_file, true);
		} else {
			$wp_rem_cs_var_default_data = '';
		}

		return $wp_rem_cs_var_default_data;
	}

}


/**
 * @Getting Demo Content
 *
 */
if ( ! function_exists('wp_rem_cs_var_get_demo_content') ) {

	function wp_rem_cs_var_get_demo_content($wp_rem_cs_var_demo_file = '') {

		// global $wp_filesystem;

		$backup_url = wp_nonce_url('themes.php?page=wp_rem_settings_page');
		// if ( false === ( $creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {

		// 	return true;
		// }

		// if ( ! WP_Filesystem($creds) ) {
		// 	request_filesystem_credentials($backup_url, '', true, false, array());
		// 	return true;
		// }

		$wp_rem_cs_var_upload_dir = get_template_directory() . '/include/backend/cs-theme-options/demo-data/';

		$wp_rem_cs_var_filename = trailingslashit($wp_rem_cs_var_upload_dir) . $wp_rem_cs_var_demo_file;

		$wp_rem_cs_var_demo_data = array();

		if ( is_file($wp_rem_cs_var_filename) ) {

			$get_options_file = file_get_contents($wp_rem_cs_var_filename);

			$wp_rem_cs_var_demo_data = $get_options_file;
		}

		return $wp_rem_cs_var_demo_data;
	}

}

/**
 * @theme activation
 * @return
 *
 */
if ( ! function_exists('wp_rem_cs_var_activation_data') ) {

	function wp_rem_cs_var_activation_data() {
		update_option('wp_rem_cs_var_options', theme_default_options());
	}

}

/**
 * @array for reset theme options
 * @return
 *
 */
if ( ! function_exists('wp_rem_cs_var_reset_data') ) {

	function wp_rem_cs_var_reset_data() {
		global $reset_data, $wp_rem_cs_var_settings;
		foreach ( $wp_rem_cs_var_settings as $value ) {
			if ( $value['type'] <> 'heading' and $value['type'] <> 'sub-heading' and $value['type'] <> 'main-heading' ) {
				if ( $value['type'] == 'sidebar' || $value['type'] == 'networks' || $value['type'] == 'badges' ) {
					$reset_data = (array_merge($reset_data, $value['options']));
				} elseif ( 'check_color' == $value['type'] ) {
					$reset_data[$value['id']] = $value['std'];
					$reset_data[$value['id'] . '_switch'] = 'off';
				} else {
					$reset_data[$value['id']] = $value['std'];
				}
			}
		}
		return $reset_data;
	}

}


if ( ! function_exists('wp_rem_cs_var_custom_fonts_list') ) {

	function wp_rem_cs_var_custom_fonts_list() {
		global $wp_rem_cs_var_options;
		$wp_rem_custom_fonts = isset($wp_rem_cs_var_options['wp_rem_custom_fonts']) ? $wp_rem_cs_var_options['wp_rem_custom_fonts'] : '';
		
		$custom_fonts = array();
		if ( is_array($wp_rem_custom_fonts) && !empty($wp_rem_custom_fonts['name'])) {
			foreach ( $wp_rem_custom_fonts['name'] as $key => $wp_rem_custom_font  ) {
				$font_name = isset($wp_rem_custom_fonts['name'][$key]) ? $wp_rem_custom_fonts['name'][$key] : '';
				if( $font_name != '' ){
					$custom_fonts[$key] = $font_name;
				}
				
			}
		}
		return $custom_fonts;
	}

}


if ( ! function_exists('rem_load_all_pages_callback') ) {
	add_action('wp_ajax_rem_load_all_pages', 'rem_load_all_pages_callback');
    function rem_load_all_pages_callback() {
		global $wp_rem_cs_var_form_fields;
		
		$selected_page = isset($_POST['selected_page']) ? $_POST['selected_page'] : '';
		$args = array(
			'sort_order' => 'asc',
			'sort_column' => 'post_title',
			'hierarchical' => 1,
			'exclude' => '',
			'include' => '',
			'meta_key' => '',
			'meta_value' => '',
			'authors' => '',
			'child_of' => 0,
			'parent' => -1,
			'exclude_tree' => '',
			'number' => '',
			'offset' => 0,
			'post_type' => 'page',
			'post_status' => 'publish'
		);

		$wp_rem_cs_var_pages = get_pages($args);
		$wp_rem_cs_var_options_array = array();
		$wp_rem_cs_var_options_array[] = wp_rem_cs_var_theme_text_srt('wp_rem_maintenance_field_select_page');
		foreach ( $wp_rem_cs_var_pages as $wp_rem_cs_var_page ) {
			$wp_rem_cs_var_options_array[$wp_rem_cs_var_page->ID] = isset($wp_rem_cs_var_page->post_title) && ($wp_rem_cs_var_page->post_title != '') ? $wp_rem_cs_var_page->post_title : wp_rem_cs_var_theme_text_srt('wp_rem_no_title');
		}
		
		$wp_rem_cs_opt_array = array(
			'std' => $select_value,
			'id' => 'maintinance_mode_page',
			'classes' => 'chosen-select',
			'extra_atr' => '',
			'return' => true,
			'options' => $wp_rem_cs_var_options_array,

		);
		$output .= $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_select_render($wp_rem_cs_opt_array);
		
		$output .= '<script type="text/javascript">
			jQuery(document).ready(function () {
				chosen_selectionbox();
			});
		</script>';
		echo json_encode(array('html' => $output));
		die;
    }
}