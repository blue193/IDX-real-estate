<?php
/*
 *
 * @Shortcode Name : Tabs
 * @retrun
 *
 * 
 */
if (!function_exists('wp_rsm_cs_var_page_builder_tabs_fancy')) {

    function wp_rsm_cs_var_page_builder_tabs_fancy($die = 0) {
        global $wp_rsm_cs_node, $count_node, $post, $wp_rsm_cs_var_html_fields, $wp_rsm_cs_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rsm_cs_counter = $_POST['counter'];
        $tabs_fancy_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rsm_cs_tabs_fancy|wp_rsm_cs_tabs_fancy_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rsm_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rsm_cs_var_tabs_fancy_title' => '',
            'wp_rsm_cs_var_tabs_fancy_subtitle' => '',
            'wp_rsm_cs_var_tabs_fancy_title_align' => '',
            'wp_rsm_cs_var_tabs_title' => '',
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
            $tabs_fancy_num = count($atts_content);
        }
        $tabs_fancy_element_size = '25';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $exploded_data = explode(",", $wp_rsm_cs_var_tabs_title);
        $name = 'wp_rsm_cs_var_page_builder_tabs_fancy';
        $coloumn_class = 'column_' . $tabs_fancy_element_size;
        $wp_rsm_cs_var_tabs_fancy_title = isset($wp_rsm_cs_var_tabs_fancy_title) ? $wp_rsm_cs_var_tabs_fancy_title : '';

        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        global $wp_rsm_cs_var_static_text;
        $strings = new wp_rsm_cs_theme_all_strings;
        $strings->wp_rsm_cs_short_code_strings();
        ?>
        <div id="<?php echo wp_rsm_cs_allow_special_char($name . $wp_rsm_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rsm_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rsm_cs_allow_special_char($shortcode_view); ?>" item="tabs_fancy" data="<?php echo wp_rsm_cs_element_size_data_array_index($tabs_fancy_element_size) ?>" >
            <?php wp_rsm_cs_element_setting($name, $wp_rsm_cs_counter, $tabs_fancy_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rsm_cs_allow_special_char($wp_rsm_cs_counter) ?> <?php echo wp_rsm_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rsm_cs_allow_special_char($name . $wp_rsm_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_edit_options')); ?></h5>
                    <a href="javascript:wp_rsm_cs_frame_removeoverlay('<?php echo wp_rsm_cs_allow_special_char($name . $wp_rsm_cs_counter) ?>','<?php echo wp_rsm_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rsm_cs_allow_special_char($wp_rsm_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/wp_rsm_cs_tabs_fancy]" data-shortcode-child-template="[wp_rsm_cs_tabs_fancy_item {{attributes}}] {{content}} [/wp_rsm_cs_tabs_fancy_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[wp_rsm_cs_tabs_fancy {{attributes}}]">
                                <?php
                                if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                    wp_rsm_cs_shortcode_element_size();
                                }
                                $wp_rsm_cs_opt_array = array(
                                    'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => wp_rsm_cs_allow_special_char($wp_rsm_cs_var_tabs_fancy_title),
                                        'id' => 'tabs_fancy_title' . $wp_rsm_cs_counter,
                                        'cust_name' => 'wp_rsm_cs_var_tabs_fancy_title[]',
                                        'classes' => '',
                                        'return' => true,
                                    ),
                                );
                                $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);

                                $wp_rsm_cs_opt_array = array(
                                    'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_element_subtitle'),
                                    'desc' => '',
                                    'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_element_subtitle_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rsm_cs_var_tabs_fancy_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rsm_cs_var_tabs_fancy_subtitle[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);


                                $wp_rsm_opt_array = array(
                                    'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_title_alignment'),
                                    'desc' => '',
                                    'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_title_alignment_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rsm_cs_var_tabs_fancy_title_align,
                                        'id' => '',
                                        'cust_name' => 'wp_rsm_cs_var_tabs_fancy_title_align[]',
                                        'classes' => 'service_postion chosen-select-no-single select-medium',
                                        'options' => array(
                                            'align-left' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_align_left'),
                                            'align-right' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_align_right'),
                                            'align-center' => wp_rsm_cs_var_theme_text_srt('wp_rsm_var_align_center'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_select_field($wp_rsm_opt_array);



                                $counter = 0;
                                if ($wp_rsm_cs_var_tabs_title == '') {

                                    echo '<div class="repeat_div">';

                                    $wp_rsm_cs_opt_array = array(
                                        'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text'),
                                        'desc' => '',
                                        'required' => true,
                                        'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text_hint'),
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => wp_rsm_cs_allow_special_char($data_single),
                                            'id' => 'tabs_fancy_title' . $wp_rsm_cs_counter,
                                            'cust_name' => 'wp_rsm_cs_var_tabs_title[]',
                                            'classes' => '',
                                            'return' => true,
                                        ),
                                    );
                                    $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);

                                    echo '</div>';
                                }
                                foreach ($exploded_data as $data_single) {
                                    if ($data_single != '') {
                                        if ($counter == 0) {

                                            echo '<div class="repeat_div">';
                                        }
                                        $wp_rsm_cs_opt_array = array(
                                            'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text'),
                                            'desc' => '',
                                            'required' => true,
                                            'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rsm_cs_allow_special_char($data_single),
                                                'id' => 'tabs_fancy_title' . $wp_rsm_cs_counter,
                                                'cust_name' => 'wp_rsm_cs_var_tabs_title[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                                        echo '<a href="#" class="delete-it btn-delete-it"><i class="icon-minus-circle"></i></a>';
                                        if ($counter == 0) {
                                            echo '</div>';
                                        }
                                    }


                                    $counter++;
                                }


                                echo '<div class="appened-data"></div>';
                                ?>
                                <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rsm_cs_shortcode_add_duplicate()"><i class="icon-plus-circle"></i><?php echo wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_add_btn'); ?></a>
                                <script>

                                    function wp_rsm_cs_shortcode_add_duplicate() {
                                        jQuery(".repeat_div").first().clone().append('<a href="#" class="delete-it btn-delete-it"><i class="icon-minus-circle"></i></a>').appendTo(".appened-data");
                                    }
                                    jQuery(document).on("click", ".delete-it", function () {
                                        $(this).prev('.form-elements').remove();
                                        (this).remove();
                                    });
                                </script>
                            </div>
                            <?php
                            if (isset($tabs_fancy_num) && $tabs_fancy_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $tabs_fancy) {
                                    $wp_rsm_cs_var_tabs_fancy_text = $tabs_fancy['content'];
                                    $rand_id = rand(3333, 99999);
                                    $defaults = array(
                                        'wp_rsm_cs_var_tabs_fancy_item_text' => 'Title',
                                        'wp_rsm_cs_var_tabs_fancy_item_icon' => '',
                                        'wp_rsm_cs_var_tabs_fancy_active' => '',
                                        'wp_rsm_cs_var_tabs_image_array' => '',
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($tabs_fancy['atts'][$key]))
                                            $$key = $tabs_fancy['atts'][$key];
                                        else
                                            $$key = $values;
                                    }
                                    $wp_rsm_cs_var_tabs_image_array = isset($wp_rsm_cs_var_tabs_image_array) ? $wp_rsm_cs_var_tabs_image_array : '';

                                    $wp_rsm_cs_var_tabs_fancy_item_text = isset($wp_rsm_cs_var_tabs_fancy_item_text) ? $wp_rsm_cs_var_tabs_fancy_item_text : '';
                                    $wp_rsm_cs_var_tabs_fancy_desc = $wp_rsm_cs_var_tabs_fancy_text;
                                    $wp_rsm_cs_var_tabs_fancy_item_icon = isset($wp_rsm_cs_var_tabs_fancy_item_icon) ? $wp_rsm_cs_var_tabs_fancy_item_icon : '';
                                    $wp_rsm_cs_var_tabs_fancy_active = isset($wp_rsm_cs_var_tabs_fancy_active) ? $wp_rsm_cs_var_tabs_fancy_active : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="wp_rsm_cs_infobox_<?php echo wp_rsm_cs_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_tabs_fancy')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_remove')); ?></a></header>
                                        <?php
                                        $exploded_data = explode(",", $wp_rsm_cs_var_tabs_title);

                                        $options_array = array();
                                        foreach ($exploded_data as $data_single) {
                                            if ($data_single != '') {
                                                $options_array[$data_single] = $data_single;
                                            }
                                        }
                                        $wp_rsm_cs_opt_array = array(
                                            'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text'),
                                            'desc' => '',
                                            'required' => true,
                                            'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rsm_cs_allow_special_char($wp_rsm_cs_var_tabs_fancy_item_text),
                                                'id' => 'fancy_item_text',
                                                'cust_name' => 'wp_rsm_cs_var_tabs_fancy_item_text[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);

                                        $wp_rsm_cs_opt_array = array(
                                            'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_active'),
                                            'desc' => '',
                                            'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_active_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rsm_cs_var_tabs_fancy_active),
                                                'id' => 'tabs_fancy_active',
                                                'cust_name' => 'wp_rsm_cs_var_tabs_fancy_active[]',
                                                'options' => $options_array,
                                                'classes' => 'chosen-select-no-single select-medium',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_select_field($wp_rsm_cs_opt_array);
                                        ?>
                                        <?php
                                        $wp_rsm_cs_opt_array = array(
                                            'std' => esc_url($wp_rsm_cs_var_tabs_image_array),
                                            'id' => 'tabs_image',
                                            'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_testimonial_field_image'),
                                            'desc' => '',
                                            'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_testimonial_field_image_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'prefix' => '',
                                            'field_params' => array(
                                                'std' => esc_url($wp_rsm_cs_var_tabs_image_array),
                                                'id' => 'tabs_image',
                                                'return' => true,
                                                'array' => true,
                                                'array_txt' => false,
                                                'prefix' => '',
                                            ),
                                        );
                                        $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_upload_file_field($wp_rsm_cs_opt_array);
                                        ?>
                                        <?php
                                        $wp_rsm_cs_opt_array = array(
                                            'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_descr'),
                                            'desc' => '',
                                            'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_descr_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rsm_cs_allow_special_char($wp_rsm_cs_var_tabs_fancy_desc),
                                                'cust_id' => 'wp_rsm_cs_var_tabs_fancy_desc' . $wp_rsm_cs_counter,
                                                'cust_name' => 'wp_rsm_cs_var_tabs_fancy_desc[]',
                                                'return' => true,
                                                'classes' => '',
                                                'wp_rsm_cs_editor' => true,
                                            ),
                                        );
                                        $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_textarea_field($wp_rsm_cs_opt_array);
                                        ?>	 				
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="hidden-object">
                            <?php
                            $wp_rsm_cs_opt_array = array(
                                'std' => $tabs_fancy_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'tabs_fancy_num[]',
                                'required' => false
                            );
                            $wp_rsm_cs_var_form_fields->wp_rsm_cs_var_form_hidden_render($wp_rsm_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rsm_cs_shortcode_element_ajax_call('tabs_fancy', 'shortcode-item-<?php echo wp_rsm_cs_allow_special_char($wp_rsm_cs_counter); ?>', '<?php echo wp_rsm_cs_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_add_tab')); ?></a> </li>
                                    <div id="loading" class="shortcodeload"></div>
                                </ul>
                                <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                                    <ul class="form-elements insert-bg">
                                        <li class="to-field"> <a class="insert-btn cs-main-btn" onclick="javascript:wp_rsm_cs_shortcode_insert_editor('<?php echo esc_js(str_replace('wp_rsm_cs_var_page_builder_', '', $name)); ?>', 'shortcode-item-<?php echo wp_rsm_cs_allow_special_char($wp_rsm_cs_counter); ?>', '<?php echo wp_rsm_cs_allow_special_char($filter_element); ?>')" ><?php echo esc_html(wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_insert')); ?></a> </li>
                                    </ul>
                                    <div id="results-shortocde"></div>
                                    <?php
                                } else {
                                    $wp_rsm_cs_opt_array = array(
                                        'std' => 'tabs_fancy',
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => '',
                                        'extra_atr' => '',
                                        'cust_id' => '',
                                        'cust_name' => 'wp_rsm_cs_orderby[]',
                                        'required' => false
                                    );
                                    $wp_rsm_cs_var_form_fields->wp_rsm_cs_var_form_hidden_render($wp_rsm_cs_opt_array);
                                    $wp_rsm_cs_opt_array = array(
                                        'name' => '',
                                        'desc' => '',
                                        'hint_text' => '',
                                        'echo' => true,
                                        'field_params' => array(
                                            'std' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_save'),
                                            'cust_id' => '',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-admin-btn',
                                            'cust_name' => '',
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'return' => true,
                                        ),
                                    );
                                    $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            /* modern selection box and help hover text function */
            jQuery(document).ready(function ($) {
                chosen_selectionbox();
                popup_over();
            });
            /* end modern selection box and help hover text function */
        </script>
        <?php
        if ($die <> 1) {
            die();
        }
        ?>
        <?php
    }

    add_action('wp_ajax_wp_rsm_cs_var_page_builder_tabs_fancy', 'wp_rsm_cs_var_page_builder_tabs_fancy');
}

if (!function_exists('wp_rsm_cs_save_page_builder_data_tabs_fancy_callback')) {

    /**
     * Save data for tabs_fancy shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rsm_cs_save_page_builder_data_tabs_fancy_callback($args) {
        $data = $args['data'];
        $wp_rsm_cs_var_tabs_title = $data['wp_rsm_cs_var_tabs_title'];

        if (isset($wp_rsm_cs_var_tabs_title) && count($wp_rsm_cs_var_tabs_title) > 0) {
            foreach ($wp_rsm_cs_var_tabs_title as $title) {
                if ($title != '') {
                    $wp_rsm_cs_var_tabs_title_actual .=$title . ',';
                }
            }
        }


        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		$shortcode_data = '';
        if ($widget_type == "tabs_fancy" || $widget_type == "cs_tabs_fancy") {
            $shortcode = $shortcode_item = '';

            $page_element_size = $data['tabs_fancy_element_size'][$counters['wp_rsm_cs_global_counter_tabs_fancy']];
            $current_element_size = $data['tabs_fancy_element_size'][$counters['wp_rsm_cs_global_counter_tabs_fancy']];

            if (isset($data['wp_rsm_cs_widget_element_num'][$counters['wp_rsm_cs_counter']]) && $data['wp_rsm_cs_widget_element_num'][$counters['wp_rsm_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($data['shortcode']['tabs_fancy'][$counters['wp_rsm_cs_shortcode_counter_tabs_fancy']]);

                $element_settings = 'tabs_fancy_element_size="' . $current_element_size . '"';
                $reg = '/tabs_fancy_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rsm_cs_shortcode_counter_tabs_fancy'] ++;
            } else {
                if (isset($data['tabs_fancy_num'][$counters['wp_rsm_cs_counter_tabs_fancy']]) && $data['tabs_fancy_num'][$counters['wp_rsm_cs_counter_tabs_fancy']] > 0) {
                    for ($i = 1; $i <= $data['tabs_fancy_num'][$counters['wp_rsm_cs_counter_tabs_fancy']]; $i ++) {
                        $shortcode_item .= '[wp_rsm_cs_tabs_fancy_item ';
                        if (isset($data['wp_rsm_cs_var_tabs_fancy_item_text'][$counters['wp_rsm_cs_counter_tabs_fancy_node']]) && $data['wp_rsm_cs_var_tabs_fancy_item_text'][$counters['wp_rsm_cs_counter_tabs_fancy_node']] != '') {
                            $shortcode_item .= 'wp_rsm_cs_var_tabs_fancy_item_text="' . htmlspecialchars($data['wp_rsm_cs_var_tabs_fancy_item_text'][$counters['wp_rsm_cs_counter_tabs_fancy_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rsm_cs_var_tabs_image_array'][$counters['wp_rsm_cs_counter_tabs_fancy_node']]) && $data['wp_rsm_cs_var_tabs_image_array'][$counters['wp_rsm_cs_counter_tabs_fancy_node']] != '') {
                            $shortcode_item .= 'wp_rsm_cs_var_tabs_image_array="' . $data['wp_rsm_cs_var_tabs_image_array'][$counters['wp_rsm_cs_counter_tabs_fancy_node']] . '" ';
                        }
                        if (isset($data['wp_rsm_cs_var_tabs_fancy_active'][$counters['wp_rsm_cs_counter_tabs_fancy_node']]) && $data['wp_rsm_cs_var_tabs_fancy_active'][$counters['wp_rsm_cs_counter_tabs_fancy_node']] != '') {
                            $shortcode_item .= 'wp_rsm_cs_var_tabs_fancy_active="' . htmlspecialchars($data['wp_rsm_cs_var_tabs_fancy_active'][$counters['wp_rsm_cs_counter_tabs_fancy_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if (isset($data['wp_rsm_cs_var_tabs_fancy_desc'][$counters['wp_rsm_cs_counter_tabs_fancy_node']]) && $data['wp_rsm_cs_var_tabs_fancy_desc'][$counters['wp_rsm_cs_counter_tabs_fancy_node']] != '') {
                            $shortcode_item .= htmlspecialchars($data['wp_rsm_cs_var_tabs_fancy_desc'][$counters['wp_rsm_cs_counter_tabs_fancy_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/wp_rsm_cs_tabs_fancy_item]';
                        $counters['wp_rsm_cs_counter_tabs_fancy_node'] ++;
                    }
                }
                $section_title = '';
                if (isset($data['wp_rsm_cs_var_tabs_fancy_title'][$counters['wp_rsm_cs_counter_tabs_fancy']]) && $data['wp_rsm_cs_var_tabs_fancy_title'][$counters['wp_rsm_cs_counter_tabs_fancy']] != '') {
                    $section_title .= 'wp_rsm_cs_var_tabs_fancy_title="' . htmlspecialchars($data['wp_rsm_cs_var_tabs_fancy_title'][$counters['wp_rsm_cs_counter_tabs_fancy']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_tabs_fancy_subtitle'][$counters['wp_rsm_cs_counter_tabs_fancy']]) && $data['wp_rsm_cs_var_tabs_fancy_subtitle'][$counters['wp_rsm_cs_counter_tabs_fancy']] != '') {
                    $section_title .= 'wp_rsm_cs_var_tabs_fancy_subtitle="' . htmlspecialchars($data['wp_rsm_cs_var_tabs_fancy_subtitle'][$counters['wp_rsm_cs_counter_tabs_fancy']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_tabs_fancy_title_align'][$counters['wp_rsm_cs_counter_tabs_fancy']]) && $data['wp_rsm_cs_var_tabs_fancy_title_align'][$counters['wp_rsm_cs_counter_tabs_fancy']] != '') {
                    $section_title .= 'wp_rsm_cs_var_tabs_fancy_title_align="' . htmlspecialchars($data['wp_rsm_cs_var_tabs_fancy_title_align'][$counters['wp_rsm_cs_counter_tabs_fancy']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rsm_cs_var_tabs_title'][$counters['wp_rsm_cs_counter_tabs_fancy']]) && $wp_rsm_cs_var_tabs_title_actual != '') {
                    $section_title .= 'wp_rsm_cs_var_tabs_title="' . $wp_rsm_cs_var_tabs_title_actual . '" ';
                }

                $element_settings = 'tabs_fancy_element_size="' . htmlspecialchars($data['tabs_fancy_element_size'][$counters['wp_rsm_cs_global_counter_tabs_fancy']]) . '"';
                $shortcode = '[wp_rsm_cs_tabs_fancy ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/wp_rsm_cs_tabs_fancy]';

                $shortcode_data .= $shortcode;
                $counters['wp_rsm_cs_counter_tabs_fancy'] ++;
            }
            $counters['wp_rsm_cs_global_counter_tabs_fancy'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rsm_cs_save_page_builder_data_tabs_fancy', 'wp_rsm_cs_save_page_builder_data_tabs_fancy_callback');
}

if (!function_exists('wp_rsm_cs_load_shortcode_counters_tabs_fancy_callback')) {

    /**
     * Populate tabs_fancy shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rsm_cs_load_shortcode_counters_tabs_fancy_callback($counters) {
        $counters['wp_rsm_cs_counter_tabs_fancy'] = 0;
        $counters['wp_rsm_cs_counter_tabs_fancy_node'] = 0;
        $counters['wp_rsm_cs_shortcode_counter_tabs_fancy'] = 0;
        $counters['wp_rsm_cs_global_counter_tabs_fancy'] = 0;
        return $counters;
    }

    add_filter('wp_rsm_cs_load_shortcode_counters', 'wp_rsm_cs_load_shortcode_counters_tabs_fancy_callback');
}

if (!function_exists('wp_rsm_cs_shortcode_names_list_populate_tabs_fancy_callback')) {

    /**
     * Populate tabs_fancy shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rsm_cs_shortcode_names_list_populate_tabs_fancy_callback($shortcode_array) {
        $shortcode_array['tabs_fancy'] = array(
            'title' => 'Facny Tabs',
            'name' => 'tabs_fancy',
            'icon' => 'icon-tab',
            'categories' => 'contentblocks',
            'desc' => wp_rsm_cs_var_frame_text_srt('wp_rsm_cs_var_tabs_fancy_desc'),
        );
        return $shortcode_array;
    }

    add_filter('wp_rsm_cs_shortcode_names_list_populate', 'wp_rsm_cs_shortcode_names_list_populate_tabs_fancy_callback');
}

if (!function_exists('wp_rsm_cs_element_list_populate_tabs_fancy_callback')) {

    /**
     * Populate tabs_fancy shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rsm_cs_element_list_populate_tabs_fancy_callback($element_list) {
        $element_list['tabs_fancy'] = 'Facny Tabs';
        return $element_list;
    }

    add_filter('wp_rsm_cs_element_list_populate', 'wp_rsm_cs_element_list_populate_tabs_fancy_callback');
}

if (!function_exists('wp_rsm_cs_shortcode_sub_element_ui_tabs_fancy_callback')) {

    /**
     * Render UI for sub element in tabs_fancy settings.
     *
     * @param	array $args
     */
    function wp_rsm_cs_shortcode_sub_element_ui_tabs_fancy_callback($args) {
        $type = $args['type'];
        $wp_rsm_cs_var_html_fields = $args['html_fields'];
        if ($type == 'tabs_fancy') {
            $rand_id = rand(23, 45453);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="wp_rsm_cs_tabs_fancy_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rsm_cs_var_frame_text_srt('wp_rsm_cs_var_tab'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rsm_cs_var_frame_text_srt('wp_rsm_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rsm_cs_opt_array = array(
                    'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text'),
                    'desc' => '',
                    'required' => true,
                    'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_item_text_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'fancy_item_text',
                        'cust_name' => 'wp_rsm_cs_var_tabs_fancy_item_text[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_text_field($wp_rsm_cs_opt_array);
                $wp_rsm_cs_opt_array = array(
                    'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_active'),
                    'desc' => '',
                    'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_active_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'tabs_fancy_item_text',
                        'cust_name' => 'wp_rsm_cs_var_tabs_fancy_active[]',
                        'classes' => 'dropdown chosen-select-no-single select-medium',
                        'options' => array(),
                        'return' => true,
                    ),
                );
                $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_select_field($wp_rsm_cs_opt_array);
                $wp_rsm_cs_opt_array = array(
                    'std' => esc_url($wp_rsm_cs_var_tabs_image_array),
                    'id' => 'tabs_image',
                    'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_testimonial_field_image'),
                    'desc' => '',
                    'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_testimonial_field_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'prefix' => '',
                    'field_params' => array(
                        'std' => esc_url($wp_rsm_cs_var_tabs_image_array),
                        'id' => 'tabs_image',
                        'return' => true,
                        'array' => true,
                        'array_txt' => false,
                        'prefix' => '',
                    ),
                );
                $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_upload_file_field($wp_rsm_cs_opt_array);
                ?>

                <?php
                $wp_rsm_cs_opt_array = array(
                    'name' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_descr'),
                    'desc' => '',
                    'hint_text' => wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_var_tabs_fancy_descr_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => 'wp_rsm_cs_var_tabs_fancy_desc',
                        'cust_name' => 'wp_rsm_cs_var_tabs_fancy_desc[]',
                        'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                        'return' => true,
                        'classes' => '',
                        'wp_rsm_cs_editor' => true
                    ),
                );
                $wp_rsm_cs_var_html_fields->wp_rsm_cs_var_textarea_field($wp_rsm_cs_opt_array);
                ?>   
            </div>
            <?php
        }
    }

    add_action('wp_rsm_cs_shortcode_sub_element_ui', 'wp_rsm_cs_shortcode_sub_element_ui_tabs_fancy_callback');
}