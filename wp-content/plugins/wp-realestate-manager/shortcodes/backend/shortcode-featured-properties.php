<?php
/**
 * Shortcode Name : wp_rem_featured_properties
 *
 * @package	wp_rem_cs 
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_wp_rem_featured_properties') ) {

    function wp_rem_cs_var_page_builder_wp_rem_featured_properties($die = 0) {
        global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
        if ( function_exists('wp_rem_cs_shortcode_names') ) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $wp_rem_cs_PREFIX = 'wp_rem_featured_properties';
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
                'properties_title' => '',
                'properties_subtitle' => '',
                'properties_title_limit' => '20',
                'properties_title_alignment' => '',
                'properties_content_limit' => '100',
                'property_type' => '',
                'property_view' => '',
                'property_featured' => 'no',
                'property_ads_switch' => 'no',
                'property_ads_after_list_count' => '5',
                'property_location' => '',
                'posts_per_page' => '6',
                'property_no_custom_fields' => '3',
            );
            $defaults = apply_filters('wp_rem_properties_shortcode_admin_default_attributes', $defaults);
            if ( isset($wp_rem_cs_output['0']['atts']) ) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if ( isset($wp_rem_cs_output['0']['content']) ) {
                $wp_rem_featured_properties_column_text = $wp_rem_cs_output['0']['content'];
            } else {
                $wp_rem_featured_properties_column_text = '';
            }
            $wp_rem_featured_properties_element_size = '100';
            foreach ( $defaults as $key => $values ) {
                if ( isset($atts[$key]) ) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_wp_rem_featured_properties';
            $coloumn_class = 'column_' . $wp_rem_featured_properties_element_size;
            if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $property_rand_id = rand(4444, 99999);
            wp_rem_cs_var_date_picker();
            $property_views = array(
                'single' => wp_rem_plugin_text_srt('wp_rem_element_view_single_property'),
                'multiple' => wp_rem_plugin_text_srt('wp_rem_element_view_multiple_properties'),
            );
            ?>

            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="wp_rem_featured_properties" data="<?php echo wp_rem_cs_element_size_data_array_index($wp_rem_featured_properties_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $wp_rem_featured_properties_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_featured_properties {{attributes}}]{{content}}[/wp_rem_featured_properties]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo wp_rem_plugin_text_srt('wp_rem_shortcode_featured_properties_options'); ?></h5>
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
                                'label_desc' => '',
								'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($properties_title),
                                    'id' => 'properties_title',
                                    'cust_name' => 'properties_title[]',
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
                                    'std' => esc_attr($properties_subtitle),
                                    'id' => 'properties_subtitle',
                                    'cust_name' => 'properties_subtitle[]',
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
                                    'std' => esc_attr($properties_title_alignment),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'properties_title_alignment[]',
                                    'return' => true,
                                    'options' => array(
                                        'align-left' => wp_rem_plugin_text_srt('wp_rem_align_left'),
                                        'align-right' => wp_rem_plugin_text_srt('wp_rem_align_right'),
                                        'align-center' => wp_rem_plugin_text_srt('wp_rem_align_center'),
                                    ),
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            $wp_rem_post_property_types = new Wp_rem_Post_Property_Types();
                            $property_types_array = $wp_rem_post_property_types->wp_rem_types_array_callback(wp_rem_plugin_text_srt('wp_rem_shortcode_properties_all_types'));
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_types'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_type),
                                    'id' => 'property_type[]',
                                    'classes' => 'chosen-select',
                                    'cust_name' => 'property_type[]',
                                    'return' => true,
                                    'options' => $property_types_array
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            ?>
                            <script type="text/javascript">
                                function property_view<?php echo absint($property_rand_id); ?>($view) {
                                    if ($view == 'single') {
                                        jQuery('.property_content_langth<?php echo absint($property_rand_id); ?>').show();
                                        jQuery('.multiple-properties-fields-<?php echo absint($property_rand_id); ?>').hide();
                                    } else {
                                        jQuery('.property_content_langth<?php echo absint($property_rand_id); ?>').hide();
                                        jQuery('.multiple-properties-fields-<?php echo absint($property_rand_id); ?>').show();
                                    }
                                }
                                function property_ads_count<?php echo absint($property_rand_id); ?>($property_ads_switcher) {
                                    if ($property_ads_switcher == 'no') {
                                        jQuery('.property_count_dynamic_fields<?php echo absint($property_rand_id); ?>').hide();
                                    } else {
                                        jQuery('.property_count_dynamic_fields<?php echo absint($property_rand_id); ?>').show();
                                    }
                                }

                            </script>
                            <?php
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_view'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_view_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_view),
                                    'id' => 'property_view' . $property_rand_id . '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'property_view[]',
                                    'return' => true,
                                    'extra_atr' => 'onchange="property_view' . $property_rand_id . '(this.value)"',
                                    'options' => $property_views
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_title_length'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($properties_title_limit),
                                    'id' => 'properties_title_limit',
                                    'cust_name' => 'properties_title_limit[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            $property_content_display = '';
                            if ( $property_view == 'multiple' ) {
                                $property_content_display = 'style="display:none;"';
                            }
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_content_length'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'property_content_langth' . $property_rand_id . '',
                                'main_wraper_extra' => $property_content_display,
                                'field_params' => array(
                                    'std' => esc_attr($properties_content_limit),
                                    'id' => 'properties_content_limit_' . $property_rand_id,
                                    'cust_name' => 'properties_content_limit[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_property_featured'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_featured),
                                    'id' => 'property_featured[]',
                                    'cust_name' => 'property_featured[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'options' => array(
                                        'all' => wp_rem_plugin_text_srt('wp_rem_options_all'),
                                        'only-featured' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_only_featured'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_number_of_custom_fields'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_no_custom_fields),
                                    'id' => 'property_no_custom_fields',
                                    'cust_name' => 'property_no_custom_fields[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            $multiple_fields_display = '';
                            if ( $property_view == 'single' || $property_view == '' ) {
                                $multiple_fields_display = 'style="display:none;"';
                            }
                            echo '<div class="multiple-properties-fields-' . $property_rand_id . '" ' . $multiple_fields_display . '>';

                            do_action('wp_rem_compare_properties_element_field', $atts);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_ads_switch'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_ads_switch),
                                    'id' => 'property_ads_switch[]',
                                    'cust_name' => 'property_ads_switch[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'extra_atr' => 'onchange="property_ads_count' . $property_rand_id . '(this.value)"',
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $property_count_hide_string = '';
                            if ( $property_ads_switch == 'no' ) {
                                $property_count_hide_string = 'style="display:none;"';
                            }

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_count'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_count_hint'),
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'property_count_dynamic_fields' . $property_rand_id . '',
                                'main_wraper_extra' => $property_count_hide_string,
                                'field_params' => array(
                                    'std' => esc_attr($property_ads_after_list_count),
                                    'id' => 'property_ads_after_list_count',
                                    'cust_name' => 'property_ads_after_list_count[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            ?>
                            <script>
                                jQuery(document).ready(function () {
                                    jQuery(".save_property_locations_<?php echo absint($property_rand_id); ?>").click(function () {
                                        var MY_SELECT = jQuery('#wp_rem_property_locations_<?php echo absint($property_rand_id); ?>').get(0);
                                        var selection = ChosenOrder.getSelectionOrder(MY_SELECT);
                                        var property_location_value = '';
                                        var comma = '';
                                        jQuery(selection).each(function (i) {
                                            property_location_value = property_location_value + comma + selection[i];
                                            comma = ',';
                                        });
                                        jQuery('#property_location_<?php echo absint($property_rand_id); ?>').val(property_location_value);
                                    });

                                });
                            </script>
                            <?php
                            $saved_property_location = $property_location;
                            $property_location_options = array(
                                'country' => wp_rem_plugin_text_srt('wp_rem_options_country'),
                                'state' => wp_rem_plugin_text_srt('wp_rem_options_state'),
                                'city' => wp_rem_plugin_text_srt('wp_rem_options_city'),
                                'town' => wp_rem_plugin_text_srt('wp_rem_options_town'),
                                'address' => wp_rem_plugin_text_srt('wp_rem_options_town_complete_address'),
                            );

                            if ($saved_property_location != '') {
                                $property_locations = explode(',', $saved_property_location);
                                foreach ($property_locations as $property_loc) {
                                    $get_property_locations[$property_loc] = $property_location_options[$property_loc];
                                }
                            }
                            if ($get_property_locations) {
                                $property_location_options = array_unique(array_merge($get_property_locations, $property_location_options));
                            } else {
                                $property_location_options = $property_location_options;
                            }

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_location_filter'),
                                'desc' => '',
                                'label_desc' => '',
                                'multi' => true,
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $saved_property_location,
                                    'id' => 'property_locations_' . $property_rand_id . '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'property_locations[]',
                                    'return' => true,
                                    'options' => $property_location_options,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => $property_location,
                                'cust_id' => 'property_location_' . $property_rand_id . '',
                                'cust_name' => "property_location[]",
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
                            
                            echo '</div>';
                            
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_posts_per_page'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($posts_per_page),
                                    'id' => 'posts_per_page',
                                    'cust_name' => 'posts_per_page[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            
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
                                'std' => 'wp_rem_featured_properties',
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
                                    'cust_id' => 'wp_rem_featured_properties_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn save_property_locations_' . $property_rand_id . '',
                                    'cust_name' => 'wp_rem_featured_properties_save',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);
                        }
                        ?>
                    </div>
                </div>
                <script type="text/javascript">
                    popup_over();

                </script>
            </div>

            <?php
        }
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_wp_rem_featured_properties', 'wp_rem_cs_var_page_builder_wp_rem_featured_properties');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_wp_rem_featured_properties_callback') ) {

    /**
     * Save data for wp_rem_featured_properties shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_wp_rem_featured_properties_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ( $widget_type == "wp_rem_featured_properties" || $widget_type == "cs_wp_rem_featured_properties" ) {
            $wp_rem_featured_properties = '';

            $page_element_size = $data['wp_rem_featured_properties_element_size'][$counters['wp_rem_featured_properties_global_counter']];
            $current_element_size = $data['wp_rem_featured_properties_element_size'][$counters['wp_rem_featured_properties_global_counter']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes(( $data['shortcode']['wp_rem_featured_properties'][$counters['wp_rem_cs_shortcode_counter_wp_rem_featured_properties']]));

                $element_settings = 'wp_rem_featured_properties_element_size="' . $current_element_size . '"';
                $reg = '/wp_rem_featured_properties_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_wp_rem_featured_properties'] ++;
            } else {
                $element_settings = 'wp_rem_featured_properties_element_size="' . htmlspecialchars($data['wp_rem_featured_properties_element_size'][$counters['wp_rem_featured_properties_global_counter']]) . '"';
                $wp_rem_featured_properties = '[wp_rem_featured_properties ' . $element_settings . ' ';
                if ( isset($data['properties_title'][$counters['wp_rem_featured_properties_counter']]) && $data['properties_title'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'properties_title="' . htmlspecialchars($data['properties_title'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['properties_title_alignment'][$counters['wp_rem_featured_properties_counter']]) && $data['properties_title_alignment'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'properties_title_alignment="' . htmlspecialchars($data['properties_title_alignment'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['properties_title_limit'][$counters['wp_rem_featured_properties_counter']]) && $data['properties_title_limit'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'properties_title_limit="' . htmlspecialchars($data['properties_title_limit'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['properties_subtitle'][$counters['wp_rem_featured_properties_counter']]) && $data['properties_subtitle'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'properties_subtitle="' . htmlspecialchars($data['properties_subtitle'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_type'][$counters['wp_rem_featured_properties_counter']]) && $data['property_type'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'property_type="' . htmlspecialchars($data['property_type'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_view'][$counters['wp_rem_featured_properties_counter']]) && $data['property_view'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'property_view="' . htmlspecialchars($data['property_view'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                // saving admin field using filter for add on
                $wp_rem_featured_properties = apply_filters('wp_rem_save_properties_shortcode_admin_fields', $wp_rem_featured_properties, $_POST, $counters['wp_rem_featured_properties_counter']);
                if ( isset($data['property_featured'][$counters['wp_rem_featured_properties_counter']]) && $data['property_featured'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'property_featured="' . htmlspecialchars($data['property_featured'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_no_custom_fields'][$counters['wp_rem_featured_properties_counter']]) && $data['property_no_custom_fields'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'property_no_custom_fields="' . htmlspecialchars($data['property_no_custom_fields'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_ads_switch'][$counters['wp_rem_featured_properties_counter']]) && $data['property_ads_switch'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'property_ads_switch="' . htmlspecialchars($data['property_ads_switch'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_ads_after_list_count'][$counters['wp_rem_featured_properties_counter']]) && $data['property_ads_after_list_count'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'property_ads_after_list_count="' . htmlspecialchars($data['property_ads_after_list_count'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['posts_per_page'][$counters['wp_rem_featured_properties_counter']]) && $data['posts_per_page'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'posts_per_page="' . htmlspecialchars($data['posts_per_page'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_location'][$counters['wp_rem_featured_properties_counter']]) && $data['property_location'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= 'property_location="' . htmlspecialchars($data['property_location'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . '" ';
                }
                $wp_rem_featured_properties .= ']';
                if ( isset($data['wp_rem_featured_properties_column_text'][$counters['wp_rem_featured_properties_counter']]) && $data['wp_rem_featured_properties_column_text'][$counters['wp_rem_featured_properties_counter']] != '' ) {
                    $wp_rem_featured_properties .= htmlspecialchars($data['wp_rem_featured_properties_column_text'][$counters['wp_rem_featured_properties_counter']], ENT_QUOTES) . ' ';
                }
                $wp_rem_featured_properties .= '[/wp_rem_featured_properties]';
                $shortcode_data .= $wp_rem_featured_properties;
                $counters['wp_rem_featured_properties_counter'] ++;
            }
            $counters['wp_rem_featured_properties_global_counter'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_wp_rem_featured_properties', 'wp_rem_cs_save_page_builder_data_wp_rem_featured_properties_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_wp_rem_featured_properties_callback') ) {

    /**
     * Populate wp_rem_featured_properties shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_wp_rem_featured_properties_callback($counters) {
        $counters['wp_rem_featured_properties_global_counter'] = 0;
        $counters['wp_rem_cs_shortcode_counter_wp_rem_featured_properties'] = 0;
        $counters['wp_rem_featured_properties_counter'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_wp_rem_featured_properties_callback');
}



if ( ! function_exists('wp_rem_cs_element_list_populate_wp_rem_featured_properties_callback') ) {

    /**
     * Populate wp_rem_featured_properties shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_wp_rem_featured_properties_callback($element_list) {
        $element_list['wp_rem_featured_properties'] = wp_rem_plugin_text_srt('wp_rem_shortcode_featured_properties_heading');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_wp_rem_featured_properties_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_wp_rem_featured_properties_callback') ) {

    /**
     * Populate wp_rem_featured_properties shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_wp_rem_featured_properties_callback($shortcode_array) {
        $shortcode_array['wp_rem_featured_properties'] = array(
            'title' => wp_rem_plugin_text_srt('wp_rem_shortcode_featured_properties_heading'),
            'name' => 'wp_rem_featured_properties',
            'icon' => 'icon-gears',
            'categories' => 'typography',
        );

        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_wp_rem_featured_properties_callback');
}
