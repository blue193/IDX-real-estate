<?php
global $wp_rem_settings_init;

require_once ABSPATH . '/wp-admin/includes/file.php';

// Home Demo
$wp_rem_demo = wp_rem_get_settings_demo('demo.json');

$wp_rem_settings_init = array(
	"plugin_options" => $wp_rem_demo,
);