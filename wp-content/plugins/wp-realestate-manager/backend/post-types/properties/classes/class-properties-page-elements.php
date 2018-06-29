<?php

/**
 * File Type: Opening Hours
 */
if ( ! class_exists('wp_rem_page_elements') ) {

	class wp_rem_page_elements {

		/**
		 * Start construct Functions
		 */
		public function __construct() {
			add_filter('wp_rem_page_elements_admin_fields', array( $this, 'wp_rem_page_elements_admin_fields_callback' ), 11, 2);
		}

		public function wp_rem_page_elements_admin_fields_callback($post_id, $property_type_slug) {
			global $wp_rem_html_fields, $post;

			$post_id = ( isset($post_id) && $post_id != '' ) ? $post_id : $post->ID;
			$property_type_post = get_posts(array( 'posts_per_page' => '1', 'post_type' => 'property-type', 'name' => "$property_type_slug", 'post_status' => 'publish' ));
			$property_type_id = isset($property_type_post[0]->ID) ? $property_type_post[0]->ID : 0;
			$wp_rem_full_data = get_post_meta($property_type_id, 'wp_rem_full_data', true);
			$html = '';

			$html .= $wp_rem_html_fields->wp_rem_heading_render(
					array(
						'name' => wp_rem_plugin_text_srt('wp_rem_property_page_elements'),
						'cust_name' => 'page_elements',
						'classes' => '',
						'std' => '',
						'description' => '',
						'hint' => '',
						'echo' => false,
					)
			);

			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt('wp_rem_property_page_inquire_form'),
				'desc' => '',
				'hint_text' => '',
				'echo' => false,
				'field_params' => array(
					'std' => '',
					'id' => 'inquiry_form',
					'return' => true,
				),
			);
			$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt('wp_rem_property_page_financing_calculator'),
				'desc' => '',
				'hint_text' => '',
				'echo' => false,
				'field_params' => array(
					'std' => '',
					'id' => 'financing_calculator',
					'return' => true,
				),
			);
			$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

			if ( isset($wp_rem_full_data['wp_rem_report_spams_element']) && $wp_rem_full_data['wp_rem_report_spams_element'] == 'on' ) {

				$wp_rem_opt_array = array(
					'name' => wp_rem_plugin_text_srt('wp_rem_property_page_report_spams'),
					'desc' => '',
					'hint_text' => '',
					'echo' => false,
					'field_params' => array(
						'std' => '',
						'id' => 'report_spams',
						'return' => true,
					),
				);
				$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
			}
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt('wp_rem_property_page_similar_posts'),
				'desc' => '',
				'hint_text' => '',
				'echo' => false,
				'field_params' => array(
					'std' => '',
					'id' => 'similar_posts',
					'return' => true,
				),
			);
			$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt('wp_rem_property_page_featured_property_image'),
				'desc' => '',
				'hint_text' => '',
				'echo' => false,
				'field_params' => array(
					'std' => '',
					'id' => 'featured_property_image',
					'return' => true,
				),
			);
			$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);

			if ( isset($wp_rem_full_data['wp_rem_claim_property_element']) && $wp_rem_full_data['wp_rem_claim_property_element'] == 'on' ) {

				$wp_rem_opt_array = array(
					'name' => wp_rem_plugin_text_srt('wp_rem_property_page_claim_property'),
					'desc' => '',
					'hint_text' => '',
					'echo' => false,
					'field_params' => array(
						'std' => '',
						'id' => 'claim_property',
						'return' => true,
					),
				);
				$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
			}

			if ( isset($wp_rem_full_data['wp_rem_social_share_element']) && $wp_rem_full_data['wp_rem_social_share_element'] == 'on' ) {

				$wp_rem_opt_array = array(
					'name' => wp_rem_plugin_text_srt('wp_rem_property_page_social_share'),
					'desc' => '',
					'hint_text' => '',
					'echo' => false,
					'field_params' => array(
						'std' => '',
						'id' => 'social_share',
						'return' => true,
					),
				);
				$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
			}

			if ( isset($wp_rem_full_data['wp_rem_user_reviews']) && $wp_rem_full_data['wp_rem_user_reviews'] == 'on' ) {

				$wp_rem_opt_array = array(
					'name' => wp_rem_plugin_text_srt('wp_rem_property_page_review_ratings'),
					'desc' => '',
					'hint_text' => '',
					'echo' => false,
					'field_params' => array(
						'std' => '',
						'id' => 'reivew_ratings',
						'return' => true,
					),
				);
				$html .= $wp_rem_html_fields->wp_rem_checkbox_field($wp_rem_opt_array);
			}

			return $html;
		}

	}

	global $wp_rem_page_elements;
	$wp_rem_page_elements = new wp_rem_page_elements();
}