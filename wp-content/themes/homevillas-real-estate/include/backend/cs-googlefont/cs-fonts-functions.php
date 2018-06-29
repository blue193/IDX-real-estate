<?php

/**
 * Google Fonts
 *
 * @package WordPress
 * @subpackage mashup
 * @since Auto Mobile 1.0
 */
if ( ! function_exists('wp_rem_cs_var_googlefont_list') ) {

	function wp_rem_cs_var_googlefont_list() {

		global $fonts;
		$font_array = '';
		if ( get_option('wp_rem_cs_var_font_list') != '' && get_option('wp_rem_cs_var_font_attribute') != '' ) {
			$font_array = get_option('wp_rem_cs_var_font_list');
			$font_attribute = get_option('wp_rem_cs_var_font_attribute');
		} else {
			$font_array = wp_rem_cs_var_get_google_fontlist($fonts);
			$font_attribute = wp_rem_cs_var_font_attribute($fonts);
			if ( is_array($font_array) && count($font_array) > 0 && is_array($font_attribute) && count($font_attribute) > 0 ) {
				update_option('wp_rem_cs_var_font_list', $font_array);
				update_option('wp_rem_cs_var_font_attribute', $font_attribute);
			}
		}
		return $font_array;
	}

}

/**
 * @Getting Google font Array from json
 *
 */
if ( ! function_exists('wp_rem_cs_var_get_google_fontlist') ) {

	function wp_rem_cs_var_get_google_fontlist($response = '') {

		global $fonts;
		$font_list = '';
		$json_fonts = json_decode($response, true);

		if ( $json_fonts != '' ) {
			$items = isset($json_fonts['items']) ? $json_fonts['items'] : '';
			$font_list = array();
			$i = 0;
			foreach ( $items as $item ) {
				$key = isset($item['family']) ? $item['family'] : '';
				$font_list[$key] = isset($item['family']) ? $item['family'] : '';
				$i ++;
			}
		}
		return $font_list;
	}

}
/**
 * @Frontend Font Printing.
 */
if ( ! function_exists('wp_rem_cs_var_get_google_font_attribute') ) {

	function wp_rem_cs_var_get_google_font_attribute($response = '', $id = 'ABeeZee') {

		global $fonts;
		if ( get_option('wp_rem_cs_var_font_attribute') ) {
			$font_attribute = get_option('wp_rem_cs_var_font_attribute');
			if ( isset($font_attribute) && $font_attribute <> '' ) {
				$items = isset($font_attribute[$id]) ? $font_attribute[$id] : '';
			}
		} else {
			$arrtibue_array = wp_rem_cs_var_font_attribute($fonts);
			$items = isset($arrtibue_array[$id]) ? $arrtibue_array[$id] : '';
		}
		return $items;
	}

}

/**
 * @Getting Google Font Attributes
 *
 */
if ( ! function_exists('wp_rem_cs_var_get_google_font_attributes') ) {

	add_action('wp_ajax_wp_rem_cs_var_get_google_font_attributes', 'wp_rem_cs_var_get_google_font_attributes');

	function wp_rem_cs_var_get_google_font_attributes() {

		global $fonts, $wp_rem_cs_var_static_text;
		$wp_rem_cs_var_select_attribute = isset($wp_rem_cs_var_static_text['wp_rem_cs_var_select_attribute']) ? $wp_rem_cs_var_static_text['wp_rem_cs_var_select_attribute'] : '';
		if ( isset($_POST['index']) && $_POST['index'] <> '' ) {
			$index = $_POST['index'];
		} else {
			$index = '';
		}
		if ( $index != 'default' ) {
			if ( get_option('wp_rem_cs_var_font_attribute') ) {
				$font_attribute = get_option('wp_rem_cs_var_font_attribute');
				$items = isset($font_attribute[$index]) ? $font_attribute[$index] : '';
			} else {
				$json_fonts = json_decode($fonts, true);
				if ( $json_fonts != '' ) {
					$items = isset($json_fonts['items'][$index]['variants']) ? $json_fonts['items'][$index]['variants'] : '';
				}
			}
			$html = '<select class="chosen-select" id="' . $_POST['id'] . '" name="' . $_POST['id'] . '"><option value="">' . $wp_rem_cs_var_select_attribute . '</option>';
			foreach ( $items as $key => $value ) {
				$html .= '<option value="' . $value . '">' . $value . '</option>';
			}
			$html .='</select>';
		} else {
			$html = '<select class="chosen-select" id="' . $_POST['id'] . '" name="' . $_POST['id'] . '"><option value="">' . $wp_rem_cs_var_select_attribute . '</option></select>';
		}

		echo '<script>
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
            });
        </script>';

		echo balanceTags($html, false);
		die();
	}

}

/**
 * @Font Attribute Function
 *
 */
if ( ! function_exists('wp_rem_cs_var_font_attribute') ) {

	function wp_rem_cs_var_font_attribute($fontarray = '') {

		//global $fonts;

		$json_fonts = json_decode($fontarray, true);
		$items = isset($json_fonts['items']) ? $json_fonts['items'] : '';
		$font_list = array();
		$i = 0;
		foreach ( $items as $item ) {
			$key = isset($item['family']) ? $item['family'] : '';
			$font_list[$key] = isset($item['variants']) ? $item['variants'] : '';
			$i ++;
		}
		return $font_list;
	}

}

if ( ! function_exists('wp_rem_cs_var_is_fonts_loaded') ) {

	function wp_rem_cs_var_is_fonts_loaded() {

		$wp_rem_cs_var_options = get_option('wp_rem_cs_var_options');

			$return_array = array();
			
			$wp_rem_cs_var_content_font = '';
			$wp_rem_cs_var_mainmenu_font = '';
			$wp_rem_cs_var_heading1_font = '';
			$wp_rem_cs_var_heading2_font = '';
			$wp_rem_cs_var_heading3_font = '';
			$wp_rem_cs_var_heading4_font = '';
			$wp_rem_cs_var_heading5_font = '';
			$wp_rem_cs_var_heading6_font = '';
			$wp_rem_cs_var_section_title_font = '';
			$wp_rem_cs_var_page_title_font = '';
			$wp_rem_cs_var_post_title_font = '';
			$wp_rem_cs_var_widget_heading_font = '';
			$wp_rem_cs_var_ft_widget_heading_font = '';
			
			$content_custom_font_html = wp_rem_cs_var_load_custom_fonts('content_font');
			if( $content_custom_font_html == '' ){
				$wp_rem_cs_var_content_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_content_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_content_font'] : '';
			}
			
			$mainmenu_custom_font_html = wp_rem_cs_var_load_custom_fonts('mainmenu_font');
			if( $mainmenu_custom_font_html == '' ){
				$wp_rem_cs_var_mainmenu_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_mainmenu_font'] : '';
			}
			
			$heading1_custom_font_html = wp_rem_cs_var_load_custom_fonts('heading1_font');
			if ( $heading1_custom_font_html == '' ) {
				$wp_rem_cs_var_heading1_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading1_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading1_font'] : '';
			}
			
			$heading2_custom_font_html = wp_rem_cs_var_load_custom_fonts('heading2_font');
			if ( $heading2_custom_font_html == '' ) {
				$wp_rem_cs_var_heading2_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading2_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading2_font'] : '';
			}
		
			$heading3_custom_font_html = wp_rem_cs_var_load_custom_fonts('heading3_font');
			if ( $heading3_custom_font_html == '' ) {
				$wp_rem_cs_var_heading3_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading3_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading3_font'] : '';
			}
		
			$heading4_custom_font_html = wp_rem_cs_var_load_custom_fonts('heading4_font');
			if ( $heading4_custom_font_html == '' ) {
				$wp_rem_cs_var_heading4_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading4_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading4_font'] : '';
			}
			
			$heading5_custom_font_html = wp_rem_cs_var_load_custom_fonts('heading5_font');
			if ( $heading5_custom_font_html == '' ) {
				$wp_rem_cs_var_heading5_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading5_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading5_font'] : '';
			}
			
			$heading6_custom_font_html = wp_rem_cs_var_load_custom_fonts('heading6_font');
			if ( $heading6_custom_font_html == '' ) {
				$wp_rem_cs_var_heading6_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_heading6_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_heading6_font'] : '';
			}
			
			$section_title_custom_font_html = wp_rem_cs_var_load_custom_fonts('section_title_font');
			if ( $section_title_custom_font_html == '' ) {
				$wp_rem_cs_var_section_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_section_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_section_title_font'] : '';
			}
			
			$element_title_custom_font_html = wp_rem_cs_var_load_custom_fonts('element_title_font');
			if ( $element_title_custom_font_html == '' ) {
				$wp_rem_cs_var_element_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_element_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_element_title_font'] : '';
			}
			
			$post_title_custom_font_html = wp_rem_cs_var_load_custom_fonts('post_title_font');
			if ( $post_title_custom_font_html == '' ) {
				$wp_rem_cs_var_post_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_post_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_post_title_font'] : '';
			}
			
			$page_title_custom_font_html = wp_rem_cs_var_load_custom_fonts('page_title_font');
			if ( $page_title_custom_font_html == '' ) {
				$wp_rem_cs_var_page_title_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_font'] : '';
			}
			
			$widget_heading_custom_font_html = wp_rem_cs_var_load_custom_fonts('widget_heading_font');
			if ( $widget_heading_custom_font_html == '' ) {
				$wp_rem_cs_var_widget_heading_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_widget_heading_font'] : '';
			}
			
			$ft_widget_heading_custom_font_html = wp_rem_cs_var_load_custom_fonts('ft_widget_heading_font');
			if ( $ft_widget_heading_custom_font_html == '' ) {
				$wp_rem_cs_var_ft_widget_heading_font = (isset($wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_font'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_ft_widget_heading_font'] : '';
			}
			
			$fonts_array = array(
				$wp_rem_cs_var_content_font,
				$wp_rem_cs_var_mainmenu_font,
				$wp_rem_cs_var_heading1_font,
				$wp_rem_cs_var_heading2_font,
				$wp_rem_cs_var_heading3_font,
				$wp_rem_cs_var_heading4_font,
				$wp_rem_cs_var_heading5_font,
				$wp_rem_cs_var_heading6_font,
				$wp_rem_cs_var_section_title_font,
				$wp_rem_cs_var_element_title_font,
				$wp_rem_cs_var_page_title_font,
				$wp_rem_cs_var_post_title_font,
				$wp_rem_cs_var_widget_heading_font,
				$wp_rem_cs_var_ft_widget_heading_font,
			);
			$fonts_array = array_unique($fonts_array);
			foreach ( $fonts_array as $font ) {
				if ( $font != '' && $font != 'default' ) {
					$return_array[] = $font;
				}
			}
			if ( sizeof($return_array) > 0 ) {
				return $return_array;
			}
			return false;
		//}
		//return false;
	}

}

/**
 * @Setting Font for Frontend
 *
 */
if ( ! function_exists('wp_rem_cs_var_get_font_families') ) {

	function wp_rem_cs_var_get_font_families($font_indexes = array()) {
		$fonts = $font_attribute = $wp_rem_cs_var_fonts_subsets = '';
		
		if (class_exists('wp_rem_google_fonts_admin_frontend')) {
			$fonts_admin_frontend = new wp_rem_google_fonts_admin_frontend();
			$fonts =  $fonts_admin_frontend->wp_rem_added_google_fonts(true);
			$font_attribute = $fonts_admin_frontend->wp_rem_added_google_fonts_attributes(true);
		}
		if (class_exists('wp_rem_google_fonts_admin_frontend')) {
			$fonts_frontend = new wp_rem_google_fonts_frontend();
			$wp_rem_cs_var_fonts_subsets = $fonts_frontend->wp_rem_added_google_fonts_subsets();
		}
		
		$all_att = '';
		$wp_rem_cs_var_subs = '';
		$families_get = array();
		$all_atts_arr = array();
		$all_subs_arr = array();

		$all_fsubs_arr = array();

		foreach ( $font_indexes as $font_index ) {
			if ( $font_index != 'default' && $font_index != '' ) {

				if ( isset($fonts) && is_array($fonts) ) {
					$family_str = '';
					$name = isset($fonts[$font_index]) ? $fonts[$font_index] : '';

					if ( $name != '' ) {
						$families_get[] = $name;
						$family_str .= $name;
					}

					if ( isset($font_attribute[$font_index]) && is_array($font_attribute[$font_index]) ) {

						$get_atts_s = array();
						foreach ( $font_attribute[$font_index] as $f_atts ) {
							$all_atts_arr[] = $f_atts;
							$get_atts_s[] = $f_atts;
						}
						if ( ! empty($get_atts_s) ) {
							$get_atts_s = array_unique($get_atts_s);
							$all_att_s = ':' . implode(',', $get_atts_s);
							$family_str .= $all_att_s;
						}
					}

					if ( $family_str != '' ) {
						$all_fsubs_arr[] = $family_str;
					}

					$wp_rem_cs_var_subsets = isset($wp_rem_cs_var_fonts_subsets[$font_index]) ? $wp_rem_cs_var_fonts_subsets[$font_index] : '';
					if ( is_array($wp_rem_cs_var_subsets) && sizeof($wp_rem_cs_var_subsets) > 0 ) {
						foreach ( $wp_rem_cs_var_subsets as $sub_set ) {
							$all_subs_arr[] = $sub_set;
						}
					}
				}
			}
		}

		if ( sizeof($all_atts_arr) > 0 ) {
			$all_atts_arr = array_unique($all_atts_arr);
			$all_att = ':' . implode(',', $all_atts_arr);
		}

		if ( sizeof($all_subs_arr) > 0 ) {
			$all_atts_arr = array_unique($all_subs_arr);
			$wp_rem_cs_var_subs = '&subset=' . implode(',', $all_subs_arr);
		}
		
		if ( sizeof($all_fsubs_arr) > 0 ) {
			$families = implode('|', $all_fsubs_arr);
			return $families . $wp_rem_cs_var_subs;
		}

		if ( sizeof($families_get) > 0 ) {
			$families = implode('|', $families_get);
			return $families . $all_att . $wp_rem_cs_var_subs;
		}
		return false;
	}

}

/**
 * @Getting Font Family on Frontend
 *
 */
if ( ! function_exists('wp_rem_cs_var_get_font_name') ) {

	function wp_rem_cs_var_get_font_name($font_index = 'default') {

		global $fonts;
		if ( $font_index != 'default' ) {
			$fonts = wp_rem_cs_var_googlefont_list();
			if ( isset($fonts) and is_array($fonts) ) {
				$name = isset($fonts[$font_index]) ? $fonts[$font_index] : '';
				return $name;
			}
		} else {
			return 'default';
		}
	}

}

/**
 * @Function for Recursive Array Replace
 *
 */
if ( ! function_exists('wp_rem_cs_var_recursive_array_replace') ) {

	function wp_rem_cs_var_recursive_array_replace($array) {

		global $fonts;
		if ( is_array($array) ) {
			$new_array = array();
			for ( $i = 0; $i < sizeof($array); $i ++ ) {
				$new_array[] = $array[$i] == 'regular' ? 'Normal' : $array[$i];
			}
		}
		return $new_array;
	}

}

/**
 * @Getting Font Family on Frontend
 *
 */
if ( ! function_exists('wp_rem_cs_var_get_font_att_array') ) {

	function wp_rem_cs_var_get_font_att_array($atts = array()) {

		global $fonts;
		$atts = wp_rem_cs_var_recursive_array_replace($atts);

		if ( sizeof($atts) == 1 && is_numeric($atts[0]) )
			$atts = array_merge($atts, array( 'Normal' ));
		$r_att = '';
		foreach ( $atts as $att ) {
			$r_att .= $att . ' ';
		}
		return $r_att;
	}

}

/**
 * @Printing Font on Frontend
 *
 */
if ( ! function_exists('wp_rem_cs_var_font_font_print') ) {

	function wp_rem_cs_var_font_font_print($atts = '', $size = '12', $line_height = '20', $f_name, $imp = false) {

		global $fonts;
		$important = '';
		$html = '';
		$f_name = wp_rem_cs_var_get_font_name($f_name);
		if ( $f_name == 'default' || $f_name == '' ) {
			if ( $imp == true ) {
				$important = ' !important';
			}
			if ( $size > 0 ) {
				$html = 'font-size:' . $size . 'px' . $important . ';';
			}
		} else {
			if ( $imp == true ) {
				$important = ' !important';
			}
			$html = 'font:' . $atts . ' ' . $size . 'px' . ( $line_height != '' ? '/' . $line_height . 'px' : '' ) . ' "' . $f_name . '", sans-serif' . $important . ';';
		}
		return $html;
	}

}

/**
 * @Printing Font on Frontend
 *
 */
if ( ! function_exists('wp_rem_selected_google_font_print') ) {

	function wp_rem_selected_google_font_print($atts = '', $size = '12', $line_height = '20', $f_name, $imp = false) {
		if (class_exists('wp_rem_google_fonts_frontend')) {
			$fonts_frontend = new wp_rem_google_fonts_frontend();
			return $fonts_frontend->wp_rem_selected_google_font_print_frontend( $atts, $size, $line_height, $f_name, $imp );
		}
	}

}




if ( ! function_exists('wp_rem_cs_var_custom_font_name') ) {

	function wp_rem_cs_var_custom_font_name( $key = '' ) {
		$wp_rem_cs_var_options = get_option('wp_rem_cs_var_options');
		$font_name_html = '';
		
		if( $key != '' ){
			$content_font_type = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_'. $key .'_type'] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_'. $key .'_type'] : '';
			$wp_rem_custom_fonts = isset($wp_rem_cs_var_options['wp_rem_custom_fonts']) ? $wp_rem_cs_var_options['wp_rem_custom_fonts'] : '';
			if( $content_font_type == 'custom_fonts' && is_array($wp_rem_custom_fonts) && !empty($wp_rem_custom_fonts)){
				$custom_content_font_key = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .''] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .''] : '';
				if( $custom_content_font_key != '' ){
					$font_name = isset($wp_rem_custom_fonts['name'][$custom_content_font_key]) ? $wp_rem_custom_fonts['name'][$custom_content_font_key] : '';
					if( $font_name != '' ){
						$font_name_html = 'font-family: '. $font_name .' !important;';
					}
				}
			}
		}
		return $font_name_html;
	}
}

if ( ! function_exists('wp_rem_cs_var_load_custom_fonts') ) {

	function wp_rem_cs_var_load_custom_fonts( $key = '' ) {
		$wp_rem_cs_var_options = get_option('wp_rem_cs_var_options');
		$font_face_html = '';
		
		if( $key != '' ){
			$content_font_type = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_'. $key .'_type'] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_'. $key .'_type'] : '';
			$wp_rem_custom_fonts = isset($wp_rem_cs_var_options['wp_rem_custom_fonts']) ? $wp_rem_cs_var_options['wp_rem_custom_fonts'] : '';

			if( $content_font_type == 'custom_fonts' && is_array($wp_rem_custom_fonts) && !empty($wp_rem_custom_fonts)){
				$custom_content_font_key = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .''] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .''] : '';
				$custom_content_font_weight = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .'_weight'] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .'_weight'] : '400';
				if( $custom_content_font_key != '' ){
					$font_name = isset($wp_rem_custom_fonts['name'][$custom_content_font_key]) ? $wp_rem_custom_fonts['name'][$custom_content_font_key] : '';
					$font_woff = isset($wp_rem_custom_fonts['woff'][$custom_content_font_key]) ? $wp_rem_custom_fonts['woff'][$custom_content_font_key] : '';
					$font_ttf = isset($wp_rem_custom_fonts['ttf'][$custom_content_font_key]) ? $wp_rem_custom_fonts['ttf'][$custom_content_font_key] : '';
					$font_svg = isset($wp_rem_custom_fonts['svg'][$custom_content_font_key]) ? $wp_rem_custom_fonts['svg'][$custom_content_font_key] : '';
					$font_eot = isset($wp_rem_custom_fonts['eot'][$custom_content_font_key]) ? $wp_rem_custom_fonts['eot'][$custom_content_font_key] : '';

					if (( isset( $font_woff ) && $font_woff != '' ) && ( isset( $font_ttf ) && $font_ttf != '' ) && ( isset( $font_svg ) && $font_svg != '' ) && ( isset( $font_eot ) && $font_eot != '' ) ){
						$font_face_html = "
						@font-face {
						font-family: '". $font_name ."';
						src: url('" . $font_eot . "');
						src:
						url('" . $font_eot . "?#iefix') format('eot'),
						url('" . $font_woff . "') format('woff'),
						url('" . $font_ttf . "') format('truetype'),
						url('" . $font_svg . "#wp_rem_cs_var_custom_font') format('svg');
						font-weight: ". $custom_content_font_weight ." !important;
						font-style: normal;
						}";
					}
				}
			}
		}
		return $font_face_html;
	}
}

if ( ! function_exists('wp_rem_cs_var_load_custom_font_weight') ) {

	function wp_rem_cs_var_load_custom_font_weight( $key = '' ) {
		$wp_rem_cs_var_options = get_option('wp_rem_cs_var_options');
		$custom_font_weight = '';
		
		if( $key != '' ){
			$content_font_type = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_'. $key .'_type'] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_'. $key .'_type'] : '';
			$wp_rem_custom_fonts = isset($wp_rem_cs_var_options['wp_rem_custom_fonts']) ? $wp_rem_cs_var_options['wp_rem_custom_fonts'] : '';

			if( $content_font_type == 'custom_fonts' && is_array($wp_rem_custom_fonts) && !empty($wp_rem_custom_fonts)){
				$custom_content_font_key = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .''] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .''] : '';
				$custom_content_font_weight = (isset( $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .'_weight'] )) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_'. $key .'_weight'] : '400';
				if( $custom_content_font_key != '' ){
					$font_woff = isset($wp_rem_custom_fonts['woff'][$custom_content_font_key]) ? $wp_rem_custom_fonts['woff'][$custom_content_font_key] : '';
					$font_ttf = isset($wp_rem_custom_fonts['ttf'][$custom_content_font_key]) ? $wp_rem_custom_fonts['ttf'][$custom_content_font_key] : '';
					$font_svg = isset($wp_rem_custom_fonts['svg'][$custom_content_font_key]) ? $wp_rem_custom_fonts['svg'][$custom_content_font_key] : '';
					$font_eot = isset($wp_rem_custom_fonts['eot'][$custom_content_font_key]) ? $wp_rem_custom_fonts['eot'][$custom_content_font_key] : '';

					if (( isset( $font_woff ) && $font_woff != '' ) && ( isset( $font_woff ) && $font_woff != '' ) && ( isset( $font_woff ) && $font_woff != '' ) && ( isset( $font_woff ) && $font_woff != '' ) ){
						echo 'font-weight: ' . $custom_content_font_weight . ' !important;';
					}
				}
			}
		}
	}
}

