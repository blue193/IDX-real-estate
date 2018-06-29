<?php
/**
 * Shortcode Name : wp_rem_properties_slider
 *
 * @package	wp_rem_cs 
 */
if (!function_exists('wp_rem_cs_var_page_builder_wp_rem_properties_slider')) {

    function wp_rem_cs_var_page_builder_wp_rem_properties_slider($die = 0) {
        global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
        if (function_exists('wp_rem_cs_shortcode_names')) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $wp_rem_cs_PREFIX = 'wp_rem_properties_slider';
            $wp_rem_cs_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            if (isset($_POST['action']) && !isset($_POST['shortcode_element_id'])) {
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
                'properties_slider_alignment' => '',
				'properties_title_limit' => '20',
                'property_type' => '',
                'property_sort_by' => 'recent',
                'property_featured' => 'all',
                'property_location' => '',
				'property_no_custom_fields' => '3',
				'posts_per_page' => '10',
            );
            $defaults = apply_filters('wp_rem_properties_shortcode_admin_default_attributes', $defaults);
            if (isset($wp_rem_cs_output['0']['atts'])) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if (isset($wp_rem_cs_output['0']['content'])) {
                $wp_rem_properties_slider_column_text = $wp_rem_cs_output['0']['content'];
            } else {
                $wp_rem_properties_slider_column_text = '';
            }
            $wp_rem_properties_slider_element_size = '100';
            foreach ($defaults as $key => $values) {
                if (isset($atts[$key])) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_wp_rem_properties_slider';
            $coloumn_class = 'column_' . $wp_rem_properties_slider_element_size;
            if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $property_rand_id = rand(4444, 99999);
            wp_rem_cs_var_date_picker();
            $property_views = array(
                'grid' => 'Grid',
                'list' => 'List',
                'fancy' => 'Fancy',
                'map' => 'Map',
            );
            ?>

            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="wp_rem_properties_slider" data="<?php echo wp_rem_cs_element_size_data_array_index($wp_rem_properties_slider_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $wp_rem_properties_slider_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_properties_slider {{attributes}}]{{content}}[/wp_rem_properties_slider]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo wp_rem_plugin_text_srt('wp_rem_property_slider_options'); ?></h5>
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

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_title'),
                                'desc' => '',
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
                                    'std' => esc_attr($properties_slider_alignment),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'properties_slider_alignment[]',
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
							
							$wp_rem_opt_array = array(
								'name' => wp_rem_plugin_text_srt( 'wp_rem_shortcode_properties_title_length' ),
								'desc' => '',
								'label_desc' => '',
								'echo' => true,
								'field_params' => array(
									'std' => esc_attr( $properties_title_limit ),
									'id' => 'properties_title_limit',
									'cust_name' => 'properties_title_limit[]',
									'return' => true,
								),
							);
							$wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_sort_by'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_sort_by),
                                    'id' => 'property_sort_by[]',
                                    'cust_name' => 'property_sort_by[]',
                                    'classes' => 'chosen-select-no-single',
                                    'return' => true,
                                    'options' => array(
                                        'recent' => wp_rem_plugin_text_srt('wp_rem_member_members_recent'),
                                        'alphabetical' => wp_rem_plugin_text_srt('wp_rem_member_members_alphabetical'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

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

                            $wp_rem_cs_opt_array = array(
                                'std' => absint($property_rand_id),
                                'id' => '',
                                'cust_id' => 'property_counter',
                                'cust_name' => 'property_counter[]',
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);
							
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

                            do_action('wp_rem_compare_properties_element_field', $atts);
							
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
                        <?php if (isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode') { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>', '<?php echo esc_js($filter_element); ?>')" ><?php echo wp_rem_plugin_text_srt('wp_rem_insert'); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                        <?php } else { ?>

                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => 'wp_rem_properties_slider',
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
                                    'cust_id' => 'wp_rem_properties_slider_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn save_property_locations_' . $property_rand_id . '',
                                    'cust_name' => 'wp_rem_properties_slider_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_wp_rem_properties_slider', 'wp_rem_cs_var_page_builder_wp_rem_properties_slider');
}

if (!function_exists('wp_rem_cs_save_page_builder_data_wp_rem_properties_slider_callback')) {

    /**
     * Save data for wp_rem_properties_slider shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_wp_rem_properties_slider_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ($widget_type == "wp_rem_properties_slider" || $widget_type == "cs_wp_rem_properties_slider") {
            $wp_rem_cs_bareber_wp_rem_properties_slider = '';

            $page_element_size = $data['wp_rem_properties_slider_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_properties_slider']];
            $current_element_size = $data['wp_rem_properties_slider_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_properties_slider']];

            if (isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode') {
                $shortcode_str = stripslashes(( $data['shortcode']['wp_rem_properties_slider'][$counters['wp_rem_cs_shortcode_counter_wp_rem_properties_slider']]));

                $element_settings = 'wp_rem_properties_slider_element_size="' . $current_element_size . '"';
                $reg = '/wp_rem_properties_slider_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_wp_rem_properties_slider'] ++;
            } else {
                $element_settings = 'wp_rem_properties_slider_element_size="' . htmlspecialchars($data['wp_rem_properties_slider_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_properties_slider']]) . '"';
                $wp_rem_cs_bareber_wp_rem_properties_slider = '[wp_rem_properties_slider ' . $element_settings . ' ';
                if (isset($data['properties_title'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['properties_title'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'properties_title="' . htmlspecialchars($data['properties_title'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                if (isset($data['properties_slider_alignment'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['properties_slider_alignment'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'properties_slider_alignment="' . htmlspecialchars($data['properties_slider_alignment'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                if (isset($data['properties_subtitle'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['properties_subtitle'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'properties_subtitle="' . htmlspecialchars($data['properties_subtitle'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_type'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['property_type'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'property_type="' . htmlspecialchars($data['property_type'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
				if (isset($data['properties_title_limit'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['properties_title_limit'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'properties_title_limit="' . htmlspecialchars($data['properties_title_limit'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_sort_by'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['property_sort_by'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'property_sort_by="' . htmlspecialchars($data['property_sort_by'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                // saving admin field using filter for add on
                $wp_rem_cs_bareber_wp_rem_properties_slider = apply_filters('wp_rem_save_properties_shortcode_admin_fields', $wp_rem_cs_bareber_wp_rem_properties_slider, $_POST, $counters['wp_rem_cs_counter_wp_rem_properties_slider']);
                if (isset($data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'property_featured="' . htmlspecialchars($data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_counter'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['property_counter'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'property_counter="' . htmlspecialchars($data['property_counter'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                if (isset($data['property_location'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['property_location'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'property_location="' . htmlspecialchars($data['property_location'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
				if (isset($data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'property_no_custom_fields="' . htmlspecialchars($data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
				if (isset($data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= 'posts_per_page="' . htmlspecialchars($data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_bareber_wp_rem_properties_slider .= ']';
                if (isset($data['wp_rem_properties_slider_column_text'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']]) && $data['wp_rem_properties_slider_column_text'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']] != '') {
                    $wp_rem_cs_bareber_wp_rem_properties_slider .= htmlspecialchars($data['wp_rem_properties_slider_column_text'][$counters['wp_rem_cs_counter_wp_rem_properties_slider']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_bareber_wp_rem_properties_slider .= '[/wp_rem_properties_slider]';
                $shortcode_data .= $wp_rem_cs_bareber_wp_rem_properties_slider;
                $counters['wp_rem_cs_counter_wp_rem_properties_slider'] ++;
            }
            $counters['wp_rem_cs_global_counter_wp_rem_properties_slider'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_wp_rem_properties_slider', 'wp_rem_cs_save_page_builder_data_wp_rem_properties_slider_callback');
}

if (!function_exists('wp_rem_cs_load_shortcode_counters_wp_rem_properties_slider_callback')) {

    /**
     * Populate wp_rem_properties_slider shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_wp_rem_properties_slider_callback($counters) {
        $counters['wp_rem_cs_global_counter_wp_rem_properties_slider'] = 0;
        $counters['wp_rem_cs_shortcode_counter_wp_rem_properties_slider'] = 0;
        $counters['wp_rem_cs_counter_wp_rem_properties_slider'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_wp_rem_properties_slider_callback');
}



if (!function_exists('wp_rem_cs_element_list_populate_wp_rem_properties_slider_callback')) {

    /**
     * Populate wp_rem_properties_slider shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_wp_rem_properties_slider_callback($element_list) {
        $element_list['wp_rem_properties_slider'] = wp_rem_plugin_text_srt('wp_rem_property_slider_heading');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_wp_rem_properties_slider_callback');
}

if (!function_exists('wp_rem_cs_shortcode_names_list_populate_wp_rem_properties_slider_callback')) {

    /**
     * Populate wp_rem_properties_slider shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_wp_rem_properties_slider_callback($shortcode_array) {
        $shortcode_array['wp_rem_properties_slider'] = array(
            'title' => wp_rem_plugin_text_srt('wp_rem_property_slider_heading'),
            'name' => 'wp_rem_properties_slider',
            'icon' => 'icon-gears',
            'categories' => 'typography',
        );

        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_wp_rem_properties_slider_callback');
}
