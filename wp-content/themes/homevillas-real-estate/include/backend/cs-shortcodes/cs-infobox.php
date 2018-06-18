<?php
/*
 *
 * @Shortcode Name : Button
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_page_builder_infobox') ) {

    function wp_rem_cs_var_page_builder_infobox($die = 0) {
        global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $PREFIX = 'wp_rem_cs_infobox|infobox_item';
        $parseObject = new ShortcodeParse();
        $infobox_num = 0;
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_infobox_main_title' => '',
            'wp_rem_cs_var_infobox_main_subtitle' => '',
            'wp_rem_var_infobox_align' => '',
            'wp_rem_cs_var_info_icon_color' => '',
            'wp_rem_cs_var_info_heading_color'=>'',
            'wp_rem_var_infobox_styles' => '',
            'infobox_get_in_touch_url' => '',
            'infobox_get_in_touch_text' => '',
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
            $infobox_num = count($atts_content);
        }
        $infobox_element_size = '50';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_infobox';
        $coloumn_class = 'column_' . $infobox_element_size;
        $wp_rem_cs_var_infobox_main_title = isset($wp_rem_cs_var_infobox_main_title) ? $wp_rem_cs_var_infobox_main_title : '';
        $wp_rem_cs_var_info_icon_color = isset($wp_rem_cs_var_info_icon_color) ? $wp_rem_cs_var_info_icon_color : '';
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="infobox" data="<?php echo wp_rem_cs_element_size_data_array_index($infobox_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $infobox_element_size, '', 'list-ul'); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[<?php echo esc_attr(WP_REM_SC_ACCORDION); ?> {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_edit_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}}[/<?php echo esc_attr('wp_rem_cs_infobox'); ?>]" data-shortcode-child-template="[<?php echo esc_attr('infobox_item'); ?> {{attributes}}] {{content}} [/<?php echo esc_attr('infobox_item'); ?>]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr('wp_rem_cs_infobox'); ?> {{attributes}}]">
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_infobox_main_title),
                                        'id' => 'wp_rem_cs_var_infobox_main_title',
                                        'cust_name' => 'wp_rem_cs_var_infobox_main_title[]',
                                        'classes' => '',
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
                                        'std' => esc_attr($wp_rem_cs_var_infobox_main_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_infobox_main_subtitle[]',
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
                                        'std' => $wp_rem_var_infobox_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_infobox_align',
                                        'cust_name' => 'wp_rem_var_infobox_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_views'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_var_infobox_styles,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_infobox_views',
                                        'cust_name' => 'wp_rem_var_infobox_styles[]',
                                        'classes' => 'chosen-select-no-single select-medium',
                                        'extra_atr' => 'onchange="javascript:rem_change_infobox_view(this.value)"',
                                        'options' => array(
                                            'simple' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_view_simple'),
                                            'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_views_moder'),
                                            'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_views_classic'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
                                $button_style = '';
                                if ( $wp_rem_var_infobox_styles != 'classic' ) {
                                    $button_style = ' style="display:none"';
                                }
                                $icon_style = '';
                                if ( $wp_rem_var_infobox_styles == 'classic' ) {
                                    $icon_style = ' style="display:none"';
                                }
                                ?>
                                <script>
                                    function rem_change_infobox_view(view) {
                                        if (view == 'classic') {
                                            jQuery('.infobox-view-dynamic').show();
                                            jQuery('.infobox-view-dynamic-icon').hide();
                                        } else {
                                            jQuery('.infobox-view-dynamic-icon').show();
                                            jQuery('.infobox-view-dynamic').hide();
                                        }
                                    }
                                </script>
                                <?php
                                echo '<div class="infobox-view-dynamic"' . $button_style . '>';
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_buttton_text'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_buttton_text_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($infobox_get_in_touch_text),
                                        'classes' => '',
                                        'cust_name' => 'infobox_get_in_touch_text[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_buttton_text_url'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_buttton_text_url_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($infobox_get_in_touch_url),
                                        'classes' => '',
                                        'cust_name' => 'infobox_get_in_touch_url[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                echo '</div>';

                                if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                                    wp_rem_cs_shortcode_element_size();
                                }


                                echo '<div class="infobox-view-dynamic-icon" ' . wp_rem_cs_allow_special_char($icon_style) . '>';
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_icon_color'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_icon_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_info_icon_color),
                                        'cust_id' => 'wp_rem_cs_var_info_icon_color' . $wp_rem_cs_counter,
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_info_icon_color[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                echo '</div>';
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_heading_color'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_info_heading_color),
                                        'cust_id' => 'wp_rem_cs_var_info_heading_color' . $wp_rem_cs_counter,
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_info_heading_color[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                ?>
                            </div>
                                <?php
                                if ( isset($infobox_num) && $infobox_num <> '' && isset($atts_content) && is_array($atts_content) ) {
                                    foreach ( $atts_content as $infobox ) {
                                        $rand_id = rand(3333, 99999);
                                        $wp_rem_cs_var_infobox_text = $infobox['content'];
                                        $defaults = array( 'wp_rem_cs_var_infobox_title' => '', 'wp_rem_cs_var_infobox_active' => 'yes', 'wp_rem_cs_var_icon_box' => '', 'wp_rem_cs_var_icon_box_group' => '' );
                                        foreach ( $defaults as $key => $values ) {
                                            if ( isset($infobox['atts'][$key]) )
                                                $$key = $infobox['atts'][$key];
                                            else
                                                $$key = $values;
                                        }
                                        $wp_rem_cs_var_infobox_active = isset($wp_rem_cs_var_infobox_active) ? $wp_rem_cs_var_infobox_active : '';
                                        $wp_rem_cs_var_infobox_title = isset($wp_rem_cs_var_infobox_title) ? $wp_rem_cs_var_infobox_title : '';
                                        ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a></header>
                                        <div class="infobox-view-dynamic-icon"<?php echo wp_rem_cs_allow_special_char($icon_style); ?>>
                                            <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_icon')); ?></label>
                <?php
                if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                    echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_icon_hint'));
                }
                ?>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <?php echo apply_filters( 'cs_icons_fields', $wp_rem_cs_var_icon_box, esc_attr($rand_id), 'wp_rem_cs_var_icon_box', $wp_rem_cs_var_icon_box_group); ?>
                                                </div>
                                            </div>
                                        </div>

                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_title'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_var_infobox_title),
                        'classes' => '',
                        'cust_name' => 'wp_rem_cs_var_infobox_title[]',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_content'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_content_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_infobox_text),
                        'id' => 'wp_rem_cs_var_infobox_text',
                        'cust_name' => 'wp_rem_cs_var_infobox_text[]',
                        'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                        'classes' => '',
                        'return' => true,
                    //'wp_rem_cs_editor' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
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
                                'std' => $infobox_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'infobox_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('infobox', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add_infobox')); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
        <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                                    <ul class="form-elements insert-bg">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
            <?php
        } else {
            $wp_rem_cs_opt_array = array(
                'std' => 'infobox',
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
        </div>

        <?php
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_infobox', 'wp_rem_cs_var_page_builder_infobox');
}


if ( ! function_exists('wp_rem_cs_save_page_builder_data_infobox_callback') ) {

    /**
     * Save data for infobox shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_infobox_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ( $widget_type == "infobox" || $widget_type == "cs_infobox" ) {
            $shortcode = $shortcode_item = '';
            $page_element_size = $data['infobox_element_size'][$counters['wp_rem_cs_global_counter_infobox']];
            $current_element_size = $data['infobox_element_size'][$counters['wp_rem_cs_global_counter_infobox']];
            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($data['shortcode']['infobox'][$counters['wp_rem_cs_shortcode_counter_infobox']]);

                $element_settings = 'infobox_element_size="' . $current_element_size . '"';
                $reg = '/infobox_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_infobox'] ++;
            } else {
                if ( isset($data['infobox_num'][$counters['wp_rem_cs_counter_infobox']]) && $data['infobox_num'][$counters['wp_rem_cs_counter_infobox']] > 0 ) {
                    for ( $i = 1; $i <= $data['infobox_num'][$counters['wp_rem_cs_counter_infobox']]; $i ++ ) {
                        $shortcode_item .= '[infobox_item ';
                        if ( isset($data['wp_rem_cs_var_icon_box'][$counters['wp_rem_cs_counter_infobox_node']]) && $data['wp_rem_cs_var_icon_box'][$counters['wp_rem_cs_counter_infobox_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_icon_box="' . htmlspecialchars($data['wp_rem_cs_var_icon_box'][$counters['wp_rem_cs_counter_infobox_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_icon_box_group'][$counters['wp_rem_cs_counter_infobox_node']]) && $data['wp_rem_cs_var_icon_box_group'][$counters['wp_rem_cs_counter_infobox_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_icon_box_group="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_group'][$counters['wp_rem_cs_counter_infobox_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_infobox_title'][$counters['wp_rem_cs_counter_infobox_node']]) && $data['wp_rem_cs_var_infobox_title'][$counters['wp_rem_cs_counter_infobox_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_infobox_title="' . htmlspecialchars($data['wp_rem_cs_var_infobox_title'][$counters['wp_rem_cs_counter_infobox_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if ( isset($data['wp_rem_cs_var_infobox_text'][$counters['wp_rem_cs_counter_infobox_node']]) && $data['wp_rem_cs_var_infobox_text'][$counters['wp_rem_cs_counter_infobox_node']] != '' ) {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_infobox_text'][$counters['wp_rem_cs_counter_infobox_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/infobox_item]';
                        $counters['wp_rem_cs_counter_infobox_node'] ++;
                    }
                }
                $section_title = '';
                if ( isset($data['wp_rem_cs_var_infobox_main_title'][$counters['wp_rem_cs_counter_infobox']]) && $data['wp_rem_cs_var_infobox_main_title'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_infobox_main_title="' . htmlspecialchars($data['wp_rem_cs_var_infobox_main_title'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['infobox_get_in_touch_text'][$counters['wp_rem_cs_counter_infobox']]) && $data['infobox_get_in_touch_text'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'infobox_get_in_touch_text="' . htmlspecialchars($data['infobox_get_in_touch_text'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['infobox_get_in_touch_url'][$counters['wp_rem_cs_counter_infobox']]) && $data['infobox_get_in_touch_url'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'infobox_get_in_touch_url="' . htmlspecialchars($data['infobox_get_in_touch_url'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_infobox_styles'][$counters['wp_rem_cs_counter_infobox']]) && $data['wp_rem_var_infobox_styles'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'wp_rem_var_infobox_styles="' . htmlspecialchars($data['wp_rem_var_infobox_styles'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_infobox_align'][$counters['wp_rem_cs_counter_infobox']]) && $data['wp_rem_var_infobox_align'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'wp_rem_var_infobox_align="' . htmlspecialchars($data['wp_rem_var_infobox_align'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_infobox_main_subtitle'][$counters['wp_rem_cs_counter_infobox']]) && $data['wp_rem_cs_var_infobox_main_subtitle'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_infobox_main_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_infobox_main_subtitle'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_info_icon_color'][$counters['wp_rem_cs_counter_infobox']]) && $data['wp_rem_cs_var_info_icon_color'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_info_icon_color="' . htmlspecialchars($data['wp_rem_cs_var_info_icon_color'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_info_heading_color'][$counters['wp_rem_cs_counter_infobox']]) && $data['wp_rem_cs_var_info_heading_color'][$counters['wp_rem_cs_counter_infobox']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_info_heading_color="' . htmlspecialchars($data['wp_rem_cs_var_info_heading_color'][$counters['wp_rem_cs_counter_infobox']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'infobox_element_size="' . htmlspecialchars($data['infobox_element_size'][$counters['wp_rem_cs_global_counter_infobox']]) . '"';
                $shortcode = '[wp_rem_cs_infobox ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/wp_rem_cs_infobox]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_infobox'] ++;
            }
            $counters['wp_rem_cs_global_counter_infobox'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_infobox', 'wp_rem_cs_save_page_builder_data_infobox_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_infobox_callback') ) {

    /**
     * Populate infobox shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_infobox_callback($counters) {
        $counters['wp_rem_cs_global_counter_infobox'] = 0;
        $counters['wp_rem_cs_shortcode_counter_infobox'] = 0;
        $counters['wp_rem_cs_counter_infobox_node'] = 0;
        $counters['wp_rem_cs_counter_infobox'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_infobox_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_infobox_callback') ) {

    /**
     * Populate infobox shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_infobox_callback($shortcode_array) {
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $shortcode_array['infobox'] = array(
            'title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox'),
            'name' => 'infobox',
            'icon' => 'fa icon-info-circle',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_infobox_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_infobox_callback') ) {

    /**
     * Populate infobox shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_infobox_callback($element_list) {
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $element_list['infobox'] = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_infobox_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_sub_element_ui_infobox_callback') ) {

    /**
     * Render UI for sub element in infobox settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_infobox_callback($args) {
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];
        if ( $type == 'infobox' ) {
            $wp_rem_cs_var_active = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_active');
            $wp_rem_cs_var_infobox_active_hint = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_active_hint');
            $wp_rem_cs_var_infobox_title = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_title');
            $wp_rem_cs_var_infobox_title_hint = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_title_hint');
            $wp_rem_cs_var_infobox_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_content');
            $wp_rem_cs_var_infobox_text_hint = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_content_hint');
            $rand_id = rand(324235, 993249);
            ?>
            <script>
                var view_infobox = jQuery('#wp_rem_infobox_views').val();
                if (view_infobox == 'classic') {
                    jQuery('.infobox-view-dynamic-icon').hide();
                }
            </script>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="wp_rem_cs_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox')); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a>
                </header>

                <div class="infobox-view-dynamic-icon">
                    <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_icon')); ?></label>
            <?php
            if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_icon_hint'));
            }
            ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <?php echo apply_filters( 'cs_icons_fields', '', esc_attr($rand_id), 'wp_rem_cs_var_icon_box'); ?>
                        </div>
                    </div>
                </div>

            <?php
            $wp_rem_cs_opt_array = array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_title'),
                'desc' => '',
                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_infobox_title_hint'),
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'classes' => '',
                    'cust_name' => 'wp_rem_cs_var_infobox_title[]',
                    'return' => true,
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


            $wp_rem_cs_opt_array = array(
                'name' => $wp_rem_cs_var_infobox_text,
                'desc' => '',
                'hint_text' => $wp_rem_cs_var_infobox_text_hint,
                'echo' => true,
                'field_params' => array(
                    'std' => '',
                    'id' => 'wp_rem_cs_var_infobox_text',
                    'cust_name' => 'wp_rem_cs_var_infobox_text[]',
                    'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                    'return' => true,
                    'classes' => '',
                //'wp_rem_cs_editor' => true
                ),
            );
            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
            ?>
            </div>
                <?php
            }
        }

        add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_infobox_callback');
    }