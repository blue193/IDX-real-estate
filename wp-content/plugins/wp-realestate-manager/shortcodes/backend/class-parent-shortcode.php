<?php

/**
 * File Type: About Shortcode
 */
if ( ! class_exists('Wp_rem_Shortcodes') ) {

	class Wp_rem_Shortcodes {

		protected $title = 'title';
		protected $sub_title = 'Sub Title';
		protected $save_text = 'save';

		public function __construct() {
			add_action('directyory_common_title', array( $this, 'directyory_common_title_call_back' ));
			add_action('directyory_common_save_btn', array( $this, 'directyory_common_save_btn_call_back' ));
		}

		protected function directyory_common_title_call_back($title) {
			global $post, $wp_rem_html_fields, $wp_rem_form_fields;
			$this->title = $title;
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt('wp_rem_element_title'),
				'desc' => '',
				'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_title_hint'),
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => $this->title,
					'cust_name' => $this->title . '[]',
					'return' => true,
				),
			);
			$wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
		}

		protected function directyory_common_subtitle_call_back($sub_title) {
			global $post, $wp_rem_html_fields, $wp_rem_form_fields;
			// $wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
			$this->sub_title = $sub_title;
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt('wp_rem_element_sub_title'),
				'desc' => '',
				'label_desc' => wp_rem_plugin_text_srt('wp_rem_element_sub_title_hint'),
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => $this->sub_title,
					'cust_name' => $this->sub_title . '[]',
					'return' => true,
				),
			);
			$wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
		}

		protected function directyory_common_save_btn_call_back($ave_text) {
			$this->save_text = $ave_text;
			$wp_rem_opt_array = array(
				'name' => '',
				'desc' => '',
				'label_desc' => '',
				'echo' => true,
				'field_params' => array(
					'std' => wp_rem_plugin_text_srt('wp_rem_save'),
					'cust_id' => '',
					'cust_type' => 'button',
					'classes' => 'cs-admin-btn',
					'cust_name' => '',
					'extra_atr' => 'onclick="javascript:_removerlay(jQuery(this))"',
					'return' => true,
				),
			);

			$wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
		}

	}

}
