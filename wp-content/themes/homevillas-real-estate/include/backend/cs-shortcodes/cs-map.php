<?php
/**
 * @Google map html form for page builder start
 */
if (!function_exists('wp_rem_cs_var_page_builder_map')) {

    function wp_rem_cs_var_page_builder_map($die = 0) {
        global $wp_rem_cs_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
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
            $PREFIX = 'wp_rem_cs_map';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_map_title' => '',
            'wp_rem_cs_var_map_subtitle' => '',
            'wp_rem_var_map_align' => '',
            'wp_rem_cs_var_map_height' => '',
            'wp_rem_cs_var_map_lat' => '40.7143528',
            'wp_rem_cs_var_map_lon' => '-74.0059731',
            'wp_rem_cs_var_map_zoom' => '',
            'wp_rem_cs_var_map_info' => '',
            'wp_rem_cs_var_map_api_key'=>'',
            'wp_rem_cs_var_map_style_code'=>'',
            'wp_rem_cs_var_map_info_width' => '',
            'wp_rem_cs_var_map_info_height' => '',
            'wp_rem_cs_var_map_marker_icon' => '',
            'wp_rem_cs_var_map_show_marker' => 'true',
            'wp_rem_cs_var_map_controls' => '',
            'wp_rem_cs_var_map_draggable' => '',
            'wp_rem_cs_var_map_scrollwheel' => '',
            'wp_rem_cs_var_map_border' => '',
            'wp_rem_cs_var_map_border_color' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content'])) {
            $atts_content = $output['0']['content'];
        } else {
            $atts_content = '';
        }
        $map_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $wp_rem_cs_var_map_title = isset($wp_rem_cs_var_map_title) ? $wp_rem_cs_var_map_title : '';
        $wp_rem_cs_var_map_height = isset($wp_rem_cs_var_map_height) ? $wp_rem_cs_var_map_height : '';
        $wp_rem_cs_var_map_lat = isset($wp_rem_cs_var_map_lat) ? $wp_rem_cs_var_map_lat : '';
        $wp_rem_cs_var_map_lon = isset($wp_rem_cs_var_map_lon) ? $wp_rem_cs_var_map_lon : '';
        $wp_rem_cs_var_map_zoom = isset($wp_rem_cs_var_map_zoom) ? $wp_rem_cs_var_map_zoom : '';
        $wp_rem_cs_var_map_info = isset($wp_rem_cs_var_map_info) ? $wp_rem_cs_var_map_info : '';
        $wp_rem_cs_var_map_info_width = isset($wp_rem_cs_var_map_info_width) ? $wp_rem_cs_var_map_info_width : '';
        $wp_rem_cs_var_map_info_height = isset($wp_rem_cs_var_map_info_height) ? $wp_rem_cs_var_map_info_height : '';
        $wp_rem_cs_var_map_marker_icon = isset($wp_rem_cs_var_map_marker_icon) ? $wp_rem_cs_var_map_marker_icon : '';
        $wp_rem_cs_var_map_show_marker = isset($wp_rem_cs_var_map_show_marker) ? $wp_rem_cs_var_map_show_marker : '';
        $wp_rem_cs_var_map_controls = isset($wp_rem_cs_var_map_controls) ? $wp_rem_cs_var_map_controls : '';
        $wp_rem_cs_var_map_draggable = isset($wp_rem_cs_var_map_draggable) ? $wp_rem_cs_var_map_draggable : '';
        $wp_rem_cs_var_map_scrollwheel = isset($wp_rem_cs_var_map_scrollwheel) ? $wp_rem_cs_var_map_scrollwheel : '';
        $wp_rem_cs_var_map_border = isset($wp_rem_cs_var_map_border) ? $wp_rem_cs_var_map_border : '';
        $wp_rem_cs_var_map_border_color = isset($wp_rem_cs_var_map_border_color) ? $wp_rem_cs_var_map_border_color : '';
        $wp_rem_cs_var_map_api_key = isset($wp_rem_cs_var_map_api_key) ? $wp_rem_cs_var_map_api_key : '';
        $name = 'wp_rem_cs_var_page_builder_map';
        $coloumn_class = 'column_' . $map_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $rand_string = $wp_rem_cs_counter . '' . wp_rem_cs_generate_random_string(3);
        global $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="map" data="<?php echo wp_rem_cs_element_size_data_array_index($map_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $map_element_size, '', 'globe'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter); ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[<?php echo esc_attr('wp_rem_cs_map'); ?> {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_map_options')); ?></h5>
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
                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_map_title),
                                'cust_id' => '',
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_var_map_title[]',
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
                                'std' => esc_attr($wp_rem_cs_var_map_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_var_map_subtitle[]',
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
                                'std' => $wp_rem_var_map_align,
                                'id' => '',
                                'cust_id' => 'wp_rem_var_map_align',
                                'cust_name' => 'wp_rem_var_map_align[]',
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
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_map_height'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_map_height_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_height),
                                'cust_id' => '',
                                'classes' => 'txtfield ',
                                'cust_name' => 'wp_rem_cs_var_map_height[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_latitude'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_latitude_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_lat),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_var_map_lat[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_longitude'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_longitude_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_lon),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_var_map_lon[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_zoom'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_zoom_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_zoom),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_var_map_zoom[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_info_text'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_info_text_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_info),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_var_map_info[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_info_text_width'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_info_text_width_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_info_width),
                                'cust_id' => '',
                                'classes' => 'txtfield input-small',
                                'cust_name' => 'wp_rem_cs_var_map_info_width[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_info_text_height'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_info_text_height_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_info_height),
                                'cust_id' => '',
                                'classes' => 'txtfield input-small',
                                'cust_name' => 'wp_rem_cs_var_map_info_height[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'std' => esc_url($wp_rem_cs_var_map_marker_icon),
                            'id' => 'map_marker_icon',
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_marker_icon_path'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_marker_icon_path_hint'),
                            'echo' => true,
                            'array' => true,
                            'prefix' => '',
                            'field_params' => array(
                                'std' => esc_url($wp_rem_cs_var_map_marker_icon),
                                'cust_id' => '',
                                'id' => 'map_marker_icon',
                                'return' => true,
                                'array' => true,
                                'array_txt' => false,
                                'prefix' => '',
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_show_marker'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_show_marker_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_map_show_marker),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_var_map_show_marker[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'true' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_on'),
                                    'false' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_off'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_disable_map_controls'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_disable_map_controls_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_map_controls),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_var_map_controls[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'true' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_on'),
                                    'false' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_off'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_drage_able'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_drage_able_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_map_draggable),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_var_map_draggable[]',
                                'classes' => 'dropdown  chosen-select',
                                'options' => array(
                                    'true' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_on'),
                                    'false' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_off'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_scroll_wheel'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_scroll_wheel_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_map_scrollwheel),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_var_map_scrollwheel[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'true' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_on'),
                                    'false' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_off'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_map_border'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_map_border_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_var_map_border),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_var_map_border[]',
                                'classes' => 'dropdown chosen-select',
                                'options' => array(
                                    'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
                                    'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_border_color'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_border_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_border_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'wp_rem_cs_var_map_border_color[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_map_google_api_key'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_map_google_api_key_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr($wp_rem_cs_var_map_api_key),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_var_map_api_key[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        
                        $styrle_map_code = '';
                        $styrle_map_code = rem_custom_shortcode_decode($atts_content);
                        
                         $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_plugin_option_map_custom_style'),
                                'desc' => sprintf(wp_rem_cs_var_theme_text_srt('wp_rem_plugin_option_map_custom_style_desc'), '<a href="'.esc_url( 'https://snazzymaps.com' ).'" target="_blank">'.esc_url( 'https://snazzymaps.com' ).'</a>'),
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => ($styrle_map_code),
                                    'cust_name' => 'wp_rem_cs_var_map_style_code[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                        
                        
                        
                        
                        ?>
                    </div>
                    <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                        ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                        <?php
                    } else {
                        $wp_rem_cs_opt_array = array(
                            'std' => 'map',
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'classes' => '',
                            'extra_atr' => '',
                            'cust_id' => '',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_map', 'wp_rem_cs_var_page_builder_map');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_map_callback')) {

    /**
     * Save data for map shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_map_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "map" || $widget_type == "cs_map") {
            $wp_rem_cs_var_map_shortcode = '';
            $page_element_size = $data['map_element_size'][$counters['wp_rem_cs_global_counter_map']];
            $current_element_size = $data['map_element_size'][$counters['wp_rem_cs_global_counter_map']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['map'][$counters['wp_rem_cs_shortcode_counter_map']]));

                $element_settings = 'map_element_size="' . $current_element_size . '"';
                $reg = '/map_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_map'] ++;
            } else {
                $wp_rem_cs_var_map_shortcode = '[wp_rem_cs_map map_element_size="' . htmlspecialchars($data['map_element_size'][$counters['wp_rem_cs_global_counter_map']]) . '" ';
                if (isset($data['wp_rem_cs_var_map_title'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_title'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_title="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_map_title'][$counters['wp_rem_cs_counter_map']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_var_map_align'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_var_map_align'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_var_map_align="' . stripslashes(htmlspecialchars(($data['wp_rem_var_map_align'][$counters['wp_rem_cs_counter_map']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_subtitle'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_subtitle'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_subtitle="' . stripslashes(htmlspecialchars(($data['wp_rem_cs_var_map_subtitle'][$counters['wp_rem_cs_counter_map']]), ENT_QUOTES)) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_height'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_height'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_height="' . htmlspecialchars($data['wp_rem_cs_var_map_height'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_lat'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_lat'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_lat="' . htmlspecialchars($data['wp_rem_cs_var_map_lat'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_lon'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_lon'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_lon="' . htmlspecialchars($data['wp_rem_cs_var_map_lon'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_zoom'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_zoom'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_zoom="' . htmlspecialchars($data['wp_rem_cs_var_map_zoom'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_info'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_info'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_info="' . htmlspecialchars($data['wp_rem_cs_var_map_info'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_info_width'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_info_width'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_info_width="' . htmlspecialchars($data['wp_rem_cs_var_map_info_width'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_info_height'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_info_height'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_info_height="' . htmlspecialchars($data['wp_rem_cs_var_map_info_height'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_marker_icon_array'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_marker_icon_array'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_marker_icon="' . htmlspecialchars($data['wp_rem_cs_var_map_marker_icon_array'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_show_marker'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_show_marker'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_show_marker="' . htmlspecialchars($data['wp_rem_cs_var_map_show_marker'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_controls'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_controls'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_controls="' . htmlspecialchars($data['wp_rem_cs_var_map_controls'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_draggable'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_draggable'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_draggable="' . htmlspecialchars($data['wp_rem_cs_var_map_draggable'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_scrollwheel'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_scrollwheel'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_scrollwheel="' . htmlspecialchars($data['wp_rem_cs_var_map_scrollwheel'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_border'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_border'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_border="' . htmlspecialchars($data['wp_rem_cs_var_map_border'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_border_color'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_border_color'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_border_color="' . htmlspecialchars($data['wp_rem_cs_var_map_border_color'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_map_api_key'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_api_key'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= 'wp_rem_cs_var_map_api_key="' . htmlspecialchars($data['wp_rem_cs_var_map_api_key'][$counters['wp_rem_cs_counter_map']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_var_map_shortcode .= ']';
                
                if (isset($data['wp_rem_cs_var_map_style_code'][$counters['wp_rem_cs_counter_map']]) && $data['wp_rem_cs_var_map_style_code'][$counters['wp_rem_cs_counter_map']] != '') {
                    $wp_rem_cs_var_map_shortcode .= htmlspecialchars(rem_custom_shortcode_encode($data['wp_rem_cs_var_map_style_code'][$counters['wp_rem_cs_counter_map']]),ENT_QUOTES) . ' ';
                    //$wp_rem_cs_var_map_shortcode .= rem_custom_shortcode_encode($data['wp_rem_cs_var_map_style_code'][$counters['wp_rem_cs_counter_map']]) . ' ';
                }
                $wp_rem_cs_var_map_shortcode .= '[/wp_rem_cs_map]';
                $shortcode_data .= $wp_rem_cs_var_map_shortcode;
                $counters['wp_rem_cs_counter_map'] ++;
            }
            $counters['wp_rem_cs_global_counter_map'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_map', 'wp_rem_cs_save_page_builder_data_map_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_map_callback')) {

    /**
     * Populate map shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_map_callback($counters) {
        $counters['wp_rem_cs_global_counter_map'] = 0;
        $counters['wp_rem_cs_shortcode_counter_map'] = 0;
        $counters['wp_rem_cs_counter_map'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_map_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_map_callback')) {

    /**
     * Populate map shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_map_callback($shortcode_array) {
        $shortcode_array['map'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_map'),
            'name' => 'map',
            'icon' => 'icon-location2',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_map_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_map_callback')) {

    /**
     * Populate map shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_map_callback($element_list) {
        $element_list['map'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_map');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_map_callback');
}