<?php

/**
 * @Generate Random String
 */
if ( ! function_exists('wp_rem_generate_random_string') ) {

    function wp_rem_generate_random_string($length = 3) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ( $i = 0; $i < $length; $i ++  ) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

}
/*
 * Start Function  user last login
 */
if ( ! function_exists('wp_rem_user_last_login') ) {

    function wp_rem_user_last_login($user_login, $user) {
        $company_id = get_user_meta($user->ID, 'wp_rem_company', true);
        update_post_meta($company_id, 'last_login', time());
    }

    add_action('wp_login', 'wp_rem_user_last_login', 10, 2);
}

/*
 * Start Function  for if user exist using Ajax
 */
if ( ! function_exists('ajax_login') ) {

    function ajax_login() {
        global $wp_rem_plugin_options, $wpdb;
        $credentials = array();

        $wp_rem_danger_html = '<div class="alert alert-danger"><p><i class="icon-warning4"></i>';

        $wp_rem_success_html = '<div class="alert alert-success"><p><i class="icon-checkmark6"></i>';

        $wp_rem_msg_html = '</p></div>';

        $credentials['user_login'] = esc_sql($_POST['user_login']);
        $credentials['user_password'] = esc_sql($_POST['user_pass']);
        if ( isset($_POST['rememberme']) ) {
            $remember = esc_sql($_POST['rememberme']);
        } else {
            $remember = '';
        }
        if ( $remember ) {
            $credentials['remember'] = true;
        } else {
            $credentials['remember'] = false;
        }
        if ( $credentials['user_login'] == '' ) {
            $json['type'] = "error";
            $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_username_error' );
            echo json_encode($json);
            exit();
        } elseif ( $credentials['user_password'] == '' ) {
            $json['type'] = "error";
            $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_password_error' );
            echo json_encode($json);
            exit();
        } else {
            $user_status = '0';
            $user = get_user_by('login', $credentials['user_login']);
            if ( is_object($user) && isset($user->ID) ) {
                $user_id = $user->ID;
                $user_status = $user->user_status;
                $user_status_profile = get_user_meta($user_id, 'wp_rem_user_status', true);

                if ( $user && wp_check_password($credentials['user_password'], $user->data->user_pass, $user_id) ) {
                    if ( $user_status == '0' ) {
                        $json['type'] = "error";
                        $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_not_activated' );
                        echo json_encode($json);
                        die;
                    } elseif ( $user_status_profile == 'deleted' ) {
                        $json['type'] = "error";
                        $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_removed_from_company' );
                        echo json_encode($json);
                        die;
                    }
                } else {
                    $json['type'] = "error";
                    $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_check_password' );
                    echo json_encode($json);
                    die;
                }
            }

            $status = wp_signon($credentials, false);
            if ( is_wp_error($status) ) {
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_wrong_user_pass' );
                echo json_encode($json);
            } else {
                $user_roles = isset($status->roles) ? $status->roles : '';
                $uid = $status->ID;
                $wp_rem_user_name = $_POST['user_login'];
                $wp_rem_login_user = get_user_by('login', $wp_rem_user_name);
                $wp_rem_page_id = '';
                $default_url = $_POST['redirect_to'];
                if ( ($user_roles != '' && in_array("wp_rem_member", $user_roles) ) ) {
                    $wp_rem_page_id = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : $default_url;
                }
                // update user last activity
                update_user_meta($uid, 'wp_rem_user_last_activity_date', strtotime(date('d-m-Y H:i:s')));
                $wp_rem_redirect_url = '';
                if ( $wp_rem_page_id != '' ) {
                    $wp_rem_redirect_url = get_permalink($wp_rem_page_id);
                } else {
                    $wp_rem_redirect_url = $default_url;  // home URL if page not set
                }
                if ( isset($_POST['login-redirect-page']) && $_POST['login-redirect-page'] != '' ) {
                    $wp_rem_redirect_url = $_POST['login-redirect-page'];
                }

                $wp_rem_redirect_url = apply_filters('wp_rem_user_login_redirect_url', $wp_rem_redirect_url);

                $json['type'] = "success";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_login_successfully' );
                $json['redirecturl'] = $wp_rem_redirect_url;
                echo json_encode($json);
            }
        }
        die();
    }

    add_action('wp_ajax_ajax_login', 'ajax_login');
    add_action('wp_ajax_nopriv_ajax_login', 'ajax_login');
}
/*
 * Start Function  for  user registration validation
 */
if ( ! function_exists('wp_rem_registration_validation') ) {

    function wp_rem_registration_validation($atts = '', $given_params = '') {

        global $wpdb, $wp_rem_plugin_options, $wp_rem_form_fields_frontend, $buyer_permissions;
		$member_title = isset($wp_rem_plugin_options['member_title']) ? $wp_rem_plugin_options['member_title'] : '';
        $member_value = isset($wp_rem_plugin_options['member_value']) ? $wp_rem_plugin_options['member_value'] : '';
        $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
        $wp_rem_danger_html = '<div class="alert alert-danger"><p><i class="icon-warning4"></i>';
        $wp_rem_success_html = '<div class="alert alert-success"><p><i class="icon-checkmark6"></i>';
        $wp_rem_msg_html = '</p></div>';

        if ( $given_params != '' && is_array($given_params) ) {
            extract($given_params);
        } else {
            $id = isset($_POST['id']) ? $_POST['id'] : ''; //rand id 
            $username = isset($_POST['user_login' . $id]) ? $_POST['user_login' . $id] : '';
            $profile_type = isset($_POST['wp_rem_profile_type' . $id]) ? $_POST['wp_rem_profile_type' . $id] : '';
            $member_type = isset($_POST['wp_rem_member_type' . $id]) ? $_POST['wp_rem_member_type' . $id] : '';
            $email = isset($_POST['wp_rem_user_email' . $id]) ? $_POST['wp_rem_user_email' . $id] : '';
            $password = isset($_POST['wp_rem_user_password' . $id]) ? $_POST['wp_rem_user_password' . $id] : '';
            $wp_rem_user_role_type = (isset($_POST['wp_rem_user_role_type' . $id]) and $_POST['wp_rem_user_role_type' . $id] <> '') ? $_POST['wp_rem_user_role_type' . $id] : '';
            $display_name = wp_rem_get_input('wp_rem_display_name' . $id, NULL, 'STRING');
        }
        $company_name = wp_rem_get_input('wp_rem_company_name' . $id, NULL, 'STRING');
        $company_field = wp_rem_get_input('wp_rem_company_name' . $id, NULL, 'STRING');

        $json = array();
        if ( $given_params == '' ) {
            if ( empty($username) ) {
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_username_error' );
                echo json_encode($json);
                exit();
            } elseif ( ! preg_match('/^[a-zA-Z0-9_]{5,}$/', $username) ) { // for english chars + numbers only
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_enter_valid_username' );
                echo json_encode($json);
                exit();
            }
            if ( ! empty($profile_type) && $profile_type == 'company' && !empty($member_title) && !empty($member_value)) {
                if ( empty($member_type) ) {
                    $json['type'] = "error";
                    $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_select_type' );
                    echo json_encode($json);
                    exit();
                }
            }
            if ( empty($email) ) {
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_email_error' );
                echo json_encode($json);
                exit();
            }

            if ( ! preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email) ) {
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_valid_email' );
                echo json_encode($json);
                exit();
            }

            if ( $wp_rem_captcha_switch == 'on' && empty($given_params) ) {
                do_action('wp_rem_verify_captcha_form');
            }
        }

        /*
         * register form popup validation
         */
        if ( empty($profile_type) ) {
            $json['type'] = "error";
            $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_type_error' );
        }
        if ( ! empty($profile_type) && $profile_type == 'company' ) {
            if ( $company_name == NULL ) {
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_company_name_error' );
            }
        }
        if ( email_exists($email) ) {
            $json['type'] = "error";
            $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_email_already_exists' );
        }
        if ( $wp_rem_captcha_switch == 'on' && empty($given_params) ) {
            do_action('wp_rem_verify_captcha_form');
        }
        if ( $company_name == NULL ) {
            $company_name = $display_name;
        } else {
            if ( $display_name == NULL ) {
                $display_name = $company_name;
            }
        }
        /*
         * End register form popup validation
         */

        if ( isset($json['type']) && $json['type'] == 'error' ) {
            if ( empty($given_params) ) { // if this is AJAX request
                echo json_encode($json);
                wp_die();
            } else { // If this function is called from code.
                return $json;
            }
        }

        if ( empty($password) || $password == '' ) {
            $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
        } else {
            $random_password = $password;
        }

        $status = wp_create_user($username, $random_password, $email);

        if ( $status ) {
            update_user_meta($status, 'display_name', wp_strip_all_tags($display_name));
            $wp_rem_userdata = array( 'display_name' => $display_name );
            wp_update_user(array( 'ID' => $status, 'display_name' => $display_name ));
        }
        if ( is_wp_error($status) ) {
            if ( $given_params != '' && is_array($given_params) ) {
                $json['type'] = "error";
                $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_user_already_exists' );
            }
        } else {
            global $wpdb;
            $signup_user_role = '';
            if ( $wp_rem_user_role_type == 'member' ) {
                $signup_user_role = 'wp_rem_member';
            }
            wp_update_user(array( 'ID' => esc_sql($status), 'role' => esc_sql($signup_user_role), 'user_status' => 1 ));
            $wpdb->update(
                    $wpdb->prefix . 'users', array( 'user_status' => 1 ), array( 'ID' => esc_sql($status) )
            );
            update_user_meta($status, 'show_admin_bar_front', false);
            // set extra status only for delete user maintain
            update_user_meta($status, 'wp_rem_user_status', 'active');
            update_user_meta($status, 'wp_rem_is_admin', 1);
            /*
             * Inserting Member while registering user
             */
            $company_phone = wp_rem_get_input('wp_rem_phone_no' . $id, NULL, 'STRING');
            $company_data = array(
                'post_title' => wp_strip_all_tags($display_name),
                'post_type' => 'members',
                'post_content' => '',
                'post_status' => 'publish',
                'post_author' => 1,
            );
            $company_ID = wp_insert_post($company_data);
            if ( $company_ID ) {
                update_user_meta($status, 'wp_rem_user_type', 'supper-admin');
                update_post_meta($company_ID, 'wp_rem_member_company_name', $company_name);
                update_post_meta($company_ID, 'wp_rem_email_address', $email);

                if ( isset($_POST['wp_rem_profile_type' . $id]) ) {
                    update_post_meta($company_ID, 'wp_rem_member_profile_type', $_POST['wp_rem_profile_type' . $id]);
                } else {
                    update_post_meta($company_ID, 'wp_rem_member_profile_type', 'company');
                }
                update_post_meta($company_ID, 'wp_rem_member_type', $member_type);
                update_post_meta($company_ID, 'wp_rem_member_user_type', 'reseller' );
            }
            update_user_meta($status, 'wp_rem_company', $company_ID);


            // send email to user
            $reg_user = get_user_by('ID', $status);
            if ( isset($reg_user->roles) && in_array('wp_rem_member', $reg_user->roles) ) {
                // Site owner email hook
                do_action('wp_rem_new_user_notification_site_owner', $reg_user->data->user_login, $reg_user->data->user_email);
                do_action('wp_rem_user_register', $reg_user, $random_password);

                if ( class_exists('wp_rem_register_email_template') && isset(Wp_rem_register_email_template::$is_email_sent1) ) {
                    $json['type'] = "success";
                    $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_check_email' );
                } else {
                    $json['type'] = "error";
                    $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_went_wrong' );
                }
            } else {
                // Site owner email hook
                do_action('wp_rem_new_user_notification_site_owner', $reg_user->data->user_login, $reg_user->data->user_email);
                do_action('wp_rem_user_register', $reg_user, $random_password);

                if ( class_exists('wp_rem_register_email_template') && isset(Wp_rem_register_email_template::$is_email_sent1) ) {
                    $json['type'] = "success";
                    $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_check_email' );
                } else {
                    $json['type'] = "error";
                    $json['msg'] = wp_rem_plugin_text_srt( 'wp_rem_login_went_wrong' );
                }
            }

            $wp_rem_comp_name = '';
            $wp_rem_phone_no = '';

            // update user meta by role
            if ( $wp_rem_user_role_type == 'member' ) {
                if ( $given_params != '' && is_array($given_params) ) {
                    $wp_rem_comp_name = isset($_POST['wp_rem_organization_name' . $id]) ? $_POST['wp_rem_organization_name' . $id] : '';
                }

                if ( isset($wp_rem_plugin_options['wp_rem_member_review_option']) && $wp_rem_plugin_options['wp_rem_member_review_option'] == 'on' ) {
                    $wpdb->update(
                        $wpdb->prefix . 'users', array( 'user_status' => 1 ), array( 'ID' => esc_sql($status) )
                    );
                    update_user_meta($status, 'profile_approved', 1);
					update_post_meta($company_ID, 'wp_rem_user_status', 'active');
                } else {
                    $wpdb->update(
                        $wpdb->prefix . 'users', array( 'user_status' => 0 ), array( 'ID' => esc_sql($status) )
                    );
                    update_user_meta($status, 'profile_approved', 0);
					update_post_meta($company_ID, 'wp_rem_user_status', 'pending');
                }
            }
            update_user_meta($status, 'wp_rem_user_last_activity_date', strtotime(date('d-m-Y')));
            update_user_meta($status, 'wp_rem_allow_search', 'yes');
        }
        if ( ! empty($given_params) ) {
            if ( isset($json['type']) && $json['type'] == 'error' ) {
                return $json;
            } else {
                return array( $company_ID, $status );
            }
        } else {
            echo json_encode($json);
            wp_die();
        }
    }

    add_action('wp_ajax_wp_rem_registration_validation', 'wp_rem_registration_validation');
    add_action('wp_ajax_nopriv_wp_rem_registration_validation', 'wp_rem_registration_validation');
}
/*
 * Start Function  for  contact validation 
 */
if ( ! function_exists('wp_rem_contact_validation') ) {

    function wp_rem_contact_validation($atts = '') {
        global $wpdb, $wp_rem_plugin_options, $wp_rem_form_fields_frontend;
        $id = rand(10000000, 91564689); //rand id 
        $username = $_POST['user_login' . $id];
        $json = array();
        if ( $wp_rem_captcha_switch == 'on' ) {
            wp_rem_captcha_verify();
        }
        if ( is_wp_error($status) ) {
            $json['type'] = "error";
            $json['message'] = wp_rem_plugin_text_srt( 'wp_rem_login_an_issue' );
            echo json_encode($json);
            die;
        } else {
            $json['type'] = "error";
            $json['message'] = wp_rem_plugin_text_srt( 'wp_rem_login_success' );
        }

        echo json_encode($json);
        die;
    }

    add_action('wp_ajax_wp_rem_registration_validation', 'wp_rem_registration_validation');
    add_action('wp_ajax_nopriv_wp_rem_registration_validation', 'wp_rem_registration_validation');
}
/*
 * Start Function  for  user registration save 
 */
if ( ! function_exists('wp_rem_registration_save') ) {

    add_action('user_register', 'wp_rem_registration_save', 10, 1);

    function wp_rem_registration_save($user_id) {
        if ( isset($_REQUEST['action']) && $_REQUEST['action'] == 'register' ) {
            $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
            wp_set_password($random_password, $user_id);
            $reg_user = get_user_by('ID', $user_id);
            if ( isset($reg_user->roles) && (in_array('subscriber', $reg_user->roles) || in_array('editor', $reg_user->roles) || in_array('author', $reg_user->roles)) ) {
                // Site owner email hook
                do_action('wp_rem_new_user_notification_site_owner', $reg_user->data->user_login, $reg_user->data->user_email);
                // normal user email hook
                do_action('wp_rem_user_register', $reg_user, $random_password);
            }
        }
    }

}