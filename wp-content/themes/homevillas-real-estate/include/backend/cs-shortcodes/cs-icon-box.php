<?php
/*
 *
 * @Shortcode Name : icon_box
 * @retrun
 *
 */
if (!function_exists('wp_rem_cs_var_page_builder_icon_box')) {

    function wp_rem_cs_var_page_builder_icon_box($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $string = new wp_rem_cs_theme_all_strings;
        $string->wp_rem_cs_short_code_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $icon_boxes_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'icon_box|icon_boxes_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '1/1',
            'wp_rem_cs_var_icon_boxes_title' => '',
            'wp_rem_cs_var_icon_boxes_sub_title' => '',
            'wp_rem_cs_var_icon_boxes_element_sub_title' => '',
            'wp_rem_cs_var_icon_boxes_element_alignment' => '',
            'wp_rem_cs_var_icon_box_column' => '',
            'wp_rem_cs_var_icon_box_view' => '',
            'wp_rem_cs_title_color' => '',
            'wp_rem_cs_icon_box_content_color' => '',
            'wp_rem_cs_icon_box_icon_color' => '',
            'wp_rem_cs_var_icon_box_icon_size' => '',
            'wp_rem_cs_icon_box_content_align' => '',
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
            $icon_boxes_num = count($atts_content);
        }
        $icon_boxes_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $wp_rem_cs_var_icon_boxes_title = isset($wp_rem_cs_var_icon_boxes_title) ? $wp_rem_cs_var_icon_boxes_title : '';
        $wp_rem_cs_var_icon_boxes_sub_title = isset($wp_rem_cs_var_icon_boxes_sub_title) ? $wp_rem_cs_var_icon_boxes_sub_title : '';
        $wp_rem_cs_var_icon_boxes_element_sub_title = isset($wp_rem_cs_var_icon_boxes_element_sub_title) ? $wp_rem_cs_var_icon_boxes_element_sub_title : '';
        $wp_rem_cs_var_icon_boxes_element_alignment = isset($wp_rem_cs_var_icon_boxes_element_alignment) ? $wp_rem_cs_var_icon_boxes_element_alignment : '';
        
        $wp_rem_cs_var_icon_box_column = isset($wp_rem_cs_var_icon_box_column) ? $wp_rem_cs_var_icon_box_column : '';
        $wp_rem_cs_var_icon_box_view = isset($wp_rem_cs_var_icon_box_view) ? $wp_rem_cs_var_icon_box_view : '';
        $wp_rem_cs_title_color = isset($wp_rem_cs_title_color) ? $wp_rem_cs_title_color : '';
        $wp_rem_cs_icon_box_content_color = isset($wp_rem_cs_icon_box_content_color) ? $wp_rem_cs_icon_box_content_color : '';
        $wp_rem_cs_icon_box_icon_color = isset($wp_rem_cs_icon_box_icon_color) ? $wp_rem_cs_icon_box_icon_color : '';
        $wp_rem_cs_var_icon_box_icon_size = isset($wp_rem_cs_var_icon_box_icon_size) ? $wp_rem_cs_var_icon_box_icon_size : '';
        $wp_rem_cs_icon_box_content_align = isset($wp_rem_cs_icon_box_content_align) ? $wp_rem_cs_icon_box_content_align : '';
        $name = 'wp_rem_cs_var_page_builder_icon_box';
        $coloumn_class = 'column_' . $icon_boxes_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="icon_box" data="<?php echo wp_rem_cs_element_size_data_array_index($icon_boxes_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $icon_boxes_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_edit')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/icon_box]" data-shortcode-child-template="[icon_boxes_item {{attributes}}] {{content}} [/icon_boxes_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[icon_box {{attributes}}]">
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
                                        'std' => esc_attr($wp_rem_cs_var_icon_boxes_title),
                                        'cust_id' => '',
                                        'cust_name' => 'wp_rem_cs_var_icon_boxes_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_var_icon_boxes_element_sub_title),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_icon_boxes_element_sub_title[]',
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
                                        'std' => $wp_rem_cs_var_icon_boxes_element_alignment,
                                        'id' => '',
                                        'cust_name' => 'wp_rem_cs_var_icon_boxes_element_alignment[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_title_color'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_title_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($wp_rem_cs_icon_box_content_color),
                                        'id' => 'wp_rem_cs_icon_box_content_color',
                                        'cust_name' => 'wp_rem_cs_icon_box_content_color[]',
                                        'classes' => 'bg_color',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_text'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_content_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_icon_boxes_sub_title),
                                        'cust_id' => '',
                                        'cust_name' => 'wp_rem_cs_var_icon_boxes_sub_title[]',
                                        'return' => true,
                                        'classes' => '',
                                        'wp_rem_cs_editor' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_styles'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_styles_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_icon_box_view,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_cs_var_icon_box_view',
                                        'cust_name' => 'wp_rem_cs_var_icon_box_view[]',
                                        'classes' => 'wp_rem_cs_var_icon_box_view chosen-select select-medium',
                                        'options' => array(
                                            'fancy' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_style_fancy'),
                                            'has-border' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_style_has_border'),
                                            'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_style_modern'),
                                            'award' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_style_reward'),
                                            'boxed' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_style_boxed'),
                                            'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_style_classic'),
                                            'boxed-v2' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_style_box_v2'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_icon_box_content_align,
                                        'id' => '',
                                        'cust_name' => 'wp_rem_cs_icon_box_content_align[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            'left' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment_left'),
                                            'right' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment_right'),
                                            'top-center' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment_center'),
                                            'top-left' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment_top_left'),
                                            'top-right' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment_top_right'),
                                            'left-right' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_alignment_left_right'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_sel_col'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_sel_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($wp_rem_cs_var_icon_box_column),
                                        'cust_id' => 'wp_rem_cs_var_icon_box_column' . $wp_rem_cs_counter,
                                        'cust_name' => 'wp_rem_cs_var_icon_box_column[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            '1' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_one_col'),
                                            '2' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_two_col'),
                                            '3' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_three_col'),
                                            '4' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_four_col'),
                                            '6' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_six_col'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_title_color'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_title_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_title_color),
                                        'cust_id' => 'wp_rem_cs_title_color',
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_title_color[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_Icon_color'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_Icon_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($wp_rem_cs_icon_box_icon_color),
                                        'id' => 'wp_rem_cs_icon_box_icon_color',
                                        'cust_name' => 'wp_rem_cs_icon_box_icon_color[]',
                                        'classes' => 'bg_color',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_font_size'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_font_size_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_icon_box_icon_size,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_cs_var_icon_box_icon_size',
                                        'cust_name' => 'wp_rem_cs_var_icon_box_icon_size[]',
                                        'classes' => 'icon_box_postion chosen-select-no-single select-medium',
                                        'options' => array(
                                            'icon-1x' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_font_size_option_1'),
                                            'icon-2x' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_font_size_option_2'),
                                            'icon-3x' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_font_size_option_3'),
                                            'icon-4x' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_font_size_option_4'),
                                            'icon-5x' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_font_size_option_5'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                ?>
                            </div>
                            <?php
                            if (isset($icon_boxes_num) && $icon_boxes_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $icon_boxes) {
                                    $rand_string = rand(123456, 987654);
                                    $wp_rem_cs_var_icon_boxes_text = $icon_boxes['content'];
                                    $defaults = array(
                                        'wp_rem_cs_var_icon_box_title' => '',
                                        'wp_rem_cs_var_icon_boxes_icon' => '',
                                        'wp_rem_cs_var_icon_boxes_icon_group' => 'default',
                                        'wp_rem_cs_var_link_url' => '',
                                        'wp_rem_cs_var_icon_box_icon_type' => '',
                                        'wp_rem_cs_var_icon_box_image' => ''
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($icon_boxes['atts'][$key])) {
                                            $$key = $icon_boxes['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    $wp_rem_cs_var_icon_boxes_text = isset($wp_rem_cs_var_icon_boxes_text) ? $wp_rem_cs_var_icon_boxes_text : '';
                                    $wp_rem_cs_var_icon_box_title = isset($wp_rem_cs_var_icon_box_title) ? $wp_rem_cs_var_icon_box_title : '';
                                    $wp_rem_cs_var_icon_boxes_icon = isset($wp_rem_cs_var_icon_boxes_icon) ? $wp_rem_cs_var_icon_boxes_icon : '';
                                    $wp_rem_cs_var_icon_box_icon_color = isset($wp_rem_cs_var_icon_box_icon_color) ? $wp_rem_cs_var_icon_box_icon_color : '';
                                    $wp_rem_cs_var_link_url = isset($wp_rem_cs_var_link_url) ? $wp_rem_cs_var_link_url : '';
                                    $wp_rem_cs_var_icon_box_icon_type = isset($wp_rem_cs_var_icon_box_icon_type) ? $wp_rem_cs_var_icon_box_icon_type : '';
                                    $wp_rem_cs_var_icon_box_image = isset($wp_rem_cs_var_icon_box_image) ? $wp_rem_cs_var_icon_box_image : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_remove')); ?></a>
                                        </header>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_title'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_icon_box_title),
                                                'cust_id' => 'wp_rem_cs_var_icon_box_title',
                                                'classes' => '',
                                                'cust_name' => 'wp_rem_cs_var_icon_box_title[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_link_url'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_link_url_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_link_url),
                                                'cust_id' => 'wp_rem_cs_var_link_url',
                                                'classes' => '',
                                                'cust_name' => 'wp_rem_cs_var_link_url[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_type'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_type_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_icon_box_icon_type),
                                                'id' => 'wp_rem_cs_var_icon_box_icon_type',
                                                'cust_name' => 'wp_rem_cs_var_icon_box_icon_type[]',
                                                'classes' => 'chosen-select-no-single select-medium function-class',
                                                'options' => array(
                                                    'icon' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_type_1'),
                                                    'image' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_type_2'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                        ?>
                                        <div class="cs-sh-icon_box-image-area" style="display:<?php echo esc_html($wp_rem_cs_var_icon_box_icon_type == 'image' ? 'block' : 'none' ) ?>;">
                                            <?php
                                            $wp_rem_cs_opt_array = array(
                                                'std' => $wp_rem_cs_var_icon_box_image,
                                                'id' => 'icon_box_image_array',
                                                'main_id' => 'icon_box_image_array',
                                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field'),
                                                'desc' => '',
                                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_image_hint'),
                                                'echo' => true,
                                                'array' => true,
                                                'field_params' => array(
                                                    'std' => $wp_rem_cs_var_icon_box_image,
                                                    'cust_id' => '',
                                                    'cust_name' => 'wp_rem_cs_var_icon_box_image[]',
                                                    'id' => 'icon_box_image_array',
                                                    'return' => true,
                                                    'array' => true,
                                                ),
                                            );
                                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                                            $rand_id = rand(1111111, 9999999);
                                            ?>
                                        </div>
                                        <div class="cs-sh-icon_box-icon-area" style="display:<?php echo esc_html($wp_rem_cs_var_icon_box_icon_type != 'image' ? 'block' : 'none' ) ?>;">
                                            <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_icon')); ?></label>
                                                    <?php
                                                    if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                                                        echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_boxes_icon_hint'));
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <?php echo apply_filters( 'cs_icons_fields', $wp_rem_cs_var_icon_boxes_icon, esc_attr($rand_id), 'wp_rem_cs_var_icon_boxes_icon', $wp_rem_cs_var_icon_boxes_icon_group); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_content'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_icon_content_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_icon_boxes_text),
                                                'cust_id' => '',
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'cust_name' => 'wp_rem_cs_var_icon_boxes_text[]',
                                                'return' => true,
                                                'classes' => '',
                                                'wp_rem_cs_editor' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                        ?>
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                            <script type="text/javascript">
                                jQuery('.function-class').change(function ($) {
                                    var value = jQuery(this).val();
                                    var parentNode = jQuery(this).parent().parent().parent();
                                    if (value == 'image') {
                                        parentNode.find(".cs-sh-icon_box-image-area").show();
                                        parentNode.find(".cs-sh-icon_box-icon-area").hide();
                                    } else {
                                        parentNode.find(".cs-sh-icon_box-image-area").hide();
                                        parentNode.find(".cs-sh-icon_box-icon-area").show();
                                    }
                                }
                                );
                            </script>
                        </div>
                        <div class="hidden-object">
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_allow_special_char($icon_boxes_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'icon_boxes_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_icon_boxesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('icon_box', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_box_add')); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg noborder">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                    <?php
                                } else {
                                    $wp_rem_cs_opt_array = array(
                                        'std' => 'icon_box',
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => '',
                                        'extra_atr' => '',
                                        'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
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
                                            'cust_id' => 'icon_boxes_save' . $wp_rem_cs_counter,
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-wp_rem_cs-admin-btn',
                                            'cust_name' => 'icon_boxes_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_icon_box', 'wp_rem_cs_var_page_builder_icon_box');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_icon_box_callback')) {

    /**
     * Save data for icon_box shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_icon_box_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "icon_box" || $widget_type == "cs_icon_box") {
            $shortcode = $shortcode_item = '';

            $page_element_size = $data['icon_box_element_size'][$counters['wp_rem_cs_global_counter_icon_boxes']];
            $current_element_size = $data['icon_box_element_size'][$counters['wp_rem_cs_global_counter_icon_boxes']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($data['shortcode']['icon_box'][$counters['wp_rem_cs_shortcode_counter_icon_boxes']]);

                $element_settings = 'icon_box_element_size="' . $current_element_size . '"';
                $reg = '/icon_box_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_icon_boxes'] ++;
            } else {
                if (isset($data['icon_boxes_num'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['icon_boxes_num'][$counters['wp_rem_cs_counter_icon_boxes']] > 0) {
                    for ($i = 1; $i <= $data['icon_boxes_num'][$counters['wp_rem_cs_counter_icon_boxes']]; $i ++) {
                        $shortcode_item .= '[icon_boxes_item ';

                        if (isset($data['wp_rem_cs_var_icon_box_title'][$counters['wp_rem_cs_counter_icon_boxes_node']]) && $data['wp_rem_cs_var_icon_box_title'][$counters['wp_rem_cs_counter_icon_boxes_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_icon_box_title="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_title'][$counters['wp_rem_cs_counter_icon_boxes_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_link_url'][$counters['wp_rem_cs_counter_icon_boxes_node']]) && $data['wp_rem_cs_var_link_url'][$counters['wp_rem_cs_counter_icon_boxes_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_link_url="' . htmlspecialchars($data['wp_rem_cs_var_link_url'][$counters['wp_rem_cs_counter_icon_boxes_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_icon_boxes_icon'][$counters['wp_rem_cs_counter_icon_boxes_node']]) && $data['wp_rem_cs_var_icon_boxes_icon'][$counters['wp_rem_cs_counter_icon_boxes_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_icon_boxes_icon="' . htmlspecialchars($data['wp_rem_cs_var_icon_boxes_icon'][$counters['wp_rem_cs_counter_icon_boxes_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_icon_boxes_icon_group'][$counters['wp_rem_cs_counter_icon_boxes_node']]) && $data['wp_rem_cs_var_icon_boxes_icon_group'][$counters['wp_rem_cs_counter_icon_boxes_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_icon_boxes_icon_group="' . htmlspecialchars($data['wp_rem_cs_var_icon_boxes_icon_group'][$counters['wp_rem_cs_counter_icon_boxes_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_icon_box_icon_type'][$counters['wp_rem_cs_counter_icon_boxes_node']]) && $data['wp_rem_cs_var_icon_box_icon_type'][$counters['wp_rem_cs_counter_icon_boxes_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_icon_box_icon_type="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_icon_type'][$counters['wp_rem_cs_counter_icon_boxes_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_icon_box_image'][$counters['wp_rem_cs_counter_icon_boxes_node']]) && $data['wp_rem_cs_var_icon_box_image'][$counters['wp_rem_cs_counter_icon_boxes_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_icon_box_image="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_image'][$counters['wp_rem_cs_counter_icon_boxes_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if (isset($data['wp_rem_cs_var_icon_boxes_text'][$counters['wp_rem_cs_counter_icon_boxes_node']]) && $data['wp_rem_cs_var_icon_boxes_text'][$counters['wp_rem_cs_counter_icon_boxes_node']] != '') {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_icon_boxes_text'][$counters['wp_rem_cs_counter_icon_boxes_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/icon_boxes_item]';
                        $counters['wp_rem_cs_counter_icon_boxes_node'] ++;
                    }
                }
                $section_title = '';
                if (isset($data['wp_rem_cs_var_icon_boxes_title'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_var_icon_boxes_title'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_var_icon_boxes_title="' . htmlspecialchars($data['wp_rem_cs_var_icon_boxes_title'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_icon_boxes_element_sub_title'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_var_icon_boxes_element_sub_title'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_var_icon_boxes_element_sub_title="' . htmlspecialchars($data['wp_rem_cs_var_icon_boxes_element_sub_title'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }if (isset($data['wp_rem_cs_var_icon_boxes_element_alignment'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_var_icon_boxes_element_alignment'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_var_icon_boxes_element_alignment="' . htmlspecialchars($data['wp_rem_cs_var_icon_boxes_element_alignment'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_title_color'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_title_color'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_title_color="' . htmlspecialchars($data['wp_rem_cs_title_color'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_icon_box_content_color'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_icon_box_content_color'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_icon_box_content_color="' . htmlspecialchars($data['wp_rem_cs_icon_box_content_color'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_icon_box_icon_color'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_icon_box_icon_color'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_icon_box_icon_color="' . htmlspecialchars($data['wp_rem_cs_icon_box_icon_color'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_icon_box_icon_size'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_var_icon_box_icon_size'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_var_icon_box_icon_size="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_icon_size'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_icon_box_view'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_var_icon_box_view'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_var_icon_box_view="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_view'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_icon_box_content_align'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_icon_box_content_align'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_icon_box_content_align="' . htmlspecialchars($data['wp_rem_cs_icon_box_content_align'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_icon_boxes_sub_title'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_var_icon_boxes_sub_title'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_var_icon_boxes_sub_title="' . htmlspecialchars(str_replace('"', '\'', wp_rem_cs_custom_shortcode_encode($data['wp_rem_cs_var_icon_boxes_sub_title'][$counters['wp_rem_cs_counter_icon_boxes']]))) . '" ';
                }
                if (isset($data['wp_rem_cs_var_icon_box_column'][$counters['wp_rem_cs_counter_icon_boxes']]) && $data['wp_rem_cs_var_icon_box_column'][$counters['wp_rem_cs_counter_icon_boxes']] != '') {
                    $section_title .= 'wp_rem_cs_var_icon_box_column="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_column'][$counters['wp_rem_cs_counter_icon_boxes']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'icon_box_element_size="' . htmlspecialchars($data['icon_box_element_size'][$counters['wp_rem_cs_global_counter_icon_boxes']]) . '"';
                $shortcode = '[icon_box ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/icon_box]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_icon_boxes'] ++;
            }
            $counters['wp_rem_cs_global_counter_icon_boxes'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_icon_box', 'wp_rem_cs_save_page_builder_data_icon_box_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_icon_box_callback')) {

    /**
     * Populate spacer shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_icon_box_callback($counters) {
        $counters['wp_rem_cs_counter_icon_boxes'] = 0;
        $counters['wp_rem_cs_counter_icon_boxes_node'] = 0;
        $counters['wp_rem_cs_shortcode_counter_icon_boxes'] = 0;
        $counters['wp_rem_cs_global_counter_icon_boxes'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_icon_box_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_icon_box_callback')) {

    /**
     * Populate icon box shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_icon_box_callback($shortcode_array) {
        $shortcode_array['icon_box'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxs_title'),
            'name' => 'icon_box',
            'icon' => 'icon-database2',
            'categories' => 'loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_icon_box_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_icon_box_callback')) {

    /**
     * Populate icon box shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_icon_box_callback($element_list) {
        $element_list['icon_box'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxs_title');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_icon_box_callback');
}

if (!function_exists('wp_rem_cs_shortcode_sub_element_ui_icon_box_callback')) {

    /**
     * Render UI for sub element in icon box settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_icon_box_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];

        if ($type == 'icon_box') {
            $icon_boxes_count = 'icon_boxes_' . rand(455345, 23454390);
            if (isset($wp_rem_cs_var_icon_boxes_text) && $wp_rem_cs_var_icon_boxes_text != '') {
                $wp_rem_cs_var_icon_boxes_text = $wp_rem_cs_var_icon_boxes_text;
            } else {
                $wp_rem_cs_var_icon_boxes_text = '';
            }
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp' id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($icon_boxes_count); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxs_title'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_content_title'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_content_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'wp_rem_cs_var_icon_box_title',
                        'classes' => '',
                        'cust_name' => 'wp_rem_cs_var_icon_box_title[]',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_link_url'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_link_url_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'wp_rem_cs_var_link_url',
                        'classes' => '',
                        'cust_name' => 'wp_rem_cs_var_link_url[]',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_box_icon_type'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_box_icon_type_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'wp_rem_cs_var_icon_box_icon_type',
                        'cust_name' => 'wp_rem_cs_var_icon_box_icon_type[]',
                        'classes' => 'chosen-select-no-single select-medium function-class',
                        'options' => array(
                            'icon' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_box_icon_type_1'),
                            'image' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_box_icon_type_2'),
                        ),
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                $rand_id = rand(123450, 854987);
                ?>	 				

                <div class="cs-sh-icon_box-image-area" style="display:none;">
                    <?php
                    $wp_rem_cs_opt_array = array(
                        'std' => '',
                        'id' => 'icon_box_image_array',
                        'main_id' => 'icon_box_image_array',
                        'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_box_image'),
                        'desc' => '',
                        'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_box_image_hint'),
                        'echo' => true,
                        'array' => true,
                        'field_params' => array(
                            'std' => '',
                            'cust_id' => '',
                            'cust_name' => 'wp_rem_cs_var_icon_box_image[]',
                            'id' => 'icon_box_image_array',
                            'return' => true,
                            'array' => true,
                        ),
                    );
                    $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                    $rand_id = rand(1111111, 9999999);
                    ?>
                </div>
                <div class="cs-sh-icon_box-icon-area" style="display:block;">
                    <div class="form-elements" id="<?php echo esc_attr($rand_id); ?>">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_Icon'); ?></label>
                            <?php
                            if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                                echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_Icon_hint'));
                            }
                            ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <?php echo apply_filters( 'cs_icons_fields','', $rand_id, 'wp_rem_cs_var_icon_boxes_icon'); ?>
                        </div>
                    </div>

                </div>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_text'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_boxes_text_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_icon_boxes_text[]',
                        'return' => true,
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'classes' => '',
                        'wp_rem_cs_editor' => true,
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                ?>
            </div>
            <script type="text/javascript">
                jQuery('.function-class').change(function ($) {
                    var value = jQuery(this).val();

                    var parentNode = jQuery(this).parent().parent().parent();
                    if (value == 'image') {
                        parentNode.find(".cs-sh-icon_box-image-area").show();
                        parentNode.find(".cs-sh-icon_box-icon-area").hide();
                    } else {
                        parentNode.find(".cs-sh-icon_box-image-area").hide();
                        parentNode.find(".cs-sh-icon_box-icon-area").show();
                    }

                }
                );
            </script>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_icon_box_callback');
}