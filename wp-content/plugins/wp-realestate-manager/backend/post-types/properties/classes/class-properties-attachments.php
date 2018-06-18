<?php

/**
 * File Type: Near By
 */
if ( ! class_exists( 'wp_rem_attachments' ) ) {

	class wp_rem_attachments {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_filter( 'wp_rem_attachemnts_admin_fields', array( $this, 'wp_rem_attachemnts_admin_fields_callback' ), 11, 2 );
			add_action( 'wp_ajax_wp_rem_files_attachments_repeating_fields', array( $this, 'wp_rem_files_attachments_repeating_fields_callback' ), 11 );
			add_action( 'save_post', array( $this, 'wp_rem_insert_file_attachments' ), 17 );
		}

		public function wp_rem_attachemnts_admin_fields_callback( $post_id, $property_type_slug ) {
			global $wp_rem_html_fields, $post, $wp_rem_form_fields;

			$post_id = ( isset( $post_id ) && $post_id != '' ) ? $post_id : $post->ID;
			$property_type_post = get_posts( array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ) );
			$property_type_id = isset( $property_type_post[0]->ID ) ? $property_type_post[0]->ID : 0;
			$wp_rem_full_data = get_post_meta( $property_type_id, 'wp_rem_full_data', true );
			$html = '';
			
			$wp_rem_attachments = get_post_meta( $post_id, 'wp_rem_attachments', true );

			if ( ! isset( $wp_rem_full_data['wp_rem_attachments_options_element'] ) || $wp_rem_full_data['wp_rem_attachments_options_element'] != 'on' ) {
				return $html = '';
			}

			$html .= $wp_rem_html_fields->wp_rem_heading_render(
					array(
						'name' => wp_rem_plugin_text_srt( 'wp_rem_files_attachments' ),
						'cust_name' => 'files_attachments',
						'classes' => '',
						'std' => '',
						'description' => '',
						'hint' => '',
						'echo' => false,
					)
			);
			
			$html .= '<div id="form-elements">';
					$html .= '<div id="attachments_repeater_fields">';
					if ( isset( $wp_rem_attachments ) && is_array( $wp_rem_attachments ) ) {
						foreach ( $wp_rem_attachments as $attachments ) {
							$html .= $this->wp_rem_files_attachments_repeating_fields_callback( $attachments, $property_type_id );
						}
					}
					$html .= '</div>';
                                        $html .= '<div class="form-elements input-element wp-rem-form-button"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><a href="javascript:void(0);" id="click-more" class="attachments_repeater_btn wp-rem-add-more cntrl-add-new-row" data-id="attachments_repeater" property_type_id="'. $property_type_id .'">' . wp_rem_plugin_text_srt( 'wp_rem_add_attachment' ) . '</a></div></div>';
			$html .= '</div>';

			return $html;
		}

		public function wp_rem_files_attachments_repeating_fields_callback( $data = array( '' ), $property_type_id = '' ) {
			global $wp_rem_html_fields;
			if ( isset( $data ) && count( $data ) > 0 ) {
				extract( $data );
			}
			
			$property_type_id = isset($_POST['property_type_id']) ? $_POST['property_type_id'] : $property_type_id;
			$allowd_attachment_extensions = get_post_meta($property_type_id, 'wp_rem_property_allowd_attachment_extensions', true);
			$allowd_attachment_extensions = isset($allowd_attachment_extensions) ? $allowd_attachment_extensions : '';
			if (isset($allowd_attachment_extensions) && $allowd_attachment_extensions != '') {
				$allowd_attachment_extensions = implode(',', $allowd_attachment_extensions);
			}

			$html = '';
			$rand = mt_rand( 10, 200 );

			$html .= '<div id="attachments_repeater" style="display:block;" class="wp-rem-repeater-form">';
                        
                        $html .= '<a href="javascript:void(0);" class="wp-rem-element-remove"><i class="icon-close2"></i></a>';
			
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt( 'wp_rem_attachment_title' ),
				'desc' => '',
				'hint_text' => '',
				'echo' => false,
				'field_params' => array(
					'usermeta' => true,
					'std' => ( isset( $attachment_title ) ) ? $attachment_title : '',
					'id' => 'attachment_title' . $rand,
					'cust_name' => 'wp_rem_attachments[title][]',
					'classes' => 'repeating_field wp-rem-dev-req-field-admin',
					'return' => true,
				),
			);

			$html .= $wp_rem_html_fields->wp_rem_text_field( $wp_rem_opt_array );
			
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt( 'wp_rem_attachment_file' ),
				'desc' => '<span class="wp_rem_attachment_file' . $rand.'_rand_allowed_extensions">'. wp_rem_plugin_text_srt( 'wp_rem_attachment_allowed_formats' ). str_replace(',', ', ', $allowd_attachment_extensions) .'</span>',
				'hint_text' => '',
				'id' => 'attachment_file' . $rand,
				'force_std' => true,
				'std' => ( isset( $attachment_file ) ? $attachment_file : '' ),
				'field_params' => array(
					'id' => 'attachment_file' . $rand,
					'cust_name' => 'wp_rem_attachments[file][]',
					'return' => true,
					'force_std' => true,
					'allowd_extensions' => $allowd_attachment_extensions,
					'std' => ( isset( $attachment_file ) ? $attachment_file : '' ),
				),
			);
			$html .= $wp_rem_html_fields->wp_rem_upload_attachment_file_field( $wp_rem_opt_array );
                        
			//$html .= '<div class="remove_field" data-id="attachments_repeater">'. wp_rem_plugin_text_srt( 'wp_rem_attachment_remove' ).'</div>';
			$html .= '</div>';
			if ( NULL != wp_rem_get_input( 'ajax', NULL ) && wp_rem_get_input( 'ajax' ) == 'true' ) {
				echo force_balance_tags( $html );
			} else {
				return $html;
			}

			if ( NULL != wp_rem_get_input( 'die', NULL ) && wp_rem_get_input( 'die' ) == 'true' ) {
				die();
			}
		}

		public function wp_rem_insert_file_attachments( $post_id ) {
			if ( get_post_type( $post_id ) == 'properties' ) {
				if ( ! isset( $_POST['wp_rem_attachments']['file'] ) || count( $_POST['wp_rem_attachments']['file'] ) < 1 ) {
					delete_post_meta( $post_id, 'wp_rem_attachments' );
				}
			}
			if ( isset( $_POST['wp_rem_attachments']['file'] ) && count( $_POST['wp_rem_attachments']['file'] ) > 0 ) {
				foreach ( $_POST['wp_rem_attachments']['file'] as $key => $attachment ) {
					if ( count( $attachment ) > 0 ) {
						$attachment_array[] = array(
							'attachment_title' => $_POST['wp_rem_attachments']['title'][$key],
							'attachment_file' => $attachment
						);
					}
				}
				update_post_meta( $post_id, 'wp_rem_attachments', $attachment_array );
			}
		}

	}

	global $wp_rem_attachments;
	$wp_rem_attachments = new wp_rem_attachments();
}