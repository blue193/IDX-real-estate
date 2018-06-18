<?php

/**
 * Quote html form for page builder
 */
if (!function_exists('wp_rem_cs_var_quote_shortcode')) {

    function wp_rem_cs_var_quote_shortcode($atts, $content = "") {
	$html = '';
	$page_element_size = isset($atts['quote_element_size']) ? $atts['quote_element_size'] : 100;
	if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
	    $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
	}
	$wp_rem_cs_var_defaults = array(
	    'wp_rem_cs_var_column_size' => '',
	    'wp_rem_cs_quote_section_title' => '',
            'wp_rem_cs_quote_section_subtitle' => '',
	    'wp_rem_var_quote_align' => '',
	    'wp_rem_cs_quote_cite' => '',
	    'wp_rem_cs_quote_cite_url' => '#',
	    'wp_rem_cs_author_position' => '',
	    'wp_rem_cs_var_quote_image' => ''
	);
	$author_name = '';
	extract(shortcode_atts($wp_rem_cs_var_defaults, $atts));
	$wp_rem_cs_quote_section_title = isset($wp_rem_cs_quote_section_title) ? $wp_rem_cs_quote_section_title : '';
	$wp_rem_cs_var_quote_image = isset($wp_rem_cs_var_quote_image) ? $wp_rem_cs_var_quote_image : '';
	$wp_rem_cs_quote_cite_url = isset($wp_rem_cs_quote_cite_url) ? $wp_rem_cs_quote_cite_url : '';
	$wp_rem_cs_quote_cite = isset($wp_rem_cs_quote_cite) ? $wp_rem_cs_quote_cite : '';
	$wp_rem_cs_author_position = isset($wp_rem_cs_author_position) ? $wp_rem_cs_author_position : '';

	if (isset($wp_rem_cs_quote_cite_url) && $wp_rem_cs_quote_cite_url <> '') {

	    if (isset($wp_rem_cs_quote_cite_url) && $wp_rem_cs_quote_cite_url <> '') {
		$author_name .= '<a href="' . esc_url($wp_rem_cs_quote_cite_url) . '">';
	    }
	    $author_name .= $wp_rem_cs_quote_cite;
	    if (isset($wp_rem_cs_quote_cite_url) && $wp_rem_cs_quote_cite_url <> '') {
		$author_name .= '</a>';
	    }
	}
	$column_class = '';
	if (isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '') {
	    if (function_exists('wp_rem_cs_var_custom_column_class')) {
		$column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
	    }
	}
	if (isset($column_class) && $column_class <> '') {
	    $html .= '<div  class="' . esc_html($column_class) . '" >';
	}
	$html .= wp_rem_title_sub_align($wp_rem_cs_quote_section_title, $wp_rem_cs_quote_section_subtitle, $wp_rem_var_quote_align);
        $html .= '<div class="blockquote-fancy">';
	$html .= '<blockquote>';
	$html .= '<p>' . do_shortcode($content) .'</p>';
	if ($author_name || $wp_rem_cs_author_position) {
	    $html .= '<div class="author-info">';
	    if ($wp_rem_cs_var_quote_image <> '') {
		$html .= '<figure><img src = "' . esc_url($wp_rem_cs_var_quote_image) . '" alt = ""></figure>';
	    }
	    $html .= '<div class="text-holder">';
	    if ($author_name && $wp_rem_cs_author_position) {
		$html .= '<span>';
		$html .= wp_rem_cs_allow_special_char($author_name);
		$html .= '</span>';
	    }
	    $html .= '<small>' . $wp_rem_cs_author_position . '</small>';
	    $html .= '</div>';
	    $html .= '</div>';
	}
	$html .= '</blockquote>';
	$html .= '</div>';


	if (isset($column_class) && $column_class <> '') {
	    $html .= '</div>';
	}
	if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
	    $html .= '</div>';
	}
	return $html;
    }

    if (function_exists('wp_rem_cs_var_short_code'))
	wp_rem_cs_var_short_code('wp_rem_cs_quote', 'wp_rem_cs_var_quote_shortcode');
}