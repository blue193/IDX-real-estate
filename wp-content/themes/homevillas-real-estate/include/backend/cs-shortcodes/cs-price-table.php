<?php
/*
 *
 * @Shortcode Name : Price Plan
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_page_builder_price_table') ) {

    function wp_rem_cs_var_page_builder_price_table($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;
        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $wp_rem_cs_counter = $_POST['counter'];
        $price_table_num = 0;
        if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
            $POSTID = '';
            $shortcode_element_id = '';
        } else {
            $POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $shortcode_str = stripslashes($shortcode_element_id);
            $PREFIX = 'wp_rem_cs_price_table|price_table_item';
            $parseObject = new ShortcodeParse();
            $output = $parseObject->wp_rem_cs_shortcodes($output, $shortcode_str, true, $PREFIX);
        }
        $defaults = array(
            'column_size' => '1/1',
            'wp_rem_cs_multi_price_table_section_title' => '',
            'wp_rem_cs_multi_price_table_section_subtitle' => '',
            'wp_rem_var_price_table_align' => '',
            'wp_rem_cs_price_table_style' => '',
            'pricing_table_btn_1_txt' => '',
            'pricing_table_btn_1_lnk' => '',
            'pricing_table_btn_2_txt' => '',
            'pricing_table_btn_2_lnk' => '',
            'pricing_table_cmpre_btn_txt' => '',
            'pricing_table_cmpre_btn_lnk' => '',
            'wp_rem_cs_multi_price_col' => '',
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
            $price_table_num = count($atts_content);
        }
        $price_table_element_size = '100';
        foreach ( $defaults as $key => $values ) {
            if ( isset($atts[$key]) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }
        $name = 'wp_rem_cs_var_page_builder_price_table';
        $coloumn_class = 'column_' . $price_table_element_size;
        $wp_rem_cs_multi_price_table_section_title = isset($wp_rem_cs_multi_price_table_section_title) ? $wp_rem_cs_multi_price_table_section_title : '';

        $wp_rem_cs_multi_price_col = isset($wp_rem_cs_multi_price_col) ? $wp_rem_cs_multi_price_col : '';
        if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo wp_rem_cs_allow_special_char($coloumn_class); ?> <?php echo wp_rem_cs_allow_special_char($shortcode_view); ?>" item="price_table" data="<?php echo wp_rem_cs_element_size_data_array_index($price_table_element_size) ?>" >
            <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $price_table_element_size, '', 'comments-o', $type = ''); ?>
            <div class="cs-wrapp-class-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter) ?> <?php echo wp_rem_cs_allow_special_char($shortcode_element); ?>" id="<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>" style="display: none;">
                <div class="cs-heading-area">
                    <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_edit_option')); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo wp_rem_cs_allow_special_char($name . $wp_rem_cs_counter) ?>','<?php echo wp_rem_cs_allow_special_char($filter_element); ?>')" class="cs-btnclose"><i class="icon-cross"></i></a>
                </div>
                <div class="cs-clone-append cs-pbwp-content">
                    <div class="cs-wrapp-tab-box">
                        <div id="shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>" data-shortcode-template="{{child_shortcode}} [/wp_rem_cs_price_table]" data-shortcode-child-template="[price_table_item {{attributes}}] {{content}} [/price_table_item]">
                            <div class="cs-wrapp-clone cs-shortcode-wrapp cs-disable-true cs-pbwp-content" data-template="[wp_rem_cs_price_table {{attributes}}]">
                                <?php
                                if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                                    wp_rem_cs_shortcode_element_size();
                                }
                                $wp_rem_cs_price_table_style = isset($wp_rem_cs_price_table_style) ? $wp_rem_cs_price_table_style : '';
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_multi_price_table_section_title),
                                        'id' => 'wp_rem_cs_multi_price_table_section_title',
                                        'cust_name' => 'wp_rem_cs_multi_price_table_section_title[]',
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
                                        'std' => esc_attr($wp_rem_cs_multi_price_table_section_subtitle),
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_multi_price_table_section_subtitle[]',
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
                                        'std' => $wp_rem_var_price_table_align,
                                        'id' => '',
                                        'cust_id' => 'wp_rem_var_price_table_align',
                                        'cust_name' => 'wp_rem_var_price_table_align[]',
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
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_plan_style'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_plan_style_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => $wp_rem_cs_price_table_style,
                                        'id' => '',
                                        'cust_name' => 'wp_rem_cs_price_table_style[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_plan_style_classic'),
                                            'advance' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_plan_style_advanced'),
											'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_plan_style_modren'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);

                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn1_txt'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn1_txt_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($pricing_table_btn_1_txt),
                                        'id' => 'pricing_table_btn_1_txt',
                                        'cust_name' => 'pricing_table_btn_1_txt[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn1_lnk'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn1_lnk_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($pricing_table_btn_1_lnk),
                                        'id' => 'pricing_table_btn_1_lnk',
                                        'cust_name' => 'pricing_table_btn_1_lnk[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn2_txt'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn2_txt_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($pricing_table_btn_2_txt),
                                        'id' => 'pricing_table_btn_2_txt',
                                        'cust_name' => 'pricing_table_btn_2_txt[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn2_lnk'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_btn2_lnk_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($pricing_table_btn_2_lnk),
                                        'id' => 'pricing_table_btn_2_lnk',
                                        'cust_name' => 'pricing_table_btn_2_lnk[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_cmpre_btn_txt'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_cmpre_btn_txt_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($pricing_table_cmpre_btn_txt),
                                        'id' => 'pricing_table_cmpre_btn_txt',
                                        'cust_name' => 'pricing_table_cmpre_btn_txt[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_cmpre_btn_lnk'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_cmpre_btn_lnk_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($pricing_table_cmpre_btn_lnk),
                                        'id' => 'pricing_table_cmpre_btn_lnk',
                                        'cust_name' => 'pricing_table_cmpre_btn_lnk[]',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_select_col'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_select_col_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($wp_rem_cs_multi_price_col),
                                        'cust_id' => 'wp_rem_cs_multi_price_col',
                                        'cust_name' => 'wp_rem_cs_multi_price_col[]',
                                        'classes' => 'dropdown chosen-select',
                                        'options' => array(
                                            '1' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_one_column'),
                                            '2' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_two_column'),
                                            '3' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_three_column'),
                                            '4' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_four_column'),
                                            '6' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_accordian_six_column'),
                                        ),
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                ?>
                            </div>
                            <?php
                            if ( isset($price_table_num) && $price_table_num <> '' && isset($atts_content) && is_array($atts_content) ) {
                                foreach ( $atts_content as $price_table ) {
                                    $rand_string = rand(1234, 7894563);
                                    $wp_rem_cs_var_price_table_text = $price_table['content'];
                                    $defaults = array(
                                        'wp_rem_cs_price_table_price' => '',
                                        'wp_rem_cs_price_table_text' => '',
                                        'wp_rem_cs_price_table_title_color' => '',
                                        'wp_rem_cs_price_table_currency' => '$',
                                        'wp_rem_cs_price_table_time_duration' => '',
                                        'wp_rem_cs_price_table_button_text' => 'Sign Up',
                                        'wp_rem_cs_price_table_pricing_detail' => '',
                                        'wp_rem_cs_price_table_featured' => '',
                                        'wp_rem_cs_price_table_button_color' => '',
                                        'wp_rem_cs_price_table_button_color_bg' => '',
                                        'wp_rem_cs_price_table_button_column_color' => '',
                                        'wp_rem_cs_price_table_column_bgcolor' => '',
                                        'wp_rem_cs_price_table_button_link' => '',
										'wp_rem_cs_price_table_image_icon' => '',
                                        'wp_rem_cs_var_price_table_image' => '',
										'wp_rem_cs_price_table_icon_box' => '',
										'wp_rem_cs_price_table_icon_box_group' => 'default',
                                        'wp_rem_var_price_table_packages_list' => ''
                                    );
                                    foreach ( $defaults as $key => $values ) {
                                        if ( isset($price_table['atts'][$key]) ) {
                                            $$key = $price_table['atts'][$key];
                                        } else {
                                            $$key = $values;
                                        }
                                    }

                                    $wp_rem_cs_price_table_price = isset($wp_rem_cs_price_table_price) ? $wp_rem_cs_price_table_price : '';
                                    $wp_rem_cs_price_table_text = isset($wp_rem_cs_price_table_text) ? $wp_rem_cs_price_table_text : '';
                                    $wp_rem_cs_price_table_title_color = isset($wp_rem_cs_price_table_title_color) ? $wp_rem_cs_price_table_title_color : '';
                                    $wp_rem_cs_price_table_currency = isset($wp_rem_cs_price_table_currency) ? $wp_rem_cs_price_table_currency : '';
                                    $wp_rem_cs_price_table_time_duration = isset($wp_rem_cs_price_table_time_duration) ? $wp_rem_cs_price_table_time_duration : '';
                                    $wp_rem_cs_price_table_button_text = isset($wp_rem_cs_price_table_button_text) ? $wp_rem_cs_price_table_button_text : '';
                                    $wp_rem_cs_price_table_pricing_detail = isset($wp_rem_cs_price_table_pricing_detail) ? $wp_rem_cs_price_table_pricing_detail : '';
                                    $wp_rem_cs_price_table_featured = isset($wp_rem_cs_price_table_featured) ? $wp_rem_cs_price_table_featured : '';
                                    $wp_rem_cs_price_table_button_color = isset($wp_rem_cs_price_table_button_color) ? $wp_rem_cs_price_table_button_color : '';
                                    $wp_rem_cs_price_table_button_color_bg = isset($wp_rem_cs_price_table_button_color_bg) ? $wp_rem_cs_price_table_button_color_bg : '';
                                    $wp_rem_cs_price_table_button_column_color = isset($wp_rem_cs_price_table_button_column_color) ? $wp_rem_cs_price_table_button_column_color : '';
                                    $wp_rem_cs_price_table_column_bgcolor = isset($wp_rem_cs_price_table_column_bgcolor) ? $wp_rem_cs_price_table_column_bgcolor : '';
                                    $wp_rem_cs_price_table_button_link = isset($wp_rem_cs_price_table_button_link) ? $wp_rem_cs_price_table_button_link : '';
                                    $wp_rem_cs_var_price_table_image = isset($wp_rem_cs_var_price_table_image) ? $wp_rem_cs_var_price_table_image : '';
                                    $wp_rem_var_price_table_packages_list = isset($wp_rem_var_price_table_packages_list) ? $wp_rem_var_price_table_packages_list : '';
                                    ?>
                                    <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content' id="wp_rem_cs_infobox_<?php echo wp_rem_cs_allow_special_char($rand_string); ?>">
                                        <header>
                                            <h4><i class='icon-arrows'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_sc')); ?></h4>
                                            <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_remove')); ?></a>
                                        </header>
                                        <?php
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_title'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_title_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_price_table_text),
                                                'id' => 'wp_rem_cs_price_table_text',
                                                'cust_name' => 'wp_rem_cs_price_table_text[]',
                                                'classes' => '',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
										
										?>
										<script type="text/javascript">
											function price_table_image_icon<?php echo absint($rand_string); ?>($price_table_image_icon_switcher) {
												if ($price_table_image_icon_switcher == 'image') {
													jQuery('.price-table-image-field-<?php echo absint($rand_string); ?>').show();
													jQuery('.wp_rem_cs_price_table_icon_<?php echo absint($rand_string); ?>').hide();
												} else {
													jQuery('.price-table-image-field-<?php echo absint($rand_string); ?>').hide();
													jQuery('.wp_rem_cs_price_table_icon_<?php echo absint($rand_string); ?>').show();
												}
											}

										</script>
										<?php
										$wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_image_icon'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_image_icon_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_price_table_image_icon,
                                                'id' => '',
                                                'cust_name' => 'wp_rem_cs_price_table_image_icon[]',
                                                'classes' => 'chosen-select-no-single',
												'extra_atr' => 'onchange="price_table_image_icon' . $rand_string . '(this.value)"',
                                                'options' => array(
                                                    'image' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field'),
                                                    'icon' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_icon'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
										
										$image_field_display = 'style="display:block;"';
											$icon_field_display = 'style="display:none;"';
										if ($wp_rem_cs_price_table_image_icon == 'icon') {
											$image_field_display = 'style="display:none;"';
											$icon_field_display = 'style="display:block;"';
										}
										echo '<div class="price-table-image-field-'. $rand_string .'" '. $image_field_display .'>';
											$wp_rem_cs_opt_array = array(
												'std' => $wp_rem_cs_var_price_table_image,
												'id' => 'price_table_image_array',
												'main_id' => 'price_table_image_array',
												'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price_image'),
												'desc' => '',
												'hint_text' => '',
												'echo' => true,
												'array' => true,
												'field_params' => array(
													'std' => $wp_rem_cs_var_price_table_image,
													'cust_id' => '',
													'cust_name' => 'wp_rem_cs_var_price_table_image[]',
													'id' => 'price_table_image_array',
													'return' => true,
													'array' => true,
												),
											);
											$wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
										echo '</div>';
										?>
					<div class="form-elements wp_rem_cs_price_table_icon_<?php echo esc_attr($rand_string); ?>" <?php echo $icon_field_display; ?>>
                                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                                <label><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_icon')); ?></label>
                                                <?php
                                                if ( function_exists('wp_rem_cs_var_tooltip_helptext') ) {
                                                    echo wp_rem_cs_var_tooltip_helptext(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_icon_hint'));
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                                <?php echo apply_filters( 'cs_icons_fields', $wp_rem_cs_price_table_icon_box, esc_attr($rand_string), 'wp_rem_cs_price_table_icon_box', $wp_rem_cs_price_table_icon_box_group ); ?>
                                            </div>
                                        </div>
										<?php
										
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price_color'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_price_table_title_color),
                                                'id' => 'wp_rem_cs_price_table_title_color',
                                                'cust_name' => 'wp_rem_cs_price_table_title_color[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_price_table_price),
                                                'id' => 'wp_rem_cs_price_table_price',
                                                'cust_name' => 'wp_rem_cs_price_table_price[]',
                                                'classes' => 'txtfield',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_currency'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_currency_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_price_table_currency),
                                                'id' => 'wp_rem_cs_price_table_currency',
                                                'cust_name' => 'wp_rem_cs_price_table_currency[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $arg_packages = array(
                                            'post_type' => 'packages',
                                            'posts_per_page' => "-1",
                                            'post_status' => 'publish',
                                        );
                                        $packages_array = array( '' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_package_list_select') );
                                        $the_query = new WP_Query($arg_packages);
                                        if ( $the_query->have_posts() ) :
                                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                                $packages_array[get_the_ID()] = get_the_title();
                                            endwhile;
                                        endif;
                                        wp_reset_postdata();
                                        $wp_rem_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_package_list'),
                                            'desc' => '',
                                            'hint_text' => '',
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_var_price_table_packages_list,
                                                'id' => '',
                                                'cust_id' => 'wp_rem_var_price_table_packages_list',
                                                'cust_name' => 'wp_rem_var_price_table_packages_list[]',
                                                'classes' => 'chosen-select-no-single select-medium',
                                                'options' => $packages_array,
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);

                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_time'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_time_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_price_table_time_duration),
                                                'id' => 'wp_rem_cs_price_table_time_duration',
                                                'cust_name' => 'wp_rem_cs_price_table_time_duration[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_link'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_link_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_url($wp_rem_cs_price_table_button_link),
                                                'id' => 'wp_rem_cs_price_table_button_link',
                                                'cust_name' => 'wp_rem_cs_price_table_button_link[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_text'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_text_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_price_table_button_text),
                                                'id' => 'wp_rem_cs_price_table_button_text',
                                                'cust_name' => 'wp_rem_cs_price_table_button_text[]',
                                                'classes' => 'txtfield  input-small',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_color'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_price_table_button_color),
                                                'id' => 'wp_rem_cs_price_table_button_color',
                                                'cust_name' => 'wp_rem_cs_price_table_button_color[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_bg_color'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_bg_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_html($wp_rem_cs_price_table_button_color_bg),
                                                'id' => 'wp_rem_cs_price_table_button_color_bg',
                                                'cust_name' => 'wp_rem_cs_price_table_button_color_bg[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_featured'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_featured_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => $wp_rem_cs_price_table_featured,
                                                'id' => '',
                                                'cust_name' => 'wp_rem_cs_price_table_featured[]',
                                                'classes' => 'dropdown chosen-select',
                                                'options' => array(
                                                    'Yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
                                                    'No' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
                                                ),
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_price_table_description'),
                                            'desc' => '',
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_var_price_table_text),
                                                'cust_id' => '',
                                                'cust_name' => 'wp_rem_cs_var_price_table_text[]',
                                                'return' => true,
                                                'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                                'classes' => '',
                                                'wp_rem_cs_editor' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                        $wp_rem_cs_opt_array = array(
                                            'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_column_color'),
                                            'desc' => '',
                                            'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_column_color_hint'),
                                            'echo' => true,
                                            'field_params' => array(
                                                'std' => esc_attr($wp_rem_cs_price_table_column_bgcolor),
                                                'id' => 'wp_rem_cs_price_table_column_bgcolor',
                                                'cust_name' => 'wp_rem_cs_price_table_column_bgcolor[]',
                                                'classes' => 'bg_color',
                                                'return' => true,
                                            ),
                                        );
                                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
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
                                'std' => wp_rem_cs_allow_special_char($price_table_num),
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => 'fieldCounter',
                                'extra_atr' => '',
                                'cust_id' => '',
                                'cust_name' => 'price_table_num[]',
                                'return' => true,
                                'required' => false
                            );
                            echo wp_rem_cs_allow_special_char($wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array));
                            ?>
                        </div>
                        <div class="wrapptabbox cs-pbwp-content cs-zero-padding">
                            <div class="opt-conts">
                                <ul class="form-elements">
                                    <li class="to-field"> <a href="javascript:void(0);" class="add_servicesss cs-main-btn" onclick="wp_rem_cs_shortcode_element_ajax_call('price_table', 'shortcode-item-<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_counter); ?>', '<?php echo admin_url('admin-ajax.php'); ?>')"><i class="icon-plus-circle"></i><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_add')); ?></a> </li>
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
                                        'std' => 'price_table',
                                        'id' => '',
                                        'before' => '',
                                        'after' => '',
                                        'classes' => '',
                                        'extra_atr' => '',
                                        'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
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
                                            'cust_id' => 'price_table_save' . $wp_rem_cs_counter,
                                            'cust_type' => 'button',
                                            'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                            'classes' => 'cs-wp_rem_cs-admin-btn',
                                            'cust_name' => 'price_table_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_price_table', 'wp_rem_cs_var_page_builder_price_table');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_price_table_callback') ) {

    /**
     * Save data for price table shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_price_table_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ( $widget_type == "price_table" || $widget_type == "cs_price_table" ) {
            $shortcode = $shortcode_item = '';

            $page_element_size = $data['price_table_element_size'][$counters['wp_rem_cs_global_counter_price_table']];
            $current_element_size = $data['price_table_element_size'][$counters['wp_rem_cs_global_counter_price_table']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($data['shortcode']['price_table'][$counters['wp_rem_cs_shortcode_counter_price_table']]);

                $element_settings = 'price_table_element_size="' . $current_element_size . '"';
                $reg = '/price_table_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_price_table'] ++;
            } else {
                if ( isset($data['price_table_num'][$counters['wp_rem_cs_counter_price_table']]) && $data['price_table_num'][$counters['wp_rem_cs_counter_price_table']] > 0 ) {
                    for ( $i = 1; $i <= $data['price_table_num'][$counters['wp_rem_cs_counter_price_table']]; $i ++ ) {
                        $shortcode_item .= '[price_table_item ';
                        if ( isset($data['wp_rem_cs_price_table_text'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_text'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_text="' . htmlspecialchars($data['wp_rem_cs_price_table_text'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }

                        if ( isset($data['wp_rem_cs_var_price_table_image'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_var_price_table_image'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_var_price_table_image="' . htmlspecialchars($data['wp_rem_cs_var_price_table_image'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }

                        if ( isset($data['wp_rem_cs_price_table_title_color'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_title_color'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_title_color="' . $data['wp_rem_cs_price_table_title_color'][$counters['wp_rem_cs_counter_price_table_node']] . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_price'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_price'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_price="' . $data['wp_rem_cs_price_table_price'][$counters['wp_rem_cs_counter_price_table_node']] . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_currency'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_currency'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_currency="' . htmlspecialchars($data['wp_rem_cs_price_table_currency'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_time_duration'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_time_duration'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_time_duration="' . htmlspecialchars($data['wp_rem_cs_price_table_time_duration'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_button_link'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_button_link'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_button_link="' . htmlspecialchars($data['wp_rem_cs_price_table_button_link'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_button_text'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_button_text'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_button_text="' . htmlspecialchars($data['wp_rem_cs_price_table_button_text'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_button_color'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_button_color'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_button_color="' . htmlspecialchars($data['wp_rem_cs_price_table_button_color'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_button_color_bg'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_button_color_bg'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_button_color_bg="' . htmlspecialchars($data['wp_rem_cs_price_table_button_color_bg'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_featured'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_featured'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_featured="' . htmlspecialchars($data['wp_rem_cs_price_table_featured'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_column_bgcolor'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_column_bgcolor'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_column_bgcolor="' . htmlspecialchars($data['wp_rem_cs_price_table_column_bgcolor'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_var_price_table_packages_list'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_var_price_table_packages_list'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_var_price_table_packages_list="' . htmlspecialchars($data['wp_rem_var_price_table_packages_list'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_image_icon'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_image_icon'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_image_icon="' . htmlspecialchars($data['wp_rem_cs_price_table_image_icon'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_icon_box'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_icon_box'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_icon_box="' . htmlspecialchars($data['wp_rem_cs_price_table_icon_box'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
                        if ( isset($data['wp_rem_cs_price_table_icon_box_group'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_price_table_icon_box_group'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= 'wp_rem_cs_price_table_icon_box_group="' . htmlspecialchars($data['wp_rem_cs_price_table_icon_box_group'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES) . '" ';
                        }
						
                        $shortcode_item .= ']';
                        if ( isset($data['wp_rem_cs_var_price_table_text'][$counters['wp_rem_cs_counter_price_table_node']]) && $data['wp_rem_cs_var_price_table_text'][$counters['wp_rem_cs_counter_price_table_node']] != '' ) {
                            $shortcode_item .= htmlspecialchars($data['wp_rem_cs_var_price_table_text'][$counters['wp_rem_cs_counter_price_table_node']], ENT_QUOTES);
                        }
                        $shortcode_item .= '[/price_table_item]';
                        $counters['wp_rem_cs_counter_price_table_node'] ++;
                    }
                }
                $section_title = '';
                if ( isset($data['wp_rem_cs_multi_price_table_section_title'][$counters['wp_rem_cs_counter_price_table']]) && $data['wp_rem_cs_multi_price_table_section_title'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'wp_rem_cs_multi_price_table_section_title="' . htmlspecialchars($data['wp_rem_cs_multi_price_table_section_title'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_var_price_table_align'][$counters['wp_rem_cs_counter_price_table']]) && $data['wp_rem_var_price_table_align'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'wp_rem_var_price_table_align="' . htmlspecialchars($data['wp_rem_var_price_table_align'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_multi_price_table_section_subtitle'][$counters['wp_rem_cs_counter_price_table']]) && $data['wp_rem_cs_multi_price_table_section_subtitle'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'wp_rem_cs_multi_price_table_section_subtitle="' . htmlspecialchars($data['wp_rem_cs_multi_price_table_section_subtitle'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_cs_price_table_style'][$counters['wp_rem_cs_counter_price_table']]) && $data['wp_rem_cs_price_table_style'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'wp_rem_cs_price_table_style="' . htmlspecialchars($data['wp_rem_cs_price_table_style'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }

                if ( isset($data['pricing_table_btn_1_txt'][$counters['wp_rem_cs_counter_price_table']]) && $data['pricing_table_btn_1_txt'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'pricing_table_btn_1_txt="' . htmlspecialchars($data['pricing_table_btn_1_txt'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['pricing_table_btn_1_lnk'][$counters['wp_rem_cs_counter_price_table']]) && $data['pricing_table_btn_1_lnk'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'pricing_table_btn_1_lnk="' . htmlspecialchars($data['pricing_table_btn_1_lnk'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['pricing_table_btn_2_txt'][$counters['wp_rem_cs_counter_price_table']]) && $data['pricing_table_btn_2_txt'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'pricing_table_btn_2_txt="' . htmlspecialchars($data['pricing_table_btn_2_txt'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['pricing_table_btn_2_lnk'][$counters['wp_rem_cs_counter_price_table']]) && $data['pricing_table_btn_2_lnk'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'pricing_table_btn_2_lnk="' . htmlspecialchars($data['pricing_table_btn_2_lnk'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['pricing_table_cmpre_btn_txt'][$counters['wp_rem_cs_counter_price_table']]) && $data['pricing_table_cmpre_btn_txt'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'pricing_table_cmpre_btn_txt="' . htmlspecialchars($data['pricing_table_cmpre_btn_txt'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['pricing_table_cmpre_btn_lnk'][$counters['wp_rem_cs_counter_price_table']]) && $data['pricing_table_cmpre_btn_lnk'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'pricing_table_cmpre_btn_lnk="' . htmlspecialchars($data['pricing_table_cmpre_btn_lnk'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }

                if ( isset($data['wp_rem_cs_multi_price_col'][$counters['wp_rem_cs_counter_price_table']]) && $data['wp_rem_cs_multi_price_col'][$counters['wp_rem_cs_counter_price_table']] != '' ) {
                    $section_title .= 'wp_rem_cs_multi_price_col="' . htmlspecialchars($data['wp_rem_cs_multi_price_col'][$counters['wp_rem_cs_counter_price_table']], ENT_QUOTES) . '" ';
                }
                $element_settings = 'price_table_element_size="' . htmlspecialchars($data['price_table_element_size'][$counters['wp_rem_cs_global_counter_price_table']]) . '"';
                $shortcode = '[wp_rem_cs_price_table ' . $element_settings . ' ' . $section_title . ' ]' . $shortcode_item . '[/wp_rem_cs_price_table]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_price_table'] ++;
            }
            $counters['wp_rem_cs_global_counter_price_table'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_price_table', 'wp_rem_cs_save_page_builder_data_price_table_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_price_table_callback') ) {

    /**
     * Populate price table shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_price_table_callback($counters) {
        $counters['wp_rem_cs_counter_price_table'] = 0;
        $counters['wp_rem_cs_counter_price_table_node'] = 0;
        $counters['wp_rem_cs_shortcode_counter_price_table'] = 0;
        $counters['wp_rem_cs_global_counter_price_table'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_price_table_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_price_table_callback') ) {

    /**
     * Populate price table shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_price_table_callback($shortcode_array) {
        $shortcode_array['price_table'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_price_plan'),
            'name' => 'price_table',
            'icon' => 'icon-briefcase',
            'categories' => 'contentblocks',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_price_table_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_price_table_callback') ) {

    /**
     * Populate price table shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_price_table_callback($element_list) {
        $element_list['price_table'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_price_plan');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_price_table_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_sub_element_ui_price_table_callback') ) {

    /**
     * Render UI for sub element in price table settings.
     *
     * @param	array $args
     */
    function wp_rem_cs_shortcode_sub_element_ui_price_table_callback($args) {
        $type = $args['type'];
        $wp_rem_cs_var_html_fields = $args['html_fields'];
        if ( $type == 'price_table' ) {
            $rand_id = rand(1234, 7894563);
            ?>
            <div class='cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content'  id="wp_rem_cs_infobox_<?php echo intval($rand_id); ?>">
                <header>
                    <h4><i class='icon-arrows'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_price_plan'); ?></h4>
                    <a href='#' class='deleteit_node'><i class='icon-minus-circle'></i><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_remove'); ?></a>
                </header>
                <?php
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_title'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_title_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_price_table_text),
                        'id' => 'wp_rem_cs_price_table_text',
                        'cust_name' => 'wp_rem_cs_price_table_text[]',
                        'classes' => '',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $wp_rem_cs_opt_array = array(
                    'std' => $wp_rem_cs_var_price_table_image,
                    'id' => 'price_table_image_array',
                    'main_id' => 'price_table_image_array',
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_image_hint'),
                    'echo' => true,
                    'array' => true,
                    'field_params' => array(
                        'std' => $wp_rem_cs_var_price_table_image,
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_price_table_image[]',
                        'id' => 'price_table_image_array',
                        'return' => true,
                        'array' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price_color'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_html($wp_rem_cs_price_table_title_color),
                        'id' => 'wp_rem_cs_price_table_title_color',
                        'cust_name' => 'wp_rem_cs_price_table_title_color[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_price_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_price_table_price),
                        'id' => 'wp_rem_cs_price_table_price',
                        'cust_name' => 'wp_rem_cs_price_table_price[]',
                        'classes' => 'txtfield',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_currency'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_currency_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_price_table_currency),
                        'id' => 'wp_rem_cs_price_table_currency',
                        'cust_name' => 'wp_rem_cs_price_table_currency[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                $arg_packages = array(
                    'post_type' => 'packages',
                    'posts_per_page' => "-1",
                    'post_status' => 'publish',
                );
                $packages_array = array( '' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_package_list_select') );
                $the_query = new WP_Query($arg_packages);
                if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $packages_array[get_the_ID()] = get_the_title();
                    endwhile;
                endif;
                wp_reset_postdata();
                $wp_rem_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_package_list'),
                    'desc' => '',
                    'hint_text' => '',
                    'echo' => true,
                    'field_params' => array(
                        'std' => '',
                        'id' => '',
                        'cust_id' => 'wp_rem_var_price_table_packages_list',
                        'cust_name' => 'wp_rem_var_price_table_packages_list[]',
                        'classes' => 'chosen-select-no-single select-medium',
                        'options' => $packages_array,
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);

                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_time'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_time_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_price_table_time_duration),
                        'id' => 'wp_rem_cs_price_table_time_duration',
                        'cust_name' => 'wp_rem_cs_price_table_time_duration[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_link'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_link_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_url($wp_rem_cs_price_table_button_link),
                        'id' => 'wp_rem_cs_price_table_button_link',
                        'cust_name' => 'wp_rem_cs_price_table_button_link[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_text'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_text_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_html($wp_rem_cs_price_table_button_text),
                        'id' => 'wp_rem_cs_price_table_button_text',
                        'cust_name' => 'wp_rem_cs_price_table_button_text[]',
                        'classes' => 'txtfield  input-small',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_color'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_html($wp_rem_cs_price_table_button_color),
                        'id' => 'wp_rem_cs_price_table_button_color',
                        'cust_name' => 'wp_rem_cs_price_table_button_color[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_bg_color'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_button_bg_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_html($wp_rem_cs_price_table_button_color_bg),
                        'id' => 'wp_rem_cs_price_table_button_color_bg',
                        'cust_name' => 'wp_rem_cs_price_table_button_color_bg[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_featured'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_featured_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => $wp_rem_cs_price_table_featured,
                        'id' => '',
                        'cust_name' => 'wp_rem_cs_price_table_featured[]',
                        'classes' => 'dropdown chosen-select',
                        'options' => array(
                            'Yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yes'),
                            'No' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no'),
                        ),
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_price_table_description'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_price_table_description_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_var_price_table_text),
                        'cust_id' => '',
                        'cust_name' => 'wp_rem_cs_var_price_table_text[]',
                        'return' => true,
                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                        'classes' => '',
                        'wp_rem_cs_editor' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                $wp_rem_cs_opt_array = array(
                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_column_color'),
                    'desc' => '',
                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_price_table_column_color_hint'),
                    'echo' => true,
                    'field_params' => array(
                        'std' => esc_attr($wp_rem_cs_price_table_column_bgcolor),
                        'id' => 'wp_rem_cs_price_table_column_bgcolor',
                        'cust_name' => 'wp_rem_cs_price_table_column_bgcolor[]',
                        'classes' => 'bg_color',
                        'return' => true,
                    ),
                );
                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                ?>
            </div>
            <?php
        }
    }

    add_action('wp_rem_cs_shortcode_sub_element_ui', 'wp_rem_cs_shortcode_sub_element_ui_price_table_callback');
}
