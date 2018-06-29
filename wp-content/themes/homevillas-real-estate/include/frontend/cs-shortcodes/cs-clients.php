<?php

/*
 *
 * @Shortcode Name :   Start function for Client shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_clients_shortcode') ) {

    function wp_rem_cs_clients_shortcode($atts, $content = null) {
        global $wp_rem_cs_var_blog_variables, $clients_style, $item_counter, $wp_rem_cs_var_clients_text, $post, $clients_section_title, $wp_rem_var_clients_view, $randomid;
        $wp_rem_cs_var_clients = '';
        $page_element_size = isset($atts['clients_element_size']) ? $atts['clients_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_clients .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $randomid = rand(1234, 7894563);
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'clients_style' => '',
            'wp_rem_cs_var_clients_text' => '',
            'wp_rem_cs_var_clients_element_subtitle' => '',
            'wp_rem_var_clients_align' => '',
            'wp_rem_cs_var_clients_element_title' => '',
            'wp_rem_var_clients_view' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $item_counter = 1;

        $wp_rem_cs_var_clients_element_title = isset($wp_rem_cs_var_clients_element_title) ? $wp_rem_cs_var_clients_element_title : '';
        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $clients_style = isset($clients_style) ? $clients_style : '';
        $wp_rem_cs_var_clients_text = isset($wp_rem_cs_var_clients_text) ? $wp_rem_cs_var_clients_text : '';
        $wp_rem_var_clients_view = isset($wp_rem_var_clients_view) ? $wp_rem_var_clients_view : '';

        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        if ( isset($column_class) && $column_class <> '' ) {

            $wp_rem_cs_var_clients .= '<div class="' . esc_html($column_class) . '">';
        }
        //if ( $wp_rem_var_clients_view != 'slider' ) {
            $wp_rem_cs_var_clients .= wp_rem_title_sub_align($wp_rem_cs_var_clients_element_title, $wp_rem_cs_var_clients_element_subtitle, $wp_rem_var_clients_align);
        //}


        $logo_class = '';
        $row_class = '';
        if ( $wp_rem_var_clients_view == 'modern' ) {
            $logo_class = ' modern';
        } elseif ( $wp_rem_var_clients_view == 'modern-border' ) {
            $logo_class = ' modern has-border';
        } elseif ( $wp_rem_var_clients_view == 'default' ) {
            $logo_class = ' default has-border';
        } elseif ( $wp_rem_var_clients_view == 'advance' ) {
            $logo_class = ' v2';
        } elseif ( $wp_rem_var_clients_view == 'classic' ) {
            $logo_class = ' advance ';
            $row_class = ' class="row"';
        }

        if ( $wp_rem_var_clients_view == 'advance' ) {
            $wp_rem_cs_var_clients .='<div class="company-logo-holder">';
        }


        if ( $wp_rem_var_clients_view == 'slider' ) {

            $wp_rem_cs_var_clients .='<div id="company-logo-slider-' . $randomid . '" class="company-logo-holder company-logo-slider">
    <div class="company-logo">
        ';
           
            $wp_rem_cs_var_clients .='
                    <div class="swiper-container">
                        <ul class="swiper-wrapper">';
            $wp_rem_cs_var_clients .= do_shortcode($content);
            $wp_rem_cs_var_clients .='</ul>
                    </div>
                    <div class="swiper-button-next"><i class="icon-keyboard_arrow_right"></i></div>
                    <div class="swiper-button-prev"><i class="icon-keyboard_arrow_left"></i></div>
                
        
    </div>
</div>';
        } else {
            $wp_rem_cs_var_clients .='<div class="company-logo' . esc_html($logo_class) . '">';
            $wp_rem_cs_var_clients .='<ul' . $row_class . '>';
            $wp_rem_cs_var_clients .= do_shortcode($content);
            $wp_rem_cs_var_clients .='</ul>';
            $wp_rem_cs_var_clients .='</div>';
        }

        if ( $wp_rem_var_clients_view == 'advance' ) {
            $wp_rem_cs_var_clients .='</div>';
        }

        if ( isset($column_class) && $column_class <> '' ) {
            $wp_rem_cs_var_clients .= '</div>';
        }

        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $wp_rem_cs_var_clients .= '</div>';
        }

        return wp_rem_cs_allow_special_char($wp_rem_cs_var_clients);
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('wp_rem_cs_clients', 'wp_rem_cs_clients_shortcode');
    }
}

/*
 *
 * @Shortcode Name :  Start function for Client Item shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_clients_item') ) {

    function wp_rem_cs_clients_item($atts, $content = null) {
        global $clients_style, $column_class, $item_counter, $clients_style, $wp_rem_cs_var_clients_text_color, $post, $wp_rem_var_clients_view, $randomid;
        $defaults = array(
            'wp_rem_cs_var_clients_img_user_array' => '',
            'wp_rem_cs_var_clients_text' => '',
        );

        extract(shortcode_atts($defaults, $atts));
        $wp_rem_cs_var_clients_item = '';
        $clients_img_user = isset($wp_rem_cs_var_clients_img_user_array) ? $wp_rem_cs_var_clients_img_user_array : '';

        if ( $wp_rem_cs_var_clients_text == '' ) {
            $wp_rem_cs_var_clients_text = 'javascript:void(0)';
        } else {
            $wp_rem_cs_var_clients_text = esc_url($wp_rem_cs_var_clients_text);
        }
        $col_classic_class = '';
        if ( $wp_rem_var_clients_view == 'classic' ) {
            $col_classic_class = ' class="col-lg-6 col-md-6 col-sm-12 col-xs-12"';
        }
        if ( $wp_rem_var_clients_view == 'slider' ) {
            if ( $clients_img_user <> '' ) {
                $wp_rem_cs_var_clients_item .= '<li class="swiper-slide">';
                $wp_rem_cs_var_clients_item .= '<figure>
                                    <a href="' . esc_html($wp_rem_cs_var_clients_text) . '">
                                        <img src="' . esc_url($clients_img_user) . '" alt="" />
                                    </a>
                                </figure>';
                $wp_rem_cs_var_clients_item .= '</li>';
            }
            $wp_rem_cs_inline_script = '
            jQuery(document).ready(function ($) {
                    if ("" != jQuery("#company-logo-slider-' . $randomid . ' .swiper-container").length) {
                        new Swiper("#company-logo-slider-' . $randomid . ' .swiper-container", {
                            nextButton: "#company-logo-slider-' . $randomid . ' .swiper-button-next",
                            prevButton: "#company-logo-slider-' . $randomid . ' .swiper-button-prev",
                            paginationClickable:true,
                            slidesPerView: 6,
                            slidesPer: 1,
                            loop: !0,
                            breakpoints: {
                                1024: {
                                    slidesPerView: 4
                                },
                                768: {
                                    slidesPerView: 3
                                },
                                480: {
                                    slidesPerView: 2
                                },
                                320: {
                                    slidesPerView: 1
                                }
                            }
                        })
                    }
            });';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-functions');
        } else {
            if ( $clients_img_user <> '' ) {
                $wp_rem_cs_var_clients_item .= '<li' . $col_classic_class . '>';
                $wp_rem_cs_var_clients_item .= '<figure>';
                $wp_rem_cs_var_clients_item .= '<a href="' . esc_html($wp_rem_cs_var_clients_text) . '">';
                $wp_rem_cs_var_clients_item .= '<img src="' . esc_url($clients_img_user) . '" alt="">';
                $wp_rem_cs_var_clients_item .= '</a>';
                $wp_rem_cs_var_clients_item .= '</figure>';
                $wp_rem_cs_var_clients_item .= '</li>';
            }
        }
        $item_counter ++;

        return $wp_rem_cs_var_clients_item;
    }

    if ( function_exists('wp_rem_cs_var_short_code') ) {
        wp_rem_cs_var_short_code('clients_item', 'wp_rem_cs_clients_item');
    }
}