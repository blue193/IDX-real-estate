<?php
/**
 * Homevillas Notifications Module
 */
// Direct access not allowed.
if ( ! defined('ABSPATH') ) {
    exit;
}

/**
 * Wp_rem_Property_Alerts class.
 */
class Wp_rem_Property_Alerts {

    public static $property_details = array();
    public $email_template_type;
    public $email_default_template;
    public $email_template_variables;
    public $admin_notices;
    public $email_template_index;
    public $template_group;

    /**
     * Defined constants, include classes, enqueue scripts, bind hooks to parent plugin
     */
    public function __construct() {
        // Define constants
        define('WP_REM_NOTIFICATIONS_FILE', __FILE__);
        define('WP_REM_NOTIFICATIONS_CORE_DIR', WP_PLUGIN_DIR . '/wp-realestate-manager/modules/wp-rem-notifications');
        define('WP_REM_NOTIFICATIONS_INCLUDES_DIR', WP_REM_NOTIFICATIONS_CORE_DIR . '/includes');
        define('WP_REM_NOTIFICATIONS_TEMPLATES_DIR', WP_REM_NOTIFICATIONS_CORE_DIR . '/templates');
        define('WP_REM_NOTIFICATIONS_PLUGIN_URL', WP_PLUGIN_URL . '/wp-realestate-manager/modules/wp-rem-notifications');

        $this->email_template_type = 'Property Alert';

        $this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">' . wp_rem_plugin_text_srt('wp_rem_alerts_property_alert') . '</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>' . wp_rem_plugin_text_srt('wp_rem_alerts_hello') . '! ' . wp_rem_plugin_text_srt('wp_rem_alerts_following_properties') . ' [SITE_NAME]</td></tr><tr><td style="padding: 10px 0 0 0;">' . wp_rem_plugin_text_srt('wp_rem_alerts_property_alert_title') . ': [LSITING_ALERT_TITLE]</td></tr><tr><td style="padding: 10px 0 0 0;">[LSITING_ALERT_LSITINGS_LIST]</td></tr><tr><td style="padding: 10px 0 0 0;">' . wp_rem_plugin_text_srt('wp_rem_alerts_property_link') . ': [LSITING_ALERT_FULL_PROPERTY_URL]</td></tr><tr><td style="padding: 10px 0 0 0;">' . wp_rem_plugin_text_srt('wp_rem_alerts_properties_count') . ': [LSITING_ALERT_TOTAL_LSITINGS_COUNT]</td></tr><tr><td style="padding: 10px 0 0 0;">' . wp_rem_plugin_text_srt('wp_rem_alerts_alert_frequency') . ': [LSITING_ALERT_FREQUENCY]</td></tr><tr><td style="padding: 10px 0 0 0;">' . wp_rem_plugin_text_srt('wp_rem_alerts_to_unsubscribe') . ': [LSITING_ALERT_UNSUBSCRIBE_LINK]</td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

        $this->email_template_variables = array(
            array(
                'tag' => 'LSITING_ALERT_TITLE',
                'display_text' => 'Property Alert Title',
                'value_callback' => array( $this, 'get_property_alert_title' ),
            ),
            array(
                'tag' => 'LSITING_ALERT_LSITINGS_LIST',
                'display_text' => wp_rem_plugin_text_srt('wp_rem_alerts_filtered_properties'),
                'value_callback' => array( $this, 'get_filtered_properties_list' ),
            ),
            array(
                'tag' => 'LSITING_ALERT_TOTAL_LSITINGS_COUNT',
                'display_text' => wp_rem_plugin_text_srt('wp_rem_alerts_total_properties'),
                'value_callback' => array( $this, 'get_total_properties_count' ),
            ),
            array(
                'tag' => 'LSITING_ALERT_UNSUBSCRIBE_LINK',
                'display_text' => wp_rem_plugin_text_srt('wp_rem_alerts_unsubscribe_link'),
                'value_callback' => array( $this, 'get_unsubscribe_link' ),
            ),
            array(
                'tag' => 'LSITING_ALERT_FREQUENCY',
                'display_text' => wp_rem_plugin_text_srt('wp_rem_alerts_property_alert_frequency'),
                'value_callback' => array( $this, 'get_frequency' ),
            ),
            array(
                'tag' => 'LSITING_ALERT_FULL_PROPERTY_URL',
                'display_text' => wp_rem_plugin_text_srt('wp_rem_alerts_full_property_url'),
                'value_callback' => array( $this, 'get_full_property_url' ),
            ),
        );

        $this->email_template_index = 'property-alert-template';
        $this->template_group = 'property';

        // Initialize Addon
        add_action('init', array( $this, 'init' ), 0);
    }

    /**
     * Initialize application, load text domain, enqueue scripts and bind hooks
     */
    public function init() {
        // Add Plugin textdomain

        add_action('wp_enqueue_scripts', array( $this, 'enqueue_scripts' ));
        //add_filter('wp_rem_notifications_theme_options', array($this, 'theme_options'));
        // Include Custom Post Type class - Create Notification type and meta boxes.
        require_once WP_REM_NOTIFICATIONS_INCLUDES_DIR . '/class-notifications-post-type.php';
        require_once WP_REM_NOTIFICATIONS_INCLUDES_DIR . '/class-notifications-plugin-options.php';
        require_once WP_REM_NOTIFICATIONS_INCLUDES_DIR . '/class-notifications-helpers.php';
        require_once WP_REM_NOTIFICATIONS_INCLUDES_DIR . '/class-notifications-member-ui.php';
        // Add hook for frontend UI.
        add_action('pre_wp_rem_properties_property', array( $this, 'frontend_ui_callback' ), 10, 0);
        add_action('wp_rem_save_search_element', array( $this, 'wp_rem_save_search_element_callback' ), 10, 0);
        // Hook our function , create_daily_alert_schedule_callback(), into the action create_daily_alert_schedule.
        add_action('create_daily_alert_schedule_action', array( $this, 'create_daily_alert_schedule_callback' ));
        // temprary testing
        // 
        if ( isset($_GET['wp_rem_cron']) && $_GET['wp_rem_cron'] == 'yes' ) {
            do_action('create_daily_alert_schedule_action');
        }
        // Add optinos in Email Template Settings
        add_filter('wp_rem_email_template_settings', array( $this, 'email_template_settings_callback' ), 0, 1);
        //add_action('init', array( $this, 'create_daily_alert_schedule_callback' ), 1000, 1);
        add_action('init', array( $this, 'add_email_template_callback' ), 5);
    }

    /**
     * Enqueue Frontend Styles and Scripts
     */
    public function enqueue_scripts() {
        // Enqueue CSS
        wp_enqueue_style('wp-rem-notifications-css', WP_REM_NOTIFICATIONS_PLUGIN_URL . '/assets/css/wp-rem-notifications-frontend.css');
        // Register JS, should be included in header as this uses some variables.
        wp_register_script('wp-rem-alerts-js', WP_REM_NOTIFICATIONS_PLUGIN_URL . '/assets/js/wp-rem-notifications.js', '', '', true);

        wp_localize_script('wp-rem-alerts-js', 'wp_rem_notifications', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'security' => wp_create_nonce("wp_rem_create_property_alert"),
                )
        );
    }

    public function property_alert_notices_callback() {
        foreach ( $this->admin_notices as $value ) {
            echo $value;
        }
    }

    public function after_properties_property_callback($properties_query, $sort_by) {
        echo '<div class="properties_query hidden">' . json_encode($properties_query) . '</div>';
    }

    public function frontend_ui_callback() {
        global  $wp_rem_form_fields_frontend;
        wp_enqueue_script('wp-rem-alerts-js');
        $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
        $wp_rem_terms_conditions = isset($wp_rem_plugin_options['wp_rem_terms_conditions']) ? $wp_rem_plugin_options['wp_rem_terms_conditions'] : '';
        $frequencies = array(
            'wp_rem_frequency_daily' => wp_rem_plugin_text_srt('wp_rem_alerts_daily'),
            'wp_rem_frequency_weekly' => wp_rem_plugin_text_srt('wp_rem_alerts_weekly'),
            'wp_rem_frequency_fortnightly' => wp_rem_plugin_text_srt('wp_rem_alerts_fortnightly'),
            'wp_rem_frequency_monthly' => wp_rem_plugin_text_srt('wp_rem_alerts_monthly'),
            'wp_rem_frequency_biannually' => wp_rem_plugin_text_srt('wp_rem_alerts_biannually'),
            'wp_rem_frequency_annually' => wp_rem_plugin_text_srt('wp_rem_alerts_annually'),
            'wp_rem_frequency_never' => wp_rem_plugin_text_srt('wp_rem_alerts_never'),
        );
        $options_str = '';
        $options_search_str = '';
        $is_one_checked = false;
        $checked = '';
        $frequency_counter = 2;
        $frequency_exists_flag = false;

        $options_str .= '<ul>';
        $options_str .= '<li><input id="frequency-1" name="alert-frequency" class="radio-frequency css-radio" maxlength="75" type="radio" value="never" checked="checked"> <label for="frequency-1" class="css-radio-lbl">' . wp_rem_plugin_text_srt('wp_rem_alerts_no_email_alerts') . '</label></li>';
        foreach ( $frequencies as $frequency => $label ) {
            // If it is 'on' then show it's option
            if ( isset($wp_rem_plugin_options[$frequency]) && 'on' == $wp_rem_plugin_options[$frequency] ) {
                $frequency_exists_flag = true;
                $options_str .= '<li><input id="frequency-' . $frequency_counter . '" name="alert-frequency" class="radio-frequency css-radio" maxlength="75" type="radio" value="' . strtolower($label) . '" ' . $checked . '> <label for="frequency-' . $frequency_counter . '" class="css-radio-lbl">' . $label . ' ' . wp_rem_plugin_text_srt('wp_rem_alerts_summary_email') . '</label></li>';
                $frequency_counter ++;
            }
        }
        $options_str .= '</ul>';

        // Get logged in user email and hide email address field.
        $user = wp_get_current_user();
        $disabled = '';
        $email = '';
        if ( $user->ID > 0 ) {
            $email = $user->user_email;
            $disabled = ' disabled="disabled"';
        }
        ?>

        <div class="email-me-top">
            <!-- Trigger the modal with a button -->
            <button type="button" class="email-alert-btn" data-toggle="modal" data-target="#property-alert-model"><?php echo wp_rem_plugin_text_srt('wp_rem_alerts_create_email_alerts'); ?></button>
            <!-- Modal -->
            <div id="property-alert-model" class="modal fade modal-form" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><?php echo wp_rem_plugin_text_srt('wp_rem_alerts_email_save_search'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="property-alert-box property-alert property-alert-container-top" >
                                <div class="search-query-filters">
                                    <h6><?php echo wp_rem_plugin_text_srt('wp_rem_alerts_filter_criteria'); ?></h6>
                                    <ul id="wp-rem-tags" class="tagit ui-widget ui-widget-content ui-corner-all">
                                        <?php
                                        //get all query string
                                        $qrystr = $_REQUEST;
                                        $query_flag = false;
                                        if ( isset($qrystr) ) {
                                            $flag = 1;
                                            $qrystr = array_filter($qrystr);
                                            foreach ( $qrystr as $qry_var => $qry_val ) {
                                                if ( 'ajax_filter' == $qry_var || 'advanced_search' == $qry_var || 'property_arg' == $qry_var || 'action' == $qry_var || 'alert-frequency' == $qry_var || 'alerts-name' == $qry_var || 'loc_polygon' == $qry_var || 'alerts-email' == $qry_var || 'loc_polygon_path' == $qry_var )
                                                    continue;

                                                if ( $qry_val != '' ) {
                                                    $query_flag = true;
                                                    $flag ++;
                                                    echo '<li class="tagit-choice ui-widget-content ui-state-default ui-corner-all tagit-choice-editable"><span class="tagit-label">';
                                                    echo esc_html(ucwords(str_replace("-", " ", str_replace("+", " ", $qry_val))));
                                                    echo '</span></li>';
                                                }
                                            }
                                        }
                                        if ( $query_flag == false ) {
                                            echo '<li class="tagit-choice ui-widget-content ui-state-default ui-corner-all tagit-choice-editable"><span class="tagit-label">';
                                            echo wp_rem_plugin_text_srt('wp_rem_alerts_all_properties');
                                            echo '</span></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <!--<form class="property-alerts">-->
                                <div class="validation error hide">
                                    <label class="" for="alerts-email-top"><?php echo wp_rem_plugin_text_srt('wp_rem_alerts_enter_valid_email'); ?></label>
                                </div>
                                <div class="newsletter">
                                    <?php
                                    echo '<div class="field-holder">';
                                    $wp_rem_field_opt = array(
                                        'id' => 'alerts-name',
                                        'cust_name' => 'alerts-name',
                                        'std' => '',
                                        'desc' => '',
                                        'classes' => 'form-control name-input-top',
                                        'extra_atr' => ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_alerts_alert_name_title') . '" maxlength="75"',
                                        'hint_text' => '',
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_field_opt);
                                    echo '</div>';

                                    echo '<div class="field-holder">';
                                    $wp_rem_field_opt = array(
                                        'id' => 'alerts-email',
                                        'cust_name' => 'alerts-email',
                                        'std' => $email,
                                        'desc' => '',
                                        'classes' => 'form-control email-input-top alerts-email',
                                        'extra_atr' => $disabled . ' placeholder="' . wp_rem_plugin_text_srt('wp_rem_alerts_email_address') . '"',
                                        'hint_text' => '',
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_field_opt);
                                    echo '</div>';

                                    if ( strlen($options_str) > 0 && $frequency_exists_flag == true ) :
                                        ?>
                                        <div class="field-holder">
                                            <div class="alert-frequency">
                                                <h6><?php echo wp_rem_plugin_text_srt('wp_rem_alerts_alert_frequency'); ?>:</h6>
                                                <?php echo $options_str; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="field-holder">
                                        <div class="propertyalert-submit-button input-button-loader">
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'std' => wp_rem_plugin_text_srt('wp_rem_alerts_submit'),
                                                'cust_name' => 'AlertsEmail',
                                                'return' => false,
                                                'classes' => 'propertyalert-submit',
                                                'cust_type' => 'button',
                                                'force_std' => true,
                                            );
                                            $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                </div>

                                <?php if ( $wp_rem_terms_conditions <> '' ) : ?>
                                    <div class="terms-message"><?php echo html_entity_decode($wp_rem_terms_conditions); ?></div>
                                <?php endif; ?>
                                <!--</form>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end class email-me-top -->
        <?php
    }

    public static function create_daily_alert_schedule() {
        // Use wp_next_scheduled to check if the event is already scheduled.
        $timestamp = wp_next_scheduled('create_daily_alert_schedule');

        // If $timestamp == false schedule daily alerts since it hasn't been done previously.
        if ( $timestamp == false ) {
            // Schedule the event for right now, then to repeat daily using the hook 'create_daily_alert_schedule'.
            wp_schedule_event(time(), 'hourly', 'create_daily_alert_schedule_action');
        }
    }

    public function add_email_template_callback() {
        $email_templates = array();
        $email_templates[$this->template_group] = array();
        $email_templates[$this->template_group][$this->email_template_index] = array(
            'title' => $this->email_template_type,
            'template' => $this->email_default_template,
            'email_template_type' => $this->email_template_type,
            'is_recipients_enabled' => false,
            'description' => wp_rem_plugin_text_srt('wp_rem_alerts_email_template_desc'),
            'jh_email_type' => 'html',
        );
        do_action('wp_rem_load_email_templates', $email_templates);
    }

    public function get_template() {
        return wp_rem::get_template($this->email_template_index, $this->email_template_variables, $this->email_default_template);
    }

    public function create_daily_alert_schedule_callback() {
        // Get alerts
        $args = array(
            'post_type' => 'property-alert',
        );


        $property_details = array();
        $property_alerts = new WP_Query($args);
        //echo $property_alerts->request;
        //wp_rem_dbg( $property_alerts->get_posts() );
        while ( $property_alerts->have_posts() ) {

            $property_alerts->the_post();
            $property_id = get_the_ID();
            $frequency_annually = get_post_meta($property_id, 'wp_rem_frequency_annually', true);
            $frequency_biannually = get_post_meta($property_id, 'wp_rem_frequency_biannually', true);
            $frequency_monthly = get_post_meta($property_id, 'wp_rem_frequency_monthly', true);
            $frequency_fortnightly = get_post_meta($property_id, 'wp_rem_frequency_fortnightly', true);
            $frequency_weekly = get_post_meta($property_id, 'wp_rem_frequency_weekly', true);
            $frequency_daily = get_post_meta($property_id, 'wp_rem_frequency_daily', true);
            $frequency_never = get_post_meta($property_id, 'wp_rem_frequency_never', true);
            $last_time_email_sent = get_post_meta($property_id, 'wp_rem_last_time_email_sent', true);

            $set_frequency = '';
            if ( ! empty($frequency_annually) ) {
                $selected_frequency = '+365 days';
                $set_frequency = wp_rem_plugin_text_srt('wp_rem_alerts_annually');
            } else if ( ! empty($frequency_biannually) ) {
                $selected_frequency = '+182 days';
                $set_frequency = wp_rem_plugin_text_srt('wp_rem_alerts_biannualy2');
            } else if ( ! empty($frequency_monthly) ) {
                $selected_frequency = '+30 days';
                $set_frequency = wp_rem_plugin_text_srt('wp_rem_alerts_monthly');
            } else if ( ! empty($frequency_fortnightly) ) {
                $selected_frequency = '+15 days';
                $set_frequency = wp_rem_plugin_text_srt('wp_rem_alerts_fortnightly');
            } else if ( ! empty($frequency_weekly) ) {
                $selected_frequency = '+7 days';
                $set_frequency = wp_rem_plugin_text_srt('wp_rem_alerts_weekly');
            } else if ( ! empty($frequency_daily) ) {
                $selected_frequency = '+1 days';
                $set_frequency = wp_rem_plugin_text_srt('wp_rem_alerts_daily');
            } else if ( ! empty($frequency_never) ) {
                $selected_frequency = false;
                $set_frequency = wp_rem_plugin_text_srt('wp_rem_alerts_never');
            } else {
                $selected_frequency = false;
                $set_frequency = '';
            }

            if ( $selected_frequency != false ) {
                $email_template_variables = array();
                $email_template = '';

                $querystring = get_post_meta($property_id, 'wp_rem_query', true);

                parse_str($querystring, $properties_query_array);
                $property_obj = $this->get_properties_by_query($properties_query_array, $selected_frequency);
                $property_found_count = $property_obj->found_posts;
                if ( time() > strtotime($selected_frequency, intval($last_time_email_sent)) ) {


                    // Set this for email data.
                    self::$property_details = array(
                        'id' => $property_id,
                        'title' => get_the_title(),
                        'properties_query' => $querystring,
                        'email' => get_post_meta($property_id, 'wp_rem_email', true),
                        'url_query' => get_post_meta($property_id, 'wp_rem_query', true),
                        'frequency' => $selected_frequency,
                        'set_frequency' => $set_frequency,
                    );


                    $template = $this->get_template();

                    // Checking email notification is enabled/disabled.
                    if ( isset($template['email_notification']) && $template['email_notification'] == 1 && $property_found_count > 0 ) {

                        $subject = (isset($template['subject']) && $template['subject'] != '' ) ? $template['subject'] : wp_rem_plugin_text_srt('wp_rem_alerts_property_found_at') . get_bloginfo('name');
                        //$from = (isset($template['from']) && $template['from'] != '') ? $template['from'] : esc_attr($blogname) . ' <' . $admin_email . '>';
                        $recipients = (isset($template['recipients']) && $template['recipients'] != '') ? $template['recipients'] : self::$property_details['email']; //$this->get_property_added_email();
                        $email_type = (isset($template['email_type']) && $template['email_type'] != '') ? $template['email_type'] : 'plain_text';

                        $args = array(
                            'to' => self::$property_details['email'],
                            'subject' => $subject,
                            //'from' => $from,
                            'message' => $template['email_template'],
                            'email_type' => $email_type,
                            'class_obj' => $this,
                        );
                        // Update last time email sent for this property alert.
                        update_post_meta($property_id, 'wp_rem_last_time_email_sent', time());
                        //  Send email.
                        do_action('wp_rem_send_mail', $args);
                    }
                }
            }
        }
    }

    public static function remove_daily_alert_schedule() {
        wp_clear_scheduled_hook('create_daily_alert_schedule');
    }

    public function email_template_settings_callback($email_template_options) {

        $email_template_options["types"][] = $this->email_template_type;
        $email_template_options["templates"]["property alert"] = $this->email_default_template;
        $email_template_options["variables"]["property alert"] = $this->email_template_variables;
        return $email_template_options;
    }

    public static function get_property_alert_title() {
        if ( isset(self::$property_details['title']) ) {
            return ucfirst(self::$property_details['title']);
        }
        return false;
    }

    public static function get_filtered_properties_list() {
        if ( isset(self::$property_details['properties_query']) ) {


            parse_str(self::$property_details['properties_query'], $properties_query_array);
            $property_obj = self::get_properties_by_query($properties_query_array, self::$property_details['frequency']);

            ob_start();
            ?>
            <table cellpadding="0px" cellspacing="0px">
                <?php while ( $property_obj->have_posts() ) : $property_obj->the_post(); ?>
                    <tr><td style="padding: 5px 0 0 0;"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></td></tr>
                <?php endwhile; ?>
            </table>
            <?php
            $html1 = ob_get_clean();
            return $html1;
        }
        return false;
    }

    public static function get_total_properties_count() {

        if ( isset(self::$property_details['properties_query']) ) {
            parse_str(self::$property_details['properties_query'], $properties_query_array);
            $property_obj = self::get_properties_by_query($properties_query_array, self::$property_details['frequency']);
            $property_found_count = $property_obj->found_posts;
            return $property_found_count;
        }
        return false;
    }

    public static function get_unsubscribe_link() {
        if ( isset(self::$property_details['id']) ) {
            return '<a href="' . admin_url('admin-ajax.php') . '?action=wp_rem_unsubscribe_property_alert&jaid=' . self::$property_details['id'] . '">' . wp_rem_plugin_text_srt('wp_rem_alerts_unsubcribe') . '</a>';
        }
        return false;
    }

    public static function get_frequency() {
        if ( isset(self::$property_details['set_frequency']) ) {
            return self::$property_details['set_frequency'];
        }
        return false;
    }

    public static function get_full_property_url() {
        if ( isset(self::$property_details['id']) ) {
            $wp_rem_plugin_options = get_option('wp_rem_plugin_options');
            $default_property_page = '';
            if ( isset($wp_rem_plugin_options['wp_rem_search_result_page']) ) {
                $page = get_post($wp_rem_plugin_options['wp_rem_search_result_page']);
                $default_property_page = $page->post_name;
            }
            //wp_rem_search_result_page
            return '<a href="' . get_bloginfo('url') . '/' . $default_property_page . '?' . self::$property_details['url_query'] . '">' . wp_rem_plugin_text_srt('wp_rem_alerts_view_full_property') . '</a>';
        }
        return false;
    }

    public static function get_property_alerts_count($properties_query, $frequency) {
        $frequency = str_replace('+', '-', $frequency);
        $properties_query['meta_query'][] = array(
            'key' => 'wp_rem_property_posted',
            'value' => strtotime(date('Y/m/d', strtotime($frequency))),
            'compare' => '>=',
        );
        $properties_query['posts_per_page'] = -1;
        $loop_count = new WP_Query($properties_query);
        //wp_rem_dbg( $loop_count );

        return $loop_count->found_posts;
    }

    static function get_filter_arg($property_type, $request_data) {
        global $wp_rem_post_property_types;
        $filter_arr = '';
        if ( isset($request_data['ajax_filter']) ) {
            if ( isset($property_type) && $property_type != '' ) {

                $property_type_category_name = 'wp_rem_property_category';   // category_fieldname in db and request
                if ( isset($request_data[$property_type_category_name]) && $request_data[$property_type_category_name] != '' ) {
                    $dropdown_query_str_var_name = explode(",", $request_data[$property_type_category_name]);
                    $cate_filter_multi_arr ['relation'] = 'OR';
                    foreach ( $dropdown_query_str_var_name as $query_str_var_name_key ) {
                        $cate_filter_multi_arr[] = array(
                            'key' => $property_type_category_name,
                            'value' => serialize($query_str_var_name_key),
                            'compare' => 'LIKE',
                        );
                    }
                    if ( isset($cate_filter_multi_arr) && ! empty($cate_filter_multi_arr) ) {
                        $filter_arr[] = array(
                            $cate_filter_multi_arr
                        );
                    }
                }
                $wp_rem_property_type_cus_fields = $wp_rem_post_property_types->wp_rem_types_custom_fields_array($property_type);
                $wp_rem_fields_output = '';
                if ( is_array($wp_rem_property_type_cus_fields) && sizeof($wp_rem_property_type_cus_fields) > 0 ) {
                    $custom_field_flag = 1;
                    foreach ( $wp_rem_property_type_cus_fields as $cus_fieldvar => $cus_field ) {
                        if ( isset($cus_field['enable_srch']) && $cus_field['enable_srch'] == 'yes' ) {
                            $query_str_var_name = $cus_field['meta_key'];
                            // only for date type field need to change field name
                            if ( $cus_field['type'] == 'date' ) {

                                if ( $cus_field['type'] == 'date' ) {

                                    $from_date = 'from' . $query_str_var_name;
                                    $to_date = 'to' . $query_str_var_name;
                                    if ( isset($request_data[$from_date]) && $request_data[$from_date] != '' ) {
                                        $filter_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => strtotime($request_data[$from_date]),
                                            'compare' => '>=',
                                        );
                                    }
                                    if ( isset($request_data[$to_date]) && $request_data[$to_date] != '' ) {
                                        $filter_arr[] = array(
                                            'key' => $query_str_var_name,
                                            'value' => strtotime($request_data[$to_date]),
                                            'compare' => '<=',
                                        );
                                    }
                                }
                            } else if ( isset($request_data[$query_str_var_name]) && $request_data[$query_str_var_name] != '' ) {

                                if ( $cus_field['type'] == 'dropdown' ) {
                                    if ( isset($cus_field['multi']) && $cus_field['multi'] == 'yes' ) {
                                        $filter_multi_arr ['relation'] = 'OR';
                                        $dropdown_query_str_var_name = explode(",", $request_data[$query_str_var_name]);
                                        foreach ( $dropdown_query_str_var_name as $query_str_var_name_key ) {
                                            if ( $cus_field['post_multi'] == 'yes' ) {
                                                $filter_multi_arr[] = array(
                                                    'key' => $query_str_var_name,
                                                    'value' => serialize($query_str_var_name_key),
                                                    'compare' => 'Like',
                                                );
                                            } else {
                                                $filter_multi_arr[] = array(
                                                    'key' => $query_str_var_name,
                                                    'value' => $query_str_var_name_key,
                                                    'compare' => '=',
                                                );
                                            }
                                        }
                                        $filter_arr[] = array(
                                            $filter_multi_arr
                                        );
                                    } else {
                                        if ( $cus_field['post_multi'] == 'yes' ) {

                                            $filter_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => serialize($request_data[$query_str_var_name]),
                                                'compare' => 'Like',
                                            );
                                        } else {
                                            $filter_arr[] = array(
                                                'key' => $query_str_var_name,
                                                'value' => $request_data[$query_str_var_name],
                                                'compare' => '=',
                                            );
                                        }
                                    }
                                } elseif ( $cus_field['type'] == 'text' || $cus_field['type'] == 'email' || $cus_field['type'] == 'url' || $cus_field['type'] == 'number' ) {
                                    $filter_arr[] = array(
                                        'key' => $query_str_var_name,
                                        'value' => $request_data[$query_str_var_name],
                                        'compare' => 'LIKE',
                                    );
                                } elseif ( $cus_field['type'] == 'range' ) {
                                    $ranges_str_arr = explode(",", $request_data[$query_str_var_name]);
                                    if ( ! isset($ranges_str_arr[1]) ) {
                                        $ranges_str_arr = explode(",", $ranges_str_arr[0]);
                                    }
                                    $range_first = $ranges_str_arr[0];
                                    $range_seond = $ranges_str_arr[1];
                                    $filter_arr[] = array(
                                        'key' => $query_str_var_name,
                                        'value' => $range_first,
                                        'compare' => '>=',
                                        'type' => 'numeric'
                                    );
                                    $filter_arr[] = array(
                                        'key' => $query_str_var_name,
                                        'value' => $range_seond,
                                        'compare' => '<=',
                                        'type' => 'numeric'
                                    );
                                }
                            }
                        }
                        $custom_field_flag ++;
                    }
                }
            }
        }
        return $filter_arr;
    }

    static function get_properties_by_query($properties_query_array, $frequency) {
        global $wpdb;
        /*
         * Query building
         */

        $default_date_time_formate = 'd-m-Y H:i:s';
        $frequency = str_replace('+', '-', $frequency);
        $properties_query['meta_query'][] = array(
            'key' => 'wp_rem_property_posted',
            'value' => strtotime(date('Y/m/d', strtotime($frequency))),
            'compare' => '>=',
        );

        /* $element_filter_arr[] = array(
          'key' => 'wp_rem_property_posted',
          'value' => strtotime( date( $default_date_time_formate ) ),
          'compare' => '<=',
          ); */

        $element_filter_arr[] = array(
            'key' => 'wp_rem_property_expired',
            'value' => strtotime(date($default_date_time_formate)),
            'compare' => '>=',
        );

        $element_filter_arr[] = array(
            'key' => 'property_member_status',
            'value' => 'active',
            'compare' => '=',
        );

        $element_filter_arr[] = array(
            'key' => 'wp_rem_property_status',
            'value' => 'active',
            'compare' => '=',
        );

        if ( isset($properties_query_array['property_type']) ) {
            $element_filter_arr[] = array(
                'key' => 'wp_rem_property_type',
                'value' => $properties_query_array['property_type'],
                'compare' => '=',
            );
        }
        $left_filter_arr = array();
        if ( isset($properties_query_array['property_type']) ) {
            $left_filter_arr = self::get_filter_arg($properties_query_array['property_type'], $properties_query_array);
        }
        $meta_post_ids_arr = wp_rem_get_query_whereclase_by_array($left_filter_arr);
        $property_id_condition = '';
        if ( isset($left_filter_arr) && ! empty($left_filter_arr) ) {
            $meta_post_ids_arr = wp_rem_get_query_whereclase_by_array($left_filter_arr);
            // if no result found in filtration 
            if ( empty($meta_post_ids_arr) ) {
                $meta_post_ids_arr = array( 0 );
            }
            $ids = $meta_post_ids_arr != '' ? implode(",", $meta_post_ids_arr) : '0';
            $property_id_condition = " ID in (" . $ids . ") AND ";
        }
        $post_ids = $wpdb->get_col("SELECT ID FROM $wpdb->posts WHERE " . $property_id_condition . " post_type='properties' AND post_status='publish'");
        $property_sort_by = 'recent';    // default value
        $property_sort_order = 'desc';   // default value

        if ( isset($properties_query_array['sort-by']) && $properties_query_array['sort-by'] != '' ) {
            $property_sort_by = $properties_query_array['sort-by'];
        }
        if ( $property_sort_by == 'recent' ) {
            $qryvar_property_sort_type = 'DESC';
            $qryvar_sort_by_column = 'post_date';
        } elseif ( $property_sort_by == 'alphabetical' ) {
            $qryvar_property_sort_type = 'ASC';
            $qryvar_sort_by_column = 'post_title';
        }
        $args = array(
            'posts_per_page' => 10,
            'post_type' => 'properties',
            'post_status' => 'publish',
            'order' => $qryvar_property_sort_type,
            'orderby' => $qryvar_sort_by_column,
            'fields' => 'ids', // only load ids
            'meta_query' => array(
                $element_filter_arr,
            ),
        );

        $all_post_ids = $post_ids;

        if ( ! empty($all_post_ids) ) {

            $args_count['post__in'] = $all_post_ids;
            $args['post__in'] = $all_post_ids;
        }

        $property_loop_obj = wp_rem_get_cached_obj('property_result_cached_loop_obj', $args, 12, false, 'wp_query');
        return $property_loop_obj;
    }

    public function wp_rem_save_search_element_callback() {
        global $wp_rem_form_fields_frontend;
        //$user->ID
        $target_class = ' wp-rem-open-register-tab';
        if ( is_user_logged_in() ) {
            $target_class = '';
        }
        ?>
        <div class="email-me-top">
            <button type="button" class="email-alert-btn<?php echo esc_attr($target_class); ?>" data-toggle="modal" data-target="#property-alert-model"><?php echo wp_rem_plugin_text_srt('wp_rem_alerts_save_search'); ?></button>
        </div>
        <?php
    }

}

new Wp_rem_Property_Alerts();
