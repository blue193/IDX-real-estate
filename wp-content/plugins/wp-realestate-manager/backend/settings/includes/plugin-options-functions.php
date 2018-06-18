<?php

/* ------------------------------------------------------
 * Save Option
 * ----------------------------------------------------- */
/**
 * Start Function  how to Save Plugin Options
 */
if ( ! function_exists('plugin_option_save') ) {

    function plugin_option_save() {
        global $reset_plugin_data, $wp_rem_setting_options;
        $_POST['wp_rem_linkedin_app_redirect_uri'] = site_url();
        $_POST = stripslashes_htmlspecialchars($_POST);
        $_POST = update_fixed_price_opt($_POST);
        update_option("wp_rem_plugin_options", $_POST);
        wp_rem_update_extras_options();
        wp_rem_update_packages_options();
        wp_rem_update_feats();
        $response = wp_rem_plugin_text_srt('wp_rem_opt_func_option_saved');

        echo wp_rem_cs_allow_special_char($response);
        die();
    }

    add_action('wp_ajax_plugin_option_save', 'plugin_option_save');
}

if ( ! function_exists('wp_rem_check_plugin_fields_avail') ) {

    function wp_rem_check_plugin_fields_avail() {
        global $wp_rem_plugin_options;

        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $member_value = isset($wp_rem_plugin_options['member_value']) ? $wp_rem_plugin_options['member_value'] : '';
        $error_flag = false;
        $wp_rem_json = array();

        if ( $name == '' ) {
            $error_flag = true;
            $wp_rem_json['type'] = 'error';
            $wp_rem_json['message'] = esc_html('Required field', 'wp-rem');
        } elseif ( preg_match('/\s/', $name) ) {
            $error_flag = true;
            $wp_rem_json['type'] = 'error';
            $wp_rem_json['message'] = esc_html('Space not Allowed', 'wp-rem');
        } elseif ( preg_match('/[\'^�$%&*()}{@#~?><>,|=+�]/', $name) ) {
            $error_flag = true;
            $wp_rem_json['type'] = 'error';
            $wp_rem_json['message'] = esc_html('Special characters are not Allowed', 'wp-rem');
        } elseif ( is_array($member_value) && sizeof($member_value) > 0 ) {
            foreach ( $member_value as $key => $value ) {
                if ( $name == $value ) {
                    $error_flag = true;
                    $wp_rem_json['type'] = 'error';
                    $wp_rem_json['message'] = esc_html('Name already exists', 'wp-rem');
                }
            }
        }
        if ( $error_flag != true ) {
            $wp_rem_json['type'] = 'success';
            $wp_rem_json['message'] = esc_html('Name Available', 'wp-rem');
        }
        echo json_encode($wp_rem_json);
        wp_die();
    }

    add_action('wp_ajax_wp_rem_check_plugin_fields_avail', 'wp_rem_check_plugin_fields_avail');
}









/**
 * Start Function  for taking backup options fields
 */
if ( ! function_exists('wp_rem_pl_opt_backup_generate') ) {

    function wp_rem_pl_opt_backup_generate() {
        global $wp_filesystem;
        $wp_rem_export_options = get_option('wp_rem_plugin_options');
        $wp_rem_option_fields = json_encode($wp_rem_export_options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
        $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=wp_rem_settings');
        if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {
            return true;
        }
        if ( ! WP_Filesystem($creds) ) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/backups/';
        $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . (current_time('d-M-Y_H.i.s')) . '.json';


        if ( ! $wp_filesystem->put_contents($wp_rem_filename, $wp_rem_option_fields, FS_CHMOD_FILE) ) {
            echo wp_rem_plugin_text_srt('wp_rem_opt_func_error_saving');
        } else {
            echo wp_rem_plugin_text_srt('wp_rem_opt_func_backup_generated');
        }
        die();
    }

    add_action('wp_ajax_wp_rem_pl_opt_backup_generate', 'wp_rem_pl_opt_backup_generate');
}
/**
 * end Function  for taking backup options fields
 */
/**
 * Start Function  for demo setting
 */
if ( ! function_exists('wp_rem_get_settings_demo') ) {

    function wp_rem_get_settings_demo($wp_rem_demo_file = '') {
        // global $wp_filesystem;
        // $backup_url = '';
        // if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {
        //     return true;
        // }
        // if ( ! WP_Filesystem($creds) ) {
        //     request_filesystem_credentials($backup_url, '', true, false, array());
        //     return true;
        // }
        $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/demo/';
        $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . $wp_rem_demo_file;
        $wp_rem_demo_data = array();
        if ( is_file($wp_rem_filename) ) {
            $get_options_file = file_get_contents($wp_rem_filename);

            $wp_rem_demo_data = $get_options_file;
        }
        return $wp_rem_demo_data;
    }

}

if ( ! function_exists('wp_rem_demo_plugin_data') ) {

    function wp_rem_demo_plugin_data($filename = "") {
        // if $filename is not provided then go with the existing import plugin settings
        // else fetch JSON from external file and use those for importing
        if ( $filename == "" ) {
            global $wp_rem_settings_init;
            $demo_plugin_data = '';
            if ( isset($wp_rem_settings_init) && $wp_rem_settings_init <> '' ) {
                $wp_rem_settings = $wp_rem_settings_init['plugin_options'];
                $plugin_settings = json_decode($wp_rem_settings, true);
                $demo_plugin_data = $plugin_settings;
            }
        } else {
            global $wp_filesystem;
            $wp_rem_settings = $wp_filesystem->get_contents($filename);
            $plugin_settings = json_decode($wp_rem_settings, true);
            $demo_plugin_data = $plugin_settings;
        }

        delete_option('wp_rem_plugin_options');
        update_option("wp_rem_plugin_options", $demo_plugin_data);
    }

}

/**
 * Start Function  for demo setting
 */
/**
 * Start Function  that how to take backup deleted files
 */
if ( ! function_exists('wp_rem_pl_backup_file_delete') ) {

    function wp_rem_pl_backup_file_delete() {
        global $wp_filesystem;
        $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=wp_rem_settings');
        if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {
            return true;
        }
        if ( ! WP_Filesystem($creds) ) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/backups/';

        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';
        $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . $file_name;
        if ( is_file($wp_rem_filename) ) {
            unlink($wp_rem_filename);
            printf(wp_rem_plugin_text_srt('wp_rem_opt_func_file_delete'), $file_name);
        } else {
            echo wp_rem_plugin_text_srt('wp_rem_opt_func_error_delete');
        }
        die();
    }

    add_action('wp_ajax_wp_rem_pl_backup_file_delete', 'wp_rem_pl_backup_file_delete');
}
/**
 * end Function  that how to take backup deleted files
 */
/**
 * Start Function  for restoreing backup the data
 */
if ( ! function_exists('wp_rem_pl_backup_file_restore') ) {

    function wp_rem_pl_backup_file_restore() {
        global $wp_filesystem;
        $backup_url = wp_nonce_url('edit.php?post_type=vehicles&page=wp_rem_settings');
        if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {
            return true;
        }
        if ( ! WP_Filesystem($creds) ) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/backups/';
        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';
        $file_path = isset($_POST['file_path']) ? $_POST['file_path'] : '';
        if ( $file_path == 'yes' ) {
            $wp_rem_file_body = '';
            $wp_rem_file_response = wp_remote_get($file_name);
            if ( is_array($wp_rem_file_response) ) {
                $wp_rem_file_body = isset($wp_rem_file_response['body']) ? $wp_rem_file_response['body'] : '';
            }
            if ( $wp_rem_file_body != '' ) {
                $get_options_file = json_decode($wp_rem_file_body, true);
                update_option("wp_rem_plugin_options", $get_options_file);

                echo wp_rem_plugin_text_srt('wp_rem_options_file_import_success');
            } else {
                echo wp_rem_plugin_text_srt('wp_rem_options_error_restoring_file');
            }
            die;
        }
        $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . $file_name;
        if ( is_file($wp_rem_filename) ) {
            $get_options_file = $wp_filesystem->get_contents($wp_rem_filename);
            $get_options_file = json_decode($get_options_file, true);
            update_option("wp_rem_plugin_options", $get_options_file);
            printf(wp_rem_plugin_text_srt('wp_rem_opt_func_restore_file'), $file_name);
        } else {
            echo wp_rem_plugin_text_srt('wp_rem_options_error_restoring_file');
        }
        die();
    }

    add_action('wp_ajax_wp_rem_pl_backup_file_restore', 'wp_rem_pl_backup_file_restore');
}
/**
 * end Function  for restoreing backup the data
 */
/**
 * Start Function  for reset all pluging
 */
if ( ! function_exists('plugin_option_rest_all') ) {

    function plugin_option_rest_all() {
        global $wp_filesystem;
        $backup_url = home_url('/');
        if ( false === ($creds = request_filesystem_credentials($backup_url, '', false, false, array()) ) ) {
            return true;
        }
        if ( ! WP_Filesystem($creds) ) {
            request_filesystem_credentials($backup_url, '', true, false, array());
            return true;
        }
        $wp_rem_upload_dir = wp_rem::plugin_dir() . 'backend/settings/default-settings/';
        $wp_rem_filename = trailingslashit($wp_rem_upload_dir) . 'default-settings.json';
        if ( is_file($wp_rem_filename) ) {
            $get_options_file = $wp_filesystem->get_contents($wp_rem_filename);
            $get_options_file = json_decode($get_options_file, true);
            update_option("wp_rem_plugin_options", $get_options_file);
        }
        die;
    }

    add_action('wp_ajax_plugin_option_rest_all', 'plugin_option_rest_all');
}
/**
 * end Function  for reset all pluging
 *
 * Start Function  for update package option data
 */
if ( ! function_exists('wp_rem_update_packages_options') ) {

    function wp_rem_update_packages_options() {
        $data = get_option("wp_rem_plugin_options");
        $package_counter = 0;
        $package_array = $packages = $packagesdata = array();
        if ( isset($_POST['package_id_array']) && ! empty($_POST['package_id_array']) ) {
            foreach ( $_POST['package_id_array'] as $keys => $values ) {
                if ( $values ) {
                    $package_array['package_id'] = $_POST['package_id_array'][$package_counter];
                    $package_array['package_title'] = $_POST['package_title_array'][$package_counter];
                    $package_array['package_price'] = $_POST['package_price_array'][$package_counter];
                    $package_array['package_duration'] = $_POST['package_duration_array'][$package_counter];
                    $package_array['package_duration_period'] = $_POST['package_duration_period_array'][$package_counter];
                    $package_array['package_description'] = $_POST['package_description_array'][$package_counter];
                    $package_array['package_type'] = $_POST['package_type_array'][$package_counter];
                    if ( isset($_POST['package_type_array'][$package_counter]) && $_POST['package_type_array'][$package_counter] == 'single' ) {
                        $package_array['package_properties'] = 1;
                    } else {
                        $package_array['package_properties'] = $_POST['package_properties_array'][$package_counter];
                    }
                    $package_array['package_cvs'] = $_POST['package_cvs_array'][$package_counter];
                    $package_array['package_submission_limit'] = $_POST['package_submission_limit_array'][$package_counter];
                    $package_array['wp_rem_list_dur'] = $_POST['wp_rem_list_dur_array'][$package_counter];
                    $package_array['package_feature'] = $_POST['package_feature_array'][$package_counter];
                    $packages[$values] = $package_array;
                    $package_counter ++;
                }
            }
        }
        // Update Packages
        $packagesdata['wp_rem_packages_options'] = $packages;
        $wp_rem_options = array_merge($data, $packagesdata);
        update_option("wp_rem_plugin_options", $wp_rem_options);
    }

}
/**
 * end Function  for update package option data
 */
/**
 * Start Function  how to remove html tags
 */
if ( ! function_exists('stripslashes_htmlspecialchars') ) {

    function stripslashes_htmlspecialchars($value) {
        $value = is_array($value) ? array_map('stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
        return $value;
    }

}
/**
 * End Function  how to remove html tags
 */
/**
 * Start Function  how to update extras options
 */
/* ------------------------------------------------------
 * Update Extras
 * ----------------------------------------------------- */
if ( ! function_exists('wp_rem_update_extras_options') ) {

    function wp_rem_update_extras_options() {
        $data = get_option("wp_rem_plugin_options");
        $extra_feature_counter = 0;
        $extra_feature_array = $extra_features = $extrasdata = array();
        if ( isset($_POST['extra_feature_id_array']) && ! empty($_POST['extra_feature_id_array']) ) {
            foreach ( $_POST['extra_feature_id_array'] as $keys => $values ) {
                if ( $values ) {
                    $extra_feature_array['extra_feature_id'] = $_POST['extra_feature_id_array'][$extra_feature_counter];
                    $extra_feature_array['wp_rem_extra_feature_title'] = $_POST['wp_rem_extra_feature_title_array'][$extra_feature_counter];
                    $extra_feature_array['wp_rem_extra_feature_price'] = $_POST['wp_rem_extra_feature_price_array'][$extra_feature_counter];
                    $extra_feature_array['wp_rem_extra_feature_type'] = $_POST['wp_rem_extra_feature_type_array'][$extra_feature_counter];
                    $extra_feature_array['wp_rem_extra_feature_guests'] = $_POST['wp_rem_extra_feature_guests_array'][$extra_feature_counter];
                    $extra_feature_array['wp_rem_extra_feature_fchange'] = $_POST['wp_rem_extra_feature_fchange_array'][$extra_feature_counter];
                    $extra_feature_array['wp_rem_extra_feature_desc'] = $_POST['wp_rem_extra_feature_desc_array'][$extra_feature_counter];
                    $extra_features[$values] = $extra_feature_array;
                    $extra_feature_counter ++;
                }
            }
        }
        $extrasdata['wp_rem_extra_features_options'] = $extra_features;
        $wp_rem_options = array_merge($data, $extrasdata);
        update_option("wp_rem_plugin_options", $wp_rem_options);
        $obj = new wp_rem_plugin_options();
        $obj->wp_rem_remove_duplicate_extra_value();
    }

}
/**
 * end Function  how to update extras options
 */
/**
 * Start Function  how to update Features options
 */
if ( ! function_exists('wp_rem_update_feats') ) {

    function wp_rem_update_feats() {
        $data = get_option("wp_rem_plugin_options");
        $feats_counter = 0;
        $feats_array = $feats = $extrasdata = array();
        if ( isset($_POST['feats_id_array']) && ! empty($_POST['feats_id_array']) ) {
            foreach ( $_POST['feats_id_array'] as $keys => $values ) {
                if ( $values ) {
                    $feats_array['feats_id'] = $_POST['feats_id_array'][$feats_counter];
                    $feats_array['wp_rem_feats_title'] = $_POST['wp_rem_feats_title_array'][$feats_counter];
                    $feats_array['wp_rem_feats_image'] = $_POST['wp_rem_feats_image_array'][$feats_counter];
                    $feats_array['wp_rem_feats_desc'] = $_POST['wp_rem_feats_desc_array'][$feats_counter];
                    $feats[$values] = $feats_array;
                    $feats_counter ++;
                }
            }
        }
        $extrasdata['wp_rem_feats_options'] = $feats;
        $wp_rem_options = array_merge($data, $extrasdata);
        update_option("wp_rem_plugin_options", $wp_rem_options);
    }

}
/**
 * end Function  how to update extras options
 */
/**
 * Start Function  how to get currency Symbols
 */
if ( ! function_exists('wp_rem_get_currency_symbol') ) {

    function wp_rem_get_currency_symbol() {
        $code = $_POST['code'];
        $currency_list = wp_rem_get_currency();
        echo WP_REM_FUNCTIONS()->special_chars($currency_list[$code]['symbol']);
        die();
    }

    add_action('wp_ajax_wp_rem_get_currency_symbol', 'wp_rem_get_currency_symbol');
}
/**
 * end Function  how to get currency Symbols
 */
if ( ! function_exists("wp_rem_get_lk_page") ) {

    function wp_rem_get_lk_page($url, $ref = '', $ctOnly = false, $fields = '', $advSettings = '', $ch = false) {

        if ( ! $ch )
            $ch = curl_init($url);
        else
            curl_setopt($ch, CURLOPT_URL, $url);

        $ccURL = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
        static $curl_loops = 0;
        static $curl_max_loops = 20;
        global $xyzsmap_gCookiesArr;

        $cookies = '';
        if ( is_array($xyzsmap_gCookiesArr) )
            foreach ( $xyzsmap_gCookiesArr as $cName => $cVal )
                $cookies .= $cName . '=' . $cVal . '; ';


        if ( $curl_loops ++ >= $curl_max_loops ) {
            $curl_loops = 0;
            curl_close($ch);
            return false;
        }
        $headers = array();

        if ( $fields != '' )
            $field_type = "POST";
        else
            $field_type = "GET";


        $headers[] = 'Cache-Control: max-age=0';
        $headers[] = 'Connection: Keep-Alive';
        $headers[] = 'Referer: ' . $url;
        $headers[] = 'User-Member: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.22 Safari/537.36';
        if ( $field_type == 'POST' )
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';

        if ( isset($advSettings['liXMLHttpRequest']) ) {
            $headers[] = 'X-Requested-With: XMLHttpRequest';
        }
        if ( isset($advSettings['Origin']) ) {
            $headers[] = 'Origin: ' . $advSettings['Origin'];
        }
        if ( $field_type == 'GET' )
            $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
        else
            $headers[] = 'Accept: */*';

        $headers[] = 'Accept-Encoding: deflate,sdch';
        $headers[] = 'Accept-Language: en-US,en;q=0.8';



        if ( isset($advSettings['noSSLSec']) ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }

        if ( isset($advSettings['proxy']) && $advSettings['proxy']['host'] != '' && $advSettings['proxy']['port'] !== '' ) {
            curl_setopt($ch, CURLOPT_TIMEOUT, 4);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
            curl_setopt($ch, CURLOPT_PROXY, $advSettings['proxy']['host']);
            curl_setopt($ch, CURLOPT_PROXYPORT, $advSettings['proxy']['port']);
            if ( isset($advSettings['proxy']['up']) && $advSettings['proxy']['up'] != '' ) {
                curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_ANY);
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $advSettings['proxy']['up']);
            }
        }
        if ( isset($advSettings['headers']) ) {
            $headers = array_merge($headers, $advSettings['headers']);
        }
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        if ( is_string($ref) && $ref != '' )
            curl_setopt($ch, CURLOPT_REFERER, $ref);
        curl_setopt($ch, CURLOPT_REFERER, (( isset($advSettings['UA']) && $advSettings['UA'] != '') ? $advSettings['UA'] : "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.44 Safari/537.36"));

        if ( $fields != '' ) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        } else {
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, '');
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        $content = curl_exec($ch);

        $errmsg = curl_error($ch);
        if ( isset($errmsg) && stripos($errmsg, 'SSL') !== false ) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $content = curl_exec($ch);
        }
        if ( strpos($content, "\n\n") != false && strpos($content, "\n\n") < 100 )
            $content = substr_replace($content, "\n", strpos($content, "\n\n"), strlen("\n\n"));
        if ( strpos($content, "\r\n\r\n") != false && strpos($content, "\r\n\r\n") < 100 )
            $content = substr_replace($content, "\r\n", strpos($content, "\r\n\r\n"), strlen("\r\n\r\n"));
        $ndel = strpos($content, "\n\n");
        $rndel = strpos($content, "\r\n\r\n");
        if ( $ndel == false )
            $ndel = 1000000;
        if ( $rndel == false )
            $rndel = 1000000;
        $rrDel = $rndel < $ndel ? "\r\n\r\n" : "\n\n";
        list($header, $content) = explode($rrDel, $content, 2);
        if ( $ctOnly !== true ) {
            $fullresponse = curl_getinfo($ch);
            $err = curl_errno($ch);
            $errmsg = curl_error($ch);
            $fullresponse['errno'] = $err;
            $fullresponse['errmsg'] = $errmsg;
            $fullresponse['headers'] = $header;
            $fullresponse['content'] = $content;
        }
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = curl_getinfo($ch);

        if ( empty($headers['request_header']) )
            $headers['request_header'] = 'Host: None' . "\n";

        $results = array();
        preg_match_all('|Host: (.*)\n|U', $headers['request_header'], $results);
        $ckDomain = str_replace('.', '_', $results[1][0]);
        $ckDomain = str_replace("\r", "", $ckDomain);
        $ckDomain = str_replace("\n", "", $ckDomain);


        $results = array();
        $cookies = '';
        preg_match_all('|Set-Cookie: (.*);|U', $header, $results);
        $carTmp = $results[1];
        preg_match_all('/Set-Cookie: (.*)\b/', $header, $xck);
        $xck = $xck[1];
        if ( isset($advSettings['cdomain']) && $advSettings['cdomain'] != '' ) {
            foreach ( $carTmp as $iii => $cTmp )
                if ( stripos($xck[$iii], 'Domain=') === false || stripos($xck[$iii], 'Domain=.' . $advSettings['cdomain'] . ';') !== false ) {
                    $temp = explode('=', $cTmp, 2);
                    $xyzsmap_gCookiesArr[$temp[0]] = $temp[1];
                }
        } else {
            foreach ( $carTmp as $cTmp ) {
                $temp = explode('=', $cTmp, 2);
                $xyzsmap_gCookiesArr[$temp[0]] = $temp[1];
            }
        }

        $rURL = '';

        if ( $http_code == 200 && stripos($content, 'http-equiv="refresh" content="0; url=&#39;') !== false ) {
            $http_code = 301;
            $rURL = '';
            $xyzsmap_gCookiesArr = array();
        } elseif ( $http_code == 200 && stripos($content, 'location.replace') !== false ) {
            $http_code = 301;
            $rURL = '';
        }
        if ( $http_code == 301 || $http_code == 302 || $http_code == 303 ) {
            if ( $rURL != '' ) {
                $rURL = str_replace('\x3d', '=', $rURL);
                $rURL = str_replace('\x26', '&', $rURL);
                $url = @parse_url($rURL);
            } else {
                $matches = array();
                preg_match('/Location:(.*?)\n/', $header, $matches);
                $url = @parse_url(trim(array_pop($matches)));
            } $rURL = '';
            if ( ! $url ) {
                $curl_loops = 0;
                curl_close($ch);
                return ($ctOnly === true) ? $content : $fullresponse;
            }
            $last_urlX = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            $last_url = @parse_url($last_urlX);
            if ( ! $url['scheme'] )
                $url['scheme'] = $last_url['scheme'];
            if ( ! $url['host'] )
                $url['host'] = $last_url['host'];
            if ( ! $url['path'] )
                $url['path'] = $last_url['path'];
            if ( ! isset($url['query']) )
                $url['query'] = '';
            $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query'] ? '?' . $url['query'] : '');

            return wp_rem_get_lk_page($new_url, $last_urlX, $ctOnly, '', $advSettings, $ch);
        } else {
            $curl_loops = 0;
            curl_close($ch);
            return ($ctOnly === true) ? $content : $fullresponse;
        }
    }

}

if ( ! function_exists('wp_rem_get_yelp_access_token_callback') ) {

    function wp_rem_get_yelp_access_token_callback() {

        global $wp_rem_plugin_options;

        $yelp_client_id = isset($wp_rem_plugin_options['wp_rem_yelp_app_id']) ? $wp_rem_plugin_options['wp_rem_yelp_app_id'] : '';
        $yelp_secret_id = isset($wp_rem_plugin_options['wp_rem_yelp_secret']) ? $wp_rem_plugin_options['wp_rem_yelp_secret'] : '';
        $post_data = array(
            'client_id' => urlencode($yelp_client_id),
            'client_secret' => urlencode($yelp_secret_id),
        );

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($post_data),
            )
        );

        $context = stream_context_create($options);
        $yelp_data = file_get_contents('https://api.yelp.com/oauth2/token', false, $context);

        $yelp_data = json_decode($yelp_data, true);

        $token = isset($yelp_data['access_token']) ? $yelp_data['access_token'] : '';
        echo json_encode(array( 'token' => $token ));
        die;
    }

    add_action('wp_ajax_wp_rem_get_yelp_access_token', 'wp_rem_get_yelp_access_token_callback');
}

/**
 * @Adding Ads Unit
 *
 */
if ( ! function_exists('wp_rem_banner_ads_banner') ) {

    function wp_rem_banner_ads_banner() {

        global $wp_rem_html_fields, $wp_rem_form_fields, $wp_rem_static_text;
        $strings = new wp_rem_plugin_all_strings_1;
        $strings->wp_rem_plugin_strings();
        $wp_rem_rand_num = rand(123456, 987654);
        $wp_rem_html = '';
        if ( $_POST['banner_title_input'] ) {

            $title = isset($_POST['banner_title_input']) ? $_POST['banner_title_input'] : '';
        }

        $wp_rem_html .='<li class="wp-rem-list-item">
                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                ' . esc_html($title) . '
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">
                                                ' . esc_html($_POST['banner_style_input']) . '
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                                        <!--For Simple Input Element-->
                                        <div class="input-element">
                                            <div class="input-holder">';
        if ( $_POST['banner_type_input'] == 'image' ) {
            $img_url = wp_get_attachment_image_src($_POST['image_path']);
            $wp_rem_html .= '<img src="' . esc_url($img_url[0]) . '" alt="" width="100" />';
            $wp_rem_html .= '&nbsp;';
        } else {
            $wp_rem_html .= '<td>' . wp_rem_plugin_text_srt('wp_rem_banner_custom_code') . '</td>';
            $wp_rem_html .= '<td>&nbsp;</td>';
        }
        $wp_rem_html .='</div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
                <!--For Simple Input Element-->
                <div class="input-element">
                    <div class="input-holder">
                        0
                    </div>
                </div>
            </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <!--For Simple Input Element-->
                    <div class="input-element">
                        <div class="input-holder">
                            [wp_rem_ads id="' . absint($wp_rem_rand_num) . '"]
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0);" class="wp-rem-remove wp-rem-parent-li-remove"><i class="icon-close2"></i></a>
                <a href="javascript:void(0);" class="wp-rem-edit wp-rem-parent-li-edit"><i class="icon-edit2"></i></a>';


        $wp_rem_html .= '<div class="parent-li-edit-div banner-style" id="' . absint($wp_rem_rand_num) . '" style="display:none">';
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_banner_title_field'),
            'desc' => '',
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_banner_title_field_hint'),
            'field_params' => array(
                'std' => isset($_POST['banner_title_input']) ? $_POST['banner_title_input'] : '',
                'cust_id' => 'banner_title' . absint($wp_rem_rand_num),
                'cust_name' => 'wp_rem_banner_title[]',
                'classes' => '',
                'return' => true,
            ),
        );
        $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);


        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_banner_style'),
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_banner_style_hint'),
            'field_params' => array(
                'std' => isset($_POST['banner_style_input']) ? $_POST['banner_style_input'] : '',
                'cust_id' => 'banner_style' . absint($wp_rem_rand_num),
                'cust_name' => 'wp_rem_banner_style[]',
                'desc' => '',
                'classes' => 'input-small chosen-select',
                'options' =>
                array(
                    'top_banner' => wp_rem_plugin_text_srt('wp_rem_banner_type_top'),
                    'bottom_banner' => wp_rem_plugin_text_srt('wp_rem_banner_type_bottom'),
                    'sidebar_banner' => wp_rem_plugin_text_srt('wp_rem_banner_type_sidebar'),
                    'vertical_banner' => wp_rem_plugin_text_srt('wp_rem_banner_type_vertical'),
                    'property_detail_banner' => wp_rem_plugin_text_srt('wp_rem_banner_type_property_detail'),
                    'property_banner' => wp_rem_plugin_text_srt('wp_rem_banner_type_property'),
                    'property_banner_leftfilter' => wp_rem_plugin_text_srt('wp_rem_banner_type_property_leftfilter'),
                    'member_banner' => wp_rem_plugin_text_srt('wp_rem_banner_type_member'),
                ),
                'return' => true,
            ),
        );
        $wp_rem_html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_banner_type'),
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_banner_type_hint'),
            'field_params' => array(
                'std' => isset($_POST['banner_type_input']) ? $_POST['banner_type_input'] : '',
                'cust_id' => 'banner_type' . absint($wp_rem_rand_num),
                'cust_name' => 'wp_rem_banner_type[]',
                'desc' => '',
                'extra_atr' => 'onchange="javascript:wp_rem_banner_type_toggle(this.value , \'' . $wp_rem_rand_num . '\')"',
                'classes' => 'input-small chosen-select',
                'options' =>
                array(
                    'image' => wp_rem_plugin_text_srt('wp_rem_banner_image'),
                    'code' => wp_rem_plugin_text_srt('wp_rem_banner_code'),
                ),
                'return' => true,
            ),
        );
        $wp_rem_html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
        $display_ads = 'none';
        if ( $_POST['banner_type_input'] == 'image' ) {
            $display_ads = 'block';
        } else if ( $_POST['banner_type_input'] == 'code' ) {
            $display_ads = 'none';
        }
        $wp_rem_html .='<div class="form-elements" id="ads_image' . absint($wp_rem_rand_num) . '" style="display:' . esc_html($display_ads) . '">';
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_banner_image'),
            'id' => 'banner_image',
            'std' => isset($_POST['image_path']) ? $_POST['image_path'] : '',
            'desc' => '',
            'form_element_wrapper' => false,
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_banner_image_hint'),
            'prefix' => '',
            'array' => true,
            'field_params' => array(
                'std' => isset($_POST['image_path']) ? $_POST['image_path'] : '',
                'id' => 'banner_image',
                'prefix' => '',
                'array' => true,
                'return' => true,
            ),
        );

        $wp_rem_html .= $wp_rem_html_fields->wp_rem_upload_file_field($wp_rem_opt_array);
        $wp_rem_html .='</div>';

        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_banner_url_field'),
            'desc' => '',
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_banner_url_hint'),
            'field_params' => array(
                'std' => isset($_POST['banner_field_url_input']) ? $_POST['banner_field_url_input'] : '',
                'cust_id' => 'banner_field_url' . absint($wp_rem_rand_num),
                'cust_name' => 'wp_rem_banner_field_url[]',
                'classes' => '',
                'return' => true,
            ),
        );
        $wp_rem_html .= $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);


        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_banner_target'),
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_banner_target_hint'),
            'field_params' => array(
                'std' => isset($_POST['banner_target_input']) ? $_POST['banner_target_input'] : '',
                'desc' => '',
                'cust_id' => 'banner_target' . absint($wp_rem_rand_num),
                'cust_name' => 'wp_rem_banner_target[]',
                'classes' => 'input-small chosen-select',
                'options' =>
                array(
                    '_self' => wp_rem_plugin_text_srt('wp_rem_banner_target_self'),
                    '_blank' => wp_rem_plugin_text_srt('wp_rem_banner_target_blank'),
                ),
                'return' => true,
            ),
        );
        $wp_rem_html .= $wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
        $display_ads = 'none';
        if ( $_POST['banner_type_input'] == 'image' ) {
            $display_ads = 'none';
        } else if ( $_POST['banner_type_input'] == 'code' ) {
            $display_ads = 'block';
        }
        $wp_rem_html .='<div id="ads_code' . absint($wp_rem_rand_num) . '" style="display:' . esc_html($display_ads) . '">';
        $wp_rem_opt_array = array(
            'name' => wp_rem_plugin_text_srt('wp_rem_banner_ad_sense_code'),
            'desc' => '',
            'hint_text' => wp_rem_plugin_text_srt('wp_rem_banner_ad_sense_code_hint'),
            'field_params' => array(
                'std' => isset($_POST['adsense_code_input']) ? $_POST['adsense_code_input'] : '',
                'cust_id' => 'adsense_code' . absint($wp_rem_rand_num),
                'cust_name' => 'wp_rem_banner_adsense_code[]',
                'classes' => '',
                'return' => true,
            ),
        );
        $wp_rem_html .= $wp_rem_html_fields->wp_rem_textarea_field($wp_rem_opt_array);
        $wp_rem_html .='</div>';

        $wp_rem_opt_array = array(
            'std' => absint($wp_rem_rand_num),
            'id' => 'banner_field_code_no' . absint($wp_rem_rand_num),
            'cust_name' => 'wp_rem_banner_field_code_no[]',
            'return' => true,
        );
        $wp_rem_html .= $wp_rem_form_fields->wp_rem_form_hidden_render($wp_rem_opt_array);

        $wp_rem_html .= '</div></li>';


        echo force_balance_tags($wp_rem_html);
        die;
    }

    add_action('wp_ajax_wp_rem_banner_ads_banner', 'wp_rem_banner_ads_banner');
}


/**
 * Start Function  how to get currency List
 */
if ( ! function_exists('wp_rem_get_currencies') ) {

    function wp_rem_get_currencies() {
        return array(
            'USD' => array( 'numeric_code' => 840, 'code' => 'USD', 'name' => 'United States dollar', 'symbol' => '$', 'fraction_name' => 'Cent[D]', 'decimals' => 2 ),
            'AED' => array( 'numeric_code' => 784, 'code' => 'AED', 'name' => 'United Arab Emirates dirham', 'symbol' => 'د.إ', 'fraction_name' => 'Fils', 'decimals' => 2 ),
            'AFN' => array( 'numeric_code' => 971, 'code' => 'AFN', 'name' => 'Afghan afghani', 'symbol' => '؋', 'fraction_name' => 'Pul', 'decimals' => 2 ),
            'ALL' => array( 'numeric_code' => 8, 'code' => 'ALL', 'name' => 'Albanian lek', 'symbol' => 'L', 'fraction_name' => 'Qintar', 'decimals' => 2 ),
            'AMD' => array( 'numeric_code' => 51, 'code' => 'AMD', 'name' => 'Armenian dram', 'symbol' => 'դր.', 'fraction_name' => 'Luma', 'decimals' => 2 ),
            'AMD' => array( 'numeric_code' => 51, 'code' => 'AMD', 'name' => 'Armenian dram', 'symbol' => 'դր.', 'fraction_name' => 'Luma', 'decimals' => 2 ),
            'ANG' => array( 'numeric_code' => 532, 'code' => 'ANG', 'name' => 'Netherlands Antillean guilder', 'symbol' => 'ƒ', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'AOA' => array( 'numeric_code' => 973, 'code' => 'AOA', 'name' => 'Angolan kwanza', 'symbol' => 'Kz', 'fraction_name' => 'Cêntimo', 'decimals' => 2 ),
            'ARS' => array( 'numeric_code' => 32, 'code' => 'ARS', 'name' => 'Argentine peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'AUD' => array( 'numeric_code' => 36, 'code' => 'AUD', 'name' => 'Australian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'AWG' => array( 'numeric_code' => 533, 'code' => 'AWG', 'name' => 'Aruban florin', 'symbol' => 'ƒ', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'AZN' => array( 'numeric_code' => 944, 'code' => 'AZN', 'name' => 'Azerbaijani manat', 'symbol' => 'AZN', 'fraction_name' => 'Qəpik', 'decimals' => 2 ),
            'BAM' => array( 'numeric_code' => 977, 'code' => 'BAM', 'name' => 'Bosnia and Herzegovina convertible mark', 'symbol' => 'КМ', 'fraction_name' => 'Fening', 'decimals' => 2 ),
            'BBD' => array( 'numeric_code' => 52, 'code' => 'BBD', 'name' => 'Barbadian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'BDT' => array( 'numeric_code' => 50, 'code' => 'BDT', 'name' => 'Bangladeshi taka', 'symbol' => '৳', 'fraction_name' => 'Paisa', 'decimals' => 2 ),
            'BGN' => array( 'numeric_code' => 975, 'code' => 'BGN', 'name' => 'Bulgarian lev', 'symbol' => 'лв', 'fraction_name' => 'Stotinka', 'decimals' => 2 ),
            'BHD' => array( 'numeric_code' => 48, 'code' => 'BHD', 'name' => 'Bahraini dinar', 'symbol' => 'ب.د', 'fraction_name' => 'Fils', 'decimals' => 3 ),
            'BIF' => array( 'numeric_code' => 108, 'code' => 'BIF', 'name' => 'Burundian franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'BMD' => array( 'numeric_code' => 60, 'code' => 'BMD', 'name' => 'Bermudian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'BND' => array( 'numeric_code' => 96, 'code' => 'BND', 'name' => 'Brunei dollar', 'symbol' => '$', 'fraction_name' => 'Sen', 'decimals' => 2 ),
            'BND' => array( 'numeric_code' => 96, 'code' => 'BND', 'name' => 'Brunei dollar', 'symbol' => '$', 'fraction_name' => 'Sen', 'decimals' => 2 ),
            'BOB' => array( 'numeric_code' => 68, 'code' => 'BOB', 'name' => 'Bolivian boliviano', 'symbol' => 'Bs.', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'BRL' => array( 'numeric_code' => 986, 'code' => 'BRL', 'name' => 'Brazilian real', 'symbol' => 'R$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'BSD' => array( 'numeric_code' => 44, 'code' => 'BSD', 'name' => 'Bahamian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'BTN' => array( 'numeric_code' => 64, 'code' => 'BTN', 'name' => 'Bhutanese ngultrum', 'symbol' => 'BTN', 'fraction_name' => 'Chertrum', 'decimals' => 2 ),
            'BWP' => array( 'numeric_code' => 72, 'code' => 'BWP', 'name' => 'Botswana pula', 'symbol' => 'P', 'fraction_name' => 'Thebe', 'decimals' => 2 ),
            'BWP' => array( 'numeric_code' => 72, 'code' => 'BWP', 'name' => 'Botswana pula', 'symbol' => 'P', 'fraction_name' => 'Thebe', 'decimals' => 2 ),
            'BYR' => array( 'numeric_code' => 974, 'code' => 'BYR', 'name' => 'Belarusian ruble', 'symbol' => 'Br', 'fraction_name' => 'Kapyeyka', 'decimals' => 2 ),
            'BZD' => array( 'numeric_code' => 84, 'code' => 'BZD', 'name' => 'Belize dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'CAD' => array( 'numeric_code' => 124, 'code' => 'CAD', 'name' => 'Canadian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'CDF' => array( 'numeric_code' => 976, 'code' => 'CDF', 'name' => 'Congolese franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'CHF' => array( 'numeric_code' => 756, 'code' => 'CHF', 'name' => 'Swiss franc', 'symbol' => 'Fr', 'fraction_name' => 'Rappen[I]', 'decimals' => 2 ),
            'CLP' => array( 'numeric_code' => 152, 'code' => 'CLP', 'name' => 'Chilean peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'CNY' => array( 'numeric_code' => 156, 'code' => 'CNY', 'name' => 'Chinese yuan', 'symbol' => '元', 'fraction_name' => 'Fen[E]', 'decimals' => 2 ),
            'COP' => array( 'numeric_code' => 170, 'code' => 'COP', 'name' => 'Colombian peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'CRC' => array( 'numeric_code' => 188, 'code' => 'CRC', 'name' => 'Costa Rican colón', 'symbol' => '₡', 'fraction_name' => 'Céntimo', 'decimals' => 2 ),
            'CUC' => array( 'numeric_code' => 931, 'code' => 'CUC', 'name' => 'Cuban convertible peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'CUP' => array( 'numeric_code' => 192, 'code' => 'CUP', 'name' => 'Cuban peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'CVE' => array( 'numeric_code' => 132, 'code' => 'CVE', 'name' => 'Cape Verdean escudo', 'symbol' => 'Esc', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'CZK' => array( 'numeric_code' => 203, 'code' => 'CZK', 'name' => 'Czech koruna', 'symbol' => 'K�?', 'fraction_name' => 'Haléř', 'decimals' => 2 ),
            'DJF' => array( 'numeric_code' => 262, 'code' => 'DJF', 'name' => 'Djiboutian franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'DKK' => array( 'numeric_code' => 208, 'code' => 'DKK', 'name' => 'Danish krone', 'symbol' => 'kr', 'fraction_name' => 'Øre', 'decimals' => 2 ),
            'DKK' => array( 'numeric_code' => 208, 'code' => 'DKK', 'name' => 'Danish krone', 'symbol' => 'kr', 'fraction_name' => 'Øre', 'decimals' => 2 ),
            'DOP' => array( 'numeric_code' => 214, 'code' => 'DOP', 'name' => 'Dominican peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'DZD' => array( 'numeric_code' => 12, 'code' => 'DZD', 'name' => 'Algerian dinar', 'symbol' => 'د.ج', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'EEK' => array( 'numeric_code' => 233, 'code' => 'EEK', 'name' => 'Estonian kroon', 'symbol' => 'KR', 'fraction_name' => 'Sent', 'decimals' => 2 ),
            'EGP' => array( 'numeric_code' => 818, 'code' => 'EGP', 'name' => 'Egyptian pound', 'symbol' => '£', 'fraction_name' => 'Piastre[F]', 'decimals' => 2 ),
            'ERN' => array( 'numeric_code' => 232, 'code' => 'ERN', 'name' => 'Eritrean nakfa', 'symbol' => 'Nfk', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'ETB' => array( 'numeric_code' => 230, 'code' => 'ETB', 'name' => 'Ethiopian birr', 'symbol' => 'ETB', 'fraction_name' => 'Santim', 'decimals' => 2 ),
            'EUR' => array( 'numeric_code' => 978, 'code' => 'EUR', 'name' => 'Euro', 'symbol' => '€', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'FJD' => array( 'numeric_code' => 242, 'code' => 'FJD', 'name' => 'Fijian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'FKP' => array( 'numeric_code' => 238, 'code' => 'FKP', 'name' => 'Falkland Islands pound', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2 ),
            'GBP' => array( 'numeric_code' => 826, 'code' => 'GBP', 'name' => 'British pound[C]', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2 ),
            'GEL' => array( 'numeric_code' => 981, 'code' => 'GEL', 'name' => 'Georgian lari', 'symbol' => 'ლ', 'fraction_name' => 'Tetri', 'decimals' => 2 ),
            'GHS' => array( 'numeric_code' => 936, 'code' => 'GHS', 'name' => 'Ghanaian cedi', 'symbol' => '₵', 'fraction_name' => 'Pesewa', 'decimals' => 2 ),
            'GIP' => array( 'numeric_code' => 292, 'code' => 'GIP', 'name' => 'Gibraltar pound', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2 ),
            'GMD' => array( 'numeric_code' => 270, 'code' => 'GMD', 'name' => 'Gambian dalasi', 'symbol' => 'D', 'fraction_name' => 'Butut', 'decimals' => 2 ),
            'GNF' => array( 'numeric_code' => 324, 'code' => 'GNF', 'name' => 'Guinean franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'GTQ' => array( 'numeric_code' => 320, 'code' => 'GTQ', 'name' => 'Guatemalan quetzal', 'symbol' => 'Q', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'GYD' => array( 'numeric_code' => 328, 'code' => 'GYD', 'name' => 'Guyanese dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'HKD' => array( 'numeric_code' => 344, 'code' => 'HKD', 'name' => 'Hong Kong dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'HNL' => array( 'numeric_code' => 340, 'code' => 'HNL', 'name' => 'Honduran lempira', 'symbol' => 'L', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'HRK' => array( 'numeric_code' => 191, 'code' => 'HRK', 'name' => 'Croatian kuna', 'symbol' => 'kn', 'fraction_name' => 'Lipa', 'decimals' => 2 ),
            'HTG' => array( 'numeric_code' => 332, 'code' => 'HTG', 'name' => 'Haitian gourde', 'symbol' => 'G', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'HUF' => array( 'numeric_code' => 348, 'code' => 'HUF', 'name' => 'Hungarian forint', 'symbol' => 'Ft', 'fraction_name' => 'Fillér', 'decimals' => 2 ),
            'IDR' => array( 'numeric_code' => 360, 'code' => 'IDR', 'name' => 'Indonesian rupiah', 'symbol' => 'Rp', 'fraction_name' => 'Sen', 'decimals' => 2 ),
            'ILS' => array( 'numeric_code' => 376, 'code' => 'ILS', 'name' => 'Israeli new sheqel', 'symbol' => '₪', 'fraction_name' => 'Agora', 'decimals' => 2 ),
            'INR' => array( 'numeric_code' => 356, 'code' => 'INR', 'name' => 'Indian rupee', 'symbol' => '₨', 'fraction_name' => 'Paisa', 'decimals' => 2 ),
            'IQD' => array( 'numeric_code' => 368, 'code' => 'IQD', 'name' => 'Iraqi dinar', 'symbol' => 'ع.د', 'fraction_name' => 'Fils', 'decimals' => 3 ),
            'IRR' => array( 'numeric_code' => 364, 'code' => 'IRR', 'name' => 'Iranian rial', 'symbol' => '﷼', 'fraction_name' => 'Dinar', 'decimals' => 2 ),
            'ISK' => array( 'numeric_code' => 352, 'code' => 'ISK', 'name' => 'Icelandic króna', 'symbol' => 'kr', 'fraction_name' => 'Eyrir', 'decimals' => 2 ),
            'JMD' => array( 'numeric_code' => 388, 'code' => 'JMD', 'name' => 'Jamaican dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'JOD' => array( 'numeric_code' => 400, 'code' => 'JOD', 'name' => 'Jordanian dinar', 'symbol' => 'د.ا', 'fraction_name' => 'Piastre[H]', 'decimals' => 2 ),
            'JPY' => array( 'numeric_code' => 392, 'code' => 'JPY', 'name' => 'Japanese yen', 'symbol' => '¥', 'fraction_name' => 'Sen[G]', 'decimals' => 2 ),
            'KES' => array( 'numeric_code' => 404, 'code' => 'KES', 'name' => 'Kenyan shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'KGS' => array( 'numeric_code' => 417, 'code' => 'KGS', 'name' => 'Kyrgyzstani som', 'symbol' => 'KGS', 'fraction_name' => 'Tyiyn', 'decimals' => 2 ),
            'KHR' => array( 'numeric_code' => 116, 'code' => 'KHR', 'name' => 'Cambodian riel', 'symbol' => '៛', 'fraction_name' => 'Sen', 'decimals' => 2 ),
            'KMF' => array( 'numeric_code' => 174, 'code' => 'KMF', 'name' => 'Comorian franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'KPW' => array( 'numeric_code' => 408, 'code' => 'KPW', 'name' => 'North Korean won', 'symbol' => '₩', 'fraction_name' => 'Ch�?n', 'decimals' => 2 ),
            'KRW' => array( 'numeric_code' => 410, 'code' => 'KRW', 'name' => 'South Korean won', 'symbol' => '₩', 'fraction_name' => 'Jeon', 'decimals' => 2 ),
            'KWD' => array( 'numeric_code' => 414, 'code' => 'KWD', 'name' => 'Kuwaiti dinar', 'symbol' => 'د.ك', 'fraction_name' => 'Fils', 'decimals' => 3 ),
            'KYD' => array( 'numeric_code' => 136, 'code' => 'KYD', 'name' => 'Cayman Islands dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'KZT' => array( 'numeric_code' => 398, 'code' => 'KZT', 'name' => 'Kazakhstani tenge', 'symbol' => '〒', 'fraction_name' => 'Tiyn', 'decimals' => 2 ),
            'LAK' => array( 'numeric_code' => 418, 'code' => 'LAK', 'name' => 'Lao kip', 'symbol' => '₭', 'fraction_name' => 'Att', 'decimals' => 2 ),
            'LBP' => array( 'numeric_code' => 422, 'code' => 'LBP', 'name' => 'Lebanese pound', 'symbol' => 'ل.ل', 'fraction_name' => 'Piastre', 'decimals' => 2 ),
            'LKR' => array( 'numeric_code' => 144, 'code' => 'LKR', 'name' => 'Sri Lankan rupee', 'symbol' => 'Rs', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'LRD' => array( 'numeric_code' => 430, 'code' => 'LRD', 'name' => 'Liberian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'LSL' => array( 'numeric_code' => 426, 'code' => 'LSL', 'name' => 'Lesotho loti', 'symbol' => 'L', 'fraction_name' => 'Sente', 'decimals' => 2 ),
            'LTL' => array( 'numeric_code' => 440, 'code' => 'LTL', 'name' => 'Lithuanian litas', 'symbol' => 'Lt', 'fraction_name' => 'Centas', 'decimals' => 2 ),
            'LVL' => array( 'numeric_code' => 428, 'code' => 'LVL', 'name' => 'Latvian lats', 'symbol' => 'Ls', 'fraction_name' => 'Santīms', 'decimals' => 2 ),
            'LYD' => array( 'numeric_code' => 434, 'code' => 'LYD', 'name' => 'Libyan dinar', 'symbol' => 'ل.د', 'fraction_name' => 'Dirham', 'decimals' => 3 ),
            'MAD' => array( 'numeric_code' => 504, 'code' => 'MAD', 'name' => 'Moroccan dirham', 'symbol' => 'Dh', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'MDL' => array( 'numeric_code' => 498, 'code' => 'MDL', 'name' => 'Moldovan leu', 'symbol' => 'L', 'fraction_name' => 'Ban', 'decimals' => 2 ),
            'MGA' => array( 'numeric_code' => 969, 'code' => 'MGA', 'name' => 'Malagasy ariary', 'symbol' => 'MGA', 'fraction_name' => 'Iraimbilanja', 'decimals' => 5 ),
            'MKD' => array( 'numeric_code' => 807, 'code' => 'MKD', 'name' => 'Macedonian denar', 'symbol' => 'ден', 'fraction_name' => 'Deni', 'decimals' => 2 ),
            'MMK' => array( 'numeric_code' => 104, 'code' => 'MMK', 'name' => 'Myanma kyat', 'symbol' => 'K', 'fraction_name' => 'Pya', 'decimals' => 2 ),
            'MNT' => array( 'numeric_code' => 496, 'code' => 'MNT', 'name' => 'Mongolian tögrög', 'symbol' => '₮', 'fraction_name' => 'Möngö', 'decimals' => 2 ),
            'MOP' => array( 'numeric_code' => 446, 'code' => 'MOP', 'name' => 'Macanese pataca', 'symbol' => 'P', 'fraction_name' => 'Avo', 'decimals' => 2 ),
            'MRO' => array( 'numeric_code' => 478, 'code' => 'MRO', 'name' => 'Mauritanian ouguiya', 'symbol' => 'UM', 'fraction_name' => 'Khoums', 'decimals' => 5 ),
            'MUR' => array( 'numeric_code' => 480, 'code' => 'MUR', 'name' => 'Mauritian rupee', 'symbol' => '₨', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'MVR' => array( 'numeric_code' => 462, 'code' => 'MVR', 'name' => 'Maldivian rufiyaa', 'symbol' => 'ރ.', 'fraction_name' => 'Laari', 'decimals' => 2 ),
            'MWK' => array( 'numeric_code' => 454, 'code' => 'MWK', 'name' => 'Malawian kwacha', 'symbol' => 'MK', 'fraction_name' => 'Tambala', 'decimals' => 2 ),
            'MXN' => array( 'numeric_code' => 484, 'code' => 'MXN', 'name' => 'Mexican peso', 'symbol' => '$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'MYR' => array( 'numeric_code' => 458, 'code' => 'MYR', 'name' => 'Malaysian ringgit', 'symbol' => 'RM', 'fraction_name' => 'Sen', 'decimals' => 2 ),
            'MZN' => array( 'numeric_code' => 943, 'code' => 'MZN', 'name' => 'Mozambican metical', 'symbol' => 'MTn', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'NAD' => array( 'numeric_code' => 516, 'code' => 'NAD', 'name' => 'Namibian dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'NGN' => array( 'numeric_code' => 566, 'code' => 'NGN', 'name' => 'Nigerian naira', 'symbol' => '₦', 'fraction_name' => 'Kobo', 'decimals' => 2 ),
            'NIO' => array( 'numeric_code' => 558, 'code' => 'NIO', 'name' => 'Nicaraguan córdoba', 'symbol' => 'C$', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'NOK' => array( 'numeric_code' => 578, 'code' => 'NOK', 'name' => 'Norwegian krone', 'symbol' => 'kr', 'fraction_name' => 'Øre', 'decimals' => 2 ),
            'NPR' => array( 'numeric_code' => 524, 'code' => 'NPR', 'name' => 'Nepalese rupee', 'symbol' => '₨', 'fraction_name' => 'Paisa', 'decimals' => 2 ),
            'NZD' => array( 'numeric_code' => 554, 'code' => 'NZD', 'name' => 'New Zealand dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'OMR' => array( 'numeric_code' => 512, 'code' => 'OMR', 'name' => 'Omani rial', 'symbol' => 'ر.ع.', 'fraction_name' => 'Baisa', 'decimals' => 3 ),
            'PAB' => array( 'numeric_code' => 590, 'code' => 'PAB', 'name' => 'Panamanian balboa', 'symbol' => 'B/.', 'fraction_name' => 'Centésimo', 'decimals' => 2 ),
            'PEN' => array( 'numeric_code' => 604, 'code' => 'PEN', 'name' => 'Peruvian nuevo sol', 'symbol' => 'S/.', 'fraction_name' => 'Céntimo', 'decimals' => 2 ),
            'PGK' => array( 'numeric_code' => 598, 'code' => 'PGK', 'name' => 'Papua New Guinean kina', 'symbol' => 'K', 'fraction_name' => 'Toea', 'decimals' => 2 ),
            'PHP' => array( 'numeric_code' => 608, 'code' => 'PHP', 'name' => 'Philippine peso', 'symbol' => '₱', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'PKR' => array( 'numeric_code' => 586, 'code' => 'PKR', 'name' => 'Pakistani rupee', 'symbol' => '₨', 'fraction_name' => 'Paisa', 'decimals' => 2 ),
            'PLN' => array( 'numeric_code' => 985, 'code' => 'PLN', 'name' => 'Polish złoty', 'symbol' => 'zł', 'fraction_name' => 'Grosz', 'decimals' => 2 ),
            'PYG' => array( 'numeric_code' => 600, 'code' => 'PYG', 'name' => 'Paraguayan guaraní', 'symbol' => '₲', 'fraction_name' => 'Céntimo', 'decimals' => 2 ),
            'QAR' => array( 'numeric_code' => 634, 'code' => 'QAR', 'name' => 'Qatari riyal', 'symbol' => 'ر.ق', 'fraction_name' => 'Dirham', 'decimals' => 2 ),
            'RON' => array( 'numeric_code' => 946, 'code' => 'RON', 'name' => 'Romanian leu', 'symbol' => 'L', 'fraction_name' => 'Ban', 'decimals' => 2 ),
            'RSD' => array( 'numeric_code' => 941, 'code' => 'RSD', 'name' => 'Serbian dinar', 'symbol' => 'дин.', 'fraction_name' => 'Para', 'decimals' => 2 ),
            'RUB' => array( 'numeric_code' => 643, 'code' => 'RUB', 'name' => 'Russian ruble', 'symbol' => 'руб.', 'fraction_name' => 'Kopek', 'decimals' => 2 ),
            'RWF' => array( 'numeric_code' => 646, 'code' => 'RWF', 'name' => 'Rwandan franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'SAR' => array( 'numeric_code' => 682, 'code' => 'SAR', 'name' => 'Saudi riyal', 'symbol' => 'ر.س', 'fraction_name' => 'Hallallah', 'decimals' => 2 ),
            'SBD' => array( 'numeric_code' => 90, 'code' => 'SBD', 'name' => 'Solomon Islands dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'SCR' => array( 'numeric_code' => 690, 'code' => 'SCR', 'name' => 'Seychellois rupee', 'symbol' => '₨', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'SDG' => array( 'numeric_code' => 938, 'code' => 'SDG', 'name' => 'Sudanese pound', 'symbol' => '£', 'fraction_name' => 'Piastre', 'decimals' => 2 ),
            'SEK' => array( 'numeric_code' => 752, 'code' => 'SEK', 'name' => 'Swedish krona', 'symbol' => 'kr', 'fraction_name' => 'Öre', 'decimals' => 2 ),
            'SGD' => array( 'numeric_code' => 702, 'code' => 'SGD', 'name' => 'Singapore dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'SHP' => array( 'numeric_code' => 654, 'code' => 'SHP', 'name' => 'Saint Helena pound', 'symbol' => '£', 'fraction_name' => 'Penny', 'decimals' => 2 ),
            'SLL' => array( 'numeric_code' => 694, 'code' => 'SLL', 'name' => 'Sierra Leonean leone', 'symbol' => 'Le', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'SOS' => array( 'numeric_code' => 706, 'code' => 'SOS', 'name' => 'Somali shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'SRD' => array( 'numeric_code' => 968, 'code' => 'SRD', 'name' => 'Surinamese dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'STD' => array( 'numeric_code' => 678, 'code' => 'STD', 'name' => 'São Tomé and Príncipe dobra', 'symbol' => 'Db', 'fraction_name' => 'Cêntimo', 'decimals' => 2 ),
            'SVC' => array( 'numeric_code' => 222, 'code' => 'SVC', 'name' => 'Salvadoran colón', 'symbol' => '₡', 'fraction_name' => 'Centavo', 'decimals' => 2 ),
            'SYP' => array( 'numeric_code' => 760, 'code' => 'SYP', 'name' => 'Syrian pound', 'symbol' => '£', 'fraction_name' => 'Piastre', 'decimals' => 2 ),
            'SZL' => array( 'numeric_code' => 748, 'code' => 'SZL', 'name' => 'Swazi lilangeni', 'symbol' => 'L', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'THB' => array( 'numeric_code' => 764, 'code' => 'THB', 'name' => 'Thai baht', 'symbol' => '฿', 'fraction_name' => 'Satang', 'decimals' => 2 ),
            'TJS' => array( 'numeric_code' => 972, 'code' => 'TJS', 'name' => 'Tajikistani somoni', 'symbol' => 'ЅМ', 'fraction_name' => 'Diram', 'decimals' => 2 ),
            'TMM' => array( 'numeric_code' => 0, 'code' => 'TMM', 'name' => 'Turkmenistani manat', 'symbol' => 'm', 'fraction_name' => 'Tennesi', 'decimals' => 2 ),
            'TND' => array( 'numeric_code' => 788, 'code' => 'TND', 'name' => 'Tunisian dinar', 'symbol' => 'د.ت', 'fraction_name' => 'Millime', 'decimals' => 3 ),
            'TOP' => array( 'numeric_code' => 776, 'code' => 'TOP', 'name' => 'Tongan paʻanga', 'symbol' => 'T$', 'fraction_name' => 'Seniti[J]', 'decimals' => 2 ),
            'TRY' => array( 'numeric_code' => 949, 'code' => 'TRY', 'name' => 'Turkish lira', 'symbol' => 'TL', 'fraction_name' => 'Kuruş', 'decimals' => 2 ),
            'TTD' => array( 'numeric_code' => 780, 'code' => 'TTD', 'name' => 'Trinidad and Tobago dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'TWD' => array( 'numeric_code' => 901, 'code' => 'TWD', 'name' => 'New Taiwan dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'TZS' => array( 'numeric_code' => 834, 'code' => 'TZS', 'name' => 'Tanzanian shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'UAH' => array( 'numeric_code' => 980, 'code' => 'UAH', 'name' => 'Ukrainian hryvnia', 'symbol' => '₴', 'fraction_name' => 'Kopiyka', 'decimals' => 2 ),
            'UGX' => array( 'numeric_code' => 800, 'code' => 'UGX', 'name' => 'Ugandan shilling', 'symbol' => 'Sh', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'UYU' => array( 'numeric_code' => 858, 'code' => 'UYU', 'name' => 'Uruguayan peso', 'symbol' => '$', 'fraction_name' => 'Centésimo', 'decimals' => 2 ),
            'UZS' => array( 'numeric_code' => 860, 'code' => 'UZS', 'name' => 'Uzbekistani som', 'symbol' => 'UZS', 'fraction_name' => 'Tiyin', 'decimals' => 2 ),
            'VEF' => array( 'numeric_code' => 937, 'code' => 'VEF', 'name' => 'Venezuelan bolívar', 'symbol' => 'Bs F', 'fraction_name' => 'Céntimo', 'decimals' => 2 ),
            'VND' => array( 'numeric_code' => 704, 'code' => 'VND', 'name' => 'Vietnamese đồng', 'symbol' => '₫', 'fraction_name' => 'Hào[K]', 'decimals' => 10 ),
            'VUV' => array( 'numeric_code' => 548, 'code' => 'VUV', 'name' => 'Vanuatu vatu', 'symbol' => 'Vt', 'fraction_name' => 'None', 'decimals' => NULL ),
            'WST' => array( 'numeric_code' => 882, 'code' => 'WST', 'name' => 'Samoan tala', 'symbol' => 'T', 'fraction_name' => 'Sene', 'decimals' => 2 ),
            'XAF' => array( 'numeric_code' => 950, 'code' => 'XAF', 'name' => 'Central African CFA franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'XCD' => array( 'numeric_code' => 951, 'code' => 'XCD', 'name' => 'East Caribbean dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'XOF' => array( 'numeric_code' => 952, 'code' => 'XOF', 'name' => 'West African CFA franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'XPF' => array( 'numeric_code' => 953, 'code' => 'XPF', 'name' => 'CFP franc', 'symbol' => 'Fr', 'fraction_name' => 'Centime', 'decimals' => 2 ),
            'YER' => array( 'numeric_code' => 886, 'code' => 'YER', 'name' => 'Yemeni rial', 'symbol' => '﷼', 'fraction_name' => 'Fils', 'decimals' => 2 ),
            'ZAR' => array( 'numeric_code' => 710, 'code' => 'ZAR', 'name' => 'South African rand', 'symbol' => 'R', 'fraction_name' => 'Cent', 'decimals' => 2 ),
            'ZMK' => array( 'numeric_code' => 894, 'code' => 'ZMK', 'name' => 'Zambian kwacha', 'symbol' => 'ZK', 'fraction_name' => 'Ngwee', 'decimals' => 2 ),
            'ZWR' => array( 'numeric_code' => 0, 'code' => 'ZWR', 'name' => 'Zimbabwean dollar', 'symbol' => '$', 'fraction_name' => 'Cent', 'decimals' => 2 ),
        );
    }

}

/**
 * End Function  how to get currency Symbols
 */
if ( ! function_exists('update_fixed_price_opt') ) {

    function update_fixed_price_opt($post) {
        $fixed_price_opt = isset($post['fixed_price_opt']) ? $post['fixed_price_opt'] : '';
        if ( $fixed_price_opt != '' ) {
            unset($post['fixed_price_opt']);
            foreach ( $fixed_price_opt as $key => $label ) {
                $post['fixed_price_opt'][sanitize_title($label)] = $label;
            }
        }
        return $post;
    }

}


if ( ! function_exists('wp_rem_load_all_pages_callback') ) {
	add_action('wp_ajax_wp_rem_load_all_pages', 'wp_rem_load_all_pages_callback');
    function wp_rem_load_all_pages_callback() {
		$args = isset($_POST['args']) ? $_POST['args'] : '';
		$new_args = json_decode(stripslashes($args), true);
		$wp_rem_output = wp_dropdown_pages($new_args);
		$wp_rem_output .= '<script type="text/javascript">
			jQuery(document).ready(function () {
				chosen_selectionbox();
			});
		</script>';
		echo json_encode(array('html' => $wp_rem_output));
		die;
    }
}

if ( ! function_exists('wp_rem_load_all_agencies_options_callback') ) {
	add_action('wp_ajax_wp_rem_load_all_agencies_options', 'wp_rem_load_all_agencies_options_callback');
    function wp_rem_load_all_agencies_options_callback() {
		global $wp_rem_plugin_options, $wp_rem_form_fields;
		
		$selected_val = wp_rem_get_input('selected_val', '', 'STRING');
		
		$wp_rem_agency_list = array('' => wp_rem_plugin_text_srt('wp_rem_plugin_options_slct_agency'));
        $args = array(
            'orderby' => 'nicename',
            'role' => 'wp_rem_member',
            'meta_query' =>
            array(
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'wp_rem_user_type',
                        'value' => 'supper-admin',
                        'compare' => '=',
                    ),
                )
            )
        );

        $wp_rem_users = get_users($args);
        foreach ($wp_rem_users as $user) {
            $wp_rem_company_id = get_user_meta($user->ID, 'wp_rem_company', true);
            $profile_type = get_post_meta($wp_rem_company_id, 'wp_rem_member_profile_type', true);
            if ($profile_type != '' && $profile_type == 'company') {
                $wp_rem_agency_list[$user->ID] = $user->display_name;
            }
        }
		
		$wp_rem_opt_array = array(
			'std' => $selected_val,
			'id' => 'demo_user_agency',
			'options' => $wp_rem_agency_list,
			'classes' => 'chosen-select',
			'return' => true,
			
		);
		$wp_rem_output = $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
		
		$wp_rem_output .= '<script type="text/javascript">
			jQuery(document).ready(function () {
				chosen_selectionbox();
			});
		</script>';
		echo json_encode(array('html' => $wp_rem_output));
		die;
    }
}

if ( ! function_exists('wp_rem_load_all_members_options_callback') ) {
	add_action('wp_ajax_wp_rem_load_all_members_options', 'wp_rem_load_all_members_options_callback');
    function wp_rem_load_all_members_options_callback() {
		global $wp_rem_plugin_options, $wp_rem_form_fields;
		
		$selected_val = wp_rem_get_input('selected_val', '', 'STRING');
		
		$wp_rem_member_list = array('' => wp_rem_plugin_text_srt('wp_rem_plugin_options_slct_member'));
        $args = array(
            'orderby' => 'nicename',
            'role' => 'wp_rem_member',
            'meta_query' =>
            array(
                array(
                    'relation' => 'AND',
                    array(
                        'key' => 'wp_rem_user_type',
                        'value' => 'supper-admin',
                        'compare' => '=',
                    ),
                )
            )
        );

        $wp_rem_users = get_users($args);
        foreach ($wp_rem_users as $user) {
            $wp_rem_company_id = get_user_meta($user->ID, 'wp_rem_company', true);
            $profile_type = get_post_meta($wp_rem_company_id, 'wp_rem_member_profile_type', true);
            if ($profile_type != '' && $profile_type == 'company') {
                $wp_rem_agency_list[$user->ID] = $user->display_name;
            } else {
                $wp_rem_member_list[$user->ID] = $user->display_name;
            }
        }
		
		$wp_rem_opt_array = array(
			'std' => $selected_val,
			'id' => 'demo_user_member',
			'options' => $wp_rem_member_list,
			'classes' => 'chosen-select',
			'return' => true,
			
		);
		$wp_rem_output = $wp_rem_form_fields->wp_rem_form_select_render($wp_rem_opt_array);
		
		$wp_rem_output .= '<script type="text/javascript">
			jQuery(document).ready(function () {
				chosen_selectionbox();
			});
		</script>';
		echo json_encode(array('html' => $wp_rem_output));
		die;
    }
}