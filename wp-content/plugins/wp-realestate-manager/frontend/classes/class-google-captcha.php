<?php

/**
 * File Type: Google Captcha
 */
if (!class_exists('Wp_rem_Captcha')) {

    Class Wp_rem_Captcha {

        public function __construct() {
            add_action('wp_rem_generate_captcha_form', array($this, 'wp_rem_generate_captcha_form_callback'), 10, 2);
            add_action('wp_ajax_wp_rem_reload_captcha_form', array($this, 'wp_rem_reload_captcha_form_callback'), 10, 1);
            add_action('wp_ajax_nopriv_wp_rem_reload_captcha_form', array($this, 'wp_rem_reload_captcha_form_callback'), 10, 1);
            add_action('wp_rem_verify_captcha_form', array($this, 'wp_rem_verify_captcha_form_callback'), 10, 1);
        }

        public function wp_rem_generate_captcha_form_callback($captcha_id = '',$return_output='false') {
            global $wp_rem_plugin_options;

            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
            $output = '';
            if ($wp_rem_captcha_switch == 'on') {
                if ($wp_rem_sitekey <> '' && $wp_rem_secretkey <> '') {

                    $output .= '<div class="g-recaptcha" data-theme="light" id="' . $captcha_id . '" data-sitekey="' . $wp_rem_sitekey . '" style="">'
                            . '</div> <a class="recaptcha-reload-a" href="javascript:void(0);" onclick="captcha_reload(\'' . admin_url('admin-ajax.php') . '\', \'' . $captcha_id . '\');">'
                            . '<i class="icon-refresh2"></i> ' . wp_rem_plugin_text_srt('wp_rem_google_captcha_reload') . '</a>';
                } else {
                    $output .= '<p>' . wp_rem_plugin_text_srt('wp_rem_google_captcha_provide_captcha_api_key') . '</p>';
                }
            }
            if($return_output=='true'){
            return $output;
            }
            else{
                  echo force_balance_tags($output);
            }
        }

        public function wp_rem_reload_captcha_form_callback() {
            global $wp_rem_plugin_options;
            $captcha_id = $_REQUEST['captcha_id'];
	    
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
           
	    $return_str = "<script>
        var " . $captcha_id . ";
            " . $captcha_id . " = grecaptcha.render('" . $captcha_id . "', {
                'sitekey': '" . $wp_rem_sitekey . "', //Replace this with your Site key
                'theme': 'light'
            });"
                    . "</script>";
            $return_str .= wp_rem_captcha($captcha_id);
            echo force_balance_tags($return_str);
            wp_die();
        }

        public function wp_rem_verify_captcha_form_callback($page) {
            global $wp_rem_plugin_options;
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
            $wp_rem_captcha = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';

            if ($wp_rem_captcha_switch == 'on') {
                if ($page == true) {
                    if (empty($wp_rem_captcha)) {
                        return true;
                    }
                } else {

                    if (empty($wp_rem_captcha)) {
                        $response_array = array(
                            'type' => 'error',
                            'msg' => '<p>'. wp_rem_plugin_text_srt('wp_rem_google_captcha_select_field') .'</p>'
                        );
                        echo json_encode($response_array);
                        exit();
                    }
                }
            }
        }

    }

    global $Wp_rem_Captcha;
    $Wp_rem_Captcha = new Wp_rem_Captcha();
}