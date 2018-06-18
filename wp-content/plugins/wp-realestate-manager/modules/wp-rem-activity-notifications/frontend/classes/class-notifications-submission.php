<?php

/**
 * File Type: Notifications Submission from frontend
 */
if ( ! class_exists( 'Wp_rem_Activity_Notifications_Submission' ) ) {

    class Wp_rem_Activity_Notifications_Submission {

        /**
         * Start Contructer Function
         */
        public function __construct() {
            $notification_status = apply_filters( 'wp_rem_get_plugin_options', 'wp_rem_activity_notifications_switch' );
            if ( isset( $notification_status ) && $notification_status == 'on' ) {
                add_action( 'wp_rem_add_notification', array( &$this, 'wp_rem_add_notification_callback' ) );
            }
        }

        /**
         * Adding Notification Function
         * @Array contains element id, element type, sender and reciever ids.
         */
        public function wp_rem_add_notification_callback( $data_array ) {
            wp_enqueue_script('wp-rem-notifications-js');
            $reciever_id = $this->reciever_id_by_type( $data_array );
            $notification_icon = $this->notification_icon( $data_array );
            if( $data_array['type'] != 'order_messages' && $data_array['type'] != 'inquiry' ){
                $data_array['reciever_id'] = $reciever_id;
            }
            $data_array['notification_content'] = $data_array['message'];
            $data_array['notification_icon'] = $notification_icon;
            $this->wp_rem_insert_notification( $data_array );
        }

        /**
         * Notification Type Icon
         * @ Array contains icons for each notification type.
         */
        public function notification_icon( $data_array ) {

            $notification_type = $data_array['type'];
            $icons_array = array(
                'property' => '<img src="' . wp_rem::plugin_url() . 'assets/frontend/images/icon-favourite.png">',
                'review' => '<img src="' . wp_rem::plugin_url() . 'assets/frontend/images/icon-reviews.png">',
                'reservation' => '<img src="' . wp_rem::plugin_url() . 'assets/frontend/images/icon-cart.png">',
                'inquiry' => '<img src="' . wp_rem::plugin_url() . 'assets/frontend/images/icon-order.png">',
                'order_messages' => '<img src="' . wp_rem::plugin_url() . 'assets/frontend/images/icon-msgs.png">',
            );
            $notification_icon = '';
            if ( isset( $icons_array[$notification_type] ) ) {
                $notification_icon = $icons_array[$notification_type];
            }
            return $notification_icon;
        }

        /**
         * Notification adding post for notification with referance to the submitted data.
         */
        public function wp_rem_insert_notification( $data_array ) {
            $data_array['status'] = 'new';
            $post_title     = str_replace( '_', ' ', $data_array['type'] );
            $postArray = array(
                'post_title'    => ucwords($post_title) . ' Notification',
                'post_content'    => $data_array['notification_content'],
                'post_status' => 'publish',
                'post_type' => 'notifications',
            );
            $post_id = wp_insert_post( $postArray );

            foreach ( $data_array as $key => $value ) {
                update_post_meta( $post_id, $key, $value );
            }
        }

        /**
         * Notification Reciever Id based on element type
         */
        public function reciever_id_by_type( $data_array ) {
            switch ( $data_array['type'] ) {

                case "property":
                    return $this->reciever_id_from_property( $data_array['element_id'] );
                    break;
                
                case "review":
                    return $this->reciever_id_from_property( $data_array['element_id'] );
                    break;

                case "reservation":
                    return $this->reciever_id_from_property( $data_array['element_id'] );
                    break;
                
                default :
                    return '';
                    break;
            }
        }

        /**
         * Reciever ID from property
         * @property id as parameter
         */
        public function reciever_id_from_property( $property_id ) {
            $reciever_id = '';
            if ( isset( $property_id ) && $property_id != '' ) {
                $reciever_id = get_post_meta( $property_id, 'wp_rem_property_member', true );
            }
            return $reciever_id;
        }

    }

    // Initialize Object
    $wp_rem_activity_notifications_submission_object = new Wp_rem_Activity_Notifications_Submission();
}