<?php
/**
 * Arrange Viewing Status Update Email Template
 *
 * @since 1.0
 * @package	Homevillas
 */

if ( ! class_exists( 'Wp_rem_arrange_viewing_status_updated_email_template' ) ) {

	class Wp_rem_arrange_viewing_status_updated_email_template {

		public $email_template_type;
		public $email_default_template;
		public $email_template_variables;
		public $template_type;
		public $email_template_index;
		public $viewing_id;
		public $is_email_sent;
		public static $is_email_sent1;
		public $template_group;

		public function __construct() {
			
			$this->email_template_type = 'Arrange Viewing Status Updated';

			$this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" barrange_viewing="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">Arrange Viewing Status Updated</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table barrange_viewing="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="260" valign="top"><table barrange_viewing="0" cellpadding="0" cellspacing="0" width="100%"><tr><td style="padding-bottom:8px;">Hi, [ARRANGE_VIEWING_USER_NAME]</td></tr><tr><td style="padding-bottom:8px;">Your arrange viewing is [ARRANGE_VIEWING_STATUS] on "[PROPERTY_TITLE]" property.</td></tr><tr><td>You can see arrange viewing on following link:</td></tr><tr><td>[ARRANGE_VIEWING_LINK]</td></tr></table></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table barrange_viewing="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

			$this->email_template_variables = array(
				array(
					'tag' => 'ARRANGE_VIEWING_USER_NAME',
					'display_text' => 'Arrange Viewing User Name',
					'value_callback' => array( $this, 'get_arrange_viewing_user_name' ),
				),
				array(
					'tag' => 'ARRANGE_VIEWING_USER_EMAIL',
					'display_text' => 'Arrange Viewing User Email',
					'value_callback' => array( $this, 'get_arrange_viewing_user_email' ),
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
					'tag' => 'ARRANGE_VIEWING_NUMBER',
					'display_text' => 'Arrange Viewing Number',
					'value_callback' => array( $this, 'get_arrange_viewing_number' ),
				),
				array(
					'tag' => 'ARRANGE_VIEWING_LINK',
					'display_text' => 'Arrange Viewing LINK',
					'value_callback' => array( $this, 'get_arrange_viewing_link' ),
				),
				array(
					'tag' => 'ARRANGE_VIEWING_STATUS',
					'display_text' => 'Arrange Viewing Status',
					'value_callback' => array( $this, 'get_arrange_viewing_status' ),
				),
			);
			$this->template_group = 'Viewings';

			$this->email_template_index = 'arrange-viewings-status-updated-template';
			add_action( 'init', array( $this, 'add_email_template' ), 5 );
			add_filter( 'wp_rem_email_template_settings', array( $this, 'template_settings_callback' ), 12, 1 );
			add_action( 'wp_rem_viewing_status_updated_email', array( $this, 'wp_rem_viewing_status_updated_email_callback' ), 10, 4 );
		}

		public function wp_rem_viewing_status_updated_email_callback( $viewing_id = '' ) {
			
			$this->viewing_id = $viewing_id;
			$template = $this->get_template();
			// checking email notification is enable/disable
			if ( isset( $template['email_notification'] ) && $template['email_notification'] == 1 ) {

				$blogname = get_option( 'blogname' );
				$admin_email = get_option( 'admin_email' );
				// getting template fields
				$subject = (isset( $template['subject'] ) && $template['subject'] != '' ) ? $template['subject'] : wp_rem_plugin_text_srt( 'wp_rem_update_arrange_viewing_status' );
				$from = (isset( $template['from'] ) && $template['from'] != '') ? $template['from'] : esc_attr( $this->get_property_user_name() ) . ' <' . $this->get_property_user_email() . '>';
				$recipients = (isset( $template['recipients'] ) && $template['recipients'] != '') ? $template['recipients'] : $this->get_arrange_viewing_user_email();
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
				Wp_rem_arrange_viewing_status_updated_email_template::$is_email_sent1 = $this->is_email_sent;
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
				'description' => wp_rem_plugin_text_srt( 'wp_rem_update_arrange_viewing_email' ),
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

		function get_arrange_viewing_user_name() {
			$arrange_viewing_user_id   = get_post_meta( $this->viewing_id, 'wp_rem_viewing_user', true );
			$arrange_viewing_user_info = get_userdata( $arrange_viewing_user_id );
			return $arrange_viewing_user_info->display_name;
		}
		function get_arrange_viewing_user_email() {
			$arrange_viewing_user_id   = get_post_meta( $this->viewing_id, 'wp_rem_viewing_user', true );
			$arrange_viewing_user_info = get_userdata( $arrange_viewing_user_id );
			return $arrange_viewing_user_info->user_email;
		}
		function get_property_user_name() {
			$property_user_id   = get_post_meta( $this->viewing_id, 'wp_rem_property_user', true );
			$property_user_info = get_userdata( $property_user_id );
			return $property_user_info->display_name;
		}
		function get_property_user_email() {
			$property_user_id   = get_post_meta( $this->viewing_id, 'wp_rem_property_user', true );
			$property_user_info = get_userdata( $property_user_id );
			return $property_user_info->user_email;
		}
		function get_property_title() {
			$property_id   = get_post_meta( $this->viewing_id, 'wp_rem_property_id', true );
			return esc_html( get_the_title( $property_id ) );
		}
		function get_property_link() {
			$property_id   = get_post_meta( $this->viewing_id, 'wp_rem_property_id', true );
			return esc_url( get_permalink( $property_id ) );
		}
		function get_arrange_viewing_number() {
			return $this->viewing_id;
		}
		function get_arrange_viewing_link() {
			global $wp_rem_plugin_options;
			$member_dashboard = isset( $wp_rem_plugin_options['wp_rem_member_dashboard'] ) ? $wp_rem_plugin_options['wp_rem_member_dashboard'] : '';
			if( $member_dashboard != '' ){
				return esc_url( get_permalink( $member_dashboard )).'?dashboard=viewings';
			}else{
				return esc_url( site_url( '/dashboard/?dashboard=viewings' ) );
			}
		}
		function get_arrange_viewing_status() {
			$arrange_viewing_status = get_post_meta( $this->viewing_id, 'wp_rem_viewing_status', true );
			return esc_html( $arrange_viewing_status );
		}
		
		
	}

	new Wp_rem_arrange_viewing_status_updated_email_template();
}
