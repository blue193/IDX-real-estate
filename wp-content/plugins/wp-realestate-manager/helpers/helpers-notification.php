<?php

/**
 * @Start notification helper class
 * @return
 */
if (!class_exists('WP_REM_Plugin_Notification_Helper')) {

    class WP_REM_Plugin_Notification_Helper {

        public $message;

        /**
         * Start construct Functions
         */
        public function __construct() {
            // Do Something here..
            $this->message = wp_rem_plugin_text_srt('wp_rem_helper_notify_no_record_found');
        }

        /**
         * End construct Functions
         */

        /**
         * Start Function for createing success Message
         */
        public function success($message = '') {
            global $post;
            if ($message == '') {
                $message = $this->message;
            }
            $output = '';
            $output .= '<div class="col-md-12 cs-succ_mess"><p>';
            $output .= $message;
            $output .= '</p></div>';

            echo force_balance_tags($output);
        }

        /**
         * End Function for createing success Message
         */

        /**
         * Start Function for createing Error Message
         */
        public function error($message = '') {
            global $post;
            if ($message == '') {
                $message = $this->message;
            }
            $output = '';
            $output .= '<div class="col-md-12 cs-error"><p>';
            $output .= $message;
            $output .= '</p></div>';
            echo force_balance_tags($output);
        }

        /**
         * End Function for createing Error Message
         */

        /**
         * Start Function for createing Warning Message
         */
        public function warning($message = '') {
            global $post;
            if ($message == '') {
                $message = $this->message;
            }
            $output = '';
            $output .= '<div class="col-md-12 cs-warning"><p>';
            $output .= $message;
            $output .= '</p></div>';
            echo force_balance_tags($output);
        }

        /**
         * End Function for createing Warning Message
         */

        /**
         * Start Function for Giving the Information to you the user
         */
        public function informations($message = '') {
            global $post;
            if ($message == '') {
                $message = $this->message;
            }
            $output = '';
            $output .= '<div class="col-md-12 cs-informations"><p>';
            $output .= $message;
            $output .= '</p></div>';
            echo force_balance_tags($output);
        }

        /**
         * End Function for Giving the Information to you the user
         */

        /**
         * Start Function for Giving the Information to you the user
         */
        public function info_msg($message = '', $classes = '', $before, $after) {
            global $post;
            if ($message == '') {
                $message = $this->message;
            }
            $output = '';
            $class_str = '';
            if ($classes != '') {
                $class_str .= ' class="' . $classes . '"';
            }
            $before_str = '';
            if ($before != '') {
                $before_str .= $before;
            }
            $after_str = '';
            if ($after != '') {
                $after_str .= $after;
            }
            $output .= $before_str;
            $output .= '<span' . $class_str . '>';
            $output .= $message;
            $output .= '</span>';
            $output .= $after_str;
            echo force_balance_tags($output);
        }

        /**
         * End Function for Giving the Information to you the user
         */
    }

    $wp_rem_plugin_notify = new WP_REM_Plugin_Notification_Helper();
    global $wp_rem_plugin_notify;
}