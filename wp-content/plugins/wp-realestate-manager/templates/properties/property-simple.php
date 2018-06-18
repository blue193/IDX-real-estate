<?php
/**
 * Property search box
 *
 */
global $wp_rem_post_property_types, $wp_rem_cs_var_options;
if ( false === ( $property_view = wp_rem_get_transient_obj('wp_rem_property_view' . $property_short_counter) ) ) {
    $property_view = isset($atts['property_view']) ? $atts['property_view'] : '';
}
$search_box = isset($atts['search_box']) ? $atts['search_box'] : '';
$main_class = 'property-medium';
$property_ads_switch = isset($atts['property_ads_switch']) ? $atts['property_ads_switch'] : 'no';
if ( $property_ads_switch == 'yes' ) {
    $property_ads_after_list_series = isset($atts['property_ads_after_list_count']) ? $atts['property_ads_after_list_count'] : '5';
    if ( $property_ads_after_list_series != '' ) {
        $property_ads_list_array = explode(",", $property_ads_after_list_series);
    }
    $property_ads_after_list_array_count = sizeof($property_ads_list_array);
    $property_ads_after_list_flag = 0;

    $i = 0;
    $array_i = 0;
    $property_ads_after_list_array_final = '';
    while ( $property_ads_after_list_array_count > $array_i ) {
        if ( isset($property_ads_list_array[$array_i]) && $property_ads_list_array[$array_i] != '' ) {
            $property_ads_after_list_array[$i] = $property_ads_list_array[$array_i];
            $i ++;
        }
        $array_i ++;
    }
    // new count 
    $property_ads_after_list_array_count = sizeof($property_ads_after_list_array);
}
$columns_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
if ( $property_view == 'grid' ) {
    $columns_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
    if ( $search_box == 'yes' && $property_view != 'map' ) {
        $columns_class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12';
    }
    $main_class = 'property-grid';
}
if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length']) && $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'] <> '' ) {
    $default_excerpt_length = $wp_rem_cs_var_options['wp_rem_cs_var_excerpt_length'];
} else {
    $default_excerpt_length = '18';
}

// $property_location_options = isset($atts['property_location']) ? $atts['property_location'] : '';
$property_location_options = 'state,country';
if ( $property_location_options != '' ) {
    $property_location_options = explode(',', $property_location_options);
}

$properties_ads_array = array();
if ( $property_ads_switch == 'yes' && $property_ads_after_list_array_count > 0 ) {
    $list_count = 0;
    for ( $i = 0; $i <= $property_loop_obj->found_posts; $i ++ ) {
        if ( $list_count == $property_ads_after_list_array[$property_ads_after_list_flag] ) {
            $list_count = 1;
            $properties_ads_array[] = $i;
            $property_ads_after_list_flag ++;
            if ( $property_ads_after_list_flag >= $property_ads_after_list_array_count ) {
                $property_ads_after_list_flag = $property_ads_after_list_array_count - 1;
            }
        } else {
            $list_count ++;
        }
    }
}
$property_page = isset($_REQUEST['property_page']) && $_REQUEST['property_page'] != '' ? $_REQUEST['property_page'] : 1;
$posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '';
$counter = 1;
if ( $property_page >= 2 ) {
    $counter = ( ($property_page - 1) * $posts_per_page ) + 1;
}

if ( $property_loop_obj->have_posts() ) {
    $flag = 1;
    ?>
    <div class="wp-rem-property">
        <div class="row">
            <?php
            // start top categories
            if ( $element_property_top_category == 'yes' ) {
                while ( $property_top_categries_loop_obj->have_posts() ) : $property_top_categries_loop_obj->the_post();
                    global $post, $wp_rem_member_profile;
                    $property_id = $post;
					$pro_is_compare = apply_filters('wp_rem_is_compare', $property_id, $compare_property_switch);

                    $Wp_rem_Locations = new Wp_rem_Locations();
                    $get_property_location = $Wp_rem_Locations->get_element_property_location($property_id, $property_location_options);

                    $wp_rem_property_username = get_post_meta($property_id, 'wp_rem_property_username', true);
                    $wp_rem_property_is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);
                    $wp_rem_profile_image = $wp_rem_member_profile->member_get_profile_image($wp_rem_property_username);
                    $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                    $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                    $wp_rem_property_posted = get_post_meta($property_id, 'wp_rem_property_posted', true);
                    $wp_rem_property_posted = wp_rem_time_elapsed_string($wp_rem_property_posted);
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
                        $wp_rem_property_price = wp_rem_property_price( $property_id );
                    } else if ( $wp_rem_property_price_options == 'on-call' ) {
                        $wp_rem_property_price = wp_rem_plugin_text_srt('wp_rem_properties_price_on_request');
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
                    ?>
                    <div class="<?php echo esc_html($columns_class); ?>">
                        <div class="<?php echo esc_html($main_class); ?> <?php echo esc_html( $pro_is_compare ); ?>">
                            <div class="img-holder">
                                <figure>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        if ( function_exists('property_gallery_first_image') ) {
                                            $gallery_image_args = array(
                                                'property_id' => $property_id,
                                                'size' => 'full',
                                                'class' => 'img-list',
                                                'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg')
                                            );
                                            echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
                                        }
                                        ?>
                                    </a>
                                    <figcaption>
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
                                        ?>
                                    </figcaption>
                                </figure>
                            </div>

                            <div class="text-holder">
                                <?php if ( $wp_rem_property_type_price_switch == 'on' && $wp_rem_property_price != '') { ?>
                                    <span class="property-price">
                                        <span class="new-price text-color">
                                            <?php
                                            if ( $wp_rem_property_price_options == 'on-call' ) {
                                                echo force_balance_tags($wp_rem_property_price);
                                            } else {
                                                echo $wp_rem_property_price;
                                            }
                                            ?>
                                        </span>
                                    </span>
                                    <?php
                                }
                                if ( $wp_rem_cate_str != '' || $wp_rem_property_is_featured == 'on' ) {
                                    ?>
                                    <div class="post-category-options">
                                        <ul>
                                            <?php if ( $wp_rem_property_is_featured == 'on' ) { ?>
                                                <li class="featured-property">
                                                    <span class="bgcolor"><?php echo wp_rem_plugin_text_srt('wp_rem_property_featrd'); ?></span>
                                                </li>
                                                <?php
                                            }
                                            if ( $wp_rem_cate_str != '' ) {
                                                ?>
                                                <li><a href="javascript:void(0);"><?php echo ($wp_rem_cate_str); ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php } ?>
                                <?php if ( $wp_rem_profile_image != '' ) {
                                    ?>
                                    <div class="post-meta">
                                        <div class="post-by">
                                            <figure>
                                                <img src="<?php echo esc_url($wp_rem_profile_image); ?>" alt="" width="41" height="41">
                                            </figure>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="post-title">
                                    <h4><a href="<?php echo esc_url(get_permalink($property_id)); ?>"><?php echo esc_html(get_the_title($property_id)); ?></a></h4>
                                    <?php if ( $wp_rem_property_is_featured == 'on' ) { ?><div class="feature-check"><i class="icon-check2"></i></div><?php } ?>
                                </div>
                                <div class="post-time">
                                    <i class="icon-clock3"></i><span><?php echo esc_html($wp_rem_property_posted); ?></span>
                                </div>
                                <?php
                                $ratings_data = array(
                                    'overall_rating' => 0.0,
                                    'count' => 0,
                                );
                                $ratings_data = apply_filters('reviews_ratings_data', $ratings_data, $property_id);
                                ?>
                                <?php if ( ! empty($get_property_location) ) { ?>
                                    <ul class="property-location">
                                        <li><i class="icon-location-pin2"></i><span><?php echo esc_html(implode(', ', $get_property_location)); ?></span></li>
                                    </ul>
                                    <?php
                                }
                                ?>
                                <p class="description"><?php echo wp_trim_words(get_the_content($property_id), $default_excerpt_length, ' ...'); ?></p>
                            </div>

                        </div>
                    </div>
                    <?php
                endwhile;
            }
            // end top categories
            if ( sizeof($properties_ads_array) > 0 && in_array(0, $properties_ads_array) && ($property_page == 1 || $property_page == '') ) {
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php do_action('wp_rem_random_ads', 'property_banner'); ?>
                </div>
                <?php
            }
            while ( $property_loop_obj->have_posts() ) : $property_loop_obj->the_post();
                global $post, $wp_rem_member_profile;
                $property_id = $post;
				$pro_is_compare = apply_filters('wp_rem_is_compare', $property_id, $compare_property_switch);

                $Wp_rem_Locations = new Wp_rem_Locations();
                $get_property_location = $Wp_rem_Locations->get_element_property_location($property_id, $property_location_options);

                $wp_rem_property_username = get_post_meta($property_id, 'wp_rem_property_username', true);
                $wp_rem_property_is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);
                $wp_rem_profile_image = $wp_rem_member_profile->member_get_profile_image($wp_rem_property_username);
                $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                $wp_rem_property_posted = get_post_meta($property_id, 'wp_rem_property_posted', true);
                $wp_rem_property_posted = wp_rem_time_elapsed_string($wp_rem_property_posted);
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
                     $wp_rem_property_price = wp_rem_property_price( $property_id );
                } else if ( $wp_rem_property_price_options == 'on-call' ) {
                    $wp_rem_property_price = wp_rem_plugin_text_srt('wp_rem_properties_price_on_request');
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
                ?>
                <div class="<?php echo esc_html($columns_class); ?>">
                    <div class="<?php echo esc_html($main_class); ?> <?php echo esc_html( $pro_is_compare ); ?>">
                        <div class="img-holder">
                            <figure>
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    if ( function_exists('property_gallery_first_image') ) {
                                        $gallery_image_args = array(
                                            'property_id' => $property_id,
                                            'size' => 'full',
                                            'class' => 'img-list',
                                            'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg')
                                        );
                                        echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
                                    }
                                    ?>
                                </a>
                                <figcaption>
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
                                    ?>
                                </figcaption>
                            </figure>
                        </div>

                        <div class="text-holder">
                            <?php if ( $wp_rem_property_type_price_switch == 'on' && $wp_rem_property_price != '' ) { ?>
                                <span class="property-price">
                                    <span class="new-price text-color">
                                        <?php
                                        if ( $wp_rem_property_price_options == 'on-call' ) {
                                            echo force_balance_tags($wp_rem_property_price);
                                        } else {
                                            echo $wp_rem_property_price;
                                        }
                                        ?>
                                    </span>
                                </span>
                                <?php
                            }
                            if ( $wp_rem_cate_str != '' || $wp_rem_property_is_featured == 'on' ) {
                                ?>
                                <div class="post-category-options">
                                    <ul>
                                        <?php if ( $wp_rem_property_is_featured == 'on' ) { ?>
                                            <li class="featured-property">
                                                <span class="bgcolor"><?php echo wp_rem_plugin_text_srt('wp_rem_property_featrd'); ?></span>
                                            </li>
                                            <?php
                                        }
                                        if ( $wp_rem_cate_str != '' ) {
                                            ?>
                                            <li><a href="javascript:void(0);"><?php echo ($wp_rem_cate_str); ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            <?php if ( $wp_rem_profile_image != '' ) {
                                ?>
                                <div class="post-meta">
                                    <div class="post-by">
                                        <figure>
                                            <img src="<?php echo esc_url($wp_rem_profile_image); ?>" alt="" width="41" height="41">
                                        </figure>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="post-title">
                                <h4><a href="<?php echo esc_url(get_permalink($property_id)); ?>"><?php echo esc_html(get_the_title($property_id)); ?></a></h4>
                                <?php if ( $wp_rem_property_is_featured == 'on' ) { ?><div class="feature-check"><i class="icon-check2"></i></div><?php } ?>
                            </div>
                            <div class="post-time">
                                <i class="icon-clock3"></i><span><?php echo esc_html($wp_rem_property_posted); ?></span>
                            </div>
                            <?php
                            $ratings_data = array(
                                'overall_rating' => 0.0,
                                'count' => 0,
                            );
                            $ratings_data = apply_filters('reviews_ratings_data', $ratings_data, $property_id);
                            ?>
                            <?php if ( ! empty($get_property_location) ) { ?>
                                <ul class="property-location">
                                    <li><i class="icon-location-pin2"></i><span><?php echo esc_html(implode(', ', $get_property_location)); ?></span></li>
                                </ul>
                                <?php
                            }
                            ?>
                            <p class="description"><?php echo wp_trim_words(get_the_content($property_id), $default_excerpt_length, ' ...'); ?></p>
                        </div>

                    </div>
                </div>
                <?php
                if ( sizeof($properties_ads_array) > 0 && in_array($counter, $properties_ads_array) ) {
                    ?>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php do_action('wp_rem_random_ads', 'property_banner'); ?>
                    </div>
                    <?php
                }
                $counter ++;
            endwhile;
            ?>
        </div>
    </div>
    <?php
} else {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-property-match-error"><h6><i class="icon-warning"></i><strong> ' . wp_rem_plugin_text_srt('wp_rem_property_slider_sorry') . '</strong>&nbsp; ' . wp_rem_plugin_text_srt('wp_rem_property_slider_doesn_match') . ' </h6></div>';
}