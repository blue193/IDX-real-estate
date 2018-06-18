<?php

/**
 * File Type: About Shortcode Frontend
 */
if (!class_exists('Wp_rem_Shortcode_About_Frontend')) {

    class Wp_rem_Shortcode_About_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_about';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array($this, 'wp_rem_about_shortcode_callback'));
        }

        /*
         * Shortcode View on Frontend
         */

        public function wp_rem_about_shortcode_callback($atts, $content = "") {

            echo wp_rem_allow_special_char($atts['title']);
        }

    }

    global $wp_rem_shortcode_about_frontend;
    $wp_rem_shortcode_about_frontend = new Wp_rem_Shortcode_About_Frontend();
}
