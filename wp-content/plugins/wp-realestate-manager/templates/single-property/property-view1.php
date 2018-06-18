<?php
/**
 * The template for displaying single property
 *
 */
global $post, $wp_rem_plugin_options, $wp_rem_theme_options, $wp_rem_post_property_types;
$post_id = $post->ID;
wp_rem_property_views_count($post_id);
$wp_rem_social_network = isset($wp_rem_plugin_options['wp_rem_property_detail_page_social_network']) ? $wp_rem_plugin_options['wp_rem_property_detail_page_social_network'] : '';
$property_limits = get_post_meta($post_id, 'wp_rem_trans_all_meta', true);
$wp_rem_property_price_options = get_post_meta($post_id, 'wp_rem_property_price_options', true);
$wp_rem_property_price = '';
if ($wp_rem_property_price_options == 'price') {
    $wp_rem_property_price = get_post_meta($post_id, 'wp_rem_property_price', true);
} else if ($wp_rem_property_price_options == 'on-call') {
    $wp_rem_property_price = wp_rem_plugin_text_srt('wp_rem_nearby_properties_price_on_request');
}
$wp_rem_var_post_social_sharing = $wp_rem_plugin_options['wp_rem_social_share'];
wp_enqueue_script('wp-rem-prettyPhoto');
wp_enqueue_script('wp-rem-reservation-functions');
wp_enqueue_style('wp-rem-prettyPhoto');
// checking review in on in property type
$wp_rem_property_type = get_post_meta($post_id, 'wp_rem_property_type', true);

/*
 * member data
 */
$wp_rem_property_member_id = get_post_meta($post_id, 'wp_rem_property_member', true);


$wp_rem_property_member_id = isset($wp_rem_property_member_id) ? $wp_rem_property_member_id : '';
$wp_rem_post_loc_address_member = get_post_meta($wp_rem_property_member_id, 'wp_rem_post_loc_address_member', true);
$wp_rem_member_title = '';
if (isset($wp_rem_property_member_id) && $wp_rem_property_member_id <> '') {
    $wp_rem_member_title = get_the_title($wp_rem_property_member_id);
}
$wp_rem_member_link = 'javascript:void(0)';
if (isset($wp_rem_property_member_id) && $wp_rem_property_member_id <> '') {
    $wp_rem_member_link = get_the_permalink($wp_rem_property_member_id);
}

$member_image_id = get_post_meta($wp_rem_property_member_id, 'wp_rem_profile_image', true);
$member_image = wp_get_attachment_url($member_image_id);
$wp_rem_member_phone_num = get_post_meta($wp_rem_property_member_id, 'wp_rem_phone_number', true);
$wp_rem_member_email_address = get_post_meta($wp_rem_property_member_id, 'wp_rem_email_address', true);
$wp_rem_member_email_address = isset($wp_rem_member_email_address) ? $wp_rem_member_email_address : '';
/*
 * member data end 
 */

$wp_rem_post_loc_address_property = get_post_meta($post_id, 'wp_rem_post_loc_address_property', true);
$wp_rem_post_loc_latitude = get_post_meta($post_id, 'wp_rem_post_loc_latitude_property', true);
$wp_rem_post_loc_longitude = get_post_meta($post_id, 'wp_rem_post_loc_longitude_property', true);
$wp_rem_property_type = isset($wp_rem_property_type) ? $wp_rem_property_type : '';
if ($property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type'))
    $property_type_id = $property_type_post->ID;
$property_type_id = isset($property_type_id) ? $property_type_id : '';
$wp_rem_property_type_feature_img_switch = get_post_meta($property_type_id, 'wp_rem_social_share_element', true);
$wp_rem_property_is_featured = get_post_meta($post_id, 'wp_rem_property_is_featured', true);
$wp_rem_property_type_price_switch = get_post_meta($property_type_id, 'wp_rem_property_type_price', true);
$wp_rem_property_type_cover_img_switch = get_post_meta($post_id, 'wp_rem_transaction_property_cimage', true);
$wp_rem_property_type_claim_list_switch = get_post_meta($property_type_id, 'wp_rem_claim_property_element', true);
$wp_rem_property_type_flag_list_switch = get_post_meta($property_type_id, 'wp_rem_report_spams_element', true);
$wp_rem_property_type_social_share_switch = get_post_meta($property_type_id, 'wp_rem_social_share_element', true);
$wp_rem_property_type_det_desc_switch = get_post_meta($property_type_id, 'wp_rem_property_detail_length_switch', true);
$wp_rem_property_type_det_desc_length = get_post_meta($property_type_id, 'wp_rem_property_desc_detail_length', true);
$wp_rem_property_type_walkscores_switch = get_post_meta($property_type_id, 'wp_rem_walkscores_options_element', true);
$wp_rem_env_res_all_lists = get_post_meta($post_id, 'wp_rem_env_res', true);
$wp_rem_env_res_title = get_post_meta($post_id, 'wp_rem_env_res_heading', true);
$wp_rem_env_res_description = get_post_meta($post_id, 'wp_rem_env_res_description', true);
$zoom_level = ( isset($wp_rem_plugin_options['wp_rem_map_zoom_level']) && $wp_rem_plugin_options['wp_rem_map_zoom_level'] != '' ) ? $wp_rem_plugin_options['wp_rem_map_zoom_level'] : 10;

/*
 * Banner slider data
 */
$gallery_ids_list = get_post_meta($post_id, 'wp_rem_detail_page_gallery_ids', true);
/*
 * Property Elements Settings
 */
$wp_rem_enable_features_element = get_post_meta($post_id, 'wp_rem_enable_features_element', true);
$wp_rem_enable_video_element = get_post_meta($post_id, 'wp_rem_enable_video_element', true);
$wp_rem_enable_yelp_places_element = get_post_meta($post_id, 'wp_rem_enable_yelp_places_element', true);
$wp_rem_enable_appartment_for_sale_element = get_post_meta($post_id, 'wp_rem_enable_appartment_for_sale_element', true);
$wp_rem_enable_file_attachments_element = get_post_meta($post_id, 'wp_rem_enable_file_attachments_element', true);
$wp_rem_enable_floot_plan_element = get_post_meta($post_id, 'wp_rem_enable_floot_plan_element', true);
/*
 * Banner slider data end 
 */

if ($wp_rem_property_type_det_desc_length < 0) {
    $wp_rem_property_type_det_desc_length = 50;
}

$no_image_class = '';
if (!has_post_thumbnail()) {
    $no_image_class = ' no-image';
}

//get custom fields
$cus_field_arr = array();
$property_type = '';
$property_type = get_post_meta($post_id, 'wp_rem_property_type', true);
$wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($property_type);

// get all categories
$wp_rem_cate = '';
$wp_rem_cate_str = '';
$wp_rem_property_category = get_post_meta($post_id, 'wp_rem_property_category', true);

if (!empty($wp_rem_property_category) && is_array($wp_rem_property_category)) {
    $comma_flag = 0;
    foreach ($wp_rem_property_category as $cate_slug => $cat_val) {
        $wp_rem_cate = get_term_by('slug', $cat_val, 'property-category');

        if (!empty($wp_rem_cate)) {
            $cate_link = wp_rem_property_category_link($property_type_id, $cat_val);
            if ($comma_flag != 0) {
                $wp_rem_cate_str .= ', ';
            }
            $wp_rem_cate_str = '<a href="' . $cate_link . '">' . $wp_rem_cate->name . '</a>';
            $comma_flag ++;
        }
    }
}
?>
<!-- Main Start -->
<div id="main" class="main-section">
    <div class="page-section" style="padding:20px 0;">
        <div class="property-detail">
            <div class="container">
                <div class="row">
                    <?php
                    $member_profile_status = get_post_meta($post_id, 'property_member_status', true);
                    if ($member_profile_status == 'active') {
                        ?>
                        <div class="page-content col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <div class="list-detail-options">
                                <div class="title-area">
                                    <div class="price-holder">
                                        <?php if ($wp_rem_property_type_price_switch == 'on' && $wp_rem_property_price_options != 'none') { ?>
                                            <span class="property-price">
                                                <?Php
                                                if ($wp_rem_property_price_options == 'on-call') {
                                                    echo '<span class="new-price text-color">' . force_balance_tags($wp_rem_property_price) . '</span>';
                                                } else {
                                                    $property_info_price = wp_rem_property_price($post_id, $wp_rem_property_price, '<span class="guid-price">', '</span>');
                                                    echo '<span class="new-price text-color">' . force_balance_tags($property_info_price) . '</span>';
                                                }
                                                ?>
                                            </span>
                                        <?php } ?>
                                    </div>
                                    <?php if (get_the_title($post_id) != '') { ?>
                                        <h2><?php the_title(); ?></h2>
                                    <?php } ?>
                                    <?php /* if (isset($wp_rem_post_loc_address_property) && $wp_rem_post_loc_address_property != '') { ?>
                                        <address><i class="icon- icon-location-pin2"></i><?php echo esc_html($wp_rem_post_loc_address_property); ?></address>
                                    <?php } */ ?>
                                    <div class="property-data">
                                        <ul>
                                            <?php if ($wp_rem_property_is_featured == 'on') { ?>
                                                <li class="featured-property">
                                                    <span class="bgcolor"><?php echo wp_rem_plugin_text_srt('wp_rem_property_featured'); ?></span>
                                                </li>
                                            <?php }
                                            ?>
                                            <li><i class="icon-home"></i><?php echo wp_rem_property_type_link($property_type_id); ?> <?php
                                                if ($wp_rem_cate_str != '') {
                                                    echo wp_rem_plugin_text_srt('wp_rem_property_type_in');
                                                }
                                                ?></li>
                                            <?php if ($wp_rem_cate_str != '') { ?>
                                                <li><strong><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></strong></li>
                                            <?php } ?>
                                            <li><?php
                                                $favourite_label = wp_rem_plugin_text_srt('wp_rem_property_favourite');
                                                $favourite_label = wp_rem_plugin_text_srt('wp_rem_property_favourite');
                                                $figcaption_div = true;
                                                $book_mark_args = array(
                                                    'before_label' => $favourite_label,
                                                    'after_label' => $favourite_label,
                                                    'before_icon' => '<i class="icon-heart-o"></i>',
                                                    'after_icon' => '<i class="icon-heart5"></i>',
                                                );
                                                do_action('wp_rem_favourites_frontend_button', $post_id, $book_mark_args, $figcaption_div);
                                                ?></li>
                                        </ul>
                                    </div>
                                    <?php if ($wp_rem_social_network === 'on') { ?>
                                        <div class="property-social-links">
                                            <span class="social-share"><?php echo wp_rem_plugin_text_srt('wp_rem_property_social_share_text') ?></span>
                                            <?php do_action('wp_rem_social_sharing'); ?>
                                        </div>
                                    <?php } ?>
                                    <?php do_action('wp_rem_detail_compare_btn', $post_id); ?>
                                </div>
                                <?php do_action('wp_rem_enquire_arrange_buttons_element_html', $post_id); ?>
                            </div>
                            <?php do_action('wp_rem_images_gallery_element_html', $post_id); ?>
                            <?php
                            do_action('wp_rem_custom_fields_html', $post_id);

                            // DESCRIPTION AND FEATURE CONTENT START
                            $my_postid = $post_id; //This is page id or post id
                            $content_post = get_post($my_postid);
                            $content = $content_post->post_content;
                            $content = apply_filters('the_content', $content);
                            $content = str_replace(']]>', ']]&gt;', $content);
                            $wp_rem_property_summary = get_post_meta($post_id, 'wp_rem_property_summary', true);
                            $wp_rem_property_summary = isset($wp_rem_property_summary) ? $wp_rem_property_summary : '';
                            if ($wp_rem_property_summary != '' || $content != '') {
                                ?>
                                <?= do_shortcode('[really_simple_share button="facebook_share_new"]') ?>
                                <div id="property-detail" class="description-holder">
                                    <?php if ($wp_rem_property_summary != '') { ?>
                                        <div class="property-feature">
                                            <div class="element-title">
                                                <h3><?php echo wp_rem_plugin_text_srt('wp_rem_property_property_key_detail'); ?></h3>
                                            </div>
                                            <p><?php echo force_balance_tags(str_replace("<br/>", '</p><p>', str_replace("<br />", '</p><p>', nl2br($wp_rem_property_summary)))); ?></p>
                                        </div>
                                    <?php } ?>
                                    <?php if ($content != '') { ?>    
                                        <div class="property-dsec">
                                            <div class="element-title">
                                                <h3><?php echo wp_rem_plugin_text_srt('wp_rem_property_property_desc'); ?></h3>
                                            </div>
                                            <?php echo force_balance_tags($content); ?>
                                        </div> 
                                    <?php } ?> 
                                </div>
                            <?php } // DESCRIPTION AND FEATURE CONTENT END ?> 
							
							<?php do_action('wp_rem_sidebar_map_html', $post_id); ?>
                            <?php
                            if ($wp_rem_enable_features_element != 'off') {
                                do_action('wp_rem_features_element_html', $post_id);
                            }
                            ?>
                            <?php
                            if ($wp_rem_enable_appartment_for_sale_element != 'off') {
                                do_action('wp_rem_property_apartment_html', $post_id);
                            }
                            ?>
                            <?php
                            if ($wp_rem_enable_video_element != 'off') {
                                do_action('wp_rem_property_video_html', $post_id);
                            }
                            ?>
                            <?php
                            if ($wp_rem_enable_file_attachments_element != 'off') {
                                do_action('wp_rem_attachments_html', $post_id);
                            }
                            ?>
                            <?php
                            if ($wp_rem_enable_yelp_places_element != 'off') {
                                do_action('wp_rem_restaurant_yelp_results', $post_id);
                            }
                            ?>

                            <?php if (!empty($wp_rem_property_type_walkscores_switch) && $wp_rem_property_type_walkscores_switch == 'on') : ?>
                                <?php if (true || isset($wp_rem_plugin_options['wp_rem_walkscore_api_key']) && $wp_rem_plugin_options['wp_rem_walkscore_api_key'] != '') : ?>
                                    <?php
                                    $response = wp_rem_get_walk_score($wp_rem_post_loc_latitude, $wp_rem_post_loc_longitude, $wp_rem_post_loc_address_property);
                                    if (is_array($response)) {
                                        //var_dump( $response['body'] );
                                        $response = json_decode($response['body'], true);
                                        ?>
                                        <div class="scoring-holder">
                                            <div class="section-title">
                                                <h2><?php echo wp_rem_plugin_text_srt('wp_rem_property_walk_scores'); ?></h2>
                                                <div class="walkscore-logo">
                                                    <a href="https://www.walkscore.com" target="_blank">
                                                        <img src="https://cdn.walk.sc/images/api-logo.png" alt="<?php echo wp_rem_plugin_text_srt('wp_rem_property_walk_scores'); ?>">
                                                    </a>
                                                </div>
                                            </div>
                                            <ul class="scoring-list">
                                                <?php if (isset($response['status']) && $response['status'] == 1) : ?>

                                                    <?php if (isset($response['walkscore'])) : ?>
                                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="img-holder"> <span class="socres-lable"><?php echo $response['walkscore']; ?></span></div>
                                                            <div class="text-holder">
                                                                <a href="<?php echo $response['ws_link']; ?>"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_property_walk_scores'); ?></strong></a>
                                                                <address>
                                                                    <?php echo $response['description']; ?>
                                                                </address>
                                                                <a href="<?php echo $response['ws_link']; ?>" class="moredetail-btn"><?php echo wp_rem_plugin_text_srt('wp_rem_property_walk_scores_more_detail'); ?></a>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if (isset($response['transit']) && !empty($response['transit']['score'])) : ?>
                                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="img-holder"> <span class="socres-lable"><?php echo $response['transit']['score']; ?></span> </div>
                                                            <div class="text-holder">
                                                                <a href="<?php echo $response['ws_link']; ?>"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_property_transit_score'); ?></strong></a>
                                                                <address>
                                                                    <?php echo $response['transit']['description']; ?>
                                                                </address>
                                                                <a href="<?php echo $response['ws_link']; ?>" class="moredetail-btn"><?php echo wp_rem_plugin_text_srt('wp_rem_property_walk_scores_more_detail'); ?></a>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>

                                                    <?php if (isset($response['bike']) && !empty($response['bike']['score'])) : ?>
                                                        <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <div class="img-holder"> <span class="socres-lable"><?php echo $response['bike']['score']; ?></span> </div>
                                                            <div class="text-holder">
                                                                <a href="<?php echo $response['ws_link']; ?>"><strong><?php echo wp_rem_plugin_text_srt('wp_rem_property_bike_score'); ?></strong></a>
                                                                <address>
                                                                    <?php echo $response['bike']['description']; ?>
                                                                </address>
                                                                <a href="<?php echo $response['ws_link']; ?>" class="moredetail-btn"><?php echo wp_rem_plugin_text_srt('wp_rem_property_walk_scores_more_detail'); ?></a>
                                                            </div>
                                                        </li>
                                                    <?php endif; ?>

                                                <?php else: ?>
                                                    <li class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                        <?php echo wp_rem_plugin_text_srt('wp_rem_property_score_error_occured'); ?>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                        <?php
                                    } else {
                                        echo wp_rem_plugin_text_srt('wp_rem_property_score_error_occured');
                                    }
                                    ?>

                                <?php endif; ?>
                            <?php endif; ?>

                            <?php
                            if ($wp_rem_enable_floot_plan_element != 'off') {
                                $floor_plans = get_post_meta($post_id, 'wp_rem_floor_plans', true);
                                $floor_plans = empty($floor_plans) ? array() : $floor_plans;
                                if (count($floor_plans) > 0) :
                                    ?>
                                    <div class="architecture-holder">
                                        <div class="element-title">
                                            <h3><?php echo wp_rem_plugin_text_srt('wp_rem_floor_plans'); ?></h3>
                                        </div>
                                        <?php $active = 'active'; ?>
                                        <ul class="nav nav-tabs">
                                            <?php foreach ($floor_plans as $key => $floor_plan) : ?>
                                                <?php
                                                if ($key == 1) {
                                                    $active = '';
                                                }
                                                ?>
                                                <li class="<?php echo esc_html($active); ?>"><a data-toggle="tab" href="#<?php echo sanitize_title($floor_plan['floor_plan_title']); ?>"><?php echo esc_html($floor_plan['floor_plan_title']); ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <div class="tab-content">
                                            <?php $active = 'active'; ?>
                                            <?php foreach ($floor_plans as $key => $floor_plan) : ?>
                                                <?php
                                                if ($key == 1) {
                                                    $active = '';
                                                }
                                                $floor_plan['floor_plan_desc'] = isset($floor_plan['floor_plan_desc']) ? $floor_plan['floor_plan_desc'] : '';
                                                $floor_id = '';
                                                if (isset($floor_plan['floor_plan_title']) && $floor_plan['floor_plan_title'] != '') {
                                                    $floor_id = 'id="' . sanitize_title($floor_plan['floor_plan_title']) . '"';
                                                }
                                                ?>
                                                <div <?php echo ($floor_id); ?> class="tab-pane fade in <?php echo esc_html($active); ?>">
                                                    <p><?php echo esc_html($floor_plan['floor_plan_desc']); ?></p>
                                                    <img src="<?php echo wp_get_attachment_url($floor_plan['floor_plan_image']); ?>" alt=""/>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                            }
                            ?>

                            <?php
                            if (isset($wp_rem_plugin_options['wp_rem_property_static_text_block']) && $wp_rem_plugin_options['wp_rem_property_static_text_block'] != '') {
                                $environmental_text = isset($wp_rem_plugin_options['wp_rem_property_static_envior_text']) ? $wp_rem_plugin_options['wp_rem_property_static_envior_text'] : '';
                                ?>
                                <div class="element-title">
                                    <h3><?php echo esc_html($environmental_text) ?></h3>
                                </div>
                                <div class="property-static-text">
                                    <?php
                                    echo htmlspecialchars_decode($wp_rem_plugin_options['wp_rem_property_static_text_block']);
                                    ?>
                                </div>
                            <?php } ?>
                            <?php do_action('wp_rem_author_info_html', $post_id); ?>
                        </div>
                        <div class="sidebar col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <?php do_action('wp_rem_payment_calculator_html', $post_id); ?>
                        </div>
                        <?php
                    } else {
                        ?> 
                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="member-inactive">
                                <i class="icon-warning"></i>
                                <span> <?php echo wp_rem_plugin_text_srt('wp_rem_user_profile_not_active'); ?></span>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php do_action('wp_rem_nearby_properties_element_html', $post_id); ?>
</div>