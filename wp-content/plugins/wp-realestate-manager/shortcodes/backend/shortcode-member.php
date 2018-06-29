<?php
/**
 * Shortcode Name : wp_rem_members
 *
 * @package	wp_rem_cs 
 */
if ( ! function_exists('wp_rem_cs_var_page_builder_wp_rem_members') ) {

    function wp_rem_cs_var_page_builder_wp_rem_members($die = 0) {
        global $post, $wp_rem_html_fields, $wp_rem_html_fields, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_frame_static_text;
        if ( function_exists('wp_rem_cs_shortcode_names') ) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $wp_rem_cs_PREFIX = 'wp_rem_members';
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
                'members_title' => '',
                'members_subtitle' => '',
                'members_title_align' => '',
                'member_view' => '',
                'member_sort_by' => 'no',
                'posts_per_page' => '',
                'pagination' => '',
                'member_property_sort_view' => '',
                'member_excerpt_length' => '',
                'member_top_filter' => '',
                'member_featured_only' => '',
                'wp_rem_element_title_color'=>'',
            );
            $defaults = apply_filters('wp_rem_members_shortcode_admin_default_attributes', $defaults);
            if ( isset($wp_rem_cs_output['0']['atts']) ) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if ( isset($wp_rem_cs_output['0']['content']) ) {
                $wp_rem_members_column_text = $wp_rem_cs_output['0']['content'];
            } else {
                $wp_rem_members_column_text = '';
            }
            $wp_rem_members_element_size = '100';
            foreach ( $defaults as $key => $values ) {
                if ( isset($atts[$key]) ) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_wp_rem_members';
            $coloumn_class = 'column_' . $wp_rem_members_element_size;
            if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $member_rand_id = rand(4444, 99999);
            wp_rem_cs_var_date_picker();
            $member_views = array(
                'alphabatic' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_alphabatic'),
                'grid' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_grid'),
                'grid-slider' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_slider'),
                'list' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_list'),
            );
            ?>

            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="wp_rem_members" data="<?php echo wp_rem_cs_element_size_data_array_index($wp_rem_members_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $wp_rem_members_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_members {{attributes}}]{{content}}[/wp_rem_members]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo wp_rem_plugin_text_srt('wp_rem_shortcode_members_options'); ?></h5>
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
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_title'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($members_title),
                                    'id' => 'members_title',
                                    'cust_name' => 'members_title[]',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_sub_title'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($members_subtitle),
                                    'id' => 'members_subtitle',
                                    'cust_name' => 'members_subtitle[]',
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
                                    'std' => esc_attr($members_title_align),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'members_title_align[]',
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
                                'name' => wp_rem_plugin_text_srt('wp_rem_element_title_color_memeber'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_html($wp_rem_element_title_color),
                                    'cust_name' => 'wp_rem_element_title_color[]',
                                    'classes' => 'bg_color',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
                        
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_member_member_type'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($member_property_sort_view),
                                    'id' => 'member_property_sort_view',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'member_property_sort_view[]',
                                    'return' => true,
                                    'options' => array(
                                        'all' => wp_rem_plugin_text_srt('wp_rem_options_all'),
                                        'individual' => wp_rem_plugin_text_srt('wp_rem_members'),
                                        'company' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_agencies'),
                                    ),
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_view'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($member_view),
                                    'id' => 'member_view' . $member_rand_id . '',
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'member_view[]',
                                    'extra_atr' => 'onchange="member_map_position' . $member_rand_id . '()"',
                                    'return' => true,
                                    'options' => $member_views
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_top_filters'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($member_top_filter),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'member_top_filter[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    ),
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_featured_only'),
                                'desc' => '',
                                'label_desc' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($member_featured_only),
                                    'classes' => 'chosen-select-no-single',
                                    'cust_name' => 'member_featured_only[]',
                                    'return' => true,
                                    'options' => array(
                                        'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
                                        'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
                                    ),
                                ),
                            );

                            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
                            ?>
                            <script>
                                
                                function member_ads_count<?php echo absint($member_rand_id); ?>($member_ads_switcher) {
                                    if ($member_ads_switcher == 'no') {
                                        jQuery('.member_count_dynamic_fields<?php echo absint($member_rand_id); ?>').hide();
                                    } else {
                                        jQuery('.member_count_dynamic_fields<?php echo absint($member_rand_id); ?>').show();
                                    }
                                }
                            </script>
            <?php
            
           
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_sort_by'),
                'desc' => '',
                'label_desc' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($member_sort_by),
                    'id' => 'member_sort_by[]',
                    'cust_name' => 'member_sort_by[]',
                    'classes' => 'chosen-select-no-single',
                    'return' => true,
                    'options' => array(
						'no' => wp_rem_plugin_text_srt('wp_rem_property_no'),
						'yes' => wp_rem_plugin_text_srt('wp_rem_property_yes'),
					),
                ),
            );
            $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);

            
            $wp_rem_opt_array = array(
                'name' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_excerpt_length'),
                'desc' => '',
                'echo' => true,
                'field_params' => array(
                    'std' => esc_attr($member_excerpt_length),
                    'id' => 'member_excerpt_length',
                    'cust_name' => 'member_excerpt_length[]',
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


            $wp_rem_cs_opt_array = array(
                'std' => absint($member_rand_id),
                'id' => '',
                'cust_id' => 'member_counter',
                'cust_name' => 'member_counter[]',
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
                                'std' => 'wp_rem_members',
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
                                    'cust_id' => 'wp_rem_members_save',
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn ',
                                    'cust_name' => 'wp_rem_members_save',
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

    add_action('wp_ajax_wp_rem_cs_var_page_builder_wp_rem_members', 'wp_rem_cs_var_page_builder_wp_rem_members');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_wp_rem_members_callback') ) {

    /**
     * Save data for wp_rem_members shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_wp_rem_members_callback($args) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        $shortcode_data = '';
        if ( $widget_type == "wp_rem_members" || $widget_type == "cs_wp_rem_members" ) {
            $wp_rem_cs_bareber_wp_rem_members = '';

            $page_element_size = $data['wp_rem_members_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_members']];
            $current_element_size = $data['wp_rem_members_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_members']];
            if ( isset($data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes(( $data['shortcode']['wp_rem_members'][$counters['wp_rem_cs_shortcode_counter_wp_rem_members']]));

                $element_settings = 'wp_rem_members_element_size="' . $current_element_size . '"';
                $reg = '/wp_rem_members_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_wp_rem_members'] ++;
            } else {
                $element_settings = 'wp_rem_members_element_size="' . htmlspecialchars($data['wp_rem_members_element_size'][$counters['wp_rem_cs_global_counter_wp_rem_members']]) . '"';
                $wp_rem_cs_bareber_wp_rem_members = '[wp_rem_members ' . $element_settings . ' ';
                if ( isset($data['members_title'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['members_title'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'members_title="' . htmlspecialchars($data['members_title'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['wp_rem_element_title_color'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['wp_rem_element_title_color'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'wp_rem_element_title_color="' . htmlspecialchars($data['wp_rem_element_title_color'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['members_title_align'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['members_title_align'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'members_title_align="' . htmlspecialchars($data['members_title_align'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['members_subtitle'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['members_subtitle'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'members_subtitle="' . htmlspecialchars($data['members_subtitle'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_type'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_type'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_type="' . htmlspecialchars($data['member_type'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_property_sort_view'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_property_sort_view'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_property_sort_view="' . htmlspecialchars($data['member_property_sort_view'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_excerpt_length'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_excerpt_length'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_excerpt_length="' . htmlspecialchars($data['member_excerpt_length'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_view'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_view'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_view="' . htmlspecialchars($data['member_view'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_top_filter'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_top_filter'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_top_filter="' . htmlspecialchars($data['member_top_filter'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_featured_only'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_featured_only'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_featured_only="' . htmlspecialchars($data['member_featured_only'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_sort_by'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_sort_by'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_sort_by="' . htmlspecialchars($data['member_sort_by'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
               
                
                if ( isset($data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'posts_per_page="' . htmlspecialchars($data['posts_per_page'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['pagination'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['pagination'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'pagination="' . htmlspecialchars($data['pagination'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }
                if ( isset($data['member_counter'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['member_counter'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= 'member_counter="' . htmlspecialchars($data['member_counter'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . '" ';
                }


                $wp_rem_cs_bareber_wp_rem_members .= ']';
                if ( isset($data['wp_rem_members_column_text'][$counters['wp_rem_cs_counter_wp_rem_members']]) && $data['wp_rem_members_column_text'][$counters['wp_rem_cs_counter_wp_rem_members']] != '' ) {
                    $wp_rem_cs_bareber_wp_rem_members .= htmlspecialchars($data['wp_rem_members_column_text'][$counters['wp_rem_cs_counter_wp_rem_members']], ENT_QUOTES) . ' ';
                }
                $wp_rem_cs_bareber_wp_rem_members .= '[/wp_rem_members]';
                $shortcode_data .= $wp_rem_cs_bareber_wp_rem_members;
                $counters['wp_rem_cs_counter_wp_rem_members'] ++;
            }
            $counters['wp_rem_cs_global_counter_wp_rem_members'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_wp_rem_members', 'wp_rem_cs_save_page_builder_data_wp_rem_members_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_wp_rem_members_callback') ) {

    /**
     * Populate wp_rem_members shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_wp_rem_members_callback($counters) {
        $counters['wp_rem_cs_global_counter_wp_rem_members'] = 0;
        $counters['wp_rem_cs_shortcode_counter_wp_rem_members'] = 0;
        $counters['wp_rem_cs_counter_wp_rem_members'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_wp_rem_members_callback');
}



if ( ! function_exists('wp_rem_cs_element_list_populate_wp_rem_members_callback') ) {

    /**
     * Populate wp_rem_members shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_wp_rem_members_callback($element_list) {
        $element_list['wp_rem_members'] = wp_rem_plugin_text_srt('wp_rem_shortcode_members_heading');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_wp_rem_members_callback');
}

if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_wp_rem_members_callback') ) {

    /**
     * Populate wp_rem_members shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_wp_rem_members_callback($shortcode_array) {
        $shortcode_array['wp_rem_members'] = array(
            'title' => wp_rem_plugin_text_srt('wp_rem_shortcode_members_heading'),
            'name' => 'wp_rem_members',
            'icon' => 'icon-gears',
            'categories' => 'typography',
        );

        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_wp_rem_members_callback');
}
