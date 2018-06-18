<?php
/**
 * The template for displaying single member
 *
 */
global $post, $wp_rem_plugin_options, $wp_rem_theme_options, $Wp_rem_Captcha, $wp_rem_form_fields_frontend, $wp_rem_post_property_types;
$post_id = $post->ID;
$wp_rem_user_status = get_post_meta($post_id, 'wp_rem_user_status', true);
$wp_rem_captcha_switch = '';
$wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
$wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
$wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
$default_property_no_custom_fields = isset($wp_rem_plugin_options['wp_rem_property_no_custom_fields']) ? $wp_rem_plugin_options['wp_rem_property_no_custom_fields'] : '';
$wp_rem_phone_number = get_post_meta($post_id, 'wp_rem_phone_number', true);
$wp_rem_email_address = get_post_meta($post_id, 'wp_rem_email_address', true);
$wp_rem_email_address = isset($wp_rem_email_address) ? $wp_rem_email_address : '';
$wp_rem_biography = get_post_meta($post_id, 'wp_rem_biography', true);
$wp_rem_post_loc_address_member = get_post_meta($post_id, 'wp_rem_post_loc_address_member', true);
$wp_rem_website = get_post_meta($post_id, 'wp_rem_website', true);
$wp_rem_post_loc_latitude_member = get_post_meta($post_id, 'wp_rem_post_loc_latitude_member', true);
$wp_rem_post_loc_longitude_member = get_post_meta($post_id, 'wp_rem_post_loc_longitude_member', true);
$default_zoom_level = ( isset($wp_rem_plugin_options['wp_rem_map_zoom_level']) && $wp_rem_plugin_options['wp_rem_map_zoom_level'] != '' ) ? $wp_rem_plugin_options['wp_rem_map_zoom_level'] : 10;
$wp_rem_property_zoom = get_post_meta($post_id, 'wp_rem_post_loc_zoom_member', true);
if ( $wp_rem_property_zoom == '' || $wp_rem_property_zoom == 0 ) {
    $wp_rem_property_zoom = $default_zoom_level;
}
$member_image_id = get_post_meta($post_id, 'wp_rem_profile_image', true);
$member_image = wp_get_attachment_url($member_image_id);
if ( $member_image == '' ) {
    $member_image = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/member-no-image.jpg');
}
$member_title = '';
$member_title = get_the_title($post_id);
$member_link = '';
$member_link = get_the_permalink($post_id);
wp_enqueue_script('wp-rem-prettyPhoto');
wp_enqueue_style('wp-rem-prettyPhoto');
$wp_rem_cs_inline_script = '
                jQuery(document).ready(function () {
                     jQuery("a.property-video-btn[rel^=\'prettyPhoto\']").prettyPhoto({animation_speed:"fast",slideshow:10000, hideflash: true,autoplay:true,autoplay_slideshow:false});
                });';
wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');




if ( isset($wp_rem_user_status) && $wp_rem_user_status == 'active' ) {
    ?>
    <div class="page-content col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="member-info">
                    <div class="img-holder">
                        <figure>
                            <?php
                            if ( isset($member_image) && $member_image != '' ) {
                                ?>
                                <img src="<?php echo esc_url($member_image); ?>" alt="" />
                                <?php
                            }
                            ?>
                        </figure>
                    </div>
                    <div class="text-holder">
                        <div class="title-area">
                            <h3><?php the_title(); ?></h3>
                        </div> 
                        <ul class="info-list">
                            <?php if ( isset($wp_rem_post_loc_address_member) && $wp_rem_post_loc_address_member != '' ) { ?>
                                <li><i class="icon-location-pin2"></i> <a href="#" class="branch-address-link" data-lat="<?php echo $wp_rem_post_loc_latitude_member; ?>" data-lng="<?php echo $wp_rem_post_loc_longitude_member; ?>"><?php echo esc_html($wp_rem_post_loc_address_member); ?></a></li>
                            <?php } ?>
                            <?php
                            if ( isset($wp_rem_phone_number) && $wp_rem_phone_number != '' ) {
                                $wp_rem_phone_number = str_replace(" ", "-", $wp_rem_phone_number);
                                ?>
                                <li><i class="icon-mobile2"></i><a href="tel:<?php echo esc_html($wp_rem_phone_number); ?>"><?php echo esc_html($wp_rem_phone_number); ?></a> </li>
                            <?php } ?> 
                            <?php if ( isset($wp_rem_website) && $wp_rem_website != '' ) { ?>
                                <li><i class="icon-earth-globe"></i><a target="_blank"  href="<?php echo esc_url($wp_rem_website); ?>"><?php echo esc_html($wp_rem_website); ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>

                </div>
                <!--Tabs Start-->
                <div class="member-tabs horizontal">
                    <ul class="nav nav-tabs">
                        <?php if ( isset($wp_rem_biography) && $wp_rem_biography != '' ) { ?>
                            <li class="active"><a data-toggle="tab" href="#overview_tab"><?php echo wp_rem_plugin_text_srt('wp_rem_member_overview'); ?> </a></li>
                        <?php } ?>
                        <?php if ( ! empty($branches) && sizeof($branches) > 0 ) { ?>
                            <li><a data-toggle="tab" href="#branches_tab"><?php echo wp_rem_plugin_text_srt('wp_rem_member_office_branches'); ?> </a></li>
                        <?php } ?>
                        <?php if ( ! empty($team_members) && sizeof($team_members) > 1 ) { ?>
                            <li><a data-toggle="tab" href="#member_tab"><?php echo wp_rem_plugin_text_srt('wp_rem_member_staff'); ?> </a></li>
                        <?php } ?>
                        <li><a data-toggle="tab" href="#contact_tab"><?php echo wp_rem_plugin_text_srt('wp_rem_member_find_on_map'); ?> </a></li>
                    </ul>
                    <div class="tab-content">
                        <?php if ( isset($wp_rem_biography) && $wp_rem_biography != '' ) { ?>
                            <div id="overview_tab" class="tab-pane fade in active">
                                <p><?php echo force_balance_tags(str_replace("<br/>", '</p><p>', str_replace("<br />", '</p><p>', nl2br($wp_rem_biography)))); ?></p>
                            </div>
                        <?php } ?>
                        <?php $branches_markers = array(); ?>
                        <?php if ( ! empty($branches) && sizeof($branches) > 0 ) { ?>
                            <div id="branches_tab" class="tab-pane fade member-branches-tab">
                                <ul class="tabs-property">
                                    <?php
                                    foreach ( $branches as $key => $branche ) {
                                        $branche_name = get_post_meta($branche, 'wp_rem_branch_name', true);
                                        $branche_phone = get_post_meta($branche, 'wp_rem_branch_phone', true);
                                        $branche_email = get_post_meta($branche, 'wp_rem_branch_email', true);
                                        $branche_adrss = get_post_meta($branche, 'wp_rem_post_loc_address_branch', true);
                                        $branche_lat = get_post_meta($branche, 'wp_rem_post_loc_latitude_branch', true);
                                        $branche_lng = get_post_meta($branche, 'wp_rem_post_loc_longitude_branch', true);
                                        ?>
                                        <li>
                                            <div class="member-data">
                                                <h3><?php echo esc_html($branche_name); ?></h3> 
                                                <address><a href="#" class="branch-address-link" data-lat="<?php echo $branche_lat; ?>" data-lng="<?php echo $branche_lng; ?>"><i class="icon-location-pin2"></i><?php echo esc_html($branche_adrss); ?></a></address>
                                                <span class="member-email"><i class="icon-envelope-o"></i><a href="mailto:<?php echo esc_html($branche_email); ?>"><?php echo wp_rem_plugin_text_srt('wp_rem_member_contact_email'); ?></a> </span>
                                                <?php if ( isset($branche_phone) && $branche_phone != '' ) { ?>
                                                    <span class="member-phone"><i class="icon-phone2"></i><?php echo esc_html($branche_phone); ?> </span> 
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </li>
                                        <?php
                                        $marker_info = '';
                                        $marker_info .= '<div id="property-info-' . $key . '-' . '" class="property-info-inner">';
                                        $marker_info .= '<div class="info-main-container">';
                                        if ( $member_image != '' ) {
                                            $marker_info .= '<figure style="text-align: center;"><a class="info-title" href="#"><img src="' . $member_image . '" style="width: 100px;"></a></figure>';
                                        }
                                        $marker_info .= '<div class="info-txt-holder">';
                                        $marker_info .= '<a class="info-title" href="#"><b>' . $branche_name . '</b></a>';

                                        $marker_info .= '<ul class="info-list">';
                                        if ( isset($branche_adrss) && $branche_adrss != '' ) {
                                            $marker_info .= '<li><i class="icon-map-pin"></i> ' . esc_html($branche_adrss) . '</li>';
                                        }

                                        if ( isset($branche_phone) && $branche_phone != '' ) {
                                            $branche_phone = str_replace(" ", "-", $branche_phone);
                                            $marker_info .= '<li><i class="icon-phone2"></i> <a href="tel:' . esc_html($branche_phone) . '">' . esc_html($branche_phone) . '</a> </li>';
                                        }

                                        $marker_info .= '</ul>';
                                        $marker_info .= '</div>';
                                        $marker_info .= '</div>';
                                        $marker_info .= '</div>';

                                        $branches_markers[] = array(
                                            'name' => $branche_name,
                                            'address' => $branche_adrss,
                                            'lat' => $branche_lat,
                                            'lng' => $branche_lng,
                                            'content' => $marker_info,
                                        );
                                        ?>
                                    <?php } ?>
                                </ul>
                                <script type="text/javascript">
                                    jQuery(function () {
                                        $ = jQuery;
                                        window.is_address_link_clicked = false;
                                        $(".branch-address-link").click(function (e) {
                                            e.stopPropagation();
                                            var lat = $(this).data('lat');
                                            var lng = $(this).data('lng');
                                            window.is_address_link_clicked = true;
                                            $("a[href='#contact_tab']").trigger('click');
                                            if (typeof window.all_branches_markers != "undefined") {
                                                $.each(window.all_branches_markers, function (key, marker) {
                                                    //console.log( marker.position.lat() + "=" + lat );
                                                    //console.log( marker.position.lng() + "=" + lng );
                                                    if (marker.position.lat() == lat) {
                                                        map.setZoom(17);
                                                        map.panTo(marker.position);
                                                        new google.maps.event.trigger(marker, 'click');
                                                    }

                                                });
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        <?php } ?>
                        <?php if ( ! empty($team_members) && sizeof($team_members) > 1 ) { ?>
                            <div id="member_tab" class="tab-pane fade">
                                <div class="wp-rem-members-list">
                                    <ul class="tabs-property">
                                        <?php
                                        foreach ( $team_members as $member_data ) {
                                            $selected_user_type = get_user_meta($member_data->ID, 'wp_rem_user_type', true);
                                            $selected_user_type = isset($selected_user_type) && $selected_user_type != '' ? $selected_user_type : 'team-member';
                                            $member_permissions = get_user_meta($member_data->ID, 'wp_rem_permissions', true);
                                            $member_name = get_user_meta($member_data->ID, 'member_name', true);
                                            $phone_number = get_user_meta($member_data->ID, 'member_phone_number', true);
                                            $wp_rem_member_thumb_id = get_user_meta($member_data->ID, 'member_thumb', true);
                                            $member_name = ( isset($member_name) && $member_name != '' ) ? $member_name : $member_data->user_login;
                                            $wp_rem_public_profile = get_user_meta($member_data->ID, 'wp_rem_public_profile', true);
                                            $wp_rem_public_profile = isset($wp_rem_public_profile) ? $wp_rem_public_profile : '';
                                            if ( isset($wp_rem_public_profile) && $wp_rem_public_profile == 'yes' ) {
                                                ?>
                                                <li>
                                                    <?php if ( isset($wp_rem_member_thumb_id) && $wp_rem_member_thumb_id != '' ) { ?>
                                                        <div class="member-image">
                                                            <?php echo wp_get_attachment_image($wp_rem_member_thumb_id, 'thumbnail'); ?>
                                                        </div>
                                                    <?php } ?>
                                                    <div class="member-data">
                                                        <h3><?php echo esc_html($member_name); ?></h3> 
                                                        <span class="member-email"><i class="icon-envelope-o"></i><a href="mailto:<?php echo esc_html($member_data->user_email); ?>"><?php echo wp_rem_plugin_text_srt('wp_rem_member_contact_email'); ?></a> </span>
                                                        <?php if ( isset($phone_number) && $phone_number != '' ) { ?>
                                                            <span class="member-phone"><i class="icon-phone2"></i><?php echo esc_html($phone_number); ?> </span> 
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <div id="contact_tab" class="tab-pane fade member-contact-form">
                            <?php if ( ( isset($wp_rem_post_loc_latitude_member) && $wp_rem_post_loc_latitude_member != '' ) && ( isset($wp_rem_post_loc_longitude_member) && $wp_rem_post_loc_longitude_member != '' ) ) { ?>
                                <div class="widget widget-map-sec">
                                    <?php
                                    $marker_info = '';
                                    $marker_info .= '<div id="property-info-' . $post_id . '-' . '" class="property-info-inner">';
                                    $marker_info .= '<div class="info-main-container">';
                                    if ( $member_image != '' ) {
                                        $marker_info .= '<figure style="text-align: center;"><a class="info-title" href="' . $member_link . '"><img src="' . $member_image . '" style="width: 100px;"></a></figure>';
                                    }
                                    $marker_info .= '<div class="info-txt-holder">';
                                    $marker_info .= '<a class="info-title" href="' . $member_link . '"><b>' . $member_title . '</b></a>';

                                    $marker_info .= '<ul class="info-list">';
                                    if ( isset($wp_rem_post_loc_address_member) && $wp_rem_post_loc_address_member != '' ) {
                                        $marker_info .= '<li><i class="icon-map-pin"></i> ' . esc_html($wp_rem_post_loc_address_member) . '</li>';
                                    }

                                    if ( isset($wp_rem_phone_number) && $wp_rem_phone_number != '' ) {
                                        $wp_rem_phone_number = str_replace(" ", "-", $wp_rem_phone_number);
                                        $marker_info .= '<li><i class="icon-phone2"></i> <a href="tel:' . esc_html($wp_rem_phone_number) . '">' . esc_html($wp_rem_phone_number) . '</a> </li>';
                                    }

                                    if ( isset($wp_rem_email_address) && $wp_rem_email_address != '' ) {
                                        $marker_info .= '<li><i class="icon-mail6"></i> <a href="mailto:' . esc_html($wp_rem_email_address) . '">' . esc_html($wp_rem_email_address) . '</a></li>';
                                    }
                                    $marker_info .= '</ul>';
                                    $marker_info .= '</div>';
                                    $marker_info .= '</div>';
                                    $marker_info .= '</div>';
                                    $map_atts = array(
                                        'map_height' => '350',
                                        'map_lat' => $wp_rem_post_loc_latitude_member,
                                        'map_lon' => $wp_rem_post_loc_longitude_member,
                                        'map_zoom' => $wp_rem_property_zoom,
                                        'map_type' => '',
                                        'map_info' => $marker_info,
                                        'map_info_width' => '230',
                                        'map_info_height' => '350',
                                        'map_marker_icon' => '',
                                        'map_show_marker' => 'true',
                                        'map_controls' => 'true',
                                        'map_draggable' => 'true',
                                        'map_scrollwheel' => 'false',
                                        'map_border' => '',
                                        'map_border_color' => '',
                                        'wp_rem_map_style' => '',
                                        'wp_rem_map_class' => '',
                                        'wp_rem_map_directions' => 'off',
                                        'wp_rem_map_circle' => '',
                                        'wp_rem_branches_map' => true,
                                    );
                                    if ( isset($branches) ) {
                                        $map_atts['wp_rem_branches_markers'] = $branches_markers;
                                    }
                                    if ( function_exists('wp_rem_map_content') ) {
                                        wp_rem_map_content($map_atts);
                                        ?>
                                        <script type="text/javascript">
                                            jQuery(function () {
                                                $ = jQuery;
                                                $("a[href='#contact_tab']").on('shown.bs.tab', function () {
                                                    google.maps.event.trigger(map, 'resize');
                                                    if (!window.is_address_link_clicked) {
                                                        var center1 = new google.maps.LatLng("<?php echo $wp_rem_post_loc_latitude_member; ?>", "<?php echo $wp_rem_post_loc_longitude_member; ?>");
                                                        map.panTo(center1);
                                                    }
                                                    window.is_address_link_clicked = false;
                                                });
                                            });
                                        </script>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                            <!-- Modal -->
                        </div>
                    </div>
                </div>
                <!--Tabs End-->
            </div>
            <div id="properties"></div>
            <?php
            if ( $post_count > 0 ) {
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="element-title">
                        <h2><?php
                            echo get_the_title($post_id) . ' ';
                            echo wp_rem_plugin_text_srt('wp_rem_member_properties');
                            ?></h2>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="real-estate-property">
                        <div class="row">
                            <?php
                            while ( $custom_query->have_posts() ) : $custom_query->the_post();
                                global $post;
                                $property_id = $post->ID;
                                $wp_rem_cover_image_id = get_post_meta($property_id, 'wp_rem_cover_image', true);
                                $wp_rem_cover_image = wp_get_attachment_url($wp_rem_cover_image_id);
                                $wp_rem_post_loc_address_property = get_post_meta($property_id, 'wp_rem_post_loc_address_property', true);
                                $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                                $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
                                $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                                $wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($wp_rem_property_type);
                                $wp_rem_property_is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);
                                $wp_rem_property_gallery_ids = get_post_meta($property_id, 'wp_rem_detail_page_gallery_ids', true);
                                $gallery_pics_allowed = get_post_meta($property_id, 'wp_rem_transaction_property_pic_num', true);
                                $count_all = ( isset($wp_rem_property_gallery_ids) && is_array($wp_rem_property_gallery_ids) && sizeof($wp_rem_property_gallery_ids) > 0 ) ? count($wp_rem_property_gallery_ids) : 0;
                                if ( $count_all > $gallery_pics_allowed ) {
                                    $count_all = $gallery_pics_allowed;
                                }
                                $gallery_image_count = $count_all;
                                // checking review in on in property type
                                $wp_rem_property_type = isset($wp_rem_property_type) ? $wp_rem_property_type : '';
                                if ( $property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type') )
                                    $property_type_id = $property_type_post->ID;
                                $property_type_id = isset($property_type_id) ? $property_type_id : '';
                                // get all categories
                                $wp_rem_cate = '';
                                $wp_rem_cate_str = '';
                                $wp_rem_property_category = get_post_meta($property_id, 'wp_rem_property_category', true);
                                $wp_rem_post_loc_address_property = get_post_meta($property_id, 'wp_rem_post_loc_address_property', true);
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
                                ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="property-medium">
                                        <div class="img-holder">
                                            <figure>
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php
                                                    if ( function_exists('property_gallery_first_image') ) {
                                                        $gallery_image_args = array(
                                                            'property_id' => $property_id,
                                                            'size' => 'full',
                                                            'class' => '',
                                                            'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image9x6.jpg')
                                                        );
                                                        echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
                                                    }
                                                    ?>
                                                </a>
                                                <figcaption>
                                                    <?php if ( isset($wp_rem_property_is_featured) && $wp_rem_property_is_featured == 'on' ) { ?>
                                                        <span class="featured"><?php echo wp_rem_plugin_text_srt('wp_rem_property_featured'); ?></span>
                                                    <?php } ?>
                                                    <div class="caption-inner">
                                                        <?php if ( $wp_rem_cate_str != '' ) { ?>
                                                            <span class="rent-label"><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></span>
                                                        <?php } ?>
                                                        <?php if ( isset($gallery_image_count) && $gallery_image_count > 0 ) { ?>
                                                            <ul id="galley-img<?php echo absint($property_id) ?>" class="galley-img">
                                                                <li><a  href="javascript:void(0)" class="rem-pretty-photos" data-id="<?php echo absint($property_id) ?>" ><span class="capture-count"><i class="icon-camera6"></i><?php echo absint($gallery_image_count); ?></span><div class="info-content"><span><?php echo wp_rem_plugin_text_srt('wp_rem_element_tooltip_icon_camera'); ?></span></div></a> </li>   
                                                            </ul>
                                                            <?php
                                                        }

                                                        $property_video_url = get_post_meta($property_id, 'wp_rem_property_video', true);
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
                                            <div class="post-title">
                                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                            </div>
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
                                            do_action('wp_rem_favourites_frontend_button', $property_id, $book_mark_args, $figcaption_div);
                                            if ( isset($wp_rem_post_loc_address_property) && ! empty($wp_rem_post_loc_address_property) ) {
                                                ?>
                                                <ul class="property-location">
                                                    <li><i class="icon-location-pin2"></i><span><?php echo esc_html($wp_rem_post_loc_address_property); ?></span></li>
                                                </ul>
                                                <?php
                                            }
                                            // All custom fields with value
                                            $cus_fields = array( 'content' => '' );
                                            $cus_fields = apply_filters('wp_rem_custom_fields', $property_id, $cus_fields, $default_property_no_custom_fields);
                                            if ( isset($cus_fields['content']) && $cus_fields['content'] != '' ) {
                                                ?>
                                                <div class="post-category-list">
                                                    <ul>
                                                        <?php echo wp_rem_allow_special_char($cus_fields['content']); ?>
                                                    </ul>
                                                </div>
                                                <?php
                                            }
                                            if ( isset($wp_rem_property_price_options) && $wp_rem_property_price_options == 'price' ) {
                                                $wp_rem_property_price = wp_rem_property_price($property_id, $wp_rem_property_price, '<span class="guid-price">', '</span>');
                                                ?>
                                                <span class="property-price"><?php echo force_balance_tags($wp_rem_property_price); ?><small></small></span>
                                            <?php } ?>
                                            <div class="post-time">
                                                <small>
                                                    <?php
                                                    $month = get_the_date('M');
                                                    $day = get_the_date('j');
                                                    $year = get_the_date('Y');
                                                    printf(wp_rem_plugin_text_srt('wp_rem_member_listed_on'), $day, $month, $year);
                                                    ?>
                                                </small>
                                                <a href="<?php echo esc_url($member_link); ?>"><span><?php echo esc_html($member_title); ?></span></a>
                                            </div>
                                            <?php if ( isset($member_image) && $member_image != '' ) { ?>
                                                <div class="thumb-img">
                                                    <a href="<?php echo esc_url($member_link); ?>"><img src="<?php echo esc_url($member_image); ?>"></a>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                wp_reset_postdata();
                            endwhile;
                            ?>
                        </div>
                        <?php
                        $property_short_counter = rand(123, 9999);

                        $paging_args = array(
                            'total_posts' => $post_count,
                            'posts_per_page' => $paging_var_perpage,
                            'paging_var' => $paging_var,
                            'show_pagination' => 'yes',
                            'property_short_counter' => $property_short_counter,
                        );
                        do_action('wp_rem_pagination', $paging_args);
                        ?>
                    </div>
                </div>
                <?php
            }
            ?> 
        </div>
    </div>
    <aside class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <form class="contactform_name" id="contactfrm<?php echo absint($wp_rem_cs_email_counter); ?>" name="contactform_name" action="javascript:wp_rem_contact_send_message(<?php echo absint($wp_rem_cs_email_counter); ?>)">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h5><?php echo wp_rem_plugin_text_srt('wp_rem_contact_heading'); ?> <?php echo get_the_title($post_id); ?></h5>
                    <div id="message22" class="response-message"></div>
                    <div class="field-holder">
                        <i class="icon- icon-user4"></i>
                        <?php
                        $wp_rem_opt_array = array(
                            'cust_name' => 'contact_full_name',
                            'return' => false,
                            'classes' => 'input-field',
                            'extra_atr' => ' placeholder=" ' . wp_rem_plugin_text_srt('wp_rem_member_contact_your_name') . '"',
                        );
                        $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                        ?>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="field-holder">
                        <i class="icon- icon-envelope3"></i>
                        <?php
                        $wp_rem_opt_array = array(
                            'cust_name' => 'contact_email_add',
                            'return' => false,
                            'classes' => 'input-field',
                            'extra_atr' => ' placeholder=" ' . wp_rem_plugin_text_srt('wp_rem_member_contact_your_email') . '"',
                        );
                        $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                        ?>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="field-holder">
                        <i class="icon-message"></i>
                        <?php
                        $wp_rem_opt_array = array(
                            'std' => '',
                            'id'=>'',
                            'name'=>'',
                            'cust_name' => 'contact_message_field',
                            'return' => false,
                            'extra_atr' => ' placeholder=" ' . wp_rem_plugin_text_srt('wp_rem_member_contact_your_message') . '"',
                        );
                        $wp_rem_form_fields_frontend->wp_rem_form_textarea_render($wp_rem_opt_array);
                        ?>
                    </div>
                </div>
                <?php
                if ( $wp_rem_captcha_switch == 'on' ) {
                    if ( $wp_rem_sitekey <> '' and $wp_rem_secretkey <> '' ) {
                        wp_rem_google_recaptcha_scripts();
                        ?>
                        <script>
                            var recaptcha_member;
                            var wp_rem_multicap = function () {
                                //Render the recaptcha1 on the element with ID "recaptcha1"
                                recaptcha_member = grecaptcha.render('recaptcha_member_sidebar', {
                                    'sitekey': '<?php echo ($wp_rem_sitekey); ?>', //Replace this with your Site key
                                    'theme': 'light'
                                });

                            };
                        </script>
                        <?php
                    }
                    if ( class_exists('Wp_rem_Captcha') ) {
                        $output = '<div class="col-md-12 recaptcha-reload" id="member_sidebar_div">';
                        $output .= $Wp_rem_Captcha->wp_rem_generate_captcha_form_callback('member_sidebar', 'true');
                        $output .='</div>';
                        echo force_balance_tags($output);
                    }
                }
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php wp_rem_term_condition_form_field('member_detail_term_policy', 'member_detail_term_policy'); ?>
                    <div class="field-holder">
                        <div class="contact-message-submit input-button-loader">
                            <?php
                            $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                    array(
                                        'cust_id' => 'message_submit',
                                        'cust_name' => 'contact_message_submit',
                                        'classes' => 'bgcolor',
                                        'std' => wp_rem_plugin_text_srt('wp_rem_contact_send_message') . '',
                                        'cust_type' => "submit",
                                    )
                            );
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
        echo do_action('wp_rem_opening_hours_element_opened_html', $post_id);
        if ( isset($featured_count) && $featured_count > 0 ) {
            ?>
            <div class="property-featured-widget">
                <div class="widget-title">
                    <h5><?php echo wp_rem_plugin_text_srt('wp_rem_member_featured_property'); ?></h5>
                </div>
                <div class="real-estate-property">
                    <?php
                    while ( $custom_query_featured->have_posts() ) : $custom_query_featured->the_post();
                        global $post, $wp_rem_member_profile;
                        $property_id = $post->ID;
                        $wp_rem_property_username = get_post_meta($property_id, 'wp_rem_property_username', true);
                        $wp_rem_property_is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);
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
                        $wp_rem_property_type_price_nearby_switch = get_post_meta($property_type_nearby_id, 'wp_rem_property_type_price', true);
                        $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
                        ?>
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
                                        <?php if ( isset($wp_rem_property_is_featured) && $wp_rem_property_is_featured == 'on' ) { ?>
                                            <span class="featured"><?php echo wp_rem_plugin_text_srt('wp_rem_property_featured'); ?></span>
                                        <?php } ?>
                                        <div class="caption-inner">
                                            <?php if ( $wp_rem_cate_str != '' ) { ?>
                                                <span class="rent-label"><?php echo wp_rem_allow_special_char($wp_rem_cate_str); ?></span>
                                            <?php } ?>

                                            <?php if ( isset($gallery_image_count) && $gallery_image_count > 0 ) { ?>
                                                <ul id="galley-img<?php echo absint($property_id) ?>" class="galley-img">
                                                    <li><a  href="javascript:void(0)" class="rem-pretty-photos" data-id="<?php echo absint($property_id) ?>" ><span class="capture-count"><i class="icon-camera6"></i><?php echo absint($gallery_image_count); ?></span><div class="info-content"><span><?php echo wp_rem_plugin_text_srt('wp_rem_element_tooltip_icon_camera'); ?></span></div></a> </li>   
                                                </ul>
                                            <?php
                                            }

                                            $property_video_url = get_post_meta($property_id, 'wp_rem_property_video', true);
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
                        <?php
                    endwhile;
                    ?>

                </div>
            </div>
        <?php } ?>
    </aside>
<?php } else {
    ?> 
    <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="member-inactive">
            <i class="icon-warning"></i>
            <span> <?php echo wp_rem_plugin_text_srt('wp_rem_user_profile_not_active'); ?></span>
        </div>
    </div>
<?php }
?>