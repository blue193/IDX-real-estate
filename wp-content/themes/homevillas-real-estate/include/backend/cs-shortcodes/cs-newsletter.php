<?php
/*
 *
 * @File : Newsletter
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_page_builder_newsletter') ) {

    function wp_rem_cs_var_page_builder_newsletter($die = 0) {
        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields;

        if ( function_exists('wp_rem_cs_shortcode_names') ) {
            $shortcode_element = '';
            $filter_element = 'filterdrag';
            $shortcode_view = '';
            $wp_rem_cs_output = array();
            $PREFIX = 'wp_rem_cs_newsletter';
            $counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            $wp_rem_cs_counter = isset($_POST['counter']) ? $_POST['counter'] : '';
            if ( isset($_POST['action']) && ! isset($_POST['shortcode_element_id']) ) {
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
                'wp_rem_cs_var_newsletter_title' => '',
                'wp_rem_cs_var_newsletter_subtitle' => '',
                'wp_rem_var_newsletter_align' => '',
                'wp_rem_cs_var_newsletter_api_key' => '',
                'wp_rem_var_newsletter_list' => '',
                'wp_rem_var_newsletter_styles'=>'',
                'wp_rem_var_newsletter_social_icons'=>'',
            );
            if ( isset($wp_rem_cs_output['0']['atts']) ) {
                $atts = $wp_rem_cs_output['0']['atts'];
            } else {
                $atts = array();
            }
            if ( isset($wp_rem_cs_output['0']['content']) ) {
                $newsletter_text = $wp_rem_cs_output['0']['content'];
            } else {
                $newsletter_text = '';
            }
            $newsletter_element_size = '25';
            foreach ( $defaults as $key => $values ) {
                if ( isset($atts[$key]) ) {
                    $$key = $atts[$key];
                } else {
                    $$key = $values;
                }
            }
            $name = 'wp_rem_cs_var_page_builder_newsletter';
            $coloumn_class = 'column_' . $newsletter_element_size;
            $wp_rem_cs_var_newsletter_title = isset($wp_rem_cs_var_newsletter_title) ? $wp_rem_cs_var_newsletter_title : '';
            $wp_rem_cs_var_newsletter_url = isset($wp_rem_cs_var_newsletter_url) ? $wp_rem_cs_var_newsletter_url : '';
            $wp_rem_cs_var_height = isset($wp_rem_cs_var_height) ? $wp_rem_cs_var_height : '';
            if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) {
                $shortcode_element = 'shortcode_element_class';
                $shortcode_view = 'cs-pbwp-shortcode';
                $filter_element = 'ajax-drag';
                $coloumn_class = '';
            }
            $stringsObj = new wp_rem_cs_theme_all_strings;
            $stringsObj->wp_rem_cs_short_code_strings();
            ?>
            <div id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>_del" class="column  parentdelete <?php echo esc_attr($coloumn_class); ?>
                 <?php echo esc_attr($shortcode_view); ?>" item="newsletter" data="<?php echo wp_rem_cs_element_size_data_array_index($newsletter_element_size) ?>" >
                     <?php wp_rem_cs_element_setting($name, $wp_rem_cs_counter, $newsletter_element_size) ?>
                <div class="cs-wrapp-class-<?php echo intval($wp_rem_cs_counter) ?>
                     <?php echo esc_attr($shortcode_element); ?>" id="<?php echo esc_attr($name . $wp_rem_cs_counter) ?>" data-shortcode-template="[wp_rem_cs_newsletter {{attributes}}]{{content}}[/wp_rem_cs_newsletter]" style="display: none;">
                    <div class="cs-heading-area" data-counter="<?php echo esc_attr($wp_rem_cs_counter) ?>">
                        <h5><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_text')); ?></h5>
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
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_newsletter_title),
                                    'cust_id' => 'wp_rem_cs_var_newsletter_title' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_newsletter_title[]',
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
                                    'std' => esc_attr($wp_rem_cs_var_newsletter_subtitle),
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_newsletter_subtitle[]',
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
                                    'std' => $wp_rem_var_newsletter_align,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_var_newsletter_align',
                                    'cust_name' => 'wp_rem_var_newsletter_align[]',
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
                            
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_styles'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_styles_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_var_newsletter_styles,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_var_newsletter_styles[]',
                                    'classes' => 'chosen-select-no-single',
                                    'options' => array(
                                        'classic' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_styles_classic'),
                                        'modern' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_styles_modern'),
                                        'boxed' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_newslwtter_styles_boxed'),
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
                            
                            
                            $wp_rem_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_newsletter_show_icons'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_var_newsletter_social_icons,
                                    'id' => '',
                                    'cust_name' => 'wp_rem_var_newsletter_social_icons[]',
                                    'classes' => 'chosen-select-no-single',
                                    'options' => array(
                                        'yes' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_newsletter_show_icons_yes'),
                                        'no' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_newsletter_show_icons_no'),
                                        
                                    ),
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);
                            
                            
                            
                            
                            
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_content'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_textarea($newsletter_text),
                                    'cust_id' => 'wp_rem_cs_var_newsletter_description' . $wp_rem_cs_counter,
                                    'classes' => 'textarea',
                                    'cust_name' => 'wp_rem_cs_var_newsletter_description[]',
                                    'return' => true,
                                    'wp_rem_cs_editor' => true,
                                    'extra_atr' => 'data-content-text="cs-shortcode-textarea"',
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field($wp_rem_cs_opt_array);
                            
                            
                            $wp_rem_cs_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_api_key'),
                                'desc' => '',
                                'hint_text' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_api_key_hint'),
                                'echo' => true,
                                'field_params' => array(
                                    'std' => esc_attr($wp_rem_cs_var_newsletter_api_key),
                                    'cust_id' => 'wp_rem_cs_var_newsletter_api_key' . $wp_rem_cs_counter,
                                    'classes' => '',
                                    'cust_name' => 'wp_rem_cs_var_newsletter_api_key[]',
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_opt_array);

                            $mail_chimp_list = array();
                            if ( isset($wp_rem_cs_var_newsletter_api_key) && $wp_rem_cs_var_newsletter_api_key != '' ) {
                                $mailchimp_option = $wp_rem_cs_var_newsletter_api_key;
                                if ( $mailchimp_option <> '' ) {
                                    if ( function_exists('wp_rem_cs_mailchimp_list') ) {
                                        $mc_list = wp_rem_cs_mailchimp_list($mailchimp_option);
                                        if ( is_array($mc_list) && ! empty($mc_list) ) {
                                            if ( is_array($mc_list) && isset($mc_list['data']) ) {
                                                foreach ( $mc_list['data'] as $list ) {
                                                    $mail_chimp_list[$list['id']] = $list['name'];
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            $wp_rem_opt_array = array(
                                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_list'),
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => $wp_rem_var_newsletter_list,
                                    'id' => '',
                                    'cust_id' => 'wp_rem_var_newsletter_list',
                                    'cust_name' => 'wp_rem_var_newsletter_list[]',
                                    'classes' => 'service_postion chosen-select-no-single select-medium',
                                    'options' => $wp_rem_var_newsletter_list,
                                    'return' => true,
                                ),
                            );
                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_opt_array);

                            
                            ?>
                        </div>
                        <?php if ( isset($_POST['shortcode_element']) && $_POST['shortcode_element'] == 'shortcode' ) { ?>
                            <ul class="form-elements insert-bg">
                                <li class="to-field">
                                    <a class="insert-btn cs-main-btn" 
                                       onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace('wp_rem_cs_var_page_builder_', '', $name); ?>', '<?php echo esc_js($name . $wp_rem_cs_counter) ?>',
                                                                       '<?php echo esc_js($filter_element); ?>')" ><?php echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_insert')); ?></a>
                                </li>
                            </ul>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'newsletter',
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
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save'),
                                    'cust_id' => 'newsletter_save' . $wp_rem_cs_counter,
                                    'cust_type' => 'button',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'classes' => 'cs-wp_rem_cs-admin-btn',
                                    'cust_name' => 'newsletter_save',
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
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action('wp_ajax_wp_rem_cs_var_page_builder_newsletter', 'wp_rem_cs_var_page_builder_newsletter');
}

if ( ! function_exists('wp_rem_cs_save_page_builder_data_newsletter_callback') ) {

    /**
     * Save data for newsletter shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_newsletter_callback($args) {
        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
		
        $shortcode_data = '';
        if ( $widget_type == "newsletter" || $widget_type == "cs_newsletter" ) {
            $shortcode = '';
            $page_element_size = $data['newsletter_element_size'][$counters['wp_rem_cs_global_counter_newsletter']];
            $current_element_size = $data['newsletter_element_size'][$counters['wp_rem_cs_global_counter_newsletter']];

            if ( isset($_POST['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']]) && $_POST['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes($_POST['shortcode']['newsletter'][$counters['wp_rem_cs_shortcode_counter_newsletter']]);
                $element_settings = 'newsletter_element_size="' . $current_element_size . '"';
                $reg = '/newsletter_element_size="(\d+)"/s';
                $shortcode_str = preg_replace($reg, $element_settings, $shortcode_str);
                $shortcode_data = $shortcode_str;
                $counters['wp_rem_cs_shortcode_counter_newsletter'] ++;
            } else {
                $shortcode = '[wp_rem_cs_newsletter newsletter_element_size="' . htmlspecialchars($data['newsletter_element_size'][$counters['wp_rem_cs_global_counter_newsletter']]) . '" ';
                if ( isset($_POST['wp_rem_cs_var_newsletter_title'][$counters['wp_rem_cs_counter_newsletter']]) && $_POST['wp_rem_cs_var_newsletter_title'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .='wp_rem_cs_var_newsletter_title="' . htmlspecialchars($_POST['wp_rem_cs_var_newsletter_title'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . '" ';
                }
                if ( isset($_POST['wp_rem_cs_var_newsletter_api_key'][$counters['wp_rem_cs_counter_newsletter']]) && $_POST['wp_rem_cs_var_newsletter_api_key'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .='wp_rem_cs_var_newsletter_api_key="' . htmlspecialchars($_POST['wp_rem_cs_var_newsletter_api_key'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . '" ';
                }
                if ( isset($_POST['wp_rem_var_newsletter_styles'][$counters['wp_rem_cs_counter_newsletter']]) && $_POST['wp_rem_var_newsletter_styles'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .='wp_rem_var_newsletter_styles="' . htmlspecialchars($_POST['wp_rem_var_newsletter_styles'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . '" ';
                }
                if ( isset($_POST['wp_rem_var_newsletter_social_icons'][$counters['wp_rem_cs_counter_newsletter']]) && $_POST['wp_rem_var_newsletter_social_icons'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .='wp_rem_var_newsletter_social_icons="' . htmlspecialchars($_POST['wp_rem_var_newsletter_social_icons'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . '" ';
                }
                if ( isset($_POST['wp_rem_var_newsletter_list'][$counters['wp_rem_cs_counter_newsletter']]) && $_POST['wp_rem_var_newsletter_list'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .='wp_rem_var_newsletter_list="' . htmlspecialchars($_POST['wp_rem_var_newsletter_list'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . '" ';
                }
                if ( isset($_POST['wp_rem_cs_var_newsletter_subtitle'][$counters['wp_rem_cs_counter_newsletter']]) && $_POST['wp_rem_cs_var_newsletter_subtitle'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .='wp_rem_cs_var_newsletter_subtitle="' . htmlspecialchars($_POST['wp_rem_cs_var_newsletter_subtitle'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . '" ';
                }
                if ( isset($_POST['wp_rem_var_newsletter_align'][$counters['wp_rem_cs_counter_newsletter']]) && $_POST['wp_rem_var_newsletter_align'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .='wp_rem_var_newsletter_align="' . htmlspecialchars($_POST['wp_rem_var_newsletter_align'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . '" ';
                }
                $shortcode .= ']';
                if ( isset($data['wp_rem_cs_var_newsletter_description'][$counters['wp_rem_cs_counter_newsletter']]) && $data['wp_rem_cs_var_newsletter_description'][$counters['wp_rem_cs_counter_newsletter']] != '' ) {
                    $shortcode .= htmlspecialchars($data['wp_rem_cs_var_newsletter_description'][$counters['wp_rem_cs_counter_newsletter']], ENT_QUOTES) . ' ';
                }
                $shortcode .= '[/wp_rem_cs_newsletter]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_newsletter'] ++;
            }
            $counters['wp_rem_cs_global_counter_newsletter'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter('wp_rem_cs_save_page_builder_data_newsletter', 'wp_rem_cs_save_page_builder_data_newsletter_callback');
}

if ( ! function_exists('wp_rem_cs_load_shortcode_counters_newsletter_callback') ) {

    /**
     * Populate newsletter shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_newsletter_callback($counters) {
        $counters['wp_rem_cs_global_counter_newsletter'] = 0;
        $counters['wp_rem_cs_shortcode_counter_newsletter'] = 0;
        $counters['wp_rem_cs_counter_newsletter'] = 0;
        return $counters;
    }

    add_filter('wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_newsletter_callback');
}
if ( ! function_exists('wp_rem_cs_shortcode_names_list_populate_newsletter_callback') ) {

    /**
     * Populate newsletter shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_newsletter_callback($shortcode_array) {
        $shortcode_array['newsletter'] = array(
            'title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_element'),
            'name' => 'newsletter',
            'icon' => 'icon-envelope-o',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter('wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_newsletter_callback');
}

if ( ! function_exists('wp_rem_cs_element_list_populate_newsletter_callback') ) {

    /**
     * Populate newsletter shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_newsletter_callback($element_list) {
        $element_list['newsletter'] = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_edit_newsletter_element');
        return $element_list;
    }

    add_filter('wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_newsletter_callback');
}