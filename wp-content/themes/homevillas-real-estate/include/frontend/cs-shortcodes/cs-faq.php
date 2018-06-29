<?php

/*
 *
 * @Shortcode Name : Accordion
 * @retrun
 *
 */
if ( ! function_exists( 'wp_rem_cs_faq_shortcode' ) ) {

    function wp_rem_cs_faq_shortcode( $atts, $content = "" ) {

        global $acc_counter, $wp_rem_cs_var_faq_view;
        $acc_counter = rand( 40, 9999999 );

        $html = '';
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_faq_view' => '',
            'wp_rem_cs_var_faq_sub_title' => '',
            'wp_rem_cs_var_faq_main_subtitle' => '',
            'wp_rem_cs_var_faq_main_title' => '',
            'wp_rem_var_faq_align' => ''
        );
        extract( shortcode_atts( $defaults, $atts ) );
        
        $column_class = '';
        $wp_rem_cs_var_faq_view = isset( $wp_rem_cs_var_faq_view ) ? $wp_rem_cs_var_faq_view : '';
        $wp_rem_cs_var_column_size = isset( $wp_rem_cs_var_column_size ) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_faq_main_title = isset( $wp_rem_cs_var_faq_main_title ) ? $wp_rem_cs_var_faq_main_title : '';
        $wp_rem_cs_var_faq_sub_title = isset( $wp_rem_cs_var_faq_sub_title ) ? $wp_rem_cs_var_faq_sub_title : '';
        $faq_classs = '';
        if($wp_rem_cs_var_faq_view == 'modern'){
            $faq_classs = ' modern'; 
        }
        
        if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
            }
        }
        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '<div class="' . esc_html( $column_class ) . '">';
        }
        $html .= wp_rem_title_sub_align($wp_rem_cs_var_faq_main_title, $wp_rem_cs_var_faq_main_subtitle, $wp_rem_var_faq_align);
        $html .= '<div class="faq panel-group " id="faq_' . absint( $acc_counter ) . '">';
        $html .= do_shortcode( $content );
        $html .= '</div>';

        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '</div>';
        }
        $page_element_size  = isset( $atts['faq_element_size'] )? $atts['faq_element_size'] : 100;
        return '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' "><div class="faqs'.$faq_classs.'">'.wp_rem_cs_allow_special_char($html).'</div></div>';
        
        
    }

    if ( function_exists( 'wp_rem_cs_short_code' ) ) {
        wp_rem_cs_short_code( 'wp_rem_cs_faq', 'wp_rem_cs_faq_shortcode' );
    }
}
if ( function_exists( 'wp_rem_cs_var_short_code' ) )
    wp_rem_cs_var_short_code( 'wp_rem_cs_faq', 'wp_rem_cs_faq_shortcode' );
/*
 *
 * @Accordion Item
 * @retrun
 *
 */
if ( ! function_exists( 'wp_rem_cs_faq_item_shortcode' ) ) {

    function wp_rem_cs_faq_item_shortcode( $atts, $content = "" ) {
        global $acc_counter, $wp_rem_cs_var_faq_view;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $defaults = array(
            'wp_rem_cs_var_faq_title' => 'Title',
            'wp_rem_cs_var_icon_box' => '',
            'wp_rem_cs_var_icon_box_group' => 'default',
            'wp_rem_cs_var_faq_active' => 'yes',
        );
        extract( shortcode_atts( $defaults, $atts ) );
        $wp_rem_cs_var_acc_icon = '';
        $wp_rem_cs_var_faq_title = isset( $wp_rem_cs_var_faq_title ) ? $wp_rem_cs_var_faq_title : '';
        $wp_rem_cs_var_icon_box = isset( $wp_rem_cs_var_icon_box ) ? $wp_rem_cs_var_icon_box : '';
        $wp_rem_cs_var_faq_active = isset( $wp_rem_cs_var_faq_active ) ? $wp_rem_cs_var_faq_active : '';

        if ( isset( $wp_rem_cs_var_icon_box ) && $wp_rem_cs_var_icon_box != '' ) {
             wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_icon_box_group );
            $wp_rem_cs_var_acc_icon .= '<i class="' . esc_html ( $wp_rem_cs_var_icon_box ) . '"></i>';
        }
       
        $faq_count = 0;
        $faq_count = rand( 4045, 99999 );
        $html = '';
        $active_in = '';
        $active_class = '';
        $styleColapse = 'collapsed';
        if ( isset( $wp_rem_cs_var_faq_active ) && $wp_rem_cs_var_faq_active == 'yes' ) {
            $active_in = 'in';
            $styleColapse = '';
        } else {
            $active_class = 'collapsed';
        }

        $html .= ' <div class="panel">';
        $html .= '  <div class="panel-heading">';
        $html .= '   <strong class="panel-title">';
        $html .= '<a class="' . esc_html( $active_class ) . '" data-toggle="collapse" data-parent="#faq_' . absint( $acc_counter ) . '" href="#collapse' . absint( $faq_count ) . '">' . $wp_rem_cs_var_acc_icon . esc_html( $wp_rem_cs_var_faq_title ) . '</a>';
        $html .= '   </strong>';
        $html .= ' </div>';
        $html .= '  <div id="collapse' . absint( $faq_count ) . '" class="panel-collapse collapse ' . esc_html( $active_in ) . '"	>';
        $html .= '     <div class="panel-body">' . do_shortcode( $content ) . '</div>';
        $html .= ' </div>';
        $html .= '</div>
		
		';
        return $html;
    }

    if ( function_exists( 'wp_rem_cs_short_code' ) ) {
        wp_rem_cs_short_code( 'faq_item', 'wp_rem_cs_faq_item_shortcode' );
    }
}
if ( function_exists( 'wp_rem_cs_var_short_code' ) )
    wp_rem_cs_var_short_code( 'faq_item', 'wp_rem_cs_faq_item_shortcode' );
