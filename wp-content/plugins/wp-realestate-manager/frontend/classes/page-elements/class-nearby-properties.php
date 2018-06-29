<?php
/**
 * File Type: Nearby Properties Page Element
 */
if ( ! class_exists('wp_rem_nearby_properties_element') ) {

    class wp_rem_nearby_properties_element {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_nearby_properties_element_html', array( $this, 'wp_rem_nearby_properties_element_html_callback' ), 11, 1);
        }

        public function wp_rem_nearby_properties_element_html_callback($property_id = '') {

            global $post, $wp_rem_plugin_options, $wp_rem_post_property_types;
            wp_enqueue_script('wp-rem-prettyPhoto');
            wp_enqueue_style('wp-rem-prettyPhoto');
            $wp_rem_cs_inline_script = '
                jQuery(document).ready(function () {
                     jQuery("a.property-video-btn[rel^=\'prettyPhoto\']").prettyPhoto({animation_speed:"fast",slideshow:10000, hideflash: true,autoplay:true,autoplay_slideshow:false});
                });';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
            $default_property_no_custom_fields = isset($wp_rem_plugin_options['wp_rem_property_no_custom_fields']) ? $wp_rem_plugin_options['wp_rem_property_no_custom_fields'] : '';
            if ( $property_id != '' ) {
                $wp_rem_default_radius_circle = isset($wp_rem_plugin_options['wp_rem_default_radius_circle']) ? $wp_rem_plugin_options['wp_rem_default_radius_circle'] : '';
                $property_address = get_post_meta($property_id, 'wp_rem_post_loc_address_property', true);
                if ( $property_address != '' && $wp_rem_default_radius_circle > 0 ) {
                    $Shortcode_Properties_Frontend = new Wp_rem_Shortcode_Properties_Frontend();
                    $location_rslt = $Shortcode_Properties_Frontend->property_geolocation_filter($property_address, '', $wp_rem_default_radius_circle);
                    $wp_rem_base_query_args = '';
                    if ( function_exists('wp_rem_base_query_args') ) {
                        $wp_rem_base_query_args = wp_rem_base_query_args();
                    }
                    $location_rslt = array_diff( $location_rslt, array( $property_id ) );
                    if( empty( $location_rslt ) ) return;
                    $args = array(
                        'post_type' => 'properties',
                        'posts_per_page' => 10,
                        'post__not_in' => array( $property_id ),
                        'post__in' => $location_rslt,
                        'meta_query' => array(
                            'relation' => 'AND',
                            $wp_rem_base_query_args,
                        ),
                    );
                    $rel_qry = new WP_Query($args);
                        if ( $rel_qry->have_posts() ) {
                            $flag = 1;
                            ?>
                            <div class="page-section" style="background-color:#f7f7f7;padding:65px 0 40px;">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="property-grid-slider real-estate-property">
                                        <div class="element-title">
                                            <h3><?php echo wp_rem_plugin_text_srt('wp_rem_nearby_properties_heading'); ?></h3>
                                        </div>
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper">
                                                <?php
                                                $list_count = 1;
                                                while ( $rel_qry->have_posts() ) : $rel_qry->the_post();
                                                    global $post, $wp_rem_member_profile;
                                                    $property_id = $post->ID;
                                                    $post_id = $post->ID;
                                                    $Wp_rem_Locations = new Wp_rem_Locations();
                                                    $property_location = $Wp_rem_Locations->get_location_by_property_id($property_id);
                                                    $wp_rem_property_username = get_post_meta($property_id, 'wp_rem_property_username', true);
                                                    $wp_rem_property_is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);
                                                    $wp_rem_profile_image = $wp_rem_member_profile->member_get_profile_image($wp_rem_property_username);
                                                    $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                                                    $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                                                    // checking review in on in property type
                                                    $wp_rem_property_type = isset($wp_rem_property_type) ? $wp_rem_property_type : '';
                                                    if ( $property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type') )
                                                        $property_type_id = $property_type_post->ID;
                                                    $property_type_id = isset($property_type_id) ? $property_type_id : '';
                                                    $wp_rem_user_reviews = get_post_meta($property_type_id, 'wp_rem_user_reviews', true);
                                                    $wp_rem_property_type_price_switch = get_post_meta($property_type_id, 'wp_rem_property_type_price', true);
                                                    // end checking review on in property type
                                                    $wp_rem_property_price = '';
                                                    if ( $wp_rem_property_price_options == 'price' ) {
                                                        $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
                                                    } else if ( $wp_rem_property_price_options == 'on-call' ) {
                                                        $wp_rem_property_price = wp_rem_plugin_text_srt('wp_rem_nearby_properties_price_on_request');
                                                    }
                                                    // get all categories
                                                    $wp_rem_cate = '';
                                                    $wp_rem_cate_str = '';
                                                    $wp_rem_property_category = get_post_meta($property_id, 'wp_rem_property_category', true);
                                                    if ( ! empty($wp_rem_property_category) && is_array($wp_rem_property_category) ) {
                                                        $comma_flag = 0;
                                                        foreach ( $wp_rem_property_category as $cate_slug => $cat_val ) {
                                                            $wp_rem_cate = get_term_by('slug', $cat_val, 'property-category');
                                                            if ( ! empty($wp_rem_cate) ) {
                                                                $cate_link = wp_rem_property_category_link($property_type_id, $cat_val);
                                                                if ( $comma_flag != 0 ) {
                                                                    $wp_rem_cate_str .= ', ';
                                                                }
                                                                $wp_rem_cate_str = '<a href="' . $cate_link . '">' . $wp_rem_cate->name . '</a>';
                                                                $comma_flag ++;
                                                            }
                                                        }
                                                    }
                                                    $nearby_property_id = $post->ID;
                                                    $wp_rem_property_nearby_price_options = get_post_meta($nearby_property_id, 'wp_rem_property_price_options', true);
                                                    $wp_rem_property_nearby_price = '';
                                                    $wp_rem_property_price = '';
                                                    if ( $wp_rem_property_nearby_price_options == 'price' ) {
                                                        $wp_rem_property_nearby_price = get_post_meta($nearby_property_id, 'wp_rem_property_price', true);
                                                    } else if ( $wp_rem_property_nearby_price_options == 'on-call' ) {
                                                        $wp_rem_property_nearby_price = wp_rem_plugin_text_srt('wp_rem_nearby_properties_price_on_request');
                                                    }
                                                    $wp_rem_property_gallery_ids = get_post_meta($nearby_property_id, 'wp_rem_detail_page_gallery_ids', true);
                                                    $gallery_image_count = count($wp_rem_property_gallery_ids);
                                                    $wp_rem_property_type = get_post_meta($nearby_property_id, 'wp_rem_property_type', true);
                                                    $wp_rem_property_type = isset($wp_rem_property_type) ? $wp_rem_property_type : '';
                                                    if ( $property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type') )
                                                        $property_type_nearby_id = $property_type_post->ID;
                                                    $wp_rem_property_type_price_nearby_switch = get_post_meta(@$property_type_nearby_id, 'wp_rem_property_type_price', true);
                                                    ?>
                                                    <div class="swiper-slide">
                                                        <div class="property-grid">
                                                            <div class="img-holder">
                                                                <figure>
                                                                    <a href="<?php the_permalink(); ?>">
                                                                        <?php
                                                                        if ( function_exists('property_gallery_first_image') ) {
                                                                            $gallery_image_args = array(
                                                                                'property_id' => $property_id,
                                                                                'size' => 'wp_rem_cs_media_5',
                                                                                'class' => 'img-grid',
                                                                                'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image9x6.jpg')
                                                                            );
                                                                            echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
                                                                        }
                                                                        ?></a>
                                                                    <figcaption>
                                                                        <div class="caption-inner">
                                                                            <?php if ( $wp_rem_cate_str != '' ) { ?>
                                                                                <span class="rent-label"><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></span>
                                                                            <?php } ?>

                                                                            <?php if ( isset($gallery_image_count) && $gallery_image_count > 0 ) { ?>
                                                                                <ul id="galley-img<?php echo absint($nearby_property_id) ?>" class="galley-img">
                                                                                    <li><a  href="javascript:void(0)" class="rem-pretty-photos" data-id="<?php echo absint($nearby_property_id) ?>" ><span class="capture-count"><i class="icon-camera6"></i><?php echo absint($gallery_image_count); ?></span><div class="info-content"><span><?php echo wp_rem_plugin_text_srt('wp_rem_element_tooltip_icon_camera'); ?></span></div></a> </li>   
                                                                                </ul>
                                                                                <?php
                                                                            }

                                                                            $property_video_url = get_post_meta($nearby_property_id, 'wp_rem_property_video', true);
                                                                            $property_video_url = isset($property_video_url) ? $property_video_url : '';
                                                                            if ( $property_video_url != '' ) {
                                                                                $property_video_url = str_replace("player.vimeo.com/video", "vimeo.com", $property_video_url)
                                                                                ?>
                                                                                <a class="property-video-btn" rel="prettyPhoto" href="<?php echo esc_url($property_video_url); ?>"><i class="icon-film2"></i><div class="info-content"><span><?php echo wp_rem_plugin_text_srt('wp_rem_subnav_item_3'); ?></span></div></a>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </figcaption>
                                                                </figure>
                                                            </div>
                                                            <div class="text-holder">
                                                                <?php if ( $wp_rem_property_type_price_nearby_switch == 'on' && $wp_rem_property_nearby_price_options != 'none' ) { ?>
                                                                    <span class="property-price">
                                                                        <?Php
                                                                        if ( $wp_rem_property_nearby_price_options == 'on-call' ) {
                                                                            echo '<span class="property-price">' . force_balance_tags($wp_rem_property_nearby_price) . '</span>';
                                                                        } else {
                                                                            $property_info_price = wp_rem_property_price($nearby_property_id, $wp_rem_property_nearby_price, '<span class="guid-price">', '</span>');
                                                                            echo '<span class="property-price">' . force_balance_tags($property_info_price) . '</span>';
                                                                        }
                                                                        ?>
                                                                    </span>
                                                                <?php } ?>

                                                                <?php
                                                                $favourite_label = '';
                                                                $favourite_label = '';
                                                                $figcaption_div = true;
                                                                $book_mark_args = array(
                                                                    'before_label' => $favourite_label,
                                                                    'after_label' => $favourite_label,
                                                                    'before_icon' => '<i class="icon-heart-o"></i>',
                                                                    'after_icon' => '<i class="icon-heart5"></i>',
                                                                );
                                                                do_action('wp_rem_favourites_frontend_button', $nearby_property_id, $book_mark_args, $figcaption_div);
                                                                ?>

                                                                <?php if ( get_the_title($nearby_property_id) != '' ) { ?>
                                                                    <div class="post-title">
                                                                        <h4><a href="<?php echo esc_url(get_permalink($property_id)); ?>"><?php echo esc_html(get_the_title($property_id)); ?></a></h4>
                                                                    </div>
                                                                <?php } ?>
                                                                <?php
                                                                // property custom fields.
                                                                $cus_fields = array( 'content' => '' );
                                                                $cus_fields = apply_filters('wp_rem_custom_fields', $nearby_property_id, $cus_fields, $default_property_no_custom_fields);
                                                                if ( isset($cus_fields['content']) && $cus_fields['content'] != '' ) {
                                                                    ?>
                                                                    <ul class="post-category-list">
                                                                        <?php echo wp_rem_allow_special_char($cus_fields['content']); ?>
                                                                    </ul>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $list_count ++;
                                                endwhile;
                                                wp_reset_postdata();
                                                ?>
                                            </div>
                                        </div>
                                        <?php if ( $list_count > 5 ) { ?>
                                            <div class="swiper-button-prev"> <i class="icon-chevron-thin-left"></i></div>
                                            <div class="swiper-button-next"><i class="icon-chevron-thin-right"></i></div>
                                            <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                jQuery(document).ready(function ($) {
                                    if (jQuery(".property-grid-slider.real-estate-property .swiper-container").length != "") {
                                        "use strict";
                                        var swiper = new Swiper(".property-grid-slider.real-estate-property .swiper-container", {
                                            slidesPerView: 4,
                                            slidesPerColumn: 1,
                                            loop: false,
                                            paginationClickable: true,
                                            grabCursor: false,
                                            autoplay: false,
                                            spaceBetween: 30,
                                            nextButton: ".property-grid-slider.real-estate-property .swiper-button-next",
                                            prevButton: ".property-grid-slider.real-estate-property .swiper-button-prev",
                                            breakpoints: {
                                                1024: {
                                                    slidesPerView: 3,
                                                    spaceBetween: 40
                                                },
                                                991: {
                                                    slidesPerView: 2,
                                                    spaceBetween: 30
                                                },
                                                600: {
                                                    slidesPerView: 1,
                                                    spaceBetween: 15
                                                }
                                            }
                                        });
                                    }
                                });
                            </script>
                            <?php
                    }
                }
            }
        }

    }

    global $wp_rem_nearby_properties;
    $wp_rem_nearby_properties = new wp_rem_nearby_properties_element();
}