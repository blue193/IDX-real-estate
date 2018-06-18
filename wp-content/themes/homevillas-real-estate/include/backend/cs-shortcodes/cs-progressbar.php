<?php
/*
 *
 * @Shortcode Name : Progressbar
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_progressbars')) {

    function wp_rem_cs_var_page_builder_progressbars($die = 0) {
        global $wp_rem_cs_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $PREFIX = 'wp_rem_cs_progressbar|progressbar_item';
        $parseObject = new ShortcodeParse();
        $progressbars_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'column_size' => '1/1',
            'progressbars_element_title' => '',
            'progressbars_element_subtitle' => '',
            'wp_rem_var_progressbars_align' => ''
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
            $progressbars_num = count($atts_content);
        }
        $progressbars_element_size = '25';
        $progressbars_element_title = isset($progressbars_element_title) ? $progressbars_element_title : '';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_progressbars';
        $coloumn_class = 'column_' . $progressbars_element_size;

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        global $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $strings->wp_rem_cs_theme_option_field_strings();
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter); ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="progressbars" data="<?php echo wp_rem_cs_element_size_data_array_index($progressbars_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $progressbars_element_size, '', 'list-alt'); ?>
            <div class="cs-wrapp-class-<?php echo esc_attr($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter); ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter); ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
                <div class="cs-clone-append cs-pbwp-content" >
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo esc_attr($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/<?php echo esc_attr('wp_rem_cs_progressbar'); ?>]" data-shortcode-child-template="[<?php echo esc_attr('progressbar_item'); ?> {{attributes}}] {{content}} [/<?php echo esc_attr('progressbar_item'); ?>]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr('wp_rem_cs_progressbar'); ?> {{attributes}}]">
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
                                        'std' => esc_html($progressbars_element_title),
                                        'id' => 'progressbars_element_title',
                                        'cust_name' => 'progressbars_element_title[]',
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
                                        'std' => esc_attr($progressbars_element_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'progressbars_element_subtitle[]',
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
                                        'std' => $wp_rem_var_progressbars_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_progressbars_align',
                                        'cust_name' => 'wp_rem_var_progressbars_align[]',
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
                                ?>
                            </div>
                            <?php
                            if (isset($progressbars_num) && $progressbars_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $progressbars) {
                                    $rand_id = $wp_rem_cs_counter . '' . wp_rem_cs_generate_random_string(3);
                                    $defaults = array('progressbars_title' => '', 'progressbars_color' => '#4d8b0c', 'progressbars_percentage' => '50');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($progressbars['atts'][$key])) {
                                            $$key = $progressbars['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    echo '<div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content" id="wp_rem_cs_infobox_' . $rand_id . '">';
                                    ?>
                                    <header>
                                        <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar')); ?></h4>
                                        <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a></header>
                                    <?php
                                    $wp_rem_cs_opt_array = array(
                                        'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_title'),
                                        'desc' => '',
                                        'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_title_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => esc_html($progressbars_title),
                                            'id' => 'progressbars_title',
                                            'cust_name' => 'progressbars_title[]',
                                            'return' => true,
                                        ),
                                    );
                                    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                    $wp_rem_cs_opt_array = array(
                                        'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_skill'),
                                        'desc' => '',
                                        'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_skill_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => esc_html($progressbars_percentage),
                                            'id' => 'progressbars_percentage',
                                            'cust_name' => 'progressbars_percentage[]',
                                            'return' => true,
                                        ),
                                    );
                                    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                    $wp_rem_cs_opt_array = array(
                                        'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_color'),
                                        'desc' => '',
                                        'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_color_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => esc_html($progressbars_color),
                                            'id' => 'progressbars_color',
                                            'cust_name' => 'progressbars_color[]',
                                            'return' => true,
                                            'classes' => 'bg_color',
                                        ),
                                    );
                                    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
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
                            'std' => esc_attr($progressbars_num),
                            'id' => '',
                            'before' => '',
                            'after' => '',
                            'classes' => 'fieldCounter',
                            'extra_atr' => '',
                            'cust_id' => '',
                            'cust_name' => 'progressbars_num[]',
                            'return' => true,
                            'required' => false
                        );
                        echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array));
                        ?>
                    </div>
                    <div class="wrapptabbox cs-zero-padding">
                        <div class="opt-conts">
                            <ul class="form-elements noborder">
                                <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('progressbars', 'shortcode-item-<?php echo esc_js($wp_rem_cs_counter); ?>', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_progressbar_add_button')); ?></a> </li>
                                <div id="loading" class="shortcodeload"></div>
                            </ul>
                            <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                <ul class="form-elements insert-bg">
                                    <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', 'shortcode-item-<?php echo esc_js($wp_rem_cs_counter); ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                                </ul>
                                <div id="results-shortocde"></div>
                                <?php
                            } else {
                                $wp_rem_cs_opt_array = array(
                                    'std' => 'progressbars',
                                    'id' => '',
                                    'before' => '',
                                    'after' => '',
                                    'classes' => '',
                                    'extra_atr' => '',
                                    'cust_id' => '',
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
                                        'cust_id' => '',
                                        'cust_type' => 'button',
                                        'classes' => 'cs-admin-btn',
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
            </div>
        </div>
        <script>

            /*
             * modern selection box function
             */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
            /*
             * modern selection box function
             */
        </script>
        <?php
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_progressbars', 'wp_rem_cs_var_page_builder_progressbars');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_progressbar_callback')) {

    /**
     * Save data for progressbar shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_progressbar_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "progressbars" || $widget_type == "cs_progressbars") {
            $shortcode = $shortcode_item = '';

            $page_element_size = $data['progressbars_element_size'][$counters['wp_rem_cs_global_counter_progressbars']];
            $current_element_size = $data['progressbars_element_size'][$counters['wp_rem_cs_global_counter_progressbars']];

            if (isset($_POST['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $_POST['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($_POST['shortcode']['progressbars'][$counters['wp_rem_cs_shortcode_counter_progressbars']]);

                $element_settings = 'progressbars_element_size="' . $current_element_size . '"';
                $reg = '/progressbars_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_progressbars'] ++;
            } else {
                if (isset($_POST['progressbars_num'][$counters['wp_rem_cs_counter_progressbars']]) && $_POST['progressbars_num'][$counters['wp_rem_cs_counter_progressbars']] > 0) {
                    for ($i = 1; $i <= $_POST['progressbars_num'][$counters['wp_rem_cs_counter_progressbars']]; $i ++) {
                        $shortcode_item .= '[progressbar_item ';
                        if (isset($_POST['progressbars_title'][$counters['wp_rem_cs_counter_progressbars_node']]) && $_POST['progressbars_title'][$counters['wp_rem_cs_counter_progressbars_node']] != '') {
                            $shortcode_item .= 'progressbars_title="' . htmlspecialchars($_POST['progressbars_title'][$counters['wp_rem_cs_counter_progressbars_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($_POST['progressbars_percentage'][$counters['wp_rem_cs_counter_progressbars_node']]) && $_POST['progressbars_percentage'][$counters['wp_rem_cs_counter_progressbars_node']] != '') {
                            $shortcode_item .= 'progressbars_percentage="' . htmlspecialchars($_POST['progressbars_percentage'][$counters['wp_rem_cs_counter_progressbars_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($_POST['progressbars_color'][$counters['wp_rem_cs_counter_progressbars_node']]) && $_POST['progressbars_color'][$counters['wp_rem_cs_counter_progressbars_node']] != '') {
                            $shortcode_item .= 'progressbars_color="' . htmlspecialchars($_POST['progressbars_color'][$counters['wp_rem_cs_counter_progressbars_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .=']';
                        $counters['wp_rem_cs_counter_progressbars_node'] ++;
                    }
                }
                $element_settings = 'progressbars_element_size="' . htmlspecialchars($data['progressbars_element_size'][$counters['wp_rem_cs_global_counter_progressbars']]) . '"';
                $shortcode .= '[wp_rem_cs_progressbar ' . $element_settings . ' ';
                if (isset($_POST['progressbars_element_title'][$counters['wp_rem_cs_counter_progressbars']]) && $_POST['progressbars_element_title'][$counters['wp_rem_cs_counter_progressbars']] != '') {
                    $shortcode .= 'progressbars_element_title="' . htmlspecialchars($_POST['progressbars_element_title'][$counters['wp_rem_cs_counter_progressbars']], ENT_QUOTES) . '" ';
                }
                if (isset($_POST['wp_rem_var_progressbars_align'][$counters['wp_rem_cs_counter_progressbars']]) && $_POST['wp_rem_var_progressbars_align'][$counters['wp_rem_cs_counter_progressbars']] != '') {
                    $shortcode .= 'wp_rem_var_progressbars_align="' . htmlspecialchars($_POST['wp_rem_var_progressbars_align'][$counters['wp_rem_cs_counter_progressbars']], ENT_QUOTES) . '" ';
                }
                if (isset($_POST['progressbars_element_subtitle'][$counters['wp_rem_cs_counter_progressbars']]) && $_POST['progressbars_element_subtitle'][$counters['wp_rem_cs_counter_progressbars']] != '') {
                    $shortcode .= 'progressbars_element_subtitle="' . htmlspecialchars($_POST['progressbars_element_subtitle'][$counters['wp_rem_cs_counter_progressbars']], ENT_QUOTES) . '" ';
                }
                $shortcode .= ']' . $shortcode_item . '[/wp_rem_cs_progressbar]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_progressbars'] ++;
            }
            $counters['wp_rem_cs_global_counter_progressbars'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_progressbars', 'wp_rem_cs_save_page_builder_data_progressbar_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_progressbar_callback')) {

    /**
     * Populate progressbar shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_progressbar_callback($counters) {
        $counters['wp_rem_cs_counter_progressbars'] = 0;
        $counters['wp_rem_cs_counter_progressbars_node'] = 0;
        $counters['wp_rem_cs_global_counter_progressbars'] = 0;
        $counters['wp_rem_cs_shortcode_counter_progressbars'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_progressbar_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_progressbars_callback')) {

    /**
     * Populate progressbars shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_progressbars_callback($shortcode_array) {
        $shortcode_array['progressbars'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbars'),
            'name' => 'progressbars',
            'icon' => 'icon-list-alt',
            'categories' => ' loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_progressbars_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_progressbars_callback')) {

    /**
     * Populate progressbars shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_progressbars_callback($element_list) {
        $element_list['progressbars'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbars');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_progressbars_callback');
}

if (!function_exists('wp_rem_cs_shortcode_sub_element_ui_progressbars_callback')) {

    /**
     * Render UI for sub element in progressbars settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_progressbars_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];

        if ($type == 'progressbars') {
            $rand_id = rand(40, 9999999);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="wp_rem_cs_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbar'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbar_title'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbar_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'progressbars_title',
                        'cust_name' => 'progressbars_title[]',
                        'return' => true,
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbar_skill'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbar_skill_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '50',
                        'id' => 'progressbars_percentage',
                        'cust_name' => 'progressbars_percentage[]',
                        'return' => true,
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbar_color'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_progressbar_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '#4d8b0c',
                        'id' => 'progressbars_color',
                        'cust_name' => 'progressbars_color[]',
                        'return' => true,
                        'classes' => 'bg_color',
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                ?>

            </div>

            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_progressbars_callback');
}