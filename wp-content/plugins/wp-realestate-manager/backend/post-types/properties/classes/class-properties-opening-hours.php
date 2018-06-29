<?php
/**
 * File Type: Opening Hours
 */
if (!class_exists('wp_rem_opening_hours')) {

    class wp_rem_opening_hours {
        
        /**
         * Start construct Functions
         */
        public function __construct() {
            
            add_filter('wp_rem_opening_hours_admin_fields', array($this, 'wp_rem_opening_hours_admin_fields_callback'), 11, 2);
            add_action('save_post', array($this, 'wp_rem_insert_opening_hours'), 15);
        }
        
        public function wp_rem_opening_hours_admin_fields_callback( $post_id, $property_type_slug ){
            global $wp_rem_html_fields, $post;
            $post_id                = ( isset( $post_id ) && $post_id != '' )? $post_id : $post->ID;
            $property_type_post      = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id        = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_full_data    = get_post_meta( $property_type_id, 'wp_rem_full_data', true );
            $lapse                  = 15;
            $wp_rem_opening_hours_gap        = get_post_meta( $property_type_id, 'wp_rem_opening_hours_time_gap', true );
            if ( isset( $wp_rem_opening_hours_gap ) && $wp_rem_opening_hours_gap != '' ){
                $lapse              = $wp_rem_opening_hours_gap;
            }
            
            $html                   = '';
            if ( !isset( $wp_rem_full_data['wp_rem_opening_hours_element'] ) || $wp_rem_full_data['wp_rem_opening_hours_element'] != 'on' ){
                return $html = '';
            }
            
            $opening_hours_data     = get_post_meta( $post_id, 'wp_rem_opening_hours', true );
            $date       = date("Y/m/d 12:00");
            $time       = strtotime('12:00 am');
            $start_time = strtotime( $date. ' am' );
            $endtime   = strtotime( date("Y/m/d h:i a", strtotime('1440 minutes', $start_time)) );
            
            while( $start_time < $endtime ){
                $time   = date("h:i a", strtotime('+' . $lapse . ' minutes', $time));
                $hours[$time]   = $time;
                $time   = strtotime( $time );
                $start_time   = strtotime( date("Y/m/d h:i a", strtotime('+' . $lapse . ' minutes', $start_time)));
            }
            
            $html .= $wp_rem_html_fields->wp_rem_heading_render(
                array(
                    'name' => wp_rem_plugin_text_srt( 'wp_rem_property_schedule_with_time' ),
                    'cust_name' => 'opening_hours',
                    'classes' => '',
                    'std' => '',
                    'description' => '',
                    'hint' => '',
                    'echo' => false,
                )
            );

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_monday' ),
                'id' => 'radius_fields',
                'desc' => '',
                'hint_text' => '',
                'echo' => false, 
                'fields_list' => array(
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['monday']['opening_time'] ) )? $opening_hours_data['monday']['opening_time']:'',
                            'cust_name' => 'opening_hours[monday][opening_time]',
                            'id' => 'opening_hours[monday][opening_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_opening_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['monday']['closing_time'] ) )? $opening_hours_data['monday']['closing_time']:'',
                            'cust_name' => 'opening_hours[monday][closing_time]',
                            'id' => 'opening_hours[monday][closing_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_closing_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),

                    array(
                        'type' => 'checkbox', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['monday']['day_status'] ) )? $opening_hours_data['monday']['day_status']:'on',
                            'cust_name' => 'opening_hours[monday][day_status]',
                            'id' => 'opening_hours[monday][day_status]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_monday_on' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                        ),
                    ),
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);

            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_tuesday' ),
                'id' => 'radius_fields',
                'desc' => '',
                'hint_text' => '',
                'echo' => false, 
                'fields_list' => array(
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['tuesday']['opening_time'] ) )? $opening_hours_data['tuesday']['opening_time']:'',
                            'cust_name' => 'opening_hours[tuesday][opening_time]',
                            'id' => 'opening_hours[tuesday][opening_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_opening_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['tuesday']['closing_time'] ) )? $opening_hours_data['tuesday']['closing_time']:'',
                            'cust_name' => 'opening_hours[tuesday][closing_time]',
                            'id' => 'opening_hours[tuesday][closing_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_closing_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),

                    array(
                        'type' => 'checkbox', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['tuesday']['day_status'] ) )? $opening_hours_data['tuesday']['day_status']:'on',
                            'cust_name' => 'opening_hours[tuesday][day_status]',
                            'id' => 'opening_hours[tuesday][day_status]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_tuesday_on' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                        ),
                    ),
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_wednesday' ),
                'id' => 'radius_fields',
                'desc' => '',
                'hint_text' => '',
                'echo' => false, 
                'fields_list' => array(
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['wednesday']['opening_time'] ) )? $opening_hours_data['wednesday']['opening_time']:'',
                            'cust_name' => 'opening_hours[wednesday][opening_time]',
                            'id' => 'opening_hours[wednesday][opening_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_opening_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['wednesday']['closing_time'] ) )? $opening_hours_data['wednesday']['closing_time']:'',
                            'cust_name' => 'opening_hours[wednesday][closing_time]',
                            'id' => 'opening_hours[wednesday][closing_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_closing_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),

                    array(
                        'type' => 'checkbox', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['wednesday']['day_status'] ) )? $opening_hours_data['wednesday']['day_status']:'on',
                            'cust_name' => 'opening_hours[wednesday][day_status]',
                            'id' => 'opening_hours[wednesday][day_status]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_wednesday_on' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                        ),
                    ),
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_thursday' ),
                'id' => 'radius_fields',
                'desc' => '',
                'hint_text' => '',
                'echo' => false, 
                'fields_list' => array(
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['thursday']['opening_time'] ) )? $opening_hours_data['thursday']['opening_time']:'',
                            'cust_name' => 'opening_hours[thursday][opening_time]',
                            'id' => 'opening_hours[thursday][opening_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_opening_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['thursday']['closing_time'] ) )? $opening_hours_data['thursday']['closing_time']:'',
                            'cust_name' => 'opening_hours[thursday][closing_time]',
                            'id' => 'opening_hours[thursday][closing_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_closing_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),

                    array(
                        'type' => 'checkbox', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['thursday']['day_status'] ) )? $opening_hours_data['thursday']['day_status']:'on',
                            'cust_name' => 'opening_hours[thursday][day_status]',
                            'id' => 'opening_hours[thursday][day_status]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_thursday_on' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                        ),
                    ),
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_friday' ),
                'id' => 'radius_fields',
                'desc' => '',
                'hint_text' => '',
                'echo' => false, 
                'fields_list' => array(
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['friday']['opening_time'] ) )? $opening_hours_data['friday']['opening_time']:'',
                            'cust_name' => 'opening_hours[friday][opening_time]',
                            'id' => 'opening_hours[friday][opening_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_opening_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['friday']['closing_time'] ) )? $opening_hours_data['friday']['closing_time']:'',
                            'cust_name' => 'opening_hours[friday][closing_time]',
                            'id' => 'opening_hours[friday][closing_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_closing_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),

                    array(
                        'type' => 'checkbox', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['friday']['day_status'] ) )? $opening_hours_data['friday']['day_status']:'on',
                            'cust_name' => 'opening_hours[friday][day_status]',
                            'id' => 'opening_hours[friday][day_status]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_friday_on' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                        ),
                    ),
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_saturday' ),
                'id' => 'radius_fields',
                'desc' => '',
                'hint_text' => '',
                'echo' => false, 
                'fields_list' => array(
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['saturday']['opening_time'] ) )? $opening_hours_data['saturday']['opening_time']:'',
                            'cust_name' => 'opening_hours[saturday][opening_time]',
                            'id' => 'opening_hours[saturday][opening_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_opening_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['saturday']['closing_time'] ) )? $opening_hours_data['saturday']['closing_time']:'',
                            'cust_name' => 'opening_hours[saturday][closing_time]',
                            'id' => 'opening_hours[saturday][closing_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_closing_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),

                    array(
                        'type' => 'checkbox', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['saturday']['day_status'] ) )? $opening_hours_data['saturday']['day_status']:'on',
                            'cust_name' => 'opening_hours[saturday][day_status]',
                            'id' => 'opening_hours[saturday][day_status]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_saturday_on' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                        ),
                    ),
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);


            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_property_sunday' ),
                'id' => 'radius_fields',
                'desc' => '',
                'hint_text' => '',
                'echo' => false, 
                'fields_list' => array(
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['sunday']['opening_time'] ) )? $opening_hours_data['sunday']['opening_time']:'',
                            'cust_name' => 'opening_hours[sunday][opening_time]',
                            'id' => 'opening_hours[sunday][opening_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_opening_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),
                    array(
                        'type' => 'select', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['sunday']['closing_time'] ) )? $opening_hours_data['sunday']['closing_time']:'',
                            'cust_name' => 'opening_hours[sunday][closing_time]',
                            'id' => 'opening_hours[sunday][closing_time]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_closing_time' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                            'options' => $hours,
                        ),
                    ),

                    array(
                        'type' => 'checkbox', 'field_params' => array(
                            'std' => ( isset( $opening_hours_data['sunday']['day_status'] ) )? $opening_hours_data['sunday']['day_status']:'on',
                            'cust_name' => 'opening_hours[sunday][day_status]',
                            'id' => 'opening_hours[sunday][day_status]',
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt( 'wp_rem_property_sunday_on' ) . '"',
                            'return' => true,
                            'classes' => 'input-small',
                        ),
                    ),
                ),
            );

            $html .= $wp_rem_html_fields->wp_rem_multi_fields($wp_rem_opt_array);
            
            return $html;
        }
        
        public function wp_rem_insert_opening_hours( $post_id ){
            if( isset( $_POST['opening_hours'] ) ){
                update_post_meta( $post_id, 'wp_rem_opening_hour', $_POST['opening_hours'] );
            }
        }
    }
    global $wp_rem_opening_hours;
    $wp_rem_opening_hours    = new wp_rem_opening_hours();
}