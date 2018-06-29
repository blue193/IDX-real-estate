<?php
/*
 *
 * @File : Image Frame 
 * @retrun
 *
 */

if (!function_exists('wp_rsm_cs_var_page_builder_about_info')) {

    function wp_rsm_cs_var_page_builder_about_info($die = 0) {
        global $post, $wp_rsm_cs_node, $wp_rsm_cs_var_html_fields, $coloumn_class, $wp_rsm_cs_var_form_fields, $wp_rsm_cs_var_static_text;

        if (function_exists('wp_rsm_cs_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rsm_cs_output = array();
            $PREFIX = 'wp_rsm_cs_about_info';
            $wp_rsm_cs_counter = isset($_POST['wp_rsm_cs_counter']) ? $_POST['wp_rsm_cs_counter'] : '';
            $wp_rsm_cs_counter = ($wp_rsm_cs_counter == '') ? $_POST['counter'] : $wp_rsm_cs_counter;
            if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
                $POSTID = '';
                $shortcode_element_id = '';
            } else {
                $POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
                $shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
                $shortcode_str = stripslashes($shortcode_element_id);
                $parseObject = new ShortcodeParse();
                $wp_rsm_cs_output = $parseObject->wp_rsm_cs_shortcodes($wp_rsm_cs_output, $shortcode_str, true, $PREFIX);
            }
            $defaults = array(
                'wp_rsm_cs_var_column' => '',
                'wp_rsm_cs_var_image_section_title' => '',
                'wp_rsm_cs_var_image_section_subtitle' => '',
                'wp_rsm_var_about_info_align' => '',
                'wp_rsm_cs_about_info_select_background' => '',
                'wp_rsm_cs_var_about_info_button_title' => '',
                'wp_rsm_cs_var_frame_image_url_array' => '',
                'wp_rsm_cs_var_frame_promo_image_url_array' => '',
                'wp_rsm_cs_var_app_store_image_url_array' => '',
                'wp_rsm_cs_about_info_button_bg_color' => '',
                'wp_rsm_cs_about_info_bg_color' => '',
                'wp_rsm_cs_var_about_info_title' => '',
                'wp_rsm_cs_var_about_info_sub_title' => '',
                'wp_rsm_cs_about_info_sub_title_color' => '',
                'wp_rsm_cs_var_about_info_button_url' => '',
                'wp_rsm_cs_about_info_title_color' => '',
                'wp_rsm_cs_var_promo_box_view' => '',
                'wp_rsm_cs_var_app_store_url' => '',
                'wp_rsm_cs_var_google_store_url' => '',
                'wp_rsm_cs_var_email' => '',
            );
            if (isset($wp_rsm_cs_output['0']['atts'])) {
                $atts = $wp_rsm_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rsm_cs_output['0']['content'])) {
                $wp_rsm_cs_var_image_description = $wp_rsm_cs_output['0']['content'];
            } else {
                $wp_rsm_cs_var_image_description = '';
            }
            $about_info_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rsm_cs_var_page_builder_about_info';
            $coloumn_class = 'column_' . $about_info_element_size;
            $wp_rsm_cs_var_image_section_title = isset($wp_rsm_cs_var_image_section_title) ? $wp_rsm_cs_var_image_section_title : '';
            $wp_rsm_cs_var_image_section_subtitle = isset($wp_rsm_cs_var_image_section_subtitle) ? $wp_rsm_cs_var_image_section_subtitle : '';
            $wp_rsm_cs_var_about_info_button_title = isset($wp_rsm_cs_var_about_info_button_title) ? $wp_rsm_cs_var_about_info_button_title : '';
            $wp_rsm_cs_about_info_select_background = isset($wp_rsm_cs_about_info_select_background) ? $wp_rsm_cs_about_info_select_background : '';
            $wp_rsm_cs_var_frame_image_url_array = isset($wp_rsm_cs_var_frame_image_url_array) ? $wp_rsm_cs_var_frame_image_url_array : '';
            $wp_rsm_cs_about_info_button_bg_color = isset($wp_rsm_cs_about_info_button_bg_color) ? $wp_rsm_cs_about_info_button_bg_color : '';
            $wp_rsm_cs_about_info_bg_color = isset($wp_rsm_cs_about_info_bg_color) ? $wp_rsm_cs_about_info_bg_color : '';
            $wp_rsm_cs_var_about_info_title = isset($wp_rsm_cs_var_about_info_title) ? $wp_rsm_cs_var_about_info_title : '';
            $wp_rsm_cs_var_about_info_button_url = isset($wp_rsm_cs_var_about_info_button_url) ? $wp_rsm_cs_var_about_info_button_url : '';
            $wp_rsm_cs_about_info_title_color = isset($wp_rsm_cs_about_info_title_color) ? $wp_rsm_cs_about_info_title_color : '';
            $wp_rsm_cs_var_frame_promo_image_url_array = isset($wp_rsm_cs_var_frame_promo_image_url_array) ? $wp_rsm_cs_var_frame_promo_image_url_array : '';
            $wp_rsm_cs_var_app_store_image_url_array = isset($wp_rsm_cs_var_app_store_image_url_array) ? $wp_rsm_cs_var_app_store_image_url_array : '';
            $wp_rsm_cs_var_app_store_url = isset($wp_rsm_cs_var_app_store_url) ? $wp_rsm_cs_var_app_store_url : '';
            $wp_rsm_cs_var_google_store_url = isset($wp_rsm_cs_var_google_store_url) ? $wp_rsm_cs_var_google_store_url : '';
            $wp_rsm_cs_var_email = isset($wp_rsm_cs_var_email) ? $wp_rsm_cs_var_email : '';
            $wp_rsm_cs_var_promo_box_view = isset($wp_rsm_cs_var_promo_box_view) ? $wp_rsm_cs_var_promo_box_view : '';
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $strings = new wp_rsm_cs_theme_all_strings;
            $strings->wp_rsm_cs_short_code_strings();
            ?>
            <div id="<?php echo esc_attr($name . $wp_rsm_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="about_info" data="<?php echo wp_rsm_cs_element_size_data_array_index($about_info_element_size) ?>" >
                     <?php wp_rsm_cs_element_setting($name, $wp_rsm_cs_counter, $about_info_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rsm_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rsm_cs_counter) ?>" data-shortcode-template="[wp_rsm_cs_about_info {{attributes}}]{{content}}[/wp_rsm_cs_about_info]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rsm_cs_counter) ?>">
                        <h5><?php echo esc_html(wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_about_info_options')); ?></h5>
                        <a href="javascript:wp_rsm_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rsm_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
                            <i class="icon-cross"></i>
                        </a>
                    </div>
                    <div class="cs-pbwp-content">
                        <div class="cs-wrapp-clone cs-shortcode-wrapp">
                            <?php
                            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                wp_rsm_cs_shortcode_element_size();
                            }
                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_image_field_name'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_image_field_name_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rsm_cs_var_image_section_title),
                                    'cust_id' => 'wp_rsm_cs_var_image_section_title' . $wp_rsm_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rsm_cs_var_image_section_title[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);

                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_element_subtitle'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_element_subtitle_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rsm_cs_var_image_section_subtitle),
                                    'cust_id' => 'wp_rsm_cs_var_image_section_subtitle' . $wp_rsm_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rsm_cs_var_image_section_subtitle[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);


                            $wp_rsm_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_title_alignment'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_title_alignment_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rsm_var_about_info_align,
                                    'id' => '',
                                    'cust_id' => 'wp_rsm_var_about_info_align',
                                    'cust_name' => 'wp_rsm_var_about_info_align[]',
                                    'classes' => 'service_postion chosen-select-no-single select-medium',
                                    'options' => array(
                                        'align-left' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_align_left'),
                                        'align-right' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_align_right'),
                                        'align-center' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_align_center'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_select_field($wp_rsm_opt_array);

                            $wp_rsm_cs_opt_array = array(
                                'std' => esc_url($wp_rsm_cs_var_frame_promo_image_url_array),
                                'id' => 'frame_promo_image_url',
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_select_image'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_about_info_select_image_hint'),
                                'echo' => true,
                                'array' => true,
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => esc_url($wp_rsm_cs_var_frame_promo_image_url_array),
                                    'id' => 'frame_promo_image_url',
                                    'return' => true,
                                    'array' => true,
                                    'array_txt' => false,
                                    'prefix' => '',
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_upload_file_field($wp_rsm_cs_opt_array);
                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_title'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rsm_cs_var_about_info_title),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'wp_rsm_cs_var_about_info_title[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                            //about_info title color
                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_title_color'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_title_color_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($wp_rsm_cs_about_info_title_color),
                                    'id' => 'wp_rsm_cs_about_info_title_color',
                                    'cust_name' => 'wp_rsm_cs_about_info_title_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );

                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);

                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_sub_title'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_sub_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rsm_cs_var_about_info_sub_title),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'wp_rsm_cs_var_about_info_sub_title[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                            //about_info title color
                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_sub_title_color'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_sub_title_color_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($wp_rsm_cs_about_info_sub_title_color),
                                    'id' => 'wp_rsm_cs_about_info_title_color',
                                    'cust_name' => 'wp_rsm_cs_about_info_sub_title_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );

                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);

                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_field_desc'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_about_info_field_desc_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_textarea($wp_rsm_cs_var_image_description),
                                    'cust_id' => 'wp_rsm_cs_var_image_description' . $wp_rsm_cs_counter,
                                    'classes' => 'textarea',
                                    'cust_name' => 'wp_rsm_cs_var_image_description[]',
                                    'return' => true,
                                    'wp_rsm_cs_editor' => true,
                                    'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_textarea_field($wp_rsm_cs_opt_array);
                            //button
                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_button_title'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_about_info_button_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rsm_cs_var_about_info_button_title),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'wp_rsm_cs_var_about_info_button_title[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                            //button bg color
                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_button_bg_color'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_about_info_button_bg_color_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($wp_rsm_cs_about_info_button_bg_color),
                                    'id' => 'wp_rsm_cs_about_info_button_bg_color',
                                    'cust_name' => 'wp_rsm_cs_about_info_button_bg_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );

                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                            $wp_rsm_cs_opt_array = array(
                                'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_button_url'),
                                'desc' => '',
                                'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_promobox_button_url_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rsm_cs_var_about_info_button_url),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'wp_rsm_cs_var_about_info_button_url[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                            ?>
                        </div>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rsm_cs_shortcode_insert_editor('<?php echo str_replace('wp_rsm_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rsm_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_insert')); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>

                            <?php
                            $wp_rsm_cs_opt_array = array(
                                'std' => 'about_info',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'cust_id' => 'wp_rsm_cs_orderby' . $wp_rsm_cs_counter,
                                'cust_name' => 'wp_rsm_cs_orderby[]',
                                'required' => false
                            );
                            $wp_rsm_cs_var_form_fields->wp_rsm_cs_var_form_hidden_render($wp_rsm_cs_opt_array);
                            $wp_rsm_cs_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_save'),
                                    'cust_id' => 'about_info_save',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-wp_rsm_cs-admin-btn',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'cust_name' => 'about_info_save' . $wp_rsm_cs_counter,
                                    'return' => true,
                                ),
                            );
                            $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
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

    add_action('wp_ajax_wp_rsm_cs_var_page_builder_about_info', 'wp_rsm_cs_var_page_builder_about_info');
}

if (!function_exists('wp_rsm_cs_save_page_builder_data_about_info_callback')) {

    /**
     * Save data for image frame shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rsm_cs_save_page_builder_data_about_info_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		$shortcode_data = '';
        if ($widget_type == "about_info" || $widget_type == "cs_about_info") {
            $wp_rsm_cs_var_about_info = '';
            $page_element_size = $data['about_info_element_size'][$counters['wp_rsm_cs_global_counter_about_info']];
            $current_element_size = $data['about_info_element_size'][$counters['wp_rsm_cs_global_counter_about_info']];

            if (isset($data['wp_rsm_cs_widget_element_num'][$counters['wp_rsm_cs_counter']]) && $data['wp_rsm_cs_widget_element_num'][$counters['wp_rsm_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['about_info'][$counters['wp_rsm_cs_shortcode_counter_about_info']]));

                $element_settings = 'about_info_element_size="' . $current_element_size . '"';
                $reg = '/about_info_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rsm_cs_shortcode_counter_about_info'] ++;
            } else {
                $wp_rsm_cs_var_about_info = '[wp_rsm_cs_about_info about_info_element_size="' . htmlspecialchars($data['about_info_element_size'][$counters['wp_rsm_cs_global_counter_about_info']]) . '" ';
                if (isset($data['wp_rsm_cs_var_image_section_title'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_image_section_title'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_image_section_title="' . htmlspecialchars($data['wp_rsm_cs_var_image_section_title'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_image_section_subtitle'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_image_section_subtitle'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_image_section_subtitle="' . htmlspecialchars($data['wp_rsm_cs_var_image_section_subtitle'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_var_about_info_align'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_var_about_info_align'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_var_about_info_align="' . htmlspecialchars($data['wp_rsm_var_about_info_align'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_about_info_title'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_about_info_title'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_about_info_title="' . htmlspecialchars($data['wp_rsm_cs_var_about_info_title'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_about_info_title_color'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_about_info_title_color'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_about_info_title_color="' . htmlspecialchars($data['wp_rsm_cs_about_info_title_color'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }

                if (isset($data['wp_rsm_cs_var_about_info_sub_title'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_about_info_sub_title'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_about_info_sub_title="' . htmlspecialchars($data['wp_rsm_cs_var_about_info_sub_title'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_about_info_sub_title_color'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_about_info_sub_title_color'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_about_info_sub_title_color="' . htmlspecialchars($data['wp_rsm_cs_about_info_sub_title_color'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }

                if (isset($data['wp_rsm_cs_about_info_select_background'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_about_info_select_background'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_about_info_select_background="' . htmlspecialchars($data['wp_rsm_cs_about_info_select_background'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_about_info_button_title'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_about_info_button_title'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_about_info_button_title="' . htmlspecialchars($data['wp_rsm_cs_var_about_info_button_title'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_promo_box_view'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_promo_box_view'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_promo_box_view="' . htmlspecialchars($data['wp_rsm_cs_var_promo_box_view'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_frame_image_url_array'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_frame_image_url_array'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_frame_image_url_array="' . htmlspecialchars($data['wp_rsm_cs_var_frame_image_url_array'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_app_store_image_url_array'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_app_store_image_url_array'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_app_store_image_url_array="' . htmlspecialchars($data['wp_rsm_cs_var_app_store_image_url_array'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_app_store_url'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_app_store_url'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_app_store_url="' . htmlspecialchars($data['wp_rsm_cs_var_app_store_url'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_google_store_url'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_google_store_url'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_google_store_url="' . htmlspecialchars($data['wp_rsm_cs_var_google_store_url'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_email'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_email'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_email="' . htmlspecialchars($data['wp_rsm_cs_var_email'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_frame_promo_image_url_array'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_frame_promo_image_url_array'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_frame_promo_image_url_array="' . htmlspecialchars($data['wp_rsm_cs_var_frame_promo_image_url_array'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_about_info_button_bg_color'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_about_info_button_bg_color'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_about_info_button_bg_color="' . htmlspecialchars($data['wp_rsm_cs_about_info_button_bg_color'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_about_info_button_url'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_about_info_button_url'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_var_about_info_button_url="' . htmlspecialchars($data['wp_rsm_cs_var_about_info_button_url'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_about_info_bg_color'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_about_info_bg_color'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= 'wp_rsm_cs_about_info_bg_color="' . htmlspecialchars($data['wp_rsm_cs_about_info_bg_color'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . '" ';
                }
                $wp_rsm_cs_var_about_info .= ']';
                if (isset($data['wp_rsm_cs_var_image_description'][$counters['wp_rsm_cs_counter_about_info']]) && $data['wp_rsm_cs_var_image_description'][$counters['wp_rsm_cs_counter_about_info']] != '') {
                    $wp_rsm_cs_var_about_info .= htmlspecialchars($data['wp_rsm_cs_var_image_description'][$counters['wp_rsm_cs_counter_about_info']], ENT_QUOTES) . ' ';
                }
                $wp_rsm_cs_var_about_info .= '[/wp_rsm_cs_about_info]';

                $shortcode_data .= $wp_rsm_cs_var_about_info;
                $counters['wp_rsm_cs_counter_about_info'] ++;
            }
            $counters['wp_rsm_cs_global_counter_about_info'] ++;
        }

        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rsm_cs_save_page_builder_data_about_info', 'wp_rsm_cs_save_page_builder_data_about_info_callback');
}

if (!function_exists('wp_rsm_cs_load_shortcode_counters_about_info_callback')) {

    /**
     * Populate image frame shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rsm_cs_load_shortcode_counters_about_info_callback($counters) {
        $counters['wp_rsm_cs_global_counter_about_info'] = 0;
        $counters['wp_rsm_cs_shortcode_counter_about_info'] = 0;
        $counters['wp_rsm_cs_counter_about_info'] = 0;
        return $counters;
    }

    add_filter('wp_rsm_cs_load_shortcode_counters', 'wp_rsm_cs_load_shortcode_counters_about_info_callback');
}
if (!function_exists('wp_rsm_cs_shortcode_names_list_populate_about_info_callback')) {

    /**
     * Populate image frame shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rsm_cs_shortcode_names_list_populate_about_info_callback($shortcode_array) {
        $shortcode_array['about_info'] = array(
            'title' => wp_rsm_cs_var_frame_text_srt('wp_rsm_cs_var_about_info'),
            'name' => 'about_info',
            'icon' => 'icon-photo',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rsm_cs_shortcode_names_list_populate', 'wp_rsm_cs_shortcode_names_list_populate_about_info_callback');
}

if (!function_exists('wp_rsm_cs_element_list_populate_about_info_callback')) {

    /**
     * Populate image frame shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rsm_cs_element_list_populate_about_info_callback($element_list) {
        $element_list['about_info'] = wp_rsm_cs_var_frame_text_srt('wp_rsm_cs_var_about_info');
        return $element_list;
    }

    add_filter('wp_rsm_cs_element_list_populate', 'wp_rsm_cs_element_list_populate_about_info_callback');
}