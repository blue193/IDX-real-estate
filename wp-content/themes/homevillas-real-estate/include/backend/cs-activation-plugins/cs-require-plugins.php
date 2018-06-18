<?php

/*
 * tgm class for 
 * (internal and WordPress repository) 
 * plugin activation start
 */

wp_rem_cs_include_file(trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/cs-plugin-activation.php');

if (!function_exists('wp_rem_cs_var_register_required_plugins')) {
    add_action('tgmpa_register', 'wp_rem_cs_var_register_required_plugins');

    function wp_rem_cs_var_register_required_plugins() {
        global $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_plugin_activation_strings();


        /*
         * Array of plugin arrays. Required keys are name and slug.
         * If the source is NOT from the .org repo, then source is also required.
         */

        $plugins = array(
            /*
             * This is an example of how to include a plugin from the WordPress Plugin Repository.
             */
            array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_revolution_slider'),
                'slug' => 'revslider',
                'source' => '' . wp_rem_cs_server_protocol() . 'chimpgroup.com/wp-demo/download-plugin/revslider.zip',
                'required' => true,
                'version' => '5.4',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_framework'),
                'slug' => 'real-estate-framework',
                'source' => trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/real-estate-framework.zip',
                'required' => true,
                'version' => '1.3',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_wp_rem'),
                'slug' => 'wp-realestate-manager',
                'source' => trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/wp-realestate-manager.zip',
                'required' => true,
                'version' => '1.3',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
			array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_manager'),
                'slug' => 'cs-icons-manager',
                'source' => trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/cs-icons-manager.zip',
                'required' => true,
                'version' => '1.0',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
            array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_loco_translate'),
                'slug' => 'loco-translate',
                'required' => true,
                'version' => '',
                'force_activation' => false,
                'force_deactivation' => false,
                'external_url' => '',
            ),
        );

        /*
         * Change this to your theme text domain, used for internationalising strings
         */
        $theme_text_domain = 'homevillas-real-estate';
        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
            'domain' => 'homevillas-real-estate', /* Text domain - likely want to be the same as your theme. */
            'default_path' => '', /* Default absolute path to pre-packaged plugins */
            'parent_slug' => 'themes.php', /* Default parent menu slug */
            'menu' => 'install-required-plugins', /* Menu slug */
            'has_notices' => true, /* Show admin notices or not */
            'is_automatic' => true, /* Automatically activate plugins after installation or not */
            'message' => '', /* Message to output right before the plugins table */
            'strings' => array(
                'page_title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_install_require_plugins'),
                'menu_title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_install_plugins'),
                'installing' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_installing_plugins'), /* %1$s = plugin name */
                'oops' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_wrong'),
                'notice_can_install_required' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_notice_can_install_required'), /* %1$s = plugin name(s) */
                'notice_can_install_recommended' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_notice_can_install_recommended'), /* %1$s = plugin name(s) */
                'notice_cannot_install' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sorry'), /* %1$s = plugin name(s) */
                'notice_can_activate_required' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_notice_can_activate_required'), /* %1$s = plugin name(s) */
                'notice_can_activate_recommended' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_notice_can_activate_recommended'), /* %1$s = plugin name(s) */
                'notice_cannot_activate' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sorry_not_permission'), /* %1$s = plugin name(s) */
                'notice_ask_to_update' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_notice_can_activate_recommended'), /* %1$s = plugin name(s) */
                'notice_cannot_update' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sorry_updated'), /* %1$s = plugin name(s) */
                'install_link' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_install_link'),
                'activate_link' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_activate_installed'),
                'return' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_return'),
                'plugin_activated' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_activation_success'),
                'complete' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_complete'), /* %1$s = dashboard link */
                'nag_type' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_updated'), /* Determines admin notice type - can only be 'updated' or 'error' */
            )
        );
        tgmpa($plugins, $config);
    }

}