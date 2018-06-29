<?php
/**
 * dropcaps html form for page builder
 */
if (!function_exists('wp_rem_cs_var_page_builder_dropcap')) {

    function wp_rem_cs_var_page_builder_dropcap($die = 0) {
        global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_dropcap';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_dropcap_section_title' => '',
            'wp_rem_cs_dropcap_section_subtitle' => '',
            'wp_rem_var_dropcap_align' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }

        if (isset($output['0']['content'])) {
            $dropcaps_content = $output['0']['content'];
        } else {
            $dropcaps_content = '';
        }

        $dropcap_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_dropcap';
        $coloumn_class = 'column_' . $dropcap_element_size;
        $wp_rem_cs_dropcap_section_title = isset($wp_rem_cs_dropcap_section_title) ? $wp_rem_cs_dropcap_section_title : '';

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        global $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
             <?php echo esc_attr($shortcode_view); ?>" item="dropcap" data="<?php echo wp_rem_cs_element_size_data_array_index($dropcap_element_size) ?>" >
                 <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $dropcap_element_size) ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_dropcap {{attributes}}]{{content}}[/wp_rem_cs_dropcap]" style="display: none;"">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_dropcap_edit')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
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
                                'std' => esc_html($wp_rem_cs_dropcap_section_title),
                                'id' => 'wp_rem_cs_dropcap_section_title',
                                'cust_name' => 'wp_rem_cs_dropcap_section_title[]',
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
                                'std' => esc_attr($wp_rem_cs_dropcap_section_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_dropcap_section_subtitle[]',
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
                                'std' => $wp_rem_var_dropcap_align,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_dropcap_align',
                                'cust_name' => 'wp_rem_var_dropcap_align[]',
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
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_dropcaps_content_field_text'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_dropcaps_content_field_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($dropcaps_content),
                                'cust_id' => 'dropcaps_content',
                                'classes' => '',
                                'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                'cust_name' => 'dropcaps_content[]',
                                'return' => true,
                                'wp_rem_cs_editor' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                        ?>

                    </div>
                    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                    <?php } else { ?>
                        <?php
                        $wp_rem_cs_opt_array = array(
                            'std' => 'dropcap',
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'extra_atr' => '',
                            'cust_id' => '',
                            'cust_name' => 'wp_rem_cs_orderby[]',
                            'return' => false,
                            'required' => false
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => '',
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
                                'cust_id' => '',
                                'cust_type' => 'button',
                                'classes' => 'cs-wp_rem_cs-admin-btn',
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
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_dropcap', 'wp_rem_cs_var_page_builder_dropcap');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_dropcap_callback')) {

    /**
     * Save data for dropcap shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_dropcap_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "dropcap" || $widget_type == "cs_dropcap") {

            $shortcode = '';
            $page_element_size = $data['dropcap_element_size'][$counters['wp_rem_cs_global_counter_dropcap']];
            $current_element_size = $data['dropcap_element_size'][$counters['wp_rem_cs_global_counter_dropcap']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['dropcap'][$counters['wp_rem_cs_shortcode_counter_dropcap']]));
                $element_settings = 'dropcap_element_size="' . $current_element_size . '"';
                $reg = '/dropcap_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_dropcap'] ++;
            } else {
                $shortcode = '[wp_rem_cs_dropcap dropcap_element_size="' . htmlspecialchars($data['dropcap_element_size'][$counters['wp_rem_cs_global_counter_dropcap']]) . '" ';
                if (isset($data['wp_rem_cs_dropcap_section_title'][$counters['wp_rem_cs_counter_dropcap']]) && $data['wp_rem_cs_dropcap_section_title'][$counters['wp_rem_cs_counter_dropcap']] != '') {
                    $shortcode .= 'wp_rem_cs_dropcap_section_title="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_dropcap_section_title'][$counters['wp_rem_cs_counter_dropcap']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_var_dropcap_align'][$counters['wp_rem_cs_counter_dropcap']]) && $data['wp_rem_var_dropcap_align'][$counters['wp_rem_cs_counter_dropcap']] != '') {
                    $shortcode .= 'wp_rem_var_dropcap_align="' . stripslashes(htmlspecialchars(($data['wp_rem_var_dropcap_align'][$counters['wp_rem_cs_counter_dropcap']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_dropcap_section_subtitle'][$counters['wp_rem_cs_counter_dropcap']]) && $data['wp_rem_cs_dropcap_section_subtitle'][$counters['wp_rem_cs_counter_dropcap']] != '') {
                    $shortcode .= 'wp_rem_cs_dropcap_section_subtitle="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_dropcap_section_subtitle'][$counters['wp_rem_cs_counter_dropcap']]), ENT_QUOTES)) . '" ';
                }
                $shortcode .= ']';
                if (isset($data['dropcaps_content'][$counters['wp_rem_cs_counter_dropcap']]) && $data['dropcaps_content'][$counters['wp_rem_cs_counter_dropcap']] != '') {
                    $shortcode .= htmlspecialchars($data['dropcaps_content'][$counters['wp_rem_cs_counter_dropcap']], ENT_QUOTES) . ' ';
                }
                $shortcode .= '[/wp_rem_cs_dropcap]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_dropcap'] ++;
            }
            $counters['wp_rem_cs_global_counter_dropcap'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_dropcap', 'wp_rem_cs_save_page_builder_data_dropcap_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_dropcap_callback')) {

    /**
     * Populate dropcap shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_dropcap_callback($counters) {
        $counters['wp_rem_cs_counter_dropcap'] = 0;
        $counters['wp_rem_cs_shortcode_counter_dropcap'] = 0;
        $counters['wp_rem_cs_global_counter_dropcap'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_dropcap_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_dropcap_callback')) {

    /**
     * Populate dropcap shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_dropcap_callback($shortcode_array) {
        $shortcode_array['dropcap'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_dropcap'),
            'name' => 'dropcap',
            'icon' => 'icon-comments-o',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_dropcap_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_dropcap_callback')) {

    /**
     * Populate dropcap shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_dropcap_callback($element_list) {
        $element_list['dropcap'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_dropcap');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_dropcap_callback');
}