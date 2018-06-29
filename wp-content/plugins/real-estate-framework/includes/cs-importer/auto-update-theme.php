<?php

/**
 * Auto Update Theme and Plugins
 *
 * @since 1.0
 * @package Rem_cs
 */
// Used while Auto Upgrading theme and plugins
$cs_theme_upgraded_name = '';
$cs_plugins_upgraded = array();

add_action('admin_init', 'wp_rem_cs_check_for_updates');
if ( ! function_exists('wp_rem_cs_check_for_updates') ) {

	/**
	 * Check for theme updates if available
	 */
	function wp_rem_cs_check_for_updates() {
		global $wp_rem_cs_options;

		// Skip if current user is not allowed to update theme.
		if ( ! current_user_can('update_themes') ) {
			return;
		}
		// If this is an request to upgrade theme then no need to show Theme upgrade notice.
		if ( 'upgrade_theme' == isset($_GET['action']) && $_GET['action'] ) {
			return;
		}
		// If there is already upgrade found then only show notice.
		$upgrade_option = get_option('is_auto_update_theme_' . THEME_NAME);
		if ( $upgrade_option ) {
			// If this is themes.php page then show update notice on Theme item.
			if ( 'themes.php' == basename($_SERVER[PHP_SELF]) ) {
				add_action('admin_footer', 'wp_rem_cs_show_theme_auto_update_available_on_themes_page');
			}

			add_action('admin_notices', 'wp_rem_cs_show_theme_auto_update_available');
			return;
		}

		//- delete_option( 'last_time_auto_theme_update_checked_' . THEME_NAME );
		if ( ! empty($wp_rem_cs_options['cs_marketplace_username']) ) {
			$last_checked = get_option('last_time_auto_theme_update_checked_' . THEME_NAME);
			if ( $last_checked ) {
				// Check for updates once every 24 horus.
				if ( $last_checked + 24 * 60 * 60 > time() ) {
					return;
				}
			}
			$user_name = $wp_rem_cs_options['cs_marketplace_username'];
			$api_key = $wp_rem_cs_options['cs_secret_api_key'];
			$skip_backup = $wp_rem_cs_options['cs_skip_theme_backup'];

			require_once trailingslashit(CS_BASE) . 'include/backend/cs-importer-helper/class-envato-api.php';

			$protected_api = new Envato_Protected_API($user_name, $api_key);

			// Get purchased marketplace themes.
			$themes = $protected_api->wp_list_themes();

			/* Display API errors */
			if ( $errors = $protected_api->api_errors() ) {
				add_action('admin_notices', 'wp_rem_cs_show_theme_auto_update_error');
			} else {
				add_option('last_time_auto_theme_update_checked_' . THEME_NAME, time());
				// Get current theme version.
				$my_theme = wp_get_theme();
				$active_theme_version = $my_theme->get('Version');

				$is_update_theme = false;
				if ( ! empty($themes) && is_array($themes) ) {
					foreach ( $themes as $theme ) {
						if ( THEME_ENVATO_ID == $theme->item_id ) {
							$latest_version = $theme->version;
							$item_id = $theme->item_id;
							$theme_name = $theme->item_name;
							if ( version_compare($active_theme_version, $latest_version, '<') ) {
								$is_update_theme = true;
							}
							break;
						}
					}
					if ( $is_update_theme ) {
						$option_name = 'is_auto_update_theme_' . THEME_NAME;
						$data = array(
							'item_id' => $item_id,
							'latest_version' => $latest_version,
							'theme_name' => $theme_name,
						);
						if ( get_option($option_name) ) {
							update_option($option_name, $data);
						} else {
							add_option($option_name, $data);
						}
						add_action('admin_notices', 'wp_rem_cs_show_theme_auto_update_available');
					}
				}
			}
		} else {
			add_action('admin_notices', 'wp_rem_cs_show_theme_auto_update_warning');
		}
	}

// End Function.
} // End If.

if ( ! function_exists('wp_rem_cs_show_theme_auto_update_available_on_themes_page') ) {

	/**
	 * Show theme update available on themes page, Ouput JS to footer of themes.php page.
	 */
	function wp_rem_cs_show_theme_auto_update_available_on_themes_page() {
		// This is a hack to show Update notification on Theme on Themes.php Listing Page
		// On click of update label it will use Auto Updater to update plugin.
		$msg = '<script type="text/javascript">
				(function($){
					$(document).ready(function() { 
						setTimeout(
							function() {
								$(".theme #' . THEME_NAME . '-name").parent().append(\'<div class="theme-update">Update Available</div>\');
								$(".theme-update", $(".theme #' . THEME_NAME . '-name").parent()).click(function(event) {
									event.stopPropagation();
									$(".btnConfirmThemeUpgrade").trigger("click");
								});
							}, 
						0);
					});
				})(jQuery);
				</script>';
		echo $msg;
	}

}

if ( ! function_exists('wp_rem_cs_show_theme_auto_update_available') ) {

	/**
	 * Show notification if an update is avaiable.
	 */
	function wp_rem_cs_show_theme_auto_update_available() {
		$data = get_option('is_auto_update_theme_' . THEME_NAME);
		if ( $data ) {
			$class = 'notice notice-warning is-dismissible';
			$plugins = get_plugins_to_be_updated();
			$affected_plugins = array();
			foreach ( $plugins as $key => $val ) {
				array_push($affected_plugins, $val['name'] . ' Plugin');
			}
			array_unshift($affected_plugins, ucfirst(THEME_NAME) . ' Theme');
			$affected_packages = '<ul><li>' . implode('</li><li>', $affected_plugins) . '</li></ul>';
			$popup_message = '<h1 style=\'color: #ff2e2e; margin-top: 0; float: none;\'>Warning!!!</h1> By upgrading you will loose all changes you have made to:<br>' . $affected_packages;
			$popup = '
				<script type="text/javascript">
					var html_popup1 = "<div id=\'confirmOverlay\' style=\'display:block\'><div id=\'confirmBox\'>";
					html_popup1 += "<div id=\'confirmText\' style=\'padding-left: 20px; padding-right: 20px;\'>' . $popup_message . '</div>";
					html_popup1 += "<div id=\'confirmButtons\'><div class=\'button confirm-yes\'>Upgrade</div><div class=\'button confirm-no\'>Cancel</div><br class=\'clear\'></div></div></div>";
					
					(function($){
						$(function() {
							$(".btnConfirmThemeUpgrade").click(function() {
								$(this).parent().append(html_popup1);

								$(".confirm-yes").click(function() {
									window.location = "' . network_admin_url('admin.php?page=' . THEME_OPTIONS_PAGE_SLUG . '&action=upgrade_theme&time=' . time()) . '#tab-auto-updater-show";
									$("#confirmOverlay").remove();
								});
								$(".confirm-no").click(function() {
									$("#confirmOverlay").remove();
								});
								return false;
							});
						});
					})(jQuery);
				</script>';
			$message = 'A new version "' . $data['theme_name'] . ' ' . $data['latest_version'] . '" theme is available. &raquo; <a href="#" class="btnConfirmThemeUpgrade">Please Upgrade Now</a>' . $popup;
			printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
		}
	}

}

if ( ! function_exists('wp_rem_cs_show_theme_auto_update_error') ) {

	/**
	 * Show error if marketplace username or secret API keys is not valid.
	 */
	function wp_rem_cs_show_theme_auto_update_error() {
		$class = 'notice notice-error is-dismissible';
		$message = __('Please provide valid Marketplace Username and Secret API Key in theme options to get Automatic Theme Updates.  &raquo; <a href="' . network_admin_url('admin.php?page=' . THEME_OPTIONS_PAGE_SLUG) . '#tab-auto-updater-show">Fix Now</a>', 'wp-rem-frame');

		printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
	}

}

if ( ! function_exists('wp_rem_cs_show_theme_auto_update_warning') ) {

	/**
	 * Show Warning if auto updates are not configured.
	 */
	function wp_rem_cs_show_theme_auto_update_warning() {
		if ( false === ( $admin_dismiss_notice = get_transient('admin_dismiss_notice') ) ) {
			$class = 'notice notice-warning is-dismissible';
			$message = __('Please configure Auto Updates in theme options to get Automatic Theme Updates. &raquo; <a href="' . network_admin_url('admin.php?page=' . THEME_OPTIONS_PAGE_SLUG) . '#tab-auto-updater-show">Configure Now</a>', 'wp-rem-frame');

			$ajax_url = admin_url('admin-ajax.php');
			printf( '<div class="%1$s" data-ajax-url="%2$s"><p>%3$s</p></div>', $class, $ajax_url, $message );
		}
	}

}

if ( ! function_exists('wp_rem_cs_auto_upgrade_theme_and_plugins') ) {

	/**
	 * Upgrade theme by downloading it from Envato and also keep backup of current theme.
	 *
	 * @return	array	Details about the theme and plugins updated
	 */
	function wp_rem_cs_auto_upgrade_theme_and_plugins() {
		global $wp_rem_cs_options, $current_screen, $cs_theme_upgraded_name, $cs_plugins_upgraded;

		// Skip if current user is not allowed to update theme.
		if ( ! current_user_can('update_themes') ) {
			return;
		}
		// Skip if marketplace details not available.
		if ( empty($wp_rem_cs_options['cs_marketplace_username']) ) {
			return;
		}
		// Skip if update theme details not available.
		$theme_info = get_option('is_auto_update_theme_' . THEME_NAME);
		if ( ! $theme_info ) {
			return;
		}

		// Upgrade Theme.
		$theme_info['user_name'] = $wp_rem_cs_options['cs_marketplace_username'];
		$theme_info['api_key'] = $wp_rem_cs_options['cs_secret_api_key'];
		$theme_info['skip_backup'] = $wp_rem_cs_options['cs_skip_theme_backup'];
		$status = true;
		$status = wp_rem_cs_auto_update_theme($theme_info);

		// Upgrade Plugins.
		if ( function_exists('get_plugins_to_be_updated') ) {
			wp_rem_cs_auto_update_plugins(get_plugins_to_be_updated());
		}

		if ( $status ) {
			// Delete option after upgrade.
			delete_option('is_auto_update_theme_' . THEME_NAME);

			return array( 'cs_theme_upgraded_name' => $cs_theme_upgraded_name, 'cs_plugins_upgraded' => $cs_plugins_upgraded );
		} else {
			return array();
		}
	}

// End Function.
} // End If.

if ( ! function_exists('wp_rem_cs_auto_update_theme') ) {

	/**
	 * Update theme
	 *
	 * @param array $theme_info	Contain information related to theme and Envato API.
	 * @return	boolean	Whether theme get upgraded or not
	 */
	function wp_rem_cs_auto_update_theme($theme_info) {
		global $cs_theme_upgraded_name;
		$user_name = $theme_info['user_name'];
		$api_key = $theme_info['api_key'];
		$skip_backup = $theme_info['skip_backup'];
		$item_id = $theme_info['item_id'];
		$theme = $theme_info['theme_name'];

		require_once trailingslashit(CS_BASE) . 'include/backend/cs-importer-helper/class-envato-api.php';
		$protected_api = new Envato_Protected_API($user_name, $api_key);

		$title = __('Update Theme', 'wp-rem-frame');
		$nonce = 'upgrade-theme_' . $theme;
		$url = network_admin_url('admin.php?page=' . THEME_OPTIONS_PAGE_SLUG . '#tab-auto-updater-show');

		/*
		 * Trick WP into thinking it's the themes page for the icon32
		 */

		/* Create backup if not skipped */
		if ( ! $skip_backup ) {
			wp_rem_cs_backup_theme($theme);
		}

		require_once trailingslashit(CS_BASE) . 'include/backend/cs-importer-helper/class-wp-upgrader.php';

		/*
		 * new Envato_Theme_Upgrader
		 */
		$upgrader = new Envato_Theme_Upgrader(new Theme_Upgrader_Skin(compact('title', 'nonce', 'url', 'theme')));

		$url = $protected_api->wp_download($item_id);
		if ( ! empty($url) && is_array($url) ) {
			die('Please, provide valid Marketplace username and Secret API key.');
		}

		/*
		 * fetch file in wploads to create small path
		 */
		global $wp_filesystem;
		$paths = wp_upload_dir();
		$wp_upload_url = trailingslashit($paths['url']);
		$wp_upload_dir = trailingslashit($paths['path']);
		$content = $wp_filesystem->get_contents($url);
		$file_name = basename($url);
		$file_name = current(explode('?', $file_name));
		$wp_file_path = $wp_upload_dir . $file_name;
		$new_url = $wp_upload_url . $file_name;
		$wp_filesystem->put_contents($wp_file_path, $content);

		// Upgrade the theme.
		$status = $upgrader->upgrade($theme, $new_url);

		$cs_theme_upgraded_name = $theme;

		// Delete local theme archive.
		unlink($wp_file_path);

		return true;
	}

}

if ( ! function_exists('wp_rem_cs_auto_update_plugins') ) {

	/**
	 * Update plugins
	 *
	 * @param	array $plugins	Plugins to be updated.
	 * @return	boolean	Whether plugins upgraded or not
	 */
	function wp_rem_cs_auto_update_plugins($plugins) {
		global $cs_plugins_upgraded;
		if ( ! class_exists('Plugin_Upgrader') ) {
			include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
		}
		$active_plugins = get_plugins();
		$active_plugins_paths = array();
		foreach ( $active_plugins as $key => $plugin ) {
			$plugin_slug = dirname($key);
			$active_plugins_paths[$plugin_slug] = $key;
		}

		foreach ( $plugins as $key => $plugin_info ) {
			if ( '' != $plugin_info['slug'] ) {
				// Delete plugin before upgrade.
				if ( array_key_exists($plugin_info['slug'], $active_plugins_paths) ) {
					delete_plugins(array( $active_plugins_paths[$plugin_info['slug']] ));
				}

				// If we arrive here, we have the filesystem.
				wp_rem_cs_include_file(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php'); // Need for upgrade classes.

				$plugin = array();
				$plugin['slug'] = $plugin_info['slug']; // Needed for potentially renaming of wp_rem_cs name.
				$plugin['name'] = $plugin_info['name'];
				$source = $plugin_info['source'];

				// Prep variables for Plugin_Installer_Skin class.
				$url = add_query_arg(
						array(
					'action' => 'install-plugin',
					'plugin' => urlencode($plugin['slug']),
						), 'update.php'
				);

				// Create a new instance of Plugin_Upgrader.
				$upgrader = new Plugin_Upgrader(
						new Plugin_Installer_Skin(
						array(
					'type' => 'web',
					'title' => sprintf('Installing %s plugin', $plugin['name']),
					'url' => esc_url_raw($url),
					'nonce' => 'install-plugin_' . $plugin['slug'],
					'plugin' => $plugin,
						)
						)
				);
				$upgrader->install($source);

				$plugin_activate = $upgrader->plugin_info(); // Grab the plugin info from the Plugin_Upgrader method.
				if ( ! is_plugin_active($plugin_activate) ) {
					$activate = activate_plugin($plugin_activate); // Activate the plugin.

					if ( is_wp_error($activate) ) {
						// Unable to activate.
					}
				}

				array_push($cs_plugins_upgraded, $plugin['name'] . ' Plugin');
			}
		}
		return true;
	}

// End Function.
} // End If.

if ( ! function_exists('wp_rem_cs_backup_theme') ) {

	/**
	 * Backup specified theme in a zip
	 *
	 * @param	string $theme	Theme slug to be backed up.
	 * @return	boolean	Whether theme backup was successful
	 */
	function wp_rem_cs_backup_theme($theme) {
		$backup_errors = array();

		require_once trailingslashit(CS_BASE) . 'include/backend/cs-importer-helper/class-envato-backup.php';
		$theme_backup = Envato_Backup::get_instance();

		$theme_backup->path = AUTO_UPGRADE_BACKUP_DIR;

		$theme_backup->root = get_template_directory();

		$theme_backup->archive_filename = strtolower(sanitize_file_name($theme . '.backup.' . date('Y-m-d-H-i-s', time() + ( current_time('timestamp') - time() )) . '.zip'));

		if ( ( ! is_dir($theme_backup->path()) && ( ! is_writable(dirname($theme_backup->path())) || ! mkdir($theme_backup->path()) ) ) || ! is_writable($theme_backup->path()) ) {
			array_push($backup_errors, 'Invalid backup path');
			return false;
		}

		if ( ! is_dir($theme_backup->root()) || ! is_readable($theme_backup->root()) ) {
			array_push($backup_errors, 'Invalid root path');
			return false;
		}

		$theme_backup->backup();

		if ( file_exists(Envato_Backup::get_instance()->archive_filepath()) ) {
			return true;
		} else {
			return $backup_errors;
		}
	}

}