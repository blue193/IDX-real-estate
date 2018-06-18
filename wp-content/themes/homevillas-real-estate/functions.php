<?php
/**
 * Wp_rem_cs functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package rem
 */
require_once trailingslashit(get_template_directory()) . 'assets/frontend/translate/cs-strings.php';
require_once trailingslashit(get_template_directory()) . 'assets/frontend/translate/cs-strings-2.php';
require_once trailingslashit(get_template_directory()) . 'assets/frontend/translate/cs-strings-3.php';
require_once trailingslashit(get_template_directory()) . 'include/cs-global-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-global-variables.php';
require_once trailingslashit(get_template_directory()) . 'include/cs-theme-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/cs-helpers.php';

define('SCRIPTS_VER', '4.7.4');

define('RECEIVED_ENQUIRY_EMAIL', 'admin@1on1realtors.com');
define('SEND_ARRANGE_SUBMIT', 'admin@1on1realtors.com');
/**
 * Sets up theme defaults and registers support for various WordPress features.     *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
if ( ! function_exists('wp_rem_cs_setup') ) {

    function wp_rem_cs_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ wp_rem_cs.
         * If you're building a theme based on wp_rem_cs, use a find and replace
         * to change 'wp-rem' to the name of your theme in all the template files.
         */
        load_theme_textdomain('homevillas-real-estate', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.

        register_nav_menus(array(
            'primary' => esc_html__('Primary', 'homevillas-real-estate'),
            'footer_menu' => esc_html__('Footer Menu', 'homevillas-real-estate'),
        ));



        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('wp_rem_cs_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        /*
         * This theme styles the visual editor to resemble the theme style,
         * specifically font, colors, icons, and column width.
         */
        add_editor_style('assets/backend/css/editor-style.css');
        add_filter('the_password_form', 'wp_rem_cs_password_form');

        define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
    }

    add_action('after_setup_theme', 'wp_rem_cs_setup');
}
/*
 * Include file function
 */
if ( ! function_exists('wp_rem_cs_include_file') ) {

    function wp_rem_cs_include_file($file_path = '', $inc = false) {
        if ( $file_path != '' ) {
            if ( $inc == true ) {
                include $file_path;
            } else {
                require_once $file_path;
            }
        }
    }

}

/*
 * Add images sizes for 
 * complete site
 */
add_image_size('wp_rem_cs_media_1', 750, 422, true); //Blog Detail
add_image_size('wp_rem_cs_media_2', 750, 312, true); //Blog Large 
add_image_size('wp_rem_cs_media_3', 360, 223, true); //Blog Gride 
add_image_size('wp_rem_cs_media_4', 252, 189, true); //Blog Medium
add_image_size('wp_rem_cs_media_5', 409, 250, true); //Properties Grid
add_image_size('wp_rem_cs_media_6', 320, 180, true); //Properties Medium
add_image_size('wp_rem_cs_media_7', 750, 397, true); //Properties Detail
add_image_size('wp_rem_cs_media_8', 352, 264, true); //Properties featured
add_image_size('wp_rem_cs_media_9', 255, 252, true); //Properties list modern

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! function_exists('wp_rem_cs_content_width') ) {

    function wp_rem_cs_content_width() {
        $GLOBALS['content_width'] = apply_filters('wp_rem_cs_content_width', 640);
    }

    add_action('after_setup_theme', 'wp_rem_cs_content_width', 0);
}
/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Auto Mobile 1.0
 */
if ( ! function_exists('wp_rem_cs_widgets_init') ) {

    function wp_rem_cs_widgets_init() {

        global $wp_rem_cs_var_options, $wp_rem_cs_var_static_text;

        /**
         * @If Theme Activated
         */
        if ( get_option('wp_rem_cs_var_options') ) {
            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) && ! empty($wp_rem_cs_var_options['wp_rem_cs_var_sidebar']) ) {
                foreach ( $wp_rem_cs_var_options['wp_rem_cs_var_sidebar'] as $sidebar ) {
                    $sidebar_id = sanitize_title($sidebar);

                    $wp_rem_cs_widget_start = '<div class="widget %2$s">';
                    $wp_rem_cs_widget_end = '</div>';
                    if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_widget_sidebar']) && $wp_rem_cs_var_options['wp_rem_cs_var_footer_widget_sidebar'] == $sidebar ) {

                        $wp_rem_cs_widget_start = '<aside class="widget col-lg-4 col-md-4 col-sm-6 col-xs-12 %2$s">';
                        $wp_rem_cs_widget_end = '</aside>';
                    }
                    register_sidebar(array(
                        'name' => wp_rem_cs_allow_special_char($sidebar),
                        'id' => wp_rem_cs_allow_special_char($sidebar_id),
                        'description' => esc_html(wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widget_display_text')),
                        'before_widget' => wp_rem_cs_allow_special_char($wp_rem_cs_widget_start),
                        'after_widget' => wp_rem_cs_allow_special_char($wp_rem_cs_widget_end),
                        'before_title' => '<div class="widget-title"><h5>',
                        'after_title' => '</h5></div>'
                    ));
                }
            }

            $sidebar_name = '';
            if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar']) && ! empty($wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar']) ) {
                $i = 0;
                foreach ( $wp_rem_cs_var_options['wp_rem_cs_var_footer_sidebar'] as $wp_rem_cs_var_footer_sidebar ) {

                    $footer_sidebar_id = sanitize_title($wp_rem_cs_var_footer_sidebar);
                    $sidebar_name = isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_footer_width'] : '';
                    $wp_rem_cs_sidebar_name = isset($sidebar_name[$i]) ? $sidebar_name[$i] : '';
                    $custom_width = str_replace('(', ' - ', $wp_rem_cs_sidebar_name);
                    $wp_rem_cs_widget_start = '<div class="widget %2$s">';
                    $wp_rem_cs_widget_end = '</div>';

                    if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_footer_widget_sidebar']) && $wp_rem_cs_var_options['wp_rem_cs_var_footer_widget_sidebar'] == $wp_rem_cs_var_footer_sidebar ) {

                        $wp_rem_cs_widget_start = '<aside class="widget col-lg-4 col-md-4 col-sm-6 col-xs-12 %2$s">';
                        $wp_rem_cs_widget_end = '</aside>';
                    }

                    register_sidebar(array(
                        'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_footer') . $wp_rem_cs_var_footer_sidebar . ' ' . '(' . $custom_width . ' ',
                        'id' => wp_rem_cs_allow_special_char($footer_sidebar_id),
                        'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widget_display_text'),
                        'before_widget' => wp_rem_cs_allow_special_char($wp_rem_cs_widget_start),
                        'after_widget' => wp_rem_cs_allow_special_char($wp_rem_cs_widget_end),
                        'before_title' => '<div class="widget-title"><h5>',
                        'after_title' => '</h5></div>'
                    ));
                    $i ++;
                }
            }
        } else {
            register_sidebar(array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widgets'),
                'id' => 'sidebar-1',
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_widget_display_right_text'),
                'before_widget' => '<div class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h5>',
                'after_title' => '</h5></div>'
            ));
        }
    }

    add_action('widgets_init', 'wp_rem_cs_widgets_init');
}
/**
 * Add meta tag in head.
 */
if ( ! function_exists('wp_rem_add_meta_tags') ) {

    function wp_rem_add_meta_tags() {

        echo '<meta http-equiv="X-UA-Compatible" content="IE=edge" />';
    }

    add_action('wp_head', 'wp_rem_add_meta_tags', 2);
}

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists('wp_rem_cs_scripts_1') ) {

    function wp_rem_cs_scripts_1() {
        global $wp_rem_cs_var_options;
        $wp_rem_cs_responsive_site = isset($wp_rem_cs_var_options['wp_rem_cs_var_responsive']) ? $wp_rem_cs_var_options['wp_rem_cs_var_responsive'] : '';

        $theme_version = SCRIPTS_VER;
        wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/assets/frontend/css/bootstrap.css');
        wp_enqueue_style('bootstrap-theme', get_template_directory_uri() . '/assets/frontend/css/bootstrap-theme.css');
        wp_enqueue_style('chosen', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/chosen.css');
        wp_enqueue_style('swiper', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/swiper.css');
        wp_enqueue_style('wp-rem-style', get_stylesheet_uri(), [], SCRIPTS_VER);
        wp_enqueue_style('blog-boxed', get_template_directory_uri() . '/assets/frontend/css/blog-boxed.css'); // temperory
        wp_enqueue_style('aston', get_template_directory_uri() . '/assets/frontend/css/aston.css'); // temperory
        wp_enqueue_style('wp-rem-widget', get_template_directory_uri() . '/assets/frontend/css/widget.css');
        wp_enqueue_style('iconmoon', (get_template_directory_uri()) . '/assets/common/icomoon/css/iconmoon.css');
        wp_register_style('wp-rem-prettyPhoto', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/prettyPhoto.css');

        if ( is_singular() && comments_open() && get_option('thread_comments') ) {
            wp_enqueue_script('comment-reply');
        }
        wp_enqueue_script('bootstrap-min', get_template_directory_uri() . '/assets/common/js/bootstrap.min.js', array( 'jquery' ), $theme_version);
        wp_enqueue_script('modernizr', get_template_directory_uri() . '/assets/frontend/js/modernizr.js', array( 'jquery' ), $theme_version, true);
        
        wp_register_script('wp-rem-counter', get_template_directory_uri() . '/assets/frontend/js/counter.js', array( 'jquery' ), $theme_version, true);
        
        wp_enqueue_script('responsive-menu', get_template_directory_uri() . '/assets/frontend/js/responsive.menu.js', '', $theme_version, true);
        wp_enqueue_script('chosen', get_template_directory_uri() . '/assets/common/js/chosen.select.js', '', $theme_version);
        wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/frontend/js/swiper.min.js', '', $theme_version, true);
        
        //wp_enqueue_script('fliters', get_template_directory_uri() . '/assets/frontend/js/fliters.js', '', $theme_version, true);
        
        //wp_enqueue_script('wp-rem-maps-styles', trailingslashit(get_template_directory_uri()) . 'assets/backend/js/cs-map_styles.js', '', $theme_version, true);
        wp_enqueue_script('fitvids', get_template_directory_uri() . '/assets/frontend/js/fitvids.js', '', $theme_version, true);
        // JQUERY BLOCK UI
        wp_enqueue_script('blockui', get_template_directory_uri() . '/assets/frontend/js/jquery.blockUI.min.js', '', $theme_version, true);
        
        //wp_enqueue_script('skills-progress', get_template_directory_uri() . '/assets/frontend/js/skills-progress.js', '', $theme_version, true);
        
        wp_enqueue_script('wp-rem-functions', get_template_directory_uri() . '/assets/frontend/js/functions.js', '', $theme_version, true);
        wp_register_script('wp-rem-lightbox', trailingslashit(get_template_directory_uri()) . 'assets/frontend/js/lightbox.js', '', '', true);
        wp_register_script('wp-rem-prettyPhoto', trailingslashit(get_template_directory_uri()) . 'assets/frontend/js/jquery.prettyPhoto.js', '', '', true);
        wp_register_script('wp-rem-growls', get_template_directory_uri() . '/assets/frontend/js/jquery.growl.js', '', $theme_version, true);
        if ( class_exists('WooCommerce') ) {
            wp_enqueue_style('custom-woocommerce', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/woocommerce.css');
        }
        if ( ! function_exists('wp_rem_cs_addthis_script_init_method') ) {

            function wp_rem_cs_addthis_script_init_method() {
                wp_enqueue_script('addthis', trailingslashit(get_template_directory_uri()) . 'assets/frontend/js/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
            }

        }
        if ( ! function_exists('wp_rem_cs_inline_enqueue_script') ) {

            function wp_rem_cs_inline_enqueue_script($script = '', $script_handler = 'wp-rem-custom-inline') {
                wp_register_script('wp-rem-custom-inline', trailingslashit(get_template_directory_uri()) . 'assets/common/js/custom-inline.js', '', '', true);
                wp_enqueue_script('wp-rem-custom-inline');
                wp_add_inline_script('wp-rem-custom-inline', $script);
            }

        }
        if ( ! function_exists('wp_rem_cs_var_dynamic_scripts') ) {

            function wp_rem_cs_var_dynamic_scripts($wp_rem_cs_js_key, $wp_rem_cs_arr_key, $wp_rem_cs_js_code) {
                // Register the script
                wp_register_script('wp-rem-dynamic-scripts', trailingslashit(get_template_directory_uri()) . 'assets/frontend/js/inline-scripts-functions.js', '', '', true);
                // Localize the script
                $wp_rem_cs_code_array = array(
                    $wp_rem_cs_arr_key => $wp_rem_cs_js_code
                );
                wp_localize_script('wp-rem-dynamic-scripts', $wp_rem_cs_js_key, $wp_rem_cs_code_array);
                wp_enqueue_script('wp-rem-dynamic-scripts');
            }

        }
        if ( ! function_exists('wp_rem_inline_enqueue_style') ) {

            function wp_rem_inline_enqueue_style($script = '', $script_handler = 'inline-style-functions') {
                wp_register_style('inline-style-functions', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/inline-style-functions.css', '', '', true);
                wp_enqueue_style($script_handler);
                wp_add_inline_style($script_handler, $script);
            }

        }
    }

    add_action('wp_enqueue_scripts', 'wp_rem_cs_scripts_1', 1);
}

if ( ! function_exists('wp_rem_gallery_masonry') ) {

    function wp_rem_gallery_masonry() {
        wp_enqueue_script('wp_rem_init_js', trailingslashit(get_template_directory_uri()) . 'assets/frontend/js/init.js', '', '', true);
        wp_enqueue_script('wp_rem_freetile_js', trailingslashit(get_template_directory_uri()) . 'assets/frontend/js/jquery.freetile.js', '', '', true);
        wp_enqueue_script('wp_rem_masonry_pkgd_min_js', trailingslashit(get_template_directory_uri()) . 'assets/frontend/js/masonry.pkgd.min.js', '', '', true);
    }

}

if ( ! function_exists('wp_rem_cs_header_color_styles') ) {

    function wp_rem_cs_header_color_styles() {
        global $wp_rem_cs_var_options;
        $custom_style_ver = (isset($wp_rem_cs_var_options['wp_rem_cs_var_theme_option_save_flag'])) ? $wp_rem_cs_var_options['wp_rem_cs_var_theme_option_save_flag'] : '';
        wp_enqueue_style('wp_rem_cs-default-element-style', trailingslashit(get_template_directory_uri()) . '/assets/frontend/css/default-element.css', '', $custom_style_ver);
    }

    add_action('wp_enqueue_scripts', 'wp_rem_cs_header_color_styles', 9);
}

/**
 * Enqueue scripts and styles.
 */
if ( ! function_exists('wp_rem_cs_scripts_10') ) {

    function wp_rem_cs_scripts_10() {
        global $wp_rem_cs_var_options;
        $wp_rem_cs_responsive_site = isset($wp_rem_cs_var_options['wp_rem_cs_var_responsive']) ? $wp_rem_cs_var_options['wp_rem_cs_var_responsive'] : '';
        if ( is_rtl() ) {
            wp_enqueue_style('wp_rem_cs-rtl', get_template_directory_uri() . '/assets/frontend/css/rtl.css');
        }
        if ( $wp_rem_cs_responsive_site == 'on' ) {
            $theme_version = wp_rem_cs_get_theme_version();
            wp_enqueue_style('wp_rem_responsive_css', get_template_directory_uri() . '/assets/frontend/css/responsive.css', '', $theme_version);
        }
    }

    add_action('wp_enqueue_scripts', 'wp_rem_cs_scripts_10', 10);
}

/**
 * Custom Css
 */
if ( ! function_exists('wp_rem_custom_inline_styles_method') ) {

    function wp_rem_custom_inline_styles_method() {
        global $wp_rem_cs_var_options;
        $wp_rem_custom_css = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_css']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_css'] : '';
        if ( $wp_rem_custom_css != '' ) {
            wp_enqueue_style('custom-style-inline', trailingslashit(get_template_directory_uri()) . 'assets/frontend/css/custom-script.css', '', '', true);
            wp_add_inline_style('custom-style-inline', $wp_rem_custom_css);
        }
    }

    add_action('wp_enqueue_scripts', 'wp_rem_custom_inline_styles_method', 30);
}

/**
 * Add Admin Page for 
 * Theme Options Menu
 */
if ( ! function_exists('wp_rem_cs_var_options') ) {
    add_action('admin_menu', 'wp_rem_cs_var_options');

    function wp_rem_cs_var_options() {
        global $wp_rem_cs_var_static_text;
        $wp_rem_cs_var_theme_options = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_theme_options');
        if ( current_user_can('administrator') ) {
            add_menu_page($wp_rem_cs_var_theme_options, $wp_rem_cs_var_theme_options, 'manage_options', 'wp_rem_settings_page', 'wp_rem_settings_page', '', 44);
        }
    }

}

/**
 * Enqueue Google Fonts.
 */
if ( ! function_exists('wp_rem_cs_var_load_google_font_families') ) {

    function wp_rem_cs_var_load_google_font_families() {
        if ( wp_rem_cs_var_is_fonts_loaded() ) {
            $fonts_array = wp_rem_cs_var_is_fonts_loaded();
            $fonts_url = wp_rem_cs_var_get_font_families($fonts_array);
            if ( $fonts_url ) {
                $font_url = add_query_arg('family', urlencode($fonts_url), "//fonts.googleapis.com/css");
                wp_enqueue_style('wp-rem-google-fonts', $font_url, array(), '');
            }
        }
    }

    add_action('wp_enqueue_scripts', 'wp_rem_cs_var_load_google_font_families', 0);
}

/*
 * admin Enque Scripts
 */
if ( ! function_exists('wp_rem_cs_var_admin_scripts_enqueue') ) {

    function wp_rem_cs_var_admin_scripts_enqueue() {
        $theme_version = wp_rem_cs_get_theme_version();
        if ( is_admin() ) {
            global $wp_rem_cs_var_template_path;
            $wp_rem_cs_var_template_path = trailingslashit(get_template_directory_uri()) . 'assets/backend/js/cs-media-upload.js';
            wp_enqueue_style('fonticonpicker', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/css/jquery.fonticonpicker.min.css', array(), $theme_version);
            wp_enqueue_style('fonticonpicker');
            wp_enqueue_style('iconmoon', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/css/iconmoon.css');
            wp_enqueue_style('bootstrap', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css');
            wp_enqueue_style('chosen', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/chosen.css');
            wp_enqueue_style('wp-rem-bootstrap', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/bootstrap.css');
            wp_enqueue_style('wp_rem_cs-admin-lightbox', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/lightbox.css');
            wp_enqueue_style('wp-rem-admin-style', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/admin-style.css');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('admin-upload', $wp_rem_cs_var_template_path, array( 'jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker' ));
            wp_enqueue_script('fonticonpicker', trailingslashit(get_template_directory_uri()) . 'assets/common/icomoon/js/jquery.fonticonpicker.min.js');
            wp_enqueue_script('bootstrap', trailingslashit(get_template_directory_uri()) . 'assets/common/js/bootstrap.min.js', '', '', true);
            wp_enqueue_style('jquery_datetimepicker', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/jquery_datetimepicker.css');
            wp_enqueue_style('datepicker', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/datepicker.css');
            wp_enqueue_style('jquery_ui_datepicker_theme', trailingslashit(get_template_directory_uri()) . 'assets/backend/css/jquery_ui_datepicker_theme.css');
            wp_enqueue_script('jquery_datetimepicker', trailingslashit(get_template_directory_uri()) . 'assets/backend/js/jquery_datetimepicker.js');
            wp_enqueue_script('wp_rem_cs-light-box-js', trailingslashit(get_template_directory_uri()) . 'assets/backend/js/light-box.js', '', '', true);
            wp_enqueue_script('wp_rem_cs-theme-options', trailingslashit(get_template_directory_uri()) . 'assets/backend/js/cs-theme-option-fucntions.js', '', '', true);
            $wp_rem_theme_options_vars = array(
                'ajax_url' => admin_url('admin-ajax.php'),
				'theme_url' => get_template_directory_uri(),
                'verify_blank_error' => wp_rem_cs_var_theme_text_srt('wp_rem_pur_code_cannot_be_blank'),
                'verify_code_incorrect' => wp_rem_cs_var_theme_text_srt('wp_rem_pur_code_is_not_correct'),
                'purchase_verifiying' => wp_rem_cs_var_theme_text_srt('wp_rem_pur_code_verifiying'),
                'client_logo_error' => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_client_logo_error'),
                'social_sharing_error' => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_social_sharing_error'),
                'sidebar_error' => wp_rem_cs_var_theme_text_srt('wp_rem_theme_option_sidebar_error'),
            );
            wp_localize_script('wp_rem_cs-theme-options', 'wp_rem_theme_options_vars', $wp_rem_theme_options_vars);
            wp_enqueue_script('chosen', trailingslashit(get_template_directory_uri()) . 'assets/common/js/chosen.select.js', '', '');
            wp_enqueue_script('wp_rem_cs-custom-functions', trailingslashit(get_template_directory_uri()) . 'assets/backend/js/cs-fucntions.js', '', $theme_version, true);
            ////editor script
            wp_enqueue_script('jquery-te', trailingslashit(get_template_directory_uri()) . 'assets/backend/editor/js/jquery-te-1.4.0.min.js');
            wp_enqueue_style('jquery-te', trailingslashit(get_template_directory_uri()) . 'assets/backend/editor/css/jquery-te-1.4.0.css');

            if ( ! function_exists('wp_rem_cs_admin_inline_enqueue_script') ) {

                function wp_rem_cs_admin_inline_enqueue_script($script = '', $script_handler = 'custom') {
                    wp_enqueue_script($script_handler);
                    wp_add_inline_script($script_handler, $script);
                }

            }
        }
    }

    add_action('admin_enqueue_scripts', 'wp_rem_cs_var_admin_scripts_enqueue');
}


if ( ! function_exists('wp_rem_cs_var_date_picker') ) {

    function wp_rem_cs_var_date_picker() {
        global $wp_rem_cs_var_template_path;
        wp_enqueue_script('wp_rem_cs-admin-upload', $wp_rem_cs_var_template_path, array( 'jquery', 'media-upload' ));
    }

}

/*
 * Get current theme version
 */
if ( ! function_exists('wp_rem_cs_get_theme_version') ) {

    function wp_rem_cs_get_theme_version() {
        $my_theme = wp_get_theme();
        $theme_version = $my_theme->get('Version');
        return $theme_version;
    }

}

/**
 * Default Pages title.
 *
 * @since Auto Mobile 1.0
 */
if ( ! function_exists('wp_rem_cs_post_page_title') ) {

    function wp_rem_cs_post_page_title() {

        $wp_rem_cs_var_search_result = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_search_result');
        $wp_rem_cs_var_author = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_author');
        $wp_rem_cs_var_archives = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_archives');
        $wp_rem_cs_var_daily_archives = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_daily_archives');
        $wp_rem_cs_var_monthly_archives = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_monthly_archives');
        $wp_rem_cs_var_yearly_archives = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_yearly_archives');
        $wp_rem_cs_var_tags = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_tags');
        $wp_rem_cs_var_category = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_category');
        $wp_rem_cs_var_error_404 = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_error_404');
        $wp_rem_cs_var_home = wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_home');

        if ( function_exists('is_shop') && is_shop() ) {
            $wp_rem_cs_var_post_ID = woocommerce_get_page_id('shop');
            echo get_the_title($wp_rem_cs_var_post_ID);
        } else if ( ! is_page() && ! is_singular() && ! is_search() && ! is_404() && ! is_front_page() ) {
            the_archive_title();
        } else if ( is_search() ) {
            printf($wp_rem_cs_var_search_result, '<span>' . get_search_query() . '</span>');
        } else if ( is_404() ) {
            echo esc_attr($wp_rem_cs_var_error_404);
        } else if ( is_home() ) {
            echo esc_html($wp_rem_cs_var_home);
        } else if ( is_page() || is_singular() ) {
            echo get_the_title();
        }
    }

}
add_filter('comment_form_field_comment', 'wp_rem_cs_form_field_comment', 10, 1);
add_action('comment_form_logged_in_after', 'wp_rem_cs_comment_tut_fields');
add_action('comment_form_after_fields', 'wp_rem_cs_comment_tut_fields');

function wp_rem_cs_form_field_comment($field) {

    return '';
}

function wp_rem_cs_comment_tut_fields() {

    $cs_msg_class = '';
    if ( is_user_logged_in() ) {
        $cs_msg_class = ' cs-message';
    }
    $comment_field = '<textarea name="comment" class="commenttextarea" rows="55" cols="15" placeholder="' . wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_comment_text_here') . '"></textarea>';
    $html = '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12' . esc_html($cs_msg_class) . '"><div class="field-holder"><label>' . force_balance_tags($comment_field) . '</label></div></div>';
    echo force_balance_tags($html);
}

if ( ! function_exists('wp_rem_allow_special_char') ) {

    function wp_rem_allow_special_char($input = '') {

        $output = $input;

        return $output;
    }

}

/**
 * Including the required files
 *
 * @since Wp_rem_cs 1.0
 */
if ( ! function_exists('wp_rem_cs_require_theme_files') ) {

    function wp_rem_cs_require_theme_files($wp_rem_cs_path = '') {
        global $wp_filesystem;
        if (!$wp_filesystem) {
            $wp_filesystem = new WP_Filesystem_Direct(1);
        }
        // $backup_url = '';
        // if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {
        //     return true;
        // }
        // if (!WP_Filesystem($creds)) {
        //     request_filesystem_credentials($backup_url, '', true, false, array());
        //     return true;
        // }
        $wp_rem_cs_sh_front_dir = trailingslashit(get_template_directory()) . $wp_rem_cs_path;
        $wp_rem_cs_all_f_list = $wp_filesystem->dirlist($wp_rem_cs_sh_front_dir);
        if ( is_array($wp_rem_cs_all_f_list) && sizeof($wp_rem_cs_all_f_list) > 0 ) {
            foreach ( $wp_rem_cs_all_f_list as $file_key => $file_val ) {
                if ( isset($file_val['name']) ) {
                    $wp_rem_cs_file_name = $file_val['name'];
                    $wp_rem_cs_ext = pathinfo($wp_rem_cs_file_name, PATHINFO_EXTENSION);
                    if ( $wp_rem_cs_ext == 'php' ) {
                        require_once trailingslashit(get_template_directory()) . $wp_rem_cs_path . $wp_rem_cs_file_name;
                    }
                }
            }
        }
    }

}
/**
 * stripslashes string
 *
 * @since Auto Mobile 1.0
 */
if ( ! function_exists('wp_rem_cs_var_stripslashes_htmlspecialchars') ) {

    function wp_rem_cs_var_stripslashes_htmlspecialchars($value) {
        $value = is_array($value) ? array_map('wp_rem_cs_var_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
        return $value;
    }

}

require_once ABSPATH . '/wp-admin/includes/file.php';
/**
 * Mega Menu.
 */
require_once trailingslashit(get_template_directory()) . 'include/mega-menu/custom-walker.php';
require_once trailingslashit(get_template_directory()) . 'include/mega-menu/edit-custom-walker.php';
require_once trailingslashit(get_template_directory()) . 'include/mega-menu/menu-functions.php';
/**
 * Implement the Custom Header feature.
 */
require_once trailingslashit(get_template_directory()) . 'include/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once trailingslashit(get_template_directory()) . 'include/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once trailingslashit(get_template_directory()) . 'include/extras.php';

/*
 * Inlcude themes required files for theme options
 */
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-custom-fields/cs-form-fields.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-custom-fields/cs-html-fields.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-admin-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/importer-hooks.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-googlefont/cs-fonts-array.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-googlefont/cs-fonts.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-googlefont/cs-fonts-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/import/cs-class-widget-data.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options-functions.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options-fields.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-theme-options/cs-theme-options-arrays.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-activation-plugins/cs-require-plugins.php';
require_once trailingslashit(get_template_directory()) . 'include/cs-class-parse.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/theme-config.php';
require_once trailingslashit(get_template_directory()) . 'include/frontend/cs-header.php';
require_once trailingslashit(get_template_directory()) . 'include/frontend/class-pagination.php';
require_once trailingslashit(get_template_directory()) . 'template-parts/blog/blog_element.php';
require_once trailingslashit(get_template_directory()) . 'template-parts/blog/blog_functions.php';
/*
 * Inlcude theme classes files
 */
require_once trailingslashit(get_template_directory()) . 'include/backend/classes/class-category-meta.php';
/*
 * Inlcude theme required files for widgets
 */
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-custom-menu.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-flickr.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-author.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-ads.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-text.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-mailchimp.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-twitter.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-facebook.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-recent-posts.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-contact-info.php';
require_once trailingslashit(get_template_directory()) . 'include/backend/cs-widgets/cs-fancymenu.php';
if ( class_exists('woocommerce') ) {
    require_once trailingslashit(get_template_directory()) . 'include/backend/cs-woocommerce/cs-config.php';
}

if ( ! function_exists('wp_rem_cs_include_shortcodes') ) {

    /**
     * Include shortcodes backend and frontend as well.
     */
    function wp_rem_cs_include_shortcodes() {
        /* shortcodes files */
        wp_rem_cs_require_theme_files('include/backend/cs-shortcodes/');
        wp_rem_cs_require_theme_files('include/frontend/cs-shortcodes/');
    }

    add_action('init', 'wp_rem_cs_include_shortcodes', 1);
}

$active_plugins = get_option('active_plugins', array());
if ( ! in_array('wp-realestate-manager/wp-realestate-manager.php', $active_plugins) ) {

    function wp_rem_theme_loader() {
        echo '<div class="wp_rem_loader" style="display: none;">';
        echo '<div class="loader-img"><i class="icon-spinner"></i></div></div>';
        echo '<div class="wp-rem-button-loader spinner">
			<div class="bounce1"></div>
			  <div class="bounce2"></div>
			  <div class="bounce3"></div>
		  </div>';
    }

    add_action('wp_footer', 'wp_rem_theme_loader');
}