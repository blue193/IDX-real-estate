<?php

/**
 * File Type: Apartment for sale
 */
if ( ! class_exists('wp_rem_apartment') ) {

    class wp_rem_apartment {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_filter('wp_rem_apartment_admin_fields', array( $this, 'wp_rem_apartment_admin_fields_callback' ), 11, 2);
            add_action('wp_ajax_wp_rem_apartment_repeating_fields', array( $this, 'wp_rem_apartment_repeating_fields_callback' ), 11);
            add_action('save_post', array( $this, 'wp_rem_insert_apartment' ), 17);
        }

        public function wp_rem_apartment_admin_fields_callback($post_id, $property_type_slug) {
            global $wp_rem_html_fields, $post;

            $post_id = ( isset($post_id) && $post_id != '' ) ? $post_id : $post->ID;
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_full_data = get_post_meta($property_type_id, 'wp_rem_full_data', true);
            $html = '';

            $wp_rem_apartment_data = get_post_meta($post_id, 'wp_rem_apartment', true);

            if ( ! isset($wp_rem_full_data['wp_rem_apartment_options_element']) || $wp_rem_full_data['wp_rem_apartment_options_element'] != 'on' ) {
                // return $html = '';
            }

            $html .= $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt('wp_rem_appartment_for_sale'),
                        'cust_name' => 'apartment',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => '',
                        'echo' => false,
                    )
            );

            $html .= '<div id="form-elements">';

            $html .= '<div id="apartment_repeater_fields">';

            if ( isset($wp_rem_apartment_data) && is_array($wp_rem_apartment_data) ) {

                foreach ( $wp_rem_apartment_data as $service_data ) {
                    $html .= $this->wp_rem_apartment_repeating_fields_callback($service_data);
                }
            }

            $html .= '</div>';



            $html .= '<div class="form-elements input-element wp-rem-form-button"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><a href="javascript:void(0);" id="click-more" class="apartment_repeater_btn wp-rem-add-more cntrl-add-new-row" data-id="apartment_repeater">' . wp_rem_plugin_text_srt('wp_rem_add_appartment') . '</a></div></div>';

            $html .= '</div>';

            return $html;
        }

        public function wp_rem_apartment_repeating_fields_callback($data = array( '' )) {
            global $wp_rem_html_fields;
            if ( isset($data) && count($data) > 0 ) {
                extract($data);
            }

            $html = '';
            $rand = mt_rand(10, 200);

            $html .= '<div id="apartment_repeater" style="display:block;" class="wp-rem-repeater-form">';

            $html .= '<a href="javascript:void(0);" class="wp-rem-element-remove"><i class="icon-close2"></i></a>';

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_plot'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset($apartment_plot) ) ? $apartment_plot : '',
                    'id' => 'apartment_plot' . $rand,
                    'cust_name' => 'wp_rem_apartment[plot][]',
                    'classes' => 'repeating_field',
                    'return' => true,
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_beds'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset($apartment_beds) ) ? $apartment_beds : '',
                    'id' => 'apartment_beds' . $rand,
                    'cust_name' => 'wp_rem_apartment[beds][]',
                    'classes' => 'repeating_field',
                    'return' => true,
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_price_from'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset($apartment_price_from) ) ? $apartment_price_from : '',
                    'id' => 'apartment_price_from' . $rand,
                    'cust_name' => 'wp_rem_apartment[price_from][]',
                    'classes' => 'repeating_field',
                    'return' => true,
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_floor'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset($apartment_floor) ) ? $apartment_floor : '',
                    'id' => 'apartment_floor' . $rand,
                    'cust_name' => 'wp_rem_apartment[floor][]',
                    'classes' => 'repeating_field',
                    'return' => true,
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_building'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset($apartment_address) ) ? $apartment_address : '',
                    'id' => 'apartment_address' . $rand,
                    'cust_name' => 'wp_rem_apartment[address][]',
                    'classes' => 'repeating_field',
                    'return' => true,
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_property_availability'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset($apartment_availability) ) ? $apartment_availability : '',
                    'id' => 'apartment_availability' . $rand,
                    'cust_name' => 'wp_rem_apartment[availability][]',
                    'classes' => 'repeating_field',
                    'options' => array(
                        'available' => wp_rem_plugin_text_srt('wp_rem_property_available'),
                        'unavailable' => wp_rem_plugin_text_srt('wp_rem_property_not_available'),
                    ),
                    'return' => true,
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_appartment_link'),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset($apartment_link) ) ? $apartment_link : '',
                    'id' => 'apartment_link' . $rand,
                    'cust_name' => 'wp_rem_apartment[link][]',
                    'classes' => 'repeating_field',
                    'return' => true,
                ),
            );
            $html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

            $html .= '</div>';
            if ( NULL != wp_rem_get_input('ajax', NULL) && wp_rem_get_input('ajax') == 'true' ) {
                echo force_balance_tags($html);
            } else {
                return $html;
            }

            if ( NULL != wp_rem_get_input('die', NULL) && wp_rem_get_input('die') == 'true' ) {
                die();
            }
        }

        public function wp_rem_insert_apartment($post_id) {
            if ( get_post_type($post_id) == 'properties' ) {
                if ( ! isset($_POST['wp_rem_apartment']['title']) || count($_POST['wp_rem_apartment']['title']) < 1 ) {
                    delete_post_meta($post_id, 'wp_rem_apartment');
                }
            }
            if ( isset($_POST['wp_rem_apartment']['plot']) && count($_POST['wp_rem_apartment']['plot']) > 0 ) {
                //Plot	Beds	Price From	Floor	Building / address	Availability
                foreach ( $_POST['wp_rem_apartment']['plot'] as $key => $apartment ) {

                    if ( count($apartment) > 0 ) {
                        $apartment_array[] = array(
                            'apartment_plot' => $apartment,
                            'apartment_beds' => $_POST['wp_rem_apartment']['beds'][$key],
                            'apartment_price_from' => $_POST['wp_rem_apartment']['price_from'][$key],
                            'apartment_floor' => $_POST['wp_rem_apartment']['floor'][$key],
                            'apartment_address' => $_POST['wp_rem_apartment']['address'][$key],
                            'apartment_availability' => $_POST['wp_rem_apartment']['availability'][$key],
                            'apartment_link' => $_POST['wp_rem_apartment']['link'][$key],
                        );
                    }
                }
                update_post_meta($post_id, 'wp_rem_apartment', $apartment_array);
            }
        }

    }

    global $wp_rem_apartment;
    $wp_rem_apartment = new wp_rem_apartment();
}