<?php
/**
 * Google Fonts
 *
 * @return
 * @package wp_rem_cs-framework
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if(!class_exists('wp_rem_google_fonts_admin_frontend')){
	class wp_rem_google_fonts_admin_frontend{
		
		public function wp_rem_added_google_fonts( $front = false ){
			global $wp_rem_cs_var_options;
			
			$added_google_fonts = get_option('wp_rem_added_google_fonts');
			
			$google_fonts_list = array();
			if( !empty($added_google_fonts) && is_array($added_google_fonts) ){
				foreach ( $added_google_fonts as $key => $val ){
					$font_name = (isset($val['font_name']) && $val['font_name'] != '') ? $val['font_name'] : '';
					if( $font_name ){
						$google_fonts_list[$key] = $font_name;
					}
				}
			}
			if( $front == true ){
				
				$option_font_fields = array(
					'wp_rem_cs_var_content_font',
					'wp_rem_cs_var_mainmenu_font',
					'wp_rem_cs_var_heading1_font',
					'wp_rem_cs_var_heading2_font',
					'wp_rem_cs_var_heading3_font',
					'wp_rem_cs_var_heading4_font',
					'wp_rem_cs_var_heading5_font',
					'wp_rem_cs_var_heading6_font',
					'wp_rem_cs_var_section_title_font',
					'wp_rem_cs_var_element_title_font',
					'wp_rem_cs_var_post_title_font',
					'wp_rem_cs_var_page_title_font',
					'wp_rem_cs_var_widget_heading_font',
					'wp_rem_cs_var_ft_widget_heading_font',
				);
				foreach( $option_font_fields as $val ){
					$font_name = (isset($wp_rem_cs_var_options[$val])) ? $wp_rem_cs_var_options[$val] : '';
					if( $font_name != '' && !in_array($font_name, $google_fonts_list)){
						$google_fonts_list[$font_name] = $font_name;
					}
				}
			}
			return $google_fonts_list;
		}
		
		public function wp_rem_added_google_fonts_attributes( $front = false ){
			global $wp_rem_cs_var_options;
			
			$added_google_fonts = get_option('wp_rem_added_google_fonts');
			$google_font_attributes = array();
			if( !empty($added_google_fonts) && is_array($added_google_fonts) ){
				foreach ( $added_google_fonts as $key => $val ){
					$google_font_attributes[$key][] = 'regular';
					$items = isset($added_google_fonts[$key]['variants']) ? $added_google_fonts[$key]['variants'] : '';
					if( !empty($items) && is_array($items) ){
						foreach ( $items as $sub_key => $sub_val ){
							$variant_selected = (isset($sub_val['variant_selected']) && $sub_val['variant_selected'] != '') ? $sub_val['variant_selected'] : '';
							$variant_value = (isset($sub_val['variant_value']) && $sub_val['variant_value'] != '') ? $sub_val['variant_value'] : '';
							if( $variant_value != '' && $variant_selected == 'true' ){
								$google_font_attributes[$key][] = $variant_value;
							}
						}
					}
				}
			}
			
			if( $front == true ){
				
				$option_font_fields = array(
					'wp_rem_cs_var_content_font',
					'wp_rem_cs_var_mainmenu_font',
					'wp_rem_cs_var_heading1_font',
					'wp_rem_cs_var_heading2_font',
					'wp_rem_cs_var_heading3_font',
					'wp_rem_cs_var_heading4_font',
					'wp_rem_cs_var_heading5_font',
					'wp_rem_cs_var_heading6_font',
					'wp_rem_cs_var_section_title_font',
					'wp_rem_cs_var_element_title_font',
					'wp_rem_cs_var_post_title_font',
					'wp_rem_cs_var_page_title_font',
					'wp_rem_cs_var_widget_heading_font',
					'wp_rem_cs_var_ft_widget_heading_font',
				);
				foreach( $option_font_fields as $val ){
					$font_name = (isset($wp_rem_cs_var_options[$val])) ? $wp_rem_cs_var_options[$val] : '';
					$font_att = (isset($wp_rem_cs_var_options[$val .'_att'])) ? $wp_rem_cs_var_options[$val .'_att'] : '';
					if ($font_att != '' && !array_key_exists($font_name, $google_font_attributes)) {
						$google_font_attributes[$font_name][] = $font_att;
					}
					if( isset($google_font_attributes[$font_name]) && !is_array($google_font_attributes[$font_name])){
						$google_font_attributes[$font_name] = array();
					}
					if($font_name != '' && isset($google_font_attributes[$font_name]) && !in_array('regular', $google_font_attributes[$font_name])){
						$google_font_attributes[$font_name][] = 'regular';
					}
				}
			}
			return $google_font_attributes;
		}
		
		public function wp_rem_selected_google_fonts_attributes($id = ''){
			$added_google_fonts = get_option('wp_rem_added_google_fonts');
			$selected_google_font_attributes = array();
			$selected_google_font_attributes['400'] = 'regular';
			if( !empty($added_google_fonts) && is_array($added_google_fonts) && $id != '' ){
				$items = isset($added_google_fonts[$id]['variants']) ? $added_google_fonts[$id]['variants'] : '';
				if( !empty($items) && is_array($items) ){
					foreach ( $items as $key => $val ){
						$variant_selected = (isset($val['variant_selected']) && $val['variant_selected'] != '') ? $val['variant_selected'] : '';
						$variant_value = (isset($val['variant_value']) && $val['variant_value'] != '') ? $val['variant_value'] : '';
						if( $variant_value != '' && $variant_selected == 'true' ){
							$selected_google_font_attributes[$variant_value] = $variant_value;
						}
					}
				}
			}
			return $selected_google_font_attributes;
		}
	}
	new wp_rem_google_fonts_admin_frontend;
}