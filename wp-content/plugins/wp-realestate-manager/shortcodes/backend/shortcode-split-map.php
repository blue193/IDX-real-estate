<?php
/**
 * Shortcode Name : wp_rem_split_map
 *
 * @package	wp_rem_cs 
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_wp_rem_split_map') ) {

    function wp_rem_cs_var_page_builder_wp_rem_split_map($die = 0) {
        global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
        if ( function_exists('wp_rem_cs_shortcode_names') ) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $wp_rem_cs_PREFIX = 'wp_rem_split_map';
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
                'split_map_title' => '',
                'split_map_title_limit' => '',
                'split_map_subtitle' => '',
                'split_map_title_alignment' => '',
                'property_type' => '',
                'filter_by_categories' => '',
                'property_topmap' => '',
                'property_map_position' => '',
                'property_map_height' => '',
                'property_view' => '',
                'property_sort_by' => 'no',
                'property_layout_switcher' => 'no',
                'property_layout_switcher_view' => '',
                'property_search_keyword' => 'no',
                'property_top_category' => 'no',
                'property_top_category_count' => '',
                'property_footer' => 'no',
                'property_featured' => 'no',
                'property_ads_switch' => 'no',
                'property_open_house_filter' => 'yes',
                'property_price_filter' => 'yes',
                'property_ads_after_list_count' => '5',
                'property_location' => '',
                'posts_per_page' => '',
                'pagination' => '',
                'search_box' => '',
                'left_filter_count' => '',
                'show_more_property_button_switch' => 'no',
                'show_more_property_button_url' => '',
                'draw_on_map_url' => '',
                'notifications_box' => 'yes',
                'property_no_custom_fields' => '3',
                'wp_rem_property_sidebar' => '',
				'wp_rem_map_position' => '',
				'wp_rem_map_fixed' => '',
            );
            $defaults = apply_filters('wp_rem_properties_shortcode_admin_default_attributes', $defaults);
            if ( isset($wp_rem_cs_output['0']['atts']) ) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if ( isset($wp_rem_cs_output['0']['content']) ) {
                $wp_rem_split_map_column_text = $wp_rem_cs_output['0']['content'];
            } else {
                $wp_rem_split_map_column_text = '';
            }
            $wp_rem_split_map_element_size = '100';
            foreach ( $defaults as $key => $values ) {
                if ( isset($atts[$key]) ) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_wp_rem_split_map';
            $coloumn_class = 'column_' . $wp_rem_split_map_element_size;
            if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $property_rand_id = rand(4444, 99999);
            wp_rem_cs_var_date_picker();
            $property_views = array(
                'grid' => wp_rem_plugin_text_srt('wp_rem_element_view_grid'),
                'list' => wp_rem_plugin_text_srt('wp_rem_element_view_list'),
                'list-modern' => wp_rem_plugin_text_srt('wp_rem_element_view_list_modern'),
                'grid-medern' => wp_rem_plugin_text_srt('wp_rem_element_view_gid_modern'),
                'grid-classic' => wp_rem_plugin_text_srt('wp_rem_element_view_gid_classic'),
                'grid-default' => wp_rem_plugin_text_srt('wp_rem_element_view_gid_default'),
            );
            ?>

            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="wp_rem_split_map" data="<?php echo wp_rem_cs_element_size_data_array_index($wp_rem_split_map_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $wp_rem_split_map_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_split_map {{attributes}}]{{content}}[/wp_rem_split_map]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo wp_rem_plugin_text_srt('wp_rem_shortcode_split_map_options'); ?></h5>
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
                                    'std' => esc_attr($split_map_title),
                                    'id' => 'split_map_title',
                                    'cust_name' => 'split_map_title[]',
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
                                    'std' => esc_attr($split_map_subtitle),
                                    'id' => 'split_map_subtitle',
                                    'cust_name' => 'split_map_subtitle[]',
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
                                    'std' => esc_attr($split_map_title_alignment),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'split_map_title_alignment[]',
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
                            <script>
                                jQuery(document).ready(function () {
                                    jQuery(".save_filter_by_categories").click(function () {
                                        var MY_SELECT = jQuery('#wp_rem_filter_by_categories').get(0);
                                        var selection = ChosenOrder.getSelectionOrder(MY_SELECT);
                                        var filter_by_categories_vals = '';
                                        var comma = '';
                                        jQuery(selection).each(function (i) {
                                            filter_by_categories_vals = filter_by_categories_vals + comma + selection[i];
                                            comma = ',';
                                        });
                                        jQuery('#filter_by_categories_val').val(filter_by_categories_vals);
                                    });

                                });
                            </script>
                            <?php
                            // $categories_filter_array = array();
                            $categories_filter_array = get_terms( array(
                                            'taxonomy' => 'property-category',
                                            'fields' => 'id=>slug',
                                            'hide_empty' => false,
                                        ) );

                            // filter properties by category
                            $wp_rem_opt_array = array(
                                'name' => 'Filter by Category',
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'multi' => true,
                                'field_params' => array(
                                    'std' => esc_attr($filter_by_categories),
                                    'id' => 'filter_by_categories',
                                    'classes' => 'chosen-select',
                                    'cust_name' => 'filter_by_categories[]',
                                    'return' => true,
                                    'options' => $categories_filter_array
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            
                            $wp_rem_cs_opt_array = array(
                                'std' => $property_location,
                                'cust_id' => 'filter_by_categories_val',
                                'cust_name' => "filter_by_categories_val[]",
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                            ?>
                            <script>
                                function property_map_position<?php echo absint($property_rand_id); ?>() {
                                    'use strict';
                                    var property_topmap = jQuery("#<?php echo 'wp_rem_property_view' . $property_rand_id ?>").val();
                                    var property_layout_switcher = jQuery("#<?php echo 'wp_rem_property_layout_switcher' . $property_rand_id ?>").val();
                                    var property_layout_switcher_view = jQuery("#<?php echo 'wp_rem_property_layout_switcher_view' . $property_rand_id ?>").val();
                                    var condition = false;
                                    if (property_topmap == 'map') {
                                        condition = true;
                                    } else if (property_layout_switcher == 'yes') {
                                        if (property_layout_switcher_view.indexOf("map") != -1) {
                                            //condition = true;
                                        }
                                    }
                                    if (condition === false) {
                                        jQuery('.dynamic_map_position<?php echo absint($property_rand_id); ?>').hide();
                                        jQuery('.dynamic_map_show_position<?php echo absint($property_rand_id); ?>').show();
                                    } else {
                                        jQuery('.dynamic_map_show_position<?php echo absint($property_rand_id); ?>').hide();
                                        jQuery('.dynamic_map_position<?php echo absint($property_rand_id); ?>').show();
                                    }

                                    var view_value = jQuery('#wp_rem_property_view<?php echo absint($property_rand_id); ?>').val();
                                    if (view_value == 'list') {
                                        jQuery('.dynamic_title_length').hide();
                                    } else {
                                        jQuery('.dynamic_title_length').show();
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
                                    'extra_atr' => 'onchange="property_map_position' . $property_rand_id . '()"',
                                    'return' => true,
                                    'options' => $property_views
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            ?>
                            <script>
                                function property_layout_switcher_view<?php echo absint($property_rand_id); ?>($property_layout_switcher) {
                                    // only for slider view
                                    if ($property_layout_switcher == 'no') {
                                        jQuery('.layout_dynamic_fields<?php echo absint($property_rand_id); ?>').hide();
                                    } else {
                                        jQuery('.layout_dynamic_fields<?php echo absint($property_rand_id); ?>').show();
                                    }
                                    property_map_position<?php echo absint($property_rand_id) ?>();
                                }
                                function property_ads_count<?php echo absint($property_rand_id); ?>($property_ads_switcher) {
                                    if ($property_ads_switcher == 'no') {
                                        jQuery('.property_count_dynamic_fields<?php echo absint($property_rand_id); ?>').hide();
                                    } else {
                                        jQuery('.property_count_dynamic_fields<?php echo absint($property_rand_id); ?>').show();
                                    }
                                }
                                function show_more_button_count<?php echo absint($property_rand_id); ?>($show_more_button_switcher) {
                                    if ($show_more_button_switcher == 'no') {
                                        jQuery('.show_more_button_dynamic_fields<?php echo absint($property_rand_id); ?>').hide();
                                    } else {
                                        jQuery('.show_more_button_dynamic_fields<?php echo absint($property_rand_id); ?>').show();
                                    }
                                }
                            </script>
                            <?php
                            $dynamic_title_length_grid = 'style="display: block;"';
                            if ( $property_view != 'grid' ) {
                                $dynamic_title_length_grid = 'style="display: none;"';
                            }
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_title_length'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'dynamic_title_length',
                                'main_wraper_extra' => $dynamic_title_length_grid,
                                'field_params' => array(
                                    'std' => esc_attr($split_map_title_limit),
                                    'id' => 'split_map_title_limit',
                                    'cust_name' => 'split_map_title_limit[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_layout_switcher'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_layout_switcher),
                                    'id' => 'property_layout_switcher' . $property_rand_id . '',
                                    'cust_name' => 'property_layout_switcher[]',
                                    'classes' => 'chosen-select-no-single',
                                    'extra_atr' => 'onchange="property_layout_switcher_view' . $property_rand_id . '(this.value)"',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            $layout_hide_string = '';
                            if ( $property_layout_switcher == 'no' ) {
                                $layout_hide_string = 'style="display:none;"';
                            }
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_layout_switcher_views'),
                                'desc' => '',
                                'label_desc' => '',
                                'multi' => true,
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'layout_dynamic_fields' . $property_rand_id . '',
                                'main_wraper_extra' => $layout_hide_string,
                                'field_params' => array(
                                    'std' => esc_attr($property_layout_switcher_view),
                                    'id' => 'property_layout_switcher_view' . $property_rand_id . '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'property_layout_switcher_view[' . $property_rand_id . '][]',
                                    'extra_atr' => 'onchange="property_map_position' . $property_rand_id . '()"',
                                    'return' => true,
                                    'options' => $property_views
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            $topmap_position_hide_string = '';
                            $topmap_position_show_string = '';
                            if ( ( false === strpos($property_layout_switcher_view, 'map') ) && $property_view != 'map' ) {
                                $topmap_position_hide_string = 'style="display:none;"';
                                $topmap_position_show_string = 'style="display:block;"';
                            } else if ( $property_view == 'map' ) {
                                $topmap_position_show_string = 'style="display:none;"';
                            }

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_map_position'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'dynamic_map_position' . $property_rand_id . '',
                                'main_wraper_extra' => $topmap_position_hide_string,
                                'field_params' => array(
                                    'std' => esc_attr($property_map_position),
                                    'id' => 'property_map_position[]',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'property_map_position[]',
                                    'return' => true,
                                    'options' => array(
                                        'left' => wp_rem_plugin_text_srt('wp_rem_align_left'),
                                        'right' => wp_rem_plugin_text_srt('wp_rem_align_right'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_footer_disable'),
                                'desc' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_footer_disable_desc'),
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'dynamic_map_position' . $property_rand_id . '',
                                'main_wraper_extra' => $topmap_position_hide_string,
                                'field_params' => array(
                                    'std' => esc_attr($property_footer),
                                    'id' => 'property_footer[]',
                                    'cust_name' => 'property_footer[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_left_filters'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'dynamic_map_show_position' . $property_rand_id . '',
                                'main_wraper_extra' => $topmap_position_show_string,
                                'field_params' => array(
                                    'std' => esc_attr($search_box),
                                    'id' => 'search_box[]',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'search_box[]',
                                    'extra_atr' => 'onchange="left_filter_count' . $property_rand_id . '(this.value)"',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            $left_filter_hide_string = '';
                            if ( $search_box == 'no' ) {
                                $left_filter_hide_string = 'style="display:none;"';
                            }
                            ?>
                            <script>
                                function left_filter_count<?php echo intval($property_rand_id); ?>($search_box) {
                                    if ($search_box == 'no') {
                                        jQuery('.left_filter_show_position<?php echo intval($property_rand_id); ?>').hide();
                                    } else {
                                        jQuery('.left_filter_show_position<?php echo intval($property_rand_id); ?>').show();
                                    }
                                }
                            </script><?php
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_left_filters_count'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'left_filter_show_position' . $property_rand_id . '',
                                'main_wraper_extra' => $left_filter_hide_string,
                                'field_params' => array(
                                    'std' => esc_attr($left_filter_count),
                                    'id' => 'left_filter_count[]',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'left_filter_count[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_notifications_box'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($notifications_box),
                                    'id' => 'notifications_box[]',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'notifications_box[]',
                                    'return' => true,
                                    'options' => array(
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                    )
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $draw_field_display = ( $notifications_box == 'yes' ) ? 'block' : 'none';
                            echo '<div class="draw_on_map_url_field" style="display:' . $draw_field_display . ';">';
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_draw_on_map'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($draw_on_map_url),
                                    'id' => 'draw_on_map_url',
                                    'cust_name' => 'draw_on_map_url[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            echo '</div>';

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
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => absint($property_rand_id),
                                'id' => '',
                                'cust_name' => "property_layout_switcher_id[]",
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_map_search_keyword'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_search_keyword),
                                    'id' => 'property_search_keyword[]',
                                    'cust_name' => 'property_search_keyword[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            ?>
                            <script>
                                function property_top_category_count<?php echo $property_rand_id; ?>($property_top_category) {
                                    if ($property_top_category == 'no') {
                                        jQuery('.property_top_category_count_dynamic_fields<?php echo $property_rand_id; ?>').hide();
                                    } else {
                                        jQuery('.property_top_category_count_dynamic_fields<?php echo $property_rand_id; ?>').show();
                                    }
                                }
                            </script>
                            <?php
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_list_meta_top_category'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_top_category),
                                    'id' => 'property_top_category[]',
                                    'cust_name' => 'property_top_category[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'extra_atr' => 'onchange="property_top_category_count' . $property_rand_id . '(this.value)"',
                                    'options' => array(
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                    ),
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            $property_top_category_count_hide_string = '';
                            if ( $property_top_category == 'no' ) {
                                $property_top_category_count_hide_string = 'style="display:none;"';
                            }
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_top_category_count'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'property_top_category_count_dynamic_fields' . $property_rand_id . '',
                                'main_wraper_extra' => $property_top_category_count_hide_string,
                                'field_params' => array(
                                    'std' => esc_attr($property_top_category_count),
                                    'id' => 'property_top_category_count',
                                    'cust_name' => 'property_top_category_count[]',
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


                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_price_filters'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_price_filter),
                                    'id' => 'property_price_filter[]',
                                    'cust_name' => 'property_price_filter[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'extra_atr' => '',
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_open_house_filters'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($property_open_house_filter),
                                    'id' => 'property_open_house_filter[]',
                                    'cust_name' => 'property_open_house_filter[]',
                                    'return' => true,
                                    'classes' => 'chosen-select-no-single',
                                    'extra_atr' => '',
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
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

                            if ( $property_location != '' ) {
                                $property_locations = explode(',', $property_location);
                                foreach ( $property_locations as $property_location ) {
                                    $get_property_locations[$property_location] = $property_location_options[$property_location];
                                }
                            }
                            if ( $get_property_locations ) {
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

                            $show_more_property_button_switch_options = array( 'no' => wp_rem_plugin_text_srt('wp_rem_property_no'), 'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes') );
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_show_more_switch'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($show_more_property_button_switch),
                                    'id' => 'show_more_property_button_switch',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'show_more_property_button_switch[]',
                                    'return' => true,
                                    'extra_atr' => 'onchange="show_more_button_count' . $property_rand_id . '(this.value)"',
                                    'options' => $show_more_property_button_switch_options
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $show_more_button_hide_string = '';
                            if ( $show_more_property_button_switch == 'no' ) {
                                $show_more_button_hide_string = 'style="display:none;"';
                            }

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_show_more_url'),
                                'desc' => '',
                                'label_desc' => wp_rem_plugin_text_srt('wp_rem_shortcode_properties_show_more_url_hint'),
                                'echo' => true,
                                'main_wraper' => true,
                                'main_wraper_class' => 'show_more_button_dynamic_fields' . $property_rand_id . '',
                                'main_wraper_extra' => $show_more_button_hide_string,
                                'field_params' => array(
                                    'std' => esc_attr($show_more_property_button_url),
                                    'id' => 'show_more_property_button_url',
                                    'cust_name' => 'show_more_property_button_url[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);

                            $pagination_options = array( 'no' => wp_rem_plugin_text_srt('wp_rem_property_no'), 'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes') );
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_pagination'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($pagination),
                                    'id' => 'pagination',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'pagination[]',
                                    'return' => true,
                                    'options' => $pagination_options
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

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

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_map_position'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_map_position),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'wp_rem_map_position[]',
                                    'return' => true,
                                    'options' => array(
                                        'left' => wp_rem_plugin_text_srt('wp_rem_shortcode_map_left'),
                                        'right' => wp_rem_plugin_text_srt('wp_rem_shortcode_map_right'),
                                        'top' => wp_rem_plugin_text_srt('wp_rem_shortcode_map_top'),
                                    )
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_fixed_map'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_map_fixed),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'wp_rem_map_fixed[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    )
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => absint($property_rand_id),
                                'id' => '',
                                'cust_id' => 'property_counter',
                                'cust_name' => 'property_counter[]',
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
                                'std' => 'wp_rem_split_map',
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
                                    'cust_id' => 'wp_rem_split_map_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'save_filter_by_categories cs-wp_rem_cs-admin-btn save_property_locations_' . $property_rand_id . '',
                                    'cust_name' => 'wp_rem_split_map_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_wp_rem_split_map', 'wp_rem_cs_var_page_builder_wp_rem_split_map');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_wp_rem_split_map_callback') ) {

    /**
     * Save data for wp_rem_split_map shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_wp_rem_split_map_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ( $widget_type == "wp_rem_split_map" || $widget_type == "cs_wp_rem_split_map" ) {
            $wp_rem_cs_bareber_wp_rem_split_map = '';

            $page_element_size = $data['wp_rem_split_map_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_split_map']];
            $current_element_size = $data['wp_rem_split_map_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_split_map']];

            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes(( $data['shortcode']['wp_rem_split_map'][$counters['wp_rem_cs_shortcode_counter_wp_rem_split_map']]));

                $element_settings = 'wp_rem_split_map_element_size="' . $current_element_size . '"';
                $reg = '/wp_rem_split_map_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_wp_rem_split_map'] ++;
            } else {
                $element_settings = 'wp_rem_split_map_element_size="' . htmlspecialchars($data['wp_rem_split_map_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_split_map']]) . '"';
                $wp_rem_cs_bareber_wp_rem_split_map = '[wp_rem_split_map ' . $element_settings . ' ';
                if ( isset($data['split_map_title'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['split_map_title'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'split_map_title="' . htmlspecialchars($data['split_map_title'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['split_map_title_alignment'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['split_map_title_alignment'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'split_map_title_alignment="' . htmlspecialchars($data['split_map_title_alignment'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['split_map_title_limit'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['split_map_title_limit'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'split_map_title_limit="' . htmlspecialchars($data['split_map_title_limit'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['split_map_subtitle'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['split_map_subtitle'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'split_map_subtitle="' . htmlspecialchars($data['split_map_subtitle'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_type'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_type'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_type="' . htmlspecialchars($data['property_type'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }

                if ( isset($data['property_topmap'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_topmap'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_topmap="' . htmlspecialchars($data['property_topmap'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_map_position'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_map_position'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_map_position="' . htmlspecialchars($data['property_map_position'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_map_height'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_map_height'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_map_height="' . htmlspecialchars($data['property_map_height'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_view'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_view'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_view="' . htmlspecialchars($data['property_view'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_sort_by'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_sort_by'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_sort_by="' . htmlspecialchars($data['property_sort_by'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_layout_switcher'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_layout_switcher'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_layout_switcher="' . htmlspecialchars($data['property_layout_switcher'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($_POST['property_layout_switcher_id'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $_POST['property_layout_switcher_id'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {

                    $property_layout_switcher_id = $_POST['property_layout_switcher_id'][$counters['wp_rem_cs_counter_wp_rem_split_map']];
                    if ( isset($_POST['property_layout_switcher_view'][$property_layout_switcher_id]) && $_POST['property_layout_switcher_view'][$property_layout_switcher_id] != '' ) {
                        if ( is_array($_POST['property_layout_switcher_view'][$property_layout_switcher_id]) ) {
                            $wp_rem_cs_bareber_wp_rem_split_map .= ' property_layout_switcher_view="' . implode(',', $_POST['property_layout_switcher_view'][$property_layout_switcher_id]) . '" ';
                        }
                    }
                }

                // saving admin field using filter for add on
                $wp_rem_cs_bareber_wp_rem_split_map .= apply_filters('wp_rem_save_properties_shortcode_admin_fields', $wp_rem_cs_bareber_wp_rem_split_map, $data, $counters['wp_rem_cs_counter_wp_rem_split_map']);
                if ( isset($data['filter_by_categories_val'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['filter_by_categories_val'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'filter_by_categories="' . $data['filter_by_categories_val'][$counters['wp_rem_cs_counter_wp_rem_split_map']] . '" ';
                }
                if ( isset($data['property_search_keyword'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_search_keyword'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_search_keyword="' . htmlspecialchars($data['property_search_keyword'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_top_category'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_top_category'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_top_category="' . htmlspecialchars($data['property_top_category'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_top_category_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_top_category_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_top_category_count="' . htmlspecialchars($data['property_top_category_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_footer'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_footer'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_footer="' . htmlspecialchars($data['property_footer'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_featured="' . htmlspecialchars($data['property_featured'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_no_custom_fields="' . htmlspecialchars($data['property_no_custom_fields'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_ads_switch'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_ads_switch'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_ads_switch="' . htmlspecialchars($data['property_ads_switch'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_price_filter'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_price_filter'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_price_filter="' . htmlspecialchars($data['property_price_filter'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_open_house_filter'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_open_house_filter'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_open_house_filter="' . htmlspecialchars($data['property_open_house_filter'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_ads_after_list_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_ads_after_list_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_ads_after_list_count="' . htmlspecialchars($data['property_ads_after_list_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'posts_per_page="' . htmlspecialchars($data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['pagination'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['pagination'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'pagination="' . htmlspecialchars($data['pagination'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['show_more_property_button_switch'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['show_more_property_button_switch'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'show_more_property_button_switch="' . htmlspecialchars($data['show_more_property_button_switch'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['show_more_property_button_url'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['show_more_property_button_url'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'show_more_property_button_url="' . htmlspecialchars($data['show_more_property_button_url'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }

                if ( isset($data['property_counter'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_counter'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_counter="' . htmlspecialchars($data['property_counter'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['search_box'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['search_box'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'search_box="' . htmlspecialchars($data['search_box'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['left_filter_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['left_filter_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'left_filter_count="' . htmlspecialchars($data['left_filter_count'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['notifications_box'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['notifications_box'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'notifications_box="' . htmlspecialchars($data['notifications_box'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['draw_on_map_url'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['draw_on_map_url'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'draw_on_map_url="' . htmlspecialchars($data['draw_on_map_url'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_map_position'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['wp_rem_map_position'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'wp_rem_map_position="' . htmlspecialchars($data['wp_rem_map_position'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_map_fixed'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['wp_rem_map_fixed'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'wp_rem_map_fixed="' . htmlspecialchars($data['wp_rem_map_fixed'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['property_location'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['property_location'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= 'property_location="' . htmlspecialchars($data['property_location'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . '" ';
                }
                $wp_rem_cs_bareber_wp_rem_split_map .= ']';
                if ( isset($data['wp_rem_split_map_column_text'][$counters['wp_rem_cs_counter_wp_rem_split_map']]) && $data['wp_rem_split_map_column_text'][$counters['wp_rem_cs_counter_wp_rem_split_map']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_split_map .= htmlspecialchars($data['wp_rem_split_map_column_text'][$counters['wp_rem_cs_counter_wp_rem_split_map']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_bareber_wp_rem_split_map .= '[/wp_rem_split_map]';
                $shortcode_data .= $wp_rem_cs_bareber_wp_rem_split_map;
                $counters['wp_rem_cs_counter_wp_rem_split_map'] ++;
            }
            $counters['wp_rem_cs_global_counter_wp_rem_split_map'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_wp_rem_split_map', 'wp_rem_cs_save_page_builder_data_wp_rem_split_map_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_wp_rem_split_map_callback') ) {

    /**
     * Populate wp_rem_split_map shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_wp_rem_split_map_callback($counters) {
        $counters['wp_rem_cs_global_counter_wp_rem_split_map'] = 0;
        $counters['wp_rem_cs_shortcode_counter_wp_rem_split_map'] = 0;
        $counters['wp_rem_cs_counter_wp_rem_split_map'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_wp_rem_split_map_callback');
}



if ( ! function_exists('wp_rem_cs_element_list_populate_wp_rem_split_map_callback') ) {

    /**
     * Populate wp_rem_split_map shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_wp_rem_split_map_callback($element_list) {
        $element_list['wp_rem_split_map'] = wp_rem_plugin_text_srt('wp_rem_shortcode_split_map_heading');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_wp_rem_split_map_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_wp_rem_split_map_callback') ) {

    /**
     * Populate wp_rem_split_map shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_wp_rem_split_map_callback($shortcode_array) {
        $shortcode_array['wp_rem_split_map'] = array(
            'title' => wp_rem_plugin_text_srt('wp_rem_shortcode_split_map_heading'),
            'name' => 'wp_rem_split_map',
            'icon' => 'icon-gears',
            'categories' => 'typography',
        );

        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_wp_rem_split_map_callback');
}


if ( ! function_exists('wp_rem_cs_shortcode_remove_sizes_callback') ) {

    function wp_rem_cs_shortcode_remove_sizes_callback($shortcode_array) {
        $shortcode_array[] = 'wp_rem_split_map';
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_remove_sizes', 'wp_rem_cs_shortcode_remove_sizes_callback');
}
