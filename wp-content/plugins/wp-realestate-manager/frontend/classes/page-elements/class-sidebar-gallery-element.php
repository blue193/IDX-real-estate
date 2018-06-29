<?php
/**
 * File Type: Property Sidebar Gallery Page Element
 */
if ( ! class_exists('wp_rem_sidebar_gallery_element') ) {

    class wp_rem_sidebar_gallery_element {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_sidebar_gallery_html', array( $this, 'wp_rem_sidebar_gallery_html_callback' ), 11, 1);
        }

        public function wp_rem_sidebar_gallery_html_callback($property_id = '') {
            global $wp_rem_plugin_options;
            $sidebar_gallery = isset($wp_rem_plugin_options['wp_rem_property_detail_page_sidebar_gallery']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_sidebar_gallery'] : '';
            if ( $sidebar_gallery != 'on' ) {
                return;
            }

            global $post, $wp_rem_plugin_options;
            if ( $property_id == '' ) {
                $property_id = $post->ID;
            }
            if ( $property_id != '' ) {
                $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                $wp_rem_property_type = isset($wp_rem_property_type) ? $wp_rem_property_type : '';
                if ( $property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type') )
                    $property_type_id = $property_type_post->ID;
                $property_type_id = isset($property_type_id) ? $property_type_id : '';
                $gallery_pics_allowed = get_post_meta($property_id, 'wp_rem_transaction_property_pic_num', true);
                if ( $gallery_pics_allowed > 0 && is_numeric($gallery_pics_allowed) ) {
                    $gallery_ids_list = get_post_meta($property_id, 'wp_rem_detail_page_gallery_ids', true);
                    if ( is_array($gallery_ids_list) && sizeof($gallery_ids_list) > 0 ) {
                        $count_all = count($gallery_ids_list);
                        if ( $count_all > $gallery_pics_allowed ) {
                            $count_all = $gallery_pics_allowed;
                        }
                        ?>
                        <div class="flickr-gallery-slider photo-gallery gallery ">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    <?php
                                    $counter = 1;
                                    foreach ( $gallery_ids_list as $gallery_idd ) {
                                        $image = wp_get_attachment_image_src($gallery_idd, 'wp_rem_media_8');
                                        if ( isset($image[0]) ) {
                                            if ( $counter <= $gallery_pics_allowed ) {
                                                $first_class = ( $counter == 1) ? 'gallery-first-img' : '';
                                                ?>
                                                <div class="swiper-slide"><a class="pretty-photo-img <?php echo esc_attr($first_class); ?>" rel="prettyPhoto[gallery]" href="<?php echo esc_url(wp_get_attachment_url($gallery_idd)) ?>"><img src="<?php echo esc_url($image[0]); ?>" alt="<?php echo wp_rem_plugin_text_srt('wp_rem_slider_image'); ?>" /></a></div>
                                                <?php
                                            }
                                            $counter ++;
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <span><a href="javascript:;" class="pretty-photo-slider"><?php echo wp_rem_plugin_text_srt('wp_rem_slider_view_all_photos'); ?> (<?php echo intval($count_all); ?>)</a></span>
                        </div>
                        <?php
                        $wp_rem_cs_inline_script = '
                        jQuery(document).ready(function () {
                            jQuery(document).on("click", ".pretty-photo-slider", function() {
                                "use strict";
                                jQuery(".gallery-first-img").click();
                            });
                        });';
                        wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
                    }
                }
            }
        }

    }

    global $wp_rem_sidebar_gallery;
    $wp_rem_sidebar_gallery = new wp_rem_sidebar_gallery_element();
}