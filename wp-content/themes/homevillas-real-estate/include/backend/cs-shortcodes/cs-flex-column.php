<?php
/*
 *
 * @File : Flex column
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_flex_column')) {

    function wp_rem_cs_var_page_builder_flex_column($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
        if (function_exists('wp_rem_cs_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $PREFIX = 'wp_rem_cs_column';
            $counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            $wp_rem_cs_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
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
                'wp_rem_cs_var_column_section_title' => '',
                'wp_rem_cs_var_column_section_subtitle' => '',
                'wp_rem_cs_column_margin_left' => '',
                'wp_rem_var_column_align' => '',
                'wp_rem_cs_column_margin_right' => '',
                'wp_rem_cs_var_column_top_padding' => '',
                'wp_rem_cs_var_column_bottom_padding' => '',
                'wp_rem_cs_var_column_left_padding' => '',
                'wp_rem_cs_var_column_right_padding' => '',
                'wp_rem_cs_var_column_image_url_array' => '',
                'wp_rem_cs_var_column_bg_color' => '',
                'wp_rem_cs_var_column_title_color' => '',
            );
            if (isset($wp_rem_cs_output['0']['atts'])) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rem_cs_output['0']['content'])) {
                $wp_rem_cs_var_column_text = $wp_rem_cs_output['0']['content'];
            } else {
                $wp_rem_cs_var_column_text = '';
            }
            $flex_column_element_size = '33';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_flex_column';
            $coloumn_class = 'column_' . $flex_column_element_size;

            $wp_rem_cs_var_column_section_title = isset($wp_rem_cs_var_column_section_title) ? $wp_rem_cs_var_column_section_title : '';
            $wp_rem_cs_column_margin_left = isset($wp_rem_cs_column_margin_left) ? $wp_rem_cs_column_margin_left : '';
            $wp_rem_cs_column_margin_right = isset($wp_rem_cs_column_margin_right) ? $wp_rem_cs_column_margin_right : '';
            $wp_rem_cs_var_column_top_padding = isset($wp_rem_cs_var_column_top_padding) ? $wp_rem_cs_var_column_top_padding : '';
            $wp_rem_cs_var_column_bottom_padding = isset($wp_rem_cs_var_column_bottom_padding) ? $wp_rem_cs_var_column_bottom_padding : '';
            $wp_rem_cs_var_column_left_padding = isset($wp_rem_cs_var_column_left_padding) ? $wp_rem_cs_var_column_left_padding : '';
            $wp_rem_cs_var_column_right_padding = isset($wp_rem_cs_var_column_right_padding) ? $wp_rem_cs_var_column_right_padding : '';
            $wp_rem_cs_var_column_image_url_array = isset($wp_rem_cs_var_column_image_url_array) ? $wp_rem_cs_var_column_image_url_array : '';
            $wp_rem_cs_var_column_bg_color = isset($wp_rem_cs_var_column_bg_color) ? $wp_rem_cs_var_column_bg_color : '';
            $wp_rem_cs_var_column_title_color = isset($wp_rem_cs_var_column_title_color) ? $wp_rem_cs_var_column_title_color : '';

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
                 <?php echo esc_attr($shortcode_view); ?>" item="flex_column" data="<?php echo wp_rem_cs_element_size_data_array_index($flex_column_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $flex_column_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_column {{attributes}}]{{content}}[/wp_rem_cs_column]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_edit_options')); ?></h5>
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
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_title'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_section_title),
                                    'cust_id' => 'wp_rem_cs_var_column_section_title' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_column_section_title[]',
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
                                    'std' => esc_attr($wp_rem_cs_var_column_section_subtitle),
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_column_section_subtitle[]',
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
                                    'std' => $wp_rem_var_column_align,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_var_column_align',
                                    'cust_name' => 'wp_rem_var_column_align[]',
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
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_color_text'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_title_color),
                                    'cust_id' => 'wp_rem_cs_var_column_title_color' . $wp_rem_cs_counter,
                                    'classes' => 'bg_color',
                                    'cust_name' => 'wp_rem_cs_var_column_title_color[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_text'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_text_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_text),
                                    'cust_id' => 'wp_rem_cs_var_column_text' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                    'cust_name' => 'wp_rem_cs_var_column_text[]',
                                    'return' => true,
                                    'wp_rem_cs_editor' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_margin_left'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_margin_left_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_column_margin_left),
                                    'cust_id' => 'wp_rem_cs_column_margin_left' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_column_margin_left[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_margin_right'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_margin_right_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_column_margin_right),
                                    'cust_id' => 'wp_rem_cs_column_margin_right' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_column_margin_right[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_top_padding'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_top_padding_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_top_padding),
                                    'cust_id' => 'wp_rem_cs_var_column_top_padding' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_column_top_padding[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_bottom_padding'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_bottom_padding_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_bottom_padding),
                                    'cust_id' => 'wp_rem_cs_var_column_bottom_padding' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_column_bottom_padding[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_left_padding_text'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_left_padding_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_left_padding),
                                    'cust_id' => 'wp_rem_cs_var_column_left_padding' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_column_left_padding[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_right_padding_text'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_right_padding_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_right_padding),
                                    'cust_id' => 'wp_rem_cs_var_column_right_padding' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_column_right_padding[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => esc_attr($wp_rem_cs_var_column_image_url_array),
                                'id' => 'column_image_url',
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_image_text'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_image_hint'),
                                'echo' => true,
                                'array' => true,
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_image_url_array),
                                    'id' => 'column_image_url',
                                    'return' => true,
                                    'array' => true,
                                    'array_txt' => false,
                                    'prefix' => '',
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_background_color_text'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_column_bg_color),
                                    'cust_id' => 'wp_rem_cs_var_column_bg_color' . $wp_rem_cs_counter,
                                    'classes' => 'bg_color',
                                    'cust_name' => 'wp_rem_cs_var_column_bg_color[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
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
                                'std' => 'flex_column',
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
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
                                    'cust_id' => 'flex_column_save' . $wp_rem_cs_counter,
                                    'cust_type' => 'button',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'cust_name' => 'flex_column_save',
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
        }
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_flex_column', 'wp_rem_cs_var_page_builder_flex_column');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_flex_column_callback')) {

    /**
     * Save data for flex column shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_flex_column_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "flex_column" || $widget_type == "cs_flex_column") {
            $shortcode = '';
            $page_element_size = $data['flex_column_element_size'][$counters['wp_rem_cs_global_counter_column']];
            $current_element_size = $data['flex_column_element_size'][$counters['wp_rem_cs_global_counter_column']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['flex_column'][$counters['wp_rem_cs_shortcode_counter_column']]));
                $element_settings = 'flex_column_element_size="' . $current_element_size . '"';
                $reg = '/flex_column_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_column'] ++;
            } else {
                $shortcode = '[wp_rem_cs_column flex_column_element_size="' . htmlspecialchars($data['flex_column_element_size'][$counters['wp_rem_cs_global_counter_column']]) . '" ';
                if (isset($data['wp_rem_cs_var_column_section_title'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_section_title'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_section_title="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_column_section_title'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_var_column_align'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_var_column_align'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_var_column_align="' . stripslashes(htmlspecialchars(($data['wp_rem_var_column_align'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_section_subtitle'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_section_subtitle'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_section_subtitle="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_column_section_subtitle'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_column_margin_left'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_column_margin_left'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_column_margin_left="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_column_margin_left'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_column_margin_right'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_column_margin_right'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_column_margin_right="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_column_margin_right'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_top_padding'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_top_padding'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_top_padding="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_column_top_padding'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_bottom_padding'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_bottom_padding'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_bottom_padding="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_column_bottom_padding'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_left_padding'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_left_padding'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_left_padding="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_column_left_padding'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_right_padding'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_right_padding'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_right_padding="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_column_right_padding'][$counters['wp_rem_cs_counter_column']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_image_url_array'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_image_url_array'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_image_url_array="' . htmlspecialchars($data['wp_rem_cs_var_column_image_url_array'][$counters['wp_rem_cs_counter_column']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_title_color'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_title_color'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_title_color="' . htmlspecialchars($data['wp_rem_cs_var_column_title_color'][$counters['wp_rem_cs_counter_column']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_column_bg_color'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_bg_color'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= 'wp_rem_cs_var_column_bg_color="' . htmlspecialchars($data['wp_rem_cs_var_column_bg_color'][$counters['wp_rem_cs_counter_column']], ENT_QUOTES) . '" ';
                }
                $shortcode .= ']';
                if (isset($data['wp_rem_cs_var_column_text'][$counters['wp_rem_cs_counter_column']]) && $data['wp_rem_cs_var_column_text'][$counters['wp_rem_cs_counter_column']] != '') {
                    $shortcode .= htmlspecialchars($data['wp_rem_cs_var_column_text'][$counters['wp_rem_cs_counter_column']], ENT_QUOTES) . ' ';
                }
                $shortcode .= '[/wp_rem_cs_column]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_column'] ++;
            }
            $counters['wp_rem_cs_global_counter_column'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_flex_column', 'wp_rem_cs_save_page_builder_data_flex_column_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_flex_column_callback')) {

    /**
     * Populate flex column shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_flex_column_callback($counters) {
        $counters['wp_rem_cs_global_counter_column'] = 0;
        $counters['wp_rem_cs_shortcode_counter_column'] = 0;
        $counters['wp_rem_cs_counter_column'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_flex_column_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_flex_column_callback')) {

    /**
     * Populate flex column shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_flex_column_callback($shortcode_array) {
        $shortcode_array['flex_column'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_column'),
            'name' => 'flex_column',
            'icon' => 'icon-columns',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_flex_column_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_flex_column_callback')) {

    /**
     * Populate flex column shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_flex_column_callback($element_list) {
        $element_list['flex_column'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_column');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_flex_column_callback');
}