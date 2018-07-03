<?php

/**
 * The template for displaying single property
 *
 */
get_header();
global $post, $wp_rem_plugin_options, $wp_rem_theme_options, $wp_rem_post_property_types, $wp_rem_plugin_options;
$post_id = $post->ID;

$wp_rem_single_view = wp_rem_property_detail_page_view($post_id);
if( $wp_rem_single_view == '' ){
	$wp_rem_single_view = 'detail_view1';
}

if ( $wp_rem_single_view == 'detail_view1' ) {
	wp_rem_get_template_part('property', 'view1', 'single-property');
} elseif ( $wp_rem_single_view == 'detail_view2' ) {
	wp_rem_get_template_part('property', 'view2', 'single-property');
} elseif ( $wp_rem_single_view == 'detail_view3' || $wp_rem_single_view == 'detail_view4' ) {
	wp_rem_get_template_part('property', 'view3', 'single-property');
}

get_footer();
