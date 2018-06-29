<?php
/**
 * The template for 
 * displaying shop page
 */
get_header();
$var_arrays = array( 'post', 'wp_rem_cs_node', 'wp_rem_cs_sidebarLayout', 'column_class', 'wp_rem_cs_xmlObject', 'wp_rem_cs_node_id', 'column_attributes', 'wp_rem_cs_elem_id' );
$page_global_vars = WP_REM_CS_VAR_GLOBALS()->globalizing( $var_arrays );
extract( $page_global_vars );

if ( is_shop() ) {

    $wp_rem_cs_shop_id = woocommerce_get_page_id( 'shop' );

    $wp_rem_cs_page_bulider = get_post_meta( $wp_rem_cs_shop_id, "wp_rem_cs_page_builder", true );

    $wp_rem_cs_xmlObject = new stdClass();
    if ( isset( $wp_rem_cs_page_bulider ) && $wp_rem_cs_page_bulider <> '' ) {
        $wp_rem_cs_xmlObject = new SimpleXMLElement( $wp_rem_cs_page_bulider );
    }
    ?>
    <!-- Main Content Section -->
    <div class="main-section">
        <?php
        $wp_rem_cs_page_sidebar_right = '';
        $wp_rem_cs_page_sidebar_left = '';
        $wp_rem_cs_postObject = get_post_meta( $wp_rem_cs_shop_id, 'wp_rem_cs_var_full_data', true );
        $wp_rem_cs_page_layout = get_post_meta( $wp_rem_cs_shop_id, 'wp_rem_cs_var_page_layout', true );
        $wp_rem_cs_page_sidebar_right = get_post_meta( $wp_rem_cs_shop_id, 'wp_rem_cs_var_page_sidebar_right', true );
        $wp_rem_cs_page_sidebar_left = get_post_meta( $wp_rem_cs_shop_id, 'wp_rem_cs_var_page_sidebar_left', true );
        $wp_rem_cs_page_bulider = get_post_meta( $wp_rem_cs_shop_id, "wp_rem_cs_page_builder", true );
        $section_container_width = '';
        $page_element_size = 'page-content-fullwidth';

        if ( ! isset( $wp_rem_cs_page_layout ) || $wp_rem_cs_page_layout == "none" ) {
            $page_element_size = 'page-content-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12';
        } else {
            $page_element_size = 'page-content col-lg-9 col-md-9 col-sm-12 col-xs-12';
        }
        $wp_rem_cs_xmlObject = new stdClass();

        if ( isset( $wp_rem_cs_page_bulider ) && $wp_rem_cs_page_bulider <> '' ) {
            $wp_rem_cs_xmlObject = new SimpleXMLElement( $wp_rem_cs_page_bulider );
        }
        if ( isset( $wp_rem_cs_page_layout ) ) {
            $wp_rem_cs_sidebarLayout = $wp_rem_cs_page_layout;
        }
        $pageSidebar = false;
        if ( $wp_rem_cs_sidebarLayout == 'left' || $wp_rem_cs_sidebarLayout == 'right' ) {
            $pageSidebar = true;
        }

        if ( isset( $wp_rem_cs_xmlObject ) && count( $wp_rem_cs_xmlObject ) > 1 ) {
			if ($pageSidebar === true) {
				echo '<div class="col-xs-12">';
			}
            if ( isset( $wp_rem_cs_page_layout ) ) {
                $wp_rem_cs_page_sidebar_right = $wp_rem_cs_page_sidebar_right;
                $wp_rem_cs_page_sidebar_left = $wp_rem_cs_page_sidebar_left;
            }
            $wp_rem_cs_counter_node = $column_no = 0;
            $fullwith_style = '';
            $section_container_style_elements = ' ';
            if ( isset( $wp_rem_cs_page_layout ) && $wp_rem_cs_sidebarLayout <> '' and $wp_rem_cs_sidebarLayout <> "none" ) {

                $fullwith_style = 'style="width:100%;"';
                $section_container_style_elements = ' width: 100%;';
                echo '<div class="container">';
                echo '<div class="row">';

                if ( isset( $wp_rem_cs_page_layout ) && $wp_rem_cs_sidebarLayout <> '' and $wp_rem_cs_sidebarLayout <> "none" and $wp_rem_cs_sidebarLayout == 'left' ) :
                    if ( is_active_sidebar( wp_rem_cs_get_sidebar_id( $wp_rem_cs_page_sidebar_left ) ) ) {
                        ?>
                        <aside class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $wp_rem_cs_page_sidebar_left ) ) : endif; ?>
                        </aside>
                        <?php
                    }
                endif;
                echo '<div class="' . ($page_element_size) . '">';
            } 

            if ( post_password_required() ) {
                echo '<header class="heading"><h6 class="transform">' . get_the_title( $wp_rem_cs_shop_id ) . '</h6></header>';
                echo wp_rem_cs_password_form();
            } else {
                $width = 840;
                $height = 328;
                $wp_rem_cs_post_thumbnail_id = get_post_thumbnail_id( $wp_rem_cs_shop_id );
                $image_url = wp_rem_cs_attachment_image_src( $wp_rem_cs_post_thumbnail_id, $width, $height );
                wp_reset_postdata();

                if ( $pageSidebar != true ) {
                    ?>
                    <div class="page-section">
                        <div class="container">
                            <div class="row">
                                <?php
                            }
                            if ( isset( $image_url ) && $image_url != '' ) {
                                ?>
                                <a href="<?php echo esc_url( $image_url ); ?>" data-rel="prettyPhoto" data-title="">
                                    <figure>
                                        <div class="page-featured-image">
                                            <img class="img-thumbnail cs-page-thumbnail" title="" alt="" data-src="" src="<?php echo esc_url( $image_url ); ?>">
                                        </div>
                                    </figure>
                                </a>
                                <?php
                            }
                            $content_post = get_post( $wp_rem_cs_shop_id );
                            if ( is_object( $content_post ) ) {
                                $content = $content_post->post_content;

                                if ( trim( $content ) <> '' ) {
                                    echo '<div class="cs-shop-wrap"><div class="cs-rich-editor">';
                                    $content = apply_filters( 'the_content', $content );
                                    $content = str_replace( ']]>', ']]&gt;', $content );
                                    echo do_shortcode( $content );
                                    echo '</div></div>';
                                }
                            }
                            if ( $pageSidebar != true ) {
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
				 if ( $pageSidebar != true ) {
                    ?>
                    <div class="page-section">
                        <div class="container">
							<?php
                            }
                            get_template_part( 'woocommerce/products-loop', 'page' );
                            if ( $pageSidebar != true ) {
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }

            if ( isset( $wp_rem_cs_xmlObject->column_container ) ) {
                $wp_rem_cs_elem_id = 0;
            }
            foreach ( $wp_rem_cs_xmlObject->column_container as $column_container ) {

                $wp_rem_cs_section_bg_image = $wp_rem_cs_var_section_title = $wp_rem_cs_var_section_subtitle = $wp_rem_cs_section_bg_image_position = $wp_rem_cs_section_bg_image_repeat = $wp_rem_cs_section_bg_color = $wp_rem_cs_section_padding_top = $wp_rem_cs_section_padding_bottom = $wp_rem_cs_section_custom_style = $wp_rem_cs_section_css_id = $wp_rem_cs_layout = $wp_rem_cs_sidebar_left = $wp_rem_cs_sidebar_right = $css_bg_image = '';
                $section_style_elements = '';
                $section_container_style_elements = '';
                $section_video_element = '';
                $wp_rem_cs_section_bg_color = '';
                $wp_rem_cs_section_view = 'container';
                if ( isset( $column_container ) ) {

                    $column_attributes = $column_container->attributes();
                    $column_class = $column_attributes->class;
                    $parallax_class = '';
                    $parallax_data_type = '';
                    $wp_rem_cs_section_parallax = $column_attributes->wp_rem_cs_section_parallax;
                    if ( isset( $wp_rem_cs_section_parallax ) && (string) $wp_rem_cs_section_parallax == 'yes' ) {

                        $parallax_class = ($wp_rem_cs_section_parallax == 'yes') ? 'parallex-bg' : '';
                        $parallax_data_type = ' data-type="background"';
                    }
                    $wp_rem_cs_var_section_title = $column_attributes->wp_rem_cs_var_section_title;
                    $wp_rem_cs_var_section_subtitle = $column_attributes->wp_rem_cs_var_section_subtitle;
                    $wp_rem_cs_section_margin_top = $column_attributes->wp_rem_cs_section_margin_top;
                    $wp_rem_cs_section_margin_bottom = $column_attributes->wp_rem_cs_section_margin_bottom;
                    $wp_rem_cs_section_padding_top = $column_attributes->wp_rem_cs_section_padding_top;
                    $wp_rem_cs_section_padding_bottom = $column_attributes->wp_rem_cs_section_padding_bottom;
                    $wp_rem_cs_section_view = $column_attributes->wp_rem_cs_section_view;
                    $wp_rem_cs_section_border_color = $column_attributes->wp_rem_cs_section_border_color;
                    if ( isset( $wp_rem_cs_section_border_color ) && $wp_rem_cs_section_border_color != '' ) {
                        $section_style_elements .= '';
                    }
                    if ( isset( $wp_rem_cs_section_margin_top ) && $wp_rem_cs_section_margin_top != '' ) {
                        $section_style_elements .= 'margin-top: ' . $wp_rem_cs_section_margin_top . 'px;';
                    }
                    if ( isset( $wp_rem_cs_section_padding_top ) && $wp_rem_cs_section_padding_top != '' ) {
                        $section_style_elements .= 'padding-top: ' . $wp_rem_cs_section_padding_top . 'px;';
                    }
                    if ( isset( $wp_rem_cs_section_padding_bottom ) && $wp_rem_cs_section_padding_bottom != '' ) {
                        $section_style_elements .= 'padding-bottom: ' . $wp_rem_cs_section_padding_bottom . 'px;';
                    }
                    if ( isset( $wp_rem_cs_section_margin_bottom ) && $wp_rem_cs_section_margin_bottom != '' ) {
                        $section_style_elements .= 'margin-bottom: ' . $wp_rem_cs_section_margin_bottom . 'px;';
                    }
                    $wp_rem_cs_section_border_top = $column_attributes->wp_rem_cs_section_border_top;
                    $wp_rem_cs_section_border_bottom = $column_attributes->wp_rem_cs_section_border_bottom;
                    if ( isset( $wp_rem_cs_section_border_top ) && $wp_rem_cs_section_border_top != '' ) {
                        $section_style_elements .= 'border-top: ' . $wp_rem_cs_section_border_top . 'px ' . $wp_rem_cs_section_border_color . ' solid;';
                    }
                    if ( isset( $wp_rem_cs_section_border_bottom ) && $wp_rem_cs_section_border_bottom != '' ) {
                        $section_style_elements .= 'border-bottom: ' . $wp_rem_cs_section_border_bottom . 'px ' . $wp_rem_cs_section_border_color . ' solid;';
                    }
                    $wp_rem_cs_section_background_option = $column_attributes->wp_rem_cs_section_background_option;
                    $wp_rem_cs_section_bg_image_position = $column_attributes->wp_rem_cs_section_bg_image_position;
                    if ( isset( $column_attributes->wp_rem_cs_section_bg_color ) )
                        $wp_rem_cs_section_bg_color = $column_attributes->wp_rem_cs_section_bg_color;
                    if ( isset( $wp_rem_cs_section_background_option ) && $wp_rem_cs_section_background_option == 'section-custom-background-image' ) {
                        $wp_rem_cs_section_bg_image = $column_attributes->wp_rem_cs_section_bg_image;
                        $wp_rem_cs_section_bg_image_position = $column_attributes->wp_rem_cs_section_bg_image_position;
                        $wp_rem_cs_section_bg_imageg = '';
                        if ( isset( $wp_rem_cs_section_bg_image ) && $wp_rem_cs_section_bg_image != '' ) {
                            if ( isset( $wp_rem_cs_section_parallax ) && (string) $wp_rem_cs_section_parallax == 'yes' ) {
                                $wp_rem_cs_section_bg_imageg = 'url(' . $wp_rem_cs_section_bg_image . ') ' . $wp_rem_cs_section_bg_image_position . ' ' . ' fixed';
                            } else {
                                $wp_rem_cs_section_bg_imageg = 'url(' . $wp_rem_cs_section_bg_image . ') ' . $wp_rem_cs_section_bg_image_position . ' ';
                            }
                        }
                        $section_style_elements .= 'background: ' . $wp_rem_cs_section_bg_imageg . ' ' . $wp_rem_cs_section_bg_color . ';';
                    } else if ( isset( $wp_rem_cs_section_background_option ) && $wp_rem_cs_section_background_option == 'section_background_video' ) {
                        $wp_rem_cs_section_video_url = $column_attributes->wp_rem_cs_section_video_url;
                        $wp_rem_cs_section_video_mute = $column_attributes->wp_rem_cs_section_video_mute;
                        $wp_rem_cs_section_video_autoplay = $column_attributes->wp_rem_cs_section_video_autoplay;
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
                                        <video id="player' . $rand_player_id . '" width="100%" height="100%" ' . $wp_rem_cs_video_autoplay . ' loop="true" preload="none" volume="false" controls="controls" class="nectar-video-bg   cs-video-element"  ' . $mute_control . ' >
                                            <source src="' . esc_url( $wp_rem_cs_section_video_url ) . '" type="' . $file_type . '">
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
                    $wp_rem_cs_section_padding_top = $column_attributes->wp_rem_cs_section_padding_top;
                    $wp_rem_cs_section_padding_bottom = $column_attributes->wp_rem_cs_section_padding_bottom;
                    if ( isset( $wp_rem_cs_section_padding_top ) && $wp_rem_cs_section_padding_top != '' ) {
                        $section_container_style_elements .= 'padding-top: ' . $wp_rem_cs_section_padding_top . 'px; ';
                    }
                    if ( isset( $wp_rem_cs_section_padding_bottom ) && $wp_rem_cs_section_padding_bottom != '' ) {
                        $section_container_style_elements .= 'padding-bottom: ' . $wp_rem_cs_section_padding_bottom . 'px; ';
                    }
                    $wp_rem_cs_section_custom_style = $column_attributes->wp_rem_cs_section_custom_style;
                    $wp_rem_cs_section_css_id = $column_attributes->wp_rem_cs_section_css_id;
                    if ( isset( $wp_rem_cs_section_css_id ) && trim( $wp_rem_cs_section_css_id ) != '' ) {
                        $wp_rem_cs_section_css_id = 'id="' . $wp_rem_cs_section_css_id . '"';
                    }

                    $page_element_size = 'section-fullwidth';
                    $wp_rem_cs_layout = $column_attributes->wp_rem_cs_layout;
                    if ( ! isset( $wp_rem_cs_layout ) || $wp_rem_cs_layout == '' || $wp_rem_cs_layout == 'none' ) {
                        $wp_rem_cs_layout = "none";
                        $page_element_size = 'section-fullwidth col-lg-12 col-md-12 col-sm-12 col-xs-12';
                    } else {
                        $page_element_size = 'section-content col-lg-9 col-md-9 col-sm-12 col-xs-12 ';
                    }
                    $wp_rem_cs_sidebar_left = $column_attributes->wp_rem_cs_sidebar_left;
                    $wp_rem_cs_sidebar_right = $column_attributes->wp_rem_cs_sidebar_right;
                }
                if ( isset( $wp_rem_cs_section_bg_image ) && $wp_rem_cs_section_bg_image <> '' && $wp_rem_cs_section_background_option == 'section-custom-background-image' ) {
                    $css_bg_image = 'url(' . $wp_rem_cs_section_bg_image . ')';
                }

                $section_style_element = '';
                if ( $section_style_elements ) {
                    $section_style_element = 'style="' . $section_style_elements . '"';
                }
                if ( $section_container_style_elements ) {
                    $section_container_style_elements = 'style="' . $section_container_style_elements . '"';
                }
                ?>
                <!-- Page Section -->
                <div <?php echo wp_rem_cs_allow_special_char( $wp_rem_cs_section_css_id ); ?> class="page-section <?php echo sanitize_html_class( $parallax_class ); ?>" <?php echo wp_rem_cs_allow_special_char( $parallax_data_type ); ?>  <?php echo wp_rem_cs_allow_special_char( $section_style_element ); ?> >
                    <?php
                    echo wp_rem_cs_allow_special_char( $section_video_element );
                    if ( isset( $wp_rem_cs_section_background_option ) && $wp_rem_cs_section_background_option == 'section-custom-slider' ) {
                        $wp_rem_cs_section_custom_slider = $column_attributes->wp_rem_cs_section_custom_slider;
                        if ( $wp_rem_cs_section_custom_slider != '' ) {
                            echo do_shortcode( $wp_rem_cs_section_custom_slider );
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
                                ?>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="section-title" style="margin-bottom:27px;">
                                        <?php if ( $wp_rem_cs_var_section_title != '' ) { ?>
                                            <h2 style="font-size:24px !important; letter-spacing:1px !important; text-align:center; margin-bottom:20px;"><?php echo esc_html( $wp_rem_cs_var_section_title ) ?></h2>
                                        <?php } if ( $wp_rem_cs_var_section_subtitle != '' ) { ?>
                                            <p><?php echo esc_html( $wp_rem_cs_var_section_subtitle ) ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php
                            }// end page section
                            if ( isset( $wp_rem_cs_layout ) && $wp_rem_cs_layout == "left" && $wp_rem_cs_sidebar_left <> '' ) {
                                echo '<aside class="section-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">';
                                if ( is_active_sidebar( wp_rem_cs_get_sidebar_id( $wp_rem_cs_sidebar_left ) ) ) {
                                    if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $wp_rem_cs_sidebar_left ) ) : endif;
                                }
                                echo '</aside>';
                            }
                            $wp_rem_cs_node_id = 0;
                            echo '<div class="' . ($page_element_size) . ' ">';
                            echo '<div class="row">';

                            foreach ( $column_container->children() as $column ) {
                                $column_no ++;
                                $wp_rem_cs_node_id ++;
                                foreach ( $column->children() as $wp_rem_cs_node ) {

                                    $wp_rem_cs_elem_id ++;
                                    $page_element_size = '100';
                                    if ( isset( $wp_rem_cs_node->page_element_size ) )
                                        $page_element_size = $wp_rem_cs_node->page_element_size;
                                    echo '<div class="' . wp_rem_cs_var_page_builder_element_sizes( $page_element_size ) . '">';
                                    $shortcode = trim( (string) $wp_rem_cs_node->wp_rem_cs_shortcode );
                                    $shortcode = html_entity_decode( $shortcode );
                                    echo do_shortcode( $shortcode );
                                    echo '</div>';
                                }
                            }
                            echo '</div></div>';
                            if ( isset( $wp_rem_cs_layout ) && $wp_rem_cs_layout == "right" && $wp_rem_cs_sidebar_right <> '' ) {
                                echo '<aside class="section-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">';
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
                    </div>
                </div>
                <?php
                $column_no = 0;
            }
            if ( isset( $wp_rem_cs_page_layout ) && $wp_rem_cs_sidebarLayout <> '' && $wp_rem_cs_sidebarLayout <> "none" ) {

                echo '</div>';
				if ( isset( $wp_rem_cs_page_layout ) && $wp_rem_cs_sidebarLayout <> '' and $wp_rem_cs_sidebarLayout <> "none" and $wp_rem_cs_sidebarLayout == 'right' ) :
					if ( is_active_sidebar( wp_rem_cs_get_sidebar_id( $wp_rem_cs_page_sidebar_right ) ) ) {
						?>
						<aside class="page-sidebar col-lg-3 col-md-3 col-sm-12 col-xs-12">
							<?php if ( ! function_exists( 'dynamic_sidebar' ) || ! dynamic_sidebar( $wp_rem_cs_page_sidebar_right ) ) : endif; ?>
						</aside>
						<?php
					}
				endif;
                echo '</div>';
                echo '</div>';
            } 
			
			if ($pageSidebar === true) {
				echo '</div>';
			}
        } else {
            ?>
            <div class="container">        
                <!-- Row Start -->
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php get_template_part( 'woocommerce/products-loop', 'page' ); ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
get_footer();
