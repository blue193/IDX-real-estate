<?php
/**
 * Header Functions
 *
 * @package WordPress
 * @subpackage wp_rem_cs
 * @since Homevillas 1.0
 */
if ( ! get_option('wp_rem_cs_var_options') ) {
    $wp_rem_cs_activation_data = theme_default_options();
    if ( is_array($wp_rem_cs_activation_data) && sizeof($wp_rem_cs_activation_data) > 0 ) {
        $wp_rem_cs_var_options = $wp_rem_cs_activation_data;
    } else {
        wp_rem_cs_include_file(trailingslashit(get_template_directory()) . 'include/backend/cs-global-variables.php', true);
    }
}

if ( ! function_exists('wp_rem_cs_custom_pages_menu') ) {

    function wp_rem_cs_custom_pages_menu() {
        $cs_menu = wp_list_pages(array(
            'title_li' => '',
            'echo' => false,
        ));
        echo '<ul>' . wp_rem_cs_allow_special_char($cs_menu) . '</ul>';
    }

}

if ( ! function_exists('create_property_button') ) {

    function create_property_button() {
        global $wp_rem_cs_var_options;
        $property_btn_text = isset($wp_rem_cs_var_options['wp_rem_cs_var_add_villa_text']) ? $wp_rem_cs_var_options['wp_rem_cs_var_add_villa_text'] : '';
        $property_btn_link = isset($wp_rem_cs_var_options['wp_rem_cs_var_add_villa_url']) ? $wp_rem_cs_var_options['wp_rem_cs_var_add_villa_url'] : '';
        $property_btn_switch = isset($wp_rem_cs_var_options['wp_rem_cs_var_add_villa_swicth']) ? $wp_rem_cs_var_options['wp_rem_cs_var_add_villa_swicth'] : '';
        if ( $property_btn_text != '' && $property_btn_link != '' && $property_btn_switch == 'on' ) {
            echo '<a href="' . esc_url($property_btn_link) . '" class="property-btn">' . wp_rem_cs_allow_special_char($property_btn_text) . '</a>';
        }
    }

}
if ( ! function_exists('header_contact_us') ) {

    function header_contact_us($header_view = '') {
        global $wp_rem_cs_var_options;
        $icon_html = '';
        if ( $header_view == 'modern' ) {
            $icon_html = '<i class="icon-phone5"></i>';
        }

        $contact_us_text = isset($wp_rem_cs_var_options['wp_rem_cs_var_contact_us_text']) ? $wp_rem_cs_var_options['wp_rem_cs_var_contact_us_text'] : '';
        if ( $contact_us_text != '' ) {
            echo ' <div class="contact-info"> ';
            echo force_balance_tags($icon_html);
            echo html_entity_decode($contact_us_text);
            echo '</div>';
        }
    }

}
if ( ! function_exists('wp_rem_cs_header_main_menu') ) {

    function wp_rem_cs_header_main_menu() {

        if ( has_nav_menu('primary') ) {
            global $wp_rem_cs_var_options;
            $custom_id = '';
            $custom_id = 'site-navigation';
            ?>
            <nav id="<?php echo esc_html($custom_id); ?>" class="main-navigation" role="navigation" aria-label="<?php echo wp_rem_cs_var_theme_text_srt('wp_rem_cs_header_primary'); ?>">
                <?php
                wp_nav_menu(array(
                    'container' => ' ',
                    'theme_location' => 'primary',
                    'menu_class' => 'primary-menu',
                    'walker' => new wp_rem_cs_mega_menu_walker('main')
                ));
                ?>
            </nav><!-- .main-navigation -->
            <?php
        } else {
            ?>
            <nav class="main-navigation" id="main_nav">
                <?php
                wp_nav_menu(array(
                    'theme_location' => '',
                    'fallback_cb' => 'wp_rem_cs_custom_pages_menu',
                ));
                ?>
            </nav><!-- .main-navigation -->
            <?php
        }
    }

}
if ( ! function_exists('wp_rem_cs_header_view_1') ) {

    function wp_rem_cs_header_view_1() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $sticky_header_class = '';
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = 'sticky-header';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>
        <header id="header" class="header1">
            <div class="main-header">
                <div class="top-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                <div class="logo">
                                    <figure> 
                                        <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                                <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php }
                                            ?>
                                        </a> 
                                    </figure>
                                </div>
                            </div>
                            <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                                <div class="contact-holder header-contact-holder">
                                    <?php
                                    do_action('wp_rem_before_contact_in_header');
                                    header_contact_us();
                                    do_action('wp_rem_create_property_button');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-area <?php echo esc_html($sticky_header_class); ?>">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                <div class="main-nav">
                                    <?php wp_rem_cs_header_main_menu(); ?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                                <div class="login-area">
                                    <?php
                                    wp_rem_cs_social_network(2, '', '', 'social-media');
                                    if ( $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off' && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != '' ) {
                                        ?>
                                        <div class="login-option">
                                            <?php
                                            do_action('wp_rem_login');
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </header>
        <?php
    }

}
if ( ! function_exists('wp_rem_cs_header_view_modern') ) {

    function wp_rem_cs_header_view_modern() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_var_sticky_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $sticky_header_class = '';
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = 'sticky-header';
        }
        $sticky_logo_class = '';
        if ( ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) && ( ! empty($wp_rem_cs_var_sticky_logo) ) ) {
            $sticky_logo_class = ' sticky-logo';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>
        <header id="header" class="modern">
            <div class="main-header <?php echo esc_html($sticky_header_class); ?>">
                <div class="top-header">
                    <div class="wide">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                                <div class="logo<?php echo esc_html($sticky_logo_class); ?>">
                                    <figure> 
                                        <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                                <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php if ( ! empty($sticky_logo_class) ) { ?>
                                                    <img src="<?php echo esc_url($wp_rem_cs_var_sticky_logo) ?>" style="display:none;" alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php } ?>
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php }
                                            ?>
                                        </a> 
                                    </figure>
                                </div>
                                <div class="main-nav">
                                    <?php wp_rem_cs_header_main_menu(); ?>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="contact-holder">
                                    <?php
                                    if ( $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off' && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != '' ) {
                                        ?>
                                        <div class="login-option">
                                            <?php
                                            do_action('wp_rem_login');
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    do_action('wp_rem_create_property_button');
                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <?php
    }

}
if ( ! function_exists('wp_rem_cs_header_view_classic') ) {

    function wp_rem_cs_header_view_classic() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $wp_rem_cs_var_sticky_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo'] : '';
        $sticky_logo_class = '';
        if ( ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) && ( ! empty($wp_rem_cs_var_sticky_logo) ) ) {
            $sticky_logo_class = ' sticky-logo';
        }
        $sticky_header_class = '';
        $home_class = '';
        if ( ! is_front_page() ) {
            $home_class = ' no-transparent ';
        }
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = 'sticky-header';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>
        <header id="header" class="classic <?php echo esc_html($home_class); ?>">
            <div class="main-header">
                <div class="top-header">
                    <div class="container">
                        <div class="top-header-wrp">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="contact-holder">
                                        <?php header_contact_us('modern'); ?>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <div class="login-area">
                                        <?php
                                        do_action('wp_rem_login');
                                        ?>
                                    </div>  
                                    <?php
                                    wp_rem_cs_social_network(2, '', '', 'social-media');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-area <?php echo esc_html($sticky_header_class); ?>">
                    <div class="container">
                        <div class="logo<?php echo esc_html($sticky_logo_class); ?>">
                            <figure> 
                                <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                        <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                        <?php if ( ! empty($sticky_logo_class) ) { ?>
                                            <img src="<?php echo esc_url($wp_rem_cs_var_sticky_logo) ?>" style="display:none;" alt="<?php esc_html(bloginfo('name')) ?>">
                                        <?php } ?>
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                    <?php }
                                    ?>
                                </a> 
                            </figure>
                        </div>
                        <div class="main-nav">
                            <?php wp_rem_cs_header_main_menu(); ?>
                        </div>

                    </div>
                </div>
            </div>
        </header>


        <?php
    }

}
if ( ! function_exists('wp_rem_cs_header_view_fancy') ) {

    function wp_rem_cs_header_view_fancy() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $wp_rem_cs_var_sticky_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo'] : '';
        $sticky_logo_class = '';
        if ( ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) && ( ! empty($wp_rem_cs_var_sticky_logo) ) ) {
            $sticky_logo_class = ' sticky-logo';
        }
        $sticky_header_class = '';
        $home_class = '';
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = ' sticky-header';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>
        <header id="header" class="default">
            <div class="main-header <?php echo esc_html($sticky_header_class); ?>">
                <div class="top-header">
                    <div class="container">
                        <div class="row">
                            <div class="logo<?php echo esc_html($sticky_logo_class); ?>">
                                <figure> 
                                    <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                            <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php if ( ! empty($sticky_logo_class) ) { ?>
                                                <img src="<?php echo esc_url($wp_rem_cs_var_sticky_logo) ?>" style="display:none;" alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php } ?>
                                            <?php
                                        } else {
                                            ?>
                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                        <?php }
                                        ?>
                                    </a> 
                                </figure>
                            </div>
                            <div class="main-nav">
                                <?php wp_rem_cs_header_main_menu(); ?>
                            </div>
                            <div class="contact-holder">
                                <div class="login-option">
                                    <span class="phone"><?php header_contact_us(); ?></span>
                                    <?php
                                    if ( $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off' && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != '' ) {
                                        do_action('wp_rem_login');
                                    }
                                    ?>
                                </div>
                                <?php do_action('wp_rem_create_property_button'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }

}
if ( ! function_exists('wp_rem_cs_header_view_default') ) {

    function wp_rem_cs_header_view_default() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_var_header_full_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_full_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_full_width'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $wp_rem_cs_var_sticky_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo'] : '';




        $sticky_logo_class = '';
        if ( ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) && ( ! empty($wp_rem_cs_var_sticky_logo) ) ) {
            $sticky_logo_class = ' sticky-logo';
        }
        $home_class = '';
        if ( ! is_front_page() ) {
            $home_class = ' no-transparent ';
        }

        $sticky_header_class = '';
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = ' sticky-header';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        $container_class = 'container-fluid';
        if ( isset($wp_rem_cs_var_header_full_width) && $wp_rem_cs_var_header_full_width == 'off' ) {
            $container_class = 'container';
        }
        ?>
        <header id="header" class="default default-v2<?php echo esc_html($home_class); ?>">
            <div class="main-header <?php echo esc_html($sticky_header_class); ?>">
                <div class="<?php echo wp_rem_cs_allow_special_char($container_class); ?>">
                    <div class="row">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <div class="logo<?php echo esc_html($sticky_logo_class); ?>">
                                <figure> 
                                    <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                            <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php if ( ! empty($sticky_logo_class) ) { ?>
                                                <img src="<?php echo esc_url($wp_rem_cs_var_sticky_logo) ?>" style="display:none;" alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php } ?>
                                            <?php
                                        } else {
                                            ?>
                                            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                        <?php }
                                        ?>
                                    </a> 
                                </figure>
                            </div>
                        </div>
                        <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                            <div class="main-nav">
                                <?php wp_rem_cs_header_main_menu(); ?> 
                            </div>
                            <?php if ( (isset($wp_rem_plugin_options['wp_rem_create_listing_button']) && $wp_rem_plugin_options['wp_rem_create_listing_button'] != 'off' ) || (isset($wp_rem_plugin_options['wp_rem_user_dashboard_switchs']) && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off') ) { ?>
                                <div class="contact-holder">
                                    <?php if ( $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off' && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != '' ) { ?>
                                        <div class="login-option"><?php do_action('wp_rem_login'); ?></div>
                                    <?php } ?>
                                    <?php do_action('wp_rem_create_property_button'); ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }

}
if ( ! function_exists('wp_rem_cs_header_view_advance') ) {

    function wp_rem_cs_header_view_advance() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $wp_rem_cs_var_sticky_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo'] : '';
        $sticky_logo_class = '';
        if ( ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) && ( ! empty($wp_rem_cs_var_sticky_logo) ) ) {
            $sticky_logo_class = ' sticky-logo';
        }
        $sticky_header_class = '';
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = ' sticky-header';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>
        <header id="header" class="advance">
            <div class="main-header<?php echo esc_html($sticky_header_class); ?>">
                <div class="top-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                                <div class="logo<?php echo esc_html($sticky_logo_class); ?>">
                                    <figure> 
                                        <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                                <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php if ( ! empty($sticky_logo_class) ) { ?>
                                                    <img src="<?php echo esc_url($wp_rem_cs_var_sticky_logo) ?>" style="display:none;" alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php } ?>
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php }
                                            ?>
                                        </a> 
                                    </figure>
                                </div>
                                <div class="main-nav">
                                    <?php wp_rem_cs_header_main_menu(); ?>  
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="user-option">
                                    <div class="login-area">
                                        <div class="login-option"> 
                                            <?php
                                            if ( $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off' && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != '' ) {
                                                do_action('wp_rem_login');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php do_action('wp_rem_create_property_button'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </header>
        <?php
    }

}

if ( ! function_exists('wp_rem_cs_header_view_advance_v2') ) {

    function wp_rem_cs_header_view_advance_v2() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $wp_rem_cs_var_sticky_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo'] : '';


        $wp_rem_cs_var_header_full_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_full_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_full_width'] : '';
        $container_class = 'container-fluid';
        if ( isset($wp_rem_cs_var_header_full_width) && $wp_rem_cs_var_header_full_width == 'off' ) {
            $container_class = 'container';
        }


        $sticky_logo_class = '';
        if ( ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) && ( ! empty($wp_rem_cs_var_sticky_logo) ) ) {
            $sticky_logo_class = ' sticky-logo';
        }
        $sticky_header_class = '';
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = ' sticky-header';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>
        <header id="header" class="advance v2">
            <div class="main-header<?php echo esc_html($sticky_header_class); ?>">
                <div class="top-header">
                    <div class="<?php echo wp_rem_cs_allow_special_char($container_class); ?>">
                        <div class="row">
                            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                <div class="logo<?php echo esc_html($sticky_logo_class); ?>">
                                    <figure> 
                                        <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                                <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php if ( ! empty($sticky_logo_class) ) { ?>
                                                    <img src="<?php echo esc_url($wp_rem_cs_var_sticky_logo) ?>" style="display:none;" alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php } ?>
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php }
                                            ?>
                                        </a> 
                                    </figure>
                                </div>
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
                                <div class="main-nav">
                                    <?php wp_rem_cs_header_main_menu(); ?>  
                                </div>
                                <div class="user-option">
                                    <?php do_action('wp_rem_before_contact_in_header'); ?>
                                    <div class="login-area">
                                        <div class="login-option"> 
                                            <?php
                                            if ( $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off' && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != '' ) {
                                                do_action('wp_rem_login', 'advance_v2');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php do_action('wp_rem_create_property_button', 'false'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </header>
        <?php
    }

}



if ( ! function_exists('wp_rem_cs_header_view_modern_v2') ) {

    function wp_rem_cs_header_view_modern_v2() {
        global $wp_rem_cs_var_options, $wp_rem_cs_var_form_fields, $wp_rem_plugin_options;
        $wp_rem_cs_custom_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_logo'] : '';
        $wp_rem_cs_logo_height = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_height']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_height'] : '';
        $wp_rem_cs_logo_width = isset($wp_rem_cs_var_options['wp_rem_cs_var_logo_width']) ? $wp_rem_cs_var_options['wp_rem_cs_var_logo_width'] : '';
        $wp_rem_cs_autosidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_autosidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_autosidebar'] : '';
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        $wp_rem_cs_var_sticky_logo = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_logo'] : '';
        $sticky_logo_class = '';
        if ( ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) && ( ! empty($wp_rem_cs_var_sticky_logo) ) ) {
            $sticky_logo_class = ' sticky-logo';
        }
        $sticky_header_class = '';
        $home_class = '';
        if ( ! is_front_page() ) {
            $home_class = ' no-transparent ';
        }
        if ( isset($wp_rem_cs_var_sticky_header) && $wp_rem_cs_var_sticky_header == 'on' ) {
            $sticky_header_class = ' sticky-header';
        }
        $style_string = '';
        if ( '' !== $wp_rem_cs_logo_width || '' !== $wp_rem_cs_logo_height ) {
            $style_string = 'style="';
            if ( '' !== $wp_rem_cs_logo_width ) {
                $style_string .= 'width:' . absint($wp_rem_cs_logo_width) . 'px;';
            }
            if ( '' !== $wp_rem_cs_logo_height ) {
                $style_string .= 'height:' . absint($wp_rem_cs_logo_height) . 'px;';
            }
            $style_string .= '"';
        }
        ?>
        <header id="header" class="modern transparent<?php
        echo wp_rem_cs_allow_special_char($sticky_header_class);
        echo wp_rem_cs_allow_special_char($home_class);
        ?>">
            <div class="main-header">
                <div class="top-header">
                    <div class="wide">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                                <div class="logo<?php echo esc_html($sticky_logo_class); ?>">
                                    <figure> 
                                        <a href="<?php echo esc_url(home_url('/')) ?>"> <?php if ( $wp_rem_cs_custom_logo != '' ) { ?>
                                                <img src="<?php echo esc_url($wp_rem_cs_custom_logo) ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php if ( ! empty($sticky_logo_class) ) { ?>
                                                    <img src="<?php echo esc_url($wp_rem_cs_var_sticky_logo) ?>" style="display:none;" alt="<?php esc_html(bloginfo('name')) ?>">
                                                <?php } ?>
                                                <?php
                                            } else {
                                                ?>
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/logo-classic.png') ?>" <?php echo wp_rem_cs_allow_special_char($style_string); ?> alt="<?php esc_html(bloginfo('name')) ?>">
                                            <?php }
                                            ?>
                                        </a> 
                                    </figure>
                                </div>
                                <div class="main-nav">
                                    <?php wp_rem_cs_header_main_menu(); ?>   
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                <div class="user-option">
                                    <div class="login-area">
                                        <div class="login-option"> 
                                            <?php
                                            if ( $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != 'off' && $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] != '' ) {
                                                do_action('wp_rem_login');
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <?php do_action('wp_rem_create_property_button'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php
    }

}

if ( ! function_exists('wp_rem_cs_main_header') ) {

    function wp_rem_cs_main_header() {
        global $wp_rem_cs_var_options;
        $current_page_id = get_the_ID();
        $theme_option_header_style = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_style']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_style'] : '';
        $page_header_style = get_post_meta($current_page_id, 'wp_rem_cs_var_page_header_style', true);
        $page_header_style = isset($page_header_style) ? $page_header_style : '';
        $toggle_sidebar = isset($wp_rem_cs_var_options['wp_rem_cs_var_toggle_sidebar']) ? $wp_rem_cs_var_options['wp_rem_cs_var_toggle_sidebar'] : '';
        if ( isset($page_header_style) && ! empty($page_header_style) ) {
            $dynamic_function_name = 'wp_rem_cs_header_view_' . $page_header_style;
            $dynamic_function_name();
        } elseif ( isset($theme_option_header_style) && ! empty($theme_option_header_style) ) {
            $dynamic_function_name = 'wp_rem_cs_header_view_' . $theme_option_header_style;
            $dynamic_function_name();
        } else {
            wp_rem_cs_header_view_1();
        }
    }

}
if ( ! function_exists('wp_rem_cs_sticky_header') ) {

    function wp_rem_cs_sticky_header() {
        global $wp_rem_cs_var_options;
        $wp_rem_cs_var_sticky_header = isset($wp_rem_cs_var_options['wp_rem_cs_var_sticky_header']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sticky_header'] : '';
        if ( $wp_rem_cs_var_sticky_header == 'on' ) {
            echo 'has-stick';
        }
    }

    add_action('wp_rem_cs_sticky_class', 'wp_rem_cs_sticky_header');
}
if ( ! function_exists('wp_rem_cs_var_subheader_style') ) {

    function wp_rem_cs_var_subheader_style($wp_rem_cs_var_post_ID = '') {
        global $post, $wp_query, $wp_rem_cs_var_options, $wp_rem_cs_var_post_meta;
        $post_type = get_post_type(get_the_ID());
        $wp_rem_cs_var_post_ID = get_the_ID();
        if ( get_post_type() != 'members' ) {
            if ( is_search() || is_category() || is_home() || is_404() || is_archive() ) {
                $wp_rem_cs_var_post_ID = '';
            }
            $meta_element = 'wp_rem_cs_full_data';
            $wp_rem_cs_var_post_meta = get_post_meta((int) $wp_rem_cs_var_post_ID, "$meta_element", true);
            $wp_rem_cs_var_header_banner_style = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_header_banner_style", true);

            if ( isset($wp_rem_cs_var_header_banner_style) && $wp_rem_cs_var_header_banner_style == 'no-header' ) {
                $wp_rem_cs_var_header_border_color = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_main_header_border_color", true);
                if ( $wp_rem_cs_var_header_border_color <> '' ) {
                    $wp_rem_cs_header_border_style = '
				#header {
                    border-bottom: 1px solid ' . $wp_rem_cs_var_header_border_color . ';
                }';
                    wp_rem_cs_var_dynamic_scripts('wp_rem_cs_header_border_style', 'css', $wp_rem_cs_header_border_style);
                }
                echo '<div class="cs-no-subheader"></div>';
            } else if ( isset($wp_rem_cs_var_header_banner_style) && $wp_rem_cs_var_header_banner_style == 'breadcrumb_header' ) {
                wp_rem_cs_var_breadcrumb_page_setting($wp_rem_cs_var_post_ID);
            } else if ( isset($wp_rem_cs_var_header_banner_style) && $wp_rem_cs_var_header_banner_style == 'custom_slider' ) {
                wp_rem_cs_var_rev_slider('pages', $wp_rem_cs_var_post_ID);
            } else if ( isset($wp_rem_cs_var_header_banner_style) && $wp_rem_cs_var_header_banner_style == 'map' ) {
                wp_rem_cs_var_page_map($wp_rem_cs_var_post_ID);
            } else if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_default_header']) ) {
                if ( $wp_rem_cs_var_options['wp_rem_cs_var_default_header'] == 'no_header' ) {
                    $wp_rem_cs_var_header_border_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_header_border_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_header_border_color'] : '';
                    if ( $wp_rem_cs_var_header_border_color <> '' ) {
                        $wp_rem_cs_header_border_style = '
                    #header .cs-main-nav .pinned {
                        border-bottom: 1px solid ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_header_border_color) . ';
                    }';
                        wp_rem_cs_var_dynamic_scripts('wp_rem_cs_header_border_style', 'css', $wp_rem_cs_header_border_style);
                    }
                } else if ( $wp_rem_cs_var_options['wp_rem_cs_var_default_header'] == 'breadcrumbs_sub_header' ) {
                    wp_rem_cs_var_breadcrumb_theme_option($wp_rem_cs_var_post_ID);
                } else if ( $wp_rem_cs_var_options['wp_rem_cs_var_default_header'] == 'slider' ) {
                    wp_rem_cs_var_rev_slider('default-pages', $wp_rem_cs_var_post_ID);
                }
            }
        }
    }

}

/*
 * Start Rev slider function
 */

if ( ! function_exists('wp_rem_cs_var_rev_slider') ) {

    function wp_rem_cs_var_rev_slider($wp_rem_cs_var_slider_type = '', $wp_rem_cs_var_post_ID = '') {
        global $post, $post_meta, $wp_rem_cs_var_options;
        if ( $wp_rem_cs_var_slider_type == 'pages' ) {
            $wp_rem_cs_var_rev_slider_id = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_custom_slider_id", true);
        } else {
            $wp_rem_cs_var_rev_slider_id = isset($wp_rem_cs_var_options['wp_rem_cs_var_custom_slider']) ? $wp_rem_cs_var_options['wp_rem_cs_var_custom_slider'] : '';
        }
        if ( isset($wp_rem_cs_var_rev_slider_id) && $wp_rem_cs_var_rev_slider_id != '' ) {
            ?>
            <div class="cs-banner"><?php echo do_shortcode("[rev_slider alias=\"{$wp_rem_cs_var_rev_slider_id}\"]"); ?> </div>
            <?php
        }
    }

}

/*
 * Start page map function
 */

if ( ! function_exists('wp_rem_cs_var_page_map') ) {

    function wp_rem_cs_var_page_map($wp_rem_cs_var_post_ID = '') {
        global $post, $post_meta, $header_map;
        $wp_rem_cs_var_custom_map = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_custom_map", true);
        if ( empty($wp_rem_cs_var_custom_map) ) {
            $wp_rem_cs_var_custom_map = "";
        } else {
            $wp_rem_cs_var_custom_map = html_entity_decode($wp_rem_cs_var_custom_map);
        }
        if ( isset($wp_rem_cs_var_custom_map) && $wp_rem_cs_var_custom_map != '' ) {
            $header_map = true;
            ?>
            <div class="cs-fullmap"> <?php echo do_shortcode($wp_rem_cs_var_custom_map); ?> </div>
            <?php
        }
    }

}

/**
 * @subheader page 
 * setting breadcrums
 */
if ( ! function_exists('wp_rem_cs_var_breadcrumb_page_setting') ) {

    function wp_rem_cs_var_breadcrumb_page_setting() {
        global $post, $wp_query, $wp_rem_cs_var_options, $post_meta;
        $meta_element = 'wp_rem_cs_full_data';
        $wp_rem_cs_var_post_ID = get_the_ID();
        if ( function_exists('is_shop') ) {
            if ( is_shop() ) {
                $wp_rem_cs_var_post_ID = woocommerce_get_page_id('shop');
            }
        }
        $post_meta = get_post_meta((int) $wp_rem_cs_var_post_ID, "$meta_element", true);

        $wp_rem_cs_var_sub_header_style = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_sub_header_style", true);
        $wp_rem_cs_var_sub_header_sub_hdng = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_page_subheading_title", true);
        $wp_rem_cs_var_header_banner_image = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_header_banner_image", true);
        $wp_rem_cs_var_page_subheader_parallax = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_page_subheader_parallax", true);
        $wp_rem_cs_var_page_subheader_color = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_page_subheader_color", true);
        $wp_rem_cs_var_page_title_switch = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_page_title_switch", true);
        $wp_rem_cs_var_sub_header_align = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_sub_header_align", true);
        $wp_rem_cs_var_page_breadcrumbs = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_page_breadcrumbs", true);
        $wp_rem_cs_var_subheader_padding_top = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_subheader_padding_top", true);
        $wp_rem_cs_var_subheader_padding_bottom = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_subheader_padding_bottom", true);
        $wp_rem_cs_var_subheader_margin_top = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_subheader_margin_top", true);
        $wp_rem_cs_var_subheader_margin_bottom = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_subheader_margin_bottom", true);
        $wp_rem_cs_var_page_subheader_text_color = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_page_subheader_text_color", true);
        $wp_rem_cs_var_breadcrumb_bg_color = get_post_meta((int) $wp_rem_cs_var_post_ID, "wp_rem_cs_var_breadcrumb_bg_color", true);

        $wp_rem_cs_all_fields = array(
            'wp_rem_cs_var_post_ID' => $wp_rem_cs_var_post_ID,
            'wp_rem_cs_var_sub_header_style' => $wp_rem_cs_var_sub_header_style,
            'wp_rem_cs_var_sub_header_sub_hdng' => $wp_rem_cs_var_sub_header_sub_hdng,
            'wp_rem_cs_var_header_banner_image' => $wp_rem_cs_var_header_banner_image,
            'wp_rem_cs_var_page_subheader_parallax' => $wp_rem_cs_var_page_subheader_parallax,
            'wp_rem_cs_var_page_subheader_color' => $wp_rem_cs_var_page_subheader_color,
            'wp_rem_cs_var_sub_header_align' => $wp_rem_cs_var_sub_header_align,
            'wp_rem_cs_var_page_title_switch' => $wp_rem_cs_var_page_title_switch,
            'wp_rem_cs_var_page_breadcrumbs' => $wp_rem_cs_var_page_breadcrumbs,
            'wp_rem_cs_var_subheader_padding_top' => $wp_rem_cs_var_subheader_padding_top,
            'wp_rem_cs_var_subheader_padding_bottom' => $wp_rem_cs_var_subheader_padding_bottom,
            'wp_rem_cs_var_subheader_margin_top' => $wp_rem_cs_var_subheader_margin_top,
            'wp_rem_cs_var_subheader_margin_bottom' => $wp_rem_cs_var_subheader_margin_bottom,
            'wp_rem_cs_var_page_subheader_text_color' => $wp_rem_cs_var_page_subheader_text_color,
            'wp_rem_cs_var_breadcrumb_bg_color' => $wp_rem_cs_var_breadcrumb_bg_color,
        );
        wp_rem_cs_var_breadcrumb_markup($wp_rem_cs_all_fields);
    }

}

/**
 * @subheader page 
 * breadcrums settings
 */
if ( ! function_exists('wp_rem_cs_var_breadcrumb_theme_option') ) {

    function wp_rem_cs_var_breadcrumb_theme_option() {
        global $wp_rem_cs_var_options;
        $wp_rem_cs_var_post_ID = get_the_ID();
        if ( function_exists('is_shop') ) {
            if ( is_shop() ) {
                $wp_rem_cs_var_post_ID = woocommerce_get_page_id('shop');
            }
        }

        $wp_rem_cs_var_sub_header_style = isset($wp_rem_cs_var_options['wp_rem_cs_var_sub_header_style']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sub_header_style'] : '';
        $wp_rem_cs_var_sub_header_sub_hdng = isset($wp_rem_cs_var_options['wp_rem_cs_var_sub_header_sub_hdng']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sub_header_sub_hdng'] : '';
        $wp_rem_cs_var_header_banner_image = isset($wp_rem_cs_var_options['wp_rem_cs_var_sub_header_bg_img']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sub_header_bg_img'] : '';
        $wp_rem_cs_var_page_subheader_parallax = isset($wp_rem_cs_var_options['wp_rem_cs_var_sub_header_parallax']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sub_header_parallax'] : '';
        $wp_rem_cs_var_page_subheader_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_sub_header_bg_clr']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sub_header_bg_clr'] : '';
        $wp_rem_cs_var_page_title_switch = isset($wp_rem_cs_var_options['wp_rem_cs_var_page_title_switch']) ? $wp_rem_cs_var_options['wp_rem_cs_var_page_title_switch'] : '';
        $wp_rem_cs_var_sub_header_align = isset($wp_rem_cs_var_options['wp_rem_cs_var_default_sub_header_align']) ? $wp_rem_cs_var_options['wp_rem_cs_var_default_sub_header_align'] : '';
        $wp_rem_cs_var_page_breadcrumbs = isset($wp_rem_cs_var_options['wp_rem_cs_var_breadcrumbs_switch']) ? $wp_rem_cs_var_options['wp_rem_cs_var_breadcrumbs_switch'] : '';
        $wp_rem_cs_var_subheader_padding_top = isset($wp_rem_cs_var_options['wp_rem_cs_var_sh_paddingtop']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sh_paddingtop'] : '';
        $wp_rem_cs_var_subheader_padding_bottom = isset($wp_rem_cs_var_options['wp_rem_cs_var_sh_paddingbottom']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sh_paddingbottom'] : '';
        $wp_rem_cs_var_subheader_margin_top = isset($wp_rem_cs_var_options['wp_rem_cs_var_sh_margintop']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sh_margintop'] : '';
        $wp_rem_cs_var_subheader_margin_bottom = isset($wp_rem_cs_var_options['wp_rem_cs_var_sh_marginbottom']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sh_marginbottom'] : '';
        $wp_rem_cs_var_page_subheader_text_color = isset($wp_rem_cs_var_options['wp_rem_cs_var_sub_header_text_color']) ? $wp_rem_cs_var_options['wp_rem_cs_var_sub_header_text_color'] : '';
        $wp_rem_cs_var_breadcrumb_bg_clr = isset($wp_rem_cs_var_options['wp_rem_cs_var_breadcrumb_bg_clr']) ? $wp_rem_cs_var_options['wp_rem_cs_var_breadcrumb_bg_clr'] : '';

        $wp_rem_cs_all_fields = array(
            'wp_rem_cs_var_post_ID' => $wp_rem_cs_var_post_ID,
            'wp_rem_cs_var_sub_header_style' => $wp_rem_cs_var_sub_header_style,
            'wp_rem_cs_var_sub_header_sub_hdng' => $wp_rem_cs_var_sub_header_sub_hdng,
            'wp_rem_cs_var_header_banner_image' => $wp_rem_cs_var_header_banner_image,
            'wp_rem_cs_var_page_subheader_parallax' => $wp_rem_cs_var_page_subheader_parallax,
            'wp_rem_cs_var_page_subheader_color' => $wp_rem_cs_var_page_subheader_color,
            'wp_rem_cs_var_page_title_switch' => $wp_rem_cs_var_page_title_switch,
            'wp_rem_cs_var_sub_header_align' => $wp_rem_cs_var_sub_header_align,
            'wp_rem_cs_var_page_breadcrumbs' => $wp_rem_cs_var_page_breadcrumbs,
            'wp_rem_cs_var_subheader_padding_top' => $wp_rem_cs_var_subheader_padding_top,
            'wp_rem_cs_var_subheader_padding_bottom' => $wp_rem_cs_var_subheader_padding_bottom,
            'wp_rem_cs_var_subheader_margin_top' => $wp_rem_cs_var_subheader_margin_top,
            'wp_rem_cs_var_subheader_margin_bottom' => $wp_rem_cs_var_subheader_margin_bottom,
            'wp_rem_cs_var_page_subheader_text_color' => $wp_rem_cs_var_page_subheader_text_color,
            'wp_rem_cs_var_breadcrumb_bg_color' => $wp_rem_cs_var_breadcrumb_bg_clr,
        );

        $wp_rem_cs_sub_header_view = true;

        if ( $wp_rem_cs_sub_header_view == true ) {
            wp_rem_cs_var_breadcrumb_markup($wp_rem_cs_all_fields);
        }
    }

}

/**
 * @subheader styles 
 * markup
 */
if ( ! function_exists('wp_rem_cs_var_breadcrumb_markup') ) {

    function wp_rem_cs_var_breadcrumb_markup($wp_rem_cs_fields = array()) {

        extract($wp_rem_cs_fields);
        global $post;
        $wp_rem_cs_sub_style = '';
        $wp_rem_cs_var_sub_header_align = isset($wp_rem_cs_var_sub_header_align) ? $wp_rem_cs_var_sub_header_align : 'pull-left';
        if ( $wp_rem_cs_var_header_banner_image != '' ) {
            $wp_rem_cs_var_parallax_fixed = $wp_rem_cs_var_page_subheader_parallax == 'on' ? ' fixed' : '';

            $wp_rem_cs_sub_style .= ' background:url(' . wp_rem_cs_allow_special_char($wp_rem_cs_var_header_banner_image) . ') ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_page_subheader_color) . ' no-repeat' . wp_rem_cs_allow_special_char($wp_rem_cs_var_parallax_fixed) . ' ;';
            $wp_rem_cs_sub_style .= ' background-size: cover;';
        } else if ( $wp_rem_cs_var_page_subheader_color != '' ) {
            $wp_rem_cs_sub_style .= ' background:' . wp_rem_cs_allow_special_char($wp_rem_cs_var_page_subheader_color) . ' !important;';
        }
        if ( $wp_rem_cs_var_subheader_padding_top != '' ) {
            $wp_rem_cs_sub_style .= ' padding-top: ' . esc_html($wp_rem_cs_var_subheader_padding_top) . 'px !important;';
        }
        if ( $wp_rem_cs_var_subheader_padding_bottom != '' ) {
            $wp_rem_cs_sub_style .= ' padding-bottom: ' . esc_html($wp_rem_cs_var_subheader_padding_bottom) . 'px !important;';
        }
        if ( $wp_rem_cs_var_subheader_margin_top != '' ) {
            $wp_rem_cs_sub_style .= ' margin-top: ' . esc_html($wp_rem_cs_var_subheader_margin_top) . 'px !important;';
        }
        if ( $wp_rem_cs_var_subheader_margin_bottom != '' ) {
            $wp_rem_cs_sub_style .= ' margin-bottom: ' . esc_html($wp_rem_cs_var_subheader_margin_bottom) . 'px !important;';
        }

        if ( $wp_rem_cs_var_header_banner_image != '' ) {
            $wp_rem_cs_upload_dir = wp_upload_dir();
            $wp_rem_cs_upload_baseurl = isset($wp_rem_cs_upload_dir['baseurl']) ? $wp_rem_cs_upload_dir['baseurl'] . '/' : '';

            $wp_rem_cs_upload_dir = isset($wp_rem_cs_upload_dir['basedir']) ? $wp_rem_cs_upload_dir['basedir'] . '/' : '';

            if ( false !== strpos($wp_rem_cs_var_header_banner_image, $wp_rem_cs_upload_baseurl) ) {
                $wp_rem_cs_upload_subdir_file = str_replace($wp_rem_cs_upload_baseurl, '', $wp_rem_cs_var_header_banner_image);
            }

            $wp_rem_cs_images_dir = trailingslashit(get_template_directory()) . 'assets/frontend/images/';

            $wp_rem_cs_img_name = preg_replace('/^.+[\\\\\\/]/', '', $wp_rem_cs_var_header_banner_image);

            if ( is_file($wp_rem_cs_upload_dir . $wp_rem_cs_img_name) || is_file($wp_rem_cs_images_dir . $wp_rem_cs_img_name) ) {
                if ( ini_get('allow_url_fopen') ) {
                    $wp_rem_cs_var_header_image_height = getimagesize($wp_rem_cs_var_header_banner_image);
                }
            } else if ( isset($wp_rem_cs_upload_subdir_file) && is_file($wp_rem_cs_upload_dir . $wp_rem_cs_upload_subdir_file) ) {
                if ( ini_get('allow_url_fopen') ) {
                    $wp_rem_cs_var_header_image_height = getimagesize($wp_rem_cs_var_header_banner_image);
                }
            } else {
                $wp_rem_cs_var_header_image_height = '';
            }

            if ( isset($wp_rem_cs_var_header_image_height[1]) && $wp_rem_cs_var_header_image_height != '' ) {
                $wp_rem_cs_var_header_image_height = $wp_rem_cs_var_header_image_height[1] . 'px';
                $wp_rem_cs_sub_style .= ' height: ' . wp_rem_cs_allow_special_char($wp_rem_cs_var_header_image_height) . ' !important;';
            }
        }
        $post_type = '';
        if ( ! is_author() && ! is_404() ) {
            if ( $post ) {
                $post_type = get_post_type($post->ID);
            }
        }
        if ( $wp_rem_cs_var_sub_header_align == '' ) {
            $wp_rem_cs_var_sub_header_align = 'pull-left';
        }

        $sub_header_align = '';
        if ( $wp_rem_cs_var_sub_header_align == 'center' ) {
            $sub_header_align = ' align-center';
        } elseif ( $wp_rem_cs_var_sub_header_align == 'right' ) {
            $sub_header_align = ' align-right';
        } elseif ( $wp_rem_cs_var_sub_header_align == 'left' ) {
            $sub_header_align = ' align-left';
        } elseif ( $wp_rem_cs_var_sub_header_align == 'bottom' ) {
            $sub_header_align = ' align-left';
        }
        $post_type = '';
        $post_type = get_post_type();
        if ( ( ! is_404()) && ($post_type <> 'properties') ) {

            $col_class = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
            if ( $wp_rem_cs_var_sub_header_align == 'bottom' ) {
                $col_class = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
            }
            ?>
            <div class="sub-header <?php echo sanitize_html_class($sub_header_align); ?>"<?php if ( $wp_rem_cs_sub_style != '' ) { ?> style="<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_sub_style) ?>"<?php } ?>>
                <div class="container">
                    <div class="row">
                        <div class="<?php echo esc_html($col_class); ?>">
                            <div class="text-holder">
                                <?php
                                if ( $post_type <> 'properties' ) {
                                    if ( $wp_rem_cs_var_page_title_switch == "on" ) {
                                        ?>
                                        <div  class="page-title">
                                            <h1<?php if ( $wp_rem_cs_var_page_subheader_text_color != '' ) { ?> style="color:<?php echo esc_html($wp_rem_cs_var_page_subheader_text_color); ?> !important;"<?php } ?>><?php wp_rem_cs_post_page_title(); ?></h1>

                                        </div>
                                        <?php
                                    }
                                    if ( isset($wp_rem_cs_var_sub_header_sub_hdng) && ! empty($wp_rem_cs_var_sub_header_sub_hdng) ) {
                                        echo '<p>' . esc_html($wp_rem_cs_var_sub_header_sub_hdng) . '</p>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <?php if ( $wp_rem_cs_var_sub_header_align != 'bottom' ) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <?php
                                if ( $wp_rem_cs_var_page_breadcrumbs == "on" ) {
                                    wp_rem_cs_breadcrumbs();
                                }
                                ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if ( $wp_rem_cs_var_sub_header_align == 'bottom' ) { ?>
                <div class="sub-header <?php echo sanitize_html_class($sub_header_align); ?>"<?php if ( $wp_rem_cs_var_breadcrumb_bg_color != '' ) { ?> style="background:<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_breadcrumb_bg_color) ?>"<?php } ?>>
                    <div class="breadcrumbs">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <?php
                                    if ( $wp_rem_cs_var_page_breadcrumbs == "on" ) {
                                        wp_rem_cs_breadcrumbs();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php
        }
    }

}