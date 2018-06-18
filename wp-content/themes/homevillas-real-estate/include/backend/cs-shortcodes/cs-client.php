<?php
/*
 *
 * @Shortcode Name : Clients
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_clients')) {

    function wp_rem_cs_var_page_builder_clients($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $clients_num = 0;
        $wp_rem_cs_var_clients_element_title = isset($wp_rem_cs_var_clients_element_title) ? $wp_rem_cs_var_clients_element_title : '';
        $wp_rem_cs_var_clients_text_color = isset($wp_rem_cs_var_clients_text_color) ? $wp_rem_cs_var_clients_text_color : '';
        $wp_rem_cs_var_clients_position = isset($wp_rem_cs_var_clients_position) ? $wp_rem_cs_var_clients_position : '';
        $clients_img_user = isset($clients_img_user) ? $clients_img_user : '';
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_clients|clients_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'column_size' => '1/1',
            'wp_rem_cs_var_clients_text_color' => '',
            'wp_rem_cs_var_clients_element_title' => '',
            'wp_rem_cs_var_clients_element_subtitle' => '',
            'wp_rem_cs_clients_class' => '',
            'wp_rem_var_clients_view' => '',
            'wp_rem_var_clients_align' => '',
            'clients_text_color' => '',
        );
        if (isset($output['0']['atts'])) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if (isset($output['0']['content'])) {
            $atts_content = $output['0']['content'];
        } else {
            $atts_content = array();
        }
        if (is_array($atts_content)) {
            $clients_num = count($atts_content);
        }
        $clients_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_clients';
        $coloumn_class = 'column_' . $clients_element_size;

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="clients" data="<?php echo wp_rem_cs_element_size_data_array_index($clients_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $clients_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_edit_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/wp_rem_cs_clients]" data-shortcode-child-template="[clients_item {{attributes}}] {{content}} [/clients_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[wp_rem_cs_clients {{attributes}}]">
                                <?php
                                if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                    wp_rem_cs_shortcode_element_size();
                                }
                                $wp_rem_cs_clients_style = isset($wp_rem_cs_clients_style) ? $wp_rem_cs_clients_style : '';
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_title_hint_text'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_clients_element_title),
                                        'cust_id' => '',
                                        'cust_id' => 'wp_rem_cs_var_clients_element_title' . $wp_rem_cs_counter,
                                        'cust_name' => 'wp_rem_cs_var_clients_element_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_var_clients_element_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_clients_element_subtitle[]',
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
                                        'std' => $wp_rem_var_clients_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_clients_align',
                                        'cust_name' => 'wp_rem_var_clients_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_hint_text'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_var_clients_view,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_clients_view',
                                        'cust_name' => 'wp_rem_var_clients_view[]',
                                        'classes' => 'chosen-select-no-single select-medium',
                                        'options' => array(
                                            'simple' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_simple'),
                                            'default' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_default'),
                                            'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_medern'),
                                            'modern-border' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_medern_with_border'),
                                            'advance' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_advance'),
                                            'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_classic'),
                                            'slider' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_view_slider'),
                                            
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
                                ?>
                            </div>
                            <?php
                            if (isset($clients_num) && $clients_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $clients) {
                                    $rand_string = rand(1234, 7894563);
                                    $wp_rem_cs_var_clients_text = $clients['content'];
                                    $defaults = array('wp_rem_cs_var_clients_text' => '', 'wp_rem_cs_var_clients_img_user_array' => '', 'wp_rem_cs_var_clients_position' => '');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($clients['atts'][$key])) {
                                            $$key = $clients['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_counter')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a>
                                        </header>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_url'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_url_hint_text'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_clients_text),
                                                'cust_id' => '',
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'cust_name' => 'wp_rem_cs_var_clients_text[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'std' => $wp_rem_cs_var_clients_img_user_array,
                                            'id' => 'clients_img_user',
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_image'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_url_image_hint_text'),
                                            'echo' => true,
                                            'array' => true,
                                            'prefix' => '',
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_var_clients_img_user_array,
                                                'id' => 'clients_img_user',
                                                'return' => true,
                                                'array' => true,
                                                'array_txt' => false,
                                                'prefix' => '',
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="hidden-object">
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_allow_special_char($clients_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'clients_num[]',
                                'return' => true,
                                'required' => false
                            );
                            echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array));
                            ?>
                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('clients', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_url_add_clients')); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg noborder">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_url_add_insert')); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                    <?php
                                } else {
                                    $wp_rem_cs_opt_array = array(
                                        'std' => 'clients',
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => '',
                                        'extra_atr' => '',
                                        'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
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
                                            'cust_id' => 'clients_save' . $wp_rem_cs_counter,
                                            'cust_type' => 'button',
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'classes' => 'cs-wp_rem_cs-admin-btn',
                                            'cust_name' => 'clients_save',
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
            </div>

        </div>
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_clients', 'wp_rem_cs_var_page_builder_clients');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_clients_callback')) {

    /**
     * Save data for clients shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_clients_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "clients" || $widget_type == "cs_clients") {
            $shortcode = $shortcode_item = '';
            $page_element_size = $data['clients_element_size'][$counters['wp_rem_cs_global_counter_clients']];
            $current_element_size = $data['clients_element_size'][$counters['wp_rem_cs_global_counter_clients']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($data['shortcode']['clients'][$counters['wp_rem_cs_shortcode_counter_clients']]);
                $element_settings = 'clients_element_size="' . $current_element_size . '"';
                $reg = '/clients_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_clients'] ++;
            } else {
                if (isset($data['clients_num'][$counters['wp_rem_cs_counter_clients']]) && $data['clients_num'][$counters['wp_rem_cs_counter_clients']] > 0) {
                    for ($i = 1; $i <= $data['clients_num'][$counters['wp_rem_cs_counter_clients']]; $i ++) {
                        $shortcode_item .= '[clients_item ';
                        if (isset($data['wp_rem_cs_var_clients_img_user_array'][$counters['wp_rem_cs_counter_clients_node']]) && $data['wp_rem_cs_var_clients_img_user_array'][$counters['wp_rem_cs_counter_clients_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_clients_img_user_array="' . $data['wp_rem_cs_var_clients_img_user_array'][$counters['wp_rem_cs_counter_clients_node']] . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_clients_text'][$counters['wp_rem_cs_counter_clients_node']]) && $data['wp_rem_cs_var_clients_text'][$counters['wp_rem_cs_counter_clients_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_clients_text="' . $data['wp_rem_cs_var_clients_text'][$counters['wp_rem_cs_counter_clients_node']] . '" ';
                        }
                        $shortcode_item .= ']';

                        $shortcode_item .= '[/clients_item]';
                        $counters['wp_rem_cs_counter_clients_node'] ++;
                    }
                }
                $section_title = '';
                if (isset($data['wp_rem_cs_var_clients_element_title'][$counters['wp_rem_cs_counter_clients']]) && $data['wp_rem_cs_var_clients_element_title'][$counters['wp_rem_cs_counter_clients']] != '') {
                    $section_title .= 'wp_rem_cs_var_clients_element_title="' . htmlspecialchars($data['wp_rem_cs_var_clients_element_title'][$counters['wp_rem_cs_counter_clients']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_clients_element_subtitle'][$counters['wp_rem_cs_counter_clients']]) && $data['wp_rem_cs_var_clients_element_subtitle'][$counters['wp_rem_cs_counter_clients']] != '') {
                    $section_title .= 'wp_rem_cs_var_clients_element_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_clients_element_subtitle'][$counters['wp_rem_cs_counter_clients']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_clients_align'][$counters['wp_rem_cs_counter_clients']]) && $data['wp_rem_var_clients_align'][$counters['wp_rem_cs_counter_clients']] != '') {
                    $section_title .= 'wp_rem_var_clients_align="' . htmlspecialchars($data['wp_rem_var_clients_align'][$counters['wp_rem_cs_counter_clients']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_clients_view'][$counters['wp_rem_cs_counter_clients']]) && $data['wp_rem_var_clients_view'][$counters['wp_rem_cs_counter_clients']] != '') {
                    $section_title .= 'wp_rem_var_clients_view="' . htmlspecialchars($data['wp_rem_var_clients_view'][$counters['wp_rem_cs_counter_clients']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'clients_element_size="' . htmlspecialchars($data['clients_element_size'][$counters['wp_rem_cs_global_counter_clients']]) . '"';
                $shortcode = '[wp_rem_cs_clients ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/wp_rem_cs_clients]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_clients'] ++;
            }
            $counters['wp_rem_cs_global_counter_clients'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_clients', 'wp_rem_cs_save_page_builder_data_clients_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_clients_callback')) {

    /**
     * Populate clients shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_clients_callback($counters) {
        $counters['wp_rem_cs_counter_clients'] = 0;
        $counters['wp_rem_cs_counter_clients_node'] = 0;
        $counters['wp_rem_cs_shortcode_counter_clients'] = 0;
        $counters['wp_rem_cs_global_counter_clients'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_clients_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_clients_callback')) {

    /**
     * Populate clients shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_clients_callback($shortcode_array) {
        $shortcode_array['clients'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_clients'),
            'name' => 'clients',
            'icon' => 'icon-user3',
            'categories' => 'loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_clients_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_clients_callback')) {

    /**
     * Populate clients shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_clients_callback($element_list) {
        $element_list['clients'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_clients');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_clients_callback');
}

if (!function_exists('wp_rem_cs_shortcode_sub_element_ui_clients_callback')) {

    /**
     * Render UI for sub element in clients settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_clients_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];

        if ($type == 'clients') {

            $rand_id = rand(1234, 7894563);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_clients'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image_url'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image_url_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'cust_name' => 'wp_rem_cs_var_clients_text[]',
                        'return' => true,
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'std' => '',
                    'id' => 'clients_img_user',
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'prefix' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => 'clients_img_user',
                        'return' => true,
                        'array' => true,
                        'array_txt' => false,
                        'prefix' => '',
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                ?>

            </div>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_clients_callback');
}