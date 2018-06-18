<?php
/*
 *
 * @Shortcode Name : counter
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_counter') ) {

    function wp_rem_cs_var_page_builder_counter($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_counters_view, $style_modern;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $counter_num = 0;
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'counter|counter_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }

        $defaults = array(
            'wp_rem_cs_var_column_size' => '1/1',
            'wp_rem_cs_counter_title' => '',
            'wp_rem_cs_counter_subtitle' => '',
            'wp_rem_var_counter_align' => '',
            'wp_rem_cs_var_counter_col' => '',
            'wp_rem_cs_var_icon_color' => '',
            'wp_rem_cs_var_count_color' => '',
            'wp_rem_cs_var_counters_view' => '',
            'wp_rem_cs_var_icon_title_color'=>'',
        );
        if ( isset($output['0']['atts']) ) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if ( isset($output['0']['content']) ) {
            $atts_content = $output['0']['content'];
        } else {
            $atts_content = array();
        }
        if ( is_array($atts_content) ) {
            $counter_num = count($atts_content);
        }
        $counter_element_size = '100';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $wp_rem_cs_counter_title = isset($wp_rem_cs_counter_title) ? $wp_rem_cs_counter_title : '';
        $wp_rem_cs_var_counter_col = isset($wp_rem_cs_var_counter_col) ? $wp_rem_cs_var_counter_col : '';
        $wp_rem_cs_var_icon_color = isset($wp_rem_cs_var_icon_color) ? $wp_rem_cs_var_icon_color : '';
        $wp_rem_cs_var_count_color = isset($wp_rem_cs_var_count_color) ? $wp_rem_cs_var_count_color : '';
        $wp_rem_cs_var_counters_view = isset($wp_rem_cs_var_counters_view) ? $wp_rem_cs_var_counters_view : '';

        $name = 'wp_rem_cs_var_page_builder_counter';
        $coloumn_class = 'column_' . $counter_element_size;
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        global $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="counter" data="<?php echo wp_rem_cs_element_size_data_array_index($counter_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $counter_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_counter_edit_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/counter]" data-shortcode-child-template="[multiple_counter_item {{attributes}}] {{content}} [/multiple_counter_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[counter {{attributes}}]">
                                <?php
                                if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                                    wp_rem_cs_shortcode_element_size();
                                }
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_counter_title),
                                        'cust_id' => '',
                                        'cust_name' => 'wp_rem_cs_counter_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_counter_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_counter_subtitle[]',
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
                                        'std' => $wp_rem_var_counter_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_counter_align',
                                        'cust_name' => 'wp_rem_var_counter_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_style'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_style_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_counters_view,
                                        'id' => 'counters_view',
                                        'cust_name' => 'wp_rem_cs_var_counters_view[]',
                                        'classes' => 'dropdown chosen-select',
                                        'extra_atr' => ' onchange="javascript:wp_rem_counter_modern(this.value)"',
                                        'options' => array(
                                            'default' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default'),
                                            'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_modern'),
                                            'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_classic'),
                                            'classic_v2' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_client_style_classic_v2'),
                                        ),
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sel_col'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sel_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_counter_col,
                                        'id' => '',
                                        'cust_name' => 'wp_rem_cs_var_counter_col[]',
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
                                $style_modern = '';
                                if ( $wp_rem_cs_var_counters_view == 'modern' || $wp_rem_cs_var_counters_view == 'classic' ) {
                                    $style_modern = ' style="display:none;" ';
                                }
                                
                                $icon_style_modern = '';
                                if ( $wp_rem_cs_var_counters_view == 'modern' ) {
                                    $icon_style_modern = ' style="display:none;" ';
                                }
                                
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_counter_title_color'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_icon_title_color),
                                        'cust_id' => 'wp_rem_cs_var_icon_title_color',
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_icon_title_color[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                
                                
                                echo '<div class="modern-hide-show" ' . $style_modern . '>';

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_icon_color'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_icon_color_tooltip'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_icon_color),
                                        'cust_id' => 'wp_rem_cs_var_icon_color',
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_icon_color[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_count_color'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_count_color_tooltip'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_count_color),
                                        'cust_id' => 'wp_rem_cs_var_count_color',
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_count_color[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                echo '</div>';
                                ?>

                                <script>
                                    function wp_rem_counter_modern(view) {
                                        if (view == 'modern' || view == 'classic') {
                                            $('.modern-hide-show').hide();
                                        } else {
                                            $('.modern-hide-show').show();
                                        }
                                        if (view == 'modern') {
                                            $('.modern-hide-show-iocn').hide();
                                        } else {
                                            $('.modern-hide-show-iocn').show();
                                        }

                                    }
                                </script>


                            </div>
                            <?php
                            if ( isset($counter_num) && $counter_num <> '' && isset($atts_content) && is_array($atts_content) ) {
                                foreach ( $atts_content as $counter ) {
                                    $rand_string = rand(123456, 987654);
                                    $wp_rem_cs_var_counter_text = $counter['content'];
                                    $defaults = array(
                                        'wp_rem_cs_var_icon' => '',
                                        'wp_rem_cs_var_icon_group' => 'default',
                                        'wp_rem_cs_var_title' => '',
                                        'wp_rem_cs_var_count' => '',
                                    );
                                    foreach ( $defaults as $key => $values ) {
                                        if ( isset($counter['atts'][$key]) ) {
                                            $$key = $counter['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    $wp_rem_cs_var_icon = isset($wp_rem_cs_var_icon) ? $wp_rem_cs_var_icon : '';
                                    $wp_rem_cs_var_title = isset($wp_rem_cs_var_title) ? $wp_rem_cs_var_title : '';
                                    $wp_rem_cs_var_count = isset($wp_rem_cs_var_count) ? $wp_rem_cs_var_count : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="wp_rem_cs_counter_<?php echo wp_rem_cs_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a>
                                        </header>
                                        <div class="modern-hide-show-iocn" <?php echo ($icon_style_modern); ?>>
                                            <div class="form-elements" id="<?php echo esc_attr($rand_string); ?>">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_icon')); ?></label>
                                                    <?php
                                                    if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                                                        echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_icon_tooltip'));
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <?php //echo wp_rem_cs_var_icomoon_icons_box(esc_attr($wp_rem_cs_var_icon), $rand_string, 'wp_rem_cs_var_icon'); ?>
                                                    <?php echo apply_filters( 'cs_icons_fields', esc_attr($wp_rem_cs_var_icon), $rand_string, 'wp_rem_cs_var_icon', $wp_rem_cs_var_icon_group ); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_title'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_title),
                                                'cust_id' => 'wp_rem_cs_var_title',
                                                'classes' => '',
                                                'cust_name' => 'wp_rem_cs_var_title[]',
                                                'return' => true,
                                            ),
                                        );

                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_count'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_multiple_counter_count_tooltip'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_count),
                                                'cust_id' => 'wp_rem_cs_var_count',
                                                'classes' => '',
                                                'cust_name' => 'wp_rem_cs_var_count[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        echo '<div class="modern-hide-show" ' . $style_modern . '>';

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_content'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_content_tooltip'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_counter_text),
                                                'cust_id' => '',
                                                'cust_name' => 'wp_rem_cs_var_counter_text[]',
                                                'return' => true,
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'classes' => '',
                                                'wp_rem_cs_editor' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                        echo '</div>';
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
                                'std' => wp_rem_cs_allow_special_char($counter_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'counter_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>

                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_counterss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('counter', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add_counter')); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                                    <ul class="form-elements insert-bg noborder">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                    <?php
                                } else {
                                    $wp_rem_cs_opt_array = array(
                                        'std' => 'counter',
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
                                            'cust_id' => 'counter_save' . $wp_rem_cs_counter,
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-wp_rem_cs-admin-btn',
                                            'cust_name' => 'counter_save',
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
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_counter', 'wp_rem_cs_var_page_builder_counter');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_counter_callback') ) {

    /**
     * Save data for counter shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_counter_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ( $widget_type == "counter" || $widget_type == "cs_counter" ) {

            $shortcode = $shortcode_item = '';
            $page_element_size = $data['counter_element_size'][$counters['wp_rem_cs_global_counter_counter']];
            $current_element_size = $data['counter_element_size'][$counters['wp_rem_cs_global_counter_counter']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($data['shortcode']['counter'][$counters['wp_rem_cs_shortcode_counter_counter']]);

                $element_settings = 'counter_element_size="' . $current_element_size . '"';
                $reg = '/counter_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_counter'] ++;
            } else {

                if ( isset($data['counter_num'][$counters['wp_rem_cs_counter_counter']]) && $data['counter_num'][$counters['wp_rem_cs_counter_counter']] > 0 ) {

                    for ( $i = 1; $i <= $data['counter_num'][$counters['wp_rem_cs_counter_counter']]; $i ++ ) {
                        $shortcode_item .= '[counter_item ';
                        if ( isset($data['wp_rem_cs_var_icon'][$counters['wp_rem_cs_counter_counter_node']]) && $data['wp_rem_cs_var_icon'][$counters['wp_rem_cs_counter_counter_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_icon="' . htmlspecialchars($data['wp_rem_cs_var_icon'][$counters['wp_rem_cs_counter_counter_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_icon_group'][$counters['wp_rem_cs_counter_counter_node']]) && $data['wp_rem_cs_var_icon_group'][$counters['wp_rem_cs_counter_counter_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_icon_group="' . htmlspecialchars($data['wp_rem_cs_var_icon_group'][$counters['wp_rem_cs_counter_counter_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_title'][$counters['wp_rem_cs_counter_counter_node']]) && $data['wp_rem_cs_var_title'][$counters['wp_rem_cs_counter_counter_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_title="' . $data['wp_rem_cs_var_title'][$counters['wp_rem_cs_counter_counter_node']] . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_count'][$counters['wp_rem_cs_counter_counter_node']]) && $data['wp_rem_cs_var_count'][$counters['wp_rem_cs_counter_counter_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_count="' . $data['wp_rem_cs_var_count'][$counters['wp_rem_cs_counter_counter_node']] . '" ';
                        }
                        $shortcode_item .= ']';
                        if ( isset($data['wp_rem_cs_var_counter_text'][$counters['wp_rem_cs_counter_counter_node']]) && $data['wp_rem_cs_var_counter_text'][$counters['wp_rem_cs_counter_counter_node']] != '' ) {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_counter_text'][$counters['wp_rem_cs_counter_counter_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/counter_item]';
                        $counters['wp_rem_cs_counter_counter_node'] ++;
                    }
                }

                $section_title = '';
                if ( isset($data['wp_rem_cs_counter_title'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_cs_counter_title'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_cs_counter_title="' . htmlspecialchars($data['wp_rem_cs_counter_title'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_counter_subtitle'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_cs_counter_subtitle'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_cs_counter_subtitle="' . htmlspecialchars($data['wp_rem_cs_counter_subtitle'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_counter_align'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_var_counter_align'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_var_counter_align="' . htmlspecialchars($data['wp_rem_var_counter_align'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_counter_col'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_cs_var_counter_col'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_counter_col="' . htmlspecialchars($data['wp_rem_cs_var_counter_col'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_icon_title_color'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_cs_var_icon_title_color'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_icon_title_color="' . htmlspecialchars($data['wp_rem_cs_var_icon_title_color'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_icon_color'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_cs_var_icon_color'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_icon_color="' . htmlspecialchars($data['wp_rem_cs_var_icon_color'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_count_color'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_cs_var_count_color'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_count_color="' . htmlspecialchars($data['wp_rem_cs_var_count_color'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_counters_view'][$counters['wp_rem_cs_counter_counter']]) && $data['wp_rem_cs_var_counters_view'][$counters['wp_rem_cs_counter_counter']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_counters_view="' . htmlspecialchars($data['wp_rem_cs_var_counters_view'][$counters['wp_rem_cs_counter_counter']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'counter_element_size="' . htmlspecialchars($data['counter_element_size'][$counters['wp_rem_cs_global_counter_counter']]) . '"';
                $shortcode = '[counter ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/counter]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_counter'] ++;
            }
            $counters['wp_rem_cs_global_counter_counter'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_counter', 'wp_rem_cs_save_page_builder_data_counter_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_counter_callback') ) {

    /**
     * Populate counter shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_counter_callback($counters) {
        $counters['wp_rem_cs_counter_counter'] = 0;
        $counters['wp_rem_cs_counter_counter_node'] = 0;
        $counters['wp_rem_cs_shortcode_counter_counter'] = 0;
        $counters['wp_rem_cs_global_counter_counter'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_counter_callback');
}
if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_counter_callback') ) {

    /**
     * Populate list shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_counter_callback($shortcode_array) {
        $shortcode_array['counter'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter'),
            'name' => 'counter',
            'icon' => 'icon-clock-o',
            'categories' => 'loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_counter_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_counter_callback') ) {

    /**
     * Populate counter shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_counter_callback($element_list) {
        $element_list['counter'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_counter_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_sub_element_ui_counter_callback') ) {

    /**
     * Render UI for sub element in list settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_counter_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];
        $style_modern;

        if ( $type == 'counter' ) {

            $multiple_counter_count = 'multiple_counter_' . rand(455345, 23454390);
            if ( isset($wp_rem_cs_var_counter_text) && $wp_rem_cs_var_counter_text != '' ) {
                $wp_rem_cs_var_counter_text = $wp_rem_cs_var_counter_text;
            } else {
                $wp_rem_cs_var_counter_text = '';
            }
            ?>
            <script>
                var counter_view = $('#wp_rem_cs_var_counters_view').val();
                if (counter_view == 'modern' || counter_view == 'classic') {
                    $('.modern-hide-show').hide();
                } else {
                    $('.modern-hide-show').show();
                }
                if (counter_view == 'modern') {
                    $('.modern-hide-show-iocn').hide();
                } else {
                    $('.modern-hide-show-iocn').show();
                }
            </script>
            <div class='cs-wrapp-clone cs-shortcode-wrapp' id="wp_rem_cs_counter_<?php echo wp_rem_cs_allow_special_char($multiple_counter_count); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php
                        echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove');
                        ?></a>
                </header>
                <div class="modern-hide-show-iocn">
                    <div class="form-elements" id="<?php echo esc_attr($multiple_counter_count); ?>">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_icon'); ?></label>
                            <?php
                            if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                                echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_icon_tooltip'));
                            }
                            ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <?php //echo wp_rem_cs_var_icomoon_icons_box('', $multiple_counter_count, 'wp_rem_cs_var_icon'); ?>
                            <?php echo apply_filters( 'cs_icons_fields', '', $multiple_counter_count, 'wp_rem_cs_var_icon' ); ?>
                        </div>
                    </div>
                </div>


                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_title'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'wp_rem_cs_var_title',
                        'classes' => '',
                        'cust_name' => 'wp_rem_cs_var_title[]',
                        'return' => true,
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_count'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_count_tooltip'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => 'wp_rem_cs_var_count',
                        'classes' => '',
                        'cust_name' => 'wp_rem_cs_var_count[]',
                        'return' => true,
                    ),
                );

                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                echo '<div class="modern-hide-show">';
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_content'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_multiple_counter_content_tooltip'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_counter_text[]',
                        'return' => true,
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'classes' => '',
                        'wp_rem_cs_editor' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                echo '</div>';
                ?>
            </div>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_counter_callback');
}