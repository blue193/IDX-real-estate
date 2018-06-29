<?php
/**
 * File Type: Register Shortcode Frontend
 */
if ( ! class_exists('Wp_rem_Shortcode_Register_Frontend') ) {

    class Wp_rem_Shortcode_Register_Frontend {

        /**
         * Constant variables
         */
        var $PREFIX = 'wp_rem_register';

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_shortcode($this->PREFIX, array( $this, 'wp_rem_register_shortcode_callback' ));
        }

        /*
         * Shortcode View on Frontend
         */

        public function wp_rem_register_shortcode_callback($atts, $content = "") {
            global $wpdb, $wp_rem_plugin_options, $wp_rem_form_fields_frontend, $wp_rem_form_fields_frontend, $wp_rem_html_fields, $wp_rem_shortcode_login_frontend;
            wp_rem_socialconnect_scripts(); // social login script
            $defaults = array(
                'column_size' => '1/1',
                'member_register_element_title' => '',
                'title' => '',
                'subtitle' => '',
                'title_alignmenet' => '',
                'register_title' => '',
                'register_text' => '',
                'register_role' => 'contributor',
                'wp_rem_register_class' => '',
                'wp_rem_register_animation' => ''
            );
            extract(shortcode_atts($defaults, $atts));
            $user_disable_text = wp_rem_plugin_text_srt('wp_rem_register_disable');
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

            $output = '';
            if ( is_user_logged_in() ) {
                $output_html = wp_rem_plugin_text_srt('wp_rem_register_alreaady_logged');
            } else {
                wp_enqueue_script('wp-rem-login-script');
                $role = $register_role;
                $wp_rem_type = isset($wp_rem_type) ? $wp_rem_type : '';
                $wp_rem_login_class = 'login';
                $login_btn_class_str = '';

                $output_html = '';
                $page_element_size = isset($atts['wp_rem_register_element_size']) ? $atts['wp_rem_register_element_size'] : 100;
                if ( function_exists('wp_rem_cs_var_page_builder_element_sizes') ) {
                    $output_html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
                }
                /*
                 * Signin Popup Rendering
                 */
                $output_html .= '<div class="login-form login-form-element-' . $rand_id . '" data-id="' . $rand_id . '">
                                <div class="modal-content"><div class="tab-content">';
                $output_html .= '<ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#user-login-tab-' . $rand_id . '" id="myModalLabel">' . wp_rem_plugin_text_srt('wp_rem_register_signin_here') . '</a></li>
                                    <li><a data-toggle="tab" href="#user-register-' . $rand_id . '">' . wp_rem_plugin_text_srt('wp_rem_register_text_register') . '</a></li>
                                </ul>';
                // Signin Tab
                $output_html .= '<div id="user-login-tab-' . $rand_id . '" class="tab-pane fade in active">';
                $output_html .= '<div class="modal-body">';
                $output_html .= '<div class="content-style-form cs-forgot-pbox-' . $rand_id . ' content-style-form-2" style="display:none;"><div class="signin-tab-link">
                                            Already have an account?    <a data-id="' . $rand_id . '" class="cs-bgcolor cs-login-switch">' . wp_rem_plugin_text_srt('wp_rem_register_login_here') . '</a>
                    </div><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
                ob_start();
                $output_html .= do_shortcode('[wp_rem_forgot_password wp_rem_type="popup"]');
                $output_html .= ob_get_clean();
                $output_html .= '</div><div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="login-detail">
                                            <h2>' . wp_rem_plugin_text_srt('wp_rem_register_need_more_help') . '</h2>
                                            <p>' . wp_rem_plugin_text_srt('wp_rem_register_login_with_social_string') . '</p>
                                            <a href="#">' . wp_rem_plugin_text_srt('wp_rem_register_contact_us_string') . '</a>
                                        </div>
                                    </div></div>';
                $output_html .= '<p class="wp-rem-dev-login-top-msg" style="display: none;"></p>';
                $output_html .='<div class="cs-login-pbox-' . $rand_id . ' login-form-id-' . $rand_id . '">';
                $output_html .= '<div class="status status-message"></div>';
                ob_start();
                $output_html .= do_action('login_form', array( 'form_rand_id' => $rand_id ));
                $output_html .= ob_get_clean();
                if ( is_user_logged_in() ) {
                    $output_html .='<script>'
                            . 'jQuery("body").on("keypress", "input#user_login' . absint($rand_id) . ', input#user_pass' . absint($rand_id) . '", function (e) {
                                        if (e.which == "13") {
                                            show_alert_msg("' . wp_rem_plugin_text_srt("wp_rem_register_logout_first") . '");
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
                    $output_html .= '<a class="demo-login-member-' . $rand_id . '" href="javascript:void(0)" onclick="javascript:wp_rem_demo_user_login(\'' . $wp_rem_demo_member_detail_user . '\',\'.demo-login-member-' . $rand_id . '\')" '
                            . '><i class="icon-user-secret"></i>' . wp_rem_plugin_text_srt('wp_rem_register_login_buyer_rent')
                            . '</a>';
                    $output_html .= '</li>';
                    $output_html .= '<li>';
                    $output_html .= '<a class="demo-login-agency-' . $rand_id . '" href="javascript:void(0)" onclick="javascript:wp_rem_demo_user_login(\'' . $wp_rem_demo_agency_detail_user . '\',\'.demo-login-agency-' . $rand_id . '\')" '
                            . '><i class="icon-location_city"></i>' . wp_rem_plugin_text_srt('wp_rem_register_login_sell_let_out')
                            . '</a>';
                    $output_html .= '</li>';
                    $output_html .= '</ul>';
                    $output_html .='</div>';
                    $output_html .='<script>
                        function wp_rem_demo_user_login(user, buttonloader) {
                            jQuery("#user_login' . $rand_id . '" ).val(user);
                            jQuery("#user_pass' . $rand_id . '" ).val("' . $demo_user_password . '");
                            wp_rem_user_authentication(\'' . admin_url("admin-ajax.php") . '\',\'' . $rand_id . '\', buttonloader);
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
                    'extra_atr' => ' tabindex="11" placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_username') . '"',
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
                                                            <label for="remember">Remember me</label>
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
                    $output_html .='<div class="register-element-btn-' . $rand_id . ' input-button-loader">';
                    $wp_rem_opt_array = array(
                        'std' => wp_rem_plugin_text_srt('wp_rem_register_login'),
                        'cust_name' => 'user-submit',
                        'cust_type' => 'button',
                        'classes' => 'cs-bgcolor',
                        'extra_atr' => ' onclick="javascript:wp_rem_user_authentication(\'' . admin_url("admin-ajax.php") . '\', \'' . $rand_id . '\', \'.register-element-btn-' . $rand_id . '\')"',
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
                    $output_html .= '
				</div>
			</div>';
                }
                $output_html .='<div class="forget-password"><i class="icon-help"></i><a class="cs-forgot-switch" data-id="' . $rand_id . '">' . wp_rem_plugin_text_srt('wp_rem_register_forgot_password') . '</a></div>';
                $output_html .='</form>';
                $output_html .= '</div>';
                $output_html .= '</div>';
                $output_html .= '</div>';
                //End Signin Tab
                // Signup Tab
                $output_html .= '<div id="user-register-' . $rand_id . '" class="tab-pane fade">';
                $output_html .= $this->wp_rem_registration_tab($rand_id);
                $output_html .='
                </div>';
                //End Signup Tab
                //Forgot Password Tab
                $output_html .='<div id="user-password-' . $rand_id . '" class="tab-pane fade">';
                $output_html .='
                </div>';
                //End Password Tab
                $output_html .= '</div>';
                $output_html .='
                </div></div></div>';
                $data = get_transient('social_data');
                delete_transient('social_data');
                if ( $data != false ) {
                    ob_start();
                    ?>
                    <script type="text/javascript">
                        (function ($) {
                            $(function () {
                                var rand_id = window.rand_id_registration;
                                $("input[name='user_login" + rand_id + "']").val('<?php echo esc_html($data['user_login']); ?>');
                                $("input[name='foodbakery_display_name" + rand_id + "']").val('<?php echo esc_html($data['first_name']) . ' ' . esc_html($data['last_name']); ?>');
                                $(".status-message").addClass('text-danger').html('<?php echo wp_rem_plugin_text_srt('wp_rem_register_sorry') . ucfirst($data['social_login_provider']) . wp_rem_plugin_text_srt('wp_rem_register_sorry_text'); ?>');
                                $("#signin-role").after('<input type="hidden" name="social_meta_key" value="<?php echo esc_html($data['social_meta_key']); ?>">');
                                $("#signin-role").after('<input type="hidden" name="social_meta_value" value="<?php echo esc_html($data['social_meta_value']); ?>">');
                                $(".foodbakery-dev-login-box-btn").click();
                                $(".cs-popup-joinus-btn").click();
                            });
                        })(jQuery);
                    </script>
                    <?php
                    $output_html .= ob_get_clean();
                }
            }
            return $output_html;
        }

        public function wp_rem_registration_tab($rand_id = '') {
            global $wp_rem_form_fields_frontend, $wp_rem_plugin_options, $wp_rem_html_fields_frontend;
            $wp_rem_captcha_switch = '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
            $output_html = '';
            $role = '';
            $register_text = '';
            $user_disable_text = wp_rem_plugin_text_srt('wp_rem_register_disable');
            $content = '';
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
                        . 'jQuery("body").on("keypress", "input#wp_rem_company_name' . absint($rand_ids) . ', input#user_login_' . absint($rand_ids) . ', input#wp_rem_display_name' . absint($rand_ids) . ', input#wp_rem_user_email' . absint($rand_ids) . '", function (e) {
                                                                            if (e.which == "13") {
                                                                                    wp_rem_registration_validation("' . esc_url(admin_url("admin-ajax.php")) . '", "' . absint($rand_ids) . '", \'.ajax-signup-button\');
                                                                                    return false;
                                                                            }
                                                                            });'
                        . '</script>';
                ob_start();
                if ( class_exists('wp_rem') ) {
                    $output_html .= do_action('login_form', array( 'form_rand_id' => $rand_id ));
                }
                $output_html .= ob_get_clean();
                $key = wp_rem_get_input('key', NULL, 'STRING');
                if ( $key != NULL ) {
                    $key_data = get_option($key);
                    $output_html .= '<script>jQuery(document).ready(function($){$("#join-us").modal("show")}); </script>';
                }
                $output_html .='<form method="post" class="wp-user-form demo_test" id="wp_signup_form_' . $rand_ids . '" enctype="multipart/form-data">';
                $output_html .='<div class="input-filed">';
                $output_html .= $wp_rem_html_fields_frontend->wp_rem_radio_field(
                        array(
                            'description' => '<label for="member_profile_type_individual">' . wp_rem_plugin_text_srt('wp_rem_member_profile_individual') . '</label>',
                            'echo' => false,
                            'field_params' => array(
                                'std' => 'individual',
                                'cust_id' => 'member_profile_type_individual',
                                'cust_name' => 'wp_rem_profile_type' . $rand_ids . '',
                                'extra_atr' => ' class="wp_rem_profile_type" checked',
                                'return' => true
                            ),
                        )
                );

                $output_html .= $wp_rem_html_fields_frontend->wp_rem_radio_field(
                        array(
                            'description' => ' <label for="member_profile_type_company">' . wp_rem_plugin_text_srt('wp_rem_member_profile_company') . '</label>',
                            'echo' => false,
                            'field_params' => array(
                                'std' => 'company',
                                'cust_id' => 'member_profile_type_company',
                                'cust_name' => 'wp_rem_profile_type' . $rand_ids . '',
                                'extra_atr' => 'class="wp_rem_profile_type"',
                                'return' => true
                            ),
                        )
                );
                $output_html .='</div>';
                if ( $key == NULL ) {
                    $output_html .='<div class="input-filed wp-rem-company-name" style="display:none;">';
                    $output_html .=' <i class="icon- icon-user"></i>';
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
                $output_html .= '</div>';
                if ( $key == NULL ) {
                    $output_html .='<div class="input-filed">';
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
                        $member_type_array[$member_value[$a]] = $member_title[$a];
                    }
                }
                if ( ! empty($member_type_array) ) {
                    $output_html .='<div class="input-filed">';
                    $output_html .='<i class="icon-user-tie-fancy"></i>';
                    $wp_rem_opt_array = array(
                        'std' => '',
                        'classes' => 'chosen-single',
                        'id' => 'member_type' . $rand_ids,
                        'options' => $member_type_array,
                        'return' => true,
                        'description' => '',
                        'name' => '',
                        'extra_atr' => 'data-placeholder="' . wp_rem_plugin_text_srt('wp_rem_register_member_type') . '"',
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
                        array( 'name' => 'user role type',
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
                    if ( $wp_rem_sitekey <> '' and $wp_rem_secretkey <> '' ) {
                        wp_rem_google_recaptcha_scripts();
                        $output_html .= "<script>
                                            var recaptcha_register;
                                            var wp_rem_multicap = function () {
                                            recaptcha_register = grecaptcha.render('recaptcha_register', {
                                                    'sitekey': '.$wp_rem_sitekey.', //Replace this with your Site key
                                                    'theme': 'light'
                                                });
                                            };
                                        </script>";
                    }// end site key
                    if ( class_exists('Wp_rem_Captcha') ) {
                        global $Wp_rem_Captcha;
                        $output_html .='<div class="recaptcha-reload" id="recaptcha_register_div">';
                        $output_html .= $Wp_rem_Captcha->wp_rem_generate_captcha_form_callback('recaptcha_register', 'true');
                        $output_html .='</div>';
                    }// end captcha class exists
                }//end captcha switch on
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

    }

    global $wp_rem_shortcode_register_frontend;
    $wp_rem_shortcode_register_frontend = new Wp_rem_Shortcode_Register_Frontend();
}
