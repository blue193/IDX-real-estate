<?php
/*
 *
 * @File : Image Frame 
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_image_frame')) {

    function wp_rem_cs_var_page_builder_image_frame($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $coloumn_class, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;

        if (function_exists('wp_rem_cs_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $PREFIX = 'wp_rem_cs_image_frame';

            $wp_rem_cs_counter = isset($_POST['wp_rem_cs_counter']) ? $_POST['wp_rem_cs_counter'] : '';
            $wp_rem_cs_counter = ($wp_rem_cs_counter == '') ? $_POST['counter'] : $wp_rem_cs_counter;

            if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
                $POSTID = '';
                $shortcode_element_id = '';
            } else {
                $POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
                $shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
                $shortcode_str = stripslashes($shortcode_element_id);
                $parseObject = new ShortcodeParse();
                $wp_rem_cs_output = $parseObject->wp_rem_cs_shortcodes($wp_rem_cs_output, $shortcode_str, true, $PREFIX);
            }
            $defaults = array(
                'wp_rem_cs_var_column' => '',
                'wp_rem_cs_var_image_section_title' => '',
                'wp_rem_cs_var_image_section_subtitle' => '',
                'wp_rem_cs_var_image_title' => '',
                'wp_rem_cs_var_img_align' => '',
                'wp_rem_cs_var_img_style' => '',
                'wp_rem_var_image_title_align' => '',
                'wp_rem_cs_var_frame_image_url_array' => '',
            );
            if (isset($wp_rem_cs_output['0']['atts'])) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rem_cs_output['0']['content'])) {
                $wp_rem_cs_var_image_description = $wp_rem_cs_output['0']['content'];
            } else {
                $wp_rem_cs_var_image_description = '';
            }
            $image_frame_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_image_frame';
            $coloumn_class = 'column_' . $image_frame_element_size;
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }

            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_short_code_strings();
            $wp_rem_cs_var_image_section_title = isset($wp_rem_cs_var_image_section_title) ? $wp_rem_cs_var_image_section_title : '';
            $wp_rem_cs_var_image_title = isset($wp_rem_cs_var_image_title) ? $wp_rem_cs_var_image_title : '';
            $wp_rem_cs_var_img_align = isset($wp_rem_cs_var_img_align) ? $wp_rem_cs_var_img_align : 'simple';
            $wp_rem_cs_var_img_style = isset($wp_rem_cs_var_img_style) ? $wp_rem_cs_var_img_style : '';
            $wp_rem_cs_var_frame_image_url_array = isset($wp_rem_cs_var_frame_image_url_array) ? $wp_rem_cs_var_frame_image_url_array : '';
            ?>
            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="image_frame" data="<?php echo wp_rem_cs_element_size_data_array_index($image_frame_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $image_frame_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_image_frame {{attributes}}]{{content}}[/wp_rem_cs_image_frame]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_edit_options')); ?></h5>
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
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_name'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_name_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_image_section_title),
                                    'cust_id' => 'wp_rem_cs_var_image_section_title' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_image_section_title[]',
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
                                    'std' => esc_attr($wp_rem_cs_var_image_section_subtitle),
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_image_section_subtitle[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_title'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_image_title),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'wp_rem_cs_var_image_title[]',
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
                                    'std' => $wp_rem_var_image_title_align,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_var_image_title_align',
                                    'cust_name' => 'wp_rem_var_image_title_align[]',
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
                                'std' => esc_url($wp_rem_cs_var_frame_image_url_array),
                                'id' => 'frame_image_url',
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_url'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_url_hint'),
                                'echo' => true,
                                'array' => true,
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => esc_url($wp_rem_cs_var_frame_image_url_array),
                                    'id' => 'frame_image_url',
                                    'return' => true,
                                    'array' => true,
                                    'array_txt' => false,
                                    'prefix' => '',
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_alignment'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_alignment_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_var_img_align,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_cs_var_img_align[]',
                                    'classes' => 'dropdown chosen-select',
                                    'options' => array(
                                        'left' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_left'),
                                        'right' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_right'),
                                        'center' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_center'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_style'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_var_img_style,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_cs_var_img_style[]',
                                    'classes' => 'dropdown chosen-select',
                                    'options' => array(
                                        'simple' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_simple'),
                                        'featured' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_featured'),
                                        'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_modern'),
                                        'default' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_frame_default'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_desc'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_desc_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_textarea($wp_rem_cs_var_image_description),
                                    'cust_id' => 'wp_rem_cs_var_image_description' . $wp_rem_cs_counter,
                                    'classes' => 'textarea',
                                    'cust_name' => 'wp_rem_cs_var_image_description[]',
                                    'return' => true,
                                    'wp_rem_cs_editor' => true,
                                    'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'image_frame',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
                                'cust_name' => 'wp_rem_cs_orderby[]',
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
                                    'cust_id' => 'image_frame_save',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'cust_name' => 'image_frame_save' . $wp_rem_cs_counter,
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
        }
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_image_frame', 'wp_rem_cs_var_page_builder_image_frame');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_image_frame_callback')) {

    /**
     * Save data for image frame shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_image_frame_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "image_frame" || $widget_type == "cs_image_frame") {
            $wp_rem_cs_var_image_frame = '';
            $page_element_size = $data['image_frame_element_size'][$counters['wp_rem_cs_global_counter_image_frame']];
            $current_element_size = $data['image_frame_element_size'][$counters['wp_rem_cs_global_counter_image_frame']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['image_frame'][$counters['wp_rem_cs_shortcode_counter_image_frame']]));

                $element_settings = 'image_frame_element_size="' . $current_element_size . '"';
                $reg = '/image_frame_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_image_frame'] ++;
            } else {
                $wp_rem_cs_var_image_frame = '[wp_rem_cs_image_frame image_frame_element_size="' . htmlspecialchars($data['image_frame_element_size'][$counters['wp_rem_cs_global_counter_image_frame']]) . '" ';
                if (isset($data['wp_rem_cs_var_image_section_title'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_cs_var_image_section_title'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= 'wp_rem_cs_var_image_section_title="' . htmlspecialchars($data['wp_rem_cs_var_image_section_title'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_image_title_align'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_var_image_title_align'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= 'wp_rem_var_image_title_align="' . htmlspecialchars($data['wp_rem_var_image_title_align'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_image_section_subtitle'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_cs_var_image_section_subtitle'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= 'wp_rem_cs_var_image_section_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_image_section_subtitle'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_image_title'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_cs_var_image_title'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= 'wp_rem_cs_var_image_title="' . htmlspecialchars($data['wp_rem_cs_var_image_title'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_img_align'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_cs_var_img_align'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= 'wp_rem_cs_var_img_align="' . htmlspecialchars($data['wp_rem_cs_var_img_align'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_img_style'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_cs_var_img_style'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= 'wp_rem_cs_var_img_style="' . htmlspecialchars($data['wp_rem_cs_var_img_style'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_frame_image_url_array'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_cs_var_frame_image_url_array'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= 'wp_rem_cs_var_frame_image_url_array="' . htmlspecialchars($data['wp_rem_cs_var_frame_image_url_array'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_var_image_frame .= ']';
                if (isset($data['wp_rem_cs_var_image_description'][$counters['wp_rem_cs_counter_image_frame']]) && $data['wp_rem_cs_var_image_description'][$counters['wp_rem_cs_counter_image_frame']] != '') {
                    $wp_rem_cs_var_image_frame .= htmlspecialchars($data['wp_rem_cs_var_image_description'][$counters['wp_rem_cs_counter_image_frame']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_var_image_frame .= '[/wp_rem_cs_image_frame]';
                $shortcode_data .= $wp_rem_cs_var_image_frame;
                $counters['wp_rem_cs_counter_image_frame'] ++;
            }
            $counters['wp_rem_cs_global_counter_image_frame'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_image_frame', 'wp_rem_cs_save_page_builder_data_image_frame_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_image_frame_callback')) {

    /**
     * Populate image frame shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_image_frame_callback($counters) {
        $counters['wp_rem_cs_global_counter_image_frame'] = 0;
        $counters['wp_rem_cs_shortcode_counter_image_frame'] = 0;
        $counters['wp_rem_cs_counter_image_frame'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_image_frame_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_image_frame_callback')) {

    /**
     * Populate image frame shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_image_frame_callback($shortcode_array) {
        $shortcode_array['image_frame'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image_frame'),
            'name' => 'image_frame',
            'icon' => 'icon-photo',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_image_frame_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_image_frame_callback')) {

    /**
     * Populate image frame shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_image_frame_callback($element_list) {
        $element_list['image_frame'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image_frame');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_image_frame_callback');
}