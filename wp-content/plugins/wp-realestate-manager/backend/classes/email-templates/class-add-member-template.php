<?php
/**
 * Add Member Email Template.
 *
 * @since 1.0
 * @package	Homevillas
 */

if ( ! class_exists( 'Wp_rem_add_member_email_template' ) ) {

	class Wp_rem_add_member_email_template {

		public $email_template_type;
		public $email_default_template;
		public $email_template_variables;
		public $template_type;
		public $email_template_index;
		public $user;
		public $user_name;
		public $user_email;
		public $user_password;
		public $user_type;
		public $user_permissions;
		public $member_first_name;
		public $member_last_name;
		public $member_user_email;
		public $is_email_sent;
		public static $is_email_sent1;
		public $template_group;

		public function __construct() {
			$this->user = array();
			$this->email_template_type = 'Add Member Email Template';

			$this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">Account Created</h1></td></tr><tr><td style="padding: 40px 30px 40px 30px;" bgcolor="#ffffff"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td valign="top" width="260"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td>Hello and Welcome!<br>You account has been created as [USER_TYPE] by [MEMBER_FULL_NAME].<br>Here are the details for you account.<br>Username: [USER_NAME]<br>Password: [USER_PASSWORD]<br>Type: [USER_TYPE]<br>Permissions: [USER_PERMISSIONS]</td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;"> [SITE_NAME], 2017</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

			$this->email_template_variables = array(
				array(
					'tag' => 'USER_NAME',
					'display_text' => 'Newly Added User Name',
					'value_callback' => array( $this, 'get_user_name' ),
				),
                                array(
					'tag' => 'USER_EMAIL',
					'display_text' => 'Newly Added User Email',
					'value_callback' => array( $this, 'get_user_email' ),
				),
				array(
					'tag' => 'USER_PASSWORD',
					'display_text' => 'Newly Added User Password',
					'value_callback' => array( $this, 'get_user_password' ),
				),
                                array(
					'tag' => 'USER_TYPE',
					'display_text' => 'Newly Added User Type',
					'value_callback' => array( $this, 'get_user_type' ),
				),
				array(
					'tag' => 'USER_PERMISSIONS',
					'display_text' => 'Newly Added User Permissions',
					'value_callback' => array( $this, 'get_user_permissions' ),
				),
                                array(
					'tag' => 'MEMBER_FULL_NAME',
					'display_text' => 'Member Full Name',
					'value_callback' => array( $this, 'get_member_full_name' ),
				),
                                array(
					'tag' => 'MEMBER_USER_EMAIL',
					'display_text' => 'Member User Email',
					'value_callback' => array( $this, 'get_member_user_email' ),
				),
                                
			);
			$this->template_group = 'Member';

			$this->email_template_index = 'add-member-email-template';
			add_action( 'init', array( $this, 'add_email_template' ), 5 );
			add_filter( 'wp_rem_email_template_settings', array( $this, 'template_settings_callback' ), 12, 1 );
			add_action( 'wp_rem_add_member_email', array( $this, 'wp_rem_add_member_email_callback' ), 10, 1 );
		}

		public function wp_rem_add_member_email_callback( $data_array ) {
			
                        $this->user_name        = isset( $data_array['user_name'] ) ? $data_array['user_name'] : '';
                        $this->user_email       = isset( $data_array['user_email'] ) ? $data_array['user_email'] : '';
                        $this->user_password    = isset( $data_array['user_password'] ) ? $data_array['user_password'] : '';
                        $this->user_type        = isset( $data_array['user_type'] ) ? $data_array['user_type'] : '';
                        $this->user_permissions = isset( $data_array['user_permissions'] ) ? $data_array['user_permissions'] : '';
                        $this->member_first_name   = isset( $data_array['member_first_name'] ) ? $data_array['member_first_name'] : '';
                        $this->member_last_name   = isset( $data_array['member_last_name'] ) ? $data_array['member_last_name'] : '';
                        $this->member_user_email  = isset( $data_array['member_user_email'] ) ? $data_array['member_user_email'] : '';
                    
			$template = $this->get_template();
			// checking email notification is enable/disable
			if ( isset( $template['email_notification'] ) && $template['email_notification'] == 1 ) {

				$blogname = get_option( 'blogname' );
				$admin_email = get_option( 'admin_email' );
				// getting template fields
				$subject = (isset( $template['subject'] ) && $template['subject'] != '' ) ? $template['subject'] : wp_rem_plugin_text_srt( 'wp_rem_account_created' );
				$from = (isset( $template['from'] ) && $template['from'] != '') ? $template['from'] : esc_attr( $blogname ) . ' <' . $admin_email . '>';
				$recipients = (isset( $template['recipients'] ) && $template['recipients'] != '') ? $this->user_email.','.$template['recipients'] : $this->user_email.','.$admin_email;
				$email_type = (isset( $template['email_type'] ) && $template['email_type'] != '') ? $template['email_type'] : 'html';

				$args = array(
					'to' => $recipients,
					'subject' => $subject,
					'from' => $from,
					'message' => $template['email_template'],
					'email_type' => $email_type,
					'class_obj' => $this,
				);
                                
				do_action( 'wp_rem_send_mail', $args );
				Wp_rem_add_member_email_template::$is_email_sent1 = $this->is_email_sent;
			}
		}

		public function add_email_template() {
			$email_templates = array();
			$email_templates[$this->template_group] = array();
			$email_templates[$this->template_group][$this->email_template_index] = array(
				'title' => $this->email_template_type,
				'template' => $this->email_default_template,
				'email_template_type' => $this->email_template_type,
				'is_recipients_enabled' => TRUE,
				'description' => wp_rem_plugin_text_srt( 'wp_rem_account_created_email' ),
				'jh_email_type' => 'html',
			);
			do_action( 'wp_rem_load_email_templates', $email_templates );
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
		function get_user_name() {
			$return_value = $this->user_name;
			return $return_value;
		}
                function get_user_email() {
			$return_value = $this->user_email;
			return $return_value;
		}
                function get_user_password() {
			$return_value = $this->user_password;
			return $return_value;
		}
                function get_user_type() {
			$return_value = $this->user_type;
                        $return_value = str_replace( '_', ' ', $return_value );
                        $return_value = str_replace( '-', ' ', $return_value );
			return ucwords( $return_value );
		}
                function get_user_permissions() {
			$return_value = $this->user_permissions;
                        $permission = '';
                        if( !empty( $return_value ) ){
                            foreach( $return_value as $key => $value ){
                                $key = str_replace( '_', ' ', $key );
                                $key = str_replace( '-', ' ', $key );
                                $permission .= ' [ '.ucwords( $key ).' ] ';
                            }
                        }
			return $permission;
		}
                function get_member_full_name() {
			$return_value = $this->member_first_name.' '.$this->member_last_name;
			return $return_value;
		}
                function get_member_user_email() {
			$return_value = $this->member_user_email;
			return $return_value;
		}

	}

	new Wp_rem_add_member_email_template();
}