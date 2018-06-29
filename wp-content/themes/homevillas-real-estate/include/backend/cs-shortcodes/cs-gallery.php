<?php
/*
 *
 * @Shortcode Name : Gallery
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_page_builder_gallery') ) {

    function wp_rem_cs_var_page_builder_gallery($die = 0) {
        global $wp_rem_cs_node, $count_node, $post, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $PREFIX = 'wp_rem_cs_gallery|gallery_item';
        $parseObject = new ShortcodeParse();
        $gallery_num = 0;
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
            'wp_rem_cs_var_gallery_main_title' => '',
            'wp_rem_cs_var_gallery_main_subtitle' => '',
            'wp_rem_var_gallery_align' => '',
            'wp_rem_cs_var_gallery_magin_right' => '',
            'wp_rem_cs_var_gallery_magin_left' => '',
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
            $gallery_num = count($atts_content);
        }
        $gallery_element_size = '50';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $name = 'wp_rem_cs_var_page_builder_gallery';
        $coloumn_class = 'column_' . $gallery_element_size;
        $wp_rem_cs_var_gallery_view = isset($wp_rem_cs_var_gallery_view) ? $wp_rem_cs_var_gallery_view : '';
        $wp_rem_cs_var_gallery_main_title = isset($wp_rem_cs_var_gallery_main_title) ? $wp_rem_cs_var_gallery_main_title : '';
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="gallery" data="<?php echo wp_rem_cs_element_size_data_array_index($gallery_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $gallery_element_size, '', 'list-ul'); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[<?php echo esc_attr(WP_REM_SC_ACCORDION); ?> {{attributes}}]" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_edit_options')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a> </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}}[/<?php echo esc_attr('wp_rem_cs_gallery'); ?>]" data-shortcode-child-template="[<?php echo esc_attr('gallery_item'); ?> {{attributes}}] {{content}} [/<?php echo esc_attr('gallery_item'); ?>]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[<?php echo esc_attr('wp_rem_cs_gallery'); ?> {{attributes}}]">
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => wp_rem_cs_allow_special_char($wp_rem_cs_var_gallery_main_title),
                                        'id' => 'wp_rem_cs_var_gallery_main_title',
                                        'cust_name' => 'wp_rem_cs_var_gallery_main_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_var_gallery_main_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_gallery_main_subtitle[]',
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
                                        'std' => $wp_rem_var_gallery_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_gallery_align',
                                        'cust_name' => 'wp_rem_var_gallery_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_gallery_margin_left'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_gallery_margin_left_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_gallery_magin_left),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_gallery_magin_left[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_gallery_margin_right'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_gallery_margin_right_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_gallery_magin_right),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_gallery_magin_right[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                                    wp_rem_cs_shortcode_element_size();
                                }
                                ?>

                            </div>
                            <?php
                            if ( isset($gallery_num) && $gallery_num <> '' && isset($atts_content) && is_array($atts_content) ) {
                                foreach ( $atts_content as $gallery ) {

                                    $rand_id = rand(3333, 99999);
                                    $wp_rem_cs_var_gallery_text = $gallery['content'];
                                    $defaults = array(
                                        'wp_rem_cs_var_galler_img_size' => '',
                                        'wp_rem_cs_var_gallery_image' => ''
                                    );
                                    foreach ( $defaults as $key => $values ) {
                                        if ( isset($gallery['atts'][$key]) )
                                            $$key = $gallery['atts'][$key];
                                        else
                                            $$key = $values;
                                    }

                                    $wp_rem_cs_var_galler_img_size = isset($wp_rem_cs_var_galler_img_size) ? $wp_rem_cs_var_galler_img_size : '';
                                    $wp_rem_cs_var_gallery = isset($wp_rem_cs_var_gallery) ? $wp_rem_cs_var_gallery : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp  cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_id); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_gallery')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a>
                                        </header>
                                        <?php
                                        
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_var_galler_img_size,
                                                'id' => '',
                                                'cust_name' => 'wp_rem_cs_var_galler_img_size[]',
                                                'classes' => 'dropdown chosen-select',
                                                'options' => array(
                                                    'img-small' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size_small'),
                                                    'img-large' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size_large'),
                                                ),
                                                'return' => true,
                                            ),
                                        );

                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'std' => $wp_rem_cs_var_gallery_image,
                                            'id' => 'gallery_image_array',
                                            'main_id' => 'gallery_image_array',
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_var_gallery_image,
                                                'cust_id' => '',
                                                'cust_name' => 'wp_rem_cs_var_gallery_image[]',
                                                'id' => 'gallery_image_array',
                                                'return' => true,
                                                'array' => true,
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
                                'std' => $gallery_num,
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'gallery_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox">
                            <div class="opt-conts">
                                <ul class="form-elements noborder">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('gallery', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo wp_rem_cs_allow_special_char(admin_url('admin-ajax.php')); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add_gallery')); ?></a> </li>
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
                                        'std' => 'gallery',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_gallery', 'wp_rem_cs_var_page_builder_gallery');
}
if ( ! function_exists('wp_rem_cs_save_page_builder_data_gallery_callback') ) {

    /**
     * Save data for gallery shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_gallery_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];

        $shortcode_data = '';
        if ( $widget_type == "gallery" || $widget_type == "cs_gallery" ) {
            $shortcode = $shortcode_item = '';
            $page_element_size = $data['gallery_element_size'][$counters['wp_rem_cs_global_counter_gallery']];
            $current_element_size = $data['gallery_element_size'][$counters['wp_rem_cs_global_counter_gallery']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($data['shortcode']['gallery'][$counters['wp_rem_cs_shortcode_counter_gallery']]);
                $element_settings = 'gallery_element_size="' . $current_element_size . '"';
                $reg = '/gallery_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_gallery'] ++;
            } else {
                if ( isset($data['gallery_num'][$counters['wp_rem_cs_counter_gallery']]) && $data['gallery_num'][$counters['wp_rem_cs_counter_gallery']] > 0 ) {
                    for ( $i = 1; $i <= $data['gallery_num'][$counters['wp_rem_cs_counter_gallery']]; $i ++ ) {
                        $shortcode_item .= '[gallery_item ';

                        if ( isset($data['wp_rem_cs_var_galler_img_size'][$counters['wp_rem_cs_counter_gallery_node']]) && $data['wp_rem_cs_var_galler_img_size'][$counters['wp_rem_cs_counter_gallery_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_galler_img_size="' . htmlspecialchars($data['wp_rem_cs_var_galler_img_size'][$counters['wp_rem_cs_counter_gallery_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_gallery'][$counters['wp_rem_cs_counter_gallery_node']]) && $data['wp_rem_cs_var_gallery'][$counters['wp_rem_cs_counter_gallery_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_gallery="' . htmlspecialchars($data['wp_rem_cs_var_gallery'][$counters['wp_rem_cs_counter_gallery_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_gallery_image'][$counters['wp_rem_cs_counter_gallery_node']]) && $data['wp_rem_cs_var_gallery_image'][$counters['wp_rem_cs_counter_gallery_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_gallery_image="' . htmlspecialchars($data['wp_rem_cs_var_gallery_image'][$counters['wp_rem_cs_counter_gallery_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if ( isset($data['wp_rem_cs_var_gallery_text'][$counters['wp_rem_cs_counter_gallery_node']]) && $data['wp_rem_cs_var_gallery_text'][$counters['wp_rem_cs_counter_gallery_node']] != '' ) {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_gallery_text'][$counters['wp_rem_cs_counter_gallery_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/gallery_item]';
                        $counters['wp_rem_cs_counter_gallery_node'] ++;
                    }
                }
                $section_title = '';

                if ( isset($data['wp_rem_cs_var_gallery_magin_right'][$counters['wp_rem_cs_counter_gallery']]) && $data['wp_rem_cs_var_gallery_magin_right'][$counters['wp_rem_cs_counter_gallery']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_gallery_magin_right="' . htmlspecialchars($data['wp_rem_cs_var_gallery_magin_right'][$counters['wp_rem_cs_counter_gallery']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_gallery_magin_left'][$counters['wp_rem_cs_counter_gallery']]) && $data['wp_rem_cs_var_gallery_magin_left'][$counters['wp_rem_cs_counter_gallery']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_gallery_magin_left="' . htmlspecialchars($data['wp_rem_cs_var_gallery_magin_left'][$counters['wp_rem_cs_counter_gallery']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_gallery_main_title'][$counters['wp_rem_cs_counter_gallery']]) && $data['wp_rem_cs_var_gallery_main_title'][$counters['wp_rem_cs_counter_gallery']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_gallery_main_title="' . htmlspecialchars($data['wp_rem_cs_var_gallery_main_title'][$counters['wp_rem_cs_counter_gallery']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_gallery_align'][$counters['wp_rem_cs_counter_gallery']]) && $data['wp_rem_var_gallery_align'][$counters['wp_rem_cs_counter_gallery']] != '' ) {
                    $section_title .= 'wp_rem_var_gallery_align="' . htmlspecialchars($data['wp_rem_var_gallery_align'][$counters['wp_rem_cs_counter_gallery']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_gallery_main_subtitle'][$counters['wp_rem_cs_counter_gallery']]) && $data['wp_rem_cs_var_gallery_main_subtitle'][$counters['wp_rem_cs_counter_gallery']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_gallery_main_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_gallery_main_subtitle'][$counters['wp_rem_cs_counter_gallery']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'gallery_element_size="' . htmlspecialchars($data['gallery_element_size'][$counters['wp_rem_cs_global_counter_gallery']]) . '"';
                $shortcode = '[wp_rem_cs_gallery ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/wp_rem_cs_gallery]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_gallery'] ++;
            }
            $counters['wp_rem_cs_global_counter_gallery'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_gallery', 'wp_rem_cs_save_page_builder_data_gallery_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_gallery_callback') ) {

    /**
     * Populate gallery shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_gallery_callback($counters) {
        $counters['wp_rem_cs_global_counter_gallery'] = 0;
        $counters['wp_rem_cs_shortcode_counter_gallery'] = 0;
        $counters['wp_rem_cs_counter_gallery_node'] = 0;
        $counters['wp_rem_cs_counter_gallery'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_gallery_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_gallery_callback') ) {

    /**
     * Populate gallery shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_gallery_callback($shortcode_array) {
        $shortcode_array['gallery'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_gallery'),
            'name' => 'gallery',
            'icon' => 'icon-images',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_gallery_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_gallery_callback') ) {

    /**
     * Populate gallery shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_gallery_callback($element_list) {
        $element_list['gallery'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_gallery');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_gallery_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_sub_element_ui_gallery_callback') ) {

    /**
     * Render UI for sub element in gallery settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_gallery_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];

        if ( $type == 'gallery' ) {

            $rand_id = rand(324235, 993249);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp'  id="wp_rem_cs_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_gallery'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => '',
                        'cust_name' => 'wp_rem_cs_var_galler_img_size[]',
                        'classes' => 'dropdown chosen-select',
                        'options' => array(
                            'img-small' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size_small'),
                            'img-large' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_size_large'),
                        ),
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'std' => '',
                    'id' => 'gallery_image_array',
                    'main_id' => 'gallery_image_array',
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_gallery_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_gallery_image[]',
                        'id' => 'gallery_image_array',
                        'return' => true,
                        'array' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                ?>
            </div>
             <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_gallery_callback');
}