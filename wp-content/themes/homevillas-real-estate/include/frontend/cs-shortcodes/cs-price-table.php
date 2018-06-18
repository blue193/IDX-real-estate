<?php

/*
 *
 * @Shortcode Name :   Start function for Price Plan shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_price_table_shortcode') ) {

    function wp_rem_cs_price_table_shortcode($atts, $content = null) {
        global $wp_rem_cs_multi_price_col, $wp_rem_cs_price_plan_counter, $wp_rem_cs_price_table_style;
        $wp_rem_cs_price_plan_counter == 0;
        $wp_rem_cs_var_price_table = '';
        $page_element_size = isset($atts['price_table_element_size']) ? $atts['price_table_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_price_table .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_multi_price_table_section_title' => '',
            'wp_rem_cs_multi_price_table_section_subtitle' => '',
            'wp_rem_var_price_table_align' => '',
            'wp_rem_cs_price_table_style' => '',
            'pricing_table_btn_1_txt' => '',
            'pricing_table_btn_1_lnk' => '',
            'pricing_table_btn_2_txt' => '',
            'pricing_table_btn_2_lnk' => '',
            'pricing_table_cmpre_btn_txt' => '',
            'pricing_table_cmpre_btn_lnk' => '',
            'wp_rem_cs_multi_price_col' => '',
        );
        extract(shortcode_atts($defaults, $atts));

        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_multi_price_table_section_title = isset($wp_rem_cs_multi_price_table_section_title) ? $wp_rem_cs_multi_price_table_section_title : '';
        $wp_rem_cs_price_table_style = isset($wp_rem_cs_price_table_style) ? $wp_rem_cs_price_table_style : '';
        $wp_rem_cs_var_price_table_text = isset($wp_rem_cs_var_price_table_text) ? $wp_rem_cs_var_price_table_text : '';

        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }

        if ( isset($column_class) && $column_class <> '' ) {

            $wp_rem_cs_var_price_table .= '<div class="' . esc_html($column_class) . '">';
        }
        $modern_class = '';
        if ( $wp_rem_cs_price_table_style == 'modern' ) {
            $modern_class = 'modern-price-table';
        } else {
            $modern_class = 'facny-image-price-plans';
        }
        $wp_rem_cs_var_price_table_buttons = '';
        if ( $wp_rem_cs_price_table_style == 'classic' || $wp_rem_cs_price_table_style == 'modern' ) {
            $wp_rem_cs_var_price_table .= '<div class="' . $modern_class . '">';

            if ( $pricing_table_btn_1_txt != '' || $pricing_table_btn_2_txt != '' ) {
                $wp_rem_cs_var_price_table_buttons .= '<div class="plans-top-btns">';
                if ( $pricing_table_btn_1_txt != '' ) {
                    $wp_rem_cs_var_price_table_buttons .= '<a href="' . $pricing_table_btn_1_lnk . '" class="for-sale border-color">' . $pricing_table_btn_1_txt . '</a>';
                }
                if ( $pricing_table_btn_2_txt != '' ) {
                    $wp_rem_cs_var_price_table_buttons .= '<a href="' . $pricing_table_btn_2_lnk . '" class="for-rent border-color">' . $pricing_table_btn_2_txt . '</a>';
                }
                $wp_rem_cs_var_price_table_buttons .= '</div>';
            }
        }

        $wp_rem_cs_var_price_table .= '<div class="row">';
        $wp_rem_cs_var_price_table .= wp_rem_title_sub_align($wp_rem_cs_multi_price_table_section_title, $wp_rem_cs_multi_price_table_section_subtitle, $wp_rem_var_price_table_align);
        $wp_rem_cs_var_price_table .= $wp_rem_cs_var_price_table_buttons;
        $wp_rem_cs_var_price_table .= '' . do_shortcode($content) . '';
        $wp_rem_cs_inline_script = '(function($){ $(".price-items-wrapper > div").last().find(".pricetable-holder").addClass("last-element"); })(jQuery);';
        wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-functions');

        $wp_rem_cs_var_price_table .= '</div>';

        if ( $wp_rem_cs_price_table_style == 'classic' ) {
            if ( $pricing_table_cmpre_btn_txt != '' ) {
                $wp_rem_cs_var_price_table .= '<div class="plans-compare-btn"><a href="' . $pricing_table_cmpre_btn_lnk . '">' . $pricing_table_cmpre_btn_txt . '</a></div>';
            }
            $wp_rem_cs_var_price_table .= '</div>';
        }

        if ( $wp_rem_cs_price_table_style == 'modern' ) {
            $wp_rem_cs_var_price_table .= '</div>';
        }

        if ( isset($column_class) && $column_class <> '' ) {
            $wp_rem_cs_var_price_table .= '</div>';
        }

        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_price_table .= '</div>';
        }

        return $wp_rem_cs_var_price_table;
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('wp_rem_cs_price_table', 'wp_rem_cs_price_table_shortcode');
    }
}

/*
 *
 * @Shortcode Name :  Start function for Price Plan Item shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_price_table_item') ) {

    function wp_rem_cs_price_table_item($atts, $content = null) {
        global $wp_rem_cs_multi_price_col, $wp_rem_cs_price_plan_counter, $wp_rem_cs_price_table_style;
        $defaults = array(
            'wp_rem_cs_price_table_text' => '',
            'wp_rem_cs_price_table_title_color' => '',
            'wp_rem_cs_price_table_price' => '',
            'wp_rem_cs_price_table_currency' => '',
            'wp_rem_cs_price_table_time_duration' => '',
            'wp_rem_cs_button_link' => '',
            'wp_rem_cs_price_table_button_text' => '',
            'wp_rem_cs_price_table_button_color' => '',
            'wp_rem_cs_price_table_button_color_bg' => '',
            'wp_rem_cs_price_table_featured' => '',
            'wp_rem_var_price_table_packages_list' => '',
            'wp_rem_cs_price_table_column_bgcolor' => '',
            'wp_rem_cs_price_table_image_icon' => '',
            'wp_rem_cs_var_price_table_image' => '',
            'wp_rem_cs_price_table_icon_box' => ''
        );

        extract(shortcode_atts($defaults, $atts));

        if ( $wp_rem_cs_price_plan_counter == 0 ) {
            $first = 'first-element';
        } else {
            $first = '';
        }

        $wp_rem_cs_multi_price_col = isset($wp_rem_cs_multi_price_col) ? $wp_rem_cs_multi_price_col : '';
        $wp_rem_var_price_table_packages_list = isset($wp_rem_var_price_table_packages_list) ? $wp_rem_var_price_table_packages_list : '';
        $wp_rem_cs_price_table_text = isset($wp_rem_cs_price_table_text) ? $wp_rem_cs_price_table_text : '';
        $wp_rem_cs_price_table_title_color = isset($wp_rem_cs_price_table_title_color) ? $wp_rem_cs_price_table_title_color : '';
        $wp_rem_cs_price_table_price = isset($wp_rem_cs_price_table_price) ? $wp_rem_cs_price_table_price : '';
        $wp_rem_cs_price_table_currency = isset($wp_rem_cs_price_table_currency) ? $wp_rem_cs_price_table_currency : '$';
        $wp_rem_cs_price_table_time_duration = isset($wp_rem_cs_price_table_time_duration) ? $wp_rem_cs_price_table_time_duration : '';
        $wp_rem_cs_button_link = isset($wp_rem_cs_button_link) ? $wp_rem_cs_button_link : '';
        $wp_rem_cs_price_table_button_text = isset($wp_rem_cs_price_table_button_text) ? $wp_rem_cs_price_table_button_text : '';
        $wp_rem_cs_price_table_button_color = isset($wp_rem_cs_price_table_button_color) ? $wp_rem_cs_price_table_button_color : '';
        $wp_rem_cs_price_table_button_color_bg = isset($wp_rem_cs_price_table_button_color_bg) ? $wp_rem_cs_price_table_button_color_bg : '';
        $wp_rem_cs_price_table_featured = isset($wp_rem_cs_price_table_featured) ? $wp_rem_cs_price_table_featured : '';
        $wp_rem_cs_price_table_image_icon = isset($wp_rem_cs_price_table_image_icon) ? $wp_rem_cs_price_table_image_icon : '';
        $wp_rem_cs_var_price_table_image = isset($wp_rem_cs_var_price_table_image) ? $wp_rem_cs_var_price_table_image : '';
        $wp_rem_cs_price_table_icon_box = isset($wp_rem_cs_price_table_icon_box) ? $wp_rem_cs_price_table_icon_box : '';
        $wp_rem_cs_price_table_column_bgcolor = isset($wp_rem_cs_price_table_column_bgcolor) ? 'style="background-color:' . $wp_rem_cs_price_table_column_bgcolor . ' !important;" ' : '';
        $active_class = '';
        $featured_text = '';
        if ( $wp_rem_cs_price_table_featured == 'Yes' ) {
            $active_class = 'active';
            $featured_text = '
			<div class="category bgcolor">
				<em></em>
			</div>';
        }

        if ( isset($wp_rem_cs_multi_price_col) && $wp_rem_cs_multi_price_col != '' ) {
            $number_col = 12 / $wp_rem_cs_multi_price_col;
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
        $advance_class = '';
        if ( $wp_rem_cs_price_table_style == 'advance' ) {
            $advance_class = 'advance';
        }

        $wp_rem_cs_var_price_table_item = '';
        $wp_rem_cs_var_price_table_item .= '<div class="' . esc_html($col_class) . ' ' . esc_html($advance_class) . '">';
        //simple view
        if ( $wp_rem_cs_price_table_style == 'classic' ) {
            $wp_rem_cs_var_price_table_item .= '<div class="pricetable-holder center ' . esc_html($active_class) . '" ' . force_balance_tags($wp_rem_cs_price_table_column_bgcolor) . '>';
            $wp_rem_cs_var_price_table_item .= '<div class="cs-price">';
            if ( $wp_rem_cs_price_table_featured == 'Yes' ) {
                $wp_rem_cs_var_price_table_item .= '<em class="popular-plan text-color">' . wp_rem_cs_var_theme_text_srt('wp_rem_price_plan_most_popular') . '</em>';
            }
            if ( $wp_rem_cs_price_table_text <> '' ) {
                $wp_rem_cs_var_price_table_item .= '<span class="title">' . esc_html($wp_rem_cs_price_table_text) . '</span>';
            }

            if ( (($wp_rem_cs_price_table_image_icon == 'image' || $wp_rem_cs_price_table_image_icon == '') && $wp_rem_cs_var_price_table_image != '') || (($wp_rem_cs_price_table_image_icon == 'icon' || $wp_rem_cs_price_table_image_icon == '') && $wp_rem_cs_price_table_icon_box != '') ) {
                $wp_rem_cs_var_price_table_item .='<div class="img-holder">';
                $wp_rem_cs_var_price_table_item .='<figure>';
                if ( ($wp_rem_cs_price_table_image_icon == 'icon' || $wp_rem_cs_price_table_image_icon == '') && $wp_rem_cs_price_table_icon_box != '' ) {
                    $wp_rem_cs_var_price_table_item .='<i class="icon ' . $wp_rem_cs_price_table_icon_box . '"></i>';
                } else {
                    $wp_rem_cs_var_price_table_item .='<a href="#"><img src="' . esc_url($wp_rem_cs_var_price_table_image) . '" alt=""></a>';
                }
                $wp_rem_cs_var_price_table_item .='</figure>';
                $wp_rem_cs_var_price_table_item .='</div>';
            }

            $wp_rem_cs_var_price_table_item .= $featured_text;

            $price_color = '';
            if ( isset($wp_rem_cs_price_table_title_color) && $wp_rem_cs_price_table_title_color <> '' ) {
                $price_color = 'style = "color:' . $wp_rem_cs_price_table_title_color . ';"';
            }
            if ( $wp_rem_cs_price_table_price <> '' ) {
                $wp_rem_cs_var_price_table_item .= '<strong ' . $price_color . '><sub>' . wp_rem_cs_allow_special_char($wp_rem_cs_price_table_currency) . '</sub> ' . esc_html($wp_rem_cs_price_table_price) . '</strong>';
            }
            if ( $wp_rem_cs_price_table_time_duration <> '' ) {
                $wp_rem_cs_var_price_table_item .= '<span class="per-month">' . esc_html($wp_rem_cs_price_table_time_duration) . '</span>';
            }
            if ( isset($wp_rem_var_price_table_packages_list) && $wp_rem_var_price_table_packages_list != '' ) {
                $wp_rem_cs_price_table_button_text = '[wp_rem_package package_id="' . $wp_rem_var_price_table_packages_list . '"]';
                $wp_rem_cs_var_price_table_item .= do_shortcode($wp_rem_cs_price_table_button_text);
            } else {
                if ( $wp_rem_cs_price_table_button_text <> '' ) {
                    $wp_rem_cs_var_price_table_item .= '<a class="try-btn" style="background-color:' . force_balance_tags($wp_rem_cs_price_table_button_color_bg) . '!important; color:' . force_balance_tags($wp_rem_cs_price_table_button_color) . ' !important" href="' . esc_url($wp_rem_cs_button_link) . '">' . esc_html($wp_rem_cs_price_table_button_text) . '</a>';
                }
            }
            $wp_rem_cs_var_price_table_item .= '</div>';
            $wp_rem_cs_var_price_table_item .= do_shortcode($content);
            $wp_rem_cs_var_price_table_item .= '</div>';
        } else if ( $wp_rem_cs_price_table_style == 'advance' ) {

            $wp_rem_cs_var_price_table_item .= '<div class="pricetable-holder center ' . esc_html($active_class) . ' ">';
            $wp_rem_cs_var_price_table_item .= '<div class="price-holder">';
            if ( $wp_rem_cs_price_table_featured == 'Yes' ) {
                $wp_rem_cs_var_price_table_item .= '<div class="category"><em>' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_activation_recommended') . '</em></div>';
            }
            $wp_rem_cs_var_price_table_item .= ' <div class="cs-price">';
            $wp_rem_cs_var_price_table_item .= '<span ' . force_balance_tags($wp_rem_cs_price_table_column_bgcolor) . '>';
            $wp_rem_cs_var_price_table_item .= '<small>' . esc_html($wp_rem_cs_price_table_currency) . '</small>';
            if ( $wp_rem_cs_price_table_price <> '' ) {
                $wp_rem_cs_var_price_table_item .= esc_html($wp_rem_cs_price_table_price);
            }
            $wp_rem_cs_var_price_table_item .= '<strong style="color:' . ($wp_rem_cs_price_table_title_color) . '!important;">' . esc_html($wp_rem_cs_price_table_text) . '</strong>';

            $wp_rem_cs_var_price_table_item .= '</span>';
            $wp_rem_cs_var_price_table_item .= '<div class="advance-duration">  <em>' . esc_html($wp_rem_cs_price_table_time_duration) . '</em></div>';
            $wp_rem_cs_var_price_table_item .= '</div>';
            $wp_rem_cs_var_price_table_item .= do_shortcode($content);

            if ( isset($wp_rem_var_price_table_packages_list) && $wp_rem_var_price_table_packages_list != '' ) {
                $wp_rem_cs_price_table_button_text = '[wp_rem_package package_id="' . $wp_rem_var_price_table_packages_list . '"]';
                $wp_rem_cs_var_price_table_item .= do_shortcode($wp_rem_cs_price_table_button_text);
            } else {
                if ( $wp_rem_cs_price_table_button_text <> '' ) {
                    $wp_rem_cs_var_price_table_item .= '<div class="button-holder">';
                    $wp_rem_cs_var_price_table_item .= '<a style="background-color:' . force_balance_tags($wp_rem_cs_price_table_button_color_bg) . '!important; color:' . force_balance_tags($wp_rem_cs_price_table_button_color) . ' !important;" href="' . esc_url($wp_rem_cs_button_link) . '" class="text-color">' . esc_html($wp_rem_cs_price_table_button_text) . ' <i class="icon-controller-play"></i></a>';
                    $wp_rem_cs_var_price_table_item .= '</div>';
                }
            }
            $wp_rem_cs_var_price_table_item .= ' </div>';
            $wp_rem_cs_var_price_table_item .= ' </div>';
        } else if ( $wp_rem_cs_price_table_style == 'modern' ) {
            $wp_rem_cs_var_price_table_item .= '<div class="pricetable-holder modern center ' . esc_html($active_class) . '" ' . force_balance_tags($wp_rem_cs_price_table_column_bgcolor) . '>';
            if ( $wp_rem_cs_price_table_text != '' ) {
                $wp_rem_cs_var_price_table_item .= '<div class="post-title">';
                $wp_rem_cs_var_price_table_item .= '<h6>' . esc_html($wp_rem_cs_price_table_text) . '</h6>';
                $wp_rem_cs_var_price_table_item .= '</div>';
            }

            $wp_rem_cs_var_price_table_item .= '<div class="price-holder">';
            $wp_rem_cs_var_price_table_item .= '<div class="cs-price">';
            if ( (($wp_rem_cs_price_table_image_icon == 'image' || $wp_rem_cs_price_table_image_icon == '') && $wp_rem_cs_var_price_table_image != '') || (($wp_rem_cs_price_table_image_icon == 'icon' || $wp_rem_cs_price_table_image_icon == '') && $wp_rem_cs_price_table_icon_box != '') ) {
                $wp_rem_cs_var_price_table_item .='<div class="img-holder">';
                $wp_rem_cs_var_price_table_item .='<figure>';
                if ( ($wp_rem_cs_price_table_image_icon == 'icon' || $wp_rem_cs_price_table_image_icon == '') && $wp_rem_cs_price_table_icon_box != '' ) {
                    $wp_rem_cs_var_price_table_item .='<i class="icon ' . $wp_rem_cs_price_table_icon_box . '"></i>';
                } else {
                    $wp_rem_cs_var_price_table_item .='<a href="#"><img src="' . esc_url($wp_rem_cs_var_price_table_image) . '" alt=""></a>';
                }
                $wp_rem_cs_var_price_table_item .='</figure>';
                $wp_rem_cs_var_price_table_item .='</div>';
            }

            $price_color = '';
            if ( isset($wp_rem_cs_price_table_title_color) && $wp_rem_cs_price_table_title_color <> '' ) {
                $price_color = 'style="color:' . $wp_rem_cs_price_table_title_color . ';"';
            }
            if ( $wp_rem_cs_price_table_price <> '' ) {
                $wp_rem_cs_var_price_table_item .= '<strong ' . $price_color . '><sub>' . wp_rem_cs_allow_special_char($wp_rem_cs_price_table_currency) . '</sub> ' . esc_html($wp_rem_cs_price_table_price) . '</strong>';
            }
            if ( $wp_rem_cs_price_table_time_duration <> '' ) {
                $wp_rem_cs_var_price_table_item .= '<span class="per-month">' . esc_html($wp_rem_cs_price_table_time_duration) . '</span>';
            }
            if ( isset($wp_rem_var_price_table_packages_list) && $wp_rem_var_price_table_packages_list != '' ) {
                $wp_rem_cs_price_table_button_text = '[wp_rem_package package_id="' . $wp_rem_var_price_table_packages_list . '"]';
                $wp_rem_cs_var_price_table_item .= do_shortcode($wp_rem_cs_price_table_button_text);
            } else {
                if ( $wp_rem_cs_price_table_button_text <> '' ) {
                    $wp_rem_cs_var_price_table_item .= '<a class="try-btn" style="background-color:' . force_balance_tags($wp_rem_cs_price_table_button_color_bg) . '!important; color:' . force_balance_tags($wp_rem_cs_price_table_button_color) . ' !important" href="' . esc_url($wp_rem_cs_button_link) . '">' . esc_html($wp_rem_cs_price_table_button_text) . '</a>';
                }
            }
            $wp_rem_cs_var_price_table_item .= '</div>';
            $wp_rem_cs_var_price_table_item .= do_shortcode($content);
            $wp_rem_cs_var_price_table_item .= '</div>';
            $wp_rem_cs_var_price_table_item .= '</div>';
        }
        $wp_rem_cs_var_price_table_item .= '</div>';

        $wp_rem_cs_price_plan_counter ++;


        return $wp_rem_cs_var_price_table_item;
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('price_table_item', 'wp_rem_cs_price_table_item');
    }
}