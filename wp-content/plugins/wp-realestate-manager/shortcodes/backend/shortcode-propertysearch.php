<?php
/**
 * Shortcode Name : wp_rem_propertysearch
 *
 * @package	wp_rem_cs 
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_wp_rem_propertysearch') ) {

    function wp_rem_cs_var_page_builder_wp_rem_propertysearch($die = 0) {
        global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
        if ( function_exists('wp_rem_cs_shortcode_names') ) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $wp_rem_cs_PREFIX = 'wp_rem_propertysearch';
            $wp_rem_cs_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
                $wp_rem_cs_POSTID = '';
                $shortcode_element_id = '';
            } else {
                $wp_rem_cs_POSTID = isset($_POST['POSTID']) ? $_POST['POSTID'] : '';
                $shortcode_element_id = isset($_POST['shortcode_element_id']) ? $_POST['shortcode_element_id'] : '';
                $shortcode_str = stripslashes($shortcode_element_id);
                $parseObject = new ShortcodeParse();
                $wp_rem_cs_output = $parseObject->wp_rem_cs_shortcodes($wp_rem_cs_output, $shortcode_str, true, $wp_rem_cs_PREFIX);
            }
            $defaults = array(
                'propertysearch_title' => '',
                'propertysearch_subtitle' => '',
                'propertysearch_alignment' => '',
                'propertysearch_layout_bg' => '',
                'element_title_color' => '',
                'propertysearch_layout_heading_color' => '',
                'propertysearch_title_field_switch' => '',
                'propertysearch_property_type_field_switch' => '',
                'propertysearch_location_field_switch' => '',
                'propertysearch_price_field_switch' => '',
                'propertysearch_advance_filter_switch' => '',
                'propertysearch_categories_field_switch' => '',
                'advance_link' => '',
                'popup_link_text' => '',
                'propertysearch_view' => 'fancy',
                'wp_rem_search_label_color' => '',
                'search_background_color' => '',
                'propertysearch_price_type_switch' => '',
            );
            $defaults = apply_filters('wp_rem_propertysearch_shortcode_admin_default_attributes', $defaults);
            if ( isset($wp_rem_cs_output['0']['atts']) ) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if ( isset($wp_rem_cs_output['0']['content']) ) {
                $help_text_popup = $wp_rem_cs_output['0']['content'];
            } else {
                $help_text_popup = '';
            }
            $wp_rem_propertysearch_element_size = '100';
            foreach ( $defaults as $key => $values ) {
                if ( isset($atts[$key]) ) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_wp_rem_propertysearch';
            $coloumn_class = 'column_' . $wp_rem_propertysearch_element_size;
            if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $property_rand_id = rand(4444, 99999);
            wp_rem_cs_var_date_picker();
            ?>

            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="wp_rem_propertysearch" data="<?php echo wp_rem_cs_element_size_data_array_index($wp_rem_propertysearch_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $wp_rem_propertysearch_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_propertysearch {{attributes}}]{{content}}[/wp_rem_propertysearch]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo wp_rem_plugin_text_srt('wp_rem_property_search_options'); ?></h5>
                        <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js($name . $wp_rem_cs_counter) ?>','<?php echo esc_js($filter_element); ?>')" class="cs-btnclose">
                            <i class="icon-cross"></i>
                        </a>
                    </div>
                    <div class="cs-pbwp-content">
                        <div class="cs-wrapp-clone cs-shortcode-wrapp">
                            <?php
                            if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                                wp_rem_cs_shortcode_element_size();
                            }

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_title'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_title),
                                    'id' => 'propertysearch_title',
                                    'cust_name' => 'propertysearch_title[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_sub_title'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_sub_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_subtitle),
                                    'id' => 'propertysearch_subtitle',
                                    'cust_name' => 'propertysearch_subtitle[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_title_align'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_title_align_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_alignment),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_alignment[]',
                                    'return' => true,
                                    'options' => array(
                                        'align-left' => wp_rem_plugin_text_srt('wp_rem_align_left'),
                                        'align-right' => wp_rem_plugin_text_srt('wp_rem_align_right'),
                                        'align-center' => wp_rem_plugin_text_srt('wp_rem_align_center'),
                                    ),
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_search_element_title_colorrr'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($element_title_color),
                                    'cust_name' => 'element_title_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $propertysearch_views = array(
                                'fancy' => wp_rem_plugin_text_srt('wp_rem_element_view_fancy'),
                                'fancy_v2' => wp_rem_plugin_text_srt('wp_rem_element_view_fancy_v2'),
                                'fancy_v3' => wp_rem_plugin_text_srt('wp_rem_element_view_fancy_v3'),
                                'classic' => wp_rem_plugin_text_srt('wp_rem_shortcode_classic'),
                                'list' => wp_rem_plugin_text_srt('wp_rem_element_view_list'),
                                'modern' => wp_rem_plugin_text_srt('wp_rem_element_view_modernnn'),
                                'modern_v2' => wp_rem_plugin_text_srt('wp_rem_search_element_style_modern_v2'),
                                'modern_v3' => wp_rem_plugin_text_srt('wp_rem_search_element_style_modern_v3'),
                                'simple' => wp_rem_plugin_text_srt('wp_rem_element_view_simplee'),
                                'advance' => wp_rem_plugin_text_srt('wp_rem_element_view_advance'),
                            );
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_view'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_view_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_view),
                                    'id' => 'propertysearch_view' . $property_rand_id . '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_view[]',
                                    'return' => true,
                                    'options' => $propertysearch_views
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);


                            $fancy_v2_view_fields = 'none';
                            if ( isset($propertysearch_view) && ($propertysearch_view == 'fancy_v2' || $propertysearch_view == 'modern_v2' || $propertysearch_view == 'fancy_v3' || $propertysearch_view == 'modern_v3') ) {
                                $fancy_v2_view_fields = 'block';
                            }
                            echo '<div id="search_background_color_field' . $property_rand_id . '" style="display:' . $fancy_v2_view_fields . ';">';
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_search_element_background_colorrr'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($search_background_color),
                                    'cust_name' => 'search_background_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            echo '</div>';
                            $modern_view_fields = 'none';
                            if ( isset($propertysearch_view) && $propertysearch_view == 'modern' ) {
                                $modern_view_fields = 'block';
                            }

                            $simple_view_fields = 'block';
                            if ( isset($propertysearch_view) && ($propertysearch_view == 'simple' || $propertysearch_view == 'advance') ) {
                                $simple_view_fields = 'none';
                            }

                            echo '<div id="search_label_color' . $property_rand_id . '" style="display:' . $modern_view_fields . ';">';

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_search_view_label_color'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_property_search_view_label_color_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($wp_rem_search_label_color),
                                    'id' => 'search_label_color' . $property_rand_id . '',
                                    'cust_name' => 'wp_rem_search_label_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            echo '</div>';



                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_map_search_keyword'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_map_search_keyword_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_title_field_switch),
                                    'cust_id' => '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_title_field_switch[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_map_search_property_type'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_map_search_property_type_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_property_type_field_switch),
                                    'cust_id' => '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_property_type_field_switch[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            echo '<div id="search_simple_dynamic' . $property_rand_id . '" style="display:' . $simple_view_fields . ';">';

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_map_search_location'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_map_search_location_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_location_field_switch),
                                    'cust_id' => '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_location_field_switch[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_map_search_categories'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_map_search_categories_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_categories_field_switch),
                                    'cust_id' => '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_categories_field_switch[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $property_price_type_field_display = 'none';
                            if ( isset($propertysearch_view) && $propertysearch_view == 'modern_v2' ) {
                                $property_price_type_field_display = 'block';
                            }
                            echo '<div id="property_price_type_field_' . $property_rand_id . '" style="display:' . $property_price_type_field_display . ';">';
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_search_property_price_type'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_property_search_property_price_type_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_price_type_switch),
                                    'cust_id' => '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_price_type_switch[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            echo '</div>';

                            $property_price_field_display = 'block';
                            if ( isset($propertysearch_view) && $propertysearch_view == 'fancy_v3' ) {
                                $property_price_field_display = 'none';
                            }
                            echo '<div id="property_price_field_' . $property_rand_id . '" style="display:' . $property_price_field_display . ';">';
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_search_property_price'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_property_search_property_price_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_price_field_switch),
                                    'cust_id' => '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_price_field_switch[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            echo '</div>';

                            $advanc_search_field_display = 'block';
                            if ( isset($propertysearch_view) && ($propertysearch_view == 'modern_v2' || $propertysearch_view == 'fancy_v3' || $propertysearch_view == 'modern_v3') ) {
                                $advanc_search_field_display = 'none';
                            }
                            echo '<div id="advanc_search_field_' . $property_rand_id . '" style="display:' . $advanc_search_field_display . ';">';
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_search_advance_filter'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_property_search_advance_filter_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($propertysearch_advance_filter_switch),
                                    'cust_id' => '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'propertysearch_advance_filter_switch[]',
                                    'cust_id' => 'propertysearch_advance_filter_switch' . $property_rand_id,
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            echo '</div>';

                            echo '</div>';
                            $fancy_view_fields = 'none';
                            if ( isset($propertysearch_view) && $propertysearch_view == 'fancy' ) {
                                $fancy_view_fields = 'block';
                            }
                            echo '<div id="fancy_view_fields_' . $property_rand_id . '" style="display:' . $fancy_view_fields . ';">';
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_search_poup_link_text'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($popup_link_text),
                                    'id' => 'popup_link_text',
                                    'cust_name' => 'popup_link_text[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_search_poup_help_text'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($help_text_popup),
                                    'id' => 'help_text_popup',
                                    'wp_rem_editor' => true,
                                    'cust_name' => 'help_text_popup[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
                            echo '</div>';
                            ?>
                            <script type="text/javascript">
                                var property_rand_id = "<?php echo esc_html($property_rand_id); ?>";
                                jQuery(document).on('change', '#propertysearch_advance_filter_switch' + property_rand_id + '', function () {
                                    if (this.value == 'yes') {
                                        jQuery('#advance_link_' + property_rand_id + '').show();
                                    } else {
                                        jQuery('#advance_link_' + property_rand_id + '').hide();
                                    }
                                });
                                jQuery(document).on('change', '#wp_rem_propertysearch_view' + property_rand_id + '', function () {

                                    jQuery('#property_price_field_' + property_rand_id + '').show();
                                    jQuery('#property_price_type_field_' + property_rand_id + '').show();
                                    jQuery('#advanc_search_field_' + property_rand_id + '').show();

                                    if (this.value == 'fancy') {
                                        jQuery('#fancy_view_fields_' + property_rand_id + '').show();
                                    } else {
                                        jQuery('#fancy_view_fields_' + property_rand_id + '').hide();
                                    }
                                    if (this.value == 'modern') {
                                        jQuery('#search_label_color' + property_rand_id + '').show();
                                    } else {
                                        jQuery('#search_label_color' + property_rand_id + '').hide();
                                    }

                                    if (this.value == 'simple' || this.value == 'advance') {
                                        jQuery('#search_simple_dynamic' + property_rand_id + '').hide();
                                    } else {
                                        jQuery('#search_simple_dynamic' + property_rand_id + '').show();
                                    }

                                    if (this.value == 'fancy_v2' || this.value == 'modern_v2' || this.value == 'fancy_v3' || this.value == 'modern_v3') {
                                        jQuery('#search_background_color_field' + property_rand_id + '').show();
                                    } else {
                                        jQuery('#search_background_color_field' + property_rand_id + '').hide();
                                    }
                                    if (this.value == 'modern_v2' || this.value == 'modern_v3') {
                                        jQuery('#advanc_search_field_' + property_rand_id + '').hide();
                                    }
                                    if (this.value == 'fancy_v3') {
                                        jQuery('#property_price_field_' + property_rand_id + '').hide();
                                        jQuery('#property_price_type_field_' + property_rand_id + '').hide();
                                        jQuery('#advanc_search_field_' + property_rand_id + '').hide();
                                    }
                                });
                                jQuery(document).ready(function () {
                                    var advance_val = jQuery('#propertysearch_advance_filter_switch' + property_rand_id + '').val();
                                    if (advance_val == 'yes') {
                                        jQuery('#advance_link_' + property_rand_id + '').show();
                                    } else {
                                        jQuery('#advance_link_' + property_rand_id + '').hide();
                                    }
                                });
                            </script>
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => absint($property_rand_id),
                                'id' => '',
                                'cust_id' => 'propertysearch_counter',
                                'cust_name' => 'propertysearch_counter[]',
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                        <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo wp_rem_plugin_text_srt('wp_rem_insert'); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>

                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => 'wp_rem_propertysearch',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                'cust_id' => 'wp_rem_cs_orderby' . $wp_rem_cs_counter,
                                'cust_name' => 'wp_rem_cs_orderby[]',
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            $wp_rem_cs_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rem_plugin_text_srt('wp_rem_save'),
                                    'cust_id' => 'wp_rem_propertysearch_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'cust_name' => 'wp_rem_propertysearch_save',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        }
                        ?>
                    </div>
                </div>
                <script type="text/javascript">


                    jQuery(document).ready(function ($) {
                        if (jQuery('.chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width').length != '') {
                            var config = {
                                '.chosen-select': {width: "100%"},
                                '.chosen-select-deselect': {allow_single_deselect: true},
                                '.chosen-select-no-single': {disable_search_threshold: 10, width: "100%", search_contains: true},
                                '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                                '.chosen-select-width': {width: "95%"}
                            }
                            for (var selector in config) {
                                jQuery(selector).chosen(config[selector]);
                            }
                        }

                    });

                    popup_over();

                </script>
            </div>

            <?php
        }
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_wp_rem_propertysearch', 'wp_rem_cs_var_page_builder_wp_rem_propertysearch');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_wp_rem_propertysearch_callback') ) {

    /**
     * Save data for wp_rem_propertysearch shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_wp_rem_propertysearch_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ( $widget_type == "wp_rem_propertysearch" || $widget_type == "cs_wp_rem_propertysearch" ) {
            $wp_rem_cs_bareber_wp_rem_propertysearch = '';

            $page_element_size = $data['wp_rem_propertysearch_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_propertysearch']];
            $current_element_size = $data['wp_rem_propertysearch_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_propertysearch']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes(( $data['shortcode']['wp_rem_propertysearch'][$counters['wp_rem_cs_shortcode_counter_wp_rem_propertysearch']]));

                $element_settings = 'wp_rem_propertysearch_element_size="' . $current_element_size . '"';
                $reg = '/wp_rem_propertysearch_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_wp_rem_propertysearch'] ++;
            } else {

                $element_settings = 'wp_rem_propertysearch_element_size="' . htmlspecialchars($data['wp_rem_propertysearch_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_propertysearch']]) . '"';
                $wp_rem_cs_bareber_wp_rem_propertysearch = '[wp_rem_propertysearch ' . $element_settings . ' ';
                if ( isset($data['propertysearch_title'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_title'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_title="' . htmlspecialchars($data['propertysearch_title'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_alignment'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_alignment'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_alignment="' . htmlspecialchars($data['propertysearch_alignment'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['search_background_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['search_background_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'search_background_color="' . htmlspecialchars($data['search_background_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_subtitle'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_subtitle'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_subtitle="' . htmlspecialchars($data['propertysearch_subtitle'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['element_title_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['element_title_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'element_title_color="' . htmlspecialchars($data['element_title_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_search_label_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['wp_rem_search_label_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'wp_rem_search_label_color="' . htmlspecialchars($data['wp_rem_search_label_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_layout_bg'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_layout_bg'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_layout_bg="' . htmlspecialchars($data['propertysearch_layout_bg'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_layout_heading_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_layout_heading_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_layout_heading_color="' . htmlspecialchars($data['propertysearch_layout_heading_color'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_title_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_title_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_title_field_switch="' . htmlspecialchars($data['propertysearch_title_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_property_type_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_property_type_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_property_type_field_switch="' . htmlspecialchars($data['propertysearch_property_type_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_location_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_location_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_location_field_switch="' . htmlspecialchars($data['propertysearch_location_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_price_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_price_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_price_field_switch="' . htmlspecialchars($data['propertysearch_price_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_categories_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_categories_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_categories_field_switch="' . htmlspecialchars($data['propertysearch_categories_field_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }

                if ( isset($data['propertysearch_price_type_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_price_type_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_price_type_switch="' . htmlspecialchars($data['propertysearch_price_type_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_advance_filter_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_advance_filter_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_advance_filter_switch="' . htmlspecialchars($data['propertysearch_advance_filter_switch'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['advance_link'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['advance_link'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'advance_link="' . htmlspecialchars($data['advance_link'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['popup_link_text'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['popup_link_text'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'popup_link_text="' . htmlspecialchars($data['popup_link_text'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['propertysearch_view'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_view'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_view="' . htmlspecialchars($data['propertysearch_view'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }

                // saving admin field using filter for add on
                $wp_rem_cs_bareber_wp_rem_propertysearch = apply_filters('wp_rem_save_propertysearch_shortcode_admin_fields', $wp_rem_cs_bareber_wp_rem_propertysearch, $_POST, $counters['wp_rem_cs_counter_wp_rem_propertysearch']);
                if ( isset($data['propertysearch_counter'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['propertysearch_counter'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= 'propertysearch_counter="' . htmlspecialchars($data['propertysearch_counter'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_bareber_wp_rem_propertysearch .= ']';
                if ( isset($data['help_text_popup'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']]) && $data['help_text_popup'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_propertysearch .= htmlspecialchars($data['help_text_popup'][$counters['wp_rem_cs_counter_wp_rem_propertysearch']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_bareber_wp_rem_propertysearch .= '[/wp_rem_propertysearch]';
                $shortcode_data .= $wp_rem_cs_bareber_wp_rem_propertysearch;
                $counters['wp_rem_cs_counter_wp_rem_propertysearch'] ++;
            }
            $counters['wp_rem_cs_global_counter_wp_rem_propertysearch'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_wp_rem_propertysearch', 'wp_rem_cs_save_page_builder_data_wp_rem_propertysearch_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_wp_rem_propertysearch_callback') ) {

    /**
     * Populate wp_rem_propertysearch shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_wp_rem_propertysearch_callback($counters) {
        $counters['wp_rem_cs_global_counter_wp_rem_propertysearch'] = 0;
        $counters['wp_rem_cs_shortcode_counter_wp_rem_propertysearch'] = 0;
        $counters['wp_rem_cs_counter_wp_rem_propertysearch'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_wp_rem_propertysearch_callback');
}



if ( ! function_exists('wp_rem_cs_element_list_populate_wp_rem_propertysearch_callback') ) {

    /**
     * Populate wp_rem_propertysearch shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_wp_rem_propertysearch_callback($element_list) {
        $element_list['wp_rem_propertysearch'] = wp_rem_plugin_text_srt('wp_rem_property_search_heading');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_wp_rem_propertysearch_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_wp_rem_propertysearch_callback') ) {

    /**
     * Populate wp_rem_propertysearch shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_wp_rem_propertysearch_callback($shortcode_array) {
        $shortcode_array['wp_rem_propertysearch'] = array(
            'title' => wp_rem_plugin_text_srt('wp_rem_property_search_heading'),
            'name' => 'wp_rem_propertysearch',
            'icon' => 'icon-search',
            'categories' => 'typography',
        );

        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_wp_rem_propertysearch_callback');
}
