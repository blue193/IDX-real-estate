<?php

/*
 *
 * @Shortcode Name : Accordion
 * @retrun
 *
 */
if ( ! function_exists( 'wp_rem_cs_accordion_shortcode' ) ) {

    function wp_rem_cs_accordion_shortcode( $atts, $content = "" ) {

        $html = '';
        $page_element_size  = isset( $atts['accordion_element_size'] )? $atts['accordion_element_size'] : 100;
        if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
            $html   .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        global $acc_counter, $wp_rem_cs_var_accordion_column;
        $acc_counter = rand( 40, 9999999 );

        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_accordion_view' => '',
            'wp_rem_cs_var_accordion_column' => '',
            'wp_rem_cs_var_accordian_main_subtitle' => '',
            'wp_rem_cs_var_accordian_sub_title' => '',
            'wp_rem_cs_var_accordian_main_title' => '',
            'wp_rem_var_accordion_align' => '',
        );
        extract( shortcode_atts( $defaults, $atts ) );

        $column_class = '';
        $wp_rem_cs_var_accordion_view = isset( $wp_rem_cs_var_accordion_view ) ? $wp_rem_cs_var_accordion_view : '';
        $wp_rem_cs_var_column_size = isset( $wp_rem_cs_var_column_size ) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_accordian_main_title = isset( $wp_rem_cs_var_accordian_main_title ) ? $wp_rem_cs_var_accordian_main_title : '';
        $wp_rem_cs_var_accordian_sub_title = isset( $wp_rem_cs_var_accordian_sub_title ) ? $wp_rem_cs_var_accordian_sub_title : '';
        $wp_rem_cs_var_counter_col = isset( $wp_rem_cs_var_accordion_column ) ? $wp_rem_cs_var_accordion_column : '';

        if ( isset( $wp_rem_cs_var_counter_col ) && $wp_rem_cs_var_counter_col != '' ) {
            $number_col = 12 / $wp_rem_cs_var_counter_col;
            $number_col_sm = 12;
            $number_col_xs = 12;
            if ( $number_col == 2 ) {
                $number_col_sm = 4;
                $number_col_xs = 6;
            }
            if ( $number_col == 3 ) {
                $number_col_sm = 6;
                $number_col_xs = 12;
            }
            if ( $number_col == 4 ) {
                $number_col_sm = 6;
                $number_col_xs = 12;
            }
            if ( $number_col == 6 ) {
                $number_col_sm = 12;
                $number_col_xs = 12;
            }
            $col_class = 'col-lg-' . esc_html($number_col) . ' col-md-' . esc_html($number_col) . ' col-sm-' . esc_html($number_col_sm) . ' col-xs-' . esc_html($number_col_xs) . '';
        }
        if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
            }
        }
        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '<div class="' . esc_html( $column_class ) . '">';
        }
        $boxex_class = ' simple';
        if ( isset( $wp_rem_cs_var_accordion_view ) && $wp_rem_cs_var_accordion_view == 'modern' ) {
            $boxex_class = ' modern';
        }
        $html .= wp_rem_title_sub_align($wp_rem_cs_var_accordian_main_title, $wp_rem_cs_var_accordian_main_subtitle, $wp_rem_var_accordion_align);
        $html .= '<div class="panel-group ' . esc_attr($boxex_class) . '" id="accordion_' . absint( esc_html($acc_counter) ) . '" role="tablist" aria-multiselectable="true">';
        $html .= do_shortcode( $content );
        $html .= '</div>';



        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '</div>';
        }
         if (function_exists('wp_rem_cs_var_page_builder_element_sizes')) {
           $html    .=  '</div>';
        }
        return $html;
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) ) {
        wp_rem_cs_var_short_code( 'wp_rem_cs_accordion', 'wp_rem_cs_accordion_shortcode' );
    }
}

/*
 *
 * @Accordion Item
 * @retrun
 *
 */
if ( ! function_exists( 'wp_rem_cs_accordion_item_shortcode' ) ) {

    function wp_rem_cs_accordion_item_shortcode( $atts, $content = "" ) {
        global $acc_counter;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $defaults = array(
            'wp_rem_cs_var_accordion_title' => 'Title',
            'wp_rem_cs_var_icon_box' => '',
            'wp_rem_cs_var_icon_box_group' => 'default',
            'wp_rem_cs_var_accordion_active' => 'yes',
        );
        extract( shortcode_atts( $defaults, $atts ) );
        $wp_rem_cs_var_acc_icon = '';
        $wp_rem_cs_var_accordion_title = isset( $wp_rem_cs_var_accordion_title ) ? $wp_rem_cs_var_accordion_title : '';
        $wp_rem_cs_var_icon_box = isset( $wp_rem_cs_var_icon_box ) ? $wp_rem_cs_var_icon_box : '';
        $wp_rem_cs_var_accordion_active = isset( $wp_rem_cs_var_accordion_active ) ? $wp_rem_cs_var_accordion_active : '';

        if ( isset( $wp_rem_cs_var_icon_box ) && $wp_rem_cs_var_icon_box != '' ) {
            wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_icon_box_group );
            $wp_rem_cs_var_acc_icon = '<i class="' . esc_attr($wp_rem_cs_var_icon_box) . '"></i>';
        }

        $accordion_count = 0;
        $accordion_count = rand( 4045, 99999 );
        $html = '';
        $active_in = '';
        $active_class = '';
        $styleColapse = 'collapsed';
        if ( isset( $wp_rem_cs_var_accordion_active ) && $wp_rem_cs_var_accordion_active == 'yes' ) {
            $active_in = 'in';
            $styleColapse = '';
        } else {
            $active_class = 'collapsed';
        }
        $html .= ' <div class="panel panel-default">';
        $html .= '  <div class="panel-heading" role="tab" id="heading_' . absint( esc_html($accordion_count) ) . '">';
        $html .= '   <h6 class="panel-title">';
        $html .= '<a  role="button" class="' . esc_html( $active_class ) . '" data-toggle="collapse" data-parent="#accordion_' . absint( esc_html($acc_counter) ) . '" href="#collapse' . absint( esc_html($accordion_count) ) . '">' . ($wp_rem_cs_var_acc_icon) . esc_html( $wp_rem_cs_var_accordion_title ) . '</a>';
        $html .= '   </h6>';
        $html .= ' </div>';
        $html .= '  <div id="collapse' . absint( esc_html($accordion_count) ) . '" class="panel-collapse collapse ' . esc_html( $active_in ) . '"	role="tabpanel" aria-labelledby="heading_' . absint( esc_html($accordion_count) ) . '">';
        $html .= '     <div class="panel-body">' . do_shortcode( wp_rem_cs_allow_special_char($content) ) . '</div>';
        $html .= ' </div>';
        $html .= '</div>
		';
        return wp_rem_cs_allow_special_char($html);
    }

    if ( function_exists( 'wp_rem_cs_var_short_code' ) ) {
        wp_rem_cs_var_short_code( 'accordion_item', 'wp_rem_cs_accordion_item_shortcode' );
    }
}