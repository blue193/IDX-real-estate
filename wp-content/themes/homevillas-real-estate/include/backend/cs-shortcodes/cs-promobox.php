<?php
/*
 *
 * @File : Image Frame 
 * @retrun
 *
 */

if (!function_exists('wp_rem_cs_var_page_builder_promobox')) {

    function wp_rem_cs_var_page_builder_promobox($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $coloumn_class, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;

        if (function_exists('wp_rem_cs_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $PREFIX = 'wp_rem_cs_promobox';
            $wp_rem_cs_counter = isset($_POST['wp_rem_cs_counter']) ? $_POST['wp_rem_cs_counter'] : '';
            $wp_rem_cs_counter = ($wp_rem_cs_counter == '') ? $_POST['counter'] : $wp_rem_cs_counter;
            if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
                $POSTID = '';
                $shortcode_element_id = '';
            } else {
                $POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
                $shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
                $shortcode_str = stripslashes($shortcode_element_id);
                $parseObject = new ShortcodeParse();
                $wp_rem_cs_output = $parseObject->wp_rem_cs_shortcodes($wp_rem_cs_output, $shortcode_str, true, $PREFIX);
            }
            $defaults = array(
                'wp_rem_cs_var_column' => '',
                'wp_rem_cs_var_image_section_title' => '',
                'wp_rem_cs_var_image_section_subtitle' => '',
                'wp_rem_var_promobox_align' => '',
                'wp_rem_cs_promobox_select_background' => '',
                'wp_rem_cs_var_promobox_button_title' => '',
                'wp_rem_cs_var_frame_image_url_array' => '',
                'wp_rem_cs_var_frame_promo_image_url_array' => '',
                'wp_rem_cs_var_app_store_image_url_array' => '',
                'wp_rem_cs_promobox_button_bg_color' => '',
                'wp_rem_cs_promobox_bg_color' => '',
                'wp_rem_cs_var_promobox_title' => '',
                'wp_rem_cs_var_promobox_button_url' => '',
                'wp_rem_cs_promobox_title_color' => '',
                'wp_rem_cs_var_promo_box_view' => '',
                'wp_rem_cs_var_app_store_url' => '',
                'wp_rem_cs_var_google_store_image_url_array' => '',
                'wp_rem_cs_var_google_store_url' => '',
                'wp_rem_cs_var_email' => '',
            );
            if (isset($wp_rem_cs_output['0']['atts'])) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rem_cs_output['0']['content'])) {
                $wp_rem_cs_var_image_description = $wp_rem_cs_output['0']['content'];
            } else {
                $wp_rem_cs_var_image_description = '';
            }
            $promobox_element_size = '25';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_promobox';
            $coloumn_class = 'column_' . $promobox_element_size;
            $wp_rem_cs_var_image_section_title = isset($wp_rem_cs_var_image_section_title) ? $wp_rem_cs_var_image_section_title : '';
            $wp_rem_cs_var_promobox_button_title = isset($wp_rem_cs_var_promobox_button_title) ? $wp_rem_cs_var_promobox_button_title : '';
            $wp_rem_cs_promobox_select_background = isset($wp_rem_cs_promobox_select_background) ? $wp_rem_cs_promobox_select_background : '';
            $wp_rem_cs_var_frame_image_url_array = isset($wp_rem_cs_var_frame_image_url_array) ? $wp_rem_cs_var_frame_image_url_array : '';
            $wp_rem_cs_promobox_button_bg_color = isset($wp_rem_cs_promobox_button_bg_color) ? $wp_rem_cs_promobox_button_bg_color : '';
            $wp_rem_cs_promobox_bg_color = isset($wp_rem_cs_promobox_bg_color) ? $wp_rem_cs_promobox_bg_color : '';
            $wp_rem_cs_var_promobox_title = isset($wp_rem_cs_var_promobox_title) ? $wp_rem_cs_var_promobox_title : '';
            $wp_rem_cs_var_promobox_button_url = isset($wp_rem_cs_var_promobox_button_url) ? $wp_rem_cs_var_promobox_button_url : '';
            $wp_rem_cs_promobox_title_color = isset($wp_rem_cs_promobox_title_color) ? $wp_rem_cs_promobox_title_color : '';
            $wp_rem_cs_var_frame_promo_image_url_array = isset($wp_rem_cs_var_frame_promo_image_url_array) ? $wp_rem_cs_var_frame_promo_image_url_array : '';
            $wp_rem_cs_var_app_store_image_url_array = isset($wp_rem_cs_var_app_store_image_url_array) ? $wp_rem_cs_var_app_store_image_url_array : '';
            $wp_rem_cs_var_app_store_url = isset($wp_rem_cs_var_app_store_url) ? $wp_rem_cs_var_app_store_url : '';
            $wp_rem_cs_var_google_store_image_url_array = isset($wp_rem_cs_var_google_store_image_url_array) ? $wp_rem_cs_var_google_store_image_url_array : '';
            $wp_rem_cs_var_google_store_url = isset($wp_rem_cs_var_google_store_url) ? $wp_rem_cs_var_google_store_url : '';
            $wp_rem_cs_var_email = isset($wp_rem_cs_var_email) ? $wp_rem_cs_var_email : '';
            $wp_rem_cs_var_promo_box_view = isset($wp_rem_cs_var_promo_box_view) ? $wp_rem_cs_var_promo_box_view : '';
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $strings = new wp_rem_cs_theme_all_strings;
            $strings->wp_rem_cs_short_code_strings();
            ?>
            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="promobox" data="<?php echo wp_rem_cs_element_size_data_array_index($promobox_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $promobox_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_promobox {{attributes}}]{{content}}[/wp_rem_cs_promobox]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promo_box_options')); ?></h5>
                        <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
                            <i class="icon-cross"></i>
                        </a>
                    </div>
                    <div class="cs-pbwp-content">
                        <div class="cs-wrapp-clone cs-shortcode-wrapp">
                            <?php
                            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                                wp_rem_cs_shortcode_element_size();
                            }
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_name'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_image_field_name_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_image_section_title),
                                    'cust_id' => 'wp_rem_cs_var_image_section_title' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_image_section_title[]',
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
                                    'std' => esc_attr($wp_rem_cs_var_image_section_subtitle),
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_image_section_subtitle[]',
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
                                    'std' => $wp_rem_var_promobox_align,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_var_promobox_align',
                                    'cust_name' => 'wp_rem_var_promobox_align[]',
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

                            
                            //background image
                            $wp_rem_cs_opt_array = array(
                                'std' => esc_url($wp_rem_cs_var_frame_image_url_array),
                                'id' => 'frame_image_url',
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_image_field_url'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_image_field_url_hint'),
                                'echo' => true,
                                'array' => true,
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => esc_url($wp_rem_cs_var_frame_image_url_array),
                                    'id' => 'frame_image_url',
                                    'return' => true,
                                    'array' => true,
                                    'array_txt' => false,
                                    'prefix' => '',
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                            //background color
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_bg_color_field'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_bg_color_field_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($wp_rem_cs_promobox_bg_color),
                                    'id' => 'wp_rem_cs_promobox_bg_color',
                                    'cust_name' => 'wp_rem_cs_promobox_bg_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            //image
                            $wp_rem_cs_opt_array = array(
                                'std' => esc_url($wp_rem_cs_var_frame_promo_image_url_array),
                                'id' => 'frame_promo_image_url',
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_select_image'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_select_image_hint'),
                                'echo' => true,
                                'array' => true,
                                'prefix' => '',
                                'field_params' => array(
                                    'std' => esc_url($wp_rem_cs_var_frame_promo_image_url_array),
                                    'id' => 'frame_promo_image_url',
                                    'return' => true,
                                    'array' => true,
                                    'array_txt' => false,
                                    'prefix' => '',
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_title'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_promobox_title),
                                    'cust_id' => '',
                                    'classes' => 'txtfield',
                                    'cust_name' => 'wp_rem_cs_var_promobox_title[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                            //promobox title color
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_title_color'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_title_color_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($wp_rem_cs_promobox_title_color),
                                    'id' => 'wp_rem_cs_promobox_title_color',
                                    'cust_name' => 'wp_rem_cs_promobox_title_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promo_box_styles'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promo_box_styles_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_cs_var_promo_box_view,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_cs_var_promo_box_view',
                                    'cust_name' => 'wp_rem_cs_var_promo_box_view[]',
                                    'classes' => 'wp_rem_cs_var_promo_box_view chosen-select select-medium view_class',
                                    'options' => array(
                                        'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promo_box_style_classic'),
                                        'fancy' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promo_box_style_fancy'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_opt_array);
                            $show_div = '';
                            if (isset($wp_rem_cs_var_promo_box_view) && $wp_rem_cs_var_promo_box_view == 'classic') {
                                $show_div = 'block';
                            } else {
                                $show_div = 'none';
                            }
                            if (empty($wp_rem_cs_var_promo_box_view)) {
                                $show_div = 'block';
                            }
                            ?>
                            <script type="text/javascript">
                                jQuery('.view_class').change(function ($) {
                                    var value = jQuery(this).val();
                                    var parentNode = jQuery(this).parent().parent().parent();
                                    if (value == 'fancy') {
                                        parentNode.find("#order_div").hide();
                                    } else {
                                        parentNode.find("#order_div").show();
                                    }
                                }
                                );
                            </script>
                            <div id="order_div" style="display:<?php echo esc_html($show_div) ?>;">
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'std' => esc_url($wp_rem_cs_var_app_store_image_url_array),
                                    'id' => 'app_store_image_url',
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_app_store_image'),
                                    'desc' => '',
                                    'echo' => true,
                                    'array' => true,
                                    'prefix' => '',
                                    'field_params' => array(
                                        'std' => esc_url($wp_rem_cs_var_app_store_image_url_array),
                                        'id' => 'app_store_image_url',
                                        'return' => true,
                                        'array' => true,
                                        'array_txt' => false,
                                        'prefix' => '',
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_app_store_url'),
                                    'desc' => '',
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_app_store_url),
                                        'cust_id' => 'wp_rem_cs_var_app_store_url' . $wp_rem_cs_counter,
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_app_store_url[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'std' => esc_url($wp_rem_cs_var_google_store_image_url_array),
                                    'id' => 'google_store_image_url',
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_google_play'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_google_play_hint'),
                                    'echo' => true,
                                    'array' => true,
                                    'prefix' => '',
                                    'field_params' => array(
                                        'std' => esc_url($wp_rem_cs_var_google_store_image_url_array),
                                        'id' => 'google_store_image_url',
                                        'return' => true,
                                        'array' => true,
                                        'array_txt' => false,
                                        'prefix' => '',
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_google_store_url'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_google_store_url_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_google_store_url),
                                        'cust_id' => 'wp_rem_cs_var_google_store_url' . $wp_rem_cs_counter,
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_google_store_url[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_email'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_email_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_email),
                                        'cust_id' => 'wp_rem_cs_var_email' . $wp_rem_cs_counter,
                                        'classes' => '',
                                        'cust_name' => 'wp_rem_cs_var_email[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                ?>
                            </div>
                                <?php
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_field_desc'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_field_desc_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_textarea($wp_rem_cs_var_image_description),
                                        'cust_id' => 'wp_rem_cs_var_image_description' . $wp_rem_cs_counter,
                                        'classes' => 'textarea',
                                        'cust_name' => 'wp_rem_cs_var_image_description[]',
                                        'return' => true,
                                        'wp_rem_cs_editor' => true,
                                        'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                                //button
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_button_title'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_button_title_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_promobox_button_title),
                                        'cust_id' => '',
                                        'classes' => 'txtfield',
                                        'cust_name' => 'wp_rem_cs_var_promobox_button_title[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                //button bg color
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_button_bg_color'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_button_bg_color_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_html($wp_rem_cs_promobox_button_bg_color),
                                        'id' => 'wp_rem_cs_promobox_button_bg_color',
                                        'cust_name' => 'wp_rem_cs_promobox_button_bg_color[]',
                                        'classes' => 'bg_color',
                                        'return' => true,
                                    ),
                                );

                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                $wp_rem_cs_opt_array = array(
                                    'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_button_url'),
                                    'desc' => '',
                                    'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_promobox_button_url_hint'),
                                    'echo' => true,
                                    'field_params' => array(
                                        'std' => esc_attr($wp_rem_cs_var_promobox_button_url),
                                        'cust_id' => '',
                                        'classes' => 'txtfield',
                                        'cust_name' => 'wp_rem_cs_var_promobox_button_url[]',
                                        'return' => true,
                                    ),
                                );
                                $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                                ?>
                        </div>
                            <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
            <?php } else { ?>

                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => 'promobox',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
                                'cust_name' => 'wp_rem_cs_orderby[]',
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
                                    'cust_id' => 'promobox_save',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'cust_name' => 'promobox_save' . $wp_rem_cs_counter,
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
        }
        if ($die <> 1) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_promobox', 'wp_rem_cs_var_page_builder_promobox');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_promobox_callback')) {

    /**
     * Save data for image frame shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_promobox_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ($widget_type == "promobox" || $widget_type == "cs_promobox") {
            $wp_rem_cs_var_promobox = '';
            $page_element_size = $data['promobox_element_size'][$counters['wp_rem_cs_global_counter_promobox']];
            $current_element_size = $data['promobox_element_size'][$counters['wp_rem_cs_global_counter_promobox']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['promobox'][$counters['wp_rem_cs_shortcode_counter_promobox']]));

                $element_settings = 'promobox_element_size="' . $current_element_size . '"';
                $reg = '/promobox_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_promobox'] ++;
            } else {
                $wp_rem_cs_var_promobox = '[wp_rem_cs_promobox promobox_element_size="' . htmlspecialchars($data['promobox_element_size'][$counters['wp_rem_cs_global_counter_promobox']]) . '" ';
                if (isset($data['wp_rem_cs_var_image_section_title'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_image_section_title'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_image_section_title="' . htmlspecialchars($data['wp_rem_cs_var_image_section_title'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_image_section_subtitle'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_image_section_subtitle'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_image_section_subtitle="' . htmlspecialchars($data['wp_rem_cs_var_image_section_subtitle'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_var_promobox_align'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_var_promobox_align'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_var_promobox_align="' . htmlspecialchars($data['wp_rem_var_promobox_align'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_promobox_title'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_promobox_title'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_promobox_title="' . htmlspecialchars($data['wp_rem_cs_var_promobox_title'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_promobox_title_color'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_promobox_title_color'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_promobox_title_color="' . htmlspecialchars($data['wp_rem_cs_promobox_title_color'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_promobox_select_background'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_promobox_select_background'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_promobox_select_background="' . htmlspecialchars($data['wp_rem_cs_promobox_select_background'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_promobox_button_title'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_promobox_button_title'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_promobox_button_title="' . htmlspecialchars($data['wp_rem_cs_var_promobox_button_title'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_promo_box_view'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_promo_box_view'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_promo_box_view="' . htmlspecialchars($data['wp_rem_cs_var_promo_box_view'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_frame_image_url_array'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_frame_image_url_array'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_frame_image_url_array="' . htmlspecialchars($data['wp_rem_cs_var_frame_image_url_array'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_app_store_image_url_array'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_app_store_image_url_array'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_app_store_image_url_array="' . htmlspecialchars($data['wp_rem_cs_var_app_store_image_url_array'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_app_store_url'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_app_store_url'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_app_store_url="' . htmlspecialchars($data['wp_rem_cs_var_app_store_url'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_google_store_image_url_array'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_google_store_image_url_array'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_google_store_image_url_array="' . htmlspecialchars($data['wp_rem_cs_var_google_store_image_url_array'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_google_store_url'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_google_store_url'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_google_store_url="' . htmlspecialchars($data['wp_rem_cs_var_google_store_url'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_email'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_email'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_email="' . htmlspecialchars($data['wp_rem_cs_var_email'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_frame_promo_image_url_array'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_frame_promo_image_url_array'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_frame_promo_image_url_array="' . htmlspecialchars($data['wp_rem_cs_var_frame_promo_image_url_array'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_promobox_button_bg_color'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_promobox_button_bg_color'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_promobox_button_bg_color="' . htmlspecialchars($data['wp_rem_cs_promobox_button_bg_color'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_var_promobox_button_url'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_promobox_button_url'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_var_promobox_button_url="' . htmlspecialchars($data['wp_rem_cs_var_promobox_button_url'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                if (isset($data['wp_rem_cs_promobox_bg_color'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_promobox_bg_color'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= 'wp_rem_cs_promobox_bg_color="' . htmlspecialchars($data['wp_rem_cs_promobox_bg_color'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_var_promobox .= ']';
                if (isset($data['wp_rem_cs_var_image_description'][$counters['wp_rem_cs_counter_promobox']]) && $data['wp_rem_cs_var_image_description'][$counters['wp_rem_cs_counter_promobox']] != '') {
                    $wp_rem_cs_var_promobox .= htmlspecialchars($data['wp_rem_cs_var_image_description'][$counters['wp_rem_cs_counter_promobox']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_var_promobox .= '[/wp_rem_cs_promobox]';

                $shortcode_data .= $wp_rem_cs_var_promobox;
                $counters['wp_rem_cs_counter_promobox'] ++;
            }
            $counters['wp_rem_cs_global_counter_promobox'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_promobox', 'wp_rem_cs_save_page_builder_data_promobox_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_promobox_callback')) {

    /**
     * Populate image frame shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_promobox_callback($counters) {
        $counters['wp_rem_cs_global_counter_promobox'] = 0;
        $counters['wp_rem_cs_shortcode_counter_promobox'] = 0;
        $counters['wp_rem_cs_counter_promobox'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_promobox_callback');
}
if (!function_exists('wp_rem_cs_shortcode_names_list_populate_promobox_callback')) {

    /**
     * Populate image frame shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_promobox_callback($shortcode_array) {
        $shortcode_array['promobox'] = array(
            'title' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_promobox'),
            'name' => 'promobox',
            'icon' => 'icon-photo',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_promobox_callback');
}

if (!function_exists('wp_rem_cs_element_list_populate_promobox_callback')) {

    /**
     * Populate image frame shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_promobox_callback($element_list) {
        $element_list['promobox'] = wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_promobox');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_promobox_callback');
}