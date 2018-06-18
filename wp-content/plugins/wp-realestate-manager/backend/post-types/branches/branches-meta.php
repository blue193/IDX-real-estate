<?php
/**
 * @Add Meta Box For Properties Post
 * @return
 *
 */
if ( ! class_exists('wp_rem_branch_meta') ) {

	class wp_rem_branch_meta {

		var $html_data = '';

		public function __construct() {
			add_action('add_meta_boxes', array( $this, 'wp_rem_meta_branches_add' ));
		}
		function wp_rem_meta_branches_add() {
			add_meta_box('wp_rem_meta_branches', wp_rem_plugin_text_srt('wp_rem_branch_options'), array( $this, 'wp_rem_meta_branches' ), 'branches', 'normal', 'high');
		}

		/**
		 * Start Function How to Attach mata box with post
		 */
		function wp_rem_meta_branches($post) {
			global $post, $wp_rem_form_fields, $wp_rem_form_fields, $wp_rem_html_fields, $wp_rem_plugin_options;
			
			
			$args = array(
				'post_type' => 'members',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'fields' => 'ids',
				'meta_query' =>
				array(
					array(
						'relation' => 'AND',
						array(
							'key' => 'wp_rem_user_status',
							'value' => 'active',
							'compare' => '=',
						),
					)
				)
			);
			$members = get_posts($args);
			$wp_rem_member_list = array();
			if( !empty($members)){
				foreach( $members as $member ){
					$wp_rem_member_list[$member] = esc_html(get_the_title($member));
				}
			}
			wp_reset_postdata();
			
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt( 'wp_rem_branches_member' ),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'branch_member',
					'classes' => 'chosen-select-no-single',
					'options' => $wp_rem_member_list,
					'return' => true,
				),
			);
			$wp_rem_html_fields->wp_rem_select_field($wp_rem_opt_array);
			
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt( 'wp_rem_branches_name' ),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'branch_name',
					'return' => true,
				),
			);
			$wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
			
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt( 'wp_rem_branches_phone' ),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'branch_phone',
					'return' => true,
				),
			);
			$wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
			
			$wp_rem_opt_array = array(
				'name' => wp_rem_plugin_text_srt( 'wp_rem_branches_email' ),
				'desc' => '',
				'hint_text' => '',
				'echo' => true,
				'field_params' => array(
					'std' => '',
					'id' => 'branch_email',
					'return' => true,
				),
			);
			$wp_rem_html_fields->wp_rem_text_field($wp_rem_opt_array);
			
			WP_REM_FUNCTIONS()->wp_rem_location_fields('off', '', 'branch');
		}
	}

	global $wp_rem_branch_meta;
	$wp_rem_branch_meta = new wp_rem_branch_meta();
}