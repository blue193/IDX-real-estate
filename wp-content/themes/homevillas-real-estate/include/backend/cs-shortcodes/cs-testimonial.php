<?php
/*
 *
 * @Shortcode Name : Testimonial
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_testimonial') ) {

    function wp_rem_cs_var_page_builder_testimonial($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $testimonial_num = 0;
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_testimonial|testimonial_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_testimonial_title' => '',
            'wp_rem_cs_var_testimonial_subtitle' => '',
            'wp_rem_var_testimonial_align' => '',
            'wp_rem_cs_var_author_color' => '',
            'wp_rem_cs_var_heading_color' => '',
            'wp_rem_cs_var_text_color' => '',
            'wp_rem_cs_var_testimonial_view' => '',
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
            $testimonial_num = count($atts_content);
        }
        $testimonial_element_size = '100';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $wp_rem_cs_var_testimonial_title = isset($wp_rem_cs_var_testimonial_title) ? $wp_rem_cs_var_testimonial_title : '';
        $wp_rem_cs_var_author_color = isset($wp_rem_cs_var_author_color) ? $wp_rem_cs_var_author_color : '';
        $wp_rem_cs_var_testimonial_view = isset($wp_rem_cs_var_testimonial_view) ? $wp_rem_cs_var_testimonial_view : '';

        $name = 'wp_rem_cs_var_page_builder_testimonial';
        $coloumn_class = 'column_' . $testimonial_element_size;
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        global $wp_rem_cs_var_static_text;
        $rand_string = rand(123456, 987654);
        $rand_num = rand(12345, 9876);
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="testimonial" data="<?php echo wp_rem_cs_element_size_data_array_index($testimonial_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $testimonial_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_edit')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/wp_rem_cs_testimonial]" data-shortcode-child-template="[testimonial_item {{attributes}}] {{content}} [/testimonial_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[wp_rem_cs_testimonial {{attributes}}]">
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
                                        'std' => esc_attr($wp_rem_cs_var_testimonial_title),
                                        'cust_id' => '',
                                        'cust_name' => 'wp_rem_cs_var_testimonial_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_var_testimonial_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_testimonial_subtitle[]',
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
                                        'std' => $wp_rem_var_testimonial_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_testimonial_align',
                                        'cust_name' => 'wp_rem_var_testimonial_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_views'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_views_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_var_testimonial_view,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_cs_var_testimonial_view',
                                        'cust_name' => 'wp_rem_cs_var_testimonial_view[]',
                                        'classes' => 'wp_rem_cs_var_testimonial_view chosen-select select-medium view_class',
                                        'extra_atr' => 'onchange="testimonial_view(this.value)"',
                                        'options' => array(
                                            'fancy' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_style_fancy'),
                                            'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_style_modern'),
                                            'advance' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_style_advance'),
                                            'advance-v1' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_style_advance_v1'),
                                            'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_style_classic'),
                                            'simple' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_style_simple'),
                                            'default' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_view_default'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                ?>
                                <script>
                                    function testimonial_view($wp_rem_cs_var_testimonial_view) {
                                        if ($wp_rem_cs_var_testimonial_view == 'modern' || $wp_rem_cs_var_testimonial_view == 'advance' || $wp_rem_cs_var_testimonial_view == 'advance-v1') {
                                            jQuery('.bg_dynamic_fields_<?php echo intval($rand_num); ?>').hide();
                                            jQuery('.url_dynamic_fields_<?php echo intval($rand_num); ?>').show();

                                        } else {
                                            jQuery('.bg_dynamic_fields_<?php echo intval($rand_num); ?>').show();
                                            jQuery('.url_dynamic_fields_<?php echo intval($rand_num); ?>').hide();
                                        }
                                    }
                                </script>
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_author_color'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_author_color),
                                        'cust_id' => 'wp_rem_cs_var_author_color' . $wp_rem_cs_counter,
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_author_color[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_heading_color'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_heading_color),
                                        'cust_id' => 'wp_rem_cs_var_heading_color' . $wp_rem_cs_counter,
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_heading_color[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_address_color'),
                                    'desc' => '',
                                    'hint_text' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_text_color),
                                        'cust_id' => 'wp_rem_cs_var_text_color' . $wp_rem_cs_counter,
                                        'classes' => 'bg_color',
                                        'cust_name' => 'wp_rem_cs_var_text_color[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                ?>
                            </div>
                            <?php
                            if ( isset($testimonial_num) && $testimonial_num <> '' && isset($atts_content) && is_array($atts_content) ) {
                                foreach ( $atts_content as $testimonial ) {
                                    $rand_string = rand(123456, 987654);
                                    $wp_rem_cs_var_testimonial_content = $testimonial['content'];
                                    $defaults = array(
                                        'wp_rem_cs_var_testimonial_author' => '',
                                        'wp_rem_cs_var_testimonial_author_image_array' => '',
                                        'wp_rem_cs_var_testimonial_author_address' => '',
                                        'wp_rem_cs_var_testimonial_background_image_array' => '',
                                        'wp_rem_cs_var_testimonial_link' => '',
                                    );
                                    foreach ( $defaults as $key => $values ) {
                                        if ( isset($testimonial['atts'][$key]) ) {
                                            $$key = $testimonial['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }
                                    $wp_rem_cs_var_testimonial_author = isset($wp_rem_cs_var_testimonial_author) ? $wp_rem_cs_var_testimonial_author : '';
                                    $wp_rem_cs_var_testimonial_author_image_array = isset($wp_rem_cs_var_testimonial_author_image_array) ? $wp_rem_cs_var_testimonial_author_image_array : '';
                                    $wp_rem_cs_var_testimonial_background_image_array = isset($wp_rem_cs_var_testimonial_background_image_array) ? $wp_rem_cs_var_testimonial_background_image_array : '';
                                    $wp_rem_cs_var_testimonial_author_address = isset($wp_rem_cs_var_testimonial_author_address) ? $wp_rem_cs_var_testimonial_author_address : '';
                                    $wp_rem_cs_var_testimonial_content = isset($wp_rem_cs_var_testimonial_content) ? $wp_rem_cs_var_testimonial_content : '';
                                    $wp_rem_cs_var_testimonial_link = isset($wp_rem_cs_var_testimonial_link) ? $wp_rem_cs_var_testimonial_link : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tabs_remove')); ?></a>
                                        </header>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_text'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_text_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_testimonial_content),
                                                'cust_id' => '',
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'cust_name' => 'wp_rem_cs_var_testimonial_content[]',
                                                'return' => true,
                                                'classes' => '',
                                                'wp_rem_cs_editor' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_author'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_author_hint'),
                                            'echo' => true,
                                            'classes' => 'txtfield',
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_testimonial_author),
                                                'cust_id' => '',
                                                'cust_name' => 'wp_rem_cs_var_testimonial_author[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_address'),
                                            'desc' => '',
                                            'echo' => true,
                                            'classes' => 'txtfield',
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_testimonial_author_address),
                                                'cust_id' => '',
                                                'cust_name' => 'wp_rem_cs_var_testimonial_author_address[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                        $bg_hide_string = '';
                                        if ( $wp_rem_cs_var_testimonial_view == 'modern' || $wp_rem_cs_var_testimonial_view == 'advance' || $wp_rem_cs_var_testimonial_view == 'advance-v1' ) {
                                            $bg_hide_string = 'style="display:none;"';
                                        }
                                        $wp_rem_cs_opt_array = array(
                                            'std' => esc_url($wp_rem_cs_var_testimonial_background_image_array),
                                            'id' => 'testimonial_background_image',
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_image_background'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_image_background_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'main_wraper' => true,
                                            'main_wraper_class' => 'bg_dynamic_fields_' . intval($rand_num),
                                            'main_wraper_extra' => $bg_hide_string,
                                            'prefix' => '',
                                            'field_params' => array(
                                                'std' => esc_url($wp_rem_cs_var_testimonial_background_image_array),
                                                'id' => 'testimonial_background_image',
                                                'return' => true,
                                                'array' => true,
                                                'array_txt' => false,
                                                'prefix' => '',
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'std' => esc_url($wp_rem_cs_var_testimonial_author_image_array),
                                            'id' => 'testimonial_author_image',
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_image'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_image_hint'),
                                            'echo' => true,
                                            'array' => true,
                                            'prefix' => '',
                                            'field_params' => array(
                                                'std' => esc_url($wp_rem_cs_var_testimonial_author_image_array),
                                                'id' => 'testimonial_author_image',
                                                'return' => true,
                                                'array' => true,
                                                'array_txt' => false,
                                                'prefix' => '',
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                                        $url_hide_string = ' style="display:none;"';
                                        if ( $wp_rem_cs_var_testimonial_view == 'modern' || $wp_rem_cs_var_testimonial_view == 'advance' || $wp_rem_cs_var_testimonial_view == 'advance-v1' ) {
                                            $url_hide_string = ' style="display:block;"';
                                        }
                                        echo '<div class="url_dynamic_fields_' . intval($rand_num) . '"' . $url_hide_string . ' >';
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_link'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_link_hint'),
                                            'echo' => true,
                                            'classes' => 'txtfield',
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_testimonial_link),
                                                'cust_id' => '',
                                                'cust_name' => 'wp_rem_cs_var_testimonial_link[]',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
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
                                'std' => wp_rem_cs_allow_special_char($testimonial_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'testimonial_num[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('testimonial', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_add_testimonial')); ?></a> </li>
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
                                        'std' => 'testimonial',
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
                                            'cust_id' => 'testimonial_save' . $wp_rem_cs_counter,
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'cust_type' => 'button',
                                            'classes' => 'cs-wp_rem_cs-admin-btn',
                                            'cust_name' => 'testimonial_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_testimonial', 'wp_rem_cs_var_page_builder_testimonial');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_testimonial_callback') ) {

    /**
     * Save data for testimonial shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_testimonial_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ( $widget_type == "testimonial" || $widget_type == "cs_testimonial" ) {
            $shortcode = $shortcode_item = $shortcode_image_item = '';
            $page_element_size = $data['testimonial_element_size'][$counters['wp_rem_cs_global_counter_testimonial']];
            $current_element_size = $data['testimonial_element_size'][$counters['wp_rem_cs_global_counter_testimonial']];
            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($data['shortcode']['testimonial'][$counters['wp_rem_cs_shortcode_counter_testimonial']]);
                $element_settings = 'testimonial_element_size="' . $current_element_size . '"';
                $reg = '/testimonial_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_testimonial'] ++;
            } else {
                if ( isset($data['testimonial_num'][$counters['wp_rem_cs_counter_testimonial']]) && $data['testimonial_num'][$counters['wp_rem_cs_counter_testimonial']] > 0 ) {

                    for ( $i = 1; $i <= $data['testimonial_num'][$counters['wp_rem_cs_counter_testimonial']]; $i ++ ) {
                        $shortcode_item .= '[testimonial_item ';
                        if ( isset($data['wp_rem_cs_var_testimonial_author_address'][$counters['wp_rem_cs_counter_testimonial_node']]) && $data['wp_rem_cs_var_testimonial_author_address'][$counters['wp_rem_cs_counter_testimonial_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_testimonial_author_address="' . htmlspecialchars($data['wp_rem_cs_var_testimonial_author_address'][$counters['wp_rem_cs_counter_testimonial_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_testimonial_author'][$counters['wp_rem_cs_counter_testimonial_node']]) && $data['wp_rem_cs_var_testimonial_author'][$counters['wp_rem_cs_counter_testimonial_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_testimonial_author="' . htmlspecialchars($data['wp_rem_cs_var_testimonial_author'][$counters['wp_rem_cs_counter_testimonial_node']], ENT_QUOTES) . '" ';
                        }

                        if ( isset($data['wp_rem_cs_var_testimonial_author_image_array'][$counters['wp_rem_cs_counter_testimonial_node']]) && $data['wp_rem_cs_var_testimonial_author_image_array'][$counters['wp_rem_cs_counter_testimonial_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_testimonial_author_image_array="' . $data['wp_rem_cs_var_testimonial_author_image_array'][$counters['wp_rem_cs_counter_testimonial_node']] . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_testimonial_background_image_array'][$counters['wp_rem_cs_counter_testimonial_node']]) && $data['wp_rem_cs_var_testimonial_background_image_array'][$counters['wp_rem_cs_counter_testimonial_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_testimonial_background_image_array="' . $data['wp_rem_cs_var_testimonial_background_image_array'][$counters['wp_rem_cs_counter_testimonial_node']] . '" ';
                        }
                        if ( isset($data['wp_rem_cs_var_testimonial_link'][$counters['wp_rem_cs_counter_testimonial_node']]) && $data['wp_rem_cs_var_testimonial_link'][$counters['wp_rem_cs_counter_testimonial_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_testimonial_link="' . htmlspecialchars($data['wp_rem_cs_var_testimonial_link'][$counters['wp_rem_cs_counter_testimonial_node']], ENT_QUOTES) . '" ';
                        }
                        $shortcode_item .= ']';
                        if ( isset($data['wp_rem_cs_var_testimonial_content'][$counters['wp_rem_cs_counter_testimonial_node']]) && $data['wp_rem_cs_var_testimonial_content'][$counters['wp_rem_cs_counter_testimonial_node']] != '' ) {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_testimonial_content'][$counters['wp_rem_cs_counter_testimonial_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/testimonial_item]';

                        $counters['wp_rem_cs_counter_testimonial_node'] ++;
                    }
                }
                $section_title = '';
                if ( isset($data['wp_rem_cs_var_testimonial_title'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_cs_var_testimonial_title'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_testimonial_title="' . htmlspecialchars($data['wp_rem_cs_var_testimonial_title'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_testimonial_align'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_var_testimonial_align'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_var_testimonial_align="' . htmlspecialchars($data['wp_rem_var_testimonial_align'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_testimonial_subtitle'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_cs_var_testimonial_subtitle'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_testimonial_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_testimonial_subtitle'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_testimonial_view'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_cs_var_testimonial_view'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_testimonial_view="' . htmlspecialchars($data['wp_rem_cs_var_testimonial_view'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_author_color'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_cs_var_author_color'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_author_color="' . htmlspecialchars($data['wp_rem_cs_var_author_color'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_heading_color'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_cs_var_heading_color'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_heading_color="' . htmlspecialchars($data['wp_rem_cs_var_heading_color'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_var_text_color'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_cs_var_text_color'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_text_color="' . htmlspecialchars($data['wp_rem_cs_var_text_color'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }

                if ( isset($data['wp_rem_cs_var_position_color'][$counters['wp_rem_cs_counter_testimonial']]) && $data['wp_rem_cs_var_position_color'][$counters['wp_rem_cs_counter_testimonial']] != '' ) {
                    $section_title .= 'wp_rem_cs_var_position_color="' . htmlspecialchars($data['wp_rem_cs_var_position_color'][$counters['wp_rem_cs_counter_testimonial']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'testimonial_element_size="' . htmlspecialchars($data['testimonial_element_size'][$counters['wp_rem_cs_global_counter_testimonial']]) . '"';
                $shortcode = '[wp_rem_cs_testimonial ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_image_item . $shortcode_item . '[/wp_rem_cs_testimonial]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_testimonial'] ++;
            }
            $counters['wp_rem_cs_global_counter_testimonial'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_testimonial', 'wp_rem_cs_save_page_builder_data_testimonial_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_testimonial_callback') ) {

    /**
     * Populate testimonial shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_testimonial_callback($counters) {
        $counters['wp_rem_cs_counter_testimonial'] = 0;
        $counters['wp_rem_cs_counter_testimonial_node'] = 0;
        $counters['wp_rem_cs_shortcode_counter_testimonial'] = 0;
        $counters['wp_rem_cs_global_counter_testimonial'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_testimonial_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_testimonial_callback') ) {

    /**
     * Populate testimonial shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_testimonial_callback($shortcode_array) {
        $shortcode_array['testimonial'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_testimonial'),
            'name' => 'testimonial',
            'icon' => 'icon-comments-o',
            'categories' => 'loops',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_testimonial_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_testimonial_callback') ) {

    /**
     * Populate testimonial shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_testimonial_callback($element_list) {
        $element_list['testimonial'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_testimonial');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_testimonial_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_sub_element_ui_testimonial_callback') ) {

    /**
     * Render UI for sub element in testimonial settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_testimonial_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];
        if ( $type == 'testimonial' ) {
            $rand_id = rand(324335, 9234299);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_testimonial')); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove')); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_testimonial_text'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_text_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'cust_name' => 'wp_rem_cs_var_testimonial_content[]',
                        'return' => true,
                        'classes' => '',
                        'wp_rem_cs_editor' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_author'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_author_hint'),
                    'echo' => true,
                    'classes' => 'txtfield',
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_testimonial_author[]',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_address'),
                    'desc' => '',
                    // 'hint_text' => wp_rem_cs_var_theme_text_srt( 'wp_rem_cs_var_testimonial_field_author_hint' ),
                    'echo' => true,
                    'classes' => 'txtfield',
                    'field_params' => array(
                        'std' => '',
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_testimonial_author_address[]',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                ?>
                <script>
                    $view = jQuery('#wp_rem_cs_var_testimonial_view').val();
                    if ($view == 'modern' || $view == 'advance') {
                        jQuery('.bg_dynamic_fields').hide();
                    } else {
                        jQuery('.bg_dynamic_fields').show();
                    }
                </script>
                <?php
                $wp_rem_cs_opt_array = array(
                    'std' => '',
                    'id' => 'testimonial_background_image',
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_image_background'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_testimonial_field_image_background_hint'),
                    'echo' => true,
                    'array' => true,
                    'main_wraper' => true,
                    'main_wraper_class' => 'bg_dynamic_fields',
                    'prefix' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => 'testimonial_background_image',
                        'return' => true,
                        'array' => true,
                        'array_txt' => false,
                        'prefix' => '',
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'std' => '',
                    'id' => 'testimonial_author_image',
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'prefix' => '',
                    'field_params' => array(
                        'std' => '',
                        'id' => 'testimonial_author_image',
                        'return' => true,
                        'array' => true,
                        'array_txt' => false,
                        'prefix' => '',
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                ?>
            </div>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_testimonial_callback');
}