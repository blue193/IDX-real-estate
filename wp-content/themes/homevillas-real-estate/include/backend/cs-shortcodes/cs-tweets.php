<?php
/*
 *
 * @Shortcode Name : Tweets
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_tweets') ) {

    function wp_rem_cs_var_page_builder_tweets($die = 0) {
        global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $wp_rem_cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_tweets';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_tweets_user_name' => 'default',
            'wp_rem_cs_var_no_of_tweets' => '',
            'wp_rem_cs_var_tweets_color' => '',
            'wp_rem_api_consumer_key' => '',
            'wp_rem_api_consumer_secret_key' => '',
            'wp_rem_api_access_token_key' => '',
            'wp_rem_api_access_token_secret_key' => '',
        );
        if ( isset($output['0']['atts']) ) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $tweets_element_size = '25';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $wp_rem_cs_var_tweets_user_name = isset($wp_rem_cs_var_tweets_user_name) ? $wp_rem_cs_var_tweets_user_name : '';
        $wp_rem_cs_var_no_of_tweets = isset($wp_rem_cs_var_no_of_tweets) ? $wp_rem_cs_var_no_of_tweets : '';
        $wp_rem_cs_var_tweets_color = isset($wp_rem_cs_var_tweets_color) ? $wp_rem_cs_var_tweets_color : '';
        $name = 'wp_rem_cs_var_page_builder_tweets';
        $coloumn_class = 'column_' . $tweets_element_size;
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        global $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) . '_del'; ?>" class="column parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="tweets" data="<?php echo wp_rem_cs_element_size_data_array_index($tweets_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $tweets_element_size, '', 'check-square-o'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_tweets {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_edit_msg')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_attr($name . $wp_rem_cs_counter); ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
                        <?php
                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            wp_rem_cs_shortcode_element_size();
                        }
                        $wp_rem_cs_opt_array = array(
                            'name' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_username')),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_username_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_tweets_user_name),
                                'cust_id' => 'wp_rem_cs_var_tweets_user_name',
                                'cust_name' => 'wp_rem_cs_var_tweets_user_name[]',
                                'classes' => 'input-medium',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_text_color')),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_text_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_tweets_color),
                                'cust_id' => 'wp_rem_cs_var_tweets_color',
                                'cust_name' => 'wp_rem_cs_var_tweets_color[]',
                                'classes' => 'bg_color',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_tweets_num')),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_tweets_num_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_no_of_tweets),
                                'cust_id' => 'wp_rem_cs_var_no_of_tweets',
                                'cust_name' => 'wp_rem_cs_var_no_of_tweets[]',
                                'classes' => 'input-medium',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        /*
                         * Add Twitter Api Keys
                         */

                        $wp_rem_cs_opt_array = array(
                            'name' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_consumer_key')),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_consumer_key_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_api_consumer_key),
                                'cust_name' => 'wp_rem_api_consumer_key[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_consumer_secret_key')),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_consumer_secret_key_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_api_consumer_secret_key),
                                'cust_name' => 'wp_rem_api_consumer_secret_key[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_access_token_key')),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_access_token_key_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_api_access_token_key),
                                'cust_name' => 'wp_rem_api_access_token_key[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_access_token_secret_key')),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter_element_api_access_token_secret_key_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_api_access_token_secret_key),
                                'cust_name' => 'wp_rem_api_access_token_secret_key[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        ?>
                    </div>
                        <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field">
                                <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_pb_', '', $name)); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a>
                            </li>
                        </ul>
                        <div id="results-shortocde"></div>
            <?php
        } else {
            $wp_rem_cs_opt_array = array(
                'std' => 'tweets',
                'id' => '',
                'before' => '',
                'after' => '',
                'classes' => '',
                'extra_atr' => '',
                'cust_id' => '',
                'cust_name' => 'wp_rem_cs_orderby[]',
                'return' => false,
                'required' => false
            );
            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
            $wp_rem_cs_opt_array = array(
                'name' => '',
                'desc' => '',
                'hint_text' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save')),
                    'cust_id' => '',
                    'cust_type' => 'button',
                    'classes' => 'cs-admin-btn',
                    'cust_name' => '',
                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
        }
        ?>
                </div>
            </div>
        </div>

        <?php
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_tweets', 'wp_rem_cs_var_page_builder_tweets');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_tweets_callback') ) {

    /**
     * Save data for tweets shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_tweets_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ( $widget_type == "tweets" || $widget_type == "cs_tweets" ) {
            $shortcode = '';
            $page_element_size = $data['tweets_element_size'][$counters['wp_rem_cs_global_counter_tweets']];
            $current_element_size = $data['tweets_element_size'][$counters['wp_rem_cs_global_counter_tweets']];
            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($data['shortcode']['tweets'][$counters['wp_rem_cs_shortcode_counter_tweets']]);
                $element_settings = 'tweets_element_size="' . $current_element_size . '"';
                $reg = '/tweets_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_tweets'] ++;
            } else {
                $shortcode = '[wp_rem_cs_tweets tweets_element_size="' . htmlspecialchars($data['tweets_element_size'][$counters['wp_rem_cs_global_counter_tweets']]) . '" ';
                if ( isset($data['wp_rem_cs_var_tweets_user_name'][$counters['wp_rem_cs_counter_tweets']]) && $data['wp_rem_cs_var_tweets_user_name'][$counters['wp_rem_cs_counter_tweets']] != '' ) {
                    $shortcode .='wp_rem_cs_var_tweets_user_name="' . htmlspecialchars($data['wp_rem_cs_var_tweets_user_name'][$counters['wp_rem_cs_counter_tweets']]) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_tweets_color'][$counters['wp_rem_cs_counter_tweets']]) && $data['wp_rem_cs_var_tweets_color'][$counters['wp_rem_cs_counter_tweets']] != '' ) {
                    $shortcode .='wp_rem_cs_var_tweets_color="' . htmlspecialchars($data['wp_rem_cs_var_tweets_color'][$counters['wp_rem_cs_counter_tweets']]) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_no_of_tweets'][$counters['wp_rem_cs_counter_tweets']]) && $data['wp_rem_cs_var_no_of_tweets'][$counters['wp_rem_cs_counter_tweets']] != '' ) {
                    $shortcode .='wp_rem_cs_var_no_of_tweets="' . htmlspecialchars($data['wp_rem_cs_var_no_of_tweets'][$counters['wp_rem_cs_counter_tweets']]) . '" ';
                }
                if ( isset($data['wp_rem_api_consumer_key'][$counters['wp_rem_cs_counter_tweets']]) && $data['wp_rem_api_consumer_key'][$counters['wp_rem_cs_counter_tweets']] != '' ) {
                    $shortcode .='wp_rem_api_consumer_key="' . htmlspecialchars($data['wp_rem_api_consumer_key'][$counters['wp_rem_cs_counter_tweets']]) . '" ';
                }
                if ( isset($data['wp_rem_api_consumer_secret_key'][$counters['wp_rem_cs_counter_tweets']]) && $data['wp_rem_api_consumer_secret_key'][$counters['wp_rem_cs_counter_tweets']] != '' ) {
                    $shortcode .='wp_rem_api_consumer_secret_key="' . htmlspecialchars($data['wp_rem_api_consumer_secret_key'][$counters['wp_rem_cs_counter_tweets']]) . '" ';
                }
                if ( isset($data['wp_rem_api_access_token_key'][$counters['wp_rem_cs_counter_tweets']]) && $data['wp_rem_api_access_token_key'][$counters['wp_rem_cs_counter_tweets']] != '' ) {
                    $shortcode .='wp_rem_api_access_token_key="' . htmlspecialchars($data['wp_rem_api_access_token_key'][$counters['wp_rem_cs_counter_tweets']]) . '" ';
                }
                if ( isset($data['wp_rem_api_access_token_secret_key'][$counters['wp_rem_cs_counter_tweets']]) && $data['wp_rem_api_access_token_secret_key'][$counters['wp_rem_cs_counter_tweets']] != '' ) {
                    $shortcode .='wp_rem_api_access_token_secret_key="' . htmlspecialchars($data['wp_rem_api_access_token_secret_key'][$counters['wp_rem_cs_counter_tweets']]) . '" ';
                }

                $shortcode .=']';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_tweets'] ++;
            }
            $counters['wp_rem_cs_global_counter_tweets'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_tweets', 'wp_rem_cs_save_page_builder_data_tweets_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_tweets_callback') ) {

    /**
     * Populate tweets shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_tweets_callback($counters) {
        $counters['wp_rem_cs_counter_tweets'] = 0;
        $counters['wp_rem_cs_shortcode_counter_tweets'] = 0;
        $counters['wp_rem_cs_global_counter_tweets'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_tweets_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_tweets_callback') ) {

    /**
     * Populate tweets shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_tweets_callback($shortcode_array) {
        $shortcode_array['tweets'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_tweets'),
            'name' => 'tweets',
            'icon' => 'icon-twitter',
            'categories' => 'loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_tweets_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_tweets_callback') ) {

    /**
     * Populate tweets shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_tweets_callback($element_list) {
        $element_list['tweets'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_tweets');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_tweets_callback');
}