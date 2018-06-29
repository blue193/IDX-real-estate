<?php

/**
 * Form Fields
 */
if (!class_exists('wp_rem_cs_var_form_fields')) {

    class wp_rem_cs_var_form_fields {

        private $counter = 0;

        public function __construct() {

            // Do something...
        }

        /**
         * @ render label
         */
        public function wp_rem_cs_var_form_text_render($params = '') {

            global $post, $pagenow, $user;

            if (isset($params) && is_array($params)) {
                extract($params);
            }
            $wp_rem_cs_var_output = '';
            $prefix_enable = 'true'; // default value of prefix add in name and id
            if (!isset($id)) {
                $id = '';
            }
            if (!isset($std)) {
                $std = '';
            }

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'wp_rem_cs_var_'; // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php' && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                    }
                }
            } else {
                $wp_rem_cs_var_value = isset($std) ? $std : '';
            }
            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $wp_rem_cs_var_rand_id = time();

            if (isset($rand_id) && $rand_id != '') {
                $wp_rem_cs_var_rand_id = $rand_id;
            }

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            // Disabled Field
            $wp_rem_cs_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $wp_rem_cs_var_visibilty = 'readonly="readonly"';
            }

            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }

            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $wp_rem_cs_var_input_type = 'text';
            if (isset($cust_type) && $cust_type != '') {
                $wp_rem_cs_var_input_type = $cust_type;
            }

            $wp_rem_cs_var_before = '';
            if (isset($before) && $before != '') {
                $wp_rem_cs_var_before = '<div class="' . $before . '">';
            }

            $wp_rem_cs_var_after = '';
            if (isset($after) && $after != '') {
                $wp_rem_cs_var_after = $after;
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            if (isset($rang) && $rang == true && isset($min) && isset($max)) {}
            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                $wp_rem_cs_var_output .= '<ul><li class="to-field"><div class="cs-drag-slider" data-slider-min="' . $min . '" data-slider-max="' . $max . '" data-slider-step="1" data-slider-value="' . $value . '"></div>';
            }
            
            $wp_rem_cs_var_output .= $wp_rem_cs_var_before;
            if ($value != '') {
                $wp_rem_cs_var_output .= '<input type="' . $wp_rem_cs_var_input_type . '" ' . $wp_rem_cs_var_visibilty . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $wp_rem_cs_var_classes . ' ' . $html_id . $html_name . ' value="' . $value . '" />';
            } else {
                $wp_rem_cs_var_output .= '<input type="' . $wp_rem_cs_var_input_type . '" ' . $wp_rem_cs_var_visibilty . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $wp_rem_cs_var_classes . ' ' . $html_id . $html_name . ' />';
            }
            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                $wp_rem_cs_var_output .= "</li></ul>";
            }
            $wp_rem_cs_var_output .= $wp_rem_cs_var_after;

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Radio field
         */
        public function wp_rem_cs_var_form_radio_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $wp_rem_cs_var_output = '';

            if (!isset($id)) {
                $id = '';
            }

            $prefix_enable = 'true'; // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'wp_rem_cs_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            if ($pagenow == 'post.php' && $id != '') {
                $wp_rem_cs_var_value = get_post_meta($post->ID, 'wp_rem_cs_var_' . $id, true);
                if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                    $value = $wp_rem_cs_var_value;
                } else {
                    $value = $std;
                }
            } else {
                $value = $std;
            }

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $html_id = isset($html_id) ? $html_id : '';

            // Disbaled Field
            $wp_rem_cs_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $wp_rem_cs_var_visibilty = 'readonly="readonly"';
            }
            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }
            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }

            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            $wp_rem_cs_var_output .= '<input type="radio" ' . $wp_rem_cs_var_visibilty . $wp_rem_cs_var_required . ' ' . $wp_rem_cs_var_classes . ' ' . $extra_atributes . ' ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Radio field
         */
        public function wp_rem_cs_var_form_hidden_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $wp_rem_cs_var_rand_id = time();

            if (!isset($id)) {
                $id = '';
            }
            $html_id = '';
            $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }

            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            $wp_rem_cs_var_output = '<input type="hidden" ' . $html_id . ' ' . $wp_rem_cs_var_classes . ' ' . $extra_atributes . ' ' . $html_name . ' value="' . sanitize_text_field($std) . '" />';
            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Date field
         */
        public function wp_rem_cs_var_form_date_render($params = '') {

            global $post, $pagenow, $user;
            $wp_rem_cs_var_format = 'd-m-Y';
            if (isset($format) && $format != '') {
                $wp_rem_cs_var_format = $format;
            }

            if (isset($params) && is_array($params)) {
                extract($params);
            }
            $wp_rem_cs_var_output = '';
            $prefix_enable = 'true'; // default value of prefix add in name and id
            if (!isset($id)) {
                $id = '';
            }
            if (!isset($std)) {
                $std = '';
            }

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'wp_rem_cs_var_'; // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php' && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                    }
                }
            } else {
                $wp_rem_cs_var_value = isset($std) ? $std : '';
            }
            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $wp_rem_cs_var_rand_id = time();

            if (isset($rand_id) && $rand_id != '') {
                $wp_rem_cs_var_rand_id = $rand_id;
            }

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            // Disabled Field
            $wp_rem_cs_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $wp_rem_cs_var_visibilty = 'readonly="readonly"';
            }

            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }

            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $wp_rem_cs_var_input_type = 'text';
            if (isset($cust_type) && $cust_type != '') {
                $wp_rem_cs_var_input_type = $cust_type;
            }

            $wp_rem_cs_var_before = '';
            if (isset($before) && $before != '') {
                $wp_rem_cs_var_before = '<div class="' . $before . '">';
            }

            $wp_rem_cs_var_after = '';
            if (isset($after) && $after != '') {
                $wp_rem_cs_var_after = $after;
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            if (isset($rang) && $rang == true && isset($min) && isset($max)) {
                $wp_rem_cs_var_output .= '<div class="cs-drag-slider" data-slider-min="' . absint($min) . '" data-slider-max="' . absint($max) . '" data-slider-step="1" data-slider-value="' . $value . '">';
            }
            $wp_rem_cs_var_output .= $wp_rem_cs_var_before;
			
			$wp_rem_cs_var_output .= '<script>
                                jQuery(function(){
                                    jQuery("#' . $cust_id . '").datetimepicker({
                                        format:"' . $wp_rem_cs_var_format . '",
                                        minDate: new Date(),
                                        timepicker:false
                                    });
                                });
                          </script>';
			
			if ($value != '') {
                $wp_rem_cs_var_output .= '<input type="' . $wp_rem_cs_var_input_type . '" ' . $wp_rem_cs_var_visibilty . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $wp_rem_cs_var_classes . ' ' . $html_id . $html_name . ' value="' . $value . '" />';
            } else {
                $wp_rem_cs_var_output .= '<input type="' . $wp_rem_cs_var_input_type . '" ' . $wp_rem_cs_var_visibilty . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $wp_rem_cs_var_classes . ' ' . $html_id . $html_name . ' />';
            }

            $wp_rem_cs_var_output .= $wp_rem_cs_var_after;

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Textarea field
         */
        public function wp_rem_cs_var_form_textarea_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $wp_rem_cs_var_output = '';
            if (!isset($id)) {
                $id = '';
            }
			
			if ($pagenow == 'post.php') {
				
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $id, true);
				} else {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, 'wp_rem_cs_var_' . $id, true);
				}
			} elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                    }
                }
            } else {
                $wp_rem_cs_var_value = $std;
            }
			
			if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }

            $wp_rem_cs_var_rand_id = time();

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . '"';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="wp_rem_cs_var_cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }
            $wp_rem_cs_var_before = '';
            if (isset($before) && $before != '') {
                $wp_rem_cs_var_before = '<div class="' . $before . '">';
            }

            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }

            $wp_rem_cs_var_after = '';
            if (isset($after) && $after != '') {
                $wp_rem_cs_var_after = '</div>';
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            $wp_rem_cs_var_output .= $wp_rem_cs_var_before;
            $wp_rem_cs_var_output .= ' <textarea' . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $html_id . $html_name . $wp_rem_cs_var_classes . '>' . $value . '</textarea>';
            $wp_rem_cs_var_output .= $wp_rem_cs_var_after;

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render select field
         */
        public function wp_rem_cs_var_form_select_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $prefix_enable = 'true';    // default value of prefix add in name and id
            if (!isset($id)) {
                $id = '';
            }
            $wp_rem_cs_var_output = '';

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'wp_rem_cs_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            $wp_rem_cs_var_onchange = '';

            if ($pagenow == 'post.php' && $id != '') {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                    }
                }
            } else {
                $wp_rem_cs_var_value = $std;
            }

            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }

            $wp_rem_cs_var_rand_id = time();
            if (isset($rand_id) && $rand_id != '') {
                $wp_rem_cs_var_rand_id = $rand_id;
            }

            $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
                $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $wp_rem_cs_var_display = '';
            if (isset($status) && $status == 'hide') {
                $wp_rem_cs_var_display = 'style=display:none';
            }

            if (isset($onclick) && $onclick != '') {
                $wp_rem_cs_var_onchange = 'onchange="' . $onclick . '"';
            }

            $wp_rem_cs_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $wp_rem_cs_var_visibilty = 'readonly="readonly"';
            }
            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }
            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if (isset($markup) && $markup != '') {
                $wp_rem_cs_var_output .= $markup;
            }

            if (isset($div_classes) && $div_classes <> "") {
                $wp_rem_cs_var_output .= '<div class="' . esc_attr($div_classes) . '">';
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            $wp_rem_cs_var_output .= '<select ' . $wp_rem_cs_var_visibilty . ' ' . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $wp_rem_cs_var_classes . ' ' . $html_id . $html_name . ' ' . $wp_rem_cs_var_onchange . ' >';
            if (isset($options_markup) && $options_markup == true) {
                $wp_rem_cs_var_output .= $options;
            } else {
                if (isset($first_option) && $first_option <> "") {
                    $wp_rem_cs_var_output .= $first_option;
                }
                if (is_array($options)) {
                    foreach ($options as $key => $option) {
                        if (!is_array($option)) {
                            $wp_rem_cs_var_output .= '<option ' . selected($key, $value, false) . ' value="' . $key . '">' . $option . '</option>';
                        }
                    }
                }
            }
            $wp_rem_cs_var_output .= '</select>';

            if (isset($div_classes) && $div_classes <> "") {
                $wp_rem_cs_var_output .= '</div>';
            }

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Multi Select field
         */
        public function wp_rem_cs_var_form_multiselect_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $wp_rem_cs_var_output = '';

            $prefix_enable = 'true';    // default value of prefix add in name and id
            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'wp_rem_cs_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            $wp_rem_cs_var_onchange = '';

            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                    }
                }
            } else {
                $wp_rem_cs_var_value = $std;
            }
            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }
            $wp_rem_cs_var_rand_id = time();
            if (isset($rand_id) && $rand_id != '') {
                $wp_rem_cs_var_rand_id = $rand_id;
            }
            $html_wraper = '';
            if (isset($id) && $id != '') {
                $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            }
            $html_id = '';
            if (isset($id) && $id != '') {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            }
            $html_name = '';
            if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . '][]"';
            } else {
                if (isset($id) && $id != '') {
                    $html_name = ' name="' . $prefix . sanitize_html_class($id) . '[]"';
                }
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $wp_rem_cs_var_display = '';
            if (isset($status) && $status == 'hide') {
                $wp_rem_cs_var_display = 'style=display:none';
            }

            if (isset($onclick) && $onclick != '') {
                $wp_rem_cs_var_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
            }

            if (!is_array($value) && $value != '') {
                $value = explode(',', $value);
            }

            if (!is_array($value)) {
                $value = array();
            }

            // Disbaled Field
            $wp_rem_cs_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $wp_rem_cs_var_visibilty = 'readonly="readonly"';
            }
            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }
            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="multiple ' . $classes . '"';
            } else {
                $wp_rem_cs_var_classes = ' class="multiple"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            $wp_rem_cs_var_output .= '<select' . $wp_rem_cs_var_visibilty . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $wp_rem_cs_var_classes . ' ' . ' multiple="multiple" ' . $html_id . $html_name . ' ' . $wp_rem_cs_var_onchange . ' style="height:110px !important;">';

            if (isset($options_markup) && $options_markup == true) {
                $wp_rem_cs_var_output .= $options;
            } else {
                foreach ($options as $key => $option) {
                    $selected = '';
                    if (in_array($key, $value)) {
                        $selected = 'selected="selected"';
                    }

                    $wp_rem_cs_var_output .= '<option ' . $selected . 'value="' . $key . '">' . $option . '</option>';
                }
            }
            $wp_rem_cs_var_output .= '</select>';

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Checkbox field
         */
        public function wp_rem_cs_var_form_checkbox_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $prefix_enable = 'true';    // default value of prefix add in name and id

            $wp_rem_cs_var_output = '';

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            if (!isset($id)) {
                $id = '';
            }

            $prefix = 'wp_rem_cs_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php') {
                $wp_rem_cs_var_value = get_post_meta($post->ID, 'wp_rem_cs_var_' . $id, true);
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                    }
                }
            } else {
                $wp_rem_cs_var_value = $std;
            }

            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }

            $wp_rem_cs_var_rand_id = time();

            $html_id = ' id="' . $prefix . sanitize_html_class($id) . '"';
            $btn_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $btn_name = ' name="' . $prefix . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                $html_name = ' name="' . $cust_name . '"';
            }

            $checked = isset($value) && $value == 'on' ? ' checked="checked"' : '';
            // Disbaled Field
            $wp_rem_cs_var_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $wp_rem_cs_var_visibilty = 'readonly="readonly"';
            }
            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }
            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_var_"') {
                $html_id = '';
            }

            if (isset($simple) && $simple == true) {
                if ($value == '') {
                    $wp_rem_cs_var_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $wp_rem_cs_var_classes . ' ' . $checked . ' ' . $extra_atributes . ' />';
                } else {
                    $wp_rem_cs_var_output .= '<input type="checkbox" ' . $html_id . $html_name . ' ' . $wp_rem_cs_var_classes . ' ' . $checked . ' value="' . $value . '"' . $extra_atributes . ' />';
                }
            } else {
                $wp_rem_cs_var_output .= '<label class="pbwp-checkbox cs-chekbox">';
                $wp_rem_cs_var_output .= '<input type="hidden"' . $html_id . $html_name . ' value="' . sanitize_text_field($std) . '" />';
                $wp_rem_cs_var_output .= '<input type="checkbox" ' . $wp_rem_cs_var_classes . ' ' . $btn_name . $checked . ' ' . $extra_atributes . ' />';
                $wp_rem_cs_var_output .= '<span class="pbwp-box"></span>';
                $wp_rem_cs_var_output .= '</label>';
            }

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Checkbox With Input Field
         */
        public function wp_rem_cs_var_form_checkbox_with_field_render($params = '') {
            global $post, $pagenow;
            extract($params);
            extract($field);
            $prefix_enable = 'true';    // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'wp_rem_cs_var_';    // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }

            $wp_rem_cs_var_value = get_post_meta($post->ID, $prefix . $id, true);
            if (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($id) && $id != '') {
                        $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                    }
                }
            }
            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }

            $wp_rem_cs_var_input_value = get_post_meta($post->ID, $prefix . $field_id, true);
            if (isset($wp_rem_cs_var_input_value) && $wp_rem_cs_var_input_value != '') {
                $input_value = $wp_rem_cs_var_input_value;
            } else {
                $input_value = $field_std;
            }

            $wp_rem_cs_var_visibilty = ''; // Disbaled Field
            if (isset($active) && $active == 'in-active') {
                $wp_rem_cs_var_visibilty = 'readonly="readonly"';
            }
            $wp_rem_cs_var_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_cs_var_required = ' required';
            }
            $wp_rem_cs_var_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_var_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $wp_rem_cs_var_output .= '<label class="pbwp-checkbox">';
            $wp_rem_cs_var_output .= $this->wp_rem_cs_var_form_hidden_render(array('id' => $id, 'std' => '', 'type' => '', 'return' => 'return'));
            $wp_rem_cs_var_output .= '<input type="checkbox" ' . $wp_rem_cs_var_visibilty . $wp_rem_cs_var_required . ' ' . $extra_atributes . ' ' . $wp_rem_cs_var_classes . ' ' . ' name="' . $prefix . sanitize_html_class($id) . '" id="' . $prefix . sanitize_html_class($id) . '" value="' . sanitize_text_field('on') . '" ' . checked('on', $value, false) . ' />';
            $wp_rem_cs_var_output .= '<span class="pbwp-box"></span>';
            $wp_rem_cs_var_output .= '</label>';
            $wp_rem_cs_var_output .= '<input type="text" name="' . $prefix . sanitize_html_class($field_id) . '"  value="' . sanitize_text_field($input_value) . '">';
            $wp_rem_cs_var_output .= $this->wp_rem_cs_var_form_description($description);

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render File Upload field
         */
        public function wp_rem_cs_var_media_url($params = '') {
            global $post, $pagenow, $wp_rem_cs_var_static_text;
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_theme_option_field_strings();
            extract($params);

            $wp_rem_cs_var_output = '';

            $wp_rem_cs_var_value = isset($post->ID) ? get_post_meta($post->ID, 'wp_rem_cs_var_' . $id, true) : '';
            if (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                        }
                    }
                }
            }
            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
            } else {
                $value = $std;
            }

            $wp_rem_cs_var_rand_id = time();

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . '"';
            $html_id_btn = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . '_btn"';
            $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '"';
                $html_id_btn = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . $wp_rem_cs_var_rand_id . '_btn"';
                $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '_array[]"';
            }
            $wp_rem_cs_var_output .= '<input type="text" class="cs-form-text cs-input" ' . $html_id . $html_name . ' value="' . sanitize_text_field($value) . '" />';
            $wp_rem_cs_var_output .= '<label class="cs-browse">';
            $wp_rem_cs_var_output .= '<input type="button" ' . $html_id_btn . $html_name . ' class="uploadfile left" value="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_browse') . '"/>';
            $wp_rem_cs_var_output .= '</label>';

            if (isset($return) && $return == true) {
                return $wp_rem_cs_var_output;
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render File Upload field
         */
        public function wp_rem_cs_var_form_fileupload_render($params = '') {
            global $post, $pagenow, $image_val, $wp_rem_cs_var_static_text;
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_theme_option_field_strings();
            extract($params);

            $wp_rem_cs_var_output = '';
            if ($pagenow == 'post.php') {

                if (isset($dp) && $dp == true) {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, $id, true);
                } else {
                    $wp_rem_cs_var_value = get_post_meta($post->ID, 'wp_rem_cs_var_' . $id, true);
                }
            } elseif (isset($usermeta) && $usermeta == true) {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                } else {
                    if (isset($dp) && $dp == true) {
                        $wp_rem_cs_var_value = get_the_author_meta($id, $user->ID);
                    } else {
                        if (isset($id) && $id != '') {
                            $wp_rem_cs_var_value = get_the_author_meta('wp_rem_cs_var_' . $id, $user->ID);
                        }
                    }
                }
            } else {
                $wp_rem_cs_var_value = $std;
            }

            if (isset($wp_rem_cs_var_value) && $wp_rem_cs_var_value != '') {
                $value = $wp_rem_cs_var_value;
                if (isset($dp) && $dp == true) {
                    $value = wp_rem_cs_var_get_img_url($wp_rem_cs_var_value, 'wp_rem_cs_var_media_5');
                } else {
                    $value = $wp_rem_cs_var_value;
                }
            } else {
                $value = $std;
            }

            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $btn_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '"';
            $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $btn_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . $wp_rem_cs_var_random_id . '"';
                $html_id = ' id="wp_rem_cs_var_' . sanitize_html_class($id) . $wp_rem_cs_var_random_id . '"';
                $html_name = ' name="wp_rem_cs_var_' . sanitize_html_class($id) . '_array[]"';
            } else if (isset($dp) && $dp == true) {
                $html_name = ' name="' . sanitize_html_class($id) . '"';
            }

            if (isset($cust_name) && $cust_name == true) {
                $html_name = ' name="' . $cust_name . '"';
            }

            if (isset($value) && $value != '') {
                $display_btn = ' style=display:none';
            } else {
                $display_btn = ' style=display:block';
            }

            $wp_rem_cs_var_output .= '<input' . $html_id . $html_name . 'type="hidden" class="" value="' . $value . '"/>';

            $wp_rem_cs_var_output .= '<label' . $display_btn . ' class="browse-icon"><input' . $btn_name . 'type="button" class="cs-wp_rem_cs-media left" value=' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_browse') . ' /></label>';

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_var_output);
            } else {
                echo force_balance_tags($wp_rem_cs_var_output);
            }
        }

        /**
         * @ render Random String
         */
        public function wp_rem_cs_var_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

        /**
         * @ render submit field
         */
        public function wp_rem_cs_var_form_submit_render($params = '') {
            global $post, $pagenow;
            extract($params);

            $wp_rem_cs_rand_id = time();

            if (!isset($id)) {
                $id = '';
            }

            $html_id = ' id="wp_rem_cs_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_cs_' . sanitize_html_class($id) . '"';

            if (isset($array) && $array == true) {
                $html_name = ' name="wp_rem_cs_' . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name)) {
                if ($cust_name == '') {
                    $html_name = '';
                } else {
                    $html_name = ' name="' . $cust_name . '"';
                }
            }

            $wp_rem_cs_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_cs_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }
            if ($html_id == ' id=""' || $html_id == ' id="wp_rem_cs_"') {
                $html_id = '';
            }
            $wp_rem_cs_output = '<input type="submit" ' . $html_id . ' ' . $extra_atributes . ' ' . $wp_rem_cs_classes . ' ' . $html_name . ' value="' . sanitize_text_field($std) . '" />';

            if (isset($return) && $return == true) {
                return force_balance_tags($wp_rem_cs_output);
            } else {
                echo force_balance_tags($wp_rem_cs_output);
            }
        }

    }

    $var_arrays = array('wp_rem_cs_var_form_fields');
    $form_fields_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing($var_arrays);
    extract($form_fields_global_vars);
    $wp_rem_cs_var_form_fields = new wp_rem_cs_var_form_fields();
}

/**
 * 
 * @ render Wrapper Start
 */
function wp_rem_cs_wrapper_start_render($params = '') {
    global $post, $wp_rem_html_fields;
    extract($params);
    $wp_rem_cs_display = '';
    if (isset($status) && $status == 'hide') {
        $wp_rem_cs_display = 'style="display:none;"';
    }

    $wp_rem_cs_output = '<div class="wrapper_' . sanitize_html_class($id) . '" id="wrapper_' . sanitize_html_class($id) . '" ' . $wp_rem_cs_display . '>';
    echo wp_rem_cs_allow_special_char($wp_rem_cs_output);
}

/**
 * 
 * @ render Wrapper Start
 */
function wp_rem_cs_wrapper_end_render($params = '') {
    global $post, $wp_rem_html_fields;
    extract($params);

    $wp_rem_cs_output = '</div>';
    echo wp_rem_cs_allow_special_char($wp_rem_cs_output);
}