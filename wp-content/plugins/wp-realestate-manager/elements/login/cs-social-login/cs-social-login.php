<?php
if ( ! function_exists('email_exists') )
    require_once ABSPATH . WPINC . '/registration.php';
/*
 *  set query vars
 */
if ( ! function_exists('wp_rem_query_vars') ) {

    function wp_rem_query_vars($vars) {
        $vars[] = 'social-login';
        return $vars;
    }

    add_action('query_vars', 'wp_rem_query_vars');
}
/*
 *  set parse request
 */
if ( ! function_exists('wp_rem_parse_request') ) {

    function wp_rem_parse_request($wp) {

        $plugin_url = plugin_dir_url(__FILE__);
        if ( array_key_exists('social-login', $wp->query_vars) ) {

            $_REQUEST['state'] = (isset($_REQUEST['state'])) ? $_REQUEST['state'] : '';

            $state = base64_decode($_REQUEST['state']);
            $state = json_decode($state);
            if ( isset($wp->query_vars['social-login']) && $wp->query_vars['social-login'] == 'twitter' ) {
                wp_rem_twitter_connect();
            } else if ( isset($wp->query_vars['social-login']) && $wp->query_vars['social-login'] == 'twitter-callback' ) {
                wp_rem_twitter_callback();
            } else if ( isset($wp->query_vars['social-login']) && $wp->query_vars['social-login'] == 'linkedin' || (isset($state->social_login) && $state->social_login == 'linkedin' ) ) {
                require_once "linkedin/linkedin_function.php";
                die();
            } else if ( isset($wp->query_vars['social-login']) && $wp->query_vars['social-login'] == 'facebook-callback' ) {
                require_once 'facebook/callback.php';
                die();
            }
            wp_die();
        }
        if ( isset($_REQUEST['likedin-login-request']) ) {

            $user_info = get_userdata($_REQUEST['likedin-login-request']);
            $ID = $_REQUEST['likedin-login-request'];
            $user_login = $user_info->user_login;
            $user_id = $user_info->ID;
            wp_set_current_user($user_id, $user_login);
            wp_set_auth_cookie($user_id);
            do_action('wp_login', $user_login, $user_info);
        }
    }

    add_action('parse_request', 'wp_rem_parse_request');
}

/*
 *  login process method
 */
if ( ! function_exists('wp_rem_social_process_login') ) {

    function wp_rem_social_process_login($is_ajax = false) {
        global $wp_rem_plugin_options, $wpdb, $buyer_permissions;
        if ( isset($_REQUEST['redirect_to']) && $_REQUEST['redirect_to'] != '' ) {
            $redirect_to = $_REQUEST['redirect_to'];
            // Redirect to https if user wants ssl
            if ( isset($secure_cookie) && $secure_cookie && false !== strpos($redirect_to, 'wp-admin') )
                $redirect_to = preg_replace('|^http://|', 'https://', $redirect_to);
        } else {
            $redirect_to = admin_url();
        }
        $wp_rem_page_id = isset($wp_rem_plugin_options['wp_rem_member_dashboard']) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : $_POST['redirect_to'];
        $redirect_to = get_permalink((int) $wp_rem_page_id);
        $redirect_to = apply_filters('social_login_redirect_to', $redirect_to);
        $social_login_provider = $_REQUEST['social_login_provider'];
        $wp_rem_provider_identity_key = 'social_login_' . $social_login_provider . '_id';
        $wp_rem_provided_signature = $_REQUEST['social_login_signature'];
        $wp_rem_email = '';
        switch ( $social_login_provider ) {
            case 'facebook':
                $fields = array(
                    'id', 'name', 'first_name', 'last_name', 'link', 'website', 'picture',
                    'gender', 'locale', 'about', 'email', 'hometown', 'location',
                    'birthday'
                );
                wp_rem_social_login_verify_signature($_REQUEST['social_login_access_token'], $wp_rem_provided_signature, $redirect_to);
                $fb_json = json_decode(wp_rem_http_get_contents("https://graph.facebook.com/me?access_token=" . $_REQUEST['social_login_access_token'] . "&fields=" . implode(',', $fields)));
                $facebook_member_profile_url = $fb_json->picture->data->url;

                if ( isset($fb_json->error->type) ? $fb_json->error->type : '' == 'OAuthException' ) {
                    ?>
                    <script>
                        alert("<?php echo wp_rem_plugin_text_srt('wp_rem_social_login_check_fb_account'); ?>");
                        window.close();
                    </script>
                    <?php
                    exit();
                } else {
                    $wp_rem_provider_identity = $fb_json->{ 'id' };
                    $wp_rem_profile_pic = 'https://graph.facebook.com/' . $wp_rem_provider_identity . '/picture';
                    $wp_rem_facebook = $fb_json->{ 'link' };
                    $wp_rem_gender = $fb_json->{ 'gender' };
                    //$wp_rem_email = $fb_json->{ 'email' };
                    if ( isset($fb_json->email) ) {
                        $wp_rem_email = $fb_json->{ 'email' };
                    }
                    $wp_rem_first_name = $fb_json->{ 'first_name' };
                    $wp_rem_last_name = $fb_json->{ 'last_name' };
                    $wp_rem_profile_url = $fb_json->{ 'link' };
                    $wp_rem_gender = $fb_json->{ 'gender' };
                    $wp_rem_name = $wp_rem_first_name . ' ' . $wp_rem_last_name;
                    $user_login = strtolower($wp_rem_first_name . $wp_rem_last_name);
                }
                break;
            case 'twitter':
                $wp_rem_provider_identity = $_REQUEST['social_login_twitter_identity'];
                wp_rem_social_login_verify_signature($wp_rem_provider_identity, $wp_rem_provided_signature, $redirect_to);
                $wp_rem_name = $_REQUEST['social_login_name'];
                //var_dump($_REQUEST);
                //die;
                $wp_rem_twitter = 'https://twitter.com/' . $_REQUEST['social_login_screen_name'];
                $names = explode(" ", $wp_rem_name);
                $wp_rem_first_name = '';
                if ( isset($names[0]) )
                    $wp_rem_first_name = $names[0];
                $wp_rem_last_name = '';
                if ( isset($names[1]) )
                    $wp_rem_last_name = $names[1];
                $wp_rem_screen_name = $_REQUEST['social_login_screen_name'];
                $facebook_member_profile_url = $_REQUEST['social_profile_image_url'];
                $wp_rem_profile_url = '';
                $wp_rem_gender = '';
                // Get host name from URL
                $site_url = parse_url(site_url());
                //$wp_rem_email = 'tw_' . md5($wp_rem_provider_identity) . '@' . $site_url['host'] . '.com';
                $user_login = $wp_rem_screen_name;
                break;
            default:

                break;
        }

        // Get user by meta
        $user_id = wp_rem_social_get_user_by_meta($wp_rem_provider_identity_key, $wp_rem_provider_identity);
        if ( $user_id ) {
            $current_user = get_userdata($user_id);
            $user_roles = isset($current_user->roles) ? $current_user->roles : '';
            if ( ($user_roles != '' && in_array("wp_rem_member", $user_roles) ) ) {
                $user_data = get_userdata($user_id);
                $user_login = $user_data->user_login;
                // update user meta
                update_user_meta($user_id, 'wp_rem_user_last_activity_date', strtotime(date('d-m-Y H:i:s')));
                //update_user_meta($user_id, 'wp_rem_allow_search', 'yes');
                //update_user_meta($user_id, 'wp_rem_user_status', 'active');
                if ( isset($wp_rem_facebook) && $wp_rem_facebook != '' ) {
                    update_user_meta($user_id, 'wp_rem_facebook', $wp_rem_facebook);
                }
                if ( isset($wp_rem_twitter) && $wp_rem_twitter != '' ) {
                    update_user_meta($user_id, 'wp_rem_twitter', $wp_rem_twitter);
                }
            } else {
                ?>
                <script>
                    alert("<?php echo wp_rem_plugin_text_srt('wp_rem_social_login_profile_already_linked'); ?>");
                    window.opener.location.reload();
                    window.close();
                </script>
                <?php
                $ID = Null;  // set null bcz this user exist in other Role
            }
        } elseif ( $user_id = email_exists($wp_rem_email) ) { // User not found by provider identity, check by email
            $current_user = get_userdata($user_id);
            $user_roles = isset($current_user->roles) ? $current_user->roles : '';
            if ( ($user_roles != '' && in_array("wp_rem_member", $user_roles) ) ) {
                // update user meta
                update_user_meta($user_id, $wp_rem_provider_identity_key, $wp_rem_provider_identity);
                $user_data = get_userdata($user_id);
                $user_login = $user_data->user_login;
                // update user meta
                update_user_meta($user_id, 'wp_rem_user_last_activity_date', strtotime(date('d-m-Y H:i:s')));
                //update_user_meta($user_id, 'wp_rem_allow_search', 'yes');
                //update_user_meta($user_id, 'wp_rem_user_status', 'active');
                if ( isset($wp_rem_facebook) && $wp_rem_facebook != '' ) {
                    update_user_meta($user_id, 'wp_rem_facebook', $wp_rem_facebook);
                }
                if ( isset($wp_rem_twitter) && $wp_rem_twitter != '' ) {
                    update_user_meta($user_id, 'wp_rem_twitter', $wp_rem_twitter);
                }
            } else {
                ?>
                <script>
                    alert("<?php echo wp_rem_plugin_text_srt('wp_rem_social_login_profile_already_linked'); ?>");
                    window.opener.location.reload();
                    window.close();
                </script>
                <?php
                $ID = Null;  // set null bcz this user exist in other Role
            }
        } else { // Create new user and associate provider identity
            if ( get_option('users_can_register') ) {
                $member_user_tab = wp_rem_get_transient_obj('member_user_tab');
                if ( empty($wp_rem_email) || $member_user_tab == 'login' ) {
                    $data = array(
                        'user_login' => $user_login,
                        'user_email' => $wp_rem_email,
                        'role' => 'wp_rem_member',
                        'first_name' => $wp_rem_first_name,
                        'last_name' => $wp_rem_last_name,
                        'user_url' => $wp_rem_profile_url,
                        'social_login_provider' => $social_login_provider,
                        'social_meta_key' => $wp_rem_provider_identity_key,
                        'social_meta_value' => $wp_rem_provider_identity,
                    );
                    set_transient('social_data', $data, 60);
                    ?>
                    <script>
                        location.href = '<?php echo get_home_url(); ?>';
					</script>
                    <?php
                    wp_die();
                }

                $wp_rem_member_image_id = upload_member_profile_image($facebook_member_profile_url);

                $user_login = wp_rem_get_unique_username($user_login);
                $userdata = array( 'user_login' => $user_login, 'user_email' => $wp_rem_email, 'role' => 'wp_rem_member', 'first_name' => $wp_rem_first_name, 'last_name' => $wp_rem_last_name, 'user_url' => $wp_rem_profile_url, 'user_pass' => wp_generate_password() );
                // Create a new user
                $user_id = wp_insert_user($userdata);
                $user_id = (int) $user_id; // converting user id into int from object
                $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
                wp_set_password($random_password, $user_id);
                $reg_user = get_user_by('ID', $user_id);
                // Site owner email hook
                $user_login = isset($reg_user->data->user_login) ? $reg_user->data->user_login : '';
                $user_email = isset($reg_user->data->user_email) ? $reg_user->data->user_email : '';
                do_action('wp_rem_new_user_notification_site_owner', $user_login, $user_email);

                // send member email template hook
                //do_action('wp_rem_member_register', $reg_user, $random_password);
                do_action('wp_rem_user_register', $reg_user, $random_password);

                $new_user = new WP_User($user_id);
                // update user meta
                $new_user->set_role('wp_rem_member');
                update_user_meta($user_id, 'wp_rem_user_last_activity_date', strtotime(date('d-m-Y H:i:s')));
                update_user_meta($user_id, 'wp_rem_allow_search', 'yes');
                update_user_meta($user_id, 'wp_rem_user_status', 'active');
				// Update User Profile Status
				if ( isset($wp_rem_plugin_options['wp_rem_member_review_option']) && $wp_rem_plugin_options['wp_rem_member_review_option'] == 'on' ) {
                    $wpdb->update(
                        $wpdb->prefix . 'users', array( 'user_status' => 1 ), array( 'ID' => esc_sql($user_id) )
                    );
                } else {
                    $wpdb->update(
                        $wpdb->prefix . 'users', array( 'user_status' => 0 ), array( 'ID' => esc_sql($user_id) )
                    );
                }
				

                $company_name = $wp_rem_first_name . ' ' . $wp_rem_last_name;
                $company_data = array(
                    'post_title' => wp_strip_all_tags($company_name),
                    'post_type' => 'members',
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_author' => 1,
                );
                $company_ID = wp_insert_post($company_data);
                if ( $company_ID ) {
                    update_user_meta($user_id, 'wp_rem_user_type', 'supper-admin');
                    update_post_meta($company_ID, 'wp_rem_member_profile_type', 'individual');
                    update_post_meta($company_ID, 'wp_rem_member_user_type', 'reseller');
                    
                    if ( isset($wp_rem_member_image_id) && $wp_rem_member_image_id != '' ) {
                        update_post_meta($company_ID, 'wp_rem_profile_image', $wp_rem_member_image_id);
                    }
                }

                update_user_meta($user_id, 'show_admin_bar_front', false);
                update_user_meta($user_id, 'wp_rem_is_admin', 1);
                update_user_meta($user_id, 'wp_rem_company', $company_ID);

                if ( isset($wp_rem_facebook) && $wp_rem_facebook != '' ) {
                    update_user_meta($user_id, 'wp_rem_facebook', $wp_rem_facebook);
                }
                if ( isset($wp_rem_twitter) && $wp_rem_twitter != '' ) {
                    update_user_meta($user_id, 'wp_rem_twitter', $wp_rem_twitter);
                }
                update_user_meta($user_id, 'wp_rem_user_registered', $social_login_provider);
                if ( $user_id && is_integer($user_id) ) {
                    update_user_meta($user_id, $wp_rem_provider_identity_key, $wp_rem_provider_identity);
                }
				
				// Update Member Status
                if ( isset($wp_rem_plugin_options['wp_rem_member_review_option']) && $wp_rem_plugin_options['wp_rem_member_review_option'] == 'on' ) {
                    update_post_meta($company_ID, 'wp_rem_user_status', 'active');
                } else {
                   update_post_meta($company_ID, 'wp_rem_user_status', 'pending');
				}
			} else {
                add_filter('wp_login_errors', 'wp_login_errors');

                return;
            }
        }

        wp_set_auth_cookie($user_id);
        do_action('social_connect_login', $user_login);

        if ( $is_ajax ) {
            echo '{"redirect":"' . $redirect_to . '"}';
        } else {
            wp_safe_redirect($redirect_to);
        }

        exit();
    }

}

/*
 *  login error
 */
if ( ! function_exists('wp_rem_login_errors') ) {

    function wp_rem_login_errors($errors) {
        $errors->errors = array();
        $errors->add('registration_disabled', '<strong>' . wp_rem_plugin_text_srt('wp_rem_social_login_error') . '</strong>:', wp_rem_plugin_text_srt('wp_rem_social_login_reg_disable'));
        return $errors;
    }

}

/*
 *  get unique username
 */
if ( ! function_exists('wp_rem_get_unique_username') ) {

    function wp_rem_get_unique_username($user_login, $c = 1) {
        if ( username_exists($user_login) ) {
            if ( $c > 5 )
                $append = '_' . substr(md5($user_login), 0, 3) . $c;
            else
                $append = $c;

            $user_login = apply_filters('social_login_username_exists', $user_login . $append);
            return wp_rem_get_unique_username($user_login, ++ $c);
        } else {
            return $user_login;
        }
    }

    add_action('login_form_social_login', 'wp_rem_social_process_login');
}

/*
 *  AJAX login
 */
if ( ! function_exists('wp_rem_ajax_login') ) {

    function wp_rem_ajax_login() {
        if ( isset($_POST['login_submit']) && $_POST['login_submit'] == 'ajax' && // Plugins will need to pass this param
                isset($_POST['action']) && $_POST['action'] == 'social_login' )
            wp_rem_social_process_login(true);
    }

    add_action('init', 'wp_rem_ajax_login');
}
/*
 *  filter user avatar
 */
if ( ! function_exists('wp_rem_filter_avatar') ) {

    function wp_rem_filter_avatar($avatar, $id_or_email, $size, $default, $alt) {
        $custom_avatar = '';
        $social_id = '';
        $provider_id = '';
        $user_id = ( ! is_integer($id_or_email) && ! is_string($id_or_email) && get_class($id_or_email)) ? $id_or_email->user_id : $id_or_email;

        if ( ! empty($user_id) ) {
            $providers = array( 'facebook', 'twitter' );
            $social_login_provider = isset($_COOKIE['social_login_current_provider']) ? $_COOKIE['social_login_current_provider'] : '';
            if ( ! empty($social_login_provider) && $social_login_provider == 'twitter' ) {
                $providers = array( 'twitter', 'facebook' );
            }
            foreach ( $providers as $search_provider ) {
                $social_id = get_user_meta($user_id, 'social_login_' . $search_provider . '_id', true);
                if ( ! empty($social_id) ) {
                    $provider_id = $search_provider;
                    break;
                }
            }
        }
        if ( ! empty($social_id) ) {
            
        }

        if ( ! empty($custom_avatar) ) {
            update_user_meta($user_id, 'custom_avatar', $custom_avatar);
            $return = '<img class="avatar" src="' . esc_url($custom_avatar) . '" style="width:' . $size . 'px" alt="' . $alt . '" />';
        } else if ( $avatar ) {
            // gravatar
            $return = $avatar;
        } else {
            // default
            $return = '<img class="avatar" src="' . esc_url($default) . '" style="width:' . $size . 'px" alt="' . $alt . '" />';
        }

        return $return;
    }

}
/*
 *  social add comment meta
 */
if ( ! function_exists('wp_rem_social_add_comment_meta') ) {

    function wp_rem_social_add_comment_meta($comment_id) {
        $social_login_comment_via_provider = isset($_POST['social_login_comment_via_provider']) ? $_POST['social_login_comment_via_provider'] : '';
        if ( $social_login_comment_via_provider != '' ) {
            update_comment_meta($comment_id, 'social_login_comment_via_provider', $social_login_comment_via_provider);
        }
    }

    add_action('comment_post', 'wp_rem_social_add_comment_meta');
}
/*
 *  social comment meta
 */
if ( ! function_exists('wp_rem_social_comment_meta') ) {

    function wp_rem_social_comment_meta($link) {
        global $comment;
        $images_url = get_template_directory_uri() . '/media/img/';
        if ( is_object($comment) ) {
            $social_login_comment_via_provider = get_comment_meta($comment->comment_ID, 'social_login_comment_via_provider', true);
            if ( $social_login_comment_via_provider && current_user_can('manage_options') ) {
                return $link . '&nbsp;<img class="social_login_comment_via_provider" alt="' . $social_login_comment_via_provider . '" src="' . $images_url . $social_login_comment_via_provider . '_16.png"  />';
            } else {
                return $link;
            }
        }
        return $link;
    }

    add_action('get_comment_author_link', 'wp_rem_social_comment_meta');
}
/*
 *  social login form
 */
if ( ! function_exists('wp_rem_comment_form_social_login') ) {

    function wp_rem_comment_form_social_login() {
        if ( comments_open() && ! is_user_logged_in() ) {
            wp_rem_social_login_form();
        }
    }

}
/*
 *  login page url
 */
if ( ! function_exists('wp_rem_login_page_uri') ) {

    function wp_rem_login_page_uri() {
        global $wp_rem_form_fields_frontend;
        $wp_rem_opt_array = array(
            'id' => '',
            'cust_id' => 'social_login_form_uri',
            'std' => esc_url(site_url('wp-login.php', 'login_post')),
            'cust_type' => 'hidden',
            'classes' => '',
        );

        $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
    }

    add_action('wp_footer', 'wp_rem_login_page_uri');
}
/*
 *  get user by meta key
 */
if ( ! function_exists('wp_rem_social_get_user_by_meta') ) {

    function wp_rem_social_get_user_by_meta($meta_key, $meta_value) {
        global $wpdb;
        $sql = "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = '%s' AND meta_value = '%s'";
        return $wpdb->get_var($wpdb->prepare($sql, $meta_key, $meta_value));
    }

}

/*
 *  generate social signature
 */
if ( ! function_exists('wp_rem_social_generate_signature') ) {

    function wp_rem_social_generate_signature($data) {
        return hash('SHA256', AUTH_KEY . $data);
    }

}

/*
 * login verify signature
 */
if ( ! function_exists('wp_rem_social_login_verify_signature') ) {

    function wp_rem_social_login_verify_signature($data, $signature, $redirect_to) {
        $generated_signature = wp_rem_social_generate_signature($data);
        if ( $generated_signature != $signature ) {
            wp_safe_redirect($redirect_to);
            exit();
        }
    }

}

/*
 *  get the contents of url
 */
if ( ! function_exists('wp_rem_http_get_contents') ) {

    function wp_rem_http_get_contents($url) {
        $response = wp_remote_get($url);
        if ( is_wp_error($response) ) {
            die(sprintf(wp_rem_plugin_text_srt('wp_rem_social_login_smthng_went_wrong'), $response->get_error_message()));
        } else {
            return $response['body'];
        }
    }

}
/*
 *  add custom styling
 */
if ( ! function_exists('wp_rem_add_stylesheets') ) {

    function wp_rem_add_stylesheets() {
        if ( is_admin() ) {
            if ( ! wp_style_is('social_login', 'registered') ) {

                wp_register_style("social_login_css", plugins_url('media/css/cs-social-style.css', __FILE__));
            }
            if ( did_action('wp_print_styles') ) {
                wp_print_styles('social_login');
                wp_print_styles('wp-jquery-ui-dialog');
            } else {
                wp_enqueue_style("social_login");
                wp_enqueue_style("wp-jquery-ui-dialog");
            }
        }
    }

    add_action('login_enqueue_scripts', 'wp_rem_add_stylesheets');
    add_action('wp_head', 'wp_rem_add_stylesheets');
}

/*
 *  add admin side styling
 */
if ( ! function_exists('wp_rem_add_admin_stylesheets') ) {

    function wp_rem_add_admin_stylesheets() {
        if ( is_admin() ) {
            if ( ! wp_style_is('social_login', 'registered') ) {
                wp_register_style("social_login_css", plugins_url('media/css/cs-social-style.css', __FILE__));
            }

            if ( did_action('wp_print_styles') ) {
                wp_print_styles('social_login');
            } else {
                wp_enqueue_style("social_login");
            }
        }
    }

    add_action('admin_print_styles', 'wp_rem_add_admin_stylesheets');
}
/*
 *  add javascripts files
 */
if ( ! function_exists('wp_rem_add_javascripts') ) {

    function wp_rem_add_javascripts() {
        if ( is_admin() ) {
            $deps = array( 'jquery', 'jquery-ui-core', 'jquery-ui-dialog' );
            $wordpress_enabled = 0;


            if ( $wordpress_enabled ) {
                $deps[] = 'jquery-ui-dialog';
            }

            if ( ! wp_script_is('social_login_js', 'registered') )
                wp_register_script('social_login_js', plugins_url('media/js/cs-connect.js', __FILE__), $deps);

            wp_enqueue_script('social_login_js');
            wp_localize_script('social_login_js', 'social_login_data', array( 'wordpress_enabled' => $wordpress_enabled ));
        }
    }

    add_action('login_enqueue_scripts', 'wp_rem_add_javascripts');
    add_action('wp_enqueue_scripts', 'wp_rem_add_javascripts');
}
/*
 *  Twitter Callback
 */
if ( ! function_exists('wp_rem_twitter_callback') ) {

    function wp_rem_twitter_callback() {
        global $wp_rem_plugin_options;
        $consumer_key = isset($wp_rem_plugin_options['wp_rem_consumer_key']) ? $wp_rem_plugin_options['wp_rem_consumer_key'] : '';
        $consumer_secret = isset($wp_rem_plugin_options['wp_rem_consumer_secret']) ? $wp_rem_plugin_options['wp_rem_consumer_secret'] : '';

        if ( ! class_exists('TwitterOAuth') ) {
            require_once wp_rem::plugin_dir() . 'include/cs-twitter/twitteroauth.php';
        }
        $oauth_token = get_transient('oauth_token');
        $oauth_token_secret = get_transient('oauth_token_secret');
        if ( ! empty($oauth_token) && ! empty($oauth_token_secret) ) {
            $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
            $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
            set_transient('access_token', $access_token, (3600 * 60) * 24);
            delete_transient('oauth_token');
            delete_transient('oauth_token_secret');
        }

        if ( 200 == $connection->http_code ) {
            set_transient('status', 'verified', (3600 * 60) * 24);
            $user = $connection->get('account/verify_credentials');
            $member_profile_image = $user->profile_image_url;
            //$member_profile_image_id = '';
            //if ( isset($member_profile_image) && $member_profile_image != '' ) {
            //$member_profile_image_id = upload_member_profile_image($member_profile_image);
            //}
            $name = $user->name;
            $screen_name = $user->screen_name;
            $twitter_id = $user->id;
            $signature = wp_rem_social_generate_signature($twitter_id);
            ?>
            <html>
                <head>
                    <script>
                        function init() {
                            window.opener.wp_social_login({'action': 'social_login', 'social_login_provider': 'twitter',
                                'social_login_signature': '<?php echo esc_attr($signature) ?>',
                                'social_login_twitter_identity': '<?php echo esc_attr($twitter_id) ?>',
                                'social_login_screen_name': '<?php echo esc_attr($screen_name) ?>',
                                'social_profile_image_url': '<?php echo esc_attr($member_profile_image) ?>',
                                'social_login_name': '<?php echo esc_attr($name) ?>'});
                            window.close();
                        }
                    </script>
                </head>
                <body onLoad="init();"></body>
            </html>
            <?php
            die();
        } else {
            echo wp_rem_plugin_text_srt('wp_rem_social_login_login_error');
        }
    }

}

/*
 *  Upload member profile image
 */
if ( ! function_exists('upload_member_profile_image') ) {

    function upload_member_profile_image($member_profile_image) {
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $wp_upload_dir = wp_upload_dir();
        $image_data = file_get_contents($member_profile_image);
        $member_profile_image = explode('?', $member_profile_image);
        $member_profile_image = $member_profile_image[0];
        $filename = basename($member_profile_image);
        $file = $wp_upload_dir['path'] . '/' . $filename;

        file_put_contents($file, $image_data);

        $filetype = wp_check_filetype(basename($member_profile_image), null);
        $attachment = array(
            'post_mime_type' => $filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename($member_profile_image)),
            'guid' => $wp_upload_dir['url'] . '/' . basename($member_profile_image),
        );

        $profile_image_id = wp_insert_attachment($attachment, $file);
        $attach_data = wp_generate_attachment_metadata($profile_image_id, $file);
        wp_update_attachment_metadata($profile_image_id, $attach_data);
        $member_profile_image_id = $profile_image_id;
        return $member_profile_image_id;
    }

}
/*
 *  Twitter connect
 */
if ( ! function_exists('wp_rem_twitter_connect') ) {

    function wp_rem_twitter_connect() {
        global $wp_rem_plugin_options;
        if ( ! class_exists('TwitterOAuth') ) {
            require_once wp_rem::plugin_dir() . 'include/cs-twitter/twitteroauth.php';
        }
        $consumer_key = $wp_rem_plugin_options['wp_rem_consumer_key'];
        $consumer_secret = $wp_rem_plugin_options['wp_rem_consumer_secret'];
        $twitter_oath_callback = home_url('index.php?social-login=twitter-callback');
        if ( $consumer_key != '' && $consumer_secret != '' ) {
            $connection = new TwitterOAuth($consumer_key, $consumer_secret);
            $request_token = $connection->getRequestToken($twitter_oath_callback);

            if ( ! empty($request_token) ) {
                set_transient('oauth_token', $request_token['oauth_token'], (3600 * 60) * 24);
                set_transient('oauth_token_secret', $request_token['oauth_token_secret'], (3600 * 60) * 24);
                $token = $request_token['oauth_token'];
            }

            switch ( $connection->http_code ) {
                case 200:
                    $url = $connection->getAuthorizeURL($token);
                    wp_redirect($url);
                    break;
                default:
                    echo esc_html($connection->http_code);
                    echo wp_rem_plugin_text_srt('wp_rem_social_login_contact_site_admin');
            }
            exit();
        }
    }

}
/*
 *  Facebook Callback
 */
if ( ! function_exists('wp_rem_facebook_callback') ) {

    function wp_rem_facebook_callback() {
        global $wp_rem_plugin_options;

        require_once plugin_dir_url(__FILE__) . 'facebook/facebook.php';


        $client_id = $wp_rem_plugin_options['wp_rem_facebook_app_id'];
        $secret_key = $wp_rem_plugin_options['wp_rem_facebook_secret'];


        if ( isset($_GET['code']) ) {
            $code = $_GET['code'];
            $access_token = $code;
            parse_str(wp_rem_http_get_contents("https://graph.facebook.com/oauth/access_token?" .
                            'client_id=' . $client_id . '&redirect_uri=' . home_url('index.php?social-login=facebook-callback') .
                            '&client_secret=' . $secret_key .
                            '&code=' . urlencode($code)));
            $signature = wp_rem_social_generate_signature($access_token);
            do_action('social_login_before_register_facebook', $code, $signature, $access_token);
            ?>
            <html>
                <head>
                    <script>
                        function init() {
                            window.opener.wp_social_login({'action': 'social_login', 'social_login_provider': 'facebook',
                                'social_login_signature': '<?php echo esc_attr($signature) ?>',
                                'social_login_access_token': '<?php echo esc_attr($access_token) ?>'});
                            window.close();
                        }
                    </script>
                </head>
                <body onLoad="init();"></body>
            </html>
            <?php
        } else {
            $redirect_uri = urlencode(plugin_dir_url(__FILE__) . 'facebook/callback.php');
            wp_redirect('https://graph.facebook.com/oauth/authorize?client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&scope=email');
        }
    }

}