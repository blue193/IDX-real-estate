<?php
/**
 * File Type: Floor Plans
 */
if (!class_exists('wp_rem_floor_plans')) {

    class wp_rem_floor_plans {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_filter('wp_rem_floor_plans_admin_fields', array($this, 'wp_rem_floor_plans_admin_fields_callback'), 11, 2);
            add_action('wp_ajax_wp_rem_floor_plans_repeating_fields', array($this, 'wp_rem_floor_plans_repeating_fields_callback'), 11);
            add_action('save_post', array($this, 'wp_rem_insert_floor_plans'), 17);
        }
        
        public function wp_rem_floor_plans_admin_fields_callback( $post_id, $property_type_slug ){
            global $wp_rem_html_fields, $post;
            
            $post_id                = ( isset( $post_id ) && $post_id != '' )? $post_id : $post->ID;
            $property_type_post      = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id        = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_full_data    = get_post_meta( $property_type_id, 'wp_rem_full_data', true );
            $html                   = '';
            
            $wp_rem_floor_plans_data = get_post_meta( $post_id, 'wp_rem_floor_plans', true );
            
            if ( !isset( $wp_rem_full_data['wp_rem_floor_plans_options_element'] ) || $wp_rem_full_data['wp_rem_floor_plans_options_element'] != 'on' ){
                return $html = '';
            }
            
            $html   .= $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt( 'wp_rem_floor_plans' ),
                        'cust_name' => 'floor_plans',
                        'classes' => '',
                        'std' => '',
                        'description' => '',
                        'hint' => '',
                        'echo' => false,
                    )
            );
            
			$html   .= '<div id="form-elements">';
			
            $html   .= '<div id="floor_plans_repeater_fields">';
            
            if ( isset ( $wp_rem_floor_plans_data ) && is_array( $wp_rem_floor_plans_data ) ){
                
                foreach( $wp_rem_floor_plans_data as $service_data ){
                        $html       .= $this->wp_rem_floor_plans_repeating_fields_callback( $service_data );
                }
            }
            
            $html   .= '</div>';
            
            $html .= '<div class="form-elements input-element wp-rem-form-button"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><a href="javascript:void(0);" id="click-more" class="floor_plans_repeater_btn wp-rem-add-more cntrl-add-new-row" data-id="floor_plans_repeater">' . wp_rem_plugin_text_srt( 'wp_rem_floor_add_more' ) . '</a></div></div>';
            
            $html   .= '</div>';
            
            return $html;
        }
        
        public function wp_rem_floor_plans_repeating_fields_callback( $data = array('') ){
             global $wp_rem_html_fields;
             if ( isset ( $data ) && count( $data ) > 0 ){
                 extract( $data );
             }
			 
             $html   = '';
             $rand  = mt_rand(10,200);
             
             $html   .= '<div id="floor_plans_repeater" style="display:block;" class="wp-rem-repeater-form">';
             
             $html .= '<a href="javascript:void(0);" class="wp-rem-element-remove"><i class="icon-close2"></i></a>';
		
             $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_floor_title' ),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset( $floor_plan_title ) )? $floor_plan_title : '',
                    'id' => 'floor_plan_title'.$rand,
                    'cust_name' => 'wp_rem_floor_plans[title][]',
                    'classes' => 'repeating_field',
                    'return' => true,
                ),
            );
            
            $html   .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
			
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt( 'wp_rem_floor_image' ),
				'desc' => '',
				'hint_text' => '',
				'id' => 'floor_plan_image' . $rand,
				'force_std' => true,
				'std' => ( isset( $floor_plan_image ) ? $floor_plan_image : '' ),
				'field_params' => array(
					'id' => 'floor_plan_image' . $rand,
					'cust_name' => 'wp_rem_floor_plans[image][]',
					'return' => true,
					'force_std' => true,
					'std' => ( isset( $floor_plan_image ) ? $floor_plan_image : '' ),
					
				),
			);
			$html   .= $wp_rem_html_fields->wp_rem_upload_file_field($wp_rem_opt_array);

             $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt( 'wp_rem_floor_description' ),
                'desc' => '',
                'hint_text' => '',
                'echo' => false,
                'field_params' => array(
                    'usermeta' => true,
                    'std' => ( isset( $floor_plan_description ) )? $floor_plan_description : '',
                    'id' => 'floor_plan_description'.$rand,
                    'cust_name' => 'wp_rem_floor_plans[description][]',
                    'extra_atr' => 'class="repeating_field"',
					'classes' => 'wp-rem-dev-req-field wp_rem_editor',
					'wp_rem_editor' => true,
                    'return' => true,
                ),
            );

            $html   .= $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
            
            
            $html   .= '</div>';
            if ( NULL != wp_rem_get_input( 'ajax', NULL ) && wp_rem_get_input( 'ajax' ) == 'true' ){
               echo force_balance_tags($html);
            } else {
                return $html;
            }
            
            if ( NULL != wp_rem_get_input( 'die', NULL ) && wp_rem_get_input( 'die' ) == 'true' ){
                die();
            }
        }
        
        public function wp_rem_insert_floor_plans( $post_id ){
            if ( get_post_type( $post_id ) == 'properties' ){
                if ( !isset( $_POST['wp_rem_floor_plans']['title'] ) || count( $_POST['wp_rem_floor_plans']['title'] ) < 1 ){
                    delete_post_meta ( $post_id, 'wp_rem_floor_plans' );
                }
            }
            if ( isset( $_POST['wp_rem_floor_plans']['title'] ) && count( $_POST['wp_rem_floor_plans']['title'] ) > 0 ){
                
                foreach( $_POST['wp_rem_floor_plans']['title'] as $key => $floor_plan ){
                    
                    if ( count( $floor_plan ) > 0 ){
                        $floor_plans_array[] = array(
                            'floor_plan_title' => $floor_plan,
                            'floor_plan_description' => $_POST['wp_rem_floor_plans']['description'][$key],
                            'floor_plan_image' => $_POST['wp_rem_floor_plans']['image'][$key],
                        );
                    }
                }
                update_post_meta( $post_id, 'wp_rem_floor_plans', $floor_plans_array );
            }
        }
    }
    global $wp_rem_floor_plans;
    $wp_rem_floor_plans    = new wp_rem_floor_plans();
}