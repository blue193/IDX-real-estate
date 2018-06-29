<?php
/**
 * File Type: Properties Shortcode Frontend
 */
if ( ! class_exists('Wp_rem_Shortcode_Properties_with_Categories_Frontend') ) {

    class Wp_rem_Shortcode_Properties_with_Categories_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_properties_with_categories';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array( $this, 'wp_rem_properties_shortcode_callback' ));
            add_action('wp_ajax_wp_rem_property_by_categories_filters_content', array( $this, 'wp_rem_properties_filters_content_callback' ));
            add_action('wp_ajax_nopriv_wp_rem_property_by_categories_filters_content', array( $this, 'wp_rem_properties_filters_content_callback' ));
            add_action('wp_rem_property_pagination', array( $this, 'wp_rem_property_pagination_callback' ), 11, 1);
        }

        /*
         * Shortcode View on Frontend
         */

        public function wp_rem_properties_shortcode_callback($atts, $content = "") {
            wp_enqueue_script('wp-rem-property-functions');
            wp_enqueue_script('jquery-mixitup');
            wp_enqueue_script('wp-rem-matchHeight-script');
            wp_enqueue_script('wp-rem-bootstrap-slider');
            $property_short_counter = rand(10000000, 99999999);
            $page_element_size = isset($atts['wp_rem_properties_element_size']) ? $atts['wp_rem_properties_element_size'] : 100;

            if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
                echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
            }
            ?>
            <div class="wp-rem-property-content" id="wp-rem-property-content-<?php echo esc_html($property_short_counter); ?>">
                <?php
                $property_arg = array(
                    'property_short_counter' => $property_short_counter,
                    'atts' => $atts,
                    'content' => $content,
                    'page_url' => get_permalink(get_the_ID()),
                );
                $this->wp_rem_properties_filters_content($property_arg);
                ?>
            </div>   
            <?php
            if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
                echo '</div>';
            }

            $wp_rem_cs_inline_script = 'jQuery(document).ready(function($) {
                var wrapHeight;
                wrapHeight=$(".real-estate-property .tab-content > .tab-pane.active").outerHeight();
                $(".real-estate-property").addClass("tabs-loaded");
                $(".real-estate-property.tabs-loaded .tab-content").height(wrapHeight);
                $(window).resize(function(){
                    wrapHeight=$(".real-estate-property .tab-content > .tab-pane.active").outerHeight();
                    $(".real-estate-property.tabs-loaded .tab-content").height(wrapHeight);
                });
                $(\'.real-estate-property a[data-toggle="tab"]\').on("shown.bs.tab", function (e) {
                   e.target
                   e.relatedTarget
                   var target=$(e.target).attr("href");
                   var prevTarget=$(e.relatedTarget).attr("href");
                   var wrapHeight=$(target).outerHeight();
                   $(".real-estate-property .tab-content").height(wrapHeight);
                   $(prevTarget).addClass("active-moment").find(".animated").removeClass("slideInUp").addClass("fadeOutDown");
                   $(target).find(".animated").addClass("slideInUp").removeClass("fadeOutDown");
                   setTimeout(function(){
                      $(prevTarget).removeClass("active-moment").find(".animated").removeClass("fadeOutDown");
                    }, 800);

                });
            });';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
        }

        public function wp_rem_properties_filters_content($property_arg = '') {
            global $wpdb, $wp_rem_form_fields_frontend, $wp_rem_search_fields;
            wp_enqueue_script('wp-rem-matchHeight-script');
            // getting arg array from ajax
            if ( isset($_REQUEST['property_arg']) && $_REQUEST['property_arg'] ) {
                $property_arg = $_REQUEST['property_arg'];
                $property_arg = json_decode(str_replace('\"', '"', $property_arg));
                $property_arg = $this->toArray($property_arg);
            }
            if ( isset($property_arg) && $property_arg != '' && ! empty($property_arg) ) {
                extract($property_arg);
            }

            $posts_per_page = '6';
            $pagination = 'no';
            $element_filter_arr = '';
            $content_columns = 'col-lg-12 col-md-12 col-sm-12 col-xs-12'; // if filteration not true
            $paging_var = 'paged_id';
            $default_date_time_formate = 'd-m-Y H:i:s';
            // element attributes
            $property_view = isset($atts['property_view']) ? $atts['property_view'] : '';
            $property_property_featured = isset($atts['property_featured']) ? $atts['property_featured'] : 'all';
            $property_type = isset($atts['property_type']) ? $atts['property_type'] : '';
            $property_category = isset($atts['property_category']) ? $atts['property_category'] : '';
            $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '6';
            $pagination = isset($atts['pagination']) ? $atts['pagination'] : 'no';

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_posted',
                'value' => strtotime(date($default_date_time_formate)),
                'compare' => '<=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_expired',
                'value' => strtotime(date($default_date_time_formate)),
                'compare' => '>=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_type',
                'value' => $property_type,
                'compare' => '=',
            );

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

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_is_featured',
                'value' => 'on',
                'compare' => '=',
            );

            $paged = isset($_REQUEST[$paging_var]) ? $_REQUEST[$paging_var] : 1;
            $args = array(
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'post_type' => 'properties',
                'post_status' => 'publish',
                'fields' => 'ids', // only load ids
                'orderby' => 'ID',
                'order' => 'DESC',
                'meta_query' => array(
                    $element_filter_arr,
                ),
            );

            //wp_rem_property_category


            $show_more_property = '';
            $tab_counter = rand(12345, 54321);
            ?>
            <div class="real-estate-property <?php echo esc_html($show_more_property); ?>">
                <?php
                $properties_title = isset($atts['properties_title']) ? $atts['properties_title'] : '';
                $properties_subtitle = isset($atts['properties_subtitle']) ? $atts['properties_subtitle'] : '';
                $properties_filters_alagnment = isset($atts['properties_filters_alagnment']) ? $atts['properties_filters_alagnment'] : '';
                $show_more_button = isset($atts['show_more_button']) ? $atts['show_more_button'] : '';
                $show_more_button_url = isset($atts['show_more_button_url']) ? $atts['show_more_button_url'] : '';
                ?>
                <div class="element-title <?php echo ($properties_filters_alagnment); ?>">
                    <?php if ( $properties_title != '' ) { ?>
                        <h2><?php echo esc_html($properties_title); ?></h2>
                    <?php } ?>
                    <?php if ( $properties_subtitle != '' ) { ?>
                        <p><?php echo esc_html($properties_subtitle); ?></p>
                    <?php } ?>
                    <?php
                    $filters_class = 'modern-filters';
                    ?>
                    <ul id="filters" class="clearfix <?php echo esc_html($filters_class); ?>">
                        <?php
                        if ( isset($property_category) && ! empty($property_category) ) {
                            $property_category = explode(',', $property_category);
                            $active_tab = 'first_active';
							$count = 1;
                            foreach ( $property_category as $category_slug ) {
                                $term_obj = get_term_by('slug', $category_slug, 'property-category');
                                if ( is_object($term_obj) ) {

                                    $current_tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : '';
                                    if ( isset($current_tab) && $current_tab == $category_slug ) {
                                        $active_tab = 'active';
                                    } else {
                                        if ( ! isset($_REQUEST['tab']) ) {
                                            if ( $active_tab == 'first_active' ) {
                                                $active_tab = 'active';
                                            }
                                        }
                                    }
                                    ?>
                                    <li class="<?php echo esc_attr($category_slug); ?> <?php echo esc_html($active_tab); ?>"><span class="filter"><a data-toggle="tab" href="#tab-<?php echo intval($tab_counter.$count); ?>"><?php echo esc_html($term_obj->name); ?></a></span></li>
                                    <?php
                                    $active_tab = '';
                                    $count++;
                                }
                            }
                        }
                        ?>
                    </ul>
                    <?php if ( $show_more_button == 'yes' && $show_more_button_url != '' && $property_view != 'grid-modern' ) { ?>
                        <a href="<?php echo esc_url($show_more_button_url); ?>" class="show-more-property "><?php echo wp_rem_plugin_text_srt('wp_rem_listfilter_showmore'); ?></a>
                    <?php } ?>
                </div>
                <?php $property_short_counter = rand(12345, 54321); ?>
                <div class="row">
                    <div class="<?php echo esc_html($content_columns); ?>">
                        <div class="tab-content clearfix">
                            <?php
                            if ( isset($property_category) && ! empty($property_category) ) {
                                $count = 1;
                                foreach ( $property_category as $category_slug ) {
                                    $property_short_counter = rand(12345, 54321);
                                    if ( is_object($term_obj) ) {
                                        $category_args = $args;
                                        $category_args['meta_query'][0][] = array(
                                            'key' => 'wp_rem_property_category',
                                            'value' => $category_slug,
                                            'compare' => 'LIKE',
                                        );

                                        $property_loop_obj = wp_rem_get_cached_obj('property_result_cached_loop_obj', $category_args, 12, false, 'wp_query');
                                        $property_found_count = $property_loop_obj->found_posts;

                                        $term_obj = get_term_by('slug', $category_slug, 'property-category');
                                        $current_tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : '';
                                        if ( ! isset($_REQUEST['tab']) ) {
                                            $active_class = ( $count == 1 ) ? 'active' : '';
                                        }
                                        if ( isset($current_tab) && $current_tab == $category_slug ) {
                                            $active_class = 'active';
                                        }
                                        ?>
                                        <div class="tab-pane in <?php echo esc_attr($active_class); ?>" id="tab-<?php echo intval($tab_counter.$count); ?>">
                                            <?php
                                            $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                                                    array(
                                                        'return' => false,
                                                        'cust_name'=>'',
                                                        'classes' => 'property-counter',
                                                        'std' => $property_short_counter,
                                                    )
                                            );
                                            ?>
                                            <div style="display:none" id='property_arg<?php echo absint($property_short_counter); ?>'>
                                                <?php $property_arg['property_short_counter'] = $property_short_counter; ?>
                                                <?php echo json_encode($property_arg); ?>
                                            </div>
                                            <div id="property-tab-content-<?php echo esc_attr($property_short_counter); ?>">
                                                <?php
                                                set_query_var('property_loop_obj', $property_loop_obj);
                                                set_query_var('property_short_counter', $property_short_counter);
                                                set_query_var('atts', $atts);
                                                wp_rem_get_template_part('property', 'filters-grid-modern', 'properties');
                                                // apply paging
                                                $paging_args = array(
                                                    'property_view' => $property_view,
                                                    'tab' => $category_slug,
                                                    'total_posts' => $property_found_count,
                                                    'posts_per_page' => $posts_per_page,
                                                    'paging_var' => $paging_var,
                                                    'show_pagination' => $pagination,
                                                    'property_short_counter' => $property_short_counter,
                                                );
                                                $this->wp_rem_property_pagination_callback($paging_args);
                                                ?>
                                            </div>
                                        </div>
                                        <?php wp_reset_postdata(); ?>
                                        <?php
                                        $count ++;
                                        $active_class = '';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        public function wp_rem_properties_filters_content_callback($property_arg = '') {
            global $wpdb, $wp_rem_form_fields_frontend, $wp_rem_search_fields;

            // getting arg array from ajax
            if ( isset($_REQUEST['property_arg']) && $_REQUEST['property_arg'] ) {
                $property_arg = $_REQUEST['property_arg'];
                $property_arg = json_decode(str_replace('\"', '"', $property_arg));
                $property_arg = $this->toArray($property_arg);
            }
            if ( isset($property_arg) && $property_arg != '' && ! empty($property_arg) ) {
                extract($property_arg);
            }

            $posts_per_page = '6';
            $pagination = 'no';
            $element_filter_arr = '';
            $content_columns = 'col-lg-12 col-md-12 col-sm-12 col-xs-12'; // if filteration not true
            $paging_var = 'paged_id';
            $default_date_time_formate = 'd-m-Y H:i:s';
            // element attributes
            $property_property_featured = isset($atts['property_featured']) ? $atts['property_featured'] : 'all';
            $property_type = isset($atts['property_type']) ? $atts['property_type'] : '';
            $posts_per_page = isset($atts['posts_per_page']) ? $atts['posts_per_page'] : '6';
            $pagination = isset($atts['pagination']) ? $atts['pagination'] : 'no';

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_posted',
                'value' => strtotime(date($default_date_time_formate)),
                'compare' => '<=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_expired',
                'value' => strtotime(date($default_date_time_formate)),
                'compare' => '>=',
            );

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_status',
                'value' => 'active',
                'compare' => '=',
            );


            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_type',
                'value' => $property_type,
                'compare' => '=',
            );
            if ( isset($_REQUEST['tab']) && $_REQUEST['tab'] != '' ) {
                $element_filter_arr[] = array(
                    'key' => 'wp_rem_property_category',
                    'value' => $_REQUEST['tab'],
                    'compare' => 'LIKE',
                );
            }

            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_is_featured',
                'value' => 'on',
                'compare' => '=',
            );


            $paged = isset($_REQUEST[$paging_var]) ? $_REQUEST[$paging_var] : 1;
            $args = array(
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'post_type' => 'properties',
                'post_status' => 'publish',
                'fields' => 'ids', // only load ids
                'orderby' => 'ID',
                'order' => 'DESC',
                'meta_query' => array(
                    $element_filter_arr,
                ),
            );

            $tab = isset($_REQUEST['tab']) ? $_REQUEST['tab'] : 'flats';
            $property_loop_obj = wp_rem_get_cached_obj('property_result_cached_loop_obj', $args, 12, false, 'wp_query');
            $property_found_count = $property_loop_obj->found_posts;
            set_query_var('property_loop_obj', $property_loop_obj);
            set_query_var('property_short_counter', $property_short_counter);
            set_query_var('atts', $atts);
            wp_rem_get_template_part('property', 'filters-grid', 'properties');
            // apply paging
            $paging_args = array(
                'tab' => $tab,
                'total_posts' => $property_found_count,
                'posts_per_page' => $posts_per_page,
                'paging_var' => $paging_var,
                'show_pagination' => $pagination,
                'property_short_counter' => $property_short_counter,
            );
            $this->wp_rem_property_pagination_callback($paging_args);
            wp_reset_postdata();
            wp_die();
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

        public function wp_rem_property_pagination_callback($args) {
            global $wp_rem_form_fields_frontend;
            $total_posts = '';
            $posts_per_page = '5';
            $paging_var = 'paged_id';
            $show_pagination = 'yes';
            $tab = 'for-sale';
            $property_short_counter = '';

            extract($args);
            if ( $show_pagination <> 'yes' ) {
                return;
            } else if ( $total_posts <= $posts_per_page ) {
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
                            'cust_id' => $paging_var . '-' . $property_short_counter,
                            'cust_name' => $paging_var,
                            'std' => '',
                            'extra_atr' => 'onchange="wp_rem_property_filters_content(\'' . $property_short_counter . '\');"',
                        )
                );
                $html .= '<div class="row"><div class="portfolio grid-fading animated col-lg-12 col-md-12 col-sm-12 col-xs-12 page-nation"><ul class="pagination pagination-large">';
                if ( $paged_id > 1 ) {
                    $html .= '<li><a onclick="wp_rem_property_by_category_filters_pagenation_ajax(\'' . $paging_var . '\', \'' . ($paged_id - 1) . '\', \'' . ($property_short_counter) . '\' , \'' . ($tab) . '\');" href="javascript:void(0);">';
                    $html .= wp_rem_plugin_text_srt('wp_rem_shortcode_filter_prev') . '</a></li>';
                }
                if ( $paged_id > 3 and $total_page > 5 ) {


                    $html .= '<li><a onclick="wp_rem_property_by_category_filters_pagenation_ajax(\'' . $paging_var . '\', \'' . (1) . '\', \'' . ($property_short_counter) . '\', \'' . ($tab) . '\');" href="javascript:void(0);">';
                    $html .= '1</a></li>';
                }
                if ( $paged_id > 4 and $total_page > 6 ) {
                    $html .= '<li class="disabled"><span><a>. . .</a></span><li>';
                }

                if ( $total_page > 1 ) {

                    for ( $i = $loop_start; $i <= $loop_end; $i ++ ) {

                        if ( $i <> $paged_id ) {

                            $html .= '<li><a onclick="wp_rem_property_by_category_filters_pagenation_ajax(\'' . $paging_var . '\', \'' . ($i) . '\', \'' . ($property_short_counter) . '\', \'' . ($tab) . '\');" href="javascript:void(0);">';
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
                    $html .= '<li><a onclick="wp_rem_property_by_category_filters_pagenation_ajax(\'' . $paging_var . '\', \'' . ($total_page) . '\', \'' . ($property_short_counter) . '\', \'' . ($tab) . '\');" href="javascript:void(0);">';
                    $html .= $total_page . '</a></li>';
                }
                if ( $total_posts > 0 and $paged_id < ($total_posts / $posts_per_page) ) {
                    $html .= '<li><a onclick="wp_rem_property_by_category_filters_pagenation_ajax(\'' . $paging_var . '\', \'' . ($paged_id + 1) . '\', \'' . ($property_short_counter) . '\', \'' . ($tab) . '\');" href="javascript:void(0);">';
                    $html .= wp_rem_plugin_text_srt('wp_rem_shortcode_filter_next') . '</a></li>';
                }
                $html .= "</ul></div></div>";
                echo force_balance_tags($html);
            }
        }

    }

    global $wp_rem_shortcode_properties_filters_frontend;
    $wp_rem_shortcode_properties_filters_frontend = new Wp_rem_Shortcode_Properties_with_Categories_Frontend();
}
    