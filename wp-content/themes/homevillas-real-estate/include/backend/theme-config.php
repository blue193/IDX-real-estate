<?php
/**
 * Defines configurations for Theme, Framework Plugin and rating plugin
 *
 * @since	1.0
 * @package	WordPress
 */
/*
 * THEME_ENVATO_ID contains theme unique id at envator
 */
if ( ! defined( 'THEME_ENVATO_ID' ) ) {
    define( 'THEME_ENVATO_ID', '19446059' );
}

/*
 * THEME_NAME contains the name of the current theme
 */
if ( ! defined( 'THEME_NAME' ) ) {
    define( 'THEME_NAME', 'homevillas-real-estate');
}

/*
 * THEME_TEXT_DOMAIN contains the text domain name used for this theme
 */
if ( ! defined( 'THEME_TEXT_DOMAIN' ) ) {
    define( 'THEME_TEXT_DOMAIN', 'homevillas-real-estate');
}

/*
 * THEME_OPTIONS_PAGE_SLUG contains theme optinos main page slug
 */
if ( ! defined( 'THEME_OPTIONS_PAGE_SLUG' ) ) {
    define( 'THEME_OPTIONS_PAGE_SLUG', 'wp_rem_settings_page' );
}

/*
 * CS_WP_REM_STABLE_VERSION contains rem stable version compitble with this theme version
 */
if ( ! defined( 'CS_WP_REM_REALESTATE_STABLE_VERSION' ) ) {
    define( 'CS_WP_REM_REALESTATE_STABLE_VERSION', '1.0' );
}

/*
 * CS_FRAMEWORK_STABLE_VERSION contains cs framework stable version compitble with this theme version
 */
if ( ! defined( 'CS_WP_REM_CS_FRAMEWORK_STABLE_VERSION' ) ) {
    define( 'CS_WP_REM_CS_FRAMEWORK_STABLE_VERSION', '1.0' );
}

/*
 * CS_BASE contains the root server path of the framework that is loaded
 */
if ( ! defined( 'CS_BASE' ) ) {
    define( 'CS_BASE', get_template_directory() . '/' );
}

/*
 * CS_BASE_URL contains the http url of the framework that is loaded
 */
if ( ! defined( 'CS_BASE_URL' ) ) {
    define( 'CS_BASE_URL', get_template_directory_uri() . '/' );
}

/*
 * DEFAULT_DEMO_DATA_NAME contains the default demo data name used by CS importer
 */
if ( ! defined( 'DEFAULT_DEMO_DATA_NAME' ) ) {
    define( 'DEFAULT_DEMO_DATA_NAME', 'homevillas-real-estate');
}

/*
 * DEFAULT_DEMO_DATA_URL contains the default demo data url used by CS importer
 */
if ( ! defined( 'DEFAULT_DEMO_DATA_URL' ) ) {
    define( 'DEFAULT_DEMO_DATA_URL', 'http://homevillas.chimpgroup.com/wp-content/uploads/' );
}

/*
 * DEMO_DATA_URL contains the demo data url used by CS importer
 */
if ( ! defined( 'DEMO_DATA_URL' ) ) {
    define( 'DEMO_DATA_URL', 'http://homevillas.chimpgroup.com/{{{demo_data_name}}}/wp-content/uploads/' );
}

/*
 * REMOTE_API_URL contains the api url used for envator purchase key verification
 */
if ( ! defined( 'REMOTE_API_URL' ) ) {
    define( 'REMOTE_API_URL', 'http://chimpgroup.com/wp-demo/webservice/' );
}

/*
 * ATTACHMENTS_REPLACE_URL contains the URL to be replaced in WP content XML attachments
 */
if ( ! defined( 'ATTACHMENTS_REPLACE_URL' ) ) {
    define( 'ATTACHMENTS_REPLACE_URL', 'http://homevillas.chimpgroup.com/wp-content/uploads/' );
}

/*
 * Theme Backup Wp_rem_cs Path
 */
if ( ! defined( 'AUTO_UPGRADE_BACKUP_DIR' ) ) {
    define( 'AUTO_UPGRADE_BACKUP_DIR', WP_CONTENT_DIR . '/' . THEME_NAME . '-backups/' );
}

if ( ! function_exists( 'get_demo_data_structure' ) ) {

    /**
     * Return Demo datas available
     *
     * @return	array	details of demo datas available
     */
    function get_demo_data_structure() {
        $demo_data_structure = array(
            'homevillas-real-estate' => array(
                'slug' => 'homevillas-real-estate',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo1_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homevillas-real-estate.jpg',
            ),
			'homev2' => array(
                'slug' => 'homev2',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo2_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev2.jpg',
            ),
			'homev3' => array(
                'slug' => 'homev3',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo3_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev3.jpg',
            ),
			'homev4' => array(
                'slug' => 'homev4',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo4_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev4.jpg',
            ),
			'homev5' => array(
                'slug' => 'homev5',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo5_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev5.jpg',
            ),
			'homev6' => array(
                'slug' => 'homev6',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo6_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev6.jpg',
            ),
			'homev7' => array(
                'slug' => 'homev7',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo7_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev7.jpg',
            ),
			'homev8' => array(
                'slug' => 'homev8',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo8_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev8.jpg',
            ),
			'homev9' => array(
                'slug' => 'homev9',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo9_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev9.jpg',
            ),
			'homev10' => array(
                'slug' => 'homev10',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo10_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev10.jpg',
            ),
			'homev11' => array(
                'slug' => 'homev11',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo11_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev11.jpg',
            ),
			'homev12' => array(
                'slug' => 'homev12',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo12_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev12.jpg',
            ),
			'homev13' => array(
                'slug' => 'homev13',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo13_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev13.jpg',
            ),
			'homev14' => array(
                'slug' => 'homev14',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo14_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev14.jpg',
            ),
			'homev15' => array(
                'slug' => 'homev15',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo15_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev15.jpg',
            ),
			'homev16' => array(
                'slug' => 'homev16',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_demo16_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/homev16.jpg',
            ),
			'rtl' => array(
                'slug' => 'rtl',
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_rtl_label'),
                'image_url' => 'http://chimpgroup.com/wp-demo/webservice/demo_images/homevillas-real-estate/rtl.jpg',
            )
			
        );
        return $demo_data_structure;
    }

}

if ( ! function_exists( 'get_server_requirements' ) ) {

    /**
     * Return server requirements for importer
     *
     * @return	array	server resources requirements for importer
     */
    function get_server_requirements() {
		$post_max_size = ini_get( 'post_max_size' );
        $upload_max_filesize = ini_get( 'upload_max_filesize' );
        $memory_limit = ini_get( 'memory_limit' );
        $recommended_php_version = '5.5.0';
        $recommended_post_max_size = 256;
        $recommended_post_max_size_unit = 'M';
        $recommended_upload_max_filesize = 256;
        $recommended_upload_max_filesize_unit = 'M';
        $recommended_memory_limit = 256;
        $recommended_memory_limit_unit = 'M';
		
        $server_requirements = array(
			array(
                'title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_min_php_version').' = ' . $recommended_php_version . ' ( '. wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_available') .' ' . phpversion() . ' )',
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_min_php_version_desc'),
                'version' => '',
                'is_met' => ( version_compare( phpversion(), $recommended_php_version, '>' ) ),
            ),
            array(
                'title' => 'POST_MAX_SIZE = ' . $recommended_post_max_size . $recommended_post_max_size_unit . ' ( '. wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_available') .' ' . $post_max_size . ' )',
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_max_data'),
                'version' => '',
                'is_met' => ( $recommended_post_max_size <= $post_max_size ),
            ),
            array(
                'title' => 'UPLOAD_MAX_FILESIZE = ' . $recommended_upload_max_filesize . $recommended_upload_max_filesize_unit . ' ( '. wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_available') .' ' . $upload_max_filesize . ' )',
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_max_file_size'),
                'version' => '',
                'is_met' => ( $recommended_upload_max_filesize <= $upload_max_filesize ),
            ),
            array(
                'title' => 'MEMORY_LIMIT = ' . $recommended_memory_limit . $recommended_memory_limit_unit . ' ( '. wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_available') .' ' . $memory_limit . ' )',
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_max_amount_memory'),
                'version' => '',
                'is_met' => ( $recommended_memory_limit <= $memory_limit ),
            ),
			array(
                'title' => 'allow_url_fopen '. wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_should_be_enabled') .' php.ini',
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_download_import_data'),
                'version' => '',
                'is_met' => ini_get( 'allow_url_fopen' ),
            ),
        );
        return $server_requirements;
    }

}

if ( ! function_exists( 'get_plugin_requirements' ) ) {

    /**
     * Return plugin requirements for importer
     *
     * @return array plugin requirements for importer
     */
    function get_plugin_requirements() {
        // Default compatible plugin versions.
        $compatible_plugin_versions = array(
            'wp_rem_real_estate_framework' => CS_WP_REM_CS_FRAMEWORK_STABLE_VERSION,
            'wp_rem_wp_realestate_manager' => CS_WP_REM_REALESTATE_STABLE_VERSION,
        );
        // Check if there is a need to prompt user to install theme.
        $is_cs_wp_rem_real_estate_framework = class_exists( 'wp_rem_real_estate_framework' );
        $current_version_cs_wp_rem_real_estate_framework = '0.0';
        $have_new_version_cs_wp_rem_real_estate_framework = false;
        if ( $is_cs_wp_rem_real_estate_framework ) {
            $current_version_cs_wp_rem_real_estate_framework = wp_rem_real_estate_framework::get_plugin_version();
            $new_version_cs_wp_rem_real_estate_framework = $compatible_plugin_versions['wp_rem_real_estate_framework'];
            if ( version_compare( $current_version_cs_wp_rem_real_estate_framework, $new_version_cs_wp_rem_real_estate_framework ) < 0 ) {
                $is_cs_wp_rem_real_estate_framework = false;
                $have_new_version_cs_wp_rem_real_estate_framework = true;
            }
        }
        // Check if there is a need to prompt user to install theme.
        $is_wp_realestate_manager = class_exists( 'wp_rem' );
        $current_version_wp_rem_wp_realestate_manager = '0.0';
        $have_new_version_wp_realestate_manager = false;
        if ( $is_wp_realestate_manager ) {
            $current_version_wp_rem_wp_realestate_manager = wp_rem::get_plugin_version();
            $new_version_wp_realestate_manager = $compatible_plugin_versions['wp_rem_wp_realestate_manager'];
            if ( version_compare( $current_version_wp_rem_wp_realestate_manager, $new_version_wp_realestate_manager ) < 0 ) {
                $is_wp_realestate_manager = false;
                $have_new_version_wp_realestate_manager = true;
            }
        }
        // Check if there is a need to prompt user to install theme.
        $is_rev_slider = class_exists( 'RevSlider' );
        $have_new_version_rev_slider = false;
		$current_version_rev_slider = '0.0';
        if ( $is_rev_slider ) {
            $current_version_rev_slider = RevSliderGlobals::SLIDER_REVISION;
            $new_version_rev_slider = get_option( 'revslider-latest-version', RevSliderGlobals::SLIDER_REVISION );
            if ( empty( $new_version_rev_slider ) ) {
                $new_version_rev_slider = '5.2.5';
            }

            if ( version_compare( $current_version_rev_slider, $new_version_rev_slider ) < 0 ) {
                $is_rev_slider = false;
                $have_new_version_rev_slider = true;
            }
        }
        $plugin_requirements = array(
			'wp_rem_wp_realestate_manager' => array(
                'title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_realestate_manager_title'),
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_realestate_manager_desc'),
                'version' => $current_version_wp_rem_wp_realestate_manager,
                'new_version' => ( true == $have_new_version_wp_realestate_manager ) ? $new_version_wp_realestate_manager : '',
                'is_installed' => $is_wp_realestate_manager,
            ),
            'wp_rem_real_estate_framework' => array(
                'title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_framework_title'),
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_framework_desc'),
                'version' => $current_version_cs_wp_rem_real_estate_framework,
                'new_version' => ( true == $have_new_version_cs_wp_rem_real_estate_framework ) ? $new_version_cs_wp_rem_real_estate_framework : '',
                'is_installed' => $is_cs_wp_rem_real_estate_framework,
            ),
			'rev_slider' => array(
                'title' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_rev_slider_title'),
                'description' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_rev_slider_desc'),
                'version' => $current_version_rev_slider,
                'new_version' => ( true == $have_new_version_rev_slider ) ? $new_version_rev_slider : '',
                'is_installed' => $is_rev_slider,
            ),
        );
        return $plugin_requirements;
    }

}

if ( ! function_exists( 'get_mandaory_plugins' ) ) {

    /**
     * Give a list of the plugins pluings need to be updated (used Auto Theme Upgrader)
     *
     * @return	array	a list of plugins which will be updated on Auto Theme update
     */
    function get_plugins_to_be_updated() {
        return array(
            array(
                'name' => wp_rem_cs_var_theme_text_srt('wp_rem_cs_var_config_framework_title'),
                'slug' => 'real-estate-framework',
                'source' => trailingslashit( get_template_directory_uri() ) . 'include/backend/cs-activation-plugins/real-estate-framework.zip',
                'required' => true,
                'version' => '',
                'force_activation' => true,
                'force_deactivation' => true,
                'external_url' => '',
            ),
        );
    }

}