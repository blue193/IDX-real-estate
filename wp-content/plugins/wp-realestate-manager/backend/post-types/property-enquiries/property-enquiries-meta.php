<?php

/**
 * File Type: Property Enquiries Post Type Metas
 */
if (!class_exists('property_enquiries_post_type_meta')) {

    class property_enquiries_post_type_meta {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            add_action('add_meta_boxes', array(&$this, 'property_enquiries_add_meta_boxes_callback'));
        }

        /**
         * Add meta boxes Callback Function
         */
        public function property_enquiries_add_meta_boxes_callback() {
            add_meta_box('wp_rem_meta_property_enquiries', esc_html(wp_rem_plugin_text_srt('wp_rem_property_enquiries_options')), array($this, 'wp_rem_meta_property_enquiries'), 'property_enquiries', 'normal', 'high');
        }

        public function wp_rem_meta_property_enquiries() {
            global $post, $wp_rem_plugin_options;
            $post_id = $post->ID;
            $wp_rem_users_list = array();

            $wp_rem_seller_members_list = array();
            $enquiry_meta = array();

            $enquiry_meta['order_id'] = array(
                'name' => 'order_id',
                'type' => 'hidden_label',
                'title' => wp_rem_plugin_text_srt('wp_rem_enquiry_id'),
                'description' => '',
            );

            $enquiry_meta['property_member'] = array(
                'name' => 'property_member',
                'type' => 'members_select',
                'classes' => 'chosen-select',
                'title' => wp_rem_plugin_text_srt('wp_rem_enquiry_property_member'),
                'options' => $wp_rem_seller_members_list,
                'description' => '',
            );

            $enquiry_meta['enquiry_member'] = array(
                'name' => 'enquiry_member',
                'type' => 'members_select',
                'classes' => 'chosen-select',
                'title' => wp_rem_plugin_text_srt('wp_rem_enquiry_enquiry_member'),
                'options' => $wp_rem_seller_members_list,
                'description' => '',
            );
            $orders_status = isset($wp_rem_plugin_options['orders_status']) ? $wp_rem_plugin_options['orders_status'] : '';
            if (is_array($orders_status) && sizeof($orders_status) > 0) {
                foreach ($orders_status as $key => $label) {
                    $drop_down_options[$label] = $label;
                }
            } else {
                $drop_down_options = array(
                    'Processing' => wp_rem_plugin_text_srt('wp_rem_enquiry_detail_procceing'),
                    'Completed' => wp_rem_plugin_text_srt('wp_rem_enquiry_detail_completed'),
                );
            }
            $enquiry_status = get_post_meta($post_id, 'wp_rem_enquiry_status', true);
            if ($enquiry_status == 'Closed') {
                $drop_down_options['Closed'] = wp_rem_plugin_text_srt('wp_rem_enquiry_detail_closed');
            }
            $enquiry_meta['enquiry_status'] = array(
                'name' => 'enquiry_status',
                'type' => 'select',
                'classes' => 'chosen-select',
                'title' => wp_rem_plugin_text_srt('wp_rem_enquiry_status'),
                'options' => $drop_down_options,
                'description' => '',
            );

            $html = '<div class="page-wrap">
						<div class="option-sec" style="margin-bottom:0;">
							<div class="opt-conts">
								<div class="wp-rem-review-wrap">';
            foreach ($enquiry_meta as $key => $params) {
                $html .= $this->wp_rem_create_property_enquiries_fields($key, $params);
            }
            $html .= '</div>
							</div>
						</div>
						<div class="clear"></div>
					</div>';
            echo force_balance_tags($html);
        }

        public function wp_rem_create_property_enquiries_fields($key, $param) {
            global $post, $wp_rem_html_fields, $wp_rem_form_fields, $wp_rem_plugin_options;
            $wp_rem_currency_sign = wp_rem_get_currency_sign();

            $wp_rem_value = $param['title'];
            $html = '';
            switch ($param['type']) {
                case 'text' :
                    // prepare
                    $wp_rem_value = get_post_meta($post->ID, $key, true);

                    if (isset($wp_rem_value) && $wp_rem_value != '') {
                        if ($key == 'wp_rem_order_date') {
                            $wp_rem_value = date_i18n('d-m-Y', $wp_rem_value);
                        } else {
                            $wp_rem_value = $wp_rem_value;
                        }
                    } else {
                        $wp_rem_value = isset($param['std']) ? $param['std'] : '';
                    }

                    $wp_rem_opt_array = array(
                        'name' => $param['title'],
                        'desc' => '',
                        'hint_text' => '',
                        'field_params' => array(
                            'std' => $wp_rem_value,
                            'cust_id' => $key,
                            'cust_name' => $key,
                            'classes' => 'wp-rem-form-text wp-rem-input',
                            'force_std' => true,
                            'return' => true,
                            'active' => $param['active'],
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
                    if (isset($wp_rem_value) && $wp_rem_value != '') {
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
                    
                case 'members_select' :
                    $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);
                    $wp_rem_members_list    = array();
                    if (isset($wp_rem_value) && $wp_rem_value != '') {
                        $wp_rem_value = $wp_rem_value;
                        $wp_rem_members_list = array( $wp_rem_value => get_the_title($wp_rem_value) );
                    } else {
                        $wp_rem_value = '';
                    }
                    $wp_rem_classes = '';
                    if (isset($param['classes']) && $param['classes'] != "") {
                        $wp_rem_classes = $param['classes'];
                    }
                    $output = $wp_rem_html_fields->wp_rem_opening_field(array(
					'id' => 'property_member',
					'name' => $param['title'],
					'label_desc' => '',
				)
			);
                    $output .= '<div class="property_members_holder ' . $key . '_holder" onclick="wp_rem_load_all_members(\'' . $key . '_holder\', \''. $wp_rem_value .'\');">';
                            $wp_rem_opt_array = array(
                                    'std' => $wp_rem_value,
                                    'force_std' => true,
                                    'id' => $key,
                                    'extra_atr' => 'onchange="wp_rem_show_company_users(this.value, \''.admin_url('admin-ajax.php').'\', \''.wp_rem::plugin_url().'\');"',
                                    'classes' => $wp_rem_classes,
                                    'options' => $wp_rem_members_list,
                                    'markup' => '<span class="members-loader"></span>',
                                    'return' => true,
                            );
                            $output .= $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
                    $output .= '</div>';
                    
                    $output .= $wp_rem_html_fields->wp_rem_closing_field(array('desc' => ''));
                    // append
                    $html .= $output;
                    break;
                case 'select' :
                    $wp_rem_value = get_post_meta($post->ID, 'wp_rem_' . $key, true);
                    if (isset($wp_rem_value) && $wp_rem_value != '') {
                        $wp_rem_value = $wp_rem_value;
                    } else {
                        $wp_rem_value = '';
                    }
                    $wp_rem_classes = '';
                    if (isset($param['classes']) && $param['classes'] != "") {
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

                    if (isset($wp_rem_value) && $wp_rem_value != '') {
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
                default :
                    break;
            }
            return $html;
        }

    }

    // Initialize Object
    $property_enquiries_meta_object = new property_enquiries_post_type_meta();
}