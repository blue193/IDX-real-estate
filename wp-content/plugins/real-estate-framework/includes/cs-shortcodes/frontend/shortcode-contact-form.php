<?php

/*
 * Frontend file for Contact Us short code
 */
if ( ! function_exists( 'wp_rem_cs_var_contact_us_data' ) ) {

    function wp_rem_cs_var_contact_us_data( $atts, $content = "" ) {
        global $post, $abc;
        $html = '';
        $page_element_size = isset( $atts['contact_form_element_size'] ) ? $atts['contact_form_element_size'] : 100;
        if ( function_exists( 'wp_rem_cs_var_page_builder_element_sizes' ) ) {
            $html .= '<div class="' . wp_rem_cs_var_page_builder_element_sizes( $page_element_size ) . ' ">';
        }
        $defaults = shortcode_atts( array(
            'wp_rem_cs_var_column_size' => '',
            'wp_rem_cs_var_contact_us_element_title' => '',
            'wp_rem_var_contact_us_align' => '',
            'wp_rem_cs_var_contact_us_element_subtitle' => '',
            'wp_rem_cs_var_contact_us_element_send' => '',
            'wp_rem_cs_var_contact_us_element_success' => '',
            'wp_rem_cs_var_contact_us_element_error' => '',

                ), $atts );


        extract( shortcode_atts( $defaults, $atts ) );

        wp_enqueue_script( 'wp_rem_cs-growls' );

        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();

        if ( isset( $wp_rem_cs_var_column_size ) && $wp_rem_cs_var_column_size != '' ) {
            if ( function_exists( 'wp_rem_cs_var_custom_column_class' ) ) {
                $column_class = wp_rem_cs_var_custom_column_class( $wp_rem_cs_var_column_size );
            }
        }

        $wp_rem_cs_email_counter = rand( 56, 5565 );
        // Set All variables 
        $section_title = '';
        $column_class = isset( $column_class ) ? $column_class : '';
        $wp_rem_cs_contactus_section_title = isset( $wp_rem_cs_var_contact_us_element_title ) ? $wp_rem_cs_var_contact_us_element_title : '';
        $wp_rem_cs_contact_us_element_subtitle = isset( $wp_rem_cs_var_contact_us_element_subtitle ) ? $wp_rem_cs_var_contact_us_element_subtitle : '';
        $wp_rem_cs_contactus_send = isset( $wp_rem_cs_var_contact_us_element_send ) ? $wp_rem_cs_var_contact_us_element_send : '';
        $wp_rem_cs_success = isset( $wp_rem_cs_var_contact_us_element_success ) ? $wp_rem_cs_var_contact_us_element_success : '';
        $wp_rem_cs_error = isset( $wp_rem_cs_var_contact_us_element_error ) ? $wp_rem_cs_var_contact_us_element_error : '';


        // End All variables
        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '<div class="' . esc_html( $column_class ) . '">';
        }
       
        $html .= wp_rem_title_sub_align($wp_rem_cs_contactus_section_title, $wp_rem_cs_contact_us_element_subtitle, $wp_rem_var_contact_us_align);

        if ( trim( $wp_rem_cs_success ) && trim( $wp_rem_cs_success ) != '' ) {
            $success = $wp_rem_cs_success;
        } else {
            $success = wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_default_success_msg' );
        }

        if ( trim( $wp_rem_cs_error ) && trim( $wp_rem_cs_error ) != '' ) {
            $error = $wp_rem_cs_error;
        } else {
            $error = wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_default_error_msg' );
        }

        $wp_rem_cs_inline_script = '
		function wp_rem_cs_var_contact_frm_submit(form_id) {
			var wp_rem_cs_mail_id = \'' . esc_js( $wp_rem_cs_email_counter ) . '\';
			if (form_id == wp_rem_cs_mail_id) {
				var $ = jQuery;
				var thisObj = jQuery(\'.contact-btn-holder\');
				wp_rem_show_theme_loader(\'.contact-btn-holder\', \'\', \'button_loader\', thisObj);
				var datastring = $("#frm' . esc_js( $wp_rem_cs_email_counter ) . '").serialize() + "&wp_rem_cs_contact_email=' . esc_js( $wp_rem_cs_contactus_send ) . '&wp_rem_cs_contact_succ_msg=' . esc_js( $success ) . '&wp_rem_cs_contact_error_msg=' . esc_js( $error ) . '&action=wp_rem_cs_var_contact_submit";
                $.ajax({
					type: \'POST\',
					url: \'' . esc_js( esc_url( admin_url( 'admin-ajax.php' ) ) ) . '\',
					data: datastring,
					dataType: "json",
					success: function (response) {
						wp_rem_cs_show_response_theme(response, \'\', thisObj);
					}
				});
			}
		}';
        wp_rem_cs_inline_enqueue_script( $wp_rem_cs_inline_script, 'wp-rem-custom-inline' );

        $html .= '<div class="contact-form">';

        $html .= '<div class="form-holder row" id="ul_frm' . absint( $wp_rem_cs_email_counter ) . '">';
        $html .= '<form  name="frm' . absint( $wp_rem_cs_email_counter ) . '" id="frm' . absint( $wp_rem_cs_email_counter ) . '" action="javascript:wp_rem_cs_var_contact_frm_submit(' . absint( $wp_rem_cs_email_counter ) . ')" >';
        $html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
        $html .= '<div class="field-holder">';
        $html .= '<strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_first_name' ) . ' *</strong>';
        $html .= '<div class="has-icon">';
        $html .= '<i class="icon-user4"></i>';
        $html .= '<input class="field-input" name="contact_name" type="text" placeholder="' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_first_name_placeholder' ) . '" required>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
        $html .= '<div class="field-holder">';
        $html .= '<strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_email' ) . ' *</strong>';
        $html .= '<div class="has-icon">';
        $html .= '<i class="icon-envelope3"></i>';
        $html .= '<input class="field-input" name="contact_email" type="text" placeholder="' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_email_address' ) . '" required>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
        $html .= '<div class="field-holder">';
        $html .= '<strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_phone_number' ) . ' </strong>';
        $html .= '<div class="has-icon">';
        $html .= '<i class="icon-phone4"></i>';
        $html .= '<input class="field-input" name="contact_number" type="text" placeholder="' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_phone_number_placeholder' ) . '">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">';
        $html .= '<div class="field-holder">';
        $html .= '<strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_last_name' ) . ' </strong>';
        $html .= '<div class="has-icon">';
        $html .= '<i class="icon-align-left2"></i>';
        $html .= '<input class="field-input" name="contact_name_last" type="text" placeholder="' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_last_name_placeholder' ) . '">';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="field-holder">';
        $html .= '<strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_message' ) . ' </strong>';
        $html .= '<div class="has-icon has-textarea">';
        $html .= '<i class="icon-new-message"></i>';
        $html .= '<textarea name="contact_msg" placeholder="' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_text_here' ) . '"></textarea>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
        $html .= '<div class="field-holder contact-btn-holder">';
			$html .= '<input class="btn-holder bgcolor" type="submit" value="' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_button_text' ) . '">';
		$html .= '</div></div>';
        $html .= '</form>';
        $html .= '</div>';

        $html .= '</div>';

        if ( isset( $column_class ) && $column_class <> '' ) {
            $html .= '</div>';
        }
        if ( function_exists( 'wp_rem_cs_var_page_builder_element_sizes' ) ) {
            $html .= '</div>';
        }
        return $html;
    }

}
if ( function_exists( 'wp_rem_cs_var_short_code' ) ) {
    wp_rem_cs_var_short_code( 'wp_rem_cs_contact_form', 'wp_rem_cs_var_contact_us_data' );
}


// Contact form submit ajax
if ( ! function_exists( 'wp_rem_cs_var_contact_submit' ) ) {

    function wp_rem_cs_var_contact_submit() {

        define( 'WP_USE_THEMES', false );
        global $abc;
        $strings = new wp_rem_cs_theme_all_strings;
        $strings->wp_rem_cs_short_code_strings();
        $strings->wp_rem_cs_theme_strings();
        $check_box = '';
        $json = array();
        $wp_rem_cs_contact_error_msg = '';
        $subject_name = '';
        foreach ( $_REQUEST as $keys => $values ) {
            $$keys = $values;
        }

        $wp_rem_cs_danger_html = '<div class="alert alert-danger"><button class="close" type="button" data-dismiss="alert" aria-hidden="true">&times;</button><p><i class="icon-warning4"></i><span>';
        $wp_rem_cs_success_html = '<div class="alert alert-success"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">&times;</button><p><i class="icon-warning4"></i><span>';
        $wp_rem_cs_msg_html = '</span></p></div>';

        $bloginfo = get_bloginfo();
        $wp_rem_cs_contactus_send = '';
        $subjecteEmail = "(" . $bloginfo . ") " . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_received' );
        if ( '' == $wp_rem_cs_contact_email || ! preg_match( '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $wp_rem_cs_contact_email ) ) {
            $json['type'] = "error";
            $json['msg'] =  esc_html( $wp_rem_cs_contact_error_msg );
        } else {
            if ( ! preg_match( '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/', $contact_email ) ) {
                $json['type'] = 'error';
                $json['msg'] = esc_html( wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_valid_email' ) );
            } else if ( $contact_email == '' ) {
                $json['type'] = "error";
                $json['msg'] = esc_html( wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_email_should_not_be_empty' ) );
            } else {
                $message = '
				<table width="100%" border="0">
				  <tr>
					<td width="100"><strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_full_name' ) . '</strong></td>
					<td>' . esc_html( $contact_name ) . '</td>
				  </tr>
				  <tr>
					<td><strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_email' ) . '</strong></td>
					<td>' . esc_html( $contact_email ) . '</td>
				  </tr>';
                if ( $contact_number != '' ) {
                    $message .= '<tr>
					<td><strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_phone_number' ) . '</strong></td>
					<td>' . esc_html( $contact_number ) . '</td>
				  </tr>';
                }
                if ( $contact_name_last != '' ) {
                    $message .= '<tr>
                    <td><strong>' . 'Subject' . '</strong></td>
                    <td>' . esc_html( $contact_name_last ) . '</td>
                  </tr>';
                }
                if ( $contact_msg != '' ) {
                    $message .= '<tr>
					<td><strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_text_here' ) . '</strong></td>
					<td>' . esc_html( $contact_msg ) . '</td>
				  </tr>';
                }
                if ( $check_box != '' ) {
                    $message .= '
				  <tr>
					<td><strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_check_field' ) . '</strong></td>
					<td>' . esc_html( $check_box ) . '</td>
				  </tr>';
                }
                $message .= '
				  <tr>
					<td><strong>' . wp_rem_cs_var_frame_text_srt( 'wp_rem_cs_var_contact_ip_address' ) . '</strong></td>
					<td>' . esc_html($_SERVER["REMOTE_ADDR"]) . '</td>
				  </tr>
				</table>';

                // $headers = 'From: "'. esc_html($contact_name) .'" <'. esc_html($contact_email) .'>' . "\r\n";
                $headers .= "Reply-To: " . esc_html($contact_email) . "\r\n";
                $headers .= "Content-type: text/html; charset=utf-8" . "\r\n";
                $headers .= "MIME-Version: 1.0" . "\r\n";
                $attachments = '';

                $respose = wp_mail( $wp_rem_cs_contact_email, $subjecteEmail, $message, $headers );
				if ( $respose ) {
                    $json['type'] = "success";
                    $json['msg'] = esc_html( $wp_rem_cs_contact_succ_msg );
                } else {
                    $json['type'] = "error";
                    $json['msg'] = esc_html( $wp_rem_cs_contact_error_msg );
                };
            }
        }
        echo json_encode( $json );
        die();
    }

}
//Submit Contact Us Form Hooks
add_action( 'wp_ajax_nopriv_wp_rem_cs_var_contact_submit', 'wp_rem_cs_var_contact_submit' );
add_action( 'wp_ajax_wp_rem_cs_var_contact_submit', 'wp_rem_cs_var_contact_submit' );