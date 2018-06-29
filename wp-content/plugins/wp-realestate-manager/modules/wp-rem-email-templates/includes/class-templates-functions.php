<?php
/**
 * Main plugin Templates Functions File.
 *
 * @since 1.0
 * @package	Homevillas
 */
// Direct access not allowed.
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Templates Functions Class.
 */
class Wp_rem_Email_Templates_Functions {

    /**
     * Put hooks in place and activate.
     */
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'plugin_enqueue'));
        add_action('wp_rem_email_template', array($this, 'jh_email_notification'), 10, 1);
        add_action('send_email_with_template', array($this, 'send_email_with_template_callback'), 20, 2);
    }

    /*
     * @ Enqueue Plugin Styles and Scripts
     */

    public function plugin_enqueue() {

        wp_enqueue_style('wp-rem-email-templates', WP_REM_EMAIL_TEMPLATES_PLUGIN_URL . '/assets/css/wp-rem-email-templates.css');
        wp_enqueue_script('wp-rem-email-templates', WP_REM_EMAIL_TEMPLATES_PLUGIN_URL . '/assets/js/wp-rem-email-templates.js', array('jquery'));
    }

    /*
     * @ Email Header
     */

    private function email_header($from = '', $to = '') {

        if ($from == '') {
            $from = get_bloginfo('name');
        }
        if ($to == '') {
            $to = get_bloginfo('admin_email');
        }

        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: " . $to . "\r\n";
        $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\r\n";
        return $headers;
    }

    /*
     * @ Email Add New Template
     */

    public function jh_email_notification($atts = array()) {
        global $current_user;

        $defaults = array(
            'template_id' => '',
            'email_from' => '',
            'email_reply_to' => '',
            'bcc_switch' => '',
            'job_id' => '',
            'user_id' => '',
            'candidate_id' => '',
            'from_message' => '',
            'phone_number' => '',
            'user_password' => '',
        );
        extract(shortcode_atts($defaults, $atts));

        $content_template = get_post($template_id);
        $content_template = $content_template->post_content;
        $content_template = apply_filters('the_content', $content_template);
        $content_template = str_replace(']]>', ']]&gt;', $content_template);

        $user_display_name = $current_user->display_name;
        $user_email = $current_user->user_email;

        if (!empty($job_id)) {

            $jh_user = get_post_meta($job_id, 'wp_rem_job_username', true);

            $jh_user = get_user_by('ID', $jh_user);

            if (empty($jh_user)) {
                $jh_user = $current_user;
            }
            $user_display_name = $jh_user->display_name;
            $user_email = $jh_user->user_email;
        }

        if (!empty($user_id)) {
            $jh_user = get_user_by('ID', $user_id);

            $user_display_name = $jh_user->display_name;
            $user_email = $jh_user->user_email;
        }

        $candidate_display_name = '';
        if (!empty($candidate_id)) {
            $jh_user = get_user_by('ID', $candidate_id);

            $candidate_display_name = $jh_user->display_name;
        }

        $get_strings = array(
            '[JOB_USER_NAME]',
            '[JOB_SITE_NAME]',
            '[JOB_ADMIN_EMAIL]',
            '[JOB_SITE_URL]',
            '[JOB_TITLE]',
            '[JOB_USER_PASSWORD]',
            '[JOB_CANDIDATE]',
            '[JOB_FROM_NAME]',
            '[JOB_REPLY_TO]',
            '[JOB_PHONE_NUMBER]',
            '[JOB_FROM_MESSAGE]',
        );

        $replace_strings = array(
            $user_display_name,
            get_bloginfo('name'),
            get_bloginfo('admin_email'),
            '<a href="' . esc_url(home_url('/')) . '">' . esc_url(home_url('/')) . '</a>',
            '<a href="' . esc_url(get_permalink($job_id)) . '">' . get_the_title($job_id) . '</a>',
            $user_password,
            $candidate_display_name,
            $email_from,
            $email_reply_to,
            $phone_number,
            $from_message,
        );

        $cc_email = get_post_meta($template_id, 'jh_template_cc', true);
        if ($cc_email != '' && $bcc_switch == 'on') {
            $email_to = array(sanitize_email($user_email), sanitize_email($cc_email));
        } else {
            $email_to = sanitize_email($user_email);
        }

        $subject = get_post_meta($template_id, 'jh_template_subject', true);
        $subject = str_replace($get_strings, $replace_strings, $subject);

        $email_body = str_replace($get_strings, $replace_strings, $content_template);
        $headers = Wp_rem_Email_Templates_Functions::email_header($email_from, $email_reply_to);

        wp_mail($email_to, $subject, $email_body, $headers);
    }

    public static function send_email_with_template_callback($email_template_index, $template_type) {
        $wp_rem_plugin_options = get_option('wp_rem_plugin_options');

        $email_template = '';
        $email_template_variables = array();
        if (isset($wp_rem_plugin_options[$email_template_index])) {
            $selected_template_id = intval($wp_rem_plugin_options[$email_template_index]);

            // Check if a temlate selected else default template is used.
            if ($selected_template_id != 0) {
                $templateObj = get_post($selected_template_id);
                if ($templateObj != null) {
                    $email_template = $templateObj->post_content;
                }
            } else {
                if (isset(Wp_rem_Email_Templates_Post::$email_template_options)) {
                    if (isset(Wp_rem_Email_Templates_Post::$email_template_options['templates'][$template_type])) {
                        // Get default template.
                        $email_template = Wp_rem_Email_Templates_Post::$email_template_options['templates'][$template_type];
                    }
                }
            }
            // Get Email template types in Wp_rem_Email_Templates_Post class.
            if (isset(Wp_rem_Email_Templates_Post::$email_template_options)) {
                $email_template_variables = array_merge(
                        Wp_rem_Email_Templates_Post::$email_template_options['variables']['General'], Wp_rem_Email_Templates_Post::$email_template_options['variables'][$template_type]
                );
            }
        }

        $template = $this->replace_tags($email_template, $email_template_variables);
        //var_dump($template);

        if ($email_template == null) {
            $email_template = wp_rem_plugin_text_srt('wp_rem_template_fun');
        }
    }

    public static function replace_tags($template, $variables) {
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

}

$wp_rem_email_functions = new Wp_rem_Email_Templates_Functions();