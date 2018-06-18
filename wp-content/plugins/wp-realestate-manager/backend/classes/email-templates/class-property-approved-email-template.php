<?php
/**
 * Property Approved Email Template
 *
 * @since 1.0
 * @package	Homevillas
 */

if ( ! class_exists( 'Wp_rem_property_approved_email_template' ) ) {

	class Wp_rem_property_approved_email_template {
		
		public $email_template_type;
		public $email_default_template;
		public $email_template_variables;
		public $template_type;
		public $email_template_index;
		public $user;
		public $property_id;
		public $is_email_sent;
		public static $is_email_sent1;
		public $template_group;
		

		public function __construct() {

			$this->email_template_type = 'Property Approved Email Template';
			$this->email_default_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /><meta name="viewport" content="width=device-width, initial-scale=1.0"/></head><body style="margin: 0; padding: 0;"><div style="background-color: #eeeeef; padding: 50px 0;"><table style="max-width: 640px;" border="0" cellspacing="0" cellpadding="0" align="center"><tbody><tr><td style="padding: 40px 30px 30px 30px;" align="center" bgcolor="#33333e"><h1 style="color: #fff;">Property Approved Email Template</h1></td></tr><tr><td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td width="260" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td>Hello [PROPERTY_USER_NAME]! Your Property "[PROPERTY_TITLE]" has been approved.</td></tr><tr><td style="padding: 10px 0 0 0;">[PROPERTY_LINK]</td></tr></table></td></tr></table></td></tr><tr><td style="background-color: #ffffff; padding: 30px 30px 30px 30px;"><table border="0" width="100%" cellspacing="0" cellpadding="0"><tbody><tr><td style="font-family: Arial, sans-serif; font-size: 14px;">&reg; [SITE_NAME], 2016</td></tr></tbody></table></td></tr></tbody></table></div></body></html>';

			$this->email_template_variables = array(
				
				array(
					'tag' => 'PROPERTY_TITLE',
					'display_text' => 'Property Title',
					'value_callback' => array( $this, 'get_property_approved_title' ),
				),
				array(
					'tag' => 'PROPERTY_LINK',
					'display_text' => 'Property Link',
					'value_callback' => array( $this, 'get_property_approved_link' ),
				),
                                array(
					'tag' => 'PROPERTY_TYPE',
					'display_text' => 'Property Type',
					'value_callback' => array( $this, 'get_property_added_type' ),
				),
                                array(
					'tag' => 'PROPERTY_PRICE',
					'display_text' => 'Property Price',
					'value_callback' => array( $this, 'get_property_added_price' ),
				),
                                array(
					'tag' => 'PROPERTY_EMAIL',
					'display_text' => 'Property Email',
					'value_callback' => array( $this, 'get_property_added_property_email' ),
				),
                                array(
					'tag' => 'PROPERTY_PHONE',
					'display_text' => 'Property Phone Number',
					'value_callback' => array( $this, 'get_property_added_phone' ),
				),
                                array(
					'tag' => 'PROPERTY_ADDRESS',
					'display_text' => 'Property Address',
					'value_callback' => array( $this, 'get_property_added_address' ),
				),
                                array(
					'tag' => 'PROPERTY_USER_NAME',
					'display_text' => 'Property User Name',
					'value_callback' => array( $this, 'get_property_approved_user_name' ),
				),
				array(
					'tag' => 'PROPERTY_USER_EMAIL',
					'display_text' => 'Property User Email',
					'value_callback' => array( $this, 'get_property_approved_user_email' ),
				),
			);

			$this->template_group = 'Property';
			$this->email_template_index = 'property-approved-template';

			add_filter( 'wp_rem_email_template_settings', array( $this, 'template_settings_callback' ), 12, 1 );

			// Add action property status callback
			add_action( 'wp_rem_property_approved_email', array( $this, 'property_status_changed_callback' ), 10, 2 );
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

		function get_property_approved_user_name() {
			$user_name = $this->user->display_name;
			return $user_name;
		}

		function get_property_approved_user_email() {
			$email = $this->user->user_email;
			return $email;
		}

		function get_property_approved_title() {
			return get_the_title( $this->property_id );
		}

		function get_property_approved_link() {
			return esc_url( get_permalink( $this->property_id ) );
		}
                
                function get_property_added_type(){
                    $response   = get_post_meta( $this->property_id, 'wp_rem_property_type', true );
                    return ( $response!= '' )? $response : '-';
                }
                
                function get_property_added_price(){
                    $response   = get_post_meta( $this->property_id, 'wp_rem_property_price', true );
                    return ( $response!= '' )? $response : '-';
                }
                
                function get_property_added_property_email(){
                    $response   = get_post_meta( $this->property_id, 'wp_rem_property_contact_email', true );
                    return ( $response!= '' )? $response : '-';
                }
                
                function get_property_added_phone(){
                    $response   = get_post_meta( $this->property_id, 'wp_rem_property_contact_phone', true );
                    return ( $response!= '' )? $response : '-';
                }
                
                function get_property_added_address(){
                    $response   = get_post_meta( $this->property_id, 'wp_rem_post_loc_address_property', true );
                    return ( $response!= '' )? $response : '-';
                }

		public function property_status_changed_callback( $user, $property_id ) {

			if ( $property_id != '' ) {
				
				$this->user = $user;

				$this->property_id = $property_id;

				$template = $this->get_template();
				
				// checking email notification is enable/disable
				if ( isset( $template['email_notification'] ) && $template['email_notification'] == 1 ) {

					$blogname = get_option( 'blogname' );
					$admin_email = get_option( 'admin_email' );
					// getting template fields
					$subject = (isset( $template['subject'] ) && $template['subject'] != '' ) ? $template['subject'] : wp_rem_plugin_text_srt( 'wp_rem_property_approved' );
					$from = (isset( $template['from'] ) && $template['from'] != '') ? $template['from'] : esc_attr( $blogname ) . ' <' . $admin_email . '>';
					$recipients = (isset( $template['recipients'] ) && $template['recipients'] != '') ? $template['recipients'] : $this->get_property_approved_user_email();
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

		public function add_email_template() {
			$email_templates = array();
			$email_templates[$this->template_group] = array();
			$email_templates[$this->template_group][$this->email_template_index] = array(
				'title' => $this->email_template_type,
				'template' => $this->email_default_template,
				'email_template_type' => $this->email_template_type,
				'is_recipients_enabled' => true,
				'description' => wp_rem_plugin_text_srt( 'wp_rem_property_approved_email' ),
				'jh_email_type' => 'html',
			);
			do_action( 'wp_rem_load_email_templates', $email_templates );
		}

	}

	new Wp_rem_property_approved_email_template();
}