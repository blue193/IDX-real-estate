<?php

/*
 * @Shortcode Name :   Start function for Counter shortcode/element front end view
 */
if ( ! function_exists('wp_rem_cs_counters_shortcode') ) {

    function wp_rem_cs_counters_shortcode($atts, $content = null) {
        global $post, $wp_rem_cs_var_counter_col, $wp_rem_cs_var_icon_color, $wp_rem_cs_var_count_color, $wp_rem_cs_var_content_color, $wp_rem_cs_var_counters_view,$wp_rem_cs_var_icon_title_color;
        wp_enqueue_script('wp-rem-counter');
        $defaults = array(
            'wp_rem_cs_var_column_size' => '1/1',
            'wp_rem_cs_counter_title' => '',
            'wp_rem_cs_counter_subtitle' => '',
            'wp_rem_var_counter_align' => '',
            'wp_rem_cs_multi_counter_sub_title' => '',
            'wp_rem_cs_var_counter_col' => '',
            'wp_rem_cs_var_icon_color' => '',
            'wp_rem_cs_var_count_color' => '',
            'wp_rem_cs_var_content_color' => '',
            'wp_rem_cs_var_counters_view' => '',
            'wp_rem_cs_var_icon_title_color'=>'',
        );
        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_section_title = '';
        $wp_rem_cs_var_column_size = '';
        $wp_rem_cs_counter_title = isset($wp_rem_cs_counter_title) ? $wp_rem_cs_counter_title : '';
        $wp_rem_cs_multi_counter_sub_title = isset($wp_rem_cs_multi_counter_sub_title) ? $wp_rem_cs_multi_counter_sub_title : '';
        $wp_rem_cs_var_counter_col = isset($wp_rem_cs_var_counter_col) ? $wp_rem_cs_var_counter_col : '';
        $wp_rem_cs_var_counters_view = isset($wp_rem_cs_var_counters_view) ? $wp_rem_cs_var_counters_view : '';



        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        $wp_rem_cs_var_counter = '';
        $page_element_size = isset($atts['counter_element_size']) ? $atts['counter_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_counter .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }

        if ( isset($column_class) && $column_class <> '' ) {
            $wp_rem_cs_var_counter .= '<div class="' . esc_html($column_class) . '">';
        }
        $wp_rem_cs_section_title .= wp_rem_title_sub_align($wp_rem_cs_counter_title, $wp_rem_cs_counter_subtitle, $wp_rem_var_counter_align);
        $wp_rem_cs_var_counter .= $wp_rem_cs_section_title;

        if ( $wp_rem_cs_var_counters_view == 'modern' ) {
            $wp_rem_cs_var_counter .= '<div class="counter-holder ">';
            $wp_rem_cs_var_counter .= '<div class="row">';
        } elseif ( $wp_rem_cs_var_counters_view == 'classic' ) {
            $wp_rem_cs_var_counter .= '<div class="counter-holder">';
            $wp_rem_cs_var_counter .= '<div class="row">';
        } elseif ( $wp_rem_cs_var_counters_view == 'classic_v2' ) {
            $wp_rem_cs_var_counter .= '<div class="counter-holder">';
            $wp_rem_cs_var_counter .= '<div class="row">';
        }  else {
            $wp_rem_cs_var_counter .= ' <div class="counter-sec counter-shortcode">';
            $wp_rem_cs_var_counter .= '<div class="row">';
        }
        $wp_rem_cs_var_counter .= do_shortcode($content);

        if ( $wp_rem_cs_var_counters_view == 'modern' ) {
            $wp_rem_cs_var_counter .= ' </div>';
            $wp_rem_cs_var_counter .= ' </div>';
        } elseif ( $wp_rem_cs_var_counters_view == 'classic' ) {
            $wp_rem_cs_var_counter .= ' </div>';
            $wp_rem_cs_var_counter .= ' </div>';
        } elseif ( $wp_rem_cs_var_counters_view == 'classic_v2' ) {
            $wp_rem_cs_var_counter .= ' </div>';
            $wp_rem_cs_var_counter .= ' </div>';
        } else {
            $wp_rem_cs_var_counter .= ' </div>';
            $wp_rem_cs_var_counter .= ' </div>';
        }

        if ( isset($column_class) && $column_class <> '' ) {
            $wp_rem_cs_var_counter .= '</div>'; // close column class
        }
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_counter .= '</div>'; // close page element size 
        }
        return $wp_rem_cs_var_counter;
    }

}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('counter', 'wp_rem_cs_counters_shortcode');

/*
 * @Shortcode Name :  Start function for counter Item
 */
if ( ! function_exists('wp_rem_cs_counter_item') ) {

    function wp_rem_cs_counter_item($atts, $content = null) {
        global $post, $wp_rem_cs_var_counter_col, $wp_rem_cs_var_icon_color, $wp_rem_cs_var_count_color, $wp_rem_cs_var_content_color, $wp_rem_cs_var_counters_view,$wp_rem_cs_var_icon_title_color;
        $col_class = '';
        if ( isset($wp_rem_cs_var_counter_col) && $wp_rem_cs_var_counter_col != '' ) {
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
            $col_class = 'col-lg-' . $number_col . ' col-md-' . $number_col . ' col-sm-' . $number_col_sm . ' col-xs-' . $number_col_xs . '';
        }
        $wp_rem_cs_var_counter_item = '';
        $defaults = array(
            'wp_rem_cs_var_icon' => '',
            'wp_rem_cs_var_icon_group' => '',
            'wp_rem_cs_var_count' => '',
            'wp_rem_cs_var_title' => ''
        );

        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_icon = isset($wp_rem_cs_var_icon) ? $wp_rem_cs_var_icon : '';
        $wp_rem_cs_var_count = isset($wp_rem_cs_var_count) ? $wp_rem_cs_var_count : '';
        $wp_rem_cs_var_icon_color = isset($wp_rem_cs_var_icon_color) ? $wp_rem_cs_var_icon_color : '';
        $wp_rem_cs_var_count_color = isset($wp_rem_cs_var_count_color) ? $wp_rem_cs_var_count_color : '';
        $wp_rem_cs_var_content_color = isset($wp_rem_cs_var_content_color) ? $wp_rem_cs_var_content_color : '';
        $wp_rem_cs_var_title = isset($wp_rem_cs_var_title) ? $wp_rem_cs_var_title : '';
        $wp_rem_cs_var_content = $content;
        $counter_color = '';
        if( isset($wp_rem_cs_var_count_color) && !empty($wp_rem_cs_var_count_color)){
            $counter_color = ' style="color:'.$wp_rem_cs_var_count_color.' ! important"';
        }
        
        $counter_title_color = '';
        if( isset($wp_rem_cs_var_icon_title_color) && !empty($wp_rem_cs_var_icon_title_color)){
            $counter_title_color = ' style="color:'.$wp_rem_cs_var_icon_title_color.' ! important"';
        }
        
        
        
        $wp_rem_cs_var_counter_item .= '<div class="' . esc_html($col_class) . '">';
        if ( isset($wp_rem_cs_var_counters_view) && $wp_rem_cs_var_counters_view == 'default' ) {
            $wp_rem_cs_var_counter_item .= '<div class="counter-holder">';
            $wp_rem_cs_var_counter_item .= '<div class="text-holder">';
            if ( isset($wp_rem_cs_var_icon) && $wp_rem_cs_var_icon != '' ) {
                 wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_icon_group );
                $wp_rem_cs_var_counter_item .= '<i style="color:' . esc_html($wp_rem_cs_var_icon_color) . ' !important" class="' . esc_html($wp_rem_cs_var_icon) . '"></i>';
            }
            $wp_rem_cs_var_counter_item .= '<strong class="custom-counter" style="color:' . ($wp_rem_cs_var_count_color) . ' !important" class="count">' . esc_html(($wp_rem_cs_var_count)) . '</strong>';
            if ( $wp_rem_cs_var_title <> '' ) {
                $wp_rem_cs_var_counter_item .= '<span>' . esc_html($wp_rem_cs_var_title) . '</span>';
            }
            if ( $content != '' ) {
                $wp_rem_cs_var_counter_item .= '<p>' . wp_rem_cs_allow_special_char($content) . '</p>';
            }
            $wp_rem_cs_var_counter_item .= '</div>';
            $wp_rem_cs_var_counter_item .= '</div>';
        } elseif ( $wp_rem_cs_var_counters_view == 'classic' ) {

            $wp_rem_cs_var_counter_item .=' <div class="cs-counter default">';
            if ( isset($wp_rem_cs_var_icon) && $wp_rem_cs_var_icon != '' ) {
                wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_icon_group );
                $wp_rem_cs_var_counter_item .= '<div class="img-holder">';
                $wp_rem_cs_var_counter_item .= '<i class="' . esc_html($wp_rem_cs_var_icon) . '"></i>';
                $wp_rem_cs_var_counter_item .= '</div>';
            }
            $wp_rem_cs_var_counter_item .= '<div class="text-holder">';

            if ( $wp_rem_cs_var_count <> '' ) {
                $wp_rem_cs_var_counter_item .= '<strong class="counter custom-counter">' . $wp_rem_cs_var_count . '</strong>';
            }
            if ( $wp_rem_cs_var_title <> '' ) {
                $wp_rem_cs_var_counter_item .= '<span>' . esc_html($wp_rem_cs_var_title) . '</span>';
            }
            $wp_rem_cs_var_counter_item .= ' </div>
                                </div>';
        } elseif ( $wp_rem_cs_var_counters_view == 'classic_v2' ) {

            $wp_rem_cs_var_counter_item .=' <div class="cs-counter default top-center">';
            if ( isset($wp_rem_cs_var_icon) && $wp_rem_cs_var_icon != '' ) {
                wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_icon_group );
                $wp_rem_cs_var_counter_item .= '<div class="img-holder">';
                $wp_rem_cs_var_counter_item .= '<i class="' . esc_html($wp_rem_cs_var_icon) . '"></i>';
                $wp_rem_cs_var_counter_item .= '</div>';
            }
            $wp_rem_cs_var_counter_item .= '<div class="text-holder">';
            if ( $wp_rem_cs_var_count <> '' ) {
                $wp_rem_cs_var_counter_item .= '<strong class="counter custom-counter" '.$counter_color.'>' . $wp_rem_cs_var_count . '</strong>';
            }
            if ( $wp_rem_cs_var_title <> '' ) {
                $wp_rem_cs_var_counter_item .= '<span '.$counter_title_color.'>' . esc_html($wp_rem_cs_var_title) . '</span>';
            }
            $wp_rem_cs_var_counter_item .= ' </div>
                                </div>';
        } else {
            $wp_rem_cs_var_counter_item .='<div class="cs-counter modern">
                                            <div class="text-holder">';
            if ( $wp_rem_cs_var_count <> '' ) {
                $wp_rem_cs_var_counter_item .='<strong class="counter text-color custom-counter">' . esc_html($wp_rem_cs_var_count) . '</strong>';
            }
            if ( $wp_rem_cs_var_title <> '' ) {
                $wp_rem_cs_var_counter_item .='<span>' . esc_html($wp_rem_cs_var_title) . '</span>';
            }
            $wp_rem_cs_var_counter_item .='</div>
                                            </div>';
        }
        $wp_rem_cs_var_counter_item .= '</div>';
        return $wp_rem_cs_var_counter_item;
    }

    if ( function_exists('wp_rem_cs_var_short_code') )
        wp_rem_cs_var_short_code('counter_item', 'wp_rem_cs_counter_item');
}
