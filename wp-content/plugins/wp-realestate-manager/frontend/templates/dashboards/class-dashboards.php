<?php

/**
 * File Type: Dashboard Templates
 */
if ( ! class_exists( 'Wp_rem_Dashboard_Templates' ) ) {

    class Wp_rem_Dashboard_Templates {

        /**
         * Start construct Functions
         */
        public function __construct() {
            global $wp_rem_plugin_static_text;
            $this->templates = array();
            
            add_filter( 'theme_page_templates', array( $this, 'theme_page_templates_callback' ) );
            add_filter( 'template_include', array( $this, 'dashboard_page_templates' ) );
            add_filter( 'template_include', array( $this, 'packag_page_templates' ) );
            add_action('init', array( $this, 'wp_rem_templates_callback' ), 0);
            add_action( 'wp_ajax_wp_rem_save_suggestions_settings_dashboard', array( $this, 'wp_rem_save_suggestions_settings_dashboard_callback' ) );
              
        }
        
        public function wp_rem_templates_callback(){
            $this->templates = array(
                'member-dashboard.php' => wp_rem_plugin_text_srt( 'wp_rem_member_dashboard' ),
                'packages-template.php' => wp_rem_plugin_text_srt( 'wp_rem_member_package_detail' ),
            );
        }
        
        public function theme_page_templates_callback( $post_templates ) {
            $post_templates = array_merge($this->templates, $post_templates);   
            return $post_templates;
        }

        /**
         * end construct Functions
         */
        /**
         * Adds our template to the pages cache in order to trick WordPress
         * into thinking the template file exists where it doens't really exist.
         */

        /**
         * Start Function how to register template in dashboard
         */
        public function dashboard_register_templates( $atts ) {
            $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
            $templates = wp_cache_get( $cache_key, 'themes' );
            if ( empty( $templates ) ) {
                $templates = array();
            } // end if
            wp_cache_delete( $cache_key, 'themes' );

            $templates = array_merge( $templates, $this->templates );
            wp_cache_add( $cache_key, $templates, 'themes', 1800 );

            return $atts;
        }

        /**
         * End Function for to register template in dashboard
         */
        // end dashboard_register_templates

        /**
         * Start Function if the templae page is assigned to the page funciton
         */
        public function dashboard_page_templates( $template ) {
            global $post;
            if ( ! isset( $post ) )
                return $template;
            if ( ! isset( $this->templates[get_post_meta( $post->ID, '_wp_page_template', true )] ) ) {
                return $template;
            }
              
            if ( 'member-dashboard.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {
                $current_user = wp_get_current_user();
                $roles = $current_user->roles;
              
                if ( in_array( 'wp_rem_member', $roles ) ) {
                    $file = plugin_dir_path( __FILE__ ) . 'member/' . get_post_meta( $post->ID, '_wp_page_template', true );
                    if ( file_exists( $file ) ) {
                        return $file;
                    }
                } else {
                    wp_redirect( site_url() );
                }
            }
           
            return $template;
        }

        public function packag_page_templates( $template ) {
            global $post;
            if ( ! isset( $post ) )
                return $template;
            if ( ! isset( $this->templates[get_post_meta( $post->ID, '_wp_page_template', true )] ) ) {
                return $template;
            }
            if ( 'packages-template.php' === get_post_meta( $post->ID, '_wp_page_template', true ) ) {

                $file = plugin_dir_path( __FILE__ ) . '' . get_post_meta( $post->ID, '_wp_page_template', true );
                if ( file_exists( $file ) ) {
                    return $file;
                }
            }
            return $template;
        }

        /**
         * Save suggestions settings for user's dashaboard.
         */
        public function wp_rem_save_suggestions_settings_dashboard_callback() {
            $msg = wp_rem_plugin_text_srt( 'wp_rem_member_no_of_suggestions' );
            $type   = 'error';
            $success = false;
            $suggested_properties_categories = isset( $_POST['wp_rem_suggested_properties_categories'] ) ? $_POST['wp_rem_suggested_properties_categories'] : '';
            $suggested_properties_max_properties = isset( $_POST['suggested_properties_max_properties'] ) ? $_POST['suggested_properties_max_properties'] : '';
            
            if( empty( $suggested_properties_categories ) ){
                $response_array = array(
                    'type' => 'error',
                    'msg' => wp_rem_plugin_text_srt( 'wp_rem_member_atleast_category' ),
                );
                echo json_encode( $response_array );
                wp_die();
            }
            if( $suggested_properties_max_properties == '' ){
                $response_array = array(
                    'type' => 'error',
                    'msg' => $msg,
                );
                echo json_encode( $response_array );
                wp_die();
            }
            if ( $suggested_properties_categories != '' && $suggested_properties_max_properties != '' ) {
                $user = wp_get_current_user();

                if ( $user->ID > 0 ) {
                    update_user_meta( $user->ID, 'suggested_properties_categories', $suggested_properties_categories );
                    update_user_meta( $user->ID, 'suggested_properties_max_properties', $suggested_properties_max_properties );
                    $msg = wp_rem_plugin_text_srt( 'wp_rem_member_setting_saved' );
                    $type   = 'success';
                    $success = true;
                }
            }
            
            $response_array = array(
                'type' => $type,
                'msg' => $msg,
            );
            echo json_encode( $response_array );
            wp_die();
        }

    }

    // end class
    // Initialize Object
    $wp_rem_dashboard_templates = new Wp_rem_Dashboard_Templates();
}