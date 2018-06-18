<?php
/**
 * New Member Notification Site Owner Email Template.
 *
 * @since 1.0
 * @package Homevillas
 */

if ( ! class_exists( 'Wp_rem_new_member_notification_site_owner_email_template' ) ) {

	class Wp_rem_new_member_notification_site_owner_email_template {

		public $email_template_type;
		public $email_default_template;
		public $email_template_variables;
		public $template_type;
		public $email_template_index;
		public $new_user_username;
		public $new_user_email;
		public $template_group;
		public $is_email_sent;

		public function __construct() {

			$this->email_template_type = 'New User Registration Email To Site Owner';

			$this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">New User Notification Site Owner</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td><p>Hello! New user registration on your site [SITE_NAME]:</p><p>Username: [NEW_USER_USERNAME] Email: [NEW_USER_EMAIL]</p></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

			$this->email_template_variables = array(
				array(
					'tag' => 'NEW_USER_USERNAME',
					'display_text' => 'New User Username',
					'value_callback' => array( $this, 'get_new_user_username' ),
				),
				array(
					'tag' => 'NEW_USER_EMAIL',
					'display_text' => 'New User Email',
					'value_callback' => array( $this, 'get_new_user_email' ),   
				),
                                array(
					'tag' => 'USER_PROFILE_TYPE',
					'display_text' => 'New User Profile Type',
					'value_callback' => array( $this, 'get_new_user_profile_type' ),   
				),
                                array(
					'tag' => 'USER_PROFILE_STATUS',
					'display_text' => 'New User Profile Status',
					'value_callback' => array( $this, 'get_new_user_profile_status' ),   
				)
			);
			$this->template_group = 'User';

			$this->email_template_index = 'new-member-notification-site-owner-template';
			add_action( 'init', array( $this, 'add_email_template' ), 5 );
			add_action( 'wp_rem_new_user_notification_site_owner', array( $this, 'new_pulisher_notification_site_owner_callback' ), 10, 2 );
			add_filter( 'wp_rem_email_template_settings', array( $this, 'template_settings_callback' ), 12, 1 );
		}

		public function new_pulisher_notification_site_owner_callback( $new_user_username = '', $new_user_email = '' ) {
			$this->new_user_username = $new_user_username;
			$this->new_user_email = $new_user_email;

			$template = $this->get_template();
			// checking email notification is enable/disable
			if ( isset( $template['email_notification'] ) && $template['email_notification'] == 1 ) {

				$blogname = get_option( 'blogname' );
				$admin_email = get_option( 'admin_email' );
				// getting template fields
				$subject = (isset( $template['subject'] ) && $template['subject'] != '' ) ? $template['subject'] : sprintf( wp_rem_plugin_text_srt( 'wp_rem_user_registration' ), $blogname );
				$from = (isset( $template['from'] ) && $template['from'] != '') ? $template['from'] : esc_attr( $blogname ) . ' <' . $admin_email . '>';
				$recipients = (isset( $template['recipients'] ) && $template['recipients'] != '') ? $template['recipients'] : $admin_email;
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

		public function template_settings_callback( $email_template_options ) {

			$email_template_options["types"][] = $this->email_template_type;

			$email_template_options["templates"][$this->email_template_type] = $this->email_default_template;

			$email_template_options["variables"][$this->email_template_type] = $this->email_template_variables;

			return $email_template_options;
		}

		public function get_template() {
			return wp_rem::get_template( $this->email_template_index, $this->email_template_variables, $this->email_default_template );
		}

		function get_new_user_username() {
			return $this->new_user_username;
		}

		function get_new_user_email() {
			return $this->new_user_email;
		}
                
                public function get_new_user_profile_type(){
                   $user = get_user_by( 'email', $this->new_user_email );
                   $user_company    = get_user_meta( $user->ID, 'wp_rem_company', true );
                   $profile_type    =  get_post_meta( $user_company, 'wp_rem_member_profile_type', true );
                   return ( $profile_type!= '' )? $profile_type : '-';
                }
                
                public function get_new_user_profile_status(){
                   $user = get_user_by( 'email', $this->new_user_email );
                   $user_company    = get_user_meta( $user->ID, 'wp_rem_company', true );
                   $profile_status  = get_post_meta( $user_company, 'wp_rem_user_status', true );
                   return ( $profile_status!= '' )? $profile_status : 'active';
                }

		public function add_email_template() {
			$email_templates = array();
			$email_templates[$this->template_group] = array();
			$email_templates[$this->template_group][$this->email_template_index] = array(
				'title' => $this->email_template_type,
				'template' => $this->email_default_template,
				'email_template_type' => $this->email_template_type,
				'is_recipients_enabled' => true,
				'description' => wp_rem_plugin_text_srt( 'wp_rem_user_registration_email' ),
				'jh_email_type' => 'html',
			);
			do_action( 'wp_rem_load_email_templates', $email_templates );
		}

	}

	new Wp_rem_new_member_notification_site_owner_email_template( '', '' );
}
