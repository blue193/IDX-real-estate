<?php
/**
 * File Type: Property Posted By
 */
if (!class_exists('wp_rem_images_gallery')) {

    class wp_rem_images_gallery {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_filter('wp_rem_images_gallery_admin_fields', array($this, 'wp_rem_images_gallery_admin_fields_callback'), 11, 2);
            add_action('save_post', array($this, 'wp_rem_images_gallery_on_submission'), 14);
        }
        
        public function wp_rem_images_gallery_admin_fields_callback( $post_id, $property_type_slug ){
            global $wp_rem_html_fields, $post;
            $post_id                = ( isset( $post_id ) && $post_id != '' )? $post_id : $post->ID;
            $property_type_post      = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
            $property_type_id        = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $wp_rem_full_data    = get_post_meta( $property_type_id, 'wp_rem_full_data', true );
            $html                   = '';
            if ( !isset( $wp_rem_full_data['wp_rem_image_gallery_element'] ) || $wp_rem_full_data['wp_rem_image_gallery_element'] != 'on' ){
                return $html = '';
            }
            
            
            $html   .= $wp_rem_html_fields->wp_rem_heading_render(
                    array(
                        'name' => wp_rem_plugin_text_srt( 'wp_rem_property_image_gallery' ),
                        'cust_name' => 'images_gallery',
                        'classes' => '',
                        'std' => '',
                        'echo' => false,
                        'description' => '',
                        'hint' => ''
                    )
            );
            
            $html   .= '<div id="post_detail_gallery">';
                $wp_rem_opt_array = array(
                    'name' => wp_rem_plugin_text_srt( 'wp_rem_property_gallery_image' ),
                    'id' => 'detail_page_gallery',
                    'post_id' => $post_id,
                    'classes' => '',
                    'echo' => false,
                    'std' => '',
                );

                $html   .= $wp_rem_html_fields->wp_rem_gallery_render( $wp_rem_opt_array );
            $html   .= '</div>';
            return $html;
        }
        
        public function wp_rem_images_gallery_on_submission( $post_id ){
            if ( get_post_type( $post_id ) == 'properties' ){
                if( wp_rem_get_input( 'wp_rem_detail_page_gallery_ids', NULL ) === NULL ){
                    delete_post_meta ( $post_id, 'wp_rem_detail_page_gallery_ids' );
                }
            }
        }
        
    }
    global $wp_rem_images_gallery;
    $wp_rem_images_gallery    = new wp_rem_images_gallery();
}