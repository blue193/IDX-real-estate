<?php

/**
 * Static string 2
 */
if ( ! class_exists('wp_rem_cs_theme_all_strings_2') ) {

    class wp_rem_cs_theme_all_strings_2 {

        public function __construct() {
            add_filter('wp_rem_cs_theme_option_strings', array( $this, 'wp_rem_cs_theme_option_strings_callback' ), 1);
            add_filter('wp_rem_cs_theme_option_field_strings', array( $this, 'wp_rem_cs_theme_option_field_strings_callback' ), 1);
            add_filter('wp_rem_cs_plugin_activation_strings', array( $this, 'wp_rem_cs_plugin_activation_strings_callback' ), 1);
            add_filter('wp_rem_cs_short_code_strings', array( $this, 'wp_rem_cs_short_code_strings_callback' ), 1);
            add_filter('wp_rem_cs_theme_strings', array( $this, 'wp_rem_cs_theme_strings_callback' ), 1);
        }

        public function wp_rem_cs_theme_option_strings_callback($wp_rem_cs_var_static_text) {
            global $wp_rem_cs_var_static_text;

            $wp_rem_cs_var_static_text['wp_rem_post_pass_protected'] = esc_html__('This post is password protected. To view it please enter your password below:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_auto_update'] = esc_html__('Auto Update', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_auto_update_theme'] = esc_html__('Auto Update Theme', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_automatic_upgrade'] = esc_html__('Automatic Upgrade', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_marketplace_username'] = esc_html__('Marketplace Username', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_marketplace_username_hint'] = esc_html__('Enter your Marketplace Username.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_secret_api_key'] = esc_html__('Secret API Key', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_secret_api_key_hint'] = esc_html__('Enter your Secret API key.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_skip_theme_backup'] = esc_html__('Skip Theme Backup', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_skip_theme_backup_hint'] = esc_html__('Do you want to skip theme backup?', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_'] = esc_html__('Auto', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_client_logo_error'] = esc_html__('Please add client logo first.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_social_sharing_error'] = esc_html__('Please fill all mandatory fields.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_theme_option_sidebar_error'] = esc_html__('Please fill sidebar name field.', 'homevillas-real-estate');

            return $wp_rem_cs_var_static_text;
        }

        public function wp_rem_cs_theme_option_field_strings_callback($wp_rem_cs_var_static_text) {
            global $wp_rem_cs_var_static_text;

            return $wp_rem_cs_var_static_text;
        }

        public function wp_rem_cs_plugin_activation_strings_callback($wp_rem_cs_var_static_text) {
            global $wp_rem_cs_var_static_text;
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_min_php_version'] = esc_html__('Minimum PHP Version', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_min_php_version_desc'] = esc_html__('To run this theme properly, mentioned minium PHP version is required.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_available'] = esc_html__('Available', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_max_data'] = esc_html__('Sets max size of post data allowed. This setting also affects file upload.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_max_file_size'] = esc_html__('The maximum size of a file that can be uploaded.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_max_amount_memory'] = esc_html__('This sets the maximum amount of memory that a script is allowed to allocate.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_download_import_data'] = esc_html__('To download import data this option is required.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_should_be_enabled'] = esc_html__('should be enabled in', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_framework_title'] = esc_html__('Real Estate Framework', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_framework_desc'] = esc_html__('This plugin is required as this handles the core functionality of the theme.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_realestate_manager_title'] = esc_html__('WP Real Estate Manager', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_realestate_manager_desc'] = esc_html__('This plugin is required as this handles all functionality related to real estate manager etc.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_rev_slider_title'] = esc_html__('Revolution Slider', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_config_rev_slider_desc'] = esc_html__('This plugin is required to import Revolution sliders from demo data.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_install_req_plugins'] = esc_html__('Install Required Plugins', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installing_plugins'] = esc_html__('Install Plugins', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installing_plugin_with_col'] = esc_html__('Installing Plugin: %s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_updating_plugin_with_col'] = esc_html__('Updating Plugin: %s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_api_error'] = esc_html__('Something went wrong with the plugin API.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_return_required_plugins'] = esc_html__('Return to Required Plugins Installer', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_return_to_dashboard'] = esc_html__('Return to the Dashboard', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_activated_successfully'] = esc_html__('Plugin activated successfully.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_following_plugin_activated'] = esc_html__('The following plugin was activated successfully:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_already_active'] = esc_html__('No action taken. Plugin %1$s was already active.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_not_activated'] = esc_html__('Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_all_plugins_installed'] = esc_html__('All plugins installed and activated successfully. %1$s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_dismiss_this_notice'] = esc_html__('Dismiss this notice', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_one_or_more_required'] = esc_html__('There are one or more required or recommended plugins to install, update or activate.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_contact_site_admin'] = esc_html__('Please contact the administrator of this site for help.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_need_update_for_compatible'] = esc_html__('This plugin needs to be updated to be compatible with your theme.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_update_required'] = esc_html__('Update Required', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_rename_failed'] = esc_html__('The remote plugin package does not contain a folder with the desired slug and renaming did not work.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_packaged_wrong'] = esc_html__('The remote plugin package consists of more than one file, but the files are not packaged in a folder.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_contact_plugin_provider'] = esc_html__('Please contact the plugin provider and ask them to package their plugin according to the WordPress guidelines.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_required'] = esc_html__('Required', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_recommended'] = esc_html__('Recommended', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_wp_repository'] = esc_html__('WordPress Repository', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_external_source'] = esc_html__('External Source', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_pre_packaged'] = esc_html__('Pre-Packaged', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_not_installed'] = esc_html__('Not Installed', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installed_not_activated'] = esc_html__('Installed But Not Activated', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_active'] = esc_html__('Active', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_require_update_not_available'] = esc_html__('Required Update not Available', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_requires_update'] = esc_html__('Requires Update', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_update_recommended'] = esc_html__('Update recommended', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installed_version'] = esc_html__('Installed version:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_minimum_required_version'] = esc_html__('Minimum required version:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_available_version'] = esc_html__('Available version:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_no_plugins_to_install'] = esc_html__('No plugins to install, update or activate.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin'] = esc_html__('Plugin', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_source'] = esc_html__('Source', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_type'] = esc_html__('Type', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_version'] = esc_html__('Version', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_status'] = esc_html__('Status', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_install_with_value'] = esc_html__('Install %2$s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_update_with_value'] = esc_html__('Update %2$s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_activate_with_value'] = esc_html__('Activate %2$s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_upgrade_msg_with_author'] = esc_html__('Upgrade message from the plugin author:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_install'] = esc_html__('Install', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_update'] = esc_html__('Update', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_activate'] = esc_html__('Activate', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_no_plugin_selected_to_be_installed'] = esc_html__('No plugins were selected to be installed. No action taken.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_no_plugin_selected_to_be_updated'] = esc_html__('No plugins were selected to be updated. No action taken.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_no_plugin_available_to_be_installed'] = esc_html__('No plugins are available to be installed at this time.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_no_plugin_available_to_be_updated'] = esc_html__('No plugins are available to be updated at this time.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_no_plugin_selected_to_be_activated'] = esc_html__('No plugins were selected to be activated. No action taken.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_no_plugin_available_to_be_activated'] = esc_html__('No plugins are available to be activated at this time.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_activation_failed'] = esc_html__('Plugin activation failed.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_activated_successfully'] = esc_html__('Plugin activated successfully.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_updating_plugin'] = esc_html__('Updating Plugin', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_error_occurred'] = esc_html__('An error occurred while installing', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installation_failed'] = esc_html__('The installation of %1$s failed.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installation_activation_proccess'] = esc_html__('The installation and activation process is starting. This process may take a while on some hosts, so please be patient.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installed_activated_successfully'] = esc_html__('%1$s installed and activated successfully.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_show_details'] = esc_html__('Show Details', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_hide_details'] = esc_html__('Hide Details', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installations_activations_completed'] = esc_html__('All installations and activations have been completed.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installing_and_activating_plugin'] = esc_html__('Installing and Activating Plugin %1$s (%2$d/%3$d)', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installation_proccess'] = esc_html__('The installation process is starting. This process may take a while on some hosts, so please be patient.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installed_successfully'] = esc_html__('%1$s installed successfully.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_all_installations_completed'] = esc_html__('All installations have been completed.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_installing_plugin'] = esc_html__('Installing Plugin', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_tgmpa_version'] = esc_html__('TGMPA v%s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_install_update_status'] = esc_html_x('%1$s, %2$s', 'Install/Update Status', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_unknown'] = esc_html_x('unknown', 'as in: "version nr unknown"', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_a_and_b'] = esc_html_x('and', 'plugin A *and* plugin B', 'homevillas-real-estate');

            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_all'] = esc_html__('All', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_to_install'] = esc_html__('To Install', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_update_available'] = esc_html__('Update Available', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_to_activate'] = esc_html__('To Activate', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugin_was_activated'] = esc_html__('The following plugin was activated successfully:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_activation_plugins_were_activated'] = esc_html__('The following plugins were activated successfully:', 'homevillas-real-estate');
			
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo1_label'] = esc_html__('Homevillas Real Estate', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo2_label'] = esc_html__('Home v2', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo3_label'] = esc_html__('Home v3', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo4_label'] = esc_html__('Home v4', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo5_label'] = esc_html__('Home v5', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo6_label'] = esc_html__('Home v6', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo7_label'] = esc_html__('Home v7', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo8_label'] = esc_html__('Home v8', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo9_label'] = esc_html__('Home v9', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo10_label'] = esc_html__('Home v10', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo11_label'] = esc_html__('Home v11', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo12_label'] = esc_html__('Home v12', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo13_label'] = esc_html__('Home v13', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo14_label'] = esc_html__('Home v14', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo15_label'] = esc_html__('Home v15', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_demo16_label'] = esc_html__('Home v16', 'homevillas-real-estate');
			$wp_rem_cs_var_static_text['wp_rem_cs_var_rtl_label'] = esc_html__('RTL Demo', 'homevillas-real-estate');
            

            /*
             * Meta Strings
             */
            $wp_rem_cs_var_static_text['wp_rem_cs_var_meta_category'] = esc_html__('Category:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_meta_categories'] = esc_html__('Categories:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_meta_tag'] = esc_html__('Tag:', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_meta_tags'] = esc_html__('Tags:', 'homevillas-real-estate');

            $wp_rem_cs_var_static_text['wp_rem_cs_var_rating_rating'] = esc_html__('based on %s customer rating', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_rating_ratings'] = esc_html__('based on %s customer ratings', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_rating_reviews'] = esc_html__('Reviews', 'homevillas-real-estate');

            return $wp_rem_cs_var_static_text;
        }

        public function wp_rem_cs_short_code_strings_callback($wp_rem_cs_var_static_text) {
            global $wp_rem_cs_var_static_text;

            return $wp_rem_cs_var_static_text;
        }

        public function wp_rem_cs_theme_strings_callback($wp_rem_cs_var_static_text) {
            global $wp_rem_cs_var_static_text;

            // Start Woocommerce.
            $wp_rem_cs_var_static_text['wp_rem_wooc_product_dec'] = esc_html__('Product Description', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_wooc_additional_information'] = esc_html__('Additional Information', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_wooc_out_of_rating'] = esc_html__('out of %s5%s', 'homevillas-real-estate');
            // End Woocommerce.
            // Start Fancy Menu Widget.
            $wp_rem_cs_var_static_text['wp_rem_fancymenu_widget_heading'] = esc_html__('Fancy Menu', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_fancymenu_widget_desc'] = esc_html__('Menu List', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_fancymenu_widget_no_menu_created'] = esc_html__('No menus have been created yet.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_fancymenu_widget_create_some'] = esc_html__('Create some', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_fancymenu_widget_title'] = esc_html__('Title', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_fancymenu_widget_menu'] = esc_html__('Menu', 'homevillas-real-estate');
            // Start Fancy Menu Widget.
            // Start Common.
            $wp_rem_cs_var_static_text['wp_rem_cs_var_submit'] = esc_html__('Submit', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_ago'] = esc_html__('ago', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_reply'] = esc_html__('Reply', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_facebook'] = esc_html__('facebook', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_twitter'] = esc_html__('twitter', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_google_plus'] = esc_html__('google+', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_tumbler'] = esc_html__('tumbler', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_dribble'] = esc_html__('dribble', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_stumbleupon'] = esc_html__('stumbleupon', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_content'] = esc_html__('Content', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_remove'] = esc_html__('Remove', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_categories'] = esc_html__('Categories', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_select_categories'] = esc_html__('-- Select Categories --', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_title'] = esc_html__('Title', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_mega_menu_view'] = esc_html__('Mega Menu View', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_mega_menu_view_simple'] = esc_html__('Simple', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_active_mega_menu'] = esc_html__('Active Mega Menu', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_on'] = esc_html__('on', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_featured'] = esc_html__('Featured', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_views'] = esc_html__('Views', 'homevillas-real-estate');
            // End Common.
            // Start Custom Walker.
            $wp_rem_cs_var_static_text['wp_rem_cs_var_eng'] = esc_html__('eng', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_france'] = esc_html__('France', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_germany'] = esc_html__('Germany', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_italy'] = esc_html__('Italy', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_iceland'] = esc_html__('Iceland', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_usd'] = esc_html__('USD', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_uae'] = esc_html__('UAE', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_invalid'] = esc_html__('%s (Invalid)', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_pending'] = esc_html__('%s (Pending)', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_original'] = esc_html__('Original: %s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_move_up'] = esc_html__('Move up', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_move_down'] = esc_html__('Move down', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_edit_menu_item'] = esc_html__('Edit Menu Item', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_url'] = esc_html__('URL', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_navi_label'] = esc_html__('Navigation Label', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_title_attr'] = esc_html__('Title Attribute', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_open_link_new_tab'] = esc_html__('Open link in a new tab', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_css_classes'] = esc_html__('CSS Classes (optional)', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_link_relationship'] = esc_html__('Link Relationship (XFN)', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_description'] = esc_html__('Description', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_item_description_hint'] = esc_html__('The description will be displayed in the menu if the current theme supports it.', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_menu_cancel'] = esc_html__('Cancel', 'homevillas-real-estate');
            // End Custom Walker.
            // Start Tags.
            $wp_rem_cs_var_static_text['wp_rem_cs_var_tags_posted_in'] = esc_html__('Posted in %1$s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_tags_tagged'] = esc_html__('Tagged %1$s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_tags_edit'] = esc_html__('Edit %s', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_tags_leave_comment'] = esc_html__('Leave a Comment', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_tags_posted_on'] = esc_html_x('Posted on %s', 'post date', 'homevillas-real-estate');
            $wp_rem_cs_var_static_text['wp_rem_cs_var_tags_posted_by'] = esc_html_x('by %s', 'post author', 'homevillas-real-estate');
            // End Tags.

            return $wp_rem_cs_var_static_text;
        }

    }

    new wp_rem_cs_theme_all_strings_2;
}
