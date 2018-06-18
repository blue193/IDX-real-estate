<?php
/**
 * Shortcode Name : property_categories
 *
 * @package	wp_rem_cs 
 */
if (!function_exists('wp_rem_cs_var_page_builder_property_categories')) {

    function wp_rem_cs_var_page_builder_property_categories($die = 0) {
        global $post, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
        if (function_exists('wp_rem_cs_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $wp_rem_cs_PREFIX = 'property_categories';

            $wp_rem_cs_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
                $wp_rem_cs_POSTID = '';
                $shortcode_element_id = '';
            } else {
                $wp_rem_cs_POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
                $shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
                $shortcode_str = stripslashes($shortcode_element_id);
                $parseObject = new ShortcodeParse();
                $wp_rem_cs_output = $parseObject->wp_rem_cs_shortcodes($wp_rem_cs_output, $shortcode_str, true, $wp_rem_cs_PREFIX);
            }
            $defaults = array(
                'property_categories_title' => '',
                'property_categories_subtitle' => '',
                'property_categories_title_align' => '',
                'property_categories_styles'=>'',
                'property_categories_view' => '',
                'property_categories' => '',
                'wp_rem_typess' => '',
                'property_categories_more_less' => '',
            );
            if (isset($wp_rem_cs_output['0']['atts'])) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rem_cs_output['0']['content'])) {
                $property_categories_column_text = $wp_rem_cs_output['0']['content'];
            } else {
                $property_categories_column_text = '';
            }
            $property_categories_element_size = '100';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_property_categories';
            $coloumn_class = 'column_' . $property_categories_element_size;
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            wp_rem_cs_var_date_picker();
            ?>

            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="property_categories" data="<?php echo wp_rem_cs_element_size_data_array_index($property_categories_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $property_categories_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[property_categories {{attributes}}]{{content}}[/property_categories]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo wp_rem_plugin_text_srt('wp_rem_property_categories_options'); ?></h5>
                        <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
                            <i class="icon-cross"></i>
                        </a>
                    </div>
                    <div class="cs-pbwp-content">
                        <div class="cs-wrapp-clone cs-shortcode-wrapp">
                            <?php
                            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                wp_rem_cs_shortcode_element_size();
                            }


                            $wp_rem_types_array = array();
                            $args = array('post_type' => 'property-type', 'posts_per_page' => '-1', 'post_status' => 'publish');
                            $query = new wp_query($args);
                            while ($query->have_posts()):
                                $query->the_post();
                                $wp_rem_types_array[get_the_id()] = get_the_title();
                            endwhile;

                            wp_reset_postdata();

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_title'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $property_categories_title,
                                    'id' => 'property_categories_title',
                                    'cust_name' => 'property_categories_title[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_sub_title'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_sub_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $property_categories_subtitle,
                                    'id' => 'property_categories_subtitle',
                                    'cust_name' => 'property_categories_subtitle[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_title_align'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_title_align_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_categories_title_align),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'property_categories_title_align[]',
                                    'return' => true,
                                    'options' => array(
                                        'align-left' => wp_rem_plugin_text_srt('wp_rem_align_left'),
                                        'align-right' => wp_rem_plugin_text_srt('wp_rem_align_right'),
                                        'align-center' => wp_rem_plugin_text_srt('wp_rem_align_center'),
                                    ),
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            
                            
                            $wp_rem_opt_array = array(
                                'name' => 'Styles',
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_categories_styles),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'property_categories_styles[]',
                                    'return' => true,
                                    'options' => array(
                                        'simple' => 'Simple',
                                        'classic' => 'Classic',
                                    ),
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            
                            
                            
                            
                            $category_obj = get_terms('property-category', array(
                                'hide_empty' => false,
                                    ));
                            $categories_list = array();
                            if (is_array($category_obj) && sizeof($category_obj) > 0) {
                                foreach ($category_obj as $dir_cat) {
                                    $categories_list[$dir_cat->slug] = $dir_cat->name;
                                }
                            }
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_categories_categories'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_property_categories_categories_hint'),
                                'echo' => true,
                                'multi' => true,
                                'classes' => 'chosen-select',
                                'field_params' => array(
                                    'std' => $property_categories,
                                    'id' => 'property_categories',
                                    'cust_name' => 'property_categories[]',
                                    'return' => true,
                                    'classes' => 'chosen-select',
                                    'options' => $categories_list,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
						?>
						</div>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo wp_rem_plugin_text_srt('wp_rem_insert'); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>

                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => 'property_categories',
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
                                'name' => '',
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_save'),
                                    'cust_id' => 'property_categories_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'cust_name' => 'property_categories_save',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        }
                        ?>
                    </div>
                </div>
                <script type="text/javascript">
                    popup_over();

                </script>
            </div>

            <?php
        }
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_property_categories', 'wp_rem_cs_var_page_builder_property_categories');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_property_categories_callback')) {

    /**
     * Save data for property_categories shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_property_categories_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ($widget_type == "property_categories" || $widget_type == "cs_property_categories") {
            $property_cats = isset($data['property_categories']) ? $data['property_categories'] : '';
            $types_lists = '';
            if (is_array($property_cats)) {
                foreach ($property_cats as $property_cat) {
                    $cats_lists .=$property_cat . ',';
                }
            }


            $wp_rem_cs_bareber_property_categories = '';

            $page_element_size = $data['property_categories_element_size'][$counters['wp_rem_cs_global_counter_property_categories']];
            $current_element_size = $data['property_categories_element_size'][$counters['wp_rem_cs_global_counter_property_categories']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['property_categories'][$counters['wp_rem_cs_shortcode_counter_property_categories']]));

                $element_settings = 'property_categories_element_size="' . $current_element_size . '"';
                $reg = '/property_categories_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $wp_rem_cs_bareber_property_categories ++;
            } else {
                $element_settings = 'property_categories_element_size="' . htmlspecialchars($data['property_categories_element_size'][$counters['wp_rem_cs_global_counter_property_categories']]) . '"';
                $wp_rem_cs_bareber_property_categories = '[property_categories ' . $element_settings . ' ';
                if (isset($data['property_categories_title'][$counters['wp_rem_cs_counter_property_categories']]) && $data['property_categories_title'][$counters['wp_rem_cs_counter_property_categories']] != '') {
                    $wp_rem_cs_bareber_property_categories .= 'property_categories_title="' . htmlspecialchars($data['property_categories_title'][$counters['wp_rem_cs_counter_property_categories']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_categories_title_align'][$counters['wp_rem_cs_counter_property_categories']]) && $data['property_categories_title_align'][$counters['wp_rem_cs_counter_property_categories']] != '') {
                    $wp_rem_cs_bareber_property_categories .= 'property_categories_title_align="' . htmlspecialchars($data['property_categories_title_align'][$counters['wp_rem_cs_counter_property_categories']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_categories_styles'][$counters['wp_rem_cs_counter_property_categories']]) && $data['property_categories_styles'][$counters['wp_rem_cs_counter_property_categories']] != '') {
                    $wp_rem_cs_bareber_property_categories .= 'property_categories_styles="' . htmlspecialchars($data['property_categories_styles'][$counters['wp_rem_cs_counter_property_categories']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_categories_subtitle'][$counters['wp_rem_cs_counter_property_categories']]) && $data['property_categories_subtitle'][$counters['wp_rem_cs_counter_property_categories']] != '') {
                    $wp_rem_cs_bareber_property_categories .= 'property_categories_subtitle="' . htmlspecialchars($data['property_categories_subtitle'][$counters['wp_rem_cs_counter_property_categories']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_categories'][$counters['wp_rem_cs_counter_property_categories']]) && $data['property_categories'][$counters['wp_rem_cs_counter_property_categories']] != '') {
                    $wp_rem_cs_bareber_property_categories .= 'property_categories="' . $cats_lists . '" ';
                }

                $wp_rem_cs_bareber_property_categories .= ']';

                if (isset($data['property_categories_column_text'][$counters['wp_rem_cs_counter_property_categories']]) && $data['property_categories_column_text'][$counters['wp_rem_cs_counter_property_categories']] != '') {
                    $wp_rem_cs_bareber_property_categories .= htmlspecialchars($data['property_categories_column_text'][$counters['wp_rem_cs_counter_property_categories']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_bareber_property_categories .= '[/property_categories]';

                $shortcode_data .= $wp_rem_cs_bareber_property_categories;
                $counters['wp_rem_cs_counter_property_categories'] ++;
            }
            $counters['wp_rem_cs_global_counter_property_categories'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_property_categories', 'wp_rem_cs_save_page_builder_data_property_categories_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_property_categories_callback')) {

    /**
     * Populate property_categories shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_property_categories_callback($counters) {
        $counters['wp_rem_cs_global_counter_property_categories'] = 0;
        $counters['wp_rem_cs_shortcode_counter_property_categories'] = 0;
        $counters['wp_rem_cs_counter_property_categories'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_property_categories_callback');
}



if (!function_exists('wp_rem_cs_element_list_populate_property_categories_callback')) {

    /**
     * Populate property_categories shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_property_categories_callback($element_list) {
        $element_list['property_categories'] = wp_rem_plugin_text_srt('wp_rem_property_categories_heading');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_property_categories_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_property_categories_callback')) {

    /**
     * Populate property_categories shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_property_categories_callback($shortcode_array) {
        $shortcode_array['property_categories'] = array(
            'title' => wp_rem_plugin_text_srt('wp_rem_property_categories_heading'),
            'name' => 'property_categories',
            'icon' => 'icon-gears',
            'categories' => 'typography',
        );

        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_property_categories_callback');
}
