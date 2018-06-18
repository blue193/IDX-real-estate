<?php

/*
 *
 * @Shortcode Name : Button
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_button') ) {

	function wp_rem_cs_var_button($atts, $content = "") {
		$html = '';
		$page_element_size = isset($atts['button_element_size']) ? $atts['button_element_size'] : 100;
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
		}
		$defaults = array(
			'wp_rem_cs_var_column_size' => '',
			'wp_rem_cs_var_column' => '1',
			'wp_rem_cs_var_button_text' => '',
			'wp_rem_cs_var_button_link' => '#',
			'wp_rem_cs_var_button_border' => '',
			'wp_rem_cs_var_button_icon_position' => '',
			'wp_rem_cs_var_button_type' => 'rounded',
			'wp_rem_cs_var_button_target' => '_self',
			'wp_rem_cs_var_button_border_color' => '',
			'wp_rem_cs_var_button_color' => '#fff',
			'wp_rem_cs_var_button_bg_color' => '',
			'wp_rem_cs_var_button_align' => '',
			'wp_rem_cs_button_icon' => '',
			'wp_rem_cs_button_icon_group' => 'default',
			'wp_rem_cs_var_button_size' => 'btn-lg',
			'wp_rem_cs_var_icon_view' => '',
			'wp_rem_cs_var_button_alignment' => ''
		);
		extract(shortcode_atts($defaults, $atts));
		$wp_rem_cs_var_column = isset($wp_rem_cs_var_column) ? $wp_rem_cs_var_column : '';
		$wp_rem_cs_var_button_text = isset($wp_rem_cs_var_button_text) ? $wp_rem_cs_var_button_text : '';
		$wp_rem_cs_var_button_alignment = isset($wp_rem_cs_var_button_alignment) ? $wp_rem_cs_var_button_alignment : '';
		$wp_rem_cs_var_button_link = isset($wp_rem_cs_var_button_link) ? $wp_rem_cs_var_button_link : '';
		$wp_rem_cs_var_button_border = isset($wp_rem_cs_var_button_border) ? $wp_rem_cs_var_button_border : '';
		$wp_rem_cs_var_button_icon_position = isset($wp_rem_cs_var_button_icon_position) ? $wp_rem_cs_var_button_icon_position : '';
		$wp_rem_cs_var_button_type = isset($wp_rem_cs_var_button_type) ? $wp_rem_cs_var_button_type : '';
		$wp_rem_cs_var_button_border_color = isset($wp_rem_cs_var_button_border_color) ? $wp_rem_cs_var_button_border_color : '';
		$wp_rem_cs_var_button_bg_color = isset($wp_rem_cs_var_button_bg_color) ? $wp_rem_cs_var_button_bg_color : '';
		$wp_rem_cs_var_button_color = isset($wp_rem_cs_var_button_color) ? $wp_rem_cs_var_button_color : '';
		$wp_rem_cs_var_button_target = isset($wp_rem_cs_var_button_target) ? $wp_rem_cs_var_button_target : '';
		$wp_rem_cs_button_icon = isset($wp_rem_cs_button_icon) ? $wp_rem_cs_button_icon : '';
		$button_size = isset($wp_rem_cs_var_button_size) ? $wp_rem_cs_var_button_size : '';
		$wp_rem_cs_var_icon_view = isset($wp_rem_cs_var_icon_view) ? $wp_rem_cs_var_icon_view : '';
		$column_class = '';
		if ( isset($column_class) && $column_class <> '' ) {
			$html .= '<div  class="' . esc_html($column_class) . '" >';
		}
		$button_type_class = 'no_circle';
		$wp_rem_cs_var_button_align = isset($wp_rem_cs_var_button_align) ? $wp_rem_cs_var_button_align : '';
		$border = '';
		$has_icon = '';

		if ( $button_size == 'btn-lg' ) {
			$button_size = ' large-btn';
		} elseif ( $button_size == ' medium-btn' ) {
			$button_size = ' medium-btn';
		} elseif ( $button_size == 'btn-sml' ) {
			$button_size = ' small-btn';
		}
		if ( isset($wp_rem_cs_var_button_border_color) && $wp_rem_cs_var_button_border_color <> '' ) {
			$border = ' border: 2px solid ' . esc_attr($wp_rem_cs_var_button_border_color) . ' !important;';
		}
		if ( isset($wp_rem_cs_var_button_type) && $wp_rem_cs_var_button_type == 'rounded' ) {
			$button_type_class = 'circle';
		}
		if ( isset($wp_rem_cs_var_button_type) && $wp_rem_cs_var_button_type == 'three-d' ) {
			$button_type_class = 'has-shadow';
			$border = '';
		}
		if ( isset($wp_rem_cs_button_icon) && $wp_rem_cs_button_icon <> '' ) {
			$has_icon = 'has_icon';
		}
		$button_class_position = (isset($wp_rem_cs_var_button_align) and $wp_rem_cs_var_button_align == 'left') ? 'icon-left' : 'icon-right';
		$has_border = '';
		if ( $wp_rem_cs_var_button_border == 'yes' ) {
			$has_border = 'has-border';
		}
		if ( isset($wp_rem_cs_var_button_target) && $wp_rem_cs_var_button_target == '_blank' ) {
			$wp_rem_cs_var_button_target = ' target=' . $wp_rem_cs_var_button_target . '';
		} else {
			$wp_rem_cs_var_button_target = ' target=' . $wp_rem_cs_var_button_target . '';
		}
		$button_alignment = '';
		if ( $wp_rem_cs_var_button_alignment == 'center' ) {
			$button_alignment = ' align-center';
		} elseif ( $wp_rem_cs_var_button_alignment == 'left' ) {
			$button_alignment = ' align-left';
		} elseif ( $wp_rem_cs_var_button_alignment == 'right' ) {
			$button_alignment = ' align-right';
		}

		$html .= '<div class="button_style cs-button' . esc_attr($button_alignment) . '">';
		$html .= '<a href="  ' . esc_url($wp_rem_cs_var_button_link) . '" class="csborder-color ' . esc_attr($has_border) . ' custom-btn ' . esc_attr($button_size) . ' ' . sanitize_html_class($button_type_class) . ' bg-color  ' . $has_icon . ' button-icon-' . esc_attr($wp_rem_cs_var_button_align) . '" style="' . esc_attr($border) . '  background-color: ' . esc_attr($wp_rem_cs_var_button_bg_color) . ' ! important; color:' . esc_attr($wp_rem_cs_var_button_color) . ' ! important;"' . esc_html($wp_rem_cs_var_button_target) . '>';
		if ( isset($wp_rem_cs_button_icon) && $wp_rem_cs_button_icon <> '' && isset($wp_rem_cs_var_icon_view) && $wp_rem_cs_var_icon_view == 'on' ) {
                        wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_button_icon_group );
			$html .= '<i class="' . esc_attr($wp_rem_cs_button_icon) . '"></i>';
		}
		if ( isset($wp_rem_cs_var_button_text) && $wp_rem_cs_var_button_text <> '' ) {
			$html .= wp_rem_cs_allow_special_char($wp_rem_cs_var_button_text);
		}
		$html .= '</a>';
		$html .= '</div>';
		if ( isset($column_class) && $column_class <> '' ) {
			$html .= '</div>';
		}
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$html .= '</div>';
		}
		return do_shortcode($html);
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('wp_rem_cs_button', 'wp_rem_cs_var_button');
	}
}