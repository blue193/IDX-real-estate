<?php

/**
 * @Page options
 * @return html
 *
 */
if ( ! function_exists( 'wp_rem_cs_subheader_element' ) ) {

    function wp_rem_cs_subheader_element() {
        global $post, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_frame_static_text;
        $page_subheader_no_image = '';

        $wp_rem_cs_default_map = '[wp_rem_cs_map wp_rem_cs_var_map_element_title="Address Help" wp_rem_cs_var_sub_element_title="Map info" wp_rem_cs_var_map_height_title="300" wp_rem_cs_var_map_latitude_title="-0.127758" wp_rem_cs_var_map_longitude_title="51.507351" wp_rem_cs_var_info_text_title="info text" wp_rem_cs_var_info_width_title="300" wp_rem_cs_var_info_height_title="100" wp_rem_cs_var_map_zoom="9" wp_rem_cs_var_map_types="HYBRID" wp_rem_cs_var_show_marker="true" wp_rem_cs_var_disable_map="true" wp_rem_cs_var_drag_able="true" wp_rem_cs_var_scrol_wheel="true" wp_rem_cs_var_map_direction="true" ][/wp_rem_cs_map]';

        $wp_rem_cs_banner_style = get_post_meta( $post->ID, 'wp_rem_cs_header_banner_style', true );

        $wp_rem_cs_default_header = $wp_rem_cs_breadcrumb_header = $wp_rem_cs_custom_slider = $wp_rem_cs_map = $wp_rem_cs_no_header = 'hide';
        if ( isset( $wp_rem_cs_banner_style ) && $wp_rem_cs_banner_style == 'default_header' ) {
            $wp_rem_cs_default_header = 'show';
        } else if ( isset( $wp_rem_cs_banner_style ) && $wp_rem_cs_banner_style == 'breadcrumb_header' ) {
            $wp_rem_cs_breadcrumb_header = 'show';
        } else if ( isset( $wp_rem_cs_banner_style ) && $wp_rem_cs_banner_style == 'custom_slider' ) {
            $wp_rem_cs_custom_slider = 'show';
        } else if ( isset( $wp_rem_cs_banner_style ) && $wp_rem_cs_banner_style == 'map' ) {
            $wp_rem_cs_map = 'show';
        } else if ( isset( $wp_rem_cs_banner_style ) && $wp_rem_cs_banner_style == 'no-header' ) {
            $wp_rem_cs_no_header = 'show';
        } else {
            $wp_rem_cs_default_header = 'show';
        }

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_choose_subheader' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => 'default_header',
                'id' => 'header_banner_style',
                'return' => true,
                'extra_atr' => 'onchange="wp_rem_cs_header_element_toggle(this.value)"',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'default_header' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_default_subheader' ),
                    'breadcrumb_header' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_custom_subheader' ),
                    'custom_slider' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_rev_slider' ),
                    'map' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_map' ),
                    'no-header' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_no_subheader' )
                ),
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_var_opt_array );


        $wp_rem_cs_var_opt_array = array(
            'id' => 'custom_header',
            'enable_id' => 'wp_rem_cs_var_header_banner_style',
            'enable_val' => 'breadcrumb_header',
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_style' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => 'simple',
                'id' => 'sub_header_style',
                'return' => true,
                'extra_atr' => 'onchange="wp_rem_cs_var_page_subheader_style(this.value)"',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'classic' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_classic' ),
                    'with_bg' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_with_image' ),
                ),
            ),
        );

        //$wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_var_opt_array);

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_padding_top' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_padding_top_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_padding_top',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_padding_bot' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_padding_bot_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_padding_bottom',
                'return' => true,
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_margin_top' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_margin_top_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_margin_top',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_margin_bot' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_margin_bot_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'subheader_margin_bottom',
                'return' => true,
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_title' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_title_switch',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_sub_header_align' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => 'left',
                'id' => 'sub_header_align',
                'return' => true,
                'extra_atr' => '',
                'classes' => 'dropdown chosen-select',
                'options' => array(
                    'left' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_align_left' ),
                    'center' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_align_center' ),
                    'right' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_align_right' ),
					'bottom' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_align_bottom' ),
                ),
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_var_opt_array );


        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_text_color' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_text_color_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheader_text_color',
                'classes' => 'bg_color',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'id' => 'subheader_with_bc',
            'enable_id' => 'wp_rem_cs_var_sub_header_style',
            'enable_val' => 'classic',
        );
        //$wp_rem_cs_var_html_fields->wp_rem_cs_var_division($wp_rem_cs_var_opt_array);
        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_breadcrumbs' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_breadcrumbs',
                'return' => true,
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field( $wp_rem_cs_var_opt_array );
        //$wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close(array());

        $wp_rem_cs_var_opt_array = array(
            'id' => 'subheader_with_bg',
            'enable_id' => 'wp_rem_cs_var_sub_header_style',
            'enable_val' => 'with_bg',
        );
        //$wp_rem_cs_var_html_fields->wp_rem_cs_var_division($wp_rem_cs_var_opt_array);

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_sub_heading' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_sub_heading_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheading_title',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_bg_image' ),
            'id' => 'header_banner_image',
            'main_id' => '',
            'std' => '',
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_bg_image_hint' ),
            'prefix' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'header_banner_image',
                'prefix' => '',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_upload_file_field( $wp_rem_cs_opt_array );

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_parallax' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_parallax_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheader_parallax',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field( $wp_rem_cs_var_opt_array );

        //$wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close(array());

        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_bg_color' ),
            'desc' => '',
            'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_bg_color_hint' ),
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_subheader_color',
                'classes' => 'bg_color',
                'return' => true,
            ),
        );
		$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );
		
		$wp_rem_cs_var_opt_array = array(
            'id' => 'default_breacrumb_bg_color',
            'enable_id' => 'wp_rem_cs_var_sub_header_align',
            'enable_val' => 'bottom',
        );
		$wp_rem_cs_var_html_fields->wp_rem_cs_var_division( $wp_rem_cs_var_opt_array );
			$wp_rem_cs_var_opt_array = array(
				'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_breadcrumb_bg_color' ),
				'desc' => '',
				'hint_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_breadcrumb_bg_color_hint' ),
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'breadcrumb_bg_color',
					'classes' => 'bg_color',
					'return' => true,
				),
			);
			$wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );
		$wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close( array() );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close( array() );

        $wp_rem_cs_var_opt_array = array(
            'id' => 'rev_slider_header',
            'enable_id' => 'wp_rem_cs_var_header_banner_style',
            'enable_val' => 'custom_slider',
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_slider_value = get_post_meta( $post->ID, 'wp_rem_cs_var_custom_slider_id', true );
        $wp_rem_cs_slider_options = '<option value="">' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_slider' ) . '</option>';

        if ( class_exists( 'RevSlider' ) && class_exists( 'wp_rem_cs_var_RevSlider' ) ) {

            $slider = new wp_rem_cs_var_RevSlider();
            $arrSliders = $slider->getAllSliderAliases();

            if ( is_array( $arrSliders ) ) {
                foreach ( $arrSliders as $key => $entry ) {
                    $wp_rem_cs_slider_selected = '';
                    if ( $wp_rem_cs_slider_value != '' ) {
                        if ( $wp_rem_cs_slider_value == $entry['alias'] ) {
                            $wp_rem_cs_slider_selected = ' selected="selected"';
                        }
                    }
                    $wp_rem_cs_slider_options .= '<option ' . $wp_rem_cs_slider_selected . ' value="' . $entry['alias'] . '">' . $entry['title'] . '</option>';
                }
            }
        }

        $wp_rem_cs_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_slider' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'custom_slider_id',
                'classes' => 'dropdown chosen-select',
                'return' => true,
                'options_markup' => true,
                'options' => $wp_rem_cs_slider_options,
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );



        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close( array() );


        $wp_rem_cs_var_opt_array = array(
            'id' => 'map_header',
            'enable_id' => 'wp_rem_cs_var_header_banner_style',
            'enable_val' => 'map',
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division( $wp_rem_cs_var_opt_array );


        $wp_rem_cs_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_map_sc' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => $wp_rem_cs_default_map,
                'id' => 'custom_map',
                'classes' => '',
                'return' => true,
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_textarea_field( $wp_rem_cs_opt_array );


        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close( array() );

        $wp_rem_cs_var_opt_array = array(
            'id' => 'no_header',
            'enable_id' => 'wp_rem_cs_var_header_banner_style',
            'enable_val' => 'no-header',
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division( $wp_rem_cs_var_opt_array );


//        $wp_rem_cs_var_opt_array = array(
//            'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_header_border'),
//            'desc' => '',
//            'hint_text' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_header_hint'),
//            'echo' => true,
//            'field_params' => array(
//                'std' => '',
//                'id' => 'main_header_border_color',
//                'classes' => 'bg_color',
//                'return' => true,
//            ),
//        );
//
//        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field($wp_rem_cs_var_opt_array);
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close( array() );
        ?>
        <script>
            jQuery(document).ready(function () {
                chosen_selectionbox();
            });
        </script>
        <?php

    }

}

/**
 * @Sidebar Layout setting start
 * @return
 *
 */
if ( class_exists( 'RevSlider' ) && ! class_exists( 'wp_rem_cs_var_RevSlider' ) ) {

    class wp_rem_cs_var_RevSlider extends RevSlider {
        /*
         * Get sliders alias, Title, ID
         */

        public function getAllSliderAliases() {
            $where = "";
            $response = $this->db->fetch( GlobalsRevSlider::$table_sliders, $where, "id" );
            $arrAliases = array();
            $slider_array = array();
            foreach ( $response as $arrSlider ) {
                $arrAliases['id'] = $arrSlider["id"];
                $arrAliases['title'] = $arrSlider["title"];
                $arrAliases['alias'] = $arrSlider["alias"];
                $slider_array[] = $arrAliases;
            }
            return($slider_array);
        }

    }

}
if ( ! function_exists( 'wp_rem_cs_sidebar_layout_options' ) ) {

    function wp_rem_cs_sidebar_layout_options() {
        global $post, $pagenow, $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_frame_static_text;

        // if (isset($post->post_type) && $post->post_type == 'page') {
//            $wp_rem_cs_var_opt_array = array(
//                'name' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_header_style'),
//                'desc' => '',
//                'hint_text' => '',
//                'echo' => true,
//                'field_params' => array(
//                    'std' => 'default_header_style',
//                    'id' => 'header_style',
//                    'return' => true,
//                    'classes' => 'dropdown chosen-select',
//                    'extra_atr' => 'onclick="wp_rem_cs_header_element_toggle(this.value)"',
//                    'options' => array(
//                        'modern_header_style' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_modern_header'),
//                        'default_header_style' => wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_default_header')
//                    ),
//                ),
//            );
//
//
//            $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field($wp_rem_cs_var_opt_array);
//        }
        $wp_rem_cs_sidebars_array = array( '' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_side_bar' ) );
        if ( isset( $wp_rem_cs_var_options['wp_rem_cs_var_sidebar'] ) && is_array( $wp_rem_cs_var_options['wp_rem_cs_var_sidebar'] ) && sizeof( $wp_rem_cs_var_options['wp_rem_cs_var_sidebar'] ) > 0 ) {
            foreach ( $wp_rem_cs_var_options['wp_rem_cs_var_sidebar'] as $key => $sidebar ) {
                $wp_rem_cs_sidebars_array[sanitize_title( $sidebar )] = $sidebar;
            }
        }
        $bg_color = get_post_meta( get_the_id(), 'wp_rem_cs_var_page_bg_color', true );
        $container_switch = get_post_meta( get_the_id(), 'wp_rem_cs_var_page_container_switch', true );
        $container_switch  = ( isset( $container_switch ) && $container_switch != '' )? $container_switch : 'on';
        $page_pg_val = isset( $bg_color[0] ) ? $bg_color[0] : '';
        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_bg_color' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => $page_pg_val,
                'id' => 'page_bg_color',
                'classes' => 'bg_color',
                'cust_name' => 'wp_rem_cs_var_page_bg_color',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_text_field( $wp_rem_cs_var_opt_array );
        
        $wp_rem_cs_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_header_style',
                'classes' => 'dropdown chosen-select',
                'return' => true,
                'options' => array(
                    ''=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_default' ),
                    'modern'=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_moderm' ),
                    'classic'=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_classic' ),
                    'fancy'=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_fancy' ),
                    'default'=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_default_v2' ),
                    'advance'=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_advance' ),
                    'advance_v2'=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_advance_v2' ),
                    'modern_v2'=>wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_header_view_modern_v2' ),
                    
                ),
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
        
        
        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_margin' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_margin_switch',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field( $wp_rem_cs_var_opt_array );
        
        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_container' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => $container_switch,
                'id' => 'page_container_switch',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field( $wp_rem_cs_var_opt_array );
        
        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_hide_header' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_header_hidden',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field( $wp_rem_cs_var_opt_array );
        
        $wp_rem_cs_var_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_page_hide_footer' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_footer_hidden',
                'return' => true,
            ),
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_checkbox_field( $wp_rem_cs_var_opt_array );

        $wp_rem_cs_var_html_fields->wp_rem_cs_form_layout_render(
                array( 'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_choose_sidebar' ),
                    'id' => 'page_layout',
                    'std' => 'none',
                    'classes' => '',
                    'description' => '',
                    'onclick' => '',
                    'status' => '',
                    'meta' => '',
                    'help_text' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_sidebar_hint' )
                )
        );

        $wp_rem_cs_var_opt_array = array(
            'id' => 'left_layout',
            'enable_id' => 'wp_rem_cs_var_page_layout',
            'enable_val' => 'left',
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division( $wp_rem_cs_var_opt_array );


        $wp_rem_cs_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_left_sidebar' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_sidebar_left',
                'classes' => 'dropdown chosen-select',
                'return' => true,
                'options' => $wp_rem_cs_sidebars_array,
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );


        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close( array() );


        $wp_rem_cs_var_opt_array = array(
            'id' => 'right_layout',
            'enable_id' => 'wp_rem_cs_var_page_layout',
            'enable_val' => 'right',
        );

        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division( $wp_rem_cs_var_opt_array );


        $wp_rem_cs_opt_array = array(
            'name' => wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_right_sidebar' ),
            'desc' => '',
            'hint_text' => '',
            'echo' => true,
            'field_params' => array(
                'std' => '',
                'id' => 'page_sidebar_right',
                'classes' => 'dropdown chosen-select',
                'return' => true,
                'options' => $wp_rem_cs_sidebars_array,
            ),
        );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_select_field( $wp_rem_cs_opt_array );
        $wp_rem_cs_var_html_fields->wp_rem_cs_var_division_close( array() );

        // Extra Layouts
        $cs_extra_layouts = false;
        if ( $pagenow == 'post.php' && get_post_type() == 'page' ) {
            $cs_extra_layouts = true;
        }
        ?>
        <script>
            jQuery(document).ready(function () {
                chosen_selectionbox();
            });
        </script>
        <?php

    }

}