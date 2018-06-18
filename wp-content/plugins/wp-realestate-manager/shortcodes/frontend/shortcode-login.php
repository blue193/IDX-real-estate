<?php
/**
 * File Type: Login Shortcode Frontend
 */
if ( ! class_exists('Wp_rem_Shortcode_Login_Frontend') ) {

    class Wp_rem_Shortcode_Login_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_login';
        var $LOGIN_OUTPUT = '';
        var $REGISTER_OUTPUT = '';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array( $this, 'wp_rem_login_shortcode_callback' ));
            add_action($this->PREFIX, array( $this, 'wp_rem_login_callback' ), 11, 1);
        }

        public function wp_nav_menu_items_callback($items, $args) {
            global $post, $wp_rem_plugin_options, $wp_rem_theme_options;

            $wp_rem_html = '';
            echo wp_rem_allow_special_char($wp_rem_plugin_options['wp_rem_user_dashboard_switchs'] . 'ssdsddsd');
            die();
            $wp_rem_user_dashboard_switchs = '';
            if ( isset($wp_rem_plugin_options['wp_rem_user_dashboard_switchs']) ) {
                echo $wp_rem_user_dashboard_switchs = $wp_rem_plugin_options['wp_rem_user_dashboard_switchs'];
            }
            if ( $args->theme_location == 'primary' ) {

                ob_start();
                ?>
                <ul class="login-option">
                    <?php do_action('wp_rem_login'); ?>
                </ul>
                <?php
                $wp_rem_html .= ob_get_clean();
                if ( $wp_rem_user_dashboard_switchs == 'on' ) {
                    $items .= $wp_rem_html;
                }
            }
            return $items;
        }

        /*
         * Login hook calling shortcode
         */

        public function wp_rem_login_callback($view = '') {
            echo do_shortcode('[' . $this->PREFIX . ' header_view=' . $view . ']');
        }

        /*
         * Shortcode View on Frontend
         */

        public function wp_rem_login_shortcode_callback($atts, $content = "") {
            global $wpdb, $wp_rem_plugin_options, $wp_rem_form_fields_frontend, $wp_rem_form_fields_frontend, $wp_rem_html_fields;


            wp_rem_socialconnect_scripts(); // social login script
            $defaults = array( 'column_size' => '1/1', 'title' => '', 'register_text' => '', 'register_role' => 'contributor', 'wp_rem_type' => '', 'wp_rem_login_txt' => '', 'login_btn_class' => '' );
            extract(shortcode_atts($defaults, $atts));

            $header_view = isset($atts['header_view']) ? $atts['header_view'] : '';

            $user_disable_text = wp_rem_plugin_text_srt('wp_rem_login_register_disabled');
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';

            $wp_rem_demo_user_login_switch = isset($wp_rem_plugin_options['wp_rem_demo_user_login_switch']) ? $wp_rem_plugin_options['wp_rem_demo_user_login_switch'] : '';
            if ( $wp_rem_demo_user_login_switch == 'on' ) {
                $wp_rem_demo_user_member = isset($wp_rem_plugin_options['wp_rem_demo_user_member']) ? $wp_rem_plugin_options['wp_rem_demo_user_member'] : '';
                $wp_rem_demo_user_agency = isset($wp_rem_plugin_options['wp_rem_demo_user_agency']) ? $wp_rem_plugin_options['wp_rem_demo_user_agency'] : '';
            }
            $rand_id = rand(13243, 99999);
            wp_rem_login_box_popup_scripts();
            if ( $wp_rem_sitekey <> '' and $wp_rem_secretkey <> '' and ! is_user_logged_in() ) {
                wp_rem_google_recaptcha_scripts();
                ?>
                <script>

                    var recaptcha2;

                    var recaptcha5;
                    var wp_rem_multicap = function () {
                        //Render the recaptcha1 on the element with ID "recaptcha1"
                        recaptcha2 = grecaptcha.render('recaptcha2', {
                            'sitekey': '<?php echo ($wp_rem_sitekey); ?>', //Replace this with your Site key
                            'theme': 'light'
                        });
                        //Render the recaptcha2 on the element with ID "recaptcha2"
                        recaptcha5 = grecaptcha.render('recaptcha5', {
                            'sitekey': '<?php echo ($wp_rem_sitekey); ?>', //Replace this with your Site key
                            'theme': 'light'
                        });
                    };

                </script>
                <?php
            }
            $output = '';
            if ( is_user_logged_in() ) {
                $output .= $this->wp_rem_profiletop_menu('', $header_view);
            } else {
                wp_enqueue_script('wp-rem-login-script');
                $role = $register_role;
                $wp_rem_type = isset($wp_rem_type) ? $wp_rem_type : '';
                $wp_rem_login_class = 'login';
                $isRegistrationOn = get_option('users_can_register');

                $sign_in_label = wp_rem_plugin_text_srt('wp_rem_login_register_sign_in');
                $register_label = wp_rem_plugin_text_srt('wp_rem_register_register');
                if ( $header_view == 'advance_v2' ) {
                    $sign_in_label = '';
                    $register_label = '';
                }

                $output .= '<i class="icon-user2"></i>';
                $output .= '<a id="btn-header-main-login" data-target="#sign-in" data-toggle="modal" class="cs-popup-login-btn login-popup-btn wp-rem-open-signin-button user-tab-login" href="#user-login-tab-' . $rand_id . '">' . $sign_in_label . '</a>';
                $output .= '<span>/</span>';
                $output .= '<a class="cs-color cs-popup-joinus-btn login-popup-btn wp-rem-open-register-button user-tab-register" data-target="#sign-in" data-toggle="modal" href="#user-register-' . $rand_id . '">' . $register_label . '</a>';
                $login_btn_class_str = '';
                if ( $login_btn_class != '' ) {
                    $login_btn_class_str = 'class="' . $login_btn_class . '"';
                }
                /*
                 * Signin Popup Rendering
                 */
                $output_html = '';

                $output_html .= '<div class="modal fade" id="sign-in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                <div class="login-form login-form-element-' . $rand_id . '" data-id="' . $rand_id . '">
                                    
                                <div class="modal-content">';

                $output_html .= '<div class="tab-content"><ul class="nav nav-tabs">
                    <li><a data-toggle="tab" href="#user-login-tab-' . $rand_id . '" id="myModalLabel" class="user-tab-login">' . wp_rem_plugin_text_srt('wp_rem_login_register_sign_in') . '</a></li>
                    <li><a data-toggle="tab" href="#user-register-' . $rand_id . '" class="user-tab-register">' . wp_rem_plugin_text_srt('wp_rem_register_register') . '</a></li>
                </ul>';


                // Signin Tab
                $output_html .= '<div id="user-login-tab-' . $rand_id . '" class="tab-pane fade">';

                $output_html .= '<div class="modal-header">
              
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"><i class="icon- icon-close2"></i></span> </button>
                             
                         </div>';
                $output_html .= '<div class="modal-body">';
                $output_html .= '<div class="content-style-form cs-forgot-pbox-' . $rand_id . ' content-style-form-2" style="display:none;"><div class="signin-tab-link">
                                            ' . wp_rem_plugin_text_srt('wp_rem_login_register_already_have_account') . '    <a data-id="' . $rand_id . '" class="cs-bgcolor cs-login-switch">' . wp_rem_plugin_text_srt('wp_rem_register_login_here') . '</a>
                    </div><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
                ob_start();
                $output_html .= do_shortcode('[wp_rem_forgot_password wp_rem_type="popup"]');
                $output_html .= ob_get_clean();
                $output_html .= '</div><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="login-detail">
                                            <h2>' . wp_rem_plugin_text_srt('wp_rem_login_register_need_more_help') . '</h2>
                                            <p>' . wp_rem_plugin_text_srt('wp_rem_login_register_can_login') . '</p>
                                            <a href="#">' . wp_rem_plugin_text_srt('wp_rem_register_contact_us_string') . '</a>
                                        </div>
                                    </div></div>';
                $output_html .= '<p class="wp-rem-dev-login-top-msg" style="display: none;"></p>';

                $output_html .='<div class="cs-login-pbox-' . $rand_id . ' login-form-id-' . $rand_id . '">';
                $output_html .= '<div class="status status-message"></div>';
                $isRegistrationOn = get_option('users_can_register');
                if ( $isRegistrationOn ) {
                    
                }
                ob_start();
                $isRegistrationOn = get_option('users_can_register');
                // Social login switch options

                $twitter_login = isset($wp_rem_plugin_options['wp_rem_twitter_api_switch']) ? $wp_rem_plugin_options['wp_rem_twitter_api_switch'] : '';
                $facebook_login = isset($wp_rem_plugin_options['wp_rem_facebook_login_switch']) ? $wp_rem_plugin_options['wp_rem_facebook_login_switch'] : '';
                $google_login = isset($wp_rem_plugin_options['wp_rem_google_login_switch']) ? $wp_rem_plugin_options['wp_rem_google_login_switch'] : '';

                $output_html .= '<div class="flex-user-form">';
                $output_html .= do_action('login_form', array( 'form_rand_id' => $rand_id ));
                $output_html .= ob_get_clean();

                if ( $isRegistrationOn && ($twitter_login == 'on' || $facebook_login == 'on' || $google_login == 'on') ) {
                    
                }

                if ( is_user_logged_in() ) {
                    $output_html .='<script>'
                            . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_id) . ', input#user_pass' . absint($rand_id) . '", function (e) {
                                        if (e.which == "13") {
                                            show_alert_msg("' . wp_rem_plugin_text_srt('wp_rem_register_logout_first') . '");
                                            return false;
                                        }
                                });'
                            . '</script>';
                } else {
                    $output_html .='<script>'
                            . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_id) . ', input#user_pass' . absint($rand_id) . '", function (e) {
                                    if (e.which == "13") {
                                        wp_rem_user_authentication("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_id) . '", \'.ajax-login-button\');
                                        return false;
                                    }
                                });'
                            . '</script>';
                }

                $output_html .='<form method="post" class="wp-user-form webkit" id="ControlForm_' . $rand_id . '">';
                if ( $wp_rem_demo_user_login_switch == 'on' ) {
                    $demo_user_password = esc_html('demo123');
                    $wp_rem_demo_member_detail = get_user_by('id', $wp_rem_demo_user_member);
                    $wp_rem_demo_agency_detail = get_user_by('id', $wp_rem_demo_user_agency);
                    require_once( ABSPATH . 'wp-includes/class-phpass.php');
                    $wp_hasher = new PasswordHash(8, TRUE);
                    if ( ! (isset($wp_rem_demo_member_detail->user_pass) && $wp_hasher->CheckPassword($demo_user_password, $wp_rem_demo_member_detail->user_pass)) ) {
                        wp_set_password($demo_user_password, $wp_rem_demo_user_member);
                    }
                    if ( ! (isset($wp_rem_demo_agency_detail->user_pass) && $wp_hasher->CheckPassword($demo_user_password, $wp_rem_demo_agency_detail->user_pass)) ) {
                        wp_set_password($demo_user_password, $wp_rem_demo_user_agency);
                    }
                    $wp_rem_demo_member_detail_user = isset($wp_rem_demo_member_detail->user_login) ? $wp_rem_demo_member_detail->user_login : '';
                    $wp_rem_demo_agency_detail_user = isset($wp_rem_demo_agency_detail->user_login) ? $wp_rem_demo_agency_detail->user_login : '';
                    $output_html .='<div class="cs-demo-login">';
                    $output_html .='<div class="cs-demo-login-lable">' . wp_rem_plugin_text_srt('wp_rem_register_login_demo');
                    $output_html .= '</div>';
                    $output_html .= '<ul class="login-switches">';
                    $output_html .= '<li>';
                    $output_html .= '<a class="demo-login-agency-' . $rand_id . '" href="javascript:void(0)" onclick="javascript:wp_rem_demo_user_login(\'' . $wp_rem_demo_agency_detail_user . '\',\'.demo-login-agency-' . $rand_id . '\')" '
                            . '><i class="icon-location_city"></i>' . wp_rem_plugin_text_srt('wp_rem_register_login_demo_user')
                            . '</a>';
                    $output_html .= '</li>';
                    $output_html .= '</ul>';


                    $output_html .='</div>';
                    $output_html .='<script>
                        function wp_rem_demo_user_login(user, buttonloader) {
                            jQuery("#user_login' . $rand_id . '" ).val(user);
                            jQuery("#user_pass' . $rand_id . '" ).val("' . $demo_user_password . '");
                            wp_rem_user_authentication(\'' . admin_url("admin-ajax.php") . '\',\'' . $rand_id . '\',buttonloader);
                        }
                    </script>';
                }



                $output_html .='<div class="input-filed">';
                $output_html .='<i class="icon- icon-user4"></i>';
                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => '',
                    'cust_id' => 'user_login' . $rand_id,
                    'cust_name' => 'user_login',
                    'classes' => 'form-control',
                    'extra_atr' => ' tabindex="11" placeholder="' . wp_rem_plugin_text_srt('wp_rem_member_username') . '"',
                    'return' => true,
                );
                $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                $output_html .='</div>';

                $output_html .='<div class="input-filed">';
                $output_html .='<i class="icon- icon-lock4"></i>';
                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => wp_rem_plugin_text_srt('wp_rem_register_password'),
                    'cust_id' => 'user_pass' . $rand_id,
                    'cust_name' => 'user_pass',
                    'cust_type' => 'password',
                    'classes' => 'form-control',
                    'extra_atr' => ' tabindex="12" size="20" onfocus="if(this.value ==\'' . wp_rem_plugin_text_srt('wp_rem_register_password') . '\') { this.value = \'\'; }" onblur="if(this.value == \'\') { this.value =\'' . wp_rem_plugin_text_srt('wp_rem_register_password') . '\'; }"',
                    'return' => true,
                );
                $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                $output_html .='</div>';
                $output_html .='<div class="input-holder">
                                                        <div class="check-box-remind">
                                                            <input class="input-field" type="checkbox" id="remember">
                                                            <label for="remember">' . wp_rem_plugin_text_srt('wp_rem_login_register_remember_me') . '</label>
                                                        </div>
                                                    </div>';
                if ( is_user_logged_in() ) {
                    $output_html .='<div class="input-filed">';
                    $wp_rem_opt_array = array(
                        'std' => wp_rem_plugin_text_srt('wp_rem_register_login'),
                        'cust_name' => 'user-submit',
                        'cust_type' => 'button',
                        'classes' => 'cs-bgcolor',
                        'extra_atr' => ' onclick="javascript:show_alert_msg(\'' . wp_rem_plugin_text_srt('wp_rem_register_logout_first') . '\')"',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                    $output_html .= '</div>';
                } else {
                    $output_html .='<div class="input-filed">';
                    $output_html .='<div class="ajax-login-button input-button-loader">';
                    $wp_rem_opt_array = array(
                        'std' => wp_rem_plugin_text_srt('wp_rem_register_login'),
                        'cust_name' => 'user-submit',
                        'cust_type' => 'button',
                        'classes' => 'cs-bgcolor',
                        'extra_atr' => ' onclick="javascript:wp_rem_user_authentication(\'' . admin_url("admin-ajax.php") . '\', \'' . $rand_id . '\', \'.ajax-login-button\')"',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                    $wp_rem_opt_array = array(
                        'id' => '',
                        'std' => get_permalink(),
                        'cust_id' => 'redirect_to',
                        'cust_name' => 'redirect_to',
                        'cust_type' => 'hidden',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                    $wp_rem_opt_array = array(
                        'id' => '',
                        'std' => '1',
                        'cust_id' => 'user-cookie',
                        'cust_name' => 'user-cookie',
                        'cust_type' => 'hidden',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                    $wp_rem_opt_array = array(
                        'id' => '',
                        'std' => 'ajax_login',
                        'cust_name' => 'action',
                        'cust_type' => 'hidden',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                    $wp_rem_opt_array = array(
                        'id' => '',
                        'std' => 'login',
                        'cust_id' => 'login',
                        'cust_name' => 'login',
                        'cust_type' => 'hidden',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                    $wp_rem_opt_array = array(
                        'id' => '',
                        'std' => get_the_permalink(),
                        'cust_id' => 'login-redirect-page',
                        'cust_name' => 'login-redirect-page',
                        'cust_type' => 'hidden',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                    $output_html .= '
				</div>
			</div>';
                }
                $output_html .='<div class="forget-password"><i class="icon-help"></i><a data-id="' . $rand_id . '" class="cs-forgot-switch">' . wp_rem_plugin_text_srt('wp_rem_register_forgot_password') . '</a></div>';
                $output_html .='</form>';
                $output_html .= '</div>';
                $output_html .= '</div>';
                $output_html .= '</div>'; // end flex-user-form


                $output_html .= '</div>';
                //End Signin Tab
                // Signup Tab
                $output_html .= '<div id="user-register-' . $rand_id . '" class="tab-pane fade">';

                $output_html .= $this->wp_rem_registration_tab($rand_id);

                $output_html .='
                </div>';
                //End Signup Tab
                //Forgot Password Tab
                $output_html .='<div id="user-password' . $rand_id . '" class="tab-pane fade">';


                $output_html .='
                </div>';
                //End Password Tab


                $output_html .= '</div>';

                $output_html .='
                </div>';

                $output_html .='
                </div>';

                $output_html .='
            </div></div>';
                $data = get_transient('social_data');
                delete_transient('social_data');
                if ( $data != false ) {
                    ob_start();
                    $status_message = wp_rem_plugin_text_srt('wp_rem_register_sorry') . ' ' . ucfirst($data['social_login_provider']) . ' ' . wp_rem_plugin_text_srt('wp_rem_register_sorry_text');
                    if ( isset($data['user_email']) && ! empty($data['user_email']) ) {
                        $status_message = wp_rem_plugin_text_srt('wp_rem_login_register_confirm_below_info_for_register');
                    }
                    ?>
                    <script type="text/javascript">
                        (function ($) {
                            $(function () {
                                var rand_id = window.rand_id_registration;
                                $("input[name='user_login" + rand_id + "']").val('<?php echo esc_html($data['user_login']); ?>');
                                $("input[name='wp_rem_display_name" + rand_id + "']").val('<?php echo esc_html($data['first_name']) . ' ' . esc_html($data['last_name']); ?>');
                                $("input[name='wp_rem_user_email" + rand_id + "']").val('<?php echo esc_html($data['user_email']); ?>');
                                $(".status-message").addClass('text-danger').html('<?php echo esc_html($status_message); ?>');
                                $("#signin-role").after('<input type="hidden" name="social_meta_key" value="<?php echo esc_html($data['social_meta_key']); ?>">');
                                $("#signin-role").after('<input type="hidden" name="social_meta_value" value="<?php echo esc_html($data['social_meta_value']); ?>">');
                                $(".wp-rem-open-register-button").click();
                            });
                        })(jQuery);
                    </script>

                    <?php
                    $output_html .= ob_get_clean();
                }

                $this->LOGIN_OUTPUT = $output_html;

                $this->wp_rem_popup_into_footer();
            }
            return $output;
        }

        public function wp_rem_registration_tab($rand_id = '') {
            global $wp_rem_form_fields_frontend, $wp_rem_html_fields, $wp_rem_plugin_options;
            $wp_rem_captcha_switch = '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
            $output_html = '';
            $role = '';
            $register_text = '';
            $user_disable_text = wp_rem_plugin_text_srt('wp_rem_login_register_disabled');
            $content = '';
            $output_html .= '<div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"><i class="icon- icon-close2"></i></span> </button>
                                                   
                                         
                                            </div>';
            $output_html .='<div class="modal-body">';
            $isRegistrationOn = get_option('users_can_register');
            $popup_register_rand_divids = rand(0, 999999);
            if ( $isRegistrationOn ) {

                $rand_ids = rand(0, 999999);

                $rand_ids = $rand_id;

                // popup registration forms
                // popup member registration form
                $output_html .='<div id="member' . $popup_register_rand_divids . '" role="tabpanel" class="tab-pane active">';
                $output_html .= '<div id="result_' . $rand_ids . '" class="status-message"></div>';
                $output_html .='<script>'
                        . 'window.rand_id_registration = \'' . $rand_ids . '\';
                        jQuery("body").on("keypress", "input#wp_rem_company_name' . absint($rand_ids) . ', input#user_login_' . absint($rand_ids) . ', input#wp_rem_display_name' . absint($rand_ids) . ', input#wp_rem_user_email' . absint($rand_ids) . '", function (e) {
                                                                            if (e.which == "13") {
                                                                                    wp_rem_registration_validation("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_ids) . '", \'.ajax-signup-button\');
                                                                                    return false;
                                                                            }
                                                                            });'
                        . '</script>';
                ob_start();
                $output_html .= '<div class="flex-user-form">';
                if ( class_exists('wp_rem') ) {
                    $output_html .= do_action('login_form', array( 'form_rand_id' => $rand_id ));
                }
                $output_html .= ob_get_clean();
                $key = wp_rem_get_input('key', NULL, 'STRING');
                if ( $key != NULL ) {
                    $key_data = get_option($key);
                    $output_html .= '<script>jQuery(document).ready(function($){$("#join-us").modal("show")}); </script>';
                }

                $output_html .='<form method="post" class="wp-user-form demo_test aaa" id="wp_signup_form_' . $rand_ids . '" enctype="multipart/form-data">';

                $output_html .='<div class="input-filed wp-rem-profile-type-display">';
                $output_html .='<i class="icon-business_center"></i>';
                $wp_rem_opt_array = array(
                    'std' => '',
                    'classes' => 'chosen-select-no-single wp_rem_profile_type',
                    'id' => 'wp_rem_profile_type' . $rand_ids,
                    'options' => array(
                        'individual' => wp_rem_plugin_text_srt('wp_rem_member_profile_individual'),
                        'company' => wp_rem_plugin_text_srt('wp_rem_member_profile_company'),
                    ),
                    'return' => true,
                    'description' => '',
                    'cust_name' => 'wp_rem_profile_type' . $rand_ids . '',
                    'extra_atr' => ' data-placeholder="' . wp_rem_plugin_text_srt('wp_rem_member_member_type') . '"',
                );
                $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array);
                $output_html .= '<script type="text/javascript">
                        chosen_selectionbox();
                    </script>';
                $output_html .='</div>';

                $output_html .='<div class="input-filed">';
                $output_html .='<i class="icon- icon-user"></i>';
                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => '',
                    'cust_id' => 'user_login_' . $rand_ids,
                    'cust_name' => 'user_login' . $rand_ids,
                    'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_username') . '"',
                    'classes' => '',
                    'return' => true,
                );
                $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                $output_html .= '
                                </div>';


                if ( $key == NULL ) {
                    $output_html .='<div class="input-filed wp-rem-company-name" style="display:none;">';
                    $output_html .=' <i class="icon-business_center"></i>';
                    $output_html .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                            array( 'name' => wp_rem_plugin_text_srt('wp_rem_register_company_name'),
                                'id' => 'company_name' . $rand_ids,
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_company_name') . '"',
                                'std' => '',
                                'return' => true,
                            )
                    );
                    $output_html .= '</div>';
                }

                if ( $key == NULL ) {
                    $output_html .='<div class="input-filed display-name-field">';
                    $output_html .='<i class="icon-user-fancy"></i>';
                    $output_html .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                            array( 'name' => wp_rem_plugin_text_srt('wp_rem_register_display_name'),
                                'id' => 'display_name' . $rand_ids,
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_display_name') . '"',
                                'std' => '',
                                'return' => true,
                            )
                    );
                    $output_html .= '</div>';
                }
                $member_title = isset($wp_rem_plugin_options['member_title']) ? $wp_rem_plugin_options['member_title'] : '';
                $member_value = isset($wp_rem_plugin_options['member_value']) ? $wp_rem_plugin_options['member_value'] : '';
                $member_type_array = array();
                $checked = '';
                $total_count = count($member_value);
                if ( $total_count > 0 ) {
                    for ( $a = 0; $a < $total_count; $a ++ ) {
                        if ( isset($member_title[$a]) && $member_value[$a] ) {
                            $member_type_array[$member_value[$a]] = $member_title[$a];
                        }
                    }
                }
                if ( ! empty($member_type_array) ) {
                    $output_html .='<div class="input-filed member-type-field" style="display:none;">';
                    $output_html .='<i class="icon- icon-envelope3"></i>';
                    $wp_rem_opt_array = array(
                        'std' => '',
                        'classes' => 'chosen-single',
                        'id' => 'member_type' . $rand_ids,
                        'options' => $member_type_array,
                        'return' => true,
                        'description' => '',
                        'name' => '',
                        'extra_atr' => ' data-placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_member_type') . '"',
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_multiselect_render($wp_rem_opt_array);
                    $output_html .= '</div>';
                }
                $output_html .= '<script>jQuery(window).load(function($){'
                        . 'if (jQuery(".chosen-select, .chosen-select-deselect, .chosen-select-no-single, .chosen-select-no-results, .chosen-select-width").length != "") {
                                var config = {
                                    ".chosen-select": {
                                        width: "100%"
                                    },
                                    ".chosen-select-deselect": {
                                        allow_single_deselect: true
                                    },
                                    ".chosen-select-no-single": {
                                        disable_search_threshold: 10,
                                        width: "100%",
                                        search_contains: true
                                    },
                                    ".chosen-select-no-results": {
                                        no_results_text: "Oops, nothing found!"
                                    },
                                    ".chosen-select-width": {
                                        width: "95%"
                                    }
                                };
                                for (var selector in config) {
                                    jQuery(selector).chosen(config[selector]);
                                }
                            }'
                        . '}); </script>';

                $output_html .='<div class="input-filed">';
                $output_html .='<i class="icon- icon-envelope3"></i>';
                $readonly = ( isset($key_data['email']) ) ? 'readonly' : '';
                $output_html .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array( 'name' => wp_rem_plugin_text_srt('wp_rem_register_email'),
                            'id' => 'user_email' . $rand_ids,
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_email') . '"' . $readonly . '',
                            'std' => ( isset($key_data['email']) ) ? $key_data['email'] : '',
                            'return' => true,
                        )
                );
                $output_html .= '</div>';

                $output_html .=$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                        array( 'name' => wp_rem_plugin_text_srt('wp_rem_login_register_user_role_type'),
                            'id' => 'user_role_type' . $rand_ids,
                            'classes' => 'input-holder',
                            'std' => 'member',
                            'description' => '',
                            'return' => true,
                            'hint' => '',
                            'icon' => 'icon-user9'
                        )
                );

                $output_html .='<div class="side-by-side select-icon clearfix">';
                $output_html .='<div class="select-holder">';

                $output_html .='</div>';
                $output_html .='</div>';


                if ( $wp_rem_captcha_switch == 'on' && ( ! is_user_logged_in()) ) {
                    if ( $wp_rem_sitekey <> '' and $wp_rem_secretkey <> '' and ! is_user_logged_in() ) {
                        wp_rem_google_recaptcha_scripts();
                        ?>
                        <script>
                            var recaptcha10;
                            var wp_rem_multicap = function () {
                                //Render the recaptcha1 on the element with ID "recaptcha1"
                                recaptcha10 = grecaptcha.render('recaptcha10', {
                                    'sitekey': '<?php echo ($wp_rem_sitekey); ?>', //Replace this with your Site key
                                    'theme': 'light'
                                });

                            };
                        </script>
                        <?php
                    }
                    if ( class_exists('Wp_rem_Captcha') ) {
                        global $Wp_rem_Captcha;
                        $output_html .='<div class="recaptcha-reload" id="recaptcha10_div">';
                        $output_html .= $Wp_rem_Captcha->wp_rem_generate_captcha_form_callback('recaptcha10', 'true');
                        $output_html .='</div>';
                    }
                }
                $output_html .= '<div class="checks-holder">';
                ob_start();
                $output_html .= do_action('register_form');
                $output_html .= ob_get_clean();
                $wp_rem_rand_id = rand(122, 1545464897);

                $output_html .= '<div class="input-filed">';
                $output_html .= '<div class="ajax-signup-button-' . $rand_id . ' input-button-loader">';
                $wp_rem_opt_array = array(
                    'std' => wp_rem_plugin_text_srt('wp_rem_register_signup'),
                    'cust_id' => 'submitbtn' . $wp_rem_rand_id,
                    'cust_name' => 'user-submit',
                    'cust_type' => 'button',
                    'classes' => 'user-submit cs-bgcolor acc-submit',
                    'extra_atr' => ' tabindex="103" onclick="javascript:wp_rem_registration_validation(\'' . admin_url("admin-ajax.php") . '\', \'' . $rand_ids . '\', \'.ajax-signup-button-' . $rand_id . '\')"',
                    'return' => true,
                );
                $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => $role,
                    'cust_id' => 'signin-role',
                    'cust_name' => 'role',
                    'cust_type' => 'hidden',
                    'return' => true,
                );
                $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => 'wp_rem_registration_validation',
                    'cust_name' => 'action',
                    'cust_type' => 'hidden',
                    'return' => true,
                );
                $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                if ( $key != NULL ) {
                    $wp_rem_opt_array = array(
                        'id' => '',
                        'std' => $key,
                        'cust_name' => 'key',
                        'cust_type' => 'hidden',
                        'return' => true,
                    );
                    $output_html .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                }

                $output_html .= '</div>';
                $output_html .= '</div>';
                $output_html .= '</div>';

                $output_html .= '</form>
                                        <div class="register_content">' . do_shortcode($content . $register_text) . '</div>';

                $output_html .='</div>';
                $output_html .='</div>'; //end flex-user-form
            } else {
                $output_html .='<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 register-page">
                                            <div class="cs-user-register">
                                                <div class="element-title">
                                                       <h2>' . wp_rem_plugin_text_srt('wp_rem_register_register') . '</h2>
                                               </div>
                                               <p>' . $user_disable_text . '</p>
                                            </div>
                                        </div>
                                </div>';
                $output_html .='</div>';
            }
            $output_html .= '</div>';
            return $output_html;
        }

        public function wp_rem_registration_popup() {
            global $wp_rem_form_fields_frontend, $wp_rem_html_fields;
            $rand_id = rand(0, 999999);
            echo $rand_id;
            $output = '';
            $user_disable_text = wp_rem_plugin_text_srt('wp_rem_login_register_disabled');
            $output .= '<div class="modal fade" id="join-us' . $rand_id . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                              <div class="modal-dialog" role="document">
                              <div class="login-form">
                                <div class="modal-content">
                                
                                  <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                                   
                                    </div>';
            $output .= '<div class="modal-body">';
            $isRegistrationOn = get_option('users_can_register');
            $popup_register_rand_divids = rand(0, 999999);
            if ( $isRegistrationOn ) {

                $rand_ids = rand(0, 999999);

                // popup registration forms
                $output .='<div class="tab-content">';

                // popup member registration form
                $output .='<div id="member' . $popup_register_rand_divids . '" role="tabpanel" class="tab-pane active">';
                $output .= '<div id="result_' . $rand_ids . '" class="status-message"></div>';
                $output .='<script>'
                        . 'jQuery("body").on("keypress", "input#wp_rem_company_name' . absint($rand_ids) . ', input#user_login_' . absint($rand_ids) . ', input#wp_rem_display_name' . absint($rand_ids) . ', input#wp_rem_user_email' . absint($rand_ids) . '", function (e) {
				if (e.which == "13") {
						wp_rem_registration_validation("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_ids) . '", \'.ajax-signup-button\', \'.ajax-signup-button\');
						return false;
				}
				});'
                        . '</script>';
                ob_start();
                if ( class_exists('wp_rem') ) {
                    $output .= do_action('login_form');
                }
                $output .= ob_get_clean();
                $output .='<form method="post" class="wp-user-form demo_test" id="wp_signup_form_' . $rand_ids . '" enctype="multipart/form-data">';
                $output .='<div class="input-filed">';
                $key = wp_rem_get_input('key', NULL, 'STRING');
                if ( $key != NULL ) {

                    $key_data = get_option($key);
                }
                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => '',
                    'cust_id' => 'user_login_' . $rand_ids,
                    'cust_name' => 'user_login' . $rand_ids,
                    'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_member_username') . '"',
                    'classes' => 'form-control',
                    'return' => true,
                );
                $output .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                $output .= '
                        </div>';

                $output .='<div class="input-filed">';
                $output .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array( 'name' => wp_rem_plugin_text_srt('wp_rem_register_display_name'),
                            'id' => 'display_name' . $rand_ids,
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_display_name') . '"',
                            'std' => '',
                            'return' => true,
                        )
                );
                $output .= '</div>';
                if ( $key == NULL ) {
                    $output .='<div class="input-filed">';
                    $output .=' <i class="icon- icon-user"></i>';
                    $output .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                            array( 'name' => wp_rem_plugin_text_srt('wp_rem_member_company_name'),
                                'id' => 'company_name' . $rand_ids,
                                'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_member_company_name') . '"',
                                'std' => '',
                                'return' => true,
                            )
                    );
                    $output .= '</div>';
                }

                $output .='<div class="input-filed">';
                $readonly = ( isset($key_data['email']) ) ? 'readonly' : '';
                $output .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array( 'name' => wp_rem_plugin_text_srt('wp_rem_register_email'),
                            'id' => 'user_email' . $rand_ids,
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_email') . '"' . $readonly . '',
                            'std' => ( isset($key_data['email']) ) ? $key_data['email'] : '',
                            'return' => true,
                        )
                );
                $output .= '</div>';

                $output .='<div class="input-filed">';
                $output .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array( 'name' => wp_rem_plugin_text_srt('wp_rem_register_password'),
                            'id' => 'user_password' . $rand_ids,
                            'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_password') . '"',
                            'std' => '',
                            'cust_type' => 'password',
                            'return' => true,
                        )
                );
                $output .= '</div>';


                $output .=$wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
                        array( 'name' => wp_rem_plugin_text_srt('wp_rem_login_register_user_role_type'),
                            'id' => 'user_role_type' . $rand_ids,
                            'classes' => 'input-holder',
                            'std' => 'member',
                            'description' => '',
                            'return' => true,
                            'hint' => '',
                            'icon' => 'icon-user9'
                        )
                );

                $output .='<div class="side-by-side select-icon clearfix">';
                $output .='<div class="select-holder">';

                $output .='</div>';
                $output .='</div>';
                $output .='<div class="input-filed phone">';
                $output .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array( 'name' => wp_rem_plugin_text_srt('property_contact_phone'),
                            'id' => 'phone_no' . $rand_ids,
                            'std' => '',
                            'extra_atr' => ' placeholder=" ' . wp_rem_plugin_text_srt('property_contact_phone') . '"',
                            'return' => true,
                        )
                );
                $output .='</div>';
                if ( $wp_rem_captcha_switch == 'on' && ( ! is_user_logged_in()) ) {
                    if ( class_exists('Wp_rem_Captcha') ) {
                        global $Wp_rem_Captcha;
                        $output .='<div class="col-md-12 recaptcha-reload" id="recaptcha5_div">';
                        $output .= $Wp_rem_Captcha->wp_rem_generate_captcha_form_callback('recaptcha5', 'true');
                        $output .='</div>';
                    }
                }
                $output .= '<div class="checks-holder">';
                ob_start();
                $output .= do_action('register_form');
                $output .= ob_get_clean();
                $wp_rem_rand_id = rand(122, 1545464897);
                $output .= '<div class="input-filed">';
                $output .= '<div class="ajax-signup-button input-button-loader">';
                $wp_rem_opt_array = array(
                    'std' => wp_rem_plugin_text_srt('wp_rem_register_signup'),
                    'cust_id' => 'submitbtn' . $wp_rem_rand_id,
                    'cust_name' => 'user-submit',
                    'cust_type' => 'button',
                    'classes' => 'user-submit cs-bgcolor acc-submit',
                    'extra_atr' => ' tabindex="103" onclick="javascript:wp_rem_registration_validation(\'' . admin_url("admin-ajax.php") . '\',\'' . $rand_ids . '\',\'.ajax-signup-button\')"',
                    'return' => true,
                );
                $output .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => $role,
                    'cust_id' => 'signin-role',
                    'cust_name' => 'role',
                    'cust_type' => 'hidden',
                    'return' => true,
                );
                $output .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                $wp_rem_opt_array = array(
                    'id' => '',
                    'std' => 'wp_rem_registration_validation',
                    'cust_name' => 'action',
                    'cust_type' => 'hidden',
                    'return' => true,
                );
                $output .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);

                if ( $key != NULL ) {
                    $wp_rem_opt_array = array(
                        'id' => '',
                        'std' => $key,
                        'cust_name' => 'key',
                        'cust_type' => 'hidden',
                        'return' => true,
                    );
                    $output .= $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                }

                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

                $output .= '</form>
                                <div class="register_content">' . do_shortcode($content . $register_text) . '</div>';
                $output .='</div>';

                $output .='</div>';
            } else {
                $output .='<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 register-page">
                                <div class="cs-user-register">
                                    <div class="element-title">
                                           <h2>' . wp_rem_plugin_text_srt('wp_rem_register_register') . '</h2>
                                   </div>
                                   <p>' . $user_disable_text . '</p>
                                </div>
                            </div>
                        </div>';
                $output .='</div>';
            }
            $output .= '</div>';
            $output .= '</div>';

            $output .= '
                      </div></div>
                                </div>
                          ';

            echo $output;
        }

        /*
         * Calling Footer Hook
         */

        public function wp_rem_popup_into_footer() {
            add_action('wp_footer', array( $this, 'wp_rem_footer_callback' ));
        }

        /*
         * Outputting Signin and Registration Popups into footer
         */

        public function wp_rem_footer_callback() {
            echo $this->LOGIN_OUTPUT;
            echo $this->REGISTER_OUTPUT;
        }

        public function wp_rem_dashboar_top_menu_url($url_param = '') {
            $pageid = get_the_ID();
            $final_url = '';
            $dashboard_page_link = wp_rem_user_dashboard_page_url('id');
            $dashboard_url_off = 0;
            if ( $dashboard_page_link == $pageid ) {
                $dashboard_url_off = 1;
            }
            if ( $url_param != '' ) {
                $url_param = '?' . $url_param;
            }
            if ( $dashboard_url_off == 1 ) {
                $final_url = 'javascript:void(0);';
            } else {
                $dashboard_page_link = wp_rem_user_dashboard_page_url('url');
                $final_url = ( $dashboard_page_link . $url_param );
            }

            return $final_url;
        }

        /**
         * Start Function how to add user profile menu in top position
         */
        public function wp_rem_profiletop_menu($uid = '', $header_view = '') {
            global $post, $cs_plugin_options, $current_user, $wp_roles, $userdata, $wp_rem_member_profile, $wp_rem_plugin_options;
            if ( is_user_logged_in() ) {

                $menu_cls = '';

                $uid = (isset($uid) and $uid <> '') ? $uid : $current_user->ID;
                $user_display_name = get_the_author_meta('display_name', $uid);
                $cs_page_id = isset($cs_theme_options['cs_dashboard']) ? $cs_theme_options['cs_dashboard'] : '';
                $user_company = get_user_meta($uid, 'wp_rem_company', true);
                $fullName = isset($user_company) && $user_company != '' ? get_the_title($user_company) : '';
                if ( is_super_admin() ) {
                    $fullName = $userdata->display_name;
                }
                if ( strlen($fullName) > 10 ) {
                    $fullName = substr($fullName, 0, 10) . "...";
                }
                $wp_rem_profile_image = $wp_rem_member_profile->member_get_profile_image($uid);
                $wp_rem_user_type = get_user_meta($current_user->ID, 'wp_rem_user_type', true);
                $member_profile_type = get_post_meta($user_company, 'wp_rem_member_profile_type', true);
                $user_roles = isset($current_user->roles) ? $current_user->roles : '';
                $dashboard_page_link = wp_rem_user_dashboard_page_url();
                $wp_rem_property_add_url = $dashboard_page_link != '' ? add_query_arg(array( 'tab' => 'add-property' ), $dashboard_page_link) : '#';

                if ( $wp_rem_profile_image == '' ) {
                    $wp_rem_profile_image = wp_rem::plugin_url() . '/assets/frontend/images/member-no-image.jpg';
                }
                ?>
                <div class="user-dashboard-menu">
                    <ul>
                        <li class="user-dashboard-menu-children">
                            <a href="">
                                <?php
                                if ( $wp_rem_profile_image != '' ) {
                                    if ( is_numeric($wp_rem_profile_image) ) {
                                        $wp_rem_profile_image = wp_get_attachment_url($wp_rem_profile_image);
                                    }
                                    echo '<div class="img-holder"><figure class="profile-image"><img src="' . esc_url($wp_rem_profile_image) . '" alt="' . wp_rem_plugin_text_srt('wp_rem_member_profile_image') . '"></figure></div>';
                                }

                                if ( $header_view != 'advance_v2' ) {
                                    ?>
                                    <span class="user-full-name"><?php echo esc_html($fullName) ?></span>
                                    <i class="icon-caret-down"></i>
                                <?php } ?>
                            </a>
                            <?php if ( ($user_roles != '' && in_array("wp_rem_member", $user_roles) ) ) {
                                ?>
                                <ul>
                                    <?php if ( true === Wp_rem_Member_Permissions::check_permissions('properties') ) { ?>
                                            <!--<li class="user-add-property"><a href="<?php echo esc_url_raw($wp_rem_property_add_url) ?>" ><i class="icon-add-properties"></i> <?php echo wp_rem_plugin_text_srt('wp_rem_login_register_add_new_add'); ?> </a></li>-->
                                        <?php
                                    }
                                    $dashboard_url = '';
                                    $dashboard_url = $this->wp_rem_dashboar_top_menu_url();
                                    if ( isset($dashboard_url) && $dashboard_url != '' ) {
                                        $dashboard_url = $dashboard_url;
                                    } else {
                                        $dashboard_url = 'javascript:void(0)';
                                    }
                                    ?>
                                    <li class="user_dashboard_ajax active" id="wp_rem_member_suggested" data-queryvar="dashboard=suggested"><a href="<?php echo wp_rem_allow_special_char($dashboard_url); ?>"><i class="icon-dashboard"></i><?php echo wp_rem_plugin_text_srt('wp_rem_login_register_dashboard') ?></a></li>
                                    <?php
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('properties') ) {
                                        $properties_url = '';
                                        $properties_url = $this->wp_rem_dashboar_top_menu_url('dashboard=properties');
                                        if ( isset($properties_url) && $properties_url != '' ) {
                                            $properties_url = $properties_url;
                                        } else {
                                            $properties_url = 'javascript:void(0)';
                                        }
                                        ?>
                                        <li class="user_dashboard_ajax" id="wp_rem_member_properties" data-queryvar="dashboard=properties"><a href="<?php echo wp_rem_allow_special_char($properties_url); ?>"><i class="icon-megaphone2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_properties_properties') ?></a></li>
                                        <?php
                                    }
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('enquiries') ) {
                                        $inquiries_url = '';
                                        $enquiries_url = $this->wp_rem_dashboar_top_menu_url('dashboard=enquiries');
                                        if ( isset($enquiries_url) && $enquiries_url != '' ) {
                                            $enquiries_url = $enquiries_url;
                                        } else {
                                            $enquiries_url = 'javascript:void(0)';
                                        }
                                        ?>
                                        <li class="user_dashboard_ajax" id="wp_rem_member_enquiries" data-queryvar="dashboard=enquiries"><a href="<?php echo wp_rem_allow_special_char($enquiries_url); ?>"><i class="icon-question_answer"></i><?php echo wp_rem_plugin_text_srt('wp_rem_login_register_enquiries') ?></a></li>
                                        <?php
                                    }

                                    if ( true === Wp_rem_Member_Permissions::check_permissions('arrange_viewings') ) {
                                        $inquiries_url = '';
                                        $arrange_viewings_url = $this->wp_rem_dashboar_top_menu_url('dashboard=viewings');
                                        if ( isset($arrange_viewings_url) && $arrange_viewings_url != '' ) {
                                            $arrange_viewings_url = $arrange_viewings_url;
                                        } else {
                                            $arrange_viewings_url = 'javascript:void(0)';
                                        }
                                        ?>
                                        <li class="user_dashboard_ajax" id="wp_rem_member_viewings" data-queryvar="dashboard=viewings"><a href="<?php echo wp_rem_allow_special_char($arrange_viewings_url); ?>"><i class="icon-layers3"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_register_arrange_viewings') ?></a></li>
                                        <?php
                                    }

                                    $search_alerts_url = '';
                                    $favourite_url = '';
                                    // search & alerts link for login shortcode.
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('alerts') ) {
                                        $search_alerts_url = $this->wp_rem_dashboar_top_menu_url('dashboard=alerts');
                                        echo do_action('wp_rem_top_menu_member_dashboard', wp_rem_plugin_text_srt('wp_rem_login_register_alerts_searches'), '<i class="icon-save"></i>', $search_alerts_url);
                                    }

                                    // Favourites link for login shortcode.
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('favourites') ) {
                                        $favourite_url = $this->wp_rem_dashboar_top_menu_url('dashboard=favourites');
                                        echo do_action('wp_rem_top_menu_favourites_dashboard', wp_rem_plugin_text_srt('wp_rem_login_register_favourite_properties'), '<i class="icon-heart5"></i>', $favourite_url);
                                    }
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('packages') ) {
                                        $package_url = $this->wp_rem_dashboar_top_menu_url('dashboard=packages');
                                        if ( isset($package_url) && $package_url != '' ) {
                                            $package_url = $package_url;
                                        } else {
                                            $package_url = 'javascript:void(0)';
                                        }
                                        ?>
                                        <li class="user_dashboard_ajax" id="wp_rem_member_packages" data-queryvar="dashboard=packages"><a href="<?php echo wp_rem_allow_special_char($package_url); ?>"><i class="icon-dropbox2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_packages') ?></a></li>
                                        <?php
                                    }
									
									$notes_url = $this->wp_rem_dashboar_top_menu_url('dashboard=prop_notes');
									if ( isset($notes_url) && $notes_url != '' ) {
										$notes_url = $notes_url;
									} else {
										$notes_url = 'javascript:void(0)';
									}
									$hidden_property_url = $this->wp_rem_dashboar_top_menu_url('dashboard=hidden_properties');
									if ( isset($hidden_property_url) && $hidden_property_url != '' ) {
										$hidden_property_url = $hidden_property_url;
									} else {
										$hidden_property_url = 'javascript:void(0)';
									}
									?>
									<li class="user_dashboard_ajax" id="wp_rem_member_prop_notes" data-queryvar="dashboard=prop_notes"><a href="<?php echo wp_rem_allow_special_char($notes_url); ?>"><i class="icon-book2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_prop_notes_notes') ?></a></li>
									<li class="user_dashboard_ajax" id="wp_rem_member_hidden_properties" data-queryvar="dashboard=hidden_properties"><a href="<?php echo wp_rem_allow_special_char($hidden_property_url); ?>"><i class="icon-block"></i><?php echo wp_rem_plugin_text_srt('wp_rem_hidden_properties') ?></a></li>
									<?php
                                    if ( true === Wp_rem_Member_Permissions::check_permissions('company_profile') ) {
                                        $company_profile_url = '';
                                        $company_profile_url = $this->wp_rem_dashboar_top_menu_url('dashboard=account');
                                        if ( isset($company_profile_url) && $company_profile_url != '' ) {
                                            $company_profile_url = $company_profile_url;
                                        } else {
                                            $company_profile_url = 'javascript:void(0)';
                                        }
                                        ?>
                                        <li class="user_dashboard_ajax" id="wp_rem_member_accounts" data-queryvar="dashboard=account"><a href="<?php echo wp_rem_allow_special_char($company_profile_url); ?>"><i class="icon-tools2"></i><?php echo wp_rem_plugin_text_srt('wp_rem_user_meta_my_profile') ?></a></li>
                                    <?php } ?>

                                    <?php
                                    if ( $member_profile_type == 'company' && $wp_rem_user_type == 'supper-admin' ) {
                                        $team_members_url = '';
                                        $team_members_url = $this->wp_rem_dashboar_top_menu_url('dashboard=team_members');
                                        if ( isset($team_members_url) && $team_members_url != '' ) {
                                            $team_members_url = $team_members_url;
                                        } else {
                                            $team_members_url = 'javascript:void(0)';
                                        }
                                        ?><li class="user_dashboard_ajax" id="wp_rem_member_company" data-queryvar="dashboard=team_members"><a href="<?php echo wp_rem_allow_special_char($team_members_url); ?>"><i class="icon-group"></i><?php echo wp_rem_plugin_text_srt('wp_rem_member_team_members') ?></a></li>
                                    <?php } ?>

                                    <li>
                                        <?php
                                        if ( is_user_logged_in() ) {
                                            ?>
                                            <a class="logout-btn" href="<?php echo esc_url(wp_logout_url(wp_rem_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>"><i class="icon-log-out"></i><?php echo wp_rem_plugin_text_srt('wp_rem_login_register_sign_out') ?></a>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                </ul><?php
                            } else {
                                ?>
                                <ul>
                                    <li>
                                        <h6><?php echo esc_html($user_display_name) ?></h6>
                                        <?php
                                        if ( is_user_logged_in() ) {
                                            ?>
                                            <a class="logout-btn" href="<?php echo esc_url(wp_logout_url(wp_rem_server_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])) ?>"><i class="icon-logout"></i><?php echo wp_rem_plugin_text_srt('wp_rem_login_register_sign_out') ?></a>
                                                <?php
                                            }
                                            ?>
                                    </li>

                                </ul>
                            <?php }
                            ?> 
                        </li>

                    </ul> 
                </div>

                <?php
            }
        }

    }

    global $wp_rem_shortcode_login_frontend;
    $wp_rem_shortcode_login_frontend = new Wp_rem_Shortcode_Login_Frontend();
}
