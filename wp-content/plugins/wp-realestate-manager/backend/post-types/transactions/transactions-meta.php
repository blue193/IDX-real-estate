<?php

/**
 * Start Function  how to Create Transations Fields
 */
if ( ! function_exists('wp_rem_create_transactions_fields') ) {

    function wp_rem_create_transactions_fields($key, $param) {
        global $post, $wp_rem_html_fields, $wp_rem_form_fields, $wp_rem_plugin_options;
        $wp_rem_gateway_options = get_option('wp_rem_plugin_options');
        $wp_rem_currency_sign = wp_rem_get_currency_sign();
        $wp_rem_value = $param['title'];
        $html = '';
        switch ( $param['type'] ) {
            case 'text' :
                // prepare
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);

                if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
                    if ( $key == 'transaction_expiry_date' ) {
                        $wp_rem_value = date_i18n('d-m-Y', $wp_rem_value);
                    } else {
                        $wp_rem_value = $wp_rem_value;
                    }
                } else {
                    $wp_rem_value = '';
                }

                $wp_rem_opt_array = array(
                    'name' => $param['title'],
                    'desc' => '',
                    'hint_text' => '',
                    'field_params' => array(
                        'std' => $wp_rem_value,
                        'id' => $key,
                        'classes' => 'wp-rem-form-text wp-rem-input',
                        'force_std' => true,
                        'return' => true,
                    ),
                );
                $output = '';
                $output .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                $output .= '<span class="wp-rem-form-desc">' . $param['description'] . '</span>' . "\n";


                $html .= $output;
                break;
            case 'checkbox' :
                // prepare
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);

                $wp_rem_opt_array = array(
                    'name' => $param['title'],
                    'desc' => '',
                    'hint_text' => '',
                    'field_params' => array(
                        'std' => $wp_rem_value,
                        'id' => $key,
                        'classes' => 'wp-rem-form-text wp-rem-input',
                        'force_std' => true,
                        'return' => true,
                    ),
                );
                $output = '';
                $output .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

                $html .= $output;
                break;
            case 'textarea' :
                // prepare
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);
                if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
                    $wp_rem_value = $wp_rem_value;
                } else {
                    $wp_rem_value = '';
                }

                $wp_rem_opt_array = array(
                    'name' => $param['title'],
                    'desc' => '',
                    'hint_text' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => $key,
                        'return' => true,
                    ),
                );

                $output = $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
                $html .= $output;
                break;
            case 'select' :
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);
                if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
                    $wp_rem_value = $wp_rem_value;
                } else {
                    $wp_rem_value = '';
                }
                $wp_rem_classes = '';
                if ( isset($param['classes']) && $param['classes'] != "" ) {
                    $wp_rem_classes = $param['classes'];
                }
                $wp_rem_opt_array = array(
                    'name' => $param['title'],
                    'desc' => '',
                    'hint_text' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => $key,
                        'classes' => $wp_rem_classes,
                        'options' => $param['options'],
                        'return' => true,
                    ),
                );

                $output = $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                // append
                $html .= $output;
                break;
            case 'hidden_label' :
                // prepare
                $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);

                if ( isset($wp_rem_value) && $wp_rem_value != '' ) {
                    $wp_rem_value = $wp_rem_value;
                } else {
                    $wp_rem_value = '';
                }

                $wp_rem_opt_array = array(
                    'name' => $param['title'],
                    'hint_text' => '',
                );
                $output = $wp_rem_html_fields->wp_rem_opening_field($wp_rem_opt_array);

                $output .= '<span>#' . $wp_rem_value . '</span>';

                $output .= $wp_rem_form_fields->wp_rem_form_hidden_render(
                        array(
                            'name' => '',
                            'id' => $key,
                            'return' => true,
                            'classes' => '',
                            'std' => $wp_rem_value,
                            'description' => '',
                            'hint' => ''
                        )
                );

                $wp_rem_opt_array = array(
                    'desc' => '',
                );
                $output .= $wp_rem_html_fields->wp_rem_closing_field($wp_rem_opt_array);
                $html .= $output;
                break;

            case 'summary' :
                // prepare
                $trans_first_name = get_post_meta($post->ID, 'wp_rem_trans_first_name', true);
                $trans_last_name = get_post_meta($post->ID, 'wp_rem_trans_last_name', true);
                $trans_email = get_post_meta($post->ID, 'wp_rem_trans_email', true);
                $trans_phone_number = get_post_meta($post->ID, 'wp_rem_trans_phone_number', true);
                $trans_address = get_post_meta($post->ID, 'wp_rem_trans_address', true);

                $output = '';

                if ( $trans_first_name != '' || $trans_last_name != '' || $trans_email != '' || $trans_phone_number != '' || $trans_address != '' ) {

                    $wp_rem_opt_array = array(
                        'name' => $param['title'],
                        'hint_text' => '',
                    );
                    $output .= $wp_rem_html_fields->wp_rem_opening_field($wp_rem_opt_array);

                    $output .= '<ul class="trans-user-summary">';

                    if ( $trans_first_name != '' ) {
                        $output .= '<li>';
                        $output .= '<label>' . wp_rem_plugin_text_srt('wp_rem_trans_meta_first_name') . '</label><span>' . $trans_first_name . '</span>';
                        $output .= '</li>';
                    }
                    if ( $trans_last_name != '' ) {
                        $output .= '<li>';
                        $output .= '<label>' . wp_rem_plugin_text_srt('wp_rem_trans_meta_last_name') . '</label><span>' . $trans_last_name . '</span>';
                        $output .= '</li>';
                    }
                    if ( $trans_email != '' ) {
                        $output .= '<li>';
                        $output .= '<label>' . wp_rem_plugin_text_srt('wp_rem_trans_meta_email') . '</label><span>' . $trans_email . '</span>';
                        $output .= '</li>';
                    }
                    if ( $trans_phone_number != '' ) {
                        $output .= '<li>';
                        $output .= '<label>' . wp_rem_plugin_text_srt('wp_rem_trans_meta_phone_num') . '</label><span><a href="tel:' . $trans_phone_number . '">' . $trans_phone_number . '</a></span>';
                        $output .= '</li>';
                    }
                    if ( $trans_address != '' ) {
                        $output .= '<li>';
                        $output .= '<label>' . wp_rem_plugin_text_srt('wp_rem_trans_meta_address') . '</label><span>' . $trans_address . '</span>';
                        $output .= '</li>';
                    }

                    $output .= '<ul>';

                    $wp_rem_opt_array = array(
                        'desc' => '',
                    );
                    $output .= $wp_rem_html_fields->wp_rem_closing_field($wp_rem_opt_array);
                }

                $html .= $output;
                break;

            default :
                break;
        }
        return $html;
    }

}
/**
 * End Function  how to Create Transations Fields
 */