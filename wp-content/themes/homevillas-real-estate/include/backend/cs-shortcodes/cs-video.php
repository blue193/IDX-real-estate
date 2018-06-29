<?php
/*
 *
 * @File : Video
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_video')) {

    function wp_rem_cs_var_page_builder_video($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;

        if (function_exists('wp_rem_cs_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $PREFIX = 'wp_rem_cs_video';
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
                'wp_rem_cs_var_video_title' => '',
                'wp_rem_cs_var_video_subtitle' => '',
                'wp_rem_cs_var_video_url' => '',
                'wp_rem_cs_var_height' => '',
                'wp_rem_var_video_align' => '',
            );
            if (isset($wp_rem_cs_output['0']['atts'])) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rem_cs_output['0']['content'])) {
                $video_text = $wp_rem_cs_output['0']['content'];
            } else {
                $video_text = '';
            }
            $video_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_video';
            $coloumn_class = 'column_' . $video_element_size;
            $wp_rem_cs_var_video_title = isset($wp_rem_cs_var_video_title) ? $wp_rem_cs_var_video_title : '';
            $wp_rem_cs_var_video_url = isset($wp_rem_cs_var_video_url) ? $wp_rem_cs_var_video_url : '';
            $wp_rem_cs_var_height = isset($wp_rem_cs_var_height) ? $wp_rem_cs_var_height : '';
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $stringsObj = new wp_rem_cs_theme_all_strings;
            $stringsObj->wp_rem_cs_short_code_strings();
            ?>
            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="video" data="<?php echo wp_rem_cs_element_size_data_array_index($video_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $video_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_video {{attributes}}]{{content}}[/wp_rem_cs_video]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_video_text')); ?></h5>
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
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_video_title),
                                    'cust_id' => 'wp_rem_cs_var_video_title' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_video_title[]',
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
                                    'std' => esc_attr($wp_rem_cs_var_video_subtitle),
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_video_subtitle[]',
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
                                    'std' => $wp_rem_var_video_align,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_var_video_align',
                                    'cust_name' => 'wp_rem_var_video_align[]',
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
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_video_field_url'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_video_height_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_video_url),
                                    'cust_id' => 'wp_rem_cs_var_video_url' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_video_url[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_video_field_height'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_video_field_height_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_height),
                                    'cust_id' => 'wp_rem_cs_var_height' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_height[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" 
                                       onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>',
                                                       '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'video',
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
                                    'cust_id' => 'video_save' . $wp_rem_cs_counter,
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'cust_name' => 'video_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_video', 'wp_rem_cs_var_page_builder_video');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_video_callback')) {

    /**
     * Save data for video shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_video_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		$shortcode_data = '';
        if ($widget_type == "video" || $widget_type == "cs_video") {
            $shortcode = '';
            $page_element_size = $data['video_element_size'][$counters['wp_rem_cs_global_counter_video']];
            $current_element_size = $data['video_element_size'][$counters['wp_rem_cs_global_counter_video']];

            if (isset($_POST['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $_POST['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($_POST['shortcode']['video'][$counters['wp_rem_cs_shortcode_counter_video']]);
                $element_settings = 'video_element_size="' . $current_element_size . '"';
                $reg = '/video_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_video'] ++;
            } else {
                $shortcode = '[wp_rem_cs_video video_element_size="' . htmlspecialchars($data['video_element_size'][$counters['wp_rem_cs_global_counter_video']]) . '" ';
                if (isset($_POST['wp_rem_cs_var_video_title'][$counters['wp_rem_cs_counter_video']]) && $_POST['wp_rem_cs_var_video_title'][$counters['wp_rem_cs_counter_video']] != '') {
                    $shortcode .='wp_rem_cs_var_video_title="' . htmlspecialchars($_POST['wp_rem_cs_var_video_title'][$counters['wp_rem_cs_counter_video']], ENT_QUOTES) . '" ';
                }
                if (isset($_POST['wp_rem_cs_var_video_subtitle'][$counters['wp_rem_cs_counter_video']]) && $_POST['wp_rem_cs_var_video_subtitle'][$counters['wp_rem_cs_counter_video']] != '') {
                    $shortcode .='wp_rem_cs_var_video_subtitle="' . htmlspecialchars($_POST['wp_rem_cs_var_video_subtitle'][$counters['wp_rem_cs_counter_video']], ENT_QUOTES) . '" ';
                }
                if (isset($_POST['wp_rem_var_video_align'][$counters['wp_rem_cs_counter_video']]) && $_POST['wp_rem_var_video_align'][$counters['wp_rem_cs_counter_video']] != '') {
                    $shortcode .='wp_rem_var_video_align="' . htmlspecialchars($_POST['wp_rem_var_video_align'][$counters['wp_rem_cs_counter_video']], ENT_QUOTES) . '" ';
                }
                if (isset($_POST['wp_rem_cs_var_video_url'][$counters['wp_rem_cs_counter_video']]) && $_POST['wp_rem_cs_var_video_url'][$counters['wp_rem_cs_counter_video']] != '') {
                    $shortcode .='wp_rem_cs_var_video_url="' . htmlspecialchars($_POST['wp_rem_cs_var_video_url'][$counters['wp_rem_cs_counter_video']], ENT_QUOTES) . '" ';
                }
                if (isset($_POST['wp_rem_cs_var_height'][$counters['wp_rem_cs_counter_video']]) && $_POST['wp_rem_cs_var_height'][$counters['wp_rem_cs_counter_video']] != '') {
                    $shortcode .='wp_rem_cs_var_height="' . htmlspecialchars($_POST['wp_rem_cs_var_height'][$counters['wp_rem_cs_counter_video']], ENT_QUOTES) . '" ';
                }
                $shortcode .= ']';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_video'] ++;
            }
            $counters['wp_rem_cs_global_counter_video'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_video', 'wp_rem_cs_save_page_builder_data_video_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_video_callback')) {

    /**
     * Populate video shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_video_callback($counters) {
        $counters['wp_rem_cs_global_counter_video'] = 0;
        $counters['wp_rem_cs_shortcode_counter_video'] = 0;
        $counters['wp_rem_cs_counter_video'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_video_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_video_callback')) {

    /**
     * Populate video shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_video_callback($shortcode_array) {
        $shortcode_array['video'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_video'),
            'name' => 'video',
            'icon' => 'icon-video2',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_video_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_video_callback')) {

    /**
     * Populate video shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_video_callback($element_list) {
        $element_list['video'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_video');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_video_callback');
}