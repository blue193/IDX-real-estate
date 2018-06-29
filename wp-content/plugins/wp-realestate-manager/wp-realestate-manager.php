<?php
/*
  Plugin Name: WP Real Estate Manager
  Plugin URI: http://themeforest.net/user/Chimpstudio/
  Description: WP Real Estate Manager
  Version: 1.3
  Author: ChimpStudio
  Text Domain: wp-rem
  Author URI: http://themeforest.net/user/Chimpstudio/
  License: GPL2
  Copyright 2015  chimpgroup  (email : info@chimpstudio.co.uk)
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.
  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, United Kingdom
 */
if (!class_exists('wp_rem')) {

    class wp_rem {

        public $plugin_url;
        public $plugin_dir;

        /**
         * Start Function of Construct
         */
        public function __construct() {

            add_action('init', array($this, 'load_plugin_textdomain'), 0);
            remove_filter('pre_user_description', 'wp_filter_kses');
            add_filter('pre_user_description', 'wp_filter_post_kses');
            // Add optinos in Email Template Settings
            add_filter('wp_rem_email_template_settings', array($this, 'email_template_settings_callback'), 0, 1);
            add_filter('wp_rem_get_plugin_options', array($this, 'wp_rem_get_plugin_options_callback'), 0, 1);
            add_action('admin_menu', array($this, 'admin_menu_position'));
            add_action('wp_footer', array($this, 'wp_rem_loader'));
            add_action('admin_footer', array($this, 'wp_rem_admin_footer_modal'));
            $this->define_constants();
            $this->includes();
            add_action('admin_head', array($this, 'hide_update_notice_for_wp_rem_pages'), 11);
        }

        /**
         * Start Function how to Create WC Contants
         */
        private function define_constants() {

            global $post, $wp_query, $wp_rem_plugin_options, $current_user, $wp_rem_jh_scodes, $plugin_user_images_wp_rem;
            $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
            $this->plugin_url = plugin_dir_url(__FILE__);
            $this->plugin_dir = plugin_dir_path(__FILE__);
            $plugin_user_images_wp_rem = 'wp-rem-users';
        }

        /**
         * What type of request is this?
         * string $type ajax, frontend or admin
         * @return bool
         */
        /*
         * remove admin notices
         */
        public function hide_update_notice_for_wp_rem_pages() {
            $screen = get_current_screen();
            $post_type_screen = isset($screen->post_type) ? $screen->post_type : '';
            $argss = array(
                'public' => true,
                '_builtin' => false
            );
            $output = 'names'; // names or objects, note names is the default
            $operator = 'and';
            $all_custom_post_types = get_post_types($argss, $output, $operator);

            if ($post_type_screen != '' && in_array($post_type_screen, $all_custom_post_types)) {
                global $wp_filter;
                remove_action('admin_notices', 'update_nag', 3);
                unset($wp_filter['user_admin_notices']);
                unset($wp_filter['admin_notices']);
            }
        }

        public function is_request($type) {
            switch ($type) {
                case 'admin' :
                    return is_admin();
                    break;
                case 'ajax' :
                    return defined('DOING_AJAX');
                case 'cron' :
                    return defined('DOING_CRON');
                case 'frontend' :
                    return (!is_admin() || defined('DOING_AJAX') ) && !defined('DOING_CRON');
            }
        }

        /*
         * WP Real Estate Manager Error Messages Popup in Footer for admin
         *
         */

        public function wp_rem_admin_footer_modal() {
            echo '<div class="wp-rem-error-messages" style="display:none;"></div>';
        }

        /**
         * WP Real Estate Manager Loader in Footer
         */
        public function wp_rem_loader() {
            echo '<div class="wp_rem_loader" style="display: none;">';
            echo '<div class="loader-img"><i class="icon-spinner"></i></div></div>';
            echo '<div class="wp-rem-button-loader spinner">
                                    <div class="bounce1"></div>
                                      <div class="bounce2"></div>
                                      <div class="bounce3"></div>
                                  </div>';
            if (is_user_logged_in()) {
                if (!wp_rem::is_demo_user_modification_allowed()) :
                    ?>
                    <script type="text/javascript">
                        var pageInitialized = false;
                        (function ($) {
                            $(document).ready(function () {
                                bind_rest_auth_event();
                                $("body").on("DOMNodeInserted DOMNodeRemoved", bind_rest_auth_event);
                                if (pageInitialized)
                                    return;
                                jQuery.growl.error({
                                    message: '<?php echo wp_rem_plugin_text_srt('wp_rem_demo_user_not_allowed_to_modify'); ?>'
                                });
                                pageInitialized = true;
                            });

                            function bind_rest_auth_event() {
                                $("input[type='submit'], .btn-submit, .btn-send, .delete-this-user-review, .delete-shortlist, .remove_member, #team_update_form, .wp-rem-dev-property-delete, .discussion-submit").off("click");
                                $(document).off("click", "input[type='submit'], .btn-submit, .btn-send, .delete-this-user-review, .delete-shortlist, .remove_member, #team_update_form, .wp-rem-dev-property-delete, .discussion-submit");
                                $("body").off("click", "input[type='submit'], .btn-submit, .btn-send, .delete-this-user-review, .delete-shortlist, .remove_member, #team_update_form, .wp-rem-dev-property-delete, .discussion-submit");
                                $("body").on("click", "input[type='submit'], .btn-submit, .btn-send, .delete-this-user-review, .delete-shortlist, .remove_member, #team_update_form, .wp-rem-dev-property-delete, .discussion-submit", function (e) {
                                    e.stopPropagation();
                                    e.stopImmediatePropagation();
                                    jQuery.growl.error({
                                        message: '<?php echo wp_rem_plugin_text_srt('wp_rem_demo_user_not_allowed_to_modify'); ?>'
                                    });
                                    return false;
                                });
                            }
                        })(jQuery);
                    </script>
                    <?php
                endif;
            }
        }

        public static function is_demo_user_modification_allowed() {
            global $wp_rem_plugin_options, $post;
            $current_page = isset($post->ID) ? $post->ID : '';
            $create_property_page = isset($wp_rem_plugin_options['wp_rem_create_property_page']) ? $wp_rem_plugin_options['wp_rem_create_property_page'] : '';
            if ('member-dashboard.php' === wp_rem_get_current_template() || '' === wp_rem_get_current_template() || $current_page == $create_property_page) {
                $wp_rem_demo_user_login_switch = isset($wp_rem_plugin_options['wp_rem_demo_user_login_switch']) ? $wp_rem_plugin_options['wp_rem_demo_user_login_switch'] : '';
                if ($wp_rem_demo_user_login_switch == 'on') {
                    $wp_rem_wp_rem_demo_user_member = isset($wp_rem_plugin_options['wp_rem_demo_user_member']) ? $wp_rem_plugin_options['wp_rem_demo_user_member'] : '';
                    $wp_rem_wp_rem_demo_user_agency = isset($wp_rem_plugin_options['wp_rem_demo_user_agency']) ? $wp_rem_plugin_options['wp_rem_demo_user_agency'] : '';
                    $current_user_id = get_current_user_id();
                    if ($wp_rem_wp_rem_demo_user_member == $current_user_id || $wp_rem_wp_rem_demo_user_agency == $current_user_id) {
                        if (isset($wp_rem_plugin_options['wp_rem_demo_user_modification_allowed_switch']) && $wp_rem_plugin_options['wp_rem_demo_user_modification_allowed_switch'] == 'off') {
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        /**
         * Start Function how to add core files used in admin and theme
         */
        public function includes() {

            //require_once 'include/core-functions.php';

            /*
             * Email Templates.
             */
            require_once 'backend/classes/email-templates/class-register-template.php';
            require_once 'backend/classes/email-templates/class-reset-password-template.php';
            require_once 'backend/classes/email-templates/class-change-password-template.php';

            require_once 'backend/classes/email-templates/class-property-add-template.php';
            require_once 'backend/classes/email-templates/class-new-member-notification-site-owner-template.php';
            require_once 'backend/classes/email-templates/class-property-update-email-template.php';
            require_once 'backend/classes/email-templates/class-property-approved-email-template.php';
            require_once 'backend/classes/email-templates/class-property-not-approved-email-template.php';
            require_once 'backend/classes/email-templates/class-property-pending-email-template.php';
            require_once 'backend/classes/email-templates/class-approved-member-profile-template.php';
            require_once 'backend/classes/email-templates/class-not-approved-member-profile-template.php';
            require_once 'backend/classes/email-templates/class-property-expired-template.php';
            require_once 'backend/classes/email-templates/class-received-enquiry-template.php';
            require_once 'backend/classes/email-templates/class-received-arrange-viewing-template.php';
            require_once 'backend/classes/email-templates/class-add-member-template.php';

            require_once 'backend/classes/email-templates/orders-inquiries/class-update-viewing-status-template.php';
            /*
             * croppic
             */
            require_once 'frontend/classes/class-image-cropper.php';
            require_once 'frontend/classes/class-radius-check.php';
            /*
             * Include admin files
             */

            /*
             * Form Fields Class
             */
            require_once 'backend/classes/form-fields/class-form-fields.php';
            require_once 'backend/classes/form-fields/class-html-fields.php';
            /*
             * Form Fields Classes Frontend
             */
            require_once 'frontend/classes/form-fields/class-form-fields.php';
            require_once 'frontend/classes/form-fields/class-html-fields.php';

            /*
             * Payment Gateways Files
             */
            require_once 'payments/class-payments.php';
            require_once 'payments/custom-wooc-hooks.php';
            require_once 'payments/config.php';

            // importer hooks
            require_once 'backend/include/importer-hooks.php';

            /*
             * Email Class
             */
            require_once 'backend/classes/class-email.php';

            require_once 'backend/post-types/properties/properties.php';
            require_once 'backend/post-types/comments/comments.php';
            /*
             * Strings Class
             */
            require_once 'assets/common/translate/class-strings-1.php';
            require_once 'assets/common/translate/class-strings-2.php';
            require_once 'assets/common/translate/class-strings-3.php';
            require_once 'assets/common/translate/class-strings-4.php';

            /*
             * Helpers Classes
             */
            require_once 'helpers/helpers-notification.php';
            require_once 'helpers/helpers-general.php';

            /*
             * Shortcode File
             * Other files are being added into this file.
             */
            // for login
            require_once 'elements/login/login-functions.php';
            require_once 'elements/login/login-forms.php';
            require_once 'elements/login/cs-social-login/cs-social-login.php';
            require_once 'elements/login/cs-social-login/google/cs_google_connect.php';
            // linkedin login
            // recaptchas
            require_once 'elements/login/recaptcha/autoload.php';

            require_once 'shortcodes/backend/class-parent-shortcode.php';
            require_once 'shortcodes/class-shortcodes.php';

            // property add shortcde files
            require_once 'shortcodes/backend/wp-rem-add-property.php';
            require_once 'shortcodes/frontend/wp-rem-add-property.php';
            /*
             * shortcodes
             */
            // banners shortcode
            require_once 'shortcodes/frontend/shortcode-banner-ads.php';

            // map search
            require_once 'shortcodes/backend/shortcode-map-search.php';
            require_once 'shortcodes/frontend/shortcode-map-search.php';

            /*
             * Compare Properties
             */
            require_once 'frontend/templates/compare/class-compare-property.php';

            /*
             * social sharing Class
             */
            require_once 'frontend/classes/class-social-sharing.php';
            /*
             * social sharing Class
             */

            /*
             * Search Fields Class
             */
            require_once 'frontend/classes/class-search-fields.php';

            /*
             * Order/Inquiry Detail Class
             */
            require_once 'frontend/classes/class-enquiry-detail.php';

            /*
             * Arrange Viewing Detail Class
             */
            require_once 'frontend/classes/class-arrange-viewing-detail.php';

            /*
             * pagination sharing Class
             */
            require_once 'frontend/classes/class-pagination.php';

            /*
             * Member Account Pages
             */
            require_once 'frontend/templates/dashboards/class-dashboards.php';
            require_once 'frontend/templates/dashboards/member/member-add-property.php';

            require_once 'frontend/templates/payment-process-center.php';

            /*
             * Member Account Pages
             */
            require_once 'frontend/templates/dashboards/member/member-properties.php';
            require_once 'frontend/templates/dashboards/member/member-profile.php';
            require_once 'frontend/templates/dashboards/member/member-company.php';
            require_once 'frontend/templates/dashboards/member/member-packages.php';
            require_once 'frontend/templates/dashboards/member/member-property-enquires.php';
            require_once 'frontend/templates/dashboards/member/member-arrange-viewings.php';
            require_once 'frontend/templates/dashboards/member/member-suggested.php';
            require_once 'frontend/templates/dashboards/member/member-branches.php';

            /*
             * properties Post type classes for fields
             */
            require_once 'backend/post-types/class-save-post-options.php';
            require_once 'backend/post-types/properties/classes/class-properties-opening-hours.php';
            require_once 'backend/post-types/properties/classes/class-properties-posted-by.php';
            require_once 'backend/post-types/properties/classes/class-properties-images-gallery.php';
            require_once 'backend/post-types/properties/classes/class-properties-floor-plan.php';
            require_once 'backend/post-types/properties/classes/class-properties-attachments.php';
            require_once 'backend/post-types/properties/classes/class-properties-apartments.php';
            require_once 'backend/post-types/properties/classes/class-properties-page-elements.php';
            require_once 'backend/post-types/properties/properties-meta.php';
            require_once 'backend/post-types/properties/property-taxonomy-mata.php';

            /*
             * property-type Post type classes for fields
             */
            require_once 'backend/post-types/property-type/property-type.php';
            require_once 'backend/post-types/property-type/property-type-fields.php';
            require_once 'backend/post-types/property-type/property-type-meta.php';
            require_once 'backend/post-types/property-type/classes/class-property-type-categories.php';


            /*
             * members Post type classes for fields
             */

            require_once 'backend/post-types/members/members.php';
            require_once 'backend/post-types/members/members-meta.php';

            /*
             * Packages Post type classes for fields
             * @Used as hooks
             */
            require_once 'backend/post-types/packages/packages.php';
            require_once 'backend/post-types/packages/packages-meta.php';

            require_once 'backend/post-types/transactions/transactions.php';
            require_once 'backend/post-types/transactions/transactions-meta.php';

            // Branches Post Type
            require_once 'backend/post-types/branches/branches.php';
            require_once 'backend/post-types/branches/branches-meta.php';

            /*
             * Property Enquires Post type classes for fields
             * @Used as hooks
             */
            require_once 'backend/post-types/property-enquiries/property-enquiries.php';
            require_once 'backend/post-types/property-enquiries/property-enquiries-meta.php';

            /*
             * Property Viewings Post type classes for fields
             * @Used as hooks
             */
            require_once 'backend/post-types/arrange-viewings/arrange-viewings.php';
            require_once 'backend/post-types/arrange-viewings/arrange-viewings-meta.php';

            /*
             * Price Table Post type classes for fields
             * @Files
             */
            require_once 'backend/post-types/price-tables/price-table.php';
            require_once 'backend/post-types/price-tables/price-table-meta.php';

            /*
             * Form Fields Classes
             */
            require_once 'backend/classes/form-fields/class-form-fields.php';
            require_once 'backend/classes/form-fields/class-html-fields.php';

            require_once 'frontend/templates/functions.php';

            /*
             * User Meta
             */
            require_once 'backend/include/user-meta/meta.php';


            /*
             * Plugin Settings Classes
             */

            require_once 'backend/settings/plugin-settings.php';
            require_once 'backend/settings/includes/plugin-options.php';
            require_once 'backend/settings/includes/plugin-options-fields.php';
            require_once 'backend/settings/includes/plugin-options-functions.php';
            require_once 'backend/settings/includes/plugin-options-array.php';
            require_once 'backend/settings/user-import/import.php';

            /*
             * Transactions Files
             */
            require_once 'backend/post-types/package-orders/package-orders.php';
            require_once 'backend/post-types/package-orders/package-orders-meta.php';

            /*
             * Include frontend files
             */

            /*
             * Property Page Elements Classes
             */
            require_once 'frontend/classes/page-elements/class-sub-navbar.php';
            require_once 'frontend/classes/page-elements/class-features-element.php';
            require_once 'frontend/classes/page-elements/class-opening-hours-element.php';
            require_once 'frontend/classes/page-elements/class-images-gallery-element.php';
            require_once 'frontend/classes/page-elements/class-contact-element.php';
            require_once 'frontend/classes/page-elements/class-discussion-element.php';
            require_once 'frontend/classes/page-elements/class-custom-fields-element.php';
            require_once 'frontend/classes/page-elements/class-enquire-arrange-buttons.php';
            require_once 'frontend/classes/page-elements/class-payment-calculator-element.php';
            require_once 'frontend/classes/page-elements/class-author-info-element.php';
            require_once 'frontend/classes/page-elements/class-sidebar-gallery-element.php';
            require_once 'frontend/classes/page-elements/class-sidebar-map-element.php';
            require_once 'frontend/classes/page-elements/class-yelp-results.php';
            require_once 'frontend/classes/page-elements/class-attachments-element.php';
            require_once 'frontend/classes/page-elements/class-nearby-properties.php';

            /*
             * Member Permissions
             */
            require_once 'frontend/classes/class-member-permissions.php';

            /*
             * Location Manager
             */
            require_once 'frontend/classes/class-locations-manager.php';

            /*
             * Reviews Manager
             */
            //require_once 'frontend/classes/class-reviews-manager.php';

            /*
             * widgets
             */
            require_once 'backend/widgets/wp-rem-locations.php';
            require_once 'backend/widgets/wp-rem-banners.php';
            require_once 'backend/widgets/wp-rem-top-properties.php';
            require_once 'backend/widgets/wp-rem-top-member.php';
            /*
             * Member Account Pages
             */


            /*
             * google cpathca
             */
            require_once 'frontend/classes/class-google-captcha.php';



            /*
             * Currencies Class
             */

            require_once 'backend/classes/class-currencies.php';
            /*
             * Including Modules files
             */
            $this->register_modules();


            add_filter('template_include', array($this, 'wp_rem_single_template'));
            add_action('admin_enqueue_scripts', array($this, 'wp_rem_defaultfiles_plugin_enqueue'), 2);
            add_action('admin_enqueue_scripts', array($this, 'wp_rem_enqueue_admin_style_sheet'), 90);
            add_action('wp_enqueue_scripts', array($this, 'wp_rem_defaultfiles_plugin_enqueue'), 2);
            add_action('wp_enqueue_scripts', array($this, 'wp_rem_enqueue_responsive_front_scripts'), 3);


            add_action('admin_init', array($this, 'wp_rem_all_scodes'));
            add_filter('body_class', array($this, 'wp_rem_boby_class_names'));
        }

        /**
         * Start Function how to add Specific CSS Classes by filter
         */
        function wp_rem_boby_class_names($classes) {
            $classes[] = 'wp-rem';
            return $classes;
        }

        /**
         * Start Function how position admin menu
         */
        public function admin_menu_position() {
            global $menu, $submenu;
            foreach ($menu as $key => $menu_item) {
                if (isset($menu_item[2]) && $menu_item[2] == 'edit.php?post_type=properties') {
                    $menu[$key][0] = wp_rem_plugin_text_srt('wp_rem_rem_wp');
                }
            }
        }

        /**
         * Start Function how to access admin panel
         */
        public function prevent_admin_access() {
            if (is_user_logged_in()) {

                if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin') !== false && (current_user_can('wp_rem_member'))) {
                    wp_redirect(get_option('siteurl'));
                    add_filter('show_admin_bar', '__return_false');
                }
            }
        }

        /**
         * Start Function how to Add textdomain for translation
         */
        public function load_plugin_textdomain() {
            global $wp_rem_plugin_options;


            if (function_exists('icl_object_id')) {

                global $sitepress, $wp_filesystem;

                require_once ABSPATH . '/wp-admin/includes/file.php';

                $backup_url = '';

                if (false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) )) {

                    return true;
                }

                if (!WP_Filesystem($creds)) {
                    request_filesystem_credentials($backup_url, '', true, false, array());
                    return true;
                }

                $wp_rem_languages_dir = plugin_dir_path(__FILE__) . 'languages/';

                $wp_rem_all_langs = $wp_filesystem->dirlist($wp_rem_languages_dir);

                $wp_rem_mo_files = array();
                if (is_array($wp_rem_all_langs) && sizeof($wp_rem_all_langs) > 0) {

                    foreach ($wp_rem_all_langs as $file_key => $file_val) {

                        if (isset($file_val['name'])) {

                            $wp_rem_file_name = $file_val['name'];

                            $wp_rem_ext = pathinfo($wp_rem_file_name, PATHINFO_EXTENSION);

                            if ($wp_rem_ext == 'mo') {
                                $wp_rem_mo_files[] = $wp_rem_file_name;
                            }
                        }
                    }
                }

                $wp_rem_active_langs = $sitepress->get_current_language();

                foreach ($wp_rem_mo_files as $mo_file) {
                    if (strpos($mo_file, $wp_rem_active_langs) !== false) {
                        $wp_rem_lang_mo_file = $mo_file;
                    }
                }
            }

            $locale = apply_filters('plugin_locale', get_locale(), 'wp-rem');
            $dir = trailingslashit(WP_LANG_DIR);
            if (isset($wp_rem_lang_mo_file) && $wp_rem_lang_mo_file != '') {
                load_textdomain('wp-rem', plugin_dir_path(__FILE__) . "languages/" . $wp_rem_lang_mo_file);
            } else {
                load_textdomain('wp-rem', plugin_dir_path(__FILE__) . "languages/wp-rem-" . $locale . '.mo');
            }
        }

        /**
         * Fetch and return version of the current plugin
         *
         * @return	string	version of this plugin
         */
        public static function get_plugin_version() {
            $plugin_data = get_plugin_data(__FILE__);
            return $plugin_data['Version'];
        }

        /**
         * Start Function how to Add User and custom Roles
         */
        public function wp_rem_add_custom_role() {
            add_role('guest', 'Guest', array(
                'read' => true, // True allows that capability
                'edit_posts' => true,
                'delete_posts' => false, // Use false to explicitly deny
            ));
        }

        /**
         * Start Function how to Add plugin urls
         */
        public static function plugin_url() {
            return plugin_dir_url(__FILE__);
        }

        /**
         * Start Function how to Add image url for plugin wp_rem
         */
        public static function plugin_img_url() {
            return plugin_dir_url(__FILE__);
        }

        /**
         * Start Function how to Create plugin WP Real Estate Manager
         */
        public static function plugin_dir() {
            return plugin_dir_path(__FILE__);
        }

        /**
         * Start Function how to Activate the plugin
         */
        public static function activate() {
            global $plugin_user_images_wp_rem;
            add_option('wp_rem__plugin_activation', 'installed');
            add_option('wp_rem_', '1');
            // create user role for wp_rem member
            $result = add_role(
                    'wp_rem_member', esc_html('Real Estate Member'), array(
                'read' => false,
                'edit_posts' => false,
                'delete_posts' => false,
                    )
            );
            // create users images wp_rem
            $upload = wp_upload_dir();
            $upload_dir = $upload['basedir'];
            $upload_dir = $upload_dir . '/' . $plugin_user_images_wp_rem;
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777);
            }
        }

        /**
         * Start Function how to DeActivate the plugin
         */
        static function deactivate() {
            delete_option('wp_rem__plugin_activation');
            delete_option('wp_rem_', false);
        }

        /**
         * Start Function how to Add Theme Templates
         */
        public function wp_rem_single_template($single_template) {
            global $post;
            if (get_post_type() == 'properties') {
                if (is_single()) {
                    $single_template = plugin_dir_path(__FILE__) . 'frontend/templates/single_pages/single-property.php';
                }
            }
            if (get_post_type() == 'members') {
                $single_template = plugin_dir_path(__FILE__) . 'frontend/templates/single_pages/single-members.php';
            }
            return $single_template;
        }

        /**
         * Start Function how to Includes Default Scripts and Styles
         */
        public function wp_rem_defaultfiles_plugin_enqueue() {
            global $wp_rem_plugin_options;
            // admin styles
            if (is_admin()) {
                wp_enqueue_media();
            }
            wp_register_style('wp-rem-prettyPhoto', plugins_url('/assets/frontend/css/prettyPhoto.css', __FILE__));

            // map height 100%
            wp_register_style('leaflet', plugins_url('/assets/frontend/css/leaflet.css', __FILE__));
            wp_register_script('leaflet', plugins_url('/assets/frontend/scripts/leaflet.js', __FILE__), array('jquery'));
            wp_register_script('wp_rem_freetilee_js', plugins_url('/assets/frontend/scripts/jquery.freetile.js', __FILE__), array('jquery'), '', true);
            wp_register_script('wp_rem_masonry_pkgd_min_js', plugins_url('/assets/frontend/scripts/masonry.pkgd.min.js', __FILE__), array('jquery'), '', true);
            wp_register_script('wp_rem_init_js', plugins_url('/assets/frontend/scripts/init.js', __FILE__), array('jquery'), '', true);

            /*
             * register i croppic styles
             */

            /* swipper */
            wp_register_style('swiper', plugins_url('/assets/frontend/css/swiper.css', __FILE__));
            wp_register_script('swiper', plugins_url('/assets/frontend/scripts/swiper.min.js', __FILE__), array('jquery'), '', true);
            /*
             * register i croppic scripts
             */


            wp_register_script('fitvids', plugins_url('/assets/frontend/scripts/fitvids.js', __FILE__), array('jquery'), '', true);

            wp_register_script('wp-rem-cripic-min_js', plugins_url('/assets/frontend/scripts/croppic.min.js', __FILE__), array('jquery'));
            // common file for property category
            wp_register_script('wp-rem-property-categories', plugins_url('/assets/common/js/property-categories.js', __FILE__), array('jquery'));
            wp_register_script('chosen-ajaxify', plugins_url('/assets/backend/scripts/chosen-ajaxify.js', __FILE__));
            wp_register_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.js');
            $wp_rem_pt_array = array(
                'plugin_url' => wp_rem::plugin_url(),
            );
            wp_localize_script('chosen-ajaxify', 'wp_rem_chosen_vars', $wp_rem_pt_array);
            if (!is_admin()) {
                wp_register_style('fonticonpicker', plugins_url('/assets/icomoon/css/jquery.fonticonpicker.min.css', __FILE__));
            }
            wp_enqueue_style('iconmoon', plugins_url('/assets/icomoon/css/iconmoon.css', __FILE__));
            wp_enqueue_style('wp_rem_fonticonpicker_bootstrap_css', plugins_url('/assets/icomoon/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css', __FILE__));
            wp_enqueue_script('bootstrap-min', plugins_url('/assets/frontend/scripts/bootstrap.min.js', __FILE__), array('jquery'), '', true);

            wp_register_style('daterangepicker', plugins_url('/assets/frontend/css/daterangepicker.css', __FILE__));

            if (!is_admin()) {
                wp_enqueue_style('bootstrap_css', plugins_url('/assets/frontend/css/bootstrap.css', __FILE__));
                wp_enqueue_style('wp_rem_bootstrap_slider_css', plugins_url('/assets/frontend/css/bootstrap-slider.css', __FILE__));
                wp_enqueue_style('rem-style-animate', plugins_url('/assets/frontend/css/style-animate.css', __FILE__));
                wp_enqueue_style('wp_rem_plugin_css', plugins_url('/assets/frontend/css/wp-rem-plugin.css', __FILE__));
                wp_register_style('wp_rem_datepicker_css', plugins_url('/assets/frontend/css/jquery-ui.css', __FILE__));
                $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
            }
            // All JS files
            $google_api_key = '';
            if (isset($wp_rem_plugin_options['wp_rem_google_api_key']) && $wp_rem_plugin_options['wp_rem_google_api_key'] != '') {
                $google_api_key = '?key=' . $wp_rem_plugin_options['wp_rem_google_api_key'] . '&libraries=geometry,places,drawing';
            } else {
                $google_api_key = '?libraries=geometry,places,drawing';
            }
            wp_register_script('wp-rem-google-map-api', 'https://maps.googleapis.com/maps/api/js' . $google_api_key);
            wp_enqueue_script('wp-rem-google-map-api');

            //wp_enqueue_script('wp-rem-map-styles', plugins_url('/assets/frontend/scripts/map-styles.js', __FILE__), '', '', true);

            if (!is_admin()) {
                wp_enqueue_script('responsive-menu', plugins_url('/assets/frontend/scripts/responsive.menu.js', __FILE__), '', '', true);
                //wp_enqueue_script('jquery-branches-latlon-picker', plugins_url('/assets/frontend/scripts/jquery-branches-latlon-picker.js', __FILE__), '', '', true);
            }

            wp_register_script('wp-rem-matchHeight-script', plugins_url('/assets/frontend/scripts/jquery.matchHeight-min.js', __FILE__), '', '', true);
            wp_enqueue_script('wp-rem-matchHeight-script');
            /*
             * New Scripts
             */
            wp_register_script('wp-rem-validation-script', plugins_url('/assets/frontend/scripts/wp-rem-validation.js', __FILE__), '', '', true);
            wp_register_script('wp-rem-members-script', plugins_url('/assets/frontend/scripts/wp-rem-members.js', __FILE__), '', '', true);
            wp_register_script('wp-rem-login-script', plugins_url('/assets/frontend/scripts/wp-rem-login.js', __FILE__), '', '', true);
            wp_register_script('wp-rem-icons-loader', plugins_url('/assets/common/js/icons-loader.js', __FILE__), array('jquery'));
            wp_register_script('wp-rem-property-functions', plugins_url('/assets/frontend/scripts/property-functions.js', __FILE__), array('jquery'));
            wp_register_script('jquery-mixitup', plugins_url('/assets/frontend/scripts/jquery.mixitup.min.js', __FILE__), array('jquery'));
            wp_register_script('wp-rem-member-functions', plugins_url('/assets/frontend/scripts/member-functions.js', __FILE__), array('jquery'));
            $wp_rem_property_functions_string = array(
                'property_type' => wp_rem_plugin_text_srt('wp_rem_rem_property_type'),
                'price_type' => wp_rem_plugin_text_srt('wp_rem_advance_search_select_price_type_label'),
                'all' => wp_rem_plugin_text_srt('wp_rem_advance_search_select_price_types_all'),
                'plugin_url' => wp_rem::plugin_url(),
                'ajax_url' => admin_url('admin-ajax.php'),
            );
            wp_localize_script('wp-rem-property-functions', 'wp_rem_property_functions_string', $wp_rem_property_functions_string);
            $wp_rem_icons_array = array(
                'plugin_url' => wp_rem::plugin_url(),
            );
            wp_localize_script('wp-rem-icons-loader', 'icons_vars', $wp_rem_icons_array);
            if (is_admin()) {
                wp_enqueue_script('wp-rem-icons-loader');
            }
            $wp_rem_property_strings = array(
                'service_added' => wp_rem_plugin_text_srt('wp_rem_rem_serveice_addeed'),
                'ploor_plan_added' => wp_rem_plugin_text_srt('wp_rem_rem_floor_plan_added'),
                'nearby_added' => wp_rem_plugin_text_srt('wp_rem_rem_near_by_added'),
                'attachment_added' => wp_rem_plugin_text_srt('wp_rem_rem_attachment_added'),
                'apartment_added' => wp_rem_plugin_text_srt('wp_rem_rem_apartment_added'),
                'off_day_added' => wp_rem_plugin_text_srt('wp_rem_rem_off_day_added'),
                'buy_exist_packg' => wp_rem_plugin_text_srt('wp_rem_rem_buy_exists_pkg'),
                'buy_new_packg' => wp_rem_plugin_text_srt('wp_rem_rem_buy_new_pkg'),
                'off_day_already_added' => wp_rem_plugin_text_srt('wp_rem_rem_off_day_already_added'),
                'upload_images_only' => wp_rem_plugin_text_srt('wp_rem_rem_upload_images'),
                'action_error' => wp_rem_plugin_text_srt('wp_rem_rem_action_error'),
                'compulsory_fields' => wp_rem_plugin_text_srt('wp_rem_rem_compulsory_fields'),
                'payment_txt' => wp_rem_plugin_text_srt('wp_rem_rem_payment_text'),
                'submit_order_txt' => wp_rem_plugin_text_srt('wp_rem_rem_sbmit_order'),
                'update_txt' => wp_rem_plugin_text_srt('wp_rem_rem_update_text'),
                'create_list_txt' => wp_rem_plugin_text_srt('wp_rem_rem_create_list_text'),
                'property_updated' => wp_rem_plugin_text_srt('wp_rem_rem_property_updated'),
                'property_created' => wp_rem_plugin_text_srt('wp_rem_rem_property_created'),
                'valid_price_error' => wp_rem_plugin_text_srt('wp_rem_rem_valid_price_error'),
                'detail_txt' => wp_rem_plugin_text_srt('wp_rem_rem_detail_text'),
                'close_txt' => wp_rem_plugin_text_srt('wp_rem_rem_close_text'),
                'plugin_url' => wp_rem::plugin_url(),
                'ajax_url' => admin_url('admin-ajax.php'),
                'more_than_f' => wp_rem_plugin_text_srt('wp_rem_select_pkg_img_num_more_than'),
                'more_than_image_change' => wp_rem_plugin_text_srt('wp_rem_select_pkg_img_num_change_pkg'),
                'more_than_doc_change' => wp_rem_plugin_text_srt('wp_rem_select_pkg_doc_num_change_pkg'),
            );
            // temprary off
            wp_enqueue_script('wp_rem_functions_frontend', plugins_url('/assets/frontend/scripts/functions.js', __FILE__));
            wp_localize_script('wp_rem_functions_frontend', 'wp_rem_property_strings', $wp_rem_property_strings);
            wp_register_script('wp-rem-split-map', plugins_url('/assets/frontend/scripts/split-map.js', __FILE__), '', '', true);
            wp_register_script('wp_rem_piechart_frontend', plugins_url('/assets/frontend/scripts/donut-pie-chart.min.js', __FILE__));

            wp_localize_script(
                    'wp_rem_functions_frontend', 'wp_rem_globals', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'some_txt_error' => wp_rem_plugin_text_srt('wp_rem_prop_notes_some_txt_error'),
                'plugin_url' => wp_rem::plugin_url(),
                'is_frontend' => is_admin() ? 'false' : 'true',
                'security' => wp_create_nonce('wp-rem-security'),
                    )
            );
            wp_register_script('wp-rem-prettyPhoto', plugins_url('/assets/frontend/scripts/jquery.prettyPhoto.js', __FILE__), array('jquery'));
            wp_register_script('wp-rem-tags-it', plugins_url('/assets/frontend/scripts/tag-it.js', __FILE__));
            if (!is_admin()) {
                wp_register_style('bootstrap-datepicker', plugins_url('/assets/frontend/css/bootstrap-datepicker.css', __FILE__));
                wp_enqueue_script('wp-rem-growls', plugins_url('/assets/frontend/scripts/jquery.growl.js', __FILE__), '', '', true);
                wp_register_script('wp-rem-property-add', plugins_url('/assets/frontend/scripts/property-add-functions.js', __FILE__), '', '', true);
                wp_register_script('wp-rem-property-user-add', plugins_url('/assets/frontend/scripts/property-add-user.js', __FILE__), '', '', true);
                wp_register_script('wp-rem-reservation-functions', plugins_url('/assets/frontend/scripts/reservation-functions.js', __FILE__));
                /*
                 * Icons style and script
                 */
                wp_register_script('fonticonpicker', plugins_url('/assets/icomoon/js/jquery.fonticonpicker.min.js', __FILE__));

                wp_localize_script('wp-rem-property-add', 'wp_rem_property_strings', $wp_rem_property_strings);
                wp_localize_script('wp-rem-property-user-add', 'wp_rem_property_strings', $wp_rem_property_strings);
                // property map js
                wp_register_script('map-infobox', plugins_url('/assets/frontend/scripts/map-infobox.js', __FILE__), '', '', true);
                wp_register_script('map-clusterer', plugins_url('/assets/frontend/scripts/markerclusterer.js', __FILE__), '', '', true);
                wp_register_script('wp-rem-property-map', plugins_url('/assets/frontend/scripts/property-map.js', __FILE__), '', '', true);
                wp_register_script('wp-rem-property-top-map', plugins_url('/assets/frontend/scripts/property-top-map.js', __FILE__), '', '', true);
                do_action('wp_rem_enqueue_files_frontend');
            }
            wp_register_script('wp-rem-jquery-scrollbar', plugins_url('/assets/frontend/scripts/jquery.scrollbar.js', __FILE__), '', '', true);
            wp_enqueue_script('responsive-calendar', plugins_url('/assets/common/js/responsive-calendar.min.js', __FILE__), '', '', true);
            wp_register_script('wp-rem-bootstrap-slider', plugins_url('/assets/frontend/scripts/bootstrap-slider.js', __FILE__), '', '', true);
            wp_enqueue_script('wp-rem-bootstrap-slider');
            // Dashboad date fields style & script.
            wp_register_style('daterangepicker', plugins_url('/assets/frontend/css/daterangepicker.css', __FILE__));
            wp_register_script('daterangepicker-moment', plugins_url('/assets/frontend/scripts/moment.js', __FILE__), '', '', true);
            wp_register_script('daterangepicker', plugins_url('/assets/frontend/scripts/daterangepicker.js', __FILE__), '', '', true);
            wp_register_script('wp-rem-filters-functions', plugins_url('/assets/frontend/scripts/filters-functions.js', __FILE__), '', '', true);

            // property compare
            wp_register_script('wp-rem-property-compare', plugins_url('/assets/frontend/scripts/property-compare.js', __FILE__), '', '', true);
            $property_compare_strings = array(
                'plugin_url' => wp_rem::plugin_url(),
                'ajax_url' => admin_url('admin-ajax.php'),
                'error' => wp_rem_plugin_text_srt('wp_rem_shortcode_compare_error'),
                'compare_label' => wp_rem_plugin_text_srt('wp_rem_shortcode_compare_label'),
                'compared_label' => wp_rem_plugin_text_srt('wp_rem_shortcode_compared_label'),
            );
            wp_localize_script('wp-rem-property-compare', 'wp_rem_property_compare', $property_compare_strings);

            /**
             *
             * @login popup script files
             */
            if (!function_exists('wp_rem_login_box_popup_scripts')) {

                function wp_rem_login_box_popup_scripts() {
                    echo '';
                }

            }
            /**
             *
             * @login popup script files
             */
            if (!function_exists('wp_rem_google_recaptcha_scripts')) {

                function wp_rem_google_recaptcha_scripts() {
                    wp_enqueue_script('wp_rem_google_recaptcha_scripts', wp_rem_server_protocol() . 'www.google.com/recaptcha/api.js?onload=wp_rem_multicap_all_functions&amp;render=explicit', '', '');
                }

            }
            //jquery text editor files
            if (is_admin()) {
                wp_enqueue_style('jquery-te', plugins_url('/assets/common/css/jquery-te-1.4.0.css', __FILE__));
                wp_enqueue_script('jquery-te', plugins_url('/assets/common/js/jquery-te-1.4.0.min.js', __FILE__), '', '', true);
            }
            if (!is_admin()) {
                wp_register_style('jquery-te', plugins_url('/assets/common/css/jquery-te-1.4.0.css', __FILE__));
                wp_register_script('jquery-te', plugins_url('/assets/common/js/jquery-te-1.4.0.min.js', __FILE__));
            }
            //jquery text editor files end
            if (is_admin()) {
                // admin css files
                global $price_tables_meta_object;
                wp_enqueue_style('wp_rem_datatable_css', plugins_url('/assets/backend/css/datatable.css', __FILE__));
                wp_enqueue_style('fonticonpicker', plugins_url('/assets/icomoon/css/jquery.fonticonpicker.min.css', __FILE__));
                wp_enqueue_style('iconmoon', plugins_url('/assets/icomoon/css/iconmoon.css', __FILE__));
                wp_enqueue_style('wp_rem_fonticonpicker_bootstrap_css', plugins_url('/assets/icomoon/theme/bootstrap-theme/jquery.fonticonpicker.bootstrap.css', __FILE__));
                wp_enqueue_style('wp-rem-bootstrap', plugins_url('/assets/backend/css/bootstrap.css', __FILE__));
                wp_enqueue_style('chosen', plugins_url('/assets/backend/css/chosen.css', __FILE__));
                wp_enqueue_style('wp_rem_bootstrap_calendar_css', plugins_url('/assets/backend/css/bootstrap-year-calendar.css', __FILE__));
                wp_enqueue_style('wp_rem_price_tables', plugins_url('/assets/backend/css/price-tables.css', __FILE__));
                wp_enqueue_script('jquery-latlon-picker', plugins_url('/assets/frontend/scripts/jquery_latlon_picker.js', __FILE__), '', '', false);
                wp_enqueue_style('wp-color-picker');
                wp_enqueue_script('wp-rem-bootstrap-slider');
                // admin js files
                wp_enqueue_script('wp_rem_datatable_js', plugins_url('/assets/backend/scripts/datatable.js', __FILE__), '', '', true);
                wp_enqueue_script('chosen', plugins_url('/assets/frontend/scripts/chosen.jquery.js', __FILE__));
                wp_enqueue_script('chosen-order-jquery', plugins_url('/assets/common/js/chosen.order.jquery.js', __FILE__));
                wp_enqueue_script('chosen-ajaxify', plugins_url('/assets/backend/scripts/chosen-ajaxify.js', __FILE__));
                $wp_rem_pt_array = array(
                    'plugin_url' => wp_rem::plugin_url(),
                );
                wp_localize_script('chosen-ajaxify', 'wp_rem_chosen_vars', $wp_rem_pt_array);
                wp_enqueue_script('wp_rem_bootstrap_calendar_js', plugins_url('/assets/backend/scripts/bootstrap-year-calendar.js', __FILE__));
                wp_enqueue_script('wp_rem_custom_wp_admin_script_js', plugins_url('/assets/backend/scripts/functions.js', __FILE__), array('wp-color-picker'), '', true);
                wp_localize_script(
                        'wp_rem_custom_wp_admin_script_js', 'wp_rem_globals', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'plugin_url' => wp_rem::plugin_url(),
                    'security' => wp_create_nonce('wp-rem-security'),
                    'banner_image_error' => wp_rem_plugin_text_srt('wp_rem_options_banner_image_error'),
                    'banner_code_error' => wp_rem_plugin_text_srt('wp_rem_options_banner_code_error'),
                    'delete_selected_file_cofirmation' => wp_rem_plugin_text_srt('wp_rem_options_delete_selected_backup_file'),
                        )
                );
                wp_enqueue_script('wp_rem__shortcodes_js', plugins_url('/assets/backend/scripts/shortcode-functions.js', __FILE__), '', '', true);
                wp_localize_script(
                        'wp_rem__shortcodes_js', 'wp_rem_globals', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'plugin_url' => wp_rem::plugin_url(),
                        )
                );

                wp_enqueue_script('fonticonpicker', plugins_url('/assets/icomoon/js/jquery.fonticonpicker.min.js', __FILE__));
                wp_register_script('wp-rem-price-tables', plugins_url('/assets/backend/scripts/price-tables.js', __FILE__), '', '', true);
                $wp_rem_pt_array = array(
                    'plugin_url' => wp_rem::plugin_url(),
                    'ajax_url' => esc_url(admin_url('admin-ajax.php')),
                    'packages_dropdown' => $price_tables_meta_object->wp_rem_pkgs(),
                );
                wp_localize_script('wp-rem-price-tables', 'wp_rem_pt_vars', $wp_rem_pt_array);
                wp_enqueue_script('wp-rem-price-tables');
                wp_enqueue_style('datetimepicker', plugins_url('/assets/common/css/jquery.datetimepicker.css', __FILE__));
                wp_enqueue_script('datetimepicker', plugins_url('/assets/common/js/jquery.datetimepicker.js', __FILE__), '', '', true);
            }

            wp_register_style('datepicker', plugins_url('/assets/frontend/css/datepicker.css', __FILE__));
            wp_register_style('datetimepicker', plugins_url('/assets/common/css/jquery.datetimepicker.css', __FILE__));
            wp_register_script('datetimepicker', plugins_url('/assets/common/js/jquery.datetimepicker.js', __FILE__), '', '', true);

            wp_register_script('jquery-latlon-picker', plugins_url('/assets/frontend/scripts/jquery_latlon_picker.js', __FILE__), '', '', false);

            /**
             *
             * @social login script
             */
            if (!function_exists('wp_rem_socialconnect_scripts')) {

                function wp_rem_socialconnect_scripts() {
                    wp_enqueue_script('wp_rem_socialconnect_js', plugins_url('/elements/login/cs-social-login/media/js/cs-connect.js', __FILE__), '', '', true);
                }

            }

            // Register Location Autocomplete for late use.
            wp_register_script('wp_rem_location_autocomplete_js', plugins_url('/assets/frontend/scripts/jquery.location-autocomplete.js', __FILE__), '', '', true);
            //wp_enqueue_script('wp_rem_location_autocomplete_js');
            /**
             *
             * @google auto complete script
             */
            if (!function_exists('wp_rem_google_autocomplete_scripts')) {

                function wp_rem_google_autocomplete_scripts() {
                    wp_enqueue_script('wp_rem_location_autocomplete_js', plugins_url('/assets/frontend/scripts/jquery.location-autocomplete.js', __FILE__), '', '');
                }

            }
        }

        public function wp_rem_enqueue_admin_style_sheet() {
            wp_enqueue_style('wp-rem-admin-style', plugins_url('/assets/backend/css/admin-style.css', __FILE__));
        }

        /**
         *
         * @Responsive Tabs Styles and Scripts
         */
        public static function wp_rem_enqueue_responsive_front_scripts() {


            $my_theme = wp_get_theme('wp-rem');
            if (!$my_theme->exists()) {
                wp_enqueue_style('wp_rem_responsive_css', plugins_url('/assets/frontend/css/responsive.css', __FILE__));
            }
        }

        /**
         *
         * @Data Table Style Scripts
         */

        /**
         * Start Function how to Add table Style Script
         */
        public static function wp_rem_data_table_style_script() {
            wp_enqueue_style('wp_rem_data_table_css', plugins_url('/assets/frontend/css/jquery.data_tables.css', __FILE__));
        }

        /**
         * End Function how to Add Tablit Style Script
         */
        public static function wp_rem_jquery_ui_scripts() {
            
        }

        /**
         * Start Function how to Add Location Picker Scripts
         */
        public function wp_rem_location_gmap_script() {
            wp_enqueue_script('jquery-latlon-picker', plugins_url('/assets/frontend/scripts/jquery_latlon_picker.js', __FILE__), '', '', true);
        }

        public function wp_rem_branches_location_gmap_script() {
            wp_enqueue_script('jquery-branches-latlon-picker', plugins_url('/assets/frontend/scripts/jquery-branches-latlon-picker.js', __FILE__), '', '', true);
        }

        /**
         * Start Function how to Add Google Place Scripts
         */
        public function wp_rem_google_place_scripts() {
            global $wp_rem_plugin_options;
            $google_api_key = '';
            if (isset($wp_rem_plugin_options['wp_rem_google_api_key']) && $wp_rem_plugin_options['wp_rem_google_api_key'] != '') {
                $google_api_key = '?key=' . $wp_rem_plugin_options['wp_rem_google_api_key'] . '&libraries=geometry,places,drawing';
            } else {
                $google_api_key = '?libraries=geometry,places,drawing';
            }
            wp_enqueue_script('google-autocomplete', 'https://maps.googleapis.com/maps/api/js' . $google_api_key);
        }

        // start function for google map files
        public static function wp_rem_googlemapcluster_scripts() {
            echo '';
        }

        /**
         * Start Function how to Add Google Autocomplete Scripts
         */
        public function wp_rem_autocomplete_scripts() {
            wp_enqueue_script('jquery-ui-autocomplete');
            wp_enqueue_script('jquery-ui-slider');
        }

        // Start function for global code
        public function wp_rem_all_scodes() {
            global $wp_rem_jh_scodes;
        }

        // Start function for auto login user
        public function wp_rem_auto_login_user() {
            
        }

        public static $email_template_type = 'general';
        public static $email_default_template = 'Hello! I am general email template by [COMPANY_NAME].';
        public static $email_template_variables = array(
            array(
                'tag' => 'SITE_NAME',
                'display_text' => 'Site Name',
                'value_callback' => array('wp_rem', 'wp_rem_get_site_name'),
            ),
            array(
                'tag' => 'ADMIN_EMAIL',
                'display_text' => 'Admin Email',
                'value_callback' => array('wp_rem', 'wp_rem_get_admin_email'),
            ),
            array(
                'tag' => 'SITE_URL',
                'display_text' => 'SITE URL',
                'value_callback' => array('wp_rem', 'wp_rem_get_site_url'),
            ),
        );

        public function email_template_settings_callback($email_template_options) {
            $email_template_options['types'][] = self::$email_template_type;
            $email_template_options['templates']['general'] = self::$email_default_template;
            $email_template_options['variables']['General'] = self::$email_template_variables;

            return $email_template_options;
        }

        /*
         * Fetching Plugin Option for specific option ID
         * @ @option_id is the option you want to get status for
         */

        public function wp_rem_get_plugin_options_callback($option_id = '') {
            if (isset($option_id) && $option_id != '') {
                $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
                if (isset($wp_rem_plugin_options[$option_id])) {
                    return $wp_rem_plugin_options[$option_id];
                }
            }
            return false;
        }

        public static function get_terms_and_conditions_field($label = '', $field_name = '', $show_accept = true) {
            global $wp_rem_plugin_options;
            $label = ( $label == '' ? wp_rem_plugin_text_srt('wp_rem_rem_terms_and_conditions') : $label );
            $field_name = ( $field_name == '' ? 'terms_and_conditions' : $field_name );

            $terms_condition_check = isset($wp_rem_plugin_options['wp_rem_cs_terms_condition_check']) ? $wp_rem_plugin_options['wp_rem_cs_terms_condition_check'] : '';
            ob_start();
            if ($terms_condition_check == 'on') {
                $terms_condition_page = isset($wp_rem_plugin_options['cs_terms_condition']) ? $wp_rem_plugin_options['cs_terms_condition'] : '';
                ?>
                <div class="checkbox-area">
                    <input type="checkbox" id="<?php echo ($field_name); ?>" class="wp-rem-dev-req-field">
                    <label for="<?php echo ($field_name); ?>">
                        <?php
                        if ($show_accept) {
                            echo wp_rem_plugin_text_srt('wp_rem_rem_accept');
                        }
                        ?>
                        <a target="_blank" href="<?php echo esc_url(get_permalink($terms_condition_page)); ?>">
                            <?php echo esc_html($label); ?>
                        </a>
                    </label>
                </div>
                <?php
            }
            return ob_get_clean();
        }

        public static function wp_rem_get_site_name() {
            return get_bloginfo('name');
        }

        public static function wp_rem_get_admin_email() {
            return get_bloginfo('admin_email');
        }

        public static function wp_rem_get_site_url() {
            return get_bloginfo('url');
        }

        public static function wp_rem_replace_tags($template, $variables) {
            // Add general variables to the list
            $variables = array_merge(self::$email_template_variables, $variables);

            foreach ($variables as $key => $variable) {
                $callback_exists = false;

                // Check if function/method exists.
                if (is_array($variable['value_callback'])) { // If it is a method of a class.
                    $callback_exists = method_exists($variable['value_callback'][0], $variable['value_callback'][1]);
                } else { // If it is a function.
                    $callback_exists = function_exists($variable['value_callback']);
                }

                // Substitute values in place of tags if callback exists.
                if (true == $callback_exists) {
                    // Make a call to callback to get value.
                    $value = call_user_func($variable['value_callback']);

                    // If we have some value to substitute then use that.
                    if (false != $value) {
                        $template = str_replace('[' . $variable['tag'] . ']', $value, $template);
                    }
                }
            }
            return $template;
        }

        public static function get_template($email_template_index, $email_template_variables, $email_default_template) {
            $email_template = '';
            $template_data = array('subject' => '', 'from' => '', 'recipients' => '', 'email_notification' => '', 'email_type' => '', 'email_template' => '');
            // Check if there is a template select else go with default template.
            $selected_template_id = wp_rem_check_if_template_exists($email_template_index, 'jh-templates');
            if (false != $selected_template_id) {

                // Check if a temlate selected else default template is used.
                if ($selected_template_id != 0) {
                    $templateObj = get_post($selected_template_id);
                    if ($templateObj != null) {
                        $email_template = $templateObj->post_content;
                        $template_id = $templateObj->ID;
                        $template_data['subject'] = wp_rem::wp_rem_replace_tags(get_post_meta($template_id, 'jh_subject', true), $email_template_variables);
                        $template_data['from'] = wp_rem::wp_rem_replace_tags(get_post_meta($template_id, 'jh_from', true), $email_template_variables);
                        $template_data['recipients'] = wp_rem::wp_rem_replace_tags(get_post_meta($template_id, 'jh_recipients', true), $email_template_variables);
                        $template_data['email_notification'] = get_post_meta($template_id, 'jh_email_notification', true);
                        $template_data['email_type'] = get_post_meta($template_id, 'jh_email_type', true);
                    }
                } else {
                    // Get default template.
                    $email_template = $email_default_template;
                    $template_data['email_notification'] = 1;
                }
            } else {
                $email_template = $email_default_template;
                $template_data['email_notification'] = 1;
            }

            $email_template = wp_rem::wp_rem_replace_tags($email_template, $email_template_variables);
            $template_data['email_template'] = $email_template;
            return $template_data;
        }

        public static function plugin_path() {
            return untrailingslashit(plugin_dir_path(__FILE__));
        }

        public static function template_path() {
            return apply_filters('wp_rem_plugin_template_path', 'wp-realestate-manager/');
        }

        public function register_modules() {
            /*
             * Modules
             */
            require_once 'modules/wp-rem-favourites/wp-rem-favourites.php';
            require_once 'modules/wp-rem-notifications/wp-rem-alerts.php';
            require_once 'modules/wp-rem-activity-notifications/wp-rem-activity-notifications.php';
            require_once 'modules/wp-rem-email-templates/wp-rem-email-templates.php';
        }

    }

}
/*
 * Check if an email template exists
 */
if (!function_exists('wp_rem_check_if_template_exists')) {

    function wp_rem_check_if_template_exists($slug, $type) {
        global $wpdb;
        $post = $wpdb->get_row("SELECT ID FROM " . $wpdb->prefix . "posts WHERE post_name = '" . $slug . "' && post_type = '" . $type . "'", 'ARRAY_A');
        if (isset($post) && isset($post['ID'])) {
            return $post['ID'];
        } else {
            return false;
        }
    }

}


/**
 * Get Property's Gallery Nth Image.
 *
 */
if (!function_exists('wp_rem_get_property_gallery_nth_image_url')) {

    function wp_rem_get_property_gallery_nth_image_url($post_id = 0, $size = 'thumbnail', $n = 0) {
        $image_url = '';

        if ($post_id > -1 && $n > -1) {
            $property_type_slug = get_post_meta($post_id, 'wp_rem_property_type', true);
            $property_type_post = get_posts(array('posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish'));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $property_type_gal_switch = get_post_meta($property_type_id, 'wp_rem_image_gallery_element', true);
            if ($property_type_gal_switch == 'on') {
                $gallery_ids_list = get_post_meta($post_id, 'wp_rem_detail_page_gallery_ids', true);
                if (( is_array($gallery_ids_list) && sizeof($gallery_ids_list) > 0)) {
                    if (isset($gallery_ids_list[$n])) {
                        $attachment_id = $gallery_ids_list[$n];
                    } else {
                        $attachment_id = $gallery_ids_list[0];
                    }
                    $image_attr = wp_get_attachment_image_src($attachment_id, $size);
                    if ($image_attr) {
                        $image_url = $image_attr[0];
                    }
                }
            }
        }
        return $image_url;
    }

}


/**
 *
 * @Create Object of class To Activate Plugin
 */
if (class_exists('wp_rem')) {
    global $wp_rem_Class;
    $wp_rem_Class = new wp_rem();
    register_activation_hook(__FILE__, array('wp_rem', 'activate'));
    register_deactivation_hook(__FILE__, array('wp_rem', 'deactivate'));
}

//Remove Sub Menu add new properties
function modify_menu() {
    global $submenu;
    if (isset($submenu['edit.php?post_type=properties'][10])) {
        unset($submenu['edit.php?post_type=properties'][10]);
    }
    if (isset($submenu['edit.php?post_type=members'][10])) {
        unset($submenu['edit.php?post_type=members'][10]);
    }
    if (isset($submenu['edit.php?post_type=packages'][10])) {
        unset($submenu['edit.php?post_type=packages'][10]);
    }
}

add_action('admin_menu', 'modify_menu');

function create_daily_properties_check() {
    // Use wp_next_scheduled to check if the event is already scheduled.
    $timestamp = wp_next_scheduled('create_daily_properties_check');

    // If $timestamp == false schedule daily alerts since it hasn't been done previously.
    if ($timestamp == false) {
        // Schedule the event for right now, then to repeat daily using the hook 'create_daily_properties_check'.
        wp_schedule_event(time(), 'daily', 'create_daily_properties_check');
    }
}

function remove_daily_properties_check() {
    wp_clear_scheduled_hook('remove_daily_properties_check');
}

// On plugin activation register daily cronj0b.
register_activation_hook(__FILE__, 'create_daily_properties_check');

// On plugin deactivation


function wp_rem_get_current_template($echo = false) {
    if (!isset($GLOBALS['current_theme_template']))
        return false;
    if ($echo)
        echo $GLOBALS['current_theme_template'];
    else
        return $GLOBALS['current_theme_template'];
}

add_filter('template_include', 'wp_rem_template_include', 1000);

function wp_rem_template_include($t) {
    $GLOBALS['current_theme_template'] = basename($t);
    return $t;
}
