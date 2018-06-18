<?php
/**
 * Received Inquiry Email Template
 *
 * @since 1.0
 * @package	Homevillas
 */

if ( ! class_exists( 'Wp_rem_received_inquiry_email_template' ) ) {

	class Wp_rem_received_inquiry_email_template {

		public $email_template_type;
		public $email_default_template;
		public $email_template_variables;
		public $template_type;
		public $email_template_index;
		public $inquiry_id;
		public $is_email_sent;
		public static $is_email_sent1;
		public $template_group;

		public function __construct() {
			
			$this->email_template_type = 'Inquiry Received';

			$this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">Inquiry Received</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="260" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="padding-bottom:8px;">Hi, [PROPERTY_USER_NAME]</td></tr><tr><td style="padding-bottom:8px;">[INQUIRY_USER_NAME] has submitted an inquiry on your property ( <a href="[PROPERTY_LINK]">[PROPERTY_TITLE]</a> ).</td></tr><tr><td>You can see inquiry on following link:</td></tr><tr><td>[INQUIRY_LINK]</td></tr></table></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

			$this->email_template_variables = array(
				array(
					'tag' => 'INQUIRY_USER_NAME',
					'display_text' => 'Inquiry User Name',
					'value_callback' => array( $this, 'get_inquiry_user_name' ),
				),
				array(
					'tag' => 'INQUIRY_USER_EMAIL',
					'display_text' => 'Inquiry User Email',
					'value_callback' => array( $this, 'get_inquiry_user_email' ),
				),
				array(
					'tag' => 'PROPERTY_USER_NAME',
					'display_text' => 'Property User Name',
					'value_callback' => array( $this, 'get_property_user_name' ),
				),
				array(
					'tag' => 'PROPERTY_USER_EMAIL',
					'display_text' => 'Property User Email',
					'value_callback' => array( $this, 'get_property_user_email' ),
				),
				array(
					'tag' => 'PROPERTY_TITLE',
					'display_text' => 'Property Title',
					'value_callback' => array( $this, 'get_property_title' ),
				),
				array(
					'tag' => 'PROPERTY_LINK',
					'display_text' => 'Property Link',
					'value_callback' => array( $this, 'get_property_link' ),
				),
				array(
					'tag' => 'INQUIRY_NUMBER',
					'display_text' => 'Inquiry Number',
					'value_callback' => array( $this, 'get_inquiry_number' ),
				),
				array(
					'tag' => 'INQUIRY_LINK',
					'display_text' => 'Inquiry LINK',
					'value_callback' => array( $this, 'get_inquiry_link' ),
				),
				array(
					'tag' => 'INQUIRY_STATUS',
					'display_text' => 'Inquiry Status',
					'value_callback' => array( $this, 'get_inquiry_status' ),
				),
			);
			$this->template_group = 'Inquiries';

			$this->email_template_index = 'received-inquiry-template';
			add_action( 'init', array( $this, 'add_email_template' ), 5 );
			add_filter( 'wp_rem_email_template_settings', array( $this, 'template_settings_callback' ), 12, 1 );
			add_action( 'wp_rem_received_inquiry_email', array( $this, 'wp_rem_received_inquiry_email_callback' ), 10, 4 );
		}

		public function wp_rem_received_inquiry_email_callback( $inquiry_id = '' ) {
			
			$this->inquiry_id = $inquiry_id;
			$template = $this->get_template();
			// checking email notification is enable/disable
			if ( isset( $template['email_notification'] ) && $template['email_notification'] == 1 ) {

				$blogname = get_option( 'blogname' );
				$admin_email = get_option( 'admin_email' );
				// getting template fields
				$subject = (isset( $template['subject'] ) && $template['subject'] != '' ) ? $template['subject'] : wp_rem_plugin_text_srt( 'wp_rem_received_inquiry' );
				$from = (isset( $template['from'] ) && $template['from'] != '') ? $template['from'] : esc_attr( $this->get_inquiry_user_name() ) . ' <' . $this->get_inquiry_user_email() . '>';
				$recipients = (isset( $template['recipients'] ) && $template['recipients'] != '') ? $template['recipients'] : $this->get_property_user_email();
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
				Wp_rem_received_inquiry_email_template::$is_email_sent1 = $this->is_email_sent;
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
				'description' => wp_rem_plugin_text_srt( 'wp_rem_received_inquiry_email' ),
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

		function get_inquiry_user_name() {
			$inquiry_user_id   = get_post_meta( $this->inquiry_id, 'wp_rem_order_user', true );
			$inquiry_user_info = get_userdata( $inquiry_user_id );
			return $inquiry_user_info->display_name;
		}
		function get_inquiry_user_email() {
			$inquiry_user_id   = get_post_meta( $this->inquiry_id, 'wp_rem_order_user', true );
			$inquiry_user_info = get_userdata( $inquiry_user_id );
			return $inquiry_user_info->user_email;
		}
		function get_property_user_name() {
			$property_user_id   = get_post_meta( $this->inquiry_id, 'wp_rem_member', true );
			$property_user_info = get_userdata( $property_user_id );
			return $property_user_info->display_name;
		}
		function get_property_user_email() {
			$property_user_id   = get_post_meta( $this->inquiry_id, 'wp_rem_member', true );
			$property_user_info = get_userdata( $property_user_id );
			return $property_user_info->user_email;
		}
		function get_property_title() {
			$property_id   = get_post_meta( $this->inquiry_id, 'wp_rem_property_id', true );
			return esc_html( get_the_title( $property_id ) );
		}
		function get_property_link() {
			$property_id   = get_post_meta( $this->inquiry_id, 'wp_rem_property_id', true );
			return esc_url( get_permalink( $property_id ) );
		}
		function get_inquiry_number() {
			return $this->inquiry_id;
		}
		function get_inquiry_link() {
			global $wp_rem_plugin_options;
			$member_dashboard = isset( $wp_rem_plugin_options['wp_rem_member_dashboard'] ) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
			if( $member_dashboard != '' ){
				return esc_url( get_permalink( $member_dashboard )).'?dashboard=inquiries';
			}else{
				return esc_url( site_url( '/dashboard/?dashboard=inquiries' ) );
			}
		}
		function get_inquiry_status() {
			$inquiry_status = get_post_meta( $this->inquiry_id, 'wp_rem_order_status', true );
			return esc_html( $inquiry_status );
		}
		
		
	}

	new Wp_rem_received_inquiry_email_template();
}
