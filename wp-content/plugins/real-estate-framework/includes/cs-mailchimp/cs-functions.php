<?php
if ( ! function_exists('wp_rem_cs_mailchimp_list') ) {

    /**
     * Mailchimp list.
     *
     * @param string $apikey mailchimp shortcode api key.
     */
    function wp_rem_cs_mailchimp_list($apikey) {
        global $wp_rem_cs_var_options;
        $MailChimp = new MailChimp($apikey);
        $mailchimp_list = $MailChimp->call('lists/list');
        return $mailchimp_list;
    }

    /**
     * Mailchimp list.
     */
    if ( ! function_exists('wp_rem_cs_mailchimp') ) {

        add_action('wp_ajax_nopriv_wp_rem_cs_mailchimp', 'wp_rem_cs_mailchimp');
        add_action('wp_ajax_wp_rem_cs_mailchimp', 'wp_rem_cs_mailchimp');

        /**
         * Mailchimp list.
         */
        function wp_rem_cs_mailchimp() {
            global $wp_rem_cs_var_options, $counter, $wp_rem_cs_var_frame_static_text;
            $msg = array();
            $wp_rem_cs_var_subscribe_success = isset($wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subscribe_success']) ? $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_subscribe_success'] : '';
            $wp_rem_cs_var_api_set_msg = isset($wp_rem_cs_var_frame_static_text['wp_rem_cs_var_api_set_msg']) ? $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_api_set_msg'] : '';
            $mc_email = wp_rem_cs_get_input('mc_email', false, false);
            $wp_rem_cs_list_id = wp_rem_cs_get_input('mail_list_id', false, false);
            $mailchimp_key = wp_rem_cs_get_input('mail_key', false, false);
            $mailchimp_key = isset($mailchimp_key) ? $mailchimp_key : '';
            $wp_rem_cs_list_id = isset($wp_rem_cs_list_id) ? $wp_rem_cs_list_id : '';


            if ( isset($mc_email) && ! empty($wp_rem_cs_list_id) && '' !== $mailchimp_key ) {
                if ( $mailchimp_key <> '' ) {
                    $MailChimp = new MailChimp($mailchimp_key);
                }
                $email = $mc_email;
                $list_id = $wp_rem_cs_list_id;
                $result = $MailChimp->call('lists/subscribe', array(
                    'id' => $list_id,
                    'email' => array( 'email' => $email ),
                    'merge_vars' => array(),
                    'double_optin' => false,
                    'update_existing' => false,
                    'replace_interests' => false,
                    'send_welcome' => true,
                ));
                if ( '' !== $result ) {
                    if ( isset($result['status']) && 'error' === $result['status'] ) {
                        $msg['type'] = 'error';
                        $msg['msg'] = wp_rem_cs_allow_special_char($result['error']);
                    } else {
                        $msg['type'] = 'success';
                        $msg['msg'] = wp_rem_cs_allow_special_char($wp_rem_cs_var_subscribe_success);
                    }
                }
            } else {
                $msg['type'] = 'error';
                $msg['msg'] = wp_rem_cs_allow_special_char($wp_rem_cs_var_api_set_msg);
            }
            echo json_encode($msg);
            die();
        }

    }
}

/**
 * Mailchimp frontend form.
 */
if ( ! function_exists('wp_rem_cs_custom_mailchimp') ) {

    /**
     * Mailchimp frontend form.
     *
     * @param bolean $under_construction checking under construction.
     */
    function wp_rem_cs_custom_mailchimp($under_construction = '0', $mail_key = '', $mail_list_id = '') {

        global $wp_rem_cs_var_options, $counter, $social_switch, $wp_rem_cs_var_frame_static_text;
        $wp_rem_cs_var_enter_valid = isset($wp_rem_cs_var_frame_static_text['wp_rem_cs_var_enter_valid']) ? $wp_rem_cs_var_frame_static_text['wp_rem_cs_var_enter_valid'] : '';
        $counter ++;
        $newsletter_elemnt_class = '';
        if($under_construction == 4){
            $newsletter_elemnt_class = ' class="newsletter-form"';
        }
        
        
        ?>
        <script>
            function wp_rem_cs_mailchimp_submit(theme_url, counter, admin_url) {
                'use strict';
                $ = jQuery;
                var thisObj = $('.mailchimp-btn-loader-' + counter);
                wp_rem_show_loader('.mailchimp-btn-loader-' + counter, '', 'button_loader', thisObj);
                $.ajax({
                    type: 'POST',
                    url: admin_url,
                    data: $('#mcform_' + counter).serialize() + '&mail_key=<?php echo esc_html($mail_key) ?>&mail_list_id=<?php echo esc_html($mail_list_id) ?>&action=wp_rem_cs_mailchimp',
                    dataType: "json",
                    success: function (response) {
                        $('#mcform_' + counter).get(0).reset();
                        wp_rem_show_response(response, '', thisObj);
                    }
                });
            }
            function hide_div(div_hide) {
                jQuery('#' + div_hide).hide();
            }
        </script>
        <div id ="process_newsletter_<?php echo intval($counter); ?>"<?php echo ($newsletter_elemnt_class);?>>
            <div id="process_<?php echo intval($counter); ?>" class="status status-message cs-spinner" style="display:none"></div>
            <div id="newsletter_error_div_<?php echo intval($counter); ?>" style="display:none" class="alert alert-danger">
                <button class="close" type="button" onclick="hide_div('newsletter_error_div_<?php echo intval($counter); ?>')" aria-hidden="true">×</button>
                <p><i class="icon-warning4"></i>
                    <span id="newsletter_mess_error_<?php echo intval($counter); ?>"></span></p>
            </div> 
            <div id="newsletter_success_div_<?php echo intval($counter); ?>" style="display:none" class="alert alert-success">
                <button class="close" type="button" onclick="hide_div('newsletter_success_div_<?php echo intval($counter); ?>')" aria-hidden="true">×</button>
                <p><i class="icon-warning4"></i><span id="newsletter_mess_success_<?php echo intval($counter); ?>"></span></p>
            </div>
            <form  action="javascript:wp_rem_cs_mailchimp_submit('<?php echo get_template_directory_uri() ?>','<?php echo esc_js($counter); ?>','<?php echo admin_url('admin-ajax.php'); ?>')" id="mcform_<?php echo intval($counter); ?>" method="post">
                <?php
                if ( $under_construction == 4 ) {
                    ?>
                    <div class="field-holder">
                        <input class="field-input" id="mc_email<?php echo intval($counter); ?>" type="text" name="mc_email" placeholder="<?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_newsletter_email_id'); ?>">
                        <label class="mailchimp-btn-loader-<?php echo intval($counter); ?> input-button-loader">
                            <input class="btn-holder bgcolor br-color" id="btn_newsletter_<?php echo intval($counter); ?>" type="submit" value="<?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_newsletter_subscribe'); ?>">
                        </label>
                    </div>

                    <?php
                } else {




                    if ( $under_construction == '2' ) {
                        ?>
                        <div class="news-letter-heading">
                            <h6><?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_maintenance_newsletter'); ?></h6>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="field-holder">
                        <input id="wp_rem_cs_list_id<?php echo intval($counter); ?>" type="hidden" name="wp_rem_cs_list_id" value="<?php
                        if ( isset($mail_list_id) ) {
                            echo esc_attr($mail_list_id);
                        }
                        ?>" />
                        <input type="text" id="mc_email<?php echo intval($counter); ?>" class="txt-bar field-input"  name="mc_email" placeholder=" <?php echo esc_html($wp_rem_cs_var_enter_valid); ?>"   >
                        <?php
                        if ( $under_construction == 2 ) {
                            ?>
                            <label class="mailchimp-btn-loader-<?php echo intval($counter); ?> input-button-loader">
                                <input class="btn-submit bgcolor btn-holder" id="btn_newsletter_<?php echo intval($counter); ?>" type="submit" value="<?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_maintenance_newsletter_sign_up'); ?>">
                            </label>
                            <?php
                        }
                        if ( $under_construction == 3 ) {
                            ?>
                            <label class="mailchimp-btn-loader-<?php echo intval($counter); ?> input-button-loader">
                                <input class="btn-submit bgcolor btn-holder" id="btn_newsletter_<?php echo intval($counter); ?>" type="submit" value="<?php echo wp_rem_cs_var_frame_text_srt('wp_rem_cs_var_maintenance_newsletter_sign_up'); ?>">
                            </label>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>
            </form>
        </div>
        <?php
    }

}

if ( ! function_exists('wp_rem_cs_var_social_network') ) {

    function wp_rem_cs_var_social_network($icon_type = '', $tooltip = '') {
        global $wp_rem_cs_var_options;
        $tooltip_data = '';
        if ( $icon_type == 'large' ) {
            $icon = 'icon-2x';
        } else {

            $icon = '';
        }
        if ( isset($tooltip) && $tooltip <> '' ) {
            $tooltip_data = 'data-placement-tooltip="tooltip"';
        }
        if ( isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) and count($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) > 0 ) {
            $i = 0;
            $icon_color = array();
            $icon_color = $wp_rem_cs_var_options['wp_rem_cs_var_social_icon_color'];
            ?>
            <ul>
                <?php
                if ( is_array($wp_rem_cs_var_options['wp_rem_cs_var_social_net_url']) ):
                    foreach ( $wp_rem_cs_var_options['wp_rem_cs_var_social_net_url'] as $val ) {

                        if ( $val != '' ) {
                            ?>      
                            <li>
                                <a style="background :<?php echo $icon_color[$i]; ?> "  href="<?php echo esc_url($val); ?>" data-original-title="<?php echo wp_rem_cs_allow_special_char($wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'][$i]); ?>"  <?php echo balanceTags($tooltip_data, false); ?> >
                                    <?php if ( $wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'][$i] <> '' && isset($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'][$i]) ) { ?>
                                        <i class="<?php echo esc_attr($wp_rem_cs_var_options['wp_rem_cs_var_social_net_awesome'][$i]); ?> <?php echo esc_attr($icon); ?>"></i>

                                    <?php } else { ?>
                                        <img title="<?php echo esc_attr($wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'][$i]); ?>" src="<?php echo esc_url($wp_rem_cs_var_options['wp_rem_cs_var_social_icon_path_array'][$i]); ?>" alt="<?php echo esc_attr($wp_rem_cs_var_options['wp_rem_cs_var_social_net_tooltip'][$i]); ?>" />
                                    <?php } ?>
                                </a>
                            </li>
                            <?php
                        }
                        $i ++;
                    }
                endif;
                ?>
            </ul>
            <?php
        }
    }

}
