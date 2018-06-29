<?php
$var_arrays = array( 'wp_rem_cs_var_home', 'wp_rem_cs_var_demo' );
$theme_option_array_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing( $var_arrays );
extract( $theme_option_array_global_vars );

$home_demo = wp_rem_cs_var_get_demo_content( 'home.json' );

$wp_rem_cs_page_option[] = array();
$wp_rem_cs_page_option['theme_options'] = array(
    'select' => array(
        'home' => isset( $wp_rem_cs_var_home ) ? $wp_rem_cs_var_home : '',
    ),
    'home' => array(
        'name' => isset( $wp_rem_cs_var_demo ) ? $wp_rem_cs_var_demo : '',
        'page_slug' => 'home',
        'theme_option' => $home_demo,
        'thumb' => 'Import-Dummy-Data'
    ),
);