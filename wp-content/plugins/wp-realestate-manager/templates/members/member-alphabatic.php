<?php
/**
 * Properties Member search box
 *
 */
 
global $wp_rem_post_member_types, $wp_rem_form_fields_frontend;
if ( false === ( $member_view = wp_rem_get_transient_obj( 'wp_rem_member_view' . $member_short_counter ) ) ) {
    $member_view = isset( $atts['member_view'] ) ? $atts['member_view'] : '';
}
$search_box = isset( $atts['search_box'] ) ? $atts['search_box'] : '';
$main_class = 'member-medium';
// start ads script
$member_ads_switch = isset( $atts['member_ads_switch'] ) ? $atts['member_ads_switch'] : 'no';
if ( $member_ads_switch == 'yes' ) {
    $member_ads_after_list_series = isset( $atts['member_ads_after_list_count'] ) ? $atts['member_ads_after_list_count'] : '5';
    if ( $member_ads_after_list_series != '' ) {
        $member_ads_list_array = explode( ",", $member_ads_after_list_series );
    }
    $member_ads_after_list_array_count = sizeof( $member_ads_list_array );
    $member_ads_after_list_flag = 0;

    $i = 0;
    $array_i = 0;
    $member_ads_after_list_array_final = '';
    while ( $member_ads_after_list_array_count > $array_i ) {
        if ( isset( $member_ads_list_array[$array_i] ) && $member_ads_list_array[$array_i] != '' ) {
            $member_ads_after_list_array[$i] = $member_ads_list_array[$array_i];
            $i ++;
        }
        $array_i ++;
    }
    // new count 
    $member_ads_after_list_array_count = sizeof( $member_ads_after_list_array );
}


$member_page = isset( $_REQUEST['member_page'] ) ? $_REQUEST['member_page'] : '';
$posts_per_page = isset( $atts['posts_per_page'] ) ? $atts['posts_per_page'] : '';
$counter = 0;
if ( $member_page >= 2 ) {
    $counter = ( ($member_page - 1) * $posts_per_page );
}
$member_ads_number_counter = 1;
$member_ads_flag_counter = 0;
$member_ads_last_number = 0;
if ( isset( $member_ads_after_list_array ) && ! empty( $member_ads_after_list_array ) ) {
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



$columns_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
if ( $member_view == 'grid' ) {
    $columns_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
    if ( $search_box == 'yes' && $member_view != 'map' ) {
        $columns_class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12';
    }
    $main_class = 'member-grid';
}

$member_location_options = isset( $atts['member_location'] ) ? $atts['member_location'] : '';
if ( $member_location_options != '' ) {
    $member_location_options = explode( ',', $member_location_options );
}
?>
<div class="ajax-div">
    
        <div class="member-search-filter">
            <?php
             $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                    array(
                        'simple' => true,
                        'cust_id' => 'alphanumaric-' . $member_short_counter,
                        'cust_name' => 'alphanumaric',
                        'std' => $alphanumaric,
                        'extra_atr' => 'onchange="wp_rem_member_content(\'' . $member_short_counter . '\');"',
                    )
            );
            ?>
            <ul>
                <li><a onclick="wp_rem_member_alphanumaric_ajax('alphanumaric', '', '<?php echo esc_html( $member_short_counter ); ?>');" href="javascript:void(0);"><?php echo wp_rem_plugin_text_srt('wp_rem_options_all'); ?></a></li>
                <li><a onclick="wp_rem_member_alphanumaric_ajax('alphanumaric', 'numeric', '<?php echo esc_html( $member_short_counter ); ?>');" href="javascript:void(0);">#</a></li> 
                <?php
                $alphas_arr = range( 'A', 'Z' );
                foreach ( $alphas_arr as $char ) {
                    ?>
                    <li class="sorting-letter">
                        <?php
                        echo '<a onclick="wp_rem_member_alphanumaric_ajax(\'alphanumaric\', \'' . ($char) . '\', \'' . ($member_short_counter) . '\');" href="javascript:void(0)">
                        ' . $char . '</a>';
                        ?>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
      
        <div class="member-property member-alphabatic">
            <div class="row">
                <?php
                if ( $member_loop_obj->have_posts() ) {

                    if ( $member_ads_switch == 'yes' ) {
                        if ( $member_ads_after_list_array_count > 0 && ( $member_page == 1 || $member_page == '') ) {
                            if ( $counter == $member_ads_after_list_array[$member_ads_flag_counter] && $member_ads_after_list_array[$member_ads_flag_counter] == 0 ) {
                                ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="member-post">
                                        <?php do_action( 'wp_rem_random_ads', 'member_banner' ); ?>
                                    </div>
                                </div>
                                <?php
                                if ( $member_ads_flag_counter < $member_ads_after_list_array_count ) {
                                    $member_ads_flag_counter ++;
                                }
                            }
                        }
                    }
                    $flag = 0;
					$old_char = '';
                    while ( $member_loop_obj->have_posts() ) : $member_loop_obj->the_post();
                        $post_id = $post;
                        $member_image_id = get_post_meta( $post_id, 'wp_rem_profile_image', true );
                        $member_type_selected = get_post_meta( $post_id, 'wp_rem_member_profile_type', true );
                        $member_image = wp_get_attachment_url( $member_image_id ); 
                        $wp_rem_phone_number = get_post_meta( $post_id, 'wp_rem_phone_number', true );
                        $wp_rem_email_address = get_post_meta( $post_id, 'wp_rem_email_address', true );
                        $wp_rem_biography = get_post_meta( $post_id, 'wp_rem_biography', true );

                        $first_letter = substr( get_the_title(), 0, 1 );
                        $new_char = strtoupper( $first_letter );
                        if ( ! preg_match( '/[a-zA-Z]/', $new_char ) ) {
                            $new_char = "#";
                        }
                        if ( $new_char != $old_char ) {
                            if ( $flag != 0 ) {
                                echo ' </ul></div></div> <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="member-post"> ';
                            }

                            if ( $flag == 0 ) {
                                echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="member-post">';
                            }
                            ?>
                            <div class="search-title">
                                <span><?php echo esc_html($new_char); ?></span>
                            </div>
                            <?php
                            echo '<ul class="member" id="member' . $new_char . '">';
                        }

                        echo '<li>';
                        echo '<a href="' . esc_url( get_the_permalink() ) . '">' . get_the_title() . '</a>';
                        echo '</li>';
                        $old_char = $new_char;

                        $flag ++;
                        if ( $member_ads_switch == 'yes' ) {
                            if ( $member_ads_after_list_array_count > 0 ) {
                                $new_counter = $counter + 1;
                                $member_ads_value = $member_ads_after_list_array[$member_ads_flag_counter];
                                if ( $new_counter == $member_ads_after_list_array[$member_ads_flag_counter] ) {
                                    // end divs before ad started
                                    echo '</ul> </div></div> ';
                                    ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="member-post">
                                            <?php do_action( 'wp_rem_random_ads', 'member_banner' ); ?>
                                        </div>
                                    </div>
                                    <?php
                                    if ( $member_ads_flag_counter < ($member_ads_after_list_array_count - 1) ) {
                                        $member_ads_flag_counter ++;
                                    }
                                    // start divs after ad started
                                    echo ' <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="member-post"> ';
                                    echo '<ul class="member" id="member' . $new_char . '">';
                                } elseif ( $new_counter % $member_ads_value == 0 && $new_counter > $member_ads_last_number && $new_counter != 1 ) {
                                    // end divs before ad started
                                    echo '</ul> </div></div> ';
                                    ?><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="member-post">
                                            <?php do_action( 'wp_rem_random_ads', 'member_banner' ); ?>
                                        </div>
                                    </div>
                                    <?php
                                    // start divs after ad started
                                    echo ' <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="member-post"> ';
                                    echo '<ul class="member" id="member' . $new_char . '">';
                                }
                            }
                        }
                        $counter ++;

                    endwhile;
                    echo '</ul></div></div>';
                } else {
                    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-member-match-error"><h6><i class="icon-warning"></i><strong> ' . wp_rem_plugin_text_srt('wp_rem_member_sorry') . '</strong>&nbsp; ' . wp_rem_plugin_text_srt('wp_rem_member_no_results') . ' </h6></div>';
                }
                ?>
            </div>
        </div>
    
</div>
<!--Wp-rem Element End-->