<?php

/**
 * User Approved Email Template
 *
 * @since 1.0
 * @package	Homevillas
 */
if ( ! class_exists( 'Wp_rem_approved_member_profile_template' ) ) {

	class Wp_rem_approved_member_profile_template {

		public $email_template_type;
		public $email_default_template;
		public $email_template_variables;
		public $template_type;
		public $email_template_index;
		public $template_group;
		public $member_id;
		public $is_email_sent;

		public function __construct() {

			$this->email_template_type = 'Approved Member Profile';
			$this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">Approved Member Profile</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td><p>Hello [MEMBER_NAME]! Your profile has been approved successfully.</p></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

			$this->email_template_variables = array(
				array(
					'tag' => 'MEMBER_NAME',
					'display_text' => 'Member Name',
					'value_callback' => array( $this, 'get_approved_member_name' ),
				),
                                array(
					'tag' => 'USER_EMAIL',
					'display_text' => 'User Email',
					'value_callback' => array( $this, 'get_approved_member_email' ),
				),
                                array(
					'tag' => 'USER_NAME',
					'display_text' => 'Username',
					'value_callback' => array( $this, 'get_approved_member_username' ),
				),
                                array(
					'tag' => 'USER_PASSWORD',
					'display_text' => 'User Password',
					'value_callback' => array( $this, 'get_approved_member_password' ),
				),
			);
			$this->template_group = 'User';
			$this->email_template_index = 'approved-member-profile-template';

			add_filter( 'wp_rem_email_template_settings', array( $this, 'template_settings_callback' ), 12, 1 );

			// Add action user status callback
			add_action( 'wp_rem_profile_status_changed', array( $this, 'member_profile_status_changed' ), 10, 2 );

			add_action( 'init', array( $this, 'add_email_template' ), 5 );
		}

		public function template_settings_callback( $email_template_options ) {

			$email_template_options["types"][] = $this->email_template_type;

			$email_template_options["templates"][$this->email_template_type] = $this->email_default_template;

			$email_template_options["variables"][$this->email_template_type] = $this->email_template_variables;

			return $email_template_options;
		}

		public function get_template() {
			return wp_rem::get_template( $this->email_template_index, $this->email_template_variables, $this->email_default_template );
		}

		function get_approved_member_name() {
			$member_info = get_user_by( 'id', $this->member_id );
			return $member_info->display_name;
		}

		function get_approved_member_email() {
			$member_info = get_user_by( 'id', $this->member_id );
			return $member_info->user_email;
		}
                
                function get_approved_member_username(){
                        $member_info = get_user_by( 'id', $this->member_id );
			return $member_info->user_nicename;
                }
                
                function get_approved_member_password(){
                    $user_info = get_userdata( $this->member_id );
                    return $user_info->user_pass;
                }

		public function member_profile_status_changed( $member_id, $member_old_status ) {

			if ( $member_id != '' ) {

				$this->member_id = $member_id;
				$member = new WP_User( $member_id );
				$role = array_shift( $member->roles );
				// checking member role
				if ( $role == 'wp_rem_member' ) {
					// getting pulbisher status
					$member_status = get_user_meta( $member_id, 'wp_rem_user_status', true );

					
					// checking user status
					if ( $member_status == 'active' && $member_status != $member_old_status ) {

						$template = $this->get_template();

						// checking email notification is enable/disable
						if ( isset( $template['email_notification'] ) && $template['email_notification'] == 1 ) {

							$blogname = get_option( 'blogname' );
							$admin_email = get_option( 'admin_email' );
							// getting template fields
							$subject = (isset( $template['subject'] ) && $template['subject'] != '' ) ? $template['subject'] : wp_rem_plugin_text_srt( 'wp_rem_approved_member' );
							$from = (isset( $template['from'] ) && $template['from'] != '') ? $template['from'] : esc_attr( $blogname ) . ' <' . $admin_email . '>';
							$recipients = (isset( $template['recipients'] ) && $template['recipients'] != '') ? $template['recipients'] : $this->get_approved_member_email();
							$email_type = (isset( $template['email_type'] ) && $template['email_type'] != '') ? $template['email_type'] : 'html';

							$args = array(
								'to' => $recipients,
								'subject' => $subject,
								'from' => $from,
								'message' => $template['email_template'],
								'email_type' => $email_type,
							);
							
							do_action( 'wp_rem_send_mail', $args );
						}
					}
				}
			}
		}

		public function add_email_template() {
			$email_templates = array();
			$email_templates[$this->template_group] = array();
			$email_templates[$this->template_group][$this->email_template_index] = array(
				'title' => $this->email_template_type,
				'template' => $this->email_default_template,
				'email_template_type' => $this->email_template_type,
				'is_recipients_enabled' => false,
				'description' => wp_rem_plugin_text_srt( 'wp_rem_approved_member_email' ),
				'jh_email_type' => 'html',
			);
			do_action( 'wp_rem_load_email_templates', $email_templates );
		}

	}

	new wp_rem_approved_member_profile_template();
}