<?php
/*
 *
 * @Shortcode Name : tabs
 * @retrun
 *
 */
if (!function_exists('wp_rem_cs_var_page_builder_tabs')) {

    function wp_rem_cs_var_page_builder_tabs($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $string = new wp_rem_cs_theme_all_strings;
        $string->wp_rem_cs_short_code_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $tabs_num = 0;
        if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'tabs|tabs_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '1/1',
            'wp_rem_cs_var_element_title' => '',
            'wp_rem_cs_var_element_subtitle' => '',
            'wp_rem_var_tabs_align' => '',
            'wp_rem_cs_var_tabs_view' => '',
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
            $tabs_num = count($atts_content);
        }
        $tabs_element_size = '100';
        foreach ($defaults as $key => $values) {
            if (isset($atts[$key])) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $wp_rem_cs_var_element_title = isset($wp_rem_cs_var_element_title) ? $wp_rem_cs_var_element_title : '';
        $wp_rem_cs_var_tabs_view = isset($wp_rem_cs_var_tabs_view) ? $wp_rem_cs_var_tabs_view : '';

        $name = 'wp_rem_cs_var_page_builder_tabs';
        $coloumn_class = 'column_' . $tabs_element_size;
        if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="tabs" data="<?php echo wp_rem_cs_element_size_data_array_index($tabs_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $tabs_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_edit')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/tabs]" data-shortcode-child-template="[tabs_item {{attributes}}] {{content}} [/tabs_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[tabs {{attributes}}]">
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
                                        'std' => esc_attr($wp_rem_cs_var_element_title),
                                        'cust_id' => '',
                                        'cust_name' => 'wp_rem_cs_var_element_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_var_element_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_element_subtitle[]',
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
                                        'std' => $wp_rem_var_tabs_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_tabs_align',
                                        'cust_name' => 'wp_rem_var_tabs_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_styles'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_styles_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_tabs_view,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_cs_var_tabs_view',
                                        'cust_name' => 'wp_rem_cs_var_tabs_view[]',
                                        'classes' => 'wp_rem_cs_var_tabs_view chosen-select select-medium',
                                        'options' => array(
                                            'vertical' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_style_vertical'),
                                            'horizontal' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_style_horizontal'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                ?>
                            </div>
                            <?php
                            if (isset($tabs_num) && $tabs_num <> '' && isset($atts_content) && is_array($atts_content)) {
                                foreach ($atts_content as $tabs) {
                                    $rand_string = rand(123456, 987654);
                                    $wp_rem_cs_var_tabs_text = $tabs['content'];
                                    $defaults = array(
                                        'wp_rem_cs_var_tabs_title' => '',
                                        'wp_rem_cs_var_tabs_icon' => '',
                                        'wp_rem_cs_var_tabs_icon_group' => 'default',
                                        'wp_rem_cs_var_link_url' => '',
                                        'wp_rem_cs_var_tabs_icon_type' => '',
                                        'wp_rem_cs_var_tabs_image' => '',
                                        'wp_rem_cs_var_tab_active' => '',
                                    );
                                    foreach ($defaults as $key => $values) {
                                        if (isset($tabs['atts'][$key])) {
                                            $$key = $tabs['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    $wp_rem_cs_var_tabs_text = isset($wp_rem_cs_var_tabs_text) ? $wp_rem_cs_var_tabs_text : '';
                                    $wp_rem_cs_var_tabs_title = isset($wp_rem_cs_var_tabs_title) ? $wp_rem_cs_var_tabs_title : '';
                                    $wp_rem_cs_var_tabs_icon = isset($wp_rem_cs_var_tabs_icon) ? $wp_rem_cs_var_tabs_icon : '';
                                    $wp_rem_cs_var_tabs_icon_color = isset($wp_rem_cs_var_tabs_icon_color) ? $wp_rem_cs_var_tabs_icon_color : '';
                                    $wp_rem_cs_var_link_url = isset($wp_rem_cs_var_link_url) ? $wp_rem_cs_var_link_url : '';
                                    $wp_rem_cs_var_tabs_icon_type = isset($wp_rem_cs_var_tabs_icon_type) ? $wp_rem_cs_var_tabs_icon_type : '';
                                    $wp_rem_cs_var_tabs_image = isset($wp_rem_cs_var_tabs_image) ? $wp_rem_cs_var_tabs_image : '';
                                    $wp_rem_cs_var_tab_active = isset($wp_rem_cs_var_tab_active) ? $wp_rem_cs_var_tab_active : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabss_title')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a>
                                        </header>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_active'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_active_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_var_tab_active,
                                                'id' => '',
                                                'cust_id' => 'wp_rem_cs_var_tab_active',
                                                'cust_name' => 'wp_rem_cs_var_tab_active[]',
                                                'classes' => 'wp_rem_cs_var_tab_active chosen-select select-medium',
                                                'options' => array(
                                                    'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
                                                    'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tab_title'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tab_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_tabs_title),
                                                'cust_id' => 'wp_rem_cs_var_tabs_title',
                                                'classes' => '',
                                                'cust_name' => 'wp_rem_cs_var_tabs_title[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        ?>

                                        <div class="cs-sh-tabs-icon-area" style="display:<?php echo esc_html($wp_rem_cs_var_tabs_icon_type != 'image' ? 'block' : 'none' ) ?>;">
                                            <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                                                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                    <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon')); ?></label>
                                                    <?php
                                                    if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                                                        echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon_hint'));
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                    <?php echo apply_filters( 'cs_icons_fields', $wp_rem_cs_var_tabs_icon, esc_attr($rand_id), 'wp_rem_cs_var_tabs_icon', $wp_rem_cs_var_tabs_icon_group ); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon_content'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon_content_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_tabs_text),
                                                'cust_id' => '',
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'cust_name' => 'wp_rem_cs_var_tabs_text[]',
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
                                        parentNode.find(".cs-sh-tabs-image-area").show();
                                        parentNode.find(".cs-sh-tabs-icon-area").hide();
                                    } else {
                                        parentNode.find(".cs-sh-tabs-image-area").hide();
                                        parentNode.find(".cs-sh-tabs-icon-area").show();
                                    }
                                }
                                );
                            </script>
                        </div>
                        <div class="hidden-object">
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_allow_special_char($tabs_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'tabs_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_tabsss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('tabs', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_add')); ?></a> </li>
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
                                        'std' => 'tabs',
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
                                            'cust_id' => 'tabs_save' . $wp_rem_cs_counter,
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-wp_rem_cs-admin-btn',
                                            'cust_name' => 'tabs_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_tabs', 'wp_rem_cs_var_page_builder_tabs');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_tabs_callback')) {

    /**
     * Save data for tabs shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_tabs_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		$shortcode_data = '';
        if ($widget_type == "tabs" || $widget_type == "cs_tabs") {
            $shortcode = $shortcode_item = '';

            $page_element_size = $data['tabs_element_size'][$counters['wp_rem_cs_global_counter_tabs']];
            $current_element_size = $data['tabs_element_size'][$counters['wp_rem_cs_global_counter_tabs']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes($data['shortcode']['tabs'][$counters['wp_rem_cs_shortcode_counter_tabs']]);

                $element_settings = 'tabs_element_size="' . $current_element_size . '"';
                $reg = '/tabs_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_tabs'] ++;
            } else {
                if (isset($data['tabs_num'][$counters['wp_rem_cs_counter_tabs']]) && $data['tabs_num'][$counters['wp_rem_cs_counter_tabs']] > 0) {
                    for ($i = 1; $i <= $data['tabs_num'][$counters['wp_rem_cs_counter_tabs']]; $i ++) {
                        $shortcode_item .= '[tabs_item ';

                        if (isset($data['wp_rem_cs_var_tabs_title'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_tabs_title'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_tabs_title="' . htmlspecialchars($data['wp_rem_cs_var_tabs_title'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_link_url'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_link_url'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_link_url="' . htmlspecialchars($data['wp_rem_cs_var_link_url'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_tab_active'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_tab_active'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_tab_active="' . htmlspecialchars($data['wp_rem_cs_var_tab_active'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_tabs_icon'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_tabs_icon'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_tabs_icon="' . htmlspecialchars($data['wp_rem_cs_var_tabs_icon'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_tabs_icon_group'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_tabs_icon_group'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_tabs_icon_group="' . htmlspecialchars($data['wp_rem_cs_var_tabs_icon_group'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_tabs_icon_type'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_tabs_icon_type'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_tabs_icon_type="' . htmlspecialchars($data['wp_rem_cs_var_tabs_icon_type'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES) . '" ';
                        }
                        if (isset($data['wp_rem_cs_var_tabs_image'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_tabs_image'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= 'wp_rem_cs_var_tabs_image="' . htmlspecialchars($data['wp_rem_cs_var_tabs_image'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if (isset($data['wp_rem_cs_var_tabs_text'][$counters['wp_rem_cs_counter_tabs_node']]) && $data['wp_rem_cs_var_tabs_text'][$counters['wp_rem_cs_counter_tabs_node']] != '') {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_tabs_text'][$counters['wp_rem_cs_counter_tabs_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/tabs_item]';
                        $counters['wp_rem_cs_counter_tabs_node'] ++;
                    }
                }
                $section_title = '';
                if (isset($data['wp_rem_cs_var_element_title'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_var_element_title'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_var_element_title="' . htmlspecialchars($data['wp_rem_cs_var_element_title'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_element_subtitle'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_var_element_subtitle'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_var_element_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_element_subtitle'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_tabs_align'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_var_tabs_align'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_var_tabs_align="' . htmlspecialchars($data['wp_rem_var_tabs_align'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_title_color'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_title_color'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_title_color="' . htmlspecialchars($data['wp_rem_cs_title_color'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_tabs_content_color'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_tabs_content_color'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_tabs_content_color="' . htmlspecialchars($data['wp_rem_cs_tabs_content_color'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_tabs_icon_color'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_tabs_icon_color'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_tabs_icon_color="' . htmlspecialchars($data['wp_rem_cs_tabs_icon_color'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_tabs_icon_size'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_var_tabs_icon_size'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_var_tabs_icon_size="' . htmlspecialchars($data['wp_rem_cs_var_tabs_icon_size'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_tabs_view'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_var_tabs_view'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_var_tabs_view="' . htmlspecialchars($data['wp_rem_cs_var_tabs_view'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_tabs_content_align'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_tabs_content_align'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_tabs_content_align="' . htmlspecialchars($data['wp_rem_cs_tabs_content_align'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_tabs_sub_title'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_var_tabs_sub_title'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_var_tabs_sub_title="' . htmlspecialchars(str_replace('"', '\'', wp_rem_cs_custom_shortcode_encode($data['wp_rem_cs_var_tabs_sub_title'][$counters['wp_rem_cs_counter_tabs']]))) . '" ';
                }
                if (isset($data['wp_rem_cs_var_tabs_column'][$counters['wp_rem_cs_counter_tabs']]) && $data['wp_rem_cs_var_tabs_column'][$counters['wp_rem_cs_counter_tabs']] != '') {
                    $section_title .= 'wp_rem_cs_var_tabs_column="' . htmlspecialchars($data['wp_rem_cs_var_tabs_column'][$counters['wp_rem_cs_counter_tabs']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'tabs_element_size="' . htmlspecialchars($data['tabs_element_size'][$counters['wp_rem_cs_global_counter_tabs']]) . '"';
                $shortcode = '[tabs ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/tabs]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_tabs'] ++;
            }
            $counters['wp_rem_cs_global_counter_tabs'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_tabs', 'wp_rem_cs_save_page_builder_data_tabs_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_tabs_callback')) {

    /**
     * Populate spacer shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_tabs_callback($counters) {
        $counters['wp_rem_cs_counter_tabs'] = 0;
        $counters['wp_rem_cs_counter_tabs_node'] = 0;
        $counters['wp_rem_cs_shortcode_counter_tabs'] = 0;
        $counters['wp_rem_cs_global_counter_tabs'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_tabs_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_tabs_callback')) {

    /**
     * Populate icon box shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_tabs_callback($shortcode_array) {
        $shortcode_array['tabs'] = array(
            'title' => 'Tabs',
            'name' => 'tabs',
            'icon' => 'icon-database2',
            'categories' => 'loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_tabs_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_tabs_callback')) {

    /**
     * Populate icon box shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_tabs_callback($element_list) {
        $element_list['tabs'] = 'Tabs';
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_tabs_callback');
}

if (!function_exists('wp_rem_cs_shortcode_sub_element_ui_tabs_callback')) {

    /**
     * Render UI for sub element in icon box settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_tabs_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];

        if ($type == 'tabs') {
            $tabs_count = 'tabs_' . rand(455345, 23454390);
            if (isset($wp_rem_cs_var_tabs_text) && $wp_rem_cs_var_tabs_text != '') {
                $wp_rem_cs_var_tabs_text = $wp_rem_cs_var_tabs_text;
            } else {
                $wp_rem_cs_var_tabs_text = '';
            }
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp' id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($tabs_count); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabss_title'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_active'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_active_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => $wp_rem_cs_var_tab_active,
                        'id' => '',
                        'cust_id' => 'wp_rem_cs_var_tab_active',
                        'cust_name' => 'wp_rem_cs_var_tab_active[]',
                        'classes' => 'wp_rem_cs_var_tab_active chosen-select select-medium',
                        'options' => array(
                            'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
                            'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
                        ),
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tab_title'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tab_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_tabs_title),
                        'cust_id' => 'wp_rem_cs_var_tabs_title',
                        'classes' => '',
                        'cust_name' => 'wp_rem_cs_var_tabs_title[]',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);


                $rand_id = rand(123450, 854987);
                ?>	 				


                <div class="cs-sh-tabs-icon-area" style="display:<?php echo esc_html($wp_rem_cs_var_tabs_icon_type != 'image' ? 'block' : 'none' ) ?>;">
                    <div class="form-elements" id="wp_rem_cs_infobox_<?php echo esc_attr($rand_id); ?>">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon')); ?></label>
                            <?php
                            if (function_exists('wp_rem_cs_var_tooltip_helptext')) {
                                echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon_hint'));
                            }
                            ?>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <?php echo apply_filters( 'cs_icons_fields', '', esc_attr($rand_id), 'wp_rem_cs_var_tabs_icon'); ?>
                        </div>
                    </div>
                </div>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon_content'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_icon_content_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_var_tabs_text),
                        'cust_id' => '',
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'cust_name' => 'wp_rem_cs_var_tabs_text[]',
                        'return' => true,
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
                        parentNode.find(".cs-sh-tabs-image-area").show();
                        parentNode.find(".cs-sh-tabs-icon-area").hide();
                    } else {
                        parentNode.find(".cs-sh-tabs-image-area").hide();
                        parentNode.find(".cs-sh-tabs-icon-area").show();
                    }

                }
                );
            </script>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_tabs_callback');
}