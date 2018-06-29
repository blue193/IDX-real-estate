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

if(!class_exists('wp_rem_google_fonts_frontend')){
	class wp_rem_google_fonts_frontend{
		
		public function wp_rem_added_google_fonts_subsets(){
			$added_google_fonts = get_option('wp_rem_added_google_fonts');
			
			$google_font_attributes = '';
			if( !empty($added_google_fonts) && is_array($added_google_fonts) ){
				foreach ( $added_google_fonts as $key => $val ){
					$items = isset($added_google_fonts[$key]['subsets']) ? $added_google_fonts[$key]['subsets'] : '';
					if( !empty($items) && is_array($items) ){
						foreach ( $items as $sub_key => $sub_val ){
							$variant_selected = (isset($sub_val['subset_selected']) && $sub_val['subset_selected'] != '') ? $sub_val['subset_selected'] : '';
							$variant_value = (isset($sub_val['subset_value']) && $sub_val['subset_value'] != '') ? $sub_val['subset_value'] : '';
							if( $variant_value != '' && $variant_selected == 'true' ){
								$google_font_attributes[$key][] = $variant_value;
							}
						}
					}
				}
			}
			return $google_font_attributes;
		}
		
		function wp_rem_selected_google_font_print_frontend($atts = '', $size = '12', $line_height = '20', $f_name, $imp = false) {
			$important = '';
			$html = '';
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
	
	new wp_rem_google_fonts_frontend;
}