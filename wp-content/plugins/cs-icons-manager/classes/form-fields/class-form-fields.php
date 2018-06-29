<?php

/**
 * File Type: Form Fields
 */
if ( ! class_exists('cs_icons_form_fields') ) {

	class cs_icons_form_fields {

		private $counter = 0;

		public function __construct() {

			// Do something...
		}

		/**
		 * @ render label
		 */
		public function cs_icons_form_text_render($params = '') {

			global $post, $pagenow, $user;

			if ( isset($params) && is_array($params) ) {
				extract($params);
			}
			$cs_icons_output = '';
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

			$prefix = 'cs_icons_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}
			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
					}
				}
			} else {
				$cs_icons_value = isset($std) ? $std : '';
			}
			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
			} else {
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}
			
			$cs_icons_rand_id = time();

			if ( isset($rand_id) && $rand_id != '' ) {
				$cs_icons_rand_id = $rand_id;
			}

			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';

			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $cs_icons_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) && $cust_name != '' ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			// Disabled Field
			$cs_icons_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$cs_icons_visibilty = 'readonly="readonly"';
			}

			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}

			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			$cs_icons_input_type = 'text';
			if ( isset($cust_type) && $cust_type != '' ) {
				$cs_icons_input_type = $cust_type;
			}

			$cs_icons_before = '';
			if ( isset($before) && $before != '' ) {
				$cs_icons_before = '<div class="' . $before . '">';
			}

			$cs_icons_after = '';
			if ( isset($after) && $after != '' ) {
				$cs_icons_after = $after;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}

			if ( isset($rang) && $rang == true && isset($min) && isset($max) ) {
				$cs_icons_output .= '<div class="cs-drag-slider" data-slider-min="' . $min . '" data-slider-max="' . $max . '" data-slider-step="1" data-slider-value="' . $value . '">';
			}
			$cs_icons_output .= $cs_icons_before;
			if ( $value != '' ) {
				$cs_icons_output .= '<input type="' . $cs_icons_input_type . '" ' . $cs_icons_visibilty . $cs_icons_required . ' ' . $extra_atributes . ' ' . $cs_icons_classes . ' ' . $html_id . $html_name . ' value="' . $value . '" />';
			} else {
				$cs_icons_output .= '<input type="' . $cs_icons_input_type . '" ' . $cs_icons_visibilty . $cs_icons_required . ' ' . $extra_atributes . ' ' . $cs_icons_classes . ' ' . $html_id . $html_name . ' />';
			}

			$cs_icons_output .= $cs_icons_after;

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Radio field
		 */
		public function cs_icons_form_radio_render($params = '') {
			global $post, $user, $pagenow;
			extract($params);

			$cs_icons_output = '';

			if ( ! isset($id) ) {
				$id = '';
			}

			$prefix_enable = 'true'; // default value of prefix add in name and id

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'cs_icons_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
					}
				}
			} else {
				$cs_icons_value = isset($std) ? $std : '';
			}

			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
			} else {
				$value = $std;
			}

			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $cs_icons_rand_id . '"';
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
			$cs_icons_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$cs_icons_visibilty = 'readonly="readonly"';
			}
			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}
			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}

			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}

			$cs_icons_output .= '<input type="radio" ' . $cs_icons_visibilty . $cs_icons_required . ' ' . $cs_icons_classes . ' ' . $extra_atributes . ' ' . $html_id . $html_name . ' value="' . ($value) . '" />';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Radio field
		 */
		public function cs_icons_form_hidden_render($params = '') {
			global $post, $pagenow;
			extract($params);

			$cs_icons_rand_id = time();

			if ( ! isset($id) ) {
				$id = '';
			}
			$html_id = '';
			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '"';
			$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}

			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}

			$cs_icons_output = '<input type="hidden" ' . $html_id . ' ' . $cs_icons_classes . ' ' . $extra_atributes . ' ' . $html_name . ' value="' . sanitize_text_field($std) . '" />';
			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Date field
		 */
		public function cs_icons_form_date_render($params = '') {
			global $post, $pagenow;
			extract($params);

			$cs_icons_output = '';

			$cs_icons_format = 'd-m-Y';
			$prefix_enable = 'true'; // default value of prefix add in name and id

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'cs_icons_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}
			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( isset($format) && $format != '' ) {
				$cs_icons_format = $format;
			}
			$cs_icons_value = '';
			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, $prefix . $id, true);
				}
				if ( isset($strtotime) && $strtotime == true ) {
					
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
					}
				}

				if ( isset($strtotime) && $strtotime == true ) {
					
				}
			} else {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					if ( isset($strtotime) && $strtotime == true ) {
						$cs_icons_value = isset($post->ID) ? get_post_meta((int) $post->ID, 'cs_icons_' . $id, true) : '';
					} else {
						$cs_icons_value = isset($post->ID) ? get_post_meta($post->ID, 'cs_icons_' . $id, true) : '';
					}
				}
			}

			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				if ( isset($strtotime) && $strtotime == true ) {
					$cs_icons_value = date($cs_icons_format, (int) $cs_icons_value);
				}
				$value = $cs_icons_value;
			} elseif ( isset($std) && $std != '' ) {
				$value = $std;
			} else {
				$value = date($cs_icons_format);
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}


			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}
			// disable attribute
			$cs_icons_disabled = '';
			if ( isset($disabled) && $disabled == 'yes' ) {
				$cs_icons_disabled = ' disabled="disabled"';
			}

			$cs_icons_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$cs_icons_visibilty = 'readonly="readonly"';
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$cs_icons_rand_id = time();
			if ( isset($rand_id) && $rand_id != '' ) {
				$cs_icons_rand_id = $rand_id;
			}

			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			$cs_icons_piker_id = $id;
			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $cs_icons_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
				$cs_icons_piker_id = $id . $cs_icons_rand_id;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}

			$cs_icons_output .= '<script>
                                jQuery(function(){
                                    jQuery("#' . $prefix . $cs_icons_piker_id . '").datetimepicker({
                                        format:"' . $cs_icons_format . '",
                                        timepicker:false,
                                        minDate: new Date(),
                                    });
                                });
                          </script>';
			$cs_icons_output .= '<div class="input-date">';
			$cs_icons_output .= '<input type="text"' . $cs_icons_visibilty . $cs_icons_required . ' ' . $cs_icons_disabled . ' ' . $extra_atributes . ' ' . $cs_icons_classes . ' ' . $html_id . $html_name . '  value="' . sanitize_text_field($value) . '" />';
			$cs_icons_output .= '</div>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Textarea field
		 */
		public function cs_icons_form_textarea_render($params = '') {
			global $post, $pagenow;
			if ( isset($params['cs_icons_editor']) ) {
				if ( $params['cs_icons_editor'] == true ) {
					$editor_class = 'cs_icons_editor' . mt_rand();
					if ( isset($params['before']) ) {
						$params['before'] .= ' ' . $editor_class;
					} else {
						$params['before'] = ' ' . $editor_class;
					}
				}
			}
			extract($params);
			$cs_icons_output = '';
			if ( ! isset($id) ) {
				$id = '';
			}
			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, 'cs_icons_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
					}
				}
			} else {
				$cs_icons_value = $std;
			}
			//echo "==(".$cs_icons_value.")";

			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
			} else {
				$value = $std;
			}

			$cs_icons_rand_id = time();

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '"';
			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="cs_icons_cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_rand_id . '"';
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '_array[]"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}
			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}
			$cs_icons_before = '';
			if ( isset($before) && $before != '' ) {
				$cs_icons_before = '<div class="' . $before . '">';
			}

			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			$cs_icons_after = '';
			if ( isset($after) && $after != '' ) {
				$cs_icons_after = '</div>';
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}

			$cs_icons_output .= $cs_icons_before;
			$cs_icons_output .= ' <textarea' . $cs_icons_required . ' ' . $extra_atributes . ' ' . $html_id . $html_name . $cs_icons_classes . '>' . $value . '</textarea>';
			$cs_icons_output .= $cs_icons_after;
			if ( isset($params['cs_icons_editor']) ) {
				if ( $params['cs_icons_editor'] == true ) {
					$jquery = '<script>
						jQuery( document ).ready(function() {
							jQuery(".' . $editor_class . ' textarea").jqte(' . (isset($cs_icons_editor_placeholder) && $cs_icons_editor_placeholder != '' ? '{placeholder: "' . $cs_icons_editor_placeholder . '"}' : '') . ');
						});
					</script>';
				}
			}
			$cs_icons_jquery = '';
			if ( isset($jquery) && $jquery != '' ) {
				$cs_icons_jquery = $jquery;
			}
			$cs_icons_output .= $cs_icons_jquery;

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render select field
		 */
		public function cs_icons_form_select_render($params = '') {
			global $post, $pagenow;
			extract($params);
			$prefix_enable = 'true'; // default value of prefix add in name and id
			if ( ! isset($id) ) {
				$id = '';
			}
			$cs_icons_output = '';

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'cs_icons_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			$cs_icons_onchange = '';

			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
					}
				}
			} else {
				$cs_icons_value = $std;
			}
			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
			} else {
				$value = $std;
			}
			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}
			$cs_icons_rand_id = time();
			if ( isset($rand_id) && $rand_id != '' ) {
				$cs_icons_rand_id = $rand_id;
			}

			$html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
			if ( isset($cus_field) && $cus_field == true ) {
				$html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
			} else {
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
			}

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $cs_icons_rand_id . '"';
				$html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
				$html_wraper = ' id="wrapper_' . sanitize_html_class($id) . $cs_icons_rand_id . '"';
			}

			if ( isset($cust_id) && $cust_id != '' ) {
				$html_id = ' id="' . $cust_id . '"';
			}

			if ( isset($cust_name) ) {
				$html_name = ' name="' . $cust_name . '"';
			}

			$cs_icons_display = '';
			if ( isset($status) && $status == 'hide' ) {
				$cs_icons_display = 'style=display:none';
			}

			if ( isset($onclick) && $onclick != '' ) {
				$cs_icons_onchange = 'onchange="' . $onclick . '"';
			}

			$cs_icons_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$cs_icons_visibilty = 'readonly="readonly"';
			}
			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}
			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( isset($markup) && $markup != '' ) {
				$cs_icons_output .= $markup;
			}

			if ( isset($div_classes) && $div_classes <> "" ) {
				$cs_icons_output .= '<div class="' . esc_attr($div_classes) . '">';
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}

			$cs_icons_output .= '<select ' . $cs_icons_visibilty . ' ' . $cs_icons_required . ' ' . $extra_atributes . ' ' . $cs_icons_classes . ' ' . $html_id . $html_name . ' ' . $cs_icons_onchange . ' >';
			if ( isset($options_markup) && $options_markup == true ) {
				$cs_icons_output .= $options;
			} else {
				if ( is_array($options) ) {
					foreach ( $options as $key => $option ) {
						if ( ! is_array($option)) {
                                                        //echo $key.'==='.$value.'<br />';
							$cs_icons_output .= '<option ' . selected($key, $value, false) . ' value="' . $key . '">' . $option . '</option>';
						}
					}
				}
			}
			$cs_icons_output .= '</select>';

			if ( isset($div_classes) && $div_classes <> "" ) {
				$cs_icons_output .= '</div>';
			}

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Multi Select field
		 */
		public function cs_icons_form_multiselect_render($params = '') {
			global $post, $pagenow;
			extract($params);

			$cs_icons_output = '';

			$prefix_enable = 'true'; // default value of prefix add in name and id
			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'cs_icons_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}
			$cs_icons_onchange = '';

			if ( $pagenow == 'post.php' ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, $prefix . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
					}
				}
			} else {
				$cs_icons_value = $std;
			}
			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
			} else {
				$value = $std;
			}
			$cs_icons_rand_id = time();
			if ( isset($rand_id) && $rand_id != '' ) {
				$cs_icons_rand_id = $rand_id;
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

			$cs_icons_display = '';
			if ( isset($status) && $status == 'hide' ) {
				$cs_icons_display = 'style=display:none';
			}

			if ( isset($onclick) && $onclick != '' ) {
				$cs_icons_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
			}

			if ( ! is_array($value) && $value != '' ) {
				$value = explode(',', $value);
			}

			if ( ! is_array($value) ) {
				$value = array();
			}

			// Disbaled Field
			$cs_icons_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$cs_icons_visibilty = 'readonly="readonly"';
			}
			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}
			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="multiple ' . $classes . '"';
			} else {
				$cs_icons_classes = ' class="multiple"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}

			$cs_icons_output .= '<select' . $cs_icons_visibilty . $cs_icons_required . ' ' . $extra_atributes . ' ' . $cs_icons_classes . ' ' . ' multiple ' . $html_id . $html_name . ' ' . $cs_icons_onchange . ' style="height:110px !important;">';

			if ( isset($options_markup) && $options_markup == true ) {
				$cs_icons_output .= $options;
			} else {
				foreach ( $options as $key => $option ) {
					$selected = '';
					if ( in_array($key, $value) ) {
						$selected = 'selected="selected"';
					}

					$cs_icons_output .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
				}
			}
			$cs_icons_output .= '</select>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Checkbox field         
		 */
		public function cs_icons_form_checkbox_render($params = '') {
			global $post, $pagenow;
			extract($params);
			$prefix_enable = 'true'; // default value of prefix add in name and id

			$cs_icons_output = '';

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			if ( ! isset($id) ) {
				$id = '';
			}
			$prefix = 'cs_icons_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			if ( $pagenow == 'post.php' && $id != '' ) {
				$cs_icons_value = get_post_meta($post->ID, 'cs_icons_' . $id, true);
				$value = $cs_icons_value;
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
					$value = $cs_icons_value;
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
						$value = $cs_icons_value;
					}
				}
			} else {
				$cs_icons_value = $std;
				$value = $cs_icons_value;
			}

			if ( $value == '' ) {
				$value = $std;
			}
			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$cs_icons_rand_id = time();

			$html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
			$btn_name = ' name="' . $prefix . sanitize_html_class($id) . '"';

			$html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$html_id = ' id="' . $prefix . sanitize_html_class($id) . $cs_icons_rand_id . '"';
				$btn_name = ' name="' . $prefix . sanitize_html_class($id) . $cs_icons_rand_id . '"';
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
			$cs_icons_visibilty = '';
			if ( isset($active) && $active == 'in-active' ) {
				$cs_icons_visibilty = 'readonly="readonly"';
			}
			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}
			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			if ( $html_id == ' id=""' || $html_id == ' id="cs_icons_"' ) {
				$html_id = '';
			}
			$html_data_id = str_replace('id=', 'data-id=', $html_id);
			if ( isset($simple) && $simple == true ) {
				if ( $value == '' ) {
					$cs_icons_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $cs_icons_classes . ' ' . $checked . ' ' . $extra_atributes . ' />';
				} else {
					$cs_icons_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $cs_icons_classes . ' ' . $checked . ' value="' . $value . '"' . $extra_atributes . ' />';
				}
			} else {
				if ( $value == '' ) {
					$value = 'off';
				}
				$cs_icons_output .= '<label class="pbwp-checkbox cs-chekbox">';
				$cs_icons_output .= '<input type="hidden"' . $html_id . $html_name . ' value="' . $value . '" />';
				$cs_icons_output .= '<input type="checkbox" ' . $html_data_id . ' ' . $cs_icons_classes . ' ' . $checked . ' ' . $extra_atributes . ' />';
				$cs_icons_output .= '<span class="pbwp-box"></span>';
				$cs_icons_output .= '</label>';
			}

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Checkbox With Input Field
		 */
		public function cs_icons_form_checkbox_with_field_render($params = '') {
			global $post, $pagenow;
			extract($params);
			extract($field);
			$prefix_enable = 'true'; // default value of prefix add in name and id

			if ( isset($prefix_on) ) {
				$prefix_enable = $prefix_on;
			}

			$prefix = 'cs_icons_'; // default prefix
			if ( isset($field_prefix) && $field_prefix != '' ) {
				$prefix = $field_prefix;
			}
			if ( $prefix_enable != true ) {
				$prefix = '';
			}

			$cs_icons_value = get_post_meta($post->ID, $prefix . $id, true);
			if ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($id) && $id != '' ) {
						$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
					}
				}
			}
			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
			} else {
				$value = $std;
			}

			$cs_icons_input_value = get_post_meta($post->ID, $prefix . $field_id, true);
			if ( isset($cs_icons_input_value) && $cs_icons_input_value != '' ) {
				$input_value = $cs_icons_input_value;
			} else {
				$input_value = $field_std;
			}

			$cs_icons_visibilty = ''; // Disbaled Field
			if ( isset($active) && $active == 'in-active' ) {
				$cs_icons_visibilty = 'readonly="readonly"';
			}
			$cs_icons_required = '';
			if ( isset($required) && $required == 'yes' ) {
				$cs_icons_required = ' required';
			}
			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}
			$extra_atributes = '';
			if ( isset($extra_atr) && $extra_atr != '' ) {
				$extra_atributes = $extra_atr;
			}

			$cs_icons_output .= '<label class="pbwp-checkbox">';
			$cs_icons_output .= $this->cs_icons_form_hidden_render(array( 'id' => $id, 'std' => '', 'type' => '', 'return' => 'return' ));
			$cs_icons_output .= '<input type="checkbox" ' . $cs_icons_visibilty . $cs_icons_required . ' ' . $extra_atributes . ' ' . $cs_icons_classes . ' ' . ' name="' . $prefix . sanitize_html_class($id) . '" id="' . $prefix . sanitize_html_class($id) . '" value="' . sanitize_text_field('on') . '" ' . checked('on', $value, false) . ' />';
			$cs_icons_output .= '<span class="pbwp-box"></span>';
			$cs_icons_output .= '</label>';
			$cs_icons_output .= '<input type="text" name="' . $prefix . sanitize_html_class($field_id) . '"  value="' . sanitize_text_field($input_value) . '">';
			$cs_icons_output .= $this->cs_icons_form_description($description);

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render File Upload field
		 */
		public function cs_icons_media_url($params = '') {
			global $post, $pagenow;
			extract($params);

			$cs_icons_output = '';

			$cs_icons_value = isset($post->ID) ? get_post_meta($post->ID, 'cs_icons_' . $id, true) : '';
			if ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$cs_icons_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
						}
					}
				}
			}
			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
			} else {
				$value = $std;
			}

			$cs_icons_rand_id = time();

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '"';
			$html_id_btn = ' id="cs_icons_' . sanitize_html_class($id) . '_btn"';
			$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_rand_id . '"';
				$html_id_btn = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_rand_id . '_btn"';
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '_array[]"';
			}

			$cs_icons_output .= '<input type="text" class="cs-form-text cs-input" ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';
			$cs_icons_output .= '<label class="cs-browse">';
			$cs_icons_output .= '<input type="button" ' . $html_id_btn . $html_name . ' class="uploadfile left" value="' . cs_icons_manager_text_srt( 'cs_icons_form_fields_browse' ) . '"/>';
			$cs_icons_output .= '</label>';

			if ( isset($return) && $return == true ) {
				return $cs_icons_output;
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render File Upload field
		 */
		public function cs_icons_form_fileupload_render($params = '') {
			global $post, $pagenow, $image_val, $cs_icons_html_fields;
			extract($params);



			$std = isset($std) ? $std : '';
			$cs_icons_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, 'cs_icons_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$cs_icons_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
						}
					}
				}
			} else {
				$cs_icons_value = $std;
			}

			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
				if ( isset($dp) && $dp == true ) {
					$value = cs_icons_get_img_url($cs_icons_value, 'cs_icons_media_5');
				} else {
					$value = $cs_icons_value;
				}
			} else {
				$std = ( isset($std) ) ? $std : '';
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . '_rand"';
			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '_rand"';
			$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '_array[]"';
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

			$cs_icons_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

			$cs_icons_output .= '<label ' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-icons-uploadMedia left" value=' . cs_icons_manager_text_srt( 'cs_icons_form_fields_browse' ) . ' /></label>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		/**
		 * @ render Custom File Upload field
		 */
		public function cs_icons_form_custom_fileupload_render($params = '') {
			global $post, $pagenow, $image_val;
			extract($params);

			$cs_icons_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, 'cs_icons_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$cs_icons_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
						}
					}
				}
			} else {
				$cs_icons_value = $std;
			}
			$imagename_only = '';
			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
				$imagename_only = $cs_icons_value;
				if ( isset($dp) && $dp == true ) {
					$value = cs_icons_get_img_url($cs_icons_value, 'cs_icons_media_5');
				} else {
					$value = $cs_icons_value;
				}
			} else {
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . '_media"';
			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '"';
			$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . '_media' . $cs_icons_random_id . '"';
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '_array[]"';
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

			$cs_icons_classes = '';
			if ( isset($classes) && $classes != '' ) {
				$cs_icons_classes = ' class="' . $classes . '"';
			}

			$cs_icons_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $imagename_only . '"/>';

			$cs_icons_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="file" class="' . $cs_icons_classes . '" value=' . cs_icons_manager_text_srt( 'cs_icons_form_fields_browse' ) . ' /></label>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}


		/**
		 * @ render Random String
		 */
		public function cs_icons_generate_random_string($length = 3) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ( $i = 0; $i < $length; $i ++ ) {
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}

		public function cs_icons_img_upload_button($params = '') {
			global $post, $pagenow, $image_val, $cs_icons_plugin_static_text;
			extract($params);

			$cs_icons_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, 'cs_icons_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$cs_icons_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
						}
					}
				}
			} else {
				$cs_icons_value = $std;
			}

			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
				if ( isset($dp) && $dp == true ) {
					$value = cs_icons_get_img_url($cs_icons_value, 'cs_icons_media_6');
				} else {
					$value = $cs_icons_value;
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

			$cs_icons_random_id = '';
			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '"';
			if ( isset($array) && $array == true ) {
				$cs_icons_random_id = rand(12345678, 98765432);
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
			}

			$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';
			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '"';
			$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '_array[]"';
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

			$cs_icons_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';
			$cs_icons_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-uploadMedia left" value=' . cs_icons_manager_text_srt( 'cs_icons_form_fields_browse' ) . ' /></label>';
			$cs_icons_output .= '<div class="page-wrap" ' . $display . ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '_box">';
			$cs_icons_output .= '<div class="gal-active">';
			$cs_icons_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
			$cs_icons_output .= '<ul id="gal-sortable">';
			$cs_icons_output .= '<li class="ui-state-default" id="">';
			$cs_icons_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '_img" width="100" alt="" />';
			$cs_icons_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '\')" class="delete delImgMedia"></a> </div>';
			$cs_icons_output .= '</div>';
			$cs_icons_output .= '</li>';
			$cs_icons_output .= '</ul>';
			$cs_icons_output .= '</div>';
			$cs_icons_output .= '</div>';
			$cs_icons_output .= '</div>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

		public function cs_icons_form_attachemnt_fileupload_render($params = '') {
			global $post, $pagenow, $image_val, $cs_icons_html_fields;
			extract($params);



			$std = isset($std) ? $std : '';
			$cs_icons_output = '';
			if ( $pagenow == 'post.php' ) {

				if ( isset($dp) && $dp == true ) {
					$cs_icons_value = get_post_meta($post->ID, $id, true);
				} else {
					$cs_icons_value = get_post_meta($post->ID, 'cs_icons_' . $id, true);
				}
			} elseif ( isset($usermeta) && $usermeta == true ) {
				if ( isset($cus_field) && $cus_field == true ) {
					$cs_icons_value = get_the_author_meta($id, $user->ID);
				} else {
					if ( isset($dp) && $dp == true ) {
						$cs_icons_value = get_the_author_meta($id, $user->ID);
					} else {
						if ( isset($id) && $id != '' ) {
							$cs_icons_value = get_the_author_meta('cs_icons_' . $id, $user->ID);
						}
					}
				}
			} else {
				$cs_icons_value = $std;
			}

			if ( isset($cs_icons_value) && $cs_icons_value != '' ) {
				$value = $cs_icons_value;
				if ( isset($dp) && $dp == true ) {
					$value = cs_icons_get_img_url($cs_icons_value, 'cs_icons_media_5');
				} else {
					$value = $cs_icons_value;
				}
			} else {
				$std = ( isset($std) ) ? $std : '';
				$value = $std;
			}

			if ( isset($force_std) && $force_std == true ) {
				$value = $std;
			}

			if ( isset($array) && $array == true ) {
				$cs_icons_random_id = rand(12345678, 98765432);
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
			}

			$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . '_rand"';
			$html_id = ' id="cs_icons_' . sanitize_html_class($id) . '_rand"';
			$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '"';

			if ( isset($array) && $array == true ) {
				$btn_name = ' name="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
				$html_id = ' id="cs_icons_' . sanitize_html_class($id) . $cs_icons_random_id . '"';
				$html_name = ' name="cs_icons_' . sanitize_html_class($id) . '_array[]"';
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

			$cs_icons_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

			$cs_icons_output .= '<label ' . $display_btn . ' class="browse-icon"><input' . $btn_name . $allowd_extensions_attr . ' type="button" class="cs-attachment-uploadMedia left" value=' . cs_icons_manager_text_srt( 'cs_icons_form_fields_browse' ) . ' /></label>';

			if ( isset($return) && $return == true ) {
				return force_balance_tags($cs_icons_output);
			} else {
				echo force_balance_tags($cs_icons_output);
			}
		}

	}

	global $cs_icons_form_fields;
	$cs_icons_form_fields = new cs_icons_form_fields();
}
