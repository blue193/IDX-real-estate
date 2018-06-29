<?php
/*
 *
 * @Shortcode Name : List
 * @retrun
 *
 * 
 */
if (!function_exists('wp_rem_cs_var_page_builder_list')) {

    function wp_rem_cs_var_page_builder_list($die = 0) {
        global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $list_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_list|wp_rem_cs_list_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_list_title' => '',
            'wp_rem_cs_var_list_sub_title' => '',
            'wp_rem_cs_var_list_type' => '',
            'wp_rem_var_list_align' => '',
            'wp_rem_cs_var_list_item_icon_color' => '',
            'wp_rem_cs_var_list_item_icon_bg_color' => ''
        );
        $wp_rem_cs_var_list_item_icon_color = isset($wp_rem_cs_var_list_item_icon_color) ? $wp_rem_cs_var_list_item_icon_color : '';
        $wp_rem_cs_var_list_item_icon_bg_color = isset($wp_rem_cs_var_list_item_icon_bg_color) ? $wp_rem_cs_var_list_item_icon_bg_color : '';
        $wp_rem_cs_var_list_title = isset($wp_rem_cs_var_list_title) ? $wp_rem_cs_var_list_title : '';
        $wp_rem_cs_var_list_type = isset($wp_rem_cs_var_list_type) ? $wp_rem_cs_var_list_type : '';
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
            $list_num = count($atts_content);
        }
        $list_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_list';
        $coloumn_class = 'column_' . $list_element_size;
        $wp_rem_cs_var_list_main_title = isset($wp_rem_cs_var_list_main_title) ? $wp_rem_cs_var_list_main_title : '';
        $wp_rem_cs_var_list_sub_title = isset($wp_rem_cs_var_list_sub_title) ? $wp_rem_cs_var_list_sub_title : '';
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
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="list" data="<?php echo wp_rem_cs_element_size_data_array_index($list_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $list_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_edit_option')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/wp_rem_cs_list]" data-shortcode-child-template="[wp_rem_cs_list_item {{attributes}}] {{content}} [/wp_rem_cs_list_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[wp_rem_cs_list {{attributes}}]">
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
                                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_list_title),
                                        'id' => 'list_title' . $wp_rem_cs_counter,
                                        'cust_name' => 'wp_rem_cs_var_list_title[]',
                                        'classes' => '',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_sub_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_sub_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_list_sub_title),
                                        'id' => 'sub_list_title' . $wp_rem_cs_counter,
                                        'cust_name' => 'wp_rem_cs_var_list_sub_title[]',
                                        'classes' => '',
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
                                        'std' => $wp_rem_var_list_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_list_align',
                                        'cust_name' => 'wp_rem_var_list_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_style'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_style_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_list_type,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_cs_var_list_type',
                                        'cust_name' => 'wp_rem_cs_var_list_type[]',
                                        'classes' => 'dropdown chosen-select-no-single select-medium',
                                        'options' => array(
                                            'default' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_style_default'),
                                            'numeric-icon' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_style_numeric'),
                                            'built' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_bullet'),
                                            'icon' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_icon'),
                                            'alphabetic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_alphabetic'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                ?>
                                <style type="text/css">
                                    .icon_fields{ display: <?php echo esc_html($wp_rem_cs_var_list_type == 'icon' ? 'block' : 'none' ) ?>; }
                                </style>
                                <div class="icon_fields">   
                                    <?php
                                    $wp_rem_cs_opt_array = array(
                                        'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_icon_color'),
                                        'desc' => '',
                                        'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_icon_color_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => $wp_rem_cs_var_list_item_icon_color,
                                            'id' => 'wp_rem_cs_var_list_item_icon_color' . $wp_rem_cs_counter,
                                            'cust_name' => 'wp_rem_cs_var_list_item_icon_color[]',
                                            'classes' => 'bg_color',
                                            'return' => true,
                                        ),
                                    );
                                    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                    $wp_rem_cs_opt_array = array(
                                        'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_icon_bg_color'),
                                        'desc' => '',
                                        'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_icon_bg_color_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_list_item_icon_bg_color),
                                            'id' => 'wp_rem_cs_var_list_item_icon_bg_color' . $wp_rem_cs_counter,
                                            'cust_name' => 'wp_rem_cs_var_list_item_icon_bg_color[]',
                                            'classes' => 'bg_color',
                                            'return' => true,
                                        ),
                                    );
                                    $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                    ?>
                                </div>
                                <style type="text/css">
                                    .icon_fields{ display: <?php echo esc_html($wp_rem_cs_var_list_type == 'icon' ? 'block' : 'none' ) ?>; }
                                </style>
                                <script>
                                    $(function () {
                                        $('#wp_rem_cs_var_list_type').change(function () {
                                            var getValue = $("#wp_rem_cs_var_list_type option:selected").val();
                                            if (getValue == 'icon') {
                                                $('.icon_fields').css('display', 'block');
                                            } else {
                                                $('.icon_fields').css('display', 'none');
                                            }
                                        });
                                    });

                                </script>
                            </div>
                            <?php
                            if (isset($list_num) && $list_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $list) {
                                    $rand_id = rand(3333, 99999);
                                    $wp_rem_cs_var_list_text = $list['content'];
                                    $defaults = array('wp_rem_cs_var_list_item_text' => '', 'wp_rem_cs_var_list_item_icon' => '', 'wp_rem_cs_var_list_item_icon_group' => '');
                                    foreach ($defaults as $key => $values) {
                                        if (isset($list['atts'][$key]))
                                            $$key = $list['atts'][$key];
                                        else
                                            $$key = $values;
                                    }
                                    $wp_rem_cs_var_list_item_text = isset($wp_rem_cs_var_list_item_text) ? $wp_rem_cs_var_list_item_text : '';
                                    $wp_rem_cs_var_list_item_icon = isset($wp_rem_cs_var_list_item_icon) ? $wp_rem_cs_var_list_item_icon : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a></header>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_item'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_item_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_var_list_item_text),
                                                'id' => 'list_item_text' . $wp_rem_cs_counter,
                                                'cust_name' => 'wp_rem_cs_var_list_item_text[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        ?>	 				
                                        <div class="icon_fields">
                                            <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_icon')); ?></label>
                                                    <?php
                                                    if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                                                        echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_icon_hint'));
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <?php echo apply_filters( 'cs_icons_fields', esc_html($wp_rem_cs_var_list_item_icon), esc_attr($rand_id), 'wp_rem_cs_var_list_item_icon', $wp_rem_cs_var_list_item_icon_group ); ?>
                                                </div>
                                            </div>
                                            <?php
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="hidden-object">
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => $list_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'list_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('list', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_list_sc_add_item')); ?></a> </li>
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
                                        'std' => 'list',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_list', 'wp_rem_cs_var_page_builder_list');
}
if (!function_exists('wp_rem_cs_save_page_builder_data_list_callback')) {

    /**
     * Save data for list shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_list_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "list" || $widget_type == "cs_list") {
            $shortcode = $shortcode_item = '';

            $page_element_size = $data['list_element_size'][$counters['wp_rem_cs_global_counter_list']];
            $current_element_size = $data['list_element_size'][$counters['wp_rem_cs_global_counter_list']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($data['shortcode']['list'][$counters['wp_rem_cs_shortcode_counter_list']]);

                $element_settings = 'list_element_size="' . $current_element_size . '"';
                $reg = '/list_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_list'] ++;
            } else {
                if (isset($data['list_num'][$counters['wp_rem_cs_counter_list']]) && $data['list_num'][$counters['wp_rem_cs_counter_list']] > 0) {
                    for ($i = 1; $i <= $data['list_num'][$counters['wp_rem_cs_counter_list']]; $i ++) {
                        $shortcode_item .= '[wp_rem_cs_list_item ';
                        if (isset($data['wp_rem_cs_var_list_item_text'][$counters['wp_rem_cs_counter_list_node']]) && $data['wp_rem_cs_var_list_item_text'][$counters['wp_rem_cs_counter_list_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_list_item_text="' . htmlspecialchars($data['wp_rem_cs_var_list_item_text'][$counters['wp_rem_cs_counter_list_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_list_item_icon'][$counters['wp_rem_cs_counter_list_node']]) && $data['wp_rem_cs_var_list_item_icon'][$counters['wp_rem_cs_counter_list_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_list_item_icon="' . htmlspecialchars($data['wp_rem_cs_var_list_item_icon'][$counters['wp_rem_cs_counter_list_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_list_item_icon_group'][$counters['wp_rem_cs_counter_list_node']]) && $data['wp_rem_cs_var_list_item_icon_group'][$counters['wp_rem_cs_counter_list_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_list_item_icon_group="' . htmlspecialchars($data['wp_rem_cs_var_list_item_icon_group'][$counters['wp_rem_cs_counter_list_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        $shortcode_item .= '[/wp_rem_cs_list_item]';
                        $counters['wp_rem_cs_counter_list_node'] ++;
                    }
                }
                $section_title = '';
                if (isset($data['wp_rem_cs_var_list_title'][$counters['wp_rem_cs_counter_list']]) && $data['wp_rem_cs_var_list_title'][$counters['wp_rem_cs_counter_list']] != '') {
                    $section_title .= 'wp_rem_cs_var_list_title="' . htmlspecialchars($data['wp_rem_cs_var_list_title'][$counters['wp_rem_cs_counter_list']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_list_align'][$counters['wp_rem_cs_counter_list']]) && $data['wp_rem_var_list_align'][$counters['wp_rem_cs_counter_list']] != '') {
                    $section_title .= 'wp_rem_var_list_align="' . htmlspecialchars($data['wp_rem_var_list_align'][$counters['wp_rem_cs_counter_list']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_list_sub_title'][$counters['wp_rem_cs_counter_list']]) && $data['wp_rem_cs_var_list_sub_title'][$counters['wp_rem_cs_counter_list']] != '') {
                    $section_title .= 'wp_rem_cs_var_list_sub_title="' . htmlspecialchars($data['wp_rem_cs_var_list_sub_title'][$counters['wp_rem_cs_counter_list']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_list_type'][$counters['wp_rem_cs_counter_list']]) && $data['wp_rem_cs_var_list_type'][$counters['wp_rem_cs_counter_list']] != '') {
                    $section_title .= 'wp_rem_cs_var_list_type="' . htmlspecialchars($data['wp_rem_cs_var_list_type'][$counters['wp_rem_cs_counter_list']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_list_item_icon_color'][$counters['wp_rem_cs_counter_list']]) && $data['wp_rem_cs_var_list_item_icon_color'][$counters['wp_rem_cs_counter_list']] != '') {
                    $section_title .= 'wp_rem_cs_var_list_item_icon_color="' . htmlspecialchars($data['wp_rem_cs_var_list_item_icon_color'][$counters['wp_rem_cs_counter_list']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_list_item_icon_bg_color'][$counters['wp_rem_cs_counter_list']]) && $data['wp_rem_cs_var_list_item_icon_bg_color'][$counters['wp_rem_cs_counter_list']] != '') {
                    $section_title .= 'wp_rem_cs_var_list_item_icon_bg_color="' . htmlspecialchars($data['wp_rem_cs_var_list_item_icon_bg_color'][$counters['wp_rem_cs_counter_list']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'list_element_size="' . htmlspecialchars($data['list_element_size'][$counters['wp_rem_cs_global_counter_list']]) . '"';
                $shortcode = '[wp_rem_cs_list ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/wp_rem_cs_list]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_list'] ++;
            }
            $counters['wp_rem_cs_global_counter_list'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_list', 'wp_rem_cs_save_page_builder_data_list_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_list_callback')) {

    /**
     * Populate list shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_list_callback($counters) {
        $counters['wp_rem_cs_global_counter_list'] = 0;
        $counters['wp_rem_cs_shortcode_counter_list'] = 0;
        $counters['wp_rem_cs_counter_list_node'] = 0;
        $counters['wp_rem_cs_counter_list'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_list_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_list_callback')) {

    /**
     * Populate list shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_list_callback($shortcode_array) {
        $shortcode_array['list'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_list'),
            'name' => 'list',
            'icon' => 'icon-newspaper',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_list_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_list_callback')) {

    /**
     * Populate list shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_list_callback($element_list) {
        $element_list['list'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_list');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_list_callback');
}

if (!function_exists('wp_rem_cs_shortcode_sub_element_ui_list_callback')) {

    /**
     * Render UI for sub element in list settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_list_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];
        if ($type == 'list') {
            $rand_id = rand(23, 45453);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="wp_rem_cs_list_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_list'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_list_Item'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_list_Item_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'list_item_text',
                        'cust_name' => 'wp_rem_cs_var_list_item_text[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                ?>	 				
                <div class="icon_fields">
                    <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon'); ?></label>
                            <?php
                            if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                                echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_icon_tooltip'));
                            }
                            ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <?php echo apply_filters( 'cs_icons_fields', '', $rand_id, 'wp_rem_cs_var_list_item_icon'); ?>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                popup_over();
                jQuery(document).ready(function ($) {
                    var getValue = $("#wp_rem_cs_var_list_type option:selected").val();
                    $('.icon_fields').css('display', 'none');
                    if (getValue == 'icon') {
                        $('.icon_fields').css('display', 'block');
                    } else {
                        $('.icon_fields').css('display', 'none');
                    }
                });
            </script> 

            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_list_callback');
}