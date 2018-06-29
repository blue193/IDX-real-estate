<?php
/* *
 * @Shortcode Name : Heading
 * @retrun
 * */
if ( ! function_exists('wp_rem_cs_var_page_builder_heading') ) {

    function wp_rem_cs_var_page_builder_heading($die = 0) {
        global $wp_rem_cs_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $counter = $_POST['counter'];
        $wp_rem_cs_counter = $_POST['counter'];
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_heading';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_heading_title' => '',
            'wp_rem_cs_heading_subtitle' => '',
            'wp_rem_var_heading_align' => '',
            'wp_rem_cs_heading_color' => '#000',
            'class' => 'cs-heading-shortcode',
            'wp_rem_cs_heading_style' => '1',
            'wp_rem_cs_heading_size' => '',
            'wp_rem_cs_letter_space' => '',
            'wp_rem_cs_line_height' => '',
            'wp_rem_cs_font_weight' => '',
            'wp_rem_cs_heading_font_style' => '',
            'wp_rem_cs_heading_view' => 'view-1',
            'wp_rem_cs_heading_align' => 'center',
            'wp_rem_cs_heading_divider' => '',
            'wp_rem_cs_var_heading_align' => '',
        );
        if ( isset($output['0']['atts']) ) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if ( isset($output['0']['content']) ) {
            $heading_content = $output['0']['content'];
        } else {
            $heading_content = '';
        }
        $heading_element_size = '25';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) )
                $$key = $atts[$key];
            else
                $$key = $values;
        }
        $name = 'wp_rem_cs_var_page_builder_heading';
        $coloumn_class = 'column_' . $heading_element_size;
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $wp_rem_cs_heading_title = isset($wp_rem_cs_heading_title) ? $wp_rem_cs_heading_title : '';
        $wp_rem_cs_heading_color = isset($wp_rem_cs_heading_color) ? $wp_rem_cs_heading_color : '';
        $wp_rem_cs_heading_style = isset($wp_rem_cs_heading_style) ? $wp_rem_cs_heading_style : '';
        $wp_rem_cs_heading_size = isset($wp_rem_cs_heading_size) ? $wp_rem_cs_heading_size : '';
        $wp_rem_cs_letter_space = isset($wp_rem_cs_letter_space) ? $wp_rem_cs_letter_space : '';
        $wp_rem_cs_line_height = isset($wp_rem_cs_line_height) ? $wp_rem_cs_line_height : '';
        $wp_rem_cs_heading_font_style = isset($wp_rem_cs_heading_font_style) ? $wp_rem_cs_heading_font_style : '';
        $wp_rem_cs_heading_view = isset($wp_rem_cs_heading_view) ? $wp_rem_cs_heading_view : '';
        $wp_rem_cs_heading_align = isset($wp_rem_cs_heading_align) ? $wp_rem_cs_heading_align : '';
        $wp_rem_cs_heading_divider = isset($wp_rem_cs_heading_divider) ? $wp_rem_cs_heading_divider : '';
        $wp_rem_cs_var_heading_align = isset($wp_rem_cs_var_heading_align) ? $wp_rem_cs_var_heading_align : '';
        ?>
        <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column parentdelete <?php echo esc_attr($coloumn_class); ?> <?php echo esc_attr($shortcode_view); ?>" item="heading" data="<?php echo wp_rem_cs_element_size_data_array_index($heading_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $heading_element_size, '', 'h-square', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?> <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>"  data-shortcode-template="[wp_rem_cs_heading {{attributes}}]{{content}}[/wp_rem_cs_heading]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_edit_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')"
                       class="cs-btnclose"><i class="icon-cross"></i>
                    </a>
                </div>
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp">
                        <?php
                        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                            wp_rem_cs_shortcode_element_size();
                        }
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_title'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_title_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_heading_title),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'wp_rem_cs_heading_title[]',
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
                                'std' => esc_attr($wp_rem_cs_heading_subtitle),
                                'classes' => '',
                                'cust_name' => 'wp_rem_cs_heading_subtitle[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_content'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_content_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_textarea($heading_content),
                                'cust_id' => '',
                                'classes' => 'txtfield',
                                'cust_name' => 'heading_content[]',
                                'return' => true,
                                'wp_rem_cs_editor' => true,
                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_type'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_type_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_heading_style,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_heading_style[]',
                                'classes' => 'chosen-select select-medium',
                                'options' => array(
                                    '1' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_h1'),
                                    '2' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_h2'),
                                    '3' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_h3'),
                                    '4' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_h4'),
                                    '5' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_h5'),
                                    '6' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_h6'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        ?>
                        <div class="form-elements">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_font_size')); ?></label>
                                <?php
                                if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                                    echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_font_size_hint'));
                                }
                                ?>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'std' => esc_attr($wp_rem_cs_heading_size),
                                    'id' => '',
                                    'classes' => 'cs-range-input input-small',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'wp_rem_cs_heading_size[]',
                                    'extra_atr' => ' placeholder="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_font_size') . '"',
                                    'return' => true,
                                    'required' => false,
                                    'rang' => true,
                                    'min' => 0,
                                    'max' => 50,
                                );
                                echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array));
                                ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_letter_spacing')); ?></label>
                                <?php
                                if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                                    echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_letter_spacing_hint'));
                                }
                                ?>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'std' => esc_attr($wp_rem_cs_letter_space),
                                    'id' => '',
                                    'classes' => 'cs-range-input input-small',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'wp_rem_cs_letter_space[]',
                                    'extra_atr' => ' placeholder="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_letter_spacing') . '"',
                                    'return' => true,
                                    'required' => false,
                                    'rang' => true,
                                    'min' => 0,
                                    'max' => 50,
                                );
                                echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array));
                                ?>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_line_height')); ?></label>
                                <?php
                                if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                                    echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_line_height_hint'));
                                }
                                ?>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'std' => esc_attr($wp_rem_cs_line_height),
                                    'id' => '',
                                    'classes' => 'cs-range-input input-small',
                                    'extra_atr' => '',
                                    'cust_id' => '',
                                    'cust_name' => 'wp_rem_cs_line_height[]',
                                    'extra_atr' => ' placeholder="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_line_height') . '"',
                                    'return' => true,
                                    'required' => false,
                                    'rang' => true,
                                    'min' => 0,
                                    'max' => 50,
                                );
                                echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array));
                                ?>
                            </div>
                        </div>
                        <?php
                        $font_weight_options = array(
                        '' =>  wp_rem_cs_var_theme_text_srt('wp_rem_cs_heading_element_font_weight_select'),
                        '100' => '100',
                        '200' => '200',
                        '300' => '300',
                        '400' => '400',
                        '500' => '500',
                        '600' => '600',
                        '700' => '700',
                        '800' => '800',
                        '800' => '800',
                        'bold' => 'Bold',
                        'bolder' => 'Bolder',
                        'inherit' => 'Inherit',
                        'lighter' => 'Lighter',
                        'normal' => 'Normal',
                        );
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_heading_element_font_weight'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_heading_element_font_weight_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_html($wp_rem_cs_font_weight),
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_font_weight[]',
                                'classes' => 'chosen-select select-medium',
                                'options' => $font_weight_options,
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_heading_align'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_heading_align_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_heading_align,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_heading_align[]',
                                'classes' => 'chosen-select select-medium',
                                'options' => array(
                                    'align-left' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_left'),
                                    'align-right' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_right'),
                                    'align-center' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_center'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_color'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_color_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_heading_color),
                                'cust_id' => '',
                                'classes' => 'bg_color',
                                'cust_name' => 'wp_rem_cs_heading_color[]',
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_divider'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_divider_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_heading_divider,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_heading_divider[]',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'options' => array(
                                    'on' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_on'),
                                    'off' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_off'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_font_style'),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_font_style_hint'),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_heading_font_style,
                                'id' => '',
                                'cust_id' => '',
                                'cust_name' => 'wp_rem_cs_heading_font_style[]',
                                'classes' => 'dropdown chosen-select-no-single select-medium',
                                'options' => array(
                                    'normal' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_normal'),
                                    'italic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_italic'),
                                    'oblique' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading_sc_oblique'),
                                ),
                                'return' => true,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                        ?>

                    </div>
                    <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                        <ul class="form-elements insert-bg">
                            <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                        </ul>
                        <div id="results-shortocde"></div>
                        <?php
                    } else {
                        $wp_rem_cs_opt_array = array(
                            'std' => 'heading',
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
        <?php
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_heading', 'wp_rem_cs_var_page_builder_heading');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_heading_callback') ) {

    /**
     * Save data for heading shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_heading_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ( $widget_type == "heading" || $widget_type == "cs_heading" ) {

            $wp_rem_cs_var_heading = '';
            $page_element_size = $data['heading_element_size'][$counters['wp_rem_cs_global_counter_heading']];
            $current_element_size = $data['heading_element_size'][$counters['wp_rem_cs_global_counter_heading']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes(( $data['shortcode']['heading'][$counters['wp_rem_cs_shortcode_counter_heading']]));
                $element_settings = 'heading_element_size="' . $current_element_size . '"';
                $reg = '/heading_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_heading'] ++;
            } else {
                $wp_rem_cs_var_heading = '[wp_rem_cs_heading heading_element_size="' . htmlspecialchars($data['heading_element_size'][$counters['wp_rem_cs_global_counter_heading']]) . '" ';
                if ( isset($data['wp_rem_cs_heading_title'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_title'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_title="' . htmlspecialchars($data['wp_rem_cs_heading_title'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_subtitle'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_subtitle'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_subtitle="' . htmlspecialchars($data['wp_rem_cs_heading_subtitle'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_heading_align'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_var_heading_align'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_var_heading_align="' . htmlspecialchars($data['wp_rem_var_heading_align'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_style'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_style'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_style="' . htmlspecialchars($data['wp_rem_cs_heading_style'][$counters['wp_rem_cs_counter_heading']]) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_heading_align'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_var_heading_align'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_var_heading_align="' . htmlspecialchars($data['wp_rem_cs_var_heading_align'][$counters['wp_rem_cs_counter_heading']]) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_size'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_size'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_size="' . htmlspecialchars($data['wp_rem_cs_heading_size'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_letter_space'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_letter_space'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_letter_space="' . htmlspecialchars($data['wp_rem_cs_letter_space'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_line_height'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_line_height'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_line_height="' . htmlspecialchars($data['wp_rem_cs_line_height'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_font_weight'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_font_weight'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_font_weight="' . htmlspecialchars($data['wp_rem_cs_font_weight'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_align'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_align'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_align="' . htmlspecialchars($data['wp_rem_cs_heading_align'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_view'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_view'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_view="' . htmlspecialchars($data['wp_rem_cs_heading_view'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_font_style'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_font_style'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_font_style="' . htmlspecialchars($data['wp_rem_cs_heading_font_style'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_divider'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_divider'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_divider="' . htmlspecialchars($data['wp_rem_cs_heading_divider'][$counters['wp_rem_cs_counter_heading']]) . '" ';
                }
                if ( isset($data['wp_rem_cs_heading_color'][$counters['wp_rem_cs_counter_heading']]) && $data['wp_rem_cs_heading_color'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= 'wp_rem_cs_heading_color="' . htmlspecialchars($data['wp_rem_cs_heading_color'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_var_heading .= ']';
                if ( isset($data['heading_content'][$counters['wp_rem_cs_counter_heading']]) && $data['heading_content'][$counters['wp_rem_cs_counter_heading']] != '' ) {
                    $wp_rem_cs_var_heading .= htmlspecialchars($data['heading_content'][$counters['wp_rem_cs_counter_heading']], ENT_QUOTES);
                }
                $wp_rem_cs_var_heading .= '[/wp_rem_cs_heading]';
                $shortcode_data .= $wp_rem_cs_var_heading;
                $counters['wp_rem_cs_counter_heading'] ++;
            }
            $counters['wp_rem_cs_global_counter_heading'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_heading', 'wp_rem_cs_save_page_builder_data_heading_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_heading_callback') ) {

    /**
     * Populate heading shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_heading_callback($counters) {
        $counters['wp_rem_cs_global_counter_heading'] = 0;
        $counters['wp_rem_cs_shortcode_counter_heading'] = 0;
        $counters['wp_rem_cs_counter_heading'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_heading_callback');
}
if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_heading_callback') ) {

    /**
     * Populate heading shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_heading_callback($shortcode_array) {
        $shortcode_array['heading'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_heading'),
            'name' => 'heading',
            'icon' => 'icon-header',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_heading_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_heading_callback') ) {

    /**
     * Populate heading shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_heading_callback($element_list) {
        $element_list['heading'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_heading');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_heading_callback');
}