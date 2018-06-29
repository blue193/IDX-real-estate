<?php
/*
 *
 * @File : Call to action
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_call_to_action')) {

    function wp_rem_cs_var_page_builder_call_to_action($die = 0) {

        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;

        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $PREFIX = 'call_to_action';
        $wp_rem_cs_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
        $parseObject = new ShortcodeParse();
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $wp_rem_cs_var_shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->wp_rem_cs_shortcodes($output, $wp_rem_cs_var_shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_call_to_action_title' => '',
            'wp_rem_cs_var_call_to_action_subtitle' => '',
            'wp_rem_var_call_to_action_align' => '',
            'wp_rem_cs_var_call_action_subtitle' => '',
            'wp_rem_cs_var_heading_color' => '#000',
            'wp_rem_cs_var_call_to_action_icon_background_color' => '',
            'wp_rem_cs_var_call_to_action_button_text' => '',
            'wp_rem_cs_var_call_to_action_button_link' => '#',
            'wp_rem_cs_var_contents_bg_color' => '',
            'wp_rem_cs_var_call_to_action_img_array' => '',
            'wp_rem_cs_var_call_action_text_align' => '',
            'wp_rem_cs_var_call_action_img_align' => '',
            'wp_rem_cs_var_button_bg_color' => '',
            'wp_rem_cs_var_button_border_color' => '',
            'wp_rem_var_call_to_action_style'=>'',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content']))
            $atts_content = $output['0']['content'];
        else
            $atts_content = "";
        $call_to_action_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $name = 'wp_rem_cs_var_page_builder_call_to_action';
        $coloumn_class = 'column_' . $call_to_action_element_size;

        $wp_rem_cs_var_call_to_action_title = isset($wp_rem_cs_var_call_to_action_title) ? $wp_rem_cs_var_call_to_action_title : '';
        $wp_rem_cs_var_call_action_subtitle = isset($wp_rem_cs_var_call_action_subtitle) ? $wp_rem_cs_var_call_action_subtitle : '';
        $wp_rem_cs_var_heading_color = isset($wp_rem_cs_var_heading_color) ? $wp_rem_cs_var_heading_color : '';
        $wp_rem_cs_var_call_to_action_icon_background_color = isset($wp_rem_cs_var_call_to_action_icon_background_color) ? $wp_rem_cs_var_call_to_action_icon_background_color : '';
        $wp_rem_cs_var_call_to_action_button_text = isset($wp_rem_cs_var_call_to_action_button_text) ? $wp_rem_cs_var_call_to_action_button_text : '';
        $wp_rem_cs_var_call_to_action_button_link = isset($wp_rem_cs_var_call_to_action_button_link) ? $wp_rem_cs_var_call_to_action_button_link : '';
        $wp_rem_cs_var_contents_bg_color = isset($wp_rem_cs_var_contents_bg_color) ? $wp_rem_cs_var_contents_bg_color : '';
        $wp_rem_cs_var_call_to_action_img_array = isset($wp_rem_cs_var_call_to_action_img_array) ? $wp_rem_cs_var_call_to_action_img_array : '';
        $wp_rem_cs_var_call_action_text_align = isset($wp_rem_cs_var_call_action_text_align) ? $wp_rem_cs_var_call_action_text_align : '';
        $wp_rem_cs_var_call_action_img_align = isset($wp_rem_cs_var_call_action_img_align) ? $wp_rem_cs_var_call_action_img_align : '';
        $wp_rem_cs_var_button_bg_color = isset($wp_rem_cs_var_button_bg_color) ? $wp_rem_cs_var_button_bg_color : '';
        $wp_rem_cs_var_button_border_color = isset($wp_rem_cs_var_button_border_color) ? $wp_rem_cs_var_button_border_color : '';

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
             <?php echo esc_attr($shortcode_view); ?>" item="call_to_action" data="<?php echo wp_rem_cs_element_size_data_array_index($call_to_action_element_size) ?>" >
                 <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $call_to_action_element_size) ?>
            <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                 <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[call_to_action {{attributes}}]{{content}}[/call_to_action]" style="display: none;">
                <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_call_to_action_edit')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
                        <i class="icon-cross"></i>
                    </a>
                </div> 
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
                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_call_to_action_title),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_var_call_to_action_title[]',
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
                                'std' => esc_attr($wp_rem_cs_var_call_to_action_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_var_call_to_action_subtitle[]',
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
                                'std' => $wp_rem_var_call_to_action_align,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_call_to_action_align',
                                'cust_name' => 'wp_rem_var_call_to_action_align[]',
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
                        
                        $wp_rem_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_call_to_action_style'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_var_call_to_action_style,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_call_to_action_style',
                                'cust_name' => 'wp_rem_var_call_to_action_style[]',
                                'classes' => 'service_postion chosen-select-no-single select-medium',
                                'options' => array(
                                    'default' => wp_rem_cs_var_theme_text_srt('wp_rem_call_to_action_style_default'),
                                    'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_call_to_action_style_classic'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
                        
                        
                        

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_call_action_subtitle),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_var_call_action_subtitle[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_color'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_title_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_heading_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'wp_rem_cs_var_heading_color[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_short_text'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_short_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_textarea($atts_content),
                                'cust_id' => 'atts_content' . $wp_rem_cs_counter,
                                'classes' => '',
                                'cust_name' => 'atts_content[]',
                                'return' => true,
                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                'wp_rem_cs_editor' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bgcolor'),
                            'desc' => '',
                            'id' => 'call_to_action_id',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bg_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_contents_bg_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'wp_rem_cs_var_contents_bg_color[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'std' => $wp_rem_cs_var_call_to_action_img_array,
                            'id' => 'call_to_action_img',
                            'main_id' => 'call_to_action_img_id',
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_background_image'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_bg_image_hint'),
                            'echo' => true,
                            'array' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_var_call_to_action_img_array,
                                'cust_id' => '',
                                'id' => 'call_to_action_img',
                                'return' => true,
                                'array' => true,
                                'array_txt' => false,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_position'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_var_call_action_img_align,
                                'cust_id' => '',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'cust_name' => 'wp_rem_cs_var_call_action_img_align[]',
                                'options' => array(
                                    "no-repeat center top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_center_top'),
                                    "repeat center top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_repeat_center_top'),
                                    "no-repeat center" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_center'),
                                    "Repeat Center" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_repeat_center'),
                                    "no-repeat left top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_left_top'),
                                    "repeat left top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_repeat_left_top'),
                                    "no-repeat fixed center" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_fixed_center'),
                                    "no-repeat center / cover" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_fixed_center_cover')
                                ),
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_call_to_action_button_bg'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_call_to_action_button_bg_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_button_bg_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'wp_rem_cs_var_button_bg_color[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_call_to_action_button_border'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_call_to_action_button_border_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_button_border_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'wp_rem_cs_var_button_border_color[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_color'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_call_to_action_icon_background_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'wp_rem_cs_var_call_to_action_icon_background_color[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_text'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_call_to_action_button_text),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_var_call_to_action_button_text[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_link'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_button_link_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_call_to_action_button_link),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_var_call_to_action_button_link[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_align'),
                            'desc' => '',
                            'hint_text' => '',
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_call_action_text_align),
                                'cust_id' => '',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'cust_name' => 'wp_rem_cs_var_call_action_text_align[]',
                                'options' => array('center' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_center_align'), 'left' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_left_align'), 'right' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_right_align')),
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        ?>

                    </div>
                    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>

                        <ul class="form-elements insert-bg">
                            <li class="to-field">
                                <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a>
                            </li>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'call_to_action',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                'cust_id' => 'wp_rem_cs_orderby',
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
                                    'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
                                    'cust_id' => '',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-barber-admin-btn',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_call_to_action', 'wp_rem_cs_var_page_builder_call_to_action');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_call_to_action_callback')) {

    /**
     * Save data for call to action shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_call_to_action_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "call_to_action" || $widget_type == "cs_call_to_action") {

            $shortcode = '';

            $page_element_size = $data['call_to_action_element_size'][$counters['wp_rem_cs_global_counter_call_to_action']];
            $cta_element_size = $data['call_to_action_element_size'][$counters['wp_rem_cs_global_counter_call_to_action']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['call_to_action'][$counters['wp_rem_cs_shortcode_counter_call_to_action']]));

                $element_settings = 'call_to_action_element_size="' . $cta_element_size . '"';
                $reg = '/call_to_action_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_call_to_action'] ++;
            } else {
                $shortcode = '[call_to_action call_to_action_element_size="' . htmlspecialchars($data['call_to_action_element_size'][$counters['wp_rem_cs_global_counter_call_to_action']]) . '" ';
                if (isset($data['wp_rem_cs_var_call_to_action_title'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_to_action_title'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_to_action_title="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_to_action_title'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_var_call_to_action_style'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_var_call_to_action_style'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_var_call_to_action_style="' . stripslashes(htmlspecialchars(($data['wp_rem_var_call_to_action_style'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_to_action_subtitle'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_to_action_subtitle'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_to_action_subtitle="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_to_action_subtitle'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_var_call_to_action_align'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_var_call_to_action_align'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_var_call_to_action_align="' . stripslashes(htmlspecialchars(($data['wp_rem_var_call_to_action_align'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_action_subtitle'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_action_subtitle'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_action_subtitle="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_action_subtitle'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_button_bg_color'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_button_bg_color'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_button_bg_color="' . htmlspecialchars($data['wp_rem_cs_var_button_bg_color'][$counters['wp_rem_cs_counter_call_to_action']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_button_border_color'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_button_border_color'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_button_border_color="' . htmlspecialchars($data['wp_rem_cs_var_button_border_color'][$counters['wp_rem_cs_counter_call_to_action']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_heading_color'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_heading_color'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_heading_color="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_heading_color'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_to_action_icon_background_color'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_to_action_icon_background_color'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_to_action_icon_background_color="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_to_action_icon_background_color'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_to_action_button_text'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_to_action_button_text'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_to_action_button_text="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_to_action_button_text'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_to_action_button_link'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_to_action_button_link'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_to_action_button_link="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_to_action_button_link'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_contents_bg_color'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_contents_bg_color'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_contents_bg_color="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_contents_bg_color'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_to_action_img_array'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_to_action_img_array'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_to_action_img_array="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_to_action_img_array'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_action_text_align'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_action_text_align'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_action_text_align="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_action_text_align'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_call_action_img_align'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['wp_rem_cs_var_call_action_img_align'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= 'wp_rem_cs_var_call_action_img_align="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_call_action_img_align'][$counters['wp_rem_cs_counter_call_to_action']]), ENT_QUOTES)) . '" ';
                }
                $shortcode .= '] ';
                if (isset($data['atts_content'][$counters['wp_rem_cs_counter_call_to_action']]) && $data['atts_content'][$counters['wp_rem_cs_counter_call_to_action']] != '') {
                    $shortcode .= htmlspecialchars($data['atts_content'][$counters['wp_rem_cs_counter_call_to_action']], ENT_QUOTES) . ' ';
                }
                $shortcode .= '[/call_to_action]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_call_to_action'] ++;
            }
            $counters['wp_rem_cs_global_counter_call_to_action'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_call_to_action', 'wp_rem_cs_save_page_builder_data_call_to_action_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_call_to_action_callback')) {

    /**
     * Populate call to action shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_call_to_action_callback($counters) {
        $counters['wp_rem_cs_counter_call_to_action'] = 0;
        $counters['wp_rem_cs_shortcode_counter_call_to_action'] = 0;
        $counters['wp_rem_cs_global_counter_call_to_action'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_call_to_action_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_call_to_action_callback')) {

    /**
     * Populate call_to_action shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_call_to_action_callback($shortcode_array) {
        $shortcode_array['call_to_action'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_call_action'),
            'name' => 'call_to_action',
            'icon' => 'fa icon-info-circle',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_call_to_action_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_call_to_action_callback')) {

    /**
     * Populate call_to_action shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_call_to_action_callback($element_list) {
        $element_list['call_to_action'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_call_action');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_call_to_action_callback');
}