<?php

/*
 *
 * @Shortcode Name :  List front end view
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_list_shortcode') ) {

	function wp_rem_cs_var_list_shortcode($atts, $content = "") {
		global $post, $wp_rem_cs_var_list_column, $wp_rem_cs_var_list_type, $wp_rem_cs_var_list_item_icon_color, $wp_rem_cs_var_list_item_icon_bg_color;
		$html = '';
		$page_element_size = isset($atts['list_element_size']) ? $atts['list_element_size'] : 100;
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
		}
		$defaults = array(
			'wp_rem_cs_var_column_size' => '',
			'wp_rem_cs_var_list_title' => '',
			'wp_rem_var_list_align' => '',
			'wp_rem_cs_var_list_sub_title' => '',
			'wp_rem_cs_var_list_type' => '',
			'wp_rem_cs_var_list_item_icon_color' => '',
			'wp_rem_cs_var_list_item_icon_bg_color' => ''
		);
		extract(shortcode_atts($defaults, $atts));

		$wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
		$wp_rem_cs_var_list_title = isset($wp_rem_cs_var_list_title) ? $wp_rem_cs_var_list_title : '';
		$wp_rem_cs_var_list_type = isset($wp_rem_cs_var_list_type) ? $wp_rem_cs_var_list_type : '';
		$wp_rem_cs_var_list_sub_title = isset($wp_rem_cs_var_list_sub_title) ? $wp_rem_cs_var_list_sub_title : '';
		$wp_rem_cs_var_list_item_icon_color = isset($wp_rem_cs_var_list_item_icon_color) ? $wp_rem_cs_var_list_item_icon_color : '';
		$wp_rem_cs_var_list_item_icon_bg_color = isset($wp_rem_cs_var_list_item_icon_bg_color) ? $wp_rem_cs_var_list_item_icon_bg_color : '';

		$wp_rem_cs_section_title = '';



		if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
			if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
				$column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
			}
		}

		if ( isset($column_class) && $column_class <> '' ) {
			$html .= '<div class="' . esc_html($column_class) . '">';
		}
		if ( $wp_rem_cs_var_list_type == 'icon' ) {
			$html .= '<div class="icons-lists">';
		}
		if ( $wp_rem_cs_var_list_type == 'default' ) {
			$html .= '<div class="property-search">';
		}
                $wp_rem_cs_section_title .= wp_rem_title_sub_align($wp_rem_cs_var_list_title, $wp_rem_cs_var_list_sub_title, $wp_rem_var_list_align);
		$html .= $wp_rem_cs_section_title;
		if ( $wp_rem_cs_var_list_type == 'numeric-icon' ) {
			$html .= '<ol>';
		} elseif ( $wp_rem_cs_var_list_type == 'alphabetic' ) {
			$html .= '<ol class="cs-alphabetic-list">';
		} elseif ( $wp_rem_cs_var_list_type == 'built' ) {
			$html .= '<ul class="simple-liststyle">';
		} elseif ( $wp_rem_cs_var_list_type == 'icon' ) {
			$html .= '<ul>';
		} else {
			$html .= '<ul class="property-list">';
		}

		$html .= do_shortcode($content);

		if ( $wp_rem_cs_var_list_type == 'numeric-icon' || $wp_rem_cs_var_list_type == 'alphabetic' ) {
			$html .= '</ol>';
		} else {
			$html .= '</ul>';
		}
		if ( $wp_rem_cs_var_list_type == 'icon' || $wp_rem_cs_var_list_type == 'default' ) {
			$html .= '</div>';
		}
		if ( isset($column_class) && $column_class <> '' ) {
			$html .= '</div>';
		}
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$html .= '</div>';
		}
		return do_shortcode($html);
	}

}
if ( function_exists('wp_rem_cs_var_short_code') )
	wp_rem_cs_var_short_code('wp_rem_cs_list', 'wp_rem_cs_var_list_shortcode');

/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_list_item_shortcode') ) {

	function wp_rem_cs_var_list_item_shortcode($atts, $content = "") {
		global $post, $wp_rem_cs_var_list_type, $wp_rem_cs_var_list_item_icon_color, $wp_rem_cs_var_list_item_icon_bg_color;
		$defaults = array( 'wp_rem_cs_var_list_item_text' => '', 'wp_rem_cs_var_list_item_icon' => '', );
		extract(shortcode_atts($defaults, $atts));
		$wp_rem_cs_var_list_item_text = isset($wp_rem_cs_var_list_item_text) ? $wp_rem_cs_var_list_item_text : '';
		$wp_rem_cs_var_list_item_icon = isset($wp_rem_cs_var_list_item_icon) ? $wp_rem_cs_var_list_item_icon : '';
		$html = '';
		if ( isset($wp_rem_cs_var_list_type) && $wp_rem_cs_var_list_type == 'icon' ) {
			$icon_style = '';
			if ( $wp_rem_cs_var_list_item_icon_color != '' || $wp_rem_cs_var_list_item_icon_bg_color != '' ) {
				$icon_style .= ' style="';
				if ( $wp_rem_cs_var_list_item_icon_color != '' ) {
					$icon_style .= 'color: ' . esc_html($wp_rem_cs_var_list_item_icon_color) . ' !important;';
				}
				if ( $wp_rem_cs_var_list_item_icon_bg_color != '' ) {
					$icon_style .= ' background-color: ' . esc_html($wp_rem_cs_var_list_item_icon_bg_color) . ' !important;';
				}
				$icon_style .= '"';
			}
			$html .= '<li><i class="' . esc_html($wp_rem_cs_var_list_item_icon) . '" ' . $icon_style . ' ></i> ' . esc_html($wp_rem_cs_var_list_item_text) . '</li>';
		} else
		if ( isset($wp_rem_cs_var_list_type) && $wp_rem_cs_var_list_type == 'default' ) {
			$html .= '<li style="list-style-type:none !important;">' . esc_html($wp_rem_cs_var_list_item_text) . '</li>';
		} else
		if ( isset($wp_rem_cs_var_list_type) && $wp_rem_cs_var_list_type == 'built' ) {
			$html .= '<li>' . esc_html($wp_rem_cs_var_list_item_text) . '</li>';
		} else
		if ( isset($wp_rem_cs_var_list_type) && $wp_rem_cs_var_list_type == 'numeric-icon' ) {
			$html .= '<li> ' . esc_html($wp_rem_cs_var_list_item_text) . '</li>';
		} else
		if ( isset($wp_rem_cs_var_list_type) && $wp_rem_cs_var_list_type == 'alphabetic' ) {
			$html .= '<li style="list-style:lower-alpha !important;"> ' . esc_html($wp_rem_cs_var_list_item_text) . '</li>';
		}
		return do_shortcode($html);
	}

}
if ( function_exists('wp_rem_cs_var_short_code') )
	wp_rem_cs_var_short_code('wp_rem_cs_list_item', 'wp_rem_cs_var_list_item_shortcode');
