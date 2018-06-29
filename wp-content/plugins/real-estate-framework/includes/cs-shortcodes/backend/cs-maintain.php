<?php
/*
 *
 * @File : Call to action
 * @retrun
 *
 */

if ( ! function_exists( 'wp_rem_cs_var_page_builder_maintenance' ) ) {

    function wp_rem_cs_var_page_builder_maintenance( $die = 0 ) {

        global $post, $wp_rem_cs_node, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_static_text;

        $shortcode_element = '';
        $filter_element = 'filterdrag';
        $shortcode_view = '';
        $output = array();
        $REM_BARBER_PREFIX = 'maintenance';
        $wp_rem_cs_counter = isset( $_POST['counter'] ) ? $_POST['counter'] : '';
        $parseObject = new ShortcodeParse();
        wp_rem_cs_var_date_picker();
        if ( isset( $_POST['action'] ) && ! isset( $_POST['shortcode_element_id'] ) ) {
            $REM_POSTID = '';
            $shortcode_element_id = '';
        } else {
            $REM_POSTID = $_POST['POSTID'];
            $shortcode_element_id = $_POST['shortcode_element_id'];
            $wp_rem_cs_var_shortcode_str = stripslashes( $shortcode_element_id );
            $output = $parseObject->wp_rem_cs_shortcodes( $output, $wp_rem_cs_var_shortcode_str, true, $REM_BARBER_PREFIX );
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_maintenance_time_left' => '',
            'wp_rem_cs_var_maintainance_logo_array' => '',
            'wp_rem_cs_var_maintainance_image_array' => '',
            'wp_rem_cs_var_lunch_date' => '',
        );
        if ( isset( $output['0']['atts'] ) ) {
            $atts = $output['0']['atts'];
        } else {
            $atts = array();
        }
        if ( isset( $output['0']['content'] ) )
            $maintenance_column_text = $output['0']['content'];
        else
            $maintenance_column_text = "";
        $maintenance_element_size = '100';
        foreach ( $defaults as $key => $values ) {
            if ( isset( $atts[$key] ) ) {
                $$key = $atts[$key];
            } else {
                $$key = $values;
            }
        }

        $name = 'wp_rem_cs_var_page_builder_maintenance';
        $coloumn_class = 'column_' . $maintenance_element_size;

        $wp_rem_cs_var_maintenance_image_url_array = isset( $wp_rem_cs_var_maintenance_image_url_array ) ? $wp_rem_cs_var_maintenance_image_url_array : '';
        $wp_rem_cs_var_call_action_subtitle = isset( $wp_rem_cs_var_call_action_subtitle ) ? $wp_rem_cs_var_call_action_subtitle : '';
        $wp_rem_cs_var_heading_color = isset( $wp_rem_cs_var_heading_color ) ? $wp_rem_cs_var_heading_color : '';
        $wp_rem_cs_var_maintenance_icon_background_color = isset( $wp_rem_cs_var_maintenance_icon_background_color ) ? $wp_rem_cs_var_maintenance_icon_background_color : '';
        $wp_rem_cs_var_maintenance_button_text = isset( $wp_rem_cs_var_maintenance_button_text ) ? $wp_rem_cs_var_maintenance_button_text : '';
        $wp_rem_cs_var_maintenance_button_link = isset( $wp_rem_cs_var_maintenance_button_link ) ? $wp_rem_cs_var_maintenance_button_link : '';
        $wp_rem_cs_var_contents_bg_color = isset( $wp_rem_cs_var_contents_bg_color ) ? $wp_rem_cs_var_contents_bg_color : '';
        $wp_rem_cs_var_maintenance_img_array = isset( $wp_rem_cs_var_maintenance_img_array ) ? $wp_rem_cs_var_maintenance_img_array : '';
        $wp_rem_cs_var_call_action_text_align = isset( $wp_rem_cs_var_call_action_text_align ) ? $wp_rem_cs_var_call_action_text_align : '';
        $wp_rem_cs_var_call_action_img_align = isset( $wp_rem_cs_var_call_action_img_align ) ? $wp_rem_cs_var_call_action_img_align : '';
        $wp_rem_cs_var_button_bg_color = isset( $wp_rem_cs_var_button_bg_color ) ? $wp_rem_cs_var_button_bg_color : '';
        $wp_rem_cs_var_button_border_color = isset( $wp_rem_cs_var_button_border_color ) ? $wp_rem_cs_var_button_border_color : '';

        if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
            $shortcode_element = 'shortcode_element_class';
            $shortcode_view = 'cs-pbwp-shortcode';
            $filter_element = 'ajax-drag';
            $coloumn_class = '';
        }
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        ?>
        <div id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>_del" class="column  parentdelete <?php echo esc_attr( $coloumn_class ); ?>
             <?php echo esc_attr( $shortcode_view ); ?>" item="maintenance" data="<?php echo wp_rem_cs_element_size_data_array_index( $maintenance_element_size ) ?>" >
                 <?php wp_rem_cs_element_setting( $name, $wp_rem_cs_counter, $maintenance_element_size ) ?>
            <div class="cs-wrapp-class-<?php echo intval( $wp_rem_cs_counter ) ?>
                 <?php echo esc_attr( $shortcode_element ); ?>" id="<?php echo esc_attr( $name . $wp_rem_cs_counter ) ?>" data-shortcode-template="[maintenance {{attributes}}]{{content}}[/maintenance]" style="display: none;">
                <div class="cs-heading-area" data-counter="<?php echo esc_attr( $wp_rem_cs_counter ) ?>">
                    <h5><?php echo esc_html( wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_edit_maintenance_page' ) ); ?></h5>
                    <a href="javascript:wp_rem_cs_frame_removeoverlay('<?php echo esc_js( $name . $wp_rem_cs_counter ) ?>','<?php echo esc_js( $filter_element ); ?>')" class="cs-btnclose">
                        <i class="icon-times"></i>
                    </a>
                </div> 
                <div class="cs-pbwp-content">
                    <div class="cs-wrapp-clone cs-shortcode-wrapp cs-pbwp-content">
                        <?php
                        if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) {
                            wp_rem_cs_shortcode_element_size();
                        }

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_maintenance_sc_text' ),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_maintenance_sc_text_hint' ),
                            'echo' => true,
                            'field_params' => array(
                                'std' => esc_attr( $maintenance_column_text ),
                                'cust_id' => 'maintenance_column_text' . $wp_rem_cs_counter,
                                'extra_atr' => ' data-content-text="cs-shortcode-textarea"',
                                'classes' => '',
                                'cust_name' => 'maintenance_column_text[]',
                                'return' => true,
                                'wp_rem_cs_editor' => true
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field( $wp_rem_cs_opt_array );

                        $wp_rem_cs_opt_array = array(
                            'std' => $wp_rem_cs_var_maintainance_logo_array,
                            'id' => 'maintainance_logo',
                            'main_id' => 'maintainance_logo_id',
                            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_logo' ),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_maintenance_sc_logo_hint' ),
                            'echo' => true,
                            'array' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_var_maintainance_logo_array,
                                'cust_id' => '',
                                'id' => 'maintainance_logo',
                                'return' => true,
                                'array' => true,
                                'array_txt' => false,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field( $wp_rem_cs_opt_array );
                        
                        $wp_rem_cs_opt_array = array(
                            'std' => $wp_rem_cs_var_maintainance_image_array,
                            'id' => 'maintainance_image',
                            'main_id' => 'maintainance_image_id',
                            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_image' ),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_maintenance_sc_image_hint' ),
                            'echo' => true,
                            'array' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_var_maintainance_image_array,
                                'cust_id' => '',
                                'id' => 'maintainance_image',
                                'return' => true,
                                'array' => true,
                                'array_txt' => false,
                            ),
                        );
                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field( $wp_rem_cs_opt_array );

                        $wp_rem_cs_opt_array = array(
                            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_maintenance_sc_launch_date' ),
                            'desc' => '',
                            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_maintenance_sc_launch_date_hint' ),
                            'echo' => true,
                            'field_params' => array(
                                'std' => $wp_rem_cs_var_lunch_date,
                                'cust_id' => 'wp_rem_cs_var_lunch_date' . $wp_rem_cs_counter,
                                'classes' => '',
                                'id' => 'lunch_date',
                                'cust_name' => 'wp_rem_cs_var_lunch_date[]',
                                'return' => true,
                            ),
                        );

                        $wp_rem_cs_var_html_fields->wp_rem_cs_var_date_field( $wp_rem_cs_opt_array );
                        ?>

                    </div>
                    <?php if ( isset( $_POST['shortcode_element'] ) && $_POST['shortcode_element'] == 'shortcode' ) { ?>

                        <ul class="form-elements insert-bg">
                            <li class="to-field">
                                <a class="insert-btn cs-main-btn" onclick="javascript:wp_rem_cs_shortcode_insert_editor('<?php echo str_replace( 'wp_rem_cs_var_page_builder_', '', $name ); ?>', '<?php echo esc_js( $name . $wp_rem_cs_counter ) ?>', '<?php echo esc_js( $filter_element ); ?>')" ><?php echo esc_html( wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_insert' ) ); ?></a>
                            </li>
                            <div id="results-shortocde"></div>
                            <?php
                        } else {
                            $wp_rem_cs_opt_array = array(
                                'std' => 'maintenance',
                                'id' => '',
                                'before' => '',
                                'after' => '',
                                'classes' => '',
                                'extra_atr' => '',
                                'cust_id' => 'wp_rem_cs_orderby',
                                'cust_name' => 'wp_rem_cs_orderby[]',
                                'return' => false,
                                'required' => false
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render( $wp_rem_cs_opt_array );

                            $wp_rem_cs_opt_array = array(
                                'name' => '',
                                'desc' => '',
                                'hint_text' => '',
                                'echo' => true,
                                'field_params' => array(
                                    'std' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_maintenance_sc_save' ),
                                    'cust_id' => '',
                                    'cust_type' => 'button',
                                    'classes' => 'cs-barber-admin-btn',
                                    'cust_name' => '',
                                    'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
                                    'return' => true,
                                ),
                            );

                            $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_opt_array );
                        }
                        ?>
                </div>
            </div>
        </div>

        <?php
        if ( $die <> 1 ) {
            die();
        }
    }

    add_action( 'wp_ajax_wp_rem_cs_var_page_builder_maintenance', 'wp_rem_cs_var_page_builder_maintenance' );
}

if ( ! function_exists( 'wp_rem_cs_save_page_builder_data_maintenance_callback' ) ) {

    /**
     * Save data for call to action shortcode.
     *
     * @param	array $args
     * @return	array
     */
    function wp_rem_cs_save_page_builder_data_maintenance_callback( $args ) {

        $data = $args['data'];
        $counters = $args['counters'];
        $widget_type = $args['widget_type'];
        $column = $args['column'];
        if ( $widget_type == "maintenance" || $widget_type == "cs_maintenance" ) {

            $shortcode = '';

            $page_element_size = $data['maintenance_element_size'][$counters['wp_rem_cs_global_counter_maintenance']];
            $cta_element_size = $data['maintenance_element_size'][$counters['wp_rem_cs_global_counter_maintenance']];

            if ( isset( $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] ) && $data['wp_rem_cs_widget_element_num'][$counters['wp_rem_cs_counter']] == 'shortcode' ) {
                $shortcode_str = stripslashes( ( $data['shortcode']['maintenance'][$counters['wp_rem_cs_shortcode_counter_maintenance']] ) );

                $element_settings = 'maintenance_element_size="' . $cta_element_size . '"';
                $reg = '/maintenance_element_size="(\d+)"/s';
                $shortcode_str = preg_replace( $reg, $element_settings, $shortcode_str );
                $shortcode_data .= $shortcode_str;

                $counters['wp_rem_cs_shortcode_counter_maintenance'] ++;
            } else {
                $shortcode = '[maintenance maintenance_element_size="' . htmlspecialchars( $data['maintenance_element_size'][$counters['wp_rem_cs_global_counter_maintenance']] ) . '" ';

                if ( isset( $data['wp_rem_cs_var_maintenance_time_left'][$counters['wp_rem_cs_counter_maintenance']] ) && $data['wp_rem_cs_var_maintenance_time_left'][$counters['wp_rem_cs_counter_maintenance']] != '' ) {
                    $shortcode .= 'wp_rem_cs_var_maintenance_time_left="' . htmlspecialchars( $data['wp_rem_cs_var_maintenance_time_left'][$counters['wp_rem_cs_counter_maintenance']], ENT_QUOTES ) . '" ';
                }
                if ( isset( $data['wp_rem_cs_var_maintainance_logo_array'][$counters['wp_rem_cs_counter_maintenance']] ) && $data['wp_rem_cs_var_maintainance_logo_array'][$counters['wp_rem_cs_counter_maintenance']] != '' ) {
                    $shortcode .= 'wp_rem_cs_var_maintainance_logo_array="' . stripslashes( htmlspecialchars( ($data['wp_rem_cs_var_maintainance_logo_array'][$counters['wp_rem_cs_counter_maintenance']] ), ENT_QUOTES ) ) . '" ';
                }
                if ( isset( $data['wp_rem_cs_var_maintainance_image_array'][$counters['wp_rem_cs_counter_maintenance']] ) && $data['wp_rem_cs_var_maintainance_image_array'][$counters['wp_rem_cs_counter_maintenance']] != '' ) {
                    $shortcode .= 'wp_rem_cs_var_maintainance_image_array="' . stripslashes( htmlspecialchars( ($data['wp_rem_cs_var_maintainance_image_array'][$counters['wp_rem_cs_counter_maintenance']] ), ENT_QUOTES ) ) . '" ';
                }
                if ( isset( $data['wp_rem_cs_var_lunch_date'][$counters['wp_rem_cs_counter_maintenance']] ) && $data['wp_rem_cs_var_lunch_date'][$counters['wp_rem_cs_counter_maintenance']] != '' ) {
                    $shortcode .= 'wp_rem_cs_var_lunch_date="' . htmlspecialchars( $data['wp_rem_cs_var_lunch_date'][$counters['wp_rem_cs_counter_maintenance']], ENT_QUOTES ) . '" ';
                }

                $shortcode .= '] ';
                if ( isset( $data['maintenance_column_text'][$counters['wp_rem_cs_counter_maintenance']] ) && $data['maintenance_column_text'][$counters['wp_rem_cs_counter_maintenance']] != '' ) {
                    $shortcode .= htmlspecialchars( $data['maintenance_column_text'][$counters['wp_rem_cs_counter_maintenance']], ENT_QUOTES ) . ' ';
                }
                $shortcode .= '[/maintenance]';
                $shortcode_data .= $shortcode;
                $counters['wp_rem_cs_counter_maintenance'] ++;
            }
            $counters['wp_rem_cs_global_counter_maintenance'] ++;
        }
        return array(
            'data' => $data,
            'counters' => $counters,
            'widget_type' => $widget_type,
            'column' => $shortcode_data,
        );
    }

    add_filter( 'wp_rem_cs_save_page_builder_data_maintenance', 'wp_rem_cs_save_page_builder_data_maintenance_callback' );
}

if ( ! function_exists( 'wp_rem_cs_load_shortcode_counters_maintenance_callback' ) ) {

    /**
     * Populate call to action shortcode counter variables.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_load_shortcode_counters_maintenance_callback( $counters ) {
        $counters['wp_rem_cs_counter_maintenance'] = 0;
        $counters['wp_rem_cs_shortcode_counter_maintenance'] = 0;
        $counters['wp_rem_cs_global_counter_maintenance'] = 0;
        return $counters;
    }

    add_filter( 'wp_rem_cs_load_shortcode_counters', 'wp_rem_cs_load_shortcode_counters_maintenance_callback' );
}
if ( ! function_exists( 'wp_rem_cs_shortcode_names_list_populate_maintenance_callback' ) ) {

    /**
     * Populate maintenance shortcode names list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_shortcode_names_list_populate_maintenance_callback( $shortcode_array ) {
        $shortcode_array['maintenance'] = array(
            'title' => 'Maintenance',
            'name' => 'maintenance',
            'icon' => 'fa icon-info-circle',
            'categories' => 'typography',
        );
        return $shortcode_array;
    }

    add_filter( 'wp_rem_cs_shortcode_names_list_populate', 'wp_rem_cs_shortcode_names_list_populate_maintenance_callback' );
}

if ( ! function_exists( 'wp_rem_cs_element_list_populate_maintenance_callback' ) ) {

    /**
     * Populate maintenance shortcode strings list.
     *
     * @param	array $counters
     * @return	array
     */
    function wp_rem_cs_element_list_populate_maintenance_callback( $element_list ) {
        $element_list['maintenance'] = 'Maintenance';
        return $element_list;
    }

    add_filter( 'wp_rem_cs_element_list_populate', 'wp_rem_cs_element_list_populate_maintenance_callback' );
}