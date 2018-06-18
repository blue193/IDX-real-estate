<?php
/**
 * File Type: Members Shortcode Frontend
 */
if ( ! class_exists('Wp_rem_Shortcode_Members_Frontend') ) {

    class Wp_rem_Shortcode_Members_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_members';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array( $this, 'wp_rem_members_shortcode_callback' ));
            add_action('wp_ajax_wp_rem_members_content', array( $this, 'wp_rem_members_content' ));
            add_action('wp_ajax_nopriv_wp_rem_members_content', array( $this, 'wp_rem_members_content' ));
            add_action('wp_rem_member_pagination', array( $this, 'wp_rem_member_pagination_callback' ), 11, 1);
        }

        /*
         * Shortcode View on Frontend
         */

        public function wp_rem_members_shortcode_callback($atts, $content = "") {
            $member_short_counter = isset($atts['member_counter']) && $atts['member_counter'] != '' ? ( $atts['member_counter'] ) : rand(123, 9999); // for shortcode counter
            wp_enqueue_script('wp-rem-member-functions');

            if ( false === ( $member_view = wp_rem_get_transient_obj('wp_rem_member_view' . $member_short_counter) ) ) {
                $member_view = isset($atts['member_view']) ? $atts['member_view'] : '';
            }

            wp_rem_set_transient_obj('wp_rem_member_view' . $member_short_counter, $member_view);
            $member_map_counter = rand(10000000, 99999999);
            $map_change_class = '';
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wp-rem-member-content" id="wp-rem-member-content-<?php echo esc_html($member_short_counter); ?>">
                    <?php
                    $page_url = get_permalink(get_the_ID());
                    ?>
                    <div id="Member-content-<?php echo esc_html($member_short_counter); ?>">
                        <?php
                        $member_arg = array(
                            'member_short_counter' => $member_short_counter,
                            'atts' => $atts,
                            'content' => $content,
                            'member_map_counter' => $member_map_counter,
                            'page_url' => $page_url,
                        );

                        $this->wp_rem_members_content($member_arg);
                        ?>
                    </div>

                </div>   
            </div>   
            <?php
        }

        public function wp_rem_members_content($member_arg = '') {
            global $wpdb, $wp_rem_form_fields_frontend, $wp_rem_shortcode_properties_frontend;

            // getting arg array from ajax
            if ( isset($_REQUEST['member_arg']) && $_REQUEST['member_arg'] ) {
                $member_arg = $_REQUEST['member_arg'];
                $member_arg = json_decode(str_replace('\"', '"', $member_arg));
                $member_arg = $this->toArray($member_arg);
            }
            if ( isset($member_arg) && $member_arg != '' && ! empty($member_arg) ) {
                extract($member_arg);
            }
            $qryvar_member_sort_type = '';
            $member_property_sort_view = isset($atts['member_property_sort_view']) ? $atts['member_property_sort_view'] : '';
            
            $member_top_filter = isset($atts['member_top_filter']) ? $atts['member_top_filter'] : '';
            $member_featured_only = isset($atts['member_featured_only']) ? $atts['member_featured_only'] : '';

            $default_date_time_formate = 'd-m-Y H:i:s';
            // getting if user set it with his choice
            if ( false === ( $member_view = wp_rem_get_transient_obj('wp_rem_member_view' . $member_short_counter) ) ) {
                $member_view = isset($atts['member_view']) ? $atts['member_view'] : '';
            }
            $element_member_sort_by = isset($atts['member_sort_by']) ? $atts['member_sort_by'] : '';
            $element_member_layout_switcher = isset($atts['member_layout_switcher']) ? $atts['member_layout_switcher'] : 'no';

            $element_member_map_height = isset($atts['member_map_height']) ? $atts['member_map_height'] : 400;
            $element_member_search_keyword = isset($atts['member_search_keyword']) ? $atts['member_search_keyword'] : 'no';
            $member_member_featured = isset($atts['member_featured']) ? $atts['member_featured'] : 'all';
            $search_box = isset($atts['search_box']) ? $atts['search_box'] : 'no';
            $posts_per_page = '-1';
            $pagination = 'no';
            $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '-1';
            $pagination = isset($atts['pagination']) ? $atts['pagination'] : 'no';

            $filter_arr = '';
            $element_filter_arr = '';
            $paging_var = 'member_page';
            if ( ! isset($_REQUEST[$paging_var]) ) {
                $_REQUEST[$paging_var] = '';
            }
            $post_ids = '';
            $alphanumaric = '';
            if ( isset($_REQUEST['alphanumaric']) ) {

                $alphabatic_qrystr = '';
                $alphanumaric = $_REQUEST['alphanumaric'];
                if ( $alphanumaric != '' ) {
                    $keyword = 'a-z';
                    $comapare = ' NOT REGEXP ';
                    if ( $alphanumaric != "numeric" ) {
                        $keyword = $alphanumaric;
                        $comapare = ' REGEXP '; // only specific alphabets
                    }
                    $alphabatic_qrystr = " AND post_title " . $comapare . " '^[" . $keyword . "]' ";
                }
                $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE 1=1 " . $alphabatic_qrystr . "   AND post_type='members' AND post_status='publish'");
                if ( empty($post_ids) ) {
                    $post_ids = array( 0 );
                }
            }
            $search_title = isset($_REQUEST['search_title']) ? $_REQUEST['search_title'] : '';
            $sort_by = isset($_REQUEST['sort-by']) ? $_REQUEST['sort-by'] : '';
            $member_type = isset($_REQUEST['member_type']) ? $_REQUEST['member_type'] : '';
            $element_filter_arr[] = array(
                'key' => 'wp_rem_user_status',
                'value' => 'active',
                'compare' => '=',
            );

            if ( $member_featured_only == 'yes' ) {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_member_is_featured',
                    'value' => 'on',
                    'compare' => '=',
                );
            }

            if ( $member_property_sort_view != 'all' ) {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_member_profile_type',
                    'value' => $member_property_sort_view,
                    'compare' => '=',
                );
            }

            if ( $member_type <> '' ) {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_member_type',
                    'value' => $member_type,
                    'compare' => '=',
                );
            }

            if ( isset($sort_by) && $sort_by == 'featured-members' ) {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_member_is_featured',
                    'value' => 'on',
                    'compare' => '=',
                );
            }
            $qryvar_sort_by_column = '';
            $meta_key = '';
            if ( isset($sort_by) && $sort_by == 'num-of-properties' ) {
                $meta_key = 'wp_rem_num_of_properties';
                $qryvar_member_sort_type = 'DESC';
                $qryvar_sort_by_column = 'meta_value_num';
            }

            if ( isset($sort_by) && $sort_by == 'trusted-agencies' ) {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_member_profile_type',
                    'value' => 'company',
                    'compare' => '=',
                );
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_member_is_trusted',
                    'value' => 'on',
                    'compare' => '=',
                );
            }

            $member_sort_by = 'recent'; // default value
            $member_sort_order = 'desc';   // default value
            // if member view is alphabatic then sort by title
            if ( $member_view == 'alphabatic' ) {
                $member_sort_by = 'alphabetical';
            }

            if ( isset($_REQUEST['sort-by']) && $_REQUEST['sort-by'] != '' ) {
                $member_sort_by = $_REQUEST['sort-by'];
            }
            if ( $member_sort_by == 'recent' ) {
                $qryvar_member_sort_type = 'DESC';
                $qryvar_sort_by_column = 'post_date';
            } elseif ( $member_sort_by == 'alphabetical' ) {
                $qryvar_member_sort_type = 'ASC';
                $qryvar_sort_by_column = 'post_title';
            }
            if ( isset($_REQUEST['location']) && $_REQUEST['location'] != '' && ! isset($_REQUEST['loc_polygon_path']) ) {
                $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : '';
                $post_ids = $this->member_location_filter($_REQUEST['location'], $post_ids);
                if ( empty($post_ids) ) {
                    $post_ids = array( 0 );
                }
            }

            $all_post_ids = $post_ids;
            $args = array(
                'posts_per_page' => $posts_per_page,
                'paged' => $_REQUEST[$paging_var],
                'post_type' => 'members',
                'post_status' => 'publish',
                'order' => $qryvar_member_sort_type,
                'orderby' => $qryvar_sort_by_column,
                's' => $search_title,
                'meta_key' => $meta_key,
                'fields' => 'ids', // only load ids 
                'meta_query' => array(
                    $element_filter_arr,
                ),
            );
            if ( ! empty($all_post_ids) ) {

                $args['post__in'] = $all_post_ids;
            }

            $member_loop_obj = wp_rem_get_cached_obj('member_result_cached_loop_obj', $args, 12, false, 'wp_query');
            $member_totnum = $member_loop_obj->found_posts;

            if ( isset($member_top_filter) && $member_top_filter == 'yes' ) {
                set_query_var('member_short_counter', $member_short_counter);
                set_query_var('wp_rem_member_type', $member_short_counter);
                wp_rem_get_template_part('member', 'filters', 'members');
            }
            ?>
            <form id="frm_member_arg<?php echo esc_html($member_short_counter); ?>">
                <div style="display:none" id='member_arg<?php echo esc_html($member_short_counter); ?>'><?php
                    echo json_encode($member_arg);
                    ?>
                </div>
                <div class="wp-rem-member-content wp-rem-dev-member-content" id="wp-rem-data-member-content-<?php echo esc_html($member_short_counter); ?>" data-id="<?php echo esc_html($member_short_counter); ?>">
                    <?php
                    $members_title = isset($atts['members_title']) ? $atts['members_title'] : '';
                    $wp_rem_element_title_color = isset($atts['wp_rem_element_title_color']) ? $atts['wp_rem_element_title_color'] : '';
                    $members_subtitle = isset($atts['members_subtitle']) ? $atts['members_subtitle'] : '';
                    $members_title_align = isset($atts['members_title_align']) ? $atts['members_title_align'] : '';
                    $wp_rem_element_structure = '';
                    $title_color_style = '';
                    if(isset($wp_rem_element_title_color) && !empty($wp_rem_element_title_color)){
                        $title_color_style  = ' style= "color:'.$wp_rem_element_title_color.' !important"';
                    }
                    if ( $member_view == 'grid-slider' ) {
                        ?>
                        <div class="element-title <?php echo $members_title_align ?>">
                            <h2 <?php echo ($title_color_style); ?>><?php echo esc_html($members_title); ?></h2>
                            <div class="pull-right">
                                <div class="button-next-member"><i class="icon-keyboard_arrow_left"></i></div>
                                <div class="button-prev-member"><i class="icon-keyboard_arrow_right"></i></div>
                            </div>
                        </div>
                        <?php
                    } else {
                        $wp_rem_element_structure = wp_rem_plugin_title_sub_align($members_title, $members_subtitle, $members_title_align,$title_color_style);
                    }
                    echo force_balance_tags($wp_rem_element_structure);
                    if ( $element_member_sort_by == 'yes' ) {
                        ?>
                        <div class="slide-loader-holder">
                            <div class="property-sorting-holder member-sorting slide-loader">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="all-results">
                                            <h5><?php echo absint($member_totnum); ?> <?php echo wp_rem_plugin_text_srt('wp_rem_member_members_found'); ?></h5>
                                        </div> 
                                        <?php $this->member_search_sort_fields($atts, $member_sort_by, $member_short_counter, $member_view); ?> 
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <?php
                    }
                    set_query_var('member_loop_obj', $member_loop_obj);
                    set_query_var('member_view', $member_view);
                    set_query_var('member_short_counter', $member_short_counter);
                    set_query_var('atts', $atts);
                    if ( isset($member_view) && $member_view == 'alphabatic' ) {
                        set_query_var('alphanumaric', $alphanumaric);
                        wp_rem_get_template_part('member', 'alphabatic', 'members');
                    } else if ( isset($member_view) && $member_view == 'list' ) {
                        wp_rem_get_template_part('member', 'list', 'members');
                    } else if ( isset($member_view) && $member_view == 'grid-slider' ) {

                        wp_rem_get_template_part('member', 'grid-slider', 'members');
                    } else { // for grid and view 2
                        wp_rem_get_template_part('member', 'grid', 'members');
                    }
                    wp_reset_postdata();
                    if ( $member_totnum > 0 && $posts_per_page > 0 && $member_totnum > $posts_per_page ) {
                        // apply paging
                        $paging_args = array( 'total_posts' => $member_totnum,
                            'posts_per_page' => $posts_per_page,
                            'paging_var' => $paging_var,
                            'show_pagination' => $pagination,
                            'member_short_counter' => $member_short_counter,
                        );
                        $this->wp_rem_member_pagination_callback($paging_args);
                    }
                    ?>
                </div>
            </form>
            <script>
                if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
                    var config = {
                        '.chosen-select': {width: "100%"},
                        '.chosen-select-deselect': {allow_single_deselect: true},
                        '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%", search_contains: true},
                        '.chosen-select-no-results': {no_results_text: '<?php echo wp_rem_plugin_text_srt('wp_rem_oops_nothing_found'); ?>'},
                        '.chosen-select-width': {width: "95%"}
                    };
                    for (var selector in config) {
                        jQuery(selector).chosen(config[selector]);
                    }
                }

            </script>
            <?php
            // only for ajax request
            if ( isset($_REQUEST['action']) ) {
                die();
            }
        }

        public function get_filter_arg($member_type, $member_short_counter = '') {
            global $wp_rem_post_member_types;
            $filter_arr = '';
            if ( isset($_REQUEST['ajax_filter']) ) {
                $member_type_category_name = 'wp_rem_member_category';   // category_fieldname in db and request
                if ( isset($_REQUEST[$member_type_category_name]) && $_REQUEST[$member_type_category_name] != '' ) {
                    $dropdown_query_str_var_name = explode(",", $_REQUEST[$member_type_category_name]);
                    $cate_filter_multi_arr ['relation'] = 'OR';
                    foreach ( $dropdown_query_str_var_name as $query_str_var_name_key ) {
                        $cate_filter_multi_arr[] = array(
                            'key' => $member_type_category_name,
                            'value' => serialize($query_str_var_name_key),
                            'compare' => 'LIKE',
                        );
                    }
                    if ( isset($cate_filter_multi_arr) && ! empty($cate_filter_multi_arr) ) {
                        $filter_arr[] = array(
                            $cate_filter_multi_arr
                        );
                    }
                }
            }
            return $filter_arr;
        }

        public function member_search_sort_fields($atts, $member_sort_by, $member_short_counter, $view = '') {
            global $wp_rem_form_fields_frontend;

            $counter = isset($atts['member_counter']) && $atts['member_counter'] != '' ? $atts['member_counter'] : '';
            $transient_view = wp_rem_get_transient_obj('wp_rem_member_view' . $counter);
            $view = isset($transient_view) && $transient_view != '' ? $transient_view : $view;

            if ( ( isset($atts['member_sort_by']) && $atts['member_sort_by'] != 'no') || ( isset($atts['member_layout_switcher']) && $atts['member_layout_switcher'] != 'no' ) ) {
                ?>
                <div class="user-location-filters">
                    <?php if ( isset($atts['member_sort_by']) && $atts['member_sort_by'] != 'no' ) { ?>
                        <div class="years-select-box">
                            <div class="input-field">
                                <?php
                                $wp_rem_opt_array = array(
                                    'std' => $member_sort_by,
                                    'id' => 'pagination',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'sort-by',
                                    'extra_atr' => 'onchange="wp_rem_member_content(\'' . $member_short_counter . '\');"',
                                    'options' => array(
                                        '' => wp_rem_plugin_text_srt('wp_rem_member_members_default_order'),
                                        'alphabetical' => wp_rem_plugin_text_srt('wp_rem_member_members_alphabetical'),
                                        'num-of-properties' => wp_rem_plugin_text_srt('wp_rem_member_members_no_of_properties'),
                                        'featured-members' => wp_rem_plugin_text_srt('wp_rem_member_members_featured'),
                                        'trusted-agencies' => wp_rem_plugin_text_srt('wp_rem_member_members_trusted_agencies'),
                                    ),
                                );

                                $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>               
                <?php
            }
        }

        public function member_location_filter($location_slug, $all_post_ids) {
            $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : '';
            $search_type = isset($_REQUEST['search_type']) ? $_REQUEST['search_type'] : 'autocomplete';

            if ( $search_type == 'autocomplete' && $radius == 0 ) {

                if ( isset($location_slug) && $location_slug != '' ) {
                    $location_condition_arr = array(
                        'relation' => 'OR',
                        array(
                            'key' => 'wp_rem_post_loc_country_member',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_state_member',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_city_member',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_town_member',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_address_member',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                    );

                    $args_count = array(
                        'posts_per_page' => "-1",
                        'post_type' => 'members',
                        'post_status' => 'publish',
                        'fields' => 'ids', // only load ids
                        'meta_query' => array(
                            $location_condition_arr,
                        ),
                    );
                    if ( ! empty($all_post_ids) ) {
                        $args_count['post__in'] = $all_post_ids;
                    }
                    $location_rslt = get_posts($args_count);
                }
            } else {
                $location_rslt = $this->member_geolocation_filter($_REQUEST['location'], $all_post_ids, $radius);
            }
            return $location_rslt;
        }

        public function member_geolocation_filter($location_slug, $all_post_ids, $radius) {
            if ( isset($location_slug) && $location_slug != '' ) {
                $Wp_rem_Locations = new Wp_rem_Locations();
                $location_response = $Wp_rem_Locations->wp_rem_get_geolocation_latlng_callback($location_slug);
                $lat = isset($location_response->lat) ? $location_response->lat : '';
                $lng = isset($location_response->lng) ? $location_response->lng : '';
                $radiusCheck = new RadiusCheck($lat, $lng, $radius);
                $minLat = $radiusCheck->MinLatitude();
                $maxLat = $radiusCheck->MaxLatitude();
                $minLong = $radiusCheck->MinLongitude();
                $maxLong = $radiusCheck->MaxLongitude();
                $wp_rem_compare_type = 'CHAR';
                if ( $radius > 0 ) {
                    $wp_rem_compare_type = 'DECIMAL(10,6)';
                }
                $location_condition_arr = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'wp_rem_post_loc_latitude_member',
                        'value' => array( $minLat, $maxLat ),
                        'compare' => 'BETWEEN',
                        'type' => $wp_rem_compare_type
                    ),
                    array(
                        'key' => 'wp_rem_post_loc_longitude_member',
                        'value' => array( $minLong, $maxLong ),
                        'compare' => 'BETWEEN',
                        'type' => $wp_rem_compare_type
                    ),
                );
                $args_count = array(
                    'posts_per_page' => "-1",
                    'post_type' => 'members',
                    'post_status' => 'publish',
                    'fields' => 'ids', // only load ids
                    'meta_query' =>
                    $location_condition_arr,
                );
                if ( ! empty($all_post_ids) ) {
                    $args_count['post__in'] = $all_post_ids;
                }
                $location_rslt = get_posts($args_count);
                return $location_rslt;
                $rslt = '';
            }
        }

        public function toArray($obj) {
            if ( is_object($obj) ) {
                $obj = (array) $obj;
            }
            if ( is_array($obj) ) {
                $new = array();
                foreach ( $obj as $key => $val ) {
                    $new[$key] = $this->toArray($val);
                }
            } else {
                $new = $obj;
            }

            return $new;
        }

        /*
         * member pagination
         */

        public function wp_rem_member_pagination_callback($args) {
            global $wp_rem_form_fields_frontend;
            $total_posts = '';
            $posts_per_page = '5';
            $paging_var = 'paged_id';
            $show_pagination = 'yes';
            $member_short_counter = '';

            extract($args);
            if ( $show_pagination <> 'yes' ) {
                return;
            } else if ( $total_posts < $posts_per_page ) {
                return;
            } else {
                if ( ! isset($_REQUEST['page_id']) ) {
                    $_REQUEST['page_id'] = '';
                }
                $html = '';
                $dot_pre = '';
                $dot_more = '';
                $total_page = 0;
                if ( $total_posts <> 0 )
                    $total_page = ceil($total_posts / $posts_per_page);
                $paged_id = 1;
                if ( isset($_REQUEST[$paging_var]) && $_REQUEST[$paging_var] != '' ) {
                    $paged_id = $_REQUEST[$paging_var];
                }
                $loop_start = $paged_id - 2;

                $loop_end = $paged_id + 2;

                if ( $paged_id < 3 ) {

                    $loop_start = 1;

                    if ( $total_page < 5 )
                        $loop_end = $total_page;
                    else
                        $loop_end = 5;
                }
                else if ( $paged_id >= $total_page - 1 ) {

                    if ( $total_page < 5 )
                        $loop_start = 1;
                    else
                        $loop_start = $total_page - 4;

                    $loop_end = $total_page;
                }
                $html .= $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                        array(
                            'simple' => true,
                            'cust_id' => $paging_var . '-' . $member_short_counter,
                            'cust_name' => $paging_var,
                            'std' => '',
                            'extra_atr' => 'onchange="wp_rem_member_content(\'' . $member_short_counter . '\');"',
                        )
                );
                $html .= '<div class="page-nation"><ul class="pagination pagination-large">';
                if ( $paged_id > 1 ) {
                    $html .= '<li><a onclick="wp_rem_member_pagenation_ajax(\'' . $paging_var . '\', \'' . ($paged_id - 1) . '\', \'' . ($member_short_counter) . '\');" href="javascript:void(0);">';
                    $html .= '' . wp_rem_plugin_text_srt('wp_rem_pagination_prev') . ' </a></li>';
                } else {
                    $html .= '<li class="disabled"><span>' . wp_rem_plugin_text_srt('wp_rem_pagination_prev') . '</span></li>';
                }

                if ( $paged_id > 3 and $total_page > 5 ) {

                    $html .= '<li><a onclick="wp_rem_member_pagenation_ajax(\'' . $paging_var . '\', \'' . (1) . '\', \'' . ($member_short_counter) . '\');" href="javascript:void(0);">';
                    $html .= '1</a></li>';
                }
                if ( $paged_id > 4 and $total_page > 6 ) {
                    $html .= '<li class="disabled"><span><a>. . .</a></span><li>';
                }

                if ( $total_page > 1 ) {

                    for ( $i = $loop_start; $i <= $loop_end; $i ++ ) {

                        if ( $i <> $paged_id ) {
                            $html .= '<li><a onclick="wp_rem_member_pagenation_ajax(\'' . $paging_var . '\', \'' . ($i) . '\', \'' . ($member_short_counter) . '\');" href="javascript:void(0);">';
                            $html .= $i . '</a></li>';
                        } else {
                            $html .= '<li class="active"><span><a class="page-numbers active">' . $i . '</a></span></li>';
                        }
                    }
                }
                if ( $loop_end <> $total_page and $loop_end <> $total_page - 1 ) {
                    $html .= '<li><a>. . .</a></li>';
                }
                if ( $loop_end <> $total_page ) {
                    $html .= '<li><a onclick="wp_rem_member_pagenation_ajax(\'' . $paging_var . '\', \'' . ($total_page) . '\', \'' . ($member_short_counter) . '\');" href="javascript:void(0);">';
                    $html .= $total_page . '</a></li>';
                }
                if ( $total_posts > 0 and $paged_id < ($total_posts / $posts_per_page) ) {
                    $html .= '<li><a onclick="wp_rem_member_pagenation_ajax(\'' . $paging_var . '\', \'' . ($paged_id + 1) . '\', \'' . ($member_short_counter) . '\');" href="javascript:void(0);">';
                    $html .= '' . wp_rem_plugin_text_srt('wp_rem_pagination_next') . '</a></li>';
                } else {
                    $html .= '<li class="disabled"><span>' . wp_rem_plugin_text_srt('wp_rem_pagination_next') . '</span></li> ';
                }
                $html .= "</ul></div>";
                echo force_balance_tags($html);
            }
        }

        public function wp_rem_member_filter_categories($member_type, $category_request_val) {
            $wp_rem_member_type_category_array = '';
            $parent_cate_array = '';
            if ( $category_request_val != '' ) {
                $category_request_val_arr = explode(",", $category_request_val);
                $category_request_val = isset($category_request_val_arr[0]) && $category_request_val_arr[0] != '' ? $category_request_val_arr[0] : '';
                $single_term = get_term_by('slug', $category_request_val, 'member-category');
                $single_term_id = isset($single_term->term_id) && $single_term->term_id != '' ? $single_term->term_id : '0';
                $parent_cate_array = $this->wp_rem_member_parent_categories($single_term_id);
            }
            $wp_rem_member_type_category_array = $this->wp_rem_member_categories_list($member_type, $parent_cate_array);
            return $wp_rem_member_type_category_array;
        }

        public function wp_rem_member_parent_categories($category_id) {

            $parent_cate_array = '';
            $category_obj = get_term_by('id', $category_id, 'member-category');
            if ( isset($category_obj->parent) && $category_obj->parent != '0' ) {
                $parent_cate_array .= $this->wp_rem_member_parent_categories($category_obj->parent);
            }
            $parent_cate_array .= isset($category_obj->slug) ? $category_obj->slug . ',' : '';
            return $parent_cate_array;
        }

        public function wp_rem_member_categories_list($member_type, $parent_cate_string) {
            $cate_list_found = 0;
            $wp_rem_member_type_category_array = '';
            if ( $parent_cate_string != '' ) {
                $category_request_val_arr = explode(",", $parent_cate_string);

                $count_arr = sizeof($category_request_val_arr);
                while ( $count_arr >= 0 ) {
                    if ( isset($category_request_val_arr[$count_arr]) && $category_request_val_arr[$count_arr] != '' ) {
                        if ( $cate_list_found == 0 ) {
                            $single_term = get_term_by('slug', $category_request_val_arr[$count_arr], 'member-category');
                            $single_term_id = isset($single_term->term_id) && $single_term->term_id != '' ? $single_term->term_id : '0';
                            $wp_rem_category_array = get_terms('member-category', array(
                                'hide_empty' => false,
                                'parent' => $single_term_id,
                                    )
                            );
                            if ( is_array($wp_rem_category_array) && sizeof($wp_rem_category_array) > 0 ) {
                                foreach ( $wp_rem_category_array as $dir_tag ) {
                                    $wp_rem_member_type_category_array['cate_list'][] = $dir_tag->slug;
                                }
                                $cate_list_found ++;
                            }
                        }if ( $cate_list_found > 0 ) {
                            $wp_rem_member_type_category_array['parent_list'][] = $category_request_val_arr[$count_arr];
                        }
                    }
                    $count_arr --;
                }
            }

            if ( $cate_list_found == 0 && $member_type != '' ) {
                $member_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'member-type', 'name' => "$member_type", 'post_status' => 'publish', 'fields' => 'ids' ));
                $member_type_post_id = isset($member_type_post[0]) ? $member_type_post[0] : 0;
                $wp_rem_member_type_category_array['cate_list'] = get_post_meta($member_type_post_id, 'wp_rem_member_type_cats', true);
            }
            return $wp_rem_member_type_category_array;
        }

        public function wp_rem_member_body_classes($classes) {
            $classes[] = 'member-with-full-map';
            return $classes;
        }

        public function wp_rem_member_map_coords_obj($member_ids) {
            $map_cords = array();

            if ( is_array($member_ids) && sizeof($member_ids) > 0 ) {
                foreach ( $member_ids as $member_id ) {
                    global $wp_rem_member_profile;

                    $Wp_rem_Locations = new Wp_rem_Locations();
                    $member_type = get_post_meta($member_id, 'wp_rem_member_type', true);
                    $member_type_obj = get_page_by_path($member_type, OBJECT, 'member-type');
                    $member_type_id = isset($member_type_obj->ID) ? $member_type_obj->ID : '';
                    $member_location = $Wp_rem_Locations->get_location_by_member_id($member_id);
                    $wp_rem_member_username = get_post_meta($member_id, 'wp_rem_member_username', true);
                    $wp_rem_profile_image = $wp_rem_member_profile->member_get_profile_image($wp_rem_member_username);
                    $member_latitude = get_post_meta($member_id, 'wp_rem_post_loc_latitude_member', true);
                    $member_longitude = get_post_meta($member_id, 'wp_rem_post_loc_longitude_member', true);
                    $member_marker = get_post_meta($member_type_id, 'wp_rem_member_type_marker_image', true);

                    if ( $member_marker != '' ) {
                        $member_marker = wp_get_attachment_url($member_marker);
                    } else {
                        $member_marker = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/map-marker.png');
                    }

                    $wp_rem_member_is_featured = get_post_meta($member_id, 'wp_rem_member_is_featured', true);

                    $wp_rem_member_price_options = get_post_meta($member_id, 'wp_rem_member_price_options', true);
                    $wp_rem_member_type = get_post_meta($member_id, 'wp_rem_member_type', true);
                    $wp_rem_transaction_member_reviews = get_post_meta($member_id, 'wp_rem_transaction_member_reviews', true);

                    $wp_rem_member_type_price_switch = get_post_meta($member_type_id, 'wp_rem_member_type_price', true);
                    $wp_rem_user_reviews = get_post_meta($member_type_id, 'wp_rem_user_reviews', true);

                    // end checking review on in member type

                    $wp_rem_member_price = '';
                    if ( $wp_rem_member_price_options == 'price' ) {
                        $wp_rem_member_price = get_post_meta($member_id, 'wp_rem_member_price', true);
                    } else if ( $wp_rem_member_price_options == 'on-call' ) {
                        $wp_rem_member_price = wp_rem_plugin_text_srt('wp_rem_nearby_properties_price_on_request');
                    }

                    if ( has_post_thumbnail() ) {
                        $img_atr = array( 'class' => 'img-map-info' );
                        $member_info_img = get_the_post_thumbnail($member_id, 'wp_rem_cs_media_5', $img_atr);
                    } else {
                        $no_image_url = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg');
                        $member_info_img = '<img class="img-map-info" src="' . $no_image_url . '" />';
                    }

                    $member_info_price = '';
                    if ( $wp_rem_member_type_price_switch == 'on' && $wp_rem_member_price != '' ) {
                        $member_info_price .= '
						<span class="member-price">
							<span class="new-price text-color">';

                        if ( $wp_rem_member_price_options == 'on-call' ) {
                            $member_info_price .= $wp_rem_member_price;
                        } else {
                            $member_info_price .= wp_rem_get_currency($wp_rem_member_price, true);
                        }
                        $member_info_price .= '	
							</span>
						</span>';
                    }
                    $member_info_address = '';
                    if ( $member_location != '' ) {
                        $member_info_address = '<span class="info-address">' . $member_location . '</span>';
                    }

                    ob_start();
                    $favourite_label = '';
                    $favourite_label = '';
                    $figcaption_div = true;
                    $book_mark_args = array(
                        'before_label' => $favourite_label,
                        'after_label' => $favourite_label,
                        'before_icon' => '<i class="icon-heart-o"></i>',
                        'after_icon' => '<i class="icon-heart5"></i>',
                    );
                    do_action('wp_rem_favourites_frontend_button', $member_id, $book_mark_args, $figcaption_div);
                    $list_favourite = ob_get_clean();

                    $member_featured = '';
                    if ( $wp_rem_member_is_featured == 'on' ) {
                        $member_featured .= '
						<div class="featured-member">
							<span class="bgcolor">' . wp_rem_plugin_text_srt('wp_rem_member_members_featured') . '</span>
						</div>';
                    }

                    $member_member = $wp_rem_member_username != '' && get_the_title($wp_rem_member_username) != '' ? '<span class="info-member">' . sprintf(wp_rem_plugin_text_srt('wp_rem_member_members_with_colan'), get_the_title($wp_rem_member_username)) . '</span>' : '';

                    $ratings_data = array(
                        'overall_rating' => 0.0,
                        'count' => 0,
                    );
                    $ratings_data = apply_filters('reviews_ratings_data', $ratings_data, $member_id);

                    $member_reviews = '';
                    if ( $wp_rem_transaction_member_reviews == 'on' && $wp_rem_user_reviews == 'on' && $ratings_data['count'] > 0 ) {
                        $member_reviews .= '
						<div class="post-rating">
							<div class="rating-holder">
								<div class="rating-star">
									<span class="rating-box" style="width: ' . $ratings_data['overall_rating'] . '%;"></span>
								</div>
								<span class="ratings"><span class="rating-text">(' . $ratings_data['count'] . ') ' . wp_rem_plugin_text_srt('wp_rem_list_meta_reviews') . '</span></span>
							</div>
						</div>';
                    }

                    if ( $member_latitude != '' && $member_longitude != '' ) {
                        $map_cords[] = array(
                            'lat' => $member_latitude,
                            'long' => $member_longitude,
                            'id' => $member_id,
                            'title' => get_the_title($member_id),
                            'link' => get_permalink($member_id),
                            'img' => $member_info_img,
                            'price' => $member_info_price,
                            'address' => $member_info_address,
                            'favourite' => $list_favourite,
                            'featured' => $member_featured,
                            'reviews' => $member_reviews,
                            'member' => $member_member,
                            'marker' => $member_marker,
                        );
                    }
                }
            }
            return $map_cords;
        }

    }

    global $wp_rem_shortcode_members_frontend;
    $wp_rem_shortcode_members_frontend = new Wp_rem_Shortcode_Members_Frontend();
}

