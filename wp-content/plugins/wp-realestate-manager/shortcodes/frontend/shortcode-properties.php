<?php
/**
 * File Type: Properties Shortcode Frontend
 */
if (!class_exists('Wp_rem_Shortcode_Properties_Frontend')) {

    class Wp_rem_Shortcode_Properties_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_properties';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array($this, 'wp_rem_properties_shortcode_callback'));
            add_action('wp_ajax_wp_rem_properties_content', array($this, 'wp_rem_properties_content'));
            add_action('wp_ajax_nopriv_wp_rem_properties_content', array($this, 'wp_rem_properties_content'));
            add_action('wp_ajax_wp_rem_property_view_switch', array($this, 'wp_rem_property_view_switch'), 11, 1);
            add_action('wp_ajax_nopriv_wp_rem_property_view_switch', array($this, 'wp_rem_property_view_switch'), 11, 1);
            add_action('wp_rem_property_pagination', array($this, 'wp_rem_property_pagination_callback'), 11, 1);
            add_action('wp_rem_draw_search_element', array($this, 'wp_rem_draw_search_element_callback'), 11, 1);
            add_filter('fetch_property_open_house', array($this, 'fetch_property_open_house_callback'), 11, 1);
        }

        /*
         * Shortcode View on Frontend
         */

        public function wp_rem_properties_shortcode_callback($atts, $content = "") {

            $property_short_counter = isset($atts['property_counter']) && $atts['property_counter'] != '' ? ( $atts['property_counter'] ) : rand(123, 9999); // for shortcode counter
            wp_enqueue_script('wp-rem-property-functions');
            wp_enqueue_script('wp-rem-bootstrap-slider');
            wp_enqueue_script('wp-rem-matchHeight-script');
            if (false === ( $property_view = wp_rem_get_transient_obj('wp_rem_property_view' . $property_short_counter) )) {
                $property_view = isset($atts['property_view']) ? $atts['property_view'] : '';
            }
            wp_rem_set_transient_obj('wp_rem_property_view' . $property_short_counter, $property_view);
            $property_map_counter = rand(10000000, 99999999);
            $element_property_footer = isset($atts['property_footer']) ? $atts['property_footer'] : '';
            $element_property_map_position = isset($atts['property_map_position']) ? $atts['property_map_position'] : '';
            ob_start();
            $page_element_size = isset($atts['wp_rem_properties_element_size']) ? $atts['wp_rem_properties_element_size'] : 100;
            if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
                echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
            }
            $map_change_class = '';
            if ($property_view == 'map') {
                if ($element_property_footer == 'yes') {
                    echo '<script>';
                    echo 'jQuery(document).ready(function () {'
                    . 'jQuery("footer#footer").hide();'
                    . '});';
                    echo '</script>';
                }
            }
            wp_reset_query();
			
			do_action('property_checks_enquire_lists_submit');
            ?> 
            <div class="wp-rem-property-content" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                <?php
                echo '<div class="dev-map-class-changer' . $map_change_class . '">'; // container for content area when top map on
                $page_url = get_permalink(get_the_ID());
                ?>
                <div id="Property-content-<?php echo esc_html($property_short_counter); ?>">
                    <?php
                    $property_arg = array(
                        'property_short_counter' => $property_short_counter,
                        'atts' => $atts,
                        'content' => $content,
                        'property_map_counter' => $property_map_counter,
                        'page_url' => $page_url,
                    );

                    $this->wp_rem_properties_content($property_arg);
                    ?>
                </div>
                <?php
                echo '</div>';
                ?>
            </div> 
            <?php
            $wp_rem_cs_inline_script = '
                jQuery(document).ready(function () {
                     jQuery("a.property-video-btn[rel^=\'prettyPhoto\']").prettyPhoto({animation_speed:"fast",slideshow:10000, hideflash: true,autoplay:true,autoplay_slideshow:false});
                    });';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
            if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
                echo '</div>';
            }
            $html = ob_get_clean();
            return $html;
        }

        public function wp_rem_properties_content($property_arg = '') {
            global $wpdb, $wp_rem_form_fields_frontend, $wp_rem_search_fields;

            wp_enqueue_script('wp-rem-prettyPhoto');
            wp_enqueue_style('wp-rem-prettyPhoto');
            wp_enqueue_script('wp-rem-matchHeight-script');
            // getting arg array from ajax

            $all_post_ids = array();

            $split_map = ( isset($_REQUEST['view_type']) && $_REQUEST['view_type'] == 'split_map' ) ? true : false;
            if (isset($_REQUEST['property_arg']) && $_REQUEST['property_arg']) {
                $property_arg = $_REQUEST['property_arg'];
                $property_arg = json_decode(str_replace('\"', '"', $property_arg));
                $property_arg = $this->toArray($property_arg);
            }
            if (isset($property_arg) && $property_arg != '' && !empty($property_arg)) {
                extract($property_arg);
            }

            $GLOBALS['wp_rem_split_map_shortcode_atts'] = @$atts;

            $default_date_time_formate = 'd-m-Y H:i:s';
            // getting if user set it with his choice
            if (false === ( $property_view = wp_rem_get_transient_obj('wp_rem_property_view' . $property_short_counter) )) {
                $property_view = isset($atts['property_view']) ? $atts['property_view'] : '';
            }
            ?> 
            <script>
                var view = '<?php echo esc_html($property_view); ?>';
                if (view == 'map') {
                    jQuery('.wrapper').css('padding-top', '0');
                    if (jQuery('.dev-map-class-changer').length > 0)
                        jQuery('.dev-map-class-changer').addClass('property-map-holder');
                } else {
                    if (jQuery('.dev-map-class-changer').length > 0)
                        jQuery('.dev-map-class-changer').removeClass('property-map-holder');
                }
            </script>
            <?php
            $element_property_sort_by = isset($atts['property_sort_by']) ? $atts['property_sort_by'] : 'no';
            $element_property_topmap = ''; //isset( $atts['property_topmap'] ) ? $atts['property_topmap'] : 'no';
            $element_property_map_position = isset($atts['property_map_position']) ? $atts['property_map_position'] : 'full';
            $element_property_layout_switcher = isset($atts['property_layout_switcher']) ? $atts['property_layout_switcher'] : 'no';
            $element_property_layout_switcher_view = isset($atts['property_layout_switcher_view']) ? $atts['property_layout_switcher_view'] : 'grid';
            $element_property_map_height = isset($atts['property_map_height']) ? $atts['property_map_height'] : 400;
            $element_property_footer = isset($atts['property_footer']) ? $atts['property_footer'] : 'no';
            $element_property_search_keyword = isset($atts['property_search_keyword']) ? $atts['property_search_keyword'] : 'no';
            $element_property_top_category = isset($atts['property_top_category']) ? $atts['property_top_category'] : 'no';
            $element_property_top_category_count = isset($atts['property_top_category_count']) ? $atts['property_top_category_count'] : '5';
            $element_property_recent_switch = isset($atts['property_recent_switch']) ? $atts['property_recent_switch'] : 'no';
            $element_property_recent_count = isset($atts['property_recent_count']) ? $atts['property_recent_count'] : '5';
            $property_property_featured = isset($atts['property_featured']) ? $atts['property_featured'] : 'all';
            $property_type = isset($atts['property_type']) ? $atts['property_type'] : 'all';
            $property_hide_switch = isset($atts['property_hide_switch']) ? $atts['property_hide_switch'] : 'no';
            $search_box = isset($atts['search_box']) ? $atts['search_box'] : 'no';
            $posts_per_page = '-1';
            $pagination = 'no';
            $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '-1';
            $pagination = isset($atts['pagination']) ? $atts['pagination'] : 'no';
            $show_more_property_button_switch = isset($atts['show_more_property_button_switch']) ? $atts['show_more_property_button_switch'] : 'no';
            $show_more_property_button_url = isset($atts['show_more_property_button_url']) ? $atts['show_more_property_button_url'] : '';

            $filter_arr = array();
            $qryvar_sort_by_column = '';
            $element_filter_arr = array();
            $content_columns = 'col-lg-12 col-md-12 col-sm-12 col-xs-12'; // if filteration not true
            $paging_var = 'property_page';

            // Element fields in filter
            if (isset($_REQUEST['property_type']) && $_REQUEST['property_type'] != '') {
                $property_type = $_REQUEST['property_type'];
            }
            // $property_price = '';
            // if (isset($_REQUEST['property_price']) && $_REQUEST['property_price']) {
            //     $property_price = $_REQUEST['property_price'];
            // }

            // posted date check
            // $element_filter_arr[] = array(
            //     'key' => 'wp_rem_property_posted',
            //     'value' => strtotime(date($default_date_time_formate)),
            //     'compare' => '<=',
            // );

            // $element_filter_arr[] = array(
            //     'key' => 'wp_rem_property_expired',
            //     'value' => strtotime(date($default_date_time_formate)),
            //     'compare' => '>=',
            // );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_status',
                'value' => 'active',
                'compare' => '=',
            );
            // check if member not inactive
            $element_filter_arr[] = array(
                'key' => 'property_member_status',
                'value' => 'active',
                'compare' => '=',
            );

            if ($property_type != '' && $property_type != 'all') {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_type',
                    'value' => $property_type,
                    'compare' => '=',
                );
            }
            // if ($property_price != '' && $property_price != 'all') {
            //     $element_filter_arr[] = array(
            //         'key' => 'wp_rem_property_price',
            //         'value' => $property_price,
            //         'compare' => '=',
            //     );
            // }
			
			// price type
			if (isset($_REQUEST['price_type']) && $_REQUEST['price_type'] != '') {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_price_type',
                    'value' => $_REQUEST['price_type'],
                    'compare' => '=',
                );
            }

            // min price
			if (isset($_REQUEST['price_minimum']) && $_REQUEST['price_minimum'] != '') {
                // remove ">" sign and others non digital if present
                $_val = preg_replace("/[^0-9]/", "", $_REQUEST['price_minimum']);
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_price_ttd',
                    'value' => $_val,
                    'type'      => 'NUMERIC',
                    'compare' => '>=',
                );
            }

            // max price
            if (isset($_REQUEST['price_maximum']) && $_REQUEST['price_maximum'] != '' && strpos($_REQUEST['price_maximum'], '>') === false ) {
                // remove non digital signs
                $_val = preg_replace("/[^0-9]/", "", $_REQUEST['price_maximum']);
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_price_ttd',
                    'value' => $_val,
					'type'		=> 'NUMERIC',
                    'compare' => '<=',
                );
            }
			
            // If featured property.
            if ($property_property_featured == 'only-featured') {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_is_featured',
                    'value' => 'on',
                    'compare' => '=',
                );
            }

            if (!isset($_REQUEST[$paging_var])) {
                $_REQUEST[$paging_var] = '';
            }

            // Get all arguments from getting flters.
            $left_filter_arr = $this->get_filter_arg($property_type, $property_short_counter);

            $search_features_filter = $this->property_search_features_filter();
            if (!empty($search_features_filter)) {
                $left_filter_arr[] = $search_features_filter;
            }

            $post_ids = array();
            if (!empty($left_filter_arr)) {
                // apply all filters and get ids
                $post_ids = $this->get_property_id_by_filter($left_filter_arr);
            }

            if (isset($_REQUEST['location']) && $_REQUEST['location'] != '' && !isset($_REQUEST['loc_polygon_path'])) {
                $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : '';
                $post_ids = $this->property_location_filter($_REQUEST['location'], $post_ids);
                if (empty($post_ids)) {
                    $post_ids = array(0);
                }
            }

            $loc_polygon_path = '';
            if (isset($_REQUEST['loc_polygon_path']) && $_REQUEST['loc_polygon_path'] != '') {
                $loc_polygon_path = $_REQUEST['loc_polygon_path'];
            }
            $post_ids = $this->property_open_house_filter('', $post_ids);

            //$post_ids = $this->property_price_filter('', $post_ids);

            if (!empty($post_ids)) {
                $all_post_ids = $post_ids;
            }

            $search_title = isset($_REQUEST['search_title']) ? $_REQUEST['search_title'] : '';

            $args_count = array(
                'posts_per_page' => "1",
                'post_type' => 'properties',
                'post_status' => 'publish',
                's' => $search_title,
                'fields' => 'ids', // only load ids
                'meta_query' => array(
                    $element_filter_arr,
                ),
            );

            $property_sort_by = 'recent'; // default value
            $property_sort_order = 'desc';   // default value

            if (isset($_REQUEST['sort-by']) && $_REQUEST['sort-by'] != '') {
                $property_sort_by = $_REQUEST['sort-by'];
            }
            if ($property_sort_by == 'recent') {
                $qryvar_property_sort_type = 'DESC';
                $qryvar_sort_by_column = '';
            } elseif ($property_sort_by == 'alphabetical') {
                $qryvar_property_sort_type = 'ASC';
                $qryvar_sort_by_column = 'post_title';
            }
            $args = array(
                'posts_per_page' => $posts_per_page,
                'paged' => $_REQUEST[$paging_var],
                'post_type' => 'properties',
                'post_status' => 'publish',
                's' => $search_title,
                'order' => $qryvar_property_sort_type,
                'orderby' => $qryvar_sort_by_column,
                'fields' => 'ids', // only load ids
                'meta_query' => array(
                    $element_filter_arr,
                ),
            );

            if (isset($_REQUEST['property_category']) && $_REQUEST['property_category'] != '' && !isset($_REQUEST['advanced_search']) && !isset($_REQUEST['ajax_filter'])) {
                $args['tax_query'] = array(
                    array(
                        'taxonomy' => 'property-category',
                        'field' => 'slug',
                        'terms' => $_REQUEST['property_category']
                    )
                );
            }

            if ($element_property_top_category == 'yes') {
                $element_top_cate_filter_arr[] = array(
                    'key' => 'wp_rem_property_posted',
                    'value' => strtotime(date($default_date_time_formate)),
                    'compare' => '<=',
                );

                $element_top_cate_filter_arr[] = array(
                    'key' => 'wp_rem_property_expired',
                    'value' => strtotime(date($default_date_time_formate)),
                    'compare' => '>=',
                );

                $element_top_cate_filter_arr[] = array(
                    'key' => 'wp_rem_property_status',
                    'value' => 'active',
                    'compare' => '=',
                );
                $element_top_cate_filter_arr[] = array(
                    'key' => 'wp_rem_property_is_top_cat',
                    'value' => 'on',
                    'compare' => '=',
                );
                if ($property_type != '' && $property_type != 'all') {
                    $element_top_cate_filter_arr[] = array(
                        'key' => 'wp_rem_property_type',
                        'value' => $property_type,
                        'compare' => '=',
                    );
                }
                $property_type_category_name = 'wp_rem_property_category';   // category_fieldname in db and request
                if (isset($_REQUEST[$property_type_category_name]) && $_REQUEST[$property_type_category_name] != '') {
                    $dropdown_query_str_var_name = explode(",", $_REQUEST[$property_type_category_name]);
                    $cate_filter_multi_arr ['relation'] = 'OR';
                    foreach ($dropdown_query_str_var_name as $query_str_var_name_key) {
                        $cate_filter_multi_arr[] = array(
                            'key' => $property_type_category_name,
                            'value' => serialize($query_str_var_name_key),
                            'compare' => 'LIKE',
                        );
                    }
                    if (isset($cate_filter_multi_arr) && !empty($cate_filter_multi_arr)) {
                        $element_top_cate_filter_arr[] = array(
                            $cate_filter_multi_arr
                        );
                    }
                }
                $top_categries_args = array(
                    'posts_per_page' => $element_property_top_category_count,
                    'post_type' => 'properties',
                    'post_status' => 'publish',
                    'order' => $qryvar_property_sort_type,
                    'orderby' => $qryvar_sort_by_column,
                    'fields' => 'ids', // only load ids
                    'meta_query' => array(
                        $element_top_cate_filter_arr,
                    ),
                );
            }
            // query for recent property start
            $recent_property_args = '';
            if ($element_property_recent_switch == 'yes') {
                $element_recent_property_filter_arr[] = array(
                    'key' => 'wp_rem_property_posted',
                    'value' => strtotime(date($default_date_time_formate)),
                    'compare' => '<=',
                );

                $element_recent_property_filter_arr[] = array(
                    'key' => 'wp_rem_property_expired',
                    'value' => strtotime(date($default_date_time_formate)),
                    'compare' => '>=',
                );

                $element_recent_property_filter_arr[] = array(
                    'key' => 'wp_rem_property_status',
                    'value' => 'active',
                    'compare' => '=',
                );
                if ($property_type != '' && $property_type != 'all') {
                    $element_recent_property_filter_arr[] = array(
                        'key' => 'wp_rem_property_type',
                        'value' => $property_type,
                        'compare' => '=',
                    );
                }
                $property_type_category_name = 'wp_rem_property_category';   // category_fieldname in db and request
                if (isset($_REQUEST[$property_type_category_name]) && $_REQUEST[$property_type_category_name] != '') {
                    $dropdown_query_str_var_name = explode(",", $_REQUEST[$property_type_category_name]);
                    $cate_filter_multi_arr ['relation'] = 'OR';
                    foreach ($dropdown_query_str_var_name as $query_str_var_name_key) {
                        $cate_filter_multi_arr[] = array(
                            'key' => $property_type_category_name,
                            'value' => serialize($query_str_var_name_key),
                            'compare' => 'LIKE',
                        );
                    }
                    if (isset($cate_filter_multi_arr) && !empty($cate_filter_multi_arr)) {
                        $element_recent_property_filter_arr[] = array(
                            $cate_filter_multi_arr
                        );
                    }
                }

                $recent_property_args = array(
                    'posts_per_page' => $element_property_recent_count,
                    'post_type' => 'properties',
                    'post_status' => 'publish',
                    'order' => 'DESC',
                    'orderby' => 'post_date',
                    'fields' => 'ids', // only load ids
                    'meta_query' => array(
                        $element_recent_property_filter_arr,
                    ),
                );
            }

            if (isset($_REQUEST['loc_polygon_path']) && $_REQUEST['loc_polygon_path'] != '') {
                $loc_polygon_path = $_REQUEST['loc_polygon_path'];
                $all_post_ids = $this->property_polygon_filter($loc_polygon_path, $all_post_ids, $element_filter_arr);
            }

            // recent property query end

            if (!empty($all_post_ids)) {
                $args_count['post__in'] = $all_post_ids;
                $args['post__in'] = $all_post_ids;
            }
            ?>
            <script>
                jQuery(document).ready(function () {
                    jQuery("a.property-video-btn[rel^='prettyPhoto']").prettyPhoto({animation_speed: "fast", slideshow: 10000, hideflash: true, autoplay: true, autoplay_slideshow: false});
                    var _this_list_view = '<?php echo esc_html($property_view) ?>';
                    var _element_property_footer = '<?php echo esc_html($element_property_footer) ?>';
            <?php
            if (isset($_POST['action'])) {
                // temprary off
                ?>
                        if (_this_list_view == 'map') {
                            if (!jQuery('#wp-rem-property-map-<?php echo esc_html($property_map_counter) ?>').is(':visible')) {
                                jQuery('.dev-property-map-holder').css({
                                    display: 'block',
                                });
                                jQuery('.dev-map-class-changer').removeClass('map-<?php echo esc_html($element_property_map_position) ?>');
                                jQuery('.dev-map-class-changer').removeClass('property-map-holder');
                                jQuery('.dev-map-class-changer').addClass('map-<?php echo esc_html($element_property_map_position) ?>');
                                jQuery('.dev-map-class-changer').addClass('property-map-holder');

                                if (_element_property_footer == 'yes') {
                                    jQuery("footer#footer").hide();
                                }
                                // temprary comment
                                if (document.getElementById('wp-rem-top-map-holder').length > 0)
                                    document.getElementById('wp-rem-top-map-holder').style.display = "none";
                                // jQuery(window).load(); // temprarty off
                            }
                        } else {
                            if (jQuery('.dev-property-map-holder').length > 0) {
                                jQuery('.dev-property-map-holder').css({display: 'none', });
                            }
                            if (jQuery('.dev-map-class-changer').length > 0) {
                                jQuery('.dev-map-class-changer').removeClass('map-<?php echo esc_html($element_property_map_position) ?>');
                            }
                            if (_element_property_footer == 'yes') {
                                jQuery("footer#footer").show();
                            }
                            // temprary comment 
                            if (jQuery('#wp-rem-top-map-holder').length > 0) {
                                document.getElementById('wp-rem-top-map-holder').style.display = "block";
                            }
                            // jQuery(window).load(); // temprarty off
                        }

                <?php
            }
            ?>
                });
            </script>
            <?php
            // top categories
            $element_property_top_category = 'no';
            if ($element_property_top_category == 'yes') {
                $property_top_categries_loop_obj = wp_rem_get_cached_obj('property_result_cached_top_categries_loop_obj', $top_categries_args, 12, false, 'wp_query');
            }
            // arrange excluded ids for result
            if (isset($property_top_categries_loop_obj->posts) && is_array($property_top_categries_loop_obj->posts) && !empty($property_top_categries_loop_obj->posts)) {
                //$new_args['post__not_in'] = $property_top_categries_loop_obj->posts;

                if (!empty($all_post_ids)) {
                    $all_post_ids = array_diff($all_post_ids, $property_top_categries_loop_obj->posts);
                    $args['post__in'] = $all_post_ids;
                } else {
                    $args['post__not_in'] = $property_top_categries_loop_obj->posts;
                }
            }

            $property_loop_obj = wp_rem_get_cached_obj('property_result_cached_loop_obj1', $args, 12, false, 'wp_query');

            $property_totnum = $property_loop_obj->found_posts;
            // print '<pre>';
            // print_r($GLOBALS['wp_rem_split_map_shortcode_atts']);
            // print_r($args);
            // print '</pre>';
            ?>
            <form id="frm_property_arg<?php echo absint($property_short_counter); ?>">
                <div style="display:none" id='property_arg<?php echo absint($property_short_counter); ?>'><?php
                    echo json_encode($property_arg);
                    ?>
                </div>
                <?php
                echo '<div class="row">';
                if ($search_box == 'yes' && (isset($property_view) && $property_view != 'map')) {  // if sidebar on from element
                    set_query_var('property_type', $property_type);
                    set_query_var('property_short_counter', $property_short_counter);
                    set_query_var('property_arg', $property_arg);
                    set_query_var('args_count', $args_count);
                    set_query_var('atts', $atts);
                    set_query_var('property_totnum', $property_totnum);
                    set_query_var('page_url', $page_url);
                    set_query_var('property_loop_obj', $property_loop_obj);
                    wp_rem_get_template_part('property', 'leftfilters', 'properties');
                    $content_columns = 'col-lg-9 col-md-9 col-sm-12 col-xs-12';
                }
                ?> 
                <div class="<?php echo esc_html($content_columns); ?>">
                    <?php
                    if ($split_map == true) {
                        echo '<a href="javascript:;" class="split-map-toggler"><i class="icon-angle-double-right"></i></a>';
                    }
                    ?>
                    <div class="real-estate-property-content real-estate-dev-property-content" id="wp-rem-data-property-content-<?php echo esc_html($property_short_counter); ?>" data-id="<?php echo esc_html($property_short_counter); ?>">
                        <?php
                        $properties_title = isset($atts['properties_title']) ? $atts['properties_title'] : '';
                        $properties_subtitle = isset($atts['properties_subtitle']) ? $atts['properties_subtitle'] : '';
                        $properties_title_alignment = isset($atts['properties_title_alignment']) ? $atts['properties_title_alignment'] : '';
                        $property_element_seperator = isset($atts['property_element_seperator']) ? $atts['property_element_seperator'] : '';
                        if ($properties_title != '' || $properties_subtitle != '' || $show_more_property_button_switch == 'yes') {
                            ?>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="element-title <?php echo ($properties_title_alignment); ?>">
                                        <?php
                                        if ($properties_title != '' || $properties_subtitle != '') {
                                            if ($properties_title != '') {
                                                ?>
                                                <h2><?php echo esc_html($properties_title); ?></h2>
                                                <?php
                                            }
                                            if ($properties_subtitle != '') {
                                                ?>
                                                <p><?php echo esc_html($properties_subtitle); ?></p>
                                                <?php
                                            }
                                            if (isset($property_element_seperator) && $property_element_seperator == 'yes') {
                                                ?>
                                                <div class="separator-zigzag">
                                                    <figure><img src="<?php echo esc_url(wp_rem::plugin_url() . 'assets/frontend/images/zigzag-img1.png'); ?>" alt=""></figure>
                                                </div>
                                                <?php
                                            }
                                        }
                                        if ($show_more_property_button_switch == 'yes') {
                                            ?> 
                                            <a href="<?php echo esc_url($show_more_property_button_url) ?>" class="show-more-property"><?php echo wp_rem_plugin_text_srt('wp_rem_properties_show_more') ?></a>
                                        <?php }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        // only ajax request procced

                        if ((isset($property_view) && $property_view != 'map') && $property_totnum >= 1) {
                            // sorting fields
                            echo '<div class="slide-loader-holder">';
                            $this->property_search_sort_fields($atts, $property_sort_by, $property_short_counter, $property_view, $property_totnum);
                            echo '</div>';
                        }
                        // search keywords  
                        set_query_var('property_loop_obj', $property_loop_obj);
                        set_query_var('property_view', $property_view);
                        set_query_var('property_short_counter', $property_short_counter);
                        set_query_var('atts', $atts);
                        set_query_var('recent_property_args', $recent_property_args);
                        set_query_var('element_property_top_category', $element_property_top_category);
                        set_query_var('property_hide_switch', $property_hide_switch);                        
                        if ($element_property_top_category == 'yes') {
                            set_query_var('property_top_categries_loop_obj', $property_top_categries_loop_obj);
                        }
                        
                        if (isset($property_view) && $property_view == 'grid') {
                            wp_rem_get_template_part('property', 'grid', 'properties');
                        } elseif (isset($property_view) && $property_view == 'grid-medern') {
                            wp_rem_get_template_part('property', 'grid-modern', 'properties');
                        } elseif (isset($property_view) && $property_view == 'grid-classic') {
                            wp_rem_get_template_part('property', 'grid-classic', 'properties');
                        } elseif (isset($property_view) && $property_view == 'list') { // for grid and view 2
                            wp_rem_get_template_part('property', 'grid', 'properties');
                        } elseif (isset($property_view) && $property_view == 'list-modern') { // for grid and view 2
                            wp_rem_get_template_part('property', 'list-modern', 'properties');
                        } elseif (isset($property_view) && $property_view == 'list-classic') { // for grid and view 2
                            wp_rem_get_template_part('property', 'list-classic', 'properties');
                        } elseif (isset($property_view) && $property_view == 'grid-default') { // for grid and view 2
                            wp_rem_get_template_part('property', 'grid-default', 'properties');
                        } elseif (isset($property_view) && $property_view == 'grid-masnory') { // for grid and view 2
                            wp_rem_get_template_part('property', 'grid-masnory', 'properties');
                        }
                        wp_reset_postdata();
                        ?>
                    </div>
                    <?php
                    // apply paging
                    $paging_args = array('total_posts' => $property_totnum,
                        'posts_per_page' => $posts_per_page,
                        'paging_var' => $paging_var,
                        'show_pagination' => $pagination,
                        'property_short_counter' => $property_short_counter,
                        'split_map' => $split_map,
                    );
                    $this->wp_rem_property_pagination_callback($paging_args);
                    ?>
                </div>
                <?php
                echo '</div>';
                if (isset($element_property_topmap) && $element_property_topmap == 'yes') {
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                if ($loc_polygon_path != '') {
                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                            array(
                                'simple' => true,
                                'cust_id' => "loc_polygon_path",
                                'cust_name' => 'loc_polygon_path',
                                'std' => $loc_polygon_path,
                            )
                    );
                }
                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                        array(
                            'return' => false,
                            'cust_name' => '',
                            'classes' => 'property-counter',
                            'std' => $property_short_counter,
                        )
                );
                ?>
            </form>
            <script>
                if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
                    var config = {
                        '.chosen-select': {width: "100%"},
                        '.chosen-select-deselect': {allow_single_deselect: true},
                        '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%", search_contains: true},
                        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                        '.chosen-select-width': {width: "95%"}
                    };
                    for (var selector in config) {
                        jQuery(selector).chosen(config[selector]);
                    }
                }
                jQuery(document).ready(function () {
                    var Header_height = jQuery("header#header").height();
                    if (jQuery('.property-map-holder.map-right').length != '') {
                        jQuery("header#header").addClass("fixed-header");
                        jQuery(".property-map-holder.map-right .detail-map").addClass("fixed-item").css("padding-top", Header_height);
                        jQuery(".property-map-holder.map-right .detail-map-property").css("padding-top", Header_height);

                    } else {
                        jQuery(".property-map-holder.map-right .detail-map").removeClass("fixed-item").css("padding-top", "0");
                        jQuery("header#header").removeClass("fixed-header");
                        jQuery(".property-map-holder.map-right .detail-map-property").css("padding-top", "0");
                    }
                    if (jQuery('.property-map-holder.map-left').length != '') {
                        jQuery("header#header").addClass("fixed-header");
                        jQuery(".property-map-holder.map-left .detail-map").addClass("fixed-item").css("padding-top", Header_height);
                        jQuery(".property-map-holder.map-left .detail-map-property").css("padding-top", Header_height);

                    } else {
                        jQuery(".property-map-holder.map-left .detail-map").removeClass("fixed-item").css("padding-top", "0");
                        jQuery("header#header").removeClass("fixed-header");
                        jQuery(".property-map-holder.map-left .detail-map-property").css("padding-top", "0");
                    }
                });
            </script>

            <?php
            // only for ajax request
            if (isset($_REQUEST['action'])) {
                die();
            }
        }

        public function property_polygon_filter($polygon_pathstr, $post_ids, $custom_meta_array) {
            global $wpdb;
            if (empty($post_ids)) {
                $post_ids = wp_rem_get_query_whereclase_by_array($custom_meta_array);
            }
            $polygon_path = array();
            $polygon_path = explode('||', $polygon_pathstr);
            if (count($polygon_path) > 0) {
                array_walk($polygon_path, function(&$val) {
                    $val = explode(',', $val);
                });
            }
            $new_post_ids = array();
            $th_counter = 0;
            foreach ($post_ids as $property_id) {
                $qry = "SELECT meta_value FROM $wpdb->postmeta WHERE 1=1 AND post_id='" . $property_id . "' AND meta_key='wp_rem_post_loc_latitude_property'";
                $property_latitude_arr = $wpdb->get_col($qry);
                $property_latitude = isset($property_latitude_arr[0]) ? $property_latitude_arr[0] : '';

                $qry = "SELECT meta_value FROM $wpdb->postmeta WHERE 1=1 AND post_id='" . $property_id . "' AND meta_key='wp_rem_post_loc_longitude_property'";
                $property_longitude_arr = $wpdb->get_col($qry);
                $property_longitude = isset($property_longitude_arr[0]) ? $property_longitude_arr[0] : '';

                if ($this->pointInPolygon(array($property_latitude, $property_longitude), $polygon_path)) {
                    $new_post_ids[] = $property_id;
                }
                if ($th_counter > 3000) {
                    break;
                }
                $th_counter++;
            }
            return $new_post_ids;
        }

        public function pointInPolygon($point, $polygon) {
            $return = false;
            foreach ($polygon as $k => $p) {
                if (!$k)
                    $k_prev = count($polygon) - 1;
                else
                    $k_prev = $k - 1;

                if (($p[1] < $point[1] && $polygon[$k_prev][1] >= $point[1] || $polygon[$k_prev][1] < $point[1] && $p[1] >= $point[1]) && ($p[0] <= $point[0] || $polygon[$k_prev][0] <= $point[0])) {
                    if ($p[0] + ($point[1] - $p[1]) / ($polygon[$k_prev][1] - $p[1]) * ($polygon[$k_prev][0] - $p[0]) < $point[0]) {
                        $return = !$return;
                    }
                }
            }
            return $return;
        }

        public function property_search_features_filter() {
            global $wp_rem_search_fields;
            $property_type_slug = $property_type_id = '';
            $features_filter = array();
            if (isset($_REQUEST['property_type']) && $_REQUEST['property_type']) {
                $property_type_slug = $_REQUEST['property_type'];
            }
            if ($property_type_slug != '') {
                $property_type_id = $wp_rem_search_fields->wp_rem_property_type_id_by_slug($property_type_slug);
            }
            if (isset($_REQUEST['features']) && $_REQUEST['features'] != '' && $property_type_id != '') {
                $features = $_REQUEST['features'];
                $features = explode(',', $features);
                $property_type_features = get_post_meta($property_type_id, 'feature_lables', true);
                $feature_icons = get_post_meta($property_type_id, 'wp_rem_feature_icon', true);
                $search_features = array();
                if (is_array($property_type_features) && sizeof($property_type_features) > 0) {
                    foreach ($property_type_features as $feat_key => $feature) {
                        if (isset($feature) && !empty($feature)) {
                            $feature_name = isset($feature) ? $feature : '';
                            $feature_icon = isset($feature_icons[$feat_key]) ? $feature_icons[$feat_key] : '';
                            if (in_array($feature_name, $features)) {

                                $search_features[] = $feature_name . '_icon' . $feature_icon;
                            }
                        }
                    }
                }
                if (is_array($search_features) && !empty($search_features)) {
                    $features_filter['relation'] = 'OR';
                    foreach ($search_features as $feature) {
                        $features_filter['meta_query'][] = array(
                            'key' => 'wp_rem_property_feature_list',
                            'value' => $feature,
                            'compare' => 'LIKE',
                            'type' => 'CHAR'
                        );
                    }
                }
            }
            return $features_filter;
        }

        public function get_filter_arg($property_type, $property_short_counter = '', $exclude_meta_key = '') {
            global $wp_rem_post_property_types;
            $filter_arr = array();

            //if (isset($_REQUEST['ajax_filter']) || isset($_REQUEST['advanced_search'])) {
            // if (isset($_REQUEST['advanced_search'])) {

            $property_type_category_name = 'wp_rem_property_category';   // category_fieldname in db and request
            if ($exclude_meta_key != $property_type_category_name) {
                if (isset($_REQUEST['property_category']) && $_REQUEST['property_category'] != '') {
                    $dropdown_query_str_var_name = explode(",", $_REQUEST['property_category']);

                    $count_cats = count($dropdown_query_str_var_name);

                    $cate_filter_multi_arr ['relation'] = 'OR';
                    $i = 1;
                    foreach ($dropdown_query_str_var_name as $query_str_var_name_key) {
                        if ($count_cats == $i) {
                            $cate_filter_multi_arr[] = array(
                                'key' => $property_type_category_name,
                                'value' => serialize($query_str_var_name_key),
                                'compare' => 'LIKE',
                            );
                        }
                        $i ++;
                    }
                    if (isset($cate_filter_multi_arr) && !empty($cate_filter_multi_arr)) {
                        $filter_arr[] = array(
                            $cate_filter_multi_arr
                        );
                    }
                }
            }
            if (isset($property_type) && $property_type != '' && $property_type != 'all') {
                $wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($property_type);
                $wp_rem_fields_output = '';
                if (is_array($wp_rem_property_type_cus_fields) && sizeof($wp_rem_property_type_cus_fields) > 0) {
                    $custom_field_flag = 1;
                    foreach ($wp_rem_property_type_cus_fields as $cus_fieldvar => $cus_field) {
                        if (isset($cus_field['enable_srch']) && $cus_field['enable_srch'] == 'yes') {
                            $query_str_var_name = $cus_field['meta_key'];
                            // only for date type field need to change field name
                            if ($exclude_meta_key != $query_str_var_name) {
                                if ($cus_field['type'] == 'date') {

                                    if ($cus_field['type'] == 'date') {

                                        $from_date = 'from' . $query_str_var_name;
                                        $to_date = 'to' . $query_str_var_name;
                                        if (isset($_REQUEST[$from_date]) && $_REQUEST[$from_date] != '') {
                                            $filter_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => strtotime($_REQUEST[$from_date]),
                                                'compare' => '>=',
                                            );
                                        }
                                        if (isset($_REQUEST[$to_date]) && $_REQUEST[$to_date] != '') {
                                            $filter_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => strtotime($_REQUEST[$to_date]),
                                                'compare' => '<=',
                                            );
                                        }
                                    }
                                } else if (isset($_REQUEST[$query_str_var_name]) && $_REQUEST[$query_str_var_name] != '') {

                                    if ($cus_field['type'] == 'dropdown') {
                                        if (isset($cus_field['multi']) && $cus_field['multi'] == 'yes') {
                                            $filter_multi_arr ['relation'] = 'OR';
                                            $dropdown_query_str_var_name = explode(",", $_REQUEST[$query_str_var_name]);
                                            foreach ($dropdown_query_str_var_name as $query_str_var_name_key) {
                                                if ($cus_field['post_multi'] == 'yes') {
                                                    $filter_multi_arr[] = array(
                                                        'key' => $query_str_var_name,
                                                        'value' => serialize($query_str_var_name_key),
                                                        'compare' => 'Like',
                                                    );
                                                } else {
                                                    $filter_multi_arr[] = array(
                                                        'key' => $query_str_var_name,
                                                        'value' => $query_str_var_name_key,
                                                        'compare' => '=',
                                                    );
                                                }
                                            }
                                            $filter_arr[] = array(
                                                $filter_multi_arr
                                            );
                                        } else {
                                            if ($cus_field['post_multi'] == 'yes') {

                                                $filter_arr[] = array(
                                                    'key' => $query_str_var_name,
                                                    'value' => serialize($_REQUEST[$query_str_var_name]),
                                                    'compare' => 'Like',
                                                );
                                            } else {
                                                $filter_arr[] = array(
                                                    'key' => $query_str_var_name,
                                                    'value' => $_REQUEST[$query_str_var_name],
                                                    'compare' => '=',
                                                );
                                            }
                                        }
                                    } elseif ($cus_field['type'] == 'text' || $cus_field['type'] == 'email' || $cus_field['type'] == 'url') {
                                        if ($_REQUEST[$query_str_var_name] != 0 && $_REQUEST[$query_str_var_name] != '') {
                                            $filter_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => $_REQUEST[$query_str_var_name],
                                                'compare' => 'LIKE',
                                            );
                                        }
                                    } elseif ($cus_field['type'] == 'number') {
                                        if ($_REQUEST[$query_str_var_name] != 0 && $_REQUEST[$query_str_var_name] != '') {
                                            $filter_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => $_REQUEST[$query_str_var_name],
                                                'compare' => '>=',
                                                'type' => 'numeric'
                                            );
                                        }
                                    } elseif ($cus_field['type'] == 'range') {
                                        $ranges_str_arr = explode(",", $_REQUEST[$query_str_var_name]);
                                        if (!isset($ranges_str_arr[1])) {
                                            $ranges_str_arr = explode(",", $ranges_str_arr[0]);
                                        }
                                        $range_first = $ranges_str_arr[0];
                                        $range_seond = $ranges_str_arr[1];
                                        $filter_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => $range_first,
                                            'compare' => '>=',
                                            'type' => 'numeric'
                                        );
                                        $filter_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => $range_seond,
                                            'compare' => '<=',
                                            'type' => 'numeric'
                                        );
                                    }
                                }
                            }
                        }
                        $custom_field_flag ++;
                    }
                }
            }
            // }
            return $filter_arr;
        }

        public function get_property_id_by_filter($left_filter_arr) {
            global $wpdb;
            $meta_post_ids_arr = '';
            $property_id_condition = '';
            if (isset($left_filter_arr) && !empty($left_filter_arr)) {
                $meta_post_ids_arr = wp_rem_get_query_whereclase_by_array($left_filter_arr);
                // if no result found in filtration 
                if (empty($meta_post_ids_arr)) {
                    $meta_post_ids_arr = array(0);
                }

                if (isset($_REQUEST['loc_polygon_path']) && $_REQUEST['loc_polygon_path'] != '' && $meta_post_ids_arr != '') {
                    $meta_post_ids_arr = $this->property_polygon_filter($_REQUEST['loc_polygon_path'], $meta_post_ids_arr);
                    if (empty($meta_post_ids_arr)) {
                        $meta_post_ids_arr = '';
                    }
                }
                $ids = $meta_post_ids_arr != '' ? implode(",", $meta_post_ids_arr) : '0';
                $property_id_condition = " ID in (" . $ids . ") AND ";
            }

            $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE " . $property_id_condition . " post_type='properties' AND post_status='publish'");

            if (empty($post_ids)) {
                $post_ids = array(0);
            }
            return $post_ids;
        }

        public function property_search_sort_fields($atts, $property_sort_by, $property_short_counter, $view = '', $property_totnum = '') {
            global $wp_rem_form_fields_frontend;

            $counter = isset($atts['property_counter']) && $atts['property_counter'] != '' ? $atts['property_counter'] : '';
            $transient_view = wp_rem_get_transient_obj('wp_rem_property_view' . $counter);
            $view = isset($transient_view) && $transient_view != '' ? $transient_view : $view;

            $view_type = '';
            $split_map = ( isset($_REQUEST['view_type']) && $_REQUEST['view_type'] == 'split_map' ) ? true : false;
            if ($split_map == true) {
                $view_type = 'split_map';
            }

            if (( isset($atts['property_sort_by']) && $atts['property_sort_by'] != 'no') || ( isset($atts['property_layout_switcher']) && $atts['property_layout_switcher'] != 'no' )) {
                ?>
                <div class="property-sorting-holder"><div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="all-results">
                                <h5><?php echo absint($property_totnum); ?> <?php echo wp_rem_plugin_text_srt('wp_rem_properties_properties_found'); ?></h5>
                            </div> 
                            <div class="user-location-filters">
                                <?php if (isset($atts['property_sort_by']) && $atts['property_sort_by'] != 'no') { ?>
                                    <span class="filter-title"><?php echo wp_rem_plugin_text_srt('wp_rem_properties_sort_by') ?>:</span>
                                    <div class="years-select-box">
                                        <div class="input-field">
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'std' => $property_sort_by,
                                                'id' => 'pagination',
                                                'classes' => 'chosen-select-no-single',
                                                'cust_name' => 'sort-by',
                                                'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\', \'' . $view_type . '\');"',
                                                'options' => array('alphabetical' => wp_rem_plugin_text_srt('wp_rem_member_members_alphabetical'), 'recent' => wp_rem_plugin_text_srt('wp_rem_member_members_recent')),
                                            );

                                            $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div> 
                                    <?php
                                }
                                if ($view != 'map') {
                                    $this->property_layout_switcher_fields($atts, $property_short_counter, $view = '');
                                }
                                ?>
                            </div> 
                        </div></div></div>
                <?php
            }
        }

        public function property_layout_switcher_fields($atts, $property_short_counter, $view = '', $frc_view = false) {

            $counter = isset($atts['property_counter']) && $atts['property_counter'] != '' ? $atts['property_counter'] : '';
            $transient_view = wp_rem_get_transient_obj('wp_rem_property_view' . $counter);

            if ($frc_view == true) {
                $view = $view;
            } else {
                if (false === ( $view = wp_rem_get_transient_obj('wp_rem_property_view' . $counter) )) {
                    $view = isset($atts['property_view']) ? $atts['property_view'] : '';
                }
            }
            if (( isset($atts['property_layout_switcher']) && $atts['property_layout_switcher'] != 'no')) {

                if (isset($atts['property_layout_switcher_view']) && !empty($atts['property_layout_switcher_view'])) {
                    $property_layout_switcher_views = array(
                        'grid' => 'Grid',
                        'map' => 'Map',
                        'simple' => 'Simple',
                    );
                    ?> 
                    <ul>
                        <?php
                        $element_property_layout_switcher_view = explode(',', $atts['property_layout_switcher_view']);

                        if (!empty($element_property_layout_switcher_view) && is_array($element_property_layout_switcher_view)) {
                            $views_counter = 0;
                            foreach ($element_property_layout_switcher_view as $single_layout_view) {
                                $case_for_list = $single_layout_view;
                                if ($single_layout_view == 'list') {
                                    $case_for_list = 'listed';
                                }
                                if ($single_layout_view == 'grid-medern') {
                                    $case_for_list = 'grid-medern';
                                }
                                switch ($case_for_list) {
                                    case 'grid':
                                        $icon = '<i class="icon-th-large"></i>';
                                        break;
                                    case 'listed':
                                        $icon = '<i class="icon-th-list"></i>';
                                        break;
                                    case 'grid-medern':
                                        $icon = '<i class="icon-th"></i>';
                                        break;
                                    case 'grid-classic':
                                        $icon = '<i class="icon-grid_on"></i>';
                                        break;
                                    case 'grid-default':
                                        $icon = '<i class="icon-menu4"></i>';
                                        break;
                                    case 'list-modern':
                                        $icon = '<i class="icon-list5"></i>';
                                        break;
                                    default:
                                        $icon = '<i class="icon-th-list"></i>';
                                }
                                if (empty($view) && $views_counter === 0) {
                                    ?>
                                    <li><a href="javascript:void(0);" class="active"><i class="icon-th-list"></i><?php echo esc_html($property_layout_switcher_views[$single_layout_view]); ?></a></li>
                                    <?php
                                } else {
                                    $view_type = '';
                                    $split_map = ( isset($_REQUEST['view_type']) && $_REQUEST['view_type'] == 'split_map' ) ? true : false;
                                    if ($split_map == true) {
                                        $view_type = 'split_map';
                                    }
                                    ?>
                                    <li><a href="javascript:void(0);" <?php if ($view == $single_layout_view) echo 'class="active"'; ?> <?php if ($view != $single_layout_view) { ?> onclick="wp_rem_property_view_switch('<?php echo esc_html($single_layout_view) ?>', '<?php echo esc_html($property_short_counter); ?>', '<?php echo esc_html($counter); ?>', '<?php echo esc_html($view_type); ?>');"<?php } ?>><?php echo force_balance_tags($icon); ?></a></li>
                                    <?php
                                }
                                $views_counter ++;
                            }
                        }
                        ?>
                    </ul>

                    <?php
                }
            }
        }

        public function wp_rem_property_view_switch() {
            $view = wp_rem_get_input('view', NULL, 'STRING');
            $property_short_counter = wp_rem_get_input('property_short_counter', NULL, 'STRING');
            wp_rem_set_transient_obj('wp_rem_property_view' . $property_short_counter, $view);
            echo 'success';
            wp_die();
        }

        public function property_location_filter($location_slug, $all_post_ids) {
            $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : '';
            // $search_type = isset($_REQUEST['search_type']) ? $_REQUEST['search_type'] : 'autocomplete';
            $search_type = 'autocomplete';
            $location_slug = sanitize_title($location_slug);

            if ($search_type == 'autocomplete' && $radius == 0) {

                if (isset($location_slug) && $location_slug != '') {
                    $location_condition_arr[] = array(
                        'relation' => 'OR',
                        array(
                            'key' => 'wp_rem_post_loc_country_property',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_state_property',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_city_property',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_town_property',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                        array(
                            'key' => 'wp_rem_post_loc_address_property',
                            'value' => $location_slug,
                            'compare' => 'LIKE',
                        ),
                    );

                    $args_count = array(
                        'posts_per_page' => "-1",
                        'post_type' => 'properties',
                        'post_status' => 'publish',
                        'fields' => 'ids', // only load ids
                        'meta_query' => array(
                            $location_condition_arr,
                        ),
                    );
                    if (!empty($all_post_ids)) {
                        $args_count['post__in'] = $all_post_ids;
                    }
                    $location_rslt = get_posts($args_count);
                }
            } else {
                $location_rslt = $this->property_geolocation_filter($_REQUEST['location'], $all_post_ids, $radius);
            }
            return $location_rslt;
        }

        public function property_open_house_filter($open_house = '', $all_post_ids) {

            $open_house_results = $all_post_ids;

            $open_house = ( isset($open_house) && $open_house != '' ) ? $open_house : '';
            if ($open_house == '') {
                $open_house = ( isset($_REQUEST['open_house']) && $_REQUEST['open_house'] != '' ) ? $_REQUEST['open_house'] : '';
            }

            if (isset($open_house) && $open_house != '') {

                $start_date = strtotime(date("Y/m/d") . " 00:00");
                $end_date = strtotime(date("Y/m/d") . " 23:59");

                $time = $open_house;

                if ($time == 'today') {
                    $start_date = strtotime(date("Y/m/d") . " 00:00");
                    $end_date = strtotime(date("Y/m/d") . " 23:59");
                }
                if ($time == 'tomorrow') {
                    $date = date("Y/m/d");
                    $date1 = str_replace('-', '/', $date);
                    $tomorrow = date('Y/m/d', strtotime($date1 . "+1 days"));
                    $start_date = strtotime($tomorrow . " 00:00");
                    $end_date = strtotime($tomorrow . " 23:59");
                }
                if ($time == 'through_weekend') {
                    $date = date("Y/m/d");
                    $date1 = str_replace('-', '/', $date);
                    $weekend = date('Y/m/d', strtotime($date1 . "next Sunday"));
                    $end_date = strtotime($weekend . " 23:59");
                }
                if ($time == 'weekend_only') {
                    $date = date("Y/m/d");
                    $date1 = str_replace('-', '/', $date);
                    $saturday = date('Y/m/d', strtotime($date1 . "next Saturday"));
                    $sunday = date('Y/m/d', strtotime($date1 . "next Sunday"));
                    if (date("l") == 'Saturday') {
                        $saturday = $date;
                    }
                    if (date("l") == 'Sunday') {
                        $saturday = date('Y/m/d', strtotime($date1 . "-1 days"));
                        $sunday = $date;
                    }
                    $start_date = strtotime($saturday . " 00:00");
                    $end_date = strtotime($sunday . " 23:59");
                }
                $filter_arr = array();
                $filter_arr[] = array(
                    'key' => 'wp_rem_transaction_property_open_house',
                    'value' => 'on',
                    'compare' => '=',
                );
                $filter_arr[] = array(
                    array(
                        'key' => 'open_house_start',
                        'value' => $start_date,
                        'compare' => '<=',
                        'type' => 'NUMERIC',
                    ),
                    array(
                        'key' => 'open_house_end',
                        'value' => $end_date,
                        'compare' => '>=',
                        'type' => 'NUMERIC',
                    ),
                );
                $args_count = array(
                    'posts_per_page' => "-1",
                    'post_type' => 'properties',
                    'post_status' => 'publish',
                    'fields' => 'ids', // only load ids
                    'meta_query' => array(
                        $filter_arr,
                    ),
                );
                if (!empty($all_post_ids)) {
                    $args_count['post__in'] = $all_post_ids;
                }
                $result1 = get_posts($args_count);

                $filter_arr = array();
                $filter_arr[] = array(
                    'key' => 'wp_rem_transaction_property_open_house',
                    'value' => 'on',
                    'compare' => '=',
                );
                $filter_arr[] = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'open_house_start',
                        'value' => array($start_date, $end_date),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC',
                    ),
                    array(
                        'key' => 'open_house_end',
                        'value' => array($start_date, $end_date),
                        'compare' => 'BETWEEN',
                        'type' => 'NUMERIC',
                    ),
                );
                $args_count = array(
                    'posts_per_page' => "-1",
                    'post_type' => 'properties',
                    'post_status' => 'publish',
                    'fields' => 'ids', // only load ids
                    'meta_query' => array(
                        $filter_arr,
                    ),
                );
                if (!empty($all_post_ids)) {
                    $args_count['post__in'] = $all_post_ids;
                }
//				if ($time == 'today') {
//					echo '<pre>'; print_r($args_count); echo '</pre>';
//				}
                $result2 = get_posts($args_count);
                $open_house_results = array_unique(array_merge($result1, $result2));
                if (empty($open_house_results)) {
                    $open_house_results = array(0);
                }
            }
            return $open_house_results;
        }

        /*
         * Property Price Search Filter
         */

        public function property_price_filter($open_house = '', $all_post_ids) {

            $results = $all_post_ids;

            $maximum_price = ( isset($_REQUEST['price_maximum']) && $_REQUEST['price_maximum'] != '' ) ? $_REQUEST['price_maximum'] : '';
            $minimum_price = ( isset($_REQUEST['price_minimum']) && $_REQUEST['price_minimum'] != '' ) ? $_REQUEST['price_minimum'] : '';
            $price_type = ( isset($_REQUEST['price_type']) && $_REQUEST['price_type'] != '' ) ? $_REQUEST['price_type'] : '';
            $filter_arr = array(
                'relation' => 'OR'
            );
            if ($minimum_price != '' && $minimum_price != 0) {
                $filter_arr[] = array(
                    'key' => 'wp_rem_property_price_num',
                    'value' => $minimum_price,
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                );
                $filter_arr[] = array(
                    'key' => 'wp_rem_property_price_ttd_num',
                    'value' => $minimum_price,
                    'compare' => '>=',
                    'type' => 'NUMERIC',
                );
            }
            if ($maximum_price != '' && $maximum_price != 0) {
                $filter_arr[] = array(
                    'key' => 'wp_rem_property_price_num',
                    'value' => $maximum_price,
                    'compare' => '<=',
                    'type' => 'NUMERIC',
                );
                $filter_arr[] = array(
                    'key' => 'wp_rem_property_price_ttd_num',
                    'value' => $maximum_price,
                    'compare' => '<=',
                    'type' => 'NUMERIC',
                );
            }

            if ($price_type != '') {
                $filter_arr[] = array(
                    'key' => 'wp_rem_price_type',
                    'value' => $price_type,
                    'compare' => '=',
                );
            }

            if (!empty($filter_arr)) {
                $args_count = array(
                    'posts_per_page' => "-1",
                    'post_type' => 'properties',
                    'post_status' => 'publish',
                    'fields' => 'ids', // only load ids
                    'meta_query' => array(
                        $filter_arr,
                    ),
                );
                if (!empty($all_post_ids)) {
                    $args_count['post__in'] = $all_post_ids;
                }
                $results = get_posts($args_count);

                if (empty($results)) {
                    $results = array(0);
                }
            }
            return $results;
        }

        public function property_geolocation_filter($location_slug, $all_post_ids, $radius) {
            if (isset($location_slug) && $location_slug != '') {
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
                if ($radius > 0) {
                    $wp_rem_compare_type = 'DECIMAL(10,6)';
                }
                $location_condition_arr = array(
                    'relation' => 'OR',
                    array(
                        'key' => 'wp_rem_post_loc_latitude_property',
                        'value' => array($minLat, $maxLat),
                        'compare' => 'BETWEEN',
                        'type' => $wp_rem_compare_type
                    ),
                    array(
                        'key' => 'wp_rem_post_loc_longitude_property',
                        'value' => array($minLong, $maxLong),
                        'compare' => 'BETWEEN',
                        'type' => $wp_rem_compare_type
                    ),
                );
                $args_count = array(
                    'posts_per_page' => "-1",
                    'post_type' => 'properties',
                    'post_status' => 'publish',
                    'fields' => 'ids', // only load ids
                    'meta_query' => array(
                        $location_condition_arr,
                    ),
                );
                if (!empty($all_post_ids)) {
                    $args_count['post__in'] = $all_post_ids;
                }
                $location_rslt = get_posts($args_count);
                return $location_rslt;
                $rslt = '';
            }
        }

        public function toArray($obj) {
            if (is_object($obj)) {
                $obj = (array) $obj;
            }
            if (is_array($obj)) {
                $new = array();
                foreach ($obj as $key => $val) {
                    $new[$key] = $this->toArray($val);
                }
            } else {
                $new = $obj;
            }

            return $new;
        }

        /*
         * property pagination
         */

        public function wp_rem_property_pagination_callback($args) {
            global $wp_rem_form_fields_frontend;
            $total_posts = '';
            $posts_per_page = '5';
            $paging_var = 'paged_id';
            $show_pagination = 'yes';
            $property_short_counter = '';
            extract($args);
            $view_type = '';
            $split_map = ( isset($_REQUEST['view_type']) && $_REQUEST['view_type'] == 'split_map' ) ? true : false;
            if ($split_map == true) {
                $view_type = 'split_map';
            }

            $ajax_filter = ( isset($_REQUEST['ajax_filter']) || isset($_REQUEST['search_type']) ) ? 'true' : 'false';

            if ($show_pagination <> 'yes') {
                return;
            } else if ($total_posts <= $posts_per_page) {
                return;
            } else {
                if (!isset($_REQUEST['page_id'])) {
                    $_REQUEST['page_id'] = '';
                }
                $html = '';
                $dot_pre = '';
                $dot_more = '';
                $total_page = 0;
                if ($total_posts <> 0)
                    $total_page = ceil($total_posts / $posts_per_page);
                $paged_id = 1;
                if (isset($_REQUEST[$paging_var]) && $_REQUEST[$paging_var] != '') {
                    $paged_id = $_REQUEST[$paging_var];
                }
                $loop_start = $paged_id - 2;

                $loop_end = $paged_id + 2;

                if ($paged_id < 3) {

                    $loop_start = 1;

                    if ($total_page < 5)
                        $loop_end = $total_page;
                    else
                        $loop_end = 5;
                }
                else if ($paged_id >= $total_page - 1) {

                    if ($total_page < 5)
                        $loop_start = 1;
                    else
                        $loop_start = $total_page - 4;

                    $loop_end = $total_page;
                }
                $html .= $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                        array(
                            'simple' => true,
                            'cust_id' => $paging_var . '-' . $property_short_counter,
                            'cust_name' => $paging_var,
                            'std' => '',
                            'extra_atr' => 'onchange="wp_rem_property_content(\'' . $property_short_counter . '\', \'' . $view_type . '\');"',
                        )
                );
                $html .= '<div class="page-nation"><ul class="pagination pagination-large">';
                if ($paged_id > 1) {
                    $html .= '<li><a onclick="wp_rem_property_pagenation_ajax(\'' . $paging_var . '\', \'' . ($paged_id - 1) . '\', \'' . ($property_short_counter) . '\', \'' . ($ajax_filter) . '\', \'' . ($view_type) . '\');" href="javascript:void(0);">';
                    $html .= wp_rem_plugin_text_srt('wp_rem_properties_prev') . '</a></li>';
                } else {
                    
                }

                if ($paged_id > 3 and $total_page > 5) {


                    $html .= '<li><a onclick="wp_rem_property_pagenation_ajax(\'' . $paging_var . '\', \'' . (1) . '\', \'' . ($property_short_counter) . '\', \'' . ($ajax_filter) . '\', \'' . ($view_type) . '\');" href="javascript:void(0);">';
                    $html .= '1</a></li>';
                }
                if ($paged_id > 4 and $total_page > 6) {
                    $html .= '<li class="disabled"><span><a>. . .</a></span><li>';
                }

                if ($total_page > 1) {

                    for ($i = $loop_start; $i <= $loop_end; $i ++) {

                        if ($i <> $paged_id) {

                            $html .= '<li><a onclick="wp_rem_property_pagenation_ajax(\'' . $paging_var . '\', \'' . ($i) . '\', \'' . ($property_short_counter) . '\', \'' . ($ajax_filter) . '\', \'' . ($view_type) . '\');" href="javascript:void(0);">';
                            $html .= $i . '</a></li>';
                        } else {
                            $html .= '<li class="active"><span><a class="page-numbers active">' . $i . '</a></span></li>';
                        }
                    }
                }
                if ($loop_end <> $total_page and $loop_end <> $total_page - 1) {
                    $html .= '<li><a>. . .</a></li>';
                }
                if ($loop_end <> $total_page) {
                    $html .= '<li><a onclick="wp_rem_property_pagenation_ajax(\'' . $paging_var . '\', \'' . ($total_page) . '\', \'' . ($property_short_counter) . '\', \'' . ($ajax_filter) . '\', \'' . ($view_type) . '\');" href="javascript:void(0);">';
                    $html .= $total_page . '</a></li>';
                }
                if ($total_posts > 0 and $paged_id < ($total_posts / $posts_per_page)) {
                    $html .= '<li><a onclick="wp_rem_property_pagenation_ajax(\'' . $paging_var . '\', \'' . ($paged_id + 1) . '\', \'' . ($property_short_counter) . '\', \'' . ($ajax_filter) . '\', \'' . ($view_type) . '\');" href="javascript:void(0);">';
                    $html .= wp_rem_plugin_text_srt('wp_rem_properties_next') . '</a></li>';
                } else {
                    
                }
                $html .= "</ul></div>";
                echo force_balance_tags($html);
            }
        }

        public function wp_rem_property_filter_categories($property_type, $category_request_val) {
            $wp_rem_property_type_category_array = '';
            $parent_cate_array = '';
            if ($category_request_val != '') {
                $category_request_val_arr = explode(",", $category_request_val);
                $category_request_val = isset($category_request_val_arr[0]) && $category_request_val_arr[0] != '' ? $category_request_val_arr[0] : '';
                $single_term = get_term_by('slug', $category_request_val, 'property-category');
                $single_term_id = isset($single_term->term_id) && $single_term->term_id != '' ? $single_term->term_id : '0';
                $parent_cate_array = $this->wp_rem_property_parent_categories($single_term_id);
            }
            $wp_rem_property_type_category_array = $this->wp_rem_property_categories_list($property_type, $parent_cate_array);
            return $wp_rem_property_type_category_array;
        }

        public function wp_rem_property_parent_categories($category_id) {
            $parent_cate_array = '';
            $category_obj = get_term_by('id', $category_id, 'property-category');
            if (isset($category_obj->parent) && $category_obj->parent != '0') {
                $parent_cate_array .= $this->wp_rem_property_parent_categories($category_obj->parent);
            }
            $parent_cate_array .= isset($category_obj->slug) ? $category_obj->slug . ',' : '';
            return $parent_cate_array;
        }

        public function wp_rem_property_categories_list($property_type, $parent_cate_string) {
            $cate_list_found = 0;
            $wp_rem_property_type_category_array = '';
            if ($parent_cate_string != '') {
                $category_request_val_arr = explode(",", $parent_cate_string);
                $count_arr = sizeof($category_request_val_arr);
                while ($count_arr >= 0) {
                    if (isset($category_request_val_arr[$count_arr]) && $category_request_val_arr[$count_arr] != '') {
                        if ($cate_list_found == 0) {
                            $single_term = get_term_by('slug', $category_request_val_arr[$count_arr], 'property-category');
                            $single_term_id = isset($single_term->term_id) && $single_term->term_id != '' ? $single_term->term_id : '0';
                            $wp_rem_category_array = get_terms('property-category', array(
                                'hide_empty' => false,
                                'parent' => $single_term_id,
                                    )
                            );
                            if (is_array($wp_rem_category_array) && sizeof($wp_rem_category_array) > 0) {
                                foreach ($wp_rem_category_array as $dir_tag) {
                                    $wp_rem_property_type_category_array['cate_list'][] = $dir_tag->slug;
                                }
                                $cate_list_found ++;
                            }
                        }if ($cate_list_found > 0) {
                            $wp_rem_property_type_category_array['parent_list'][] = $category_request_val_arr[$count_arr];
                        }
                    }
                    $count_arr --;
                }
            }

            if ($cate_list_found == 0 && $property_type != '') {
                $property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type", 'post_status' => 'publish', 'fields' => 'ids'));
                $property_type_post_id = isset($property_type_post[0]) ? $property_type_post[0] : 0;
                $wp_rem_property_type_category_array['cate_list'] = get_post_meta($property_type_post_id, 'wp_rem_property_type_cats', true);
            }
            return $wp_rem_property_type_category_array;
        }

        public function wp_rem_property_body_classes($classes) {
            $classes[] = 'property-with-full-map';
            return $classes;
        }

        public function wp_rem_property_map_coords_obj($property_ids) {
            $map_cords = array();

            if (is_array($property_ids) && sizeof($property_ids) > 0) {
                foreach ($property_ids as $property_id) {
                    global $wp_rem_member_profile;

                    $Wp_rem_Locations = new Wp_rem_Locations();
                    $property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                    $property_type_obj = get_page_by_path($property_type, OBJECT, 'property-type');
                    $property_type_id = isset($property_type_obj->ID) ? $property_type_obj->ID : '';
                    $property_location = $Wp_rem_Locations->get_location_by_property_id($property_id);
                    $wp_rem_property_username = get_post_meta($property_id, 'wp_rem_property_username', true);
                    $wp_rem_profile_image = $wp_rem_member_profile->member_get_profile_image($wp_rem_property_username);
                    $property_latitude = get_post_meta($property_id, 'wp_rem_post_loc_latitude_property', true);
                    $property_longitude = get_post_meta($property_id, 'wp_rem_post_loc_longitude_property', true);
                    $property_marker = get_post_meta($property_type_id, 'wp_rem_property_type_marker_image', true);

                    if ($property_marker != '') {
                        $property_marker = wp_get_attachment_url($property_marker);
                    } else {
                        $property_marker = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/map-marker.png');
                    }

                    $wp_rem_property_is_featured = get_post_meta($property_id, 'wp_rem_property_is_featured', true);

                    $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                    $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);

                    $wp_rem_property_type_price_switch = get_post_meta($property_type_id, 'wp_rem_property_type_price', true);
                    $wp_rem_user_reviews = get_post_meta($property_type_id, 'wp_rem_user_reviews', true);

                    // end checking review on in property type

                    $wp_rem_property_price = '';
                    if ($wp_rem_property_price_options == 'price') {
                        $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
                    } else if ($wp_rem_property_price_options == 'on-call') {
                        $wp_rem_property_price = wp_rem_plugin_text_srt('wp_rem_properties_price_on_request');
                    }

                    if (has_post_thumbnail()) {
                        $img_atr = array('class' => 'img-map-info');
                        $property_info_img = get_the_post_thumbnail($property_id, 'wp_rem_cs_media_5', $img_atr);
                    } else {
                        $no_image_url = esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg');
                        $property_info_img = '<img class="img-map-info" src="' . $no_image_url . '" />';
                    }

                    $property_info_price = '';
                    if ($wp_rem_property_type_price_switch == 'on' && $wp_rem_property_price != '') {
                        $property_info_price .= '
						<span class="property-price">
							<span class="new-price text-color">';

                        if ($wp_rem_property_price_options == 'on-call') {
                            $property_info_price .= $wp_rem_property_price;
                        } else {
                            $property_info_price .= wp_rem_property_price($property_id, $wp_rem_property_price, '<span class="guid-price">', '</span>');
                        }
                        $property_info_price .= '	
							</span>
						</span>';
                    }
                    $property_info_address = '';
                    if ($property_location != '') {
                        $property_info_address = '<span class="info-address">' . $property_location . '</span>';
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
                    do_action('wp_rem_favourites_frontend_button', $property_id, $book_mark_args, $figcaption_div);
                    $list_favourite = ob_get_clean();

                    $property_featured = '';
                    if ($wp_rem_property_is_featured == 'on') {
                        $property_featured .= '
						<div class="featured-property">
							<span class="bgcolor">' . wp_rem_plugin_text_srt('wp_rem_properties_featured') . '</span>
						</div>';
                    }

                    $property_member = $wp_rem_property_username != '' && get_the_title($wp_rem_property_username) != '' ? '<span class="info-member">' . sprintf(wp_rem_plugin_text_srt('wp_rem_properties_members'), get_the_title($wp_rem_property_username)) . '</span>' : '';

                    $ratings_data = array(
                        'overall_rating' => 0.0,
                        'count' => 0,
                    );
                    $ratings_data = apply_filters('reviews_ratings_data', $ratings_data, $property_id);

                    if ($property_latitude != '' && $property_longitude != '') {
                        $map_cords[] = array(
                            'lat' => $property_latitude,
                            'long' => $property_longitude,
                            'id' => $property_id,
                            'title' => get_the_title($property_id),
                            'link' => get_permalink($property_id),
                            'img' => $property_info_img,
                            'price' => $property_info_price,
                            'address' => $property_info_address,
                            'favourite' => $list_favourite,
                            'featured' => $property_featured,
                            'member' => $property_member,
                            'marker' => $property_marker,
                        );
                    }
                }
            }
            return $map_cords;
        }

        public function wp_rem_draw_search_element_callback($draw_on_map_url = '') {
            if ($draw_on_map_url != '') {
                ?>
                <div class="email-me-top">
                    <a href="<?php echo esc_url($draw_on_map_url); ?>" class="email-alert-btn draw-your-search-btn"><?php echo wp_rem_plugin_text_srt('wp_rem_properties_draw_search'); ?></a>
                </div>
                <?php
            }
        }

        public function fetch_property_open_house_callback($property_id) {
            $open_house_start = get_post_meta($property_id, 'open_house_start', true);
            $open_house_end = get_post_meta($property_id, 'open_house_end', true);
            $property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
            $property_type_obj = get_page_by_path($property_type, OBJECT, 'property-type');
            $property_type_id = isset($property_type_obj->ID) ? $property_type_obj->ID : '';
            $open_house_check = get_post_meta($property_type_id, 'wp_rem_property_type_open_house', true);
            $html = '';
            if ($open_house_start != '' && $open_house_end != '' && $open_house_check == 'on') {
                $date = date_i18n(get_option('date_format'), $open_house_start);
                $start_time = date_i18n("h:i a", $open_house_start);
                $end_time = date_i18n("h:i a", $open_house_end);

                $html = '<div class="opening-time">
                        <ul>
                                <li>
                                <span class="time-label">' . wp_rem_plugin_text_srt('wp_rem_properties_open_house') . '</span>
                                <small>' . $date . ' ' . $start_time . ' ' . wp_rem_plugin_text_srt('wp_rem_member_to') . ' ' . $end_time . '</small>
                            </li>
                        </ul>               
                    </div>';
            }
            return $html;
        }

        public function homevillas_duplicate_post_as_draft() {
            set_time_limit(0);
            global $wpdb;
            if (!( isset($_REQUEST['post']) && ( isset($_REQUEST['action']) && 'homevillas_duplicate_post_as_draft' == $_REQUEST['action'] ) )) {
                wp_die('No post to duplicate has been supplied!');
            }
            echo 'homevillas_duplicate_post_as_draft 3';
            $count = 1;
            /*
             * get the original post id
             */
            $post_id = (isset($_GET['post']) ? absint($_GET['post']) : absint($_POST['post']) );
            /*
             * and all the original post data then
             */
            $post = get_post($post_id);

            /*
             * if you don't want current user to be the new post author,
             * then change next couple of lines to this: $new_post_author = $post->post_author;
             */
            //$current_user = wp_get_current_user();
            //$new_post_author = $current_user->ID;

            /*
             * if post data exists, create the post duplicate
             */
            if (isset($post) && $post != null) {

                /*
                 * new post data array
                 */
                $args = array(
                    //'comment_status' => $post->comment_status,
                    //'ping_status' => $post->ping_status,
                    // 'post_author' => $new_post_author,
                    'post_content' => $post->post_content,
                    // 'post_excerpt' => $post->post_excerpt,
                    'post_name' => $post->post_name,
                    // 'post_parent' => $post->post_parent,
                    //  'post_password' => $post->post_password,
                    'post_status' => 'publish',
                    'post_title' => 'Dupplicate - ' . $count . $post->post_title,
                    'post_type' => $post->post_type,
                        //'to_ping' => $post->to_ping,
                        // 'menu_order' => $post->menu_order
                );

                /*
                 * insert the post by wp_insert_post() function
                 */
                $new_post_id = wp_insert_post($args);

                /*
                 * get all current post terms ad set them to the new post draft
                 */
//                $taxonomies = get_object_taxonomies($post->post_type); // returns array of taxonomy names for post type, ex array("category", "post_tag");
//                foreach ($taxonomies as $taxonomy) {
//                    $post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
//                    wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
//                }

                /*
                 * duplicate all post meta just in two SQL queries
                 */
                $post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
                if (count($post_meta_infos) != 0) {
                    $sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
                    foreach ($post_meta_infos as $meta_info) {
                        $meta_key = $meta_info->meta_key;
                        $meta_value = addslashes($meta_info->meta_value);
                        $sql_query_sel[] = "SELECT $new_post_id, '$meta_key', '$meta_value'";
                    }
                    $sql_query.= implode(" UNION ALL ", $sql_query_sel);
                    $wpdb->query($sql_query);
                }

                echo 'added ';
                /*
                 * finally, redirect to the edit post screen for the new draft
                 */
                exit;
            } else {
                wp_die('Post creation failed, could not find original post: ' . $post_id);
            }
        }

    }

    global $wp_rem_shortcode_properties_frontend;
    $wp_rem_shortcode_properties_frontend = new Wp_rem_Shortcode_Properties_Frontend();
}

function fetch_property_open_house_grid_view_callback($property_id) {
    $open_house_start = get_post_meta($property_id, 'open_house_start', true);
    $open_house_end = get_post_meta($property_id, 'open_house_end', true);

    $property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
    $property_type_obj = get_page_by_path($property_type, OBJECT, 'property-type');
    $property_type_id = isset($property_type_obj->ID) ? $property_type_obj->ID : '';

    $open_house_check = get_post_meta($property_type_id, 'wp_rem_property_type_open_house', true);
    $html = '';
    if ($open_house_start != '' && $open_house_end != '' && $open_house_check == 'on') {
        $date = date(get_option('date_format'), $open_house_start);
        $start_time = date("h:i a", $open_house_start);
        $end_time = date("h:i a", $open_house_end);
        $html = '<a href="#" class="open-house-info" data-placement="left" data-toggle="popover" data-trigger="hover" data-content="' . wp_rem_plugin_text_srt('wp_rem_properties_open_house') . '"></a>';
    }
    return $html;
}

function property_search_keywords($property_totnum, $element_property_search_keyword, $qrystr = '', $atts, $page_url = '') {
    if ($element_property_search_keyword != 'no' || ( isset($atts['property_alert_button']) && $atts['property_alert_button'] == 'enable')) {
        ?>
        <div class="search-options">
            <div class="all-results">
                <?php if ($element_property_search_keyword != 'no') { ?>
                    <h6><?php
                        $reset_var = 0;
                        if (isset($qrystr)) {
                            $qry_flag = 0;
                            foreach ($qrystr as $qry_var => $qry_val) {
                                if ('ajax_filter' == $qry_var || 'advanced_search' == $qry_var || 'property_arg' == $qry_var || 'action' == $qry_var || 'alert-frequency' == $qry_var || 'alerts-name' == $qry_var || 'loc_polygon' == $qry_var || 'alerts-email' == $qry_var || 'loc_polygon_path' == $qry_var)
                                    continue;
                                $qry_flag ++;
                                if ($qry_val != '') {
                                    $reset_var ++;
                                }
                            }
                        }
                        echo wp_rem_plugin_text_srt('wp_rem_properties_search_criteria');
                        ?></h6>
                    <?php if (isset($reset_var) && $reset_var > 0) { ?>
                        <a class="clear-tags reset-results" href="<?php echo esc_url($page_url); ?>"><i class=" icon-cross3"></i><?php wp_rem_plugin_text_srt('wp_rem_properties_reset'); ?></a>
                        <?php
                    }
                    ?>
                    <ul class="search-results">
                        <?php
                        //get all query string
                        if (isset($qrystr)) {
                            $flag = 1;
                            $qrystr = array_filter($qrystr);
                            foreach ($qrystr as $qry_var => $qry_val) {
                                if ('ajax_filter' == $qry_var || 'advanced_search' == $qry_var || 'property_arg' == $qry_var || 'action' == $qry_var || 'alert-frequency' == $qry_var || 'alerts-name' == $qry_var || 'loc_polygon' == $qry_var || 'alerts-email' == $qry_var || 'loc_polygon_path' == $qry_var)
                                    continue;

                                if ($qry_val != '') {
                                    $flag ++;
                                    echo '<li>';
                                    echo esc_html(ucwords(str_replace("-", " ", str_replace("+", " ", $qry_val))));
                                    if (count($qrystr) > $flag) {
                                        echo ', ';
                                    }
                                    echo '</li>';
                                }
                            }
                        }
                        ?>
                    </ul>
                <?php }
                ?>
            </div>
        </div>
        <?php
    }
}
