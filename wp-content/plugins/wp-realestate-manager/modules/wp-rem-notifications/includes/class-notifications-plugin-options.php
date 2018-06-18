<?php

/**
 * Create Custom Post Type and it's meta boxes for Property Alert Notifications
 *
 * @package	Homevillas
 */
// Direct access not allowed.
if ( ! defined('ABSPATH') ) {
    exit;
}

if ( ! function_exists('create_plugin_options') ) {

    /**
     * Create Plugin Options
     */
    function create_plugin_options($wp_rem_setting_options) {
        $on_off_option = array( 'yes' => wp_rem_plugin_text_srt('wp_rem_yes'), 'no' => wp_rem_plugin_text_srt('wp_rem_no') );

        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_property_alerts'),
            "fontawesome" => 'icon-bell-o',
            "id" => 'tab-property-alert-settings',
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_property_alerts'),
            "id" => "tab-property-alert-settings",
            "extra" => 'class="wp_rem_tab_block" data-title="' . wp_rem_plugin_text_srt('wp_rem_notifications_property_alerts') . '"',
            "type" => "sub-heading"
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_alert_frequencies'),
            "id" => "tab-user-alert-frequency",
            "std" => wp_rem_plugin_text_srt('wp_rem_notifications_frequency'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_setting_options[] = array(
            'name' => '',
            'id' => '',
            'std' => wp_rem_plugin_text_srt('wp_rem_notifications_announcements'),
            'type' => 'announcement',
            'options' => ''
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_annually'),
            "desc" => "",
            "hint_text" => '',
            "label_desc" => wp_rem_plugin_text_srt('wp_rem_notifications_annually_hint'),
            "id" => "frequency_annually",
            "std" => "",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_biannually'),
            "desc" => "",
            "hint_text" => '',
			"label_desc" => wp_rem_plugin_text_srt('wp_rem_notifications_biannually_hint'),
            "id" => "frequency_biannually",
            "std" => "",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_monthly'),
            "desc" => "",
            "hint_text" => '',
			"label_desc" => wp_rem_plugin_text_srt('wp_rem_notifications_monthly_hint'),
            "id" => "frequency_monthly",
            "std" => "",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_fortnightly'),
            "desc" => "",
            "hint_text" => '',
			"label_desc" => wp_rem_plugin_text_srt('wp_rem_notifications_fortnightly_hint'),
            "id" => "frequency_fortnightly",
            "std" => "",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_weekly'),
            "desc" => "",
            "hint_text" => '',
			"label_desc" => wp_rem_plugin_text_srt('wp_rem_notifications_weekly_hint'),
            "id" => "frequency_weekly",
            "std" => "",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $wp_rem_setting_options[] = array(
            "name" => wp_rem_plugin_text_srt('wp_rem_notifications_daily'),
            "desc" => "",
            "hint_text" => '',
			"label_desc" => wp_rem_plugin_text_srt('wp_rem_notifications_daily_hint'),
            "id" => "frequency_daily",
            "std" => "",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $wp_rem_setting_options[] = array(
            "col_heading" => wp_rem_plugin_text_srt('wp_rem_notifications_property_alerts'),
            "type" => "col-right-text",
            "help_text" => ""
        );

        return $wp_rem_setting_options;
    }

}
// Add Plugin Options
add_filter('wp_rem_notification_plugin_settings', 'create_plugin_options', 10, 1);


if ( ! function_exists('wp_rem_properties_shortcode_admin_fields_callback') ) {

    /**
     * Add Option to enable/disable 'Email me property like these' button 'Property Options Shortcode Element Settings'
     */
    function wp_rem_properties_shortcode_admin_fields_callback($attrs) {
        global $wp_rem_html_fields;

        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_notifications_property_alert_shortcode'),
            'desc' => '',
            'hint_text' => '',
            'label_desc' => wp_rem_plugin_text_srt('wp_rem_notifications_property_alert_shortcode_hint'),
            'echo' => true,
            'field_params' => array(
                'std' => $attrs['property_alert_button'],
                'id' => 'property_alert_button[]',
                'cust_name' => 'property_alert_button[]',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'enable' => wp_rem_plugin_text_srt('wp_rem_notifications_property_alert_shortcode_enable'),
                    'disable' => wp_rem_plugin_text_srt('wp_rem_notifications_property_alert_shortcode_disable'),
                ),
                'return' => true,
            ),
        );

        $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
    }

}
// Add Option to enable/disable 'Email me property like these' button 'Property Options Shortcode Element Settings'
add_action('wp_rem_properties_shortcode_admin_fields', 'wp_rem_properties_shortcode_admin_fields_callback', 10, 1);


if ( ! function_exists('wp_rem_save_properties_shortcode_admin_fields_callback') ) {

    /**
     * Save Option to enable/disable 'Email me property like these' button 'Property Options Shortcode Element Settings'
     */
    function wp_rem_save_properties_shortcode_admin_fields_callback($shortcode, $data, $wp_rem_counter_property) {

        if ( isset($data['property_alert_button'][$wp_rem_counter_property]) && $data['property_alert_button'][$wp_rem_counter_property] != '' ) {
            $shortcode .= 'property_alert_button="' . htmlspecialchars($data['property_alert_button'][$wp_rem_counter_property]) . '" ';
        }
        return $shortcode;
    }

}
// Add Plugin Options
add_filter('wp_rem_save_properties_shortcode_admin_fields', 'wp_rem_save_properties_shortcode_admin_fields_callback', 10, 3);


if ( ! function_exists('wp_rem_properties_shortcode_admin_default_attributes_callback') ) {

    /**
     * Set default Option to enable/disable 'Email me property like these' button 'Property Options Shortcode Element Settings'
     */
    function wp_rem_properties_shortcode_admin_default_attributes_callback($defaults) {
        $defaults['property_alert_button'] = 'enable';
        return $defaults;
    }

}
// Register default variable on backend
add_filter('wp_rem_properties_shortcode_admin_default_attributes', 'wp_rem_properties_shortcode_admin_default_attributes_callback', 10, 1);
// Register default variable on frontend
add_filter('wp_rem_properties_shortcode_frontend_default_attributes', 'wp_rem_properties_shortcode_admin_default_attributes_callback', 10, 1);
