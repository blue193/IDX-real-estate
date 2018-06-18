<?php
/*
 *
 * @File : Contact Us Short Code
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_contact_form')) {

    function wp_rem_cs_var_page_builder_contact_form($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;

        if (function_exists('wp_rem_cs_shortcode_names')) {

            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $PREFIX = 'wp_rem_cs_contact_form';
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
                'wp_rem_cs_var_contact_us_element_title' => '',
                'wp_rem_cs_var_contact_us_element_subtitle' => '',
                'wp_rem_var_contact_us_align' => '',
                'wp_rem_cs_var_contact_us_element_send' => '',
                'wp_rem_cs_var_contact_us_element_success' => '',
                'wp_rem_cs_var_contact_us_element_error' => '',
            );
            if (isset($wp_rem_cs_output['0']['atts'])) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rem_cs_output['0']['content'])) {
                $contact_us_text = $wp_rem_cs_output['0']['content'];
            } else {
                $contact_us_text = '';
            }
            $contact_form_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_contact_form';
            $coloumn_class = 'column_' . $contact_form_element_size;
            $wp_rem_cs_var_contact_us_element_title = isset($wp_rem_cs_var_contact_us_element_title) ? $wp_rem_cs_var_contact_us_element_title : '';
            $wp_rem_cs_var_contact_us_element_send = isset($wp_rem_cs_var_contact_us_element_send) ? $wp_rem_cs_var_contact_us_element_send : '';
            $wp_rem_cs_var_contact_us_element_success = isset($wp_rem_cs_var_contact_us_element_success) ? $wp_rem_cs_var_contact_us_element_success : '';
            $wp_rem_cs_var_contact_us_element_error = isset($wp_rem_cs_var_contact_us_element_error) ? $wp_rem_cs_var_contact_us_element_error : '';

            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_short_code_strings();
            ?>
            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="contact_form" data="<?php echo wp_rem_cs_element_size_data_array_index($contact_form_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $contact_form_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_contact_form {{attributes}}]{{content}}[/wp_rem_cs_contact_form]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo esc_html(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_edit_form')); ?></h5>
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
                                'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_element_title'),
                                'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_element_title_hint'),
                                'desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_contact_us_element_title),
                                    'cust_id' => 'wp_rem_cs_var_contact_us_element_title' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_contact_us_element_title[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_element_subtitle'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_element_subtitle_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_contact_us_element_subtitle),
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_contact_us_element_subtitle[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_cs_var_frame_text_srt('wp_rem_var_title_alignment'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_var_title_alignment_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_var_contact_us_align,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_var_contact_us_align',
                                    'cust_name' => 'wp_rem_var_contact_us_align[]',
                                    'classes' => 'service_postion chosen-select-no-single select-medium',
                                    'options' => array(
                                        'align-left' => wp_rem_cs_var_frame_text_srt('wp_rem_var_align_left'),
                                        'align-right' => wp_rem_cs_var_frame_text_srt('wp_rem_var_align_right'),
                                        'align-center' => wp_rem_cs_var_frame_text_srt('wp_rem_var_align_center'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);



                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_send_to'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_send_to_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_contact_us_element_send),
                                    'cust_id' => 'wp_rem_cs_var_contact_us_element_send' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_contact_us_element_send[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_success_message'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_success_message_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_contact_us_element_success),
                                    'cust_id' => 'wp_rem_cs_var_contact_us_element_success' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_contact_us_element_success[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_error_message'),
                                'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_error_message_hint'),
                                'desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_contact_us_element_error),
                                    'cust_id' => 'wp_rem_cs_var_contact_us_element_error' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_contact_us_element_error[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_insert')); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'contact_form',
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
                                    'std' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_save'),
                                    'cust_id' => 'contact_form_save' . $wp_rem_cs_counter,
                                    'cust_type' => 'button',
                                    'classes' => '',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'cust_name' => 'contact_from_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_contact_form', 'wp_rem_cs_var_page_builder_contact_form');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_contact_form_callback')) {

    /**
     * Save data for contact_form shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_contact_form_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        if ($widget_type == "contact_form" || $widget_type == "cs_contact_form") {
            $shortcode = '';

            $page_element_size = $data['contact_form_element_size'][$counters['wp_rem_cs_global_counter_contact_us']];
            $contact_element_size = $data['contact_form_element_size'][$counters['wp_rem_cs_global_counter_contact_us']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['contact_form'][$counters['wp_rem_cs_shortcode_counter_contact_us']]));

                $element_settings = 'contact_form_element_size="' . $contact_element_size . '"';
                $reg = '/contact_form_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data .= $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_contact_us'] ++;
            } else {
                $shortcode = '[wp_rem_cs_contact_form contact_form_element_size="' . htmlspecialchars($data['contact_form_element_size'][$counters['wp_rem_cs_global_counter_contact_us']]) . '" ';
                if (isset($data['wp_rem_cs_var_contact_us_element_title'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_contact_us_element_title'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_contact_us_element_title="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_contact_us_element_title'][$counters['wp_rem_cs_counter_contact_us']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_contact_us_element_subtitle'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_contact_us_element_subtitle'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_contact_us_element_subtitle="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_contact_us_element_subtitle'][$counters['wp_rem_cs_counter_contact_us']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_var_contact_us_align'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_var_contact_us_align'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_var_contact_us_align="' . stripslashes(htmlspecialchars(($data['wp_rem_var_contact_us_align'][$counters['wp_rem_cs_counter_contact_us']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_text_us'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_text_us'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_text_us="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_text_us'][$counters['wp_rem_cs_counter_contact_us']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_us'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_call_us'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_us="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_us'][$counters['wp_rem_cs_counter_contact_us']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_address'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_address'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_address="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_address'][$counters['wp_rem_cs_counter_contact_us']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_form_title'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_form_title'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_form_title="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_form_title'][$counters['wp_rem_cs_counter_contact_us']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_contact_us_element_send'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_contact_us_element_send'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_contact_us_element_send="' . htmlspecialchars($data['wp_rem_cs_var_contact_us_element_send'][$counters['wp_rem_cs_counter_contact_us']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_contact_us_element_success'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_contact_us_element_success'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_contact_us_element_success="' . htmlspecialchars($data['wp_rem_cs_var_contact_us_element_success'][$counters['wp_rem_cs_counter_contact_us']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_contact_us_element_error'][$counters['wp_rem_cs_counter_contact_us']]) && $data['wp_rem_cs_var_contact_us_element_error'][$counters['wp_rem_cs_counter_contact_us']] != '') {
                    $shortcode .= 'wp_rem_cs_var_contact_us_element_error="' . htmlspecialchars($data['wp_rem_cs_var_contact_us_element_error'][$counters['wp_rem_cs_counter_contact_us']], ENT_QUOTES) . '" ';
                }
                $shortcode .= ']';
                $shortcode .= '[/wp_rem_cs_contact_form]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_contact_us'] ++;
            }
            $counters['wp_rem_cs_global_counter_contact_us'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_contact_form', 'wp_rem_cs_save_page_builder_data_contact_form_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_contact_form_callback')) {

    /**
     * Populate contact_form shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_contact_form_callback($counters) {
        $counters['wp_rem_cs_global_counter_contact_us'] = 0;
        $counters['wp_rem_cs_shortcode_counter_contact_us'] = 0;
        $counters['wp_rem_cs_counter_contact_us'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_contact_form_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_contact_form_callback')) {

    /**
     * Populate contact form shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_contact_form_callback($shortcode_array) {
        $shortcode_array['contact_form'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_contact_form'),
            'name' => 'contact_form',
            'icon' => 'icon-building-o',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_contact_form_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_contact_form_callback')) {

    /**
     * Populate contact form shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_contact_form_callback($element_list) {
        $element_list['contact_form'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_contact_form');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_contact_form_callback');
}