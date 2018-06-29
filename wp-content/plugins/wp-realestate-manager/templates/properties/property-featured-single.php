<?php
/**
 * Property search box
 *
 */
?>
<!--Element Section Start-->
<!--Wp-rem Element Start-->
<?php
global $wp_rem_post_property_types, $wp_rem_plugin_options;

$wp_rem_property_title_limit = isset($atts['properties_title_limit']) ? $atts['properties_title_limit'] : '20';
$properties_content_limit = isset($atts['properties_content_limit']) ? $atts['properties_content_limit'] : '100';

$default_property_no_custom_fields = isset($wp_rem_plugin_options['wp_rem_property_no_custom_fields']) ? $wp_rem_plugin_options['wp_rem_property_no_custom_fields'] : '';
$property_no_custom_fields = isset($atts['property_no_custom_fields']) ? $atts['property_no_custom_fields'] : $default_property_no_custom_fields;
if ( $property_no_custom_fields == '' || ! is_numeric($property_no_custom_fields) ) {
    $property_no_custom_fields = 3;
}

if ( $property_loop_obj->have_posts() ) {
    ?>
    <div class="featured-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                while ( $property_loop_obj->have_posts() ) : $property_loop_obj->the_post();
                    $property_id = $post;
                    ?>
                    <div class="swiper-slide">
                        <?php
                        $default_image = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image9x6.jpg');
                        if ( function_exists('property_gallery_first_image') ) {
                            $gallery_image_args = array(
                                'property_id' => $property_id,
                                'size' => 'wp_rem_media_10',
                                'class' => 'img-grid',
                                'default_image_src' => $default_image
                            );
                            $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
                        }
                        $col_class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12';
                        if ( $property_gallery_first_image == $default_image ) {
                            $property_gallery_first_image = '';
                            $col_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
                        }
                        ?>
                        <?php if ( $property_gallery_first_image != '' ) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="img-frame classic has-border has-shadow">
                                    <figure>
                                        <?php echo wp_rem_allow_special_char($property_gallery_first_image); ?>
                                    </figure>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="<?php echo esc_html($col_class); ?>">
                            <div class="column-text classic">
                                <h2><a href="<?php echo esc_url(get_permalink($property_id)); ?>"><?php echo esc_html(wp_trim_words(get_the_title($property_id), $wp_rem_property_title_limit)) ?></a></h2>
                                <p class="description"><?php echo wp_trim_words(get_the_content($property_id), $properties_content_limit, ' ...'); ?></p>
                                <?php
                                // All custom fields with value
                                $cus_fields = array( 'content' => '' );
                                $cus_fields = apply_filters('wp_rem_featured_custom_fields', $property_id, $cus_fields, $property_no_custom_fields);
                                if ( isset($cus_fields['content']) && $cus_fields['content'] != '' ) {
                                    ?>
                                    <ul class="categories-holder classic">
                                        <?php echo wp_rem_allow_special_char($cus_fields['content']); ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <?php
} else {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-property-match-error"><h6><i class="icon-warning"></i><strong> ' . wp_rem_plugin_text_srt('wp_rem_property_slider_sorry') . '</strong>&nbsp; ' . wp_rem_plugin_text_srt('wp_rem_property_slider_doesn_match') . ' </h6></div>';
}
?>