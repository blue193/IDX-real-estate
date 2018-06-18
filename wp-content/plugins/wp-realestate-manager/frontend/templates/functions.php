<?php
/**

 * Start Function how to Remove Extra Variables using Query String

 */
if ( ! function_exists('cs_remove_qrystr_extra_var') ) {

    function cs_remove_qrystr_extra_var($qStr, $key, $withqury_start = 'yes') {

        if ( ! (strpos($qr_str, '?') !== false) ) {

            $qr_str = "?" . $qr_str;
        }

        $qr_str = str_replace("?&", "?", $qr_str);

        $qr_str = remove_dupplicate_var_val($qr_str);



        if ( $withqury_start == 'no' ) {

            $qr_str = str_replace("?", "", $qr_str);
        }

        return $qr_str;

        die();
    }

}

if ( ! function_exists('property_checks_enquire_lists_submit') ) {

    add_action('property_checks_enquire_lists_submit', 'property_checks_enquire_lists_submit', 10);

    function property_checks_enquire_lists_submit($id, $args = array()) {
        global $current_user, $wp_rem_plugin_options, $Wp_rem_Captcha, $wp_rem_form_fields_frontend;
        extract($args);

		$html = '';
		if ( is_user_logged_in() ) {
			
			$html .= '
			<div id="prop-enquiry-pop-list-box" class="enquiry-submit-btn-box" style="display: none;">
			<input type="hidden" id="prop-enquiry-list-all">
			<a href="javascript:void(0)" class="prop-enquiry-pop-list-btn" data-target="#sprop-enquiry-popbox-list" data-toggle="modal">Send Enquiry</a>';
			
			ob_start();
            $wp_rem_captcha_switch = '';
            $wp_rem_captcha_switch = isset($wp_rem_plugin_options['wp_rem_captcha_switch']) ? $wp_rem_plugin_options['wp_rem_captcha_switch'] : '';
            $wp_rem_sitekey = isset($wp_rem_plugin_options['wp_rem_sitekey']) ? $wp_rem_plugin_options['wp_rem_sitekey'] : '';
            $wp_rem_secretkey = isset($wp_rem_plugin_options['wp_rem_secretkey']) ? $wp_rem_plugin_options['wp_rem_secretkey'] : '';
            $wp_rem_property_counter = rand(1234500, 99954321);
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
            <div class="modal modal-form fade" id="sprop-enquiry-popbox-list" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="enquiry-myModalLabel"><?php echo wp_rem_plugin_text_srt('wp_rem_enquire_arrange_request_inquiry'); ?></h4>
                        </div>
                        <div class="modal-body profile-info">
                            <form id="frm_property<?php echo absint($wp_rem_property_counter); ?>" class="enquiry-request-form" name="form_name" action="javascript:wp_rem_enquire_list_send_message('<?php echo absint($wp_rem_property_counter); ?>');" method="get">
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
                                                'extra_atr' => ' readonly="readonly"',
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
                                                'extra_atr' => ' readonly="readonly"',
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
                                                'extra_atr' => ' readonly="readonly"',
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
                                    'std' => '',
                                    'id' => 'property_id',
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
			function wp_rem_enquire_list_send_message(form_id) {
				"use strict";
				var thisObj = jQuery(".enquiry-request-holder");
				wp_rem_show_loader(".enquiry-request-holder", "", "button_loader", thisObj);
				var datastring = jQuery("#frm_property" + form_id).serialize() + "&action=wp_rem_send_enquire_listing_submit";
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
			$html .= ob_get_clean();
			
			$html .= '</div>';
		}

        echo force_balance_tags($html);
    }

}

if ( ! function_exists('wp_rem_send_enquire_listing_submit_callback') ) {
	function wp_rem_send_enquire_listing_submit_callback() {
		global $wp_rem_plugin_options;
		// if ( is_user_logged_in() ) {

			$user_name = wp_rem_get_input('user_name', NULL, 'STRING');
			$user_phone = wp_rem_get_input('user_phone', NULL, 'STRING');
			$user_email = wp_rem_get_input('user_email', NULL, 'STRING');
			$user_message = wp_rem_get_input('user_message', NULL, 'STRING');
			
			$enquiry_user = wp_rem_get_input('wp_rem_enquiry_user', 0);
			$enquiry_member = wp_rem_get_input('wp_rem_enquiry_member', 0);
				
			$property_ids = isset($_POST['wp_rem_property_id']) ? $_POST['wp_rem_property_id'] : '';
			
			if ($property_ids != '') {
				
				$property_ids = explode(',', $property_ids);

				foreach($property_ids as $property_id) {
					
					$property_member = get_post_meta($property_id, 'wp_rem_property_member', true);
					$property_user = wp_rem_user_id_form_company_id($property_member);
					$property_type_slug = get_post_meta($property_id, 'wp_rem_property_type', true);
					$property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => $property_type_slug, 'post_status' => 'publish' ));
					$property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
					

					if ( $property_member == $enquiry_member ) {
						$json['type'] = 'error';
						$json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_own_property_error');
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

					//do_action('wp_rem_received_enquiry_email', $_POST);
				}
				
				$json['type'] = 'success';
				$json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquiry_sent_successfully');
				echo json_encode($json);
				exit();
			}
		// } else {
		// 	$json['type'] = 'error';
		// 	$json['msg'] = wp_rem_plugin_text_srt('wp_rem_enquire_arrange_login');
		// 	echo json_encode($json);
		// 	exit();
		// }
	}
	
	add_action('wp_ajax_nopriv_wp_rem_send_enquire_listing_submit', 'wp_rem_send_enquire_listing_submit_callback');
    add_action('wp_ajax_wp_rem_send_enquire_listing_submit', 'wp_rem_send_enquire_listing_submit_callback');
}

if ( ! function_exists('wp_rem_enquiry_check_frontend') ) {

    add_action('wp_rem_enquiry_check_frontend_button', 'wp_rem_enquiry_check_frontend', 10, 2);

    function wp_rem_enquiry_check_frontend($id, $args = array()) {
        global $current_user;
        extract($args);

		$html = '';
		if ( is_user_logged_in() ) {
			
			$html .= '
			<div class="enquiry-list-btn">
				<input type="checkbox" id="prop-enquiry-list-btn-' . $id . '" data-id="' . $id . '" class="property-enquiry-check dev-property-list-enquiry-check"> <label for="prop-enquiry-list-btn-' . $id . '">' . $enquiry_label . '</label>
			</div>';
		}

        echo force_balance_tags($html);
    }

}

if ( ! function_exists('wp_rem_adding_property_notes') ) {

    add_action('wp_ajax_wp_rem_adding_property_notes', 'wp_rem_adding_property_notes');
    add_action('wp_ajax_nopriv_wp_rem_adding_property_notes', 'wp_rem_adding_property_notes');

    function wp_rem_adding_property_notes() {
        global $current_user;
        $prop_id = isset($_POST['prop_id']) ? $_POST['prop_id'] : '';
        $prop_notes = isset($_POST['prop_notes']) ? $_POST['prop_notes'] : '';

        if ( strlen($prop_notes) > 499 ) {
            echo json_encode(array( 'type' => 'error', 'msg' => wp_rem_plugin_text_srt('wp_rem_prop_notes_no_500_words_allow') ));
            die;
        }

        $company_id = wp_rem_company_id_form_user_id($current_user->ID);

        $property_notes = get_post_meta($company_id, 'property_notes', true);

        $notes_to_save = array(
            'property_id' => $prop_id,
            'notes' => $prop_notes,
        );

        $property_notes[$prop_id] = $notes_to_save;

        update_post_meta($company_id, 'property_notes', $property_notes);

        echo json_encode(array( 'type' => 'success', 'msg' => wp_rem_plugin_text_srt('wp_rem_prop_notes_saved_msg') ));
        die;
    }

}

if ( ! function_exists('wp_rem_notes_frontend_button') ) {

    add_action('wp_rem_notes_frontend_button', 'wp_rem_notes_frontend_button', 10, 2);

    function wp_rem_notes_frontend_button($id, $args = array()) {
        global $wp_rem_form_fields, $current_user;
        extract($args);

        $notes_added = false;
        if ( is_user_logged_in() ) {
            $company_id = wp_rem_company_id_form_user_id($current_user->ID);
            $property_notes = get_post_meta($company_id, 'property_notes', true);
            if ( is_array($property_notes) && ! empty($property_notes) ) {
                if ( array_key_exists($id, $property_notes) ) {
                    $notes_added = true;
                }
            }
        }

		if ( is_user_logged_in() ) {
			if ( true === $notes_added ) {
				$html = '
				<div class="notes-btn">
					<a id="property-note-' . $id . '" data-id="' . $id . '" data-aftericon="' . $after_icon . '" data-afterlabel="' . $after_label . '" class="property-notes">' . $after_label . ' <i class="' . $after_icon . '"></i></a>
				</div>';
			} else {
				$html = '
				<div class="notes-btn">
					<a id="property-note-' . $id . '" data-id="' . $id . '" data-aftericon="' . $after_icon . '" data-afterlabel="' . $after_label . '" href="javascript:void(0);" class="property-notes" data-toggle="modal" data-target="#prop-notes-' . $id . '">' . $before_label . ' <i class="' . $before_icon . '"></i></a>
				</div>

				<div id="prop-notes-' . $id . '" class="modal fade property-notes-modal" role="dialog">
					<div class="modal-dialog">
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title">' . sprintf(wp_rem_plugin_text_srt('wp_rem_prop_notes_add_notes_for'), wp_trim_words(get_the_title($id), 4, '...')) . '"</h4>
						</div>
						<div class="modal-body">';
				$html .= '';
				$wp_rem_opt_array = array(
					'std' => '',
					'classes' => '',
					'cust_id' => 'prop-notes-text-' . absint($id),
					'cust_name' => 'prop-notes-text',
					'extra_atr' => 'placeholder="' . wp_rem_plugin_text_srt('wp_rem_prop_notes_type_here') . '"',
					'return' => true,
				);
				$html .= $wp_rem_form_fields->wp_rem_form_textarea_render($wp_rem_opt_array);
				$html .= wp_rem_plugin_text_srt('wp_rem_prop_notes_max_chars_allowed');
				$html .= '
						</div>
						<div class="modal-footer">
						  <div class="submit-prop-notes-btn">
							<button data-id="' . $id . '" type="button" class="submit-prop-notes btn bgcolor">' . wp_rem_plugin_text_srt('wp_rem_prop_notes_submit') . '</button>
						  </div>
						</div>
					  </div>
					</div>
				</div>';
			}
		} else {
			$html = '
			<div class="notes-btn">
				<a id="property-note-' . $id . '" href="javascript:void(0);" class="property-notes dev-prop-notes-login">' . $before_label . ' <i class="' . $before_icon . '"></i></a>
			</div>';
		}

        echo force_balance_tags($html);
    }

}


/**

 * Start Function how to remove Dupplicate variable value

 */
if ( ! function_exists('remove_dupplicate_var_val') ) {



    function remove_dupplicate_var_val($qry_str) {

        $old_string = $qry_str;

        $qStr = str_replace("?", "", $qry_str);

        $query = explode('&', $qStr);

        $params = array();

        if ( isset($query) && ! empty($query) ) {

            foreach ( $query as $param ) {

                if ( ! empty($param) ) {

                    $param_array = explode('=', $param);

                    $name = isset($param_array[0]) ? $param_array[0] : '';

                    $value = isset($param_array[1]) ? $param_array[1] : '';

                    $new_str = $name . "=" . $value;

                    // count matches

                    $count_str = substr_count($old_string, $new_str);

                    $count_str = $count_str - 1;

                    if ( $count_str > 0 ) {

                        $old_string = cs_str_replace_limit($new_str, "", $old_string, $count_str);
                    }

                    $old_string = str_replace("&&", "&", $old_string);
                }
            }
        }

        $old_string = str_replace("?&", "?", $old_string);

        return $old_string;
    }

}


/**

 *

 * @str replace limit

 *

 */
if ( ! function_exists('cs_str_replace_limit') ) {



    function cs_str_replace_limit($search, $replace, $string, $limit = 1) {
        if ( is_bool($pos = (strpos($string, $search))) )
            return $string;

        $search_len = strlen($search);

        for ( $i = 0; $i < $limit; $i ++ ) {

            $string = substr_replace($string, $replace, $pos, $search_len);



            if ( is_bool($pos = (strpos($string, $search))) )
                break;
        }

        return $string;
    }

}


if ( ! function_exists('wp_rem_frontend_icomoon_selector') ) {

    function wp_rem_frontend_icomoon_selector($icon_value = '', $id = '', $name = '', $classes = '') {

        global $wp_rem_form_fields;
        $wp_rem_var_icomoon = '
        <script>
            jQuery(document).ready(function ($) {
                var this_icons;
                var e9_element = $(\'#e9_element_' . esc_html($id) . '\').fontIconPicker({
                    theme: \'fip-bootstrap\'
                });
                icons_load_call.always(function () {
                    this_icons = loaded_icons;
                    // Get the class prefix
                    var classPrefix = this_icons.preferences.fontPref.prefix,
                            icomoon_json_icons = [],
                            icomoon_json_search = [];
                    $.each(this_icons.icons, function (i, v) {
                            icomoon_json_icons.push(classPrefix + v.properties.name);
                            if (v.icon && v.icon.tags && v.icon.tags.length) {
                                    icomoon_json_search.push(v.properties.name + \' \' + v.icon.tags.join(\' \'));
                            } else {
                                    icomoon_json_search.push(v.properties.name);
                            }
                    });
                    // Set new fonts on fontIconPicker
                    e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
                    // Show success message and disable
                    $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-success\').text(\'' . wp_rem_plugin_text_srt('wp_rem_func_loaded_icons') . '\').prop(\'disabled\', true);
                })
                .fail(function () {
                    // Show error message and enable
                    $(\'#e9_buttons_' . esc_html($id) . ' button\').removeClass(\'btn-primary\').addClass(\'btn-danger\').text(\'' . wp_rem_plugin_text_srt('wp_rem_func_try_again') . '\').prop(\'disabled\', false);
                });
            });
        </script>';
        $wp_rem_opt_array = array(
            'std' => esc_html($icon_value),
            'classes' => $classes,
            'cust_id' => 'e9_element_' . esc_html($id),
            'cust_name' => esc_html($name) . '[]',
            'return' => true,
        );
        $wp_rem_var_icomoon .= $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
        $wp_rem_var_icomoon .= '
        <span id="e9_buttons_' . esc_html($id) . '" style="display:none">
            <button data-autocomplete="off" type="button" class="btn btn-primary">' . wp_rem_plugin_text_srt('wp_rem_func_load_from_icomoon') . '</button>
        </span>';

        return $wp_rem_var_icomoon;
    }

}

if ( ! function_exists('wp_rem_front_change_password') ) {

    function wp_rem_front_change_password() {
        global $current_user;
        $user = get_user_by('login', $current_user->user_login);
        $old_pass = isset($_POST['old_pass']) ? $_POST['old_pass'] : '';
        $new_pass = isset($_POST['new_pass']) ? $_POST['new_pass'] : '';
        $confirm_pass = isset($_POST['confirm_pass']) ? $_POST['confirm_pass'] : '';

        if ( ! is_user_logged_in() ) {
            echo wp_rem_plugin_text_srt('wp_rem_functions_php_login_again');
            die;
        }

        if ( $old_pass == '' || $new_pass == '' || $confirm_pass == '' ) {
            echo wp_rem_plugin_text_srt('wp_rem_functions_php_pass_field_empty');
            die;
        }
        if ( $user && wp_check_password($old_pass, $user->data->user_pass, $user->ID) ) {

            if ( $new_pass !== $confirm_pass ) {
                echo wp_rem_plugin_text_srt('wp_rem_functions_php_mismatch_pass_field');
                die;
            } else {
                wp_set_password($new_pass, $user->ID);
                echo wp_rem_plugin_text_srt('wp_rem_functions_php_password_changed');
                die;
            }
        } else {
            echo wp_rem_plugin_text_srt('wp_rem_functions_php_old_pass_incorrect');
            die;
        }
        echo wp_rem_plugin_text_srt('wp_rem_functions_php_password_incorrect');
        die;
    }

    add_action('wp_ajax_wp_rem_front_change_password', 'wp_rem_front_change_password');
    add_action('wp_ajax_nopriv_wp_rem_front_change_password', 'wp_rem_front_change_password');
}

/**

 * Start Function how to Share Posts

 */
if ( ! function_exists('wp_rem_addthis_script_init_method') ) {

    function wp_rem_addthis_script_init_method() {

        wp_enqueue_script('wp_rem_addthis', wp_rem_server_protocol() . 's7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', '', '', true);
    }

}

/**
 * End Function how to Share Posts
 */
/**

 * Start Function how to Get Current User ID

 */
if ( ! function_exists('wp_rem_get_user_id') ) {



    function wp_rem_get_user_id() {

        global $current_user;

        wp_get_current_user();

        return $current_user->ID;
    }

}

/**

 * End Function how to Get Current User ID

 */
/**
 *
 * @time elapsed string
 *
 */
if ( ! function_exists('wp_rem_time_elapsed_string') ) {



    function wp_rem_time_elapsed_string($ptime) {

        return human_time_diff($ptime, current_time('timestamp')) . " " . wp_rem_plugin_text_srt('wp_rem_func_ago');
    }

}

/**

 * Start Function how to get Custom Loaction for search element

 */
if ( ! function_exists('wp_rem_get_custom_locations_property_filter') ) {


    // field_type value = filter or header
    function wp_rem_get_custom_locations_property_filter($dropdown_start_html = '', $dropdown_end_html = '', $wp_rem_text_ret = false, $property_short_counter, $field_type = 'filter', $dropdown_type = '', $onchange_function = '') {
        global $wp_rem_plugin_options, $wp_rem_form_fields_frontend;
        $wp_rem_search_result_page = isset($wp_rem_plugin_options['wp_rem_search_result_page']) ? $wp_rem_plugin_options['wp_rem_search_result_page'] : '';
        $redirecturl = isset($wp_rem_search_result_page) && $wp_rem_search_result_page != '' ? get_permalink($wp_rem_search_result_page) . '' : '';

        $default_radius = isset($wp_rem_plugin_options['wp_rem_default_radius_circle']) ? $wp_rem_plugin_options['wp_rem_default_radius_circle'] : 0;
        $geo_location_status = isset($wp_rem_plugin_options['wp_rem_map_geo_location']) ? $wp_rem_plugin_options['wp_rem_map_geo_location'] : '';
        $auto_country_detection = isset($wp_rem_plugin_options['wp_rem_map_auto_country_detection']) ? $wp_rem_plugin_options['wp_rem_map_auto_country_detection'] : '';
        $auto_complete = isset($wp_rem_plugin_options['wp_rem_location_autocomplete']) ? $wp_rem_plugin_options['wp_rem_location_autocomplete'] : '';
        $output = '';
        $selected_item = '';
        if ( $dropdown_type == 'list' ) {
            $output = '';
        } else {
            $selected_item .= '<option value="">' . wp_rem_plugin_text_srt('wp_rem_func_locations_placeholder') . '</option>';
        }
        $selected_location = '';

        $onchange_str = 'wp_rem_empty_loc_polygon(\'' . esc_html($property_short_counter) . '\');wp_rem_property_content(\'' . esc_html($property_short_counter) . '\')';
        if ( $field_type != 'filter' ) {

            if ( $redirecturl != '' ) {
                $onchange_str = 'wp_rem_page_load(this, \'' . esc_html($redirecturl) . '\')';
            } else {
                $onchange_str = '';
            }
        }

        wp_enqueue_script('chosen-ajaxify');

        $wp_rem_cs_inline_script = '
        jQuery(document).ready(function () {
            function wp_rem_page_load($this, redirecturl) {
                "use strict";
                var selected_location = jQuery($this).val();
                document.location.href = redirecturl + "?location=" + selected_location;
            }
        });';
        wp_rem_cs_inline_enqueue_script($wp_rem_cs_inline_script, 'wp-rem-custom-inline');

        $location_slug = '';
        if ( isset($_REQUEST['loc_polygon']) && $_REQUEST['loc_polygon'] != '' ) {
            if ( $dropdown_type != 'list' ) {
                $selected_item .= '<option selected value="">' . wp_rem_plugin_text_srt('wp_rem_func_draw_area') . '</option>';
            }
        } else
        if ( isset($_REQUEST['location']) && $_REQUEST['location'] != '' ) {
            $location_slug = $_REQUEST['location'];
            if ( $dropdown_type != 'list' ) {
                $selected_item .= '<option selected value="' . $location_slug . '">' . ucwords(str_replace("-", " ", $location_slug)) . '</option>';
            }
        }
        if ( $dropdown_type == 'list' ) {
            $output .= $selected_item;
            $output .= '';
        } else {
            $location_value = ( isset($_REQUEST['location']) ) ? $_REQUEST['location'] : '';
            if ( isset($_REQUEST['loc_polygon']) && $_REQUEST['loc_polygon'] != '' ) {
                $location_value .= wp_rem_plugin_text_srt('wp_rem_func_draw_area');
            }
            $focus_class = '';
            $location_field_text = '';

            $focus_class = 'wp-rem-focus-out';
            $location_field_text = 'location-field-text';
			if( $field_type == 'modern-v2' || $field_type == 'fancy-v3'){
				$output .= '<div class="field-holder search-input">';
			}
            $output .= '<div class="wp-rem-locations-fields-group ' . $focus_class . ' wp_rem_searchbox_div" data-locationadminurl="' . esc_url(admin_url("admin-ajax.php")) . '">';

            $location_cross_display = ( isset($_REQUEST['location']) ) ? 'block' : 'none';
			if( $field_type != 'modern-v2' && $field_type != 'fancy-v3'){
				$output .= '<span class="wp-rem-search-location-icon" data-id="' . $property_short_counter . '"><i class="icon-location"></i></span>';
			}
            $output .= '<span class="wp-rem-input-cross wp-rem-input-cross' . $property_short_counter . '" data-id="' . $property_short_counter . '" style="display:' . $location_cross_display . ';"><i class="icon-cross"></i></span>';
            if( $field_type == 'modern-v2' ){
				$output .= '<span class="wp-rem-radius-location"><a id="wp-rem-geo-location' . $property_short_counter . '" class="cs-color wp-rem-geo-location' . $property_short_counter . '" href="javascript:void(0)"><i class="icon-angle-down"></i></a></span>';
			}elseif($field_type != 'fancy-v3'){
				$output .= '<span id="wp-rem-radius-location' . $property_short_counter . '" class="wp-rem-radius-location wp-rem-radius-location' . $property_short_counter . '" data-id="' . $property_short_counter . '"><i class="icon-angle-down"></i></span>';
			}
			if ( $auto_complete == 'on' ) {
                $output .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array(
                            'cust_name' => 'location',
                            'cust_id' => 'wp-rem-locations-field',
                            'classes' => "wp-rem-location-field " . $location_field_text . ' ' . $location_field_text . $property_short_counter . ' wp-rem-locations-field-geo' . $property_short_counter,
                            'extra_atr' => 'data-id="' . $property_short_counter . '" placeholder="' . wp_rem_plugin_text_srt('wp_rem_func_locations_placeholder') . '" autocomplete="off"',
                            'std' => $location_value,
                            'return' => true,
                        )
                );
            } else {
                $output .=$wp_rem_form_fields_frontend->wp_rem_form_text_render(
                        array(
                            'cust_name' => 'location',
                            'cust_id' => 'wp-rem-locations-field',
                            'classes' => "wp-rem-location-field " . $location_field_text . " " . $location_field_text . $property_short_counter . ' input-field wp-rem-locations-field' . $property_short_counter,
                            'extra_atr' => 'data-id="' . $property_short_counter . '" placeholder="' . wp_rem_plugin_text_srt('wp_rem_func_all_locations') . '" autocomplete="off"',
                            'std' => @$_GET['location'] ?: '',
                            'return' => true,
                        )
                );
            }
            $search_type = !isset($_REQUEST['location']) ? 'autocomplete' : '';
            if (!$search_type) {
                $search_type = isset($_REQUEST['search_type']) ? $_REQUEST['search_type'] : 'custom';
            }
            $output .= '<input type="hidden" name="search_type" class="search_type" value="' . $search_type . '">';
            $output .= '</div>';
            $output .= '<div class="wp-rem-all-locations' . $property_short_counter . '">';
            $output .= '</div>';
			if( $field_type == 'modern-v2' || $field_type == 'fancy-v3'){
				$output .= '</div>';
			}
			
			if( $field_type == 'fancy-v3' ){
				$output .= '<div class="fancy-v3-radius-location">';
					$output .= '<span class="wp-rem-radius-location"><a id="wp-rem-geo-location' . $property_short_counter . '" class="cs-color wp-rem-geo-location' . $property_short_counter . '" href="javascript:void(0)"><i class="icon-angle-down"></i></a></span>';
				$output .= '</div>';
			}
			
            $radius = isset($_REQUEST['radius']) ? $_REQUEST['radius'] : $default_radius;
            if ( $field_type != 'header' ) {
                if ( $geo_location_status == 'on' ) {
					if( $field_type == 'modern-v2' || $field_type == 'fancy-v3' ){
						$radius_display = 'block';
						$output .= '<div class="field-holder search-input">';
							$output .= '<div class="select-location wp-rem-radius-range' . $property_short_counter . '" style="display:' . $radius_display . '"><div class="select-popup popup-open">';
							$output .= $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
									array(
										'simple' => true,
										'cust_id' => "range-hidden-wp-rem-radius",
										'cust_name' => "radius",
										'std' => $radius,
										'classes' => "wp-rem-radius",
										'return' => true,
										'extra_atr' => 'data-id="' . $property_short_counter . '"',
									)
							);
							$output .= $wp_rem_form_fields_frontend->wp_rem_form_text_render(
											array(
												'cust_name' => '',
												'cust_id' => 'ex16b' . $property_short_counter,
												'std' => '',
												'return' => true,
											)
									)
									. '<span id="ex16b' . $property_short_counter . 'CurrentSliderValLabel"><span class="distance" id="ex16b' . $property_short_counter . 'SliderVal">' . $radius . '</span>' . wp_rem_plugin_text_srt('wp_rem_func_miles_m') . '</span>';

							$output .= '</div></div>';
						$output .= '</div>';
					}else{
					
						$radius_display = 'none';
						$output .= '<div class="select-location wp-rem-radius-range' . $property_short_counter . '" style="display:' . $radius_display . '"><div class="select-popup popup-open"> <a href="javascript:void(0);" class="location-close-popup location-close-popup' . $property_short_counter . '" data-id="' . $property_short_counter . '"><i class="icon-cross"></i></a>';
						$output .= $wp_rem_form_fields_frontend->wp_rem_form_hidden_render(
								array(
									'simple' => true,
									'cust_id' => "range-hidden-wp-rem-radius",
									'cust_name' => "radius",
									'std' => $radius,
									'classes' => "wp-rem-radius",
									'return' => true,
									'extra_atr' => 'data-id="' . $property_short_counter . '"',
								)
						);
						$output .= '<p>' . wp_rem_plugin_text_srt('wp_rem_func_show_with_in') . '</p>' .
								$wp_rem_form_fields_frontend->wp_rem_form_text_render(
										array(
											'cust_name' => '',
											'cust_id' => 'ex16b' . $property_short_counter,
											'std' => '',
											'return' => true,
										)
								)
								. '<span id="ex16b' . $property_short_counter . 'CurrentSliderValLabel">' . wp_rem_plugin_text_srt('wp_rem_func_miles') . ': <span id="ex16b' . $property_short_counter . 'SliderVal">' . $radius . '</span></span>';

						$output .= '<br><p class="my-location">' . wp_rem_plugin_text_srt('wp_rem_func_my_location_of') . ' <i class="cs-color icon-location-arrow"></i><a id="wp-rem-geo-location' . $property_short_counter . '" class="cs-color wp-rem-geo-location' . $property_short_counter . '" href="javascript:void(0)">' . wp_rem_plugin_text_srt('wp_rem_func_my_location') . '</a></p>';
						$output .= '</div></div>';
					}
                    $output .='<script>
                        jQuery(document).ready(function() {
                        if (jQuery("#ex16b' . $property_short_counter . '").length != "") {
                            jQuery("#ex16b' . $property_short_counter . '").slider({
                                step : 1,
                                min: 0,
                                max: 500,
                                value: ' . $radius . ',
                            });
                            jQuery("#ex16b' . $property_short_counter . '").on("slideStop", function () {
                                    var rang_slider_val = jQuery("#ex16b' . $property_short_counter . '").val();
                                    jQuery("#range-hidden-wp-rem-radius").val(rang_slider_val);    
									jQuery("#ex16b' . $property_short_counter . 'SliderVal").html(rang_slider_val);
                                    wp_rem_property_content("' . esc_html($property_short_counter) . '");
                                });
                            jQuery("#ex16b' . $property_short_counter . '").on("slide", function () {
                                    var rang_slider_val = jQuery("#ex16b' . $property_short_counter . '").val();
                                    jQuery("#ex16b' . $property_short_counter . 'SliderVal").html(rang_slider_val);
                            });   

                            }
                        });
                    </script>';
                }
            }
        }
        if ( $dropdown_type != 'list' ) {
            if ( false === ( $wp_rem_location_data = get_transient('wp_rem_location_data') ) ) {
                $output .= '<script>
				jQuery(document).ready(function () {
					jQuery(".chosen-select-location").chosen();
					chosen_ajaxify("filter-location-box' . $property_short_counter . '", "' . esc_url(admin_url('admin-ajax.php')) . '", "dropdown_options_for_search_location_data");
				});
				</script>';
            } else {
                $output .= '<script>
				jQuery(document).ready(function () {
					$("#filter-location-box' . $property_short_counter . '").after(\'<span class="chosen-ajaxify-loader"><img src="' . wp_rem::plugin_url() . 'assets/frontend/images/ajax-loader.gif" alt=""></span>\');                
					var location_data_json = \'' . str_replace("'", "", $wp_rem_location_data) . '\';
					var location_data_json_obj = JSON.parse(location_data_json);
					jQuery.each(location_data_json_obj, function() {
						var location_selected = \'\';
						if(this.value == \'' . $location_slug . '\'){
                                                    location_selected = \'selected\';
						}
						jQuery("#filter-location-box' . $property_short_counter . '").append(
                            jQuery("<option" + location_selected + "></option>").text(this.caption).val(this.value)
						);
					});
					$("#filter-location-box' . $property_short_counter . '").next("span.chosen-ajaxify-loader").remove();
				});
				</script>';
            }
        }

        $output .= '<script>
                jQuery(document).ready(function () {
                    jQuery(".chosen-select-location").chosen();
                    
					jQuery("input.wp-rem-location-field").cityAutocomplete();

                   $(document).on("focus", ".wp-rem-locations-field' . $property_short_counter . '", function () {
                       jQuery("#range-hidden-wp-rem-radius' . $property_short_counter . '").val(0);
                       jQuery(".wp-rem-radius-range' . $property_short_counter . '").hide();
                       jQuery(this).keyup();
                   });

                   $(document).on("click", ".wp-rem-all-locations' . $property_short_counter . ' li", function () {
                       var this_value  = jQuery(this).text();
                       jQuery(".wp-rem-locations-field' . $property_short_counter . '").val(this_value);
                       var this_position  = jQuery("#wp-rem-locations-position' . $property_short_counter . '").val();
                       if( this_position != "header" ){
                            var data_counter = jQuery(".wp-rem-locations-field' . $property_short_counter . '").data("id");
                            jQuery("#range-hidden-wp-rem-radius' . $property_short_counter . '").val(0);
                            jQuery(".wp-rem-radius-range' . $property_short_counter . '").hide();
                            wp_rem_property_content(data_counter);
                       }
                   });
				    $(document).on("keypress", ".wp-rem-locations-fields-group input[name=\'location\']", function (e) {
						var key = e.keyCode || e.which;
						if (key == 13){ 
							$(".location-field-text").val($(this).val());
							$("#range-hidden-wp-rem-radius' . $property_short_counter . '").val(0);
							$(".location-field-text").parents("form").submit();
						}
				   });
                   $(document).on("click", "body", function () {
                        var data_id = jQuery(".location-field-text").data("id");
                        jQuery(".wp-rem-all-locations"+data_id).html("");
                   });
                   
                    $(document).on("click", ".wp-rem-input-cross' . $property_short_counter . '", function () {
						var data_id = jQuery(this).data("id");
                        jQuery(".wp-rem-locations-field"+data_id).val("");
                        jQuery(".wp-rem-locations-field"+data_id).keyup();
                        jQuery(".wp-rem-locations-field-geo"+data_id).val("");
                        jQuery(".wp-rem-locations-field-geo"+data_id).keyup();
                        jQuery("body").click();
                        //jQuery("#range-hidden-wp-rem-radius").val(0);
                        jQuery(".wp-rem-radius-range").hide();
                        wp_rem_property_content(data_id);
                        jQuery(".wp-rem-input-cross' . $property_short_counter . '").hide();
                    });
                    
                    $(document).on("change", ".location-field-text' . $property_short_counter . '", function(){
                        this_text   = jQuery(this).val();
                        if(this_text == ""){
                            jQuery(".wp-rem-input-cross' . $property_short_counter . '").hide();

                        } else {
							jQuery(".wp-rem-input-cross' . $property_short_counter . '").show();
						}
							' . $onchange_function . '
                    });
                    
                    $(document).on("click", ".wp-rem-geo-location' . $property_short_counter . '", function () {
                        var data_id = jQuery(this).data("id");
						
						if ( jQuery(\'form[name="wp-rem-top-map-form"]\').length > 0 ) {
							$(".wp-rem-radius-range' . $property_short_counter . '").toggle();
							wp_rem_getLocation( jQuery(\'form[name="wp-rem-top-map-form"]\').data("id") );
							return false;
						}
						
                        jQuery(".wp-rem-locations-field-geo"+data_id).val("");
                        jQuery("#range-hidden-wp-rem-radius").val(' . $default_radius . ');
                        if (navigator.geolocation) {
                            navigator.geolocation.getCurrentPosition(function(position) {
								jQuery.ajax({
									url: "https://maps.googleapis.com/maps/api/geocode/json?latlng=" + position.coords.latitude + "," + position.coords.longitude + "&sensor=true",
									type: "POST",
									dataType: "json",
									success: function (response) {
										if ( typeof response.results[0] != "undefined" ) {
											jQuery(".wp-rem-locations-field' . $property_short_counter . ', .wp-rem-locations-field-geo' . $property_short_counter . '").val( response.results[0].formatted_address );
											
											jQuery(".wp-rem-input-cross' . $property_short_counter . '").show();
											$(this).parents("form").submit();
										}
									}
								});
                            });
                        }
                    });
					
					$(".wp-rem-radius-location' . $property_short_counter . '").click( function() {
						var data_id = jQuery(this).data("id");
						$(".wp-rem-radius-range"+data_id).toggle();
					});
					
					$(".location-close-popup' . $property_short_counter . '").click( function() {
						var data_id = jQuery(this).data("id");
						$(".wp-rem-radius-range"+data_id).toggle();
					});
                });
                
                </script>';
        if ( $auto_country_detection == 'on' && ( is_home() || is_front_page()) ) {
            $output .= '<script>
                $( window ).load(function() {
					if(jQuery("input.wp-rem-location-field").length !== 0){
						var current_value = jQuery("input.wp-rem-location-field").val();
						var data_id  = jQuery(".location-list input.wp-rem-location-field").data("id");
						jQuery.getJSON("https://freegeoip.net/json/", function(data) {
							if( typeof data.city != "undefined" && data.city.trim() != "" ) {
								current_value = data.city;
							}
							if( typeof data.region_name != "undefined" && data.region_name.trim() != "" ) {
								if ( current_value != "") {
									current_value += " ";
								}
								current_value += data.region_name;
							}
							if( typeof data.zip_code != "undefined" && data.zip_code.trim() != "" ) {
								if ( current_value != "") {
									current_value += " ";
								}
								current_value += data.zip_code;
							}
							if( typeof data.country_name != "undefined" && data.country_name.trim() != "" ) {
								if ( current_value != "") {
									current_value += ", ";
								}
								current_value += data.country_name;
							} 
							
							if ( current_value != "" ) {
								
								jQuery("input.wp-rem-location-field").val( current_value );
								
								jQuery(".wp-rem-input-cross' . $property_short_counter . '").show();
							}
							
						});
					}
				});
            </script>';
        }
        echo force_balance_tags($dropdown_start_html . $output . $dropdown_end_html);
    }

}
/**

 * Start Function how to Count User Meta 

 */
if ( ! function_exists('count_usermeta') ) {

    function count_usermeta($key, $value, $opr, $return = false) {

        $arg = array(
            'meta_key' => $key,
            'meta_value' => $value,
            'meta_compare' => $opr,
        );

        $users = get_users($arg);



        if ( $return == true ) {

            return $users;
        }

        return count($users);
    }

}
/**
 * Start Function how to Save last User login Save
 */
if ( ! function_exists('user_last_login') ) {

    add_action('wp_login', 'user_last_login', 0, 2);

    function user_last_login($login, $user) {

        $user = get_user_by('login', $login);

        $now = time();

        update_user_meta($user->ID, 'user_last_login', $now);
    }

}

/**

 * End Function how to Save last User login Save

 */
/**

 * Start Function how to Add images sizes and their URL's 

 */
if ( ! function_exists('wp_rem_get_img_url') ) {



    function wp_rem_get_img_url($img_name = '', $size = 'wp_rem_media_2', $return_sizes = false, $dir_filter = true) {

        $ret_name = '';

        $wp_rem_img_sizes = array(
            'wp_rem_media_1' => '-870x489',
            'wp_rem_media_2' => '-270x203',
            'wp_rem_media_3' => '-236x168',
            'wp_rem_media_4' => '-200x200',
            'wp_rem_media_5' => '-180x135',
            'wp_rem_media_6' => '-150x113',
        );

        if ( $return_sizes == true ) {

            return $wp_rem_img_sizes;
        }

        // Register our new path for user images.

        if ( $dir_filter == true ) {

            add_filter('upload_dir', 'wp_rem_user_images_custom_wp_rem');
        }

        $wp_rem_upload_dir = wp_upload_dir();

        $wp_rem_upload_sub_dir = '';



        if ( (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']) !== false) ) {

            if ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']) + strlen($wp_rem_img_sizes['wp_rem_media_1'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']) + strlen($wp_rem_img_sizes['wp_rem_media_2'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']) + strlen($wp_rem_img_sizes['wp_rem_media_3'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']) + strlen($wp_rem_img_sizes['wp_rem_media_4'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']) + strlen($wp_rem_img_sizes['wp_rem_media_5'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']) + strlen($wp_rem_img_sizes['wp_rem_media_6'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']));
            }



            $wp_rem_upload_dir = isset($wp_rem_upload_dir['url']) ? $wp_rem_upload_dir['url'] . '/' : '';

            $wp_rem_upload_dir = $wp_rem_upload_dir . $wp_rem_upload_sub_dir;

            if ( $ret_name != '' ) {

                if ( isset($wp_rem_img_sizes[$size]) ) {

                    $ret_name = $wp_rem_upload_dir . $ret_name . $wp_rem_img_sizes[$size] . $img_ext;
                } else {

                    $ret_name = $wp_rem_upload_dir . $ret_name . $img_ext;
                }
            }
        } else {

            if ( $img_name != '' ) {

                $ret_name = '';
            }
        }

        // Set everything back to normal.

        if ( $dir_filter == true ) {

            remove_filter('upload_dir', 'wp_rem_user_images_custom_wp_rem');
        }

        return $ret_name;
    }

}

/**

 * End Function how to Add images sizes and their URL's 

 */
/**

 * Start Function how to  get image

 */
if ( ! function_exists('wp_rem_get_orignal_image_nam') ) {



    function wp_rem_get_orignal_image_nam($img_name = '', $size = 'wp_rem_media_2') {

        $ret_name = '';

        $wp_rem_img_sizes = array(
            'wp_rem_media_1' => '-870x489',
            'wp_rem_media_2' => '-270x203',
            'wp_rem_media_3' => '-236x168',
            'wp_rem_media_4' => '-200x200',
            'wp_rem_media_5' => '-180x135',
            'wp_rem_media_6' => '-150x113',
        );

        if ( (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']) !== false) || (strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']) !== false) ) {

            if ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']) + strlen($wp_rem_img_sizes['wp_rem_media_1'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_1']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']) + strlen($wp_rem_img_sizes['wp_rem_media_2'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_2']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']) + strlen($wp_rem_img_sizes['wp_rem_media_3'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_3']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']) + strlen($wp_rem_img_sizes['wp_rem_media_4'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_4']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']) + strlen($wp_rem_img_sizes['wp_rem_media_5'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_5']));
            } elseif ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']) !== false ) {

                $img_ext = substr($img_name, ( strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']) + strlen($wp_rem_img_sizes['wp_rem_media_6'])), strlen($img_name));

                $ret_name = substr($img_name, 0, strpos($img_name, $wp_rem_img_sizes['wp_rem_media_6']));
            }

            $wp_rem_upload_dir = isset($wp_rem_upload_dir['url']) ? $wp_rem_upload_dir['url'] . '/' : '';

            if ( $ret_name != '' ) {

                if ( isset($wp_rem_img_sizes[$size]) ) {

                    $ret_name = $wp_rem_upload_dir . $ret_name . $wp_rem_img_sizes[$size] . $img_ext;
                } else {

                    $ret_name = $wp_rem_upload_dir . $ret_name . $img_ext;
                }
            }
        } else {

            if ( $img_name != '' ) {
                $ret_name = '';
            }
        }



        return $ret_name;
    }

}
/**

 * Start Function how prevent guest not access admin panel

 */
if ( ! function_exists('redirect_user') ) {

    add_action('admin_init', 'redirect_user');

    function redirect_user() {

        $user = wp_get_current_user();

        if ( ( ! defined('DOING_AJAX') || ! DOING_AJAX ) && ( empty($user) || in_array("wp_rem_member", (array) $user->roles)) ) {

            wp_safe_redirect(home_url());

            exit;
        }
    }

}

/**

 * End Function how prevent guest not access admin panel

 */
/**

 * Start Function how to get using servers and servers protocols

 */
if ( ! function_exists('wp_rem_server_protocol') ) {

    function wp_rem_server_protocol() {

        if ( is_ssl() ) {
            return 'https://';
        }

        return 'http://';
    }

}

/**
 * End Function how to get using servers and servers protocols
 */
if ( ! function_exists('getMultipleParameters') ) {

    function getMultipleParameters($query_string = '') {

        if ( $query_string == '' )
            $query_string = $_SERVER['QUERY_STRING'];

        $params = explode('&', $query_string);
        foreach ( $params as $param ) {

            $k = $param;
            $v = '';

            if ( strpos($param, '=') ) {

                list($name, $value) = explode('=', $param);

                $k = rawurldecode($name);

                $v = rawurldecode($value);
            }

            if ( isset($query[$k]) ) {

                if ( is_array($query[$k]) ) {

                    $query[$k][] = $v;
                } else {

                    $query[$k][] = array( $query[$k], $v );
                }
            } else {

                $query[$k][] = $v;
            }
        }

        return $query;
    }

}

/**

 * End Function how to get using servers and servers protocols

 */
/**

 * Start Function how to check if Image Exists

 */
if ( ! function_exists('wp_rem_image_exist') ) {



    function wp_rem_image_exist($sFilePath) {



        $img_formats = array( "png", "jpg", "jpeg", "gif", "tiff" ); //Etc. . . 

        $path_info = pathinfo($sFilePath);

        if ( isset($path_info['extension']) && in_array(strtolower($path_info['extension']), $img_formats) ) {

            if ( ! filter_var($sFilePath, FILTER_VALIDATE_URL) === false ) {

                $wp_rem_file_response = wp_remote_get($sFilePath);

                if ( is_array($wp_rem_file_response) && isset($wp_rem_file_response['headers']['content-type']) && strpos($wp_rem_file_response['headers']['content-type'], 'image') !== false ) {

                    return true;
                }
            }
        }

        return false;
    }

}

/**

 *

 * @get query whereclase by array

 *

 */
if ( ! function_exists('wp_rem_get_query_whereclase_by_array') ) {



    function wp_rem_get_query_whereclase_by_array($array, $user_meta = false) {

        $id = '';

        $flag_id = 0;

        if ( isset($array) && is_array($array) ) {

            foreach ( $array as $var => $val ) {

                $string = ' ';

                $string .= ' AND (';

                if ( isset($val['key']) || isset($val['value']) ) {

                    $string .= get_meta_condition($val);
                } else {  // if inner array 
                    if ( isset($val) && is_array($val) ) {

                        foreach ( $val as $inner_var => $inner_val ) {

                            $inner_relation = isset($inner_val['relation']) ? $inner_val['relation'] : 'and';

                            $second_string = '';



                            if ( isset($inner_val) && is_array($inner_val) ) {

                                $string .= "( ";

                                $inner_arr_count = is_array($inner_val) ? count($inner_val) : '';

                                $inner_flag = 1;

                                foreach ( $inner_val as $inner_val_var => $inner_val_value ) {

                                    if ( is_array($inner_val_value) ) {

                                        $string .= "( ";

                                        $string .= get_meta_condition($inner_val_value);

                                        $string .= ' )';

                                        if ( $inner_flag != $inner_arr_count )
                                            $string .= ' ' . $inner_relation . ' ';
                                    }

                                    $inner_flag ++;
                                }

                                $string .= ' )';
                            }
                        }
                    }
                }

                $string .= " ) ";

                $id_condtion = '';

                if ( isset($id) && $flag_id != 0 ) {

                    $id = implode(",", $id);

                    if ( empty($id) ) {

                        $id = 0;
                    }

                    if ( $user_meta == true ) {

                        $id_condtion = ' AND user_id IN (' . $id . ')';
                    } else {

                        $id_condtion = ' AND post_id IN (' . $id . ')';
                    }
                }

                if ( $user_meta == true ) {

                    $id = wp_rem_get_user_id_by_whereclase($string . $id_condtion);
                } else {

                    $id = wp_rem_get_post_id_by_whereclase($string . $id_condtion);
                }

                $flag_id = 1;
            }
        }

        return $id;
    }

}

/**

 * Start Function how to get Meta using Conditions

 */
if ( ! function_exists('get_meta_condition') ) {



    function get_meta_condition($val) {

        $string = '';

        $meta_key = isset($val['key']) ? $val['key'] : '';

        $compare = isset($val['compare']) ? $val['compare'] : '=';

        $meta_value = isset($val['value']) ? $val['value'] : '';


        $string .= " meta_key='" . $meta_key . "' AND ";

        $type = isset($val['type']) ? $val['type'] : '';

        if ( $compare == 'BETWEEN' || $compare == 'between' || $compare == 'Between' ) {

            $meta_val1 = '';

            $meta_val2 = '';

            if ( isset($meta_value) && is_array($meta_value) ) {

                $meta_val1 = isset($meta_value[0]) ? $meta_value[0] : '';

                $meta_val2 = isset($meta_value[1]) ? $meta_value[1] : '';
            }

            if ( $type != '' && strtolower($type) == 'numeric' ) {

                $string .= " meta_value BETWEEN '" . $meta_val1 . "' AND " . $meta_val2 . " ";
            } else {

                $string .= " meta_value BETWEEN '" . $meta_val1 . "' AND '" . $meta_val2 . "' ";
            }
        } elseif ( $compare == 'like' || $compare == 'LIKE' || $compare == 'Like' ) {

            $string .= " meta_value LIKE '%" . $meta_value . "%' ";
        } else {

            if ( $type != '' && strtolower($type) == 'numeric' && $meta_value != '' ) {

                $string .= " meta_value" . $compare . " " . $meta_value . " ";
            } else {

                $string .= " meta_value" . $compare . "'" . $meta_value . "' ";
            }
        }

        return $string;
    }

}

/**

 * end Function how to get Meta using Conditions

 */
/**

 * Start Function how to get post id using whereclase Query

 */
if ( ! function_exists('wp_rem_get_post_id_by_whereclase') ) {



    function wp_rem_get_post_id_by_whereclase($whereclase) {

        global $wpdb;

        $qry = "SELECT post_id FROM $wpdb->postmeta WHERE 1=1 " . $whereclase;

        return $posts = $wpdb->get_col($qry);
    }

}



if ( ! function_exists('wp_rem_get_user_id_by_whereclase') ) {



    function wp_rem_get_user_id_by_whereclase($whereclase) {

        global $wpdb;

        $qry = "SELECT user_id FROM $wpdb->usermeta WHERE 1=1 " . $whereclase;

        return $posts = $wpdb->get_col($qry);
    }

}



/**

 * end Function how to get post id using whereclase Query

 */
/**

 * Start Function how to get post id using whereclase Query

 */
if ( ! function_exists('wp_rem_get_post_id_whereclause_post') ) {



    function wp_rem_get_post_id_whereclause_post($whereclase) {

        global $wpdb;

        $qry = "SELECT ID FROM $wpdb->posts WHERE 1=1 " . $whereclase;

        return $posts = $wpdb->get_col($qry);
    }

}

/**

 * End Function how to get post id using whereclase Query

 */
/**

 * Start Function how to remove Dupplicate variable value

 */
if ( ! function_exists('remove_dupplicate_var_val') ) {



    function remove_dupplicate_var_val($qry_str) {

        $old_string = $qry_str;

        $qStr = str_replace("?", "", $qry_str);

        $query = explode('&', $qStr);

        $params = array();

        if ( isset($query) && ! empty($query) ) {

            foreach ( $query as $param ) {

                if ( ! empty($param) ) {

                    $param_array = explode('=', $param);

                    $name = isset($param_array[0]) ? $param_array[0] : '';

                    $value = isset($param_array[1]) ? $param_array[1] : '';

                    $new_str = $name . "=" . $value;

                    // count matches

                    $count_str = substr_count($old_string, $new_str);

                    $count_str = $count_str - 1;

                    if ( $count_str > 0 ) {

                        $old_string = wp_rem_str_replace_limit($new_str, "", $old_string, $count_str);
                    }

                    $old_string = str_replace("&&", "&", $old_string);
                }
            }
        }

        $old_string = str_replace("?&", "?", $old_string);

        return $old_string;
    }

}

/**

 *

 * @str replace limit

 *

 */
if ( ! function_exists('wp_rem_str_replace_limit') ) {



    function wp_rem_str_replace_limit($search, $replace, $string, $limit = 1) {

        if ( is_bool($pos = (strpos($string, $search))) )
            return $string;

        $search_len = strlen($search);

        for ( $i = 0; $i < $limit; $i ++ ) {

            $string = substr_replace($string, $replace, $pos, $search_len);



            if ( is_bool($pos = (strpos($string, $search))) )
                break;
        }

        return $string;
    }

}

/**

 * Start Function how to allow the user for adding special characters

 */
if ( ! function_exists('wp_rem_allow_special_char') ) {



    function wp_rem_allow_special_char($input = '') {

        $output = $input;

        return $output;
    }

}

/**

 * End Function how to allow the user for adding special characters

 */
/* tgm class for (internal and WordPress repository) plugin activation end */

/* Thumb size On Blogs Detail */

add_image_size('wp_rem_media_1', 870, 489, true);

/* Thumb size On Related Blogs On Detail, blogs on property, Portfolio */

add_image_size('wp_rem_media_2', 270, 203, true);

/* Thumb size On Blogs On slider, blogs on property, Portfolio */

add_image_size('wp_rem_media_3', 236, 168, true);

add_image_size('wp_rem_media_4', 200, 200, true);

/* Thumb size On Property, Property View 2, User Resume, company profile */

add_image_size('wp_rem_media_5', 180, 135, true);

/* Thumb size On Property 2, Detail,Related Properties */

add_image_size('wp_rem_media_6', 150, 113, true);

add_image_size('wp_rem_media_7', 120, 90, true);
/* Property detail sidebar gallery */
add_image_size('wp_rem_media_8', 340, 227, true);
/* Property detail gallery with thumbnails */
add_image_size('wp_rem_media_9', 750, 397, true);
/* Single Featured Property Element */
add_image_size('wp_rem_media_10', 535, 401, true);
add_image_size('wp_rem_media_11', 1500, 1320, true);


/**

 * Start Function how to share the posts

 */
if ( ! function_exists('wp_rem_social_share') ) {



    function wp_rem_social_share($echo = true) {

        global $wp_rem_plugin_options;

        $wp_rem_plugin_options = get_option('wp_rem_plugin_options');

        $twitter = '';

        $facebook = '';

        $google_plus = '';

        $tumblr = '';

        $dribbble = '';

        $instagram = '';

        $share = '';

        $stumbleupon = '';

        $youtube = '';

        $pinterst = '';

        if ( isset($wp_rem_plugin_options['wp_rem_twitter_share']) ) {

            $twitter = $wp_rem_plugin_options['wp_rem_twitter_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_facebook_share']) ) {

            $facebook = $wp_rem_plugin_options['wp_rem_facebook_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_google_plus_share']) ) {

            $google_plus = $wp_rem_plugin_options['wp_rem_google_plus_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_tumblr_share']) ) {

            $tumblr = $wp_rem_plugin_options['wp_rem_tumblr_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_dribbble_share']) ) {

            $dribbble = $wp_rem_plugin_options['wp_rem_dribbble_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_instagram_share']) ) {

            $instagram = $wp_rem_plugin_options['wp_rem_instagram_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_share_share']) ) {

            $share = $wp_rem_plugin_options['wp_rem_share_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_stumbleupon_share']) ) {

            $stumbleupon = $wp_rem_plugin_options['wp_rem_stumbleupon_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_youtube_share']) ) {

            $youtube = $wp_rem_plugin_options['wp_rem_youtube_share'];
        }

        if ( isset($wp_rem_plugin_options['wp_rem_pintrest_share']) ) {

            $pinterst = $wp_rem_plugin_options['wp_rem_pintrest_share'];
        }

        wp_rem_addthis_script_init_method();

        $html = '';

        if ( $twitter == 'on' or $facebook == 'on' or $google_plus == 'on' or $pinterst == 'on' or $tumblr == 'on' or $dribbble == 'on' or $instagram == 'on' or $share == 'on' or $stumbleupon == 'on' or $youtube == 'on' ) {

            if ( isset($facebook) && $facebook == 'on' ) {

                $html .='<li><a class="addthis_button_facebook" data-original-title="Facebook"><i class="icon-facebook2"></i></a></li>';
            }

            if ( isset($twitter) && $twitter == 'on' ) {

                $html .='<li><a class="addthis_button_twitter" data-original-title="twitter"><i class="icon-twitter2"></i></a></li>';
            }

            if ( isset($google_plus) && $google_plus == 'on' ) {

                $html .='<li><a class="addthis_button_google" data-original-title="google-plus"><i class="icon-googleplus7"></i></a></li>';
            }

            if ( isset($tumblr) && $tumblr == 'on' ) {

                $html .='<li><a class="addthis_button_tumblr" data-original-title="Tumblr"><i class="icon-tumblr5"></i></a></li>';
            }

            if ( isset($dribbble) && $dribbble == 'on' ) {

                $html .='<li><a class="addthis_button_dribbble" data-original-title="Dribbble"><i class="icon-dribbble7"></i></a></li>';
            }

            if ( isset($instagram) && $instagram == 'on' ) {

                $html .='<li><a class="addthis_button_instagram" data-original-title="Instagram"><i class="icon-instagram4"></i></a></li>';
            }

            if ( isset($stumbleupon) && $stumbleupon == 'on' ) {

                $html .='<li><a class="addthis_button_stumbleupon" data-original-title="stumbleupon"><i class="icon-stumbleupon4"></i></a></li>';
            }

            if ( isset($youtube) && $youtube == 'on' ) {

                $html .='<li><a class="addthis_button_youtube" data-original-title="Youtube"><i class="icon-youtube"></i></a></li>';
            }

            if ( isset($pinterst) && $pinterst == 'on' ) {

                $html .='<li><a class="addthis_button_youtube" data-original-title="Youtube"><i class="icon-pinterest"></i></a></li>';
            }

            if ( isset($share) && $share == 'on' ) {

                $html .= '<li><a class="cs-more addthis_button_compact at300m"></a></li>';
            }

            $html .= '</ul>';
        }
        if ( $echo ) {
            echo balanceTags($html, true);
        } else {
            return balanceTags($html, true);
        }
    }

}
/*
 *  End tool tip text asaign function
 */
/**
 * Start Function how to add tool tip text without icon only tooltip string
 */
if ( ! function_exists('wp_rem_tooltip_helptext_string') ) {



    function wp_rem_tooltip_helptext_string($popover_text = '', $return_html = true, $class = '') {

        $popover_link = '';

        if ( isset($popover_text) && $popover_text != '' ) {

            $popover_link = '<br><em><strong>' . $popover_text . '</strong></em>';
        }

        if ( $return_html == true ) {

            return $popover_link;
        } else {

            echo force_balance_tags($popover_link);
        }
    }

}

/*

 *  End tool tip text asaign function

 */


// Fontawsome icon box for Theme Options

if ( ! function_exists('wp_rem_iconlist_plugin_options') ) {



    function wp_rem_iconlist_plugin_options($icon_value = '', $id = '', $name = '', $class = '') {

        global $wp_rem_form_fields;

        ob_start();
        ?>

        <script>



            jQuery(document).ready(function ($) {

                var this_icons;
                var rand_num = '<?php echo wp_rem_allow_special_char($id); ?>';
                var e9_element = $('#e9_element_' + rand_num).fontIconPicker({
                    theme: 'fip-bootstrap'
                });
                icons_load_call.always(function () {
                    this_icons = loaded_icons;
                    // Get the class prefix
                    var classPrefix = this_icons.preferences.fontPref.prefix,
                            icomoon_json_icons = [],
                            icomoon_json_search = [];
                    $.each(this_icons.icons, function (i, v) {
                        icomoon_json_icons.push(classPrefix + v.properties.name);
                        if (v.icon && v.icon.tags && v.icon.tags.length) {
                            icomoon_json_search.push(v.properties.name + ' ' + v.icon.tags.join(' '));
                        } else {
                            icomoon_json_search.push(v.properties.name);
                        }
                    });
                    // Set new fonts on fontIconPicker
                    e9_element.setIcons(icomoon_json_icons, icomoon_json_search);
                    // Show success message and disable
                    $('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-success').text('Successfully loaded icons').prop('disabled', true);
                })
                        .fail(function () {
                            // Show error message and enable
                            $('#e9_buttons_' + rand_num + ' button').removeClass('btn-primary').addClass('btn-danger').text('Error: Try Again?').prop('disabled', false);
                        });

            });
        </script>

        <?php
        $wp_rem_opt_array = array(
            'id' => '',
            'std' => wp_rem_allow_special_char($icon_value),
            'cust_id' => "e9_element_" . wp_rem_allow_special_char($id),
            'cust_name' => wp_rem_allow_special_char($name) . "[]",
            'classes' => ( isset($class) ) ? $class : '',
            'extra_atr' => '',
        );

        $wp_rem_form_fields->wp_rem_form_text_render($wp_rem_opt_array);
        ?>

        <span id="e9_buttons_<?php echo wp_rem_allow_special_char($id); ?>" style="display:none">

            <button autocomplete="off" type="button" class="btn btn-primary"><?php echo wp_rem_plugin_text_srt('wp_rem_functions_php_load_from_icomoon'); ?></button>

        </span>

        <?php
        $fontawesome = ob_get_clean();

        return $fontawesome;
    }

}

/*

 * start information messages

 */

if ( ! function_exists('wp_rem_info_messages_property') ) {



    function wp_rem_info_messages_property($message = '', $return = true, $classes = '', $before = '', $after = '') {

        global $post;

        $output = '';

        $class_str = '';

        if ( $classes != '' ) {

            $class_str .= ' class="' . $classes . '"';
        }

        $before_str = '';

        if ( $before != '' ) {

            $before_str .= $before;
        }

        $after_str = '';

        if ( $after != '' ) {

            $after_str .= $after;
        }

        $output .= $before_str;

        $output .= '<span' . $class_str . '>';

        $output .= $message;

        $output .= '</span>';

        $output .= $after_str;

        if ( $return == true ) {

            return force_balance_tags($output);
        } else {

            echo force_balance_tags($output);
        }
    }

}

/*

 * end information messages

 */



/* define it global */

$umlaut_chars['in'] = array( chr(196), chr(228), chr(214), chr(246), chr(220), chr(252), chr(223) );

$umlaut_chars['ecto'] = array( 'Ä', 'ä', 'Ö', 'ö', 'Ü', 'ü', 'ß' );

$umlaut_chars['html'] = array( '&Auml;', '&auml;', '&Ouml;', '&ouml;', '&Uuml;', '&uuml;', '&szlig;' );

$umlaut_chars['feed'] = array( '&#196;', '&#228;', '&#214;', '&#246;', '&#220;', '&#252;', '&#223;' );

$umlaut_chars['utf8'] = array( utf8_encode('Ä'), utf8_encode('ä'), utf8_encode('Ö'), utf8_encode('ö'), utf8_encode('Ü'), utf8_encode('ü'), utf8_encode('ß') );

$umlaut_chars['perma'] = array( 'Ae', 'ae', 'Oe', 'oe', 'Ue', 'ue', 'ss' );


if ( ! function_exists('wp_rem_de_DE_umlaut_permalinks') ) {
    /* sanitizes the titles to get qualified german permalinks with  correct transliteration */

    function wp_rem_de_DE_umlaut_permalinks($title) {

        global $umlaut_chars;

        if ( seems_utf8($title) ) {
            $invalid_latin_chars = array( chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe', chr(197) . chr(160) => 'S', chr(197) . chr(189) => 'Z', chr(197) . chr(161) => 's', chr(197) . chr(190) => 'z', chr(226) . chr(130) . chr(172) => 'E' );
            $title = utf8_decode(strtr($title, $invalid_latin_chars));
        }
        $title = str_replace($umlaut_chars['ecto'], $umlaut_chars['perma'], $title);
        $title = str_replace($umlaut_chars['in'], $umlaut_chars['perma'], $title);
        $title = str_replace($umlaut_chars['html'], $umlaut_chars['perma'], $title);
        $title = sanitize_title_with_dashes($title);
        return $title;
    }

    add_filter('sanitize_title', 'wp_rem_de_DE_umlaut_permalinks');
}

if ( ! function_exists('wp_new_user_notification') ) :

    function wp_new_user_notification($user_id, $plaintext_pass = ' ') {

        $user = new WP_User($user_id);

        $user_login = stripslashes($user->user_login);
        $user_email = stripslashes($user->user_email);

        if ( empty($plaintext_pass) ) {
            return;
        }

        do_action('wp_rem_new_user_notification_site_owner', $user_login, $user_email);
        $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
        wp_set_password($random_password, $user_id);

        $reg_user = get_user_by('ID', $user_id);
        do_action('wp_rem_user_register', $reg_user, $random_password);
    }

endif;

if ( ! function_exists('users_query_vars') ) {
    add_filter('query_vars', 'users_query_vars');

    function users_query_vars($vars) {

        global $wp_rem_plugin_options;

        // add lid to the valid list of variables

        $author_slug = isset($wp_rem_plugin_options['wp_rem_author_page_slug']) ? $wp_rem_plugin_options['wp_rem_author_page_slug'] : 'user';

        $new_vars = array( $author_slug );

        $vars = $new_vars + $vars;

        return $vars;
    }

}
if ( ! function_exists('wp_rem_user_rewrite_rules') ) {

    function wp_rem_user_rewrite_rules($wp_rewrite) {

        global $wp_rem_plugin_options;
        $author_slug = isset($wp_rem_plugin_options['wp_rem_author_page_slug']) ? $wp_rem_plugin_options['wp_rem_author_page_slug'] : 'user';

        $newrules = array();
        $new_rules[$author_slug . '/(\d*)$'] = 'index.php?author=$matches[1]';
        $wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
    }

    add_filter('generate_rewrite_rules', 'wp_rem_user_rewrite_rules');
}
if ( ! function_exists('wp_rem_location_query_vars') ) {

    function wp_rem_location_query_vars($query_vars) {
        $query_vars['location'] = 'location';
        return $query_vars;
    }

    add_filter('query_vars', 'wp_rem_location_query_vars');
}


/*
 * TinyMCE EDITOR "Biographical Info" USER PROFILE
 * */
if ( ! function_exists('wp_rem_biographical_info_tinymce') ) {

    function wp_rem_biographical_info_tinymce() {
        if ( basename($_SERVER['PHP_SELF']) == 'profile.php' || basename($_SERVER['PHP_SELF']) == 'user-edit.php' && function_exists('wp_tiny_mce') ) {
            wp_admin_css();
            wp_enqueue_script('utils');
            wp_enqueue_script('editor');
            do_action('admin_print_scripts');
            do_action("admin_print_styles-post-php");
            do_action('admin_print_styles');
            remove_all_filters('mce_external_plugins');

            add_filter('teeny_mce_before_init', create_function('$a', '
		
		$a["skin"] = "wp_theme";
		$a["height"] = "200";
		$a["width"] = "240";
		$a["onpageload"] = "";
		$a["mode"] = "exact";
		$a["elements"] = "description";
		$a["theme_advanced_buttons1"] = "formatselect, forecolor, bold, italic, pastetext, pasteword, bullist, numlist, link, unlink, outdent, indent, charmap, removeformat, spellchecker, fullscreen, wp_adv";
		$a["theme_advanced_buttons2"] = "underline, justifyleft, justifycenter, justifyright, justifyfull, forecolor, pastetext, undo, redo, charmap, wp_help";
		$a["theme_advanced_blockformats"] = "p,h2,h3,h4,h5,h6";
		$a["theme_advanced_disable"] = "strikethrough";
		return $a;'));

            wp_tiny_mce(true);
        }
    }

    add_action('admin_head', 'wp_rem_biographical_info_tinymce');
}
if ( ! function_exists('wp_rem_cred_limit_check') ) {

    function wp_rem_cred_limit_check($property_id = '', $index = '', $print_all = false) {

        $property_limits = get_post_meta($property_id, 'wp_rem_trans_all_meta', true);
        if ( is_array($property_limits) && sizeof($property_limits) > 0 ) {

            foreach ( $property_limits as $limit_key => $limit_val ) {
                if ( isset($limit_val['value']) && isset($limit_val['key']) && $limit_val['key'] == $index ) {

                    return $limit_val['value'];
                }
            }
        }
        if ( empty($property_limits) ) {
            return 'on';
        }
        if ( $print_all === true ) {
            
        }
    }

}
if ( ! function_exists('wp_rem_encode_url_string') ) {

    function wp_rem_encode_url_string($stringArray) {
        $s = strtr(base64_encode(addslashes(gzcompress(serialize($stringArray), 9))), '+/=', '-_,');
        return $s;
    }

}
if ( ! function_exists('wp_rem_decode_url_string') ) {

    function wp_rem_decode_url_string($stringArray) {
        $s = unserialize(gzuncompress(stripslashes(base64_decode(strtr($stringArray, '-_,', '+/=')))));
        return $s;
    }

}
if ( ! function_exists('wp_rem_properties_map_cords_to_url') ) {

    function wp_rem_properties_map_cords_to_url() {
        $cords = isset($_POST['pathstr']) ? $_POST['pathstr'] : '';
        $property_ins = isset($_POST['poly_in_properties']) ? $_POST['poly_in_properties'] : '';

        $final_array = array(
            'cords' => $cords,
            'ids' => $property_ins,
        );

        $final_json = json_encode($final_array);

        $encode_string = wp_rem_encode_url_string($final_json);

        echo json_encode(array( 'string' => $encode_string ));
        die;
    }

    add_action('wp_ajax_wp_rem_properties_map_cords_to_url', 'wp_rem_properties_map_cords_to_url');
    add_action('wp_ajax_nopriv_wp_rem_properties_map_cords_to_url', 'wp_rem_properties_map_cords_to_url');
}

if ( ! function_exists('array_column') ) {

    function array_column($input = null, $columnKey = null, $indexKey = null) {
        // Using func_get_args() in order to check for proper number of
        // parameters and trigger errors exactly as the built-in array_column()
        // does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ( $argc < 2 ) {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if ( ! is_array($params[0]) ) {
            trigger_error(
                    'array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING
            );
            return null;
        }
        if ( ! is_int($params[1]) && ! is_float($params[1]) && ! is_string($params[1]) && $params[1] !== null && ! (is_object($params[1]) && method_exists($params[1], '__toString'))
        ) {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if ( isset($params[2]) && ! is_int($params[2]) && ! is_float($params[2]) && ! is_string($params[2]) && ! (is_object($params[2]) && method_exists($params[2], '__toString'))
        ) {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if ( isset($params[2]) ) {
            if ( is_float($params[2]) || is_int($params[2]) ) {
                $paramsIndexKey = (int) $params[2];
            } else {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ( $paramsInput as $row ) {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ( $paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row) ) {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ( $paramsColumnKey === null ) {
                $valueSet = true;
                $value = $row;
            } elseif ( is_array($row) && array_key_exists($paramsColumnKey, $row) ) {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ( $valueSet ) {
                if ( $keySet ) {
                    $resultArray[$key] = $value;
                } else {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }

}

if ( ! function_exists("wp_rem_linkedin_attachment_metas") ) {

    function wp_rem_linkedin_attachment_metas($contentln, $url) {
        $content_title = '';
        $content_desc = '';
        $utf = "UTF-8";
        $content_img = '';
        $aprv_me_data = wp_remote_get($url);
        if ( is_array($aprv_me_data) ) {
            $aprv_me_data = $aprv_me_data['body']; // use the content
        } else {
            $aprv_me_data = '';
        }

        $og_datas = new DOMDocument();
        @$og_datas->loadHTML($aprv_me_data);
        $xpath = new DOMXPath($og_datas);
        if ( isset($contentln['content']['title']) ) {
            $ogmetaContentAttributeNodes_tit = $xpath->query("/html/head/meta[@property='og:title']/@content");
            foreach ( $ogmetaContentAttributeNodes_tit as $ogmetaContentAttributeNode_tit ) {
                $content_title = $ogmetaContentAttributeNode_tit->nodeValue;
            }

            if ( $content_title != '' )
                $contentln['content']['title'] = $content_title;
        }
        if ( isset($contentln['content']['description']) ) {
            $ogmetaContentAttributeNodes_desc = $xpath->query("/html/head/meta[@property='og:description']/@content");
            foreach ( $ogmetaContentAttributeNodes_desc as $ogmetaContentAttributeNode_desc ) {
                $content_desc = $ogmetaContentAttributeNode_desc->nodeValue;
            }

            if ( $content_desc != '' )
                $contentln['content']['description'] = $content_desc;
        }

        if ( isset($contentln['content']['submitted-url']) )
            $contentln['content']['submitted-url'] = $url;

        return $contentln;
    }

}

if ( ! function_exists('wp_rem_property_string_limit') ) {

    function wp_rem_property_string_limit($string, $limit) {

        $space = " ";
        $appendstr = " ...";
        if ( mb_strlen($string) <= $limit )
            return $string;
        if ( mb_strlen($appendstr) >= $limit )
            return '';
        $string = mb_substr($string, 0, $limit - mb_strlen($appendstr));
        $rpos = mb_strripos($string, $space);
        if ( $rpos === false )
            return $string . $appendstr;
        else
            return mb_substr($string, 0, $rpos) . $appendstr;
    }

}

if ( ! function_exists("wp_rem_fbapp_attachment_metas") ) {

    function wp_rem_fbapp_attachment_metas($attachment, $url) {
        $name = '';
        $description_li = '';
        $content_img = '';
        $utf = "UTF-8";
        $aprv_me_data = wp_remote_get($url);
        if ( is_array($aprv_me_data) ) {
            $aprv_me_data = $aprv_me_data['body']; // use the content
        } else {
            $aprv_me_data = '';
        }

        $og_datas = new DOMDocument();
        @$og_datas->loadHTML($aprv_me_data);
        $xpath = new DOMXPath($og_datas);
        if ( isset($attachment['name']) ) {
            $ogmetaContentAttributeNodes_tit = $xpath->query("/html/head/meta[@property='og:title']/@content");

            foreach ( $ogmetaContentAttributeNodes_tit as $ogmetaContentAttributeNode_tit ) {
                $name = $ogmetaContentAttributeNode_tit->nodeValue;
            }
            $name = utf8_decode($name);
            if ( $name != '' )
                $attachment['name'] = $name;
        }
        if ( isset($attachment['actions']) ) {
            if ( isset($attachment['actions']['name']) ) {
                $ogmetaContentAttributeNodes_tit = $xpath->query("/html/head/meta[@property='og:title']/@content");

                foreach ( $ogmetaContentAttributeNodes_tit as $ogmetaContentAttributeNode_tit ) {
                    $name = $ogmetaContentAttributeNode_tit->nodeValue;
                }
                $name = utf8_decode($name);
                if ( $name != '' )
                    $attachment['actions']['name'] = $name;
            }
            if ( isset($attachment['actions']['link']) ) {
                $attachment['actions']['link'] = $url;
            }
        }
        if ( isset($attachment['description']) ) {
            $ogmetaContentAttributeNodes_desc = $xpath->query("/html/head/meta[@property='og:description']/@content");
            foreach ( $ogmetaContentAttributeNodes_desc as $ogmetaContentAttributeNode_desc ) {
                $description_li = $ogmetaContentAttributeNode_desc->nodeValue;
            }
            if ( get_option('xyz_smap_utf_decode_enable') == 1 )
                $description_li = utf8_decode($description_li);
            if ( $description_li != '' )
                $attachment['description'] = $description_li;
        }

        if ( isset($attachment['link']) )
            $attachment['link'] = $url;

        return $attachment;
    }

}

/**
 * @count Banner Clicks
 *
 */
if ( ! function_exists('wp_rem_banner_click_count_plus') ) {

    function wp_rem_banner_click_count_plus() {
        $code_id = isset($_POST['code_id']) ? $_POST['code_id'] : '';
        $banner_click_count = get_option("banner_clicks_" . $code_id);
        $banner_click_count = $banner_click_count <> '' ? $banner_click_count : 0;
        if ( ! isset($_COOKIE["banner_clicks_" . $code_id]) ) {
            setcookie("banner_clicks_" . $code_id, 'true', time() + 86400, '/');
            update_option("banner_clicks_" . $code_id, $banner_click_count + 1);
        }
        die(0);
    }

    add_action('wp_ajax_wp_rem_banner_click_count_plus', 'wp_rem_banner_click_count_plus');
    add_action('wp_ajax_nopriv_wp_rem_banner_click_count_plus', 'wp_rem_banner_click_count_plus');
}

if ( ! function_exists('wp_rem_wpml_lang_url') ) {

    function wp_rem_wpml_lang_url() {

        if ( function_exists('icl_object_id') ) {

            global $sitepress;

            $cs_server_uri = $_SERVER['REQUEST_URI'];
            $cs_server_uri = explode('/', $cs_server_uri);

            $cs_active_langs = $sitepress->get_active_languages();

            if ( is_array($cs_active_langs) && sizeof($cs_active_langs) > 0 ) {
                foreach ( $cs_server_uri as $uri ) {

                    if ( array_key_exists($uri, $cs_active_langs) ) {
                        return $uri;
                    }
                }
            }
        }
        return false;
    }

}

if ( ! function_exists('wp_rem_wpml_parse_url') ) {

    function wp_rem_wpml_parse_url($lang = 'en', $url) {

        $cs_fir_url = home_url('/');
        if ( strpos($cs_fir_url, '/' . $lang . '/') !== false ) {
            
        }
        $cs_tail_url = substr($url, strlen($cs_fir_url), strlen($url));

        $cs_trans_url = $cs_fir_url . $lang . '/' . $cs_tail_url;

        return $cs_trans_url;
    }

}
if ( ! function_exists('wp_rem_wpml_ls_filter') ) {
    add_filter('icl_ls_languages', 'wp_rem_wpml_ls_filter');

    function wp_rem_wpml_ls_filter($languages) {
        global $sitepress;
        if ( strpos(basename($_SERVER['REQUEST_URI']), 'dashboard') !== false || strpos(basename($_SERVER['REQUEST_URI']), 'tab') !== false ) {

            $cs_request_query = str_replace('?', '', basename($_SERVER['REQUEST_URI']));

            $cs_request_query = explode('&', $cs_request_query);

            $cs_request_quer = '';

            $query_count = 1;

            if ( is_array($cs_request_query) ) {
                foreach ( $cs_request_query as $quer ) {
                    if ( strpos($quer, 'page_id') !== false || strpos($quer, 'lang') !== false ) {
                        continue;
                    }
                    if ( $query_count == 1 ) {
                        $cs_request_quer .= $quer;
                    } else {
                        $cs_request_quer .= '&' . $quer;
                    }
                    $query_count ++;
                }
            }

            if ( is_array($languages) && sizeof($languages) > 0 ) {
                foreach ( $languages as $lang_code => $language ) {
                    if ( strpos($languages[$lang_code]['url'], '?') !== false ) {
                        $languages[$lang_code]['url'] = $languages[$lang_code]['url'] . '&' . $cs_request_quer;
                    } else {
                        $languages[$lang_code]['url'] = $languages[$lang_code]['url'] . '?' . $cs_request_quer;
                    }
                }
            }
        }
        return $languages;
    }

}
if ( ! function_exists('wp_rem_array_search_partial') ) {

    function wp_rem_array_search_partial($arr, $keyword) {
        $response = array();
        foreach ( $arr as $index => $string ) {
            if ( stripos($string, $keyword) !== FALSE )
                if ( stripos($string, $keyword) == 0 ) {
                    $response[] = $string;
                }
        }
        return $response;
    }

}
if ( ! function_exists('wp_rem_dashboard_pagination') ) {

    function wp_rem_dashboard_pagination($total_pages = 1, $page = 1, $url = '', $to_action = '') {

        $query_string = $_SERVER['QUERY_STRING'];

        if ( $url != '' ) {
            $base = $url . '' . remove_query_arg('page_id_all', $query_string) . '%_%';
        } else {
            $base = get_permalink() . '?' . remove_query_arg('page_id_all', $query_string) . '%_%';
        }
        $wp_rem_pagination = paginate_links(array(
            'base' => $base, // the base URL, including query arg
            'format' => '&page_id_all=%#%', // this defines the query parameter that will be used, in this case "p"
            'prev_text' => '<i class="icon-angle-left"></i> ' . wp_rem_plugin_text_srt('wp_rem_func_previous'), // text for previous page
            'next_text' => wp_rem_plugin_text_srt('wp_rem_func_next') . ' <i class="icon-angle-right"></i>', // text for next page
            'total' => $total_pages, // the total number of pages we have
            'current' => $page, // the current page
            'end_size' => 1,
            'mid_size' => 2,
            'type' => 'array',
        ));

        $wp_rem_pages = '';

        if ( is_array($wp_rem_pagination) && sizeof($wp_rem_pagination) > 0 ) {

            $wp_rem_pages .= '<ul class="pagination">';

            foreach ( $wp_rem_pagination as $wp_rem_link ) {

                if ( strpos($wp_rem_link, 'current') !== false ) {

                    $wp_rem_pages .= '<li class="active"><a>' . preg_replace("/[^0-9]/", "", $wp_rem_link) . '</a></li>';
                } else {

                    $page_a_val = '';
                    $page_a_href = '';
                    $query_page_num = '';
                    $pagination_dom = new DOMDocument;
                    $pagination_dom->loadHTML($wp_rem_link);
                    foreach ( $pagination_dom->getElementsByTagName('a') as $pagination_node ) {
                        $page_a_href = $pagination_node->getAttribute('href');
                        $page_a_val = $pagination_node->nodeValue;

                        $parse_href = parse_url($page_a_href);
                        $href_query = isset($parse_href['query']) ? $parse_href['query'] : '';
                        $query_page_num = preg_replace("/[^0-9]/", "", $href_query);
                    }
                    if ( ! isset($query_page_num) || $query_page_num == '' ) {
                        $query_page_num = 1;
                    }
                    if ( $page_a_val != '' && $page_a_href != '' ) {
                        $wp_rem_pages .= '<li><a href="javascript:void(0);" data-id="wp_rem_member_' . $to_action . '" data-pagenum="' . $query_page_num . '" class="user_dashboard_ajax" data-queryvar="dashboard=' . $to_action . '&page_id_all=' . $query_page_num . '">' . $page_a_val . '</a></li>';
                    } else {
                        $wp_rem_pages .= '<li>' . $wp_rem_link . '</li>';
                    }
                }
            }

            $wp_rem_pages .= '</ul>';
        }

        echo force_balance_tags($wp_rem_pages);
    }

}

if ( ! function_exists('wp_rem_filters_query_args') ) {

    function wp_rem_filters_query_args($args = array()) {

        $date_range = isset($_POST['date_range']) ? $_POST['date_range'] : '';

        // Date range filter query
        if ( $date_range != '' && $date_range != 'undefined' ) {
            $new_date_range = explode(' - ', $date_range);
            $start_date = isset($new_date_range[0]) ? str_replace('/', '-', $new_date_range[0]) : '';
            $end_date = isset($new_date_range[1]) ? str_replace('/', '-', $new_date_range[1]) : '';
            $args['meta_query'][] = array(
                'key' => 'wp_rem_property_posted',
                'value' => strtotime($start_date),
                'compare' => '>=',
            );
            $args['meta_query'][] = array(
                'key' => 'wp_rem_property_posted',
                'value' => strtotime($end_date),
                'compare' => '<=',
            );
        }

        return $args;
    }

}

if ( ! function_exists('wp_rem_property_views_count') ) {

    function wp_rem_property_views_count($postID) {
        $wp_rem_property_views_count = get_post_meta($postID, "wp_rem_property_views_count", true);
        if ( ! isset($_COOKIE["wp_rem_property_views_count" . $postID]) ) {
            setcookie("wp_rem_property_views_count" . $postID, time() + 86400);
            update_post_meta($postID, 'wp_rem_property_views_count', (int) $wp_rem_property_views_count + 1);
        }
    }

}

if ( ! function_exists('wp_rem_base_query_args') ) {

    function wp_rem_base_query_args($element_filter_arr = array()) {
        $element_filter_arr[] = array(
            'key' => 'wp_rem_property_posted',
            'value' => strtotime(date("d-m-Y")),
            'compare' => '<=',
        );

        $element_filter_arr[] = array(
            'key' => 'wp_rem_property_expired',
            'value' => strtotime(date("d-m-Y")),
            'compare' => '>=',
        );

        $element_filter_arr[] = array(
            'key' => 'wp_rem_property_status',
            'value' => 'active',
            'compare' => '=',
        );
        // check if member not inactive
        $element_filter_arr[] = array(
            'key' => 'property_member_status',
            'value' => 'active',
            'compare' => '=',
        );
        return $element_filter_arr;
    }

}