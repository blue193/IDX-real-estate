<?php
/**
 * @Top Properties widget Class
 *
 *
 */
if (!class_exists('wp_rem_top_properties')) {

    class wp_rem_top_properties extends WP_Widget {
        /**
         * Outputs the content of the widget
         * @param array $args
         * @param array $instance
         */

        /**
         * @init User list Module
         */
        public function __construct() {

            parent::__construct(
                    'wp_rem_top_properties', // Base ID
                    wp_rem_plugin_text_srt('wp_rem_top_properties_widget'), // Name
                    array('classname' => 'widget_top_properties', 'description' => wp_rem_plugin_text_srt('wp_rem_top_properties_widget_desc'),) // Args
            );
        }

        /**
         * @User list html form
         */
        function form($instance) {
            global $wp_rem_html_fields;
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $title = $instance['title'];
            $showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_top_properties_title_field'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($title),
                    'id' => ($this->get_field_id('title')),
                    'classes' => '',
                    'cust_id' => ($this->get_field_name('title')),
                    'cust_name' => ($this->get_field_name('title')),
                    'return' => true,
                    'required' => false
                ),
            );
            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_top_properties_num_post'),
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($showcount),
                    'id' => wp_rem_cs_allow_special_char($this->get_field_id('showcount')),
                    'classes' => '',
                    'cust_id' => wp_rem_cs_allow_special_char($this->get_field_name('showcount')),
                    'cust_name' => wp_rem_cs_allow_special_char($this->get_field_name('showcount')),
                    'return' => true,
                    'required' => false
                ),
            );
            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
        }

        /**
         * @User list update data
         */
        function update($new_instance, $old_instance) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['showcount'] = esc_sql($new_instance['showcount']);
            return $instance;
        }

        /**
         * @Display User list widget */
        function widget($args, $instance) {
            extract($args, EXTR_SKIP);
            global $wpdb, $post, $cs_theme_options;
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));
            $showcount = $instance['showcount'];
            // WIDGET display CODE Start
            echo balanceTags($before_widget, false);
            $cs_page_id = '';
            
            if( isset( $instance['title'] ) && $instance['title'] != '' ){
                if (strlen($title) <> 1 || strlen($title) <> 0) {
                    echo balanceTags($before_title . $title . $after_title, false);
                }
            }
            $showcount = $showcount <> '' ? $showcount : '10';
            $default_date_time_formate = 'd-m-Y H:i:s';
            // posted date check
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
            // check if member not inactive
            $element_filter_arr[] = array(
                'key' => 'property_member_status',
                'value' => 'active',
                'compare' => '=',
            );
            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_is_top_cat',
                'value' => 'on',
                'compare' => '=',
            );
            $paging_var = isset( $paging_var )? $paging_var : '';
            $args = array(
                'posts_per_page' => $showcount,
                'paged' => isset( $_REQUEST[$paging_var] )? $_REQUEST[$paging_var] : 1,
                'post_type' => 'properties',
                'post_status' => 'publish',
                'fields' => 'ids', // only load ids 
                'meta_query' => array(
                    $element_filter_arr,
                ),
            );

            $top_properties_loop_obj = wp_rem_get_cached_obj('top_properties_result_cached_loop_obj', $args, 12, false, 'wp_query');
            if ($top_properties_loop_obj->have_posts()) {
                ?>
                <div class="top-properties-property">
                    <?php
                    while ($top_properties_loop_obj->have_posts()) : $top_properties_loop_obj->the_post();
                        global $post;
                        $property_id = $post;
                        $wp_rem_property_price_options = get_post_meta($property_id, 'wp_rem_property_price_options', true);
                        $wp_rem_property_type = get_post_meta($property_id, 'wp_rem_property_type', true);
                        // checking review in on in property type
                        $wp_rem_property_type = isset($wp_rem_property_type) ? $wp_rem_property_type : '';
                        if ($property_type_post = get_page_by_path($wp_rem_property_type, OBJECT, 'property-type'))
                            $property_type_id = $property_type_post->ID;
                        $property_type_id = isset($property_type_id) ? $property_type_id : '';
                        $wp_rem_user_reviews = get_post_meta($property_type_id, 'wp_rem_user_reviews', true);
                        $wp_rem_property_type_price_switch = get_post_meta($property_type_id, 'wp_rem_property_type_price', true);
                        // end checking review on in property type
                        $wp_rem_property_price = '';
                        if ($wp_rem_property_price_options == 'price') {
                            $wp_rem_property_price = get_post_meta($property_id, 'wp_rem_property_price', true);
                        } else if ($wp_rem_property_price_options == 'on-call') {
                            $wp_rem_property_price = wp_rem_plugin_text_srt('wp_rem_properties_price_on_request');
                        }
                        ?>
                        <div class="properties-post"> 
                            <div class="img-holder">
                                <figure>
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                        if (function_exists('property_gallery_first_image')) {
                                            $gallery_image_args = array(
                                                'property_id' => $property_id,
                                                'size' => 'wp_rem_cs_media_4',
                                                'class' => 'img-list',
                                                'default_image_src' => esc_url(wp_rem::plugin_url() . 'assets/frontend/images/no-image4x3.jpg')
                                            );
                                            echo $property_gallery_first_image = property_gallery_first_image($gallery_image_args);
                                        }
                                        ?>
                                    </a> 
                                </figure>
                            </div>
                            <div class="text-holder">
                                <div class="post-title">
                                    <h4><a href="<?php echo esc_url(get_permalink($property_id)); ?>"><?php echo esc_html(get_the_title($property_id)); ?></a></h4> 
                                </div>
                                <?php if ($wp_rem_property_type_price_switch == 'on' && $wp_rem_property_price != '') { ?>
                                    <span class="property-price">
                                        <span class="new-price text-color">
                                            <?php
                                            if ($wp_rem_property_price_options == 'on-call') {
                                                echo force_balance_tags($wp_rem_property_price);
                                            } else {
                                                $property_info_price = wp_rem_property_price($property_id, $wp_rem_property_price, '<span class="guid-price">', '</span>');
                                                echo force_balance_tags($property_info_price);
                                            }
                                            ?>
                                        </span>
                                    </span>
                                <?php }
                                ?>
                            </div>
                        </div> 
                        <?php
                    endwhile;
                    ?>
                </div>
                <?php
            } else {
                echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-member-match-error"><h6><i class="icon-warning"></i><strong> ' .wp_rem_plugin_text_srt('wp_rem_top_properties_widget_sorry'). '</strong>&nbsp; ' . wp_rem_plugin_text_srt('wp_rem_top_properties_widget_dosen_match') . ' </h6></div>';
            }
            echo balanceTags($after_widget, false);
        }

    }

}
add_action('widgets_init', create_function('', 'return register_widget("wp_rem_top_properties");'));



