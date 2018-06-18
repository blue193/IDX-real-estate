<?php
/*
 *
 * @Shortcode Name : Table
 * @retrun
 *
 */
if (!function_exists('wp_rem_cs_var_page_builder_table')) {

    function wp_rem_cs_var_page_builder_table($die = 0) {
        global $wp_rem_cs_node, $wp_rem_cs_count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'wp_rem_cs_table';
        $defaultAttributes = false;
        $parseObject = new ShortcodeParse();
        $wp_rem_cs_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
            $defaultAttributes = true;
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '1/2',
            'wp_rem_cs_table_element_title' => '',
            'wp_rem_cs_table_element_subtitle' => '',
            'wp_rem_cs_table_content' => '',
            'wp_rem_var_table_align' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        $atts_content = '[table]
                            [thead]
                              [tr]
                                [th]Column 1[/th]
                                [th]Column 2[/th]
                                [th]Column 3[/th]
                                [th]Column 4[/th]
                              [/tr]
                            [/thead]
                            [tbody]
                              [tr]
                                [td]Item 1[/td]
                                [td]Item 2[/td]
                                [td]Item 3[/td]
                                [td]Item 4[/td]
                              [/tr]
                              [tr]
                                [td]Item 11[/td]
                                [td]Item 22[/td]
                                [td]Item 33[/td]
                                [td]Item 44[/td]
                              [/tr]
                            [/tbody]
                        [/table]';

        if ($defaultAttributes) {
            $atts_content = $atts_content;
        } else {
            if (isset($output['0']['content'])) {
                $atts_content = $output['0']['content'];
            } else {
                $atts_content = "";
            }
        }
        $table_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_table';
        $wp_rem_cs_table_element_title = isset($wp_rem_cs_table_element_title) ? $wp_rem_cs_table_element_title : '';
        $wp_rem_cs_table_content = isset($wp_rem_cs_table_content) ? $wp_rem_cs_table_content : '';
        $wp_rem_cs_count_node ++;
        $coloumn_class = 'column_' . $table_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="table" data="<?php echo wp_rem_cs_element_size_data_array_index($table_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $table_element_size, '', 'th'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>"  data-shortcode-template="[wp_rem_cs_table {{attributes}}] {{content}} [/wp_rem_cs_table]"  style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_table_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_attr($name . $wp_rem_cs_counter) ?>','<?php echo esc_attr($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
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
                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_table_element_title),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_table_element_title[]',
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
                                'std' => esc_attr($wp_rem_cs_table_element_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_table_element_subtitle[]',
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
                                'std' => $wp_rem_var_table_align,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_table_align',
                                'cust_name' => 'wp_rem_var_table_align[]',
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

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_table_content'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_table_content_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_textarea($atts_content),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_table_content[]',
                                'return' => true,
                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                            ?>
                            <ul class="form-elements insert-bg noborder cs-insert-noborder">
                                <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                            </ul>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'table',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_orderby[]',
                                'return' => true,
                                'required' => false
                            );
                            echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array));
                            $wp_rem_cs_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
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
        </div>
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_table', 'wp_rem_cs_var_page_builder_table');
}
if (!function_exists('wp_rem_cs_save_page_builder_data_table_callback')) {

    /**
     * Save data for table shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_table_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		$shortcode_data = '';
        if ($widget_type == "table" || $widget_type == "cs_table") {
            $shortcode = '';
            $page_element_size = $data['table_element_size'][$counters['wp_rem_cs_global_counter_table']];
            $current_element_size = $data['table_element_size'][$counters['wp_rem_cs_global_counter_table']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($data['shortcode']['table'][$counters['wp_rem_cs_shortcode_counter_table']]);
                $element_settings = 'table_element_size="' . $current_element_size . '"';
                $reg = '/table_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_table'] ++;
            } else {
                $shortcode = '[wp_rem_cs_table table_element_size="' . htmlspecialchars($data['table_element_size'][$counters['wp_rem_cs_global_counter_table']]) . '" ';
                if (isset($data['wp_rem_cs_table_element_title'][$counters['wp_rem_cs_counter_table']]) && $data['wp_rem_cs_table_element_title'][$counters['wp_rem_cs_counter_table']] != '') {
                    $shortcode .= ' wp_rem_cs_table_element_title="' . htmlspecialchars($data['wp_rem_cs_table_element_title'][$counters['wp_rem_cs_counter_table']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_table_align'][$counters['wp_rem_cs_counter_table']]) && $data['wp_rem_var_table_align'][$counters['wp_rem_cs_counter_table']] != '') {
                    $shortcode .= ' wp_rem_var_table_align="' . htmlspecialchars($data['wp_rem_var_table_align'][$counters['wp_rem_cs_counter_table']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_table_element_subtitle'][$counters['wp_rem_cs_counter_table']]) && $data['wp_rem_cs_table_element_subtitle'][$counters['wp_rem_cs_counter_table']] != '') {
                    $shortcode .= ' wp_rem_cs_table_element_subtitle="' . htmlspecialchars($data['wp_rem_cs_table_element_subtitle'][$counters['wp_rem_cs_counter_table']], ENT_QUOTES) . '" ';
                }
                $shortcode .= ']';
                if (isset($data['wp_rem_cs_table_content'][$counters['wp_rem_cs_counter_table']]) && $data['wp_rem_cs_table_content'][$counters['wp_rem_cs_counter_table']] != '') {
                    $shortcode .= htmlspecialchars($data['wp_rem_cs_table_content'][$counters['wp_rem_cs_counter_table']], ENT_QUOTES);
                }
                $shortcode .='[/wp_rem_cs_table]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_table'] ++;
            }
            $counters['wp_rem_cs_global_counter_table'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_table', 'wp_rem_cs_save_page_builder_data_table_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_table_callback')) {

    /**
     * Populate spacer shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_table_callback($counters) {
        $counters['wp_rem_cs_counter_table'] = 0;
        $counters['wp_rem_cs_global_counter_table'] = 0;
        $counters['wp_rem_cs_shortcode_counter_table'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_table_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_table_callback')) {

    /**
     * Populate table shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_table_callback($shortcode_array) {
        $shortcode_array['table'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_table'),
            'name' => 'table',
            'icon' => 'icon-th',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_table_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_table_callback')) {

    /**
     * Populate table shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_table_callback($element_list) {
        $element_list['table'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_table');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_table_callback');
}