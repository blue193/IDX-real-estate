<?php

/*
 *
 * @Shortcode Name :  Team front end view
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_team_shortcode') ) {

    function wp_rem_cs_var_team_shortcode($atts, $content = "") {
        $html = '';
        global $post, $wp_rem_cs_var_team_column, $wp_rem_cs_var_team_col, $wp_rem_cs_var_team_views, $team_rand_id;
        $page_element_size = isset($atts['team_element_size']) ? $atts['team_element_size'] : 100;
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        if ( ! function_exists('wp_rem_cs_var_theme_demo') ) {

            function wp_rem_cs_var_theme_demo($str = '') {
                global $wp_rem_cs_strings;
                if ( isset($wp_rem_cs_strings[$str]) ) {
                    return $wp_rem_cs_strings[$str];
                }
            }

        }
        $defaults = array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_team_title' => '',
            'wp_rem_cs_var_team_subtitle' => '',
            'wp_rem_cs_var_team_sub_title' => '',
            'wp_rem_cs_var_team_col' => '',
            'wp_rem_cs_var_team_views' => '',
            'wp_rem_var_team_align' => '',
        );
        extract(shortcode_atts($defaults, $atts));

        $wp_rem_cs_var_column_size = isset($wp_rem_cs_var_column_size) ? $wp_rem_cs_var_column_size : '';
        $wp_rem_cs_var_team_title = isset($wp_rem_cs_var_team_title) ? $wp_rem_cs_var_team_title : '';
        $wp_rem_cs_var_team_sub_title = isset($wp_rem_cs_var_team_sub_title) ? $wp_rem_cs_var_team_sub_title : '';
        $wp_rem_cs_var_team_col = isset($wp_rem_cs_var_team_col) ? $wp_rem_cs_var_team_col : '';
        $wp_rem_cs_var_team_views = isset($wp_rem_cs_var_team_views) ? $wp_rem_cs_var_team_views : '';
        $team_rand_id = rand(4444, 99999);


        $wp_rem_cs_section_title = '';

        if ( isset($wp_rem_cs_var_column_size) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists('wp_rem_cs_var_custom_column_class') ) {
                $column_class = wp_rem_cs_var_custom_column_class($wp_rem_cs_var_column_size);
            }
        }
        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '<div class="' . esc_html($column_class) . '">';
        }
        // wp_rem_title_sub_align(title,subtitle,align,style,seperator)
        $wp_rem_cs_section_title = wp_rem_title_sub_align($wp_rem_cs_var_team_title, $wp_rem_cs_var_team_subtitle, $wp_rem_var_team_align,'','classic');
        $html .= $wp_rem_cs_section_title;
        if ( $wp_rem_cs_var_team_views == 'medium' ) {
            $html .= '<div class="team team-medium">';
            $html .= '<div class="row">';
            $html .= do_shortcode($content);
            $html .= '</div>';
            $html .= '</div>';
        } elseif ( $wp_rem_cs_var_team_views == 'grid' ) {
            $html .= '<div class="team team-grid">';
            $html .= '<div class="row">';
            $html .= do_shortcode($content);
            $html .= '</div>';
            $html .= '</div>';
        } elseif ( $wp_rem_cs_var_team_views == 'classic' ) {
            $html .= '<div class="team team-grid classic team-classic-' . absint($team_rand_id) . '">';
            //$html .= '<div class="swiper-container">';
            //$html .= '<div class="swiper-wrapper">';
            $html .= do_shortcode($content);
            //$html .= '</div>';
            //$html .= '</div>';
            //$html .= '<div class="swiper-button-next">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_pagination_next') . '</div>';
            //$html .= '<div class="swiper-button-prev">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_pagination_prev') . '</div>';
            $html .= '</div>';
        } elseif ( $wp_rem_cs_var_team_views == 'grid-classic' ) {
            $html .= '<div class="team team-grid default">';
            $html .= '<div class="row">';
            $html .= do_shortcode($content);
            $html .= '</div>';
            $html .= '</div>';
        } elseif ( $wp_rem_cs_var_team_views == 'grid-classic-slider' ) {
            $html .= '<div class="team team-grid default team-grid-classic-' . absint($team_rand_id) . '">';
            $html .= '<div class="swiper-container">';
            $html .= '<div class="swiper-wrapper">';
            $html .= do_shortcode($content);
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="swiper-button-next">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_pagination_next') . '</div>';
            $html .= '<div class="swiper-button-prev">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_pagination_prev') . '</div>';
            $html .= '</div>';
        } else {
            $html .= '<div class="team team-grid-sm">';
            $html .= '<div class="row"> ';
            $html .= do_shortcode($content);
            $html .= ' </div>';
            $html .= '</div>';
        }

        if ( isset($column_class) && $column_class <> '' ) {
            $html .= '</div>';
        }
        if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
            $html .= '</div>';
        }
        return do_shortcode($html);
    }

}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('wp_rem_cs_team', 'wp_rem_cs_var_team_shortcode');

/*
 *
 * @List  Item  shortcode/element front end view
 * @retrun
 *
 */

if ( ! function_exists('wp_rem_cs_var_team_item_shortcode') ) {

    function wp_rem_cs_var_team_item_shortcode($atts, $content = "") {
        global $post, $wp_rem_cs_var_team_col, $wp_rem_cs_var_team_views, $team_rand_id;
        $defaults = array(
            'wp_rem_cs_var_team_name' => '',
            'wp_rem_cs_var_team_designation' => '',
            'wp_rem_cs_var_team_link' => '',
            'wp_rem_cs_var_team_image' => '',
            'wp_rem_cs_var_team_text' => '',
            'wp_rem_cs_var_team_email' => '',
            'wp_rem_cs_var_team_facebook' => '',
            'wp_rem_cs_var_team_twitter' => '',
            'wp_rem_cs_var_team_linkedin' => '',
            'wp_rem_cs_var_team_phone' => '',
        );
        extract(shortcode_atts($defaults, $atts));

        $wp_rem_cs_var_team_name = isset($wp_rem_cs_var_team_name) ? $wp_rem_cs_var_team_name : '';
        $wp_rem_cs_var_team_designation = isset($wp_rem_cs_var_team_designation) ? $wp_rem_cs_var_team_designation : '';
        $wp_rem_cs_var_team_link = isset($wp_rem_cs_var_team_link) ? $wp_rem_cs_var_team_link : '';
        $wp_rem_cs_var_team_image = isset($wp_rem_cs_var_team_image) ? $wp_rem_cs_var_team_image : '';
        $wp_rem_cs_var_team_text = isset($wp_rem_cs_var_team_text) ? $wp_rem_cs_var_team_text : '';
        $wp_rem_cs_var_team_email = isset($wp_rem_cs_var_team_email) ? $wp_rem_cs_var_team_email : '';
        $wp_rem_cs_var_team_facebook = isset($wp_rem_cs_var_team_facebook) ? $wp_rem_cs_var_team_facebook : '';
        $wp_rem_cs_var_team_twitter = isset($wp_rem_cs_var_team_twitter) ? $wp_rem_cs_var_team_twitter : '';
        $wp_rem_cs_var_team_linkedin = isset($wp_rem_cs_var_team_linkedin) ? $wp_rem_cs_var_team_linkedin : '';
        $wp_rem_cs_var_team_phone = isset($wp_rem_cs_var_team_phone) ? $wp_rem_cs_var_team_phone : '';

        $col_class = '';
        if ( isset($wp_rem_cs_var_team_col) && $wp_rem_cs_var_team_col != '' ) {
            $number_col = 12 / $wp_rem_cs_var_team_col;
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
        $html = '';

        $swiper_class = '';
        if ( $wp_rem_cs_var_team_views == 'grid-classic-slider' ) {
            $swiper_class = 'swiper-slide ';
        }
        if ( $wp_rem_cs_var_team_views <> 'small' ) {
            $html .= '<div class="' . esc_html($swiper_class) . esc_html($col_class) . '">';
        }

        $team_link = 'javascript:void(0)';
        if ( '' != $wp_rem_cs_var_team_link ) {
            $team_link = esc_url($wp_rem_cs_var_team_link);
        }
        if ( $wp_rem_cs_var_team_views == 'medium' ) {
            $html .= ' <div class="team-holder">';
            $html .= ' <div class="img-holder">';
            if ( $wp_rem_cs_var_team_image <> '' ) {
                $html .= ' <figure><a href="' . esc_html($team_link) . '"><img src="' . esc_url($wp_rem_cs_var_team_image) . '" alt=""></a></figure>';
            }
            $html .= ' </div>';

            $html .= '<div class="text-holder">';
            if ( $wp_rem_cs_var_team_name <> '' ) {
                $html .= ' <div class="post-title">';
                $html .= ' <h4><a href="' . esc_html($team_link) . '">' . esc_html($wp_rem_cs_var_team_name) . '</a></h4>';
                $html .= ' </div>';
            }
            if ( $wp_rem_cs_var_team_designation <> '' ) {
                $html .= ' <span class="post-designation">' . esc_html($wp_rem_cs_var_team_designation) . '</span>';
            }
            $html .= '<p>' . do_shortcode($content) . '</p>';
            $html .= '<div class="social-media">';
            $html .= '<ul>';
            if ( $wp_rem_cs_var_team_facebook <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_facebook) . '" data-original-title="facebook"><i class="icon-facebook5"></i></a></li>';
            }if ( $wp_rem_cs_var_team_twitter <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_twitter) . '" data-original-title="google"><i class="icon-google"></i></a></li>';
            }if ( $wp_rem_cs_var_team_linkedin <> '' ) {
                $html .= '<li><a href="#" data-original-title="linkedin"><i class="icon-linkedin4"></i></a></li>';
            }
            $html .= '</ul>';
            $html .= '</div>';
            if ( $wp_rem_cs_var_team_email <> '' ) {
                $html .= '<a href="mailto:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_team_email) . '" class="contact-btn text-color">' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_team_shortcode_contact_me') . '</a>';
            }
            $html .= ' </div>';
            $html .= ' </div>';
        } elseif ( $wp_rem_cs_var_team_views == 'grid' ) {
            $html .= '<div class="team-holder has-border center">';
            if ( $wp_rem_cs_var_team_image <> '' ) {
                $html .= '<div class="img-holder circle-img">';
                $html .= '<figure><a href="' . esc_html($team_link) . '"><img src="' . esc_url($wp_rem_cs_var_team_image) . '" alt=""></a></figure>';
                $html .= '</div>';
            }
            $html .= '<div class="text-holder">';
            if ( $wp_rem_cs_var_team_name <> '' ) {
                $html .= '<div class="post-title"><h5><a href="' . esc_html($team_link) . '">' . esc_html($wp_rem_cs_var_team_name) . '</a></h5></div>';
            }if ( $wp_rem_cs_var_team_designation <> '' ) {
                $html .= '<span class="post-designation">' . esc_html($wp_rem_cs_var_team_designation) . '</span>';
            }
            $html .= '<ul class="post-options">';
            if ( $wp_rem_cs_var_team_phone <> '' ) {
                $html .= '<li>' . wp_rem_cs_var_theme_text_srt('wp_rem_team_member_frontend_phone') . ' : ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_team_phone) . '</li>';
            }if ( $wp_rem_cs_var_team_email <> '' ) {
                $html .= '<li>' . wp_rem_cs_var_theme_text_srt('wp_rem_team_member_frontend_email') . ' :<a href="mailto:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_team_email) . '"> ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_team_email) . '</a></li>';
            }
            $html .= '</ul>';
            $html .= '<div class="social-media">';
            $html .= '<ul>';
            if ( $wp_rem_cs_var_team_facebook <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_facebook) . '"><i class="icon-facebook"></i></a></li>';
            }if ( $wp_rem_cs_var_team_twitter <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_twitter) . '"><i class="icon-twitter"></i></a></li>';
            }if ( $wp_rem_cs_var_team_linkedin <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_linkedin) . '"><i class="icon-linkedin"></i></a></li>';
            }

            $html .= '</ul>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        } elseif ( $wp_rem_cs_var_team_views == 'classic' ) {
            $html .= '<div class="team-holder has-border center">';
            if ( $wp_rem_cs_var_team_image <> '' ) {
                $html .= '<div class="img-holder circle-img">';
                $html .= '<figure><a href="' . wp_rem_cs_allow_special_char($team_link) . '"><img src="' . esc_url($wp_rem_cs_var_team_image) . '" alt=""></a></figure>';
                $html .= '</div>';
            }
            $html .= '<div class="text-holder">';
            if ( $wp_rem_cs_var_team_name <> '' ) {
                $html .= '<div class="post-title"><h5><a href="' . wp_rem_cs_allow_special_char($team_link) . '">' . esc_html($wp_rem_cs_var_team_name) . '</a></h5></div>';
            }
            if ( $wp_rem_cs_var_team_designation <> '' ) {
                $html .= '<span class="post-designation">' . esc_html($wp_rem_cs_var_team_designation) . '</span>';
            }
            
            $html .= '<div class="social-media">';
            $html .= '<ul>';
            if ( $wp_rem_cs_var_team_facebook <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_facebook) . '" data-original-title="facebook"><i class="icon-facebook-with-circle"></i></a></li>';
            }if ( $wp_rem_cs_var_team_twitter <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_twitter) . '" data-original-title="twitter"><i class="icon-twitter-with-circle"></i></a></li>';
            }if ( $wp_rem_cs_var_team_linkedin <> '' ) {
                $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_linkedin) . '" data-original-title="google"><i class="icon-google-with-circle"></i></a></li>';
            }
            $html .= '</ul>';
            $html .= '</div>';
            if ( $content != '' && $content != ' ' ) {
                $html .= apply_filters('the_content', $content);
            }
            //$html .= '<a href="' . wp_rem_cs_allow_special_char($team_link) . '" class="viewprofile-btn bgcolor">' . wp_rem_cs_var_theme_text_srt('wp_rem_team_member_frontend_view_profile') . '</a>';
            $html .= '</div>';
            $html .= '</div>';
            
        } elseif ( $wp_rem_cs_var_team_views == 'grid-classic' || $wp_rem_cs_var_team_views == 'grid-classic-slider' ) {
            $html .= '<div class="team-holder">';
            if ( $wp_rem_cs_var_team_image <> '' ) {
                $html .= '<div class="img-holder">';
                $html .= '<figure><a href="' . wp_rem_cs_allow_special_char($team_link) . '"><img src="' . esc_url($wp_rem_cs_var_team_image) . '" alt=""></a></figure>';
                $html .= '<div class="text-holder">';
                if ( $wp_rem_cs_var_team_name <> '' ) {
                    $html .= '<div class="post-title"><h5><a href="' . wp_rem_cs_allow_special_char($team_link) . '">' . esc_html($wp_rem_cs_var_team_name) . '</a></h5></div>';
                }
                if ( $wp_rem_cs_var_team_designation <> '' ) {
                    $html .= '<span class="post-designation">' . esc_html($wp_rem_cs_var_team_designation) . '</span>';
                }
                if ( $content != '' && $content != ' ' ) {
                    $html .= apply_filters('the_content', $content);
                }
                $html .= '<ul class="post-options">';
                if ( $wp_rem_cs_var_team_phone <> '' ) {
                    $html .= '<li>' . wp_rem_cs_var_theme_text_srt('wp_rem_team_member_frontend_phone') . ' : ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_team_phone) . '</li>';
                }if ( $wp_rem_cs_var_team_email <> '' ) {
                    $html .= '<li>' . wp_rem_cs_var_theme_text_srt('wp_rem_team_member_frontend_email') . ' :<a href="mailto:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_team_email) . '"> ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_team_email) . '</a></li>';
                }
                $html .= '</ul>';
                $html .= '<div class="social-media">';
                $html .= '<ul>';
                if ( $wp_rem_cs_var_team_facebook <> '' ) {
                    $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_facebook) . '" data-original-title="facebook"><i class="icon-facebook-with-circle"></i></a></li>';
                }if ( $wp_rem_cs_var_team_twitter <> '' ) {
                    $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_twitter) . '" data-original-title="twitter"><i class="icon-twitter-with-circle"></i></a></li>';
                }if ( $wp_rem_cs_var_team_linkedin <> '' ) {
                    $html .= '<li><a href="' . esc_url($wp_rem_cs_var_team_linkedin) . '" data-original-title="google"><i class="icon-google-with-circle"></i></a></li>';
                }
                $html .= '</ul>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>';
            if ( $wp_rem_cs_var_team_views == 'grid-classic-slider' ) {
                $wp_rem_cs_inline_script = '
				jQuery(document).ready(function ($) {
					if ("" != jQuery(".team-grid-classic-' . absint($team_rand_id) . ' .swiper-container").length) {
						new Swiper(".team-grid-classic-' . absint($team_rand_id) . ' .swiper-container", {
							nextButton: ".swiper-button-next",
							prevButton: ".swiper-button-prev",
							paginationClickable: !0,
							slidesPerView: 4,
							slidesPer: 1,
                                                        spaceBetween: 30,
							loop: !0,
							autoplay: 3000,
							speed: 2000,
							breakpoints: {
								1024: {
									slidesPerView: 3
								},
								768: {
									slidesPerView: 2
								},
								480: {
									slidesPerView: 1,
                                                                        spaceBetween: 0
								}
							}
						})
					}
				});';
                wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-functions');
            }
        } else {
            $html .= ' <div class="col-lg-1 col-md-2 col-sm-4 col-xs-6"> ';
            if ( $wp_rem_cs_var_team_image <> '' ) {
                $html .= '<div class="img-holder">';
                $html .= '<figure><a href="' . esc_html($team_link) . '"><img src="' . esc_url($wp_rem_cs_var_team_image) . '" alt=""></a></figure>';
                $html .= '</div>';
            }
            $html .= ' </div> ';
        }
        if ( $wp_rem_cs_var_team_views <> 'small' ) {
            $html .= ' </div>';
        }
        return do_shortcode($html);
    }

}
if ( function_exists('wp_rem_cs_var_short_code') )
    wp_rem_cs_var_short_code('wp_rem_cs_team_item', 'wp_rem_cs_var_team_item_shortcode');


