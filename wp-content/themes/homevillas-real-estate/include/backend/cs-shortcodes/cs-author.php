<?php
/*
 *
 * @File : author
 * @retrun
 *
 */
if (!function_exists('wp_rem_cs_var_page_builder_author')) {

    function wp_rem_cs_var_page_builder_author($die = 0) {
        global $wp_rem_cs_var_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $strings->wp_rem_cs_theme_option_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $wp_rem_cs_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_author';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_author_element_title' => '',
            'wp_rem_cs_author_element_subtitle' => '',
            'wp_rem_cs_author_orderby' => 'DESC',
            'wp_rem_cs_author_description' => 'yes',
            'wp_rem_cs_author_excerpt' => '30',
            'wp_rem_cs_author_num_post' => '5',
            'author_pagination' => '',
            'wp_rem_var_author_align' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $author_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'author';
        $coloumn_class = 'column_' . $author_element_size;
        $wp_rem_cs_author_element_title = isset($wp_rem_cs_author_element_title) ? $wp_rem_cs_author_element_title : '';
        $wp_rem_cs_author_element_subtitle = isset($wp_rem_cs_author_element_subtitle) ? $wp_rem_cs_author_element_subtitle : '';
        
        
        $wp_rem_cs_author_orderby = isset($wp_rem_cs_author_orderby) ? $wp_rem_cs_author_orderby : '';
        $wp_rem_cs_author_description = isset($wp_rem_cs_author_description) ? $wp_rem_cs_author_description : '';
        $wp_rem_cs_author_excerpt = isset($wp_rem_cs_author_excerpt) ? $wp_rem_cs_author_excerpt : '';
        $wp_rem_cs_author_num_post = isset($wp_rem_cs_author_num_post) ? $wp_rem_cs_author_num_post : '';
        $author_pagination = isset($author_pagination) ? $author_pagination : '';
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $wp_rem_cs_rand_id = rand(13441324, 93441324);
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="author" data="<?php echo wp_rem_cs_element_size_data_array_index($author_element_size) ?>">
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $author_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_author {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_author_items')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter); ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            wp_rem_cs_shortcode_element_size();
                        }
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_author_element_title),
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_author_element_title[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_subtitle'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_subtitle_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_author_element_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_author_element_subtitle[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_var_title_alignment'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_var_title_alignment_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_var_author_align,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_author_align',
                                'cust_name' => 'wp_rem_var_author_align[]',
                                'classes' => 'service_postion chosen-select-no-single select-medium',
                                'options' => array(
                                    'align-left' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_left'),
                                    'align-right' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_right'),
                                    'align-center' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_center'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
                        ?>
                        <div id="Blog-listing<?php echo intval($wp_rem_cs_counter); ?>" >
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_post_order'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_post_order_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_author_orderby,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_cs_author_orderby[]',
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'ASC' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_asc'),
                                        'DESC' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_desc'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_description'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_description_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_author_description,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_cs_author_description[]',
                                    'classes' => 'dropdown chosen-select-no-single select-medium',
                                    'options' => array(
                                        'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
                                        'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_length_author_excerpt'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_length_author_excerpt_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_author_excerpt),
                                    'cust_id' => '',
                                    'classes' => 'txtfield input-small',
                                    'cust_name' => 'wp_rem_cs_author_excerpt[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <?php
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_per_page'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_per_page_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_author_num_post),
                                'cust_id' => '',
                                'classes' => 'txtfield input-small',
                                'cust_name' => 'wp_rem_cs_author_num_post[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_pagination'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_pagination_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $author_pagination,
                                'id' => '',
                                'cust_name' => 'author_pagination[]',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'options' => array(
                                    'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_show_pagination'),
                                    'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_single_page'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_', '', $name)); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                            </ul>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'author',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
                                'cust_name' => 'wp_rem_cs_orderby[]',
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'id' => '',
                                'std' => absint($wp_rem_cs_rand_id),
                                'cust_id' => "",
                                'cust_name' => "wp_rem_cs_author_id[]",
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => 'Save',
                                    'cust_id' => '',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'cust_name' => 'button',
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
        </div>

        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_author', 'wp_rem_cs_var_page_builder_author');
}
if (!function_exists('wp_rem_cs_save_page_builder_data_author_callback')) {

    /**
     * Save data for author shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_author_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ($widget_type == "author" || $widget_type == "cs_author") {

            $wp_rem_cs_var_author = '';
            $page_element_size = $data['author_element_size'][$counters['wp_rem_cs_global_counter_author']];
            $author_element_size = $data['author_element_size'][$counters['wp_rem_cs_global_counter_author']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['author'][$counters['wp_rem_cs_shortcode_counter_author']]));
                $element_settings = 'author_element_size="' . $author_element_size . '"';
                $reg = '/author_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_author'] ++;
            } else {
                $wp_rem_cs_var_author = '[wp_rem_cs_author author_element_size="' . htmlspecialchars($data['author_element_size'][$counters['wp_rem_cs_global_counter_author']]) . '" ';
                if (isset($data['wp_rem_cs_author_element_title'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_cs_author_element_title'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'wp_rem_cs_author_element_title="' . htmlspecialchars($data['wp_rem_cs_author_element_title'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_author_element_subtitle'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_cs_author_element_subtitle'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'wp_rem_cs_author_element_subtitle="' . htmlspecialchars($data['wp_rem_cs_author_element_subtitle'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_author_align'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_var_author_align'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'wp_rem_var_author_align="' . htmlspecialchars($data['wp_rem_var_author_align'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_author_id'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_cs_author_id'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_author_id = $data['wp_rem_cs_author_id'][$counters['wp_rem_cs_counter_author']];
                }
                if (isset($data['wp_rem_cs_author_orderby'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_cs_author_orderby'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'wp_rem_cs_author_orderby="' . htmlspecialchars($data['wp_rem_cs_author_orderby'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['orderby'][$counters['wp_rem_cs_counter_author']]) && $data['orderby'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'orderby="' . htmlspecialchars($data['orderby'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_author_description'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_cs_author_description'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'wp_rem_cs_author_description="' . htmlspecialchars($data['wp_rem_cs_author_description'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_author_excerpt'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_cs_author_excerpt'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'wp_rem_cs_author_excerpt="' . htmlspecialchars($data['wp_rem_cs_author_excerpt'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_author_num_post'][$counters['wp_rem_cs_counter_author']]) && $data['wp_rem_cs_author_num_post'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'wp_rem_cs_author_num_post="' . htmlspecialchars($data['wp_rem_cs_author_num_post'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                if (isset($data['author_pagination'][$counters['wp_rem_cs_counter_author']]) && $data['author_pagination'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= 'author_pagination="' . htmlspecialchars($data['author_pagination'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_var_author .= ']';
                if (isset($data['author_text'][$counters['wp_rem_cs_counter_author']]) && $data['author_text'][$counters['wp_rem_cs_counter_author']] != '') {
                    $wp_rem_cs_var_author .= htmlspecialchars($data['author_text'][$counters['wp_rem_cs_counter_author']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_var_author .= '[/wp_rem_cs_author]';
                $shortcode_data .= $wp_rem_cs_var_author;

                $counters['wp_rem_cs_counter_author'] ++;
            }
            $counters['wp_rem_cs_global_counter_author'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_author', 'wp_rem_cs_save_page_builder_data_author_callback');
}
if (!function_exists('wp_rem_cs_load_shortcode_counters_author_callback')) {

    /**
     * Populate author shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_author_callback($counters) {
        $counters['wp_rem_cs_global_counter_author'] = 0;
        $counters['wp_rem_cs_shortcode_counter_author'] = 0;
        $counters['wp_rem_cs_counter_author'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_author_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_author_callback')) {

    /**
     * Populate author shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_author_callback($shortcode_array) {
        $shortcode_array['author'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_author'),
            'name' => 'author',
            'icon' => 'icon-user3',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

//icon-support2
    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_author_callback');
}
if (!function_exists('wp_rem_cs_element_list_populate_author_callback')) {

    /**
     * Populate author shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_author_callback($element_list) {
        $element_list['author'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_author');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_author_callback');
}