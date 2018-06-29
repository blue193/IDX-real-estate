<?php

/**
 * File Type: Register Email Templates
 */
if ( ! class_exists( 'Wp_rem_register_email_template' ) ) {

	class Wp_rem_register_email_template {

		public $email_template_type;
		public $email_default_template;
		public $email_template_variables;
		public $email_template_index;
		public $is_email_sent;
		public static $is_email_sent1;
		public $user;
		public $user_pass;
		public $template_group;

		public function __construct() {

			$this->email_template_type = 'User Register';

			$this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">User Register</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="260" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>Hello! Register Successfully. Below is your username and password.</td></tr><tr><td style="padding: 10px 0 0 0;">User Name: [REGISTER_USER_NAME]</td></tr><tr><td style="padding: 10px 0 0 0;">User Password: [REGISTER_USER_PASSWORD]</td></tr></table></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

			$this->email_template_variables = array(
				array(
					'tag' => 'REGISTER_USER_NAME',
					'display_text' => 'User Name',
					'value_callback' => array( $this, 'get_registered_user_name' ),
				),
                                array(
					'tag' => 'REGISTER_USER_EMAIL',
					'display_text' => 'User Email',
					'value_callback' => array( $this, 'get_registered_user_email' ),
				),
				array(
					'tag' => 'REGISTER_USER_PASSWORD',
					'display_text' => 'User Password',
					'value_callback' => array( $this, 'get_registered_user_passsword' ),
				),
			);
			$this->template_group = 'User';
			$this->email_template_index = 'user-register-template';
			add_action( 'init', array( $this, 'add_email_template' ), 5 );
			add_filter( 'wp_rem_email_template_settings', array( $this, 'template_settings_callback' ), 10, 1 );
			add_action( 'wp_rem_user_register', array( $this, 'member_register_callback' ), 10, 2 );
		}

		public function template_settings_callback( $email_template_options ) {

			$email_template_options["types"][] = $this->email_template_type;

			$email_template_options["templates"]["User Register"] = $this->email_default_template;

			$email_template_options["variables"]["User Register"] = $this->email_template_variables;

			return $email_template_options;
		}

		public function get_template() {
			return wp_rem::get_template( $this->email_template_index, $this->email_template_variables, $this->email_default_template );
		}

		function get_registered_user_name() {
			$user_name = $this->user->user_login;
			return $user_name;
		}

		function get_registered_user_email() {
			$user_email = $this->user->user_email;
			return $user_email;
		}

		function get_registered_user_passsword() {
			$user_password = $this->user_pass;
			return $user_password;
		}

		public function add_email_template() {
			$email_templates = array();
			$email_templates[$this->template_group] = array();
			$email_templates[$this->template_group][$this->email_template_index] = array(
				'title' => $this->email_template_type,
				'template' => $this->email_default_template,
				'email_template_type' => $this->email_template_type,
				'is_recipients_enabled' => FALSE,
				'description' => wp_rem_plugin_text_srt( 'wp_rem_register_successfully_email' ),
				'jh_email_type' => 'html',
			);
			do_action( 'wp_rem_load_email_templates', $email_templates );
		}

		public function member_register_callback( $user = '', $password = '' ) {

			$this->user = $user;
			$this->user_pass = $password;
			$template = $this->get_template();

			// checking email notification is enable/disable
			if ( isset( $template['email_notification'] ) && $template['email_notification'] == 1 ) {

				$blogname = get_option( 'blogname' );
				$admin_email = get_option( 'admin_email' );
				// getting template fields
				$subject = (isset( $template['subject'] ) && $template['subject'] != '' ) ? $template['subject'] : wp_rem_plugin_text_srt( 'wp_rem_register_successfully' );
				$from = (isset( $template['from'] ) && $template['from'] != '') ? $template['from'] : esc_attr( $blogname ) . ' <' . $admin_email . '>';
				$recipients = (isset( $template['recipients'] ) && $template['recipients'] != '') ? $template['recipients'] : $this->get_registered_user_email();
				$email_type = (isset( $template['email_type'] ) && $template['email_type'] != '') ? $template['email_type'] : 'html';

				$email_args = array(
					'to' => $recipients,
					'subject' => $subject,
					'from' => $from,
					'message' => $template['email_template'],
					'email_type' => $email_type,
					'class_obj' => $this,
				);
				do_action( 'wp_rem_send_mail', $email_args );
				wp_rem_register_email_template::$is_email_sent1 = $this->is_email_sent;
			}
		}

	}

	return new wp_rem_register_email_template();
}
