<?php

/*
 *
 * @Shortcode Name :   Start function for Testimonial shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_testimonials_shortcode') ) {

    function wp_rem_cs_testimonials_shortcode($atts, $content = null) {

        global $column_class, $section_title, $post, $wp_rem_cs_var_author_color, $wp_rem_cs_var_heading_color, $wp_rem_cs_var_text_color, $content_array, $wp_rem_cs_var_testimonial_view;
        $randomid = rand(0123, 9999);
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_testimonial_content' => '',
            'wp_rem_cs_var_testimonial_title' => '',
            'wp_rem_cs_var_testimonial_subtitle' => '',
            'wp_rem_var_testimonial_align' => '',
            'wp_rem_cs_var_author_color' => '',
            'wp_rem_cs_var_heading_color' => '',
            'wp_rem_cs_var_text_color' => '',
            'wp_rem_cs_var_testimonial_view' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        $html = '';
        $page_element_size = isset($atts['testimonial_element_size']) ? $atts['testimonial_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $section_title = '';
        $wp_rem_cs_var_testimonial_title = isset($wp_rem_cs_var_testimonial_title) ? $wp_rem_cs_var_testimonial_title : '';
        $wp_rem_cs_var_testimonial_content = isset($wp_rem_cs_var_testimonial_content) ? $wp_rem_cs_var_testimonial_content : '';
        $wp_rem_cs_var_testimonial_subtitle = isset($wp_rem_cs_var_testimonial_subtitle) ? $wp_rem_cs_var_testimonial_subtitle : '';
        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_author_color = isset($wp_rem_cs_var_author_color) ? $wp_rem_cs_var_author_color : '';
        $wp_rem_cs_var_testimonial_view = isset($wp_rem_cs_var_testimonial_view) ? $wp_rem_cs_var_testimonial_view : '';

        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        $heading_color = '';
        if ( $wp_rem_cs_var_heading_color != '' ) {
            $heading_color = 'style="color: ' . esc_html($wp_rem_cs_var_heading_color) . ' !important;"';
        }
        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }

        if ( $wp_rem_cs_var_testimonial_view == 'modern' || $wp_rem_cs_var_testimonial_view == 'advance' || $wp_rem_cs_var_testimonial_view == 'advance-v1' || $wp_rem_cs_var_testimonial_view == 'fancy' ) {
            $html .= '<div class="row">';
        }
        if ( $wp_rem_cs_var_testimonial_view == 'modern' ) {
            $html .= '<div class="testimonial-holder">';
            $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
            $html .= '<div class="img-holder">';
            $html .= '<ul>';
            $html .= '' . do_shortcode($content);
            $html .= '</ul>';
            $html .= '</div><!-- end img-holder-->';
            $html .= '<div class="text-holder">';
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_testimonial_title, $wp_rem_cs_var_testimonial_subtitle, $wp_rem_var_testimonial_align, $wp_rem_cs_var_heading_color);
            $html .= '<div class="swiper-container">';
            $html .= '<div class="swiper-wrapper">';
            // html render
            if ( ! empty($content_array) ) {
                foreach ( $content_array as $content_single ) {
                    $html .= force_balance_tags($content_single);
                }
            }
            $html .= '</div><!-- end swiper-wrapper-->';
            $html .= '</div><!-- end swiper-container-->';
            $html .= '</div><!-- end text-holder-->';
            $html .= '</div><!-- end columns-->';
            $html .= '</div><!-- end testimonial-holder-->';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'advance' ) {
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_testimonial_title, $wp_rem_cs_var_testimonial_subtitle, $wp_rem_var_testimonial_align, $wp_rem_cs_var_heading_color);
            $html .= '<div class="testimonial-holder advance">';
            $html .= '<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $html .= '' . do_shortcode($content);
            $html .= '<div class="text-holder">';
            $html .= '<div class="swiper-container">';
            $html .= '<div class="swiper-wrapper">';
            // html render
            if ( ! empty($content_array) ) {
                foreach ( $content_array as $content_single ) {
                    $html .= force_balance_tags($content_single);
                }
            }
            $html .= '</div><!-- end swiper-wrapper-->';
            $html .= '</div><!-- end swiper-container-->';
            $html .= '</div><!-- end text-holder-->';
            $html .= '</div><!-- end columns-->';
            $html .= '</div><!-- end testimonial-holder-->';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'advance-v1' ) {
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_testimonial_title, $wp_rem_cs_var_testimonial_subtitle, $wp_rem_var_testimonial_align, $wp_rem_cs_var_heading_color);
            $html .= '<div id="testimonial-holder-' . $randomid . '" class="testimonial-holder advance v1">';
            $html .= '<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">';
            $html .= '' . do_shortcode($content);
            $html .= '<div class="text-holder">';
            $html .= '<div class="swiper-container">';
            $html .= '<div class="swiper-wrapper">';
            // html render
            if ( ! empty($content_array) ) {
                foreach ( $content_array as $content_single ) {
                    $html .= force_balance_tags($content_single);
                }
            }
            $html .= '</div><!-- end swiper-wrapper-->';
            $html .= '</div><!-- end swiper-container-->';
            $html .= '<div class="swiper-button-next"><i class="icon-angle-right"></i> </div>';
            $html .= '<div class="swiper-button-prev"><i class="icon-angle-left"></i></div>';
            $html .= '</div><!-- end text-holder-->';
            $html .= '</div><!-- end columns-->';
            $html .= '</div><!-- end testimonial-holder-->';
            $wp_rem_cs_inline_script = '
			jQuery(document).ready(function ($) {
				if ("" != jQuery("#testimonial-holder-' . $randomid . ' .swiper-container").length) {
					new Swiper("#testimonial-holder-' . $randomid . ' .swiper-container", {
						nextButton: "#testimonial-holder-' . $randomid . ' .swiper-button-next",
						prevButton: "#testimonial-holder-' . $randomid . ' .swiper-button-prev",
						paginationClickable: true,
						slidesPerView: 1,
						slidesPerColumn: 1,
						grabCursor: !0,
						loop: !0,
						spaceBetween:0,
					})
				}
			});';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-functions');
        } elseif ( $wp_rem_cs_var_testimonial_view == 'classic' ) {
            $html .= '<div class="testimonial-holder default">';
            $html .= '  <div class="text-holder">';
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_testimonial_title, $wp_rem_cs_var_testimonial_subtitle, $wp_rem_var_testimonial_align, $wp_rem_cs_var_heading_color, 'classic');
            $html .='  <div class="swiper-container">
                                    <div class="swiper-wrapper">';
            $html .= do_shortcode($content);
            $html .= '              </div>
                                </div>
                            </div>
                        </div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'default' ) {
            $html .= '<div class="testimonial-holder default v2">';
            $html .= '  <div class="text-holder">';
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_testimonial_title, $wp_rem_cs_var_testimonial_subtitle, $wp_rem_var_testimonial_align, $wp_rem_cs_var_heading_color);
            $html .='  <div class="swiper-container">
                                    <div class="swiper-wrapper">';
            $html .= do_shortcode($content);
            $html .= '              </div>
                                </div>
                            </div>
                        </div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'fancy' ) {
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_testimonial_title, $wp_rem_cs_var_testimonial_subtitle, $wp_rem_var_testimonial_align, $wp_rem_cs_var_heading_color);
            $html .= '<div class="testimonial-slider">';
            $html .= '<div class="swiper-container swiper-container-horizontal">';
            $html .= '<div class="swiper-wrapper">';
            $html .= do_shortcode($content);
            $html .= '</div><!-- end swiper-wrapper-->';
            $html .= '</div><!-- end swiper-containe-->';
            $html .= '</div><!-- end testimonial-slider-->';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'simple' ) {
            $html .= wp_rem_title_sub_align($wp_rem_cs_var_testimonial_title, $wp_rem_cs_var_testimonial_subtitle, $wp_rem_var_testimonial_align, $wp_rem_cs_var_heading_color);
            $html .= '<div class="testimonial-holder classic">
                        <div class="text-holder">
                            <div class="swiper-container">
                                <div class="swiper-wrapper">';
            $html .= do_shortcode($content);
            $html .= '</div><!-- end swiper-wrapper-->';
            $html .= '</div><!-- end swiper-containe-->';
            $html .= '</div><!-- end testimonial-slider-->';
            $html .= '</div><!-- end testimonial-slider-->';
        }


        if ( $wp_rem_cs_var_testimonial_view == 'modern' || $wp_rem_cs_var_testimonial_view == 'advance' || $wp_rem_cs_var_testimonial_view == 'advance-v1' || $wp_rem_cs_var_testimonial_view == 'fancy' ) {
            $html .= '</div><!-- end row-->';
        }



        if ( isset($column_class) && $column_class <> '' ) {
            $html .= ' </div>';
        }

        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }

        return $html;
    }

    if ( function_exists('wp_rem_cs_short_code') ) {
        wp_rem_cs_short_code('wp_rem_cs_testimonial', 'wp_rem_cs_testimonials_shortcode');
    }
}

if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('wp_rem_cs_testimonial', 'wp_rem_cs_testimonials_shortcode');
/*
 *
 * @Shortcode Name :  Start function for Testimonial Item shortcode/element front end view
 * @retrun
 *
 */
if ( ! function_exists('wp_rem_cs_testimonial_item') ) {

    function wp_rem_cs_testimonial_item($atts, $content = null) {
        global $column_class, $post, $wp_rem_cs_var_author_color, $wp_rem_cs_var_heading_color, $wp_rem_cs_var_text_color, $content_array, $wp_rem_cs_var_testimonial_view;
        $width = '150';
        $height = '150';
        $defaults = array(
            'wp_rem_cs_var_testimonial_author' => '',
            'wp_rem_cs_var_testimonial_author_image_array' => '',
            'wp_rem_cs_var_testimonial_author_address' => '',
            'wp_rem_cs_var_testimonial_background_image_array' => '',
            'wp_rem_cs_var_testimonial_link' => '',
        );

        extract(shortcode_atts($defaults, $atts));
        $figure = '';
        $html = '';

        $wp_rem_cs_var_testimonial_author_image_array = isset($wp_rem_cs_var_testimonial_author_image_array) ? $wp_rem_cs_var_testimonial_author_image_array : '';
        $image_id = wp_rem_cs_var_get_image_id($wp_rem_cs_var_testimonial_author_image_array);
        $image_url = wp_rem_cs_attachment_image_src($image_id, $width, $height);
        $wp_rem_cs_var_testimonial_author = isset($wp_rem_cs_var_testimonial_author) ? $wp_rem_cs_var_testimonial_author : '';
        $wp_rem_cs_var_testimonial_author_address = isset($wp_rem_cs_var_testimonial_author_address) ? $wp_rem_cs_var_testimonial_author_address : '';
        $wp_rem_cs_var_testimonial_background_image_array = isset($wp_rem_cs_var_testimonial_background_image_array) ? $wp_rem_cs_var_testimonial_background_image_array : '';
        $image_bg_id = wp_rem_cs_var_get_image_id($wp_rem_cs_var_testimonial_background_image_array);
        $image_bg_url = wp_rem_cs_attachment_image_src($image_bg_id, '', '');
        $wp_rem_cs_var_testimonial_view = isset($wp_rem_cs_var_testimonial_view) ? $wp_rem_cs_var_testimonial_view : '';
        $wp_rem_cs_var_testimonial_link = (isset($wp_rem_cs_var_testimonial_link) && $wp_rem_cs_var_testimonial_link != '') ? $wp_rem_cs_var_testimonial_link : '#';
        $author_color = '';
        if ( $wp_rem_cs_var_author_color != '' ) {
            $author_color = 'style="color: ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_author_color) . ' !important;"';
        }

        $text_color = '';
        if ( $wp_rem_cs_var_text_color != '' ) {
            $text_color = 'style="color: ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_text_color) . ' !important;"';
        }

        $html .= '';
        if ( $wp_rem_cs_var_testimonial_view == 'modern' ) {
            if ( $image_url <> '' ) {
                $html .='<li class="swiper-pagination-switch">
                                            <figure>
                                                <a href="' . esc_url($wp_rem_cs_var_testimonial_link) . '"><img src="' . esc_url($image_url) . '" alt=""></a>
                                            </figure>
                                        </li>';
            }

            $content_array[] = '<div class="swiper-slide">
                                                <p ' . $text_color . '>' . do_shortcode($content) . '</p>
                                                <div class="author-info">
                                                    <div class="img-holder">
                                                        <figure>
                                                           <img src="' . esc_url($image_url) . '" alt="">
                                                        </figure>
                                                    </div>
                                                    <div class="text-holder">
                                                        <h6 ><a href="' . esc_url($wp_rem_cs_var_testimonial_link) . '" ' . wp_rem_cs_allow_special_char($author_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author) . '</a></h6>
							    <span ' . ($text_color) . '> ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_testimonial_author_address) . ' </span>
                                                    </div>
                                                </div>
                                            </div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'advance' ) {
            $content_array[] = '<div class="swiper-slide">
                                    <p ' . $text_color . '>' . do_shortcode($content) . '</p>
                                    <div class="author-info">
                                        <div class="img-holder">
                                            <figure>
                                               <img src="' . esc_url($image_url) . '" alt="">
                                            </figure>
                                        </div>
                                        <div class="text-holder">
                                            <h6 ><a href="' . esc_url($wp_rem_cs_var_testimonial_link) . '" ' . wp_rem_cs_allow_special_char($author_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author) . '</a></h6>
                                                <span ' . wp_rem_cs_allow_special_char($text_color) . '> ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_testimonial_author_address) . ' </span>
                                        </div>
                                    </div>
                                </div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'advance-v1' ) {
            $content_array[] = '<div class="swiper-slide">
                                    <p ' . $text_color . '>' . do_shortcode($content) . '</p>
                                    <div class="author-info">
                                        <div class="img-holder">
                                            <figure>
                                               <img src="' . esc_url($image_url) . '" alt="">
                                            </figure>
                                        </div>
                                        <div class="text-holder">
                                            <h6 ><a href="' . esc_url($wp_rem_cs_var_testimonial_link) . '" ' . wp_rem_cs_allow_special_char($author_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author) . '</a></h6>
                                                <span ' . wp_rem_cs_allow_special_char($text_color) . '> ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_testimonial_author_address) . ' </span>
                                        </div>
                                    </div>
                                </div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'classic' ) {


            $html .= '<div class="swiper-slide">';

            if ( isset($content) && $content != '' ) {
                $html .='<p>' . do_shortcode($content) . '</p>';
            }

            $html .= '<div class="author-info default">';
            if ( isset($image_url) && $image_url != '' ) {
                $html .= '    <div class="img-holder">
                                <figure>
                                    <img src="' . esc_url($image_url) . '" alt="">
                                </figure>
                            </div>';
            }
            $html .= '  <div class="text-holder">';
            if ( $wp_rem_cs_var_testimonial_author <> '' ) {
                $html .='<h6 ' . ($author_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author) . '</h6>';
            }
            if ( $wp_rem_cs_var_testimonial_author_address <> '' ) {
                $html .='<span ' . ($text_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author_address) . '</span>';
            }
            $html .= '  </div>
                        </div>
                    </div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'default' ) {


            $html .= '<div class="swiper-slide">';

            if ( isset($image_url) && $image_url != '' ) {
                $html .= '    <div class="img-holder">
                                <figure>
                                    <img src="' . esc_url($image_url) . '" alt="">
                                </figure>
                            </div>';
            }
            if ( isset($content) && $content != '' ) {
                $html .='<p>' . do_shortcode($content) . '</p>';
            }

            $html .= '<div class="author-info default">';

            $html .= '  <div class="text-holder">';
            if ( $wp_rem_cs_var_testimonial_author <> '' ) {
                $html .='<h6 ' . ($author_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author) . '</h6>';
            }
            if ( $wp_rem_cs_var_testimonial_author_address <> '' ) {
                $html .='<span ' . ($text_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author_address) . '</span>';
            }
            $html .= '  </div>
                        </div>
                    </div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'fancy' ) {
            $html .='<div class="swiper-slide">';
            $html .='<div class="testimonial fancy">';
            if ( $image_bg_url <> '' ) {
                $html .='<div class="img-holder">';
                $html .='<figure><img src="' . esc_url($image_bg_url) . '" alt=""></figure>';
                $html .='</div>';
            }
            $html .='<div class="testimonial-description">';
            if ( $image_url <> '' ) {
                $html .='<div class="img-holder">';
                $html .='<figure><img src="' . esc_url($image_url) . '" alt=""></figure>';
                $html .='</div>';
            }
            $html .='<div class="text-holder">';
            $html .='<p>' . do_shortcode($content) . '</p>';
            $html .='<div class="authore-detail">';
            $html .='<span class="authore-name" ' . ($author_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author) . '</span>';
            if ( $wp_rem_cs_var_testimonial_author_address <> '' ) {
                $html .='<address ' . ($text_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author_address) . '</address>';
            }
            $html .='</div>';
            $html .='</div>';
            $html .='</div>';
            $html .='</div>';
            $html .='</div>';
        } elseif ( $wp_rem_cs_var_testimonial_view == 'simple' ) {

            $html .= '<div class="swiper-slide">';


            if ( isset($content) && $content != '' ) {
                $html .='<p><i class="icon-quotes-left"></i>' . do_shortcode($content) . '</p>';
            }


            $html .= '<div class="author-info classic">';

            if ( isset($image_url) && $image_url != '' ) {
                $html .= '    <div class="img-holder">
                                <figure>
                                    <img src="' . esc_url($image_url) . '" alt="">
                                </figure>
                            </div>';
            }
            $html .= '  <div class="text-holder">';
            if ( $wp_rem_cs_var_testimonial_author <> '' ) {
                $html .='<h6 ' . ($author_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author) . '</h6>';
            }
            if ( $wp_rem_cs_var_testimonial_author_address <> '' ) {
                $html .='<span ' . ($text_color) . '>' . esc_html($wp_rem_cs_var_testimonial_author_address) . '</span>';
            }
            $html .= '  </div>
                        </div>
                    </div>';
        }

        return $html;
    }

    if ( function_exists('wp_rem_cs_short_code') ) {
        wp_rem_cs_short_code('testimonial_item', 'wp_rem_cs_testimonial_item');
    }
}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('testimonial_item', 'wp_rem_cs_testimonial_item');



