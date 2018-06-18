<?php

/*
 *
 * @Shortcode Name :  Start function for Multiple icon_box shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_icon_boxes_shortcode') ) {

    function wp_rem_cs_var_icon_boxes_shortcode($atts, $content = "") {
        global $post, $icon_box_counter, $wp_rem_cs_var_icon_box_column, $wp_rem_cs_icon_box_icon_color, $wp_rem_cs_title_color, $wp_rem_cs_var_link_url, $wp_rem_cs_var_icon_box_view, $wp_rem_cs_var_icon_box_icon_size, $wp_rem_cs_icon_box_content_align;
        $html = '';
        $page_element_size = isset($atts['icon_box_element_size']) ? $atts['icon_box_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_icon_boxes_title' => '',
            'wp_rem_cs_var_icon_boxes_sub_title' => '',
            'wp_rem_cs_var_icon_boxes_element_sub_title' => '',
            'wp_rem_cs_var_icon_boxes_element_alignment' => '',
            'wp_rem_cs_var_icon_box_column' => '',
            'wp_rem_cs_icon_box_content_color' => '',
            'wp_rem_cs_title_color' => '',
            'wp_rem_cs_var_icon_box_view' => '',
            'wp_rem_cs_icon_box_icon_color' => '',
            'wp_rem_cs_var_icon_box_icon_size' => '',
            'wp_rem_cs_icon_box_content_align' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $icon_box_counter = 1;
        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_icon_boxes_title = isset($wp_rem_cs_var_icon_boxes_title) ? $wp_rem_cs_var_icon_boxes_title : '';
        $wp_rem_cs_var_icon_boxes_sub_title = isset($wp_rem_cs_var_icon_boxes_sub_title) ? $wp_rem_cs_var_icon_boxes_sub_title : '';
        $wp_rem_cs_var_icon_box_column = isset($wp_rem_cs_var_icon_box_column) ? $wp_rem_cs_var_icon_box_column : '';
        $wp_rem_cs_var_link_url = isset($wp_rem_cs_var_link_url) ? $wp_rem_cs_var_link_url : '';
        $wp_rem_cs_var_icon_box_view = isset($wp_rem_cs_var_icon_box_view) ? $wp_rem_cs_var_icon_box_view : '';
        $wp_rem_cs_title_color = isset($wp_rem_cs_title_color) ? $wp_rem_cs_title_color : '';
        $wp_rem_cs_icon_box_icon_color = isset($wp_rem_cs_icon_box_icon_color) ? $wp_rem_cs_icon_box_icon_color : '';
        $wp_rem_cs_var_icon_box_icon_size = isset($wp_rem_cs_var_icon_box_icon_size) ? $wp_rem_cs_var_icon_box_icon_size : '';
        $wp_rem_cs_icon_box_content_align = isset($wp_rem_cs_icon_box_content_align) ? $wp_rem_cs_icon_box_content_align : '';
        $wp_rem_cs_icon_box_content_color = isset($wp_rem_cs_icon_box_content_color) ? $wp_rem_cs_icon_box_content_color : '';

        if ( $wp_rem_cs_var_icon_box_view == 'award' ) {
            $wp_rem_cs_icon_box_content_align = '';
        }
$icon_box_list_class = 'cs-icon-boxes-list';
        if ( $wp_rem_cs_var_icon_box_view == 'modern' ) {
            $icon_box_list_class = 'icons-boxes-list';
        }
        $column_class = '';
        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        $wp_rem_cs_section_title = '';
        $title_subtitle_style = '';
        if ( isset($wp_rem_cs_icon_box_content_color) && $wp_rem_cs_icon_box_content_color != '' ) {

            $title_subtitle_style = 'style="color:' . esc_html($wp_rem_cs_icon_box_content_color) . ' !important;"';
        }
        $wp_rem_cs_section_title .= wp_rem_title_sub_align($wp_rem_cs_var_icon_boxes_title, $wp_rem_cs_var_icon_boxes_element_sub_title, $wp_rem_cs_var_icon_boxes_element_alignment, $wp_rem_cs_icon_box_content_color);
        if ( $wp_rem_cs_section_title != '' || $content != '' ) {
            if ( isset($column_class) && $column_class <> '' ) {
                $html .= '<div class="' . esc_html($column_class) . '">';
            }
            if ( $wp_rem_cs_section_title != '' ) {
                $html .= $wp_rem_cs_section_title;
            }
            if ( $content != '' ) {
                $html .= '<div class="' . $icon_box_list_class . ' ' . $wp_rem_cs_icon_box_content_align . '">'
                        . '<div class="row">';
                $html .= do_shortcode($content);
                $html .= '</div></div>';
            }
            if ( isset($column_class) && $column_class <> '' ) {
                $html .= '</div>';
            }
        }
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }
        return do_shortcode(do_shortcode($html));
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('icon_box', 'wp_rem_cs_var_icon_boxes_shortcode');
    }
}
/*
 *
 * @Multiple  Start function for Multiple icon_box Item  shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_var_icon_boxes_item_shortcode') ) {

    function wp_rem_cs_var_icon_boxes_item_shortcode($atts, $content = "") {
        $defaults = array(
            'icon_boxes_style' => '',
            'wp_rem_cs_var_icon_box_title' => '',
            'wp_rem_cs_var_icon_boxes_icon' => '',
            'wp_rem_cs_var_icon_boxes_icon_group' => 'default',
            'wp_rem_cs_var_link_url' => '',
            'wp_rem_cs_var_icon_box_icon_type' => '',
            'wp_rem_cs_var_icon_box_image' => '',
        );
        global $post, $icon_box_counter, $wp_rem_cs_var_icon_box_column, $wp_rem_cs_var_link_url, $wp_rem_cs_title_color, $wp_rem_cs_icon_box_icon_color, $wp_rem_cs_var_icon_box_icon_size, $wp_rem_cs_var_icon_box_view, $wp_rem_cs_icon_box_content_align;
        extract(shortcode_atts($defaults, $atts));
        $html = '';
        $wp_rem_cs_var_icon_box_view = isset($wp_rem_cs_var_icon_box_view) ? $wp_rem_cs_var_icon_box_view : '';
        $wp_rem_cs_var_icon_boxes_icon = isset($wp_rem_cs_var_icon_boxes_icon) ? $wp_rem_cs_var_icon_boxes_icon : '';
        $wp_rem_cs_var_icon_box_title = isset($wp_rem_cs_var_icon_box_title) ? $wp_rem_cs_var_icon_box_title : '';
        $wp_rem_cs_var_link_url = isset($wp_rem_cs_var_link_url) ? $wp_rem_cs_var_link_url : '';
        $wp_rem_cs_var_icon_box_icon_type = isset($wp_rem_cs_var_icon_box_icon_type) ? $wp_rem_cs_var_icon_box_icon_type : '';
        $wp_rem_cs_var_icon_box_image = isset($wp_rem_cs_var_icon_box_image) ? $wp_rem_cs_var_icon_box_image : '';
        $col_class = '';
        $heading = '5';
        if ( $wp_rem_cs_var_icon_box_view == 'modern' || $wp_rem_cs_var_icon_box_view == 'classic') {
            $heading = '3';
        }
        $has_shadow = '';
        if ( $wp_rem_cs_var_icon_box_view == 'boxed' ) {
            $has_shadow = 'has-shadow';
        }
        if ( $wp_rem_cs_var_icon_box_view == 'boxed-v2' ) {
            $wp_rem_cs_var_icon_box_view = 'boxed advance';
        }
        if ( isset($wp_rem_cs_var_icon_box_column) && $wp_rem_cs_var_icon_box_column != '' ) {
            $number_col = 12 / $wp_rem_cs_var_icon_box_column;
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
        $box_col_plus_class = '';
        if ( $wp_rem_cs_icon_box_content_align == 'left-right' ) {
            if ( fmod($icon_box_counter, 2) == 0 ) {
                $box_col_plus_class = ' box-right';
            } else {
                $box_col_plus_class = ' box-left';
            }
        }
        if ( $wp_rem_cs_var_icon_boxes_icon != '' || $wp_rem_cs_var_icon_box_title != '' || $content != '' ) {
            $html .= '<div class="' . esc_html($col_class) . esc_html($box_col_plus_class) . '">';
            if ( $wp_rem_cs_icon_box_content_align == 'left-right' ) {
                $html .= '<div class="icon-boxes ' . esc_html($wp_rem_cs_var_icon_box_view) . ' top-left">';
            } else {
                $html .= '<div class="icon-boxes ' . esc_html($wp_rem_cs_var_icon_box_view) . ' ' . $has_shadow . ' ' . esc_html($wp_rem_cs_icon_box_content_align) . '">';
            }
            if ( $wp_rem_cs_var_icon_boxes_icon != '' && $wp_rem_cs_var_icon_box_icon_type == 'icon' ) {
                wp_enqueue_style('cs_icons_data_css_'.$wp_rem_cs_var_icon_boxes_icon_group );
                $html .= '<div class="img-holder">';
                if ( $wp_rem_cs_var_link_url != '' ) {
                    $html .= '<a href="' . esc_url($wp_rem_cs_var_link_url) . '">';
                }
                $html .= '<figure><i class="cs-color ' . esc_attr($wp_rem_cs_var_icon_boxes_icon) . ' ' . esc_html($wp_rem_cs_var_icon_box_icon_size) . '" style="color:' . esc_html($wp_rem_cs_icon_box_icon_color) . ' !important;line-height:50px;">
				</i></figure>';
                if ( $wp_rem_cs_var_link_url != '' ) {
                    $html .= '</a>';
                }
                $html .= '</div>';
            } elseif ( $wp_rem_cs_var_icon_box_image != '' && $wp_rem_cs_var_icon_box_icon_type == 'image' ) {
                $html .= '<div class="img-holder">';
                if ( $wp_rem_cs_var_link_url != '' ) {
                    $html .= '<a href="' . esc_url($wp_rem_cs_var_link_url) . '">';
                }
                $html .= '<figure><img src="' . esc_url($wp_rem_cs_var_icon_box_image) . '" alt="' . esc_html($wp_rem_cs_var_icon_box_title) . '"></figure>';
                if ( $wp_rem_cs_var_link_url != '' ) {
                    $html .= '</a>';
                }
                $html .= '</div>';
            }
            if ( $wp_rem_cs_var_icon_box_title != '' || $content != '' ) {
                $html .= '<div class="text-holder">';
                if ( $wp_rem_cs_var_icon_box_title != '' ) {
                    $html .= '<h' . esc_html($heading) . ' style="color:' . esc_html($wp_rem_cs_title_color) . ' !important;">';
                    if ( $wp_rem_cs_var_link_url != '' ) {
                        $html .= '<a href="' . esc_url($wp_rem_cs_var_link_url) . '" style="color:' . esc_html($wp_rem_cs_title_color) . ' !important;">';
                    }
                    $html .= $wp_rem_cs_var_icon_box_title;
                    if ( $wp_rem_cs_var_link_url != '' ) {
                        $html .= '</a>';
                    }
                    $html .= '</h' . esc_html($heading) . '>';
                }
                if ( $content != '' ) {
                    if ( $wp_rem_cs_var_icon_box_view == 'modern' || $wp_rem_cs_var_icon_box_view == 'boxed' ) {
                        $html .= '<p>' . do_shortcode($content) . '</p>';
                    } else {
                        $html .= do_shortcode($content);
                    }
                }
                $read_more_icon = '';
                $read_more_class = '';
                $read_more_class = '';
                if ( $wp_rem_cs_var_icon_box_view == 'has-border' ) {
                    $read_more_class = 'view-more-btn';
                    $read_more_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_menu_view_more');
                    $read_more_icon = '<i class="icon-caret-right"></i>';
                } elseif ( $wp_rem_cs_var_icon_box_view == 'boxed' ) {
                    $read_more_class = 'read-more-btn';
                    $read_more_text = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_readmore_text');
                }
                if ( $wp_rem_cs_var_link_url != '' && ($wp_rem_cs_var_icon_box_view == 'has-border' || $wp_rem_cs_var_icon_box_view == 'boxed') ) {
                    $html .= '<a href="' . esc_url($wp_rem_cs_var_link_url) . '" class="' . $read_more_class . ' text-color">' . esc_html($read_more_text) . $read_more_icon . '</a>';
                }
                $html .= '</div>';
            }
            $html .= '</div>';
            $html .= '</div>';
        }
        $icon_box_counter ++;
        return do_shortcode($html);
    }
    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('icon_boxes_item', 'wp_rem_cs_var_icon_boxes_item_shortcode');
    }
}