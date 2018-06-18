<?php
/**
 * File Type: Enquire Arrange Buttons Page Element
 */
if ( ! class_exists('wp_rem_enquire_arrange_button_element') ) {

    class wp_rem_enquire_arrange_button_element {

        /**
         * Start construct Functions
         */
        public function __construct() {
            add_action('wp_rem_enquire_arrange_buttons_element_html', array( $this, 'wp_rem_enquire_arrange_buttons_element_html_callback' ), 11, 1);
            add_action('wp_ajax_nopriv_wp_rem_send_enquire_arrange_submit', array( $this, 'wp_rem_send_enquire_arrange_submit_callback' ), 11, 1);
            add_action('wp_ajax_wp_rem_send_enquire_arrange_submit', array( $this, 'wp_rem_send_enquire_arrange_submit_callback' ), 11, 1);
            add_action('wp_ajax_nopriv_wp_rem_send_arrange_submit', array( $this, 'wp_rem_send_arrange_submit_callback' ), 11, 1);
            add_action('wp_ajax_wp_rem_send_arrange_submit', array( $this, 'wp_rem_send_arrange_submit_callback' ), 11, 1);
        }

        public function wp_rem_send_enquire_arrange_submit_callback() {
            global $wp_rem_plugin_options;
            // if ( is_user_logged_in() ) {

                $user_name = wp_rem_get_input('user_name', NULL, 'STRING');
                $user_phone = wp_rem_get_input('user_phone', NULL, 'STRING');
                $user_email = wp_rem_get_input('user_email', NULL, 'STRING');
                $send_copy = wp_rem_get_input('send_copy', NULL, 'STRING');
                $user_message = wp_rem_get_input('user_message', NULL, 'STRING');

                $property_user = wp_rem_get_input('wp_rem_property_user', 0);
                $property_member = wp_rem_get_input('wp_rem_property_member', 0);
                $property_id = wp_rem_get_input('wp_rem_property_id', 0);
                $property_type_id = wp_rem_get_input('wp_rem_property_type_id', 0);
                $enquiry_user = wp_rem_get_input('wp_rem_enquiry_user', 0);
                $enquiry_member = wp_rem_get_input('wp_rem_enquiry_member', 0);

                if ( $property_member == $enquiry_member ) {
                    $json['type'] = 'error';
                    $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_own_property_error');
                    echo json_encode($json);
                    exit();
                }

                if ( empty($user_name) ) {
                    $json['type'] = 'error';
                    $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_name_empty');
                    echo json_encode($json);
                    exit();
                }
                
                if ( empty($user_phone) ) {
                    $json['type'] = 'error';
                    $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_phone_empty');
                    echo json_encode($json);
                    exit();
                }

                if ( empty($user_email) ) {
                    $json['type'] = 'error';
                    $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_email_empty');
                    echo json_encode($json);
                    exit();
                }

                if ( empty($user_message) ) {
                    $json['type'] = 'error';
                    $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_msg_empty');
                    echo json_encode($json);
                    exit();
                }

                wp_rem_verify_term_condition_form_field('term_policy');

                $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
                if ( $wp_rem_captcha_switch == 'on' ) {
                    do_action('wp_rem_verify_captcha_form');
                }
                /*
                 * Add inquery in DB logic
                 */

                $enquiry_post = array(
                    'post_title' => wp_strip_all_tags(get_the_title($property_id)),
                    'post_content' => '',
                    'post_status' => 'publish',
                    'post_type' => 'property_enquiries',
                    'post_date' => current_time('Y/m/d H:i:s')
                );
                //insert Enquiry
                $enquiry_id = wp_insert_post($enquiry_post);
                // Update the post into the database
                $my_post = array(
                    'ID' => $order_id,
                    'post_title' => 'enquiry-' . $enquiry_id,
                    'post_name' => 'enquiry-' . $enquiry_id,
                );
                wp_update_post($my_post);

                update_post_meta($enquiry_id, 'wp_rem_user_name', $user_name);
                update_post_meta($enquiry_id, 'wp_rem_phone_number', $user_phone);
                update_post_meta($enquiry_id, 'wp_rem_user_email', $user_email);
                update_post_meta($enquiry_id, 'wp_rem_user_message', $user_message);
                // Save Viewing Property Fields
                update_post_meta($enquiry_id, 'wp_rem_property_user', $property_user);
                update_post_meta($enquiry_id, 'wp_rem_property_member', $property_member);
                update_post_meta($enquiry_id, 'wp_rem_property_id', $property_id);
                update_post_meta($enquiry_id, 'wp_rem_property_type_id', $property_type_id);
                update_post_meta($enquiry_id, 'wp_rem_enquiry_user', $enquiry_user);
                update_post_meta($enquiry_id, 'wp_rem_enquiry_member', $enquiry_member);

                update_post_meta($enquiry_id, 'wp_rem_enquiry_id', $viewing_id);
                update_post_meta($enquiry_id, 'wp_rem_enquiry_status', 'Processing');
                update_post_meta($enquiry_id, 'buyer_read_status', '0');
                update_post_meta($enquiry_id, 'seller_read_status', '0');

                do_action('wp_rem_received_enquiry_email', $_POST);

                $json['type'] = 'success';
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_sent_successfully');
                echo json_encode($json);
                exit();
            // } else {
            //     $json['type'] = 'error';
            //     $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquire_arrange_login');
            //     echo json_encode($json);
            //     exit();
            // }
        }

        public function wp_rem_send_arrange_submit_callback() {
            global $wp_rem_plugin_options;
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';

            $arrange_user_name = wp_rem_get_input('arrange_user_name', NULL, 'STRING');
            $arrange_phone_num = wp_rem_get_input('arrange_phone_num', NULL, 'STRING');
            $arrange_user_email = wp_rem_get_input('arrange_user_email', NULL, 'STRING');
            $arrange_user_message = wp_rem_get_input('arrange_user_message', NULL, 'STRING');
            $arrange_view_date = wp_rem_get_input('arrange_view_date', '');
            $arrange_view_time = wp_rem_get_input('arrange_view_time', '');

            $property_user = wp_rem_get_input('wp_rem_property_user', 0);
            $property_member = wp_rem_get_input('wp_rem_property_member', 0);
            $property_id = wp_rem_get_input('wp_rem_property_id', 0);
            $property_type_id = wp_rem_get_input('wp_rem_property_type_id', 0);
            $viewing_user = wp_rem_get_input('wp_rem_viewing_user', 0);
            $viewing_member = wp_rem_get_input('wp_rem_viewing_member', 0);

            if ( $property_member == $viewing_member ) {
                $json['type'] = 'error';
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_viewing_own_property_error');
                echo json_encode($json);
                exit();
            }

            if ( empty($arrange_user_name) ) {
                $json['type'] = 'error';
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_name_empty');
                echo json_encode($json);
                exit();
            }
            
            if ( empty($arrange_phone_num) ) {
                $json['type'] = 'error';
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_phone_empty');
                echo json_encode($json);
                exit();
            }

            if ( empty($arrange_user_email) ) {
                $json['type'] = 'error';
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_email_empty');
                echo json_encode($json);
                exit();
            }

            if ( empty($arrange_user_message) ) {
                $json['type'] = 'error';
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_viewing_msg_empty');
                echo json_encode($json);
                exit();
            }
            wp_rem_verify_term_condition_form_field('term_policy');

            if ( $wp_rem_captcha_switch == 'on' ) {
                do_action('wp_rem_verify_captcha_form');
            }

            /*
             * Add inquery in DB logic
             */
            $order_inquiry_post = array(
                'post_title' => wp_strip_all_tags(get_the_title($property_id)),
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'property_viewings',
                'post_date' => current_time('Y/m/d H:i:s')
            );
            //insert Arrange Viewing
            $viewing_id = wp_insert_post($order_inquiry_post);
            if ( $viewing_id ) {
                // Update the post into the database
                $my_post = array(
                    'ID' => $viewing_id,
                    'post_title' => 'viewing-' . $viewing_id,
                    'post_name' => 'viewing-' . $viewing_id,
                );
                wp_update_post($my_post);
                // Save Form Fields

                if ( $arrange_view_date != '' ) {
                    update_post_meta($viewing_id, 'wp_rem_arrange_view_date', strtotime($arrange_view_date));
                }
                if ( $arrange_view_time != '' ) {
                    update_post_meta($viewing_id, 'wp_rem_arrange_view_time', strtotime($arrange_view_time));
                }

                update_post_meta($viewing_id, 'wp_rem_user_name', $arrange_user_name);
                update_post_meta($viewing_id, 'wp_rem_phone_number', $arrange_phone_num);
                update_post_meta($viewing_id, 'wp_rem_user_email', $arrange_user_email);
                update_post_meta($viewing_id, 'wp_rem_user_message', $arrange_user_message);
                // Save Viewing Property Fields
                update_post_meta($viewing_id, 'wp_rem_property_user', $property_user);
                update_post_meta($viewing_id, 'wp_rem_property_member', $property_member);
                update_post_meta($viewing_id, 'wp_rem_property_id', $property_id);
                update_post_meta($viewing_id, 'wp_rem_property_type_id', $property_type_id);
                update_post_meta($viewing_id, 'wp_rem_viewing_user', $viewing_user);
                update_post_meta($viewing_id, 'wp_rem_viewing_member', $viewing_member);

                update_post_meta($viewing_id, 'wp_rem_viewing_id', $viewing_id);
                update_post_meta($viewing_id, 'wp_rem_viewing_status', 'Processing');
                update_post_meta($viewing_id, 'buyer_read_status', '0');
                update_post_meta($viewing_id, 'seller_read_status', '0');

                do_action('wp_rem_received_arrange_viewing_email', $_POST);  // email templete
                $json['type'] = 'success';
                $json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquire_arrange_message_sent_successfully');
                echo json_encode($json);
                exit();
            }
        }

        public function wp_rem_enquire_arrange_buttons_element_html_callback($property_id) {
            ?>
            <div class="enquire-holder">

                <?php
				$target_modal = '';
				$target_arrange_modal = '';
                $target_class = ' wp-rem-open-signin-tab';
                // if ( is_user_logged_in() ) {
                    $target_class = '';
					$target_modal = ' data-toggle="modal" data-target="#enquiry-modal"';
					$target_arrange_modal = ' data-toggle="modal" data-target="#arrange-modal"';
                // }
                ?>
                <a class="enquire-btn<?php echo esc_attr($target_class); ?>" href="javascript:void(0);"<?php echo ($target_modal); ?>><i class="icon- icon-calendar-check-o"></i><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_enquiry_now'); ?></a>

                <a class="bgcolor enquire-btn<?php echo esc_attr($target_class); ?>" href="javascript:void(0);"<?php echo ($target_arrange_modal); ?>><i class="icon- icon-calendar-check-o"></i><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_arrange_viewing'); ?></a>
            </div>
            <?php
            $this->wp_rem_popupbox_enquire_now($property_id, wp_rem_plugin_text_srt('wp_rem_enquire_arrange_enquiry_now'), 'enquiry');
            $this->wp_rem_popupbox_arrange_view($property_id, wp_rem_plugin_text_srt('wp_rem_enquire_arrange_arrange_viewing'), 'arrange');

            $wp_rem_cs_inline_script = '
            jQuery(document).ready(function () {
                jQuery(document).on("click", ".property-detail .enquire-holder .enquire-btn", function() {
                    "use strict";
                    jQuery("#enquiry-modal").find("form")[0].reset();
                    jQuery("#arrange-modal").find("form")[0].reset();
                    jQuery("#enquiry-modal .response-message").html("");
                    jQuery("#arrange-modal .response-message").html("");
                });
            });';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
        }

        public function wp_rem_popupbox_enquire_now($property_id = '', $heading = '', $type = '') {
            global $wp_rem_plugin_options, $Wp_rem_Captcha, $wp_rem_form_fields_frontend;
            $wp_rem_captcha_switch = '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
            $wp_rem_property_counter = rand(12345, 54321);
            $wp_rem_property_member_id = get_post_meta($property_id, 'wp_rem_property_member', true);
            $property_member = wp_rem_user_id_form_company_id($wp_rem_property_member_id);
            $wp_rem_member_email_address = get_post_meta($wp_rem_property_member_id, 'wp_rem_email_address', true);
            $property_type_slug = get_post_meta($property_id, 'wp_rem_property_type', true);
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => $property_type_slug, 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $user_id = $company_id = 0;
            $user_id = get_current_user_id();
            $display_name = '';
            $phone_number = '';
            $email_address = '';
            if ( $user_id != 0 ) {
                $company_id = get_user_meta($user_id, 'wp_rem_company', true);
                $user_data = get_userdata($user_id);
                $display_name = isset($user_data->display_name) ? $user_data->display_name : '';
                $phone_number = get_post_meta($company_id, 'wp_rem_phone_number', true);
                $email_address = get_post_meta($company_id, 'wp_rem_email_address', true);
            }
            ?>
            <!-- Modal -->
            <div class="modal modal-form fade" id="enquiry-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="enquiry-myModalLabel"><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_request_inquiry'); ?></h4>
                        </div>
                        <div class="modal-body profile-info">
                            <form id="frm_property<?php echo absint($wp_rem_property_counter); ?>" class="enquiry-request-form" name="form_name" action="javascript:wp_rem_enquire_arrange_send_message('<?php echo absint($wp_rem_property_counter); ?>');" method="get">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-holder">
                                            <i class="icon-user2"></i>
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'std' => esc_html($display_name),
                                                'cust_name' => 'user_name',
                                                'return' => false,
                                                'classes' => 'input-field',
                                                'extra_atr' => 'placeholder="Full Name"',
                                                // 'extra_atr' => ' readonly="readonly"',
                                            );
                                            $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-holder">
                                            <i class="icon-phone4"></i>
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'std' => esc_html($phone_number),
                                                'cust_name' => 'user_phone',
                                                'return' => false,
                                                'classes' => 'input-field',
                                                'extra_atr' => 'placeholder="Telephone Number"',
                                                // 'extra_atr' => ' readonly="readonly"',
                                            );
                                            $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-holder">
                                            <i class="icon-mail"></i>
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'std' => esc_html($email_address),
                                                'cust_name' => 'user_email',
                                                'return' => false,
                                                'classes' => 'input-field',
                                                'extra_atr' => 'placeholder="Email"',
                                                // 'extra_atr' => ' readonly="readonly"',
                                            );
                                            $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-holder">
                                            <i class="icon-message"></i>
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'std' => '',
                                                'id' => 'user_message',
                                                'cust_name' => 'user_message',
                                                'classes' => 'textarea-field',
                                                'description' => '',
                                                'return' => false,
                                                'name' => wp_rem_plugin_text_srt('wp_rem_author_info_sender_message'),
                                            );
                                            $wp_rem_form_fields_frontend->wp_rem_form_textarea_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                    if ( $wp_rem_captcha_switch == 'on' ) {
                                        if ( $wp_rem_sitekey <> '' and $wp_rem_secretkey <> '' ) {
                                            wp_rem_google_recaptcha_scripts();
                                            ?>
                                            <script>
                                                var recaptcha_enquery;
                                                var wp_rem_multicap = function () {
                                                    //Render the recaptcha1 on the element with ID "recaptcha1"
                                                    recaptcha_enquery = grecaptcha.render('recaptcha_enquery', {
                                                        'sitekey': '<?php echo ($wp_rem_sitekey); ?>', //Replace this with your Site key
                                                        'theme': 'light'
                                                    });

                                                };
                                            </script>
                                            <?php
                                        }
                                        if ( class_exists('Wp_rem_Captcha') ) {
                                            $output = '<div class="col-md-12 recaptcha-reload" id="recaptcha_enquery_div">';
                                            $output .= $Wp_rem_Captcha->wp_rem_generate_captcha_form_callback('recaptcha_enquery', 'true');
                                            $output .='</div>';
                                            echo force_balance_tags($output);
                                        }
                                    }
                                    ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-holder"> 
                                            <div class="check-box-remind">
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'simple' => true,
                                                    'cust_id' => 'inquiry-send-email',
                                                    'cust_name' => 'send_copy',
                                                    'std' => '',
                                                    'classes' => 'input-field',
                                                );
                                                $wp_rem_form_fields_frontend->wp_rem_form_checkbox_render($wp_rem_opt_array);
                                                ?>
                                                <label for="inquiry-send-email"><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_send_copy'); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-holder enquiry-request-holder input-button-loader">
                                            <?php
                                            $wp_rem_opt_array = array(
                                                'std' => wp_rem_plugin_text_srt('wp_rem_contact_send_message'),
                                                'cust_name' => 'message_submit',
                                                'return' => false,
                                                'classes' => 'bgcolor',
                                                'cust_type' => 'submit',
                                                'force_std' => true,
                                            );
                                            $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-holder">
                                            <?php wp_rem_term_condition_form_field('term_policy', 'term_policy'); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $wp_rem_opt_array = array(
                                    'std' => intval($property_member),
                                    'id' => 'property_user',
                                    'return' => false,
                                    'force_std' => true,
                                );
                                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'std' => intval($wp_rem_property_member_id),
                                    'id' => 'property_member',
                                    'return' => false,
                                    'force_std' => true,
                                );
                                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'std' => intval($property_id),
                                    'id' => 'property_id',
                                    'return' => false,
                                    'force_std' => true,
                                );
                                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'std' => intval($property_type_id),
                                    'id' => 'property_type_id',
                                    'return' => false,
                                    'force_std' => true,
                                );
                                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'std' => intval($user_id),
                                    'id' => 'enquiry_user',
                                    'return' => false,
                                    'force_std' => true,
                                );
                                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                $wp_rem_opt_array = array(
                                    'std' => intval($company_id),
                                    'id' => 'enquiry_member',
                                    'return' => false,
                                    'force_std' => true,
                                );
                                $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);
                                ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $wp_rem_cs_inline_script = '
			function wp_rem_enquire_arrange_send_message(form_id, type) {
				"use strict";
				var thisObj = jQuery(".enquiry-request-holder");
				wp_rem_show_loader(".enquiry-request-holder", "", "button_loader", thisObj);
				var datastring = jQuery("#frm_property" + form_id + "").serialize() + "&action=wp_rem_send_enquire_arrange_submit";
				jQuery.ajax({
					type: "POST",
					url: wp_rem_globals.ajax_url,
					data: datastring,
					dataType: "json",
					success: function(response) {
						wp_rem_show_response(response, ".enquiry-request-form", thisObj);
						if (response.type == "success") {
							jQuery("#frm_property" + form_id + "").trigger("reset");
						}
					}
				});
			}';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
        }

        public function wp_rem_popupbox_arrange_view($property_id = '', $heading = '', $type = '') {
            global $wp_rem_plugin_options, $Wp_rem_Captcha, $Wp_rem_Captcha, $wp_rem_form_fields, $wp_rem_form_fields_frontend;

            $wp_rem_captcha_switch = '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';

            $wp_rem_property_counter = rand(12345, 54321);
            $wp_rem_property_member_id = get_post_meta($property_id, 'wp_rem_property_member', true);
            $property_member = wp_rem_user_id_form_company_id($wp_rem_property_member_id);
            $property_type_slug = get_post_meta($property_id, 'wp_rem_property_type', true);
            $property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => $property_type_slug, 'post_status' => 'publish' ));
            $property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
            $user_id = $company_id = 0;
            $user_id = get_current_user_id();
            $display_name = '';
            $phone_number = '';
            $email_address = '';
            if ( $user_id != 0 ) {
                $company_id = get_user_meta($user_id, 'wp_rem_company', true);
                $user_data = get_userdata($user_id);
                $display_name = isset($user_data->display_name) ? $user_data->display_name : '';
                $phone_number = get_post_meta($company_id, 'wp_rem_phone_number', true);
                $email_address = get_post_meta($company_id, 'wp_rem_email_address', true);
            }


            $wp_rem_property_member_id = get_post_meta($property_id, 'wp_rem_property_member', true);
            $wp_rem_member_email_address = get_post_meta($wp_rem_property_member_id, 'wp_rem_email_address', true);
            $book_off_days = get_post_meta($wp_rem_property_member_id, 'wp_rem_calendar', true);
            $book_off_days = ( ! empty($book_off_days) ) ? $book_off_days : array();
            if ( isset($book_off_days) && ! empty($book_off_days) ) {
                $book_off_days = implode(',', $book_off_days);
            }
            wp_enqueue_style('wp_rem_datepicker_css');
            wp_enqueue_script('jquery-ui');
            if ( empty($book_off_days) ) {
                $book_off_days = '';
            }
            ?>
            <div class="modal modal-form fade" id="arrange-modal" tabindex="-1" role="dialog" aria-labelledby="arrange-myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="arrange-myModalLabel"><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_arrange_viewing'); ?></h4>
                        </div>
                        <div class="modal-body profile-info">
                            <div class="booking-info-sec">
                                <form id="frm_arrange<?php echo absint($wp_rem_property_counter); ?>" class="viewing-request-form" name="form_arrange_view" action="javascript:wp_rem_arrange_view_send_message('<?php echo absint($wp_rem_property_counter); ?>');" method="get">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <label class="time-label"><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_viewing_times'); ?> <span><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_viewing_times_optional'); ?></span></label>
                                                <div class="date-sec">
                                                    <i class="icon-keyboard_arrow_down"> </i>
                                                    <?php
                                                    $wp_rem_form_fields_frontend->wp_rem_form_text_render(
                                                            array(
                                                                'cust_name' => 'arrange_view_date',
                                                                'cust_id' => 'date-of-booking',
                                                                'classes' => 'form-control booking-date wp-rem-required-field',
                                                                'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_enquire_arrange_viewing_schedule') . '"',
                                                                'std' => '',
                                                            )
                                                    );
                                                    ?>  
                                                    <div id="datepicker_1468" class="reservaion-calendar hasDatepicker"></div>
                                                    <script type="text/javascript">
                                                        jQuery(document).ready(function () {
                                                            var off_days_array = '<?php echo wp_rem_allow_special_char($book_off_days); ?>';
                                                            off_days_array = off_days_array.split(',');
                                                            jQuery("#date-of-booking").datepicker({
                                                                showOtherMonths: true,
                                                                firstDay: 1,
                                                                minDate: 0,
                                                                dateFormat: "dd-mm-yy",
                                                                prevText: "",
                                                                nextText: "",
                                                                monthNames: [
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_jan'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_feb'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_mar'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_apr'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_may'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_jun'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_jul'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_aug'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_sep'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_oct'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_nov'); ?>",
                                                                    "<?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_calendar_month_dec'); ?>"
                                                                ],
                                                                beforeShowDay: function (date) {
                                                                    var string = jQuery.datepicker.formatDate('yy-m-dd', date);
                                                                    return [off_days_array.indexOf(string) == -1];
                                                                }
                                                            });
                                                            jQuery(".chosen-select-no-single").chosen();
                                                        });
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <?php
                                                $time_lapse = 15;
                                                $time_list = $this->property_time_list($time_lapse);
                                                if ( is_array($time_list) && sizeof($time_list) > 0 ) {
                                                    foreach ( $time_list as $time_key => $time_val ) {
                                                        $drop_down_options[$time_key] = esc_html($time_val);
                                                    }
                                                }
                                                if ( ! empty($drop_down_options) ) {
                                                    $wp_rem_opt_array = array();
                                                    $wp_rem_opt_array['std'] = '';
                                                    $wp_rem_opt_array['cust_id'] = 'arrange_view_time';
                                                    $wp_rem_opt_array['cust_name'] = 'arrange_view_time';
                                                    $wp_rem_opt_array['options'] = $drop_down_options;
                                                    $wp_rem_opt_array['classes'] = 'chosen-select-no-single my_select_box';
                                                    $wp_rem_opt_array['return'] = true;
                                                    echo wp_rem_allow_special_char($wp_rem_form_fields_frontend->wp_rem_form_select_render($wp_rem_opt_array));
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <i class="icon-user2"></i>
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => esc_html($display_name),
                                                    'cust_name' => 'arrange_user_name',
                                                    'return' => false,
                                                    'classes' => 'input-field',
                                                    'extra_atr' => 'placeholder="Full Name"',
                                                    // 'extra_atr' => ' readonly="readonly" ',
                                                );
                                                $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <i class="icon-phone4"></i>
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => esc_html($phone_number),
                                                    'cust_name' => 'arrange_phone_num',
                                                    'return' => false,
                                                    'classes' => 'input-field',
                                                    'extra_atr' => 'placeholder="Telephone Number"',
                                                        //'extra_atr' => ' readonly="readonly" ',
                                                );
                                                $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <i class="icon-mail"></i>
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => esc_html($email_address),
                                                    'cust_name' => 'arrange_user_email',
                                                    'return' => false,
                                                    'classes' => 'input-field',
                                                    'extra_atr' => 'placeholder="Email"',
                                                    // 'extra_atr' => ' readonly="readonly" ',
                                                );
                                                $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>

                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <i class="icon-message"></i>
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => '',
                                                    'id' => 'arrange_user_message',
                                                    'cust_name' => 'arrange_user_message',
                                                    'classes' => 'textarea-field',
                                                    'description' => '',
                                                    'return' => false,
                                                    'name' => wp_rem_plugin_text_srt('wp_rem_enquire_arrange_viewing_message'),
                                                );
                                                $wp_rem_form_fields_frontend->wp_rem_form_textarea_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                        if ( $wp_rem_captcha_switch == 'on' ) {
                                            if ( $wp_rem_sitekey <> '' and $wp_rem_secretkey <> '' ) {
                                                wp_rem_google_recaptcha_scripts();
                                                ?>
                                                <script>
                                                    var recaptcha_arrange_view;
                                                    var wp_rem_multicap = function () {
                                                        //Render the recaptcha1 on the element with ID "recaptcha1"
                                                        recaptcha_arrange_view = grecaptcha.render('recaptcha_arrange_view', {
                                                            'sitekey': '<?php echo ($wp_rem_sitekey); ?>', //Replace this with your Site key
                                                            'theme': 'light'
                                                        });

                                                    };
                                                </script>
                                                <?php
                                            }
                                            if ( class_exists('Wp_rem_Captcha') ) {
                                                $output = '<div class="col-md-12 recaptcha-reload" id="recaptcha_arrange_view_div">';
                                                $output .= $Wp_rem_Captcha->wp_rem_generate_captcha_form_callback('recaptcha_arrange_view', 'true');
                                                $output .='</div>';
                                                echo force_balance_tags($output);
                                            }
                                        }
                                        ?>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder viewing-request-holder input-button-loader">
                                                <?php
                                                $wp_rem_opt_array = array(
                                                    'std' => wp_rem_plugin_text_srt('wp_rem_contact_send_message'),
                                                    'cust_name' => 'submit_message_arrange',
                                                    'return' => false,
                                                    'classes' => 'bgcolor',
                                                    'cust_type' => 'submit',
                                                    'force_std' => true,
                                                );
                                                $wp_rem_form_fields_frontend->wp_rem_form_text_render($wp_rem_opt_array);
                                                ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="field-holder">
                                                <div class="check-box-remind">
                                                    <?php wp_rem_term_condition_form_field('arrange_viewing_term_policy', 'term_policy'); ?>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <?php
                                    $wp_rem_opt_array = array(
                                        'std' => intval($property_member),
                                        'id' => 'property_user',
                                        'return' => false,
                                        'force_std' => true,
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                    $wp_rem_opt_array = array(
                                        'std' => intval($wp_rem_property_member_id),
                                        'id' => 'property_member',
                                        'return' => false,
                                        'force_std' => true,
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                    $wp_rem_opt_array = array(
                                        'std' => intval($property_id),
                                        'id' => 'property_id',
                                        'return' => false,
                                        'force_std' => true,
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                    $wp_rem_opt_array = array(
                                        'std' => intval($property_type_id),
                                        'id' => 'property_type_id',
                                        'return' => false,
                                        'force_std' => true,
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                    $wp_rem_opt_array = array(
                                        'std' => intval($user_id),
                                        'id' => 'viewing_user',
                                        'return' => false,
                                        'force_std' => true,
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);

                                    $wp_rem_opt_array = array(
                                        'std' => intval($company_id),
                                        'id' => 'viewing_member',
                                        'return' => false,
                                        'force_std' => true,
                                    );
                                    $wp_rem_form_fields_frontend->wp_rem_form_hidden_render($wp_rem_opt_array);
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $wp_rem_cs_inline_script = '
			function wp_rem_arrange_view_send_message(form_id, type) {
				"use strict";
				var thisObj = jQuery(".viewing-request-holder");
				wp_rem_show_loader(".viewing-request-holder", "", "button_loader", thisObj);
				var datastring = jQuery("#frm_arrange" + form_id + "").serialize() + "&action=wp_rem_send_arrange_submit";
				jQuery.ajax({
					type: "POST",
					url: wp_rem_globals.ajax_url,
					data: datastring,
					dataType: "json",
					success: function(response) {
						wp_rem_show_response(response, ".viewing-request-form", thisObj);
						if (response.type == "success") {
							jQuery("#frm_arrange" + form_id + "").trigger("reset");
						}
					}
				});
			}
            jQuery(document).ready(function () {
                

				jQuery(".booking-date").focus(function() {
					$(".booking-info-sec .reservaion-calendar.hasDatepicker").show();
					$(document).mouseup(function(e) {
						var container = $(".booking-info-sec .reservaion-calendar.hasDatepicker");
						if (!container.is(e.target) && container.has(e.target).length === 0 && !$(".booking-date").is(e.target)){
							container.hide();
						}
					});

					$(".booking-info-sec .reservaion-calendar.hasDatepicker .undefined").click(function() {
						"use strict";
						if ($(this).hasClass("ui-state-disabled") == false) {
							$(".booking-info-sec .reservaion-calendar.hasDatepicker").hide();
						}
					});
				});

            });';
            wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');
        }

        public function property_time_list($lapse = 15) {
            $hours = array();
            $start = '12:00AM';
            $end = '11:59PM';
            $interval = '+' . $lapse . ' minutes';

            $start_str = strtotime($start);
            $end_str = strtotime($end);
            $now_str = $start_str;
            while ( $now_str <= $end_str ) {
                $hours[date('h:i a', $now_str)] = date('h:i A', $now_str);
                $now_str = strtotime($interval, $now_str);
            }
            return $hours;
        }

    }

    global $wp_rem_enquire_arrange_button;
    $wp_rem_enquire_arrange_button = new wp_rem_enquire_arrange_button_element();
}