<?php
/**
 * Property Member search box
 *
 */
global $wp_rem_post_member_types;
$search_box = isset($atts['search_box']) ? $atts['search_box'] : '';
// start ads script
$member_ads_switch = isset($atts['member_ads_switch']) ? $atts['member_ads_switch'] : 'no';
$member_excerpt_length = isset($atts['member_excerpt_length']) ? $atts['member_excerpt_length'] : '10';
if ( $member_ads_switch == 'yes' ) {
    $member_ads_after_list_series = isset($atts['member_ads_after_list_count']) ? $atts['member_ads_after_list_count'] : '5';
    if ( $member_ads_after_list_series != '' ) {
        $member_ads_list_array = explode(",", $member_ads_after_list_series);
    }
    $member_ads_after_list_array_count = sizeof($member_ads_list_array);
    $member_ads_after_list_flag = 0;

    $i = 0;
    $array_i = 0;
    $member_ads_after_list_array_final = '';
    while ( $member_ads_after_list_array_count > $array_i ) {
        if ( isset($member_ads_list_array[$array_i]) && $member_ads_list_array[$array_i] != '' ) {
            $member_ads_after_list_array[$i] = $member_ads_list_array[$array_i];
            $i ++;
        }
        $array_i ++;
    }
    // new count 
    $member_ads_after_list_array_count = sizeof($member_ads_after_list_array);
}
$member_page = isset($_REQUEST['member_page']) ? $_REQUEST['member_page'] : '';
$posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '';
$counter = 0;
if ( $member_page >= 2 ) {
    $counter = ( ($member_page - 1) * $posts_per_page );
}
$member_ads_number_counter = 1;
$member_ads_flag_counter = 0;
$member_ads_last_number = 0;
if ( isset($member_ads_after_list_array) && ! empty($member_ads_after_list_array) ) {
    foreach ( $member_ads_after_list_array as $key => $member_ads_number ) {
        $member_ads_last_number = $member_ads_number;
    }
    foreach ( $member_ads_after_list_array as $key => $member_ads_number ) {
        if ( $member_page == 1 || $member_page == '' ) {
            $member_ads_flag_counter = $key;
            break;
        } elseif ( $counter < $member_ads_number ) {
            $member_ads_flag_counter = $key;
            break;
        } elseif ( $member_ads_number_counter == $member_ads_after_list_array_count ) {
            $member_ads_flag_counter = $key;
            break;
        }
        $member_ads_number_counter ++;
    }
}
// end ads script 
$member_location_options = isset($atts['member_location']) ? $atts['member_location'] : '';
if ( $member_location_options != '' ) {
    $member_location_options = explode(',', $member_location_options);
}
if ( $member_loop_obj->have_posts() ) {
    $flag = 1;
    ?>
    <div class="member-property member-medium">
        <?php
        if ( $member_ads_switch == 'yes' ) {
            if ( $member_ads_after_list_array_count > 0 && ( $member_page == 1 || $member_page == '') ) {
                if ( $counter == $member_ads_after_list_array[$member_ads_flag_counter] && $member_ads_after_list_array[$member_ads_flag_counter] == 0 ) {
                    ?>
                    <div class="member-post">
                        <?php do_action('wp_rem_random_ads', 'member_banner'); ?>
                    </div>
                    <?php
                    if ( $member_ads_flag_counter < $member_ads_after_list_array_count ) {
                        $member_ads_flag_counter ++;
                    }
                }
            }
        }
        while ( $member_loop_obj->have_posts() ) : $member_loop_obj->the_post();
            global $post, $wp_rem_member_profile;
            $post_id = $post;
            $member_id = get_post_meta($post_id, 'wp_rem_property_member', true);
            $member_is_featured = get_post_meta($post_id, 'wp_rem_member_is_featured', true);
            $member_is_trusted = get_post_meta($post_id, 'wp_rem_member_is_trusted', true);
            $member_image_id = get_post_meta($post_id, 'wp_rem_profile_image', true);
            $member_image = wp_get_attachment_url($member_image_id);
            $wp_rem_phone_number = get_post_meta($post_id, 'wp_rem_phone_number', true);
            $wp_rem_biography = get_post_meta($post_id, 'wp_rem_biography', true);
            $wp_rem_post_loc_address_member = get_post_meta($post_id, 'wp_rem_post_loc_address_member', true);
            $list_args = array(
                'posts_per_page' => "1",
                'post_type' => 'properties',
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'wp_rem_property_member',
                        'value' => $post_id,
                        'compare' => '=',
                    ),
                    array(
                        'key' => 'wp_rem_property_expired',
                        'value' => strtotime(date("d-m-Y")),
                        'compare' => '>=',
                    ),
                    array(
                        'key' => 'wp_rem_property_status',
                        'value' => 'delete',
                        'compare' => '!=',
                    ),
                ),
            );
            $custom_query = new WP_Query($list_args);
            $num_of_properties = $custom_query->found_posts;
            $num_of_branshes = apply_filters('wp_rem_member_branches_count', $post_id);
            ?>
            <div class="member-post">
                <?php if ( isset($member_is_featured) && $member_is_featured == 'on' ) {
                    ?><span class="post-featured"><?php echo wp_rem_plugin_text_srt('wp_rem_member_featured'); ?></span><?php }
                ?>
                <div class="img-holder">
                    <figure>
                        <a title="<?php echo esc_html(get_the_title($member_id)); ?>" href="<?php the_permalink(); ?>">
                            <?php
                            if ( $member_image != '' ) {
                                $no_image = '<img src="' . $member_image . '" alt=""/>';
                                echo force_balance_tags($no_image);
                            } else {
                                $no_image_url = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg');
                                $no_image = '<img class="img-grid" src="' . $no_image_url . '" alt=""/>';
                                echo force_balance_tags($no_image);
                            }
                            ?>
                        </a>
                    </figure>
                </div>
                <div class="text-holder">
                    <div class="post-title">
                        <h4>
                            <a title="<?php echo esc_html(get_the_title($member_id)); ?>" href="<?php the_permalink(); ?>"><?php echo esc_html(get_the_title($member_id)); ?></a>
                            <?php if ( isset($member_is_trusted) && $member_is_trusted == 'on' ) {
                                ?><span class="trusted-member"><i class="icon-verified_user"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_trusted'); ?></span><?php }
                            ?>
                        </h4>
                    </div>
                     <?php if ( isset($wp_rem_post_loc_address_member) && $wp_rem_post_loc_address_member != '' ) { ?>
                             <span class="member-address"><i class="icon-location-pin2"></i><?php echo esc_html($wp_rem_post_loc_address_member); ?> </span>
                        <?php } ?>   
                    <?php
                    $properties_link_start = '';
                    $properties_link_end = '';
                    if ( $num_of_properties > 0 ) {
                        $properties_link_start = '<a href="' . get_the_permalink($member_id) . '#properties">';
                        $properties_link_end = '</a>';
                    }
                    ?>
                    
                    <span class="properties-count"><?php echo wp_rem_allow_special_char($properties_link_start); ?> <span> <?php echo absint($num_of_properties); ?> <?php echo wp_rem_plugin_text_srt('wp_rem_member_properties2'); ?>  </span><?php echo wp_rem_allow_special_char($properties_link_end); ?></span>
                    <?php if ( $wp_rem_biography != '' ) { ?>
                        <p><?php echo esc_html(wp_trim_words($wp_rem_biography, $member_excerpt_length)); ?></p>
                        <?php
                    }
                    ?>
                    <ul class="member-info">
                        <?php
                        if ( $wp_rem_phone_number != '' ) {
                            ?>
                            <li><a href="tel:<?php echo esc_html(str_replace(' ', '', $wp_rem_phone_number)); ?>"><i class="icon-phone2"></i><?php echo esc_html($wp_rem_phone_number); ?></a></li>
                            <?php
                        }
                        if ( $num_of_branshes != '' && $num_of_branshes > 0 ) {
                            ?> 
                            <li><a href="<?php the_permalink(); ?>#branches_tab"><i class="icon-list2"></i><?php echo absint($num_of_branshes); ?> <?php echo wp_rem_plugin_text_srt('wp_rem_member_branchs'); ?></a></li>
                            <?php
                        }
                        ?>
                        <li><?php do_action('wp_rem_contact_form_element_html', $post_id); ?></li>

                    </ul>
                </div>
            </div>
            <?php
            if ( $member_ads_switch == 'yes' ) {
                if ( $member_ads_after_list_array_count > 0 ) {
                    $new_counter = $counter + 1;
                    $member_ads_value = $member_ads_after_list_array[$member_ads_flag_counter];
                    if ( $new_counter == $member_ads_after_list_array[$member_ads_flag_counter] ) {
                        ?>   
                        <div class="member-post">   <?php do_action('wp_rem_random_ads', 'member_banner'); ?></div>
                        <?php
                        if ( $member_ads_flag_counter < ($member_ads_after_list_array_count - 1) ) {
                            $member_ads_flag_counter ++;
                        }
                    } elseif ( $new_counter % $member_ads_value == 0 && $new_counter > $member_ads_last_number && $new_counter != 1 ) {
                        ?>  
                        <div class="member-post">  <?php do_action('wp_rem_random_ads', 'member_banner'); ?></div>
                        <?php
                    }
                }
            }
            $counter ++;
            ?>
            <?php
        endwhile;
        ?>
    </div>
    <?php
} else {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-member-match-error"><h6><i class="icon-warning"></i><strong> ' . wp_rem_plugin_text_srt('wp_rem_member_sorry') . '</strong>&nbsp; ' . wp_rem_plugin_text_srt('wp_rem_member_no_results') . ' </h6></div>';
}