<?php

/**
 * File Type: Notifications Settings for Homevillas Plugin
 */
if (!class_exists('Wp_rem_Activity_Notifications_Plugin_Settings')) {

    class Wp_rem_Activity_Notifications_Plugin_Settings {

	/**
	 * Start Contructer Function
	 */
	public function __construct() {
	    add_filter( 'wp_rem_activity_notification_plugin_settings', array( &$this, 'wp_rem_activity_notification_plugin_settings_callback' ) );
	}
        
	/**
	 * Add Notification Options in wp_rem plugin backend
         * @ $wp_rem_setting_options contains the current settings
	 */
	public function wp_rem_activity_notification_plugin_settings_callback( $wp_rem_setting_options ) {
            
            $on_off_option = array("show" => "on", "hide" => "off");
            
            
            $wp_rem_setting_options[] = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_activity_notifications_settings'),
                'id' => 'activity-notifications-settings',
                'std' => wp_rem_plugin_text_srt('wp_rem_activity_notifications_settings'),
                'type' => 'section',
                'options' => ''
            );
	    $wp_rem_setting_options[] = array("name" => wp_rem_plugin_text_srt('wp_rem_activity_notifications_heading'),
                "desc" => "",
                "hint_text" => '',
                "id" => "activity_notifications_switch",
                "std" => "on",
                "type" => "checkbox",
                "options" => $on_off_option
            );
            
            return $wp_rem_setting_options;
	}

	// End of class	
    }

    // Initialize Object
    $wp_rem_activity_notifications_plugin_settings = new Wp_rem_Activity_Notifications_Plugin_Settings();
}