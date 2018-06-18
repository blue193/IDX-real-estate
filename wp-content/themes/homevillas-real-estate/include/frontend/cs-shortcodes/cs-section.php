<?php
/*
 *
 * @Shortcode Name : Start function for Section shortcode/element front end view
 * @retrun
 *
 */

if ( ! function_exists( 'wp_rem_cs_var_section_shortocde' ) ) { 
    function wp_rem_cs_var_section_shortocde( $atts, $content = "" ) { 
        global $post;
        $wp_rem_cs_section_titlt_color = $wp_rem_cs_section_subtitlt_color = $wp_rem_cs_section_bg_image = $wp_rem_cs_var_section_title = $wp_rem_cs_var_section_subtitle = $title_sub_title_alignment = $wp_rem_cs_section_bg_image_position = $wp_rem_cs_section_bg_image_repeat = $wp_rem_cs_section_bg_color = $wp_rem_cs_section_padding_top = $wp_rem_cs_section_padding_bottom = $wp_rem_cs_section_custom_style = $wp_rem_cs_section_css_id = $wp_rem_cs_layout = $wp_rem_cs_sidebar_left = $wp_rem_cs_sidebar_right = $css_bg_image = '';
        $section_style_elements = '';
        $wp_rem_cs_page_layout   = '';
        $section_container_style_elements = '';
        $wp_rem_cs_section_nopadding    = '';
        $wp_rem_cs_section_nomargin    = '';
        if( isset( $post->ID ) ){
            $wp_rem_cs_page_layout = get_post_meta( $post->ID, 'wp_rem_cs_var_page_layout', true );
        }
        $wp_rem_cs_page_inline_style = '';
        $section_video_element = '';
        $wp_rem_cs_section_bg_color = '';
        $wp_rem_cs_section_view = 'container';
        $wp_rem_cs_section_rand_id = rand( 123456, 987654 );
        $column_container = '';
        extract( $atts );
        if ( isset( $column_container ) ) {
            $column_class = isset( $class ) ? $class : '';
            $parallax_class = '';
            $parallax_data_type = '';
            if ( isset( $wp_rem_cs_section_parallax ) && (string) $wp_rem_cs_section_parallax == 'yes' ) {
                $parallax_class = ($wp_rem_cs_section_parallax == 'yes') ? 'parallex-bg' : '';
                $parallax_data_type = ' data-type="background"';
            }

            if ( isset( $wp_rem_cs_section_border_color ) && $wp_rem_cs_section_border_color != '' ) {
                $section_style_elements .= '';
            }
            
            if ( wp_is_mobile() ) {
                
                if ( isset( $wp_rem_cs_section_margin_top_mobile ) && $wp_rem_cs_section_margin_top_mobile != '' && $wp_rem_cs_section_margin_top_mobile != 0 ) {
                    $wp_rem_cs_section_margin_top   = $wp_rem_cs_section_margin_top_mobile;
                }
                if ( isset( $wp_rem_cs_section_padding_top_mobile ) && $wp_rem_cs_section_padding_top_mobile != '' && $wp_rem_cs_section_padding_top_mobile != 0 ) {
                    $wp_rem_cs_section_padding_top   = $wp_rem_cs_section_padding_top_mobile;
                }
                if ( isset( $wp_rem_cs_section_padding_bottom_mobile ) && $wp_rem_cs_section_padding_bottom_mobile != '' && $wp_rem_cs_section_padding_bottom_mobile != 0 ) {
                    $wp_rem_cs_section_padding_bottom   = $wp_rem_cs_section_padding_bottom_mobile;
                }
                if ( isset( $wp_rem_cs_section_margin_bottom_mobile ) && $wp_rem_cs_section_margin_bottom_mobile != '' && $wp_rem_cs_section_margin_bottom_mobile != 0 ) {
                    $wp_rem_cs_section_margin_bottom   = $wp_rem_cs_section_margin_bottom_mobile;
                }
                
            }
            if ( isset( $wp_rem_cs_section_margin_top ) && $wp_rem_cs_section_margin_top != '' && $wp_rem_cs_section_margin_top != 0 ) {
                $section_style_elements .= 'margin-top: ' . $wp_rem_cs_section_margin_top . 'px;';
            }
            if ( isset( $wp_rem_cs_section_padding_top ) && $wp_rem_cs_section_padding_top != '' && $wp_rem_cs_section_padding_top != 0 ) {
                $section_style_elements .= 'padding-top: ' . $wp_rem_cs_section_padding_top . 'px;';
            }
            if ( isset( $wp_rem_cs_section_padding_bottom ) && $wp_rem_cs_section_padding_bottom != '' && $wp_rem_cs_section_padding_bottom != 0 ) {
                $section_style_elements .= 'padding-bottom: ' . $wp_rem_cs_section_padding_bottom . 'px;';
            }
            if ( isset( $wp_rem_cs_section_margin_bottom ) && $wp_rem_cs_section_margin_bottom != '' && $wp_rem_cs_section_margin_bottom != 0 ) {
                $section_style_elements .= 'margin-bottom: ' . $wp_rem_cs_section_margin_bottom . 'px;';
            }
            if ( isset( $wp_rem_cs_section_border_top ) && $wp_rem_cs_section_border_top != '' ) {
                $section_style_elements .= 'border-top: ' . $wp_rem_cs_section_border_top . 'px ' . $wp_rem_cs_section_border_color . ' solid;';
            }
            if ( isset( $wp_rem_cs_section_border_bottom ) && $wp_rem_cs_section_border_bottom != '' ) {
                $section_style_elements .= 'border-bottom: ' . $wp_rem_cs_section_border_bottom . 'px ' . $wp_rem_cs_section_border_color . ' solid;';
            }
            if ( isset( $wp_rem_cs_section_background_option ) && $wp_rem_cs_section_background_option == 'section-custom-background-image' ) {
                $wp_rem_cs_section_bg_imageg = '';
                if ( isset( $wp_rem_cs_section_bg_image ) && $wp_rem_cs_section_bg_image != '' ) {
                    if ( isset( $wp_rem_cs_section_parallax ) && (string) $wp_rem_cs_section_parallax == 'yes' ) {
                        $wp_rem_cs_paralax_str = false !== strpos( $wp_rem_cs_section_bg_image_position, 'fixed' ) ? '' : ' fixed';
                        $wp_rem_cs_section_bg_imageg = 'url(' . $wp_rem_cs_section_bg_image . ') ' . $wp_rem_cs_section_bg_image_position . ' ' . $wp_rem_cs_paralax_str;
                    } else {
                        $wp_rem_cs_section_bg_imageg = 'url(' . $wp_rem_cs_section_bg_image . ') ' . $wp_rem_cs_section_bg_image_position . ' ';
                    }
                }
                $section_style_elements .= 'background: ' . $wp_rem_cs_section_bg_imageg . ' ' . $wp_rem_cs_section_bg_color . ';';
            } else if ( isset( $wp_rem_cs_section_background_option ) && $wp_rem_cs_section_background_option == 'section_background_video' ) {
                $mute_flag = $mute_control = '';
                $mute_flag = 'true';
                if ( $wp_rem_cs_section_video_mute == 'yes' ) {
                    $mute_flag = 'false';
                    $mute_control = 'controls muted ';
                }
                $wp_rem_cs_video_autoplay = 'autoplay';
                if ( $wp_rem_cs_section_video_autoplay == 'yes' ) {
                    $wp_rem_cs_video_autoplay = 'autoplay';
                } else {
                    $wp_rem_cs_video_autoplay = '';
                }
                $section_video_class = 'video-parallex';
                $url = parse_url( $wp_rem_cs_section_video_url );
                if ( $url['host'] == $_SERVER["SERVER_NAME"] ) {
                    $file_type = wp_check_filetype( $wp_rem_cs_section_video_url );
                    if ( isset( $file_type['type'] ) && $file_type['type'] <> '' ) {
                        $file_type = $file_type['type'];
                    } else {
                        $file_type = 'video/mp4';
                    }
                    $rand_player_id = rand( 6, 555 );
                    $section_video_element = '<div class="page-section-video cs-section-video">
                                    <video id="player' . wp_rem_cs_allow_special_char( $rand_player_id ) . '" width="100%" height="100%" ' . wp_rem_cs_allow_special_char( $wp_rem_cs_video_autoplay ) . ' loop="true" preload="none" volume="false" controls="controls" class="nectar-video-bg   cs-video-element"  ' . wp_rem_cs_allow_special_char( $mute_control ) . ' >
                                        <source src="' . esc_url( $wp_rem_cs_section_video_url ) . '" type="' . wp_rem_cs_allow_special_char( $file_type ) . '">
                                    </video>
                                </div>';
                } else {
                    $section_video_element = wp_oembed_get( $wp_rem_cs_section_video_url, array( 'height' => '1083' ) );
                }
            } else {
                if ( isset( $wp_rem_cs_section_bg_color ) && $wp_rem_cs_section_bg_color != '' ) {
                    $section_style_elements .= 'background: ' . esc_attr( $wp_rem_cs_section_bg_color ) . ';';
                }
            }


            if ( isset( $wp_rem_cs_section_padding_top ) && $wp_rem_cs_section_padding_top != '' ) {
                $section_container_style_elements .= 'padding-top: ' . esc_html($wp_rem_cs_section_padding_top) . 'px; ';
            }
            if ( isset( $wp_rem_cs_section_padding_bottom ) && $wp_rem_cs_section_padding_bottom != '' ) {
                $section_container_style_elements .= 'padding-bottom: ' . esc_html($wp_rem_cs_section_padding_bottom) . 'px; ';
            }
            if ( isset( $wp_rem_cs_section_css_id ) && trim( $wp_rem_cs_section_css_id ) != '' ) {
                $wp_rem_cs_section_css_id = 'id="' . esc_html($wp_rem_cs_section_css_id) . '"';
            }

            $page_element_size = 'section-fullwidth';
            if ( ! isset( $wp_rem_cs_layout ) || $wp_rem_cs_layout == '' || $wp_rem_cs_layout == 'none' ) {
                $wp_rem_cs_layout = "none";
                $page_element_size = 'section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12';
            } else {
                $page_element_size = 'section-content col-lg-8 col-md-8 col-sm-12 col-xs-12 ';
            }
        }
        if ( isset( $wp_rem_cs_section_bg_image ) && $wp_rem_cs_section_bg_image <> '' && $wp_rem_cs_section_background_option == 'section-custom-background-image' ) {
            $css_bg_image = 'url(' . esc_html($wp_rem_cs_section_bg_image) . ')';
        }

        $section_style_element = '';
        if ( $section_style_elements ) {
            $section_style_element = 'style="' . $section_style_elements . '"';
            $wp_rem_cs_page_inline_style .= ".cs-page-sec-{$wp_rem_cs_section_rand_id}{{$section_style_elements}}";
        }
        if ( $section_container_style_elements ) {
            $section_container_style_elements = 'style="' . esc_html($section_container_style_elements) . '"';
        }
        ?>
        <!-- Page Section -->
        <?php
        $paddingClass = ($wp_rem_cs_section_nopadding == 'yes') ? 'nopadding' : '';
        $marginClass = ($wp_rem_cs_section_nomargin == 'yes') ? 'cs-nomargin' : '';
        ?>
        <div <?php echo wp_rem_cs_allow_special_char( $wp_rem_cs_section_css_id ); ?> class="page-section cs-page-sec-<?php echo absint( $wp_rem_cs_section_rand_id ) ?> <?php echo sanitize_html_class( $parallax_class ); ?> <?php echo sanitize_html_class( $paddingClass ); ?> <?php echo sanitize_html_class( $marginClass ); ?>" <?php echo wp_rem_cs_allow_special_char( $parallax_data_type ); ?>  <?php //echo wp_rem_cs_allow_special_char($section_style_element);     ?> >
            <?php
            echo wp_rem_cs_allow_special_char( $section_video_element );
            if ( isset( $wp_rem_cs_section_background_option ) && $wp_rem_cs_section_background_option == 'section-custom-slider' ) {
                if ( isset( $wp_rem_cs_section_custom_slider ) && $wp_rem_cs_section_custom_slider != '' ) {
                    echo do_shortcode( '[rev_slider alias="'.$wp_rem_cs_section_custom_slider.'"]' );
                }
            }
            if ( $wp_rem_cs_page_layout == '' || $wp_rem_cs_page_layout == 'none' ) {
                if ( $wp_rem_cs_section_view == 'container' ) {
                    $wp_rem_cs_section_view = 'container';
                } else {
                    $wp_rem_cs_section_view = 'wide';
                }
            } else {
                $wp_rem_cs_section_view = '';
            }
            
            
            if ( $wp_rem_cs_page_inline_style != '' ) {
                ?>
                <script type="text/javascript">
                    if( jQuery("#inline-style-functions-inline-css").length == 0 ){  
                        jQuery("head").append('<style id="inline-style-functions-inline-css" type="text/css"></style>');
                    }
                </script>
                <?php
                echo '<script type="text/javascript">
                jQuery("#inline-style-functions-inline-css").append("'.$wp_rem_cs_page_inline_style.'");
            </script>';
            }
        
            ?>
            <!-- Container Start -->

            <div class="<?php echo sanitize_html_class( $wp_rem_cs_section_view ); ?> "> 
                <?php
                if ( isset( $wp_rem_cs_layout ) && ( $wp_rem_cs_layout != '' || $wp_rem_cs_layout != 'none' ) ) {
                    ?>
                    <div class="row">
                        <?php
                    }
                    // start page section
                    if ( $wp_rem_cs_var_section_title != '' || $wp_rem_cs_var_section_subtitle != '' ) {
                        $title_align = '';
                        if ( $title_sub_title_alignment <> '' ) {
                            $title_align = ' style="text-align:' . $title_sub_title_alignment . '!important;"';
                        }
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="section-title" <?php echo force_balance_tags( $title_align ); ?>>
                                <?php if ( $wp_rem_cs_var_section_title != '' ) { ?>
                                    <h2 style="color:<?php echo esc_html($wp_rem_cs_section_titlt_color); ?> !important;"><?php echo esc_html( $wp_rem_cs_var_section_title );
                                    ?></h2>
                                <?php } if ( $wp_rem_cs_var_section_subtitle != '' ) { ?>
                                    <span style="color:<?php echo esc_html($wp_rem_cs_section_subtitlt_color); ?> !important;"><?php echo do_shortcode( $wp_rem_cs_var_section_subtitle ) ?></span>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                    } // end page section
                    if ( isset( $wp_rem_cs_layout ) && $wp_rem_cs_layout == "left" && $wp_rem_cs_sidebar_left <> '' ) {
                        echo '<aside class="section-sidebar left col-lg-4 col-md-4 col-sm-12 col-xs-12">';
                        if ( is_active_sidebar( wp_rem_cs_get_sidebar_id( $wp_rem_cs_sidebar_left ) ) ) {
                            if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $wp_rem_cs_sidebar_left ) ) : endif;
                        }
                        echo '</aside>';
                    }
                    $wp_rem_cs_node_id = 0;

                    echo '<div class="' . esc_attr($page_element_size) . '">';
                    echo '<div class="row">';

                    echo do_shortcode( $content );

                    echo '</div><!-- end section row -->';
                    echo '</div>';
                    if ( isset( $wp_rem_cs_layout ) && $wp_rem_cs_layout == "right" && $wp_rem_cs_sidebar_right <> '' ) {
                        echo '<aside class="section-sidebar right col-lg-4 col-md-4 col-sm-12 col-xs-12">';
                        if ( is_active_sidebar( wp_rem_cs_get_sidebar_id( $wp_rem_cs_sidebar_right ) ) ) {
                            if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $wp_rem_cs_sidebar_right ) ) : endif;
                        }
                        echo '</aside>';
                    }
                    if ( isset( $wp_rem_cs_layout ) && ( $wp_rem_cs_layout != '' || $wp_rem_cs_layout != 'none' ) ) {
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>  <!-- End Container Start -->
        </div> <!-- End Page Section -->
        <?php
        $column_no = 0;
        
        
    } 
    if ( function_exists( 'wp_rem_cs_var_short_code' ) && !is_admin() )
        wp_rem_cs_var_short_code( 'section', 'wp_rem_cs_var_section_shortocde' ); 
}