<?php
/*
 *
 * @File : locations
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_locations') ) {

    function wp_rem_cs_var_page_builder_locations($die = 0) {
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
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_locations';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_locations_element_title' => '',
            'wp_rem_cs_locations_element_subtitle' => '',
            'wp_rem_var_locations_align' => '',
            'wp_rem_var_locations_style' => '',
            'wp_rem_all_locations_names' => '',
            'wp_rem_all_locations_url' => '',
        );
        if ( isset($output['0']['atts']) ) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $locations_element_size = '50';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_locations';
        $coloumn_class = 'column_' . $locations_element_size;
        $wp_rem_cs_locations_element_title = isset($wp_rem_cs_locations_element_title) ? $wp_rem_cs_locations_element_title : '';
        $wp_rem_cs_locations_element_subtitle = isset($wp_rem_cs_locations_element_subtitle) ? $wp_rem_cs_locations_element_subtitle : '';
        $wp_rem_var_locations_align = isset($wp_rem_var_locations_align) ? $wp_rem_var_locations_align : '';

        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $wp_rem_cs_rand_id = rand(13441324, 93441324);
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="locations" data="<?php echo wp_rem_cs_element_size_data_array_index($locations_element_size) ?>">
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $locations_element_size); ?>
            <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_locations {{attributes}}]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter); ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            wp_rem_cs_shortcode_element_size();
                        }
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_element_title'),
                            'desc' => '',
                            'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_locations_element_title),
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_locations_element_title[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_element_sub_title'),
                            'desc' => '',
                            'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_sub_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_locations_element_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_locations_element_subtitle[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_opt_array = array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_title_align'),
                            'desc' => '',
                            'label_desc' => wp_rem_plugin_text_srt('wp_rem_title_align_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_var_locations_align,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_locations_align',
                                'cust_name' => 'wp_rem_var_locations_align[]',
                                'classes' => 'service_postion chosen-select-no-single select-medium',
                                'options' => array(
                                    'align-left' => wp_rem_plugin_text_srt('wp_rem_align_left'),
                                    'align-right' => wp_rem_plugin_text_srt('wp_rem_align_right'),
                                    'align-center' => wp_rem_plugin_text_srt('wp_rem_align_center'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);

                        $wp_rem_opt_array = array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_styles'),
                            'desc' => '',
                            'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_styles_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_var_locations_style,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_locations_style',
                                'cust_name' => 'wp_rem_var_locations_style[]',
                                'extra_atr' => 'onchange="javascript:location_hide_show(this.value)"',
                                'classes' => 'service_postion chosen-select-no-single select-medium',
                                'options' => array(
                                    'modern' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_styles_modern'),
                                    'simple' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_styles_simple'),
                                    'classic' => wp_rem_plugin_text_srt('wp_rem_location_element_style_classic'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);

                        $locations_names_array = array();
                        $get_all_locations_data = '';
                        $get_all_locations_data = get_terms(array(
                            'taxonomy' => 'wp_rem_locations',
                            'hide_empty' => false,
                        ));
                        if ( isset($get_all_locations_data) && ! empty($get_all_locations_data) && is_array($get_all_locations_data) ) {
                            foreach ( $get_all_locations_data as $key => $value ) {
                                $locations_names_array[$value->term_id] = $value->name;
                            }
                        }
                        $wp_rem_opt_array = array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_locations'),
                            'desc' => '',
                            'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_locations_hint'),
                            'echo' => true,
                            'multi' => true,
                            'classes' => 'chosen-select',
                            'field_params' => array(
                                'std' => $wp_rem_all_locations_names,
                                'id' => '',
                                'cust_id' => 'wp_rem_all_locations_names',
                                'cust_name' => 'wp_rem_all_locations_names[]',
                                'classes' => 'chosen-select',
                                'options' => $locations_names_array,
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
                        $loc_sty = '';
                        if ( $wp_rem_var_locations_style == 'simple' ) {
                            $loc_sty = ' style="display:none"';
                        }
                        ?>
                        <script>

                            function location_hide_show(view) {
                                if (view == 'modern') {
                                    jQuery('.all-loc-hide').show();
                                } else {
                                    jQuery('.all-loc-hide').hide();
                                }
                            }
                        </script>
                        <?php
                        echo '<div class="all-loc-hide"' . $loc_sty . '>';
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_all_locations_url'),
                            'desc' => '',
                            'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_all_locations_url_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_all_locations_url),
                                'classes' => '',
                                'cust_name' => 'wp_rem_all_locations_url[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        echo '</div>';

                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo wp_rem_plugin_text_srt('wp_rem_insert'); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>

                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => 'locations',
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
                                    'cust_id' => 'locations_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn save_property_locations_' . $property_rand_id . '',
                                    'cust_name' => 'locations_save',
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
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_locations', 'wp_rem_cs_var_page_builder_locations');
}
if ( ! function_exists('wp_rem_cs_save_page_builder_data_locations_callback') ) {

    /**
     * Save data for locations shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_locations_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ( $widget_type == "locations" || $widget_type == "cs_locations" ) {

            $wp_rem_cs_var_locations = '';
            $page_element_size = $data['locations_element_size'][$counters['wp_rem_cs_global_counter_locations']];
            $locations_element_size = $data['locations_element_size'][$counters['wp_rem_cs_global_counter_locations']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes(( $data['shortcode']['locations'][$counters['wp_rem_cs_shortcode_counter_locations']]));
                $element_settings = 'locations_element_size="' . $locations_element_size . '"';
                $reg = '/locations_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_locations'] ++;
            } else {
                $wp_rem_cs_var_locations = '[wp_rem_cs_locations locations_element_size="' . htmlspecialchars($data['locations_element_size'][$counters['wp_rem_cs_global_counter_locations']]) . '" ';
                if ( isset($data['wp_rem_cs_locations_element_title'][$counters['wp_rem_cs_counter_locations']]) && $data['wp_rem_cs_locations_element_title'][$counters['wp_rem_cs_counter_locations']] != '' ) {
                    $wp_rem_cs_var_locations .= 'wp_rem_cs_locations_element_title="' . htmlspecialchars($data['wp_rem_cs_locations_element_title'][$counters['wp_rem_cs_counter_locations']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_locations_element_subtitle'][$counters['wp_rem_cs_counter_locations']]) && $data['wp_rem_cs_locations_element_subtitle'][$counters['wp_rem_cs_counter_locations']] != '' ) {
                    $wp_rem_cs_var_locations .= 'wp_rem_cs_locations_element_subtitle="' . htmlspecialchars($data['wp_rem_cs_locations_element_subtitle'][$counters['wp_rem_cs_counter_locations']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_locations_align'][$counters['wp_rem_cs_counter_locations']]) && $data['wp_rem_var_locations_align'][$counters['wp_rem_cs_counter_locations']] != '' ) {
                    $wp_rem_cs_var_locations .= 'wp_rem_var_locations_align="' . htmlspecialchars($data['wp_rem_var_locations_align'][$counters['wp_rem_cs_counter_locations']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_locations_style'][$counters['wp_rem_cs_counter_locations']]) && $data['wp_rem_var_locations_style'][$counters['wp_rem_cs_counter_locations']] != '' ) {
                    $wp_rem_cs_var_locations .= 'wp_rem_var_locations_style="' . htmlspecialchars($data['wp_rem_var_locations_style'][$counters['wp_rem_cs_counter_locations']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_all_locations_url'][$counters['wp_rem_cs_counter_locations']]) && $data['wp_rem_all_locations_url'][$counters['wp_rem_cs_counter_locations']] != '' ) {
                    $wp_rem_cs_var_locations .= 'wp_rem_all_locations_url="' . htmlspecialchars($data['wp_rem_all_locations_url'][$counters['wp_rem_cs_counter_locations']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_all_locations_names'][$counters['wp_rem_cs_counter_locations']]) && $data['wp_rem_all_locations_names'][$counters['wp_rem_cs_counter_locations']] != '' ) {
                    $property_locations_names = isset($data['wp_rem_all_locations_names']) ? $data['wp_rem_all_locations_names'] : '';
                    $location_lists = '';
                    $total = count($property_locations_names);
                    $count = 0;
                    if ( is_array($property_locations_names) ) {
                        foreach ( $property_locations_names as $property_cat ) {
                            $location_lists .=$property_cat;
                            $count ++;
                            if ( $count < $total ) {
                                $location_lists .=',';
                            }
                        }
                    }
                    $wp_rem_cs_var_locations .= 'wp_rem_all_locations_names="' . $location_lists . '" ';
                }
                $wp_rem_cs_var_locations .= ']';
                if ( isset($data['locations_text'][$counters['wp_rem_cs_counter_locations']]) && $data['locations_text'][$counters['wp_rem_cs_counter_locations']] != '' ) {
                    $wp_rem_cs_var_locations .= htmlspecialchars($data['locations_text'][$counters['wp_rem_cs_counter_locations']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_var_locations .= '[/wp_rem_cs_locations]';
                $shortcode_data .= $wp_rem_cs_var_locations;

                $counters['wp_rem_cs_counter_locations'] ++;
            }
            $counters['wp_rem_cs_global_counter_locations'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_locations', 'wp_rem_cs_save_page_builder_data_locations_callback');
}
if ( ! function_exists('wp_rem_cs_load_shortcode_counters_locations_callback') ) {

    /**
     * Populate locations shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_locations_callback($counters) {
        $counters['wp_rem_cs_global_counter_locations'] = 0;
        $counters['wp_rem_cs_shortcode_counter_locations'] = 0;
        $counters['wp_rem_cs_counter_locations'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_locations_callback');
}
if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_locations_callback') ) {

    /**
     * Populate locations shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_locations_callback($shortcode_array) {
        $shortcode_array['locations'] = array(
            'title' => wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_name'),
            'name' => 'locations',
            'icon' => 'icon-my_location',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

//icon-support2
    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_locations_callback');
}
if ( ! function_exists('wp_rem_cs_element_list_populate_locations_callback') ) {

    /**
     * Populate locations shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_locations_callback($element_list) {
        $element_list['locations'] = wp_rem_plugin_text_srt('wp_rem_element_location_shortcode_name');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_locations_callback');
}