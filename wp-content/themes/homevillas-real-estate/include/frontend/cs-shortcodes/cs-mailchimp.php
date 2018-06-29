<?php

/*
 *
 * @Shortcode Name : Image Frame
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_mail_chimp') ) {

	function wp_rem_cs_var_mail_chimp($atts, $content = "") {
		$page_element_size = isset($atts['mail_chimp_element_size']) ? $atts['mail_chimp_element_size'] : 100;
		$wp_rem_cs_var_mail_chimp = '';
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$wp_rem_cs_var_mail_chimp.= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
		}
		global $header_map, $post;
		$defaults = array(
			'wp_rem_cs_var_column_size' => '',
			'wp_rem_cs_var_mail_section_title' => '',
                        'wp_rem_cs_var_mail_section_subtitle' => '',
			'wp_rem_var_mail_align' => '',
			'wp_rem_cs_var_mail_sub_title' => '',
			'wp_rem_cs_var_background_color' => '',
		);
		extract(shortcode_atts($defaults, $atts));
		if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
			if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
				$column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
			}
		}
		$wp_rem_cs_var_mail_section_title = isset($wp_rem_cs_var_mail_section_title) ? $wp_rem_cs_var_mail_section_title : '';
                $wp_rem_cs_var_mail_section_subtitle = isset($wp_rem_cs_var_mail_section_subtitle) ? $wp_rem_cs_var_mail_section_subtitle : '';
		$wp_rem_cs_var_mail_sub_title = isset($wp_rem_cs_var_mail_sub_title) ? $wp_rem_cs_var_mail_sub_title : '';
		$wp_rem_cs_var_background_color = isset($wp_rem_cs_var_background_color) ? $wp_rem_cs_var_background_color : '';

		$background = '';
		if ( isset($wp_rem_cs_var_background_color) && $wp_rem_cs_var_background_color != '' ) {
			$background = 'style = "background-color:' . $wp_rem_cs_var_background_color . '; "';
		}
		if ( isset($column_class) && $column_class <> '' ) {
			$wp_rem_cs_var_mail_chimp .= '<div class="' . esc_html($column_class) . '">';
		}
		$wp_rem_cs_var_mail_chimp.= '<div class="banner-news-letter '.wp_rem_cs_allow_special_char($wp_rem_var_mail_align).'" ' . wp_rem_cs_allow_special_char($background) . '>';
		if ( isset($wp_rem_cs_var_mail_section_title) && $wp_rem_cs_var_mail_section_title != '' ) {
			$wp_rem_cs_var_mail_chimp.= '<h5>' . esc_html($wp_rem_cs_var_mail_section_title) . '</h5>';
		}
		if ( isset($wp_rem_cs_var_mail_sub_title) && $wp_rem_cs_var_mail_sub_title != '' ) {
			$wp_rem_cs_var_mail_chimp.= '<p>' . esc_html($wp_rem_cs_var_mail_sub_title) . '</p>';
		}
		if ( $content <> '' ) {
			$wp_rem_cs_var_mail_chimp.= do_shortcode($content);
		}
		$under_construction = '2';
		ob_start();
		wp_rem_cs_custom_mailchimp($under_construction);
		$wp_rem_cs_var_mail_chimp.= ob_get_clean();
		$wp_rem_cs_var_mail_chimp.= '</div>';
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$wp_rem_cs_var_mail_chimp.= '</div>';
		}
		return $wp_rem_cs_var_mail_chimp;
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('wp_rem_cs_mail_chimp', 'wp_rem_cs_var_mail_chimp');
	}
}