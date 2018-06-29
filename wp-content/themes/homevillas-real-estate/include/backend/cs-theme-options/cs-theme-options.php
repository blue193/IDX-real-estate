<?php
/**
 * Wp_rem_cs Theme Options
 *
 * @package WordPress
 * @subpackage wp_rem_cs
 * @since Auto Mobile 1.0
 */
if ( ! function_exists('wp_rem_settings_page') ) {

    /**
     * Wp_rem_cs setting page
     */
    function wp_rem_settings_page() {

        global $wp_rem_cs_var_options, $wp_rem_cs_var_settings, $wp_rem_cs_var_form_fields, $wp_rem_cs_var_html_fields, $wp_rem_cs_var_static_text;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_theme_option_strings();
        ?>
        <div class="theme-wrap fullwidth">
            <div class="inner">
                <div class="outerwrapp-layer">
                    <div class="loading_div"> 
                        <i class="icon-circle-o-notch icon-spin"></i> <br>
                        <?php
                        echo esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_save_msg'));
                        ?>
                    </div>
                    <div class="form-msg"> 
                        <i class="icon-check-circle-o"></i>
                        <div class="innermsg"></div>
                    </div>
                </div>
                <div class="row">
                    <form id="frm" method="post">
                        <?php
                        $wp_rem_cs_var_fields = new wp_rem_cs_var_fields();
                        $return = $wp_rem_cs_var_fields->wp_rem_cs_var_fields($wp_rem_cs_var_settings);
                        ?>
                        <div class="col1">
                            <nav class="admin-navigtion">
                                <div class="logo"> <a href="<?php echo esc_url(home_url('/')) ?>" class="logo1"><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/backend/images/logo-themeoption.png') ?>" /></a> <a href="#" class="nav-button"><i class="icon-align-justify"></i></a> </div>
                                <ul>
                                    <?php echo force_balance_tags($return[1], true); ?>
                                </ul>
                            </nav>
                        </div>

                        <div class="col2">
                            <?php echo force_balance_tags($return[0], true); ?>
                        </div>
                        <?php
                        $wp_rem_cs_inline_script = '
						jQuery(document).ready(function () {
							chosen_selectionbox();
						});';
                        wp_rem_cs_admin_inline_enqueue_script($wp_rem_cs_inline_script, 'wp_rem_cs-custom-functions');
                        ?>
                        <div class="clear"></div>
                        <div class="footer">
                            <?php
                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_save_msg'),
                                'cust_id' => 'submit_btn',
                                'cust_name' => 'submit_btn',
                                'cust_type' => 'button',
                                'extra_atr' => 'onclick="javascript:theme_option_save(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(get_template_directory_uri()) . '\');"',
                                'classes' => 'bottom_btn_save',
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => 'theme_option_save',
                                'cust_id' => 'action',
                                'cust_name' => 'action',
                                'classes' => '',
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_hidden_render($wp_rem_cs_opt_array);

                            $wp_rem_cs_opt_array = array(
                                'std' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_reset_msg'),
                                'cust_id' => 'reset',
                                'cust_name' => 'reset',
                                'cust_type' => 'button',
                                'extra_atr' => 'onclick="javascript:wp_rem_cs_var_rest_all_options(\'' . esc_js(admin_url('admin-ajax.php')) . '\', \'' . esc_js(get_template_directory_uri()) . '\');"',
                                'classes' => 'bottom_btn_reset',
                            );
                            $wp_rem_cs_var_form_fields->wp_rem_cs_var_form_text_render($wp_rem_cs_opt_array);
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <?php
    }

}
/**
 * @Background Count function
 * @return
 *
 */
if ( ! function_exists('wp_rem_cs_var_bgcount') ) {

    function wp_rem_cs_var_bgcount($name, $count) {

        $pattern = array();
        for ( $i = 0; $i <= $count; $i ++ ) {
            $pattern['option' . $i] = $name . $i;
        }
        return $pattern;
    }

}
/**
 * @Theme Options array
 * @return
 *
 */
if ( ! function_exists('wp_rem_cs_var_options_array') ) {

    add_action('init', 'wp_rem_cs_var_options_array');

    function wp_rem_cs_var_options_array() {

        global $wp_rem_cs_var_settings, $wp_rem_cs_var_options, $wp_rem_cs_var_static_text;
        $banner_fields = array( 'banner_field_title' => array( 'Banner 1' ), 'banner_field_style' => array( 'top_banner' ), 'banner_field_type' => array( 'code' ), 'banner_field_image' => array( '' ), 'banner_field_url' => array( '#' ), 'banner_field_url_target' => array( '_self' ), 'banner_adsense_code' => array( '' ), 'banner_field_code_no' => array( '0' ) );
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_theme_strings();
        $strings->wp_rem_cs_theme_option_strings();
        $strings->wp_rem_cs_short_code_strings();
        $on_off_option = array(
            "show" => "on",
            "hide" => "off",
        );
        $navigation_style = array(
            "left" => "left",
            "center" => "center",
            "right" => "right"
        );

        $social_network = array(
            'wp_rem_cs_var_social_net_icon_path' => array( '', '', '', '', '' ),
            'wp_rem_cs_var_social_net_awesome' => array( 'icon-facebook9', 'icon-dribbble7', 'icon-twitter2', 'icon-behance2' ),
            'wp_rem_cs_var_social_net_url' => array( 'https://www.facebook.com/', 'https://dribbble.com/', 'https://www.twitter.com/', 'https://www.behance.net/' ),
            'wp_rem_cs_var_social_net_tooltip' => array( 'Facebook', 'Dribbble', 'Twitter', 'Behance' ),
            'wp_rem_cs_var_social_icon_color' => array( '#cccccc', '#cccccc', '#cccccc', '#cccccc' )
        );

        $clients = array(
            'wp_rem_clients_title' => array( '', '', '', '', '' ),
            'wp_rem_clients_url' => array( '', '', '', '', '' ),
            'wp_rem_clients_image' => array( '', '', '', '', '' ),
        );

        $wp_rem_cs_var_sidebar = array(
            'sidebar' => array(
            )
        );

        $wp_rem_cs_var_footer_sidebar = array(
            'wp_rem_cs_var_footer_sidebar' => array(
                '' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_please_select'),
            )
        );

        $deafult_sub_header = array(
            'breadcrumbs_sub_header' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_breadcrumbs_sub_header'),
            'slider' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_revolution_slider'),
            'no_header' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_no_sub_header'),
        );

        if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) && sizeof($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) > 0 ) {
            $wp_rem_cs_var_sidebar = array( 'sidebar' => $wp_rem_cs_var_options['wp_rem_cs_var_sidebar'] );
        }

        // google fonts array
		$wp_rem_cs_var_fonts = '';
		$wp_rem_cs_var_fonts_atts = '';
		if (class_exists('wp_rem_google_fonts_admin_frontend')) {
			$fonts_admin_frontend = new wp_rem_google_fonts_admin_frontend();
			$wp_rem_cs_var_fonts = $fonts_admin_frontend->wp_rem_added_google_fonts();
			$wp_rem_cs_var_fonts_atts = $fonts_admin_frontend->wp_rem_selected_google_fonts_attributes();
		}

        if ( isset($wp_rem_cs_var_options) and isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar']) ) {
            if ( is_array($wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar']) and count($wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar']) > 0 ) {
                $wp_rem_cs_footer_sidebar = array( 'wp_rem_cs_var_footer_sidebar' => $wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar'] );
            } else {
                $wp_rem_cs_footer_sidebar = array( 'wp_rem_cs_var_footer_sidebar' => array() );
            }
        } else {
            $wp_rem_cs_footer_sidebar = $wp_rem_cs_var_footer_sidebar;
        }

        $footer_sidebar_list[''] = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_please_select');
        if ( isset($wp_rem_cs_footer_sidebar['wp_rem_cs_var_footer_sidebar']) && is_array($wp_rem_cs_footer_sidebar['wp_rem_cs_var_footer_sidebar']) ) {
            foreach ( $wp_rem_cs_footer_sidebar['wp_rem_cs_var_footer_sidebar'] as $footer_sidebar_var => $footer_sidebar_val ) {
                $footer_sidebar_list[$footer_sidebar_var] = $footer_sidebar_val;
            }
        }
        $wp_rem_cs_footer_sidebar['wp_rem_cs_var_footer_sidebar'] = $footer_sidebar_list;
        //Set the Options Array
        $wp_rem_cs_var_settings = array();
        //general setting options
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_global'),
            "fontawesome" => 'icon-global',
            "id" => "tab-global-setting",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_header'),
            "fontawesome" => 'icon-header',
            "id" => "tab-header-options",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header'),
            "fontawesome" => 'icon-document-landscape',
            "id" => "tab-sub-header-options",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer'),
            "fontawesome" => 'icon-straighten',
            "id" => "tab-footer-options",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icons'),
            "fontawesome" => 'icon-share3',
            "id" => "tab-social-setting",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_sharing'),
            "fontawesome" => 'icon-share',
            "id" => "tab-social-network",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );



        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_color'),
            "fontawesome" => 'icon-magic',
            "label_desc" => "",
            "type" => "heading",
            "options" => array(
                'tab-general-color' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_general'),
                'tab-header-color' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_header'),
                'tab-footer-color' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer'),
                'tab-heading-color' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_heading'),
            )
        );



        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_typo_font'),
            "fontawesome" => 'icon-font',
            "desc" => "",
            "label_desc" => "",
			"id" => "tab-font-family",
            "type" => "main-heading",
            "options" => ''
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar'),
            "fontawesome" => 'icon-columns',
            "id" => "tab-sidebar",
            "std" => "",
            "type" => "main-heading",
            "options" => ''
        );

        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_global'),
            "id" => "tab-global-setting",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_global'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_global'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_layout'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_layout_type'),
            "id" => "layout",
            "std" => "full_width",
            "options" => array(
                "boxed" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_box'),
                "full_width" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_full_width'),
            ),
            "type" => "layout",
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => "",
            "id" => "horizontal_tab",
            "class" => "horizontal_tab",
            "type" => "horizontal_tab",
            "std" => "",
            "options" => array(
                wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_background') => 'background_tab',
                wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bgcolor') => 'background_tab_color',
                wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_pattern') => 'pattern_tab',
                wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_custom_image') => 'custom_image_tab'
            )
        );
        $wp_rem_cs_var_layout = isset($wp_rem_cs_var_options['wp_rem_cs_var_layout']) ? $wp_rem_cs_var_options['wp_rem_cs_var_layout'] : '';
        $wp_rem_cs_var_bg_image = isset($wp_rem_cs_var_options['wp_rem_cs_var_bg_image']) ? $wp_rem_cs_var_options['wp_rem_cs_var_bg_image'] : '';
        $wp_rem_cs_var_bg_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_bg_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_bg_color'] : '';
        $wp_rem_cs_var_pattern_image = isset($wp_rem_cs_var_options['wp_rem_cs_var_pattern_image']) ? $wp_rem_cs_var_options['wp_rem_cs_var_pattern_image'] : '';
        $wp_rem_cs_var_custom_bgimage = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_bgimage']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_bgimage'] : '';
        if ( $wp_rem_cs_var_layout == 'full_width' ) {
            $bg_image_display = "none";
        } else {
            $bg_image_display = "block";
        }
        $bg_color_display = $pattern_image_display = $custom_bgimage_display = $custom_bgimage_position_display = "none";
        if ( $wp_rem_cs_var_custom_bgimage <> '' ) {
            $custom_bgimage_display = "block";
            $custom_bgimage_position_display = "block";
            $bg_image_display = "none";
        } elseif ( $wp_rem_cs_var_pattern_image <> '' && $wp_rem_cs_var_pattern_image <> 0 ) {
            $pattern_image_display = "block";
            $bg_image_display = "none";
        } elseif ( $wp_rem_cs_var_bg_color <> '' ) {
            $bg_color_display = "block";
            $bg_image_display = "none";
        }
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_background_image'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_bg_image_hint'),
            "id" => "bg_image",
            "class" => "wp_rem_cs_var_background_",
            "path" => "background",
            "tab" => "background_tab",
            "std" => "bg1",
            "type" => "layout_body",
            "display" => $bg_image_display,
            "options" => wp_rem_cs_var_bgcount('bg', '10')
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_bg_pattern'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_bg_pattern_hint'),
            "id" => "pattern_image",
            "class" => "wp_rem_cs_var_background_",
            "path" => "patterns",
            "tab" => "pattern_tab",
            "std" => "bg7",
            "type" => "layout_body",
            "display" => $pattern_image_display,
            "options" => wp_rem_cs_var_bgcount('pattern', '27')
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bgcolor'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_bgcolor_hint'),
            "id" => "bg_color",
            "std" => "#f3f3f3",
            "tab" => "background_tab_color",
            "display" => $bg_color_display,
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_custom_image'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_layout_hint'),
            "id" => "custom_bgimage",
            "std" => "",
            "tab" => "custom_image_tab",
            "display" => $custom_bgimage_display,
            "type" => "upload logo"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bg_image_position'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_bg_image_position_hint'),
            "id" => "bgimage_position",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_repeat_center'),
            "type" => "select",
            "tab" => "custom_image_position",
            "display" => $custom_bgimage_position_display,
            'classes' => 'chosen-select',
            "options" => array(
                "no-repeat center top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_center_top'),
                "repeat center top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_repeat_center_top'),
                "no-repeat center" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_center'),
                "Repeat Center" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_repeat_center'),
                "no-repeat left top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_left_top'),
                "repeat left top" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_repeat_left_top'),
                "no-repeat fixed center" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_fixed_center'),
                "no-repeat fixed center / cover" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_no_repeat_fixed_center_cover'),
            )
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_responsive'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_responsive_hint'),
            "id" => "responsive",
            "std" => "on",
            "type" => "checkbox",
            "options" => $on_off_option
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_excerpt'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_excerpt_hint'),
            "id" => "excerpt_length",
            "std" => "120",
            "type" => "text"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_bottom_spacing'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_element_title_bottom_spacing_hint'),
            "id" => "title_bottom_spacing",
            "std" => "",
            "type" => "text"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_page_margin'),
            "desc" => "",
            "label_desc" => "",
            "id" => "page_margin",
            "std" => "on",
            "type" => "checkbox"
        );
        if ( function_exists('icl_object_id') ) {
            $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_lang'),
                "desc" => "",
                "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_lang_hint'),
                "id" => "footer_lang_switch",
                "std" => "",
                "type" => "checkbox",
            );
        }

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_custom_css'),
            "id" => "header_top_strip",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_custom_css'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_custom_css'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_custom_css_hint'),
            "id" => "custom_css",
            "std" => '',
            "type" => "textarea"
        );

        // filter to add custom fields in themes options using addons
        $all_pages = get_pages();
        $pages_array = array();
        foreach ( $all_pages as $page ) {
            if ( $page->post_type == 'page' ) {
                $pages_array[$page->ID] = $page->post_name;
            }
        }
        $wp_rem_cs_var_settings = apply_filters('wp_rem_cs_theme_options_general', $wp_rem_cs_var_settings);
        $currPage = '';

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_logo_width'),
            "type" => "division_close"
        );
        $wp_rem_cs_var_settings[] = array( "col_heading" => '',
            "type" => "col-right-text",
            "help_text" => '',
        );
        // Header options start
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_header'),
            "id" => "tab-header-options",
            "type" => "sub-heading"
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_header'),
            "id" => "header_top_strip",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_header'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('header_style_real_estate'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('header_style_real_estate_hint'),
            "id" => "header_style",
            "std" => "",
            "type" => "select",
            'classes' => 'chosen-select-no-single',
            "options" => array(
                '' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_default'),
                'modern' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_modern'),
                'classic' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_classic'),
                'fancy' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_fancy'),
                'default' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_default_v2'),
                'advance' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_advance'),
                'advance_v2' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_advance_v2'),
                'modern_v2' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_modern_v2'),
            )
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_logo'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_logo_hint'),
            "id" => "custom_logo",
            "std" => "",
            "type" => "upload logo"
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_header_full_width'),
            "desc" => "",
            "id" => 'header_full_width',
            "label_desc" => '',
            "id" => "header_full_width",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('header_sticky_switch'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('header_sticky_switch_hint'),
            "id" => "sticky_header",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sticky_logo'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sticky_logo_hint'),
            "id" => "sticky_logo",
            "std" => "",
            "type" => "upload logo"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_logo_height'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_logo_height_hint'),
            "id" => "logo_height",
            "min" => '0',
            "max" => '100',
            "std" => "67",
            "type" => "range"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_logo_width'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_logo_width_hint'),
            "id" => "logo_width",
            "min" => '0',
            "max" => '210',
            "std" => "142",
            "type" => "range"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_contact_us_btn'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_contact_us_btn_hint'),
            "id" => "contact_us_text",
            "std" => "",
            "type" => "textarea"
        );
        // sub header element settings 
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header'),
            "id" => "tab-sub-header-options",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header'),
            "id" => "header_top_strip",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_sub_header'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_sub_header_hint'),
            "id" => "default_header",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_breadcrumbs_sub_header'),
            'classes' => 'chosen-select',
            "type" => "default_header",
            "options" => $deafult_sub_header
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_default_header",
            "enable_val" => "no_header",
            "extra_atts" => 'id="cs-no-headerfields"',
        );

        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_default_header",
            "enable_val" => "slider",
            "extra_atts" => 'id="cs-rev-slider-fields"',
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_revolution_slider'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_revolution_slider_hint'),
            "id" => "custom_slider",
            "std" => "",
            "type" => "slider_code",
            "options" => ''
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );

        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_default_header",
            "enable_val" => "breadcrumbs_sub_header",
            "extra_atts" => 'id="cs-breadcrumbs-fields"',
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_padding_top'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header_padding_top_hint'),
            "id" => "sh_paddingtop",
            "min" => '0',
            "max" => '200',
            "std" => "0",
            "type" => "range"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_padding_bottom'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header_padding_bottom_hint'),
            "id" => "sh_paddingbottom",
            "min" => '0',
            "max" => '200',
            "std" => "0",
            "type" => "range"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_margin_top'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header_margin_top_hint'),
            "id" => "sh_margintop",
            "min" => '0',
            "max" => '200',
            "std" => "0",
            "type" => "range"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_margin_bottom'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_margin_bottom_hint'),
            "id" => "sh_marginbottom",
            "min" => '0',
            "max" => '200',
            "std" => "0",
            "type" => "range"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_page_title'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_page_title_hint'),
            "id" => "page_title_switch",
            "std" => "on",
            "type" => "checkbox"
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_align'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_header_text_align_hint'),
            "id" => "default_sub_header_align",
            "std" => "",
            "type" => "select",
            'classes' => 'chosen-select-no-single',
            "options" => array(
                'left' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_left'),
                'center' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_center'),
                'right' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_right'),
                'bottom' => wp_rem_cs_var_theme_text_srt('wp_rem_var_align_bottom'),
            )
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_subheader_text_color_hint'),
            "id" => "sub_header_text_color",
            "std" => "#ffffff",
            "type" => "color"
        );

        $wp_rem_cs_var_settings[] = array(
            "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_breadcrumbs'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_breadcrumbs_hint'),
            "id" => "breadcrumbs_switch",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_default_header",
            "enable_val" => "breadcrumbs_sub_header",
            "extra_atts" => 'id="cs-breadcrumbs_sub_header_fields"',
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sub_heading'),
            "desc" => "",
            "label_desc" => "",
            "id" => "sub_header_sub_hdng",
            "std" => "",
            "type" => "textarea"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_background_image'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bg_image_hint'),
            "id" => "sub_header_bg_img",
            "std" => "",
            "type" => "upload logo"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_parallax'),
            "desc" => "",
            "label_desc" => '',
            "id" => "sub_header_parallax",
            "std" => "",
            "type" => "checkbox",
            "options" => $on_off_option
        );

        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_default_header",
            "enable_val" => "breadcrumbs_sub_header",
            "extra_atts" => 'id="sub_header_bg_clr"',
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bgcolor'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bgcolor_hint'),
            "id" => "sub_header_bg_clr",
            "std" => "",
            "type" => "color"
        );

        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_sub_header_align",
            "enable_val" => "bottom",
            "extra_atts" => 'id="breacrumb-bg-color"',
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_breadcrumb_bgcolor'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_breadcrumb_bgcolor_hint'),
            "id" => "breadcrumb_bg_clr",
            "std" => "",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );

        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );
        // start footer options    
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_options'),
            "id" => "tab-footer-options",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_options'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_options'),
            "type" => "section",
            "options" => ""
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('footer_style_real_estate'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('footer_style_real_estate_hint'),
            "id" => "footer_style",
            "std" => "",
            "type" => "select",
            "extra_att" => " onchange=wp_rem_footer_views(this.value)",
            'classes' => 'chosen-select-no-single',
            "options" => array(
                '' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_default'),
                'modern' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_modern'),
                'classic' => wp_rem_cs_var_theme_text_srt('header_style_real_estate_classic'),
                'advance' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_style_advance'),
            )
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_footer_style",
            "enable_val" => "classic,advance",
            "extra_atts" => ' id="wp_rem_footer_style_dynamic"',
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_logo'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_logo_hint'),
            "id" => "footer_logo",
            "std" => "",
            "type" => "upload logo"
        );
        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );
        
        $wp_rem_cs_var_settings[] = array(
            "type" => "division",
            "enable_id" => "wp_rem_cs_var_footer_style",
            "enable_val" => "advance",
            "extra_atts" => ' id="wp_rem_footer_menu_dynamic"',
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_menu_switch'),
            "desc" => "",
            "label_desc" =>'',
            "id" => "footer_menu",
            "std" => "on",
            "type" => "checkbox"
        );
        
        $wp_rem_cs_var_settings[] = array(
            "type" => "division_close",
        );
        
        
        
        

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_widgets'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_widgets_hint'),
            "id" => "footer_widget",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_copy_write_section'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_copy_write_section_hint'),
            "id" => "copy_write_section",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_copy_write_text_switch'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_copy_write_text_switch_hint'),
            "id" => "copy_write_text_switch",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_copyright_text'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_copyright_text_hint'),
            "id" => "copy_right",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_copyright_text_value'),
            "type" => "textarea"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_back_to_top'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_back_to_top_hint'),
            "id" => "back_to_top",
            "std" => "on",
            "type" => "checkbox",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_google_play_img'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_google_play_img_hint'),
            "id" => "google_store",
            "std" => "",
            "type" => "upload logo"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_google_play_img_url'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_google_play_img_url_hint'),
            "id" => "google_store_url",
            "std" => "",
            "type" => "text" );



        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_app_store_img'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_app_store_img_hint'),
            "id" => "footer_app_store",
            "std" => "",
            "type" => "upload logo"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_app_store_img_url'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_app_store_img_url_hint'),
            "id" => "footer_app_store_url",
            "std" => "",
            "type" => "text" );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_background'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_background_hint'),
            "id" => "custom_footer_background",
            "std" => "",
            "type" => "upload logo"
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_social_network'),
            "desc" => "",
            "label_desc" => "",
            "id" => "social_network",
            "std" => "",
            "type" => "clients",
            "options" => $clients,
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_sidebar'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_sidebar'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_sidebar'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar_hint'),
            "id" => "wp_rem_cs_footer_sidebar",
            "std" => $wp_rem_cs_var_footer_sidebar,
            "type" => "wp_rem_cs_var_footer_sidebar",
            "options" => $wp_rem_cs_var_footer_sidebar
        );


        // End footer tab setting
        // general colors 
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_general_color'),
            "id" => "tab-general-color",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_general_color'),
            "id" => "header_top_strip",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_general_color'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_color_hint'),
            "id" => "theme_color",
            "std" => "#ed413f",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_second_theme_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_second_theme_color_hint'),
            "id" => "second_theme_color",
            "std" => "#ed413f",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_text_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_text_color_hint'),
            "id" => "text_color",
            "std" => "#555555",
            "type" => "color"
        );
        // start top strip tab options
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_header_color'),
            "id" => "tab-header-color",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_header_color'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_header_color'),
            "type" => "section",
            "options" => ""
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_bgcolor'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_default_header_colors_hint'),
            "id" => "header_bgcolor",
            "std" => "#ffffff",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sticky_header_colors'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sticky_header_colors_hint'),
            "id" => "sticky_header_bgcolor",
            "std" => "#ffffff",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sticky_header_text_colors'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sticky_header_text_colors_hint'),
            "id" => "sticky_menu_text_color",
            "std" => "#ffffff",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_menu_link_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_menu_link_color_hint'),
            "id" => "menu_color",
            "std" => "#282828",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_menu_hover_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_menu_hover_color_hint'),
            "id" => "menu_active_color",
            "std" => "#ed413f ",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_menu_hover_bg_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_menu_hover_bg_color_hint'),
            "id" => "menu_hover_bg_color",
            "std" => "#ed413f ",
            "type" => "color"
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_submenu_2nd_level_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_submenu_2nd_level_color_hint'),
            "id" => "submenu_2nd_level_color",
            "std" => "#282828",
            "type" => "color"
        );
        //DropDown 2nd Level Background-Color
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_submenu_2nd_level_bgcolor'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_submenu_2nd_level_bgcolor_hint'),
            "id" => "submenu_2nd_level_bgcolor",
            "std" => "#ed413f",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_submenu_hover_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_submenu_hover_color_hint'),
            "id" => "submenu_hover_color",
            "std" => "#ed413f",
            "type" => "color"
        );

        // footer colors 
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_color'),
            "id" => "tab-footer-color",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_color'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_color'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_bg_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_bg_color_hint'),
            "id" => "footerbg_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_text_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_text_color_hint'),
            "id" => "footer_text_color",
            "std" => "#999999",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_link_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_link_color_hint'),
            "id" => "link_color",
            "std" => "#999999",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_copyright_bg_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_copyright_bg_color_hint'),
            "id" => "copyright_bg_color",
            "std" => "#999999",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_copyright_text_color'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_copyright_text_color_hint'),
            "id" => "copyright_text_color",
            "std" => "#999999",
            "type" => "color"
        );
        // heading colors 
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_color'),
            "id" => "tab-heading-color",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_color'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_color'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_h1'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_h1_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_h2'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_h2_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_h3'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_h3_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_h4'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_h4_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_h5'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_h5_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_heading_h6'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_h6_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_section_title'),
            "desc" => "",
            "label_desc" => "",
            "id" => "section_title_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_post_title'),
            "desc" => "",
            "label_desc" => "",
            "id" => "post_title_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_page_title'),
            "desc" => "",
            "label_desc" => "",
            "id" => "page_title_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widget_title'),
            "desc" => "",
            "label_desc" => "",
            "id" => "widget_title_color",
            "std" => "#333333",
            "type" => "color"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer_widget_title'),
            "desc" => "",
            "label_desc" => "",
            "id" => "footer_widget_title_color",
            "std" => "#333333",
            "type" => "color"
        );
        // start font family 
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_typo_font'),
            "id" => "tab-font-family",
            "type" => "sub-heading"
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_content_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_content_google_font_discription'),
            "id" => "content_font",
            "std" => "Raleway",
            "type" => "gfont_select",
            'classes' => 'chosen-select',
            "options" => $wp_rem_cs_var_fonts
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "content_font_att",
            "std" => "500",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "content_size",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "content_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "content_textr",
            "std" => "none",
            "type" => "select_ftext",
            'classes' => 'chosen-select',
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "content_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_main_menu_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_main_menu_font_hint'),
            "id" => "mainmenu_font",
            "std" => "Raleway",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "mainmenu_font_att",
            "std" => "700",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "mainmenu_size",
            "min" => '6',
            "max" => '50',
            "std" => "14",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "mainmenu_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "mainmenu_textr",
            "std" => "none",
            "type" => "select_ftext",
            'classes' => 'chosen-select',
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "mainmenu_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading1_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading_font_hint'),
            "id" => "heading1_font",
            "std" => "Montserrat",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "heading1_font_att",
            "std" => "700",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_1_size",
            "min" => '6',
            "max" => '50',
            "std" => "36",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_1_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_1_textr",
            "std" => "none",
            "type" => "select_ftext",
            'classes' => 'chosen-select',
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_1_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading2_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading_font_hint'),
            "id" => "heading2_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "heading2_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_2_size",
            "min" => '6',
            "max" => '50',
            "std" => "30",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_2_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_2_textr",
            "std" => "none",
            "type" => "select_ftext",
            'classes' => 'chosen-select',
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_2_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading3_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading_font_hint'),
            "id" => "heading3_font",
            'classes' => 'chosen-select',
            "std" => "",
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "heading3_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_3_size",
            "min" => '6',
            "max" => '50',
            "std" => "26",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_3_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_3_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_3_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading4_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading_font_hint'),
            "id" => "heading4_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "heading4_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_4_size",
            "min" => '6',
            "max" => '50',
            "std" => "20",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_4_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_4_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_4_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading5_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading_font_hint'),
            "id" => "heading5_font",
            'classes' => 'chosen-select',
            "std" => "",
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "heading5_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_5_size",
            "min" => '6',
            "max" => '50',
            "std" => "18",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_5_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_5_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_5_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading6_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_Heading_font_hint'),
            "id" => "heading6_font",
            'classes' => 'chosen-select',
            "std" => "",
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "heading6_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_6_size",
            "min" => '6',
            "max" => '50',
            "std" => "16",
            "type" => "range_font",
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_6_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_6_textr",
            'classes' => 'chosen-select',
            "std" => "none",
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "heading_6_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_section_title_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_section_title_font_hint'),
            "id" => "section_title_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "section_title_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "section_title_size",
            "min" => '6',
            "max" => '50',
            "std" => "20",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "section_title_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "section_title_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "section_title_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        
        
        /*
         * Element Title fonts
         */
        
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_options_element_title_fonts'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_section_title_font_hint'),
            "id" => "element_title_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "element_title_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "element_title_size",
            "min" => '6',
            "max" => '50',
            "std" => "20",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "element_title_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "element_title_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "element_title_spc",
            "min" => '6',
            "max" => '50',
            "std" => "0",
            "type" => "range_font",
        );
        
        
        
        /*
         * Element title fonts End
         */
        
        
        
        
        
        
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_page_title_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_page_title_hint'),
            "id" => "page_title_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "page_title_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "page_title_size",
            "min" => '6',
            "max" => '50',
            "std" => "20",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "page_title_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "page_title_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "page_title_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_post_title_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_post_title_hint'),
            "id" => "post_title_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "post_title_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "post_title_size",
            "min" => '6',
            "max" => '50',
            "std" => "20",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "post_title_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "post_title_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "post_title_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar_widget_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar_widget_font_hint'),
            "id" => "widget_heading_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "widget_heading_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "widget_heading_size",
            "min" => '6',
            "max" => '50',
            "std" => "18",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "widget_heading_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "widget_heading_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "widget_heading_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_widget_font'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_widget_font_hint'),
            "id" => "ft_widget_heading_font",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_select",
            "options" => $wp_rem_cs_var_fonts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_font_attribute_hint'),
            "id" => "ft_widget_heading_font_att",
            "std" => "",
            'classes' => 'chosen-select',
            "type" => "gfont_att_select",
            "options" => $wp_rem_cs_var_fonts_atts
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_size'),
            "desc" => "",
            "label_desc" => "",
            "id" => "ft_widget_heading_size",
            "min" => '6',
            "max" => '50',
            "std" => "18",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_line_height'),
            "desc" => "",
            "label_desc" => "",
            "id" => "ft_widget_heading_lh",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_text_transform'),
            "desc" => "",
            "label_desc" => "",
            "id" => "ft_widget_heading_textr",
            "std" => "none",
            'classes' => 'chosen-select',
            "type" => "select_ftext",
            "options" => array(
                'none' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_none'),
                'capitalize' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_capitalize'),
                'uppercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_uppercase'),
                'lowercase' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_lowercase'),
                'initial' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_initial'),
                'inherit' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_inherit')
            ),
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_letter_spacing'),
            "desc" => "",
            "label_desc" => "",
            "id" => "ft_widget_heading_spc",
            "min" => '6',
            "max" => '50',
            "std" => "13",
            "type" => "range_font",
        );
        /* social icons setting */
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icons'),
            "id" => "tab-social-setting",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icons'),
            "id" => "header_top_strip",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_icons'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_social_network'),
            "desc" => "",
            "label_desc" => "",
            "id" => "social_network",
            "std" => "",
            "type" => "networks",
            "options" => $social_network
        );
        // social Network setting 
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_sharing'),
            "id" => "tab-social-network",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_sharing'),
            "id" => "header_top_strip",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_social_sharing'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_fb'),
            "desc" => "",
            "label_desc" => "",
            "id" => "facebook_share",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_twitter'),
            "desc" => "",
            "label_desc" => "",
            "id" => "twitter_share",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_g_plus'),
            "desc" => "",
            "label_desc" => "",
            "id" => "google_plus_share",
            "std" => "off",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tumblr'),
            "desc" => "",
            "label_desc" => "",
            "id" => "tumblr_share",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_dribbble'),
            "desc" => "",
            "label_desc" => "",
            "id" => "dribbble_share",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_stumbleupon'),
            "desc" => "",
            "label_desc" => "",
            "id" => "stumbleupon_share",
            "std" => "on",
            "type" => "checkbox"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_share_more'),
            "desc" => "",
            "label_desc" => "",
            "id" => "share_share",
            "std" => "on",
            "type" => "checkbox"
        );
        // social Network setting 
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar'),
            "id" => "tab-sidebar",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar_hint'),
            "id" => "sidebar",
            "std" => $wp_rem_cs_var_sidebar,
            "type" => "sidebar",
            "options" => $wp_rem_cs_var_sidebar
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_pages'),
            "id" => "default_pages",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_pages_sidebar'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_pages_layout'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_default_pages_layout_hint'),
            "id" => "default_page_layout",
            "std" => "sidebar_right",
            "type" => "layout",
            "options" => array(
                "sidebar_left" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sidebar_left'),
                "sidebar_right" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sidebar_right'),
                "no_sidebar" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_full_width'),
            )
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_default_pages_sidebar_hint'),
            "id" => "default_layout_sidebar",
            "std" => "",
            "classes" => 'chosen-select',
            "type" => "select_sidebar",
            "options" => $wp_rem_cs_var_sidebar
        );
        if ( class_exists('WooCommerce') ) {

            $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_wc_archive_sidebar'),
                "id" => "woo_archive_pages",
                "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_wc_archive_sidebar'),
                "type" => "section",
                "options" => ""
            );
            $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_layout'),
                "desc" => "",
                "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_wc_archive_sidebar_discription'),
                "id" => "woo_archive_layout",
                "std" => "sidebar_right",
                "type" => "layout",
                "options" => array(
                    "sidebar_left" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sidebar_left'),
                    "sidebar_right" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_sidebar_right'),
                    "no_sidebar" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_full_width'),
                )
            );
            $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar'),
                "desc" => "",
                "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_wc_archive_sidebar_hint'),
                "id" => "woo_archive_sidebar",
                "std" => "",
                "classes" => 'chosen-select',
                "type" => "select_sidebar",
                "options" => $wp_rem_cs_var_sidebar
            );
        }
        // Footer sidebar tab 
//        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_sidebar'),
//            "id" => "tab-footer-sidebar",
//            "type" => "sub-heading"
//        );
//        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_footer_sidebar'),
//            "desc" => "",
//            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_sidebar_hint'),
//            "id" => "wp_rem_cs_footer_sidebar",
//            "std" => $wp_rem_cs_var_footer_sidebar,
//            "type" => "wp_rem_cs_var_footer_sidebar",
//            "options" => $wp_rem_cs_var_footer_sidebar
//        );


        /*  Automatic Updater */
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_auto_update'),
            "fontawesome" => 'icon-tasks',
            "id" => "tab-auto-updater",
            "std" => "",
            "type" => "main-heading",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_auto_update_theme'),
            "id" => "tab-auto-updater",
            "type" => "sub-heading"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_auto_update_theme'),
            "id" => "",
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_auto_update_theme'),
            "type" => "section",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_automatic_upgrade'),
            "desc" => "",
            "label_desc" => '',
            "id" => "cs_backup_options",
            "std" => "",
            "type" => "automatic_upgrade"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_marketplace_username'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_marketplace_username_hint'),
            "id" => "cs_marketplace_username",
            "std" => "",
            "type" => "text" );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_secret_api_key'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_secret_api_key_hint'),
            "id" => "cs_secret_api_key",
            "std" => "",
            "type" => "text" );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_skip_theme_backup'),
            "desc" => "",
            "label_desc" => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_skip_theme_backup_hint'),
            "id" => "cs_skip_theme_backup",
            "std" => "on",
            "type" => "checkbox",
        );
        $wp_rem_cs_var_settings[] = array( "col_heading" => '',
            "type" => "col-right-text",
            "help_text" => ''
        );

        /* Import & Export */
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_import_export'),
            "fontawesome" => 'icon-database',
            "id" => "tab-import-export-options",
            "std" => "",
            "type" => "main-heading",
            "options" => ""
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_import_export'),
            "id" => "tab-import-export-options",
            "type" => "sub-heading"
        );

        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_backup_option'),
            "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_backup_option'),
            "id" => "theme-bakups-options",
            "type" => "section"
        );
        $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_option_backup'),
            "desc" => "",
            "label_desc" => '',
            "id" => "wp_rem_cs_backup_options",
            "std" => "",
            "type" => "generate_backup"
        );

        if ( class_exists('wp_rem_cs_var_widget_data') ) {

            $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widgets_backup_options'),
                "std" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widgets_backup_options'),
                "id" => "widgets-bakups-options",
                "type" => "section"
            );

            $wp_rem_cs_var_settings[] = array( "name" => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widgets_backup'),
                "desc" => "",
                "label_desc" => '',
                "id" => "wp_rem_cs_widgets_backup",
                "std" => "",
                "type" => "widgets_backup"
            );
        }
        $wp_rem_cs_var_settings = apply_filters('wp_rem_cs_maintenance_options', $wp_rem_cs_var_settings);
        $wp_rem_cs_var_settings[] = array(
            "id" => "theme_option_save_flag",
            "std" => md5(uniqid(rand(), true)),
            "type" => "hidden_field"
        );
    }

}