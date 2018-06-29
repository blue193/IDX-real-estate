<?php

if ( ! class_exists('foodbakery_maintenance_fields') ) {

    class foodbakery_maintenance_fields {

        /**
         * Construct
         *
         * @return
         */
        public function __construct() {
            
        }

        /**
         * All Options Fields
         *
         * @return
         */
        public function foodbakery_fields($foodbakery_frame_settings = '') {

            global $foodbakery_var_frame_options, $foodbakery_var_form_fields, $foodbakery_var_html_fields;
            $counter = 0;
            $output = '';

            if ( is_array($foodbakery_frame_settings) && sizeof($foodbakery_frame_settings) > 0 ) {
                foreach ( $foodbakery_frame_settings as $value ) {
                    $counter ++;
                    $val = '';
                    
                    echo  $value['type'];
                    
                    
                    $select_value = '';
                    switch ( $value['type'] ) {

                        case "section":
                            $output .= '
                            <div class="alert alert-info fade in nomargin theme_box">
                                <h4>' . esc_attr($value['std']) . '</h4>
                                <div class="clear"></div>
                            </div>';
                            break;

                        case "checkbox":

                            if ( isset($foodbakery_var_frame_options['foodbakery_var_' . $value['id']]) ) {
                                $checked_value = $foodbakery_var_frame_options['foodbakery_var_' . $value['id']];
                            } else {
                                $checked_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $foodbakery_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'id' => isset($value['id']) ? 'foodbakery_var_' . $value['id'] . '_checkbox' : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'field_params' => array(
                                    'std' => $checked_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => '',
                                    'return' => true,
                                ),
                            );
                            $output .= $foodbakery_var_html_fields->foodbakery_var_checkbox_field($foodbakery_opt_array);

                            break;

                        case 'select':
                            if ( isset($foodbakery_var_frame_options['foodbakery_var_' . $value['id']]) ) {
                                $select_value = $foodbakery_var_frame_options['foodbakery_var_' . $value['id']];
                            } else {
                                $select_value = isset($value['std']) ? $value['std'] : '';
                            }

                            $foodbakery_opt_array = array(
                                'name' => isset($value['name']) ? $value['name'] : '',
                                'desc' => isset($value['desc']) ? $value['desc'] : '',
                                'hint_text' => isset($value['hint_text']) ? $value['hint_text'] : '',
                                'field_params' => array(
                                    'std' => $select_value,
                                    'id' => isset($value['id']) ? $value['id'] : '',
                                    'classes' => isset($value['classes']) ? $value['classes'] : '',
                                    'extra_atr' => isset($value['extra_att']) ? $value['extra_att'] : '',
                                    'return' => true,
                                    'options' => isset($value['options']) ? $value['options'] : '',
                                ),
                            );
                            $output .= $foodbakery_var_html_fields->foodbakery_var_select_field($foodbakery_opt_array);

                            break;
                    }
                }
            }

            return $output;
        }

    }

}