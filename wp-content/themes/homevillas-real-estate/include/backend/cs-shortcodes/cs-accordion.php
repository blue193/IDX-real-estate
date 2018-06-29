<?php
/**
 * Shortcode Name : Accordion
 *
 * @package	wp_rem_cs 
 */
if (!function_exists('wp_rem_cs_var_page_builder_accordion')) {

    function wp_rem_cs_var_page_builder_accordion($die = 0) {
        global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $PREFIX = 'wp_rem_cs_accordion|accordion_item';
        $parseObject = new ShortcodeParse();
        $accordion_num = 0;
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
            'wp_rem_cs_var_accordion_view' => '',
            'wp_rem_cs_var_accordion_icon' => '',
            'wp_rem_cs_var_accordian_main_title' => '',
            'wp_rem_cs_var_accordian_main_subtitle' => '',
            'wp_rem_var_accordion_align' => '',
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
            $accordion_num = count($atts_content);
        }
        $accordion_element_size = '50';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_accordion';
        $coloumn_class = 'column_' . $accordion_element_size;
        $wp_rem_cs_var_accordion_view = isset($wp_rem_cs_var_accordion_view) ? $wp_rem_cs_var_accordion_view : '';
        $wp_rem_cs_var_accordian_main_title = isset($wp_rem_cs_var_accordian_main_title) ? $wp_rem_cs_var_accordian_main_title : '';
        $wp_rem_cs_var_accordion_icon = isset($wp_rem_cs_var_accordion_icon) ? $wp_rem_cs_var_accordion_icon : '';
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="accordion" data="<?php echo wp_rem_cs_element_size_data_array_index($accordion_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $accordion_element_size, '', 'list-ul'); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[<?php echo esc_attr(WP_REM_SC_ACCORDION); ?> {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordion_edit_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}}[/<?php echo esc_attr('wp_rem_cs_accordion'); ?>]" data-shortcode-child-template="[<?php echo esc_attr('accordion_item'); ?> {{attributes}}] {{content}} [/<?php echo esc_attr('accordion_item'); ?>]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr('wp_rem_cs_accordion'); ?> {{attributes}}]">
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_accordian_main_title),
                                        'id' => 'wp_rem_cs_var_accordian_main_title',
                                        'cust_name' => 'wp_rem_cs_var_accordian_main_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_var_accordian_main_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_accordian_main_subtitle[]',
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
                                        'std' => $wp_rem_var_accordion_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_accordion_align',
                                        'cust_name' => 'wp_rem_var_accordion_align[]',
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

                                if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                    wp_rem_cs_shortcode_element_size();
                                }
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordion_views'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordion_view_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_accordion_view,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_cs_var_accordion_view',
                                        'cust_name' => 'wp_rem_cs_var_accordion_view[]',
                                        'classes' => 'service_postion chosen-select-no-single select-medium',
                                        'options' => array(
                                            'simple' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordion_simple'),
                                            'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordion_modern'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                ?>
                            </div>
                            <?php
                            if (isset($accordion_num) && $accordion_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $accordion) {
                                    $rand_id = rand(3333, 99999);
                                    $wp_rem_cs_var_accordion_text = $accordion['content'];
                                    $defaults = array('wp_rem_cs_var_accordion_title' => 'Title', 'wp_rem_cs_var_accordion_active' => 'yes', 'wp_rem_cs_var_icon_box' => '', 'wp_rem_cs_var_icon_box_group' => '');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($accordion['atts'][$key]))
                                            $$key = $accordion['atts'][$key];
                                        else
                                            $$key = $values;
                                    }
                                    $wp_rem_cs_var_accordion_active = isset($wp_rem_cs_var_accordion_active) ? $wp_rem_cs_var_accordion_active : '';
                                    $wp_rem_cs_var_accordion_title = isset($wp_rem_cs_var_accordion_title) ? $wp_rem_cs_var_accordion_title : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordion')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a></header>
                                        <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon')); ?></label>
                                                <?php
                                                if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                                                    echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_icon_hint'));
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                <?php echo apply_filters( 'cs_icons_fields', $wp_rem_cs_var_icon_box, esc_attr($rand_id), 'wp_rem_cs_var_icon_box', $wp_rem_cs_var_icon_box_group ); ?>
                                                <?php //echo wp_rem_cs_var_icomoon_icons_box($wp_rem_cs_var_icon_box, esc_attr($rand_id), 'wp_rem_cs_var_icon_box'); ?>
                                            </div>
                                        </div>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_active'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_active_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_var_accordion_active,
                                                'id' => '',
                                                'cust_name' => 'wp_rem_cs_var_accordion_active[]',
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
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_title'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_accordion_title),
                                                'id' => 'accordion_title',
                                                'cust_name' => 'wp_rem_cs_var_accordion_title[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_descr'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_descr_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_accordion_text),
                                                'id' => 'wp_rem_cs_var_accordion_text',
                                                'cust_name' => 'wp_rem_cs_var_accordion_text[]',
                                                'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                                'classes' => '',
                                                'return' => true,
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
                        </div>
                        <div class="hidden-object">
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => $accordion_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'accordion_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('accordion', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_add_accordian')); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rem_cs_var_page_builder_', '', $name)); ?>', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                    <?php
                                } else {
                                    $wp_rem_cs_opt_array = array(
                                        'std' => 'accordion',
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
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_accordion', 'wp_rem_cs_var_page_builder_accordion');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_accordion_callback')) {

    /**
     * Save data for accordion shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_accordion_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ($widget_type == "accordion" || $widget_type == "cs_accordion") {
            $shortcode = $shortcode_item = '';

            $page_element_size = $data['accordion_element_size'][$counters['wp_rem_cs_global_counter_accordion']];
            $current_element_size = $data['accordion_element_size'][$counters['wp_rem_cs_global_counter_accordion']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($data['shortcode']['accordion'][$counters['wp_rem_cs_shortcode_counter_accordion']]);

                $element_settings = 'accordion_element_size="' . $current_element_size . '"';
                $reg = '/accordion_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_accordion'] ++;
            } else {
                if (isset($data['accordion_num'][$counters['wp_rem_cs_counter_accordion']]) && $data['accordion_num'][$counters['wp_rem_cs_counter_accordion']] > 0) {
                    for ($i = 1; $i <= $data['accordion_num'][$counters['wp_rem_cs_counter_accordion']]; $i ++) {
                        $shortcode_item .= '[accordion_item ';
                        if (isset($data['wp_rem_cs_var_accordion_active'][$counters['wp_rem_cs_counter_accordion_node']]) && $data['wp_rem_cs_var_accordion_active'][$counters['wp_rem_cs_counter_accordion_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_accordion_active="' . htmlspecialchars($data['wp_rem_cs_var_accordion_active'][$counters['wp_rem_cs_counter_accordion_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_accordion_title'][$counters['wp_rem_cs_counter_accordion_node']]) && $data['wp_rem_cs_var_accordion_title'][$counters['wp_rem_cs_counter_accordion_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_accordion_title="' . htmlspecialchars($data['wp_rem_cs_var_accordion_title'][$counters['wp_rem_cs_counter_accordion_node']], ENT_QUOTES) . '" ';
                        }
                        
                        if (isset($data['wp_rem_cs_var_icon_box'][$counters['wp_rem_cs_counter_accordion_node']]) && $data['wp_rem_cs_var_icon_box'][$counters['wp_rem_cs_counter_accordion_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_icon_box="' . htmlspecialchars($data['wp_rem_cs_var_icon_box'][$counters['wp_rem_cs_counter_accordion_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_icon_box_group'][$counters['wp_rem_cs_counter_accordion_node']]) && $data['wp_rem_cs_var_icon_box_group'][$counters['wp_rem_cs_counter_accordion_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_icon_box_group="' . htmlspecialchars($data['wp_rem_cs_var_icon_box_group'][$counters['wp_rem_cs_counter_accordion_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if (isset($data['wp_rem_cs_var_accordion_text'][$counters['wp_rem_cs_counter_accordion_node']]) && $data['wp_rem_cs_var_accordion_text'][$counters['wp_rem_cs_counter_accordion_node']] != '') {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_accordion_text'][$counters['wp_rem_cs_counter_accordion_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/accordion_item]';
                        $counters['wp_rem_cs_counter_accordion_node'] ++;
                    }
                }
                $section_title = '';
                if (isset($data['wp_rem_cs_var_accordion_view'][$counters['wp_rem_cs_counter_accordion']]) && $data['wp_rem_cs_var_accordion_view'][$counters['wp_rem_cs_counter_accordion']] != '') {
                    $section_title .= 'wp_rem_cs_var_accordion_view="' . htmlspecialchars($data['wp_rem_cs_var_accordion_view'][$counters['wp_rem_cs_counter_accordion']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_accordian_main_title'][$counters['wp_rem_cs_counter_accordion']]) && $data['wp_rem_cs_var_accordian_main_title'][$counters['wp_rem_cs_counter_accordion']] != '') {
                    $section_title .= 'wp_rem_cs_var_accordian_main_title="' . htmlspecialchars($data['wp_rem_cs_var_accordian_main_title'][$counters['wp_rem_cs_counter_accordion']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_accordion_align'][$counters['wp_rem_cs_counter_accordion']]) && $data['wp_rem_var_accordion_align'][$counters['wp_rem_cs_counter_accordion']] != '') {
                    $section_title .= 'wp_rem_var_accordion_align="' . htmlspecialchars($data['wp_rem_var_accordion_align'][$counters['wp_rem_cs_counter_accordion']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_accordian_main_subtitle'][$counters['wp_rem_cs_counter_accordion']]) && $data['wp_rem_cs_var_accordian_main_subtitle'][$counters['wp_rem_cs_counter_accordion']] != '') {
                    $section_title .= 'wp_rem_cs_var_accordian_main_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_accordian_main_subtitle'][$counters['wp_rem_cs_counter_accordion']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'accordion_element_size="' . htmlspecialchars($data['accordion_element_size'][$counters['wp_rem_cs_global_counter_accordion']]) . '"';
                $shortcode = '[wp_rem_cs_accordion ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/wp_rem_cs_accordion]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_accordion'] ++;
            }
            $counters['wp_rem_cs_global_counter_accordion'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_accordion', 'wp_rem_cs_save_page_builder_data_accordion_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_accordion_callback')) {

    /**
     * Populate accordion shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_accordion_callback($counters) {
        $counters['wp_rem_cs_counter_accordion'] = 0;
        $counters['wp_rem_cs_counter_accordion_node'] = 0;
        $counters['wp_rem_cs_shortcode_counter_accordion'] = 0;
        $counters['wp_rem_cs_global_counter_accordion'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_accordion_callback');
}

if (!function_exists('wp_rem_cs_shortcode_sub_element_ui_accordion_callback')) {

    /**
     * Render UI for sub element in accordion settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_accordion_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];
        if ($type == 'accordion') {
            $wp_rem_cs_var_active = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_active');
            $wp_rem_cs_var_active_hint = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_active_hint');
            $wp_rem_cs_var_accordion_title = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion_title');
            $wp_rem_cs_var_accordion_title_hint = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion_title_hint');
            $wp_rem_cs_var_accordion_text = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion_text');
            $wp_rem_cs_var_accordion_text_hint = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion_text_hint');
            $rand_id = rand(324235, 993249);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="wp_rem_cs_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>

                <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion_icon'); ?></label>
                        <?php
                        if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                            echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion_icon_hint'));
                        }
                        ?>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <?php echo apply_filters( 'cs_icons_fields', '', esc_attr($rand_id), 'wp_rem_cs_var_icon_box'); ?>
                    </div>
                </div>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => $wp_rem_cs_var_active,
                    'desc' => '',
                    'hint_text' => $wp_rem_cs_var_active_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => '',
                        'cust_name' => 'wp_rem_cs_var_accordion_active[]',
                        'classes' => 'dropdown chosen-select',
                        'options' => array(
                            'yes' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_yes'),
                            'no' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_no'),
                        ),
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => $wp_rem_cs_var_accordion_title,
                    'desc' => '',
                    'hint_text' => $wp_rem_cs_var_accordion_title_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'accordion_title',
                        'cust_name' => 'wp_rem_cs_var_accordion_title[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => $wp_rem_cs_var_accordion_text,
                    'desc' => '',
                    'hint_text' => $wp_rem_cs_var_accordion_text_hint,
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'wp_rem_cs_var_accordion_text',
                        'cust_name' => 'wp_rem_cs_var_accordion_text[]',
                        'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                        'return' => true,
                        'classes' => '',
                        'wp_rem_cs_editor' => true
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                ?>
            </div>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_accordion_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_accordion_callback')) {

    /**
     * Populate accordion shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_accordion_callback($element_list) {
        $element_list['accordion'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordion');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_accordion_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_accordion_callback')) {

    /**
     * Populate accordion shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_accordion_callback($shortcode_array) {
        $shortcode_array['accordion'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_accordian'),
            'name' => 'accordion',
            'icon' => 'icon-list-ul',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_accordion_callback');
}
