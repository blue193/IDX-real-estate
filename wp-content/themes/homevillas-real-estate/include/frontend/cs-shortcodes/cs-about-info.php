<?php
/*
 *
 * @Shortcode Name : Image Frame
 * @retrun
 *
 */
if (!function_exists('wp_rsm_cs_var_about_info')) {

    function wp_rsm_cs_var_about_info($atts, $content = "") {

        global $header_map, $post;
        $defaults = array(
            'wp_rsm_cs_var_column_size' => '',
            'wp_rsm_cs_var_image_section_title' => '',
            'wp_rsm_cs_var_image_section_subtitle' => '',
            'wp_rsm_var_about_info_align' => '',
            'wp_rsm_cs_var_frame_image_url_array' => '',
            'wp_rsm_cs_about_info_bg_color' => '',
            'wp_rsm_cs_var_about_info_title' => '',
            'wp_rsm_cs_about_info_title_color' => '',
            'wp_rsm_cs_var_about_info_sub_title' => '',
            'wp_rsm_cs_about_info_sub_title_color' => '',
            'wp_rsm_cs_var_frame_promo_image_url_array' => '',
            'wp_rsm_cs_var_app_store_image_url_array' => '',
            'wp_rsm_cs_about_info_button_bg_color' => '',
            'wp_rsm_cs_var_about_info_button_title' => '',
            'wp_rsm_cs_var_about_info_button_url' => '',
        );
        extract(shortcode_atts($defaults, $atts));
        if (isset($wp_rsm_cs_var_column_size) && $wp_rsm_cs_var_column_size != '') {
            if (function_exists('wp_rsm_cs_var_custom_column_class')) {
                $column_class = wp_rsm_cs_var_custom_column_class($wp_rsm_cs_var_column_size);
            }
        }

        $wp_rsm_cs_var_image_section_title = isset($wp_rsm_cs_var_image_section_title) ? $wp_rsm_cs_var_image_section_title : '';
        $wp_rsm_cs_var_image_section_subtitle = isset($wp_rsm_cs_var_image_section_subtitle) ? $wp_rsm_cs_var_image_section_subtitle : '';
        $wp_rsm_cs_var_frame_image_url = isset($wp_rsm_cs_var_frame_image_url_array) ? $wp_rsm_cs_var_frame_image_url_array : '';
        $wp_rsm_cs_about_info_bg_color = isset($wp_rsm_cs_about_info_bg_color) ? $wp_rsm_cs_about_info_bg_color : '';
        $wp_rsm_cs_var_frame_promo_image_url_array = isset($wp_rsm_cs_var_frame_promo_image_url_array) ? $wp_rsm_cs_var_frame_promo_image_url_array : '';
        $wp_rsm_cs_var_about_info_title = isset($wp_rsm_cs_var_about_info_title) ? $wp_rsm_cs_var_about_info_title : '';
        $wp_rsm_cs_about_info_title_color = isset($wp_rsm_cs_about_info_title_color) ? $wp_rsm_cs_about_info_title_color : '';
        $wp_rsm_cs_var_about_info_sub_title = isset($wp_rsm_cs_var_about_info_sub_title) ? $wp_rsm_cs_var_about_info_sub_title : '';
        $wp_rsm_cs_about_info_sub_title_color = isset($wp_rsm_cs_about_info_sub_title_color) ? $wp_rsm_cs_about_info_sub_title_color : '';
        $wp_rsm_cs_var_about_info_button_title = isset($wp_rsm_cs_var_about_info_button_title) ? $wp_rsm_cs_var_about_info_button_title : '';
        $wp_rsm_cs_var_about_info_button_url = isset($wp_rsm_cs_var_about_info_button_url) ? $wp_rsm_cs_var_about_info_button_url : '';
        $wp_rsm_cs_about_info_button_bg_color = isset($wp_rsm_cs_about_info_button_bg_color) ? $wp_rsm_cs_about_info_button_bg_color : '';
        $wp_rsm_cs_var_about_info = '';
        $page_element_size = isset($atts['about_info_element_size']) ? $atts['about_info_element_size'] : 100;
        if (function_exists('wp_rsm_cs_var_page_builder_element_sizes')) {
            $wp_rsm_cs_var_about_info .= '<div class="' . wp_rsm_cs_var_page_builder_element_sizes($page_element_size) . ' ">';
        }
        $wp_rsm_cs_var_about_info .= wp_rsm_title_sub_align($wp_rsm_cs_var_image_section_title, $wp_rsm_cs_var_image_section_subtitle, $wp_rsm_var_about_info_align);

        ob_start();
        ?>
        <div class="row about-info-holder">
            <?php if ($wp_rsm_cs_var_frame_promo_image_url_array != '') { ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="img-frame classic has-border has-shadow">
                        <figure>
                            <img src="<?php echo esc_url($wp_rsm_cs_var_frame_promo_image_url_array); ?>" alt="<?php echo wp_rsm_cs_var_theme_text_srt('wp_rsm_cs_about_info_image'); ?>">
                        </figure>
                    </div>
                </div>
            <?php } ?>
            <?php if ($wp_rsm_cs_var_about_info_sub_title || $wp_rsm_cs_var_about_info_title || $content || $wp_rsm_cs_var_about_info_button_title) { ?>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="column-text default about-info">
                        <?php if ($wp_rsm_cs_var_about_info_sub_title != '') { ?>
                            <?php
                            $content_sub_title_style = '';
                            if (isset($wp_rsm_cs_about_info_sub_title_color) && $wp_rsm_cs_about_info_sub_title_color <> '') {
                                $content_sub_title_style = 'style="color:' . esc_html($wp_rsm_cs_about_info_sub_title_color) . ' !important;"';
                            }
                            ?>
                            <span <?php echo wp_rsm_cs_allow_special_char($content_sub_title_style); ?>><?php echo esc_html($wp_rsm_cs_var_about_info_sub_title); ?></span>
                        <?php } ?>
                        <?php if ($wp_rsm_cs_var_about_info_title != '') { ?>
                            <?php
                            $content_title_style = '';
                            if (isset($wp_rsm_cs_about_info_title_color) && $wp_rsm_cs_about_info_title_color <> '') {
                                $content_title_style = 'style="color:' . esc_html($wp_rsm_cs_about_info_title_color) . ' !important;"';
                            }
                            ?>
                            <h1 <?php echo wp_rsm_cs_allow_special_char($content_title_style); ?>><?php echo esc_html($wp_rsm_cs_var_about_info_title); ?></h1>
                        <?php } ?>
                        <?php
                        if ($content != '') {
                            echo do_shortcode($content);
                        }
                        ?>
                        <?php if ($wp_rsm_cs_var_about_info_button_title != '') { ?>
                            <?php
                            $button_style = '';
                            if (isset($wp_rsm_cs_about_info_button_bg_color) && $wp_rsm_cs_about_info_button_bg_color <> '') {
                                $button_style = 'style="background-color:' . esc_html($wp_rsm_cs_about_info_button_bg_color) . ' !important;"';
                            }
                            ?>
                            <a class="promo-btn bgcolor" href="<?php echo esc_url($wp_rsm_cs_var_about_info_button_url); ?>" <?php echo wp_rsm_cs_allow_special_char($button_style); ?>><?php echo esc_html($wp_rsm_cs_var_about_info_button_title); ?></a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php
        $content = ob_get_clean();
        $wp_rsm_cs_var_about_info .= wp_rsm_cs_allow_special_char( $content );
        if (function_exists('wp_rsm_cs_var_page_builder_element_sizes')) {
            $wp_rsm_cs_var_about_info .= '</div>';
        }


        return $wp_rsm_cs_var_about_info;
    }

    if (function_exists('wp_rsm_cs_var_short_code'))
        wp_rsm_cs_var_short_code('wp_rsm_cs_about_info', 'wp_rsm_cs_var_about_info');
}