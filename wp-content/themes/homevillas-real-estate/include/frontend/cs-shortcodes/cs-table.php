<?php

/*
 *
 * @Shortcode Name : Start function for Table shortcode/element front end view
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_table_shortcode') ) {

	function wp_rem_cs_var_table_shortcode($atts, $content = "") {
		$defaults = array( 
                    'wp_rem_cs_table_element_title' => '',
                    'wp_rem_cs_table_element_subtitle' => '',
                    'wp_rem_var_table_align' => '', 
                    'wp_rem_cs_var_column_size' => ''
                    );
		extract(shortcode_atts($defaults, $atts));
		if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
			if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
				$column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
			}
		}
		$html = '';
		$page_element_size = isset($atts['table_element_size']) ? $atts['table_element_size'] : 100;
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
		}
		////// Start Column Class
		if ( isset($column_class) && $column_class <> '' ) {
			$html .= '<div class="' . esc_html($column_class) . '">';
		}
		////// Element Title
		
                $html .= wp_rem_title_sub_align($wp_rem_cs_table_element_title, $wp_rem_cs_table_element_subtitle, $wp_rem_var_table_align);
                
		////// Table Content
		$html .= '<div class="cs-pricing-table table-responsive">' . do_shortcode($content) . '</div>';
		////// End Column Class
		if ( isset($column_class) && $column_class <> '' ) {
			$html .= ' </div>';
		}
		if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
			$html .= '</div>';
		}
		return $html;
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('wp_rem_cs_table', 'wp_rem_cs_var_table_shortcode');
	}
}
/*
 *
 * @Shortcode Name : Start function for Table shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_table_shortcode') ) {

	function wp_rem_cs_table_shortcode($atts, $content = "") {
		$defaults = array( 'wp_rem_cs_table_content' => '' );
		extract(shortcode_atts($defaults, $atts));
		return '<table class="table ">' . do_shortcode($content) . '</table>';
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('table', 'wp_rem_cs_table_shortcode');
	}
}

/*
 *
 * @Shortcode Name : Start function for Table Body  shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_table_body_shortcode') ) {

	function wp_rem_cs_table_body_shortcode($atts, $content = "") {
		$defaults = array();
		extract(shortcode_atts($defaults, $atts));
		return '<tbody>' . do_shortcode($content) . '</tbody>';
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('tbody', 'wp_rem_cs_table_body_shortcode');
	}
}
/*
 *
 * @Shortcode Name : Start function for Table Head  shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_table_head_shortcode') ) {

	function wp_rem_cs_table_head_shortcode($atts, $content = "") {
		$defaults = array();
		extract(shortcode_atts($defaults, $atts));
		return '<thead>' . do_shortcode($content) . '</thead>';
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('thead', 'wp_rem_cs_table_head_shortcode');
	}
}
/*
 *
 * @Shortcode Name : Start function for Table Row  shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_table_row_shortcode') ) {

	function wp_rem_cs_table_row_shortcode($atts, $content = "") {
		$defaults = array();
		extract(shortcode_atts($defaults, $atts));
		return '<tr>' . do_shortcode($content) . '</tr>';
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('tr', 'wp_rem_cs_table_row_shortcode');
	}
}

/*
 *
 * @Shortcode Name :Start function for Table Heading  shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_table_heading_shortcode') ) {

	function wp_rem_cs_table_heading_shortcode($atts, $content = "") {
		$defaults = array();
		extract(shortcode_atts($defaults, $atts));
		$html = '';
		$html .= '<th>';
		$html .= do_shortcode($content);
		$html .= '</th>';

		return $html;
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('th', 'wp_rem_cs_table_heading_shortcode');
	}
}

/*
 *
 * @Shortcode Name :  Start function for Table Data  shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_table_data_shortcode') ) {

	function wp_rem_cs_table_data_shortcode($atts, $content = "") {
		$defaults = array();
		extract(shortcode_atts($defaults, $atts));
		return '<td>' . do_shortcode($content) . '</td>';
	}

	if ( function_exists('wp_rem_cs_var_short_code') ) {
		wp_rem_cs_var_short_code('td', 'wp_rem_cs_table_data_shortcode');
	}
}
