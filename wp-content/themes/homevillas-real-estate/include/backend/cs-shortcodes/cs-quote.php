<?php
/**
 * Quotes html form for page builder
 */
if (!function_exists('wp_rem_cs_var_page_builder_quote')) {

    function wp_rem_cs_var_page_builder_quote($die = 0) {
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
            $PREFIX = 'wp_rem_cs_quote';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_quote_section_title' => '',
            'wp_rem_cs_quote_section_subtitle' => '',
            'wp_rem_var_quote_align' => '',
            'wp_rem_cs_quote_cite' => '',
            'wp_rem_cs_quote_cite_url' => '#',
            'wp_rem_cs_author_position' => '',
            'wp_rem_cs_var_quote_image' => ''
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }

        if (isset($output['0']['content'])) {
            $quotes_content = $output['0']['content'];
        } else {
            $quotes_content = '';
        }
        $wp_rem_cs_var_quote_image = isset($wp_rem_cs_var_quote_image) ? $wp_rem_cs_var_quote_image : '';
        $wp_rem_cs_quote_section_title = isset($wp_rem_cs_quote_section_title) ? $wp_rem_cs_quote_section_title : '';
        $wp_rem_cs_quote_cite = isset($quote_cite) ? $quote_cite : '';
        $wp_rem_cs_quote_cite_url = isset($quote_cite_url) ? $quote_cite_url : '';
        $wp_rem_cs_author_position = isset($author_position) ? $author_position : '';

        $quote_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_quote';
        $coloumn_class = 'column_' . $quote_element_size;
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
             <?php echo esc_attr($shortcode_view); ?>" item="quote" data="<?php echo wp_rem_cs_element_size_data_array_index($quote_element_size) ?>" >
                 <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $quote_element_size) ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_quote {{attributes}}]{{content}}[/wp_rem_cs_quote]" style="display: none;"">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_quote_edit')); ?></h5>
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
                                'std' => esc_html($wp_rem_cs_quote_section_title),
                                'id' => 'wp_rem_cs_quote_section_title',
                                'cust_name' => 'wp_rem_cs_quote_section_title[]',
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
                                'std' => esc_attr($wp_rem_cs_quote_section_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_quote_section_subtitle[]',
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
                                'std' => $wp_rem_var_quote_align,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_quote_align',
                                'cust_name' => 'wp_rem_var_quote_align[]',
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
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_quote_cite),
                                'id' => 'wp_rem_cs_quote_cite',
                                'cust_name' => 'wp_rem_cs_quote_cite[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_url'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_url_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_url($wp_rem_cs_quote_cite_url),
                                'id' => 'wp_rem_cs_quote_cite_url',
                                'cust_name' => 'wp_rem_cs_quote_cite_url[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_position'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_position_hint'),
                            'echo' => true,
                            'classes' => 'txtfield',
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_author_position),
                                'id' => 'wp_rem_cs_author_position',
                                'cust_name' => 'wp_rem_cs_author_position[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                        $wp_rem_cs_opt_array = array(
                            'std' => $wp_rem_cs_var_quote_image,
                            'id' => 'quote_image_array',
                            'main_id' => 'quote_image_array',
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author_image'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'array' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_var_quote_image,
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_var_quote_image[]',
                                'id' => 'quote_image_array',
                                'return' => true,
                                'array' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);



                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_text'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_column_field_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($quotes_content),
                                'cust_id' => 'quotes_content',
                                'classes' => '',
                                'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                'cust_name' => 'quotes_content[]',
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
                        <?php
                    } else {
                        $wp_rem_cs_opt_array = array(
                            'std' => 'quote',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_quote', 'wp_rem_cs_var_page_builder_quote');
}


if (!function_exists('wp_rem_cs_save_page_builder_data_quote_callback')) {

    /**
     * Save data for quote shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_quote_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "quote" || $widget_type == "cs_quote") {
            $shortcode = '';
            $page_element_size = $data['quote_element_size'][$counters['wp_rem_cs_global_counter_quote']];
            $current_element_size = $data['quote_element_size'][$counters['wp_rem_cs_global_counter_quote']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['quote'][$counters['wp_rem_cs_shortcode_counter_quote']]));
                $element_settings = 'quote_element_size="' . $current_element_size . '"';
                $reg = '/quote_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_quote'] ++;
            } else {
                $shortcode = '[wp_rem_cs_quote quote_element_size="' . htmlspecialchars($data['quote_element_size'][$counters['wp_rem_cs_global_counter_quote']]) . '" ';
                if (isset($data['wp_rem_cs_quote_section_title'][$counters['wp_rem_cs_counter_quote']]) && $data['wp_rem_cs_quote_section_title'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= 'wp_rem_cs_quote_section_title="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_quote_section_title'][$counters['wp_rem_cs_counter_quote']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_quote_section_subtitle'][$counters['wp_rem_cs_counter_quote']]) && $data['wp_rem_cs_quote_section_subtitle'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= 'wp_rem_cs_quote_section_subtitle="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_quote_section_subtitle'][$counters['wp_rem_cs_counter_quote']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_var_quote_align'][$counters['wp_rem_cs_counter_quote']]) && $data['wp_rem_var_quote_align'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= 'wp_rem_var_quote_align="' . stripslashes(htmlspecialchars(($data['wp_rem_var_quote_align'][$counters['wp_rem_cs_counter_quote']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_quote_image'][$counters['wp_rem_cs_counter_quote']]) && $data['wp_rem_cs_var_quote_image'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= 'wp_rem_cs_var_quote_image="' . htmlspecialchars($data['wp_rem_cs_var_quote_image'][$counters['wp_rem_cs_counter_quote']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_quote_cite'][$counters['wp_rem_cs_counter_quote']]) && $data['wp_rem_cs_quote_cite'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= 'wp_rem_cs_quote_cite="' . htmlspecialchars($data['wp_rem_cs_quote_cite'][$counters['wp_rem_cs_counter_quote']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_quote_cite_url'][$counters['wp_rem_cs_counter_quote']]) && $data['wp_rem_cs_quote_cite_url'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= 'wp_rem_cs_quote_cite_url="' . htmlspecialchars($data['wp_rem_cs_quote_cite_url'][$counters['wp_rem_cs_counter_quote']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_author_position'][$counters['wp_rem_cs_counter_quote']]) && $data['wp_rem_cs_author_position'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= 'wp_rem_cs_author_position="' . htmlspecialchars($data['wp_rem_cs_author_position'][$counters['wp_rem_cs_counter_quote']], ENT_QUOTES) . '" ';
                }
                $shortcode .= ']';
                if (isset($data['quotes_content'][$counters['wp_rem_cs_counter_quote']]) && $data['quotes_content'][$counters['wp_rem_cs_counter_quote']] != '') {
                    $shortcode .= htmlspecialchars($data['quotes_content'][$counters['wp_rem_cs_counter_quote']], ENT_QUOTES) . ' ';
                }
                $shortcode .= '[/wp_rem_cs_quote]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_quote'] ++;
            }
            $counters['wp_rem_cs_global_counter_quote'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_quote', 'wp_rem_cs_save_page_builder_data_quote_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_quote_callback')) {

    /**
     * Populate quote shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_quote_callback($counters) {
        $counters['wp_rem_cs_counter_quote'] = 0;
        $counters['wp_rem_cs_shortcode_counter_quote'] = 0;
        $counters['wp_rem_cs_global_counter_quote'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_quote_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_quote_callback')) {

    /**
     * Populate quote shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_quote_callback($shortcode_array) {
        $shortcode_array['quote'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_quote'),
            'name' => 'quote',
            'icon' => 'icon-comments-o',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_quote_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_quote_callback')) {

    /**
     * Populate quote shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_quote_callback($element_list) {
        $element_list['quote'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_quote');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_quote_callback');
}