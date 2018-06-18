<?php

/**
 * File Type: Form Fields
 */
if ( ! class_exists('wp_rem_form_fields') ) {

	class wp_rem_form_fields {

		private $counter = 0;

		public function __construct() {

			// Do something...
		}

		/**
		 * @ render label
		 */
		public function wp_rem_form_text_render($params = '') {

			global $post, $pagenow, $user;

			if ( isset($params) && is_array($params) ) {
				extract($params);
			}
			$wp_rem_output = '';
			$prefix_enable = 'true'; // default value of prefix add in name and id
			if ( ! isset($id) ) {
				$id = '';
			}
			if ( ! isset($std) ) {
				$std = '';
			}

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'wp_rem_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}
			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
					}
				}
			} else {
				$wp_rem_value = isset($std) ? $std : '';
			}
			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}
			
			$wp_rem_rand_id = time();

			if ( isset($rand_id) && $rand_id != '' ) {
				$wp_rem_rand_id = $rand_id;
			}

			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';

			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) && $cust_name != '' ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			// Disabled Field
			$wp_rem_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$wp_rem_visibilty = 'readonly="readonly"';
			}

			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}

			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			$wp_rem_input_type = 'text';
			if ( isset($cust_type) && $cust_type != '' ) {
				$wp_rem_input_type = $cust_type;
			}

			$wp_rem_before = '';
			if ( isset($before) && $before != '' ) {
				$wp_rem_before = '<div class="' . $before . '">';
			}

			$wp_rem_after = '';
			if ( isset($after) && $after != '' ) {
				$wp_rem_after = $after;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}

			if ( isset($rang) && $rang == true && isset($min) && isset($max) ) {
				$wp_rem_output .= '<div class="cs-drag-slider" data-slider-min="' . $min . '" data-slider-max="' . $max . '" data-slider-step="1" data-slider-value="' . $value . '">';
			}
			$wp_rem_output .= $wp_rem_before;
			if ( $value != '' ) {
				$wp_rem_output .= '<input type="' . $wp_rem_input_type . '" ' . $wp_rem_visibilty . $wp_rem_required . ' ' . $extra_atributes . ' ' . $wp_rem_classes . ' ' . $html_id . $html_name . ' value="' . $value . '" />';
			} else {
				$wp_rem_output .= '<input type="' . $wp_rem_input_type . '" ' . $wp_rem_visibilty . $wp_rem_required . ' ' . $extra_atributes . ' ' . $wp_rem_classes . ' ' . $html_id . $html_name . ' />';
			}

			$wp_rem_output .= $wp_rem_after;

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Radio field
		 */
		public function wp_rem_form_radio_render($params = '') {
			global $post, $user, $pagenow;
			extract($params);

			$wp_rem_output = '';

			if ( ! isset($id) ) {
				$id = '';
			}

			$prefix_enable = 'true'; // default value of prefix add in name and id

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'wp_rem_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
					}
				}
			} else {
				$wp_rem_value = isset($std) ? $std : '';
			}

			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}

			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$html_id = isset($html_id) ? $html_id : '';

			// Disbaled Field
			$wp_rem_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$wp_rem_visibilty = 'readonly="readonly"';
			}
			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}
			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}

			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}

			$wp_rem_output .= '<input type="radio" ' . $wp_rem_visibilty . $wp_rem_required . ' ' . $wp_rem_classes . ' ' . $extra_atributes . ' ' . $html_id . $html_name . ' value="' . ($value) . '" />';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Radio field
		 */
		public function wp_rem_form_hidden_render($params = '') {
			global $post, $pagenow;
			extract($params);

			$wp_rem_rand_id = time();

			if ( ! isset($id) ) {
				$id = '';
			}
			$html_id = '';
			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
			$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}

			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}

			$wp_rem_output = '<input type="hidden" ' . $html_id . ' ' . $wp_rem_classes . ' ' . $extra_atributes . ' ' . $html_name . ' value="' . sanitize_text_field($std) . '" />';
			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Date field
		 */
		public function wp_rem_form_date_render($params = '') {
			global $post, $pagenow;
			extract($params);

			$wp_rem_output = '';

			$wp_rem_format = 'd-m-Y';
			$prefix_enable = 'true'; // default value of prefix add in name and id

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'wp_rem_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}
			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( isset($format) && $format != '' ) {
				$wp_rem_format = $format;
			}
			$wp_rem_value = '';
			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, $prefix . $id, true);
				}
				if ( isset($strtotime) && $strtotime == true ) {
					
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
					}
				}

				if ( isset($strtotime) && $strtotime == true ) {
					
				}
			} else {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					if ( isset($strtotime) && $strtotime == true ) {
						$wp_rem_value = isset($post->ID) ? get_post_meta((int) $post->ID, 'wp_rem_' . $id, true) : '';
					} else {
						$wp_rem_value = isset($post->ID) ? get_post_meta($post->ID, 'wp_rem_' . $id, true) : '';
					}
				}
			}

			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				if ( isset($strtotime) && $strtotime == true ) {
					$wp_rem_value = date($wp_rem_format, (int) $wp_rem_value);
				}
				$value = $wp_rem_value;
			} elseif ( isset($std) && $std != '' ) {
				$value = $std;
			} else {
				$value = date($wp_rem_format);
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}


			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}
			// disable attribute
			$wp_rem_disabled = '';
			if ( isset($disabled) && $disabled == 'yes' ) {
				$wp_rem_disabled = ' disabled="disabled"';
			}

			$wp_rem_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$wp_rem_visibilty = 'readonly="readonly"';
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$wp_rem_rand_id = time();
			if ( isset($rand_id) && $rand_id != '' ) {
				$wp_rem_rand_id = $rand_id;
			}

			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			$wp_rem_piker_id = $id;
			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
				$wp_rem_piker_id = $id . $wp_rem_rand_id;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}

			$wp_rem_output .= '<script>
                                jQuery(function(){
                                    jQuery("#' . $prefix . $wp_rem_piker_id . '").datetimepicker({
                                        format:"' . $wp_rem_format . '",
                                        minDate: new Date(),
                                        timepicker:false
                                    });
                                });
                          </script>';
			$wp_rem_output .= '<div class="input-date">';
			$wp_rem_output .= '<input type="text"' . $wp_rem_visibilty . $wp_rem_required . ' ' . $wp_rem_disabled . ' ' . $extra_atributes . ' ' . $wp_rem_classes . ' ' . $html_id . $html_name . '  value="' . sanitize_text_field($value) . '" />';
			$wp_rem_output .= '</div>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Textarea field
		 */
		public function wp_rem_form_textarea_render($params = '') {
			global $post, $pagenow;
			if ( isset($params['wp_rem_editor']) ) {
				if ( $params['wp_rem_editor'] == true ) {
					$editor_class = 'wp_rem_editor' . mt_rand();
					if ( isset($params['before']) ) {
						$params['before'] .= ' ' . $editor_class;
					} else {
						$params['before'] = ' ' . $editor_class;
					}
				}
			}
			extract($params);
			$wp_rem_output = '';
			if ( ! isset($id) ) {
				$id = '';
			}
			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
					}
				}
			} else {
				$wp_rem_value = $std;
			}
			//echo "==(".$wp_rem_value.")";

			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}

			$wp_rem_rand_id = time();

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="wp_rem_cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}
			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}
			$wp_rem_before = '';
			if ( isset($before) && $before != '' ) {
				$wp_rem_before = '<div class="' . $before . '">';
			}

			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			$wp_rem_after = '';
			if ( isset($after) && $after != '' ) {
				$wp_rem_after = '</div>';
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}

			$wp_rem_output .= $wp_rem_before;
			$wp_rem_output .= ' <textarea' . $wp_rem_required . ' ' . $extra_atributes . ' ' . $html_id . $html_name . $wp_rem_classes . '>' . $value . '</textarea>';
			$wp_rem_output .= $wp_rem_after;
			if ( isset($params['wp_rem_editor']) ) {
				if ( $params['wp_rem_editor'] == true ) {
					$jquery = '<script>
						jQuery( document ).ready(function() {
							jQuery(".' . $editor_class . ' textarea").jqte(' . (isset($wp_rem_editor_placeholder) && $wp_rem_editor_placeholder != '' ? '{placeholder: "' . $wp_rem_editor_placeholder . '"}' : '') . ');
						});
					</script>';
				}
			}
			$wp_rem_jquery = '';
			if ( isset($jquery) && $jquery != '' ) {
				$wp_rem_jquery = $jquery;
			}
			$wp_rem_output .= $wp_rem_jquery;

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render select field
		 */
		public function wp_rem_form_select_render($params = '') {
			global $post, $pagenow;
			extract($params);
			$prefix_enable = 'true'; // default value of prefix add in name and id
			if ( ! isset($id) ) {
				$id = '';
			}
			$wp_rem_output = '';

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'wp_rem_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			$wp_rem_onchange = '';

			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
					}
				}
			} else {
				$wp_rem_value = $std;
			}
			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}
			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}
			$wp_rem_rand_id = time();
			if ( isset($rand_id) && $rand_id != '' ) {
				$wp_rem_rand_id = $rand_id;
			}

			$html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
				$html_wraper = ' id="wrapper_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$wp_rem_display = '';
			if ( isset($status) && $status == 'hide' ) {
				$wp_rem_display = 'style=display:none';
			}

			if ( isset($onclick) && $onclick != '' ) {
				$wp_rem_onchange = 'onchange="' . $onclick . '"';
			}

			$wp_rem_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$wp_rem_visibilty = 'readonly="readonly"';
			}
			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}
			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( isset($markup) && $markup != '' ) {
				$wp_rem_output .= $markup;
			}

			if ( isset($div_classes) && $div_classes <> "" ) {
				$wp_rem_output .= '<div class="' . esc_attr($div_classes) . '">';
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}

			$wp_rem_output .= '<select ' . $wp_rem_visibilty . ' ' . $wp_rem_required . ' ' . $extra_atributes . ' ' . $wp_rem_classes . ' ' . $html_id . $html_name . ' ' . $wp_rem_onchange . ' >';
			if ( isset($options_markup) && $options_markup == true ) {
				$wp_rem_output .= $options;
			} else {
				if ( is_array($options) ) {
					foreach ( $options as $key => $option ) {
						if ( ! is_array($option)) {
                                                        //echo $key.'==='.$value.'<br />';
							$wp_rem_output .= '<option ' . selected($key, $value, false) . ' value="' . $key . '">' . $option . '</option>';
						}
					}
				}
			}
			$wp_rem_output .= '</select>';

			if ( isset($div_classes) && $div_classes <> "" ) {
				$wp_rem_output .= '</div>';
			}

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Multi Select field
		 */
		public function wp_rem_form_multiselect_render($params = '') {
			global $post, $pagenow;
			extract($params);

			$wp_rem_output = '';

			$prefix_enable = 'true'; // default value of prefix add in name and id
			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'wp_rem_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}
			$wp_rem_onchange = '';

			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
					}
				}
			} else {
				$wp_rem_value = $std;
			}
			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}
			$wp_rem_rand_id = time();
			if ( isset($rand_id) && $rand_id != '' ) {
				$wp_rem_rand_id = $rand_id;
			}
			$html_wraper = '';
			if ( isset($id) && $id != '' ) {
				$html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
			}
			$html_id = '';
			if ( isset($id) && $id != '' ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
			}
			$html_name = '';
			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . '][]"';
			} else {
				if ( isset($id) && $id != '' ) {
					$html_name = ' name="' . $prefix . sanitize_html_class($id) . '[]"';
				}
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}
			
			if (isset($cust_name) && $cust_name == '' ) {
				$html_name = '';
			}

			$wp_rem_display = '';
			if ( isset($status) && $status == 'hide' ) {
				$wp_rem_display = 'style=display:none';
			}

			if ( isset($onclick) && $onclick != '' ) {
				$wp_rem_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
			}

			if ( ! is_array($value) && $value != '' ) {
				$value = explode(',', $value);
			}

			if ( ! is_array($value) ) {
				$value = array();
			}

			// Disbaled Field
			$wp_rem_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$wp_rem_visibilty = 'readonly="readonly"';
			}
			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}
			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="multiple ' . $classes . '"';
			} else {
				$wp_rem_classes = ' class="multiple"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}

			$wp_rem_output .= '<select' . $wp_rem_visibilty . $wp_rem_required . ' ' . $extra_atributes . ' ' . $wp_rem_classes . ' ' . ' multiple ' . $html_id . $html_name . ' ' . $wp_rem_onchange . ' style="height:110px !important;">';

			if ( isset($options_markup) && $options_markup == true ) {
				$wp_rem_output .= $options;
			} else {
				foreach ( $options as $key => $option ) {
					$selected = '';
					if ( in_array($key, $value) ) {
						$selected = 'selected="selected"';
					}

					$wp_rem_output .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
			}
			$wp_rem_output .= '</select>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Checkbox field         
		 */
		public function wp_rem_form_checkbox_render($params = '') {
			global $post, $pagenow;
			extract($params);
			$prefix_enable = 'true'; // default value of prefix add in name and id

			$wp_rem_output = '';

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			if ( ! isset($id) ) {
				$id = '';
			}
			$prefix = 'wp_rem_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			if ( $pagenow == 'post.php' && $id != '' ) {
				$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
				$value = $wp_rem_value;
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
					$value = $wp_rem_value;
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
						$value = $wp_rem_value;
					}
				}
			} else {
				$wp_rem_value = $std;
				$value = $wp_rem_value;
			}

			if ( $value == '' ) {
				$value = $std;
			}
			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$wp_rem_rand_id = time();

			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
			$btn_name = ' name="' . $prefix . sanitize_html_class($id) . '"';

			$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$btn_name = ' name="' . $prefix . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$checked = isset($value) && $value == 'on' ? ' checked="checked"' : '';
			// Disbaled Field
			$wp_rem_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$wp_rem_visibilty = 'readonly="readonly"';
			}
			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}
			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="wp_rem_"' ) {
				$html_id = '';
			}
			$html_data_id = str_replace('id=', 'data-id=', $html_id);
			if ( isset($simple) && $simple == true ) {
				if ( $value == '' ) {
					$wp_rem_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $wp_rem_classes . ' ' . $checked . ' ' . $extra_atributes . ' />';
				} else {
					$wp_rem_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $wp_rem_classes . ' ' . $checked . ' value="' . $value . '"' . $extra_atributes . ' />';
				}
			} else {
				if ( $value == '' ) {
					$value = 'off';
				}
				$wp_rem_output .= '<label class="pbwp-checkbox cs-chekbox">';
				$wp_rem_output .= '<input type="hidden"' . $html_id . $html_name . ' value="' . $value . '" />';
				$wp_rem_output .= '<input type="checkbox" ' . $html_data_id . ' ' . $wp_rem_classes . ' ' . $checked . ' ' . $extra_atributes . ' />';
				$wp_rem_output .= '<span class="pbwp-box"></span>';
				$wp_rem_output .= '</label>';
			}

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Checkbox With Input Field
		 */
		public function wp_rem_form_checkbox_with_field_render($params = '') {
			global $post, $pagenow;
			extract($params);
			extract($field);
			$prefix_enable = 'true'; // default value of prefix add in name and id

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'wp_rem_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			$wp_rem_value = get_post_meta($post->ID, $prefix . $id, true);
			if ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
					}
				}
			}
			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}

			$wp_rem_input_value = get_post_meta($post->ID, $prefix . $field_id, true);
			if ( isset($wp_rem_input_value) && $wp_rem_input_value != '' ) {
				$input_value = $wp_rem_input_value;
			} else {
				$input_value = $field_std;
			}

			$wp_rem_visibilty = ''; // Disbaled Field
			if ( isset($active) && $active == 'in-active' ) {
				$wp_rem_visibilty = 'readonly="readonly"';
			}
			$wp_rem_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$wp_rem_required = ' required';
			}
			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			$wp_rem_output .= '<label class="pbwp-checkbox">';
			$wp_rem_output .= $this->wp_rem_form_hidden_render(array( 'id' => $id, 'std' => '', 'type' => '', 'return' => 'return' ));
			$wp_rem_output .= '<input type="checkbox" ' . $wp_rem_visibilty . $wp_rem_required . ' ' . $extra_atributes . ' ' . $wp_rem_classes . ' ' . ' name="' . $prefix . sanitize_html_class($id) . '" id="' . $prefix . sanitize_html_class($id) . '" value="' . sanitize_text_field('on') . '" ' . checked('on', $value, false) . ' />';
			$wp_rem_output .= '<span class="pbwp-box"></span>';
			$wp_rem_output .= '</label>';
			$wp_rem_output .= '<input type="text" name="' . $prefix . sanitize_html_class($field_id) . '"  value="' . sanitize_text_field($input_value) . '">';
			$wp_rem_output .= $this->wp_rem_form_description($description);

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render File Upload field
		 */
		public function wp_rem_media_url($params = '') {
			global $post, $pagenow;
			extract($params);

			$wp_rem_output = '';

			$wp_rem_value = isset($post->ID) ? get_post_meta($post->ID, 'wp_rem_' . $id, true) : '';
			if ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$wp_rem_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
						}
					}
				}
			}
			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}

			$wp_rem_rand_id = time();

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
			$html_id_btn = ' id="wp_rem_' . sanitize_html_class($id) . '_btn"';
			$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
				$html_id_btn = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '_btn"';
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			}

			$wp_rem_output .= '<input type="text" class="cs-form-text cs-input" ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';
			$wp_rem_output .= '<label class="cs-browse">';
			$wp_rem_output .= '<input type="button" ' . $html_id_btn . $html_name . ' class="uploadfile left" value="' . wp_rem_plugin_text_srt( 'wp_rem_form_fields_browse' ) . '"/>';
			$wp_rem_output .= '</label>';

			if ( isset($return) && $return == true ) {
				return $wp_rem_output;
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render File Upload field
		 */
		public function wp_rem_form_fileupload_render($params = '') {
			global $post, $pagenow, $image_val, $wp_rem_html_fields;
			extract($params);



			$std = isset($std) ? $std : '';
			$wp_rem_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$wp_rem_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
						}
					}
				}
			} else {
				$wp_rem_value = $std;
			}

			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
				if ( isset($dp) && $dp == true ) {
					$value = wp_rem_get_img_url($wp_rem_value, 'wp_rem_media_5');
				} else {
					$value = $wp_rem_value;
				}
			} else {
				$std = ( isset($std) ) ? $std : '';
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '_rand"';
			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '_rand"';
			$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			} else if ( isset($dp) && $dp == true ) {
				$html_name = ' name="' . sanitize_html_class($id) . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			if ( isset($value) && $value != '' ) {
				$display_btn = ' style="display:none !important;"';
			} else {
				$display_btn = ' style="display:block !important;"';
			}

			$wp_rem_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

			$wp_rem_output .= '<label ' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left" value=' . wp_rem_plugin_text_srt( 'wp_rem_form_fields_browse' ) . ' /></label>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Custom File Upload field
		 */
		public function wp_rem_form_custom_fileupload_render($params = '') {
			global $post, $pagenow, $image_val;
			extract($params);

			$wp_rem_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$wp_rem_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
						}
					}
				}
			} else {
				$wp_rem_value = $std;
			}
			$imagename_only = '';
			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
				$imagename_only = $wp_rem_value;
				if ( isset($dp) && $dp == true ) {
					$value = wp_rem_get_img_url($wp_rem_value, 'wp_rem_media_5');
				} else {
					$value = $wp_rem_value;
				}
			} else {
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '_media"';
			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
			$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '_media' . $wp_rem_random_id . '"';
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			} else if ( isset($dp) && $dp == true ) {
				$html_name = ' name="' . sanitize_html_class($id) . '"';
			}

			if ( isset($cust_name) && $cust_name == true ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			if ( isset($value) && $value != '' ) {
				$display_btn = ' style=display:none';
			} else {
				$display_btn = ' style=display:block';
			}

			$wp_rem_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$wp_rem_classes = ' class="' . $classes . '"';
			}

			$wp_rem_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $imagename_only . '"/>';

			$wp_rem_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="file" class="' . $wp_rem_classes . '" value=' . wp_rem_plugin_text_srt( 'wp_rem_form_fields_browse' ) . ' /></label>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render cvupload Upload field
		 */
		public function wp_rem_form_cvupload_render($params = '') {
			global $post, $pagenow;
			extract($params);
			$wp_rem_output = '';
			if ( $pagenow == 'post.php' ) {
				$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$wp_rem_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
						}
					}
				}
			} else {
				$wp_rem_value = $std;
			}
			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
			} else {
				$value = $std;
			}

			if ( isset($value) && $value != '' ) {
				$display = 'style=display:block';
			} else {
				$display = 'style=display:none';
			}

			$wp_rem_random_id = WP_REM_FUNCTIONS()->rand_id();

			$btn_name = ' name="' . sanitize_html_class($id) . '"';
			$html_id = ' id="' . sanitize_html_class($id) . '"';
			$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_id = ' id="' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			}

			$wp_rem_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';
			$wp_rem_output .= '<label class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left" value="' . wp_rem_plugin_text_srt( 'wp_rem_form_fields_browse' ) . '" /></label>';

			$wp_rem_output .= '<div class="page-wrap" ' . $display . ' id="wp_rem_' . sanitize_html_class($id) . '_box">';
			$wp_rem_output .= '<div class="gal-active">';
			$wp_rem_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
			$wp_rem_output .= '<ul id="gal-sortable">';
			$wp_rem_output .= '<li class="ui-state-default" id="">';
			$wp_rem_output .= '<div class="thumb-secs" id="wp_rem_' . sanitize_html_class($id) . '_img"> ' . basename($value);
			$wp_rem_output .= '<div class="gal-edit-opts"><a href="javascript:del_cv_media(\'wp_rem_' . sanitize_html_class($id) . '\', \'' . sanitize_html_class($id) . '\')" class="delete"></a> </div>';
			$wp_rem_output .= '</div>';
			$wp_rem_output .= '</li>';
			$wp_rem_output .= '</ul>';
			$wp_rem_output .= '</div>';
			$wp_rem_output .= '</div>';
			$wp_rem_output .= '</div>';


			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		/**
		 * @ render Random String
		 */
		public function wp_rem_generate_random_string($length = 3) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ( $i = 0; $i < $length; $i ++ ) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}

		public function wp_rem_img_upload_button($params = '') {
			global $post, $pagenow, $image_val, $wp_rem_plugin_static_text;
			extract($params);

			$wp_rem_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$wp_rem_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
						}
					}
				}
			} else {
				$wp_rem_value = $std;
			}

			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
				if ( isset($dp) && $dp == true ) {
					$value = wp_rem_get_img_url($wp_rem_value, 'wp_rem_media_6');
				} else {
					$value = $wp_rem_value;
				}
			} else {
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			if ( isset($value) && $value != '' ) {
				$display = 'style=display:block';
			} else {
				$display = 'style=display:none';
			}

			$wp_rem_random_id = '';
			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
			if ( isset($array) && $array == true ) {
				$wp_rem_random_id = rand(12345678, 98765432);
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
			}

			$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
			$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			} else if ( isset($dp) && $dp == true ) {
				$html_name = ' name="' . sanitize_html_class($id) . '"';
			}
			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' name="' . $cust_name . '"';
			}

			if ( isset($cust_name) && $cust_name != '' ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			if ( isset($value) && $value != '' ) {
				$display_btn = ' style=display:none';
			} else {
				$display_btn = ' style=display:block';
			}

			$wp_rem_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';
			$wp_rem_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left" value=' . wp_rem_plugin_text_srt( 'wp_rem_form_fields_browse' ) . ' /></label>';
			$wp_rem_output .= '<div class="page-wrap" ' . $display . ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '_box">';
			$wp_rem_output .= '<div class="gal-active">';
			$wp_rem_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
			$wp_rem_output .= '<ul id="gal-sortable">';
			$wp_rem_output .= '<li class="ui-state-default" id="">';
			$wp_rem_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '_img" width="100" alt="" />';
			$wp_rem_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '\')" class="delete delImgMedia"></a> </div>';
			$wp_rem_output .= '</div>';
			$wp_rem_output .= '</li>';
			$wp_rem_output .= '</ul>';
			$wp_rem_output .= '</div>';
			$wp_rem_output .= '</div>';
			$wp_rem_output .= '</div>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

		public function wp_rem_form_attachemnt_fileupload_render($params = '') {
			global $post, $pagenow, $image_val, $wp_rem_html_fields;
			extract($params);



			$std = isset($std) ? $std : '';
			$wp_rem_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$wp_rem_value = get_post_meta($post->ID, $id, true);
				} else {
					$wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$wp_rem_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$wp_rem_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$wp_rem_value = get_the_author_meta('wp_rem_' . $id, $user->ID);
						}
					}
				}
			} else {
				$wp_rem_value = $std;
			}

			if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
				$value = $wp_rem_value;
				if ( isset($dp) && $dp == true ) {
					$value = wp_rem_get_img_url($wp_rem_value, 'wp_rem_media_5');
				} else {
					$value = $wp_rem_value;
				}
			} else {
				$std = ( isset($std) ) ? $std : '';
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			if ( isset($array) && $array == true ) {
				$wp_rem_random_id = rand(12345678, 98765432);
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
			}

			$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '_rand"';
			$html_id = ' id="wp_rem_' . sanitize_html_class($id) . '_rand"';
			$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
				$html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
			} else if ( isset($dp) && $dp == true ) {
				$html_name = ' name="' . sanitize_html_class($id) . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			if ( isset($value) && $value != '' ) {
				$display_btn = ' style="display:none !important;"';
			} else {
				$display_btn = ' style="display:block !important;"';
			}

			$allowd_extensions_attr = '';
			if ( isset($allowd_extensions) && $allowd_extensions != '' ) {
				$allowd_extensions_attr = ' allowd_extensions="' . $allowd_extensions . '" ';
			}

			$wp_rem_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

			$wp_rem_output .= '<label ' . $display_btn . ' class="browse-icon"><input' . $btn_name . $allowd_extensions_attr . ' type="button" class="cs-attachment-uploadMedia left" value=' . wp_rem_plugin_text_srt( 'wp_rem_form_fields_browse' ) . ' /></label>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($wp_rem_output);
			} else {
				echo force_balance_tags($wp_rem_output);
			}
		}

	}

	global $wp_rem_form_fields;
	$wp_rem_form_fields = new wp_rem_form_fields();
}
