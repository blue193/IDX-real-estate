<?php

/**
 * File Type: Form Fields
 */
if (!class_exists('wp_rem_html_fields_frontend')) {

    class wp_rem_html_fields_frontend extends wp_rem_form_fields_frontend {

        private $counter = 0;

        public function __construct() {
            // Do something...
        }

        /* ----------------------------------------------------------------------
         * @ render label
         * --------------------------------------------------------------------- */

        public function wp_rem_form_label($name = 'Label Not defined') {
            global $post, $pagenow;

            $wp_rem_output = '<li class="to-label">';
            $wp_rem_output .= '<label>' . $name . '</label>';
            $wp_rem_output .= '</li>';

            return $wp_rem_output;
        }

        /**
         * @ render description
         */
        public function wp_rem_form_description($description = '') {
            global $post, $pagenow;
            if ($description == '') {
                return;
            }
            $wp_rem_output = '<div class="left-info">';
            $wp_rem_output .= '<p>' . $description . '</p>';
            $wp_rem_output .= '</div>';
            return $wp_rem_output;
        }

        /**
         * @ render Headings
         */
        public function wp_rem_heading_render($params = '') {
            global $post;
            extract($params);
            $wp_rem_output = '<div class="theme-help" id="' . sanitize_html_class($id) . '">
                            <h4 style="padding-bottom:0px;">' . esc_attr($name) . '</h4>
                            <div class="clear"></div>
                          </div>';
            echo force_balance_tags($wp_rem_output);
        }

        /**
         * @ render text field
         */
        public function wp_rem_form_text_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $wp_rem_output = '';
            $std = '';
            $id = '';

            $prefix_enable = 'true'; // default value of prefix add in name and id

            if (isset($prefix_on)) {
                $prefix_enable = $prefix_on;
            }

            $prefix = 'wp_rem_'; // default prefix
            if (isset($field_prefix) && $field_prefix != '') {
                $prefix = $field_prefix;
            }
            if ($prefix_enable != true) {
                $prefix = '';
            }
            if ($pagenow == 'post.php') {
                if (isset($cus_field) && $cus_field == true) {
                    $wp_rem_value = get_post_meta($post->ID, $id, true);
                } else {
                    $wp_rem_value = get_post_meta($post->ID, $prefix . $id, true);
                }
            } else {
                $wp_rem_value = isset($std) ? $std : '';
            }

            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }

            $wp_rem_rand_id = time();

            if (isset($rand_id) && $rand_id != '') {
                $wp_rem_rand_id = $rand_id;
            }
            $wp_rem_output = '';

            $wp_rem_styles = '';
            if (isset($styles) && $styles != '') {
                $wp_rem_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';

              if (isset($cus_field) && $cus_field == true) {
                $html_name = ' name="' . $prefix . 'cus_field[' . sanitize_html_class($id) . ']"';
            } else {
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '"';
            }

            if (isset($array) && $array == true) {
                $html_id = ' id="' . $prefix . sanitize_html_class($id) . $wp_rem_rand_id . '"';
                $html_name = ' name="' . $prefix . sanitize_html_class($id) . '_array[]"';
            }

            if (isset($cust_id) && $cust_id != '') {
                $html_id = ' id="' . $cust_id . '"';
            }

            if (isset($cust_name) && $cust_name != '') {
                $html_name = ' name="' . $cust_name . '"';
            }

            // Disabled Field
            $wp_rem_visibilty = '';
            if (isset($active) && $active == 'in-active') {
                $wp_rem_visibilty = 'readonly="readonly"';
            }

            $wp_rem_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_required = ' required="required"';
            }

            $wp_rem_classes = '';
            if (isset($classes) && $classes != '') {
                $wp_rem_classes = ' class="' . $classes . '"';
            }
            $extra_atributes = '';
            if (isset($extra_atr) && $extra_atr != '') {
                $extra_atributes = $extra_atr;
            }

            $wp_rem_input_type = 'text';
            if (isset($cust_type) && $cust_type != '') {
                $wp_rem_input_type = $cust_type;
            }

            $wp_rem_icon = '';
            $wp_rem_icon = (isset($icon) and $icon <> '') ? '<i class="' . $icon . '"></i>' : '';
            if (isset($wp_rem_before) && $wp_rem_before != '') {
                $wp_rem_output .= '<div class="' . $wp_rem_before . '">';
            }
            if (isset($wp_rem_after) && $wp_rem_after != '') {
                $wp_rem_output .= '</div>';
            }



            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $wp_rem_output .= $wp_rem_icon;

            $wp_rem_output .= parent::wp_rem_form_text_render($field_params);



            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }
		
		/**
         * radio field markup
         * 
         */
        public function wp_rem_radio_field($params = '') {
            extract($params);
            $wp_rem_output = '';

            $wp_rem_output .= '
			<div class="input-sec">';
            $wp_rem_output .= parent::wp_rem_form_radio_render($field_params);
            $wp_rem_output .= $description;
            $wp_rem_output .= '
			</div>';

            if ( isset($echo) && $echo == true ) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render Radio field
         */
        public function wp_rem_form_radio_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_output = '<ul class="form-elements">';
            $wp_rem_output .= $this->wp_rem_form_label($name);
            $wp_rem_output .= '<li class="to-field">';
            $wp_rem_output .= '<div class="input-sec">';
            $wp_rem_output .= parent::wp_rem_form_radio_render($field_params);
            $wp_rem_output .= '</div>';
            $wp_rem_output .= $this->wp_rem_form_description($description);
            $wp_rem_output .= '</li>';
            $wp_rem_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render text field
         */
        public function wp_rem_form_hidden_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $wp_rem_rand_id = time();
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
            }
            $wp_rem_output .= parent::wp_rem_form_hidden_render($field_params);

            if (isset($return) && $return == true) {
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
            $wp_rem_styles = '';
            if (isset($styles) && $styles != '') {
                $wp_rem_styles = ' style="' . $styles . '"';
            }
            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_format = 'd-m-Y';
            if (isset($format) && $format != '') {
                $wp_rem_format = $format;
            }
            $wp_rem_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_required = ' required="required"';
            }
            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }
            $wp_rem_rand_id = time();
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            $wp_rem_piker_id = $id;
            if (isset($array) && $array == true) {
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
                $wp_rem_piker_id = $id . $wp_rem_rand_id;
            }
            if (isset($force_empty) && $force_empty == true) {
                $value = '';
            }
            $wp_rem_output = '<div  class="' . $classes . '">';
            $wp_rem_output .= '<script>
                                jQuery(function(){
                                    jQuery("#wp_rem_' . $wp_rem_piker_id . '").datetimepicker({
                                        format:"' . $wp_rem_format . '",
                                        minDate: new Date(),
                                        timepicker:false
                                    });
                                });
                          </script>';
            $wp_rem_output .= parent::wp_rem_form_date_render($field_params);
            $wp_rem_output .= $this->wp_rem_form_description($description);
            $wp_rem_output .= '</div>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render Textarea field
         */
        public function wp_rem_form_textarea_render($params = '') {
            global $post, $pagenow;
            extract($params);

            if (!isset($std)) {
                $std = '';
            }
            if (!isset($description)) {
                $description = '';
            }
            if (!isset($id)) {
                $id = '';
            }
            if ($pagenow == 'post.php') {
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            } else {
                $wp_rem_value = $std;
            }

            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_rand_id = time();
            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }

            $wp_rem_output = '';
            $wp_rem_styles = '';
            if (isset($styles) && $styles != '') {
                $wp_rem_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
            }
            $wp_rem_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_required = ' required="required"';
            }
            
            if (isset($wp_rem_before) && $wp_rem_before != '') {
                $wp_rem_output .= '<div class="' . $wp_rem_before . '">';
            }
            $wp_rem_output .= parent::wp_rem_form_textarea_render($field_params);
            $wp_rem_output .= $this->wp_rem_form_description($description);
            $wp_rem_output .= '</div>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render Rich edito field
         */
        public function wp_rem_form_editor_render($params = '') {
            global $post, $pagenow;
            extract($params);
            if ($pagenow == 'post.php') {
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            } else {
                $wp_rem_value = $std;
            }
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_output = '<div class="input-info">';
            $wp_rem_output .= '<div class="row">';
            $wp_rem_output .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            ob_start();
            wp_editor($value, 'wp_rem_' . sanitize_html_class($id), $settings = array('textarea_name' => 'wp_rem_' . sanitize_html_class($id), 'editor_class' => 'text-input', 'teeny' => true, 'media_buttons' => false, 'textarea_rows' => 8, 'quicktags' => false));
            $wp_rem_editor_contents = ob_get_clean();
            $wp_rem_output .= $wp_rem_editor_contents;
            $wp_rem_output .= '</div>';
            $wp_rem_output .= $this->wp_rem_form_description($description);
            $wp_rem_output .= '</div>';
            $wp_rem_output .= '</div>';
            if (isset($return) && $return == true) {
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
            if (isset($std) && $std <> '') {
                $std = $std;
            } else {
                $std = '';
            }
            if (isset($id) && $id <> '') {
                $id = $id;
            } else {
                $id = '';
            }
            if (isset($extra_att) && $extra_att <> '') {
                $extra_att = $extra_att;
            } else {
                $extra_att = '';
            }
            $wp_rem_onchange = '';
            if ($pagenow == 'post.php') {
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            } else {
                $wp_rem_value = $std;
            }
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_output = '';
            $wp_rem_styles = '';
            if (isset($styles) && $styles != '') {
                $wp_rem_styles = ' style="' . $styles . '"';
            }
            if (isset($description) && $description != '') {
                $description = $description;
            } else {
                $value = '';
            }
            $wp_rem_rand_id = time();
            $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
                $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
            }
            $wp_rem_display = '';
            if (isset($status) && $status == 'hide') {
                $wp_rem_display = 'style=display:none';
            }
            if (isset($onclick) && $onclick != '') {
                $wp_rem_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
            }
            $wp_rem_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_required = ' required="required"';
            }
            $wp_rem_output .= parent::wp_rem_form_select_render($field_params);
           if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render Multi Select field
         */
        public function wp_rem_form_multiselect_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $wp_rem_output = '';
            $wp_rem_styles = '';
            if (isset($styles) && $styles != '') {
                $wp_rem_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';

            $wp_rem_onchange = '';
            if ($pagenow == 'post.php') {
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            } else {
                $wp_rem_value = $std;
            }
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_rand_id = time();
            $html_wraper = ' id="wrapper_' . sanitize_html_class($id) . '"';
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '[]"';
            $wp_rem_display = '';
            if (isset($status) && $status == 'hide') {
                $wp_rem_display = 'style=display:none';
            }
            if (isset($onclick) && $onclick != '') {
                $wp_rem_onchange = 'onchange="javascript:' . $onclick . '(this.value, \'' . esc_js(admin_url('admin-ajax.php')) . '\')"';
            }
            if (!is_array($value)) {
                $value = array();
            }
            $wp_rem_required = '';
            if (isset($required) && $required == 'yes') {
                $wp_rem_required = ' required="required"';
            }
            $wp_rem_output = '<ul class="form-elements"' . $html_wraper . ' ' . $wp_rem_display . '>';
            $wp_rem_output .= $this->wp_rem_form_label($name);
            $wp_rem_output .= '<li class="to-field multiple">';

            $wp_rem_output .= parent::wp_rem_form_multiselect_render($field_params);

            $wp_rem_output .= $this->wp_rem_form_description($description);
            $wp_rem_output .= '</li>';
            $wp_rem_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render Checkbox field
         */
        public function wp_rem_form_checkbox_render($params = '') {
            global $post, $pagenow;
            extract($params);
            $id = isset( $id ) ? $id : '';
            $std = isset( $std ) ? $std : '';
            if ($pagenow == 'post.php') {
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            } else {
                $wp_rem_value = $std;
            }
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_output = '';
            $wp_rem_styles = '';
            if (isset($styles) && $styles != '') {
                $wp_rem_styles = ' style="' . $styles . '"';
            }

            $cust_id = isset($id) ? ' id="' . $id . '"' : '';
            $extra_attr = isset($extra_att) ? ' ' . $extra_att . ' ' : '';

            $wp_rem_rand_id = time();
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
                $btn_name = ' name="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
            }
            if( isset( $field_params['id'] ) && $field_params['id'] != '' ){
                $checkbox_id    = $html_id = 'wp_rem_' . sanitize_html_class($field_params['id']);
            }
            $checked = isset($value) && $value == 'on' ? ' checked="checked"' : '';
            $wp_rem_output       = '';
            if( isset( $simple ) && $simple != true ){
                $wp_rem_output .= '<ul class="form-elements">';
                $wp_rem_output .= '<li class="to-field has_input">';
            }
            $wp_rem_output .= parent::wp_rem_form_checkbox_render($field_params);
            $wp_rem_output .= '<label for="' . $checkbox_id . '">';
                $wp_rem_output .= $name;
            $wp_rem_output .= '</label>';
            if( isset( $simple ) && $simple != true ){
                $wp_rem_output .= '<span class="pbwp-box"></span>';
                $wp_rem_output .= $this->wp_rem_form_description($description);
                $wp_rem_output .= '</li>';
                $wp_rem_output .= '</ul>';
            }
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render File Upload field
         */
        public function wp_rem_media_url($params = '') {
            global $post, $pagenow;
            extract($params);
            $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            $wp_rem_rand_id = time();
            if (isset($force_std) && $force_std == true) {
                $value = $std;
            }
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $html_id_btn = ' id="wp_rem_' . sanitize_html_class($id) . '_btn"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '"';
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_rand_id . '_btn"';
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
            }
            $wp_rem_output = '<ul class="form-elements">';
            $wp_rem_output .= $this->wp_rem_form_label($name);
            $wp_rem_output .= '<li class="to-field">';
            $wp_rem_output .= '<div class="input-sec">';
            $wp_rem_output .= parent::wp_rem_media_url($field_params);
            $wp_rem_output .= '</div>';
            $wp_rem_output .= $this->wp_rem_form_description($description);
            $wp_rem_output .= '</li>';
            $wp_rem_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render File Upload field
         */
        public function wp_rem_form_fileupload_render($params = '') {
            global $post, $pagenow;
            extract($params);
            if ($pagenow == 'post.php') {
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            } else {
                $wp_rem_value = $std;
            }
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            if (isset($value) && $value != '') {
                $display = 'style=display:block';
            } else {
                $display = 'style=display:none';
            }
            $class = '';
            if (isset($value) && $classes != '') {
                $class = " " . $classes;
            }
            $wp_rem_random_id = WP_REM_FUNCTIONS()->rand_id();
            $btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $btn_name = ' name="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
            }
            $wp_rem_output = '<ul class="form-elements">';
            $wp_rem_output .= $this->wp_rem_form_label($name);
            $wp_rem_output .= '<li class="to-field">';
            $wp_rem_output .= '<div class="page-wrap" ' . $display . ' id="wp_rem_' . sanitize_html_class($id) . '_box">';
            $wp_rem_output .= '<div class="gal-active">';
            $wp_rem_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $wp_rem_output .= '<ul id="gal-sortable">';
            $wp_rem_output .= '<li class="ui-state-default" id="">';
            $wp_rem_output .= '<div class="thumb-secs"> <img src="' . esc_url($value) . '" id="wp_rem_' . sanitize_html_class($id) . '_img" width="100" alt="" />';
            $wp_rem_output .= '<div class="gal-edit-opts"><a href="javascript:del_media(\'wp_rem_' . sanitize_html_class($id) . '\')" class="delete"></a> </div>';
            $wp_rem_output .= '</div>';
            $wp_rem_output .= '</li>';
            $wp_rem_output .= '</ul>';
            $wp_rem_output .= '</div>';
            $wp_rem_output .= '</div>';
            $wp_rem_output .= '</div>';
            $wp_rem_output .= parent::wp_rem_form_fileupload_render($field_params);
            $wp_rem_output .= '</li>';
            $wp_rem_output .= '</ul>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render File Upload field
         */
        public function wp_rem_form_cvupload_render($params = '') {
            global $post, $pagenow;
            extract($params);
            if ($pagenow == 'post.php') {
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $id, true);
            } else {
                $wp_rem_value = $std;
            }
            if (isset($wp_rem_value) && $wp_rem_value != '') {
                $value = $wp_rem_value;
            } else {
                $value = $std;
            }
            if (isset($value) && $value != '') {
                $display = 'style=display:block';
            } else {
                $display = 'style=display:none';
            }
            $wp_rem_random_id = WP_REM_FUNCTIONS()->rand_id();
            $btn_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            $html_id = ' id="wp_rem_' . sanitize_html_class($id) . '"';
            $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '"';
            if (isset($array) && $array == true) {
                $btn_name = ' name="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
                $html_id = ' id="wp_rem_' . sanitize_html_class($id) . $wp_rem_random_id . '"';
                $html_name = ' name="wp_rem_' . sanitize_html_class($id) . '_array[]"';
            }
            $wp_rem_output = '<div class="cs-img-detail resume-upload">';
            $wp_rem_output = '<div class="upload-btn-div">';
            $wp_rem_output .= '<div class="dragareamain" style="padding-bottom:0px;">';
            $wp_rem_output .= parent::wp_rem_form_hidden_render($field_params);
            $wp_rem_output .= '<input' . $btn_name . 'type="button" class="cs-uploadMedia uplaod-btn" value="' .  wp_rem_plugin_text_srt('wp_rem_form_fields_brows') . '"/>';
            $wp_rem_output .= '<div class="alert alert-dismissible user-resume" id="wp_rem_' . sanitize_html_class($id) . '_img">';
            if (isset($value) and $value <> '') {
                $wp_rem_output .= '<div>' . basename($value);
                $wp_rem_output .= '<button aria-label="Close" data-dismiss="alert" class="close" type="button">';
                $wp_rem_output .= '<span aria-hidden="true" class="cs-color">×</span>';
                $wp_rem_output .= '</button>';
                $wp_rem_output .= '<a href="javascript:wp_rem_del_media(\'wp_rem_' . sanitize_html_class($id) . '\')" class="delete"></a></div>';
            }
            $wp_rem_output .= '</div>';
            $wp_rem_output .= '</div>';
            $wp_rem_output .= '</div>';
            if (isset($echo) && $echo == true) {
                echo force_balance_tags($wp_rem_output);
            } else {
                return $wp_rem_output;
            }
        }

        /**
         * @ render Random String
         */
        public function wp_rem_generate_random_string($length = 3) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }
            return $randomString;
        }

    }

    global $wp_rem_html_fields_frontend;
    $wp_rem_html_fields_frontend = new wp_rem_html_fields_frontend();
}